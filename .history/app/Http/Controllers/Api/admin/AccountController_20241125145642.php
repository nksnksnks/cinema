<?php

namespace App\Http\Controllers\Api\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Account;
class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::all();
        return view('admin.account.index', compact('accounts'));
    }

    
    public function create()
    {
        $config['method'] = 'create';
        return view('admin.genre.create', compact('config'));
    }

   
    public function edit($id)
    {
        $genre = Account::find($id);
        $config['method'] = 'edit';
        return view('admin.genre.create', compact('config','genre'));
    }

   
    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            $account = Account::find($id);
    
            // Cập nhật trạng thái
            if ($request->has('status')) {
                $account->status = $request->status;
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
