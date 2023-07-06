
<div class="main-card card fcard mb-1 mt-n3">
	<div class="card-body pt-2 pb-3">
	
		<?php echo $this->Form->create(null , array('type'=>'file', 'enctype'=>'multipart/form-data','class'=>'form-group')); ?>
		
		<h5 class="text-center font-weight-bold text-alternate pb-1">
			<?php
				// Added $returnList to all heading and checked heading coming proper for Old & New returns by Shalini D on 18/02/2022
				$returnList = "";
				if(isset($_SESSION['oldreturns'])){
					$returnList ="Old";	
				}
				$return_type = 'Annual';
				
				if($_SESSION['sess_return_type']=='monthly'){
					$return_type = 'Monthly';
				}
				if($_SESSION['sess_status'] == 's'){
					
					echo $return_type.' Received '.$returnList.' Returns List';
					
				}elseif($_SESSION['sess_status'] == 'p'){
					
					echo $return_type.' Pending '.$returnList.' Returns List';
					
				}elseif($_SESSION['sess_status'] == 'r'){
					
					echo $return_type.' Referred Back '.$returnList.' Returns List';
					
				}elseif($_SESSION['sess_status'] == 'a'){
					
					echo $return_type.' Accepted '.$returnList.' Returns List';
					
				}
			?>
		
		</h5>
		
		<?php echo $this->element('search_filter'); ?>
		
		<?php echo $this->Form->end(); ?>
	</div>
</div>
<div class="main-card mb-3 card">
	<div class="card-body">
		<h5 class="card-title">
			<?php if($returnsData == 'filterDataTampared'){ ?><span class="text-danger">Invalid Search</span><?php } ?>
		</h5>
		<div class="table-responsive">
		
		<?php if($_SESSION['sess_form_type'] == 'f' || $_SESSION['sess_form_type'] == 'g'){ ?>
		
			<table class="mb-0 table table-striped return_list_table" id="list">
				<thead class="bg-dark text-white">
				<tr>
					<th class="p-1 border-right-1 border-white">#</th>
					<!--<th class="p-1 border-right-1 border-white"></th>-->
					<th class="p-1 border-right-1 border-white">REG. NO / MINE CODE</th>
					<th class="p-1 border-right-1 border-white">NAME OF THE OWNER</th>
					<th class="p-1 border-right-1 border-white">FORM NO.</th>
					<th class="p-1 border-right-1 border-white"><?php echo ($_SESSION['sess_form_type'] == 'f') ? 'MONTH/YEAR' : 'YEAR'; ?></th>
					<th class="p-1 border-right-1 border-white">DATE OF SUBMISSION</th>
					<th class="p-1 border-right-1 border-white">STATUS</th>
					<th class="p-1 border-right-1 border-white">STATUS DATE</th>
					<th class="p-1 border-right-1 border-white">ACTION</th>
				</tr>
				</thead>
				<tbody>
				<?php if($returnsData != 'filterDataTampared'){
					if(isset($_GET['debug'])) { echo '<pre>'; print_r($returnsData); exit; }
						$i=1;
						foreach($returnsData as $row) { 
						
							$submissionDate=date_create($row['DateOfFinalSubmission']);
							if($row['StatusDate']=='0000-00-00'){
								$statusDate = date_format(date_create($row['updatedAt']),"d-m-Y");
							}else{
								$statusDate= date_format(date_create($row['StatusDate']),"d-m-Y");
							}
							
							/**
							* Added below check for rendering old returns (returns before MCDR 2017 was get in effect)
							* Render old returns in PDF format only.
							* @version 29th Nov 2021
							* @author Aniket Ganvir
							*/
						   $monthYear = $row['MonthYear'];
						   $monYrArr = explode('/', $monthYear);
						   $returnDt = trim($monYrArr[1]).'-'.trim($monYrArr[0]).'-01';
						   $returnDt = date('Y-m-d', strtotime($returnDt));
						   $oldReturn = ($returnDt < $cutoffDate) ? 1 : 0;

				?>
					<tr>
						<th scope="row"><?php echo $i; ?></th>
						<!--<td><?php //echo $row['RegistrationNumber']; ?></td>-->
						<td><?php echo $row['applicantId']; ?></td>
						<td><?php echo $row['NameOfTheOwner']; ?></td>
						<td><?php if($row['ReturnType'] =='MONTHLY'){ echo  'F'.$row['formType']; }else{ echo  'G'.$row['formType']; } ?></td>
						<td><?php echo $monYrLabel = ($_SESSION['sess_form_type'] == 'f') ? $row['MonthYear'] : ((trim((int)$monYrArr[1])) . "-" .trim((int)$monYrArr[1] + 1)); ?></td>
						<td><?php echo date_format($submissionDate,"d-m-Y"); ?></td>
						<td><?php echo $row['StatusReferred']; ?></td>
						<td><?php echo $statusDate; ?></td>
						<td>
							<div class="btn-group">
							<?php if(empty($returnList)){

								if ($oldReturn == 0) {
									echo $this->Html->link('<i class="fa  fa fa-eye pr-1 pl-1 spinner_btn_nxt"></i>', '/mms/monthly-returns/'.$row["MineCode"].'/'.$row['MonthYear'].'/'.$row['ReturnType'].'/view', array('class'=>'btn-shadow p-1 spinner_btn_nxt', 'escapeTitle'=>false, 'title'=>'View'));
									
									if (isset($row['pdfPath']) && !empty($row['pdfPath'])){
										echo '<a href="'.$this->Url->build('/'.$row['pdfPath']).'" class="btn-shadow pt-1" title="View PDF" target="_blank"><i class="fa fa-file-pdf text-danger"></i></a>';

										// Added pdf version view button on 25-08-2022 by Aniket
										echo '<a href="#" class="btn-shadow pt-1 pl-2 view_all_pdf_version_btn" title="View all PDF version" data-toggle="modal" data-target="#pdf_version_modal" appid="'.$row['MineCode'].'" rtype="'.$row['ReturnType'].'" rdate="'.$row['ReturnDate'].'" rmnyr="'.$monYrLabel.'" rform="authuser"><i class="fa fa-file-pdf text-primary"></i></a>';
									}
									
								} else {
									echo $this->Html->link('<i class="fa  fa fa-eye pr-1 pl-1"></i>', '/mms/monthly-returns-pdf/'.$row["MineCode"].'/'.$row['MonthYear'].'/'.$row['ReturnType'].'/view', array('class'=>'btn-shadow p-1', 'escapeTitle'=>false, 'title'=>'View', 'target'=>'_blank'));
								}
							}else{
								echo $this->Html->link('<i class="fa  fa fa-eye pr-1 pl-1"></i>', '/mms/monthly-returns-pdf/'.$row["MineCode"].'/'.$row['MonthYear'].'/'.$row['ReturnType'].'/read', array('class'=>'btn-shadow p-1', 'escapeTitle'=>false, 'title'=>'View', 'target'=>'_blank'));
							}
							
							?>
							</div>
						</td>
					</tr>
				<?php $i++; } } ?>
				</tbody>
			</table>
		
		
		<?php }elseif($_SESSION['sess_form_type'] == 'm' || $_SESSION['sess_form_type'] == 'l'){ ?>
		
			<table class="mb-0 table table-striped return_list_table" id="list">
				<thead class="bg-dark text-white">
				<tr>
					<th class="p-1 border-right-1 border-white">#</th>
					<!--<th class="p-1 border-right-1 border-white"></th>-->
					<th class="p-1 border-right-1 border-white">Applicant Id</th>
					<th class="p-1 border-right-1 border-white">FORM NO.</th>
					<th class="p-1 border-right-1 border-white"><?php echo ($_SESSION['sess_form_type'] == 'm') ? 'MONTH/YEAR' : 'YEAR'; ?></th>
					<th class="p-1 border-right-1 border-white">DATE OF SUBMISSION</th>
					<th class="p-1 border-right-1 border-white">STATUS</th>
					<th class="p-1 border-right-1 border-white">STATUS DATE</th>
					<th class="p-1 border-right-1 border-white">ACTION</th>
				</tr>
				</thead>
				<tbody>
				<?php if($returnsData != 'filterDataTampared'){
						$i=1;
						foreach($returnsData as $row) { 
						
							$submissionDate=date_create($row['DateOfFinalSubmission']);
							if($row['StatusDate']=='0000-00-00'){
								$statusDate = date_format(date_create($row['updatedAt']),"d-m-Y");
							}else{
								$statusDate= date_format(date_create($row['StatusDate']),"d-m-Y");
							}
							
							$applicantid = str_replace('/','SPR',$row["applicantId"]);
							
							/**
							* Added below check for rendering old returns (returns before MCDR 2017 was get in effect)
							* Render old returns in PDF format only.
							* @version 29th Nov 2021
							* @author Aniket Ganvir
							*/
							$monthYear = $row['MonthYear'];
							$monYrArr = explode('/', $monthYear);
							$returnDt = trim($monYrArr[1]).'-'.trim($monYrArr[0]).'-01';
							$returnDt = date('Y-m-d', strtotime($returnDt));
							$oldReturn = ($returnDt < $cutoffDate) ? 1 : 0;

					?>
					<tr>
						<th scope="row"><?php echo $i; ?></th>
						<!--<td><?php //echo $row['RegistrationNumber']; ?></td>-->
						<td><?php echo $row['applicantId']; ?></td>		
						<td><?php if($row['ReturnType'] =='MONTHLY'){ echo 'L'; }else{ echo 'M'; } ?></td>
						<td><?php echo $monYrLabel = ($_SESSION['sess_form_type'] == 'm') ? $row['MonthYear'] : ((trim((int)$monYrArr[1])) . "-" .trim((int)$monYrArr[1] + 1)); ?></td>
						<td><?php echo date_format($submissionDate,"d-m-Y"); ?></td>
						<td><?php echo $row['StatusReferred']; ?></td>
						<td><?php echo $statusDate; ?></td>
						<td>
							<div class="btn-group">
							<?php 
							if(empty($returnList)){
								if ($oldReturn == 0) {
									echo $this->Html->link('<i class="fa  fa fa-eye pr-1 pl-1 spinner_btn_nxt"></i>', '/mms/monthly-returns/'.$applicantid.'/'.$row['MonthYear'].'/'.$row['ReturnType'].'/view', array('class'=>'btn-shadow p-1 spinner_btn_nxt', 'escapeTitle'=>false, 'title'=>'View'));
									
									if (isset($row['pdfPath']) && !empty($row['pdfPath'])){
										echo '<a href="'.$this->Url->build('/'.$row['pdfPath']).'" class="btn-shadow pt-1" title="View PDF" target="_blank"><i class="fa fa-file-pdf text-danger"></i></a>';
										
										// Added pdf version view button on 25-08-2022 by Aniket
										echo '<a href="#" class="btn-shadow pt-1 pl-2 view_all_pdf_version_btn" title="View all PDF version" data-toggle="modal" data-target="#pdf_version_modal" appid="'.$row['applicantId'].'" rtype="'.$row['ReturnType'].'" rdate="'.$row['ReturnDate'].'" rmnyr="'.$monYrLabel.'" rform="enduser"><i class="fa fa-file-pdf text-primary"></i></a>';
									}

								} else {
									echo $this->Html->link('<i class="fa  fa fa-eye pr-1 pl-1"></i>', '/mms/monthly-returns-pdf/'.$applicantid.'/'.$row['MonthYear'].'/'.$row['ReturnType'].'/view', array('class'=>'btn-shadow p-1', 'escapeTitle'=>false, 'title'=>'View', 'target'=>'_blank'));
								}
							}
							else{
								echo $this->Html->link('<i class="fa  fa fa-eye pr-1 pl-1"></i>', '/mms/monthly-returns-pdf/'.$applicantid.'/'.$row['MonthYear'].'/'.$row['ReturnType'].'/view', array('class'=>'btn-shadow p-1', 'escapeTitle'=>false, 'title'=>'View', 'target'=>'_blank'));
							}
								
							?>
							</div>
						</td>
					</tr>
				<?php $i++; } } ?>
				</tbody>
			</table>
			<?php } ?>
		</div>
	</div>
</div>

<?php echo $this->Form->control('',['type'=>'hidden', 'id'=>'get_pdf_version_url', 'value'=>$this->Url->build(array('controller'=>'ajax', 'action'=>'get_pdf_version'))]); ?>
<?php echo $this->Html->script('element/return_list.js?version='.$version); ?>