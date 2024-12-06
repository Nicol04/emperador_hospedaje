<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Emperador</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @if (($message = Session::get('mensaje')) && ($icono = Session::get('icono')))
            <script>
                Swal.fire({
                    title: "Mensaje",
                    text: "{{ $message }}",
                    icon: "{{ $icono }}"
                });
            </script>
        @endif


        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="" class="nav-link">Hola {{ Auth::user()->rol_name }} !</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="{{ asset('dist/img/user1-128x128.jpg') }}" alt="User Avatar"
                                    class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Brad Diesel
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">Call me whenever you can...</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="{{ asset('dist/img/user8-128x128.jpg') }}" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        John Pierce
                                        <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">I got your message bro</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="{{ asset('dist/img/user3-128x128.jpg') }}" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Nora Silvester
                                        <span class="float-right text-sm text-warning"><i
                                                class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">The subject goes here</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"
                        role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ url('/admin') }}" class="brand-link">
                <img src="{{ asset('assets/img/logo.jpg') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">El Emperador</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ Auth::user()->empleado && Auth::user()->empleado->foto ? asset('storage/' . Auth::user()->empleado->foto) : asset('assets/img/usuario.png') }}"
                            style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;"
                            class="img-circle elevation-2" alt="User Image" />

                    </div>
                    <div class="info">
                        <a href="{{ route('admin.empleados.show', Auth::user()->idUsuario) }}" class="d-block">
                            {{ Auth::user()->nombreUsuario }}
                        </a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="#" class="nav-link toggle-active">
                                <i class="nav-icon fas"><i class="bi bi-people-fill"></i></i>
                                <p>
                                    Usuarios
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li
                                    class="nav-item @if (Request::is('empleados/*')) menu-is-opening menu-open @endif">
                                    <a href="{{ url('/empleados') }}"
                                        class="nav-link @if (Request::is('empleados')) active @endif">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Empleados</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Clientes</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item @if (Request::is('habitaciones/*')) menu-is-opening menu-open @endif">
                            <a href="{{ route('habitaciones.tipohabitacion.index') }}"
                                class="nav-link @if (Request::is('habitaciones/tipohabitacion')) active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tipos de Habitación</p>
                            </a>
                        </li>

                        <li class="nav-item @if (Request::is('habitaciones/*')) menu-is-opening menu-open @endif">
                            <a href="{{ route('habitaciones.index') }}"
                                class="nav-link @if (Request::is('habitaciones/tipohabitacion')) active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Habitaciones</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link toggle-active">
                                <img src="{{ asset('assets/img/cama.png') }}" alt="Icono de cama" class="nav-icon"
                                    style="width: 20px; height: 20px; margin-right: 5px;">
                                <p>
                                    Habitaciones
                                    <i class="fas fa-angle-left right"></i>
                                    <span class="badge badge-info right">6</span>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li
                                    class="nav-item @if (Request::is('habitaciones/*')) menu-is-opening menu-open @endif">
                                    <a href="#" class="nav-link toggle-active">
                                        <img src="{{ asset('assets/img/limpieza.png') }}" alt="Icono de limpieza"
                                            class="nav-icon" style="width: 20px; height: 20px; margin-right: 5px;">
                                        <p>Reservas</p>
                                        <i class="fas fa-angle-left right"></i>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li
                                            class="nav-item @if (Request::is('habitaciones/*')) menu-is-opening menu-open @endif">
                                            <a href="{{ url('/habitaciones/reservas') }}"
                                                class="nav-link @if (Request::is('habitaciones/reservas/checkin')) active @endif">
                                                <img src="{{ Request::is('habitaciones/reserva') ? asset('assets/img/insumos1.png') : asset('assets/img/insumos.png') }}"
                                                    alt="Icono de checkin" class="nav-icon"
                                                    style="width: 20px; height: 20px; margin-right: 5px;">
                                                <p>Check in</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/habitaciones/limpieza/checkout') }}"
                                                class="nav-link @if (Request::is('habitaciones/reservas/checkout')) active @endif">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Check out</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li
                                    class="nav-item @if (Request::is('habitaciones/*')) menu-is-opening menu-open @endif">
                                    <a href="#" class="nav-link toggle-active">
                                        <img src="{{ asset('assets/img/limpieza.png') }}" alt="Icono de limpieza"
                                            class="nav-icon" style="width: 20px; height: 20px; margin-right: 5px;">
                                        <p>Limpieza</p>
                                        <i class="fas fa-angle-left right"></i>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li
                                            class="nav-item @if (Request::is('habitaciones/*')) menu-is-opening menu-open @endif">
                                            <a href="{{ url('/habitaciones/limpieza') }}"
                                                class="nav-link @if (Request::is('habitaciones/limpieza')) active @endif">
                                                <img src="{{ Request::is('habitaciones/limpieza') ? asset('assets/img/insumos1.png') : asset('assets/img/insumos.png') }}"
                                                    alt="Icono de cama" class="nav-icon"
                                                    style="width: 20px; height: 20px; margin-right: 5px;">
                                                <p>Insumos limpieza</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/habitaciones/limpieza/registrar') }}"
                                                class="nav-link @if (Request::is('habitaciones/limpieza/registrar')) active @endif">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Registrar limpieza</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item logout-item">
                                <a class="nav-link logout-link" href="{{ route('logout') }}"
                                    style="background-color: #ff0000"
                                    onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
                                    <i class="nav-icon"><i class="bi bi-door-open-fill"></i> </i>
                                    <p class="nav-item">Salir</p>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Contenido y paginas-->
        <div class="content-wrapper">
            <!-- Parte de arriba -->
            <div class="content-header">
                <div class="container-fluid">
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                @yield('content')
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleSubmenu = document.querySelector('.toggle-submenu');

            toggleSubmenu.addEventListener('click', function(e) {
                e.preventDefault();

                let parentLi = this.closest('.nav-item');
                let subMenu = parentLi.querySelector('.nav-treeview');
                parentLi.classList.toggle('menu-open');
                if (subMenu.style.display === "block") {
                    subMenu.style.display = "none";
                    this.classList.remove('active');
                } else {
                    subMenu.style.display = "block";
                    this.classList.add('active');
                }
            });
        });
    </script>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

    <script>
        // Función universal para mostrar un modal de decisión
        function confirmAction(actionUrl, method = 'POST', message = '¿Estás seguro de realizar esta acción?',
            actionName = 'Eliminar') {
            Swal.fire({
                title: '¿Estás seguro?',
                text: message, // Aquí pasas el mensaje dinámicamente
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: `Sí, ${actionName}`,
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Crear un formulario con el método adecuado (POST, DELETE, etc.)
                    const form = document.createElement('form');
                    form.method = method;
                    form.action = actionUrl;

                    // Si el método es DELETE, incluir un campo de método
                    if (method.toUpperCase() === 'DELETE') {
                        const deleteField = document.createElement('input');
                        deleteField.type = 'hidden';
                        deleteField.name = '_method';
                        deleteField.value = 'DELETE';
                        form.appendChild(deleteField);
                    }

                    // Añadir el CSRF Token
                    const csrfTokenField = document.createElement('input');
                    csrfTokenField.type = 'hidden';
                    csrfTokenField.name = '_token';
                    csrfTokenField.value = document.querySelector('meta[name="csrf-token"]').getAttribute(
                    'content');
                    form.appendChild(csrfTokenField);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>

</body>

</html>
