
<?php echo $this->Html->css('authhome'); ?> 

<div class="main-card card fcard mb-1 mt-n3">
    <div class="card-body">
        <div class="rows">
        	<h4 class="text-center font-weight-bold text_head"><img src="/webroot/writereaddata/IBM/logo/ticket_logo.png" class='logoSize'> Ticket Details</h4>
        </div>
        <!-- <div class="rows">
        	<h6 class="text-center font-weight-bold text-custom"><u>Token Number  :</u><label class="input text font-weight-bold  pr-4 ml-2"><u><//?php if(!empty($token_number)){echo ucwords($token_number);}else { echo "N/A";} ?></u></label></h6>
        </div> -->

       		<div class="clearfix">&nbsp;</div>
	        <div class="row col-md-12">
	        	<!-- <div class="clearfix col-md-1">&nbsp;</div> -->

	        		<div class="col-md-4">
	        		<!-- <h6 class="text-center font-weight-bold text-custom"><u>Status  :</u><label class="input text font-weight-bold  pr-4 ml-2"><u><//?php if(!empty($Ticketstatus)){echo ucwords($Ticketstatus);}else { echo "N/A";} ?></u></label></h6> -->
	        		<h6><button type="button" class="text-center btn btn-warning font-weight-bold font_12 mrleft">
					  Status <span class="badge badge-light font-weight-bold font_12 "><?php if(!empty($Ticketstatus)){echo ucwords($Ticketstatus);}else { echo "N/A";} ?></span>
						</button>
	        		</h6>
	        	</div>
	        	<div class="col-md-4">
	        		<h6 class="text-center font-weight-bold text-custom"><u>Token Number  :</u><label class="input text font-weight-bold  pr-4 ml-2"><u><?php if(!empty($token_number)){echo ucwords($token_number);}else { echo "N/A";} ?></u></label></h6>
	        	</div>
	        	<?php if($reference_no==''){ ?>
        	
	        	<?php } else { ?>
	        		<div class="col-md-4">
	        		<h6><a href="<?php echo $this->Url->build(['controller'=>'support-mod', 'action'=>'view_reference_fun', $reference_no,$ticket_record_id]); ?>" target="_blank" class="text-center font-weight-bold ">Previous Token Number : <label class="input text font-weight-bold  pr-4 ml-2"><u><?php if(!empty($reference_no)){echo $reference_no;}else { echo "N/A";} ?></u></label></a></h6>	
	        	</div>
	        	<?php } ?>
	        	
	        	<!-- <div class="clearfix col-md-2">&nbsp;</div> -->
	        </div>

	    </div>

    </div>

<div class="main-card mb-3 card ">
	<div class="card-body ">	     
        	
	          <div class="row"><!-- <div class="col-md-12 form-row"> -->
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
										<th>Issued Raised At</th>
										<td><?php if(!empty($issued_raise_at)){echo $issued_raise_at;}else { echo "N/A";} ?></td>
									</tr>

									<tr>
										<th>Issued Type </th>
										<td><?php if(!empty($issued_type)){echo $issued_type;}else { echo "N/A";} ?></td>
										<th>Form Submission </th>
										<td><?php if(!empty($form_submission)){echo $form_submission;}else { echo "N/A";} ?></td>
									</tr>
									
									<tr>
										<th>Form Type Monthly </th>
										<td><?php if(!empty($form_type_monthly)){echo $form_type_monthly;}else { echo "N/A";} ?></td>
										<th>Form Type Annual </th>
										<td><?php if(!empty($form_type_annual)){echo $form_type_annual;}else { echo "N/A";} ?></td>
									</tr>
									
									<tr>
										<th>Other Issue Type </th>
										<td><?php if(!empty($issue_category)){echo $issue_category;}else { echo "N/A";} ?></td>
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
          					<thead class="tablehead ">
								<tr>
									<th>Attachment</th>
									<th>File Description</th>
								</tr>
							</thead>
						<tbody>
						

	          			<?php 
	          			
	          			$i=1;
	          			
	          			if($getAttach[0]) { ?>

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


      						$filename = $getname;

      						// Remove the extension from the filename
      						$extension = pathinfo($filename, PATHINFO_EXTENSION);
							
							//FileName Without Extension
							$filenameWithoutExtension = pathinfo($filename, PATHINFO_FILENAME);

							// Split the filename into different parts using a specific pattern
							//$parts = preg_split('/(?<=\d)(?=[a-zA-Z])|(?<=[a-zA-Z])(?=\d)/', $filenameWithoutExtension);
							$parts = preg_split('/(?<=\d)(?=[a-zA-Z])|(?<=[a-zA-Z])(?=\d)/', $filename);

      						$splitfileLinkCount = count($parts);
							$getProperName = $parts[$splitfileLinkCount - 1];
      						//print_r($parts);exit;
      						//

							/*$alphanumericPart = $parts[0];
							$nonAlphanumericPart = $parts[1];
							echo "Alphanumeric Part: " . $alphanumericPart . "<br>";
							echo "Non-Alphanumeric Part: " . $nonAlphanumericPart . "<br>";
							echo "Extension: " . $extension;*/

	          						



	          				if($ext =='jpg' || $ext =='JPG' || $ext =='PNG' || $ext =='png' || $ext =='jpeg' || $ext =='JPEG')
	          				  { ?>
							<tr>
								<td>
									<a href="/webroot<?= $row; ?>" target="_blank"><i class="fa fa-file-image text-info btn imgSize"></i>
									</a><b>(<?php echo $i; ?>)</b>
									<a href="/webroot<?= $row; ?>" target="_blank"><?php if(!empty($getProperName)){echo $getProperName;}else { echo "N/A";} ?></a>
								</td>
								<td>
									<p class="justify"><b><?php if(!empty($getAttachDescript[$i-1])){echo $getAttachDescript[$i-1] ;}else { echo "N/A";} ?></b></p>
								</td>			
							</tr>		
	                        	
	          				<?php } elseif( $ext =='pdf' || $ext =='PDF' ){ ?>
	          				<tr>
	          					<td>

	          						<a href="/webroot<?= $row; ?>" target="_blank"><i class="fa fa-file-pdf text-danger btn imgSize"></i></a><b>(<?php echo $i; ?>)</b>
	          						<a href="/webroot<?= $row; ?>" target="_blank"><?php if(!empty($getProperName)){echo $getProperName;}else { echo "N/A";} ?></a>
	          					</td>
	          					<td>
	          						<p class="justify"><b><?php if(!empty($getAttachDescript[$i-1])){echo $getAttachDescript[$i-1] ;}else { echo "N/A";} ?></b></p>
	          					</td>
	                        </tr>
	    					<?php } elseif( $ext =='doc' || $ext =='DOC' ||  $ext =='docx'){ ?>

	          				<tr>
	          					<td>
	          						<a href="/webroot<?= $row; ?>" target="_blank"><i class="fa fa-file-pdf text-info btn imgSize"></i></a><b>(<?php echo $i; ?>)</b>
	          						<a href="/webroot<?= $row; ?>" target="_blank"><?php if(!empty($getProperName)){echo $getProperName;}else { echo "N/A";} ?></a>
	          					</td>
	          					<td>
	          						<p class="justify"><b><?php if(!empty($getAttachDescript[$i-1])){echo $getAttachDescript[$i-1] ;}else { echo "N/A";} ?></b></p>
	          					</td>
	                        </tr>
	                    	<?php } elseif($ext =='xls' || $ext =='xlsx'){ ?>

	          				<tr>
	          					<td>
	          						<a href="/webroot<?= $row; ?>" target="_blank"><i class="fa fa-file-excel text-success btn imgSize"></i></a><b>(<?php echo $i; ?>)</b>
	          						<a href="/webroot<?= $row; ?>" target="_blank"><?php if(!empty($getProperName)){echo $getProperName;}else { echo "N/A";} ?></a>
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
	          <div class="col-md-6">&nbsp;</div>

	               <div class="card-footer cardFooterBackground">
	               	<div class="col-md-1">&nbsp;</div>
	               	<div class="submit">
	               		<input type="hidden" name="ticket_record_id" id="ticket_record_id" value="<?php echo $ticket_record_id;?>">
	               		<input type="hidden" name="token_number"  id="token_number"  value="<?php echo $token_number;?>">
	               		<input type="hidden" name="support_team_id" id="support_team_id" value="<?php echo $support_team_id;?>">
	               		<input type="hidden" name="username" id="username" value="<?php echo $username;?>">
	               		<input type="submit" name="Taken" class="form-control btn btn-success pl-4 pr-4 font-weight-bold" id="taken_btn" value="Allocate">
	               	</div>
						<?php echo $this->Html->link('Back', '/support-mod/ticket-list',array('escapeTitle'=>false,'class'=>'btn btn-secondary font-weight-bold pl-4 pr-4 ml-2')); ?>
					</div>
		</div>
		
</div>
<?php echo $this->Html->script('support/support_page');?>



