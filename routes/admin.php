<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){

        Route::group(['namespace'=>'Admin','middleware'=>'auth:admin','prefix'=>'admin'],function(){
            Route::get('/','DashboardController@index')->name('admin.dashboard');
            Route::get('logout', 'LoginController@logout')->name('admin.logout');
            Route::group(['prefix'=>'settings'],function(){
                Route::get('shipping-methods/{type}','SettingController@edit')->name('edit.shippings.methods');
                Route::put('shipping-methods/{id}','SettingController@update')->name('update.shippings.methods');
                
            });
            Route::group(['prefix'=>'profile'],function(){
                Route::get('edit','ProfileController@edit')->name('edit.profile');
                Route::put('update','ProfileController@update')->name('update.profile');
                
            });
       ################################## categories routes ######################################
        Route::group(['prefix' => 'main_categories'], function () {
            Route::get('/', 'MainCategoriesController@index')->name('admin.maincategories');
            Route::get('create', 'MainCategoriesController@create')->name('admin.maincategories.create');
            Route::post('store', 'MainCategoriesController@store')->name('admin.maincategories.store');
            Route::get('edit/{id}', 'MainCategoriesController@edit')->name('admin.maincategories.edit');
            Route::post('update/{id}', 'MainCategoriesController@update')->name('admin.maincategories.update');
            Route::get('delete/{id}', 'MainCategoriesController@destroy')->name('admin.maincategories.delete');
        });

        ################################## end categories    #######################################

          ################################## sub categories routes ######################################
          Route::group(['prefix' => 'sub_categories'], function () {
            Route::get('/', 'SubCategoriesController@index')->name('admin.subcategories');
            Route::get('create', 'SubCategoriesController@create')->name('admin.subcategories.create');
            Route::post('store', 'SubCategoriesController@store')->name('admin.subcategories.store');
            Route::get('edit/{id}', 'SubCategoriesController@edit')->name('admin.subcategories.edit');
            Route::post('update/{id}', 'SubCategoriesController@update')->name('admin.subcategories.update');
            Route::get('delete/{id}', 'SubCategoriesController@destroy')->name('admin.subcategories.delete');
        });

        ################################## end categories    #######################################

        ################################## brands routes ######################################
        Route::group(['prefix' => 'brands'], function () {
            Route::get('/', 'BrandsController@index')->name('admin.brands');
            Route::get('create', 'BrandsController@create')->name('admin.brands.create');
            Route::post('store', 'BrandsController@store')->name('admin.brands.store');
            Route::get('edit/{id}', 'BrandsController@edit')->name('admin.brands.edit');
            Route::post('update/{id}', 'BrandsController@update')->name('admin.brands.update');
            Route::get('delete/{id}', 'BrandsController@destroy')->name('admin.brands.delete');
        });
        ################################## end brands    #######################################
         ################################## Tags routes ######################################
         Route::group(['prefix' => 'tags'], function () {
            Route::get('/', 'TagsController@index')->name('admin.tags');
            Route::get('create', 'TagsController@create')->name('admin.tags.create');
            Route::post('store', 'TagsController@store')->name('admin.tags.store');
            Route::get('edit/{id}', 'TagsController@edit')->name('admin.tags.edit');
            Route::post('update/{id}', 'TagsController@update')->name('admin.tags.update');
            Route::get('delete/{id}', 'TagsController@destroy')->name('admin.tags.delete');
        });
        ################################## end brands    #######################################
         ################################## products routes ######################################
         Route::group(['prefix' => 'products'], function () {
            Route::get('/', 'ProductsController@index')->name('admin.products');
            Route::get('general-information', 'ProductsController@create')->name('admin.products.general.create');
            Route::post('store-general-information', 'ProductsController@store')->name('admin.products.general.store');

            Route::get('price/{id}', 'ProductsController@getPrice')->name('admin.products.price');
            Route::post('price', 'ProductsController@saveProductPrice')->name('admin.products.price.store');

            Route::get('stock/{id}', 'ProductsController@getStock')->name('admin.products.stock');
            Route::post('stock', 'ProductsController@saveProductStock')->name('admin.products.stock.store');

            Route::get('images/{id}', 'ProductsController@addImages')->name('admin.products.images');
            Route::post('images', 'ProductsController@saveProductImages')->name('admin.products.images.store');
            Route::post('images/db', 'ProductsController@saveProductImagesDB')->name('admin.products.images.store.db');
        });
        ################################## end brands    #######################################
           ################################## attrributes routes ######################################
           Route::group(['prefix' => 'attributes'], function () {
            Route::get('/', 'AttributesController@index')->name('admin.attributes');
            Route::get('create', 'AttributesController@create')->name('admin.attributes.create');
            Route::post('store', 'AttributesController@store')->name('admin.attributes.store');
            Route::get('delete/{id}', 'AttributesController@destroy')->name('admin.attributes.delete');
            Route::get('edit/{id}', 'AttributesController@edit')->name('admin.attributes.edit');
            Route::post('update/{id}', 'AttributesController@update')->name('admin.attributes.update');
        });
        ################################## end attributes    #######################################

        ################################## brands options ######################################
        Route::group(['prefix' => 'options'], function () {
            Route::get('/', 'OptionsController@index')->name('admin.options');
            Route::get('create', 'OptionsController@create')->name('admin.options.create');
            Route::post('store', 'OptionsController@store')->name('admin.options.store');
            //Route::get('delete/{id}','OptionsController@destroy') -> name('admin.options.delete');
            Route::get('edit/{id}', 'OptionsController@edit')->name('admin.options.edit');
            Route::post('update/{id}', 'OptionsController@update')->name('admin.options.update');
            Route::get('delete/{id}', 'OptionsController@destroy')->name('admin.options.destroy');
        });
        ################################## end options    #######################################
          ################################## sliders ######################################
          Route::group(['prefix' => 'sliders'], function () {
            Route::get('/', 'SliderController@addImages')->name('admin.sliders.create');
            Route::post('images', 'SliderController@saveSliderImages')->name('admin.sliders.images.store');
            Route::post('images/db', 'SliderController@saveSliderImagesDB')->name('admin.sliders.images.store.db');

        });
        ################################## end sliders    #######################################
        });
        Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>'guest:admin'],function(){
            Route::get('login','LoginController@login')->name('admin.login');
            Route::post('login','LoginController@postlogin')->name('admin.post.login');
        });


    });

