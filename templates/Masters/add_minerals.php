<a href="<?= $this->Url->build(['action' => 'minerals-list']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading">Add New Mineral</h4>
<?= $this->Form->create(null, ['id' => 'mineralForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    
    <div class="row">
        <div class="col-md-6">
            <label for="mine" class="labelForm"><span class="compulsoryField pr-1">*</span>Mineral Name</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('mineral_name', [
                'class' => 'form-control cvOn cvAlpha',
				'id'=>'mineral_name',
                'required' => true,
                'label' => false,
                'pattern' => '[a-zA-Z0-9\s]{1,100}',
                'title' => 'Only letters, numbers are allowed not more than 100 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>	
    <div class="row">
        <div class="col-md-6">
            <label for="category" class="labelForm"><span class="compulsoryField pr-1">*</span> Form Type</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('form_type', [
                'type' => 'select',
				'required' => true,
                'options' => array('1'=>'F1','5'=>'F2','7'=>'F3'),
                'empty' => 'Please select',
                'class' => 'form-control',
                'label' => false,
            ]); ?>
        </div>
    </div>
    <br>    
    <div class="row">
        <div class="col-md-6">
            <label for="category" class="labelForm"><span class="compulsoryField pr-1">*</span>Input Unit</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('input_unit', [
                'type' => 'select',
				'required' => true,
                'options' => $units,
                'empty' => 'Please select',
                'class' => 'form-control',
                'label' => false,
            ]); ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="category" class="labelForm"><span class="compulsoryField pr-1">*</span>Output Unit</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('output_unit', [
                'type' => 'select',
				'required' => true,
                'options' => $units,
                'empty' => 'Please select',
                'class' => 'form-control',
                'label' => false,
            ]); ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="category" class="labelForm"><span class="compulsoryField pr-1">*</span>Mineral Type</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('mineral_type', [
                'type' => 'select',
				'required' => true,
                'options' => array('Major'=>'Major','Minor'=>'Minor'),
                'empty' => 'Please select',
                'class' => 'form-control',
                'label' => false,
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