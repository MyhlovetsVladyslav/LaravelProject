@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Добавить рейс</h2>
        <form action="{{ route('admin.trips.store', ['page' => $page]) }}" method="post">
            @csrf
            <div class="form-group mt-3 mb-3">
                <label for="type">Тип транспорта:</label>
                <select name="type" class="form-control" id="selectType" required>
                    <option value="bus" @if(old('type') === 'bus') selected @endif>
                        Автобус
                    </option>
                    <option value="train" @if(old('type') === 'train') selected @endif>Поезд
                    </option>
                    <option value="plane" @if(old('type') === 'plane') selected @endif>Самолет</option>
                </select>
                @error('type')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="route">Маршрут:</label>
                <a href="" target="_blank" hidden></a>
                <input type="text" name="route" id="route" class="form-control search-input-route" value=" {{ old('route') }}" oninput="handleInputChangeRoutes()">
                <ul id="events-list-route" class="list-group"></ul>

                @error('route')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="transport">Транспорт:</label>
                <input type="text" name="transport" id="transport" class="form-control" value=" {{ old('transport') }}" oninput="handleInputChangeTransports()">
                <ul id="events-list-transport" class="list-group"></ul>
                @error('transport')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="date_departure">Дата отправления:</label>
                <input type="datetime-local"  min="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}"
                       name="date_departure" id="date_departure" class="form-control"
                       value=" {{ old('date_departure') }}">
                @error('date_departure')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mt-3 trainFields passenger intercity">
                <div class="form-group mt-3 trainFields passenger">
                    <label for="price_platskart">Цена за плацкарт: </label>
                    <input type="text" name="price_platskart" id="price_platskart" class="form-control search-input-route" value=" {{ old('price_platskart') }}">
                    @error('price_platskart')
                    <p class="alert alert-danger mt-2">{{ $message }}</p>
                    @enderror
                    <label for="price_coupe">Цена за купе: </label>
                    <input type="text" name="price_coupe" id="price_coupe" class="form-control search-input-route" value=" {{ old('price_coupe') }}">
                    @error('price_coupe')
                    <p class="alert alert-danger mt-2">{{ $message }}</p>
                    @enderror
                    <label for="price_lux">Цена за люкс: </label>
                    <input type="text" name="price_lux" id="price_lux" class="form-control search-input-route" value=" {{ old('price_lux') }}">
                    @error('price_lux')
                    <p class="alert alert-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group mt-3 trainFields intercity">
                    <label for="price_first_class">Цена за первый класс: </label>
                    <input type="text" name="price_first_class" id="price_first_class" class="form-control" value=" {{ old('price_first_class') }}">
                    @error('price_first_class')
                    <p class="alert alert-danger mt-2">{{ $message }}</p>
                    @enderror
                    <label for="price_second_class">Цена за второй класс: </label>
                    <input type="text" name="price_second_class" id="price_second_class" class="form-control" value=" {{ old('price_second_class') }}">
                    @error('price_second_class')
                    <p class="alert alert-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-group mt-3 busFields">
                <label for="price_bus">Цена за место: </label>
                <input type="text" name="price_bus" id="price_bus" class="form-control" value=" {{ old('price_bus') }}">
                @error('price_bus')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mt-3 planeFields">
                <label for="price_econom">Цена за эконом: </label>
                <input type="text" name="price_econom" id="price_econom" class="form-control" value=" {{ old('price_econom') }}">
                @error('price_econom')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
                <label for="price_comfort">Цена за комфорт: </label>
                <input type="text" name="price_comfort" id="price_comfort" class="form-control" value=" {{ old('price_comfort') }}">
                @error('price_comfort')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
                <label for="price_bisness">Цена за бизнесс: </label>
                <input type="text" name="price_bisness" id="price_bisness" class="form-control" value=" {{ old('price_bisness') }}">
                @error('price_bisness')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>
            <input type="hidden" id="subType" name="subType" value="{{ old('subType') }}">
            <input type="hidden" id="duration" name="duration" value="{{ old('duration') }}">
            <input type="hidden" name="date_arrival" id="date_arrival" class="form-control"
                   value=" {{ old('date_arrival') }}">
            <button type="submit" class="btn btn-primary mt-3">Добавить</button>
            <a href="{{ route('admin.trips.index', ['page' => $page]) }}" class="btn btn-secondary mt-3">Вернуться</a>
        </form>
    </div>

@endsection

<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.getElementById('selectType').addEventListener('change', function () {
            let durationInput = document.getElementById('duration');
            let dateArrival = document.getElementById('date_arrival');
            let dateDeparture = document.getElementById('date_departure');
            let searchInputRoute = document.getElementById('route');
            let searchInputTransport = document.getElementById('transport');
            searchInputRoute.value = '';
            searchInputTransport.value = '';
            durationInput.value = '';
            dateArrival.value = '';
            dateDeparture.value = '';
            updateFields();
        })
        document.getElementById('transport').addEventListener('change', function () {
            setTimeout(() => {
                updateFields();
            }, "100");
        })
        document.getElementById('transport').addEventListener('input', function () {
            let subType = document.getElementById('subType');
            setTimeout(() => {
                updateFields();
            }, 100);
            subType.value = ''
        });
        document.getElementById('date_departure').addEventListener('input', function () {
            createDateArrival()
        })
        updateFields();

        function updateFields() {
            let selectType = document.getElementById('selectType').value;
            let subType = document.getElementById('subType');
            console.log(subType.value)
            let trainTypeFields = document.querySelectorAll('.trainFields');
            trainTypeFields.forEach(function (trainTypeField) {
                trainTypeField.style.display = 'none';
            });

            let planeFields = document.querySelectorAll('.planeFields');
            planeFields.forEach(function (planeField) {
                planeField.style.display = 'none';
            });

            // Скрываем все поля для автобусов
            let busFields = document.querySelectorAll('.busFields');
            busFields.forEach(function (busField) {
                busField.style.display = 'none';
            });
            // Показываем только выбранные поля вагонов

            if (selectType === 'train') {
                let selectedTypeTrain = document.querySelectorAll('.' + selectType + 'Fields');
                selectedTypeTrain.forEach(function (field) {
                    if (subType.value === 'passenger') {
                        if (field.classList.contains('passenger')) {
                            field.style.display = 'block';
                        } else {
                            field.style.display = 'none';
                        }
                    } else if (subType.value === 'intercity') {
                        if (field.classList.contains('intercity')) {
                            field.style.display = 'block';
                        } else {
                            field.style.display = 'none';
                        }
                    }
                });
            } else if (selectType === 'bus') {
                let selectedTypeBus = document.querySelectorAll('.' + selectType + 'Fields');
                selectedTypeBus.forEach(function (field) {
                    field.style.display = 'block';
                });
            } else {
                let selectedTypePlane = document.querySelectorAll('.' + selectType + 'Fields');
                selectedTypePlane.forEach(function (field) {
                    field.style.display = 'block';
                });
        }
    }
    });

    function handleInputChangeRoutes() {
        let searchInputRoute = document.getElementById('route');
        let selectType = document.getElementById('selectType');
        fetchEventsRoutes(searchInputRoute.value, selectType.value);
    }
    function handleInputChangeTransports() {
        let searchInputTransport = document.getElementById('transport');
        let selectType = document.getElementById('selectType');
        fetchEventsTransports(searchInputTransport.value, selectType.value);
    }
    function displayEventsRoutes(events) {
        let eventsList = document.getElementById('events-list-route');
        eventsList.innerHTML = '';
        events.forEach(function(event) {
            let durationInput = document.getElementById('duration');
            let departure = event.routable.departure_location;
            let arrival = event.routable.arrival_location;
            let duration = event.routable.duration;
            let id = event.id;
            let listItem = document.createElement('li');
            listItem.textContent = id + ' | ' + departure + '  -  ' + arrival;
            listItem.classList.add('list-group-item');
            listItem.addEventListener('click', function() {
                let inputRoute = document.getElementById('route');
                durationInput.value = duration
                inputRoute.value = listItem.textContent;
                eventsList.innerHTML = '';
            });
            eventsList.appendChild(listItem);
        });
    }

    function createDateArrival(){
        let dateArrival = document.getElementById('date_arrival');
        let durationInput = document.getElementById('duration').value;
        let dateDeparture = document.getElementById('date_departure').value;
        console.log(dateDeparture,durationInput)
        let departureDate = new Date(dateDeparture);
        let matches = durationInput.match(/(\d+)\s*ч(?:ас?)?\.\s*(\d+)\s*мин\./);
        if (matches) {
            let hours = parseInt(matches[1]); // Получаем часы
            let minutes = parseInt(matches[2]); // Получаем минуты

            // Выполняем необходимые вычисления
            let arrivalDate = new Date(departureDate.getTime()); // Копируем дату отправления
            console.log(arrivalDate)
            arrivalDate.setHours(arrivalDate.getHours() + hours); // Добавляем часы
            arrivalDate.setMinutes(arrivalDate.getMinutes() + minutes); // Добавляем минуты
            dateArrival.value = arrivalDate.getFullYear() + '-' +
                ('0' + (arrivalDate.getMonth() + 1)).slice(-2) + '-' +
                ('0' + arrivalDate.getDate()).slice(-2) + ' ' +
                ('0' + arrivalDate.getHours()).slice(-2) + ':' +
                ('0' + arrivalDate.getMinutes()).slice(-2) + ':' +
                ('0' + arrivalDate.getSeconds()).slice(-2);
        }
    }

    function displayEventsTransports(events) {
        let eventsList = document.getElementById('events-list-transport');
        eventsList.innerHTML = '';
        events.forEach(function(event) {
            let number = event.transportable.number;
            let type = event.transportable.type ? event.transportable.type : null;
            let id = event.id;
            let listItem = document.createElement('li');
            if (type === null) {
                listItem.textContent = id + ' | ' + ' Номер ' + number;
            } else {
                listItem.textContent = id + ' | ' + ' Номер ' + number + ' | ' +  ' Тип  ' + type;
            }
            listItem.classList.add('list-group-item');
            listItem.addEventListener('click', function () {
                let inputRoute = document.getElementById('transport');
                let subType = document.getElementById('subType');
                inputRoute.value = listItem.textContent;
                if(type !== null) {
                    subType.value = listItem.textContent.match(/Тип\s+(\w+)/)[1];
                }
                eventsList.innerHTML = '';
            });
            eventsList.appendChild(listItem);
        });
    }

    function fetchEventsRoutes(text, type) {
        if (!text) {
            return;
        }
        $.ajax({
            type: 'GET',
            url: "{{ route('admin.events.searchRoutes') }}",
            data: {
                text: text,
                type: type
            },
            success: function(events) {
                displayEventsRoutes(events);
            },
            error: function(response) {
                console.error(response);
            }
        });
    };
    function fetchEventsTransports(text, type) {
        if (!text) {
            return;
        }
        $.ajax({
            type: 'GET',
            url: "{{ route('admin.events.searchTransports') }}",
            data: {
                text: text,
                type: type
            },
            success: function(events) {
                displayEventsTransports(events);
            },
            error: function(response) {
                console.error(response);
            }
        });
    };


</script>
<style>
    .list-group-item:hover {
        background-color: #f0f0f0;
        cursor: pointer;
    }

</style>
