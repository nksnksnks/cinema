<?php

namespace App\Http\Controllers\Api\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Role;
use App\Models\Cinema;
use Illuminate\Support\Facades\Hash;
class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::all();
        $roles = Role::pluck('name','id');
        $cinemas = Cinema::pluck('name','id');
        return view('admin.account.index', compact('accounts','roles','cinemas'));
    }

    
    public function create()
    {
        $config['method'] = 'create';
        $roles = Role::pluck('name','id');
        $cinemas = Cinema::pluck('name','id');
        return view('admin.account.create', compact('config','roles','cinemas'));
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
            'role_id' => request('role_id'), 
            'cinema_id' => request('cinema_id')
        ]);
        
        return redirect()->route("auth.login")->with('success', 'Đăng ký thành công! Bạn có thể đăng nhập ngay.');
    }
   
    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            $account = Account::find($id);
    
            // Cập nhật trạng thái
            if ($request->has('status')) {
                $account->status = $request->status;
            } 
            if ($request->has('role_id')) {
                $account->role_id = $request->role_id;
            } 
            if ($request->has('cinema_id')) {
                $account->cinema_id = $request->cinema_id;
            } 
            $account->save();
    
            return response()->json(['success' => 'Thông tin đã được cập nhật']);
        }
    }

    
    public function destroy($id)
    {
        Account::find($id)->delete();
        return redirect()->back()->with('success', 'Xóa account thành công.');
    }
}
