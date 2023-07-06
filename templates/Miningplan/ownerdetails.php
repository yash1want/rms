<div class="main-card card fcard mt-n3">
    <div class="card-body p-1 page-heading text-white">        
            <h5 class="text-center font-weight-bold m-0">PRODUCTION SCHEDULE (MINING PLAN)</h5> 
    </div>
</div>
<div class="main-card mb-3 card">
    <div class="card-body">	
		<div class="form-row">
			<div class="col-md-4 mb-3">
				<label>Registration No. </label>                    
				<div class="form-control"><?php echo $data["registration_no"] ?></div>            
			</div>
			<div class="col-md-4 mb-3">
				<label>Owner </label> 
				<div class="form-control"><?php echo $data["owner_name"] ?></div>            
			</div>
			<div class="col-md-4 mb-3">
				<label>Mine Code </label> 
				<div class="form-control"><?php echo $data["mine_code"] ?></div>            
			</div>			
		</div>
		<div class="form-row">
			<div class="col-md-4 mb-3">
				<label>Mine Name </label>                    
				<div class="form-control"><?php echo $data["mine_name"] ?></div>            
			</div>
			<div class="col-md-4 mb-3">
				<label>Type of Document </label> 
				<?php
				if ($data['document_type'] == 1) {
				  ?>
				  <div class="form-control">Mining Plan</div>    
				<?php } else if ($data['document_type'] == 2) { ?>
				  <div class="form-control">Modification of Mining Plan</div>    
				<?php } else if ($data['document_type'] == 3) { ?>
				  <div class="form-control">Schemes of Mining</div>    
				<?php } else if ($data['document_type'] == 4) { ?>
				  <div class="form-control">Modification of Scheme of Mining</div>    
				<?php } ?>         
			</div>
			<div class="col-md-4 mb-3">
				<label>Date of Approval </label> 
				<div class="form-control"><?php echo $data["appr_date"] ?></div>            
			</div>			
		</div>
		<div class="form-row">
			<div class="col-md-4 mb-3">
				<label>Effective date of approval </label>                    
				<div class="form-control"><?php echo $data["EFF_APPR_DATE"] ?></div>            
			</div>			
			<div class="col-md-4 mb-3">
				<label>Status </label> 
				<?php
					if ($data['document_type'] == 1) {
				?>
				  <div class="form-control">Approved</div>    
				<?php } else if ($data['document_type'] == 0) { ?>
				  <div class="form-control">Pending</div>    
				<?php } ?> 
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>
		<?php if($dynamicData['mineral_name'] !='') {?>
			<h5 class="text-center font-weight-bold m-0">Field Annual Production(<?= $dynamicData['mineral_name']?>)</h5> 
		<?php } else {?>
			<h5 class="text-center font-weight-bold m-0">Field Annual Production</h5>
		<?php }?>
		<div class="clearfix">&nbsp;</div>
		<table class="table table-bordered">
			<tr>
				<th>SN</th>
				<th>Financial Year:</th>
				<th>Unit of Measurement: Tonne</th>
			</tr>
			<tr>
				<td>1</td>
				<td id="year_1"></td>
				<td><?= $dynamicData['year1']?></td>
			<tr>
				<td>2</td>
				<td id="year_2"></td>
				<td><?= $dynamicData['year2']?></td>
			</tr>
			<tr>
				<td>3</td>
				<td id="year_3"></td>
				<td><?= $dynamicData['year3']?></td>
			</tr>
			<tr>
				<td>4</td>
				<td id="year_4"></td>
				<td><?= $dynamicData['year4']?></td>
			</tr>
			<tr>
				<td>5</td>
				<td id="year_5"></td>
				<td><?= $dynamicData['year5']?></td>
			</tr>
		</table>
		<hr>
		<div class="form-row">
			<input type="hidden" value="<?= $dynamicData['first_submit_data'] ?>" id="first_submit_data">
			<?php  echo $this->Html->link('Back', '/Miningplan/ownerlist',array('escapeTitle'=>false,'class'=>'btn btn-secondary font-weight-bold pl-4 pr-4 ml-2'));   ?>           
		</div> 
    </div>    
</div>
<?= $this->Html->Script('miningplan/ownerdetails');?>
