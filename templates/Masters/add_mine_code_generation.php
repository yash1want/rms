<a href="<?= $this->Url->build(['action' => 'mine-code-generation']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading">Add New Mine Code Generation</h4>
<?= $this->Form->create(null, ['id' => 'mineCodeForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="principle-name" class="labelForm"><span class="compulsoryField">*</span> Principle Mineral</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('principle_mineral', [
                'type' => 'select',
                'options' => $minerals,
                'empty' => 'Please Select',
                'class' => 'form-control',
                'required' => true,
                'label' => false,
            ]); ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="state" class="labelForm"><span class="compulsoryField">*</span> State Name</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('state_code', [
                'type' => 'select',
                'options' => $states,
                'empty' => 'Please Select',
                'class' => 'form-control',
                'required' => true,
                'label' => false,
                'id' => 'stateSelect',
            ]); ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="district" class="labelForm"><span class="compulsoryField">*</span> District Name</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('district_code', [
                'type' => 'select',
                'class' => 'form-control',
                'empty' => 'Please Select',
                'required' => true,
                'label' => false,
                'id' => 'districtSelect',
            ]); ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="mine" class="labelForm"><span class="compulsoryField">*</span> Mine Name</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('MINE_NAME', [
                'class' => 'form-control cvOn cvAlphaNum',
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
            <label for="mine" class="labelForm"><span class="compulsoryField">*</span> Lessee Owner Name</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('lessee_owner_name', [
                'class' => 'form-control cvOn cvAlphaNum',
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
            <label for="category" class="labelForm"> Mine Category</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('mine_category', [
                'type' => 'select',
                'options' => $category,
                'empty' => 'Please select',
                'class' => 'form-control',
                'label' => false,
            ]); ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="type" class="labelForm"> Type Working </label>
        </div>
        <div class="col-md-6">
            <?php
            $data = ['OPENCAST', 'UNDERGROUND'];
            $data = array_combine($data, $data);
            ?>
            <?= $this->Form->control('type_working', [
                'type' => 'select',
                'options' => $data,
                'empty' => 'Please select',
                'class' => 'form-control',
                'label' => false,
            ]); ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="nature" class="labelForm"> Nature Use</label>
        </div>
        <div class="col-md-6">
            <?php 
            $data = ['CAPTIVE', 'NONCAPTIVE']; 
            $data = array_combine($data, $data);
            ?>
            <?= $this->Form->control('nature_use', [
                'type' => 'select',
                'options' => $data,
                'empty' => 'Please select',
                'class' => 'form-control',
                'label' => false,
            ]); ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="mechanisation" class="labelForm"> Mechanisation</label>
        </div>
        <div class="col-md-6">
            <?php 
            $data = ['MECHANISED', 'OTHER THAN MECHANISED']; 
            $data = array_combine($data, $data);
            ?>
            <?= $this->Form->control('mechanisation', [
                'type' => 'select',
                'options' => $data,
                'empty' => 'Please select',
                'class' => 'form-control',
                'label' => false,
            ]); ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="owner" class="labelForm"> Mine Ownership</label>
        </div>
        <div class="col-md-6">
            <?php 
            $data = ['JOINT', 'PRIVATE', 'PUBLIC']; 
            $data = array_combine($data, $data);
            ?>
            <?= $this->Form->control('mine_ownership', [
                'type' => 'select',
                'options' => $data,
                'empty' => 'Please select',
                'class' => 'form-control',
                'label' => false,
            ]); ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="village" class="labelForm"> <span class="compulsoryField">*</span> Village Name</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('village_name', [
                'class' => 'form-control cvOn cvAlphaNum',
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
            <label for="taluk" class="labelForm"><span class="compulsoryField">*</span> Taluk Name</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('taluk_name', [
                'class' => 'form-control cvOn cvAlphaNum',
                'required' => true,
                'label' => false,
                'pattern' => '[a-zA-Z0-9\s]{1,100}',
                'title' => 'Only letters, numbers are allowed and not more than 100 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="mine" class="labelForm"><span class="compulsoryField">*</span> Post Office</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('post_office', [
                'class' => 'form-control cvOn cvAlphaNum',
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
            <label for="pin" class="labelForm"> Pin</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('pin', [
                'type' => 'number',
                'class' => 'form-control cvOn cvNum',
                'label' => false,
                'pattern' => '[0-9]{1,6}',
                'title' => 'Only number are allowed and not more than 6 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="fax" class="labelForm"> Fax Number</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('fax_no', [
                'type' => 'number',
                'class' => 'form-control cvOn cvNum',
                'label' => false,
                'pattern' => '[0-9]{1,20}',
                'title' => 'Only number are allowed and not more than 20 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="phone" class="labelForm"><span class="compulsoryField">*</span> Phone Number</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('phone_no', [
                'type' => 'tel',
                'class' => 'form-control cvOn cvNum',
                'required' => true,
                'label' => false,
                'pattern' => '[0-9]{1,20}',
                'title' => 'Only number are allowed not more than 20 digit'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="mobile" class="labelForm"><span class="compulsoryField">*</span> Mobile Number</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('mobile_no', [
                'type' => 'tel',
                'class' => 'form-control cvOn cvNum',
                'required' => true,
                'label' => false,
                'pattern' => '[789][0-9]{9}',
                'title' => 'Mobile Number Format ((7|8|9)xxxxxxxx)'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="email" class="labelForm"><span class="compulsoryField">*</span> Email</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('email', [
                'type' => 'email',
                'class' => 'form-control cvOn cvEmail',
                'required' => true,
                'label' => false,
                'pattern' => '/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/',
                'title' => 'Enter valid Email address'
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

									 
										 
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'get_district_url', 'value'=>$this->Url->build(['controller' => 'Ajax', 'action' => 'get-districts-array']))); ?>
<?php echo $this->Html->script('masters/add_mine_code_generation.js?version='.$version); ?>