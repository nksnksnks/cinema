<?php

namespace app\Http\Controllers\Api\admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\app\AuthRequest;

class AuthAdminController extends Controller
{
    public function viewlogin()
    {
        $config['method'] = 'get_login';
        return view("admin.auth.login", compact('config'));
    }

    public function login(Request $request)
    {
        // Check credentials
        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user(); // Get user info

            // Check if the account is active (status == 1)
            if ($user->status == 1) {
                if ($user->role_id != 4) {
                    return redirect()->route('dashboard.index')->with('success', 'Đăng nhập thành công');
                } else {
                    return redirect()->route('homepage')->with('success', 'Đăng nhập thành công');
                }
            }
            
            // Log out user if status is 0
            Auth::logout();
        }

        // Default error message
        return back()->withErrors(['login' => 'Username hoặc password không chính xác!']);
    }


    public function viewregister()
    {
        return view("admin.auth.register");
    }
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:ci_account,email',
            'username' => 'required|unique:ci_account,username',
            'password' => 'required|min:6|max:55',
            'name' => 'required',
            'phone_number'=> 'required|numeric|min:10|max:11|unique:ci_profile'
        ], [
            'email.unique' => 'Email đã tồn tại',
            'email.email' => 'Email sai định dạng',
            'email.required' => 'Email là bắt buộc',
            'password.required' => 'Mật khẩu là trường bắt buộc',
            'password.min' => 'Mật khẩu có độ dài tối thiểu là 6 kí tự',
            'password.max' => 'Mật khẩu có độ dài tối đa là 55 kí tự',
            'username.unique' => 'User name đã tồn tại',
            'name.required' => 'Tên là trường bắt buộc',
            'phone_number.required' => 'Số điện thoại là trường bắt buộc',
            'phone_number.numeric' => 'Số điện thoại phải là số',
            'phone_number.unique' => 'Số điện thoại đã tồn tại',
            'phone_number.min' => 'Số điện thoại có độ dài không phù hợp',
            'phone_number.max' => 'Số điện thoại có độ dài không phù hợp',

        ]);
       $account = Account::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 1, // Set status to 'active'
            'role_id' => 4,
        ])->id;
        $profile = Profile::create([
            'account_id' => $account,
            'name' => $request->name,
            'phone_number' => $request->phone_number,
        ]);


        return redirect()->route("auth.login")->with('success', 'Đăng ký thành công! Bạn có thể đăng nhập ngay.');
    }
    public function viewChangePassword()
    {
        return view("admin.auth.change-password");
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login');
    }

    public function ChangePassword(Request $request){
        $validatedData = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:6',
        ], [
            'current_password.required' => 'Mật khẩu hiện tại là trường bắt buộc',
            'new_password.required' => 'Mật khẩu mới là trường bắt buộc',
            'new_password.confirmed' => 'Mật khẩu xác nhận không khớp',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 kí tự',
        ]);
        $user = $request->user();
        // Kiểm tra mật khẩu hiện tại có chính xác không
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }
        
        $user->password = Hash::make($request->new_password);
        $user->save();
        return back()->with('success', 'Đổi mật khẩu thành công.');
    }
}
