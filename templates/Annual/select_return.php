<?php ?>

<div class="tab-content">
    <div class="tab-pane tabs-animation fade active show" id="tab-content-1" role="tabpanel">
        <div class="main-card mb-3 card">
            <div class="card-body">
            	<h5 class="card-title text-center mb-4">FILE ANNUAL RETURNS</h5>
				<div class="alert alert-info"> 
					<table>
						<tr>
							<td rowspan="3" class="v_a_base"><strong>Note :</strong></td>
							<td> 1) For returns upto Financial Year 2021-2022, Please go to https://oldreturns.ibm.gov.in</td>
						</tr>
						<tr>
							<td> 2) The following period selection shown below are only for pending returns</td>
						</tr>
						<tr>
							<td> 3) If any return period not available in following period selection that means it already filled </td>
						</tr>
					</table>
				</div>
				<?php if($_SESSION['mining_close_status'] !='C'){ ?>
				
					<?php echo $this->Form->create(null, array('id'=>'frmAnnualReturns')); ?>
						<div class="position-relative row form-group"><label for="exampleEmail" class="col-sm-1 offset-sm-3 col-form-label">Period</label>
							<div class="col-sm-4">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text" id="validationTooltipUsernamePrepend"><i class="fa fa-calendar-alt"></i></span>
									</div>
									<?php  echo $this->Form->select('year', $annualFileReturn, ['empty'=>'Select','class'=>'form-control', 'id'=>'annual_year']); ?>
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
					
				<?php } ?> 	
            </div>
        </div>
    </div>
</div>
