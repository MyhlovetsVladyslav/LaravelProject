@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <h2 class="mb-4">Список мест вагона {{ $carriage_number }}</h2>
        <a href="{{ route('admin.transports.train.index',['train_id' => $train_id]) }}" class="btn btn-secondary mb-3 ">Вернуться</a>

        <div class="table-responsive">
            <table class="table table-bordered">
                <colgroup>
                    <col style="width: 33%;">
                    <col style="width: 33%;">
                    <col style="width: 33%;">
                </colgroup>
                <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Номер</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($seats as $key => $seat)
                    <tr class="{{ $key % 2 == 0 ? 'even-row' : 'odd-row' }}">
                        <td>{{ $seat->id }}</td>
                        <td>{{ $seat->seat_number }}</td>
                        <td>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div class="btn-group dropstart">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        . . .
                                    </button>
                                    <ul class="dropdown-menu bg-dark">
                                        <li><a class="dropdown-item text-warning"
                                               href="{{ route('admin.transports.carriage.edit', ['train_id' => $train_id,'carriage_id'=> $carriage_id,'seat' => $seat->id]) }}">Редактировать</a>
                                        </li>
                                        <li>
                                            <form
                                                action="{{ route('admin.transports.carriage.destroy', ['train_id' => $train_id,'carriage_id'=> $carriage_id,'seat' => $seat->id]) }}"
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
            {{ $seats ->links() }}
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
