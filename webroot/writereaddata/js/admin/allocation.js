
$(document).ready(function() {
$('#allocateRecordnew').dataTable();
    $('#reallocateRecordnew').dataTable({
				  order: [],
				  columnDefs: [
					{ 
						//defaultContent: '',
						targets: [4,5,6,7], 
						render: function(data, type, full, meta){
							if(type === 'filter' || type === 'sort'){
								var api = new $.fn.dataTable.Api(meta.settings);
								var td = api.cell({row: meta.row, column: meta.col}).node();
								var $input = $('select, input', td);
								if($input.length && $input.is('select')){
								   data = $('option:selected', $input).text();
								} else {                   
								   data = $input.val();
								}
							}

							return data;
						}
					}
				  ]     
			   });

    var table;
    var seriestype = $("#seriestype").val();
    var allocationtype = $("#allocationtype").val();

    /* For getting list on page load */

    if(seriestype == 'fseries'){

        get_unallocated_miner_user_id()

    }else{

        get_unallocated_end_user_id();

    }
    

     /* For getting list on filter selection */
    $(document).on('change','.end_all_filter',function(){

        if(seriestype == 'fseries'){

            get_unallocated_miner_user_id()

        }else{

            get_unallocated_end_user_id();

        }

   });


   function get_unallocated_miner_user_id(){


        let mineral_name = $("#mineral_name").val();
        let state_code =  $("#state_code").val();

        $('#allocateRecord').dataTable().fnClearTable();
        $('#allocateRecord').dataTable().fnDestroy();

        table = $('#unallocateRecord').DataTable({
          'ajax': {
                'url': '../admin/get-unallocated-miner-lease',
                'type': 'POST',
                'data': {mineral_name:mineral_name,state_code:state_code,allocationtype:allocationtype},
                'beforeSend': function (xhr) { // Add this line
                        xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                }

            },
          'columnDefs': [
             {
                'targets': 0,
                'checkboxes': {
                   'selectRow': true
                }
             }
          ],
          'select': {
             'style': 'multi'
          },
          'order': [[0, 'asc']]
       });


   }



   function get_unallocated_end_user_id(){
   
        let activity_type = $("#activity_type").val();
        let state_code =  $("#state_code").val();


        $('#unallocateRecord').dataTable().fnClearTable();
        $('#unallocateRecord').dataTable().fnDestroy();

        table = $('#unallocateRecord').DataTable({
          'ajax': {
                'url': '../admin/get-unallocated-lease',
                'type': 'POST',
                'data': {activity_type:activity_type,state_code:state_code,allocationtype:allocationtype},
                'beforeSend': function (xhr) { // Add this line
                        xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                }

            },
          'columnDefs': [
             {
                'targets': 0,
                'checkboxes': {
                   'selectRow': true
                }
             }
          ],
          'select': {
             'style': 'multi'
          },
          'order': [[0, 'asc']]
       });

   } 


  
    // for allocation by shankhpal    
   $(document).on('click','.allocate',function(e){
             e.preventDefault();
			  var lease_id = $(this).closest("tr").find("#lease_id").attr("rdid");
              //var lease_id = $(this).closest("tr").find("#lease_id").text();
              var scru_id = $(this).closest("tr").find("#scru_id1").val();
              var suprit_id = $(this).closest("tr").find("#suprit_id1").val();
              var state_id = $(this).closest("tr").find('#state_id').val();
			  var com_id = $(this).closest("tr").find('#com_id').val(); // Added  by Shweta Apale on 13-09-2022
              let activity_type = $("#activity_type").val();
               

               if(scru_id !="")
               {
          
                $.ajax({                
                    type:"POST",
                    url:"../ajax/user-allocation",
                    //Added com_id by Shweta Apale on 13-09-2022
					data: { scru_id: scru_id, suprit_id: suprit_id, appuserid: lease_id, state_id: state_id, com_id: com_id, allocationtype: allocationtype },
                    cache:false,
                    async:false,
                    
                    beforeSend: function (xhr) { // Add this line
                        xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                    },
                    success : function(response)
                    {        

                        if($.trim(response) == 'yes'){
                           
                            if(allocationtype == 'allocate'){

                                alert('Allocation Successfully Completed');
                                window.location.href = "../admin/allocation";

                            }
                            else
                            {
                                alert('Allocation not Done, Something happened Wrong');
                                window.location.href = "../admin/allocation";
                            }
                        }
                        else if($.trim(response) == 'existed'){
                            alert('Allocation already done! Kindly check under Re-allocation window.');
                            window.location.href = "../admin/allocation";
                        }
                        else
                            {
                                alert('Allocation not Done, Something happened Wrong');
                                window.location.href = "../admin/allocation";
                            }
                    }
                });

        }else{

            alert('Please select Scruitinizer Id');
        } 
           }); 
     
 
       // for reallocation by shankhpal
        $(document).on('click', '.reallocate', function(){

            
            var id = $(this).closest("tr").find("#id").text();
           
			var lease_id = $(this).closest("tr").find("#lease_id").attr("rdid"); //Change text() to attr() 14-09-2022 Shweta Apale
            var scru_id = $(this).closest("tr").find("#scru_id1").val();
            var suprit_id = $(this).closest("tr").find("#suprit_id1").val();
            var state_id = $(this).closest("tr").find('#state_id').val();
			var com_id = $(this).closest("tr").find('#com_id').val(); // Added  by Shweta Apale on 14-09-2022
            let activity_type = $("#activity_type").val();
               

               if(scru_id !="")
               {
          
                $.ajax({                
                    type:"POST",
                    url:"../ajax/user-Reallocation",
                    //Added com_id by Shweta Apale on 14-09-2022
					data: { id: id, scru_id: scru_id, suprit_id: suprit_id, appuserid: lease_id, state_id: state_id, com_id: com_id, allocationtype: allocationtype },
                    cache:false,
                    
                    beforeSend: function (xhr) { // Add this line
                        xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                    },
                    success : function()
                    {        
                           
                            if(allocationtype == 'reallocate'){

                                alert('Reallocation Successfully Completed');
                                window.location.href = "../admin/reallocation";

                            }
                            else
                            {
                                alert('Reallocation not Done, Something happened Wrong');
                                window.location.href = "../admin/reallocation";
                            }
                           
                            
                        }
                    
                });

        }else{

            alert('Please select Scruitinizer Id');
        } 
           }); 


});

