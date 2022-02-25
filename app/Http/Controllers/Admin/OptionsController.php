<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Option;
use App\Http\Requests\OptionsRequest;
use App\Models\Product;
use App\Models\Attribute;
use DB;


class OptionsController extends Controller
{
    //
    public function index(){
     // return  $options=Option::with(['product','attribute'])->paginate(PAGINATION_COUNT);
    
      $options = Option::with(['product' => function ($prod) {
          $prod->select('id');
      }, 'attribute' => function ($attr) {
          $attr->select('id');
      }])->select('id', 'product_id', 'attribute_id', 'price')->paginate(PAGINATION_COUNT);


      return view('admin.options.index', compact('options'));
    }


   
    public function create()
    {
        $data = [];
        $data['products'] = Product::active()->select('id')->get();
        $data['attributes'] = Attribute::select('id')->get();

        return view('admin.options.create', $data);
    }

    public function store(OptionsRequest $request){
        try{

            DB::beginTransaction();
         $option=Option::create($request->except('_token'));
         $option->name=$request->name;
         $option->save();
         DB::commit();
         return redirect()->route('admin.options')->with(['success' => __('admin/message.successadd')]);
         }catch(\Exception $ex){
             return $ex;
             DB::rollback();
             return redirect()->route('admin.options')->with(['error' => __('admin/message.error')]);
         }


    }




    public function edit($id){
       
        $data = [];
         $data['option'] = Option::find($id);

        if (!$data['option'])
            return redirect()->route('admin.options')->with(['error' => __('admin/message.notfound')]);
        $data['products'] = Product::active()->select('id')->get();
        $data['attributes'] = Attribute::select('id')->get();


        return view('admin.options.edit', $data);
    }

    public function update($id, OptionsRequest $request)
    {
        try {

             $option = Option::find($id);

            if (!$option)
                return redirect()->route('admin.options')->with(['error' => __('admin/message.notfound')]);

            $option->update($request->only(['price','product_id','attribute_id']));
            //save translations
            $option->name = $request->name;
            $option->save();

            return redirect()->route('admin.options')->with(['success' => __('admin/message.success')]);
        } catch (\Exception $ex) {

            return redirect()->route('admin.options')->with(['error' => __('admin/message.error')]);
        }

    }


    public function destroy($id)
    {

        try {
            //get specific categories and its translations
            $option =Option::find($id);

            if (!$option)
                return redirect()->route('admin.options')->with(['success' => __('admin/message.notfound')]);

            $option->delete();      
        
           return redirect()->route('admin.options')->with(['success' => __('admin/message.successdelete')]);
         }catch(\Exception $ex){
           
            return redirect()->route('admin.options')->with(['error' => __('admin/message.error')]);
        }
    }
}
