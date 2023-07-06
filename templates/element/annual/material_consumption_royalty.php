
<div class="position-relative row form-group mine-group border-top-0">
	<div class="col-sm-12 font-weight-bold">
		<?php echo $label[0]; ?>
	</div>
	<div class="col-sm-12">
		<table class="table table-bordered table-sm">
            <thead class="bg-secondary text-white">
                <tr>
                    <th></th>
                    <th class="w-25"><?php echo $label[1]; ?></th>
                    <th class="w-25"><?php echo $label[2]; ?></th>
                </tr>
            </thead>
            <?php 
            
            // Check if monthly return array present
            // If exits, highlight modified data in annual as compare to monthly

            $item = array('ROYALTY_CURRENT', 'DEAD_RENT_CURRENT', 'SURFACE_RENT_CURRENT', 'CURRENT_PAY_DMF', 'CURRENT_PAY_NMET');
            for ($i = 0; $i < 5; $i++) {

                $diff[$item[$i]]['class'] = '';
                $diff[$item[$i]]['title'] = '';
                    
                if (isset($matConsRoyDataMonthly)) {

                    $mcrDataOld = $matConsRoyDataMonthly;

                    $itemOld = $mcrDataOld[$item[$i]];
                    $itemNew = $matConsRoyData[$item[$i]];
                    if ($itemOld != $itemNew) {
                        $itemDiff = $itemNew - $itemOld;
                        $diff[$item[$i]]['title'] = ($itemDiff > 0) ? '+'.$itemDiff : $itemDiff;
                        $diff[$item[$i]]['class'] = ' in_new';
                    }

                }
            }

            ?>
            <tbody>
                <tr>
                    <td><?php echo $label[3]; ?></td>
                    <td>
                        <?php echo $this->Form->control('ROYALTY_CURRENT', array('class'=>'form-control form-control-sm number-fields'.$diff['ROYALTY_CURRENT']['class'], 'id'=>'ROYALTY_CURRENT', 'label'=>false, 'title'=>$diff['ROYALTY_CURRENT']['title'], 'value'=>$matConsRoyData['ROYALTY_CURRENT'])); ?>
                        <div class="err_cv"></div>
                    </td>
                    <td>
                        <?php echo $this->Form->control('ROYALTY_PAST', array('class'=>'form-control form-control-sm number-fields', 'id'=>'ROYALTY_PAST', 'label'=>false, 'value'=>$matConsRoyData['ROYALTY_PAST'])); ?>
                        <div class="err_cv"></div>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $label[4]; ?></td>
                    <td>
                        <?php echo $this->Form->control('DEAD_RENT_CURRENT', array('class'=>'form-control form-control-sm number-fields'.$diff['DEAD_RENT_CURRENT']['class'], 'id'=>'DEAD_RENT_CURRENT', 'label'=>false, 'title'=>$diff['DEAD_RENT_CURRENT']['title'], 'value'=>$matConsRoyData['DEAD_RENT_CURRENT'])); ?>
                        <div class="err_cv"></div>
                    </td>
                    <td>
                        <?php echo $this->Form->control('DEAD_RENT_PAST', array('class'=>'form-control form-control-sm number-fields', 'id'=>'DEAD_RENT_PAST', 'label'=>false, 'value'=>$matConsRoyData['DEAD_RENT_PAST'])); ?>
                        <div class="err_cv"></div>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $label[5]; ?></td>
                    <td>
                        <?php echo $this->Form->control('SURFACE_RENT_CURRENT', array('class'=>'form-control form-control-sm number-fields'.$diff['SURFACE_RENT_CURRENT']['class'], 'id'=>'SURFACE_RENT_CURRENT', 'label'=>false, 'title'=>$diff['SURFACE_RENT_CURRENT']['title'], 'value'=>$matConsRoyData['SURFACE_RENT_CURRENT'])); ?>
                        <div class="err_cv"></div>
                    </td>
                    <td>
                        <?php echo $this->Form->control('SURFACE_RENT_PAST', array('class'=>'form-control form-control-sm number-fields', 'id'=>'SURFACE_RENT_PAST', 'label'=>false, 'value'=>$matConsRoyData['SURFACE_RENT_PAST'])); ?>
                        <div class="err_cv"></div>
                    </td>
                </tr>
                <!-- Added four new fields below as per MCDR 2017 -->
                <!-- "CURRENT_PAY_DMF", "PAST_PAY_DMF", "CURRENT_PAY_NMET", "PAST_PAY_NMET" -->
                <tr>
                    <td><?php echo $label[6]; ?></td>
                    <td>
                        <?php echo $this->Form->control('CURRENT_PAY_DMF', array('class'=>'form-control form-control-sm number-fields'.$diff['CURRENT_PAY_DMF']['class'], 'id'=>'CURRENT_PAY_DMF', 'label'=>false, 'title'=>$diff['CURRENT_PAY_DMF']['title'], 'value'=>$matConsRoyData['CURRENT_PAY_DMF'])); ?>
                        <div class="err_cv"></div>
                    </td>
                    <td>
                        <?php echo $this->Form->control('PAST_PAY_DMF', array('class'=>'form-control form-control-sm number-fields', 'id'=>'PAST_PAY_DMF', 'label'=>false, 'value'=>$matConsRoyData['PAST_PAY_DMF'])); ?>
                        <div class="err_cv"></div>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $label[7]; ?></td>
                    <td>
                        <?php echo $this->Form->control('CURRENT_PAY_NMET', array('class'=>'form-control form-control-sm number-fields'.$diff['CURRENT_PAY_NMET']['class'], 'id'=>'CURRENT_PAY_NMET', 'label'=>false, 'title'=>$diff['CURRENT_PAY_NMET']['title'], 'value'=>$matConsRoyData['CURRENT_PAY_NMET'])); ?>
                        <div class="err_cv"></div>
                    </td>
                    <td>
                        <?php echo $this->Form->control('PAST_PAY_NMET', array('class'=>'form-control form-control-sm number-fields', 'id'=>'PAST_PAY_NMET', 'label'=>false, 'value'=>$matConsRoyData['PAST_PAY_NMET'])); ?>
                        <div class="err_cv"></div>
                    </td>
                </tr>
            </tbody>
        </table>
	</div>
</div>

<div class="position-relative row form-group mine-group">
	<div class="col-sm-9 font-weight-bold">
		<?php echo $label[8]; ?>
	</div>
	<div class="col-sm-3 mine-m-auto">
        <?php echo $this->Form->control('TREE_COMPENSATION', array('class'=>'form-control form-control-sm number-fields', 'id'=>'TREE_COMPENSATION', 'label'=>false, 'value'=>$matConsRoyData['TREE_COMPENSATION'])); ?>
        <div class="err_cv"></div>
	</div>
</div>

<div class="position-relative row form-group mine-group">
	<div class="col-sm-9 font-weight-bold">
		<?php echo $label[9]; ?>
	</div>
	<div class="col-sm-3 mine-m-auto">
        <?php echo $this->Form->control('DEPRECIATION', array('class'=>'form-control form-control-sm number-fields', 'id'=>'DEPRECIATION', 'label'=>false, 'value'=>$matConsRoyData['DEPRECIATION'])); ?>
        <div class="err_cv"></div>
	</div>
</div>

<?php echo $this->Form->control('form_no', array('type'=>'hidden', 'value'=>$formId)); ?>
<?php echo $this->Form->control('mine_code', array('type'=>'hidden', 'value'=>$mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType)); ?>
<?php echo $this->Form->control('return_date', array('type'=>'hidden', 'value'=>$returnDate)); ?>
<?php echo $this->Form->control('return_year', array('type'=>'hidden', 'value'=>$returnYear)); ?>
<?php echo $this->Form->control('depreciation_org', array('type'=>'hidden', 'id'=>'depreciation_org', 'value'=>$depriciationTotal)); ?>
<?php echo $this->Form->control('monthly_royalty_total', array('type'=>'hidden', 'id'=>'monthly_royalty_total', 'value'=>$monthlyRoyaltyTotal)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'form_id_name', 'value'=>'materialConsumptionRoyalty')); ?>

<?php echo $this->Html->script('g/material_consumption_royalty.js?version='.$version); ?>
