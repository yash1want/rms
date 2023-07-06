<a href="<?= $this->Url->build(['action' => 'mine-category']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading">Add New Mine Category</h4>
<?= $this->Form->create(null, ['id' => 'mineCategoryForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="category" class="labelForm"><span class="compulsoryField">*</span> Mine Category</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('mine_category', [
                'class' => 'form-control cvOn cvAlpha',
                'required' => true,
                'label' => false,
                'pattern' => '[a-zA-Z]{1}',
                'title' => 'Only 1 character allowed'
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