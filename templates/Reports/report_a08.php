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
                    <h4 class="tHeadFont" id="heading1">Report A08 - Precious & Semi Precious Stone ROM Production Details( Form F3)</h4>
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
                                            <th rowspan="2">#</th>
                                            <th rowspan="2">Year</th>
											<th rowspan="2">Mineral</th>
                                            <th rowspan="2">State</th>
                                            <th rowspan="2">District</th>                                              
                                            <th rowspan="2">Name of Mine</th>
                                            <th rowspan="2">Name of Lease Owner</th>
                                            <th rowspan="2">Lease Area</th>
											<th rowspan="2">Mine Code</th>
                                            <th rowspan="2">IBM Registration Number</th>
                                            <th colspan="2"> Open Cast Working</th>
                                            <th colspan="2">Underground Working</th>
                                        </tr>
                                        <tr>
                                            <th>Units of Quantity</th>
                                            <th>Quantity</th>
                                            <th>Units of Quantity</th>
                                            <th>Quantity</th>
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
                                                <td><?php echo $record['oc_type'] ?></td>
                                                <td><?php echo $record['oc_qty'] ?></td>
                                                <td><?php echo $record['ug_type'] ?></td>
                                                <td><?php echo $record['ug_qty'] ?></td>
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
											<th colspan="14" class="noDisplay" align="left">Report A08 - Precious & Semi Precious Stone ROM Production Details( Form F3)  Year : <?php echo $showDate; ?></th>
										</tr>
                                        <tr>
                                            <th rowspan="2">#</th>
                                            <th rowspan="2">Year</th>
											<th rowspan="2">Mineral</th>
                                            <th rowspan="2">State</th>
                                            <th rowspan="2">District</th>                                              
                                            <th rowspan="2">Name of Mine</th>
                                            <th rowspan="2">Name of Lease Owner</th>
                                            <th rowspan="2">Lease Area</th>
											<th rowspan="2">Mine Code</th>
                                            <th rowspan="2">IBM Registration Number</th>
                                            <th colspan="2"> Open Cast Working</th>
                                            <th colspan="2">Underground Working</th>
                                        </tr>
                                        <tr>
                                            <th>Units of Quantity</th>
                                            <th>Quantity</th>
                                            <th>Units of Quantity</th>
                                            <th>Quantity</th>
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
                                                <td><?php echo $record['oc_type'] ?></td>
                                                <td><?php echo $record['oc_qty'] ?></td>
                                                <td><?php echo $record['ug_type'] ?></td>
                                                <td><?php echo $record['ug_qty'] ?></td>
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