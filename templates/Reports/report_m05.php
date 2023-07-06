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
                    <h4 class="tHeadFont" id='heading1'>ReportM05 - Sales-Dispatch Details of Ore/Concentrates</h4>
                    <div class="form-horizontal">
                        <div class="card-body" id="avb">
							<h6 class="tHeadDate"  id='heading2'>Date : <?php echo 'From '.$showDate; ?></h6>
                            <?php if($rowCount <= '10000') { ?>
							<div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" id="tableReport">
                                    <thead class="tableHead">
                                        <tr>
                                            <th rowspan="2">#</th>
                                            <th rowspan="2">Month</th>  
											<th rowspan="2">Mineral</th>
											<th rowspan="2">State</th>
											<th rowspan="2">District</th>  
                                            <th rowspan="2">Name of Mine</th>
                                            <th rowspan="2">Name of Lease Owner</th>
                                            <th rowspan="2">Lease Area</th>
											<th rowspan="2">Mine Code</th>
                                            <th rowspan="2">IBM Registration Number</th>
											
											<th rowspan="2">Mine Category</th>
											<th rowspan="2">Type Of Working</th>
											<th rowspan="2">Mechanisation</th>
											<th rowspan="2">Mine Ownership</th>
											
											
                                            <th colspan="6"> For Domestic Purpose</th>
                                            <th colspan="3">For Export Purpose</th>
                                        </tr>
                                        <tr>
                                            <th>Grade of Ore/Concentrate</th>
                                            <th>Nature of Dispatch</th>
                                            <th>Consignee Name</th>
                                            <th>Consignee IBM Registration No.</th>
                                            <th>Quantity (tonnes)</th>
                                            <th>Sale Value(Rs)</th>
                                            <th>Country</th>
                                            <th>Quantity</th>
                                            <th>F.O.B Value(Rs)</th>
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
												
												<td><?php echo $record['mine_category'] ?></td>
												<td><?php echo $record['type_working'] ?></td>
												<td><?php echo $record['mechanisation'] ?></td>
												<td><?php echo $record['mine_ownership'] ?></td>
												
												
                                                <td><?php echo $record['grade_name'] ?></td>
                                                <td><?php echo $record['client_type'] ?></td>
                                                <td><?php echo $record['client_name'] ?></td>
                                                <td><?php echo $record['client_reg_no'] ?></td>
                                                <td><?php echo $record['quantity'] ?></td>
                                                <td><?php echo $record['sale_value']; ?></td>
                                                <td><?php echo $record['expo_country'] ?></td>
                                                <td><?php echo $record['expo_quantity'] ?></td>
                                                <td><?php echo $record['expo_fob'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
							<?php } else { ?>
							<!-- Added by Shweta Apale on 27-07-2022 for excel download use id = 'noDatatable' -->
							<h6 class="tHeadDate" id='heading2'><strong>Since records are more hence no search & pagination service is available, you may use the option "Export to Excel"</strong></h6>
							<input type="button" id="downloadExcel" value="Export to Excel">
							<!--<input type="button" id="printTable" value="Print">-->
							<br /><br />
							
							<div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" border="1" id="noDatatable">
                                    <thead class="tableHead">
										<tr>
											<th colspan="19" class="noDisplay" align="left">ReportM05 - Sales-Dispatch Details of Ore/Concentrates  Date : <?php echo 'From '.$showDate; ?></th>
										</tr>
                                        <tr>
                                            <th rowspan="2">#</th>
                                            <th rowspan="2">Month</th>  
											<th rowspan="2">Mineral</th>
											<th rowspan="2">State</th>
											<th rowspan="2">District</th>  
                                            <th rowspan="2">Name of Mine</th>
                                            <th rowspan="2">Name of Lease Owner</th>
                                            <th rowspan="2">Lease Area</th>
											<th rowspan="2">Mine Code</th>
                                            <th rowspan="2">IBM Registration Number</th>
											
											<th rowspan="2">Mine Category</th>
											<th rowspan="2">Type Of Working</th>
											<th rowspan="2">Mechanisation</th>
											<th rowspan="2">Mine Ownership</th>
											
											
                                            <th colspan="6"> For Domestic Purpose</th>
                                            <th colspan="3">For Export Purpose</th>
                                        </tr>
                                        <tr>
                                            <th>Grade of Ore/Concentrate</th>
                                            <th>Nature of Dispatch</th>
                                            <th>Consignee Name</th>
                                            <th>Consignee IBM Registration No.</th>
                                            <th>Quantity (tonnes)</th>
                                            <th>Sale Value(Rs)</th>
                                            <th>Country</th>
                                            <th>Quantity</th>
                                            <th>F.O.B Value(Rs)</th>
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
												
												<td><?php echo $record['mine_category'] ?></td>
												<td><?php echo $record['type_working'] ?></td>
												<td><?php echo $record['mechanisation'] ?></td>
												<td><?php echo $record['mine_ownership'] ?></td>
												
												
                                                <td><?php echo $record['grade_name'] ?></td>
                                                <td><?php echo $record['client_type'] ?></td>
                                                <td><?php echo $record['client_name'] ?></td>
                                                <td><?php echo $record['client_reg_no'] ?></td>
                                                <td><?php echo $record['quantity'] ?></td>
                                                <td><?php echo $record['sale_value']; ?></td>
                                                <td><?php echo $record['expo_country'] ?></td>
                                                <td><?php echo $record['expo_quantity'] ?></td>
                                                <td><?php echo $record['expo_fob'] ?></td>
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