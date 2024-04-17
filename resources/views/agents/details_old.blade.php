@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <!-- start: Header row -->
    <div class="row">
        <header>
            <div class="top-header">
                <section class="header-top-left">
                    <div class="logo">
                        <a href="index.html">
                            <!-- <img src="images/go-org-logo.png" alt="GP ORG" /> -->
                            <h4 class="page-title">Therapist /Agent Details</h4>
                        </a>
                    </div>
                </section>
                <section class="header-top-right">
                    <!-- <div class="cat-logo">
                                        <img src="images/catlogo.png" alt="CATERPILLAR" />
                                    </div> -->
                    <div class="dropdown user-profile-main">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="userProfileMenu"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="userProfileMenu">
                            <p class="user-name">
                                <span id="initialname" class="name-initl"></span>
                                <span id="getFullName">Admin Name</span>
                            </p>
                            <p class="user-designation">Administrator</p>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void(0)" target="_blank">Settings <i
                                    class='fa fa-gear pull-right mt-1'></i></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void(0)" target="_blank">Sign Out <i
                                    class='fa fa-sign-out pull-right mt-1'></i></a>
                        </div>
                    </div>
                </section>
            </div>
            <div class="clearfix"></div>



        </header>
    </div>
    <!-- start: Main Container row -->
    <!-- <div class="row">
                        <div class="col-sm-12">
                            <h4 class="page-title">Contamination Control</h4>
                        </div>
                    </div> -->

    <!-- start: main container -->
    <div class="row">
        <div class="main1 col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <div class="dropdown">
                        <button class="profile-btn btn btn-secondary dropdown-toggle" type="button"
                             id="profile_btn" aria-haspopup="true" aria-expanded="false">
                            Profile
                        </button>
                        <div class="pro dropdown-menu" aria-labelledby="dropdownMenuButton" id="profile" style="display:none"> 
                            <div class="main-pro">
                                <div class="avtar">
                                    <img src="{{ asset('images/avtar.svg') }}" />
                                   <!--  <button class="edit btn btn-group">Edit</button> -->
                                </div>
                                <div class="profile">
                                    <span class="name">{{ @$agents->name }} 
                                       <!--  <input type="checkbox" name="status" value="Active" id="status"> -->
                                       <?php
                                       if($agents->disabled == '1') $checked = "checked";
                                        else $checked = "";
                                        ?>
                                        <input  onchange="changeStatus( <?=$agents->id?> ,<?=$agents->disabled?>)"  type="checkbox" <?= $checked ?>  value="{{ @$agents->disabled }}">

                                    </span><br />
                                    <span class="user">User ID : {{ @$agents->id }}</span>
                                </div><br />
                                <div class="info">
                                    <span>{{ @$agents->current_profession }}</span><br />
                                    <span>@ {{ @$agents->employer_name }}</span><br />                                    
                                    <span>Financial Experience:{{ @$agents->financial_industry }}</span>
                                </div><br />
                                <div class="infooo">
                                    <ul class="infoo">
                                        <li><i class="fa fa-map-marker"></i> {{ @$agents->location }}</li>
                                        <li><i class="fa fa-envelope"></i> {{ @$agents->email }}</li>
                                        <li><i class="fa fa-phone"></i> {{ @$agents->mobile }}</li>
                                        <li><i class="fa fa-calendar"></i> Joined On {{ @$agents->created_at }}</li>
                                    </ul>
                                </div>
                                <div class="last-active">
                                    <span>Last Active:40Mins ago</span>
                                </div>
                            </div>
                            <div class="social-btn">
                                <a href="https://web.whatsapp.com/" target="_blank" class="whatsapp btn btn-group"><i class="fa fa-whatsapp"></i> WhatsApp to {{ @$agents->name }}</a>
                                <a href="https://mail.google.com/" target="_blank" class="mail btn btn-group"><i class="fa fa-envelope"></i> E-mail {{ @$agents->name }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div id="exTab1" class="container">
                        <ul class="nav nav-pills">
                            <li class="active">
                                <a href="#1a" data-toggle="tab">Cases</a>
                            </li>
                            <li><a href="#2a" data-toggle="tab">Summary</a>
                            </li>
                            <li><a href="#3a" data-toggle="tab">Bank & Earnings</a>
                            </li>
                            <li><a href="#4a" data-toggle="tab">Performance</a>
                            </li>
                            <li><a href="#4a" data-toggle="tab">Activity</a>
                            </li>
                        </ul>


                    </div>


                </div>
                <div class="col-md-12">
                    <div class="tab-content clearfix">
                        <div class="tab-pane active" id="1a">
                            <div class="filter-start col-md-12">
                                <div class="filter">
                                    <div class="heading">
                                        <p class="btn btn-group" onclick="myFunction()">
                                            <i class="fa fa-filter"></i> Filter
                                        </p>
                                    </div>
                                    <div class="filt" id="myDIV" style="display:none;">

                                        <div class="filters col-md-12">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <h5>Select Time Period</h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <form>
                                                        <div class="row">
                                                            <div class="col-md-6 form-group ">
                                                                <label for="fromFilter"
                                                                    class="col-sm-2 col-form-label">From</label>
                                                                <div class="col-sm-10">
                                                                    <input type="date" class="form-control"
                                                                        id="fromFilter" name="fromFilter">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 form-group ">
                                                                <label for="toFilter"
                                                                    class="col-sm-2 col-form-label">To</label>
                                                                <div class="col-sm-10">
                                                                    <input type="date" class="form-control"
                                                                        id="toFilter" name="toFilter">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="statuss col-md-2">
                                                    <select id="statusCase"
                                                        class="status-select form-control placeholder"
                                                        style="width: 180px;border:none;" multiple="multiple" style="display:none"
                                                        name="statusCase[]">
                                                        <option value="Cases Created">Cases Created</option>
                                                        <option value="Submitted">Submitted</option>
                                                        <option value="Bank Login">Bank Login</option>
                                                        <option value="Approved">Approved</option>
                                                        <option value="Disbursed">Disbursed</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-12" style="text-align:center;margin-top: -35px;">
                                                    <center><button type="button"
                                                            class="btn btn-outline-dark search-btn applyFilter"
                                                            id="btn-cc-search" style="padding: 3px;"><i
                                                                class="fa fa-search" aria-hidden="true"></i>
                                                            Search</button></center>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mis-heading">
                                    <input type="hidden" value="{{ route('Agent-Cases') }}" id="addressGetCases">
                                    <input type="hidden" value="{{ @$agents->id }}" id="agent_id" name="agent_id">
                                    <table id="misTable" class="display table-responsive" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="ActionGO">Action</th>
                                                <th class="AgentName">Name</th>
                                                <th class="MobileGO">Mobile</th>
                                                <th class="MobileGO">Location</th>
                                                <th class="EmailGO">Pincode</th>
                                                <th class="AadharPanGO">Company</th>
                                                <th class="OccupationGO">Designation</th>
                                                <th class="CeateDateGO">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="2a">
                             <meta name="csrf-token" content="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="side-card col-md-8">
                                    <form method="POST" class="needs-validation" id="summaryForm" action="" novalidate enctype="multipart/form-data">
                                        @csrf
                                    <div class="inner-card">
                                        <div class="inner1">
                                            <div class="inner-doc col-md-12">
                                                <div class="row">
                                                    <div class="docu col-md-6">
                                                        <span>User Profile</span>
                                                    </div>    
                                                    <div class="edit-btn col-md-6">
                                                    <button type="submit" name="submit" class="edit btn btn-group">Update</button>
                                                </div>                                                
                                                </div>
                                            </div>

                                        </div>
                                        
                                        <input type="hidden" value="{{ @$agents->id }}" name="id">
                                        <div class="inner col-md-12">
                                            <div class="row">
                                                <div class="form-group col-md-6" style="margin-bottom: 12px;">
                                                    <label for="employment_type" class="col-sm-2 col-form-label">Full Name</label>
                                                    <input type="text" class="col-sm-8 form-control" value="{{ @$agents->name }}" name="name" id="name" style="width: 60%;">

                                                </div>
                                                <div class="form-group col-md-6" style="margin-bottom: 12px;">

                                                    <label for="employment_type"
                                                        class="col-sm-2 col-form-label">User Id</label>


                                                    <input type="text" class="col-sm-8 form-control" value="{{ @$agents->id }}" readonly="" 
                                                        style="width: 60%;">

                                                </div>
                                                <div class="form-group col-md-6" style="margin-bottom: 12px;">

                                                    <label for="employment_type"
                                                        class="col-sm-2 col-form-label">Occupation</label>


                                                    <input type="text" class="col-sm-8 form-control" value="{{ @$agents->current_profession }}" name="current_profession" id="current_profession"
                                                        style="width: 60%;">

                                                </div>
                                                <div class="form-group col-md-6" style="margin-bottom: 12px;">

                                                    <label for="employment_type"
                                                        class="col-sm-2 col-form-label">Company</label>


                                                    <input type="text" class="col-sm-8 form-control" value="{{ @$agents->employer_name }}" name="employer_name" id="employer_name"
                                                        style="width: 60%;">

                                                </div>
                                                <div class="form-group col-md-6" style="margin-bottom: 12px;">

                                                    <label for="employment_type"
                                                        class="col-sm-2 col-form-label">Location</label>


                                                    <input type="text" class="col-sm-8 form-control" value="{{ @$agents->location }}" name="location" id="location"
                                                        style="width: 60%;">

                                                </div>
                                                <div class="form-group col-md-6" style="margin-bottom: 12px;">

                                                    <label for="employment_type"
                                                        class="col-sm-2 col-form-label">Phone Number</label>


                                                    <input type="text" class="col-sm-8 form-control" value="{{ @$agents->mobile }}" name="mobile" id="mobile"
                                                        style="width: 60%;">

                                                </div>
                                                 <div class="form-group col-md-6" style="margin-bottom: 12px;">

                                                    <label for="employment_type"
                                                        class="col-sm-2 col-form-label">Email</label>


                                                    <input type="text" class="col-sm-8 form-control" value="{{ @$agents->email }}" name="email" id="email"
                                                        style="width: 60%;">

                                                </div>
                                                 <div class="form-group col-md-6" style="margin-bottom: 12px;">

                                                    <label for="employment_type"
                                                        class="col-sm-2 col-form-label">Whatsapp Number</label>


                                                    <input type="text" class="col-sm-7 form-control" value="{{ @$agents->whatsapp_number }}" name="whatsapp_number" id="whatsapp_number"
                                                        style="width: 60%;">

                                                </div>
                                                <div class="form-group col-md-6" style="margin-bottom: 12px;">

                                                    <label for="employment_type"
                                                        class="col-sm-2 col-form-label">Financial Service Experience</label>


                                                     <input type="radio" name="financial_industry" value="Yes" id="yes" <?php if(@$agents->financial_industry == 'Yes'){ echo 'checked';} ?>> Yes
                                                        <input type="radio" name="financial_industry" value="No" id="No" <?php if(@$agents->financial_industry == 'No'){ echo 'checked';} ?>> No

                                                </div>
                                                <div class="form-group col-md-6" style="margin-bottom: 12px;">

                                                    <label for="employment_type"
                                                        class="col-sm-2 col-form-label">Joined On</label>


                                                    <input type="text" class="col-sm-8 form-control" value="{{ @$agents->created_at }}" readonly="" style="width: 60%;">

                                                </div>
                                                <div class="form-group col-md-6" style="margin-bottom: 12px;">

                                                    <label for="inputPassword"
                                                        class="col-sm-2 col-form-label">Gender</label>
                                                        <div style="margin-top: 5px;margin-left: 30px;">                                                 
                                                        <input type="radio" name="gender" value="Male" id="male" <?php if(@$agents->gender == 'Male'){ echo 'checked';} ?>> Male
                                                        <input type="radio" name="gender" value="Female" id="female" <?php if(@$agents->gender == 'Female'){ echo 'checked';} ?>> Female
                                                        <input type="radio" name="gender" value="Others" id="others" <?php if(@$agents->gender == 'Others'){ echo 'checked';} ?>> Others
                                                        </div>
                                                </div>
                                                <div class="form-group col-md-6" style="margin-bottom: 12px;">

                                                    <label for="employment_type"
                                                        class="col-sm-2 col-form-label">Employment Type</label>


                                                    <input type="text" class="col-sm-7 form-control" value="{{ @$agents->employment_type }}" name="employment_type" id="employment_type"
                                                        style="width: 60%;">

                                                </div>
                                                <div class="form-group col-md-6" style="margin-bottom: 0px;">

                                                    <label for="dob" class="col-sm-2 col-form-label">Date
                                                        of Birth</label>


                                                    <input type="date" class="col-sm-8 form-control" value="{{ @$agents->dob }}" name="dob" id="dob"
                                                        style="width: 66%;">

                                                </div>
                                                <div class="form-group col-md-6" style="margin-bottom: 0px;">

                                                    <label for="hold_gov_office" class="col-sm-2 col-form-label"
                                                        style="padding-top: 0px;">Themselves or Family
                                                        <br />Position in Gov./Politics</label>


                                                        <div style="margin-top: 5px;margin-left: 30px;">                                                 
                                                        <input type="radio" name="hold_gov_office" value="Yes" id="yes" <?php if(@$agents->hold_gov_office == 'Yes'){ echo 'checked';} ?> > Yes
                                                        <input type="radio" name="hold_gov_office" value="No" id="no" <?php if(@$agents->hold_gov_office == 'No'){ echo 'checked';} ?> > No
                                                       
                                                        </div>

                                                </div>
                                                <div class="form-group col-md-6" style="margin-top: 5px;">

                                                    <label for="work_experience" class="col-sm-2 col-form-label">Work
                                                        Experience</label>


                                                    <input type="number" class="col-sm-8 form-control" name="work_experience" value="{{ @$agents->work_experience }}" id="work_experience"
                                                        style="width: 59%;">

                                                </div>
                                                
                                            </div>
                                        </div>
                                        </form>
                                         <form method="POST" class="needs-validation" id="documentForm" action="" novalidate enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{ @$agents->id }}" name="id">
                                        <div class="inner1">
                                            <div class="inner-doc col-md-12">
                                                <div class="row">
                                                    <div class="docu col-md-6">
                                                        <span>Documents</span>
                                                    </div>
                                                    <div class="edit-bt col-md-6">
                                                        <button type="submit" class="edit btn btn-group">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="inner-box">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="kyc col-md-6"><span>KYC</span></div>

                                                    <div class="edit-bt col-md-6">
                                                        <!-- <button class="edit btn btn-group"><i class="fa fa-plus"></i>Add
                                                            Document</button> -->
                                                    </div>
                                                    @for($i = 0; $i < 5; $i++)
                                                        @php
                                                            $i_n = $i+1;
                                                        @endphp
                                                         @if(isset($url) && isset($files[$i]))
                                                        <div class="card-box col-md-3">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <a target="_blank" href="{{$url.$files[$i]}}">
                                                                    <i class="font fa fa-folder col-md-12" style="color:#212529;"></i>
                                                                    {!! Form::label("doc_$i_n", "Document $i_n") !!}
                                                                     </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    @endfor
                                                    <!-- <div class="card-box col-md-3">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <i class="font fa fa-folder col-md-12"></i>
                                                                <span class="col-md-12">PAN Card</span>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                   <!--  <div class="card-box col-md-3">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <i class="font fa fa-folder col-md-12"></i>
                                                                <span class="col-md-12">Front of Aadhaar</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-box col-md-3">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <i class="font fa fa-folder col-md-12"></i>
                                                                <span class="col-md-12">Back of Aadhaar</span>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <div class="col-md-3"></div>
                                                    <div class="kyc col-md-12"><span>LEGAL</span></div>
                                                                                        
                                                                @for($i = 0; $i < 1; $i++)
                                                                    @php
                                                                        $i_n = $i+1;
                                                                    @endphp
                                                                     @if(isset($url) && isset($documents[$i]))
                                                                    <div class="card-box col-md-3">
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <a target="_blank" href="{{$url.$documents[$i]}}">
                                                                                <i class="font fa fa-folder col-md-12" style="color:#212529;"></i> 
                                                                                <span class="service col-md-12">Service Partner
                                                                    Agreement</span>                 
                                                                                 </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                @endfor
                                                                
                                                           
                                                    <div class="card-box col-md-3">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="file btn btn-lg btn-primary col-md-12">
                                                                    <i class="fa fa-arrow-circle-up"></i>Upload
                                                                    <input type="file" name="agreement_document" />
                                                                </div><br /><br />
                                                                <span class="files">Upload or Drag and Drop the
                                                                    file</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="3a">
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="side-card col-md-8">
                                    <div class="inner-card">
                                         <form method="POST" class="needs-validation" id="bankEarningForm" action="" novalidate enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{ @$agents->id }}" name="id">
                                        <div class="inner col-md-12">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <div>
                                                        <label for="account_holder_name"
                                                            class="col-sm-2 col-form-label">Account Holder Name</label>
                                                    </div>
                                                    <div>
                                                        <input type="text" class="form-control" id="account_holder_name" name="account_holder_name" value="{{ @$agents->account_holder_name }}" 
                                                            style="width:101%;">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <div>
                                                        <label for="bank_name" class="col-sm-2 col-form-label">Bank
                                                            Account</label>
                                                    </div>
                                                    <div>
                                                        <input type="text" name="bank_name" value="{{ @$agents->bank_name }}" class="form-control" id="bank_name">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <div>
                                                        <label for="account_number"
                                                            class="col-sm-2 col-form-label">Account Number</label>
                                                    </div>
                                                    <div class="input2">
                                                       <input type="text" name="account_number" value="{{ @$agents->account_number }}" class="form-control" id="account_number">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <div><label for="exampleFormControlTextarea1"
                                                            class="col-sm-2 col-form-label">Address</label></div>
                                                    <div><textarea class="form-control" id="exampleFormControlTextarea1"
                                                            style="width:125%;height: 42.99px;" value="{{ @$agents->address }}" name="address" > {{ @$agents->address }}</textarea></div>
                                                </div>
                                                <div class="iscf form-group col-md-6">
                                                    <div>
                                                        <label for="ifsc_code" class="col-sm-2 col-form-label">IFSC
                                                            Code</label>
                                                    </div>
                                                    <div>
                                                        <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" value="{{ @$agents->ifsc_code }}" 
                                                            style="width:136%;">
                                                    </div>
                                                </div>
                                                <div class="edit-btn col-md-6">
                                                    <button type="submit" class="edit btn btn-group">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                     <form method="POST" class="needs-validation" id="transactionForm" action="" novalidate enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{ @$agents->id }}" name="agent_id">
                                        <div class="inner1">
                                            <div class="inner-doc col-md-12">
                                                <div class="row">
                                                    <div class="docu col-md-6">
                                                        <span>Transaction</span>
                                                    </div>
                                                    <div class="edit-bt col-md-6">
                                                        <button type="submit" class="edit btn btn-group">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="inner-box">
                                            <?php 
                                            if($transaction){
                                            ?>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="kyc col-md-6"><span>Details</span></div>
                                                    <div class="edit-bt col-md-6">
                                                        <button class="edit btn btn-group addnbtn" id='add-row'
                                                            value="Add new row"><i class="fa fa-plus"></i>Add
                                                            Transaction</button>
                                                    </div>

                                                    <div class="col-md-12" style="margin-left: -15px">
                                                        <div class="table-responsive">
                                                            <table id="test-table" class="table table-condensed">
                                                                <thead>
                                                                    <th scope="col">Period(From)</th>
                                                                    <th scope="col">Period(to)</th>
                                                                    <th scope="col">Total Amount</th>
                                                                    <th scope="col">Reference No.</th>
                                                                    <th scope="col">Transaction Receipt</th>
                                                                    <th scope="col">Files</th>
                                                                    <th></th>
                                                                </thead>
                                                                <tbody id="test-body">
                                                                    @foreach($transaction as $data)
                                                                    <tr id="row">
                                                                        <td scope="row">
                                                                            <input type="date"
                                                                                class="form-control "
                                                                                style="width:90%;" 
                                                                                name="from[]" id="from" value="{{ $data->from }}" required="" 
                                                                                />
                                                                        </td>
                                                                        <td scope="row">
                                                                            <input type="date"
                                                                                class="form-control"
                                                                                name="to[]" id="to" style="width: 90%; " value="{{ $data->to }}" required="" 
                                                                                 />
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" class="form-control" id="total_amount" style="width:100px;" name="total_amount[]" value="{{ $data->total_amount }}" required="" readonly="" />
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" class="form-control" id="reference_no" style="width:100px;" name="reference_no[]" value="{{ $data->reference_no }}" required="" readonly="" >
                                                                        </td>
                                                                        <td>
                                                                            <div class="t-amounts">
                                                                                <div class="filey btn btn-lg ">
                                                                                    <i
                                                                                        class="fa fa-arrow-circle-up"></i>Upload
                                                                                    <input type="file" name="receipt[]" required="" />
                                                                                </div>
                                                                                <p class="filesy">Upload or Drag and
                                                                                    Drop the file
                                                                                </p>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="t-amounts">
                                                                                <i class="folder fa fa-folder"></i>
                                                                                <div>
                                                                                    <span>abcd.pdf</span>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <!-- <input class='delete-row btn btn-primary' type='button' value='Delete' /> -->
                                                                            <button class="delete-row btn btn-group"><i
                                                                                    class="fa fa-trash"></i></button>
                                                                        </td>
                                                                        <!-- <td>
                                                                                        <button class="btn btn-group remove">Remove</button>
                                                                                    </td> -->
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                            }else{


                                            ?>


                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="kyc col-md-6"><span>Details</span></div>
                                                    <div class="edit-bt col-md-6">
                                                        <button class="edit btn btn-group addnbtn" id='add-row'
                                                            value="Add new row"><i class="fa fa-plus"></i>Add
                                                            Transaction</button>
                                                    </div>

                                                    <div class="col-md-12" style="margin-left: -15px">
                                                        <div class="table-responsive">
                                                            <table id="test-table" class="table table-condensed">
                                                                <thead>
                                                                    <th scope="col">Period(From)</th>
                                                                    <th scope="col">Period(to)</th>
                                                                    <th scope="col">Total Amount</th>
                                                                    <th scope="col">Reference No.</th>
                                                                    <th scope="col">Transaction Receipt</th>
                                                                    <th scope="col">Files</th>
                                                                    <th></th>
                                                                </thead>
                                                                <tbody id="test-body">
                                                                    <tr id="row">
                                                                        <td scope="row">
                                                                            <input type="date"
                                                                                class="form-control "
                                                                                style="width:90%;" 
                                                                                name="from[]" id="from" required="" 
                                                                                />
                                                                        </td>
                                                                        <td scope="row">
                                                                            <input type="date"
                                                                                class="form-control"
                                                                                name="to[]" id="to" style="width: 90%; "required="" 
                                                                                 />
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" class="form-control" id="total_amount" style="width:100px;" name="total_amount[]" value="" required=""/>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" class="form-control" id="reference_no" style="width:100px;" name="reference_no[]" value="" required="" >
                                                                        </td>
                                                                        <td>
                                                                            <div class="t-amounts">
                                                                                <div class="filey btn btn-lg ">
                                                                                    <i
                                                                                        class="fa fa-arrow-circle-up"></i>Upload
                                                                                    <input type="file" name="receipt[]" required="" />
                                                                                </div>
                                                                                <p class="filesy">Upload or Drag and
                                                                                    Drop the file
                                                                                </p>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="t-amounts">
                                                                                <i class="folder fa fa-folder"></i>
                                                                                <div>
                                                                                    <span>abcd.pdf</span>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <!-- <input class='delete-row btn btn-primary' type='button' value='Delete' /> -->
                                                                            <button class="delete-row btn btn-group"><i
                                                                                    class="fa fa-trash"></i></button>
                                                                        </td>
                                                                        <!-- <td>
                                                                                        <button class="btn btn-group remove">Remove</button>
                                                                                    </td> -->
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="tab-pane" id="4a">
                                        <h3>We use css to change the background color of the content to be equal to the tab</h3>
                                    </div> -->
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="{{ asset('js/bootstrap-multiselect.js') }}"></script>
<script src="{{ asset('js/cases.js') }}"></script>

<script type="text/javascript">
$(document).ready(function () {
    $("#profile_btn").click(function () {
        $("#profile").toggle();
    });
});
function changeStatus(agent_id,UserStatus) {

    if(UserStatus == '1') UserStatus = '0';

    else UserStatus = '1';

    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $.ajax({
        type: "get",
        url: "{{ route('Agent-Status') }}",
        data: {
            'id' : agent_id,
            'disabled' : UserStatus
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
    $(document).ready(function(){

    $(function(){
        var dtToday = new Date();
        
        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();
        
        var maxDate = year + '-' + month + '-' + day;



        var month1 = dtToday.getMonth() - 1;
        var day1 = dtToday.getDate();
        var year1 = dtToday.getFullYear();
        if(month1 < 10)
            month1 = '0' + month1.toString();
        if(day1 < 10)
            day1 = '0' + day1.toString();
        
        var minDate = year1 + '-' + month1 + '-' + day1;
        //alert(minDate);
        //new Date().getFullYear()
        
        $('#from,#to').attr('max', maxDate);
        $('#from,#to').attr('min', minDate);
    });
    });
    $(document).ready(function(){ 
        $("#documentForm").submit(function(e){
            e.preventDefault(); 
            $.ajaxSetup({

                headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}

            });                 
            $.ajax({
                type: "POST",
                url: '{{ route('Document-Update') }}',
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
  
    $("#summaryForm").submit(function(e){
            e.preventDefault(); 
            $.ajaxSetup({

                headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}

            });                 
            $.ajax({
                type: "POST",
                url: '{{ route('Summary-create') }}',
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
        $("#bankEarningForm").submit(function(e){
            e.preventDefault(); 
            $.ajaxSetup({

                headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}

            });                 
            $.ajax({
                type: "POST",
                url: '{{ route('Bank-Earnings-create') }}',
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

        $("#transactionForm").submit(function(e){
            e.preventDefault(); 
            $.ajaxSetup({

                headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}

            });                 
            $.ajax({
                type: "POST",
                url: '{{ route('Bank-Transaction-create') }}',
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
 });
</script>


<script>

function myFunction() {
        var x = document.getElementById("myDIV");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
//hide and show//
var row = 1;
$(document).on("click", "#add-row", function() {
    var new_row =
        '<tr id="row"><td scope="row"><input type="date"class="form-control "style="width:85%;"name="from[]" id="from"/></td><td scope="row"><input type="date"class="form-control"name="to[]" id="to" style="width: 85%;" /></td><td><input type="text" class="form-control" id="total_amount" style="width:100px;" name="total_amount[]" value=""/></td><td><input type="text" class="form-control" id="reference_no" style="width:100px;" name="reference_no[]" value="" ></td><td><div class="t-amounts"><div class="filey btn btn-lg "><iclass="fa fa-arrow-circle-up"></i>Upload<input type="file" name="receipt" /></div><p class="filesy">Upload or Drag and Drop the file</p></div></td><td><div class="t-amounts"><i class="folder fa fa-folder"></i><div><span>abcd.pdf</span></div></div></td><td><button class="delete-row btn btn-group"><i class="fa fa-trash"></i></button></td></tr>';
    $('#test-body').append(new_row);
    row++;
    return false;
});

// Remove criterion
$(document).on("click", ".delete-row", function() {
    //  alert("deleting row#"+row);
    if (row > 1) {
        $(this).closest('tr').remove();
        row--;
    }
    return false;
});
/* select placeholder */
$('select').change(function() {
    if ($(this).children('option:first-child').is(':selected')) {
        $(this).addClass('placeholder');
    } else {
        $(this).removeClass('placeholder');
    }
});

$(document).on('click', '.allow-focus', function(e) {
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
    $chk.filter(function(i) {
        return !defaultHiddenIds.includes(i);
    }).prop('checked', true);

    for (var _iterator = defaultHiddenIds, _isArray = Array.isArray(_iterator), _i = 0, _iterator = _isArray ?
            _iterator : _iterator[Symbol.iterator]();;) {
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

    $chk.click(function() {
        var colToHide = $("#" + table_id + " th").filter("." + $(this).attr("name"));
        var index = $(colToHide).index();
        $("#" + table_id).find('tr :nth-child(' + (index + 1) + ')').toggle();
    });
}

/* CC Main */
$(function() {
    /* CC Main table visibility filter */
    chkBoxFilter("grpChkBoxCCMain", [6, 8, 9, 10, 17, 18, 19, 20, 21]);

});

$(document).ready(function() {
    $('#toggle-search-a').click(function() {
        $(this).toggleClass("active");
        if ($(this).hasClass("active")) {
            $(this).text("Show");
        } else {
            $(this).text("Hide");
        }
    });

    /* multiselect */
    $('#dealerCC, #dealerBranchCC, #locationCC, #YearCC, #MonthCC, #statusCase').multiselect({
        numberDisplayed: 1,
        includeSelectAllOption: true,
        allSelectedText: 'No option left ...',
        buttonContainer: '<div class="btn-group col-sm-6 col-lg-8" /> '
    });

});



</script>