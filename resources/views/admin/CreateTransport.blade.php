@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Добавить транспорт</h2>
        <form action="{{ route('admin.transports.store') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="number">Номер:</label>
                <input type="text" name="number" class="form-control" value=" {{ old('number',$transport->number) }}">
                @error('number')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="type">Тип:</label>
                <select name="type" class="form-control" id="typeSelect" required>
                    <option value="train" @if(old('type', $transport->type) === 'train') selected @endif>Поезд</option>
                    <option value="bus" @if(old('type', $transport->type) === 'bus') selected @endif>Автобус</option>
                    <option value="plane" @if(old('type', $transport->type) === 'plane') selected @endif>Самолет</option>
                </select>
                @error('type')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mt-3" id="subtypeFields">
                <div class="subtypeFields trainFields passenger intercity">
                    <label for="train_type">Подтип:</label>
                    <select name="train_type" id="train_type" class="form-control" required>
                        <option value="passenger"
                                @if(old('train_type', $transport->train_type) === 'passenger') selected @endif>Пассажирский
                        </option>
                        <option value="intercity"
                                @if(old('train_type', $transport->train_type) === 'intercity') selected @endif>Интерсити
                        </option>
                    </select>
                </div>
                @error('subtype')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-3">Добавить</button>
            <a href="{{ route('admin.transports.index',['page' => $page]) }}" class="btn btn-secondary mt-3">Вернуться</a>
        </form>
    </div>
    <script>
            updateFields();

            document.getElementById('typeSelect').addEventListener('change', function() {
                updateFields();
            });

            document.getElementById('train_type').addEventListener('change', function() {
                updateFields();
            });

        function updateFields() {
            let selectedType = document.getElementById('typeSelect').value;

            // Скрываем все поля вагонов
            let trainTypeFields = document.querySelectorAll('.trainFields');
            trainTypeFields.forEach(function(trainTypeField) {
                trainTypeField.style.display = 'none';
            });

            let planeFields = document.querySelectorAll('.planeFields');
            planeFields.forEach(function(planeField) {
                planeField.style.display = 'none';
            });

            // Скрываем все поля для автобусов
            let busFields = document.querySelectorAll('.busFields');
            busFields.forEach(function(busField) {
                busField.style.display = 'none';
            });
            // Показываем только выбранные поля вагонов

            if (selectedType === 'train') {
                let selectedTypeTrain = document.querySelectorAll('.' + selectedType + 'Fields');
                selectedTypeTrain.forEach(function(field) {
                    field.style.display = 'block';
                });
            } else if(selectedType === 'bus') {
                let selectedTypeBus = document.querySelectorAll('.' + selectedType + 'Fields');
                selectedTypeBus.forEach(function(field) {
                    field.style.display = 'block';
                });
            } else{
                let selectedTypePlane = document.querySelectorAll('.' + selectedType + 'Fields');
                selectedTypePlane.forEach(function(field) {
                    field.style.display = 'block';
                });
            }
        }
    </script>



@endsection
