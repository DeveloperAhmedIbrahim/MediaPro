<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AdminSeeder extends Seeder
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
