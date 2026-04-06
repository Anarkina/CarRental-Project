@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h4 class="fw-bold mb-4">Новый автомобиль</h4>
                    <form action="{{ route('admin.cars.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="small fw-bold">Бренд</label>
                            <input type="text" name="brand" class="form-control rounded-3" placeholder="Напр: Tesla"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold">Модель</label>
                            <input type="text" name="model" class="form-control rounded-3" placeholder="Напр: Model 3"
                                required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="small fw-bold">Год</label>
                                <input type="number" name="year" class="form-control rounded-3" value="2024" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="small fw-bold">Госномер</label>
                                <input type="text" name="license_plate" class="form-control rounded-3"
                                    placeholder="001 AAA 01" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold">Категория</label>
                            <select name="category_id" class="form-select rounded-3">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="small fw-bold">Цена за сутки (₸)</label>
                            <input type="number" name="price_per_day" class="form-control rounded-3" placeholder="30000"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold">Ссылка на фото (URL)</label>
                            <input type="text" name="image" class="form-control rounded-3"
                                placeholder="https://image.com/car.jpg">
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold">Подробное описание</label>
                            <textarea name="description" class="form-control rounded-3" rows="3"
                                placeholder="Опишите состояние, комплектацию..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">Добавить в
                            базу</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection