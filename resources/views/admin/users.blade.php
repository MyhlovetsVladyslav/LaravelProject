@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <h2 class="mb-4">Список пользователей</h2>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">Добавить пользователя</a>
        <div class="table-responsive">
            <table class="table table-bordered">
                <colgroup>
                    <col style="width: 25%;">
                    <col style="width: 25%;">
                    <col style="width: 25%;">
                    <col style="width: 25%;">
                </colgroup>
                <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Роль</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $key => $user)
                    <tr class="{{ $key % 2 == 0 ? 'even-row' : 'odd-row' }}">
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span>{{ $user->role }}</span>
                                <div>
                                    <a href="{{ route('admin.users.edit', ['user' => $user->id]) }}" class="btn btn-warning btn-sm">Редактировать</a>
                                    <form action="{{ route('admin.users.destroy', ['user' => $user->id]) }}" method="post" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm m-2" onclick="return confirm('Вы уверены?')">Удалить</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>


        <div class="d-flex justify-content-center mt-4">
            {{ $users->links() }}
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
