<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Prandium</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/-Login-form-Page-BS4-.css">
    <link rel="stylesheet" href="assets/css/info-box.css">
    <link rel="stylesheet" href="assets/css/Table-With-Search-1.css">
    <link rel="stylesheet" href="assets/css/Table-With-Search.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
</head>

<body id="page-top" class="sidebar-toggled">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0 toggled" style="background: rgb(78, 115, 223);">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon rotate-n-15"><i class="fa fa-gittip"></i></div>
                    <div class="sidebar-brand-text mx-3"><span>sysvent</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="{{route('home')}}" style="font-size: 14.4px;"><i class="fas fa-tachometer-alt"></i><span>Home</span></a></li>
                    
                    <li class="nav-item"><a class="nav-link" href="{{route('padre_hijo')}}" style="font-size: 13.4px;"><i class="fa fa-users"></i><span>Padres/Hijos</span></a></li>
                    <li class="nav-item"><a class="nav-link" target="_blank" href="{{route('deudaspendientes')}}" style="font-size: 14.4px;"><i class="fas fa-money-bill-wave"></i><span>Deudas Pendientes</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('platos')}}" style="font-size: 14.4px;"><i class="fas fa-ring"></i><span>Platos</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('pedidos')}}" style="font-size: 13.4px;"><i class="fas fa-truck-loading"></i><span>Pedidos Padres</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('pedidosprofesor')}}" style="font-size: 13.4px;"><i class="fas fa-users"></i><span>Pedidos Profesores</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('pedidosadmin')}}" style="font-size: 13.4px;"><i class="fas fa-truck-loading"></i><span>Ingresar Pedido</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('menu')}}" style="font-size: 14.4px;"><i class="fas fa-table"></i><span>Menú</span></a></li>
                    <li class="nav-item"><a class="nav-link" target="_blank" href="{{route('recarga')}}" style="font-size: 14.4px;"><i class="fas fa-money-bill-wave"></i><span>Recargas</span></a></li>
                    <li class="nav-item"><a class="nav-link" target="_blank" href="{{route('reportes')}}" style="font-size: 14.4px;"><i class="fa fa-file-pdf-o"></i><span>Reportes</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('perfil')}}" style="font-size: 14.4px;"><i class="fas fa-user"></i><span>Perfil</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}"
                                         onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();"  style="font-size: 14.4px;"><i class="fas fa-door-closed"></i><span>Salir</span></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                    </form>                
                    </li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><i class="fas fa-search"></i></a>
                                <div class="dropdown-menu dropdown-menu-end p-3 animated--grow-in" aria-labelledby="searchDropdown">
                                    <form class="me-auto navbar-search w-100">
                                        <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                            <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            
                           
                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">
                                    <span class="d-none d-lg-inline me-2 text-gray-600 small">
                                        @auth
                                            {{ Auth::user()->name }}<br>{{ Auth::user()->rol }}
                                        @else
                                            Invitado
                                        @endauth
                                    </span>
                                    <img class="border rounded-circle img-profile" src="assets/img/dogs/administrador.png"></a>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href="{{route('perfil')}}"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Perfil</a><a class="dropdown-item" href="#"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Settings</a><a class="dropdown-item" href="#"><i class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Activity log</a>
                                        <div class="dropdown-divider"></div><a href="{{ route('logout') }}"
                                         onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();" class="dropdown-item"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                         <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                            </form>

                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>

        @yield('contenido')

        <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/Table-With-Search.js"></script>
    <script src="assets/js/theme.js"></script>

<!-- MOSTRAR DATOS EN EL MODAL -->
   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  @stack('scripts')
</body>

</html>