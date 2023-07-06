<?php echo $this->Html->css('miningplan/miningplan') ?>
<?php echo $this->Form->create(null, array('type' => 'file' ,'id'=>'mining_plan')); ?>
<div class="main-card card fcard mt-n3">
    <div class="card-body p-1 page-heading text-white">        
            <h5 class="text-center font-weight-bold m-0"><?php echo ucfirst('PRODUCTION SCHEDULE (MINING PLAN)'); ?></h5> 
    </div>
</div>
<input type="hidden" id="ro_dashboard" value="<?php echo $ro_dashboard; ?>">
<input type="hidden" id="ro_selected_mineral" value="<?php echo $ro_selected_mineral; ?>">
<input type="hidden" id="plan_id" value="<?php echo $plan_data['id']; ?>">
<div class="main-card mb-3 card">
    <div class="card-body">
        <div class="form-row">
            <div class="col-md-7 mb-3 border-1">
                <div class="form-row heading">Details</div>
                <table class="table table-sm table-bordered">
                    <tr>
                        <td><label>Registration No.</label></td>
                        <td><?php echo $mine_data['registration_no']; ?></td>     
                    </tr>
                    <tr>
                        <td><label>Owner</label></td>
                        <td><?php echo $mine_data['owner_name']; ?></td>     
                    </tr>
                    <tr>
                        <td><label>Mine Code</label></td>
                        <td id="mine_code_lb"><?php echo $mine_data['mine_code']; ?></td>     
                    </tr>
                    <tr>
                        <td><label>Mine Name</label></td>
                        <td><?php echo $mine_data['mine_name']; ?></td>     
                    </tr>                    
                    <tr>
                        <td><label>Type of Document</label></td>
                        <td>
                            <?php echo $this->Form->control('document_type', array('type' => 'select', 'options'=>$document_types,'class'=>'form-control', 'empty'=>'Select', 'id'=>'document_type','required','label'=>false)); ?>
                            <div id="error_document_type" class="text-danger"></div>
                        </td>     
                    </tr>
                    <tr>
                        <td><label>Date of Approval of Above Document</label></td>
                        <td>
                            <?php echo $this->Form->control('date_approval', array('type' => 'text', 'class'=>'form-control','id'=>'date_approval','required','label'=>false)); ?>
                            <div id="error_date_approval" class="text-danger"></div>
                        </td>     
                    </tr>
                    <tr>
                        <td><label>Date of commencement of mining operation as per Above Document</label></td>
                        <td>
                            <?php echo $this->Form->control('date_conmmencement', array('type' => 'text', 'class'=>'form-control','id'=>'date_conmmencement','required','label'=>false)); ?>
                            <div id="error_date_conmmencement" class="text-danger"></div>
                        </td>     
                    </tr>
                    <tr>
                        <td><label>Date of execution of mining lease</label></td>
                        <td>
                            <?php echo $this->Form->control('date_execution', array('type' => 'text', 'class'=>'form-control','id'=>'date_execution','required','label'=>false)); ?>
                            <div id="error_date_execution" class="text-danger"></div>
                        </td>     
                    </tr>
                </table>
            </div>  
            
            <div class="col-md-5 mb-3">
                <div class="form-row heading">File Annual Production</div>
                <div class="form-row ">
                    <div class="col-md-5 mb-3  mt-4 text-right"><label>Mineral Name :</label></div>
                    <div class="col-md-5 mb-3 mt-3">
                            <?php echo $this->Form->control('mineral_name', array('type' => 'select', 'options'=>$minerals,'class'=>'form-control','empty'=>'Select','id'=>'mineral_name','required','label'=>false)); ?></div>
                            <div id="error_mineral_name" class="text-danger rem13"></div>
                    </div>
                    <table class="table table-sm table-bordered">
                    <tr>
                        <td><label>Sr.No</label></td>     
                        <td><label>Financial Year:</label></td>
                        <td><label>Unit of Measurement: Tonne</label></td>     
                        
                    </tr>
                    <tr>
                        <td><label>1</label></td>     
                        <td><label><?php echo $this->Form->control('start_year', array('type' => 'select', 'class'=>'form-control','id'=>'start_year','required','label'=>false)); ?></label><div id="reset_year_btn" class="text-primary font-italic btn p-0" data-toggle="tooltip" data-placement="right" data-html="true" title="This will reset the <b>Financial Year</b> selection!">Reset year</div></td>
                        <td>
                            <?php echo $this->Form->control('year_1', array('type' => 'text', 'class'=>'form-control','id'=>'year_1','required','label'=>false)); ?>
                            <div id="error_year_1" class="text-danger"></div>
                        </td>     
                    </tr>
                    <tr>
                        <td><label>2</label></td>     
                        <td><label id="year_2_label">2019 - 2020</label></td>
                        <td>
                            <?php echo $this->Form->control('year_2', array('type' => 'text', 'class'=>'form-control','id'=>'year_2','required','label'=>false)); ?>
                            <div id="error_year_2" class="text-danger"></div>
                        </td>     
                    </tr>
                    <tr>
                        <td><label>3</label></td>     
                        <td><label id="year_3_label">2019 - 2020</label></td>
                        <td>
                            <?php echo $this->Form->control('year_3', array('type' => 'text', 'class'=>'form-control','id'=>'year_3','required','label'=>false)); ?>
                            <div id="error_year_3" class="text-danger"></div>
                        </td>     
                    </tr>
                    <tr>
                        <td><label>4</label></td>     
                        <td><label id="year_4_label">2019 - 2020</label></td>
                        <td>
                            <?php echo $this->Form->control('year_4', array('type' => 'text', 'class'=>'form-control','id'=>'year_4','required','label'=>false)); ?>
                            <div id="error_year_4" class="text-danger"></div>
                        </td>     
                    </tr>
                    <tr>
                        <td><label>5</label></td>     
                        <td><label id="year_5_label">2019 - 2020</label></td>
                        <td>
                            <?php echo $this->Form->control('year_5', array('type' => 'text', 'class'=>'form-control','id'=>'year_5','required','label'=>false)); ?>
                            <div id="error_year_5" class="text-danger"></div>
                        </td>     
                    </tr>
                </table>    
            </div> 

            <div class="col-md-12 mb-3" id="approved_list">
                <div class="form-row heading">Approved Production Details</div>
                <table class="table table-sm table-bordered" id="approved_result">
                    <tr>
                        <td><label>Sr.No</label></td>     
                        <td><label>Financial Year:</label></td>
                        <td><label>Unit of Measurement: Tonne</label></td>
                    </tr>                    
                </table>    
            </div>

            <div class="col-md-12 mb-3 reason_box">
                <div class="form-row heading">Reason</div>
                <?php echo $this->Form->control('reason_text', array('type' => 'textarea', 'class'=>'form-control','id'=>'reason_text','label'=>false)); ?>  
            </div>

            <hr>    
            <div class="form-row">

                <button type="reset" class="btn btn-info mr-2 font-weight-bold reset">Reset</button>   

                <?php echo $this->Form->submit('Save', array('name'=>'save','class'=>'form-control btn btn-success pl-4 pr-4 font-weight-bold','id'=>'btnsave','label'=>false)); ?>
                <?php echo $this->Form->submit('Final Submit', array('name'=>'final_submit','class'=>'form-control btn btn-success pl-4 pr-4 mr-2 ml-2 font-weight-bold','id'=>'final_submit','label'=>false)); ?>
                <?php echo $this->Form->submit('Accept', array('name'=>'accepted','class'=>'form-control btn btn-success pl-4 pr-4 mr-4 ml-4 font-weight-bold','id'=>'accepted','label'=>false)); ?>

                <?php if($_SESSION['loginusertype']=='mmsuser'){
                    echo $this->Html->link('Back', '/miningplan/mining-plan-list',array('escapeTitle'=>false,'class'=>'btn btn-secondary font-weight-bold pl-4 pr-4 ml-5'));
                    }   else { echo $this->Html->link('Back', '/auth/auth-home',array('escapeTitle'=>false,'class'=>'btn btn-secondary font-weight-bold pl-4 pr-4 ml-5')); } ?>

            </div>             
        </div>
    </div>
</div>  
 
<?php $this->Form->end() ?>
<?php echo $this->Form->control('reset_start_year', array('type'=>'hidden','id'=>'reset_start_year')); ?>
<?php echo $this->Form->control('mp_current_year', array('type'=>'hidden','id'=>'mp_current_year','value'=>date('Y'))); ?>
<?php echo $this->Form->control('mp_current_month', array('type'=>'hidden','id'=>'mp_current_month','value'=>date('m'))); ?>
<?php echo $this->Html->script('miningplan/miningplan.js?version='.$version) ?>