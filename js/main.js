// start: datatable init for all dashboard grid's

$(document).ready(function () {

    $("li.activeSelected").parents('.sidebar-submenu').css("display", "block");
    $("li.activeSelected").parents('.sidebar-dropdown').addClass("active");

    $(".drop-down-menu").addClass("desktop-click");
    /* Get iniials for name */
    var initname = $('#getFullName').text();
    var initials = initname.match(/\b\w/g) || [];
    initials = ((initials.shift() || '') + (initials.pop() || '')).toUpperCase();
    console.log(initials);
    document.getElementById("initialname").innerHTML = initials;

    // Add active class to the current button (highlight it)
    // var header = document.getElementById("sidebar");
    // var btns = header.getElementsByClassName("sub-menu-link");
    // for (var i = 0; i < btns.length; i++) {
    //     btns[i].addEventListener("click", function () {
    //         var current = document.getElementsByClassName("activeSelected1");
    //         current[0].className = current[0].className.replace("activeSelected1", "");
    //         this.className += " activeSelected1";
    //     });
    // }

    /* start: Navigation JS */

    $("#close-sidebar").on('click', function () {
        $(".page-wrapper").removeClass("toggled");
        $(".page-wrapper").addClass("hideinsmall");
        $(".nav-logo-link").addClass("collapsed");
        $(".drop-down-menu").removeClass("desktop-click");
        $(".drop-down-menu").addClass("mobile-click");
    });

    $("#show-sidebar").on('click', function () {
        $(".page-wrapper").addClass("toggled");
        $(".page-wrapper").removeClass("hideinsmall");
        $(".nav-logo-link").removeClass("collapsed");
        $(".drop-down-menu").addClass("desktop-click");
        $(".drop-down-menu").removeClass("mobile-click");
    });

    $(document).on("click", ".desktop-click", function () {

        $(".sidebar-submenu").slideUp(200);
        if (
            $(this)
            .parent()
            .hasClass("active")
        ) {
            $(".sidebar-dropdown").removeClass("active");
            $(this)
                .parent()
                .removeClass("active");
        } else {
            $(".sidebar-dropdown").removeClass("active");
            $(this)
                .next(".sidebar-submenu")
                .slideDown(200);
            $(this)
                .parent()
                .addClass("active");
        }

    });

    $(document).on("click", ".mobile-click", function () {
        // $(".sidebar-submenu").hide("slide", {
        //     direction: "left"
        // }, 200);
        // if (
        //     $(this)
        //     .parent()
        //     .hasClass("active")
        // ) {
        //     $(".sidebar-dropdown").removeClass("active");
        //     $(this)
        //         .parent()
        //         .removeClass("active");
        // } else {
        //     $(".sidebar-dropdown").removeClass("active");
        //     $(this)
        //         .next(".sidebar-submenu")
        //         .show("slide", {
        //             direction: "left"
        //         }, 200);
        //     $(this)
        //         .parent()
        //         .addClass("active");
        // }
    });

    /* start: Export button global code */

    function addExportButton(table, button_wrapper_id) {
        if ($("#" + button_wrapper_id).length) {
            new $.fn.dataTable.Buttons(table, {
                buttons: [{
                    extend: 'excel',
                    exportOptions: {
                        columns: ':visible'
                    },
                    className: 'btn btn-outline-info btn-sm',
                    titleAttr: 'Export to Excel',
                    text: '',
                    //text: 'Export to Excel',
                }]
            }).container().appendTo($('#' + button_wrapper_id));
        }
    }

    /* start export button for CC Main page */



    /* start: Assessment Details datatable code */

    // var dtad = $('#assessmentDetailsTable').DataTable({
    //     "paging": false,
    //     "bFilter": false

    // });
    // /* start: Assessment Summary datatable code */
    // var dt = $('#assessmentSummaryTable').DataTable({
    //     "paging": false,
    //     "bFilter": false
    // });

    /* start: Category Summary datatable */
    var dtc = $('#categorySummaryTable').DataTable({
        "paging": false,
        "bFilter": false
    });

    /* start: General Observations datatable */
    var dtgo = $('#generalObservationsTable').DataTable({
        "paging": false,
        "bFilter": false
    });
    /* start: Threshold Table datatable  */
    var dtoth = $('#thresholdTable').DataTable({
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search...",
            infoFiltered: ""
        },
        "sDom": 'Rfrtlip'
    });
    /* start: Opportunities datatable  */
    var dtopp = $('#opportunitiesTable').DataTable({
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search...",
            infoFiltered: ""
        },
        "sDom": 'Rfrtlip'
    });

    /* start: No Applicable datatable  */
    var dtna = $('#notApplicableTable').DataTable({
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search...",
            infoFiltered: ""
        },
        "sDom": 'Rfrtlip'

    });
    /* start: Housekeeping datatable  */
    var dthk = $('#houseKeepingTable').DataTable({
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search...",
            infoFiltered: ""
        },
        "sDom": 'Rfrtlip'

    });
    // var ccTableMain = $('#ccTable').DataTable({
    //     "lengthMenu": [
    //         [10, 25, 50, -1],
    //         [10, 25, 50, "All"]
    //     ],
    //     language: {
    //         search: "_INPUT_",
    //         searchPlaceholder: "Search...",
    //         infoFiltered: ""
    //     },
    //     "sDom": 'Rfrtlip'

    // });


    var dtci = $('#costImpactTable').DataTable({
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search...",
            infoFiltered: ""
        },
        "sDom": 'Rfrtlip'

    });



    var dtpoc = $('#proofOfConformanceTable').DataTable({
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search...",
            infoFiltered: ""
        },
        "sDom": 'Rfrtlip'

    });

    //addExportButton(dtad, 'buttonsExportAD');
    // addExportButton(dt, 'buttonsExport'); 

    addExportButton(dtc, 'buttonsExportCS');
    addExportButton(dtopp, 'buttonsExportOpp');
    addExportButton(dtgo, 'buttonsExportGO');
    addExportButton(dtna, 'buttonsExportNA');
    addExportButton(dthk, 'buttonsExportHK');
    addExportButton(dtci, 'buttonsExportCI');
    addExportButton(dtpoc, 'buttonsExportPOC');
    addExportButton(dtoth, 'buttonsExportTH');
    //addExportButton(ccTableMain, 'buttonsExportCCMain');


    /* common js for datatable */
    $('div.dataTables_filter input').addClass('form-control');


});

// Tooltip enable code 

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})