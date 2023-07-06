
<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
        <div class="modal-header">			
            <h6 class="modal-title col-10" id="reportModalLabel">Now mineral master is being handled through Returns module<br>
Below is a list of minerals which are present in the Registration module but not present in Returns Module.
Please add these minerals first for syncronizing the data between Registration mineral master and Returns mineral master</h6>
           <a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>
        </div>
        <div class="modal-body">
            
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="form-horizontal">
                                <div class="card-body" id="avb">                                   
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-bordered compact" id="tableReportModal">
                                            <thead class="tableHeadModal">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Mineral Name</th>
                                                    <th>Form Type</th>
                                                    <th>Input Unit</th>
													<th>Output Unit</th>                                                     
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tableBodyModal">
												<?php $i = 1; foreach($minerals_not_exist_in_returns as $each){ ?>
												<tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $each['MINERAL_NAME']; ?></td>
													<?php if($each['FORM_TYPE'] != ''){ ?>
														<td><?php if(in_array($each['FORM_TYPE'],array(1,2,3,4,8))){ 
																			echo 'F1'; 
																	  }elseif($each['FORM_TYPE'] == 5){
																		  echo 'F2'; 
																	  }elseif($each['FORM_TYPE'] == 7){
																		  echo 'F3';
																	  }else{
																		  echo '';
																	  }
															?></td>
													<?php }else{ ?>	
														<td><?= $this->Form->control('form_type', [
															'type' => 'select',
															'required' => true,
															'options' => array('1'=>'F1','5'=>'F2','7'=>'F3'),
															'empty' => 'Please select',
															'class' => 'form-control form_type',
															'label' => false,
														]); ?></td>
													<?php } ?>
													
													<?php if($each['INPUT_UNIT'] != ''){ ?>
														 <td><?php echo $each['INPUT_UNIT']; ?></td>
													<?php }else{ ?>	
														<td><?= $this->Form->control('input_unit', [
															'type' => 'select',
															'required' => true,
															'options' => $units,
															'empty' => 'Please select',
															'class' => 'form-control input_unit',
															'label' => false,
														]); ?></td>
													<?php } ?>
													
													
													<?php if($each['OUTPUT_UNIT'] != ''){ ?>
														<td><?php echo $each['OUTPUT_UNIT']; ?></td> 
													<?php }else{ ?>	
														<td><?= $this->Form->control('output_unit', [
																'type' => 'select',
																'required' => true,
																'options' => $units,
																'empty' => 'Please select',
																'class' => 'form-control output_unit',
																'label' => false,
															]); ?></td>
													<?php } ?>
													
                                                   
													                                                    
                                                    <th><input type="button" class="btn btn-sm btn-success addmineral" id ="<?php echo $each['MINERAL_CODE']?> " value="Add"></th>
                                                </tr>
												<?php $i++; } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
        </div>
    </div>
</div>
<input type="button" id="report_model_id" data-toggle="modal" data-target="#reportModal" data-keyboard="false" data-backdrop="static" hidden>

<?php echo $this->Html->script('masters/add_minerals.js?version='.$version); ?>
