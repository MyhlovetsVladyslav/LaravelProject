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
    <!-- Add your header content here -->
</header>
<div class="row">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sidebar">
        <p class="navbar-brand p-3">Admin Panel</p>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
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
</body>
</html>
