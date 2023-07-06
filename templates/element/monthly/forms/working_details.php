
<h5 class="card-title text-center"><?php echo $label['title']; ?></h5>
<div class="position-relative row form-group mine-group">
	<div class="col-sm-4"><?php echo $label[0]; ?></div>
	<div class="col-sm-8 mine-m-auto">
		<div class="col-sm-6">
			<?php echo $this->Form->control('f_total_no_days', array('class'=>'form-control', 'id'=>'f_total_no_days', 'label'=>false, 'autocomplete'=>"off", 'maxlength'=>"2", 'value'=>$workDetail['total_no_days'])); ?>
		<div class="err_cv"></div>
		</div>
	</div>
</div>
<div class="position-relative row form-group mine-group">
	<div class="col-sm-4"><?php echo $label[1]; ?></div>
	<div class="col-sm-8 mine-m-auto">
		<table class="table working_det_table table-bordered">
			<thead class="bg-secondary text-white text-center">
				<tr>
					<th><?php echo $label[2]; ?></th>
					<th colspan="2"><?php echo $label[3]; ?></th>
				</tr>
			</thead>
			<?php 

			$optionArr = [];
			foreach($reasonsArr as $reason){
				$optionArr[$reason['stoppage_sn']] = $reason['stoppage_def']; 
			}

			$freeOptionArr = $optionArr;

			if($workDetail['stoppage_sn_1']!=null){
				unset($freeOptionArr[$workDetail['stoppage_sn_1']]);
			}
			if($workDetail['stoppage_sn_2']!=null){
				unset($freeOptionArr[$workDetail['stoppage_sn_2']]);
			}
			if($workDetail['stoppage_sn_3']!=null){
				unset($freeOptionArr[$workDetail['stoppage_sn_3']]);
			}
			if($workDetail['stoppage_sn_4']!=null){
				unset($freeOptionArr[$workDetail['stoppage_sn_4']]);
			}
			if($workDetail['stoppage_sn_5']!=null){
				unset($freeOptionArr[$workDetail['stoppage_sn_5']]);
			}

			if($workDetail['stoppage_sn_1']!=null){
				$optionArr1 = $freeOptionArr;
				$optionArr1[$workDetail['stoppage_sn_1']] = $optionArr[$workDetail['stoppage_sn_1']];
			}
			if($workDetail['stoppage_sn_2']!=null){
				$optionArr2 = $freeOptionArr;
				$optionArr2[$workDetail['stoppage_sn_2']] = $optionArr[$workDetail['stoppage_sn_2']];
			}
			if($workDetail['stoppage_sn_3']!=null){
				$optionArr3 = $freeOptionArr;
				$optionArr3[$workDetail['stoppage_sn_3']] = $optionArr[$workDetail['stoppage_sn_3']];
			}
			if($workDetail['stoppage_sn_4']!=null){
				$optionArr4 = $freeOptionArr;
				$optionArr4[$workDetail['stoppage_sn_4']] = $optionArr[$workDetail['stoppage_sn_4']];
			}
			if($workDetail['stoppage_sn_5']!=null){
				$optionArr5 = $freeOptionArr;
				$optionArr5[$workDetail['stoppage_sn_5']] = $optionArr[$workDetail['stoppage_sn_5']];
			}

			?>
			<tbody class="table_body">
				<?php if($workDetail['stoppage_sn_1']!=null){ ?>
					<tr id="row-1">
						<td>
							<?php echo $this->Form->select('stoppage_reason_1', $optionArr1, array('empty'=>'Select Reason','class'=>'form-control work_det_reason', 'id'=>'stoppage_reason-1')); ?>
							<div class="err_cv"></div>
							<?php echo $this->Form->control('stop_res_last_key[]', array('type'=>'hidden','id'=>'sto_res_last_key-1','value'=>$workDetail['stoppage_sn_1'])); ?>
							<?php echo $this->Form->control('stop_res_last_val[]', array('type'=>'hidden','id'=>'sto_res_last_val-1','value'=>$optionArr[$workDetail['stoppage_sn_1']])); ?>
						</td>
						<td>
							<?php echo $this->Form->control('no_days_1', array('class'=>'form-control cvOn cvNotReq', 'id'=>'no_days_1', 'label'=>false, 'value'=>$workDetail['no_days_1'])); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->button('<i class="fa fa-times"></i>', array('type'=>'button', 'escapeTitle'=>false, 'class'=>'btn btn-sm btn-danger rem_work_det_row', 'disabled'=>'true')); ?>
						</td>
					</tr>
				<?php } else { ?>
					<tr id="row-1">
						<td>
							<?php echo $this->Form->select('stoppage_reason_1', $optionArr, array('empty'=>'Select Reason','class'=>'form-control work_det_reason', 'id'=>'stoppage_reason-1')); ?>
							<div class="err_cv"></div>
							<?php echo $this->Form->control('stop_res_last_key[]', array('type'=>'hidden','id'=>'sto_res_last_key-1','value'=>'')); ?>
							<?php echo $this->Form->control('stop_res_last_val[]', array('type'=>'hidden','id'=>'sto_res_last_val-1','value'=>'')); ?>
						</td>
						<td>
							<?php echo $this->Form->control('no_days_1', array('class'=>'form-control cvOn cvNotReq', 'id'=>'no_days_1', 'label'=>false)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->button('<i class="fa fa-times"></i>', array('type'=>'button', 'escapeTitle'=>false, 'class'=>'btn btn-sm btn-danger rem_work_det_row', 'disabled'=>'true')); ?>
						</td>
					</tr>
				<?php } ?>

				<?php if($workDetail['stoppage_sn_2']!=null){ ?>
					<tr id="row-2">
						<td>
							<?php echo $this->Form->select('stoppage_reason_2', $optionArr2, array('empty'=>'Select Reason','class'=>'form-control work_det_reason', 'id'=>'stoppage_reason-2')); ?>
							<div class="err_cv"></div>
							<?php echo $this->Form->control('stop_res_last_key[]', array('type'=>'hidden','id'=>'sto_res_last_key-2','value'=>$workDetail['stoppage_sn_2'])); ?>
							<?php echo $this->Form->control('stop_res_last_val[]', array('type'=>'hidden','id'=>'sto_res_last_val-2','value'=>$optionArr[$workDetail['stoppage_sn_2']])); ?>
						</td>
						<td>
							<?php echo $this->Form->control('no_days_2', array('class'=>'form-control cvOn cvNotReq', 'id'=>'no_days_2', 'label'=>false, 'value'=>$workDetail['no_days_2'])); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->button('<i class="fa fa-times"></i>', array('type'=>'button', 'escapeTitle'=>false, 'class'=>'btn btn-sm btn-danger rem_work_det_row', 'disabled'=>'true')); ?>
						</td>
					</tr>
				<?php } ?>

				<?php if($workDetail['stoppage_sn_3']!=null){ ?>
					<tr id="row-3">
						<td>
							<?php echo $this->Form->select('stoppage_reason_3', $optionArr3, array('empty'=>'Select Reason','class'=>'form-control work_det_reason', 'id'=>'stoppage_reason-3')); ?>
							<div class="err_cv"></div>
							<?php echo $this->Form->control('stop_res_last_key[]', array('type'=>'hidden','id'=>'sto_res_last_key-3','value'=>$workDetail['stoppage_sn_3'])); ?>
							<?php echo $this->Form->control('stop_res_last_val[]', array('type'=>'hidden','id'=>'sto_res_last_val-3','value'=>$optionArr[$workDetail['stoppage_sn_3']])); ?>
						</td>
						<td>
							<?php echo $this->Form->control('no_days_3', array('class'=>'form-control cvOn cvNotReq', 'id'=>'no_days_3', 'label'=>false, 'value'=>$workDetail['no_days_3'])); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->button('<i class="fa fa-times"></i>', array('type'=>'button', 'escapeTitle'=>false, 'class'=>'btn btn-sm btn-danger rem_work_det_row', 'disabled'=>'true')); ?>
						</td>
					</tr>
				<?php } ?>

				<?php if($workDetail['stoppage_sn_4']!=null){ ?>
					<tr id="row-4">
						<td>
							<?php echo $this->Form->select('stoppage_reason_4', $optionArr4, array('empty'=>'Select Reason','class'=>'form-control work_det_reason', 'id'=>'stoppage_reason-4')); ?>
							<div class="err_cv"></div>
							<?php echo $this->Form->control('stop_res_last_key[]', array('type'=>'hidden','id'=>'sto_res_last_key-4','value'=>$workDetail['stoppage_sn_4'])); ?>
							<?php echo $this->Form->control('stop_res_last_val[]', array('type'=>'hidden','id'=>'sto_res_last_val-4','value'=>$optionArr[$workDetail['stoppage_sn_4']])); ?>
						</td>
						<td>
							<?php echo $this->Form->control('no_days_4', array('class'=>'form-control cvOn cvNotReq', 'id'=>'no_days_4', 'label'=>false, 'value'=>$workDetail['no_days_4'])); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->button('<i class="fa fa-times"></i>', array('type'=>'button', 'escapeTitle'=>false, 'class'=>'btn btn-sm btn-danger rem_work_det_row', 'disabled'=>'true')); ?>
						</td>
					</tr>
				<?php } ?>

				<?php if($workDetail['stoppage_sn_5']!=null){ ?>
					<tr id="row-5">
						<td>
							<?php echo $this->Form->select('stoppage_reason_5', $optionArr5, array('empty'=>'Select Reason','class'=>'form-control work_det_reason', 'id'=>'stoppage_reason-5')); ?>
							<div class="err_cv"></div>
							<?php echo $this->Form->control('stop_res_last_key[]', array('type'=>'hidden','id'=>'sto_res_last_key-5','value'=>$workDetail['stoppage_sn_5'])); ?>
							<?php echo $this->Form->control('stop_res_last_val[]', array('type'=>'hidden','id'=>'sto_res_last_val-5','value'=>$optionArr[$workDetail['stoppage_sn_5']])); ?>
						</td>
						<td>
							<?php echo $this->Form->control('no_days_5', array('class'=>'form-control cvOn cvNotReq', 'id'=>'no_days_5', 'label'=>false, 'value'=>$workDetail['no_days_5'])); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->button('<i class="fa fa-times"></i>', array('type'=>'button', 'escapeTitle'=>false, 'class'=>'btn btn-sm btn-danger rem_work_det_row', 'disabled'=>'true')); ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
			<thead>
				<tr>
					<td colspan="3">
						<?php echo $this->Form->button('<i class="fa fa-plus"></i> Add more', array('type'=>'button', 'escapeTitle'=>false, 'class'=>'btn btn-info btn-sm float-right', 'id'=>'working_det_add_more')); ?>
					</td>
				</tr>
			</thead>
		</table>
	</div>
</div>

<input type="hidden" value="<?php echo $workDetail['stoppage_sn_1']; ?>" id="stop_1"/>
<input type="hidden" value="<?php echo $workDetail['stoppage_sn_2']; ?>" id="stop_2"/>
<input type="hidden" value="<?php echo $workDetail['stoppage_sn_3']; ?>" id="stop_3"/>
<input type="hidden" value="<?php echo $workDetail['stoppage_sn_4']; ?>" id="stop_4"/>
<input type="hidden" value="<?php echo $workDetail['stoppage_sn_5']; ?>" id="stop_5"/>

<?php echo $this->Form->control('form_no', array('type'=>'hidden', 'value'=>$formId)); ?>
<?php echo $this->Form->control('mine_code', array('type'=>'hidden', 'value'=>$mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType)); ?>
<?php echo $this->Form->control('return_date', array('type'=>'hidden', 'value'=>$returnDate)); ?>
<?php echo $this->Form->control('curmonth', array('type'=>'hidden', 'id'=>'curmonth', 'value'=>date('m'))); ?>
<?php echo $this->Form->control('curyear', array('type'=>'hidden', 'id'=>'curyear', 'value'=>date('Y'))); ?>
<?php echo $this->Form->control('month_days', array('type'=>'hidden', 'id'=>'month_days', 'value'=>$month_days)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'form_id_name', 'value'=>'frmWorkingDetails')); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'free_option_arr', 'value'=>$this->Form->select("stoppage_reason_incStringPurpose", $freeOptionArr, array("empty"=>"Select Reason","class"=>"form-control work_det_reason", "id"=>"stoppage_reason-incStringPurpose")))); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'stoppage_sn_1', 'value'=>$workDetail['stoppage_sn_1'])); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'stoppage_sn_2', 'value'=>$workDetail['stoppage_sn_2'])); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'stoppage_sn_3', 'value'=>$workDetail['stoppage_sn_3'])); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'stoppage_sn_4', 'value'=>$workDetail['stoppage_sn_4'])); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'stoppage_sn_5', 'value'=>$workDetail['stoppage_sn_5'])); ?>

<?php echo $this->Html->script('f/working_details'); ?>
