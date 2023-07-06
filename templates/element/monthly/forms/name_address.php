
<h5 class="card-title"><?php echo $label['title']; ?></h5>
<div class="form-row">
    <div class="col-md-6">
        <div class="position-relative form-group">
        	<label for="exampleEmail11" class=""><?php echo $label[0]; ?></label>
			<input type="text" class="form-control form-control-sm" value="<?php echo $owner['name']; ?>" disabled>
        </div>
    </div>
    <div class="col-md-6">
        <div class="position-relative form-group">
        	<label for="examplePassword11" class=""><?php echo $label[1]; ?></label>
			<input type="text" class="form-control form-control-sm" value="<?php echo $owner['street']; ?>" disabled>
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col-md-6">
        <div class="position-relative form-group">
        	<label for="exampleEmail11" class=""><?php echo $label[2]; ?></label>
			<input type="text" class="form-control form-control-sm" value="<?php echo $owner['district']; ?>" disabled>
        </div>
    </div>
    <div class="col-md-3">
        <div class="position-relative form-group">
        	<label for="examplePassword11" class=""><?php echo $label[3]; ?></label>
			<input type="text" class="form-control form-control-sm" value="<?php echo $owner['state']; ?>" disabled>
        </div>
    </div>
    <div class="col-md-3">
        <div class="position-relative form-group">
        	<label for="exampleEmail11" class=""><?php echo $label[4]; ?></label>
			<input type="text" class="form-control form-control-sm" value="<?php echo $owner['pin']; ?>" disabled>
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col-md-6">
        <div class="position-relative form-group">
        	<label for="exampleEmail11" class="col-sm-3 d-block p-0"><?php echo $label[5]; ?></label>
			<div class="col-sm-10 d-inline-block p-0">
				<div class="a_fax_no_loder"></div><!-- Changed maxlenght to 20 on 07-09-2022 Shweta Apale -->
				<?php echo $this->Form->control('f_a_fax_no', array('class'=>'form-control cvOn cvNotReq cvMaxLen', 'id'=>'f_a_fax_no', 'label'=>false, 'autocomplete'=>"off", 'min'=>'0', 'maxlength'=>"15", 'value'=>$owner['fax'])); ?>
				<div class="err_cv"></div>
			</div>
			<div class="col-sm-1 p-0 d-inline-block ml-3">
				<div class="a_fax_ajaxloader d_none">
					<?php echo $this->Html->image('ajax-loader.gif', array('alt'=>'loading',"title" => "loading", "height" => "20", "width" => "20")); ?>
				</div>
				<?php echo $this->Form->button($label['btn'], array('type'=>'button','class'=>'btn btn-info btn-sm a_fax_no_update')); ?>
			</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="position-relative form-group">
        	<label for="examplePassword11" class="col-sm-3 d-block p-0"><?php echo $label[6]; ?></label>
			<div class="col-sm-10 d-inline-block p-0">
				<div class="a_phone_no_loder"></div><!-- Changed maxlenght to 20 on 07-09-2022 Shweta Apale -->
				<?php echo $this->Form->control('f_a_phone_no', array('class'=>'form-control cvOn cvReq cvNum cvMin cvMaxLen', 'id'=>'f_a_phone_no', 'label'=>false, 'autocomplete'=>"off", 'min'=>'0', 'maxlength'=>"20", 'value'=>$owner['phone'])); ?>
				<div class="err_cv"></div>
			</div>
			<div class="col-sm-1 p-0 d-inline-block ml-3">
				<div class="a_phone_ajaxloader d_none">
					<?php echo $this->Html->image('ajax-loader.gif', array('alt'=>'loading',"title" => "loading", "height" => "20", "width" => "20")); ?>
				</div>
				<?php echo $this->Form->button($label['btn'], array('type'=>'button','class'=>'btn btn-info btn-sm a_phone_no_update')); ?>
			</div>
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col-md-6">
        <div class="position-relative form-group">
        	<label for="exampleEmail11" class="col-sm-3 d-block p-0"><?php echo $label[7]; ?></label>
			<div class="col-sm-10 d-inline-block p-0">
				<div class="a_mobile_no_loder"></div><!-- Changed maxlenght to 20 on 07-09-2022 Shweta Apale -->
				<?php echo $this->Form->control('f_a_mobile_no', array('class'=>'form-control cvOn cvReq cvNum cvMin cvMaxLen', 'id'=>'f_a_mobile_no', 'label'=>false, 'autocomplete'=>"off", 'min'=>'0', 'maxlength'=>"20", 'value'=>$owner['mobile'])); ?>
				<div class="err_cv"></div>
			</div>
			<div class="col-sm-1 p-0 d-inline-block ml-3">
				<div class="a_mobile_ajaxloader d_none">
					<?php echo $this->Html->image('ajax-loader.gif', array('alt'=>'loading',"title" => "loading", "height" => "20", "width" => "20")); ?>
				</div>
				<?php echo $this->Form->button($label['btn'], array('type'=>'button','class'=>'btn btn-info btn-sm a_mobile_no_update')); ?>
			</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="position-relative form-group">
        	<label for="examplePassword11" class="col-sm-3 d-block p-0"><?php echo $label[8]; ?></label>
			<div class="col-sm-10 d-inline-block p-0">
				<div class="a_email_loder"></div>
				<?php echo $this->Form->control('f_a_email', array('class'=>'form-control cvOn cvReq cvEmail', 'id'=>'f_a_email', 'label'=>false, 'autocomplete'=>"off", 'maxlength'=>"150", 'value'=>$owner['email'])); ?>
				<div class="err_cv"></div>
			</div>
			<div class="col-sm-1 p-0 d-inline-block ml-3">
				<div class="a_email_ajaxloader d_none">
					<?php echo $this->Html->image('ajax-loader.gif', array('alt'=>'loading',"title" => "loading", "height" => "20", "width" => "20")); ?>
				</div>
				<?php echo $this->Form->button($label['btn'], array('type'=>'button','class'=>'btn btn-info btn-sm a_email_update')); ?>
			</div>
        </div>
    </div>
</div>

<?php if($returnType == 'ANNUAL') { ?>
	<div class="form-row">
		<div class="col-md-3">
			<div class="position-relative form-group">
				<label for="exampleEmail11" class=""><?php echo $label[9]; ?></label><!-- Changed maxlenght to 255 on 07-09-2022 Shweta Apale -->
				<?php echo $this->Form->control('lessee_office_name', array('class'=>'form-control text-fields cvOn cvReq cvMaxLen', 'id'=>'f_lessee_office_name', 'label'=>false, 'autocomplete'=>"off", 'maxlength'=>"255", 'value'=>$owner['lessee_office_name'])); ?>
				<div class="err_cv"></div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="position-relative form-group"><!-- Changed maxlenght to 200 on 07-09-2022 Shweta Apale -->
				<label for="examplePassword11" class=""><?php echo $label[10]; ?></label>
				<?php echo $this->Form->control('director_name', array('class'=>'form-control text-fields cvOn cvReq cvMaxLen', 'id'=>'f_director_name', 'label'=>false, 'autocomplete'=>"off", 'maxlength'=>"200", 'value'=>$owner['director_name'])); ?>
				<div class="err_cv"></div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="position-relative form-group"><!-- Changed maxlenght to 200 on 07-09-2022 Shweta Apale -->
				<label for="exampleEmail11" class=""><?php echo $label[11]; ?></label>
				<?php echo $this->Form->control('agent_name', array('class'=>'form-control text-fields cvOn cvReq cvMaxLen', 'id'=>'f_agent_name', 'label'=>false, 'autocomplete'=>"off", 'maxlength'=>"200", 'value'=>$owner['agent_name'])); ?>
				<div class="err_cv"></div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="position-relative form-group"><!-- Changed maxlenght to 200 on 07-09-2022 Shweta Apale -->
				<label for="examplePassword11" class=""><?php echo $label[12]; ?></label>
				<?php echo $this->Form->control('manager_name', array('class'=>'form-control text-fields cvOn cvReq cvMaxLen', 'id'=>'f_manager_name', 'label'=>false, 'autocomplete'=>"off", 'maxlength'=>"200", 'value'=>$owner['manager_name'])); ?>
				<div class="err_cv"></div>
			</div>
		</div>
	</div>
	<div class="form-row">
		<div class="col-md-3">
			<div class="position-relative form-group"><!-- Changed maxlenght to 200 on 07-09-2022 Shweta Apale -->
				<label for="exampleEmail11" class=""><?php echo $label[13]; ?></label>
				<?php echo $this->Form->control('mining_engineer_name', array('class'=>'form-control text-fields cvOn cvReq cvMaxLen', 'id'=>'f_mining_engineer_name', 'label'=>false, 'autocomplete'=>"off", 'maxlength'=>"200", 'value'=>$owner['mining_engineer_name'])); ?>
				<div class="err_cv"></div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="position-relative form-group"><!-- Changed maxlenght to 200 on 07-09-2022 Shweta Apale -->
				<label for="examplePassword11" class=""><?php echo $label[14]; ?></label>
				<?php echo $this->Form->control('geologist_name', array('class'=>'form-control text-fields cvOn cvReq cvMaxLen', 'id'=>'f_geologist_name', 'label'=>false, 'autocomplete'=>"off", 'maxlength'=>"200", 'value'=>$owner['geologist_name'])); ?>
				<div class="err_cv"></div>
			</div>
		</div>
		<div class="col-md-3 nm_addr_opt_l">
			<div class="position-relative form-group">
				<label for="exampleEmail11" class=""><?php echo $label[15]; ?></label>
			<div id="nm_addr_if_any"><?php echo $label[17]; ?></div><!-- Changed maxlenght to 200 on 07-09-2022 Shweta Apale -->
				<?php echo $this->Form->control('previous_lessee_name', array('class'=>'form-control text-fields cvOn cvNotReq cvMaxLen', 'id'=>'f_previous_lessee_name', 'label'=>false, 'autocomplete'=>"off", 'maxlength'=>"200", 'value'=>$owner['previous_lessee_name'])); ?>
				<div class="err_cv"></div>
			</div>
		</div>
		<div class="col-md-3 nm_addr_opt_r">
			<div class="position-relative form-group">
				<label for="examplePassword11" class=""><?php echo $label[16]; ?></label>
				<?php echo $this->Form->control('date_of_entry', array('type'=>'date', 'class'=>'form-control text-fields cvOn cvNotReq', 'id'=>'f_date_of_entry', 'label'=>false, 'autocomplete'=>"off", 'value'=>$owner['date_of_entry'], 'min'=>'1960-01-01', 'max'=>$max_date)); ?>
				<div class="err_cv"></div>
			</div>
		</div>
	</div>
	<hr>
	<div class="p-3 mb-2 rounded bg_gainsboro">
		<h5 class="card-title text-center"><?php echo $label[18]; ?></h5>	
		<div class="form-row">
			<div class="col-md-2">
				<div class="position-relative form-group">
					<label for="exampleEmail11" class=""><?php echo $label[19]; ?></label>
					<?php echo $this->Html->link('<i class="fa fa-download"></i> '.$label[20], '/doc/PMCP_report_template.xlsx', array('class'=>'form-control btn btn-primary font_12', 'id'=>'dowload_excel_btn', 'label'=>false, 'escape'=>false)); ?>
					<div class="err_cv"></div>
				</div>
			</div>
			<div class="col-md-5">
				<div class="position-relative form-group">
					<label for="examplePassword11" class=""><?php echo $label[21]; ?></label>
					<?php echo $this->Form->control('profile_pdf', array('type' => 'file','class'=>'form-control pl-2 cvOn cvNotReq','id'=>'profile_pdf','label'=>false, 'accept'=>'pdf')); ?>
					<?php echo $this->Form->control('profile_pdf_old', array('type'=>'hidden', 'value'=>$owner['profile_pdf'])); ?>
					<div id="profile_pdf_error" class="text-danger"></div>
					<?php if ($owner['profile_pdf'] != '') { ?>
						<div class="text-right"><a href="<?php echo $owner['profile_pdf']; ?>" target="_blank"><?php echo $label[22]; ?> <i class="fa fa-external-link-alt"></i></a></div>
					<?php } ?>
					<div class="alert alert-info pl-2 pt-1 pb-1"><i class="fa fa-info-circle"></i> <?php echo $label[23]; ?></div>
				</div>
			</div>
			<div class="col-md-5">
				<div class="position-relative form-group">
					<label for="exampleEmail11" class=""><?php echo $label[24]; ?></label>
					<?php echo $this->Form->control('profile_kml', array('type' => 'file','class'=>'form-control pl-2 cvOn cvNotReq','id'=>'profile_kml','label'=>false, 'accept'=>'kml')); ?>
					<?php echo $this->Form->control('profile_kml_old', array('type'=>'hidden', 'value'=>$owner['profile_kml'])); ?>
					<div id="profile_kml_error" class="text-danger"></div>
					<?php if ($owner['profile_kml'] != '') { ?>
						<div class="text-right"><a href="<?php echo $owner['profile_kml']; ?>" target="_blank"><?php echo $label[25]; ?> <i class="fa fa-external-link-alt"></i></a></div>
					<?php } ?>
					<div class="alert alert-info pl-2 pt-1 pb-1"><i class="fa fa-info-circle"></i> <?php echo $label[26]; ?></div>
				</div>
			</div>
		</div>
	</div>

<?php } ?>

<?php echo $this->Form->control('form_no', array('type'=>'hidden', 'label'=>false, 'value'=>$formId)); ?>
<?php echo $this->Form->control('mine_code', array('type'=>'hidden', 'id'=>'mine_code', 'label'=>false, 'value'=>$mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'label'=>false, 'value'=>$returnType)); ?>
<?php echo $this->Form->control('return_date', array('type'=>'hidden', 'id'=>'return_date', 'label'=>false, 'value'=>$annualReturnDate)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden','id'=>'form_id_name', 'label'=>false, 'value'=>'frmNameAddress')); ?>

<!--script for total calculation : starts-->
<?php echo $this->Html->script('f/name_address.js?version='.$version); ?>