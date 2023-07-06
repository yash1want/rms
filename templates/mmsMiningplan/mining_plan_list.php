<div class="main-card card fcard mb-1 mt-n3">
    <div class="card-body">
        <div class="rows">
        	<h4 class="text-center font-weight-bold text-alternate">MINING PLAN LIST</h4>
        </div>
        	<?php echo $this->Form->create(null, array('type' => 'file' ,'id'=>'search')); ?>
        <div class="form-row">
			<div class="col-md-4 mb-3 form-row">
		        <div class="col-md-3"><label>District</label></div>       
		        <div class="col-md-8"><?php echo $this->Form->control('district', array('type'=>'select', 'options'=>$district_list, 'label'=>false,'class'=>'form-control','empty'=>'--select--','value'=>$formData['district'])); ?>  </div>       
				        
			</div>
			<div class="col-md-3 mb-3 form-row">
		        <div class="col-md-3"><label>Year</label></div>       
		        <div class="col-md-8"><?php echo $this->Form->control('year', array('type'=>'select', 'options'=>$years, 'label'=>false,'class'=>'form-control','empty'=>'--select--','value'=>$formData['year'])); ?>  </div>       
				        
			</div>
			<div class="col-md-5 mb-3 form-row">
		        <div class="col-md-3"><label>Registration Code</label></div>       
		        <div class="col-md-8"><?php echo $this->Form->control('reg_no', array('type'=>'text', 'value'=>$formData['reg_no'], 'label'=>false,'class'=>'form-control','maxlength'=>'20')); ?>  </div>       
				        
			</div>
			<div class="col-md-4 mb-3 form-row">
		        <div class="col-md-3"><label>Mine Code</label></div>       
		        <div class="col-md-8"><?php echo $this->Form->control('mine_code', array('type'=>'text', 'value'=>$formData['mine_code'], 'label'=>false,'class'=>'form-control','maxlength'=>'20')); ?>  </div>       
				        
			</div>
			<div class="col-md-4 mb-3 form-row">
				<?php echo $this->Form->control('region', array('type'=>'hidden', 'value'=>$regionName, 'label'=>false,'class'=>'form-control','maxlength'=>'20')); ?>
				<div class="col-md-4">
				<?php echo $this->Form->control('Search', array('type'=>'submit', 'name'=>'submit','value'=>'search', 'label'=>false,'class'=>'btn btn-primary font-weight-bold pl-4 pr-4 ml-2')); ?>
				</div>
				<div class="col-md-4">
				<?php echo $this->Form->control('Reset', array('type'=>'submit', 'name'=>'reset','value'=>'reset', 'label'=>false,'class'=>'btn btn-info font-weight-bold pl-4 pr-4 ml-2')); ?>
				</div>
			</div>
		</div>
			<?php $this->Form->end() ?> 
    </div>
</div>
<div class="main-card mb-3 card">
	<div class="card-body">			
		<div class="table-responsive">
			<table class="mb-0 table table-striped " id="list">
				<thead class="bg-dark text-white">
					<tr>
						<td class="p-1 border-right-1 border-white">#</td>
				        <td class="p-1 border-right-1 border-white">REG. NO.</td>
				        <td class="p-1 border-right-1 border-white">NAME OF THE OWNER</td>
				        <td class="p-1 border-right-1 border-white">MINE NAME</td>
				        <td class="p-1 border-right-1 border-white">MINE CODE</td>
				        <td class="p-1 border-right-1 border-white">MINERAL NAME</td>
				        <td class="p-1 border-right-1 border-white">YEAR</td>
				        <td class="p-1 border-right-1 border-white">STATUS</td>
				        <td class="p-1 border-right-1 border-white">VIEW</td>
					</tr>
				</thead>  
				<tbody>
					<?php if(!empty($allData)){ $sr=1; foreach ($allData as $each) { ?>
					<tr>
						<td><?= $sr; ?></td>
						<td><?= $each['reg_no']; ?></td>
						<td><?= $each['owner_name']; ?></td>
						<td><?= $each['mine_name']; ?></td>
						<td><?= $each['mine_code']; ?></td>
						<td><?php if ($each['mineral_name'] == 1) { ?>
				              IRON ORE-HEMATITE
				            <?php } else if ($each['mineral_name'] == 2) {
				              ?>
				              IRON ORE-MEGNATITE
				            <?php
				            } else {
				              echo $each['mineral_name'];
				            }
				            ?></td>
						<td><?= $each['first_submit_year']; ?></td>
						<td><?php
				            $s = $each['status'];
				            if ($s == 0)
				              $status = "Pending";
				            else if ($s == 1)
				              $status = "Accepted";
				            else if ($s == 2)
				              $status = "Referred Back";
				            echo $status;?>
				        </td>
				        <td><?php echo $this->Html->link('', array('controller' => '', 'action'=>'', $each['id']),array('class'=>'fas fa-eye','title'=>'View')); ?></td>
					</tr>
					<?php $sr++; } } ?>
				</tbody>
			</table>			
		</div>
	</div>
</div>

    