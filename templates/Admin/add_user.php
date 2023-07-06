<?php 
        //$AuthenticationComponent = new AdminController();

        //$AuthenticationComponent->test(); exit;
?>

<div class="main-card card fcard mt-n3">
    <div class="card-body p-1 page-heading text-white">        
            <h5 class="text-center font-weight-bold m-0"><?php echo $heading; ?></h5> 
    </div>
</div>
<div class="main-card mb-3 card">
    <div class="card-body">	
        <?php echo $this->Form->create(null, array('type' => 'file' ,'id'=>'add_user')); ?>

            <?php if($userAllocationStatus == true){ ?>
                <div class="alert alert-info"><i class="fa fa-info-circle"></i> 
                    <?php if($userDetails['role_id'] == 22) { ?>
                        Note: "User Role" and "Parent User" fields are not available for modification, Because some work are allocated to the user. Please Reallocate the work to another user and then update the role.
                    <?php }else{ ?>
                        Note: "User Role" field is not available for modification, Because some work are allocated to the user. Please Reallocate the work to another user and then update the role.
                    <?php } ?>
                </div>
            <?php } ?>

            <div class="form-row">

                <div class="col-md-4 mb-3">
                    <label>First name <span class="text-danger">*</span></label>                    
                    <?php echo $this->Form->control('first_name', array('type' => 'text','value'=>$userDetails['first_name'], 'class'=>'form-control','id'=>'first_name','required','placeholder'=>'Enter First Name','label'=>false)); ?>               
                    <div id="f_error" class="text-danger"></div>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Middle Name</label>
                    <?php echo $this->Form->control('mid_name', array('type' => 'text','value'=>$userDetails['mid_name'], 'class'=>'form-control','id'=>'mid_name','placeholder'=>'Enter Middle Name','label'=>false)); ?>
                    <div id="m_error" class="text-danger"></div>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Last name <span class="text-danger">*</span></label> 
                    <?php echo $this->Form->control('last_name', array('type' => 'text','value'=>$userDetails['last_name'], 'class'=>'form-control','id'=>'last_name','required','placeholder'=>'Enter Last Name','label'=>false)); ?>
                    <div id="l_error" class="text-danger"></div>
                </div>  

            </div>

            <div class="form-row">

                <div class="col-md-4 mb-3">
                    <label>Email <span class="text-danger">*</span></label>                    
                    <?php echo $this->Form->control('email', array('type' => 'email','value'=>base64_decode($userDetails['email']), 'class'=>'form-control','id'=>'email','required','placeholder'=>'Enter Email','label'=>false)); ?>               
                    <div id="email_error" class="text-danger"></div>
                </div>

                <!--<div class="col-md-4 mb-3">
                    <label>Alternet Email</label>
                    <?php //echo $this->Form->control('email_alts', array('type' => 'email','value'=>$userDetails['email_alts'], 'class'=>'form-control','id'=>'alt_email','placeholder'=>'Enter Alternet Email','label'=>false)); ?>
                    <div id="altemail_error" class="text-danger"></div>
                </div>-->

                <div class="col-md-4 mb-3">
                    <label>Mobile No.<span class="text-danger">*</span></label> 
                    <?php echo $this->Form->control('mobile', array('type' => 'number','oninput'=>'javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);','value'=>base64_decode($userDetails['mobile']), 'maxlength'=>'10','class'=>'form-control','id'=>'mobile','required','placeholder'=>'Enter Mobile Number','label'=>false)); ?>
                    <div id="mobile_error" class="text-danger"></div>
                </div>

            </div>
            <div class="form-row">

                <div class="col-md-4 mb-3">
                    <label>Phone No</label>                    
                    <?php echo $this->Form->control('phone', array('type' => 'number', 'oninput'=>'javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);','value'=>$userDetails['phone'], 'class'=>'form-control','id'=>'phone','minlength'=>'6','maxlength'=>'15','placeholder'=>'Enter Phone No','label'=>false)); ?>               
                    <div id="phone_error" class="text-danger"></div>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Designation</label>
                    <?php echo $this->Form->control('designation', array('type' => 'text','value'=>$userDetails['designation'], 'class'=>'form-control','id'=>'designation','placeholder'=>'Enter Designation','label'=>false)); ?>
                    <div id="desig_error" class="text-danger"></div>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Profile Photo</label> 
                    <?php echo $this->Form->control('user_image', array('type' => 'file','class'=>'form-control','id'=>'user_image','label'=>false)); ?>
                    <div class="text-info">Size: 2MB, File Type: jpg,jpeg</div>
                    <div id="photo_error" class="text-danger"></div>
                </div>

            </div>

            <!--<div class="form-row">
                <div class="col-md-4 mb-3">
                    <label>State <span class="text-danger">*</span></label>                    
                    <?php //echo $this->Form->control('state_code', array('type' => 'select','options'=>$statelist, 'value'=>$userDetails['state_code'], 'class'=>'form-control','id'=>'f_state','empty'=>'Select State','label'=>false)); ?>               
                    <div id="state_error" class="text-danger"></div>
                </div>
                <div class="col-md-4 mb-3">
                    <label>District <span class="text-danger">*</span></label>
                    <?php //echo $this->Form->control('district_id', array('type' => 'select','options'=>$districts, 'value'=>$userDetails['district_id'], 'class'=>'form-control','id'=>'f_district','label'=>false)); ?>
                    <div id="district_error" class="text-danger"></div>
                </div>
                <div class="col-md-4 mb-3">
                    <label>User Name <span class="text-danger">*</span></label>                    
                                 
                    <div id="username_error" class="text-danger"></div>
                </div>                
            </div>-->

            <?php if($_SESSION['userAction'] !='profile'){ ?>

                <div class="form-row">

                    <?php if($userAllocationStatus == true){ ?>     

                        <div class="col-md-4 mb-3">
                            <label>User Role <span class="text-danger">*</span></label>
                            <?php echo $this->Form->control('role_id_copied', array('type' => 'select', 'options'=>$rolelist,'value'=>$userDetails['role_id'], 'class'=>'form-control','id'=>'role_id_copied','empty'=>'Select Role','label'=>false, 'disabled'=>true)); ?>
                            <div id="role_error" class="text-danger"></div>
                        </div>
                        <?php echo $this->Form->control('role_id', array('type'=>'hidden', 'value'=>$userDetails['role_id'],'id'=>'role_id','label'=>false,'readonly'=>true)); ?>

                    <?php } else { ?>

                        <div class="col-md-4 mb-3">
                            <label>User Role <span class="text-danger">*</span></label>
                            <?php echo $this->Form->control('role_id', array('type' => 'select', 'options'=>$rolelist,'value'=>$userDetails['role_id'], 'class'=>'form-control','id'=>'role_id','empty'=>'Select Role','label'=>false)); ?>
                            <div id="role_error" class="text-danger"></div>
                        </div>

                    <?php } ?>

                    <?php if($userAllocationStatus == true){ ?>
                    
                        <div class="col-md-4 mb-3" id="parentbox">
                            <label id="parentlabel"><?php echo $parentUserLabel; ?><span class="text-danger">*</span></label> 
                            <?php echo $this->Form->control('parentuser_copied', array('type' => 'select', 'options'=>$parentUserList, 'value'=>$userDetails['parent_id'], 'class'=>'form-control','id'=>'parentinput_copied','label'=>false, 'disabled'=>true)); ?>
                            <div id="parent_error" class="text-danger"></div>
                        </div>
                        <?php echo $this->Form->control('parentuser', array('type'=>'hidden', 'value'=>$userDetails['parent_id'],'id'=>'parentinput','label'=>false,'readonly'=>true)); ?>

                    <?php } else { ?>

                        <div class="col-md-4 mb-3" id="parentbox">
                            <label id="parentlabel"><?php echo $parentUserLabel; ?><span class="text-danger">*</span></label> 
                            <?php echo $this->Form->control('parentuser', array('type' => 'select', 'options'=>$parentUserList, 'value'=>$userDetails['parent_id'], 'class'=>'form-control','id'=>'parentinput','label'=>false)); ?>
                            <div id="parent_error" class="text-danger"></div>
                        </div>
						
                    <?php } ?>

                    <div class="col-md-4 mb-3" id="zoneregionbox">
                        <label id="zoneregionlabel"><?php echo $zoneRegionLabel; ?><span class="text-danger">*</span></label> 
                        <?php echo $this->Form->control('zoneregion', array('type' => 'select', 'options'=>$zoneRegion, 'value'=>$zoneRegionValue, 'class'=>'form-control','id'=>'zoneregionid','label'=>false)); ?>
                        <div id="zone_error" class="text-danger"></div>
                    </div>   

                </div>
            <?php } ?>

            <hr>
            <div class="form-row">

                <button type="reset" class="btn btn-info mr-2 font-weight-bold">Reset</button>   

                <?php echo $this->Form->submit($buttonlabel, array('name'=>'save','class'=>'form-control btn btn-success pl-4 pr-4 font-weight-bold','id'=>'btnsave','label'=>false)); ?>

                <?php if($_SESSION['userAction'] =='profile'){

                          echo $this->Html->link('Back', '/mms/home',array('escapeTitle'=>false,'class'=>'btn btn-secondary font-weight-bold pl-4 pr-4 ml-2')); 

                    }else{

                        echo $this->Html->link('Cancel', '/admin/list-users',array('escapeTitle'=>false,'class'=>'btn btn-secondary font-weight-bold pl-4 pr-4 ml-2')); 
                    }
                ?>

            </div>   

        <?php $this->Form->end() ?>  
    </div>
</div>

<input type="hidden" id="useraction" value="<?php echo $_SESSION['userAction']; ?>">
<input type="hidden" id="usrid" value="<?php if(isset($_SESSION['editUserId'])){ echo $_SESSION['editUserId']; } ?>">
<input type="hidden" id="parentUserListCount" value="<?= count($parentUserList); ?>">
<input type="hidden" id="zoneRegionCount" value="<?= count($zoneRegion); ?>">
<input type="hidden" id="no_pending_work" value="">
<input type="hidden" id="current_parent_id" value="<?php echo $userDetails['parent_id']; ?>">
<input type="hidden" id="userEmailOld" value="<?php echo base64_decode($userDetails['email']); ?>">
<?php echo $this->Html->script('admin/add_user'); ?>
        