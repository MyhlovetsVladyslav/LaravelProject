@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2 class="mb-4">Редактирование пользователя: {{ $transport->name }}</h2>
        <form action="{{ route('admin.transports.update', ['transport' => $transport->id]) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="number">Номер:</label>
                <input type="text" name="number" class="form-control" value=" {{ old('number',$transport->number) }}">
                @error('number')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="type">Тип:</label>
                <select name="type" class="form-control" required>
                    <option value="train" @if(old('type', $transport->type) === 'train') selected @endif>Поезд</option>
                    <option value="bus" @if(old('type', $transport->type) === 'bus') selected @endif>Автобус</option>
                    <option value="plane" @if(old('type', $transport->type) === 'plane') selected @endif>Самолет</option>
                </select>
                @error('type')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="status">Статус:</label>
                <select name="status" class="form-control" required>
                    <option value="active" @if(old('status', $transport->status) === 'active') selected @endif>Активный</option>
                    <option value="disabled" @if(old('status', $transport->status) === 'disabled') selected @endif>Отключен</option>
                    <option value="repair" @if(old('status', $transport->status) === 'old') selected @endif>Ремонт</option>
                </select>
                @error('type')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-3">Добавить</button>
            <a href="{{ route('admin.transports.index') }}" class="btn btn-secondary mt-3">Вернуться</a>
        </form>
    </div>
@endsection
