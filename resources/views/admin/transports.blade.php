@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <h2 class="mb-4">Список транспортов</h2>
        <a href="{{ route('admin.transports.create') }}" class="btn btn-primary mb-3">Добавить транспорт</a>

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
                    <th>Тип</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($transports as $key => $transport)
                    <tr class="{{ $key % 2 == 0 ? 'even-row' : 'odd-row' }}">
                        <td>{{ $transport->id }}</td>
                        <td>{{ $transport->transportable->number }}</td>
                        <td>{{ $transport->type }} @if($transport->transportable->type) / {{ $transport->transportable->type  }} @endif</td>
                        <td>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div class="dropdown">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Действия
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @if($transport->transportable_type === 'App\Models\Train')
                                            <li><a class="dropdown-item" href="{{ route('admin.transports.train.create', ['train_id' => $transport->transportable->id, 'train_type' => $transport->transportable->type]) }}">Добавить вагон</a></li>
                                        @endif
                                        <li><a class="dropdown-item" href="{{ route('admin.transports.edit', ['transport' => $transport->id]) }}">Редактировать</a></li>
                                        <li>
                                            <form action="{{ route('admin.transports.destroy', ['transport' => $transport->id]) }}" method="post" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item" onclick="return confirm('Вы уверены?')">Удалить</button>
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
            {{ $transports->links() }}
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
