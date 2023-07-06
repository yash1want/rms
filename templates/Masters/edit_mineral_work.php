<a href="<?= $this->Url->build(['action' => 'mineral-work']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading"> Edit Mineral Work</h4>
<?= $this->Form->create(null, ['id' => 'mineralWorkForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="mine-code" class="labelForm"><span class="compulsoryField">*</span> Mine Code</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('mine_code', [
                'type' => 'text',
                'class' => 'form-control cvOn',
                'value' => $mineralWork->mine_code,
                'required' => true,
                'label' => false,
                'pattern' => '[a-z&A-Z0-9\s]{1,20}',
                'title' => 'Only letters, numbers are allowed not more than 20 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="mineral-name" class="labelForm"><span class="compulsoryField">*</span> Mineral Name</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('mineral_name', [
                'class' => 'form-control cvOn',
                'type' => 'select',
                'options' => $minerals,
                'value' => $mineralWork->mineral_name,
                'disabled' => 'disabled',
                'required' => true,
                'label' => false,
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="mineral-sn" class="labelForm"> Mineral Sn</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('mineral_sn', [
                'class' => 'form-control cvOn cvNum',
                'type' => 'number',
                'value' => $mineralWork->mineral_sn,
                'label' => false,
                'pattern' => '[0-9]{1,6}',
                'title' => 'Only numbers are allowed'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="proportion" class="labelForm"> Proportion</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('proportion', [
                'class' => 'form-control cvOn cvFloat',
                'label' => false,
                'value' => $mineralWork->proportion,
                'pattern' => '[0-9.]{1,20}',
                'cvfloat' => '9999.99',
                'title' => 'Only decimal numbers are allowed'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="ore-lump" class="labelForm"> Ore Lump </label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('ore_lump', [
                'class' => 'form-control cvOn cvAlpha',
                'value' => $mineralWork->ore_lump,
                'label' => false,
                'pattern' => '[a-zA-Z]{1}',
                'title' => 'Only one characters is allowed.'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="fines" class="labelForm">Ore Fines</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('ore_fines', [
                'class' => 'form-control cvOn cvAlpha',
                'value' => $mineralWork->ore_fines,
                'label' => false,
                'pattern' => '[a-zA-Z]{1}',
                'title' => 'Only one characters is allowed.'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="friable" class="labelForm"> Ore Friable</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('ore_friable', [
                'class' => 'form-control cvOn cvAlpha',
                'value' => $mineralWork->ore_friable,
                'label' => false,
                'pattern' => '[a-zA-Z]{1}',
                'title' => 'Only one characters is allowed.'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="granular" class="labelForm"> Ore Granular</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('ore_granular', [
                'class' => 'form-control cvOn cvAlpha',
                'value' => $mineralWork->ore_granular,
                'label' => false,
                'pattern' => '[a-zA-Z]{1}',
                'title' => 'Only one characters is allowed.'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="platy" class="labelForm"> Ore Platy</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('ore_platy', [
                'class' => 'form-control cvOn cvAlpha',
                'value' => $mineralWork->ore_platy,
                'label' => false,
                'pattern' => '[a-zA-Z]{1}',
                'title' => 'Only one characters is allowed.'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="fibrous" class="labelForm">Ore Fibrous</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('ore_fibrous', [
                'class' => 'form-control cvOn cvAlpha',
                'value' => $mineralWork->ore_fibrous,
                'label' => false,
                'pattern' => '[a-zA-Z]{1}',
                'title' => 'Only one characters are allowed.'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="other" class="labelForm"> Ore Other</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('ore_other', [
                'class' => 'form-control cvOn cvAlphaNum',
                'value' => $mineralWork->ore_other,
                'label' => false,
                'pattern' => '[a-zA-Z0-9\s]{1,100}',
                'title' => 'Only characters and numbers are allowed. Not more than 100 characters are allowed'
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