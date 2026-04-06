@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h3 class="fw-bold mb-4 text-center">Вход в систему</h3>
                
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="small fw-bold">Email</label>
                        <input type="email" name="email" class="form-control rounded-3" placeholder="admin@test.com" required>
                    </div>
                    <div class="mb-4">
                        <label class="small fw-bold">Пароль</label>
                        <input type="password" name="password" class="form-control rounded-3" required>
                    </div>
                    <button type="submit" class="btn btn-dark w-100 rounded-pill py-2 fw-bold">Войти</button>
                </form>
                
                <div class="mt-4 text-center">
                    <p class="small text-muted">Нет аккаунта? Обратитесь к администратору.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection