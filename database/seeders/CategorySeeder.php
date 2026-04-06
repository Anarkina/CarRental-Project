<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create(['name' => 'Эконом', 'description' => 'Доступные авто для города']);
        Category::create(['name' => 'Комфорт', 'description' => 'Удобные седаны для долгих поездок']);
        Category::create(['name' => 'Бизнес', 'description' => 'Представительские авто']);
    }
}