<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        return Car::with('category')->get();
    }

    public function show($id)
    {
        return Car::with('category')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'brand' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|integer',
            'license_plate' => 'required|string|unique:cars',
            'price_per_day' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'status' => 'string'
        ]);

        return Car::create($data);
    }
    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        $car->delete();

        return response()->json(['message' => 'Машина успешно удалена из системы']);
    }
}