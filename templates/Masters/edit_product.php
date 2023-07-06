<a href="<?= $this->Url->build(['action' => 'product']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading"> Edit Product</h4>
<?= $this->Form->create(null, ['id' => 'productForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="product-def" class="labelForm">Product Def</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('product_def', [
                'class' => 'form-control cvOn cvAlphaNum',
                'label' => false,
                'value' => $product->product_def,
                'pattern' => '[a-zA-Z0-9\s]{1,50}',
                'title' => 'Only letters, numbers are allowed and not more than 50 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="unit" class="labelForm">Unit</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('unit', [
                'class' => 'form-control cvOn cvAlpha',
                'label' => false,
                'value' => $product->unit,
                'pattern' => '[A-Za-z]{1,10}',
                'title' => 'Only characters are allowed. Not more than 10 characters are allowed'
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