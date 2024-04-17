@extends('layouts.app')
@section('content')

<main class="page-content">
    <div class="container-fluid">
        <!-- start: Header row -->
        <div class="row">
            <header>
                <div class="top-header">
                    <section class="header-top-left">
                        <div class="logo">
                            <a href="">
                                <!-- <img src="images/catlogo.png" alt="CATERPILLAR"> -->
                                <h4 class="page-title">Agent Details</h4>
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
                        <ul class="nav nav-pills pills-nav">
                            <li class="active">
                                <a href="#1a" data-toggle="tab">Cases</a>
                            </li>
                            <li><a href="#2a" data-toggle="tab">Summary</a>
                            </li>
                            <li><a href="#3a" data-toggle="tab">Bank & Earnings</a>
                            </li>
                            <li><a href="#4a" data-toggle="tab">Performance</a>
                            </li>
                            <li><a href="#5a" data-toggle="tab">Activity</a>
                            </li>
                        </ul>


                    </div>


                </div>
                <div class="col-md-12">
                    <div class="tab-content clearfix">
                        <div class="tab-pane active" id="1a">
                            <div class="filter-start col-md-12">
                                <div class="filter retlif">
                                    <div class="heading text-left">
                                        <p class="btn btn-group" onclick="myFunction()" style="margin-bottom: 0px;">
                                            <i class="fa fa-filter"></i> Filters
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
                                                        <div class="row" style="margin-top: -2em;">
                                                            <div class="col-md-6 form-group ">
                                                                
                                                                <div class="col-sm-12 text-left">
                                                                    <label for="fromFilter"
                                                                    class="col-sm-2 col-form-label  color-size">From</label>
                                                                    <input type="date" class="form-control"
                                                                        id="fromFilter" name="fromFilter">
                                                                </div>

                                                                
                                                            </div>
                                                            <div class="col-md-6 form-group ">
                                                               
                                                                <div class="col-sm-12 text-left">
                                                                     <label for="toFilter"
                                                                    class="col-sm-2 col-form-label color-size">To</label>
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
                                                        style="width: 180px;border:none;display:none;" multiple="multiple"
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
                                                            class="btn btn-outline-dark search-btn applyFilter search-css-btn"
                                                            id="btn-cc-search" style="padding: 3px;"><i
                                                                class="fa fa-search" aria-hidden="true"></i>
                                                            Search</button></center>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mis-heading heading-mis">
                                    
                                    <!-- <table id="misTable" class="display table-responsive table-bordered" style="width:100%">
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
                                    </table> -->
                                    <div class="card card-custom">
                  <div class="card-body" style="padding: 0px"></div>
                  <div class="col-md-12 no-padding">
                    <div id="exTab1 reniatnoc" class="container">
                      <ul class="nav nav-pills pills-nav">
                        <li class="active">
                          <a href="#1aa" data-toggle="tab">Professional Loan</a>
                        </li>
                        <li>
                          <a href="#2aa" data-toggle="tab">Personal Loan</a>
                        </li>
                        <li>
                          <a href="#3aa" data-toggle="tab">Business Loan</a>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="tab-content clearfix" style="padding: 0px">
                      <div class="tab-pane active" id="1aa">
                        <div class="content">
                          <div
                            class="custom-search-box box-search-custom-filter"
                            style="margin-bottom: 0px; padding: 15px"
                          >
                           <!--  <p
                              class="btn btn-group group-btn"
                              onclick="myFunction()"
                              style="margin-bottom: 0px"
                            >
                              <i class="fa fa-filter"></i> Filters
                            </p> -->

                            <div
                              class="collapse show multiselect-ui"
                              id="myDIV"
                              style="display: none"
                            >
                              <input
                                type="hidden"
                                value="{{ route('Proffesional-Cases') }}"
                                id="getProfessionalUrl"
                              />

                              <div class="form-group row">
                                <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                  <label
                                    for="dealerCC"
                                    class="
                                      col-sm-6 col-lg-4 col-form-label
                                      pull-left
                                    "
                                    >User Name</label
                                  >
                                  <input
                                    type="text"
                                    class="form-control"
                                    required=""
                                    placeholder=""
                                  />
                                </div>

                                <!--<div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                                            <label for="dealerCC"
                                                                class="col-sm-6 col-lg-4 col-form-label pull-left">User
                                                                Name</label>
                                                            <input type="text" class="form-control" />
                                                        </div>-->

                                <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                  <label
                                    for="dealerBranchCC"
                                    class="
                                      col-sm-6 col-lg-4 col-form-label
                                      pull-left
                                    "
                                    >Location</label
                                  >
                                  <select
                                    id="dealerBranchCC"
                                    class="
                                      form-control
                                      col-sm-6 col-lg-8
                                      placeholder
                                    "
                                    multiple="multiple"
                                    style="display: none"
                                  >
                                    <option value="P1" selected="selected">
                                      Udaipur
                                    </option>
                                    <option value="P2">Jaipur</option>
                                    <option value="P3">Kota</option>
                                    <option value="P4">Shrinagar</option>
                                    <option value="P5">Ahemdabad</option>
                                  </select>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                  <label
                                    for="locationCC"
                                    class="
                                      col-sm-6 col-lg-4 col-form-label
                                      pull-left
                                    "
                                    >State</label
                                  >
                                  <select
                                    id="locationCC"
                                    class="
                                      form-control
                                      col-sm-6 col-lg-8
                                      placeholder
                                    "
                                    multiple="multiple"
                                    style="display: none"
                                  >
                                    <option
                                      value="Approved"
                                      selected="selected"
                                    >
                                      Rajasthan
                                    </option>
                                    <option value="Rejected">Delhi</option>
                                    <option value="RollBacked">Gujarat</option>
                                    <option value="Pending">Mumbai</option>
                                  </select>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                  <label
                                    for="YearCC"
                                    class="
                                      col-sm-6 col-lg-4 col-form-label
                                      pull-left
                                    "
                                    >Profession</label
                                  >
                                  <select
                                    id="YearCC"
                                    class="
                                      form-control
                                      col-sm-6 col-lg-8
                                      placeholder
                                    "
                                    multiple="multiple"
                                    style="display: none; margin-left: -15px"
                                  >
                                    <option value="2020" selected="selected">
                                      Business
                                    </option>
                                    <option value="2019">2019</option>
                                    <option value="2018">2018</option>
                                    <option value="2017">2017</option>
                                    <option value="2016">2016</option>
                                    <option value="2015">2015</option>
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
                                <div
                                  class="
                                    date_filter
                                    col-xs-12 col-sm-6 col-lg-4
                                  "
                                >
                                  <label
                                    for="MonthCC"
                                    class="col-sm-6 col-lg-4 col-form-label"
                                    >From</label
                                  >
                                  <input
                                    type="date"
                                    class="form-control col-sm-6 col-lg-12"
                                    name="date"
                                  />
                                </div>
                                <div
                                  class="
                                    date_filter
                                    col-xs-12 col-sm-6 col-lg-4
                                  "
                                >
                                  <label
                                    for="MonthCC"
                                    class="col-sm-6 col-lg-4 col-form-label"
                                    >To</label
                                  >
                                  <input
                                    type="date"
                                    class="form-control col-sm-6 col-lg-12"
                                    name="date"
                                  />
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-2 mb-3">
                                  <button
                                    type="button"
                                    class="
                                      btn btn-outline-dark btn-sm
                                      mr-3
                                      applyFilter
                                      search-css-btn
                                    "
                                    id="btn-cc-search"
                                    style="margin-top: 2em"
                                  >
                                    <i
                                      class="fa fa-search"
                                      aria-hidden="true"
                                    ></i>
                                    Search
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="clearfix"></div>
                          <!--start: Contamination Control tabs started from here -->
                          <div class="cc-tabs-main m-t-0">
                            <div
                              id="content"
                              class="all-tab-tables table-tab-all-cases"
                            >
                              <div
                                class="card-body all-tab-table"
                                style="padding: 0px; margin-top: -8px"
                              >
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
                                <input type="hidden" value="{{ route('Agent-Cases') }}" id="addressGetCases">
                                <input type="hidden" value="{{ @$agents->id }}" id="agent_id" name="agent_id">
                                <table
                                  id="ProfessionalMisTable" class="display
                                    cust_table                                    
                                    display
                                    table-responsive
                                    responsive
                                    nowrap
                                    table-bordered
                                  "
                                  style="width: 100%; font-size: 12px"
                                >
                                  <thead>
                                    <tr>
                                      <th class="Action">Action</th>
                                      <th class="CaseID">Case ID</th>
                                      <th class="Customer">Customer Name</th>
                                      <th class="Phone">Phone Number</th>
                                      <th class="State">Customer Location</th>
                                      <th class="Status">Status</th>
                                      <th class="LastCase">
                                        Last Case Updated
                                      </th>
                                      <th class="Cibil">CIBIL Score</th>
                                      <th class="User">User Name</th>
                                      <!-- <th class="CustomerName">Case in System</th> -->
                                      <th class="Profession">Profession</th>
                                      <th class="CreatedDate">
                                        Created Date & Time
                                      </th>
                                      <th class="Em-type">Employee Type</th>
                                      <th class="Degree">Degree</th>
                                      <th class="PastLoan">Past Loan</th>
                                      <th class="LenderName">Tenure</th>
                                      <th class="Loan-amount">
                                        Desired Loan Amount
                                      </th>
                                      <th class="MonthSalary">
                                        Monthly Salary
                                      </th>
                                      <th class="AnnualSalary">
                                        Annual Income
                                      </th>
                                    </tr>
                                  </thead>
                                  <tbody></tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane" id="2aa">
                        <div class="content">
                          <div
                            class="custom-search-box box-search-custom-filter"
                            style="margin-bottom: 0px; padding: 15px"
                          >
                            <!-- <p
                              class="btn btn-group group-btn"
                              onclick="myFunctionss()"
                              style="margin-bottom: 0px"
                            >
                              <i class="fa fa-filter"></i> Filters
                            </p> -->

                            <div
                              class="collapse show multiselect-ui"
                              id="myDIVY"
                              style="display: none"
                            >
                              <!-- <input
                                type="hidden"
                                value="{{ route('Personal-Cases') }}"
                                id="getPersonalUrl"
                              /> -->
                              <div class="form-group row">
                                <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                  <label
                                    for="dealerCC"
                                    class="
                                      col-sm-6 col-lg-4 col-form-label
                                      pull-left
                                    "
                                    >User Name</label
                                  >
                                  <input
                                    type="text"
                                    class="form-control col-md-12"
                                  />
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                  <label
                                    for="dealerBranchCC"
                                    class="
                                      col-sm-6 col-lg-4 col-form-label
                                      pull-left
                                    "
                                    >Location</label
                                  >
                                  <select
                                    id="dealerBranchCC"
                                    class="
                                      form-control
                                      col-sm-6 col-lg-8
                                      placeholder
                                    "
                                    multiple="multiple"
                                    style="display: none"
                                  >
                                    <option value="P1" selected="selected">
                                      Udaipur
                                    </option>
                                    <option value="P2">Jaipur</option>
                                    <option value="P3">Kota</option>
                                    <option value="P4">Shrinagar</option>
                                    <option value="P5">Ahemdabad</option>
                                  </select>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                  <label
                                    for="YearCC"
                                    class="
                                      col-sm-6 col-lg-4 col-form-label
                                      pull-left
                                    "
                                    >Occupation</label
                                  >
                                  <select
                                    id="YearCC"
                                    class="
                                      form-control
                                      col-sm-6 col-lg-8
                                      placeholder
                                    "
                                    multiple="multiple"
                                    style="display: none"
                                  >
                                    <option value="2020" selected="selected">
                                      Engineering
                                    </option>
                                    <option value="2019">2019</option>
                                    <option value="2018">2018</option>
                                    <option value="2017">2017</option>
                                    <option value="2016">2016</option>
                                    <option value="2015">2015</option>
                                  </select>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                  <label
                                    for="MonthCC"
                                    class="
                                      col-sm-6 col-lg-4 col-form-label
                                      pull-left
                                    "
                                    >Lender</label
                                  >
                                  <select
                                    id="MonthCC"
                                    class="
                                      form-control
                                      col-sm-6 col-lg-8
                                      placeholder
                                    "
                                    multiple="multiple"
                                    style="display: none"
                                  >
                                    <option value="B030" selected="selected">
                                      Jan
                                    </option>
                                    <option value="B030">Feb</option>
                                    <option value="D070">Mar</option>
                                    <option value="K070">Apr</option>
                                    <option value="T030">May</option>
                                  </select>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                  <label
                                    for="MonthCC"
                                    class="
                                      col-sm-6 col-lg-4 col-form-label
                                      pull-left
                                    "
                                    >Loan Type</label
                                  >
                                  <input type="text" class="form-control" />
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                  <label
                                    for="MonthCC"
                                    class="col-sm-6 col-lg-4 col-form-label"
                                    >Desire Loan Amount</label
                                  >
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Rs 540"
                                    disabled
                                  />
                                </div>
                                <div class="col-xs-12 col-sm-12 col-lg-12 mb-3">
                                  <button
                                    type="button"
                                    class="
                                      btn btn-outline-dark btn-sm
                                      mr-2
                                      pull-right
                                      search-css-btn
                                    "
                                    id="btn-cc-search"
                                  >
                                    <i
                                      class="fa fa-search"
                                      aria-hidden="true"
                                    ></i>
                                    Search
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="clearfix"></div>
                          <!--start: Contamination Control tabs started from here -->
                          <div class="cc-tabs-main m-t-0">
                            <div
                              id="content"
                              class="all-tab-tables table-tab-all-cases"
                            >
                              <div
                                class="card-body all-tab-table"
                                style="padding: 0px; margin-top: -8px"
                              >
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
                                <input type="hidden" value="{{ route('Agent-Cases-Personal') }}" id="getPersonalUrl">
                                <input type="hidden" value="{{ @$agents->id }}" id="agent_id" name="agent_id">
                                <table
                                  id="PersonalTable"
                                  class="display cust_table table-responsive"
                                  style="width: 100%; font-size: 12px"
                                >
                                  <thead>
                                    <tr>
                                      <th class="Action">Action</th>
                                      <th class="CaseID">Case ID</th>
                                      <th class="Customer">Customer Name</th>
                                      <th class="Phone">Phone Number</th>
                                      <th class="State">Customer Location</th>
                                      <th class="Status">Status</th>
                                      <th class="LastCase">
                                        Last Case Updated
                                      </th>
                                      <th class="Cibil">CIBIL Score</th>
                                      <th class="User">User Name</th>
                                      <!-- <th class="CustomerName">Case in System</th> -->
                                      <th class="Profession">Profession</th>
                                      <th class="CreatedDate">
                                        Created Date & Time
                                      </th>
                                      <th class="Em-type">Employee Type</th>
                                      <!--   <th class="Degree">Degree</th> -->
                                      <th class="PastLoan">Past Loan</th>
                                      <th class="LenderName">Tenure</th>
                                      <th class="Loan-amount">
                                        Desired Loan Amount
                                      </th>
                                      <th class="MonthSalary">
                                        Monthly Salary
                                      </th>
                                      <!-- <th class="AnnualSalary">Annual Income</th> -->
                                    </tr>
                                  </thead>
                                  <tbody></tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane" id="3aa">
                        <div class="content">
                          <div
                            class="custom-search-box box-search-custom-filter"
                            style="margin-bottom: 0px; padding: 15px"
                          >
                            <!-- <p
                              class="btn btn-group group-btn"
                              onclick="myyFunction()"
                              style="margin-bottom: 0px"
                            >
                              <i class="fa fa-filter"></i> Filters
                            </p> -->

                            <div
                              class="collapse show multiselect-ui"
                              id="myDII"
                              style="display: none"
                            >
                              <!-- <input
                                type="hidden"
                                value="{{ route('Bussiness-Cases') }}"
                                id="getBussinessUrl"
                              /> -->
                              <div class="form-group row">
                                <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                  <label
                                    for="dealerCC"
                                    class="
                                      col-sm-6 col-lg-4 col-form-label
                                      pull-left
                                    "
                                    >User Name</label
                                  >
                                  <input
                                    type="text"
                                    class="form-control col-md-12"
                                  />
                                </div>

                                <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                  <label
                                    for="dealerBranchCC"
                                    class="
                                      col-sm-6 col-lg-4 col-form-label
                                      pull-left
                                    "
                                    >Location</label
                                  >
                                  <select
                                    id="dealerBranchCC"
                                    class="
                                      form-control
                                      col-sm-6 col-lg-8
                                      placeholder
                                    "
                                    multiple="multiple"
                                    style="display: none"
                                  >
                                    <option value="P1" selected="selected">
                                      Udaipur
                                    </option>
                                    <option value="P2">Jaipur</option>
                                    <option value="P3">Kota</option>
                                    <option value="P4">Shrinagar</option>
                                    <option value="P5">Ahemdabad</option>
                                  </select>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                  <label
                                    for="locationCC"
                                    class="
                                      col-sm-6 col-lg-4 col-form-label
                                      pull-left
                                    "
                                    >State</label
                                  >
                                  <select
                                    id="locationCC"
                                    class="
                                      form-control
                                      col-sm-6 col-lg-8
                                      placeholder
                                    "
                                    multiple="multiple"
                                    style="display: none"
                                  >
                                    <option
                                      value="Approved"
                                      selected="selected"
                                    >
                                      Rajasthan
                                    </option>
                                    <option value="Rejected">Delhi</option>
                                    <option value="RollBacked">Gujarat</option>
                                    <option value="Pending">Mumbai</option>
                                  </select>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                  <label
                                    for="YearCC"
                                    class="col-sm-6 col-lg-4 col-form-label"
                                    >Name of Business</label
                                  >
                                  <select
                                    id="YearCC"
                                    class="
                                      form-control
                                      col-sm-6 col-lg-8
                                      placeholder
                                    "
                                    multiple="multiple"
                                    style="display: none"
                                  >
                                    <option value="2020" selected="selected">
                                      Engineering
                                    </option>
                                    <option value="2019">2019</option>
                                    <option value="2018">2018</option>
                                    <option value="2017">2017</option>
                                    <option value="2016">2016</option>
                                    <option value="2015">2015</option>
                                  </select>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                  <label
                                    for="MonthCC"
                                    class="
                                      col-sm-6 col-lg-4 col-form-label
                                      pull-left
                                    "
                                    >Lender</label
                                  >
                                  <select
                                    id="MonthCC"
                                    class="
                                      form-control
                                      col-sm-6 col-lg-8
                                      placeholder
                                    "
                                    multiple="multiple"
                                    style="display: none"
                                  >
                                    <option value="B030" selected="selected">
                                      Jan
                                    </option>
                                    <option value="B030">Feb</option>
                                    <option value="D070">Mar</option>
                                    <option value="K070">Apr</option>
                                    <option value="T030">May</option>
                                  </select>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                  <label
                                    for="MonthCC"
                                    class="
                                      col-sm-6 col-lg-4 col-form-label
                                      pull-left
                                    "
                                    >Loan Type</label
                                  >
                                  <input type="text" class="form-control" />
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-4 mb-3">
                                  <label
                                    for="MonthCC"
                                    class="col-sm-6 col-lg-4 col-form-label"
                                    >Desire Loan Amount</label
                                  >
                                  <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Rs 540"
                                    disabled
                                  />
                                </div>
                                <div class="col-xs-12 col-sm-12 col-lg-4 mb-3">
                                  <button
                                    type="button"
                                    class="
                                      btn btn-outline-dark btn-sm
                                      mr-2
                                      search-css-btn
                                    "
                                    id="btn-cc-search"
                                    style="margin-top: 2em"
                                  >
                                    <i
                                      class="fa fa-search"
                                      aria-hidden="true"
                                    ></i>
                                    Search
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="clearfix"></div>
                          <!--start: Contamination Control tabs started from here -->
                          <div class="cc-tabs-main m-t-0">
                            <div
                              id="content"
                              class="all-tab-tables table-tab-all-cases"
                            >
                              <div
                                class="card-body all-tab-table"
                                style="padding: 0px; margin-top: -8px"
                              >
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
                                <input type="hidden" value="{{ route('Agent-Cases-Business') }}" id="getBussinessUrl">
                                <input type="hidden" value="{{ @$agents->id }}" id="agent_id" name="agent_id">
                                <table
                                  id="businessTable"
                                  class="display cust_table table-responsive"
                                  style="width: 100%; font-size: 12px"
                                >
                                  <thead>
                                    <tr>
                                      <th class="Action">Action</th>
                                      <th class="CaseID">Case ID</th>
                                      <th class="Customer">Customer Name</th>
                                      <th class="Phone">Phone Number</th>
                                      <th class="State">Customer Location</th>
                                      <th class="Status">Status</th>
                                      <th class="LastCase">
                                        Last Case Updated
                                      </th>
                                      <th class="Cibil">CIBIL Score</th>
                                      <th class="User">User Name</th>
                                      <!-- <th class="CustomerName">Case in System</th> -->
                                      <th class="Profession">Profession</th>
                                      <th class="CreatedDate">
                                        Created Date & Time
                                      </th>
                                      <th class="Em-type">Employee Type</th>
                                      <th class="Degree">Degree</th>
                                      <th class="PastLoan">Past Loan</th>
                                      <th class="LenderName">Tenure</th>
                                      <th class="Loan-amount">
                                        Desired Loan Amount
                                      </th>
                                      <th class="MonthSalary">
                                        Monthly Salary
                                      </th>
                                      <th class="AnnualSalary">
                                        Annual Income
                                      </th>
                                    </tr>
                                  </thead>
                                  <tbody></tbody>
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
                        <div class="tab-pane" id="2a">
                             <meta name="csrf-token" content="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="side-card col-md-12">
                                    <form method="POST" class="needs-validation" id="summaryForm" action="" novalidate enctype="multipart/form-data">
                                        @csrf
                                    <div class="inner-card">
                                        <div class="inner1">
                                            <div class="inner-doc col-md-12">
                                                <div class="row">
                                                    <div class="docu col-md-6 text-left">
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
                                            <div class="row" style="margin-top: 1em;">
                                                <div class="col-md-6 form-row">
                                                   <div class="col-md-3">
                                                      <label for="employment_type" class=" col-form-label">Full Name</label>
                                                     </div>

                                                      <div class="col-md-9">
                                                         <input type="text" class=" form-control" value="{{ @$agents->name }}" name="name" id="name">
                                                     </div>
                                                </div>

                                                <div class="col-md-6 form-row">
                                                   <div class="col-md-3">
                                                       <label for="employment_type"
                                                        class="col-form-label">User Id</label>
                                                     </div>

                                                      <div class="col-md-9">
                                                          <input type="text" class=" form-control" value="{{ @$agents->id }}" readonly="" 
                                                       >
                                                     </div>
                                                </div>
                                            </div>
                                                
                                             <div class="row" style="margin-top: 1em;">
                                                <div class="col-md-6 form-row">
                                                   <div class="col-md-3">
                                                        <label for="employment_type"
                                                        class="col-form-label">Occupation</label>
                                                     </div>

                                                      <div class="col-md-9">
                                                       <input type="text" class="form-control" value="{{ @$agents->current_profession }}" name="current_profession" id="current_profession">
                                                     </div>
                                                </div>

                                                <div class="col-md-6 form-row">
                                                   <div class="col-md-3">
                                                    <label for="employment_type"
                                                        class="col-form-label">Company</label>
                                                     </div>

                                                      <div class="col-md-9">
                                                           <input type="text" class=" form-control" value="{{ @$agents->employer_name }}" name="employer_name" id="employer_name">
                                                       
                                                     </div>
                                                </div>
                                            </div>

                                                 

                                             <div class="row" style="margin-top: 1em;">
                                                <div class="col-md-6 form-row">
                                                   <div class="col-md-3">
                                                         <label for="employment_type"
                                                        class="col-form-label">Location</label>
                                                     </div>

                                                      <div class="col-md-9">
                                                     
                                                    <input type="text" class="form-control" value="{{ @$agents->location }}" name="location" id="location"
                                                    >
                                                     </div>
                                                </div>

                                                <div class="col-md-6 form-row">
                                                   <div class="col-md-3">
                                                     <label for="employment_type"
                                                        class="col-form-label">Phone Number</label>
                                                     </div>

                                                      <div class="col-md-9">
                                                            <input type="text" class="form-control" value="{{ @$agents->mobile }}" name="mobile" id="mobile"
                                                        >
                                                       
                                                     </div>
                                                </div>
                                            </div>

                                                
                                               <div class="row" style="margin-top: 1em;">
                                                <div class="col-md-6 form-row">
                                                   <div class="col-md-3">
                                                          <label for="employment_type"
                                                        class="col-form-label">Email</label>
                                                     </div>

                                                      <div class="col-md-9">
                                                   <input type="text" class=" form-control" value="{{ @$agents->email }}" name="email" id="email">
                                                     </div>
                                                </div>

                                                <div class="col-md-6 form-row">
                                                   <div class="col-md-3">
                                                        <label for="employment_type"
                                                        class=" col-form-label">Whatsapp Number</label>
                                                     </div>

                                                      <div class="col-md-9">
                                                           
                                                    <input type="text" class=" form-control" value="{{ @$agents->whatsapp_number }}" name="whatsapp_number" id="whatsapp_number"
                                                    >
                                                       
                                                     </div>
                                                </div>
                                            </div>
                                                 
                                            <div class="row" style="margin-top: 1em;">
                                                <div class="col-md-6 form-row">
                                                   <div class="col-md-3">
                                                            <label for="employment_type"
                                                        class="col-form-label text-left">Financial Service <br>Experience</label>
                                                     </div>

                                                      <div class="col-md-3 text-left">
                                                     <div class="male-female-checkbox-new">
                                                  <input type="radio" name="financial_industry" value="Yes" id="yes" <?php if(@$agents->financial_industry == 'Yes'){ echo 'checked';} ?>> Yes
                                                        <input type="radio" name="financial_industry" value="No" id="No" <?php if(@$agents->financial_industry == 'No'){ echo 'checked';} ?>> No
                                                     </div>
                                                 </div>
                                                </div>

                                                <div class="col-md-6 form-row">
                                                   <div class="col-md-3">
                                                        <label for="employment_type"
                                                        class="col-form-label">Joined On</label>
                                                     </div>

                                                      <div class="col-md-9">
                                                           
                                                    <input type="text" class="form-control" value="{{ @$agents->created_at }}" readonly="">
                                                       
                                                       
                                                     </div>
                                                </div>
                                            </div>

                                                 
                                             <div class="row" style="margin-top: 3px;">
                                                <div class="col-md-6 form-row">
                                                   <div class="col-md-3">
                                                            <label for="employment_type"
                                                        class="col-form-label">Gender</label>
                                                     </div>

                                                      <div class="col-md-6 text-left">
                                                    <div class="male-female-checkbox">
                                                  <input type="radio" name="gender" value="Male" id="male" <?php if(@$agents->gender == 'Male'){ echo 'checked';} ?>> Male


                                                   <input type="radio" name="gender" value="Female" id="female" <?php if(@$agents->gender == 'Female'){ echo 'checked';} ?>> Female

                                                     <input type="radio" name="gender" value="Others" id="others" <?php if(@$agents->gender == 'Others'){ echo 'checked';} ?>> Others
                                                     </div>
                                                 </div>
                                                </div>

                                                <div class="col-md-6 form-row">
                                                   <div class="col-md-3">
                                                         <label for="employment_type"
                                                        class="col-form-label">Employment Type</label>
                                                     </div>

                                                      <div class="col-md-9">
                                                           
                                                   <input type="text" class="form-control" value="{{ @$agents->employment_type }}" name="employment_type" id="employment_type"
                                                    >
                                                       
                                                       
                                                     </div>
                                                </div>
                                            </div>

                                             
                                             <div class="row" style="margin-top: 1em;">
                                                <div class="col-md-6 form-row">
                                                   <div class="col-md-3">
                                                              <label for="dob" class=" col-form-label">Date
                                                        of Birth</label>
                                                     </div>

                                                      <div class="col-md-9">
                                                
                                                    <input type="date" class="form-control" value="{{ @$agents->dob }}" name="dob" id="dob"
                                                        >
                                                     </div>
                                                </div>

                                                <div class="col-md-6 form-row">
                                                   <div class="col-md-3">
                                                           <label for="hold_gov_office" class=" col-form-label text-left"
                                                        style="padding-top: 0px;">Themselves or Family
                                                        <br />Position in Gov./Politics</label>
                                                     </div>

                                                      <div class="col-md-3">
                                                 <input type="radio" name="hold_gov_office" value="Yes" id="yes" <?php if(@$agents->hold_gov_office == 'Yes'){ echo 'checked';} ?> > Yes
                                                        <input type="radio" name="hold_gov_office" value="No" id="no" <?php if(@$agents->hold_gov_office == 'No'){ echo 'checked';} ?> > No
                                                       
                                                       
                                                     </div>
                                                </div>
                                            </div>



                                              <div class="row wor" style="margin-top: -0px;margin-bottom: 25px;">
                                                <div class="col-md-6 form-row">
                                                   <div class="col-md-3">
                                                                 <label for="work_experience" class="col-form-label">Work
                                                        Experience</label>
                                                     </div>

                                                      <div class="col-md-9">
                                                
                                                 
                                                    <input type="number" class=" form-control" name="work_experience" value="{{ @$agents->work_experience }}" id="work_experience"
                                                    >
                                                     </div>
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
                                                    <div class="docu col-md-6 text-left">
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
                                                    <div class="kyc col-md-6 text-left"><span>KYC</span></div>

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
                                                    <div class="kyc col-md-12 text-left"><span>LEGAL</span></div>
                                                                                        
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
                                <div class="side-card col-md-12">
                                    <div class="inner-card">
                                         <form method="POST" class="needs-validation" id="bankEarningForm" action="" novalidate enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{ @$agents->id }}" name="id">
                                        <div class="inner col-md-12">
                                             <div class="row" style="margin-top: 1em;">
                                                <div class="col-md-6 form-row">
                                                   <div class="col-md-3">
                                                      <label for="account_holder_name"
                                                            class="col-form-label text-left">Account Holder Name</label>
                                                     </div>

                                                      <div class="col-md-9">
                                                         <input type="text" class="form-control" id="account_holder_name" name="account_holder_name" value="{{ @$agents->account_holder_name }}" 
                                                            >
                                                     </div>
                                                </div>

                                                <div class="col-md-6 form-row">
                                                   <div class="col-md-3">
                                                        <label for="bank_name" class=" col-form-label">Bank
                                                            Account</label>
                                                     </div>

                                                      <div class="col-md-9">
                                                          <input type="text" name="bank_name" value="{{ @$agents->bank_name }}" class="form-control" id="bank_name">
                                                     </div>
                                                </div>
                                            </div>





                                             <div class="row" style="margin-top: 2px;">
                                                <div class="col-md-6 form-row">
                                                   <div class="col-md-3">
                                                      <label for="account_number"
                                                            class="col-form-label">Account Number</label>
                                                     </div>

                                                      <div class="col-md-9">
                                                         <input type="text" class="form-control" id="account_number" name="account_number" value="{{ @$agents->account_number }}" 
                                                            >
                                                     </div>
                                                </div>

                                                <div class="col-md-6 form-row">
                                                   <div class="col-md-3">
                                                       <label for="exampleFormControlTextarea1"
                                                            class="col-form-label">Address</label>
                                                     </div>

                                                      <div class="col-md-9">
                                                         <textarea class="form-control" id="exampleFormControlTextarea1"
                                                             value="{{ @$agents->address }}" name="address" > {{ @$agents->address }}</textarea>
                                                     </div>
                                                </div>
                                            </div>


                                            <div class="row" style="margin-top: 2px;margin-bottom: 24px;">
                                                <div class="col-md-6 form-row">
                                                   <div class="col-md-3">
                                                      <label for="ifsc_code" class="col-form-label">IFSC
                                                            Code</label>
                                                     </div>

                                                      <div class="col-md-9">
                                                         <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" value="{{ @$agents->ifsc_code }}" 
                                                            >
                                                     </div>
                                                </div>
                                                 <div class="edit-btn col-md-6" style="margin-top: 1em;">
                                                    <button type="submit" class="edit btn btn-group">Update</button>
                                                </div>
                                               
                                            </div>





                                            <!--<div class="row">
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
                                                </div>-->
                                               
                                            </div>
                                        </div>
                                    </form>
                                     <form method="POST" class="needs-validation" id="transactionForm" action="" novalidate enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{ @$agents->id }}" name="agent_id">
                                        <div class="inner1">
                                            <div class="inner-doc col-md-12">
                                                <div class="row">
                                                    <div class="docu col-md-6 text-left">
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
                            <div class="tab-pane" id="4a">
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="side-card col-md-12">
                                        <div class="inner-card">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6 class="float-left text-left">Total Loan Disbursed</h6>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="float-left text-left"><?=$total_disbursed_amount?></h6>
                                                </div>

                                                <div class="col-md-6">
                                                    <h6 class="float-left text-left">Total Cases Disbursed</h6>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="float-left text-left"><?=$total_disbursed_cases?></h6>
                                                </div>

                                                <div class="col-md-6">
                                                    <h6 class="float-left text-left">Cases Disbursed For The Month (Current Month)</h6>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="float-left text-left"><?=$month_disbursed_cases?></h6>
                                                </div>

                                                <div class="col-md-6">
                                                    <h6 class="float-left text-left">Loan Disbursed For The Month (Current Month)</h6>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="float-left text-left"><?=$month_disbursed_amount?></h6>
                                                </div>

                                                <div class="col-md-6">
                                                    <h6 class="float-left text-left">cases registered for the month</h6>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="float-left text-left"><?=$month_case_registered?></h6>
                                                </div>

                                                <div class="col-md-6">
                                                    <h6 class="float-left text-left">login for the month</h6>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="float-left text-left"><?=$month_case_logins?></h6>
                                                </div>

                                                <div class="col-md-6">
                                                    <h6 class="float-left text-left">rejection for the month</h6>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="float-left text-left"><?=$month_case_rejections?></h6>
                                                </div>

                                                <div class="col-md-6">
                                                    <h6 class="float-left text-left">approval for the month</h6>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="float-left text-left"><?=$month_case_approval?></h6>
                                                </div>

                                                <div class="col-md-6">
                                                    <h6 class="float-left text-left">active cases</h6>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="float-left text-left"><?=$case_active?></h6>
                                                </div>

                                                <div class="col-md-6">
                                                    <h6 class="float-left text-left">conversion ratio</h6>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="float-left text-left"><?=$conversion_ratio?></h6>
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
                </div>
            </div>
        </div>


    </div>
</main>   
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<!-- <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script> -->
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