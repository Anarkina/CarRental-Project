@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold m-0">Управление арендой</h2>
            <div class="d-flex gap-2 mb-4">
                <a href="{{ route('admin.rentals') }}" class="btn btn-dark rounded-pill px-4">Бронирования</a>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-dark rounded-pill px-4">Категории</a>
                <a href="{{ route('admin.cars.index') }}" class="btn btn-outline-dark rounded-pill px-4">Автопарк</a>
            </div>
            <a href="{{ route('profile') }}" class="btn btn-outline-dark btn-sm rounded-pill">Назад в профиль</a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Пользователь</th>
                            <th>Автомобиль</th>
                            <th>Статус</th>
                            <th class="pe-4 text-end">Действия админа</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rentals as $rental)
                            <tr>
                                <td class="ps-4">#{{ $rental->id }}</td>
                                <td>
                                    <div class="fw-bold">{{ $rental->user->name }}</div>
                                    <div class="small text-muted">{{ $rental->user->email }}</div>
                                </td>
                                <td>{{ $rental->car->brand }} {{ $rental->car->model }}</td>
                                <td>
                                    @if($rental->status == 'pending')
                                        <span class="badge bg-warning text-dark">В обработке</span>
                                    @elseif($rental->status == 'confirmed')
                                        <span class="badge bg-success">Подтверждено</span>
                                    @else
                                        <span class="badge bg-secondary">Завершено</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <form action="{{ route('admin.rentals.update', [$rental->id, 'confirmed']) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm">Подтвердить</button>
                                        </form>

                                        <form action="{{ route('admin.rentals.update', [$rental->id, 'rejected']) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-sm btn-outline-danger rounded-pill px-3">Отклонить</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection