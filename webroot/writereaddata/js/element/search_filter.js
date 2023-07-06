$(document).ready(function() {
    
    $('#f_state').change(function(){

        var state = $(this).val();
        
        $.ajax({				
                type:"POST",
                url:"../ajax/get-districts-arr",
                data:{state:state},
                cache:false,
                
                beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
                success : function(response)
                {	
                    $("#f_district").find('option').remove();
                    $("#f_district").append(response);						
                }
        });
        			
    });
    

});