<a href="<?= $this->Url->build(['action' => 'mine-type']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading"> Edit Mine Type</h4>
<?= $this->Form->create(null, ['id' => 'mineTypeForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="form-type" class="labelForm">Form Type</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('form_type', [
                'class' => 'form-control cvOn cvNum',
                'label' => false,
                'value' => $mineType->form_type,
                'type' => 'number',
                'pattern' => '[0-9]{1,4}',
                'title' => "Only numbers are allowed not nore than 4 digit"
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="def" class="labelForm">Form Def</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('form_def', [
                'class' => 'form-control cvOn cvAlphaNum',
                'label' => false,
                'value' => $mineType->form_def,
                'pattern' => '[a-zA-Z0-9\s]{1,50}',
                'title' => 'Only letters, numbers are allowed and not more than 50 characters'
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