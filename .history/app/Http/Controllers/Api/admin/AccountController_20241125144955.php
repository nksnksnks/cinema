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
            $movie = Movie::find($id);
    
            // Cập nhật danh mục
            if ($request->has('category_id')) {
                $movie->category_id = $request->category_id;
            }
    
            // Cập nhật trạng thái
            if ($request->has('status')) {
                $movie->status = $request->status;
            }
    
            // Cập nhật topview
            if ($request->has('topview')) {
                $movie->topview = $request->topview;
            }
    
            // Cập nhật new_comment
            if ($request->has('new_comment')) {
                $movie->new_comment = $request->new_comment;
            }
    
            // Cập nhật phim_hot
            if ($request->has('phim_hot')) {
                $movie->phim_hot = $request->phim_hot;
            }
    
            $movie->save();
    
            return response()->json(['success' => 'Thông tin đã được cập nhật']);
        }else{
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            
        ], [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'name.string' => 'Tên danh mục phải là một chuỗi ký tự.',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
            
        ]);
        
        $data = $request->all();
   
        Account::find($id)->update($data);
        return redirect()->route('genre.index')->with('success', 'Cập nhật danh mục thành công.');
    }

    
    public function destroy($id)
    {
        Account::find($id)->delete();
        return redirect()->back()->with('success', 'Xóa account thành công.');
    }
}
