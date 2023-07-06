<a href="<?= $this->Url->build(['action' => 'district']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading">Add New District</h4>
<?= $this->Form->create(null, ['id' => 'districtForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="state-code" class="labelForm"><span class="compulsoryField">*</span> State Code</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('state_code', [
                'class' => 'form-control', 
                'required' => true, 
                'label' => false,
                'type' => 'select',
                'empty' => 'Please Select',
                'options' => $states,
            ]); ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="district-name" class="labelForm"><span class="compulsoryField">*</span> District Name</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('district_name', [
                'class' => 'form-control cvOn cvAlphaNum',
                'required' => true,
                'label' => false,
                'pattern' => '[a-zA-Z0-9\s]{1,30}',
                'title' => 'Only letters, numbers are allowed and not more than 30 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="region name" class="labelForm"><span class="compulsoryField">*</span> Region Name</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('region_name', [
                'class' => 'form-control cvOn cvAlphaNum',
                'required' => true,
                'label' => false,
                'pattern' => '[a-zA-Z0-9\s]{1,25}',
                'title' => 'Only letters, numbers are allowed and not more than 25 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="district-code" class="labelForm"><span class="compulsoryField">*</span> District Code</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('district_code', [
                'type' => 'number',
                'class' => 'form-control cvOn cvNum',
                'required' => true,
                'label' => false,
                'type' => 'number',
                'pattern' => '[0-9]{1,6}',
                'title' => 'Only numbers are allowed not more than 6 numbers'
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