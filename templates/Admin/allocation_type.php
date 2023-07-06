<div class="main-card card fcard mt-n3">
    <div class="card-body p-1 page-heading text-white">        
            <h5 class="text-center font-weight-bold m-0"><?php echo $title; ?></h5> 
    </div>
</div>
<div class="main-card mb-3 card">
    <div class="card-body">	
        <?php if(!empty($this->getRequest()->getSession()->read('error_msg'))){ ?>
            <div class="alert alert-danger fade show errormsg" role="alert"><i class="fa fa-times-circle"></i> 
                <?php echo $this->getRequest()->getSession()->read('error_msg'); ?>
            </div>
        <?php $this->getRequest()->getSession()->delete('error_msg');  } ?>

        <h6 class="text-center font-weight-bold m-0">PLEASE SELECT THE SERIES TYPE TO ALLOCATE IT'S USERS</h6>
        
        <?php echo $this->Form->create(null, array('type' => 'file' ,'id'=>'allocation-series-type')); ?>
            
            <div class="col-md-4 offset-md-4 mt-3">
                <?php echo $this->Form->control('seriestype', array('type' => 'select','options'=>$seriestype, 'class'=>'form-control','id'=>'f_state','empty'=>'Select the Series Type For Allocation','label'=>false)); ?>               
                
            </div>
            <?php echo $this->Form->submit('GO', array('name'=>'save','class'=>'btn btn-success pl-4 pr-4 font-weight-bold float-right','id'=>'btnsave','label'=>false)); ?>
            <?php echo $this->Html->link('Back', '/mms/home',array('escapeTitle'=>false,'class'=>'btn btn-secondary font-weight-bold pl-4 pr-4 ml-2')); ?> 
        
        <?php $this->Form->end() ?> 

    </div>
</div>    