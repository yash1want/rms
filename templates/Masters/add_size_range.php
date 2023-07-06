<a href="<?= $this->Url->build(['action' => 'size_range']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading">Add New Size Range</h4>
<?= $this->Form->create(null, ['id' => 'sizeRangeForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="range" class="labelForm"><span class="compulsoryField">*</span> Size Range</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('size_range', [
                'class' => 'form-control cvOn ',
                'required' => true,
                'label' => false,
                'type' => 'textarea',
                'pattern' => '[a-zA-Z0-9\s<>!,]{1,256}',
                'title' => 'Only letters, numbers are allowed and not more than 256 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
</div>
<br>
<div class="col-md-8 labelForm">
    <?= $this->Form->submit('Save', ['class' => 'btn btn-primary mb-4']); ?>
</div>
<?= $this->Form->end(); ?>