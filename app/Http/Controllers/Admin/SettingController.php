<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Http\Requests\ShippingsRequest;
use DB;

class SettingController extends Controller
{
    //
    public function edit($type){
       // return Setting::where('key','free_shipping_lable')->get();
        if ($type =='free'){
            $shippingMethod =Setting::where('key','free_shipping_lable')->first();
            

        }elseif ($type == 'inner')
        {
            $shippingMethod = Setting::where('key', 'local_lable')->first();
        }elseif ($type == 'outer'){
            $shippingMethod = Setting::where('key', 'outer_lable')->first();
        }else{
            $shippingMethod =Setting::where('key','free_shipping_lable')->first();
        }
             
       return view('admin.settings.shippings.edit', compact('shippingMethod'));
    }

    public function update(ShippingsRequest $request,$id){
         try {
            $shipping_method = Setting::find($id);

            DB::beginTransaction();
            $shipping_method->update(['plain_value' => $request->plain_value]);
            //save translations
            $shipping_method->value = $request->value;
            $shipping_method->save();

            DB::commit();
            return redirect()->back()->with(['success' => __('admin/shippings.success')]);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => __('admin/shippings.error')]);
           
        }
    }
}
