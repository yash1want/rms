<?php ?>
<div class="main-card card fcard mb-1 mt-n3">
    <div class="card-body">
        <div class="rows"><h4 class="text-center font-weight-bold text-alternate">All Menus</h4>
        	
            <?php echo $this->Html->link('<i class="fa  fa fa-user-plus"> Add Menu</i>', '/cms/add_menu',array('class'=>'btn btn-primary mt-n4 float-right p-2', 'style'=>'font-size:1.0rem', 'escapeTitle'=>false,'title'=>'Add Menu')); ?>
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
                        <th class="p-1 border-right-1 border-white">Menu Name</th>
                        <th class="p-1 border-right-1 border-white">Position</th>                            
                        <th class="p-1 border-right-1 border-white">Menu Type</th>                            
                        <th class="p-1 border-right-1 border-white">Action</th>
                    </tr>
				</thead>                   
                    <tbody>
                        <?php $i=1; foreach($all_menus as $single_menu){ ?>
                        	<tr>
								<td><?php echo $i;?></td>
								<td><?php echo $single_menu['title'];?></td>
								<td><?php echo $single_menu['position'];?></td>
								<td><?php echo $single_menu['link_type'];?></td>
								<td>
									<?php echo $this->Html->link('', array('controller' => 'cms', 'action'=>'fetch_menu_id', $single_menu['id']),array('class'=>'fa fa-edit','title'=>'Edit')); ?> | 
									<?php echo $this->Html->link('', array('controller' => 'cms', 'action'=>'delete_menu', $single_menu['id']),array('class'=>'fas fa-trash-alt delete_menu','title'=>'Delete')); ?>
								</td>
							</tr>
                           
                        <?php $i++; } ?>
                    </tbody>
			</table>			
		</div>
	</div>
</div>

<?php echo $this->Html->script('cms/all_menus');?>



