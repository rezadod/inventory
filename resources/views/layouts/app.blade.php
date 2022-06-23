<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>INVENTORY</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- <link rel="stylesheet" href="{{ asset('node_modules/font-awesome/css/font-awesome.min.css') }}" /> -->
    <link rel="stylesheet" href="{{ asset('node_modules/perfect-scrollbar/dist/css/perfect-scrollbar.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('node_modules/flag-icon-css/css/flag-icon.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" />
    @stack('add_css')
</head>

<body>
    <div class=" container-scroller">
        <nav class="navbar navbar-expand-lg main-navbar p-0 navbar-default">
            <div class="bg-white text-center navbar-brand-wrapper">
                <a class="navbar-brand brand-logo" href="{{ url('/') }}">INVENTORY</a>
                <a class="navbar-brand brand-logo-mini" href="{{ url('/') }}">In</a>
            </div>
            <!-- <div class="navbar-menu-wrapper d-flex align-items-center"> -->
            <button class="navbar-toggler navbar-toggler d-none d-lg-block navbar-dark align-self-center mr-3"
                type="button" data-toggle="minimize">
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="navbar-nav ml-lg-auto d-flex align-items-center">
                <li class="nav-item"><a href="#" data-toggle="dropdown"
                        class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <!-- <img alt="image" src="../assets/img/avatar/avatar-1.png" class="rounded-circle mr-1"> -->
                        <div class="d-sm-none d-lg-inline-block">Hi, {{Auth::user()->name}}</div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" style="z-index: 999;">
                        <!-- <div class="dropdown-divider"></div> -->
                        <a class="dropdown-item has-icon text-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
            <!-- </div> -->
        </nav>

        <div class="container-fluid">
            <div class="row row-offcanvas row-offcanvas-right">
                <nav class="bg-white sidebar sidebar-offcanvas" id="sidebar">
                    @php
                        if(Request::is('home')){
                            $act_1 = 'active';
                            $act_2 = '';
                        } else if (Request::is('report_barang_keluar')){
                            $act_1 = '';
                            $act_2 = 'active';
                        }
                    @endphp
                    <ul class="nav">
                        <li class="nav-item {{ $act_1 }}">
                            <a class="nav-link" href="{{ url('/home') }}">
                                <img src="images/icons/1.png" alt="">
                                @if(Auth::user()->role_id == 1)
                                <span class="menu-title">Kelola Inventory</span>
                                @else
                                <span class="menu-title">Report Barang Masuk</span>
                                @endif
                            </a>
                        </li>
                        @if(Auth::user()->role_id == 2)
                        <li class="nav-item {{ $act_2 }}">
                            <a class="nav-link" href="{{ url('/report_barang_keluar') }}">
                                <img src="images/icons/1.png" alt="">
                                <span class="menu-title">Report Barang Keluar</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </nav>

                <!-- partial -->
                <div class="content-wrapper">
                    @yield('content')
                </div>
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="container-fluid clearfix">
                        <span class="float-right">
                            <a href="#">Inventory-alpha</a> &copy; 2022
                        </span>
                    </div>
                </footer>

                <!-- partial -->
            </div>
        </div>
    </div>

    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="node_modules/chart.js/dist/Chart.min.js"></script>
    <script src="node_modules/perfect-scrollbar/dist/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB5NXz9eVnyJOA81wimI8WYE08kW_JMe8g&callback=initMap"
        async defer></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/misc.js"></script>
    <script src="js/chart.js"></script>
    <script src="js/maps.js"></script>
    @stack('add_js')
</body>

</html>
