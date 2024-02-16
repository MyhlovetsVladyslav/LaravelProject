@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <h2 class="mb-4">Список рейсов</h2>
        <a href="{{ route('admin.trips.create',['page' => $page]) }}" class="btn btn-primary mb-3">Добавить рейс</a>

        <div class="table-responsive">
            <table class="table table-bordered">
                <colgroup>
                    <col style="width: 5%;">
                    <col style="width: 30%;">
                    <col style="width: 30%;">
                    <col style="width: 5%;">
                    <col style="width: 15%;">
                    <col style="width: 15%;">
                    <col style="width: 5%;">
                </colgroup>
                <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Место отправления</th>
                    <th>Место прибытия</th>
                    <th>Транспорт</th>
                    <th>Время отправления</th>
                    <th>Время прибытия</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($trips as $key => $trip)
                    <tr class="{{ $key % 2 == 0 ? 'even-row' : 'odd-row' }}">
                        <td>{{ $trip->id }}</td>
                        <td>{{ $trip->route->routable->departure_location }}</td>
                        <td>{{ $trip->route->routable->arrival_location }}</td>
                        <td>{{ $trip->transport->transportable->number }}</td>
                        <td>{{ $trip->departure_time }}</td>
                        <td>{{ $trip->arrival_time }}</td>
                        <td>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div class="btn-group dropstart">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        . . .
                                    </button>
                                    <ul class="dropdown-menu bg-dark">
                                        <li><a class="dropdown-item text-warning"
                                               href="">Редактировать</a>
                                        </li>
                                        <li>
                                            <form
                                                action=""
                                                method="post" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                        onclick="return confirm('Вы уверены?')">Удалить
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>


                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>


        <div class="d-flex justify-content-center mt-4">
            {{ $trips->links() }}
        </div>
    </div>

    <style>
        .even-row {
            background-color: #f2f2f2;
        }

        .odd-row {
            background-color: #ffffff;
        }
    </style>
@endsection
