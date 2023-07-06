<?php ?>
<!-- Create form by Ankush T on 19/04/2023  -->
<div class="row p-0">
	<div class="container">
    
		 <div class="main-card card fcard mb-1 mt-n3">
		    <div class="card-body">
		        <div class="rows text-center"><h4 class="alert alert-secondary alert-heading p-2 pl-3"><?php echo $heading; ?></h4>
		        	
		        	<?php if ($buttonlabel == 'Update') { ?>
		                
		                <h4 class="text-center font-weight-bold text-custom"><u>Token Number  :</u><label class="input text font-weight-bold  pr-4 ml-2"><u><?php if(!empty($tokenNumber)){echo ucwords($tokenNumber);}else { echo "N/A";} ?></u></label></h4>

		            <?php } ?> 

		            <?php if(!empty($this->getRequest()->getSession()->read('usr_msg_suc'))){ ?>
                     <div class="alert alert-success fade show" role="alert" id=msg-box><i class="fa fa-check-circle"></i> 
                        <?php echo $this->getRequest()->getSession()->read('usr_msg_suc'); ?>
                    </div>
                     <?php $this->getRequest()->getSession()->delete('usr_msg_suc'); } ?>
                
                <?php if(!empty($this->getRequest()->getSession()->read('usr_msg_err'))){ ?>
                    <div class="alert alert-danger fade show" role="alert"><i class="fa fa-check-circle"></i> 
                        <?php echo $this->getRequest()->getSession()->read('usr_msg_err'); ?>
                    </div>
                <?php $this->getRequest()->getSession()->delete('usr_msg_err'); } ?>  
		        </div>
		    </div>
         </div>
	        <div class="main-card mb-3 card">
	          <div class="card-body">
	          	<?php echo $this->Form->create(null,array('type' => 'file' ,'enctype' => 'multipart/form-data','id'=>'generate_ticket')); ?>
	          	 <div>
				    <div class="form-row">
						    <div class="form-check form-check-inline radio-button">
								  <input class="form-check-input" type="radio" name="ticket_type" id="rms"<?php echo ($ticketDetails['ticket_type']=='RMS')?'checked':'' ?> value="RMS">
								  <label class="form-check-label btn btn-outline-primary" for="rms">
								    RMS
								  </label>
							 </div>
							 <div class="form-check form-check-inline radio-button">
								  <input class="form-check-input" type="radio" id="mpas"<?php echo ($ticketDetails['ticket_type']=='MPAS')?'checked':'' ?> name="ticket_type" value="MPAS">
								  <label class="form-check-label btn btn-outline-primary" for="mpas">
								    MPAS
								  </label>
							  </div>
			       </div>
			       <div class="form-row mt-4 d-none" id="issued-raise-at">
					         <div class="col-md-6 mb-3">
								  <div>
									  <label for="issued-raise-at">Issue Raise By <span class="text-danger">*</span></label>  <span id="issued_raise_at_error" class="text-danger"></span>
										<select id="issued_raise_at" name="issued-raise-at" class="form-control">
										  <option value="none" selected disabled>--select issue--</option>
										  <option value="Applicant" <?php echo ($ticketDetails['issued_raise_at']=='Applicant')?'selected':'' ?>>Applicant</option>
										  <option value="IBM" <?php echo ($ticketDetails['issued_raise_at']=='IBM')?'selected':'' ?>>IBM</option>
										</select>
										<div id="issued_raise_at_error" class="text-danger"></div>
								  </div>
							  </div>
							  <div class="col-md-6 mb-3">
								  <div id="issued-type">
									  <label for="issued_type">Issue Type <span class="text-danger">*</span></label>
									  <span id="issued_type_error" class="text-danger"></span>
										<select id="issued_type" name="issued_type"class="form-control">
										  <option value="none" selected disabled>--select issue type--</option>
										  <option value="Form Related" <?php echo ($ticketDetails['issued_type']=='Form Related')?'selected':'' ?>>Form Related</option>
										  <option value="Change Request" <?php echo ($ticketDetails['issued_type']=='Change Request')?'selected':'' ?>>Change Request</option>
										  <option value="Others" <?php echo ($ticketDetails['issued_type']=='Others')?'selected':'' ?>>Others</option>
										</select>
								  </div>
							 </div>
							 
				    </div>
				    <div class="form-row mt-4 d-none" id="form-submission">
                        
								<div class="form-check form-check-inline radio-button">
								  <input class="form-check-input" type="radio" id="form_f" <?php echo ($ticketDetails['form_submission']=='Form F')?'checked':'' ?> name="form_submission" value="Form F">
								  <label class="form-check-label btn btn-outline-primary" for="form_f">
								    Form F
								  </label>
								</div>
								<div class="form-check form-check-inline radio-button">
								  <input class="form-check-input" type="radio" id="form_l" <?php echo ($ticketDetails['form_submission']=='Form L')?'checked':'' ?> name="form_submission" value="Form L">
								  <label class="form-check-label btn btn-outline-primary" for="form_l">
								    Form L
								  </label>
								</div>
							
							 
								<div class="form-check form-check-inline radio-button">
								  <input class="form-check-input" type="radio" id="form_g" <?php echo ($ticketDetails['form_submission']=='Form G')?'checked':'' ?> name="form_submission" value="Form G">
								  <label class="form-check-label btn btn-outline-primary" for="form_g">
								    Form G
								  </label>
								</div>
								<div class="form-check form-check-inline radio-button">
								  <input class="form-check-input" type="radio" id="form_n" <?php echo ($ticketDetails['form_submission']=='Form M')?'checked':'' ?> name="form_submission" value="Form M">
								  <label class="form-check-label btn btn-outline-primary" for="form_n">
								    Form M
								  </label>
								</div>
							  
                 </div>
                 
                   <div class=" mt-4 d-none" id='show-form-submission'>
                    <div class="form-row">

                    	   <div class="col-md-4 mb-3 d-none" id="form-type-monthly">
                   			   <label>Return Month</label>                    
		                       <?php echo $this->Form->control('return_month', array('type' => 'month','class'=>'form-control','id'=>'return_month','value'=>$ticketDetails['return_month'],'placeholder'=>'Select date','label'=>false)); ?>               
		                      <div id="return_date_error" class="text-danger"></div>
                		   </div>
                		   <div class="col-md-4 mb-3 d-none" id="form-type-annual">
                   			   <label>Return Year</label>                    
		                          
		                       <select id="return_year" name="return_year"class="form-control">
										  <option value="none" selected disabled>--select return year--</option>
										  <option value="2022-2023" <?php echo ($ticketDetails['return_year']=='2022-2023')?'selected':'' ?>>2022-2023</option>
										  
										</select>            
		                    <div id="return_date_error" class="text-danger"></div>
                		   </div>
                    	<div class="col-md-4 mb-3">
                   			 <label>Applicant Id</label>                    
		                    <?php echo $this->Form->control('applicant_id', array('type' => 'text','class'=>'form-control','id'=>'applicant_id','value'=>$ticketDetails['applicant_id'],'placeholder'=>'Enter Applicant Id','label'=>false)); ?>               
		                    <div id="applicant_id_error" class="text-danger"></div>
                		</div>

                       <div class="col-md-4 mb-3">
                             <label for="mine_code">Mine Code/Lease Code/User ID <span class="text-danger">*</span></label>
                               <?php echo $this->Form->control('mine_code', array('type' => 'text','class'=>'form-control','id'=>'mine_code','value'=>$ticketDetails['mine_code'],'placeholder'=>'Enter Mine Code','label'=>false)); ?>
			                  <div id="mine_code_error" class="text-danger"></div> 
                       </div>

                    </div>
                    <div class="form-row mt-4">
                    	<div class="col-md-12 mb-4">
                   			 <label for="description">Description</label>
                   			 <span id="description_error" class="text-danger"></span>                    
		                    <?php echo $this->Form->control('description', array('type' => 'textarea','class'=>'form-control','value'=>$ticketDetails['description'],'id'=>'description','maxlength' => 5000,'rows' => 6,'placeholder'=>'Enter Description','label'=>false)); ?>               
		                    
                		</div>
                    
                    </div>
                  </div>
                               
                   
                     <div class=" mt-4 d-none" id='show-form-others'>
                       <div class="form-row">

	                           <div class="col-md-6 mb-4">
	                   			 <label>Issue Type/Subject</label>
	                   			 <span id="other_issue_type_error" class="text-danger"></span>                    
			                    <?php echo $this->Form->control('other_issue_type', array('type' => 'textarea','class'=>'form-control','value'=>$ticketDetails['other_issue_type'],'id'=>'other_issue_type','placeholder'=>'Enter Issue Type/Subject ','rows'=>"5",'label'=>false)); ?>               
			                   </div>
                          
		                    	<div class="col-md-6 mb-4">
		                   			 <label>Description</label> 
		                   			 <span id="other_description_error" class="text-danger"></span>                   
				                    <?php echo $this->Form->control('other_description', array('type' => 'textarea','class'=>'form-control','value'=>$ticketDetails['description'],'id'=>'other_description','placeholder'=>'Enter Description','label'=>false)); ?>
		                		</div>
		                </div>
					</div>
                       
                       
                      <!--Start Add  more row -->
                      <div class=" mt-4 d-none" id='ticket-table'>
                      	<h5 class="alert alert-info alert-heading p-2 pl-3">Attach File Here</h5>
                      <table class="table table-bordered table-sm w-100 m-auto" id="ticketTable">
							    <thead class="bg-secondary text-white">
							        <tr>
							            <th class="text-center"><?php echo 'Sr.No.'; ?></th>
							            <th class="text-center"><?php echo 'File Upload'; ?></th>
							            <th class="text-center" colspan="2"><?php echo 'Description'; ?></th>
							            
							        </tr>
							    </thead>
							    <tbody>
							   <?php if ($flag == 'add') { ?>
                                
                                <tr id="rw-1">
							            	<td class="text-center srno">1</td>
							                <td>
							                	  <?php echo $this->Form->control('add_more_attachment[]', array('type' => 'file','class'=>'form-control add_attachment','id'=>'add_more_attachment','multiple' => true,'label'=>false)); ?>
							                	  
							                    <div class="err_cv"></div>
							                </td>
							                <td>

							                   <?php echo $this->Form->control('add_more_description[]',array('type' =>'textarea','class'=>'form-control add_attachment','id'=>'add_more_description','rows'=>'2','placeholder'=>'Enter Description','label'=>false)); ?> 
							                    <div class="err_cv"></div>
							                </td>
							                <td>
                                       <?php echo $this->Form->button('<i class="fa fa-times"></i>', array('type' => 'button', 'escapeTitle' => false, 'class' => 'btn btn-sm rem_btn', 'disabled' => 'true')); ?>
                                     </td>
							                
							            </tr>
                               
                               <?php unset($flag); }else{ ?>
							    	    <?php
                                 
                                 $add_more_attachment = isset($ticketDetails['add_more_attachment']) ? explode(",", $ticketDetails['add_more_attachment']) : [];
                                 $add_more_description = isset($ticketDetails['add_more_description']) ? explode(",", $ticketDetails['add_more_description']) : [];

                                

                                 $count = count($add_more_attachment);
                                 if ($count > 0 && !empty($add_more_attachment[0])) {
                                ?>
							          <?php for ($i = 0; $i < $count; $i++): ?>
							            <tr id="rw-<?php echo $i + 1 ?>">
							            	<td class="text-center srno"><?php echo $i + 1 ?></td>
							                <td>
							                	  <?php echo $this->Form->control('add_more_attachment_name[]', array('type' => 'hidden','class'=>'form-control add_attachment','id'=>'add_more_attachment','multiple' => true,'label'=>false,'value'=>$add_more_attachment[$i])); ?>
							                	  
							                	  <div class="token"><a href="/webroot<?= $add_more_attachment[$i]; ?>" target="_blank"><i class="fa fa-file-pdf text-danger btn imgSize"></i>Preview</a>
							                	  </div>
							                    
							                    <div class="err_cv"></div>
							                </td>
							                <td>

							                   <?php echo $this->Form->control('add_more_description[]',array('type' =>'textarea','class'=>'form-control add_attachment','id'=>'add_more_description','rows'=>'2','maxlength'=>'10000','value'=>$add_more_description[$i],'placeholder'=>'Enter Description','label'=>false)); ?> 
							                    <div class="err_cv"></div>
							                </td>
							                <td>
												<?php echo $this->Form->button('<i class="fa fa-times"></i>', array('type' => 'button', 'escapeTitle' => false, 'class' => 'btn btn-sm rem_btn', 'disabled' => 'false')); ?>
											</td>
							                
							            </tr>
							          <?php endfor;} else{ ?>
                                         
							          	<tr id="rw-1">
							            	<td class="text-center srno">1</td>
							                <td>
							                	  <?php echo $this->Form->control('add_more_attachment[]', array('type' => 'file','class'=>'form-control add_attachment','id'=>'add_more_attachment','multiple' => true,'label'=>false)); ?>
							                	  
							                    <div class="err_cv"></div>
							                </td>
							                <td>

							                   <?php echo $this->Form->control('add_more_description[]',array('type' =>'textarea','class'=>'form-control add_attachment','id'=>'add_more_description','rows'=>'2','placeholder'=>'Enter Description','label'=>false)); ?> 
							                    <div class="err_cv"></div>
							                </td>
							                <td>
												<?php echo $this->Form->button('<i class="fa fa-times"></i>', array('type' => 'button', 'escapeTitle' => false, 'class' => 'btn btn-sm rem_btn', 'disabled' => 'true')); ?>
											</td>
							                
							            </tr>
							          <?php }} ?>
							    </tbody>
							    <thead>
							        <tr>
							            <th colspan="4">
							                <?php echo $this->Form->button('<i class="fa fa-plus"></i> Add more', array('type' => 'button', 'escapeTitle' => false, 'class' => 'btn btn-info btn-sm', 'id' => 'add_more_btn')); ?>
							            </th>
							        </tr>
							    </thead>
							</table>
						</div>
							  	<!--End Add  more row -->


                      <hr>

            <div class="form-row">
                 
               <?php if ($buttonlabel == 'Save') { ?>
                 
                  <button type="reset" class="btn btn-info mr-2 font-weight-bold">Reset</button>   
             
               <?php } ?>            
               
                <?php echo $this->Form->submit($buttonlabel, array('name'=>'save','class'=>'form-control btn btn-success pl-4 pr-4 font-weight-bold','id'=>'btnsave','label'=>false)); ?>
                 
                
                
                <?php echo $this->Html->link('Cancel', '/mms/list-ticket',array('escapeTitle'=>false,'class'=>'btn btn-secondary font-weight-bold pl-4 pr-4 ml-2')); 
                    
                ?>
                
            </div>   
           <?php if ($action == 'ReferenceTicket') { ?>
                  
               <?php echo $this->Form->control('reference_no', array('type'=>'hidden', 'value'=>$ticketDetails['token'])); ?>
             <?php } ?>

             <?php if ($buttonlabel == 'Update') { ?>
                  
               <?php echo $this->Form->control('token', array('type'=>'hidden','value'=>$ticketDetails['token'])); ?>
             <?php } ?>
        
        <?php $this->Form->end() ?>  	

                   	
		    </div>
          
	</div>

</div>
</div>
</div>


<?php echo $this->Html->script('mms/form_create_ticket.js?version='.$version); ?>
<?php echo $this->Html->script('mms/generate_ticket.js?version='.$version); ?>


