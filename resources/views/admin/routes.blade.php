@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <h2 class="mb-4">Список маршрутов</h2>
        <a href="{{  route('admin.routes.create')  }}" class="btn btn-primary mb-3">Добавить маршрут</a>
        <div class="table-responsive">
            <table class="table table-bordered">
                <colgroup>
                    <col style="width: 10%;">
                    <col style="width: 10%;">
                    <col style="width: 25%;">
                    <col style="width: 25%;">
                    <col style="width: 10%;">
                    <col style="width: 10%;">
                    <col style="width: 10%;">
                </colgroup>
                <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Тип</th>
                    <th>Отправление</th>
                    <th>Прибытие</th>
                    <th>Дистанция</th>
                    <th>Время пути</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($routes as $key => $route)
                    <tr class="{{ $key % 2 == 0 ? 'even-row' : 'odd-row' }}">
                        <td>{{ $route->id }}</td>
                        <td>{{ $route->type }}</td>
                        <td>{{ $route->routable->departure_location }}</td>
                        <td>{{ $route->routable->arrival_location }}</td>
                        <td>{{ $route->routable->distance }}</td>
                        <td>{{ $route->routable->duration }}</td>
                        <td>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div class="btn-group dropstart">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        . . .
                                    </button>
                                    <ul class="dropdown-menu bg-dark">

                                        <li><a class="dropdown-item text-warning"
                                               href="{{ route('admin.routes.edit',['route' => $route->id]) }}">Редактировать</a>
                                        </li>
                                        <li>
                                            <form
                                                action="{{ route('admin.routes.destroy', ['route' => $route->id]) }}"
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
            {{ $routes->links() }}
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
