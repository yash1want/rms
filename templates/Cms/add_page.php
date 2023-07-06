<?php ?>
<div class="main-card card fcard mt-n3">
    <div class="card-body p-1 page-heading text-white">        
            <h5 class="text-center font-weight-bold m-0">Add Page</h5> 
    </div>
</div>
<div class="main-card mb-3 card">
    <div class="card-body">	
        <?php echo $this->Form->create(null, array('type' => 'file' ,'id'=>'add_page')); ?>

            <div class="form-row">

                <div class="col-md-9 mb-3">

                	<div class="form-row">
                		<div class="col-md-11 mb-3">
		                    <label>Title <span class="cRed">*</span></label>
							<?php echo $this->Form->control('title', array('type'=>'text', 'id'=>'title', 'label'=>false,'class'=>'form-control')); ?>	
							<span class="error invalid-feedback" id="error_title"></span>
                		</div>
                		<div class="col-md-11 mb-3">
		                    <label>Page Content <span class="cRed">*</span></label>
							<!-- For ckeditor 5 changed id value to "editor" from "content" 01-07-2021 by Amol-->
							<?php echo $this->Form->control('content', array('type'=>'textarea', 'id'=>'editor','class'=>'' ,'label'=>false,)); ?>
							<span class="error invalid-feedback" id="error_content"></span>
                		</div>
                	</div>


                </div>

                <div class="col-md-3 mb-3">
                    <div class="form-row">
                    	<div class="col-md-12 mb-3">
                    		<label>Publish Date <span class="cRed">*</span></label>
							<?php echo $this->Form->control('publish_date', array('type'=>'text', 'id'=>'publish_date', 'label'=>false, 'readonly'=>true,'class'=>'form-control')); ?>	
							<span class="error invalid-feedback" id="error_publish_date"></span>
                    	</div>
                    	<div class="col-md-12 mb-3">
                    		<label>Archive Date <span class="cRed">*</span></label>
							<?php echo $this->Form->control('archive_date', array('type'=>'text', 'id'=>'archive_date', 'label'=>false, 'readonly'=>true,'class'=>'form-control')); ?>
							<span class="error invalid-feedback" id="error_archive_date"></span>
                    	</div>
                    	<div class="col-md-12 mb-3">
                    		<label>Status <span class="cRed">*</span></label>
							<?php echo $this->Form->control('status', array('type'=>'select', 'options'=>$list_status, 'label'=>false,'class'=>'form-control')); ?>
                    	</div>
                    	<div class="col-md-12 mb-3">
							<label>Get Files URL <span class="cRed">*</span></label>
							<?php echo $this->Form->control('file_path', array('type'=>'select', 'id'=>'file_path', 'class'=>'chosen-select', 'empty'=>'---Select---', 'options'=>$uploaded_files, 'label'=>false,'class'=>'form-control')); ?>
							<?php echo $this->Form->control('copy_file_path', array('type'=>'text', 'id'=>'copy_file_path', 'label'=>false,'class'=>'form-control')); ?>
                    	</div>
                    	<div class="col-md-12 mb-3">
	                    	<label>Meta Keyword <span class="cRed">*</span></label>
							<?php echo $this->Form->control('meta_keyword', array('type'=>'text', 'id'=>'meta_keyword', 'label'=>false,'class'=>'form-control')); ?>
							<span class="error invalid-feedback" id="error_meta_keyword"></span>
						</div>
						<div class="col-md-12 mb-3">
							<label>Meta Description <span class="cRed">*</span></label>
							<?php echo $this->Form->control('meta_description', array('type'=>'textarea', 'id'=>'meta_description', 'label'=>false,'class'=>'form-control')); ?>
							<span class="error invalid-feedback" id="error_meta_description"></span>
						</div>
                    </div>
                </div>

               <div class="card-footer cardFooterBackground">
               		<?php echo $this->Form->submit('Publish', array('name'=>'publish','class'=>'form-control btn btn-success pl-4 pr-4 font-weight-bold','id'=>'publish_btn','label'=>false)); ?>

					<?php echo $this->Html->link('Back', '/cms/all_pages',array('escapeTitle'=>false,'class'=>'btn btn-secondary font-weight-bold pl-4 pr-4 ml-2')); ?>
					
				</div>

            </div>

            


        <?php $this->Form->end() ?>  
    </div>
</div>

	
<?php echo $this->Html->script('cms/add_page');?>