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
            'username' => 'required|unique:ci_account,username',
            'password' => 'required|min:6|max:55',
            
            
        ], [
            'email.unique' => 'Email đã tồn tại',
            'email.email' => 'Email sai định dạng',
            
            'email.required' => 'Email là bắt buộc',
          
            
            'password.required' => 'Mật khẩu là trường bắt buộc',
           
            'password.min' => 'Mật khẩu có độ dài tối thiểu là 6 kí tự',
            'password.max' => 'Mật khẩu có độ dài tối đa là 55 kí tự',
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
