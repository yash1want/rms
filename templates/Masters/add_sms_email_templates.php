<a href="<?= $this->Url->build(['action' => 'sms-email-templates']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading">Add New Template</h4>
<?= $this->Form->create(null, ['id' => 'add_template', 'class' => 'master_form']); ?>
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
                'class' => 'form-control',
                'required' => true,
                'label' => false,
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
                'class' => 'form-control',
                'required' => true, 
                'label' => false,
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
                'class' => 'form-control',
                'required' => true,
                'label' => false,
                'id' => 'email_message'
            ]);
            ?>
            <div class="err_cv"></div>
        </div>
    </div>
  
</div>
    
 <div class="col-md-8 labelForm">
    Send To:
    <?php echo $this->Form->control('applicant', array('type'=>'checkbox', 'id'=>'applicant','label'=>' Applicant', 'escape'=>false)); ?>
                                
    <?php echo $this->Form->control('ibm_officer', array('type'=>'checkbox', 'id'=>'ibm_officer', 'label'=>' Officer', 'escape'=>false)); ?>
</div>      
                               
<div class="col-md-8 labelForm">
    <?= $this->Form->submit('Save', ['class' => 'btn btn-primary mb-4']); ?>
</div>
<div class="col-md-2"></div>

<?= $this->Form->end(); ?>