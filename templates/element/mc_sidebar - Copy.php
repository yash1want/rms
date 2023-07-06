
<div class="scrollbar-sidebar">
	<div class="app-sidebar__inner">
		<ul class="vertical-nav-menu">
			<li class="app-sidebar__heading">
				<?php echo $this->Html->link('<i class="metismenu-icon pe-7s-home"></i>DASHBOARD', '/auth/home', array('class'=>'u-li-menu','escape'=>false)); ?>
			</li>

			<?php 
			$sec_link = array(); // form link array
			$linkPart = 1;
			$curController = $this->getRequest()->getParam('controller');
			$curAction = $this->getRequest()->getParam('action');
			$mineralParam = $this->getRequest()->getParam('pass');
			if(null==$mineralParam){
				$mineralParam = "";
			} else {
				$mineralPar = $mineralParam[0];
				$mineralPar .= (isset($mineralParam[1])) ? "/".$mineralParam[1] : "";
				$mineralParam = $mineralPar;
			}

			$mineralParam = strtoupper($mineralParam);

			if(strtolower($curController) == 'monthly' && $curAction!= 'selectReturn') {
			?>
				<li class="app-sidebar__heading">FORM - F<?php echo $this->getRequest()->getSession()->read('mc_form_main'); ?> </li>
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
							<?php echo $this->Html->link('Details of the Mine', '/monthly/mine', array('class'=>'u_menu_'.$_SESSION["secStatus"]["mine"].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/mine"; ?>
						</li>
						<li>
							<?php if($curAction == 'nameAddress') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Name and Address', '/monthly/name_address', array('class'=>'u_menu_'.$_SESSION["secStatus"]["name_address"].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/name_address"; ?>
						</li>
						<li>
							<?php if($curAction == 'rent') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Details of Rent/Royalty', '/monthly/rent', array('class'=>'u_menu_'.$_SESSION["secStatus"]["rent"].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/rent"; ?>
						</li>
						<li>
							<?php if($curAction == 'workingDetail') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Details on working', '/monthly/working_detail', array('class'=>'u_menu_'.$_SESSION["secStatus"]["working_detail"].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/working_detail"; ?>
						</li>
						<li>
							<?php if($curAction == 'dailyAverage') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Average Daily Employment', '/monthly/daily_average', array('class'=>'u_menu_'.$_SESSION["secStatus"]["daily_average"].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/daily_average"; ?>
						</li>
					</ul>	
				</li>
				<!--PART II FOR PRIMARY MINERAL-->
				<?php 

				$title = "Part II For ";
				$title.= ucwords(strtolower($partIIM1[0]));
				$mineral = $partIIM1[0];
				$mineralMain = $mineral;
				$ironSubMin = '';
				if(strtolower($partIIM1[0]) == strtolower('Iron Ore')) {
					if($is_hematite) {
						$title.= ' (HEMATITE)';
						// $mineral.= ' (HEMATITE)';
						$ironSubMin = "/hematite";
						$mineralMain .= "/HEMATITE";
					} elseif($is_magnetite) {
						$title.= ' (MAGNETITE)';
						// $mineral.= ' (MAGNETITE)';
						$ironSubMin = "/magnetite";
						$mineralMain .= "/MAGNETITE";
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
					<?php 
						if(isset($_GET['working'])){
							echo 'formno: '.$formno;
						}
					?>

					<!--=======GETTING FORM TYPE BASED ON THE MINERAL NAME=====-->
					<?php if($partIIM1['formNo'] == 5) { ?>
						<ul class="mm-collapse <?php echo $partIdII[2]; ?>">
							<li>
								<?php if($curAction == 'romStocksOre' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F11') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Production / Stocks (ROM)', '/monthly/rom_stocks_ore/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["rom_stocks_ore"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/rom_stocks_ore/".$mineral.$ironSubMin; ?>
							</li>
							<li>
								<?php if($curAction == 'exMine' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F12') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Ex-mine price', '/monthly/ex_mine/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["ex_mine"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/ex_mine/".$mineral.$ironSubMin; ?>
							</li>
							<li>
								<?php if($curAction == 'conReco' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F13') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Recoveries at Concentrator', '/monthly/con_reco/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["con_reco"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/con_reco/".$mineral.$ironSubMin; ?>
							</li>
							<li>
								<?php if($curAction == 'smeltReco' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F14') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Recovery at the Smelter', '/monthly/smelt_reco/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["smelt_reco"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/smelt_reco/".$mineral.$ironSubMin; ?>
							</li>
							<li>
								<?php if($curAction == 'salesMetalProduct' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F15') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Sales(Metals/By product)', '/monthly/sales_metal_product/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["sales_metal_product"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/sales_metal_product/".$mineral.$ironSubMin; ?>
							</li>
							<li>
								<?php if($curAction == 'deductDetail' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F16') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Details of Deductions', '/monthly/deduct_detail/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["deduct_detail"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/deduct_detail/".$mineral.$ironSubMin; ?>
							</li>
							<li>
								<?php if($curAction == 'saleDespatch' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F17') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Sales/Dispatches', '/monthly/sale_despatch/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["sale_despatch"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/sale_despatch/".$mineral.$ironSubMin; ?>
							</li>
						</ul>
					<?php } elseif($partIIM1['formNo'] == 7) { ?>
						<ul class="mm-collapse">
							<li>
								<?php if($curAction == 'romStocksThree' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F21') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Production / Stocks (ROM)', '/monthly/rom_stocks_three/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["rom_stocks_three"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/rom_stocks_three/".$mineral.$ironSubMin; ?>
							</li>
							<li>
								<?php if($curAction == 'prodStockDis' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F22') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Production, Despatches and Stocks', '/monthly/prod_stock_dis/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["prod_stock_dis"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/prod_stock_dis/".$mineral.$ironSubMin; ?>
							</li>
							<li>
								<?php if($curAction == 'deductDetail' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F23') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Details of Deductions', '/monthly/deduct_detail/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["deduct_detail"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/deduct_detail/".$mineral.$ironSubMin; ?>
							</li>
							<li>
								<?php if($curAction == 'saleDespatch' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F24') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Sales/Dispatches', '/monthly/sale_despatch/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["sale_despatch"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/sale_despatch/".$mineral.$ironSubMin; ?>
							</li>
						</ul>
					<?php } else { ?>
						<ul class="mm-collapse">
							<?php if (strtolower($partIIM1[0]) == strtolower('Iron Ore')) { ?>
								<li>
									<?php if($curAction == 'oreType' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F31') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //echo $this->Html->link('Type of ore', '/monthly/ore_type/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["ore_type"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/ore_type/".$mineral.$ironSubMin; ?>
									<?php echo $this->Html->link('Type of ore', '/monthly/ore_type/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["ore_type"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/ore_type/".$mineral.$ironSubMin; ?>
								</li>
							<?php } ?>
							<li>
								<?php if($curAction == 'romStocks' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F32') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Production / Stocks (ROM)', '/monthly/rom_stocks/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["rom_stocks"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/rom_stocks/".$mineral.$ironSubMin; ?>
							</li>
							<li>
								<?php if($curAction == 'gradewiseProd' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F33') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Grade-wise Production', '/monthly/gradewise_prod/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["gradewise_prod"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/gradewise_prod/".$mineral.$ironSubMin; ?>
							</li>
							<?php if ($partIIM1['formNo'] == 8) { ?>
								<li>
									<?php if($curAction == 'pulverisation' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F34') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Pulverisation', '/monthly/pulverisation/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["pulverisation"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/pulverisation/".$mineral.$ironSubMin; ?>
								</li>
							<?php } ?>
							<li>
								<?php if($curAction == 'deductDetail' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F35') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Details of Deductions', '/monthly/deduct_detail/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["deduct_detail"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/deduct_detail/".$mineral.$ironSubMin; ?>
							</li>
							<li>
								<?php if($curAction == 'saleDespatch' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F36') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Sales/Dispatches', '/monthly/sale_despatch/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["sale_despatch"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/sale_despatch/".$mineral.$ironSubMin; ?>
							</li>
						</ul>
					<?php } ?>
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
								<?php echo $this->Html->link('Production / Stocks (ROM)', '/monthly/rom_stocks/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["rom_stocks"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/rom_stocks/".$mineral.$ironSubMin; ?>
							</li>
							<li>
								<?php if($curAction == 'gradewiseProd' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php //if($formId == 'F42') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
								<?php echo $this->Html->link('Grade-wise Production', '/monthly/gradewise_prod/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["gradewise_prod"][strtolower($mineral).$ironSubMin].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/gradewise_prod/".$mineral.$ironSubMin; ?>
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
					$mineralMain = $mineral;
					$ironSubMin = '';
					if(strtolower($partIIM[0]) == strtolower('Iron Ore')) {
						if($is_hematite) {
							$title.= ' (HEMATITE)';
							$mineral.= ' (HEMATITE)';
							$ironSubMin = "/hematite";
							$mineralMain .= "/HEMATITE";
						} elseif($is_magnetite) {
							$title.= ' (MAGNETITE)';
							$mineral.= ' (MAGNETITE)';
							$ironSubMin = "/magnetite";
							$mineralMain .= "/MAGNETITE";
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
									<?php if($formId == 'F51') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Production / Stocks (ROM)', '/monthly/activeForm/P'.$mCount.'/F51/'.$mineral, array('class'=>'u_menu_error'.$activeStat)); $sec_link['part_'.$linkPart][] = '/monthly/activeForm/P'.$mCount.'/F51/'.$mineral; ?>
								</li>
								<li>
									<?php if($formId == 'F52') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Ex-mine price', '/monthly/activeForm/P'.$mCount.'/F52/'.$mineral, array('class'=>'u_menu_error'.$activeStat)); $sec_link['part_'.$linkPart][] = '/monthly/activeForm/P'.$mCount.'/F52/'.$mineral; ?>
								</li>
								<li>
									<?php if($formId == 'F53') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Recoveries at Concentrator', '/monthly/activeForm/P'.$mCount.'/F53/'.$mineral, array('class'=>'u_menu_error'.$activeStat)); $sec_link['part_'.$linkPart][] = '/monthly/activeForm/P'.$mCount.'/F53/'.$mineral; ?>
								</li>
								<li>
									<?php if($formId == 'F54') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Recovery at the Smelter', '/monthly/activeForm/P'.$mCount.'/F54/'.$mineral, array('class'=>'u_menu_error'.$activeStat)); $sec_link['part_'.$linkPart][] = '/monthly/activeForm/P'.$mCount.'/F54/'.$mineral; ?>
								</li>
								<li>
									<?php if($formId == 'F55') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Sales(Metals/By product)', '/monthly/activeForm/P'.$mCount.'/F55/'.$mineral, array('class'=>'u_menu_error'.$activeStat)); $sec_link['part_'.$linkPart][] = '/monthly/activeForm/P'.$mCount.'/F55/'.$mineral; ?>
								</li>
								<li>
									<?php if($formId == 'F56') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Details of Deductions', '/monthly/activeForm/P'.$mCount.'/F56/'.$mineral, array('class'=>'u_menu_error'.$activeStat)); $sec_link['part_'.$linkPart][] = '/monthly/activeForm/P'.$mCount.'/F56/'.$mineral; ?>
								</li>
								<li>
									<?php if($formId == 'F57') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Sales/Dispatches', '/monthly/activeForm/P'.$mCount.'/F57/'.$mineral, array('class'=>'u_menu_error'.$activeStat)); $sec_link['part_'.$linkPart][] = '/monthly/activeForm/P'.$mCount.'/F57/'.$mineral; ?>
								</li>
							</ul>
						<?php } elseif($partIIM['formNo'] == 7) { ?>
							<ul class="mm-collapse <?php echo $partIdIV[2]; ?>">
								<li>
									<?php if($curAction == 'romStocksThree' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F61') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Production / Stocks (ROM)', '/monthly/rom_stocks_three/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["rom_stocks_three"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/rom_stocks_three/".$mineral.$ironSubMin; ?>
								</li>
								<li>
									<?php if($curAction == 'prodStockDis' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F62') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Production, Despatches and Stocks', '/monthly/prod_stock_dis/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["prod_stock_dis"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/prod_stock_dis/".$mineral.$ironSubMin; ?>
								</li>
								<li>
									<?php if($curAction == 'deductDetail' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F63') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Details of Deductions', '/monthly/deduct_detail/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["deduct_detail"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/deduct_detail/".$mineral.$ironSubMin; ?>
								</li>
								<li>
									<?php if($curAction == 'saleDespatch' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F64') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Sales/Dispatches', '/monthly/sale_despatch/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["sale_despatch"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/sale_despatch/".$mineral.$ironSubMin; ?>
								</li>
							</ul>
						<?php } else { ?>
							<ul class="mm-collapse <?php echo $partIdIV[2]; ?>">
								<?php if (strtolower($partIIM[0]) == strtolower('Iron Ore')) { ?>
									<li>
										<?php if($curAction == 'oreType' && $mineralMain == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
										<?php //if($formId == 'F71') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
										<?php echo $this->Html->link('Type of ore', '/monthly/ore_type/'.$mineral.$ironSubMin, array('class'=>'u_menu_error'.$activeStat)); $sec_link['part_'.$linkPart][] = "/monthly/ore_type/".$mineral.$ironSubMin; ?>
									</li>
								<?php } ?>
								<li>
									<?php if($curAction == 'romStocks' && $mineral == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F72') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Production / Stocks (ROM)', '/monthly/rom_stocks/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["rom_stocks"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = '/monthly/rom_stocks/'.$mineral.$ironSubMin; ?>
								</li>
								<li>
									<?php if($curAction == 'gradewiseProd' && $mineral == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F73') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Grade-wise Production', '/monthly/gradewise_prod/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["gradewise_prod"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = '/monthly/gradewise_prod/'.$mineral.$ironSubMin; ?>
								</li>
								<?php if ($partIIM['formNo'] == 8) { ?>
									<li>
										<?php if($curAction == 'pulverisation' && $mineral == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
										<?php //if($formId == 'F74') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
										<?php echo $this->Html->link('Pulverisation', '/monthly/pulverisation/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["pulverisation"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = '/monthly/pulverisation/'.$mineral.$ironSubMin; ?>
									</li>
								<?php } ?>
								<li>
									<?php if($curAction == 'deductDetail' && $mineral == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F75') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Details of Deductions', '/monthly/deduct_detail/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["deduct_detail"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = '/monthly/deduct_detail/'.$mineral.$ironSubMin; ?>
								</li>
								<li>
									<?php if($curAction == 'saleDespatch' && $mineral == $mineralParam) { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php //if($formId == 'F76') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Sales/Dispatches', '/monthly/sale_despatch/'.$mineral.$ironSubMin, array('class'=>'u_menu_'.$_SESSION["secStatus"]["sale_despatch"][strtolower($mineral)].$activeStat)); $sec_link['part_'.$linkPart][] = '/monthly/sale_despatch/'.$mineral.$ironSubMin; ?>
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
						if($partId == 'P'.$mCount) {
							$partIdV = ['mm-active', 'true', 'mm-show'];
						} else {
							$partIdV = ['', 'false', ''];
						}
						?>
						<li class="app-sidebar__heading <?php echo $partIdV[0]; ?>">
							<a href="#" class="u-li-menu menu_sec_<?php echo $mCount; ?>" aria-expanded="<?php echo $partIdV[1]; ?>">
								<i class="metismenu-icon pe-7s-plugin"></i>
								<?php 
								$title = "Part II For ";
								$title.= ucwords(strtolower($partIIM[0]));
								$mineral = $partIIM[0];
								$title.= ' (MAGNETITE)';
								$mineral.= ' (MAGNETITE)';
								echo $title;
								?>
								<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
							</a>

							<?php $linkPart++; ?>

							<ul class="mm-collapse <?php echo $partIdV[2]; ?>">
								<li>
									<?php if($formId == 'F81') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Production / Stocks (ROM)', '/monthly/activeForm/P'.$mCount.'/F81/'.$mineral, array('class'=>'u_menu_error'.$activeStat)); $sec_link['part_'.$linkPart][] = '/monthly/activeForm/P'.$mCount.'/F81/'.$mineral; ?>
								</li>
								<li>
									<?php if($formId == 'F82') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
									<?php echo $this->Html->link('Grade-wise Production', '/monthly/activeForm/P'.$mCount.'/F82/'.$mineral, array('class'=>'u_menu_error'.$activeStat)); $sec_link['part_'.$linkPart][] = '/monthly/activeForm/P'.$mCount.'/F82/'.$mineral; ?>
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
							<?php //echo $this->Html->link('My Profile', '/monthly/activeForm/P'.$mCount.'/F91', array('class'=>'u_menu_error'.$activeStat)); $fLink[] = '/monthly/activeForm/P'.$mCount.'/F91'; ?>
						</li>
					</ul>
				</li> -->

			<?php 
			} else if(strtolower($curController) == 'enduser' && $curAction!= 'selectReturn') {
			?>
				<li class="app-sidebar__heading">FORM - L</li>
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
							<?php //if($curAction == 'mine') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Instruction', '/enduser/instruction', array('class'=>'u_menu_error')); $sec_link['part_1'][] = '/enduser/instruction'; ?>
						</li>
						<li>
							<?php //if($curAction == 'mine') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('General Particulars', '/enduser/generalParticular', array('class'=>'u_menu_error')); $sec_link['part_1'][] = '/enduser/generalParticular'; ?>
						</li>
					</ul>	
				</li>

				<!-- PART II -->
				<?php 
				// set active sidebar menu expanded by default
				
				$mineralMain = null;
				if($mineralMain == $mineralParam) {
					$partIdII = ['mm-active', 'true', 'mm-show'];
				} else {
					$partIdII = ['', 'false', ''];
				}
				?>
				<li class="app-sidebar__heading <?php echo $partIdII[0]; ?>">
					<a href="#" class="u-li-menu menu_sec_1" aria-expanded="<?php echo $partIdI[1]; ?>">
						<i class="metismenu-icon pe-7s-note2"></i>
						PART II
						<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
					</a>
					<ul class="mm-collapse <?php echo $partIdI[2]; ?>">
						<li>
							<?php //if($curAction == 'mine') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Trading Activity', '/enduser/tradingActivity', array('class'=>'u_menu_error')); $sec_link['part_2'][] = '/enduser/tradingActivity'; ?>
						</li>
						<li>
							<?php //if($curAction == 'mine') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Export Activity', '/enduser/exportOfOre', array('class'=>'u_menu_error')); $sec_link['part_2'][] = '/enduser/exportOfOre'; ?>
						</li>
						<li>
							<?php //if($curAction == 'mine') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('End-use Mineral Based Activity', '/enduser/mineralBaseActivity', array('class'=>'u_menu_error')); $sec_link['part_2'][] = '/enduser/mineralBaseActivity'; ?>
						</li>
						<li>
							<?php //if($curAction == 'mine') { $activeStat = ' active_menu'; } else { $activeStat = ''; } ?>
							<?php echo $this->Html->link('Storage Activity', '/enduser/storageActivity', array('class'=>'u_menu_error')); $sec_link['part_2'][] = '/enduser/storageActivity'; ?>
						</li>
					</ul>	
				</li>


			<?php } else { ?>
				
				<?php if($_SESSION['is_mine_owner'] == true || 
						 $_SESSION['endUserFlag'] == false ){ ?>
				<li class="app-sidebar__heading">
					<a href="#" class="u-li-menu" aria-expanded="false">
						<i class="metismenu-icon pe-7s-note2"></i>
						Monthly Returns (F)
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
					<ul class="mm-collapse" style="height: 6.4px;">
						<li>
							<?php echo $this->Html->link('<i class="metismenu-icon pe-7s-diamond"></i>File Return', '/monthly/selectReturn', array('escape'=>false)); ?>
						</li>
						<?php if($_SESSION['is_mine_owner'] == false){ ?>
							<li>
								<a href="<?php echo $this->request->getAttribute('webroot'); ?>auth/returns/monthly/f/submitted">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Submitted (<?php echo $_SESSION['mSubmittedCount']; ?>)
								</a>
							</li>
							<li>
								<a href="<?php echo $this->request->getAttribute('webroot'); ?>auth/returns/monthly/f/replied">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Replied (<?php echo $_SESSION['mRepliedCount']; ?>)
								</a>
							</li>
						<?php } ?>
						<li>
							<a href="<?php echo $this->request->getAttribute('webroot'); ?>auth/returns/monthly/f/referredback">
								<i class="metismenu-icon pe-7s-diamond"></i>
								Referred Back (<?php echo $_SESSION['mReferredBackCount']; ?>)
							</a>
						</li>
						<li>
							<?php //echo $this->Html->link('<i class="metismenu-icon pe-7s-diamond"></i>'.$dashboardB.' ('.$referred.')', '/monthly/rejectedReturns/MONTHLY', array('escape'=>false)); ?>
							<a href="<?php echo $this->request->getAttribute('webroot'); ?>auth/returns/monthly/f/accepted">
								<i class="metismenu-icon pe-7s-diamond"></i>
								Accepted (<?php echo $_SESSION['mApprovedCount']; ?>)
							</a>
						</li>
					</ul>	
                </li>
				<li class="app-sidebar__heading">
					<a href="#" class="u-li-menu" aria-expanded="false">
						<i class="metismenu-icon pe-7s-display1"></i>
						Annual Returns (G)
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
					<ul class="mm-collapse">
					<?php if($_SESSION['is_mine_owner'] == false){ ?>	
						<li>
							<a href="<?php echo $this->request->getAttribute('webroot'); ?>auth/returns/annual/g/submitted">
								<i class="metismenu-icon pe-7s-diamond"></i>
								Submitted (<?php echo $_SESSION['aSubmittedCount']; ?>)
							</a>
						</li>
						<li>
							<a href="<?php echo $this->request->getAttribute('webroot'); ?>auth/returns/annual/g/replied">
								<i class="metismenu-icon pe-7s-diamond"></i>
								Replied (<?php echo $_SESSION['aRepliedCount']; ?>)
							</a>
						</li>
					<?php } ?>	
						<li>
							<a href="<?php echo $this->request->getAttribute('webroot'); ?>auth/returns/annual/g/referredback">
								<i class="metismenu-icon pe-7s-diamond"></i>
								Referred Back (<?php echo $_SESSION['aReferredBackCount']; ?>)
							</a>
						</li>
						<li>
							<a href="<?php echo $this->request->getAttribute('webroot'); ?>auth/returns/annual/g/accepted">
								<i class="metismenu-icon pe-7s-diamond"></i>
								Accepted (<?php echo $_SESSION['aApprovedCount']; ?>)
							</a>
						</li>						
					</ul>
				</li>
				<?php } ?>		
				<?php if($_SESSION['is_mine_owner'] == true || 
						 $_SESSION['endUserFlag'] == true ){ ?>
				<li class="app-sidebar__heading">
					<a href="#" class="u-li-menu" aria-expanded="false">
						<i class="metismenu-icon pe-7s-date"></i>
						Monthly Returns (M)
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
					<ul class="mm-collapse">
					<li>
						<?php echo $this->Html->link('<i class="metismenu-icon pe-7s-diamond"></i>File Return', '/enduser/selectReturn', array('escape'=>false)); ?>
					</li>
					<?php if($_SESSION['is_mine_owner'] == false){ ?>		
						<li>
							<a href="<?php echo $this->request->getAttribute('webroot'); ?>auth/returns/monthly/m/submitted">
								<i class="metismenu-icon pe-7s-diamond"></i>
								Submitted (<?php echo $_SESSION['emSubmittedCount']; ?>)
							</a>
						</li>
						<li>
							<a href="<?php echo $this->request->getAttribute('webroot'); ?>auth/returns/monthly/m/replied">
								<i class="metismenu-icon pe-7s-diamond"></i>
								Replied (<?php echo $_SESSION['emRepliedCount']; ?>)
							</a>
						</li>
					<?php } ?>		
						<li>
							<a href="<?php echo $this->request->getAttribute('webroot'); ?>auth/returns/monthly/m/referredback">
								<i class="metismenu-icon pe-7s-diamond"></i>
								Referred Back (<?php echo $_SESSION['emReferredBackCount']; ?>)
							</a>
						</li>
						<li>
							<a href="<?php echo $this->request->getAttribute('webroot'); ?>auth/returns/monthly/m/accepted">
								<i class="metismenu-icon pe-7s-diamond"></i>
								Accepted (<?php echo $_SESSION['emApprovedCount']; ?>)
							</a>
						</li>						
					</ul>
				</li>
				<li class="app-sidebar__heading">
					<a href="#" class="u-li-menu" aria-expanded="false">
						<i class="metismenu-icon pe-7s-id"></i>
						Annual Returns (L)
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
					<ul class="mm-collapse">
					<?php if($_SESSION['is_mine_owner'] == false){ ?>
						<li>
							<a href="<?php echo $this->request->getAttribute('webroot'); ?>auth/returns/annual/l/submitted">
								<i class="metismenu-icon pe-7s-diamond"></i>
								Submitted (<?php echo $_SESSION['eaSubmittedCount']; ?>)
							</a>
						</li>
						<li>
							<a href="<?php echo $this->request->getAttribute('webroot'); ?>auth/returns/annual/l/replied">
								<i class="metismenu-icon pe-7s-diamond"></i>
								Replied (<?php echo $_SESSION['eaRepliedCount']; ?>)
							</a>
						</li>
					<?php } ?>	
						<li>
							<a href="<?php echo $this->request->getAttribute('webroot'); ?>auth/returns/annual/l/referredback">
								<i class="metismenu-icon pe-7s-diamond"></i>
								Referred Back (<?php echo $_SESSION['eaReferredBackCount']; ?>)
							</a>
						</li>
						<li>
							<a href="<?php echo $this->request->getAttribute('webroot'); ?>auth/returns/annual/l/accepted">
								<i class="metismenu-icon pe-7s-diamond"></i>
								Accepted (<?php echo $_SESSION['eaApprovedCount']; ?>)
							</a>
						</li>						
					</ul>
				</li>		
				<?php } ?>		
				<li class="app-sidebar__heading">
					<a href="#" class="u-li-menu" aria-expanded="false">
						<i class="metismenu-icon pe-7s-users"></i>
						All Users
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
					<ul class="mm-collapse">
						<li>
							<a href="#">
								<i class="metismenu-icon pe-7s-diamond"></i>
								Create Users
							</a>
						</li>
						<li>
							<a href="#">
								<i class="metismenu-icon pe-7s-diamond"></i>
								List Users
							</a>
						</li>
					</ul>
				</li>
				<li class="app-sidebar__heading">
					<a href="#" class="u-li-menu" aria-expanded="false">
					<i class="metismenu-icon pe-7s-like2"></i>
						FEEDBACK
                    </a>   
				</li>

			<?php } ?>

		</ul>
	</div>
</div>

<?php $this->getRequest()->getSession()->write('sec_link',$sec_link); ?>