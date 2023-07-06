<a href="<?= $this->Url->build(['action' => 'state']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading"> Edit State</h4>
<?= $this->Form->create(null, ['id' => 'stateForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="state-code" class="labelForm">State Code</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('state_code', [
                'class' => 'form-control cvOn cvAlpha',
                'label' => false,
                'value' => $state->state_code,
                'pattern' => '[a-zA-Z]{1,3}',
                'title' => 'Only characters are allowed. Not more than 3 characters are allowed'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="state-name" class="labelForm">State Name</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('state_name', [
                'class' => 'form-control cvOn cvAlphaNum',
                'label' => false,
                'value' => $state->state_name,
                'pattern' => '[a-zA-Z0-9\s]{1,25}',
                'title' => 'Only letters, numbers are allowed and not more than 25 characters'
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