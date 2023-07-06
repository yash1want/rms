
<h5 class="card-title text-center"><?php echo $label['title']; ?></h5>
<table class="table table-bordered">
    <thead class="bg-secondary text-white">
        <tr>
            <th><?php echo $label[0]; ?></th>
            <th><?php echo $label[1]; ?></th>
            <th><?php echo $label[2]; ?></th>
            <th><?php echo $label[3]; ?></th>
            <th><?php echo $label[4]; ?></th>
            <th><?php echo $label[5]; ?></th>
        </tr>
        <tr>
            <th>(1)</th>
            <th>(2)</th>
            <th>(3)</th>
            <th>(4)</th>
            <th>(5)</th>
            <th>(6)= (3+4-5)</th>
        </tr>
        <tr>
            <th colspan="6"><?php echo $label[6]; ?></th>
        </tr>
    </thead>
    <tbody>
        <tr id="row-1">
            <td><?php echo $label[7]; ?></td>
            <td>111</td>
            <td>
                <?php echo $this->Form->control('RS[PROVED_BEGIN]', array('class'=>'form-control form-control-sm number-fields-small rs_begin', 'id'=>'RS_PROVED_BEGIN', 'label'=>false, 'value'=>$reserves['proved_begin'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[PROVED_ASSESSED_DURING]', array('class'=>'form-control form-control-sm number-fields-small rs_during', 'id'=>'RS_PROVED_ASSESSED_DURING', 'label'=>false, 'value'=>$reserves['proved_assessed_during'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[PROVED_DEPLETION]', array('class'=>'form-control form-control-sm number-fields-small rs_depletion', 'id'=>'RS_PROVED_DEPLETION', 'label'=>false, 'value'=>$reserves['proved_depletion'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[PROVED_BALANCE]', array('class'=>'form-control form-control-sm number-fields-small rs_balance', 'id'=>'RS_PROVED_BALANCE', 'label'=>false, 'value'=>$reserves['proved_balance'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr id="row-2">
            <td rowspan="2"><?php echo $label[8]; ?></td>
            <td>121</td>
            <td>
                <?php echo $this->Form->control('RS[PROBABLE_FIRST_BEGIN]', array('class'=>'form-control form-control-sm number-fields-small rs_begin', 'id'=>'RS_PROBABLE_FIRST_BEGIN', 'label'=>false, 'value'=>$reserves['probable_first_begin'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[PROBABLE_FIRST_ASSESSED_DURING]', array('class'=>'form-control form-control-sm number-fields-small rs_during', 'id'=>'RS_PROBABLE_FIRST_ASSESSED_DURING', 'label'=>false, 'value'=>$reserves['probable_first_assessed_during'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[PROBABLE_FIRST_DEPLETION]', array('class'=>'form-control form-control-sm number-fields-small rs_depletion', 'id'=>'RS_PROBABLE_FIRST_DEPLETION', 'label'=>false, 'value'=>$reserves['probable_first_depletion'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[PROBABLE_FIRST_BALANCE]', array('class'=>'form-control form-control-sm number-fields-small rs_balance', 'id'=>'RS_PROBABLE_FIRST_BALANCE', 'label'=>false, 'value'=>$reserves['probable_first_balance'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr id="row-3">
            <td>122</td>
            <td>
                <?php echo $this->Form->control('RS[PROBABLE_SEC_BEGIN]', array('class'=>'form-control form-control-sm number-fields-small rs_begin', 'id'=>'RS_PROBABLE_SEC_BEGIN', 'label'=>false, 'value'=>$reserves['probable_sec_begin'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[PROBABLE_SEC_ASSESSED_DURING]', array('class'=>'form-control form-control-sm number-fields-small rs_during', 'id'=>'RS_PROBABLE_SEC_ASSESSED_DURING', 'label'=>false, 'value'=>$reserves['probable_sec_assessed_during'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[PROBABLE_SEC_DEPLETION]', array('class'=>'form-control form-control-sm number-fields-small rs_depletion', 'id'=>'RS_PROBABLE_SEC_DEPLETION', 'label'=>false, 'value'=>$reserves['probable_sec_depletion'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[PROBABLE_SEC_BALANCE]', array('class'=>'form-control form-control-sm number-fields-small rs_balance', 'id'=>'RS_PROBABLE_SEC_BALANCE', 'label'=>false, 'value'=>$reserves['probable_sec_balance'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr class="bg-light">
            <td><?php echo $label[9]; ?></td>
            <td></td>
            <td id="mReservbeginTot" class="pl-3"></td>
            <td id="mReservduringTot" class="pl-3"></td>
            <td id="mReservdepletionTot" class="pl-3"></td>
            <td id="mReservbalanceTot" class="pl-3"></td>
        </tr>
    </tbody>
    <thead class="bg-secondary text-white">
        <tr>
            <th colspan="6"><?php echo $label[10]; ?></th>
        </tr>
    </thead>
    <tbody>
        <tr id="row-4">
            <td><?php echo $label[11]; ?></td>
            <td>211</td>
            <td>
                <?php echo $this->Form->control('RS[FEASIBILITY_BEGIN]', array('class'=>'form-control form-control-sm number-fields-small rs_begin', 'id'=>'RS_FEASIBILITY_BEGIN', 'label'=>false, 'value'=>$reserves['feasibility_begin'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[FEASIBILITY_ASSESSED_DURING]', array('class'=>'form-control form-control-sm number-fields-small rs_during', 'id'=>'RS_FEASIBILITY_ASSESSED_DURING', 'label'=>false, 'value'=>$reserves['feasibility_assessed_during'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[FEASIBILITY_DEPLETION]', array('class'=>'form-control form-control-sm number-fields-small rs_depletion', 'id'=>'RS_FEASIBILITY_DEPLETION', 'label'=>false, 'value'=>$reserves['feasibility_depletion'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[FEASIBILITY_BALANCE]', array('class'=>'form-control form-control-sm number-fields-small rs_balance', 'id'=>'RS_FEASIBILITY_BALANCE', 'label'=>false, 'value'=>$reserves['feasibility_balance'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr id="row-5">
            <td rowspan="2"><?php echo $label[12]; ?></td>
            <td>221</td>
            <td>
                <?php echo $this->Form->control('RS[PREFEASIBILITY_FIRST_BEGIN]', array('class'=>'form-control form-control-sm number-fields-small rs_begin', 'id'=>'RS_PREFEASIBILITY_FIRST_BEGIN', 'label'=>false, 'value'=>$reserves['prefeasibility_first_begin'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[PREFEASIBILITY_FIRST_ASSESSED_DURING]', array('class'=>'form-control form-control-sm number-fields-small rs_during', 'id'=>'RS_PREFEASIBILITY_FIRST_ASSESSED_DURING', 'label'=>false, 'value'=>$reserves['prefeasibility_first_assessed_during'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[PREFEASIBILITY_FIRST_DEPLETION]', array('class'=>'form-control form-control-sm number-fields-small rs_depletion', 'id'=>'RS_PREFEASIBILITY_FIRST_DEPLETION', 'label'=>false, 'value'=>$reserves['prefeasibility_first_depletion'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[PREFEASIBILITY_FIRST_BALANCE]', array('class'=>'form-control form-control-sm number-fields-small rs_balance', 'id'=>'RS_PREFEASIBILITY_FIRST_BALANCE', 'label'=>false, 'value'=>$reserves['prefeasibility_first_balance'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr id="row-6">
            <td>222</td>
            <td>
                <?php echo $this->Form->control('RS[PREFEASIBILITY_SEC_BEGIN]', array('class'=>'form-control form-control-sm number-fields-small rs_begin', 'id'=>'RS_PREFEASIBILITY_SEC_BEGIN', 'label'=>false, 'value'=>$reserves['prefeasibility_sec_begin'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[PREFEASIBILITY_SEC_ASSESSED_DURING]', array('class'=>'form-control form-control-sm number-fields-small rs_during', 'id'=>'RS_PREFEASIBILITY_SEC_ASSESSED_DURING', 'label'=>false, 'value'=>$reserves['prefeasibility_sec_assessed_during'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[PREFEASIBILITY_SEC_DEPLETION]', array('class'=>'form-control form-control-sm number-fields-small rs_depletion', 'id'=>'RS_PREFEASIBILITY_SEC_DEPLETION', 'label'=>false, 'value'=>$reserves['prefeasibility_sec_depletion'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[PREFEASIBILITY_SEC_BALANCE]', array('class'=>'form-control form-control-sm number-fields-small rs_balance', 'id'=>'RS_PREFEASIBILITY_SEC_BALANCE', 'label'=>false, 'value'=>$reserves['prefeasibility_sec_balance'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr id="row-7">
            <td><?php echo $label[13]; ?></td>
            <td>331</td>
            <td>
                <?php echo $this->Form->control('RS[MEASURED_BEGIN]', array('class'=>'form-control form-control-sm number-fields-small rs_begin', 'id'=>'RS_MEASURED_BEGIN', 'label'=>false, 'value'=>$reserves['measured_begin'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[MEASURED_ASSESSED_DURING]', array('class'=>'form-control form-control-sm number-fields-small rs_during', 'id'=>'RS_MEASURED_ASSESSED_DURING', 'label'=>false, 'value'=>$reserves['measured_assessed_during'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[MEASURED_SEC_DEPLETION]', array('class'=>'form-control form-control-sm number-fields-small rs_depletion', 'id'=>'RS_MEASURED_SEC_DEPLETION', 'label'=>false, 'value'=>$reserves['measured_sec_depletion'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[MEASURED_SEC_BALANCE]', array('class'=>'form-control form-control-sm number-fields-small rs_balance', 'id'=>'RS_MEASURED_SEC_BALANCE', 'label'=>false, 'value'=>$reserves['measured_sec_balance'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr id="row-8">
            <td><?php echo $label[14]; ?></td>
            <td>332</td>
            <td>
                <?php echo $this->Form->control('RS[INDICATED_BEGIN]', array('class'=>'form-control form-control-sm number-fields-small rs_begin', 'id'=>'RS_INDICATED_BEGIN', 'label'=>false, 'value'=>$reserves['indicated_begin'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[INDICATED_ASSESSED_DURING]', array('class'=>'form-control form-control-sm number-fields-small rs_during', 'id'=>'RS_INDICATED_ASSESSED_DURING', 'label'=>false, 'value'=>$reserves['indicated_assessed_during'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[INDICATED_SEC_DEPLETION]', array('class'=>'form-control form-control-sm number-fields-small rs_depletion', 'id'=>'RS_INDICATED_SEC_DEPLETION', 'label'=>false, 'value'=>$reserves['indicated_sec_depletion'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[INDICATED_SEC_BALANCE]', array('class'=>'form-control form-control-sm number-fields-small rs_balance', 'id'=>'RS_INDICATED_SEC_BALANCE', 'label'=>false, 'value'=>$reserves['indicated_sec_balance'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr id="row-9">
            <td><?php echo $label[15]; ?></td>
            <td>333</td>
            <td>
                <?php echo $this->Form->control('RS[INFERRED_BEGIN]', array('class'=>'form-control form-control-sm number-fields-small rs_begin', 'id'=>'RS_INFERRED_BEGIN', 'label'=>false, 'value'=>$reserves['inferred_begin'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[INFERRED_ASSESSED_DURING]', array('class'=>'form-control form-control-sm number-fields-small rs_during', 'id'=>'RS_INFERRED_ASSESSED_DURING', 'label'=>false, 'value'=>$reserves['inferred_assessed_during'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[INFERRED_SEC_DEPLETION]', array('class'=>'form-control form-control-sm number-fields-small rs_depletion', 'id'=>'RS_INFERRED_SEC_DEPLETION', 'label'=>false, 'value'=>$reserves['inferred_sec_depletion'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[INFERRED_SEC_BALANCE]', array('class'=>'form-control form-control-sm number-fields-small rs_balance', 'id'=>'RS_INFERRED_SEC_BALANCE', 'label'=>false, 'value'=>$reserves['inferred_sec_balance'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr id="row-10">
            <td><?php echo $label[16]; ?></td>
            <td>334</td>
            <td>
                <?php echo $this->Form->control('RS[RECONNAISSANCE_BEGIN]', array('class'=>'form-control form-control-sm number-fields-small rs_begin', 'id'=>'RS_RECONNAISSANCE_BEGIN', 'label'=>false, 'value'=>$reserves['reconnaissance_begin'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[RECONNAISSANCE_ASSESSED_DURING]', array('class'=>'form-control form-control-sm number-fields-small rs_during', 'id'=>'RS_RECONNAISSANCE_ASSESSED_DURING', 'label'=>false, 'value'=>$reserves['reconnaissance_assessed_during'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[RECONNAISSANCE_SEC_DEPLETION]', array('class'=>'form-control form-control-sm number-fields-small rs_depletion', 'id'=>'RS_RECONNAISSANCE_SEC_DEPLETION', 'label'=>false, 'value'=>$reserves['reconnaissance_sec_depletion'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('RS[RECONNAISSANCE_SEC_BALANCE]', array('class'=>'form-control form-control-sm number-fields-small rs_balance', 'id'=>'RS_RECONNAISSANCE_SEC_BALANCE', 'label'=>false, 'value'=>$reserves['reconnaissance_sec_balance'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr class="bg-light b_b_grey">
            <td><?php echo $label[17]; ?></td>
            <td></td>
            <td id="rResourcebeginTot" class="pl-3"></td>
            <td id="rResourceduringTot" class="pl-3"></td>
            <td id="rResourcedepletionTot" class="pl-3"></td>
            <td id="rResourcebalanceTot" class="pl-3"></td>
        </tr>
        <tr class="bg-light">
            <td><?php echo $label[18]; ?></td>
            <td></td>
            <td id="beginTot" class="pl-3"></td>
            <td id="duringTot" class="pl-3"></td>
            <td id="depletionTot" class="pl-3"></td>
            <td id="balanceTot" class="pl-3"></td>
        </tr>
    </tbody>
</table>

<h5 class="card-title text-center"><?php echo $label['title_two']; ?></h5>
<div class="alert alert-info p-1 pl-2 mb-1"><?php echo $label[19]; ?></div>
<table class="table table-bordered">
    <thead class="bg-secondary text-white">
        <tr>
            <th><?php echo $label[20]; ?></th>
            <th><?php echo $label[21]; ?></th>
            <th><?php echo $label[22]; ?></th>
            <th><?php echo $label[23]; ?></th>
            <th><?php echo $label[24]; ?></th>
            <th><?php echo $label[25]; ?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $label[26]; ?></td>
            <td>
                <?php echo $this->Form->control('SMR[UNPROCESSED_BEGIN]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'SMR_UNPROCESSED_BEGIN', 'label'=>false, 'value'=>$subgrade['unprocessed_begin'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('SMR[UNPROCESSED_GENERATED]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'SMR_UNPROCESSED_GENERATED', 'label'=>false, 'value'=>$subgrade['unprocessed_generated'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('SMR[UNPROCESSED_DISPOSED]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'SMR_UNPROCESSED_DISPOSED', 'label'=>false, 'value'=>$subgrade['unprocessed_disposed'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('SMR[UNPROCESSED_TOTAL]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'SMR_UNPROCESSED_TOTAL', 'label'=>false, 'value'=>$subgrade['unprocessed_total'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('SMR[UNPROCESSED_AVERAGE]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'SMR_UNPROCESSED_AVERAGE', 'label'=>false, 'value'=>$subgrade['unprocessed_average'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td><?php echo $label[27]; ?></td>
            <td>
                <?php echo $this->Form->control('SMR[PROCESSED_BEGIN]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'SMR_PROCESSED_BEGIN', 'label'=>false, 'value'=>$subgrade['processed_begin'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('SMR[PROCESSED_GENERATED]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'SMR_PROCESSED_GENERATED', 'label'=>false, 'value'=>$subgrade['processed_generated'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('SMR[PROCESSED_DISPOSED]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'SMR_PROCESSED_DISPOSED', 'label'=>false, 'value'=>$subgrade['processed_disposed'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('SMR[PROCESSED_TOTAL]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'SMR_PROCESSED_TOTAL', 'label'=>false, 'value'=>$subgrade['processed_total'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('SMR[PROCESSED_AVERAGE]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'SMR_PROCESSED_AVERAGE', 'label'=>false, 'value'=>$subgrade['processed_average'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
    </tbody>
</table>

<?php echo $this->Form->control('form_no', array('type'=>'hidden', 'value'=>$formId)); ?>
<?php echo $this->Form->control('mine_code', array('type'=>'hidden', 'value'=>$mineCode)); ?>
<?php echo $this->Form->control('mineral_name', array('type'=>'hidden', 'value'=>$mineralName)); ?>
<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType)); ?>
<?php echo $this->Form->control('return_date', array('type'=>'hidden', 'value'=>$returnDate)); ?>
<?php echo $this->Form->control('return_year', array('type'=>'hidden', 'value'=>$returnYear)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'form_id_name', 'value'=>'geologyPart2')); ?>

<?php echo $this->Html->script('g/geology_reserves_subgrade.js?version='.$version); ?>
