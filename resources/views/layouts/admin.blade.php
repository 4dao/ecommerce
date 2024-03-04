<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

    <!-- Header -->
    <header class="admin-header">
        <h1 class="admin-title">Painel de Administração</h1>
        <nav class="admin-nav">
            <ul class="admin-nav-list">
                <li class="admin-nav-item"><a href="#" class="admin-nav-link">Dashboard</a></li>
                <li class="admin-nav-item"><a href="#" class="admin-nav-link">Produtos</a></li>
                <li class="admin-nav-item"><a href="#" class="admin-nav-link">Pedidos</a></li>
                <li class="admin-nav-item"><a href="#" class="admin-nav-link">Usuários</a></li>
            </ul>
        </nav>
    </header>

    @yield('content')

    
</body>
</html>