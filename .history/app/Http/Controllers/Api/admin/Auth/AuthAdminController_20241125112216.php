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
    public function register(AuthRequest $request)
    {
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
