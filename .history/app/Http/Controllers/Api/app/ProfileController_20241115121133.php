<?php

namespace App\Http\Controllers\Api\app;

use App\Http\Controllers\Controller;
use App\Http\Requests\app\ProfileRequest;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/profile",
     *     tags={"Profile"},
     *     summary="Get the profile of the authenticated user",
     *     operationId="getUserProfile",
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="User profile information retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="dateofbirth", type="string", format="date"),
     *             @OA\Property(property="sex", type="string"),
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="avatar", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Profile not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Profile not found")
     *         )
     *     )
     * )
     */
    public function getProfile(Request $request)
    {
        // Lấy thông tin hồ sơ của người dùng
        $profile = Profile::where('user_id', Auth::user()->id)->first();

        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        return response()->json($profile, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/profile",
     *     tags={"Profile"},
     *     summary="Update or create the profile of the authenticated user",
     *     operationId="updateOrCreateProfile",
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "dateofbirth", "sex", "address"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="dateofbirth", type="string", format="date"),
     *             @OA\Property(property="sex", type="string"),
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="avatar", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profile updated or created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Profile updated or created successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid input")
     *         )
     *     )
     * )
     */
    public function updateOrCreateProfile(ProfileRequest $request)
    {
        // Cập nhật hoặc tạo mới hồ sơ người dùng
        $userProfile = Profile::updateOrCreate(
            ['user_id' => Auth::user()->id],
            [
                'name' => $request->name,
                'dateofbirth' => $request->dateofbirth,
                'sex' => $request->sex,
                'address' => $request->address,
                'avatar' => $request->avatar
            ]
        );

        return response()->json(['message' => 'Profile updated or created successfully'], 200);
    }
}
