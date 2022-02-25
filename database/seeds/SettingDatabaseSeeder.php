<?php

use Illuminate\Database\Seeder;
use App\Models\Setting;
class SettingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Setting::setMany([
            'default_locale'=>'ar',
            'default_timezone'=>'Africa/cairo',
            'reviews_enabled'=>true,
            'auto_approve_reviews'=>true,
            'supported_currencies'=>['USD','LE','SAR'],
            'default_currency'=>'USD',
            'store_email'=>'admin@ecommerce.test',
            'search_engine'=>'mysql',
            'local_shipping_cost'=>0,
            'outer_shipping_cost'=>0,
            'free_shipping_cost'=>0,
            'translatable'=>[
                'store_name'=>'Emamy Store',
                'free_shipping_lable'=>'Free Shipping',
                'local_lable'=>'Local Shipping',
                'outer_lable'=>'Outer Shipping',
            ],
        ]);

    }
}
