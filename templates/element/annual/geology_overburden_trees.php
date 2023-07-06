
<h5 class="card-title text-center"><?php echo $label['title']; ?></h5>
<div class="alert alert-info p-1 pl-2 mb-1"><?php echo $label[0]; ?></div>
<table class="table table-bordered">
    <thead class="bg-secondary text-white">
        <tr>
            <th><?php echo $label[1]; ?></th>
            <th><?php echo $label[2]; ?></th>
            <th><?php echo $label[3]; ?></th>
            <th><?php echo $label[4]; ?></th>
            <th><?php echo $label[5]; ?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo $this->Form->control('O[AT_BEGINING_YR]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'O_AT_BEGINING_YR', 'label'=>false, 'value'=>$overburden['at_begining_yr'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('O[GENERATED_DY]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'O_GENERATED_DY', 'label'=>false, 'value'=>$overburden['generated_dy'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('O[DISPOSED_DY]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'O_DISPOSED_DY', 'label'=>false, 'value'=>$overburden['disposed_dy'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('O[BACKFILLED_DY]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'O_BACKFILLED_DY', 'label'=>false, 'value'=>$overburden['backfilled_dy'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('O[TOTAL_AT_EOY]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'O_TOTAL_AT_EOY', 'label'=>false, 'value'=>$overburden['total_at_eoy'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
    </tbody>
</table>

<h5 class="card-title text-center"><?php echo $label[6]; ?></h5>
<table class="table table-bordered">
    <thead class="bg-secondary text-white">
        <tr>
            <th><?php echo $label[7]; ?></th>
            <th><?php echo $label[8]; ?></th>
            <th><?php echo $label[9]; ?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $label[10]; ?></td>
            <td>
                <?php echo $this->Form->control('T[TREES_WI_LEASE]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'T_TREES_WI_LEASE', 'label'=>false, 'value'=>$treesPlant['trees_wi_lease'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('T[TREES_OS_LEASE]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'T_TREES_OS_LEASE', 'label'=>false, 'value'=>$treesPlant['trees_os_lease'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td><?php echo $label[11]; ?></td>
            <td>
                <?php echo $this->Form->control('T[SURV_WI_LEASE]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'T_SURV_WI_LEASE', 'label'=>false, 'value'=>$treesPlant['surv_wi_lease'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('T[SURV_OS_LEASE]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'T_SURV_OS_LEASE', 'label'=>false, 'value'=>$treesPlant['surv_os_lease'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td><?php echo $label[12]; ?></td>
            <td>
                <?php echo $this->Form->control('T[TTL_EOY_WI_LEASE]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'T_TTL_EOY_WI_LEASE', 'label'=>false, 'value'=>$treesPlant['ttl_eoy_wi_lease'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('T[TTL_EOY_OS_LEASE]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'T_TTL_EOY_OS_LEASE', 'label'=>false, 'value'=>$treesPlant['ttl_eoy_os_lease'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
    </tbody>
</table>

<?php echo $this->Form->control('form_no', array('type'=>'hidden', 'value'=>$formId)); ?>
<?php echo $this->Form->control('mine_code', array('type'=>'hidden', 'value'=>$mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType)); ?>
<?php echo $this->Form->control('return_date', array('type'=>'hidden', 'value'=>$returnDate)); ?>
<?php echo $this->Form->control('return_year', array('type'=>'hidden', 'value'=>$returnYear)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'form_id_name', 'value'=>'frmGeologyOverburdenTrees')); ?>

<?php echo $this->Html->script('g/geology_overburden_trees.js?version='.$version); ?>
