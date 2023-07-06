<a href="<?= $this->Url->build(['action' => 'sms-email-templates']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading">Edit Template</h4>
<?= $this->Form->create(null, ['id' => 'edit_template', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="short-description" class="labelForm"><span class="compulsoryField">*</span> Short Description</label>
        </div>
        <div class="col-md-6">
            <?=
            $this->Form->control('description', [
                'type' => 'textarea',
                'class' => 'form-control',
                'required' => true,
                'label' => false,
                'value' => $template->description,
                'id' => 'description'
            ]);
            ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="SMS Message" class="labelForm"><span class="compulsoryField">*</span> SMS Message</label>
        </div>
        <div class="col-md-6">
            <?=
            $this->Form->control('sms_message', [
                'type' => 'textarea',
                'class' => 'form-control cvOn',
                'required' => true,
                'label' => false,
                'value' => $template->sms_message,
                'id' => 'sms_message'
            ]);
            ?>
            <div class="err_cv"></div>
            <div id="error_sms_message" class="err_cv"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="Subject" class="labelForm"><span class="compulsoryField">*</span> Subject</label>
        </div>
        <div class="col-md-6">
            <?=
            $this->Form->control('email_subject', [
                'type' => 'text',
                'class' => 'form-control cvOn',
                'required' => true, 
                'label' => false,
                'value' => $template->email_subject,
                'id' => 'email_subject'
            ]);
            ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="Email Message" class="labelForm"><span class="compulsoryField">*</span> Email Message</label>
        </div>
        <div class="col-md-6">
            <?=
            $this->Form->control('email_message', [
                'type' => 'textarea',
                'class' => 'form-control cvOn',
                'required' => true,
                'label' => false,
                'value' => $template->email_message,
                'id' => 'email_message'
            ]);
            ?>
            <div class="err_cv"></div>
        </div>
    </div>
    
</div>
<br>
<div class="col-md-8 labelForm">
    Send To:
    <?php  //Applicant
        if (in_array(1,$existed_destination_array)) {
            echo $this->Form->control('applicant', array('type'=>'checkbox', 'checked'=>true, 'id'=>'applicant', 'label'=>' Applicant'));
        } else {
            echo $this->Form->control('applicant', array('type'=>'checkbox', 'checked'=>false, 'id'=>'applicant', 'label'=>' Applicant'));
        }
    ?>

    <?php //Officer
        if (in_array(2,$existed_destination_array)) {
            echo $this->Form->control('ibm_officer', array('type'=>'checkbox', 'checked'=>true, 'id'=>'ibm_officer', 'label'=>' Officer'));
        } else {
            echo $this->Form->control('ibm_officer', array('type'=>'checkbox', 'checked'=>false, 'id'=>'ibm_officer', 'label'=>' Officer'));
        }
    ?>

</div>   
<div class="col-md-8 labelForm">
    <?= $this->Form->submit('Save', ['class' => 'btn btn-primary mb-4 template_validations']); ?>
</div>
<div class="col-md-2"></div>

<?= $this->Form->end(); ?>

<?php echo $this->Html->script('masters/template_validations'); ?>