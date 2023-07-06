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
                    <h4 class="tHeadFont" id='heading1'>Report M02C - Grade wise Production, Grade wise Dispatch, Grade wise Ex-mine Price, Opening-Closing Stock, Sale Quantity & Value (For F3 Minerals)</h4>
                    <div class="form-horizontal">
                        <div class="card-body" id="avb">
                            <h6 class="tHeadDate" id='heading2'>Date : <?php echo 'From ' . $showDate; ?></h6>
                            <?php 
							// To check record count if less than show records in datatable else with no datatable
                            // Added by Shweta Apale on 27-07-2022 start
							if($rowCount <= '10000') {
							?>
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
											<th>Nature of use (Captive / Non-Captive) </th>
                                            <th>IBM Registration Number</th>
											
											<th>Mine Category</th>
											<th>Type Of Working</th>
											<th>Mechanisation</th>
											<th>Mine Ownership</th>
											
											
                                            <th>Grade</th>
                                            <th>Grade wise production</th>
                                            <th>Grade wise dispatch from mine head</th>
                                            <th>Ex Mine Price(Rs)</th>
                                            <th>Grade wise opening stock </th>
                                            <th>Grade wise closing stock </th>
											<th>Nature of Despatch (Domestic Sale / Domestic Transfer / Captive Consumption / Export)</th>
                                            <th>Quantity </th>
											<th>Sale Value(Rs)</th>
                                            <th>Deduction made from sale value for computation of Ex mine price(in Rs)</th>
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
                                                <td><?php echo $monthName . ' ' . $record['showYear']; ?></td>
                                                <td><?php echo ucwords(str_replace('_', ' ', $record['mineral_name'])) ?></td>
                                                <td><?php echo $record['state_name']; ?></td>
                                                <td><?php echo $record['district_name']; ?></td>          
                                                <td><?php echo $record['MINE_NAME'] ?></td>
                                                <td><?php echo $record['lessee_owner_name'] ?></td>
                                                <td><?php echo $record['lease_area'] ?></td>
												<td><?php echo $record['mine_code']; ?></td>
												<td><?php echo $record['nature_use']; ?></td>
                                                <td><?php echo $record['registration_no'] ?></td>
												
												<td><?php echo $record['mine_category'] ?></td>
												<td><?php echo $record['type_working'] ?></td>
												<td><?php echo $record['mechanisation'] ?></td>
												<td><?php echo $record['mine_ownership'] ?></td>
												
												
                                                <td><?php echo $record['grade_name'].' in '. $record['input_unit'] ?></td>
                                                <td><?php echo $record['production'] ?></td>
                                                <td><?php echo $record['despatches']?></td>
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
											<th colspan="21"  class="noDisplay" align="left">Report M02C - Grade wise Production, Grade wise Dispatch, Grade wise Ex-mine Price, Opening-Closing Stock, Sale Quantity & Value (For F3 Minerals)  Date : <?php echo 'From ' . $showDate; ?></th>
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
											<th>Nature of use (Captive / Non-Captive) </th>
                                            <th>IBM Registration Number</th>
											
											<th>Mine Category</th>
											<th>Type Of Working</th>
											<th>Mechanisation</th>
											<th>Mine Ownership</th>
											
											
                                            <th>Grade</th>
                                            <th>Grade wise production</th>
                                            <th>Grade wise dispatch from mine head</th>
                                            <th>Ex Mine Price(Rs)</th>
                                            <th>Grade wise opening stock </th>
                                            <th>Grade wise closing stock </th>
											<th>Nature of Despatch (Domestic Sale / Domestic Transfer / Captive Consumption / Export)</th>
                                            <th>Quantity </th>
											<th>Sale Value(Rs)</th>
                                            <th>Deduction made from sale value for computation of Ex mine price(in Rs)</th>
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
                                                <td><?php echo $monthName . ' ' . $record['showYear']; ?></td>
                                                <td><?php echo ucwords(str_replace('_', ' ', $record['mineral_name'])) ?></td>
                                                <td><?php echo $record['state_name']; ?></td>
                                                <td><?php echo $record['district_name']; ?></td>                       
                                                <td><?php echo $record['MINE_NAME'] ?></td>
                                                <td><?php echo $record['lessee_owner_name'] ?></td>
                                                <td><?php echo $record['lease_area'] ?></td>
												<td><?php echo $record['mine_code']; ?></td>
												<td><?php echo $record['nature_use']; ?></td>
                                                <td><?php echo $record['registration_no'] ?></td>
												
												<td><?php echo $record['mine_category'] ?></td>
												<td><?php echo $record['type_working'] ?></td>
												<td><?php echo $record['mechanisation'] ?></td>
												<td><?php echo $record['mine_ownership'] ?></td>
												
												
                                                <td><?php echo $record['grade_name'].' in '. $record['input_unit'] ?></td>
                                                <td><?php echo $record['production'] ?></td>
                                                <td><?php echo $record['despatches']?></td>
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