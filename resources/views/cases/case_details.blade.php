@extends('layouts.app')
@section('content')
<style>
    .nav-pills li {
        padding-top: 10px;
        padding-left: 8px;
        padding-right: 13px;
    }

    .side-card {
        border: none;
    }

    .content {
        background-color: #EDEDED;
        border-radius: 7px;
    }

    .tabs {
        display: flex;
        flex-wrap: wrap;
    }

    .tabs .tab {
        order: 99;
        flex-grow: 1;
        width: 100%;
        display: none;
    }

    .tabs input[type="radio"] {
        display: none;
    }

    .tabs input[type="radio"]:checked+label {
        background: #fff;
        border-radius: 22px;
        padding: 12px;
        margin: 10px;
    }

    .tabs input[type="radio"]:checked+label+.tab {
        display: block;
    }

    .btn:not(:disabled):not(.disabled).active, .btn:not(:disabled):not(.disabled):active, .show>.btn.dropdown-toggle {
    color: #fff;
    background-color: #68ccff !important;
    border-color: #68ccff !important;
        border-radius: 30px;
}

.tabs input[type="radio"]:checked+label {
    background: #f4de4c;
    border-radius: 22px;
    padding: 12px;
    margin: 10px;
}
</style>
<main class="page-content">
    <div class="container-fluid">
        <!-- start: Header row -->
        <div class="row">
            <header>
                <div class="top-header">
                    <section class="header-top-left">
                        <div class="logo">
                            <a href="">                                
                                <h4 class="page-title">Case Details</h4>
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
<!-- <div class="row">
<div class="col-sm-12">
<div class="card card-custom cc-home-main">
<div class="card-body">     -->                

<div class="row">
<div class="main1 col-md-12">
<div class="row">
<div class="col-md-4">
<div class="dropdown">
<button class="profile-btn btn btn-secondary dropdown-toggle" type="button"
    id="profile_btn">
    Profile
</button>
<div class="pro dropdown-menu" aria-labelledby="profile_btn" id="profile">
    <div class="main-pro">
        <div class="avtar">
            <img src="./images/avtar.svg" />
           <!--  <button class="edit btn btn-group">Edit</button> -->
        </div>
        <div class="profile">
            <span class="name">{{ $cases->first_name }} {{ $cases->last_name }}<i
                    class="fa fa-check-circle"></i></span><br />
            <span class="user" style="font-size: 18px;">Case ID : {{ $cases->id }}</span>
        </div><br />
        <div class="info">

            <span>User : <a href="<?php echo route('Agent-Details', ['id=' .$agent_details->id])?>" target="_blank"><?=$agent_details->name?></a></span><br />
            Loan Type :<span style="color: #44CCFF;"> {{ $cases->load_type }}</span><br />
            <span>Credit Score :@if(!empty($cases->cibil)) {{$cases->cibil}}  @else Not Available @endif</span><br />
            <span>Degree :@if(!empty($cases->highest_degree))  {{$cases->highest_degree}}   @else Not Available @endif</span>
           
        </div><br />
        <div class="infooo">
            <ul class="infoo">
                <li><i class="fa fa-tag"></i> {{ $cases->occupation }}</li>
                <li><i class="fa fa-map-marker"></i> {{ $cases->address }} , {{ $cases->pin_code }}</li>
                <li><i class="fa fa-envelope"></i> {{ $cases->email }}</li>
                <li><i class="fa fa-phone"></i> {{ $cases->mobile }}</li>
                <li><i class="fa fa-heart"></i>{{ $cases->load_amount }}</li>
            </ul>
        </div>
        <div class="last-active">
            <span>Last Active:40Mins ago</span>
        </div>
    </div>
    <div class="social-btn">
        <a href="https://api.whatsapp.com/send?phone=<?=$cases->mobile ?>" target="_blank" class="whatsapp btn btn-group"><i class="fa fa-whatsapp"></i>
            WhatsApp to {{ $cases->first_name }}</a>
        <a href="mailto:<?=$cases->email?>" class="mail btn btn-group"><i class="fa fa-envelope"></i> E-mail
            {{ $cases->first_name }}</a>
    </div>
</div>
</div>
</div>
<div class="col-md-8">
<div id="exTab1" class="container">
<ul class="nav nav-pills pills-nav" style="height: 43px;">
    <li class="active">
        <a href="#1a" data-toggle="tab">Documents</a>
    </li>
    <li class="case-details-page"><a href="#2a" data-toggle="tab">Comments</a>
    </li>
    <li class="case-details-page"><a href="#3a" data-toggle="tab">Policy Details</a>
    </li>
    <li class="case-details-page"><a href="#4a" data-toggle="tab">Status Notification</a>
    </li>
    <li class="case-details-page"><a href="#5a" data-toggle="tab">Bank Interaction</a>
    </li>
    <li class="case-details-page"><a href="#6a" data-toggle="tab">Customer Details</a>
    </li>
</ul>
</div>


</div>
<div class="col-md-12" style="height: 50em;">
<div class="tab-content clearfix">

<!-- Documents Section Code Starts -->

<div class="tab-pane active" id="1a">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="side-card col-md-8">
            <div class="inner-card">
                <div class="inner-one">
                    <div class="content p-4">
                        <div class="row">
                            <form method="POST" class="needs-validation" id="DocumentsForm" action="" novalidate enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $cases->id }}" name="case_id">
                            <?php
                            $i = 1;
                             foreach ($document_type as $key => $value) { ?>                               
                            <input type="hidden" name="id[]" value="<?=$value->id?>">
                            <div class="col-md-9">
                                <div class="button d-flex">
                                    <span>
                                         <?php
                                        // if($value->status == 'Yes') $checked = "checked";
                                        // else $checked = "";


                                        if($value->status == 'Yes'){
                                            $status = 1;
                                        }else{
                                            $status = 0;
                                        }
                                        ?>
                                        <div class="custom-control custom-switch pt-1">
                                           <input type="checkbox" name="status" class="custom-control-input" id="customSwitch<?=$i?>" onchange="changeStatusDocument( <?=$value->id?> ,<?=$status?>)" value="<?php echo $value->status; ?>" <?php if($value->status == 'Yes'){ echo "checked";} ?> >
                                          
                                            <label class="custom-control-label" for="customSwitch<?=$i?>" data-toggle="tooltip" data-placement="top" title="Status"></label>
                                        </div>
                                        
                                       
                                    </span>
                                    <span>
                                        <a href="#" class="badge"
                                            style="background-color: #44CCFF;color: black;padding: 10px;padding-left: 20px;padding-right: 20px;margin-left: 20px;">{{ $value->document_type }}</a>
                                    </span>
                                    

                                </div>
                                <div class="area mt-2" style="margin-left: -50px;">
                                    <div class="form-group" style="margin-left: 50px;">
                                        @foreach($documents as $data)
                                            @if($data->document_type == $value->document_type)
                                            
                                                <a href="{{ $url.$data->document_url }}" target="_blank" class="btn btn-secondary"  class="btn btn-primary"
                                                    style="font-size:11px;"><i
                                                        class="fas fa-file"></i></a>
                                                 <?php   if($data->flag == 'Yes'){
                                                        $flag = 1;
                                                    }else{
                                                        $flag = 0;
                                                    } ?>
                                                <label class="switch">
                                                  <input type="checkbox" id="flag<?=$i?>" onchange="changeFlagDocument( <?=$data->id?> ,<?=$flag?>)" value="<?php echo $data->flag; ?>" <?php if($data->flag == 'Yes'){ echo "checked";} ?> name="flag">
                                                  <span class="slider"></span>
                                                </label>
                                            
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="area mt-2">
                                    <div class="form-group">
                                        <textarea class="form-control" name="comments[]" 
                                            id="exampleFormControlTextarea1"
                                            rows="2" value="<?php= $value->comments?>"
                                            placeholder="Comment for user"><?=$value->comments?></textarea>
                                    </div>
                                </div>
                            </div>
                            <?php 
                            $i++;
                            } ?>
                            
                            <div class="col-md-9" style="text-align: center;">
                            <button type="submit" name="submit" class="btn btn-primary" style="background-color: #6C757D;padding: 10px;padding-left: 20px;padding-right: 20px;margin-left: 20px;border:none;">Submit Title</button>
                            </div>
                        
                        </form>                           
                             <div class="btn-add">
                                <!-- <button class="btn btn-group" id='add-row'
                                    value="Add new row"
                                    style="background-color: #C2C2C2;border: 2px solid #A1A1A1;border-radius: 10px;font-size: 12px;"><i
                                        class="fas fa-plus"
                                        style="font-size:20px;font-weight:800;padding-right: 15px;color:#6666FF;"></i>
                                    add new document for user</button><br /> -->
                            <label for="exampleFormControlInput1">Add new document for User</label>
                            </div>
                            <form method="POST" action="" id="casedetail">  <!-- Add new Document -->
                                @csrf
                            <div class="col-md-9 mt-2">
                                <div class="button d-flex">
                                    <span>
                                        <div class="custom-control custom-switch pt-1"
                                            data-toggle="tooltip"
                                            data-placement="top" title="Status">
                                            <input type="checkbox"
                                                class="custom-control-input"
                                                id="customSwitchNew" value="Yes" name="status" checked>
                                            <label class="custom-control-label"
                                                for="customSwitchNew"></label>
                                        </div>
                                    </span>
                                    
                                    <span>
                                        <input type="text" class="form-control" name="document_type" placeholder="Editable" style="background-color: #44CCFF;color: black;padding: 10px;padding-left: 0px;padding-right: 0px;margin-left: 20px;padding-top: 0px;padding-bottom: 0px;" />
                                    </span>
                                        
                                                
                                    <!-- <span>
                                        <button class="btn btn-secondary ml-5"
                                            style="font-size:11px;"><i
                                                class="fas fa-file"></i></button>
                                    </span> -->
                                   
                                </div>

                                <input type="hidden" name="case_id" value="{{ $cases->id }}">

                                <div class="area mt-2">
                                    <div class="form-group">
                                        <textarea class="form-control"
                                            id="exampleFormControlTextarea1" rows="2" placeholder="Comment for user" name="comments"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9 mt-2" id="test-body">
                                <span>
                                <button type="submit" class="btn btn-secondary ml-5"
                                        style="font-size:11px;float: right;">Submit to
                                        Doc</button>
                                    
                                </span>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Comments Section Code Starts -->

<div class="tab-pane" id="2a">
    <div class="row">
    <div class="col-md-4"></div>
        <div class="side-card col-md-8">
            <div class="inner-card">
                <div class="inner-one">
                    <div class="content p-4">
                        <div class="row">
                            <div class="alert alert-success" style="display:none;" role="alert">
                              Messege Sent Successfully.
                            </div>
                            <?php foreach ($comments as $key => $value) { ?>
                                <?php if(!empty($value->case_comments)){ ?>
                                <div class="message1 col-md-12">
                                    <div class="content-message" style="width: 60%;border-radius: 20px; background-color: #9AB3BC;padding: 15px;">
                                            <p><?=$value->case_comments?></p>                                    
                                    </div>
                                </div>
                                <?php } ?>
                                <?php if(!empty($value->user_comments)){ ?>
                                <div class="message2 col-md-12">
                                    <div class="content-message"
                                        style="width: 60%;float:right;border-radius: 20px;background-color: #44CCFF;padding: 15px;margin-top: 20px;">
                                        <p><?=$value->user_comments?></p>
                                    </div>
                                </div>
                                <?php } ?>
                            <?php } ?> 
                                <div class="message2 col-md-12 recent_comment" style="display:none;">
                                    <div class="content-message"
                                        style="width: 60%;float:right;border-radius: 20px;background-color: #44CCFF;padding: 15px;margin-top: 20px;">
                                        <p id="recent_comment">test</p>
                                    </div>
                                </div>  
                            <form method="POST" class="needs-validation" id="CommentsForm" action="" novalidate enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $cases->id }}" name="case_id">                         
                            <div class="send col-md-12 mt-3">
                                <div class="row">
                                    <div class="col-md-11">
                                        <div class="form-group">
                                            <textarea class="form-control" name="user_comments" id="user_comments"
                                            rows="2" placeholder="Please Enter Your Comment"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-1">                                       
                                            <button type="submit" class="btn btn-primary" style="padding: 12px;"><i class="fas fa-paper-plane"></i></button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="tab-pane" id="3a">
<div class="row">
<div class="col-md-4"></div>
<div class="side-card col-md-8">
<div class="inner-card">
<div class="inner-one">
<form method="POST" class="needs-validation" id="PolicyDetailsForm" action="" novalidate enctype="multipart/form-data">
@csrf
<input type="hidden" value="{{ $cases->id }}" name="case_id">
<table class="table">
<thead>
<tr>
<th scope="col"
    style="background-color: #99EEFF;border: 1px solid #7F8588;">
</th>
<th scope="col"
    style="background-color: #C6D2D7;border: 1px solid #7F8588;">
    Default Details of Product</th>
<th scope="col"
    style="background-color: #BBCCD3;border: 1px solid #7F8588;">
    Login details of Case</th>
<th scope="col"
    style="background-color: #EDF1F2;border: 1px solid #7F8588;">
    Approval From the Bank</th>
<!--  <th scope="col"
    style="background-color: #C6D2D7;border: 1px solid #7F8588;">
    Negotiation with User/Customer</th> -->
</tr>
</thead>
<tbody>

<tr>
<th scope="row"
    style="background-color: #99EEFF;border: 1px solid #7F8588;">
    Loan Amount</th>
<td
    style="background-color: #C6D2D7;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <!-- <input type="text" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" /> -->
    </div>
</td>
<td
    style="background-color: white;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" name="login_loan_amount" value="{{ @$policy_details->login_loan_amount }}" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td>
<td
    style="background-color:white;border: 1px solid #7F8588;padding:0px;text-align: center;">
    <input type="text" name="approval_loan_amount" value="{{ @$policy_details->approval_loan_amount }}" class="form-control" placeholder=""
    style="background-color: transparent;border: none;" /></td>
<!-- <td
    style="background-color: #C6D2D7;border: 1px solid #7F8588;padding:0px;text-align: center;">
    <input type="text" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" /></td> -->
</tr>
<tr>
<th scope="row"
    style="background-color: #99EEFF;border: 1px solid #7F8588;">
    Tenure</th>
<td
    style="background-color: #C6D2D7;border: 1px solid #7F8588;">
</td>
<td
    style="background-color: white;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" class="form-control" name="login_tenure" value="{{ @$policy_details->login_tenure }}"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td>
<td
    style="background-color: white;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" class="form-control" name="approval_tenure" value="{{ @$policy_details->approval_tenure }}"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td>
<!-- <td
    style="background-color: #C6D2D7;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td> -->
</tr>
<tr>
<th scope="row"
    style="background-color: #99EEFF;border: 1px solid #7F8588;">
    Interest Rate</th>
<td
    style="background-color: #C6D2D7;border: 1px solid #7F8588;">
</td>
<td
    style="background-color: white;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" name="login_interest_rate" value="{{ @$policy_details->login_interest_rate }}" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td>
<td
    style="background-color: white;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" name="approval_interest_rate" value="{{ @$policy_details->approval_interest_rate }}" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td>
<!-- <td
    style="background-color: #C6D2D7;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td> -->
</tr>
<tr>
<th scope="row"
    style="background-color: #99EEFF;border: 1px solid #7F8588;">
    Processing Fees</th>
<td
    style="background-color: #C6D2D7;border: 1px solid #7F8588;">
</td>
<td
    style="background-color: white;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" name="login_processing_fees" value="{{ @$policy_details->login_processing_fees }}" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td>
<td
    style="background-color: white;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" name="approval_processing_fees" value="{{ @$policy_details->approval_processing_fees }}" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td>
<!-- <td
    style="background-color: #C6D2D7;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td> -->
</tr>
<tr>
<th scope="row"
    style="background-color: #99EEFF;border: 1px solid #7F8588;">
    Insurance Fees</th>
<td
    style="background-color: #C6D2D7;border: 1px solid #7F8588;">
</td>
<td
    style="background-color: white;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" name="login_insurance_fees" value="{{ @$policy_details->login_insurance_fees }}" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td>
<td
    style="background-color: white;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" name="approval_insurance_fees" value="{{ @$policy_details->approval_insurance_fees }}" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td>
<!-- <td
    style="background-color: #C6D2D7;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td> -->
</tr>
<tr>
<th scope="row"
    style="background-color: #99EEFF;border: 1px solid #7F8588;">
    Admin Other Fees</th>
<td
    style="background-color: #C6D2D7;border: 1px solid #7F8588;">
</td>
<td
    style="background-color: white;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" name="login_admin_other_fees" value="{{ @$policy_details->login_admin_other_fees }}" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td>
<td
    style="background-color: white;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" name="approval_admin_other_fees" value="{{ @$policy_details->approval_admin_other_fees }}"  class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td>
<!-- <td
    style="background-color: #C6D2D7;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td> -->
</tr>
<tr>
<th scope="row"
    style="background-color: #99EEFF;border: 1px solid #7F8588;">
    Selected Lender</th>
<td
    style="background-color: #C6D2D7;border: 1px solid #7F8588;">

</td>
<td
    style="background-color: white;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" name="login_selected_lender" value="{{ @$policy_details->login_selected_lender }}" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td>
<td
    style="background-color: white;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" name="approval_selected_lender" value="{{ @$policy_details->approval_selected_lender }}" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td>
<!-- <td
    style="background-color: #C6D2D7;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td> -->
</tr>
<tr>
<th scope="row"
    style="background-color: #99EEFF;border: 1px solid #7F8588;">
    Lender Name</th>
<td
    style="background-color: #C6D2D7;border: 1px solid #7F8588;">

</td>
<td
    style="background-color: white;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" name="login_lender_name" value="{{ @$policy_details->login_lender_name }}" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td>
<td
    style="background-color: white;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" name="approval_lender_name" value="{{ @$policy_details->approval_lender_name }}" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td>
<!-- <td
    style="background-color: #C6D2D7;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td> -->
</tr>
<tr>
<th scope="row"
    style="background-color: #99EEFF;border: 1px solid #7F8588;">
    Policy Name of lender Selected</th>
<td
    style="background-color: #C6D2D7;border: 1px solid #7F8588;">
</td>
<td
    style="background-color: white;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" name="login_policy_name" value="{{ @$policy_details->login_policy_name }}" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td>
<td
    style="background-color: white;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" name="approval_policy_name" value="{{ @$policy_details->approval_policy_name }}" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td>
<!-- <td
    style="background-color: #C6D2D7;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td> -->
</tr>
<tr>
<th scope="row"
    style="background-color: #99EEFF;border: 1px solid #7F8588;">
    Policy Number</th>
<td
    style="background-color: #C6D2D7;border: 1px solid #7F8588;">
</td>
<td
    style="background-color: white;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" name="login_policy_number" value="{{ @$policy_details->login_policy_number }}" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td>
<td
    style="background-color: white;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" name="approval_policy_number" value="{{ @$policy_details->approval_policy_number }}" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td>
<!--  <td
    style="background-color: #C6D2D7;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td> -->
</tr>
<tr>
<th scope="row"
    style="background-color: #99EEFF;border: 1px solid #7F8588;">
    Program Type/Scheme Code</th>
<td
    style="background-color: #C6D2D7;border: 1px solid #7F8588;">
</td>
<td
    style="background-color: white;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" name="login_program_type" value="{{ @$policy_details->login_program_type }}" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td>
<td
    style="background-color: white;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" name="approval_program_type" value="{{ @$policy_details->approval_program_type }}" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td>
<!-- <td
    style="background-color: #C6D2D7;border: 1px solid #7F8588;padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-0"
        style="margin: 0px;padding: 0px;">
        <input type="text" class="form-control"
                placeholder=""
                style="background-color: transparent;border: none;" />
    </div>
</td> -->
</tr>
</tbody>
</table>
<div class="col-md-12" >
<div class="all-btn row">
    <div class="col-md-3"></div>
    <div class="col-md-3"></div>
<div class="col-md-3" style="text-align: center;">
<button type="submit" class="btn btn-warning"
style="border-radius: 20px;padding: 0 22px 0 22px;">Submit</button>
</div>
<div class="col-md-3" style="text-align: center;">
<button type="submit" class="btn btn-warning"
style="border-radius: 20px;padding: 0 22px 0 22px;">Submit</button>
</div>
<!-- <button class="btn btn-danger"
style="border-radius: 20px;margin-right:8px;padding: 8px 22px 8px 22px;">Submit</button> -->
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
<div class="tab-pane" id="4a">

<div class="row">
<div class="col-md-4"></div>
<div class="side-card col-md-8">
<div class="inner-card">
<div class="inner-one">
<form method="POST" class="needs-validation" id="EligibilityForm" action="" novalidate enctype="multipart/form-data">
@csrf
<input type="hidden" value="{{ $cases->id }}" name="case_id">
<input type="hidden" value="<?=date("Y-m-d h:i:s")?>" name="status_date">
<div class="contents p-2">
    <div class="row">
 <div class="col-xs-6 col-sm-6 col-lg-4">
<label for="exampleFormControlSelect1">Case Status</label>
    <select class="form-control" id="case_status" name="case_status">
        
        <?php 
        foreach( $case_status  as $key =>  $c_status) { ?>
            <option value="<?=$c_status->title?>" <?php if($c_status->title == $cases->case_status){ echo "selected";} ?>  ><?=$c_status->title?></option>
        <?php } ?>
    </select>
</div>  
<div class="col-xs-6 col-sm-6 col-lg-4">
<label for="exampleFormControlSelect1">Actions</label>
    <select class="form-control" id="status" name="status">
        <?php 
        foreach( $case_actions  as $key =>  $actions) { ?>
            <option value="<?=$actions->actions?>" <?php if($actions->actions == $cases->status){ echo "selected";} ?>  ><?=$actions->actions?></option>
        <?php } ?>
        
    </select>
</div> 
</div>
<div class="col-xs-12 col-sm-12 col-lg-4"  id="eligibility_yes_no" style="display:none !important;">

    <div class="btn-content d-flex p-3">
<span style="padding-top:8px;">ELIGIBILITY</span>

<?php 

if(@$cases->eligibility_status == 'Yes'){
$checked = 'checked';
}else{
$checked = '';
}

if(@$cases->eligibility_status == 'No'){
$unchecked = 'checked';
}else{
$unchecked = '';
}

?>

<div class="btn-group btn-group-toggle" data-toggle="buttons" style="margin-left: 20px;">
  <label class="btn  active case-details-check">
    <input type="radio" id="status_yes" name="eligibility_status" value="Yes" autocomplete="off" <?= $checked ?> /> Yes
  </label>
  <label class="btn  case-details-check">
    <input type="radio"  id="status_no" name="eligibility_status" value="No" autocomplete="off" <?= $unchecked ?> /> No 
  </label>
</div>

<!--<input type="radio" id="status_yes" name="status" value="Yes" class="btn btn-group" <?= $checked ?> /> Yes 
<input type="radio" id="status_no" name="status" value="No" class="btn btn-secondary" <?= $unchecked ?> /> No -->

<div style="width: 100%;">
<p
    style="margin-bottom: 0;float: right;padding-top: 10px;">
    {{ @$eligibility_data->status }}</p>
</div>
</div>

  </div>
<div class="form-group" id="status_explanation" style="margin-top: 15px;">
<textarea class="form-control" name="status_explanation" 
id="exampleFormControlTextarea1"
style="border-radius:10px;border:1px solid #A9A9A9;background-color:#E3E3E3;"
rows="9"
placeholder="Type Something (Explanation)..." value="{{ @$cases->status_explanation }} " > {{ @$cases->status_explanation }} </textarea>
</div>

</div>
<div class="btn" id="status_button" style="float:right;">
<button type="submit" class="btn btn-warning"
style="border-radius: 20px;padding-left: 20px;padding-right: 20px;">Send</button>
</div>
</form>
<div id="final_loan" style="display:none;">
<form method="POST" class="needs-validation" id="FinalBankApprovalForm" action="" novalidate enctype="multipart/form-data">
@csrf
<input type="hidden" value="{{ $cases->id }}" name="case_id">
<input type="hidden" value="" name="case_status" id="case_status2">

<div class="contents p-2">
<div class="btn-content d-flex p-3">
<span style="padding-top:8px;">FINAL LOAN APPROVAL FROM THE BANK</span>
</div>                                                    

<div class="in-form"
style="border: 1px solid #A9A9A9;border-radius: 10px;background-color: #E3E3E3;padding: 20px;">                              
<div class="form-group row">
    <label for="inputEmail3"
        class="col-sm-2  col-form-label">Loan Amount
        (Receivable)</label>
    <div class="col-sm-10">
        <input type="text" name="final_loan_loan_amount" value="{{ @$cases->final_loan_loan_amount }}" 
            class="form-control w-50"
            id="inputEmail3" style="border: none;">
    </div>
</div>
<div class="form-group row" >
    <label for="inputEmail3"
        class="col-sm-2 col-form-label">Interest
        Rate</label>
    <div class="col-sm-10">
        <input type="text" name="final_loan_interest_rate" value="{{ @$cases->final_loan_interest_rate }}" 
            class="form-control w-50"
            id="inputEmail3" style="border: none;">
    </div>
</div>
<div class="form-group row">
    <label for="inputEmail3"
        class="col-sm-2 col-form-label">Tenure (In Month)</label>
    <div class="col-sm-10">
        <input type="text" name="final_loan_tenure" value="{{ @$cases->final_loan_tenure }}"
            class="form-control w-50"
            id="inputEmail3" style="border: none;">
    </div>
</div>
<div class="form-group row">
    <label for="inputEmail3"
        class="col-sm-2 col-form-label">Processing
        Fees</label>
    <div class="col-sm-10">
        <input type="text" name="final_loan_processing_fees" value="{{ @$cases->final_loan_processing_fees }}"
            class="form-control w-50"
            id="inputEmail3" style="border: none;">
    </div>
</div>
<div class="form-group row" style="margin-top: 15px;"><label for="inputEmail3"
        class="col-sm-2 col-form-label">Remark</label>
<div class="col-sm-10">
<textarea class="form-control" name="status_explanation" 
id="exampleFormControlTextarea1"
style="border-radius:10px;border:1px solid #A9A9A9;background-color:#E3E3E3;"
rows="9"
placeholder="Type Something (Explanation)..." value="{{ @$cases->status_explanation }} " > {{ @$cases->status_explanation }} </textarea>
</div>
</div>

</div>
</div>
<div class="btn" style="float:right;">
<button type="submit" class="btn btn-danger"
style="border-radius: 20px;padding-left: 20px;padding-right: 20px;">Submit</button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>

</div>
<div class="tab-pane" id="5a">
<div class="row">
<div class="col-md-4"></div>
<div class="side-card col-md-8">
<div class="inner-card">
<div class="content p-4">
<div class="heading col-md-12">
<h5>Bank Interaction Form</h5>
</div>
<div class="form-group row">
<div class="col-xs-12 col-sm-6 col-lg-6 mb-3">
<label for="dealerCC"
class="col-sm-6 col-lg-6 col-form-label pull-left">Customer
Name</label>
<input type="text" class="form-control control-form col-md-6"
disabled />
</div>
<div class="col-xs-12 col-sm-6 col-lg-6 mb-3">
<label for="dealerCC"
class="col-sm-6 col-lg-6 col-form-label pull-left">User
Name</label>
<input type="text" class="form-control control-form col-md-6"
disabled />
</div>
<div class="col-xs-12 col-sm-6 col-lg-6 mb-3">
<label for="dealerCC"
class="col-sm-6 col-lg-6 col-form-label pull-left">Case
ID</label>
<input type="text" class="form-control control-form col-md-6"
disabled />
</div>
<div class="col-xs-12 col-sm-6 col-lg-6 mb-3">
<label for="dealerCC"
class="col-sm-6 col-lg-6 col-form-label pull-left">Loan
Type</label>
<input type="text" class="form-control control-form col-md-6"
disabled />
</div>
<div class="col-xs-12 col-sm-6 col-lg-6 mb-3">
<label for="dealerCC"
class="col-sm-6 col-lg-6 col-form-label pull-left">Bank/Lender</label>
<input type="text" class="form-control control-form col-md-6"
disabled />
</div>
<div class="col-xs-12 col-sm-6 col-lg-6 mb-3">
<label for="dealerCC"
class="col-sm-6 col-lg-6 col-form-label pull-left">Policy
Code</label>
<input type="text" class="form-control control-form col-md-6"
disabled />
</div>
<div class="col-xs-12 col-sm-6 col-lg-6 mb-3">
<label for="dealerCC"
class="col-sm-6 col-lg-6 col-form-label pull-left">Policy
Scheme Name</label>
<input type="text" class="form-control control-form col-md-6"
disabled />
</div>
<div class="col-xs-12 col-sm-6 col-lg-6 mb-3">
<label for="dealerCC"
class="col-sm-6 col-lg-6 col-form-label pull-left">Bank
location for Case</label>
<input type="text" class="form-control control-form col-md-6"
disabled />
</div>

</div>
<div class="heading col-md-12">
<h5>Contact</h5>
</div>
<div class="form-group row">
<div class="col-xs-12 col-sm-6 col-lg-6 mb-3">
<label for="dealerCC"
class="col-sm-6 col-lg-6 col-form-label pull-left">Banker
Name</label>
<input type="text" class="form-control col-md-6" />
</div>
<div class="col-xs-12 col-sm-6 col-lg-6 mb-3">
<label for="dealerCC"
class="col-sm-6 col-lg-6 col-form-label pull-left">Banker
Name(2)</label>
<input type="text" class="form-control col-md-6" />
</div>
<div class="col-xs-12 col-sm-6 col-lg-6 mb-3">
<label for="dealerCC"
class="col-sm-6 col-lg-6 col-form-label pull-left">Banker
Designation</label>
<input type="text" class="form-control col-md-6" />
</div>
<div class="col-xs-12 col-sm-6 col-lg-6 mb-3">
<label for="dealerCC"
class="col-sm-6 col-lg-6 col-form-label pull-left">Banker
Designation</label>
<input type="text" class="form-control col-md-6" />
</div>
<div class="col-xs-12 col-sm-6 col-lg-6 mb-3">
<label for="dealerCC"
class="col-sm-6 col-lg-6 col-form-label pull-left">Banker
Number</label>
<input type="text" class="form-control col-md-6" />
</div>
<div class="col-xs-12 col-sm-6 col-lg-6 mb-3">
<label for="dealerCC"
class="col-sm-6 col-lg-6 col-form-label pull-left">Banker
Number</label>
<input type="text" class="form-control col-md-6" />
</div>
</div>
<div class="sm-content">
<div class="rrrr">
<p
style="padding: 5px;background-color: #55CCFF;border-radius: 5px;">
<span class="rating">

    <input type="radio" name="rating"
        id="rating-10">
    <label for="rating-10"></label>
    <input type="radio" name="rating" id="rating-9">
    <label for="rating-9"></label>
    <input type="radio" name="rating" id="rating-8">
    <label for="rating-8"></label>
    <input type="radio" name="rating" id="rating-7">
    <label for="rating-7"></label>
    <input type="radio" name="rating" id="rating-6">
    <label for="rating-6"></label>
    <input type="radio" name="rating" id="rating-5">
    <label for="rating-5"></label>
    <input type="radio" name="rating" id="rating-4">
    <label for="rating-4"></label>
    <input type="radio" name="rating" id="rating-3">
    <label for="rating-3"></label>
    <input type="radio" name="rating" id="rating-2">
    <label for="rating-2"></label>
    <input type="radio" name="rating" id="rating-1">
    <label for="rating-1"></label>
    <span
        style="font-size:12px;padding-top:15px;">Case
        Management with Branch(People)</span>
</span>
</p>
</div>
<div class="rrrr">
<p
style="padding: 5px;background-color: #55CCFF;border-radius: 5px;">
<span class="rating">

    <input type="radio" name="rating"
        id="rating-100">
    <label for="rating-100"></label>
    <input type="radio" name="rating"
        id="rating-99">
    <label for="rating-99"></label>
    <input type="radio" name="rating"
        id="rating-88">
    <label for="rating-88"></label>
    <input type="radio" name="rating"
        id="rating-77">
    <label for="rating-77"></label>
    <input type="radio" name="rating"
        id="rating-66">
    <label for="rating-66"></label>
    <input type="radio" name="rating"
        id="rating-55">
    <label for="rating-55"></label>
    <input type="radio" name="rating"
        id="rating-44">
    <label for="rating-44"></label>
    <input type="radio" name="rating"
        id="rating-33">
    <label for="rating-33"></label>
    <input type="radio" name="rating"
        id="rating-22">
    <label for="rating-22"></label>
    <input type="radio" name="rating"
        id="rating-11">
    <label for="rating-11"></label>
    <span
        style="font-size:12px;padding-top:15px;">Operational
        Efficency with Bank(Process)</span>
</span>
</p>
</div>
</div>
<div class="col-md-12">
<div class="tabs">
<input type="radio" name="tabs" id="tabone"
checked="checked">
<label for="tabone"
style=" border-radius: 22px;padding: 12px;margin: 10px;">Login</label>
<div class="tab">
<div class="content"
    style="padding:10px;background-color: #fff;">
    <div class="form-group row">
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6  col-form-label  pull-left">Time
                since Login</label>
            <input type="text"
                class="form-control control-form col-md-6"
                placeholder="hh:mm;ss" disabled />
        </div>
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6 col-form-label pull-left">Login
                Time & Date</label>
            <input type="text"
                class="form-control control-form col-md-6"
                placeholder="hh:mm - dd/mm/yy"
                disabled />
        </div>
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6 col-form-label pull-left">Login
                TAT</label>
            <input type="text"
                class="form-control control-form col-md-6"
                disabled />
        </div>
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6 col-form-label pull-left">Time
                from Case create to case login in
                bank</label>
            <input type="text"
                class="form-control control-form col-md-6"
                placeholder="hh:mm;ss" disabled />
        </div>
        <div class="col-md-12">
            <h5 style="margin-left:1px;">Communications (eligibility to
                inquiry
                to Login)</h5>
        </div>
        <div class="row">
            <div
                class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                <div class="form-check">
                    <label class="form-check-label"
                        for="exampleCheck1">Calls to
                        bank at
                        Login Stage</label>
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px;
    max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px;
    max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="    margin: 0 9px;padding: 10px;width: 0px;
    max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="    margin: 0 9px;padding: 10px;width: 0px;
    max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="    margin: 0 9px;padding: 10px;width: 0px;
    max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="    margin: 0 9px;padding: 10px;width: 0px;
    max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="    margin: 0 9px;padding: 10px;width: 0px;
    max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="    margin: 0 9px;padding: 10px;width: 0px;
    max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="    margin: 0 9px;padding: 10px;width: 0px;
    max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px;
    max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
        </div>
        <div class="row">
            <div
                class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                <div class="form-check">
                    <label class="form-check-label"
                        for="exampleCheck1">Emails
                        to
                        bank
                        at Login Stage</label>
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px;
    max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px;
    max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px;
    max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px;
    max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px;
    max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px;
    max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px;
    max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px;
    max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px;
    max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px;
    max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
        </div>




        <div class="col-md-12">
            <h5>Login Case Order</h5>
        </div>
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6 col-form-label pull-left">Desired
                Loan Amount</label>
            <input type="text"
                class="form-control control-form col-md-6"
                disabled />
        </div>
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6 col-form-label pull-left">ROI</label>
            <input type="text"
                class="form-control control-form col-md-6"
                disabled />
        </div>
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6 col-form-label pull-left">PF</label>
            <input type="text"
                class="form-control control-form col-md-6"
                disabled />
        </div>
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6 col-form-label pull-left">Insurance</label>
            <input type="text"
                class="form-control control-form col-md-6"
                disabled />
        </div>
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6 col-form-label pull-left">Other
                Charges</label>
            <input type="text"
                class="form-control control-form col-md-6"
                disabled />
        </div>
        <div class="col-md-12">
            <h5>Communication & Follow-Ups</h5>
        </div>
        <div
            class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <label
                for="exampleFormControlTextarea1">Interaction
                we would do/messaging to be done
                with Bank/Lender (keep like note
                making of comm/instruction to be
                given the bank)</label>
            <textarea class="form-control"
                id="exampleFormControlTextarea1"
                rows="5"></textarea>
        </div>
        <div
            class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <label
                for="exampleFormControlTextarea1">Latest
                Revert Recieved from the
                Bank/Lender</label>
            <textarea class="form-control"
                id="exampleFormControlTextarea1"
                rows="5"></textarea>
        </div>
        <div
            class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <label
                for="exampleFormControlTextarea1">Requirements
                From the Bank</label>
            <textarea class="form-control"
                id="exampleFormControlTextarea1"
                rows="5"></textarea>
        </div>
        <div
            class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <label
                for="exampleFormControlTextarea1">Pendencies</label>
            <textarea class="form-control"
                id="exampleFormControlTextarea1"
                rows="5"></textarea>
        </div>
    </div>
</div>
</div>

<input type="radio" name="tabs" id="tabtwo">
<label for="tabtwo"
style=" border-radius: 22px;padding: 12px;margin: 10px;">Approval</label>
<div class="tab">
<div class="content"
    style="padding:10px;background-color:white;">
    <div class="form-group row">
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6 col-form-label pull-left">Time
                since Approval</label>
            <input type="text"
                class="form-control control-form col-md-6"
                placeholder="hh:mm;ss" disabled />
        </div>
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6 col-form-label pull-left">Approval
                Time & Date</label>
            <input type="text"
                class="form-control control-form col-md-6"
                placeholder="hh:mm - dd/mm/yy"
                disabled />
        </div>
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6 col-form-label pull-left">Approval
                TAT</label>
            <input type="text"
                class="form-control control-form col-md-6"
                disabled />
        </div>
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6 col-form-label pull-left">Time
                period from case login in bank to
                approval from the bank</label>
            <input type="text"
                class="form-control control-form col-md-6"
                placeholder="hh:mm;ss" disabled />
        </div>
        <div class="col-md-12">
            <h5 style="margin-left: 1px;">Communications (Login to Approval)
            </h5>
        </div>
        <div class="row">
            <div
                class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                <div class="form-check">
                    <label class="form-check-label"
                        for="exampleCheck1">Calls to
                        bank at
                        Approval Stage</label>
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px; max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
          <div style="margin: 0 9px;padding: 10px;width: 0px; max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px; max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
           <div style="margin: 0 9px;padding: 10px;width: 0px; max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
           <div style="margin: 0 9px;padding: 10px;width: 0px; max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px; max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
           <div style="margin: 0 9px;padding: 10px;width: 0px; max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
           <div style="margin: 0 9px;padding: 10px;width: 0px; max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
          <div style="margin: 0 9px;padding: 10px;width: 0px; max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
          <div style="margin: 0 9px;padding: 10px;width: 0px; max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
        </div>
        <div class="row">
            <div
                class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                <div class="form-check">
                    <label class="form-check-label"
                        for="exampleCheck1">Emails
                        to
                        bank
                        at Approval Stage</label>
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px; max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
         <div style="margin: 0 9px;padding: 10px;width: 0px; max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px; max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px; max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
           <div style="margin: 0 9px;padding: 10px;width: 0px; max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px; max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
           <div style="margin: 0 9px;padding: 10px;width: 0px; max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
           <div style="margin: 0 9px;padding: 10px;width: 0px; max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px; max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px; max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <h5>Approval Case Order</h5>
        </div>
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6 col-form-label pull-left">Recievable
                Loan Amount</label>
            <input type="text"
                class="form-control control-form col-md-6"
                disabled />
        </div>
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6 col-form-label pull-left">ROI</label>
            <input type="text"
                class="form-control control-form col-md-6"
                disabled />
        </div>
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6 col-form-label pull-left">PF</label>
            <input type="text"
                class="form-control control-form col-md-6"
                disabled />
        </div>
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6 col-form-label pull-left">Insurance</label>
            <input type="text"
                class="form-control control-form col-md-6"
                disabled />
        </div>
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6 col-form-label pull-left">Other
                Charges</label>
            <input type="text"
                class="form-control control-form col-md-6"
                disabled />
        </div>
        <div class="col-md-12">
            <h5>Communication & Follow-Ups</h5>
        </div>
        <div
            class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <label
                for="exampleFormControlTextarea1">Interaction
                we would do/messaging to be done
                with Bank/Lender (keep like note
                making of comm/instruction to be
                given the bank)</label>
            <textarea class="form-control"
                id="exampleFormControlTextarea1"
                rows="5"></textarea>
        </div>
        <div
            class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <label
                for="exampleFormControlTextarea1">Latest
                Revert Recieved from the
                Bank/Lender</label>
            <textarea class="form-control"
                id="exampleFormControlTextarea1"
                rows="5"></textarea>
        </div>
        <div
            class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <label
                for="exampleFormControlTextarea1">Requirements
                From the Bank</label>
            <textarea class="form-control"
                id="exampleFormControlTextarea1"
                rows="5"></textarea>
        </div>
        <div
            class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <label
                for="exampleFormControlTextarea1">Pendencies</label>
            <textarea class="form-control"
                id="exampleFormControlTextarea1"
                rows="5"></textarea>
        </div>
    </div>
</div>
</div>

<input type="radio" name="tabs" id="tabthree">
<label for="tabthree"
style=" border-radius: 22px;padding: 12px;margin: 10px;">Disbursal</label>
<div class="tab">
<div class="content"
    style="padding:10px;background-color:white;">
    <div class="form-group row">
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6 col-form-label pull-left">Time
                since Login</label>
            <input type="text"
                class="form-control control-form col-md-6"
                placeholder="hh:mm;ss" disabled />
        </div>
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6 col-form-label pull-left">Login
                Time & Date</label>
            <input type="text"
                class="form-control control-form  col-md-6"
                placeholder="hh:mm - dd/mm/yy"
                disabled />
        </div>
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6 col-form-label pull-left">Login
                TAT</label>
            <input type="text"
                class="form-control control-form col-md-6"
                disabled />
        </div>
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6 col-form-label pull-left">Time
                from Case create to case login in
                bank</label>
            <input type="text"
                class="form-control control-form  col-md-6"
                placeholder="hh:mm;ss" disabled />
        </div>
        <div class="col-md-12">
            <h5 style="margin-left: 1px;">Communications (Approval to
                Disbursal)</h5>
        </div>
        <div class="row">
            <div
                class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                <div class="form-check">
                    <label class="form-check-label"
                        for="exampleCheck1">Calls to
                        bank at
                        Disbursal Stage</label>
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px;max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
             <div style="margin: 0 9px;padding: 10px;width: 0px;max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
             <div style="margin: 0 9px;padding: 10px;width: 0px;max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px;max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px;max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px;max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px;max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
             <div style="margin: 0 9px;padding: 10px;width: 0px;max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px;max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
             <div style="margin: 0 9px;padding: 10px;width: 0px;max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
        </div>
        <div class="row">
            <div
                class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                <div class="form-check">
                    <label class="form-check-label"
                        for="exampleCheck1">Emails
                        to
                        bank
                        at Disbursal Stage</label>
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px;max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
             <div style="margin: 0 9px;padding: 10px;width: 0px;max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
             <div style="margin: 0 9px;padding: 10px;width: 0px;max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
              <div style="margin: 0 9px;padding: 10px;width: 0px;max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
             <div style="margin: 0 9px;padding: 10px;width: 0px;max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
             <div style="margin: 0 9px;padding: 10px;width: 0px;max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px;max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
            <div style="margin: 0 9px;padding: 10px;width: 0px;max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
             <div style="margin: 0 9px;padding: 10px;width: 0px;max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
             <div style="margin: 0 9px;padding: 10px;width: 0px;max-width: 0%;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        id="exampleCheck1">
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <h5>Disbursed Case Order</h5>
        </div>
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6 col-form-label pull-left">Disbursed
                Loan Amount</label>
            <input type="text"
                class="form-control control-form col-md-6"
                disabled />
        </div>
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6 col-form-label pull-left">ROI</label>
            <input type="text"
                class="form-control control-form col-md-6"
                disabled />
        </div>
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6 col-form-label pull-left">PF</label>
            <input type="text"
                class="form-control control-form col-md-6"
                disabled />
        </div>
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6 col-form-label pull-left">Insurance</label>
            <input type="text"
                class="form-control control-form col-md-6"
                disabled />
        </div>
        <div
            class="col-xs-12 col-sm-6 col-lg-6 mb-3">
            <label for="dealerCC"
                class="col-sm-6 col-lg-6 col-form-label pull-left">Other
                Charges</label>
            <input type="text"
                class="form-control control-form col-md-6"
                disabled />
        </div>
        <div class="col-md-12">
            <h5>Communication & Follow-Ups</h5>
        </div>
        <div
            class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <label
                for="exampleFormControlTextarea1">Interaction
                we would do/messaging to be done
                with Bank/Lender (keep like note
                making of comm/instruction to be
                given the bank)</label>
            <textarea class="form-control"
                id="exampleFormControlTextarea1"
                rows="5"></textarea>
        </div>
        <div
            class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <label
                for="exampleFormControlTextarea1">Latest
                Revert Recieved from the
                Bank/Lender</label>
            <textarea class="form-control"
                id="exampleFormControlTextarea1"
                rows="5"></textarea>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="tab-pane" id="6a">
<form method="POST" class="needs-validation" id="CaseForm" action="" novalidate enctype="multipart/form-data">
@csrf
<input type="hidden" name="id" value="{{ $cases->id }}">
<div class="row">
<div class="col-md-4"></div>
<div class="side-card col-md-8">
<div class="inner-card">
<div class="content p-4">
<div class="personal">
<img src="images/avtar.svg" />
<span>Case Id : #{{ $cases->id  }}</span>
<span class="infom">Personal Information</span>
</div>
<div class="form-group row pt-3">
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label>First Name</label>
<input type="text" name="first_name" value="{{ $cases->first_name }}" class="form-control" placeholder="First Name" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label>Last Name</label>
<input type="text" name="last_name" value="{{ $cases->last_name }}" class="form-control" placeholder="Last Name" />
</div>
<div class="date_filter col-xs-12 col-sm-6 col-lg-4 mb-3">
<label>Date of Birth</label>
<input type="date" value="<?php echo date("Y-m-d",strtotime($cases->date_of_birth)); ?>" class="form-control" name="date_of_birth">
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3 ">
<label>Email</label>
<input type="text" value="{{ $cases->email }}" name="email" class="form-control"
placeholder="Email" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label>Mobile Number</label>
<input type="text" value="{{ $cases->mobile }}" name="mobile" class="form-control"
placeholder="Mobile Number" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
    <label>CIBIL</label>
    <input type="text" name="cibil" value="{{ $cases->cibil }}" class="form-control" placeholder="CIBIL" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
    <label>Pincode</label>
    <input type="text" name="pin_code" value="{{ $cases->pin_code }}" class="form-control" placeholder="Pincode" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
    <label>Degree</label>
    <input type="text" name="highest_degree" value="{{ $cases->highest_degree }}" class="form-control" placeholder="Degree" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
    <label>Email</label>
    <input type="text" name="email" value="{{ $cases->email }}" class="form-control" placeholder="Email" />
</div>
</div>
<div class="personal col-md-12">
<div class="row">
<span class="infom">Address</span>
</div>
</div>
<div class="form-group row pt-3">
<div class="col-xs-12 col-sm-12 col-lg-8">
<label>Residential Address</label>
<small class="form-text text-muted">Please fill your
customer's complete current residential address,
here.we recommend match with their address
proff</small>
<input type="text" value="{{ $cases->address }}" name="address" class="form-control"
placeholder="Address" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-4"
style="padding-top: 37px;">
<label for="exampleFormControlSelect1">Address Type</label>
<select class="form-control" name="address_type" 
id="exampleFormControlSelect1">
<option value=""> Select Status</option>
<option value="Permanent Address"  <?php if('Permanent Address' == $cases->address_type){ echo "selected";} ?> >Permanent Address</option>
<option value="Present Address"  <?php if('Present Address' == $cases->address_type){ echo "selected";} ?> >Present Address</option>
<option value="Any Other Address"  <?php if('Any Other Address' == $cases->address_type){ echo "selected";} ?> >Any Other Address</option>



</select>
</div>
<div class="col-xs-12 col-sm-12 col-lg-4"
style="padding-top: 37px;">
<label for="exampleFormControlSelect1">Residential Status</label>
<select class="form-control" name="residential_status" 
id="exampleFormControlSelect1">
<option value=""> Select Status</option>
<?php foreach ($resi_status as $key => $value) { 
    ?>
   <option value="<?php echo $value->status_name; ?>"  <?php if($value->status_name == $cases->residential_status){ echo "selected";} ?> ><?php echo $value->status_name; ?></option>
<?php  } ?>


</select>
</div>
</div>

<div class="personal col-md-12">
<div class="row">
<span class="infom">Loan Details</span>
</div>
</div>
<div class="form-group row pt-3">
    <div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
         <label>Tenure (In Month)</label>
            <input type="number" value="{{ $cases->loan_period }}" name="loan_period" class="form-control" placeholder="Tenure" />
    </div>

    <div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
        <label for="exampleFormControlSelect1">Past Loans</label>
            <select class="form-control" name="past_loans" id="exampleFormControlSelect1">
                <option value=""> Select </option>
                <option value="Yes"  <?php if($cases->past_loans == 'Yes'){ echo "selected";} ?> >Yes</option>
                <option value="No"  <?php if($cases->past_loans == 'No'){ echo "selected";} ?> >No</option>
            </select>
    </div>

    <div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
        <label for="exampleFormControlSelect1">Purpose Of Loan</label>
            <select class="form-control" name="load_purpose" id="exampleFormControlSelect1">
                <option value=""> Select Loan Purpose </option>
                <?php foreach ($loan_purpose as $key => $value) { ?>
                    <option value="<?=$value->purpose?>" <?php if($value->purpose == $cases->load_purpose){ echo 'selected';} ?>> <?=$value->purpose?> </option>
                <?php } ?>
            </select>
    </div>
    
    <div class="col-xs-12 col-sm-12 col-lg-4">
        <label for="exampleFormControlSelect1">Type Of Product</label>
            <select class="form-control" id="exampleFormControlSelect1" name="selected_loan">
            <option>Select Type Of Product</option>
            <?php

                foreach ($loans_products as $key => $value) { ?>
                    <option value="<?=$value->id?>" <?php if($value->id == $cases->selected_loan){ echo "selected";} ?> ><?=$value->Loan_product_name?></option>
                <?php }
              ?>
            </select>
    </div>
    <div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
         <label>Desired Amount</label>
            <input type="number" value="{{ $cases->load_amount }}" name="load_amount" class="form-control" placeholder="Desired Amount" />
    </div>
    <div class="col-xs-12 col-sm-12 col-lg-4">
        <label for="exampleFormControlSelect1">Loan Type</label>
            <select class="form-control" id="exampleFormControlSelect1" name="load_type">
            <option>Select Loan Type</option>
            <?php

                foreach ($loan_types as $key => $value) { ?>
                    <option value="<?=$value->loan_type?>" <?php if($value->loan_type == $cases->load_type){ echo "selected";} ?> ><?=$value->loan_type?></option>
                <?php }
              ?>
            </select>
    </div>
</div>


<?php if($cases->employment_type == 'Salaried+Self Employed' || $cases->employment_type == 'Salaried'){ ?>

<div class="personal col-md-12">
<div class="row">
<span class="infom">Employeement Type Details - Salaried</span>
</div>
</div>
<div class="form-group row pt-3">
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label>Occupation</label>
<input type="text" name="occupation" value="{{ $cases->occupation }}" class="form-control" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label>Company</label>
<input type="text" name="employer_name" value="{{ $cases->employer_name }}" class="form-control" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-4">
<label for="exampleFormControlSelect1">Industry</label>
<select class="form-control" id="exampleFormControlSelect1" name="industry">
    <option>Industry Type</option>
    <?php 
    foreach( $industry  as $key =>  $ind) { ?>
        <option value="<?=$ind->industry_name?>" <?php if($ind->industry_name == $cases->industry){ echo "selected";} ?>  ><?=$ind->industry_name?></option>
    <?php } ?>
</select>
</div>
<div class="col-xs-12 col-sm-12 col-lg-4">
<label for="exampleFormControlSelect1">Employment Type</label>
    <select class="form-control" id="" name="empoyeement_type">
        <option>Employeement Type</option> 
        <?php 
        foreach( $empoyeement_type  as $key =>  $empoyeement) { ?>
            <option value="<?=$empoyeement->employeement_type_name?>" <?php if($empoyeement->employeement_type_name == $cases->employment_type){ echo "selected";} ?>  ><?=$empoyeement->employeement_type_name?></option>
        <?php } ?>  
    </select>
</div>
<div class="col-xs-12 col-sm-12 col-lg-4">
<label for="exampleFormControlSelect1">Organization Type</label>
    <select class="form-control" id="exampleFormControlSelect1" name="organisation_type">
        <option>Organization Type</option>
        <?php 
        foreach( $organistion_type  as $key =>  $types) { ?>
            <option value="<?=$types->organisation_type_name?>" <?php if($types->organisation_type_name == $cases->organisation_type){ echo "selected";} ?>  ><?=$types->organisation_type_name?></option>
        <?php } ?>
    </select>
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label>Monthly Salary(INR)</label>
<input type="text" name="monthly_salary" value="{{ $cases->monthly_salary }}" class="form-control" />
</div>

<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label>Annual Income</label>
<input type="text" name="inform_client_income" value="{{ $cases->inform_client_income }}" class="form-control" />
</div>

<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label>Work Experience</label>
<input type="number" name="work_experience" value="{{ $cases->work_experience }}" class="form-control" />
</div>

<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label>Experience With Current Company</label>
<input type="number" name="exp_with_current_employer" value="{{ $cases->exp_with_current_employer }}" class="form-control" />
</div>

<div class="col-xs-12 col-sm-12 col-lg-4">
<label for="exampleFormControlSelect1">Salary Recieved In?</label>
    <select class="form-control" id="exampleFormControlSelect1" name="mode_of_salary" required>
        <option>Salary Type</option>
        <?php 
        foreach( $mode_of_salaries  as $key =>  $types) { ?>
            <option value="<?=$types->salary_type?>" <?php if($types->salary_type == $cases->mode_of_salary){ echo "selected";} ?>  ><?=$types->salary_type?></option>
        <?php } ?>
    </select>
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label for="exampleFormControlSelect1">Business Premise Ownership Status</label>
<select class="form-control" id="exampleFormControlSelect1" name="premise_ownership_status">
<option>Select Status</option>
<?php

    foreach ($ownership_status as $key => $value) { ?>
        <option value="<?=$value->premise_status?>" <?php if($value->premise_status == $cases->premise_ownership_status){ echo "selected";} ?> ><?=$value->premise_status?></option>
    <?php }
  ?>
</select>
</div>
</div>
<?php } ?>
<?php if($cases->employment_type == 'Salaried+Self Employed' || $cases->employment_type == 'Self Employed'){ ?>
<div class="personal col-md-12">
<div class="row">
    <span class="infom">Employeement Type Details - Self Employed</span>
</div>
</div>
<div class="form-group row pt-3">
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label>Business Name *</label>
<input type="text" name="firm_name" value="{{ $cases->firm_name }}" class="form-control" placeholder="Business Name" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label>Business Incorporated Year *</label>
<input type="text" value="{{ $cases->how_old_business }}" name="how_old_business" class="form-control" placeholder="Business Incorporated Year" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label for="exampleFormControlSelect1">Business Organization Type</label>
    <select class="form-control" id="exampleFormControlSelect1" name="organisation_type">
        <option>Business Organization Type</option>
        <?php 
        foreach( $organistion_type  as $key =>  $type) { ?>
            <option value="<?=$type->organisation_type_name?>" <?php if($type->organisation_type_name == $cases->organisation_type){ echo "selected";} ?>  ><?=$type->organisation_type_name?></option>
        <?php } ?>
    </select>
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label for="exampleFormControlSelect1">Industry*</label>
    <select class="form-control" id="exampleFormControlSelect1">
        <option>Industry Type</option>
        <?php 
        foreach( $industry  as $key =>  $ind) { ?>
            <option value="<?=$ind->industry_name?>" <?php if($ind->industry_name == $cases->business_industry){ echo "selected";} ?>  ><?=$ind->industry_name?></option>
        <?php } ?>
    </select>
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label>Annual Business Income in INR</label>
<!-- <input type="text" name="client_income" value="{{ $cases->client_income }}" class="form-control" /> -->
<input type="text" name="inform_client_income" value="<?=$cases->inform_client_income?>" class="form-control" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label for="exampleFormControlSelect1">Business Premise Ownership Status</label>
<select class="form-control" id="exampleFormControlSelect1" name="premise_ownership_status">
<option>Select Status</option>
<?php

    foreach ($ownership_status as $key => $value) { ?>
        <option value="<?=$value->premise_status?>" <?php if($value->premise_status == $cases->premise_ownership_status){ echo "selected";} ?> ><?=$value->premise_status?></option>
    <?php }
  ?>
</select>
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label>Work Experience</label>
<input type="number" name="work_experience" value="{{ $cases->work_experience }}" class="form-control" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label for="exampleFormControlSelect1">Any Past Loan</label>
<select class="form-control" id="exampleFormControlSelect1" name="past_loans">
    <option>Selected</option>
    <option value="Yes" <?php if($cases->past_loans == 'Yes'){ echo "selected";} ?> >Yes</option>
    <option value="No" <?php if($cases->past_loans == 'No'){ echo "selected";} ?>>No</option>
</select>
</div>

<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label for="exampleFormControlSelect1">Income Method</label>
<select class="form-control" id="exampleFormControlSelect1" name="income_method">
<option>Select Income Method</option>
<?php

    foreach ($income_methods as $key => $value) { ?>
        <option value="<?=$value->income_method_name?>" <?php if($value->income_method_name == $cases->income_method){ echo "selected";} ?> ><?=$value->income_method_name?></option>
    <?php }
  ?>
</select>
</div>

<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label for="exampleFormControlSelect1">Primary Account</label>
<select class="form-control" id="exampleFormControlSelect1" name="primary_account">
<option>Select Primary Account</option>
<?php

    foreach ($primary_accounts as $key => $value) { ?>
        <option value="<?=$value->bank_name?>" <?php if($value->bank_name == $cases->primary_account){ echo "selected";} ?> ><?=$value->bank_name?></option>
    <?php }
  ?>
</select>
</div>

</div>
<?php } ?>
<!-- ============Personal Loan============== -->

<?php if($cases->load_type == 'Personal'){ ?>

<div class="personal col-md-12">
<div class="row">
<span class="infom">Employeement Type Details - Salaried</span>
</div>
</div>
<div class="form-group row pt-3">
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label>Occupation</label>
<input type="text" name="occupation" value="{{ $cases->occupation }}" class="form-control" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label>Company</label>
<input type="text" name="employer_name" value="{{ $cases->employer_name }}" class="form-control" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-4">
<label for="exampleFormControlSelect1">Industry</label>
<select class="form-control" id="exampleFormControlSelect1" name="industry">
    <option>Industry Type</option>
    <?php 
    foreach( $industry  as $key =>  $ind) { ?>
        <option value="<?=$ind->industry_name?>" <?php if($ind->industry_name == $cases->industry){ echo "selected";} ?>  ><?=$ind->industry_name?></option>
    <?php } ?>
</select>
</div>
<div class="col-xs-12 col-sm-12 col-lg-4">
<label for="exampleFormControlSelect1">Employment Type</label>
    <select class="form-control" id="" name="employment_type">
        <option>Employeement Type</option> 
        <?php 
        foreach( $empoyeement_type  as $key =>  $empoyeement) { ?>
            <option value="<?=$empoyeement->employeement_type_name?>" <?php if($empoyeement->employeement_type_name == $cases->employment_type){ echo "selected";} ?>  ><?=$empoyeement->employeement_type_name?></option>
        <?php } ?>  
    </select>
</div>
<div class="col-xs-12 col-sm-12 col-lg-4">
<label for="exampleFormControlSelect1">Organization Type</label>
    <select class="form-control" id="exampleFormControlSelect1" name="organisation_type">
        <option>Organization Type</option>
        <?php 
        foreach( $organistion_type  as $key =>  $types) { ?>
            <option value="<?=$types->organisation_type_name?>" <?php if($types->organisation_type_name == $cases->organisation_type){ echo "selected";} ?>  ><?=$types->organisation_type_name?></option>
        <?php } ?>
    </select>
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label>Monthly Salary(INR)</label>
<input type="text" name="monthly_salary" value="{{ $cases->monthly_salary }}" class="form-control" />
</div>

<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label>Work Experience</label>
<input type="number" name="work_experience" value="{{ $cases->work_experience }}" class="form-control" />
</div>

<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label>Experience With Current Company</label>
<input type="number" name="exp_with_current_employer" value="{{ $cases->exp_with_current_employer }}" class="form-control" />
</div>

<div class="col-xs-12 col-sm-12 col-lg-4">
<label for="exampleFormControlSelect1">Salary Recieved In?</label>
    <select class="form-control" id="exampleFormControlSelect1" name="mode_of_salary">
        <option>Salary Type</option>
        <?php 
        foreach( $mode_of_salaries  as $key =>  $types) { ?>
            <option value="<?=$types->salary_type?>" <?php if($types->salary_type == $cases->mode_of_salary){ echo "selected";} ?>  ><?=$types->salary_type?></option>
        <?php } ?>
    </select>
</div>

</div>
<?php } ?>

<!-- ======Business Loan============== -->

<?php if($cases->load_type == 'Business'){ ?>
<div class="personal col-md-12">
<div class="row">
    <span class="infom">Business Details</span>
</div>
</div>
<div class="form-group row pt-3">
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label>Business Name *</label>
<input type="text" name="firm_name" value="{{ $cases->firm_name }}" class="form-control" placeholder="Business Name" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label>Business Incorporated Year *</label>
<input type="text" value="{{ $cases->how_old_business }}" name="how_old_business" class="form-control" placeholder="Business Incorporated Year" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label for="exampleFormControlSelect1">Business Organization Type</label>
    <select class="form-control" id="exampleFormControlSelect1" name="organisation_type">
        <option>Business Organization Type</option>
        <?php 
        foreach( $organistion_type  as $key =>  $type) { ?>
            <option value="<?=$type->organisation_type_name?>" <?php if($type->organisation_type_name == $cases->organisation_type){ echo "selected";} ?>  ><?=$type->organisation_type_name?></option>
        <?php } ?>
    </select>
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3" style="padding-top:21px;">
<label for="exampleFormControlSelect1">Industry*</label>
    <select class="form-control" id="exampleFormControlSelect1">
        <option>Industry Type</option>
        <?php 
        foreach( $industry  as $key =>  $ind) { ?>
            <option value="<?=$ind->industry_name?>" <?php if($ind->industry_name == $cases->business_industry){ echo "selected";} ?>  ><?=$ind->industry_name?></option>
        <?php } ?>
    </select>
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label>Annual Business Income in INR</label>
<!-- <input type="text" name="client_income" value="{{ $cases->client_income }}" class="form-control" /> -->
<input type="text" name="inform_client_income" value="{{ $cases->inform_client_income }}" class="form-control" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label for="exampleFormControlSelect1">Business Premise Ownership Status</label>
<select class="form-control" id="exampleFormControlSelect1" name="premise_ownership_status">
<option>Select Status</option>
<?php

    foreach ($ownership_status as $key => $value) { ?>
        <option value="<?=$value->premise_status?>" <?php if($value->premise_status == $cases->premise_ownership_status){ echo "selected";} ?> ><?=$value->premise_status?></option>
    <?php }
  ?>
</select>
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label>Business Health</label>
<!-- <input type="text" name="client_income" value="{{ $cases->client_income }}" class="form-control" /> -->
<input type="Text" name="business_health" value="<?=$cases->business_health?>" class="form-control" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label>Age of business(In years)</label>
<!-- <input type="text" name="client_income" value="{{ $cases->client_income }}" class="form-control" /> -->
<input type="Text" name="years_in_business" value="<?=$cases->years_in_business?>" class="form-control" />
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label for="exampleFormControlSelect1">Has business been profitable for last 2 years</label>
<select class="form-control" id="exampleFormControlSelect1" name="profitability_years">
<option>Select Status</option>

<option value="Yes" <?php if('Yes' == $cases->profitability_years){ echo "selected";} ?> >Yes</option>
<option value="No" <?php if('No' == $cases->profitability_years){ echo "selected";} ?> >No</option>
   
</select>
</div>
<div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label for="exampleFormControlSelect1">Primary Account</label>
<select class="form-control" id="exampleFormControlSelect1" name="primary_account">
<option>Select Primary Account</option>
<?php

    foreach ($primary_accounts as $key => $value) { ?>
        <option value="<?=$value->bank_name?>" <?php if($value->bank_name == $cases->primary_account){ echo "selected";} ?> ><?=$value->bank_name?></option>
    <?php }
  ?>
</select>
</div>
<!-- <div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
<label for="exampleFormControlSelect1">Any Past Loan</label>
<select class="form-control" id="exampleFormControlSelect1" name="past_loans">
    <option>Selected</option>
    <option value="Yes" <?php if($cases->past_loans == 'Yes'){ echo "selected";} ?> >Yes</option>
    <option value="No" <?php if($cases->past_loans == 'No'){ echo "selected";} ?>>No</option>
</select>
</div> -->

</div>
<?php } ?>
<div class="personal col-md-12">
<div class="row">
<span class="infom">Obligation</span>
</div>
</div>
<div class="form-group row pt-3">
<div class="col-xs-12 col-sm-12 col-lg-12">
<label>Total Monthly EMI Obligation in INR</label>
<small class="form-text text-muted">(including Credit
Cards,Loans,Insurance & Others)</small>
<input type="text" name="ongoing_monthly_obligations" value="{{ $cases->ongoing_monthly_obligations }}" class="form-control"
placeholder="Total Monthly EMI Obligation in INR" />
</div>
</div>
<div class="edit-btn col-md-6">
<button type="submit" name="submit" class="edit btn btn-group">Update</button>
</div>
</div>

</div>

</div>

</div>
</form>
</div>
</div>
<!-- <div class="tab-pane" id="4a">
<h3>We use css to change the background color of the content to be equal to the tab</h3>
</div> -->
</div>

</div>







                        <!-- Bootstrap core JavaScript
        ================================================== -->
                        <!-- Placed at the end of the document so the pages load faster -->
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
                        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
                    </div>

                </div>
                       
                   <!--  </div>
                </div>
            </div>
        </div> -->


    </div>
</main>  
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div> 
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<!-- <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="{{ asset('js/bootstrap-multiselect.js') }}"></script>
<script src="{{ asset('js/cases.js') }}"></script>

<script>
$(document).ready(function () {
    $('#case_status').on('change', function() { 
          var status = this.value;   
          $("#case_status2").val(status);     
          if(status == 'Verifying Eligibility'){
            $("#eligibility_yes_no").css('display', '');
          }else{
            $("#eligibility_yes_no").css('display', 'none');
          }
          if(status == 'Approved'){
            $("#final_loan").css('display', '');
            $("#status_button").css('display', 'none');
            $("#status_explanation").css('display', 'none');
            
          }else{
            $("#final_loan").css('display', 'none');
            $("#status_button").css('display', '');
            $("#status_explanation").css('display', '')
          }
        });

    if($('#case_status').val() == 'Verifying Eligibility'){
         $("#eligibility_yes_no").css('display', '');
    }else{
            $("#eligibility_yes_no").css('display', 'none');
          }

    if($('#case_status').val() == 'Approved'){
         $("#final_loan").css('display', '');
         $("#status_button").css('display', 'none');
            $("#status_explanation").css('display', 'none');
    }else{
            $("#final_loan").css('display', 'none');
          }
});


     function changeStatusDocument(id,status) {

        if(status == '1') status = 'No';

        else status = 'Yes';

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            type: "get",
            url: "{{ route('Case-Status-Document') }}",
            data: {
                'id' : id,
                'status' : status
            },        
            success:function(data)
            {
               var data = JSON.parse(data);

               if(data.message == 'success')
               {   
                toastr.success(data.msg)                    
                 setTimeout(function() {
                     window.location.reload();
                  }, 1000);
               }
               else if(data.message == 'fail')
               {
                toastr.error(data.msg)                  

               }
            },
            error:function()
            {
               $("#ErrorMessage").show();
            }
        });

    }

    function changeFlagDocument(id,status) {

        if(status == 1) status = 'No';

        else status = 'Yes';

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            type: "get",
            url: "{{ route('Case-Flag-Document') }}",
            data: {
                'id' : id,
                'status' : status
            },        
            success:function(data)
            {
               var data = JSON.parse(data);

               if(data.message == 'success')
               {   
                toastr.success(data.msg)                    

               }
               else if(data.message == 'fail')
               {
                toastr.error(data.msg)                   

               }
            },
            error:function()
            {
               $("#ErrorMessage").show();
            }
        });

    }
$(document).ready(function () {
    $("#profile_btn").click(function () {
        $("#profile").toggle();
    });
   
    $("#DocumentsForm").submit(function(e){
            e.preventDefault(); 
            $.ajaxSetup({

                headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}

            });                 
            $.ajax({
                type: "POST",
                url: '{{ route('Case-Document-type') }}',
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success:function(data)
                {
                   var data = JSON.parse(data);

                   if(data.message == 'success')
                   {   
                    toastr.success(data.msg)                    

                   }
                   else if(data.message == 'fail')
                   {
                    toastr.error(data.msg)                   

                   }
                },
                error:function()
                {
                   $("#ErrorMessage").show();
                }
            });
        });
    $("#PolicyDetailsForm").submit(function(e){
            e.preventDefault(); 
            $.ajaxSetup({

                headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}

            });                 
            $.ajax({
                type: "POST",
                url: '{{ route('Case-Privacy-Policy') }}',
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success:function(data)
                {
                   var data = JSON.parse(data);

                   if(data.message == 'success')
                   {   
                    toastr.success(data.msg)                    

                   }
                   else if(data.message == 'fail')
                   {
                    toastr.error(data.msg)                   

                   }
                },
                error:function()
                {
                   $("#ErrorMessage").show();
                }
            });
        });
    $("#CommentsForm").submit(function(e){
            e.preventDefault(); 
            $.ajaxSetup({

                headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}

            });                 
            $.ajax({
                type: "POST",
                url: '{{ route('Case-Comments') }}',
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success:function(data)
                {
                   var data = JSON.parse(data);

                   if(data.message == 'success')
                   {  
                    //toastr.success(data.msg) 
                     $(".alert-success").css('display','');
                    
                    var comment = $("#user_comments").val();
                    $("#recent_comment").html(comment);
                    $(".recent_comment").css('display','');
                    $("#user_comments").val('');
                   }
                   else if(data.message == 'fail')
                   {
                    toastr.error(data.msg)                   

                   }
                },
                error:function()
                {
                   $("#ErrorMessage").show();
                }
            });
        });
   $("#FinalBankApprovalForm").submit(function(e){
            e.preventDefault(); 
            $.ajaxSetup({

                headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}

            });                 
            $.ajax({
                type: "POST",
                url: '{{ route('Case-Final-Bank-Approval') }}',
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success:function(data)
                {
                   var data = JSON.parse(data);

                   if(data.message == 'success')
                   {   
                    toastr.success(data.msg)                    

                   }
                   else if(data.message == 'fail')
                   {
                    toastr.error(data.msg)                   

                   }
                },
                error:function()
                {
                   $("#ErrorMessage").show();
                }
            });
        });
    $("#EligibilityForm").submit(function(e){
            e.preventDefault(); 
            $.ajaxSetup({

                headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}

            });                 
            $.ajax({
                type: "POST",
                url: '{{ route('Case-Update-Eligibility') }}',
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success:function(data)
                {
                   var data = JSON.parse(data);

                   if(data.message == 'success')
                   {   
                    toastr.success(data.msg)                    

                   }
                   else if(data.message == 'fail')
                   {
                    toastr.error(data.msg)                   

                   }
                },
                error:function()
                {
                   $("#ErrorMessage").show();
                }
            });
        });
    $("#CaseForm").submit(function(e){
            e.preventDefault(); 
            $.ajaxSetup({

                headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}

            });                 
            $.ajax({
                type: "POST",
                url: '{{ route('Case-Update') }}',
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success:function(data)
                {
                   var data = JSON.parse(data);

                   if(data.message == 'success')
                   {   
                    toastr.success(data.msg)                    

                   }
                   else if(data.message == 'fail')
                   {
                    toastr.error(data.msg)                   

                   }
                },
                error:function()
                {
                   $("#ErrorMessage").show();
                }
            });
        });
        $("#casedetail").submit(function(e){
            e.preventDefault(); 
            $.ajaxSetup({

                headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}

            });                 
            $.ajax({
                type: "POST",
                url: '{{ route('Case-Document-type') }}',
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success:function(data)
                {
                   var data = JSON.parse(data);

                   if(data.message == 'success')
                   {   
                    toastr.success(data.msg)                    
                    location.reload();
                   }
                   else if(data.message == 'fail')
                   {
                    toastr.error(data.msg)                   

                   }
                },
                error:function()
                {
                   $("#ErrorMessage").show();
                }
            });
        });

});

    function myFunction() {
        var x = document.getElementById("myDIV");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
    // function addRow() {
    //     var table = document.getElementById("main");
    //     var rws = table.rows;
    //     var cols = table.rows[0].cells.length;
    //     var row = table.insertRow(rws.length);
    //     var cell;
    //     for (var i = 0; i < cols; i++) {
    //         cell = row.insertCell(i);
    //         cell.innerHTML = ' <input type="text" class="form-control datepicker" name="datepicker" id="datepicker" placeholder="--/--" />';
    //     }
    // }
    // $('.addnbtn').click(function(e) {
    //     event.preventDefault();
    //     $('.rappend').append('<tr id="row"><td scope="row" class="addedrow"><input type="text" class="form-control datepicker" name="datepicker" id="datepicker" placeholder="--/--" /> </td><td><div class="t-amount"> <span>Rs 1,00,000</span> </div></td> <td><div class="t-amount"> <span>34567823</span></div></td><td><div class="t-amounts"><div class="filey btn btn-lg "><i class="fa fa-arrow-circle-up"></i>Upload<input type="file" name="file" /></div> <p class="filesy">Upload or Drag and Drop the file</p></div> </td> <td><div class="t-amounts"><i class="folder fa fa-folder"></i><div><span>abcd.pdf</span></div> </div> </td></tr>');
    // });

    // $('.body').on('click', '.remove', function(e) {
    //     event.preventDefault();
    //     $(this).parents('.addedrow').remove();
    // });
    /*add row */
    $("#datepicker").datepicker({
        viewMode: 'years',
        format: 'mm-yyyy'
    });
    /* select placeholder */
    $('select').change(function () {
        if ($(this).children('option:first-child').is(':selected')) {
            $(this).addClass('placeholder');
        } else {
            $(this).removeClass('placeholder');
        }
    });

    $(document).on('click', '.allow-focus', function (e) {
        e.stopPropagation();
    });

    // function chkBoxFilter(checkbox_group, defaultHiddenIds = []) {
    //     var $chk = $("#" + checkbox_group + " input:checkbox");
    //     var table_id = $("#" + checkbox_group).data('associatedTable');
    //     $chk.filter((i) => !defaultHiddenIds.includes(i)).prop('checked', true)
    //     for (index of defaultHiddenIds) {
    //         $("#" + table_id).find('tr :nth-child(' + (index + 1) + ')').hide();
    //     }
    //     $chk.click(function () {
    //         var colToHide = $("#" + table_id + " th").filter("." + $(this).attr("name"));
    //         var index = $(colToHide).index();
    //         $("#" + table_id).find('tr :nth-child(' + (index + 1) + ')').toggle();
    //     });
    // }

    "use strict";

    function chkBoxFilter(checkbox_group, defaultHiddenIds) {
        if (defaultHiddenIds === void 0) {
            defaultHiddenIds = [];
        }

        var $chk = $("#" + checkbox_group + " input:checkbox");
        var table_id = $("#" + checkbox_group).data('associatedTable');
        $chk.filter(function (i) {
            return !defaultHiddenIds.includes(i);
        }).prop('checked', true);

        for (var _iterator = defaultHiddenIds, _isArray = Array.isArray(_iterator), _i = 0, _iterator = _isArray ?
            _iterator : _iterator[Symbol.iterator](); ;) {
            if (_isArray) {
                if (_i >= _iterator.length) break;
                index = _iterator[_i++];
            } else {
                _i = _iterator.next();
                if (_i.done) break;
                index = _i.value;
            }

            $("#" + table_id).find('tr :nth-child(' + (index + 1) + ')').hide();
        }

        $chk.click(function () {
            var colToHide = $("#" + table_id + " th").filter("." + $(this).attr("name"));
            var index = $(colToHide).index();
            $("#" + table_id).find('tr :nth-child(' + (index + 1) + ')').toggle();
        });
    }

    /* CC Main */
    $(function () {
        /* CC Main table visibility filter */
        chkBoxFilter("grpChkBoxCCMain", [6, 8, 9, 10, 17, 18, 19, 20, 21]);

    });

    $(document).ready(function () {
        $('#toggle-search-a').click(function () {
            $(this).toggleClass("active");
            if ($(this).hasClass("active")) {
                $(this).text("Show");
            } else {
                $(this).text("Hide");
            }
        });

        /* multiselect */
        $('#dealerCC, #dealerBranchCC, #locationCC, #YearCC, #MonthCC').multiselect({
            numberDisplayed: 1,
            includeSelectAllOption: true,
            allSelectedText: 'No option left ...',
            buttonContainer: '<div class="btn-group col-sm-6 col-lg-8" /> '
        });

    });


    // add div

</script>
<script>
    var row = 1;
    $(document).on("click", "#add-row", function () {
        var new_row = '<div class="button d-flex"><span><div class="custom-control custom-switch pt-1"data-toggle="tooltip"data-placement="top" title="Status"><input type="checkbox"class="custom-control-input" id="customSwitch"><lab for="customSwitch5"></label></div></span><span><a href="#" class="badge" style="background-color: #44CCFF;color: black;padding: 10px;padding-left: 20px;padding-right: 20px;margin-left: 20px;">Present Address proff </a></span><span><button class="btn btn-secondary ml-5" style="font-size:11px;"><i class="fas fa-file"></i></button></span><span><button class="btn btn-secondary ml-5" style="font-size:11px;">Submit to Doc</button></span></div><div class="area mt-2"><div class="form-group"><textarea class="form-control"id="exampleFormControlTextarea1"rows="2"placeholder="Comment for user"></textarea></div></div></div>';
        $('#test-body').append(new_row);
        row++;
        return false;
    });

    // Remove criterion
    $(document).on("click", ".delete-row", function () {
        //  alert("deleting row#"+row);
        if (row > 1) {
            $(this).closest('tr').remove();
            row--;
        }
        return false;
    });
</script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

<script> $(document).ready(function () {
        $('#toggle-search-a').click(function () {
            $(this).toggleClass("active");
            if ($(this).hasClass("active")) {
                $(this).text("Show");
            } else {
                $(this).text("Hide");
            }
        });

        /* multiselect */
        $('#dealerCC, #dealerBranchCC, #locationCC, #YearCC, #MonthCC').multiselect({
            numberDisplayed: 1,
            includeSelectAllOption: true,
            allSelectedText: 'No option left ...',
            buttonContainer: '<div class="btn-group col-sm-6 col-lg-8" /> '
        });

    });</script>
<script>
    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
    })
</script>