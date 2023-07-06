	<?php ?>	
			<div class="row">
				<div class="col-md-2 pt-2">
					<div class="custom-radio custom-control">
						<input type="radio" id="rb_period" name="rb_period" value="period" checked>
						<label class="font-weight-bold">Returns Period</label>						
					</div>
				</div>
				<div class="col-md-2">
					<?php echo $this->Form->control('r_period', array('type'=>'select', 'class'=>'form-control custom-select f-control search_f_control', 'id'=>'r_period', 'options'=>$returnPeriodArr, 'label'=>false)); ?>
				</div>
				<div class="col-md-3 pt-2">
					<div class="custom-radio custom-control">
						<input type="radio" id="rb_period_range" name="rb_period" value="range">
						<label class="font-weight-bold">Returns Period Range</label>						
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
					<?php if($_SESSION['sess_form_type'] == 'f' || $_SESSION['sess_form_type'] == 'g'){ ?>	
						<label class="font-weight-bold">Mine Code</label>	
					<?php }elseif($_SESSION['sess_form_type'] == 'm' || $_SESSION['sess_form_type'] == 'l'){ ?>
						<label class="font-weight-bold">Applicant Id</label>	
					<?php } ?>						
				</div>
				<div class="col-md-2">					
					<?php echo $this->Form->control('f_mine_code', array('type'=>'text', 'class'=>'form-control f-control search_f_control', 'id'=>'f_mine_code', 'label'=>false)); ?>
				</div>	
				<div class="col-md-5 pl-5 pt-2">
					<input type="submit" class="btn btn-dark fbtn" name="f_search" value="View Details">
					<input type="reset" class="btn btn-danger fbtn" name="reset" value="Clear">
					<!-- <?php /*if($dashboard == 'mmsuser'){  ?>
						<input type="button" data-toggle="collapse" href="#collapseF" class="btn btn-light fbtn float-right mt-1" name="reset" value="Advanced Search">
					<?php } */ ?>	 -->
				</div>
			</div>
			<?php if($dashboard == 'mmsuser'){  ?>
			<div class="collapse" id="collapseF">
				<div class="row pt-4">
					<?php if(!in_array($userrole,array('5','6','10'))){ ?>
						<div class="col-md-1 pt-2">
							<label class="font-weight-bold">Zone</label>
						</div>
						<div class="col-md-2">
							<?php echo $this->Form->control('f_zone', array('type'=>'select', 'class'=>'form-control f-control search_f_control', 'id'=>'f_zone', 'options'=>$zoneArr, 'empty'=>'Select', 'label'=>false )); ?>
						</div>
					<?php } ?>
					<?php if(!in_array($userrole,array('6','10'))){ ?>
						<div class="col-md-1 pt-2">
							<label class="font-weight-bold" >Region</label>
						</div>
						<div class="col-md-2">
							<?php echo $this->Form->control('f_region', array('type'=>'select', 'class'=>'form-control f-control search_f_control', 'id'=>'f_region', 'options'=>$regionsList, 'empty'=>'Select', 'label'=>false )); ?>
						</div>
					<?php } ?>
					<?php if(!in_array($userrole,array('6','10'))){ ?>
					<div class="col-md-1 pt-2">
						<label class="font-weight-bold">State</label>
					</div>
					<div class="col-md-2">
						<?php echo $this->Form->control('f_state', array('type'=>'select', 'class'=>'form-control f-control search_f_control', 'id'=>'f_state', 'options'=>$statesList,  'empty'=>'Select', 'label'=>false)); ?>
					</div>
					<?php } ?>
					<div class="col-md-1 pt-2">
						<label class="font-weight-bold">District</label>
					</div>
					<div class="col-md-2">
						<?php echo $this->Form->control('f_district', array('type'=>'select', 'class'=>'form-control f-control search_f_control', 'id'=>'f_district', 'options'=>$districtsList, 'empty'=>'Select', 'label'=>false)); ?>
					</div>
					<?php if(in_array($userrole,array('5','6','10'))){ ?>
						<div class="col-md-1 pt-2">
							<label class="font-weight-bold">Form</label>
						</div>
						<div class="col-md-2">
							<?php echo $this->Form->control('f_form', array('type'=>'select', 'class'=>'form-control f-control search_f_control', 'id'=>'f_form', 'options'=>$formsArr, 'empty'=>'Select', 'label'=>false)); ?>
						</div>
					<?php } ?>
				</div>
				<div class="row">
					<?php if(!in_array($userrole,array('5','6','10'))){ ?>
						<div class="col-md-1 pt-2">
							<label class="font-weight-bold">Form</label>
						</div>
						<div class="col-md-2">
							<?php echo $this->Form->control('f_form', array('type'=>'select', 'class'=>'form-control f-control search_f_control', 'id'=>'f_form', 'options'=>$formsArr, 'empty'=>'Select', 'label'=>false)); ?>
						</div>
					<?php } ?>
					<!--<div class="col-md-1 pr-0 pt-2">
						<label class="font-weight-bold">Mine Code</label>
					</div>
					<div class="col-md-2">
						<?php echo $this->Form->control('f_mine_code', array('type'=>'text', 'class'=>'form-control f-control search_f_control', 'id'=>'f_mine_code', 'label'=>false)); ?>
					</div>
					<div class="col-md-1 pt-2">
						<label class="font-weight-bold">Year</label>
					</div>
					<div class="col-md-2">
						<?php echo $this->Form->control('f_year', array('type'=>'select', 'class'=>'form-control f-control search_f_control', 'id'=>'f_year', 'options'=>$yearsArr, 'empty'=>'Select','label'=>false)); ?>
					</div>
					<div class="col-md-1 pt-2">
						<label class="font-weight-bold">Month</label>
					</div>
					<div class="col-md-2">
						<?php echo $this->Form->control('f_month', array('type'=>'select', 'class'=>'form-control f-control search_f_control', 'id'=>'f_month', 'options'=>''/*$monthsArr*/, 'empty'=>'Select', 'label'=>false)); ?>
					</div>	-->				
				</div>
				<div class="row">
					
				</div>
				<div class="row">
					
				</div>
			</div>
			<?php } ?>
			<!--<div class="row">
				<div class="col-md-2">
					<label class="custom-control-label font-weight-bold" for="exampleCustomRadio">Returns Period</label>
				</div>
				<div class="col-md-3"></div>
				<div class="col-md-2">
					<label class="custom-control-label font-weight-bold" for="exampleCustomRadio">Returns Period</label>
				</div>
				<div class="col-md-3"></div>
			</div>-->
			
<?php echo $this->Html->script('mms/search_filter.js?version='.$version); ?>		