
<h5 class="card-title text-center"><?php echo $label['title']; ?></h5>
<div class="position-relative row form-group mine-group">
	<div class="col-sm-12 mine-m-auto">
		<table class="table table-bordered" id="d_avg_table">
			<thead class="bg-secondary text-white text-center">
				<tr>
					<th rowspan="2"><?php echo $label[0]; ?></th>
					<th colspan="2"><?php echo $label[1]; ?></th>
					<th colspan="2"><?php echo $label[2]; ?></th>
					<th colspan="2"><?php echo $label[3]; ?></th>
				</tr>
				<tr>
					<th><?php echo $label[4]; ?></th>
					<th><?php echo $label[5]; ?></th>
					<th><?php echo $label[6]; ?></th>
					<th><?php echo $label[7]; ?></th>
					<th><?php echo $label[8]; ?></th>
					<th><?php echo $label[9]; ?></th>
				</tr>
			</thead>
			<tbody>
				<tr class="d_avg_work_place">
					<td><?php echo $label[10]; ?></td>
					<td>
						<?php echo $this->Form->control('f_below_male_avg_direct', array('type'=>'text', 'class'=>'form-control text-fields right open_direct_male req', 'id'=>'F_Below_MALE_AVG_DIRECT', 'cvfloat'=>'9999.9', 'label'=>false, 'value'=>$belowArr['male_avg_direct'])); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_below_female_avg_direct', array('type'=>'text', 'class'=>'form-control text-fields right open_direct_female req', 'id'=>'F_Below_FEMALE_AVG_DIRECT', 'cvfloat'=>'9999.9', 'label'=>false, 'value'=>$belowArr['female_avg_direct'])); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_below_male_avg_contract', array('type'=>'text', 'class'=>'form-control text-fields right contract_male req', 'id'=>'F_Below_MALE_AVG_CONTRACT', 'cvfloat'=>'9999.9', 'label'=>false, 'value'=>$belowArr['male_avg_contract'])); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_below_female_avg_contract', array('type'=>'text', 'class'=>'form-control text-fields right contract_female req', 'id'=>'F_Below_FEMALE_AVG_CONTRACT', 'cvfloat'=>'9999.9', 'label'=>false, 'value'=>$belowArr['female_avg_contract'])); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_below_wage_direct', array('type'=>'text', 'class'=>'form-control text-fields right direct_wages req', 'id'=>'F_Below_WAGE_DIRECT', 'label'=>false, 'cvfloat'=>'999999999.9', 'value'=>$belowArr['wage_direct'])); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_below_wage_contract', array('type'=>'text', 'class'=>'form-control text-fields right contract_wages req', 'id'=>'F_Below_WAGE_CONTRACT', 'label'=>false, 'cvfloat'=>'999999999.9', 'value'=>$belowArr['wage_contract'])); ?>
						<div class="err_cv"></div>
					</td>
				</tr>
				<tr class="d_avg_work_place">
					<td><?php echo $label[11]; ?></td>
					<td>
						<?php echo $this->Form->control('f_open_male_avg_direct', array('type'=>'text', 'class'=>'form-control text-fields right open_direct_male req', 'id'=>'F_Open_MALE_AVG_DIRECT', 'cvfloat'=>'9999.9', 'label'=>false, 'value'=>$openArr['male_avg_direct'])); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_open_female_avg_direct', array('type'=>'text', 'class'=>'form-control text-fields right open_direct_female req', 'id'=>'F_Open_FEMALE_AVG_DIRECT', 'cvfloat'=>'9999.9', 'label'=>false, 'value'=>$openArr['female_avg_direct'])); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_open_male_avg_contract', array('type'=>'text', 'class'=>'form-control text-fields right contract_male req', 'id'=>'F_Open_MALE_AVG_CONTRACT', 'cvfloat'=>'9999.9', 'label'=>false, 'value'=>$openArr['male_avg_contract'])); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_open_female_avg_contract', array('type'=>'text', 'class'=>'form-control text-fields right contract_female req', 'id'=>'F_Open_FEMALE_AVG_CONTRACT', 'cvfloat'=>'9999.9', 'label'=>false, 'value'=>$openArr['female_avg_contract'])); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_open_wage_direct', array('type'=>'text', 'class'=>'form-control text-fields right direct_wages req', 'id'=>'F_Open_WAGE_DIRECT', 'cvfloat'=>'999999999.9', 'label'=>false, 'value'=>$openArr['wage_direct'])); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_open_wage_contract', array('type'=>'text', 'class'=>'form-control text-fields right contract_wages req', 'id'=>'F_Open_WAGE_CONTRACT', 'cvfloat'=>'999999999.9', 'label'=>false, 'value'=>$openArr['wage_contract'])); ?>
						<div class="err_cv"></div>
					</td>
				</tr>
				<tr class="d_avg_work_place">
					<td><?php echo $label[12]; ?></td>
					<td>
						<?php echo $this->Form->control('f_above_male_avg_direct', array('type'=>'text', 'class'=>'form-control text-fields right open_direct_male req', 'id'=>'F_Above_MALE_AVG_DIRECT', 'cvfloat'=>'9999.9', 'label'=>false, 'value'=>$aboveArr['male_avg_direct'])); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_above_female_avg_direct', array('type'=>'text', 'class'=>'form-control text-fields right open_direct_female req', 'id'=>'F_Above_FEMALE_AVG_DIRECT', 'cvfloat'=>'9999.9', 'label'=>false, 'value'=>$aboveArr['female_avg_direct'])); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_above_male_avg_contract', array('type'=>'text', 'class'=>'form-control text-fields right contract_male req', 'id'=>'F_Above_MALE_AVG_CONTRACT', 'cvfloat'=>'9999.9', 'label'=>false, 'value'=>$aboveArr['male_avg_contract'])); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_above_female_avg_contract', array('type'=>'text', 'class'=>'form-control text-fields right contract_female req', 'id'=>'F_Above_FEMALE_AVG_CONTRACT', 'cvfloat'=>'9999.9', 'label'=>false, 'value'=>$aboveArr['female_avg_contract'])); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_above_wage_direct', array('type'=>'text', 'class'=>'form-control text-fields right direct_wages req', 'id'=>'F_Above_WAGE_DIRECT', 'cvfloat'=>'999999999.9', 'label'=>false, 'value'=>$aboveArr['wage_direct'])); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_above_wage_contract', array('type'=>'text', 'class'=>'form-control text-fields right contract_wages req', 'id'=>'F_Above_WAGE_CONTRACT', 'cvfloat'=>'999999999.9', 'label'=>false, 'value'=>$aboveArr['wage_contract'])); ?>
						<div class="err_cv"></div>
					</td>
				</tr>
			</tbody>
			<thead class="bg-light">
				<tr class="d_dvg_work_place_total">
					<th><?php echo $label[13]; ?></th>
					<th>
						<?php echo $this->Form->control('f_open_total_male_direct', array('type'=>'text', 'class'=>'form-control text-fields right open_direct_male req', 'id'=>'F_Open_TOTAL_MALE_DIRECT', 'label'=>false, 'value'=>$openArr['total_male_direct'])); ?>
						<div class="err_cv"></div>
					</th>
					<th>
						<?php echo $this->Form->control('f_open_total_female_direct', array('type'=>'text', 'class'=>'form-control text-fields right open_direct_female req', 'id'=>'F_Open_TOTAL_FEMALE_DIRECT', 'label'=>false, 'value'=>$openArr['total_female_direct'])); ?>
						<div class="err_cv"></div>
					</th>
					<th>
						<?php echo $this->Form->control('f_open_total_male_contract', array('type'=>'text', 'class'=>'form-control text-fields right contract_male req', 'id'=>'F_Open_TOTAL_MALE_CONTRACT', 'label'=>false, 'value'=>$openArr['total_male_contract'])); ?>
						<div class="err_cv"></div>
					</th>
					<th>
						<?php echo $this->Form->control('f_open_total_female_contract', array('type'=>'text', 'class'=>'form-control text-fields right contract_female req', 'id'=>'F_Open_TOTAL_FEMALE_CONTRACT', 'label'=>false, 'value'=>$openArr['total_female_contract'])); ?>
						<div class="err_cv"></div>
					</th>
					<th>
						<?php echo $this->Form->control('f_open_total_direct', array('type'=>'text', 'class'=>'form-control text-fields right direct_wages req', 'id'=>'F_Open_TOTAL_DIRECT', 'label'=>false, 'value'=>$openArr['total_direct'])); ?>
						<div class="err_cv"></div>
					</th>
					<th>
						<?php echo $this->Form->control('f_open_total_contract', array('type'=>'text', 'class'=>'form-control text-fields right contract_wages req', 'id'=>'F_Open_TOTAL_CONTRACT', 'label'=>false, 'value'=>$openArr['total_contract'])); ?>
						<div class="err_cv"></div>
					</th>
				</tr>
			</thead>
			<thead>
				<tr>
					<td colspan="7"><div class="alert alert-info p-2 pl-3"><?php echo $label[14]; ?></div></td>
				</tr>
			</thead>
		</table>
	</div>
</div>

<?php echo $this->Form->control('form_no', array('type'=>'hidden', 'label'=>false, 'value'=>$formId)); ?>
<?php echo $this->Form->control('mine_code', array('type'=>'hidden', 'label'=>false, 'value'=>$mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'label'=>false, 'value'=>$returnType)); ?>
<?php echo $this->Form->control('return_date', array('type'=>'hidden', 'label'=>false, 'value'=>$returnDate)); ?>
<?php echo $this->Form->control('open_cast_id', array('type'=>'hidden', 'label'=>false, 'value'=>$openCastId)); ?>
<?php echo $this->Form->control('below_id', array('type'=>'hidden', 'label'=>false, 'value'=>$belowId)); ?>
<?php echo $this->Form->control('above_id', array('type'=>'hidden', 'label'=>false, 'value'=>$aboveId)); ?>
<?php echo $this->Form->control('returnMonthTotalDays', array('type'=>'hidden', 'id'=>'return_month_total_days', 'label'=>false, 'value'=>$returnMonthTotalDays)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden','id'=>'form_id_name', 'label'=>false, 'value'=>'frmDailyAverage')); ?>

<?php echo $this->Html->script('f/daily_average'); ?>
