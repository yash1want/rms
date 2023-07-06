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
                    <h4 class="tHeadFont" id="heading1">Report A02B - Grade wise Production, Grade wise Dispatch, Grade wise Ex-mine Price, Opening-Closing Stock, Sale Quantity & Value (For Iron Ore and Chromite)</h4>
                    <div class="form-horizontal">
                        <div class="card-body" id="avb">
							<h6 class="tHeadDate" id='heading2'>Year : <?php echo $showDate; ?></h6>
                            
							<?php 
							// To check record count if less than show records in datatable else with no datatable
                            // Added by Shweta Apale on 29-07-2022 start
							if($rowCount <= 10000) { ?>
							<div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" id="tableReport">
                                    <thead class="tableHead">
                                        <tr>
                                            <th>#</th>
                                            <th>Year</th>
											<th>Mineral</th>
                                            <th>State</th>
                                            <th>District</th>                                                                     
                                            <th>Name of Mine</th>
                                            <th>Name of Lease Owner</th>
                                            <th>Lease Area</th>
											<th>Mine Code</th>
                                            <th>IBM Registration Number</th>
											
											<th>Mine Category</th>
											<th>Type Of Working</th>
											<th>Mechanisation</th>
											<th>Mine Ownership</th>
											
                                            <th>Grade</th>
                                            <th>Grade wise production</th>
                                            <th>Grade wise dispatch from mine head</th>
                                            <th>Ex Mine Price ROM(Rs/tonnes)</th>
                                            <th>Grade wise opening stock (tonnes)</th>
                                            <th>Grade wise closing stock (tonnes)</th>
											<th>Nature of Despatch (Domestic Sale / Domestic Transfer / Captive Consumption / Export)</th>
                                            <th>Quantity (in tonne)</th>
											<th>Sale Value(Rs)</th>
                                            <th>Deduction made from sale value for computation of Ex mine price(in Rs/tonnes)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody">
                                        <?php
                                        foreach ($records as $record) :
                                        ?>
                                            <tr>
                                                <td></td>
                                                <td><?php echo $record['year1']?></td>
												<td><?php echo ucwords(str_replace('_', ' ', $record['mineral_name']))?></td>
												<td><?php echo $record['state_name'] ?></td>
												<td><?php echo $record['district_name'];?></td>    
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
                                                <td><?php echo $record['production'] ?></td>
                                                <td><?php echo $record['despatches'] ?></td>
                                                <td><?php echo $record['pmv'] ?></td>
                                                <td><?php echo $record['opening_stock'] ?></td>
                                                <td><?php echo $record['closing_stock'] ?></td>
                                                <td><?php echo $record['client_type'] ?></td>
												<td><?php echo $record['quantity'] ?></td>
                                                <td><?php echo $record['sale_value'] ?></td>
                                                <td><?php echo $record['detail_deduction'] ?></td>
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
											<th colspan="21" class="noDisplay" align="left">Report A02B - Grade wise Production, Grade wise Dispatch, Grade wise Ex-mine Price, Opening-Closing Stock, Sale Quantity & Value (For Iron Ore and Chromite)  Year : <?php echo $showDate; ?></th>
										</tr>
                                        <tr>
                                            <th>#</th>
                                            <th>Year</th>
											<th>Mineral</th>
                                            <th>State</th>
                                            <th>District</th>                                                                
                                            <th>Name of Mine</th>
                                            <th>Name of Lease Owner</th>
                                            <th>Lease Area</th>
											<th>Mine Code</th>
                                            <th>IBM Registration Number</th>
											
											<th>Mine Category</th>
											<th>Type Of Working</th>
											<th>Mechanisation</th>
											<th>Mine Ownership</th>
											
                                            <th>Grade</th>
                                            <th>Grade wise production</th>
                                            <th>Grade wise dispatch from mine head</th>
                                            <th>Ex Mine Price ROM(Rs/tonnes)</th>
                                            <th>Grade wise opening stock (tonnes)</th>
                                            <th>Grade wise closing stock (tonnes)</th>
											<th>Nature of Despatch (Domestic Sale / Domestic Transfer / Captive Consumption / Export)</th>
                                            <th>Quantity (in tonne)</th>
											<th>Sale Value(Rs)</th>
                                            <th>Deduction made from sale value for computation of Ex mine price(in Rs/tonnes)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody">
                                        <?php
										$sr = 1;
                                        foreach ($records as $record) :
                                        ?>
                                            <tr>
                                                <td><?php echo $sr; ?></td>
                                                <td><?php echo $record['year1']?></td>
												<td><?php echo ucwords(str_replace('_', ' ', $record['mineral_name']))?></td>
												<td><?php echo $record['state_name'] ?></td>
												<td><?php echo $record['district_name'];?></td>  
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
                                                <td><?php echo $record['production'] ?></td>
                                                <td><?php echo $record['despatches'] ?></td>
                                                <td><?php echo $record['pmv'] ?></td>
                                                <td><?php echo $record['opening_stock'] ?></td>
                                                <td><?php echo $record['closing_stock'] ?></td>
                                                <td><?php echo $record['client_type'] ?></td>
												<td><?php echo $record['quantity'] ?></td>
                                                <td><?php echo $record['sale_value'] ?></td>
                                                <td><?php echo $record['detail_deduction'] ?></td>
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