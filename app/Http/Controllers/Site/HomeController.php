<?php

namespace App\Http\Controllers\Site;
use App\Models\Category;
use App\Models\Slider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
class HomeController extends Controller
{
    //
    public function home()
    {
        $data = [];
         $data['sliders'] = Slider::get(['photo']);
         $data['categories'] = Category::parent()->select('id', 'slug')->with(['childrens' => function ($q) {
            $q->select('id', 'parent_id', 'slug');
            $q->with(['childrens' => function ($qq) {
                $qq->select('id', 'parent_id', 'slug');
            }]);
        }])->with('products')->get();
        //return $data['categories'];
        $data['$categorys']=Category::parent()->get();
        $data['products']=Product::get();
        return view('front.home', $data);
    }
}
