@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

<main class="page-content">
    <div class="container-fluid">
        <!-- start: Header row -->
        <div class="row">
            <header>
                <div class="top-header">
                    <section class="header-top-left">
                        <div class="logo">
                            <a href="#">
                                <!-- <img src="images/catlogo.png" alt="CATERPILLAR"> -->
                                <h4 class="page-title">Dashboard</h4>
                            </a>
                        </div>
                    </section>
                    <section class="header-top-right">
                        <!-- <div class="cat-logo">
                            <img src="images/catlogo.png" alt="CATERPILLAR" />
                        </div> -->
                        <div class="dropdown user-profile-main">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                id="userProfileMenu" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fa fa-bars" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="userProfileMenu">
                                <p class="user-name">
                                    <span id="initialname" class="name-initl"></span>
                                    <span id="getFullName">{{ Auth::user()->name }}</span></p>
                                <p class="user-designation">{{ Auth::user()->usre_type }}</p>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)" target="_blank">Settings <i class='fa fa-gear pull-right mt-1'></i></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign Out <i class='fa fa-sign-out pull-right mt-1'></i></a>
                                  <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="clearfix"></div>
            </header>
        </div>        
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-custom cc-home-main">
                    <div class="card-body">

                        <h4>Welcome To Financial Freedom</h4>


                       
                    </div>
                </div>
            </div>
        </div>


    </div>
</main>   
@endsection