
<?php 

// Highlight fields which are differs from cumulative monthly data in annual
// (Only for Form M in MMS side)
// Effective from Phase-II
// Added on 13th Dec 2021 by Aniket Ganvir

$row_old_main = (isset($tradingAcMonthAll)) ? $tradingAcMonthAll : array();
$row_old_main_part = (isset($tradingAcMonthAll)) ? $tradingAcMonthAll : array();

foreach($tradingAc['mineralsData'] as $key=>$val){

	// MINERAL
	$diff['mineralsData'][$key]['local_mineral_code']['class'] = '';
	$diff['mineralsData'][$key]['local_mineral_code']['title'] = '';

	// GRADES OF MINERAL
	$diff['mineralsData'][$key]['local_grade_code']['class'] = '';
	$diff['mineralsData'][$key]['local_grade_code']['title'] = '';

	// MINERALS DATA
	$diff['mineralsData'][$key]['opening_stock']['class'] = '';
	$diff['mineralsData'][$key]['opening_stock']['title'] = '';
	$diff['mineralsData'][$key]['closing_stock']['class'] = '';
	$diff['mineralsData'][$key]['closing_stock']['title'] = '';

	// SUPPLIER
	$sup = $tradingAc['gradeforMineral'][$key]['supplier'];
	$sup_cnt = $sup['suppliercount'];
	for($rw=1; $rw<=$sup_cnt; $rw++){
		$diff['gradeforMineral'][$key]['supplier']['registration_no_'.$rw]['class'] = '';
		$diff['gradeforMineral'][$key]['supplier']['registration_no_'.$rw]['title'] = '';
		$diff['gradeforMineral'][$key]['supplier']['quantity_'.$rw]['class'] = '';
		$diff['gradeforMineral'][$key]['supplier']['quantity_'.$rw]['title'] = '';
		$diff['gradeforMineral'][$key]['supplier']['value_'.$rw]['class'] = '';
		$diff['gradeforMineral'][$key]['supplier']['value_'.$rw]['title'] = '';
	}
	
	// IMPORT DATA
	$imp = $tradingAc['gradeforMineral'][$key]['importData'];
	$imp_cnt = $imp['importcount'];
	for($rw=1; $rw<=$imp_cnt; $rw++){
		$diff['gradeforMineral'][$key]['importData']['country_name_'.$rw]['class'] = '';
		$diff['gradeforMineral'][$key]['importData']['country_name_'.$rw]['title'] = '';
		$diff['gradeforMineral'][$key]['importData']['quantity_'.$rw]['class'] = '';
		$diff['gradeforMineral'][$key]['importData']['quantity_'.$rw]['title'] = '';
		$diff['gradeforMineral'][$key]['importData']['value_'.$rw]['class'] = '';
		$diff['gradeforMineral'][$key]['importData']['value_'.$rw]['title'] = '';
	}
	
	// CONSUMED DATA
	$diff['gradeforMineral'][$key]['consumeData']['quantity']['class'] = '';
	$diff['gradeforMineral'][$key]['consumeData']['quantity']['title'] = '';
	$diff['gradeforMineral'][$key]['consumeData']['value']['class'] = '';
	$diff['gradeforMineral'][$key]['consumeData']['value']['title'] = '';
	
	// DESPATCH
	$des = $tradingAc['gradeforMineral'][$key]['despatch'];
	$des_cnt = $des['despatchcount'];
	for($rw=1; $rw<=$des_cnt; $rw++){
		$diff['gradeforMineral'][$key]['despatch']['registration_no_'.$rw]['class'] = '';
		$diff['gradeforMineral'][$key]['despatch']['registration_no_'.$rw]['title'] = '';
		$diff['gradeforMineral'][$key]['despatch']['quantity_'.$rw]['class'] = '';
		$diff['gradeforMineral'][$key]['despatch']['quantity_'.$rw]['title'] = '';
		$diff['gradeforMineral'][$key]['despatch']['value_'.$rw]['class'] = '';
		$diff['gradeforMineral'][$key]['despatch']['value_'.$rw]['title'] = '';
	}

	if (isset($tradingAcMonthAll) && $tradingAcMonthAll != null) {
		if (count($tradingAcMonthAll['mineralsData']) != 0 && count($tradingAcMonthAll['gradeforMineral']) != 0) {

			$mineral_code = $val['local_mineral_code'];
			$grade_code = $val['local_grade_code'];

			$mineral_code_old = (array_column($tradingAcMonthAll['mineralsData'], 'local_mineral_code'));
			$grade_code_old = (array_column($tradingAcMonthAll['mineralsData'], 'local_grade_code'));

			$min_grd_arr = array();
			foreach ($mineral_code_old as $min_key=>$min_val) {
				$min_grd_arr[$min_key] = $min_val.$grade_code_old[$min_key];
			}

			$inter_min = array_search($mineral_code.$grade_code, $min_grd_arr);

			$keys['local_mineral_code'] = array_keys(array_column($tradingAcMonthAll['mineralsData'], 'local_mineral_code'), $mineral_code);
			$keys['local_grade_code'] = array_keys(array_column($tradingAcMonthAll['mineralsData'], 'local_grade_code'), $grade_code);
			$keys_all[] = $keys['local_mineral_code'];
			$keys_all[] = $keys['local_grade_code'];

			$min = $keys['local_mineral_code'];
			$grd = $keys['local_grade_code'];

			// $inter = array_intersect(...$keys_all);
			$inter = $inter_min;
			// $inter = array_intersect(array_keys($min), $grd);

			if (is_numeric($inter_min)) {
				
				// if (isset($tradingAcMonthAll['mineralsData'][$inter[array_key_first($inter)]])) {
					// $row_old = $tradingAcMonthAll['mineralsData'][$inter[array_key_first($inter)]];
					$row_old = $tradingAcMonthAll['mineralsData'][$inter_min];
					
					// MINERALS DATA
					if ($val['opening_stock'] != $row_old['opening_stock']) {
						$diff['mineralsData'][$key]['opening_stock']['title'] = (int)$val['opening_stock'] - (int)$row_old['opening_stock'];
						$diff['mineralsData'][$key]['opening_stock']['title'] = ($diff['mineralsData'][$key]['opening_stock']['title'] > 0) ? "+".$diff['mineralsData'][$key]['opening_stock']['title'] : $diff['mineralsData'][$key]['opening_stock']['title'];
						$diff['mineralsData'][$key]['opening_stock']['class'] = ' in_modified';
					}
					
					if ($val['closing_stock'] != $row_old['closing_stock']) {
						$diff['mineralsData'][$key]['closing_stock']['title'] = (int)$val['closing_stock'] - (int)$row_old['closing_stock'];
						$diff['mineralsData'][$key]['closing_stock']['title'] = ($diff['mineralsData'][$key]['closing_stock']['title'] > 0) ? "+".$diff['mineralsData'][$key]['closing_stock']['title'] : $diff['mineralsData'][$key]['closing_stock']['title'];
						$diff['mineralsData'][$key]['closing_stock']['class'] = ' in_modified';
					}
					
					// SUPPLIER
					$sup = $tradingAc['gradeforMineral'][$key]['supplier'];
					$sup_old = $tradingAcMonthAll['gradeforMineral'][$inter_min]['supplier'];

					$sup_old_cnt = $sup_old['suppliercount'];
					for($n=1; $n <= $sup_old_cnt; $n++) {
						$reg_no_old[$n] = $sup_old['registration_no_'.$n];
					}
					
					$sup_cnt = $sup['suppliercount'];
					for($rw=1; $rw<=$sup_cnt; $rw++){

						$reg_no = $sup['registration_no_'.$rw];
						$reg_no_key = array_search($reg_no, $reg_no_old);
						$rwo = $reg_no_key;
						if ($reg_no_key != '') {

							if ($sup['quantity_'.$rw] != $sup_old['quantity_'.$rwo]) {
								$diff['gradeforMineral'][$key]['supplier']['quantity_'.$rw]['title'] = $sup['quantity_'.$rw] - $sup_old['quantity_'.$rwo];
								$diff['gradeforMineral'][$key]['supplier']['quantity_'.$rw]['title'] = ($diff['gradeforMineral'][$key]['supplier']['quantity_'.$rw]['title'] > 0) ? "+".$diff['gradeforMineral'][$key]['supplier']['quantity_'.$rw]['title'] : $diff['gradeforMineral'][$key]['supplier']['quantity_'.$rw]['title'];
								$diff['gradeforMineral'][$key]['supplier']['quantity_'.$rw]['class'] = ' in_modified';
							}
							
							if ($sup['value_'.$rw] != $sup_old['value_'.$rwo]) {
								$diff['gradeforMineral'][$key]['supplier']['value_'.$rw]['title'] = $sup['value_'.$rw] - $sup_old['value_'.$rwo];
								$diff['gradeforMineral'][$key]['supplier']['value_'.$rw]['title'] = ($diff['gradeforMineral'][$key]['supplier']['value_'.$rw]['title'] > 0) ? "+".$diff['gradeforMineral'][$key]['supplier']['value_'.$rw]['title'] : $diff['gradeforMineral'][$key]['supplier']['value_'.$rw]['title'];
								$diff['gradeforMineral'][$key]['supplier']['value_'.$rw]['class'] = ' in_modified';
							}

							unset($row_old_main_part['gradeforMineral'][$inter_min]['supplier']['registration_no_'.$rwo]);
							unset($row_old_main_part['gradeforMineral'][$inter_min]['supplier']['quantity_'.$rwo]);
							unset($row_old_main_part['gradeforMineral'][$inter_min]['supplier']['value_'.$rwo]);

						} else {
							
							$diff['gradeforMineral'][$key]['supplier']['registration_no_'.$rw]['class'] = ' in_new';
							$diff['gradeforMineral'][$key]['supplier']['registration_no_'.$rw]['title'] = 'New record';
							$diff['gradeforMineral'][$key]['supplier']['quantity_'.$rw]['class'] = ' in_new';
							$diff['gradeforMineral'][$key]['supplier']['quantity_'.$rw]['title'] = 'New record';
							$diff['gradeforMineral'][$key]['supplier']['value_'.$rw]['class'] = ' in_new';
							$diff['gradeforMineral'][$key]['supplier']['value_'.$rw]['title'] = 'New record';

						}

					}
					
					// IMPORT DATA
					$imp = $tradingAc['gradeforMineral'][$key]['importData'];
					$imp_old = $tradingAcMonthAll['gradeforMineral'][$inter_min]['importData'];
					
					$imp_old_cnt = $imp_old['importcount'];
					for($n=1; $n <= $imp_old_cnt; $n++) {
						$country_no_old[$n] = $imp_old['country_name_'.$n];
					}

					$imp_cnt = $imp['importcount'];
					for($rw=1; $rw<=$imp_cnt; $rw++){

						$country_no = $imp['country_name_'.$rw];
						$country_no_key = array_search($country_no, $country_no_old);
						$rwo = $country_no_key;
						if ($country_no_key != '') {

							if ($imp['quantity_'.$rw] != $imp_old['quantity_'.$rwo]) {
								$diff['gradeforMineral'][$key]['importData']['quantity_'.$rw]['title'] = $imp['quantity_'.$rw] - $imp_old['quantity_'.$rwo];
								$diff['gradeforMineral'][$key]['importData']['quantity_'.$rw]['title'] = ($diff['gradeforMineral'][$key]['importData']['quantity_'.$rw]['title'] > 0) ? "+".$diff['gradeforMineral'][$key]['importData']['quantity_'.$rw]['title'] : $diff['gradeforMineral'][$key]['importData']['quantity_'.$rw]['title'];
								$diff['gradeforMineral'][$key]['importData']['quantity_'.$rw]['class'] = ' in_modified';
							}
							
							if ($imp['value_'.$rw] != $imp_old['value_'.$rwo]) {
								$diff['gradeforMineral'][$key]['importData']['value_'.$rw]['title'] = $imp['value_'.$rw] - $imp_old['value_'.$rwo];
								$diff['gradeforMineral'][$key]['importData']['value_'.$rw]['title'] = ($diff['gradeforMineral'][$key]['importData']['value_'.$rw]['title'] > 0) ? "+".$diff['gradeforMineral'][$key]['importData']['value_'.$rw]['title'] : $diff['gradeforMineral'][$key]['importData']['value_'.$rw]['title'];
								$diff['gradeforMineral'][$key]['importData']['value_'.$rw]['class'] = ' in_modified';
							}

							unset($row_old_main_part['gradeforMineral'][$inter_min]['importData']['country_name_'.$rwo]);
							unset($row_old_main_part['gradeforMineral'][$inter_min]['importData']['quantity_'.$rwo]);
							unset($row_old_main_part['gradeforMineral'][$inter_min]['importData']['value_'.$rwo]);

						} else {
							
							$diff['gradeforMineral'][$key]['importData']['country_name_'.$rw]['class'] = ' in_new';
							$diff['gradeforMineral'][$key]['importData']['country_name_'.$rw]['title'] = 'New record';
							$diff['gradeforMineral'][$key]['importData']['quantity_'.$rw]['class'] = ' in_new';
							$diff['gradeforMineral'][$key]['importData']['quantity_'.$rw]['title'] = 'New record';
							$diff['gradeforMineral'][$key]['importData']['value_'.$rw]['class'] = ' in_new';
							$diff['gradeforMineral'][$key]['importData']['value_'.$rw]['title'] = 'New record';

						}

					}
					
					// CONSUMED DATA
					if ($section_no == 3) {
						$con = $tradingAc['gradeforMineral'][$key]['consumeData'];
						$con_old = $tradingAcMonthAll['gradeforMineral'][$inter_min]['consumeData'];
						if ($con['quantity'] != $con_old['quantity']) {
							$diff['gradeforMineral'][$key]['consumeData']['quantity']['title'] = $con['quantity'] - $con_old['quantity'];
							$diff['gradeforMineral'][$key]['consumeData']['quantity']['title'] = ($diff['gradeforMineral'][$key]['consumeData']['quantity']['title'] > 0) ? "+".$diff['gradeforMineral'][$key]['consumeData']['quantity']['title'] : $diff['gradeforMineral'][$key]['consumeData']['quantity']['title'];
							$diff['gradeforMineral'][$key]['consumeData']['quantity']['class'] = ' in_modified';
						}
						
						if ($con['value'] != $con_old['value']) {
							$diff['gradeforMineral'][$key]['consumeData']['value']['title'] = $con['value'] - $con_old['value'];
							$diff['gradeforMineral'][$key]['consumeData']['value']['title'] = ($diff['gradeforMineral'][$key]['consumeData']['value']['title'] > 0) ? "+".$diff['gradeforMineral'][$key]['consumeData']['value']['title'] : $diff['gradeforMineral'][$key]['consumeData']['value']['title'];
							$diff['gradeforMineral'][$key]['consumeData']['value']['class'] = ' in_modified';
						}
					}

					// DESPATCH
					$des = $tradingAc['gradeforMineral'][$key]['despatch'];
					$des_old = $tradingAcMonthAll['gradeforMineral'][$inter_min]['despatch'];

					$des_old_cnt = $des_old['despatchcount'];
					for($n=1; $n <= $des_old_cnt; $n++) {
						$reg_nno_old[$n] = $des_old['registration_no_'.$n];
					}
					
					$des_cnt = $des['despatchcount'];
					for($rw=1; $rw<=$des_cnt; $rw++){

						$reg_nno = $des['registration_no_'.$rw];
						$reg_nno_key = array_search($reg_nno, $reg_nno_old);
						$rwo = $reg_nno_key;
						if ($reg_nno_key != '') {

							if ($des['quantity_'.$rw] != $des_old['quantity_'.$rwo]) {
								$diff['gradeforMineral'][$key]['despatch']['quantity_'.$rw]['title'] = $des['quantity_'.$rw] - $des_old['quantity_'.$rwo];
								$diff['gradeforMineral'][$key]['despatch']['quantity_'.$rw]['title'] = ($diff['gradeforMineral'][$key]['despatch']['quantity_'.$rw]['title'] > 0) ? "+".$diff['gradeforMineral'][$key]['despatch']['quantity_'.$rw]['title'] : $diff['gradeforMineral'][$key]['despatch']['quantity_'.$rw]['title'];
								$diff['gradeforMineral'][$key]['despatch']['quantity_'.$rw]['class'] = ' in_modiified';
							}
							
							if ($des['value_'.$rw] != $des_old['value_'.$rwo]) {
								$diff['gradeforMineral'][$key]['despatch']['value_'.$rw]['title'] = $des['value_'.$rw] - $des_old['value_'.$rwo];
								$diff['gradeforMineral'][$key]['despatch']['value_'.$rw]['title'] = ($diff['gradeforMineral'][$key]['despatch']['value_'.$rw]['title'] > 0) ? "+".$diff['gradeforMineral'][$key]['despatch']['value_'.$rw]['title'] : $diff['gradeforMineral'][$key]['despatch']['value_'.$rw]['title'];
								$diff['gradeforMineral'][$key]['despatch']['value_'.$rw]['class'] = ' in_modiified';
							}

							unset($row_old_main_part['gradeforMineral'][$inter_min]['despatch']['registration_no_'.$rwo]);
							unset($row_old_main_part['gradeforMineral'][$inter_min]['despatch']['quantity_'.$rwo]);
							unset($row_old_main_part['gradeforMineral'][$inter_min]['despatch']['value_'.$rwo]);

						} else {
							
							$diff['gradeforMineral'][$key]['despatch']['registration_no_'.$rw]['class'] = ' in_new';
							$diff['gradeforMineral'][$key]['despatch']['registration_no_'.$rw]['title'] = 'New record';
							$diff['gradeforMineral'][$key]['despatch']['quantity_'.$rw]['class'] = ' in_new';
							$diff['gradeforMineral'][$key]['despatch']['quantity_'.$rw]['title'] = 'New record';
							$diff['gradeforMineral'][$key]['despatch']['value_'.$rw]['class'] = ' in_new';
							$diff['gradeforMineral'][$key]['despatch']['value_'.$rw]['title'] = 'New record';

						}

					}
					
					unset($row_old_main['mineralsData'][$inter_min]);
					unset($row_old_main['gradeforMineral'][$inter_min]);
				// }

			} else {
				
				// MINERAL
				$diff['mineralsData'][$key]['local_mineral_code']['class'] = ' in_new';
				$diff['mineralsData'][$key]['local_mineral_code']['title'] = 'New Record';

				// GRADES OF MINERAL
				$diff['mineralsData'][$key]['local_grade_code']['class'] = ' in_new';
				$diff['mineralsData'][$key]['local_grade_code']['title'] = 'New Record';

				// MINERALS DATA
				$diff['mineralsData'][$key]['opening_stock']['class'] = ' in_new';
				$diff['mineralsData'][$key]['opening_stock']['title'] = 'New Record';
				$diff['mineralsData'][$key]['closing_stock']['class'] = ' in_new';
				$diff['mineralsData'][$key]['closing_stock']['title'] = 'New Record';

				// SUPPLIER
				$sup = $tradingAc['gradeforMineral'][$key]['supplier'];
				$sup_cnt = $sup['suppliercount'];
				for($rw=1; $rw<=$sup_cnt; $rw++){
					$diff['gradeforMineral'][$key]['supplier']['registration_no_'.$rw]['class'] = ' in_new';
					$diff['gradeforMineral'][$key]['supplier']['registration_no_'.$rw]['title'] = 'New Record';
					$diff['gradeforMineral'][$key]['supplier']['quantity_'.$rw]['class'] = ' in_new';
					$diff['gradeforMineral'][$key]['supplier']['quantity_'.$rw]['title'] = 'New Record';
					$diff['gradeforMineral'][$key]['supplier']['value_'.$rw]['class'] = ' in_new';
					$diff['gradeforMineral'][$key]['supplier']['value_'.$rw]['title'] = 'New Record';
				}
				
				// IMPORT DATA
				$imp = $tradingAc['gradeforMineral'][$key]['importData'];
				$imp_cnt = $imp['importcount'];
				for($rw=1; $rw<=$imp_cnt; $rw++){
					$diff['gradeforMineral'][$key]['importData']['country_name_'.$rw]['class'] = ' in_new';
					$diff['gradeforMineral'][$key]['importData']['country_name_'.$rw]['title'] = 'New Record';
					$diff['gradeforMineral'][$key]['importData']['quantity_'.$rw]['class'] = ' in_new';
					$diff['gradeforMineral'][$key]['importData']['quantity_'.$rw]['title'] = 'New Record';
					$diff['gradeforMineral'][$key]['importData']['value_'.$rw]['class'] = ' in_new';
					$diff['gradeforMineral'][$key]['importData']['value_'.$rw]['title'] = 'New Record';
				}
				
				// CONSUMED DATA
				$diff['gradeforMineral'][$key]['consumeData']['quantity']['class'] = ' in_new';
				$diff['gradeforMineral'][$key]['consumeData']['quantity']['title'] = 'New Record';
				$diff['gradeforMineral'][$key]['consumeData']['value']['class'] = ' in_new';
				$diff['gradeforMineral'][$key]['consumeData']['value']['title'] = 'New Record';
				
				// DESPATCH
				$des = $tradingAc['gradeforMineral'][$key]['despatch'];
				$des_cnt = $des['despatchcount'];
				for($rw=1; $rw<=$des_cnt; $rw++){
					$diff['gradeforMineral'][$key]['despatch']['registration_no_'.$rw]['class'] = ' in_new';
					$diff['gradeforMineral'][$key]['despatch']['registration_no_'.$rw]['title'] = 'New Record';
					$diff['gradeforMineral'][$key]['despatch']['quantity_'.$rw]['class'] = ' in_new';
					$diff['gradeforMineral'][$key]['despatch']['quantity_'.$rw]['title'] = 'New Record';
					$diff['gradeforMineral'][$key]['despatch']['value_'.$rw]['class'] = ' in_new';
					$diff['gradeforMineral'][$key]['despatch']['value_'.$rw]['title'] = 'New Record';
				}

			}
		}

	}
	
}


// DELETED RECORDS
if (isset($tradingAcMonthAll) && $tradingAcMonthAll != null) {
	if (count($tradingAcMonthAll['mineralsData']) != 0 && count($tradingAcMonthAll['gradeforMineral']) != 0) {
		$min_row_span_month_all = array();
		$min_val_month_all = "";
		$min_code_row_month_all = array();
		foreach($row_old_main['mineralsData'] as $key=>$val){
			
			//set mineral rowspan structure
			if($val['local_mineral_code'] == ''){
				$min_count = 1;
			} else if($min_val_month_all == $val['local_mineral_code']){
				$min_count = 0;
				// $min_row_span_month_all[$key-1] = $min_row_span_month_all[$key-1] + 1;
				$min_code_key = $min_code_row_month_all[$val['local_mineral_code']];
				$min_row_span_month_all[$min_code_key] = $min_row_span_month_all[$min_code_key] + 1;
			} else {
				$min_count = 1;
				$min_code_row_month_all[$val['local_mineral_code']] = $key;
			}
			$min_row_span_month_all[$key] = $min_count;
			$min_val_month_all = $val['local_mineral_code'];

		}
	}
}

?>
<h5 class="card-title"><?php echo $label['title']; ?></h5>
<div class="position-relative row form-group mine-group">
	<div class="col-sm-12 mine-m-auto">
		<table class="table table-bordered table-sm v_a_mid_th" id="trad_ac_tbl">
			<thead class="bg-secondary text-white text-center">
				<tr>
					<th class="m_w_90"><?php echo $label[0]; ?></th>
					<th class="m_w_90"><?php echo $label[1]; ?></th>
					<th class="m_w_80"><?php echo $label[2]; ?></th>
					<th colspan="3"><?php echo $label[3]; ?></th>
					<th colspan="3"><?php echo $label[4]; ?></th>
					<?php if($section_no == 3){ ?>
						<th colspan="2"><?php echo $label[12]; ?></th>
					<?php } ?>
					<th colspan="3"><?php echo $label[5]; ?></th>
					<th class="m_w_80"><?php echo $label[6]; ?></th>
					<!-- <th rowspan="2" class="m_w_80"><?php //echo $label[13]; ?></th> -->
					<th></th>
				</tr>
				<tr>
					<th></th>
					<th></th>
					<th><?php echo $label[7]; ?></th>
					<th class="m_w_100 w_10_p">
						<?php 
						echo str_replace(
							'as allotted by the Indian Bureau of Mines to the supplier <br>(to indicate separately if more than one supplier)',
							'<span id="read_more_text_1" class="read_more_text d_none">as allotted by the Indian Bureau of Mines to the supplier <br>(to indicate separately if more than one supplier)</span><span id="read_more_link_1" class="btn read_more_link">more..</span><span id="hide_text_link_1" class="btn d_none">less..</span>',
							$label[8]
						);
						?>
					</th>
					<th class="m_w_100 w_10_p"><?php echo $label[7]; ?></th>
					<th class="m_w_120 w_11_p"><?php echo $label[9]; ?></th>
					<th class="m_w_100 w_10_p"><?php echo $label[10]; ?></th>
					<th class="m_w_100 w_10_p"><?php echo $label[7]; ?></th>
					<th class="m_w_120 w_11_p"><?php echo $label[9]; ?></th>
					<?php if($section_no == 3){ ?>
						<th class="m_w_70"><?php echo $label[7]; ?></th>
						<th class="m_w_90"><?php echo $label[9]; ?></th>
					<?php } ?>
					<?php if($section_no == 2){ ?>
						<th class="m_w_100 w_10_p"><?php echo $label[10]; ?></th>
					<?php } else { ?>
						<th class="m_w_100 w_10_p">
							<?php 
							$label[11] = str_replace(
								'as allotted by the Indian Bureau of Mines to the buyer <br>(to indicate separately if more than one buyer)',
								'<span id="read_more_text_2" class="read_more_text d_none">as allotted by the Indian Bureau of Mines to the buyer <br>(to indicate separately if more than one buyer)</span><span id="read_more_link_2" class="btn read_more_link">more..</span><span id="hide_text_link_2" class="btn d_none">less..</span>',
								$label[11]
							);
							$label[11] = str_replace(
								'as allotted by the Indian Bureau of Mines to the person-company to whom ore dispatched<br>(to indicate separately if more than one person-company)',
								'<span id="read_more_text_2" class="read_more_text d_none">as allotted by the Indian Bureau of Mines to the person-company to whom ore dispatched<br>(to indicate separately if more than one person-company)</span><span id="read_more_link_2" class="btn read_more_link">more..</span><span id="hide_text_link_2" class="btn d_none">less..</span>',
								$label[11]
							);
							echo $label[11];
							?>
						</th>
					<?php } ?>
					<th class="m_w_100 w_10_p"><?php echo $label[7]; ?></th>
					<th class="m_w_120 w_11_p"><?php echo $label[9]; ?></th>
					<th><?php echo $label[7]; ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody class="main_tbody tbody_border">
				<?php 

				$min_code_key = array();
				$min_code_key_count = array();
				
				$min_rw = 0;
				foreach($tradingAc['mineralsData'] as $key=>$val){ 
					$keyN = $key+1;
					$min_rw_span = $min_row_span[$key];

					if($min_rw_span > 0){
						$min_code_key[$val['local_mineral_code']] = $min_row_span[$key];
						$m_rw = 1; //main row
						$min_rw++; //mineral row
						$btn_rem = ($key != 0) ? '<i class="fa fa-times btn-rem btn_rem_mineral"></i>' : '';
					?>
						<tr id="c_row_<?php echo $min_rw; ?>" class="c_row_<?php echo $min_rw.'_'.$m_rw; ?> main_tr c_row">
							<td rowspan="<?php echo $min_rw_span+1; ?>" class="v_a_base">
								<div>
									<?php echo $this->Form->select('mineral_'.$min_rw, $minerals, array('empty'=>'- Select -','class'=>'form-control form-control-sm h-selectbox mineral tab_index_'.$min_rw.' valid cvOn cvReq'.$diff['mineralsData'][$key]['local_mineral_code']['class'], 'id'=>'mineral_'.$min_rw, 'title'=>$diff['mineralsData'][$key]['local_mineral_code']['title'],  'value'=>$val['local_mineral_code'])); ?>
								</div>
								<div class="err_cv"></div>
								<div class="unitSpan_mineral"></div>
							</td>
					<?php 
					} else { 
						$m_rw++; 
						$btn_rem = '<i class="fa fa-times btn-rem btn_rem_grade"></i>';
						?>
						<tr class="c_row_<?php echo $min_rw.'_'.$m_rw; ?> main_tr">
					<?php
					}
					$mrw_id = $min_rw.'_'.$m_rw; //main row id

					$min_code_key_count[$val['local_mineral_code']] = (isset($min_code_key_count[$val['local_mineral_code']])) ? ($min_code_key_count[$val['local_mineral_code']] + 1) : 1;
					?>
						<td class="v_a_base">
							<div>
								<?php echo $this->Form->select('grade_'.$mrw_id, $min_grade_arr[$key], array('empty'=>'- Select grade -','class'=>'form-control form-control-sm h-selectbox grade trad_ac_grade_select_'.$min_rw.' cvOn cvReq'.$diff['mineralsData'][$key]['local_grade_code']['class'], 'id'=>'grade_'.$mrw_id, 'title'=>$diff['mineralsData'][$key]['local_grade_code']['title'], 'value'=>$val['local_grade_code'])); ?>
							</div>
							<div class="err_cv"></div>
						</td>
						<td class="v_a_base">
							<?php echo $this->Form->control('opening_stock_quantity_'.$mrw_id, array('type'=>'text', 'class'=>'form-control form-control-sm opening_stock_quantity opening_stock_quantity_'.$min_rw.' cvOn cvReq cvNum cvMaxLen'.$diff['mineralsData'][$key]['opening_stock']['class'], 'id'=>'opening_stock_quantity_'.$mrw_id, 'title'=>$diff['mineralsData'][$key]['opening_stock']['title'], 'label'=>false, 'maxLength'=>'8', 'value'=>$val['opening_stock'])); ?>
							<div class="err_cv"></div>
						</td>
						<td colspan="3" class="v_a_base">
							<table id="supplier_table_<?php echo $mrw_id; ?>_1" class="trad_ac_grade_tbl table table-borderless">
								<thead></thead>
								<tbody>
									<?php 
									$sup = $tradingAc['gradeforMineral'][$key]['supplier'];
									$sup_cnt = $sup['suppliercount'];
									for($rw=1; $rw<=$sup_cnt; $rw++){ ?>
										<tr>
											<td class="v_a_base">
												<?php echo $this->Form->control('reg_no_'.$mrw_id.'_'.$rw, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields supplier_registration supplier_reg_noClass_'.$mrw_id.' ui-autocomplete-input cvOn cvReq'.$diff['gradeforMineral'][$key]['supplier']['registration_no_'.$rw]['class'], 'title'=>$diff['gradeforMineral'][$key]['supplier']['registration_no_'.$rw]['title'], 'id'=>'reg_no_'.$mrw_id.'_'.$rw, 'label'=>false, 'value'=>$sup['registration_no_'.$rw], 'maxlength'=>'20')); ?>
												<div class="err_cv"></div>
												<div class="sugg-box autocomp"></div>
											</td>
											<td class="v_a_base">
												<?php echo $this->Form->control('supplier_quantity_'.$mrw_id.'_'.$rw, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields supplier_quantity supplier_quantityClass_'.$mrw_id.' cvOn cvReq cvNum'.$diff['gradeforMineral'][$key]['supplier']['quantity_'.$rw]['class'], 'title'=>$diff['gradeforMineral'][$key]['supplier']['quantity_'.$rw]['title'], 'id'=>'supplier_quantity_'.$mrw_id.'_'.$rw, 'label'=>false, 'value'=>$sup['quantity_'.$rw])); ?>
												<div class="err_cv"></div>
											</td>
											<td class="v_a_base">
												<?php echo $this->Form->control('supplier_value_'.$mrw_id.'_'.$rw, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields supplier_value supplier_valueClass_'.$mrw_id.' cvOn cvReq cvNum'.$diff['gradeforMineral'][$key]['supplier']['quantity_'.$rw]['class'], 'title'=>$diff['gradeforMineral'][$key]['supplier']['quantity_'.$rw]['title'], 'id'=>'supplier_value_'.$mrw_id.'_'.$rw, 'label'=>false, 'value'=>$sup['value_'.$rw])); ?>
												<div class="err_cv"></div>
											</td>
											<td class="v_a_base mw_19">
												<?php if($sup_cnt > 1){ echo '<i class="fa fa-times btn-rem btn_rem_supplier"></i>'; } ?>
											</td>
										</tr>
									<?php } ?>
									
									<?php 
									
									// This extra loop is only for showing deleted records in the annual return
									// as compares to monthly return
									// Effective from Phase-II
									// Added on 13th Dec 2021 by Aniket Ganvir
									if (isset($row_old_main_part) && $row_old_main_part != null) {
										if (count($tradingAcMonthAll['mineralsData']) != 0 && count($tradingAcMonthAll['gradeforMineral']) != 0) {
											if (isset($row_old_main_part['gradeforMineral'][$key]['supplier'])) {
												$sup = $row_old_main_part['gradeforMineral'][$key]['supplier'];
												$sup_cnt = $sup['suppliercount'];
												for($rw=1; $rw<=$sup_cnt; $rw++){
													if (isset($sup['registration_no_'.$rw])) {
														?>
														<tr>
															<td class="v_a_base">
																<?php echo $this->Form->control('reg_no_'.$mrw_id.'_'.$rw, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields supplier_registration supplier_reg_noClass_'.$mrw_id.' ui-autocomplete-input cvOn cvReq in_old', 'title'=>'Deleted record', 'id'=>'reg_no_'.$mrw_id.'_'.$rw, 'label'=>false, 'value'=>$sup['registration_no_'.$rw], 'maxlength'=>'20')); ?>
																<div class="err_cv"></div>
																<div class="sugg-box autocomp"></div>
															</td>
															<td class="v_a_base">
																<?php echo $this->Form->control('supplier_quantity_'.$mrw_id.'_'.$rw, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields supplier_quantity supplier_quantityClass_'.$mrw_id.' cvOn cvReq cvNum in_old', 'title'=>'Deleted record', 'id'=>'supplier_quantity_'.$mrw_id.'_'.$rw, 'label'=>false, 'value'=>$sup['quantity_'.$rw])); ?>
																<div class="err_cv"></div>
															</td>
															<td class="v_a_base">
																<?php echo $this->Form->control('supplier_value_'.$mrw_id.'_'.$rw, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields supplier_value supplier_valueClass_'.$mrw_id.' cvOn cvReq cvNum in_old', 'title'=>'Deleted record', 'id'=>'supplier_value_'.$mrw_id.'_'.$rw, 'label'=>false, 'value'=>$sup['value_'.$rw])); ?>
																<div class="err_cv"></div>
															</td>
															<td class="v_a_base mw_19">
																<?php if($sup_cnt > 1){ echo '<i class="fa fa-times btn-rem btn_rem_supplier"></i>'; } ?>
															</td>
														</tr>
													<?php } ?>
												<?php } ?>
											<?php } ?>
										<?php } ?>
									<?php } ?>
								</tbody>
								<thead>
									<tr>
										<th colspan="4">
											<?php echo $this->Form->button('<i class="fa fa-plus"></i> '.$label['btn_3'], array('type'=>'button', 'id'=>'add_more_supplier_'.$mrw_id.'_1', 'class'=>'btn btn-sm btn-info btn-add-more h-add-more-btn supplier_add_more', 'escapeTitle'=>false)); ?>
										</th>
									</tr>
								</thead>
							</table>
							<?php echo $this->Form->control('purchase_cnt_'.$mrw_id, array('type'=>'hidden', 'id'=>'purchase_cnt_'.$mrw_id, 'value'=>$sup_cnt)); ?>
						</td>
						<td colspan="3" class="v_a_base">
							<table id="import_table_<?php echo $mrw_id; ?>_1" class="trad_ac_import_tbl table table-borderless">
								<thead></thead>
								<tbody>
									<?php 
									$imp = $tradingAc['gradeforMineral'][$key]['importData'];
									$imp_cnt = $imp['importcount'];
									for($rw=1; $rw<=$imp_cnt; $rw++){ ?>
										<tr>
											<td class="v_a_base">
												<?php echo $this->Form->select('import_country_'.$mrw_id.'_'.$rw, $countries, array('class'=>'form-control form-control-sm text-fields import_country import_countryClass_'.$mrw_id.' ui-autocomplete-input cvOn cvNotReq'.$diff['gradeforMineral'][$key]['importData']['country_name_'.$rw]['class'], 'title'=>$diff['gradeforMineral'][$key]['importData']['country_name_'.$rw]['title'], 'id'=>'import_country_'.$mrw_id.'_'.$rw, 'label'=>false, 'value'=>$imp['country_name_'.$rw])); ?>
											</td>
											<td class="v_a_base">
												<?php echo $this->Form->control('import_quantity_'.$mrw_id.'_'.$rw, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields import_quantity import_quantityClass_'.$mrw_id.' cvOn cvReq cvNum'.$diff['gradeforMineral'][$key]['importData']['quantity_'.$rw]['class'], 'title'=>$diff['gradeforMineral'][$key]['importData']['quantity_'.$rw]['title'], 'id'=>'import_quantity_'.$mrw_id.'_'.$rw, 'label'=>false, 'value'=>$imp['quantity_'.$rw])); ?>
												<div class="err_cv"></div>
											</td>
											<td class="v_a_base">
												<?php echo $this->Form->control('import_value_'.$mrw_id.'_'.$rw, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields import_value import_value_'.$mrw_id.' cvOn cvNum cvNotReq'.$diff['gradeforMineral'][$key]['importData']['value_'.$rw]['class'], 'title'=>$diff['gradeforMineral'][$key]['importData']['value_'.$rw]['title'], 'id'=>'import_value_'.$mrw_id.'_'.$rw, 'label'=>false, 'value'=>$imp['value_'.$rw])); ?>
											</td>
											<td class="v_a_base mw_19">
												<?php if($imp_cnt > 1){ echo '<i class="fa fa-times btn-rem btn_rem_import"></i>'; } ?>
											</td>
										</tr>
									<?php } ?>
									
									<?php 
									
									// This extra loop is only for showing deleted records in the annual return
									// as compares to monthly return
									// Effective from Phase-II
									// Added on 13th Dec 2021 by Aniket Ganvir
									if (isset($row_old_main_part) && $row_old_main_part != null) {
										if (count($tradingAcMonthAll['mineralsData']) != 0 && count($tradingAcMonthAll['gradeforMineral']) != 0) {
											if (isset($row_old_main_part['gradeforMineral'][$key]['importData'])) {
												$imp = $row_old_main_part['gradeforMineral'][$key]['importData'];
												$imp_cnt = $imp['importcount'];
												for($rw=1; $rw<=$imp_cnt; $rw++){
													if (isset($sup['country_name_'.$rw])) { ?>
														<tr>
															<td class="v_a_base">
																<?php echo $this->Form->seelect('import_country_'.$mrw_id.'_'.$rw, $countries, array('class'=>'form-control form-control-sm text-fields import_country import_countryClass_'.$mrw_id.' ui-autocomplete-input cvOn cvNotReq in_old', 'title'=>'Deleted record', 'id'=>'import_country_'.$mrw_id.'_'.$rw, 'label'=>false, 'value'=>$imp['country_name_'.$rw])); ?>
															</td>
															<td class="v_a_base">
																<?php echo $this->Form->control('import_quantity_'.$mrw_id.'_'.$rw, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields import_quantity import_quantityClass_'.$mrw_id.' cvOn cvReq cvNum in_old', 'title'=>'Deleted record', 'id'=>'import_quantity_'.$mrw_id.'_'.$rw, 'label'=>false, 'value'=>$imp['quantity_'.$rw])); ?>
																<div class="err_cv"></div>
															</td>
															<td class="v_a_base">
																<?php echo $this->Form->control('import_value_'.$mrw_id.'_'.$rw, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields import_value import_value_'.$mrw_id.' cvOn cvNum cvNotReq in_old', 'title'=>'Deleted record', 'id'=>'import_value_'.$mrw_id.'_'.$rw, 'label'=>false, 'value'=>$imp['value_'.$rw])); ?>
															</td>
															<td class="v_a_base mw_19">
																<?php if($imp_cnt > 1){ echo '<i class="fa fa-times btn-rem btn_rem_import"></i>'; } ?>
															</td>
														</tr>
													<?php } ?>
												<?php } ?>
											<?php } ?>
										<?php } ?>
									<?php } ?>
								</tbody>
								<thead>
									<tr>
										<th colspan="4">
											<?php echo $this->Form->button('<i class="fa fa-plus"></i> '.$label['btn'], array('type'=>'button', 'id'=>'add_more_import_'.$mrw_id.'_1', 'class'=>'btn btn-sm btn-info btn-add-more h-add-more-btn import_add_more', 'escapeTitle'=>false)); ?>
										</th>
									</tr>
								</thead>
							</table>
							<?php echo $this->Form->control('import_cnt_'.$mrw_id, array('type'=>'hidden', 'id'=>'import_cnt_'.$mrw_id, 'value'=>$imp_cnt)); ?>
						</td>

						<?php if($section_no == 3){ $cons = $tradingAc['gradeforMineral'][$key]['consumeData']; ?>

							<td class="v_a_base">
								<?php echo $this->Form->control('consumeQuantity_'.$mrw_id, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields consume_quantity consume_quantity_'.$min_rw.' cvOn cvReq cvNum cvMaxLen'.$diff['gradeforMineral'][$key]['consumeData']['quantity']['class'], 'title'=>$diff['gradeforMineral'][$key]['consumeData']['quantity']['title'], 'id'=>'consumeQuantity_'.$mrw_id, 'label'=>false, 'maxLength'=>'10', 'value'=>$cons['quantity'])); ?>
								<div class="err_cv"></div>
							</td>
							<td class="v_a_base">
								<?php echo $this->Form->control('consumeValue_'.$mrw_id, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields consume_value consume_value_'.$min_rw.' cvOn cvNum cvMaxLen cvNotReq'.$diff['gradeforMineral'][$key]['consumeData']['value']['class'], 'title'=>$diff['gradeforMineral'][$key]['consumeData']['value']['title'], 'id'=>'consumeValue_'.$mrw_id, 'label'=>false, 'maxLength'=>'10', 'value'=>$cons['value'])); ?>
							</td>
						
						<?php } ?>

						<td colspan="3" class="v_a_base">
							<table id="buyer_table_<?php echo $mrw_id; ?>_1" class="trad_ac_buyer_tbl table table-borderless">
								<thead></thead>
								<tbody>
									<?php 
									$desp = $tradingAc['gradeforMineral'][$key]['despatch'];
									$desp_cnt = $desp['despatchcount'];
									for($rw=1; $rw<=$desp_cnt; $rw++){ ?>
										<tr>
											<td class="v_a_base">
												<?php if ($section_no == 2) { ?>
													<?php echo $this->Form->select('buyer_regNo_'.$mrw_id.'_'.$rw, $countries, array('class'=>'form-control form-control-sm text-fields buyer_country buyer_regNoClass_'.$mrw_id.' ui-autocomplete-input cvOn cvAlphaNum cvNotReq'.$diff['gradeforMineral'][$key]['despatch']['registration_no_'.$rw]['class'], 'title'=>$diff['gradeforMineral'][$key]['despatch']['registration_no_'.$rw]['title'], 'id'=>'buyer_regNo_'.$mrw_id.'_'.$rw, 'label'=>false, 'value'=>$desp['registration_no_'.$rw], 'maxlength'=>20)); ?>
												<?php } else { ?>
													<?php echo $this->Form->control('buyer_regNo_'.$mrw_id.'_'.$rw, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields buyer_registration buyer_regNoClass_'.$mrw_id.' ui-autocomplete-input cvOn cvReq'.$diff['gradeforMineral'][$key]['despatch']['registration_no_'.$rw]['class'], 'title'=>$diff['gradeforMineral'][$key]['despatch']['registration_no_'.$rw]['title'], 'id'=>'buyer_regNo_'.$mrw_id.'_'.$rw, 'label'=>false, 'autocomplete'=>"off", 'role'=>"textbox", 'aria-autocomplete'=>"list", 'aria-haspopup'=>"true", 'value'=>$desp['registration_no_'.$rw], 'maxlength'=>20)); ?>
													<div class="err_cv"></div>
													<div class="sugg-box autocomp"></div>
												<?php } ?>
											</td>
											<td class="v_a_base">
												<?php echo $this->Form->control('buyer_quantity_'.$mrw_id.'_'.$rw, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields buyer_quantity buyer_quantityClass_'.$mrw_id.' cvOn cvReq cvNum'.$diff['gradeforMineral'][$key]['despatch']['quantity_'.$rw]['class'], 'title'=>$diff['gradeforMineral'][$key]['despatch']['quantity_'.$rw]['title'], 'id'=>'buyer_quantity_'.$mrw_id.'_'.$rw, 'label'=>false, 'value'=>$desp['quantity_'.$rw])); ?>
												<div class="err_cv"></div>
											</td>
											<td class="v_a_base">
												<?php echo $this->Form->control('buyer_value_'.$mrw_id.'_'.$rw, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields buyer_value buyer_valueClass_'.$mrw_id.' cvOn cvReq cvNum'.$diff['gradeforMineral'][$key]['despatch']['value_'.$rw]['class'], 'title'=>$diff['gradeforMineral'][$key]['despatch']['value_'.$rw]['title'], 'id'=>'buyer_value_'.$mrw_id.'_'.$rw, 'label'=>false, 'value'=>$desp['value_'.$rw])); ?>
												<div class="err_cv"></div>
											</td>
											<td class="v_a_base mw_19">
												<?php if($desp_cnt > 1){ echo '<i class="fa fa-times btn-rem btn_rem_buyer"></i>'; } ?>
											</td>
										</tr>
									<?php } ?>
									
									<?php 
									// This extra loop is only for showing deleted records in the annual return
									// as compares to monthly return
									// Effective from Phase-II
									// Added on 13th Dec 2021 by Aniket Ganvir
									if (isset($row_old_main_part) && $row_old_main_part != null) {
										if (count($tradingAcMonthAll['mineralsData']) != 0 && count($tradingAcMonthAll['gradeforMineral']) != 0) {
											if (isset($row_old_main_part['gradeforMineral'][$key]['despatch'])) {
												$desp = $row_old_main_part['gradeforMineral'][$key]['despatch'];
												$desp_cnt = $desp['despatchcount'];
												for($rw=1; $rw<=$desp_cnt; $rw++){
													if (isset($sup['country_name_'.$rw])) { ?>
														<tr>
															<td class="v_a_base">
																<?php echo $this->Form->control('buyer_regNo_'.$mrw_id.'_'.$rw, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields buyer_registration buyer_regNoClass_'.$mrw_id.' ui-autocomplete-input cvOn cvReq in_old', 'title'=>'Deleted record', 'id'=>'buyer_regNo_'.$mrw_id.'_'.$rw, 'label'=>false, 'autocomplete'=>"off", 'role'=>"textbox", 'aria-autocomplete'=>"list", 'aria-haspopup'=>"true", 'value'=>$desp['registration_no_'.$rw], 'maxlength'=>20)); ?>
																<div class="err_cv"></div>
																<div class="sugg-box autocomp"></div>
															</td>
															<td class="v_a_base">
																<?php echo $this->Form->control('buyer_quantity_'.$mrw_id.'_'.$rw, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields buyer_quantity buyer_quantityClass_'.$mrw_id.' cvOn cvReq cvNum in_old', 'title'=>'Deleted record', 'id'=>'buyer_quantity_'.$mrw_id.'_'.$rw, 'label'=>false, 'value'=>$desp['quantity_'.$rw])); ?>
																<div class="err_cv"></div>
															</td>
															<td class="v_a_base">
																<?php echo $this->Form->control('buyer_value_'.$mrw_id.'_'.$rw, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields buyer_value buyer_valueClass_'.$mrw_id.' cvOn cvReq cvNum in_old', 'title'=>'Deleted record', 'id'=>'buyer_value_'.$mrw_id.'_'.$rw, 'label'=>false, 'value'=>$desp['value_'.$rw])); ?>
																<div class="err_cv"></div>
															</td>
															<td class="v_a_base mw_19">
																<?php if($desp_cnt > 1){ echo '<i class="fa fa-times btn-rem btn_rem_buyer"></i>'; } ?>
															</td>
														</tr>
													<?php } ?>
												<?php } ?>
											<?php } ?>
										<?php } ?>
									<?php } ?>
								</tbody>
								<thead>
									<tr>
										<th colspan="4">
											<?php echo $this->Form->button('<i class="fa fa-plus"></i> '.$label['btn_4'], array('type'=>'button', 'id'=>'add_more_buyer_'.$mrw_id.'_1', 'class'=>'btn btn-sm btn-info btn-add-more h-add-more-btn add_more_buyer_btn', 'escapeTitle'=>false)); ?>
										</th>
									</tr>
								</thead>
							</table>
							<?php echo $this->Form->control('despatch_cnt_'.$mrw_id, array('type'=>'hidden', 'id'=>'despatch_cnt_'.$mrw_id, 'value'=>'1')); ?>
						</td>

						<td class="v_a_base">
							<?php echo $this->Form->control('closing_stock_'.$mrw_id, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields closing_stock closing_stock_'.$min_rw.' cvOn cvReq cvNum'.$diff['mineralsData'][$key]['closing_stock']['class'], 'id'=>'closing_stock_'.$mrw_id, 'title'=>$diff['mineralsData'][$key]['closing_stock']['title'], 'label'=>false, 'value'=>$val['closing_stock'])); ?>
							<div class="err_cv"></div>
						</td>
						<!-- <td class="v_a_base">
							<?php //echo $this->Form->textarea('remark_'.$mrw_id, array('class'=>'form-control form-control-sm', 'id'=>'remark_'.$mrw_id, 'label'=>false, 'rows'=>3, 'value'=>$val['remark'])); ?>
							<div class="err_cv"></div>
						</td> -->
						<td class="v_a_base"><?php echo $btn_rem; ?></td>
					</tr>

					<?php //if($min_rw_span == 0 || $min_rw_span == 1){ ?>
					<?php if($min_code_key[$val['local_mineral_code']] == $min_code_key_count[$val['local_mineral_code']]){ ?>
						<tr class="main_tr">
							<td colspan="12">
								<?php echo $this->Form->button('<i class="fa fa-plus"></i> '.$label['btn_2'], array('type'=>'button', 'id'=>'add_grade_'.$min_rw, 'class'=>'btn btn-sm btn-info btn-add-more btn-add-more h-add-more-btn grade_add_more', 'escapeTitle'=>false)); ?>
								<?php echo $this->Form->control('grade_cnt_'.$min_rw, array('type'=>'hidden', 'id'=>'grade_cnt_'.$min_rw, 'value'=>$min_rw_span)); ?>
							</td>
						</tr>
					<?php } ?>
				
				<?php } ?>

				

				<?php 
				// This extra loop is only for showing deleted records in the annual return
				// as compares to monthly return
				// Effective from Phase-II
				// Added on 13th Dec 2021 by Aniket Ganvir
				$min_code_key = array();
				$min_code_key_count = array();

				$min_rw = 0;
				$minerals['NIL'] = 'NIL';
				$min_grade_arr_month_all['NIL'] = 'NIL';
				if (isset($tradingAcMonthAll) && $tradingAcMonthAll != null) {
					if (count($tradingAcMonthAll['mineralsData']) != 0 && count($tradingAcMonthAll['gradeforMineral']) != 0) {
						foreach($row_old_main['mineralsData'] as $key=>$val){ 
							$keyN = $key+1;
							$min_rw_span = $min_row_span_month_all[$key];

							if($min_rw_span > 0){
								$min_code_key[$val['local_mineral_code']] = $min_row_span_month_all[$key];
								$m_rw = 1; //main row
								$min_rw++; //mineral row
								$btn_rem = ($key != 0) ? '<i class="fa fa-times btn-rem btn_rem_mineral"></i>' : '';
							?>
								<tr id="c_row_<?php echo $min_rw; ?>" class="c_row_<?php echo $min_rw.'_'.$m_rw; ?> main_tr c_row">
									<td rowspan="<?php echo $min_rw_span+1; ?>" class="v_a_base">
										<div>
											<?php echo $this->Form->select('mineral_'.$min_rw, $minerals, array('empty'=>'- Select -','class'=>'form-control form-control-sm h-selectbox mineral tab_index_'.$min_rw.' valid cvOn cvReq in_old', 'title'=>'Deleted record', 'id'=>'mineral_'.$min_rw, 'value'=>$val['local_mineral_code'])); ?>
										</div>
										<div class="err_cv"></div>
										<div class="unitSpan_mineral"></div>
									</td>
							<?php 
							} else { 
								$m_rw++; 
								$btn_rem = '<i class="fa fa-times btn-rem btn_rem_grade"></i>';
								?>
								<tr class="c_row_<?php echo $min_rw.'_'.$m_rw; ?> main_tr">
							<?php
							}
							$mrw_id = $min_rw.'_'.$m_rw; //main row id
							$min_code_key_count[$val['local_mineral_code']] = (isset($min_code_key_count[$val['local_mineral_code']])) ? ($min_code_key_count[$val['local_mineral_code']] + 1) : 1;
							?>
								<td class="v_a_base">
									<div>
										<?php echo $this->Form->select('grade_'.$mrw_id, $min_grade_arr_month_all[$key], array('empty'=>'- Select grade -','class'=>'form-control form-control-sm h-selectbox grade trad_ac_grade_select_'.$min_rw.' cvOn cvReq in_old', 'title'=>'Deleted record', 'id'=>'grade_'.$mrw_id, 'value'=>$val['local_grade_code'])); ?>
									</div>
									<div class="err_cv"></div>
								</td>
								<td class="v_a_base">
									<?php echo $this->Form->control('opening_stock_quantity_'.$mrw_id, array('type'=>'text', 'class'=>'form-control form-control-sm opening_stock_quantity opening_stock_quantity_'.$min_rw.' cvOn cvReq cvNum cvMaxLen in_old', 'id'=>'opening_stock_quantity_'.$mrw_id, 'title'=>'Deleted record', 'label'=>false, 'maxLength'=>'8', 'value'=>$val['opening_stock'])); ?>
									<div class="err_cv"></div>
								</td>
								<td colspan="3" class="v_a_base">
									<table id="supplier_table_<?php echo $mrw_id; ?>_1" class="trad_ac_grade_tbl table table-borderless">
										<thead></thead>
										<tbody>
											<?php 
											$sup = $row_old_main['gradeforMineral'][$key]['supplier'];
											$sup_cnt = $sup['suppliercount'];
											for($rw=1; $rw<=$sup_cnt; $rw++){ ?>
												<tr>
													<td class="v_a_base">
														<?php echo $this->Form->control('reg_no_'.$mrw_id.'_'.$rw, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields supplier_registration supplier_reg_noClass_'.$mrw_id.' ui-autocomplete-input cvOn cvReq in_old', 'title'=>'Deleted record', 'id'=>'reg_no_'.$mrw_id.'_'.$rw, 'label'=>false, 'value'=>$sup['registration_no_'.$rw], 'maxlength'=>'20')); ?>
														<div class="err_cv"></div>
														<div class="sugg-box autocomp"></div>
													</td>
													<td class="v_a_base">
														<?php echo $this->Form->control('supplier_quantity_'.$mrw_id.'_'.$rw, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields supplier_quantity supplier_quantityClass_'.$mrw_id.' cvOn cvReq cvNum in_old', 'title'=>'Deleted record', 'id'=>'supplier_quantity_'.$mrw_id.'_'.$rw, 'label'=>false, 'value'=>$sup['quantity_'.$rw])); ?>
														<div class="err_cv"></div>
													</td>
													<td class="v_a_base">
														<?php echo $this->Form->control('supplier_value_'.$mrw_id.'_'.$rw, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields supplier_value supplier_valueClass_'.$mrw_id.' cvOn cvReq cvNum in_old', 'title'=>'Deleted record', 'id'=>'supplier_value_'.$mrw_id.'_'.$rw, 'label'=>false, 'value'=>$sup['value_'.$rw])); ?>
														<div class="err_cv"></div>
													</td>
													<td class="v_a_base mw_19">
														<?php if($sup_cnt > 1){ echo '<i class="fa fa-times btn-rem btn_rem_supplier"></i>'; } ?>
													</td>
												</tr>
											<?php } ?>
										</tbody>
										<!-- <thead>
											<tr>
												<th colspan="4">
													<?php //echo $this->Form->button('<i class="fa fa-plus"></i> '.$label['btn_3'], array('type'=>'button', 'id'=>'add_more_supplier_'.$mrw_id.'_1', 'class'=>'btn btn-sm btn-info btn-add-more h-add-more-btn supplier_add_more', 'escapeTitle'=>false)); ?>
												</th>
											</tr> -->
										</thead>
									</table>
									<?php echo $this->Form->control('purchase_cnt_'.$mrw_id, array('type'=>'hidden', 'id'=>'purchase_cnt_'.$mrw_id, 'value'=>$sup_cnt)); ?>
								</td>
								<td colspan="3" class="v_a_base">
									<table id="import_table_<?php echo $mrw_id; ?>_1" class="trad_ac_import_tbl table table-borderless">
										<thead></thead>
										<tbody>
											<?php 
											$imp = $row_old_main['gradeforMineral'][$key]['importData'];
											$imp_cnt = $imp['importcount'];
											for($rw=1; $rw<=$imp_cnt; $rw++){ ?>
												<tr>
													<td class="v_a_base">
														<?php echo $this->Form->control('import_country_'.$mrw_id.'_'.$rw, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields import_country import_countryClass_'.$mrw_id.' ui-autocomplete-input cvOn cvAlphaNum cvNotReq in_old', 'title'=>'Deleted record', 'id'=>'import_country_'.$mrw_id.'_'.$rw, 'label'=>false, 'autocomplete'=>"off", 'role'=>"textbox", 'aria-autocomplete'=>"list", 'aria-haspopup'=>"true", 'value'=>$imp['country_name_'.$rw])); ?>
														<div class="sugg-box autocomp"></div>
													</td>
													<td class="v_a_base">
														<?php echo $this->Form->control('import_quantity_'.$mrw_id.'_'.$rw, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields import_quantity import_quantityClass_'.$mrw_id.' cvOn cvReq cvNum in_old', 'title'=>'Deleted record', 'id'=>'import_quantity_'.$mrw_id.'_'.$rw, 'label'=>false, 'value'=>$imp['quantity_'.$rw])); ?>
														<div class="err_cv"></div>
													</td>
													<td class="v_a_base">
														<?php echo $this->Form->control('import_value_'.$mrw_id.'_'.$rw, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields import_value import_value_'.$mrw_id.' cvOn cvNum cvNotReq in_old', 'title'=>'Deleted record', 'id'=>'import_value_'.$mrw_id.'_'.$rw, 'label'=>false, 'value'=>$imp['value_'.$rw])); ?>
													</td>
													<!-- <td class="v_a_base">
														<?php //if($imp_cnt > 1){ echo '<i class="fa fa-times btn-rem btn_rem_import"></i>'; } ?>
													</td> -->
												</tr>
											<?php } ?>
										</tbody>
										<!-- <thead>
											<tr>
												<th colspan="4">
													<?php //echo $this->Form->button('<i class="fa fa-plus"></i> '.$label['btn'], array('type'=>'button', 'id'=>'add_more_import_'.$mrw_id.'_1', 'class'=>'btn btn-sm btn-info btn-add-more h-add-more-btn import_add_more', 'escapeTitle'=>false)); ?>
												</th>
											</tr>
										</thead> -->
									</table>
									<?php echo $this->Form->control('import_cnt_'.$mrw_id, array('type'=>'hidden', 'id'=>'import_cnt_'.$mrw_id, 'value'=>$imp_cnt)); ?>
								</td>

								<?php if($section_no == 3){ $cons = $row_old_main['gradeforMineral'][$key]['consumeData']; ?>

									<td class="v_a_base">
										<?php echo $this->Form->control('consumeQuantity_'.$mrw_id, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields consume_quantity consume_quantity_'.$min_rw.' cvOn cvReq cvNum cvMaxLen in_old', 'title'=>'Deleted record', 'id'=>'consumeQuantity_'.$mrw_id, 'label'=>false, 'maxLength'=>'10', 'value'=>$cons['quantity'])); ?>
										<div class="err_cv"></div>
									</td>
									<td class="v_a_base">
										<?php echo $this->Form->control('consumeValue_'.$mrw_id, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields consume_value consume_value_'.$min_rw.' cvOn cvNum cvMaxLen cvNotReq in_old', 'title'=>'Deleted record', 'id'=>'consumeValue_'.$mrw_id, 'label'=>false, 'maxLength'=>'10', 'value'=>$cons['value'])); ?>
									</td>
								
								<?php } ?>

								<td colspan="3" class="v_a_base">
									<table id="buyer_table_<?php echo $mrw_id; ?>_1" class="trad_ac_buyer_tbl table table-borderless">
										<thead></thead>
										<tbody>
											<?php 
											$desp = $row_old_main['gradeforMineral'][$key]['despatch'];
											$desp_cnt = $desp['despatchcount'];
											for($rw=1; $rw<=$desp_cnt; $rw++){ ?>
												<tr>
													<td class="v_a_base">
														<?php echo $this->Form->control('buyer_regNo_'.$mrw_id.'_'.$rw, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields buyer_registration buyer_regNoClass_'.$mrw_id.' ui-autocomplete-input cvOn cvReq in_old', 'title'=>'Deleted record', 'id'=>'buyer_regNo_'.$mrw_id.'_'.$rw, 'label'=>false, 'autocomplete'=>"off", 'role'=>"textbox", 'aria-autocomplete'=>"list", 'aria-haspopup'=>"true", 'value'=>$desp['registration_no_'.$rw], 'maxlength'=>20)); ?>
														<div class="err_cv"></div>
														<div class="sugg-box autocomp"></div>
													</td>
													<td class="v_a_base">
														<?php echo $this->Form->control('buyer_quantity_'.$mrw_id.'_'.$rw, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields buyer_quantity buyer_quantityClass_'.$mrw_id.' cvOn cvReq cvNum in_old', 'title'=>'Deleted record', 'id'=>'buyer_quantity_'.$mrw_id.'_'.$rw, 'label'=>false, 'value'=>$desp['quantity_'.$rw])); ?>
														<div class="err_cv"></div>
													</td>
													<td class="v_a_base">
														<?php echo $this->Form->control('buyer_value_'.$mrw_id.'_'.$rw, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields buyer_value buyer_valueClass_'.$mrw_id.' cvOn cvReq cvNum in_old', 'title'=>'Deleted record', 'id'=>'buyer_value_'.$mrw_id.'_'.$rw, 'label'=>false, 'value'=>$desp['value_'.$rw])); ?>
														<div class="err_cv"></div>
													</td>
													<!-- <td class="v_a_base">
														<?php //if($desp_cnt > 1){ echo '<i class="fa fa-times btn-rem btn_rem_buyer"></i>'; } ?>
													</td> -->
												</tr>
											<?php } ?>
										</tbody>
										<!-- <thead>
											<tr>
												<th colspan="4">
													<?php //echo $this->Form->button('<i class="fa fa-plus"></i> '.$label['btn_4'], array('type'=>'button', 'id'=>'add_more_buyer_'.$mrw_id.'_1', 'class'=>'btn btn-sm btn-info btn-add-more h-add-more-btn add_more_buyer_btn', 'escapeTitle'=>false)); ?>
												</th>
											</tr>
										</thead> -->
									</table>
									<?php echo $this->Form->control('despatch_cnt_'.$mrw_id, array('type'=>'hidden', 'id'=>'despatch_cnt_'.$mrw_id, 'value'=>'1')); ?>
								</td>

								<td class="v_a_base">
									<?php echo $this->Form->control('closing_stock_'.$mrw_id, array('type'=>'text', 'class'=>'form-control form-control-sm text-fields closing_stock closing_stock_'.$min_rw.' cvOn cvReq cvNum in_old', 'id'=>'closing_stock_'.$mrw_id, 'title'=>'Deleted record', 'label'=>false, 'value'=>$val['closing_stock'])); ?>
									<div class="err_cv"></div>
								</td>
								<td class="v_a_base">
								</td>
								<!-- <td class="v_a_base"><?php echo $btn_rem; ?></td> -->
							</tr>

							<?php //if($min_rw_span == 0 || $min_rw_span == 1){ ?>
							<?php //if($min_code_key[$val['local_mineral_code']] == $min_code_key_count[$val['local_mineral_code']]){ ?>
								<!-- <tr class="main_tr">
									<td colspan="12">
										<?php //echo $this->Form->button('<i class="fa fa-plus"></i> '.$label['btn_2'], array('type'=>'button', 'id'=>'add_grade_'.$min_rw, 'class'=>'btn btn-sm btn-info h-add-more-btn grade_add_more', 'escapeTitle'=>false)); ?>
										<?php //echo $this->Form->control('grade_cnt_'.$min_rw, array('type'=>'hidden', 'id'=>'grade_cnt_'.$min_rw, 'value'=>$min_rw_span)); ?>
									</td>
								</tr> -->
							<?php //} ?>
						
						<?php } ?>
					<?php } ?>
				<?php } ?>
			</tbody>
			
			<thead>
				<tr>
					<th colspan="13">
						<?php echo $this->Form->button('<i class="fa fa-plus"></i> '.$label['btn_1'], array('type'=>'button', 'id'=>'add_more_mineral', 'class'=>'btn btn-sm btn-info btn-add-more h-add-more-btn', 'escapeTitle'=>false)); ?>
					</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<?php echo $this->Form->control('error-check', ['type'=>'hidden', 'id'=>'error-check', 'class'=>'error-check']); ?>

<?php echo $this->Form->control('uType', ['type'=>'hidden', 'id'=>'uType', 'value'=>$userType]); ?>
<?php echo $this->Form->control('fType', ['type'=>'hidden', 'id'=>'fType', 'value'=>$formType]); ?>
<?php echo $this->Form->control('return_date', ['type'=>'hidden', 'id'=>'return_date', 'value'=>$returnDate]); ?>
<?php echo $this->Form->control('return_type', ['type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType]); ?>
<?php echo $this->Form->control('end_user_id', ['type'=>'hidden', 'value'=>$endUserId]); ?>
<?php echo $this->Form->control('user_type', ['type'=>'hidden', 'value'=>$userType]); ?>
<?php echo $this->Form->control('', ['type'=>'hidden','id'=>'form_id_name', 'label'=>false, 'value'=>'frmActivityDetails']); ?>

<?php echo $this->Form->control('c_row', ['type'=>'hidden','id'=>'c_row_count','value'=>'1']); ?>
<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'get_grade_detail_url', 'value'=>$this->Url->build(['controller'=>'ajax', 'action'=>'get_trad_ac_grade_detail'])]); ?>
<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'raw_material_metal_url', 'value'=>$this->Url->build(['controller'=>'ajax', 'action'=>'get_raw_materials_metals_unit'])]); ?>
<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'get_country_url', 'value'=>$this->Url->build(['controller'=>'ajax', 'action'=>'get_country_name_l_series'])]); ?>
<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'get_regno_url', 'value'=>$this->Url->build(['controller'=>'ajax', 'action'=>'get_registration_no'])]); ?>
<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'first_mineral', 'value'=>$tradingAc['mineralsData'][0]['local_mineral_code']]); ?>
<?php echo $this->Form->control('mineral_cnt', ['type'=>'hidden','id'=>'mineral_cnt']); ?>
<?php echo $this->Form->control('gradeCount', ['type'=>'hidden','id'=>'gradeCount']); ?>
<?php echo $this->Form->control('supplierCount', ['type'=>'hidden','id'=>'supplierCount']); ?>
<?php echo $this->Form->control('importQuantityCount', ['type'=>'hidden','id'=>'importQuantityCount']); ?>
<?php echo $this->Form->control('buyerRegNoCount', ['type'=>'hidden','id'=>'buyerRegNoCount']); ?>
<?php echo $this->Form->control('checkMineralDuplicasy', ['type'=>'hidden','id'=>'checkMineralDuplicasy']); ?>
<?php echo $this->Form->control('section_no', ['type'=>'hidden','id'=>'section_no','value'=>$section_no]); ?>

<?php echo $this->Html->script('l/trading_activity.js?version='.$version); ?>
