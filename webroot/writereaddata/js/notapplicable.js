                              
                                                            $('document').ready(function() {

                                                               $('#row_container-1').ready(function(){
                                                                  checkCheckbox();
                                                               })

                                                                $('#grindingnotapp').on('change', function(){
                                                                    if($(this).prop('checked')){
                                                                        //  $("#drygrinding").hide();
                                                                        $('#form_id input[type=text]').prop('disabled', true);
                                                                        $('#form_id select').prop('disabled', true);
                                                                        $('#add_more').prop('disabled', true);
                                                                        $('.remove_btn_btn').show();
                                                                    }
                                                                    else {
                                                                        //  $("#drygrinding").show();
                                                                        $('#form_id input[type=text]').prop('disabled', false);
                                                                        $('#form_id select').prop('disabled', false);
                                                                        $('#add_more').prop('disabled', false);
                                                                        $('.remove_btn_btn').show();
                                                                    }


                                                                });
                                                               
                                                            });

                                                            function checkCheckbox(){
                                                               
                                                               if($('#grindingnotapp').prop('checked')){
                                                                  //  $("#drygrinding").hide();
                                                                  $('#form_id input[type=text]').prop('disabled', true);
                                                                  $('#form_id select').prop('disabled', true);
                                                                  $('#add_more').prop('disabled', true);
                                                                  $('.remove_btn_btn').hide();
                                                               }
                                                               else {
                                                                  //  $("#drygrinding").show();
                                                                  $('#form_id input[type=text]').prop('disabled', false);
                                                                  $('#form_id select').prop('disabled', false);
                                                                  $('#add_more').prop('disabled', false);
                                                                  $('.remove_btn_btn').show();
                                                               }

                                                            }

                                        