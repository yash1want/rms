
<h5 class="card-title text-center"><?php echo $label[0]; ?></h5>
<div class="position-relative row form-group mine-group border-top-0">
    <table class="table table-bordered table-sm">
        <thead class="bg-secondary text-white">
            <tr>
                <th rowspan="2"></th>
                <th colspan="2"><?php echo $label[1]; ?></th>
            </tr>
            <tr>
                <th class="w-25"><?php echo $label[2]; ?></th>
                <th class="w-25"><?php echo $label[3]; ?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="w_28p">(i)</td>
                                <td><?php echo $label[4]; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    <?php echo $this->Form->control('SALES_TAX_CENTRAL', array('class'=>'form-control form-control-sm number-fields', 'id'=>'SALES_TAX_CENTRAL', 'label'=>false, 'value'=>$matConsTaxData['SALES_TAX_CENTRAL'])); ?>
                    <div class="err_cv"></div>
                </td>
                <td>
                    <?php echo $this->Form->control('SALES_TAX_STATE', array('class'=>'form-control form-control-sm number-fields', 'id'=>'SALES_TAX_STATE', 'label'=>false, 'value'=>$matConsTaxData['SALES_TAX_STATE'])); ?>
                    <div class="err_cv"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="w_28p">(ii)</td>
                                <td><?php echo $label[5]; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    <?php echo $this->Form->control('WELFARE_TAX_CENTRAL', array('class'=>'form-control form-control-sm number-fields', 'id'=>'WELFARE_TAX_CENTRAL', 'label'=>false, 'value'=>$matConsTaxData['WELFARE_TAX_CENTRAL'])); ?>
                    <div class="err_cv"></div>
                </td>
                <td>
                    <?php echo $this->Form->control('WELFARE_TAX_STATE', array('class'=>'form-control form-control-sm number-fields', 'id'=>'WELFARE_TAX_STATE', 'label'=>false, 'value'=>$matConsTaxData['WELFARE_TAX_STATE'])); ?>
                    <div class="err_cv"></div>
                </td>
            </tr>
            <tr>
                <td class="border-right-0">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="w_28p">(iii)</td>
                                <td><?php echo $label[6]; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td colspan="2" class="border-left-0"></td>
            </tr>
            <tr>
                <td>
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="w_28p"></td>
                                <td><?php echo $label[7]; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    <?php echo $this->Form->control('MIN_CESS_TAX_CENTRAL', array('class'=>'form-control form-control-sm number-fields', 'id'=>'MIN_CESS_TAX_CENTRAL', 'label'=>false, 'value'=>$matConsTaxData['MIN_CESS_TAX_CENTRAL'])); ?>
                    <div class="err_cv"></div>
                </td>
                <td>
                    <?php echo $this->Form->control('MIN_CESS_TAX_STATE', array('class'=>'form-control form-control-sm number-fields', 'id'=>'MIN_CESS_TAX_STATE', 'label'=>false, 'value'=>$matConsTaxData['MIN_CESS_TAX_STATE'])); ?>
                    <div class="err_cv"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="w_28p"></td>
                                <td><?php echo $label[8]; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    <?php echo $this->Form->control('DEAD_CESS_TAX_CENTRAL', array('class'=>'form-control form-control-sm number-fields', 'id'=>'DEAD_CESS_TAX_CENTRAL', 'label'=>false, 'value'=>$matConsTaxData['DEAD_CESS_TAX_CENTRAL'])); ?>
                    <div class="err_cv"></div>
                </td>
                <td>
                    <?php echo $this->Form->control('DEAD_CESS_TAX_STATE', array('class'=>'form-control form-control-sm number-fields', 'id'=>'DEAD_CESS_TAX_STATE', 'label'=>false, 'value'=>$matConsTaxData['DEAD_CESS_TAX_STATE'])); ?>
                    <div class="err_cv"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="w_28p" rowspan="2"></td>
                                <td><?php echo $label[9]; ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo $this->Form->control('OTHER_TAX', array('class'=>'form-control form-control-sm number-fields', 'id'=>'OTHER_TAX', 'label'=>false, 'value'=>$matConsTaxData['OTHER_TAX'])); ?>
                                    <div class="err_cv"></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    <?php echo $this->Form->control('OTHER_TAX_CENTRAL', array('class'=>'form-control form-control-sm number-fields', 'id'=>'OTHER_TAX_CENTRAL', 'label'=>false, 'value'=>$matConsTaxData['OTHER_TAX_CENTRAL'])); ?>
                    <div class="err_cv"></div>
                </td>
                <td>
                    <?php echo $this->Form->control('OTHER_TAX_STATE', array('class'=>'form-control form-control-sm number-fields', 'id'=>'OTHER_TAX_STATE', 'label'=>false, 'value'=>$matConsTaxData['OTHER_TAX_STATE'])); ?>
                    <div class="err_cv"></div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<h5 class="card-title text-center"><?php echo $label[10]; ?></h5>
<div class="position-relative row form-group mine-group border-top-0">
    <table class="table table-bordered table-sm">
        <tbody>
            <tr>
                <td>
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="w_28p">(i)</td>
                                <td><?php echo $label[11]; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td class="w-25">
                    <?php echo $this->Form->control('OVERHEADS', array('class'=>'form-control form-control-sm number-fields', 'id'=>'OVERHEADS', 'label'=>false, 'value'=>$matConsTaxData['OVERHEADS'])); ?>
                    <div class="err_cv"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="w_28p">(ii)</td>
                                <td><?php echo $label[12]; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    <?php echo $this->Form->control('MAINTENANCE', array('class'=>'form-control form-control-sm number-fields', 'id'=>'MAINTENANCE', 'label'=>false, 'value'=>$matConsTaxData['MAINTENANCE'])); ?>
                    <div class="err_cv"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="w_28p">(iii)</td>
                                <td><?php echo $label[13]; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    <?php echo $this->Form->control('WORKMEN_BENEFITS', array('class'=>'form-control form-control-sm number-fields', 'id'=>'WORKMEN_BENEFITS', 'label'=>false, 'value'=>$matConsTaxData['WORKMEN_BENEFITS'])); ?>
                    <div class="err_cv"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="w_28p">(iv)</td>
                                <td><?php echo $label[14]; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    <?php echo $this->Form->control('PAYMENT_AGENCIES', array('class'=>'form-control form-control-sm number-fields', 'id'=>'PAYMENT_AGENCIES', 'label'=>false, 'value'=>$matConsTaxData['PAYMENT_AGENCIES'])); ?>
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
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'form_id_name', 'value'=>'materialConsumptionTax')); ?>

<?php echo $this->Html->script('g/material_consumption_tax.js?version='.$version); ?>
