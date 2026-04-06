@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Управление категориями</h2>
        <button type="button" class="btn btn-dark rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addCategory">
            + Новая категория
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th class="ps-4">Название</th>
                    <th>Машин в базе</th>
                    <th class="pe-4 text-end">Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td class="ps-4 fw-bold">{{ $category->name }}</td>
                    <td><span class="badge bg-light text-dark border">{{ $category->cars_count }}</span></td>
                    <td class="pe-4 text-end">
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-link text-danger">Удалить</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addCategory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.categories.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Добавить категорию</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" name="name" class="form-control" placeholder="Например: Электрокары" required>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-primary w-100 rounded-pill">Сохранить</button>
            </div>
        </form>
    </div>
</div>
@endsection