@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h2 class="fw-bold mb-4">Создать аккаунт</h2>

                @if ($errors->any())
                    <div class="alert alert-danger border-0 mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label small text-secondary">ФИО</label>
                        <input type="text" name="name" class="form-control rounded-pill px-3" 
                               value="{{ old('name') }}" placeholder="Имя Фамилия" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-secondary">Телефон</label>
                        <input type="text" name="phone" class="form-control rounded-pill px-3" 
                               value="{{ old('phone') }}" placeholder="+7 707..." required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-secondary">Email</label>
                        <input type="email" name="email" class="form-control rounded-pill px-3" 
                               value="{{ old('email') }}" autocomplete="new-password" 
                               placeholder="example@mail.com" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small text-secondary">Пароль</label>
                        <input type="password" name="password" class="form-control rounded-pill px-3" 
                               autocomplete="new-password" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">
                        Зарегистрироваться
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="small text-secondary">Уже есть аккаунт? 
                        <a href="{{ route('login') }}" class="text-primary text-decoration-none">Войти</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection