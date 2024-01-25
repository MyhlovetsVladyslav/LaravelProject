@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Добавить пользователя</h2>
        <form action="{{ route('admin.users.store') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="name">Имя:</label>
                <input type="text" name="name" class="form-control" value=" {{ old('name',$user->name) }}">
                @error('name')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" name="email" class="form-control" value="{{ old('email',$user->email) }}">
                @error('email')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="text" name="password" class="form-control">
                @error('password')
                <p class="alert alert-danger mt-2" >{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-3">Добавить</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">Вернуться</a>
        </form>
    </div>
@endsection
