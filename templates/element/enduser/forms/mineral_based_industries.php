
<h5 class="card-title text-center"><?php echo $label['title']; ?></h5>

<?php 

    if ($fetchData['otherind'] != "") {
        $otherDisabled = false;
    } else {
        $otherDisabled = true;
    }
	$stateDataFinal = true;
	if(isset($stateData) && $stateData == false) {
		$stateDataFinal= false;
		?>
		<div class="alert alert-danger">
			Currently your request for updation of registration information is pending with Registration Module. Once this updation request is approved, you will be able to file annual returns.
		</div>
		<?php
	} else {
?>

<div class="form-row">
    <div class="col-md-4">
        <div class="position-relative form-group">
            <label for="exampleEmail11" class=""><?php echo $label[0]; ?></label>
            <?php echo $this->Form->select('industry_name', $industries_op, array('empty'=>'- Select Industry -', 'class'=>'form-control h-selectbox', 'id'=>'industry_name', 'label'=>false, 'autocomplete'=>"off", 'value'=>$fetchData['industryname1'])); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="position-relative form-group">
            <label for="examplePassword11" class="">&nbsp;</label>
            <?php echo $this->Form->control('other_industry_name', array('class'=>'form-control text-fields other_industry_name', 'id'=>'other_industry_name', 'title'=>'Please Specify in case of others', 'label'=>false, 'maxLength'=>50, 'value'=>$fetchData['otherind'], 'disabled'=>$otherDisabled)); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="position-relative form-group">
            <label for="exampleEmail11" class=""><?php echo $label[1]; ?></label>
            <?php echo $this->Form->control('plant1', array('class'=>'form-control', 'id'=>'plant1', 'label'=>false, 'value'=>$addressDetails[0]['mcmcd_nameofplant'], 'readonly'=>true)); ?>
            <div class="err_cv"></div>
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col-md-4">
        <div class="position-relative form-group">
            <label for="exampleEmail11" class=""><?php echo $label[2]; ?></label>
            <?php echo $this->Form->control('state', array('class'=>'form-control', 'id'=>'state', 'label'=>false, 'value'=>$addressDetails[0]['mcmd_state'], 'readonly'=>true)); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="position-relative form-group">
            <label for="exampleEmail11" class=""><?php echo $label[3]; ?></label>
            <?php echo $this->Form->control('district', array('class'=>'form-control', 'id'=>'district', 'label'=>false, 'value'=>$regionAndDistrictName['district_name'], 'readonly'=>true)); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="position-relative form-group">
            <label for="exampleEmail11" class=""><?php echo $label[4]; ?></label>
            <?php echo $this->Form->control('location', array('class'=>'form-control', 'id'=>'location', 'label'=>false, 'value'=>$latiLongiDetails['latitude'] . " " . $latiLongiDetails['longitude'], 'readonly'=>true)); ?>
            <div class="err_cv"></div>
        </div>
    </div>
</div>

<?php 

    echo $this->Form->control('uType', ['type'=>'hidden', 'id'=>'uType', 'value'=>$userType]);
    echo $this->Form->control('fType', ['type'=>'hidden', 'id'=>'fType', 'value'=>$formType]);
    echo $this->Form->control('return_date', ['type'=>'hidden', 'id'=>'return_date', 'value'=>$returnDate]);
    echo $this->Form->control('return_type', ['type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType]);
    echo $this->Form->control('end_user_id', ['type'=>'hidden', 'value'=>$endUserId]);
    echo $this->Form->control('user_type', ['type'=>'hidden', 'value'=>$userType]);
    echo $this->Form->control('section_no', ['type'=>'hidden','id'=>'section_no','value'=>$section_no]);
    echo $this->Form->control('', ['type'=>'hidden','id'=>'form_id_name', 'label'=>false, 'value'=>'mineralBasedIndustries']); 

    echo $this->Form->control('reason_count', ['type'=>'hidden','id'=>'reason_count']);
	}
	echo $this->Html->script('m/mineral_based_industries.js?version='.$version);
    echo $this->Form->control('', ['type'=>'hidden','id'=>'stateData','value'=>$stateDataFinal]);

?>
