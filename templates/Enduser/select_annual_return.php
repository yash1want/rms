<?php ?>

<div class="tab-content">
    <div class="tab-pane tabs-animation fade active show" id="tab-content-1" role="tabpanel">
        <div class="main-card mb-3 card">
            <div class="card-body">
            	<h5 class="card-title text-center mb-4">FILE ANNUAL RETURNS</h5>
                <?php echo $this->Form->create(null, array('name'=>'frmAnnualReturns', 'id'=>'frmAnnualReturns')); ?>
                    <div class="position-relative row form-group"><label for="exampleEmail" class="col-sm-1 offset-sm-3 col-form-label">Period</label>
                        <div class="col-sm-4">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="validationTooltipUsernamePrepend"><i class="fa fa-calendar-alt"></i></span>
								</div>
								<?php echo $this->Form->select('year', $annualFileReturn, ['empty'=>'Select','class'=>'form-control', 'id'=>'annual_year']); ?>
							</div>
                            <div class="err_annual_year err_select_return"></div>
						</div>
                    </div>

                    <?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'current_year', 'value'=>date('Y')]); ?>

                    <div class="position-relative row form-group"></div>
                    <div class="position-relative row form-group"></div>
                    <div class="position-relative row form-check">
                        <div class="col-sm-8 offset-sm-4">
                            <?php echo $this->Html->link('Back', ['controller'=>'auth', 'action'=>'home'], ['class'=>'btn btn-primary']); ?>
                            <?php echo $this->Form->button('Submit', ['type'=>'submit', 'class'=>'btn btn-success', 'id'=>'submit']); ?>
                        </div>
                    </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
