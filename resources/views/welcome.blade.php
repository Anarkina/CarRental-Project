@extends('layouts.app')

@section('content')

<div class="hero-section shadow-sm" style="background: linear-gradient(135deg, #2c3e50, #4ca1af); color: white; padding: 80px 0; text-align: center; margin-bottom: 40px;">
    <div class="container">
        <h1 class="display-4 fw-bold">Аренда автомобилей в Астане</h1>
        <p class="lead mb-4">Быстро, просто и надежно. Найди свой идеальный авто прямо сейчас.</p>
        <a href="#catalog" class="btn btn-light btn-lg px-5 rounded-pill shadow">Смотреть каталог</a>
    </div>
</div>

<div class="container" id="catalog">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 fw-bold m-0">Наш автопарк</h2>
        <span class="badge bg-dark rounded-pill px-3 py-2">Доступно сейчас: {{ $cars->count() }}</span>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        @forelse($cars as $car)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden" style="transition: 0.3s;">
                    <div style="background: #eee; height: 200px; display: flex; align-items: center; justify-content: center;">
                        <span class="text-muted">Фото {{ $car->brand }}</span>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="card-title m-0 fw-bold">{{ $car->brand }} {{ $car->model }}</h5>
                            <span class="badge bg-light text-dark border rounded-pill small">{{ $car->category->name }}</span>
                        </div>
                        
                        <p class="text-muted small mb-3">Год выпуска: {{ $car->year }}</p>
                        
                        <div class="d-flex justify-content-between align-items-end mt-3">
                            <div>
                                <span class="h5 text-primary fw-bold">{{ number_format($car->price_per_day, 0, '.', ' ') }} ₸</span>
                                <span class="text-muted small">/ день</span>
                            </div>
                            
                            @auth
                                <button class="btn btn-dark rounded-pill px-4 shadow-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#bookModal{{ $car->id }}">
                                    Забронировать
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-dark rounded-pill px-4 btn-sm">Войти для брони</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            @auth
            <div class="modal fade" id="bookModal{{ $car->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 rounded-4 shadow-lg">
                        <div class="modal-header border-0 px-4 pt-4">
                            <h5 class="modal-title fw-bold">Бронирование: {{ $car->brand }} {{ $car->model }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('cars.rent', $car->id) }}" method="POST">
                            @csrf
                            <div class="modal-body px-4">
                                <div class="p-3 bg-light rounded-3 mb-4 text-center">
                                    <span class="text-muted small d-block">Стоимость аренды</span>
                                    <span class="h4 fw-bold text-dark">{{ number_format($car->price_per_day, 0, '.', ' ') }} ₸ / сутки</span>
                                </div>
                                
                                <div class="row g-3">
                                    <div class="col-6">
                                        <label class="form-label small fw-bold text-muted">Дата начала</label>
                                        <input type="date" name="start_date" class="form-control rounded-3 border-0 bg-light p-2" required min="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small fw-bold text-muted">Дата окончания</label>
                                        <input type="date" name="end_date" class="form-control rounded-3 border-0 bg-light p-2" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    </div>
                                </div>
                                <p class="mt-3 text-center text-muted x-small" style="font-size: 0.75rem;">
                                    Итоговая сумма будет рассчитана автоматически при подтверждении.
                                </p>
                            </div>
                            <div class="modal-footer border-0 p-4">
                                <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow">
                                    Подтвердить бронирование
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endauth

        @empty
            <div class="col-12 text-center py-5 text-muted">
                <h3>Упс! Машин пока нет.</h3>
                <p>Админ скоро добавит новые авто в каталог.</p>
            </div>
        @endforelse
    </div>
</div>

@endsection