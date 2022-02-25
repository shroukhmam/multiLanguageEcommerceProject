<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AdminLoginRequest;
use App\Models\Admin;

class LoginController extends Controller
{
    //
    public function login(){
        return view('admin.auth.login');
    }

    public function postlogin(AdminLoginRequest $request){
        $remember_me = $request->has('remember_me') ? true : false;
        if(auth()->guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)){
            return redirect() -> route('admin.dashboard');
        }
       
        return redirect()->back()->with(['error' => 'هناك خطا بالبيانات']);

    }

    public function logout(){
        Auth()->guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
