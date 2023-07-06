
<style>
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

<div class="container">
    <table class="table">
        <tbody>
            <tr style="text-align:center" class="l_h_15">
                <th>
                    <span class="f_s_11"><strong><?php echo $pdfLabel['title']['form']; ?></strong></span><br>
                    <span class="f_s_10"><strong><?php echo $pdfLabel['title']['for']; ?></strong></span><br>
                    <span class="f_s_11"><strong><?php echo $pdfLabel['title']['return']; ?></strong></span><br>
                    <span class="f_s_10"><?php echo $pdfLabel['title']['rule']; ?></span>
                </th>
            </tr>
            <tr>
                <td align="left">
                    <span style="margin-left:50px; text-align:left; font-size: 11px;"> <br />
                        <?php echo $pdfLabel['to']['to']; ?>,
                        <ol type="i" class="f_s_10">
                            <li><?php echo $pdfLabel['to']['address'][0]; ?></li>
                            <li><?php echo $pdfLabel['to']['address'][1]; ?><br />
                                <?php echo $pdfLabel['to']['address'][2]; ?>,<br />
                                <?php echo ucwords(strtolower($printAllRegion)); ?> <?php echo $pdfLabel['to']['address'][3]; ?>,<br /><br />
                                <?php echo $pdfLabel['to']['address'][4]; ?> <?php echo $pinCode; ?><br />
                                <?php echo $pdfLabel['to']['address'][5]; ?>
                            </li><br />
                            <li><?php echo $pdfLabel['to']['address'][6]; ?></li>
                        </ol>
                    </span>
                </td>
            </tr>
            
            <!-- GENERAL PARTICULARS -->
            <tr>
                <td align="center">
                    <div id="details_maines">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="left" class="f_s_10 f_b">&nbsp;&nbsp;<?php echo $label['genp']['part']; ?></td>
                            </tr>
                            <tr>
                                <td align="left" valign="top">
                                    <table width="100%" border="0.5" class="f_s_10" cellpadding="4" cellspacing="0" nobr="true">
                                        <tbody>
                                            <tr>
                                                <td><b><?php echo $label['genp'][0]; ?></b></td>
                                                <td><?php echo $data['genp']['regNO']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="v_a_base"><b><?php echo $label['genp'][1]; ?></b></td>
                                                <td><?php echo $data['genp']['fullName']; ?><br><?php echo $data['genp']['appAdd'][0]["mcappd_address1"] ? $data['genp']['appAdd'][0]["mcappd_address1"] . ",<br/>" : "" ?>
                                                    <?php echo $data['genp']['appAdd'][0]["mcappd_address2"] ? $data['genp']['appAdd'][0]["mcappd_address2"] . ",<br/>" : "" ?>
                                                    <?php echo $data['genp']['appAdd'][0]["mcappd_address3"] ? $data['genp']['appAdd'][0]["mcappd_address3"] . ",<br/>" : "" ?>
                                                    <?php echo $data['genp']['appAdd'][0]["mcappd_state"]; ?>
                                                    <?php echo $data['genp']['appAdd'][0]["mcappd_district"]; ?>
                                                    <?php echo $data['genp']['appAdd'][0]["mcappd_pincode"] ? $data['genp']['appAdd'][0]["mcappd_pincode"] : "" ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b><?php echo $label['genp'][2]; ?></b></td>
                                                <!--CHANGED WITH THE NOV CODE  UDAYSHANKAR SINGH 16TH JAN 2014-->
                                                <td><?php echo $data['genp']['addressDetails'][0]['mcmcd_nameofplant'] ? $data['genp']['addressDetails'][0]['mcmcd_nameofplant'] . ",<br/>" : ""; ?><?php echo $data['genp']['addressDetails'][0]['mcmd_village'] ? $data['genp']['addressDetails'][0]['mcmd_village'] . ",<br/>" : ""; ?>
                                                    <?php echo $data['genp']['addressDetails'][0]['mcmd_tehsil'] ? $data['genp']['addressDetails'][0]['mcmd_tehsil'] . ",<br/>" : ""; ?>
                                                    <?php echo (isset($data['genp']['regionAndDistrictName'][0]['district_name'])) ? $data['genp']['regionAndDistrictName'][0]['district_name'] . ",<br/>" : (isset($data['genp']['regionAndDistrictName']['district_name']) ? $data['genp']['regionAndDistrictName']['district_name'] . ",<br/>" : ""); ?>
                                                    <?php echo $data['genp']['addressDetails'][0]['mcmd_state'] ? $data['genp']['addressDetails'][0]['mcmd_state'] : ''; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b><?php echo $label['genp'][3]; ?></b></td>
                                                <td><?php
                                                    if ($data['genp']['activityType']== 'C' || $data['genp']['activityType']== 'S'){
                                                        echo $data['genp']['latiLongiDetails']['latitude'] . " " . $data['genp']['latiLongiDetails']['longitude'];
                                                    } else {
                                                        echo "NA";
                                                    }
                                                ?></td>
                                            </tr>
                                            <tr>
                                                <td><b><?php echo $label['genp'][4]; ?></b></td>
                                                <td><?php echo $data['genp']['currActivity']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>                    
                                </td>
                            </tr>
                            <tr><td></td></tr>
                        </table>
                    </div>
                </td>
            </tr>

            
            <!-- TRADING ACTIVITY -->
            <tr>
                <td align="center">
                    <div id="details_maines">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" nobr="true">
                            <tr>
                                <td align="center" class="f_s_10 f_b"><?php echo strtoupper($label['genp']['next_part']); ?> <?php echo strtoupper($returnMonthShort)." ".$returnYear; ?></td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" class="f_s_9">
                                        <thead class="thead-light text-center">
                                            <tr>
                                                <th colspan="9" class="f_s_10 f_b"><?php echo $label['ta']['title']; ?></th>
                                            </tr>
                                            <tr>
                                                <th rowspan="2"><?php echo $label['ta'][0]; ?></th>
                                                <th rowspan="2"><?php echo $label['ta'][1]; ?></th>
                                                <th><?php echo $label['ta'][2]; ?></th>
                                                <th colspan="3"><?php echo $label['ta'][3]; ?></th>
                                                <th colspan="3"><?php echo $label['ta'][4]; ?></th>
                                            </tr>
                                            <tr>
                                                <th><?php echo $label['ta'][7]; ?></th>
                                                <th width="12.1%"><?php echo $label['ta'][8]; ?></th>
                                                <th width="10.2%"><?php echo $label['ta'][7]; ?></th>
                                                <th width="11%"><?php echo $label['ta'][9]; ?></th>
                                                <th width="12.1%"><?php echo $label['ta'][10]; ?></th>
                                                <th width="10.2%"><?php echo $label['ta'][7]; ?></th>
                                                <th width="11%"><?php echo $label['ta'][9]; ?></th>
                                            </tr>
                                        </thead>
                                        <tbody class="main_tbody f_s_8">
                                            <?php 
                                            
                                            $min_rw = 0;
                                            foreach($data['ta']['tradingAc']['mineralsData'] as $key=>$val){ 
                                                $keyN = $key+1;
                                                $min_rw_span = $data['ta']['min_row_span'][$key];

                                                if($min_rw_span > 0){
                                                    $m_rw = 1; //main row
                                                    $min_rw++; //mineral row
                                                    $btn_rem = ($key != 0) ? '<i class="fa fa-times btn-rem btn_rem_mineral"></i>' : '';
                                                ?>
                                                    <tr id="c_row_<?php echo $min_rw; ?>" class="c_row_<?php echo $min_rw.'_'.$m_rw; ?> main_tr c_row">
                                                        <td rowspan="<?php echo $min_rw_span; ?>">
                                                            <?php echo $val['local_mineral_code']; ?> <?php echo ($val['mineral_unit']!='') ? "(".$val['mineral_unit'].")" : ""; ?>
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
                                                ?>
                                                    <td>
                                                        <?php echo (isset($data['ta']['min_grade_arr'][$key][$val['local_grade_code']])) ? $data['ta']['min_grade_arr'][$key][$val['local_grade_code']] : 'NIL'; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $val['opening_stock']; ?>
                                                    </td>
                                                    <td colspan="3">
                                                        <table border="0.5" id="supplier_table_<?php echo $mrw_id; ?>_1" class="trad_ac_grade_tbl table table-borderless">
                                                            <tbody>
                                                                <?php 
                                                                $sup = $data['ta']['tradingAc']['gradeforMineral'][$key]['supplier'];
                                                                $sup_cnt = $sup['suppliercount'];
                                                                for($rw=1; $rw<=$sup_cnt; $rw++){ ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo $sup['registration_no_'.$rw]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $sup['quantity_'.$rw]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $sup['value_'.$rw]; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                        <?php echo $this->Form->control('purchase_cnt_'.$mrw_id, array('type'=>'hidden', 'id'=>'purchase_cnt_'.$mrw_id, 'value'=>$sup_cnt)); ?>
                                                    </td>
                                                    <td colspan="3">
                                                        <table border="0.5" id="import_table_<?php echo $mrw_id; ?>_1" class="trad_ac_import_tbl table table-borderless">
                                                            <tbody>
                                                                <?php 
                                                                $imp = $data['ta']['tradingAc']['gradeforMineral'][$key]['importData'];
                                                                $imp_cnt = $imp['importcount'];
                                                                for($rw=1; $rw<=$imp_cnt; $rw++){ ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo $imp['country_name_'.$rw]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $imp['quantity_'.$rw]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $imp['value_'.$rw]; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                        <?php echo $this->Form->control('import_cnt_'.$mrw_id, array('type'=>'hidden', 'id'=>'import_cnt_'.$mrw_id, 'value'=>$imp_cnt)); ?>
                                                    </td>
                                                </tr>
                                            
                                            <?php } ?>
                                        </tbody>
                                    </table>                    
                                </td>
                            </tr>
                            <tr><td></td></tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" class="f_s_9">
                                        <thead class="thead-light text-center">
                                            <tr>
                                                <th colspan="6" class="f_s_10 f_b"><?php echo $label['ta']['title_next']; ?></th>
                                            </tr>
                                            <tr>
                                                <th rowspan="2"><?php echo $label['ta'][0]; ?></th>
                                                <th rowspan="2"><?php echo $label['ta'][1]; ?></th>
                                                <th colspan="3"><?php echo $label['ta'][5]; ?></th>
                                                <th><?php echo $label['ta'][6]; ?></th>
                                            </tr>
                                            <tr>
                                                <th width="17.5%"><?php echo $label['ta'][11]; ?></th>
                                                <th width="15.8%"><?php echo $label['ta'][7]; ?></th>
                                                <th width="16.7%"><?php echo $label['ta'][9]; ?></th>
                                                <th><?php echo $label['ta'][7]; ?></th>
                                            </tr>
                                        </thead>
                                        <tbody class="main_tbody f_s_8">
                                            <?php 
                                            
                                            $min_rw = 0;
                                            foreach($data['ta']['tradingAc']['mineralsData'] as $key=>$val){ 
                                                $keyN = $key+1;
                                                $min_rw_span = $data['ta']['min_row_span'][$key];

                                                if($min_rw_span > 0){
                                                    $m_rw = 1; //main row
                                                    $min_rw++; //mineral row
                                                    $btn_rem = ($key != 0) ? '<i class="fa fa-times btn-rem btn_rem_mineral"></i>' : '';
                                                ?>
                                                    <tr id="c_row_<?php echo $min_rw; ?>" class="c_row_<?php echo $min_rw.'_'.$m_rw; ?> main_tr c_row">
                                                        <td rowspan="<?php echo $min_rw_span; ?>">
                                                            <?php echo $val['local_mineral_code']; ?> <?php echo ($val['mineral_unit']!='') ? "(".$val['mineral_unit'].")" : ""; ?>
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
                                                ?>
                                                    <td>
                                                        <?php echo (isset($data['ta']['min_grade_arr'][$key][$val['local_grade_code']])) ? $data['ta']['min_grade_arr'][$key][$val['local_grade_code']] : 'NIL'; ?>
                                                    </td>
                                                    <td colspan="3">
                                                        <table border="0.5" id="buyer_table_<?php echo $mrw_id; ?>_1" class="trad_ac_buyer_tbl table table-borderless">
                                                            <tbody>
                                                                <?php 
                                                                $desp = $data['ta']['tradingAc']['gradeforMineral'][$key]['despatch'];
                                                                $desp_cnt = $desp['despatchcount'];
                                                                for($rw=1; $rw<=$desp_cnt; $rw++){ ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo $desp['registration_no_'.$rw]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $desp['quantity_'.$rw]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $desp['value_'.$rw]; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                        <?php echo $this->Form->control('despatch_cnt_'.$mrw_id, array('type'=>'hidden', 'id'=>'despatch_cnt_'.$mrw_id, 'value'=>'1')); ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $val['closing_stock']; ?>
                                                    </td>
                                                </tr>
                                            
                                            <?php } ?>
                                        </tbody>
                                    </table>                    
                                </td>
                            </tr>
                            <tr><td></td></tr>
                        </table>
                    </div>
                </td>
            </tr>

            
            <!-- EXPORT ACTIVITY -->
            <br pagebreak="true" />
            <tr>
                <td align="center">
                    <div id="details_maines">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center" valign="top">
                                    <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" class="f_s_9">
                                        <thead class="thead-light text-center">
                                            <tr>
                                                <th colspan="9" class="f_s_10 f_b"><?php echo $label['ea']['title']; ?></th>
                                            </tr>
                                            <tr>
                                                <th rowspan="2"><?php echo $label['ea'][0]; ?></th>
                                                <th rowspan="2"><?php echo $label['ea'][1]; ?></th>
                                                <th><?php echo $label['ea'][2]; ?></th>
                                                <th colspan="3"><?php echo $label['ea'][3]; ?></th>
                                                <th colspan="3"><?php echo $label['ea'][4]; ?></th>
                                            </tr>
                                            <tr>
                                                <th><?php echo $label['ea'][7]; ?></th>
                                                <th width="12.1%"><?php echo $label['ea'][8]; ?></th>
                                                <th width="10.2%"><?php echo $label['ea'][7]; ?></th>
                                                <th width="11%"><?php echo $label['ea'][9]; ?></th>
                                                <th width="12.1%"><?php echo $label['ea'][10]; ?></th>
                                                <th width="10.2%"><?php echo $label['ea'][7]; ?></th>
                                                <th width="11%"><?php echo $label['ea'][9]; ?></th>
                                            </tr>
                                        </thead>
                                        <tbody class="main_tbody f_s_8">
                                            <?php 
                                            
                                            $min_rw = 0;
                                            foreach($data['ea']['tradingAc']['mineralsData'] as $key=>$val){ 
                                                $keyN = $key+1;
                                                $min_rw_span = $data['ea']['min_row_span'][$key];

                                                if($min_rw_span > 0){
                                                    $m_rw = 1; //main row
                                                    $min_rw++; //mineral row
                                                    $btn_rem = ($key != 0) ? '<i class="fa fa-times btn-rem btn_rem_mineral"></i>' : '';
                                                ?>
                                                    <tr id="c_row_<?php echo $min_rw; ?>" class="c_row_<?php echo $min_rw.'_'.$m_rw; ?> main_tr c_row">
                                                        <td rowspan="<?php echo $min_rw_span; ?>">
                                                            <?php echo $val['local_mineral_code']; ?> <?php echo ($val['mineral_unit']!='') ? "(".$val['mineral_unit'].")" : ""; ?>
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
                                                ?>
                                                    <td>
                                                        <?php echo (isset($data['ea']['min_grade_arr'][$key][$val['local_grade_code']])) ? $data['ea']['min_grade_arr'][$key][$val['local_grade_code']] : "NIL"; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $val['opening_stock']; ?>
                                                    </td>
                                                    <td colspan="3">
                                                        <table border="0.5" id="supplier_table_<?php echo $mrw_id; ?>_1" class="trad_ac_grade_tbl table table-borderless">
                                                            <tbody>
                                                                <?php 
                                                                $sup = $data['ea']['tradingAc']['gradeforMineral'][$key]['supplier'];
                                                                $sup_cnt = $sup['suppliercount'];
                                                                for($rw=1; $rw<=$sup_cnt; $rw++){ ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo $sup['registration_no_'.$rw]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $sup['quantity_'.$rw]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $sup['value_'.$rw]; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                        <?php echo $this->Form->control('purchase_cnt_'.$mrw_id, array('type'=>'hidden', 'id'=>'purchase_cnt_'.$mrw_id, 'value'=>$sup_cnt)); ?>
                                                    </td>
                                                    <td colspan="3">
                                                        <table border="0.5" id="import_table_<?php echo $mrw_id; ?>_1" class="trad_ac_import_tbl table table-borderless">
                                                            <tbody>
                                                                <?php 
                                                                $imp = $data['ea']['tradingAc']['gradeforMineral'][$key]['importData'];
                                                                $imp_cnt = $imp['importcount'];
                                                                for($rw=1; $rw<=$imp_cnt; $rw++){ ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo $imp['country_name_'.$rw]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $imp['quantity_'.$rw]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $imp['value_'.$rw]; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                        <?php echo $this->Form->control('import_cnt_'.$mrw_id, array('type'=>'hidden', 'id'=>'import_cnt_'.$mrw_id, 'value'=>$imp_cnt)); ?>
                                                    </td>
                                                </tr>
                                            
                                            <?php } ?>
                                        </tbody>
                                    </table>                    
                                </td>
                            </tr>
                            <tr><td></td></tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" class="f_s_9" nobr="true">
                                        <thead class="thead-light text-center">
                                            <tr>
                                                <th colspan="6" class="f_s_10 f_b"><?php echo $label['ea']['title_next']; ?></th>
                                            </tr>
                                            <tr>
                                                <th rowspan="2"><?php echo $label['ea'][0]; ?></th>
                                                <th rowspan="2"><?php echo $label['ea'][1]; ?></th>
                                                <th colspan="3"><?php echo $label['ea'][5]; ?></th>
                                                <th><?php echo $label['ea'][6]; ?></th>
                                            </tr>
                                            <tr>
                                                <th width="17.5%"><?php echo $label['ea'][10]; ?></th>
                                                <th width="15.8%"><?php echo $label['ea'][7]; ?></th>
                                                <th width="16.7%"><?php echo $label['ea'][9]; ?></th>
                                                <th><?php echo $label['ea'][7]; ?></th>
                                            </tr>
                                        </thead>
                                        <tbody class="main_tbody f_s_8">
                                            <?php 
                                            
                                            $min_rw = 0;
                                            foreach($data['ea']['tradingAc']['mineralsData'] as $key=>$val){ 
                                                $keyN = $key+1;
                                                $min_rw_span = $data['ea']['min_row_span'][$key];

                                                if($min_rw_span > 0){
                                                    $m_rw = 1; //main row
                                                    $min_rw++; //mineral row
                                                    $btn_rem = ($key != 0) ? '<i class="fa fa-times btn-rem btn_rem_mineral"></i>' : '';
                                                ?>
                                                    <tr id="c_row_<?php echo $min_rw; ?>" class="c_row_<?php echo $min_rw.'_'.$m_rw; ?> main_tr c_row">
                                                        <td rowspan="<?php echo $min_rw_span; ?>">
                                                            <?php echo $val['local_mineral_code']; ?> <?php echo ($val['mineral_unit']!='') ? "(".$val['mineral_unit'].")" : ""; ?>
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
                                                ?>
                                                    <td>
                                                        <?php echo (isset($data['ea']['min_grade_arr'][$key][$val['local_grade_code']])) ? $data['ea']['min_grade_arr'][$key][$val['local_grade_code']] : "NIL"; ?>
                                                    </td>
                                                    <td colspan="3">
                                                        <table border="0.5" id="buyer_table_<?php echo $mrw_id; ?>_1" class="trad_ac_buyer_tbl table table-borderless">
                                                            <tbody>
                                                                <?php 
                                                                $desp = $data['ea']['tradingAc']['gradeforMineral'][$key]['despatch'];
                                                                $desp_cnt = $desp['despatchcount'];
                                                                for($rw=1; $rw<=$desp_cnt; $rw++){ ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo $desp['registration_no_'.$rw]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $desp['quantity_'.$rw]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $desp['value_'.$rw]; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                        <?php echo $this->Form->control('despatch_cnt_'.$mrw_id, array('type'=>'hidden', 'id'=>'despatch_cnt_'.$mrw_id, 'value'=>'1')); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $val['closing_stock']; ?>
                                                    </td>
                                                </tr>
                                            
                                            <?php } ?>
                                        </tbody>
                                    </table>                    
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>

            
            <!-- MINERAL BASED ACTIVITY -->
            <br pagebreak="true" />
            <tr>
                <td align="center">
                    <div id="details_maines">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center" valign="top">
                                    <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" class="f_s_9" nobr="true">
                                        <thead class="thead-light text-center">
                                            <tr>
                                                <th colspan="9" class="f_s_10 f_b"><?php echo $label['mba']['title']; ?></th>
                                            </tr>
                                            <tr>
                                                <th rowspan="2"><?php echo $label['mba'][0]; ?></th>
                                                <th rowspan="2"><?php echo $label['mba'][1]; ?></th>
                                                <th><?php echo $label['mba'][2]; ?></th>
                                                <th colspan="3"><?php echo $label['mba'][3]; ?></th>
                                                <th colspan="3"><?php echo $label['mba'][4]; ?></th>
                                            </tr>
                                            <tr>
                                                <th><?php echo $label['mba'][7]; ?></th>
                                                <th width="12.1%"><?php echo $label['mba'][8]; ?></th>
                                                <th width="10.2%"><?php echo $label['mba'][7]; ?></th>
                                                <th width="11%"><?php echo $label['mba'][9]; ?></th>
                                                <th width="12.1%"><?php echo $label['mba'][10]; ?></th>
                                                <th width="10.2%"><?php echo $label['mba'][7]; ?></th>
                                                <th width="11%"><?php echo $label['mba'][9]; ?></th>
                                            </tr>
                                        </thead>
                                        <tbody class="main_tbody f_s_8">
                                            <?php 
                                            
                                            $min_rw = 0;
                                            foreach($data['mba']['tradingAc']['mineralsData'] as $key=>$val){ 
                                                $keyN = $key+1;
                                                $min_rw_span = $data['mba']['min_row_span'][$key];

                                                if($min_rw_span > 0){
                                                    $m_rw = 1; //main row
                                                    $min_rw++; //mineral row
                                                    $btn_rem = ($key != 0) ? '<i class="fa fa-times btn-rem btn_rem_mineral"></i>' : '';
                                                ?>
                                                    <tr id="c_row_<?php echo $min_rw; ?>" class="c_row_<?php echo $min_rw.'_'.$m_rw; ?> main_tr c_row">
                                                        <td rowspan="<?php echo $min_rw_span; ?>">
                                                            <?php echo $val['local_mineral_code']; ?> <?php echo ($val['mineral_unit']!='') ? "(".$val['mineral_unit'].")" : ""; ?>
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
                                                ?>
                                                    <td>
                                                        <?php echo (isset($data['mba']['min_grade_arr'][$key][$val['local_grade_code']])) ? $data['mba']['min_grade_arr'][$key][$val['local_grade_code']] : "NIL"; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $val['opening_stock']; ?>
                                                    </td>
                                                    <td colspan="3">
                                                        <table id="supplier_table_<?php echo $mrw_id; ?>_1" border="0.5" class="trad_ac_grade_tbl table table-borderless">
                                                            <tbody>
                                                                <?php 
                                                                $sup = $data['mba']['tradingAc']['gradeforMineral'][$key]['supplier'];
                                                                $sup_cnt = $sup['suppliercount'];
                                                                for($rw=1; $rw<=$sup_cnt; $rw++){ ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo $sup['registration_no_'.$rw]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $sup['quantity_'.$rw]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $sup['value_'.$rw]; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                        <?php echo $this->Form->control('purchase_cnt_'.$mrw_id, array('type'=>'hidden', 'id'=>'purchase_cnt_'.$mrw_id, 'value'=>$sup_cnt)); ?>
                                                    </td>
                                                    <td colspan="3">
                                                        <table id="import_table_<?php echo $mrw_id; ?>_1" border="0.5" class="trad_ac_import_tbl table table-borderless">
                                                            <tbody>
                                                                <?php 
                                                                $imp = $data['mba']['tradingAc']['gradeforMineral'][$key]['importData'];
                                                                $imp_cnt = $imp['importcount'];
                                                                for($rw=1; $rw<=$imp_cnt; $rw++){ ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo $imp['country_name_'.$rw]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $imp['quantity_'.$rw]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $imp['value_'.$rw]; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                        <?php echo $this->Form->control('import_cnt_'.$mrw_id, array('type'=>'hidden', 'id'=>'import_cnt_'.$mrw_id, 'value'=>$imp_cnt)); ?>
                                                    </td>

                                                </tr>
                                            
                                            <?php } ?>
                                        </tbody>
                                    </table>                    
                                </td>
                            </tr>
                            <tr><td></td></tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" class="f_s_9" nobr="true">
                                        <thead class="thead-light text-center">
                                            <tr>
                                                <th colspan="8" class="f_s_10 f_b"><?php echo $label['mba']['title_next']; ?></th>
                                            </tr>
                                            <tr>
                                                <th rowspan="2"><?php echo $label['mba'][0]; ?></th>
                                                <th rowspan="2"><?php echo $label['mba'][1]; ?></th>
                                                <?php if($data['mba']['sec_no'] == 3){ ?>
                                                    <th colspan="2"><?php echo $label['mba'][12]; ?></th>
                                                <?php } ?>
                                                <th colspan="3"><?php echo $label['mba'][5]; ?></th>
                                                <th><?php echo $label['mba'][6]; ?></th>
                                            </tr>
                                            <tr>
                                                <?php if($data['mba']['sec_no'] == 3){ ?>
                                                    <th><?php echo $label['mba'][7]; ?></th>
                                                    <th><?php echo $label['mba'][9]; ?></th>
                                                <?php } ?>
                                                <th width="13.3%"><?php echo $label['mba'][11]; ?></th>
                                                <th width="11.7%"><?php echo $label['mba'][7]; ?></th>
                                                <th width="12.5%"><?php echo $label['mba'][9]; ?></th>
                                                <th><?php echo $label['mba'][7]; ?></th>
                                            </tr>
                                        </thead>
                                        <tbody class="main_tbody f_s_8">
                                            <?php 
                                            
                                            $min_rw = 0;
                                            foreach($data['mba']['tradingAc']['mineralsData'] as $key=>$val){ 
                                                $keyN = $key+1;
                                                $min_rw_span = $data['mba']['min_row_span'][$key];

                                                if($min_rw_span > 0){
                                                    $m_rw = 1; //main row
                                                    $min_rw++; //mineral row
                                                    $btn_rem = ($key != 0) ? '<i class="fa fa-times btn-rem btn_rem_mineral"></i>' : '';
                                                ?>
                                                    <tr id="c_row_<?php echo $min_rw; ?>" class="c_row_<?php echo $min_rw.'_'.$m_rw; ?> main_tr c_row">
                                                        <td rowspan="<?php echo $min_rw_span; ?>">
                                                            <?php echo $val['local_mineral_code']; ?> <?php echo ($val['mineral_unit']!='') ? "(".$val['mineral_unit'].")" : ""; ?>
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
                                                ?>
                                                    <td>
                                                        <?php echo (isset($data['mba']['min_grade_arr'][$key][$val['local_grade_code']])) ? $data['mba']['min_grade_arr'][$key][$val['local_grade_code']] : "NIL"; ?>
                                                    </td>

                                                    <?php if($data['mba']['sec_no'] == 3){ $cons = $data['mba']['tradingAc']['gradeforMineral'][$key]['consumeData']; ?>

                                                        <td>
                                                            <?php echo $cons['quantity']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $cons['value']; ?>
                                                        </td>
                                                    
                                                    <?php } ?>

                                                    <td colspan="3">
                                                        <table border="0.5" id="buyer_table_<?php echo $mrw_id; ?>_1" class="trad_ac_buyer_tbl table table-borderless">
                                                            <tbody>
                                                                <?php 
                                                                $desp = $data['mba']['tradingAc']['gradeforMineral'][$key]['despatch'];
                                                                $desp_cnt = $desp['despatchcount'];
                                                                for($rw=1; $rw<=$desp_cnt; $rw++){ ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo $desp['registration_no_'.$rw]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $desp['quantity_'.$rw]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $desp['value_'.$rw]; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                        <?php echo $this->Form->control('despatch_cnt_'.$mrw_id, array('type'=>'hidden', 'id'=>'despatch_cnt_'.$mrw_id, 'value'=>'1')); ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $val['closing_stock']; ?>
                                                    </td>
                                                </tr>
                                            
                                            <?php } ?>
                                        </tbody>
                                    </table>                    
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>

            
            <!-- STORAGE ACTIVITY -->
            <tr>
                <td align="center">
                    <div id="details_maines">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center" valign="top">
                                    <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" class="f_s_9" nobr="true">
                                        <thead class="thead-light text-center">
                                            <tr>
                                                <th colspan="9" class="f_s_10 f_b"><?php echo $label['sa']['title']; ?></th>
                                            </tr>
                                            <tr>
                                                <th rowspan="2"><?php echo $label['sa'][0]; ?></th>
                                                <th rowspan="2"><?php echo $label['sa'][1]; ?></th>
                                                <th><?php echo $label['sa'][2]; ?></th>
                                                <th colspan="3"><?php echo $label['sa'][3]; ?></th>
                                                <th colspan="3"><?php echo $label['sa'][4]; ?></th>
                                            </tr>
                                            <tr>
                                                <th><?php echo $label['sa'][7]; ?></th>
                                                <th width="12.1%"><?php echo $label['sa'][8]; ?></th>
                                                <th width="10.2%"><?php echo $label['sa'][7]; ?></th>
                                                <th width="11%"><?php echo $label['sa'][9]; ?></th>
                                                <th width="12.1%"><?php echo $label['sa'][10]; ?></th>
                                                <th width="10.2%"><?php echo $label['sa'][7]; ?></th>
                                                <th width="11%"><?php echo $label['sa'][9]; ?></th>
                                            </tr>
                                        </thead>
                                        <tbody class="main_tbody f_s_8">
                                            <?php 
                                            
                                            $min_rw = 0;
                                            foreach($data['sa']['tradingAc']['mineralsData'] as $key=>$val){ 
                                                $keyN = $key+1;
                                                $min_rw_span = $data['sa']['min_row_span'][$key];

                                                if($min_rw_span > 0){
                                                    $m_rw = 1; //main row
                                                    $min_rw++; //mineral row
                                                    $btn_rem = ($key != 0) ? '<i class="fa fa-times btn-rem btn_rem_mineral"></i>' : '';
                                                ?>
                                                    <tr id="c_row_<?php echo $min_rw; ?>" class="c_row_<?php echo $min_rw.'_'.$m_rw; ?> main_tr c_row">
                                                        <td rowspan="<?php echo $min_rw_span; ?>">
                                                            <?php echo $val['local_mineral_code']; ?> <?php echo ($val['mineral_unit']!='') ? "(".$val['mineral_unit'].")" : ""; ?>
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
                                                ?>
                                                    <td>
                                                        <?php echo (isset($data['sa']['min_grade_arr'][$key][$val['local_grade_code']])) ? $data['sa']['min_grade_arr'][$key][$val['local_grade_code']] : "NIL"; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $val['opening_stock']; ?>
                                                    </td>
                                                    <td colspan="3">
                                                        <table border="0.5" id="supplier_table_<?php echo $mrw_id; ?>_1" class="trad_ac_grade_tbl table table-borderless">
                                                            <tbody>
                                                                <?php 
                                                                $sup = $data['sa']['tradingAc']['gradeforMineral'][$key]['supplier'];
                                                                $sup_cnt = $sup['suppliercount'];
                                                                for($rw=1; $rw<=$sup_cnt; $rw++){ ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo $sup['registration_no_'.$rw]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $sup['quantity_'.$rw]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $sup['value_'.$rw]; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                        <?php echo $this->Form->control('purchase_cnt_'.$mrw_id, array('type'=>'hidden', 'id'=>'purchase_cnt_'.$mrw_id, 'value'=>$sup_cnt)); ?>
                                                    </td>
                                                    <td colspan="3">
                                                        <table border="0.5" id="import_table_<?php echo $mrw_id; ?>_1" class="trad_ac_import_tbl table table-borderless">
                                                            <tbody>
                                                                <?php 
                                                                $imp = $data['sa']['tradingAc']['gradeforMineral'][$key]['importData'];
                                                                $imp_cnt = $imp['importcount'];
                                                                for($rw=1; $rw<=$imp_cnt; $rw++){ ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo $imp['country_name_'.$rw]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $imp['quantity_'.$rw]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $imp['value_'.$rw]; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                        <?php echo $this->Form->control('import_cnt_'.$mrw_id, array('type'=>'hidden', 'id'=>'import_cnt_'.$mrw_id, 'value'=>$imp_cnt)); ?>
                                                    </td>
                                                </tr>
                                            
                                            <?php } ?>
                                        </tbody>
                                    </table>                    
                                </td>
                            </tr>
                            <tr><td></td></tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table width="100%" border="0.5" cellpadding="4" cellspacing="0" bordercolor="#E5D0BD" class="f_s_9" nobr="true">
                                        <thead class="thead-light text-center">
                                            <tr>
                                                <th colspan="6" class="f_s_10 f_b"><?php echo $label['sa']['title_next']; ?></th>
                                            </tr>
                                            <tr>
                                                <th rowspan="2"><?php echo $label['sa'][0]; ?></th>
                                                <th rowspan="2"><?php echo $label['sa'][1]; ?></th>
                                                <th colspan="3"><?php echo $label['sa'][5]; ?></th>
                                                <th><?php echo $label['sa'][6]; ?></th>
                                            </tr>
                                            <tr>
                                                <th width="17.5%"><?php echo $label['sa'][11]; ?></th>
                                                <th width="15.8%"><?php echo $label['sa'][7]; ?></th>
                                                <th width="16.7%"><?php echo $label['sa'][9]; ?></th>
                                                <th><?php echo $label['sa'][7]; ?></th>
                                            </tr>
                                        </thead>
                                        <tbody class="main_tbody f_s_8">
                                            <?php 
                                            
                                            $min_rw = 0;
                                            foreach($data['sa']['tradingAc']['mineralsData'] as $key=>$val){ 
                                                $keyN = $key+1;
                                                $min_rw_span = $data['sa']['min_row_span'][$key];

                                                if($min_rw_span > 0){
                                                    $m_rw = 1; //main row
                                                    $min_rw++; //mineral row
                                                    $btn_rem = ($key != 0) ? '<i class="fa fa-times btn-rem btn_rem_mineral"></i>' : '';
                                                ?>
                                                    <tr id="c_row_<?php echo $min_rw; ?>" class="c_row_<?php echo $min_rw.'_'.$m_rw; ?> main_tr c_row">
                                                        <td rowspan="<?php echo $min_rw_span; ?>">
                                                            <?php echo $val['local_mineral_code']; ?> <?php echo ($val['mineral_unit']!='') ? "(".$val['mineral_unit'].")" : ""; ?>
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
                                                ?>
                                                    <td>
                                                        <?php echo (isset($data['sa']['min_grade_arr'][$key][$val['local_grade_code']])) ? $data['sa']['min_grade_arr'][$key][$val['local_grade_code']] : "NIL"; ?>
                                                    </td>
                                                    <td colspan="3">
                                                        <table border="0.5" id="buyer_table_<?php echo $mrw_id; ?>_1" class="trad_ac_buyer_tbl table table-borderless">
                                                            <tbody>
                                                                <?php 
                                                                $desp = $data['sa']['tradingAc']['gradeforMineral'][$key]['despatch'];
                                                                $desp_cnt = $desp['despatchcount'];
                                                                for($rw=1; $rw<=$desp_cnt; $rw++){ ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo $desp['registration_no_'.$rw]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $desp['quantity_'.$rw]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $desp['value_'.$rw]; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                        <?php echo $this->Form->control('despatch_cnt_'.$mrw_id, array('type'=>'hidden', 'id'=>'despatch_cnt_'.$mrw_id, 'value'=>'1')); ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $val['closing_stock']; ?>
                                                    </td>
                                                </tr>
                                            
                                            <?php } ?>
                                        </tbody>
                                    </table>                    
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            
            <!-- FORM M - End Use Mineral Based Industries(Part-I) -->
            <?php 
            if ($returnType == 'ANNUAL') {
                if ($data['genp']['activityType'] == 'C') {
                    ?> 
                    <br pagebreak="true" />
                    <tr>
                        <td align="center">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="left" class="f_s_10 f_b"><?php echo $label['mbi']['title']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top">
                                        <table width="100%" border="0.5" class="f_s_10" cellpadding="4" cellspacing="0" nobr="true">
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $label['mbi'][0]; ?></td>
                                                    <td><?php echo $data['mbi']['fetchData']['industryname1']; ?></td>
                                                    <td><?php echo $label['mbi'][1]; ?></td>
                                                    <td colspan="3"><?php echo $data['mbi']['addressDetails'][0]['mcmcd_nameofplant']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $label['mbi'][2]; ?></td>
                                                    <td><?php echo $data['mbi']['addressDetails'][0]['mcmd_state']; ?></td>
                                                    <td><?php echo $label['mbi'][3]; ?></td>
                                                    <td><?php echo $data['mbi']['regionAndDistrictName']['district_name']; ?></td>
                                                    <td><?php echo $label['mbi'][4]; ?></td>
                                                    <td><?php echo $data['mbi']['latiLongiDetails']['latitude'] . " " . $data['mbi']['latiLongiDetails']['longitude']; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr><td></td></tr>
                                <tr>
                                    <td align="left" class="f_s_10"><?php echo $label['pmd'][0]; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top">
                                        <table width="100%" border="0.5" class="f_s_10" cellpadding="4" cellspacing="0" nobr="true">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" class="text_cent"><?php echo $label['pmd'][1]; ?></th>
                                                    <th rowspan="2" class="text_cent"><?php echo $label['pmd'][2]; ?></th>
                                                    <th colspan="2" class="text_cent"><?php echo $label['pmd'][3]; ?></th>
                                                </tr>
                                                <tr>
                                                    <th class="text_cent"><?php echo $label['pmd'][4]; ?></th>
                                                    <th class="text_cent"><?php echo $label['pmd'][5]; ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text_cent">(1)</td>
                                                    <td class="text_cent">(2)</td>
                                                    <td class="text_cent">(3)</td>
                                                    <td class="text_cent">(4)</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"><?php echo $label['pmd'][6]; ?></td>
                                                </tr>
                                                <?php 
                                                $prod = $data['pmd']['mineralData'];
                                                $finProdCount = $prod['finishedProductCount'];
                                                for ($n = 1; $n <= $finProdCount; $n++) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $prod['finished_Product_'.$n]; ?></td>
                                                        <td><?php echo $prod['finished_Capacity_'.$n]; ?></td>
                                                        <td><?php echo $prod['finished_Previous_'.$n]; ?></td>
                                                        <td><?php echo $prod['finished_Present_'.$n]; ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                <tr>
                                                    <td colspan="4"><?php echo $label['pmd'][7]; ?></td>
                                                </tr>
                                                <?php 
                                                $intProdCount = $prod['interProductCount'];
                                                for ($m = 1; $m <= $intProdCount; $m++) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $prod['intermediate_Product_'.$m]; ?></td>
                                                        <td><?php echo $prod['intermediate_Capacity_'.$m]; ?></td>
                                                        <td><?php echo $prod['intermediate_Previous_'.$m]; ?></td>
                                                        <td><?php echo $prod['intermediate_Present_'.$m]; ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                <tr>
                                                    <td colspan="4"><?php echo $label['pmd'][8]; ?></td>
                                                </tr>
                                                <?php 
                                                $byProdCount = $prod['byProductCount'];
                                                for ($o = 1; $o <= $byProdCount; $o++) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $prod['byProducts_Product_'.$o]; ?></td>
                                                        <td><?php echo $prod['byProducts_Capacity_'.$o]; ?></td>
                                                        <td><?php echo $prod['byProducts_Previous_'.$o]; ?></td>
                                                        <td><?php echo $prod['byProducts_Present_'.$o]; ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                <tr>
                                                    <td colspan="3"><?php echo $label['pmd'][9]; ?></td>
                                                    <td><?php echo $data['pmd']['mineralData']['expansion_under']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><?php echo $label['pmd'][10]; ?></td>
                                                    <td><?php echo $data['pmd']['mineralData']['expansion_program']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><?php echo $label['pmd'][11]; ?></td>
                                                    <td><?php echo $data['pmd']['mineralData']['research_develop']; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <br pagebreak="true" />
                    <tr>
                        <td align="center">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr><td></td></tr>
                                <tr>
                                    <td align="left" class="f_s_10 f_b"><?php echo $label['isi']['title']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" class="f_s_10">(iii) <?php echo $label['isi'][1]; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top">
                                        <table width="100%" border="0.5" class="f_s_9" cellpadding="4" cellspacing="0" nobr="true">
                                            <thead>
                                                <tr class="f_s_10">
                                                    <th rowspan="2" class="text_cent" width="25%"><?php echo $label['isi'][2]; ?></th>
                                                    <th rowspan="2" class="text_cent" width="18%"><?php echo $label['isi'][3]; ?></th>
                                                    <th colspan="2" class="text_cent" width="36%"><?php echo $label['isi'][4]; ?></th>
                                                    <th rowspan="2" class="text_cent" width="20%"><?php echo $label['isi'][7]; ?></th>
                                                </tr>
                                                <tr>
                                                    <th class="text_cent"><?php echo $label['isi'][5]; ?></th>
                                                    <th class="text_cent"><?php echo $label['isi'][6]; ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="5">
                                                        <table class="table table-borderless mb-0">
                                                            <tr>
                                                                <td class="w_26p"><?php echo $label['isi']['a']; ?></td>
                                                                <td><?php echo $label['isi'][8]; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table class="table table-borderless mb-0">
                                                            <tr>
                                                                <td class="w_22p"></td>
                                                                <td class="w_22p">i)</td>
                                                                <td width="80%"><?php echo $label['isi'][9]; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_anual_capacity_1']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prev_year_prod_1']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['pres_year_prod_1']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_remark_1']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table class="table table-borderless mb-0">
                                                            <tr>
                                                                <td class="w_22p"></td>
                                                                <td class="w_22p">ii)</td>
                                                                <td width="80%"><?php echo $label['isi'][10]; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_anual_capacity_2']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prev_year_prod_2']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['pres_year_prod_2']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_remark_2']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table class="table table-borderless mb-0">
                                                            <tr>
                                                                <td class="w_26p"><?php echo $label['isi']['b']; ?></td>
                                                                <td><?php echo $label['isi'][11]; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_anual_capacity_3']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prev_year_prod_3']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['pres_year_prod_3']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_remark_3']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5">
                                                        <table class="table table-borderless mb-0">
                                                            <tr>
                                                                <td class="w_26p"><?php echo $label['isi']['c']; ?></td>
                                                                <td><?php echo $label['isi'][12]; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table class="table table-borderless mb-0">
                                                            <tr>
                                                                <td class="w_22p"></td>
                                                                <td class="w_22p">i)</td>
                                                                <td width="80%"><?php echo $label['isi'][13]; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_anual_capacity_4']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prev_year_prod_4']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['pres_year_prod_4']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_remark_4']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table class="table table-borderless mb-0">
                                                            <tr>
                                                                <td class="w_22p"></td>
                                                                <td class="w_22p">ii)</td>
                                                                <td width="80%"><?php echo $label['isi'][14]; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_anual_capacity_5']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prev_year_prod_5']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['pres_year_prod_5']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_remark_5']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5">
                                                        <table class="table table-borderless mb-0">
                                                            <tr>
                                                                <td class="w_26p"><?php echo $label['isi']['d']; ?></td>
                                                                <td><?php echo $label['isi'][15]; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table class="table table-borderless mb-0">
                                                            <tr>
                                                                <td class="w_22p"></td>
                                                                <td class="w_22p">i)</td>
                                                                <td width="80%"><?php echo $label['isi'][16]; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_anual_capacity_6']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prev_year_prod_6']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['pres_year_prod_6']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_remark_6']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table class="table table-borderless mb-0">
                                                            <tr>
                                                                <td class="w_22p"></td>
                                                                <td class="w_22p">ii)</td>
                                                                <td width="80%"><?php echo $label['isi'][17]; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_anual_capacity_7']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prev_year_prod_7']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['pres_year_prod_7']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_remark_7']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table class="table table-borderless mb-0">
                                                            <tr>
                                                                <td class="w_22p"></td>
                                                                <td class="w_22p">iii)</td>
                                                                <td width="80%"><?php echo $label['isi'][18]; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_anual_capacity_8']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prev_year_prod_8']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['pres_year_prod_8']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_remark_8']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table class="table table-borderless mb-0">
                                                            <tr>
                                                                <td class="w_26p"><?php echo $label['isi']['e']; ?></td>
                                                                <td width="80%"><?php echo $label['isi'][19]; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_anual_capacity_9']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prev_year_prod_9']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['pres_year_prod_9']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_remark_9']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table class="table table-borderless mb-0">
                                                            <tr>
                                                                <td class="w_26p"><?php echo $label['isi']['f']; ?></td>
                                                                <td width="80%"><?php echo $label['isi'][20]; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_anual_capacity_10']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prev_year_prod_10']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['pres_year_prod_10']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_remark_10']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5">
                                                        <table class="table table-borderless mb-0">
                                                            <tr>
                                                                <td class="w_26p"><?php echo $label['isi']['g']; ?></td>
                                                                <td><?php echo $label['isi'][21]; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table class="table table-borderless mb-0">
                                                            <tr>
                                                                <td class="w_22p"></td>
                                                                <td class="w_22p">i)</td>
                                                                <td width="80%"><?php echo $label['isi'][22]; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_anual_capacity_11']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prev_year_prod_11']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['pres_year_prod_11']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_remark_11']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5">
                                                        <table class="table table-borderless mb-0">
                                                            <tr>
                                                                <td class="w_22p"></td>
                                                                <td class="w_22p">ii)</td>
                                                                <td><?php echo $label['isi'][23]; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table class="table table-borderless mb-0">
                                                            <tr>
                                                                <td class="w_22p"></td>
                                                                <td class="w_22p"></td>
                                                                <td class="w_22p"><?php echo $label['isi']['a']; ?></td>
                                                                <td width="60%"><?php echo $label['isi'][24]; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_anual_capacity_12']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prev_year_prod_12']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['pres_year_prod_12']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_remark_12']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table class="table table-borderless mb-0">
                                                            <tr>
                                                                <td class="w_22p"></td>
                                                                <td class="w_22p"></td>
                                                                <td class="w_22p"><?php echo $label['isi']['b']; ?></td>
                                                                <td width="60%"><?php echo $label['isi'][25]; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_anual_capacity_13']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prev_year_prod_13']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['pres_year_prod_13']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_remark_13']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table class="table table-borderless mb-0">
                                                            <tr>
                                                                <td class="w_26p"><?php echo $label['isi']['h']; ?></td>
                                                                <td width="80%"><?php echo $label['isi'][26]; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_anual_capacity_14']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prev_year_prod_14']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['pres_year_prod_14']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_remark_14']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table class="table table-borderless mb-0">
                                                            <tr>
                                                                <td class="w_26p"><?php echo $label['isi']['i']; ?></td>
                                                                <td width="80%"><?php echo $label['isi'][27]; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_anual_capacity_15']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prev_year_prod_15']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['pres_year_prod_15']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_remark_15']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table class="table table-borderless mb-0">
                                                            <tr>
                                                                <td class="w_26p"><?php echo $label['isi']['j']; ?></td>
                                                                <td width="80%"><?php echo $label['isi'][28]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <?php echo $data['isi']['prod_name_16']; ?>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_anual_capacity_16']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prev_year_prod_16']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['pres_year_prod_16']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_remark_16']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table class="table table-borderless mb-0">
                                                            <tr>
                                                                <td class="w_26p"><?php echo $label['isi']['k']; ?></td>
                                                                <td width="80%"><?php echo $label['isi'][29]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <?php echo $data['isi']['prod_name_17']; ?>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_anual_capacity_17']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prev_year_prod_17']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['pres_year_prod_17']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_remark_17']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table class="table table-borderless mb-0">
                                                            <tr>
                                                                <td class="w_26p"><?php echo $label['isi']['l']; ?></td>
                                                                <td width="80%"><?php echo $label['isi'][30]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <?php echo $data['isi']['prod_name_18']; ?>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_anual_capacity_18']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prev_year_prod_18']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['pres_year_prod_18']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prod_remark_18']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="w-25"><?php echo $label['isi'][31]; ?></td>
                                                    <td>
                                                        <?php echo $label['isi'][32]; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['prev_year_prod_19']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $label['isi'][33]; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['isi']['pres_year_prod_19']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><?php echo $label['isi'][34]; ?></td>
                                                    <td colspan="2">
                                                        <?php $data['isi']['current_expansion_prog']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><?php echo $label['isi'][35]; ?></td>
                                                    <td colspan="2">
                                                        <?php echo $data['isi']['future_expansion_prog']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><?php echo $label['isi'][36]; ?></td>
                                                    <td colspan="2">
                                                        <?php echo $data['isi']['research_prog']; ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <br pagebreak="true" />
                    <!-- RAW MATERIAL CONSUMED IN PRODUCTION -->
                    <tr>
                        <td align="center">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr><td></td></tr>
                                <tr>
                                    <td align="left" class="f_s_10 f_b"><?php echo $label['rmc']['title']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top">
                                        <table width="100%" border="0.5" class="f_s_9" cellpadding="4" cellspacing="0" nobr="true">
                                            <thead>
                                                <tr class="f_s_10">
                                                    <th colspan="3" class="text_cent"><?php echo $label['rmc'][0]; ?></th>
                                                    <th colspan="4" class="text_cent"><?php echo $label['rmc'][1]; ?></th>
                                                    <th colspan="2" class="text_cent"><?php echo $label['rmc'][2]; ?></th>
                                                </tr>
                                                <tr class="f_s_10">
                                                    <th rowspan="2" class="text_cent"><?php echo $label['rmc'][3]; ?></th>
                                                    <th rowspan="2" class="text_cent"><?php echo $label['rmc'][4]; ?></th>
                                                    <th rowspan="2" class="text_cent"><?php echo $label['rmc'][5]; ?></th>
                                                    <th colspan="2" class="text_cent"><?php echo $label['rmc'][6]; ?></th>
                                                    <th colspan="2" class="text_cent"><?php echo $label['rmc'][7]; ?></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                <tr class="f_s_10">
                                                    <th class="text_cent"><?php echo $label['rmc'][10]; ?></th>
                                                    <th class="text_cent"><?php echo $label['rmc'][11]; ?></th>
                                                    <th class="text_cent"><?php echo $label['rmc'][10]; ?></th>
                                                    <th class="text_cent"><?php echo $label['rmc'][11]; ?></th>
                                                    <th class="text_cent"><?php echo $label['rmc'][8]; ?></th>
                                                    <th class="text_cent"><?php echo $label['rmc'][9]; ?></th>
                                                </tr>
                                                <tr class="f_s_10">
                                                    <th colspan="3" class="text_cent">(1)</th>
                                                    <th colspan="2" class="text_cent">(2)</th>
                                                    <th colspan="2" class="text_cent">(3)</th>
                                                    <th class="text_cent">(4)</th>
                                                    <th class="text_cent">(5)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                
		                                            $minOpt = $data['rmc']['mineralOptions']['returnValue'];
                                                    $minOpt[''] = '--';
                                                    $minOpt['NIL'] = 'NIL';
                                                    $rmc = $data['rmc']['rawMatdata'];
                                                    $count = $rmc['totalCount'];
                                                    for ($i = 1; $i <= $count; $i++) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $minOpt[$rmc['raw_mineral_'.$i]]; ?></td>
                                                            <td><?php echo $rmc['rawmat_physpe_'.$i]; ?></td>
                                                            <td><?php echo $rmc['rawmat_chespe_'.$i]; ?></td>
                                                            <td><?php echo $rmc['rawmat_prv_ind_'.$i]; ?></td>
                                                            <td><?php echo $rmc['rawmat_prv_imp_'.$i]; ?></td>
                                                            <td><?php echo $rmc['rawmat_pre_ind_'.$i]; ?></td>
                                                            <td><?php echo $rmc['rawmat_pre_imp_'.$i]; ?></td>
                                                            <td><?php echo $rmc['rawmat_nex_fin_yr_'.$i]; ?></td>
                                                            <td><?php echo $rmc['rawmat_nextonex_fin_yr_'.$i]; ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    
                                                ?>
                                                <tr>
                                                    <td colspan="9"><?php echo $label['rmc'][12]; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- SOURCE OF SUPPLY -->
                    <tr>
                        <td align="center">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr><td></td></tr>
                                <tr>
                                    <td align="left" class="f_s_10 f_b"><?php echo $label['sos']['title']; ?></td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top">
                                        <table width="100%" border="0.5" class="f_s_9" cellpadding="4" cellspacing="0" nobr="true">
                                            <thead>
                                                <tr class="f_s_10">
                                                    <th rowspan="3" class="text_cent"><?php echo $label['sos'][1]; ?></th>
                                                    <th rowspan="3" class="text_cent"><?php echo $label['sos'][2]; ?></th>
                                                    <th colspan="8" class="text_cent"><?php echo $label['sos'][3]; ?></th>
                                                </tr>
                                                <tr class="f_s_10">
                                                    <th rowspan="2" class="text_cent"><?php echo $label['sos'][5]; ?></th>
                                                    <th colspan="2" class="text_cent"><?php echo $label['sos'][6]; ?></th>
                                                    <th rowspan="2" class="text_cent"><?php echo $label['sos'][7]; ?></th>
                                                    <th colspan="2" class="text_cent"><?php echo $label['sos'][8]; ?></th>
                                                    <th rowspan="2" class="text_cent"><?php echo $label['sos'][9]; ?></th>
                                                    <th rowspan="2" class="text_cent"><?php echo $label['sos'][10]; ?></th>
                                                </tr>
                                                <tr class="f_s_10">
                                                    <th class="text_cent"><?php echo $label['sos'][14]; ?></th>
                                                    <th class="text_cent"><?php echo $label['sos'][15]; ?></th>
                                                    <th class="text_cent"><?php echo $label['sos'][16]; ?></th>
                                                    <th class="text_cent"><?php echo $label['sos'][17]; ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sourceData = $data['sos']['sourceData'];
                                                $totalCount = $sourceData['totalCount'];
                                                for ($i = 1; $i <= $totalCount; $i++) { ?>
                                                    <tr id="trow-<?php echo $i; ?>">
                                                        <td><?php echo $sourceData['sour_indus_'.$i]; ?></td>
                                                        <td>
                                                            <?php 
                                                                echo $sourceData['sour_mineral_'.$i] . "<br>";
                                                                echo ($sourceData['mineral_unit_'.$i] != '') ? "(".$sourceData['mineral_unit_'.$i].")" : "";
                                                            ?>
                                                        </td>
                                                        <td><?php echo $sourceData['sour_name_add_'.$i]; ?></td>
                                                        <td><?php echo $sourceData['sour_mine_area_'.$i]; ?></td>
                                                        <td><?php echo ($sourceData['sour_mine_area_dist_'.$i] == '') ? '--' : $data['sos']['districts'][$sourceData['sour_mine_area_dist_'.$i]]; ?></td>
                                                        <td><?php echo $sourceData['sour_ind_dis_'.$i]; ?></td>
                                                        <td><?php echo ($sourceData['sour_tran_mode_'.$i] == '') ? '--' : $data['sos']['modeOption'][$sourceData['sour_tran_mode_'.$i]]; ?></td>
                                                        <td><?php echo $sourceData['sour_tran_cost_'.$i]; ?></td>
                                                        <td><?php echo $sourceData['sour_qty_'.$i]; ?></td>
                                                        <td><?php echo $sourceData['sour_price_'.$i]; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                
                                <tr><td></td></tr>
                                <tr>
                                    <td align="left" class="f_s_10 f_b"><?php echo $label['sos']['title']; ?> continues...</td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top">
                                        <table width="100%" border="0.5" class="f_s_9" cellpadding="4" cellspacing="0" nobr="true">
                                            <thead>
                                                <tr class="f_s_10">
                                                    <th rowspan="3" class="text_cent"><?php echo $label['sos'][1]; ?></th>
                                                    <th rowspan="3" class="text_cent"><?php echo $label['sos'][2]; ?></th>
                                                    <th colspan="4" class="text_cent"><?php echo $label['sos'][4]; ?></th>
                                                </tr>
                                                <tr class="f_s_10">
                                                    <th colspan="2" class="text_cent"><?php echo $label['sos'][11]; ?></th>
                                                    <th rowspan="2" class="text_cent"><?php echo $label['sos'][12]; ?></th>
                                                    <th rowspan="2" class="text_cent"><?php echo $label['sos'][13]; ?></th>
                                                </tr>
                                                <tr class="f_s_10">
                                                    <th class="text_cent"><?php echo $label['sos'][18]; ?></th>
                                                    <th class="text_cent"><?php echo $label['sos'][19]; ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sourceData = $data['sos']['sourceData'];
                                                $totalCount = $sourceData['totalCount'];
                                                for ($i = 1; $i <= $totalCount; $i++) { ?>
                                                    <tr id="trow-<?php echo $i; ?>">
                                                        <td><?php echo $sourceData['sour_indus_'.$i]; ?></td>
                                                        <td>
                                                            <?php 
                                                                echo $sourceData['sour_mineral_'.$i] . "<br>";
                                                                echo ($sourceData['mineral_unit_'.$i] != '') ? "(".$sourceData['mineral_unit_'.$i].")" : "";
                                                            ?>
                                                        </td>
                                                        <td><?php echo $sourceData['sour_supplier_add_'.$i]; ?></td>
                                                        <td><?php echo ($sourceData['sour_supplier_country_'.$i] == '') ? '--' : $data['sos']['countryOption'][$sourceData['sour_supplier_country_'.$i]]; ?></td>
                                                        <td><?php echo $sourceData['sour_qty_purch_'.$i]; ?></td>
                                                        <td><?php echo $sourceData['sour_cost_metric_'.$i]; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php 
                }
            }
            ?>

        </tbody>
    </table>
    
    <!-- footer section -->
    <table style="margin-left:40px;width:100%" border="0" style="font-size:11px">
        <!-- <tr>
            <td>
                <table width="95%">
                    <tr>
                        <td>
                            <p style="text-align:justify">I, ............................... S/o/D/o/W/o ................................. age ......... occupation .................................. resident of .................................. village/town/city/post-office ............................ police station .................................. taluka ................................. district .................................... state ........................... certify that the information furnished above is complete and correct in all respect.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr> -->
        <tr><td></td></tr>
        <tr><td></td></tr>
        <tr>
            <td>
                <table width="100%" nobr="true" style="font-size:11px">
                    <tr>
                        <td class="f_s_11">I Certify that the information furnished above is correct and complete in all respects.</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td></td></tr>
        <tr><td></td></tr>
        <tr>
            <td>
                <table width="100%" nobr="true" style="font-size:11px">
                    <tr>
                        <td width="40%">Place : <?php echo ucwords(strtolower($placeTemp)); ?></td>
                        <td width="20%"></td>
                        <td width="40%">Signature</td>
                    </tr>
                    <tr>
                        <td>Date : <?php echo $printAllDate; ?></td>
                        <td></td>
                        <td>Name : <?php echo $data['genp']['fullName']; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Designation: <?php echo $mcu_design; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Owner / Agent / Mining Engineer / Manager</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td width="100%" style="text-align: center;">
                <b><i><?php echo $ipTimeFormat; ?></i></b>
            </td>
        </tr>
        <tr><td></td></tr>
        <tr><td></td></tr>
        <tr><td></td></tr>
    </table>

</div>
