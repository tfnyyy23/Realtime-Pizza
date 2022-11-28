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
        $inputan['name'] = 'Admin';
        $inputan['email'] = 'admin@gmail.com';
        $inputan['password'] = ('admin-nct');
        $inputan['role'] = 'admin';
        User::create($inputan);
    }
}
