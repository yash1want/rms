
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_minerals']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All Minerals</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Mineral Name</th>
            <th>Mineral Code</th>
            <th>Mineral Form Type</th>            
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($mineLists as $mineList) : ?>
        <tr>
            <td><?php echo $mineList['mineral_name']; ?></td>
            <td><?php echo $mineList['mineral_code']; ?></td>
            <td><?php if(in_array($mineList['form_type'],array(1,2,3,4,8))){ 
							echo 'F1'; 
					  }elseif($mineList['form_type'] == 5){
						  echo 'F2'; 
					  }elseif($mineList['form_type'] == 7){
						  echo 'F3';
					  }else{
						  echo '';
					  }
			?></td>    
            <td> 
				<?php if($mineList['delete_status'] == 'no'){ ?>	
					<a href="<?= $this->Url->build(['action' => 'delete_mineral_dt', $mineList['mineral_code']]) ?>" class="delete_mine_code_generation" title="Deactivated Mineral">
						<i class="fas fa-trash"></i>
					</a>
				<?php }else{
					echo 'Deactivated';
				} ?>	
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>
