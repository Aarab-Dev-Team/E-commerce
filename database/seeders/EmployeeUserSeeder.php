<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User ; 

class EmployeeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name"=>"employee"  , 
            "email"=>"employee@gmail.com" , 
            "password"=>"employeeadmin" , 
            "role"=> "employee", 
        ]); 
    }
}
