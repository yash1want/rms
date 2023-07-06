<?php echo $this->Form->create(null , array('type'=>'file', 'enctype'=>'multipart/form-data','class'=>'form-group')); ?>
<div  class="main-card card fcard mb-1 mt-n3">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12 pb-1">
				<h5 class="text-center font-weight-bold text-alternate pb-1"><?php echo $page_title; ?></h5>
			</div>
		</div>		
		<div class="row">	
			<div class="col-md-2 pt-2">
				<div class="custom-radio custom-control">
					<input type="radio" id="rb_period" name="rb_period" value="period" checked>
					<label class="font-weight-bold">Applicant Id</label>				
				</div>		
			</div>
			<div class="col-md-2">
				<?php echo $this->Form->control('r_period', array('type'=>'text', 'class'=>'form-control f-control search_f_control', 'id'=>'r_period', 'label'=>false)); ?>
			</div>		
			<div class="col-md-5 pl-5 pt-2">
				<input type="submit" class="btn btn-dark fbtn" name="f_search" value="View Details">		
			</div>
		</div>
	</div>
</div>
<?php echo $this->Form->end(); ?>

<?php $ticket_type = $this->getRequest()->getSession()->read("ticket_type");
?>


<div class="row p-0">	
	<div class="col-lg-12 col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <table class="mb-0 table table-responsive d-table table-striped leaselist" id="list">
                    <thead class="bg-dark text-white">
                    <tr>                        
						<th>SR.NO</th>
						<th>Applicant Id</th>
						<th>Token Number</th>
                        <th>Ticket Type</th>
                        <th>Issue Raise At</th>
						<th>Issue Type</th>
                        <th>Form Submission</th>
                        <th>Other Issue Type</th>
                        <th>Status</th>
                       	<?php if($ticket_type!='resolve') { ?>
                        <th>Action</th>
						<?php }?>
                    </tr>
                    </thead>
                    <tbody>
                    	
						<?php
						$sr=1;
						//echo"<pre>";print_r($resolvelistTicket);exit;
						if($ticket_type=='inprocess')
						{
							if(!empty($inprocesslistTicket)){
							    foreach($inprocesslistTicket as $data){  ?>
								<tr>                       
									<td><?php echo $sr++; ?></td>
									<td><?php echo $data['applicant_id']; ?></td>
									<td><?php echo $data['token']; ?></td>
									<td><?php echo $data['ticket_type']; ?></td>
									<td><?php echo $data['issued_raise_at']; ?></td>
									<td><?php echo $data['issued_type']; ?></td>
									<td><?php echo $data['form_submission']; ?></td>
									<td><?php echo $data['other_issue_type']; ?></td>
									<td>
										<?php if($data['status'])
										{
                        					echo "<span class='btn btn-info btn-sm ml-1' font-weight-bold>".ucfirst($data['status'])."</span>";
                        				}
                        				?>
                        				</td>
									<td>
										<?php //echo $this->Html->link('<i class="fa fa-file-pdf text-danger"></i>', '/'.$data['withdraw_pdf_file'], array('class'=>'btn-shadow p-1', 'escapeTitle'=>false, 'title'=>'View Applicant PDF', 'target'=>'_blank'));

											//echo '<button type="button" class="btn btn-warning btn-sm ml-1 withdraw_btn" data-toggle="modal" data-target="#withdrawBox" lnm="'.$data['ticket_type'].'" appid="'.$data['applicant_id'].'"  mode="view" title="View Ticket">View</button>'; ?>

											<!-- <//?php echo $this->Html->link('', array('controller' => 'cms', 'action'=>'delete_uploaded_file', $single_file['id']),array('class'=>'fas fa-trash-alt delete_file','title'=>'Delete')); ?> -->
										
											<?php echo $this->Html->link('', array('controller' => 'support-mod', 'action'=>'fetch_resolve_id', $data['token'],$data['id']),array('class'=>'fa fa-eye btn btn-primary btn-sm ml-1','title'=>'View Ticket Details')); ?>  
									</td>	
								</tr>
						<?php } } } ?>
						<?php if($ticket_type=='pending') 
						{
									if(!empty($pendinglistTicket)){
									    foreach($pendinglistTicket as $data){  ?>
										<tr>
										<td><?php echo $sr++; ?></td>                       
										<td><?php echo $data['applicant_id']; ?></td>
										<td><?php echo $data['token']; ?></td>
										<td><?php echo $data['ticket_type']; ?></td>
										<td><?php echo $data['issued_raise_at']; ?></td>
										<td><?php echo $data['issued_type']; ?></td>
										<td><?php echo $data['form_submission']; ?></td>
										<td><?php echo $data['other_issue_type']; ?></td>
										<td>
											<?php if($data['status'])
											{
                        						echo "<span class='btn btn-warning btn-sm ml-1 font-weight-bold'>".ucfirst($data['status'])."</span>";
                        					}
                        					?>
										</td>
										<td>
											<?php //echo $this->Html->link('<i class="fa fa-file-pdf text-danger"></i>', '/'.$data['withdraw_pdf_file'], array('class'=>'btn-shadow p-1', 'escapeTitle'=>false, 'title'=>'View Applicant PDF', 'target'=>'_blank'));

												//echo '<button type="button" class="btn btn-warning btn-sm ml-1 withdraw_btn" data-toggle="modal" data-target="#withdrawBox" lnm="'.$data['ticket_type'].'" appid="'.$data['applicant_id'].'"  mode="view" title="View Ticket">View</button>'; ?>
												
											<?php echo $this->Html->link('', array('controller' => 'support-mod', 'action'=>'fetch_file_id', $data['token'],$data['id']),array('class'=>'fa fa-eye btn btn-primary btn-sm ml-1','title'=>'View Ticket Details')); ?>
											
										</td>		
										</tr>
								
						<?php } } } ?>
						<?php if($ticket_type=='resolve') 
						{
									if(!empty($resolvelistTicket)){
									    foreach($resolvelistTicket as $resdata){  ?>
										<tr>
											<td><?php echo $sr++; ?></td>                       
											<td><?php echo $resdata['applicant_id']; ?></td>
											<td><?php echo $resdata['token']; ?></td>
											<td><?php echo $resdata['ticket_type']; ?></td>
											<td><?php echo $resdata['issued_raise_at']; ?></td>
											<td><?php echo $resdata['issued_type']; ?></td>
											<td><?php echo $resdata['form_submission']; ?></td>
											<td><?php echo $resdata['other_issue_type']; ?></td>
											<td>
												<?php if($resdata['status'])
												{
	                        						echo "<span class='btn btn-success btn-sm ml-1 font-weight-bold'>".ucfirst($resdata['status'])."</span>";
	                        					}
	                        					?>	
											</td>
											
										</tr>
								
						<?php } } } ?>
							

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

