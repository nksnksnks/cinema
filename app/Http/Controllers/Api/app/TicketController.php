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
     *          @OA\Examples(
     *              summary="Examples",
     *              example = "Examples",
     *              value = {
     *                  "amount": "1000000",
     *                  "cinema_id": "1",
     *                  "show_time_id": "7",
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
        $extraData = "";
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

    public function handleMomoPayment(Request $request){
        $responseData = $request->all();
        $partnerCode = $this->partnerCode;
        $accessKey = $this->accessKey;
        $secretKey = $this->secretKey;
        $orderInfo = $this->orderInfo;
        $amount = $responseData["amount"];
        $orderId = $responseData['orderId'];
        $extraData = "";
        $requestId = $responseData['requestId'];
        $signature = $responseData['signature'];
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData .
            "&message=" . $responseData["message"] . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo .
            "&orderType=" . $responseData["orderType"] . "&partnerCode=" . $partnerCode . "&payType=" . $responseData["payType"] . "&requestId=" . $requestId .
            "&responseTime=" . $responseData["responseTime"] . "&resultCode=" . $responseData["resultCode"] . "&transId=" . $responseData["transId"];
        $generatedSignature = hash_hmac("sha256", $rawHash, $secretKey);
        if ($generatedSignature == $signature) {
            if($responseData['resultCode'] == '0') {

                $this->ticketRepository->createBill($orderId, $amount);
                return response()->json([
                    'status' => Constant::SUCCESS_CODE,
                    'message' => trans('messages.success.success'),
                    'data' => [0]
                ], Constant::SUCCESS_CODE);
            }
            else{
                $this->ticketRepository->cancelReservation($orderId);
                return response()->json([
                    'status' => Constant::BAD_REQUEST_CODE,
                    'message' => trans('messages.errors.errors'),
                    'data' => [1]
                ], Constant::SUCCESS_CODE);
            }
        } else {
            $this->ticketRepository->cancelReservation($orderId);
            return response()->json([
                'status' => Constant::BAD_REQUEST_CODE,
                'message' => trans('messages.errors.errors'),
                'data' => [1]
            ], Constant::SUCCESS_CODE);
        }
    }

}
