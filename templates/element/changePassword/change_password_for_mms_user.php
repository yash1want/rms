<?php 
    // $_SESSION['randSalt'] = Rand();
    $_SESSION['randSalt'] = 8467815;
    $salt_server = $_SESSION['randSalt'];
?>
<div class="col-md-12">
    <div class="main-card card fcard mt-n3"><div class="card-body p-1 page-heading text-white"><h5 class="text-center font-weight-bold m-0">Change Password</h5> </div></div>
        <?php echo $this->Form->create(null, array('id'=>'change_password')); ?>

            <div class="main-card mb-3 card">
                <div class="card-body"> 

                    <div class="form-group row offset-2">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Old Password <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <?php echo $this->Form->control('old_password', array('type' => 'password','class'=>'form-control','id'=>'Oldpassword','required','placeholder'=>'Enter Old Password','label'=>false)); ?>
                            <span id="error_oldpass" class="error"></span>
                        </div>
                    </div>

                    <div class="form-group row offset-2">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">New Password <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <?php echo $this->Form->control('new_password', array('type' => 'password','class'=>'form-control','id'=>'Newpassword','placeholder'=>'Enter New Password','label'=>false)); ?>
                            <span id="error_newpass" class="error"></span>
                        </div>
                    </div>
                    <?php echo $this->Form->control('salt_value', array('label'=>'', 'id'=>'hiddenSaltvalue', 'type'=>'hidden', 'value'=>$salt_server)); ?>

                    <div class="form-group row offset-2">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Confirm Password <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <?php echo $this->Form->control('confirm_password', array('type' => 'password','class'=>'form-control','id'=>'confpass','required','placeholder'=>'Confirm New Password','label'=>false)); ?>
                            <span id="error_confpass" class="error"></span>
                        </div>
                    </div>
                    
                    <div class="form-group row offset-2">
                        <div class="col-sm-9">
                            <div class="alert alert-info p-1 pl-2"><i class="fa fa-info-circle"></i> Note: Password must contain combination of Alphanumeric, special characters, at least one uppercase letter, at least one lowercase letter and minimum 8 characters</div>
                        </div>
                    </div>
                    
                    <div class="form-group row offset-2">
                        <div class="col-sm-8 labelForm">
                            <div class="row">
                                <?php echo $this->Form->control('Submit', array('type'=>'submit', 'name'=>'submit', 'id' => 'submit_btn', 'label'=>false,'class'=>'btn btn-success ml-3')); ?>
                                <?php echo $this->Form->control('Reset', array('type'=>'reset', 'id'=>'reset_btn', 'label'=>false, 'class'=>'btn btn-secondary ml-3')); ?>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
         
    <?php echo $this->Form->end(); ?>

<?php echo $this->Html->script('users/change_password.js?version='.$version); ?>
