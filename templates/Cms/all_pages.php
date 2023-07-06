<?php ?>
<div class="main-card card fcard mb-1 mt-n3">
    <div class="card-body">
        <div class="rows"><h4 class="text-center font-weight-bold text-alternate">All Site Pages</h4>
        	
            <?php echo $this->Html->link('<i class="fa  fa fa-user-plus"> Add Page</i>', '/cms/add_page',array('class'=>'btn btn-primary mt-n4 float-right p-2', 'style'=>'font-size:1.0rem', 'escapeTitle'=>false,'title'=>'Add Page')); ?>
        </div>
    </div>
</div>
<div class="main-card mb-3 card">
		<div class="card-body">			
			<div class="table-responsive">
				<table class="mb-0 table table-striped return_list_table" id="list"> <!-- Added class return_list_table for Date sorting on 20-10-2022 -->
					<thead class="bg-dark text-white">
                        <tr>
                            <th class="p-1 border-right-1 border-white">#</th>						
                            <th class="p-1 border-right-1 border-white">Page Name</th>
                            <th class="p-1 border-right-1 border-white">Author</th>
                            <th class="p-1 border-right-1 border-white">Status</th>                            
                            <th class="p-1 border-right-1 border-white">Date</th>                            
                            <th class="p-1 border-right-1 border-white">Action</th>
                        </tr>
					</thead>                   
                        <tbody>
                            <?php $i=1; foreach($all_pages as $single_page){ ?>
                            	<tr>
									<td><?php echo $i;?></td>
									<td><?php echo $single_page['title'];?></td>
									<td><?php echo base64_decode($single_page['user_email_id']); //for email encoding ?></td>
									<td><?php echo $single_page['status'];?></td>
									<td><?php echo $single_page['publish_date'];?></td>
									<td>


										<?php echo $this->Html->link('', array('controller' => 'cms', 'action'=>'pagePreview', $single_page['id']),array('target'=>'blank','class'=>'fas fa-eye','title'=>'Preview')); ?> | 
										<?php echo $this->Html->link('', array('controller' => 'cms', 'action'=>'fetch_page_id', $single_page['id']),array('class'=>'fa fa-edit','title'=>'Edit')); ?> | 
										<?php echo $this->Html->link('', array('controller' => 'cms', 'action'=>'delete_page', $single_page['id']),array('class'=>'fas fa-trash-alt delete_page','title'=>'Delete')); ?>
									</td>
								</tr>
                               
                            <?php $i++; } ?>
                        </tbody>
				</table>			
			</div>
		</div>
	</div>
    


	<?php echo $this->Html->script('cms/all_pages');?>
