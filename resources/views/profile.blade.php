@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm rounded-4 p-3">
                    <div class="card-body text-center">
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 80px; height: 80px; font-size: 2rem;">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <h4 class="fw-bold mb-1">{{ Auth::user()->name }}</h4>
                        <p class="text-muted small mb-3">{{ Auth::user()->email }}</p>

                        @if(Auth::user()->email === 'admin@test.com')
                            <span class="badge bg-danger rounded-pill px-3">Администратор</span>
                        @else
                            <span class="badge bg-success rounded-pill px-3">Клиент</span>
                        @endif
                        <hr class="my-4">
                        <div class="text-start">
                            <p class="small mb-1 text-muted">Телефон:</p>
                            <p class="fw-bold">{{ Auth::user()->phone ?? 'не указан' }}</p>
                        </div>
                        <div class="mt-4">
                            <button type="button" class="btn btn-outline-primary w-100 rounded-pill py-2"
                                data-bs-toggle="modal" data-bs-target="#editProfile">
                                ✏️ Редактировать профиль
                            </button>
                        </div>
                    </div>
                </div>

                @if(Auth::user()->email === 'admin@test.com')
                    <div class="mt-3">
                        <a href="{{ route('admin.rentals') }}" class="btn btn-dark w-100 rounded-pill py-2 fw-bold shadow-sm">
                            ⚙️ Панель управления
                        </a>
                    </div>
                @endif
            </div>

            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold m-0">Мои бронирования</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Автомобиль</th>
                                        <th>Период</th>
                                        <th>Сумма</th>
                                        <th>Статус</th>
                                        <th class="pe-4 text-end">Действие</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($userRentals as $rental)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="fw-bold">{{ $rental->car->brand }}</div>
                                                <div class="small text-muted">{{ $rental->car->model }}</div>
                                            </td>
                                            <td>
                                                <div class="small text-dark">{{ $rental->start_date }}</div>
                                                <div class="small text-muted text-decoration-line-through">
                                                    {{ $rental->end_date }}</div>
                                            </td>
                                            <td class="fw-bold">{{ number_format($rental->total_price, 0, '.', ' ') }} ₸</td>
                                            <td>
                                                @if($rental->status == 'pending')
                                                    <span class="badge bg-warning text-dark rounded-pill px-3">Ожидает</span>
                                                @elseif($rental->status == 'confirmed')
                                                    <span class="badge bg-success rounded-pill px-3">Одобрено</span>
                                                @else
                                                    <span class="badge bg-danger rounded-pill px-3">Отклонено</span>
                                                @endif
                                            </td>
                                            <td class="pe-4 text-end">
                                                {{-- Обычный юзер может удалить только пока статус pending --}}
                                                <form action="{{ route('rentals.cancel', $rental->id) }}" method="POST"
                                                    onsubmit="return confirm('Вы уверены?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        class="btn btn-sm btn-outline-danger border-0 rounded-pill">Отменить</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                У вас пока нет активных бронирований
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editProfile" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('profile.update') }}" method="POST" class="modal-content rounded-4 border-0 shadow">
            @csrf
            @method('PATCH')
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Настройки профиля</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Имя</label>
                    <input type="text" name="name" class="form-control rounded-3" value="{{ Auth::user()->name }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Телефон</label>
                    <input type="text" name="phone" class="form-control rounded-3" value="{{ Auth::user()->phone }}">
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-dark w-100 rounded-pill py-2">Сохранить изменения</button>
            </div>
        </form>
    </div>
</div>
@endsection