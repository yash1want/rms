<?php error_reporting(0); ?>
<style>
.sec_tit {
    font-size: 11px;
}
.f_s_7 {
    font-size: 6px;
}
.f_s_9 {
    font-size: 9px;
}
.f_s_10 {
    font-size: 10px;
}
.f_s_11 {
    font-size: 11px;
}
.f_s_12 {
    font-size: 12px;
}
.l_h_10 {
    line-height: 10px;
}
.l_h_15 {
    line-height: 15px;
}
.f_b {
    font-weight: bold;
}
.foot_note {
    font-size: 8px;
}
.center {
  margin-left: auto;
  margin-right: auto;
}
.div
{
    width: 80%;margin:1px auto;
}
</style>

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

$gradeIronOre = 0;

if ($formNo == 3){
    $grade_col_1 = '22%';
    $grade_col_2 = '13%';
    $grade_col_3 = '13%';
    $grade_col_4 = '13%';
    $grade_col_5 = '13%';
    $grade_col_6 = '13%';
    $grade_col_7 = '13%';
} else {
    $grade_col_1 = '25%';
    $grade_col_2 = '';
    $grade_col_3 = '15%';
    $grade_col_4 = '15%';
    $grade_col_5 = '15%';
    $grade_col_6 = '15%';
    $grade_col_7 = '15%';
}

?>

<div class="container">
    <table class="table">
        <tbody>
            <tr style="text-align:center" class="l_h_15">
                <th>
                    <span class="f_s_11"><strong><?php echo $pdfLabel['title']['form']; ?></strong></span><br>
                    <span class="f_s_10"><?php echo $pdfLabel['title']['rule']; ?></span><br>
                    <span class="f_s_10"><strong><?php echo $pdfLabel['title']['for']; ?></strong></span><br>
                    <span class="f_s_11"><strong><?php echo $pdfLabel['title']['return']; ?></strong></span><br>
                    <span class="f_s_10"><?php echo $pdfLabel['title']['instr']; ?></span>
                </th>
            </tr>
            <tr>
                <td align="left"><span style="margin-left:50px; text-align:left; font-size: 11px;">  <br />
                <?php echo $pdfLabel['to']['to']; ?>,
                <ol type="i" class="f_s_9">
                    <li><?php echo $pdfLabel['to']['address'][0]; ?><br />
                        <?php echo $pdfLabel['to']['address'][1]; ?><br />
                        <?php echo ucwords(strtolower($regionName)); ?> <?php echo $pdfLabel['to']['address'][2]; ?>,<br />
                        <?php echo $pdfLabel['to']['address'][3]; ?> <br />
                        <?php echo $pdfLabel['to']['address'][4]; ?></li><br />
                    <li><?php echo $pdfLabel['to']['address'][5]; ?> <?php echo ucwords(strtolower($mine['state'])); ?></li></ol></span>
                </td>
            </tr>
            
            <!-- MINE DETAILS -->
            <tr>
                <td align="center">
                    <div id="details_maines">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="f_s_9">
                            <?php if ($returnType == 'MONTHLY') { ?>
                                <tr>
                                    <td align="center"><span class="f_s_11" style="margin-left:50px"><strong>PART - I</strong></span></td>
                                </tr>
                                <tr>
                                    <td align="center"><span class="f_s_11" style="margin-left:50px"><strong>(General and Labour)</strong></span></td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td align="center"><span class="f_s_11" style="margin-left:50px"><strong>PART - I (General)</strong></span></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td align="center" valign="top" class="f_s_9">
                                    <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse" nobr="true">
                                        <tr>
                                            <td colspan="2" align="left" class="f_s_10 f_b"><?php echo $label['mine']['title']; ?></td>
                                        </tr>
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
                                    </table>                    
                                </td>
                            </tr>
                            <tr><td></td></tr>
                        </table>
                    </div>
                </td>
            </tr>
            
            <!-- NAME AND ADDRESS DETAILS -->
            <tr>
                <td align="center">
                    <div id="name_address">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center" valign="top" class="f_s_9">
                                    <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse" nobr="true">
                                        <tr>
                                            <td align="left" class="f_s_10 f_b"><?php echo str_replace('<br>',' ',$label['name_address']['title']); ?></td>
                                        </tr>
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
            
            <?php if ($returnType != 'ANNUAL') { ?>

                <!--Rent Details-->
                <tr>
                    <td align="center">
                        <div id="rent_details">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center" valign="top" class="f_s_9">
                                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse" nobr="true">
                                            <tr>
                                                <td align="left" class="f_s_10 f_b"><?php echo $label['rent']['title']; ?></td>
                                            </tr>
                                            <tr>
                                                <td width="50%" align="left" class="lable-text"><?php echo $label['rent'][0]; ?> (&#8377;)</td>
                                                <td width="50%" align="left"><?php echo $rentDetail['past_surface_rent']; ?></td>
                                            </tr>
                                            <tr>
                                                <td align="left" class="lable-text"><?php echo $label['rent'][1]; ?> (&#8377;)</td>
                                                <td align="left"><?php echo $rentDetail['past_royalty']; ?></td>
                                            </tr>
                                            <tr>
                                                <td align="left" class="lable-text"><?php echo $label['rent'][2]; ?> (&#8377;)</td>
                                                <td align="left"><?php echo $rentDetail['past_surface_rent']; ?></td>
                                            </tr>
                                            <tr>
                                                <td align="left" class="lable-text"><?php echo $label['rent'][3]; ?> (&#8377;)</td>
                                                <td align="left"><?php echo $rentDetail['past_dead_rent']; ?></td>
                                            </tr>
                                            <tr>
                                                <td align="left" class="lable-text"><?php echo $label['rent'][4]; ?> (&#8377;)</td>
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
                        <div id="details_working">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center" valign="top" class="f_s_9">
                                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse" nobr="true">
                                            <tr>
                                                <td align="left" class="f_s_10 f_b"><?php echo $label['working_detail']['title']; ?></td>
                                            </tr>
                                            <tr>
                                                <td width="37%" align="left" class="lable-text"><?php echo $label['working_detail'][0]; ?></td>
                                                <td width="63%" align="left"><?php echo $workDetail['total_no_days']; ?></td>
                                            </tr>
                                            <tr>
                                                <td align="left" valign="top" class="lable-text"><?php echo $label['working_detail'][1]; ?></td>
                                                <td align="left">
                                                    <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD">
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

                <!--AVERAGE DAILY-->
                <tr>
                    <td align="center" nobr="true">
                        <div id="daily_wages">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr><td align="left" class="welcome-signout sec_tit f_b"> <?php echo $label['daily_average']['title']; ?></td></tr>
                                <tr>
                                    <td align="center" valign="top">
                                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse" class="f_s_9">
                                            <tr>
                                                <td rowspan="2" align="center" class="form-table-title"><?php echo $label['daily_average'][0]; ?></td>
                                                <td colspan="2" align="center" class="form-table-title"><?php echo $label['daily_average'][1]; ?></td>
                                                <td colspan="2" align="center" class="form-table-title"><?php echo $label['daily_average'][2]; ?></td> 
                                                <td colspan="2" align="center" class="form-table-title"><?php echo $label['daily_average'][3]; ?></td>
                                            </tr>
                                            <tr>
                                                <td align="center" class="form-table-title"><?php echo $label['daily_average'][4]; ?></td>
                                                <td align="center" class="form-table-title"><?php echo $label['daily_average'][5]; ?></td>
                                                <td align="center" class="form-table-title"><?php echo $label['daily_average'][6]; ?></td>
                                                <td align="center" class="form-table-title"><?php echo $label['daily_average'][7]; ?></td>
                                                <td align="center" class="form-table-title"><?php echo $label['daily_average'][8]; ?></td>
                                                <td align="center" class="form-table-title"><?php echo $label['daily_average'][9]; ?></td>
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
                                                <td colspan="7" class="foot_note" align="left"><?php echo $label['daily_average'][14]; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>

            <?php } ?>
            
            <?php if ($returnType == 'ANNUAL') { ?>

            <!-- PART - I - ANNUAL RETURNS -->

            <!-- PARTICULARS OF AREA OPERATED -->
                <tr>
                    <td align="center">
                        <div id="particulars">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="f_s_9">
                                <tr>
                                    <td align="center" class="welcome-signout sec_tit"><span style="margin-left:50px"><strong><?php echo strtoupper($label['particulars']['title']); ?></strong></span></td>
                                </tr>
                                <tr>
                                    <td><span style="margin-left:50px"><?php echo $label['particulars']['title_note']; ?></span></td>
                                </tr>
                                
                                <?php 
                                $tbl = 1;
                                foreach($particulars as $particular){
                                    ?>
                                    <tr>
                                        <td align="center" valign="top">
                                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                                <tr>
                                                    <td align="left" colspan="2">Lease - <?php echo $tbl; ?></td>
                                                </tr>
                                                <tr>
                                                    <td align="left" class="form-table-title"><?php echo $label['particulars'][0]; ?></td>
                                                    <td align="left" class="form-table-title"><?php echo $particular['lease_no']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td align="left" colspan="2"><?php echo $label['particulars'][1]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td align="left"><?php echo $label['particulars'][2]; ?></td>
                                                    <td align="left">
                                                        <?php echo $particular['under_forest']; ?>
                                                        <?php echo $label['particulars']['unit']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left"><?php echo $label['particulars'][3]; ?></td>
                                                    <td align="left">
                                                        <?php echo $particular['outside_forest']; ?>
                                                        <?php echo $label['particulars']['unit']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left"><?php echo $label['particulars'][4]; ?></td>
                                                    <td align="left">
                                                        <?php echo $particular['total']; ?>
                                                        <?php echo $label['particulars']['unit']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left"><?php echo $label['particulars'][5]; ?></td>
                                                    <td align="left">
                                                        <?php echo $particular['execution_date']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left"><?php echo $label['particulars'][6]; ?></td>
                                                    <td align="left">
                                                        <?php echo $particular['lease_period']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" colspan="2"><?php echo $label['particulars'][7]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td align="left"><?php echo $label['particulars'][2]; ?></td>
                                                    <td align="left">
                                                        <?php echo $particular['surface_under_forest']; ?>
                                                        <?php echo $label['particulars']['unit']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left"><?php echo $label['particulars'][3]; ?></td>
                                                    <td align="left">
                                                        <?php echo $particular['surface_outside_forest']; ?>
                                                        <?php echo $label['particulars']['unit']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left"><?php echo $label['particulars'][4]; ?></td>
                                                    <td align="left">
                                                        <?php echo $particular['surface_rights']; ?>
                                                        <?php echo $label['particulars']['unit']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left"><?php echo $label['particulars'][8]; ?></td>
                                                    <td align="left">
                                                        <?php echo $particular['renewal_date']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left"><?php echo $label['particulars'][9]; ?></td>
                                                    <td align="left">
                                                        <?php echo $particular['renewal_period']; ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                <?php $tbl++; } ?>
                                
                                <tr>
                                    <td align="center" valign="top">
                                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                            <tr>
                                                <td align="left"><?php echo $label['particulars'][10]; ?></td>
                                                <td>
                                                    <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                                        <tr>
                                                            <td align="center"><?php echo $label['particulars'][11]; ?></td>
                                                            <td align="center"><?php echo $label['particulars'][12]; ?></td>
                                                            <td align="center"><?php echo $label['particulars'][13]; ?></td>
                                                        </tr>
                                                        <?php if ($particulars[0]['lease_info'] == '') { ?>
                                                            <tr>
                                                                <td align="center">--</td>
                                                                <td align="center">--</td>
                                                                <td align="center">--</td>
                                                            </tr>
                                                        <?php } else { 
                                                            foreach($particulars[0]['lease_info'] as $lease_info){
                                                                $lease_info_arr = explode('-', $lease_info);
                                                            ?>
                                                            <tr>
                                                                <td align="center"><?php echo $lease_info_arr[0]; ?></td>
                                                                <td align="center"><?php echo $lease_info_arr[1]; ?></td>
                                                                <td align="center"><?php echo $lease_info_arr[2]; ?></td>
                                                            </tr>
                                                        <?php } } ?>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr><td></td></tr>
                            </table>
                        </div>
                    </td>
                </tr>
                
                <!-- AREA OF UTILIZATION -->
                <tr>
                    <td align="center">
                        <div id="area_utilisation">
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;" nobr="true"  class="f_s_9">
                                <tr>
                                    <td align="left" class="lable-text"><?php echo $label['area_utilisation']['title']; ?></td>
                                    <td align="center"><?php echo $label['area_utilisation'][0]; ?></td>
                                    <td align="center"><?php echo $label['area_utilisation'][1]; ?></td>
                                    <td align="center"><?php echo $label['area_utilisation'][2]; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['area_utilisation'][3]; ?></td>
                                    <td align="center"><?php echo $lease['forest_abandoned_area']; ?></td>
                                    <td align="center"><?php echo $lease['non_forest_abandoned_area']; ?></td>
                                    <td align="center"><?php echo $lease['total_abandoned_area']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['area_utilisation'][4]; ?></td>
                                    <td align="center"><?php echo $lease['forest_working_area']; ?></td>
                                    <td align="center"><?php echo $lease['non_forest_working_area']; ?></td>
                                    <td align="center"><?php echo $lease['total_working_area']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['area_utilisation'][5]; ?></td>
                                    <td align="center"><?php echo $lease['forest_reclaimed_area']; ?></td>
                                    <td align="center"><?php echo $lease['non_forest_reclaimed_area']; ?></td>
                                    <td align="center"><?php echo $lease['total_reclaimed_area']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['area_utilisation'][6]; ?></td>
                                    <td align="center"><?php echo $lease['forest_waste_area']; ?></td>
                                    <td align="center"><?php echo $lease['non_forest_waste_area']; ?></td>
                                    <td align="center"><?php echo $lease['total_waste_area']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['area_utilisation'][7]; ?></td>
                                    <td align="center"><?php echo $lease['total_waste_area']; ?></td>
                                    <td align="center"><?php echo $lease['non_forest_building_area']; ?></td>
                                    <td align="center"><?php echo $lease['total_building_area']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left">
                                        <?php echo $label['area_utilisation'][8]; ?>
                                        <?php echo $lease['other_purpose']; ?>
                                    </td>
                                    <td align="center"><?php echo $lease['forest_other_area']; ?></td>
                                    <td align="center"><?php echo $lease['non_forest_other_area']; ?></td>
                                    <td align="center"><?php echo $lease['total_other_area']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['area_utilisation'][9]; ?></td>
                                    <td align="center"><?php echo $lease['forest_progressive_area']; ?></td>
                                    <td align="center"><?php echo $lease['non_forest_progressive_area']; ?></td>
                                    <td align="center"><?php echo $lease['total_progressive_area']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['area_utilisation'][10]; ?></td>
                                    <td align="center" colspan="3"><?php echo $agency_choices[$lease['agency']]; ?></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>

                <!----------------------- PART - II - ANNUAL RETURNS ---------------------->

                <!-- EMPLOYMENT WAGES -->
                
                <br pagebreak="true" />
                <tr>
                    <td align="center"><span style="margin-left:50px"><strong><?php echo $label['employment_wages']['part']; ?></strong></span></td>
                </tr>
                <tr><td></td></tr>
                <tr>
                    <td align="center">
                        <div id="employment_wages">
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                <tr>
                                    <td align="left" class="lable-text" colspan="3"><?php echo $label['employment_wages'][0]; ?></td>
                                </tr>
                                <tr>
                                    <td align="center"><?php echo $label['employment_wages'][1]; ?></td>
                                    <td align="center"><?php echo $label['employment_wages'][2]; ?></td>
                                    <td align="center"><?php echo $label['employment_wages'][3]; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['employment_wages'][4]; ?></td>
                                    <td align="center"><?php echo $empWages['wholly_employed_gme']; ?></td>
                                    <td align="center"><?php echo $empWages['partly_employed_gme']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['employment_wages'][5]; ?></td>
                                    <td align="center"><?php echo $empWages['wholly_employed_dme']; ?></td>
                                    <td align="center"><?php echo $empWages['partly_employed_dme']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['employment_wages'][6]; ?></td>
                                    <td align="center"><?php echo $empWages['wholly_employed_geologist']; ?></td>
                                    <td align="center"><?php echo $empWages['partly_employed_geologist']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['employment_wages'][7]; ?></td>
                                    <td align="center"><?php echo $empWages['wholly_employed_surveyor']; ?></td>
                                    <td align="center"><?php echo $empWages['partly_employed_surveyor']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['employment_wages'][8]; ?></td>
                                    <td align="center"><?php echo $empWages['wholly_employed_other']; ?></td>
                                    <td align="center"><?php echo $empWages['partly_employed_other']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['employment_wages'][9]; ?></td>
                                    <td align="center">
                                        <?php echo ((int)$empWages['wholly_employed_gme'] + (int)$empWages['wholly_employed_dme'] + (int)$empWages['wholly_employed_geologist'] + (int)$empWages['wholly_employed_surveyor'] + (int)$empWages['wholly_employed_other']); ?>
                                    </td>
                                    <td align="center">
                                        <?php echo ((int)$empWages['partly_employed_gme'] + (int)$empWages['partly_employed_dme'] + (int)$empWages['partly_employed_geologist'] + (int)$empWages['partly_employed_surveyor'] + (int)$empWages['partly_employed_other']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['employment_wages'][10]; ?></td>
                                    <td align="center" colspan="2"><?php echo $empWages['no_work_days']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['employment_wages'][11]; ?></td>
                                    <td align="center" colspan="2"><?php echo $empWages['no_shifts']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['employment_wages'][12]; ?></td>
                                    <td align="center" colspan="2">
                                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " class="f_s_9">
                                            <tr>
                                                <td align="center"><?php echo $label['employment_wages'][13]; ?></td>
                                                <td align="center"><?php echo $label['employment_wages'][14]; ?></td>
                                            </tr>
                                            <?php 
                                            $loop1 = 1;
                                            $ResonArr = [];
                                            foreach($reasonsArr as $reason1){
                                                $ResonArr[$reason1['stoppage_sn']] = $reason1['stoppage_def']; 
                                            }
                                            /*print_r($ResonArr[99]); echo "<br>";
                                            print_r($workData); echo "<br>";*/
                                            for ($i=1; $i <= 12 ; $i++) 
                                            { if(!empty($workData['stoppage_sn_'.$i])){ ?>
                                                <tr>
                                                    <td align="center">
                                                    <?= $ResonArr[$workData['stoppage_sn_'.$i]]; ?></td>
                                                    <td align="center"><?php echo $workData['no_days_'.$i]; ?></td>
                                                </tr>
                                            <?php } }
                                           
                                          
/*
                                            for ($i=0; $i <= $reasonsLen; $i++) {
                                                if ($workData['stoppage_sn_'.$loop] != null || $i==0) {
                                                    print_r($workData['stoppage_sn_'.$loop]); echo "<br>";
                                                    print_r($reasonsArr[$workData['stoppage_sn_'.$i]]['stoppage_def']); echo "<br>";

                                                    ?>
                                                    <tr>

                                                        <td align="center"><?php echo (isset($reasonsArr[$workData['stoppage_sn_'.$loop]]['stoppage_def'])) ? $reasonsArr[$workData['stoppage_sn_'.$loop]]['stoppage_def'] : ''; ?></td>

                                                        <td align="center"><?php echo $workData['no_days_'.$loop]; ?></td>
                                                    </tr>
                                                    <?php 
                                                }
                                                    $loop++;
                                            } die;*/
                                            ?>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                
                <!-- EMPLOYMENT & WAGES - Part II -->
                <br pagebreak="true" />
                <tr>
                    <td align="center"><span style="margin-left:50px"><strong><?php echo $label['employment_wages_part']['title']; ?></strong></span></td>
                </tr>
                <tr><td></td></tr>
                <tr>
                    <td align="center">
                        <div id="employment_wages_part">
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                <tr>
                                    <td align="left"><?php echo $label['employment_wages_part'][0]; ?> #</td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['employment_wages_part'][3]; ?></td>
                                </tr>
                                <tr>
                                    <td align="left">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                            <tr>
                                                <td align="left"><?php echo $label['employment_wages_part'][4]; ?></td>
                                                <td align="left">
                                                    <?php echo $label['employment_wages_part'][5]; ?>
                                                    <?php echo $empData['returnDetails']['WORKING_BELOW_DATE']; ?>
                                                </td>
                                                <td align="left">
                                                    <?php echo $label['employment_wages_part'][6]; ?>
                                                    <?php echo $empData['returnDetails']['WORKING_BELOW_PER']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left"><?php echo $label['employment_wages_part'][7]; ?></td>
                                                <td align="left">
                                                    <?php echo $label['employment_wages_part'][5]; ?>
                                                    <?php echo $empData['returnDetails']['WORKING_ALL_DATE']; ?>
                                                </td>
                                                <td align="left">
                                                    <?php echo $label['employment_wages_part'][6]; ?>
                                                    <?php echo $empData['returnDetails']['WORKING_ALL_PER']; ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " class="f_s_9">
                                            <tr>
                                                <td align="center" rowspan="2"><?php echo $label['employment_wages_part'][8]; ?></td>
                                                <td align="center" colspan="3"><?php echo $label['employment_wages_part'][9]; ?></td>
                                                <td align="center" rowspan="2"><?php echo $label['employment_wages_part'][10]; ?></td>
                                                <td align="center" colspan="3"><?php echo $label['employment_wages_part'][11]; ?></td>
                                                <td align="center" rowspan="2"><?php echo $label['employment_wages_part'][12]; ?></td>
                                            </tr>
                                            <tr>
                                                <td align="center"><?php echo $label['employment_wages_part'][13]; ?></td>
                                                <td align="center"><?php echo $label['employment_wages_part'][14]; ?></td>
                                                <td align="center"><?php echo $label['employment_wages_part'][15]; ?></td>
                                                <td align="center"><?php echo $label['employment_wages_part'][16]; ?></td>
                                                <td align="center"><?php echo $label['employment_wages_part'][17]; ?></td>
                                                <td align="center"><?php echo $label['employment_wages_part'][18]; ?></td>
                                            </tr>
                                            <tr>
                                                <td align="center"><?php echo $label['employment_wages_part'][19]; ?></td>
                                                <td align="center"><?php echo $label['employment_wages_part'][20]; ?></td>
                                                <td align="center"><?php echo $label['employment_wages_part'][21]; ?></td>
                                                <td align="center"><?php echo $label['employment_wages_part'][22]; ?></td>
                                                <td align="center"><?php echo $label['employment_wages_part'][23]; ?></td>
                                                <td align="center"><?php echo $label['employment_wages_part'][24]; ?></td>
                                                <td align="center"><?php echo $label['employment_wages_part'][25]; ?></td>
                                                <td align="center"><?php echo $label['employment_wages_part'][26]; ?></td>
                                                <td align="center"><?php echo $label['employment_wages_part'][27]; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $label['employment_wages_part'][28]; ?></td>
                                                <td><?php echo $empData['empDetails']['BELOW_FOREMAN_DIRECT']; ?></td>
                                                <td><?php echo $empData['empDetails']['BELOW_FOREMAN_CONTRACT']; ?></td>
                                                <td><?php echo $empData['empDetails']['BELOW_FOREMAN_MAN_TOT']; ?></td>
                                                <td><?php echo $empData['empDetails']['BELOW_FOREMAN_DAYS']; ?></td>
                                                <td><?php echo $empData['empDetails']['BELOW_FOREMAN_MALE']; ?></td>
                                                <td><?php echo $empData['empDetails']['BELOW_FOREMAN_FEMALE']; ?></td>
                                                <td><?php echo $empData['empDetails']['BELOW_FOREMAN_PER_TOTAL']; ?></td>
                                                <td><?php echo $empData['empDetails']['BELOW_FOREMAN_TOTAL_WAGES']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $label['employment_wages_part'][29]; ?></td>
                                                <td><?php echo $empData['empDetails']['OC_FOREMAN_DIRECT']; ?></td>
                                                <td><?php echo $empData['empDetails']['OC_FOREMAN_CONTRACT']; ?></td>
                                                <td><?php echo $empData['empDetails']['OC_FOREMAN_MAN_TOT']; ?></td>
                                                <td><?php echo $empData['empDetails']['OC_FOREMAN_DAYS']; ?></td>
                                                <td><?php echo $empData['empDetails']['OC_FOREMAN_MALE']; ?></td>
                                                <td><?php echo $empData['empDetails']['OC_FOREMAN_FEMALE']; ?></td>
                                                <td><?php echo $empData['empDetails']['OC_FOREMAN_PER_TOTAL']; ?></td>
                                                <td><?php echo $empData['empDetails']['OC_FOREMAN_TOTAL_WAGES']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $label['employment_wages_part'][30]; ?></td>
                                                <td><?php echo $empData['empDetails']['ABOVE_CLERICAL_DIRECT']; ?></td>
                                                <td><?php echo $empData['empDetails']['ABOVE_CLERICAL_CONTRACT']; ?></td>
                                                <td><?php echo $empData['empDetails']['ABOVE_CLERICAL_MAN_TOT']; ?></td>
                                                <td><?php echo $empData['empDetails']['ABOVE_CLERICAL_DAYS']; ?></td>
                                                <td><?php echo $empData['empDetails']['ABOVE_CLERICAL_MALE']; ?></td>
                                                <td><?php echo $empData['empDetails']['ABOVE_CLERICAL_FEMALE']; ?></td>
                                                <td><?php echo $empData['empDetails']['ABOVE_CLERICAL_PER_TOTAL']; ?></td>
                                                <td><?php echo $empData['empDetails']['ABOVE_CLERICAL_TOTAL_WAGES']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $label['employment_wages_part'][31]; ?></td>
                                                <td><?php echo $empData['empDetails']['ABOVE_ATTACHED_DIRECT']; ?></td>
                                                <td><?php echo $empData['empDetails']['ABOVE_ATTACHED_CONTRACT']; ?></td>
                                                <td><?php echo $empData['empDetails']['ABOVE_ATTACHED_MAN_TOT']; ?></td>
                                                <td><?php echo $empData['empDetails']['ABOVE_ATTACHED_DAYS']; ?></td>
                                                <td><?php echo $empData['empDetails']['ABOVE_ATTACHED_MALE']; ?></td>
                                                <td><?php echo $empData['empDetails']['ABOVE_ATTACHED_FEMALE']; ?></td>
                                                <td><?php echo $empData['empDetails']['ABOVE_ATTACHED_PER_TOTAL']; ?></td>
                                                <td><?php echo $empData['empDetails']['ABOVE_ATTACHED_TOTAL_WAGES']; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="9">
                                        <?php echo $label['employment_wages_part'][2]; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                
                
                <!-- CAPITAL STRUCTURE -->
                <br pagebreak="true" />
                <tr>
                    <td align="center"><span style="margin-left:50px"><strong><?php echo $label['capital_structure']['part']; ?></strong></span></td>
                </tr>
                <tr><td></td></tr>
                <tr>
                    <td align="center">
                        <div id="capital_structure">
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                <tr>
                                    <td align="left" colspan="7">
                                        <?php echo $label['capital_structure'][0]; ?> * (&#8377; <?php echo $csData['fixed_result'][' assests_value']; ?>) <br>
                                        <?php echo $label['capital_structure'][1]; ?><br><br>
                                        <?php echo $label['capital_structure'][2]; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="7">
                                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " class="f_s_9">
                                            <tr>
                                                <td align="center"><?php echo $label['particulars'][11]; ?></td>
                                                <td align="center"><?php echo $label['particulars'][12]; ?></td>
                                                <td align="center"><?php echo $label['particulars'][13]; ?></td>
                                            </tr>
                                            <?php if (!isset($csData['fixed_result']['selected_mine_code'][0]) || $csData['fixed_result']['selected_mine_code'][0] == '') { ?>
                                                <tr>
                                                    <td align="center">--</td>
                                                    <td align="center">--</td>
                                                    <td align="center">--</td>
                                                </tr>
                                            <?php } else { 
                                                foreach($csData['fixed_result']['selected_mine_code'] as $sel_mine_code){
                                                    $sel_mine_code_arr = explode('-', $sel_mine_code);
                                                ?>
                                                <tr>
                                                    <td align="center"><?php echo $sel_mine_code_arr[0]; ?></td>
                                                    <td align="center"><?php echo $sel_mine_code_arr[1]; ?></td>
                                                    <td align="center"><?php echo $sel_mine_code_arr[2]; ?></td>
                                                </tr>
                                            <?php } } ?>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center"><?php echo $label['capital_structure'][7]; ?></td>
                                    <td align="center"><?php echo $label['capital_structure'][8]; ?></td>
                                    <td align="center"><?php echo $label['capital_structure'][9]; ?></td>
                                    <td align="center"><?php echo $label['capital_structure'][10]; ?></td>
                                    <td align="center"><?php echo $label['capital_structure'][11]; ?></td>
                                    <td align="center"><?php echo $label['capital_structure'][12]; ?></td>
                                    <td align="center"><?php echo $label['capital_structure'][13]; ?>**</td>
                                </tr>
                                <tr>
                                    <td align="left">(i) <?php echo $label['capital_structure'][14]; ?> ***</td>
                                    <td align="center"><?php echo $csData['common_result']['land_beg']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['land_addition']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['land_sold']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['land_depreciated']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['land_close_bal']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['land_estimated']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="7">(ii) <?php echo $label['capital_structure'][15]; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['capital_structure'][16]; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['indus_beg']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['indus_addition']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['indus_sold']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['indus_depreciated']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['indus_close_bal']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['indus_estimated']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['capital_structure'][17]; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['resi_beg']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['resi_addition']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['resi_sold']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['resi_depreciated']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['resi_close_bal']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['resi_estimated']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left">(iii)<?php echo $label['capital_structure'][18]; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['plant_beg']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['plant_addition']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['plant_sold']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['plant_depreciated']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['plant_close_bal']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['plant_estimated']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left">(iv)<?php echo $label['capital_structure'][19]; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['capital_beg']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['capital_addition']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['capital_sold']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['capital_depreciated']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['capital_close_bal']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['capital_estimated']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['capital_structure'][20]; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['total_beg']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['total_addition']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['total_sold']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['total_depreciated']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['total_close_bal']; ?></td>
                                    <td align="center"><?php echo $csData['common_result']['total_estimated']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="7">
                                        <?php echo '*'.$label['capital_structure'][35]; ?><br><br>
                                        <?php echo '**'.$label['capital_structure'][32]; ?><br><br>
                                        <?php echo '***'.$label['capital_structure'][33]; ?><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="7"><?php echo $label['capital_structure'][21]; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="4"><?php echo $label['capital_structure'][22]; ?>(&#8377;)</td>
                                    <td align="center" colspan="3"><?php echo $csData['fixed_result']['paid_share']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="4"><?php echo $label['capital_structure'][23]; ?>(&#8377;)</td>
                                    <td align="center" colspan="3"><?php echo $csData['fixed_result']['own_Capital']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="4"><?php echo $label['capital_structure'][24]; ?>(&#8377;)</td>
                                    <td align="center" colspan="3"><?php echo $csData['fixed_result']['reserve']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="4"><?php echo $label['capital_structure'][25]; ?> (#)(&#8377;)</td>
                                    <td align="center" colspan="3"><?php echo $csData['fixed_result']['loan_outstanding']; ?></td>
                                </tr>
                                <tr>
                                    <td align="center" colspan="3"><?php echo $label['capital_structure'][26]; ?></td>
                                    <td align="center" colspan="2"><?php echo $label['capital_structure'][27]; ?></td>
                                    <td align="center" colspan="2"><?php echo $label['capital_structure'][28]; ?></td>
                                </tr>
                                <?php for ($i=1; $i <= $csData['dynamic_result']['rowCount']; $i++) { ?>
                                    <tr>
                                        <td colspan="3"><?php echo $csData['dynamic_result']['institute_name_'.$i]; ?></td>
                                        <td colspan="2"><?php echo $csData['dynamic_result']['loan_amount_'.$i]; ?></td>
                                        <td colspan="2"><?php echo $csData['dynamic_result']['interest_rate_'.$i]; ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="7"><?php echo '#'.$label['capital_structure'][34]; ?><br><br></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="7"><?php echo $label['capital_structure'][29]; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="4"><?php echo $label['capital_structure'][30]; ?></td>
                                    <td align="center" colspan="3"><?php echo $csData['fixed_result']['interest_paid']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="4"><?php echo $label['capital_structure'][31]; ?></td>
                                    <td align="center" colspan="3"><?php echo $csData['fixed_result']['rent_paid']; ?></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                
                <!---------------------- PART - III - ANNUAL RETURNS ---------------------->

                <!-- MATERIAL CONSUMPTION QUANTITY -->
                <br pagebreak="true" />
                <tr>
                    <td align="center"><span style="margin-left:50px"><strong><?php echo $label['material_consumption_quantity']['part']; ?></strong></span></td>
                </tr>
                <tr><td></td></tr>
                <tr>
                    <td align="center">
                        <div id="material_consumption_quantity">
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                <tr>
                                    <td align="left" colspan="4"><?php echo $label['material_consumption_quantity']['title']; ?></td>
                                </tr>
                                <tr>
                                    <td align="center"><?php echo $label['material_consumption_quantity'][0]; ?></td>
                                    <td align="center"><?php echo $label['material_consumption_quantity'][1]; ?></td>
                                    <td align="center"><?php echo $label['material_consumption_quantity'][2]; ?></td>
                                    <td align="center"><?php echo $label['material_consumption_quantity'][3]; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="4"><?php echo $label['material_consumption_quantity'][4]; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['material_consumption_quantity'][5]; ?></td>
                                    <td align="left"><?php echo $label['material_consumption_quantity']['ton']; ?></td>
                                    <td align="left"><?php echo $matConsData['COAL_QUANTITY']; ?></td>
                                    <td align="left"><?php echo $matConsData['COAL_VALUE']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['material_consumption_quantity'][6]; ?></td>
                                    <td align="left"><?php echo $label['material_consumption_quantity']['ltr']; ?></td>
                                    <td align="left"><?php echo $matConsData['DIESEL_QUANTITY']; ?></td>
                                    <td align="left"><?php echo $matConsData['DIESEL_VALUE']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['material_consumption_quantity'][7]; ?></td>
                                    <td align="left"><?php echo $label['material_consumption_quantity']['ltr']; ?></td>
                                    <td align="left"><?php echo $matConsData['PETROL_QUANTITY']; ?></td>
                                    <td align="left"><?php echo $matConsData['PETROL_VALUE']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['material_consumption_quantity'][8]; ?></td>
                                    <td align="left"><?php echo $label['material_consumption_quantity']['ltr']; ?></td>
                                    <td align="left"><?php echo $matConsData['KEROSENE_QUANTITY']; ?></td>
                                    <td align="left"><?php echo $matConsData['KEROSENE_VALUE']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['material_consumption_quantity'][9]; ?></td>
                                    <td align="left"><?php echo $label['material_consumption_quantity']['cum']; ?></td>
                                    <td align="left"><?php echo $matConsData['GAS_QUANTITY']; ?></td>
                                    <td align="left"><?php echo $matConsData['GAS_VALUE']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="4"><?php echo $label['material_consumption_quantity'][10]; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['material_consumption_quantity'][11]; ?></td>
                                    <td align="left"><?php echo $label['material_consumption_quantity']['ltr']; ?></td>
                                    <td align="left"><?php echo $matConsData['LUBRICANT_QUANTITY']; ?></td>
                                    <td align="left"><?php echo $matConsData['LUBRICANT_VALUE']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['material_consumption_quantity'][12]; ?></td>
                                    <td align="left"><?php echo $label['material_consumption_quantity']['kgs']; ?></td>
                                    <td align="left"><?php echo $matConsData['GREASE_QUANTITY']; ?></td>
                                    <td align="left"><?php echo $matConsData['GREASE_VALUE']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="4"><?php echo $label['material_consumption_quantity'][13]; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['material_consumption_quantity'][14]; ?></td>
                                    <td align="left"><?php echo $label['material_consumption_quantity']['kwh']; ?></td>
                                    <td align="left"><?php echo $matConsData['CONSUMED_QUANTITY']; ?></td>
                                    <td align="left"><?php echo $matConsData['CONSUMED_VALUE']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['material_consumption_quantity'][15]; ?></td>
                                    <td align="left"><?php echo $label['material_consumption_quantity']['kwh']; ?></td>
                                    <td align="left"><?php echo $matConsData['GENERATED_QUANTITY']; ?></td>
                                    <td align="left"><?php echo $matConsData['GENERATED_VALUE']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['material_consumption_quantity'][16]; ?></td>
                                    <td align="left"><?php echo $label['material_consumption_quantity']['kwh']; ?></td>
                                    <td align="left"><?php echo $matConsData['SOLD_QUANTITY']; ?></td>
                                    <td align="left"><?php echo $matConsData['SOLD_VALUE']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="3"><?php echo $label['material_consumption_quantity'][17]; ?></td>
                                    <td align="left"><?php echo $matConsData['EXPLOSIVES_VALUE']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['material_consumption_quantity'][18]; ?></td>
                                    <td align="left"><?php echo $label['material_consumption_quantity']['nos']; ?></td>
                                    <td align="left"><?php echo $matConsData['TYRES_QUANTITY']; ?></td>
                                    <td align="left"><?php echo $matConsData['TYRES_VALUE']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="3"><?php echo $label['material_consumption_quantity'][19]; ?></td>
                                    <td align="left"><?php echo $matConsData['TIMBER_VALUE']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['material_consumption_quantity'][20]; ?></td>
                                    <td align="left"><?php echo $label['material_consumption_quantity']['nos']; ?></td>
                                    <td align="left"><?php echo $matConsData['DRILL_QUANTITY']; ?></td>
                                    <td align="left"><?php echo $matConsData['DRILL_VALUE']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="3"><?php echo $label['material_consumption_quantity'][21]; ?></td>
                                    <td align="left"><?php echo $matConsData['OTHER_VALUE']; ?></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                
                <!-- MATERIAL CONSUMPTION QUANTITY -->
                <tr>
                    <td align="center">
                        <div id="material_consumption_royalty">
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                <tr>
                                    <td align="left" colspan="7"><?php echo $label['material_consumption_royalty'][0]; ?></td>
                                </tr>
                                <tr>
                                    <td align="center" colspan="3"></td>
                                    <td align="center" colspan="2"><?php echo $label['material_consumption_royalty'][1]; ?></td>
                                    <td align="center" colspan="2"><?php echo $label['material_consumption_royalty'][2]; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="3"><?php echo $label['material_consumption_royalty'][3]; ?></td>
                                    <td align="center" colspan="2"><?php echo $matConsRoyData['ROYALTY_CURRENT']; ?></td>
                                    <td align="center" colspan="2"><?php echo $matConsRoyData['ROYALTY_PAST']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="3"><?php echo $label['material_consumption_royalty'][4]; ?></td>
                                    <td align="center" colspan="2"><?php echo $matConsRoyData['DEAD_RENT_CURRENT']; ?></td>
                                    <td align="center" colspan="2"><?php echo $matConsRoyData['DEAD_RENT_PAST']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="3"><?php echo $label['material_consumption_royalty'][5]; ?></td>
                                    <td align="center" colspan="2"><?php echo $matConsRoyData['SURFACE_RENT_CURRENT']; ?></td>
                                    <td align="center" colspan="2"><?php echo $matConsRoyData['SURFACE_RENT_PAST']; ?></td>
                                </tr>
                                <!-- Added four new fields below as per MCDR 2017 -->
                                <!-- "CURRENT_PAY_DMF", "PAST_PAY_DMF", "CURRENT_PAY_NMET", "PAST_PAY_NMET" -->
                                <tr>
                                    <td align="left" colspan="3"><?php echo $label['material_consumption_royalty'][6]; ?></td>
                                    <td align="center" colspan="2"><?php echo $matConsRoyData['CURRENT_PAY_DMF']; ?></td>
                                    <td align="center" colspan="2"><?php echo $matConsRoyData['PAST_PAY_DMF']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="3"><?php echo $label['material_consumption_royalty'][7]; ?></td>
                                    <td align="center" colspan="2"><?php echo $matConsRoyData['CURRENT_PAY_NMET']; ?></td>
                                    <td align="center" colspan="2"><?php echo $matConsRoyData['PAST_PAY_NMET']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="5"><?php echo $label['material_consumption_royalty'][8]; ?></td>
                                    <td align="center" colspan="2"><?php echo $matConsRoyData['TREE_COMPENSATION']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="5"><?php echo $label['material_consumption_royalty'][9]; ?></td>
                                    <td align="center" colspan="2"><?php echo $matConsRoyData['DEPRECIATION']; ?></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                
                <!-- MATERIAL CONSUMPTION TAX -->
                <tr>
                    <td align="center">
                        <div id="material_consumption_tax">
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                <tr>
                                    <td align="left" colspan="7"><?php echo $label['material_consumption_tax'][0]; ?></td>
                                </tr>
                                <tr>
                                    <td align="center" colspan="3" rowspan="2"></td>
                                    <td align="center" colspan="4"><?php echo $label['material_consumption_tax'][1]; ?></td>
                                </tr>
                                <tr>
                                    <td align="center" colspan="2"><?php echo $label['material_consumption_tax'][2]; ?></td>
                                    <td align="center" colspan="2"><?php echo $label['material_consumption_tax'][3]; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="3">(i)<?php echo $label['material_consumption_tax'][4]; ?></td>
                                    <td align="center" colspan="2"><?php echo $matConsTaxData['SALES_TAX_CENTRAL']; ?></td>
                                    <td align="center" colspan="2"><?php echo $matConsTaxData['SALES_TAX_STATE']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="3">(ii)<?php echo $label['material_consumption_tax'][5]; ?></td>
                                    <td align="center" colspan="2"><?php echo $matConsTaxData['WELFARE_TAX_CENTRAL']; ?></td>
                                    <td align="center" colspan="2"><?php echo $matConsTaxData['WELFARE_TAX_STATE']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="7">(iii)<?php echo $label['material_consumption_tax'][6]; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="3"><?php echo $label['material_consumption_tax'][7]; ?></td>
                                    <td align="center" colspan="2"><?php echo $matConsTaxData['MIN_CESS_TAX_CENTRAL']; ?></td>
                                    <td align="center" colspan="2"><?php echo $matConsTaxData['MIN_CESS_TAX_STATE']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="3"><?php echo $label['material_consumption_tax'][8]; ?></td>
                                    <td align="center" colspan="2"><?php echo $matConsTaxData['DEAD_CESS_TAX_CENTRAL']; ?></td>
                                    <td align="center" colspan="2"><?php echo $matConsTaxData['DEAD_CESS_TAX_STATE']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="3">
                                        <?php echo $label['material_consumption_tax'][9]; ?><br>
                                        <?php echo $matConsTaxData['OTHER_TAX']; ?>
                                    </td>
                                    <td align="center" colspan="2"><?php echo $matConsTaxData['OTHER_TAX_CENTRAL']; ?></td>
                                    <td align="center" colspan="2"><?php echo $matConsTaxData['OTHER_TAX_STATE']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="7"><?php echo $label['material_consumption_tax'][10]; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="5">(i)<?php echo $label['material_consumption_tax'][11]; ?></td>
                                    <td align="center" colspan="2"><?php echo $matConsTaxData['OVERHEADS']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="5">(ii)<?php echo $label['material_consumption_tax'][12]; ?></td>
                                    <td align="center" colspan="2"><?php echo $matConsTaxData['MAINTENANCE']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="5">(iii)<?php echo $label['material_consumption_tax'][13]; ?></td>
                                    <td align="center" colspan="2"><?php echo $matConsTaxData['WORKMEN_BENEFITS']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="5">(iv)<?php echo $label['material_consumption_tax'][14]; ?></td>
                                    <td align="center" colspan="2"><?php echo $matConsTaxData['PAYMENT_AGENCIES']; ?></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                
                <!----------------------- PART - IV - ANNUAL RETURNS ---------------------->

                <!-- EXPLOSIVE CONSUMPTION -->
                <br pagebreak="true" />
                <tr>
                    <td align="center"><span style="margin-left:50px"><strong><?php echo $label['explosive_consumption']['part']; ?></strong></span></td>
                </tr>
                <tr><td></td></tr>
                <tr>
                    <td align="center">
                        <div id="explosive_consumption">
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                <tr>
                                    <td align="left"><?php echo $label['explosive_consumption'][0]; ?></td>
                                    <td align="center">
                                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                            <tr>
                                                <td><?php echo $label['explosive_consumption'][1]; ?></td>
                                                <td><?php echo $label['explosive_consumption'][2]; ?></td>
                                                <td><?php echo $label['explosive_consumption'][3]; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $label['explosive_consumption'][4]; ?></td>
                                                <td><?php echo $label['explosive_consumption'][7]; ?></td>
                                                <td><?php echo $explReturn['MAG_CAPACITY_EXP']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $label['explosive_consumption'][5]; ?></td>
                                                <td><?php echo $label['explosive_consumption'][8]; ?></td>
                                                <td><?php echo $explReturn['MAG_CAPACITY_DET']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $label['explosive_consumption'][6]; ?></td>
                                                <td><?php echo $label['explosive_consumption'][9]; ?></td>
                                                <td><?php echo $explReturn['MAG_CAPACITY_FUSE']; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <div id="explosive_consumption">
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                <tr>
                                    <td align="center" rowspan="2"><?php echo $label['explosive_consumption'][10]; ?></td>
                                    <td align="center" rowspan="2"><?php echo $label['explosive_consumption'][2]; ?></td>
                                    <td align="center" colspan="2"><?php echo $label['explosive_consumption'][11]; ?></td>
                                    <td align="center" colspan="2"><?php echo $label['explosive_consumption'][12]; ?></td>
                                </tr>
                                <tr>
                                    <td align="center"><?php echo $label['explosive_consumption'][13]; ?></td>
                                    <td align="center"><?php echo $label['explosive_consumption'][14]; ?></td>
                                    <td align="center"><?php echo $label['explosive_consumption'][13]; ?></td>
                                    <td align="center"><?php echo $label['explosive_consumption'][14]; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['explosive_consumption'][15]; ?></td>
                                    <td align="center"><?php echo $label['explosive_consumption'][7]; ?></td>
                                    <td align="center" colspan="2"><?php $explConsum['LARGE_CON_QTY']; ?></td>
                                    <td align="center" colspan="2"><?php $explConsum['LARGE_REQ_QTY']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="6"><?php echo $label['explosive_consumption'][16]; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['explosive_consumption'][17]; ?></td>
                                    <td align="center"><?php echo $label['explosive_consumption'][7]; ?></td>
                                    <td align="center"><?php echo $explConsum['SMALL_CON_QTY_1']; ?></td>
                                    <td align="center"><?php echo $explConsum['LARGE_CON_QTY_1']; ?></td>
                                    <td align="center"><?php echo $explConsum['SMALL_REQ_QTY_1']; ?></td>
                                    <td align="center"><?php echo $explConsum['LARGE_REQ_QTY_1']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['explosive_consumption'][18]; ?></td>
                                    <td align="center"><?php echo $label['explosive_consumption'][7]; ?></td>
                                    <td align="center"><?php echo $explConsum['SMALL_CON_QTY_2']; ?></td>
                                    <td align="center"><?php echo $explConsum['LARGE_CON_QTY_2']; ?></td>
                                    <td align="center"><?php echo $explConsum['SMALL_REQ_QTY_2']; ?></td>
                                    <td align="center"><?php echo $explConsum['LARGE_REQ_QTY_2']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['explosive_consumption'][19]; ?></td>
                                    <td align="center"><?php echo $label['explosive_consumption'][7]; ?></td>
                                    <td align="center"><?php echo $explConsum['SMALL_CON_QTY_3']; ?></td>
                                    <td align="center"><?php echo $explConsum['LARGE_CON_QTY_3']; ?></td>
                                    <td align="center"><?php echo $explConsum['SMALL_REQ_QTY_3']; ?></td>
                                    <td align="center"><?php echo $explConsum['LARGE_REQ_QTY_3']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['explosive_consumption'][20]; ?></td>
                                    <td align="center"><?php echo $label['explosive_consumption'][7]; ?></td>
                                    <td align="center"><?php echo $explConsum['SMALL_CON_QTY_4']; ?></td>
                                    <td align="center"><?php echo $explConsum['LARGE_CON_QTY_4']; ?></td>
                                    <td align="center"><?php echo $explConsum['SMALL_REQ_QTY_4']; ?></td>
                                    <td align="center"><?php echo $explConsum['LARGE_REQ_QTY_4']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $explConsum['SLURRY_TN']; ?></td>
                                    <td align="center"><?php echo $label['explosive_consumption'][7]; ?></td>
                                    <td align="center"><?php echo $explConsum['SMALL_CON_QTY_5']; ?></td>
                                    <td align="center"><?php echo $explConsum['LARGE_CON_QTY_5']; ?></td>
                                    <td align="center"><?php echo $explConsum['SMALL_REQ_QTY_5']; ?></td>
                                    <td align="center"><?php echo $explConsum['LARGE_REQ_QTY_5']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="6"><?php echo $label['explosive_consumption'][22]; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['explosive_consumption'][23]; ?></td>
                                    <td align="center"><?php echo $label['explosive_consumption'][8]; ?></td>
                                    <td align="center" colspan="2"><?php echo$explConsum['LARGE_CON_QTY_6']; ?></td>
                                    <td align="center" colspan="2"><?php echo$explConsum['LARGE_REQ_QTY_6']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="6"><?php echo $label['explosive_consumption'][24]; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['explosive_consumption'][25]; ?></td>
                                    <td align="center"><?php echo $label['explosive_consumption'][8]; ?></td>
                                    <td align="center" colspan="2"><?php echo$explConsum['LARGE_CON_QTY_8']; ?></td>
                                    <td align="center" colspan="2"><?php echo$explConsum['LARGE_REQ_QTY_8']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['explosive_consumption'][26]; ?></td>
                                    <td align="center"><?php echo $label['explosive_consumption'][8]; ?></td>
                                    <td align="center" colspan="2"><?php echo $explConsum['LARGE_CON_QTY_9']; ?></td>
                                    <td align="center" colspan="2"><?php echo $explConsum['LARGE_REQ_QTY_9']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="6"><?php echo $label['explosive_consumption'][27]; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['explosive_consumption'][28]; ?></td>
                                    <td align="center"><?php echo $label['explosive_consumption'][9]; ?></td>
                                    <td align="center" colspan="2"><?php echo $explConsum['LARGE_CON_QTY_11']; ?></td>
                                    <td align="center" colspan="2"><?php echo $explConsum['LARGE_REQ_QTY_11']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['explosive_consumption'][29]; ?></td>
                                    <td align="center"><?php echo $label['explosive_consumption'][9]; ?></td>
                                    <td align="center" colspan="2"><?php echo $explConsum['LARGE_CON_QTY_12']; ?></td>
                                    <td align="center" colspan="2"><?php echo $explConsum['LARGE_REQ_QTY_12']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['explosive_consumption'][30]; ?></td>
                                    <td align="center"><?php echo $label['explosive_consumption'][9]; ?></td>
                                    <td align="center" colspan="2"><?php echo $explConsum['LARGE_CON_QTY_13']; ?></td>
                                    <td align="center" colspan="2"><?php echo $explConsum['LARGE_REQ_QTY_13']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['explosive_consumption'][31]; ?><?php echo $explConsum['OTHER_EXPLOSIVES']; ?></td>
                                    <td align="center"><?php echo $explConsum['OTHER_UNIT']; ?></td>
                                    <td align="center" colspan="2"><?php echo $explConsum['LARGE_CON_QTY_14']; ?></td>
                                    <td align="center" colspan="2"><?php echo $explConsum['LARGE_REQ_QTY_14']; ?></td>
                                </tr>
                                <tr>
                                   <td align="left" colspan="6"><?php echo $label['explosive_consumption'][32]; ?></td> 
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>

                <!----------------------- PART - V - ANNUAL RETURNS ----------------------->

                <!-- SEC 1: EXPLORATION -->
                <br pagebreak="true" />
                <tr>
                    <td align="center"><span style="margin-left:50px"><strong><?php echo $label['geology_exploration']['part']; ?></strong></span></td>
                </tr>
                <tr>
                    <td align="center" class="f_s_9">(Items 2 and 3 to be submitted separately for each mineral)</td>
                </tr>
                <tr><td></td></tr>
                <tr>
                    <td align="center"><span style="margin-left:50px"><strong><?php echo $label['geology_exploration']['title']; ?></strong></span></td>
                </tr>
                <tr>
                    <td align="center">
                        <div id="geology_exploration">
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                <tr>
                                    <td align="left" colspan="2"><?php echo $label['geology_exploration'][0]; ?></td>
                                </tr>
                                <tr>
                                    <td align="center" colspan="2">
                                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td><?php echo $label['geology_exploration'][1]; ?></td>
                                                <td><?php echo $label['geology_exploration'][2]; ?></td>
                                                <td><?php echo $label['geology_exploration'][3]; ?></td>
                                                <td><?php echo $label['geology_exploration'][4]; ?></td>
                                            </tr>
                                            <tr>
                                                <td rowspan="2"><?php echo $label['geology_exploration'][5]; ?></td>
                                                <td><?php echo $label['geology_exploration'][6]; ?></td>
                                                <td><?php echo $geoExp['begin_holes_drilling']; ?></td>
                                                <td><?php echo $geoExp['during_holes_drilling']; ?></td>
                                                <td><?php echo $geoExp['cumu_holes_drilling']; ?></td>
                                                <td><?php echo $geoExp['gride_holes_drilling']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $label['geology_exploration'][7]; ?></td>
                                                <td><?php echo $geoExp['begin_metrage_drilling']; ?></td>
                                                <td><?php echo $geoExp['during_metrage_drilling']; ?></td>
                                                <td><?php echo $geoExp['cumu_metrage_drilling']; ?></td>
                                                <td><?php echo $geoExp['gride_metrage_drilling']; ?></td>
                                            </tr>
                                            <tr>
                                                <td rowspan="2"><?php echo $label['geology_exploration'][8]; ?></td>
                                                <td><?php echo $label['geology_exploration'][9]; ?></td>
                                                <td><?php echo $geoExp['begin_pits_pitting']; ?></td>
                                                <td><?php echo $geoExp['during_pits_pitting']; ?></td>
                                                <td><?php echo $geoExp['cumu_pits_pitting']; ?></td>
                                                <td><?php echo $geoExp['gride_pits_pitting']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $label['geology_exploration'][10]; ?></td>
                                                <td><?php echo $geoExp['begin_excav_pitting']; ?></td>
                                                <td><?php echo $geoExp['during_excav_pitting']; ?></td>
                                                <td><?php echo $geoExp['cumu_excav_pitting']; ?></td>
                                                <td><?php echo $geoExp['gride_excav_pitting']; ?></td>
                                            </tr>
                                            <tr>
                                                <td rowspan="3"><?php echo $label['geology_exploration'][11]; ?></td>
                                                <td><?php echo $label['geology_exploration'][12]; ?></td>
                                                <td><?php echo $geoExp['begin_trenches_trench']; ?></td>
                                                <td><?php echo $geoExp['during_trenches_trench']; ?></td>
                                                <td><?php echo $geoExp['cumu_trenches_trench']; ?></td>
                                                <td><?php echo $geoExp['gride_trenches_trench']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $label['geology_exploration'][13]; ?></td>
                                                <td><?php echo $geoExp['begin_excav_trench']; ?></td>
                                                <td><?php echo $geoExp['during_excav_trench']; ?></td>
                                                <td><?php echo $geoExp['cumu_excav_trench']; ?></td>
                                                <td><?php echo $geoExp['gride_excav_trench']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $label['geology_exploration'][14]; ?></td>
                                                <td><?php echo $geoExp['begin_length_trench']; ?></td>
                                                <td><?php echo $geoExp['during_length_trench']; ?></td>
                                                <td><?php echo $geoExp['cumu_length_trench']; ?></td>
                                                <td><?php echo $geoExp['gride_length_trench']; ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><?php echo $label['geology_exploration'][15]; ?></td>
                                                <td><?php echo $geoExp['begin_expenditure']; ?></td>
                                                <td><?php echo $geoExp['during_expenditure']; ?></td>
                                                <td><?php echo $geoExp['cumu_expenditure']; ?></td>
                                                <td><?php echo $geoExp['gride_expenditure']; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['geology_exploration'][16]; ?></td>
                                    <td align="center"><?php echo $geoExp['other_explor_activity']; ?></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                
                <!-- SEC 2/3: GEOLOGY RESERVES SUBGRADE -->

                <?php 
                foreach ($allMin as $min) {
                    $min_un = strtolower(str_replace(' ','_',$min));
                    ?>
                    <tr>
                        <td align="center"><span style="margin-left:50px"><strong><?php echo $label['geology_reserves_subgrade']['title']; ?> (<?php echo $min;?>)</strong></span></td>
                    </tr>
                    <tr>
                        <td align="center">
                            <div id="geology_reserves_subgrade">
                                <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;" nobr="true" class="f_s_9">
                                    <tr>
                                        <td><?php echo $label['geology_reserves_subgrade'][0]; ?></td>
                                        <td><?php echo $label['geology_reserves_subgrade'][1]; ?></td>
                                        <td><?php echo $label['geology_reserves_subgrade'][2]; ?></td>
                                        <td><?php echo $label['geology_reserves_subgrade'][3]; ?></td>
                                        <td><?php echo $label['geology_reserves_subgrade'][4]; ?></td>
                                        <td><?php echo $label['geology_reserves_subgrade'][5]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>(1)</td>
                                        <td>(2)</td>
                                        <td>(3)</td>
                                        <td>(4)</td>
                                        <td>(5)</td>
                                        <td>(6)= (3+4-5)</td>
                                    </tr>
                                    <tr>
                                        <td align="left" colspan="6"><?php echo $label['geology_reserves_subgrade'][6]; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><?php echo $label['geology_reserves_subgrade'][7]; ?></td>
                                        <td>111</td>
                                        <td><?php echo $reserves[$min_un]['proved_begin']; ?></td>
                                        <td><?php echo $reserves[$min_un]['proved_assessed_during']; ?></td>
                                        <td><?php echo $reserves[$min_un]['proved_depletion']; ?></td>
                                        <td><?php echo $reserves[$min_un]['proved_balance']; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left" rowspan="2"><?php echo $label['geology_reserves_subgrade'][8]; ?></td>
                                        <td>121</td>
                                        <td><?php echo $reserves[$min_un]['probable_first_begin']; ?></td>
                                        <td><?php echo $reserves[$min_un]['probable_first_assessed_during']; ?></td>
                                        <td><?php echo $reserves[$min_un]['probable_first_depletion']; ?></td>
                                        <td><?php echo $reserves[$min_un]['probable_first_balance']; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left">122</td>
                                        <td><?php echo $reserves[$min_un]['probable_sec_begin']; ?></td>
                                        <td><?php echo $reserves[$min_un]['probable_sec_assessed_during']; ?></td>
                                        <td><?php echo $reserves[$min_un]['probable_sec_depletion']; ?></td>
                                        <td><?php echo $reserves[$min_un]['probable_sec_balance']; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><?php echo $label['geology_reserves_subgrade'][9]; ?></td>
                                        <td></td>
                                        <td>
                                            <?php echo $resTotal['begin'] = ((int)$reserves[$min_un]['proved_begin'] + (int)$reserves[$min_un]['probable_first_begin'] + (int)$reserves[$min_un]['probable_sec_begin']); ?>
                                        </td>
                                        <td>
                                            <?php echo $resTotal['during'] = ((int)$reserves[$min_un]['proved_assessed_during'] + (int)$reserves[$min_un]['probable_first_assessed_during'] + (int)$reserves[$min_un]['probable_sec_assessed_during']); ?>
                                        </td>
                                        <td>
                                            <?php echo $resTotal['depletion'] = ((int)$reserves[$min_un]['proved_depletion'] + (int)$reserves[$min_un]['probable_first_depletion'] + (int)$reserves[$min_un]['probable_sec_depletion']); ?>
                                        </td>
                                        <td>
                                            <?php echo $resTotal['balance'] = ((int)$reserves[$min_un]['proved_balance'] + (int)$reserves[$min_un]['probable_first_balance'] + (int)$reserves[$min_un]['probable_sec_balance']); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" colspan="6"><?php echo $label['geology_reserves_subgrade'][10]; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><?php echo $label['geology_reserves_subgrade'][11]; ?></td>
                                        <td>211</td>
                                        <td><?php echo $reserves[$min_un]['feasibility_begin']; ?></td>
                                        <td><?php echo $reserves[$min_un]['feasibility_assessed_during']; ?></td>
                                        <td><?php echo $reserves[$min_un]['feasibility_depletion']; ?></td>
                                        <td><?php echo $reserves[$min_un]['feasibility_balance']; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left" rowspan="2"><?php echo $label['geology_reserves_subgrade'][12]; ?></td>
                                        <td>221</td>
                                        <td><?php echo $reserves[$min_un]['prefeasibility_first_begin']; ?></td>
                                        <td><?php echo $reserves[$min_un]['prefeasibility_first_assessed_during']; ?></td>
                                        <td><?php echo $reserves[$min_un]['prefeasibility_first_depletion']; ?></td>
                                        <td><?php echo $reserves[$min_un]['prefeasibility_first_balance']; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left">222</td>
                                        <td><?php echo $reserves[$min_un]['prefeasibility_sec_begin']; ?></td>
                                        <td><?php echo $reserves[$min_un]['prefeasibility_sec_assessed_during']; ?></td>
                                        <td><?php echo $reserves[$min_un]['prefeasibility_sec_depletion']; ?></td>
                                        <td><?php echo $reserves[$min_un]['prefeasibility_sec_balance']; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><?php echo $label['geology_reserves_subgrade'][13]; ?></td>
                                        <td>331</td>
                                        <td><?php echo $reserves[$min_un]['measured_begin']; ?></td>
                                        <td><?php echo $reserves[$min_un]['measured_assessed_during']; ?></td>
                                        <td><?php echo $reserves[$min_un]['measured_sec_depletion']; ?></td>
                                        <td><?php echo $reserves[$min_un]['measured_sec_balance']; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><?php echo $label['geology_reserves_subgrade'][14]; ?></td>
                                        <td>332</td>
                                        <td><?php echo $reserves[$min_un]['indicated_begin']; ?></td>
                                        <td><?php echo $reserves[$min_un]['indicated_assessed_during']; ?></td>
                                        <td><?php echo $reserves[$min_un]['indicated_sec_depletion']; ?></td>
                                        <td><?php echo $reserves[$min_un]['indicated_sec_balance']; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><?php echo $label['geology_reserves_subgrade'][15]; ?></td>
                                        <td>333</td>
                                        <td><?php echo $reserves[$min_un]['inferred_begin']; ?></td>
                                        <td><?php echo $reserves[$min_un]['inferred_assessed_during']; ?></td>
                                        <td><?php echo $reserves[$min_un]['inferred_sec_depletion']; ?></td>
                                        <td><?php echo $reserves[$min_un]['inferred_sec_balance']; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><?php echo $label['geology_reserves_subgrade'][16]; ?></td>
                                        <td>334</td>
                                        <td><?php echo $reserves[$min_un]['reconnaissance_begin']; ?></td>
                                        <td><?php echo $reserves[$min_un]['reconnaissance_assessed_during']; ?></td>
                                        <td><?php echo $reserves[$min_un]['reconnaissance_sec_depletion']; ?></td>
                                        <td><?php echo $reserves[$min_un]['reconnaissance_sec_balance']; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><?php echo $label['geology_reserves_subgrade'][17]; ?></td>
                                        <td></td>
                                        <td>
                                            <?php echo $totRemRes['begin'] = ((int)$reserves[$min_un]['feasibility_begin'] + (int)$reserves[$min_un]['prefeasibility_first_begin'] + (int)$reserves[$min_un]['prefeasibility_sec_begin'] + (int)$reserves[$min_un]['measured_begin'] + (int)$reserves[$min_un]['indicated_begin'] + (int)$reserves[$min_un]['inferred_begin'] + (int)$reserves[$min_un]['reconnaissance_begin']); ?>
                                        </td>
                                        <td>
                                            <?php echo $totRemRes['during'] = ((int)$reserves[$min_un]['feasibility_assessed_during'] + (int)$reserves[$min_un]['prefeasibility_first_assessed_during'] + (int)$reserves[$min_un]['prefeasibility_sec_assessed_during'] + (int)$reserves[$min_un]['measured_assessed_during'] + (int)$reserves[$min_un]['indicated_assessed_during'] + (int)$reserves[$min_un]['inferred_assessed_during'] + (int)$reserves[$min_un]['reconnaissance_assessed_during']); ?>
                                        </td>
                                        <td>
                                            <?php echo $totRemRes['depletion'] = ((int)$reserves[$min_un]['feasibility_depletion'] + (int)$reserves[$min_un]['prefeasibility_first_depletion'] + (int)$reserves[$min_un]['prefeasibility_sec_depletion'] + (int)$reserves[$min_un]['measured_sec_depletion'] + (int)$reserves[$min_un]['indicated_sec_depletion'] + (int)$reserves[$min_un]['inferred_sec_depletion'] + (int)$reserves[$min_un]['reconnaissance_sec_depletion']); ?>
                                        </td>
                                        <td>
                                            <?php echo $totRemRes['balance'] = ((int)$reserves[$min_un]['feasibility_balance'] + (int)$reserves[$min_un]['prefeasibility_first_balance'] + (int)$reserves[$min_un]['prefeasibility_sec_balance'] + (int)$reserves[$min_un]['measured_sec_balance'] + (int)$reserves[$min_un]['indicated_sec_balance'] + (int)$reserves[$min_un]['inferred_sec_balance'] + (int)$reserves[$min_un]['reconnaissance_sec_balance']); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left"><?php echo $label['geology_reserves_subgrade'][18]; ?></td>
                                        <td></td>
                                        <td>
                                            <?php echo ($resTotal['begin'] + $totRemRes['begin']); ?>
                                        </td>
                                        <td>
                                            <?php echo ($resTotal['during'] + $totRemRes['during']); ?>
                                        </td>
                                        <td>
                                            <?php echo ($resTotal['depletion'] + $totRemRes['depletion']); ?>
                                        </td>
                                        <td>
                                            <?php echo ($resTotal['balance'] + $totRemRes['balance']); ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td align="center">
                            <span style="margin-left:50px"><strong><?php echo $label['geology_reserves_subgrade']['title_two']; ?> (<?php echo $min;?>)</strong></span>
                            
                        </td>
                    </tr>
                    <tr>
                        <td class="f_s_9">(<?php echo $label['geology_reserves_subgrade'][19]; ?>)</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <div id="geology_reserves_subgrade">
                                <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                    <tr>
                                        <td><?php echo $label['geology_reserves_subgrade'][20]; ?></td>
                                        <td><?php echo $label['geology_reserves_subgrade'][21]; ?></td>
                                        <td><?php echo $label['geology_reserves_subgrade'][22]; ?></td>
                                        <td><?php echo $label['geology_reserves_subgrade'][23]; ?></td>
                                        <td><?php echo $label['geology_reserves_subgrade'][24]; ?></td>
                                        <td><?php echo $label['geology_reserves_subgrade'][25]; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><?php echo $label['geology_reserves_subgrade'][26]; ?></td>
                                        <td><?php echo $subgrade[$min_un]['unprocessed_begin']; ?></td>
                                        <td><?php echo $subgrade[$min_un]['unprocessed_generated']; ?></td>
                                        <td><?php echo $subgrade[$min_un]['unprocessed_disposed']; ?></td>
                                        <td><?php echo $subgrade[$min_un]['unprocessed_total']; ?></td>
                                        <td><?php echo $subgrade[$min_un]['unprocessed_average']; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><?php echo $label['geology_reserves_subgrade'][27]; ?></td>
                                        <td><?php echo $subgrade[$min_un]['processed_begin']; ?></td>
                                        <td><?php echo $subgrade[$min_un]['processed_generated']; ?></td>
                                        <td><?php echo $subgrade[$min_un]['processed_disposed']; ?></td>
                                        <td><?php echo $subgrade[$min_un]['processed_total']; ?></td>
                                        <td><?php echo $subgrade[$min_un]['processed_average']; ?></td>
                                    </tr>
                                   
                                </table>
                            </div>
                        </td>
                    </tr>

                <?php } ?>

                <!-- SEC 4/5: OVERBURDEN AND WASTE / TREES PLANTED- SURVIVAL RATE -->
                <tr>
                    <td align="center"><span style="margin-left:50px"><strong><?php echo $label['geology_overburden_trees']['title']; ?></strong></span>
                    </td>
                </tr>
                <tr>
                    <td class="f_s_9"><?php echo $label['geology_overburden_trees'][0]; ?></td>
                </tr>
                <tr>
                    <td align="center">
                        <div id="geology_overburden">
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                <tr>
                                    <td><?php echo $label['geology_overburden_trees'][1]; ?></td>
                                    <td><?php echo $label['geology_overburden_trees'][2]; ?></td>
                                    <td><?php echo $label['geology_overburden_trees'][3]; ?></td>
                                    <td><?php echo $label['geology_overburden_trees'][4]; ?></td>
                                    <td><?php echo $label['geology_overburden_trees'][5]; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $overburden['at_begining_yr']; ?></td>
                                    <td><?php echo $overburden['generated_dy']; ?></td>
                                    <td><?php echo $overburden['disposed_dy']; ?></td>
                                    <td><?php echo $overburden['backfilled_dy']; ?></td>
                                    <td><?php echo $overburden['total_at_eoy']; ?></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="center"><span style="margin-left:50px"><strong><?php echo $label['geology_overburden_trees'][6]; ?></strong></span></td>
                </tr>
                <tr>
                    <td align="center">
                        <div id="geology_trees">
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                <tr>
                                    <td><?php echo $label['geology_overburden_trees'][7]; ?></td>
                                    <td><?php echo $label['geology_overburden_trees'][8]; ?></td>
                                    <td><?php echo $label['geology_overburden_trees'][9]; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['geology_overburden_trees'][10]; ?></td>
                                    <td><?php echo $treesPlant['trees_wi_lease']; ?></td>
                                    <td><?php echo $treesPlant['trees_os_lease']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['geology_overburden_trees'][11]; ?></td>
                                    <td><?php echo $treesPlant['surv_wi_lease']; ?></td>
                                    <td><?php echo $treesPlant['surv_os_lease']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left"><?php echo $label['geology_overburden_trees'][12]; ?></td>
                                    <td><?php echo $treesPlant['ttl_eoy_wi_lease']; ?></td>
                                    <td><?php echo $treesPlant['ttl_eoy_os_lease']; ?></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>

                <!-- SEC 6. TYPE OF MACHINERY -->
                <tr>
                    <td align="center"><span style="margin-left:50px"><strong><?php echo $label['geology_part_three']['title']; ?></strong></span></td>
                </tr>
                <tr><td class="f_s_9">(<?php echo $label['geology_part_three'][0]; ?>)</td></tr>
                <tr>
                    <td align="center">
                        <div id="geology_trees">
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                <tr>
                                    <td><?php echo $label['geology_part_three'][1]; ?></td>
                                    <td><?php echo $label['geology_part_three'][2]; ?></td>
                                    <td><?php echo $label['geology_part_three'][3]; ?></td>
                                    <td><?php echo $label['geology_part_three'][4]; ?></td>
                                    <td><?php echo $label['geology_part_three'][5]; ?></td>
                                    <td><?php echo $label['geology_part_three'][6]; ?></td>
                                </tr>
                                <?php 
                                $agg_count = $machinery['aggregation']['aggregation_count'];
                                $row = $machinery['aggregation'];
                                for ($i=1; $i <= $agg_count; $i++) {
                                    ?>
                                    <tr>
                                        <td align="left"><?php echo ($row['machine_select_'.$i] == 0 || $row['machine_select_'.$i] == 'NIL') ? 'NIL' : $machineryTypeArr[$row['machine_select_'.$i]]; ?></td>
                                        <td><?php echo $row['capacity_box_'.$i]; ?></td>
                                        <td><?php echo $row['unit_box_'.$i]; ?></td>
                                        <td><?php echo $row['no_of_machinery_'.$i]; ?></td>
                                        <td><?php echo ($row['electrical_select_'.$i] == 0 || $row['electrical_select_'.$i] == 'NIL') ? 'NIL' : $label['geology_part_three']['electric_option'][$row['electrical_select_'.$i]]; ?></td>
                                        <td><?php echo ($row['opencast_select_'.$i] == 0 || $row['opencast_select_'.$i] == 'NIL') ? 'NIL' : $label['geology_part_three']['opencast_option'][$row['opencast_select_'.$i]]; ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                </tr>

                <!-- SEC 7. MINERAL TREATMENT PLANT -->
                <?php 
                foreach ($allMin as $min) {
                    $min_un = strtolower(str_replace(' ','_',$min));
                    ?>
                    <tr>
                        <td align="center"><span style="margin-left:50px"><strong><?php echo $label['geology_part_six']['title']; ?> (<?php echo $min; ?>)</strong></span></td>
                    </tr>
                    <tr>
                        <td align="center">
                            <div id="geology_part_six">
                                <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                    <tr>
                                        <td align="left"><?php echo $label['geology_part_six'][0]; ?></td>
                                        <td><?php echo $minTreatPlant[$min_un]['static']['MIN_TREATMENT_PLANT']; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left" colspan="2"><?php echo $label['geology_part_six'][1]; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;" class="f_s_9">
                                                <tr>
                                                    <td colspan="2"><?php echo $label['geology_part_six'][2]; ?></td>
                                                    <td><?php echo $label['geology_part_six'][3]; ?></td>
                                                    <td><?php echo $label['geology_part_six'][4]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td align="left" colspan="2"><?php echo $label['geology_part_six'][5]; ?></td>
                                                    <td><?php echo $minTreatPlant[$min_un]['static']['FEED_TONNAGE']; ?></td>
                                                    <td><?php echo $minTreatPlant[$min_un]['static']['FEED_AVG_GRADE']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td align="left"><?php echo $label['geology_part_six'][6]; ?></td>
                                                    <td><?php echo $label['geology_part_six'][7]; ?></td>
                                                    <td><?php echo $minTreatPlant[$min_un]['static']['CONCEN_TONNAGE']; ?></td>
                                                    <td><?php echo $minTreatPlant[$min_un]['static']['CONCEN_AVG_GRADE']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td align="left"><?php echo $label['geology_part_six'][8]; ?></td>
                                                    <td><?php echo $label['geology_part_six'][7]; ?></td>
                                                    <td><?php echo $minTreatPlant[$min_un]['static']['BY_PRO_TONNAGE']; ?></td>
                                                    <td><?php echo $minTreatPlant[$min_un]['static']['BY_PRO_AVG_GRADE']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td align="left" colspan="2"><?php echo $label['geology_part_six'][9]; ?></td>
                                                    <td><?php echo $minTreatPlant[$min_un]['static']['TAIL_TONNAGE']; ?></td>
                                                    <td><?php echo $minTreatPlant[$min_un]['static']['TAIL_AVG_GRADE']; ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>

                <?php } ?>
            
            <?php } ?>

            
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

            //set different grades if IRON ORE or CHROMITE is primary mineral
			$rom_grade = false;
			$mineral_sp = strtoupper(str_replace('_', ' ', $mineral));

			if(in_array($mineral_sp, array('IRON ORE', 'CHROMITE'))){
                $rom_grade = true;
			}

            ?>
            <br pagebreak="true" />
            <tr>
                <td align="center"><span style="margin-left:50px"><strong><?php echo $label['rom_stocks']['part']; ?></strong></span><br>
                    <small>(To be submitted separately for each mineral)</small>
                </td>
            </tr>
            <tr><td></td></tr>

            <!--=======GETTING FORM TYPE BASED ON THE MINERAL NAME=====-->
            <?php if($partIIM1['formNo'] == 5) { ?>
                <?php 
                    
                    $allRomData = array();
                    $os = array();
                    $pro = array();
                    $cs = array();
                                        
                    foreach($romDataOre[$minLow] as $row => $value) 
                    {
                        foreach ($value['metal'] as $met_key => $met_value) 
                        {
                            $Mgrade = 0;
                            $tot_qty = ($value['tot_qty'][0]=='') ? '0' : $value['tot_qty'][0]; 
                            $grade = ($value['grade'][$met_key]=='') ? '0' : $value['grade'][$met_key]; 
                            if($tot_qty != 0 && $grade !=0)
                            {
                                $Mgrade = ($value['tot_qty'][0] * $value['grade'][$met_key]); 
                            }
                            $single_arr = array(
                                'metal'=>$met_value,
                                'grade'=> $Mgrade,
                                'total'=>$value['tot_qty'][0],
                            );
                            if($row == 1 || $row == 4 || $row == 7)
                            {  array_push($os, $single_arr); }
                            else if($row == 2 || $row == 5 || $row == 8)
                            { array_push($pro, $single_arr); }
                            else if($row == 3 || $row == 6 || $row == 9)
                            { array_push($cs, $single_arr); }
                        }
                    }  
                 
                    array_push($allRomData, $os); 
                    array_push($allRomData, $pro); 
                    array_push($allRomData, $cs); 
                    $RomFinalData =array();
                    foreach($allRomData as $romData => $Datavalue) 
                    {
                        $single_metal = array();
                        $oc_metals = array();
                        $oc_metal_total = array();
                        $RomData = array();
                        foreach($Datavalue as $key => $value) 
                        {
                            if(!empty($value['metal'])){
                                if(in_array($value['metal'],$single_metal))
                                {
                                    $oc_metals[$value['metal']] = $oc_metals[$value['metal']] + $value['grade'];
                                    $oc_metal_total[$value['metal']] = $oc_metal_total[$value['metal']] + $value['total'];
                                }else
                                {
                                    $single_metal[] =  $value['metal'];
                                    $oc_metals[$value['metal']] = $value['grade'];
                                    $oc_metal_total[$value['metal']] = $value['total'];
                                }
                            }
                        } 
                        foreach($single_metal as $sin) 
                        {
                            if($oc_metal_total[$sin] == 0)
                            {
                                $RomData[$sin] = 0;
                            }else
                            {
                                $RomData[$sin] = $oc_metals[$sin] / $oc_metal_total[$sin];
                            }
                        }
                        if(!empty($RomData)){
                            array_push($RomFinalData, $RomData);
                        }
                    } 
                ?>
               

                
                <!--PRODUCTION / STOCKS (ROM)-->
                <tr>
                    <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['rom_stocks_ore']['title']." (".strtoupper($partIIM1[0]).")"; ?></strong></span>

                    </td>
                </tr>
                <tr>
                    <td align="left" valign="top" >
                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;" nobr="true" class="f_s_9">
                            <thead class="thead-light text-center f_s_10">
                                <tr>
                                    <th rowspan="2"></th>
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
                                <tr>
                                    <th colspan="7"><?php echo $label['rom_stocks_ore'][7]; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $label['rom_stocks_ore'][5]; ?></td>
                                    <td>
                                        <div class="tot-qty open_dev_qty" id="f_open_dev_qty"><?php echo $romDataOre[$minLow][1]['tot_qty'][0]; ?></div>
                                    </td>
                                    <td>
                                        <table id="open_dev_table" class="f5-rom-sub-table table f_s_7" width="100%" border="0.5" cellpadding="0" cellspacing="0"  >
                                            <tbody>
                                                <?php foreach($romDataOre[$minLow][1]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                           <?php echo $val; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $romDataOre[$minLow][1]['grade'][$key]; ?>
                                                        </td>
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
                                        <table id="prod_dev_table" class="f5-rom-sub-table table f_s_7" width="100%" border="0.5" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <?php foreach($romDataOre[$minLow][2]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $romDataOre[$minLow][2]['grade'][$key]; ?>
                                                        </td>
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
                                        <table id="close_dev_table" class="f5-rom-sub-table table f_s_7" width="100%" border="0.5" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <?php foreach($romDataOre[$minLow][3]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $romDataOre[$minLow][3]['grade'][$key]; ?>
                                                        </td>
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
                                        <table id="open_stop_table" class="f5-rom-sub-table table f_s_7" width="100%" border="0.5" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <?php foreach($romDataOre[$minLow][4]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $romDataOre[$minLow][4]['grade'][$key]; ?>
                                                        </td>
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
                                        <table id="prod_stop_table" class="f5-rom-sub-table table f_s_7" width="100%" border="0.5" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <?php foreach($romDataOre[$minLow][5]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $romDataOre[$minLow][5]['grade'][$key]; ?>
                                                        </td>
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
                                        <table id="close_stop_table" class="f5-rom-sub-table table f_s_7" width="100%" border="0.5" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <?php foreach($romDataOre[$minLow][6]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $romDataOre[$minLow][6]['grade'][$key]; ?>
                                                        </td>
                                                        
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php echo $this->Form->control('close_stop_metal_count', array('type'=>'hidden', 'id'=>'close_stop_metal_count', 'label'=>false)); ?>
                                    </td>
                                </tr>
                            </tbody>
                            
                            <tbody>
                                <tr>
                                    <td><?php echo $label['rom_stocks_ore'][8]; ?></td>
                                    <td>
                                        <div class="open_cast_qty" id="f_open_cast_qty"><?php echo $romDataOre[$minLow][7]['tot_qty'][0]; ?></div>
                                    </td>
                                    <td>
                                        <table id="open_cast_table" class="f5-rom-sub-table table f_s_7" width="100%" border="0.5" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <?php foreach($romDataOre[$minLow][7]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $romDataOre[$minLow][7]['grade'][$key]; ?>
                                                        </td>
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
                                        <table id="prod_cast_table" class="f5-rom-sub-table table f_s_7" width="100%" border="0.5" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <?php foreach($romDataOre[$minLow][8]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $romDataOre[$minLow][8]['grade'][$key]; ?>
                                                        </td>
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
                                        <table id="close_cast_table" class="f5-rom-sub-table table f_s_7" width="100%" border="0.5" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <?php foreach($romDataOre[$minLow][9]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                           <?php echo $val; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $romDataOre[$minLow][9]['grade'][$key]; ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php echo $this->Form->control('close_cast_metal_count', array('type'=>'hidden', 'id'=>'close_cast_metal_count', 'label'=>false)); ?>
                                    </td>
                                </tr>
                            </tbody>
                            <thead class="thead-light f_s_10">
                                <tr>
                                    <th><?php echo $label['rom_stocks_ore'][9]; ?></th>
                                    <th>
                                        <?php echo (int)$romDataOre[$minLow][1]['tot_qty'][0] + (int)$romDataOre[$minLow][4]['tot_qty'][0] + (int)$romDataOre[$minLow][7]['tot_qty'][0]; ?>
                                    </th>
                                    <th>
                                    <table id="open_total_table" class="f5-rom-total-table f_s_7" width="100%" border="0.5" cellpadding="0" cellspacing="0">
                                    
                                        <?php foreach($RomFinalData[0] as $key=>$val){ ?>
                                            <tr>
                                                <td><?php echo $key; ?></td>
                                                <td><?php echo number_format($val,2); ?></td>
                                            </tr>
                                        <?php } ?>
                                    
                                    </table>
                                    </th>
                                    <th>
                                        <?php echo $total_oc = (int)$romDataOre[$minLow][2]['tot_qty'][0] + (int)$romDataOre[$minLow][5]['tot_qty'][0] + (int)$romDataOre[$minLow][8]['tot_qty'][0]; ?>
                                    </th>
                                    <th>
                                    <table id="prod_total_table" class="f5-rom-total-table f_s_7" width="100%" border="0.5" cellpadding="0" cellspacing="0">
                                    
                                       <?php foreach($RomFinalData[1] as $key=>$val){ ?>
                                            <tr>
                                                <td><?php echo $key; ?></td>
                                                <td><?php echo number_format($val,2); ?></td>
                                            </tr>
                                        <?php } ?>
                                        
                                    </table>
                                    </th>
                                    <th>
                                        <?php echo (int)$romDataOre[$minLow][3]['tot_qty'][0] + (int)$romDataOre[$minLow][6]['tot_qty'][0] + (int)$romDataOre[$minLow][9]['tot_qty'][0]; ?>
                                    </th>
                                    <th>
                                    <table id="close_total_table" class="f5-rom-total-table f_s_7" width="100%" border="0.5" cellpadding="0" cellspacing="0">
                                    
                                       <?php foreach($RomFinalData[2] as $key=>$val){ ?>
                                            <tr>
                                                <td><?php echo $key; ?></td>
                                                <td><?php echo number_format($val,2); ?></td>
                                            </tr>
                                        <?php } ?>

                                    </table>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </td>
                </tr>
                
                <!-- EX-MINE PRICE -->
                <tr><td></td></tr>
                <tr>
                    <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['ex_mine']['title']." (".strtoupper($partIIM1[0]).")"; ?></strong></span></td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
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
                    <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['con_reco']['title']." (".strtoupper($partIIM1[0]).")"; ?></strong></span></td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;" nobr="true" class="f_s_9">
                           <thead class="thead-light text-center f_s_10">
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
                                        <table id="open_ore_table" class="f5-rom-sub-table table table-borderless f_s_7" width="100%" border="0.5" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <?php foreach($recovCon[$minLow]['rom'][10]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $recovCon[$minLow]['rom'][10]['grade'][$key]; ?>
                                                        </td>
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
                                        <table id="rec_ore_table" class="f5-rom-sub-table table table-borderless f_s_7" width="100%" border="0.5" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <?php foreach($recovCon[$minLow]['rom'][11]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $recovCon[$minLow]['rom'][11]['grade'][$key]; ?>
                                                        </td>
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
                                        <table id="treat_ore_table" class="f5-rom-sub-table table table-borderless f_s_7" width="100%" border="0.5" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <?php foreach($recovCon[$minLow]['rom'][12]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $recovCon[$minLow]['rom'][12]['grade'][$key]; ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;" nobr="true" class="f_s_9">
                            <thead class="thead-light text-center f_s_10">
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
                                        <table id="con_obt_table" class="f5-rom-sub-table table table-borderless f_s_7" width="100%" border="0.5" cellpadding="0" cellspacing="0">
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
                                        <table id="con_obt_grade_table" class="f5-rom-sub-table table table-borderless f_s_7" width="100%" border="0.5" cellpadding="0" cellspacing="0">
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
                                        <table id="con_obt_metal_value_table" class="f5-rom-sub-table table table-borderless f_s_7" width="100%" border="0.5" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <?php foreach($recovCon[$minLow]['con'][13]['con_value'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val; ?>
                                                        </td>
                                                        
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
                                        <table id="tail_ore_table" class="f5-rom-sub-table table table-borderless f_s_7" width="100%" border="0.5" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <?php foreach($recovCon[$minLow]['rom'][14]['metal'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $recovCon[$minLow]['rom'][14]['grade'][$key]; ?>
                                                        </td>
                                                        
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>

                                    <!-- SECTION 6 : CLOSING STOCKS OF CONCENTRATES THE CONCENTRATOR/PLANT  -->
                                    <td>
                                        <table id="close_con_table" class="f5-rom-sub-table table table-borderless f_s_7" width="100%" border="0.5" cellpadding="0" cellspacing="0">
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
                                        <table id="close_con_grade_table" class="f5-rom-sub-table table table-borderless f_s_7" width="100%" border="0.5" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <?php foreach($recovCon[$minLow]['con'][15]['grade'] as $key=>$val){ $keyN = $key+1; ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $val; ?>
                                                        </td>
                                                       
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="foot_note">* <?php echo $label['con_reco'][11]; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                

                <!-- RECOVERIES AT THE SMELTER -->
                <tr><td></td></tr>
                <tr>
                    <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['smelt_reco']['title']." (".strtoupper($partIIM1[0]).")"; ?></strong></span></td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                           <thead class="thead-light text-center f_s_10">
                                <tr>
                                    <th colspan="2"><?php echo $label['smelt_reco'][0]; ?></th>
                                    <th colspan="2"><?php echo $label['smelt_reco'][1]; ?></th>
                                    <th colspan="3"><?php echo $label['smelt_reco'][2]; ?></th>
                                    <th colspan="2"><?php echo $label['smelt_reco'][3]; ?></th>
                                    <th colspan="2"><?php echo $label['smelt_reco'][4]; ?></th>
                                    <th colspan="3"><?php echo $label['smelt_reco'][5]; ?></th>
                                </tr>
                                <tr>
                                    <th colspan="2"><?php echo $label['smelt_reco'][6]; ?></th>
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
                                    <th><?php echo $label['smelt_reco'][7]; ?></th>
                                </tr>
                            </thead>
                            <tbody class="recovery-table-body">
                                <?php foreach($smeltReco[$minLow]['recovery'] as $key=>$val){ $keyN = $key+1; ?>
                                    <tr class="recovery-table-rw">
                                        <td> <?php echo $val['open_metal']; ?></td>
                                        <td> <?php echo $val['open_qty']; ?></td>
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
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;" nobr="true" class="f_s_9">
                            <thead class="thead-light text-center f_s_10">
                                <tr>
                                    <th colspan="4"><?php echo $label['smelt_reco'][9]; ?></th>
                                    <th colspan="4"><?php echo $label['smelt_reco'][10]; ?></th>
                                </tr>
                                <tr>
                                    <th colspan="2"><?php echo $label['smelt_reco'][11]; ?></th>
                                    <th><?php echo $label['smelt_reco'][12]; ?></th>
                                    <th><?php echo $label['smelt_reco'][13]; ?></th>
                                    <th colspan="2"><?php echo $label['smelt_reco'][11]; ?></th>
                                    <th><?php echo $label['smelt_reco'][12]; ?></th>
                                    <th><?php echo $label['smelt_reco'][13]; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php  for($i=0; $i < count($smeltReco[$minLow]['con_metal']); $i++) { ?>
                                    <tr>
                                        <!--METAL RECOVERED TABLE-->
                                        <td><?= $smeltReco[$minLow]['con_metal'][$i]['rc_metal']; ?></td>
                                        <td><?= $smeltReco[$minLow]['con_metal'][$i]['rc_qty']; ?></td>
                                        <td><?= $smeltReco[$minLow]['con_metal'][$i]['rc_grade']; ?></td>
                                        <td><?= $smeltReco[$minLow]['con_metal'][$i]['rc_value']; ?></td>
                                        <!--BY PRODUCT TABLE-->
                                        <td><?= $smeltReco[$minLow]['by_product'][$i]['bp_metal']; ?></td>
                                        <td><?= $smeltReco[$minLow]['by_product'][$i]['bp_qty']; ?></td>
                                        <td><?= $smeltReco[$minLow]['by_product'][$i]['bp_grade']; ?></td>
                                        <td><?= $smeltReco[$minLow]['by_product'][$i]['bp_value']; ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="8" class="foot_note"><?php echo $label['smelt_reco']['note']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                
            
                <!-- SALES (METALS/BY PRODUCT) -->
                <tr><td></td></tr>
                <tr>
                    <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['sales_metal_product']['title']." (".strtoupper($partIIM1[0]).")"; ?></strong></span></td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                    
                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;" nobr="true"  class="f_s_9">
                            <thead class="thead-light text-center f_s_10">
                                <tr>
                                    <th colspan="3"><?php echo $label['sales_metal_product'][0]; ?></th>
                                    <th rowspan="2"><?php echo $label['sales_metal_product'][1]; ?></th>
                                    <th colspan="3"><?php echo $label['sales_metal_product'][2]; ?></th>
                                    <th colspan="2"><?php echo $label['sales_metal_product'][3]; ?></th>
                                </tr>
                                <tr>
                                    <th><?php echo $label['sales_metal_product'][4]; ?></th>
                                    <th><?php echo $label['sales_metal_product'][5]; ?></th>
                                    <th><?php echo $label['sales_metal_product'][6]; ?></th>
                                    <th><?php echo $label['sales_metal_product'][5]; ?></th>
                                    <th><?php echo $label['sales_metal_product'][6]; ?></th>
                                    <th><?php echo $label['sales_metal_product'][7]; ?></th>
                                    <th><?php echo $label['sales_metal_product'][5]; ?></th>
                                    <th><?php echo $label['sales_metal_product'][6]; ?></th>
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
                                    </tr>

                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                        
                        <table width="100%" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse" class="foot_note">
                            <tbody>
                                <tr>
                                    <td rowspan="2" width="6%"><?php echo $label['sales_metal_product']['note_txt']; ?></td>
                                    <td><?php echo $label['sales_metal_product']['note_1']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $label['sales_metal_product']['note_2']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

                
                <!--DEDUCTION DETAILS-->
                <tr><td></td></tr>
                <tr>
                    <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['deduct_detail']['title']." (".strtoupper($partIIM1[0]).")"; ?></strong></span></td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;" nobr="true" class="f_s_9">
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
                                            <td width="68%"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="foot_note"><?php echo $label['deduct_detail']['note']; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
            
                <!--SALES/DISPATCHES-->
                <tr><td></td></tr>
                <tr>
                    <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['sale_despatch']['title']." (".strtoupper($partIIM1[0]).")"; ?></strong></span></td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;" nobr="true" class="f_s_9">
                            <thead class="f_s_10">
                            <tr>
                                <td height="28" align="center" valign="top" class="form-table-title"></td>
                                <td align="center" class="form-table-title"></td>
                                <td id="Domestic_1" colspan="4" align="center" class="form-table-title"><?php echo $label['sale_despatch'][0]; ?></td>
                                <td id="Export_1" colspan="3" align="center" class="form-table-title"><?php echo $label['sale_despatch'][1]; ?></td>
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
                            </thead>
                            <?php for ($count = 0; $count < count($saleDespatch[$minLow]); $count++) { ?>
                                <tr>
                                    <td align="center" valign="middle" class="lable-text"><?php 
                                    if(isset($saleDespatchGrade[$minLow][$saleDespatch[$minLow][$count]['grade_code']])){
                                        echo ucfirst($saleDespatchGrade[$minLow][$saleDespatch[$minLow][$count]['grade_code']]);
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
                            <tr>
                                <td colspan="9">
                                    <?php echo $label['sale_despatch']['note1']; ?><br>
                                    <?php //if($formNo == '5'){ echo $label['sale_despatch']['note']; } ?>
                                    <?php  echo $label['sale_despatch']['note']; ?>
                                </td>
                            </tr>
                        </table> 
                    </td>
                </tr>
                <tr><td></td></tr>
                <tr>
                    <td align="left" class="welcome-signout sec_tit" style="font-size:10px"><span><?php echo $label['sale_despatch'][11]; ?></span></td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;" nobr="true"  class="f_s_9">
                            <tr><!--   Remove the S form reason word. added by ganesh satav dated: 13 feb 14-->
                                <td align="left" valign="top" class="form-table-title"><?php echo $label['sale_despatch'][13]; ?></td>
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
                <tr><td></td></tr>
                <tr>
                    <td align="left" class="welcome-signout" style="font-size:10px"><span><?php echo $label['sale_despatch'][12]; ?></span></td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;" nobr="true"  class="f_s_9">
                            <tr><!--   Remove the S form reason word. added by ganesh satav dated: 13 feb 14-->
                                <td align="left" valign="top" class="form-table-title"><?php echo $label['sale_despatch'][14]; ?></td>
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
            
            
                <!--PRODUCTION / STOCKS (ROM)-->
                <tr><td></td></tr>
                <tr>
                    <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['rom_stocks_three']['title']." (".strtoupper($partIIM1[0]).")"; ?></strong></span></td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;" class="f_s_9">
                            <thead class="thead-light text-center f_s_10">
                                <tr>
                                    <th><?php echo $label['rom_stocks_three'][0]; ?></th>
                                    <th><?php echo $label['rom_stocks_three'][10]; ?></th>
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
                <tr><td></td></tr>
                <tr>
                    <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['prod_stock_dis']['title']." (".strtoupper($partIIM1[0]).")"; ?></strong></span></td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;" nobr="true" class="f_s_9">
                            <thead class="thead-light text-center f_s_10">
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
                <tr><td></td></tr>
                <tr>
                    <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['deduct_detail']['title']." (".strtoupper($partIIM1[0]).")"; ?></strong></span></td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;" nobr="true"  class="f_s_9">
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
                                            <td width="68%"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"><?php echo $label['deduct_detail']['note']; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
                <!--SALES/DISPATCHES-->
                <tr><td></td></tr>
                <tr>
                    <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['sale_despatch']['title']." (".strtoupper($partIIM1[0]).")"; ?></strong></span></td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;" nobr="true" class="f_s_9">
                            <tr>
                                <td height="28" align="center" valign="top" class="form-table-title"></td>
                                <td align="center" class="form-table-title"></td>
                                <td id="Domestic_1" colspan="4" align="center" class="form-table-title"><?php echo $label['sale_despatch'][0]; ?></td>
                                <td id="Export_1"colspan="3" align="center" class="form-table-title"><?php echo $label['sale_despatch'][1]; ?></td>
                            </tr>
                            <tr>
                                <td align="center" valign="middle" class="form-table-title"><?php echo $label['sale_despatch'][2]; ?>(*)</td>
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
                            <tr>
                                <td colspan="9">
                                    <?php echo $label['sale_despatch']['note1']; ?><br>
                                    <?php echo $label['sale_despatch']['note3']; ?><br>
                                    <?php //if($formNo == '5'){ echo $label['sale_despatch']['note']; } ?>
                                    <?php  echo $label['sale_despatch']['note'];  ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td></td></tr>
                <tr>
                    <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['sale_despatch'][11]; ?></strong></span></td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                            <tr><!--   Remove the S form reason word. added by ganesh satav dated: 13 feb 14-->
                                <td align="left" valign="top" class="form-table-title"><?php echo $label['sale_despatch'][13]; ?></td>
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
                <tr><td></td></tr>
                <tr>
                    <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['sale_despatch'][12]; ?></strong></span></td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                            <tr><!--   Remove the S form reason word. added by ganesh satav dated: 13 feb 14-->
                                <td align="left" valign="top" class="form-table-title"><?php echo $label['sale_despatch'][14]; ?></td>
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
            
                <?php if (strtolower($partIIM1[0]) == strtolower('Iron Ore')) { ?>
                    <!-- PRINT TYPE OF ORE -->
                    <div class="page-break" style="margin-left: 40px;width:90%">

                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-left:0px" align="center" nobr="true" class="f_s_9">
                            <tr>
                                <td align="left" class="welcome-page-name">
                                    <div id="ore_type" style="border:0px solid #E5D0BD; margin-left:20px;width:100%">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr><td></td></tr>
                                            <tr><td align="left" class="welcome-signout sec_tit"><strong><?php echo $label['ore_type']['title']; ?></strong></td></tr>
                                            <tr><td></td></tr>
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
                $prodData = (strtolower($partIIM1[0]) == strtolower('Iron Ore')) ? (($is_hematite == true) ? $prodArr[$minLow]['hematite'] : $prodArr[$minLow]['magnetite']) : $prodArr[$minLow];
                $subMin = (strtolower($partIIM1[0]) == strtolower('Iron Ore')) ? (($is_hematite == true) ? ' (Hematite)' : (($is_magnetite == true) ? ' (Magnetite)' : '')) : '';
                ?>
                <tr>
                    <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['rom_stocks']['title']." (".strtoupper($partIIM1[0]).$subMin.")"; ?></strong></span></td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" border="0.5" cellpadding="2" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse" class="f_s_9">
                            <tr class="f_s_10">
                                <td width="40%" align="center" align="top" class="form-table-title"><?php echo $label['rom_stocks'][0]; ?></td>
                                <td width="20%" align="center" class="form-table-title"><?php echo $label['rom_stocks'][1]; ?></td>
                                <td width="20%" align="center" class="form-table-title"><?php echo $label['rom_stocks'][2]; ?></td>
                                <td width="20%" align="center" class="form-table-title"><?php echo $label['rom_stocks'][3]; ?></td>
                            </tr>
                            <tr>
                                <td align="left" valign="top" class="lable-text"><?php echo $label['rom_stocks'][4]; ?></td>
                                <td align="center"><?php echo (isset($prodData['open_oc_rom'])) ? $prodData['open_oc_rom'] : ''; ?></td>
                                <td align="center"><?php echo (isset($prodData['prod_oc_rom'])) ? $prodData['prod_oc_rom'] : ''; ?></td>
                                <td align="center"><?php echo (isset($prodData['clos_oc_rom'])) ? $prodData['clos_oc_rom'] : ''; ?></td>
                            </tr> 
                            <tr>
                                <td align="left" valign="top" class="lable-text"><?php echo $label['rom_stocks'][5]; ?></td>
                                <td align="center"><?php echo (isset($prodData['open_ug_rom'])) ? $prodData['open_ug_rom'] : ''; ?></td>
                                <td align="center"><?php echo (isset($prodData['prod_ug_rom'])) ? $prodData['prod_ug_rom'] : ''; ?></td>
                                <td align="center"><?php echo (isset($prodData['clos_ug_rom'])) ? $prodData['clos_ug_rom'] : ''; ?></td>
                            </tr>
                            <tr>
                                <td align="left" valign="top" class="lable-text"><?php echo $label['rom_stocks'][6]; ?></td>
                                <td align="center"><?php echo (isset($prodData['open_dw_rom'])) ? $prodData['open_dw_rom'] : ''; ?></td>
                                <td align="center"><?php echo (isset($prodData['prod_dw_rom'])) ? $prodData['prod_dw_rom'] : ''; ?></td>
                                <td align="center"><?php echo (isset($prodData['clos_dw_rom'])) ? $prodData['clos_dw_rom'] : ''; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
                <!-- GRADE-WISE PRODUCTION -->
                <?php 
                $minUndLow = strtolower(str_replace(' ','_',$partIIM1[0]));
                if (in_array($minUndLow, array('iron_ore','chromite'))) {
                    ?>
                    
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td align="left" class="welcome-signout sec_tit">
                            <span class="welcome-signout"><strong><?php echo $label['gradewise_prod']['title']." (".strtoupper($partIIM1[0]).$subMin.")"; ?></strong></span>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse" class="f_s_9 l_h_10" nobr="true">
                                <tr class="f_s_10">
                                    <td align="left" valign="top" class="form-table-title"><?php echo $label['gradewise_prod'][0]; ?></td>
                                    <td align="center" class="form-table-title"><?php echo $label['gradewise_prod'][1]; ?></td>
                                    <td align="center" class="form-table-title"><?php echo $label['gradewise_prod'][2]; ?></td>
                                </tr>
                                <?php 
                                $i = 1;
                                $feMinCount = 1;
                                $gradeWiseProdMinKey = ($minLow == 'iron ore') ? ( ($gradeIronOre != 0) ? key($gradeWiseProdRom[$minLow]) + 1 : key($gradeWiseProdRom[$minLow]) ) : key($gradeWiseProdRom[$minLow]);
                                // if ($minLow == 'iron ore') { $gradeIronOre++; }
                                $gradeKy = $gradeWiseProdRom[$minLow][$gradeWiseProdMinKey]['gradeProd'];
                                $gradeVl = $gradeWiseProdRom[$minLow][$gradeWiseProdMinKey]['gradeProd']['gradeNames'];
                                foreach($gradeVl as $gradeKk => $mainGrade){

                                    $lilist = array('a'=>'à¤•','b'=>'à¤–','c'=>'à¤—','d'=>'à¤˜','e'=>'à¥œ','f'=>'à¤š','g'=>'à¤›','h'=>'à¤œ','i'=>'à¤');
                                    $feMinSubCount = 'a';
                                    foreach ($mainGrade as $mainGradeKey => $mainGradeVal) {
                                        $tmpGradeFormName = "gradeForm" . $i;
                                        $gradeValues = $gradeWiseProdRom[$minLow][$gradeWiseProdMinKey]['gradeProd']['gradeValues'];

                                        ?>
                                        <tr>
                                            <td>
                                                <?php 
                                                echo "(" . $feMinSubCount++ . ") " . $mainGradeVal;
                                                ?>
                                            </td>
                                            <td>
                                                <?php echo $gradeValues[$mainGradeKey]['despatches']; ?>
                                            </td>
                                            <td>
                                                <?php echo $gradeValues[$mainGradeKey]['pmv']; ?>
                                            </td>
                                        </tr>
                                    <?php  $i++; 	} 	?>
                                <?php } $tmpGradeFormName = "gradeForm" . $i;  ?>
                                <tr>
                                    <td colspan="3"><?php echo $label['gradewise_prod']['note']; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td></td>
                </tr>
                <br pagebreak="true" />
                <tr>
                    <td align="left" class="welcome-signout sec_tit">
                        <span class="welcome-signout"><strong><?php echo $label['gradewise_prod']['title_two']." (".strtoupper($partIIM1[0]).$subMin.")"; ?></strong></span>
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse" class="f_s_9 l_h_10" nobr="true">
                            <tr class="f_s_10">
                                <td align="left" valign="top" class="form-table-title" width="<?php echo $grade_col_1; ?>"><?php echo $label['gradewise_prod'][3]; ?></td>
                                <?php if ($formNo == 3) { ?>
                                    <td align="center" class="form-table-title" width="<?php echo $grade_col_2; ?>"><?php echo $label['gradewise_prod'][9]; ?></td>
                                <?php } ?>
                                <td align="center" class="form-table-title" width="<?php echo $grade_col_3; ?>"><?php echo $label['gradewise_prod'][4]; ?></td>
                                <td align="center" class="form-table-title" width="<?php echo $grade_col_4; ?>"><?php echo $label['gradewise_prod'][5]; ?></td>
                                <td align="center" class="form-table-title" width="<?php echo $grade_col_5; ?>"><?php echo $label['gradewise_prod'][6]; ?></td>
                                <td align="center" class="form-table-title" width="<?php echo $grade_col_6; ?>"><?php echo $label['gradewise_prod'][7]; ?></td>
                                <td align="center" class="form-table-title" width="<?php echo $grade_col_7; ?>"><?php echo $label['gradewise_prod'][8]; ?></td>
                            </tr>
                            <?php 

                            $i = 1;
                            $feMinCount = 1;
                            $gradeWiseProdMinKey = ($minLow == 'iron ore') ? ( ($gradeIronOre != 0) ? key($gradeWiseProd[$minLow]) + 1 : key($gradeWiseProd[$minLow]) ) : key($gradeWiseProd[$minLow]);
                            if ($minLow == 'iron ore') { $gradeIronOre++; }
                            $gradeKy = $gradeWiseProd[$minLow][$gradeWiseProdMinKey]['gradeProd'];
                            $gradeVl = $gradeWiseProd[$minLow][$gradeWiseProdMinKey]['gradeProd']['gradeNames'];
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
                                    $lilist = array('a'=>'à¤•','b'=>'à¤–','c'=>'à¤—','d'=>'à¤˜','e'=>'à¥œ','f'=>'à¤š','g'=>'à¤›','h'=>'à¤œ','i'=>'à¤');
                                    $feMinSubCount = 'a';
                                    foreach ($mainGrade as $mainGradeKey => $mainGradeVal) {
                                        $tmpGradeFormName = "gradeForm" . $i;
                                        $gradeValues = $gradeWiseProd[$minLow][$gradeWiseProdMinKey]['gradeProd']['gradeValues'];

                                        ?>
                                        <tr>
                                            <td>
                                                <?php 

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
                        </table>
                    </td>
                </tr>

                
                <?php if ($partIIM1['formNo'] == 8) { ?>
                    <!--PULVERISATION-->
                    <tr><td></td></tr>
                    <tr>
                        <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['pulverisation']['title']." (".strtoupper($partIIM1[0]).")"; ?></strong></span></td>
                    </tr>
                    <tr>
                        <td class="f_s_9">
                            <span><?php echo $label['pulverisation'][0]; ?></span>
                            <span><?php echo $isPulver =($pulverArr[$minLow][0]['is_pulverised'] == 1) ? $label['pulverisation'][1] : $label['pulverisation'][2]; ?></span>
                        </td>
                    </tr>
                    <?php if($isPulver == $label['pulverisation'][1]){ ?>
                        <tr>
                            <td align="left" class="f_s_9"><span><?php echo $label['pulverisation'][3]." (".strtoupper($partIIM1[0]).")"; ?></span></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top">
                                <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                    <tr>
                                        <td align="center" class="f_s_10" rowspan="2"><?php echo $label['pulverisation'][4]; ?></td>
                                        <td align="center" class="f_s_10" rowspan="2"><?php echo $label['pulverisation'][5]; ?></td>
                                        <td align="center" class="f_s_10" colspan="2"><?php echo $label['pulverisation'][6]; ?></td>
                                        <td align="center" class="f_s_10" colspan="3"><?php echo $label['pulverisation'][7]; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="center" class="f_s_10"><?php echo $label['pulverisation'][8]; ?></td>
                                        <td align="center" class="f_s_10"><?php echo $label['pulverisation'][9]; ?></td>
                                        <td align="center" class="f_s_10"><?php echo $label['pulverisation'][10]; ?></td>
                                        <td align="center" class="f_s_10"><?php echo $label['pulverisation'][11]; ?></td>
                                        <td align="center" class="f_s_10"><?php echo $label['pulverisation'][12]; ?></td>
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
                            <td align="left" class="f_s_10"><span><?php echo $label['pulverisation'][15] . ": ₹ " . $pulverArr[$minLow][0]['avg_cost'] . " " . $label['pulverisation'][17]; ?></span></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                
            
                <!--DEDUCTION DETAILS-->
                <tr><td></td></tr>
                <tr>
                    <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['deduct_detail']['title']." (".strtoupper($partIIM1[0]).$subMin.")"; ?></strong></span></td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                            <tr>
                                <td width="55%" align="center" class="f_s_10"><?php echo $label['deduct_detail'][0]; ?></td>
                                <td width="19%" align="center" class="f_s_10"><?php echo $label['deduct_detail'][1]; ?></td>
                                <td width="26%" align="center" class="f_s_10"><?php echo $label['deduct_detail'][2]; ?></td>
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
                                            <td width="68%"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"><?php echo $label['deduct_detail']['note']; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
                <!--SALES/DISPATCHES-->
                <tr><td></td></tr>
                <tr>
                    <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['sale_despatch']['title']." (".strtoupper($partIIM1[0]).$subMin.")"; ?></strong></span></td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                            <tr>
                                <td height="28" align="center" valign="top" class="f_s_10"></td>
                                <td align="center" class="f_s_10"></td>
                                <td id="Domestic_1" colspan="4" align="center" class="f_s_10"><?php echo $label['sale_despatch'][0]; ?></td>
                                <td id="Export_1"colspan="3" align="center" class="f_s_10"><?php echo $label['sale_despatch'][1]; ?></td>
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
                            <tr>
                                <td colspan="9">
                                    <?php echo $label['sale_despatch']['note1']; ?><br>
                                    <?php //if($formNo == '5'){ echo $label['sale_despatch']['note']; } ?>
                                    <?php  echo $label['sale_despatch']['note']; ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td></td></tr>
                <tr>
                    <td align="left" class="welcome-signout sec_tit"><strong><span><?php echo $label['sale_despatch'][11]; ?></strong></span></td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true"  class="f_s_9">
                            <tr><!--   Remove the S form reason word. added by ganesh satav dated: 13 feb 14-->
                                <td align="left" valign="top" class="form-table-title"><?php echo $label['sale_despatch'][13]; ?></td>
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
                <tr><td></td></tr>
                <tr>
                    <td align="left" class="welcome-signout sec_tit"><strong><span><?php echo $label['sale_despatch'][12]; ?></strong></span></td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                            <tr><!--   Remove the S form reason word. added by ganesh satav dated: 13 feb 14-->
                                <td align="left" valign="top" class="form-table-title"><?php echo $label['sale_despatch'][14]; ?></td>
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

                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-left:0px;margin-top:20px" align="center" nobr="true">
                        <tr><td height="5"></td></tr>
                        <tr><td></td></tr>
                        <tr>
                            <td align="left" class="welcome-page-name">
                                <div id="ore_type" style="border:0px solid #E5D0BD; margin-left:20px;width:100%">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr><td></td></tr>
                                        <tr><td align="left" class="welcome-signout sec_tit"><strong><?php echo $label['ore_type']['title']; ?></strong></td></tr>
                                        <tr><td></td></tr>
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
                    <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['rom_stocks']['title']." (".strtoupper($partIIM1[0]).$subMin.")"; ?></strong></span></td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                            <tr>
                                <td width="40%" align="center" valign="top" class="form-table-title"><?php echo $label['rom_stocks'][0]; ?></td>
                                <td width="20%" align="center" class="form-table-title"><?php echo $label['rom_stocks'][1]; ?></td>
                                <td width="20%" align="center" class="form-table-title"><?php echo $label['rom_stocks'][2]; ?></td>
                                <td width="20%" align="center" class="form-table-title"><?php echo $label['rom_stocks'][3]; ?></td>
                            </tr>
                            <tr>
                                <td align="left" valign="top" class="lable-text"><?php echo $label['rom_stocks'][4]; ?></td>
                                <td align="center"><?php echo $prodArr[$minLow]['magnetite']['open_oc_rom']; ?></td>
                                <td align="center"><?php echo $prodArr[$minLow]['magnetite']['prod_oc_rom']; ?></td>
                                <td align="center"><?php echo $prodArr[$minLow]['magnetite']['clos_oc_rom']; ?></td>
                            </tr> 
                            <tr>
                                <td align="left" valign="top" class="lable-text"><?php echo $label['rom_stocks'][5]; ?></td>
                                <td align="center"><?php echo $prodArr[$minLow]['magnetite']['open_ug_rom']; ?></td>
                                <td align="center"><?php echo $prodArr[$minLow]['magnetite']['prod_ug_rom']; ?></td>
                                <td align="center"><?php echo $prodArr[$minLow]['magnetite']['clos_ug_rom']; ?></td>
                            </tr>
                            <tr>
                                <td align="left" valign="top" class="lable-text"><?php echo $label['rom_stocks'][6]; ?></td>
                                <td align="center"><?php echo $prodArr[$minLow]['magnetite']['open_dw_rom']; ?></td>
                                <td align="center"><?php echo $prodArr[$minLow]['magnetite']['prod_dw_rom']; ?></td>
                                <td align="center"><?php echo $prodArr[$minLow]['magnetite']['clos_dw_rom']; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
                <!-- GRADE-WISE PRODUCTION //ON HOLD SECTION -->
                <?php 
                $minUndLow = strtolower(str_replace(' ','_',$partIIM1[0]));
                if (in_array($minUndLow, array('iron_ore','chromite'))) {
                    ?>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td align="left" class="welcome-signout sec_tit">
                            <span class="welcome-signout"><strong> <?php echo $label['gradewise_prod']['title']." (".strtoupper($partIIM1[0]).$subMin.")"; ?></strong></span>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                <tr>
                                    <?php /* Below .added code add for solve the no and label issues added on 28 april 2014 added by ganesh satav */ ?>
                                    <td width="40%" align="left" valign="top" class="form-table-title"><?php echo $label['gradewise_prod'][0]; ?></td>  
                                    <td width="30%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][1]; ?></td>
                                    <td width="30%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][2]; ?></td>
                                </tr>
                                <?php

                                $i = 1;
                                $feMinCount = 1;
                                $gradeWiseProdMinKey = ($minLow == 'iron ore') ? ( ($gradeIronOre != 0) ? key($gradeWiseProdRom[$minLow]) + 1 : key($gradeWiseProdRom[$minLow]) ) : key($gradeWiseProdRom[$minLow]);
                                if ($minLow == 'iron ore') { $gradeIronOre++; }
                                $gradeKy = $gradeWiseProdRom[$minLow][$gradeWiseProdMinKey]['gradeProd'];
                                $gradeVl = $gradeWiseProdRom[$minLow][$gradeWiseProdMinKey]['gradeProd']['gradeNames'];
                                foreach($gradeVl as $gradeKk => $mainGrade){

                                    $lilist = array('a'=>'क','b'=>'ख','c'=>'ग','d'=>'घ','e'=>'ड़','f'=>'च','g'=>'छ','h'=>'ज','i'=>'झ');
                                    $feMinSubCount = 'a';
                                    foreach ($mainGrade as $mainGradeKey => $mainGradeVal) {
                                        $tmpGradeFormName = "gradeForm" . $i;
                                        $gradeValues = $gradeWiseProdRom[$minLow][$gradeWiseProdMinKey]['gradeProd']['gradeValues'];

                                        ?>
                                        <tr>
                                            <td>
                                                <?php 

                                                echo "(" . $feMinSubCount++ . ") " . $mainGradeVal;

                                                ?>
                                            </td>
                                            <td><?php echo $gradeValues[$mainGradeKey]['despatches']; ?></td>
                                            <td><?php echo $gradeValues[$mainGradeKey]['pmv']; ?></td>
                                        </tr>
                                    <?php $i++; } ?>
                                <?php } $tmpGradeFormName = "gradeForm" . $i;  ?>
                                <tr>
                                    <td colspan="3"><?php echo $label['gradewise_prod']['note']; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td align="left" class="welcome-signout sec_tit">
                        <span class="welcome-signout"><strong> <?php echo $label['gradewise_prod']['title_two']." (".strtoupper($partIIM1[0]).$subMin.")"; ?></strong></span>
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                            <tr>
                                <td align="left" valign="top" class="form-table-title"><?php echo $label['gradewise_prod'][3]; ?></td>
                                <?php if ($formNo == 3) { ?>
                                    <td align="center" class="form-table-title"><?php echo $label['gradewise_prod'][9]; ?></td>
                                <?php } ?>
                                <td align="center" class="form-table-title"><?php echo $label['gradewise_prod'][4]; ?></td>
                                <td align="center" class="form-table-title"><?php echo $label['gradewise_prod'][5]; ?></td>
                                <td align="center" class="form-table-title"><?php echo $label['gradewise_prod'][6]; ?></td>
                                <td align="center" class="form-table-title"><?php echo $label['gradewise_prod'][7]; ?></td>
                                <td align="center" class="form-table-title"><?php echo $label['gradewise_prod'][8]; ?></td>
                            </tr>
                            <?php 

                            $i = 1;
                            $feMinCount = 1;
                            $gradeWiseProdMinKey = ($minLow == 'iron ore') ? ( ($gradeIronOre != 0) ? key($gradeWiseProd[$minLow]) + 1 : key($gradeWiseProd[$minLow]) ) : key($gradeWiseProd[$minLow]);
                            if ($minLow == 'iron ore') { $gradeIronOre++; }
                            $gradeKy = $gradeWiseProd[$minLow][$gradeWiseProdMinKey]['gradeProd'];
                            $gradeVl = $gradeWiseProd[$minLow][$gradeWiseProdMinKey]['gradeProd']['gradeNames'];
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
                                    $lilist = array('a'=>'à¤•','b'=>'à¤–','c'=>'à¤—','d'=>'à¤˜','e'=>'à¥œ','f'=>'à¤š','g'=>'à¤›','h'=>'à¤œ','i'=>'à¤');
                                    $feMinSubCount = 'a';
                                    foreach ($mainGrade as $mainGradeKey => $mainGradeVal) {
                                        $tmpGradeFormName = "gradeForm" . $i;
                                        $gradeValues = $gradeWiseProd[$minLow][$gradeWiseProdMinKey]['gradeProd']['gradeValues'];

                                        ?>
                                        <tr>
                                            <td>
                                                <?php 

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
                $sub_min = '';
                if(strtolower($partIIM[0]) == strtolower('Iron Ore')) {
                    if($is_hematite) {
                        $title.= ' (HEMATITE)';
                        $mineral.= ' (HEMATITE)';
                        $ironSubMin = "/hematite";
                        $sub_min = 'hematite';
                    } elseif($is_magnetite) {
                        $title.= ' (MAGNETITE)';
                        $mineral.= ' (MAGNETITE)';
                        $ironSubMin = "/magnetite";
                        $sub_min = 'magnetite';
                    }
                }

                ?>
                <br pagebreak="true" />
                <?php if($partIIM['formNo'] == 5) { ?>
                
                    <!-- Production / Stocks (ROM)<br>
                    
                    Ex-mine price<br>
                    
                    Recoveries at Concentrator<br>
                    
                    Recovery at the Smelter<br>
                    
                    Sales(Metals/By product)<br>
                    
                    Details of Deductions<br>
                    
                    Sales/Dispatches<br> -->
                        
                <?php } elseif($partIIM['formNo'] == 7) { ?>
                
                    <!--PRODUCTION / STOCKS (ROM)-->
                    <tr><td></td></tr>
                    <tr>
                        <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['rom_stocks_three']['title']." (".strtoupper($partIIM[0]).")"; ?></strong></span></td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                <thead class="thead-light text-center f_s_10">
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
                    <tr><td></td></tr>
                    <tr>
                        <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['prod_stock_dis']['title']." (".strtoupper($partIIM[0]).")"; ?></strong></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="f_s_9">(To be submitted separately for each mineral)</td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                <thead class="thead-light text-center f_s_10">
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
                    <tr><td></td></tr>
                    <tr>
                        <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['deduct_detail']['title']." (".strtoupper($partIIM[0]).")"; ?></strong></span></td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
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
                                                <td width="68%"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><?php echo $label['deduct_detail']['note']; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!--SALES/DISPATCHES-->
                    <tr><td></td></tr>
                    <tr>
                        <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['sale_despatch']['title']." (".strtoupper($partIIM[0]).")"; ?></strong></span></td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                <tr>
                                    <td height="28" align="center" valign="top" class="form-table-title"></td>
                                    <td align="center" class="form-table-title"></td>
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
                                <tr>
                                    <td colspan="9">
                                        <?php echo $label['sale_despatch']['note1']; ?><br>
                                        <?php //if($formNo == '5'){ echo $label['sale_despatch']['note']; } ?>
                                        <?php  echo $label['sale_despatch']['note'];  ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr><td></td></tr>
                    <tr>
                        <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['sale_despatch'][11]; ?></strong></span></td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                <tr><!--   Remove the S form reason word. added by ganesh satav dated: 13 feb 14-->
                                    <td align="left" valign="top" class="form-table-title"><?php echo $label['sale_despatch'][13]; ?></td>
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
                    <tr><td></td></tr>
                    <tr>
                        <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['sale_despatch'][12]; ?></strong></span></td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                <tr><!--   Remove the S form reason word. added by ganesh satav dated: 13 feb 14-->
                                    <td align="left" valign="top" class="form-table-title"><?php echo $label['sale_despatch'][14]; ?></td>
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
                            <!-- Type of ore -->
                    <?php } ?>
                    
                    <?php 
                    $subMin = (strtolower($partIIM[0]) == strtolower('Iron Ore')) ? (($is_hematite == true) ? ' (Hematite)' : (($is_magnetite == true) ? ' (Magnetite)' : '')) : '';
                    ?>
                    <!--Production / Stocks (ROM)-->
                    <tr><td></td></tr>
                    <tr>
                        <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['rom_stocks']['title']." (".strtoupper($partIIM[0]).$subMin.")"; ?></strong></span></td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
                            <table width="100%" border="0.5" cellpadding="2" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse" class="f_s_9" nobr="true">
                                <tr class="f_s_10">
                                    <td width="40%" align="center" valign="top" class="form-table-title"><?php echo $label['rom_stocks'][0]; ?></td>
                                    <td width="20%" align="center" class="form-table-title"><?php echo $label['rom_stocks'][1]; ?></td>
                                    <td width="20%" align="center" class="form-table-title"><?php echo $label['rom_stocks'][2]; ?></td>
                                    <td width="20%" align="center" class="form-table-title"><?php echo $label['rom_stocks'][3]; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top" class="lable-text"> <?php echo $label['rom_stocks'][4]; ?></td>
                                    <td align="center"><?php echo ($sub_min != '') ? $prodArr[$minLow][$sub_min]['open_oc_rom'] : $prodArr[$minLow]['open_oc_rom']; ?></td>
                                    <td align="center"><?php echo ($sub_min != '') ? $prodArr[$minLow][$sub_min]['prod_oc_rom'] : $prodArr[$minLow]['open_oc_rom']; ?></td>
                                    <td align="center"><?php echo ($sub_min != '') ? $prodArr[$minLow][$sub_min]['clos_oc_rom'] : $prodArr[$minLow]['open_oc_rom']; ?></td>
                                </tr> 
                                <tr>
                                    <td align="left" valign="top" class="lable-text"> <?php echo $label['rom_stocks'][5]; ?></td>
                                    <td align="center"><?php echo ($sub_min != '') ? $prodArr[$minLow][$sub_min]['open_ug_rom'] : $prodArr[$minLow]['open_oc_rom']; ?></td>
                                    <td align="center"><?php echo ($sub_min != '') ? $prodArr[$minLow][$sub_min]['prod_ug_rom'] : $prodArr[$minLow]['open_oc_rom']; ?></td>
                                    <td align="center"><?php echo ($sub_min != '') ? $prodArr[$minLow][$sub_min]['clos_ug_rom'] : $prodArr[$minLow]['open_oc_rom']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top" class="lable-text"> <?php echo $label['rom_stocks'][6]; ?></td>
                                    <td align="center"><?php echo ($sub_min != '') ? $prodArr[$minLow][$sub_min]['open_dw_rom'] : $prodArr[$minLow]['open_oc_rom']; ?></td>
                                    <td align="center"><?php echo ($sub_min != '') ? $prodArr[$minLow][$sub_min]['prod_dw_rom'] : $prodArr[$minLow]['open_oc_rom']; ?></td>
                                    <td align="center"><?php echo ($sub_min != '') ? $prodArr[$minLow][$sub_min]['clos_dw_rom'] : $prodArr[$minLow]['open_oc_rom']; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- GRADE-WISE PRODUCTION -->
                    <?php 
                    $minUndLow = strtolower(str_replace(' ','_',$partIIM[0]));
                    if (in_array($minUndLow, array('iron_ore','chromite'))) {
                        ?>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td align="left" class="welcome-signout sec_tit">
                                <span class="welcome-signout"><strong><?php echo $label['gradewise_prod']['title']." (".strtoupper($partIIM[0]).$subMin.")"; ?></strong></span>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="top">
                                <table width="100%" border="0.5" cellpadding="2" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;" class="f_s_9 l_h_10" nobr="true">
                                    <tr class="f_s_10">
                                        <td width="28%" align="left" valign="top" class="form-table-title"><?php echo $label['gradewise_prod'][0]; ?></td>
                                        <td width="15%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][1]; ?></td>
                                        <td width="13%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][2]; ?></td>
                                    </tr>
                                    <?php 

                                    $i = 1;
                                    $feMinCount = 1;
                                    $gradeWiseProdMinKey = ($minLow == 'iron ore') ? ( ($gradeIronOre != 0) ? key($gradeWiseProdRom[$minLow]) + 1 : key($gradeWiseProdRom[$minLow]) ) : key($gradeWiseProdRom[$minLow]);
                                    // if ($minLow == 'iron ore') { $gradeIronOre++; }
                                    $gradeKy = $gradeWiseProdRom[$minLow][$gradeWiseProdMinKey]['gradeProd'];
                                    $gradeVl = $gradeWiseProdRom[$minLow][$gradeWiseProdMinKey]['gradeProd']['gradeNames'];
                                    foreach($gradeVl as $gradeKk => $mainGrade){

                                        $lilist = array('a'=>'क','b'=>'ख','c'=>'ग','d'=>'घ','e'=>'ड़','f'=>'च','g'=>'छ','h'=>'ज','i'=>'झ');
                                        $feMinSubCount = 'a';
                                        foreach ($mainGrade as $mainGradeKey => $mainGradeVal) {
                                            $tmpGradeFormName = "gradeForm" . $i;
                                            $gradeValues = $gradeWiseProdRom[$minLow][$gradeWiseProdMinKey]['gradeProd']['gradeValues'];

                                            ?>
                                            <tr>
                                                <td>
                                                    <?php 

                                                    echo "(" . $feMinSubCount++ . ") " . $mainGradeVal;

                                                    ?>
                                                </td>
                                                <td>
                                                    <?php echo $gradeValues[$mainGradeKey]['despatches']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $gradeValues[$mainGradeKey]['pmv']; ?>
                                                </td>
                                            </tr>
                                        <?php  $i++; 	} 	?>
                                    <?php } $tmpGradeFormName = "gradeForm" . $i;  ?>
                                    <tr>
                                        <td colspan="3"><?php echo $label['gradewise_prod']['note']; ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <?php 
                    }
                    ?>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td align="left" class="welcome-signout sec_tit">
                            <span class="welcome-signout"><strong><?php echo $label['gradewise_prod']['title_two']." (".strtoupper($partIIM[0]).$subMin.")"; ?></strong></span>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse" class="f_s_9 l_h_10" nobr="true">
                                <tr class="f_s_10">
                                    <td align="left" valign="top" class="form-table-title" width="<?php echo $grade_col_1; ?>"><?php echo $label['gradewise_prod'][3]; ?></td>
                                    <?php if ($formNo == 3) { ?>
                                        <td align="center" class="form-table-title" width="<?php echo $grade_col_2; ?>"><?php echo $label['gradewise_prod'][9]; ?></td>
                                    <?php } ?>
                                    <td align="center" class="form-table-title" width="<?php echo $grade_col_3; ?>"><?php echo $label['gradewise_prod'][4]; ?></td>
                                    <td align="center" class="form-table-title" width="<?php echo $grade_col_4; ?>"><?php echo $label['gradewise_prod'][5]; ?></td>
                                    <td align="center" class="form-table-title" width="<?php echo $grade_col_5; ?>"><?php echo $label['gradewise_prod'][6]; ?></td>
                                    <td align="center" class="form-table-title" width="<?php echo $grade_col_6; ?>"><?php echo $label['gradewise_prod'][7]; ?></td>
                                    <td align="center" class="form-table-title" width="<?php echo $grade_col_7; ?>"><?php echo $label['gradewise_prod'][8]; ?></td>
                                </tr>
                                <?php 

                                $i = 1;
                                $feMinCount = 1;
                                $gradeWiseProdMinKey = ($minLow == 'iron ore') ? ( ($gradeIronOre != 0) ? key($gradeWiseProd[$minLow]) + 1 : key($gradeWiseProd[$minLow]) ) : key($gradeWiseProd[$minLow]);
                                if ($minLow == 'iron ore') { $gradeIronOre++; }
                                $gradeKy = $gradeWiseProd[$minLow][$gradeWiseProdMinKey]['gradeProd'];
                                $gradeVl = $gradeWiseProd[$minLow][$gradeWiseProdMinKey]['gradeProd']['gradeNames'];
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
                                    $lilist = array('a'=>'à¤•','b'=>'à¤–','c'=>'à¤—','d'=>'à¤˜','e'=>'à¥œ','f'=>'à¤š','g'=>'à¤›','h'=>'à¤œ','i'=>'à¤');
                                    $feMinSubCount = 'a';
                                    foreach ($mainGrade as $mainGradeKey => $mainGradeVal) {
                                        $tmpGradeFormName = "gradeForm" . $i;
                                        $gradeValues = $gradeWiseProd[$minLow][$gradeWiseProdMinKey]['gradeProd']['gradeValues'];

                                        ?>
                                        <tr>
                                            <td>
                                                <?php 

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
                            </table>
                        </td>
                    </tr>
                    
                    <?php if ($partIIM['formNo'] == 8) { ?>
                                        
                        <!--PULVERISATION-->
                        <tr><td></td></tr>
                        <tr>
                            <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['pulverisation']['title']." (".strtoupper($partIIM[0]).")"; ?></strong></span></td>
                        </tr>
                        <tr>
                            <td class="f_s_9">
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
                                    <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
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
                    <tr><td></td></tr>
                    <tr>
                        <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['deduct_detail']['title']." (".strtoupper($partIIM[0]).")"; ?></strong></span></td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
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
                                                <td width="68%"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><?php echo $label['deduct_detail']['note']; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                        
                    <!--SALES/DISPATCHES-->
                    <tr><td></td></tr>
                    <tr>
                        <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['sale_despatch']['title']." (".strtoupper($partIIM[0]).")"; ?></strong></span></td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true"  class="f_s_9">
                                <tr>
                                    <td height="28" align="center" valign="top" class="form-table-title"></td>
                                    <td align="center" class="form-table-title"></td>
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
                                <tr>
                                    <td colspan="9">
                                        <?php echo $label['sale_despatch']['note1']; ?><br>
                                        <?php //if($formNo == '5'){ echo $label['sale_despatch']['note']; } ?>
                                        <?php  echo $label['sale_despatch']['note'];  ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr><td></td></tr>
                    <tr>
                        <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['sale_despatch'][11]; ?></strong></span></td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                <tr><!--   Remove the S form reason word. added by ganesh satav dated: 13 feb 14-->
                                    <td align="left" valign="top" class="form-table-title"><?php echo $label['sale_despatch'][13]; ?></td>
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
                    <tr><td></td></tr>
                    <tr>
                        <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['sale_despatch'][12]; ?></strong></span></td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                <tr><!--   Remove the S form reason word. added by ganesh satav dated: 13 feb 14-->
                                    <td align="left" valign="top" class="form-table-title"><?php echo $label['sale_despatch'][14]; ?></td>
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
                    $title = "Part II For ";
                    $title.= ucwords(strtolower($partIIM[0]));
                    $mineral = $partIIM[0];
                    $title.= ' (MAGNETITE)';
                    $mineral.= ' (MAGNETITE)';
                    // echo $title;
                    ?>
                    <br pagebreak="true" />
                    <!--PRODUCTION / STOCKS (ROM)-->
                    <?php 
                    $prodData = (strtolower($partIIM[0]) == strtolower('Iron Ore')) ? $prodArr[$minLow]['magnetite'] : $prodArr[$minLow];
                    $subMin = ($is_magnetite == true) ? ' (Magnetite) ' : '';
                    ?>
                    <tr><td></td></tr>
                    <tr>
                        <td align="left" class="welcome-signout sec_tit"><span><strong><?php echo $label['rom_stocks']['title']." (".strtoupper($partIIM[0]).$subMin.")"; ?></strong></span></td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
                            <table width="100%" border="0.5" cellpadding="2" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                <tr>
                                    <td width="40%" align="center" valign="top" class="form-table-title"><?php echo $label['rom_stocks'][0]; ?></td>
                                    <td width="20%" align="center" class="form-table-title"><?php echo $label['rom_stocks'][1]; ?></td>
                                    <td width="20%" align="center" class="form-table-title"><?php echo $label['rom_stocks'][2]; ?></td>
                                    <td width="20%" align="center" class="form-table-title"><?php echo $label['rom_stocks'][3]; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top" class="lable-text"><?php echo $label['rom_stocks'][4]; ?></td>
                                    <td align="center"><?php echo $prodData['open_oc_rom']; ?></td>
                                    <td align="center"><?php echo $prodData['prod_oc_rom']; ?></td>
                                    <td align="center"><?php echo $prodData['clos_oc_rom']; ?></td>
                                </tr> 
                                <tr>
                                    <td align="left" valign="top" class="lable-text"><?php echo $label['rom_stocks'][5]; ?></td>
                                    <td align="center"><?php echo $prodData['open_ug_rom']; ?></td>
                                    <td align="center"><?php echo $prodData['prod_ug_rom']; ?></td>
                                    <td align="center"><?php echo $prodData['clos_ug_rom']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top" class="lable-text"><?php echo $label['rom_stocks'][6]; ?></td>
                                    <td align="center"><?php echo $prodData['open_dw_rom']; ?></td>
                                    <td align="center"><?php echo $prodData['prod_dw_rom']; ?></td>
                                    <td align="center"><?php echo $prodData['clos_dw_rom']; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- GRADE-WISE PRODUCTION //ON HOLD SECTION-->
                    <?php 
                    $minUndLow = strtolower(str_replace(' ','_',$partIIM[0]));
                    if (in_array($minUndLow, array('iron_ore','chromite'))) {
                        ?>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td align="left" class="welcome-signout sec_tit">
                                <span class="welcome-signout"><strong> <?php echo $label['gradewise_prod']['title']." (".strtoupper($partIIM[0]).$subMin.")"; ?></strong></span>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="top">
                                <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                    <tr>
                                        <?php /* Below .added code add for solve the no and label issues added on 28 april 2014 added by ganesh satav */ ?>
                                        <td width="40%" align="left" valign="top" class="form-table-title"><?php echo $label['gradewise_prod'][0]; ?></td>  
                                        <td width="30%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][1]; ?></td>
                                        <td width="30%" align="center" class="form-table-title"><?php echo $label['gradewise_prod'][2]; ?></td>
                                    </tr>
                                    <?php

                                    $i = 1;
                                    $feMinCount = 1;
                                    $gradeWiseProdMinKey = ($minLow == 'iron ore') ? ( ($gradeIronOre != 0) ? key($gradeWiseProdRom[$minLow]) + 1 : key($gradeWiseProdRom[$minLow]) ) : key($gradeWiseProdRom[$minLow]);
                                    if ($minLow == 'iron ore') { $gradeIronOre++; }
                                    $gradeKy = $gradeWiseProdRom[$minLow][$gradeWiseProdMinKey]['gradeProd'];
                                    $gradeVl = $gradeWiseProdRom[$minLow][$gradeWiseProdMinKey]['gradeProd']['gradeNames'];
                                    foreach($gradeVl as $gradeKk => $mainGrade){

                                        $lilist = array('a'=>'क','b'=>'ख','c'=>'ग','d'=>'घ','e'=>'ड़','f'=>'च','g'=>'छ','h'=>'ज','i'=>'झ');
                                        $feMinSubCount = 'a';
                                        foreach ($mainGrade as $mainGradeKey => $mainGradeVal) {
                                            $tmpGradeFormName = "gradeForm" . $i;
                                            $gradeValues = $gradeWiseProdRom[$minLow][$gradeWiseProdMinKey]['gradeProd']['gradeValues'];

                                            ?>
                                            <tr>
                                                <td>
                                                    <?php 

                                                    echo "(" . $feMinSubCount++ . ") " . $mainGradeVal;

                                                    ?>
                                                </td>
                                                <td><?php echo $gradeValues[$mainGradeKey]['despatches']; ?></td>
                                                <td><?php echo $gradeValues[$mainGradeKey]['pmv']; ?></td>
                                            </tr>
                                        <?php $i++; } ?>
                                    <?php } $tmpGradeFormName = "gradeForm" . $i;  ?>
                                    <tr>
                                        <td colspan="3"><?php echo $label['gradewise_prod']['note']; ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td align="left" class="welcome-signout sec_tit">
                            <span class="welcome-signout"><strong> <?php echo $label['gradewise_prod']['title_two']." (".strtoupper($partIIM[0]).$subMin.")"; ?></strong></span>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                <tr>
                                    <td align="left" valign="top" class="form-table-title"><?php echo $label['gradewise_prod'][3]; ?></td>
                                    <?php if ($formNo == 3) { ?>
                                        <td align="center" class="form-table-title"><?php echo $label['gradewise_prod'][9]; ?></td>
                                    <?php } ?>
                                    <td align="center" class="form-table-title"><?php echo $label['gradewise_prod'][4]; ?></td>
                                    <td align="center" class="form-table-title"><?php echo $label['gradewise_prod'][5]; ?></td>
                                    <td align="center" class="form-table-title"><?php echo $label['gradewise_prod'][6]; ?></td>
                                    <td align="center" class="form-table-title"><?php echo $label['gradewise_prod'][7]; ?></td>
                                    <td align="center" class="form-table-title"><?php echo $label['gradewise_prod'][8]; ?></td>
                                </tr>
                                <?php 

                                $i = 1;
                                $feMinCount = 1;
                                $gradeWiseProdMinKey = ($minLow == 'iron ore') ? ( ($gradeIronOre != 0) ? key($gradeWiseProd[$minLow]) + 1 : key($gradeWiseProd[$minLow]) ) : key($gradeWiseProd[$minLow]);
                                if ($minLow == 'iron ore') { $gradeIronOre++; }
                                $gradeKy = $gradeWiseProd[$minLow][$gradeWiseProdMinKey]['gradeProd'];
                                $gradeVl = $gradeWiseProd[$minLow][$gradeWiseProdMinKey]['gradeProd']['gradeNames'];
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
                                        $lilist = array('a'=>'à¤•','b'=>'à¤–','c'=>'à¤—','d'=>'à¤˜','e'=>'à¥œ','f'=>'à¤š','g'=>'à¤›','h'=>'à¤œ','i'=>'à¤');
                                        $feMinSubCount = 'a';
                                        foreach ($mainGrade as $mainGradeKey => $mainGradeVal) {
                                            $tmpGradeFormName = "gradeForm" . $i;
                                            $gradeValues = $gradeWiseProd[$minLow][$gradeWiseProdMinKey]['gradeProd']['gradeValues'];

                                            ?>
                                            <tr>
                                                <td>
                                                    <?php 

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
                            </table>
                        </td>
                    </tr>

                <?php } ?>
                    
            <?php } ?>

            <?php if ($returnType == 'ANNUAL') { ?>
            
                <!----------------------- PART - VII - ANNUAL RETURNS ---------------------->

                <!-- COST OF PRODUCTION -->
                <br pagebreak="true" />
                <tr>
                    <td align="center"><span style="margin-left:50px"><strong><?php echo $label['production_cost']['part']; ?></strong></span></td>
                </tr>
                <tr>
                    <td align="center" class="f_s_9"><span style="margin-left:50px"><?php echo $label['production_cost'][0]; ?></span></td>
                </tr>
                <tr><td></td></tr>
                <tr>
                    <td align="left">
                        <div id="production_cost">
                            <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; " nobr="true" class="f_s_9">
                                <tr>
                                    <td width="10%"><?php echo $label['production_cost'][1]; ?></td>
                                    <td width="50%"><?php echo $label['production_cost'][2]; ?></td>
                                    <td width="40%"><?php echo $label['production_cost'][3]; ?></td>
                                </tr>
                                <tr>
                                    <td>(i)</td>
                                    <td align="left"><?php echo $label['production_cost'][4]; ?></td>
                                    <td><?php echo $costData['total_direct_cost']; ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td align="left"><?php echo $label['production_cost'][5]; ?></td>
                                    <td><?php echo $costData['exploration_cost']; ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td align="left"><?php echo $label['production_cost'][6]; ?></td>
                                    <td><?php echo $costData['mining_cost']; ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td align="left"><?php echo $label['production_cost'][7]; ?></td>
                                    <td><?php echo $costData['beneficiation_cost']; ?></td>
                                </tr>
                                <tr>
                                    <td>(ii)</td>
                                    <td align="left"><?php echo $label['production_cost'][8]; ?></td>
                                    <td><?php echo $costData['overhead_cost']; ?></td>
                                </tr>
                                <tr>
                                    <td>(iii)</td>
                                    <td align="left"><?php echo $label['production_cost'][9]; ?></td>
                                    <td><?php echo $costData['depreciation_cost']; ?></td>
                                </tr>
                                <tr>
                                    <td>(iv)</td>
                                    <td align="left"><?php echo $label['production_cost'][10]; ?></td>
                                    <td><?php echo $costData['interest_cost']; ?></td>
                                </tr>
                                <tr>
                                    <td>(v)</td>
                                    <td align="left"><?php echo $label['production_cost'][11]; ?> <span title="<?php echo $label['production_cost'][13]; ?>" class="text-success">(<?php echo $label['production_cost'][12]; ?>)</span></td>
                                    <td><?php echo $costData['royalty_cost']; ?></td>
                                </tr>
                                <tr>
                                    <td>(vi)</td>
                                    <td align="left"><?php echo $label['production_cost'][14]; ?></td>
                                    <td><?php echo $costData['past_pay_dmf']; ?></td>
                                </tr>
                                <tr>
                                    <td>(vii)</td>
                                    <td align="left"><?php echo $label['production_cost'][15]; ?></td>
                                    <td><?php echo $costData['past_pay_nmet']; ?></td>
                                </tr>
                                <tr>
                                    <td>(viii)</td>
                                    <td align="left"><?php echo $label['production_cost'][16]; ?></td>
                                    <td><?php echo $costData['taxes_cost']; ?></td>
                                </tr>
                                <tr>
                                    <td>(ix)</td>
                                    <td align="left"><?php echo $label['production_cost'][17]; ?></td>
                                    <td><?php echo $costData['dead_rent_cost']; ?></td>
                                </tr>
                                <tr>
                                    <td>(x)</td>
                                    <td align="left">
                                        <?php echo $label['production_cost'][18]; ?><br>
                                        <?php echo $costData['others_spec']; ?>
                                    </td>
                                    <td><?php echo $costData['others_cost']; ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td align="left"><?php echo $label['production_cost'][19]; ?></td>
                                    <td><?php echo $costData['total_cost']; ?></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="center" class="f_s_9"><span style="margin-left:50px"><?php echo $label['production_cost']['note']; ?></span></td>
                </tr>
                
            <?php } ?>
            

        </tbody>
    </table>

    
    <!--ESTIMATION TABLE-->
    <br/><br/>
    <div class="div">
        <table align="center" cellpadding="2" cellspacing="0" nobr="true" width="100%" nobr="true">
            <tr>
                <td width="5%">&nbsp;</td>
                <td width="90%">
                    <table class="f_s_9 center" align="center" cellpadding="2" cellspacing="0" nobr="true" width="100%" border="0.5" >
                        <thead class="f_s_10">
                        <?php if ($returnType == 'ANNUAL') { ?>
                            <tr>
                                
                                <th>Mineral Name </th>
                                <th>Production proposal for financial year <br/><?php echo $period; ?></th>
                                <th>Production reported during the financial year <br/><?php echo $period; ?></th>
                                <th>Difference</th>
                                
                            </tr>
                        <?php } else { ?>
                            <tr>
                                
                                <th>Mineral Name </th>
                                <th>Production proposal for current financial year</th>
                                <th>Cumulative production as reported upto the current month</th>
                                <th>Difference</th>
                               
                            </tr>
                        <?php } ?>
                        </thead>

                        <?php
                        // // if(count($estimation == 2)){
                        // $row = "";
                        // // Added one more index for multiple minerals
                        // // Added on 29/06/2018 by Naveen Jha to fix issue of 35KAR03014
                        // foreach ($estimation as $e) {
                        //     $row .= "<tr>";
                        //     $row .= "<td border='0.5' align='center'>" . $e[0]['min'] . "</td>";
                        //     $row .= "<td border='0.5' align='center'>" . $e[0]['est'] . "</td>";
                        //     $row .= "<td border='0.5' align='center'>" . $e[0]['cum'] . "</td>";
                        //     $row .= "<td border='0.5' align='center'>" . $e[0]['diff'] . "</td>";
                        //     $row .= "</tr>";
                            
                        // }
                        // echo $row;
                        ?>
                        
                        <?php
                        $row = "";
                        foreach ($estimation as $e) {
                            $row .= "<tr>";
                            $row .= "<td align='center'>" . $e['min'] . "</td>";
                            $row .= "<td align='center'>" . $e['est'] . "</td>";
                            $row .= "<td align='center'>" . $e['cum'] . "</td>";
                            $row .= "<td align='center'>" . $e['diff'] . "</td>";
                            $row .= "</tr>";
                        }
                        echo $row;
                        ?>
                    </table>
                </td>
                <td width="5%">&nbsp;</td>
            </tr>
        </table>
        
    </div>

    <!-- footer section -->
    <table style="margin-left:40px;width:100%">
        <tr><td></td></tr>
        <tr><td></td></tr>
        <tr><td class="f_s_10"> 
        I Certify that the information furnished above is correct and complete in all respects.</td></tr>
        <tr><td></td></tr>
        <tr><td></td></tr>
        <tr>
            <td>
                <table width="100%" nobr="true" style="font-size:11px">
                    <tr>
                        <td width="40%">Place :<br /> Dist: <?php echo $mine['district'] . ", " . $mine['state']; ?> <br /> Pin:<?php echo $mine['pin']; ?></td>
                        <td width="20%"></td>
                        <td width="40%">Signature</td>
                    </tr>
                    <tr>
                        <td>Date : <?php echo $finalSubmitDate; ?></td>
                        <td></td>
                        <td>Name : <?php echo $fillerName; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Designation: <?php echo $fillerdesignation; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Owner / Agent / Mining Engineer / Manager</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td></td></tr>
        <tr>
            <td width="100%" style="text-align: center;font-size:11px">
                <b><i><?php echo $ipTimeFormat; ?></i></b>
            </td>
        </tr>
    </table>

</div>
