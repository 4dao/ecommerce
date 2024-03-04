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
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body>

    <!-- Header -->
    <header class="custom-header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        @auth
                        <li class="nav-item ">
                            <a class="nav-link" href="/"><ion-icon name="home-outline"></ion-icon></a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="/purchase"><ion-icon name="apps-outline"></ion-icon></a>
                        </li>
                            @can ('access-admin') 
                                <li class="nav-item">
                                    <a class="nav-link" href="/dashboard"><ion-icon name="person-outline"></ion-icon></a>
                                </li>
                            @endcan

                            <li class="nav-item">
                                <button type="button" id="car" class="btn " data-toggle="modal" data-target="#exampleModalCenter">
                                    <ion-icon name="cart-outline"></ion-icon>
                                  </button>
                            </li>
                        @endauth
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="/login">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/register">Cadastro</a>
                            </li>
                        @endguest
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <!-- Button trigger modal -->

  
  <!-- Modal -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Meu Carrinho</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="display: flex; flex-direction: column; justify-content: center;" >


        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                </tr>
            </thead>
            <tbody> 
            @auth
                @if ($car) 
                    @foreach ($car as $item) 
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->product->name}}</td>
                            <td>{{$item->quantity}}</td>
                            <td>{{$item->price}}</td>
                        </tr>
         
                    @endforeach
                @endif
            @endauth
                <!-- Adicione mais linhas conforme necessário -->
            </tbody>
        </table>


        </div>
        <div class="modal-footer">
            <a href="/finish" class="btn btn-primary">Finalizar Compra</a>
        </div>
      </div>
    </div>
  </div>

    @yield('content')


    <!-- Rodapé -->
    <footer class="container mt-4">
        <p>&copy; 2024 Seu E-commerce. Todos os direitos reservados.</p>
    </footer>
    
</body>
</html>