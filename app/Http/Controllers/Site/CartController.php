<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;
use App\Http\Requests;
use DB;


class CartController extends Controller
{
    

    public function getIndex(){
        //$productss=Cart::where('user_id',Auth()->user()->id)->with('products')->get();
        $products=auth()->user()
            ->cartlist()
            ->latest()
            ->with('carts')
            ->get();
        
        return view('front.cart.index',compact('products'));
    }

    public function postAdd(Request $request)
    {
        if(Auth::check()){
        $prod_id=$request->input('productId');
        if (! auth()->user()->cartlistHas(request('productId'))) {
            //auth()->user()->cartlist()->attach(request('productId'));
             $cart=new Cart();
             $cart->user_id=Auth()->user()->id;
             $cart->product_id=$prod_id;
             $cart->product_qty='1';
             $cart->save();
            return response() -> json(['status' => true , 'carted' => "Product Already Added To Cart",'added'=>true]);

        }
        return response() -> json(['status' => true , 'carted' => "Product added before",'added'=>false]);  // added before we can use enumeration here     
    }else{
        return response() -> json(['status' => true , 'carted' => "Login To Continue",'added'=>false]);
    }
    }

    public function destroy(Request $request){
        if(Auth::check()){
            $prod_id=$request->input('productId');
            auth()->user()->cartlist()->detach(request('productId'));

                return response() -> json(['status' => true , 'carted' => true]);
        }else{
            return response() -> json(['status' => true , 'carted' => false]);
        }

    }

    public function postUpdate(){
        if(Auth::check()){
            $prod_id=request('productId');
            $prod_qty=request('productQty');
            DB::table('carts')->where(['user_id' => Auth::id(), 'product_id' => $prod_id])->update([
                'product_qty' =>$prod_qty
            ]);
                return response() -> json(['status' => true , 'carted' => true]);
        }else{
            return response() -> json(['status' => true , 'carted' => false]);
        }
    }
    static function countCart(){
        return Cart::where('user_id',Auth::id())->count();
    }


   

}

