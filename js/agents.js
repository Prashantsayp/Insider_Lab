$(document).ready(function () {
let dataTable = "";
// let getUrl = $("#getUrl").val();
let getUrl = document.getElementById("addressGetAgents").value;


$('.applyFilter').click(function (event) { 
    event.preventDefault();
    window.dataTable.ajax.reload()
});

$('.resetFilter').click(function (event) { 

   // $('#call-date-filter').val('');
   // $('#profession-filter').val('');
    $('#agent-filter').trigger('change');
   
    event.preventDefault();
    window.dataTable.ajax.reload()
});
});

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    let getUrl = document.getElementById("addressGetAgents").value;

    window.dataTable = $('#ccTable1').DataTable({
        "bInfo" : true,
        "pageLength": 100,
        "ordering": false,
        "paging": true,
        dom: 'Bfrtip',
        buttons: [
            // {
            //     extend: 'copyHtml5',
            //     exportOptions: {
            //         columns: [ 0, ':visible' ]
            //     }
            // },
            // {
            //     extend: 'excelHtml5',
            //     exportOptions: {
            //         columns: ':visible'
            //     }
            // },
            // {
            //     extend: 'pdfHtml5',
            //     exportOptions: {
            //         columns: [ 0, 1, 2, 5 ]
            //     }
            // },
            'colvis'
        ],
        responsive: true,
        autoWidth: false,

    
            ajax: {
            url: getUrl,
            dataSrc: "agent_list",
            data : function(data){

                let agentFilter = $('#dealerBranchCC').val(); 
                let yearFilter = $('#YearCC').val();
                let MonthFilter = $('#MonthCC').val();
                let statusFilter = $('#dealerCC').val();

                
                data.agentFilter = agentFilter;
                data.yearFilter = yearFilter;
                data.MonthFilter = MonthFilter;
                data.statusFilter = statusFilter;
               // data.callDateFilter = callDateFilter;
            },
            headers: "Content-Type: application/json",
            dataType: "JSON",
            method: "get",
            // success: function (data) { 
            //     console.clear();
            //     console.log(data);
            //  }
           },
           columns: [
                { data: 'action'            },
                { data: 'agent_id'           },
                { data: 'name'           },
                { data: 'mobile'       },
                { data: 'email'    },
                { data: 'location'    },
                { data: 'industry_services'    },
                
                { data: 'user_type'      },  
                { data: 'disabled'      },  
                { data: 'created_at'      },           
                { data: 'mobile_verified_at'      },  
                { data: 'mobile'         },
                
            ],
           
           columnDefs: [ 
           
            ],
            
            stateSave: true,
        });
 
});