<a href="<?= $this->Url->build(['action' => 'explosive']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading"> Edit Explosive</h4>
<?= $this->Form->create(null, ['id' => 'explosiveForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="explosive-name" class="labelForm">Explosive Name</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('explosive_name', [
                'class' => 'form-control cvOn cvAlphaNum',
                'label' => false,
                'value' => $explosive->explosive_name,
                'pattern' => '[a-zA-Z0-9\s]{1,50}',
                'title' => 'Only letters, numbers are allowed and not more than 50 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="unit" class="labelForm">Explosive Unit</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('explosive_unit', [
                'class' => 'form-control cvOn cvAlpha',
                'label' => false,
                'value' => $explosive->explosive_unit,
                'pattern' => '[A-Za-z]{1,10}',
                'title' => 'Only characters are allowed. Not more than 10 characters are allowed'
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