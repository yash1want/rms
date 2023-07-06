
<h5 class="card-title text-center"><?php echo $label['title']; ?></h5>

<div class="position-relative row form-group mine-group">
	<table class="table table-bordered table-sm">
        <thead class="bg-secondary text-white">
            <tr>
                <th><?php echo $label[0]; ?></th>
                <th><?php echo $label[1]; ?></th>
                <th class="w-25"><?php echo $label[2]; ?></th>
                <th class="w-25"><?php echo $label[3]; ?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="4" class="font-weight-bold"><?php echo $label[4]; ?></td>
            </tr>
            <tr>
                <td class="pl-4"><?php echo $label[5]; ?></td>
                <td><?php echo $label['ton']; ?></td>
                <td>
                    <?php echo $this->Form->control('COAL_QUANTITY', array('class'=>'form-control form-control-sm number-fields quantity', 'id'=>'COAL_QUANTITY', 'label'=>false, 'value'=>$matConsData['COAL_QUANTITY'])); ?>
                    <div class="err_cv"></div>
                </td>
                <td>
                    <?php echo $this->Form->control('COAL_VALUE', array('class'=>'form-control form-control-sm number-fields value', 'id'=>'COAL_VALUE', 'label'=>false, 'value'=>$matConsData['COAL_VALUE'])); ?>
                    <div class="err_cv"></div>
                </td>
            </tr>
            <tr>
                <td class="pl-4"><?php echo $label[6]; ?></td>
                <td><?php echo $label['ltr']; ?></td>
                <td>
                    <?php echo $this->Form->control('DIESEL_QUANTITY', array('class'=>'form-control form-control-sm number-fields quantity', 'id'=>'DIESEL_QUANTITY', 'label'=>false, 'value'=>$matConsData['DIESEL_QUANTITY'])); ?>
                    <div class="err_cv"></div>
                </td>
                <td>
                    <?php echo $this->Form->control('DIESEL_VALUE', array('class'=>'form-control form-control-sm number-fields value', 'id'=>'DIESEL_VALUE', 'label'=>false, 'value'=>$matConsData['DIESEL_VALUE'])); ?>
                    <div class="err_cv"></div>
                </td>
            </tr>
            <tr>
                <td class="pl-4"><?php echo $label[7]; ?></td>
                <td><?php echo $label['ltr']; ?></td>
                <td>
                    <?php echo $this->Form->control('PETROL_QUANTITY', array('class'=>'form-control form-control-sm number-fields quantity', 'id'=>'PETROL_QUANTITY', 'label'=>false, 'value'=>$matConsData['PETROL_QUANTITY'])); ?>
                    <div class="err_cv"></div>
                </td>
                <td>
                    <?php echo $this->Form->control('PETROL_VALUE', array('class'=>'form-control form-control-sm number-fields value', 'id'=>'PETROL_VALUE', 'label'=>false, 'value'=>$matConsData['PETROL_VALUE'])); ?>
                    <div class="err_cv"></div>
                </td>
            </tr>
            <tr>
                <td class="pl-4"><?php echo $label[8]; ?></td>
                <td><?php echo $label['ltr']; ?></td>
                <td>
                    <?php echo $this->Form->control('KEROSENE_QUANTITY', array('class'=>'form-control form-control-sm number-fields quantity', 'id'=>'KEROSENE_QUANTITY', 'label'=>false, 'value'=>$matConsData['KEROSENE_QUANTITY'])); ?>
                    <div class="err_cv"></div>
                </td>
                <td>
                    <?php echo $this->Form->control('KEROSENE_VALUE', array('class'=>'form-control form-control-sm number-fields value', 'id'=>'KEROSENE_VALUE', 'label'=>false, 'value'=>$matConsData['KEROSENE_VALUE'])); ?>
                    <div class="err_cv"></div>
                </td>
            </tr>
            <tr>
                <td class="pl-4"><?php echo $label[9]; ?></td>
                <td><?php echo $label['cum']; ?></td>
                <td>
                    <?php echo $this->Form->control('GAS_QUANTITY', array('class'=>'form-control form-control-sm number-fields quantity', 'id'=>'GAS_QUANTITY', 'label'=>false, 'value'=>$matConsData['GAS_QUANTITY'])); ?>
                    <div class="err_cv"></div>
                </td>
                <td>
                    <?php echo $this->Form->control('GAS_VALUE', array('class'=>'form-control form-control-sm number-fields value', 'id'=>'GAS_VALUE', 'label'=>false, 'value'=>$matConsData['GAS_VALUE'])); ?>
                    <div class="err_cv"></div>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="font-weight-bold"><?php echo $label[10]; ?></td>
            </tr>
            <tr>
                <td class="pl-4"><?php echo $label[11]; ?></td>
                <td><?php echo $label['ltr']; ?></td>
                <td>
                    <?php echo $this->Form->control('LUBRICANT_QUANTITY', array('class'=>'form-control form-control-sm number-fields quantity', 'id'=>'LUBRICANT_QUANTITY', 'label'=>false, 'value'=>$matConsData['LUBRICANT_QUANTITY'])); ?>
                    <div class="err_cv"></div>
                </td>
                <td>
                    <?php echo $this->Form->control('LUBRICANT_VALUE', array('class'=>'form-control form-control-sm number-fields value', 'id'=>'LUBRICANT_VALUE', 'label'=>false, 'value'=>$matConsData['LUBRICANT_VALUE'])); ?>
                    <div class="err_cv"></div>
                </td>
            </tr>
            <tr>
                <td class="pl-4"><?php echo $label[12]; ?></td>
                <td><?php echo $label['kgs']; ?></td>
                <td>
                    <?php echo $this->Form->control('GREASE_QUANTITY', array('class'=>'form-control form-control-sm number-fields quantity', 'id'=>'GREASE_QUANTITY', 'label'=>false, 'value'=>$matConsData['GREASE_QUANTITY'])); ?>
                    <div class="err_cv"></div>
                </td>
                <td>
                    <?php echo $this->Form->control('GREASE_VALUE', array('class'=>'form-control form-control-sm number-fields value', 'id'=>'GREASE_VALUE', 'label'=>false, 'value'=>$matConsData['GREASE_VALUE'])); ?>
                    <div class="err_cv"></div>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="font-weight-bold"><?php echo $label[13]; ?></td>
            </tr>
            <tr>
                <td class="pl-4"><?php echo $label[14]; ?></td>
                <td><?php echo $label['kwh']; ?></td>
                <td>
                    <?php echo $this->Form->control('CONSUMED_QUANTITY', array('class'=>'form-control form-control-sm number-fields quantity', 'id'=>'CONSUMED_QUANTITY', 'label'=>false, 'value'=>$matConsData['CONSUMED_QUANTITY'])); ?>
                    <div class="err_cv"></div>
                </td>
                <td>
                    <?php echo $this->Form->control('CONSUMED_VALUE', array('class'=>'form-control form-control-sm number-fields value', 'id'=>'CONSUMED_VALUE', 'label'=>false, 'value'=>$matConsData['CONSUMED_VALUE'])); ?>
                    <div class="err_cv"></div>
                </td>
            </tr>
            <tr>
                <td class="pl-4"><?php echo $label[15]; ?></td>
                <td><?php echo $label['kwh']; ?></td>
                <td>
                    <?php echo $this->Form->control('GENERATED_QUANTITY', array('class'=>'form-control form-control-sm number-fields quantity', 'id'=>'GENERATED_QUANTITY', 'label'=>false, 'value'=>$matConsData['GENERATED_QUANTITY'])); ?>
                    <div class="err_cv"></div>
                </td>
                <td>
                    <?php echo $this->Form->control('GENERATED_VALUE', array('class'=>'form-control form-control-sm number-fields value', 'id'=>'GENERATED_VALUE', 'label'=>false, 'value'=>$matConsData['GENERATED_VALUE'])); ?>
                    <div class="err_cv"></div>
                </td>
            </tr>
            <tr>
                <td class="pl-4"><?php echo $label[16]; ?></td>
                <td><?php echo $label['kwh']; ?></td>
                <td>
                    <?php echo $this->Form->control('SOLD_QUANTITY', array('class'=>'form-control form-control-sm number-fields quantity', 'id'=>'SOLD_QUANTITY', 'label'=>false, 'value'=>$matConsData['SOLD_QUANTITY'])); ?>
                    <div class="err_cv"></div>
                </td>
                <td>
                    <?php echo $this->Form->control('SOLD_VALUE', array('class'=>'form-control form-control-sm number-fields value', 'id'=>'SOLD_VALUE', 'label'=>false, 'value'=>$matConsData['SOLD_VALUE'])); ?>
                    <div class="err_cv"></div>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="font-weight-bold"><?php echo $label[17]; ?></td>
                <td>
                    <?php echo $this->Form->control('EXPLOSIVES_VALUE', array('class'=>'form-control form-control-sm number-fields quantity', 'id'=>'EXPLOSIVES_VALUE', 'label'=>false, 'value'=>$matConsData['EXPLOSIVES_VALUE'])); ?>
                    <div class="err_cv"></div>
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold"><?php echo $label[18]; ?></td>
                <td><?php echo $label['nos']; ?></td>
                <td>
                    <?php echo $this->Form->control('TYRES_QUANTITY', array('class'=>'form-control form-control-sm number-fields', 'id'=>'TYRES_QUANTITY', 'label'=>false, 'value'=>$matConsData['TYRES_QUANTITY'])); ?>
                    <div class="err_cv"></div>
                </td>
                <td>
                    <?php echo $this->Form->control('TYRES_VALUE', array('class'=>'form-control form-control-sm number-fields value', 'id'=>'TYRES_VALUE', 'label'=>false, 'value'=>$matConsData['TYRES_VALUE'])); ?>
                    <div class="err_cv"></div>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="font-weight-bold"><?php echo $label[19]; ?></td>
                <td>
                    <?php echo $this->Form->control('TIMBER_VALUE', array('class'=>'form-control form-control-sm number-fields', 'id'=>'TIMBER_VALUE', 'label'=>false, 'value'=>$matConsData['TIMBER_VALUE'])); ?>
                    <div class="err_cv"></div>
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold"><?php echo $label[20]; ?></td>
                <td><?php echo $label['nos']; ?></td>
                <td>
                    <?php echo $this->Form->control('DRILL_QUANTITY', array('class'=>'form-control form-control-sm number-fields quantity', 'id'=>'DRILL_QUANTITY', 'label'=>false, 'value'=>$matConsData['DRILL_QUANTITY'])); ?>
                    <div class="err_cv"></div>
                </td>
                <td>
                    <?php echo $this->Form->control('DRILL_VALUE', array('class'=>'form-control form-control-sm number-fields value', 'id'=>'DRILL_VALUE', 'label'=>false, 'value'=>$matConsData['DRILL_VALUE'])); ?>
                    <div class="err_cv"></div>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="font-weight-bold"><?php echo $label[21]; ?></td>
                <td>
                    <?php echo $this->Form->control('OTHER_VALUE', array('class'=>'form-control form-control-sm number-fields', 'id'=>'OTHER_VALUE', 'label'=>false, 'value'=>$matConsData['OTHER_VALUE'])); ?>
                    <div class="err_cv"></div>
                </td>
            </tr>
        </tbody>
    </table>
</div>


<?php echo $this->Form->control('form_no', array('type'=>'hidden', 'value'=>$formId)); ?>
<?php echo $this->Form->control('mine_code', array('type'=>'hidden', 'value'=>$mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType)); ?>
<?php echo $this->Form->control('return_date', array('type'=>'hidden', 'value'=>$returnDate)); ?>
<?php echo $this->Form->control('return_year', array('type'=>'hidden', 'value'=>$returnYear)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'form_id_name', 'value'=>'materialConsumptionQuantity')); ?>

<?php echo $this->Html->script('g/material_consumption_quantity.js?version='.$version); ?>
