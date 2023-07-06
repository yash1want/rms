
<?php echo $this->Html->css('authhome'); ?> 
<div class="main-card card fcard mb-1 mt-n3">
	     <div class="card-body">
	        <div class="rows">
	        	<h4 class="text-center font-weight-bold text-alternate"><u>Ticket Details</u></h4>
	        </div>
	        <div class="clearfix">&nbsp;</div>
	        <div class="row col-md-12">
	        	

	        	<div class="col-md-4">
	        		<h6 class="text-center font-weight-bold text-custom "><u>Status  :</u><label class="input text font-weight-bold  pr-4 ml-2"><u><?php if(!empty($Ticketstatus)){echo ucwords($Ticketstatus);}else { echo "N/A";} ?></u></label></h6>
	        	</div>
	        	<?php if ($Ticketstatus == 'Closed' && empty($ReferenceNo)) { ?>
	        	<div class="col-md-4">
	        		<h6 class="text-center font-weight-bold text-custom"><u>Create New Ticket  :</u><label class="input text font-weight-bold  pr-4 ml-2"><u><?php echo $this->Html->link('', array('controller' => 'mms', 'action'=>'ticket-create-with-reference', $id),array('class'=>'fa fa-plus btn btn-primary btn-sm ml-1','title'=>'Create New Ticket With This Reference')); ?></u></label></h6>
	        	</div>

	        	<?php } ?>
	        	
	        	<div class="col-md-4">
	        		<h6 class="text-center font-weight-bold text-custom"><u>Token Number  :</u><label class="input text font-weight-bold  pr-4 ml-2"><u><?php if(!empty($token_number)){echo ucwords($token_number);}else { echo "N/A";} ?></u></label></h6>
	        	</div>
	        	
	        </div>

	    </div>
</div>
<div class="main-card mb-3 card ">
	<div class="card-body">	     
        	
	          <div class="rows form-row">
            	<div class="col-md-10 offset-1">
					<div id="current_menu_heading"></div>
					<div id="side_menu_list ">
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
										<th>Issue Raised At</th>
										<td><?php if(!empty($issued_raise_at)){echo $issued_raise_at;}else { echo "N/A";} ?></td>
									</tr>

									<tr>
										<th>Issue Type </th>
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
	          		<label>Attachment | File Description By You<span class="cRed"></span></label>
	          		<div class='card-body borderClass'>

          				<table class="table table-bordered table-info1">
          					<thead class="tablehead">
								<tr>
									<th>Attachment</th>
									<th>File Description</th>
								</tr>
							</thead>
						<tbody>
						

	          			<?php 
	          			 
	          			$i=1;
	          			if(!empty($getAttach[0])) {?>
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

	          				if($ext =='jpg' || $ext =='JPG' || $ext =='PNG' || $ext =='png' || $ext =='jpeg' || $ext =='JPEG' || $ext =='docx' || $ext =='DOCX'|| $ext =='xls' || $ext =='xlsx')
	          				  { ?>
							<tr>
								<td>
									<a href="/webroot<?= $row; ?>" target="_blank"><i class="fa fa-file-image text-info btn imgSize"></i>
									</a><b>(<?php echo $i; ?>)</b>
									<a href="/webroot<?= $row; ?>" target="_blank"><?php if(!empty($getname)){echo $getname;}else { echo "N/A";} ?></a>
								</td>
								<td>
									<p class="justify"><b><?php if(!empty($getAttachDescript[$i-1])){echo $getAttachDescript[$i-1] ;}else { echo "N/A";} ?></b></p>
								</td>			
							</tr>		
	                        	
	          				<?php } elseif( $ext =='xls' || $ext =='xlsx' || $ext =='docx' || $ext =='pdf' || $ext =='DOCX' || $ext =='PDF'){ ?>
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
	          				
	          			<!-- </tbody> -->
						</table>
	          		</div>
	          	</div>
	          	<div class="col-md-1">&nbsp;</div>
	          </div>

	          <?php if($ticketStatus === 'Closed') { ?>
               <div class="col-md-1">&nbsp;</div>
               <div class="col-md-1">&nbsp;</div>
               <div class="row">
	          	<div class="col-md-1">&nbsp;</div>
	          	<div class="col-md-10">
	          		<label>Support Team Comment<span class="cRed"></span></label>
	          		<div class='card-body borderClass'>

          				<table class="table table-bordered table-info1">
          					<thead class="tablehead">
								<tr>
									<th>Comment</th>
									<th>Date</th>
								</tr>
							</thead>
						<tbody>
						    <tr >
	          					<td  class="text-center text-primary"><label><?php if(!empty($comment)){echo 
	          						$comment ;}else { echo "N/A";}?></label></td>
	          					<td  class="text-center text-primary"><?php if(!empty($commentDate)){echo date('d-m-Y h:i A',strtotime($commentDate));}else { echo "N/A";}?></td>
	          			    </tr>
	          			</tbody> 
						</table>
	          		</div>
	          	</div>
	          	<div class="col-md-1">&nbsp;</div>
	          </div>
               <div class="col-md-1">&nbsp;</div>
               <div class="col-md-1">&nbsp;</div>
	           <div class="row">
	          	<div class="col-md-1">&nbsp;</div>
	          	<div class="col-md-10">
	          		<label>Attachment | File Description By Support Team<span class="cRed"></span></label>
	          		<div class='card-body borderClass'>

          				<table class="table table-bordered table-info1">
          					<thead class="tablehead">
								<tr>
									<th>Attachment</th>
									<th>File Description</th>
								</tr>
							</thead>
						<tbody>
						

	          			<?php 
	          			 
	          			$i=1;
	          			if(!empty($getSupportAttach[0])) { ?>
	          				<?php foreach($getSupportAttach as $data)
	          				{
	          					if(!empty($data))
	          					{
	          						$dataexplode = explode('.',$data);
	          						$ext =$dataexplode[1];

	          					}
	          					else
	          					{
		          					$ext='';
		          					$dataexplode='';
		          				}

	          				$dataexplode1=explode('/',$data);
	          				$splitLinkCount = count($dataexplode1);
							$getAttachname = $dataexplode1[$splitLinkCount - 1];

	          				if($ext =='jpg' || $ext =='JPG' || $ext =='PNG' || $ext =='png' || $ext =='jpeg' || $ext =='JPEG')
	          				  { ?>
							<tr>
								<td>
									<a href="/webroot<?= $data; ?>" target="_blank"><i class="fa fa-file-image text-info btn imgSize"></i>
									</a><b>(<?php echo $i; ?>)</b>
									<a href="/webroot<?= $data; ?>" target="_blank"><?php if(!empty($getAttachname)){echo $getAttachname;}else { echo "N/A";} ?></a>
								</td>
								<td>
									<p class="justify"><b><?php if(!empty($getSupportDescript[$i-1])){echo $getSupportDescript[$i-1] ;}else { echo "N/A";} ?></b></p>
								</td>			
							</tr>		
	                        	
	          				<?php } elseif($ext =='xls' || $ext =='xlsx' || $ext =='doc' || $ext =='pdf' || $ext =='DOC' || $ext =='PDF'){ ?>
	          				<tr>
	          					<td>
	          						<a href="/webroot<?= $data; ?>" target="_blank"><i class="fa fa-file-pdf text-danger btn imgSize"></i></a><b>(<?php echo $i; ?>)</b>
	          						<a href="/webroot<?= $data; ?>" target="_blank"><?php if(!empty($getAttachname)){echo $getAttachname;}else { echo "N/A";} ?></a>
	          					</td>
	          					<td>
	          						<p class="justify"><b><?php if(!empty($getSupportDescript[$i-1])){echo $getSupportDescript[$i-1] ;}else { echo "N/A";} ?></b></p>
	          					</td>
	                        </tr>
	    					<?php } ?>
	          				<?php $i++; }  ?>
	          				<?php } else {  ?>
	          				<tr >
	          					<td colspan="2" class="text-center text-primary"><label>----- NOT AVAILABLE ATTACHMENT FILE & DESCRIPTION ----- </label></td>
	          				</tr>	
	          				<?php } ?>
	          				
	          			<!-- </tbody> -->
						</table>
	          		</div>
	          	</div>
	          	<div class="col-md-1">&nbsp;</div>
	          </div>
              <?php }?>
	          <div class="col-md-6">&nbsp;</div>

	               <div class="card-footer cardFooterBackground">
	               	<div class="col-md-10">&nbsp;</div>
	               	<div class="submit">
	               		<input type="hidden" name="ticket_record_id" id="ticket_record_id" value="<?php echo $ticket_record_id;?>">
	               		<input type="hidden" name="token_number"  id="token_number"  value="<?php echo $token_number;?>">
	               		<input type="hidden" name="support_team_id" id="support_team_id" value="<?php echo $support_team_id;?>">
	               		<input type="hidden" name="username" id="username" value="<?php echo $username;?>">
	               		
	               	</div>
						
						<?php echo $this->Html->link('Back', '/mms/list-ticket',array('escapeTitle'=>false,'class'=>'btn btn-secondary font-weight-bold pl-4 pr-4 ml-2')); ?>
					</div>
		</div>
		
</div>






