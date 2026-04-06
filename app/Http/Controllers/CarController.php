<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Rental;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
  
    public function index(Request $request)
    {
      
        $categories = \App\Models\Category::all();

      
        $query = \App\Models\Car::with('category');

       
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        $cars = $query->latest()->get();

        return view('home', compact('cars', 'categories'));
    }

    public function storeRental(Request $request, Car $car)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        Rental::create([
            'user_id' => Auth::id(),
            'car_id' => $car->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_price' => $car->price_per_day * (Carbon::parse($request->start_date)->diffInDays($request->end_date) ?: 1),
            'status' => 'pending'
        ]);
        return redirect()->route('profile')->with('success', 'Заявка отправлена!');
    }


    public function allRentals()
    {
        if (Auth::user()->email !== 'admin@test.com')
            return abort(403);
        $rentals = Rental::with(['user', 'car'])->latest()->get();
        return view('admin.rentals', compact('rentals'));
    }


    public function updateRentalStatus(\App\Models\Rental $rental, $status)
    {
        
        if (in_array($status, ['confirmed', 'cancelled'])) {
            $rental->update(['status' => $status]);
        }

        return redirect()->back()->with('success', 'Статус обновлен!');
    }

    public function cancelRental(Rental $rental)
    {
        if (Auth::id() === $rental->user_id || Auth::user()->email === 'admin@test.com') {
            $rental->delete();
            return back()->with('success', 'Бронирование отменено.');
        }
        return abort(403);
    }
}