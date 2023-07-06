
<div class="container">
    <table class="table">
        <thead>
            <tr class="text-center">
                <th>
                    FORM - F<?php echo $this->getRequest()->getSession()->read('mc_form_main'); ?><br><br>
                    For the Month of <?php echo $returnMonth." ".$returnYear; ?><br>
                    <?php echo $returnType; ?> RETURN<br>
                    [ <?php echo $label['mine']['rule']; ?> ]<br>
                    (Read the instructions carefully before filling the particulars)
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td align="left"><span style="margin-left:50px; text-align:left">  <br />

                To,
                <ol type="i">

                    <li>The Regional Controller Of Mines<br />
                        Indian Bureau Of Mines<br />
                        <?php echo ucwords(strtolower($regionName)); ?> Region,<br />
                        <br />
                        PIN: <br />
                        ( Please address to Regional Controller of Mines in whose territorial jurisdiction the mines falls as notified from time to time by the Controller General, Indian Bureau of Mines under Rule 62 of the Mineral Conservation and Development Rules, 1988 )</li><br />

                    <li>The State Government of  <?php echo ucwords(strtolower($mine['state'])); ?></li></ol></span>
                </td>
            </tr>

            <!-- MINE DETAILS -->
            <tr>
                <td align="center">
                    <div id="details_maines" style=" border:0px solid #833b3b; width:900px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0"  >
                            <tr><td>&nbsp;</td></tr>
                            <tr><td align="center"><span style="margin-left:50px"><strong>Part - I</strong></span></td>
                            </tr>
                            <tr><td align="center"><span style="margin-left:50px"><strong>(General and Labour)</strong></span></td>
                            </tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                <td align="left" class="welcome-signout"><span style="margin-left:50px"><?php echo $label['mine']['title']; ?></span></td>
                            </tr>

                            <tr>
                                <td align="center" valign="top"><table width="90%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                        <tr>
                                            <td width="50%" align="left" class="lable-text"><?php echo $label['mine'][0]; ?></td>
                                            <td width="50%" align="left"><?php echo $mine['reg_no']; ?></td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="lable-text"><?php echo $label['mine'][1]; ?></td>
                                            <td align="left"><?php echo $mineCode ?></td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="lable-text"><?php echo $label['mine'][2]; ?></td>
                                            <td align="left"><?php echo $mine['mineral']; ?></td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="lable-text"><?php echo $label['mine'][3]; ?></td>
                                            <td align="left"><?php echo $mine['mine_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="lable-text"><?php echo $label['mine'][4]; ?></td>
                                            <td align="left"><?php echo $mine['other_mineral'] ?></td>
                                        </tr>
                                        <tr>
                                   <td align="left" class="welcome-signout" colspan="2"><span style="margin-left:5px"><?php echo $label['mine'][5]; ?></span></td>
                                        </tr>

                                        <tr>
                                            <td align="left" class="lable-text"><?php echo $label['mine'][6]; ?></td>
                                            <td align="left"><?php echo $mine['village']; ?></td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="lable-text"><?php echo $label['mine'][7]; ?></td>
                                            <td align="left"><?php echo $mine['post_office']; ?></td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="lable-text"><?php echo $label['mine'][8]; ?></td>
                                            <td align="left"><?php echo $mine['taluk']; ?></td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="lable-text"><?php echo $label['mine'][9]; ?></td>
                                            <td align="left"><?php echo $mine['district']; ?></td> 
                                        </tr>
                                        <tr>
                                            <td align="left" class="lable-text"><?php echo $label['mine'][10]; ?> </td>
                                            <td align="left"><?php echo $mine['state']; ?></td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="lable-text"><?php echo $label['mine'][11]; ?></td>
                                            <td align="left"><?php echo $mine['pin']; ?></td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="lable-text"><?php echo $label['mine'][12]; ?></td>
                                            <td align="left"><?php echo $mine['fax']; ?></td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="lable-text"><?php echo $label['mine'][13]; ?></td>
                                            <td align="left"><?php echo $mine['phone']; ?></td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="lable-text"><?php echo $label['mine'][14]; ?></td>
                                            <td align="left"><?php echo $mine['mobile']; ?></td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="lable-text"><?php echo $label['mine'][15]; ?></td>
                                            <td align="left"><?php echo $mine['email']; ?></td>
                                        </tr>
                                    </table>                    </td>
                            </tr>
                            <tr><td>&nbsp;</td></tr>
                        </table>
                    </div>
                </td>
            </tr>
            
            <!-- Name and address details -->
            <tr>
                <td align="center">
                    <div id="name_address" style="border:0px solid #833b3b; width:900px;  ">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                <td align="left" class="welcome-signout"><span style="margin-left:50px"><?php echo $label['name_address']['title']; ?></span></td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table width="90%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                        <tr>
                                            <td width="50%" align="left" class="lable-text"><?php echo $label['name_address'][0]; ?></td>
                                            <td width="50%" align="left"><?php echo $owner['name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="lable-text"><?php echo $label['name_address'][1]; ?></td>
                                            <td align="left"><?php echo $owner['street']; ?></td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="lable-text"><?php echo $label['name_address'][2]; ?></td>
                                            <td align="left"><?php echo $owner['district']; ?></td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="lable-text"><?php echo $label['name_address'][3]; ?></td>
                                            <td align="left"><?php echo $owner['state']; ?></td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="lable-text"><?php echo $label['name_address'][4]; ?></td>
                                            <td align="left"><?php echo $owner['pin']; ?></td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="lable-text"><?php echo $label['name_address'][5]; ?></td>
                                            <td align="left"><?php echo $owner['fax']; ?></td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="lable-text"><?php echo $label['name_address'][6]; ?></td>
                                            <td align="left"><?php echo $owner['phone']; ?></td> 
                                        </tr>
                                        <tr>
                                            <td align="left" class="lable-text"><?php echo $label['name_address'][7]; ?></td>
                                            <td align="left"><?php echo $owner['mobile']; ?></td>
                                        </tr>
                                        <tr>
                                        <tr>
                                            <td align="left" class="lable-text"><?php echo $label['name_address'][8]; ?></td>
                                            <td align="left"><?php echo $owner['email']; ?></td>
                                        </tr>
                                        <?php if ($returnType == 'ANNUAL') { ?>
                                            <tr>
                                                <td align="left" class="lable-text">4. Registered Office of the Lessee</td>
                                                <td align="left"><?php echo $owner['lessee_office_name']; ?></td>
                                            </tr>
                                            <tr>
                                                <td align="left" class="lable-text">5. Director in charge</td>
                                                <td align="left"><?php echo $owner['director_name']; ?></td>
                                            </tr>
                                            <tr>
                                                <td align="left" class="lable-text">6. Agent</td>
                                                <td align="left"><?php echo $owner['agent_name']; ?></td>
                                            </tr>
                                            <tr>
                                                <td align="left" class="lable-text">7. Manager</td>
                                                <td align="left"><?php echo $owner['manager_name']; ?></td>
                                            </tr>
                                            <tr>
                                                <td align="left" class="lable-text">8. Mining Engineer in charge</td>
                                                <td align="left"><?php echo $owner['mining_engineer_name']; ?></td>
                                            </tr>
                                            <tr>
                                                <td align="left" class="lable-text">9. Geologist in charge</td>
                                                <td align="left"><?php echo $owner['geologist_name']; ?></td>
                                            </tr>
                                            <tr>
                                                <td align="left" class="lable-text">10.(i) Transferer (previous owner)</td>
                                                <td align="left"><?php echo $owner['previous_lessee_name']; ?></td>
                                            </tr>
                                            <tr>
                                                <td align="left" class="lable-text">(ii) Date of Transfer</td>
                                                <td align="left"><?php echo $owner['date_of_entry']; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>

            <!--Rent Details-->
            <tr>
                <td align="center">
                    <div id="rent_details" style="border:0px solid #833b3b; width:900px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr><td>&nbsp;</td></tr>
                            <tr><td align="left" class="welcome-signout"><span style="margin-left:50px"><?php echo $label['rent']['title']; ?></span></td></tr>
                            <tr>
                                <td align="center" valign="top"><table width="90%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                        <tr>
                                            <td width="50%" align="left" class="lable-text"><?php echo $label['rent'][0]; ?></td>
                                            <td width="50%" align="left"><?php echo $rentDetail['past_surface_rent']; ?></td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="lable-text"><?php echo $label['rent'][1]; ?></td>
                                            <td align="left"><?php echo $rentDetail['past_royalty']; ?>
                                                </td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="lable-text"><?php echo $label['rent'][2]; ?></td>
                                            <td align="left"><?php echo $rentDetail['past_surface_rent']; ?></td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="lable-text"><?php echo $label['rent'][3]; ?></td>
                                            <td align="left"><?php echo $rentDetail['past_dead_rent']; ?></td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="lable-text"><?php echo $label['rent'][4]; ?></td>
                                            <td align="left"><?php echo $rentDetail['past_pay_dmf']; ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>

            <!--Working Details-->
            <?php

			$optionArr = [];
			foreach($reasonsArr as $reason){
				$optionArr[$reason['stoppage_sn']] = $reason['stoppage_def']; 
			}

            ?>
             
            <tr>
                <td align="center">
                    <div id="details_working" style="border:0px solid #833b3b; width:900px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr><td>&nbsp;</td></tr>
                            <tr><td style="line-height:14px;" align="left" class="welcome-signout"><span style="margin-left:50px"><?php echo $label['working_detail']['title']; ?></span></td></tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table width="90%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                        <tr>
                                            <td width="37%" align="left" class="lable-text"><?php echo $label['working_detail'][0]; ?></td>
                                            <td width="63%" align="left"><?php echo $workDetail['total_no_days']; ?></td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="top" class="lable-text"><?php echo $label['working_detail'][1]; ?></td>
                                            <td align="left">
                                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD">
                                                    <tr>
                                                        <td width="49%" height="25" align="center" class="form-table-title"><?php echo $label['working_detail'][2]; ?></td>
                                                        <td width="51%" align="center" class="form-table-title"><?php echo $label['working_detail'][3]; ?></td>
                                                    </tr>
                                                    <?php
                                                    if($workDetail['stoppage_sn_1']!=null){
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $optionArr[$workDetail['stoppage_sn_1']]; ?> </td>
                                                            <td><?php echo $workDetail['no_days_1']; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    
                                                    <?php
                                                    if($workDetail['stoppage_sn_2']!=null){
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $optionArr[$workDetail['stoppage_sn_2']]; ?> </td>
                                                            <td><?php echo $workDetail['no_days_2']; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    
                                                    <?php
                                                    if($workDetail['stoppage_sn_3']!=null){
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $optionArr[$workDetail['stoppage_sn_3']]; ?> </td>
                                                            <td><?php echo $workDetail['no_days_3']; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    
                                                    <?php
                                                    if($workDetail['stoppage_sn_4']!=null){
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $optionArr[$workDetail['stoppage_sn_4']]; ?> </td>
                                                            <td><?php echo $workDetail['no_days_4']; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    
                                                    <?php
                                                    if($workDetail['stoppage_sn_5']!=null){
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $optionArr[$workDetail['stoppage_sn_5']]; ?> </td>
                                                            <td><?php echo $workDetail['no_days_5']; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>

            <!--Average Daily-->
            <tr>
                <td align="center">
                    <div id="daily_wages" style="border:0px solid #833b3b; width:900px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr><td align="left" class="welcome-signout"><span style="margin-left:50px"><?php echo $label['daily_average']['title']; ?></span></td></tr>
                            <tr>
                                <td align="center" valign="top"><table width="90%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                        <tr>
                                            <td width="21%" rowspan="2" align="center" class="form-table-title"><?php echo $label['daily_average'][0]; ?></td>
                                            <td colspan="2" align="center" class="form-table-title"><?php echo $label['daily_average'][1]; ?></td>
                                            <td colspan="2" align="center" class="form-table-title"><?php echo $label['daily_average'][2]; ?></td> 
                                            <td colspan="2" align="center" class="form-table-title"><?php echo $label['daily_average'][3]; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="12%" align="center" class="form-table-title"><?php echo $label['daily_average'][4]; ?></td>
                                            <td width="13%" align="center" class="form-table-title"><?php echo $label['daily_average'][5]; ?></td>
                                            <td width="11%" align="center" class="form-table-title"><?php echo $label['daily_average'][6]; ?></td>
                                            <td width="13%" align="center" class="form-table-title"><?php echo $label['daily_average'][7]; ?></td>
                                            <td width="14%" align="center" class="form-table-title"><?php echo $label['daily_average'][8]; ?></td>
                                            <td width="16%" align="center" class="form-table-title"><?php echo $label['daily_average'][9]; ?></td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="top" class="lable-text"><?php echo $label['daily_average'][10]; ?> </td>
                                            <td align="right"><?php echo $openArr['male_avg_direct'] ?></td>
                                            <td align="right"><?php echo $openArr['female_avg_direct'] ?></td>
                                            <td align="right"><?php echo $openArr['male_avg_contract'] ?></td>
                                            <td align="right"><?php echo $openArr['female_avg_contract'] ?></td>
                                            <td align="right"><?php echo $openArr['wage_direct'] ?></td>
                                            <td align="right"><?php echo $openArr['wage_contract'] ?></td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="top" class="lable-text"><?php echo $label['daily_average'][11]; ?></td>
                                            <td align="right"><?php echo $belowArr['male_avg_direct'] ?></td>
                                            <td align="right"><?php echo $belowArr['female_avg_direct'] ?></td>
                                            <td align="right"><?php echo $belowArr['male_avg_contract'] ?></td>
                                            <td align="right"><?php echo $belowArr['female_avg_contract'] ?></td>
                                            <td align="right"><?php echo $belowArr['wage_direct'] ?></td>
                                            <td align="right"><?php echo $belowArr['wage_contract'] ?></td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="top" class="lable-text"><?php echo $label['daily_average'][12]; ?></td>
                                            <td align="right"><?php echo $aboveArr['male_avg_direct'] ?></td>
                                            <td align="right"><?php echo $aboveArr['female_avg_direct'] ?></td>
                                            <td align="right"><?php echo $aboveArr['male_avg_contract'] ?></td>
                                            <td align="right"><?php echo $aboveArr['female_avg_contract'] ?></td>
                                            <td align="right"><?php echo $aboveArr['wage_direct'] ?></td>
                                            <td align="right"><?php echo $aboveArr['wage_contract'] ?></td>
                                        </tr>
                                        <tr class="welcome-page-name">
                                            <td align="left" valign="top" class="total-bgcolor"><?php echo $label['daily_average'][13]; ?></td>
                                            <td align="right" class="total-bgcolor"><?php echo $openArr['total_male_direct']; ?></td>
                                            <td align="right" class="total-bgcolor"><?php echo $openArr['total_female_direct']; ?></td>
                                            <td align="right" class="total-bgcolor"><?php echo $openArr['total_male_contract']; ?></td>
                                            <td align="right" class="total-bgcolor"><?php echo $openArr['total_female_contract']; ?></td>
                                            <td align="right" class="total-bgcolor"><?php echo $openArr['total_direct']; ?></td>
                                            <td align="right" class="total-bgcolor"><?php echo $openArr['total_contract']; ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="7"><?php echo $label['daily_average'][14]; ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr><td>&nbsp;</td></tr>
                        </table>
                    </div>
                </td>
            </tr>

            <!--PART II FOR PRIMARY MINERAL-->
            <?php 
            
            $title = "Part II xpt For ";
            $title.= ucwords(strtolower($partIIM1[0]));
            $minLow = strtolower($partIIM1[0]);
            $mineral = $partIIM1[0];
            $ironSubMin = '';
            if(strtolower($partIIM1[0]) == strtolower('Iron Ore')) {
                if($is_hematite) {
                    $title.= ' (HEMATITE)';
                    // $mineral.= ' (HEMATITE)';
                    $ironSubMin = "/hematite";
                } elseif($is_magnetite) {
                    $title.= ' (MAGNETITE)';
                    // $mineral.= ' (MAGNETITE)';
                    $ironSubMin = "/magnetite";
                }
            }

            ?>
            <tr><td align="center"><span style="margin-left:50px"><strong><?php echo $label['rom_stocks']['part']; ?></strong></span></td>
            </tr>
            <tr><td>&nbsp;</td></tr>

            <!--=======GETTING FORM TYPE BASED ON THE MINERAL NAME=====-->
            <?php if($partIIM1['formNo'] == 5) { ?>
                
                <!--PRODUCTION / STOCKS (ROM)-->
                <tr>
                    <td align="left" class="welcome-signout"><span><?php echo $label['rom_stocks_ore']['title']." (".strtoupper($partIIM1[0]).")"; ?></span></td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                            <thead class="thead-light text-center">
                                <tr>
                                    <th rowspan="2">&nbsp;</th>
                                    <th colspan="2"><?php echo $label['rom_stocks_ore'][0]; ?></th>
                                    <th colspan="2"><?php echo $label['rom_stocks_ore'][1]; ?></th>
                                    <th colspan="2"><?php echo $label['rom_stocks_ore'][2]; ?></th>
                                </tr>
                                <tr>
                                    <th><?php echo $label['rom_stocks_ore'][3]; ?></th>
                                    <th><?php echo $label['rom_stocks_ore'][4]; ?></th>
                                    <th><?php echo $label['rom_stocks_ore'][3]; ?></th>
                                    <th><?php echo $label['rom_stocks_ore'][4]; ?></th>
                                    <th><?php echo $label['rom_stocks_ore'][3]; ?></th>
                                    <th><?php echo $label['rom_stocks_ore'][4]; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $label['rom_stocks_ore'][5]; ?></td>
                                    <td>
                                        <div class="tot-qty open_dev_qty" id="f_open_dev_qty"><?php echo $romDataOre[$minLow][1]['tot_qty'][0]; ?></div>
                                    </td>
                                    <td>
                                        <table id="open_dev_table" class="f5-rom-sub-table table">
                                            <thead></thead>
                                            <tbody>
                                                <?php foreach($romDataOre[$minLow][1]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <div class="open_dev_metal" id="open_dev_metal_<?php echo $keyN; ?>"><?php echo $val; ?></div>
                                                        </td>
                                                        <td>
                                                            <div class="open_dev_grade" id="open_dev_grade_<?php echo $keyN; ?>"><?php echo $romDataOre[$minLow][1]['grade'][$key]; ?></div>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php echo $this->Form->control('open_dev_metal_count', array('type'=>'hidden', 'id'=>'open_dev_metal_count', 'label'=>false)); ?>
                                    </td>
                                    <td>
                                        <div class="prod_dev_qty" id="f_prod_dev_qty"><?php echo $romDataOre[$minLow][2]['tot_qty'][0]; ?></div>
                                    </td>
                                    <td>
                                        <table id="prod_dev_table" class="f5-rom-sub-table table">
                                            <thead></thead>
                                            <tbody>
                                                <?php foreach($romDataOre[$minLow][2]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <div class="prod_dev_metal" id="prod_dev_metal_<?php echo $keyN; ?>"><?php echo $val; ?></div>
                                                        </td>
                                                        <td>
                                                            <div class="prod_dev_grade" id="prod_dev_grade_<?php echo $keyN; ?>"><?php echo $romDataOre[$minLow][2]['grade'][$key]; ?></div>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php echo $this->Form->control('prod_dev_metal_count', array('type'=>'hidden', 'id'=>'prod_dev_metal_count', 'label'=>false)); ?>
                                    </td>
                                    <td>
                                        <div class="close_dev_qty" id="f_close_dev_qty"><?php echo $romDataOre[$minLow][3]['tot_qty'][0]; ?></div>
                                    </td>
                                    <td>
                                        <table id="close_dev_table" class="f5-rom-sub-table table">
                                            <thead></thead>
                                            <tbody>
                                                <?php foreach($romDataOre[$minLow][3]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <div class="close_dev_metal" id="close_dev_metal_<?php echo $keyN; ?>"><?php echo $val; ?></div>
                                                        </td>
                                                        <td>
                                                            <div class="close_dev_grade" id="close_dev_grade_<?php echo $keyN; ?>"><?php echo $romDataOre[$minLow][3]['grade'][$key]; ?></div>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php echo $this->Form->control('close_dev_metal_count', array('type'=>'hidden', 'id'=>'close_dev_metal_count', 'label'=>false)); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo $label['rom_stocks_ore'][6]; ?></td>
                                    <td>
                                        <div class="open_stop_qty" id="f_open_stop_qty"><?php echo $romDataOre[$minLow][4]['tot_qty'][0]; ?></div>
                                    </td>
                                    <td>
                                        <table id="open_stop_table" class="f5-rom-sub-table table">
                                            <thead></thead>
                                            <tbody>
                                                <?php foreach($romDataOre[$minLow][4]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <div class="open_stop_metal" id="open_stop_metal_<?php echo $keyN; ?>"><?php echo $val; ?></div>
                                                        </td>
                                                        <td>
                                                            <div class="open_stop_grade" id="open_stop_grade_<?php echo $keyN; ?>"><?php echo $romDataOre[$minLow][4]['grade'][$key]; ?></div>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php echo $this->Form->control('open_stop_metal_count', array('type'=>'hidden', 'id'=>'open_stop_metal_count', 'label'=>false)); ?>
                                    </td>
                                    <td>
                                    <div class="prod_stop_qty" id="f_prod_stop_qty"><?php echo $romDataOre[$minLow][5]['tot_qty'][0]; ?></div>
                                    </td>
                                    <td>
                                        <table id="prod_stop_table" class="f5-rom-sub-table table">
                                            <thead></thead>
                                            <tbody>
                                                <?php foreach($romDataOre[$minLow][5]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <div class="prod_stop_metal" id="prod_stop_metal_<?php echo $keyN; ?>"><?php echo $val; ?></div>
                                                        </td>
                                                        <td>
                                                            <div class="prod_stop_grade" id="prod_stop_grade_<?php echo $keyN; ?>"><?php echo $romDataOre[$minLow][5]['grade'][$key]; ?></div>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php echo $this->Form->control('prod_stop_metal_count', array('type'=>'hidden', 'id'=>'prod_stop_metal_count', 'label'=>false)); ?>
                                    </td>
                                    <td>
                                    <div class="close_stop_qty" id="f_close_stop_qty"><?php echo $romDataOre[$minLow][6]['tot_qty'][0]; ?></div>
                                    </td>
                                    <td>
                                        <table id="close_stop_table" class="f5-rom-sub-table table">
                                            <thead></thead>
                                            <tbody>
                                                <?php foreach($romDataOre[$minLow][6]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <div class="close_stop_metal" id="close_stop_metal_<?php echo $keyN; ?>"><?php echo $val; ?></div>
                                                        </td>
                                                        <td>
                                                            <div class="close_stop_grade" id="close_stop_grade_<?php echo $keyN; ?>"><?php echo $romDataOre[$minLow][6]['grade'][$key]; ?></div>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php echo $this->Form->control('close_stop_metal_count', array('type'=>'hidden', 'id'=>'close_stop_metal_count', 'label'=>false)); ?>
                                    </td>
                                </tr>
                            </tbody>
                            <thead class="thead-light">
                                <tr>
                                    <th><?php echo $label['rom_stocks_ore'][7]; ?></th>
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
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $label['rom_stocks_ore'][8]; ?></td>
                                    <td>
                                        <div class="open_cast_qty" id="f_open_cast_qty"><?php echo $romDataOre[$minLow][7]['tot_qty'][0]; ?></div>
                                    </td>
                                    <td>
                                        <table id="open_cast_table" class="f5-rom-sub-table table">
                                            <thead></thead>
                                            <tbody>
                                                <?php foreach($romDataOre[$minLow][7]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <div class="open_cast_metal" id="open_cast_metal_<?php echo $keyN; ?>"><?php echo $val; ?></div>
                                                        </td>
                                                        <td>
                                                            <div class="open_cast_grade" id="open_cast_grade_<?php echo $keyN; ?>"><?php echo $romDataOre[$minLow][7]['grade'][$key]; ?></div>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php echo $this->Form->control('open_cast_metal_count', array('type'=>'hidden', 'id'=>'open_cast_metal_count', 'label'=>false)); ?>
                                    </td>
                                    <td>
                                        <div class="prod_cast_qty" id="f_prod_cast_qty"><?php echo $romDataOre[$minLow][8]['tot_qty'][0]; ?></div>
                                    </td>
                                    <td>
                                        <table id="prod_cast_table" class="f5-rom-sub-table table">
                                            <thead></thead>
                                            <tbody>
                                                <?php foreach($romDataOre[$minLow][8]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <div class="prod_cast_metal" id="prod_cast_metal_<?php echo $keyN; ?>"><?php echo $val; ?></div>
                                                        </td>
                                                        <td>
                                                            <div class="prod_cast_grade" id="prod_cast_grade_<?php echo $keyN; ?>"><?php echo $romDataOre[$minLow][8]['grade'][$key]; ?></div>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php echo $this->Form->control('prod_cast_metal_count', array('type'=>'hidden', 'id'=>'prod_cast_metal_count', 'label'=>false)); ?>
                                    </td>
                                    <td>
                                        <div class="close_cast_qty" id="f_close_cast_qty"><?php echo $romDataOre[$minLow][9]['tot_qty'][0]; ?></div>
                                    </td>
                                    <td>
                                        <table id="close_cast_table" class="f5-rom-sub-table table">
                                            <thead></thead>
                                            <tbody>
                                                <?php foreach($romDataOre[$minLow][9]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <div class="close_cast_metal" id="close_cast_metal_<?php echo $keyN; ?>"><?php echo $val; ?></div>
                                                        </td>
                                                        <td>
                                                            <div class="close_cast_grade" id="close_cast_grade_<?php echo $keyN; ?>"><?php echo $romDataOre[$minLow][9]['grade'][$key]; ?></div>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php echo $this->Form->control('close_cast_metal_count', array('type'=>'hidden', 'id'=>'close_cast_metal_count', 'label'=>false)); ?>
                                    </td>
                                </tr>
                            </tbody>
                            <thead class="thead-light">
                                <tr>
                                    <th><?php echo $label['rom_stocks_ore'][9]; ?></th>
                                    <th>
                                        <div id='f_open_tot_qty'></div>
                                    </th>
                                    <th>
                                    <table id="open_total_table" class="f5-rom-total-table"></table>
                                    </th>
                                    <th>
                                        <div id='f_prod_tot_qty'></div>
                                    </th>
                                    <th>
                                    <table id="prod_total_table" class="f5-rom-total-table"></table>
                                    </th>
                                    <th>
                                        <div id='f_close_tot_qty'></div>
                                    </th>
                                    <th>
                                    <table id="close_total_table" class="f5-rom-total-table"></table>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </td>
                </tr>
            
                <!-- EX-MINE PRICE -->
                <tr>
                    <td align="left" class="welcome-signout"><span><?php echo $label['ex_mine']['title']." (".strtoupper($partIIM1[0]).")"; ?></span></td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                            <tbody class="tbody-light text-center">
                                <tr>
                                    <td><?php echo $label['ex_mine'][0]; ?></td>
                                    <td><?php echo $exMine[$minLow]['pmv']; ?></th>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                
                <!-- RECOVERIES AT CONCENTRATOR -->
                <tr>
                    <td align="left" class="welcome-signout"><span><?php echo $label['con_reco']['title']." (".strtoupper($partIIM1[0]).")"; ?></span></td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                           <thead class="thead-light text-center">
                                <tr>
                                    <th colspan="2"><?php echo $label['con_reco'][0]; ?></th>
                                    <th colspan="2"><?php echo $label['con_reco'][1]; ?></th>
                                    <th colspan="2"><?php echo $label['con_reco'][2]; ?></th>
                                </tr>
                                <tr>
                                    <th><?php echo $label['con_reco'][3]; ?></th>
                                    <th><?php echo $label['con_reco'][4]; ?></th>
                                    <th><?php echo $label['con_reco'][3]; ?></th>
                                    <th><?php echo $label['con_reco'][4]; ?></th>
                                    <th><?php echo $label['con_reco'][3]; ?></th>
                                    <th><?php echo $label['con_reco'][4]; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <!-- SECTION 1 : OPENING STOCKS OF THE ORE AT CONCENTRATOR/PLANT -->
                                    <td>
                                        <?php echo $recovCon[$minLow]['rom'][10]['tot_qty'][0]; ?>
                                    </td>
                                    <td>
                                        <table id="open_ore_table" class="f5-rom-sub-table table table-borderless">
                                            <thead></thead>
                                            <tbody>
                                                <?php foreach($recovCon[$minLow]['rom'][10]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $recovCon[$minLow]['rom'][10]['grade'][$key]; ?>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>

                                    <!-- SECTION 2 : ORE RECEIVED FROM THE MINE -->
                                    <td>
                                        <?php echo $recovCon[$minLow]['rom'][11]['tot_qty'][0]; ?>
                                    </td>
                                    <td>
                                        <table id="rec_ore_table" class="f5-rom-sub-table table table-borderless">
                                            <thead></thead>
                                            <tbody>
                                                <?php foreach($recovCon[$minLow]['rom'][11]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $recovCon[$minLow]['rom'][11]['grade'][$key]; ?>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>

                                    <!-- SECTION 3 : ORE TREATED  --> 
                                    <td>
                                        <?php echo $recovCon[$minLow]['rom'][12]['tot_qty'][0]; ?>
                                    </td>
                                    <td>
                                        <table id="treat_ore_table" class="f5-rom-sub-table table table-borderless">
                                            <thead></thead>
                                            <tbody>
                                                <?php foreach($recovCon[$minLow]['rom'][12]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $recovCon[$minLow]['rom'][12]['grade'][$key]; ?>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                            <thead class="thead-light text-center">
                                <tr>
                                    <th colspan="3"><?php echo $label['con_reco'][5]; ?></th>
                                    <th colspan="2"><?php echo $label['con_reco'][6]; ?></th>
                                    <th colspan="2"><?php echo $label['con_reco'][7]; ?></th>
                                </tr>
                                <tr>
                                    <th><?php echo $label['con_reco'][8]; ?></th>
                                    <th><?php echo $label['con_reco'][9]; ?></th>
                                    <th><?php echo $label['con_reco'][10]; ?></th>
                                    <th><?php echo $label['con_reco'][8]; ?></th>
                                    <th><?php echo $label['con_reco'][9]; ?></th>
                                    <th><?php echo $label['con_reco'][8]; ?></th>
                                    <th><?php echo $label['con_reco'][9]; ?></th>
                                </tr>
                            </thead>
                                <tr>
                                    <!-- SECTION 4 : CONCENTRATES * OBTAINED  -->
                                    <td>
                                        <table id="con_obt_table" class="f5-rom-sub-table table table-borderless">
                                            <tbody>
                                                <?php foreach($recovCon[$minLow]['con'][13]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $recovCon[$minLow]['con'][13]['tot_qty'][$key]; ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td>
                                        <table id="con_obt_grade_table" class="f5-rom-sub-table table table-borderless">
                                            <tbody>
                                                <?php foreach($recovCon[$minLow]['con'][13]['grade'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val; ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td>
                                        <table id="con_obt_metal_value_table" class="f5-rom-sub-table table table-borderless">
                                            <tbody>
                                                <?php foreach($recovCon[$minLow]['con'][13]['con_value'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val; ?>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>

                                    <!-- SECTION 5 : TAILINGS  -->
                                    <td>
                                        <?php echo $recovCon[$minLow]['rom'][14]['tot_qty'][0]; ?>
                                    </td>
                                    <td>
                                        <table id="tail_ore_table" class="f5-rom-sub-table table table-borderless">
                                            <tbody>
                                                <?php foreach($recovCon[$minLow]['rom'][14]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $recovCon[$minLow]['rom'][14]['grade'][$key]; ?>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>

                                    <!-- SECTION 6 : CLOSING STOCKS OF CONCENTRATES THE CONCENTRATOR/PLANT  -->
                                    <td>
                                        <table id="close_con_table" class="f5-rom-sub-table table table-borderless">
                                            <tbody>
                                                <?php foreach($recovCon[$minLow]['con'][15]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $recovCon[$minLow]['con'][15]['tot_qty'][$key]; ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td>
                                        <table id="close_con_grade_table" class="f5-rom-sub-table table table-borderless">
                                            <tbody>
                                                <?php foreach($recovCon[$minLow]['con'][15]['grade'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val; ?>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <!-- RECOVERIES AT THE SMELTER -->
                <tr>
                    <td align="left" class="welcome-signout"><span><?php echo $label['smelt_reco']['title']." (".strtoupper($partIIM1[0]).")"; ?></span></td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                           <thead class="thead-light text-center">
                                <tr>
                                    <th colspan="2"><?php echo $label['smelt_reco'][0]; ?></th>
                                    <th colspan="2"><?php echo $label['smelt_reco'][1]; ?></th>
                                    <th colspan="3"><?php echo $label['smelt_reco'][2]; ?></th>
                                    <th colspan="2"><?php echo $label['smelt_reco'][3]; ?></th>
                                    <th colspan="2"><?php echo $label['smelt_reco'][4]; ?></th>
                                    <th colspan="3"><?php echo $label['smelt_reco'][5]; ?></th>
                                </tr>
                                <tr>
                                    <th><?php echo $label['smelt_reco'][6]; ?></th>
                                    <th><?php echo $label['smelt_reco'][7]; ?></th>
                                    <th><?php echo $label['smelt_reco'][6]; ?></th>
                                    <th><?php echo $label['smelt_reco'][7]; ?></th>
                                    <th><?php echo $label['smelt_reco'][8]; ?></th>
                                    <th><?php echo $label['smelt_reco'][6]; ?></th>
                                    <th><?php echo $label['smelt_reco'][7]; ?></th>
                                    <th><?php echo $label['smelt_reco'][6]; ?></th>
                                    <th><?php echo $label['smelt_reco'][7]; ?></th>
                                    <th><?php echo $label['smelt_reco'][6]; ?></th>
                                    <th><?php echo $label['smelt_reco'][7]; ?></th>
                                    <th><?php echo $label['smelt_reco'][6]; ?></th>
                                    <th colspan="2"><?php echo $label['smelt_reco'][7]; ?></th>
                                </tr>
                            </thead>
                            <tbody class="recovery-table-body">
                                <?php foreach($smeltReco[$minLow]['recovery'] as $key=>$val){ $keyN = $key+1; ?>
                                    <tr class="recovery-table-rw">
                                        <td>
                                            <table class="smelter-open-table table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val['open_metal']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $val['open_qty']; ?>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <?php echo $val['open_grade']; ?>
                                        </td>
                                        <td>
                                            <?php echo $val['con_rc_qty']; ?>
                                        </td>
                                        <td>
                                            <?php echo $val['con_rc_grade']; ?>
                                        </td>
                                        <td>
                                            <?php echo $val['con_rs_source']; ?>
                                        </td>
                                        <td>
                                            <?php echo $val['con_rs_qty']; ?>
                                        </td>
                                        <td>
                                            <?php echo $val['con_rs_grade']; ?>
                                        </td>
                                        <td>
                                            <?php echo $val['con_so_qty']; ?>
                                        </td>
                                        <td>
                                            <?php echo $val['con_so_grade']; ?>
                                        </td>
                                        <td>
                                            <?php echo $val['con_tr_qty']; ?>
                                        </td>
                                        <td>
                                            <?php echo $val['con_tr_grade']; ?>
                                        </td>
                                        <td>
                                            <?php echo $val['close_qty']; ?>
                                        </td>
                                        <td>
                                            <?php echo $val['close_value']; ?>
                                        </td>
                                        <td></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                            <thead class="thead-light text-center">
                                <tr>
                                    <th colspan="3"><?php echo $label['smelt_reco'][9]; ?></th>
                                    <th colspan="3"><?php echo $label['smelt_reco'][10]; ?></th>
                                </tr>
                                <tr>
                                    <th><?php echo $label['smelt_reco'][11]; ?></th>
                                    <th><?php echo $label['smelt_reco'][12]; ?></th>
                                    <th><?php echo $label['smelt_reco'][13]; ?></th>
                                    <th><?php echo $label['smelt_reco'][11]; ?></th>
                                    <th><?php echo $label['smelt_reco'][12]; ?></th>
                                    <th><?php echo $label['smelt_reco'][13]; ?></th>
                                </tr>
                            </thead>
                                <tr>
                                    <!--METAL RECOVERED TABLE-->
                                    <td>
                                        <table id="con_metal_table" class="f5-rom-sub-table table table-borderless">
                                            <tbody>
                                                <?php foreach($smeltReco[$minLow]['con_metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val['rc_metal']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $val['rc_qty']; ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td>
                                        <table id="con_grade_table" class="f5-rom-sub-table table table-borderless">
                                            <tbody>
                                                <?php foreach($smeltReco[$minLow]['con_metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val['rc_grade']; ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td>
                                        <table id="con_metal_value_table" class="f5-rom-sub-table table table-borderless">
                                            <tbody>
                                                <?php foreach($smeltReco[$minLow]['con_metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val['rc_value']; ?>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>

                                    <!--BY PRODUCT TABLE-->
                                    <td>
                                        <table id="byproduct_table" class="f5-rom-sub-table table table-borderless">
                                            <tbody>
                                                <?php foreach($smeltReco[$minLow]['by_product'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val['bp_metal']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $val['bp_qty']; ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td>
                                        <table id="byproduct_grade_table" class="f5-rom-sub-table table table-borderless">
                                            <tbody>
                                                <?php foreach($smeltReco[$minLow]['by_product'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val['bp_grade']; ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td>
                                        <table id="byproduct_value_table" class="f5-rom-sub-table table table-borderless">
                                            <tbody>
                                                <?php foreach($smeltReco[$minLow]['by_product'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val['bp_value']; ?>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <div class="alert alert-secondary"><?php echo $label['smelt_reco']['note']; ?></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            
                <!-- SALES (METALS/BY PRODUCT) -->
                <tr>
                    <td align="left" class="welcome-signout"><span><?php echo $label['sales_metal_product']['title']." (".strtoupper($partIIM1[0]).")"; ?></span></td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                            <thead class="thead-light text-center">
                                <tr>
                                    <th colspan="3"><?php echo $label['sales_metal_product'][0]; ?></th>
                                    <th rowspan="2"><?php echo $label['sales_metal_product'][1]; ?></th>
                                    <th colspan="3"><?php echo $label['sales_metal_product'][2]; ?></th>
                                    <th colspan="3"><?php echo $label['sales_metal_product'][3]; ?></th>
                                </tr>
                                <tr>
                                    <th><?php echo $label['sales_metal_product'][4]; ?></th>
                                    <th><?php echo $label['sales_metal_product'][5]; ?></th>
                                    <th><?php echo $label['sales_metal_product'][6]; ?></th>
                                    <th><?php echo $label['sales_metal_product'][5]; ?></th>
                                    <th><?php echo $label['sales_metal_product'][6]; ?></th>
                                    <th><?php echo $label['sales_metal_product'][7]; ?></th>
                                    <th><?php echo $label['sales_metal_product'][5]; ?></th>
                                    <th colspan="2"><?php echo $label['sales_metal_product'][6]; ?></th>
                                </tr>
                            </thead>
                            <tbody class="t-body">
                                <?php 

                                $rowC = 1;
                                foreach($salesMetalProduct[$minLow] as $key=>$val){ 
                                    $keyN = $key+1;

                                ?>
                                    <?php if($val['table_name'] == 'open_stock'){ $rowC = ($key != 0) ? $rowC+1 : $rowC;  ?>
                                    <tr>
                                        <td>
                                            <?php echo $val['open_metal']; ?>
                                        </td>
                                        <td>
                                            <?php echo $val['open_tot_qty']; ?>
                                        </td>
                                        <td>
                                            <?php echo $val['open_grade']; ?>
                                        </td>

                                    <?php } if($val['table_name'] == 'sale_place') { ?>

                                        <td>
                                            <?php echo $val['sale_place']; ?>
                                        </td>

                                    <?php } if($val['table_name'] == 'prod_sold') { ?>

                                        <td>
                                            <?php echo $val['prod_tot_qty']; ?>
                                        </td>
                                        <td>
                                            <?php echo $val['prod_grade']; ?>
                                        </td>
                                        <td>
                                            <?php echo $val['prod_product_value']; ?>
                                        </td>

                                    <?php } if($val['table_name'] == 'close_stock') { ?>

                                        <td>
                                            <?php echo $val['close_tot_qty']; ?>
                                        </td>
                                        <td>
                                            <?php echo $val['close_product_value']; ?>
                                        </td>
                                        <td></td>
                                    </tr>

                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                        
                        <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                            <tbody>
                                <tr>
                                    <td><?php echo $label['sales_metal_product']['note_txt']; ?></td>
                                    <td class="text-primary"><?php echo $label['sales_metal_product']['note_1']; ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="text-danger"><?php echo $label['sales_metal_product']['note_2']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                
                <!--DEDUCTION DETAILS-->
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td align="left" class="welcome-signout"><span><?php echo $label['deduct_detail']['title']." (".strtoupper($partIIM1[0]).")"; ?></span></td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                            <tr>
                                <td width="55%" align="center" class="form-table-title"><?php echo $label['deduct_detail'][0]; ?></td>
                                <td width="19%" align="center" class="form-table-title"><?php echo $label['deduct_detail'][1]; ?></td>
                                <td width="26%" align="center" class="form-table-title"><?php echo $label['deduct_detail'][2]; ?></td>
                            </tr>
                            <tr height="60">
                                <td align="left" class="lable-text"><?php echo $label['deduct_detail'][3]; ?></td>
                                <td align="center"><?php echo $deductDetail[$minLow]['trans_cost']; ?></td>
                                <td align="center"><?php echo $deductDetail[$minLow]['trans_remark']; ?></td>
                            </tr>
                            <tr height="60">
                                <td align="left" class="lable-text"><?php echo $label['deduct_detail'][4]; ?></td>
                                <td align="center"><?php echo $deductDetail[$minLow]['loading_charges']; ?></td>
                                <td align="center"><?php echo $deductDetail[$minLow]['loading_remark']; ?></td>
                            </tr>
                            <tr height="60">
                                <td align="left" class="lable-text"><?php echo $label['deduct_detail'][5]; ?></td>
                                <td align="center"><?php echo $deductDetail[$minLow]['railway_freight']; ?></td>
                                <td align="center"><?php echo $deductDetail[$minLow]['railway_remark']; ?></td>
                            </tr>
                            <tr height="60">
                                <td align="left" class="lable-text"><?php echo $label['deduct_detail'][6]; ?></td>
                                <td align="center"><?php echo $deductDetail[$minLow]['port_handling']; ?></td>
                                <td align="center"><?php echo $deductDetail[$minLow]['port_remark']; ?></td>
                            </tr>
                            <tr height="60">
                                <td align="left" class="lable-text"><?php echo $label['deduct_detail'][7]; ?></td>
                                <td align="center"><?php echo $deductDetail[$minLow]['sampling_cost']; ?></td>
                                <td align="center"><?php echo $deductDetail[$minLow]['sampling_remark']; ?></td>
                            </tr>
                            <tr height="60">
                                <td align="left" class="lable-text"><?php echo $label['deduct_detail'][8]; ?></td>
                                <td align="center"><?php echo $deductDetail[$minLow]['plot_rent']; ?></td>
                                <td align="center"><?php echo $deductDetail[$minLow]['plot_remark']; ?></td>
                            </tr>
                            <tr height="60">
                                <td align="left" class="lable-text"><?php echo $label['deduct_detail'][9]; ?></td>
                                <td align="center"><?php echo $deductDetail[$minLow]['other_cost']; ?></td>
                                <td align="center"><?php echo $deductDetail[$minLow]['other_remark']; ?></td>
                            </tr>
                            <tr height="30">
                                <td align="left" class="total-bgcolor"><?php echo $label['deduct_detail'][10]; ?></td>
                                <td colspan="2" align="left" class="total-bgcolor">
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="32%" align="right" class="welcome-page-name">
                                                <?php echo $deductDetail[$minLow]['total_prod']; ?></td>
                                            <td width="68%">&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            
                <!--SALES/DISPATCHES-->
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td align="left" class="welcome-signout"><span><?php echo $label['sale_despatch']['title']." (".strtoupper($partIIM1[0]).")"; ?></span></td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                            <tr>
                                <td height="28" align="center" valign="top" class="form-table-title">&nbsp;</td>
                                <td align="center" class="form-table-title">&nbsp;</td>
                                <td id="Domestic_1" colspan="4" align="center" class="form-table-title"><?php echo $label['sale_despatch'][0]; ?></td>
                                <td id="Export_1"colspan="3" align="center" class="form-table-title"><?php echo $label['sale_despatch'][1]; ?></td>
                            </tr>
                            <tr>
                                <td align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][2]; ?></td>
                                <td align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][3]; ?></td>
                                <td id="Domestic_2" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][4]; ?></td>
                                <td id="Domestic_3" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][5]; ?></td>
                                <td id="Domestic_4" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][6]; ?> (in <?php echo $unit[$minLow]; ?>)</td>
                                <td id="Domestic_5" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][7]; ?></td>
                                <td id="Export_2" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][8]; ?></td>
                                <td id="Export_3" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][9]; ?> (in <?php echo $unit[$minLow]; ?>)</td>
                                <td id="Export_4" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][10]; ?>
                                <?php for ($count = 0; $count < count($saleDespatch[$minLow]); $count++) { ?>
                                    <tr>
                                        <td align="center" valign="middle" class="lable-text"><?php 
                                        if(isset($saleDespatchGrade[$minLow][$saleDespatch[$minLow][$count]['grade_code']])){
                                            echo $saleDespatchGrade[$minLow][$saleDespatch[$minLow][$count]['grade_code']];
                                        } else {
                                            echo 'NIL';
                                        }
                                        ?></td>
                                        <td align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['client_type']; ?></td>
                                        <td id="Domestic_6" align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['client_reg_no']; ?></td>
                                        <td id="Domestic_7" align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['client_name']; ?></td>
                                        <td id="Domestic_8" align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['quantity']; ?></td>
                                        <td id="Domestic_9" align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['sale_value']; ?></td>
                                        <td id="Export_5" align="center" valign="middle"><?php 
                                            foreach($countryList[$minLow] as $key=>$val){
                                                if($val['id'] == $saleDespatch[$minLow][$count]['expo_country']){
                                                    echo $val['country_name'];
                                                }
                                            }
                                        ?></td>
                                        <td id="Export_6" align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['expo_quantity']; ?></td>
                                        <td id="Export_7" align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['expo_fob']; ?></td>
                                    </tr>

                                <?php } ?>
                                </td>
                            </tr>
		                    <?php if($formNo == '5'){ ?>
                                <tr>
                                    <td colspan="9"><?php echo $label['sale_despatch']['note']; ?></td>
                                </tr>
					        <?php } ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="left" class="welcome-signout"><span><?php echo $label['sale_despatch'][11]; ?></span></td>
                </tr>
                <tr>
                    </td>
                        <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                            <tr><!--   Remove the S form reason word. added by ganesh satav dated: 13 feb 14-->
                                <td width="21%" align="left" valign="top" class="form-table-title"><?php echo $label['sale_despatch'][13]; ?></td>
                            </tr>
                            <tr>
                                <td align="left" height="60" valign="top" class="lable-text">
                                    <?php
                                    // if ($formData[$i]['mineral'] == "mica") {
                                    //     echo $formData[$i]['prodistocksF6']['crude']['REASON_ONE'];
                                    // } else {                                                                                                                                                           print_r("uday");
                                    //     echo $gradeValueArray['REASON_1'];
                                    // }
                                    echo $reasonData[$minLow]['reason_1'];
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="left" class="welcome-signout"><span><?php echo $label['sale_despatch'][12]; ?></span></td>
                </tr>
                <tr>
                    </td>
                        <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                            <tr><!--   Remove the S form reason word. added by ganesh satav dated: 13 feb 14-->
                                <td width="21%" align="left" valign="top" class="form-table-title"><?php echo $label['sale_despatch'][14]; ?></td>
                            </tr>
                            <tr>
                                <td align="left" height="60" valign="top" class="lable-text">
                                    <?php
                                    // if ($formData[$i]['mineral'] == "mica") {
                                    //     echo $formData[$i]['prodistocksF6']['crude']['REASON_ONE'];
                                    // } else {                                                                                                                                                           print_r("uday");
                                    //     echo $gradeValueArray['REASON_1'];
                                    // }
                                    echo $reasonData[$minLow]['reason_2'];
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>



            <?php } elseif($partIIM1['formNo'] == 7) { ?>
            Production / Stocks (ROM) 2
            Production, Despatches and Stocks
            Details of Deductions
            Sales/Dispatches
            <?php } else { ?>
            <?php if (strtolower($partIIM1[0]) == strtolower('Iron Ore')) { ?>
                
                <!-- PRINT TYPE OF ORE -->
                <div class="page-break" style="margin-left: 40px;width:90%">

                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-left:0px;margin-top:20px" align="center">
                        <tr><td height="5"></td></tr>
                        <tr><td>&nbsp;</td></tr>
                        </tr>
                        <tr>
                            <td align="left" class="welcome-page-name">
                                <div id="ore_type" style="border:0px solid #E5D0BD; margin-left:20px;width:100%">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr><td>&nbsp;</td></tr>
                                        <tr><td align="center" class="welcome-signout"><?php echo $label['ore_type']['title']; ?></td></tr>
                                        <tr><td>&nbsp;</td></tr>
                                        <tr><td align="left" class="lable-text"><?php echo $label['ore_type'][2]; ?><span align="left" class="lable-text" style="color:#CC0000"><?php if($oreType=='Hematite'){echo "(a) ".$oreType; }else{ echo "(b) ".$oreType; } ?></span></td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

            <?php } ?>
            

            <!--PRODUCTION / STOCKS (ROM)-->
            <?php 
            $prodData = (strtolower($partIIM1[0]) == strtolower('Iron Ore')) ? $prodArr[$minLow]['hematite'] : $prodArr[$minLow];
            $subMin = ($is_hematite == true) ? ' (Hematite) ' : '';
            ?>
            <tr>
                <td align="left" class="welcome-signout"><span><?php echo $label['rom_stocks']['title']." (".strtoupper($partIIM1[0]).$subMin.")"; ?></span></td>
            </tr>
            <tr>
                <td align="left" valign="top">
                    <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                        <tr>
                            <td width="26%" align="center" valign="top" class="form-table-title"><?php echo $label['rom_stocks'][0]; ?></td>
                            <td align="center" class="form-table-title"><?php echo $label['rom_stocks'][1]; ?></td>
                            <td align="center" class="form-table-title"><?php echo $label['rom_stocks'][2]; ?></td>
                            <td align="center" class="form-table-title"><?php echo $label['rom_stocks'][3]; ?></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top" class="lable-text"><?php echo $label['rom_stocks'][4]; ?></td>
                            <td width="26%" align="center"><?php echo $prodData['open_oc_rom']; ?></td>
                            <td width="26%" align="center"><?php echo $prodData['prod_oc_rom']; ?></td>
                            <td width="26%" align="center"><?php echo $prodData['clos_oc_rom']; ?></td>
                        </tr> 
                        <tr>
                            <td align="left" valign="top" class="lable-text"><?php echo $label['rom_stocks'][5]; ?></td>
                            <td width="26%" align="center"><?php echo $prodData['open_ug_rom']; ?></td>
                            <td width="26%" align="center"><?php echo $prodData['prod_ug_rom']; ?></td>
                            <td width="26%" align="center"><?php echo $prodData['clos_ug_rom']; ?></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top" class="lable-text"><?php echo $label['rom_stocks'][6]; ?></td>
                            <td width="26%" align="center"><?php echo $prodData['open_dw_rom']; ?></td>
                            <td width="26%" align="center"><?php echo $prodData['prod_dw_rom']; ?></td>
                            <td width="26%" align="center"><?php echo $prodData['clos_dw_rom']; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- GRADE-WISE PRODUCTION -->
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td align="left" class="welcome-signout">
                    <span class="welcome-signout"><?php echo $label['gradewise_prod']['title']." (".strtoupper($partIIM1[0]).$subMin.")"; ?></span>
                </td>
            </tr>
            <tr>
                <td align="left" valign="top">
                    <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                        <tr>
                            <!--Below .added code add for solve the no and label issues added on 28 april 2014 added by ganesh satav -->
                            <?php if ($formNo == 8) { ?>
                                <td width="28%" align="left" valign="top" class="form-table-title"><?php echo $label['gradewise_prod'][0]; ?></td>                                                                                              
                            <?php }else { ?>
                            <td width="28%" align="left" valign="top" class="form-table-title">Grades (% of <?php echo html_entity_decode($chemRep); ?> content)</td>
                                <?php } ?>
                                <?php if ($formNo == 3) { ?>
                                <td width="16%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][1]; ?></td>
                            <?php } ?>
                            <td width="15%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][2]; ?></td>
                            <td width="13%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][3]; ?></td>
                            <td width="15%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][4]; ?></td>
                            <td width="15%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][5]; ?></td>
                            <td width="14%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][6]; ?></td>
                        </tr>
                        <tr>
                        <?php 

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

                        // if($_SESSION['lang']=='hindi'){ $prodGradeArray = $prodGradeArrayInHindi; }

                        $i = 1;
                        $feMinCount = 1;
                        // foreach ($gradeWiseProd[$minLow][0] as $gradeKey => $gradeVl) {
                        $gradeKy = $gradeWiseProd[$minLow]['gradeProd'];
                        $gradeVl = $gradeWiseProd[$minLow]['gradeProd']['gradeNames'];
                        foreach($gradeVl as $gradeKk => $mainGrade){

                        ?>
                            <?php if ($gradeKk != '') { ?>
                                <tr>
                                    <td colspan="7">
                                        <?php if ($gradeKy != '') { ?>
                                            <div style = "font-weight:bold; color:#001D31;text-align:left"<?php if ($i != 1) echo 'class = "welcome-page-name plus"'; ?>>
                                                <?php echo "(" . rome($feMinCount++) . ") " . $gradeKk; ?>
                                            </div>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php
                                $lilist = array('a'=>'क','b'=>'ख','c'=>'ग','d'=>'घ','e'=>'ड़','f'=>'च','g'=>'छ','h'=>'ज','i'=>'झ');
                                $feMinSubCount = 'a';
                                foreach ($mainGrade as $mainGradeKey => $mainGradeVal) {
                                    $tmpGradeFormName = "gradeForm" . $i;
                                    $gradeValues = $gradeWiseProd[$minLow]['gradeProd']['gradeValues'];

                                    ?>
                                    <tr>
                                        <td>
                                            <?php 
                                            // if($_SESSION['lang']=='hindi'){ 
                                            //     echo "(" . $lilist[$feMinSubCount++] . ") " . $gradeLbl; 
                                            // } else { 
                                            //     echo "(" . $feMinSubCount++ . ") " . $gradeLbl; 
                                            // } 

                                            echo "(" . $feMinSubCount++ . ") " . $mainGradeVal;

                                            ?>
                                        </td>
                                        <?php if ($formNo == 3) { ?>
                                            <?php if ($i < 7) { ?>
                                                <td>
                                                    <?php echo $gradeVal['average_grade']; ?>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <td>
                                            <?php echo $gradeValues[$mainGradeKey]['opening_stock']; ?>
                                        </td>
                                        <td>
                                            <?php echo $gradeValues[$mainGradeKey]['production']; ?>
                                        </td>
                                        <td>
                                            <?php echo $gradeValues[$mainGradeKey]['despatches']; ?>
                                        </td>
                                        <td>
                                            <?php echo $gradeValues[$mainGradeKey]['closing_stock']; ?>
                                        </td>
                                        <td>
                                            <?php echo $gradeValues[$mainGradeKey]['pmv']; ?>
                                        </td>
                                    </tr>
                            <?php  $i++; 	} 	?>
                        <?php } $tmpGradeFormName = "gradeForm" . $i;  ?>
                        </tr>
                    </table>
                </td>
            </tr>

            <?php if ($partIIM1['formNo'] == 8) { ?>
                <!--PULVERISATION-->
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td align="left" class="welcome-signout"><span><?php echo $label['pulverisation']['title']." (".strtoupper($partIIM1[0]).")"; ?></span></td>
                </tr>
                <tr>
                    <td>
                        <span><?php echo $label['pulverisation'][0]; ?></span>
                        <span><?php echo $isPulver =($pulverArr[$minLow][0]['is_pulverised'] == 1) ? $label['pulverisation'][1] : $label['pulverisation'][2]; ?></span>
                    </td>
                </tr>
                <?php if($isPulver == $label['pulverisation'][1]){ ?>
                    <tr>
                        <td align="left" class="welcome-signout"><span><?php echo $label['pulverisation'][3]." (".strtoupper($partIIM1[0]).")"; ?></span></td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
                            <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                <tr>
                                    <td align="center" class="form-table-title" rowspan="2"><?php echo $label['pulverisation'][4]; ?></td>
                                    <td align="center" class="form-table-title" rowspan="2"><?php echo $label['pulverisation'][5]; ?></td>
                                    <td align="center" class="form-table-title" colspan="2"><?php echo $label['pulverisation'][6]; ?></td>
                                    <td align="center" class="form-table-title" colspan="3"><?php echo $label['pulverisation'][7]; ?></td>
                                </tr>
                                <tr>
                                    <td align="center" class="form-table-title"><?php echo $label['pulverisation'][8]; ?></td>
                                    <td align="center" class="form-table-title"><?php echo $label['pulverisation'][9]; ?></td>
                                    <td align="center" class="form-table-title"><?php echo $label['pulverisation'][10]; ?></td>
                                    <td align="center" class="form-table-title"><?php echo $label['pulverisation'][11]; ?></td>
                                    <td align="center" class="form-table-title"><?php echo $label['pulverisation'][12]; ?></td>
                                </tr>
                                <?php
                                $pulArr = $pulverArr[$minLow];

                                for ($k = 0; $k < count($pulArr); $k++) {
                                    ?>
                                    <tr class="pr">
                                        <td align="center"><?php echo $pulverGrade[$minLow][$pulArr[$k]['grade_code']]; ?></td>
                                        <td align="center"><?php echo $pulArr[$k]['mineral_tot_qty']; ?></td>
                                        <td align="center"><?php echo $pulArr[$k]['produced_mesh_size']; ?></td>
                                        <td align="center"><?php echo $pulArr[$k]['produced_quantity']; ?></td>
                                        <td align="center"><?php echo $pulArr[$k]['sold_mesh_size']; ?></td>
                                        <td align="center"><?php echo $pulArr[$k]['sold_quantity']; ?></td>
                                        <td align="center"><?php echo $pulArr[$k]['sale_value']; ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" class="welcome-signout"><span><?php echo $label['pulverisation'][15] . ": ₹ " . $pulverArr[$minLow][0]['avg_cost'] . " " . $label['pulverisation'][17]; ?></span></td>
                    </tr>
                <?php } ?>
            <?php } ?>

            
            <!--DEDUCTION DETAILS-->
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td align="left" class="welcome-signout"><span><?php echo $label['deduct_detail']['title']." (".strtoupper($partIIM1[0]).$subMin.")"; ?></span></td>
            </tr>
            <tr>
                <td align="left" valign="top">
                    <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                        <tr>
                            <td width="55%" align="center" class="form-table-title"><?php echo $label['deduct_detail'][0]; ?></td>
                            <td width="19%" align="center" class="form-table-title"><?php echo $label['deduct_detail'][1]; ?></td>
                            <td width="26%" align="center" class="form-table-title"><?php echo $label['deduct_detail'][2]; ?></td>
                        </tr>
                        <tr height="60">
                            <td align="left" class="lable-text"><?php echo $label['deduct_detail'][3]; ?></td>
                            <td align="center"><?php echo $deductDetail[$minLow]['trans_cost']; ?></td>
                            <td align="center"><?php echo $deductDetail[$minLow]['trans_remark']; ?></td>
                        </tr>
                        <tr height="60">
                            <td align="left" class="lable-text"><?php echo $label['deduct_detail'][4]; ?></td>
                            <td align="center"><?php echo $deductDetail[$minLow]['loading_charges']; ?></td>
                            <td align="center"><?php echo $deductDetail[$minLow]['loading_remark']; ?></td>
                        </tr>
                        <tr height="60">
                            <td align="left" class="lable-text"><?php echo $label['deduct_detail'][5]; ?></td>
                            <td align="center"><?php echo $deductDetail[$minLow]['railway_freight']; ?></td>
                            <td align="center"><?php echo $deductDetail[$minLow]['railway_remark']; ?></td>
                        </tr>
                        <tr height="60">
                            <td align="left" class="lable-text"><?php echo $label['deduct_detail'][6]; ?></td>
                            <td align="center"><?php echo $deductDetail[$minLow]['port_handling']; ?></td>
                            <td align="center"><?php echo $deductDetail[$minLow]['port_remark']; ?></td>
                        </tr>
                        <tr height="60">
                            <td align="left" class="lable-text"><?php echo $label['deduct_detail'][7]; ?></td>
                            <td align="center"><?php echo $deductDetail[$minLow]['sampling_cost']; ?></td>
                            <td align="center"><?php echo $deductDetail[$minLow]['sampling_remark']; ?></td>
                        </tr>
                        <tr height="60">
                            <td align="left" class="lable-text"><?php echo $label['deduct_detail'][8]; ?></td>
                            <td align="center"><?php echo $deductDetail[$minLow]['plot_rent']; ?></td>
                            <td align="center"><?php echo $deductDetail[$minLow]['plot_remark']; ?></td>
                        </tr>
                        <tr height="60">
                            <td align="left" class="lable-text"><?php echo $label['deduct_detail'][9]; ?></td>
                            <td align="center"><?php echo $deductDetail[$minLow]['other_cost']; ?></td>
                            <td align="center"><?php echo $deductDetail[$minLow]['other_remark']; ?></td>
                        </tr>
                        <tr height="30">
                            <td align="left" class="total-bgcolor"><?php echo $label['deduct_detail'][10]; ?></td>
                            <td colspan="2" align="left" class="total-bgcolor">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="32%" align="right" class="welcome-page-name">
                                            <?php echo $deductDetail[$minLow]['total_prod']; ?></td>
                                        <td width="68%">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            
            <!--SALES/DISPATCHES-->
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td align="left" class="welcome-signout"><span><?php echo $label['sale_despatch']['title']." (".strtoupper($partIIM1[0]).$subMin.")"; ?></span></td>
            </tr>
            <tr>
                <td align="left" valign="top">
                    <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                    <tr>
                        <td height="28" align="center" valign="top" class="form-table-title">&nbsp;</td>
                        <td align="center" class="form-table-title">&nbsp;</td>
                        <td id="Domestic_1" colspan="4" align="center" class="form-table-title"><?php echo $label['sale_despatch'][0]; ?></td>
                        <td id="Export_1"colspan="3" align="center" class="form-table-title"><?php echo $label['sale_despatch'][1]; ?></td>
                    </tr>
                    <tr>
                        <td align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][2]; ?></td>
                        <td align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][3]; ?></td>
                        <td id="Domestic_2" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][4]; ?></td>
                        <td id="Domestic_3" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][5]; ?></td>
                        <td id="Domestic_4" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][6]; ?> (in <?php echo $unit[$minLow]; ?>)</td>
                        <td id="Domestic_5" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][7]; ?></td>
                        <td id="Export_2" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][8]; ?></td>
                        <td id="Export_3" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][9]; ?> (in <?php echo $unit[$minLow]; ?>)</td>
                        <td id="Export_4" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][10]; ?>
                        <?php for ($count = 0; $count < count($saleDespatch[$minLow]); $count++) { ?>
                            <tr>
                                <td align="center" valign="middle" class="lable-text"><?php 
                                if(isset($saleDespatchGrade[$minLow][$saleDespatch[$minLow][$count]['grade_code']])){
                                    echo $saleDespatchGrade[$minLow][$saleDespatch[$minLow][$count]['grade_code']];
                                } else {
                                    echo 'NIL';
                                }
                                ?></td>
                                <td align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['client_type']; ?></td>
                                <td id="Domestic_6" align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['client_reg_no']; ?></td>
                                <td id="Domestic_7" align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['client_name']; ?></td>
                                <td id="Domestic_8" align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['quantity']; ?></td>
                                <td id="Domestic_9" align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['sale_value']; ?></td>
                                <td id="Export_5" align="center" valign="middle"><?php 
                                    foreach($countryList[$minLow] as $key=>$val){
                                        if($val['id'] == $saleDespatch[$minLow][$count]['expo_country']){
                                            echo $val['country_name'];
                                        }
                                    }
                                ?></td>
                                <td id="Export_6" align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['expo_quantity']; ?></td>
                                <td id="Export_7" align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['expo_fob']; ?></td>
                            </tr>

                        <?php } ?>
                        <?php if($formNo == '5'){ ?>
                            <tr>
                                <td colspan="9"><?php echo $label['sale_despatch']['note']; ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="left" class="welcome-signout"><span><?php echo $label['sale_despatch'][11]; ?></span></td>
            </tr>
            <tr>
                </td>
                    <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                        <tr><!--   Remove the S form reason word. added by ganesh satav dated: 13 feb 14-->
                            <td width="21%" align="left" valign="top" class="form-table-title"><?php echo $label['sale_despatch'][13]; ?></td>
                        </tr>
                        <tr>
                            <td align="left" height="60" valign="top" class="lable-text">
                                <?php
                                // if ($formData[$i]['mineral'] == "mica") {
                                //     echo $formData[$i]['prodistocksF6']['crude']['REASON_ONE'];
                                // } else {                                                                                                                                                           print_r("uday");
                                //     echo $gradeValueArray['REASON_1'];
                                // }
                                echo $reasonData[$minLow]['reason_1'];
                                ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="left" class="welcome-signout"><span><?php echo $label['sale_despatch'][12]; ?></span></td>
            </tr>
            <tr>
                </td>
                    <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                        <tr><!--   Remove the S form reason word. added by ganesh satav dated: 13 feb 14-->
                            <td width="21%" align="left" valign="top" class="form-table-title"><?php echo $label['sale_despatch'][14]; ?></td>
                        </tr>
                        <tr>
                            <td align="left" height="60" valign="top" class="lable-text">
                                <?php
                                // if ($formData[$i]['mineral'] == "mica") {
                                //     echo $formData[$i]['prodistocksF6']['crude']['REASON_ONE'];
                                // } else {                                                                                                                                                           print_r("uday");
                                //     echo $gradeValueArray['REASON_1'];
                                // }
                                echo $reasonData[$minLow]['reason_2'];
                                ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <?php } ?>



            <!--Only for Magnetite if iron ore is the primary mineral-->
            <?php if ($is_hematite && $is_magnetite && strtolower($partIIM1[0]) == strtolower('Iron Ore')) { ?>
                <?php 
                // $title = "Part II For x";
                // $title .= ucwords(strtolower($partIIM1[0]));
                // $title .= ' (MAGNETITE)';
                // $mineral .= ' (MAGNETITE)';
                ?>

                
                <!-- PRINT TYPE OF ORE -->
                <div class="page-break" style="margin-left: 40px;width:90%">

                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-left:0px;margin-top:20px" align="center">
                        <tr><td height="5"></td></tr>
                        <tr><td>&nbsp;</td></tr>
                        </tr>
                        <tr>
                            <td align="left" class="welcome-page-name">
                                <div id="ore_type" style="border:0px solid #E5D0BD; margin-left:20px;width:100%">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr><td>&nbsp;</td></tr>
                                        <tr><td align="center" class="welcome-signout"><?php echo $label['ore_type']['title']; ?></td></tr>
                                        <tr><td>&nbsp;</td></tr>
                                        <tr><td align="left" class="lable-text"><?php echo $label['ore_type'][2]; ?><span align="left" class="lable-text" style="color:#CC0000"><?php if($oreType=='Hematite'){echo "(a) ".$oreType; }else{ echo "(b) ".$oreType; } ?></span></td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            
                
                <!--PRODUCTION / STOCKS (ROM)-->
                <?php 
                $prodData = $prodArr[$minLow]['magnetite'];
                $subMin = ($is_magnetite == true) ? ' (Magnetite) ' : '';
                ?>
                <tr>
                    <td align="left" class="welcome-signout"><span><?php echo $label['rom_stocks']['title']." (".strtoupper($partIIM1[0]).$subMin.")"; ?></span></td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                            <tr>
                                <td width="26%" align="center" valign="top" class="form-table-title"><?php echo $label['rom_stocks'][0]; ?></td>
                                <td align="center" class="form-table-title"><?php echo $label['rom_stocks'][1]; ?></td>
                                <td align="center" class="form-table-title"><?php echo $label['rom_stocks'][2]; ?></td>
                                <td align="center" class="form-table-title"><?php echo $label['rom_stocks'][3]; ?></td>
                            </tr>
                            <tr>
                                <td align="left" valign="top" class="lable-text"><?php echo $label['rom_stocks'][4]; ?></td>
                                <td width="26%" align="center"><?php echo $prodData['open_oc_rom']; ?></td>
                                <td width="26%" align="center"><?php echo $prodData['prod_oc_rom']; ?></td>
                                <td width="26%" align="center"><?php echo $prodData['clos_oc_rom']; ?></td>
                            </tr> 
                            <tr>
                                <td align="left" valign="top" class="lable-text"><?php echo $label['rom_stocks'][5]; ?></td>
                                <td width="26%" align="center"><?php echo $prodData['open_ug_rom']; ?></td>
                                <td width="26%" align="center"><?php echo $prodData['prod_ug_rom']; ?></td>
                                <td width="26%" align="center"><?php echo $prodData['clos_ug_rom']; ?></td>
                            </tr>
                            <tr>
                                <td align="left" valign="top" class="lable-text"><?php echo $label['rom_stocks'][6]; ?></td>
                                <td width="26%" align="center"><?php echo $prodData['open_dw_rom']; ?></td>
                                <td width="26%" align="center"><?php echo $prodData['prod_dw_rom']; ?></td>
                                <td width="26%" align="center"><?php echo $prodData['clos_dw_rom']; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>

                
                <!-- GRADE-WISE PRODUCTION -->
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td align="left" class="welcome-signout">
                        <span class="welcome-signout"><?php echo $label['gradewise_prod']['title']." (".strtoupper($partIIM1[0]).$subMin.")"; ?></span>
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                            <tr>
                                <!--Below .added code add for solve the no and label issues added on 28 april 2014 added by ganesh satav -->
                                <?php if ($formNo == 8) { ?>
                                    <td width="28%" align="left" valign="top" class="form-table-title"><?php echo $label['gradewise_prod'][0]; ?></td>                                                                                              
                                <?php }else { ?>
                                <td width="28%" align="left" valign="top" class="form-table-title">Grades (% of <?php echo html_entity_decode($chemRep); ?> content)</td>
                                    <?php } ?>
                                    <?php if ($formNo == 3) { ?>
                                    <td width="16%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][1]; ?></td>
                                <?php } ?>
                                <td width="15%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][2]; ?></td>
                                <td width="13%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][3]; ?></td>
                                <td width="15%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][4]; ?></td>
                                <td width="15%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][5]; ?></td>
                                <td width="14%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][6]; ?></td>
                            </tr>
                            <tr>
                            <?php 

                            // if($_SESSION['lang']=='hindi'){ $prodGradeArray = $prodGradeArrayInHindi; }

                            $i = 1;
                            $feMinCount = 1;
                            // foreach ($gradeWiseProd[$minLow][0] as $gradeKey => $gradeVl) {
                            $gradeKy = $gradeWiseProd[$minLow][1]['gradeProd'];
                            $gradeVl = $gradeWiseProd[$minLow][1]['gradeProd']['gradeNames'];
                            foreach($gradeVl as $gradeKk => $mainGrade){

                            ?>
                                <tr>
                                    <td colspan="7">
                                        <?php if ($gradeKy != '') { ?>
                                            <div style = "font-weight:bold; color:#001D31;text-align:left"<?php if ($i != 1) echo 'class = "welcome-page-name plus"'; ?>>
                                                <?php echo "(" . rome($feMinCount++) . ") " . $gradeKk; ?>
                                            </div>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php
                                    $lilist = array('a'=>'क','b'=>'ख','c'=>'ग','d'=>'घ','e'=>'ड़','f'=>'च','g'=>'छ','h'=>'ज','i'=>'झ');
                                    $feMinSubCount = 'a';
                                    foreach ($mainGrade as $mainGradeKey => $mainGradeVal) {
                                        $tmpGradeFormName = "gradeForm" . $i;
                                        $gradeValues = $gradeWiseProd[$minLow][1]['gradeProd']['gradeValues'];

                                        ?>
                                        <tr>
                                            <td>
                                                <?php 
                                                // if($_SESSION['lang']=='hindi'){ 
                                                //     echo "(" . $lilist[$feMinSubCount++] . ") " . $gradeLbl; 
                                                // } else { 
                                                //     echo "(" . $feMinSubCount++ . ") " . $gradeLbl; 
                                                // } 

                                                echo "(" . $feMinSubCount++ . ") " . $mainGradeVal;

                                                ?>
                                            </td>
                                            <?php if ($formNo == 3) { ?>
                                                <?php if ($i < 7) { ?>
                                                    <td>
                                                        <?php echo $gradeVal['average_grade']; ?>
                                                    </td>
                                                <?php } ?>
                                            <?php } ?>
                                            <td>
                                                <?php echo $gradeValues[$mainGradeKey]['opening_stock']; ?>
                                            </td>
                                            <td>
                                                <?php echo $gradeValues[$mainGradeKey]['production']; ?>
                                            </td>
                                            <td>
                                                <?php echo $gradeValues[$mainGradeKey]['despatches']; ?>
                                            </td>
                                            <td>
                                                <?php echo $gradeValues[$mainGradeKey]['closing_stock']; ?>
                                            </td>
                                            <td>
                                                <?php echo $gradeValues[$mainGradeKey]['pmv']; ?>
                                            </td>
                                        </tr>
                                <?php  $i++; 	} 	?>
                            <?php } $tmpGradeFormName = "gradeForm" . $i;  ?>
                            </tr>
                        </table>
                    </td>
                </tr>
                
            <?php } ?>

            
            <!--For associated minerals-->
            <?php 

            $mCount = '4';
            foreach ($partIIMOther as $partIIM) {

                $title = "Part II xd For ";
                $title.= ucwords(strtolower($partIIM[0]));
                $minLow = strtolower($partIIM[0]);
                $mineral = $partIIM[0];
                $ironSubMin = '';
                if(strtolower($partIIM[0]) == strtolower('Iron Ore')) {
                    if($is_hematite) {
                        $title.= ' (HEMATITE)';
                        $mineral.= ' (HEMATITE)';
                        $ironSubMin = "/hematite";
                    } elseif($is_magnetite) {
                        $title.= ' (MAGNETITE)';
                        $mineral.= ' (MAGNETITE)';
                        $ironSubMin = "/magnetite";
                    }
                }

                ?>

                <?php if($partIIM['formNo'] == 5) { ?>
                
                    Production / Stocks (ROM)<br>
                    
                    Ex-mine price<br>
                    
                    Recoveries at Concentrator<br>
                    
                    Recovery at the Smelter<br>
                    
                    Sales(Metals/By product)<br>
                    
                    Details of Deductions<br>
                    
                    Sales/Dispatches<br>
                            
                    <?php } elseif($partIIM['formNo'] == 7) { ?>
                        
                        <!--PRODUCTION / STOCKS (ROM)-->
                        <tr>
                            <td align="left" class="welcome-signout"><span><?php echo $label['rom_stocks_three']['title']." (".strtoupper($partIIM[0]).")"; ?></span></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top">
                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                    <thead class="thead-light text-center">
                                        <tr>
                                            <th colspan="2"><?php echo $label['rom_stocks_three'][0]; ?></th>
                                            <th><?php echo $label['rom_stocks_three'][1]; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $label['rom_stocks_three'][2]; ?></td>
                                            <td><?php echo ucfirst(strtolower($romDataThreeMinUnit[$minLow])); ?></td>
                                            <td>
                                                <?php echo $romDataThree[$minLow][0]['oc_qty']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $label['rom_stocks_three'][3]; ?></td>
                                            <td><?php echo ucfirst(strtolower($romDataThreeMinUnit[$minLow])); ?></td>
                                            <td>
                                                <?php echo $romDataThree[$minLow][0]['ug_qty']; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        
                        <!--PRODUCTION, STOCKS AND DESPATCHES-->
                        <tr>
                            <td align="left" class="welcome-signout"><span><?php echo $label['prod_stock_dis']['title']." (".strtoupper($partIIM[0]).")"; ?></span></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top">
                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                    <thead class="thead-light text-center">
                                        <tr>
                                            <th rowspan="3"></th>
                                            <th colspan="4"><?php echo $label['prod_stock_dis'][0]; ?></th>
                                            <th colspan="2" rowspan="2"><?php echo $label['prod_stock_dis'][1]; ?></th>
                                            <th colspan="2" rowspan="2"><?php echo $label['prod_stock_dis'][2]; ?></th>
                                        </tr>
                                        <tr>
                                            <th colspan="2"><?php echo $label['prod_stock_dis'][3]; ?></th>
                                            <th colspan="2"><?php echo $label['prod_stock_dis'][4]; ?></th>
                                        </tr>
                                        <tr>
                                            <th><?php echo $label['prod_stock_dis'][5]; ?></th>
                                            <th><?php echo $label['prod_stock_dis'][6]; ?></th>
                                            <th><?php echo $label['prod_stock_dis'][5]; ?></th>
                                            <th><?php echo $label['prod_stock_dis'][6]; ?></th>
                                            <th><?php echo $label['prod_stock_dis'][5]; ?></th>
                                            <th><?php echo $label['prod_stock_dis'][6]; ?></th>
                                            <th><?php echo $label['prod_stock_dis'][5]; ?></th>
                                            <th><?php echo $label['prod_stock_dis'][6]; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $label['prod_stock_dis'][7]; ?></td>
                                            <td>
                                                <?php echo $roughStone[$minLow][0]['open_tot_no']; ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?php echo $roughStone[$minLow][0]['open_tot_qty']; ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?php echo ucfirst(strtolower($romDataThreeMinUnit[$minLow])); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo $cutStone[$minLow][0]['open_tot_no']; ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?php echo $cutStone[$minLow][0]['open_tot_qty']; ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?php echo ucfirst(strtolower($romDataThreeMinUnit[$minLow])); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo $indStone[$minLow][0]['open_tot_no']; ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?php echo $indStone[$minLow][0]['open_tot_qty']; ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?php echo ucfirst(strtolower($romDataThreeMinUnit[$minLow])); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo $othStone[$minLow][0]['open_tot_no']; ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?php echo $othStone[$minLow][0]['open_tot_qty']; ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?php echo ucfirst(strtolower($romDataThreeMinUnit[$minLow])); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="9"><?php echo $label['prod_stock_dis'][8]; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $label['prod_stock_dis'][9]; ?></td>
                                            <td>
                                                <?php echo $roughStone[$minLow][0]['prod_oc_no']; ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?php echo $roughStone[$minLow][0]['prod_oc_qty']; ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?php echo ucfirst(strtolower($romDataThreeMinUnit[$minLow])); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo $cutStone[$minLow][0]['prod_oc_no']; ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?php echo $cutStone[$minLow][0]['prod_oc_qty']; ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?php echo ucfirst(strtolower($romDataThreeMinUnit[$minLow])); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo $indStone[$minLow][0]['prod_oc_no']; ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?php echo $indStone[$minLow][0]['prod_oc_qty']; ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?php echo ucfirst(strtolower($romDataThreeMinUnit[$minLow])); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo $othStone[$minLow][0]['prod_oc_no']; ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?php echo $othStone[$minLow][0]['prod_oc_qty']; ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?php echo ucfirst(strtolower($romDataThreeMinUnit[$minLow])); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $label['prod_stock_dis'][10]; ?></td>
                                            <td>
                                                <?php echo $roughStone[$minLow][0]['prod_ug_no']; ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?php echo $roughStone[$minLow][0]['prod_ug_qty']; ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?php echo ucfirst(strtolower($romDataThreeMinUnit[$minLow])); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo $cutStone[$minLow][0]['prod_ug_no']; ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?php echo $cutStone[$minLow][0]['prod_ug_qty']; ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?php echo ucfirst(strtolower($romDataThreeMinUnit[$minLow])); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo $indStone[$minLow][0]['prod_ug_no']; ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?php echo $indStone[$minLow][0]['prod_ug_qty']; ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?php echo ucfirst(strtolower($romDataThreeMinUnit[$minLow])); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo $othStone[$minLow][0]['prod_ug_no']; ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?php echo $othStone[$minLow][0]['prod_ug_qty']; ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?php echo ucfirst(strtolower($romDataThreeMinUnit[$minLow])); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="bg-light">
                                            <td><?php echo $label['prod_stock_dis'][11]; ?></td>
                                            <td>
                                                <?php $roughStone[$minLow][0]['prod_tot_no']; ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?php $roughStone[$minLow][0]['prod_tot_qty']; ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?php echo ucfirst(strtolower($romDataThreeMinUnit[$minLow])); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php $cutStone[$minLow][0]['prod_tot_no']; ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?php echo $cutStone[$minLow][0]['prod_tot_qty']; ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?php echo ucfirst(strtolower($romDataThreeMinUnit[$minLow])); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo $indStone[$minLow][0]['prod_tot_no']; ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?php echo $indStone[$minLow][0]['prod_tot_qty']; ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?php echo ucfirst(strtolower($romDataThreeMinUnit[$minLow])); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo $othStone[$minLow][0]['prod_tot_no']; ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?php echo $othStone[$minLow][0]['prod_tot_qty']; ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?php echo ucfirst(strtolower($romDataThreeMinUnit[$minLow])); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $label['prod_stock_dis'][12]; ?></td>
                                            <td>
                                                <?php echo $roughStone[$minLow][0]['desp_tot_no']; ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?php echo $roughStone[$minLow][0]['desp_tot_qty']; ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?php echo ucfirst(strtolower($romDataThreeMinUnit[$minLow])); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo $cutStone[$minLow][0]['desp_tot_no']; ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?php echo $cutStone[$minLow][0]['desp_tot_qty']; ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?php echo ucfirst(strtolower($romDataThreeMinUnit[$minLow])); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo $indStone[$minLow][0]['desp_tot_no']; ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?php echo $indStone[$minLow][0]['desp_tot_qty']; ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?php echo ucfirst(strtolower($romDataThreeMinUnit[$minLow])); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo $othStone[$minLow][0]['desp_tot_no']; ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?php echo $othStone[$minLow][0]['desp_tot_qty']; ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?php echo ucfirst(strtolower($romDataThreeMinUnit[$minLow])); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $label['prod_stock_dis'][13]; ?></td>
                                            <td>
                                                <?php echo $roughStone[$minLow][0]['clos_tot_no']; ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?php echo $roughStone[$minLow][0]['clos_tot_qty']; ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?php echo ucfirst(strtolower($romDataThreeMinUnit[$minLow])); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo $cutStone[$minLow][0]['clos_tot_no']; ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?php echo $cutStone[$minLow][0]['clos_tot_qty']; ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?php echo ucfirst(strtolower($romDataThreeMinUnit[$minLow])); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo $indStone[$minLow][0]['clos_tot_no']; ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?php echo $indStone[$minLow][0]['clos_tot_qty']; ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?php echo ucfirst(strtolower($romDataThreeMinUnit[$minLow])); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo $othStone[$minLow][0]['clos_tot_no']; ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?php echo $othStone[$minLow][0]['clos_tot_qty']; ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?php echo ucfirst(strtolower($romDataThreeMinUnit[$minLow])); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $label['prod_stock_dis'][14]; ?></td>
                                            <td colspan="2">
                                                <?php echo $roughStone[$minLow][0]['pmv_oc']; ?>
                                            </td>
                                            <td colspan="2">
                                                <?php echo $cutStone[$minLow][0]['pmv_oc']; ?>
                                            </td>
                                            <td colspan="2">
                                                <?php echo $indStone[$minLow][0]['pmv_oc']; ?>
                                            </td>
                                            <td colspan="2">
                                                <?php echo $othStone[$minLow][0]['pmv_oc']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="9"><?php echo $label['prod_stock_dis'][15]; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                        <!--DEDUCTION DETAILS-->
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td align="left" class="welcome-signout"><span><?php echo $label['deduct_detail']['title']." (".strtoupper($partIIM[0]).")"; ?></span></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top">
                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                    <tr>
                                        <td width="55%" align="center" class="form-table-title"><?php echo $label['deduct_detail'][0]; ?></td>
                                        <td width="19%" align="center" class="form-table-title"><?php echo $label['deduct_detail'][1]; ?></td>
                                        <td width="26%" align="center" class="form-table-title"><?php echo $label['deduct_detail'][2]; ?></td>
                                    </tr>
                                <tr height="60">
                                    <td align="left" class="lable-text"><?php echo $label['deduct_detail'][3]; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['trans_cost']; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['trans_remark']; ?></td>
                                </tr>
                                <tr height="60">
                                    <td align="left" class="lable-text"><?php echo $label['deduct_detail'][4]; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['loading_charges']; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['loading_remark']; ?></td>
                                </tr>
                                <tr height="60">
                                    <td align="left" class="lable-text"><?php echo $label['deduct_detail'][5]; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['railway_freight']; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['railway_remark']; ?></td>
                                </tr>
                                <tr height="60">
                                    <td align="left" class="lable-text"><?php echo $label['deduct_detail'][6]; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['port_handling']; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['port_remark']; ?></td>
                                </tr>
                                <tr height="60">
                                    <td align="left" class="lable-text"><?php echo $label['deduct_detail'][7]; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['sampling_cost']; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['sampling_remark']; ?></td>
                                </tr>
                                <tr height="60">
                                    <td align="left" class="lable-text"><?php echo $label['deduct_detail'][8]; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['plot_rent']; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['plot_remark']; ?></td>
                                </tr>
                                <tr height="60">
                                    <td align="left" class="lable-text"><?php echo $label['deduct_detail'][9]; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['other_cost']; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['other_remark']; ?></td>
                                </tr>
                                <tr height="30">
                                    <td align="left" class="total-bgcolor"><?php echo $label['deduct_detail'][10]; ?></td>
                                    <td colspan="2" align="left" class="total-bgcolor">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="32%" align="right" class="welcome-page-name">
                                                    <?php echo $deductDetail[$minLow]['total_prod']; ?></td>
                                                <td width="68%">&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                </table>
                            </td>
                        </tr>


                        <!--SALES/DISPATCHES-->
                        <br><br>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td align="left" class="welcome-signout"><span><?php echo $label['sale_despatch']['title']." (".strtoupper($partIIM[0]).")"; ?></span></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top">
                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                    <tr>
                                        <td height="28" align="center" valign="top" class="form-table-title">&nbsp;</td>
                                        <td align="center" class="form-table-title">&nbsp;</td>
                                        <td id="Domestic_1" colspan="4" align="center" class="form-table-title"><?php echo $label['sale_despatch'][0]; ?></td>
                                        <td id="Export_1"colspan="3" align="center" class="form-table-title"><?php echo $label['sale_despatch'][1]; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][2]; ?></td>
                                        <td align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][3]; ?></td>
                                        <td id="Domestic_2" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][4]; ?></td>
                                        <td id="Domestic_3" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][5]; ?></td>
                                        <td id="Domestic_4" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][6]; ?> (in <?php echo $unit[$minLow]; ?>)</td>
                                        <td id="Domestic_5" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][7]; ?></td>
                                        <td id="Export_2" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][8]; ?></td>
                                        <td id="Export_3" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][9]; ?> (in <?php echo $unit[$minLow]; ?>)</td>
                                        <td id="Export_4" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][10]; ?></td>
                                    </tr>
                                    <?php for ($count = 0; $count < count($saleDespatch[$minLow]); $count++) { ?>
                                        <tr>
                                            <td align="center" valign="middle" class="lable-text"><?php 
                                            if(isset($saleDespatchGrade[$minLow][$saleDespatch[$minLow][$count]['grade_code']])){
                                                echo $saleDespatchGrade[$minLow][$saleDespatch[$minLow][$count]['grade_code']];
                                            } else {
                                                echo 'NIL';
                                            }
                                            ?></td>
                                            <td align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['client_type']; ?></td>
                                            <td id="Domestic_6" align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['client_reg_no']; ?></td>
                                            <td id="Domestic_7" align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['client_name']; ?></td>
                                            <td id="Domestic_8" align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['quantity']; ?></td>
                                            <td id="Domestic_9" align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['sale_value']; ?></td>
                                            <td id="Export_5" align="center" valign="middle"><?php 
                                                foreach($countryList[$minLow] as $key=>$val){
                                                    if($val['id'] == $saleDespatch[$minLow][$count]['expo_country']){
                                                        echo $val['country_name'];
                                                    }
                                                }
                                            ?></td>
                                            <td id="Export_6" align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['expo_quantity']; ?></td>
                                            <td id="Export_7" align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['expo_fob']; ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if($formNo == '5'){ ?>
                                        <tr>
                                            <td colspan="9"><?php echo $label['sale_despatch']['note']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                        </tr>
                        <br><br>
                        <tr>
                            <td align="left" class="welcome-signout"><span><?php echo $label['sale_despatch'][11]; ?></span></td>
                        </tr>
                        <tr>
                            </td>
                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                    <tr><!--   Remove the S form reason word. added by ganesh satav dated: 13 feb 14-->
                                        <td width="21%" align="left" valign="top" class="form-table-title"><?php echo $label['sale_despatch'][13]; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left" height="60" valign="top" class="lable-text">
                                            <?php
                                            // if ($formData[$i]['mineral'] == "mica") {
                                            //     echo $formData[$i]['prodistocksF6']['crude']['REASON_ONE'];
                                            // } else {                                                                                                                                                           print_r("uday");
                                            //     echo $gradeValueArray['REASON_1'];
                                            // }
                                            echo $reasonData[$minLow]['reason_1'];
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <br><br>
                        <tr>
                            <td align="left" class="welcome-signout"><span><?php echo $label['sale_despatch'][12]; ?></span></td>
                        </tr>
                        <tr>
                            </td>
                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                    <tr><!--   Remove the S form reason word. added by ganesh satav dated: 13 feb 14-->
                                        <td width="21%" align="left" valign="top" class="form-table-title"><?php echo $label['sale_despatch'][14]; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left" height="60" valign="top" class="lable-text">
                                            <?php
                                            // if ($formData[$i]['mineral'] == "mica") {
                                            //     echo $formData[$i]['prodistocksF6']['crude']['REASON_ONE'];
                                            // } else {                                                                                                                                                           print_r("uday");
                                            //     echo $gradeValueArray['REASON_1'];
                                            // }
                                            echo $reasonData[$minLow]['reason_2'];
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                    <?php } else { ?>

                        <?php if (strtolower($partIIM[0]) == strtolower('Iron Ore')) { ?>
                                Type of ore
                        <?php } ?>

                        <!--Production / Stocks (ROM)-->
                        <br><br>
                        <tr><td>&nbsp;</td></tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td align="left" class="welcome-signout"><span><?php echo $label['rom_stocks']['title']." (".strtoupper($partIIM[0]).")"; ?></span></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top">
                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                    <tr>
                                        <td width="26%" align="center" valign="top" class="form-table-title"><?php echo $label['rom_stocks'][0]; ?></td>
                                        <td align="center" class="form-table-title"><?php echo $label['rom_stocks'][1]; ?></td>
                                        <td align="center" class="form-table-title"><?php echo $label['rom_stocks'][2]; ?></td>
                                        <td align="center" class="form-table-title"><?php echo $label['rom_stocks'][3]; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top" class="lable-text"><?php echo $label['rom_stocks'][4]; ?></td>
                                        <td width="26%" align="center"><?php echo $prodArr[$minLow]['open_oc_rom']; ?></td>
                                        <td width="26%" align="center"><?php echo $prodArr[$minLow]['prod_oc_rom']; ?></td>
                                        <td width="26%" align="center"><?php echo $prodArr[$minLow]['clos_oc_rom']; ?></td>
                                    </tr> 
                                    <tr>
                                        <td align="left" valign="top" class="lable-text"><?php echo $label['rom_stocks'][5]; ?></td>
                                        <td width="26%" align="center"><?php echo $prodArr[$minLow]['open_ug_rom']; ?></td>
                                        <td width="26%" align="center"><?php echo $prodArr[$minLow]['prod_ug_rom']; ?></td>
                                        <td width="26%" align="center"><?php echo $prodArr[$minLow]['clos_ug_rom']; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top" class="lable-text"><?php echo $label['rom_stocks'][6]; ?></td>
                                        <td width="26%" align="center"><?php echo $prodArr[$minLow]['open_dw_rom']; ?></td>
                                        <td width="26%" align="center"><?php echo $prodArr[$minLow]['prod_dw_rom']; ?></td>
                                        <td width="26%" align="center"><?php echo $prodArr[$minLow]['clos_dw_rom']; ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        
                        <!-- GRADE-WISE PRODUCTION -->
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="left" class="welcome-signout">
                                <span class="welcome-signout"><?php echo $label['gradewise_prod']['title']." (".strtoupper($partIIM[0]).")"; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="top">
                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                    <tr>
                                        <!--Below .added code add for solve the no and label issues added on 28 april 2014 added by ganesh satav -->
                                        <?php if ($formNo == 8) { ?>
                                            <td width="28%" align="left" valign="top" class="form-table-title"><?php echo $label['gradewise_prod'][0]; ?></td>                                                                                              
                                        <?php }else { ?>
                                        <td width="28%" align="left" valign="top" class="form-table-title">Grades (% of <?php echo html_entity_decode($chemRep); ?> content)</td>
                                            <?php } ?>
                                            <?php if ($formNo == 3) { ?>
                                            <td width="16%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][1]; ?></td>
                                        <?php } ?>
                                        <td width="15%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][2]; ?></td>
                                        <td width="13%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][3]; ?></td>
                                        <td width="15%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][4]; ?></td>
                                        <td width="15%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][5]; ?></td>
                                        <td width="14%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][6]; ?></td>
                                    </tr>
                                    <tr>
                                    <?php 

                                    // if($_SESSION['lang']=='hindi'){ $prodGradeArray = $prodGradeArrayInHindi; }

                                    $i = 1;
                                    $feMinCount = 1;
                                    // foreach ($gradeWiseProd[$minLow][0] as $gradeKey => $gradeVl) {
                                    $gradeKy = $gradeWiseProd[$minLow]['gradeProd'];
                                    $gradeVl = $gradeWiseProd[$minLow]['gradeProd']['gradeNames'];
                                    foreach($gradeVl as $gradeKk => $mainGrade){

                                    ?>
                                        <?php if ($gradeKk != '') { ?>
                                            <tr>
                                                <td colspan="7">
                                                    <?php if ($gradeKy != '') { ?>
                                                        <div style = "font-weight:bold; color:#001D31;text-align:left"<?php if ($i != 1) echo 'class = "welcome-page-name plus"'; ?>>
                                                            <?php echo "(" . rome($feMinCount++) . ") " . $gradeKk; ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <?php
                                            $lilist = array('a'=>'क','b'=>'ख','c'=>'ग','d'=>'घ','e'=>'ड़','f'=>'च','g'=>'छ','h'=>'ज','i'=>'झ');
                                            $feMinSubCount = 'a';
                                            foreach ($mainGrade as $mainGradeKey => $mainGradeVal) {
                                                $tmpGradeFormName = "gradeForm" . $i;
                                                $gradeValues = $gradeWiseProd[$minLow]['gradeProd']['gradeValues'];

                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php 
                                                        // if($_SESSION['lang']=='hindi'){ 
                                                        //     echo "(" . $lilist[$feMinSubCount++] . ") " . $gradeLbl; 
                                                        // } else { 
                                                        //     echo "(" . $feMinSubCount++ . ") " . $gradeLbl; 
                                                        // } 

                                                        echo "(" . $feMinSubCount++ . ") " . $mainGradeVal;

                                                        ?>
                                                    </td>
                                                    <?php if ($formNo == 3) { ?>
                                                        <?php if ($i < 7) { ?>
                                                            <td>
                                                                <?php echo $gradeVal['average_grade']; ?>
                                                            </td>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    <td>
                                                        <?php echo $gradeValues[$mainGradeKey]['opening_stock']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $gradeValues[$mainGradeKey]['production']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $gradeValues[$mainGradeKey]['despatches']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $gradeValues[$mainGradeKey]['closing_stock']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $gradeValues[$mainGradeKey]['pmv']; ?>
                                                    </td>
                                                </tr>
                                        <?php  $i++; 	} 	?>
                                    <?php } $tmpGradeFormName = "gradeForm" . $i;  ?>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                            
                        <?php if ($partIIM['formNo'] == 8) { ?>
                                        
                            <!--PULVERISATION-->
                            <br><br>
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                <td align="left" class="welcome-signout"><span><?php echo $label['pulverisation']['title']." (".strtoupper($partIIM[0]).")"; ?></span></td>
                            </tr>
                            <tr>
                                <td>
                                    <span><?php echo $label['pulverisation'][0]; ?></span>
                                    <span><?php echo $isPulver =($pulverArr[$minLow][0]['is_pulverised'] == 1) ? $label['pulverisation'][1] : $label['pulverisation'][2]; ?></span>
                                </td>
                            </tr>
                            <?php if($isPulver == $label['pulverisation'][1]){ ?>
                                <tr>
                                    <td align="left" class="welcome-signout"><span><?php echo $label['pulverisation'][3]." (".strtoupper($partIIM[0]).")"; ?></span></td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top">
                                        <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                            <tr>
                                                <td align="center" class="form-table-title" rowspan="2"><?php echo $label['pulverisation'][4]; ?></td>
                                                <td align="center" class="form-table-title" rowspan="2"><?php echo $label['pulverisation'][5]; ?></td>
                                                <td align="center" class="form-table-title" colspan="2"><?php echo $label['pulverisation'][6]; ?></td>
                                                <td align="center" class="form-table-title" colspan="3"><?php echo $label['pulverisation'][7]; ?></td>
                                            </tr>
                                            <tr>
                                                <td align="center" class="form-table-title"><?php echo $label['pulverisation'][8]; ?></td>
                                                <td align="center" class="form-table-title"><?php echo $label['pulverisation'][9]; ?></td>
                                                <td align="center" class="form-table-title"><?php echo $label['pulverisation'][10]; ?></td>
                                                <td align="center" class="form-table-title"><?php echo $label['pulverisation'][11]; ?></td>
                                                <td align="center" class="form-table-title"><?php echo $label['pulverisation'][12]; ?></td>
                                            </tr>
                                            <?php
                                            $pulArr = $pulverArr[$minLow];

                                            for ($k = 0; $k < count($pulArr); $k++) {
                                                ?>
                                                <tr class="pr">
                                                    <td align="center"><?php echo $pulverGrade[$minLow][$pulArr[$k]['grade_code']]; ?></td>
                                                    <td align="center"><?php echo $pulArr[$k]['mineral_tot_qty']; ?></td>
                                                    <td align="center"><?php echo $pulArr[$k]['produced_mesh_size']; ?></td>
                                                    <td align="center"><?php echo $pulArr[$k]['produced_quantity']; ?></td>
                                                    <td align="center"><?php echo $pulArr[$k]['sold_mesh_size']; ?></td>
                                                    <td align="center"><?php echo $pulArr[$k]['sold_quantity']; ?></td>
                                                    <td align="center"><?php echo $pulArr[$k]['sale_value']; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="welcome-signout"><span><?php echo $label['pulverisation'][15] . ": ₹ " . $pulverArr[$minLow][0]['avg_cost'] . " " . $label['pulverisation'][17]; ?></span></td>
                                </tr>
                            <?php } ?>
                                
                        <?php } ?>
                        
                        <br><br>
                        <!--DEDUCTION DETAILS-->
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td align="left" class="welcome-signout"><span><?php echo $label['deduct_detail']['title']." (".strtoupper($partIIM[0]).")"; ?></span></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top">
                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                    <tr>
                                        <td width="55%" align="center" class="form-table-title"><?php echo $label['deduct_detail'][0]; ?></td>
                                        <td width="19%" align="center" class="form-table-title"><?php echo $label['deduct_detail'][1]; ?></td>
                                        <td width="26%" align="center" class="form-table-title"><?php echo $label['deduct_detail'][2]; ?></td>
                                    </tr>
                                <tr height="60">
                                    <td align="left" class="lable-text"><?php echo $label['deduct_detail'][3]; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['trans_cost']; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['trans_remark']; ?></td>
                                </tr>
                                <tr height="60">
                                    <td align="left" class="lable-text"><?php echo $label['deduct_detail'][4]; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['loading_charges']; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['loading_remark']; ?></td>
                                </tr>
                                <tr height="60">
                                    <td align="left" class="lable-text"><?php echo $label['deduct_detail'][5]; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['railway_freight']; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['railway_remark']; ?></td>
                                </tr>
                                <tr height="60">
                                    <td align="left" class="lable-text"><?php echo $label['deduct_detail'][6]; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['port_handling']; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['port_remark']; ?></td>
                                </tr>
                                <tr height="60">
                                    <td align="left" class="lable-text"><?php echo $label['deduct_detail'][7]; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['sampling_cost']; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['sampling_remark']; ?></td>
                                </tr>
                                <tr height="60">
                                    <td align="left" class="lable-text"><?php echo $label['deduct_detail'][8]; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['plot_rent']; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['plot_remark']; ?></td>
                                </tr>
                                <tr height="60">
                                    <td align="left" class="lable-text"><?php echo $label['deduct_detail'][9]; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['other_cost']; ?></td>
                                    <td align="center"><?php echo $deductDetail[$minLow]['other_remark']; ?></td>
                                </tr>
                                <tr height="30">
                                    <td align="left" class="total-bgcolor"><?php echo $label['deduct_detail'][10]; ?></td>
                                    <td colspan="2" align="left" class="total-bgcolor">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="32%" align="right" class="welcome-page-name">
                                                    <?php echo $deductDetail[$minLow]['total_prod']; ?></td>
                                                <td width="68%">&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                </table>
                            </td>
                        </tr>
                            
                        
                        <!--SALES/DISPATCHES-->
                        <br><br>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td align="left" class="welcome-signout"><span><?php echo $label['sale_despatch']['title']." (".strtoupper($partIIM[0]).")"; ?></span></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top">
                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                    <tr>
                                        <td height="28" align="center" valign="top" class="form-table-title">&nbsp;</td>
                                        <td align="center" class="form-table-title">&nbsp;</td>
                                        <td id="Domestic_1" colspan="4" align="center" class="form-table-title"><?php echo $label['sale_despatch'][0]; ?></td>
                                        <td id="Export_1"colspan="3" align="center" class="form-table-title"><?php echo $label['sale_despatch'][1]; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][2]; ?></td>
                                        <td align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][3]; ?></td>
                                        <td id="Domestic_2" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][4]; ?></td>
                                        <td id="Domestic_3" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][5]; ?></td>
                                        <td id="Domestic_4" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][6]; ?> (in <?php echo $unit[$minLow]; ?>)</td>
                                        <td id="Domestic_5" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][7]; ?></td>
                                        <td id="Export_2" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][8]; ?></td>
                                        <td id="Export_3" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][9]; ?> (in <?php echo $unit[$minLow]; ?>)</td>
                                        <td id="Export_4" align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][10]; ?></td>
                                    </tr>
                                    <?php for ($count = 0; $count < count($saleDespatch[$minLow]); $count++) { ?>
                                        <tr>
                                            <td align="center" valign="middle" class="lable-text"><?php 
                                            if(isset($saleDespatchGrade[$minLow][$saleDespatch[$minLow][$count]['grade_code']])){
                                                echo $saleDespatchGrade[$minLow][$saleDespatch[$minLow][$count]['grade_code']];
                                            } else {
                                                echo 'NIL';
                                            }
                                            ?></td>
                                            <td align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['client_type']; ?></td>
                                            <td id="Domestic_6" align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['client_reg_no']; ?></td>
                                            <td id="Domestic_7" align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['client_name']; ?></td>
                                            <td id="Domestic_8" align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['quantity']; ?></td>
                                            <td id="Domestic_9" align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['sale_value']; ?></td>
                                            <td id="Export_5" align="center" valign="middle"><?php 
                                                foreach($countryList[$minLow] as $key=>$val){
                                                    if($val['id'] == $saleDespatch[$minLow][$count]['expo_country']){
                                                        echo $val['country_name'];
                                                    }
                                                }
                                            ?></td>
                                            <td id="Export_6" align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['expo_quantity']; ?></td>
                                            <td id="Export_7" align="center" valign="middle"><?php echo $saleDespatch[$minLow][$count]['expo_fob']; ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if($formNo == '5'){ ?>
                                        <tr>
                                            <td colspan="9"><?php echo $label['sale_despatch']['note']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                        </tr>
                        <br><br>
                        <tr>
                            <td align="left" class="welcome-signout"><span><?php echo $label['sale_despatch'][11]; ?></span></td>
                        </tr>
                        <tr>
                            </td>
                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                    <tr><!--   Remove the S form reason word. added by ganesh satav dated: 13 feb 14-->
                                        <td width="21%" align="left" valign="top" class="form-table-title"><?php echo $label['sale_despatch'][13]; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left" height="60" valign="top" class="lable-text">
                                            <?php
                                            // if ($formData[$i]['mineral'] == "mica") {
                                            //     echo $formData[$i]['prodistocksF6']['crude']['REASON_ONE'];
                                            // } else {                                                                                                                                                           print_r("uday");
                                            //     echo $gradeValueArray['REASON_1'];
                                            // }
                                            echo $reasonData[$minLow]['reason_1'];
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <br><br>
                        <tr>
                            <td align="left" class="welcome-signout"><span><?php echo $label['sale_despatch'][12]; ?></span></td>
                        </tr>
                        <tr>
                            </td>
                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                    <tr><!--   Remove the S form reason word. added by ganesh satav dated: 13 feb 14-->
                                        <td width="21%" align="left" valign="top" class="form-table-title"><?php echo $label['sale_despatch'][14]; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left" height="60" valign="top" class="lable-text">
                                            <?php
                                            // if ($formData[$i]['mineral'] == "mica") {
                                            //     echo $formData[$i]['prodistocksF6']['crude']['REASON_ONE'];
                                            // } else {                                                                                                                                                           print_r("uday");
                                            //     echo $gradeValueArray['REASON_1'];
                                            // }
                                            echo $reasonData[$minLow]['reason_2'];
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                                
                    <?php } ?>
                    
                <?php } ?>

                <?php 
                foreach ($partIIMOther as $partIIM) { ?>

                <!--Only for Magnetite if iron ore is the associative mineral-->
                <?php if ($is_hematite && $is_magnetite && strtolower($partIIM[0]) == strtolower('Iron Ore')) { ?>
                <?php 
                $title = "Part II okl For ";
                $title.= ucwords(strtolower($partIIM[0]));
                $mineral = $partIIM[0];
                $title.= ' (MAGNETITE)';
                $mineral.= ' (MAGNETITE)';
                echo $title;
                ?>
                    
                    <!--PRODUCTION / STOCKS (ROM)-->
                    <?php 
                    $prodData = (strtolower($partIIM[0]) == strtolower('Iron Ore')) ? $prodArr[$minLow]['hematite'] : $prodArr[$minLow];
                    $subMin = ($is_hematite == true) ? ' (Hematite) ' : '';
                    ?>
                    <tr>
                        <td align="left" class="welcome-signout"><span><?php echo $label['rom_stocks']['title']." (".strtoupper($partIIM1[0]).$subMin.")"; ?></span></td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
                            <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                <tr>
                                    <td width="26%" align="center" valign="top" class="form-table-title"><?php echo $label['rom_stocks'][0]; ?></td>
                                    <td align="center" class="form-table-title"><?php echo $label['rom_stocks'][1]; ?></td>
                                    <td align="center" class="form-table-title"><?php echo $label['rom_stocks'][2]; ?></td>
                                    <td align="center" class="form-table-title"><?php echo $label['rom_stocks'][3]; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top" class="lable-text"><?php echo $label['rom_stocks'][4]; ?></td>
                                    <td width="26%" align="center"><?php echo $prodData['open_oc_rom']; ?></td>
                                    <td width="26%" align="center"><?php echo $prodData['prod_oc_rom']; ?></td>
                                    <td width="26%" align="center"><?php echo $prodData['clos_oc_rom']; ?></td>
                                </tr> 
                                <tr>
                                    <td align="left" valign="top" class="lable-text"><?php echo $label['rom_stocks'][5]; ?></td>
                                    <td width="26%" align="center"><?php echo $prodData['open_ug_rom']; ?></td>
                                    <td width="26%" align="center"><?php echo $prodData['prod_ug_rom']; ?></td>
                                    <td width="26%" align="center"><?php echo $prodData['clos_ug_rom']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top" class="lable-text"><?php echo $label['rom_stocks'][6]; ?></td>
                                    <td width="26%" align="center"><?php echo $prodData['open_dw_rom']; ?></td>
                                    <td width="26%" align="center"><?php echo $prodData['prod_dw_rom']; ?></td>
                                    <td width="26%" align="center"><?php echo $prodData['clos_dw_rom']; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
            
                    <!-- GRADE-WISE PRODUCTION -->
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" class="welcome-signout">
                            <span class="welcome-signout"><?php echo $label['gradewise_prod']['title']." (".strtoupper($partIIM1[0]).$subMin.")"; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
                            <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                <tr>
                                    <!--Below .added code add for solve the no and label issues added on 28 april 2014 added by ganesh satav -->
                                    <?php if ($formNo == 8) { ?>
                                        <td width="28%" align="left" valign="top" class="form-table-title"><?php echo $label['gradewise_prod'][0]; ?></td>                                                                                              
                                    <?php }else { ?>
                                    <td width="28%" align="left" valign="top" class="form-table-title">Grades (% of <?php echo html_entity_decode($chemRep); ?> content)</td>
                                        <?php } ?>
                                        <?php if ($formNo == 3) { ?>
                                        <td width="16%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][1]; ?></td>
                                    <?php } ?>
                                    <td width="15%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][2]; ?></td>
                                    <td width="13%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][3]; ?></td>
                                    <td width="15%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][4]; ?></td>
                                    <td width="15%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][5]; ?></td>
                                    <td width="14%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][6]; ?></td>
                                </tr>
                                <tr>
                                <?php 

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

                                // if($_SESSION['lang']=='hindi'){ $prodGradeArray = $prodGradeArrayInHindi; }

                                $i = 1;
                                $feMinCount = 1;
                                // foreach ($gradeWiseProd[$minLow][0] as $gradeKey => $gradeVl) {
                                $gradeKy = $gradeWiseProd[$minLow][0]['gradeProd'];
                                $gradeVl = $gradeWiseProd[$minLow][0]['gradeProd']['gradeNames'];
                                foreach($gradeVl as $gradeKk => $mainGrade){

                                ?>
                                    <?php if ($gradeKk != '') { ?>
                                        <tr>
                                            <td colspan="7">
                                                <?php if ($gradeKy != '') { ?>
                                                    <div style = "font-weight:bold; color:#001D31;text-align:left"<?php if ($i != 1) echo 'class = "welcome-page-name plus"'; ?>>
                                                        <?php echo "(" . rome($feMinCount++) . ") " . $gradeKk; ?>
                                                    </div>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <?php
                                        $lilist = array('a'=>'क','b'=>'ख','c'=>'ग','d'=>'घ','e'=>'ड़','f'=>'च','g'=>'छ','h'=>'ज','i'=>'झ');
                                        $feMinSubCount = 'a';
                                        foreach ($mainGrade as $mainGradeKey => $mainGradeVal) {
                                            $tmpGradeFormName = "gradeForm" . $i;
                                            $gradeValues = $gradeWiseProd[$minLow][0]['gradeProd']['gradeValues'];

                                            ?>
                                            <tr>
                                                <td>
                                                    <?php 
                                                    // if($_SESSION['lang']=='hindi'){ 
                                                    //     echo "(" . $lilist[$feMinSubCount++] . ") " . $gradeLbl; 
                                                    // } else { 
                                                    //     echo "(" . $feMinSubCount++ . ") " . $gradeLbl; 
                                                    // } 

                                                    echo "(" . $feMinSubCount++ . ") " . $mainGradeVal;

                                                    ?>
                                                </td>
                                                <?php if ($formNo == 3) { ?>
                                                    <?php if ($i < 7) { ?>
                                                        <td>
                                                            <?php echo $gradeVal['average_grade']; ?>
                                                        </td>
                                                    <?php } ?>
                                                <?php } ?>
                                                <td>
                                                    <?php echo $gradeValues[$mainGradeKey]['opening_stock']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $gradeValues[$mainGradeKey]['production']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $gradeValues[$mainGradeKey]['despatches']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $gradeValues[$mainGradeKey]['closing_stock']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $gradeValues[$mainGradeKey]['pmv']; ?>
                                                </td>
                                            </tr>
                                    <?php  $i++; 	} 	?>
                                <?php } $tmpGradeFormName = "gradeForm" . $i;  ?>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                <?php } ?>

                <?php } ?>

        </tbody>
    </table>

    
    <!--ESTIMATION TABLE-->

    <table class="estimation-table" align="center">
        <?php if ($returnType == 'ANNUAL') { ?>
            <tr >
                <th align="center">Mineral Name </th>
                <th align="center">Production proposal for financial year <br/><?php echo $period; ?></th>
                <th align="center">Production reported during the financial year <br/><?php echo $period; ?></th>
                <th align="center">Difference</th>
            </tr>
        <?php } else { ?>
            <tr>
                <th align="center">Mineral Name </th>
                <th align="center">Production proposal for current financial year</th>
                <th align="center">Cumulative production as reported upto the current month</th>
                <th align="center">Difference</th>
            </tr>
        <?php } ?>

        <?php
//                                              if(count($estimation == 2)){
        $row = "";
        // Added one more index for multiple minerals
        // Added on 29/06/2018 by Naveen Jha to fix issue of 35KAR03014
        foreach ($estimation as $e) {
            $row .= "<tr>";
            $row .= "<td align='center'>" . $e[0]['min'] . "</td>";
            $row .= "<td align='center'>" . $e[0]['est'] . "</td>";
            $row .= "<td align='center'>" . $e[0]['cum'] . "</td>";
            $row .= "<td align='center'>" . $e[0]['diff'] . "</td>";
            $row .= "</tr>";
            
        }
        echo $row;
        ?>
    </table>
</div>

<script>

$(document).ready(function(){

    a_total('f_open_dev_qty', 'f_open_stop_qty', 'open_und_qty_total');
    a_total('f_prod_dev_qty', 'f_prod_stop_qty', 'prod_und_qty_total');
    a_total('f_close_dev_qty', 'f_close_stop_qty', 'close_und_qty_total');

    a_mcg_total('open_und_metal_total','open_dev_table','open_dev_metal','open_dev_grade','open_stop_table','open_stop_metal','open_stop_grade','open_total_table','open_cast_table','open_cast_metal','open_cast_grade');
    a_mcg_total('prod_und_metal_total','prod_dev_table','prod_dev_metal','prod_dev_grade','prod_stop_table','prod_stop_metal','prod_stop_grade','prod_total_table','prod_cast_table','prod_cast_metal','prod_cast_grade');
    a_mcg_total('close_und_metal_total','close_dev_table','close_dev_metal','close_dev_grade','close_stop_table','close_stop_metal','close_stop_grade','close_total_table','close_cast_table','close_cast_metal','close_cast_grade');
    tStock();

});

function a_total(devQty, stopQty, qtyTotal){

    var dev_qty = ($('#'+devQty).text() == '') ? 0 : $('#'+devQty).text();
    var stop_qty = ($('#'+stopQty).text() == '') ? 0 : $('#'+stopQty).text();
    $('#'+qtyTotal).text(parseFloat(dev_qty) + parseFloat(stop_qty));

}

function a_mcg_total(tabUnd, tabOne, metalOne, gradeOne, tabTwo, metalTwo, gradeTwo, tabTotal, tabThree, metalThree, gradeThree){

    $('#'+tabUnd).html('');
    $('#'+tabTotal).html('');
    var tabOneRw = $('#'+tabOne+' tbody tr').length;
    var tabTwoRw = $('#'+tabTwo+' tbody tr').length;
    var tabThreeRw = $('#'+tabThree+' tbody tr').length;

    for(var i=1;i<=tabOneRw;i++){

        var metal = $('#'+tabOne+' tbody tr:nth-child('+i+') td:nth-child(1) .'+metalOne).text();
        var grade = $('#'+tabOne+' tbody tr:nth-child('+i+') td:nth-child(2) .'+gradeOne).text();

        var rowCon = (metal != '' && grade != '') ? "<tr><td>"+metal+"</td><td>"+grade+"</td></tr>" : "";
        $('#'+tabUnd).append(rowCon);
        $('#'+tabTotal).append(rowCon);

    }

    for(var n=1;n<=tabTwoRw;n++){

        var metal = $('#'+tabTwo+' tbody tr:nth-child('+n+') td:nth-child(1) .'+metalTwo).text();
        var grade = $('#'+tabTwo+' tbody tr:nth-child('+n+') td:nth-child(2) .'+gradeTwo).text();

        var rowCon = (metal != '' && grade != '') ? "<tr><td>"+metal+"</td><td>"+grade+"</td></tr>" : "";
        $('#'+tabUnd).append(rowCon);
        $('#'+tabTotal).append(rowCon);

    }

    for(var m=1;m<=tabThreeRw;m++){

        var metal = $('#'+tabThree+' tbody tr:nth-child('+m+') td:nth-child(1) .'+metalThree).text();
        var grade = $('#'+tabThree+' tbody tr:nth-child('+m+') td:nth-child(2) .'+gradeThree).text();

        var rowCon = (metal != '' && grade != '') ? "<tr><td>"+metal+"</td><td>"+grade+"</td></tr>" : "";
        $('#'+tabTotal).append(rowCon);

    }

}

function tStock(){

    var a_open = $('#open_und_qty_total').html();
    var b_open = $('#f_open_cast_qty').text();
    var open = (a_open != '' && b_open != '') ? parseFloat(a_open) + parseFloat(b_open) : '';
    $('#f_open_tot_qty').text(open);
    var a_prod = $('#prod_und_qty_total').html();
    var b_prod = $('#f_prod_cast_qty').text();
    var prod = (a_prod != '' && b_prod != '') ? parseFloat(a_prod) + parseFloat(b_prod) : '';
    $('#f_prod_tot_qty').text(prod);
    var a_close = $('#close_und_qty_total').html();
    var b_close = $('#f_close_cast_qty').text();
    var close = (a_close != '' && b_close != '') ? parseFloat(a_close) + parseFloat(b_close) : '';
    $('#f_close_tot_qty').text(close);

}

</script>