<h5 class="card-title text-center"><?php echo $label['title']; ?></h5>
<label><?php echo $label[0]; ?></label>
<table class="table table-bordered">
    <thead class="bg-secondary text-white">
        <tr>
            <th></th>
            <th></th>
            <th class="align-middle text-center"><?php echo $label[1]; ?></th>
            <th class="align-middle text-center"><?php echo $label[2]; ?></th>
            <th class="align-middle text-center"><?php echo $label[3]; ?></th>
            <th class="align-middle text-center"><?php echo $label[4]; ?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td rowspan="2"><?php echo $label[5]; ?></td>
            <td><?php echo $label[6]; ?></td>
            <td>
                <?php echo $this->Form->control('E[BEGIN_HOLES_DRILLING]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_BEGIN_HOLES_DRILLING', 'label'=>false, 'value'=>$formData['begin_holes_drilling'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('E[DURING_HOLES_DRILLING]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_DURING_HOLES_DRILLING', 'label'=>false, 'value'=>$formData['during_holes_drilling'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('E[CUMU_HOLES_DRILLING]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_CUMU_HOLES_DRILLING', 'label'=>false, 'value'=>$formData['cumu_holes_drilling'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('E[GRIDE_HOLES_DRILLING]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_GRIDE_HOLES_DRILLING', 'label'=>false, 'value'=>$formData['gride_holes_drilling'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td><?php echo $label[7]; ?></td>
            <td>
                <?php echo $this->Form->control('E[BEGIN_METRAGE_DRILLING]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_BEGIN_METRAGE_DRILLING', 'label'=>false, 'value'=>$formData['begin_metrage_drilling'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('E[DURING_METRAGE_DRILLING]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_DURING_METRAGE_DRILLING', 'label'=>false, 'value'=>$formData['during_metrage_drilling'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('E[CUMU_METRAGE_DRILLING]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_CUMU_METRAGE_DRILLING', 'label'=>false, 'value'=>$formData['cumu_metrage_drilling'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('E[GRIDE_METRAGE_DRILLING]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_GRIDE_METRAGE_DRILLING', 'label'=>false, 'value'=>$formData['gride_metrage_drilling'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td rowspan="2"><?php echo $label[8]; ?></td>
            <td><?php echo $label[9]; ?></td>
            <td>
                <?php echo $this->Form->control('E[BEGIN_PITS_PITTING]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_BEGIN_PITS_PITTING', 'label'=>false, 'value'=>$formData['begin_pits_pitting'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('E[DURING_PITS_PITTING]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_DURING_PITS_PITTING', 'label'=>false, 'value'=>$formData['during_pits_pitting'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('E[CUMU_PITS_PITTING]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_CUMU_PITS_PITTING', 'label'=>false, 'value'=>$formData['cumu_pits_pitting'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('E[GRIDE_PITS_PITTING]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_GRIDE_PITS_PITTING', 'label'=>false, 'value'=>$formData['gride_pits_pitting'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td><?php echo $label[10]; ?></td>
            <td>
                <?php echo $this->Form->control('E[BEGIN_EXCAV_PITTING]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_BEGIN_EXCAV_PITTING', 'label'=>false, 'value'=>$formData['begin_excav_pitting'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('E[DURING_EXCAV_PITTING]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_DURING_EXCAV_PITTING', 'label'=>false, 'value'=>$formData['during_excav_pitting'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('E[CUMU_EXCAV_PITTING]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_CUMU_EXCAV_PITTING', 'label'=>false, 'value'=>$formData['cumu_excav_pitting'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('E[GRIDE_EXCAV_PITTING]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_GRIDE_EXCAV_PITTING', 'label'=>false, 'value'=>$formData['gride_excav_pitting'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td rowspan="3"><?php echo $label[11]; ?></td>
            <td><?php echo $label[12]; ?></td>
            <td>
                <?php echo $this->Form->control('E[BEGIN_TRENCHES_TRENCH]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_BEGIN_TRENCHES_TRENCH', 'label'=>false, 'value'=>$formData['begin_trenches_trench'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('E[DURING_TRENCHES_TRENCH]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_DURING_TRENCHES_TRENCH', 'label'=>false, 'value'=>$formData['during_trenches_trench'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('E[CUMU_TRENCHES_TRENCH]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_CUMU_TRENCHES_TRENCH', 'label'=>false, 'value'=>$formData['cumu_trenches_trench'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('E[GRIDE_TRENCHES_TRENCH]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_GRIDE_TRENCHES_TRENCH', 'label'=>false, 'value'=>$formData['gride_trenches_trench'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td><?php echo $label[13]; ?></td>
            <td>
                <?php echo $this->Form->control('E[BEGIN_EXCAV_TRENCH]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_BEGIN_EXCAV_TRENCH', 'label'=>false, 'value'=>$formData['begin_excav_trench'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('E[DURING_EXCAV_TRENCH]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_DURING_EXCAV_TRENCH', 'label'=>false, 'value'=>$formData['during_excav_trench'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('E[CUMU_EXCAV_TRENCH]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_CUMU_EXCAV_TRENCH', 'label'=>false, 'value'=>$formData['cumu_excav_trench'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('E[GRIDE_EXCAV_TRENCH]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_GRIDE_EXCAV_TRENCH', 'label'=>false, 'value'=>$formData['gride_excav_trench'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td><?php echo $label[14]; ?></td>
            <td>
                <?php echo $this->Form->control('E[BEGIN_LENGTH_TRENCH]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_BEGIN_LENGTH_TRENCH', 'label'=>false, 'value'=>$formData['begin_length_trench'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('E[DURING_LENGTH_TRENCH]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_DURING_LENGTH_TRENCH', 'label'=>false, 'value'=>$formData['during_length_trench'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('E[CUMU_LENGTH_TRENCH]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_CUMU_LENGTH_TRENCH', 'label'=>false, 'value'=>$formData['cumu_length_trench'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('E[GRIDE_LENGTH_TRENCH]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_GRIDE_LENGTH_TRENCH', 'label'=>false, 'value'=>$formData['gride_length_trench'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td colspan="2"><?php echo $label[15]; ?></td>
            <td>
                <?php echo $this->Form->control('E[BEGIN_EXPENDITURE]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_BEGIN_EXPENDITURE', 'label'=>false, 'value'=>$formData['begin_expenditure'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('E[DURING_EXPENDITURE]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_DURING_EXPENDITURE', 'label'=>false, 'value'=>$formData['during_expenditure'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('E[CUMU_EXPENDITURE]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_CUMU_EXPENDITURE', 'label'=>false, 'value'=>$formData['cumu_expenditure'])); ?>
                <div class="err_cv"></div>
            </td>
            <td>
                <?php echo $this->Form->control('E[GRIDE_EXPENDITURE]', array('class'=>'form-control form-control-sm number-fields-small', 'id'=>'E_GRIDE_EXPENDITURE', 'label'=>false, 'value'=>$formData['gride_expenditure'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
    </tbody>
</table>
<div class="position-relative row form-group">
	<div class="col-sm-5">
        <label><?php echo $label[16]; ?></label>
    </div>
	<div class="col-sm-6">
        <?php echo $this->Form->textarea('E[OTHER_EXPLOR_ACTIVITY]', array('class'=>'form-control form-control-sm', 'id'=>'E_OTHER_EXPLOR_ACTIVITY', 'rows'=>'3', 'label'=>false, 'value'=>$formData['other_explor_activity'])); ?>
        <div class="err_cv"></div>
	</div>
</div>

<?php echo $this->Form->control('form_no', array('type'=>'hidden', 'value'=>$formId)); ?>
<?php echo $this->Form->control('mine_code', array('type'=>'hidden', 'value'=>$mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType)); ?>
<?php echo $this->Form->control('return_date', array('type'=>'hidden', 'value'=>$returnDate)); ?>
<?php echo $this->Form->control('return_year', array('type'=>'hidden', 'value'=>$returnYear)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'form_id_name', 'value'=>'frmgeologyExploration')); ?>

<?php echo $this->Html->script('g/geology_exploration.js?version='.$version); ?>
