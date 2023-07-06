<a href="<?= $this->Url->build(['action' => 'machinery']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading"> Edit Macinery</h4>
<?= $this->Form->create(null, ['id' => 'machineryForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="code" class="labelForm">Machinery Code</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('machinery_code', [
                'class' => 'form-control cvOn cvNum',
                'label' => false,
                'value' => $machinery->machinery_code,
                'pattern' => '[0-9]{1,2}',
                'title' => 'Only numbers are allowed not more than 2 digit',
                'id' => 'machine_code'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="machinery-name" class="labelForm">Machinery Name</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('machinery_name', [
                'class' => 'form-control cvOn cvAlphaNum',
                'label' => false,
                'value' => $machinery->machinery_name,
                'pattern' => '[a-zA-Z0-9\s]{1,50}',
                'title' => 'Only letters, numbers are allowed and not more than 50 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="unit" class="labelForm">Capacity Unit</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('capacity_unit', [
                'class' => 'form-control cvOn cvAlpha',
                'label' => false,
                'value' => $machinery->capacity_unit,
                'pattern' => '[a-zA-Z/]{1,10}',
                'title' => 'Only characters and forward slash are allowed and not more than 10 characters'
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