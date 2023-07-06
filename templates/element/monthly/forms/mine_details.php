
<h5 class="card-title"><?php echo $label['title']; ?></h5>
<div class="position-relative row form-group mine-group">
	<div class="col-sm-6"><?php echo $label[0]; ?></div>
	<div class="col-sm-6 mine-m-auto">
		<input type="text" class="form-control form-control-sm" value="<?php echo $mine['reg_no']; ?>" disabled>
	</div>
</div>
<div class="position-relative row form-group mine-group">
	<div class="col-sm-6"><?php echo $label[1]; ?></div>
	<div class="col-sm-6 mine-m-auto">
		<input type="text" class="form-control form-control-sm" value="<?php echo $mineCode; ?>" disabled>
	</div>
</div>
<div class="position-relative row form-group mine-group">
	<div class="col-sm-6"><?php echo $label[2]; ?></div>
	<div class="col-sm-6 mine-m-auto">
		<input type="text" class="form-control form-control-sm" value="<?php echo $mine['mineral']; ?>" disabled>
	</div>
</div>
<div class="position-relative row form-group mine-group">
	<div class="col-sm-6"><?php echo $label[3]; ?></div>
	<div class="col-sm-6 mine-m-auto">
		<input type="text" class="form-control form-control-sm" value="<?php echo $mine['mine_name']; ?>" disabled>
	</div>
</div>
<div class="position-relative row form-group mine-group">
	<div class="col-sm-6"><?php echo $label[4]; ?></div>
	<div class="col-sm-6 mine-m-auto">
		<input type="text" class="form-control form-control-sm" value="<?php echo $mine['other_mineral']; ?>" disabled>
	</div>
</div>
<h5 class="card-title text_trans_in mine-group pt-2 pb-2 mb-3"><?php echo $label[5]; ?></h5>
<div class="form-row">
    <div class="col-md-6">
        <div class="position-relative form-group">
        	<label for="exampleEmail11" class=""><?php echo $label[6]; ?></label>
        	<input type="text" class="form-control form-control-sm" value="<?php echo $mine['village']; ?>" disabled>
        </div>
    </div>
    <div class="col-md-6">
        <div class="position-relative form-group">
        	<label for="examplePassword11" class=""><?php echo $label[7]; ?></label>
        	<input type="text" class="form-control form-control-sm" value="<?php echo $mine['post_office']; ?>" disabled>
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col-md-6">
        <div class="position-relative form-group">
        	<label for="exampleEmail11" class=""><?php echo $label[8]; ?></label>
        	<input type="text" class="form-control form-control-sm" value="<?php echo $mine['taluk']; ?>" disabled>
        </div>
    </div>
    <div class="col-md-6">
        <div class="position-relative form-group">
        	<label for="examplePassword11" class=""><?php echo $label[9]; ?></label>
        	<input type="text" class="form-control form-control-sm" value="<?php echo $mine['district']; ?>" disabled>
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col-md-6">
        <div class="position-relative form-group">
        	<label for="exampleEmail11" class=""><?php echo $label[10]; ?></label>
        	<input type="text" class="form-control form-control-sm" value="<?php echo $mine['state']; ?>" disabled>
        </div>
    </div>
    <div class="col-md-6">
        <div class="position-relative form-group">
        	<label for="examplePassword11" class=""><?php echo $label[11]; ?></label>
        	<input type="text" class="form-control form-control-sm" value="<?php echo $mine['pin']; ?>" disabled>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-md-6">
        <div class="position-relative form-group">
        	<label for="exampleEmail11" class="col-sm-3"><?php echo $label[12]; ?></label>
			<div class="col-sm-7 d-inline-block">
				<div class="fax_no_loder"></div> <!-- Changed maxlength size to 20 on 07-09-2022 Shweta Apale -->
				<?php echo $this->Form->control('f_fax_no', array('class'=>'form-control cvOn cvReq cvNum cvMin cvMaxLen', 'id'=>'f_fax_no', 'label'=>false, 'autocomplete'=>"off", 'min'=>'0', 'maxlength'=>"20", 'value'=>$mine['fax'])); ?>
				<div class="err_cv"></div>
			</div>
			<div class="col-sm-1 p-0 d-inline-block">
				<div class="fax_ajaxloader d_none">
					<?php echo $this->Html->image('ajax-loader.gif', array('alt'=>'loading',"title" => "loading", "height" => "20", "width" => "20")); ?>
				</div>
				<?php echo $this->Form->button($label['btn'], array('type'=>'button','class'=>'btn btn-info btn-sm fax_no_update')); ?>
			</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="position-relative form-group">
        	<label for="examplePassword11" class="col-sm-3"><?php echo $label[13]; ?></label>
			<div class="col-sm-7 d-inline-block">
				<div class="phone_no_loder"></div><!-- Changed maxlength size to 20 on 07-09-2022 Shweta Apale -->
				<?php echo $this->Form->control('f_phone_no', array('class'=>'form-control cvOn cvReq cvNum cvMin cvMaxLen', 'id'=>'f_phone_no', 'label'=>false, 'autocomplete'=>"off", 'min'=>'0', 'maxlength'=>"20", 'value'=>$mine['phone'])); ?>
				<div class="err_cv"></div>
			</div>
			<div class="col-sm-1 p-0 d-inline-block">
				<div class="phone_ajaxloader d_none">
					<?php echo $this->Html->image('ajax-loader.gif', array('alt'=>'loading',"title" => "loading", "height" => "20", "width" => "20")); ?>
				</div>
				<?php echo $this->Form->button($label['btn'], array('type'=>'button','class'=>'btn btn-info btn-sm phone_no_update')); ?>
			</div>
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col-md-6">
        <div class="position-relative form-group">
        	<label for="exampleEmail11" class="col-sm-3"><?php echo $label[14]; ?></label>
			<div class="col-sm-7 d-inline-block">
				<div class="mobile_no_loder"></div><!-- Changed maxlength size to 20 on 07-09-2022 Shweta Apale -->
				<?php echo $this->Form->control('f_mobile_no', array('class'=>'form-control cvOn cvReq cvNum cvMin cvMaxLen', 'id'=>'f_mobile_no', 'label'=>false, 'autocomplete'=>"off", 'min'=>'0', 'maxlength'=>"20", 'value'=>$mine['mobile'])); ?>
				<div class="err_cv"></div>
			</div>
			<div class="col-sm-1 p-0 d-inline-block">
				<div class="mobile_ajaxloader d_none">
					<?php echo $this->Html->image('ajax-loader.gif', array('alt'=>'loading',"title" => "loading", "height" => "20", "width" => "20")); ?>
				</div>
				<?php echo $this->Form->button($label['btn'], array('type'=>'button','class'=>'btn btn-info btn-sm mobile_no_update')); ?>
			</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="position-relative form-group">
        	<label for="examplePassword11" class="col-sm-3"><?php echo $label[15]; ?></label>
			<div class="col-sm-7 d-inline-block">
				<div class="email_loder"></div>
				<?php echo $this->Form->control('f_email', array('class'=>'form-control cvOn cvReq cvEmail', 'id'=>'f_email', 'label'=>false, 'autocomplete'=>"off", 'maxlength'=>"150", 'value'=>$mine['email'])); ?>
				<div class="err_cv"></div>
			</div>
			<div class="col-sm-1 p-0 d-inline-block">
				<div class="email_ajaxloader d_none">
					<?php echo $this->Html->image('ajax-loader.gif', array('alt'=>'loading',"title" => "loading", "height" => "20", "width" => "20")); ?>
				</div>
				<?php echo $this->Form->button($label['btn'], array('type'=>'button','class'=>'btn btn-info btn-sm email_update')); ?>
			</div>
        </div>
    </div>
</div>

<?php echo $this->Form->control('form_no', array('type'=>'hidden', 'label'=>false, 'value'=>$formId)); ?>
<?php echo $this->Form->control('mine_code', array('type'=>'hidden', 'id'=>'mine_code', 'label'=>false, 'value'=>$mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden','id'=>'form_id_name', 'label'=>false, 'value'=>'frmMineDetails')); ?>

<!--script for total calculation : starts-->
<?php echo $this->Html->script('f/mine_details.js?version='.$version); ?>
