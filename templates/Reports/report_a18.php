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
                    <h4 class="tHeadFont" id="heading1">Report A18 - Machinary used in the Mine</h4>
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
                                            <th>Type of Machinery</th>
                                            <th>Capacity of each type of machinery</th>
                                            <th>Unit (in which capacity is reported)</th>
                                            <th>No. of Machinery</th>
                                            <th>Electrical/Non Electrical</th>
                                            <th>Used in Open Cast/Underground</th>
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
                                                <td><?php echo $record['machinery_name']; ?></td>
                                                <td><?php echo $record['capacity']; ?></td>
                                                <td><?php echo $record['unit_no']; ?></td>
                                                <td><?php echo $record['no_of_machinery']; ?></td>
                                                <td><?php echo $record['electrical_machinery']; ?></td>
                                                <td><?php echo $record['oc_machinery']; ?></td>
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
											<th colspan="16" class="noDisplay" align="left">Report A18 - Machinary used in the Mine  Year : <?php echo $showDate; ?></th>
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
                                            <th>Type of Machinery</th>
                                            <th>Capacity of each type of machinery</th>
                                            <th>Unit (in which capacity is reported)</th>
                                            <th>No. of Machinery</th>
                                            <th>Electrical/Non Electrical</th>
                                            <th>Used in Open Cast/Underground</th>
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
                                                <td><?php echo $record['machinery_name']; ?></td>
                                                <td><?php echo $record['capacity']; ?></td>
                                                <td><?php echo $record['unit_no']; ?></td>
                                                <td><?php echo $record['no_of_machinery']; ?></td>
                                                <td><?php echo $record['electrical_machinery']; ?></td>
                                                <td><?php echo $record['oc_machinery']; ?></td>
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