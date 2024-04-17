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
                                <h4 class="page-title">Global Media Notifications</h4>
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
                        <p class="filter-title btn" onclick="myFunction()"><i class="fa fa-plus" aria-hidden="true"></i> Add Media Notifications                         
                        </p>
                        <div class="collapse show multiselect-ui" id="contentCCMain" style="display:none;">
                        <form method="POST" class="needs-validation" id="MediaNotificationsForm" action="" novalidate enctype="multipart/form-data">
                        @csrf
                            <div class="form-group row m-b-0">                                
                                <div class="status col-xs-12 col-sm-6 col-lg-2">
                                    <label class="col-sm-6 col-lg-6 col-form-label">Notification</label>
                                    <input type="file" class="form-control col-sm-6 col-lg-12" id="notifisa" required name="media">
                                </div>                                  
                                <div class="status col-xs-12 col-sm-6 col-lg-3">
                                    <label class="col-sm-6 col-lg-6 col-form-label">Embbed Link/Text</label>
                                    <input type="text" required class="form-control col-sm-6 col-lg-12" id="notifdfi" name="text_link">
                                </div>    
                                <div class="status col-xs-12 col-sm-6 col-lg-2">
                                    <label class="col-sm-6 col-lg-6 col-form-label">Tag</label>
                                    <input type="radio" class="" value="Training" name="tag">Training
                                    <input type="radio" class="" value="Article" name="tag" checked>Article
                                </div>
                                <div class="status col-xs-12 col-sm-6 col-lg-2">
                                    <label class="col-sm-6 col-lg-6 col-form-label">Send Notification</label>
                                    <input type="radio" class="" value="Yes" name="send">Yes
                                    <input type="radio" class="" value="No" name="send" checked>No
                                </div> 
                                 <div class="status col-xs-12 col-sm-6 col-lg-6">
                                    <label class="col-sm-6 col-lg-6 col-form-label">Text</label>
                                   <!--  <input type="textarea" required class="form-control col-sm-6 col-lg-12" id="notifi" name="notes"> -->
                                   <!--  <textarea id="notifi"  required class="form-control col-sm-6 col-lg-12" name="notes" rows="2" cols="50"></textarea>
                                    -->
                                    <textarea class="required form-control col-sm-6 col-lg-12" value="" id="notifi"></textarea>
                                    <input type="hidden" id="notify" name="notes">
                                </div>                          
                                <div class="status col-xs-12 col-sm-6 col-lg-12">
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
                        @include('alerts/flash-message')
                        <div id="content" class="all-tab-tables">
                            <div class="card-body all-tab-table table-tab-all">                               
                                <div class="grid-top-actions">                                    
                                    <div id="buttonsExportCCMain" class="btnExportStyle pull-right">
                                    </div>
                                </div>    
                                <input type="hidden" value="{{ route('Media-Notifications-list') }}" id="addressGetMediaNotifications">
                                <table id="media_notifications" class="display table-bordered" style="width:100%;font-size: 11px;">
                                    <thead>
                                        <tr>                                           
                                            <th class="Media">Media</th>
                                            <th class="notes">Notes</th>
                                            <th class="text">Text/Embbed Link</th>
                                            <th class="Tag">Tag</th>
                                            <th class="Send">Send</th>
                                            <th class="Status">Status</th>
                                            <th class="Action">Action</th>
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

<div id="delete-model-1" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-confirm">

    <div class="modal-content">

      <div class="modal-header">

        <div class="icon-box">

         <!--  <i class="">warning</i> -->  <!-- &#xE5CD;  error_outline -->

        </div>        

        <h4 class="modal-title">Are you sure?</h4>  

        <button type="button" class="close close-model-delete" data-dismiss="modal" aria-hidden="true">&times;</button>

      </div>

      <div class="modal-body">

        <p>Do you really want to delete these Notification? This process cannot be undone.</p>

      </div>

       <form method="POST" class="needs-validation" action="{{ route('Media-Notification-Delete') }}" novalidate>

        @csrf

        <input type="hidden" id="id" value="" name="id">

      <div class="modal-footer m-auto">

        <button type="button" class="btn btn-info close-model-delete" data-dismiss="modal">Cancel</button>  

        <button type="submit" class="btn btn-danger">Delete</button> 

        </form>

      </div>

    </div>

  </div>

</div>

<div id="disabled-model-1" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-confirm">

    <div class="modal-content">

      <div class="modal-header">

        <div class="icon-box">

         <!--  <i class="">warning</i> -->  <!-- &#xE5CD;  error_outline -->

        </div>        

        <h4 class="modal-title">Are you sure?</h4>  

        <button type="button" class="close close-model-disabled" data-dismiss="modal" aria-hidden="true">&times;</button>

      </div>

      <div class="modal-body">

        <p>Do you really want to Disabled these Notification?</p>

      </div>

       <form method="POST" class="needs-validation" action="{{ route('Media-Notification-Disabled') }}" novalidate>

        @csrf

        <input type="hidden" id="mid" value="" name="id">
        <input type="hidden" id="active" value="" name="active">

      <div class="modal-footer m-auto">

        <button type="button" class="btn btn-info close-model-disabled" data-dismiss="modal">Cancel</button>  

        <button type="submit" class="btn btn-danger">Disabled</button> 

        </form>

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
<script src="{{ asset('js/bootstrap-multiselect.js') }}"></script>
<script src="{{ asset('js/media_notifications.js') }}"></script>
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>

<script>
     $(document).ready(function () {
       // $('.ckeditor').ckeditor();             
    });
      $(document).ready(function () {       
        var editor = CKEDITOR.replace( 'notifi' );

        //var data = CKEDITOR.instances.editor1.getData();
        editor.on( 'change', function( evt ) {
             $('#notify').val(evt.editor.getData());
            console.log( 'Total bytes: ' + evt.editor.getData() );
        });
    
    });
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });
    $(".select2-tags").select2({
        tags: true,
        theme: 'bootstrap4'
    });

    $(document).ready(function() {
	      $("#MediaNotificationsForm").submit(function(e){
            // var txtVal = CKEDITOR.instances['notifi'].getData();
            // alert(txtVal);
	        e.preventDefault(); 
	        $.ajaxSetup({

	            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}

	        });                 
	        $.ajax({
	            type: "POST",
	            url: '{{ route('Media-Notification-Save') }}',
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
	                $('#media_notifications').DataTable().ajax.reload();
	                 $('#notifi').val('');
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