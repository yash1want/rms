
<?php 

// Highlight fields which are differs from cumulative monthly data in annual
// (Only for Form G2 in MMS side)
// Effective from Phase-II
// Added on 20th Nov 2021 by Aniket Ganvir

$row_old_main = (isset($recoveryDataMonthAll)) ? $recoveryDataMonthAll : array('recovery'=>array(),'con_metal'=>array(),'by_product'=>array());
$recoveryCats = array('open_metal', 'open_qty', 'open_grade', 'con_rc_qty', 'con_rc_grade', 'con_rs_qty', 'con_rs_grade', 'con_rs_source', 'con_so_qty', 'con_so_grade', 'con_tr_qty', 'con_tr_grade', 'close_qty', 'close_value');
	
foreach ($recoveryData['recovery'] as $key=>$val) {

	foreach ($recoveryCats as $recov) {
		$diff['recovery'][$key][$recov]['class'] = '';
		$diff['recovery'][$key][$recov]['title'] = '';
	}
	
	if (isset($recoveryDataMonthAll)) {
		
		$recoveryDataOld = $recoveryDataMonthAll;
		$openMetal = $recoveryData['recovery'][$key]['open_metal'];
		$metalId = array_search($openMetal, array_column($recoveryDataOld['recovery'], 'open_metal'));
	
		if ($metalId != '') {

			foreach ($recoveryCats as $recov) {
				if (!in_array($recov, array('open_metal', 'con_rs_source'))) {
					if ($recoveryDataOld['recovery'][$metalId][$recov] != $val[$recov]) {
						$openQtyDiff = $val[$recov] - $recoveryDataOld['recovery'][$metalId][$recov];
						$diff['recovery'][$key][$recov]['title'] = ($openQtyDiff > 0) ? '+'.$openQtyDiff : $openQtyDiff;
						$diff['recovery'][$key][$recov]['class'] = ' in_new';
					}
				}
			}
			
			unset($row_old_main['recovery'][$metalId]);

		} else {
			
			foreach ($recoveryCats as $recov) {
				$diff['recovery'][$key][$recov]['class'] = ' in_new';
				$diff['recovery'][$key][$recov]['title'] = 'New record';
			}

		}
	
	}

}

$conMetalByProd = array('con_metal', 'by_product');
$conCat['con_metal'] = array('rc_metal', 'rc_qty', 'rc_value', 'rc_grade', 'unit');
$conCat['by_product'] = array('bp_metal', 'bp_qty', 'bp_value', 'bp_grade', 'unit');
foreach ($conMetalByProd as $con) {
	
	foreach ($recoveryData[$con] as $key=>$val) {

		foreach ($conCat[$con] as $recov) {
			$diff[$con][$key][$recov]['class'] = '';
			$diff[$con][$key][$recov]['title'] = '';
		}
		
		if (isset($recoveryDataMonthAll)) {
			
			$recoveryDataOld = $recoveryDataMonthAll;
			$metal = $recoveryData[$con][$key][$conCat[$con][0]];
			$metalId = array_search($metal, array_column($recoveryDataOld[$con], $conCat[$con][0]));
		
			if ($metalId != '') {

				foreach ($conCat[$con] as $recov) {
					if (!in_array($recov, array($conCat[$con][0], 'unit'))) {
						if ($recoveryDataOld[$con][$metalId][$recov] != $val[$recov]) {
							$openQtyDiff = $val[$recov] - $recoveryDataOld[$con][$metalId][$recov];
							$diff[$con][$key][$recov]['title'] = ($openQtyDiff > 0) ? '+'.$openQtyDiff : $openQtyDiff;
							$diff[$con][$key][$recov]['class'] = ' in_new';
						}
					}
				}
				
				unset($row_old_main[$con][$metalId]);

			} else {
				
				foreach ($conCat[$con] as $recov) {
					$diff[$con][$key][$recov]['class'] = ' in_new';
					$diff[$con][$key][$recov]['title'] = 'New record';
				}

			}
		
		}

	}

}

?>

<h5 class="card-title"><?php echo $label['title']; ?></h5>
<div class="position-relative row form-group mine-group">
	<div class="col-sm-12 mine-m-auto">
		<table class="table table-bordered table-sm recovery-table" id="recovery-table">
			<thead class="bg-secondary text-white text-center">
				<tr>
					<th colspan="2"><?php echo $label[0]; ?></th>
					<th colspan="2"><?php echo $label[1]; ?></th>
					<th colspan="2"><?php echo $label[2]; ?></th>
					<th colspan="2"><?php echo $label[3]; ?></th>
					<th colspan="2"><?php echo $label[4]; ?></th>
					<th colspan="3"><?php echo $label[5]; ?></th>
				</tr>
				<tr>
					<th><?php echo $label[6]; ?></th>
					<th><?php echo $label[7]; ?></th>
					<th><?php echo $label[6]; ?></th>
					<th><?php echo $label[7]; ?></th>
					<th><?php echo $label[6]; ?></th>
					<th><?php echo $label[7]; ?></th>
					<th><?php echo $label[6]; ?></th>
					<th><?php echo $label[7]; ?></th>
					<th><?php echo $label[6]; ?></th>
					<th><?php echo $label[7]; ?></th>
					<th><?php echo $label[6]; ?></th>
					<th colspan="2"><?php echo $label[7]; ?></th>
				</tr>
			</thead>
			<tbody class="recovery-table-body">
				<?php foreach($recoveryData['recovery'] as $key=>$val){ $keyN = $key+1; ?>
					<tr class="recovery-table-rw">
						<td>
							<table class="smelter-open-table table table-borderless table-sm">
								<tbody>
									<tr>
										<td>
											<?php echo $this->Form->select('open_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control open_metal metal-box min_width cvOn cvReq'.$diff['recovery'][$key]['open_metal']['class'], 'title'=>$diff['recovery'][$key]['open_metal']['title'], 'value'=>$val['open_metal'], 'id'=>'open_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('open_qty_'.$keyN, array('type'=>'text', 'class'=>'form-control open_qty quantity-txtbox makeNil min_width cvOn cvNum cvReq cvMaxLen'.$diff['recovery'][$key]['open_qty']['class'], 'id'=>'open_qty_'.$keyN, 'title'=>$diff['recovery'][$key]['open_qty']['title'], 'value'=>$val['open_qty'], 'label'=>false, 'maxLength'=>16)); ?>
											<div class="err_cv"></div>
										</td>
										<td></td>
									</tr>
								</tbody>
							</table>
						</td>
						<td>
							<?php echo $this->Form->control('open_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control open_grade grade-txtbox makeNil cvOn cvNum cvReq cvMaxLen'.$diff['recovery'][$key]['open_grade']['class'], 'id'=>'open_grade_'.$keyN, 'title'=>$diff['recovery'][$key]['open_grade']['title'], 'value'=>$val['open_grade'], 'label'=>false, 'maxLength'=>5)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('con_rc_qty_'.$keyN, array('type'=>'text', 'class'=>'form-control con_rc_qty quantity-txtbox makeNil cvOn cvNum cvReq cvMaxLen'.$diff['recovery'][$key]['con_rc_qty']['class'], 'id'=>'con_rc_qty_'.$keyN, 'title'=>$diff['recovery'][$key]['con_rc_qty']['title'], 'value'=>$val['con_rc_qty'], 'label'=>false, 'maxLength'=>16)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('con_rc_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control con_rc_grade grade-txtbox makeNil cvOn cvNum cvReq cvMaxLen'.$diff['recovery'][$key]['con_rc_grade']['class'], 'id'=>'con_rc_grade_'.$keyN, 'title'=>$diff['recovery'][$key]['con_rc_grade']['title'], 'value'=>$val['con_rc_grade'], 'label'=>false, 'maxLength'=>5)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('con_rs_qty_'.$keyN, array('type'=>'text', 'class'=>'form-control con_rs_qty quantity-txtbox makeNil cvOn cvNum cvReq cvMaxLen'.$diff['recovery'][$key]['con_rs_qty']['class'], 'id'=>'con_rs_qty_'.$keyN, 'title'=>$diff['recovery'][$key]['con_rs_qty']['title'], 'value'=>$val['con_rs_qty'], 'label'=>false, 'maxLength'=>16)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('con_rs_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control con_rs_grade grade-txtbox makeNil cvOn cvNum cvReq cvMaxLen'.$diff['recovery'][$key]['con_rs_grade']['class'], 'id'=>'con_rs_grade_'.$keyN, 'title'=>$diff['recovery'][$key]['con_rs_grade']['title'], 'value'=>$val['con_rs_grade'], 'label'=>false, 'maxLength'=>5)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('con_so_qty_'.$keyN, array('type'=>'text', 'class'=>'form-control con_so_qty quantity-txtbox makeNil cvOn cvNum cvReq cvMaxLen'.$diff['recovery'][$key]['con_so_qty']['class'], 'id'=>'con_so_qty_'.$keyN, 'title'=>$diff['recovery'][$key]['con_so_qty']['title'], 'value'=>$val['con_so_qty'], 'label'=>false, 'maxLength'=>16)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('con_so_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control con_so_grade grade-txtbox makeNil cvOn cvNum cvReq cvMaxLen'.$diff['recovery'][$key]['con_so_grade']['class'], 'id'=>'con_so_grade_'.$keyN, 'title'=>$diff['recovery'][$key]['con_so_grade']['title'], 'value'=>$val['con_so_grade'], 'label'=>false, 'maxLength'=>5)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('con_tr_qty_'.$keyN, array('type'=>'text', 'class'=>'form-control con_tr_qty quantity-txtbox makeNil cvOn cvNum cvReq cvMaxLen'.$diff['recovery'][$key]['con_tr_qty']['class'], 'id'=>'con_tr_qty_'.$keyN, 'title'=>$diff['recovery'][$key]['con_tr_qty']['title'], 'value'=>$val['con_tr_qty'], 'label'=>false, 'maxLength'=>16)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('con_tr_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control con_tr_grade grade-txtbox makeNil cvOn cvNum cvReq cvMaxLen'.$diff['recovery'][$key]['con_tr_grade']['class'], 'id'=>'con_tr_grade_'.$keyN, 'title'=>$diff['recovery'][$key]['con_tr_grade']['title'], 'value'=>$val['con_tr_grade'], 'label'=>false, 'maxLength'=>5)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('close_qty_'.$keyN, array('type'=>'text', 'class'=>'form-control close_qty quantity-txtbox makeNil cvOn cvNum cvReq cvMaxLen'.$diff['recovery'][$key]['close_qty']['class'], 'id'=>'close_qty_'.$keyN, 'title'=>$diff['recovery'][$key]['close_qty']['title'], 'value'=>$val['close_qty'], 'label'=>false, 'maxLength'=>16)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('close_value_'.$keyN, array('type'=>'text', 'class'=>'form-control close-value makeNil cvOn cvNum cvReq'.$diff['recovery'][$key]['close_value']['class'], 'id'=>'close_value_'.$keyN, 'title'=>$diff['recovery'][$key]['close_value']['title'], 'value'=>$val['close_value'], 'label'=>false)); ?>
							<div class="err_cv"></div>
						</td>
						<td></td>
					</tr>
				<?php } ?>
				
				<?php 
				// This extra loop is only for showing deleted records in the annual return
				// as compares to monthly return
				// Effective from Phase-II
				// Added on 22nd Nov 2021 by Aniket Ganvir
				foreach($row_old_main['recovery'] as $key=>$val){ $keyN = $key+1;
				?>
					<tr class="recovery-table-rw">
						<td>
							<table class="smelter-open-table table table-borderless table-sm">
								<tbody>
									<tr>
										<td>
											<?php echo $this->Form->select('open_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control open_metal metal-box cvOn cvReq in_old', 'title'=>'Removed record', 'value'=>$val['open_metal'], 'id'=>'open_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('open_qty_'.$keyN, array('type'=>'text', 'class'=>'form-control open_qty quantity-txtbox makeNil cvOn cvNum cvReq cvMaxLen in_old', 'id'=>'open_qty_'.$keyN, 'title'=>'Removed record', 'value'=>$val['open_qty'], 'label'=>false, 'maxLength'=>16)); ?>
											<div class="err_cv"></div>
										</td>
										<td></td>
									</tr>
								</tbody>
							</table>
						</td>
						<td>
							<?php echo $this->Form->control('open_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control open_grade grade-txtbox makeNil cvOn cvNum cvReq cvMaxLen in_old', 'id'=>'open_grade_'.$keyN, 'title'=>'Removed record', 'value'=>$val['open_grade'], 'label'=>false, 'maxLength'=>5)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('con_rc_qty_'.$keyN, array('type'=>'text', 'class'=>'form-control con_rc_qty quantity-txtbox makeNil cvOn cvNum cvReq cvMaxLen in_old', 'id'=>'con_rc_qty_'.$keyN, 'title'=>'Removed record', 'value'=>$val['con_rc_qty'], 'label'=>false, 'maxLength'=>16)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('con_rc_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control con_rc_grade grade-txtbox makeNil cvOn cvNum cvReq cvMaxLen in_old', 'id'=>'con_rc_grade_'.$keyN, 'title'=>'Removed record', 'value'=>$val['con_rc_grade'], 'label'=>false, 'maxLength'=>5)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('con_rs_qty_'.$keyN, array('type'=>'text', 'class'=>'form-control con_rs_qty quantity-txtbox makeNil cvOn cvNum cvReq cvMaxLen in_old', 'id'=>'con_rs_qty_'.$keyN, 'title'=>'Removed record', 'value'=>$val['con_rs_qty'], 'label'=>false, 'maxLength'=>16)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('con_rs_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control con_rs_grade grade-txtbox makeNil cvOn cvNum cvReq cvMaxLen in_old', 'id'=>'con_rs_grade_'.$keyN, 'title'=>'Removed record', 'value'=>$val['con_rs_grade'], 'label'=>false, 'maxLength'=>5)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('con_so_qty_'.$keyN, array('type'=>'text', 'class'=>'form-control con_so_qty quantity-txtbox makeNil cvOn cvNum cvReq cvMaxLen in_old', 'id'=>'con_so_qty_'.$keyN, 'title'=>'Removed record', 'value'=>$val['con_so_qty'], 'label'=>false, 'maxLength'=>16)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('con_so_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control con_so_grade grade-txtbox makeNil cvOn cvNum cvReq cvMaxLen in_old', 'id'=>'con_so_grade_'.$keyN, 'title'=>'Removed record', 'value'=>$val['con_so_grade'], 'label'=>false, 'maxLength'=>5)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('con_tr_qty_'.$keyN, array('type'=>'text', 'class'=>'form-control con_tr_qty quantity-txtbox makeNil cvOn cvNum cvReq cvMaxLen in_old', 'id'=>'con_tr_qty_'.$keyN, 'title'=>'Removed record', 'value'=>$val['con_tr_qty'], 'label'=>false, 'maxLength'=>16)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('con_tr_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control con_tr_grade grade-txtbox makeNil cvOn cvNum cvReq cvMaxLen in_old', 'id'=>'con_tr_grade_'.$keyN, 'title'=>'Removed record', 'value'=>$val['con_tr_grade'], 'label'=>false, 'maxLength'=>5)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('close_qty_'.$keyN, array('type'=>'text', 'class'=>'form-control close_qty quantity-txtbox makeNil cvOn cvNum cvReq cvMaxLen in_old', 'id'=>'close_qty_'.$keyN, 'title'=>'Removed record', 'value'=>$val['close_qty'], 'label'=>false, 'maxLength'=>16)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('close_value_'.$keyN, array('type'=>'text', 'class'=>'form-control close-value makeNil cvOn cvNum cvReq in_old', 'id'=>'close_value_'.$keyN, 'title'=>'Removed record', 'value'=>$val['close_value'], 'label'=>false)); ?>
							<div class="err_cv"></div>
						</td>
						<td></td>
					</tr>
				<?php } ?>

			</tbody>
			<thead>
				<tr>
					<td colspan="14">
						<?php echo $this->Form->button('<i class="fa fa-plus"></i> '.$label['btn'], array('type'=>'button', 'id'=>'recovery_add_btn', 'class'=>'btn btn-sm btn-info f5-add-more-btn form_btn_edit', 'escapeTitle'=>false)); ?>
					</td>
				<tr>
			</thead>
		</table>

		<table class="table table-bordered table-sm f5-smelter-metal-table" id="smelt_reco_tab_2">
			<thead class="bg-secondary text-white text-center">
				<tr>
					<th colspan="3"><?php echo $label[9]; ?></th>
					<th colspan="3"><?php echo $label[10]; ?></th>
				</tr>
				<tr>
					<th><?php echo $label[11]; ?></th>
					<th><?php echo $label[12]; ?></th>
					<th><?php echo $label[13]; ?></th>
					<th><?php echo $label[11]; ?></th>
					<th><?php echo $label[12]; ?></th>
					<th><?php echo $label[13]; ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<!--METAL RECOVERED TABLE-->
					<td>
						<table id="con_metal_table" class="f5-rom-sub-table table table-borderless table-sm">
							<tbody>
								<?php foreach($recoveryData['con_metal'] as $key=>$val){ $keyN = $key+1; ?>
									<tr>
										<td>
											<?php echo $this->Form->select('rc_metal_'.$keyN, $products, array('empty'=>'- Select -','class'=>'form-control rc-metal metal-box cvOn cvReq'.$diff['con_metal'][$key]['rc_metal']['class'], 'title'=>$diff['con_metal'][$key]['rc_metal']['title'], 'value'=>$val['rc_metal'], 'id'=>'rc_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('rc_qty_'.$keyN, array('type'=>'text', 'class'=>'form-control rc-qty cvOn cvNum cvReq cvMaxLen'.$diff['con_metal'][$key]['rc_qty']['class'], 'title'=>$diff['con_metal'][$key]['rc_qty']['title'], 'id'=>'rc_qty_'.$keyN, 'value'=>$val['rc_qty'], 'label'=>false, 'maxLength'=>'16')); ?>
											<div class="err_cv"></div>
										</td>
									</tr>
								<?php } ?>
								
								<?php 
								// This extra loop is only for showing deleted records in the annual return
								// as compares to monthly return
								// Effective from Phase-II
								// Added on 23rd Nov 2021 by Aniket Ganvir
								foreach($row_old_main['con_metal'] as $key=>$val){ $keyN = $key+1;
								?>
									<tr>
										<td>
											<?php echo $this->Form->select('rc_metal_'.$keyN, $products, array('empty'=>'- Select -','class'=>'form-control rc-metal metal-box cvOn cvReq in_old', 'title'=>'Removed record', 'value'=>$val['rc_metal'], 'id'=>'rc_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('rc_qty_'.$keyN, array('type'=>'text', 'class'=>'form-control rc-qty cvOn cvNum cvReq cvMaxLen in_old', 'title'=>'Removed record', 'id'=>'rc_qty_'.$keyN, 'value'=>$val['rc_qty'], 'label'=>false, 'maxLength'=>'16')); ?>
											<div class="err_cv"></div>
										</td>
									</tr>
								<?php } ?>

							</tbody>
						</table>
						<?php echo $this->Form->control('con_metal_count', array('type'=>'hidden', 'id'=>'con_metal_count')); ?>
					</td>
					<td>
						<table id="con_grade_table" class="f5-rom-sub-table table table-borderless">
							<tbody>

								<?php foreach($recoveryData['con_metal'] as $key=>$val){ $keyN = $key+1; ?>
									<tr>
										<td>
											<?php echo $this->Form->control('rc_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control rc-grade cvOn cvNum cvReq cvMaxLen'.$diff['con_metal'][$key]['rc_grade']['class'], 'title'=>$diff['con_metal'][$key]['rc_grade']['title'], 'id'=>'rc_grade_'.$keyN, 'value'=>$val['rc_grade'], 'label'=>false, 'maxLength'=>'5')); ?>
											<div class="err_cv"></div>
										</td>
									</tr>
								<?php } ?>
								
								<?php 
								// This extra loop is only for showing deleted records in the annual return
								// as compares to monthly return
								// Effective from Phase-II
								// Added on 23rd Nov 2021 by Aniket Ganvir
								foreach($row_old_main['con_metal'] as $key=>$val){ $keyN = $key+1;
								?>
									<tr>
										<td>
											<?php echo $this->Form->control('rc_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control rc-grade cvOn cvNum cvReq cvMaxLen in_old', 'title'=>'Removed record', 'id'=>'rc_grade_'.$keyN, 'value'=>$val['rc_grade'], 'label'=>false, 'maxLength'=>'5')); ?>
											<div class="err_cv"></div>
										</td>
									</tr>
								<?php } ?>

							</tbody>
						</table>
					</td>
					<td>
						<table id="con_metal_value_table" class="f5-rom-sub-table table table-borderless">
							<tbody>
								<?php foreach($recoveryData['con_metal'] as $key=>$val){ $keyN = $key+1; ?>
									<tr>
										<td>
											<?php echo $this->Form->control('rc_value_'.$keyN, array('type'=>'text', 'class'=>'form-control rc-value cvOn cvNum cvReq cvMaxLen'.$diff['con_metal'][$key]['rc_value']['class'], 'title'=>$diff['con_metal'][$key]['rc_value']['title'], 'id'=>'rc_value_'.$keyN, 'value'=>$val['rc_value'], 'label'=>false, 'maxLength'=>'20')); ?>
											<div class="err_cv"></div>
										</td>
										<td></td>
									</tr>
								<?php } ?>
								
								<?php 
								// This extra loop is only for showing deleted records in the annual return
								// as compares to monthly return
								// Effective from Phase-II
								// Added on 23rd Nov 2021 by Aniket Ganvir
								foreach($row_old_main['con_metal'] as $key=>$val){ $keyN = $key+1;
								?>
									<tr>
										<td>
											<?php echo $this->Form->control('rc_value_'.$keyN, array('type'=>'text', 'class'=>'form-control rc-value cvOn cvNum cvReq cvMaxLen in_old', 'title'=>'Removed record', 'id'=>'rc_value_'.$keyN, 'value'=>$val['rc_value'], 'label'=>false, 'maxLength'=>'20')); ?>
											<div class="err_cv"></div>
										</td>
										<td></td>
									</tr>
								<?php } ?>

							</tbody>
						</table>
					</td>

					<!--BY PRODUCT TABLE-->
					<td>
						<table id="byproduct_table" class="f5-rom-sub-table table table-borderless table-sm">
							<tbody>
								<?php foreach($recoveryData['by_product'] as $key=>$val){ $keyN = $key+1; ?>
									<tr>
										<td>
											<?php echo $this->Form->select('rc_byproduct_prod_'.$keyN, $products, array('empty'=>'- Select -','class'=>'form-control rc-byproduct-prod metal-box cvOn cvReq'.$diff['by_product'][$key]['bp_metal']['class'], 'title'=>$diff['by_product'][$key]['bp_metal']['title'], 'value'=>$val['bp_metal'], 'id'=>'rc_byproduct_prod_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('rc_byproduct_qty_'.$keyN, array('type'=>'text', 'class'=>'form-control rc-byproduct-qty cvOn cvNum cvReq cvMaxLen'.$diff['by_product'][$key]['bp_qty']['class'], 'title'=>$diff['by_product'][$key]['bp_qty']['title'], 'value'=>$val['bp_qty'], 'id'=>'rc_byproduct_qty_'.$keyN, 'value'=>$val['bp_qty'], 'label'=>false, 'maxLength'=>'16')); ?>
											<div class="err_cv"></div>
										</td>
									</tr>
								<?php } ?>
								
								<?php 
								// This extra loop is only for showing deleted records in the annual return
								// as compares to monthly return
								// Effective from Phase-II
								// Added on 23rd Nov 2021 by Aniket Ganvir
								foreach($row_old_main['by_product'] as $key=>$val){ $keyN = $key+1;
								?>
									<tr>
										<td>
											<?php echo $this->Form->select('rc_byproduct_prod_'.$keyN, $products, array('empty'=>'- Select -','class'=>'form-control rc-byproduct-prod metal-box cvOn cvReq in_old', 'title'=>'Removed record', 'value'=>$val['bp_metal'], 'id'=>'rc_byproduct_prod_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('rc_byproduct_qty_'.$keyN, array('type'=>'text', 'class'=>'form-control rc-byproduct-qty cvOn cvNum cvReq cvMaxLen in_old', 'title'=>'Removed record', 'value'=>$val['bp_qty'], 'id'=>'rc_byproduct_qty_'.$keyN, 'value'=>$val['bp_qty'], 'label'=>false, 'maxLength'=>'16')); ?>
											<div class="err_cv"></div>
										</td>
									</tr>
								<?php } ?>

							</tbody>
						</table>
						<?php echo $this->Form->control('byproduct_metal_count', array('type'=>'hidden', 'id'=>'byproduct_count')); ?>
					</td>
					<td>
						<table id="byproduct_grade_table" class="f5-rom-sub-table table table-borderless table-sm">
							<tbody>
								<?php foreach($recoveryData['by_product'] as $key=>$val){ $keyN = $key+1; ?>
									<tr>
										<td>
											<?php echo $this->Form->control('rc_byproduct_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control rc-byproduct-grade cvOn cvNum cvReq cvMaxLen'.$diff['by_product'][$key]['bp_grade']['class'], 'title'=>$diff['by_product'][$key]['bp_grade']['title'], 'id'=>'rc_byproduct_grade_'.$keyN, 'value'=>$val['bp_grade'], 'label'=>false, 'maxLength'=>'5')); ?>
											<div class="err_cv"></div>
										</td>
									</tr>
								<?php } ?>
								
								<?php 
								// This extra loop is only for showing deleted records in the annual return
								// as compares to monthly return
								// Effective from Phase-II
								// Added on 23rd Nov 2021 by Aniket Ganvir
								foreach($row_old_main['by_product'] as $key=>$val){ $keyN = $key+1;
								?>
									<tr>
										<td>
											<?php echo $this->Form->control('rc_byproduct_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control rc-byproduct-grade cvOn cvNum cvReq cvMaxLen in_old', 'title'=>'Removed record', 'id'=>'rc_byproduct_grade_'.$keyN, 'value'=>$val['bp_grade'], 'label'=>false, 'maxLength'=>'5')); ?>
											<div class="err_cv"></div>
										</td>
									</tr>
								<?php } ?>

							</tbody>
						</table>
					</td>
					<td>
						<table id="byproduct_value_table" class="f5-rom-sub-table table table-borderless table-sm">
							<tbody>
								<?php foreach($recoveryData['by_product'] as $key=>$val){ $keyN = $key+1; ?>
									<tr>
										<td>
											<?php echo $this->Form->control('rc_byproduct_value_'.$keyN, array('type'=>'text', 'class'=>'form-control rc-byproduct-value cvOn cvNum cvReq cvMaxLen'.$diff['by_product'][$key]['bp_value']['class'], 'title'=>$diff['by_product'][$key]['bp_value']['title'], 'id'=>'rc_byproduct_value_'.$keyN, 'value'=>$val['bp_value'], 'label'=>false, 'maxLength'=>'16')); ?>
											<div class="err_cv"></div>
										</td>
										<td></td>
									</tr>
								<?php } ?>
								
								<?php 
								// This extra loop is only for showing deleted records in the annual return
								// as compares to monthly return
								// Effective from Phase-II
								// Added on 23rd Nov 2021 by Aniket Ganvir
								foreach($row_old_main['by_product'] as $key=>$val){ $keyN = $key+1;
								?>
									<tr>
										<td>
											<?php echo $this->Form->control('rc_byproduct_value_'.$keyN, array('type'=>'text', 'class'=>'form-control rc-byproduct-value cvOn cvNum cvReq cvMaxLen in_old', 'title'=>'Removed record', 'id'=>'rc_byproduct_value_'.$keyN, 'value'=>$val['bp_value'], 'label'=>false, 'maxLength'=>'16')); ?>
											<div class="err_cv"></div>
										</td>
										<td></td>
									</tr>
								<?php } ?>

							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<?php echo $this->Form->button('<i class="fa fa-plus"></i> '.$label['btn'], array('type'=>'button', 'id'=>'con_metal_add_btn', 'class'=>'btn btn-sm btn-info f5-add-more-btn form_btn_edit', 'escapeTitle'=>false)); ?>
					</td>
					<td colspan="3">
						<?php echo $this->Form->button('<i class="fa fa-plus"></i> '.$label['btn'], array('type'=>'button', 'id'=>'byproduct_add_btn', 'class'=>'btn btn-sm btn-info f5-add-more-btn form_btn_edit', 'escapeTitle'=>false)); ?>
					</td>
				<tr>
				<tr>
					<td colspan="6">
						<div class="alert alert-info p-2 pl-3"><?php echo $label['note']; ?></div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<?php echo $this->Form->control('form_no', array('type'=>'hidden', 'value'=>$formId)); ?>
<?php echo $this->Form->control('mine_code', array('type'=>'hidden', 'value'=>$mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType)); ?>
<?php echo $this->Form->control('return_date', array('type'=>'hidden', 'value'=>$returnDate)); ?>
<?php echo $this->Form->control('mineral_name', array('type'=>'hidden', 'value'=>$mineral)); ?>

<?php echo $this->Form->control('recovery_count', array('type'=>'hidden', 'id'=>'recovery_count')); ?>
<?php echo $this->Form->control('smelter_error_check', array('type'=>'hidden', 'id'=>'smelter_error_check', 'class'=>'smelter_error_check', 'value'=>'0')); ?>
<?php echo $this->Form->control('', array('type'=>'hidden','id'=>'form_id_name', 'label'=>false, 'value'=>'frmSmeltReco')); ?>

<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'open_metal_row', 'value'=>$this->Form->select("open_metal_rowcc", $metals, array("empty"=>"- Select -","class"=>"form-control open_metal min_width metal-box cvOn cvReq", "id"=>"open_metal_rowcc"))]); ?>
<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'rc_metal_row', 'value'=>$this->Form->select("rc_metal_rowcc", $products, array("empty"=>"- Select -","class"=>"form-control rc-metal metal-box cvOn cvReq", "id"=>"rc_metal_rowcc"))]); ?>
<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'rc_byproduct_prod_row', 'value'=>$this->Form->select("rc_byproduct_prod_rowcc", $products, array("empty"=>"- Select -","class"=>"form-control rc-byproduct-prod metal-box cvOn cvReq", "id"=>"rc_byproduct_prod_rowcc"))]); ?>

<?php echo $this->Html->script('f/smelt_reco.js?version='.$version); ?>
