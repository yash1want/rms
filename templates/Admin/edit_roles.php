<?php echo $this->Html->css('admin/setroles'); ?>
<div class="main-card card fcard mt-n3">
    <div class="card-body p-1 page-heading text-white">        
            <h5 class="text-center font-weight-bold m-0"><?php echo 'Edit Roles'; ?></h5> 
    </div>
</div>
<div class="main-card mb-3 card">
    <div class="card-body">
        <?php echo $this->Form->create(null, array('type' => 'file' ,'id'=>'set_roles')); ?>
        <div class="form-row">
            <div class="col-md-4 mb-3"></div>
            <div class="col-md-offset-2 col-md-4 mb-3">
                <label>Select User <span class="text-danger">*</span></label>                    
                <?php echo $this->Form->control('selected_user', array('type' => 'select','options'=>$users,'value'=>'', 'class'=>'form-control forminput edit_selected_user','id'=>'selected_user','empty'=>'Select User','label'=>false)); ?>               
                <div id="f_error" class="text-danger"></div>
            </div>
        </div>
        <div>
            <div class="form-row">
                <div class="col-md-2 mb-3"></div>
                <div class="col-md-8 p-4 rolebox editbox">
                    <div class="form-row"><label class="roleheading">Common Roles</label></div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <?php echo $this->Form->control('add_user', array('type' => 'checkbox', 'class'=>'form-control checkboxx forminput', 'work_alloc_st'=>0)); ?>
                        </div>
                        <div class="col-md-3 mb-3">
                            <?php echo $this->Form->control('user_roles', array('type' => 'checkbox', 'class'=>'form-control checkboxx forminput', 'work_alloc_st'=>0)); ?>
                        </div>
                        <div class="col-md-3 mb-3">
                            <?php echo $this->Form->control('cms', array('type' => 'checkbox', 'class'=>'form-control checkboxx forminput', 'work_alloc_st'=>0)); ?>
                        </div>
                        <div class="col-md-3 mb-3">
                            <?php //echo $this->Form->control('cms', array('type' => 'checkbox', 'class'=>'form-control checkboxx')); ?>
                        </div>
                    </div>
					<!-- Add new mining plan roles, Pravin Bhakare 07-06-2022 -->
					<div class="form-row"><label class="roleheading">Mining Plan Roles</label></div>					
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <?php echo $this->Form->control('io', array('type' => 'checkbox', 'label' => array('text'=>'Inspection Officer'), 'class'=>'form-control checkboxx', 'work_alloc_st'=>0, 'work_alloc_txt'=>0)); ?>
                        </div>
                        <div class="col-md-3 mb-3">
                            <?php echo $this->Form->control('ddo', array('type' => 'checkbox', 'label' => array('text'=>'DDO'), 'class'=>'form-control checkboxx', 'work_alloc_st'=>0, 'work_alloc_txt'=>0)); ?>
                        </div>
                        <div class="col-md-5 mb-3">
                            <?php echo $this->Form->control('sodo', array('type' => 'checkbox', 'label' => array('text'=>'Suptd. Ore Dressing Officer'), 'class'=>'form-control checkboxx', 'work_alloc_st'=>0, 'work_alloc_txt'=>0)); ?>
                        </div>
                        <!-- Added COM user role checkbox on 22-09-2022 by Aniket -->
                        <div class="col-md-4 mb-3">
                            <?php echo $this->Form->control('com', array('type' => 'checkbox', 'label' => array('text'=>'COM'), 'class'=>'form-control checkboxx', 'work_alloc_st'=>0, 'work_alloc_txt'=>0)); ?>
                        </div>
                         <!--<div class="col-md-3 mb-3">
                            <?php //echo $this->Form->control('cms', array('type' => 'checkbox', 'class'=>'form-control checkboxx')); ?>
                        </div>-->
                        <!-- Added view_only user role checkbox on 29-03-2023 by Ankush T -->
                         <div class="col-md-3 mb-3">
                            <?php echo $this->Form->control('view_only', array('type' => 'checkbox','class'=>'form-control checkboxx')); ?>
                        </div>
                    </div>
                    <div class="row" id="chk_error" class="text-danger"></div>
                    <div class="form-row float-right">                                
                        <?php echo $this->Form->submit('Update', array('name'=>'save','class'=>'form-control btn btn-success pl-4 pr-4 font-weight-bold float-right','id'=>'btnupdate','label'=>false)); ?>
                    </div>     
                </div>
                <div class="col-md-2 mb-3"></div>                       
            </div> 
        </div> 
        <?php echo $this->Form->end(); ?>      
    </div>    
</div>   

<?php echo $this->Html->script('admin/setroles.js?version='.$version); ?>