<?php echo $this->Html->css('authhome'); ?> 
<div class="alert alert-success fade show d-none_msg"  id="alert_success_msg"><i class="fa fa-check-circle"></i>&nbsp;Taken Record Updated Successfully.</div>
<!-- <div class="alert alert-success text-center" id="alert_error" style="display:none;">Taken Record Created Successfully.</div> -->

<!-- <//?php echo $this->Form->create(null , array('type'=>'file', 'enctype'=>'multipart/form-data','class'=>'form-group')); ?> 
<div  class="main-card card fcard mb-1 mt-n3">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12 pb-1">
				<h5 class="text-center font-weight-bold text-alternate pb-1"><//?php echo $page_title; ?></h5>
			</div>
		</div>	
		<div class="clearfix">&nbsp;</div>
		<div class="row">	
			<div class="col-md-2 pt-2">
				<div class="custom-radio custom-control">
					<input type="radio" id="rb_period" name="rb_period" value="period" checked>
					<label class="font-weight-bold">Applicant Id</label>				
				</div>		
			</div>
			<div class="col-md-2">
				<//?php echo $this->Form->control('r_period', array('type'=>'text', 'value'=>'','class'=>'form-control f-control search_f_control', 'id'=>'r_period', 'label'=>false)); ?>
			</div>		
			<div class="col-md-5 pl-5 pt-2">
				<input type="submit" class="btn btn-dark fbtn" name="f_search" value="View Details">		
			</div>
		</div>
	</div>
</div>
		
<//?php echo $this->Form->end(); ?> -->
<?php $ticket_type = $this->getRequest()->getSession()->read("ticket_type");
//print_r($ticket_type);exit;
?>

<div class="main-card card fcard mb-1 mt-n3">
	<div class="card-body pt-2 pb-3">
	
		<?php echo $this->Form->create(null , array('type'=>'file', 'enctype'=>'multipart/form-data','class'=>'form-group')); ?>
		
		<h5 class="text-center font-weight-bold text-alternate pb-1">
			<?php echo $page_title; ?>
		</h5>
		
			<?php echo $this->element('search_ticket_filter'); ?>
		
		
		<?php echo $this->Form->end(); ?>
	</div>
</div>

<div class="row p-0">	
	<div class="col-lg-12 col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
            	<h5 class="card-title">
					<!-- <//?php if($returnsData == 'filterDataTampared'){ ?><span class="text-danger">Invalid Search</span><//?php } ?> -->
				</h5>
                <table class="mb-0 table table-responsive d-table table-striped leaselist" id="list">
                    <thead class="bg-dark text-white text-center">
                    <tr >                    <!-- class="text-center" -->    
						<th>SR.NO</th>
						<th>Token Number</th>
						<th>Applicant Id</th>
						<?php if($ticket_type!='pending' && $ticket_type!='all') { ?>
						<th>Support Name</th>
						<?php }?>
                        <th>Module</th>
                        <th>Issue Raise By</th>
						<th>Issue Type</th>
						<th>Creating Date</th>
                        <!-- <th>Form Submission</th>
                        <th>Other Issue Type</th> -->
                       <!-- 	<//?php if($ticket_type!='resolve') { ?> -->
                        <th>Status</th>
                        <th>No.Of Days</th>
						<!-- <//?php }?> -->
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    	<!-- INPROCESS LIST -->
						
						<?php   if($returnsData != 'filterDataTampared') {
							$sr=1;
						
							if(isset($_GET['debug'])) { echo '<pre>'; print_r($returnsData); exit; }
							
							//print_r($returnsData);exit;
							foreach($returnsData as $row) {  
						?>

						<tr>                       
								<td><strong><?php echo $sr++; ?></strong></td>
								<td>
									<b><?php if(!empty($row['token'])){echo $row['token'];}else { echo "N/A";} ?></b>	
								</td>
								<td>
									<b><?php if(!empty($row['applicant_id'])){echo $row['applicant_id'];}else { echo "N/A";} ?></b>	
								</td>
								<?php if($ticket_type!='pending' && $ticket_type!='all') { ?>
								<td>
									<?php if(!empty($row['support_firstname'])){echo "<span class='badge badge-primary'>".ucfirst($row['support_firstname'])."</span>";}else { echo "<span class='badge badge-pill badge-secondary'>N/A</span>";} ?>	
								</td>
								<?php }?>
								<td>
									<?php if(!empty($row['ticket_type'])){echo $row['ticket_type'];}else { echo "N/A";} ?>	
								</td>
								<td>
									<?php if(!empty($row['issued_raise_at'])){echo $row['issued_raise_at'];}else { echo "N/A";} ?>
								</td>
								<td>
									<?php if(!empty($row['issued_type'])){echo $row['issued_type']."-".$row['form_submission'];}else { echo "N/A";} ?>
								</td>
								<td>
									<?php echo date("d-m-Y", strtotime($row['created_at']));?>
									<?php

										//-- Calculate Day Count --
									
										$oldDate = date("d-m-Y", strtotime($row['created_at']));
										$currentDate = date('d-m-Y');
										$replyDate = date("d-m-Y", strtotime($row['reply_date']));

										$datetime1 = new DateTime($oldDate);
										//$datetime2 = new DateTime($replyDate);
										if($row['status']=='Closed')
										{
											$datetime2 = new DateTime($replyDate);
											
										}else
										{
											$datetime2 = new DateTime($currentDate);
										}
										$interval = $datetime1->diff($datetime2);

										$count = $interval->days;
										//echo $count;
									?>
								</td>
								
								<td>
									<?php 
									if($row['status']=='Pending')
									{
                    					echo "<span class='btn btn-warning btn-sm ml-1 font-weight-bold fixsize'>".ucfirst($row['status'])."</span>";
                    				}
                    				elseif($row['status']=='Inprocess')
                    				{
                    					echo "<span class='btn btn-info btn-sm ml-1 font-weight-bold fixsize'>".ucfirst($row['status'])."</span>";
                    				}
                    				else
                    				{
                    					echo "<span class='btn btn-success btn-sm ml-1 font-weight-bold fixsize'>".ucfirst($row['status'])."</span>";
                    				}
                    				?>
                    			</td>
                    			<td>
                    				<!-- Showing Day Count -->
									<!-- <//?php if(!empty($count)){echo $count;}else { echo "N/A";} ?> -->
									<?php 

										if($row['status']=='Pending')
										{
	                    					echo "<h6><span class='badge badge-pill badge-dark font-weight-bold'>".$count."</span></h6>";
	                    					/*echo "<h6  class='btn btn-dark font-weight-bold'>Application Pending From<span class='badge badge-pill badge-light'>".$count."</span>&nbsp; days</h6>";*/
/*
	                    					echo "<h6  class='btn btn-dark font-weight-bold'><span class='badge badge-pill badge-light'>".$count."</span></h6>";*/
	                    				}
	                    				elseif($row['status']=='Inprocess')
	                    				{
	                    					echo "<h6><span class='badge badge-pill badge-dark font-weight-bold'>".$count."</span></h6>";
	                    					/*echo "<h6  class='btn btn-dark font-weight-bold'>Application Inprocess From<span class='badge badge-pill badge-light'>".$count."</span>&nbsp; days</h6>";*/
	                    					/*echo "<h6  class='btn btn-dark font-weight-bold'><span class='badge badge-pill badge-light'>".$count."</span></h6>";
*/
	                    				}
	                    				elseif($row['status']=='Closed')
	                    				{
	                    					echo "<h6><span class='badge badge-pill badge-dark font-weight-bold'>".$count."</span></h6>";
	                    					/*echo "<h6  class='btn btn-dark font-weight-bold'>Application Closed From<span class='badge badge-pill badge-light'>".$count."</span>&nbsp; days</h6>";*/
	                    					/*echo "<h6  class='btn btn-dark font-weight-bold'><span class='badge badge-pill badge-light'>".$count."</span></h6>";*/
	                    				}

									?>

								</td>
								<td>
									<?php 
									if($row['status']=='Inprocess'){
									?>
									<?php echo $this->Html->link('', array('controller' => 'support-mod', 'action'=>'fetch_resolve_id', $row['token'],$row['id']),array('class'=>'fa fa-edit btn btn-primary btn-sm ml-1','title'=>'View Ticket Details')); ?> 

									<?php } elseif($row['status']=='Pending') {?>

									<?php echo $this->Html->link('', array('controller' => 'support-mod', 'action'=>'fetch_file_id', $row['token'],$row['id']),array('class'=>'fa fa-edit btn btn-primary btn-sm ml-1','title'=>'View Ticket Details')); ?>
									<?php }  else { ?>
										
									<?php echo $this->Html->link('', array('controller' => 'support-mod', 'action'=>'fetch_closed_ticket_id', $row['token'],$row['id']),array('class'=>'fa fa-eye btn btn-primary btn-sm ml-1','title'=>'View Ticket Details')); ?>
									<?php }   ?>

								</td>	
							</tr>

						<?php  } } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Html->script('support/support_page');?>
