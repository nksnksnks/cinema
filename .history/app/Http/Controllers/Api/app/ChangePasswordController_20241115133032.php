<?php

namespace App\Http\Controllers\Api\app;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Account;
use App\Http\Requests\app\ChangePasswordRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class ChangePasswordController extends Controller
{
    /**
     * @author quynhndmq
     * @OA\Post(
     *     path="/api/app/change-password",
     *     tags={"App Tài khoản"},
     *     summary="Change the user's password",
     *     operationId="changePassword",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             required={"current_password", "new_password", "new_password_confirmation"},
     *             @OA\Property(property="current_password", type="string", description="The current password of the user"),
     *             @OA\Property(property="new_password", type="string", description="The new password to set"),
     *             @OA\Property(property="new_password_confirmation", type="string", description="Confirmation of the new password"),
     *             @OA\Examples(
     *                 example="ChangePasswordExample",
     *                 summary="Sample change password data",
     *                 value={
     *                     "current_password": "OldPassword123",
     *                     "new_password": "NewPassword123",
     *                     "new_password_confirmation": "NewPassword123"
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password successfully updated",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Password successfully updated")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Current password is incorrect")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="An error occurred.")
     *         )
     *     ),
     * )
     */
   

public function changePassword(ChangePasswordRequest $request)
{
    // Sử dụng DB Transaction để đảm bảo toàn vẹn dữ liệu
    DB::beginTransaction();

    try {
        // Lấy thông tin người dùng đã đăng nhập
        $user = $request->user();

        // Kiểm tra mật khẩu hiện tại có đúng không
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['error' => 'Mật khẩu hiện tại không chính xác'], 400);
        }

        // Kiểm tra mật khẩu mới và mật khẩu xác nhận có khớp không
        if ($request->new_password !== $request->new_password_confirmation) {
            return response()->json(['error' => 'Mật khẩu mới và mật khẩu xác nhận không khớp'], 400);
        }

        // Cập nhật mật khẩu
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Commit transaction nếu không có lỗi
        DB::commit();

        return response()->json(['message' => 'Mật khẩu đã được thay đổi thành công'], 200);
    } catch (\Exception $e) {
        // Rollback transaction nếu có lỗi
        DB::rollBack();

        return response()->json(['error' => 'Đã xảy ra lỗi khi thay đổi mật khẩu.'], 500);
    }
}

}

