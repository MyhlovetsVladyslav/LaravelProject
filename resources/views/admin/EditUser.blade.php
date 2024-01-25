@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Редактирование пользователя: {{ $user->name }}</h2>

        <form action="{{ route('admin.users.update', ['user' => $user->id]) }}" method="post">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Имя:</label>
                <input type="text" name="name" class="form-control" value="{{ old('name',$user->name) }}">
                @error('name')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="email">Email:</label>
                <input type="text" name="email" class="form-control" value="{{ old('email',$user->email) }}">
                @error('email')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="role">Role:</label>
                <select name="role" class="form-select">
                    <option value="user" {{ (old('role', $user->role) == 'user') ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ (old('role', $user->role) == 'admin') ? 'selected' : '' }}>Admin</option>
                </select>

            </div>

            <button type="submit" class="btn btn-primary mt-5">Сохранить изменения</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-5">Вернуться</a>
        </form>
    </div>
@endsection
