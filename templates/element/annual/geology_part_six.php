
<h5 class="card-title text-center"><?php echo $label['title']; ?></h5>
<table class="table table-bordered">
    <tbody>
        <tr>
            <td class="w-50"><?php echo $label[0] ?></td>
            <td>
                <?php echo $this->Form->textarea('MIN_TREATMENT_PLANT', array('class'=>'form-control form-control-sm text_area min_treatment', 'id'=>'MIN_TREATMENT_PLANT', 'rows'=>'3', 'label'=>false, 'value'=>$machineryData['static']['MIN_TREATMENT_PLANT'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?php echo $label[1]; ?>
                <table class="table table-sm mt-2">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th colspan="2" class="text-center"><?php echo $label[2]; ?></th>
                            <th class="text-center"><?php echo $label[3]; ?></th>
                            <th class="text-center"><?php echo $label[4]; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2"><?php echo $label[5]; ?></td>
                            <td>
                                <?php echo $this->Form->control('FEED_TONNAGE', array('class'=>'form-control form-control-sm number-fields-small feed_tonnage', 'id'=>'FEED_TONNAGE', 'label'=>false, 'value'=>$machineryData['static']['FEED_TONNAGE'])); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('FEED_AVG_GRADE', array('class'=>'form-control form-control-sm number-fields-small feed_avg_grade', 'id'=>'FEED_AVG_GRADE', 'label'=>false, 'value'=>$machineryData['static']['FEED_AVG_GRADE'])); ?>
                                <div class="err_cv"></div>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $label[6]; ?></td>
                            <td><?php echo $label[7]; ?></td>
                            <td>
                                <?php echo $this->Form->control('CONCEN_TONNAGE', array('class'=>'form-control form-control-sm number-fields-small feed_tonnage', 'id'=>'CONCEN_TONNAGE', 'label'=>false, 'value'=>$machineryData['static']['CONCEN_TONNAGE'])); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('CONCEN_AVG_GRADE', array('class'=>'form-control form-control-sm number-fields-small feed_avg_grade', 'id'=>'CONCEN_AVG_GRADE', 'label'=>false, 'value'=>$machineryData['static']['CONCEN_AVG_GRADE'])); ?>
                                <div class="err_cv"></div>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $label[8]; ?></td>
                            <td><?php echo $label[7]; ?></td>
                            <td>
                                <?php echo $this->Form->control('BY_PRO_TONNAGE', array('class'=>'form-control form-control-sm number-fields-small feed_tonnage', 'id'=>'BY_PRO_TONNAGE', 'label'=>false, 'value'=>$machineryData['static']['BY_PRO_TONNAGE'])); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('BY_PRO_AVG_GRADE', array('class'=>'form-control form-control-sm number-fields-small feed_tonnage', 'id'=>'BY_PRO_AVG_GRADE', 'label'=>false, 'value'=>$machineryData['static']['BY_PRO_AVG_GRADE'])); ?>
                                <div class="err_cv"></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><?php echo $label[9]; ?></td>
                            <td>
                                <?php echo $this->Form->control('TAIL_TONNAGE', array('class'=>'form-control form-control-sm number-fields-small feed_tonnage', 'id'=>'TAIL_TONNAGE', 'label'=>false, 'value'=>$machineryData['static']['TAIL_TONNAGE'])); ?>
                                <div class="err_cv"></div>
                            </td>
                            <td>
                                <?php echo $this->Form->control('TAIL_AVG_GRADE', array('class'=>'form-control form-control-sm number-fields-small feed_avg_grade', 'id'=>'TAIL_AVG_GRADE', 'label'=>false, 'value'=>$machineryData['static']['TAIL_AVG_GRADE'])); ?>
                                <div class="err_cv"></div>
                            </td>
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
<?php echo $this->Form->control('mineral_name', array('type'=>'hidden', 'value'=>$mineralName)); ?>
<?php echo $this->Form->control('form_type', array('type'=>'hidden', 'value'=>$formType)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'form_id_name', 'value'=>'GeologyPart3')); ?>

<?php echo $this->Html->script('g/geology_part_six.js?version='.$version); ?>
