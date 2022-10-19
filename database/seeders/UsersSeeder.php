<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Administrador',
            'type' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make(12345678),
        ]);
        User::create([
            'name' => 'Usuário_1',
            'email' => 'yslandiosouza2010@gmail.com',
            'password' => Hash::make(12345678),
        ]);
        User::create([
            'name' => 'Usuário_2',
            'email' => 'yslandiosouza20102@gmail.com',
            'password' => Hash::make(12345678),
        ]);
    }
}
