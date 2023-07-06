<div class="main-card card fcard mb-1 mt-n3">
    <div class="card-body">
        <div class="rows"><h4 class="text-center font-weight-bold text-alternate">All User List</h4>
            <?php echo $this->Html->link('<i class="fa  fa fa-user-plus"> Add User</i>', '/admin/add-user',array('class'=>'btn btn-primary mt-n4 float-right p-2', 'style'=>'font-size:1.0rem', 'escapeTitle'=>false,'title'=>'Add User')); ?>
        </div>
    </div>
</div>
<div class="main-card mb-3 card">
		<div class="card-body">			
			<div class="table-responsive">
                
                <?php if(!empty($this->getRequest()->getSession()->read('usr_msg_suc'))){ ?>
                    <div class="alert alert-success fade show" role="alert"><i class="fa fa-check-circle"></i> 
                        <?php echo $this->getRequest()->getSession()->read('usr_msg_suc'); ?>
                    </div>
                <?php $this->getRequest()->getSession()->delete('usr_msg_suc'); } ?>
                
                <?php if(!empty($this->getRequest()->getSession()->read('usr_msg_err'))){ ?>
                    <div class="alert alert-danger fade show" role="alert"><i class="fa fa-check-circle"></i> 
                        <?php echo $this->getRequest()->getSession()->read('usr_msg_err'); ?>
                    </div>
                <?php $this->getRequest()->getSession()->delete('usr_msg_err'); } ?>

                <?php echo $this->Form->create(null); ?>
				<table class="mb-0 table table-striped " id="list">
					<thead class="bg-dark text-white">
                        <tr>
                            <th class="p-1 border-right-1 border-white">#</th>						
                            <th class="p-1 border-right-1 border-white">Name</th>
                            <th class="p-1 border-right-1 border-white">User Name</th>
                            <th class="p-1 border-right-1 border-white">Email</th>                            
                            <th class="p-1 border-right-1 border-white">Role</th>                            
                            <th class="p-1 border-right-1 border-white">Action</th>
                        </tr>
					</thead>                   
                        <tbody>
                            <?php $i=1; foreach($listUser as $each){ ?>
                                <tr>
                                    <th scope="row"><?php echo $i; ?></th>							
                                    <td><?php echo $each['first_name'].' '.$each['last_name']; ?></td>
                                    <td><?php echo $each['user_name']; ?></td>
                                    <td><?php echo base64_decode($each['email']); ?></td>                                    
                                    <td>
                                        <?php echo (isset($rolelist[$each['role_id']])) ? $rolelist[$each['role_id']] : '--'; ?>
                                        <?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'usr_role-'.$each['id'], 'value'=>$each['role_id'])); ?>
                                    </td>                                    
                                    <td>
                                        <div class="btn-group" role="group">
                                            <?php 
                                                echo $this->Html->link('<i class="fas fa-user-edit pr-1 pl-1"></i>', '/admin/user-edit/'.$each['id'],array('escapeTitle'=>false,'title'=>'Edit','class'=>'btn btn-sm text-info'));    
                                                if($each['is_delete']==0){ 
                                                    echo $this->Form->Button('<i class="fa fa fa-user-times pr-1 pl-1"></i>', array('type'=>'button', 'class'=>'btn btn-sm btn-shadow p-1 text-danger ml-2 deact_usr','escapeTitle'=>false,'title'=>'Deactive user','id'=>'deact_usr-'.$each['id'])); 
                                                } 
                                                elseif($each['is_delete']==1){ echo $this->Form->Button('<i class="fas fa-user-check pr-1 pl-1"></i>',array('type'=>'button','class'=>'btn btn-sm btn-shadow p-1 text-success ml-2 act_usr','escapeTitle'=>false,'title'=>'Activate user','id'=>'act_usr-'.$each['id'])); }                                         
                                            ?>
                                        </div>
                                    </td>							
                                </tr>
                            <?php $i++; } ?>
                        </tbody>
				</table>	
                <?php echo $this->Form->end(); ?>		
			</div>
		</div>
	</div>
    <script> $('#list').DataTable();	</script>
    <?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'usr_id_hidden')); ?>
    <?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'usr_role_id_hidden')); ?>
    <?php echo $this->Html->script('admin/list_users.js?version='.$version); ?>
