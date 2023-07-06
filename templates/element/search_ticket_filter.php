	<?php
	
	?>	
			<div class="row">
				<div class="col-md-2 pt-2">
					<div class="custom-radio custom-control">
						<input type="radio" id="rb_period" name="rb_period" value="period" checked>
						<label class="font-weight-bold">Ticket Period</label>						
					</div>
				</div>
				<div class="col-md-2">
					<?php echo $this->Form->control('r_period', array('type'=>'select', 'class'=>'form-control custom-select f-control search_f_control', 'id'=>'r_period', 'options'=>$returnPeriodArr, 'label'=>false)); ?>
				</div>


				<div class="col-md-2 pt-2">
					<div class="custom-radio custom-control">
						<input type="radio" id="rb_period_range" name="rb_period" value="range">
						<label class="font-weight-bold">Ticket Period Range</label>						
					</div>
				</div>
				<div class="col-md-2">
					<div class="input-group f-control search_f_control"><input placeholder="From Date" name="from_date" id="from_date" type="text" readonly class="form-control">
						<div class="input-group-append"><span class="input-group-text"><i class="fa fa-calendar"></i></span></div>
					</div>
				</div>				
				<div class="col-md-2">	
					<div class="input-group f-control search_f_control"><input placeholder="To Date" name="to_date" id="to_date" type="text" readonly class="form-control">
						<div class="input-group-append"><span class="input-group-text"><i class="fa fa-calendar"></i></span></div>
					</div>
				</div>	
													
			</div>
			<div class="row mt-2">
				<div class="col-md-2 pl-5 pt-2">	
						<label class="font-weight-bold">Ticket Type</label>	
				</div>

				<div class="col-md-2">
					<?php echo $this->Form->control('f_ticket_type', array('type'=>'select', 'class'=>'form-control custom-select f-control search_f_control', 'id'=>'f_ticket_type', 'options'=>$returnTickType, 'empty'=>'All','label'=>false)); ?>
				</div>
				<div class="col-md-5 pl-5 pt-2">
					<input type="submit" class="btn btn-dark fbtn" name="f_search" value="View Details">
					<input type="reset" class="btn btn-danger fbtn" name="reset" value="Clear">
					
				</div>
			</div>		
<?php 
echo $this->Html->script('support/search_ticket_filter.js?version='.$version);
?>		