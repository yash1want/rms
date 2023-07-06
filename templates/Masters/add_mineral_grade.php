<a href="<?= $this->Url->build(['action' => 'mineral-grade']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading">Add New Mineral Grade </h4>
<?= $this->Form->create(null, ['id' => 'mineralGradeForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="mineral-name" class="labelForm"><span class="compulsoryField">*</span> Mineral Name</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('mineral_name', [
                'class' => 'form-control cvOn cvAlphaNum',
                'required' => true,
                'label' => false,
                'pattern' => '[a-zA-Z0-9\s]{1,20}',
                'title' => 'Only letters, numbers are allowed and not more than 20 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
       <!-- <div class="col-md-6">
            <label for="code" class="labelForm"> Grade Code</label>
        </div>-->
        <div class="col-md-6">
            <?= $this->Form->hidden('grade_code', [
                'class' => 'form-control',
                //'required' => true,
                'label' => false,
                'type' => 'number',
                'pattern' => '[0-9]{1,6}',
                'title' => 'Only numbers are allowed not more than 6 digit',
				'value' => '0',
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="grade-name" class="labelForm"> Grade Name</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('grade_name', [
                'class' => 'form-control cvOn  cvNotReq',
                'label' => false,
                'pattern' => '[A-Za-z0-9 \s%]{1,100}',   
                'title' => 'Only letters, numbers are allowed and not more than 100 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>

</div>
<br>
<div class="col-md-8 labelForm">
    <?= $this->Form->submit('Save', ['class' => 'btn btn-primary mb-4']); ?>
</div>
<div class="col-md-2"></div>

<?= $this->Form->end(); ?>