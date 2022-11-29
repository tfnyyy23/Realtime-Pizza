<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => 'admin-nct',
                'role' => 'admin'
            ],
            [
                'name' => 'Admin 1',
                'email' => 'administrator@gmail.com',
                'password' => 'nct-admin',
                'role' => 'admin'
            ],
        ];

        foreach($user as $key => $value){
            User::create($value);
        }
    }
}
