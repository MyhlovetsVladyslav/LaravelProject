@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Редактировать место</h2>
        <form action="{{ route('admin.transports.carriage.update', ['train_id' => $train_id,'carriage_id'=> $carriage_id, 'seat' => $seat->id]) }}" method="post">
            @csrf
            @method('put')
            <div class="form-group">
                <label for="seat_number">Номер места:</label>
                <input type="text" name="seat_number" class="form-control" value=" {{ old('seat_number',$seat->seat_number) }}">
                @error('seat_number')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-3">Добавить</button>
            <a href="{{ route('admin.transports.carriage.index', ['train_id' => $train_id, 'carriage_id' => $carriage_id]) }}" class="btn btn-secondary mt-3">Вернуться</a>
        </form>
    </div>


@endsection
