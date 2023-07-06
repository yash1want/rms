<a href="<?= $this->Url->build(['action' => 'finished-products']) ?>" class="btn btn-success backToList">Back to List</a>
<?= $this->Flash->render() ?>

<h4 class="card-title bg-primary text-white masterHeading">Edit Finished Product</h4>
<?= $this->Form->create(null, ['id' => 'edit_finished_product', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="def" class="labelForm">Finished Product</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('f_products', [
                'class' => 'form-control cvOn cvAlphaNum',
                'label' => false,
                'value' => $finishedProducts->f_products,
                'pattern' => '[a-zA-Z0-9\s]{1,100}',
                'title' => 'Only letters, numbers are allowed and not more than 100 characters'
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