@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Редактировать вагон</h2>
        <form action="{{ route('admin.transports.train.update', ['train_id' => $train_id, 'carriage' => $carriage]) }}" method="post">
            @csrf
            @method('put')
            <div class="form-group">
                <label for="number">Номер вагона:</label>
                <input type="text" name="number" class="form-control" value=" {{ old('number', $carriage->number) }}">
                @error('number')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="type">Тип вагона:</label>
                @if($type === 'passenger')
                    <select name="type" class="form-control" id="typeSelect" required>
                        <option value="platskart" @if(old('type', $carriage->type) === 'platskart') selected @endif>
                            Плацкарт
                        </option>
                        <option value="сoupe" @if(old('type', $carriage->type) === 'сoupe') selected @endif>Купе
                        </option>
                        <option value="lux" @if(old('type', $carriage->type) === 'lux') selected @endif>Люкс</option>
                    </select>
                @else
                    <select name="type" class="form-control" id="typeSelect" required>
                        <option value="first_class" @if(old('type', $carriage->type) === 'first_class') selected @endif>
                            Первый класс
                        </option>
                        <option value="second_class"
                                @if(old('type', $carriage->type) === 'second_class') selected @endif>Второй класс
                        </option>
                    </select>
                @endif
                @error('type')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>


            <button type="submit" class="btn btn-primary mt-3">Редактировать</button>
            <a href="{{ route('admin.transports.train.index', ['train_id' => $train_id]) }}" class="btn btn-secondary mt-3">Вернуться</a>
        </form>
    </div>


@endsection
