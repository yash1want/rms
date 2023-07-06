<a href="<?= $this->Url->build(['action' => 'rock']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading"> Edit Rock</h4>
<?= $this->Form->create(null, ['id' => 'rockForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="rock-code" class="labelForm">Rock Code</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('rock_code', [
                'class' => 'form-control cvOn cvAlphaNum',
                'label' => false,
                'value' => $rock->rock_code,
                'pattern' => '[a-zA-Z0-9\s]{1,4}',
                'title' => 'Only letters and numbers are allowed. Not more than 4 characters are allowed'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="rock-name" class="labelForm">Rock Name</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('rock_name', [
                'class' => 'form-control cvOn cvAlphaNum',
                'label' => false,
                'value' => $rock->rock_name,
                'pattern' => '[a-zA-Z0-9\s]{1,50}',
                'title' => 'Only letters and numbers are allowed. Not more than 4 characters are allowed'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
</div>
<br>
<div class="col-md-8" class="labelForm">
    <?= $this->Form->submit('Edit', ['class' => 'btn btn-primary mb-4']); ?>
</div>
<div class="col-md-2"></div>
<?= $this->Form->end(); ?>