<?php

namespace app\Http\Controllers\Api\app;

use App\Enums\Constant;
use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\CinemaRequest;
use App\Models\Account;
use App\Models\Cinema;
use App\Models\Ticket;
use App\Models\Bill;
use App\Models\Movie;
use App\Models\Room;
use App\Models\Seat;
use App\Models\Profile;
use App\Jobs\CreateBillJob;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\user\Ticket\TicketRepository;
use App\Models\Promotion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

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
        // $this->redirectUrl = "http://192.168.0.104:8000/api/app/ticket/handle-momo-payment";
        // $this->ipnUrl = "http://192.168.0.104:8000/api/app/ticket/handle-momo-payment";
        $this->redirectUrl = "http://127.0.0.1:8000/api/app/ticket/handle-momo-payment";
        $this->ipnUrl = "http://127.0.0.1:8000/api/app/ticket/handle-momo-payment";
    }
    

//    /**
//     * @author son.nk
//     * @OA\Post (
//     *     path="/api/app/ticket/reservation",
//     *     tags={"App Đặt vé"},
//     *     summary="Giữ chỗ",
//     *     operationId="user/ticket/reservation",
//     *     security={{"bearerAuth":{}}},
//     *     @OA\RequestBody(
//     *          @OA\JsonContent(
//     *              type="object",
//     *              @OA\Property(property="cinema_id", type="string"),
//     *              @OA\Property(property="seat_id", type="string"),
//     *              @OA\Property(property="show_time_id", type="string"),
//     *          @OA\Examples(
//     *              summary="Examples",
//     *              example = "Examples",
//     *              value = {
//     *                          "cinema_id" : "1",
//     *                          "show_time_id" : "7",
//     *                          "seat_ids" : "[5, 6, 7, 8, 9]"
//     *                      },
//     *              ),
//     *          )
//     *     ),
//     *     @OA\Response(
//     *         response=200,
//     *         description="Success",
//     *             @OA\JsonContent(
//     *             @OA\Property(property="message", type="string", example="Success."),
//     *          )
//     *     ),
//     * )
//     */
//    public function createReservation(Request $request){
//        try {
//            $data = $request->all();
//            Redis::setex($data['cinema_id'] . '_' . $data['show_time_id'] . '_' . $this->getCurrentLoggedIn()->id , 600, $data['seat_ids']);
//            return response()->json([
//                'status' => Constant::SUCCESS_CODE,
//                'message' => trans('messages.success.success'),
//                'data' => []
//            ]);
//        } catch (\Throwable $th) {
//            return response()->json([
//                'status' => Constant::FALSE_CODE,
//                'message' => $th->getMessage(),
//                'data' => []
//            ], Response::HTTP_INTERNAL_SERVER_ERROR);
//        }
//    }
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
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="amount", type="integer", example="10000"),
     *              @OA\Property(property="cinema_id", type="integer", example="1"),
     *              @OA\Property(property="show_time_id", type="integer", example="17"),
     *              @OA\Property(property="extraData", type="string", example="1"),
     *              @OA\Property(
     *                  property="seat_ids",
     *                  type="array",
     *                  @OA\Items(
     *                      type="integer",
     *                      example="90"
     *                  )
     *              ),
     *              @OA\Property(
     *                  property="food",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="food_id", type="integer", example="1"),
     *                      @OA\Property(property="food_quantity", type="integer", example=4)
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *             @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example=200),
     *              @OA\Property(property="message", type="string", example="Success."),
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="partnerCode", type="string", example="MOMODJടതി"),
     *                  @OA\Property(property="orderId", type="string", example="1_7_15_1701539372"),
     *                  @OA\Property(property="requestId", type="string", example="1701539372"),
     *                  @OA\Property(property="amount", type="number", example=10000),
     *                  @OA\Property(property="responseTime", type="integer", example=1701539373156),
     *                  @OA\Property(property="message", type="string", example="Thành công."),
     *                  @OA\Property(property="resultCode", type="integer", example=0),
     *                  @OA\Property(property="payUrl", type="string", example="https://test-payment.momo.vn/v2/gateway/api/create?eyJhbGciOiJSUzI1NiIsImtpZCI6IjIwMTgxMDA1MTUzNjMzIn0..R8rg5W-4GoeJwt7Agn7nJKJ-m-UP_m7sV-q4k-a_k_Jz4w_9lMv-EIy0E-P0gqh4WzE5w8-yBs6I3fGT77vj3_y-hB9g-q6_0-G-Zq5V99-h-lXl8XwM6kS4V3Y_Nerep-yBf7G5-qjC6Gvj-W240g"),
     *                  @OA\Property(property="deeplink", type="string", example="momo://app?param=H4sIAAAAAAAAA2WQwQ7CIBBE_2XeUdt7D9t4C24q_LgJ7sN7n8Q41R-k3k60T09374H_4eY8zE29bYjL6a1vjH22_Ue8l_vY"),
     *                  @OA\Property(property="qrCodeUrl", type="string", example="https://img.mservice.io/momo_qrcode/"),
     *                  @OA\Property(property="deeplinkMiniApp", type="string", example=null),
     *                  @OA\Property(property="signature", type="string", example="322b7412df3205802740d56308298c80267237782c6911d4"),
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     * )
     */
    public function momoPayment(Request $request){
//        $this->appointmentTime = $request->appointmentTime;
        $data = $request->all();
        $amount = $data['amount'];
        $show_time_id = $data['show_time_id'];
        $seat_ids = $data['seat_ids'];

        // Kiểm tra xem ghế đã được đặt hay chưa
        $bookedSeats = Ticket::where('movie_showtime_id', $show_time_id)
            ->whereIn('seat_id', $seat_ids)
            ->get();

        if ($bookedSeats->isNotEmpty()) {
            return response()->json([
                'status' => -1, // Hoặc mã lỗi tùy bạn quy định
                'message' => 'Rất tiếc, đã có người vừa đặt ghế của bạn mất rồi. Vui lòng chọn ghế khác',
                'data' => []
            ], 200);
        }
        $endpoint = $this->endpoint;
        $partnerCode = $this->partnerCode;
        $accessKey = $this->accessKey;
        $secretKey = $this->secretKey;
        $orderInfo = $this->orderInfo;
        $key = $data['cinema_id'] . '_' . $data['show_time_id'] . '_' . $this->getCurrentLoggedIn()->id;
        $orderId = $key . '_' . time();
        Redis::setex('reservation_' . $this->getCurrentLoggedIn()->id, 600, json_encode($data));

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
        $save = Redis::setex('info_payment_' . $this->getCurrentLoggedIn()->id, 600 , json_encode($jsonResult));
        return response()->json([
            'status' => Constant::SUCCESS_CODE,
            'message' => trans('messages.success.success'),
            'data' => $jsonResult
        ], Constant::SUCCESS_CODE);
    }

    /**
     * @author son.nk
     * @OA\Get (
     *     path="/api/app/ticket/delete-reservation",
     *     tags={"App Đặt vé"},
     *     summary="Hủy đặt chỗ",
     *     operationId="app/ticket/delete-reservation",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Success.")
     *         )
     *     ),
     * )
     */

    public function deleteReservation()
    {
        try {
            $userId = $this->getCurrentLoggedIn()->id;

            $data = $this->ticketRepository->cancelRevi($userId);

            return response()->json([
                'status' => Constant::SUCCESS_CODE,
                'message' => trans('messages.success.success'),
                'data' => $data
            ], Constant::SUCCESS_CODE);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => Constant::FALSE_CODE,
                'message' => $th->getMessage(),
                'data' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


     public function handleMomoPayment(Request $request){
         $responseData = $request->all();
         $partnerCode = $this->partnerCode;
         $accessKey = $this->accessKey;
         $secretKey = $this->secretKey;
         $orderInfo = $this->orderInfo;
         $amount = $responseData["amount"];
         $orderId = $responseData['orderId'];
         $extraData =  "";
         $requestId = $responseData['requestId'];
         $signature = $responseData['signature'];
         $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData .
             "&message=" . $responseData["message"] . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo .
             "&orderType=" . $responseData["orderType"] . "&partnerCode=" . $partnerCode . "&payType=" . $responseData["payType"] . "&requestId=" . $requestId .
             "&responseTime=" . $responseData["responseTime"] . "&resultCode=" . $responseData["resultCode"] . "&transId=" . $responseData["transId"];
         $generatedSignature = hash_hmac("sha256", $rawHash, $secretKey);
         if ($generatedSignature == $signature) {
             if($responseData['resultCode'] == '0') {
                 $parts = explode('_', $orderId);
                 $userId = $parts[2];
                 $data = $this->ticketRepository->createBill($userId);
                // CreateBillJob::dispatch($userId)->onConnection('immediate');
                 return redirect()->away('movie://movieease.com');
             }
             else{
                 $data = $this->ticketRepository->cancelReservation($orderId);
                 return response()->json([
                     'status' => Constant::BAD_REQUEST_CODE,
                     'message' => trans('messages.errors.errors'),
                     'data' => [1]
                 ], Constant::SUCCESS_CODE);
             }
         } else {
             $data = $this->ticketRepository->cancelReservation($orderId);
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

    /**
     * @author son.nk
     * @OA\Get (
     *     path="/api/app/ticket/get-info-payment",
     *     tags={"App Đặt vé"},
     *     summary="Lấy thông tin thanh toán",
     *     operationId="app/ticket/get-info-payment",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Success.")
     *         )
     *     ),
     * )
     */

    public function getInfoPayment()
    {
        try {
            $userId = $this->getCurrentLoggedIn()->id;

            $data = $this->ticketRepository->getInfoPayment($userId);

            return response()->json([
                'status' => Constant::SUCCESS_CODE,
                'message' => trans('messages.success.success'),
                'data' => $data
            ], Constant::SUCCESS_CODE);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => Constant::FALSE_CODE,
                'message' => $th->getMessage(),
                'data' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

     /**
     * @OA\Get(
     *     path="/api/app/get-ticket",
     *     tags={"Staff Check"},
     *     summary="Get bill detail by ticket_code",
     *     description="Retrieve detailed information about a bill using its ticket_code.",
     *     operationId="getBillDetail",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="ticket_code",
     *         in="query",
     *         description="The unique code of the bill.",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="HD123456"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Bill detail retrieved successfully.",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Lấy thông tin hóa đơn thành công."),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="ticket_code", type="string", example="HD123456"),
     *                 @OA\Property(property="email", type="string", example="customer@example.com"),
     *                 @OA\Property(property="movie", type="string", example="Movie Name"),
     *                 @OA\Property(property="start_time", type="string", format="time", example="08:00"),
     *                 @OA\Property(property="end_time", type="string", format="time", example="10:00"),
     *                 @OA\Property(property="start_date", type="string", format="date", example="2024-12-10"),
     *                 @OA\Property(property="room", type="string", example="Room 01"),
     *                 @OA\Property(property="cinema", type="string", example="Cinema Name"),
     *                 @OA\Property(property="seats", type="array", @OA\Items(type="string"), example={"A1", "A2"}),
     *                 @OA\Property(property="status", type="integer", example=0),
     *                 @OA\Property(property="staff_check", type="integer", nullable=true, example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Bill not found.",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Hóa đơn không tồn tại."),
     *             @OA\Property(property="data", type="array", @OA\Items())
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="ticket_code",
     *                     type="array",
     *                     @OA\Items(type="string", example="Ticket_code là bắt buộc.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getBillDetail(Request $request)
    {
        $request->validate([
            'ticket_code' => 'required'
        ]);

        $validator = Validator::make($request->all(), [
            'ticket_code' => 'required'
        ],[
            'ticket_code.required' => 'Ticket_code là bắt buộc.',

        ]);

        if ($validator->fails()) {
            $errors = (new ValidationException($validator))->errors();
            throw new HttpResponseException(response()->json([
                'status' => -1,
                'message' => $errors,
                'data' => []
            ], Constant::SUCCESS_CODE)); // Giả sử SUCCESS_CODE = 200
        }

        // Lấy thông tin nhân viên đang đăng nhập
        $staff = Auth::user();
        if($staff->role_id == 4){
            return response()->json([
                'status' => Constant::FALSE_CODE,
                'message' => 'Bạn không có quyền check vé',
                'data' => []
            ], 200);
        }

        $bill = Bill::with([
            'movieShowTime:id,start_time,end_time,start_date,room_id,movie_id',
            'account:id,email',
            'account.profile:account_id,name,phone_number', 
            'cinema:id,name',
            'foodBillJoin'
        ])
        ->where('ticket_code', $request->ticket_code)->first();

        if (!$bill) {
            return response()->json([
                'status' => Constant::FALSE_CODE,
                'message' => 'Hóa đơn không tồn tại.',
                'data' => []
            ], 200);
        }

        if($bill->status==1 && $bill->staff_check!=0 ){
            $name_nv = Profile::where('account_id',$bill->staff_check)->first()->name;
            $message = 'Vé đã được duyệt bởi nhân viên '.$name_nv;
        }else{
            $message = 'Vé chưa được duyệt';
        }
        return response()->json([
            'status' => Constant::SUCCESS_CODE,
            'message' => $message,
            'data' => [
                'ticket_code' => $bill->ticket_code,
                'email' => $bill->account->email,
                'name' => $bill->account->profile->name,
                'phone_number' => $bill->account->profile->phone_number,
                'movie' => Movie::find($bill->movieShowTime->movie_id)->name,
                'start_time' => $bill->movieShowTime->start_time,
                'end_time' => $bill->movieShowTime->end_time,
                'start_date' => $bill->movieShowTime->start_date,
                'room' => Room::find($bill->movieShowTime->room_id)->name,
                'cinema' => $bill->cinema->name,
                'foods' => $bill->foodBillJoin->map(function ($food) {
                        return [
                            'name' => $food->name,            // Tên món ăn từ bảng food
                            'quantity' => $food->pivot->quantity, // Số lượng từ bảng trung gian
                            'price' => $food->pivot->total,  // Giá từ bảng trung gian
                        ];
                    }),
                'seats' => Seat::whereIn('id', function ($query) use ($bill) {
                    $query->select('seat_id')
                          ->from('ci_ticket')
                          ->where('bill_id', $bill->id);
                })->pluck('seat_code')->toArray(),
                'status' => $bill->status,
                'staff_check' => $bill->staff_check == 0 ? null : $name_nv,

            ]
        ], Response::HTTP_OK);
    }


    /**
     * @OA\Post(
     *     path="/api/app/check-bill",
     *     tags={"Staff Check"},
     *     summary="Check and approve a bill",
     *     description="Check and approve a bill by ticket_code for a customer.",
     *     operationId="checkBill",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="ticket_code",
     *         in="query",
     *         description="The unique code of the bill to be checked.",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="HD123456"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Bill checked successfully.",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Duyệt hóa đơn thành công."),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="ticket_code", type="string", example="HD123456"),
     *                 @OA\Property(property="status", type="integer", example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Bill not found.",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Hóa đơn không tồn tại."),
     *             @OA\Property(property="data", type="array", @OA\Items())
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="ticket_code",
     *                     type="array",
     *                     @OA\Items(type="string", example="Ticket_code là bắt buộc.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bill already checked or invalid.",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Hóa đơn đã được duyệt hoặc không hợp lệ."),
     *             @OA\Property(property="data", type="array", @OA\Items())
     *         )
     *     )
     * )
     */
    public function checkBill(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_code' => 'required'
        ], [
            'ticket_code.required' => 'Ticket_code là bắt buộc.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => Constant::FALSE_CODE,
                'message' => $validator->errors()
            ], 200);
        }

        // Lấy thông tin nhân viên đang đăng nhập
        $staff = Auth::user();
        if($staff->role_id == 4){
            return response()->json([
                'status' => Constant::FALSE_CODE,
                'message' => 'Bạn không có quyền duyệt vé',
                'data' => []
            ], 200);
        }

        $bill = Bill::where('ticket_code', $request->ticket_code)->first();

        if (!$bill) {
            return response()->json([
                'status' => Constant::FALSE_CODE,
                'message' => 'Hóa đơn không tồn tại.',
                'data' => []
            ], 200);
        }

        if ($bill->status == 1 || $bill->staff_check != 0) {
            return response()->json([
                'status' => Constant::FALSE_CODE,
                'message' => 'Hóa đơn đã được duyệt hoặc không hợp lệ.',
                'data' => []
            ], 200);
        }

        
        // Cập nhật trạng thái và id nhân viên duyệt
        $bill->status = 1;
        $bill->staff_check = $staff->id;
        $bill->save();

        return response()->json([
            'status' => Constant::SUCCESS_CODE,
            'message' => 'Duyệt hóa đơn thành công.',
            'data' => [
                'ticket_code' => $bill->ticket_code,
                'status' => $bill->status,
                'staff_check' => $bill->staff_check
            ]
        ], 200);
    }

    /**
     * @author Sonnk
     * @OA\Post (
     *     path="/api/app/ticket/cash-payment",
     *     tags={"App Đặt vé"},
     *     summary="Thanh toán tiền mặt",
     *     security={{"bearerAuth":{}}},
     *     operationId="ticket/cash-payment",
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
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="amount", type="integer", example="10000"),
     *              @OA\Property(property="cinema_id", type="integer", example="1"),
     *              @OA\Property(property="show_time_id", type="integer", example="17"),
     *              @OA\Property(property="extraData", type="string", example="1"),
     *              @OA\Property(
     *                  property="seat_ids",
     *                  type="array",
     *                  @OA\Items(
     *                      type="integer",
     *                      example="90"
     *                  )
     *              ),
     *              @OA\Property(
     *                  property="food",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="food_id", type="integer", example="1"),
     *                      @OA\Property(property="food_quantity", type="integer", example=4)
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *             @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example=200),
     *              @OA\Property(property="message", type="string", example="Success."),
     *              @OA\Property(property="data", type="object",
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     * )
     */
    public function cashPayment(Request $request){
        $data = $request->all();
        $show_time_id = $data['show_time_id'];
        $seat_ids = $data['seat_ids'];

        // Kiểm tra xem ghế đã được đặt hay chưa
        $bookedSeats = Ticket::where('movie_showtime_id', $show_time_id)
            ->whereIn('seat_id', $seat_ids)
            ->get();

        if ($bookedSeats->isNotEmpty()) {
            return response()->json([
                'status' => -1, // Hoặc mã lỗi tùy bạn quy định
                'message' => 'Rất tiếc, đã có người vừa đặt ghế của bạn mất rồi. Vui lòng chọn ghế khác',
                'data' => []
            ], 200);
        }

        // Lưu thông tin đặt vé vào Redis (tương tự như momoPayment)
        $key = $data['cinema_id'] . '_' . $data['show_time_id'] . '_' . $this->getCurrentLoggedIn()->id;
        $orderId = $key . '_' . time();
        Redis::setex('reservation_' . $this->getCurrentLoggedIn()->id, 600, json_encode($data));

        // Tạo bill ngay lập tức sau khi nhân viên xác nhận
        $userId = $this->getCurrentLoggedIn()->id;
        $dataBill = $this->ticketRepository->createBill($userId);

        if($dataBill['status'] == 200){
            return response()->json([
                'status' => Constant::SUCCESS_CODE,
                'message' => trans('messages.success.success'),
                'data' => []
            ], Constant::SUCCESS_CODE);
        }
        else{
             return response()->json([
                'status' => -1,
                'message' => trans('messages.errors.errors'),
                'data' => []
             ], 200);
        }
    }

}
