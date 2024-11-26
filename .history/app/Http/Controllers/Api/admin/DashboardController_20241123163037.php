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

    public function homepage()
    {
        return view('admin.auth');
    }
}
