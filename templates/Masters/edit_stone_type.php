<a href="<?= $this->Url->build(['action' => 'stone-type']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading"> Edit Stone Type</h4>
<?= $this->Form->create(null, ['id' => 'stoneTypeForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="stone-def" class="labelForm">Stone Def</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('stone_def', [
                'class' => 'form-control cvOn cvAlphaNum',
                'label' => false,
                'value' => $stoneType->stone_def,
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