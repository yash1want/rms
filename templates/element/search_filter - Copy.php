	<?php ?>	
	<style>
		.f-control { height: calc(1.30rem + 2px); }	
		.fcard { background-color: #36b9cc !important; } 
		.flabel { 	color: white;
					font-weight: 900;
					font-size: 1rem;
			   }
		 .fbtn { padding-top: 2px; padding-bottom: 2px; font-weight: 600;}		
	</style>
		<div class="row filter mb-1">
			<div class="col-md-2 col-sm-2 pr-2">
				<label class="w-3 m-0 flabel">Zone</label>
				<?php echo $this->Form->control('f_zone', array('type'=>'select', 'class'=>'form-control f-control', 'id'=>'f_zone', 'options'=>'', 'label'=>false )); ?>
			</div>
			<div class="col-md-2 col-sm-2 pl-0 pr-2">
				<label class="w-2 m-0 flabel">Region</label>
				<?php echo $this->Form->control('f_region', array('type'=>'select', 'class'=>'form-control f-control', 'id'=>'f_region', 'options'=>'', 'label'=>false )); ?>
			</div>
			<div class="col-md-2 col-sm-2 pl-0 pr-2">
				<label class="w-2 m-0 flabel">State</label>
				<?php echo $this->Form->control('f_state', array('type'=>'select', 'class'=>'form-control f-control', 'id'=>'f_state', 'options'=>'', 'label'=>false)); ?>
			</div>
			<div class="col-md-2 col-sm-2 pl-0 pr-2">
				<label class="w-2 m-0 flabel">District</label>
				<?php echo $this->Form->control('f_district', array('type'=>'select', 'class'=>'form-control f-control', 'id'=>'f_district', 'options'=>'', 'label'=>false)); ?>
			</div>
			<div class="col-md-2 col-sm-2 pl-0 pr-2">
				<label class="w-2 m-0 flabel">Year</label>
				<?php echo $this->Form->control('f_year', array('type'=>'select', 'class'=>'form-control f-control', 'id'=>'f_year', 'options'=>'', 'label'=>false)); ?>
			</div>
			<div class="col-md-2 col-sm-2 pl-0 pr-2">
				<label class="w-2 m-0 flabel">Month</label>
				<?php echo $this->Form->control('f_month', array('type'=>'month', 'class'=>'form-control f-control', 'id'=>'f_month', 'options'=>'', 'label'=>false)); ?>
			</div>
		</div>
		<div class="row filter">
			<div class="col-md-2 col-sm-2 pr-2">
				<label class="w-2 m-0 flabel">Form</label>
				<?php echo $this->Form->control('f_form', array('type'=>'select', 'class'=>'form-control f-control', 'id'=>'f_form', 'options'=>'', 'label'=>false)); ?>
			</div>
			<div class="col-md-2 col-sm-2 pl-0">
				<label class="w-2 m-0 flabel">Mine Code</label>
				<?php echo $this->Form->control('f_mine_code', array('type'=>'text', 'class'=>'form-control f-control', 'id'=>'f_mine_code', 'label'=>false)); ?>
			</div>
			<div class="col-md-2 col-sm-2 pt-4 pl-0">					
				<input type="submit" class="btn btn-dark fbtn" name="f_search" value="Search">
				<input type="reset" class="btn btn-danger fbtn" name="reset" value="Reset Filter">
			</div>				
		</div>