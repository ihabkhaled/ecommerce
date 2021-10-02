<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Store;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        try {
            for ($i = 0; $i < 150; $i++) {
                $product = new Product;
                $created_at = Carbon::now()->subMinutes(rand(1, 900));
                $product->store_id = Store::all()->random()->id;
                $product->product_name = Str::random(10) . " Product";
                $product->product_desc = Str::random(100);
                $product->product_price = rand(0.0, 999.9);
                $product->created_at = $created_at;
                $product->save();
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
