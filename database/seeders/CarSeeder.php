<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Создаем категории (теперь их больше!)
        $econ = Category::updateOrCreate(['name' => 'Эконом']);
        $comf = Category::updateOrCreate(['name' => 'Комфорт']);
        $biz  = Category::updateOrCreate(['name' => 'Бизнес']);
        $lux  = Category::updateOrCreate(['name' => 'Люкс']);
        $suv  = Category::updateOrCreate(['name' => 'Внедорожники']);

        $cars = [
    
            ['brand' => 'Mercedes-Benz', 'model' => 'S-Class', 'year' => 2023, 'price' => 85000, 'plate' => '777 VIP 01', 'cat' => $biz->id],
            ['brand' => 'BMW', 'model' => 'M5 F90', 'year' => 2022, 'price' => 75000, 'plate' => '555 MMM 01', 'cat' => $biz->id],
            ['brand' => 'Tesla', 'model' => 'Model X', 'year' => 2023, 'price' => 90000, 'plate' => '007 TS L01', 'cat' => $lux->id],
            ['brand' => 'Porsche', 'model' => 'Taycan', 'year' => 2023, 'price' => 95000, 'plate' => '001 POR 01', 'cat' => $lux->id],
            
            ['brand' => 'Toyota', 'model' => 'Land Cruiser 300', 'year' => 2022, 'price' => 70000, 'plate' => '001 ZZZ 01', 'cat' => $suv->id],
            ['brand' => 'Lexus', 'model' => 'LX 600', 'year' => 2023, 'price' => 80000, 'plate' => '888 LEX 01', 'cat' => $suv->id],

            ['brand' => 'Toyota', 'model' => 'Camry 75', 'year' => 2022, 'price' => 25000, 'plate' => '010 AAA 01', 'cat' => $comf->id],
            ['brand' => 'Hyundai', 'model' => 'Elantra', 'year' => 2023, 'price' => 20000, 'plate' => '123 ABC 01', 'cat' => $econ->id],
            ['brand' => 'Kia', 'model' => 'K5', 'year' => 2022, 'price' => 22000, 'plate' => '444 KIA 01', 'cat' => $comf->id],
        ];

        foreach ($cars as $car) {
            Car::updateOrCreate(
                ['license_plate' => $car['plate']], 
                [
                    'brand' => $car['brand'],
                    'model' => $car['model'],
                    'year' => $car['year'],
                    'price_per_day' => $car['price'],
                    'category_id' => $car['cat'],
                ]
            );
        }

        User::updateOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'phone' => '777',
                'is_admin' => true
            ]
        );
    }
}