@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Cases</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            @include('flash::message')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <form action="">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <i class="fa fa-align-justify"></i>
                                        Cases
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="case_id" value="{{$case_id}}"
                                               placeholder="Search By CaseID, Contact" class="form-control">
                                    </div>
                                    <div class="col-sm-2">

                                        <button type="submit" class="btn btn-sm btn-primary">Search</button>
                                    </div>
                                    <div class="col-sm-2">
                                        <a class="pull-right" href="{{ route('cases.create') }}"><i
                                                    class="fa fa-plus-square fa-lg"></i></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            @include('cases.table')
                            <div class="pull-right mr-3">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

