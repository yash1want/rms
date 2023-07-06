<?php //echo phpinfo(); ?>
<?php if (!empty($records)) { ?>
	
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><?php echo $this->Html->link('Back', array('controller' => 'reports', 'action' => 'report-list'), array('class' => 'add_btn btn btn-secondary backToReport')); ?>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">

			<?php
			if($rowCount <= 15000) {
				echo $this->Html->link('Export to Excel', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/reports/'.$lfilenm,['download'=>$lfilenm,'class'=>'btnlink']);
			}
			?>
            </div>
        </div>
    </div>

    <?php echo $lprint;?>
<?php } ?>