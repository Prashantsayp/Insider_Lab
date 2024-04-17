$(document).ready(function () {
let dataTable = "";
// let getUrl = $("#getUrl").val();
//let getUrl = document.getElementById("addressGetAgents").value;

});

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    let getUrl = document.getElementById("addressGetNotifications").value;

    window.dataTable = $('#notifications').DataTable({
        "bInfo" : false,
        "pageLength": 100,
        "ordering": false,
        
        "searching": true,      
        responsive: true,
        autoWidth: false,
        "bFilter": false,
        "bPaginate": false,

    
            ajax: {
            url: getUrl,
            dataSrc: "notification_list",
            data : function(data){
                
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
                { data: 'notifications'           },
                { data: 'loan'           }, 
                { data: 'case_registered'           },
                { data: 'agents'           }                    
                
            ],
           
           columnDefs: [ 
           
            ],
            
            stateSave: true,
        });
 
});