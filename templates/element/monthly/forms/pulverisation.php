<?php

$pulverised = $pulverArr[0]['is_pulverised'];
$pulverised_yes = ($pulverised == '1') ? 'true' : 'false';
$pulverised_no = ($pulverised == '0' || $pulverised == '') ? 'true' : 'false';
$displayTableStatus = ($pulverised == '0' || $pulverised == '') ? ' d_none' : '';

// if ($formNo == "8") {
// 	if ($isPulverised == true) {
// 		$visibility = "";
// 	} else {
// 		$visibility = "display:none;";
// 	}
// } else {
// 	$visibility = "";
// }

?>

<h5 class="card-title text-center"><?php echo $label['title']; ?></h5>
<div class="position-relative row form-group mine-group">

	<div class="col-sm-12 mine-m-auto">
		<div class="card-body">
			<div id="exampleAccordion" data-children=".item">
				<div class="item">
					<label class="font-weight-bolder"><?php echo $label[0]; ?>
						<?php echo $this->Form->radio('is_pulverised', array(
							array('value' => '1', 'text' => $label[1], 'class' => 'pulver_radio ml-2 mr-1', 'checked' => $pulverised_yes),
							array('value' => '0', 'text' => $label[2], 'class' => 'pulver_radio ml-2 mr-1', 'checked' => $pulverised_no)
						)); ?>
					</label>
				</div>
			</div>
		</div>
	</div>

	<div id="pulver_table" class="<?php echo $displayTableStatus; ?>">
		<div class="col-sm-12 min
		e-m-auto">
			<div class="card-body">
				<div class="row">
					<label class="font-weight-bolder text-success"><?php echo $label[3]; ?></label>
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

		<div class="col-sm-12 mine-m-auto">
			<label class="font-weight-bolder text-success"><?php echo $label[15]; ?></label>

			<div class="position-relative row form-group mine-group">
				<div class="col-sm-4 col-12 mb-2"><?php echo $label[16]; ?></div>
				<div class="input-group col-sm-6 col-12 mb-2">
					<div class="input-group-prepend">
						<div class="input-group-text inr-icon-rent" id="btnGroupAddon"><i class="fa fa-rupee-sign"></i></div>
					</div>
					<?php echo $this->Form->control('avg_cost', array('id' => 'avg_cost', 'class' => 'form-control avg_cost cvOn cvNum el_up', 'value' => $pulverArr[0]['avg_cost'], 'label' => false, 'templates' => array('inputContainer' => '{{content}}'))); ?>
					<div class="input-group-text b_left_none"><?php echo $label[17]; ?></div>

				</div>
				<div class="err_cv"></div>
			</div>
			<div class="alert alert-info p-2 pl-3"><em><?php echo $label['note']; ?></em></div>

		</div>
	</div>
</div>

<?php echo $this->Form->control('form_no', array('type' => 'hidden', 'label' => false, 'value' => $formId)); ?>
<?php echo $this->Form->control('mine_code', array('type' => 'hidden', 'label' => false, 'value' => $mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type' => 'hidden', 'id' => 'return_type', 'label' => false, 'value' => $returnType)); ?>
<?php echo $this->Form->control('return_date', array('type' => 'hidden', 'label' => false, 'value' => $returnDate)); ?>
<?php echo $this->Form->control('mineral_name', array('type' => 'hidden', 'label' => false, 'value' => $mineral)); ?>
<?php echo $this->Form->control('', array('type' => 'hidden', 'id' => 'form_id_name', 'label' => false, 'value' => 'frmPulverisation')); ?>