<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{config('app.name')}}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 4.1.1 -->
    <link rel="stylesheet" type="text/css" media="screen" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" media="screen"href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="./plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" media="screen" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/left_navigation.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        

</head>
<body>
<div class="page-wrapper chiller-theme toggled">
    <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
        <!-- <i class="fa fa-arrow-right"></i> -->
        <svg height="9" viewBox="0 0 13 9" width="13" class="ng-star-inserted">
            <path d="M1.66797 8L5.16797 4.5L1.66797 1"></path>
            <path d="M7.5 8L11 4.5L7.5 1"></path>
        </svg>
    </a>
    <!-- start: Left Navigation -->
    <nav id="sidebar" class="sidebar-wrapper">
        <div class="sidebar-content">
            <div class="sidebar-brand">
                <a href="{{ route('homes.index') }}" class="nav-logo-link">
                    <img src="images/mono.png" alt="Financial Freedom">
                    <span class="nav-logo-title">Financial <span>Freedom</span></span>
                </a>

            </div>

            <div class="sidebar-menu">
                <ul>
                    <li title="Home" class="main-link {{ Request::is('homes*') ? 'activeSelected' : '' }}">
                        <a href="{{ route('homes.index') }}">
                            <i class="fa fa-home"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li title="Agents" class="main-link {{ Request::is('agents*') ? 'activeSelected' : '' }}">
                        <a href="{{ route('agents.index') }}">
                            <i class="fa fa-user"></i>
                            <span>Agents</span>
                        </a>
                    </li>
                    <li title="Products" class="main-link">
                        <a href="products.html">
                            <i class="fa fa-cubes"></i>
                            <span>Products</span>
                        </a>
                    </li>
                    <li title="Case Manager" class="main-link {{ Request::is('cases*') ? 'activeSelected' : '' }}">
                        <a href="{{ route('cases.index') }}">
                            <i class="fa fa-rocket"></i>
                            <span>Case Manager</span>
                        </a>
                    </li>                    
                    <li title="Global Media" class="main-link {{ Request::is('global*') ? 'activeSelected' : '' }}">
                        <a href="{{ route('Notifications-Media') }}">
                            <i class="fa fa-bell"></i>
                            <span>Global Media</span>
                        </a>
                    </li>
                    <li title="Global Notification" class="main-link {{ Request::is('notifications*') ? 'activeSelected' : '' }}">
                        <a href="{{ route('Notifications') }}">
                            <i class="fa fa-bell"></i>
                            <span>Global Notification</span>
                        </a>
                    </li>                         
                    <li title="Service Desk" class="main-link">
                        <a href="#">
                            <i class="fa fa-gear"></i>
                            <span>Service Desk</span>
                        </a>                         
                    </li>
                    
                    
                </ul>
            </div>
            <!-- sidebar-menu  -->
        </div>
        <div class="sidebar-footer">
            <div id="close-sidebar">
                <svg height="9" viewBox="0 0 13 9" width="13" class="ng-star-inserted">
                    <path d="M11.332 1L7.83203 4.5L11.332 8"></path>
                    <path d="M5.5 1L2 4.5L5.5 8"></path>
                </svg>
            </div>
        </div>
    </nav>    
     @yield('content')
</div>

</body>
<!-- jQuery 3.1.1 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="./plugins/daterangepicker/daterangepicker.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.colVis.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-multiselect.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
@stack('scripts')

</html>
