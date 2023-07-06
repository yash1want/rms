
<!-- <h5 class="card-title text-center"><?php //echo $label['title']; ?></h5> -->
<div class="alert alert-info p-1 pl-2 mb-1"><?php echo $label[0]; ?></div>
<table class="table table-bordered table-sm">
    <thead class="bg-secondary text-white">
        <tr>
            <th><?php echo $label[1]; ?></th>
            <th><?php echo $label[2]; ?></th>
            <th><?php echo $label[3]; ?></th>
        </tr>
    </thead>
    <tbody class="font-weight-bold">
        <tr>
            <td>(i)</td>
            <td><?php echo $label[4]; ?></td>
            <td>
                <?php echo $this->Form->control('TOTAL_DIRECT_COST', array('class'=>'form-control form-control-sm number-fields prod_cost cvOn cvFloatRestrict',  'cvfloat'=>'999999999999.99', 'id'=>'TOTAL_DIRECT_COST', 'label'=>false, 'value'=>$costData['total_direct_cost'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><?php echo $label[5]; ?></td>
            <td>
                <?php echo $this->Form->control('EXPLORATION_COST', array('class'=>'form-control form-control-sm number-fields prod_cost cvOn cvFloatRestrict',  'cvfloat'=>'999999999999.99', 'id'=>'EXPLORATION_COST', 'label'=>false, 'value'=>$costData['exploration_cost'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><?php echo $label[6]; ?></td>
            <td>
                <?php echo $this->Form->control('MINING_COST', array('class'=>'form-control form-control-sm number-fields prod_cost cvOn cvFloatRestrict',  'cvfloat'=>'999999999999.99', 'id'=>'MINING_COST', 'label'=>false, 'value'=>$costData['mining_cost'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><?php echo $label[7]; ?></td>
            <td>
                <?php echo $this->Form->control('BENEFICIATION_COST', array('class'=>'form-control form-control-sm number-fields prod_cost cvOn cvFloatRestrict',  'cvfloat'=>'999999999999.99', 'id'=>'BENEFICIATION_COST', 'label'=>false, 'value'=>$costData['beneficiation_cost'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td>(ii)</td>
            <td><?php echo $label[8]; ?></td>
            <td>
                <?php echo $this->Form->control('OVERHEAD_COST', array('class'=>'form-control form-control-sm number-fields prod_cost cvOn cvFloatRestrict',  'cvfloat'=>'999999999999.99', 'id'=>'OVERHEAD_COST', 'label'=>false, 'value'=>$costData['overhead_cost'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td>(iii)</td>
            <td><?php echo $label[9]; ?></td>
            <td>
                <?php echo $this->Form->control('DEPRECIATION_COST', array('class'=>'form-control form-control-sm number-fields prod_cost cvOn cvFloatRestrict',  'cvfloat'=>'999999999999.99', 'id'=>'DEPRECIATION_COST', 'label'=>false, 'value'=>$costData['depreciation_cost'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td>(iv)</td>
            <td><?php echo $label[10]; ?></td>
            <td>
                <?php echo $this->Form->control('INTEREST_COST', array('class'=>'form-control form-control-sm number-fields prod_cost cvOn cvFloatRestrict',  'cvfloat'=>'999999999999.99', 'id'=>'INTEREST_COST', 'label'=>false, 'value'=>$costData['interest_cost'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td>(v)</td>
            <td><?php echo $label[11]; ?> <span title="<?php echo $label[13]; ?>" class="text-success">(<?php echo $label[12]; ?>)</span></td>
            <td>
                <?php echo $this->Form->control('ROYALTY_COST', array('class'=>'form-control form-control-sm number-fields prod_cost cvOn cvFloatRestrict',  'cvfloat'=>'999999999999.99', 'id'=>'ROYALTY_COST', 'label'=>false, 'value'=>$costData['royalty_cost'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td>(vi)</td>
            <td><?php echo $label[14]; ?></td>
            <td>
                <?php echo $this->Form->control('PAST_PAY_DMF', array('class'=>'form-control form-control-sm number-fields prod_cost cvOn cvFloatRestrict',  'cvfloat'=>'999999999999.99', 'id'=>'PAST_PAY_DMF', 'label'=>false, 'value'=>$costData['past_pay_dmf'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td>(vii)</td>
            <td><?php echo $label[15]; ?></td>
            <td>
                <?php echo $this->Form->control('PAST_PAY_NMET', array('class'=>'form-control form-control-sm number-fields prod_cost cvOn cvFloatRestrict',  'cvfloat'=>'999999999999.99', 'id'=>'PAST_PAY_NMET', 'label'=>false, 'value'=>$costData['past_pay_nmet'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td>(viii)</td>
            <td><?php echo $label[16]; ?></td>
            <td>
                <?php echo $this->Form->control('TAXES_COST', array('class'=>'form-control form-control-sm number-fields prod_cost cvOn cvFloatRestrict',  'cvfloat'=>'999999999999.99', 'id'=>'TAXES_COST', 'label'=>false, 'value'=>$costData['taxes_cost'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td>(ix)</td>
            <td><?php echo $label[17]; ?></td>
            <td>
                <?php echo $this->Form->control('DEAD_RENT_COST', array('class'=>'form-control form-control-sm number-fields prod_cost cvOn cvFloatRestrict',  'cvfloat'=>'999999999999.99', 'id'=>'DEAD_RENT_COST', 'label'=>false, 'value'=>$costData['dead_rent_cost'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td>(x)</td>
            <td>
                <?php echo $label[18]; ?>
                <?php echo $this->Form->control('OTHERS_SPEC', array('class'=>'form-control form-control-sm number-fields', 'id'=>'OTHERS_SPEC', 'label'=>false, 'value'=>$costData['others_spec'], 'maxlength'=>'20')); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('OTHERS_COST', array('class'=>'form-control form-control-sm number-fields prod_cost cvOn cvFloatRestrict',  'cvfloat'=>'999999999999.99', 'id'=>'OTHERS_COST', 'label'=>false, 'value'=>$costData['others_cost'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
    </tbody>
    <thead class="bg-light font-weight-bold">
        <tr>
            <td></td>
            <td><?php echo $label[19]; ?></td>
            <td>
                <?php echo $this->Form->control('TOTAL_COST', array('class'=>'form-control form-control-sm number-fields prod_cost', 'id'=>'TOTAL_COST', 'label'=>false, 'value'=>$costData['total_cost'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
    </thead>
</table>
<div class="alert alert-info p-1 pl-2 mb-1"><?php echo $label['note']; ?></div>

<?php echo $this->Form->control('form_no', array('type'=>'hidden', 'value'=>$formId)); ?>
<?php echo $this->Form->control('mine_code', array('type'=>'hidden', 'value'=>$mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType)); ?>
<?php echo $this->Form->control('return_date', array('type'=>'hidden', 'value'=>$returnDate)); ?>
<?php echo $this->Form->control('return_year', array('type'=>'hidden', 'value'=>$returnYear)); ?>
<?php echo $this->Form->control('over_head', array('type'=>'hidden', 'id'=>'over_head', 'value'=>$overHead)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'form_id_name', 'value'=>'frmProductionCost')); ?>

<?php echo $this->Html->script('g/production_cost.js?version='.$version); ?>
