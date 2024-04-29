<?php

namespace Database\Seeders;
use App\Http\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone'=> '03012345',
            'role'=> '1',
            'password' => bcrypt('password'),
            'created_at' => now(),
            'updated_at' => now()

        ]);
        User::create([
            'name' => 'customer',
            'email' => 'customer@gmail.com',
            'phone'=> '030123456',
            'role'=> '2',
            'password' => bcrypt('password'),
            'created_at' => now(),
            'updated_at' => now()

        ]);
    }
}