<a href="<?= $this->Url->build(['action' => 'romStep']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading">Add New Rom 5 Step</h4>
<?= $this->Form->create(null, ['id' => 'romStepForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="rom-def" class="labelForm"><span class="compulsoryField">*</span> Rom 5 Step Def</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('rom_5_step_def', [
                'class' => 'form-control cvOn',
                'required' => true,
                'label' => false,
                'pattern' => '[a-zA-Z0-9-\s]{1,100}',
                'title' => 'Only letters, numbers are allowed not more than 100 characters'
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