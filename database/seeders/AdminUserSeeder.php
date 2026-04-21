<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User ; 

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name"=>"abdu"  , 
            "email"=>"abdu@gmail.com" , 
            "password"=>"abderrahmane" , 
            "role"=> "admin", 
        ]); 
    }
}
