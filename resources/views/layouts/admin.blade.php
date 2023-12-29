<!-- resources/views/layouts/admin.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/bootstrap/css/bootstrap.css','resources/bootstrap/js/bootstrap.js'])
    <title>Admin Panel</title>
    <!-- Add your stylesheets and scripts here -->

</head>
<body>
<header>
    <!-- Add your header content here -->
</header>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Admin Panel</a>
</nav>

<main>
    <div class="container-fluid">
        @yield('content')
    </div>
</main>

<footer>
    <!-- Add your footer content here -->
</footer>
</body>
</html>
