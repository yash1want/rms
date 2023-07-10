
<h5 class="card-title text-center"><?php echo $label['title']; ?></h5>
<div class="position-relative row form-group mine-group">

	<div class="col-sm-12 mine-m-auto">
		<div class="card-body">
			<div class="row">
				<div class="col-sm-12 tank_table">
					<div class="table-format">
						<div id="test"></div>
						<div id="directors_each_row"></div>
						<div id="error_directors_details" class="text-red float-right text-sm"></div>
						<div id="add_new_row"></div>
						<div id="table_container_1"></div>

					</div>
					<div class="alert alert-info p-2 pl-3">
					<?php echo $label['note4']; ?><br/><br/>
						<em><?php echo $label['note1']; ?></em><br/><br/>
						<?php //if($formNo == '5'){ ?>
							<?php echo $label['note']; ?></div>
						<?php //} ?>
					</div>
				</div>
			</div>
	  	</div>
	
	
	<div class="col-sm-12 mt_42_m">
		<div class="card-body col-sm-12">
			<h5 class="card-title"><?php echo $label[11]; ?></h5>
			<table class="s_des_reason_table">
				<thead>
					<tr>
						<th>
							<div class="p-2"><?php echo $label[13]; ?></div>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="p-2">
							<?php echo $this->Form->control('reason_1', array('type'=>'textarea', 'class'=>'form-control cvOn cvReq cvMaxLen', 'id'=>'reason_1', 'label'=>false, 'value'=>$reasonData['reason_1'], 'maxlength'=>'500', 'rows'=>'3')); ?>
							<div class="err_cv position-absolute mt-2"></div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	
	<div class="col-sm-12 mine-m-auto">
		<div class="card-body col-sm-12">
			<h5 class="card-title"><?php echo $label[12]; ?></h5>
			<table class="s_des_reason_table">
				<thead>
					<tr>
						<th>
							<div class="p-2"><?php echo $label[14]; ?></div>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="p-2">
							<?php echo $this->Form->control('reason_2', array('type'=>'textarea', 'class'=>'form-control cvOn cvReq cvMaxLen', 'id'=>'reason_2', 'label'=>false, 'value'=>$reasonData['reason_2'], 'maxlength'=>'500', 'rows'=>'3')); ?>
							<div class="err_cv position-absolute mt-2"></div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

</div>

<?php echo $this->Form->control('form_no', array('type'=>'hidden', 'value'=>$formId)); ?>
<?php echo $this->Form->control('mine_code', array('type'=>'hidden', 'value'=>$mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType)); ?>
<?php echo $this->Form->control('return_date', array('type'=>'hidden', 'value'=>$returnDate)); ?>
<?php echo $this->Form->control('mineral_name', array('type'=>'hidden', 'value'=>$mineral)); ?>
<?php echo $this->Form->control('iron_sub_min', array('type'=>'hidden', 'value'=>$ironSubMin)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden','id'=>'form_id_name', 'value'=>'frmSalesDespatches')); ?>

<?php echo $this->Form->control('mc_form_main', array('type'=>'hidden', 'id'=>'mc_form_main', 'value'=>$mc_form_main));?>
<?php echo $this->Form->control('consignee_url', array('type'=>'hidden', 'id'=>'consignee_url', 'value'=>$this->Url->build(['controller'=>'monthly', 'action'=>'get_consignee']))); ?>
<?php echo $this->Form->control('app_id_url', array('type'=>'hidden', 'id'=>'app_id_url', 'value'=>$this->Url->build(['controller'=>'monthly', 'action'=>'get_app_id']))); ?>

<?php echo $this->Html->script('f/sale_despatch.js?version='.$version); ?>
