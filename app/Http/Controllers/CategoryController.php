<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
  
    public function index()
    {
       
        $categories = Category::withCount('cars')->get();
        return view('admin.categories.index', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255',
        ]);

        Category::create([
            'name' => $request->name
        ]);

        return redirect()->route('categories.index')->with('success', 'Категория успешно создана!');
    }
    

  
    public function destroy(Category $category)
    {
        if ($category->cars()->count() > 0) {
            return back()->with('error', 'Нельзя удалить категорию, в которой есть автомобили!');
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Категория удалена');
    }
}