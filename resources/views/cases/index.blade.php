@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<style>
    .nav.active {
    color: #59CDFE !important;
    background: #59CDFE;
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
                            <a href="#">
                                <h4 class="page-title">Cases</h4>
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
            <div class="col-sm-12" style="height:100em;">
                <div class="card card-custom cc-home-main">
                    <div class="card-body body-card">

                        <div class="row">
                    <div class="col-sm-12 no-padding">
                        <div class="card card-custom">
                            <div class="card-body" style="padding: 0px;">

                            </div>
                            <div class="col-md-12 no-padding">
                                <div id="exTab1 reniatnoc" class="container">
                                    <ul class="nav nav-pills pills-nav">
                                        <li class="active">
                                            <a href="#1a" data-toggle="tab" >Professional Loan</a>
                                        </li>
                                        <li><a href="#2a" data-toggle="tab">Personal Loan</a>
                                        </li>
                                        <li><a href="#3a" data-toggle="tab">Business Loan</a>
                                        </li>
                                    </ul>


                                </div>


                            </div>
                            <div class="col-md-12">
                                <div class="tab-content clearfix" style="padding:0px;">
                                    <div class="tab-pane active" id="1a">
                                        <div class="content">
                                            <div class="custom-search-box box-search-custom-filter" style="margin-bottom:0px;    padding: 15px;">
                                                <p class="btn btn-group group-btn" onclick="myFunction()"
                                                    style="margin-bottom: 0px;">
                                                    <i class="fa fa-filter"></i> Filters
                                                </p>

                                                <div class="collapse show multiselect-ui" id="myDIV"
                                                    style="display: none;">  
                                                    <input type="hidden" value="{{ route('Proffesional-Cases') }}" id="getProfessionalUrl">


                                                     
                                                    <div class="form-group row">

                                

                                            <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                          
                                                <label for="dealerCC" class="col-sm-6 col-lg-4 col-form-label pull-left">User Name</label>
                                                    {{-- <input type="text" class="form-control" required="" placeholder="Enter name to search" id="proffesional_user_name"> --}}
                                                <select id="proffesional_user_id"
                                                    class="form-control">
                                                    <option value="" selected="selected">Please select</option>
                                                    <?php foreach ($data['agents'] as $agents){ if(!empty($agents['name'])){ ?>
                                                        <option value="<?php echo $agents['id']; ?>"><?php echo $agents['name']; ?></option>    
                                                    <?php } }   ?>
                                                </select>
                                            </div>

                         


                                                     
                                                        <!--<div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                                            <label for="dealerCC"
                                                                class="col-sm-6 col-lg-4 col-form-label pull-left">User
                                                                Name</label>
                                                            <input type="text" class="form-control" />
                                                        </div>-->


                                                        <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                                            <label for="proffesional_location"
                                                                class="col-sm-6 col-lg-4 col-form-label pull-left">Location</label>
                                                             <input type="text" class="form-control" placeholder="Enter location" id="proffesional_location">
                                                        </div>
                                                        {{-- <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                                            <label for="locationCC" class="col-sm-6 col-lg-4 col-form-label
                                                                  pull-left">State</label>
                                                            <select id="locationCC"
                                                                class="form-control col-sm-6 col-lg-8 placeholder"
                                                                multiple="multiple" style="display:none">

                                                                <option value="Approved" selected="selected">Rajasthan
                                                                </option>
                                                                <option value="Rejected">Delhi</option>
                                                                <option value="RollBacked">Gujarat</option>
                                                                <option value="Pending">Mumbai</option>
                                                            </select>
                                                        </div> --}}
                                                        <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                                            <label for="YearCC"
                                                                class="col-sm-6 col-lg-4 col-form-label pull-left">Profession</label>
                                                            <select id="proffesional_profession"
                                                                class="form-control">
                                                                <option value="">Please select</option>
                                                                <?php foreach($data['cases'] as $cases) { if(!empty($cases['occupation'])){?>
                                                                    <option value="<?php echo $cases['occupation']?>"><?php echo $cases['occupation'];?></option>
                                                                <?php } }?>
                                                            </select>
                                                        </div>
                                                        <!--<div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                                            <label for="MonthCC" class="col-sm-6 col-lg-4 col-form-label
                                                                  pull-left">Lender</label>
                                                            <select id="MonthCC"
                                                                class="form-control col-sm-6 col-lg-8 placeholder"
                                                                multiple="multiple" style="display:none">
                                                                <option value="B030" selected="selected">Jan</option>
                                                                <option value="B030">Feb</option>
                                                                <option value="D070">Mar</option>
                                                                <option value="K070">Apr</option>
                                                                <option value="T030">May</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                                            <label for="MonthCC" class="col-sm-6 col-lg-4 col-form-label
                                                                  ">Desire Loan Amount</label>
                                                            <input type="text" class="form-control" placeholder="Rs 540"
                                                                disabled />
                                                        </div>-->
                                                        <div class="date_filter col-xs-12 col-sm-6 col-lg-4">
                                                            <label for="MonthCC" class="col-sm-6 col-lg-4 col-form-label
                                                    ">From</label>
                                                            <input type="date" id="from_date" class="form-control col-sm-6 col-lg-12"
                                                                name="date" >
                                                        </div>
                                                        <div class="date_filter col-xs-12 col-sm-6 col-lg-4">
                                                            <label for="MonthCC" class="col-sm-6 col-lg-4 col-form-label
                                                           ">To</label>
                                                            <input type="date" id="to_date" class="form-control col-sm-6 col-lg-12"
                                                                name="date" >
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-lg-2 mb-3">
                                                            <button type="button"
                                                                class="btn btn-outline-dark btn-sm mr-3 search-css-btn"
                                                                id="applyFilter1" style="margin-top: 2em;"><i class="fa fa-search"
                                                                    aria-hidden="true"></i>
                                                                Search</button>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="clearfix"></div>
                                            <!--start: Contamination Control tabs started from here -->
                                            <div class="cc-tabs-main m-t-0">
                                                <div id="content" class="all-tab-tables table-tab-all-cases">
                                                    <div class="card-body all-tab-table" style="padding: 0px;margin-top: -8px;">
                                                        <!-- start: Contamination Control datatable grid -->
                                                        <!-- <div class="grid-top-actions">
                                                            <div class="column-visiblity">
                                                                <ul class="main-ul allow-focus">
                                                                    <li class="dropdown">
                                                                        <a href="#" data-toggle="dropdown" class="btn btn-outline-primary btn-sm
                                                                                  dropdown-toggle">
                                                                            Column
                                                                            Visibility<b class="caret"></b>
                                                                        </a>
                                                                       
                                                                        <ul class="dropdown-menu visibilityCheckCommon"
                                                                            id="grpChkBoxCCMain"
                                                                            data-associated-table="ccTable">
                                                                            <li style="display:none;">
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="ActionGO">Action</label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="CaseID">Case
                                                                                        ID</label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="Customer">Customer
                                                                                        Name</label></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox">
                                                                                    <label>
                                                                                        <input type="checkbox"
                                                                                            name="State">Customer Location
                                                                                    </label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="Status">Status</label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="LastCase">Last Case
                                                                                        Update</label></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="Phone">Phone
                                                                                        Number</label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="Cibil">CIBIL</label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox">
                                                                                    <label>
                                                                                        <input type="checkbox"
                                                                                            name="User">User Name
                                                                                    </label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="CustomerName">Case In
                                                                                        System</label></div>
                                                                            </li>
                                                                            
                                                                            
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="Profession">Profession</label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="CreatedDate">Create
                                                                                        Date</label></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="UpdateDate">Created
                                                                                        Time</label></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="Em-type">Employee</label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="Degree">Degree</label>
                                                                                </div>
                                                                            </li>
                                                                            
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="PastLoan">Past
                                                                                        Loan</label></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="Location">Location</label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="LenderName">Lender
                                                                                        Name
                                                                                    </label></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="Loan-amount">Desire
                                                                                        Loan Amount</label></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="MonthSalary">Monthly
                                                                                        Salary</label></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="AnnualSalary">Annual
                                                                                        Salary</label></div>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div id="buttonsExportCCMain"
                                                                class="btnExportStyle pull-right">
                                                            </div>
                                                        </div> -->
                                                        <!-- Start of Housekeeping table -->
                                                        <table id="ProfessionalTable" class="display cust_table table-responsive display responsive nowrap table-bordered"
                                                            style="width:100%;font-size: 12px;">
                                                            <thead>
                                                                <tr>
                                                                    <th class="Action" >Action</th>
                                                                    <th class="CaseID" >Case ID</th>
                                                                    <th class="Customer">Customer Name</th>
                                                                    <th class="Phone">Phone Number</th>
                                                                    <th class="State">Customer Location</th>
                                                                    <th class="Status">Status</th>
                                                                    <th class="Status">Additional Status</th>
                                                                    <th class="LastCase">Last Case Updated</th>
                                                                    <th class="Cibil">CIBIL Score</th>
                                                                    <th class="User" >User Name</th>
                                                                    <!-- <th class="CustomerName">Case in System</th> -->
                                                                    <th class="Profession">Profession</th>
                                                                    <th class="CreatedDate">Created Date & Time</th>
                                                                    <th class="Em-type">Employee Type</th>
                                                                    <th class="Degree">Degree</th>
                                                                    <th class="PastLoan">Past Loan</th>
                                                                    <th class="LenderName">Tenure</th>
                                                                    <th class="Loan-amount">Desired Loan Amount</th>
                                                                    <!-- <th class="MonthSalary">Monthly Salary</th>
                                                                    <th class="AnnualSalary">Annual Income 
                                                                    </th>-->
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="2a">
                                        <div class="content">
                                            <div class="custom-search-box box-search-custom-filter" style="margin-bottom: 0px;padding:15px;">
                                                <p class="btn btn-group group-btn" onclick="myFunctionss()" style="margin-bottom: 0px;">
                                                    <i class="fa fa-filter"></i> Filters
                                                </p>

                                                <div class="collapse show multiselect-ui" id="myDIVY"
                                                    style="display: none;">
                                                    <input type="hidden" value="{{ route('Personal-Cases') }}" id="getPersonalUrl"> 
                                                    <div class="form-group row">
                                                        <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                                            <label for="dealerCC"
                                                                class="col-sm-6 col-lg-4 col-form-label pull-left">User
                                                                Name</label>
                                                            {{-- <input type="text" class="form-control col-md-12" /> --}}
                                                            <select id="personal_user_id"
                                                                class="form-control">
                                                                <option value="" selected="selected">Please select</option>
                                                                <?php foreach ($data['agents'] as $agents){ if(!empty($agents['name'])){?>
                                                                    <option value="<?php echo $agents['id']; ?>"><?php echo $agents['name']; ?></option>    
                                                                <?php } }?>
                                                            </select>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                                            <label for="personal_location"
                                                                class="col-sm-6 col-lg-4 col-form-label pull-left">Location</label>
                                                             <input type="text" class="form-control" placeholder="Enter location" id="personal_location">
                                                        </div>
                                                        {{-- <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                                            <label for="dealerBranchCC"
                                                                class="col-sm-6 col-lg-4 col-form-label pull-left">Location</label>
                                                            <select id="dealerBranchCC"
                                                                class="form-control col-sm-6 col-lg-8 placeholder"
                                                                multiple="multiple" style="display:none">
                                                                <option value="P1" selected="selected">Udaipur</option>
                                                                <option value="P2">Jaipur</option>
                                                                <option value="P3">Kota</option>
                                                                <option value="P4">Shrinagar</option>
                                                                <option value="P5">Ahemdabad</option>
                                                            </select>
                                                        </div> --}}
                                                        <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                                            <label for="YearCC"
                                                                class="col-sm-6 col-lg-4 col-form-label pull-left">Occupation</label>
                                                            <select id="YearCC"
                                                                class="form-control col-sm-6 col-lg-8 placeholder"
                                                                multiple="multiple" style="display:none">
                                                                <option value="2020" selected="selected">Engineering
                                                                </option>
                                                                <option value="2019">2019</option>
                                                                <option value="2018">2018</option>
                                                                <option value="2017">2017</option>
                                                                <option value="2016">2016</option>
                                                                <option value="2015">2015</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                                            <label for="MonthCC" class="col-sm-6 col-lg-4 col-form-label
                                                                  pull-left">Lender</label>
                                                            <select id="MonthCC"
                                                                class="form-control col-sm-6 col-lg-8 placeholder"
                                                                multiple="multiple" style="display:none">
                                                                <option value="B030" selected="selected">Jan</option>
                                                                <option value="B030">Feb</option>
                                                                <option value="D070">Mar</option>
                                                                <option value="K070">Apr</option>
                                                                <option value="T030">May</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                                            <label for="MonthCC" class="col-sm-6 col-lg-4 col-form-label
                                                                  pull-left">Loan Type</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                                            <label for="MonthCC" class="col-sm-6 col-lg-4 col-form-label
                                                                  ">Desire Loan Amount</label>
                                                            <input type="text" class="form-control" placeholder="Rs 540"
                                                                disabled />
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-lg-12 mb-3">
                                                            <button type="button"
                                                                class="btn btn-outline-dark btn-sm mr-2 pull-right search-css-btn"
                                                                id="applyFilter2"><i class="fa fa-search"
                                                                    aria-hidden="true"></i>
                                                                Search</button>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="clearfix"></div>
                                            <!--start: Contamination Control tabs started from here -->
                                            <div class="cc-tabs-main m-t-0">
                                                <div id="content" class="all-tab-tables table-tab-all-cases">
                                                    <div class="card-body all-tab-table" style="padding:0px;margin-top: -8px;">
                                                        <!-- start: Contamination Control datatable grid -->
                                                        <!-- <div class="grid-top-actions">
                                                            <div class="column-visiblity">
                                                                <ul class="main-ul allow-focus">
                                                                    <li class="dropdown">
                                                                        <a href="#" data-toggle="dropdown" class="btn btn-outline-primary btn-sm
                                                                                  dropdown-toggle">
                                                                            Column
                                                                            Visibility<b class="caret"></b>
                                                                        </a>           
                                                                        <ul class="dropdown-menu visibilityCheckCommon"
                                                                            id="grpChkBoxCCMains"
                                                                            data-associated-table="ccTable1">
                                                                            <li style="display:none;">
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="ActionGO">Action</label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="CaseID">Case
                                                                                        ID</label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="Customer">Customer
                                                                                        Name</label></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="Status">Status</label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="LastCase">Last Case
                                                                                        Update</label></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="Phone">Phone
                                                                                        Number</label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="Cibil">CIBIL</label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox">
                                                                                    <label>
                                                                                        <input type="checkbox"
                                                                                            name="User">User Name
                                                                                    </label>
                                                                                </div>
                                                                            </li>
                                                                            
                                                                            
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="CustomerName">Case In
                                                                                        System</label></div>
                                                                            </li>
                                                                            
                                                                            
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="Profession">Profession</label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="CreatedDate">Create
                                                                                        Date</label></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="UpdateDate">Created
                                                                                        Time</label></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="Degree">Company
                                                                                        Name</label>
                                                                                </div>
                                                                            </li>
                                                                            
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="PastLoan">Past
                                                                                        Loan</label></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="Location">Location</label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="LenderName">Lender
                                                                                        Name
                                                                                    </label></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="Loan-amount">Desire
                                                                                        Loan Amount</label></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="MonthSalary">Monthly
                                                                                        Salary</label></div>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div id="buttonsExportCCMain"
                                                                class="btnExportStyle pull-right">
                                                            </div>
                                                        </div> -->
                                                        <!-- Start of Housekeeping table -->
                                                        <table id="PersonalTable" class="display cust_table table-responsive display responsive nowrap table-bordered dataTable no-footer"
                                                            style="width:100%;font-size: 12px;">
                                                            <thead>
                                                                <tr>
                                                                    <th class="Action" >Action</th>
                                                                    <th class="CaseID" >Case ID</th>
                                                                    <th class="Customer">Customer Name</th>
                                                                    <th class="Phone">Phone Number</th>
                                                                    <th class="State">Customer Location</th>
                                                                    <th class="Status">Status</th>
                                                                    <th class="Status">Additional Status</th>
                                                                    <th class="LastCase">Last Case Updated</th>
                                                                    <!-- <th class="Cibil">CIBIL Score</th> -->
                                                                    <th class="User" >User Name</th>
                                                                    <!-- <th class="CustomerName">Case in System</th> -->
                                                                    <!-- <th class="Profession">Profession</th> -->
                                                                    <th class="CreatedDate">Created Date & Time</th>
                                                                    <th class="Em-type">Employee Type</th>
                                                                  <!--   <th class="Degree">Degree</th> -->
                                                                    <th class="PastLoan">Past Loan</th>
                                                                    <th class="LenderName">Tenure</th>
                                                                    <th class="Loan-amount">Desired Loan Amount</th>
                                                                    <th class="MonthSalary">Monthly Salary</th>
                                                                    <!-- <th class="AnnualSalary">Annual Income</th> -->
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="3a">
                                        <div class="content">
                                            <div class="custom-search-box box-search-custom-filter" style="margin-bottom: 0px;padding:15px;">
                                                <p class="btn btn-group group-btn" onclick="myyFunction()" style="margin-bottom: 0px;">
                                                    <i class="fa fa-filter"></i> Filters
                                                </p>

                                                <div class="collapse show multiselect-ui" id="myDII"
                                                    style="display: none;">
                                                    <input type="hidden" value="{{ route('Bussiness-Cases') }}" id="getBussinessUrl"> 
                                                    <div class="form-group row">
                                                        <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                                            <label for="dealerCC"
                                                                class="col-sm-6 col-lg-4 col-form-label pull-left">User
                                                                Name</label>
                                                            {{-- <input type="text" class="form-control col-md-12" /> --}}
                                                            <select id="business_user_id"
                                                                class="form-control">
                                                                <option value="" selected="selected">Please select</option>
                                                                <?php foreach ($data['agents'] as $agents){ if(!empty($agents['name'])){?>
                                                                    <option value="<?php echo $agents['id']; ?>"><?php echo $agents['name']; ?></option>    
                                                                <?php } }?>
                                                            </select>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                                            <label for="proffesional_location"
                                                                class="col-sm-6 col-lg-4 col-form-label pull-left">Location</label>
                                                             <input type="text" class="form-control" placeholder="Enter location" id="business_location">
                                                        </div>


                                                        {{-- <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                                            <label for="dealerBranchCC"
                                                                class="col-sm-6 col-lg-4 col-form-label pull-left">Location</label>
                                                            <select id="dealerBranchCC"
                                                                class="form-control col-sm-6 col-lg-8 placeholder"
                                                                multiple="multiple" style="display:none">
                                                                <option value="P1" selected="selected">Udaipur</option>
                                                                <option value="P2">Jaipur</option>
                                                                <option value="P3">Kota</option>
                                                                <option value="P4">Shrinagar</option>
                                                                <option value="P5">Ahemdabad</option>
                                                            </select>
                                                        </div> --}}
                                                        <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                                            <label for="locationCC" class="col-sm-6 col-lg-4 col-form-label
                                                                  pull-left">State</label>
                                                            <select id="locationCC"
                                                                class="form-control col-sm-6 col-lg-8 placeholder"
                                                                multiple="multiple" style="display:none">

                                                                <option value="Approved" selected="selected">Rajasthan
                                                                </option>
                                                                <option value="Rejected">Delhi</option>
                                                                <option value="RollBacked">Gujarat</option>
                                                                <option value="Pending">Mumbai</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                                            <label for="YearCC"
                                                                class="col-sm-6 col-lg-4 col-form-label">Name of Business</label>
                                                            <select id="YearCC"
                                                                class="form-control col-sm-6 col-lg-8 placeholder"
                                                                multiple="multiple" style="display:none">
                                                                <option value="2020" selected="selected">Engineering
                                                                </option>
                                                                <option value="2019">2019</option>
                                                                <option value="2018">2018</option>
                                                                <option value="2017">2017</option>
                                                                <option value="2016">2016</option>
                                                                <option value="2015">2015</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                                            <label for="MonthCC" class="col-sm-6 col-lg-4 col-form-label
                                                                  pull-left">Lender</label>
                                                            <select id="MonthCC"
                                                                class="form-control col-sm-6 col-lg-8 placeholder"
                                                                multiple="multiple" style="display:none">
                                                                <option value="B030" selected="selected">Jan</option>
                                                                <option value="B030">Feb</option>
                                                                <option value="D070">Mar</option>
                                                                <option value="K070">Apr</option>
                                                                <option value="T030">May</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                                            <label for="MonthCC" class="col-sm-6 col-lg-4 col-form-label
                                                                  pull-left">Loan Type</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                                            <label for="MonthCC" class="col-sm-6 col-lg-4 col-form-label
                                                                  ">Desire Loan Amount</label>
                                                            <input type="text" class="form-control" placeholder="Rs 540"
                                                                disabled />
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
                                                            <button type="button"
                                                                class="btn btn-outline-dark btn-sm mr-2 search-css-btn"
                                                                id="applyFilter3" style="margin-top: 2em;"><i class="fa fa-search"
                                                                    aria-hidden="true"></i>
                                                                Search</button>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="clearfix"></div>
                                            <!--start: Contamination Control tabs started from here -->
                                            <div class="cc-tabs-main m-t-0">
                                                <div id="content" class="all-tab-tables table-tab-all-cases">
                                                    <div class="card-body all-tab-table" style="padding: 0px;margin-top: -8px;">
                                                        <!-- start: Contamination Control datatable grid -->
                                                        <!-- <div class="grid-top-actions">
                                                            <div class="column-visiblity">
                                                                <ul class="main-ul allow-focus">
                                                                    <li class="dropdown">
                                                                        <a href="#" data-toggle="dropdown" class="btn btn-outline-primary btn-sm
                                                                                  dropdown-toggle">
                                                                            Column
                                                                            Visibility<b class="caret"></b>
                                                                        </a>
                                                                        
                                                                        <ul class="dropdown-menu visibilityCheckCommon"
                                                                            id="grpChkBoxCCMainss"
                                                                            data-associated-table="ccTable2">
                                                                            <li style="display:none;">
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="ActionGO">Action</label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="CaseID">Case
                                                                                        ID</label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="State">Customer Location</label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="Status">Status</label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="LastCase">Last Case
                                                                                        Update</label></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="Phone">Phone
                                                                                        Number</label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="Cibil">CIBIL</label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox">
                                                                                    <label>
                                                                                        <input type="checkbox"
                                                                                            name="User">User Name
                                                                                    </label>
                                                                                </div>
                                                                            </li>
                                                                            
                                                                            
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="CustomerName">Case In
                                                                                        System</label></div>
                                                                            </li>
                                                                            
                                                                            
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="Business">Name of
                                                                                        Business</label></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="CreatedDate">Create
                                                                                        Date</label></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="UpdateDate">Created
                                                                                        Time</label></div>
                                                                            </li>
                                                                            
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="PastLoan">Past
                                                                                        Loan</label></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="Location">Location</label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="LenderName">Lender
                                                                                        Name
                                                                                    </label></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="Loan-amount">Desire
                                                                                        Loan Amount</label></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="checkbox"><label><input
                                                                                            type="checkbox"
                                                                                            name="Annual">Annual
                                                                                        Income</label></div>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div id="buttonsExportCCMain"
                                                                class="btnExportStyle pull-right">
                                                            </div>
                                                        </div> -->
                                                        <!-- Start of Housekeeping table -->
                                                        <table id="businessTable" class="display cust_table table-responsive display responsive nowrap table-bordered dataTable no-footer"
                                                            style="width:100%;font-size:12px;">
                                                            <thead>
                                                                <tr>
                                                                    <th class="Action" >Action</th>
                                                                    <th class="CaseID" >Case ID</th>
                                                                    <th class="Customer">Customer Name</th>
                                                                    <th class="Phone">Phone Number</th>
                                                                    <!-- <th class="State">Customer Location</th> -->
                                                                    <th class="Status">Status</th>
                                                                    <th class="LastCase">Last Case Updated</th>
                                                                    <th class="Cibil">CIBIL Score</th>
                                                                    <th class="User" >User Name</th>
                                                                    <!-- <th class="CustomerName">Case in System</th> -->
                                                                    <th class="Profession">Profession</th>
                                                                    <th class="CreatedDate">Created Date & Time</th>
                                                                    <!-- <th class="Em-type">Employee Type</th> -->
                                                                    <th class="Degree">Degree</th>
                                                                    <th class="PastLoan">Past Loan</th>
                                                                    <th class="LenderName">Tenure</th>
                                                                    <th class="Loan-amount">Desired Loan Amount</th>
                                                                    <th class="MonthSalary">Monthly Salary</th>
                                                                    <th class="AnnualSalary">Annual Income</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>                                                         

                                                            </tbody>
                                                        </table>
                                                    </div>
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
                </div>
            </div>
        </div>


    </div>
</main>   
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
              <button type="button" class="close close-modal" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            <div class="modal-body">
              <div class="col-12">
                <span>qwertyu</span>
              </div>
              <div class="col-12">
                <span>qwertyu</span>
              </div>
              <div class="col-12">
                <span>qwertyu</span>
              </div>
            </div>
              <button type="button" class="btn btn-primary">See More</button>
          </div>
        </div>
      </div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary verify_btn">Save changes</button>
      </div>
    </div>
  </div>
</div>      
@endsection


<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/case_main.js') }}"></script>
<script src="{{ asset('js/bootstrap-multiselect.js') }}"></script>
<script>
   $(document).ready(function(){
        $('[data-toggle="popover"]').popover();   
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
        chkBoxFilter("grpChkBoxCCMain", [9,10 , 11 ,12,13,14,15,16,17,18,19,20,21]);

    });


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
        chkBoxFilter("grpChkBoxCCMains", [8,9,10,11,12,13,14,15,16,17,18,19,20,21]);

    });

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
        chkBoxFilter("grpChkBoxCCMainss", [8,9,10,11,12,13,14,15,16,17]);

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
            buttonContainer: '<div/> '
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


    function myFunctionss() {
        var x = document.getElementById("myDIVY");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

    function myyFunction() {
        var x = document.getElementById("myDII");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
    $('.date-pick').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false
    });

    $('.date-pick').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
    });

</script>
<script>
    $('#datepicker').datepicker({
        uiLibrary: 'bootstrap4'
    });
</script>
<script>
    var myModal = document.getElementById('myModal')
var myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', function () {
  myInput.focus()
})
</script>