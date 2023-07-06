
$(document).ready(function() {

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

        $('#unallocateRecord').dataTable().fnClearTable();
        $('#unallocateRecord').dataTable().fnDestroy();

        table = $('#unallocateRecord').DataTable({
          'ajax': {
                'url': '../admin/get-unallocated-miner-user',
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
                'url': '../admin/get-unallocated-block-user',
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


   $(document).on('click','#allocate',function(){
        
        var rows_selected = table.column(0).checkboxes.selected();

        let i=1;
        let selected_user_ids = [];
        let sup_id = $("#sup_id").val();
        let pri_id =  $("#pri_id").val();

        if(sup_id !="" && pri_id != "" && rows_selected.length > 0)
        {
        
            $.each(rows_selected, function(index, rowId){

                selected_user_ids[i] = rowId;
                i++;
            });
            
            $.ajax({                
                type:"POST",
                url:"../ajax/user-allocation",
                data:{supid:sup_id,prid:pri_id,appuserid:selected_user_ids,allocationtype:allocationtype,seriestype:seriestype},
                cache:false,
                
                beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
                success : function(response)
                {                               
                    if($.trim(response) == 'no'){

                        if(allocationtype == 'allocate'){

                            alert('Allocation Successfully Completed');
                            window.location.href = "../admin/allocation";

                        }else{

                            alert('Reallocation Successfully Completed');
                            window.location.href = "../admin/reallocation";
                        }

                        

                    }else{

                        if(allocationtype == 'allocate'){

                            alert('Allocation not Done, Something happened Wrong');
                            window.location.href = "../admin/allocation";

                        }else{
                        
                            alert('Allocation not Done, Something happened Wrong');
                            window.location.href = "../admin/reallocation";
                        }    
                        
                    }
                }
            });

        }else{

            alert('Please select Supervisor Id, Primary Id and User Id');
        }    
        


        //console.log(selected_user_ids);

    });
	/** Start ddo allocation, Pravin Bhakare 07-06-2022 **/ 
	
	$("#ddoallocationtbl").on('click','.ddoallocate',function(){
		
         // get the current row
         var currentRow=$(this).closest("tr"); 
         
         var roid =currentRow.find("td:eq(0)").attr("id") // get current row 1st TD value
         var ddoid =currentRow.find("td:eq(1)").find(".ddo_id").val(); // get current row 2nd TD		 
		 
		 $.ajax({
			 
				type:"POST",
                url:"../ajax/ddo-allocation",
                data:{roid:roid,ddoid:ddoid},
                cache:false,
                
                beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
                success : function(response)
                {
					if($.trim(response) == 'true'){
						
						alert('DDO allocation successfully completed');
                        window.location.href = "../admin/ddo-allocation";
                        
                    }else{
						
						alert('DDO allocation not completed');
                        window.location.href = "../admin/ddo-allocation";
					}
					
				} 
			 
		 });
         
    });

});

