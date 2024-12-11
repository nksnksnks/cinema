<?php

namespace App\Http\Controllers\Api\app;

use App\Enums\Constant;
use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\CinemaRequest;
use App\Models\Cinema;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\user\Ticket\TicketRepository;
use App\Models\Promotion;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    private $endpoint;
    private $partnerCode;
    private $accessKey;
    private $orderInfo;
    private $requestType;
    private $redirectUrl;
    private $ipnUrl;
    private $secretKey;
    public $ticketRepository;
    public function __construct
    (
        TicketRepository $ticketRepository,
    )
    {
        $this->ticketRepository = $ticketRepository;
        $this->endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $this->partnerCode = 'MOMOBKUN20180529';
        $this->accessKey = 'klm05TvNBzhg7h7j';
        $this->secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $this->orderInfo = "Thanh toán qua MoMo";
        $this->requestType = "captureWallet";
        $this->redirectUrl = "http://localhost:3000/cart";
        $this->ipnUrl = "http://localhost:3000/cart";
    }

    /**
     * @author son.nk
     * @OA\Post (
     *     path="/api/app/ticket/reservation",
     *     tags={"App Đặt vé"},
     *     summary="Giữ chỗ",
     *     operationId="user/ticket/reservation",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="cinema_id", type="string"),
     *              @OA\Property(property="seat_id", type="string"),
     *              @OA\Property(property="show_time_id", type="string"),
     *          @OA\Examples(
     *              summary="Examples",
     *              example = "Examples",
     *              value = {
     *                          "cinema_id" : "1",
     *                          "show_time_id" : "7",
     *                          "seat_ids" : "[5, 6, 7, 8, 9]"
     *                      },
     *              ),
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *             @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Success."),
     *          )
     *     ),
     * )
     */
    public function createReservation(Request $request){
        try {
            $data = $request->all();
            Redis::setex($data['cinema_id'] . '_' . $data['show_time_id'] . '_' . $this->getCurrentLoggedIn()->id , 600, $data['seat_ids']);
            return response()->json([
                'status' => Constant::SUCCESS_CODE,
                'message' => trans('messages.success.success'),
                'data' => []
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => Constant::FALSE_CODE,
                'message' => $th->getMessage(),
                'data' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @author Sonnk
     * @OA\Post (
     *     path="/api/app/ticket/momo-payment",
     *     tags={"App Đặt vé"},
     *     summary="Thanh toán Momo",
     *     security={{"bearerAuth":{}}},
     *     operationId="ticket/momo-payment",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *          in="header",
     *          name="X-localication",
     *          required=false,
     *          description="Ngôn ngữ",
     *          @OA\Schema(
     *            type="string",
     *            example="vi",
     *          )
     *     ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="amount", type="string"),
     *              @OA\Property(property="cinema_id", type="string"),
     *              @OA\Property(property="show_time_id", type="string"),
     *              @OA\Property(property="extraData", type="string"),
     *          @OA\Examples(
     *              summary="Examples",
     *              example = "Examples",
     *              value = {
     *                  "amount": "10000",
     *                  "cinema_id": "1",
     *                  "show_time_id": "7",
     *                  "extraData": "1",
     *                  "food_id": "4",
     *                  "food_quantity": 4,
     *                  },
     *              ),
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *             @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Success."),
     *          )
     *     ),
     * )
     */
    public function momoPayment(Request $request){
//        $this->appointmentTime = $request->appointmentTime;
        $data = $request->all();
        $amount = $data['amount'];
        $endpoint = $this->endpoint;
        $partnerCode = $this->partnerCode;
        $accessKey = $this->accessKey;
        $secretKey = $this->secretKey;
        $orderInfo = $this->orderInfo;
        $key = $data['cinema_id'] . '_' . $data['show_time_id'] . '_' . $this->getCurrentLoggedIn()->id;
        if(!Redis::get($key)){
            return response()->json([
                'status' => Constant::SUCCESS_CODE,
                'message' => trans('messages.errors.ticket.time_out'),
                'data' => []
            ], Constant::SUCCESS_CODE);
        }
        $orderId = $key . '_' . time();
        Redis::expire($orderId, 300);
        $redirectUrl = $this->redirectUrl;
        $ipnUrl = $this->ipnUrl;
        $extraData = $data['extraData'] ?? "";
        $requestId = time() . "";
        $requestType = $this->requestType;
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array('partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature,
//            'appointmentTime' => $this->appointmentTime
        );
        $result = CommonHelper::execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);
        return response()->json([
            'status' => Constant::SUCCESS_CODE,
            'message' => trans('messages.success.success'),
            'data' => $jsonResult
        ], Constant::SUCCESS_CODE);
    }

    public function applyPromotionAfterPayment($id)
    {
        $promotion = Promotion::find($id);

        if (!$promotion || $promotion->status != 1) {
            return;
        }

        // Kiểm tra ngày áp dụng khuyến mãi
        if ($promotion->end_date < now() || $promotion->start_date > now()) {
            return;
        }

        // Kiểm tra số lượng khuyến mãi còn lại
        if ($promotion->quantity <= 0) {
            return;
        }

        $userId = Auth::id();

        // Kiểm tra người dùng đã sử dụng mã khuyến mãi này chưa
        if ($promotion->users()->where('account_id', $userId)->exists()) {
            return;
        }

        // Ghi nhận người dùng đã sử dụng mã và giảm số lượng còn lại
        $promotion->users()->attach($userId);
        $promotion->decrement('quantity');
    }


    // public function handleMomoPayment(Request $request){
    //     $responseData = $request->all();
    //     $partnerCode = $this->partnerCode;
    //     $accessKey = $this->accessKey;
    //     $secretKey = $this->secretKey;
    //     $orderInfo = $this->orderInfo;
    //     $amount = $responseData["amount"];
    //     $orderId = $responseData['orderId'];
    //     $extraData =  ""; // Chứa ID của mã giảm giá (nếu có)
    //     $requestId = $responseData['requestId'];
    //     $signature = $responseData['signature'];
    //     $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData .
    //         "&message=" . $responseData["message"] . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo .
    //         "&orderType=" . $responseData["orderType"] . "&partnerCode=" . $partnerCode . "&payType=" . $responseData["payType"] . "&requestId=" . $requestId .
    //         "&responseTime=" . $responseData["responseTime"] . "&resultCode=" . $responseData["resultCode"] . "&transId=" . $responseData["transId"];
    //     $generatedSignature = hash_hmac("sha256", $rawHash, $secretKey);
    //     if ($generatedSignature == $signature) {
    //         if($responseData['resultCode'] == '0') {

    //             $this->ticketRepository->createBill($orderId, $amount);
    //             return response()->json([
    //                 'status' => Constant::SUCCESS_CODE,
    //                 'message' => trans('messages.success.success'),
    //                 'data' => [0]
    //             ], Constant::SUCCESS_CODE);
    //         }
    //         else{
    //             $this->ticketRepository->cancelReservation($orderId);
    //             return response()->json([
    //                 'status' => Constant::BAD_REQUEST_CODE,
    //                 'message' => trans('messages.errors.errors'),
    //                 'data' => [1]
    //             ], Constant::SUCCESS_CODE);
    //         }
    //     } else {
    //         $this->ticketRepository->cancelReservation($orderId);
    //         return response()->json([
    //             'status' => Constant::BAD_REQUEST_CODE,
    //             'message' => trans('messages.errors.errors'),
    //             'data' => [1]
    //         ], Constant::SUCCESS_CODE);
    //     }
    // }


    public function handleMomoPayment(Request $request)
{
    $responseData = $request->all();
    $partnerCode = $this->partnerCode;
    $accessKey = $this->accessKey;
    $secretKey = $this->secretKey;
    $orderInfo = $this->orderInfo;
    $amount = $responseData["amount"];
    $orderId = $responseData['orderId'];
    $extraData = $responseData['extraData'] ?? ""; // Chứa ID của mã giảm giá (nếu có)
    $requestId = $responseData['requestId'];
    $signature = $responseData['signature'];
    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData .
        "&message=" . $responseData["message"] . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo .
        "&orderType=" . $responseData["orderType"] . "&partnerCode=" . $partnerCode . "&payType=" . $responseData["payType"] . "&requestId=" . $requestId .
        "&responseTime=" . $responseData["responseTime"] . "&resultCode=" . $responseData["resultCode"] . "&transId=" . $responseData["transId"];
    $generatedSignature = hash_hmac("sha256", $rawHash, $secretKey);

    if ($generatedSignature == $signature) {
        if ($responseData['resultCode'] == '0') {
            // Thanh toán thành công
            $this->ticketRepository->createBill($orderId, $amount);

            // Kiểm tra và áp dụng mã giảm giá
            if (!empty($extraData)) {
                $promotionId = intval($extraData);
                $this->applyPromotionAfterPayment($promotionId);
            }

            return response()->json([
                'status' => Constant::SUCCESS_CODE,
                'message' => trans('messages.success.success'),
                'data' => [0]
            ], Constant::SUCCESS_CODE);
        } else {
            // Hủy vé khi thanh toán thất bại
            $this->ticketRepository->cancelReservation($orderId);
            return response()->json([
                'status' => Constant::BAD_REQUEST_CODE,
                'message' => trans('messages.errors.errors'),
                'data' => [1]
            ], Constant::SUCCESS_CODE);
        }
    } else {
        // Hủy vé khi xác thực không thành công
        $this->ticketRepository->cancelReservation($orderId);
        return response()->json([
            'status' => Constant::BAD_REQUEST_CODE,
            'message' => trans('messages.errors.errors'),
            'data' => [1]
        ], Constant::SUCCESS_CODE);
    }
}

    /**
     * @OA\Get (
     *     path="/api/app/ticket/get/{type}",
     *     tags={"App Đặt vé"},
     *     summary="Vé đã đặt",
     *     operationId="app/ticket/get",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *          name="type",
     *          in="path",
     *          description="type (0: lấy vé đã chiếu, 1: lấy phim chưa chiếu)",
     *          required=true,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Success."),
     *         )
     *     ),
     * )
     */
    public function getTicket($type){
        try {
            $memberId = $this->getCurrentLoggedIn()->id;
            if($memberId){
                $data = $this->ticketRepository->getBill($memberId, $type);
                return response()->json([
                    'status' => Constant::SUCCESS_CODE,
                    'message' => trans('messages.success.success'),
                    'data' => $data
                ], Constant::SUCCESS_CODE);
            }else{
                return response()->json([
                    'status' => Constant::SUCCESS_CODE,
                    'message' => trans('messages.success.required_login'),
                    'data' => []
                ], Constant::SUCCESS_CODE);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => Constant::FALSE_CODE,
                'message' => $th->getMessage(),
                'data' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get (
     *     path="/api/app/ticket/detail/{id}",
     *     tags={"App Đặt vé"},
     *     summary="Chi tiết vé",
     *     operationId="app/ticket/detail",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="id bill cần xem chi tiết",
     *          required=true,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Success."),
     *         )
     *     ),
     * )
     */
    public function detailTicket($id){
        try {
            $memberId = $this->getCurrentLoggedIn()->id;
            if($memberId){
                $data = $this->ticketRepository->getBillDetail($id);
                return response()->json([
                    'status' => Constant::SUCCESS_CODE,
                    'message' => trans('messages.success.success'),
                    'data' => $data
                ], Constant::SUCCESS_CODE);
            }else{
                return response()->json([
                    'status' => Constant::SUCCESS_CODE,
                    'message' => trans('messages.success.required_login'),
                    'data' => []
                ], Constant::SUCCESS_CODE);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => Constant::FALSE_CODE,
                'message' => $th->getMessage(),
                'data' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
