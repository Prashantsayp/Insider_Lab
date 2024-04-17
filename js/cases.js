$(document).ready(function() {
    let dataTable = "";
    // let getUrl = $("#getUrl").val();
   // let getUrl = document.getElementById("addressGetCases").value;


    $('.applyFilter').click(function(event) {
        event.preventDefault();
        window.dataTable.ajax.reload()
    });

    $('.resetFilter').click(function(event) {

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


    let getUrl = document.getElementById("addressGetCases").value;

    window.dataTable = $('#ProfessionalMisTable').DataTable({
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
            url: getUrl,
            dataSrc: "case_list",
            data : function(data){

                let agent_id = $('#agent_id').val();
                let fromFilter = $('#fromFilter').val();
                let toFilter = $('#toFilter').val();
                let statusCase = $('#statusCase').val();
                //let statusFilter = $('#dealerCC').val();


                data.agent_id = agent_id;
                data.fromFilter = fromFilter;
                data.toFilter = toFilter;
                data.statusCase = statusCase;
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

               let agent_id = $('#agent_id').val();
                let fromFilter = $('#fromFilter').val();
                let toFilter = $('#toFilter').val();
                let statusCase = $('#statusCase').val();
                //let statusFilter = $('#dealerCC').val();


                data.agent_id = agent_id;
                data.fromFilter = fromFilter;
                data.toFilter = toFilter;
                data.statusCase = statusCase;
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

                let agent_id = $('#agent_id').val();
                let fromFilter = $('#fromFilter').val();
                let toFilter = $('#toFilter').val();
                let statusCase = $('#statusCase').val();
                //let statusFilter = $('#dealerCC').val();


                data.agent_id = agent_id;
                data.fromFilter = fromFilter;
                data.toFilter = toFilter;
                data.statusCase = statusCase;
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

