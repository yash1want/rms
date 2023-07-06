<div class="main-card card fcard mt-n3">
    <div class="card-body p-1 page-heading text-white">        
            <a href="<?php echo $this->getRequest()->getAttribute('webroot');?>mms/home" class="btn btn-light float-left"> Back <a>
            <h5 class="text-center font-weight-bold m-0">DDO Allocation</h5> 
    </div>
</div>
<div class="main-card mb-3 card">
    <div class="card-body"> 
        <div class="row pb-4">
         <div class="col-md-12">
         <?php echo $this->Form->create(null, array('type' => 'file' ,'id'=>'ddo_allocation')); ?>
                <table class="mb-0 table table-striped " id="ddoallocationtbl" >
                    <thead class="bg-dark text-white">
                      <tr>
                         <th class="p-1 border-right-1 border-white">RO Office</th>
                         <th class="p-1 border-right-1 border-white">DDO ID<span class="text-danger"> *</span>
                         </th class="p-1 border-right-1 border-white">
                         <th class="p-1 border-right-1 border-white">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($results as $row){ ?>
                      <tr>
                        <td id="<?php echo $row['id']; ?>"><?php echo $row['region_name']; ?></td>  
							<?php 
									  if (array_key_exists($row['id'],$allocatedddo)){
											$avaDdoId = $allocatedddo[$row['id']];
											$label = "Reallocate";
									  }else{
										  $avaDdoId = '';
										  $label = "Allocate";
									  }							?>
							
                        <td><?php echo $this->Form->control('ddo_name', array('type'=>'select', 'class'=>'form-control f-control ddo_id', 'options'=>$userlist, 'value'=>$avaDdoId, 'empty'=>'Select', 'label'=>false)); ?></td>
                        <td><?php echo $this->Form->control($label, array('type'=>'button', 'name'=>'allocate', 'class'=>'btn btn-success ddoallocate', 'label'=>false)); ?></td>
                      </tr>
                  <?php } ?>
                    </tbody>
                  </table>
                    <?php $this->Form->end() ?>  
            </div>
        </div>    
    </div>
</div>
<input type="hidden" id="allocationtype" value="allocate">
<?php //echo $this->Html->css('/admin/dataTables.checkboxes'); ?>
<?php echo $this->Html->script('admin/dataTables.checkboxes.min'); ?>
<?php echo $this->Html->script('admin/allocation'); ?>