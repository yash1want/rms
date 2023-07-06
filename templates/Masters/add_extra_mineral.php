<a href="<?= $this->Url->build(['action' => 'extra-mineral']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading">Add New Extra Mineral</h4>
<?= $this->Form->create(null, ['id' => 'extraMineralForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="mineral-name" class="labelForm"><span class="compulsoryField">*</span> Mineral Name</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('mineral_name', [
                'class' => 'form-control cvOn',
                'required' => true,
                'label' => false,
                'pattern' => '[a-zA-Z0-9().\s]{1,20}',
                'title' => 'Only letters, numbers afe allowed and not more than 20 characters',
                'id' => 'mineral_name'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="unit code" class="labelForm"><span class="compulsoryField">*</span> Unit Code</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('unit_code', [
                'class' => 'form-control cvOn cvAlpha',
                'required' => true,
                'label' => false,
                'pattern' => '[a-zA-Z]{1,10}',
                'title' => 'Only characters are allowed. Not more than 10 characters are allowed'
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