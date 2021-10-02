<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Store;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            for ($i = 0; $i < 50; $i++) {
                $userModel = new User;
                $created_at = Carbon::now()->subMinutes(rand(100, 200));
                $userModel->full_name = Str::random(10);
                $userModel->email = Str::random(10) . '@gmail.com';
                $userModel->password = bcrypt("12345678");
                $userModel->mobile = '01' . rand(000000001, 999999999);
                $userModel->created_at = $created_at;
                $userModel->save();                
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
