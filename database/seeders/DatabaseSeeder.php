<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin'.'@gmail.com',
            'password' => Hash::make('admin'),
            'phone' => '0112017970',
            'cuntry' => 'sudan',
            'province' => 'pro1',
            'address' => 'sudan',
            'account_active' => 1,
            'account_type' => 'admin',
            'image' => '/img/user_photo.jpg',
            'subscription_type' => 0,
            'subscription_in' => carbon::now()->toDateTimeString(),
            'subscription_out' => carbon::now()->addWeek()->toDateTimeString(),
        ]);


{

    

         
        DB::table('Items')->insert([
            'seller_id'=> "1",
            'price'=> "1000",
            'color'=> "Red",
            'description'=> "What is Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum has been the industry's standard dummy text ever since the 1500s when an unknown printer took a galley of type and scrambled it to make a type specimen book it has",
            'image1'=> "/images/items/1_1606117526A148.jpeg",
            'image2'=> "/images/items/1_1606117526B1034.jpeg",
            'image3'=> "/images/items/1_1606117526C1588.jpeg",
            'X'=> "1",
            'L'=> "1",
            'XL'=> "1",
            'view'=> "1",
            'type'=> "فساتين زفاف",
        ]);

        DB::table('Items')->insert([
            'seller_id'=> "1",
            'price'=> "2000",
            'color'=> "Red",
            'description'=> "What is Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum has been the industry's standard dummy text ever since the 1500s when an unknown printer took a galley of type and scrambled it to make a type specimen book it has",
            'image1'=> "/images/items/1_1606117526B1034.jpeg",
            'image2'=> "/images/items/1_1606117526A148.jpeg",
            'image3'=> "/images/items/1_1606117526C1588.jpeg",
            'X'=> "1",
            'L'=> "1",
            'XL'=> "1",
            'view'=> "1",
            'type'=> "فساتين زفاف",
        ]);


        DB::table('Items')->insert([
            'seller_id'=> "1",
            'price'=> "3000",
            'color'=> "Red",
            'description'=> "What is Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum has been the industry's standard dummy text ever since the 1500s when an unknown printer took a galley of type and scrambled it to make a type specimen book it has",
            'image1'=> "/images/items/1_1606117526C1588.jpeg",
            'image2'=> "/images/items/1_1606117526A148.jpeg",
            'image3'=> "/images/items/1_1606117526B1034.jpeg",
            'X'=> "1",
            'L'=> "1",
            'XL'=> "1",
            'view'=> "1",
            'type'=> "فساتين زفاف",
        ]);
    }
}
}
