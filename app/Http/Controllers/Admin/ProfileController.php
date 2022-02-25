<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
class ProfileController extends Controller
{
    //
    public function edit(){
        $admin=Auth()->guard('admin')->user();
        return view('admin.profile.edit',compact('admin'));
    }
    public function update(ProfileRequest $request){
    

            $admin = auth()->guard('admin')->user();


            if ($request->filled('password')) {
                $request->merge(['password' => bcrypt($request->password)]);
            }

            unset($request['id']);
            unset($request['password_confirmation']);

            $admin->update($request->all());

            return redirect()->back()->with(['success' => __('admin/message.success')]);

        
    }
}
