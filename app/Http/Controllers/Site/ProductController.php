<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function productsBySlug($slug)
    {
        $data=[];
        $data['product'] = Product::where('slug',$slug) -> first();  //improve select only required fields
        if (!$data['product']){ ///  redirect to previous page with message
              }

        $product_id = $data['product'] -> id ;
        $product_categories_ids =  $data['product'] -> categories ->pluck('id'); // [1,26,7] get all categories that product on it

       $data['product_attributes'] =  Attribute::whereHas('options' , function ($q) use($product_id){
            $q -> whereHas('product',function ($qq) use($product_id){
                $qq -> where('product_id',$product_id);
            });
        })->get();
         

     $data['related_products'] = Product::whereHas('categories',function ($cat) use($product_categories_ids){
           $cat-> whereIn('categories.id',$product_categories_ids);
       }) -> limit(20) -> latest() -> get();

        return view('front.products-details', $data);
    }
    
}
// @isset($products)
// @foreach($products as $product)
//     <div class="item item-list">
//         <div class="product-miniature js-product-miniature first_item"
//              data-id-product="15" data-id-product-attribute="303"
//              itemscope="" itemtype="http://schema.org/Product">
//             <div class="thumbnail-container">

//                 <a href="{{route('product.details',$product -> slug)}}"
//                    class="thumbnail product-thumbnail two-image">
//                     <img class="img-fluid image-cover"
//                          src="{{$product -> images[0] -> photo ?? ''}}"
//                          alt=""
//                          data-full-size-image-url="{{$product -> images[0] -> photo ?? ''}}"
//                          width="600" height="600">
//                     <img class="img-fluid image-secondary"
//                          src="{{$product -> images[1] -> photo ?? ''}}"
//                          alt=""
//                          data-full-size-image-url="{{$product -> images[1] -> photo ?? ''}}"
//                          width="600" height="600">
//                 </a>


//                 <div class="product-flags discount">Sale</div>


//             </div>
//             <div class="product-description">
//                 <div class="product-groups">

//                     <div class="product-title" itemprop="name"><a
//                             href="{{route('product.details',$product -> slug)}}">{{$product -> name}}</a></div>

//                     <div class="product-comments">
//                         <div class="star_content">
//                             <div class="star"></div>
//                             <div class="star"></div>
//                             <div class="star"></div>
//                             <div class="star"></div>
//                             <div class="star"></div>
//                         </div>
//                         <span>0 review</span>
//                     </div>
//                     <p class="seller_name">
//                         <a title="View seller profile"
//                            href="jmarketplace/1_david-james/index.htm">
//                             <i class="fa fa-user"></i>
//                             David James
//                         </a>
//                     </p>

//                     <div class="product-group-price">

//                         <div class="product-price-and-shipping">


//                                      class="price">{{$product -> special_price ?? $product -> price }}</span>
//                             @if($product -> special_price)
//                                 <span
//                                     class="regular-price">{{$product -> price}}</span>
//                             @endif


//                         </div>

//                     </div>
//                 </div>
//                 <div class="product-desc" itemprop="desciption">
//                         {!! $product -> description !!}
//                     </div>
//                 </div>
//                 <div class="product-buttons d-flex justify-content-center"
//                      itemprop="offers" itemscope=""
//                      itemtype="http://schema.org/Offer">
//                      <form
//                         action=""
//                         method="post" class="formAddToCart">
//                         @csrf
//                                <a class="add-to-cart cart-addition" data-product-id="{{$product -> id}}" 
//                                href="#">
//                                <i class="novicon-cart"></i><span>Add to cart</span></a>
//                     </form>
                 
//                     <a class="addToWishlist  wishlistProd_22" href="#"
//                        data-product-id="{{$product -> id}}"
//                     >
//                         <i class="fa fa-heart"></i>
//                         <span>Add to Wishlist</span>
//                     </a>
//                     <a href="#" class="quick-view hidden-sm-down"
//                        data-product-id="{{$product -> id}}">
//                         <i class="fa fa-search"></i><span> Quick view</span>
//                     </a>
//                 </div>
//             </div>
//         </div>
//     </div>

//     @include('front.includes.product-details',$product)
// @endforeach
// @endisset
