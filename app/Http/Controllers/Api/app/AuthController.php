<?php

namespace App\Http\Controllers\API\app;

use App\Enums\Constant;
use App\Http\Requests\app\AuthRequest;
use App\Models\Account;
use App\Repositories\user\Account\AccountInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class AuthController
{

    private $accountInterface;

    public function __construct(AccountInterface $accountInterface)
    {
        $this->accountInterface = $accountInterface;
    }
    /**
     * @author son.nk
     * @OA\Post (
     *     path="/api/app/auth/register",
     *     tags={"App Tài khoản"},
     *     summary="Đăng ký",
     *     operationId="app/users/create",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="phone_number", type="string"),
     *              @OA\Property(property="username", type="string"),
     *              @OA\Property(property="password", type="string"),
     *          @OA\Examples(
     *              summary="Examples",
     *              example = "Examples",
     *              value = {
     *                  "email": "user1@gmail.com",
     *                  "name": "Nguyen Van A",
     *                  "phone_number": "0123456789",
     *                  "username": "user1",
     *                  "password": "123123@",
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
    public function register(AuthRequest $request){
        try {
            DB::beginTransaction();
            $data = $request->all();
            $this->accountInterface->register($data);
            DB::commit();
            return response()->json([
                'status' => Constant::SUCCESS_CODE,
                'message' => trans('messages.success.success'),
                'data' => []
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
     * @author Sonnk
     * @OA\Post (
     *     path="/api/app/auth/login",
     *     tags={"App Tài khoản"},
     *     summary="Đăng nhập",
     *     operationId="app/users/login",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="username", type="string"),
     *              @OA\Property(property="password", type="string"),
     *              @OA\Property(property="device_token", type="string"),
     *          @OA\Examples(
     *              summary="Examples",
     *              example = "Examples",
     *              value = {
     *                  "username": "user1",
     *                  "password": "123123@",
     *                  "device_token": "xxx111xxx",
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
    public function login(AuthRequest $request)
    {
        try {
            $user = $this->accountInterface->login($request);
            if (!$user) {
                return response()->json([
                    'status' => Response::HTTP_BAD_REQUEST,
                    'errorCode' => 'E_UC2_1',
                    'message' => trans('messages.errors.users.email_not_found'),
                    'data' => []
                ], Response::HTTP_BAD_REQUEST);
            }
            if ($user->status == Account::NOT_ACTIVE) {
                return response()->json([
                    'status' => Response::HTTP_BAD_REQUEST,
                    'errorCode' => 'E_UC2_2',
                    'message' => trans('messages.errors.users.account_not_active'),
                    'data' => []
                ], Response::HTTP_BAD_REQUEST);
            }

            $credentials = [
                'username' => $request->username,
                'password' => $request->password
            ];
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status' => Response::HTTP_BAD_REQUEST,
                    'errorCode' => 'E_UC2_3',
                    'message' => trans('messages.errors.users.password_not_correct'),
                    'data' => []
                ], Response::HTTP_BAD_REQUEST);
            }


            // xoa token cu
            $user->tokens()->delete();

            $user->update([
                'device_token' => $request->device_token
            ]);
            $data = [
                'token' => $user->createToken($request->device_token)->plainTextToken,
                'user' => $user
            ];

            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => trans('messages.success.users.login_success'),
                'data' => $data
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => Constant::FALSE_CODE,
                'message' => $th->getMessage(),
                'data' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

///**
// * @author Sonnk
// * @OA\Get (
// *     path="/api/app/bill/get-list-bill",
// *     tags={"APP Đơn hàng"},
// *     summary="Danh sách đơn hàng",
// *     security={{"bearerAuth":{}}},
// *     operationId="get-list-bill",
// *     @OA\Response(
// *         response=200,
// *         description="Success",
// *             @OA\JsonContent(
// *              @OA\Property(property="message", type="string", example="Success."),
// *          )
// *     ),
// * )
// */
