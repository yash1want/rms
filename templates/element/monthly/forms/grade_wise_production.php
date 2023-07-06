
<?php echo $this->Html->script('f/grade_wise_production.js?version='.$version); ?>

<?php

if ($primaryMineral == 'IRON_ORE') { $count = 3; } else { $count = 2; }
$formNo = $this->getRequest()->getSession()->read('mc_form_type');
$minUndLow = strtolower(str_replace(' ','_',$mineral)); //mineral underscore lowercase

function rome($number) {
	$map = array('M' => 1000, 'cm' => 900, 'd' => 500, 'cd' => 400, 'c' => 100, 'xc' => 90, 'l' => 50, 'xl' => 40, 'x' => 10, 'ix' => 9, 'v' => 5, 'iv' => 4, 'i' => 1);
	$returnValue = '';
	while ($number > 0) {
		foreach ($map as $roman => $int) {
			if($number >= $int) {
				$number -= $int;
				$returnValue .= $roman;
				break;
			}
		}
	}
	return $returnValue;
}

?>
<?php if (in_array($minUndLow, array('iron_ore', 'chromite'))) { ?>
	<h5 class="card-title text-center"><?php echo $label['title']; ?></h5>
	<div class="position-relative row form-group mine-group">
		<div class="col-sm-9 mine-m-auto">
					
			<table class="table table-bordered table-sm" id="table-gradewise-prod-rom">

				<thead class="bg-secondary text-white text-center">
					<tr>
						<th><?php echo $label[0]; ?></th>			
						<th><?php echo $label[1]; ?></th>
						<th><?php echo $label[2]; ?></th>
					</tr>
				</thead>
				<tbody>
					<?php 

					$i = 1;
					$feMinCount = 1;
					$gradeKy = $gradeWiseProdRom['gradeProd'];
					$gradeVl = $gradeWiseProdRom['gradeProd']['gradeNames'];
					
					foreach($gradeVl as $gradeKk => $mainGrade){
						
						$lilist = array('a'=>'क','b'=>'ख','c'=>'ग','d'=>'घ','e'=>'ड़','f'=>'च','g'=>'छ','h'=>'ज','i'=>'झ');
						$feMinSubCount = 'a';
						foreach ($mainGrade as $mainGradeKey => $mainGradeVal) {

							// As per new amendment, grade codes (200) are only visible for magnetite
							// Added on 22-04-2022 by Aniket Ganvir
							$showRomGrade = ($mainGradeKey == 200) ? (($ironSubMin == 'magnetite') ? true : false ) : true;

							if($showRomGrade == true){
							
								$tmpGradeFormName = "gradeForm" . $i;
								$gradeValues = $gradeWiseProdRom['gradeProd']['gradeValues'];

								// Highlight fields which are differs from cumulative monthly data in annual
								// (Sepcially for Form G1 in MMS side)
								// Effective from Phase-II
								// Added on 08th Nov 2021 by Aniket Ganvir
								$romArr = array('average_grade', 'opening_stock', 'production', 'despatches', 'pmv', 'closing_stock');
								for ($n=0; $n < 6; $n++) {

									$diff[$mainGradeKey][$romArr[$n]]['class'] = '';
									$diff[$mainGradeKey][$romArr[$n]]['title'] = '';
			
									if (isset($gradeWiseProdRomMonthly)) {
										$gwpOld = $gradeWiseProdRomMonthly;
										if (isset($gwpOld[$mainGradeKey])) {
											$romOld = $gwpOld[$mainGradeKey][$romArr[$n]];
											$romNew = $gradeValues[$mainGradeKey][$romArr[$n]];
											if ($romOld != $romNew) {
												$romDiff = (int)$romNew - (int)$romOld;
												$diff[$mainGradeKey][$romArr[$n]]['title'] = ($romDiff > 0) ? '+'.$romDiff : $romDiff;
												$diff[$mainGradeKey][$romArr[$n]]['class'] = ' in_new';
											}
										}
									}

								}

								?>
								<tr class="tbody-tr" id="tbody-tr-<?php echo $i; ?>">
									<td>
										<?php echo "(" . $feMinSubCount++ . ") " . $mainGradeVal; ?>
										<?php echo $this->Form->control('grade_code_rom[]', array('type'=>'hidden', 'id'=>'grade_code_rom-'.$i, 'label'=>false, 'value'=>$mainGradeKey)); ?>
									</td>
									<td>
										<?php echo $this->Form->control('despatches_rom[]', array('class'=>'form-control form-control-sm number-fields cvOn cvNum'.$diff[$mainGradeKey]['despatches']['class'], 'id'=>'despatches_rom-'.$i, 'label'=>false, 'title'=>$diff[$mainGradeKey]['despatches']['title'], 'value'=>$gradeValues[$mainGradeKey]['despatches'])); ?>
										<div class="err_cv"></div>
									</td>
									<td>
										<?php echo $this->Form->control('pmv_rom[]', array('class'=>'form-control form-control-sm number-fields pmvForProdCheck cvOn cvNum'.$diff[$mainGradeKey]['pmv']['class'], 'id'=>'pmv_rom-'.$i, 'label'=>false, 'title'=>$diff[$mainGradeKey]['pmv']['title'], 'value'=>$gradeValues[$mainGradeKey]['pmv'])); ?>
										<div class="err_cv"></div>
									</td>
								</tr>
							<?php  $i++; 	} 	?>
						<?php  } 	?>
					<?php 	}	$tmpGradeFormName = "gradeForm" . $i;  ?>
				</tbody>
			</table>
			<div class="alert alert-info p-2 pl-3"><em><?php echo $label['note']; ?></em></div>
		</div>

	</div>
<?php } ?>

<h5 class="card-title text-center"><?php echo $label['title_two']; ?></h5>
<div class="position-relative row form-group mine-group">
	<div class="col-sm-12 mine-m-auto">
				
		<table class="table table-bordered table-sm" id="table-gradewise-prod">

			<?php 
			// $k = 1;
			// $feMinSubCount = 'a';
			// foreach ($prodRomGradeArray as $romGradeKey => $romGradeVal) {
			// 	$tmpGradeRomFormName = "gradeRomForm" . $k;
			?>

			<?php //$k++; }	$tmpGradeRomFormName = "gradeRomForm" . $k; ?>
			<thead class="bg-secondary text-white text-center">
				<tr>
					<th width="14%"><?php echo $label[3]; ?></th>
					<?php if($formNo == 3){ ?>
						<th><?php echo $label[9]; ?></th>
					<?php } ?>
					<th><?php echo $label[4]; ?></th>
					<th><?php echo $label[5]; ?></th>
					<th><?php echo $label[6]; ?></th>
					<th><?php echo $label[7]; ?></th>
					<th><?php echo $label[8]; ?></th>
				</tr>
			</thead>
			<tbody>
				<?php 
				
				// if($_SESSION['lang']=='hindi'){ $prodGradeArray = $prodGradeArrayInHindi; }

				$i = 1;
				$feMinCount = 1;
				// foreach ($prodGradeArray as $gradeKey => $gradeVal) {
				$gradeKy = $gradeWiseProd['gradeProd'];
				$gradeVl = $gradeWiseProd['gradeProd']['gradeNames'];
				
				foreach($gradeVl as $gradeKk => $mainGrade){
				?>
					<?php if ($gradeKk != '') { ?>
						<tr>
							<td colspan="7">
								<?php if ($gradeKy != '') { ?>
									<div <?php if ($i != 1) echo 'class = "welcome-page-name plus"'; ?>>
										<b><?php echo "(" . rome($feMinCount++) . ") " . $gradeKk; ?></b>
									</div>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
					<?php
					
					$lilist = array('a'=>'क','b'=>'ख','c'=>'ग','d'=>'घ','e'=>'ड़','f'=>'च','g'=>'छ','h'=>'ज','i'=>'झ');
					$feMinSubCount = 'a';
					foreach ($mainGrade as $mainGradeKey => $mainGradeVal) {
						
						// As per new amendment, grade codes (208, 216) are only visible for magnetite
						// Added on 22-04-2022 by Aniket Ganvir
						$showGrade = (in_array($mainGradeKey, array(208, 216))) ? (($ironSubMin == 'magnetite') ? true : false ) : true;

						if($showGrade == true){

							$tmpGradeFormName = "gradeForm" . $i;
							$gradeValues = $gradeWiseProd['gradeProd']['gradeValues'];

							// Highlight fields which are differs from cumulative monthly data in annual
							// (Sepcially for Form G1 in MMS side)
							// Effective from Phase-II
							// Added on 08th Nov 2021 by Aniket Ganvir
							$romArr = array('average_grade', 'opening_stock', 'production', 'despatches', 'pmv', 'closing_stock');
							for ($n=0; $n < 6; $n++) {

								$diff[$mainGradeKey][$romArr[$n]]['class'] = '';
								$diff[$mainGradeKey][$romArr[$n]]['title'] = '';
		
								if (isset($gradeWiseProdMonthly)) {
									$gwpOld = $gradeWiseProdMonthly;
									if (isset($gwpOld[$mainGradeKey])) {
										$romOld = $gwpOld[$mainGradeKey][$romArr[$n]];
										$romNew = $gradeValues[$mainGradeKey][$romArr[$n]];
										if ($romOld != $romNew) {
											$romDiff = $romNew - $romOld;
											$diff[$mainGradeKey][$romArr[$n]]['title'] = ($romDiff > 0) ? '+'.$romDiff : $romDiff;
											$diff[$mainGradeKey][$romArr[$n]]['class'] = ' in_new';
										}
									}
								}

							}

							?>
							<tr class="tbody-tr" id="tbody-tr-<?php echo $i; ?>">
								<?php 
									$colspan = ($formNo == 3 && $i > 6) ? "2" : "1";
								?>
								<td colspan="<?php echo $colspan; ?>">
									<?php //if($_SESSION['lang']=='hindi'){ echo "(" . $lilist[$feMinSubCount++] . ") " . $gradeLbl; }else{ echo "(" . $feMinSubCount++ . ") " . $gradeLbl; } ?>
									<?php echo "(" . $feMinSubCount++ . ") " . $mainGradeVal; ?>

									<?php echo $this->Form->control('grade_code[]', array('type'=>'hidden', 'id'=>'grade_code-'.$i, 'label'=>false, 'value'=>$mainGradeKey)); ?>
								</td>
								<?php if ($formNo == 3) { ?>
									<?php if ($i < 7) { ?>
										<td>
											<?php echo $this->Form->control('average_grade[]', array('class'=>'form-control form-control-sm avgGrade cvOn cvNotReq'.$diff[$mainGradeKey]['average_grade']['class'], 'id'=>'average_grade-'.$i, 'label'=>false, 'title'=>$diff[$mainGradeKey]['average_grade']['title'], 'value'=>$gradesArr[$i]['average_grade'])); ?>
										</td>
									<?php } ?>
								<?php } ?>
								<td>
									<?php echo $this->Form->control('opening_stock[]', array('class'=>'form-control form-control-sm number-fields openingStock cvOn cvNum'.$diff[$mainGradeKey]['opening_stock']['class'], 'id'=>'opening_stock-'.$i, 'label'=>false, 'title'=>$diff[$mainGradeKey]['opening_stock']['title'], 'value'=>$gradeValues[$mainGradeKey]['opening_stock'])); ?>
									<div class="err_cv"></div>
								</td>
								<td>
									<?php echo $this->Form->control('production[]', array('class'=>'form-control form-control-sm number-fields productionForTot cvOn cvNum'.$diff[$mainGradeKey]['production']['class'], 'id'=>'production-'.$i, 'label'=>false, 'title'=>$diff[$mainGradeKey]['production']['title'], 'value'=>$gradeValues[$mainGradeKey]['production'])); ?>
									<div class="err_cv"></div>
								</td>
								<td>
									<?php echo $this->Form->control('despatches[]', array('class'=>'form-control form-control-sm number-fields dispatches cvOn cvNum'.$diff[$mainGradeKey]['despatches']['class'], 'id'=>'despatches-'.$i, 'label'=>false, 'title'=>$diff[$mainGradeKey]['despatches']['title'], 'value'=>$gradeValues[$mainGradeKey]['despatches'])); ?>
									<div class="err_cv"></div>
								</td>
								<td>
									<?php echo $this->Form->control('closing_stock[]', array('class'=>'form-control form-control-sm number-fields closingStock cvOn cvNum'.$diff[$mainGradeKey]['closing_stock']['class'], 'id'=>'closing_stock-'.$i, 'label'=>false, 'title'=>$diff[$mainGradeKey]['closing_stock']['title'], 'value'=>$gradeValues[$mainGradeKey]['closing_stock'])); ?>
									<div class="err_cv"></div>
								</td>
								<td>
									<?php echo $this->Form->control('pmv[]', array('class'=>'form-control form-control-sm number-fields pmvForProdCheck cvOn cvNum'.$diff[$mainGradeKey]['pmv']['class'], 'id'=>'pmv-'.$i, 'label'=>false, 'title'=>$diff[$mainGradeKey]['pmv']['title'], 'value'=>$gradeValues[$mainGradeKey]['pmv'])); ?>
									<div class="err_cv"></div>
								</td>
							</tr>
						<?php  $i++; 	} 	?>
					<?php   	} 	?>
				<?php 	}	$tmpGradeFormName = "gradeForm" . $i;  ?>
			</tbody>
		</table>

		<?php if($ironSubMin == 'hematite'){ ?>
			<div class="alert alert-info p-2 pl-3"><?php echo $label['note_2']; ?></div>
		<?php } ?>
		
	</div>

</div>

<!-- For validation purpose take the values of the previous form -->
<?php echo $this->Form->control('openOcRom', array('type'=>'hidden', 'id'=>'openOcRom', 'value'=>$openOcRom)); ?>
<?php echo $this->Form->control('prodOcRom', array('type'=>'hidden', 'id'=>'prodOcRom', 'value'=>$prodOcRom)); ?>
<?php echo $this->Form->control('closeOcRom', array('type'=>'hidden', 'id'=>'closeOcRom', 'value'=>$closeOcRom)); ?>
<?php echo $this->Form->control('openUgRom', array('type'=>'hidden', 'id'=>'openUgRom', 'value'=>$openUgRom)); ?>
<?php echo $this->Form->control('prodUgRom', array('type'=>'hidden', 'id'=>'prodUgRom', 'value'=>$prodUgRom)); ?>
<?php echo $this->Form->control('closeUgRom', array('type'=>'hidden', 'id'=>'closeUgRom', 'value'=>$closeUgRom)); ?>
<?php echo $this->Form->control('openDwRom', array('type'=>'hidden', 'id'=>'openDwRom', 'value'=>$openDwRom)); ?>
<?php echo $this->Form->control('prodDwRom', array('type'=>'hidden', 'id'=>'prodDwRom', 'value'=>$prodDwRom)); ?>
<?php echo $this->Form->control('closeDwRom', array('type'=>'hidden', 'id'=>'closeDwRom', 'value'=>$closeDwRom)); ?>

<?php echo $this->Form->control('form_no', array('type'=>'hidden', 'value'=>$formId, 'id'=>'form_no')); ?>
<?php echo $this->Form->control('rom_grade', array('type'=>'hidden', 'value'=>$rom_grade, 'id'=>'rom_grade')); ?>
<?php echo $this->Form->control('mineral', array('type'=>'hidden', 'value'=>str_replace(' ','_',$mineral), 'id'=>'mineral')); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'prev_month', 'value'=>$prev_month)); ?>

<?php echo $this->Form->control('prod_grade_array_count', array('type'=>'hidden', 'value'=>str_replace(' ','_',$prodGradeArrayCount), 'id'=>'prod_grade_array_count')); ?>
<?php echo $this->Form->control('mine_code', array('type'=>'hidden', 'id'=>'mine_code', 'value'=>$mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType)); ?>
<?php echo $this->Form->control('return_date', array('type'=>'hidden', 'value'=>$returnDate)); ?>
<?php echo $this->Form->control('mineral_name', array('type'=>'hidden', 'id'=>'mineral_name', 'value'=>$mineral)); ?>
<?php echo $this->Form->control('iron_sub_min', array('type'=>'hidden', 'id'=>'iron_sub_min', 'value'=>$ironSubMin)); ?>
<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'prev_clo_stock_url', 'value'=>$this->Url->build(['controller'=>'monthly', 'action'=>'getPrevClosingStocks'])]); ?>
<?php echo $this->Form->control('', array('type'=>'hidden','id'=>'form_id_name', 'value'=>'frmGradeWiseProduction')); ?>
