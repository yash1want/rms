<div class="main-card card fcard mt-n3">
    <div class="card-body p-1 page-heading text-white">        
            <h5 class="text-center font-weight-bold m-0">Profile</h5> 
    </div>
</div>

<div class="main-card mb-3 card">
    <div class="card-body main">	
        <?php echo $this->Form->create(null, array('type' => 'file' ,'id'=>'add_user')); ?>

            <div class="form-row">

                <div class="col-md-4 mb-3">
                    <label>First name <span class="text-danger">*</span></label>                    
                    <?php echo $this->Form->control('first_name', array('type' => 'text','value'=>$user_details['mcu_first_name'], 'class'=>'form-control pl-2 cvOn cvAlphaNum cvReq','id'=>'first_name','required','placeholder'=>'Enter First Name','label'=>false)); ?>               
                    <div id="f_error" class="text-danger"></div>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Middle Name</label>
                    <?php echo $this->Form->control('mid_name', array('type' => 'text','value'=>$user_details['mcu_middle_name'], 'class'=>'form-control pl-2 cvOn cvAlphaNum','id'=>'mid_name','placeholder'=>'Enter Middle Name','label'=>false)); ?>
                    <div id="m_error" class="text-danger"></div>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Last name <span class="text-danger">*</span></label> 
                    <?php echo $this->Form->control('last_name', array('type' => 'text','value'=>$user_details['mcu_last_name'], 'class'=>'form-control pl-2 cvOn cvAlphaNum cvReq','id'=>'last_name','required','placeholder'=>'Enter Last Name','label'=>false)); ?>
                    <div id="l_error" class="text-danger"></div>
                </div>  

            </div>

            <div class="form-row">

                <div class="col-md-4 mb-3">
                    <label>Email <span class="text-danger">*</span></label>                    
                    <?php echo $this->Form->control('email', array('type' => 'email','value'=>base64_decode($user_details['mcu_email']), 'class'=>'form-control pl-2 cvOn cvEmail cvReq','id'=>'email','required','placeholder'=>'Enter Email','label'=>false)); ?>               
                    <div id="email_error" class="text-danger"></div>
                </div>

                <!--<div class="col-md-4 mb-3">
                    <label>Alternet Email</label>
                    <?php //echo $this->Form->control('email_alts', array('type' => 'email','value'=>$userDetails['email_alts'], 'class'=>'form-control','id'=>'alt_email','placeholder'=>'Enter Alternet Email','label'=>false)); ?>
                    <div id="altemail_error" class="text-danger"></div>
                </div>-->

                <div class="col-md-4 mb-3">
                    <label>Mobile No.<span class="text-danger">*</span></label> 
                    <?php echo $this->Form->control('mobile', array('type' => 'number','value'=>base64_decode($user_details['mcu_mob_num']), 'maxlength'=>'10','class'=>'form-control pl-2 cvOn cvNum cvReq','id'=>'mobile','required','placeholder'=>'Enter Mobile Number','label'=>false)); ?>
                    <div id="mobile_error" class="text-danger"></div>
                </div>

            </div>
            <div class="form-row">

                <div class="col-md-4 mb-3">
                    <label>Designation</label>
                    <?php echo $this->Form->control('designation', array('type' => 'text','value'=>$user_details['mcu_designation'], 'class'=>'form-control pl-2','id'=>'designation','placeholder'=>'Enter Designation','label'=>false)); ?>
                    <div id="desig_error" class="text-danger"></div>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Profile Photo</label> 
                    <?php echo $this->Form->control('user_image', array('type' => 'file','class'=>'form-control pl-2','id'=>'user_image','label'=>false)); ?>
                    <div class="text-danger">Size: 2MB, File Type: jpg,jpeg</div>
                    <div id="photo_error" class="text-danger"></div>
                </div>

            </div>
            <hr>
            <?php if($_SESSION['loginusertype'] != 'primaryuser'){ ?>
                <div class="form-row">

                    <button type="reset" class="btn btn-info mr-2 font-weight-bold">Reset</button>   

                    <?php echo $this->Form->submit('Update', array('name'=>'save','class'=>'form-control btn btn-success pl-4 pr-4 font-weight-bold','id'=>'btnsave','label'=>false)); ?>

                    <?php   echo $this->Html->link('Cancel', '/auth/auth-home',array('escapeTitle'=>false,'class'=>'btn btn-secondary font-weight-bold pl-4 pr-4 ml-2'));  ?>

                </div> 
            <?php }else{ 
                         echo $this->Html->link('Back', '/auth/primary-home',array('escapeTitle'=>false,'class'=>'btn btn-secondary font-weight-bold pl-4 pr-4 ml-2'));
            } ?>  

        <?php $this->Form->end() ?>  
    </div>
</div>
<?php 
    echo $this->Html->script('auth/profile_validation.js?version='.$version);
    if($_SESSION['loginusertype'] == 'primaryuser'){ 
        echo $this->Html->script('auth/profile.js?version='.$version);
    }
?>