
<!-- <h5 class="card-title text-center"><?php //echo $label['title']; ?></h5> -->
<table class="table table-bordered">
    <tbody>
        <tr>
            <td class="v_a_base w-50"><?php echo $label[0]; ?></td>
            <td>
                <table class="table table-sm">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th class="w-25"><?php echo $label[1]; ?></th>
                            <th class="w-25"><?php echo $label[2]; ?></th>
                            <th><?php echo $label[3]; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $label[4]; ?></td>
                            <td><?php echo $label[7]; ?></td>
                            <td>
                                <?php echo $this->Form->control('MAG_CAPACITY_EXP', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'MAG_CAPACITY_EXP', 'label'=>false, 'value'=>$explReturn['MAG_CAPACITY_EXP'])); ?>
                                <div class="err_cv"></div>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $label[5]; ?></td>
                            <td><?php echo $label[8]; ?></td>
                            <td>
                                <?php echo $this->Form->control('MAG_CAPACITY_DET', array('class'=>'form-control form-control-sm number-fields-small valid', 'id'=>'MAG_CAPACITY_DET', 'label'=>false, 'value'=>$explReturn['MAG_CAPACITY_DET'])); ?>
                                <div class="err_cv"></div>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $label[6]; ?></td>
                            <td><?php echo $label[9]; ?></td>
                            <td>
                                <?php echo $this->Form->control('MAG_CAPACITY_FUSE', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'MAG_CAPACITY_FUSE', 'label'=>false, 'value'=>$explReturn['MAG_CAPACITY_FUSE'])); ?>
                                <div class="err_cv"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>

<table class="table table-bordered table-sm mb-2">
    <thead class="bg-secondary text-white">
        <tr>
            <th rowspan="2" class="v_a_mid text-center"><?php echo $label[10]; ?></th>
            <th rowspan="2" class="v_a_mid text-center"><?php echo $label[2]; ?></th>
            <th colspan="2" class="v_a_mid text-center"><?php echo $label[11]; ?></th>
            <th colspan="2" class="v_a_mid text-center"><?php echo $label[12]; ?></th>
        </tr>
        <tr>
            <th class="v_a_mid text-center"><?php echo $label[13]; ?></th>
            <th class="v_a_mid text-center"><?php echo $label[14]; ?></th>
            <th class="v_a_mid text-center"><?php echo $label[13]; ?></th>
            <th class="v_a_mid text-center"><?php echo $label[14]; ?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $label[15]; ?></td>
            <td class="text-center"><?php echo $label[7]; ?></td>
            <td colspan="2">
                <?php echo $this->Form->control('LARGE_CON_QTY', array('class'=>'form-control form-control-sm number-fields-small con_qty', 'id'=>'LARGE_CON_QTY', 'label'=>false, 'value'=>$explConsum['LARGE_CON_QTY'])); ?>
                <div class="err_cv"></div>
            </td>
            <td colspan="2">
                <?php echo $this->Form->control('LARGE_REQ_QTY', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'LARGE_REQ_QTY', 'label'=>false, 'value'=>$explConsum['LARGE_REQ_QTY'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td colspan="6"><?php echo $label[16]; ?></td>
        </tr>
        <tr>
            <td class="pl-3"><?php echo $label[17]; ?></td>
            <td class="text-center"><?php echo $label[7]; ?></td>
            <td>
                <?php echo $this->Form->control('SMALL_CON_QTY_1', array('class'=>'form-control form-control-sm number-fields-small con_qty valid', 'id'=>'SMALL_CON_QTY_1', 'label'=>false, 'value'=>$explConsum['SMALL_CON_QTY_1'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('LARGE_CON_QTY_1', array('class'=>'form-control form-control-sm number-fields-small con_qty valid', 'id'=>'LARGE_CON_QTY_1', 'label'=>false, 'value'=>$explConsum['LARGE_CON_QTY_1'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('SMALL_REQ_QTY_1', array('class'=>'form-control form-control-sm number-fields-small valid', 'id'=>'SMALL_REQ_QTY_1', 'label'=>false, 'value'=>$explConsum['SMALL_REQ_QTY_1'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('LARGE_REQ_QTY_1', array('class'=>'form-control form-control-sm number-fields-small valid', 'id'=>'LARGE_REQ_QTY_1', 'label'=>false, 'value'=>$explConsum['LARGE_REQ_QTY_1'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td class="pl-3"><?php echo $label[18]; ?></td>
            <td class="text-center"><?php echo $label[7]; ?></td>
            <td>
                <?php echo $this->Form->control('SMALL_CON_QTY_2', array('class'=>'form-control form-control-sm number-fields-small con_qty valid', 'id'=>'SMALL_CON_QTY_2', 'label'=>false, 'value'=>$explConsum['SMALL_CON_QTY_2'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('LARGE_CON_QTY_2', array('class'=>'form-control form-control-sm number-fields-small con_qty valid', 'id'=>'LARGE_CON_QTY_2', 'label'=>false, 'value'=>$explConsum['LARGE_CON_QTY_2'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('SMALL_REQ_QTY_2', array('class'=>'form-control form-control-sm number-fields-small valid', 'id'=>'SMALL_REQ_QTY_2', 'label'=>false, 'value'=>$explConsum['SMALL_REQ_QTY_2'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('LARGE_REQ_QTY_2', array('class'=>'form-control form-control-sm number-fields-small valid', 'id'=>'LARGE_REQ_QTY_2', 'label'=>false, 'value'=>$explConsum['LARGE_REQ_QTY_2'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td><?php echo $label[19]; ?></td>
            <td class="text-center"><?php echo $label[7]; ?></td>
            <td>
                <?php echo $this->Form->control('SMALL_CON_QTY_3', array('class'=>'form-control form-control-sm number-fields-small con_qty', 'id'=>'SMALL_CON_QTY_3', 'label'=>false, 'value'=>$explConsum['SMALL_CON_QTY_3'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('LARGE_CON_QTY_3', array('class'=>'form-control form-control-sm number-fields-small con_qty', 'id'=>'LARGE_CON_QTY_3', 'label'=>false, 'value'=>$explConsum['LARGE_CON_QTY_3'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('SMALL_REQ_QTY_3', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'SMALL_REQ_QTY_3', 'label'=>false, 'value'=>$explConsum['SMALL_REQ_QTY_3'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('LARGE_REQ_QTY_3', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'LARGE_REQ_QTY_3', 'label'=>false, 'value'=>$explConsum['LARGE_REQ_QTY_3'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td><?php echo $label[20]; ?></td>
            <td class="text-center"><?php echo $label[7]; ?></td>
            <td>
                <?php echo $this->Form->control('SMALL_CON_QTY_4', array('class'=>'form-control form-control-sm number-fields-small con_qty', 'id'=>'SMALL_CON_QTY_4', 'label'=>false, 'value'=>$explConsum['SMALL_CON_QTY_4'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('LARGE_CON_QTY_4', array('class'=>'form-control form-control-sm number-fields-small con_qty', 'id'=>'LARGE_CON_QTY_4', 'label'=>false, 'value'=>$explConsum['LARGE_CON_QTY_4'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('SMALL_REQ_QTY_4', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'SMALL_REQ_QTY_4', 'label'=>false, 'value'=>$explConsum['SMALL_REQ_QTY_4'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('LARGE_REQ_QTY_4', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'LARGE_REQ_QTY_4', 'label'=>false, 'value'=>$explConsum['LARGE_REQ_QTY_4'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $label[21]; ?>
                <?php echo $this->Form->control('SLURRY_TN', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'SLURRY_TN', 'label'=>false, 'value'=>$explConsum['SLURRY_TN'])); ?>
                <div class="err_cv"></div>
            </td>
            <td class="text-center"><?php echo $label[7]; ?></td>
            <td>
                <?php echo $this->Form->control('SMALL_CON_QTY_5', array('class'=>'form-control form-control-sm number-fields-small con_qty', 'id'=>'SMALL_CON_QTY_5', 'label'=>false, 'value'=>$explConsum['SMALL_CON_QTY_5'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('LARGE_CON_QTY_5', array('class'=>'form-control form-control-sm number-fields-small con_qty', 'id'=>'LARGE_CON_QTY_5', 'label'=>false, 'value'=>$explConsum['LARGE_CON_QTY_5'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('SMALL_REQ_QTY_5', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'SMALL_REQ_QTY_5', 'label'=>false, 'value'=>$explConsum['SMALL_REQ_QTY_5'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('LARGE_REQ_QTY_5', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'LARGE_REQ_QTY_5', 'label'=>false, 'value'=>$explConsum['LARGE_REQ_QTY_5'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td colspan="6"><?php echo $label[22]; ?></td>
        </tr>
        <tr>
            <td class="pl-3"><?php echo $label[23]; ?></td>
            <td class="text-center"><?php echo $label[8]; ?></td>
            <td colspan="2">
                <?php echo $this->Form->control('LARGE_CON_QTY_6', array('class'=>'form-control form-control-sm number-fields-small con_qty', 'id'=>'LARGE_CON_QTY_6', 'label'=>false, 'value'=>$explConsum['LARGE_CON_QTY_6'])); ?>
                <div class="err_cv"></div>
            </td>
            <td colspan="2">
                <?php echo $this->Form->control('LARGE_REQ_QTY_6', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'LARGE_REQ_QTY_6', 'label'=>false, 'value'=>$explConsum['LARGE_REQ_QTY_6'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td colspan="6" class="pl-3"><?php echo $label[24]; ?></td>
        </tr>
        <tr>
            <td class="pl-4"><?php echo $label[25]; ?></td>
            <td class="text-center"><?php echo $label[8]; ?></td>
            <td colspan="2">
                <?php echo $this->Form->control('LARGE_CON_QTY_8', array('class'=>'form-control form-control-sm number-fields-small con_qty', 'id'=>'LARGE_CON_QTY_8', 'label'=>false, 'value'=>$explConsum['LARGE_CON_QTY_8'])); ?>
                <div class="err_cv"></div>
            </td>
            <td colspan="2">
                <?php echo $this->Form->control('LARGE_REQ_QTY_8', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'LARGE_REQ_QTY_8', 'label'=>false, 'value'=>$explConsum['LARGE_REQ_QTY_8'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td class="pl-4"><?php echo $label[26]; ?></td>
            <td class="text-center"><?php echo $label[8]; ?></td>
            <td colspan="2">
                <?php echo $this->Form->control('LARGE_CON_QTY_9', array('class'=>'form-control form-control-sm number-fields-small con_qty', 'id'=>'LARGE_CON_QTY_9', 'label'=>false, 'value'=>$explConsum['LARGE_CON_QTY_9'])); ?>
                <div class="err_cv"></div>
            </td>
            <td colspan="2">
                <?php echo $this->Form->control('LARGE_REQ_QTY_9', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'LARGE_REQ_QTY_9', 'label'=>false, 'value'=>$explConsum['LARGE_REQ_QTY_9'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td colspan="6"><?php echo $label[27]; ?></td>
        </tr>
        <tr>
            <td class="pl-3"><?php echo $label[28]; ?></td>
            <td class="text-center"><?php echo $label[9]; ?></td>
            <td colspan="2">
                <?php echo $this->Form->control('LARGE_CON_QTY_11', array('class'=>'form-control form-control-sm number-fields-small con_qty', 'id'=>'LARGE_CON_QTY_11', 'label'=>false, 'value'=>$explConsum['LARGE_CON_QTY_11'])); ?>
                <div class="err_cv"></div>
            </td>
            <td colspan="2">
                <?php echo $this->Form->control('LARGE_REQ_QTY_11', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'LARGE_REQ_QTY_11', 'label'=>false, 'value'=>$explConsum['LARGE_REQ_QTY_11'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td class="pl-3"><?php echo $label[29]; ?></td>
            <td class="text-center"><?php echo $label[9]; ?></td>
            <td colspan="2">
                <?php echo $this->Form->control('LARGE_CON_QTY_12', array('class'=>'form-control form-control-sm number-fields-small con_qty', 'id'=>'LARGE_CON_QTY_12', 'label'=>false, 'value'=>$explConsum['LARGE_CON_QTY_12'])); ?>
                <div class="err_cv"></div>
            </td>
            <td colspan="2">
                <?php echo $this->Form->control('LARGE_REQ_QTY_12', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'LARGE_REQ_QTY_12', 'label'=>false, 'value'=>$explConsum['LARGE_REQ_QTY_12'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td><?php echo $label[30]; ?></td>
            <td class="text-center"><?php echo $label[9]; ?></td>
            <td colspan="2">
                <?php echo $this->Form->control('LARGE_CON_QTY_13', array('class'=>'form-control form-control-sm number-fields-small con_qty', 'id'=>'LARGE_CON_QTY_13', 'label'=>false, 'value'=>$explConsum['LARGE_CON_QTY_13'])); ?>
                <div class="err_cv"></div>
            </td>
            <td colspan="2">
                <?php echo $this->Form->control('LARGE_REQ_QTY_13', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'LARGE_REQ_QTY_13', 'label'=>false, 'value'=>$explConsum['LARGE_REQ_QTY_13'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $label[31]; ?>
                <?php echo $this->Form->control('OTHER_EXPLOSIVES', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'OTHER_EXPLOSIVES', 'label'=>false, 'value'=>$explConsum['OTHER_EXPLOSIVES'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->select('OTHER_UNIT', $label['other_unit'], array('id'=>'OTHER_UNIT', 'class'=>'form-control form-control-sm selectbox-small', 'value'=>$explConsum['OTHER_UNIT'])); ?>
                <div class="err_cv"></div>
            </td>
            <td colspan="2">
                <?php echo $this->Form->control('LARGE_CON_QTY_14', array('class'=>'form-control form-control-sm number-fields-small con_qty', 'id'=>'LARGE_CON_QTY_14', 'label'=>false, 'value'=>$explConsum['LARGE_CON_QTY_14'])); ?>
                <div class="err_cv"></div>
            </td>
            <td colspan="2">
                <?php echo $this->Form->control('LARGE_REQ_QTY_14', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'LARGE_REQ_QTY_14', 'label'=>false, 'value'=>$explConsum['LARGE_REQ_QTY_14'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
    </tbody>
</table>
<div class="alert alert-info p-1 pl-2 mb-1"><?php echo $label[32]; ?></div>

<?php echo $this->Form->control('form_no', array('type'=>'hidden', 'value'=>$formId)); ?>
<?php echo $this->Form->control('mine_code', array('type'=>'hidden', 'value'=>$mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType)); ?>
<?php echo $this->Form->control('return_date', array('type'=>'hidden', 'value'=>$returnDate)); ?>
<?php echo $this->Form->control('return_year', array('type'=>'hidden', 'value'=>$returnYear)); ?>
<?php echo $this->Form->control('explosive_check_val', array('type'=>'hidden', 'value'=>$explosiveCheckVal, 'id'=>'explosiveCheckVal')); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'form_id_name', 'value'=>'explosiveConsumption')); ?>

<?php echo $this->Html->script('g/explosive_consumption.js?version='.$version); ?>
