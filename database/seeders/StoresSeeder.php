<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Store;


class StoresSeeder extends Seeder
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
            for ($i = 0; $i < 20; $i++) {
                $store = new Store;
                $created_at = Carbon::now()->subMinutes(rand(1, 900));
                $store->user_id = User::all()->random()->id;
                $store->store_name = Str::random(10) . " Store";
                $store->created_at = $created_at;
                $store->save();
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
