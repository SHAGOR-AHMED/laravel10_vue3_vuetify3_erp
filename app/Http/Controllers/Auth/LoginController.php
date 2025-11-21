<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;

class LoginController extends Controller
{

    public function index(){
       
        if(Auth::user()){
            return redirect()->back();
        }else{    
            return view('login');
        }
    }


    public function authenticate(Request $request){

        Self::validateLogin($request);
        $result = Self::checkCrediantials($request);
        if($result){
    	    return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    	
    }//authenticate

    protected static function validateLogin($request){

        $request->validate([
            'email'    => 'required',               
            'password' => 'required',  
        ]);
    }
       
    protected static function checkCrediantials($request){

        $data =  $request->only(['email', 'password']);
        
    	if(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'] ])){
            return true;
    	}else{
            return false;
        }

    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect('/');
    }
}
