
	<?php echo $this->Html->css('authhome'); ?> 
	<div class="main-card card fcard mb-1 mt-n3">
	     <div class="card-body">
	        <div class="rows">
        		<h4 class="text-center font-weight-bold text_head"><img src="/webroot/writereaddata/IBM/logo/ticket_logo.png" class='logoSize'> Ticket Details</h4>
        	</div>
	        <div class="clearfix">&nbsp;</div>
	        <div class="row col-md-12">
	        	<!-- <div class="clearfix col-md-1">&nbsp;</div> -->

	        	<div class="col-md-3">
	        		<!-- <h6 class="text-center font-weight-bold text-custom"><u>Status  :</u><label class="input text font-weight-bold  pr-4 ml-2"><u><//?php if(!empty($Ticketstatus)){echo ucwords($Ticketstatus);}else { echo "N/A";} ?></u></label></h6> -->

	        		<h6><button type="button" class="text-center btn btn-info font-weight-bold font_12 mrleft">
					  Status <span class="badge badge-light font-weight-bold font_12 "><?php if(!empty($Ticketstatus)){echo ucwords($Ticketstatus);}else { echo "N/A";} ?></span>
						</button>
	        		</h6>

	        	</div>
	        	<div class="col-md-3">
	        		<h6 class="text-center font-weight-bold text-custom"><u>Token Number  :</u><label class="input text font-weight-bold  pr-4 ml-2"><u><?php if(!empty($token_number)){echo ucwords($token_number);}else { echo "N/A";} ?></u></label></h6>
	        	</div>
	        	<?php if($reference_no==''){ ?>
        	
	        	<?php } else { ?>
	        		<div class="col-md-3">
	        		<h6><a href="<?php echo $this->Url->build(['controller'=>'support-mod', 'action'=>'view_reference_fun', $reference_no,$ticket_record_id]); ?>" target="_blank" class="text-center font-weight-bold ">Previous Token Number : <label class="input text font-weight-bold  pr-4 ml-2"><u><?php if(!empty($reference_no)){echo $reference_no;}else { echo "N/A";} ?></u></label></a></h6>	
	        		<!-- <//?php echo $this->Html->link('', array('controller' => 'support-mod', 'action'=>'fetch_closed_ticket_id', $token_number,$ticket_record_id),array('title'=>'Reference Number')); ?> -->
	        		<!-- <h6 class="text-center font-weight-bold text-custom "><u>Reference Number  :</u><label class="input text font-weight-bold  pr-4 ml-2"><u><//?php if(!empty($reference_no)){echo $reference_no;}else { echo "N/A";} ?></u></label></h6> -->
	        	</div>
	        	<?php } ?>
	        	<div class="col-md-3">
	        		<h6 class="text-center font-weight-bold text-custom"><u>Allocated To  :</u><label class="input text font-weight-bold  pr-4 ml-2"><u><?php if(!empty($support_firstname)){echo ucwords($support_firstname);}else { echo "N/A";} ?></u></label></h6>
	        	</div>
	        	<!-- <div class="clearfix col-md-2">&nbsp;</div> -->
	        </div>

	    </div>
	</div>
	<div class="main-card mb-3 card ">
		<div class="card-body ">
			<?php echo $this->Form->create(null,array('type' => 'file' ,'enctype' => 'multipart/form-data','id'=>'save_resolve_status','action'=>'../support-mod/save-resolve-status'));?>
			<!-- <form  id="save_resolve_status" action="../support-mod/save-resolve-status" method="POST" enctype="multipart/form-data"> -->
			<div class="row"><!-- <div class="col-md-12 form-row"> -->
	            	<div class="col-md-10 offset-1">
						<div id="current_menu_heading"></div>
						<div id="side_menu_list">
							<table class="table table-bordered table-info1">
								<thead class="tablehead text-center">
									<tr >
										<th colspan="4">Ticket Details</th>
					
									</tr>
								</thead>
								<tbody >
										<tr>
											<th>Ticket Type</th>
											<td><?php if(!empty($ticket_type)){echo $ticket_type;}else { echo "N/A";} ?></td>
											<th>Issued Raised At</th>
											<td><?php if(!empty($issued_raise_at)){echo $issued_raise_at;}else { echo "N/A";} ?></td>
										</tr>

										<tr>
											<th>Issued Type </th>
											<td><?php if(!empty($issued_type)){echo $form_submission;}else { echo "N/A";} ?></td>
											<th>Form Submission </th>
											<td><?php if(!empty($form_submission)){echo $form_submission;}else { echo "N/A";} ?></td>
										</tr>
										
										<tr>
											<th>Form Type Monthly </th>
											<td><?php if(!empty($form_type_monthly)){echo $form_type_annual;}else { echo "N/A";} ?></td>
											<th>Form Type Annual </th>
											<td><?php if(!empty($form_type_annual)){echo $form_type_annual;}else { echo "N/A";} ?></td>
										</tr>
										
										<tr>
											<th>Other Issue Type </th>
											<td><?php if(!empty($other_issue_type)){echo $other_issue_type;}else { echo "N/A";} ?></td>
											<th>Created Date </th>
											<td><?php echo date('d-m-Y h:i A',strtotime($created_at));?></td>
										</tr>
										<tr>
											<th>Description </th>
											<td colspan="3"><?php if(!empty($description)){echo $description ;}else { echo "N/A";} ?></td>
										</tr>
									
								</tbody>
							</table>
						</div>
						
					</div>
	            </div>
		          <div class="col-md-6">&nbsp;</div>
		           <div class="row">
		          	<div class="col-md-1">&nbsp;</div>
		          	<div class="col-md-10">
		          		<label>Attachment | File Description In Ticket<span class="cRed"></span></label>
		          		<div class='card-body borderClass'>

	          				<table class="table table-bordered table-info1">
	          					<thead class="tablehead">
									<tr>
										<th>Attachment</th>
										<th>File Description</th>
									</tr>
								</thead>
							<tbody>
							

		          			<?php $i=1; 

		          			if(count($getAttach) >= 1) { ?>

		          			<?php foreach($getAttach as $row)
		          			{	
		          				if(!empty($row))
		          				{
		          					$rowexplode = explode('.',$row);
		          					$ext =$rowexplode[1];

		          				}
		          				else
		          				{
			          				$ext='';
			          				$rowexplode='';
			          			}

		          				$rowexplode1=explode('/',$row);
		          				$splitLinkCount = count($rowexplode1);
								$getname = $rowexplode1[$splitLinkCount - 1];

		          				//echo"<pre>";print_r($getname);exit;
		          				if($ext =='jpg' || $ext =='JPG' || $ext =='PNG' || $ext =='png' || $ext =='jpeg' || $ext =='JPEG')
		          				  { ?>
								<tr>
									<td>
										<a href="/webroot<?= $row; ?>" target="_blank"><i class="fa fa-file-image text-info btn imgSize"></i>
										</a><b>(<?php echo $i; ?>)</b>
										<a href="/webroot<?= $row; ?>" target="_blank"><?php if(!empty($getname)){echo $getname;}else { echo "N/A";} ?></a>
									</td>
									<td>
										<p class="justify"><b><?php if(!empty($getAttachDescript[$i-1])){echo $getAttachDescript[$i-1] ;}else { echo "N/A";} ?>
									</b></p>
									</td>	
											
								</tr>		
		                        	
		          				<?php } elseif( $ext =='doc' || $ext =='pdf' || $ext =='DOC' || $ext =='PDF'){ ?>
		          				<tr>
		          					<td>
		          						<a href="/webroot<?= $row; ?>" target="_blank"><i class="fa fa-file-pdf text-danger btn imgSize"></i></a><b>(<?php echo $i; ?>)</b>
		          						<a href="/webroot<?= $row; ?>" target="_blank"><?php if(!empty($getname)){echo $getname;}else { echo "N/A";} ?></a>
		          					</td>
		          					<td>
		          						<p class="justify"><b><?php if(!empty($getAttachDescript[$i-1])){echo $getAttachDescript[$i-1] ;}else { echo "N/A";} ?></b></p>
		          					</td>
		                        </tr>
		    					<?php } ?>
		          				<?php $i++; }  ?>
		          				<?php } else { ?>
		          				<tr >
		          					<td colspan="2" class="text-center text-primary"><label>----- NOT AVAILABLE ATTACHMENT FILE & DESCRIPTION ----- </label></td>
		          				</tr>	
		          				<?php } ?>		
		          			</tbody>
							</table>
		          		</div>
		          	</div>
		          	<div class="col-md-1">&nbsp;</div>
		          </div>
		          <div class="clearfix">&nbsp;</div>

		          <div class="">
		          <!-- 	<//?php echo"<pre>";print_r($suppTeam_id);?>
		          	<//?php echo"<pre>";print_r($session_support_team_id);exit;?> -->
		          	<?php if($suppTeam_id == $session_support_team_id) {?>

		          	<div class="row" id="show_resolve_form">
	           			<div class="col-md-1">&nbsp;</div>
	                	<div class="col-md-10 mb-4">
	               			 <label>Issue Type</label>&nbsp;<span class="text-danger">*</span>                    
		                     <?php echo $this->Form->control('inpro_issue_type', array('type' => 'Select', 'options'=>$inproIssueTypes,'class'=>'form-control', 'empty'=>'Select', 'id'=>'inpro_issue_type','label'=>false)); ?>     
		                    <div id="issue_error" class="text-danger"></div>
	            		</div>
	             	</div>

	           		<div class="row" id="show_resolve_form">
	           			<div class="col-md-1">&nbsp;</div>
	                	<div class="col-md-10 mb-4">
	               			 <label>Reply/Description</label>&nbsp;<span class="text-danger">*</span>                    
		                    <?php echo $this->Form->control('description', array('type' => 'textarea','class'=>'form-control','style' => 'height:100px;','value'=>'','id'=>'description','placeholder'=>'Your reply type here....','label'=>false)); ?>               
		                    <div id="description_error" class="text-danger"></div>
	            		</div>
	             	</div>
	             	<!--===============================Start Add  more row ===============================-->
	             	<div class="row">
	             	<div class="col-md-1">&nbsp;</div>
					<div class="col-md-10 mb-4 " id='ticket-table'>
						<h5 class="alert alert-info alert-heading p-2 pl-3">Attach File Here</h5>
						<table class="table table-bordered table-sm w-100 m-auto" id="ticketTable">
							<thead class="bg-secondary text-white">
								<tr>
									<th class="text-center"><?php echo 'Sr.No.'; ?></th>
									<th class="text-center"><?php echo 'Description'; ?></th>
									<th class="text-center" colspan="2"><?php echo 'File Upload'; ?></th>

								</tr>
							</thead>
							<tbody class="items_table">
									<tr id="rw-1" class="item-row">
										<td class="text-center">1</td>
										<td>
											<?php echo $this->Form->control('add_more_attachment[]', array('type' => 'file','class'=>'form-control add_attachment row-attach','id'=>'add_more_attachment','multiple' => true,'label'=>false)); ?>

											<div class="err_cv"></div>
										</td>
										<td>

											<?php echo $this->Form->control('add_more_description[]',array('type' =>'textarea','class'=>'form-control add_attachment row-desc','id'=>'add_more_description','rows'=>'2','placeholder'=>'Enter Description','label'=>false)); ?> 
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->button('<i class="fa fa-times"></i>', array('type' => 'button', 'escapeTitle' => false, 'class' => 'btn btn-sm rem_btn', 'disabled' => 'true')); ?>
										</td>

									</tr>

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

	             	</div>
	             	</div>
	             	<div class="clearfix">&nbsp;</div>  	
	                <div class="card-footer cardFooterBackground">
	                	<div class="col-md-1">&nbsp;</div>
	                	<div class="submit">
	                		<input type="hidden" name="ticket_record_id" id="ticket_record_id" value="<?php echo $ticket_record_id;?>">
		               		<input type="hidden" name="token_number"  id="token_number"  value="<?php echo $token_number;?>">
		               		<input type="hidden" name="support_team_id" id="support_team_id" value="<?php echo $suppTeam_id;?>">
		               		<input type="hidden" name="username" id="username" value="<?php echo $support_firstname;?>">

	                		<input type="submit" name="finalResolve_btn" class="btn btn-success pl-4 pr-4 font-weight-bold" id="finalResolve_btn" value="Close Ticket" >

	                		<input type="button" name="release_btn" class="btn btn-dark pl-4 pr-4 font-weight-bold" id="release_btn" value="Release Ticket">
	                	</div>
	                	<?php echo $this->Html->link('Back', '/support-mod/ticket-list',array('escapeTitle'=>false,'class'=>'btn btn-info font-weight-bold pl-4 pr-4 ml-2')); ?>
	                </div>
	                <?php } else { ?>

	                	<div class="card-footer cardFooterBackground">
	                	<div class="col-md-1">&nbsp;</div>
	                	<?php echo $this->Html->link('Back', '/support-mod/ticket-list',array('escapeTitle'=>false,'class'=>'btn btn-info font-weight-bold pl-4 pr-4 ml-2')); ?>
	                </div>

	                <?php }  ?>
		           
		          
		          
		               	<!-- <div class="submit form-check form-check-inline">

						  <input class="form-check-input d-none" type="radio" id="resolve_btn" name="resolve_btn" value="Resolved" >
						  <label class="form-check-label btn btn-outline-primary" for="resolve_btn">
						    Reply</label>	
		               	</div> -->
		               	 
						
		     <!-- <//?php $this->Form->end() ?>  --> 	
		     </form>
			</div>
			
	</div>
	<?php echo $this->Html->script('support/support_page');?>



