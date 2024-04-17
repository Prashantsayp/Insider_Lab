@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="{!! route('professionalPolicyDetails.index') !!}">Professional Policy Details</a>
          </li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
    <div class="container-fluid">
         <div class="animated fadeIn">
             @include('coreui-templates::common.errors')
             <div class="row">
                 <div class="col-lg-12">
                      <div class="card">
                          <div class="card-header">
                              <i class="fa fa-edit fa-lg"></i>
                              <strong>Edit Professional Policy Details</strong>
                          </div>
                          <div class="card-body">
                              {!! Form::model($professionalPolicyDetails, ['route' => ['professionalPolicyDetails.update', $professionalPolicyDetails->id], 'method' => 'patch']) !!}

                              @include('professional_policy_details.fields')

                              {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>
@endsection