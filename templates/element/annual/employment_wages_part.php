
<h5 class="card-title text-center"><?php echo $label['title']; ?></h5>
<table class="table table-bordered table-sm font-weight-bold">
    <tbody>
        <tr>
            <td>
                <?php echo $label[0]; ?> <span class="text-primary" title="<?php echo $label[2]; ?>"><?php echo $label[1]; ?></span>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $label[3]; ?>
                <table class="table table-borderless table-sm">
                    <tbody>
                        <tr>
                            <td><?php echo $label[4]; ?></td>
                            <td class="text-right"><?php echo $label[5]; ?></td>
                            <td>
                                <div class="input-group">
                                    <?php echo $this->Form->control('WORKING_BELOW_DATE', array('class'=>'form-control form-control-sm number-fields date col-sm-11 d-inline-block', 'id'=>'WORKING_BELOW_DATE', 'label'=>false, 'min'=>$startDate, 'max'=>$endDate, 'value'=>$empData['returnDetails']['WORKING_BELOW_DATE'], 'readonly', 'templates'=>array('inputContainer'=>'{{content}}') )); ?>
                                    <div class="input-group-append">
                                        <div class="input-group-text inr-icon-rent" id="btnGroupAddon"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                <div class="err_cv"></div>
                            </td>
                            <td class="text-right"><?php echo $label[6]; ?></td>
                            <td>
                                <?php echo $this->Form->control('WORKING_BELOW_PER', array('class'=>'form-control form-control-sm number-fields', 'id'=>'WORKING_BELOW_PER', 'label'=>false, 'value'=>$empData['returnDetails']['WORKING_BELOW_PER'])); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><?php echo $label[7]; ?></td>
                            <td class="text-right"><?php echo $label[5]; ?></td>
                            <td>
                                <div class="input-group">
                                    <?php echo $this->Form->control('WORKING_ALL_DATE', array('class'=>'form-control form-control-sm number-fields date col-sm-11 d-inline-block', 'id'=>'WORKING_ALL_DATE', 'label'=>false, 'min'=>$startDate, 'max'=>$endDate, 'value'=>$empData['returnDetails']['WORKING_ALL_DATE'], 'readonly', 'templates'=>array('inputContainer'=>'{{content}}') )); ?>
                                    <div class="input-group-append">
                                        <div class="input-group-text inr-icon-rent" id="btnGroupAddon"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                <div class="err_cv"></div>
                            </td>
                            <td class="text-right"><?php echo $label[6]; ?></td>
                            <td>
                                <?php echo $this->Form->control('WORKING_ALL_PER', array('class'=>'form-control form-control-sm number-fields', 'id'=>'WORKING_ALL_PER', 'label'=>false, 'value'=>$empData['returnDetails']['WORKING_ALL_PER'])); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table class="table table-sm">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th rowspan="2" class="align-middle"><?php echo $label[8]; ?></th>
                            <th colspan="3"><?php echo $label[9]; ?></th>
                            <th rowspan="2" class="align-middle"><?php echo $label[10]; ?></th>
                            <th colspan="3"><?php echo $label[11]; ?></th>
                            <th rowspan="2" class="align-middle"><?php echo $label[12]; ?></th>
                        </tr>
                        <tr>
                            <th><?php echo $label[13]; ?></th>
                            <th><?php echo $label[14]; ?></th>
                            <th><?php echo $label[15]; ?></th>
                            <th><?php echo $label[16]; ?></th>
                            <th><?php echo $label[17]; ?></th>
                            <th><?php echo $label[18]; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $label[19]; ?></td>
                            <td><?php echo $label[20]; ?></td>
                            <td><?php echo $label[21]; ?></td>
                            <td><?php echo $label[22]; ?></td>
                            <td><?php echo $label[23]; ?></td>
                            <td><?php echo $label[24]; ?></td>
                            <td><?php echo $label[25]; ?></td>
                            <td><?php echo $label[26]; ?></td>
                            <td><?php echo $label[27]; ?></td>
                        </tr>
                        <?php 
                        
						// Highlight fields which are differs from cumulative monthly data in annual
						// (Only for Form G1 in MMS side)
						// Effective from Phase-II
						// Added on 08th Nov 2021 by Aniket Ganvir

                        $empArr = array('_MALE', '_FEMALE', '_PER_TOTAL', '_TOTAL_WAGES');
                        $empType = array('BELOW_FOREMAN', 'OC_FOREMAN', 'ABOVE_CLERICAL');
                        for ($i = 0; $i < 3; $i++) {

                            $diff[$empType[$i].$empArr[0]]['class'] = '';
                            $diff[$empType[$i].$empArr[0]]['title'] = '';
                            $diff[$empType[$i].$empArr[1]]['class'] = '';
                            $diff[$empType[$i].$empArr[1]]['title'] = '';
                            $diff[$empType[$i].$empArr[2]]['class'] = '';
                            $diff[$empType[$i].$empArr[2]]['title'] = '';
                            $diff[$empType[$i].$empArr[3]]['class'] = '';
                            $diff[$empType[$i].$empArr[3]]['title'] = '';
                                
                            if (isset($empDataMonthly)) {

                                // male
                                $empMaleOld = $empDataMonthly['empDetails'][$empType[$i].$empArr[0]];
                                $empMaleNew = $empData['empDetails'][$empType[$i].$empArr[0]];
                                if ($empMaleOld != $empMaleNew) {
                                    $empMaleDiff = $empMaleNew - $empMaleOld;
                                    $diff[$empType[$i].$empArr[0]]['title'] = ($empMaleDiff > 0) ? '+'.$empMaleDiff : $empMaleDiff;
                                    $diff[$empType[$i].$empArr[0]]['class'] = ' in_new';
                                }
                                
                                // female
                                $empFemaleOld = $empDataMonthly['empDetails'][$empType[$i].$empArr[1]];
                                $empFemaleNew = $empData['empDetails'][$empType[$i].$empArr[1]];
                                if ($empFemaleOld != $empFemaleNew) {
                                    $empFemaleDiff = $empFemaleNew - $empFemaleOld;
                                    $diff[$empType[$i].$empArr[1]]['title'] = ($empFemaleDiff > 0) ? '+'.$empFemaleDiff : $empFemaleDiff;
                                    $diff[$empType[$i].$empArr[1]]['class'] = ' in_new';
                                }
                                
                                // total
                                $empTotalOld = $empDataMonthly['empDetails'][$empType[$i].$empArr[2]];
                                $empTotalNew = $empData['empDetails'][$empType[$i].$empArr[2]];
                                if ($empTotalOld != $empTotalNew) {
                                    $empTotalDiff = $empTotalNew - $empTotalOld;
                                    $diff[$empType[$i].$empArr[2]]['title'] = ($empTotalDiff > 0) ? '+'.$empTotalDiff : $empTotalDiff;
                                    $diff[$empType[$i].$empArr[2]]['class'] = ' in_new';
                                }
                                
                                // total wages
                                $empTotalWageOld = $empDataMonthly['empDetails'][$empType[$i].$empArr[3]];
                                $empTotalWageNew = $empData['empDetails'][$empType[$i].$empArr[3]];
                                if ($empTotalWageOld != $empTotalWageNew) {
                                    $empTotalWageDiff = $empTotalWageNew - $empTotalWageOld;
                                    $diff[$empType[$i].$empArr[3]]['title'] = ($empTotalWageDiff > 0) ? '+'.$empTotalWageDiff : $empTotalWageDiff;
                                    $diff[$empType[$i].$empArr[3]]['class'] = ' in_new';
                                }

                            }
    
                        }

                        ?>
                        <tr>
                            <td><?php echo $label[28]; ?></td>
                            <td>
                                <?php echo $this->Form->control('BELOW_FOREMAN_DIRECT', array('class'=>'form-control form-control-sm number-fields per_emp direct', 'id'=>'BELOW_FOREMAN_DIRECT', 'label'=>false, 'value'=>$empData['empDetails']['BELOW_FOREMAN_DIRECT'])); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('BELOW_FOREMAN_CONTRACT', array('class'=>'form-control form-control-sm number-fields per_emp contract', 'id'=>'BELOW_FOREMAN_CONTRACT', 'label'=>false, 'value'=>$empData['empDetails']['BELOW_FOREMAN_CONTRACT'])); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td class="bg-light">
                                <?php echo $this->Form->control('BELOW_FOREMAN_MAN_TOT', array('class'=>'form-control form-control-sm number-fields sum man', 'id'=>'BELOW_FOREMAN_MAN_TOT', 'label'=>false, 'value'=>$empData['empDetails']['BELOW_FOREMAN_MAN_TOT'], 'readonly')); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('BELOW_FOREMAN_DAYS', array('class'=>'form-control form-control-sm number-fields days', 'id'=>'BELOW_FOREMAN_DAYS', 'label'=>false, 'value'=>$empData['empDetails']['BELOW_FOREMAN_DAYS'])); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('BELOW_FOREMAN_MALE', array('class'=>'form-control form-control-sm number-fields per_emp male'.$diff['BELOW_FOREMAN_MALE']['class'], 'id'=>'BELOW_FOREMAN_MALE', 'label'=>false, 'title'=>$diff['BELOW_FOREMAN_MALE']['title'], 'value'=>$empData['empDetails']['BELOW_FOREMAN_MALE'])); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('BELOW_FOREMAN_FEMALE', array('class'=>'form-control form-control-sm number-fields per_emp female'.$diff['BELOW_FOREMAN_FEMALE']['class'], 'id'=>'BELOW_FOREMAN_FEMALE', 'label'=>false, 'title'=>$diff['BELOW_FOREMAN_FEMALE']['title'], 'value'=>$empData['empDetails']['BELOW_FOREMAN_FEMALE'])); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td class="bg-light">
                                <?php echo $this->Form->control('BELOW_FOREMAN_PER_TOTAL', array('class'=>'form-control form-control-sm number-fields sum1 per_tot'.$diff['BELOW_FOREMAN_PER_TOTAL']['class'], 'id'=>'BELOW_FOREMAN_PER_TOTAL', 'label'=>false, 'title'=>$diff['BELOW_FOREMAN_PER_TOTAL']['title'], 'value'=>$empData['empDetails']['BELOW_FOREMAN_PER_TOTAL'], 'readonly')); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('BELOW_FOREMAN_TOTAL_WAGES', array('class'=>'form-control form-control-sm number-fields wages'.$diff['BELOW_FOREMAN_TOTAL_WAGES']['class'], 'id'=>'BELOW_FOREMAN_TOTAL_WAGES', 'label'=>false, 'title'=>$diff['BELOW_FOREMAN_TOTAL_WAGES']['title'], 'value'=>$empData['empDetails']['BELOW_FOREMAN_TOTAL_WAGES'])); ?>
                                <div class="err_cv"></div>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $label[29]; ?></td>
                            <td>
                                <?php echo $this->Form->control('OC_FOREMAN_DIRECT', array('class'=>'form-control form-control-sm number-fields per_emp direct', 'id'=>'OC_FOREMAN_DIRECT', 'label'=>false, 'value'=>$empData['empDetails']['OC_FOREMAN_DIRECT'])); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('OC_FOREMAN_CONTRACT', array('class'=>'form-control form-control-sm number-fields per_emp contract', 'id'=>'OC_FOREMAN_CONTRACT', 'label'=>false, 'value'=>$empData['empDetails']['OC_FOREMAN_CONTRACT'])); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td class="bg-light">
                                <?php echo $this->Form->control('OC_FOREMAN_MAN_TOT', array('class'=>'form-control form-control-sm number-fields sum man', 'id'=>'OC_FOREMAN_MAN_TOT', 'label'=>false, 'value'=>$empData['empDetails']['OC_FOREMAN_MAN_TOT'], 'readonly')); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('OC_FOREMAN_DAYS', array('class'=>'form-control form-control-sm number-fields days', 'id'=>'OC_FOREMAN_DAYS', 'label'=>false, 'value'=>$empData['empDetails']['OC_FOREMAN_DAYS'])); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('OC_FOREMAN_MALE', array('class'=>'form-control form-control-sm number-fields per_emp male'.$diff['OC_FOREMAN_MALE']['class'], 'id'=>'OC_FOREMAN_MALE', 'label'=>false, 'title'=>$diff['OC_FOREMAN_MALE']['title'], 'value'=>$empData['empDetails']['OC_FOREMAN_MALE'])); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('OC_FOREMAN_FEMALE', array('class'=>'form-control form-control-sm number-fields per_emp female'.$diff['OC_FOREMAN_FEMALE']['class'], 'id'=>'OC_FOREMAN_FEMALE', 'label'=>false, 'title'=>$diff['OC_FOREMAN_FEMALE']['title'], 'value'=>$empData['empDetails']['OC_FOREMAN_FEMALE'])); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td class="bg-light">
                                <?php echo $this->Form->control('OC_FOREMAN_PER_TOTAL', array('class'=>'form-control form-control-sm number-fields sum1 per_tot'.$diff['OC_FOREMAN_PER_TOTAL']['class'], 'id'=>'OC_FOREMAN_PER_TOTAL', 'label'=>false, 'title'=>$diff['OC_FOREMAN_PER_TOTAL']['title'], 'value'=>$empData['empDetails']['OC_FOREMAN_PER_TOTAL'], 'readonly')); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('OC_FOREMAN_TOTAL_WAGES', array('class'=>'form-control form-control-sm number-fields wages'.$diff['OC_FOREMAN_TOTAL_WAGES']['class'], 'id'=>'OC_FOREMAN_TOTAL_WAGES', 'label'=>false, 'title'=>$diff['OC_FOREMAN_TOTAL_WAGES']['title'], 'value'=>$empData['empDetails']['OC_FOREMAN_TOTAL_WAGES'])); ?>
                                <div class="err_cv"></div>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $label[30]; ?></td>
                            <td>
                                <?php echo $this->Form->control('ABOVE_CLERICAL_DIRECT', array('class'=>'form-control form-control-sm number-fields per_emp direct', 'id'=>'ABOVE_CLERICAL_DIRECT', 'label'=>false, 'value'=>$empData['empDetails']['ABOVE_CLERICAL_DIRECT'])); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('ABOVE_CLERICAL_CONTRACT', array('class'=>'form-control form-control-sm number-fields per_emp contract', 'id'=>'ABOVE_CLERICAL_CONTRACT', 'label'=>false, 'value'=>$empData['empDetails']['ABOVE_CLERICAL_CONTRACT'])); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td class="bg-light">
                                <?php echo $this->Form->control('ABOVE_CLERICAL_MAN_TOT', array('class'=>'form-control form-control-sm number-fields sum man', 'id'=>'ABOVE_CLERICAL_MAN_TOT', 'label'=>false, 'value'=>$empData['empDetails']['ABOVE_CLERICAL_MAN_TOT'], 'readonly')); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('ABOVE_CLERICAL_DAYS', array('class'=>'form-control form-control-sm number-fields days', 'id'=>'ABOVE_CLERICAL_DAYS', 'label'=>false, 'value'=>$empData['empDetails']['ABOVE_CLERICAL_DAYS'])); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('ABOVE_CLERICAL_MALE', array('class'=>'form-control form-control-sm number-fields per_emp male'.$diff['ABOVE_CLERICAL_MALE']['class'], 'id'=>'ABOVE_CLERICAL_MALE', 'label'=>false, 'title'=>$diff['ABOVE_CLERICAL_MALE']['title'], 'value'=>$empData['empDetails']['ABOVE_CLERICAL_MALE'])); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('ABOVE_CLERICAL_FEMALE', array('class'=>'form-control form-control-sm number-fields per_emp female'.$diff['ABOVE_CLERICAL_FEMALE']['class'], 'id'=>'ABOVE_CLERICAL_FEMALE', 'label'=>false, 'title'=>$diff['ABOVE_CLERICAL_FEMALE']['title'], 'value'=>$empData['empDetails']['ABOVE_CLERICAL_FEMALE'])); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td class="bg-light">
                                <?php echo $this->Form->control('ABOVE_CLERICAL_PER_TOTAL', array('class'=>'form-control form-control-sm number-fields sum1 per_tot'.$diff['ABOVE_CLERICAL_PER_TOTAL']['class'], 'id'=>'ABOVE_CLERICAL_PER_TOTAL', 'label'=>false, 'title'=>$diff['ABOVE_CLERICAL_PER_TOTAL']['title'], 'value'=>$empData['empDetails']['ABOVE_CLERICAL_PER_TOTAL'], 'readonly')); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('ABOVE_CLERICAL_TOTAL_WAGES', array('class'=>'form-control form-control-sm number-fields wages'.$diff['ABOVE_CLERICAL_TOTAL_WAGES']['class'], 'id'=>'ABOVE_CLERICAL_TOTAL_WAGES', 'label'=>false, 'title'=>$diff['ABOVE_CLERICAL_TOTAL_WAGES']['title'], 'value'=>$empData['empDetails']['ABOVE_CLERICAL_TOTAL_WAGES'])); ?>
                                <div class="err_cv"></div>
                            </td>
                        </tr>
                        <tr class="bg-light">
                            <td><?php echo $label[31]; ?></td>
                            <td>
                                <?php echo $this->Form->control('TOTAL_DIRECT', array('class'=>'form-control form-control-sm number-fields sum2 direct_tot', 'id'=>'TOTAL_DIRECT', 'label'=>false, 'value'=>$empData['empDetails']['ABOVE_ATTACHED_DIRECT'], 'readonly')); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('TOTAL_CONTRACT', array('class'=>'form-control form-control-sm number-fields sum2 contract_tot', 'id'=>'TOTAL_CONTRACT', 'label'=>false, 'value'=>$empData['empDetails']['ABOVE_ATTACHED_CONTRACT'], 'readonly')); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('TOTAL_MAN', array('class'=>'form-control form-control-sm number-fields sum man_tot', 'id'=>'TOTAL_MAN', 'label'=>false, 'value'=>$empData['empDetails']['ABOVE_ATTACHED_MAN_TOT'], 'readonly')); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td height="95px">
                                <?php echo $this->Form->control('TOTAL_DAYS', array('class'=>'form-control form-control-sm number-fields days_tot', 'id'=>'TOTAL_DAYS', 'label'=>false, 'value'=>$empData['empDetails']['ABOVE_ATTACHED_DAYS'], 'readonly')); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('TOTAL_MALE', array('class'=>'form-control form-control-sm number-fields sum3 male_tot', 'id'=>'TOTAL_MALE', 'label'=>false, 'value'=>$empData['empDetails']['ABOVE_ATTACHED_MALE'], 'readonly')); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('TOTAL_FEMALE', array('class'=>'form-control form-control-sm number-fields sum3 female_tot', 'id'=>'TOTAL_FEMALE', 'label'=>false, 'value'=>$empData['empDetails']['ABOVE_ATTACHED_FEMALE'], 'readonly')); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('TOTAL_PERSONS', array('class'=>'form-control form-control-sm number-fields sum1 sum3 person_tot', 'id'=>'TOTAL_PERSONS', 'label'=>false, 'value'=>$empData['empDetails']['ABOVE_ATTACHED_PER_TOTAL'], 'readonly')); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('TOTAL_WAGES', array('class'=>'form-control form-control-sm number-fields wages_tot', 'id'=>'TOTAL_WAGES', 'label'=>false, 'value'=>$empData['empDetails']['ABOVE_ATTACHED_TOTAL_WAGES'], 'readonly')); ?>
                                <div class="err_cv"></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="9" class="alert alert-info p-2 pl-3"><?php echo $label[2]; ?></td>
                        </tr>
                    </tbody>
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
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'start_date', 'value'=>$startDate)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'end_date', 'value'=>$endDate)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'form_id_name', 'value'=>'employmentWagesPart2')); ?>

<?php echo $this->Html->script('g/employment_wages_part.js?version='.$version); ?>
