@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Автопарк</h2>
            <a href="{{ route('admin.cars.create') }}" class="btn btn-dark rounded-pill px-4">
                + Добавить машину
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Машина</th>
                        <th>Категория</th>
                        <th>Госномер</th>
                        <th>Цена/день</th>
                        <th class="pe-4 text-end">Действие</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cars as $car)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">{{ $car->brand }}</div>
                                <div class="small text-muted">{{ $car->model }} ({{ $car->year }})</div>
                            </td>
                            <td><span class="badge bg-outline-dark border text-dark">{{ $car->category->name }}</span></td>
                            <td><code>{{ $car->license_plate }}</code></td>
                            <td>{{ number_format($car->price_per_day, 0, '.', ' ') }} ₸</td>
                            <td class="pe-4 text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('admin.cars.edit', $car->id) }}"
                                        class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        Изменить
                                    </a>
<!-- 
                                    <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST"
                                        onsubmit="return confirm('Удалить?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-link text-danger text-decoration-none">Удалить</button>
                                    </form> -->
                                </div>
                            </td>
                            <td class="pe-4 text-end">
                                <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST"
                                    onsubmit="return confirm('Удалить эту машину?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-link text-danger text-decoration-none">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection