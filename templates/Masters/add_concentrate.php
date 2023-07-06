<a href="<?= $this->Url->build(['action' => 'concentrate']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading">Add New Type Concentrate</h4>
<?= $this->Form->create(null, ['id' => 'concentrateForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="concentrate" class="labelForm"><span class="compulsoryField">*</span> Concentrate</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('type_concentrate', [
                'class' => 'form-control cvOn cvAlphaNum',
                'required' => true,
                'label' => false,
                'pattern' => '[a-zA-Z0-9\s]{1,20}',
                'title' => 'Only letters, numbers are allowed periods and not more than 20 characters',
                'id' => 'type_concentrate'
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