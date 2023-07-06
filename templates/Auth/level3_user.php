<div class="main-card card fcard mt-n3">
    <div class="card-body p-1 page-heading text-white">        
            <h5 class="text-center font-weight-bold m-0"><?php echo ucfirst($heading); ?></h5> 
    </div>
</div>
<div class="main-card mb-3 card">
    <div class="card-body">	
        <?php echo $this->Form->create(null, array('type' => 'file' ,'id'=>'add_user')); ?>

            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label>First name <span class="text-danger">*</span></label>                    
                    <?php echo $this->Form->control('first_name', array('type' => 'text','value'=>$firstname, 'class'=>'form-control','id'=>'first_name','required','placeholder'=>'Enter First Name','label'=>false)); ?>               
                    <div id="f_error" class="text-danger"></div>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Last name <span class="text-danger">*</span></label> 
                    <?php echo $this->Form->control('last_name', array('type' => 'text','value'=>$lastname, 'class'=>'form-control','id'=>'last_name','required','placeholder'=>'Enter Last Name','label'=>false)); ?>
                    <div id="l_error" class="text-danger"></div>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Email <span class="text-danger">*</span></label>                    
                    <?php echo $this->Form->control('email', array('type' => 'email','value'=>$email, 'class'=>'form-control','id'=>'email','required','placeholder'=>'Enter Email','label'=>false)); ?>               
                    <div id="email_error" class="text-danger"></div>
                </div>               
            </div>
            <hr>
            <div class="form-row">
                <button type="reset" class="btn btn-info mr-2 font-weight-bold">Reset</button>                
                <?php echo $this->Form->submit($buttonlabel, array('name'=>'save','class'=>'form-control btn btn-success pl-4 pr-4 font-weight-bold','id'=>'btnsave','label'=>false)); ?>
                <?php  echo $this->Html->link('Back', '/auth/level3-users',array('escapeTitle'=>false,'class'=>'btn btn-secondary font-weight-bold pl-4 pr-4 ml-2'));   ?>                
            </div> 
        <?php $this->Form->end() ?>  
    </div>    
</div>


