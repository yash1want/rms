<?php ini_set('max_execution_time', 0); ?>

<tr>
    <td valign="top" align="center">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" >
            <tr>
                <td align="center" valign="top"><br />
                    <div id="bodydiv">
                        <table width="97%" border="0" style="border:0px solid #E5D0BD;" cellspacing="0" cellpadding="0" style="margin: 0px 20px 0px 5px" align="center">
                            <tr><td height="5"></td></tr>
                            <tr style="background-image: url('draft.jpg') no-repeat 0 0;">
                                <td align="center" class="welcome-page-name">
                                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                        <tr>
                                            <td width="100%">
                                                <table border="0" align="center" cellpadding="1" cellspacing="1" style="line-height:9px;" class="f_s_9">
                                                    <tr>
                                                        <td align="center">
                                                            <strong>
                                                                <?php if ($returnType == 'ANNUAL') { ?>FORM O<?php } else { ?>FORM N<?php } ?>
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center">
                                                            <strong>
                                                                <?php if ($returnType == 'MONTHLY') { ?>
                                                                    For the Month of <?php echo $returnMonth . " " . $returnYear; ?>
                                                                <?php } else { ?>
                                                                    For the Financial Year of <?php echo $returnYear . " - " . ($returnYear + 1); ?>
                                                                <?php } ?>
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" class="welcome-page-name">
                                                            <strong><?php echo $returnType; ?> RETURN</strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" style="margin: 0 auto;">
                                                            <?php
                                                            if ($returnType == 'MONTHLY'){
                                                                echo "<span style='padding-left:50px'><strong>[See rule 45 (6) (i)]</strong></span>";
                                                            }
                                                            else {
                                                                echo "<span style='padding-left:50px'><strong>[See rule 45 (6) (ii)]</strong></span>";
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            
                            <tr>
                                <td align="left" class="f_s_10">To</td>
                            </tr>
                            <tr>
                                <td align="left" class="f_s_9">(i) The State Government<br>(ii)The Regional Controller of Mines<br>Indian Bureau of Mines<br><?php echo ucwords(strtolower($printAllRegion)); ?> Region,<br><br>PIN: <?php echo $pinCode; ?><br>( Please address to regional controller of mines in whose territorial jurisdiction the mines falls as notified from time to time by the controller general, Indian bureau of mines under rule 62 of the mineral conservation and development rules, 1988 )<br><br>(ii) The Chief Mineral Economist</td>
                            </tr>
                            
                            <tr>
                                <td align="left">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                        <tr>
                                            <td align="center" valign="top">
                                                <div id="bodydiv">
                                                    <table width="100%" border="0"  style="background:url(<?php echo $img_name; ?>); border:0px solid #E5D0BD;" cellspacing="0" cellpadding="0" style="margin: 0px 20px 0px 5px" align="center">
                                                        <tr><td></td></tr>
                                                        <tr><td></td></tr>
                                                        <tr>
                                                            <td align="center" class="welcome-signout">
                                                                <strong>1. GENERAL PARTICULARS</strong>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                        <tr style="font-size:12px">
                                            <td width="50%" align="left" class="form-table-title lable-text">Registration No ( allotted by IBM)</td>
                                            <td width="50%" align="left" valign="top" class="lable-text">
                                                <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" style="border-collapse:collapse;">
                                                    <tr>
                                                        <td colspan="2" align="left" class="lable-text"><?php echo $regNO; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="30%" align="left" class="form-table-title lable-text">Name</td>
                                                        <td width="70%" align="left" class="lable-text"><?php echo $fullName; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" class="form-table-title lable-text">Address</td>
                                                        <!-- ADDED THE CODE AS PER THE NOV RELEASE CODE -->
                                                        <td align="left" class="lable-text"><?php echo $appAdd[0]["mcappd_address1"] ? $appAdd[0]["mcappd_address1"] . ",<br/>" : "" ?>
                                                            <?php echo $appAdd[0]["mcappd_address2"] ? $appAdd[0]["mcappd_address2"] . ",<br/>" : "" ?>
                                                            <?php echo $appAdd[0]["mcappd_address3"] ? $appAdd[0]["mcappd_address3"] . ",<br/>" : "" ?>
                                                            <?php echo $appAdd[0]["mcappd_state"]; ?>
                                                            <?php echo $appAdd[0]["mcappd_district"]; ?>
                                                            <?php echo $appAdd[0]["mcappd_pincode"] ? $appAdd[0]["mcappd_pincode"] : "" ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <!--ADDED THE CODE AS PER THE NOV RELEASE CODE-->
                                                        <td align="left" class="form-table-title lable-text">Plant Name / Storage Location</td>
                                                        <td align="left" class="lable-text"><?php echo $addressDetails[0]['mcmcd_nameofplant'] ? $addressDetails[0]['mcmcd_nameofplant'].",<br/>" : ''; ?>
                                                            <?php echo $addressDetails[0]['mcmd_village'] ? $addressDetails[0]['mcmd_village'] . ",<br/>" : ""; ?>
                                                            <?php echo $addressDetails[0]['mcmd_tehsil'] ? $addressDetails[0]['mcmd_tehsil'] . ",<br/>" : ""; ?>
                                                            <?php echo (isset($regionAndDistrictName[0]['district_name'])) ? $regionAndDistrictName[0]['district_name'] . ",<br/>" : ""; ?>
                                                            <?php echo $addressDetails[0]['mcmd_state'] ? $addressDetails[0]['mcmd_state'] : ''; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" class="form-table-title lable-text">Latitude and Longitude<br /></td>
                                                        <td align="left" class="lable-text"><?php 
                                                        if ($activityType == 'C' || $activityType == 'S')
                                                        echo $latiLongiDetails['latitude'] . " " . $latiLongiDetails['longitude']; 
                                                        else
                                                        echo "NA";
                                                        ?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="form-table-title lable-text">Name of activity(s) reported</td>
                                            <td> <b><?php echo $currActivity; ?></b></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
        <br pagebreak="true" />
        
        <!--------------------------------ADD CODE FOR DETAILS OF THE ACTIVITY--------------------------------->

        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" nobr="true">
            <tr>
                <td align="center" valign="top">
                    <div id="bodydiv">
                        <table width="100%" border="0"  style="background:url(<?php echo $projectPath . "/img/print/" . $img_name; ?>); border:0px solid #E5D0BD;" cellspacing="0" cellpadding="0" style="margin: 0px 20px 0px 5px" align="center">
                            <tr><td></td></tr>
                            <tr><td></td></tr>
                            <tr>
                                <td align="center" class="welcome-signout">
                                    <strong>
                                        2. STATEMENT ON DETAILS OF THE ACTIVITY UNDERTAKEN 
                                        <?php if ($returnType == 'MONTHLY') { ?>
                                            IN THE MONTH OF <?php echo strtoupper(date("M", strtotime($returnDate)))." ".$returnYear; ?>
                                        <?php
                                        } else {
                                            $returnPeriod = $returnYear . " - " . ($returnYear + 1);
                                            ?>
                                            AT THE END OF FINANCIAL YEAR <?php
                                            echo $returnPeriod;
                                        }
                                        ?>
                                    </strong>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
        
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
                <td align="center" valign="top">
                    <div id="bodydiv">
                        <table width="97%" border="0"  style="background:url(<?php echo $projectPath . "/img/print/" . $img_name; ?>); border:0px solid #E5D0BD;" cellspacing="0" cellpadding="0" style="margin: 0px 20px 0px 5px" align="center">
                            <tr>
                                <td>
                                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                            <tr style="font-size: 12px"><td style="height:5px" align="center">(a) Trading Activity</td></tr>
                                            <tr>
                                                <td>
                                                    <table width="100%" cellspacing="0" cellpadding="4" border="1" style="border-collapse:collapse;">
                                                        <tbody>
                                                            <tr>
                                                                <td align="center" class="form-table-title" width="11%"><strong>Ore / Mineral</strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Grade</strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Opening stock</strong></td>
                                                                <td align="center" class="form-table-title" colspan="3" width="39%"><strong>Ore purchased during the Month (within the country)</strong></td>
                                                                <td align="center" class="form-table-title" colspan="3" width="30%"><strong>Ore imported during the Month</strong></td>
                                                            </tr>
                                                            <tr>
                                                                <td align="center" class="form-table-title" width="11%"></td>
                                                                <td align="center" class="form-table-title" width="10%"></td>
                                                                <td align="center" class="form-table-title" width="10%"></td>
                                                                <td align="center" class="form-table-title" width="19%"><strong>Registration number as allotted by the Indian Bureau of Mines to the supplier (to indicate separately if more than one supplier)</strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Quantity</strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Value </strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Country</strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Quantity</strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Value </strong></td>
                                                            </tr> 
                                                            <?php for ($i = 0; $i < count($mineralsData); $i++) { ?>
                                                                <tr style="font-size:9px">
                                                                    <td align="center" width="11%">
                                                                        <?php echo $mineralsData[$i]['local_mineral_code']; ?>
                                                                        <?php echo ($mineralsData[$i]['local_mineral_code'] != 'NIL') ? ($mineralWithUnitArr[$mineralsData[$i]['local_mineral_code']]?"(".$mineralWithUnitArr[$mineralsData[$i]['local_mineral_code']].")":"") : ""; ?>
                                                                    </td>
                                                                    <td align="center" width="10%">
                                                                        <?php
                                                                        // if (count($gradesData[$i]) > 0) {
                                                                        if (isset($gradesData[$i])) {
                                                                            if (is_array($gradesData[$i]) && count($gradesData[$i]) > 0) {
                                                                                echo $gradesData[$i];
                                                                            } else if ((is_array($gradesData[$i]) && count($gradesData[$i]) == 0)) {
                                                                                echo '';
                                                                            } else if ($gradesData[$i] != '') {
                                                                                echo $gradesData[$i];
                                                                            }
                                                                        }
                                                                        else{
                                                                            echo "Nil";
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td align="center" width="10%"><?php echo $mineralsData[$i]['opening_stock']; ?></td>
                                                                    <td align="center" colspan="3" width="39%">
                                                                        <table cellpadding="0" cellspacing="0" class="f5-sub-table-print">
                                                                            <?php for ($sup = 1; $sup <= $gradeforMineral[$i]['supplier']['suppliercount']; $sup++) { ?>
                                                                                <tr>  
                                                                                    <td align="center" width="47%" style="border:0.1px solid black"><?php echo $gradeforMineral[$i]['supplier']['registration_no_' . $sup]; ?></td>
                                                                                    <td align="center" width="28%" style="border:0.1px solid black"><?php echo $gradeforMineral[$i]['supplier']['quantity_' . $sup]; ?></td>
                                                                                    <td align="center" width="26%" style="border:0.1px solid black"><?php echo $gradeforMineral[$i]['supplier']['value_' . $sup]; ?></td>
                                                                                </tr>
                                                                            <?php } ?> 
                                                                        </table>
                                                                    </td>
                                                                    <td align="center" colspan="3" width="30%">
                                                                        <table cellpadding="0" cellspacing="0" class="f5-sub-table-print">
                                                                            <?php for ($imp = 1; $imp <= $gradeforMineral[$i]['importData']['importcount']; $imp++) { ?>
                                                                                <tr>  
                                                                                    <td align="center" width="30%" style="border:0.1px solid black"><?php echo $gradeforMineral[$i]['importData']['country_name_' . $imp]; ?></td>
                                                                                    <td align="center" width="36%" style="border:0.1px solid black"><?php echo $gradeforMineral[$i]['importData']['quantity_' . $imp]; ?></td>
                                                                                    <td align="center" width="30%" style="border:0.1px solid black"><?php echo $gradeforMineral[$i]['importData']['value_' . $imp]; ?></td>
                                                                                </tr>
                                                                            <?php } ?> 
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr><td style="height:5px"></td></tr>
                                            <tr style="font-size: 12px"><td style="height:5px" align="center">(a) Trading Activity continues...</td></tr>
                                            <tr>
                                                <td align="center">
                                                    <table width="100%" cellspacing="0" cellpadding="4">
                                                        <tbody>
                                                            <tr>
                                                                <td width="10%"></td>
                                                                <td width="65%" align="center" border="1" class="form-table-title" colspan="3"><strong>Ore despatched during the Month</strong></td>
                                                                <td width="15%" align="center" border="1" class="form-table-title"><strong>Closing stock</strong></td>
                                                                <td width="10%"></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="10%"></td>
                                                                <td width="35%" align="center" border="1" class="form-table-title"><strong>Registration number as allotted by the Indian Bureau of Mines to the buyer (to indicate separately if more than one buyer)</strong></td>
                                                                <td width="15%" align="center" border="1" class="form-table-title"><strong>Quantity</strong></td>
                                                                <td width="15%" align="center" border="1" class="form-table-title"><strong>Value </strong></td>
                                                                <td width="15%" align="center" border="1" class="form-table-title"><strong>Quantity</strong></td>
                                                                <td width="10%"></td>
                                                            </tr> 
                                                            <?php for ($i = 0; $i < count($mineralsData); $i++) { ?>
                                                                <tr style="font-size:9px">
                                                                    <td></td>
                                                                    <td align="center" colspan="3" border="1">
                                                                        <table cellpadding="0" cellspacing="0" class="f5-sub-table-print" style="border:0.1px solid black">
                                                                            <?php for ($desp = 1; $desp <= $gradeforMineral[$i]['despatch']['despatchcount']; $desp++) { ?>
                                                                                <tr>  
                                                                                    <td align="center" width="53%" style="border-right:0.1px solid black"><?php echo $gradeforMineral[$i]['despatch']['registration_no_' . $desp]; ?></td>
                                                                                    <td align="center" width="24%" style="border-right:0.1px solid black"><?php echo $gradeforMineral[$i]['despatch']['quantity_' . $desp]; ?></td>
                                                                                    <td align="center" width="23%"><?php echo $gradeforMineral[$i]['despatch']['value_' . $desp]; ?></td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        </table>
                                                                    </td>
                                                                    <td align="center" border="1"><?php echo $mineralsData[$i]['closing_stock']; ?></td>  
                                                                    <td></td>    
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr><td style="height:5px"></td></tr>
                                            <br pagebreak="true" />
                                            
                                            <!-- START CODE FOR THE EXPORT OF ORE ------------------------------>
                                            <tr><td></td></tr>
                                            <tr style="font-size: 12px"><td style="height:5px" align="center">(b) Export Activity</td></tr>
                                            <tr>
                                                <td align="left">
                                                    <table width="100%" cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                                                        <tbody>
                                                            <tr>
                                                                <td align="center" class="form-table-title" width="11%"><strong>Ore / Mineral</strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Grade</strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Opening stock</strong></td>
                                                                <td align="center" class="form-table-title" width="39%" colspan="3"><strong>Ore procured during the Month for export <br>(from within the country)</strong></td>
                                                                <td align="center" class="form-table-title" width="30%" colspan="3"><strong>Ore imported during the Month</strong></td>
                                                            </tr>
                                                            <tr>
                                                                <td align="center" class="form-table-title" width="11%"></td>
                                                                <td align="center" class="form-table-title" width="10%"></td>
                                                                <td align="center" class="form-table-title" width="10%"></td>
                                                                <td align="center" class="form-table-title" width="19%"><strong>Registration number as allotted by the Indian Bureau of Mines to the supplier (to indicate separately if more than one supplier)</strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Quantity</strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Value </strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Country</strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Quantity</strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Value </strong></td>
                                                            </tr> 
                                                            <?php for ($i = 0; $i < count($mineralsExportData); $i++) { ?>
                                                                <tr style="font-size:9px">
                                                                    <td align="center" width="11%">
                                                                        <?php echo $mineralsExportData[$i]['local_mineral_code']; ?>
                                                                        <?php echo ($mineralsExportData[$i]['local_mineral_code'] != 'NIL') ? ($mineralWithUnitArr[$mineralsExportData[$i]['local_mineral_code']]?"(".$mineralWithUnitArr[$mineralsExportData[$i]['local_mineral_code']].")":"") : ""; ?>
                                                                    </td>
                                                                    <td align="center" width="10%">
                                                                        <?php
                                                                        if (isset($gradesExportData[$i])) {
                                                                            if (is_array($gradesExportData[$i]) && count($gradesExportData[$i]) > 0) {
                                                                                echo $gradesExportData[$i];
                                                                            } else if ((is_array($gradesExportData[$i]) && count($gradesExportData[$i]) == 0)) {
                                                                                echo '';
                                                                            } else if ($gradesExportData[$i] != '') {
                                                                                echo $gradesExportData[$i];
                                                                            }
                                                                        }
                                                                        else{
                                                                            echo "Nil";
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td align="center" width="10%"><?php echo $mineralsExportData[$i]['opening_stock']; ?></td>
                                                                    <td align="center" colspan="3" width="39%">
                                                                        <table cellpadding="0" cellspacing="0" class="f5-sub-table-print" style="border:0.1px solid black">
                                                                            <?php for ($sup = 1; $sup <= $showMineralData[$i]['supplier']['suppliercount']; $sup++) { ?>
                                                                                <tr>  
                                                                                    <td align="center" width="47%" style="border-right:0.1px solid black"><?php echo $showMineralData[$i]['supplier']['registration_no_' . $sup]; ?></td>
                                                                                    <td align="center" width="28%" style="border-right:0.1px solid black"><?php echo $showMineralData[$i]['supplier']['quantity_' . $sup]; ?></td>
                                                                                    <td align="center" width="26%"><?php echo $showMineralData[$i]['supplier']['value_' . $sup]; ?></td>
                                                                                </tr>
                                                                            <?php } ?> 
                                                                        </table>
                                                                    </td>
                                                                    <td align="center" colspan="3" width="30%">
                                                                        <table cellpadding="0" cellspacing="0" class="f5-sub-table-print" style="border:0.1px solid black">
                                                                            <?php for ($imp = 1; $imp <= $showMineralData[$i]['importData']['importcount']; $imp++) { ?>
                                                                                <tr>  
                                                                                    <td align="center" width="30%" style="border-right:0.1px solid black"><?php echo $showMineralData[$i]['importData']['country_name_' . $imp]; ?></td>
                                                                                    <td align="center" width="36%" style="border-right:0.1px solid black"><?php echo $showMineralData[$i]['importData']['quantity_' . $imp]; ?></td>
                                                                                    <td align="center" width="33%"><?php echo $showMineralData[$i]['importData']['value_' . $imp]; ?></td>
                                                                                </tr>
                                                                            <?php } ?> 
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr><td style="height:5px"></td></tr>
                                            <tr style="font-size: 12px"><td style="height:5px" align="center">(b) Export Activity continues...</td></tr>
                                            <tr>
                                                <td align="center">
                                                    <table width="100%" cellspacing="0" cellpadding="4" bordercolor="#E5D0BD">
                                                        <tbody>
                                                            <tr>
                                                                <td width="10%"></td>
                                                                <td width="60%" align="center" border="1" class="form-table-title" colspan="3"><strong>Ore despatched for exports during the Month</strong></td>
                                                                <td width="20%" align="center" border="1" class="form-table-title"><strong>Closing stock</strong></td>
                                                                <td width="10%"></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="10%"></td>
                                                                <td width="20%" align="center" border="1" class="form-table-title"><strong>Country</strong></td>
                                                                <td width="20%" align="center" border="1" class="form-table-title"><strong>Quantity</strong></td>
                                                                <td width="20%" align="center" border="1" class="form-table-title"><strong>Value </strong></td>
                                                                <td width="20%" align="center" border="1" class="form-table-title"><strong>Quantity</strong></td>
                                                                <td width="10%"></td>
                                                            </tr> 
                                                            <?php for ($i = 0; $i < count($mineralsExportData); $i++) { ?>
                                                                <tr style="font-size:9px">
                                                                    <td></td>
                                                                    <td align="left" colspan="3" border="1">
                                                                        <table cellpadding="2" cellspacing="0" class="f5-sub-table-print" style="border:0.1px solid black">
                                                                            <?php for ($desp = 1; $desp <= $showMineralData[$i]['despatch']['despatchcount']; $desp++) { ?>
                                                                                <tr>  
                                                                                    <td align="center" width="32%" style="border-right:0.1px solid black"><?php echo $showMineralData[$i]['despatch']['country_name_' . $desp]; ?></td>
                                                                                    <td align="center" width="35%" style="border-right:0.1px solid black"><?php echo $showMineralData[$i]['despatch']['quantity_' . $desp]; ?></td>
                                                                                    <td align="center" width="33%"><?php echo $showMineralData[$i]['despatch']['value_' . $desp]; ?></td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        </table>
                                                                    </td>
                                                                    <td align="center" border="1"><?php echo $mineralsExportData[$i]['closing_stock']; ?></td>   
                                                                    <td></td>   
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr><td style="height:5px"></td></tr>
                                            <br pagebreak="true" />
                                            
                                            <!-- START CODE FOR THE END-USE MINERAL BASED ACTIVITY --------->

                                            <tr><td></td></tr>
                                            <tr style="font-size: 12px"><td style="height:5px" align="center">(c) End-Use Mineral Based Activity</td></tr>
                                            <tr>
                                                <td align="left">
                                                    <table width="100%" cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                                                        <tbody>
                                                            <tr>
                                                                <td align="center" class="form-table-title" width="11%"><strong>Ore / Mineral</strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Grade</strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Opening stock</strong></td>
                                                                <td align="center" class="form-table-title" width="39%" colspan="3"><strong>Ore purchased during the Month (within the country)</strong></td>
                                                                <td align="center" class="form-table-title" width="30%" colspan="3"><strong>Ore imported during the Month</strong></td>
                                                            </tr>
                                                            <tr>
                                                                <td align="center" class="form-table-title" width="11%"></td>
                                                                <td align="center" class="form-table-title" width="10%"></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Quantity</strong></td>
                                                                <td align="center" class="form-table-title" width="19%"><strong>Registration number as allotted by the Indian Bureau of Mines to the supplier (to indicate separately if more than one supplier )</strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Quantity</strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Value </strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Country</strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Quantity</strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Value </strong></td>
                                                            </tr> 
                                                            <?php for ($i = 0; $i < count($mineralsBaseData); $i++) { ?>
                                                                <tr style="font-size:9px">
                                                                    <td align="center" width="11%">
                                                                        <?php echo $mineralsBaseData[$i]['local_mineral_code'];?>
                                                                        <?php echo (isset($mineralWithUnitArr[$mineralsBaseData[$i]['local_mineral_code']]))?"(".$mineralWithUnitArr[$mineralsBaseData[$i]['local_mineral_code']].")":""; ?>
                                                                    </td>
                                                                    <td align="center" width="10%">
                                                                        <?php
                                                                        if (isset($gradesBaseData[$i]) && count($gradesBaseData[$i]) > 0) {
                                                                            echo $gradesBaseData[$i];
                                                                        }
                                                                        else
                                                                            echo "Nil";
                                                                        ?>

                                                                    </td>
                                                                    <td align="center" width="10%"><?php echo $mineralsBaseData[$i]['opening_stock']; ?></td>
                                                                    <td align="center" colspan="3" width="39%">
                                                                        <table cellpadding="0" cellspacing="0" class="f5-sub-table-print" style="border:0.1px solid black">
                                                                            <?php for ($sup = 1; $sup <= $showMineralBaseData[$i]['supplier']['suppliercount']; $sup++) { ?>
                                                                                <tr>  
                                                                                    <td align="center" width="47%" style="border-right:0.1px solid black"><?php echo $showMineralBaseData[$i]['supplier']['registration_no_' . $sup]; ?></td>
                                                                                    <td align="center" width="28%" style="border-right:0.1px solid black"><?php echo $showMineralBaseData[$i]['supplier']['quantity_' . $sup]; ?></td>
                                                                                    <td align="center" width="26%"><?php echo $showMineralBaseData[$i]['supplier']['value_' . $sup]; ?></td>
                                                                                </tr>
                                                                            <?php } ?> 
                                                                        </table>
                                                                    </td>
                                                                    <td align="center" colspan="3" width="30%">
                                                                        <table cellpadding="0" cellspacing="0" class="f5-sub-table-print" style="border:0.1px solid black">
                                                                            <?php for ($imp = 1; $imp <= $showMineralBaseData[$i]['importData']['importcount']; $imp++) { ?>
                                                                                <tr>  
                                                                                    <td align="center" width="30%" style="border-right:0.1px solid black"><?php echo $showMineralBaseData[$i]['importData']['country_name_' . $imp]; ?></td>
                                                                                    <td align="center" width="36%" style="border-right:0.1px solid black"><?php echo $showMineralBaseData[$i]['importData']['quantity_' . $imp]; ?></td>
                                                                                    <td align="center" width="30%"><?php echo $showMineralBaseData[$i]['importData']['value_' . $imp]; ?></td>
                                                                                </tr>
                                                                            <?php } ?> 
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr><td style="" height="5px"></td></tr>
                                            <tr style="font-size: 12px"><td style="height:5px" align="center">(c) End-Use Mineral Based Activity continues...</td></tr>
                                            <tr>
                                                <td align="center">
                                                    <table width="100%" cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                                                        <tbody>
                                                            <tr>
                                                                <td align="center" width="30%" class="form-table-title" colspan="2"><strong>Ore consumed during the month</strong></td>
                                                                <td align="center" width="55%" class="form-table-title" colspan="3"><strong>Ore sold during the Month</strong></td>
                                                                <td align="center" width="15%" class="form-table-title"><strong>Closing stock</strong></td>
                                                            </tr>
                                                            <tr>
                                                                <td align="center" width="15%" class="form-table-title"><strong>Quantity</strong></td>
                                                                <td align="center" width="15%" class="form-table-title"><strong>Value </strong></td>
                                                                <td align="center" width="25%" class="form-table-title"><strong>Registration number as allotted by the Indian Bureau of Mines to the buyer (to indicate separately if more than one buyer) </strong></td>
                                                                <td align="center" width="15%" class="form-table-title"><strong>Quantity</strong></td>
                                                                <td align="center" width="15%" class="form-table-title"><strong>Value </strong></td>
                                                                <td align="center" width="15%" class="form-table-title"><strong>Quantity</strong></td>
                                                            </tr> 
                                                            <?php for ($i = 0; $i < count($mineralsBaseData); $i++) { ?>
                                                                <tr style="font-size:9px">
                                                                    <td align="center" width="15%"><?php echo $showMineralBaseData[$i]['consumeData']['quantity']; ?></td>
                                                                    <td align="center" width="15%"><?php echo $showMineralBaseData[$i]['consumeData']['value']; ?></td>
                                                                    <td align="center" colspan="3">
                                                                        <table cellpadding="2" cellspacing="0" class="f5-sub-table-print" style="border:0.1px solid black">
                                                                            <?php for ($desp = 1; $desp <= $showMineralBaseData[$i]['despatch']['despatchcount']; $desp++) { ?>
                                                                                <tr>  
                                                                                    <td align="center" width="44%" style="border-right:0.1px solid black"><?php echo $showMineralBaseData[$i]['despatch']['registration_no_' . $desp]; ?></td>
                                                                                    <td align="center" width="29%" style="border-right:0.1px solid black"><?php echo $showMineralBaseData[$i]['despatch']['quantity_' . $desp]; ?></td>
                                                                                    <td align="center" width="27%"><?php echo $showMineralBaseData[$i]['despatch']['value_' . $desp]; ?></td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        </table>
                                                                    </td>
                                                                    <td align="center" width="15%"><?php echo $mineralsBaseData[$i]['closing_stock']; ?></td>      
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr><td height="5px"></td></tr>
                                            <br pagebreak="true" />
                                            
                                            <!-- START CODE FOR THE STORAGE ACTIVITY ----------------------------->
                                            <tr style="font-size: 12px"><td style="height:5px" align="center">(d) Storage Activity</td></tr>
                                            <tr>
                                                <td align="left">
                                                    <table width="100%" cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;">
                                                        <tbody>
                                                            <tr>
                                                                <td align="center" class="form-table-title" width="11%"><strong>Ore / Mineral</strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Grade</strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Opening stock</strong></td>
                                                                <td align="center" class="form-table-title" width="39%" colspan="3"><strong>Ore received during the Month (within the country)</strong></td>
                                                                <td align="center" class="form-table-title" width="30%" colspan="3"><strong>Ore imported during the Month</strong></td>
                                                            </tr>
                                                            <tr>
                                                                <td align="center" class="form-table-title" width="11%"></td>
                                                                <td align="center" class="form-table-title" width="10%"></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Quantity</strong></td>
                                                                <td align="center" class="form-table-title" width="19%"><strong>Registration number as allotted by the Indian Bureau of Mines to the supplier (to indicate separately if more than one supplier )</strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Quantity</strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Value </strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Country</strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Quantity</strong></td>
                                                                <td align="center" class="form-table-title" width="10%"><strong>Value </strong></td>
                                                            </tr> 
                                                            <?php for ($i = 0; $i < count($mineralsStorageData); $i++) { ?>
                                                                <tr style="font-size:9px">
                                                                    <td align="center" width="11%">
                                                                        <?php echo $mineralsStorageData[$i]['local_mineral_code']; ?>
                                                                        <?php echo ($mineralsStorageData[$i]['local_mineral_code'] != 'NIL') ? ($mineralWithUnitArr[$mineralsStorageData[$i]['local_mineral_code']]?"(".$mineralWithUnitArr[$mineralsStorageData[$i]['local_mineral_code']].")":"") : ""; ?>
                                                                    </td>
                                                                    <td align="center" width="10%">
                                                                        <?php
                                                                        if (isset($gradesStorageData[$i])) {
                                                                            if (is_array($gradesStorageData[$i]) && count($gradesStorageData[$i]) > 0) {
                                                                                echo $gradesStorageData[$i];
                                                                            } else if ((is_array($gradesStorageData[$i]) && count($gradesStorageData[$i]) == 0)) {
                                                                                echo '';
                                                                            } else if ($gradesStorageData[$i] != '') {
                                                                                echo $gradesStorageData[$i];
                                                                            }
                                                                        }
                                                                        else
                                                                            echo "Nil";
                                                                        ?>

                                                                    </td>
                                                                    <td align="center" width="10%"><?php echo $mineralsStorageData[$i]['opening_stock']; ?></td>
                                                                    <td align="center" colspan="3" width="39%">
                                                                        <table cellpadding="0" cellspacing="0" class="f5-sub-table-print" style="border:0.1px solid black">
                                                                            <?php for ($sup = 1; $sup <= $showStorageData[$i]['supplier']['suppliercount']; $sup++) { ?>
                                                                                <tr>  
                                                                                    <td align="center" width="47%" style="border-right:0.1px solid black"><?php echo $showStorageData[$i]['supplier']['registration_no_' . $sup]; ?></td>
                                                                                    <td align="center" width="28%" style="border-right:0.1px solid black"><?php echo $showStorageData[$i]['supplier']['quantity_' . $sup]; ?></td>
                                                                                    <td align="center" width="26%"><?php echo $showStorageData[$i]['supplier']['value_' . $sup]; ?></td>
                                                                                </tr>
                                                                            <?php } ?> 
                                                                        </table>
                                                                    </td>
                                                                    <td align="center" colspan="3" width="30%">
                                                                        <table cellpadding="0" cellspacing="0" class="f5-sub-table-print" style="border:0.1px solid black">
                                                                            <?php for ($imp = 1; $imp <= $showStorageData[$i]['importData']['importcount']; $imp++) { ?>
                                                                                <tr>  
                                                                                    <td align="center" width="30%" style="border-right:0.1px solid black"><?php echo $showStorageData[$i]['importData']['country_name_' . $imp]; ?></td>
                                                                                    <td align="center" width="36%" style="border-right:0.1px solid black"><?php echo $showStorageData[$i]['importData']['quantity_' . $imp]; ?></td>
                                                                                    <td align="center" width="30%"><?php echo $showStorageData[$i]['importData']['value_' . $imp]; ?></td>
                                                                                </tr>
                                                                            <?php } ?> 
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr><td style=""height="5px"></td></tr>
                                            <tr style="font-size: 12px"><td style="height:5px" align="center">(d) Storage Activity continues...</td></tr>
                                            <tr>
                                                <td align="center">
                                                    <table width="100%" cellspacing="0" cellpadding="4">
                                                        <tbody>
                                                            <tr>
                                                                <td width="10%"></td>
                                                                <td width="65%" align="center" border="1" class="form-table-title" colspan="3"><strong>Ore despatched during the Month </strong></td>
                                                                <td width="15%" align="center" border="1" class="form-table-title" colspan="1"><strong>Closing stock </strong></td>
                                                                <td width="10%"></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="10%"></td>
                                                                <td width="35%" align="center" border="1" class="form-table-title"><strong>Registration number as allotted by the Indian Bureau of Mines to the person/company to whom ore despatched (to indicate separately if more than one person/company)</strong></td>
                                                                <td width="15%" align="center" border="1" class="form-table-title"><strong>Quantity</strong></td>
                                                                <td width="15%" align="center" border="1" class="form-table-title"><strong>Value</strong></td>
                                                                <td width="15%" align="center" border="1" class="form-table-title"><strong>Quantity</strong></td>
                                                                <td width="10%"></td>
                                                            </tr> 
                                                            <?php for ($i = 0; $i < count($mineralsStorageData); $i++) { ?>
                                                                <tr style="font-size:9px">
                                                                    <td></td>
                                                                    <td align="center" colspan="3" border="1">
                                                                        <table cellpadding="0" cellspacing="0" class="f5-sub-table-print" style="border:0.1px solid black">
                                                                            <?php for ($sup = 1; $sup <= $showStorageData[$i]['despatch']['despatchcount']; $sup++) { ?>
                                                                                <tr>  
                                                                                    <td align="center" width="53%" style="border-right:0.1px solid black"><?php echo $showStorageData[$i]['despatch']['registration_no_' . $sup]; ?></td>
                                                                                    <td align="center" width="24%" style="border-right:0.1px solid black"><?php echo $showStorageData[$i]['despatch']['quantity_' . $sup]; ?></td>
                                                                                    <td align="center" width="23%"><?php echo $showStorageData[$i]['despatch']['value_' . $sup]; ?></td>
                                                                                </tr>
                                                                            <?php } ?> 
                                                                        </table>
                                                                    </td>
                                                                    <td align="center" border="1"><?php echo $mineralsStorageData[$i]['closing_stock']; ?></td>
                                                                    <td></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr><td height="5px"></td></tr>
                                            <!----------END CODE FOR THE TRADING ,EXPORT , MINERAL BASED , STORAGE --------------->
                                            
                                            <?php
                                            if ($returnType == 'ANNUAL') {
                                                if ($activityType == 'C') {
                                                    ?>
                                                    <br pagebreak="true" />
                                                    
                                                    <!-- End-use Mineral Based Industries - I -->
                                                    <tr style="font-size: 10px"><td style="height:5px" align="center"><b>3. INFORMATION REGARDING END-USE MINERAL BASED INDUSTRIES (OTHER THAN IRON AND STEEL INDUSTRY</b></td></tr>
                                                    <tr>
                                                        <td align="left">
                                                            <table width="100%" cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;" class="f_s_10">
                                                                <tr>
                                                                    <td width="14%"><strong>(i) Name of industry:</strong></td>
                                                                    <td align="left">
                                                                        <?php
                                                                        if ($mineralIndustrial['industryname1'] == 'other') {
                                                                            echo $mineralIndustrial['otherind'];
                                                                        } else {
                                                                            echo $mineralIndustrial['industryname1'];
                                                                        };
                                                                        ?>
                                                                    </td>
                                                                    <td align="left">Name of Plant</td>
                                                                    <td align="left" colspan="3"><?php echo $addressDetails[0]['mcmcd_nameofplant']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left"> State</td>
                                                                    <td align="left"><?php echo $addressDetails[0]['mcmd_state']; ?></td>
                                                                    <td align="left"><span>District</span></td>
                                                                    <td align="left"><?php echo $regionAndDistrictName['district_name']; ?></td>
                                                                    <td align="left"><span>Location</span></td>
                                                                    <td align="left" class="lable-text"><?php echo $latiLongiDetails['latitude'] . " " . $latiLongiDetails['longitude']; ?></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr><td></td></tr>
                                                    <!-- End of End-use Mineral Based Industries - I -->
                                                    
                                                    <!-- End-use Mineral Based Industries - II -->
                                                    <tr style="font-size: 10px"><td style="height:5px" align="center"><b>(iii)DETAILS ON PRODUCTS MANUFACTURED WITH THEIR CAPACITIES AND PRODUCTION</b></td></tr>
                                                    <tr>
                                                        <td align="left">
                                                            <table width="100%" cellspacing="0" cellpadding="4" bordercolor="#E5D0BD" border="1" style="border-collapse:collapse;" class="f_s_10">
                                                                <tr>
                                                                    <td align="center"   rowspan="2" colspan="3">Products</td>
                                                                    <td width="18%" align="center"   rowspan="2">Annual installed
                                                                        capacity<br>
                                                                        (in Tonnes)
                                                                    </td>
                                                                    <td align="center"   colspan="2">Production ( in Tonnes)</td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center"  >Previous financial year <br /></td>
                                                                    <td align="center"  >Present financial year <br /></td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" align="center" class="lable-text" colspan="3">(1)</td>
                                                                    <td valign="top" align="center" class="lable-text">(2)</td>
                                                                    <td valign="top" align="center" class="lable-text">(3)</td>
                                                                    <td valign="top" align="center" class="lable-text">(4)</td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" align="left" class="lable-text" colspan="6">FINISHED PRODUCTS</td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" align="center" class="lable-text" colspan="3">
                                                                        <?php
                                                                        for ($fp = 1; $fp <= $mineralData['finishedProductCount']; $fp++) {
                                                                            ?>
                                                                            <table width="100%" cellspacing="0" cellpadding="4"   border="1" style="border-collapse:collapse;">
                                                                                <tr id="finished_Product_1_tr">
                                                                                    <td>
                                                                                        <?php echo $mineralData['finished_Product_' . $fp] ? $mineralData['finished_Product_' . $fp] : ""; ?>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        <?php } ?>
                                                                    </td>
                                                                    <td valign="top" align="center" class="lable-text">
                                                                        <?php for ($fc = 1; $fc <= $mineralData['finishedProductCount']; $fc++) { ?>
                                                                            <table width="100%" cellspacing="0" cellpadding="4"   border="1" style="border-collapse:collapse;">
                                                                                <tr id="finished_Capacity_1_tr">
                                                                                    <td>
                                                                                        <?php echo $mineralData['finished_Capacity_' . $fc] ? $mineralData['finished_Capacity_' . $fc] : ""; ?>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        <?php } ?>
                                                                    </td>
                                                                    <td valign="top" align="center" class="lable-text">
                                                                        <?php for ($fprev = 1; $fprev <= $mineralData['finishedProductCount']; $fprev++) { ?>
                                                                            <table width="100%" cellspacing="0" cellpadding="4"   border="1" style="border-collapse:collapse;">
                                                                                <tr id="finished_Previous_1_tr">
                                                                                    <td>
                                                                                        <?php echo $mineralData['finished_Previous_' . $fprev] ? $mineralData['finished_Previous_' . $fprev] : ""; ?>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        <?php } ?>
                                                                    </td>
                                                                    <td valign="top" align="center" class="lable-text">
                                                                        <?php for ($fpres = 1; $fpres <= $mineralData['finishedProductCount']; $fpres++) { ?>
                                                                            <table width="100%" cellspacing="0" cellpadding="4"   border="1" style="border-collapse:collapse;">
                                                                                <tr id="finished_Present_1_tr">
                                                                                    <td>
                                                                                        <?php echo $mineralData['finished_Present_' . $fpres] ? $mineralData['finished_Present_' . $fpres] : ""; ?>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        <?php } ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" align="left" class="lable-text" colspan="6">INTERMEDIATE PRODUCTS</td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" align="center" class="lable-text" colspan="3">
                                                                        <table width="100%" cellspacing="0" cellpadding="4"   border="1" style="border-collapse:collapse;">
                                                                            <?php for ($inter = 1; $inter <= $mineralData['interProductCount']; $inter++) { ?>
                                                                                <tr id="intermediate_Product_1_tr">
                                                                                    <td>
                                                                                        <?php echo $mineralData['intermediate_Product_' . $inter] ? $mineralData['intermediate_Product_' . $inter] : ""; ?>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        </table>
                                                                    </td>
                                                                    <td valign="top" align="center" class="lable-text">
                                                                        <table width="100%" cellspacing="0" cellpadding="4"   border="1" style="border-collapse:collapse;">
                                                                            <?php for ($interc = 1; $interc <= $mineralData['interProductCount']; $interc++) { ?>
                                                                                <tr id="intermediate_Capacity_1_tr">
                                                                                    <td>
                                                                                        <?php echo $mineralData['intermediate_Capacity_' . $interc] ? $mineralData['intermediate_Capacity_' . $interc] : ""; ?>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        </table>
                                                                    </td>
                                                                    <td valign="top" align="center" class="lable-text">
                                                                        <table width="100%" cellspacing="0" cellpadding="4"   border="1" style="border-collapse:collapse;">
                                                                            <?php for ($interPrev = 1; $interPrev <= $mineralData['interProductCount']; $interPrev++) { ?>
                                                                                <tr id="intermediate_Previous_1_tr">
                                                                                    <td>
                                                                                        <?php echo $mineralData['intermediate_Previous_' . $interPrev] ? $mineralData['intermediate_Previous_' . $interPrev] : ""; ?>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        </table>
                                                                    </td>
                                                                    <td valign="top" align="center" class="lable-text">
                                                                        <table width="100%" cellspacing="0" cellpadding="4"   border="1" style="border-collapse:collapse;">
                                                                            <?php for ($interPres = 1; $interPres <= $mineralData['interProductCount']; $interPres++) { ?>
                                                                                <tr id="intermediate_Present_1_tr">
                                                                                    <td>
                                                                                        <?php echo $mineralData['intermediate_Present_' . $interPres] ? $mineralData['intermediate_Present_' . $interPres] : ""; ?>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" align="left" class="lable-text" colspan="6">BY-PRODUCTS</td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" align="center" class="lable-text" colspan="3">
                                                                        <table width="100%" cellspacing="0" cellpadding="4"   border="1" style="border-collapse:collapse;">
                                                                            <?php for ($byProd = 1; $byProd <= $mineralData['byProductCount']; $byProd++) { ?>
                                                                                <tr id="byProducts_Product_1_tr">
                                                                                    <td>
                                                                                        <?php echo $mineralData['byProducts_Product_' . $byProd] ? $mineralData['byProducts_Product_' . $byProd] : ""; ?>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        </table>
                                                                    </td>
                                                                    <td valign="top" align="center" class="lable-text">
                                                                        <table width="100%" cellspacing="0" cellpadding="4"   border="1" style="border-collapse:collapse;">
                                                                            <?php for ($byProdC = 1; $byProdC <= $mineralData['byProductCount']; $byProdC++) { ?>
                                                                                <tr id="byProducts_Capacity_1_tr">
                                                                                    <td>
                                                                                        <?php echo $mineralData['byProducts_Capacity_' . $byProdC] ? $mineralData['byProducts_Capacity_' . $byProdC] : ""; ?>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        </table>
                                                                    </td>
                                                                    <td valign="top" align="center" class="lable-text">
                                                                        <table width="100%" cellspacing="0" cellpadding="4"   border="1" style="border-collapse:collapse;">
                                                                            <?php for ($byProdPrev = 1; $byProdPrev <= $mineralData['byProductCount']; $byProdPrev++) { ?>
                                                                                <tr id="byProducts_Previous_1_tr">
                                                                                    <td>
                                                                                        <?php echo $mineralData['byProducts_Previous_' . $byProdPrev] ? $mineralData['byProducts_Previous_' . $byProdPrev] : ""; ?>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        </table>
                                                                    </td>
                                                                    <td valign="top" align="center" class="lable-text">
                                                                        <table width="100%" cellspacing="0" cellpadding="4"   border="1" style="border-collapse:collapse;">
                                                                            <?php for ($byProdPres = 1; $byProdPres <= $mineralData['byProductCount']; $byProdPres++) { ?>
                                                                                <tr id="byProducts_Present_1_tr">
                                                                                    <td>
                                                                                        <?php echo $mineralData['byProducts_Present_' . $byProdPres] ? $mineralData['byProducts_Present_' . $byProdPres] : ""; ?>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table width="100%" cellspacing="0" cellpadding="4" border="1" style="border-collapse:collapse;" class="f_s_10">
                                                                <tr>
                                                                    <td width="39%" valign="top" align="left" class="lable-text">(iv)Expansion programme undertaken and<br>progress made during the year</td>
                                                                    <td width="62.2%" valign="top" align="left" class="lable-text ">
                                                                        <?php echo $mineralData['expansion_under']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" align="left" class="lable-text ">(v) Expansion programme/Plan<br>envisaged for future</td>
                                                                    <td valign="top" align="left" class="lable-text">
                                                                        <?php echo $mineralData['expansion_program']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" align="left" class="lable-text">(vi)  Research &amp; Development programme<br>carried out during the year (give details)</td>
                                                                    <td valign="top" align="left" class="lable-text">
                                                                        <?php echo $mineralData['research_develop']; ?>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table width="100%" cellspacing="0" cellpadding="4"   border="0" style="border-collapse:collapse;">
                                                                <tr>
                                                                    <td align="center"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center"></td> 
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <!-- End of End-use Mineral Based Industries - II -->
                                                    
                                                    <!--  INFORMATION REGARDING IRON & STEEL INDUSTRY----->
                                                    <br pagebreak="true" />
                                                    <tr style="font-size: 10px"><td style="height:5px" align="center"><b>4. INFORMATION REGARDING IRON & STEEL INDUSTRY</b></td></tr>
                                                    <tr>
                                                        <td>
                                                            <div align="center" class="welcome-page-name style4 f_s_10" style="padding-top: 10px; padding-bottom: 10px">
                                                                (iv)&nbsp;PRODUCTS MANUFACTURED WITH THEIR CAPACITY AND PRODUCTION
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left">
                                                            <table width="100%" cellspacing="0" cellpadding="1"   border="1" style="border-collapse:collapse;" class="f_s_10">
                                                                <tr>
                                                                    <td width="25%" valign="top" align="center"  >Products</td>
                                                                    <td width="20%" valign="top" align="center"  >
                                                                        Installed capacity in tonnes</td>
                                                                    <td width="30%" valign="top" align="center"   colspan="2">Production in tonnes</td>
                                                                    <td width="28%" valign="top" align="center"  >Remarks</td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" align="center"  >&nbsp;</td>
                                                                    <td valign="top" align="center"  >&nbsp;</td>
                                                                    <td valign="top" align="center"  >
                                                                        Previous financial year
                                                                    </td>
                                                                    <td valign="top" align="center"  >
                                                                        Present<br/>financial year
                                                                    </td>
                                                                    <td valign="top" align="center"  >&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" align="right" class="lable-text">
                                                                        <table width="100%" cellspacing="0" cellpadding="4"   border="0" style="border-collapse:collapse;">
                                                                            <tr>
                                                                                <td align="left" colspan="2">(a) Sinter</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td width="25%">&nbsp;&nbsp;&nbsp;i)&nbsp;</td>
                                                                                <td width="80%" align="left"> Self fluxing</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_anual_capacity_1']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prev_year_prod_1']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['pres_year_prod_1']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_remark_1']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="middle" align="right" class="lable-text">
                                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                            <tr>
                                                                                <td width="25%">&nbsp;&nbsp;&nbsp;ii)&nbsp;</td>
                                                                                <td width="80%" align="left">Ordinary</td>
                                                                            </tr>
                                                                        </table>
                                                                        <br/>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_anual_capacity_2']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prev_year_prod_2']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['pres_year_prod_2']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_remark_2']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="middle" align="left" class="lable-text">(b) Pellets</td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_anual_capacity_3']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prev_year_prod_3']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['pres_year_prod_3']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_remark_3']; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td align="left" class="lable-text">
                                                                        <table width="100%" cellspacing="0" cellpadding="4"   border="0" style="border-collapse:collapse;">
                                                                            <tr>
                                                                                <td align="left" colspan="2">(c) Coal</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td width="25%">&nbsp;&nbsp;&nbsp;i)&nbsp;</td>
                                                                                <td width="80%" align="left"> Clean coal </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_anual_capacity_4']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prev_year_prod_4']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['pres_year_prod_4']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_remark_4']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="47" align="left" class="lable-text">
                                                                        <table width="100%" cellspacing="0" cellpadding="4"   border="0" style="border-collapse:collapse;">
                                                                            <tr>
                                                                                <td width="25%" valign="top">&nbsp;&nbsp;&nbsp;ii)&nbsp;</td>
                                                                                <td width="80%" align="left">Coke (own production)</td>
                                                                            </tr>
                                                                        </table>     
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_anual_capacity_5']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prev_year_prod_5']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['pres_year_prod_5']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_remark_5']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="47" align="left" class="lable-text">
                                                                        <table width="100%" cellspacing="0" cellpadding="4"   border="0" style="border-collapse:collapse;">
                                                                            <tr>
                                                                                <td valign="top" align="left" colspan="2">(d) Pig iron </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td valign="top">&nbsp;</td>
                                                                                <td align="left">&nbsp;</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td width="25%" valign="top">&nbsp;&nbsp;&nbsp;i)&nbsp;</td>
                                                                                <td width="80%" align="left">Hot metal (total)</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_anual_capacity_6']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prev_year_prod_6']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['pres_year_prod_6']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_remark_6']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="49" align="left" class="lable-text">
                                                                        <table width="100%" cellspacing="0" cellpadding="4"   border="0" style="border-collapse:collapse;">
                                                                            <tr>
                                                                                <td width="25%" valign="top">&nbsp;&nbsp;&nbsp;ii)&nbsp;</td>
                                                                                <td width="80%" align="left">Hot metal <br/> for own consumption.</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_anual_capacity_7']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prev_year_prod_7']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['pres_year_prod_7']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_remark_7']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="47" align="left" class="lable-text">
                                                                        <table width="100%" cellspacing="0" cellpadding="4"   border="0" style="border-collapse:collapse;">
                                                                            <tr>
                                                                                <td width="25%" valign="top">&nbsp;&nbsp;&nbsp;iii)&nbsp;</td>
                                                                                <td width="80%" align="left"> Pig iron for sale </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_anual_capacity_8']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prev_year_prod_8']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['pres_year_prod_8']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_remark_8']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left" class="lable-text">
                                                                        <table width="100%" cellspacing="0" cellpadding="4"   border="0" style="border-collapse:collapse;">
                                                                            <tr>
                                                                                <td valign="top" colspan="2">(e) Sponge Iron</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td width="25%" valign="top">&nbsp;</td>
                                                                                <td width="80%" align="left">&nbsp;</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_anual_capacity_9']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prev_year_prod_9']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['pres_year_prod_9']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_remark_9']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="49" align="left" class="lable-text">
                                                                        <table width="100%" cellspacing="0" cellpadding="4"   border="0" style="border-collapse:collapse;">
                                                                            <tr>
                                                                                <td valign="top" align="left">(f) Hot Briquetted Iron</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_anual_capacity_10']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prev_year_prod_10']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['pres_year_prod_10']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_remark_10']; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td align="left" class="lable-text">
                                                                        <table width="100%" cellspacing="0" cellpadding="4"   border="0" style="border-collapse:collapse;">
                                                                            <tr>
                                                                                <td valign="top" colspan="2">(g) Steel</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td valign="top">&nbsp;</td>
                                                                                <td align="left">&nbsp;</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td width="25%" valign="top">&nbsp;&nbsp;&nbsp;i)&nbsp;</td>
                                                                                <td width="80%" align="left"> Liquid Steel/ Crude Steel </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_anual_capacity_11']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prev_year_prod_11']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['pres_year_prod_11']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_remark_11']; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td align="left" class="lable-text">
                                                                        <table width="100%" cellspacing="0" cellpadding="4"   border="0" style="border-collapse:collapse;">
                                                                            <tr>
                                                                                <td width="25%" valign="top">&nbsp;&nbsp;&nbsp;ii)&nbsp;</td>
                                                                                <td width="80%" align="left"> Total Saleable Steel </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td valign="top">&nbsp;</td>
                                                                                <td align="left">&nbsp;</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td width="25%" valign="top">&nbsp;</td>
                                                                                <td width="80%" align="left">&nbsp;&nbsp;&nbsp;a)&nbsp;Semi-finished<br> 
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Steel </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_anual_capacity_12']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prev_year_prod_12']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['pres_year_prod_12']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_remark_12']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="47" align="left" class="lable-text">
                                                                        <table width="100%" cellspacing="0" cellpadding="4"   border="0.1" style="border-collapse:collapse;">
                                                                            <tr>
                                                                                <td width="100%" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b)&nbsp;Finished Steel </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_anual_capacity_13']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prev_year_prod_13']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['pres_year_prod_13']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_remark_13']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="middle" align="left" class="lable-text">(h) Tin plates</td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_anual_capacity_14']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prev_year_prod_14']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['pres_year_prod_14']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_remark_14']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="middle" align="left" class="lable-text">(i) Sulphuric acid</td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_anual_capacity_15']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prev_year_prod_15']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['pres_year_prod_15']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_remark_15']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="middle" align="left" class="lable-text">(j) Refractories/bricks<br>
                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <?php echo $ironData['prod_name_16']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_anual_capacity_16']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prev_year_prod_16']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['pres_year_prod_16']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_remark_16']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="middle" align="left" class="lable-text">(k) Fertilizers <br>
                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <?php echo $ironData['prod_name_17']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_anual_capacity_17']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prev_year_prod_17']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['pres_year_prod_17']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_remark_17']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="middle" align="left" class="lable-text">(l) Any other<br>
                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;product/<br>
                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;by-product<br>
                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <?php echo $ironData['prod_name_18']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_anual_capacity_18']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prev_year_prod_18']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['pres_year_prod_18']; ?>
                                                                    </td>
                                                                    <td valign="middle" align="center" class="lable-text">
                                                                        <?php echo $ironData['prod_remark_18']; ?>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table width="100%" cellspacing="0" cellpadding="4"   border="1" style="border-collapse:collapse;" class="f_s_10">
                                                                <tr>
                                                                    <td width="22%" valign="top" align="left" class="lable-text">Coke purchased (in tonnes)</td>
                                                                    <td width="9%" valign="top" align="left" class="lable-text">Previous year </td>
                                                                    <td width="18%" valign="top" align="left" class="lable-text">
                                                                        <?php echo $ironData['prev_year_prod_19']; ?>
                                                                    </td>
                                                                    <td width="10%" valign="top" align="left" class="lable-text">Present Year </td>
                                                                    <td width="44%" valign="top" align="left" class="lable-text">
                                                                        <?php echo $ironData['pres_year_prod_19']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" align="left" class="lable-text">Expansion programme undertaken and<br>
                                                                        progress made during the year</td>
                                                                    <td valign="middle" align="left" class="lable-text" colspan="4">
                                                                        <?php echo $ironData['current_expansion_prog']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" align="left" class="lable-text">Expansion programme/Plan<br>
                                                                        envisaged for future</td>
                                                                    <td valign="middle" align="left" class="lable-text" colspan="4">
                                                                        <?php echo $ironData['future_expansion_prog']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" align="left" class="lable-text">Research &amp; Development programme carried out during the year (give details)</td>
                                                                    <td valign="middle" align="left" class="lable-text" colspan="4">
                                                                        <?php echo $ironData['research_prog']; ?>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <!--  END of INFORMATION REGARDING IRON & STEEL INDUSTRY----->
                                                    
                                                    <!-- Raw Material Consumed In Production -->
                                                    <br pagebreak="true" />
                                                    <tr style="font-size: 10px"><td style="height:5px" align="center">5. DETAILS OF RAW MATERIALS CONSUMED IN PRODUCTION(Including Electricity, Coal, and Petroleum Products)</td></tr>
                                                    <tr>
                                                        <td align="left">
                                                            <table width="100%" cellspacing="0" cellpadding="4"   border="1" style="border-collapse:collapse;" id="raw_Material_Consumed_table" class="f_s_8">
                                                                <tr>
                                                                    <td width="40%" align="center"   rowspan="2" colspan="3">Raw material</td>
                                                                    <td width="35%" valign="top" align="center"   colspan="4">
                                                                        Actual Consumption (In Tonnes)
                                                                    </td>
                                                                    <td width="25%" valign="top" align="center"   colspan="2">
                                                                        Estimated requirement<br/> (In Tonnes)
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" align="center"   colspan="2">
                                                                        Previous financial year
                                                                    </td>
                                                                    <td valign="top" align="center"   colspan="2">
                                                                        Present financial year
                                                                    </td>
                                                                    <td valign="top" align="center"   rowspan="2">
                                                                        Next financial year
                                                                    </td>
                                                                    <td valign="top" align="center"   rowspan="2">
                                                                        Next to
                                                                        Next
                                                                        financial
                                                                        year
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="20%" valign="top" align="center"  >Mineral/Ore/Metal/Ferroalloy</td>
                                                                    <td width="10%" valign="top" align="center"  >Physical Specification</td>
                                                                    <td width="10%" valign="top" align="center"  >Chemical Specification</td>
                                                                    <td width="10%" valign="top" align="center"  >Indigenous</td>
                                                                    <td width="7.5%" valign="top" align="center"  >Imported</td>
                                                                    <td width="10%" valign="top" align="center"  >Indigenous</td>
                                                                    <td width="7.5%" valign="top" align="center"  >Imported</td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center" class="lable-text" colspan="3">(1)</td>
                                                                    <td align="center" class="lable-text" colspan="2">(2)</td>
                                                                    <td align="center" class="lable-text" colspan="2">(3)</td>
                                                                    <td align="center" class="lable-text">(4)</td>
                                                                    <td align="center" class="lable-text">(5)</td>
                                                                </tr>

                                                                <?php for ($i = 1; $i <= $rawMatdata['totalCount']; $i++) { ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo $rawMatdata['raw_mineral_' . $i]; ?>
                                                                            <?php echo (isset($mineralWithUnitArr[$rawMatdata['raw_mineral_' . $i]])) ? "(" . $mineralWithUnitArr[$rawMatdata['raw_mineral_' . $i]] . ")" : ""; ?>
                                                                        </td>
                                                                        <td><?php echo $rawMatdata['rawmat_physpe_' . $i]; ?></td>
                                                                        <td><?php echo $rawMatdata['rawmat_chespe_' . $i]; ?></td>


                                                                        <td><?php echo $rawMatdata['rawmat_prv_ind_' . $i]; ?></td>
                                                                        <td><?php echo $rawMatdata['rawmat_prv_imp_' . $i]; ?></td>

                                                                        <td><?php echo $rawMatdata['rawmat_pre_ind_' . $i]; ?></td>
                                                                        <td><?php echo $rawMatdata['rawmat_pre_imp_' . $i]; ?></td>

                                                                        <td align="center" >
                                                                            <?php echo $rawMatdata['rawmat_nex_fin_yr_' . $i]; ?>
                                                                        </td>
                                                                        <td align="center">
                                                                            <?php echo $rawMatdata['rawmat_nextonex_fin_yr_' . $i]; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>

                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <!-- End of Raw Material Consumed In Production -->
                                                    
                                                    <!-- Source Of Supply -->
                                                    <br pagebreak="true" />
                                                    <tr style="font-size: 10px"><td style="height:5px" align="left">&nbsp;&nbsp;&nbsp;6.Source Of Supply</td></tr>
                                                    <tr>
                                                        <td align="left">
                                                            <table width="100%" cellspacing="0" cellpadding="4"   border="1" style="border-collapse:collapse;" class="f_s_7">
                                                                <tr>
                                                                    <td width="10%" align="center"   rowspan="3">Type</td>
                                                                    <td width="10%" align="center"   rowspan="3">
                                                                        Mineral/<br/>Ore/<br/>Metal<br/>/Ferro-Alloy
                                                                    </td>
                                                                    <td width="80%" valign="top" align="center"   colspan="8">
                                                                        Indigenous
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="8%" valign="top" align="center"    rowspan="2">
                                                                        Name &amp; <br/>address of <br/>supplier
                                                                    </td>
                                                                    <td width="16%" valign="top" align="center"   colspan="2">
                                                                        Source of <br/>supply<br/>(mine or<br/> area)
                                                                    </td>
                                                                    <td width="20%" valign="top" align="center"   rowspan="2">
                                                                        Indicate <br/>the <br/>distance <br/>of mine/<br/>rail <br/>to plant <br/>(in km.)
                                                                    </td>
                                                                    <td width="22%" valign="top" align="center"   colspan="2">
                                                                        Transportation cost <br/>
                                                                        per tonne by Rail/Road
                                                                    </td>
                                                                    <td width="8%" valign="top" align="center"   rowspan="2">
                                                                        Quantity<br/>(metric tonnes.)
                                                                    </td>
                                                                    <td width="6%" valign="top" align="center"   rowspan="2">
                                                                        Price per metric <br/>tonnes. at factory site<br/>
                                                                        (in &#8377;)
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="bottom" align="center"  >&nbsp;</td>
                                                                    <td valign="bottom" align="center"  >&nbsp;</td>
                                                                    <td width="8%" valign="bottom" align="center"  >Mode</td>
                                                                    <td width="14%" valign="bottom" align="center"  >
                                                                        Cost per tonne <br/> 
                                                                        (in &#8377;)
                                                                    </td>
                                                                </tr>
                                                                <?php for ($source = 1; $source <= $sourceData['totalCount']; $source++) { ?>
                                                                    <tr>
                                                                        <td align="center">
                                                                            <?php echo $sourceData['sour_indus_' . $source] ? $sourceData['sour_indus_' . $source] : 'NA'; ?>
                                                                        </td>
                                                                        <td align="center">
                                                                            <?php echo $sourceData['sour_mineral_' . $source] ? $sourceData['sour_mineral_' . $source] : 'NA'; ?>
                                                                            <?php echo (isset($mineralWithUnitArr[$sourceData['sour_mineral_' . $source]])) ? "(" . $mineralWithUnitArr[$sourceData['sour_mineral_' . $source]] . ")" : ""; ?>
                                                                        </td>
                                                                        <td valign="top" align="center">
                                                                            <?php echo $sourceData['sour_name_add_' . $source] ? $sourceData['sour_name_add_' . $source] : 'NA'; ?>
                                                                        </td>
                                                                        <td valign="top" align="center">
                                                                            <?php echo $sourceData['sour_mine_area_' . $source] ? $sourceData['sour_mine_area_' . $source] : 'NA'; ?>
                                                                        </td>
                                                                        <td valign="top" align="center">
                                                                            <?php echo $sourceData['sour_mine_area_dist_' . $source] ? $sourceData['sour_mine_area_dist_' . $source] : 'NA'; ?>
                                                                        </td>
                                                                        <td valign="top" align="center">
                                                                            <?php echo $sourceData['sour_ind_dis_' . $source] ? $sourceData['sour_ind_dis_' . $source] : 'NA'; ?>
                                                                        </td>
                                                                        <td valign="top" align="center">
                                                                            <?php echo $sourceData['sour_tran_mode_' . $source] ? $sourceData['sour_tran_mode_' . $source] : 'NA'; ?>
                                                                        </td>
                                                                        <td valign="top" align="center">
                                                                            <?php echo $sourceData['sour_tran_cost_' . $source] ? $sourceData['sour_tran_cost_' . $source] : 'NA'; ?>
                                                                        </td>
                                                                        <td valign="top" align="center">
                                                                            <?php echo $sourceData['sour_qty_' . $source] ? $sourceData['sour_qty_' . $source] : 'NA'; ?>
                                                                        </td>
                                                                        <td valign="top" align="center">
                                                                            <?php echo $sourceData['sour_price_' . $source] ? $sourceData['sour_price_' . $source] : 'NA'; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr><td></td></tr>
                                                    <tr style="font-size: 10px"><td style="height:5px" align="left">&nbsp;&nbsp;&nbsp;6.Source Of Supply continues...</td></tr>
                                                    <tr>
                                                        <td align="left">
                                                            <table width="100%" cellspacing="0" cellpadding="4"   border="1" style="border-collapse:collapse;" class="f_s_10">
                                                                <tr>
                                                                    <td width="12%" align="center"   rowspan="3">Type</td>
                                                                    <td width="13%" align="center"   rowspan="3">
                                                                        Mineral/<br/>Ore/<br/>Metal<br/>/Ferro-Alloy
                                                                    </td>
                                                                    <td width="75%" valign="top" align="center"   colspan="4">
                                                                        Imported
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="20%" valign="top" align="center"   colspan="2">
                                                                        Name &amp; <br/>complete address of supplier (country wise)
                                                                    </td>
                                                                    <td width="12%" valign="top" align="center"   rowspan="2">
                                                                        Quantity purchased (metric tonnes)
                                                                    </td>
                                                                    <td width="43%" valign="top" align="center"   rowspan="2">
                                                                        Cost per metric tonne at factory site<br/>
                                                                        (in &#8377;)
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" align="center"  >Address</td>
                                                                    <td valign="top" align="center"  >Country</td>
                                                                </tr>
                                                                <?php for ($source = 1; $source <= $sourceData['totalCount']; $source++) { ?>
                                                                    <tr>
                                                                        <td align="center">
                                                                            <?php echo $sourceData['sour_indus_' . $source] ? $sourceData['sour_indus_' . $source] : 'NA'; ?>
                                                                        </td>
                                                                        <td align="center">
                                                                            <?php echo $sourceData['sour_mineral_' . $source] ? $sourceData['sour_mineral_' . $source] : 'NA'; ?>
                                                                            <?php echo (isset($mineralWithUnitArr[$sourceData['sour_mineral_' . $source]])) ? "(" . $mineralWithUnitArr[$sourceData['sour_mineral_' . $source]] . ")" : ""; ?>
                                                                        </td>
                                                                        <td valign="top" align="center">
                                                                            <?php echo $sourceData['sour_supplier_add_' . $source] ? $sourceData['sour_supplier_add_' . $source] : 'NA'; ?>
                                                                        </td>
                                                                        <td valign="top" align="center">
                                                                            <?php echo $sourceData['sour_supplier_country_' . $source] ? $sourceData['sour_supplier_country_' . $source] : 'NA'; ?>
                                                                        </td>
                                                                        <td valign="top" align="center">
                                                                            <?php echo $sourceData['sour_qty_purch_' . $source] ? $sourceData['sour_qty_purch_' . $source] : 'NA'; ?>
                                                                        </td>
                                                                        <td valign="top" align="center">
                                                                            <?php echo $sourceData['sour_cost_metric_' . $source] ? $sourceData['sour_cost_metric_' . $source] : 'NA'; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <!-- End of Source Of Supply -->

                                                    <?php 
                                                }
                                            }
                                            ?>
                                            
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
        <!-- <br pagebreak="true" /> -->
    
        <table style="margin-left:40px;width:100%" border="0">
            <tr><td></td></tr>
            <tr><td></td></tr>
            <tr><td></td></tr>
            <tr><td></td></tr>
            <tr><td></td></tr>
            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td width="5%"></td>
                            <td style="text-align:justify;font-size:11px" width="90%">I, ............................................. S/o/D/o/W/o ................................................. age .......... occupation ............................................. resident of ................................................... village/town/city/post-office ............................................................ police station .................................................. taluka .................................................... district ............................................. state ............................................. certify that the information furnished above is complete and correct in all respect.
                            </td>
                            <td width="5%"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td></td></tr>
            <tr><td></td></tr>
            <tr>
                <td>
                    <table width="100%" style="font-size:12px">
                        <tr>
                            <td width="5%"></td>
                            <td width="40%" align="left">Place : <?php echo ucwords(strtolower($placeTemp)); ?></td>
                            <td width="5%"></td>
                            <td width="45%" align="left">Signature</td>
                            <td width="5%"></td>
                        </tr>
                        <tr>
                            <td width="5%"></td>
                            <td align="left">Date : <?php echo $printAllDate; ?></td>
                            <td></td>
                            <td align="left">Name : <?php echo $fillerName; ?></td>
                            <td width="5%"></td>
                        </tr>
                        <tr>
                            <td width="5%"></td>
                            <td></td>
                            <td></td>
                            <td align="left">Designation: <?php echo $mcu_design; ?></td>
                            <td width="5%"></td>
                        </tr>
                        <tr>
                            <td width="5%"></td>
                            <td></td>
                            <td></td>
                            <td align="left">Owner / Agent / Mining Engineer / Manager</td>
                            <td width="5%"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td width="100%" style="text-align:center;font-size:11px;">
                    <b><i><?php echo $ipTimeFormat; ?></i></b>
                </td>
            </tr>
            <tr><td></td></tr>
            <tr><td></td></tr>
        </table>
    </td>
</tr>

<style type="text/css">
.form-table-title {
    font-size: 10px;
}
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
.f_s_7 {
    font-size: 7px;
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