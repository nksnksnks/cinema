<?php

namespace App\Http\Controllers\Api\app;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Account;
use App\Http\Requests\app\ChangePasswordRequest;
class ChangePasswordController extends Controller
{
    /**
     * @author quynhndmq
     * @OA\Post(
     *     path="/api/app/change-password",
     *     tags={"App Tài khoản"},
     *     summary="Change the user's password",
     *     operationId="changePassword",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"current_password", "new_password"},
     *                 @OA\Property(property="current_password", type="string", description="The current password of the user"),
     *                 @OA\Property(property="new_password", type="string", description="The new password to set")
     *             ),
     *             @OA\Examples(
     *                 example="ChangePasswordExample",
     *                 summary="Sample change password data",
     *                 value={
     *                     "current_password": "OldPassword123",
     *                     "new_password": "NewPassword123"
     * "current_password": "OldPassword123",
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
     *     security={
     *         {"sanctum": {}}
     *     }
     * )
     */
    public function changePassword(ChangePasswordRequest $request)
    {
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
