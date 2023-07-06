<?php ?>	
<?php echo $this->Form->create(null , array('type'=>'file', 'enctype'=>'multipart/form-data','class'=>'form-group')); ?>			
<div class="row mt-2">
	<div class="col-md-2 pl-5 pt-2">	
		<label class="font-weight-bold">Applicant Id</label>					
	</div>
	<div class="col-md-2">					
		<?php echo $this->Form->control('userid', array('type'=>'text', 'class'=>'form-control f-control search_f_control', 'id'=>'f_mine_code', 'label'=>false)); ?>
	</div>	
	<div class="col-md-5 pl-5 pt-2">
		<input type="submit" class="btn btn-dark fbtn" name="submit" value="Details">			
	</div>
</div>


<input type="hidden" name="uname" value=<?php echo $userid; ?> >
<input type="hidden" name="logid" value=<?php echo $logid; ?> >

<div class="main-card mb-3 card">
	<div class="card-body">		
		<div class="table-responsive">
			<table class="mb-0 table table-striped return_list_table" id="">
				<thead class="bg-dark text-white">
					<tr>
						<th>Applicant Id</th>
						<th>Status</th>
						<th>Date</th>
						<th>Email</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo $userid; ?></td>
						<td><?php echo $status; ?></td>
						<td><?php echo $update_date; ?></td>
						<td><?php echo base64_decode($email); ?></td>
						<td>
							<?php if($status == 'User Blocked'){ ?>
								<input type="submit" class="btn btn-dark fbtn" name="submit" value="Unblock">
							<?php } ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php echo $this->Form->end(); ?>