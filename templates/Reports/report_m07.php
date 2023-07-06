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
                    <h4 class="tHeadFont" id="heading1">Report M07 - Details of Rent/Royalty/Dead Rent/DMF/NMET</h4>
                    <div class="form-horizontal">
                        <div class="card-body" id="avb">
							<h6 class="tHeadDate"  id='heading2'>Date : <?php echo 'From '.$showDate; ?></h6>
                            <?php // To check record count if less than show records in datatable else with no datatable
                            // Added by Shweta Apale on 28-07-2022 start
                            if ($rowCount <= 10000) { ?>
							<div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" id="tableReport">
                                    <thead class="tableHead">
                                        <tr>
                                            <th>#</th>
                                            <th>Month</th>  
											<th>Mineral</th>
											<th>State</th>
											<th>District</th>                                           
                                            <th>Name of Mine</th>
                                            <th>Name of Lease Owner</th>
                                            <th>Lease Area</th>
											<th>Mine Code</th>
                                            <th>IBM Registration Number</th>
                                            <th>Rent Paid(Rs)</th>
                                            <th>Royalty Paid(Rs)</th>
                                            <th>Dead Rent Paid(Rs)</th>
                                            <th>Payment to DMF(Rs)</th>
                                            <th>Payment to NMET(Rs)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody">
                                        <?php
                                        foreach ($records as $record) :
											//creating object of DateTime and fetching the month
											$dbj   = DateTime::createFromFormat('!m', $record['showMonth']);										  
											//Format it to month name
											$monthName = $dbj->format('F');
                                        ?>
                                            <tr>
                                                <td></td>
                                               <td><?php echo $monthName.' '.$record['showYear']; ?></td>	  
												<td><?php echo ucwords($record['mineral_name']) ?></td>
												<td><?php echo $record['state_name']; ?></td>
												<td><?php echo $record['district_name']; ?></td>                                           
                                                <td><?php echo $record['MINE_NAME'] ?></td>
                                                <td><?php echo $record['lessee_owner_name'] ?></td>
                                                <td><?php echo $record['lease_area'] ?></td>
												<td><?php echo $record['mine_code']; ?></td>
                                                <td><?php echo $record['registration_no'] ?></td>
                                                <td><?php echo $record['past_surface_rent'] ?></td>
                                                <td><?php echo $record['past_royalty'] ?></td>
                                                <td><?php echo $record['past_dead_rent'] ?></td>
                                                <td><?php echo $record['past_pay_dmf'] ?></td>
                                                <td><?php echo $record['past_pay_nmet'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
							<?php } else { ?>
                                <!-- Added by Shweta Apale on 28-07-2022 for excel download use id = 'noDatatable' -->
                                <h6 class="tHeadDate" id='heading2'><strong>Since records are more hence no search & pagination service is available, you may use the option "Export to Excel"</strong></h6>
                                <input type="button" id="downloadExcel" value="Export to Excel">
                                <!--<input type="button" id="printTable" value="Print">-->
                                <br /><br />
								
								<div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" border="1" id="noDatatable">
                                    <thead class="tableHead">
										<tr>
											<th colspan="15" class="noDisplay" align="left">Report M07 - Details of Rent/Royalty/Dead Rent/DMF/NMET  Date : <?php echo 'From '.$showDate; ?></th>
										</tr>
                                        <tr>
                                            <th>#</th>
                                            <th>Month</th>  
											<th>Mineral</th>
											<th>State</th>
											<th>District</th>                                           
                                            <th>Name of Mine</th>
                                            <th>Name of Lease Owner</th>
                                            <th>Lease Area</th>
											<th>Mine Code</th>
                                            <th>IBM Registration Number</th>
                                            <th>Rent Paid(Rs)</th>
                                            <th>Royalty Paid(Rs)</th>
                                            <th>Dead Rent Paid(Rs)</th>
                                            <th>Payment to DMF(Rs)</th>
                                            <th>Payment to NMET(Rs)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody">
                                        <?php
										$sr = 1;
                                        foreach ($records as $record) :
											//creating object of DateTime and fetching the month
											$dbj   = DateTime::createFromFormat('!m', $record['showMonth']);										  
											//Format it to month name
											$monthName = $dbj->format('F');
                                        ?>
                                            <tr>
                                                <td><?php echo $sr; ?></td>
												<td><?php echo $monthName.' '.$record['showYear']; ?></td>	  
												<td><?php echo ucwords($record['mineral_name']) ?></td>
												<td><?php echo $record['state_name']; ?></td>
												<td><?php echo $record['district_name']; ?></td>                                           
                                                <td><?php echo $record['MINE_NAME'] ?></td>
                                                <td><?php echo $record['lessee_owner_name'] ?></td>
                                                <td><?php echo $record['lease_area'] ?></td>
												<td><?php echo $record['mine_code']; ?></td>
                                                <td><?php echo $record['registration_no'] ?></td>
                                                <td><?php echo $record['past_surface_rent'] ?></td>
                                                <td><?php echo $record['past_royalty'] ?></td>
                                                <td><?php echo $record['past_dead_rent'] ?></td>
                                                <td><?php echo $record['past_pay_dmf'] ?></td>
                                                <td><?php echo $record['past_pay_nmet'] ?></td>
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