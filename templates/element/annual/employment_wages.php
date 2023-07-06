
<!-- <h5 class="card-title text-center"><?php //echo $label['title']; ?></h5> -->
<table class="table table-bordered font-weight-bold">
    <tbody>
        <tr>
            <td colspan="2">
                <?php echo $label[0]; ?>
                <table class="table table-bordered table-sm font-weight-bold">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th><?php echo $label[1]; ?></th>
                            <th><?php echo $label[2]; ?></th>
                            <th><?php echo $label[3]; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $label[4]; ?></td>
                            <td>
                                <?php echo $this->Form->control('GRAD_MINING_WHOLLY', array('class'=>'form-control form-control-sm number-fields staff-emp wholly-emp-tot', 'id'=>'GRAD_MINING_WHOLLY', 'label'=>false, 'value'=>$empWages['wholly_employed_gme'])); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('GRAD_MINING_PARTLY', array('class'=>'form-control form-control-sm number-fields staff-emp partly-emp-tot', 'id'=>'GRAD_MINING_PARTLY', 'label'=>false, 'value'=>$empWages['partly_employed_gme'])); ?>
                                <div class="err_cv"></div>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $label[5]; ?></td>
                            <td>
                                <?php echo $this->Form->control('DIP_MINING_WHOLLY', array('class'=>'form-control form-control-sm number-fields staff-emp wholly-emp-tot', 'id'=>'DIP_MINING_WHOLLY', 'label'=>false, 'value'=>$empWages['wholly_employed_dme'])); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('DIP_MINING_PARTLY', array('class'=>'form-control form-control-sm number-fields staff-emp partly-emp-tot', 'id'=>'DIP_MINING_PARTLY', 'label'=>false, 'value'=>$empWages['partly_employed_dme'])); ?>
                                <div class="err_cv"></div>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $label[6]; ?></td>
                            <td>
                                <?php echo $this->Form->control('GEO_WHOLLY', array('class'=>'form-control form-control-sm number-fields staff-emp wholly-emp-tot', 'id'=>'GEO_WHOLLY', 'label'=>false, 'value'=>$empWages['wholly_employed_geologist'])); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('GEO_PARTLY', array('class'=>'form-control form-control-sm number-fields staff-emp partly-emp-tot', 'id'=>'GEO_PARTLY', 'label'=>false, 'value'=>$empWages['partly_employed_geologist'])); ?>
                                <div class="err_cv"></div>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $label[7]; ?></td>
                            <td>
                                <?php echo $this->Form->control('SURV_WHOLLY', array('class'=>'form-control form-control-sm number-fields staff-emp wholly-emp-tot', 'id'=>'SURV_WHOLLY', 'label'=>false, 'value'=>$empWages['wholly_employed_surveyor'])); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('SURV_PARTLY', array('class'=>'form-control form-control-sm number-fields staff-emp partly-emp-tot', 'id'=>'SURV_PARTLY', 'label'=>false, 'value'=>$empWages['partly_employed_surveyor'])); ?>
                                <div class="err_cv"></div>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $label[8]; ?></td>
                            <td>
                                <?php echo $this->Form->control('OTHER_WHOLLY', array('class'=>'form-control form-control-sm number-fields staff-emp wholly-emp-tot', 'id'=>'OTHER_WHOLLY', 'label'=>false, 'value'=>$empWages['wholly_employed_other'])); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('OTHER_PARTLY', array('class'=>'form-control form-control-sm number-fields staff-emp partly-emp-tot', 'id'=>'OTHER_PARTLY', 'label'=>false, 'value'=>$empWages['partly_employed_other'])); ?>
                                <div class="err_cv"></div>
                            </td>
                        </tr>
                    </tbody>
                    <thead class="bg-light">
                        <tr>
                            <th><?php echo $label[9]; ?></th>
                            <td>
                                <?php echo $this->Form->control('TOTAL_WHOLLY', array('class'=>'form-control form-control-sm number-fields staff-emp-tot', 'id'=>'TOTAL_WHOLLY', 'label'=>false, 'value'=>'')); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('TOTAL_PARTLY', array('class'=>'form-control form-control-sm number-fields staff-emp-tot', 'id'=>'TOTAL_PARTLY', 'label'=>false, 'value'=>'')); ?>
                                <div class="err_cv"></div>
                            </td>
                        </tr>
                    </thead>
                </table>
            </td>
        </tr>
        <tr>
            <td><?php echo $label[10]; ?></td>
            <td class="w-50">
                <?php echo $this->Form->control('DAYS_MINE_WORKED', array('class'=>'form-control form-control-sm number-fields', 'id'=>'DAYS_MINE_WORKED', 'label'=>false, 'value'=>$empWages['no_work_days'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td class="pl-4"><?php echo $label[11]; ?></td>
            <td>
                <?php echo $this->Form->control('NO_OF_SHIFTS', array('class'=>'form-control form-control-sm number-fields', 'id'=>'NO_OF_SHIFTS', 'label'=>false, 'value'=>$empWages['no_shifts'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td class="v_a_base pl-4"><?php echo $label[12]; ?></td>
            <td>
                <table class="table table-bordered table-sm" id="reason_tbl">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th><?php echo $label[13]; ?></th>
                            <th colspan="2"><?php echo $label[14]; ?></th>
                        </tr>
                    </thead>
			        <?php 

                    $optionArr = [];
                    foreach($reasonsArr as $reason){
                        $optionArr[$reason['stoppage_sn']] = $reason['stoppage_def']; 
                    }

                    $freeOptionArr = $optionArr;

                    // if($workDetail['stoppage_sn_1']!=null){
                    //     unset($freeOptionArr[$workDetail['stoppage_sn_1']]);
                    // }
                    // if($workDetail['stoppage_sn_2']!=null){
                    //     unset($freeOptionArr[$workDetail['stoppage_sn_2']]);
                    // }
                    // if($workDetail['stoppage_sn_3']!=null){
                    //     unset($freeOptionArr[$workDetail['stoppage_sn_3']]);
                    // }
                    // if($workDetail['stoppage_sn_4']!=null){
                    //     unset($freeOptionArr[$workDetail['stoppage_sn_4']]);
                    // }
                    // if($workDetail['stoppage_sn_5']!=null){
                    //     unset($freeOptionArr[$workDetail['stoppage_sn_5']]);
                    // }

                    // if($workDetail['stoppage_sn_1']!=null){
                    //     $optionArr1 = $freeOptionArr;
                    //     $optionArr1[$workDetail['stoppage_sn_1']] = $optionArr[$workDetail['stoppage_sn_1']];
                    // }
                    // if($workDetail['stoppage_sn_2']!=null){
                    //     $optionArr2 = $freeOptionArr;
                    //     $optionArr2[$workDetail['stoppage_sn_2']] = $optionArr[$workDetail['stoppage_sn_2']];
                    // }
                    // if($workDetail['stoppage_sn_3']!=null){
                    //     $optionArr3 = $freeOptionArr;
                    //     $optionArr3[$workDetail['stoppage_sn_3']] = $optionArr[$workDetail['stoppage_sn_3']];
                    // }
                    // if($workDetail['stoppage_sn_4']!=null){
                    //     $optionArr4 = $freeOptionArr;
                    //     $optionArr4[$workDetail['stoppage_sn_4']] = $optionArr[$workDetail['stoppage_sn_4']];
                    // }
                    // if($workDetail['stoppage_sn_5']!=null){
                    //     $optionArr5 = $freeOptionArr;
                    //     $optionArr5[$workDetail['stoppage_sn_5']] = $optionArr[$workDetail['stoppage_sn_5']];
                    // }

                    ?>
                    <tbody>
                        <?php 
                        
                        $workDataMonthlyMain = (isset($workDataMonthly)) ? $workDataMonthly : array();
                        $loop = 1;
                        for ($i=1; $i <= $reasonsLen; $i++) {
                            if ($workData['stoppage_sn_'.$i] != null || $i==1) {

                                // Check if monthly return array present
                                // If exits, highlight modified data in annual as compare to monthly
                                $diff[$i]['reason']['class'] = '';
                                $diff[$i]['reason']['title'] = '';
                                $diff[$i]['no_of_days']['class'] = '';
                                $diff[$i]['no_of_days']['title'] = '';
                                if (isset($workDataMonthly)) {

                                    $reasonId = $workData['stoppage_sn_'.$i];
                                    $reasonKey = array_search($reasonId, $workDataMonthly['reason']);
                                    if ($reasonKey != '') {
                                        $daysNext = $workData['no_days_'.$i];
                                        $daysPrev = $workDataMonthly['days'][$reasonKey];
                                        if ($daysNext != $daysPrev) {
                                            $daysDiff = $daysNext - $daysPrev;
                                            $diff[$i]['no_of_days']['title'] = ($daysDiff > 0) ? '+'.$daysDiff : $daysDiff;
                                            $diff[$i]['no_of_days']['class'] = ' in_modified';
                                        }
                                        $key = (int)$reasonKey;
                                        unset($workDataMonthly['reason'][$key]);
                                        unset($workDataMonthly['days'][$key]);
                                    } else {
                                        $diff[$i]['reason']['class'] = ' in_new';
                                        $diff[$i]['reason']['title'] = 'New record';
                                        $diff[$i]['no_of_days']['class'] = ' in_new';
                                        $diff[$i]['no_of_days']['title'] = 'New record';
                                    }

                                }

                                ?>
                                <tr id="rw-<?php echo $i; ?>">
                                    <td>
                                        <?php echo $this->Form->select('reason_'.$i, $optionArr, array('empty'=>'Select Reason','class'=>'form-control form-control-sm h-selectbox select_reason'.$diff[$i]['reason']['class'], 'id'=>'reason_'.$i, 'title'=>$diff[$i]['reason']['title'], 'value'=>$workData['stoppage_sn_'.$i])); ?>
                                        <div class="err_cv"></div>
                                    </td>
                                    <td>
                                        <?php echo $this->Form->control('no_of_days_'.$i, array('class'=>'form-control form-control-sm no_of_days number-fields'.$diff[$i]['no_of_days']['class'], 'id'=>'no_of_days_'.$i, 'label'=>false, 'title'=>$diff[$i]['no_of_days']['title'], 'value'=>$workData['no_days_'.$i])); ?>
                                        <div class="err_cv"></div>
                                    </td>
                                    <td>
                                        <?php echo $this->Form->button('<i class="fa fa-times"></i>', array('type'=>'button', 'escapeTitle'=>false, 'class'=>'btn btn-sm rem_btn', 'disabled'=>'true')); ?>
                                    </td>
                                </tr>
                                <?php 
                                $loop++;
                            }
                        }

                        // This extra loop is only for showing deleted records in the annual return
                        // as compares to monthly return
                        // Effective from Phase-II
                        // Added on 08th Nov 2021 by Aniket Ganvir
				        if (isset($workDataMonthly['reason']) && count($workDataMonthly['reason']) > 0) {
                            foreach ($workDataMonthly['reason'] as $k => $val) {
                                ?>
                                <tr id="rw-<?php echo $loop; ?>">
                                    <td>
                                        <?php echo $this->Form->select('reason_'.$loop, $optionArr, array('empty'=>'Select Reason','class'=>'form-control form-control-sm h-selectbox select_reason in_old', 'id'=>'reason_'.$loop, 'title'=>'Removed record', 'value'=>$val)); ?>
                                        <div class="err_cv"></div>
                                    </td>
                                    <td>
                                        <?php echo $this->Form->control('no_of_days_'.$loop, array('class'=>'form-control form-control-sm no_of_days number-fields in_old', 'id'=>'no_of_days_'.$loop, 'label'=>false, 'title'=>'Removed record', 'value'=>$workDataMonthly['days'][$k])); ?>
                                        <div class="err_cv"></div>
                                    </td>
                                    <td>
                                        <?php echo $this->Form->button('<i class="fa fa-times"></i>', array('type'=>'button', 'escapeTitle'=>false, 'class'=>'btn btn-sm rem_btn', 'disabled'=>'true')); ?>
                                    </td>
                                </tr>
                                <?php 
                                $loop++;
                            }
                        }
                        ?>
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="3">
                                <?php echo $this->Form->button('<i class="fa fa-plus"></i> Add more', array('type'=>'button', 'escapeTitle'=>false, 'class'=>'btn btn-info btn-sm', 'id'=>'add_more_btn')); ?>
                            </th>
                        </tr>
                    </thead>
                </table>
            </td>
        </tr>
    </tbody>
</table>

<?php echo $this->Form->control('form_no', array('type'=>'hidden', 'value'=>$formId)); ?>
<?php echo $this->Form->control('mine_code', array('type'=>'hidden', 'value'=>$mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType)); ?>
<?php echo $this->Form->control('return_date', array('type'=>'hidden', 'value'=>$returnDate)); ?>
<?php echo $this->Form->control('return_year', array('type'=>'hidden', 'value'=>$returnYear)); ?>
<?php echo $this->Form->control('reasons_len', array('type'=>'hidden', 'id'=>'reasons_len', 'value'=>$reasonsLen)); ?>
<?php echo $this->Form->control('no_days', array('type'=>'hidden', 'id'=>'no_days', 'value'=>$noDays)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'free_option_arr', 'value'=>$this->Form->select('reason_rwStringPurpose', $freeOptionArr, array('empty'=>'Select Reason','class'=>'form-control form-control-sm h-selectbox select_reason', 'id'=>'reason_rwStringPurpose')))); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'form_id_name', 'value'=>'employmentWages')); ?>


<?php echo $this->Html->script('g/employment_wages.js?version='.$version); ?>
