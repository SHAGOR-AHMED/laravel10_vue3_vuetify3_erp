<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class IndexController extends Controller
{

    public function index(){
        //$roles = Auth::user()->roles->pluck('name');
        return view('welcome');
    }
}
