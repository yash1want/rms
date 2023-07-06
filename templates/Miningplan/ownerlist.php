<div class="main-card card fcard mb-1 mt-n3">
    <div class="card-body">
        <div class="rows"><h4 class="text-center font-weight-bold text-alternate">Mining Owner List</h4>
            
        </div>
    </div>
</div>
<div class="main-card mb-3 card">
	<div class="card-body">			
		<div class="table-responsive">
			<table class="mb-0 table table-striped " id="list">
				<thead class="bg-dark text-white">
					<tr>
						<th class="p-1 border-right-1 border-white">#</th>						
						<th class="p-1 border-right-1 border-white">REG. NO.</th>
						<th class="p-1 border-right-1 border-white">NAME OF THE OWNER</th>
						<th class="p-1 border-right-1 border-white">MINE NAME</th> 
						<th class="p-1 border-right-1 border-white">MINE CODE</th>
						<th class="p-1 border-right-1 border-white">MINERAL NAME</th>
						<th class="p-1 border-right-1 border-white">YEAR</th>
						<th class="p-1 border-right-1 border-white">STATUS</th>
						<th class="p-1 border-right-1 border-white">VIEW</th>
					</tr>
				</thead>  
				<?php
					$i = 1;
					foreach ($mine_records as $r) {
                ?>
					<tbody>
						<td><?= $i; ?></td> 
						<td><?= $r['REGISTRATION_NO']; ?></td> 
						<td><?= $r['OWNER_NAME']; ?></td> 
						<td>
							<?php
							if ($r['MINE_NAME'] == "") {
									echo 'NA';
							}
							else {
								echo $r['MINE_NAME'];
							}
							?>
						</td> 
						<td><?= $r['mine_code']; ?></td> 
						<td>
							<?php if ($r['MINERAL_NAME'] == 1) { ?>
                            IRON ORE-HEMATITE
							<?php } else if ($r['MINERAL_NAME'] == 2) {
								?>
								IRON ORE-MEGNATITE
								<?php
							} else {
								echo $r['MINERAL_NAME'];
							}
							?>
						</td> 
						<td><?= $r['FIRST_SUBMIT_DATE']; ?></td> 
						<td>
							<?php
							$s = $r['STATUS'];
							if ($s == 0)
								$status = "Pending";
							else if ($s == 1)
								$status = "Accepted";
							else if ($s == 2)
								$status = "Referred Back";

							echo $status;
							?>
						</td> 
						<td>
							<?php 
								echo $this->Html->link('<i class="fa  fa fa-eye pr-1 pl-1 spinner_btn_nxt"></i>', '/Miningplan/ownerdetailsFetchID/'.$r["ID"].'/'.$r["mine_code"], array('class'=>'btn-shadow p-1', 'escapeTitle'=>false, 'title'=>'View'));
							?>
						</td> 
					</tbody>
				<?php
					$i++;
					}
				?>
			</table>			
		</div>
	</div>
</div>
<script> $('#list').DataTable();	</script>
    