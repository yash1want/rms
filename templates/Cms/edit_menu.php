<?php ?>
<div class="main-card card fcard mt-n3">
    <div class="card-body p-1 page-heading text-white">        
            <h5 class="text-center font-weight-bold m-0">Edit Menus</h5> 
    </div>
</div>
<div class="main-card mb-3 card">
    <div class="card-body">	
        <?php echo $this->Form->create(null, array('type' => 'file' ,'id'=>'add_page')); ?>
        <div class="form-row">
            <div class="col-md-6">
            	<div class="col-md-12 mb-3">
            		<label>Menu Name <span class="cRed">*</span></label>
					<?php echo $this->Form->control('title', array('type'=>'text', 'label'=>false, 'placeholder'=>'Enter Menu Title','class'=>'form-control','value'=>$menu_details['title'])); ?>
						<span id="error_title" class="error invalid-feedback"></span>
            	</div>
            	<div class="col-md-12 mb-3 ">
            		<label>Menu Type <span class="cRed">*</span></label>
					<div class="col-md-9">
						<?php
							$options=array('page'=>'Page','external'=>'External');
							$attributes=array('legend'=>false, 'id'=>'link_type', 'value'=>$menu_details['link_type'],'class'=>'m1');
							echo $this->Form->radio('link_type',$options,$attributes); ?>
					</div>
					<span id="error_link_type" class="error invalid-feedback"></span>
            	</div>
            	<div class="col-md-12 mb-3">
            		<div id="external_link_field">
						<p class="badge badge-success">If External, Paste Link with http:// or https://</p>
						<?php echo $this->Form->control('external_link', array('type'=>'text', 'id'=>'external_link', 'label'=>false, 'placeholder'=>'Eg: https://www.google.com','class'=>'form-control', 'value'=>$menu_details['external_link'])); ?>
						<span id="error_external_link" class="error invalid-feedback"></span>
					</div>
					<div id="pages_list_field">
						<label>Select Page</label>
						<?php echo $this->Form->control('link_id', array('type'=>'select', 'options'=>$list_pages, 'empty'=>'---Select---', 'id'=>'link_id', 'label'=>false,'class'=>'form-control','value'=>$menu_details['link_id'])); ?>
						<span id="error_link_id" class="error invalid-feedback"></span>
					</div>
            	</div>
            	<div class="col-md-12 mb-3 "> 
            		<label>Menu Position </label>
            		<div class="col-md-9">
					<?php
						$options=array('top'=>'Top');
						$attributes=array('legend'=>false, 'id'=>'position','value'=>$menu_details['position'],'class'=>'m1');
						echo $this->Form->radio('position',$options,$attributes); ?>
						<span id="error_position" class="error invalid-feedback"></span>
					</div>
            	</div>
            	<div class="col-md-12 mb-3"> 
            		<label>Menu Order </label>
					<?php echo $this->Form->control('order_id', array('type'=>'text', 'id'=>'order_id', 'label'=>false, 'placeholder'=>'Enter Order No.','class'=>'form-control','value'=>$menu_details['order_id'])); ?>
					<span id="error_order" class="error invalid-feedback"></span>
            	</div>
            	<div class="col-md-6">&nbsp;</div>


               <div class="card-footer cardFooterBackground">
               	<?php echo $this->Form->submit('Update', array('name'=>'update','class'=>'form-control btn btn-success pl-4 pr-4 font-weight-bold','id'=>'update_btn','label'=>false)); ?>

					<?php echo $this->Html->link('Back', '/cms/all-menus',array('escapeTitle'=>false,'class'=>'btn btn-secondary font-weight-bold pl-4 pr-4 ml-2')); ?>
					
				</div>

            </div>
            <div class="col-md-6 form-row">
            	<div class="col-md-10 offset-1">
					<div id="current_menu_heading"></div>
					<div id="side_menu_list">
						<table class="table table-bordered table-info">
							<thead class="tablehead">
								<tr>
									<th>Menu Name</th>
									<th>Order No.</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($side_menu_list as $side_menu){ ?>
									<tr>
										<td><?php echo $side_menu['title'];?></td>
										<td><?php echo $side_menu['order_id'];?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					<div id="bottom_menu_list">
						<table class="table table-bordered table-info">
							<thead class="tablehead">
								<tr>
									<th>Menu Name</th>
									<th>Order No.</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($bottom_menu_list as $bottom_menu){ ?>
									<tr>
										<td><?php echo $bottom_menu['title'];?></td>
										<td><?php echo $bottom_menu['order_id'];?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
            </div>
           </div>
            


        <?php $this->Form->end() ?>  
    </div>
</div>
<?php echo $this->Html->script('cms/edit_menu');?>
