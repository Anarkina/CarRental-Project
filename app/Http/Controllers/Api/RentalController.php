<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Car;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RentalController extends Controller
{
    public function index()
    {
        return Rental::with(['user', 'car'])->get();
    }
    public function myRentals()
    {
        return Rental::with('car')->where('user_id', auth()->id())->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        $car = Car::findOrFail($request->car_id);
        $days = Carbon::parse($request->start_date)->diffInDays(Carbon::parse($request->end_date)) ?: 1;

        $rental = Rental::create([
            'user_id' => auth()->id(),
            'car_id' => $request->car_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_price' => $car->price_per_day * $days,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Бронирование создано!', 'rental' => $rental], 201);
    }

    public function cancel($id)
    {
        $rental = Rental::where('user_id', auth()->id())->findOrFail($id);
        $rental->update(['status' => 'cancelled']);
        return response()->json(['message' => 'Аренда отменена']);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:confirmed,rejected']);
        $rental = Rental::findOrFail($id);
        $rental->update(['status' => $request->status]);
        return response()->json(['message' => 'Статус обновлен']);
    }
}