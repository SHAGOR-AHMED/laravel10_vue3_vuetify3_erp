<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{

    public function index(){
        $roles = Auth::user()->roles->pluck('name');
        return view('welcome', compact('roles'));
    }
}
