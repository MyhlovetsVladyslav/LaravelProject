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
                <input type="text" name="route" id="route" class="form-control search-input-route" value=" {{ old('route') }}" oninput="handleInputChange()">
                <div class="autocom-box">

                </div>
                @error('route')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="transport">Транспорт:</label>
                <input type="text" name="transport" id="transport" class="form-control" value=" {{ old('transport') }}" list="eventTransport">
                <datalist id="eventTransport"></datalist>
                @error('transport')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>


            <button type="submit" class="btn btn-primary mt-3">Добавить</button>
            <a href="{{ route('admin.trips.index', ['page' => $page]) }}" class="btn btn-secondary mt-3">Вернуться</a>
        </form>
    </div>


@endsection

<script>

    function handleInputChange() {
        let searchInputRoute = document.getElementById('route');
        let selectType = document.getElementById('selectType');
        fetchEvents(searchInputRoute.value, selectType.value);
    }


    function fetchEvents(text, type) {
        if (!text) {
            return;
        }
        $.ajax({
            type: 'GET',
            url: "{{ route('admin.events.search') }}",
            data: {
                text: text,
                type: type
            },
            success: function(events) {
                events.forEach(function(event) {
                    let departure = event.departure_location
                    let arrival = event.arrival_location
                    console.log(departure, arrival)
                });
            },
            error: function(response) {
                console.error(response);
            }
        });
    }



</script>
<style>

</style>
