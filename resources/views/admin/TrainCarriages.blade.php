@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <h2 class="mb-4">Список вагонов</h2>
        <a href="{{ route('admin.trains.transport.create') }}" class="btn btn-primary mb-3">Добавить вагон</a>

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

            </table>
        </div>


        <div class="d-flex justify-content-center mt-4">
            {{ $trainCarriages ->links() }}
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
