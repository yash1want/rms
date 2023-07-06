<div class="main-card card fcard mt-n3">
    <div class="card-body p-1 page-heading text-white">        
            <a href="<?php echo $this->getRequest()->getAttribute('webroot');?>admin/allocation-type/allocate" class="btn btn-light float-left"> Back <a>
            <h5 class="text-center font-weight-bold m-0">Allocation</h5> 
    </div>
</div>

<input type="hidden" id="userrole" value="<?php echo $_SESSION['mms_user_role']; ?>">
<input type="hidden" id="seriestype" value="<?php echo $_SESSION['seriestype']; ?>">
<input type="hidden" id="allocationtype" value="allocate">

<div class="main-card mb-3 card">
    <div class="card-body">	

        <div class="row pb-4">

            <div class="col-md-4">

                <?php if($_SESSION['seriestype'] == 'lseries'){ ?>

                    <div class="col-md-12">
                        <label>Activity Type</label>
                        <?php echo $this->Form->control('activity_type', array('type'=>'select', 'class'=>'form-control f-control end_all_filter', 'id'=>'activity_type', 'options'=>$activity_result, 'empty'=>'Select', 'label'=>false)); ?>
                    </div>
                    <div class="col-md-12">
                        <label>State</label>
                        <?php echo $this->Form->control('state_code', array('type'=>'select', 'class'=>'form-control f-control end_all_filter', 'id'=>'state_code', 'options'=>$dir_state_result, 'empty'=>'Select', 'label'=>false)); ?>
                    </div>

                 <?php } ?>

                 <?php if($_SESSION['seriestype'] == 'fseries'){ ?>

                    <div class="col-md-12">
                        <label>Mineral Type</label>
                        <?php echo $this->Form->control('mineral_name', array('type'=>'select', 'class'=>'form-control f-control end_all_filter', 'id'=>'mineral_name', 'options'=>$mineral_name_list, 'empty'=>'Select', 'label'=>false)); ?>
                    </div>
                    <div class="col-md-12">
                        <label>State</label>
                        <?php echo $this->Form->control('state_code', array('type'=>'select', 'class'=>'form-control f-control end_all_filter', 'id'=>'state_code', 'options'=>$dir_state_result, 'empty'=>'Select', 'label'=>false)); ?>
                    </div>

                 <?php } ?>   

                <div class="col-md-12">
                    <label>Supervisor Id <span class="text-danger">*</span></label>
                    <?php echo $this->Form->control('sup_id', array('type'=>'select', 'class'=>'form-control f-control ', 'id'=>'sup_id', 'options'=>$suplist, 'empty'=>'Select', 'label'=>false)); ?>
                </div>
                <div class="col-md-12">
                    <label>Primary Id <span class="text-danger">*</span></label>
                    <?php echo $this->Form->control('pri_id', array('type'=>'select', 'class'=>'form-control f-control ', 'id'=>'pri_id', 'options'=>$primarylist, 'empty'=>'Select', 'label'=>false)); ?>
                </div>
                <div class="col-md-12 pt-5">
                    <label></label>
                    <?php echo $this->Form->control('Allocate', array('type'=>'button', 'class'=>'btn btn-success', 'id'=>'allocate', 'label'=>false)); ?>
                </div>
            </div>

            <div class="col-md-8">

                <?php echo $this->Form->create(null, array('type' => 'file' ,'id'=>'add_user')); ?>
                    
                    <table class="mb-0 table table-striped " id="unallocateRecord">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th class="p-1 border-right-1 border-white"></th>                    
                                <th class="p-1 border-right-1 border-white">User Id</th>
                            </tr>
                        </thead>
                    </table>
                    <?php $this->Form->end() ?>  

            </div>
            
        </div>    

        
    </div>
</div>
<?php //echo $this->Html->css('admin/dataTables.checkboxes'); ?>
<?php echo $this->Html->script('admin/dataTables.checkboxes.min'); ?>
<?php echo $this->Html->script('admin/allocation'); ?>