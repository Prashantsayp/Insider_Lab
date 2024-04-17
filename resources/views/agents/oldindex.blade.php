@extends('layouts.app')
@section('content')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">





<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"> -->
<!-- Select2 CSS -->
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" /> -->
<div class="container-fluid">
    <!-- start: Header row -->
    <div class="row">
        <header>
            <div class="top-header">
                <section class="header-top-left">
                    <div class="logo">
                        <a href="index.html">
                            <!-- <img src="images/go-org-logo.png" alt="GP ORG" /> -->
                            <h4 class="page-title">Agents</h4>
                        </a>
                    </div>
                </section>
                <section class="header-top-right">
                    <!-- <div class="cat-logo">
                        <img src="images/catlogo.png" alt="CATERPILLAR" />
                    </div> -->
                    <div class="dropdown user-profile-main">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="userProfileMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="userProfileMenu">
                            <p class="user-name">
                                <span id="initialname" class="name-initl"></span>
                                <span id="getFullName">Admin Name</span>
                            </p>
                            <p class="user-designation">Administrator</p>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void(0)" target="_blank">Settings <i class='fa fa-gear pull-right mt-1'></i></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void(0)" target="_blank">Sign Out <i class='fa fa-sign-out pull-right mt-1'></i></a>
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
        <div class="col-sm-12">
            <div class="card card-custom">
                <div class="card-body">

                    <!-- start: Approval Queue Custom search section -->
                    <div class="custom-search-box">
                        <p class="filter-title btn" onclick="myFunction()"><i class="fa fa-filter" aria-hidden="true"></i> Filters
                            <!-- <button class="btn btn-primary btn-sm pull-right" id="toggle-search-a"
                                                type="button" data-toggle="collapse" data-target="#contentCCMain"
                                                aria-expanded="false" aria-controls="contentCCMain">
                                                Hide
                                            </button> -->
                        </p>
                        <input type="hidden" value="{{ route('Agent-show') }}" id="addressGetAgents">

                        <!-- <div class="collapse show multiselect-ui" id="contentCCMain">
                            <div class="form-group row m-b-0">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label for="dealerCC"
                                        class="col-sm-6 col-lg-4 col-form-label pull-left">Status</label>
                                    <select id="dealerCC"
                                        class="form-control col-sm-6 col-lg-8 placeholder"
                                        multiple="multiple" style="display:none" name="dealerCC">
                                        <option value="Approve">Approve</option>
                                        <option value="Reject">Reject</option>
                                        <option value="Pending">Pending</option>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label for="dealerBranchCC"
                                        class="col-sm-6 col-lg-4 col-form-label pull-left">Agent Name</label>
                                    <select id="dealerBranchCC"
                                        class="form-control col-sm-6 col-lg-8 placeholder"
                                        multiple="multiple" style="display:none" name="dealerBranchCC[]">
                                        @foreach($agents as $agent)
                                        <option value="{{ ( $agent->id) ? $agent->id : '-' }}">{{ ( $agent->name) ? $agent->name : "-" }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label for="YearCC"
                                        class="col-sm-6 col-lg-4 col-form-label pull-left" style="padding:7px">Completed Year</label>
                                    <select id="YearCC"
                                        class="form-control col-sm-6 col-lg-8 placeholder"
                                        multiple="multiple" style="display:none" name="YearCC[]">
                                        <option value="2021">2021</option>
                                        <option value="2020">2020</option>
                                        <option value="2019">2019</option>
                                        <option value="2018">2018</option>
                                        <option value="2017">2017</option>
                                        <option value="2016">2016</option>
                                        <option value="2015">2015</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row m-b-0">
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                    <label for="MonthCC" class="col-sm-6 col-lg-4 col-form-label
                                        pull-left" style="padding:7px">Completed Month</label>
                                    <select id="MonthCC"
                                        class="form-control col-sm-6 col-lg-8 placeholder"
                                        multiple="multiple" style="display:none" name="MonthCC[]">
                                        <option value="01">Jan</option>
                                        <option value="02">Feb</option>
                                        <option value="03">Mar</option>
                                        <option value="04">Apr</option>
                                        <option value="05">May</option>
                                        <option value="06">Jun</option>
                                        <option value="07">Jul</option>
                                        <option value="08">Aug</option>
                                        <option value="09">Sep</option>
                                        <option value="10">Oct</option>
                                        <option value="11">Nov</option>
                                        <option value="12">Dec</option>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-4"></div>
                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                        <button type="submit" class="btn btn-outline-dark btn-sm mr-2 pull-right applyFilter"
                                            id="btn-cc-search"><i class="fa fa-search" aria-hidden="true"></i>
                                            Search</button>
                                </div>
                            </div>
                            
                        </div>  -->
                        <div class="collapse show multiselect-ui" id="contentCCMain" style="display:none;">
                            <div class="form-group row m-b-0">
                                <!-- <div class="col-md-3">
                                                <label for="uname">Username:</label>
                                                <input type="text" class="form-control" id="uname" placeholder="Enter username" name="uname" required>

                                            </div> -->
                                <div class="status col-md-3">
                                    <label class="col-md-12">Status</label>
                                    <select id="dealerCC" class="form-control placeholder" multiple="multiple" style="width: 50% !important;" name="dealerCC">
                                        <option value="1" selected="selected">IsActive - Yes</option>
                                        <option value="0">IsActive - No</option>
                                    </select>
                                </div>
                                <div class="status col-md-3">
                                    <label class="col-md-12">Agent Name</label>
                                    <select id="dealerBranchCC" class="form-control placeholder" multiple="multiple" name="dealerBranchCC">
                                        @foreach($agents as $agent)
                                        <option value="{{ ( $agent->id) ? $agent->id : '-' }}">{{ ( $agent->name) ? $agent->name : "-" }}</option>
                                        @endforeach

                                    </select>
                                </div>
                               <!--  <div class="col-md-2">
                                    <label>Agent Name</label>
                                    <select id="dealerBranchCC" name="dealerBranchCC" class="select2bs4 form-control" aria-live="TRUE" style="width: 100% !important;" >
                                        <option value="" disabled="">--Select Agent-- </option>
                                         @foreach($agents as $agent)
                                        <option value="{{ ( $agent->id) ? $agent->id : '-' }}">{{ ( $agent->name) ? $agent->name : "-" }}</option>
                                        @endforeach
                                    </select>
                                </div> -->

                                <div class="status col-md-2">
                                    <label for="YearCC" class="col-md-12">From</label>
                                    <input type="date" id="YearCC" class="" name="YearCC">
                                </div>
                                <div class="status col-md-2">
                                    <label for="MonthCC" class="col-md-12">To</label>
                                    <input type="date" id="MonthCC" class="" name="MonthCC">
                                </div>
                                
                                <!-- <div class="status col-md-2">
                                                <label for="YearCC" class="col-md-12">Completed Year</label>
                                                <select id="YearCC" class="form-control placeholder" style="width: 180px;" multiple="multiple" style="display:none" name="YearCC[]">
                                                        <option value="2021">2021</option>
                                                        <option value="2020">2020</option>
                                                        <option value="2019">2019</option>
                                                        <option value="2018">2018</option>
                                                        <option value="2017">2017</option>
                                                        <option value="2016">2016</option>
                                                        <option value="2015">2015</option>
                                                    </select>
                                            </div> -->
                                <!-- <div class="status col-md-2">
                                                <label for="MonthCC" class="col-md-12">Completed Month</label>
                                                <select id="MonthCC" class="form-control  placeholder" multiple="multiple" style="display:none" name="MonthCC[]">
                                                           <option value="01">Jan</option>
                                                            <option value="02">Feb</option>
                                                            <option value="03">Mar</option>
                                                            <option value="04">Apr</option>
                                                            <option value="05">May</option>
                                                            <option value="06">Jun</option>
                                                            <option value="07">Jul</option>
                                                            <option value="08">Aug</option>
                                                            <option value="09">Sep</option>
                                                            <option value="10">Oct</option>
                                                            <option value="11">Nov</option>
                                                            <option value="12">Dec</option>
                                                        </select>
                                                <div class="col-xs-12 col-sm-6 col-lg-4"></div>

                                            </div> -->
                                <div class="col-md-2" style="text-align:center;">
                                    <button type="button" class="btn btn-outline-dark search-btn applyFilter" id="btn-cc-search" style="padding: 3px;"><i class="fa fa-search" aria-hidden="true"></i>
                                        Search</button>
                                </div>

                            </div>


                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <!--start: Contamination Control tabs started from here -->
                    <div class="cc-tabs-main m-t-0">
                        <div id="content" class="all-tab-tables">
                            <div class="card-body all-tab-table">
                                <!-- start: Contamination Control datatable grid -->
                                <div class="grid-top-actions">
                                    <!-- <div class="column-visiblity">
                                        <ul class="main-ul allow-focus">
                                            <li class="dropdown">
                                                <a href="#" data-toggle="dropdown" class="btn btn-outline-primary btn-sm
                                                        dropdown-toggle">
                                                    Column
                                                    Visibility<b class="caret"></b>
                                                </a>
                                                Start of Column Visibility List for Housekeeping Table
                                                <ul class="dropdown-menu visibilityCheckCommon"
                                                    id="grpChkBoxCCMain"
                                                    data-associated-table="ccTable1">
                                                    <li style="display:none;">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox"
                                                                    name="ActionGO">Action
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="AgentNameGO">Agent Name
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="MobileGO">Mobile
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="EmailGO">Email
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="AadharPanGO">Aadhar/PAN
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="OccupationGO">Occupation
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="IsActiveGO">IsActive
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="CeateDateGO">Create Date
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="ApproveRejectDateGO">Approve/Reject Date
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="WhatsAppNoGO">WhatsApp No.
                                                            </label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div> -->
                                    <div id="buttonsExportCCMain" class="btnExportStyle pull-right">
                                    </div>
                                </div>
                                <!-- Start of Housekeeping table -->
                                <table id="ccTable1" class="display table-responsive" style="width:100%;font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th class="ActionGO">Action</th>
                                            <th class="AgentName">Agent ID</th>
                                            <th class="AgentName">Agent Name</th>
                                            <th class="MobileGO">Mobile</th>
                                            <th class="EmailGO">Email</th>
                                            <th class="LocationGO">Location</th>
                                            <th class="LocationGO">Industry/Services</th>
                                            <th class="AadharPanGO">Aadhar/PAN</th>
                                            <th class="OccupationGO">Occupation</th>
                                            <th class="IsActiveGO">IsActive</th>
                                            <th class="CeateDateGO">Create Date</th>
                                            <th class="ApproveRejectDateGO">Approve/Reject Date</th>
                                            <th class="WhatsAppNoGO">WhatsApp No.</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach($agents as $agent)
                                        <tr>
                                            <td><a href="{{ route('agents.show', [$agent->id]) }}">View</a></td>
                                        <td>{{ ( $agent->name) ? $agent->name : "-" }}</td>
                                        <td>{{ ( $agent->mobile) ? $agent->mobile : "-" }} </td>
                                        <td>{{ ( $agent->email) ? $agent->email : "-" }} </td>
                                        <td><img src="{{ $agent->aadhar_card }}" /></td>
                                        <td>{{ ( $agent->user_type) ? $agent->user_type : "-" }}</td>
                                        <td>{{ ($agent->disabled) ? "Yes" : "No" }}</td>
                                        <td>{{ ( $agent->created_at) ? $agent->created_at : "-" }} </td>
                                        <td>{{ ( $agent->mobile_verified_at) ? $agent->mobile_verified_at : "-" }} </td>
                                        <td>{{ ( $agent->mobile) ? $agent->mobile : "-" }} </td>
                                        </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            </div>



                        </div>
                    </div>



                </div>

            </div>
        </div>
    </div>

</div>
@endsection


<!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
<!-- <script src="<?php// echo base_url()?>assets/plugins/jquery/jquery.min.js"></script>
<script src="<?php //echo base_url()?>assets/plugins/select2/js/select2.full.min.js"></script> -->

<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-multiselect.js') }}"></script>
<script src="{{ asset('js/agents.js') }}"></script>

<script>
    $('.select2bs4').select2({
    theme: 'bootstrap4'
});
$(".select2-tags").select2({
    tags: true,
    theme: 'bootstrap4'
});
    // $(document).ready(function() {
    //     $('.js-example-basic-single').select2();
    // });

    function myFunction() {
        var x = document.getElementById("contentCCMain");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
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
        $('#dealerCC, #locationCC,#dealerBranchCC').multiselect({
            numberDisplayed: 1,
            includeSelectAllOption: true,
            allSelectedText: 'No option left ...',
            buttonContainer: '<div class="btn-group col-sm-6 col-lg-8" /> '
        });

    });
</script>

