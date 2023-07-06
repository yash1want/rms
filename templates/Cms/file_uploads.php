<?php ?>
<div class="main-card card fcard mb-1 mt-n3">
    <div class="card-body">
        <div class="rows">
        	<h4 class="text-center font-weight-bold text-alternate">File Uploads</h4>
        </div>

    </div>
</div>
<div class="main-card mb-3 card">
	<div class="card-body">		
		<?php echo $this->Form->create(null, array('type'=>'file', 'enctype'=>'multipart/form-data', 'class'=>'form-group')); ?>
		<div class="form-row">
			<div class="col-md-3"></div>
			<div class="col-md-4">
			<?php echo $this->form->control('file',array('type'=>'file', 'multiple'=>'multiple', 'id'=>'file_uploads', 'label'=>false,'class'=>'form-control')); ?>
				<p class="lab_form_note"><i class="fa fa-info-circle"></i> File type: PDF, jpg &amp; max size upto 15 MB</p>
				<span class="error invalid-feedback" id="error_size_file_uploads"></span>
				<span class="error invalid-feedback" id="error_file_uploads"></span>
				<span class="error invalid-feedback" id="error_type_file_uploads"></span>
			</div>
			<div class="col-md-2">
				<?php echo $this->Form->submit('Upload', array('name'=>'upload', 'id'=>'upload_btn', 'label'=>false,'class'=>'btn btn-info float-right')); ?>
			</div>
		</div>
			<?php echo $this->Form->end(); ?>
		<div class="table-responsive">
			<table class="mb-0 table table-striped " id="list">
				<thead class="bg-dark text-white">
                    <tr>
                        <th class="p-1 border-right-1 border-white">#</th>						
                        <th class="p-1 border-right-1 border-white">File Name</th>
                        <th class="p-1 border-right-1 border-white">Uploaded by</th>
                        <th class="p-1 border-right-1 border-white">Action</th>
                    </tr>
				</thead>                   
                <tbody>
                    <?php $i=1; foreach ($all_files as $single_file){ ?>
                	<tr>
						<td><?php echo $i;?></td>
						<td><?php echo $single_file['file_name'];?></td>
						<td><?php echo base64_decode($single_file['user_email_id']); //for email encoding?></td>
						<td>
							<?php echo $this->Html->link('', array('controller' => 'cms', 'action'=>'fetch_file_id', $single_file['id']),array('class'=>'fa fa-eye','title'=>'Edit')); ?> | 
							<?php echo $this->Html->link('', array('controller' => 'cms', 'action'=>'delete_uploaded_file', $single_file['id']),array('class'=>'fas fa-trash-alt delete_file','title'=>'Delete')); ?>
						</td>
					</tr>
                       
                    <?php $i++; } ?>
                </tbody>
			</table>			
		</div>
		
	</div>
</div>



<?php echo $this->Html->script('cms/file_uploads.js?version='.$version);?>
