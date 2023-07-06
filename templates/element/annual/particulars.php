
<h5 class="card-title text-center"><?php echo $label['title']; ?></h5>
<h5 class="font_15 text-center"><?php echo $label['title_note']; ?></h5>

<div class="particular_con" id="particular_con">


	<?php 
	$tbl = 1;
	foreach($particulars as $particular){
		?>

		<div class="rounded border mt-3 particular_tbl_div" id="tbl_con_<?php echo $tbl; ?>">
			<table class="table table-bordered particular_tbl mb-0" id="particular_tbl_<?php echo $tbl; ?>">
				<tbody>
					<tr>
						<td colspan="2"><?php echo $label[0]; ?></td>
						<td>
							<?php echo $this->Form->control('lease_no_'.$tbl, array('class'=>'form-control form-control-sm number-fields lease_no', 'id'=>'lease_no_'.$tbl, 'label'=>false, 'value'=>$particular['lease_no'])); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<div class="btn btn-danger btn-sm float-right tbl_rem_btn" id="tbl_rem_btn_<?php echo $tbl; ?>"><i class="fa fa-times"></i></div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<?php echo $label[1]; ?>
							<table class="table">
								<tbody>
									<tr>
										<td><?php echo $label[2]; ?></td>
										<td>
											<div class="input-group input-group-sm">
												<?php echo $this->Form->control('under_forest_'.$tbl, array('class'=>'form-control number-fields under_lease', 'id'=>'under_forest_'.$tbl, 'label'=>false, 'value'=>$particular['under_forest'], 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
												<div class="input-group-append">
													<div class="input-group-text" id="btnGroupAddon"><?php echo $label['unit']; ?></div>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td><?php echo $label[3]; ?></td>
										<td>
											<div class="input-group input-group-sm">
												<?php echo $this->Form->control('outside_forest_'.$tbl, array('class'=>'form-control number-fields under_lease', 'id'=>'outside_forest_'.$tbl, 'label'=>false, 'value'=>$particular['outside_forest'], 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
												<div class="input-group-append">
													<div class="input-group-text" id="btnGroupAddon"><?php echo $label['unit']; ?></div>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td><?php echo $label[4]; ?></td>
										<td>
											<div class="input-group input-group-sm">
												<?php echo $this->Form->control('total_'.$tbl, array('class'=>'form-control number-fields total_under_lease', 'id'=>'total_'.$tbl, 'label'=>false, 'value'=>$particular['total'], 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
												<div class="input-group-append">
													<div class="input-group-text" id="btnGroupAddon"><?php echo $label['unit']; ?></div>
												</div>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
						<td colspan="2">
							<?php echo $label[7]; ?>
							<table class="table">
								<tbody>
									<tr>
										<td><?php echo $label[2]; ?></td>
										<td>
											<div class="input-group input-group-sm">
												<?php echo $this->Form->control('surface_under_forest_'.$tbl, array('class'=>'form-control number-fields under_lease', 'id'=>'surface_under_forest_'.$tbl, 'label'=>false, 'value'=>$particular['surface_under_forest'], 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
												<div class="input-group-append">
													<div class="input-group-text" id="btnGroupAddon"><?php echo $label['unit']; ?></div>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td><?php echo $label[3]; ?></td>
										<td>
											<div class="input-group input-group-sm">
												<?php echo $this->Form->control('surface_outside_forest_'.$tbl, array('class'=>'form-control number-fields under_lease', 'id'=>'surface_outside_forest_'.$tbl, 'label'=>false, 'value'=>$particular['surface_outside_forest'], 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
												<div class="input-group-append">
													<div class="input-group-text" id="btnGroupAddon"><?php echo $label['unit']; ?></div>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td><?php echo $label[4]; ?></td>
										<td>
											<div class="input-group input-group-sm">
												<?php echo $this->Form->control('surface_total_'.$tbl, array('class'=>'form-control number-fields total_under_lease', 'id'=>'surface_total_'.$tbl, 'label'=>false, 'value'=>$particular['surface_rights'], 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
												<div class="input-group-append">
													<div class="input-group-text" id="btnGroupAddon"><?php echo $label['unit']; ?></div>
												</div>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td><?php echo $label[5]; ?></td>
						<td>
							<?php echo $this->Form->control('execution_date_'.$tbl, array('type'=>'date', 'class'=>'form-control form-control-sm number-fields execution_date hasDatepicker', 'id'=>'execution_date_'.$tbl, 'label'=>false, 'value'=>$particular['execution_date'], 'min'=>'1960-01-01', 'max'=>$max_date)); ?>
							<div class="err_cv"></div>
						</td>
						<td><?php echo $label[8]; ?></td>
						<td>
							<?php echo $this->Form->control('renewal_date_'.$tbl, array('type'=>'date', 'class'=>'form-control form-control-sm number-fields renewal_date hasDatepicker valid', 'id'=>'renewal_date_'.$tbl, 'label'=>false, 'value'=>$particular['renewal_date'], 'min'=>'1960-01-01', 'max'=>$max_date)); ?>
							<div class="err_cv"></div>
						</td>
					</tr>
					<tr>
						<td><?php echo $label[6]; ?></td>
						<td>
							<?php echo $this->Form->control('lease_period_'.$tbl, array('class'=>'form-control form-control-sm number-fields leasePeriod', 'id'=>'lease_period_'.$tbl, 'label'=>false, 'value'=>$particular['lease_period'])); ?>
							<div class="err_cv"></div>
						</td>
						<td><?php echo $label[9]; ?></td>
						<td>
							<?php echo $this->Form->control('renewal_period_'.$tbl, array('class'=>'form-control form-control-sm number-fields period valid', 'id'=>'renewal_period_'.$tbl, 'label'=>false, 'value'=>$particular['renewal_period'])); ?>
							<div class="err_cv"></div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	<?php $tbl++; } ?>

</div>

<div class="form-row">
    <div class="col-md-6">
        <div class="position-relative form-group">
        	<div class="btn btn-info btn-sm mt-3" id="add_more_btn_particular"><i class="fa fa-plus"></i> <?php echo $label['btn']; ?></div>
        </div>
    </div>
</div>

<div class="position-relative row form-group mine-group">
	<div class="col-sm-6">
		<?php echo $label[10]; ?><br>
		<!-- <?php //if(count($mine_data) <= 1){ echo "d_none"; } else { echo "d-inline-block";} ?> -->
		<!-- <span class="alert alert-secondary d-inline-block p-1 pl-2 pr-2 font_12  mt-3 "><?php echo $label['note']; ?></span> Comment by Shweta Apale 25-01-2022 because now provided Multiselect Checkbox -->
	</div>
	<div class="col-sm-6 mine-m-auto">
		<!-- <?php //if(count($mine_data) <= 1){ echo "d_none"; } ?> -->

		<?php echo $this->Form->select('add_info_lease', $mine_data, array('id'=>'add_info_lease', 'class'=>'form-control lease-mine-code', 'multiple'=>'multiple', 'value'=>$particulars[0]['lease_info'])); ?>
	</div>
</div>

<?php 

	echo $this->Form->control('form_no', array('type'=>'hidden', 'value'=>$formId));
	echo $this->Form->control('mine_code', array('type'=>'hidden', 'value'=>$mineCode));
	echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType));
	echo $this->Form->control('return_date', array('type'=>'hidden', 'value'=>$returnDate));
	echo $this->Form->control('return_year', array('type'=>'hidden', 'value'=>$returnYear));

	echo $this->Form->control('table_count', array('type'=>'hidden', 'value'=>'0', 'id'=>'table_count'));

	echo $this->Form->control('', array('type'=>'hidden', 'id'=>'form_id_name', 'value'=>'frmParticulars'));
	echo $this->Form->control('', array('type'=>'hidden', 'id'=>'stoppage_sn_1', 'value'=>''));
	echo $this->Form->control('', array('type'=>'hidden', 'id'=>'stoppage_sn_2', 'value'=>''));
	echo $this->Form->control('', array('type'=>'hidden', 'id'=>'stoppage_sn_3', 'value'=>''));
	echo $this->Form->control('', array('type'=>'hidden', 'id'=>'stoppage_sn_4', 'value'=>''));
	echo $this->Form->control('', array('type'=>'hidden', 'id'=>'stoppage_sn_5', 'value'=>''));

	echo $this->Html->script('g/particulars.js?version='.$version); 
	
?>
