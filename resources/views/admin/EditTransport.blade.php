@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2 class="mb-4">Редактирование транспорта: {{ $transport->name }}</h2>
        <form action="{{ route('admin.transports.update', ['transport' => $transport->id]) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="number">Номер:</label>
                <input type="text" name="number" class="form-control" value=" {{ old('number',$transport->transportable->number) }}">
                @error('number')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-3">Редактировать</button>
            <a href="{{ route('admin.transports.index') }}" class="btn btn-secondary mt-3">Вернуться</a>
        </form>
    </div>
@endsection
