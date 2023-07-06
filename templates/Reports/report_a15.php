<?php if (!empty($records)) { ?>

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><?php echo $this->Html->link('Back', array('controller' => 'reports', 'action' => 'report-list'), array('class' => 'add_btn btn btn-secondary backToReport')); ?>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="tHeadFont" id="heading1">Report A15 - Cost of Production</h4>
                    <div class="form-horizontal">
                        <div class="card-body" id="avb">
							<h6 class="tHeadDate" id='heading2'>Year : <?php echo $showDate; ?></h6>
							<?php // To check record count if less than show records in datatable else with no datatable
                            // Added by Shweta Apale on 29-07-2022 start
                            if ($rowCount <= 10000) { ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" id="tableReport">
                                    <thead class="tableHead">
                                        <tr>
                                            <th rowspan="3">#</th>
                                            <th rowspan="3">Year</th>
											<th rowspan="3">Mineral</th>
                                            <th rowspan="3">State</th>
                                            <th rowspan="3">District</th>                                             
                                            <th rowspan="3">Name of Mine</th>
                                            <th rowspan="3">Name of Lease Owner</th>
                                            <th rowspan="3">Lease Area</th>
											<th rowspan="3">Mine Code</th>
                                            <th rowspan="3">IBM Registration Number</th>
                                            <th colspan="13">Cost of Production(Rs/Tonnes)</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3">Direct Cost</th>
                                            <th rowspan="2">Over-head Cost</th>
                                            <th rowspan="2">Depriciation</th>
                                            <th rowspan="2">Interest</th>
                                            <th rowspan="2">Royalty</th>
                                            <th rowspan="2">Payemnt made to DMF</th>
                                            <th rowspan="2">Payment made to NMET </th>
                                            <th rowspan="2">Taxes</th>
                                            <th rowspan="2">Dead Rent</th>
                                            <th rowspan="2">Others (Specify)</th>
                                            <th rowspan="2">Total</th>
                                        </tr>
                                        <tr>
                                            <th>Exploration</th>
                                            <th>Mining</th>
                                            <th>Beneficiation</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody">
                                        <?php
                                        foreach ($records as $record) :
                                        ?>
                                            <tr>
                                                <td></td>
                                                <td><?php echo $record['year1']?>
												<td><?php echo ucwords(str_replace('_', ' ', $record['mineral_name']))?></td>
												<td><?php echo $record['state_name'] ?></td>
												<td><?php echo $record['district_name'];?></td>   
                                                <td><?php echo $record['MINE_NAME'] ?></td>
                                                <td><?php echo $record['lessee_owner_name'] ?></td>
                                                <td><?php echo $record['lease_area'] ?></td>
												<td><?php echo $record['mine_code']; ?></td>
                                                <td><?php echo $record['registration_no'] ?></td>
                                                <td><?php echo $record['exploration_cost']; ?></td>
                                                <td><?php echo $record['mining_cost']; ?></td>
                                                <td><?php echo $record['beneficiation_cost']; ?></td>
                                                <td><?php echo $record['overhead_cost']; ?></td>
                                                <td><?php echo $record['depreciation_cost']; ?></td>
                                                <td><?php echo $record['interest_cost']; ?></td>
                                                <td><?php echo $record['royalty_cost']; ?></td>
                                                <td><?php echo $record['past_pay_dmf']; ?></td>
                                                <td><?php echo $record['past_pay_nmet'] ?></td>
                                                <td><?php echo $record['taxes_cost'] ?></td>
                                                <td><?php echo $record['dead_rent_cost']; ?></td>
                                                <td><?php echo $record['others_cost'] ?></td>
                                                <td><?php echo $record['total_cost']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
							<?php } else { ?>
							<!-- Added by Shweta Apale on 29-07-2022 for excel download use id = 'noDatatable' -->
							<h6 class="tHeadDate" id='heading2'><strong>Since records are more hence no search & pagination service is available, you may use the option "Export to Excel"</strong></h6>
							<input type="button" id="downloadExcel" value="Export to Excel">
							<!--<input type="button" id="printTable" value="Print">-->
							<br /><br />
							
							<div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" border="1" id="noDatatable">
                                    <thead class="tableHead">
										<tr>
											<th colspan="22" class="noDisplay" align="left">Report A15 - Cost of Production  Year : <?php echo $showDate; ?></th>
										</tr>
                                        <tr>
                                            <th rowspan="3">#</th>
                                            <th rowspan="3">Year</th>
											<th rowspan="3">Mineral</th>
                                            <th rowspan="3">State</th>
                                            <th rowspan="3">District</th>                                             
                                            <th rowspan="3">Name of Mine</th>
                                            <th rowspan="3">Name of Lease Owner</th>
                                            <th rowspan="3">Lease Area</th>
											<th rowspan="3">Mine Code</th>
                                            <th rowspan="3">IBM Registration Number</th>
                                            <th colspan="13">Cost of Production(Rs/Tonnes)</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3">Direct Cost</th>
                                            <th rowspan="2">Over-head Cost</th>
                                            <th rowspan="2">Depriciation</th>
                                            <th rowspan="2">Interest</th>
                                            <th rowspan="2">Royalty</th>
                                            <th rowspan="2">Payemnt made to DMF</th>
                                            <th rowspan="2">Payment made to NMET </th>
                                            <th rowspan="2">Taxes</th>
                                            <th rowspan="2">Dead Rent</th>
                                            <th rowspan="2">Others (Specify)</th>
                                            <th rowspan="2">Total</th>
                                        </tr>
                                        <tr>
                                            <th>Exploration</th>
                                            <th>Mining</th>
                                            <th>Beneficiation</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody">
                                        <?php
										$sr = 1;
                                        foreach ($records as $record) :
                                        ?>
                                            <tr>
                                                <td><?php echo $sr; ?></td>
                                                <td><?php echo $record['year1']?>
												<td><?php echo ucwords(str_replace('_', ' ', $record['mineral_name']))?></td>
												<td><?php echo $record['state_name'] ?></td>
												<td><?php echo $record['district_name'];?></td>
                                                <td><?php echo $record['MINE_NAME'] ?></td>
                                                <td><?php echo $record['lessee_owner_name'] ?></td>
                                                <td><?php echo $record['lease_area'] ?></td>
												<td><?php echo $record['mine_code']; ?></td>
                                                <td><?php echo $record['registration_no'] ?></td>
                                                <td><?php echo $record['exploration_cost']; ?></td>
                                                <td><?php echo $record['mining_cost']; ?></td>
                                                <td><?php echo $record['beneficiation_cost']; ?></td>
                                                <td><?php echo $record['overhead_cost']; ?></td>
                                                <td><?php echo $record['depreciation_cost']; ?></td>
                                                <td><?php echo $record['interest_cost']; ?></td>
                                                <td><?php echo $record['royalty_cost']; ?></td>
                                                <td><?php echo $record['past_pay_dmf']; ?></td>
                                                <td><?php echo $record['past_pay_nmet'] ?></td>
                                                <td><?php echo $record['taxes_cost'] ?></td>
                                                <td><?php echo $record['dead_rent_cost']; ?></td>
                                                <td><?php echo $record['others_cost'] ?></td>
                                                <td><?php echo $record['total_cost']; ?></td>
                                            </tr>
                                        <?php 
											$sr++;
											endforeach; 
										?>
                                    </tbody>
                                </table>
                            </div>
							<?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>