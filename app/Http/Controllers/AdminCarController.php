<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCarController extends Controller
{
 
    public function index()
    {
    
        $cars = Car::with('category')->latest()->get();
        return view('admin.cars.index', compact('cars'));
    }


    public function create()
    {
        // Нам нужны категории, чтобы выбрать одну при создании машины
        $categories = Category::all();
        return view('admin.cars.create', compact('categories'));
    }

   
    public function store(Request $request)
    {
        $data = $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'year' => 'required|integer',
            'price_per_day' => 'required|numeric',
            'license_plate' => 'required|unique:cars',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|url', // Проверяем, что это ссылка
            'description' => 'nullable|string',
        ]);

        Car::create($data);

        return redirect()->route('admin.cars.index')->with('success', 'Автомобиль успешно добавлен в автопарк!');
    }

    public function edit(Car $car)
    {
        $categories = Category::all();
        return view('admin.cars.edit', compact('car', 'categories'));
    }


    public function update(Request $request, Car $car)
    {
        // 1. Простая валидация без блокировки по госномеру
        $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'image' => 'nullable', // Убрал 'url', чтобы не ругался на странные ссылки
            'description' => 'nullable',
            'price_per_day' => 'required|numeric',
            'category_id' => 'required',
        ]);

        // 2. Обновляем данные напрямую
        $car->brand = $request->brand;
        $car->model = $request->model;
        $car->year = $request->year;
        $car->price_per_day = $request->price_per_day;
        $car->category_id = $request->category_id;
        $car->image = $request->image;
        $car->description = $request->description;


        if ($car->save()) {
            return redirect()->route('admin.cars.index')->with('success', 'Обновили!');
        }

        return back()->with('error', 'Ошибка при сохранении в базу');
    }


    public function destroy(Car $car)
    {
        // Проверяем, нет ли активных бронирований на эту машину перед удалением (опционально)
        if ($car->rentals()->where('status', 'confirmed')->exists()) {
            return back()->with('error', 'Нельзя удалить машину, которая сейчас находится в аренде!');
        }

        $car->delete();

        return redirect()->route('admin.cars.index')->with('success', 'Автомобиль удален из базы.');
    }
}