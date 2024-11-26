<?php

namespace App\Http\Controllers\Api\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\A;
class AccountController extends Controller
{
    public function index()
    {
        $genres = Genre::all();
        return view('admin.genre.index', compact('genres'));
    }

    
    public function create()
    {
        $config['method'] = 'create';
        return view('admin.genre.create', compact('config'));
    }

  
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            
        ], [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'name.string' => 'Tên danh mục phải là một chuỗi ký tự.',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
            
        ]);
        
        $data = $request->all();
        Genre::create($data);    
        return redirect()->route('genre.create')->with('success', 'Thêm danh mục thành công.');
    }

    
    public function show(string $id)
    {
        //
    }

   
    public function edit($id)
    {
        $genre = Genre::find($id);
        $config['method'] = 'edit';
        return view('admin.genre.create', compact('config','genre'));
    }

   
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            
        ], [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'name.string' => 'Tên danh mục phải là một chuỗi ký tự.',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
            
        ]);
        
        $data = $request->all();
   
        Genre::find($id)->update($data);
        return redirect()->route('genre.index')->with('success', 'Cập nhật danh mục thành công.');
    }

    
    public function destroy($id)
    {
        Genre::find($id)->delete();
        return redirect()->back()->with('success', 'Xóa danh mục thành công.');
    }
}
