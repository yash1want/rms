<a href="<?= $this->Url->build(['action' => 'metal']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading">Add New Metal</h4>
<?= $this->Form->create(null, ['id' => 'metalForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="metal-name" class="labelForm"><span class="compulsoryField">*</span> Metal Name</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('metal_name', [
                'class' => 'form-control cvOn cvAlphaNum',
                'required' => true,
                'label' => false,
                'pattern' => '[a-zA-Z0-9\s]{1,2}',
                'title' => 'Only letters, numbers are allowed and not more than 2 characters',
                'id' => 'metal_name'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="def" class="labelForm"><span class="compulsoryField">*</span> Metal Def</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('metal_def', [
                'class' => 'form-control cvOn cvAlphaNum',
                'label' => false,
                'pattern' => '[a-zA-Z0-9\s]{1,20}',
                'title' => 'Only letters, numbers are allowed and not more than 20 characters',
                'required' => true
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