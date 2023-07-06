
<?php echo $this->Html->css('authhome'); ?> 
<div class="main-card card fcard mb-1 mt-n3">
    <div class="card-body">
        <div class="rows">
        	<h4 class="text-center font-weight-bold text-alternate">Ticket Details</h4>
        </div>
        <div class="rows">
        	<h6 class="text-center font-weight-bold text-alternate ">Token Number  :<label class="input text font-weight-bold  pr-4 ml-2"><?php echo $token_number;?></label></h6>
        </div>

    </div>
</div>
<div class="main-card mb-3 card ">
	<div class="card-body ">	     
        	<!-- <div class="row ">
	            	<div class="col-md-3 borderClassgray">
	            		<label>Ticket Type : <span class="cRed"></span></label><label class="input text ">&nbsp;<?php if(!empty($ticket_type)){echo $ticket_type;}else { echo "N/A";} ?></label>
	            	</div>
	            	<div class="col-md-3 borderClassgray">
	            		<label>Issued Raised At : <span class="cRed"></span></label><label class="input text">&nbsp;<?php if(!empty($issued_raise_at)){echo $issued_raise_at;}else { echo "N/A";} ?> </label>
	            	</div>
	            	<div class="col-md-3 borderClassgray">
	            		<label>Issued Type : <span class="cRed"></span></label><label class="input text">&nbsp;<?php if(!empty($issued_type)){echo $form_submission;}else { echo "N/A";} ?> </label>
	            	</div>
	            	<div class="col-md-3 borderClassgray">
	            		<label>Form Submission : <span class="cRed"></span></label><label class="input text">&nbsp;<?php if(!empty($form_submission)){echo $form_submission;}else { echo "N/A";} ?> </label>
	            	</div>
	          </div>
	           <div class="col-md-6">&nbsp;</div>
	          <div class="row ">
	            	<div class="col-md-3 borderClassgray	">
	            		<label>Form Type Monthly : <span class="cRed"></span></label><label class="input text ">&nbsp;<?php if(!empty($form_type_monthly)){echo $form_type_annual;}else { echo "N/A";} ?> </label>
	            	</div>
	            	<div class="col-md-3 borderClassgray	">
	            		<label>Form Type Annual : <span class="cRed"></span></label><label class="input text">&nbsp;<?php if(!empty($form_type_annual)){echo $form_type_annual;}else { echo "N/A";} ?> </label>
	            	</div>
	            	<div class="col-md-3 borderClassgray	">
	            		<label>Other Issue Type : <span class="cRed"></span></label><label class="input text">&nbsp;<?php if(!empty($other_issue_type)){echo $other_issue_type;}else { echo "N/A";} ?> </label>
	            	</div>
	            	<div class="col-md-3 borderClassgray	">
	            		<label>Created Date : <span class="cRed"></span></label><label class="input text">&nbsp; <?php echo date('d-m-Y h:i A',strtotime($created_at));?></label>
	            	</div>
	          </div> -->

	          <div class="col-md-12 form-row">
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
	          		<label>Attachment <span class="cRed"></span></label>
	          		<div class='card-body borderClass'>
	          			
	          			<?php $i=1; foreach($getAttach as $row){
	          				$rowexplode = explode('.',$row);
	          				$ext =$rowexplode[1];

	          				$rowexplode=explode('/',$row);
	          				$splitLinkCount = count($rowexplode);
							$getname = $rowexplode[$splitLinkCount - 1];
	          				//echo"<pre>";print_r($getname);exit;

	          				if($ext =='jpg' || $ext =='JPG' || $ext =='PNG' || $ext =='png' || $ext =='jpeg' || $ext =='JPEG')
	          				  { ?>
							<tr>
								<?php 

								//echo $this->Html->link('<i class="fa fa-file-image text-dark"></i>', '/'.'/webroot'.$row, array('class'=>'btn imgSize','target'=>'_blank','escape'=>false)); ?>
								
								<a href="/webroot<?= $row; ?>" target="_blank"><i class="fa fa-file-image text-info btn imgSize"></i></a>
	                            <th scope="row"><b>(<?php echo $i; ?>)</b></th>
								<a href="/webroot<?= $row; ?>" target="_blank"><?php echo $getname; ?></a>
	                            <!-- <th scope="row"><b><//?php echo $getname; ?></b></th> -->
	                        </tr>	
	          				<?php } elseif( $ext =='doc' || $ext =='pdf' || $ext =='DOC' || $ext =='PDF'){ ?>
	          				<tr>
	          					<!-- <//?php echo $this->Html->link('<i class="fa fa-file-pdf text-danger"></i>', '/'.'/webroot.$row, array('class'=>'btn imgSize','target'=>'_blank','escape'=>false)); ?> -->

	          					<a href="/webroot<?= $row; ?>" target="_blank"><i class="fa fa-file-pdf text-danger btn imgSize"></i></a>
	                            <th scope="row"><b>(<?php echo $i; ?>)</b></th>
	          					<a href="/webroot<?= $row; ?>" target="_blank"><?php echo $getname; ?></a>
	          				

	                            <!-- <th scope="row"><b><//?php echo $getname; ?></b></th> -->
	                        </tr>
	    					<?php } ?>
	          			<?php $i++; } ?>
	          		</div>
	          	</div>
	          	<div class="col-md-1">&nbsp;</div>
	          </div>
	          <div class="col-md-6">&nbsp;</div>

	               <div class="card-footer cardFooterBackground">
	               	<div class="submit">
	               		<input type="hidden" name="ticket_record_id" id="ticket_record_id" value="<?php echo $ticket_record_id;?>">
	               		<input type="hidden" name="token_number"  id="token_number"  value="<?php echo $token_number;?>">
	               		<input type="hidden" name="support_team_id" id="support_team_id" value="<?php echo $support_team_id;?>">
	               		<input type="hidden" name="username" id="username" value="<?php echo $username;?>">
	               		<input type="submit" name="Taken" class="form-control btn btn-success pl-4 pr-4 font-weight-bold" id="taken_btn" value="Taken">
	               	</div>
						
						<!-- <//?php echo $this->Form->submit('Taken', array('name'=>'taken','class'=>'form-control btn btn-success pl-4 pr-4 font-weight-bold','id'=>'taken_btn','label'=>false)); ?> -->

						<?php echo $this->Html->link('Back', '/support-mod/ticket-list',array('escapeTitle'=>false,'class'=>'btn btn-secondary font-weight-bold pl-4 pr-4 ml-2')); ?>
					</div>
		</div>
		
</div>
<?php echo $this->Html->script('support/support_page');?>



