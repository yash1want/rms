
<?php

	$userType = $this->getRequest()->getSession()->read('loginusertype');
	if($userType == 'mmsuser'){
		$homeLink = "/mms/home";
	} else if($userType == 'authuser'){
		$homeLink = "/auth/home";
	} else if($userType == 'enduser'){
		$homeLink = "/auth/home";
	} else {
		$homeLink = "/mms/home";
	}

?>

<div class="scrollbar-sidebar ovrfl_x_a">
	<div class="app-sidebar__inner">
		<ul class="vertical-nav-menu">
			<li class="app-sidebar__heading">
				<?php echo $this->Html->link('<i class="metismenu-icon pe-7s-home"></i>DASHBOARD', $homeLink, array('class'=>'u-li-menu spinner_btn_nxt','escape'=>false)); ?>
			</li>

			<?php 
			$sec_link = array(); // form link array
			$main_sec = array(); // main section array same format as 'approved_sections'
			$linkPart = 1;
			$curController = $this->getRequest()->getParam('controller');
			$curControllerLower = strtolower($curController);
			$curAction = $this->getRequest()->getParam('action');
			$mineralParam = $this->getRequest()->getParam('pass');
			$returnType = $this->getRequest()->getSession()->read('returnType');
			if(null==$mineralParam){
				$mineralParam = "";
			} else {
				$mineralPar = $mineralParam[0];
				$mineralPar .= (isset($mineralParam[1])) ? "/".$mineralParam[1] : "";
				$mineralParam = $mineralPar;
			}

			$mineralParam = strtoupper($mineralParam);

			if(strtolower($curController) == 'mms' && $returnType == 'MONTHLY' && $curAction!= 'selectReturn') {
			?>
				<li class="app-sidebar__heading">FORM - F
				<?php 
					$formNo = $this->getRequest()->getSession()->read('mc_form_type');
					if($formNo == 1 || $formNo == 2 || $formNo == 3 || $formNo == 4 || $formNo == 8){
						echo '1';
					}elseif($formNo == 5){
						echo '2';
					}elseif($formNo == 7){
						echo '3';
					}	
				?> </li>
				<!-- PART I -->
				<?php 

				// set active sidebar menu expanded by default
				$partId = $this->getRequest()->getSession()->read('partId');
				$formId = $this->getRequest()->getSession()->read('formId');

				if(in_array($curAction, array('mine','nameAddress','rent','workingDetail','dailyAverage'))) {
					$partIdI = ['mm-active', 'true', 'mm-show'];
				} else {
					$partIdI = ['', 'false', ''];
				}
				?>
				<li class="app-sidebar__heading <?php echo $partIdI[0]; ?>">
					<a href="#" class="u-li-menu menu_sec_1" aria-expanded="<?php echo $partIdI[1]; ?>">
						<i class="metismenu-icon pe-7s-note2"></i>
						PART I
						<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
					</a>
					<ul class="mm-collapse <?php echo $partIdI[2]; ?>">
						<li>
							<?php if($curAction == 'mine') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Details of the Mine', '/mms/mine', array('class'=>'u_menu_'.$_SESSION["secStatus"]["mine"].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/mine"; ?>
							<?php $main_sec['partI'][1] = ""; ?>
						</li>
						<li>
							<?php if($curAction == 'nameAddress') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Name and Address', '/mms/name_address', array('class'=>'u_menu_'.$_SESSION["secStatus"]["name_address"].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/name_address"; ?>
							<?php $main_sec['partI'][2] = ""; ?>
						</li>
						<li>
							<?php if($curAction == 'rent') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Details of Rent/Royalty', '/mms/rent', array('class'=>'u_menu_'.$_SESSION["secStatus"]["rent"].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/rent"; ?>
							<?php $main_sec['partI'][3] = ""; ?>
						</li>
						<li>
							<?php if($curAction == 'workingDetail') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Details on working', '/mms/working_detail', array('class'=>'u_menu_'.$_SESSION["secStatus"]["working_detail"].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/working_detail"; ?>
							<?php $main_sec['partI'][4] = ""; ?>
						</li>
						<li>
							<?php if($curAction == 'dailyAverage') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Average Daily Employment', '/mms/daily_average', array('class'=>'u_menu_'.$_SESSION["secStatus"]["daily_average"].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/daily_average"; ?>
							<?php $main_sec['partI'][5] = ""; ?>
						</li>
					</ul>	
				</li>

				<!--PART II FOR PRIMARY MINERAL-->
				<?php 

				$title = "Part II For ";
				$title.= ucwords(strtolower($partIIM1[0]));
				$mineral = $partIIM1[0];
				$min_sp_sm = strtolower(str_replace(' ','_',$mineral));
				$sub_min = '';
				$mineralMain = $mineral;
				$ironSubMin = '';
				if(strtolower($partIIM1[0]) == strtolower('Iron Ore')) {
					if($is_hematite) {
						$title.= ' (HEMATITE)';
						// $mineral.= ' (HEMATITE)';
						$ironSubMin = "/hematite";
						$mineralMain .= "/HEMATITE";
						$sub_min = 'hematite';
					} elseif($is_magnetite) {
						$title.= ' (MAGNETITE)';
						// $mineral.= ' (MAGNETITE)';
						$ironSubMin = "/magnetite";
						$mineralMain .= "/MAGNETITE";
						$sub_min = 'magnetite';
					}
				}

				// set active sidebar menu expanded by default
				if($mineralMain == $mineralParam) {
					$partIdII = ['mm-active', 'true', 'mm-show'];
				} else {
					$partIdII = ['', 'false', ''];
				}
				?>
				<li class="app-sidebar__heading <?php echo $partIdII[0]; ?>">
					<a href="#" class="u-li-menu menu_sec_2" aria-expanded="<?php echo $partIdII[1]; ?>">
						<i class="metismenu-icon pe-7s-plugin"></i>
						<?php 
						echo $title;
						?>
						<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
					</a>

					<?php $linkPart++; ?>

					<!--=======GETTING FORM TYPE BASED ON THE MINERAL NAME=====-->
					<?php if($partIIM1['formNo'] == 5) { ?>
						<ul class="mm-collapse <?php echo $partIdII[2]; ?>">
							<li>
								<?php if($curAction == 'romStocksOre' && $mineral == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F11') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Production / Stocks (ROM)', '/mms/rom_stocks_ore/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["rom_stocks_ore"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/rom_stocks_ore/".$mineral.$ironSubMin; ?>
								<?php $main_sec[$min_sp_sm][1] = ""; ?>
							</li>
							<li>
								<?php if($curAction == 'exMine' && $mineral == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F12') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Ex-mine price', '/mms/ex_mine/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["ex_mine"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/ex_mine/".$mineral.$ironSubMin; ?>
								<?php $main_sec[$min_sp_sm][2] = ""; ?>
							</li>
							<li>
								<?php if($curAction == 'conReco' && $mineral == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F13') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Recoveries at Concentrator', '/mms/con_reco/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["con_reco"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/con_reco/".$mineral.$ironSubMin; ?>
								<?php $main_sec[$min_sp_sm][3] = ""; ?>
							</li>
							<li>
								<?php if($curAction == 'smeltReco' && $mineral == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F14') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Recovery at the Smelter', '/mms/smelt_reco/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["smelt_reco"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/smelt_reco/".$mineral.$ironSubMin; ?>
								<?php $main_sec[$min_sp_sm][4] = ""; ?>
							</li>
							<li>
								<?php if($curAction == 'salesMetalProduct' && $mineral == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F15') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Sales(Metals/By product)', '/mms/sales_metal_product/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["sales_metal_product"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/sales_metal_product/".$mineral.$ironSubMin; ?>
								<?php $main_sec[$min_sp_sm][5] = ""; ?>
							</li>
							<li>
								<?php if($curAction == 'deductDetail' && $mineral == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F16') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Details of Deductions', '/mms/deduct_detail/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["deduct_detail"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/deduct_detail/".$mineral.$ironSubMin; ?>
								<?php $main_sec[$min_sp_sm][6] = ""; ?>
							</li>
							<li>
								<?php if($curAction == 'saleDespatch' && $mineral == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F17') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Sales/Dispatches', '/mms/sale_despatch/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["sale_despatch"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/sale_despatch/".$mineral.$ironSubMin; ?>
								<?php $main_sec[$min_sp_sm][7] = ""; ?>
							</li>
						</ul>
					<?php } elseif($partIIM1['formNo'] == 7) { ?>
						<ul class="mm-collapse">
							<li>
								<?php if($curAction == 'romStocksThree' && $mineral == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F21') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Production / Stocks (ROM)', '/mms/rom_stocks_three/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["rom_stocks_three"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/rom_stocks_three/".$mineral.$ironSubMin; ?>
								<?php $main_sec[$min_sp_sm][1] = ""; ?>
							</li>
							<li>
								<?php if($curAction == 'prodStockDis' && $mineral == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F22') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Production, Despatches and Stocks', '/mms/prod_stock_dis/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["prod_stock_dis"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/prod_stock_dis/".$mineral.$ironSubMin; ?>
								<?php $main_sec[$min_sp_sm][2] = ""; ?>
							</li>
							<li>
								<?php if($curAction == 'deductDetail' && $mineral == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F23') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Details of Deductions', '/mms/deduct_detail/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["deduct_detail"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/deduct_detail/".$mineral.$ironSubMin; ?>
								<?php $main_sec[$min_sp_sm][3] = ""; ?>
							</li>
							<li>
								<?php if($curAction == 'saleDespatch' && $mineral == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F24') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Sales/Dispatches', '/mms/sale_despatch/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["sale_despatch"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/sale_despatch/".$mineral.$ironSubMin; ?>
								<?php $main_sec[$min_sp_sm][4] = ""; ?>
							</li>
						</ul>
					<?php } else { ?>
						<ul class="mm-collapse">
							<?php if (strtolower($partIIM1[0]) == strtolower('Iron Ore')) { ?>
								<li>
									<?php if($curAction == 'oreType' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F31') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //echo $this->Html->link('Type of ore', '/monthly/ore_type/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["ore_type"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/ore_type/".$mineral.$ironSubMin; ?>
									<?php echo $this->Html->link('Type of ore', '/mms/ore_type/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["ore_type"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/ore_type/".$mineral.$ironSubMin; ?>
									<?php ($sub_min != '') ? $main_sec[$min_sp_sm][$sub_min][10] = "" : $main_sec[$min_sp_sm][10] = ""; ?>
								</li>
							<?php } ?>
							<li>
								<?php if($curAction == 'romStocks' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F32') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Production / Stocks (ROM)', '/mms/rom_stocks/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["rom_stocks"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/rom_stocks/".$mineral.$ironSubMin; ?>
								<?php ($sub_min != '') ? $main_sec[$min_sp_sm][$sub_min][1] = "" : $main_sec[$min_sp_sm][1] = ""; ?>
							</li>
							<li>
								<?php if($curAction == 'gradewiseProd' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F33') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Grade-wise Production', '/mms/gradewise_prod/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["gradewise_prod"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/gradewise_prod/".$mineral.$ironSubMin; ?>
								<?php ($sub_min != '') ? $main_sec[$min_sp_sm][$sub_min][2] = "" : $main_sec[$min_sp_sm][2] = ""; ?>
							</li>
							<?php if ($partIIM1['formNo'] == 8) { ?>
								<li>
									<?php if($curAction == 'pulverisation' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F34') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Pulverisation', '/mms/pulverisation/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["pulverisation"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/pulverisation/".$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][5] = ""; ?>
								</li>
							<?php } ?>
							<li>
								<?php if($curAction == 'deductDetail' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F35') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Details of Deductions', '/mms/deduct_detail/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["deduct_detail"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/deduct_detail/".$mineral.$ironSubMin; ?>
								<?php ($sub_min != '') ? $main_sec[$min_sp_sm][$sub_min][3] = "" : $main_sec[$min_sp_sm][3] = ""; ?>
							</li>
							<li>
								<?php if($curAction == 'saleDespatch' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F36') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Sales/Dispatches', '/mms/sale_despatch/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["sale_despatch"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/sale_despatch/".$mineral.$ironSubMin; ?>
								<?php ($sub_min != '') ? $main_sec[$min_sp_sm][$sub_min][4] = "" : $main_sec[$min_sp_sm][4] = ""; ?>
							</li>
						</ul>
					<?php } ?>
				</li>

				<!--Only for Magnetite if iron ore is the primary mineral-->
				<?php 
				
				$mineral = $partIIM1[0];
				$min_sp_sm = strtolower(str_replace(' ','_',$mineral));
				$sub_min = 'magnetite';
				$mineralMain = $mineral;
				$title = "Part II For ";
				$title .= ucwords(strtolower($partIIM1[0]));
				$title .= ' (MAGNETITE)';
				$ironSubMin = "/magnetite";
				$mineralMain .= "/MAGNETITE";

				// set active sidebar menu expanded by default
				if($mineralMain == $mineralParam) {
					$partIdIII = ['mm-active', 'true', 'mm-show'];
				} else {
					$partIdIII = ['', 'false', ''];
				}
				?>
				<?php if ($is_hematite && $is_magnetite && strtolower($partIIM1[0]) == strtolower('Iron Ore')) { ?>
					<li class="app-sidebar__heading <?php echo $partIdIII[0]; ?>">
						<a href="#" class="u-li-menu menu_sec_3" aria-expanded="<?php echo $partIdIII[1]; ?>">
							<i class="metismenu-icon pe-7s-plugin"></i>
							<?php echo $title; ?>
							<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
						</a>

						<?php $linkPart++; ?>

						<ul class="mm-collapse <?php echo $partIdIII[2]; ?>">
							<li>
								<?php if($curAction == 'romStocks' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F41') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Production / Stocks (ROM)', '/mms/rom_stocks/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["rom_stocks"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/rom_stocks/".$mineral.$ironSubMin; ?>
								<?php $main_sec[$min_sp_sm][$sub_min][1] = "" ; ?>
							</li>
							<li>
								<?php if($curAction == 'gradewiseProd' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F42') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Grade-wise Production', '/mms/gradewise_prod/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["gradewise_prod"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/gradewise_prod/".$mineral.$ironSubMin; ?>
								<?php $main_sec[$min_sp_sm][$sub_min][2] = "" ; ?>
							</li>
						</ul>
					</li>
				<?php } ?>

				<!--For associated minerals-->
				<?php 

				$mCount = '4';
				foreach ($partIIMOther as $partIIM) {

					// set active sidebar menu expanded by default
					// if($partId == 'P'.$mCount) {
					// 	$partIdIV = ['mm-active', 'true', 'mm-show'];
					// } else {
					// 	$partIdIV = ['', 'false', ''];
					// }

					$title = "Part II For ";
					$title.= ucwords(strtolower($partIIM[0]));
					$mineral = $partIIM[0];
					$min_sp_sm = strtolower(str_replace(' ','_',$mineral));
					$sub_min = '';
					$mineralMain = $mineral;
					$ironSubMin = '';
					if(strtolower($partIIM[0]) == strtolower('Iron Ore')) {
						if($is_hematite) {
							$title.= ' (HEMATITE)';
							// $mineral.= ' (HEMATITE)';
							$ironSubMin = "/hematite";
							$mineralMain .= "/HEMATITE";
							$sub_min = 'hematite';
						} elseif($is_magnetite) {
							$title.= ' (MAGNETITE)';
							// $mineral.= ' (MAGNETITE)';
							$ironSubMin = "/magnetite";
							$mineralMain .= "/MAGNETITE";
							$sub_min = 'magnetite';
						}
					}

					// set active sidebar menu expanded by default
					if($mineralMain == $mineralParam) {
						$partIdIV = ['mm-active', 'true', 'mm-show'];
					} else {
						$partIdIV = ['', 'false', ''];
					}
					?>

					<li class="app-sidebar__heading <?php echo $partIdIV[0]; ?>">
						<a href="#" class="u-li-menu menu_sec_<?php echo $mCount; ?>" aria-expanded="<?php echo $partIdIV[1]; ?>">
							<i class="metismenu-icon pe-7s-plugin"></i>
							<?php echo $title; ?>
							<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
						</a>

						<?php $linkPart++; ?>

						<!--For associated minerals-->
						<?php if($partIIM['formNo'] == 5) { ?>
							<ul class="mm-collapse <?php echo $partIdIV[2]; ?>">
								<li>
									<?php if($curAction == 'romStocksOre' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F51') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Production / Stocks (ROM)', '/mms/rom_stocks_ore/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["rom_stocks_ore"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/rom_stocks_ore/'.$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][1] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'exMine' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F52') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Ex-mine price', '/mms/ex_mine/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["ex_mine"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/ex_mine/'.$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][2] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'conReco' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F53') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Recoveries at Concentrator', '/mms/con_reco/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["con_reco"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/con_reco/'.$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][3] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'smeltReco' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F54') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Recovery at the Smelter', '/mms/smelt_reco/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["smelt_reco"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/smelt_reco/'.$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][4] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'salesMetalProduct' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F55') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Sales(Metals/By product)', '/mms/smelt_reco/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["smelt_reco"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/smelt_reco/'.$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][5] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'deductDetail' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F56') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Details of Deductions', '/mms/deduct_detail/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["deduct_detail"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/deduct_detail/'.$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][6] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'saleDespatch' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F57') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Sales/Dispatches', '/mms/sale_despatch/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["sale_despatch"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/sale_despatch/'.$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][7] = ""; ?>
								</li>
							</ul>
						<?php } elseif($partIIM['formNo'] == 7) { ?>
							<ul class="mm-collapse <?php echo $partIdIV[2]; ?>">
								<li>
									<?php if($curAction == 'romStocksThree' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F61') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Production / Stocks (ROM)', '/mms/rom_stocks_three/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["rom_stocks_three"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/rom_stocks_three/".$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][1] = ""; ?>
								<li>
									<?php if($curAction == 'prodStockDis' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F62') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Production, Despatches and Stocks', '/mms/prod_stock_dis/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["prod_stock_dis"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/prod_stock_dis/".$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][2] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'deductDetail' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F63') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Details of Deductions', '/mms/deduct_detail/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["deduct_detail"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/deduct_detail/".$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][3] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'saleDespatch' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F64') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Sales/Dispatches', '/mms/sale_despatch/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["sale_despatch"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/sale_despatch/".$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][4] = ""; ?>
								</li>
							</ul>
						<?php } else { ?>
							<ul class="mm-collapse <?php echo $partIdIV[2]; ?>">
								<?php if (strtolower($partIIM[0]) == strtolower('Iron Ore')) { ?>
									<li>
										<?php if($curAction == 'oreType' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
										<?php //if($formId == 'F71') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
										<?php echo $this->Html->link('Type of ore', '/mms/ore_type/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["ore_type"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/ore_type/'.$mineral.$ironSubMin; ?>
										<?php ($sub_min != '') ? $main_sec[$min_sp_sm][$sub_min][10] = "" : $main_sec[$min_sp_sm][10] = ""; ?>
									</li>
								<?php } ?>
								<li>
									<?php if($curAction == 'romStocks' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F72') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Production / Stocks (ROM)', '/mms/rom_stocks/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["rom_stocks"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/rom_stocks/'.$mineral.$ironSubMin; ?>
									<?php ($sub_min != '') ? $main_sec[$min_sp_sm][$sub_min][1] = "" : $main_sec[$min_sp_sm][1] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'gradewiseProd' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F73') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Grade-wise Production', '/mms/gradewise_prod/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["gradewise_prod"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/gradewise_prod/'.$mineral.$ironSubMin; ?>
									<?php ($sub_min != '') ? $main_sec[$min_sp_sm][$sub_min][2] = "" : $main_sec[$min_sp_sm][2] = ""; ?>
								</li>
								<?php if ($partIIM['formNo'] == 8) { ?>
									<li>
										<?php if($curAction == 'pulverisation' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
										<?php //if($formId == 'F74') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
										<?php echo $this->Html->link('Pulverisation', '/mms/pulverisation/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["pulverisation"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/pulverisation/'.$mineral.$ironSubMin; ?>
										<?php $main_sec[$min_sp_sm][5] = ""; ?>
									</li>
								<?php } ?>
								<li>
									<?php if($curAction == 'deductDetail' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F75') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Details of Deductions', '/mms/deduct_detail/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["deduct_detail"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/deduct_detail/'.$mineral.$ironSubMin; ?>
									<?php ($sub_min != '') ? $main_sec[$min_sp_sm][$sub_min][3] = "" : $main_sec[$min_sp_sm][3] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'saleDespatch' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F76') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Sales/Dispatches', '/mms/sale_despatch/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["sale_despatch"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/sale_despatch/'.$mineral.$ironSubMin; ?>
									<?php ($sub_min != '') ? $main_sec[$min_sp_sm][$sub_min][4] = "" : $main_sec[$min_sp_sm][4] = ""; ?>
								</li>
							</ul>
						<?php } ?>
					</li>

				<?php $mCount++; } ?>
				<?php 
				foreach ($partIIMOther as $partIIM) { ?>

					<!--Only for Magnetite if iron ore is the associative mineral-->
					<?php if ($is_hematite && $is_magnetite && strtolower($partIIM[0]) == strtolower('Iron Ore')) { ?>
						<?php 
						
						$title = "Part II For ";
						$title.= ucwords(strtolower($partIIM[0]));
						$mineral = $partIIM[0];
						$min_sp_sm = strtolower(str_replace(' ','_',$mineral));
						$sub_min = 'magnetite';
						$title.= ' (MAGNETITE)';
						// $mineral.= ' (MAGNETITE)';
						$mineralMain = $mineral.'/MAGNETITE';
						$ironSubMin = '/magnetite';

						// set active sidebar menu expanded by default
						if($mineralMain == $mineralParam) {
							$partIdV = ['mm-active', 'true', 'mm-show'];
						} else {
							$partIdV = ['', 'false', ''];
						}
						?>
						<li class="app-sidebar__heading <?php echo $partIdV[0]; ?>">
							<a href="#" class="u-li-menu menu_sec_<?php echo $mCount; ?>" aria-expanded="<?php echo $partIdV[1]; ?>">
								<i class="metismenu-icon pe-7s-plugin"></i>
								<?php echo $title; ?>
								<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
							</a>

							<?php $linkPart++; ?>

							<ul class="mm-collapse <?php echo $partIdV[2]; ?>">
								<li>
									<?php if($curAction == 'romStocks' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F81') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Production / Stocks (ROM)', '/mms/rom_stocks/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["rom_stocks"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/rom_stocks/'.$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][$sub_min][1] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'gradewiseProd' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F82') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Grade-wise Production', '/mms/gradewise_prod/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["gradewise_prod"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/gradewise_prod/'.$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][$sub_min][2] = ""; ?>
								</li>
							</ul>
						</li>
					<?php $mCount++; } ?>

				<?php } ?>

				<!-- Add new menu option for to view applicant profile details, Done by Pravin Bhakare 22-12-2020-->
				<!-- <?php 
				// set active sidebar menu expanded by default
				/* if($partId == 'P'.$mCount) {
					$partIdVI = ['mm-active', 'true', 'mm-show'];
				} else {
					$partIdVI = ['', 'false', ''];
				} */
				?>
				<li class="app-sidebar__heading <?php //echo $partIdVI[0]; ?>">
					<a href="#" class="u-li-menu" aria-expanded="<?php //echo $partIdVI[1]; ?>">
						<i class="metismenu-icon pe-7s-user"></i>
						Profile
						<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
					</a>
					<ul class="mm-collapse <?php //echo $partIdVI[2]; ?>">
						<li>
							<?php //if($formId == 'F91') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php //echo $this->Html->link('My Profile', '/mms/activeForm/P'.$mCount.'/F91', array('class'=>'u_menu_error'.$activeStat)); $fLink[] = '/mms/activeForm/P'.$mCount.'/F91'; ?>
						</li>
					</ul>
				</li> -->

				
			<?php 
			} else if(strtolower($curController) == 'mmsenduser' && $curAction!= 'selectReturn') {
			?>
				<?php if ($formType == 'N') { ?>
					<li class="app-sidebar__heading">FORM - L</li>
					<!-- PART I -->
					<?php 

					// set active sidebar menu expanded by default
					$partId = $this->getRequest()->getSession()->read('partId');
					$formId = $this->getRequest()->getSession()->read('formId');

					if(in_array($curAction, array('instruction','generalParticular'))) {
						$partIdI = ['mm-active', 'true', 'mm-show'];
					} else {
						$partIdI = ['', 'false', ''];
					}
					?>
					<li class="app-sidebar__heading <?php echo $partIdI[0]; ?>">
						<a href="#" class="u-li-menu menu_sec_1" aria-expanded="<?php echo $partIdI[1]; ?>">
							<i class="metismenu-icon pe-7s-note2"></i>
							PART I
							<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
						</a>
						<ul class="mm-collapse <?php echo $partIdI[2]; ?>">
							<li>
								<?php if($curAction == 'generalParticular') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($curAction == 'mine') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('General Particulars', '/mmsenduser/generalParticular', array('class'=>'u_menu_'.$_SESSION["secStatus"]["gen_particular"].$activeStat)); $sec_link['part_1'][] = '/mmsenduser/generalParticular'; ?>
                                <?php $main_sec['partI'][1] = "Approved"; ?>
							</li>
						</ul>	
					</li>

					<!-- PART II -->
					<?php 

					// set active sidebar menu expanded by default
					if(in_array($curAction, array('tradingActivity','exportOfOre','mineralBaseActivity','storageActivity'))) {
						$partIdII = ['mm-active', 'true', 'mm-show'];
					} else {
						$partIdII = ['', 'false', ''];
					}
					?>
					<li class="app-sidebar__heading <?php echo $partIdII[0]; ?>">
						<a href="#" class="u-li-menu menu_sec_2" aria-expanded="<?php echo $partIdII[1]; ?>">
							<i class="metismenu-icon pe-7s-note2"></i>
							PART II
							<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
						</a>
						<ul class="mm-collapse <?php echo $partIdII[2]; ?>">

							<?php if($sectionType == 'T' || $sectionType == 'W'){ ?>
							<li>
								<?php if($curAction == 'tradingActivity') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($curAction == 'mine') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Trading Activity', '/mmsenduser/tradingActivity', array('class'=>'u_menu_'.$_SESSION["secStatus"]["trading_ac"].$activeStat)); $sec_link['part_2'][] = '/mmsenduser/tradingActivity'; ?>
                                <?php $main_sec['partII'][1] = ""; ?>
							</li>
							<?php } if($sectionType == 'E'){ ?>
							<li>
								<?php if($curAction == 'exportOfOre') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($curAction == 'mine') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Export Activity', '/mmsenduser/exportOfOre', array('class'=>'u_menu_'.$_SESSION["secStatus"]["export_ac"].$activeStat)); $sec_link['part_2'][] = '/mmsenduser/exportOfOre'; ?>
                                <?php $main_sec['partII'][2] = ""; ?>
							</li>
							<?php } if($sectionType == 'C'){ ?>
							<li>
								<?php if($curAction == 'mineralBaseActivity') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($curAction == 'mine') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('End-use Mineral Based Activity', '/mmsenduser/mineralBaseActivity', array('class'=>'u_menu_'.$_SESSION["secStatus"]["min_bas_ac"].$activeStat)); $sec_link['part_2'][] = '/mmsenduser/mineralBaseActivity'; ?>
                                <?php $main_sec['partII'][3] = ""; ?>
							</li>
							<?php } if($sectionType == 'S'){ ?>
							<li>
								<?php if($curAction == 'storageActivity') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($curAction == 'mine') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Storage Activity', '/mmsenduser/storageActivity', array('class'=>'u_menu_'.$_SESSION["secStatus"]["storage_ac"].$activeStat)); $sec_link['part_2'][] = '/mmsenduser/storageActivity'; ?>
                                <?php $main_sec['partII'][4] = ""; ?>
							</li>
							<?php } ?>
						</ul>	
					</li>
					
				<?php } else { ?>
				
					<li class="app-sidebar__heading">FORM - M</li>
					<!-- PART I -->
					<?php 

					// set active sidebar menu expanded by default
					$partId = $this->getRequest()->getSession()->read('partId');
					$formId = $this->getRequest()->getSession()->read('formId');

					if(in_array($curAction, array('instruction','generalParticular'))) {
						$partIdI = ['mm-active', 'true', 'mm-show'];
					} else {
						$partIdI = ['', 'false', ''];
					}
					?>
					<li class="app-sidebar__heading <?php echo $partIdI[0]; ?>">
						<a href="#" class="u-li-menu menu_sec_1" aria-expanded="<?php echo $partIdI[1]; ?>">
							<i class="metismenu-icon pe-7s-note2"></i>
							PART I
							<i class="metismenu-state-icon font_15 fa fa-chevron-down caret-left"></i>
						</a>
						<ul class="mm-collapse <?php echo $partIdI[2]; ?>">
							<li>
								<?php if($curAction == 'generalParticular') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($curAction == 'mine') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('General Particulars', '/mmsenduser/generalParticular', array('class'=>'u_menu_'.$_SESSION["secStatus"]["gen_particular"].$activeStat)); $sec_link['part_1'][] = '/mmsenduser/generalParticular'; ?>
                                <?php $main_sec['partI'][1] = "Approved"; ?>
							</li>
						</ul>	
					</li>

					<!-- PART II -->
					<?php 

					// set active sidebar menu expanded by default
					if(in_array($curAction, array('tradingActivity','exportOfOre','mineralBaseActivity','storageActivity'))) {
						$partIdII = ['mm-active', 'true', 'mm-show'];
					} else {
						$partIdII = ['', 'false', ''];
					}
					?>
					<li class="app-sidebar__heading <?php echo $partIdII[0]; ?>">
						<a href="#" class="u-li-menu menu_sec_2" aria-expanded="<?php echo $partIdII[1]; ?>">
							<i class="metismenu-icon pe-7s-note2"></i>
							PART II
							<i class="metismenu-state-icon font_15 fa fa-chevron-down caret-left"></i>
						</a>
						<ul class="mm-collapse <?php echo $partIdII[2]; ?>">

							<?php if($sectionType == 'T' || $sectionType == 'W'){ ?>
							<li>
								<?php if($curAction == 'tradingActivity') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($curAction == 'mine') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Trading Activity', '/mmsenduser/tradingActivity', array('class'=>'u_menu_'.$_SESSION["secStatus"]["trading_ac"].$activeStat)); $sec_link['part_2'][] = '/mmsenduser/tradingActivity'; ?>
                                <?php $main_sec['partII'][1] = ""; ?>
							</li>
							<?php } if($sectionType == 'E'){ ?>
							<li>
								<?php if($curAction == 'exportOfOre') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($curAction == 'mine') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Export Activity', '/mmsenduser/exportOfOre', array('class'=>'u_menu_'.$_SESSION["secStatus"]["export_ac"].$activeStat)); $sec_link['part_2'][] = '/mmsenduser/exportOfOre'; ?>
                                <?php $main_sec['partII'][2] = ""; ?>
							</li>
							<?php } if($sectionType == 'C'){ ?>
							<li>
								<?php if($curAction == 'mineralBaseActivity') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($curAction == 'mine') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('End-use Mineral Based Activity', '/mmsenduser/mineralBaseActivity', array('class'=>'u_menu_'.$_SESSION["secStatus"]["min_bas_ac"].$activeStat)); $sec_link['part_2'][] = '/mmsenduser/mineralBaseActivity'; ?>
                                <?php $main_sec['partII'][3] = ""; ?>
							</li>
							<?php } if($sectionType == 'S'){ ?>
							<li>
								<?php if($curAction == 'storageActivity') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($curAction == 'mine') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Storage Activity', '/mmsenduser/storageActivity', array('class'=>'u_menu_'.$_SESSION["secStatus"]["storage_ac"].$activeStat)); $sec_link['part_2'][] = '/mmsenduser/storageActivity'; ?>
                                <?php $main_sec['partII'][4] = ""; ?>
							</li>
							<?php } ?>
						</ul>	
					</li>

					
					<!-- PART III -->
					<?php 

					if($sectionType == 'C'){
						if(in_array($curAction, array('mineralBasedIndustries','productManufactureDetails','ironSteelIndustries','rawMaterialConsumed','sourceOfSupply'))) {
							$partIdIII = ['mm-active', 'true', 'mm-show'];
						} else {
							$partIdIII = ['', 'false', ''];
						}
						?>
						<li class="app-sidebar__heading <?php echo $partIdIII[0]; ?>">
							<a href="#" class="u-li-menu menu_sec_3" aria-expanded="<?php echo $partIdIII[1]; ?>">
								<i class="metismenu-icon pe-7s-note2"></i>
								PART III
								<i class="metismenu-state-icon font_15 fa fa-chevron-down caret-left"></i>
							</a>
							<ul class="mm-collapse <?php echo $partIdIII[2]; ?>">

								<li>
									<?php if($curAction == 'mineralBasedIndustries') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('End-use Mineral Based Ind-I', '/mmsenduser/mineralBasedIndustries', array('class'=>'u_menu_'.$_SESSION["secStatus"]["min_bas_ind"].$activeStat)); $sec_link['part_3'][] = '/mmsenduser/mineralBasedIndustries'; ?>
									<?php $main_sec['partIII'][1] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'productManufactureDetails') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('End-use Mineral Based Ind-II', '/mmsenduser/productManufactureDetails', array('class'=>'u_menu_'.$_SESSION["secStatus"]["prod_man_det"].$activeStat)); $sec_link['part_3'][] = '/mmsenduser/productManufactureDetails'; ?>
									<?php $main_sec['partIII'][2] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'ironSteelIndustries') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Iron and Steel Industry', '/mmsenduser/ironSteelIndustries', array('class'=>'u_menu_'.$_SESSION["secStatus"]["iron_steel"].$activeStat)); $sec_link['part_3'][] = '/mmsenduser/ironSteelIndustries'; ?>
									<?php $main_sec['partIII'][3] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'rawMaterialConsumed') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Raw Materials Consumed In Production', '/mmsenduser/rawMaterialConsumed', array('class'=>'u_menu_'.$_SESSION["secStatus"]["raw_mat_cons"].$activeStat)); $sec_link['part_3'][] = '/mmsenduser/rawMaterialConsumed'; ?>
									<?php $main_sec['partIII'][4] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'sourceOfSupply') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Source of Supply', '/mmsenduser/sourceOfSupply', array('class'=>'u_menu_'.$_SESSION["secStatus"]["sour_supp"].$activeStat)); $sec_link['part_3'][] = '/mmsenduser/sourceOfSupply'; ?>
									<?php $main_sec['partIII'][5] = ""; ?>
								</li>

							</ul>	
						</li>

					<?php } ?>

				<?php } ?>

			<?php 
			} else if(($curControllerLower == 'mms' || $curControllerLower == 'mmsgseries') && $returnType == 'ANNUAL' && $curAction != 'selectReturn') {
			?>
			
				<li class="app-sidebar__heading">FORM - G<?php echo $this->getRequest()->getSession()->read('mc_form_main'); ?> </li>

				<!-- PART I -->
				<?php 

				// set active sidebar menu expanded by default
				if(in_array($curAction, array('mine','nameAddress','particulars','areaUtilisation'))) {
					$partIdI = ['mm-active', 'true', 'mm-show'];
				} else {
					$partIdI = ['', 'false', ''];
				}
				?>
				<li class="app-sidebar__heading <?php echo $partIdI[0]; ?>">
					<a href="#" class="u-li-menu menu_sec_1" aria-expanded="<?php echo $partIdI[1]; ?>">
						<!-- <i class="metismenu-icon pe-7s-note2"></i> -->
						<i class="metismenu-icon fa fa-paste"></i>
						PART I
						<!-- <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i> -->
						<i class="metismenu-state-icon font_15 fa fa-chevron-down caret-left"></i>
					</a>
					<ul class="mm-collapse <?php echo $partIdI[2]; ?>">
						<li>
							<?php if($curAction == 'mine') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Details of the Mine', '/mms/mine', array('class'=>'u_menu_'.$_SESSION["secStatus"]["mine"].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/mine"; ?>
							<?php $main_sec['partI'][1] = ""; ?>
						</li>
						<li>
							<?php if($curAction == 'nameAddress') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Name and Address', '/mms/name_address', array('class'=>'u_menu_'.$_SESSION["secStatus"]["name_address"].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/name_address"; ?>
							<?php $main_sec['partI'][2] = ""; ?>
						</li>
						<li>
							<?php if($curAction == 'particulars') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Particulars of area operated', '/mmsGSeries/particulars', array('class'=>'u_menu_'.$_SESSION["secStatus"]["particulars"].$activeStat)); $sec_link['part_'.$linkPart][] = "/mmsGSeries/particulars"; ?>
							<?php $main_sec['partI'][3] = ""; ?>
						</li>
						<li>
							<?php if($curAction == 'areaUtilisation') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Lease Area Utilisation', '/mmsGSeries/area_utilisation', array('class'=>'u_menu_'.$_SESSION["secStatus"]["area_utilisation"].$activeStat)); $sec_link['part_'.$linkPart][] = "/mmsGSeries/area_utilisation"; ?>
							<?php $main_sec['partI'][4] = ""; ?>
						</li>
					</ul>	
				</li>

				<!-- PART II -->
				<?php 
				$mineral = $partIIM1[0];
				$mineralMain = $mineral;
				$ironSubMin = '';
				if(strtolower($partIIM1[0]) == strtolower('Iron Ore')) {
					if($is_hematite) {
						$ironSubMin = "/hematite";
						$mineralMain .= "/HEMATITE";
					} elseif($is_magnetite) {
						$ironSubMin = "/magnetite";
						$mineralMain .= "/MAGNETITE";
					}
				}

				// set active sidebar menu expanded by default
				if(in_array($curAction, array('employmentWages','employmentWagesPart','capitalStructure'))) {
					$partIdII = ['mm-active', 'true', 'mm-show'];
				} else {
					$partIdII = ['', 'false', ''];
				}
				?>
				<li class="app-sidebar__heading <?php echo $partIdII[0]; ?>">
					<a href="#" class="u-li-menu menu_sec_2" aria-expanded="<?php echo $partIdII[1]; ?>">
						<!-- <i class="metismenu-icon pe-7s-plugin"></i> -->
						<i class="metismenu-icon fa fa-toolbox"></i>
						Part II
						<i class="metismenu-state-icon font_15 fa fa-chevron-down caret-left"></i>
					</a>

					<?php $linkPart++; ?>

					<ul class="mm-collapse <?php echo $partIdII[2]; ?>">
						<li>
							<?php if($curAction == 'employmentWages') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Employment & Wages (I)', '/mmsGSeries/employment_wages', array('class'=>'u_menu_'.$_SESSION["secStatus"]["employment_wages"].$activeStat)); $sec_link['part_'.$linkPart][] = "/mmsGSeries/employment_wages"; ?>
							<?php $main_sec['partII'][1] = ""; ?>
						</li>
						<li>
							<?php if($curAction == 'employmentWagesPart') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Employment & Wages (II)', '/mmsGSeries/employment_wages_part', array('class'=>'u_menu_'.$_SESSION["secStatus"]["employment_wages_part"].$activeStat)); $sec_link['part_'.$linkPart][] = "/mmsGSeries/employment_wages_part"; ?>
							<?php $main_sec['partII'][3] = ""; ?>
						</li>
						<li>
							<?php if($curAction == 'capitalStructure') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Capital Structure', '/mmsGSeries/capital_structure', array('class'=>'u_menu_'.$_SESSION["secStatus"]["capital_structure"].$activeStat)); $sec_link['part_'.$linkPart][] = "/mmsGSeries/capital_structure"; ?>
							<?php $main_sec['partII'][2] = ""; ?>
						</li>
					</ul>
				</li>

				<!-- PART III -->
				<?php 
				$mineral = $partIIM1[0];
				$mineralMain = $mineral;
				$ironSubMin = '';

				// set active sidebar menu expanded by default
				if(in_array($curAction, array('materialConsumptionQuantity','materialConsumptionRoyalty','materialConsumptionTax'))) {
					$partIdIII = ['mm-active', 'true', 'mm-show'];
				} else {
					$partIdIII = ['', 'false', ''];
				}
				?>
				<li class="app-sidebar__heading <?php echo $partIdIII[0]; ?>">
					<a href="#" class="u-li-menu menu_sec_3" aria-expanded="<?php echo $partIdIII[1]; ?>">
						<!-- <i class="metismenu-icon pe-7s-plugin"></i> -->
						<i class="metismenu-icon fa fa-toolbox"></i>
						Part III
						<i class="metismenu-state-icon font_15 fa fa-chevron-down caret-left"></i>
					</a>

					<?php $linkPart++; ?>

					<ul class="mm-collapse <?php echo $partIdIII[2]; ?>">
						<li>
							<?php if($curAction == 'materialConsumptionQuantity') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Quantity & Cost of Material', '/mmsGSeries/material_consumption_quantity', array('class'=>'u_menu_'.$_SESSION["secStatus"]["material_consumption_quantity"].$activeStat)); $sec_link['part_'.$linkPart][] = "/mmsGSeries/material_consumption_quantity"; ?>
							<?php $main_sec['partIII'][1] = ""; ?>
						</li>
						<li>
							<?php if($curAction == 'materialConsumptionRoyalty') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Royalty/Compensation/Depreciation', '/mmsGSeries/material_consumption_royalty', array('class'=>'u_menu_'.$_SESSION["secStatus"]["material_consumption_royalty"].$activeStat)); $sec_link['part_'.$linkPart][] = "/mmsGSeries/material_consumption_royalty"; ?>
							<?php $main_sec['partIII'][2] = ""; ?>
						</li>
						<li>
							<?php if($curAction == 'materialConsumptionTax') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Taxes/Other Expenses', '/mmsGSeries/material_consumption_tax', array('class'=>'u_menu_'.$_SESSION["secStatus"]["material_consumption_tax"].$activeStat)); $sec_link['part_'.$linkPart][] = "/mmsGSeries/material_consumption_tax"; ?>
							<?php $main_sec['partIII'][3] = ""; ?>
						</li>
					</ul>
				</li>

				<!-- PART IV -->
				<?php 
				$mineral = $partIIM1[0];
				$mineralMain = $mineral;
				$ironSubMin = '';

				// set active sidebar menu expanded by default
				if($curAction == 'explosiveConsumption') {
					$partIdIV = ['mm-active', 'true', 'mm-show'];
				} else {
					$partIdIV = ['', 'false', ''];
				}
				?>
				<li class="app-sidebar__heading <?php echo $partIdIV[0]; ?>">
					<a href="#" class="u-li-menu menu_sec_4" aria-expanded="<?php echo $partIdIV[1]; ?>">
						<!-- <i class="metismenu-icon pe-7s-plugin"></i> -->
						<i class="metismenu-icon fa fa-toolbox"></i>
						Part IV
						<i class="metismenu-state-icon font_15 fa fa-chevron-down caret-left"></i>
					</a>

					<?php $linkPart++; ?>

					<ul class="mm-collapse <?php echo $partIdIV[2]; ?>">
						<li>
							<?php if($curAction == 'explosiveConsumption') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Consumption of Explosives', '/mmsGSeries/explosive_consumption', array('class'=>'u_menu_'.$_SESSION["secStatus"]["explosive_consumption"].$activeStat)); $sec_link['part_'.$linkPart][] = "/mmsGSeries/explosive_consumption"; ?>
							<?php $main_sec['partIV'][1] = ""; ?>
						</li>
					</ul>
				</li>


				<!-- PART V -->
				<?php 
				$mineral = $partIIM1[0];
				$mineralMain = $mineral;
				$ironSubMin = '';

				// set active sidebar menu expanded by default
				// if($mineralMain == $mineralParam) {
				if(in_array($curAction, array('geologyExploration','geologyReservesSubgrade','geologyOverburdenTrees','geologyPartThree','geologyPartSix'))) {
					$partIdII = ['mm-active', 'true', 'mm-show'];
				} else {
					$partIdII = ['', 'false', ''];
				}
				?>
				<li class="app-sidebar__heading <?php echo $partIdII[0]; ?>">
					<a href="#" class="u-li-menu menu_sec_5" aria-expanded="<?php echo $partIdII[1]; ?>">
						<!-- <i class="metismenu-icon pe-7s-plugin"></i> -->
						<i class="metismenu-icon fa fa-toolbox"></i>
						Part V
						<i class="metismenu-state-icon font_15 fa fa-chevron-down caret-left"></i>
					</a>

					<?php $linkPart++; ?>

					<ul class="mm-collapse <?php echo $partIdII[2]; ?>">
						<li>
							<?php if($curAction == 'geologyExploration') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Sec 1', '/mmsGSeries/geology_exploration', array('class'=>'u_menu_'.$_SESSION["secStatus"]["geology_exploration"].$activeStat)); $sec_link['part_'.$linkPart][] = "/mmsGSeries/geology_exploration"; ?>
							<?php $main_sec['partV'][1] = ""; ?>
						</li>
						<?php foreach ($allMin as $allMineral) { ?>
							<li>
								<?php $min_ss = strtolower(str_replace('_', ' ', $allMineral)); ?>
								<?php $min_su = strtolower(str_replace(' ', '_', $allMineral)); ?>
								<?php $min_cs = strtoupper(str_replace('_', ' ', $allMineral)); ?>
								<?php if($curAction == 'geologyReservesSubgrade' && $min_cs == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Sec 2/3 For - '.  ucwords(str_replace('_', ' ', $allMineral)), '/mmsGSeries/geology_reserves_subgrade/'.$allMineral, array('class'=>'u_menu_'.$_SESSION["secStatus"]["geology_reserves_subgrade"][$min_ss].$activeStat)); $sec_link['part_'.$linkPart][] = "/mmsGSeries/geology_reserves_subgrade/".$allMineral; ?>
								<?php $main_sec['partV'][2][$min_su] = ""; ?>
							</li>
						<?php } ?>
						<li>
							<?php if($curAction == 'geologyOverburdenTrees') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Sec 4/5', '/mmsGSeries/geology_overburden_trees', array('class'=>'u_menu_'.$_SESSION["secStatus"]["geology_overburden_trees"].$activeStat)); $sec_link['part_'.$linkPart][] = "/mmsGSeries/geology_overburden_trees"; ?>
							<?php $main_sec['partV'][3] = ""; ?>
						</li>
						<li>
							<?php if($curAction == 'geologyPartThree') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Sec 6', '/mmsGSeries/geology_part_three', array('class'=>'u_menu_'.$_SESSION["secStatus"]["geology_part_three"].$activeStat)); $sec_link['part_'.$linkPart][] = "/mmsGSeries/geology_part_three"; ?>
							<?php $main_sec['partV'][4] = ""; ?>
						</li>
						<?php foreach ($allMin as $allMineral) { ?>
							<li>
								<?php $min_ss = strtolower(str_replace('_', ' ', $allMineral)); ?>
								<?php $min_su = strtolower(str_replace(' ', '_', $allMineral)); ?>
								<?php $min_cs = strtoupper(str_replace('_', ' ', $allMineral)); ?>
								<?php if($curAction == 'geologyPartSix' && $min_cs == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Sec 7 For '.  ucwords(str_replace('_', ' ', $allMineral)), '/mmsGSeries/geology_part_six/'.$allMineral, array('class'=>'u_menu_'.$_SESSION["secStatus"]["geology_part_six"][$min_ss].$activeStat)); $sec_link['part_'.$linkPart][] = "/mmsGSeries/geology_part_six/".$allMineral; ?>
								<?php $main_sec['partV'][5][$min_su] = ""; ?>
							</li>
						<?php } ?>
					</ul>
				</li>

				<!--PART VI FOR PRIMARY MINERAL-->
				<?php 
				$title = "Part VI For ";
				$title.= ucwords(strtolower($partIIM1[0]));
				$mineral = $partIIM1[0];
				$min_sp_sm = strtolower(str_replace(' ','_',$mineral));
				$sub_min = '';
				$mineralMain = $mineral;
				$ironSubMin = '';
				if(strtolower($partIIM1[0]) == strtolower('Iron Ore')) {
					if($is_hematite) {
						$title.= ' (HEMATITE)';
						// $mineral.= ' (HEMATITE)';
						$ironSubMin = "/hematite";
						$mineralMain .= "/HEMATITE";
						$sub_min = 'hematite';
					} elseif($is_magnetite) {
						$title.= ' (MAGNETITE)';
						// $mineral.= ' (MAGNETITE)';
						$ironSubMin = "/magnetite";
						$mineralMain .= "/MAGNETITE";
						$sub_min = 'magnetite';
					}
				}

				// set active sidebar menu expanded by default
				if($mineralMain == $mineralParam && !in_array($curAction, array('geologyReservesSubgrade','geologyPartSix'))) {
					$partIdII = ['mm-active', 'true', 'mm-show'];
				} else {
					$partIdII = ['', 'false', ''];
				}
				?>
				<li class="app-sidebar__heading <?php echo $partIdII[0]; ?>">
					<a href="#" class="u-li-menu menu_sec_6" aria-expanded="<?php echo $partIdII[1]; ?>">
						<!-- <i class="metismenu-icon pe-7s-plugin"></i> -->
						<i class="metismenu-icon fa fa-toolbox"></i>
						<?php 
						echo $title;
						?>
						<i class="metismenu-state-icon font_15 fa fa-chevron-down caret-left"></i>
					</a>

					<?php $linkPart++; ?>

					<!--=======GETTING FORM TYPE BASED ON THE MINERAL NAME=====-->
					<?php if($partIIM1['formNo'] == 5) { ?>

						<!--PART II FOR PRECIOUS STONES - F5-->
						<ul class="mm-collapse <?php echo $partIdII[2]; ?>">
							<li>
								<?php if($curAction == 'romStocksOre' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Production / Stocks (ROM)', '/mms/rom_stocks_ore/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["rom_stocks_ore"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/rom_stocks_ore/".$mineral.$ironSubMin; ?>
								<?php $main_sec[$min_sp_sm][1] = ""; ?>
							</li>
							<li>
								<?php if($curAction == 'exMine' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Ex-mine price', '/mms/ex_mine/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["ex_mine"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/ex_mine/".$mineral.$ironSubMin; ?>
								<?php $main_sec[$min_sp_sm][2] = ""; ?>
							</li>
							<li>
								<?php if($curAction == 'conReco' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Recoveries at Concentrator', '/mms/con_reco/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["con_reco"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/con_reco/".$mineral.$ironSubMin; ?>
								<?php $main_sec[$min_sp_sm][3] = ""; ?>
							</li>
							<li>
								<?php if($curAction == 'smeltReco' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Recovery at the Smelter', '/mms/smelt_reco/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["smelt_reco"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/smelt_reco/".$mineral.$ironSubMin; ?>
								<?php $main_sec[$min_sp_sm][4] = ""; ?>
							</li>
							<li>
								<?php if($curAction == 'salesMetalProduct' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Sales(Metals/By product)', '/mms/sales_metal_product/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["sales_metal_product"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/sales_metal_product/".$mineral.$ironSubMin; ?>
								<?php $main_sec[$min_sp_sm][5] = ""; ?>
							</li>
							<li>
								<?php if($curAction == 'deductDetail' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Details of Deductions', '/mms/deduct_detail/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["deduct_detail"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/deduct_detail/".$mineral.$ironSubMin; ?>
								<?php $main_sec[$min_sp_sm][6] = ""; ?>
							</li>
							<li>
								<?php if($curAction == 'saleDespatch' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Sales/Dispatches', '/mms/sale_despatch/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["sale_despatch"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/sale_despatch/".$mineral.$ironSubMin; ?>
								<?php $main_sec[$min_sp_sm][7] = ""; ?>
							</li>
						</ul>
					<?php } elseif($partIIM1['formNo'] == 7) { ?>
					
						<!--PART II FOR PRECIOUS STONES - F7-->
						<ul class="mm-collapse">
							<li>
								<?php if($curAction == 'romStocksThree' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Production / Stocks (ROM)', '/mms/rom_stocks_three/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["rom_stocks_three"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/rom_stocks_three/".$mineral.$ironSubMin; ?>
								<?php $main_sec[$min_sp_sm][1] = ""; ?>
							</li>
							<li>
								<?php if($curAction == 'prodStockDis' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Production, Despatches and Stocks', '/mms/prod_stock_dis/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["prod_stock_dis"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/prod_stock_dis/".$mineral.$ironSubMin; ?>
								<?php $main_sec[$min_sp_sm][2] = ""; ?>
							</li>
							<li>
								<?php if($curAction == 'deductDetail' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Details of Deductions', '/mms/deduct_detail/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["deduct_detail"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/deduct_detail/".$mineral.$ironSubMin; ?>
								<?php $main_sec[$min_sp_sm][3] = ""; ?>
							</li>
							<li>
								<?php if($curAction == 'saleDespatch' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Sales/Dispatches', '/mms/sale_despatch/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["sale_despatch"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/sale_despatch/".$mineral.$ironSubMin; ?>
								<?php $main_sec[$min_sp_sm][4] = ""; ?>
							</li>
						</ul>
					<?php } else { ?>
						<ul class="mm-collapse">
							<?php if (strtolower($partIIM1[0]) == strtolower('Iron Ore')) { ?>
								<li>
									<?php if($curAction == 'oreType' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Type of ore', '/mms/ore_type/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["ore_type"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/ore_type/".$mineral.$ironSubMin; ?>
									<?php ($sub_min != '') ? $main_sec[$min_sp_sm][$sub_min][10] = "" : $main_sec[$min_sp_sm][10] = ""; ?>
								</li>
							<?php } ?>
							<li>
								<?php if($curAction == 'romStocks' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Production / Stocks (ROM)', '/mms/rom_stocks/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["rom_stocks"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/rom_stocks/".$mineral.$ironSubMin; ?>
								<?php ($sub_min != '') ? $main_sec[$min_sp_sm][$sub_min][1] = "" : $main_sec[$min_sp_sm][1] = ""; ?>
							</li>
							<li>
								<?php if($curAction == 'gradewiseProd' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Grade-wise Production', '/mms/gradewise_prod/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["gradewise_prod"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/gradewise_prod/".$mineral.$ironSubMin; ?>
								<?php ($sub_min != '') ? $main_sec[$min_sp_sm][$sub_min][2] = "" : $main_sec[$min_sp_sm][2] = ""; ?>
							</li>
							<?php if ($partIIM1['formNo'] == 8) { ?>
								<li>
									<?php if($curAction == 'pulverisation' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Pulverisation', '/mms/pulverisation/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["pulverisation"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/pulverisation/".$mineral.$ironSubMin; ?>
								<?php $main_sec[$min_sp_sm][5] = ""; ?>
								</li>
							<?php } ?>
							<li>
								<?php if($curAction == 'deductDetail' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Details of Deductions', '/mms/deduct_detail/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["deduct_detail"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/deduct_detail/".$mineral.$ironSubMin; ?>
								<?php ($sub_min != '') ? $main_sec[$min_sp_sm][$sub_min][3] = "" : $main_sec[$min_sp_sm][3] = ""; ?>
							</li>
							<li>
								<?php if($curAction == 'saleDespatch' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Sales/Dispatches', '/mms/sale_despatch/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["sale_despatch"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/sale_despatch/".$mineral.$ironSubMin; ?>
								<?php ($sub_min != '') ? $main_sec[$min_sp_sm][$sub_min][4] = "" : $main_sec[$min_sp_sm][4] = ""; ?>
							</li>
						</ul>
					<?php } ?>
				</li>

				<!--Only for Magnetite if iron ore is the primary mineral-->
				<?php 
				$mineral = $partIIM1[0];
				$min_sp_sm = strtolower(str_replace(' ','_',$mineral));
				$sub_min = 'magnetite';
				$mineralMain = $mineral;
				$title = "Part VI For ";
				$title .= ucwords(strtolower($partIIM1[0]));
				$title .= ' (MAGNETITE)';
				$ironSubMin = "/magnetite";
				$mineralMain .= "/MAGNETITE";

				// set active sidebar menu expanded by default
				if($mineralMain == $mineralParam) {
					$partIdIII = ['mm-active', 'true', 'mm-show'];
				} else {
					$partIdIII = ['', 'false', ''];
				}
				?>
				<?php if ($is_hematite && $is_magnetite && strtolower($partIIM1[0]) == strtolower('Iron Ore')) { ?>
					<li class="app-sidebar__heading <?php echo $partIdIII[0]; ?>">
						<a href="#" class="u-li-menu menu_sec_7" aria-expanded="<?php echo $partIdIII[1]; ?>">
							<i class="metismenu-icon fa fa-toolbox"></i>
							<?php echo $title; ?>
							<i class="metismenu-state-icon font_15 fa fa-chevron-down caret-left"></i>
						</a>
						<?php $linkPart++; ?>

						<ul class="mm-collapse <?php echo $partIdIII[2]; ?>">
							<li>
								<?php if($curAction == 'romStocks' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Production / Stocks (ROM)', '/mms/rom_stocks/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["rom_stocks"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/rom_stocks/".$mineral.$ironSubMin; ?>
								<?php //($sub_min != '') ? $main_sec[$min_sp_sm][$sub_min][1] = "" : $main_sec[$min_sp_sm][1] = ""; ?>
								<?php $main_sec[$min_sp_sm][$sub_min][1] = "" ; ?>
							</li>
							<li>
								<?php if($curAction == 'gradewiseProd' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Grade-wise Production', '/mms/gradewise_prod/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["gradewise_prod"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/gradewise_prod/".$mineral.$ironSubMin; ?>
								<?php //($sub_min != '') ? $main_sec[$min_sp_sm][$sub_min][2] = "" : $main_sec[$min_sp_sm][2] = ""; ?>
								<?php $main_sec[$min_sp_sm][$sub_min][2] = "" ; ?>
							</li>
						</ul>
					</li>
				<?php } ?>


				<!--For associated minerals-->
				<?php 

				$mCount = '8';
				foreach ($partIIMOther as $partIIM) {

					$title = "Part VI For ";
					$title.= ucwords(strtolower($partIIM[0]));
					$mineral = $partIIM[0];
					$min_sp_sm = strtolower(str_replace(' ','_',$mineral));
					$sub_min = '';
					$mineralMain = $mineral;
					$ironSubMin = '';
					if(strtolower($partIIM[0]) == strtolower('Iron Ore')) {
						if($is_hematite) {
							$title.= ' (HEMATITE)';
							// $mineral.= ' (HEMATITE)';
							$ironSubMin = "/hematite";
							$mineralMain .= "/HEMATITE";
							$sub_min = "hematite";
						} elseif($is_magnetite) {
							$title.= ' (MAGNETITE)';
							// $mineral.= ' (MAGNETITE)';
							$ironSubMin = "/magnetite";
							$mineralMain .= "/MAGNETITE";
							$sub_min = "magnetite";
						}
					}

					// set active sidebar menu expanded by default
					if($mineralMain == $mineralParam) {
						$partIdIV = ['mm-active', 'true', 'mm-show'];
					} else {
						$partIdIV = ['', 'false', ''];
					}
					?>

					<li class="app-sidebar__heading <?php echo $partIdIV[0]; ?>">
						<a href="#" class="u-li-menu menu_sec_<?php echo $mCount; ?>" aria-expanded="<?php echo $partIdIV[1]; ?>">
							<i class="metismenu-icon fa fa-toolbox"></i>
							<?php echo $title; ?>
							<i class="metismenu-state-icon font_15 fa fa-chevron-down caret-left"></i>
						</a>

						<?php $linkPart++; ?>

						<!--For associated minerals-->
						<?php if($partIIM['formNo'] == 5) { ?>
						
							<!--PART VI FOR PRECIOUS STONES - F5-->
							<ul class="mm-collapse <?php echo $partIdIV[2]; ?>">
								<li>
									<?php if($curAction == 'romStocksOre' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Production / Stocks (ROM)', '/mms/rom_stocks_ore/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["rom_stocks_ore"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/rom_stocks_ore/'.$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][1] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'exMine' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Ex-mine price', '/mms/ex_mine/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["ex_mine"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/ex_mine/'.$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][2] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'conReco' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Recoveries at Concentrator', '/mms/con_reco/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["con_reco"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/con_reco'.$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][3] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'smeltReco' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Recovery at the Smelter', '/mms/smelt_reco/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["smelt_reco"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/smelt_reco/'.$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][4] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'salesMetalProduct' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Sales(Metals/By product)', '/mms/sales_metal_product/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["sales_metal_product"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/sales_metal_product/'.$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][5] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'deductDetail' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Details of Deductions', '/mms/deduct_detail/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["deduct_detail"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/deduct_detail/'.$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][6] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'saleDespatch' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Sales/Dispatches', '/mms/sale_despatch/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["sale_despatch"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/sale_despatch/'.$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][7] = ""; ?>
								</li>
							</ul>
						<?php } elseif($partIIM['formNo'] == 7) { ?>

							<!--PART VI FOR PRECIOUS STONES - F7-->
							<ul class="mm-collapse <?php echo $partIdIV[2]; ?>">
								<li>
									<?php if($curAction == 'romStocksThree' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Production / Stocks (ROM)', '/mms/rom_stocks_three/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["rom_stocks_three"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/rom_stocks_three/".$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][1] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'prodStockDis' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Production, Despatches and Stocks', '/mms/prod_stock_dis/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["prod_stock_dis"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/prod_stock_dis/".$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][2] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'deductDetail' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Details of Deductions', '/mms/deduct_detail/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["deduct_detail"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/deduct_detail/".$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][3] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'saleDespatch' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Sales/Dispatches', '/mms/sale_despatch/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["sale_despatch"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/sale_despatch/".$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][4] = ""; ?>
								</li>
							</ul>
						<?php } else { ?>
							<ul class="mm-collapse <?php echo $partIdIV[2]; ?>">
								<?php if (strtolower($partIIM[0]) == strtolower('Iron Ore')) { ?>
									<li>
										<?php if($curAction == 'oreType' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
										<?php echo $this->Html->link('Type of ore', '/mms/ore_type/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["ore_type"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/mms/ore_type/".$mineral.$ironSubMin; ?>
										<?php ($sub_min != '') ? $main_sec[$min_sp_sm][$sub_min][10] = "" : $main_sec[$min_sp_sm][10] = ""; ?>
									</li>
								<?php } ?>
								<li>
									<?php if($curAction == 'romStocks' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Production / Stocks (ROM)', '/mms/rom_stocks/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["rom_stocks"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/rom_stocks/'.$mineral.$ironSubMin; ?>
									<?php ($sub_min != '') ? $main_sec[$min_sp_sm][$sub_min][1] = "" : $main_sec[$min_sp_sm][1] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'gradewiseProd' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Grade-wise Production', '/mms/gradewise_prod/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["gradewise_prod"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/gradewise_prod/'.$mineral.$ironSubMin; ?>
									<?php ($sub_min != '') ? $main_sec[$min_sp_sm][$sub_min][2] = "" : $main_sec[$min_sp_sm][2] = ""; ?>
								</li>

								<!--FOR SECONDARY MINERALS CHECK WHETHER IT BELONGS TO FORM-8 BEFORE SHOWING THE PULV-LINK-->
								<?php if ($partIIM['formNo'] == 8) { ?>
									<li>
										<?php if($curAction == 'pulverisation' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
										<?php echo $this->Html->link('Pulverisation', '/mms/pulverisation/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["pulverisation"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/pulverisation/'.$mineral.$ironSubMin; ?>
									<?php ($sub_min != '') ? $main_sec[$min_sp_sm][$sub_min][5] = "" : $main_sec[$min_sp_sm][5] = ""; ?>
									</li>
								<?php } ?>

								<li>
									<?php if($curAction == 'deductDetail' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Details of Deductions', '/mms/deduct_detail/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["deduct_detail"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/deduct_detail/'.$mineral.$ironSubMin; ?>
									<?php ($sub_min != '') ? $main_sec[$min_sp_sm][$sub_min][3] = "" : $main_sec[$min_sp_sm][3] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'saleDespatch' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Sales/Dispatches', '/mms/sale_despatch/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["sale_despatch"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/sale_despatch/'.$mineral.$ironSubMin; ?>
									<?php ($sub_min != '') ? $main_sec[$min_sp_sm][$sub_min][4] = "" : $main_sec[$min_sp_sm][4] = ""; ?>
								</li>
							</ul>
						<?php } ?>
					</li>

				<?php $mCount++; } ?>

				<?php 
				foreach ($partIIMOther as $partIIM) { ?>

					<!--Only for Magnetite if iron ore is the associative mineral-->
					<?php if ($is_hematite && $is_magnetite && strtolower($partIIM[0]) == strtolower('Iron Ore')) { ?>
						<?php 
						// set active sidebar menu expanded by default
						$title = "Part VI For ";
						$title.= ucwords(strtolower($partIIM[0]));
						$mineral = $partIIM[0];
						$min_sp_sm = strtolower(str_replace(' ','_',$mineral));
						$sub_min = 'magnetite';
						$title.= ' (MAGNETITE)';
						// $mineral.= ' (MAGNETITE)';
						$ironSubMin = '/magnetite';
						$mineralMain = $mineral.'/MAGNETITE';;

						if($mineralMain == $mineralParam) {
							$partIdV = ['mm-active', 'true', 'mm-show'];
						} else {
							$partIdV = ['', 'false', ''];
						}
						?>
						<li class="app-sidebar__heading <?php echo $partIdV[0]; ?>">
							<a href="#" class="u-li-menu menu_sec_<?php echo $mCount; ?>" aria-expanded="<?php echo $partIdV[1]; ?>">
								<i class="metismenu-icon fa fa-toolbox"></i>
								<?php echo $title; ?>
								<i class="metismenu-state-icon font_15 fa fa-chevron-down caret-left"></i>
							</a>

							<?php $linkPart++; ?>

							<ul class="mm-collapse <?php echo $partIdV[2]; ?>">
								<li>
									<?php if($curAction == 'romStocks' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Production / Stocks (ROM)', '/mms/rom_stocks/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["rom_stocks"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/rom_stocks/'.$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][$sub_min][1] = ""; ?>
								</li>
								<li>
									<?php if($curAction == 'gradewiseProd' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Grade-wise Production', '/mms/gradewise_prod/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["gradewise_prod"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = '/mms/gradewise_prod/'.$mineral.$ironSubMin; ?>
									<?php $main_sec[$min_sp_sm][$sub_min][2] = ""; ?>
								</li>
							</ul>
						</li>
					<?php $mCount++; } ?>

				<?php } ?>


				<!-- PART VII -->
				<?php 
				$mineral = $partIIM1[0];
				$mineralMain = $mineral;
				$ironSubMin = '';

				// set active sidebar menu expanded by default
				if($curAction == 'productionCost') {
					$partIdVII = ['mm-active', 'true', 'mm-show'];
				} else {
					$partIdVII = ['', 'false', ''];
				}
				?>
				<li class="app-sidebar__heading <?php echo $partIdVII[0]; ?>">
					<a href="#" class="u-li-menu menu_sec_<?php echo $mCount; ?>" aria-expanded="<?php echo $partIdVII[1]; ?>">
						<!-- <i class="metismenu-icon pe-7s-plugin"></i> -->
						<i class="metismenu-icon fa fa-toolbox"></i>
						Part VII
						<i class="metismenu-state-icon font_15 fa fa-chevron-down caret-left"></i>
					</a>

					<?php $linkPart++; ?>

					<ul class="mm-collapse <?php echo $partIdVII[2]; ?>">
						<li>
							<?php if($curAction == 'productionCost') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Cost of Production', '/mmsGSeries/production_cost', array('class'=>'u_menu_'.$_SESSION["secStatus"]["production_cost"].$activeStat)); $sec_link['part_'.$linkPart][] = "/mmsGSeries/production_cost"; ?>
							<?php $main_sec['partVII'][1] = ""; ?>
						</li>
					</ul>
				</li>

				<!-- Add new menu option for to view applicant profile details, Done by Pravin Bhakare 22-12-2020-->
				<!-- <?php 
				// set active sidebar menu expanded by default
				/* if($partId == 'P'.$mCount) {
					$partIdVI = ['mm-active', 'true', 'mm-show'];
				} else {
					$partIdVI = ['', 'false', ''];
				} */
				?>
				<li class="app-sidebar__heading <?php //echo $partIdVI[0]; ?>">
					<a href="#" class="u-li-menu" aria-expanded="<?php //echo $partIdVI[1]; ?>">
						<i class="metismenu-icon pe-7s-user"></i>
						Profile
						<i class="metismenu-state-icon font_15 fa fa-chevron-down caret-left"></i>
					</a>
					<ul class="mm-collapse <?php //echo $partIdVI[2]; ?>">
						<li>
							<?php //if($formId == 'F91') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php //echo $this->Html->link('My Profile', '/monthly/activeForm/P'.$mCount.'/F91', array('class'=>'u_menu_error'.$activeStat)); $fLink[] = '/monthly/activeForm/P'.$mCount.'/F91'; ?>
						</li>
					</ul>
				</li> -->

			<?php } ?>

		</ul>
	</div>
</div>

<?php $this->getRequest()->getSession()->write('sec_link',$sec_link); ?>
<?php $this->getRequest()->getSession()->write('main_sec',$main_sec); ?>
