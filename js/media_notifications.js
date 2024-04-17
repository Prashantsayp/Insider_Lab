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


    let getUrl = document.getElementById("addressGetMediaNotifications").value;

    window.dataTable = $('#media_notifications').DataTable({
        "bInfo" : false,
        "pageLength": 100,
        "ordering": false,
        
        "searching": false,      
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
                { data: 'notes'           },
                { data: 'text'           },
                { data: 'tag'           },
                { data: 'send'           },
                { data: 'status'           },
                { data: 'action'           }                      
                
            ],
           
           columnDefs: [ 
           
            ],
            
            stateSave: true,
        });
 
});
$(document).ready( function () {

$(document).on('click', '#delete-model', function(event) {

      let id = $(this).attr('data-attr');

      $('#delete-model-1').modal("show");

      $('#id').val(id);

  });
$(document).on('click', '#disabled-model', function(event) {

      let id = $(this).attr('data-attr');
      let active= $(this).attr('status');

      $('#disabled-model-1').modal("show");

      $('#mid').val(id);
      $('#active').val(active);

  });
   $(document).on('click', '.close-model-disabled', function(event) { 
      $('#mid').val('');
      $('#active').val('');
      $('#disabled-model-1').modal("hide");     

  });
   $(document).on('click', '.close-model-delete', function(event) { 
      $('#id').val('');
      $('#delete-model-1').modal("hide");     

  });

});