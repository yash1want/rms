
<?php 

// Highlight fields which are differs from cumulative monthly data in annual
// (Only for Form G2 in MMS side)
// Effective from Phase-II
// Added on 22nd Nov 2021 by Aniket Ganvir

$row_old_main = (isset($conRomDataMonthAll)) ? $conRomDataMonthAll : array('rom'=>array('10'=>array('metal'=>array()),'11'=>array('metal'=>array()),'12'=>array('metal'=>array()),'14'=>array('metal'=>array())),'con'=>array('13'=>array('metal'=>array(),'grade'=>array(),'con_value'=>array()),'15'=>array('metal'=>array(),'grade'=>array())));
for ($i=10; $i<=15; $i++) {
	
	$romIds = array('10', '11', '12', '14');
	if (in_array($i, $romIds)) {
		
		foreach ($conRomData['rom'][$i]['metal'] as $key=>$val) {

			if ($key == 0) {
				$diff['rom'][$i]['tot_qty'][0]['class'] = '';
				$diff['rom'][$i]['tot_qty'][0]['title'] = '';
			}
				
			$diff['rom'][$i]['metal'][$key]['class'] = '';
			$diff['rom'][$i]['metal'][$key]['title'] = '';
			$diff['rom'][$i]['grade'][$key]['class'] = '';
			$diff['rom'][$i]['grade'][$key]['title'] = '';
			
			if (isset($conRomDataMonthAll)) {
				
				if ($key == 0) {
					$conRomDataOld = $conRomDataMonthAll;
					$totQtyOld = $conRomDataOld['rom'][$i]['tot_qty'][0];
					$totQtyNew = $conRomData['rom'][$i]['tot_qty'][0];
					if ($totQtyOld != $totQtyNew) {
						$totQtyDiff = (float)$totQtyNew - (float)$totQtyOld; 
						$diff['rom'][$i]['tot_qty'][0]['title'] = ($totQtyDiff > 0) ? '+'.$totQtyDiff : $totQtyDiff;
						$diff['rom'][$i]['tot_qty'][0]['class'] = ' in_new';
					}
				}

				$metal = $conRomData['rom'][$i]['metal'][$key];
				$metalId = array_search($metal, $conRomDataOld['rom'][$i]['metal']);
			
				if ($metalId != '') {

					if ($conRomDataOld['rom'][$i]['grade'][$metalId] != $conRomData['rom'][$i]['grade'][$key]) {
						$metalDiff = $conRomData['rom'][$i]['grade'][$key] - $conRomDataOld['rom'][$i]['grade'][$metalId];
						$diff['rom'][$i]['grade'][$key]['title'] = ($metalDiff > 0) ? '+'.$metalDiff : $metalDiff;
						$diff['rom'][$i]['grade'][$key]['class'] = ' in_new';
					}
					
					unset($row_old_main['rom'][$i]['table'][$metalId]);
					unset($row_old_main['rom'][$i]['tot_qty'][$metalId]);
					unset($row_old_main['rom'][$i]['metal'][$metalId]);
					unset($row_old_main['rom'][$i]['grade'][$metalId]);

				} else {
					
					$diff['rom'][$i]['metal'][$key]['class'] = ' in_new';
					$diff['rom'][$i]['metal'][$key]['title'] = 'New record';
					$diff['rom'][$i]['grade'][$key]['class'] = ' in_new';
					$diff['rom'][$i]['grade'][$key]['title'] = 'New record';
				}
			
			}

		}

	}
	
	$conIds = array('13', '15');
	if (in_array($i, $conIds)) {
		
		foreach ($conRomData['con'][$i]['metal'] as $key=>$val) {
				
			$diff['con'][$i]['tot_qty'][$key]['class'] = '';
			$diff['con'][$i]['tot_qty'][$key]['title'] = '';
			$diff['con'][$i]['metal'][$key]['class'] = '';
			$diff['con'][$i]['metal'][$key]['title'] = '';
			$diff['con'][$i]['grade'][$key]['class'] = '';
			$diff['con'][$i]['grade'][$key]['title'] = '';
			$diff['con'][$i]['con_value'][$key]['class'] = '';
			$diff['con'][$i]['con_value'][$key]['title'] = '';
			
			if (isset($conRomDataMonthAll)) {
				
				$conRomDataOld = $conRomDataMonthAll;
				$totQtyOld = $conRomDataOld['con'][$i]['tot_qty'][0];
				$totQtyNew = $conRomData['con'][$i]['tot_qty'][0];
				if ($totQtyOld != $totQtyNew) {
					$totQtyDiff = (float)$totQtyNew - (float)$totQtyOld; 
					$diff['con'][$i]['tot_qty'][0]['title'] = ($totQtyDiff > 0) ? '+'.$totQtyDiff : $totQtyDiff;
					$diff['con'][$i]['tot_qty'][0]['class'] = ' in_new';
				}

				$metal = $conRomData['con'][$i]['metal'][$key];
				$metalId = array_search($metal, $conRomDataOld['con'][$i]['metal']);
			
				if ($metalId != '') {

					if ($conRomDataOld['con'][$i]['grade'][$metalId] != $conRomData['con'][$i]['grade'][$key]) {
						$metalDiff = $conRomData['con'][$i]['grade'][$key] - $conRomDataOld['con'][$i]['grade'][$metalId];
						$diff['con'][$i]['grade'][$key]['title'] = ($metalDiff > 0) ? '+'.$metalDiff : $metalDiff;
						$diff['con'][$i]['grade'][$key]['class'] = ' in_new';
					}
					
					if ($conRomDataOld['con'][$i]['tot_qty'][$metalId] != $conRomData['con'][$i]['tot_qty'][$key]) {
						$totQtyDiff = $conRomData['con'][$i]['tot_qty'][$key] - $conRomDataOld['con'][$i]['tot_qty'][$metalId];
						$diff['con'][$i]['tot_qty'][$key]['title'] = ($totQtyDiff > 0) ? '+'.$totQtyDiff : $totQtyDiff;
						$diff['con'][$i]['tot_qty'][$key]['class'] = ' in_new';
					}
					
					if ($conRomDataOld['con'][$i]['con_value'][$metalId] != $conRomData['con'][$i]['con_value'][$key]) {
						$totQtyDiff = $conRomData['con'][$i]['con_value'][$key] - $conRomDataOld['con'][$i]['con_value'][$metalId];
						$diff['con'][$i]['con_value'][$key]['title'] = ($totQtyDiff > 0) ? '+'.$totQtyDiff : $totQtyDiff;
						$diff['con'][$i]['con_value'][$key]['class'] = ' in_new';
					}
					
					unset($row_old_main['con'][$i]['table'][$metalId]);
					unset($row_old_main['con'][$i]['tot_qty'][$metalId]);
					unset($row_old_main['con'][$i]['metal'][$metalId]);
					unset($row_old_main['con'][$i]['grade'][$metalId]);
					unset($row_old_main['con'][$i]['con_value'][$metalId]);

				} else {
					
					$diff['con'][$i]['metal'][$key]['class'] = ' in_new';
					$diff['con'][$i]['metal'][$key]['title'] = 'New record';
					$diff['con'][$i]['grade'][$key]['class'] = ' in_new';
					$diff['con'][$i]['grade'][$key]['title'] = 'New record';
					$diff['con'][$i]['con_value'][$key]['class'] = ' in_new';
					$diff['con'][$i]['con_value'][$key]['title'] = 'New record';
					$diff['con'][$i]['tot_qty'][$key]['class'] = ' in_new';
					$diff['con'][$i]['tot_qty'][$key]['title'] = 'New record';
				}
			
			}

		}

	}
	
}

?>

<h5 class="card-title"><?php echo $label['title']; ?></h5>
<div class="position-relative row form-group mine-group">
	<div class="col-sm-12 mine-m-auto">
		<table class="table table-bordered table-sm v_a_mid_th" id="mTable">
			<thead class="bg-secondary text-white text-center">
				<tr>
					<th colspan="2"><?php echo $label[0]; ?></th>
					<th colspan="2"><?php echo $label[1]; ?></th>
					<th colspan="2"><?php echo $label[2]; ?></th>
				</tr>
				<tr>
					<th><?php echo $label[3]; ?></th>
					<th><?php echo $label[4]; ?></th>
					<th><?php echo $label[3]; ?></th>
					<th><?php echo $label[4]; ?></th>
					<th><?php echo $label[3]; ?></th>
					<th><?php echo $label[4]; ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<!-- SECTION 1 : OPENING STOCKS OF THE ORE AT CONCENTRATOR/PLANT -->
					<td>
						<?php echo $this->Form->control('open_ore_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields rom-quantity-txtbox cvOn cvReq cvNum cvMaxLen cvFloat'.$diff['rom'][10]['tot_qty'][0]['class'], 'id'=>'open_ore_qty', 'label'=>false, 'title'=>$diff['rom'][10]['tot_qty'][0]['title'], 'value'=>$conRomData['rom'][10]['tot_qty'][0], 'maxLength'=>16, 'cvfloat'=>'999999999999.999')); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<table id="open_ore_table" class="f5-rom-sub-table table table-borderless">
							<thead></thead>
							<tbody>
								<?php foreach($conRomData['rom'][10]['metal'] as $key=>$val){ $keyN = $key+1; ?>
									<tr>
										<td>
											<?php echo $this->Form->select('open_ore_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control form-control-sm m_w_70 open_ore_metal metal-box valid cvOn cvReq'.$diff['rom'][10]['metal'][$key]['class'], 'title'=>$diff['rom'][10]['metal'][$key]['title'], 'value'=>$val, 'id'=>'open_ore_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('open_ore_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control form-control-sm open_ore_grade grade-txtbox cvOn cvNum cvReq cvMaxLen'.$diff['rom'][10]['grade'][$key]['class'], 'id'=>'open_ore_grade_'.$keyN, 'title'=>$diff['rom'][10]['grade'][$key]['title'], 'value'=>$conRomData['rom'][10]['grade'][$key], 'label'=>false, 'maxLength'=>'5')); ?>
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
								foreach($row_old_main['rom'][10]['metal'] as $key=>$val){ $keyN = $key+1;
								?>
									<tr>
										<td>
											<?php echo $this->Form->select('open_ore_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control form-control-sm m_w_70 open_ore_metal metal-box valid cvOn cvReq in_old', 'title'=>'Removed record', 'value'=>$val, 'id'=>'open_ore_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('open_ore_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control form-control-sm open_ore_grade grade-txtbox cvOn cvNum cvReq cvMaxLen in_old', 'id'=>'open_ore_grade_'.$keyN, 'title'=>'Removed record', 'value'=>$row_old_main['rom'][10]['grade'][$key], 'label'=>false, 'maxLength'=>'5')); ?>
											<div class="err_cv"></div>
										</td>
										<td></td>
									</tr>
								<?php } ?>
							</tbody>
							<thead>
								<tr>
									<th colspan="3">
										<?php echo $this->Form->button('<i class="fa fa-plus"></i> '.$label['btn'], array('type'=>'button', 'id'=>'btn-add-1', 'class'=>'btn btn-sm btn-info form_btn_edit', 'escapeTitle'=>false)); ?>
									</th>
								</tr>
							</thead>
						</table>
						<?php echo $this->Form->control('open_ore_metal_count', array('type'=>'hidden', 'id'=>'open_ore_metal_count', 'label'=>false)); ?>
					</td>

					<!-- SECTION 2 : ORE RECEIVED FROM THE MINE -->
					<td>
						<?php echo $this->Form->control('rec_ore_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields rom-quantity-txtbox cvOn cvReq cvMaxLen cvFloat'.$diff['rom'][11]['tot_qty'][0]['class'], 'id'=>'rec_ore_qty', 'label'=>false, 'title'=>$diff['rom'][11]['tot_qty'][0]['title'], 'value'=>$conRomData['rom'][11]['tot_qty'][0], 'maxLength'=>16, 'cvfloat'=>'999999999999.999')); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<table id="rec_ore_table" class="f5-rom-sub-table table table-borderless">
							<thead></thead>
							<tbody>
								<?php foreach($conRomData['rom'][11]['metal'] as $key=>$val){ $keyN = $key+1; ?>
									<tr>
										<td>
											<?php echo $this->Form->select('rec_ore_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control form-control-sm m_w_70 rec_ore_metal metal-box cvOn cvReq'.$diff['rom'][11]['metal'][$key]['class'], 'title'=>$diff['rom'][11]['metal'][$key]['title'], 'value'=>$val, 'id'=>'rec_ore_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('rec_ore_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control form-control-sm rec_ore_grade grade-txtbox cvOn cvNum cvReq cvMaxLen'.$diff['rom'][11]['grade'][$key]['class'], 'id'=>'rec_ore_grade_'.$keyN, 'title'=>$diff['rom'][11]['grade'][$key]['title'], 'value'=>$conRomData['rom'][11]['grade'][$key], 'label'=>false, 'maxLength'=>'5')); ?>
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
								foreach($row_old_main['rom'][11]['metal'] as $key=>$val){ $keyN = $key+1;
								?>
									<tr>
										<td>
											<?php echo $this->Form->select('rec_ore_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control form-control-sm m_w_70 rec_ore_metal metal-box cvOn cvReq in_old', 'title'=>'Removed record', 'value'=>$val, 'id'=>'rec_ore_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('rec_ore_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control form-control-sm rec_ore_grade grade-txtbox cvOn cvNum cvReq cvMaxLen in_old', 'id'=>'rec_ore_grade_'.$keyN, 'title'=>'Removed record', 'value'=>$row_old_main['rom'][11]['grade'][$key], 'label'=>false, 'maxLength'=>'5')); ?>
											<div class="err_cv"></div>
										</td>
										<td></td>
									</tr>
								<?php } ?>
							</tbody>
							<thead>
								<tr>
									<th colspan="3">
										<?php echo $this->Form->button('<i class="fa fa-plus"></i> '.$label['btn'], array('type'=>'button', 'id'=>'btn-add-2', 'class'=>'btn btn-sm btn-info form_btn_edit', 'escapeTitle'=>false)); ?>
									</th>
								</tr>
							</thead>
						</table>
						<?php echo $this->Form->control('rec_ore_metal_count', array('type'=>'hidden', 'id'=>'rec_ore_metal_count', 'label'=>false)); ?>
					</td>

					<!-- SECTION 3 : ORE TREATED  --> 
					<td>
						<?php echo $this->Form->control('treat_ore_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields rom-quantity-txtbox cvOn cvReq cvNum cvMaxLen cvFloat'.$diff['rom'][12]['tot_qty'][0]['class'], 'id'=>'treat_ore_qty', 'label'=>false, 'title'=>$diff['rom'][12]['tot_qty'][0]['title'], 'value'=>$conRomData['rom'][12]['tot_qty'][0], 'maxLength'=>16, 'cvfloat'=>'999999999999.999')); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<table id="treat_ore_table" class="f5-rom-sub-table table table-borderless">
							<thead></thead>
							<tbody>
								<?php foreach($conRomData['rom'][12]['metal'] as $key=>$val){ $keyN = $key+1; ?>
									<tr>
										<td>
											<?php echo $this->Form->select('treat_ore_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control form-control-sm m_w_70 treat_ore_metal metal-box cvOn cvReq'.$diff['rom'][12]['metal'][$key]['class'], 'title'=>$diff['rom'][12]['metal'][$key]['title'], 'value'=>$val, 'id'=>'treat_ore_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('treat_ore_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control form-control-sm treat_ore_grade grade-txtbox cvOn cvNum cvReq cvMaxLen'.$diff['rom'][12]['grade'][$key]['class'], 'id'=>'treat_ore_grade_'.$keyN, 'title'=>$diff['rom'][12]['grade'][$key]['title'], 'value'=>$conRomData['rom'][12]['grade'][$key], 'label'=>false, 'maxLength'=>'5')); ?>
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
								foreach($row_old_main['rom'][12]['metal'] as $key=>$val){ $keyN = $key+1;
								?>
									<tr>
										<td>
											<?php echo $this->Form->select('treat_ore_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control form-control-sm m_w_70 treat_ore_metal metal-box cvOn cvReq in_old', 'title'=>'Removed record', 'value'=>$val, 'id'=>'treat_ore_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('treat_ore_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control form-control-sm treat_ore_grade grade-txtbox cvOn cvNum cvReq cvMaxLen in_old', 'id'=>'treat_ore_grade_'.$keyN, 'title'=>'Removed record', 'value'=>$row_old_main['rom'][12]['grade'][$key], 'label'=>false, 'maxLength'=>'5')); ?>
											<div class="err_cv"></div>
										</td>
										<td></td>
									</tr>
								<?php } ?>
							</tbody>
							<thead>
								<tr>
									<th colspan="3">
										<?php echo $this->Form->button('<i class="fa fa-plus"></i> '.$label['btn'], array('type'=>'button', 'id'=>'btn-add-3', 'class'=>'btn btn-sm btn-info form_btn_edit', 'escapeTitle'=>false)); ?>
									</th>
								</tr>
							</thead>
						</table>
						<?php echo $this->Form->control('treat_ore_metal_count', array('type'=>'hidden', 'id'=>'treat_ore_metal_count', 'label'=>false)); ?>
					</td>
				</tr>
			</tbody>
		</table>

		<table class="table table-bordered table-sm v_a_mid_th" id="con_reco_tab_2">
			<thead class="bg-secondary text-white text-center">
				<tr>
					<th colspan="3"><?php echo $label[5]; ?></th>
					<th colspan="2"><?php echo $label[6]; ?></th>
					<th colspan="2"><?php echo $label[7]; ?></th>
				</tr>
				<tr>
					<th><?php echo $label[8]; ?></th>
					<th class="w_p_8"><?php echo $label[9]; ?></th>
					<th class="w_p_12"><?php echo $label[10]; ?></th>
					<th><?php echo $label[8]; ?></th>
					<th><?php echo $label[9]; ?></th>
					<th><?php echo $label[8]; ?></th>
					<th class="w_p_10"><?php echo $label[9]; ?></th>
				</tr>
			</thead>
				<tr>
					<!-- SECTION 4 : CONCENTRATES * OBTAINED  -->
					<td>
						<table id="con_obt_table" class="f5-rom-sub-table table table-borderless">
							<tbody>
								<?php foreach($conRomData['con'][13]['metal'] as $key=>$val){ $keyN = $key+1; ?>
									<tr>
										<td>
											<?php echo $this->Form->select('con_obt_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control form-control-sm m_w_70 con_obt_metal metal-box cvOn cvReq'.$diff['con'][13]['metal'][$key]['class'], 'title'=>$diff['con'][13]['metal'][$key]['title'], 'value'=>$val, 'id'=>'con_obt_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('con_obt_quantity_'.$keyN, array('type'=>'text', 'class'=>'form-control form-control-sm con_obt_quantity quantity-txtbox cvOn cvNum cvReq cvMaxLen'.$diff['con'][13]['tot_qty'][$key]['class'], 'id'=>'con_obt_quantity_'.$keyN, 'title'=>$diff['con'][13]['tot_qty'][$key]['title'], 'value'=>$conRomData['con'][13]['tot_qty'][$key], 'label'=>false, 'maxLength'=>'16')); ?>
											<div class="err_cv"></div>
										</td>
									</tr>
								<?php } ?>
								
								<?php 
								// This extra loop is only for showing deleted records in the annual return
								// as compares to monthly return
								// Effective from Phase-II
								// Added on 22nd Nov 2021 by Aniket Ganvir
								foreach($row_old_main['con'][13]['metal'] as $key=>$val){ $keyN = $key+1;
								?>
									<tr>
										<td>
											<?php echo $this->Form->select('con_obt_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control form-control-sm m_w_70 con_obt_metal metal-box cvOn cvReq in_old', 'title'=>'Removed record', 'value'=>$val, 'id'=>'con_obt_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('con_obt_quantity_'.$keyN, array('type'=>'text', 'class'=>'form-control form-control-sm con_obt_quantity quantity-txtbox cvOn cvNum cvReq cvMaxLen in_old', 'id'=>'con_obt_quantity_'.$keyN, 'title'=>'Removed record', 'value'=>$row_old_main['con'][13]['tot_qty'][$key], 'label'=>false, 'maxLength'=>'16')); ?>
											<div class="err_cv"></div>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
						<?php echo $this->Form->control('con_obt_metal_count', array('type'=>'hidden', 'id'=>'con_obt_metal_count', 'label'=>false)); ?>
					</td>
					<td>
						<table id="con_obt_grade_table" class="f5-rom-sub-table table table-borderless">
							<tbody>
								<?php foreach($conRomData['con'][13]['grade'] as $key=>$val){ $keyN = $key+1; ?>
									<tr>
										<td>
											<?php echo $this->Form->control('con_obt_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control form-control-sm con-obt-grade grade-txtbox cvOn cvReq cvMaxLen'.$diff['con'][13]['grade'][$key]['class'], 'id'=>'con_obt_grade_'.$keyN, 'title'=>$diff['con'][13]['grade'][$key]['title'], 'value'=>$val, 'label'=>false, 'maxLength'=>'5')); ?>
											<div class="err_cv"></div>
										</td>
									</tr>
								<?php } ?>
								
								<?php 
								// This extra loop is only for showing deleted records in the annual return
								// as compares to monthly return
								// Effective from Phase-II
								// Added on 22nd Nov 2021 by Aniket Ganvir
								foreach($row_old_main['con'][13]['grade'] as $key=>$val){ $keyN = $key+1;
								?>
									<tr>
										<td>
											<?php echo $this->Form->control('con_obt_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control form-control-sm con-obt-grade grade-txtbox cvOn cvReq cvMaxLen in_old', 'id'=>'con_obt_grade_'.$keyN, 'title'=>'Removed record', 'value'=>$val, 'label'=>false, 'maxLength'=>'5')); ?>
											<div class="err_cv"></div>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</td>
					<td>
						<table id="con_obt_metal_value_table" class="f5-rom-sub-table table table-borderless">
							<tbody>
								<?php foreach($conRomData['con'][13]['con_value'] as $key=>$val){ $keyN = $key+1; ?>
									<tr>
										<td>
											<?php echo $this->Form->control('con_obt_metal_value_'.$keyN, array('type'=>'text', 'class'=>'form-control form-control-sm metal-value-txtbox cvOn cvReq cvMaxLen'.$diff['con'][13]['con_value'][$key]['class'], 'id'=>'con_obt_metal_value_'.$keyN, 'title'=>$diff['con'][13]['con_value'][$key]['title'], 'value'=>$val, 'label'=>false, 'maxLength'=>'16')); ?>
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
								foreach($row_old_main['con'][13]['con_value'] as $key=>$val){ $keyN = $key+1;
								?>
									<tr>
										<td>
											<?php echo $this->Form->control('con_obt_metal_value_'.$keyN, array('type'=>'text', 'class'=>'form-control form-control-sm metal-value-txtbox cvOn cvReq cvMaxLen in_old', 'id'=>'con_obt_metal_value_'.$keyN, 'title'=>'Removed record', 'value'=>$val, 'label'=>false, 'maxLength'=>'16')); ?>
											<div class="err_cv"></div>
										</td>
										<td></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</td>

					<!-- SECTION 5 : TAILINGS  -->
					<td>
						<?php echo $this->Form->control('tail_ore_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields rom-quantity-txtbox', 'id'=>'tail_ore_qty cvOn cvReq cvNum cvMaxLen cvFloat'.$diff['rom'][14]['tot_qty'][0]['class'], 'label'=>false, 'title'=>$diff['rom'][14]['tot_qty'][0]['title'], 'value'=>$conRomData['rom'][14]['tot_qty'][0], 'maxLength'=>16, 'cvfloat'=>'999999999999.999')); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<table id="tail_ore_table" class="f5-rom-sub-table table table-borderless">
							<tbody>
								<?php foreach($conRomData['rom'][14]['metal'] as $key=>$val){ $keyN = $key+1; ?>
									<tr>
										<td>
											<?php echo $this->Form->select('tail_ore_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control form-control-sm m_w_70 tail_ore_metal metal-box cvOn cvReq'.$diff['rom'][14]['metal'][$key]['class'], 'title'=>$diff['rom'][14]['metal'][$key]['title'], 'value'=>$val, 'id'=>'tail_ore_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('tail_ore_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control form-control-sm tail_ore_grade grade-txtbox cvOn cvNum cvReq cvMaxLen'.$diff['rom'][14]['grade'][$key]['class'], 'id'=>'tail_ore_grade_'.$keyN, 'title'=>$diff['rom'][14]['grade'][$key]['title'], 'value'=>$conRomData['rom'][14]['grade'][$key], 'label'=>false, 'maxLength'=>'5')); ?>
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
								foreach($row_old_main['rom'][14]['metal'] as $key=>$val){ $keyN = $key+1;
								?>
									<tr>
										<td>
											<?php echo $this->Form->select('tail_ore_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control form-control-sm m_w_70 tail_ore_metal metal-box cvOn cvReq in_old', 'title'=>'Removed record', 'value'=>$val, 'id'=>'tail_ore_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('tail_ore_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control form-control-sm tail_ore_grade grade-txtbox cvOn cvNum cvReq cvMaxLen in_old', 'id'=>'tail_ore_grade_'.$keyN, 'title'=>'Removed record', 'value'=>$row_old_main['rom'][14]['grade'][$key], 'label'=>false, 'maxLength'=>'5')); ?>
											<div class="err_cv"></div>
										</td>
										<td></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
						<?php echo $this->Form->control('tail_ore_metal_count', array('type'=>'hidden', 'id'=>'tail_ore_metal_count', 'label'=>false)); ?>
					</td>

					<!-- SECTION 6 : CLOSING STOCKS OF CONCENTRATES THE CONCENTRATOR/PLANT  -->
					<td>
						<table id="close_con_table" class="f5-rom-sub-table table table-borderless">
							<tbody>
								<?php foreach($conRomData['con'][15]['metal'] as $key=>$val){ $keyN = $key+1; ?>
									<tr>
										<td>
											<?php echo $this->Form->select('close_con_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control form-control-sm m_w_70 close_con_metal metal-box cvOn cvReq'.$diff['con'][15]['metal'][$key]['class'], 'id'=>'close_con_metal_'.$keyN, 'title'=>$diff['con'][15]['metal'][$key]['title'], 'value'=>$val)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('close_con_quantity_'.$keyN, array('type'=>'text', 'class'=>'form-control form-control-sm close_con_quantity quantity-txtbox cvOn cvNum cvReq'.$diff['con'][15]['tot_qty'][$key]['class'], 'id'=>'close_con_quantity_'.$keyN, 'title'=>$diff['con'][15]['tot_qty'][$key]['title'], 'value'=>$conRomData['con'][15]['tot_qty'][$key], 'label'=>false, 'maxLength'=>'16')); ?>
											<div class="err_cv"></div>
										</td>
									</tr>
								<?php } ?>
								
								<?php 
								// This extra loop is only for showing deleted records in the annual return
								// as compares to monthly return
								// Effective from Phase-II
								// Added on 22nd Nov 2021 by Aniket Ganvir
								foreach($row_old_main['con'][15]['metal'] as $key=>$val){ $keyN = $key+1;
								?>
									<tr>
										<td>
											<?php echo $this->Form->select('close_con_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control form-control-sm m_w_70 close_con_metal metal-box cvOn cvReq in_old', 'id'=>'close_con_metal_'.$keyN, 'title'=>'Removed record', 'value'=>$val)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('close_con_quantity_'.$keyN, array('type'=>'text', 'class'=>'form-control form-control-sm close_con_quantity quantity-txtbox cvOn cvNum cvReq in_old', 'id'=>'close_con_quantity_'.$keyN, 'title'=>'Removed record', 'value'=>$conRomData['con'][15]['tot_qty'][$key], 'label'=>false, 'maxLength'=>'16')); ?>
											<div class="err_cv"></div>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
						<?php echo $this->Form->control('close_con_metal_count', array('type'=>'hidden', 'id'=>'close_con_metal_count', 'label'=>false)); ?>
					</td>
					<td>
						<table id="close_con_grade_table" class="f5-rom-sub-table table table-borderless">
							<tbody>
								<?php foreach($conRomData['con'][15]['grade'] as $key=>$val){ $keyN = $key+1; ?>
									<tr>
										<td>
											<?php echo $this->Form->control('close_con_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control form-control-sm close-con-grade grade-txtbox cvOn cvNum cvReq cvMaxLen'.$diff['con'][15]['grade'][$key]['class'], 'id'=>'close_con_grade_'.$keyN, 'title'=>$diff['con'][15]['grade'][$key]['title'], 'value'=>$val, 'label'=>false, 'maxLength'=>'5')); ?>
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
								foreach($row_old_main['con'][15]['grade'] as $key=>$val){ $keyN = $key+1;
								?>
									<tr>
										<td>
											<?php echo $this->Form->control('close_con_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control form-control-sm close-con-grade grade-txtbox cvOn cvNum cvReq cvMaxLen in_old', 'id'=>'close_con_grade_'.$keyN, 'title'=>'Removed record', 'value'=>$val, 'label'=>false, 'maxLength'=>'5')); ?>
											<div class="err_cv"></div>
										</td>
										<td></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</td>
				</tr>
					<td colspan="3">
						<?php echo $this->Form->button('<i class="fa fa-plus"></i> '.$label['btn'], array('type'=>'button', 'id'=>'btn-add-4', 'class'=>'btn btn-sm btn-info form_btn_edit', 'escapeTitle'=>false)); ?>
					</td>
					<td></td>
					<td>
						<?php echo $this->Form->button('<i class="fa fa-plus"></i> '.$label['btn'], array('type'=>'button', 'id'=>'btn-add-5', 'class'=>'btn btn-sm btn-info form_btn_edit', 'escapeTitle'=>false)); ?>
					</td>
					<td colspan="2">
						<?php echo $this->Form->button('<i class="fa fa-plus"></i> '.$label['btn'], array('type'=>'button', 'id'=>'btn-add-6', 'class'=>'btn btn-sm btn-info form_btn_edit', 'escapeTitle'=>false)); ?>
					</td>
				<tr>
			</tbody>
		</table>
		<div class="alert alert-info p-2 pl-3">* <?php echo $label[11]; ?></div>
	</div>
</div>

<?php echo $this->Form->control('error-check', array('type'=>'hidden', 'id'=>'error-check', 'class'=>'error-check')); ?>

<?php echo $this->Form->control('form_no', array('type'=>'hidden', 'value'=>$formId)); ?>
<?php echo $this->Form->control('mine_code', array('type'=>'hidden', 'value'=>$mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType)); ?>
<?php echo $this->Form->control('return_date', array('type'=>'hidden', 'value'=>$returnDate)); ?>
<?php echo $this->Form->control('mineral_name', array('type'=>'hidden', 'value'=>$mineral)); ?>
<?php echo $this->Form->control('prev_month_prod', array('type'=>'hidden', 'value'=>$prevMonthProd)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'form_id_name', 'value'=>'frmConReco')); ?>

<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'get_metals_url', 'value'=>$this->Url->build(array('controller'=>'monthly','action'=>'getMetals'))]); ?>
<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'get_con_data_url', 'value'=>$this->Url->build(array('controller'=>'monthly','action'=>'getConData'))]); ?>
<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'open_ore_metal_row', 'value'=>$this->Form->select("open_ore_metal_rowcc", $metals, array("empty"=>"- Select -","class"=>"form-control form-control-sm open_ore_metal metal-box valid cvOn cvReq", "id"=>"open_ore_metal_rowcc"))]); ?>
<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'rec_ore_metal_row', 'value'=>$this->Form->select("rec_ore_metal_rowcc", $metals, array("empty"=>"- Select -","class"=>"form-control form-control-sm rec_ore_metal metal-box cvOn cvReq", "id"=>"rec_ore_metal_rowcc"))]); ?>
<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'treat_ore_metal_row', 'value'=>$this->Form->select("treat_ore_metal_rowcc", $metals, array("empty"=>"- Select -","class"=>"form-control form-control-sm treat_ore_metal metal-box cvOn cvReq", "id"=>"treat_ore_metal_rowcc"))]); ?>
<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'con_obt_metal_row', 'value'=>$this->Form->select("con_obt_metal_rowcc", $metals, array("empty"=>"- Select -","class"=>"form-control form-control-sm m_w_70 con_obt_metal metal-box cvOn cvReq", "id"=>"con_obt_metal_rowcc"))]); ?>
<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'tail_ore_metal_row', 'value'=>$this->Form->select("tail_ore_metal_rowcc", $metals, array("empty"=>"- Select -","class"=>"form-control form-control-sm m_w_70 tail_ore_metal metal-box cvOn cvReq", "id"=>"tail_ore_metal_rowcc"))]); ?>
<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'close_con_metal_row', 'value'=>$this->Form->select("close_con_metal_rowcc", $metals, array("empty"=>"- Select -","class"=>"form-control form-control-sm m_w_70 close_con_metal metal-box cvOn cvReq", "id"=>"close_con_metal_rowcc"))]); ?>

<?php echo $this->Html->script('f/con_reco.js?version='.$version); ?>
