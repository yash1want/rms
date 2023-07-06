
<?php 

// Highlight fields which are differs from cumulative monthly data in annual
// (Only for Form G2 in MMS side)
// Effective from Phase-II
// Added on 20th Nov 2021 by Aniket Ganvir

$row_old_main = (isset($romDataMonthAll)) ? $romDataMonthAll : array('1'=>array('metal'=>array()), '2'=>array('metal'=>array()),'3'=>array('metal'=>array()),'4'=>array('metal'=>array()),'5'=>array('metal'=>array()),'6'=>array('metal'=>array()),'7'=>array('metal'=>array()),'8'=>array('metal'=>array()),'9'=>array('metal'=>array()));

for ($i=1; $i<=9; $i++) {
	
	foreach ($romData[$i]['metal'] as $key=>$val) {

		if ($key == 0) {
			$diff[$i]['tot_qty'][0]['class'] = '';
			$diff[$i]['tot_qty'][0]['title'] = '';
		}
			
		$diff[$i]['metal'][$key]['class'] = '';
		$diff[$i]['metal'][$key]['title'] = '';
		$diff[$i]['grade'][$key]['class'] = '';
		$diff[$i]['grade'][$key]['title'] = '';
		
		if (isset($romDataMonthAll)) {
			
			if ($key == 0) {
				$romDataOld = $romDataMonthAll;
				$totQtyOld = $romDataOld[$i]['tot_qty'][0];
				$totQtyNew = $romData[$i]['tot_qty'][0];
				if ($totQtyOld != $totQtyNew) {
					$totQtyDiff = (float)$totQtyNew - (float)$totQtyOld; 
					$diff[$i]['tot_qty'][0]['title'] = ($totQtyDiff > 0) ? '+'.$totQtyDiff : $totQtyDiff;
					$diff[$i]['tot_qty'][0]['class'] = ' in_new';
				}
			}

			$metal = $romData[$i]['metal'][$key];
			$metalId = array_search($metal, $romDataOld[$i]['metal']);
		
			if ($metalId != '') {

				if ($romDataOld[$i]['grade'][$metalId] != $romData[$i]['grade'][$key]) {
					$metalDiff = $romData[$i]['grade'][$key] - $romDataOld[$i]['grade'][$metalId];
					$diff[$i]['grade'][$key]['title'] = ($metalDiff > 0) ? '+'.$metalDiff : $metalDiff;
					$diff[$i]['grade'][$key]['class'] = ' in_new';
				}
				
				unset($row_old_main[$i]['table'][$metalId]);
				unset($row_old_main[$i]['tot_qty'][$metalId]);
				unset($row_old_main[$i]['metal'][$metalId]);
				unset($row_old_main[$i]['grade'][$metalId]);

			} else {
				
				$diff[$i]['metal'][$key]['class'] = ' in_new';
				$diff[$i]['metal'][$key]['title'] = 'New record';
				$diff[$i]['grade'][$key]['class'] = ' in_new';
				$diff[$i]['grade'][$key]['title'] = 'New record';
			}
		
		}

	}
	
}
//print_r($label);die;

?>

<h5 class="card-title"><?php echo $label['title']; ?></h5>
<div class="position-relative row form-group mine-group">
	<div class="col-sm-12 mine-m-auto table-responsive">
		<table class="table table-bordered f_size_13 width-110" id="mTable">
			<thead class="thead-light text-center">
				<tr>
					<th rowspan="2"></th>
					<th colspan="2"><?php echo $label[0]; ?></th>
					<th colspan="2"><?php echo $label[1]; ?></th>
					<th colspan="2"><?php echo $label[2]; ?></th>
				</tr>
				<tr>
					<th class="w_5"><?php echo $label[3]; ?></th>
					<th><?php echo $label[4]; ?></th>
					<th class="w_5"><?php echo $label[3]; ?></th>
					<th><?php echo $label[4]; ?></th>
					<th class="w_5"><?php echo $label[3]; ?></th>
					<th><?php echo $label[4]; ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th colspan="7"><?php echo $label[7]; ?></th>
				</tr>
				<tr>
					
					<td><?php echo $label[5]; ?></td>
					<td>
						<?php echo $this->Form->control('f_open_dev_qty', array('type'=>'text', 'class'=>'form-control input_sm tot-qty open_dev_qty'.$diff[1]['tot_qty'][0]['class'], 'id'=>'f_open_dev_qty', 'label'=>false, 'title'=>$diff[1]['tot_qty'][0]['title'], 'value'=>$romData[1]['tot_qty'][0], 'maxLength'=>150)); ?>
					</td>
					<td>
						<table id="open_dev_table" class="f5-rom-sub-table table">
							<thead></thead>
							<tbody>
								<?php foreach($romData[1]['metal'] as $key=>$val){ $keyN = $key+1; ?>
									<tr>
										<td>
											<?php echo $this->Form->select('open_dev_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control input_sm open_dev_metal metal-box valid cvOn '.$diff[1]['metal'][$key]['class'], 'title'=>$diff[1]['metal'][$key]['title'], 'value'=>$val, 'id'=>'open_dev_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('open_dev_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control input_sm open_dev_grade grade-txtbox w_3 mw_50 one_grade_more cvOn cvNum cvReq cvFloat'.$diff[1]['grade'][$key]['class'], 'id'=>'open_dev_grade_'.$keyN, 'title'=>$diff[1]['grade'][$key]['title'], 'value'=>$romData[1]['grade'][$key], 'cvfloat'=>'99.99', 'label'=>false)); ?>
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
								foreach($row_old_main[1]['metal'] as $key=>$val){ $keyN = $key+1;
								?>
									<tr>
										<td>
											<?php echo $this->Form->select('open_dev_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control input_sm open_dev_metal metal-box valid cvOn  in_old', 'title'=>'Removed record', 'value'=>$val, 'id'=>'open_dev_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('open_dev_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control input_sm open_dev_grade grade-txtbox  w_3 mw_50 one_grade_more cvOn cvNum cvReq cvFloat in_old', 'id'=>'open_dev_grade_'.$keyN, 'title'=>'Removed record', 'value'=>$row_old_main[1]['grade'][$key], 'cvfloat'=>'99.99', 'label'=>false)); ?>
											<div class="err_cv"></div>
										</td>
										<td></td>
									</tr>
								<?php } ?>
							</tbody>
							<thead>
								<tr>
									<th colspan="3">
										<?php echo $this->Form->button('<i class="fa fa-plus"></i> Add more', array('type'=>'button', 'id'=>'btn-add-1', 'class'=>'btn btn-sm btn-info form_btn_edit', 'escapeTitle'=>false)); ?>
									</th>
								</tr>
							</thead>
						</table>
						<?php echo $this->Form->control('open_dev_metal_count', array('type'=>'hidden', 'id'=>'open_dev_metal_count', 'label'=>false)); ?>
					</td>
					<td>
						<?php echo $this->Form->control('f_prod_dev_qty', array('type'=>'text', 'class'=>'form-control input_sm number-fields tot-qty prod_dev_qty'.$diff[2]['tot_qty'][0]['class'], 'id'=>'f_prod_dev_qty', 'title'=>$diff[2]['tot_qty'][0]['title'], 'label'=>false, 'value'=>$romData[2]['tot_qty'][0], 'maxLength'=>150)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<table id="prod_dev_table" class="f5-rom-sub-table table">
							<thead></thead>
							<tbody>
								<?php foreach($romData[2]['metal'] as $key=>$val){ $keyN = $key+1; ?>
									<tr>
										<td>
											<?php echo $this->Form->select('prod_dev_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control input_sm prod_dev_metal metal-box cvOn '.$diff[2]['metal'][$key]['class'], 'title'=>$diff[2]['metal'][$key]['title'], 'value'=>$val, 'id'=>'prod_dev_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('prod_dev_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control input_sm prod_dev_grade grade-txtbox  w_3 mw_50 one_grade_more cvOn cvNum cvReq cvFloat'.$diff[2]['grade'][$key]['class'], 'id'=>'prod_dev_grade_'.$keyN, 'title'=>$diff[2]['grade'][$key]['title'], 'value'=>$romData[2]['grade'][$key], 'cvfloat'=>'99.99', 'label'=>false)); ?>
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
								foreach($row_old_main[2]['metal'] as $key=>$val){ $keyN = $key+1;
								?>
									<tr>
										<td>
											<?php echo $this->Form->select('prod_dev_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control input_sm prod_dev_metal metal-box cvOn  in_old', 'title'=>'Removed record', 'value'=>$val, 'id'=>'prod_dev_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('prod_dev_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control input_sm prod_dev_grade grade-txtbox  w_3 mw_50 one_grade_more cvOn cvNum cvReq cvFloat in_old', 'id'=>'prod_dev_grade_'.$keyN, 'title'=>'Removed record', 'value'=>$row_old_main[2]['grade'][$key], 'cvfloat'=>'99.99', 'label'=>false)); ?>
											<div class="err_cv"></div>
										</td>
										<td></td>
										
									</tr>
								<?php } ?>
							</tbody>
							<thead>
								<tr>
									<th colspan="3">
										<?php echo $this->Form->button('<i class="fa fa-plus"></i> Add more', array('type'=>'button', 'id'=>'btn-add-2', 'class'=>'btn btn-sm btn-info form_btn_edit', 'escapeTitle'=>false)); ?>
									</th>
								</tr>
							</thead>
						</table>
						<?php echo $this->Form->control('prod_dev_metal_count', array('type'=>'hidden', 'id'=>'prod_dev_metal_count', 'label'=>false)); ?>
					</td>

					<td>
						<?php echo $this->Form->control('f_close_dev_qty', array('type'=>'text', 'class'=>'form-control input_sm number-fields tot-qty close_dev_qty'.$diff[3]['tot_qty'][0]['class'], 'id'=>'f_close_dev_qty', 'title'=>$diff[3]['tot_qty'][0]['title'], 'label'=>false, 'value'=>$romData[3]['tot_qty'][0], 'maxLength'=>150)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<table id="close_dev_table" class="f5-rom-sub-table table">
							<thead></thead>
							<tbody>
								<?php foreach($romData[3]['metal'] as $key=>$val){ $keyN = $key+1; ?>
									<tr>
										<td>
											<?php echo $this->Form->select('close_dev_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control input_sm close_dev_metal metal-box cvOn '.$diff[3]['metal'][$key]['class'], 'title'=>$diff[3]['metal'][$key]['title'], 'value'=>$val, 'id'=>'close_dev_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('close_dev_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control input_sm close_dev_grade grade-txtbox  w_3 mw_50 one_grade_more cvOn cvNum cvReq cvFloat'.$diff[3]['grade'][$key]['class'], 'id'=>'close_dev_grade_'.$keyN, 'title'=>$diff[3]['grade'][$key]['title'], 'value'=>$romData[3]['grade'][$key], 'cvfloat'=>'99.99', 'label'=>false)); ?>
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
								foreach($row_old_main[3]['metal'] as $key=>$val){ $keyN = $key+1;
								?>
									<tr>
										<td>
											<?php echo $this->Form->select('close_dev_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control input_sm close_dev_metal metal-box cvOn  in_old', 'title'=>'Removed record', 'value'=>$val, 'id'=>'close_dev_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('close_dev_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control input_sm close_dev_grade grade-txtbox  w_3 mw_50 one_grade_more cvOn cvNum cvReq cvFloat in_old', 'id'=>'close_dev_grade_'.$keyN, 'title'=>'Removed record', 'value'=>$row_old_main[3]['grade'][$key], 'cvfloat'=>'99.99', 'label'=>false)); ?>
											<div class="err_cv"></div>
										</td>
										<td></td>
										
									</tr>
								<?php } ?>
							</tbody>
							<thead>
								<tr>
									<th colspan="3">
										<?php echo $this->Form->button('<i class="fa fa-plus"></i> Add more', array('type'=>'button', 'id'=>'btn-add-3', 'class'=>'btn btn-sm btn-info form_btn_edit', 'escapeTitle'=>false)); ?>
									</th>
								</tr>
							</thead>
						</table>
						<?php echo $this->Form->control('close_dev_metal_count', array('type'=>'hidden', 'id'=>'close_dev_metal_count', 'label'=>false)); ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $label[6]; ?></td>
					<td>
						<?php echo $this->Form->control('f_open_stop_qty', array('type'=>'text', 'class'=>'form-control input_sm number-fields tot-qty open_stop_qty'.$diff[4]['tot_qty'][0]['class'], 'id'=>'f_open_stop_qty', 'title'=>$diff[4]['tot_qty'][0]['title'], 'label'=>false, 'value'=>$romData[4]['tot_qty'][0], 'maxLength'=>150)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<table id="open_stop_table" class="f5-rom-sub-table table">
							<thead></thead>
							<tbody>
								<?php foreach($romData[4]['metal'] as $key=>$val){ $keyN = $key+1; ?>
									<tr>
										<td>
											<?php echo $this->Form->select('open_stop_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control input_sm open_stop_metal metal-box cvOn '.$diff[4]['metal'][$key]['class'], 'title'=>$diff[4]['metal'][$key]['title'], 'value'=>$val, 'id'=>'open_stop_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('open_stop_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control input_sm open_stop_grade grade-txtbox  w_3 mw_50 one_grade_more cvOn cvNum cvReq cvFloat'.$diff[4]['grade'][$key]['class'], 'id'=>'open_stop_grade_'.$keyN, 'title'=>$diff[4]['grade'][$key]['title'], 'value'=>$romData[4]['grade'][$key], 'cvfloat'=>'99.99', 'label'=>false)); ?>
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
								foreach($row_old_main[4]['metal'] as $key=>$val){ $keyN = $key+1;
								?>
									<tr>
										<td>
											<?php echo $this->Form->select('open_stop_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control input_sm open_stop_metal metal-box cvOn  in_old', 'title'=>'Removed record', 'value'=>$val, 'id'=>'open_stop_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('open_stop_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control input_sm open_stop_grade grade-txtbox  w_3 mw_50 one_grade_more cvOn cvNum cvReq cvFloat in_old', 'id'=>'open_stop_grade_'.$keyN, 'title'=>'Removed record', 'value'=>$row_old_main[4]['grade'][$key], 'cvfloat'=>'99.99', 'label'=>false)); ?>
											<div class="err_cv"></div>
										</td>
										<td></td>
										
									</tr>
								<?php } ?>
							</tbody>
							<thead>
								<tr>
									<th colspan="3">
										<?php echo $this->Form->button('<i class="fa fa-plus"></i> Add more', array('type'=>'button', 'id'=>'btn-add-4', 'class'=>'btn btn-sm btn-info form_btn_edit', 'escapeTitle'=>false)); ?>
									</th>
								</tr>
							</thead>
						</table>
						<?php echo $this->Form->control('open_stop_metal_count', array('type'=>'hidden', 'id'=>'open_stop_metal_count', 'label'=>false)); ?>
					</td>

					<td>
						<?php echo $this->Form->control('f_prod_stop_qty', array('type'=>'text', 'class'=>'form-control input_sm number-fields tot-qty prod_stop_qty'.$diff[5]['tot_qty'][0]['class'], 'id'=>'f_prod_stop_qty', 'label'=>false, 'title'=>$diff[5]['tot_qty'][0]['title'], 'value'=>$romData[5]['tot_qty'][0], 'maxLength'=>150)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<table id="prod_stop_table" class="f5-rom-sub-table table">
							<thead></thead>
							<tbody>
								<?php foreach($romData[5]['metal'] as $key=>$val){ $keyN = $key+1; ?>
									<tr>
										<td>
											<?php echo $this->Form->select('prod_stop_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control input_sm prod_stop_metal metal-box cvOn '.$diff[5]['metal'][$key]['class'], 'title'=>$diff[5]['metal'][$key]['title'], 'value'=>$val, 'id'=>'prod_stop_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('prod_stop_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control input_sm prod_stop_grade grade-txtbox  w_3 mw_50 one_grade_more cvOn cvNum cvReq cvFloat'.$diff[5]['grade'][$key]['class'], 'id'=>'prod_stop_grade_'.$keyN, 'title'=>$diff[5]['grade'][$key]['title'], 'value'=>$romData[5]['grade'][$key], 'cvfloat'=>'99.99', 'label'=>false)); ?>
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
								foreach($row_old_main[5]['metal'] as $key=>$val){ $keyN = $key+1;
								?>
									<tr>
										<td>
											<?php echo $this->Form->select('prod_stop_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control input_sm prod_stop_metal metal-box cvOn  in_old', 'title'=>'Removed record', 'value'=>$val, 'id'=>'prod_stop_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('prod_stop_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control input_sm prod_stop_grade grade-txtbox  w_3 mw_50 one_grade_more cvOn cvNum cvReq cvFloat in_old', 'id'=>'prod_stop_grade_'.$keyN, 'title'=>'Removed record', 'value'=>$row_old_main[5]['grade'][$key], 'cvfloat'=>'99.99', 'label'=>false)); ?>
											<div class="err_cv"></div>
										</td>
										<td></td>
									</tr>
								<?php } ?>
							</tbody>
							<thead>
								<tr>
									<th colspan="3">
										<?php echo $this->Form->button('<i class="fa fa-plus"></i> Add more', array('type'=>'button', 'id'=>'btn-add-5', 'class'=>'btn btn-sm btn-info form_btn_edit', 'escapeTitle'=>false)); ?>
									</th>
								</tr>
							</thead>
						</table>
						<?php echo $this->Form->control('prod_stop_metal_count', array('type'=>'hidden', 'id'=>'prod_stop_metal_count', 'label'=>false)); ?>
					</td>

					<td>
						<?php echo $this->Form->control('f_close_stop_qty', array('type'=>'text', 'class'=>'form-control input_sm number-fields tot-qty close_stop_qty'.$diff[6]['tot_qty'][0]['class'], 'id'=>'f_close_stop_qty', 'label'=>false, 'title'=>$diff[6]['tot_qty'][0]['title'], 'value'=>$romData[6]['tot_qty'][0], 'maxLength'=>150)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<table id="close_stop_table" class="f5-rom-sub-table table">
							<thead></thead>
							<tbody>
								<?php foreach($romData[6]['metal'] as $key=>$val){ $keyN = $key+1; ?>
									<tr>
										<td>
											<?php echo $this->Form->select('close_stop_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control input_sm close_stop_metal metal-box cvOn '.$diff[6]['metal'][$key]['class'], 'title'=>$diff[6]['metal'][$key]['title'], 'value'=>$val, 'id'=>'close_stop_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('close_stop_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control input_sm close_stop_grade grade-txtbox  w_3 mw_50 one_grade_more cvOn cvNum cvReq cvFloat'.$diff[6]['grade'][$key]['class'], 'id'=>'close_stop_grade_'.$keyN, 'title'=>$diff[6]['grade'][$key]['title'], 'value'=>$romData[6]['grade'][$key], 'cvfloat'=>'99.99', 'label'=>false)); ?>
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
								foreach($row_old_main[6]['metal'] as $key=>$val){ $keyN = $key+1;
								?>
									<tr>
										<td>
											<?php echo $this->Form->select('close_stop_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control input_sm close_stop_metal metal-box cvOn  in_old', 'title'=>'Removed record', 'value'=>$val, 'id'=>'close_stop_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('close_stop_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control input_sm close_stop_grade grade-txtbox  w_3 mw_50 one_grade_more cvOn cvNum cvReq cvFloat in_old', 'id'=>'close_stop_grade_'.$keyN, 'title'=>'Removed record', 'value'=>$row_old_main[6]['grade'][$key], 'cvfloat'=>'99.99', 'label'=>false)); ?>
											<div class="err_cv"></div>
										</td>
										<td></td>
									</tr>
								<?php } ?>
							</tbody>
							<thead>
								<tr>
									<th colspan="3">
										<?php echo $this->Form->button('<i class="fa fa-plus"></i> Add more', array('type'=>'button', 'id'=>'btn-add-6', 'class'=>'btn btn-sm btn-info form_btn_edit', 'escapeTitle'=>false)); ?>
									</th>
								</tr>
							</thead>
						</table>
						<?php echo $this->Form->control('close_stop_metal_count', array('type'=>'hidden', 'id'=>'close_stop_metal_count', 'label'=>false)); ?>
					</td>
				</tr>
			</tbody>
			<!-- <thead class="thead-light">
				<tr>
					<th><?php //echo $label[7]; ?></th>
                    <th id="open_und_qty_total">-</th>
                    <th>
                      <table width="100%" id="open_und_metal_total" class="und_total_table"></table>
                    </th>
                    <th id="prod_und_qty_total">-</th>
                    <th>
                      <table width="100%" id="prod_und_metal_total" class="und_total_table"></table>
                    </th>
                    <th id="close_und_qty_total">-</th>
                    <th>
                      <table width="100%" id="close_und_metal_total" class="und_total_table"></table>
                    </th>
				</tr>
			</thead> -->
			<tbody>
				<tr>
					<td><?php echo $label[8]; ?></td>
					<td>
						<?php echo $this->Form->control('f_open_cast_qty', array('type'=>'text', 'class'=>'form-control input_sm number-fields tot-qty open_cast_qty'.$diff[7]['tot_qty'][0]['class'], 'id'=>'f_open_cast_qty', 'label'=>false, 'title'=>$diff[7]['tot_qty'][0]['title'], 'value'=>$romData[7]['tot_qty'][0], 'maxLength'=>150)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<table id="open_cast_table" class="f5-rom-sub-table table">
							<thead></thead>
							<tbody>
								<?php foreach($romData[7]['metal'] as $key=>$val){ $keyN = $key+1; ?>
									<tr>
										<td>
											<?php echo $this->Form->select('open_cast_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control input_sm open_cast_metal metal-box cvOn '.$diff[7]['metal'][$key]['class'], 'title'=>$diff[7]['metal'][$key]['title'], 'value'=>$val, 'id'=>'open_cast_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('open_cast_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control input_sm open_cast_grade grade-txtbox  w_3 mw_50 one_grade_more cvOn cvNum cvReq cvFloat'.$diff[7]['grade'][$key]['class'], 'id'=>'open_cast_grade_'.$keyN, 'title'=>$diff[7]['grade'][$key]['title'], 'value'=>$romData[7]['grade'][$key], 'cvfloat'=>'99.99', 'label'=>false)); ?>
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
								foreach($row_old_main[7]['metal'] as $key=>$val){ $keyN = $key+1;
								?>
									<tr>
										<td>
											<?php echo $this->Form->select('open_cast_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control input_sm open_cast_metal metal-box cvOn  in_old', 'title'=>'Removed record', 'value'=>$val, 'id'=>'open_cast_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('open_cast_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control input_sm open_cast_grade grade-txtbox  w_3 mw_50 one_grade_more cvOn cvNum cvReq cvFloat in_old', 'id'=>'open_cast_grade_'.$keyN, 'title'=>'Removed record', 'value'=>$row_old_main[7]['grade'][$key], 'cvfloat'=>'99.99', 'label'=>false)); ?>
											<div class="err_cv"></div>
										</td>
										<td></td>
									</tr>
								<?php } ?>
							</tbody>
							<thead>
								<tr>
									<th colspan="3">
										<?php echo $this->Form->button('<i class="fa fa-plus"></i> Add more', array('type'=>'button', 'id'=>'btn-add-7', 'class'=>'btn btn-sm btn-info form_btn_edit', 'escapeTitle'=>false)); ?>
									</th>
								</tr>
							</thead>
						</table>
						<?php echo $this->Form->control('open_cast_metal_count', array('type'=>'hidden', 'id'=>'open_cast_metal_count', 'label'=>false)); ?>
					</td>

					<td>
						<?php echo $this->Form->control('f_prod_cast_qty', array('type'=>'text', 'class'=>'form-control input_sm number-fields tot-qty prod_cast_qty'.$diff[8]['tot_qty'][0]['class'], 'id'=>'f_prod_cast_qty', 'label'=>false, 'title'=>$diff[8]['tot_qty'][0]['title'], 'value'=>$romData[8]['tot_qty'][0], 'maxLength'=>150)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<table id="prod_cast_table" class="f5-rom-sub-table table">
							<thead></thead>
							<tbody>
								<?php foreach($romData[8]['metal'] as $key=>$val){ $keyN = $key+1; ?>
									<tr>
										<td>
											<?php echo $this->Form->select('prod_cast_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control input_sm prod_cast_metal metal-box cvOn '.$diff[8]['metal'][$key]['class'], 'title'=>$diff[8]['metal'][$key]['title'], 'value'=>$val, 'id'=>'prod_cast_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('prod_cast_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control input_sm prod_cast_grade grade-txtbox  w_3 mw_50 one_grade_more cvOn cvNum cvReq cvFloat'.$diff[8]['grade'][$key]['class'], 'id'=>'prod_cast_grade_'.$keyN, 'title'=>$diff[8]['grade'][$key]['title'], 'value'=>$romData[8]['grade'][$key], 'cvfloat'=>'99.99', 'label'=>false)); ?>
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
								foreach($row_old_main[8]['metal'] as $key=>$val){ $keyN = $key+1;
								?>
									<tr>
										<td>
											<?php echo $this->Form->select('prod_cast_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control input_sm prod_cast_metal metal-box cvOn  in_old', 'title'=>'Removed record', 'value'=>$val, 'id'=>'prod_cast_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('prod_cast_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control input_sm prod_cast_grade grade-txtbox  w_3 mw_50 one_grade_more cvOn cvNum cvReq cvFloat in_old', 'id'=>'prod_cast_grade_'.$keyN, 'title'=>'Removed record', 'value'=>$row_old_main[8]['grade'][$key], 'cvfloat'=>'99.99', 'label'=>false)); ?>
											<div class="err_cv"></div>
										</td>
										<td></td>
									</tr>
								<?php } ?>
							</tbody>
							<thead>
								<tr>
									<th colspan="3">
										<?php echo $this->Form->button('<i class="fa fa-plus"></i> Add more', array('type'=>'button', 'id'=>'btn-add-8', 'class'=>'btn btn-sm btn-info form_btn_edit', 'escapeTitle'=>false)); ?>
									</th>
								</tr>
							</thead>
						</table>
						<?php echo $this->Form->control('prod_cast_metal_count', array('type'=>'hidden', 'id'=>'prod_cast_metal_count', 'label'=>false)); ?>
					</td>

					<td>
						<?php echo $this->Form->control('f_close_cast_qty', array('type'=>'text', 'class'=>'form-control input_sm number-fields tot-qty close_cast_qty'.$diff[9]['tot_qty'][0]['class'], 'id'=>'f_close_cast_qty', 'label'=>false, 'title'=>$diff[9]['tot_qty'][0]['title'], 'value'=>$romData[9]['tot_qty'][0], 'maxLength'=>150)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<table id="close_cast_table" class="f5-rom-sub-table table">
							<thead></thead>
							<tbody>
								<?php foreach($romData[9]['metal'] as $key=>$val){ $keyN = $key+1; ?>
									<tr>
										<td>
											<?php echo $this->Form->select('close_cast_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control input_sm close_cast_metal metal-box cvOn '.$diff[9]['metal'][$key]['class'], 'title'=>$diff[9]['metal'][$key]['title'], 'value'=>$val, 'id'=>'close_cast_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('close_cast_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control input_sm close_cast_grade grade-txtbox  w_3 mw_50 one_grade_more cvOn cvNum cvReq cvFloat'.$diff[9]['grade'][$key]['class'], 'id'=>'close_cast_grade_'.$keyN, 'title'=>$diff[9]['grade'][$key]['title'], 'value'=>$romData[9]['grade'][$key], 'cvfloat'=>'99.99', 'label'=>false)); ?>
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
								foreach($row_old_main[9]['metal'] as $key=>$val){ $keyN = $key+1;
								?>
									<tr>
										<td>
											<?php echo $this->Form->select('close_cast_metal_'.$keyN, $metals, array('empty'=>'- Select -','class'=>'form-control input_sm close_cast_metal metal-box cvOn  in_old', 'title'=>'Removed record', 'value'=>$val, 'id'=>'close_cast_metal_'.$keyN)); ?>
											<div class="err_cv"></div>
										</td>
										<td>
											<?php echo $this->Form->control('close_cast_grade_'.$keyN, array('type'=>'text', 'class'=>'form-control input_sm close_cast_grade grade-txtbox  w_3 mw_50 one_grade_more cvOn cvNum cvReq cvFloat in_old', 'id'=>'close_cast_grade_'.$keyN, 'title'=>'Removed record', 'value'=>$row_old_main[9]['grade'][$key], 'cvfloat'=>'99.99', 'label'=>false)); ?>
											<div class="err_cv"></div>
										</td>
										<td></td>
									</tr>
								<?php } ?>
							</tbody>
							<thead>
								<tr>
									<th colspan="3">
										<?php echo $this->Form->button('<i class="fa fa-plus"></i> Add more', array('type'=>'button', 'id'=>'btn-add-9', 'class'=>'btn btn-sm btn-info form_btn_edit', 'escapeTitle'=>false)); ?>
									</th>
								</tr>
							</thead>
						</table>
						<?php echo $this->Form->control('close_cast_metal_count', array('type'=>'hidden', 'id'=>'close_cast_metal_count', 'label'=>false)); ?>
					</td>
				</tr>
			</tbody>
			<thead class="thead-light">
				<tr>
                    <th><?php echo $label[9]; ?></th>
                    <?php
                    $returnType = $this->getRequest()->getSession()->read('returnType');
                    $maxLength = 13;
                    if ($returnType == 'MONTHLY') {
						$quantityMaxLength = $maxLength;
                    } else if ($returnType = 'ANNUAL') {
						$quantityMaxLength = $maxLength + 2;
                    }
                    ?>
                    <th>
                    	<?php echo $this->Form->control('f_open_tot_qty', array('type'=>'text', 'class'=>'form-control quantity-txtbox', 'id'=>'f_open_tot_qty', 'label'=>false,'value'=>'', 'maxLength'=>$quantityMaxLength)); ?>
						<div class="err_cv"></div>
                    </th>
                    <th>
                      <table id="open_total_table" class="f5-rom-total-table"></table>
                    </th>
                    <th>
                    	<?php echo $this->Form->control('f_prod_tot_qty', array('type'=>'text', 'class'=>'form-control quantity-txtbox', 'id'=>'f_prod_tot_qty', 'label'=>false, 'maxLength'=>$quantityMaxLength)); ?>
						<div class="err_cv"></div>
                    </th>
                    <th>
                      <table id="prod_total_table" class="f5-rom-total-table"></table>
                    </th>
                    <th>
                    	<?php echo $this->Form->control('f_close_tot_qty', array('type'=>'text', 'class'=>'form-control quantity-txtbox', 'id'=>'f_close_tot_qty', 'label'=>false, 'maxLength'=>$quantityMaxLength)); ?>
						<div class="err_cv"></div>
                    </th>
                    <th>
                      <table id="close_total_table" class="f5-rom-total-table"></table>
                    </th>
				</tr>
			</thead>
		</table>
	</div>
	<div class="col-sm-12 mine-m-auto estimation-table-div">
		<table class="estimation-table table table-bordered table-responsive text-center">
			<?php if($returnType == 'ANNUAL'){ ?>
			<thead class="thead-light">
				<tr>
				<th><?php echo $label[10]; ?></th>
				<th><?php echo $label[11]; ?> <br/><?php echo $period; ?></th>
				<th><?php echo $label[12]; ?> <br/><?php echo $period; ?></th>
				<th><?php echo $label[15]; ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
				<td><?php echo $mineral; ?></td>
				<td><?php echo ($estProd != "") ? $estProd : "--"; ?></td>
				<td><?php echo $cumProd; ?></td>
				<td><?php echo ($estProd - $cumProd); ?></td>
				</tr>
			</tbody>
			<?php } else { ?>
			<thead class="thead-light">
				<tr>
				<th><?php echo $label[10]; ?></th>
				<th><?php echo $label[13]; ?></th>
				<th><?php echo $label[14]; ?></th>
				<th><?php echo $label[15]; ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
				<td><?php echo $mineral; ?></td>
				<td><?php echo ($estProd != "") ? $estProd : "--"; ?></td>
				<td><?php echo $cumProd; ?></td>
				<td><?php echo ($estProd - $cumProd); ?></td>
				</tr>
			</tbody>
			<?php } ?>
		</table>
	</div>
</div>

<?php echo $this->Form->control('form_no', array('type'=>'hidden', 'label'=>false, 'value'=>$formId)); ?>
<?php echo $this->Form->control('mine_code', array('type'=>'hidden', 'label'=>false, 'value'=>$mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'label'=>false, 'value'=>$returnType)); ?>
<?php echo $this->Form->control('return_date', array('type'=>'hidden', 'label'=>false, 'value'=>$returnDate)); ?>
<?php echo $this->Form->control('mineral_name', array('type'=>'hidden', 'label'=>false, 'value'=>$mineral)); ?>
<?php //echo $this->Form->control('deduction_id', array('type'=>'hidden', 'label'=>false, 'value'=>$deductionId)); ?>
<?php echo $this->Form->control('estimated_prod', array('type'=>'hidden', 'id'=>'estimated_prod', 'label'=>false, 'value'=>$estProd)); ?>
<?php echo $this->Form->control('cum_prod', array('type'=>'hidden', 'id'=>'cum_prod', 'label'=>false, 'value'=>$cumProd)); ?>
<?php echo $this->Form->control('prev_month_prod', array('type'=>'hidden', 'label'=>false, 'value'=>$prevMonthProd)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden','id'=>'form_id_name', 'label'=>false, 'value'=>'frmRomStocksOre')); ?>

<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'open_dev_metal_row', 'value'=>$this->Form->select("open_dev_metal_rowcc", $metals, array("empty"=>"- Select -","class"=>"form-control input_sm open_dev_metal metal-box valid cvOn cvReq", "id"=>"open_dev_metal_rowcc"))]); ?>
<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'prod_dev_metal_row', 'value'=>$this->Form->select("prod_dev_metal_rowcc", $metals, array("empty"=>"- Select -","class"=>"form-control input_sm prod_dev_metal metal-box valid cvOn cvReq", "id"=>"prod_dev_metal_rowcc"))]); ?>
<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'close_dev_metal_row', 'value'=>$this->Form->select("close_dev_metal_rowcc", $metals, array("empty"=>"- Select -","class"=>"form-control input_sm close_dev_metal metal-box cvOn cvReq", "id"=>"close_dev_metal_rowcc"))]); ?>
<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'open_stop_metal_row', 'value'=>$this->Form->select("open_stop_metal_rowcc", $metals, array("empty"=>"- Select -","class"=>"form-control input_sm open_stop_metal metal-box cvOn cvReq", "id"=>"open_stop_metal_rowcc"))]); ?>
<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'prod_stop_metal_row', 'value'=>$this->Form->select("prod_stop_metal_rowcc", $metals, array("empty"=>"- Select -","class"=>"form-control input_sm prod_stop_metal metal-box cvOn cvReq", "id"=>"prod_stop_metal_rowcc"))]); ?>
<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'close_stop_metal_row', 'value'=>$this->Form->select("close_stop_metal_rowcc", $metals, array("empty"=>"- Select -","class"=>"form-control input_sm close_stop_metal metal-box cvOn cvReq", "id"=>"close_stop_metal_rowcc"))]); ?>
<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'open_cast_metal_row', 'value'=>$this->Form->select("open_cast_metal_rowcc", $metals, array("empty"=>"- Select -","class"=>"form-control input_sm open_cast_metal metal-box cvOn cvReq", "id"=>"open_cast_metal_rowcc"))]); ?>
<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'prod_cast_metal_row', 'value'=>$this->Form->select("prod_cast_metal_rowcc", $metals, array("empty"=>"- Select -","class"=>"form-control input_sm prod_cast_metal metal-box cvOn cvReq", "id"=>"prod_cast_metal_rowcc"))]); ?>
<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'close_cast_metal_row', 'value'=>$this->Form->select("close_cast_metal_rowcc", $metals, array("empty"=>"- Select -","class"=>"form-control input_sm close_cast_metal metal-box cvOn cvReq", "id"=>"close_cast_metal_rowcc"))]); ?>

<?php echo $this->Html->script('f/rom_stocks_ore.js?version='.$version); ?>
