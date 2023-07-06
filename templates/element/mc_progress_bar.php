
<ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav col-12 u_pb_menu pt-0">

	<?php
	$sec_link = array(); // form link array
	$linkPart = 1;
	$curController = $this->getRequest()->getParam('controller');
	$curControllerLower = strtolower($curController);
	$curAction = $this->getRequest()->getParam('action');
	$mineralParam = $this->getRequest()->getParam('pass');
	$returnType = $this->getRequest()->getSession()->read('returnType');
	if (null == $mineralParam) {
		$mineralParam = "";
	} else {
		$mineralPar = $mineralParam[0];
		$mineralPar .= (isset($mineralParam[1])) ? "/" . $mineralParam[1] : "";
		$mineralParam = $mineralPar;
	}

	$mineralParam = strtoupper($mineralParam);

	if ($curControllerLower == 'monthly' && $returnType == 'MONTHLY' && $curAction != 'selectReturn') {
	?>

		<!-- FORM F -->
		<!-- PART I -->

		<?php

		// set active sidebar menu expanded by default
		if (in_array($curAction, array('mine', 'nameAddress', 'rent', 'workingDetail', 'dailyAverage'))) {
			$partClassI = "u_progress_bar_active";
		} else {
			$partClassI = "u_progress_bar";
		}
		?>
		
		<li class="nav-item">
			<?php echo $this->Html->link('<span class="u_progress_bar_menu">PART I</span>', $_SESSION['sec_link']['part_1'][0], array('class'=>'nav-link show active '.$partClassI.' pb_menu_sec_1', 'id'=>'tab-0', 'escape'=>false, 'title'=>'PART I')); ?>
		</li>

		<!--PART II FOR PRIMARY MINERAL-->
		<?php
		$title = "Part II For ";
		$title .= ucwords(strtolower($partIIM1[0]));
		$mineral = $partIIM1[0];
		$mineralMain = $mineral;
		$ironSubMin = '';
		if (strtolower($partIIM1[0]) == strtolower('Iron Ore')) {
			if ($is_hematite) {
				$title .= ' (HEMATITE)';
				$ironSubMin = "/hematite";
				$mineralMain .= "/HEMATITE";
			} elseif ($is_magnetite) {
				$title .= ' (MAGNETITE)';
				$ironSubMin = "/magnetite";
				$mineralMain .= "/MAGNETITE";
			}
		}

		// set active sidebar menu expanded by default
		if ($mineralMain == $mineralParam) {
			$partClassII = "u_progress_bar_active";
		} else {
			$partClassII = "u_progress_bar";
		}
		?>
		
		<?php $linkPart++; ?>

		<li class="nav-item">
			<?php echo $this->Html->link('<span class="u_progress_bar_menu">'.$title.'</span>', $_SESSION['sec_link']['part_2'][0], array('class'=>'nav-link show active '.$partClassII.' pb_menu_sec_2', 'id'=>'tpartClassIIb-0', 'escape'=>false, 'title'=>$title)); ?>
		</li>

		<!--Only for Magnetite if iron ore is the primary mineral-->
		<?php

		$mineral = $partIIM1[0];
		$mineralMain = $mineral;
		$title = "Part II For ";
		$title .= ucwords(strtolower($partIIM1[0]));
		$title .= ' (MAGNETITE)';
		$ironSubMin = "/magnetite";
		$mineralMain .= "/MAGNETITE";

		// set active sidebar menu expanded by default
		if ($mineralMain == $mineralParam) {
			$partClassIII = "u_progress_bar_active";
		} else {
			$partClassIII = "u_progress_bar";
		}
		?>
		<?php if ($is_hematite && $is_magnetite && strtolower($partIIM1[0]) == strtolower('Iron Ore')) { ?>
			
			<?php $linkPart++; ?>

			<li class="nav-item">
				<?php echo $this->Html->link('<span class="u_progress_bar_menu">'.$title.'</span>', $_SESSION['sec_link']['part_'.$linkPart][0], array('class'=>'nav-link show active '.$partClassIII.' pb_menu_sec_3', 'id'=>'tab-0', 'escape'=>false, 'title'=>$title)); ?>
			</li>

		<?php } ?>

		<!--For associated minerals-->
		<?php

		$mCount = '4';
		foreach ($partIIMOther as $partIIM) {

			$title = "Part II For ";
			$title .= ucwords(strtolower($partIIM[0]));
			$mineral = $partIIM[0];
			$mineralMain = $mineral;
			$ironSubMin = '';
			$sub_min = '';
			if (strtolower($partIIM[0]) == strtolower('Iron Ore')) {
				if ($is_hematite) {
					$title .= ' (HEMATITE)';
					$ironSubMin = "/hematite";
					$mineralMain .= "/HEMATITE";
					$sub_min = "hematite";
				} elseif ($is_magnetite) {
					$title .= ' (MAGNETITE)';
					$ironSubMin = "/magnetite";
					$mineralMain .= "/MAGNETITE";
					$sub_min = "magnetite";
				}
			}

			// set active sidebar menu expanded by default
			if ($mineralMain == $mineralParam) {
				$partClassIV = "u_progress_bar_active";
			} else {
				$partClassIV = "u_progress_bar";
			}
		?>
			
			<?php $linkPart++; ?>
			
			<li class="nav-item">
				<?php echo $this->Html->link('<span class="u_progress_bar_menu">'.$title.'</span>', $_SESSION['sec_link']['part_'.$linkPart][0], array('class'=>'nav-link show active '.$partClassIV.' pb_menu_sec_'.$mCount, 'id'=>'tab-0', 'escape'=>false, 'title'=>$title)); ?>
			</li>

		<?php $mCount++;
		} ?>
		<?php
		foreach ($partIIMOther as $partIIM) { ?>

			<!--Only for Magnetite if iron ore is the associative mineral-->
			<?php if ($is_hematite && $is_magnetite && strtolower($partIIM[0]) == strtolower('Iron Ore')) { ?>
				<?php
				// set active sidebar menu expanded by default
				$title = "Part II For ";
				$title .= ucwords(strtolower($partIIM[0]));
				$mineral = $partIIM[0];
				$title .= ' (MAGNETITE)';
				$ironSubMin = '/magnetite';
				$mineralMain = $mineral . '/MAGNETITE';

				if ($mineralMain == $mineralParam) {
					$partClassV = "u_progress_bar_active";
				} else {
					$partClassV = "u_progress_bar";
				}
				?>
				
				<?php $linkPart++; ?>

				<li class="nav-item">
					<?php echo $this->Html->link('<span class="u_progress_bar_menu">'.$title.'</span>', $_SESSION['sec_link']['part_'.$linkPart][0], array('class'=>'nav-link show active '.$partClassV.' pb_menu_sec_'.$mCount, 'id'=>'tab-0', 'escape'=>false, 'title'=>$title)); ?>
				</li>
				
			<?php $mCount++;
			} ?>

		<?php } ?>

	<?php
	} else if (strtolower($curController) == 'enduser' && $curAction != 'selectReturn' && $curAction != 'selectAnnualReturn') {
	?>
		<?php if ($formType == 'N') { ?>

			<!-- FORM L -->
			<!-- PART I -->

			<?php

			// set active sidebar menu expanded by default
			if (in_array($curAction, array('instruction', 'generalParticular'))) {
				$partClassI = "u_progress_bar_active";
			} else {
				$partClassI = "u_progress_bar";
			}
			?>
			
			<li class="nav-item">
				<?php echo $this->Html->link('<span class="u_progress_bar_menu">PART I</span>', $_SESSION['sec_link']['part_1'][0], array('class'=>'nav-link show active '.$partClassI.' pb_menu_sec_1', 'id'=>'tab-0', 'escape'=>false, 'title'=>'PART I')); ?>
			</li>

			<!-- PART II -->
			<?php

			// set active sidebar menu expanded by default
			if (in_array($curAction, array('tradingActivity', 'exportOfOre', 'mineralBaseActivity', 'storageActivity'))) {
				$partClassII = "u_progress_bar_active";
			} else {
				$partClassII = "u_progress_bar";
			}
			?>
			
			<li class="nav-item">
				<?php echo $this->Html->link('<span class="u_progress_bar_menu">PART II</span>', $_SESSION['sec_link']['part_2'][0], array('class'=>'nav-link show active '.$partClassII.' pb_menu_sec_2', 'id'=>'tab-0', 'escape'=>false, 'title'=>'PART II')); ?>
			</li>

		<?php } else { ?>

			<!-- FORM M -->
			<!-- PART I -->

			<?php

			// set active sidebar menu expanded by default
			if (in_array($curAction, array('instruction', 'generalParticular'))) {
				$partClassI = "u_progress_bar_active";
			} else {
				$partClassI = "u_progress_bar";
			}
			?>
			
			<li class="nav-item">
				<?php echo $this->Html->link('<span class="u_progress_bar_menu">PART I</span>', $_SESSION['sec_link']['part_1'][0], array('class'=>'nav-link show active '.$partClassI.' pb_menu_sec_1', 'id'=>'tab-0', 'escape'=>false, 'title'=>'PART I')); ?>
			</li>

			<!-- PART II -->
			<?php

			// set active sidebar menu expanded by default
			if (in_array($curAction, array('tradingActivity', 'exportOfOre', 'mineralBaseActivity', 'storageActivity'))) {
				$partClassII = "u_progress_bar_active";
			} else {
				$partClassII = "u_progress_bar";
			}
			?>
			
			<li class="nav-item">
				<?php echo $this->Html->link('<span class="u_progress_bar_menu">PART II</span>', $_SESSION['sec_link']['part_2'][0], array('class'=>'nav-link show active '.$partClassII.' pb_menu_sec_2', 'id'=>'tab-0', 'escape'=>false, 'title'=>'PART II')); ?>
			</li>


			<!-- PART III -->
			<?php

			if ($sectionType == 'C') {
				if (in_array($curAction, array('mineralBasedIndustries', 'productManufactureDetails', 'ironSteelIndustries', 'rawMaterialConsumed', 'sourceOfSupply'))) {
					$partClassIII = "u_progress_bar_active";
				} else {
					$partClassIII = "u_progress_bar";
				}
			?>
				
				<li class="nav-item">
					<?php echo $this->Html->link('<span class="u_progress_bar_menu">PART III</span>', $_SESSION['sec_link']['part_3'][0], array('class'=>'nav-link show active '.$partClassIII.' pb_menu_sec_3', 'id'=>'tab-0', 'escape'=>false, 'title'=>'PART III')); ?>
				</li>

			<?php } ?>

		<?php } ?>

	<?php
	} else if (($curControllerLower == 'monthly' || $curControllerLower == 'annual') && $returnType == 'ANNUAL' && $curAction != 'selectReturn') {
	?>

		<!-- FORM G -->
		<!-- PART I -->
		<?php

		// set active sidebar menu expanded by default
		if (in_array($curAction, array('mine', 'nameAddress', 'particulars', 'areaUtilisation'))) {
			$partClassI = "u_progress_bar_active";
		} else {
			$partClassI = "u_progress_bar";
		}
		?>
		
		<li class="nav-item">
			<?php echo $this->Html->link('<span class="u_progress_bar_menu">PART I</span>', $_SESSION['sec_link']['part_1'][0], array('class'=>'nav-link show active '.$partClassI.' pb_menu_sec_1', 'id'=>'tab-0', 'escape'=>false, 'title'=>'PART I')); ?>
		</li>

		<!-- PART II -->
		<?php
		$mineral = $partIIM1[0];
		$mineralMain = $mineral;
		$ironSubMin = '';
		if (strtolower($partIIM1[0]) == strtolower('Iron Ore')) {
			if ($is_hematite) {
				$ironSubMin = "/hematite";
				$mineralMain .= "/HEMATITE";
			} elseif ($is_magnetite) {
				$ironSubMin = "/magnetite";
				$mineralMain .= "/MAGNETITE";
			}
		}

		// set active sidebar menu expanded by default
		if (in_array($curAction, array('employmentWages', 'employmentWagesPart', 'capitalStructure'))) {
			$partClassII = "u_progress_bar_active";
		} else {
			$partClassII = "u_progress_bar";
		}
		?>
		
		<?php $linkPart++; ?>
		
		<li class="nav-item">
			<?php echo $this->Html->link('<span class="u_progress_bar_menu">PART II</span>', $_SESSION['sec_link']['part_2'][0], array('class'=>'nav-link show active '.$partClassII.' pb_menu_sec_2', 'id'=>'tab-0', 'escape'=>false, 'title'=>'PART II')); ?>
		</li>

		<!-- PART III -->
		<?php
		$mineral = $partIIM1[0];
		$mineralMain = $mineral;
		$ironSubMin = '';

		// set active sidebar menu expanded by default
		if (in_array($curAction, array('materialConsumptionQuantity', 'materialConsumptionRoyalty', 'materialConsumptionTax'))) {
			$partClassIII = "u_progress_bar_active";
		} else {
			$partClassIII = "u_progress_bar";
		}
		?>
		
		<?php $linkPart++; ?>
		
		<li class="nav-item">
			<?php echo $this->Html->link('<span class="u_progress_bar_menu">PART III</span>', $_SESSION['sec_link']['part_'.$linkPart][0], array('class'=>'nav-link show active '.$partClassIII.' pb_menu_sec_3', 'id'=>'tab-0', 'escape'=>false, 'title'=>'PART III')); ?>
		</li>

		<!-- PART IV -->
		<?php
		$mineral = $partIIM1[0];
		$mineralMain = $mineral;
		$ironSubMin = '';

		// set active sidebar menu expanded by default
		if ($curAction == 'explosiveConsumption') {
			$partClassIV = "u_progress_bar_active";
		} else {
			$partClassIV = "u_progress_bar";
		}
		?>
		
		<?php $linkPart++; ?>
		
		<li class="nav-item">
			<?php echo $this->Html->link('<span class="u_progress_bar_menu">PART IV</span>', $_SESSION['sec_link']['part_'.$linkPart][0], array('class'=>'nav-link show active '.$partClassIV.' pb_menu_sec_4', 'id'=>'tab-0', 'escape'=>false, 'title'=>'PART IV')); ?>
		</li>


		<!-- PART V -->
		<?php
		$mineral = $partIIM1[0];
		$mineralMain = $mineral;
		$ironSubMin = '';

		// set active sidebar menu expanded by default
		// if($mineralMain == $mineralParam) {
		if (in_array($curAction, array('geologyExploration', 'geologyReservesSubgrade', 'geologyOverburdenTrees', 'geologyPartThree', 'geologyPartSix'))) {
			$partClassV = "u_progress_bar_active";
		} else {
			$partClassV = "u_progress_bar";
		}
		?>
		
		<?php $linkPart++; ?>
		
		<li class="nav-item">
			<?php echo $this->Html->link('<span class="u_progress_bar_menu">PART V</span>', $_SESSION['sec_link']['part_'.$linkPart][0], array('class'=>'nav-link show active '.$partClassV.' pb_menu_sec_5', 'id'=>'tab-0', 'escape'=>false, 'title'=>'PART V')); ?>
		</li>

		<!--PART VI FOR PRIMARY MINERAL-->
		<?php
		$title = "Part VI For ";
		$title .= ucwords(strtolower($partIIM1[0]));
		$mineral = $partIIM1[0];
		$mineralMain = $mineral;
		$ironSubMin = '';
		if (strtolower($partIIM1[0]) == strtolower('Iron Ore')) {
			if ($is_hematite) {
				$title .= ' (HEMATITE)';
				$ironSubMin = "/hematite";
				$mineralMain .= "/HEMATITE";
			} elseif ($is_magnetite) {
				$title .= ' (MAGNETITE)';
				$ironSubMin = "/magnetite";
				$mineralMain .= "/MAGNETITE";
			}
		}

		// set active sidebar menu expanded by default
		if ($mineralMain == $mineralParam && !in_array($curAction, array('geologyReservesSubgrade', 'geologyPartSix'))) {
			$partClassII = "u_progress_bar_active";
		} else {
			$partClassII = "u_progress_bar";
		}
		?>
		
		<?php $linkPart++; ?>
		
		<li class="nav-item">
			<?php echo $this->Html->link('<span class="u_progress_bar_menu">'.$title.'</span>', $_SESSION['sec_link']['part_'.$linkPart][0], array('class'=>'nav-link show active '.$partClassII.' pb_menu_sec_6', 'id'=>'tab-0', 'escape'=>false, 'title'=>$title)); ?>
		</li>

		<!--Only for Magnetite if iron ore is the primary mineral-->
		<?php
		$mineral = $partIIM1[0];
		$mineralMain = $mineral;
		$title = "Part VI For ";
		$title .= ucwords(strtolower($partIIM1[0]));
		$title .= ' (MAGNETITE)';
		$ironSubMin = "/magnetite";
		$mineralMain .= "/MAGNETITE";

		// set active sidebar menu expanded by default
		if ($mineralMain == $mineralParam) {
			$partClassIII = "u_progress_bar_active";
		} else {
			$partClassIII = "u_progress_bar";
		}
		?>
		<?php if ($is_hematite && $is_magnetite && strtolower($partIIM1[0]) == strtolower('Iron Ore')) { ?>
			
			<?php $linkPart++; ?>
			
			<li class="nav-item">
				<?php echo $this->Html->link('<span class="u_progress_bar_menu">'.$title.'</span>', $_SESSION['sec_link']['part_'.$linkPart][0], array('class'=>'nav-link show active '.$partClassIII.' pb_menu_sec_7', 'id'=>'tab-0', 'escape'=>false, 'title'=>$title)); ?>
			</li>

		<?php } ?>


		<!--For associated minerals-->
		<?php

		$mCount = '8';
		foreach ($partIIMOther as $partIIM) {

			$title = "Part VI For ";
			$title .= ucwords(strtolower($partIIM[0]));
			$mineral = $partIIM[0];
			$mineralMain = $mineral;
			$ironSubMin = '';
			$sub_min = '';
			if (strtolower($partIIM[0]) == strtolower('Iron Ore')) {
				if ($is_hematite) {
					$title .= ' (HEMATITE)';
					$ironSubMin = "/hematite";
					$mineralMain .= "/HEMATITE";
					$sub_min = "hematite";
				} elseif ($is_magnetite) {
					$title .= ' (MAGNETITE)';
					$ironSubMin = "/magnetite";
					$mineralMain .= "/MAGNETITE";
					$sub_min = "magnetite";
				}
			}

			// set active sidebar menu expanded by default
			if ($mineralMain == $mineralParam && !in_array($curAction, array('geologyReservesSubgrade', 'geologyPartSix'))) {
				$partClassIV = "u_progress_bar_active";
			} else {
				$partClassIV = "u_progress_bar";
			}
		?>
			
			<?php $linkPart++; ?>
			
			<li class="nav-item">
				<?php echo $this->Html->link('<span class="u_progress_bar_menu">'.$title.'</span>', $_SESSION['sec_link']['part_'.$linkPart][0], array('class'=>'nav-link show active '.$partClassIV.' pb_menu_sec_'.$mCount, 'id'=>'tab-0', 'escape'=>false, 'title'=>$title)); ?>
			</li>

		<?php $mCount++;
		} ?>

		<?php
		foreach ($partIIMOther as $partIIM) { ?>

			<!--Only for Magnetite if iron ore is the associative mineral-->
			<?php if ($is_hematite && $is_magnetite && strtolower($partIIM[0]) == strtolower('Iron Ore')) { ?>
				<?php
				// set active sidebar menu expanded by default
				$title = "Part VI For ";
				$title .= ucwords(strtolower($partIIM[0]));
				$mineral = $partIIM[0];
				$title .= ' (MAGNETITE)';
				$ironSubMin = '/magnetite';
				$mineralMain = $mineral . '/MAGNETITE';;

				if ($mineralMain == $mineralParam) {
					$partClassV = "u_progress_bar_active";
				} else {
					$partClassV = "u_progress_bar";
				}
				?>
				
				<?php $linkPart++; ?>
				
				<li class="nav-item">
					<?php echo $this->Html->link('<span class="u_progress_bar_menu">'.$title.'</span>', $_SESSION['sec_link']['part_'.$linkPart][0], array('class'=>'nav-link show active '.$partClassV.' pb_menu_sec_'.$mCount, 'id'=>'tab-0', 'escape'=>false, 'title'=>$title)); ?>
				</li>

			<?php $mCount++;
			} ?>

		<?php } ?>


		<!-- PART VII -->
		<?php
		$mineral = $partIIM1[0];
		$mineralMain = $mineral;
		$ironSubMin = '';

		// set active sidebar menu expanded by default
		if ($curAction == 'productionCost') {
			$partClassVII = "u_progress_bar_active";
		} else {
			$partClassVII = "u_progress_bar";
		}
		?>
		
		<?php $linkPart++; ?>
		
		<li class="nav-item">
			<?php echo $this->Html->link('<span class="u_progress_bar_menu">PART VII</span>', $_SESSION['sec_link']['part_'.$linkPart][0], array('class'=>'nav-link show active '.$partClassVII.' pb_menu_sec_'.$mCount, 'id'=>'tab-0', 'escape'=>false, 'title'=>'PART VII')); ?>
		</li>

	<?php } ?>

</ul>
