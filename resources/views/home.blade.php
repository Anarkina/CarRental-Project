@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h2 class="fw-bold mb-4 text-dark">Наш автопарк в Астане</h2>

        <div class="d-flex flex-wrap gap-2 mb-5">
            <a href="{{ route('home') }}"
                class="btn {{ !request('category') ? 'btn-dark' : 'btn-outline-dark' }} rounded-pill px-4 shadow-sm">Все
                машины</a>
            @foreach($categories as $category)
                <a href="{{ route('home', ['category' => $category->id]) }}"
                    class="btn {{ request('category') == $category->id ? 'btn-dark' : 'btn-outline-dark' }} rounded-pill px-4 shadow-sm">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        <div class="row g-4">
            @foreach($cars as $car)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <img src="{{ $car->image }}" class="card-img-top" style="height: 220px; object-fit: cover;"
                            alt="{{ $car->brand }}">

                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0">{{ $car->brand }} {{ $car->model }}</h5>
                                <span class="text-primary fw-bold h5 mb-0">{{ number_format($car->price_per_day, 0, '', ' ') }}
                                    ₸</span>
                            </div>

                            <p class="small text-secondary mb-4">{{ $car->year }} г. • {{ $car->transmission }} •
                                {{ $car->engine_volume }} л.</p>

                            @auth
                                <button type="button" class="btn btn-dark w-100 rounded-pill py-2 fw-bold" data-bs-toggle="modal"
                                    data-bs-target="#bookModal{{ $car->id }}">
                                    Забронировать
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100 rounded-pill py-2 fw-bold">
                                    Войдите, чтобы забронировать
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

                @auth
                    <div class="modal fade" id="bookModal{{ $car->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 rounded-4 shadow">
                                <div class="modal-header border-0">
                                    <h5 class="modal-title fw-bold">Бронирование {{ $car->brand }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('rentals.store', $car->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label class="form-label small fw-bold text-secondary">Дата начала</label>
                                                <input type="date" name="start_date" class="form-control rounded-3" required
                                                    min="{{ date('Y-m-d') }}">
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label class="form-label small fw-bold text-secondary">Дата окончания</label>
                                                <input type="date" name="end_date" class="form-control rounded-3" required
                                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                            </div>
                                        </div>
                                        <div class="bg-light p-3 rounded-3 mt-2">
                                            <p class="mb-0 small text-muted">Стоимость: <strong
                                                    class="text-dark">{{ number_format($car->price_per_day, 0, '', ' ') }} ₸ /
                                                    сутки</strong></p>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-light rounded-pill px-4"
                                            data-bs-dismiss="modal">Отмена</button>
                                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Подтвердить
                                            бронь</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
            @endforeach
        </div>
    </div>
@endsection