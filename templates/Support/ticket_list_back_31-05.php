<?php echo $this->Html->css('authhome'); ?> 
<div class="alert alert-success fade show d-none_msg"  id="alert_success_msg"><i class="fa fa-check-circle"></i>&nbsp;Taken Record Updated Successfully.</div>
<!-- <//?php echo $this->Form->create(null , array('type'=>'file', 'enctype'=>'multipart/form-data','class'=>'form-group')); ?> -->
<!-- <div class="alert alert-success text-center" id="alert_error" style="display:none;">Taken Record Created Successfully.</div> -->
<div  class="main-card card fcard mb-1 mt-n3">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12 pb-1">
				<h5 class="text-center font-weight-bold text-alternate pb-1"><?php echo $page_title; ?></h5>
				<!-- <//?php if($title=="Pending"){?>	
				<h5 class="text-center"><button type="button" class="text-center btn btn-warning font-weight-bold font_17 borderClassgray">
					 <span class="badge badge-light font-weight-bold font_17 borderClassgray"><//?php echo $page_title; ?></span>
					</button>
				</h5>
				<//?php } elseif($title=="Inprocess"){?>
				<h5 class="text-center"><button type="button" class="text-center btn btn-info font-weight-bold font_17 borderClassgray">
				 <span class="badge badge-light font-weight-bold font_17 "><//?php echo $page_title; ?></span>
				</button>
				</h5>
				<//?php } elseif($title=="Resolve"){?>
				<h5 class="text-center"><button type="button" class="text-center btn btn-success font-weight-bold font_17 borderClassgray">
				 <span class="badge badge-light font-weight-bold font_17 "><//?php echo $page_title; ?></span>
				</button>
				</h5>
				<//?php } else {?>	
				<h3 class="text-center"><button type="button" class="text-center btn btn-secondary font-weight-bold font_17 borderClassgray">
				 <span class="badge badge-light font-weight-bold font_17 "><//?php echo $page_title; ?></span>
				</button>
				</h3>
				<//?php } ?>	 -->
			</div>
		</div>	
		<div class="clearfix">&nbsp;</div>
		<!-- <//?= $this->Form->create(null, ['id' => 'search-form', 'url' => ['controller' => 'supportmod', 'action' => 'search']]) ?> -->
		<?= $this->Form->create(null, ['id' => 'search-form']) ?>
		<div class="row">
			<!-- <div class="col-md-3">
				<label class="font-weight-bold">Applicant Id</label>	
			</div> -->
			<div class="col-md-3 alignRight pt-2">
				<label class="font-weight-bold">Required Parameter Search :</label>
			</div>
			<div class="col-md-6 ">
    			<?= $this->Form->input('query', ['label' => 'Search','class'=>'form-control fa fa-search','placeholder'=>'All parameter search here..']) ?>
				<!-- <label class="font-weight-bold">Search here..</label>	 -->
			</div>
			<div class="col-md-3"></div>
		</div>
		<?= $this->Form->end() ?>
		<!-- <div class="row">	
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
		</div> -->

	</div>
</div>
<!-- <//?php echo $this->Form->end(); ?> -->

<?php $ticket_type = $this->getRequest()->getSession()->read("ticket_type");
//print_r($ticket_type);exit;
?>


<div class="row p-0">	
	<div class="col-lg-12 col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
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
                        <!-- <th>Form Submission</th>
                        <th>Other Issue Type</th> -->
                       	<?php if($ticket_type!='resolve') { ?>
                        <th>Status</th>
						<?php }?>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    	
						<?php
						$sr=1;
						//echo"<pre>";print_r($resolvelistTicket);exit;
						if($ticket_type=='inprocess')
						{
							if(!empty($inprocesslistTicket)){
							    foreach($inprocesslistTicket as $data){  ?>
								<tr>                       
									<td><strong><?php echo $sr++; ?></strong></td>
									<td>
										<?php if(!empty($data['token'])){echo $data['token'];}else { echo "N/A";} ?>	
									</td>
									<td>
										<?php if(!empty($data['applicant_id'])){echo $data['applicant_id'];}else { echo "N/A";} ?>	
									</td>
									<td>
										<?php if(!empty($data['support_firstname'])){echo "<span class='badge badge-primary'>".ucfirst($data['support_firstname'])."</span>";}else { echo "<span class='badge badge-pill badge-secondary'>N/A</span>";} ?>	
									</td>
									<td>
										<?php if(!empty($data['ticket_type'])){echo $data['ticket_type'];}else { echo "N/A";} ?>	
									</td>
									<td>
										<?php if(!empty($data['issued_raise_at'])){echo $data['issued_raise_at'];}else { echo "N/A";} ?>
									</td>
									<td>
										<?php if(!empty($data['issued_type'])){echo $data['issued_type']."-".$data['form_submission'];}else { echo "N/A";} ?>
									</td>
									
									<td>
										<?php if($data['status'])
										{
                        					echo "<span class='btn btn-info btn-sm ml-1 font-weight-bold' >".ucfirst($data['status'])."</span>";
                        				}
                        				?>
                        				</td>
									<td>
										
										<?php echo $this->Html->link('', array('controller' => 'support-mod', 'action'=>'fetch_resolve_id', $data['token'],$data['id']),array('class'=>'fa fa-edit btn btn-primary btn-sm ml-1','title'=>'View Ticket Details')); ?>  
									</td>	
								</tr>
						<?php } } } ?>
							<!-- <div id="search-results">
							    <//?php if (!empty($results)): ?>
							        <h2>Search Results</h2>
							        <//?php foreach ($results as $result): ?>
							            <p><//?= h($result->title) ?></p>
							            <p><//?= h($result->description) ?></p>
							        <//?php endforeach; ?>
							    <//?php endif; ?>
							</div> -->
						
						<?php if($ticket_type=='pending') 
						{
									if(!empty($pendinglistTicket)){
									    foreach($pendinglistTicket as $data){  ?>
										<tr>
										<td><strong><?php echo $sr++; ?></strong></td>                  
										<td>
											<?php if(!empty($data['token'])){echo $data['token'];}else { echo "N/A";} ?>	
										</td>
										<td>
											<?php if(!empty($data['applicant_id'])){echo $data['applicant_id'];}else { echo "N/A";} ?>	
										</td>
										<td>
											<?php if(!empty($data['ticket_type'])){echo $data['ticket_type'];}else { echo "N/A";} ?>	
										</td>
										<td>
											<?php if(!empty($data['issued_raise_at'])){echo $data['issued_raise_at'];}else { echo "N/A";} ?>
										</td>
										<td>
											<?php if(!empty($data['issued_type'])){echo $data['issued_type']."-".$data['form_submission'];}else { echo "N/A";} ?>
										</td>
										
										<td>
											<?php if($data['status'])
											{
                        						echo "<span class='btn btn-warning btn-sm ml-1 font-weight-bold'>".ucfirst($data['status'])."</span>";
                        					}
                        					?>
										</td>
										<td>
												
											<?php echo $this->Html->link('', array('controller' => 'support-mod', 'action'=>'fetch_file_id', $data['token'],$data['id']),array('class'=>'fa fa-edit btn btn-primary btn-sm ml-1','title'=>'View Ticket Details')); ?>
											
										</td>		
										</tr>
								
						<?php } } } ?>
						<?php if($ticket_type=='resolve') 
						{
									if(!empty($resolvelistTicket)){
									    foreach($resolvelistTicket as $resdata){  ?>
										<tr>
											<td><strong><?php echo $sr++; ?></strong></td>                     
											<td>
												<?php if(!empty($resdata['token'])){echo $resdata['token'];}else { echo "N/A";} ?>	
											</td>
											<td>
												<?php if(!empty($resdata['applicant_id'])){echo $resdata['applicant_id'];}else { echo "N/A";} ?>	
											</td>
											<td>
											<?php if(!empty($resdata['support_firstname'])){echo "<span class='badge badge-primary'>".ucfirst($resdata['support_firstname'])."</span>";}else { echo "<span class='badge badge-pill badge-secondary'>N/A</span>";} ?>	
											</td>
											<td>
												<?php if(!empty($resdata['ticket_type'])){echo $resdata['ticket_type'];}else { echo "N/A";} ?>	
											</td>
											<td>
												<?php if(!empty($resdata['issued_raise_at'])){echo $resdata['issued_raise_at'];}else { echo "N/A";} ?>
											</td>
											<td>
												<?php if(!empty($resdata['issued_type'])){echo $resdata['issued_type']."-".$resdata['form_submission'];}else { echo "N/A";} ?>
											</td>
											
											<td>
												<?php echo $this->Html->link('', array('controller' => 'support-mod', 'action'=>'fetch_closed_ticket_id', $resdata['token'],$resdata['id']),array('class'=>'fa fa-eye btn btn-primary btn-sm ml-1','title'=>'View Ticket Details')); ?>
											</td>
											
										</tr>
								
						<?php } } } ?>

						<?php

						if($ticket_type=='all')
						{
							if(!empty($AllTicketList)){
							    foreach($AllTicketList as $data){  ?>
								<tr>                       
									<td><strong><?php echo $sr++; ?></strong></td>
									<td>
										<b><?php if(!empty($data['token'])){echo $data['token'];}else { echo "N/A";} ?></b>	
									</td>
									<td>
										<b><?php if(!empty($data['applicant_id'])){echo $data['applicant_id'];}else { echo "N/A";} ?></b>	
									</td>
									
									<!-- <td>
										<//?php if(!empty($data['support_firstname'])){echo "<span class='badge badge-primary'>".ucfirst($data['support_firstname'])."</span>";}else { echo "<span class='badge badge-pill badge-secondary'>N/A</span>";} ?>	
									</td> -->
									
									<td>
										<?php if(!empty($data['ticket_type'])){echo $data['ticket_type'];}else { echo "N/A";} ?>	
									</td>
									<td>
										<?php if(!empty($data['issued_raise_at'])){echo $data['issued_raise_at'];}else { echo "N/A";} ?>
									</td>
									<td>
										<?php if(!empty($data['issued_type'])){echo $data['issued_type']."-".$data['form_submission'];}else { echo "N/A";} ?>
									</td>
									
									<td>
										<?php 
										if($data['status']=='Pending')
										{
                        					echo "<span class='btn btn-warning btn-sm ml-1 font-weight-bold fixsize'>".ucfirst($data['status'])."</span>";
                        				}
                        				elseif($data['status']=='Inprocess')
                        				{
                        					echo "<span class='btn btn-info btn-sm ml-1 font-weight-bold fixsize'>".ucfirst($data['status'])."</span>";
                        				}
                        				else
                        				{
                        					echo "<span class='btn btn-success btn-sm ml-1 font-weight-bold fixsize'>".ucfirst($data['status'])."</span>";
                        				}
                        				?>
                        				</td>
									<td>
										<?php 
										if($data['status']=='Inprocess'){
										?>
										<?php echo $this->Html->link('', array('controller' => 'support-mod', 'action'=>'fetch_resolve_id', $data['token'],$data['id']),array('class'=>'fa fa-edit btn btn-primary btn-sm ml-1','title'=>'View Ticket Details')); ?> 

										<?php } elseif($data['status']=='Pending') {?>

										<?php echo $this->Html->link('', array('controller' => 'support-mod', 'action'=>'fetch_file_id', $data['token'],$data['id']),array('class'=>'fa fa-edit btn btn-primary btn-sm ml-1','title'=>'View Ticket Details')); ?>
										<?php }  else { ?>
											
										<?php echo $this->Html->link('', array('controller' => 'support-mod', 'action'=>'fetch_closed_ticket_id', $data['token'],$data['id']),array('class'=>'fa fa-eye btn btn-primary btn-sm ml-1','title'=>'View Ticket Details')); ?>
										<?php }   ?>

									</td>	
								</tr>
						<?php } } } ?>


							

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Html->script('support/support_page');?>
