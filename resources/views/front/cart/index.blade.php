<?php
$total=0;
use App\Http\Controllers\Site\CartController;
$quentity=CartController::countCart();
?>
@extends('layouts.site')

@section('content')
    <nav data-depth="1" class="breadcrumb-bg">
        <div class="container no-index">
            <div class="breadcrumb">

                <ol itemscope="" itemtype="http://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="{{route('home')}}">
                            <span itemprop="name">Home</span>
                        </a>
                        <meta itemprop="position" content="1">
                    </li>
                </ol>

            </div>
        </div>
    </nav>

    <div class="container no-index">
        <div class="row">
            <div id="content-wrapper" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <section id="main">
                    <h1 class="page-title">Shopping Cart</h1>
                    <div class="cart-grid row">
                        <div class="cart-grid-body col-xs-12 col-lg-9">
                            <!-- cart products detailed -->
                            <div class="cart-container">
                                <div class="cart-overview js-cart"
                                     data-refresh-url="">
                                    @isset($products)
                                        <ul class="cart-items">
                                            @foreach($products as $product)
                                                <li class="cart-item">
                                                    <div class="product-line-grid row spacing-10">
                                                        <!--  product left content: image-->
                                                        <div class="product-line-grid-left col-sm-2 col-xs-4">
                                                        <span class="product-image media-middle">
                                                          <img class="img-fluid"
                                                               src="{{$product -> images[0] -> photo ?? ''}}"
                                                               alt="Vehicula vel tempus sit amet ulte">
                                                        </span>
                                                        </div>

                                                        <!--  product left body: description -->
                                                        <div class="product-line-grid-body col-sm-10 col-xs-8">
                                                            <div class="row">
                                                                <div class="col-sm-6 col-xs-12">
                                                                    <div class="product-line-info">
                                                                        <a class="label"
                                                                           href="{{route('product.details',$product -> slug)}}"
                                                                           data-id_customization="0">{{$product -> name}}</a>
                                                                    </div>

                                                                    <div class="product-line-info product-price">
                                                                       <span itemprop="price"
                                                                             class="price">{{$product -> special_price ?? $product -> price }}</span>
                                                                       

                                                                    </div>

                                                                </div>
                                                                <div
                                                                    class="text-center product-line-actions col-sm-6 col-xs-12">
                                                                    <div class="row">
                                                                        <div class="col-sm-9 col-xs-12">
                                                                            <div class="row">
                                                                                <div class="col-md-6 col-xs-6 qty">
                                                                                     <div class="label">Qty:</div>
                                                                                   <div
                                                                                        class="input-group bootstrap-touchspin">
                                                                                <!-- <span
                                                                                    class="input-group-addon bootstrap-touchspin-prefix"
                                                                                    style="display: none;"></span><input
                                                                                            id="quantity_wanted"
                                                                                            class="js-cart-line-product-quantity form-control"

                                                                                            data-product-id="5"
                                                                                            type="text"
                                                                                            value="1"
                                                                                            name="product-quantity-spin"
                                                                                            min="1"
                                                                                            style="display: block;"><span
                                                                                            class="input-group-addon bootstrap-touchspin-postfix"
                                                                                            style="display: none;"></span> -->

                                                                                            <div class="input-group text-center mb-3" style='width:130px'>
                                                                                                   <button class='input-group-text decrement-btn changeQuantity'style='border: 1px solid #dfdfdf; font-size: 25px;' productid="{{$product -> id}}">-</button>
                                                                                                   <input type='text' name='quantity' class='form-control qty-input text-center' value='{{$product->carts[0]->product_qty}}'/>
                                                                                                   <button class='input-group-text increment-btn changeQuantity'style='border: 1px solid #dfdfdf; font-size: 18px;' productid="{{$product -> id}}">+</button>
                                                                                            </div>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="col-sm-3 col-xs-12 text-xs-right align-self-end">
                                                                            <div class="cart-line-product-actions shop-item">
                        
                                                                                <a class="remove-from-cart" href="#"
                                                                                    productid="{{$product -> id}}"
                                                                                >
                                                                                <i class="fa fa-trash-o"></i>
                                                                              </a>


                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </li>
                                                <?php

                                                 $total +=$product->carts[0]->product_qty*$product -> special_price ?? $product -> price;
                                                 //$product -> special_price ?? $product -> price*
                                                ?>
                                            @endforeach
                                        </ul>
                                    @endisset
                                </div>
                            </div>
                            <a class="label btn btn-primary" href="http://demo.bestprestashoptheme.com/savemart/en/">
                                Continue shopping
                            </a>
                            <!-- shipping informations -->
                        </div>
                        <!-- Right Block: cart subtotal & cart total -->
                        <div class="cart-grid-right col-xs-12 col-lg-3">
                            <div class="cart-summary">
                                <div class="cart-detailed-totals">
                                    <div class="cart-summary-products">
                                        <div class="summary-label">There are {{$quentity}} Items</div>
                                    </div>

                                    <div class="">
                                        <div class="cart-summary-line cart-total">
                                            <span class="label">Total:{{$total}}</span>
                                            <span class="value"></span>
                                        </div>

                                    </div>

                                </div>


                                <div class="checkout text-xs-center card-block">
                                    <a href="{{route('payment' , $total)}}" type="button" class="btn btn-primary"> proceed to payment
                                    </a>
                                </div>


                            </div>


                            <div class="blockreassurance_product">
                                <div>
                                                  <span class="item-product">
                                                        <img class="svg invisible"
                                                             src="../modules/blockreassurance/img/ic_verified_user_black_36dp_1x.png">
                                                        &nbsp;
                                                    </span>
                                    <p class="block-title" style="color:#000000;">Security policy (edit with
                                        Customer reassurance module)</p>
                                </div>
                                <div>
                                          <span class="item-product">
                                                        <img class="svg invisible"
                                                             src="../modules/blockreassurance/img/ic_local_shipping_black_36dp_1x.png">
                                                            &nbsp;
                                           </span>
                                    <p class="block-title" style="color:#000000;">Delivery policy (edit with
                                        Customer reassurance module)</p>
                                </div>
                                <div>
                                             <span class="item-product">
                                                        <img class="svg invisible"
                                                             src="../modules/blockreassurance/img/ic_swap_horiz_black_36dp_1x.png">
                                                          &nbsp;
                                              </span>
                                    <p class="block-title" style="color:#000000;">Return policy (edit with Customer
                                        reassurance module)</p>
                                </div>
                                <div class="clearfix"></div>
                            </div>


                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@stop


@section('scripts')
    <script>


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.decrement-btn').click(function(e){
            e.preventDefault();
            var value=parseInt($(this).siblings('input').val(),10);
            value=isNaN(value)?0:value;
            if(value>1){
                value--;
                $(this).siblings('input').val(value);
        
            }
            
        });
        $('.increment-btn').click(function(e){
            e.preventDefault();
            var value=parseInt($(this).siblings('input').val(),10);
            value=isNaN(value)?0:value;
            if(value<10){
                value++;
                $(this).siblings('input').val(value);
               
            }
            
        });
        $(document).on('click', '.remove-from-cart', function (e) {
            
            e.preventDefault();
            //alert($(this).attr('productid'));
           
            $.ajax({
                type: 'post',
                url: "{{Route('site.cart.delete')}}",
                data:{'productId': $(this).attr('productid')},
                 dataType: 'json',
                success: function (data) {
                    if(data.carted){
                        window.location.reload();  
                    }else{
                        alert('Login To Continue')
                    }
                       
                }
            });
        });
        $('.changeQuantity').click(function(e){
               e.preventDefault();
               data={
                
                'productId': $(this).attr('productid'),
                'productQty':$(this).siblings('input').val()
             
                 };
                 //alert($(this).siblings('input').val())
               $.ajax({
                type: 'post',
                url: "{{Route('site.cart.update')}}",
                data: data,
                 dataType: 'json',
                success: function (data) {
                    if(data.carted){
                        window.location.reload();  
                    }else{
                        alert('Login To Continue')
                    }
                }
            });
               
        })
    </script>
    @stop
