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
                <h4 class="tHeadFont" id='heading1'>Report M01-A - Grade wise ROM Production, ROM Dispatch & ROM Ex Mine Price  (For Iron Ore and Chromite only)</h4>
                
                <div class="form-horizontal">
                    <div class="card-body" id="avb">
                    <h6 class="tHeadDate"  id='heading2'>Date : <?php echo 'From '.$showDate; ?></h6>
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
										<th>Nature of use (Captive/Non-captive)</th>			  
                                        <th>IBM Registration Number</th>
                                        <th>Grade of ROM</th>
                                        <th>ROM Production Open Cast(tonnes)</th>
                                        <th>ROM Production Underground(tonnes)</th>
                                        <th>Dump Working Production (tonnes)</th>
                                        <th>ROM Dispatch(tonnes)</th>
                                        <th>Ex Mine Price ROM(Rs/tonnes)</th>
										<th>Nature of Despatch (Domestic Sale / Domestic Transfer / Captive Consumption / Export)</th>
										<th>Quantity (in tonne)</th>																								  
                                        <th>Sale Value(Rs)</th>
                                        <th>Deduction made from sale value for computation of Ex mine price(in Rs/tonnes)</th>
                                    </tr>
                                </thead>
                                <tbody class="tableBody">
                                    <?php
									//print_r($records);die;
                                    foreach ($records as $record) :
                                      //creating object of DateTime and fetching the month
                                      $dbj   = DateTime::createFromFormat('!m', $record['showMonth']);										  
                                      //Format it to month name
                                      $monthName = $dbj->format('F');
                                    ?>
                                        <tr>
                                            <td></td>
                                            <td><?php echo $monthName.' '.$record['showYear']; ?></td>												
                                            <td><?php echo ucwords(str_replace('_', ' ', $record['mineral_name'])) ?></td>
                                            <td><?php echo $record['state_name']; ?></td>
                                            <td><?php echo $record['district_name']; ?></td>												
                                            <td><?php echo $record['MINE_NAME'] ?></td>
                                            <td><?php echo $record['lessee_owner_name'] ?></td>
                                            <td><?php echo $record['lease_area'] ?></td>
                                            <td><?php echo $record['mine_code']; ?></td>
											<td><?php echo $record['nature_use']; ?></td>			
                                            <td><?php echo $record['registration_no'] ?></td>
                                            <td><?php echo $record['grade_name'] ?></td>
                                            <td><?php echo $record['prod_oc_rom'] ?></td>
                                            <td><?php echo $record['prod_ug_rom'] ?></td>
                                            <td><?php echo $record['prod_dw_rom'] ?></td>
                                            <td><?php echo $record['despatches'] ?></td>
                                            <td><?php echo $record['pmv'] ?></td>
											<td><?php echo $record['client_type']; ?></td>
											<td><?php echo $record['quantity']; ?></td>		 													 
                                            <td><?php echo $record['sale_value'] ?></td>
                                            <td><?php echo $record['detail_deduction'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>