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
                                <h4 class="page-title">Agents</h4>
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
            <div class="col-sm-12 no-padding">
                <div class="card card-custom cc-home-main">
                    <div class="card-body body-card">

                        <div class="custom-search-box box-search-custom box-search-custom-filter" style="padding: 15px;">
                        <p class="filter-title btn" onclick="myFunction()"><i class="fa fa-filter" aria-hidden="true"></i> Filters                         
                        </p>
                        <input type="hidden" value="{{ route('Agent-show') }}" id="addressGetAgents">
                        
                        <div class="collapse show multiselect-ui" id="contentCCMain" style="display:none;">
                            <div class="form-group row m-b-0">
                                
                                <div class="status col-xs-12 col-sm-6 col-lg-4">
                                    <label class="col-sm-6 col-lg-4 col-form-label">Status</label>
                                    <select id="dealerCC" class="form-control placeholder" multiple="multiple" style="width: 50% !important;display:none;" name="dealerCC">
                                        <option value="1" selected="selected">IsActive - Yes</option>
                                        <option value="0">IsActive - No</option>
                                    </select>
                                </div>
                                <div class="status col-xs-12 col-sm-6 col-lg-4">
                                    <label class="col-sm-6 col-lg-4 col-form-label">Agent Name</label>
                                    <select id="dealerBranchCC" class="form-control placeholder" multiple="multiple" name="dealerBranchCC" style="display: none;">
                                        @foreach($agents as $agent)
                                        <option value="{{ ( $agent->id) ? $agent->id : '-' }}">{{ ( $agent->name) ? $agent->name : "-" }}</option>
                                        @endforeach

                                    </select>
                                </div> 




                                <div class="status col-xs-12 col-sm-6 col-lg-4">
                                    <label for="YearCC" class="col-sm-6 col-lg-4 col-form-label">From</label>
                                    <input type="date" id="YearCC" class="date-from form-control col-sm-6 col-lg-12" name="YearCC" style="width: 292px !important;">
                                </div>
                                <div class="status col-xs-12 col-sm-6 col-lg-4">
                                    <label for="MonthCC" class="col-sm-6 col-lg-4 col-form-label">To</label>
                                    <input type="date" id="MonthCC" class="date-from form-control col-sm-6 col-lg-12" name="MonthCC" style=" width: 292px !important;">
                                </div>


                               
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-outline-dark search-btn applyFilter date-from search-css-btn" id="btn-cc-search" style="padding: 3px;"><i class="fa fa-search" aria-hidden="true"></i>
                                        Search</button>
                                </div>

                            </div>


                        </div>
                    </div>
                    <div class="clearfix"></div>                    
                    <div class="cc-tabs-main m-t-0">
                        <div id="content" class="all-tab-tables">
                            <div class="card-body all-tab-table table-tab-all">                               
                                <div class="grid-top-actions">                                    
                                    <div id="buttonsExportCCMain" class="btnExportStyle pull-right">
                                    </div>
                                </div>                                
                                <table id="ccTable1" class="display table-responsive table-bordered" style="width:100%;font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th class="ActionGO">Action</th>
                                            <th class="AgentName">Agent ID</th>
                                            <th class="AgentName">Agent Name</th>
                                            <th class="MobileGO">Mobile</th>
                                            <th class="EmailGO">Email</th>
                                            <th class="LocationGO">Location</th>
                                            <th class="LocationGO">Industry/Services</th>
                                            <!-- <th class="AadharPanGO">Aadhar/PAN</th> -->
                                            <th class="OccupationGO">Occupation</th>
                                            <th class="IsActiveGO">IsActive</th>
                                            <th class="CeateDateGO">Create Date</th>
                                            <th class="ApproveRejectDateGO">Approve/Reject Date</th>
                                            <th class="WhatsAppNoGO">WhatsApp No.</th>

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
            </div>
        </div>


    </div>
</main>   
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
<!-- <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script> -->
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
            buttonContainer: '<div/> '
        });

    });
</script>

