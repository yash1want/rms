
<?php echo $this->Html->css('authhome'); ?> 
<?php echo $this->Html->css('chart'); ?> 
<?php echo $this->Html->css('chart_background'); ?> 

<?php if (!empty($records)) { ?>
    
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><?php echo $this->Html->link('Back', array('controller' => 'support-mod', 'action' => 'all-status-filter?title=report-filter'), array('class' => 'add_btn btn btn-secondary backToReport')); ?>
            </div>
        </div>
    </div>
    <!-- Ticket Status -->
    <input type="hidden" name="closed_count" id="closed_count" value="<?php echo isset($closed_count) ? $closed_count : 0; ?>">
    <input type="hidden" name="inprocess_count" id="inprocess_count" value="<?php echo isset($inprocess_count) ? $inprocess_count : 0 ; ?>">
    <input type="hidden" name="all_count" id="all_count" value="<?php echo isset($allcount) ? $allcount : 0 ; ?>">
    <input type="hidden" name="pending_count" id="pending_count" value="<?php echo isset($pending_count) ? $pending_count : 0 ; ?>">

    <!-- Ticket Isuue Type -->
    <input type="hidden" name="operational_count" id="operational_count" value="<?php echo isset($operational_count) ? $operational_count : 0; ?>">
    <input type="hidden" name="db_related_count" id="db_related_count" value="<?php echo isset($db_related_count) ? $db_related_count : 0; ?>">
    <input type="hidden" name="change_request_count" id="change_request_count" value="<?php echo isset($change_request_count) ? $change_request_count : 0; ?>">
    
    <input type="hidden" name="external_count" id="external_count" value="<?php echo isset($external_count) ? $external_count : 0; ?>">
    <input type="hidden" name="training_count" id="training_count" value="<?php echo isset($training_count) ? $training_count : 0; ?>">
    <input type="hidden" name="other_mod_count" id="other_mod_count" value="<?php echo isset($other_mod_count) ? $other_mod_count : 0; ?>">

     <input type="hidden" name="prog_related_count" id="prog_related_count" value="<?php echo isset($prog_related_count) ? $prog_related_count : 0; ?>">

    <!-- Ticket Module -->
    <input type="hidden" name="rms_count" id="rms_count" value="<?php echo isset($rms_count) ? $rms_count : 0; ?>">
    <input type="hidden" name="mpas_count" id="mpas_count" value="<?php echo isset($mpas_count) ? $mpas_count : 0; ?>">
    
    <!-- <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            
            <//?php 
            if($rowCount <= 15000) {
                echo $this->Html->link('Export to Excel', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/reports/'.$lfilenm.'.xlsx',['download'=>$lfilenm,'class'=>'btnlink']);           
            }
            ?>
            </div>
        </div>
    </div>  -->

    <?php echo $lprint;?>



<?php } ?>
<!-- <input type="hidden" id="rowCount" value="<?php echo $rowCount; ?>"> -->
<?php echo $this->Html->script('support/chart');?>
<?php echo $this->Html->script('support/chart_script');?>
<?php echo $this->Html->script('support/collapse');?>
