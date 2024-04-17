@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<main class="page-content" style="height: 100%;">
    <div class="container-fluid">
        <!-- start: Header row -->
        <div class="row">
            <header>
                <div class="top-header">
                    <section class="header-top-left">
                        <div class="logo">
                            <a href="#">
                                <h4 class="page-title">Global Notifications</h4>
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
                        <p class="filter-title btn" onclick="myFunction()"><i class="fa fa-plus" aria-hidden="true"></i> Add Notifications                         
                        </p>
                        <div class="collapse show multiselect-ui" id="contentCCMain" style="display:none;">
                        <form method="POST" class="needs-validation" id="NotificationsForm" action="" novalidate enctype="multipart/form-data">
                        @csrf
                            <div class="form-group row m-b-0">                                
                                <div class="status col-xs-12 col-sm-6 col-lg-2">
                                    <label class="col-sm-6 col-lg-6 col-form-label">Notification</label>
                                    <input type="text" required class="form-control col-sm-6 col-lg-12" id="notifi" name="notifications">
                                    </select>
                                </div>
                                <div class="status col-xs-12 col-sm-6 col-lg-2">
                                    <label class="col-sm-6 col-lg-6 col-form-label">Agent</label>
                                        <select id="dealerBranchCC" class="form-control placeholder custome-select" multiple="multiple" id="agent_id" name="agent_id[]" style="display: none;">
                                        @foreach($agents as $agent)
                                        <option value="{{ ( $agent->id) ? $agent->id : '-' }}">{{ ( $agent->name) ? $agent->name : "-" }}</option>
                                        @endforeach

                                    </select>
                                    <select class="js-example-basic-single">
                                        <option value="AL">Alabama</option>
                                      <option value="AK">Alaska</option>
                                      <option value="AZ">Arizona</option>
                                    </select>
                                    
                                </div>
                                <div class="status col-xs-12 col-sm-6 col-lg-2">
                                    <label class="col-sm-6 col-lg-6 col-form-label">Loan</label>
                                        <select class="form-control" style="width: 100% !important" id="loan_id" name="loan"> 
                                        <option value="" disabled="" selected="">Select Loan Range</option>                                       
                                        <option value="0-50">0-50 Lakh</option> 
                                        <option value="50-75">50L-75L</option> 
                                        <option value="75-1">75L-1Crore</option>
                                        <option value="1+">1Crore+</option>                                       

                                    </select>
                                </div>
                                <div class="status col-xs-12 col-sm-6 col-lg-3">
                                    <label class="col-sm-6 col-lg-6 col-form-label">Case Registered For the Month</label>
                                        <select class="form-control" style="width: 100% !important" id="case_registered" name="case_registered">
                                        <option value="" disabled="" selected="">Select Case Range</option>                                        
                                        <option value="5">1-5</option> 
                                        <option value="10">5-10</option> 
                                        <option value="11">10 > </option>                                       

                                    </select>
                                </div>
                                <div class="col-md-2">
                                	<center>
	                                    <button type="submit" name="submit" class="btn btn-outline-dark search-btn applyFilter date-from search-css-btn" id="btn-cc-search" style="padding: 3px;"><i class="fa fa-bell" aria-hidden="true"></i>Send</button>
                                    </center>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>                     
                    <div class="clearfix"></div>                    
                    <div class="cc-tabs-main m-t-0">
                        <div id="content" class="">
                            <div class="card-body all-tab-table">                               
                                <div class="grid-top-actions">                                    
                                    <div id="buttonsExportCCMain" class="btnExportStyle pull-right">
                                    </div>
                                </div>    
                                <input type="hidden" value="{{ route('Notifications-list') }}" id="addressGetNotifications">
                                <table id="notifications" class="display table-bordered" style="width:100%;font-size: 11px;">
                                    <thead>
                                        <tr>                                           
                                            <th class="Notifications">Notifications</th>
                                            <th class="Loans">Loans</th>
                                            <th class="CaseRegistered">Case Registered</th>
                                            <th class="Agents">Agents</th>
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
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-multiselect.js') }}"></script>
<script src="{{ asset('js/notifications.js') }}"></script>

<script>
 $(document).ready(function() {
  $(".js-example-basic-single").select2();
});
    $(document).ready(function() {
	      $("#NotificationsForm").submit(function(e){
	        e.preventDefault(); 
	        $.ajaxSetup({

	            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}

	        });                 
	        $.ajax({
	            type: "POST",
	            url: '{{ route('Notification-Save') }}',
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
	                $('#notifications').DataTable().ajax.reload();
	                 $('#notifi').val('');
                     $('#loan_id option:selected').val('');
                     $('#agent_id option:selected').val('');
                     $('#case_registered option:selected').val('');
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

