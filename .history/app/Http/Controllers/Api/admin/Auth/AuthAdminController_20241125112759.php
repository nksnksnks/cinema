<?php

namespace App\Http\Controllers\Api\admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\app\AuthRequest;
class AuthAdminController extends Controller
{
    public function viewlogin(){
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

            
            if ($user->role_id == 1) {
                return redirect()->route('dashboard.index')->with('success', 'Đăng nhập thành công');
            } else {
                return redirect()->route('homepage')->with('success', 'Đăng nhập thành công');
            }
        }
        
        return back()->withErrors(['login' => 'Username hoặc password không chính xác!']);
    }

    public function viewregister(){
        return view("admin.auth.register");
    }
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:ci_account,email',
            'name' => 'required',
            'username' => 'required|unique:ci_account,username',
            'password' => 'required|min:6|max:55',
            
            
        ], [
            'email.unique' => 'Email đã tồn tại',
            'email.email' => 'Email sai định dạng',
            'email.exists' => 'Email không tồn tại',
            'email.required' => 'Email là bắt buộc',
            'email.prohibited' => 'Email không tồn tại',
            'code.required' => 'Mã OTP là bắt buộc',
            'password.required' => 'Mật khẩu là trường bắt buộc',
            'password.regex' => 'Mật khẩu không chính xác',
            'password.min' => 'Mật khẩu có độ dài tối thiểu là 6 kí tự',
            'password.max' => 'Mật khẩu có độ dài tối đa là 55 kí tự',
            'name.required' => "Họ và tên là bắt buộc",
            'phone_number.unique' => "Số điện thoại đã tồn tại",
            'phone_number.required' => "Số điện thoại là bắt buộc",
            'phone_number.min' => "Số điện thoại có độ dài không phù hợp",
            'phone_number.max' => "Số điện thoại có độ dài không phù hợp",
            'new_password.required' => 'Mật khẩu mới là trường bắt buộc',
            'new_password.confirmed' => 'Mật khẩu mới không trùng nhau',
            'old_password.required' => 'Mật khẩu cũ là trường bắt buộc',
            'new_password.regex' => 'Mật khẩu mới sai định dạng',
            'address.required' => 'Địa chỉ không được bỏ trống',
            'avatar.mimes' => 'Ảnh không đúng định dạng',
            'avatar.max' => 'Kích thước ảnh phải nhỏ hơn 2Mb',
            'username.unique' => 'User name đã tồn tại',
            
        ]);
        Account::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 1, // Set status to 'active'
            'role_id' => $request->role_id, // Set role to 'admin'
        ]);
        
        return redirect()->route("auth.login")->with('success', 'Đăng ký thành công! Bạn có thể đăng nhập ngay.');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login');
    }
}
