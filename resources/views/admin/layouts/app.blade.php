<?php use Illuminate\Support\Facades\Auth; ?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- End Required meta tags -->
    <title>@yield('title', 'BettercareNDIS')</title>
    <meta name="theme-color" content="#3063A0">
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600" rel="stylesheet"><!-- End GOOGLE FONT -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    <!-- BEGIN PLUGINS STYLES -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/open-iconic/font/css/open-iconic-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/%40fortawesome/fontawesome-free/css/all.min.css') }}">
    <!-- END PLUGINS STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link rel="stylesheet" href="{{ asset('assets/stylesheets/theme.min.css') }}" data-skin="default">
    <link rel="stylesheet" href="{{ asset('assets/stylesheets/theme-dark.min.css') }}" data-skin="dark">
    <link rel="stylesheet" href="{{ asset('assets/stylesheets/custom.css') }}">
    @stack('styles')
    <script>
        var skin = localStorage.getItem('skin') || 'default';
        var disabledSkinStylesheet = document.querySelector('link[data-skin]:not([data-skin="' + skin + '"])');
        // Disable unused skin immediately
        disabledSkinStylesheet.setAttribute('rel', '');
        disabledSkinStylesheet.setAttribute('disabled', true);
        // add loading class to html immediately
        document.querySelector('html').classList.add('loading');
    </script><!-- END THEME STYLES -->
</head>

<body data-spy="scroll" data-target="#nav-content" data-offset="76">
    <div class="loadercontainer2 hideloader" id="loadercontainer2">
        <div class="loader_content">
            {{-- <img src="{{ asset('images/spinner-loading.gif') }}" /><br> --}}
            <p>Loading.....</p>
        </div>
    </div>
    <!-- .app -->
    <div class="app">
        <!-- .app-header -->
        <header class="app-header app-header-dark">
            <!-- .top-bar -->
            <div class="top-bar">
                <!-- .top-bar-brand -->
                <div class="top-bar-brand">
                    <!-- toggle aside menu -->
                    <button class="hamburger hamburger-squeeze mr-2" type="button" data-toggle="aside-menu"
                        aria-label="toggle aside menu"><span class="hamburger-box"><span
                                class="hamburger-inner"></span></span></button> <!-- /toggle aside menu -->
                    <a href="#">Bettercare Orders</a>
                </div><!-- /.top-bar-brand -->
                <!-- .top-bar-list -->
                <div class="top-bar-list">
                    <!-- .top-bar-item -->
                    <div class="top-bar-item px-2 d-md-none d-lg-none d-xl-none">
                        <!-- toggle menu -->
                        <button class="hamburger hamburger-squeeze" type="button" data-toggle="aside"
                            aria-label="toggle menu"><span class="hamburger-box"><span
                                    class="hamburger-inner"></span></span></button> <!-- /toggle menu -->
                    </div><!-- /.top-bar-item -->
                    <!-- .top-bar-item -->
                    <div class="top-bar-item top-bar-item-right px-0 d-none d-sm-flex">
                        <!-- .btn-account -->
                        <div class="dropdown d-none d-md-flex">
                            <button class="btn-account" type="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false"><span
                                    class="user-avatar user-avatar-md">{{-- <img src="assets/images/avatars/profile.jpg" alt=""> --}}</span> <span
                                    class="account-summary pr-lg-4 d-none d-lg-block"><span
                                        class="account-name">{{ Auth::user()->name }}</span> </span></button>
                            <!-- .dropdown-menu -->
                            <div class="dropdown-menu">
                                <div class="dropdown-arrow d-lg-none" x-arrow=""></div>
                                <div class="dropdown-arrow ml-3 d-none d-lg-block"></div>
                                <h6 class="dropdown-header d-none d-md-block d-lg-none"> {{ Auth::user()->name }}
                                </h6>
                                <a class="dropdown-item" href="{{ url('/admin/edit_user/' . Auth::user()->id) }}"><span
                                        class="dropdown-icon oi oi-person"></span> Profile</a> <a class="dropdown-item"
                                    href="{{ route('logout') }}"><span
                                        class="dropdown-icon oi oi-account-logout"></span> Logout</a>
                            </div><!-- /.dropdown-menu -->
                        </div><!-- /.btn-account -->
                    </div><!-- /.top-bar-item -->
                </div><!-- /.top-bar-list -->
            </div><!-- /.top-bar -->
        </header><!-- /.app-header -->

        <!-- .app-aside -->
        <aside class="app-aside app-aside-expand-md app-aside-light">
            <!-- .aside-content -->
            <div class="aside-content">
                <!-- .aside-header -->
                <header class="aside-header d-block d-md-none">
                    <!-- .btn-account -->
                    <button class="btn-account" type="button" data-toggle="collapse"
                        data-target="#dropdown-aside"><span
                            class="user-avatar user-avatar-lg">{{-- <img src="assets/images/avatars/profile.jpg" alt=""> --}}</span> <span
                            class="account-icon"><span class="fa fa-caret-down fa-lg"></span></span> <span
                            class="account-summary"><span class="account-name">{{ Auth::user()->name }}</span>
                        </span></button> <!-- /.btn-account -->
                    <!-- .dropdown-aside -->
                    <div id="dropdown-aside" class="dropdown-aside collapse">
                        <!-- dropdown-items -->
                        <div class="pb-3">

                            <a class="dropdown-item" href="{{ url('/admin/edit_user/' . Auth::user()->id) }}"><span
                                    class="dropdown-icon oi oi-person"></span> Profile</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"><span
                                    class="dropdown-icon oi oi-account-logout"></span> Logout</a>
                        </div><!-- /dropdown-items -->
                    </div><!-- /.dropdown-aside -->
                </header><!-- /.aside-header -->
                <!-- .aside-menu -->
                <div class="aside-menu overflow-hidden">
                    <!-- .stacked-menu -->
                    <nav id="stacked-menu" class="stacked-menu">
                        <!-- .menu -->
                        <ul class="menu">
                            <!-- .menu-item -->
                            <li class="menu-item">
                                <a href="{{ route('adminDashboard') }}" class="menu-link"><span
                                        class="menu-icon fas fa-home"></span> <span
                                        class="menu-text">Dashboard</span></a>
                            </li><!-- /.menu-item -->
                            <!-- .menu-item -->
                            <li class="menu-item">
                                <a href="{{ route('fetchAllOrders') }}" class="menu-link"><span
                                        class="menu-icon oi oi-browser"></span><span class="menu-text">All
                                        Orders</span></a>
                            </li><!-- /.menu-item -->
                            <!-- .menu-item -->
                            <li class="menu-item">
                                <a href="{{ route('getTicketsPage') }}" class="menu-link"><span
                                        class="menu-icon oi oi-browser"></span>
                                    <span class="menu-text">Tickets & Tasks</span></a>
                            </li><!-- /.menu-item -->
                            <!-- .menu-item -->
                            <li class="menu-item">
                                <a href="{{ route('getSuppliersPage') }}" class="menu-link"><span
                                        class="menu-icon oi oi-browser"></span> <span
                                        class="menu-text">Supplier</span></a>
                            </li><!-- /.menu-item -->
                            <!-- .menu-item -->
                            <li class="menu-item">
                                <a href="{{ route('getOrders') }}" class="menu-link"><span
                                        class="menu-icon oi oi-browser"></span> <span class="menu-text">NDIA
                                        Orders</span></a>
                            </li><!-- /.menu-item -->
                            <!-- .menu-item -->
                            <li class="menu-item">
                                <a href="{{ route('getPlanManagedOrders') }}" class="menu-link"><span
                                        class="menu-icon oi oi-browser"></span> <span class="menu-text">Plan
                                        Managed Orders</span></a>
                            </li><!-- /.menu-item -->
                            {{-- <li class="menu-item">
                                <a href="{{ route('getDelayItems') }}" class="menu-link"><span
                                        class="menu-icon oi oi-browser"></span> <span class="menu-text">Delayed
                                        Items</span></a>
                            </li><!-- /.menu-item --> --}}
                            @if (Auth::user()->is_admin == 1)
                                <!-- .menu-item -->
                                <li class="menu-item">
                                    <a href="{{ route('configuration') }}" class="menu-link"><span
                                            class="menu-icon oi oi-wrench"></span> <span
                                            class="menu-text">Configuration</span></a>
                                </li><!-- /.menu-item -->

                                <!-- .menu-item -->
                                <li class="menu-item has-child">
                                    {{-- <a href="#" class="menu-link"><span class="menu-icon oi oi-person"></span>
                                        <span class="menu-text">Users</span></a> <!-- child menu --> --}}

                                    <a data-toggle="collapse" href="#collapseExample" role="button"
                                        aria-expanded="false" aria-controls="collapseExample">
                                        <span class="menu-icon oi oi-person pl-3 pr-3 pt-2 pb-2 text-gray-400"></span>
                                        <span class="menu-text text-black">Users</span>
                                    </a>


                                    <div class="collapse" id="collapseExample">
                                        <a href="{{ route('getCreateUser') }}"
                                            class="pr-4 menu-link text-black">Create
                                            User </a>
                                        <a href="{{ route('listUser') }}" class="pr-8 menu-link text-black">Users
                                            List</a>
                                    </div>
                                    {{-- <ul class="menu">
                                        <li class="menu-item">
                                            <a href="{{ route('getCreateUser') }}" class="menu-link">Create
                                                User </a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="{{ route('listUser') }}" class="menu-link">Users List</a>
                                        </li>
                                    </ul><!-- /child menu --> --}}
                                </li><!-- /.menu-item -->
                            @endif
                            <li class="menu-item">
                                <a href="{{ route('PreOrder') }}" class="menu-link"><span
                                        class="menu-icon oi oi-spreadsheet
                                        "></span>
                                    <span class="menu-text">Pre-orders</span></a>
                            </li><!-- /.menu-item -->
                            <!-- .menu-item -->

                            <li class="menu-item">
                                <a href="{{ route('logout') }}" class="menu-link"><span
                                        class="menu-icon oi oi-account-logout"></span> <span
                                        class="menu-text">Logout</span></a>
                            </li><!-- /.menu-item -->

                        </ul><!-- /.menu -->
                    </nav><!-- /.stacked-menu -->
                </div><!-- /.aside-menu -->
                <!-- Skin changer -->
                <footer class="aside-footer border-top p-2">
                    <button class="btn btn-light btn-block text-primary" data-toggle="skin"><span
                            class="d-compact-menu-none">Night mode</span> <i class="fas fa-moon ml-1"></i></button>
                </footer><!-- /Skin changer -->
            </div><!-- /.aside-content -->
        </aside><!-- /.app-aside -->
        <!-- .app-main -->
        <main class="app-main">
            <!-- .wrapper -->
            <div class="wrapper">
                @yield('content')
            </div><!-- /.wrapper -->
        </main><!-- /.app-main -->
    </div> <!-- /.app -->
    <!-- BEGIN BASE JS -->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/popper.js/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script> <!-- END BASE JS -->
    <!-- BEGIN PLUGINS JS -->
    <script src="{{ asset('assets/vendor/pace-progress/pace.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/stacked-menu/js/stacked-menu.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script> <!-- END PLUGINS JS -->
    <!-- BEGIN THEME JS -->
    <script src="{{ asset('assets/javascript/theme.min.js') }}"></script> <!-- END THEME JS -->
    @stack('scripts')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="{{ asset('https://www.googletagmanager.com/gtag/js?id=UA-116692175-1') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-116692175-1');

        function hideNotification() {
            setTimeout(function() {
                $('.alert-timer').fadeOut('fast');
            }, 3000);
        }
    </script>
</body>

</html>
