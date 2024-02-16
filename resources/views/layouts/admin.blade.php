<!-- resources/views/layouts/admin.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/bootstrap/css/bootstrap.css','resources/bootstrap/js/bootstrap.bundle.js'])
    <title>Admin Panel</title>
    <!-- Add your stylesheets and scripts here -->

</head>
<body>
<header>
</header>
<div class="row">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sidebar">
        <a href="{{ route('admin.dashboard') }}" class="navbar-brand p-3">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        @auth()
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.users.index') }}">Пользователи</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.transports.index') }}">Транспорты</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.routes.index') }}">Маршруты</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.trips.index') }}">Рейсы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.tickets.index') }}">Билеты</a>
                </li>
            </ul>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="post" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger m-2"
                                    onclick="return confirm('Вы уверены?')">Выход
                            </button>
                        </form>
                    </li>

            </ul>
        </div>
        @endauth
    </nav>

    <main>

        <div class="container-fluid">
            @yield('content')
        </div>
    </main>
</div>
<footer>
    <!-- Add your footer content here -->
</footer>
<script>
    setTimeout(function () {
        let successAlert = document.getElementById('success-alert');
        if (successAlert) {
            successAlert.style.opacity = '0';
            setTimeout(function () {
                successAlert.style.display = 'none';
            }, 600);
        }
    }, 5000);
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</body>
</html>
