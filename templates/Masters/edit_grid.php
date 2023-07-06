<a href="<?= $this->Url->build(['action' => 'grid']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading"> Edit Grid</h4>
<?= $this->Form->create(null, ['id' => 'gridForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="grid-name" class="labelForm">Grid Name</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('grid_name', [
                'class' => 'form-control cvOn cvAlphaNum',
                'label' => false,
                'value' => $grid->grid_name,
                'pattern' => '[a-zA-Z0-9\s]{1,56}',
                'title' => 'Only letters, numbersare allowed not more than 56 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="unit" class="labelForm">Grid Unit</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('grid_unit', [
                'type' => 'select',
                'options' => $gridUnits,
                'value' => $grid->grid_unit,
                'empty' => 'Please Select',
                'class' => 'form-control',
                'label' => false,
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="space" class="labelForm">Grid Space</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('grid_space', [
                'class' => 'form-control cvOn cvAlphaNum',
                'label' => false,
                'value' => $grid->grid_space,
                'pattern' => '[a-zA-Z0-9\s]{1,56}',
                'title' => 'Only letters, numbers are allowed not more than 56 characters'
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