@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Добавить рейс</h2>
        <form action="{{ route('admin.tickets.store', ['page' => $page]) }}" method="post">
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
                <label for="trip">Рейс:</label>
                <input type="text" name="trip" id="trip" class="form-control search-input-trip" value=" {{ old('trip') }}" oninput="handleInputChangeTrip()">
                <ul id="events-list-trip" class="list-group"></ul>
                <input type="hidden" name="trip_id" id="trip_id">
                @error('trip')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="seat">Место:</label>
                <select name="seat" class="form-control" id="seatSelect">

                </select>
                @error('seat')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="user">Пользователь:</label>
                <input type="text" name="user" id="user" class="form-control search-input-user" value=" {{ old('user') }}" oninput="handleInputChangeUser()">
                <ul id="events-list-user" class="list-group"></ul>
                <input type="hidden" name="user_id" id="user_id">
                @error('user')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-3">Добавить</button>
            <a href="{{ route('admin.tickets.index', ['page' => $page]) }}" class="btn btn-secondary mt-3">Вернуться</a>
        </form>
    </div>

@endsection

<script>
    function fetchEventsTrip(text, type) {
        if (!text) {
            return;
        }
        $.ajax({
            type: 'GET',
            url: "{{ route('admin.events.searchTrip') }}",
            data: {
                text: text,
                type: type
            },
            success: function(events) {
                displayEventsTrip(events);
            },
            error: function (response) {
                console.error(response);
            }
        });
    };
    function fetchEventsUser(text) {
        if (!text) {
            return;
        }
        $.ajax({
            type: 'GET',
            url: "{{ route('admin.events.searchUser') }}",
            data: {
                text: text,
            },
            success: function(events) {
                displayEventsUser(events);
            },
            error: function (response) {
                console.error(response);
            }
        });
    };
    function handleInputChangeTrip() {
        let  trip = document.getElementById('trip_id');
        trip.value = '';
        let searchInputTrip = document.getElementById('trip');
        let selectType = document.getElementById('selectType');
        fetchEventsTrip(searchInputTrip.value, selectType.value);
    }
    function handleInputChangeUser() {
        let  user = document.getElementById('user_id');
        user.value = '';
        let searchInputUser = document.getElementById('user');
        fetchEventsUser(searchInputUser.value);
    }
    function displayEventsUser(events) {
        let eventsList = document.getElementById('events-list-user');
        let user = document.getElementById('user_id');
        eventsList.innerHTML = '';
        console.log(events)
        events.forEach(function (event) {
            let id = event.id
            let name = event.name
            let listItem = document.createElement('li');
            listItem.textContent =  name;
            listItem.classList.add('list-group-item');
            listItem.addEventListener('click', function () {
                let inputRoute = document.getElementById('user');
                inputRoute.value = listItem.textContent;
                user.value = id
                eventsList.innerHTML = '';

            });
            eventsList.appendChild(listItem);
        });
    }
    function displayEventsTrip(events) {
        let eventsList = document.getElementById('events-list-trip');
        let trip = document.getElementById('trip_id');
        let seatSelect = document.getElementById('seatSelect');
        eventsList.innerHTML = '';
        seatSelect.innerHTML = '';
        console.log(events)
        events.forEach(function (event) {
            let id = event.id
            let departure_location = event.route.routable.departure_location
            let arrival_location = event.route.routable.arrival_location
            let type = event.route.type;
            let listItem = document.createElement('li');
            listItem.textContent = departure_location + '  -  ' + arrival_location;
            listItem.classList.add('list-group-item');
            listItem.addEventListener('click', function () {
                let inputRoute = document.getElementById('trip');
                inputRoute.value = listItem.textContent;
                trip.value = id
                eventsList.innerHTML = '';
                let optionGroup = document.createElement('optgroup');
                optionGroup.label = `${departure_location} - ${arrival_location}`;
                seatSelect.appendChild(optionGroup);

                event.transport.transportable.seats.forEach(function (seats) {
                    let option = document.createElement('option');
                    if (type === 'train') {
                        option.textContent = `${seats.carriage_type} ${seats.carriage_number}, место ${seats.seat_number}`;
                    }else if(type === 'plane'){
                        option.textContent = `Место ${seats.seat_number}`;
                    }else {
                        option.textContent = `Место ${seats.seat_number}`;
                    }
                    option.value = seats.seat.id;
                    optionGroup.appendChild(option);

                });

            });
            eventsList.appendChild(listItem);
        });
        seatSelect.addEventListener('change', function () {

            console.log('Выбрано место с ID:', this.value);
        });
    }
</script>
<style>
    .list-group-item:hover {
        background-color: #f0f0f0;
        cursor: pointer;
    }

</style>
