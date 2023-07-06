
<h5 class="card-title"><?php echo $label['title']; ?></h5>

<div class="form-row">
    <div class="col-md-6">
        <div class="position-relative form-group">
        	<label for="exampleEmail11" class=""><?php echo $label[0]; ?></label>
			<div class="input-group">
				<div class="input-group-prepend">
					<div class="input-group-text inr-icon-rent" id="btnGroupAddon"><i class="fa fa-rupee-sign"></i></div>
				</div>
	        	<?php echo $this->Form->control('f_past_surface_rent', array('class'=>'form-control cvOn cvReq cvNum cvMaxLen col-sm-11 d-inline-block', 'id'=>'f_past_surface_rent', 'label'=>false, 'autocomplete'=>"off", 'maxlength'=>"12", 'value'=>$rentDetail['past_surface_rent'], 'templates'=>array('inputContainer'=>'{{content}}') )); ?>
			</div>
			<div class="err_cv float-right"></div>
			<div class="clearfix"></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="position-relative form-group">
        	<label for="exampleEmail11" class=""><?php echo $label[1]; ?></label>
			<div class="input-group">
				<div class="input-group-prepend">
					<div class="input-group-text inr-icon-rent" id="btnGroupAddon"><i class="fa fa-rupee-sign"></i></div>
				</div>
				<?php echo $this->Form->control('f_past_royalty', array('class'=>'form-control cvOn cvReq cvNum cvMaxLen col-sm-11 d-inline-block', 'id'=>'f_past_royalty', 'label'=>false, 'autocomplete'=>"off", 'maxlength'=>"12", 'value'=>$rentDetail['past_royalty'],'templates'=>array('inputContainer'=>'{{content}}'))); ?>
			</div>
			<div class="err_cv float-right"></div>
			<div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col-md-6">
        <div class="position-relative form-group">
        	<label for="exampleEmail11" class=""><?php echo $label[2]; ?></label>
			<div class="input-group">
				<div class="input-group-prepend">
					<div class="input-group-text inr-icon-rent" id="btnGroupAddon"><i class="fa fa-rupee-sign"></i></div>
				</div>
	        	<?php echo $this->Form->control('f_past_dead_rent', array('class'=>'form-control cvOn cvReq cvNum cvMaxLen col-sm-11 d-inline-block', 'id'=>'f_past_dead_rent', 'label'=>false, 'autocomplete'=>"off", 'maxlength'=>"12", 'value'=>$rentDetail['past_dead_rent'],'templates'=>array('inputContainer'=>'{{content}}'))); ?>
			</div>
			<div class="err_cv float-right"></div>
			<div class="clearfix"></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="position-relative form-group">
        	<label for="exampleEmail11" class=""><?php echo $label[3]; ?></label>
			<div class="input-group">
				<div class="input-group-prepend">
					<div class="input-group-text inr-icon-rent" id="btnGroupAddon"><i class="fa fa-rupee-sign"></i></div>
				</div>
				<?php echo $this->Form->control('f_past_pay_dmf', array('class'=>'form-control cvOn cvReq cvNum cvMaxLen col-sm-11 d-inline-block', 'id'=>'f_past_pay_dmf', 'label'=>false, 'autocomplete'=>"off", 'maxlength'=>"12", 'value'=>$rentDetail['past_pay_dmf'],'templates'=>array('inputContainer'=>'{{content}}'))); ?>
			</div>
			<div class="err_cv float-right"></div>
			<div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col-md-6">
        <div class="position-relative form-group">
        	<label for="exampleEmail11" class=""><?php echo $label[4]; ?></label>
			<div class="input-group">
				<div class="input-group-prepend">
					<div class="input-group-text inr-icon-rent" id="btnGroupAddon"><i class="fa fa-rupee-sign"></i></div>
				</div>
	        	<?php echo $this->Form->control('f_past_pay_nmet', array('class'=>'form-control cvOn cvReq cvNum cvMaxLen col-sm-11 d-inline-block', 'id'=>'f_past_pay_nmet', 'label'=>false, 'autocomplete'=>"off", 'maxlength'=>"12", 'value'=>$rentDetail['past_pay_nmet'],'templates'=>array('inputContainer'=>'{{content}}'))); ?>
			</div>
			<div class="err_cv float-right"></div>
			<div class="clearfix"></div>
        </div>
    </div>
</div>

<?php echo $this->Form->control('form_no', array('type'=>'hidden', 'label'=>false, 'value'=>$formId)); ?>
<?php echo $this->Form->control('mine_code', array('type'=>'hidden', 'label'=>false, 'value'=>$mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'label'=>false, 'value'=>$returnType)); ?>
<?php echo $this->Form->control('return_date', array('type'=>'hidden', 'label'=>false, 'value'=>$returnDate)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden','id'=>'form_id_name', 'label'=>false, 'value'=>'frmRentDetails')); ?>

<?php echo $this->Html->script('f/rent_details.js?version='.$version); ?>