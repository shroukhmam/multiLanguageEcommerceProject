<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Attribute;
use App\Http\Requests\AttributesRequest;

class AttributesController extends Controller
{
    //
    public function index(){
        $attributes=Attribute::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('admin.attributes.index',compact('attributes'));

    }
    public function create(){
        return view('admin.attributes.create');
    }
    public function store(AttributesRequest $request){
        try{

        DB::beginTransaction();
        $attribute = Attribute::create([]);

        //save translations
        $attribute->name = $request->name;
        $attribute->save();
        DB::commit();
        return redirect()->route('admin.attributes')->with(['success' => __('admin/message.successadd')]);
        }catch(\Exception $ex){

            DB::rollback();
            return redirect()->route('admin.attributes')->with(['error' => __('admin/message.error')]);
        }
    }

    public function edit($id){
        $attribute=Attribute::find($id);
        return view('admin.attributes.edit',compact('attribute'));
    }
    public function update($id,AttributesRequest $request){
        $attribute=Attribute::find($id);
        //return $attribute;
        try{
            if(!$attribute)
                  return redirect()->route('admin.attributes')->with(['success' => __('admin/message.notfound')]);
        
           DB::beginTransaction();
          // Attribute::update([]);
           $attribute->name=$request->name;
           $attribute->save();
           DB::commit();
           return redirect()->route('admin.attributes')->with(['success' => __('admin/message.success')]);
         }catch(\Exception $ex){
            DB::rollback();
            return redirect()->route('admin.attributes')->with(['error' => __('admin/message.error')]);
        }
    }



        public function destroy($id){
            $attribute=Attribute::find($id);
            //return $attribute;
            try{
                if(!$attribute)
                      return redirect()->route('admin.attributes')->with(['success' => __('admin/message.notfound')]);

                $attribute->delete();      
            
               return redirect()->route('admin.attributes')->with(['success' => __('admin/message.successdelete')]);
             }catch(\Exception $ex){
               
                return redirect()->route('admin.attributes')->with(['error' => __('admin/message.error')]);
            }

        }
                
        
 
}
