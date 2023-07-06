<?php 
    /* 
    * Check mineCode for J&K. If mineCode is related to J&K then remove the "amp;" value from mineCode.
    * Change Done By Pravin Bhakare on Date 17-01-2019
    * This was done to address the issue of miners of J&K not able to save the forms 
    **/
    if (strpos($mineCode, '&') !== false) {  $mineCode = str_replace('amp;','',$mineCode); } 
    // ***********

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

    /**
     * @auther ganesh satav 
     * function below create function because of set label no a abd b
     * added on the 21 April 2014
     */
    function rome1($N) {

        $atoz = array('', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        return $atoz[$N];
    }

?>

<?php ini_set('max_execution_time', 0); ?>

<tr class="f_s_11">
    <td valign="top" align="center">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center" valign="top"><br />
                    <div id="bodydiv">
                        <table width="100%" border="0"  style="margin:20px;" cellspacing="0" cellpadding="0" align="center">
                            <tr><td height="5"></td></tr>
                            <tr>
                                <td align="center" class="welcome-page-name">
                                    <table width="100%" cellspacing="0" border="0" cellpadding="0">
                                        <tr>
                                            <td width="100%">
                                                <table border="0" align="center" cellpadding="1" cellspacing="1" style="line-height:10px" class="f_s_9">
                                                    <tr>
                                                        <td align="center"><strong>FORM <?php echo $formName; ?></strong></td>
                                                    </tr>
                                                    <?php if ($returnType == 'ANNUAL') { ?>
                                                        <tr>
                                                            <td align="center"><strong>For the financial Year 1st April <?php echo $returnYear; ?> to 31st March <?php echo($returnYear + 1); ?></strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center"><strong>ANNUAL RETURN</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center"><strong>[ See rule 45(5) (b) <?php echo $formRuleNumber; ?>]</strong></td>
                                                        </tr>
                                                    <?php } else { ?>
                                                        <tr>
                                                            <td align="center"><strong>For the Month of <?php echo $returnMonth . " " . $returnYear; ?></strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center"><strong>MONTHLY RETURN</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center"><strong>[ See rule 45(5) (a) <?php echo $formRuleNumber; ?>]</strong></td>
                                                        </tr>
                                                    <?php } ?>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" style="font-weight: bold" class="f_s_9">
                                    (Read the instructions carefully before filling the particulars)
                                </td>
                            </tr>
                            <tr>
                                <td align="left" class="f_s_10">To</td>
                            </tr>
                            <tr>
                                <td align="left" class="f_s_9">(i) The Regional Controller of Mines<br>Indian Bureau of Mines<br><?php echo ucwords(strtolower($regionName)); ?> Region,<br>PIN: <br><br>( Please address to Regional Controller of Mines in whose territorial jurisdiction the mines falls as notified from time to time by the Controller General, Indian Bureau of Mines under Rule 62 of the Mineral Conservation and Development Rules, 1988 )<br><br>(ii) The State Government of  <?php echo ucwords(strtolower($mine['state'])); ?>
                                </td>
                            </tr>

                            <!-- MINE DETAILS -->
                            <tr>
                                <td align="center">
                                    <div id="details_maines">
                                        <table width="95%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center" class="f_s_10"><span style="margin-left:50px"><strong>Part - I</strong></span></td>
                                            </tr>
                                            <tr>
                                                <td align="center" class="f_s_10"><span style="margin-left:50px"><strong>(General and Labour)</strong></span></td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="font-size:10px"><strong>1. Details of the Mine</strong></td>
                                            </tr>
                                            <tr>
                                                <td align="center" valign="top">
                                                    <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;font-size:10px;">
                                                        <tr>
                                                            <td width="50%" align="left" class="lable-text">(a) Registration Number</td>
                                                            <td width="50%" align="left"><?php echo $mine['reg_no']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" class="lable-text">(b) Mine Code</td>
                                                            <td align="left"><?php echo $mineCode ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" class="lable-text">(c) Name of the Mineral</td>
                                                            <td align="left"><?php echo $mine['mineral']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" class="lable-text">(d) Name of Mine</td>
                                                            <td align="left"><?php echo $mine['mine_name']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" class="lable-text">(e) Name(s)  of other Mineral(s), if any produced from the same mine</td>
                                                            <td align="left"><?php echo $mine['other_mineral'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" class="welcome-signout" colspan="2"><span style="margin-left:5px"><?php
                                                            if ($returnType == 'ANNUAL') {
                                                                echo "2.";
                                                            } else {
                                                                echo "(f)";
                                                            }
                                                            ?> Location of the Mine</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" class="lable-text">Village</td>
                                                            <td align="left"><?php echo $mine['village']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" class="lable-text">Post Office</td>
                                                            <td align="left"><?php echo $mine['post_office']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" class="lable-text">Tahsil/Taluk</td>
                                                            <td align="left"><?php echo $mine['taluk']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" class="lable-text"> District</td>
                                                            <td align="left"><?php echo $mine['district']; ?></td> 
                                                        </tr>
                                                        <tr>
                                                            <td align="left" class="lable-text">State </td>
                                                            <td align="left"><?php echo $mine['state']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" class="lable-text">PIN Code</td>
                                                            <td align="left"><?php echo $mine['pin']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" class="lable-text">Fax No.</td>
                                                            <td align="left"><?php echo $mine['fax']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" class="lable-text">Phone No.</td>
                                                            <td align="left"><?php echo $mine['phone']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" class="lable-text">Mobile No.</td>
                                                            <td align="left"><?php echo $mine['mobile']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" class="lable-text">E-mail</td>
                                                            <td align="left"><?php echo $mine['email']; ?></td>
                                                        </tr>
                                                    </table>                    
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <!-- Name and address details -->
                        <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
                            <tr>
                                <td align="center">
                                    <div id="name_address">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center" style="font-size:10px"><strong>
                                                    <?php
                                                    if ($returnType == 'ANNUAL') {
                                                        echo "3.";
                                                    } else {
                                                        // below add the . discuss with ajay sir
                                                        // added by ganesh satav dated 12 sep 2014
                                                        echo "2.";
                                                    }
                                                    ?> Name and Address of Lessee/Owner (along with fax no. and e-mail)
                                                </strong></td>
                                            </tr>
                                            <tr>
                                                <td align="center" valign="top">
                                                    <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;font-size:10px">
                                                        <tr>
                                                            <td width="50%" align="left" class="lable-text">Name of Owner</td>
                                                            <td width="50%" align="left"><?php echo $owner['name']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" class="lable-text"> Street/Village</td>
                                                            <td align="left"><?php echo $owner['street']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" class="lable-text">Post Office</td>
                                                            <td align="left"><?php echo $owner['post_office']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" class="lable-text">Tahsil/Taluk</td>
                                                            <td align="left"><?php echo $owner['taluk']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" class="lable-text"> District</td>
                                                            <td align="left"><?php echo $owner['district']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" class="lable-text">State</td>
                                                            <td align="left"><?php echo $owner['state']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" class="lable-text">PIN Code</td>
                                                            <td align="left"><?php echo $owner['pin']; ?></td> 
                                                        </tr>
                                                        <tr>
                                                            <td align="left" class="lable-text">Fax No</td>
                                                            <td align="left"><?php echo $owner['fax']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" class="lable-text">Phone No</td>
                                                            <td align="left"><?php echo $owner['phone']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" class="lable-text">Mobile No</td>
                                                            <td align="left"><?php echo $owner['mobile']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" class="lable-text">E-mail</td>
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
                        </table>
                    </div>
                </td>
            </tr>
        </table>

        
        <?php if ($returnType != 'ANNUAL') { ?>

            <!--Rent Details-->
            <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td align="center" valign="top">
                        <div id="bodydiv">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                <tr>
                                    <td align="center">
                                        <div id="rent_details">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td align="center" style="font-size:10px"><strong>3. Details of Rent/ Royalty / Dead Rent paid in the month</strong></td>
                                                </tr>
                                                <tr>
                                                    <td align="center" valign="top">
                                                        <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;font-size:10px;">
                                                            <tr>
                                                                <td width="50%" align="left" class="lable-text">(i) Rent paid for the period (in &#8377;)</td>
                                                                <td width="50%" align="left"><?php echo $pastSurfaceRent; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" class="lable-text">(ii) Royalty paid for the period (in &#8377;)</td>
                                                                <td align="left"><?php echo $pastRoyaltyRent; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" class="lable-text">(iii) Dead Rent paid for the period (in &#8377;)</td>
                                                                <td align="left"><?php echo $pastDeadRent; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
            
            <!--Working Details-->
            <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td align="center" valign="top">
                        <div id="bodydiv">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                <tr>
                                    <td align="center">
                                        <div id="details_working">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td align="center" style="font-size:10px"><strong>4. Details on working of mine</strong></td>
                                                </tr>
                                                <tr>
                                                    <td align="center" valign="top">
                                                        <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;font-size:10px;">
                                                            <tr>
                                                                <td width="35%" align="left" class="lable-text">(i) Number of days the mine worked</td>
                                                                <td width="65%" align="left"><?php echo $total_days; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" valign="top" class="lable-text">(ii) Reasons for work stoppage in the mine during the month</td>
                                                                <td align="left">
                                                                    <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E5D0BD">
                                                                        <tr>
                                                                            <td width="80%" align="center" class="form-table-title">Reasons</td>
                                                                            <td width="20%" align="center" class="form-table-title">No of days</td>
                                                                        </tr>
                                                                        <?php
                                                                        for ($i = 0; $i < count($reason); $i++) {
                                                                            ?>
                                                                            <tr>
                                                                                <td><?php echo ($reason[$i]) ? $reason[$i] : " "; ?> </td>
                                                                                <td align="center"><?php echo ($no_of_days[$i]) ? $no_of_days[$i] : " "; ?></td>
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
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
            
            <!--Average Daily-->
            <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td align="center" valign="top"><br />
                        <div id="bodydiv">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                <tr>
                                    <td align="center">
                                        <div id="daily_wages">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td align="center" style="font-size:10px"><strong>5. (i) Average Daily Employment and Total Wages paid</strong></td>
                                                </tr>
                                                <tr>
                                                    <td align="center" valign="top">
                                                        <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;font-size:11px;">
                                                            <tr>
                                                                <td width="21%" rowspan="2" align="center" class="form-table-title">Work place</td>
                                                                <td width="25%" colspan="2" align="center" class="form-table-title">Direct</td>
                                                                <td width="24%" colspan="2" align="center" class="form-table-title">Contract</td> 
                                                                <td width="30%" colspan="2" align="center" class="form-table-title">Total wages for the month (in &#8377;)</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="12%" align="center" class="form-table-title">Male</td>
                                                                <td width="13%" align="center" class="form-table-title">Female</td>
                                                                <td width="11%" align="center" class="form-table-title">Male</td>
                                                                <td width="13%" align="center" class="form-table-title">Female</td>
                                                                <td width="14%" align="center" class="form-table-title">Direct</td>
                                                                <td width="16%" align="center" class="form-table-title">Contract</td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" valign="top" class="lable-text">Opencast </td>
                                                                <td align="center"><?php echo $open['male_avg_direct'] ?></td>
                                                                <td align="center"><?php echo $open['female_avg_direct'] ?></td>
                                                                <td align="center"><?php echo $open['male_avg_contract'] ?></td>
                                                                <td align="center"><?php echo $open['female_avg_contract'] ?></td>
                                                                <td align="center"><?php echo $open['wage_direct'] ?></td>
                                                                <td align="center"><?php echo $open['wage_contract'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" valign="top" class="lable-text">Below Ground </td>
                                                                <td align="center"><?php echo $below['male_avg_direct'] ?></td>
                                                                <td align="center"><?php echo $below['female_avg_direct'] ?></td>
                                                                <td align="center"><?php echo $below['male_avg_contract'] ?></td>
                                                                <td align="center"><?php echo $below['female_avg_contract'] ?></td>
                                                                <td align="center"><?php echo $below['wage_direct'] ?></td>
                                                                <td align="center"><?php echo $below['wage_contract'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" valign="top" class="lable-text">Above Ground </td>
                                                                <td align="center"><?php echo $above['male_avg_direct'] ?></td>
                                                                <td align="center"><?php echo $above['female_avg_direct'] ?></td>
                                                                <td align="center"><?php echo $above['male_avg_contract'] ?></td>
                                                                <td align="center"><?php echo $above['female_avg_contract'] ?></td>
                                                                <td align="center"><?php echo $above['wage_direct'] ?></td>
                                                                <td align="center"><?php echo $above['wage_contract'] ?></td>
                                                            </tr>
                                                            <tr class="welcome-page-name">
                                                                <td align="left" valign="top" class="total-bgcolor">Total</td>
                                                                <td align="center" class="total-bgcolor"><?php echo $total['total_male_direct']; ?></td>
                                                                <td align="center" class="total-bgcolor"><?php echo $total['total_female_direct']; ?></td>
                                                                <td align="center" class="total-bgcolor"><?php echo $total['total_male_contract']; ?></td>
                                                                <td align="center" class="total-bgcolor"><?php echo $total['total_female_contract']; ?></td>
                                                                <td align="center" class="total-bgcolor"><?php echo $total['total_direct']; ?></td>
                                                                <td align="center" class="total-bgcolor"><?php echo $total['total_contract']; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr><td></td></tr>
                                                <tr>
                                                    <td align="center" valign="top">
                                                        <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;font-size:10px;">
                                                            <tr>
                                                                <td width="60%" align="left" class="lable-text">
                                                                    <table width="100%" cellspacing="0" cellpadding="0">
                                                                        <tr>
                                                                            <td>(ii) Total number of technical and supervisory staff employed in
                                                                                the mine during the month</td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                                <td width="40%" align="left" style="font-size:11px"> <?php echo $total['total_tech_emp']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" valign="top" class="lable-text">
                                                                    <table width="100%" cellspacing="0" cellpadding="0">
                                                                        <tr>
                                                                            <td>(iii) Total salaries paid to technical and supervisory staff employed in<br />
                                                                                the mine during the month (in &#8377;)</td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                                <td align="left" style="font-size:11px"> <?php echo $total['total_salaries']; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>

        <?php } ?>
        
        <?php if ($returnType == 'ANNUAL') { ?>

            <!----------------------- PART - I - ANNUAL RETURNS ---------------------->

            <!-- PARTICULARS OF AREA OPERATED -->
            <div>
                <table width="100%" cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                    <!--   Add the below text for show in the pdf. added by ganesh satav dated: 2 feb 14 -->
                    <tr>
                        <td align="left" width="100%">11. Particulars of Area Operated/Lease <br />(Furnish information on items (i) to (v) lease-wise in case mine workings cover more than one lease) </td>
                    </tr>
                    <tr>
                        <td width="100%" valign="top">
                            <?php for ($particular = 0; $particular < $totalParticulars; $particular++) { ?>
                                <table width="100%" cellpadding="2" bordercolor="#E5D0BD" border="0.1" style="border-collapse:collapse;" class="f_s_9">
                                    <tr>
                                        <td width="100%" align="left" class="pdf-text" colspan="2" ><b>Lease - <?php echo $particular + 1; ?></b></td>
                                    </tr>
                                    <tr>
                                        <td width="50%" align="left" class="pdf-text">Lease No. allotted by State Govt.</td>
                                        <td width="50%" align="left" class="pdf-data"><?php echo $particulars[$particular]['lease_no']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="100%" align="left" colspan="2"  class="pdf-text">(i) Area under lease </td>
                                    </tr>

                                    <tr>
                                        <td width="50%" align="left" class="pdf-text"> Under Forest</td>
                                        <td width="50%" align="left" class="pdf-data" class="pdf-data"><?php echo $particulars[$particular]['under_forest']; ?> hectares</td>
                                    </tr>
                                    <tr>
                                        <td width="50%" align="left" class="pdf-text"> Outside Forest</td>
                                        <td width="50%" align="left" class="pdf-data" class="pdf-data"><?php echo $particulars[$particular]['outside_forest']; ?> hectares</td>
                                    </tr>
                                    <tr>
                                        <td width="50%" align="left" class="pdf-text">Total</td>
                                        <td width="50%" align="left" class="pdf-data" class="pdf-data"><?php echo $particulars[$particular]['total']; ?> hectares</td>
                                    </tr>
                                    <tr>
                                        <td width="50%" align="left" class="pdf-text">(ii) Date of execution of mining lease deed</td>
                                        <td width="50%" align="left" class="pdf-data"><?php echo $particulars[$particular]['execution_date']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%" align="left" class="pdf-text">(iii) Period of lease</td>
                                        <td width="50%" align="left" class="pdf-data"><?php echo $particulars[$particular]['lease_period']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%" align="left" class="pdf-text">(iv) Area for which surface rights are held </td>
                                        <td width="50%" align="left" class="pdf-data"><?php echo $particulars[$particular]['surface_rights']; ?> hectares</td>
                                    </tr>
                                    <tr>
                                        <td width="50%" align="left" class="pdf-text">(v) (a) Date of renewal (if applicable)</td>
                                        <td width="50%" align="left" class="pdf-data"><?php echo $particulars[$particular]['renewal_date']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%" align="left" class="pdf-text"> (b) Period of renewal (if applicable)</td>
                                        <td width="50%" align="left" class="pdf-data"><?php echo $particulars[$particular]['renewal_period']; ?></td>
                                    </tr>
                                </table>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
                <table width="100%" cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                    <tr>
                        <td align="left" class="pdf-text" colspan="1" width="40%">(vi) In case there is more than one mine in <br/> the same lease area, indicate name <br/> of mine and mineral produced
                        </td>
                        <td colspan="1" width="60%">
                            <table cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;" width='90%'>
                                <tr>
                                    <td align='center' width='30%'><b>Mine Name</b></td>
                                    <td align='center' width='30%'><b>Mine Code</b></td>
                                    <td align='center' width='30%'><b>Mineral Name</b></td>
                                </tr>
                                <?php
                                if($particulars[0]['lease_info']!='')
                                {
                                    foreach ($particulars[0]['lease_info'] as $leaseInfo) {
                                        $splittedInfo = explode("-", $leaseInfo);
                                        $particularMineName = $splittedInfo[0];
                                        $particularMineCode = $splittedInfo[1];
                                        $particularMineralName = $splittedInfo[2];
                                        $leaseRow = '';
                                        $leaseRow .= '<tr>';
                                        $leaseRow .= '<td class="pdf-data">' . $particularMineName . '</td>';
                                        $leaseRow .= '<td class="pdf-data">' . $particularMineCode . '</td>';
                                        $leaseRow .= '<td class="pdf-data">' . $particularMineralName . '</td>';
                                        $leaseRow .= '</tr>';
                                        echo $leaseRow;
                                    }
                                }
                                else
                                {
                                    ?><!--   Add the below tr for show null(--)value if in return not select the mine details. by ganesh satav dated: 2 feb 14 -->
                                    <tr>
                                        <td align='center' width='30%'><b>--</b></td>
                                        <td align='center' width='30%'><b>--</b></td>
                                        <td align='center' width='30%'><b>--</b></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- AREA OF UTILIZATION -->
            <div class="page-break">
                <table width="100%" cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                    <tr style="font-size:12px;">
                        <td width="40%" align="left">12. Lease area (surface area) utilisation
                            as at the end of year (hectares)</td>
                        <td width="20%" align="center" >Under<br>forest </td>
                        <td width="20%" align="center" >Outside<br>forest</td>
                        <td width="20%" align="center" >Total</td>
                    </tr>
                    <tr>
                        <td align="left" class="pdf-text">(i) Already exploited & abandoned by<br/> 
                             opencast (O/C) mining</td>
                        <td align="center">
                            <?php echo $utilisation['FOREST_ABANDONED_AREA']; ?>
                        </td>
                        <td align="center">
                            <?php echo $utilisation['NON_FOREST_ABANDONED_AREA']; ?>
                        </td>
                        <td align="center" class="welcome-page-name">
                            <?php echo $utilisation['TOTAL_ABANDONED_AREA']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" class="pdf-text">(ii) Covered under current (O/C)<br> 
                             Workings</td>
                        <td align="center">
                            <?php echo $utilisation['FOREST_WORKING_AREA']; ?>
                        </td>
                        <td align="center">
                            <?php echo $utilisation['NON_FOREST_WORKING_AREA']; ?>
                        </td>
                        <td align="center" class="welcome-page-name">
                            <?php echo $utilisation['TOTAL_WORKING_AREA']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" class="pdf-text">(iii) Reclaimed/Rehabilitated</td>
                        <td align="center">
                            <?php echo $utilisation['FOREST_RECLAIMED_AREA']; ?>
                        </td>
                        <td align="center">
                            <?php echo $utilisation['NON_FOREST_RECLAIMED_AREA']; ?>
                        </td>
                        <td align="center" class="welcome-page-name">
                            <?php echo $utilisation['TOTAL_RECLAIMED_AREA']; ?>
                        </td>
                    </tr>

                    <tr>
                        <td align="left" class="pdf-text">(iv) Used for waste disposal</td>
                        <td align="center">
                            <?php echo $utilisation['FOREST_WASTE_AREA']; ?>
                        </td>
                        <td align="center">
                            <?php echo $utilisation['NON_FOREST_WASTE_AREA']; ?>
                        </td>
                        <td align="center" class="welcome-page-name">
                            <?php echo $utilisation['TOTAL_WASTE_AREA']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" class="pdf-text">(v) Occupied by plant, buildings,<br> 
                             residential, welfare buildings & roads
                        </td>
                        <td align="center">
                            <?php echo $utilisation['FOREST_BUILDING_AREA']; ?>
                        </td>
                        <td align="center">
                            <?php echo $utilisation['NON_FOREST_BUILDING_AREA']; ?>
                        </td>
                        <td align="center" class="welcome-page-name">
                            <?php echo $utilisation['TOTAL_BUILDING_AREA']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" class="pdf-text">(vi) Other Purpose (<?php echo $utilisation['OTHER_PURPOSE']; ?>)</td>
                        <td align="center"><br>
                            <?php echo $utilisation['FOREST_OTHER_AREA']; ?>
                        </td>
                        <td align="center"><br>
                            <?php echo $utilisation['NON_FOREST_OTHER_AREA']; ?>
                        </td>
                        <td align="center" class="welcome-page-name"><br>
                            <?php echo $utilisation['TOTAL_OTHER_AREA']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" class="pdf-text">(vii) Work done under progressive mine<br> 
                             closure plan during the year</td>
                        <td align="center">
                            <?php echo $utilisation['FOREST_PROGRESSIVE_AREA']; ?>
                        </td>
                        <td align="center">
                            <?php echo $utilisation['NON_FOREST_PROGRESSIVE_AREA']; ?>
                        </td>
                        <td align="center" class="welcome-page-name">
                            <?php echo $utilisation['TOTAL_PROGRESSIVE_AREA']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" align="left" width='40%'>13. Ownership/exploiting Agency of the mine: <br />(Public Sector/Private sector/Joint Sector)<br></td>
                        <td align="center" colspan="3">
                            <?php echo $utilisation['AGENCY']; ?>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!----------------------- PART - II - ANNUAL RETURNS ---------------------->

            <!-- EMPLOYMENT WAGES - (I) -->
            <div class="page-break">
                <div class="pdf-text-heading">Part-II <br/>Employment & Wages (I)</div><br/>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center">
                            <table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                <tr>
                                    <td colspan="3" align="left" class="pdf-text">1. Number of technical and supervisory staff employed at the mine</td>
                                </tr>
                                <tr>
                                    <td align="center" width="60%" class="pdf-text-lg">Description</td>
                                    <td align="center" width="20%" class="pdf-text-lg">Wholly employed</td>
                                    <td align="center" width="20%" class="pdf-text-lg">Partly employed</td>
                                </tr>
                                <tr>
                                    <td align="left" class="pdf-text">(i) Graduate Mining Engineer</td>
                                    <td align="center" class="pdf-data">
                                        <?php echo $returnDetails['GRAD_MINING_WHOLLY']; ?>
                                    </td>
                                    <td align="center" class="pdf-data">
                                        <?php echo $returnDetails['GRAD_MINING_PARTLY']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="pdf-text">(ii) Diploma Mining Engineer</td>
                                    <td align="center" class="pdf-data">
                                        <?php echo $returnDetails['DIP_MINING_WHOLLY']; ?>
                                    </td>
                                    <td align="center" class="pdf-data">
                                        <?php echo $returnDetails['DIP_MINING_PARTLY']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="pdf-text">(iii) Geologist</td>
                                    <td align="center" class="pdf-data">
                                        <?php echo $returnDetails['GEO_WHOLLY']; ?>
                                    </td>
                                    <td align="center" class="pdf-data">
                                        <?php echo $returnDetails['GEO_PARTLY']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="pdf-text">(iv) Surveyor</td>
                                    <td align="center" class="pdf-data">
                                        <?php echo $returnDetails['SURV_WHOLLY']; ?>
                                    </td>
                                    <td align="center" class="pdf-data">
                                        <?php echo $returnDetails['SURV_PARTLY']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top" class="pdf-text">(v) Other administrative and technical supervisory staff</td>
                                    <td align="center" class="pdf-data">
                                        <?php echo $returnDetails['OTHER_WHOLLY']; ?>
                                    </td>
                                    <td align="center" class="pdf-data">
                                        <?php echo $returnDetails['OTHER_PARTLY']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left"  class="pdf-text"><b>Total</b></td>
                                    <td align="center" class="pdf-data">
                                        <b><?php echo $returnDetails['TOTAL_WHOLLY']; ?></b>
                                    </td>
                                    <td align="center" class="pdf-data">
                                        <b><?php echo $returnDetails['TOTAL_PARTLY']; ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top"  class="pdf-text">2. (i) Number of days the mine worked</td>
                                    <td align="center" colspan="2" class="pdf-data">
                                        <?php echo $returnDetails['DAYS_MINE_WORKED']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top"  class="pdf-text"> (ii) No.of shifts per day</td>
                                    <td align="center" colspan="2" class="pdf-data">
                                        <?php echo $returnDetails['NO_OF_SHIFTS']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top"  class="pdf-text">
                                         (iii) Indicate reasons for work stoppage in the mine during the 
                                        year (due to strike, lockout, heavy rain, non-availability of 
                                        labour, transport bottleneck, lack of demand, uneconomic
                                        operations, etc.) and the number of days of work stoppage for 
                                        each of the factors separately .
                                    </td>
                                    <td align="center" colspan="2"  class="pdf-data" valign="top">
                                        <table border="1" style="border-collapse:collapse;">
                                            <tr>
                                                <td align="center"  width="50%">Reason</td>
                                                <td align="center"  width="50%">No of Days </td>
                                            </tr>
                                            <?php
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($workStoppageDetails['stoppage_sn_' . $i] != "") {
                                                    $workDetails = '<tr>';
                                                    $workDetails .= '<td>' . $workStoppageReasons[$workStoppageDetails['stoppage_sn_' . $i]] . '</td>';
                                                    $workDetails .= '<td>' . $workStoppageDetails['no_days_' . $i] . '</td>';
                                                    $workDetails .= '</tr>';

                                                    echo $workDetails;
                                                }
                                            }
                                            ?>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!--=====================EMPLOYMENT WAGES - II=============================-->
            <div class="page-break">
                <div class="pdf-text-heading">Employment & Wages (II)</div><br/>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center">
                            <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                <tr>
                                    <td colspan="7" align="left" class="pdf-text">3.(i) Employment of Labour and wages paid :- </td>
                                </tr>
                                <tr>
                                    <td colspan="7" align="left" class="pdf-text">Maximum number of persons employed on any one day during the year</td>
                                </tr>
                                <tr>
                                    <td colspan="7" align="left">
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td class="f_s_9" width="27%">(i) In workings below ground on</td>
                                                <td class="f_s_9" width="11%"><?php echo $returnDetailsPart2['WORKING_BELOW_DATE']; ?></td>
                                                <td class="f_s_9" align="left" width="4%"><?php echo $returnDetailsPart2['WORKING_BELOW_PER']; ?></td>
                                                <td width="10%"> Persons</td>
                                            </tr>
                                            <tr>
                                                <td class="f_s_9">(ii) In all in the mine on</td>
                                                <td class="f_s_9"><?php echo $returnDetailsPart2['WORKING_ALL_DATE']; ?></td>
                                                <td class="f_s_9" align="left"><?php echo $returnDetailsPart2['WORKING_ALL_PER']; ?></td>
                                                <td> Persons</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7" align="left">
                                        <table width="100%" border="1" cellspacing="0" cellpadding="2" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                            <tr>
                                                <td align="center" width="14%" valign="top"  rowspan="2">Classification</td>
                                                <td align="center" width="30%"  colspan="3">Total number of man days worked during the year</td>
                                                <td align="center" width="13%"  rowspan="2">No. of days worked during the year</td>
                                                <td align="center" width="30%"  colspan="3">Average daily number of persons employed </td>
                                                <td align="center" width="13%"  rowspan="2">Total<br>Wages /Salary bills for the year(in &#8377;)</td>
                                            </tr>
                                            <tr>
                                                <td align="center" >Direct</td>
                                                <td align="center" >Contract</td>
                                                <td align="center" >Total</td>
                                                <td align="center" >Male</td>
                                                <td align="center" >Female</td>
                                                <td align="center" >Total</td>
                                            </tr>
                                            <tr>
                                                <td align="center" valign="top" >(1)</td>
                                                <td align="center" >2(A)</td>
                                                <td align="center" >2(B)</td>
                                                <td align="center" >2(C)</td>
                                                <td align="center" >(3)</td>
                                                <td align="center" >4(A)</td>
                                                <td align="center"  >4(B)</td>
                                                <td align="center"  >4(C)</td>
                                                <td align="center"  >(5)</td>
                                            </tr>
                                            <tr>
                                                <td colspan="9" class="pdf-text-lg">A. Below Ground</td>
                                            </tr>
                                            <tr>
                                                <td class="pdf-text">(i) Foreman and mining<br />mates</td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['BELOW_FOREMAN_DIRECT']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['BELOW_FOREMAN_CONTRACT']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['BELOW_FOREMAN_MAN_TOT']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['BELOW_FOREMAN_DAYS']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['BELOW_FOREMAN_MALE']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['BELOW_FOREMAN_FEMALE']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['BELOW_FOREMAN_PER_TOTAL']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['BELOW_FOREMAN_TOTAL_WAGES']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pdf-text">(ii) Face workers and<br /> Loaders</td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['BELOW_FACE_DIRECT']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['BELOW_FACE_CONTRACT']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['BELOW_FACE_MAN_TOT']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['BELOW_FACE_DAYS']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['BELOW_FACE_MALE']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['BELOW_FACE_FEMALE']; ?>
                                                </td>
                                                <td align="center"  class="pdf-data">
                                                    <?php echo $empWagesPart2['BELOW_FACE_PER_TOTAL']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['BELOW_FACE_TOTAL_WAGES']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pdf-text">(iii) Others</td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['BELOW_OTHER_DIRECT']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['BELOW_OTHER_CONTRACT']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['BELOW_OTHER_MAN_TOT']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['BELOW_OTHER_DAYS']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['BELOW_OTHER_MALE']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['BELOW_OTHER_FEMALE']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['BELOW_OTHER_PER_TOTAL']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['BELOW_OTHER_TOTAL_WAGES']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="9" align="left" valign="top" class="pdf-text-lg">B. Opencast workings </td>
                                            </tr>
                                            <tr>
                                                <td class="pdf-text">(i) Foreman and mining<br />mates</td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['OC_FOREMAN_DIRECT']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['OC_FOREMAN_CONTRACT']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['OC_FOREMAN_MAN_TOT']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['OC_FOREMAN_DAYS']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['OC_FOREMAN_MALE']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['OC_FOREMAN_FEMALE']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['OC_FOREMAN_PER_TOTAL']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['OC_FOREMAN_TOTAL_WAGES']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pdf-text">(ii) Face workers and<br />Loaders</td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['OC_FACE_DIRECT']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['OC_FACE_CONTRACT']; ?>
                                                </td>
                                                <td align="center"  class="pdf-data">
                                                    <?php echo $empWagesPart2['OC_FACE_MAN_TOT']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['OC_FACE_DAYS']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['OC_FACE_MALE']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['OC_FACE_FEMALE']; ?>
                                                </td>
                                                <td align="center"  class="pdf-data">
                                                    <?php echo $empWagesPart2['OC_FACE_PER_TOTAL']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['OC_FACE_TOTAL_WAGES']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pdf-text">(iii) Others</td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['OC_OTHER_DIRECT']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['OC_OTHER_CONTRACT']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['OC_OTHER_MAN_TOT']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['OC_OTHER_DAYS']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['OC_OTHER_MALE']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['OC_OTHER_FEMALE']; ?>
                                                </td>
                                                <td align="center"  class="pdf-data">
                                                    <?php echo $empWagesPart2['OC_OTHER_PER_TOTAL']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['OC_OTHER_TOTAL_WAGES']; ?>
                                                </td>                                
                                            </tr>
                                            <tr>
                                                <td colspan="9" align="left" valign="top" class="pdf-text-lg">C. Above ground</td>
                                            </tr>
                                            <!-- add some text for show in the pdf. Added by ganesh satavss : 13 Feb 2014 -->
                                            <tr>
                                                <td class="pdf-text">(i) Clerical & Supervisory <br />
                                                                Staff (excluding the<br />
                                                                superior supervisory staff)</td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['ABOVE_CLERICAL_DIRECT']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['ABOVE_CLERICAL_CONTRACT']; ?>
                                                </td>
                                                <td align="center"  class="pdf-data">
                                                    <?php echo $empWagesPart2['ABOVE_CLERICAL_MAN_TOT']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['ABOVE_CLERICAL_DAYS']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['ABOVE_CLERICAL_MALE']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['ABOVE_CLERICAL_FEMALE']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['ABOVE_CLERICAL_PER_TOTAL']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['ABOVE_CLERICAL_TOTAL_WAGES']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pdf-text">(ii) Workers in any<br />Attached factory,<br /> Workshop or mineral<br />dressing plant</td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['ABOVE_ATTACHED_DIRECT']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['ABOVE_ATTACHED_CONTRACT']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['ABOVE_ATTACHED_MAN_TOT']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['ABOVE_ATTACHED_DAYS']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['ABOVE_ATTACHED_MALE']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['ABOVE_ATTACHED_FEMALE']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['ABOVE_ATTACHED_PER_TOTAL']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['ABOVE_ATTACHED_TOTAL_WAGES']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pdf-text">(iii) Others</td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['ABOVE_OTHER_DIRECT']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['ABOVE_OTHER_CONTRACT']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['ABOVE_OTHER_MAN_TOT']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['ABOVE_OTHER_DAYS']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['ABOVE_OTHER_MALE']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['ABOVE_OTHER_FEMALE']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['ABOVE_OTHER_PER_TOTAL']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['ABOVE_OTHER_TOTAL_WAGES']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" valign="top" class="welcome-page-name pdf-data">Total</td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['TOTAL_DIRECT']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['TOTAL_CONTRACT']; ?>
                                                </td>
                                                <td align="center"  class="pdf-data">
                                                    <?php echo $empWagesPart2['TOTAL_MAN']; ?>
                                                </td>
                                                <td align="center" class="pdf-data">
                                                    <?php echo $empWagesPart2['TOTAL_DAYS']; ?>
                                                </td>
                                                <td align="center"  class="pdf-data">
                                                    <?php echo $empWagesPart2['TOTAL_MALE']; ?>
                                                </td>
                                                <td align="center"  class="pdf-data">
                                                    <?php echo $empWagesPart2['TOTAL_FEMALE']; ?>
                                                </td>
                                                <td align="center"  class="pdf-data">
                                                    <?php echo $empWagesPart2['TOTAL_PERSONS']; ?>
                                                </td>
                                                <td align="center"  class="pdf-data">
                                                    <?php echo $empWagesPart2['TOTAL_WAGES']; ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="left" class="pdf-text">3.(ii) Total salaries paid to technical and supervisory staff employed in the mine during the year (in &#8377;)</td>
                                    <td colspan="3" align="center" class="pdf-data"> <?php echo $empWagesPart2['TOTAL_SALARY']; ?> </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!--=======================CAPITAL STRUCTURE===================-->

            <div class="page-break">
                <div class="pdf-text-heading">Part-II A<br/>Capital Structure</div><br/>
                <table id ="capitalStrucFieldsTable" width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                    <tr>
                        <td colspan="7" align="left" class="pdf-text">1. Value of Fixed Assets (in &#8377;)
                            <?php echo $fixedResult['assests_value']; ?>
                            <br />
                            (in respect of the mine, beneficiation plant, mine work-shop, power and water installation)<br />
                            <br />
                            In case this information is furnished as combined information in another mine's return please specify mine Code/mine Name
                        </td>
                    </tr>
                    <tr>
                        <td width="100%" colspan="7">
                            <table width="60%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                <tr>
                                    <td width="32%" colspan="3" class="pdf-text-lg">Mine Name</td>
                                    <td width="32%" colspan="2" class="pdf-text-lg">Mine Code</td>
                                    <td width="32%" colspan="2" class="pdf-text-lg">Mineral Name</td>
                                </tr>
                                <?php
                                if($capMineCodes!='')
                                {
                                    foreach ($capMineCodes as $capSturc) {
                                        $splittedCap = explode("-", $capSturc);
                                        $capMineName = $splittedCap[0];
                                        $capMineCode = $splittedCap[1];
                                        $capMineralName = $splittedCap[2];
                                        $capRow = '';
                                        $capRow .= '<tr align="center">';
                                        $capRow .= '<td colspan="3" class="pdf-data">' . $capMineName . '</td>';
                                        $capRow .= '<td colspan="2" class="pdf-data">' . $capMineCode . '</td>';
                                        $capRow .= '<td colspan="2" class="pdf-data">' . $capMineralName . '</td>';
                                        $capRow .= '</tr>';
                                        echo $capRow;
                                    }
                                }
                                else
                                {?>
                                <!--   Add the below tr for show null(--)value if in return not select the mine details. by ganesh satav dated: 2 feb 14 -->
                                <tr>
                                    <td colspan="3"  ><b>--</b></td>
                                    <td colspan="2"  ><b>--</b></td>
                                    <td colspan="2"  ><b>--</b></td>
                                </tr>    <?php
                                }
                                
                                ?>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7" align="right"  >(in &#8377;)</td>                                            
                    </tr>
                    <tr>
                        <td width="25%" align="center" class="pdf-text-lg">Description</td>
                        <td width="12.5%" align="center" class="pdf-text-lg">As at the beginning of the year</td>
                        <td width="12.5%" align="center" class="pdf-text-lg">Additions during the Year</td>
                        <td width="12.5%" align="center" class="pdf-text-lg">Sold or discarded during the year</td>
                        <td width="12.5%" align="center" class="pdf-text-lg"> Depreciation during the year</td>
                        <td width="12.5%" align="center" class="pdf-text-lg">Net<br />closing Balance (2+3)-(4+5)</td>
                        <td width="12.5%" align="center" class="pdf-text-lg">Estimated <br />market value</td>
                    </tr>
                    <tr>
                        <td align="left" class="pdf-text">(i) Land </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['land_beg']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['land_addition'] ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['land_sold']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['land_depreciated']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['land_close_bal'] ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['land_estimated']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7" align="left" class="pdf-text">(ii) Building</td>
                    </tr>
                    <tr>
                        <td align="left" class="pdf-text">Industrial</td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['indus_beg']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['indus_addition']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['indus_sold']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['indus_depreciated']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['indus_close_bal']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['indus_estimated']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" class="pdf-text">Residential</td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['resi_beg']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['resi_addition']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['resi_sold']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['resi_depreciated']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['resi_close_bal']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['resi_estimated']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="pdf-text" align="left">(iii) Plant and<br />Machinery<br />including<br />transport<br />equipment</td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['plant_beg']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['plant_addition']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['plant_sold']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['plant_depreciated']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['plant_close_bal']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['plant_estimated']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="pdf-text" align="left">(iv) Capitalised
                            Expenditure such
                            as pre-production <br />exploration,
                            development,major<br /> overhaul and repair to 
                            machinery etc.<br/> (As prescribed under Income Tax Act)
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['capital_beg']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['capital_addition']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['capital_sold']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['capital_depreciated']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['capital_close_bal']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['capital_estimated']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left"  class="pdf-text">
                            Total
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['total_beg']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['total_addition']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['total_sold']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['total_depreciated']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['total_close_bal']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $tableData['total_estimated']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7" align="left"  class="pdf-text">
                            2. Source of Finance (as at the end of the year) (in &#8377;):
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left" class="pdf-text">
                            (i) Paid up Share Capital 
                        </td>
                        <td align="center" colspan = "4" class="pdf-data">
                            <?php echo $fixedResult['paid_share']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left" class="pdf-text">
                            (ii) Own Capital 
                        </td>
                        <td align="center" colspan = "4" class="pdf-data">
                            <?php echo $fixedResult['own_Capital']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left" class="pdf-text">
                            (iii) Reserve &amp; Surplus (All Types) 
                        </td>
                        <td align="center" colspan = "4" class="pdf-data">
                            <?php echo $fixedResult['reserve']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left" class="pdf-text">
                            (iv) Long Term loans outstanding
                        </td>
                        <td align="center" colspan = "4" class="pdf-data">
                            <?php echo $fixedResult['loan_outstanding']; ?>
                        </td>
                    </tr>
                    <tr width="90%">
                        <td colspan="2" align="center" class="pdf-text-lg">Name of the Institution/Source</td>
                        <td colspan="2" align="center" class="pdf-text-lg">Amount of Loan</td>
                        <td colspan="3" align="center" class="pdf-text-lg">Rate of Interest</td>
                    </tr>
                    <?php
                    // $dynamicData = $sf_data->getRaw('dynamicData');
                    $totalRows = count($dynamicData) / 3;
                    for ($i = 1; $i <= $totalRows; $i++) {
                        $table = '<tr>';
                        $table .= '<td colspan="2" align="center" class="pdf-data">' . $dynamicData["institute_name_" . $i] . '</td>';
                        $table .= '<td colspan="2" align="center" class="pdf-data">' . $dynamicData["loan_amount_" . $i] . '</td>';
                        $table .= '<td colspan="3" align="center" class="pdf-data">' . $dynamicData["interest_rate_" . $i] . '</td>';
                        $table .= '</tr>';
                        echo $table;
                    }
                    ?>
                    <tr>
                        <td colspan="7"  align="left" class="pdf-text">
                            3. Interest and Rent (in &#8377;)
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"  align="left" class="pdf-text">
                            (i) Interest paid during the year
                        </td>
                        <td align="center" colspan = "4" class="pdf-data">
                            <?php echo $fixedResult['interest_paid']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left" class="pdf-text">
                            (ii) Rents (excluding surface rent) <br /> paid during the year
                        </td>
                        <td align="center" colspan = "4" class="pdf-data">
                            <?php echo $fixedResult['rent_paid']; ?>
                        </td>
                    </tr>
                </table>
            </div>

            <!--==================CONSUMPTION OF MATERIAL==================-->
            <div class="padd-bot">
                <div class="pdf-text-heading padd-bot"><b>Part - III</b><br/>Consumption of Materials</div>
                <div class="pdf-text-heading padd-bot">1. Quantity and cost of material consumed during the year</div>
                <table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                    <tr>
                        <td width="40%" align="left" valign="top" class="pdf-text-lg"  >Description</td>
                        <td width="20%" align="center" class="pdf-text-lg"  >Unit</td>
                        <td width="20%" align="center" class="pdf-text-lg"  >Quantity</td>
                        <td width="20%" align="center" class="pdf-text-lg"  >Value (in &#8377;)</td>
                    </tr>
                    <tr>
                        <td colspan="4" align="left" valign="top" class="pdf-text-lg"  >(i) Fuel</td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pdf-text">(a) Coal</td>
                        <td align="center" class="pdf-text">Tonnes</td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsQuant['COAL_QUANTITY']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsQuant['COAL_VALUE']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pdf-text">(b) Diesel Oil</td>
                        <td align="center" class="pdf-text">Ltrs</td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsQuant['DIESEL_QUANTITY']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsQuant['DIESEL_VALUE']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pdf-text">(c) Petrol</td>
                        <td align="center" class="pdf-text">Ltrs</td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsQuant['PETROL_QUANTITY']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsQuant['PETROL_VALUE']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pdf-text">(d) Kerosene</td>
                        <td align="center" class="pdf-text">Ltrs</td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsQuant['KEROSENE_QUANTITY']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsQuant['KEROSENE_VALUE']; ?>
                        </td>
                    </tr>

                    <tr>
                        <td align="left" valign="top" class="pdf-text">(e) Gas</td>
                        <td align="center" class="pdf-text">Cu.M.</td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsQuant['GAS_QUANTITY']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsQuant['GAS_VALUE']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="left" valign="top" class="pdf-text-lg"  >(ii) Lubricant</td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pdf-text">(a) Lubricant oil</td>
                        <td align="center" class="pdf-text">Ltrs</td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsQuant['LUBRICANT_QUANTITY']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsQuant['LUBRICANT_VALUE']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pdf-text">(b) Grease</td>
                        <td align="center" class="pdf-text">kgs.</td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsQuant['GREASE_QUANTITY']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsQuant['GREASE_VALUE']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="left" valign="top" class="pdf-text-lg"  >(iii) Electricity</td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pdf-text">(a) Consumed</td>
                        <td align="center" class="pdf-text">Kwh</td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsQuant['CONSUMED_QUANTITY']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsQuant['CONSUMED_VALUE']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pdf-text">(b) Generated</td>
                        <td align="center" class="pdf-text">Kwh</td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsQuant['GENERATED_QUANTITY']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsQuant['GENERATED_VALUE']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pdf-text">(c) Sold</td>
                        <td align="center" class="pdf-text">Kwh</td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsQuant['SOLD_QUANTITY']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsQuant['SOLD_VALUE']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left" valign="top" class="pdf-text-lg"  >(iv) Explosives (furnish full details in Part
                            IV)</td>
                        <td align="center" >
                            <?php echo $matConsQuant['EXPLOSIVES_VALUE']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top"  >(v) Tyres</td>
                        <td align="center" class="pdf-text">Nos.</td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsQuant['TYRES_QUANTITY']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsQuant['TYRES_VALUE']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top"  >(vi) Timber &amp; Supports</td>
                        <td> </td>
                        <td> </td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsQuant['TIMBER_VALUE']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top"  >(vii) Drill rods &amp; kits</td>
                        <td align="center" class="pdf-text">Nos.</td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsQuant['DRILL_QUANTITY']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsQuant['DRILL_VALUE']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top"  >(viii) Other spares & stores</td>
                        <td> </td>
                        <td> </td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsQuant['OTHER_VALUE']; ?>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!--======================ROYALITY AND RENTS===================-->
            <div class="page-break padd-top">
                <div class="pdf-text-heading padd-bot">2. Royalty and Rents (in &#8377;)</div>
                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                    <tr>
                        <td width="50%" align="center" class="pdf-text-lg"  >Item</td>
                        <td width="25%" align="center" class="pdf-text-lg"  >Paid for current year</td>
                        <td width="25%" align="center" class="pdf-text-lg"  >Paid towards past<br />arrears</td>
                    </tr>
                    <tr>
                        <td width="50%" align="left" valign="top" class="pdf-text">(a) Royalty</td>
                        <td width="25%" align="center" class="pdf-data">
                            <?php echo $matConsRoyalty['ROYALTY_CURRENT']; ?>
                        </td>
                        <td width="25%" align="center" class="pdf-data">
                            <?php echo $matConsRoyalty['ROYALTY_PAST']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" align="left" valign="top" class="pdf-text">(b) Dead rent</td>
                        <td width="25%" align="center" class="pdf-data">
                            <?php echo $matConsRoyalty['DEAD_RENT_CURRENT']; ?>
                        </td>
                        <td width="25%" align="center" class="pdf-data">
                            <?php echo $matConsRoyalty['DEAD_RENT_PAST']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" align="left" valign="top" class="pdf-text">(c) Surface rent</td>
                        <td width="25%" align="center" class="pdf-data">
                            <?php echo $matConsRoyalty['SURFACE_RENT_CURRENT']; ?>
                        </td>
                        <td width="25%" align="center" class="pdf-data">
                            <?php echo $matConsRoyalty['SURFACE_RENT_PAST']; ?>
                        </td>
                    </tr>
                </table>
                <table  width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                    <tr>
                        <td colspan="1" align="left"   width="60%" class="pdf-text-lg">
                            3. Compensation paid for felling trees during the year (in &#8377;)
                        </td>
                        <td colspan="2" align="center" width="40%" class="pdf-text-lg">
                            <?php echo $matConsRoyalty['TREE_COMPENSATION']; ?>
                        </td>
                    </tr>
                    <!--==================DEPRECIATION ON ASSETS=================-->
                    <tr>
                        <td colspan="1" align="left"   width="60%" class="pdf-text-lg">
                            4. Depreciation on fixed assets (in &#8377;)
                        </td>
                        <td colspan="2" align="center" width="40%" class="pdf-text-lg">
                            <?php echo $matConsRoyalty['DEPRECIATION']; ?>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Ganesh comment this line replace date : 13 Feb 2014 -->
            <!--    <div class="pdf-text-heading padd-bot">2. Royalty and Rents (in <span><img src="<?php //echo rupeeImg_Path; ?>"></span>)</div>-->
            <!--=======================TAXES AND CESSES=====================-->
            <div class="pdf-text-heading padd-bot">5. Taxes and Cesses</div>
            <div class="padd-bot page-break">
                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                    <tr>
                        <td width="40%" rowspan="2" align="center"  >Item</td>
                        <td width="60%" colspan="2" align="center"  >Amount in &#8377; paid during the year to</td>
                    </tr>
                    <tr>
                        <td height="24" align="center"  >Central Govt.</td>
                        <td align="center"  >State Govt.</td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pdf-text">(i) Sales Tax</td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsTax['SALES_TAX_CENTRAL']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsTax['SALES_TAX_STATE']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td height="29" align="left" valign="top" class="pdf-text">(ii) Welfare cess</td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsTax['WELFARE_TAX_CENTRAL']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsTax['WELFARE_TAX_STATE']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left" valign="top" class="pdf-text">(iii) Other taxes & cesses:-</td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pdf-text">(a) Mineral cess</td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsTax['MIN_CESS_TAX_CENTRAL']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsTax['MIN_CESS_TAX_STATE']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pdf-text">(b) Cess on dead rent</td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsTax['DEAD_CESS_TAX_CENTRAL']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsTax['DEAD_CESS_TAX_STATE']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pdf-text">(c) Others (please specify):<br />
                            <?php echo $matConsTax['OTHER_TAX']; ?><br />
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsTax['OTHER_TAX_CENTRAL']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $matConsTax['OTHER_TAX_STATE']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left" valign="top" class="welcome-signout" class="pdf-text">
                            6. Other expenses (in  &#8377;)
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pdf-text">(i) Overheads</td>
                        <td colspan="2" align="center" class="pdf-data">
                            <?php echo $matConsTax['OVERHEADS']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pdf-text">(ii) Maintenance</td>
                        <td colspan="2" align="center" class="pdf-data">
                            <?php echo $matConsTax['MAINTENANCE']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pdf-text">(iii) Money value of other benefits paid to workmen</td>
                        <td colspan="2" align="center" class="pdf-data">
                            <?php echo $matConsTax['WORKMEN_BENEFITS']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pdf-text">(iv) Payment made to professional agencies</td>
                        <td colspan="2" align="center" class="pdf-data">
                            <?php echo $matConsTax['PAYMENT_AGENCIES']; ?>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="page-break padd-top">
                <div class="pdf-text-heading padd-top padd-bot">Part - IV<br/>Consumption of Explosives</div>

                <!--=================EXPLOSIVE CONSUMPTON====================-->
                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;" class="padd-bot">
                    <tr>
                        <td width="40%" align="left" valign="top" class="pdf-text">
                            1. Licensed capacity of magazine: ( specify unit separately in Kg/Tonne, numbers,  meters )
                        </td>
                        <td align="center" width="60%">
                            <table width="90%" border="1" cellpadding="2" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                <tr>
                                    <td align="center"   width="30%">Item</td>
                                    <td align="center"   width="30%">Unit</td>
                                    <td align="center"   width="30%">Capacity</td>
                                </tr>
                                <tr>
                                    <td align="center" class="pdf-text">Explosives</td>
                                    <td align="center" class="pdf-text">Kg</td>
                                    <td align="center" class="pdf-data">
                                        <?php echo $expConReturn['MAG_CAPACITY_EXP']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" class="pdf-text">Detonators</td>
                                    <td align="center" class="pdf-text">Nos.</td>
                                    <td align="center" class="pdf-data">
                                        <?php echo $expConReturn['MAG_CAPACITY_DET']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" class="pdf-text">Fuses</td>
                                    <td align="center" class="pdf-text">Meters</td>
                                    <td align="center" class="pdf-data">
                                        <?php echo $expConReturn['MAG_CAPACITY_FUSE']; ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pdf-text">2. Total production during the year (in Tonne)</td>
                        <td align="center" class="pdf-data">
                            <?php echo $expConReturn['TOTAL_ROM_ORE']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pdf-text">3. Overburden removed (in Tonne)</td>
                        <td align="center" class="pdf-data">
                            <?php echo $expConReturn['OB_BLASTING']; ?>
                        </td>
                    </tr>
                </table>

                <!--===============CLASSIFICATION OF EXPLOSIVE===============-->
                <table class="padd-top" width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;margin-top: 20px;">
                    <tr>
                        <td width="20%" rowspan="2" align="center"  >Classification of<br />Explosives</td>
                        <td width="10%" rowspan="2" align="center"  >Unit</td>
                        <td width="35%" colspan="2" align="center"  >Quantity consumed<br />during the year</td>
                        <td width="35%" colspan="2" align="center"  >Estimated requirement<br />during the next year</td>
                    </tr>
                    <tr>
                        <td align="center"  >Small dia.<br />(upto 32<br />mm)</td>
                        <td align="center"  >Large dia.<br />(above 32<br />mm)</td>
                        <td align="center"  >Small dia.<br />(upto 32<br />mm)</td>
                        <td align="center"  >Large dia.<br />(above 32<br />mm)</td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="welcome-page-name">1. Gun Powder</td>
                        <td align="center" class="pdf-text">Kg</td>
                        <td align="center" colspan="2">
                            <?php echo $expCon['LARGE_CON_QTY']; ?>
                        </td>
                        <td align="center" colspan="2">
                            <?php echo $expCon['LARGE_REQ_QTY']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td  colspan="6" align="left" valign="top" class="welcome-page-name">
                            2. Nitrate Mixture
                        </td>
                    </tr>
                    <tr>
                        <td align="left" class="pdf-text-sm"> (a) Loose ammonium<br>nitrate</td>
                        <td align="center" class="pdf-text-sm">Kg</td>
                        <td align="center" class="pdf-text-sm"><?php echo $expCon['SMALL_CON_QTY_1']; ?></td>
                        <td align="center" class="pdf-text-sm"><?php echo $expCon['LARGE_CON_QTY_1']; ?></td>
                        <td align="center" class="pdf-text-sm"><?php echo $expCon['SMALL_REQ_QTY_1']; ?></td>
                        <td align="center" class="pdf-text-sm"><?php echo $expCon['LARGE_REQ_QTY_1']; ?></td>
                    </tr>
                    <tr>
                        <td align="left" class="pdf-text-sm">(b) Ammonium nitrate in cartridged form</td>
                        <td align="center" class="pdf-text-sm">Kg</td>
                        <td align="center" class="pdf-text-sm"><?php echo $expCon['SMALL_CON_QTY_2']; ?></td>
                        <td align="center" class="pdf-text-sm"><?php echo $expCon['LARGE_CON_QTY_2']; ?></td>
                        <td align="center" class="pdf-text-sm"><?php echo $expCon['SMALL_REQ_QTY_2']; ?></td>
                        <td align="center" class="pdf-text-sm"><?php echo $expCon['LARGE_REQ_QTY_2']; ?></td>
                    </tr>
                    <tr>
                        <td align="left">3.&nbsp;Nitro Compound</td>
                        <td align="center" class="pdf-text-sm">Kg</td>
                        <td align="center" class="pdf-text-sm"><?php echo $expCon['SMALL_CON_QTY_3']; ?></td>
                        <td align="center" class="pdf-text-sm"><?php echo $expCon['LARGE_CON_QTY_3']; ?></td>
                        <td align="center" class="pdf-text-sm"><?php echo $expCon['SMALL_REQ_QTY_3']; ?></td>
                        <td align="center" class="pdf-text-sm"><?php echo $expCon['LARGE_REQ_QTY_3']; ?></td>
                    </tr>
                    <tr>
                        <td align="left">4.&nbsp;Liquid Oxygen soaked cartridges</td>
                        <td align="center" class="pdf-text-sm">Kg</td>
                        <td align="center" class="pdf-text-sm"><?php echo $expCon['SMALL_CON_QTY_4']; ?></td>
                        <td align="center" class="pdf-text-sm"><?php echo $expCon['LARGE_CON_QTY_4']; ?></td>
                        <td align="center" class="pdf-text-sm"><?php echo $expCon['SMALL_REQ_QTY_4']; ?></td>
                        <td align="center" class="pdf-text-sm"><?php echo $expCon['LARGE_REQ_QTY_4']; ?></td>
                    </tr>
                    <tr>
                        <td align="left">
                            5.&nbsp;Slurry explosives (Mention different trade names):<br/>
                            <?php echo $expCon['SLURRY_TN']; ?>
                        </td>
                        <td align="center" class="pdf-text-sm">Kg</td>
                        <td align="center" class="pdf-text-sm"><?php echo $expCon['SMALL_CON_QTY_5']; ?></td>
                        <td align="center" class="pdf-text-sm"><?php echo $expCon['LARGE_CON_QTY_5']; ?></td>
                        <td align="center" class="pdf-text-sm"><?php echo $expCon['SMALL_REQ_QTY_5']; ?></td>
                        <td align="center" class="pdf-text-sm"><?php echo $expCon['LARGE_REQ_QTY_5']; ?></td>
                    </tr>
                    <tr>
                        <td colspan="6" align="left" valign="top" class="welcome-page-name">
                            6. Detonators.
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pdf-text-sm">(i) Ordinary</td>
                        <td align="center" class="pdf-text-sm">Nos.</td>
                        <td align="center" class="pdf-text-sm" colspan="2">
                            <?php echo $expCon['LARGE_CON_QTY_6']; ?>
                        </td>
                        <td align="center" class="pdf-text-sm" colspan="2">
                            <?php echo $expCon['LARGE_REQ_QTY_6']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" align="left" valign="top" class="pdf-text-sm">(ii) Electrical</td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pdf-text-sm" style="padding-left: 10px;">(a) Ordinary</td>
                        <td align="center" class="pdf-text-sm">Nos.</td>
                        <td align="center" class="pdf-text-sm" colspan="2">
                            <?php echo $expCon['LARGE_CON_QTY_8']; ?>
                        </td>
                        <td align="center" class="pdf-text-sm" colspan="2">
                            <?php echo $expCon['LARGE_REQ_QTY_8']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pdf-text-sm" style="padding-left: 10px;">(b) Delay</td>
                        <td align="center" class="pdf-text-sm">Nos.</td>
                        <td align="center" class="pdf-text-sm" colspan="2">
                            <?php echo $expCon['LARGE_CON_QTY_9']; ?>
                        </td>
                        <td align="center" class="pdf-text-sm" colspan="2">
                            <?php echo $expCon['LARGE_REQ_QTY_9']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" align="left" valign="top" class="welcome-page-name">7. Fuse</td>
                    </tr>
                    <tr>
                        <td align="left">(a) Safety Fuse</td>
                        <td align="center" class="pdf-text-sm">Mts</td>
                        <td align="center" class="pdf-text-sm" colspan="2">
                            <?php echo $expCon['LARGE_CON_QTY_11']; ?>
                        </td>
                        <td align="center" class="pdf-text-sm" colspan="2">
                            <?php echo $expCon['LARGE_REQ_QTY_11']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left">(b) Detonating Fuse</td>
                        <td align="center" class="pdf-text-sm">Mts</td>
                        <td align="center" class="pdf-text-sm" colspan="2">
                            <?php echo $expCon['LARGE_CON_QTY_12']; ?>
                        </td>
                        <td align="center" class="pdf-text-sm" colspan="2">
                            <?php echo $expCon['LARGE_REQ_QTY_12']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left">8. Plastic ignition cord</td>
                        <td align="center" class="pdf-text-sm">Mts</td>
                        <td align="center" colspan="2" class="pdf-text-sm">
                            <?php echo $expCon['LARGE_CON_QTY_13']; ?>
                        </td>
                        <td align="center" colspan="2" class="pdf-text-sm">
                            <?php echo $expCon['LARGE_REQ_QTY_13']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td  align="left">9. Others:<br/>
                            <?php echo $expCon['OTHER_EXPLOSIVES']; ?>
                        </td>
                        <td align="center" class="pdf-text-sm"><?php echo $expCon['OTHER_UNIT']; ?></td>
                        <td align="center" colspan="2" class="pdf-text-sm">
                            <?php echo $expCon['LARGE_CON_QTY_14']; ?>
                        </td>
                        <td align="center" colspan="2" class="pdf-text-sm">
                            <?php echo $expCon['LARGE_REQ_QTY_14']; ?>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!--========================PART V STARTS HERE=========================-->
            <div class="padd-bot">
                <div class="pdf-text-heading">Part - V</div>
                <?php
                $i = 1;
                foreach ($mineralProduced as $minProduced) {
                    ?>
                    <div class="pdf-text-heading padd-bot">General Geology & Mining (Sec 1/2 for <?php echo ucwords(str_replace("_"," ",$minProduced)); ?>)</div>
                    <table width="100%" cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                        <tr>
                            <td valign="top" align="left" class="pdf-text" colspan="4">
                                1. Mineral(s) worked and their characteristics : 
                                (In case more than one mineral is worked, the
                                information asked for under (a) to (c) in respect 
                                of the remaining mineral(s) may be furnished in a
                                separate sheet and attached with the return)
                            </td>
                        </tr>
                        <tr>

                            <td width="85%" colspan="2" align="left"  >(a) Name of Mineral</td>
                            <td width="15%" colspan="2" align="left" class="pdf-data"><?php echo ucwords(str_replace('_', ' ', $minProduced)); ?></td>
                        </tr>
                        <tr>
                            <td align="left"   colspan="2">(b) Type of Ore</td>
                            <td colspan="2" align="left" class="pdf-data">
                                <table cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                                    <?php if (isset($geologyPart1[$i]['min_worked']['ore_lump']) && $geologyPart1[$i]['min_worked']['ore_lump'] == 1) { ?>
                                        <tr><td colspan="2" class="pdf-data">Lump</td></tr>
                                    <?php } if (isset($geologyPart1[$i]['min_worked']['ore_fines']) && $geologyPart1[$i]['min_worked']['ore_fines'] == 1) { ?>
                                        <tr><td colspan="2" class="pdf-data">Fines</td></tr>
                                    <?php } if (isset($geologyPart1[$i]['min_worked']['ore_granular']) && $geologyPart1[$i]['min_worked']['ore_granular'] == 1) { ?>
                                        <tr><td colspan="2" class="pdf-data">Granular</td></tr>
                                    <?php } if (isset($geologyPart1[$i]['min_worked']['ore_friable']) && $geologyPart1[$i]['min_worked']['ore_friable'] == 1) { ?>
                                        <tr><td colspan="2" class="pdf-data">Friable</td></tr>
                                    <?php } if (isset($geologyPart1[$i]['min_worked']['ore_platy']) && $geologyPart1[$i]['min_worked']['ore_platy'] == 1) { ?>
                                        <tr><td colspan="2" class="pdf-data">Platy</td></tr>
                                    <?php } if (isset($geologyPart1[$i]['min_worked']['ore_fibrous']) && $geologyPart1[$i]['min_worked']['ore_fibrous'] == 1) { ?>
                                        <tr><td colspan="2" class="pdf-data">Fibrous</td></tr>
                                    <?php } if (isset($geologyPart1[$i]['min_worked']['ore_other']) && $geologyPart1[$i]['min_worked']['ore_other'] != '') { ?>
                                        <tr><td colspan="2" class="pdf-data"><?php echo ucwords($geologyPart1[$i]['min_worked']['ore_other']); ?></td></tr>
                                    <?php } ?>
                                </table>
                            </td>
                        </tr>
                        <?php for ($ore = 0; $ore < count($geologyPart1[$i]['total_ores']); $ore++) { ?>
                            <?php $oreId = $geologyPart1[$i]['total_ores'][$ore]; ?>
                            <tr>
                                <td align="left"  colspan="4">(c) Quality: Chemical Analysis of Typical Grades Produced for 
                                    <?php
                                    if ($oreId == 1)
                                        echo '<span style="color:blue">Lump</span>';
                                    else if ($oreId == 2)
                                        echo '<span style="color:blue">Fines</span>';
                                    else if ($oreId == 3)
                                        echo '<span style="color:blue">Friable</span>';
                                    else if ($oreId == 4)
                                        echo '<span style="color:blue">Granular</span>';
                                    else if ($oreId == 5)
                                        echo '<span style="color:blue">Platy</span>';
                                    else if ($oreId == 6)
                                        echo '<span style="color:blue">Fibrous</span>';
                                    else if ($oreId == 7)
                                        echo '<span style="color:blue">' . ucwords($geologyPart1[$i]["min_worked"]["ore_other"]) . '</span>';
                                    ?>
                                </td>
                            </tr>

                            <?php for ($const = 1; $const <= ($geologyPart1[$i]['const_details'][$oreId]['total_const_tables']); $const++) { ?>

                                <tr>
                                    <td align="left" colspan="2">Constituent</td>
                                    <td align="left" colspan="2">Grade</td>
                                </tr>
                                <tr>
                                    <td align="left" class="pdf-text-sm">(i) Size Range</td>
                                    <td align="left" class="pdf-text-sm"><?php echo (isset($geologyPart1[$i]['const_details'][$oreId][$const]['size_range'])) ? $geologyPart1[$i]['const_details'][$oreId][$const]['size_range'] : ''; ?></td>
                                    <td colspan="2" class="pdf-text-sm" align="center"><?php echo (isset($geologyPart1[$i]['const_details'][$oreId][$const]['size_range_grade'])) ? $geologyPart1[$i]['const_details'][$oreId][$const]['size_range_grade'] : ''; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" class="pdf-text-sm">(ii) Principal Constituent</td>
                                    <td align="left" class="pdf-text-sm"><?php echo (isset($geologyPart1[$i]['const_details'][$oreId][$const]['principal_const'])) ? $geologyPart1[$i]['const_details'][$oreId][$const]['principal_const'] : ''; ?></td>
                                    <td colspan="2" class="pdf-text-sm" align="center"><?php echo (isset($geologyPart1[$i]['const_details'][$oreId][$const]['principal_const_grade'])) ? $geologyPart1[$i]['const_details'][$oreId][$const]['principal_const_grade'] : ''; ?></td>
                                </tr>
                                <?php for ($subconst = 0; $subconst < count($geologyPart1[$i]['const_details'][$oreId][$const]['subsidiary_const']); $subconst++) { ?>
                                    <tr>
                                        <?php if ($subconst == 0) { ?>
                                            <td align="left" class="pdf-text-sm">(iii) Subsidiary Constituent</td>
                                        <?php } else { ?>
                                            <td align="left"> </td>
                                        <?php } ?>
                                        <td align="left" class="pdf-text-sm"><?php echo $geologyPart1[$i]['const_details'][$oreId][$const]['subsidiary_const'][$subconst]; ?></td>
                                        <td colspan="2" class="pdf-text-sm" align="center"><?php echo $geologyPart1[$i]['const_details'][$oreId][$const]['subsidiary_const_grade'][$subconst]; ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>

                        <tr>
                            <td colspan="1" class="pdf-text" align="left">(a). Name of rock/mineral excavated and disposed as waste</td>
                            <td colspan="3" class="pdf-data" align="center"><?php echo (isset($geologyPart1[$i]['qty_details']['rock'])) ? $geologyPart1[$i]['qty_details']['rock'] : ''; ?></td>
                        </tr>
                        <tr>
                            <td colspan="1" class="pdf-text" align="left">(b). Name(s) of the ore/mineral excavated but not sold i.e., mineral reject</td>
                            <td colspan="3" class="pdf-data" align="center"><?php echo (isset($geologyPart1[$i]['qty_details']['min_excavated'])) ? $geologyPart1[$i]['qty_details']['min_excavated'] : ''; ?></td>
                        </tr>
                        <tr>
                            <td colspan="1" class="pdf-text" align="left">(c). Typical analysis of mineral reject(s)</td>
                            <td colspan="3" class="pdf-data" align="center"><?php echo (isset($geologyPart1[$i]['qty_details']['const_analysis'])) ? $geologyPart1[$i]['qty_details']['const_analysis'] : ''; ?></td>
                        </tr>

                        <tr  >
                            <td colspan="2" align="center" class="pdf-text">Constituent</td>
                            <td colspan="2" align="center" class="pdf-text">Grade %</td>
                        </tr>
                        <?php $geologyPart1[$i]['grade_details']['const_analysis'] = (isset($geologyPart1[$i]['grade_details']['const_analysis'])) ? $geologyPart1[$i]['grade_details']['const_analysis'] : array(); ?>
                        <?php for ($grade = 0; $grade < count($geologyPart1[$i]['grade_details']['const_analysis']); $grade++) { ?>
                            <tr>
                                <td colspan="2"  align="center" class="pdf-data"><?php echo $geologyPart1[$i]['grade_details']['const_analysis'][$grade]; ?></td>
                                <td colspan="2"  align="center" class="pdf-data"><?php echo $geologyPart1[$i]['grade_details']['grade_percent'][$grade]; ?></td>
                            </tr>
                        <?php } ?>

                    </table>
                    <?php
                    $i++;
                }
                ?>

            </div>
            
            <!--===================FOR SEC 3 GOELOGY PART 4 FORM V=======================-->
            <div class="page-break">
            
            <?php
            $z = 1;
            foreach ($mineralProduced as $minProduced) {
                ?>
                <!--   Add the below heading line not show on the pdf print. by ganesh satav dated: 13 feb 14 -->
                <div class="pdf-text-heading padd-bot"><b>3. Sec 3 for <?php echo ucwords(str_replace("_"," ",$minProduced)); ?></b></div>
                <table width="100%" cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                    <tbody>
                        <tr>
                            <td valign="middle" align="left" colspan="5"  >3. Reserves and Resources estimated at the end of the year</td>
                        </tr>
                        <tr>
                            <td valign="middle" width="33%" align="center"  >Classification</td>
                            <td valign="middle" width="10%" align="center"  >Code</td>
                            <td valign="middle" width="15%" align="center"  >Quantity</td>
                            <td valign="middle" align="center" colspan="2"  >Grade<br>(as per NMI grades<br>as indicated in the<br>mining plan)</td>
                        </tr>
                        <tr>
                            <td valign="top" align="center"  >(1)</td>
                            <td align="center"  >(2)</td>
                            <td align="center"  >(3)</td>
                            <td align="center" colspan="2"  >(4)</td>
                        </tr>
                        <tr>
                            <td valign="top" height="36" align="left" class="welcome-page-name">Total Mineral Resources <br> (A + B)</td>
                            <td align="left" class="pdf-text"> </td>
                            <td align="left"> </td>
                            <td align="left" colspan="2"> </td>
                        </tr>
                        <tr>
                            <td align="left"   colspan="5">A. Mineral Reserve</td>
                            <!--<td align="left" class="pdf-text"> </td>
                            <td align="left"> </td>
                            <td align="left" colspan="2"> </td>-->
                        </tr>
                        <tr>
                            <td height="29" align="left" class="pdf-text">1. Proved Mineral Reserve</td>
                            <td align="center" class="pdf-text">111</td>
                            <td align="center">
                                <table cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                                    <!-- for loop for quantity -->
                                    <?php for ($provedm = 1; $provedm <= $totalProved; $provedm++) { ?>
                                        <tr>
                                            <td class="pdf-data"><?php echo $geologyPart3[$z]['data']['proved_min_qty_' . $provedm]; ?></td>
                                        </tr>
                                    <?php } ?>
                                    <!-- for loop for quantity -->
                                </table>
                            </td>
                            <td align="center" colspan="2">
                                <table cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                                    <!-- for loop for grade -->
                                    <?php for ($provedg = 1; $provedg <= $totalProved; $provedg++) { ?>
                                        <tr>
                                            <?php $provedGradeId = $geologyPart3[$z]['data']['proved_min_grade_' . $provedg]; ?>
                                            <td class="pdf-data"><?php echo (isset($grades[$provedGradeId])) ? $grades[$provedGradeId] : ''; ?></td>
                                        </tr>
                                    <?php } ?>
                                    <!-- for loop for grade -->
                                </table>
                            </td>
                        </tr>
                        <!-- Probable Mineral Reserve -->
                        <tr>
                            <td valign="middle" align="left" rowspan="2" class="pdf-text">2. Probable Mineral Reserve</td>
                            <td align="center" class="pdf-text">121</td>
                            <td align="center">
                                <table cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                                    <!-- for loop for quantity -->
                                    <?php for ($probfq = 1; $probfq <= $totalProbableFirst; $probfq++) { ?>
                                        <tr>
                                            <td class="pdf-data"><?php echo $geologyPart3[$z]['data']['probable_first_min_qty_' . $probfq]; ?></td>
                                        </tr>
                                    <?php } ?>
                                    <!-- for loop for quantity -->
                                </table>
                            </td>
                            <td align="center" colspan="2">
                                <table cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                                    <!-- for loop for grade -->
                                    <?php for ($probfg = 1; $probfg <= $totalProbableFirst; $probfg++) { ?>
                                        <tr>
                                            <?php $probFirstId = $geologyPart3[$z]['data']['probable_first_min_grade_' . $probfg]; ?>
                                            <td class="pdf-data"><?php echo (isset($grades[$probFirstId])) ? $grades[$probFirstId] : ''; ?></td>
                                        </tr>
                                    <?php } ?>
                                    <!-- for loop for grade -->
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" class="pdf-text">122</td>
                            <td align="center">
                                <table cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                                    <?php for ($probsq = 1; $probsq <= $totalProbableSecond; $probsq++) { ?>
                                        <tr>
                                            <td class="pdf-data"><?php echo $geologyPart3[$z]['data']['probable_second_min_qty_' . $probsq]; ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                            <td align="center" colspan="2">
                                <table cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                                    <?php for ($probsg = 1; $probsg <= $totalProbableSecond; $probsg++) { ?>
                                        <tr>
                                            <?php $probSecondId = $geologyPart3[$z]['data']['probable_second_min_grade_' . $probsg]; ?>
                                            <td class="pdf-data"><?php echo (isset($grades[$probSecondId])) ? $grades[$probSecondId] : ''; ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                        </tr>
                        <!-- Probable Mineral Reserve -->
                        <tr>
                            <td valign="top" align="left"    colspan="5">B. Remaining Resources</td>
                            <!--<td align="center" class="pdf-text"> </td>
                            <td align="center"> </td>
                            <td align="center" colspan="2"> </td>-->
                        </tr>
                        <!-- Feasibility Mineral Resources -->
                        <tr>
                            <td align="left" class="pdf-text">1. Feasibility Mineral Resource</td>
                            <td align="center" class="pdf-text">211</td>
                            <td align="center">
                                <table cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                                    <?php for ($feasiq = 1; $feasiq <= $totalFeasibility; $feasiq++) { ?>
                                        <tr>
                                            <td class="pdf-data"><?php echo $geologyPart3[$z]['data']['feasibility_min_qty_' . $feasiq]; ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                            <td align="center" colspan="2">
                                <table cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                                    <?php for ($feasig = 1; $feasig <= $totalFeasibility; $feasig++) { ?>
                                        <tr>
                                            <?php $feasGradeId = $geologyPart3[$z]['data']['feasibility_min_grade_' . $feasig]; ?>
                                            <td class="pdf-data"><?php echo (isset($grades[$feasGradeId])) ? $grades[$feasGradeId] : ''; ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                        </tr>
                        <!-- Feasibility Mineral Resources -->
                        <!-- Prefeasibility -->
                        <tr>
                            <td valign="middle" align="left" rowspan="2" class="pdf-text">2. Prefeasibility Mineral Resource</td>
                            <td height="36" align="center" class="pdf-text">221  </td>
                            <td align="center">
                                <table cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                                    <?php for ($prefeasfq = 1; $prefeasfq <= $totalPreFeasiFirst; $prefeasfq++) { ?>
                                        <tr>
                                            <td class="pdf-data"><?php echo $geologyPart3[$z]['data']['pre_feasibility_first_min_qty_' . $prefeasfq]; ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                            <td align="center" colspan="2">
                                <table cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                                    <?php for ($prefeasfg = 1; $prefeasfg <= $totalPreFeasiFirst; $prefeasfg++) { ?>
                                        <tr>
                                            <?php $preFirstId = $geologyPart3[$z]['data']['pre_feasibility_first_min_grade_' . $prefeasfg]; ?>
                                            <td class="pdf-data"><?php echo (isset($grades[$preFirstId])) ? $grades[$preFirstId] : ''; ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td height="36" align="center" class="pdf-text">222</td>
                            <td align="center">
                                <table cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                                    <?php for ($prefeassq = 1; $prefeassq <= $totalPreFeasiSecond; $prefeassq++) { ?>
                                        <tr>
                                            <td class="pdf-data"><?php echo $geologyPart3[$z]['data']['pre_feasibility_second_min_qty_' . $prefeassq]; ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                            <td align="center" colspan="2">
                                <table cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                                    <?php for ($prefeassg = 1; $prefeassg <= $totalPreFeasiSecond; $prefeassg++) { ?>
                                        <tr>
                                            <?php $preSecondId = $geologyPart3[$z]['data']['pre_feasibility_second_min_grade_' . $prefeassg]; ?>
                                            <td class="pdf-data"><?php echo (isset($grades[$preSecondId])) ? $grades[$preSecondId] : ''; ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                        </tr>
                        <!-- Prefeasibility -->

                        <!-- Measured Mineral -->
                        <tr>
                            <td align="left" class="pdf-text">3. Measured Mineral Resource</td>
                            <td align="center" class="pdf-text">331</td>
                            <td align="center">
                                <table cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                                    <?php for ($measuredq = 1; $measuredq <= $totalMeasured; $measuredq++) { ?>
                                        <tr>
                                            <td class="pdf-data"><?php echo $geologyPart3[$z]['data']['measured_min_qty_' . $measuredq]; ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                            <td align="center" colspan="2">
                                <table cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                                    <?php for ($measuredg = 1; $measuredg <= $totalMeasured; $measuredg++) { ?>
                                        <tr>
                                            <?php $measuredId = $geologyPart3[$z]['data']['measured_min_grade_' . $measuredg]; ?>
                                            <td class="pdf-data"><?php echo (isset($grades[$measuredId])) ? $grades[$measuredId] : ''; ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                        </tr>
                        <!-- Measured Mineral -->

                        <!-- Indicated Mineral -->
                        <tr>
                            <td align="left" class="pdf-text">4. Indicated Mineral Resource</td>
                            <td align="center" class="pdf-text">332</td>
                            <td align="center">
                                <table cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                                    <?php for ($indq = 1; $indq <= $totalIndicated; $indq++) { ?>
                                        <tr>
                                            <td class="pdf-data"><?php echo $geologyPart3[$z]['data']['indicated_min_qty_' . $indq]; ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                            <td align="center" colspan="2">
                                <table cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                                    <?php for ($indg = 1; $indg <= $totalIndicated; $indg++) { ?>
                                        <tr>
                                            <?php $indId = $geologyPart3[$z]['data']['indicated_min_grade_' . $indg]; ?>
                                            <td class="pdf-data"><?php echo (isset($grades[$indId])) ? $grades[$indId] : ''; ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                        </tr>
                        <!-- Indicated Mineral -->

                        <!-- Inferred Mineral -->
                        <tr>
                            <td align="left" class="pdf-text">5. Inferred Mineral Resource</td>
                            <td align="center" class="pdf-text">333</td>
                            <td align="center">
                                <table cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                                    <?php for ($infq = 1; $infq <= $totalRecon; $infq++) { ?>
                                        <tr>
                                            <td class="pdf-data"><?php echo $geologyPart3[$z]['data']['inferred_min_qty_' . $infq]; ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                            <td align="center" colspan="2">
                                <table cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                                    <?php for ($infg = 1; $infg <= $totalRecon; $infg++) { ?>
                                        <tr>
                                            <?php $infGradeId = $geologyPart3[$z]['data']['inferred_min_grade_' . $infg]; ?>
                                            <td class="pdf-data"><?php echo (isset($grades[$infGradeId])) ? $grades[$infGradeId] : ''; ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                        </tr>
                        <!-- Inferred Mineral -->

                        <!-- Recconnaissance Mineral -->
                        <tr>
                            <td align="left" class="pdf-text">6. Reconnaissance Mineral<br>
                                 Resource</td>
                            <td align="center" class="pdf-text">334</td>
                            <td align="center">
                                <table cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                                    <?php for ($recq = 1; $recq <= $totalRecon; $recq++) { ?>
                                        <tr>
                                            <td class="pdf-data"><?php echo $geologyPart3[$z]['data']['recon_min_qty_' . $recq]; ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                            <td align="center" colspan="2">
                                <table cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                                    <?php for ($recg = 1; $recg <= $totalRecon; $recg++) { ?>
                                        <tr>
                                            <?php $recId = $geologyPart3[$z]['data']['recon_min_grade_' . $recg]; ?>
                                            <td class="pdf-data"><?php echo (isset($grades[$recId])) ? $grades[$recId] : ''; ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                        </tr>
                        <!-- Recconnaissance Mineral -->
                    </tbody>
                </table>
                <?php
                $z++;
            }
            ?>
            </div>
            <!-- End of SEC - 3 -->
        
            <div class="page-break">
                <!--   Add the s after the operation. by ganesh satav dated: 13 feb 14 -->
                <div class="pdf-text-heading padd-bot"><b>4. Mining operations during the year</b></div>
                <!--============MINING OPERATION DURING THE YEAR=============-->
                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                    <tr>
                        <td colspan="5" align="left" valign="top"  >4.1 Exploration</td>
                    </tr>
                    <tr>
                        <td width="20%" align="center"  >Item</td>
                        <td width="20%" align="center"  >Grid in Meters</td>
                        <td width="40%" colspan="2" align="center"  >Meterage</td>
                        <td width="20%" align="center"  >Number</td>
                    </tr>
                    <!--=========EXPLORATION FIELDS============-->
                    <tr>
                        <td align="center" class="pdf-text">Drilling</td>
                        <td align="center">
                            <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                <?php for ($i = 1; $i <= $drillGeo2['drill_count']; $i++) { ?>
                                    <tr>
                                        <td class="pdf-data" align="center">
                                            <?php echo (isset($nmiGradesmeter[$drillGeo2['drill_grid_' . $i]])) ? $nmiGradesmeter[$drillGeo2['drill_grid_' . $i]] : ''; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </td>
                        <td colspan="2" align="center">
                            <table width="40%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                <?php for ($i = 1; $i <= $drillGeo2['drill_count']; $i++) { ?>
                                    <tr>
                                        <td class="pdf-data">
                                            <?php echo $drillGeo2['drill_meter_' . $i]; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </td>
                        <td align="center">
                            <table width="80%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                <?php for ($i = 1; $i <= $drillGeo2['drill_count']; $i++) { ?>
                                    <tr>
                                        <td class="pdf-data">
                                            <?php echo $drillGeo2['drill_number_' . $i]; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" class="pdf-text">Trenching</td>
                        <td align="center">
                            <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                <?php for ($i = 1; $i <= $trenchGeo2['trench_count']; $i++) { ?>                                     
                                    <tr>
                                        <td align="center" class="pdf-data">
                                            <?php echo (isset($nmiGradesmeter[$trenchGeo2['trench_grid_' . $i]])) ? $nmiGradesmeter[$trenchGeo2['trench_grid_' . $i]] : ''; ?>
                                        </td>
                                    </tr> <?php } ?> 
                            </table>
                        </td>
                        <td colspan="2" align="center"> 
                            <table width="40%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                <?php for ($i = 1; $i <= $trenchGeo2['trench_count']; $i++) { ?>
                                    <tr>
                                        <td  align="center" class="pdf-data">
                                            <?php echo $trenchGeo2['trench_meter_' . $i]; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </td>

                        <td align="center">
                            <table width="80%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                <?php for ($i = 1; $i <= $trenchGeo2['trench_count']; $i++) { ?>
                                    <tr>
                                        <td align="center" class="pdf-data">
                                            <?php echo $trenchGeo2['trench_number_' . $i]; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table> 
                        </td>
                    </tr>

                    <tr>
                        <td align="center" class="pdf-text">Pitting</td>
                        <td align="center">
                            <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                <?php for ($i = 1; $i <= $pitGeo2['pit_count']; $i++) { ?>
                                    <tr>
                                        <td class="pdf-data" align="center">
                                            <?php echo (isset($nmiGradesmeter[$pitGeo2['pit_grid_' . $i]])) ? $nmiGradesmeter[$pitGeo2['pit_grid_' . $i]] : ''; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </td>
                        <td colspan="2" align="center">
                            <table width="40%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                <?php for ($i = 1; $i <= $pitGeo2['pit_count']; $i++) { ?>
                                    <tr>
                                        <td class="pdf-data" align="center">
                                            <?php echo $pitGeo2['pit_meter_' . $i]; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </td>
                        <td align="center">
                            <table width="80%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                <?php for ($i = 1; $i <= $pitGeo2['pit_count']; $i++) { ?>
                                    <tr>
                                        <td class="pdf-data" align="center">
                                            <?php echo $pitGeo2['pit_number_' . $i]; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table> 
                        </td>
                    </tr>

                    <!--=====DETAILS OF BENCHES FIELDS=========-->
                    <tr>
                        <td colspan="5" align="left"  >4.2 Opencast</td>
                    </tr>
                    <tr>
                        <td colspan="5" align="left"  >(A) Details of Benches (Separately for mechanised and manual sections)</td>
                    </tr>
                    <tr>
                        <td colspan="2" align="left" valign="top"  > </td>
                        <td colspan="2" align="center"  >In ore</td>
                        <td colspan="1" align="center"  >In OB/Waste</td>
                    </tr>
                    <tr>
                        <td colspan="2" rowspan="1" align="left" class="pdf-text">(i) Number of Benches</td>
                        <td colspan="2">
                            <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                <?php for ($i = 1; $i <= $benchGeo2['bench_count']; $i++) { ?>
                                    <tr>
                                        <td colspan="1" align="center" width="60%" class="pdf-data">
                                            <?php echo $benchOptions[$benchGeo2['bench_no_ore_select_' . $i]]; ?>
                                        </td>
                                        <td colspan="1" align="center" width="40%" class="pdf-data">
                                            <?php echo $benchGeo2['bench_no_ore_input_' . $i]; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </td>
                        <td colspan="1">
                            <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                <?php for ($i = 1; $i <= $benchGeo2['bench_count']; $i++) { ?>
                                    <tr>
                                        <td colspan="1" align="center" class="pdf-data" width="80%"><?php echo $benchGeo2['bench_no_waste_input_' . $i]; ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" rowspan="1" align="left" class="pdf-text">(ii) Average height (meters)</td>
                        <td colspan="2">
                            <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                <?php for ($i = 1; $i <= $heightGeo2['height_count']; $i++) { ?>
                                    <tr>
                                        <td colspan="1" align="center" width="60%" class="pdf-data">
                                            <?php echo $benchOptions[$heightGeo2['avg_height_ore_select_' . $i]]; ?>
                                        </td>
                                        <td colspan="1" align="center" width="40%" class="pdf-data">
                                            <?php echo $heightGeo2['avg_height_ore_input_' . $i]; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </td>
                        <td colspan="1">
                            <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                <?php for ($i = 1; $i <= $heightGeo2['height_count']; $i++) { ?>
                                    <tr>
                                        <td colspan="1" align="center" class="pdf-data" width="80%"><?php echo $heightGeo2['avg_height_waste_input_' . $i]; ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" rowspan="1" align="left" class="pdf-text">(iii) Depth of the deepest working<br />from adjacent ground (Meters)</td>
                        <td colspan="2">
                            <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                <?php for ($i = 1; $i <= $depthGeo2['depth_count']; $i++) { ?>
                                    <tr>
                                        <td colspan="1" align="center" width="60%" class="pdf-data">
                                            <?php echo $benchOptions[$depthGeo2['deepest_working_ore_select_' . $i]]; ?>
                                        </td>
                                        <td colspan="1" align="center" width="40%" class="pdf-data">
                                            <?php echo $depthGeo2['deepest_working_ore_input_' . $i]; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </td>
                        <td colspan="1">
                            <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                <?php for ($i = 1; $i <= $depthGeo2['depth_count']; $i++) { ?>
                                    <tr>
                                        <td colspan="1" align="center" class="pdf-data" width="80%"><?php echo $depthGeo2['deepest_working_waste_input_' . $i]; ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3" align="left" class="pdf-text">(B) (i) Total ROM Ore production (tonnes)</td>
                        <!--==============TOTAL ROM==============-->
                        <td align="center" colspan="2" class="pdf-data"><?php echo $staticGeo2['TOTAL_ROM']; ?></td>
                    </tr>
                    <!--========TOTAL REJECTS WITH GRADE=======-->

                    <tr>
                        <td colspan="3" align="left" class="pdf-text">(C) Total quantity of Overburden/Waste removed during the year (tonnes)</td>
                        <!--========TOTAL QUANTITY OVERBURDEN====-->
                        <td align="center" colspan="2" class="pdf-data"><?php echo $staticGeo2['TOT_QTY_OVERBURDEN']; ?></td>
                    </tr>
                    <!--========OVERBURDEN TABLE===============-->
                    <tr>
                        <td colspan="2" align="center"  >Overburden/Waste</td>
                        <td colspan="2" align="center" valign="top"  >During the year</td>
                        <td colspan="1" align="center" valign="top"  >Cumulative</td>
                    </tr>
                    <tr>
                        <td colspan="2" align="left" class="pdf-text">(i) Quantity back filled</td>
                        <td colspan="2" align="center" class="pdf-data"><?php echo $staticGeo2['YEAR_BACK_FILLED']; ?></td>
                        <td colspan="1" align="center" class="pdf-data"><?php echo $staticGeo2['CUM_BACK_FILLED']; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="left" class="pdf-text">(ii) Quantity disposed of in<br /> external dumps</td>
                        <td colspan="2" align="center" class="pdf-data"><?php echo $staticGeo2['YEAR_DISPOSED_OFF']; ?></td>
                        <td colspan="1" align="center" class="pdf-data"><?php echo $staticGeo2['CUM_DISPOSED_OFF']; ?></td>
                    </tr>

                    <tr>
                        <td colspan="5" align="left"  >4.3 Underground</td>
                    </tr>
                    <!--================DRIVING================-->
                    <tr>
                        <td colspan="3" align="left" class="pdf-text">(a) Driving (metres) in ore</td>
                        <td colspan="2" align="center" class="pdf-data"><?php echo $staticGeo2['ORE_DRIVING']; ?></td>
                    </tr>

                    <!--============CROSS CUTTING==============-->
                    <tr>
                        <td colspan="3" align="left" class="pdf-text">(b) Cross Cutting/Footwall Drives (in barren)<br /> (Metres)</td>
                        <td colspan="2" align="center" class="pdf-data"><?php echo $staticGeo2['BARREN_DRIVES']; ?></td>
                    </tr>
                    <!--================WINZING================-->
                    <tr>
                        <td colspan="3" align="left" class="pdf-text">(c) Winzing (meters)</td>
                        <td colspan="2" align="center" class="pdf-data"><?php echo $staticGeo2['WINZING']; ?></td>
                    </tr>
                    <!--===============RAISING=================-->
                    <tr>
                        <td colspan="3" align="left" class="pdf-text">(d) Raising (meters)</td>
                        <td colspan="2" align="center" class="pdf-data"><?php echo $staticGeo2['RAISING']; ?></td>
                    </tr>
                    <!--============SHAFT SINKING==============-->
                    <tr>
                        <td colspan="3" align="left" class="pdf-text">(e) Shaft sinking (meters)</td>
                        <td colspan="2" align="center" class="pdf-data"><?php echo $staticGeo2['SHAFT_SINKING']; ?></td>
                    </tr>
                    <!--===========STOPE PREPARATION===========-->
                    <tr>
                        <td colspan="3" align="left" class="pdf-text">(f) Stope preparation (meters)</td>
                        <td colspan="2" align="center" class="pdf-data"><?php echo $staticGeo2['STOPE_PREP']; ?></td>
                    </tr>
                    <!--=======TONNAGE OF ORE BLOCKED==========-->
                    <tr>
                        <td colspan="3" align="left" class="pdf-text">(g) Tonnage of ore blocked for stopping (tonnes)</td>
                        <td colspan="2" align="center" class="pdf-data"><?php echo $staticGeo2['ORE_STOPING']; ?></td>
                    </tr>
                    <!--======QUANTITY OF WASTE REMOVED========-->
                    <tr>
                        <td colspan="3" align="left" class="pdf-text">(h) Quantity of waste removed (tonnes)</td>
                        <td colspan="2" align="center" class="pdf-data"><?php echo $staticGeo2['UG_WASTE']; ?></td>
                    </tr>
                    <!--=====QUANTITY OF MINERAL REJECTS=======-->
                    <!-- <tr><td colspan="2" align="left" class="pdf-text">(i) Quantity of mineral rejects generated with grade(tonnes)</td>
                        <td colspan="2" align="center" class="pdf-data"><?php // echo $staticGeo2['UG_MINERAL_REJECTS'];   ?></td>
                    </tr>-->
                    <!--==============TREES NUMBER=============-->
                    <tr>
                        <td colspan="3" align="left"  >4.4</td>
                        <td colspan="1" align="center"  >(a) Within lease area</td>
                        <td colspan="1" align="center"  >(b) Outside lease area</td>
                    </tr>
                    <!--==========OUTSIDE LEASE AREA===========-->
                    <tr>
                        <td colspan="3" align="left" class="pdf-text">(i) Number of trees planted during the year</td>
                        <td colspan="1" align="center" class="pdf-data"><?php echo $staticGeo2['TREES_INSIDE']; ?></td>
                        <td colspan="1" align="center" class="pdf-data"><?php echo $staticGeo2['TREES_OUTSIDE']; ?></td>
                    </tr>

                    <tr>
                        <td colspan="3" align="left" class="pdf-text">(ii) Survival rate in percentage</td>
                        <td colspan="1" align="center" class="pdf-data"><?php echo $staticGeo2['SURVIVAL_RATE']; ?></td>
                        <td colspan="1" align="center" class="pdf-data"><?php echo $staticGeo2['SPECIES']; ?></td>
                    </tr>
                </table>
            </div>
            
            <div class="page-break">
                <!-- Sec 4 - Mineral Rejects -->
                <?php
                foreach ($mineralProduced as $minProduced) {
                    $minProduced = str_replace(" ", "_", strtolower($minProduced));
                    ?>
                    <div>
                        <div class="pdf-text-heading padd-bot padd-top">Sec 4. Mineral Rejects for <?php echo ucwords(str_replace("_", " ", $minProduced)); ?></div>
                        <!--============MINING OPERATION DURING THE YEAR=============-->
                        <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                            <tr>
                                <td colspan="2" valign="top" align="left">
                                    4.2 Opencast 
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" valign="top" align="left">
                                    4.2(B) (ii) Mineral Rejects generated with grades   (tonnes) 
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" valign="top" class="pdf-text" align="left">
                                    a. Quantity
                                </td>
                                <td width="50%" align="center" class="pdf-data"> 
                                    <?php echo (isset($mineralRejects[$minProduced]['static']['OC_QUANTITY'])) ? $mineralRejects[$minProduced]['static']['OC_QUANTITY'] : ''; ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" valign="top" class="pdf-text" align="left">
                                    b. Grade
                                </td>
                                <td width="50%" align="center" class="pdf-data"> 
                                    <?php echo (isset($mineralRejects[$minProduced]['static']['OC_GRADE'])) ? $mineralRejects[$minProduced]['static']['OC_GRADE'] : ''; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="left"> 4.3 Underground  </td>
                            </tr>
                            <tr>
                                <td colspan="2" valign="top" align="left">
                                    4.3(i) Mineral Rejects generated with grades  (tonnes) 
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" valign="top" class="pdf-text" align="left">
                                    a. Quantity
                                </td>
                                <td width="50%" align="center" class="pdf-data"> 
                                    <?php echo (isset($mineralRejects[$minProduced]['static']['UG_QUANTITY'])) ? $mineralRejects[$minProduced]['static']['UG_QUANTITY'] : ''; ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" valign="top" class="pdf-text" align="left">
                                    b. Grade
                                </td>
                                <td width="50%" align="center" class="pdf-data"> 
                                    <?php echo (isset($mineralRejects[$minProduced]['static']['UG_GRADE'])) ? $mineralRejects[$minProduced]['static']['UG_GRADE'] : ''; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <?php
                }
                ?>

                <!-- End of the sec - 4 Mineral Rejects -->

                <div class="pdf-text-heading padd-bot" style="padding-top: 60">Sec 5/6/8/9</div>
                <table width="100%" border="1" cellpadding="4" cellspacing="0" style="border-collapse:collapse;">
                    <tr>
                        <td colspan="5" align="left" class="pdf-text"> 
                            5. Type and aggregate Horse Power of Machinery: Give the 
                            following information for the types of machinery in use 
                            such as hoist, fans, drills, loaders, excavators, dumpers, 
                            haulages, conveyors, pumps, etc. Details of any new 
                            machinery added during the year may be furnished with cost.
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="middle"  >
                            Type of<br/>machinery
                        </td>
                        <td align="center" valign="middle"  >
                            Capacity of<br/>each unit
                        </td>
                        <td align="center" valign="middle"  >
                            No.of<br/>units
                        </td>
                        <td align="center" valign="middle"  >
                            Electrical/<br/>Non-Electrical<br/>(specify)
                        </td>
                        <td align="center" valign="middle"  >
                            Used in opencast/<br/>underground<br/>(specify)
                        </td>
                    </tr>
                    <?php
                    $yearlyCount = count($machineFormData['aggregation']);
                    if ($yearlyCount > 0) {
                        //echo 'in'; exit;
                        $data = ($yearlyCount - 1) / 5;

                        if ($data == 0) {
                            $data = 1;
                        }
                        for ($i = 1; $i <= $data; $i++) {
                            if (isset($machineryName[$i])) {
                                ?>
                                <tr>
                                    <td align="center" class="pdf-data">
                                        <?php echo $machineryName[$i]['machinery_name']; ?>
                                    </td>
                                    <td align="center" class="pdf-data">
                                        <?php
                                        echo $machineFormData['aggregation']["capacity_box_" . $i] . " " . $machineFormData['aggregation']["unit_$i"];
                                        ?>
                                    </td>
                                    <td align="center" class="pdf-data">
                                        <?php
                                        echo $machineFormData['aggregation']["unit_box_" . $i];
                                        ?>
                                    </td>
                                    <td align="center" class="pdf-data">
                                        <?php
                                        $electricalSelect = $machineFormData['aggregation']["electrical_select_$i"];
                                        if ($electricalSelect == 1) {
                                            echo "Electrical";
                                        } else if ($electricalSelect == 2) {
                                            echo "Non Electrical";
                                        } else if ($electricalSelect == 3) {
                                            echo "Both";
                                        }
                                        ?>
                                    </td>
                                    <td align="center" class="pdf-data">
                                        <?php
                                        $openCastSelect = $machineFormData['aggregation']["opencast_select_$i"];
                                        if ($openCastSelect == 1) {
                                            echo "Opencast";
                                        } else if ($openCastSelect == 2) {
                                            echo "Underground";
                                        } else if ($openCastSelect == 3) {
                                            echo "Both";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    }
                    ?>
                </table>

                <div style="margin-top: 20px"></div>

                <table width="100%" border="1" cellpadding="4" cellspacing="0" style="border-collapse:collapse;" bordercolor="#E5D0BD" class="geo_colapse_table">
                    <tr>
                        <td width="50%" class="pdf-text" align="left">6.(i) Give details of future plans, if any, of 
                            exploration and development, production schedule, 
                            replacements and expansion of machinery and equipment etc.
                            <br/>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $machineFormData['static']['FUTURE_PLAN']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" class="pdf-text" align="left">
                            (ii) If you have laboratory facilities for R &amp; D then 
                            give a brief description:
                            <br/>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $machineFormData['static']['LAB_FACILITY']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" class="pdf-text" align="left">8. Furnish surface and/or underground plans 
                            and sections as prepared and brought up-to-date 
                            (as required under rule 28 of MCDR)
                        </td>
                        <td align="center" class="pdf-data">
                            <?php
                            echo $machineFormData['static']['FURNISH_SURFACE'];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" class="pdf-text" align="left">9. Please indicate the salient features which
                            affected mining operations during the year.
                        </td>
                        <td align="center" class="pdf-data">
                            <?php
                            echo $machineFormData['static']['SILENT_FEATURE'];
                            ?>
                        </td>
                    </tr>
                </table>
            </div>

        <?php } ?>

        <?php if ($returnType == 'ANNUAL') { ?>

            <div class="page-break">
                <?php foreach ($mineralProduced as $minProduced) { ?>
                    <?php $minProducedSmall = strtolower(str_replace(' ', '_', $minProduced)); ?>
                    <div style="margin-top: 20px" class="pdf-text-heading padd-bot">Sec 7 for  <?php echo ucwords(str_replace("_", " ", $minProduced)); ?></div>
                    <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                        <tr>
                            <td width="40%" class="pdf-text" align="left">
                                7.(i) Details of mineral Treatment Plant, if any. 
                                Give a brief description of the process capacity of the 
                                machinery deployed and its availability. 
                                (Enclose Flow Sheet and Material Balance of the Plant)
                            </td>
                            <td align="center" width="60%" colspan="2" class="pdf-data">
                                <?php
                                echo $sec7FormData[$minProducedSmall]['static']['MIN_TREATMENT_PLANT'];
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="3" align="left" valign="middle"  >
                                (ii) Furnish following information every year:
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="middle"  >Item</td>
                            <td align="center" valign="middle"  >Tonnage</td>
                            <td align="center" valign="middle"  >Average Grade</td>
                        </tr>

                        <tr>
                            <td align="left" valign="top" class="pdf-text">Feed</td>
                            <td align="center" class="pdf-data">
                                <?php
                                echo $sec7FormData[$minProducedSmall]['static']['FEED_TONNAGE'];
                                ?>
                            </td>
                            <td align="center" class="pdf-data">
                                <?php
                                echo $sec7FormData[$minProducedSmall]['static']['FEED_AVG_GRADE'];
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td align="left" valign="top" class="pdf-text">Concentrates</td>
                            <td align="center" class="pdf-data">
                                <?php echo $sec7FormData[$minProducedSmall]['static']['CONCEN_TONNAGE']; ?>
                            </td>
                            <td align="center">
                                <?php echo $sec7FormData[$minProducedSmall]['static']['CONCEN_AVG_GRADE']; ?>
                            </td>
                        </tr>

                        <tr>
                            <td align="left" valign="top" class="pdf-text">By-products/Co-products</td>
                            <td align="center" class="pdf-data">
                                <?php echo $sec7FormData[$minProducedSmall]['static']['BY_PRO_TONNAGE']; ?>
                            </td>
                            <td align="center" class="pdf-data">
                                <?php echo $sec7FormData[$minProducedSmall]['static']['BY_PRO_AVG_GRADE']; ?>
                            </td>
                        </tr>

                        <tr>
                            <td align="left" valign="top" class="pdf-text">Tailings</td>
                            <td align="center" class="pdf-data">
                                <?php echo $sec7FormData[$minProducedSmall]['static']['TAIL_TONNAGE']; ?>
                            </td>
                            <td align="center" class="pdf-data">
                                <?php echo $sec7FormData[$minProducedSmall]['static']['TAIL_AVG_GRADE']; ?>
                            </td>
                        </tr>

                    </table>
                <?php } ?>
            </div>

        <?php } ?>
        
        <div class="page-break" style="margin-top:20px;margin-left:40px;width:90%">
            <?php if ($returnType == "ANNUAL") { ?>
            <div style="margin-top:40px;margin-left: 60px;color:#000000" class="welcome-signout"><strong>Part - VI(PRODUCTION, DISPATCHES & STOCKS )</strong></div>
            <?php } else { ?>
            <div style="margin-top:40px;margin-left: 60px;color:#000000" class="welcome-signout"><strong>Part - II(PRODUCTION, DISPATCHES & STOCKS )</strong></div>
            <?php } ?>
            <!-- GLOBAL LOOP FOR PART - II -->

            <?php 
            if (count($formData) > 0) {
                for ($i = 0; $i < count($formData); $i++) {
                    if (isset($formData[$i]['formType'])) {
                        if ($formData[$i]['formType'] == 5) {
                            $min_name = strtoupper(str_replace('_', ' ', $formData[$i]['mineral']));

                            $romF5 = $formData[$i]['romF5']['table_data'];
                            $romF5UndTotQty = $formData[$i]['romF5']['und_tot_qty'];
                            $romF5CastTotQty = $formData[$i]['romF5']['cast_tot_qty'];
                            $romF5Reason = $formData[$i]['romF5']['reason'];
                            $romF5UndDisplayTable = $formData[$i]['romF5']['display_table']['und_stock'];
                            $romF5TotalDisplayTable = $formData[$i]['romF5']['display_table']['total_stock'];
                            ?>

                            <!--ROM F5-->
                            <?php if ($returnType == "ANNUAL") { ?>
                            <div class="page-break" style="margin-left: 60px;margin-right: 20px;width:100%">
                            <?php } else { ?>
                            <div class="page-break" style="width:90%">
                            <?php } ?>

                                <div class="welcome-signout" style="margin-top:40px;width:90%;text-align: left;">
                                    <?php echo $FormLabelNameWithFormNo['8']; ?> ( <?php echo $min_name; ?> )
                                </div>

                                <?php if ($returnType == "ANNUAL") { ?>
                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;margin-top: 10px">
                                <?php } else { ?>
                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;margin-top: 10px" align="center">
                                <?php } ?>
                                    <tr>
                                        <td width="16%" valign="top" class="form-table-title" rowspan="2"></td>
                                        <td width="28%" align="center" class="form-table-title" colspan="2">Opening Stock</td>
                                        <td width="28%" align="center" class="form-table-title" colspan="2">Production (in tonne)</td>
                                        <td width="28%" align="center" class="form-table-title" colspan="2">Closing Stock (in tonne) </td>
                                    </tr>
                                    <tr>
                                        <td align="center" class="form-table-title">Quantity</td>
                                        <td align="center" class="form-table-title">Metal content/grade</td>
                                        <td align="center" class="form-table-title">Quantity</td>
                                        <td align="center" class="form-table-title">Metal content/grade</td>
                                        <td align="center" class="form-table-title">Quantity</td>
                                        <td align="center" class="form-table-title">Metal content/grade</td>
                                    </tr>

                                    <tr>
                                        <td align="left" class="lable-text">A(i).From Development (Underground Working)</td>
                                        <td align="center"><?php echo $romF5['open_dev']['tot_qty'] ?></td>
                                        <td align="center">
                                            <table class="f5-sub-table-print">
                                                <?php
                                                $open_dev_tbl = "";
                                                foreach ($romF5['open_dev']['table'] as $od) {
                                                    $open_dev_tbl .= "<tr>";
                                                    $open_dev_tbl .= "<td>" . $od['metal'] . "</td>";
                                                    $open_dev_tbl .= "<td>" . $od['grade'] . "</td>";
                                                    $open_dev_tbl .= "</tr>";
                                                }
                                                echo $open_dev_tbl;
                                                ?>
                                            </table>
                                        </td>
                                        <td align="center"><?php echo $romF5['prod_dev']['tot_qty'] ?></td>
                                        <td align="center">
                                            <table class="f5-sub-table-print">
                                                <?php
                                                $prod_dev_tbl = "";
                                                foreach ($romF5['prod_dev']['table'] as $pd) {
                                                    $prod_dev_tbl .= "<tr>";
                                                    $prod_dev_tbl .= "<td>" . $pd['metal'] . "</td>";
                                                    $prod_dev_tbl .= "<td>" . $pd['grade'] . "</td>";
                                                    $prod_dev_tbl .= "</tr>";
                                                }
                                                echo $prod_dev_tbl;
                                                ?>
                                            </table>
                                        </td>
                                        <td align="center"><?php echo $romF5['close_dev']['tot_qty'] ?></td>
                                        <td align="center">
                                            <table class="f5-sub-table-print">
                                                <?php
                                                $close_dev_tbl = "";
                                                foreach ($romF5['close_dev']['table'] as $cd) {
                                                    $close_dev_tbl .= "<tr>";
                                                    $close_dev_tbl .= "<td>" . $cd['metal'] . "</td>";
                                                    $close_dev_tbl .= "<td>" . $cd['grade'] . "</td>";
                                                    $close_dev_tbl .= "</tr>";
                                                }
                                                echo $close_dev_tbl;
                                                ?>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="left" class="lable-text" style="color:#000">(ii).From Stopping <br/>(Underground Working)</td>
                                        <td align="center"><?php echo $romF5['open_stop']['tot_qty'] ?></td>
                                        <td align="center">
                                            <table class="f5-sub-table-print">
                                                <?php
                                                $open_stop_tbl = "";
                                                foreach ($romF5['open_stop']['table'] as $os) {
                                                    $open_stop_tbl .= "<tr>";
                                                    $open_stop_tbl .= "<td>" . $os['metal'] . "</td>";
                                                    $open_stop_tbl .= "<td>" . $os['grade'] . "</td>";
                                                    $open_stop_tbl .= "</tr>";
                                                }
                                                echo $open_stop_tbl;
                                                ?>
                                            </table>
                                        </td>
                                        <td align="center"><?php echo $romF5['prod_stop']['tot_qty'] ?></td>
                                        <td align="center">
                                            <table class="f5-sub-table-print">
                                                <?php
                                                $prod_stop_tbl = "";
                                                foreach ($romF5['prod_stop']['table'] as $ps) {
                                                    $prod_stop_tbl .= "<tr>";
                                                    $prod_stop_tbl .= "<td>" . $ps['metal'] . "</td>";
                                                    $prod_stop_tbl .= "<td>" . $ps['grade'] . "</td>";
                                                    $prod_stop_tbl .= "</tr>";
                                                }
                                                echo $prod_stop_tbl;
                                                ?>
                                            </table>
                                        </td>
                                        <td align="center"><?php echo $romF5['close_stop']['tot_qty'] ?></td>
                                        <td align="center">
                                            <table class="f5-sub-table-print">
                                                <?php
                                                $close_stop_tbl = "";
                                                foreach ($romF5['close_stop']['table'] as $cs) {
                                                    $close_stop_tbl .= "<tr>";
                                                    $close_stop_tbl .= "<td>" . $cs['metal'] . "</td>";
                                                    $close_stop_tbl .= "<td>" . $cs['grade'] . "</td>";
                                                    $close_stop_tbl .= "</tr>";
                                                }
                                                echo $close_stop_tbl;
                                                ?>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr class="und_total_row">
                                        <td align="left" class="lable-text" style="color:#000">A.From Underground Working (Total)</td>
                                        <td align="center" id="open_und_qty_total"><?php echo $romF5UndTotQty['open_und_total']; ?></td>
                                        <td align="center">
                                            <table width="100%" id="open_und_metal_total" class="und_total_table">
                                                <?php
                                                $open_und_tbl = "";
                                                foreach ($romF5UndDisplayTable['open'] as $mineral => $open_und) {
                                                    $open_und_tbl .= "<tr>";
                                                    $open_und_tbl .= "<td>" . $mineral . "</td>";
                                                    $open_und_tbl .= "<td>" . $open_und . "</td>";
                                                    $open_und_tbl .= "</tr>";
                                                }
                                                echo $open_und_tbl;
                                                ?>
                                            </table>
                                        </td>
                                        <td align="center" id="prod_und_qty_total"><?php echo $romF5UndTotQty['prod_und_total']; ?></td>
                                        <td align="center">
                                            <table width="100%" id="prod_und_metal_total" class="und_total_table">
                                                <?php
                                                $prod_und_tbl = "";
                                                foreach ($romF5UndDisplayTable['prod'] as $mineral => $prod_und) {
                                                    $prod_und_tbl .= "<tr>";
                                                    $prod_und_tbl .= "<td>" . $mineral . "</td>";
                                                    $prod_und_tbl .= "<td>" . $prod_und . "</td>";
                                                    $prod_und_tbl .= "</tr>";
                                                }
                                                echo $prod_und_tbl;
                                                ?>
                                            </table>
                                        </td>
                                        <td align="center" id="close_und_qty_total"><?php echo $romF5UndTotQty['close_und_total']; ?></td>
                                        <td align="center">
                                            <table width="100%" id="close_und_metal_total" class="und_total_table">
                                                <?php
                                                $close_und_tbl = "";
                                                foreach ($romF5UndDisplayTable['close'] as $mineral => $close_und) {
                                                    $close_und_tbl .= "<tr>";
                                                    $close_und_tbl .= "<td>" . $mineral . "</td>";
                                                    $close_und_tbl .= "<td>" . $close_und . "</td>";
                                                    $close_und_tbl .= "</tr>";
                                                }
                                                echo $close_und_tbl;
                                                ?>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="left" class="lable-text" style="color:#000">B.From Opencast workings</td>
                                        <td align="center"><?php echo $romF5['open_cast']['tot_qty'] ?></td>
                                        <td align="center">
                                            <table class="f5-sub-table-print">
                                                <?php
                                                $open_cast_tbl = "";
                                                foreach ($romF5['open_cast']['table'] as $oc) {
                                                    $open_cast_tbl .= "<tr>";
                                                    $open_cast_tbl .= "<td>" . $oc['metal'] . "</td>";
                                                    $open_cast_tbl .= "<td>" . $oc['grade'] . "</td>";
                                                    $open_cast_tbl .= "</tr>";
                                                }
                                                echo $open_cast_tbl;
                                                ?>
                                            </table>
                                        </td>
                                        <td align="center"><?php echo $romF5['prod_cast']['tot_qty'] ?></td>
                                        <td align="center">
                                            <table class="f5-sub-table-print">
                                                <?php
                                                $prod_cast_tbl = "";
                                                foreach ($romF5['prod_cast']['table'] as $pc) {
                                                    $prod_cast_tbl .= "<tr>";
                                                    $prod_cast_tbl .= "<td>" . $pc['metal'] . "</td>";
                                                    $prod_cast_tbl .= "<td>" . $pc['grade'] . "</td>";
                                                    $prod_cast_tbl .= "</tr>";
                                                }
                                                echo $prod_cast_tbl;
                                                ?>
                                            </table>
                                        </td>
                                        <td align="center"><?php echo $romF5['close_cast']['tot_qty'] ?></td>
                                        <td align="center">
                                            <table class="f5-sub-table-print">
                                                <?php
                                                $close_cast_tbl = "";
                                                foreach ($romF5['close_cast']['table'] as $cc) {
                                                    $close_cast_tbl .= "<tr>";
                                                    $close_cast_tbl .= "<td>" . $cc['metal'] . "</td>";
                                                    $close_cast_tbl .= "<td>" . $cc['grade'] . "</td>";
                                                    $close_cast_tbl .= "</tr>";
                                                }
                                                echo $close_cast_tbl;
                                                ?>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr class="f5-total-row">
                                        <td align="left" class="lable-text" style="color:#000;">Total</td>
                                        <td align="center" class="pdf-data"><?php echo $romF5CastTotQty['open']; ?></td>
                                        <td align="center">
                                            <table id="open_total_table" class="f5-rom-total-table">
                                                <?php
                                                $open_total_tbl = "";
                                                foreach ($romF5TotalDisplayTable['open'] as $mineral => $open_total) {
                                                    $open_total_tbl .= "<tr>";
                                                    $open_total_tbl .= "<td>" . $mineral . "</td>";
                                                    $open_total_tbl .= "<td>" . $open_total . "</td>";
                                                    $open_total_tbl .= "</tr>";
                                                }
                                                echo $open_total_tbl;
                                                ?>
                                            </table>
                                        </td>
                                        <td align="center" class="pdf-data"><?php echo $romF5CastTotQty['prod']; ?></td>
                                        <td align="center">
                                            <table id="prod_total_table" class="f5-rom-total-table">
                                                <?php
                                                $prod_total_tbl = "";
                                                foreach ($romF5TotalDisplayTable['prod'] as $mineral => $prod_total) {
                                                    $prod_total_tbl .= "<tr>";
                                                    $prod_total_tbl .= "<td>" . $mineral . "</td>";
                                                    $prod_total_tbl .= "<td>" . $prod_total . "</td>";
                                                    $prod_total_tbl .= "</tr>";
                                                }
                                                echo $prod_total_tbl;
                                                ?>
                                            </table>
                                        </td>
                                        <td align="center" class="pdf-data"><?php echo $romF5CastTotQty['close']; ?></td>
                                        <td align="center">
                                            <table id="close_total_table" class="f5-rom-total-table">
                                                <?php
                                                $close_total_tbl = "";
                                                foreach ($romF5TotalDisplayTable['close'] as $mineral => $close_total) {
                                                    $close_total_tbl .= "<tr>";
                                                    $close_total_tbl .= "<td>" . $mineral . "</td>";
                                                    $close_total_tbl .= "<td>" . $close_total . "</td>";
                                                    $close_total_tbl .= "</tr>";
                                                }
                                                echo $close_total_tbl;
                                                ?>
                                            </table>
                                        </td>
                                    </tr>
                                </table><br/><br/>

                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;margin-top: 10px">
                                    <tr>
                                        <!--   Remove the S form reason word. added by ganesh satav dated: 13 feb 14-->
                                        <td class="form-table-title" colspan="10" align="left">
                                            8. Give reasons for increase/decrease in production compared to the previous <?php if($returnType == 'ANNUAL'){ ?> year <?php }else { ?> month<?php } ?> or nil production, if any, during the <?php if($returnType == 'ANNUAL'){ ?> year <?php }else { ?> month<?php } ?>.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" colspan="10"><?php echo $romF5Reason; ?></td>
                                    </tr>
                                </table>
                            </div>
                            
                            <!--EX MINE-->
                            <?php
                            $exmineF5Pmv = $formData[$i]['exmineF5']['pmv'];
                            $exmineF5Reason = $formData[$i]['exmineF5']['reason'];
                            ?>
                            <?php if ($returnType == "ANNUAL") { ?>
                            <div class="page-break" style="margin-left: 60px;margin-right: 20px;width:100%">
                            <?php } else { ?>
                            <div class="page-break" style="width:90%">
                            <?php } ?>
                                <div class="welcome-signout pdf-text-lg" style="margin-top:40px; font-size:12px;width:90%;text-align: left;">
                                    <strong><?php echo $FormLabelNameWithFormNo['9']; ?> ( <?php echo $min_name; ?> )</strong>
                                </div>
                                <?php if ($returnType == "ANNUAL") { ?>
                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;margin-top: 10px">
                                <?php } else { ?>
                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;margin-top: 10px" align="center">
                                <?php } ?>
                                    <tr>
                                        <td width="50%" align="left" valign="top" class="lable-text">Ex-mine price of the ore produced (in &#8377;/Unit)</td>
                                        <td width="50%" align="left"><?php echo $exmineF5Pmv; ?></td>
                                    </tr>
                                    <tr>
                                        <!-- Remove the S form reason word. added by ganesh satav dated: 13 feb 14-->
                                        <td class="form-table-title" align="left" colspan="2">9. Give reasons for increase/decrease in grade wise ex-mine price ,if any, during the <?php if($returnType == 'ANNUAL'){ ?> year <?php }else { ?> month<?php } ?> compared to the previous <?php if($returnType == 'ANNUAL'){ ?> year <?php }else { ?> month<?php } ?>.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" colspan="2"><?php echo $exmineF5Reason; ?></td>
                                    </tr>
                                </table>
                            </div>
                            
                            <!--CON RECO-->
                            <?php
                            $conF5RomData = $formData[$i]['conRecoF5']['rom'];
                            $conF5ConData = $formData[$i]['conRecoF5']['con'];
                            ?>
                            <?php if ($returnType == "ANNUAL") { ?>
                            <div class="page-break" style="margin-left: 60px;margin-right: 20px;width:100%">
                            <?php } else { ?>
                            <div class="page-break" style="width:90%">
                            <?php } ?>
                                <div class="welcome-signout" style="margin-top:40px; font-size:12px;text-align: left;">
                                    <strong class="pdf-text-lg"><?php echo $FormLabelNameWithFormNo['10']; ?> (Quantity in tonnes & Value in &#8377;) ( <?php echo $min_name; ?> )</strong>
                                </div>
                                <?php if ($returnType == "ANNUAL") { ?>
                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;margin-top: 10px">
                                <?php } else { ?>
                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;margin-top: 10px" align="center">
                                <?php } ?>
                                    <tr>
                                        <td align="center" valign="top" class="form-table-title" colspan="2">Opening stocks of the Ore at concentrator/Plant</td>
                                        <td align="center" class="form-table-title" colspan="2">Ore received from the mine</td>
                                        <td align="center" class="form-table-title" colspan="2">Ore treated</td>
                                    </tr>
                                    <tr>
                                        <td align="center" class="form-table-title">Quantity</td>
                                        <td align="center" class="form-table-title">Metal content/grade</td>
                                        <td align="center" class="form-table-title">Quantity</td>
                                        <td align="center" class="form-table-title">Metal content/grade</td>
                                        <td align="center" class="form-table-title">Quantity</td>
                                        <td align="center" class="form-table-title">Metal content/grade</td>
                                    </tr>

                                    <!-- SECTION 1 : OPENING STOCKS OF THE ORE AT CONCENTRATOR/PLANT -->
                                    <tr>
                                        <td align="center"><?php echo $conF5RomData['open_ore']['tot_qty']; ?></td>
                                        <td align="center">
                                            <table class="f5-sub-table-print">
                                                <?php
                                                $open_ore_tbl = "";
                                                foreach ($conF5RomData['open_ore']['table'] as $o) {
                                                    $open_ore_tbl .= "<tr>";
                                                    $open_ore_tbl .= "<td>" . $o['metal'] . "</td>";
                                                    $open_ore_tbl .= "<td>" . $o['grade'] . "</td>";
                                                    $open_ore_tbl .= "</tr>";
                                                }
                                                echo $open_ore_tbl;
                                                ?>
                                            </table>
                                        </td>

                                        <!-- SECTION 2 : ORE RECEIVED FROM THE MINE -->
                                        <td align="center"><?php echo $conF5RomData['rec_ore']['tot_qty']; ?></td>
                                        <td align="center">
                                            <table class="f5-sub-table-print">
                                                <?php
                                                $rec_ore_tbl = "";
                                                foreach ($conF5RomData['rec_ore']['table'] as $ro) {
                                                    $rec_ore_tbl .= "<tr>";
                                                    $rec_ore_tbl .= "<td>" . $ro['metal'] . "</td>";
                                                    $rec_ore_tbl .= "<td>" . $ro['grade'] . "</td>";
                                                    $rec_ore_tbl .= "</tr>";
                                                }
                                                echo $rec_ore_tbl;
                                                ?>
                                            </table>
                                        </td>

                                        <!-- SECTION 3 : ORE TREATED  -->                     
                                        <td align="center"><?php echo $conF5RomData['treat_ore']['tot_qty']; ?></td>
                                        <td align="center">
                                            <table class="f5-sub-table-print">
                                                <?php
                                                $treat_ore_tbl = "";
                                                foreach ($conF5RomData['treat_ore']['table'] as $to) {
                                                    $treat_ore_tbl .= "<tr>";
                                                    $treat_ore_tbl .= "<td>" . $to['metal'] . "</td>";
                                                    $treat_ore_tbl .= "<td>" . $to['grade'] . "</td>";
                                                    $treat_ore_tbl .= "</tr>";
                                                }
                                                echo $treat_ore_tbl;
                                                ?>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" colspan="10"> * In case of any leaching method adopted, give quantity recovered and grade contained separately.</td>
                                    </tr>
                                </table><br><br>
                                
                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                    <tr>
                                        <td align="center" valign="top" class="form-table-title" colspan="3">Concentrates * Obtained</td>
                                        <td align="center" class="form-table-title" colspan="2">Tailings</td>
                                        <td align="center" class="form-table-title" colspan="2">Closing stocks of concentrates at the concentrator/Plant </td>
                                    </tr>
                                    <tr>
                                        <td align="center" class="form-table-title" colspan="1">Quantity (in tonne)</td>
                                        <td align="center" class="form-table-title">Value in &#8377;</td>
                                        <td align="center" class="form-table-title">Metal content/grade</td>
                                        <td align="center" class="form-table-title">Quantity (in tonne)</td>
                                        <td align="center" class="form-table-title" colspan="1">Metal content/grade</td>
                                        <td align="center" class="form-table-title" colspan="1">Quantity (in tonne)</td>
                                        <td align="center" class="form-table-title" colspan="1">Metal content/grade</td>
                                    </tr>

                                    <!-- SECTION 4 : CONCENTRATES * OBTAINED  -->                     
                                    <tr>
                                        <td align="center">
                                            <table class="f5-sub-table-print">
                                                <?php
                                                $con_obt_tbl = "";
                                                foreach ($conF5ConData['con_obt'] as $co) {
                                                    $con_obt_tbl .= "<tr>";
                                                    $con_obt_tbl .= "<td>" . $co['metal'] . "</td>";
                                                    $con_obt_tbl .= "<td>" . $co['tot_qty'] . "</td>";
                                                    $con_obt_tbl .= "</tr>";
                                                }
                                                echo $con_obt_tbl;
                                                ?>
                                            </table>
                                        </td>
                                        <td align="center">
                                            <table>
                                                <?php
                                                $con_obt_value_tbl = "";
                                                foreach ($conF5ConData['con_obt'] as $cv) {
                                                    $con_obt_value_tbl .= "<tr>";
                                                    $con_obt_value_tbl .= "<td>" . $cv['con_value'] . "</td>";
                                                    $con_obt_value_tbl .= "</tr>";
                                                }
                                                echo $con_obt_value_tbl;
                                                ?>
                                            </table>
                                        </td>
                                        <td align="center">
                                            <table>
                                                <?php
                                                $con_obt_grade_tbl = "";
                                                foreach ($conF5ConData['con_obt'] as $cg) {
                                                    $con_obt_grade_tbl .= "<tr>";
                                                    $con_obt_grade_tbl .= "<td>" . $cg['grade'] . "</td>";
                                                    $con_obt_grade_tbl .= "</tr>";
                                                }
                                                echo $con_obt_grade_tbl;
                                                ?>
                                            </table>
                                        </td>

                                        <!-- SECTION 5 : TAILINGS  -->                   
                                        <td align="center"><?php echo $conF5RomData['tail_ore']['tot_qty']; ?></td>
                                        <td align="center">
                                            <table class="f5-sub-table-print">
                                                <?php
                                                $tail_ore_tbl = "";
                                                foreach ($conF5RomData['tail_ore']['table'] as $to) {
                                                    $tail_ore_tbl .= "<tr>";
                                                    $tail_ore_tbl .= "<td>" . $to['metal'] . "</td>";
                                                    $tail_ore_tbl .= "<td>" . $to['grade'] . "</td>";
                                                    $tail_ore_tbl .= "</tr>";
                                                }
                                                echo $tail_ore_tbl;
                                                ?>
                                            </table>
                                        </td>

                                        <!-- SECTION 6 : CLOSING STOCKS OF CONCENTRATES THE CONCENTRATOR/PLANT  -->
                                        <td align="center">
                                            <table class="f5-sub-table-print">
                                                <?php
                                                $close_con_tbl = "";
                                                foreach ($conF5ConData['close_con'] as $cc) {
                                                    $close_con_tbl .= "<tr>";
                                                    $close_con_tbl .= "<td>" . $cc['metal'] . "</td>";
                                                    $close_con_tbl .= "<td>" . $cc['tot_qty'] . "</td>";
                                                    $close_con_tbl .= "</tr>";
                                                }
                                                echo $close_con_tbl;
                                                ?>
                                            </table>
                                        </td>
                                        <td align="center">
                                            <table>
                                                <?php
                                                $close_con_grade_tbl = "";
                                                foreach ($conF5ConData['close_con'] as $cg) {
                                                    $close_con_grade_tbl .= "<tr>";
                                                    $close_con_grade_tbl .= "<td>" . $cg['grade'] . "</td>";
                                                    $close_con_grade_tbl .= "</tr>";
                                                }
                                                echo $close_con_grade_tbl;
                                                ?>
                                            </table>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                            
                            <!--SMELTER-->
                            <?php
                            $smelterF5Recovery = $formData[$i]['smelterF5']['recovery'];
                            $smelterF5ConMetal = $formData[$i]['smelterF5']['con_metal'];
                            $smelterF5ByProduct = $formData[$i]['smelterF5']['by_product'];
                            ?>
                            <?php if ($returnType == "ANNUAL") { ?>
                            <div class="page-break" style="margin-left: 60px;margin-right: 20px;width:100%">
                            <?php } else { ?>
                            <div class="page-break" style="width:90%">
                            <?php } ?>
                                <div class="welcome-signout" style="margin-top:40px; font-size:12px;width:90%;text-align: left;">
                                    <strong class="pdf-text-lg"><?php echo $FormLabelNameWithFormNo['11']; ?> ( <?php echo $min_name; ?> )</strong>
                                </div>
                                <?php if ($returnType == "ANNUAL") { ?>
                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;margin-top: 10px">
                                <?php } else { ?>
                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;margin-top: 10px" align="center">
                                <?php } ?>
                                    <tr>
                                        <td align="center" valign="top" class="form-table-title pdf-text-xs" colspan="2">Opening Stocks of the concentrates at the smelter /Plant</td>
                                        <td align="center" class="form-table-title pdf-text-xs" colspan="2">Concentrates received from concentrator/Plant</td>
                                        <td align="center" class="form-table-title pdf-text-xs" colspan="3">Concentrates received from other sources (specify)</td>
                                        <td align="center" class="form-table-title pdf-text-xs" colspan="2">Concentrates sold (if any)</td>
                                        <td align="center" class="form-table-title pdf-text-xs" colspan="2">Concentrates treated </td>
                                        <td align="center" class="form-table-title pdf-text-xs" colspan="2">Closing stocks of concentrate at the Smelter/Plant</td>
                                    </tr>
                                    <tr>
                                        <td align="center" class="form-table-title pdf-text-xs">Quantity (in tonne)</td>
                                        <td align="center" class="form-table-title pdf-text-xs">Metal content/grade</td>
                                        <td align="center" class="form-table-title pdf-text-xs">Quantity (in tonne)</td>
                                        <td align="center" class="form-table-title pdf-text-xs">Metal content/grade</td>
                                        <td align="center" class="form-table-title pdf-text-xs">Source</td>
                                        <td align="center" class="form-table-title pdf-text-xs">Quantity (in tonne)</td>
                                        <td align="center" class="form-table-title pdf-text-xs">Metal content/grade</td>
                                        <td align="center" class="form-table-title pdf-text-xs">Quantity (in tonne)</td>
                                        <td align="center" class="form-table-title pdf-text-xs">Metal content/grade</td>
                                        <td align="center" class="form-table-title pdf-text-xs">Quantity (in tonne)</td>
                                        <td align="center" class="form-table-title pdf-text-xs">Metal content/grade</td>
                                        <td align="center" class="form-table-title pdf-text-xs">Quantity (in tonne)</td>
                                        <td align="center" class="form-table-title pdf-text-xs">Metal content/grade</td>
                                    </tr>
                                    <?php
                                    $smel_rec_tbl = "";
                                    foreach ($smelterF5Recovery as $rec) {
                                        $smel_rec_tbl .= '<tr style="text-align:center;">';
                                        $smel_rec_tbl .= '<td class="pdf-text-xs">';
                                        $smel_rec_tbl .= '<table class="f5-sub-table-print">';
                                        $smel_rec_tbl .= '<tr>';
                                        $smel_rec_tbl .= '<td class="pdf-text-xs">' . $rec["open_metal"] . '</td>';
                                        $smel_rec_tbl .= '<td class="pdf-text-xs">' . $rec["open_qty"] . '</td>';
                                        $smel_rec_tbl .= '</tr>';
                                        $smel_rec_tbl .= '</table>';
                                        $smel_rec_tbl .= '</td>';
                                        $smel_rec_tbl .= '<td class="pdf-text-xs">' . $rec["open_grade"] . '</td>';
                                        $smel_rec_tbl .= '<td class="pdf-text-xs">' . $rec["con_rc_qty"] . '</td>';
                                        $smel_rec_tbl .= '<td class="pdf-text-xs">' . $rec["con_rc_grade"] . '</td>';
                                        $smel_rec_tbl .= '<td class="pdf-text-xs"> ' . $rec["con_rs_source"] . '</td>';
                                        $smel_rec_tbl .= '<td class="pdf-text-xs">' . $rec["con_rs_qty"] . '</td>';
                                        $smel_rec_tbl .= '<td class="pdf-text-xs">' . $rec["con_rs_grade"] . '</td>';                                                
                                        $smel_rec_tbl .= '<td class="pdf-text-xs">' . $rec["con_so_qty"] . '</td>';
                                        $smel_rec_tbl .= '<td class="pdf-text-xs">' . $rec["con_so_grade"] . '</td>';
                                        $smel_rec_tbl .= '<td class="pdf-text-xs">' . $rec["con_tr_qty"] . '</td>';
                                        $smel_rec_tbl .= '<td class="pdf-text-xs">' . $rec["con_tr_grade"] . '</td>';
                                        $smel_rec_tbl .= '<td class="pdf-text-xs">' . $rec["close_qty"] . '</td>';
                                        $smel_rec_tbl .= '<td class="pdf-text-xs">' . $rec["close_value"] . '</td>';
                                        $smel_rec_tbl .= '</tr>';
                                    }
                                    echo $smel_rec_tbl;
                                    ?>
                                </table><br><br>

                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;margin-top: 10px" align="center">
                                    <tr>
                                        <td align="center" valign="top" class="form-table-title pdf-text-xs" colspan="3">Metals(*) recovered(specify)</td>
                                        <td align="center" class="form-table-title pdf-text-xs" colspan="3">Other by-products ,if any, recovered</td>
                                    </tr>
                                    <tr>
                                        <td align="center" class="form-table-title pdf-text-xs">Quantity</td>
                                        <td align="center" class="form-table-title pdf-text-xs">Value<br >(in &#8377;)</td>
                                        <td align="center" class="form-table-title pdf-text-xs">Grade</td>
                                        <td align="center" class="form-table-title pdf-text-xs">Quantity (in tonne)</td>
                                        <td align="center" class="form-table-title pdf-text-xs">Value<br >(in &#8377;)</td>
                                        <td align="center" class="form-table-title pdf-text-xs">Grade</td>
                                    </tr>
                                    <tr>
                                        <!--METAL RECOVERED TABLE-->
                                        <td align="center">
                                            <table class="f5-sub-table-print">
                                                <?php
                                                $con_metal_tbl = "";
                                                foreach ($smelterF5ConMetal as $cm) {
                                                    $con_metal_tbl .= '<tr>';
                                                    $con_metal_tbl .= '<td class="pdf-text-xs">' . $cm["rc_metal"] . '</td>';
                                                    $con_metal_tbl .= '<td class="pdf-text-xs">' . $cm["rc_qty"] . '</td>';
                                                    $con_metal_tbl .= '</tr>';
                                                }
                                                echo $con_metal_tbl;
                                                ?>
                                            </table>
                                        </td>

                                        <td align="center">
                                            <table>
                                                <?php
                                                $con_metal_value_tbl = "";
                                                foreach ($smelterF5ConMetal as $cv) {
                                                    $con_metal_value_tbl .= '<tr>';
                                                    $con_metal_value_tbl .= '<td class="pdf-text-xs">' . $cv["rc_value"] . '</td>';
                                                    $con_metal_value_tbl .= '</tr>';
                                                }
                                                echo $con_metal_value_tbl;
                                                ?>
                                            </table>
                                        </td>

                                        <td align="center">
                                            <table>
                                                <?php
                                                $con_metal_grade_tbl = "";
                                                foreach ($smelterF5ConMetal as $cg) {
                                                    $con_metal_grade_tbl .= '<tr>';
                                                    $con_metal_grade_tbl .= '<td class="pdf-text-xs">' . $cg["rc_grade"] . '</td>';
                                                    $con_metal_grade_tbl .= '</tr>';
                                                }
                                                echo $con_metal_grade_tbl;
                                                ?>
                                            </table>
                                        </td>

                                        <!--BY PRODUCT TABLE-->
                                        <td align="center">
                                            <table class="f5-sub-table-print">
                                                <?php
                                                $by_product_tbl = "";
                                                foreach ($smelterF5ByProduct as $bp) {
                                                    $by_product_tbl .= '<tr>';
                                                    $by_product_tbl .= '<td class="pdf-text-xs">' . $bp["bp_metal"] . '</td>';
                                                    $by_product_tbl .= '<td class="pdf-text-xs">' . $bp["bp_qty"] . '</td>';
                                                    $by_product_tbl .= '</tr>';
                                                }
                                                echo $by_product_tbl;
                                                ?>
                                            </table>
                                        </td>

                                        <td align="center">
                                            <table>
                                                <?php
                                                $by_product_value_tbl = "";
                                                foreach ($smelterF5ByProduct as $bv) {
                                                    $by_product_value_tbl .= '<tr>';
                                                    $by_product_value_tbl .= '<td class="pdf-text-xs">' . $bv["bp_value"] . '</td>';
                                                    $by_product_value_tbl .= '</tr>';
                                                }
                                                echo $by_product_value_tbl;
                                                ?>
                                            </table>
                                        </td>

                                        <td align="center">
                                            <table>
                                                <?php
                                                $by_product_grade_tbl = "";
                                                foreach ($smelterF5ByProduct as $bg) {
                                                    $by_product_grade_tbl .= '<tr>';
                                                    $by_product_grade_tbl .= '<td class="pdf-text-xs">' . $bg["bp_grade"] . '</td>';
                                                    $by_product_grade_tbl .= '</tr>';
                                                }
                                                echo $by_product_grade_tbl;
                                                ?>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <span class="pdf-text-xs" align="left"><b>Note:</b> (*) Please give category-wise break-up viz. blister, fire refined copper, cathodes, electrolytic copper wire bars, lead ingots, zinc cathodes, zinc dross, gold, tungsten etc.</span>
                            </div>
                            
                            <!--SALES-->
                            <?php
                            $salesF5 = $formData[$i]['salesMetals'];
                            ?>
                            <?php if ($returnType == "ANNUAL") { ?>
                            <div class="page-break" style="margin-left: 60px;margin-right: 20px;width:100%">
                            <?php } else { ?>
                            <div class="page-break" style="width:90%">
                            <?php } ?>
                                <div class="welcome-signout" style="margin-top:40px; font-size:12px;width:90%;text-align: left;">
                                    <strong class="pdf-text-lg"><?php echo $FormLabelNameWithFormNo['12']; ?> ( <?php echo $min_name; ?> )</strong>
                                </div>
                                <?php if ($returnType == "ANNUAL") { ?>
                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;margin-top: 10px">
                                <?php } else { ?>
                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;margin-top: 10px" align="center">
                                <?php } ?>
                                    <tr>
                                        <td align="center" width="35%" valign="top" class="form-table-title pdf-text-xs" colspan="3">Opening stocks of metals/ Products</td>
                                        <td align="center" width="10%"class="form-table-title pdf-text-xs" rowspan="2">Place of Sale</td>
                                        <td align="center" width="35%" class="form-table-title pdf-text-xs" colspan="3">Metals/Products sold<span style="color:#FF0000"> (@)</span></td>
                                        <td align="center" width="20%" class="form-table-title pdf-text-xs" colspan="2">Closing stocks of metals/ Products</td>
                                    </tr>
                                    <tr>
                                        <td align="center" class="form-table-title pdf-text-xs">Metal/Product</td>
                                        <td align="center" class="form-table-title pdf-text-xs">Quantity</td>
                                        <td align="center" class="form-table-title pdf-text-xs">Grade</td>
                                        <td align="center" class="form-table-title pdf-text-xs">Quantity</td>
                                        <td align="center" class="form-table-title pdf-text-xs">Grade</td>
                                        <td align="center" class="form-table-title pdf-text-xs">Value <span style="color:#0000FF"> # </span>(in &#8377;)</td>
                                        <td align="center" class="form-table-title pdf-text-xs">Quantity</td>
                                        <td align="center" class="form-table-title pdf-text-xs">Grade</td>
                                    </tr>
                                    <?php
                                    $sales_tbl = "";
                                    foreach ($salesF5 as $rec) {
                                        $sales_tbl .= '<tr style="text-align:center;">';

                                        $sales_tbl .= '<td class="pdf-text-xs">' . $rec["open_metal"] . '</td>';
                                        $sales_tbl .= '<td class="pdf-text-xs">' . $rec["open_tot_qty"] . '</td>';

                                        $sales_tbl .= '<td class="pdf-text-xs">' . $rec["open_grade"] . '</td>';
                                        $sales_tbl .= '<td class="pdf-text-xs">' . ucwords(strtolower($rec["sale_place"])) . '</td>';
                                        $sales_tbl .= '<td class="pdf-text-xs">' . $rec["prod_tot_qty"] . '</td>';
                                        $sales_tbl .= '<td class="pdf-text-xs">' . $rec["prod_grade"] . '</td>';
                                        $sales_tbl .= '<td class="pdf-text-xs">' . $rec["prod_value"] . '</td>';
                                        $sales_tbl .= '<td class="pdf-text-xs">' . $rec["close_tot_qty"] . '</td>';
                                        $sales_tbl .= '<td class="pdf-text-xs">' . $rec["close_product_value"] . '</td>';
                                        $sales_tbl .= '</tr>';
                                    }
                                    echo $sales_tbl;
                                    ?>
                                    <tr>
                                        <td align="center" valign="top" colspan="9">
                                            <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                                <tr>
                                                    <td align="center" width="15%" class="pdf-text-xs"><b>Note:</b></td>
                                                    <td align="left" width="85%" style="color:#0000FF;font-size:10px"><b>(#) Please give ex-plant sale value including excise duty but excluding other taxes.</b></td>
                                                </tr>
                                                <tr>
                                                    <td><b></b></td>
                                                    <td align="left" style="color:#FF0000;font-size:10px "><b>(@) Please give category-wise break-up of metals and other products sold.</b></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        <?php } elseif ($formData[$i]['formType'] == 6) { ?>

                            <!-- FORM F-6 PRODUCTION, DISPATCHES AND STOCKS -->
                            <div class="welcome-signout"><b>1. Production, Dispatches and Socks of crude and dressed MICA. ( in kilograms )</b></div>
                            <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;margin-top: 10px">
                                <tr>
                                    <td width="35%" align="center" valign="middle"  >Category</td>
                                    <td width="15%" align="center"  >Crude (r.o.m.)</td>
                                    <td width="25%" align="center"  >Waste/scrap mica obtained incidental  to mining</td>
                                    <td width="25%" align="center"  >Waste/scrap mica obtained after preliminary dressing (at mine site)</td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="4" class="pdf-text"><b>A. OPENING STOCKS (at the Beginning of the month)</b></td>
                                </tr>
                                <tr>
                                    <td align="left" class="pdf-text" valign="middle">(i) at Mine</td>
                                    <td align="center" valign="middle"  class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['crude']['open_mine']; ?> 
                                    </td>
                                    <td align="center" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['incidental']['open_mine']; ?>  </td>
                                    <td align="center" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['waste']['open_mine']; ?>  </td>
                                </tr>
                                <tr>
                                    <td align="left" class="pdf-text"> (ii)  at Dressing unit </td>
                                    <td align="center" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['crude']['open_dress']; ?>  </td>
                                    <td align="center" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['incidental']['open_dress']; ?> </td>
                                    <td align="center" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['waste']['open_dress']; ?> </td>
                                </tr>
                                <tr>
                                    <td align="left" class="pdf-text" >(iii) at any Other point (Please specify)<?php echo $formData[$i]['prodistocksF6']['crude']['open_other_spec']; ?> </td>
                                    <td align="center" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['crude']['open_other']; ?> </td>
                                    <td align="center" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['incidental']['open_other']; ?> </td>
                                    <td align="center" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['waste']['open_other']; ?> </td>
                                </tr>
                                <tr>
                                    <td align="left" class="pdf-text"><b>Total (Opening Stock)</b></td>
                                    <td align="center" valign="middle" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['crude']['total_open']; ?> </td>
                                    <td align="center" valign="middle" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['incidental']['total_open']; ?> </td>
                                    <td align="center" valign="middle" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['waste']['total_open']; ?> </td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="4" class="pdf-text"><b>B. PRODUCTION</b></td>
                                </tr>
                                <tr>
                                    <td align="left" class="pdf-text"> (i) From underground mining </td>
                                    <td align="center"  class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['crude']['prod_ug']; ?> </td>
                                    <td align="center"  class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['incidental']['prod_ug']; ?> </td>
                                    <td align="center"  class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['waste']['prod_ug']; ?> </td>
                                </tr>
                                <tr>
                                    <td align="left" class="pdf-text"> (ii) From opencast mining    </td>
                                    <td align="center" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['crude']['prod_oc']; ?> </td>
                                    <td align="center" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['incidental']['prod_oc']; ?> </td>
                                    <td align="center"  class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['waste']['prod_oc']; ?> </td>
                                </tr>
                                <tr>
                                    <td align="left" class="pdf-text"> (iii) From dump working   </td>
                                    <td align="center"  class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['crude']['prod_dw']; ?> </td>
                                    <td align="center" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['incidental']['prod_dw']; ?> </td>
                                    <td align="center" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['waste']['prod_dw']; ?> </td>
                                </tr>
                                <tr>
                                    <td align="left" class="pdf-text"><b>Total (Production)</b></td>
                                    <td align="center"   class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['crude']['total_prod']; ?> </td>
                                    <td align="center"  class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['incidental']['total_prod']; ?> </td>
                                    <td align="center"  class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['waste']['total_prod']; ?> </td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="4"><b>C. DESPATCHES</b></td>
                                </tr>
                                <tr>
                                    <td align="left" class="pdf-text"> (i)  for dressing  </td>
                                    <td align="center"  class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['crude']['desp_dress']; ?> </td>
                                    <td align="center"  class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['incidental']['desp_dress']; ?> </td>
                                    <td align="center"  class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['waste']['desp_dress']; ?> </td>
                                </tr>
                                <tr>
                                    <td align="left" class="pdf-text"> (ii)  for Sale     </td>
                                    <td align="center" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['crude']['desp_sale']; ?> </td>
                                    <td align="center"  class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['incidental']['desp_sale']; ?> </td>
                                    <td align="center" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['waste']['desp_sale']; ?> </td>
                                </tr>
                                <tr>
                                    <td align="left" class="pdf-text"><b>Total (Despatches)</b></td>
                                    <td align="center" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['crude']['total_desp']; ?> </td>
                                    <td align="center" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['incidental']['total_desp']; ?> </td>
                                    <td align="center" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['waste']['total_desp']; ?> </td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="4" class="pdf-text"><b>D. CLOSING STOCKS</b></td>
                                </tr>
                                <tr>
                                    <td align="left" class="pdf-text"> (i)  At mine   </td>
                                    <td align="center"  class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['crude']['clos_mine']; ?> </td>
                                    <td align="center"  class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['incidental']['clos_mine']; ?> </td>
                                    <td align="center"  class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['waste']['clos_mine']; ?> </td>
                                </tr>
                                <tr>
                                    <td align="left" class="pdf-text"> (ii) At dressing unit      </td>
                                    <td align="center" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['crude']['clos_dress']; ?> </td>
                                    <td align="center"  class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['incidental']['clos_dress']; ?> </td>
                                    <td align="center"  class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['waste']['clos_dress']; ?> </td>
                                </tr>
                                <tr>
                                    <td align="left" class="pdf-text">(iii) at any Other point (Please specify)<?php echo $formData[$i]['prodistocksF6']['crude']['clos_other_spec']; ?> </td>
                                    <td align="center"  class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['crude']['clos_other']; ?> </td>
                                    <td align="center" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['incidental']['clos_other']; ?> </td>
                                    <td align="center" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['waste']['clos_other']; ?> </td>
                                </tr>
                                <tr>
                                    <td align="left"><b>Total (Closing Stocks)</b></td>
                                    <td align="center" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['crude']['total_clos']; ?> </td>
                                    <td align="center" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['incidental']['total_clos']; ?> </td>
                                    <td align="center" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['waste']['total_clos']; ?> </td>  
                                </tr>
                                <tr>
                                    <td align="left"><b>E. Ex-mine price(&#8377; per kg)</b></td>
                                    <td align="center" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['crude']['pmv']; ?> </td>
                                    <td align="center" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['incidental']['pmv']; ?> </td>
                                    <td align="center" class="pdf-data"><?php echo $formData[$i]['prodistocksF6']['waste']['pmv'] ?> </td>
                                </tr>
                            </table>
                            
                        <!-- FORM F-7 ROM AND PRODUCTION, DISPATCHES AND STOCKS-->
                        <?php } else if ($formData[$i]['formType'] == 7) { ?>
                        
                            <!-- FORM F-7 ROM -->
                            <?php if ($returnType == 'ANNUAL') { ?>
                            <div class="page-break" style="margin-left: 40px;width:90%">
                            <?php } else { ?>
                            <div class="page-break" style="width:90%">
                            <?php } ?>
                                <div class="welcome-signout f_b" style="margin-top:40px;margin-left:20px;width:88%;text-align: left;">  
                                    <?php print_r($FormLabelNameWithFormNo['2']); ?>  ( <?php echo strtoupper(str_replace('_', ' ', $formData[$i]['mineral'])); ?> )
                                </div>
                                <?php if ($returnType == 'ANNUAL') { ?>
                                <table width="100%" border="0" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; margin-top:10px;">
                                <?php } else { ?>
                                <table width="90%" border="0" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; margin-top:10px;" align="center">
                                <?php } ?>
                                    <tr>
                                        <td align="left" valign="top">
                                            <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;margin-left:20px">
                                                <tr>
                                                    <td width="35%" align="left" valign="top" class="form-table-title">Category</td>
                                                    <td align="center" class="form-table-title">Quantity</td>
                                                </tr>
                                                <tr class="f_s_9">
                                                    <td align="left" valign="top" class="lable-text">(a) Open Cast Workings </td>
                                                    <td align="center"><?php echo $formData[$i]['romStone']['oc_qty'] . " " . ucfirst(strtolower($minUnit)); ?></td>
                                                </tr>
                                                <tr class="f_s_9">
                                                    <td align="left" valign="top" class="lable-text">(b) Underground Workings </td>
                                                    <td align="center"><?php echo $formData[$i]['romStone']['ug_qty'] . " " . ucfirst(strtolower($minUnit)); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            
                            <!-- FORM F-7 PRODUCTION, DISPATCHES AND STOCKS-->
                            <div class="page-break" style="margin-left: 40px;width:90%">
                                <div class="welcome-signout f_b" style="margin-top:40px;margin-left:20px;width:100%;text-align: left;">
                                    <?php print_r($FormLabelNameWithFormNo['3']); ?> ( <?php echo strtoupper(str_replace('_', ' ', $formData[$i]['mineral'])); ?> )
                                </div>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;margin-left:20px">
                                    <tr>
                                        <td align="center" valign="top">
                                            <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;" class="f_s_9">
                                                <tr class="f_s_10">
                                                    <td align="left" width="20%" valign="top" class="form-table-title" rowspan="3"></td>
                                                    <td align="center" width="40%"class="form-table-title" colspan="4">Gem variety</td>
                                                    <td align="center" width="20%" class="form-table-title" colspan="2" rowspan="2">Industrial</td>
                                                    <td align="center" width="20%" class="form-table-title" colspan="2" rowspan="2">Other</td>
                                                </tr>
                                                <tr class="f_s_10">
                                                    <td align="center" class="form-table-title" colspan="2">Rough and uncut stones</td>
                                                    <td align="center" class="form-table-title" colspan="2">Cut and Polished Stones</td>
                                                </tr>
                                                <tr class="f_s_10">
                                                    <td align="center" width="9%" class="form-table-title">No. of stones</td>
                                                    <td align="center" width="11%" class="form-table-title">Qty @</td>
                                                    <td align="center" width="9%" class="form-table-title">No. of stones</td>
                                                    <td align="center" width="11%" class="form-table-title">Qty @</td>
                                                    <td align="center" width="9%" class="form-table-title">No. of stones</td>
                                                    <td align="center" width="11%" class="form-table-title">Qty @</td>
                                                    <td align="center" width="9%" class="form-table-title">No. of stones</td>
                                                    <td align="center" width="11%" class="form-table-title">Qty @</td>
                                                </tr>
                                                <tr>
                                                    <td align="left" class="lable-text" style="color:#000">A. Opening Stock</td>
                                                    <td align="center" width="9%"><?php echo $formData[$i]['prodistocksF7']['rough']['open_tot_no']; ?></td>
                                                    <td align="center" width="11%"><?php echo $formData[$i]['prodistocksF7']['rough']['open_tot_qty'] . " " . ucfirst(strtolower($minUnit)); ?></td>
                                                    <td align="center" width="9%"><?php echo $formData[$i]['prodistocksF7']['polished']['open_tot_no']; ?></td>
                                                    <td align="center" width="11%"><?php echo $formData[$i]['prodistocksF7']['polished']['open_tot_qty'] . " " . ucfirst(strtolower($minUnit)); ?></td>
                                                    <td align="center" width="9%"><?php echo $formData[$i]['prodistocksF7']['industrialized']['open_tot_no']; ?></td>
                                                    <td align="center" width="11%"><?php echo $formData[$i]['prodistocksF7']['industrialized']['open_tot_qty'] . " " . ucfirst(strtolower($minUnit)); ?></td>
                                                    <td align="center" width="9%"><?php echo $formData[$i]['prodistocksF7']['other']['open_tot_no']; ?></td>
                                                    <td align="center" width="11%"><?php echo $formData[$i]['prodistocksF7']['other']['open_tot_qty'] . " " . ucfirst(strtolower($minUnit)); ?></td>
                                                </tr>
                                                <tr>
                                                    <td align="left" class="lable-text" colspan="9" style="color:#000">B. Production</td>
                                                </tr>
                                                <tr>
                                                    <td align="left" class="lable-text" style="color:#636363">(i)  From Opencast Working</td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['rough']['prod_oc_no']; ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['rough']['prod_oc_qty'] . " " . ucfirst(strtolower($minUnit)); ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['polished']['prod_oc_no']; ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['polished']['prod_oc_qty'] . " " . ucfirst(strtolower($minUnit)); ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['industrialized']['prod_oc_no']; ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['industrialized']['prod_oc_qty'] . " " . ucfirst(strtolower($minUnit)); ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['other']['prod_oc_no']; ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['other']['prod_oc_qty'] . " " . ucfirst(strtolower($minUnit)); ?></td>
                                                </tr>
                                                <tr>
                                                    <td align="left" class="lable-text" style="color:#636363">(ii)  From Underground Working</td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['rough']['prod_ug_no']; ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['rough']['prod_ug_qty'] . " " . ucfirst(strtolower($minUnit)); ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['polished']['prod_ug_no']; ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['polished']['prod_ug_qty'] . " " . ucfirst(strtolower($minUnit)); ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['industrialized']['prod_ug_no']; ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['industrialized']['prod_ug_qty'] . " " . ucfirst(strtolower($minUnit)); ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['other']['prod_ug_no']; ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['other']['prod_ug_qty'] . " " . ucfirst(strtolower($minUnit)); ?></td>
                                                </tr>
                                                <tr>
                                                    <td align="left" class="lable-text" style="color:#000;">Total production</td>
                                                    <td align="center" class="lable-text" style="color:#000; font-weight: normal"><?php echo $formData[$i]['prodistocksF7']['rough']['prod_tot_no']; ?></td>
                                                    <td align="center" class="lable-text" style="color:#000; font-weight: normal"><?php echo $formData[$i]['prodistocksF7']['rough']['prod_tot_qty'] . " " . ucfirst(strtolower($minUnit)); ?></td>
                                                    <td align="center" class="lable-text" style="color:#000; font-weight: normal"><?php echo $formData[$i]['prodistocksF7']['polished']['prod_tot_no']; ?></td>
                                                    <td align="center" class="lable-text" style="color:#000; font-weight: normal"><?php echo $formData[$i]['prodistocksF7']['polished']['prod_tot_qty'] . " " . ucfirst(strtolower($minUnit)); ?></td>
                                                    <td align="center" class="lable-text" style="color:#000; font-weight: normal"><?php echo $formData[$i]['prodistocksF7']['industrialized']['prod_tot_no']; ?></td>
                                                    <td align="center" class="lable-text" style="color:#000; font-weight: normal"><?php echo $formData[$i]['prodistocksF7']['industrialized']['prod_tot_qty'] . " " . ucfirst(strtolower($minUnit)); ?></td>
                                                    <td align="center" class="lable-text" style="color:#000; font-weight: normal"><?php echo $formData[$i]['prodistocksF7']['other']['prod_tot_no']; ?></td>
                                                    <td align="center" class="lable-text" style="color:#000; font-weight: normal"><?php echo $formData[$i]['prodistocksF7']['other']['prod_tot_qty'] . " " . ucfirst(strtolower($minUnit)); ?></td>
                                                </tr>
                                                <tr>
                                                    <td align="left" class="lable-text" style="color:#000">C. Despatches</td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['rough']['desp_tot_no']; ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['rough']['desp_tot_qty'] . " " . ucfirst(strtolower($minUnit)); ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['polished']['desp_tot_no']; ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['polished']['desp_tot_qty'] . " " . ucfirst(strtolower($minUnit)); ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['industrialized']['desp_tot_no']; ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['industrialized']['desp_tot_qty'] . " " . ucfirst(strtolower($minUnit)); ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['other']['desp_tot_no']; ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['other']['desp_tot_qty'] . " " . ucfirst(strtolower($minUnit)); ?></td>
                                                </tr>
                                                <tr>
                                                    <td align="left" class="lable-text" style="color:#000">D. Closing Stock</td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['rough']['clos_tot_no']; ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['rough']['clos_tot_qty'] . " " . ucfirst(strtolower($minUnit)); ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['polished']['clos_tot_no']; ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['polished']['clos_tot_qty'] . " " . ucfirst(strtolower($minUnit)); ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['industrialized']['clos_tot_no']; ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['industrialized']['clos_tot_qty'] . " " . ucfirst(strtolower($minUnit)); ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['other']['clos_tot_no']; ?></td>
                                                    <td align="center"><?php echo $formData[$i]['prodistocksF7']['other']['clos_tot_qty'] . " " . ucfirst(strtolower($minUnit)); ?></td>
                                                </tr>
                                                <tr>
                                                    <td align="left" class="lable-text" style="color:#000">E. Ex-mine Price* (in &#8377;)</td>
                                                    <td align="center" colspan="2"><?php echo $formData[$i]['prodistocksF7']['rough']['pmv_oc']; ?></td>
                                                    <td align="center" colspan="2"><?php echo $formData[$i]['prodistocksF7']['polished']['pmv_oc']; ?></td>
                                                    <td align="center" colspan="2"><?php echo $formData[$i]['prodistocksF7']['industrialized']['pmv_oc']; ?></td>
                                                    <td align="center" colspan="2"><?php echo $formData[$i]['prodistocksF7']['other']['pmv_oc']; ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">*This should be estimated for all the stones produced during the month whether sold or not on the basis of average sale price obtained for sales made during the month. In case no sales are made Ex-pit-head, the ex-mine price should be arrived at after deducting the actual expenses incurred from the pit-head to the point of sale, from the sale price realised.</td>
                                    </tr>
                                </table>
                                <table>
                                    <tr><td></td></tr>
                                </table>
                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;margin-left:20px">
                                    <tr>
                                        <td class="form-table-title" align="left"><?php
                                            // below comment code by ganesh satav because of sove the mcdr no issues.
                                            // if ($formData[$i]['mineral'] == "corundum") {
                                        
                                            //     } else {
                                            //    echo"7";
                                            //}
                                            echo "5";   ?>
                                            <!-- Remove the S form reason word. added by ganesh satav dated: 13 feb 14-->
                                            .Give reasons for increase/decrease in production compared to the previous<?php if($returnType == 'ANNUAL'){ ?> year<?php }else { ?> month<?php } ?> or nil production, if any, during the <?php if($returnType == 'ANNUAL'){ ?> year <?php }else { ?> month<?php } ?>.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left"><?php echo $formData[$i]['prodistocksF7']['rough']['REASON_ONE']; ?></td>
                                    </tr>
                                </table>   
                                <table>
                                    <tr><td></td></tr>
                                </table>
                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;margin-left:20px">
                                    <tr>
                                        <td class="form-table-title" align="left"><?php
                                            //    if ($formData[$i]['mineral'] == "corundum") {
                                                
                                                
                                                    // below comment code by ganesh satav because of sove the mcdr no issues.
                                                //  }
                                                //   } else {
                                                //       echo"8";
                                            //     }
                                                        echo "6";
                                            ?> <!-- Remove the S form reason word. added by ganesh satav dated: 13 feb 14-->
                                            .Give reasons for increase/decrease in grade wise ex-mine price ,if any, during the <?php if($returnType == 'ANNUAL'){ ?> year <?php }else { ?> month<?php } ?> compared to the previous <?php if($returnType == 'ANNUAL'){ ?> year <?php }else { ?> month<?php } ?>.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" style=""><?php echo $formData[$i]['prodistocksF7']['rough']['REASON_TWO']; ?></td>
                                    </tr>
                                </table>   
                            </div>
                            
                        <?php } else { ?>

                            <!-- FORM F-1 TO F-4 AND FORM F-8 -->
                            <?php if ($formData[$i]['mineral'] == "iron_ore" || $formData[$i]['mineral'] == "IRON ORE") { ?>
                                <!-- PRINT TYPE OF ORE -->
                                <div class="page-break" style="margin-left: 40px;width:90%">
                                    <table width="100%" border="0"  style="background:url(<?php echo $projectPath . "/img/print/" . $img_name; ?>); border:0px solid #E5D0BD;" cellspacing="0" cellpadding="0" style="margin-left:0px;margin-top:20px" align="center">
                                        <tr><td height="5"></td></tr>
                                        <tr><td></td></tr>
                                        <tr>
                                            <td align="left" class="welcome-page-name">
                                                <div id="ore_type">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr><td align="center" style="font-size:10px"><strong><?php echo $FormLabelNameWithFormNo['1']; ?></strong></td></tr>
                                                        <tr><td></td></tr>
                                                        <tr><td align="center" class="lable-text">Type of ore produced: <span align="left" class="lable-text" style="color:#CC0000"><?php if($oreType=='Hematite'){echo "(a) ".$oreType; }else{ echo "(b) ".$oreType; } ?></span></td></tr>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                            <?php } ?>
                            
                            <!-- FORM F-1 TYPE ROM-->
                            <?php if ($returnType == "ANNUAL") { ?>
                            <div class="page-break">
                            <?php } else { ?>
                            <div class="page-break" width="90%">
                            <?php } ?>
                                <div align="center" style="font-size:10px"><strong>
                                    <?php 
                                    // below code comment because we set the label in the common fime and print. added by ganesh satav dated 14 and 17 feb 2014
                                    // if (($formData[$i]['mineral'] == "manganese_ore") || ( $formData[$i]['mineral'] == "bauxite") || ( $formData[$i]['mineral'] == "chromite") || ( $formData[$i]['mineral'] == "mica") || ( $formData[$i]['mineral'] == "copper_ore") || ($formData[$i]['mineral'] == "kyanite") || ($formData[$i]['mineral'] == "pyrophyllite") || ($formData[$i]['mineral'] == "sillimanite") || ($formData[$i]['mineral'] == "tourmaline")) {
                                    //             echo '1';
                                    //     } else if ($formData[$i]['mineral'] == "iron_ore") {
                                    //         echo '2';
                                    // }
                                    //             ?>
                                    <?php print_r($FormLabelNameWithFormNo['2']); ?> ( <?php
                                    $ore = strtoupper(str_replace('_', ' ', $formData[$i]['mineral']));
                                    if (isset($formData[$i]['sub_min']) && $formData[$i]['sub_min']){
                                        $ore .= " (" . ucwords($formData[$i]['sub_min']) . ")";
                                    }

                                    echo $ore;
                                    ?> )
                                </strong></div>
                                <?php if ($returnType == "ANNUAL") { ?>
                                <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; margin-left: 20px;margin-top:10px;">
                                <?php } else { ?>
                                <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; margin-top:10px;" align="center">
                                <?php } ?>
                                    <tr>
                                        <td width="26%" align="center" valign="top" class="form-table-title">Category </td>
                                        <td align="center" class="form-table-title">Opening stock<br />(in tonne)</td>
                                        <td align="center" class="form-table-title">Production<br />(in tonne)</td>
                                        <td align="center" class="form-table-title">Closing stock <br />(in tonne)</td>
                                    </tr>
                                    <tr style="font-size:10px;">
                                        <td align="left" valign="top" class="lable-text">(a) Open Cast Workings </td>
                                        <td align="center"><?php echo (isset($formData[$i]['rom_prod']['OPEN_OC_ROM'])) ? $formData[$i]['rom_prod']['OPEN_OC_ROM'] : ''; ?></td>
                                        <td align="center"><?php echo (isset($formData[$i]['rom_prod']['PROD_OC_ROM'])) ? $formData[$i]['rom_prod']['PROD_OC_ROM'] : ''; ?></td>
                                        <td align="center"><?php echo (isset($formData[$i]['rom_prod']['CLOS_OC_ROM'])) ? $formData[$i]['rom_prod']['CLOS_OC_ROM'] : ''; ?></td>
                                    </tr> 
                                    <?php if ($formData[$i]['mineral'] != 'iron_ore') { ?>
                                        <tr style="font-size:10px;">
                                            <td align="left" valign="top" class="lable-text"><?php
                                                if(in_array($formData[$i]['formType'], array('7','1','3','4','2','8')))  {
                                                    echo '(b)';
                                                }
                                                ?> Underground Workings</td>
                                            <td align="center"><?php echo (isset($formData[$i]['rom_prod']['OPEN_UG_ROM'])) ? $formData[$i]['rom_prod']['OPEN_UG_ROM'] : ''; ?></td>
                                            <td align="center"><?php echo (isset($formData[$i]['rom_prod']['PROD_UG_ROM'])) ? $formData[$i]['rom_prod']['PROD_UG_ROM'] : ''; ?></td>
                                            <td align="center"><?php echo (isset($formData[$i]['rom_prod']['CLOS_UG_ROM'])) ? $formData[$i]['rom_prod']['CLOS_UG_ROM'] : ''; ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr style="font-size:10px;">
                                        <td align="left" valign="top" class="lable-text"><?php
                                                if(in_array($formData[$i]['formType'], array('7','3','4','2','8')))  {
                                                echo '(c)';
                                            } else if (in_array($formData[$i]['formType'], array('1'))) {
                                                echo '(b)';
                                            }
                                            ?> Dump Workings</td>
                                        <td align="center"><?php echo (isset($formData[$i]['rom_prod']['OPEN_DW_ROM'])) ? $formData[$i]['rom_prod']['OPEN_DW_ROM'] : ''; ?></td>
                                        <td align="center"><?php echo (isset($formData[$i]['rom_prod']['PROD_DW_ROM'])) ? $formData[$i]['rom_prod']['PROD_DW_ROM'] : ''; ?></td>
                                        <td align="center"><?php echo (isset($formData[$i]['rom_prod']['CLOS_DW_ROM'])) ? $formData[$i]['rom_prod']['CLOS_DW_ROM'] : ''; ?></td>
                                    </tr>
                                </table>
                            </div>
                            
                            <!--FORM F-1 TYPE GRADE WISE -->
                            <?php
                            $prodGradeArray = $formData[$i]['gradeProd']['gradeNames'];
                            $gradeValueArray = $formData[$i]['gradeProd']['gradeValues'];
                            ?>
                            <?php if ($returnType == "ANNUAL") { ?>
                            <div class="page-break">
                                <div id="grade_wise_production">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <?php } else { ?>
                            <div class="page-break" width="100%">
                                <div id="grade_wise_production">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                            <?php } ?>
                                        <tr><td></td></tr>
                                        <?php
                                        $ore = strtoupper(str_replace('_', ' ', $formData[$i]['mineral']));
                                        if (isset($formData[$i]['sub_min']) && $formData[$i]['sub_min'])
                                            $ore .= " (" . ucwords($formData[$i]['sub_min']) . ")";
                                        ?>
                                        <tr>
                                            <td align="center"><strong>
                                                <?php //
                                                // below code comment because we set the label in the common fime and print. added by ganesh satav dated 14 and 17 feb 2014
                                                //  if (( $formData[$i]['mineral'] == "manganese_ore") || ( $formData[$i]['mineral'] == "bauxite") || ( $formData[$i]['mineral'] == "chromite") || ($formData[$i]['mineral'] == "kyanite") || ($formData[$i]['mineral'] == "pyrophyllite") || ($formData[$i]['mineral'] == "sillimanite") || ($formData[$i]['mineral'] == "tourmaline")) {
                                                //    echo '2';
                                                // } else if ($formData[$i]['mineral'] == "iron_ore") {
                                                //    echo '3';
                                                // }
                                                ?><?php print_r($FormLabelNameWithFormNo['3']); ?> ( <?php echo $ore; ?> )</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="top">
                                                <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E5D0BD">
                                                    <tr>
                                                        <!--Below .added code add for solve the no and label issues added on 28 april 2014 added by ganesh satav -->
                                                        <?php 
                                                        if ($formData[$i]['formNo'] == 3) {
                                                            $width1 = "21%";
                                                            $width2 = "13%";
                                                            $width3 = "12%";
                                                            $width4 = "13%";
                                                            $width5 = "21%";
                                                            $width6 = "11.5%";
                                                            $width7 = "13.8%";
                                                            $width8 = "12%";
                                                        } else {
                                                            $width1 = "28%";
                                                            $width2 = "15%";
                                                            $width3 = "13%";
                                                            $width4 = "14%";
                                                            $width5 = "27%";
                                                            $width6 = "16%";
                                                            $width7 = "15%";
                                                            $width8 = "13%";
                                                        }
                                                        ?>
                                                        <?php if ($formData[$i]['formNo'] == 8) { ?>
                                                            <td width="<?php echo $width1; ?>" align="left" valign="top" class="form-table-title">Grades </td>                                                                                              
                                                        <?php }else { ?>
                                                            <td width="<?php echo $width1; ?>" align="left" valign="top" class="form-table-title">Grades (% of <?php echo html_entity_decode($formData[$i]['chemRep']); ?> content)</td>
                                                        <?php } ?>
                                                        <?php if ($formData[$i]['formNo'] == 3) { ?>
                                                            <td width="11%" align="center" class="form-table-title">Average Grade</td>
                                                        <?php } ?>
                                                        <td width="<?php echo $width2; ?>" align="center" class="form-table-title">Opening stock<br/>at mine head<br />(in tonne)</td>
                                                        <td width="<?php echo $width2; ?>" align="center" class="form-table-title">Production  (in tonne)</td>
                                                        <td width="<?php echo $width2; ?>" align="center" class="form-table-title">Despatches<br />from mine<br />head<br />  (in tonne)</td>
                                                        <td width="<?php echo $width2; ?>" align="center" class="form-table-title">Closing<br />stock at<br />mine head  (in tonne)</td>
                                                        <td width="<?php echo $width3; ?>" align="center" class="form-table-title">Ex-mine<br />price<br />(in &#8377; Per Tonne)  </td>
                                                    </tr>

                                                    <?php
                                                    $k = 1;
                                                    $feMinCount = 1;

                                                    foreach ($prodGradeArray as $gradeKey => $gradeVal) { 
                                                        ?>
                                                        <tr style="font-size:10px;">
                                                            <td colspan="7">
                                                                <!-- Below added code add for set the label No on the print and download pdf page added on the 21 april 2014  -->
                                                                <?php if ($gradeKey != '') { 
                                                                    if ($formData[$i]['formType'] == 3) { ?>
                                                                        <div style = "font-weight:bold; color:#001D31;"<?php if ($k != 1) echo 'class = "welcome-page-name "'; ?>><?php echo "(" . rome1($feMinCount++) . ") " . $gradeKey; ?></div>
                                                                    <?php }else { ?>
                                                                        <div style = "font-weight:bold; color:#001D31;"<?php if ($k != 1) echo 'class = "welcome-page-name "'; ?>><?php echo "(" . rome($feMinCount++) . ") " . $gradeKey; ?></div>
                                                                    <?php } ?> 
                                                                <?php } ?>
                                                                <div>
                                                                    <table width="100%" cellspacing="0" cellpadding="1" border="0.1">
                                                                        <?php
                                                                        $feMinSubCount = 'a';
                                                                        foreach ($gradeVal as $gradeId => $gradeLbl) {
                                                                            ?>
                                                                            <tr>
                                                                                <td width="<?php echo $width5; ?>" align="left" valign="top" class="lable-text"><?php echo "(" . $feMinSubCount++ . ") " . $gradeLbl; ?></td>
                                                                                <?php if ($formData[$i]['formNo'] == 3) { ?>
                                                                                    <?php if ($k < 7) { ?>
                                                                                        <td width="<?php echo $width6; ?>" align="center"><?php echo (isset($gradeValueArray[$gradeId]['average_grade'])) ? $gradeValueArray[$gradeId]['average_grade'] : ''; ?></td>
                                                                                    <?php } else { ?>
                                                                                        <td width="<?php echo $width6; ?>" align="center"> </td>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                                <td width="<?php echo $width7; ?>" align="center"><?php echo (isset($gradeValueArray[$gradeId]['opening_stock'])) ? $gradeValueArray[$gradeId]['opening_stock'] : ''; ?></td>
                                                                                <td width="<?php echo $width7; ?>" align="center"><?php echo (isset($gradeValueArray[$gradeId]['production'])) ? $gradeValueArray[$gradeId]['production'] : ''; ?></td>
                                                                                <td width="<?php echo $width7; ?>" align="center"><?php echo (isset($gradeValueArray[$gradeId]['despatches'])) ? $gradeValueArray[$gradeId]['despatches'] : ''; ?></td>
                                                                                <td width="<?php echo $width7; ?>" align="center"><?php echo (isset($gradeValueArray[$gradeId]['closing_stock'])) ? $gradeValueArray[$gradeId]['closing_stock'] : ''; ?></td>
                                                                                <td width="<?php echo $width8; ?>" align="center"><?php echo (isset($gradeValueArray[$gradeId]['pmv'])) ? $gradeValueArray[$gradeId]['pmv'] : ''; ?></td>
                                                                            </tr>
                                                                            <?php
                                                                            $k++;
                                                                        }
                                                                        ?>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!--FORM F-8 PULVERIZATION-->
                            <?php
                            if ($formData[$i]['formType'] == 8) {
                                ?>
                                <?php if ($returnType == "ANNUAL") { ?>
                                <div class="page-break"> 
                                    <div id="pulverisation" align="center">
                                        <table width="100%" align="left" border="0" cellspacing="0" cellpadding="0">
                                <?php } else { ?>
                                <div class="page-break"> 
                                    <div id="pulverisation" align="center">
                                        <table width="100%" align="left" border="0" cellspacing="0" cellpadding="0" align="center">
                                <?php } ?>
                                            <tr>
                                                <td align="center" style="font-size:10px"><strong>
                                                    <?php 
                                                        print_r($FormLabelNameWithFormNo['8']); ?> (<?php
                                                        $ore = strtoupper(str_replace('_', ' ', $formData[$i]['mineral']));
                                                        if (isset($formData[$i]['sub_min']) && $formData[$i]['sub_min']){
                                                            $ore .= " (" . ucwords($formData[$i]['sub_min']) . ")";
                                                        }
                                                        echo $ore;
                                                    ?>)
                                                </strong></td>
                                            </tr>
                                            <tr>
                                                <td align="left" valign="top">
                                                    <table id="pulverisation-table" width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                                        <thead>
                                                            <tr>
                                                                <th align="center" class="form-table-title" rowspan="2">Grade</th>
                                                                <th align="center" class="form-table-title" rowspan="2">Total Quantity of mineral pulverized (in tonne)</th>
                                                                <th align="center" class="form-table-title" colspan="2">Total quantity of Pulverized mineral produced (for each mesh size)</th>
                                                                <th align="center" class="form-table-title" colspan="3">Total quantity of pulverized mineral sold during the month</th>
                                                            </tr>
                                                            <tr>
                                                                <th align="center" class="form-table-title">Mesh size</th>
                                                                <th align="center" class="form-table-title">Quantity (tonne)</th>
                                                                <th align="center" class="form-table-title">Mesh size</th>
                                                                <th align="center" class="form-table-title">Quantity (tonne)</th>
                                                                <th align="center" class="form-table-title">Ex-factory Sale value (in &#8377;)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                            $pulArr = (isset($formData[$i]['pulverisation'])) ? $formData[$i]['pulverisation'] : array();

                                                            for ($k = 0; $k < count($pulArr); $k++) {
                                                                ?>
                                                                <tr class="pr" style="font-size:10px;">
                                                                    <td align="center"><?php echo $pulArr[$k]['GRADE_CODE']; ?></td>
                                                                    <td align="center"><?php echo $pulArr[$k]['MINERAL_TOT_QTY']; ?></td>
                                                                    <td align="center"><?php echo $pulArr[$k]['PRODUCED_MESH_SIZE']; ?></td>
                                                                    <td align="center"><?php echo $pulArr[$k]['PRODUCED_QUANTITY']; ?></td>
                                                                    <td align="center"><?php echo $pulArr[$k]['SOLD_MESH_SIZE']; ?></td>
                                                                    <td align="center"><?php echo $pulArr[$k]['SOLD_QUANTITY']; ?></td>
                                                                    <td align="center"><?php echo $pulArr[$k]['SALE_VALUE']; ?></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr><td></td></tr>
                                            <tr>
                                                <td align="center" class="welcome-page-name">
                                                    3.(ii) Average cost of Pulverization:  (in &#8377;) <?php echo (isset($pulArr[0]['AVG_COST'])) ? $pulArr[0]['AVG_COST'] : ''; ?> per tonne
                                                </td>
                                            </tr>
                                        </table>

                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        
                        <!--DEDUCTION DETAILS-->
                        <?php //if ($formData[$i]['deduction'] != null) { ?>
                            <?php if ($returnType == "ANNUAL") { ?>
                            <div class="page-break">  
                                <div class="welcome-signout"><strong>
                            <?php } else { ?>
                            <div class="page-break">  
                                <div align="left" style="font-size:10px"><strong>
                            <?php } ?>
                                    <?php
                                    /* // below code comment because we set the label in the common fime and print. added by ganesh satav dated 14 and 17 feb 2014
                                    *  if (( $formData[$i]['mineral'] == "manganese_ore") || ( $formData[$i]['mineral'] == "bauxite") || ( $formData[$i]['mineral'] == "chromite") || ($formData[$i]['mineral'] == "agate")) {
                                        echo '3';
                                    } else if ($formData[$i]['mineral'] == "iron_ore") {
                                        echo '4';
                                    } else if ($formData[$i]['mineral'] == "mica") {
                                        echo "2";
                                    } else if ($formData[$i]['mineral'] == "copper_ore") {
                                        echo "6";
                                    } else if (($formData[$i]['mineral'] == "kyanite") || ($formData[$i]['mineral'] == "pyrophyllite") || ($formData[$i]['mineral'] == "corundum") || ($formData[$i]['mineral'] == "sillimanite") || ($formData[$i]['mineral'] == "tourmaline")) {
                                        echo "4";
                                    }
                                    */ ?>
                                                
                                    <?php if($FormLabelNameWithFormNo['13']?print_r($FormLabelNameWithFormNo['13']):print_r($FormLabelNameWithFormNo['4'])); ?>
                                    (in &#8377; /Tonne)(
                                    <?php
                                    $ore = strtoupper(str_replace('_', ' ', $formData[$i]['mineral']));
                                    if (isset($formData[$i]['sub_min']) && $formData[$i]['sub_min'])
                                        $ore .= " (" . ucwords($formData[$i]['sub_min']) . ")";

                                    echo $ore;
                                    ?> )</strong>
                                </div>

                                <div class="form-sub-heading">
                                    <?php if ($returnType == "ANNUAL") { ?>
                                    <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; margin-left: 20px;margin-right: 20px;">
                                    <?php } else { ?>
                                    <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;" align="center">
                                    <?php } ?>

                                        <tr>
                                            <td width="61%" align="center" class="form-table-title">Deduction claimed</td>
                                            <td width="19%" align="center" class="form-table-title">Amount (in &#8377; /Tonne)</td>
                                            <td width="20%" align="center" class="form-table-title">Remarks</td>
                                        </tr>
                                        <tr height="60" style="font-size:10px">
                                            <td align="left" class="lable-text">(a) Cost of transportation (indicate Loading station and Distance from mine in remarks)</td>
                                            <td align="center"><?php echo (isset($formData[$i]['deduction']['trans']['cost'])) ? $formData[$i]['deduction']['trans']['cost'] : ''; ?></td>
                                            <td align="center"><?php echo (isset($formData[$i]['deduction']['trans']['remark'])) ? $formData[$i]['deduction']['trans']['remark'] : ''; ?></td>
                                        </tr>
                                        <tr height="60" style="font-size:10px">
                                            <td align="left" class="lable-text">(b) Loading and Unloading charges</td>
                                            <td align="center"><?php echo (isset($formData[$i]['deduction']['loading']['cost'])) ? $formData[$i]['deduction']['loading']['cost'] : ''; ?></td>
                                            <td align="center"><?php echo (isset($formData[$i]['deduction']['loading']['remark'])) ? $formData[$i]['deduction']['loading']['remark'] : ''; ?></td>
                                        </tr>
                                        <tr height="60" style="font-size:10px">
                                            <td align="left" class="lable-text">(c) Railway freight ,if applicable (indicate destination and distance in remarks)</td>
                                            <td align="center"><?php echo (isset($formData[$i]['deduction']['railway']['cost'])) ? $formData[$i]['deduction']['railway']['cost'] : ''; ?></td>
                                            <td align="center"><?php echo (isset($formData[$i]['deduction']['railway']['remark'])) ? $formData[$i]['deduction']['railway']['remark'] : ''; ?></td>
                                        </tr>
                                        <tr height="60" style="font-size:10px">
                                            <td align="left" class="lable-text">(d) Port Handling charges/export duty (indicate name of port in remarks)</td>
                                            <td align="center"><?php echo (isset($formData[$i]['deduction']['port']['cost'])) ? $formData[$i]['deduction']['port']['cost'] : ''; ?></td>
                                            <td align="center"><?php echo (isset($formData[$i]['deduction']['port']['remark'])) ? $formData[$i]['deduction']['port']['remark'] : ''; ?></td>
                                        </tr>
                                        <tr height="60" style="font-size:10px">
                                            <td align="left" class="lable-text">(e) Charges for Sampling and Analysis</td>
                                            <td align="center"><?php echo (isset($formData[$i]['deduction']['sampling']['cost'])) ? $formData[$i]['deduction']['sampling']['cost'] : ''; ?></td>
                                            <td align="center"><?php echo (isset($formData[$i]['deduction']['sampling']['remark'])) ? $formData[$i]['deduction']['sampling']['remark'] : ''; ?></td>
                                        </tr>
                                        <tr height="60" style="font-size:10px">
                                            <td align="left" class="lable-text">(f) Rent for the plot at Stocking yard</td>
                                            <td align="center"><?php echo (isset($formData[$i]['deduction']['plot']['cost'])) ? $formData[$i]['deduction']['plot']['cost'] : ''; ?></td>
                                            <td align="center"><?php echo (isset($formData[$i]['deduction']['plot']['remark'])) ? $formData[$i]['deduction']['plot']['remark'] : ''; ?></td>
                                        </tr>
                                        <tr height="60" style="font-size:10px">
                                            <td align="left" class="lable-text">(g) Other charges (specify clearly in remarks):</td>
                                            <td align="center"><?php echo (isset($formData[$i]['deduction']['other']['cost'])) ? $formData[$i]['deduction']['other']['cost'] : ''; ?></td>
                                            <td align="center"><?php echo (isset($formData[$i]['deduction']['other']['remark'])) ? $formData[$i]['deduction']['other']['remark'] : ''; ?></td>
                                        </tr>
                                        <tr height="30">
                                            <td align="left" class="total-bgcolor">Total (a) to (g) </td>
                                            <td colspan="2" align="left" class="total-bgcolor">
                                                <table width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="32%" align="right" class="welcome-page-name">
                                                                <?php echo (isset($formData[$i]['deduction']['totalProd'])) ? $formData[$i]['deduction']['totalProd'] : ''; ?></td>
                                                        <td width="68%"> </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        <?php //} ?>
                        
                        <!--SALES & DISPATCHES-->
                        <?php if (isset($formData[$i]['sales'])) { ?>
                            <?php if ($returnType == "ANNUAL") { ?>
                            <div class="page-break">
                                <div style="margin-top:40px;margin-left:20px;width:100%; font-size:12px;" class="welcome-signout"><strong>
                            <?php } else { ?>
                            <div class="page-break">
                                <div align="left" style="margin-top:40px; width:90%; font-size:10px;text-align: left;" class="welcome-signout"><strong>
                            <?php } ?>
                                    <?php
                                    // below code comment because we set the label in the common fime and print. added by ganesh satav dated 14 and 17 feb 2014
                                    /* if (( $formData[$i]['mineral'] == "manganese_ore") || ( $formData[$i]['mineral'] == "bauxite") || ( $formData[$i]['mineral'] == "chromite") || ($formData[$i]['mineral'] == "agate")) {
                                        echo '4';
                                    } else if (($formData[$i]['mineral'] == "iron_ore") || ($formData[$i]['mineral'] == "kyanite") || ($formData[$i]['mineral'] == "pyrophyllite") || ($formData[$i]['mineral'] == "corundum") || ($formData[$i]['mineral'] == "sillimanite") || ($formData[$i]['mineral'] == "tourmaline")) {
                                        echo '5';
                                    } else if ($formData[$i]['mineral'] == "mica") {
                                        echo "3";
                                    } else if ($formData[$i]['mineral'] == "copper_ore") {
                                        echo "7";
                                    }
                                    */ ?><?php
                                        if($FormLabelNameWithFormNo['14']?print_r($FormLabelNameWithFormNo['14']):print_r($FormLabelNameWithFormNo['5']))?> 
                                
                                    ( 
                                    <?php
                                    $ore = strtoupper(str_replace('_', ' ', $formData[$i]['mineral']));
                                    if (isset($formData[$i]['sub_min']) && $formData[$i]['sub_min'])
                                        $ore .= " (" . ucwords($formData[$i]['sub_min']) . ")";

                                    echo $ore;
                                    ?> ) </strong>
                                </div>

                                <?php if ($returnType == "ANNUAL") { ?>
                                <div style="margin-top:10px;margin-left:20px" class="form-sub-heading">
                                    <table id="sales_table" width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; margin-left: 20px;margin-right: 20px;">
                                <?php } else { ?> 
                                <div style="margin-top:10px;" class="form-sub-heading">
                                    <table id="sales_table" width="100%" align="center" border="1" cellpadding="1" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse; margin-right: 56px;font-size:9px;">
                                <?php } ?>
                                        <tr>
                                            <td height="28" align="center" valign="top" class="form-table-title"></td>
                                            <td align="center" class="form-table-title"></td>
                                            <td id="Domestic_1" colspan="4" align="center" class="form-table-title pdf-text-xs">For Domestic Consumption</td>
                                            <td id="Export_1"colspan="3" align="center" class="form-table-title pdf-text-xs">For export</td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="middle" class="form-table-title pdf-text-xs">Grade</td>
                                            <!-- below add the new test for the change discuss with ajay sir
                                            added by ganesh satav dated 12 sep 2014-->
                                            <td align="center" valign="middle" class="form-table-title pdf-text-xs">Nature of Dispatch (indicate whether Domestic Sale or Domestic Transfer or Captive consumption or Export)</td>
                                            <td id="Domestic_2" align="center" valign="middle" class="form-table-title pdf-text-xs">Registration<br />number as<br />allotted by the<br />Indian Bureau of<br />Mines to the<br />buyer</td>
                                            <td id="Domestic_3" align="center" valign="middle" class="form-table-title pdf-text-xs">Consignee name<br /></td>
                                            <td id="Domestic_4" align="center" valign="middle" class="form-table-title pdf-text-xs">Quantity<br />(in <?php echo $unit; ?>)</td>
                                            <td id="Domestic_5" align="center" valign="middle" class="form-table-title pdf-text-xs">Sale value <br />(in &#8377;)</td>
                                            <td id="Export_2" align="center" valign="middle" class="form-table-title pdf-text-xs">Country</td>
                                            <td id="Export_3" align="center" valign="middle" class="form-table-title pdf-text-xs">Quantity<br />(in <?php echo $unit; ?>)</td>
                                            <td id="Export_4" align="center" valign="middle" class="form-table-title pdf-text-xs">F.O.B<br />Value <br />(in &#8377;)<br /></td>
                                        </tr>
                                        <?php for ($count = 0; $count < count($formData[$i]['sales']); $count++) { ?>
                                            <tr>
                                                <td align="center" valign="middle" class="lable-text pdf-text-xs"><?php echo $formData[$i]['sales'][$count]['grade']; ?></td>
                                                <td align="center" valign="middle" class="pdf-text-xs"><?php echo $formData[$i]['sales'][$count]['client_type']; ?></td>
                                                <td id="Domestic_6" align="center" valign="middle" class="pdf-text-xs"><?php echo $formData[$i]['sales'][$count]['client_reg_no']; ?></td>
                                                <td id="Domestic_7" align="center" valign="middle" class="pdf-text-xs"><?php echo $formData[$i]['sales'][$count]['client_name']; ?></td>
                                                <td id="Domestic_8" align="center" valign="middle" class="pdf-text-xs"><?php echo $formData[$i]['sales'][$count]['quantity']; ?></td>
                                                <td id="Domestic_9" align="center" valign="middle" class="pdf-text-xs"><?php echo $formData[$i]['sales'][$count]['sale_value']; ?></td>
                                                <td id="Export_5" align="center" valign="middle" class="pdf-text-xs"><?php echo $formData[$i]['sales'][$count]['country']; ?></td>
                                                <td id="Export_6" align="center" valign="middle" class="pdf-text-xs"><?php echo $formData[$i]['sales'][$count]['expo_quantity']; ?></td>
                                                <td id="Export_7" align="center" valign="middle" class="pdf-text-xs"><?php echo $formData[$i]['sales'][$count]['expo_fob']; ?></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td colspan="9" align="left">Note : Mine owners are required to substantiate domestic sale value/ FOB value for each grade of ore quoted above with copy of invoices.</td>
                                        </tr>
                                    </table>
                                </div>
                                                
                            </div>
                        <?php } ?>          
                                            
                        <div class="page-break">
                            <div id="grade_wise_production">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <?php  if (($formData[$i]['formType'] == 6) || ($formData[$i]['formType'] == 1) || ($formData[$i]['formType'] == 2) || ($formData[$i]['formType'] == 3) || ($formData[$i]['formType'] == 4) || ($formData[$i]['formType'] == 8)) { ?>
                                        <?php //if (isset($gradeValueArray['reason_1']) && $gradeValueArray['reason_1'] != null) { ?>
                                            <tr>
                                                <td>
                                                    <div align="left" class = "welcome-page-name" style="font-size:10px"><strong>
                                                        <?php
                                                        // below code comment because we set the label in the common fime and print. added by ganesh satav dated 14 and 17 feb 2014
                                                        /*  if (($formData[$i]['mineral'] == "iron_ore") || ($formData[$i]['mineral'] == "kyanite") || ($formData[$i]['mineral'] == "pyrophyllite") || ($formData[$i]['mineral'] == "sillimanite") || ($formData[$i]['mineral'] == "tourmaline")) {
                                                            echo '6';
                                                        } else if (($formData[$i]['mineral'] == "manganese_ore") || ( $formData[$i]['mineral'] == "bauxite") || ( $formData[$i]['mineral'] == "chromite")) {
                                                            echo "5";
                                                        } else if ($formData[$i]['mineral'] == "copper_ore") {
                                                            echo "8";
                                                        } else if (( $formData[$i]['mineral'] == "mica")) {
                                                            echo "4";
                                                        }
                                                        */  ?>
                                                        <?php 
                                                        
                                                        if($FormLabelNameWithFormNo['15']?print_r($FormLabelNameWithFormNo['15']):print_r($FormLabelNameWithFormNo['6']))?> </strong>
                                                    </div>
                                                                                    
                                                    <div>
                                                        <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                                            <tr>
                                                                <!-- Remove the S form reason word. added by ganesh satav dated: 13 feb 14-->
                                                                <td width="100%" align="left" valign="top" class="form-table-title">Give reasons for increase/decrease in production compared to the previous<?php if($returnType == 'ANNUAL'){ ?> year<?php }else { ?> month<?php } ?> or nil production, if any, during the <?php if($returnType == 'ANNUAL'){ ?> year <?php }else { ?> month<?php } ?>.
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" height="60" valign="top" class="lable-text" style="font-size:10px">
                                                                    <?php
                                                                    if ($formData[$i]['mineral'] == "mica") {
                                                                        echo $formData[$i]['prodistocksF6']['crude']['REASON_ONE'];
                                                                    } else {
                                                                        echo (isset($gradeValueArray['reason_1'])) ? $gradeValueArray['reason_1'] : '';
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        </table> 
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div align="left" class = "welcome-page-name" style="font-size:10px"><strong>
                                                        <?php
                                                        // below code comment because we set the label in the common fime and print. added by ganesh satav dated 14 and 17 feb 2014
                                                        /*  if (($formData[$i]['mineral'] == "iron_ore") || ($formData[$i]['mineral'] == "kyanite") || ($formData[$i]['mineral'] == "pyrophyllite") || ($formData[$i]['mineral'] == "sillimanite") || ($formData[$i]['mineral'] == "tourmaline")) {
                                                            echo '7';
                                                        } else if (($formData[$i]['mineral'] == "manganese_ore") || ( $formData[$i]['mineral'] == "bauxite") || ( $formData[$i]['mineral'] == "chromite")) {
                                                            echo "6";
                                                        } else if ($formData[$i]['mineral'] == "copper_ore") {
                                                            echo "9";
                                                        } else if (( $formData[$i]['mineral'] == "mica")) {
                                                            echo "5";
                                                        }
                                                        */   ?>
                                                        <?php if($FormLabelNameWithFormNo['16']?print_r($FormLabelNameWithFormNo['16']):print_r($FormLabelNameWithFormNo['7']))?></strong>
                                                    </div>
                                                    <div>
                                                        <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                                            <tr>
                                                                <!-- Remove the S form reason word. added by ganesh satav dated: 13 feb 14-->
                                                                <td width="100%" align="left" valign="top" class="form-table-title">Give reasons for increase/decrease in grade wise ex-mine price ,if any, during the<?php if($returnType == 'ANNUAL'){ ?> year <?php }else { ?> month<?php } ?> compared to the previous <?php if($returnType == 'ANNUAL'){ ?> year <?php }else { ?> month<?php } ?>.
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" height="60" valign="top" class="lable-text" style="font-size:10px">
                                                                    <?php
                                                                    if ($formData[$i]['mineral'] == "mica") {
                                                                        echo $formData[$i]['prodistocksF6']['crude']['REASON_TWO'];
                                                                    } else {
                                                                        echo (isset($gradeValueArray['reason_2'])) ? $gradeValueArray['reason_2'] : '';
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        </table> 
                                                    </div>
                                                </td>
                                            </tr> 
                                        <?php //} ?>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>           
                                                
                        <?php
                    }
                }
            }
            ?>

        </div>
        
        <?php if ($returnType == 'ANNUAL') { ?>

            <!----------------------- PART - VII - ANNUAL RETURNS ---------------------->

            <!-- COST OF PRODUCTION -->
            <div>
                <div class="pdf-text-heading padd-bot">Part - VII<br/>COST OF PRODUCTION</div>

                <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center" style="border-collapse: collapse;">
                    <tr>
                        <td width="12%" align="center"  > </td>
                        <td width="46%" align="center"  >Item </td>
                        <td width="42%" align="center"  >Cost Per Tonne (in &#8377;) )</td>
                    </tr>
                    <tr>
                        <td align="center" class="pdf-text">(i)</td>
                        <td align="left" class="pdf-text">Direct Cost</td>
                        <td align="center" class="pdf-data">
                            <?php echo $productionCost['TOTAL_DIRECT_COST']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" class="pdf-text"> </td>
                        <td align="left" class="pdf-text">(a) Exploration</td>
                        <td align="center" class="pdf-data">
                            <?php echo $productionCost['EXPLORATION_COST']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" class="pdf-text"> </td>
                        <td align="left" class="pdf-text">(b) Mining</td>
                        <td align="center" class="pdf-data">
                            <?php echo $productionCost['MINING_COST']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" class="pdf-text"> </td>
                        <td align="left" class="pdf-text">(c) Beneficiation(Mechanical Only)</td>
                        <td align="center" class="pdf-data">
                            <?php echo $productionCost['BENEFICIATION_COST']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" class="pdf-text">(ii)</td>
                        <td align="left" class="pdf-text"> Over-head cost</td>
                        <td align="center" class="pdf-data">
                            <?php echo $productionCost['OVERHEAD_COST']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" class="pdf-text">(iii)</td>
                        <td align="left" class="pdf-text">Depreciation</td>
                        <td align="center" class="pdf-data">
                            <?php echo $productionCost['DEPRECIATION_COST']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" class="pdf-text">(iv)</td>
                        <td align="left" class="pdf-text">Interest</td>
                        <td align="center" class="pdf-data">
                            <?php echo $productionCost['INTEREST_COST']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" class="pdf-text">(v)</td>
                        <td align="left" class="pdf-text">Royalty</td>
                        <td align="center" class="pdf-data">
                            <?php echo $productionCost['ROYALTY_COST']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" class="pdf-text">(vi)</td>
                        <td align="left" class="pdf-text">Taxes</td>
                        <td align="center" class="pdf-data">
                            <?php echo $productionCost['TAXES_COST']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" class="pdf-text">(vii)</td>
                        <td align="left" class="pdf-text">Dead Rent</td>
                        <td align="center" class="pdf-data">
                            <?php echo $productionCost['DEAD_RENT_COST']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" class="pdf-text">(viii)</td>
                        <td align="left" class="pdf-text">Others (specify)
                            <?php echo $productionCost['OTHERS_SPEC']; ?>
                        </td>
                        <td align="center" class="pdf-data">
                            <?php echo $productionCost['OTHERS_COST'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td   align="center"> </td>
                        <td   align="left">Total</td>
                        <td   align="center">
                            <?php echo $productionCost['TOTAL_COST'] ?>
                        </td>
                    </tr>

                </table>
            </div>
        <?php } ?>
        
        <!--ESTIMATION TABLE-->

        <table class="estimation-table" align="center" border="1" width="100%" cellspacing="0" cellpadding="0">
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
            // // if(count($estimation == 2)){
            // $row = "";
            // // Added one more index for multiple minerals
            // // Added on 29/06/2018 by Naveen Jha to fix issue of 35KAR03014
            // foreach ($estimation as $e) {
            //     $row .= '<tr>';
            //     $row .= '<td align="center" border="1">' . $e[0]["min"] . '</td>';
            //     $row .= '<td align="center" border="1">' . $e[0]["est"] . '</td>';
            //     $row .= '<td align="center" border="1">' . $e[0]["cum"] . '</td>';
            //     $row .= '<td align="center" border="1">' . $e[0]["diff"] . '</td>';
            //     $row .= '</tr>';
                
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

        <!--FOOTER SECTION-->
        <table style="margin-left:20px;width:100%; margin-top: 5px;">
            <tr><td> </td></tr>
            <tr><td> </td></tr>
            <tr><td> </td></tr>
            <tr><td> </td></tr>
            <tr><td class="pdf-data-letter" align="left">&nbsp;&nbsp;I Certify that the information furnished above is correct and complete in all respects.<br></td></tr>
            <tr><td>
                    <table width="100%"><tr>
                            <td align="left" width="40%" class="pdf-data-letter">Place : <br /> Dist: <?php echo $mine['district'] . ", " . $mine['state']; ?> <br /> Pin:<?php echo $mine['pin']; ?> </td>
                            <td align="left" width="20%" class="pdf-data-letter"></td><td align="left" width="40%">Signature</td></tr>
                        <tr>
                            <td align="left" class="pdf-data-letter">Date : <?php echo $finalSubmitDate; ?></td>
                            <td></td>
                            <td align="left" class="pdf-data-letter">Name : <?php echo $fillerName; ?></td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td></td>
                            <td align="left" class="pdf-data-letter">Designation: <?php echo $fillerdesignation; ?></td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td></td>
                            <td align="left" class="pdf-data-letter">Owner / Agent / Mining Engineer / Manager</td>
                        </tr>
                    </table>

                </td></tr>

            <tr><td> </td>
            </tr>
            <tr>
                <td width="100%" style="text-align: center;">
                    <b><i class="pdf-data"><?php echo $ipTimeFormat; ?></i></b>
                </td>
            </tr>


            <tr><td> </td></tr>
            <tr><td> </td></tr>

            <tr><td> </td></tr>
            <tr><td> </td></tr>
        </table>
    </td>
</tr>

<style type="text/css">
.page-break {
    page-break-after: always;
}
.pdf-data{
    font-size: 9px;
    /* font-family: "Times New Roman", Times, serif; */
}
.pdf-data-letter{
    font-size: 10px;
}
.textJustify{
    text-align:justify;
    text-justify:inter-word;
}
.pdf-text-heading{
    text-align: center;
    font-weight: bold;
    font-size: 11px;
}
.pdf-text{
    font-size: 9px;
    /* font-family: "Times New Roman", Times, serif; */
}
.pdf-text-lg {
    font-size: 12px;
}
.pdf-text-sm {
    font-size: 9px;
}
.pdf-text-xs {
    font-size: 7.5px;
}
.padd-bot {
    padding-bottom: 10px;
}
.padd-top {
    padding-top: 10px;
}
.welcome-signout {
    font-size: 11px;
}
.middle {
    vertical-align: middle;
}

.sec_tit {
    font-size: 11px;
}
.f_s_8 {
    font-size: 8px;
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
.w_26p {
    width: 16px;
}
.w_22p {
    width: 14px;
}
.text_cent {
    text-align: center;
}
</style>