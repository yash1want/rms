<div class="scrollbar-sidebar">
	<div class="app-sidebar__inner">
		<ul class="vertical-nav-menu">
			<li class="app-sidebar__heading">
				<?php echo $this->Html->link('<i class="metismenu-icon pe-7s-home"></i>DASHBOARD', '/mms/home', array('class' => 'u-li-menu', 'escape' => false)); ?>
			</li>

			<?php
			$sec_link = array(); // form link array
			$linkPart = 1;
			$curController = $this->getRequest()->getParam('controller');
			$curAction = $this->getRequest()->getParam('action');
			$mineralParam = $this->getRequest()->getParam('pass');
			if (null == $mineralParam) {
				$mineralParam = "";
			} else {
				$mineralParam = $mineralParam[0];
			}

			$mineralParam = strtoupper($mineralParam);
			if (strtolower($curController) == 'monthly' && $curAction != 'selectReturn') {
			?>
				<li class="app-sidebar__heading">FORM - F<?php echo $this->getRequest()->getSession()->read('mc_form_type'); ?> </li>
				<!-- PART I -->
				<?php

				// set active sidebar menu expanded by default
				$partId = $this->getRequest()->getSession()->read('partId');
				$formId = $this->getRequest()->getSession()->read('formId');

				if (in_array($curAction, array('mine', 'nameAddress', 'rent', 'workingDetail', 'dailyAverage'))) {
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
							<?php if ($curAction == 'mine') {
								$activeStat = ' active_menu';
							} else {
								$activeStat = '';
							} ?>
							<?php echo $this->Html->link('Details of the Mine', '/monthly/mine', array('class' => 'u_menu_' . $_SESSION["secStatus"]["mine"] . $activeStat));
							$sec_link['part_' . $linkPart][] = "/monthly/mine"; ?>
						</li>
						<li>
							<?php if ($curAction == 'nameAddress') {
								$activeStat = ' active_menu';
							} else {
								$activeStat = '';
							} ?>
							<?php echo $this->Html->link('Name and Address', '/monthly/name_address', array('class' => 'u_menu_' . $_SESSION["secStatus"]["name_address"] . $activeStat));
							$sec_link['part_' . $linkPart][] = "/monthly/name_address"; ?>
						</li>
						<li>
							<?php if ($curAction == 'rent') {
								$activeStat = ' active_menu';
							} else {
								$activeStat = '';
							} ?>
							<?php echo $this->Html->link('Details of Rent/Royalty', '/monthly/rent', array('class' => 'u_menu_' . $_SESSION["secStatus"]["rent"] . $activeStat));
							$sec_link['part_' . $linkPart][] = "/monthly/rent"; ?>
						</li>
						<li>
							<?php if ($curAction == 'workingDetail') {
								$activeStat = ' active_menu';
							} else {
								$activeStat = '';
							} ?>
							<?php echo $this->Html->link('Details on working', '/monthly/working_detail', array('class' => 'u_menu_' . $_SESSION["secStatus"]["working_detail"] . $activeStat));
							$sec_link['part_' . $linkPart][] = "/monthly/working_detail"; ?>
						</li>
						<li>
							<?php if ($curAction == 'dailyAverage') {
								$activeStat = ' active_menu';
							} else {
								$activeStat = '';
							} ?>
							<?php echo $this->Html->link('Average Daily Employment', '/monthly/daily_average', array('class' => 'u_menu_' . $_SESSION["secStatus"]["daily_average"] . $activeStat));
							$sec_link['part_' . $linkPart][] = "/monthly/daily_average"; ?>
						</li>
					</ul>
				</li>
				<!--PART II FOR PRIMARY MINERAL-->
				<?php

				$title = "Part II For ";
				$title .= ucwords(strtolower($partIIM1[0]));
				$mineral = $partIIM1[0];
				$ironSubMin = '';
				if (strtolower($partIIM1[0]) == strtolower('Iron Ore')) {
					if ($is_hematite) {
						$title .= ' (HEMATITE)';
						$mineral .= ' (HEMATITE)';
						$ironSubMin = "/hematite";
					} elseif ($is_magnetite) {
						$title .= ' (MAGNETITE)';
						$mineral .= ' (MAGNETITE)';
						$ironSubMin = "/magnetite";
					}
				}

				// set active sidebar menu expanded by default
				if ($mineral == $mineralParam) {
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
					<?php if ($partIIM1['formNo'] == 5) { ?>
						<ul class="mm-collapse <?php echo $partIdII[2]; ?>">
							<li>
								<?php if ($curAction == 'romStocksOre' && $mineral == $mineralParam) {
									$activeStat = ' active_menu';
								} else {
									$activeStat = '';
								} ?>
								<?php //if($formId == 'F11') { $activeStat = ' active_menu'; } else { $activeStat = ''; } 
								?>
								<?php echo $this->Html->link('Production / Stocks (ROM)', '/monthly/rom_stocks_ore/' . $mineral . $ironSubMin, array('class' => 'u_menu_error' . $activeStat));
								$sec_link['part_' . $linkPart][] = "/monthly/rom_stocks_ore/" . $mineral . $ironSubMin; ?>
							</li>
							<li>
								<?php if ($curAction == 'exMine' && $mineral == $mineralParam) {
									$activeStat = ' active_menu';
								} else {
									$activeStat = '';
								} ?>
								<?php //if($formId == 'F12') { $activeStat = ' active_menu'; } else { $activeStat = ''; } 
								?>
								<?php echo $this->Html->link('Ex-mine price', '/monthly/ex_mine/' . $mineral . $ironSubMin, array('class' => 'u_menu_error' . $activeStat));
								$sec_link['part_' . $linkPart][] = "/monthly/ex_mine/" . $mineral . $ironSubMin; ?>
							</li>
							<li>
								<?php if ($formId == 'F13') {
									$activeStat = ' active_menu';
								} else {
									$activeStat = '';
								} ?>
								<?php echo $this->Html->link('Recoveries at Concentrator', '/monthly/activeForm/P2/F13/' . $mineral, array('class' => 'u_menu_error' . $activeStat));
								$sec_link['part_' . $linkPart][] = "/monthly/activeForm/P2/F13/" . $mineral; ?>
							</li>
							<li>
								<?php if ($formId == 'F14') {
									$activeStat = ' active_menu';
								} else {
									$activeStat = '';
								} ?>
								<?php echo $this->Html->link('Recovery at the Smelter', '/monthly/activeForm/P2/F14/' . $mineral, array('class' => 'u_menu_error' . $activeStat));
								$sec_link['part_' . $linkPart][] = "/monthly/activeForm/P2/F14/" . $mineral; ?>
							</li>
							<li>
								<?php if ($formId == 'F15') {
									$activeStat = ' active_menu';
								} else {
									$activeStat = '';
								} ?>
								<?php echo $this->Html->link('Sales(Metals/By product)', '/monthly/activeForm/P2/F15/' . $mineral, array('class' => 'u_menu_error' . $activeStat));
								$sec_link['part_' . $linkPart][] = "/monthly/activeForm/P2/F15"; ?>
							</li>
							<li>
								<?php if ($formId == 'F16') {
									$activeStat = ' active_menu';
								} else {
									$activeStat = '';
								} ?>
								<?php echo $this->Html->link('Details of Deductions', '/monthly/activeForm/P2/F16/' . $mineral, array('class' => 'u_menu_error' . $activeStat));
								$sec_link['part_' . $linkPart][] = "/monthly/activeForm/P2/F16/" . $mineral; ?>
							</li>
							<li>
								<?php if ($formId == 'F17') {
									$activeStat = ' active_menu';
								} else {
									$activeStat = '';
								} ?>
								<?php echo $this->Html->link('Sales/Dispatches', '/monthly/activeForm/P2/F17/' . $mineral, array('class' => 'u_menu_error' . $activeStat));
								$sec_link['part_' . $linkPart][] = "/monthly/activeForm/P2/F17/" . $mineral; ?>
							</li>
						</ul>
					<?php } elseif ($partIIM1['formNo'] == 7) { ?>
						<ul class="mm-collapse">
							<li>
								<?php if ($curAction == 'romStocksThree' && $mineral == $mineralParam) {
									$activeStat = ' active_menu';
								} else {
									$activeStat = '';
								} ?>
								<?php //if($formId == 'F21') { $activeStat = ' active_menu'; } else { $activeStat = ''; } 
								?>
								<?php echo $this->Html->link('Production / Stocks (ROM)', '/monthly/rom_stocks_three/' . $mineral . $ironSubMin, array('class' => 'u_menu_error' . $activeStat));
								$sec_link['part_' . $linkPart][] = "/monthly/rom_stocks_three/" . $mineral . $ironSubMin; ?>
							</li>
							<li>
								<?php if ($curAction == 'romStocksThree' && $mineral == $mineralParam) {
									$activeStat = ' active_menu';
								} else {
									$activeStat = '';
								} ?>
								<?php //if($formId == 'F22') { $activeStat = ' active_menu'; } else { $activeStat = ''; } 
								?>
								<?php echo $this->Html->link('Production, Despatches and Stocks', '/monthly/prod_stock_dis/' . $mineral . $ironSubMin, array('class' => 'u_menu_error' . $activeStat));
								$sec_link['part_' . $linkPart][] = "/monthly/prod_stock_dis/" . $mineral . $ironSubMin; ?>
							</li>
							<li>
								<?php if ($curAction == 'romStocksThree' && $mineral == $mineralParam) {
									$activeStat = ' active_menu';
								} else {
									$activeStat = '';
								} ?>
								<?php //if($formId == 'F23') { $activeStat = ' active_menu'; } else { $activeStat = ''; } 
								?>
								<?php echo $this->Html->link('Details of Deductions', '/monthly/deduct_detail/' . $mineral . $ironSubMin, array('class' => 'u_menu_error' . $activeStat));
								$sec_link['part_' . $linkPart][] = "/monthly/deduct_detail/" . $mineral . $ironSubMin; ?>
							</li>
							<li>
								<?php if ($curAction == 'romStocksThree' && $mineral == $mineralParam) {
									$activeStat = ' active_menu';
								} else {
									$activeStat = '';
								} ?>
								<?php //if($formId == 'F24') { $activeStat = ' active_menu'; } else { $activeStat = ''; } 
								?>
								<?php echo $this->Html->link('Sales/Dispatches', '/monthly/sale_despatch/' . $mineral . $ironSubMin, array('class' => 'u_menu_error' . $activeStat));
								$sec_link['part_' . $linkPart][] = "/monthly/sale_despatch/" . $mineral . $ironSubMin; ?>
							</li>
						</ul>
					<?php } else { ?>
						<ul class="mm-collapse">
							<?php if (strtolower($partIIM1[0]) == strtolower('Iron Ore')) { ?>
								<li>
									<?php if ($formId == 'F31') {
										$activeStat = ' active_menu';
									} else {
										$activeStat = '';
									} ?>
									<?php echo $this->Html->link('Type of ore', '/monthly/activeForm/P2/F31/' . $mineral, array('class' => 'u_menu_error' . $activeStat));
									$sec_link['part_' . $linkPart][] = "/monthly/activeForm/P2/F31/" . $mineral; ?>
								</li>
							<?php } ?>
							<li>
								<?php if ($curAction == 'romStocks' && $mineral == $mineralParam) {
									$activeStat = ' active_menu';
								} else {
									$activeStat = '';
								} ?>
								<?php //if($formId == 'F32') { $activeStat = ' active_menu'; } else { $activeStat = ''; } 
								?>
								<?php echo $this->Html->link('Production / Stocks (ROM)', '/monthly/rom_stocks/' . $mineral . $ironSubMin, array('class' => 'u_menu_' . $_SESSION["secStatus"]["rom_stocks"][strtolower($mineral)] . $activeStat));
								$sec_link['part_' . $linkPart][] = "/monthly/rom_stocks/" . $mineral . $ironSubMin; ?>
							</li>
							<li>
								<?php if ($curAction == 'gradewiseProd' && $mineral == $mineralParam) {
									$activeStat = ' active_menu';
								} else {
									$activeStat = '';
								} ?>
								<?php //if($formId == 'F33') { $activeStat = ' active_menu'; } else { $activeStat = ''; } 
								?>
								<?php echo $this->Html->link('Grade-wise Production', '/monthly/gradewise_prod/' . $mineral . $ironSubMin, array('class' => 'u_menu_' . $_SESSION["secStatus"]["gradewise_prod"][strtolower($mineral)] . $activeStat));
								$sec_link['part_' . $linkPart][] = "/monthly/gradewise_prod/" . $mineral . $ironSubMin; ?>
							</li>
							<?php if ($partIIM1['formNo'] == 8) { ?>
								<li>
									<?php if ($curAction == 'pulverisation' && $mineral == $mineralParam) {
										$activeStat = ' active_menu';
									} else {
										$activeStat = '';
									} ?>
									<?php //if($formId == 'F34') { $activeStat = ' active_menu'; } else { $activeStat = ''; } 
									?>
									<?php echo $this->Html->link('Pulverisation', '/monthly/pulverisation/' . $mineral . $ironSubMin, array('class' => 'u_menu_' . $_SESSION["secStatus"]["pulverisation"][strtolower($mineral)] . $activeStat));
									$sec_link['part_' . $linkPart][] = "/monthly/pulverisation/" . $mineral . $ironSubMin; ?>
								</li>
							<?php } ?>
							<li>
								<?php if ($curAction == 'deductDetail' && $mineral == $mineralParam) {
									$activeStat = ' active_menu';
								} else {
									$activeStat = '';
								} ?>
								<?php //if($formId == 'F35') { $activeStat = ' active_menu'; } else { $activeStat = ''; } 
								?>
								<?php echo $this->Html->link('Details of Deductions', '/monthly/deduct_detail/' . $mineral . $ironSubMin, array('class' => 'u_menu_' . $_SESSION["secStatus"]["deduct_detail"][strtolower($mineral)] . $activeStat));
								$sec_link['part_' . $linkPart][] = "/monthly/deduct_detail/" . $mineral . $ironSubMin; ?>
							</li>
							<li>
								<?php if ($curAction == 'saleDespatch' && $mineral == $mineralParam) {
									$activeStat = ' active_menu';
								} else {
									$activeStat = '';
								} ?>
								<?php //if($formId == 'F36') { $activeStat = ' active_menu'; } else { $activeStat = ''; } 
								?>
								<?php echo $this->Html->link('Sales/Dispatches', '/monthly/sale_despatch/' . $mineral . $ironSubMin, array('class' => 'u_menu_' . $_SESSION["secStatus"]["sale_despatch"][strtolower($mineral)] . $activeStat));
								$sec_link['part_' . $linkPart][] = "/monthly/sale_despatch/" . $mineral . $ironSubMin; ?>
							</li>
						</ul>
					<?php } ?>
				</li>

				<!--Only for Magnetite if iron ore is the primary mineral-->
				<?php
				// set active sidebar menu expanded by default
				if ($partId == 'P3') {
					$partIdIII = ['mm-active', 'true', 'mm-show'];
				} else {
					$partIdIII = ['', 'false', ''];
				}
				?>
				<?php if ($is_hematite && $is_magnetite && strtolower($partIIM1[0]) == strtolower('Iron Ore')) { ?>
					<li class="app-sidebar__heading <?php echo $partIdIII[0]; ?>">
						<a href="#" class="u-li-menu menu_sec_3" aria-expanded="<?php echo $partIdIII[1]; ?>">
							<i class="metismenu-icon pe-7s-plugin"></i>
							<?php
							$title = "Part II For ";
							$title .= ucwords(strtolower($partIIM1[0]));
							$title .= ' (MAGNETITE)';
							$mineral .= ' (MAGNETITE)';
							echo $title;
							?>
							<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
						</a>

						<?php $linkPart++; ?>

						<ul class="mm-collapse <?php echo $partIdIII[2]; ?>">
							<li>
								<?php if ($formId == 'F41') {
									$activeStat = ' active_menu';
								} else {
									$activeStat = '';
								} ?>
								<?php echo $this->Html->link('Production / Stocks (ROM)', '/monthly/activeForm/P3/F41/' . $mineral, array('class' => 'u_menu_error' . $activeStat));
								$sec_link['part_' . $linkPart][] = "/monthly/activeForm/P3/F41/" . $mineral; ?>
							</li>
							<li>
								<?php if ($formId == 'F42') {
									$activeStat = ' active_menu';
								} else {
									$activeStat = '';
								} ?>
								<?php echo $this->Html->link('Grade-wise Production', '/monthly/activeForm/P3/F42/' . $mineral, array('class' => 'u_menu_error' . $activeStat));
								$sec_link['part_' . $linkPart][] = "/monthly/activeForm/P3/F42/" . $mineral; ?>
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
					$title .= ucwords(strtolower($partIIM[0]));
					$mineral = $partIIM[0];
					$ironSubMin = '';
					if (strtolower($partIIM[0]) == strtolower('Iron Ore')) {
						if ($is_hematite) {
							$title .= ' (HEMATITE)';
							$mineral .= ' (HEMATITE)';
							$ironSubMin = "/hematite";
						} elseif ($is_magnetite) {
							$title .= ' (MAGNETITE)';
							$mineral .= ' (MAGNETITE)';
							$ironSubMin = "/magnetite";
						}
					}

					// set active sidebar menu expanded by default
					if ($mineral == $mineralParam) {
						$partIdIV = ['mm-active', 'true', 'mm-show'];
					} else {
						$partIdIV = ['', 'false', ''];
					}
				?>

					<li class="app-sidebar__heading <?php echo $partIdIV[0]; ?>">
						<a href="#" class="u-li-menu menu_sec_4" aria-expanded="<?php echo $partIdIV[1]; ?>">
							<i class="metismenu-icon pe-7s-plugin"></i>
							<?php echo $title; ?>
							<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
						</a>

						<?php $linkPart++; ?>

						<!--For associated minerals-->
						<?php if ($partIIM['formNo'] == 5) { ?>
							<ul class="mm-collapse <?php echo $partIdIV[2]; ?>">
								<li>
									<?php if ($formId == 'F51') {
										$activeStat = ' active_menu';
									} else {
										$activeStat = '';
									} ?>
									<?php echo $this->Html->link('Production / Stocks (ROM)', '/monthly/activeForm/P' . $mCount . '/F51/' . $mineral, array('class' => 'u_menu_error' . $activeStat));
									$sec_link['part_' . $linkPart][] = '/monthly/activeForm/P' . $mCount . '/F51/' . $mineral; ?>
								</li>
								<li>
									<?php if ($formId == 'F52') {
										$activeStat = ' active_menu';
									} else {
										$activeStat = '';
									} ?>
									<?php echo $this->Html->link('Ex-mine price', '/monthly/activeForm/P' . $mCount . '/F52/' . $mineral, array('class' => 'u_menu_error' . $activeStat));
									$sec_link['part_' . $linkPart][] = '/monthly/activeForm/P' . $mCount . '/F52/' . $mineral; ?>
								</li>
								<li>
									<?php if ($formId == 'F53') {
										$activeStat = ' active_menu';
									} else {
										$activeStat = '';
									} ?>
									<?php echo $this->Html->link('Recoveries at Concentrator', '/monthly/activeForm/P' . $mCount . '/F53/' . $mineral, array('class' => 'u_menu_error' . $activeStat));
									$sec_link['part_' . $linkPart][] = '/monthly/activeForm/P' . $mCount . '/F53/' . $mineral; ?>
								</li>
								<li>
									<?php if ($formId == 'F54') {
										$activeStat = ' active_menu';
									} else {
										$activeStat = '';
									} ?>
									<?php echo $this->Html->link('Recovery at the Smelter', '/monthly/activeForm/P' . $mCount . '/F54/' . $mineral, array('class' => 'u_menu_error' . $activeStat));
									$sec_link['part_' . $linkPart][] = '/monthly/activeForm/P' . $mCount . '/F54/' . $mineral; ?>
								</li>
								<li>
									<?php if ($formId == 'F55') {
										$activeStat = ' active_menu';
									} else {
										$activeStat = '';
									} ?>
									<?php echo $this->Html->link('Sales(Metals/By product)', '/monthly/activeForm/P' . $mCount . '/F55/' . $mineral, array('class' => 'u_menu_error' . $activeStat));
									$sec_link['part_' . $linkPart][] = '/monthly/activeForm/P' . $mCount . '/F55/' . $mineral; ?>
								</li>
								<li>
									<?php if ($formId == 'F56') {
										$activeStat = ' active_menu';
									} else {
										$activeStat = '';
									} ?>
									<?php echo $this->Html->link('Details of Deductions', '/monthly/activeForm/P' . $mCount . '/F56/' . $mineral, array('class' => 'u_menu_error' . $activeStat));
									$sec_link['part_' . $linkPart][] = '/monthly/activeForm/P' . $mCount . '/F56/' . $mineral; ?>
								</li>
								<li>
									<?php if ($formId == 'F57') {
										$activeStat = ' active_menu';
									} else {
										$activeStat = '';
									} ?>
									<?php echo $this->Html->link('Sales/Dispatches', '/monthly/activeForm/P' . $mCount . '/F57/' . $mineral, array('class' => 'u_menu_error' . $activeStat));
									$sec_link['part_' . $linkPart][] = '/monthly/activeForm/P' . $mCount . '/F57/' . $mineral; ?>
								</li>
							</ul>
						<?php } elseif ($partIIM['formNo'] == 7) { ?>
							<ul class="mm-collapse <?php echo $partIdIV[2]; ?>">
								<li>
									<?php if ($formId == 'F61') {
										$activeStat = ' active_menu';
									} else {
										$activeStat = '';
									} ?>
									<?php echo $this->Html->link('Production / Stocks (ROM)', '/monthly/activeForm/P' . $mCount . '/F61/' . $mineral, array('class' => 'u_menu_error' . $activeStat));
									$sec_link['part_' . $linkPart][] = '/monthly/activeForm/P' . $mCount . '/F61/' . $mineral; ?>
								</li>
								<li>
									<?php if ($formId == 'F62') {
										$activeStat = ' active_menu';
									} else {
										$activeStat = '';
									} ?>
									<?php echo $this->Html->link('Production, Despatches and Stocks', '/monthly/activeForm/P' . $mCount . '/F62/' . $mineral, array('class' => 'u_menu_error' . $activeStat));
									$sec_link['part_' . $linkPart][] = '/monthly/activeForm/P' . $mCount . '/F62/' . $mineral; ?>
								</li>
								<li>
									<?php if ($formId == 'F63') {
										$activeStat = ' active_menu';
									} else {
										$activeStat = '';
									} ?>
									<?php echo $this->Html->link('Details of Deductions', '/monthly/activeForm/P' . $mCount . '/F63/' . $mineral, array('class' => 'u_menu_error' . $activeStat));
									$sec_link['part_' . $linkPart][] = '/monthly/activeForm/P' . $mCount . '/F63/' . $mineral; ?>
								</li>
								<li>
									<?php if ($formId == 'F64') {
										$activeStat = ' active_menu';
									} else {
										$activeStat = '';
									} ?>
									<?php echo $this->Html->link('Sales/Dispatches', '/monthly/activeForm/P' . $mCount . '/F64/' . $mineral, array('class' => 'u_menu_error' . $activeStat));
									$sec_link['part_' . $linkPart][] = '/monthly/activeForm/P' . $mCount . '/F64/' . $mineral; ?>
								</li>
							</ul>
						<?php } else { ?>
							<ul class="mm-collapse <?php echo $partIdIV[2]; ?>">
								<?php if (strtolower($partIIM[0]) == strtolower('Iron Ore')) { ?>
									<li>
										<?php if ($formId == 'F71') {
											$activeStat = ' active_menu';
										} else {
											$activeStat = '';
										} ?>
										<?php echo $this->Html->link('Type of ore', '/monthly/activeForm/P' . $mCount . '/F71/' . $mineral, array('class' => 'u_menu_error' . $activeStat));
										$sec_link['part_' . $linkPart][] = '/monthly/activeForm/P' . $mCount . '/F71/' . $mineral; ?>
									</li>
								<?php } ?>
								<li>
									<?php if ($curAction == 'romStocks' && $mineral == $mineralParam) {
										$activeStat = ' active_menu';
									} else {
										$activeStat = '';
									} ?>
									<?php //if($formId == 'F72') { $activeStat = ' active_menu'; } else { $activeStat = ''; } 
									?>
									<?php echo $this->Html->link('Production / Stocks (ROM)', '/monthly/rom_stocks/' . $mineral . $ironSubMin, array('class' => 'u_menu_' . $_SESSION["secStatus"]["rom_stocks"][strtolower($mineral)] . $activeStat));
									$sec_link['part_' . $linkPart][] = '/monthly/rom_stocks/' . $mineral . $ironSubMin; ?>
								</li>
								<li>
									<?php if ($curAction == 'gradewiseProd' && $mineral == $mineralParam) {
										$activeStat = ' active_menu';
									} else {
										$activeStat = '';
									} ?>
									<?php //if($formId == 'F73') { $activeStat = ' active_menu'; } else { $activeStat = ''; } 
									?>
									<?php echo $this->Html->link('Grade-wise Production', '/monthly/gradewise_prod/' . $mineral . $ironSubMin, array('class' => 'u_menu_' . $_SESSION["secStatus"]["gradewise_prod"][strtolower($mineral)] . $activeStat));
									$sec_link['part_' . $linkPart][] = '/monthly/gradewise_prod/' . $mineral . $ironSubMin; ?>
								</li>
								<?php if ($partIIM['formNo'] == 8) { ?>
									<li>
										<?php if ($curAction == 'pulverisation' && $mineral == $mineralParam) {
											$activeStat = ' active_menu';
										} else {
											$activeStat = '';
										} ?>
										<?php //if($formId == 'F74') { $activeStat = ' active_menu'; } else { $activeStat = ''; } 
										?>
										<?php echo $this->Html->link('Pulverisation', '/monthly/pulverisation/' . $mineral . $ironSubMin, array('class' => 'u_menu_' . $_SESSION["secStatus"]["pulverisation"][strtolower($mineral)] . $activeStat));
										$sec_link['part_' . $linkPart][] = '/monthly/pulverisation/' . $mineral . $ironSubMin; ?>
									</li>
								<?php } ?>
								<li>
									<?php if ($curAction == 'deductDetail' && $mineral == $mineralParam) {
										$activeStat = ' active_menu';
									} else {
										$activeStat = '';
									} ?>
									<?php //if($formId == 'F75') { $activeStat = ' active_menu'; } else { $activeStat = ''; } 
									?>
									<?php echo $this->Html->link('Details of Deductions', '/monthly/deduct_detail/' . $mineral . $ironSubMin, array('class' => 'u_menu_' . $_SESSION["secStatus"]["deduct_detail"][strtolower($mineral)] . $activeStat));
									$sec_link['part_' . $linkPart][] = '/monthly/deduct_detail/' . $mineral . $ironSubMin; ?>
								</li>
								<li>
									<?php if ($curAction == 'saleDespatch' && $mineral == $mineralParam) {
										$activeStat = ' active_menu';
									} else {
										$activeStat = '';
									} ?>
									<?php //if($formId == 'F76') { $activeStat = ' active_menu'; } else { $activeStat = ''; } 
									?>
									<?php echo $this->Html->link('Sales/Dispatches', '/monthly/sale_despatch/' . $mineral . $ironSubMin, array('class' => 'u_menu_' . $_SESSION["secStatus"]["sale_despatch"][strtolower($mineral)] . $activeStat));
									$sec_link['part_' . $linkPart][] = '/monthly/sale_despatch/' . $mineral . $ironSubMin; ?>
								</li>
							</ul>
						<?php } ?>
					</li>

				<?php $mCount++;
				} ?>
				<?php
				foreach ($partIIMOther as $partIIM) { ?>

					<!--Only for Magnetite if iron ore is the associative mineral-->
					<?php if ($is_hematite && $is_magnetite && strtolower($partIIM[0]) == strtolower('Iron Ore')) { ?>
						<?php
						// set active sidebar menu expanded by default
						if ($partId == 'P' . $mCount) {
							$partIdV = ['mm-active', 'true', 'mm-show'];
						} else {
							$partIdV = ['', 'false', ''];
						}
						?>
						<li class="app-sidebar__heading <?php echo $partIdV[0]; ?>">
							<a href="#" class="u-li-menu menu_sec_5" aria-expanded="<?php echo $partIdV[1]; ?>">
								<i class="metismenu-icon pe-7s-plugin"></i>
								<?php
								$title = "Part II For ";
								$title .= ucwords(strtolower($partIIM[0]));
								$mineral = $partIIM[0];
								$title .= ' (MAGNETITE)';
								$mineral .= ' (MAGNETITE)';
								echo $title;
								?>
								<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
							</a>

							<?php $linkPart++; ?>

							<ul class="mm-collapse <?php echo $partIdV[2]; ?>">
								<li>
									<?php if ($formId == 'F81') {
										$activeStat = ' active_menu';
									} else {
										$activeStat = '';
									} ?>
									<?php echo $this->Html->link('Production / Stocks (ROM)', '/monthly/activeForm/P' . $mCount . '/F81/' . $mineral, array('class' => 'u_menu_error' . $activeStat));
									$sec_link['part_' . $linkPart][] = '/monthly/activeForm/P' . $mCount . '/F81/' . $mineral; ?>
								</li>
								<li>
									<?php if ($formId == 'F82') {
										$activeStat = ' active_menu';
									} else {
										$activeStat = '';
									} ?>
									<?php echo $this->Html->link('Grade-wise Production', '/monthly/activeForm/P' . $mCount . '/F82/' . $mineral, array('class' => 'u_menu_error' . $activeStat));
									$sec_link['part_' . $linkPart][] = '/monthly/activeForm/P' . $mCount . '/F82/' . $mineral; ?>
								</li>
							</ul>
						</li>
					<?php $mCount++;
					} ?>

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
				<li class="app-sidebar__heading <?php //echo $partIdVI[0]; 
												?>">
					<a href="#" class="u-li-menu" aria-expanded="<?php //echo $partIdVI[1]; 
																	?>">
						<i class="metismenu-icon pe-7s-user"></i>
						Profile
						<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
					</a>
					<ul class="mm-collapse <?php //echo $partIdVI[2]; 
											?>">
						<li>
							<?php //if($formId == 'F91') { $activeStat = ' active_menu'; } else { $activeStat = ''; } 
							?>
							<?php //echo $this->Html->link('My Profile', '/monthly/activeForm/P'.$mCount.'/F91', array('class'=>'u_menu_error'.$activeStat)); $fLink[] = '/monthly/activeForm/P'.$mCount.'/F91'; 
							?>
						</li>
					</ul>
				</li> -->

			<?php } else { ?>

				<?php if (in_array($_SESSION['mms_user_role'], array('1'))) { ?>
					<li class="app-sidebar__heading">
						<a href= "<?php echo $this->getRequest()->getAttribute('webroot'); ?>masters/index" class="u-li-menu" aria-expanded="false">
							<i class="metismenu-icon pe-7s-copy-file"></i>
							Manage Master Forms
						</a>
					</li>
				<?php } ?>

				<!-- As per IBM suggestion only ME division supervisor and primary user can't scrutinized the Form F and G Done by Pravin Bhakare 10-01-2022 -->

				<?php if (!in_array($_SESSION['mms_user_role'], array('8', '9'))) { ?>

					<li class="app-sidebar__heading">
						<a href="#" class="u-li-menu" aria-expanded="false">
							<i class="metismenu-icon pe-7s-note2"></i>
							Monthly Returns (F)
							<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
						</a>
						<ul class="mm-collapse" style="height: 6.4px;">
							<li>
								<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/monthly/f/s">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Received (<?php echo $_SESSION['submitted']; ?>)
								</a>
							</li>
							<li>
								<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/monthly/f/p">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Pending (<?php echo $_SESSION['pending']; ?>)
								</a>
							</li>
							<li>
								<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/monthly/f/r">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Referred Back (<?php echo $_SESSION['referred']; ?>)
								</a>
							</li>
							<li>
								<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/monthly/f/a">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Accepted (<?php echo $_SESSION['approved']; ?>)
								</a>
							</li>
							<!-- Added by Shweta Apale on 31-01-2022 For RO Only -->
							<?php if ($_SESSION['mms_user_role'] == 6) { ?>
								<li>
									<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/violation/monthly">
										<i class="metismenu-icon pe-7s-diamond"></i>
										Violation Notice List
									</a>
								</li>

								<!-- Added by Shweta Apale on 03-03-2022  For RO Only-->
								<li>
									<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/violationserve/monthly">
										<i class="metismenu-icon pe-7s-diamond"></i>
										Violation Notice Sent
									</a>
								</li>

								<li>
									<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/violationpending/monthly">
										<i class="metismenu-icon pe-7s-diamond"></i>
										Violation Notice Pending
									</a>
								</li>
							<?php } ?>
							<!--<li>
							<a href="#">
								<i class="metismenu-icon pe-7s-diamond"></i>
								More..
								<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
							</a>
							<ul class="mm-collapse">
								<li>
									<a href="#">
										<i class="metismenu-icon"></i>
										All India Wise
									</a>
								</li>
								<li>
									<a href="#">
										<i class="metismenu-icon"></i>
										ZO Wise
									</a>
								</li>
								<li>
									<a href="#">
										<i class="metismenu-icon"></i>
										RO Wise
									</a>
								</li>
								<li>
									<a href="#">
										<i class="metismenu-icon"></i>
										Supervisor Wise
									</a>
								</li>
								<li>
									<a href="#">
										<i class="metismenu-icon"></i>
										Mine Wise
									</a>
								</li>
								<li>
									<a href="#">
										<i class="metismenu-icon"></i>
										Primary User Wise
									</a>
								</li>
							</ul>
						</li>-->

						</ul>
					</li>
					<li class="app-sidebar__heading">
						<a href="#" class="u-li-menu" aria-expanded="false">
							<i class="metismenu-icon pe-7s-display1"></i>
							Annual Returns (G)
							<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
						</a>
						<ul class="mm-collapse">
							<li>
								<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/annual/g/s">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Received (<?php echo $_SESSION['submittedAnnual']; ?>)
								</a>
							</li>
							<li>
								<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/annual/g/p">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Pending for Scrutiny (<?php echo $_SESSION['pendingAnnual']; ?>)
								</a>
							</li>
							<li>
								<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/annual/g/r">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Referred back (<?php echo $_SESSION['referredAnnual']; ?>)
								</a>
							</li>
							<li>
								<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/annual/g/a">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Accepted (<?php echo $_SESSION['approvedAnnual']; ?>)
								</a>
							</li>
							<!-- Added by Shweta Apale on 04-02-2022  For RO Only -->
							<?php if ($_SESSION['mms_user_role'] == 6) { ?>
								<li>
									<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/violation/annual">
										<i class="metismenu-icon pe-7s-diamond"></i>
										Violation Notice List
									</a>
								</li>

								<!-- Added by Shweta Apale on 03-03-2022  For RO Only-->
								<li>
									<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/violationserve/annual">
										<i class="metismenu-icon pe-7s-diamond"></i>
										Violation Notice Sent
									</a>
								</li>

								<li>
									<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/violationpending/annual">
										<i class="metismenu-icon pe-7s-diamond"></i>
										Violation Notice Pending
									</a>
								</li>
							<?php } ?>
							<!--<li>
							<a href="#">
								<i class="metismenu-icon pe-7s-diamond"></i>
								More..
								<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
							</a>
							<ul class="mm-collapse">
								<li>
									<a href="#">
										<i class="metismenu-icon"></i>
										All India Wise
									</a>
								</li>
								<li>
									<a href="#">
										<i class="metismenu-icon"></i>
										ZO Wise
									</a>
								</li>
								<li>
									<a href="#">
										<i class="metismenu-icon"></i>
										RO Wise
									</a>
								</li>
								<li>
									<a href="#">
										<i class="metismenu-icon"></i>
										Supervisor Wise
									</a>
								</li>
								<li>
									<a href="#">
										<i class="metismenu-icon"></i>
										Mine Wise
									</a>
								</li>
								<li>
									<a href="#">
										<i class="metismenu-icon"></i>
										Primary User Wise
									</a>
								</li>
							</ul>
						</li>-->
						</ul>
					</li>
				<?php } ?>

				<!-- As per IBM suggestion only ME division supervisor and primary user scrutinized the Form
				L and M Done by Pravin Bhakare 10-01-2022 -->

				<?php //if(in_array($_SESSION['mms_user_role'],array('8','9'))){ 
				?>
				<?php if (!in_array($_SESSION['mms_user_role'], array('2', '3'))) { ?>
					<li class="app-sidebar__heading">
						<a href="#" class="u-li-menu" aria-expanded="false">
							<i class="metismenu-icon pe-7s-date"></i>
							Monthly Returns (L)
							<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
						</a>
						<ul class="mm-collapse">
							<li>
								<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/monthly/m/s">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Received (<?php echo $_SESSION['endUserSubmitted']; ?>)
								</a>
							</li>
							<li>
								<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/monthly/m/p">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Pending (<?php echo $_SESSION['endUserPending']; ?>)
								</a>
							</li>
							<li>
								<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/monthly/m/r">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Referred back (<?php echo $_SESSION['endUserReferred']; ?>)
								</a>
							</li>
							<li>
								<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/monthly/m/a">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Accepted (<?php echo $_SESSION['endUserApproved']; ?>)
								</a>
							</li>
							<!-- Added by Shweta Apale on 04-02-2022  For RO Only-->
							<?php if ($_SESSION['mms_user_role'] == 6) { ?>
								<li>
									<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/violationlm/monthly/m">
										<i class="metismenu-icon pe-7s-diamond"></i>
										Violation Notice List
									</a>
								</li>

								<!-- Added by Shweta Apale on 03-03-2022  For RO Only-->
								<li>
									<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/violationservelm/monthly/m">
										<i class="metismenu-icon pe-7s-diamond"></i>
										Violation Notice Sent
									</a>
								</li>

								<li>
									<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/violationlmpending/monthly/m">
										<i class="metismenu-icon pe-7s-diamond"></i>
										Violation Notice Pending
									</a>
								</li>
								
							<?php } ?>
							<!--<li>
							<a href="#">
								<i class="metismenu-icon pe-7s-diamond"></i>
								More..
								<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
							</a>
							<ul class="mm-collapse">
								<li>
									<a href="#">
										<i class="metismenu-icon"></i>
										All India Wise
									</a>
								</li>
								<li>
									<a href="#">
										<i class="metismenu-icon"></i>
										ZO Wise
									</a>
								</li>
								<li>
									<a href="#">
										<i class="metismenu-icon"></i>
										RO Wise
									</a>
								</li>
								<li>
									<a href="#">
										<i class="metismenu-icon"></i>
										Supervisor Wise
									</a>
								</li>
								<li>
									<a href="#">
										<i class="metismenu-icon"></i>
										Primary User Wise
									</a>
								</li>
							</ul>
						</li>-->
						</ul>
					</li>
				<?php } ?>

				<?php if (!in_array($_SESSION['mms_user_role'], array('2', '3'))) { ?>
					<?php //if(in_array($_SESSION['mms_user_role'],array('8','9'))){ 
					?>
					<li class="app-sidebar__heading">
						<a href="#" class="u-li-menu" aria-expanded="false">
							<i class="metismenu-icon pe-7s-id"></i>
							Annual Returns (M)
							<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
						</a>
						<ul class="mm-collapse">
							<li>
								<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/annual/l/s">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Received (<?php echo $_SESSION['endUserSubmittedAnnual']; ?>)
								</a>
							</li>
							<li>
								<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/annual/l/p">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Pending (<?php echo $_SESSION['endUserPendingAnnual']; ?>)
								</a>
							</li>
							<li>
								<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/annual/l/r">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Referred back (<?php echo $_SESSION['endUserReferredAnnual']; ?>)
								</a>
							</li>
							<li>
								<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/annual/l/a">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Accepted (<?php echo $_SESSION['endUserApprovedAnnual']; ?>)
								</a>
							</li>
							<!-- Added by Shweta Apale on 05-02-2022  For RO Only-->
							<?php if ($_SESSION['mms_user_role'] == 6) { ?>
								<li>
									<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/violationlm/annual/l">
										<i class="metismenu-icon pe-7s-diamond"></i>
										Violation Notice List
									</a>
								</li>
								<!-- Added by Shweta Apale on 03-03-2022  For RO Only-->
								<li>
									<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/violationservelm/annual/l">
										<i class="metismenu-icon pe-7s-diamond"></i>
										Violation Notice Sent
									</a>
								</li>

								<li>
									<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/violationlmpending/annual/l">
										<i class="metismenu-icon pe-7s-diamond"></i>
										Violation Notice Pending
									</a>
								</li>
							<?php } ?>
							<!--<li>
							<a href="#">
								<i class="metismenu-icon pe-7s-diamond"></i>
								More..
								<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
							</a>
							<ul class="mm-collapse">
								<li>
									<a href="#">
										<i class="metismenu-icon"></i>
										All India Wise
									</a>
								</li>
								<li>
									<a href="#">
										<i class="metismenu-icon"></i>
										ZO Wise
									</a>
								</li>
								<li>
									<a href="#">
										<i class="metismenu-icon"></i>
										RO Wise
									</a>
								</li>
								<li>
									<a href="#">
										<i class="metismenu-icon"></i>
										Supervisor Wise
									</a>
								</li>
								<li>
									<a href="#">
										<i class="metismenu-icon"></i>
										Primary User Wise
									</a>
								</li>
							</ul>
						</li>-->
						</ul>
					</li>
				<?php } ?>
				<!-- mms old returns added by Shalini D -->
				<?php //if (!in_array($_SESSION['mms_user_role'], array('8', '9'))) { 
				?>
				<!--<li class="app-sidebar__heading">
					<a href="#" class="u-li-menu" aria-expanded="false">
						<i class="metismenu-icon pe-7s-id"></i>
						Old Returns
						<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
					</a>
					<ul class="mm-collapse">
						<?php if (!in_array($_SESSION['mms_user_role'], array('8', '9'))) { ?>
							<li>
								<a href="#">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Monthly Old Returns (F)
									<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
								</a>
								<ul class="mm-collapse">
									<li>
										<a href="<?php echo $this->request->getAttribute('webroot'); ?>mms/returns/monthly/f/s/oldreturns">
											<i class="metismenu-icon pe-7s-diamond"></i>
											Received
										</a>
									</li>
									<li>
										<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/monthly/f/p/oldreturns">
											<i class="metismenu-icon pe-7s-diamond"></i>
											Pending
										</a>
									</li>
									<li>
										<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/monthly/f/r/oldreturns">
											<i class="metismenu-icon pe-7s-diamond"></i>
											Referred back
										</a>
									</li>
									<li>
										<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/monthly/f/a/oldreturns">
											<i class="metismenu-icon pe-7s-diamond"></i>
											Accepted
										</a>
									</li>
								</ul>
							</li>
							<li>
								<a href="#">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Annual Old Returns (G)
									<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
								</a>
								<ul class="mm-collapse">
									<li>
										<a href="<?php echo $this->request->getAttribute('webroot'); ?>mms/returns/annual/g/s/oldreturns">
											<i class="metismenu-icon pe-7s-diamond"></i>
											Received
										</a>
									</li>
									<li>
										<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/annual/g/p/oldreturns">
											<i class="metismenu-icon pe-7s-diamond"></i>
											Pending
										</a>
									</li>
									<li>
										<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/annual/g/r/oldreturns">
											<i class="metismenu-icon pe-7s-diamond"></i>
											Referred back
										</a>
									</li>
									<li>
										<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/annual/g/a/oldreturns">
											<i class="metismenu-icon pe-7s-diamond"></i>
											Accepted
										</a>
									</li>
								</ul>
							</li>
						<?php } ?>
						<?php if (!in_array($_SESSION['mms_user_role'], array('2', '3'))) { ?>
							<li>
								<a href="#">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Monthly Old Returns (L)
									<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
								</a>
								<ul class="mm-collapse">
									<li>
										<a href="<?php echo $this->request->getAttribute('webroot'); ?>mms/returns/monthly/m/s/oldreturns">
											<i class="metismenu-icon pe-7s-diamond"></i>
											Received
										</a>
									</li>
									<li>
										<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/monthly/m/p/oldreturns">
											<i class="metismenu-icon pe-7s-diamond"></i>
											Pending
										</a>
									</li>
									<li>
										<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/monthly/m/r/oldreturns">
											<i class="metismenu-icon pe-7s-diamond"></i>
											Referred back
										</a>
									</li>
									<li>
										<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/monthly/m/a/oldreturns">
											<i class="metismenu-icon pe-7s-diamond"></i>
											Accepted
										</a>
									</li>
								</ul>
							</li>
							<li>
								<a href="#">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Annual Old Returns (M)
									<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
								</a>
								<ul class="mm-collapse">
									<li>
										<a href="<?php echo $this->request->getAttribute('webroot'); ?>mms/returns/annual/l/s/oldreturns">
											<i class="metismenu-icon pe-7s-diamond"></i>
											Received
										</a>
									</li>
									<li>
										<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/annual/l/p/oldreturns">
											<i class="metismenu-icon pe-7s-diamond"></i>
											Pending
										</a>
									</li>
									<li>
										<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/annual/l/r/oldreturns">
											<i class="metismenu-icon pe-7s-diamond"></i>
											Referred back
										</a>
									</li>
									<li>
										<a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>mms/returns/annual/l/a/oldreturns">
											<i class="metismenu-icon pe-7s-diamond"></i>
											Accepted
										</a>
									</li>
								</ul>
							</li>-->
						<?php } ?>
					<!--</ul>-->
				<!--</li>-->
				<?php //} 
				?>

				<?php if (in_array($_SESSION['mms_user_role'], array('1', '7'))) { ?>

					<li class="app-sidebar__heading">
						<a href="#" class="u-li-menu" aria-expanded="false">
							<i class="metismenu-icon pe-7s-add-user"></i>
							Allocate Users
							<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
						</a>
						<ul class="mm-collapse">
							<li>
								<a href="<?php echo  $this->request->getAttribute('webroot'); ?>admin/allocation-type/allocate">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Allocate Registered Users
								</a>
							</li>
							<li>
								<a href="<?php echo  $this->request->getAttribute('webroot'); ?>admin/allocation-type/reallocate">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Reallocate Registered Users
								</a>
							</li>
							<!-- Start Add ddo allocation, Pravin Bhakare 07-06-2022 **/ -->
							<li>
								<a href="<?php echo  $this->request->getAttribute('webroot'); ?>admin/ddo-allocation">
									<i class="metismenu-icon"></i>
									DDO Allocation
								</a>
							</li>
						</ul>
					</li>

				<?php } ?>

				<?php if (in_array($_SESSION['mms_user_role'], array('1'))) { ?>
                     <!-- Added by Ankush T on 05/06/2023  -->
				  <li class="app-sidebar__heading">
						<a href="#" class="u-li-menu" aria-expanded="false">
							<i class="metismenu-icon pe-7s-add-user"></i>
							Raised Ticket
							<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
						</a>
						<ul class="mm-collapse">
							<li>
								<a href="<?php echo  $this->request->getAttribute('webroot'); ?>mms/generate-ticket">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Generate Ticket
								</a>
							</li>
							<li>
								<a href="<?php echo  $this->request->getAttribute('webroot'); ?>mms/list-ticket">
									<i class="metismenu-icon pe-7s-diamond"></i>
									All Ticket
								</a>
							</li>
							
						</ul>
					</li>

				 <?php } ?>

				<?php if (in_array('add_user', $_SESSION['user_roles'])) { ?>

					<li class="app-sidebar__heading">
						<a href="<?php echo  $this->request->getAttribute('webroot'); ?>admin/list-users" class="u-li-menu" aria-expanded="false">
							<i class="metismenu-icon pe-7s-users"></i>
							Users
						</a>
					</li>
				<?php } ?>

				<!-- Added by Shalini D on 08/02/2022 For RO Only -->
				<?php if ($_SESSION['mms_user_role'] == 6) { ?>
					<li class="app-sidebar__heading">
						<a href="<?php echo $this->request->getAttribute('webroot'); ?>miningplan/mining-plan-list" class="u-li-menu" aria-expanded="false">
							<i class="metismenu-icon pe-7s-note2"></i>
							Mining Plan
						</a>
					</li>
				<?php } ?>

				<!-- Added by Shalini D on 09/02/2022 For MMS user Only -->
				<?php if (in_array('user_roles', $_SESSION['user_roles'])) { ?>
					<li class="app-sidebar__heading">
						<a href="#" class="u-li-menu" aria-expanded="false">
							<i class="metismenu-icon pe-7s-note2"></i>
							User Roles
							<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
						</a>
						<ul class="mm-collapse">
							<li>
								<a href="<?php echo  $this->request->getAttribute('webroot'); ?>admin/set-roles">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Set Roles
								</a>
							</li>
							<li>
								<a href="<?php echo  $this->request->getAttribute('webroot'); ?>admin/edit-roles">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Edit Roles
								</a>
							</li>
						</ul>
					</li>
				<?php } ?>

				<!-- Added by Shalini D on 09/02/2022 For MMS user Only -->
				<?php if (in_array('cms', $_SESSION['user_roles'])) { ?>
					<li class="app-sidebar__heading">
						<a href="#" class="u-li-menu" aria-expanded="false">
							<i class="metismenu-icon pe-7s-note2"></i>
							CMS
							<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
						</a>
						<ul class="mm-collapse">
							<li>
								<a href="<?php echo  $this->request->getAttribute('webroot'); ?>cms/all_pages">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Pages
								</a>
							</li>
							<li>
								<a href="<?php echo  $this->request->getAttribute('webroot'); ?>cms/all_menus">
									<i class="metismenu-icon pe-7s-diamond"></i>
									Menus
								</a>
							</li>
							<li>
								<a href="<?php echo  $this->request->getAttribute('webroot'); ?>cms/file_uploads">
									<i class="metismenu-icon pe-7s-diamond"></i>
									file Upload
								</a>
							</li>
						</ul>
					</li>


				<?php } ?>

			<?php } ?>

		</ul>
	</div>
</div>

<?php $this->getRequest()->getSession()->write('sec_link', $sec_link); ?>