<div class="main-card card fcard mb-1 mt-n3">
    <div class="card-body">
        <div class="rows"><h4 class="text-center font-weight-bold text-alternate">Users List</h4>
            <?php echo $this->Html->link('<i class="fa  fa fa-user-plus"> Add User</i>', '/auth/level3-user',array('class'=>'btn btn-primary mt-n4 float-right p-2', 'style'=>'font-size:1.0rem', 'escapeTitle'=>false,'title'=>'Add User')); ?>
        </div>
    </div>
</div>
<div class="main-card mb-3 card">
		<div class="card-body">			
			<div class="table-responsive">
				<table class="mb-0 table table-striped " id="list">
					<thead class="bg-dark text-white">
                        <tr>
                            <th class="p-1 border-right-1 border-white">#</th>						
                            <th class="p-1 border-right-1 border-white">Name</th>
                            <th class="p-1 border-right-1 border-white">User Name</th>
                            <th class="p-1 border-right-1 border-white">Email</th> 
                            <th class="p-1 border-right-1 border-white">Action</th>
                        </tr>
					</thead>                   
                        <tbody>
                            <?php $i=1; if(isset($level3users)){
                                    foreach($level3users as $each){ ?>
                                <tr>
                                    <th scope="row"><?php echo $i; ?></th>							
                                    <td><?php echo $each['mcu_first_name'].' '.$each['mcu_last_name']; ?></td>
                                    <td><?php echo $each['mcu_child_user_name']; ?></td>
                                    <td><?php echo base64_decode($each['mcu_email']); ?></td> 
                                    <td>
                                        <?php                                             
                                            if($each['is_deleted']=='no'){ 
                                                echo $this->Html->link('<i class="fas fa-user-edit pr-1 pl-1"></i>', '/auth/update-level3-user/'.$each['mcu_user_id'],array('escapeTitle'=>false,'title'=>'Edit','class'=>'text-info'));    
                                                echo $this->Html->link('<i class="fa  fa fa-user-times pr-1 pl-1"> Deactive</i>', '/auth/level3-user-deactivited/'.$each['mcu_user_id'],array('class'=>'btn-shadow p-1','escapeTitle'=>false,'title'=>'Deactive','class'=>'text-danger ml-2')); 
                                            } 
                                            elseif($each['is_deleted']=='yes'){ echo $this->Html->link('<i class="fas fa-user-check pr-1 pl-1"> Active</i>', '/auth/level3-user-activited/'.$each['mcu_user_id'],array('class'=>'btn-shadow p-1','escapeTitle'=>false,'title'=>'Active','class'=>'text-success ml-2')); }                                         
                                            
                                        ?>
                                    </td>							
                                </tr>
                            <?php $i++; } } ?>
                        </tbody>
				</table>			
			</div>
		</div>
	</div>
    <script> $('#list').DataTable();	</script>
    