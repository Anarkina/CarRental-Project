@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="fw-bold mb-4 text-center">Редактирование</h4>

                @if ($errors->any())
                    <div class="alert alert-danger py-2 small">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.cars.update', $car->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="small fw-bold">Бренд и модель</label>
                        <div class="d-flex gap-2">
                            <input type="text" name="brand" class="form-control" value="{{ $car->brand }}" required>
                            <input type="text" name="model" class="form-control" value="{{ $car->model }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="small fw-bold text-primary">Ссылка на фото (URL)</label>
                        <input type="text" name="image" class="form-control border-primary" value="{{ $car->image }}" placeholder="">
                        <div class="form-text small text-muted">Необходимо вставить ссылку на картинку</div>
                    </div>

                    <div class="mb-3">
                        <label class="small fw-bold">Описание</label>
                        <textarea name="description" class="form-control" rows="3">{{ $car->description }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="small fw-bold">Цена (₸)</label>
                            <input type="number" name="price_per_day" class="form-control" value="{{ $car->price_per_day }}" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="small fw-bold">Год</label>
                            <input type="number" name="year" class="form-control" value="{{ $car->year }}" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="small fw-bold">Категория</label>
                        <select name="category_id" class="form-select">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $car->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">Сохранить изменения</button>
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.cars.index') }}" class="text-muted small text-decoration-none">← Назад в список</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection