<a href="<?= $this->Url->build(['action' => 'finished_products']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading">Add New Finished Product</h4>
<?= $this->Form->create(null, ['id' => 'addFinishedProductForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="def" class="labelForm"><span class="compulsoryField">*</span> Finished Products</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('f_products', [
                'class' => 'form-control cvOn cvAlphaNum cvNotReq',
                'label' => false,
                'pattern' => '[a-zA-Z0-9\s]{1,100}',
                'title' => 'Only letters, numbers are allowed and not more than 100 characters'
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