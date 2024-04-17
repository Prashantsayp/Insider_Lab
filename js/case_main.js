$(document).ready(function () {
  
let dataTable = "";
// let getUrl = $("#getUrl").val();
//let getProfessionalUrl = document.getElementById("getProfessionalUrl").value;

$('.applyFilter').click(function (event) { 
    event.preventDefault();
    window.dataTable.ajax.reload()
});

// $('.resetFilter').click(function (event) { 

//    // $('#call-date-filter').val('');
//    // $('#profession-filter').val('');
//     $('#agent-filter').trigger('change');
   
//     event.preventDefault();
//     window.dataTable.ajax.reload()
// });
});

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    let getProfessionalUrl = document.getElementById("getProfessionalUrl").value;

    window.dataTable = $('#ProfessionalTable').DataTable({
        "bInfo" : true,
        "pageLength": 100,
        "ordering": false,
        "paging": true,
         dom: 'Bfrtip',        
        buttons: [
            'colvis'
        ],
        responsive: true,
        autoWidth: false,
    
            ajax: {
            url: getProfessionalUrl,
            dataSrc: "case_list",
            data : function(data){

                // let agentFilter = $('#dealerBranchCC').val(); 
                // let yearFilter = $('#YearCC').val();
                // let MonthFilter = $('#MonthCC').val();
                // let statusFilter = $('#dealerCC').val();

                
                // data.agentFilter = agentFilter;
                // data.yearFilter = yearFilter;
                // data.MonthFilter = MonthFilter;
                // data.statusFilter = statusFilter;
               // data.callDateFilter = callDateFilter;
            },
            headers: "Content-Type: application/json",
            dataType: "JSON",
            method: "get",
           },
           columns: [
                { data: 'action'            },
                { data: 'case_id'           },
                { data: 'name'           },
                { data: 'mobile'       },
                // { data: 'email'    },
                { data: 'location'    },
                { data: 'status'    },
                { data: 'updated' },
                { data: 'cibil'      }, 
                { data: 'user_name'      },  
                // { data: 'case_in_system'      },  
                { data: 'profession'      },           
                { data: 'create_date_time'      },  
                { data: 'employee_type'         },
                { data: 'degree'         },                
                { data: 'past_loan'         },
                 { data: 'lender'         },
                { data: 'desired_loan_amount'         },               
                { data: 'monthly_salary'         },
                { data: 'annual_income'         },
                
            ],
           
           "columnDefs": [
                
            ],
            
            stateSave: true,
        });
 
});

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    let getPersonalUrl = document.getElementById("getPersonalUrl").value;

    window.dataTable = $('#PersonalTable').DataTable({
        "bInfo" : true,
        "pageLength": 100,
        "ordering": false,
        "paging": true,
         dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        responsive: true,
        autoWidth: false,
    
            ajax: {
            url: getPersonalUrl,
            dataSrc: "personal_list",
            data : function(data){

                // let agentFilter = $('#dealerBranchCC').val(); 
                // let yearFilter = $('#YearCC').val();
                // let MonthFilter = $('#MonthCC').val();
                // let statusFilter = $('#dealerCC').val();

                
                // data.agentFilter = agentFilter;
                // data.yearFilter = yearFilter;
                // data.MonthFilter = MonthFilter;
                // data.statusFilter = statusFilter;
               // data.callDateFilter = callDateFilter;
            },
            headers: "Content-Type: application/json",
            dataType: "JSON",
            method: "get",
           },
           columns: [
                { data: 'action'            },
                { data: 'case_id'           },
                { data: 'name'           },
                { data: 'mobile'       },
                // { data: 'email'    },
                { data: 'location'    },
                { data: 'status'    },
                { data: 'updated' },
                { data: 'cibil'      }, 
                { data: 'user_name'      },  
                // { data: 'case_in_system'      },  
                { data: 'profession'      },           
                { data: 'create_date_time'      },  
                { data: 'employee_type'         },
                // { data: 'degree'         },
                { data: 'past_loan'         },
                { data: 'lender'         },
                { data: 'desired_loan_amount'         },              
                { data: 'monthly_salary'         },
                // { data: 'annual_income'         },
                
            ],
           
           "columnDefs": [
                
            ],
            
            stateSave: true,
        });
 
});

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    let getBussinessUrl = document.getElementById("getBussinessUrl").value;

    window.dataTable = $('#businessTable').DataTable({
        "bInfo" : true,
        "pageLength": 100,
        "ordering": false,
        "paging": true,
         dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        responsive: true,
        autoWidth: false,
    
            ajax: {
            url: getBussinessUrl,
            dataSrc: "business_list",
            data : function(data){

                // let agentFilter = $('#dealerBranchCC').val(); 
                // let yearFilter = $('#YearCC').val();
                // let MonthFilter = $('#MonthCC').val();
                // let statusFilter = $('#dealerCC').val();

                
                // data.agentFilter = agentFilter;
                // data.yearFilter = yearFilter;
                // data.MonthFilter = MonthFilter;
                // data.statusFilter = statusFilter;
               // data.callDateFilter = callDateFilter;
            },
            headers: "Content-Type: application/json",
            dataType: "JSON",
            method: "get",
           },
           columns: [
                { data: 'action'            },
                { data: 'case_id'           },
                { data: 'name'           },
                { data: 'mobile'       },
                // { data: 'email'    },
                { data: 'location'    },
                { data: 'status'    },
                { data: 'updated' },
                { data: 'cibil'      }, 
                { data: 'user_name'      },  
                // { data: 'case_in_system'      },  
                { data: 'profession'      },           
                { data: 'create_date_time'      },  
                { data: 'employee_type'         },
                { data: 'degree'         },
                
                { data: 'past_loan'         },

                { data: 'tenure'         },
                { data: 'desired_loan_amount'         },
                
                { data: 'monthly_salary'         },
                { data: 'annual_income'         },
                
            ],
           
           "columnDefs": [
                
            ],
            
            stateSave: true,
        });
 
});
(document).on('click','.user_details',function(){
    var Id = $(this).attr('Id');  
    //var contact_no = $(this).attr('contact_no');  
    //var firebase_token = $(this).attr('firebase_token');     
    //alert(firebase_token);
    // $('#super_staus_id').val(Id);
    // $('#contact_no').val(contact_no);
    // $('#firebase_token').val(firebase_token);
    
    $('#exampleModal').modal({backdrop: 'static', keyboard: true, show: true}); 
}); 
$(document).on('click','.verify_btn',function(){      
        
    $('#modal_mechanic_status').css('display:none;'); 

});