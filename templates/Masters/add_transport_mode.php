<a href="<?= $this->Url->build(['action' => 'transport_mode']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading">Add New Transport Mode</h4>
<?= $this->Form->create(null, ['id' => 'commodityForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="transport-mode" class="labelForm"><span class="compulsoryField">*</span> Transport Mode</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('transport_mode', [
                'type' => 'text',
                'class' => 'form-control cvOn cvAlphaNum',
                'required' => true,
                'label' => false,
                'pattern' => '[a-zA-Z0-9\s]{1,200}',
                'title' => 'Only letters, numbers are allowed and not more than 200 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
</div>
<br>
<div class="col-md-8 labelForm">
    <?= $this->Form->submit('Save', ['class' => 'btn btn-primary mb-4']); ?>
</div>
<div class="col-md-2"></div>

<?= $this->Form->end(); ?>