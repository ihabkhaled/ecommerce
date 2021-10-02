<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Cart;

class CartsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            for ($i = 0; $i < 150; $i++) {
                $cart = new Cart;
                $created_at = Carbon::now()->subMinutes(rand(1, 900));
                $cart->guest_session = rand(1, 10);
                $cart->product_id = Product::all()->random()->id;
                $cart->created_at = $created_at;
                $cart->save();
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
