<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

 
    public function run(): void
    {
   
        $this->call([
            CategorySeeder::class,
            CarSeeder::class,
        ]);

        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'phone' => '777',
            'is_admin' => true,
        ]);
    }

}
