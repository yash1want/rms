
<h5 class="card-title text-center"><?php echo $label['title']; ?></h5>
<table class="table table-sm">
    <thead class="bg-secondary text-white">
        <tr>
            <th></th>
            <th class="text-center"><?php echo $label[0]; ?></th>
            <th class="text-center"><?php echo $label[1]; ?></th>
            <th class="text-center"><?php echo $label[2]; ?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $label[3]; ?></td>
            <td>
                <?php echo $this->Form->control('FOREST_ABANDONED_AREA', array('class'=>'form-control form-control-sm text-fields right', 'id'=>'FOREST_ABANDONED_AREA', 'label'=>false, 'value'=>$lease['forest_abandoned_area'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('NON_FOREST_ABANDONED_AREA', array('class'=>'form-control form-control-sm text-fields right', 'id'=>'NON_FOREST_ABANDONED_AREA', 'label'=>false, 'value'=>$lease['non_forest_abandoned_area'])); ?>
                <div class="err_cv"></div>
            </td>
            <td class="bg-light">
                <?php echo $this->Form->control('TOTAL_ABANDONED_AREA', array('class'=>'form-control form-control-sm text-fields right', 'id'=>'TOTAL_ABANDONED_AREA', 'label'=>false, 'value'=>$lease['total_abandoned_area'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td><?php echo $label[4]; ?></td>
            <td>
                <?php echo $this->Form->control('FOREST_WORKING_AREA', array('class'=>'form-control form-control-sm text-fields right', 'id'=>'FOREST_WORKING_AREA', 'label'=>false, 'value'=>$lease['forest_working_area'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('NON_FOREST_WORKING_AREA', array('class'=>'form-control form-control-sm text-fields right', 'id'=>'NON_FOREST_WORKING_AREA', 'label'=>false, 'value'=>$lease['non_forest_working_area'])); ?>
                <div class="err_cv"></div>
            </td>
            <td class="bg-light">
                <?php echo $this->Form->control('TOTAL_WORKING_AREA', array('class'=>'form-control form-control-sm text-fields right', 'id'=>'TOTAL_WORKING_AREA', 'label'=>false, 'value'=>$lease['total_working_area'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td><?php echo $label[5]; ?></td>
            <td>
                <?php echo $this->Form->control('FOREST_RECLAIMED_AREA', array('class'=>'form-control form-control-sm text-fields right', 'id'=>'FOREST_RECLAIMED_AREA', 'label'=>false, 'value'=>$lease['forest_reclaimed_area'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('NON_FOREST_RECLAIMED_AREA', array('class'=>'form-control form-control-sm text-fields right', 'id'=>'NON_FOREST_RECLAIMED_AREA', 'label'=>false, 'value'=>$lease['non_forest_reclaimed_area'])); ?>
                <div class="err_cv"></div>
            </td>
            <td class="bg-light">
                <?php echo $this->Form->control('TOTAL_RECLAIMED_AREA', array('class'=>'form-control form-control-sm text-fields right', 'id'=>'TOTAL_RECLAIMED_AREA', 'label'=>false, 'value'=>$lease['total_reclaimed_area'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td><?php echo $label[6]; ?></td>
            <td>
                <?php echo $this->Form->control('FOREST_WASTE_AREA', array('class'=>'form-control form-control-sm text-fields right', 'id'=>'FOREST_WASTE_AREA', 'label'=>false, 'value'=>$lease['forest_waste_area'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('NON_FOREST_WASTE_AREA', array('class'=>'form-control form-control-sm text-fields right', 'id'=>'NON_FOREST_WASTE_AREA', 'label'=>false, 'value'=>$lease['non_forest_waste_area'])); ?>
                <div class="err_cv"></div>
            </td>
            <td class="bg-light">
                <?php echo $this->Form->control('TOTAL_WASTE_AREA', array('class'=>'form-control form-control-sm text-fields right', 'id'=>'TOTAL_WASTE_AREA', 'label'=>false, 'value'=>$lease['total_waste_area'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td><?php echo $label[7]; ?></td>
            <td>
                <?php echo $this->Form->control('FOREST_BUILDING_AREA', array('class'=>'form-control form-control-sm text-fields right', 'id'=>'FOREST_BUILDING_AREA', 'label'=>false, 'value'=>$lease['forest_building_area'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('NON_FOREST_BUILDING_AREA', array('class'=>'form-control form-control-sm text-fields right', 'id'=>'NON_FOREST_BUILDING_AREA', 'label'=>false, 'value'=>$lease['non_forest_building_area'])); ?>
                <div class="err_cv"></div>
            </td>
            <td class="bg-light">
                <?php echo $this->Form->control('TOTAL_BUILDING_AREA', array('class'=>'form-control form-control-sm text-fields right', 'id'=>'TOTAL_BUILDING_AREA', 'label'=>false, 'value'=>$lease['total_building_area'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $label[8]; ?>
                <?php echo $this->Form->control('OTHER_PURPOSE', array('class'=>'form-control form-control-sm text-fields right col-sm-8 ml-4', 'id'=>'OTHER_PURPOSE', 'label'=>false, 'value'=>$lease['other_purpose'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('FOREST_OTHER_AREA', array('class'=>'form-control form-control-sm text-fields right', 'id'=>'FOREST_OTHER_AREA', 'label'=>false, 'value'=>$lease['forest_other_area'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('NON_FOREST_OTHER_AREA', array('class'=>'form-control form-control-sm text-fields right', 'id'=>'NON_FOREST_OTHER_AREA', 'label'=>false, 'value'=>$lease['non_forest_other_area'])); ?>
                <div class="err_cv"></div>
            </td>
            <td class="bg-light">
                <?php echo $this->Form->control('TOTAL_OTHER_AREA', array('class'=>'form-control form-control-sm text-fields right', 'id'=>'TOTAL_OTHER_AREA', 'label'=>false, 'value'=>$lease['total_other_area'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td><?php echo $label[9]; ?></td>
            <td>
                <?php echo $this->Form->control('FOREST_PROGRESSIVE_AREA', array('class'=>'form-control form-control-sm text-fields right', 'id'=>'FOREST_PROGRESSIVE_AREA', 'label'=>false, 'value'=>$lease['forest_progressive_area'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('NON_FOREST_PROGRESSIVE_AREA', array('class'=>'form-control form-control-sm text-fields right', 'id'=>'NON_FOREST_PROGRESSIVE_AREA', 'label'=>false, 'value'=>$lease['non_forest_progressive_area'])); ?>
                <div class="err_cv"></div>
            </td>
            <td class="bg-light">
                <?php echo $this->Form->control('TOTAL_PROGRESSIVE_AREA', array('class'=>'form-control form-control-sm text-fields right', 'id'=>'TOTAL_PROGRESSIVE_AREA', 'label'=>false, 'value'=>$lease['total_progressive_area'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td><?php echo $label[10]; ?><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $label[11]; ?></td>
            <td colspan="3">
                <?php echo $this->Form->select('AGENCY', $agency_choices, array('id'=>'AGENCY', 'class'=>'form-control form-control-sm', 'value'=>$lease['agency'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
    </tbody>
</table>

<?php 

	echo $this->Form->control('form_no', array('type'=>'hidden', 'value'=>$formId));
	echo $this->Form->control('mine_code', array('type'=>'hidden', 'value'=>$mineCode));
	echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType));
	echo $this->Form->control('return_date', array('type'=>'hidden', 'value'=>$returnDate));
	echo $this->Form->control('return_year', array('type'=>'hidden', 'value'=>$returnYear));
	echo $this->Form->control('', array('type'=>'hidden', 'id'=>'form_id_name', 'value'=>'frmAreaUtilisation'));

	echo $this->Html->script('g/area_utilisation.js?version='.$version);

?>
