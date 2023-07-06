<a href="<?= $this->Url->build(['action' => 'district']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading"> Edit District</h4>
<?= $this->Form->create(null, ['id' => 'districtForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="state-code" class="labelForm">State Code</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->input('state_code', [
                'class' => 'form-control',
                'label' => false,
                'type' => 'select',
                'options' => $states,
                'value' => $district->state_code
            ]); ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="district-name" class="labelForm">District Name</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('district_name', [
                'class' => 'form-control cvOn cvAlphaNum',
                'label' => false,
                'value' => $district->district_name,
                'pattern' => '[a-zA-Z0-9\s]{1,30}',
                'title' => 'Only letters, numbers are allowed and not more than 30 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="region" class="labelForm">Region Name</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('region_name', [
                'class' => 'form-control cvOn cvAlphaNum',
                'label' => false,
                'value' => $district->region_name,
                'pattern' => '[a-zA-Z0-9\s]{1,25}',
                'title' => 'Only letters, numbers are allowed and not more than 25 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="code" class="labelForm">District Code</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('district_code', [
                'type' => 'text',
                'class' => 'form-control cvOn cvNum',
                'label' => false,
                'value' => $district->district_code,
                'pattern' => '[0-9]{1,6}',
                'title' => 'Only numbers are allowed not more than 6 numbers'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>

</div>
<br>
<div class="col-md-8 labelForm">
    <?= $this->Form->submit('Edit', ['class' => 'btn btn-primary mb-4']); ?>
</div>
<div class="col-md-2"></div>
<?= $this->Form->end(); ?>