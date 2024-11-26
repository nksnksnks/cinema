<?php

namespace App\Http\Controllers\Api\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.home.index');
    }

    public function viewlogin()
    {
        return view('admin.auth.index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('homepage');
    }
}
