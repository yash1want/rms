<a href="<?= $this->Url->build(['action' => 'work-stoppage']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading">Add New Work Stoppage</h4>
<?= $this->Form->create(null, ['id' => 'workStoppageForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="sn" class="labelForm"><span class="compulsoryField">*</span> Stoppage Sn</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('stoppage_sn', [
                'class' => 'form-control cvOn cvNum',
                'required' => true,
                'label' => false,
                'pattern' => '[0-9]{1,6}',
                'title' => 'Only number are allowed not more than 6 digit',
                'id' => 'stoppage_sn'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="def" class="labelForm"><span class="compulsoryField">*</span> Stoppage Def</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('stoppage_def', [
                'class' => 'form-control cvOn cvAlphaNum',
                'required' => true,
                'label' => false,
                'pattern' => '[a-zA-Z0-9\s]{1,30}',
                'title' => 'Only letters, numbers are allowed and not more than 30 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="hindi" class="labelForm">Stoppage Def Hindi</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('stoppage_def_h', [
                'class' => 'form-control',
                'label' => false
            ]); ?>
        </div>
    </div>
</div>
<br>
<div class="col-md-8 labelForm">
    <?= $this->Form->submit('Save', ['class' => 'btn btn-primary mb-4']); ?>
</div>
<div class="col-md-2"></div>
<?= $this->Form->end(); ?>