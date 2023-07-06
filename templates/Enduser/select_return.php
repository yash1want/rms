<?php ?>

<div class="tab-content">
    <div class="tab-pane tabs-animation fade active show" id="tab-content-1" role="tabpanel">
        <div class="main-card mb-3 card">
            <div class="card-body">
            	<h5 class="card-title text-center mb-4">FILE MONTHLY RETURNS</h5>
                <?php echo $this->Form->create(null, array('id'=>'frmSelectReturns')); ?>
                    <div class="position-relative row form-group"><label for="exampleEmail" class="col-sm-2 col-form-label">Period</label>
                        <div class="col-sm-4">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="validationTooltipUsernamePrepend"><i class="fa fa-calendar-alt"></i></span>
								</div>
								<?php 
								echo $this->Form->select('year', $file_return_year, ['empty'=>'- Select Year -','class'=>'form-control', 'id'=>'year']);
								?>
							</div>
                            <div class="err_year err_select_return"></div>
						</div>
                        <div class="col-sm-4">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="validationTooltipUsernamePrepend"><i class="fa fa-calendar-alt"></i></span>
								</div>
								<?php 
								echo $this->Form->select('month', array(), ['empty'=>'- Select Month -','class'=>'form-control', 'id'=>'month']);
								?>
							</div>
                            <div class="err_month err_select_return"></div>
						</div>
                    </div>

                    <?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'current_month', 'label'=>false, 'value'=>date('n')]); ?>
                    <?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'current_year', 'label'=>false, 'value'=>date('Y')]); ?>
                    <?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'applicant_id', 'label'=>false, 'value'=>$applicant_id]); ?>
                    <?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'controller_type', 'label'=>false, 'value'=>'enduser']); ?>

                    <div class="position-relative row form-group"></div>
                    <div class="position-relative row form-group"></div>
                    <div class="position-relative row form-check">
                        <div class="col-sm-10 offset-sm-2">
                            <?php echo $this->Html->link('Back', ['controller'=>'auth', 'action'=>'home'], ['class'=>'btn btn-primary']); ?>
                            <?php echo $this->Form->button('Submit', ['type'=>'submit', 'class'=>'btn btn-success']); ?>
                        </div>
                    </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
