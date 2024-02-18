<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'first_name' => 'Nahom',
            'last_name' => 'Tesfamichael',
            'address' => 'vrydemalaan 44',
            'zipcode' => '9713 WS',
            'phone_number' => '068707654354',
            'avatar' => 'default.png',
            'email' => 'admin@customwebsite.nl',
            'password' => Hash::make('Welkom123'),
            'role_id' => Role::ADMIN,

        ]);
    }
}
