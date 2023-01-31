<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        DB::table('users')->insert([
            [
                'name'=>'admin',
                'email'=>'admin@admin.com',
                'password'=>Hash::make('testingpassword'),
                'role'=>'admin',
                'status'=>'active',
            ],
        [
            'name'=>'user',
            'email'=>'user@user.com',
            'password'=>Hash::make('testingpassword'),
            'role'=>'user',
            'status'=>'active',
        ]
        ]);
    }
}
