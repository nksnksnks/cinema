<?php

namespace App\Repositories\user\Ticket;

use App\Models\Bill;
use App\Models\Cinema;
use App\Models\Food;
use App\Models\FoodBillJoin;
use App\Models\Movie;
use App\Models\Promotion;
use App\Models\Seat;
use App\Models\Account;
use App\Models\Ticket;
use App\Models\MovieShowtime    ;
use App\Repositories\user\WeeklyTicketPrices\WeeklyTicketPricesRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketConfirmationMail;
use Illuminate\Support\Facades\Auth;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Cloudinary\Cloudinary;

class TicketRepository{

    function model(){
        return Ticket::class;
    }

    public function createBill($userId)
    {
        $data = Redis::get('reservation_' . $userId);
        $data = json_decode($data);
        $extraId = $data->extraData;
        $promotion = Promotion::where('id', $extraId)
            ->where('status', 1)
            ->where('start_date', '<=', now()->toDateString())
            ->where('end_date', '>=', now()->toDateString())
            ->where('quantity', '>', 0)
            ->first();
        if ($promotion && !$promotion->users()->where('account_id', $userId)->exists()) {
            $promotion->users()->attach($userId);
            $promotion->decrement('quantity');
            $extraId = $promotion->id;
        }else{
            $extraId = null;
        }
        $account = Account::find($userId);
        if ($data->seat_ids) {
            $randomNumber = mt_rand(10000, 99999);  // Tạo 5 số ngẫu nhiên
            $currentTime = Carbon::now()->timestamp;  // Lấy ngày tháng năm + giờ phút giây (YmdHis)
            $ticketCode = $randomNumber . $currentTime;  // Kết hợp cả hai phần
            if($account->role_id != 4){
                $billId = Bill::create([
                    'extra_id' => $extraId,
                    'ticket_code' => $ticketCode,
                    'account_id' => (int)$userId,
                    'cinema_id' => $data->cinema_id,
                    'movie_show_time_id' => $data->show_time_id,
                    'total' => $data->amount,
                    'staff_check' => $account->id,
                    'status' => '1'
                ])->id;
            }else{
                // Tạo Bill
                $billId = Bill::create([
                    'extra_id' => $extraId,
                    'ticket_code' => $ticketCode,
                    'account_id' => (int)$userId,
                    'cinema_id' => $data->cinema_id,
                    'movie_show_time_id' => $data->show_time_id,
                    'total' => $data->amount,
                    'status' => '0'
                ])->id;
            }
            if ($billId && !empty($data->food)) {
                foreach ($data->food as $f) {
                    $food = Food::find($f->food_id); // Lấy đúng món ăn theo food_id
                    if ($food) { // Kiểm tra nếu món ăn tồn tại
                        FoodBillJoin::create([
                            'bill_id' => $billId,
                            'food_id' => $f->food_id,
                            'quantity' => $f->food_quantity,
                            'total' => $f->food_quantity * $food->price // Lấy đúng giá của món ăn
                        ]);
                    }
                }
            }
            

            // $user = Auth::user()->id;

            if ($account) {
                $account->update(['cinema_id' => $data->cinema_id]);
            }
            $seatIds = $data->seat_ids;
            $seatCodes = [];

            foreach ($seatIds as $seatId) {
                $showTime = MovieShowtime::find($data->show_time_id)->first();
                $ticketPrice = WeeklyTicketPricesRepository::getTicketPrice($showTime->start_date, $showTime->start_time);
                $seats = Seat::with('seatType')
                    ->where('id', $seatId)
                    ->first();
                $price = (int)$ticketPrice + $seats->seatType->extra_fee;
                Ticket::create([
                    'seat_id' => $seatId,
                    'bill_id' => $billId,
                    'movie_showtime_id' => (int)$data->show_time_id,
                    'price' => $price
                ]);

                $seat = Seat::find($seatId);
                if ($seat) {
                    $seatCodes[] = $seat->seat_code; // Thêm mã ghế vào danh sách
                }
            }
            $bill = Bill::find($billId);
            $cinema_name = $bill->cinema->name;
            $total_bill = $bill->total;
            $movieShowtime = MovieShowtime::find($data->show_time_id);
            $movie_name = $movieShowtime->movie->name;
            $room = $movieShowtime->room->name;
            $start_time = $movieShowtime->start_time;
            $seatListString = implode(', ', $seatCodes);
            // Tạo mã QR
                $qrCode = Builder::create()
                ->writer(new PngWriter()) // Định dạng PNG
                ->data($ticketCode) // Dữ liệu QR (VD: mã vé)
                ->size(200) // Kích thước mã QR
                ->margin(10) // Khoảng cách xung quanh mã QR
                ->build();

                // $qrCode->saveToFile(storage_path('app/public/qrcode.png'));

                // $qrCodeBase64 = base64_encode(file_get_contents(storage_path('app/public/qrcode.png')));
                // $qrCodeBase64 = base64_encode($qrCode->getString());
                // Tạo file tạm thời
                $tempFilePath = tempnam(sys_get_temp_dir(), 'qr_'); // Tạo tên file tạm thời trong thư mục tạm của hệ thống
                $qrCode->saveToFile($tempFilePath);

                // Upload lên Cloudinary từ file tạm thời
                $qrCodeResult = cloudinary()->upload($tempFilePath, [
                    'folder' => 'qr-code',
                    'upload_preset' => 'upload-qrcode',
                ]);
                $qrCodeUrl = $qrCodeResult->getSecurePath();

                // Xóa file tạm thời
                unlink($tempFilePath);
            
            $user = Account::find($userId);
            if ($user && $user->email && $seatListString) {
                Mail::to($user->email)->send(new TicketConfirmationMail($user->username, $ticketCode, $seatListString, $cinema_name, $movie_name, $room, $start_time, $total_bill,$qrCodeUrl));
            }

            // Thay vì return $billId;
        return [
            'status' => 200,
            'message' => trans('messages.success.create_bill'), // Thêm thông báo thành công vào file language
            'data' => [
                'bill_id' => $billId,
                // Thêm các thông tin khác nếu cần, ví dụ:
                'ticket_code' => $ticketCode,
                'total' => $total_bill
            ]
        ];
        }

        self::cancelReservation($userId);
        return [
            'status' => -1,
            'message' => trans('messages.errors.create_bill_failed'), // Thêm thông báo lỗi vào file language
            'data' => [] // Có thể thêm thông tin lỗi chi tiết hơn nếu cần
        ];
    }

    public function getSeatSold($showTimeId)
    {
        $data = Ticket::where('movie_showtime_id', $showTimeId)
            ->get();
        return $data;
    }

    public static function cancelReservation($userId)
    {
        $data = Redis::del('reservation_' . $userId);
        return $data;
    }

    public function cancelRevi($userId)
    {
        $data = Redis::del('reservation_' . $userId);
        return $data;
    }

    public function getBill($memberId, $type){
        $bill = Bill::select('ci_bill.*', 'ci_cinema.name as cinema_name', 'ci_cinema.address as cinema_address')
            ->join('ci_cinema', 'ci_bill.cinema_id', '=', 'ci_cinema.id')
            ->where('ci_bill.account_id', $memberId)->where('ci_bill.updated_at', '>' , Carbon::now()->subMonths(12))->orderBy('ci_bill.created_at', 'DESC')->get();
        $response = [];
        foreach ($bill as $key){
            $ticket = Ticket::select(
                'ci_ticket.price',
                'ci_seat.seat_code',
                'ci_seat_type.name',
                'ci_movie_show_time.start_time',
                'ci_movie_show_time.end_time',
                'ci_movie.name as movie_name',
                'ci_movie.id as movie_id',
                'ci_movie.avatar as avatar',
                'ci_room.name as room',
                'ci_movie_show_time.start_date'
            )
                ->join('ci_seat', 'ci_ticket.seat_id', '=', 'ci_seat.id')
                ->join('ci_seat_type', 'ci_seat_type.id', '=', 'ci_seat.seat_type_id')
                ->join('ci_movie_show_time', 'ci_movie_show_time.id', '=', 'ci_ticket.movie_showtime_id')
                ->join('ci_movie', 'ci_movie_show_time.movie_id', '=', 'ci_movie.id')
                ->join('ci_room', 'ci_room.id', '=', 'ci_movie_show_time.room_id')
                ->where('ci_ticket.bill_id', '=', $key->id);
            if($type == 1){
                $ticket = $ticket->where(function ($query) {
                    $query->where('ci_movie_show_time.start_date', '>', Carbon::now()->toDateString())
                        ->orWhere(function ($query) {
                            $query->where('ci_movie_show_time.start_date', '=', Carbon::now()->toDateString())
                                ->where('ci_movie_show_time.start_time', '>', Carbon::now()->format('H:i'));
                        });
                });
            }else{
                $ticket = $ticket->where(function ($query) {
                    $query->where('ci_movie_show_time.start_date', '<', Carbon::now()->toDateString())
                        ->orWhere(function ($query) {
                            $query->where('ci_movie_show_time.start_date', '=', Carbon::now()->toDateString())
                                ->where('ci_movie_show_time.end_time', '<', Carbon::now()->format('H:i'));
                        });
                });
            }
            $total = $ticket->count();
            $ticket = $ticket->get();
            if($total > 0){
                $movie = Movie::find($ticket[0]['movie_id']);
                $data['bill_id'] = $key->id;
                $data['cinema_name'] = $key->cinema_name;
                $data['cinema_address'] = $key->cinema_address;
                $data['movie_avatar'] = $ticket[0]['avatar'];
                $data['movie_name'] = $ticket[0]['movie_name'];
                $data['movie_genre'] = $movie->movie_genre;
                $data['movie_duration'] = $movie->duration;
                $data['movie_rated'] = $movie->rated->name;
                $data['show_start_date'] = $ticket[0]['start_date'];
                $data['show_start_time'] = $ticket[0]['start_time'];
                $data['show_room'] = $ticket[0]['room'];
                $data['show_ticket_total'] = $total;
                $data['show_seat'] = '';
                foreach ($ticket as $k){
                    $data['show_seat'] = $data['show_seat'] . $k->seat_code . ', ';
                }
                $data['show_seat'] = rtrim($data['show_seat'], ', ');
                $data['total_price'] = $key->total;
                $response[] = $data;
            }
        }
        return $response;
    }

    public function getBillDetail($billId){
        $bill = Bill::select('ci_bill.*', 'ci_cinema.name as cinema_name', 'ci_cinema.address as cinema_address')
            ->join('ci_cinema', 'ci_bill.cinema_id', '=', 'ci_cinema.id')
            ->where('ci_bill.id', $billId)->orderBy('ci_bill.created_at', 'DESC')->first();
        $response['bill'] = $bill;
        $ticket = Ticket::select(
            'ci_ticket.price',
            'ci_seat.seat_code',
            'ci_seat_type.name',
            'ci_movie_show_time.start_time',
            'ci_movie_show_time.end_time',
            'ci_movie.name as movie_name',
            'ci_movie.id as movie_id',
            'ci_movie.avatar as avatar',
            'ci_room.name as room',
            'ci_movie_show_time.start_date'
        )
            ->join('ci_seat', 'ci_ticket.seat_id', '=', 'ci_seat.id')
            ->join('ci_seat_type', 'ci_seat_type.id', '=', 'ci_seat.seat_type_id')
            ->join('ci_movie_show_time', 'ci_movie_show_time.id', '=', 'ci_ticket.movie_showtime_id')
            ->join('ci_movie', 'ci_movie_show_time.movie_id', '=', 'ci_movie.id')
            ->join('ci_room', 'ci_room.id', '=', 'ci_movie_show_time.room_id')
            ->where('ci_ticket.bill_id', '=', $billId);
        $total = $ticket->count();
        $ticket = $ticket->get();
        $response['movie'] = Movie::with('movie_genre','rated')->find($ticket[0]['movie_id']);
        $response['ticket'] = $ticket;
        if (isset($bill['extra_id'])) {
            $promotion = Promotion::find($bill['extra_id']); // Bỏ ->first()
            $response['voucher'] = $promotion;
        } else {
            $response['voucher'] = null;
        }
        $response['foods'] = Food::select('ci_foods.*', 'fbj.quantity', 'fbj.total')
            ->join('ci_food_bill_join as fbj', 'fbj.food_id', '=', 'ci_foods.id')
            ->where('fbj.bill_id', '=', $billId)->get();
        return $response;
    }

    public function getInfoPayment($userId)
    {
        $dataPayment = Redis::get('info_payment_' . $userId);
        if(!$dataPayment){
            return [];
        }
        $dataPayment = json_decode($dataPayment);
        $orderId = $dataPayment->orderId;
        $data = Redis::get('reservation_' . $userId);
        $data = json_decode($data);
        $data->extraData = Promotion::find('id', $data->extraData);
        foreach ($data->seat_ids as $d){
            $showTime = MovieShowtime::where('id', $data->show_time_id)->first();
            $ticketPrice = WeeklyTicketPricesRepository::getTicketPrice($showTime->start_date, $showTime->start_time);
            $seats = Seat::with('seatType')
                ->where('id', $d)
                ->first();
            if($seats->seatType->id == 1){
                $price = (int)$ticketPrice + 10000;
            }else{
                $price = (int)$ticketPrice;
            }
            $dataSeat[] = [
                'seat_id' => $d,
                'seat_name' => $seats->seat_code,
                'movie_showtime_id' => (int)$data->show_time_id,
                'price' => $price
            ];
        }
        $foods = [];
        foreach ($data->food as $f){
            $food = Food::where('id', $f->food_id)->first();
            $food['quantity'] = $f->food_quantity;
            $foods[] = $food;
        }
        $data->seat_ids = $dataSeat;
        $data->food = $foods;
        $response = [
            'cinema' => Cinema::where('id', $data->cinema_id)->first(),
            'show_time' => MovieShowtime::where('id', $data->show_time_id)->first(),
            'extra' => $data->extraData,
            'seat_list' => $data->seat_ids,
            'food' => $data->food,
            'amount' => $data->amount,
        ];
//        return $data->show_time_id;
        return [
            'data_payment' => $dataPayment,
            'data_bill' => $response
            ];
    }

}
