@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Добавить маршрут</h2>
        <form action="{{ route('admin.routes.store') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="type">Тип транспорта:</label>
                <select class="form-control mb-3" name="type">
                    <option value="train">Поезд</option>
                    <option value="bus">Автобус</option>
                    <option value="plane">Cамолет</option>
                </select>
            </div>
            <div class="form-group">
                <label for="departure_location">Место отправления:</label>
                <input type="text" name="departure_location" class="form-control" id="departure-input" value="{{ old('departure_location') }}">
                @error('departure_location')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mt-5">
                <label for="arrival_location">Место прибытия:</label>
                <input type="text" name="arrival_location" class="form-control" id="arrival-input" value="{{ old('arrival_location') }}">
                @error('arrival_location')
                <p class="alert alert-danger mt-2">{{ $message }}</p>
                @enderror
            </div>
            <input type="hidden" name="distance" id="Distance-hidden">
            <input type="hidden" name="duration" id="Duration-hidden">
            <button type="submit" id="button" class="btn btn-primary mt-3">Добавить</button>
            <a href="{{ route('admin.routes.index') }}" class="btn btn-secondary mt-3">Вернуться</a>
        </form>
    </div>
@endsection


<script>

    function calculateDistanceAndTime() {
        const departure = document.getElementById('departure-input').value;
        const arrival = document.getElementById('arrival-input').value;
        const distanceHidden = document.getElementById('Distance-hidden');
        const durationHidden = document.getElementById('Duration-hidden');
        const directionsService = new google.maps.DirectionsService();

        directionsService.route(
            {
                origin: departure,
                destination: arrival,
                travelMode: 'DRIVING'
            },
            (response, status) => {
                if (status === 'OK') {
                    const route = response.routes[0];
                    distanceHidden.value = route.legs[0].distance.text;
                    durationHidden.value = route.legs[0].duration.text;
                } else {
                    console.log('Directions request failed due to ' + status);
                }
            }
        );
    }


    function initMap() {
        const departureInput = document.getElementById('departure-input');
        const arrivalInput = document.getElementById('arrival-input');
        function initAutocomplete(input) {
            const autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.addListener('place_changed', () => {
                const place = autocomplete.getPlace();
                if (!place.geometry || !place.geometry.location) {
                    input.value = '';
                    return;
                }
                input.value = place.formatted_address;
            });
        }

        departureInput.addEventListener('input', function() {
            if (this.value.length > 2) {
                setTimeout(() => {
                    initAutocomplete(departureInput);
                }, 300);
            }
            if(departureInput.value !== '' && arrivalInput.value !== ''){
                calculateDistanceAndTime();
            }
        });

        arrivalInput.addEventListener('input', function() {
            if (this.value.length > 2) {
                setTimeout(() => {
                    initAutocomplete(arrivalInput);
                }, 300);
            }
            if(departureInput.value !== '' && arrivalInput.value !== ''){
                calculateDistanceAndTime();
            }
        });




    }

</script>


