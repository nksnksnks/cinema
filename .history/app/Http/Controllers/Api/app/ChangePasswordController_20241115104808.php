<?php

namespace App\Http\Controllers\Api\app;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Account;
class ChangePasswordController extends Controller
{
    public function changePassword(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed', // Kiểm tra xác nhận new_password_confirmation
        ]);

        // Lấy thông tin người dùng đã đăng nhập
        $user = $request->user();

        // Kiểm tra mật khẩu hiện tại có đúng không
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['error' => 'Mật khẩu hiện tại không chính xác'], 400);
        }

        // Cập nhật mật khẩu
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Mật khẩu đã được thay đổi thành công'], 200);
    }
}
