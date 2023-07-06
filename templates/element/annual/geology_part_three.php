
<h5 class="card-title text-center"><?php echo $label['title']; ?></h5>
<div class="alert alert-info p-1 pl-2 mb-1"><?php echo $label[0]; ?></div>
<div class="">
	<div class="">
		<div class="">
			<div class="row">
				<div class="col-sm-12 tank_table">
					<div class="table-format">
						<div id="test"></div>
						<div id="directors_each_row"></div>
						<div id="error_directors_details" class="text-red float-right text-sm"></div>
						<div id="add_new_row"></div>
						<div id="table_container_1"></div>
					</div>
				</div>
			</div>
	  	</div>
	</div>
</div>

<?php echo $this->Form->control('form_no', array('type'=>'hidden', 'value'=>$formId)); ?>
<?php echo $this->Form->control('mine_code', array('type'=>'hidden', 'value'=>$mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType)); ?>
<?php echo $this->Form->control('return_date', array('type'=>'hidden', 'value'=>$returnDate)); ?>
<?php echo $this->Form->control('return_year', array('type'=>'hidden', 'value'=>$returnYear)); ?>
<?php echo $this->Form->control('form_type', array('type'=>'hidden', 'value'=>$formType)); ?>
<?php echo $this->Form->control('lang', array('type'=>'hidden', 'id'=>'lang', 'value'=>$lang)); ?>
<?php //echo $this->Form->control('machinery_type', array('type'=>'hidden', 'id'=>'machinery_type', 'value'=>$machineryType)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'form_id_name', 'value'=>'GeologyPart3')); ?>

<?php echo $this->Html->script('g/geology_part_three.js?version='.$version); ?>
