
<!-- below add php code for print the dyanamic value as per the form call. added by ganesh satav dated on 25th feb 2014 -->
<!-- <h5 class="card-title"><?php //echo $FormLabelNameWithFormNo['1']; ?></h5> -->
<h5 class="card-title"><?php echo $label['title']; ?><small><?php echo $label[3]; ?></small></h5>
<table class="table table-bordered">
	<tbody>
		<tr>
			<td><?php echo $label['title']; ?><?php echo $label['sub-title']; ?></td>
			<td class="border-right-0">
				<div class="form-check form-check-inline">
					<?php echo $this->Form->checkbox('f_hematite', array('id'=>'F_HEMATITE','class'=>'form-check-input','autocomplete'=>'off','value'=>'1','checked'=>$is_hematite)); ?>
				  <!-- <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1"> -->
				  <label class="form-check-label" for="inlineCheckbox1"><?php echo $label[0]; ?></label>
				</div>
			</td>
			<td class="border-left-0">
				<div class="form-check form-check-inline">
					<?php echo $this->Form->checkbox('f_magnetite', array('id'=>'F_MAGNETITE','class'=>'form-check-input','autocomplete'=>'off','value'=>'1','checked'=>$is_magnetite)); ?>
				  <!-- <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2"> -->
				  <label class="form-check-label" for="inlineCheckbox2"><?php echo $label[1]; ?></label>
				</div>
			</td>
		</tr>
	</tbody>
</table>

<?php echo $this->Form->control('form_no', array('type'=>'hidden', 'value'=>$formId)); ?>
<?php echo $this->Form->control('mine_code', array('type'=>'hidden', 'value'=>$mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType)); ?>
<?php echo $this->Form->control('return_date', array('type'=>'hidden', 'value'=>$returnDate)); ?>
<?php echo $this->Form->control('mineral_name', array('type'=>'hidden', 'value'=>$mineralName)); ?>
<?php echo $this->Form->control('iron_sub_min', array('type'=>'hidden', 'value'=>$ironSubMin)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden','id'=>'form_id_name', 'value'=>'frmMineDetails')); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'ore_is_hematite', 'value'=>$is_hematite)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'ore_is_magnetite', 'value'=>$is_magnetite)); ?>
