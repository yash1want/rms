<a href="<?= $this->Url->build(['action' => 'material']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading">Add New Material</h4>
<?= $this->Form->create(null, ['id' => 'materialForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="mateial-def" class="labelForm"> Material Def</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('material_def', [
                'class' => 'form-control cvOn cvAlphaNum cvNotReq',
                'label' => false,
                'pattern' => '[a-zA-Z0-9\s]{1,50}',
                'title' => 'Only letters, numbers are allowed and not more than 50 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="unit" class="labelForm">Material Unit</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('material_unit', [
                'class' => 'form-control',
                'label' => false,
                'pattern' => '[a-zA-Z.]{1,10}',
                'title' => 'Only characters and period are allowed. Not more than 10 characters are allowed'
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