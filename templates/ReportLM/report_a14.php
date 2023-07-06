
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><?php echo $this->Html->link('Back', array('controller' => 'report-l-m', 'action' => 'index'), array('class' => 'add_btn btn btn-secondary backToReport')); ?>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="tHeadFont" id="heading1">State wise Production of Product and Mineral Consumption Report</h4>
                    <div class="form-horizontal">
                        <div class="card-body" id="avb">
							<h6 class="tHeadDate" id='heading2'><?php echo $report; ?></h6>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" id="tableReport">
                                    <thead class="tableHead">
                                        <tr>
                                            <th rowspan="3">#</th>
                                            <th rowspan="3">State</th>
											<th rowspan="3">District</th>
											<th rowspan="3">Registration Number</th>
											<th rowspan="3">Name of Company</th>
                                            <th rowspan="3">Plant Name/Storage Location</th>
                                            <th rowspan="3">Name of Product</th>  
											<th colspan="2">Production(In Tonnes)</th> 	
                                            <th rowspan="3">Name of Minerals</th>
											<th colspan="4">Actual Consumption (In Tonnes)</th>
                                        </tr>
										<tr>
											<th rowspan="2">Previous F.Y</th> 
											<th rowspan="2">Present F.Y</th>
											<th colspan="2">Previous F.Y</th> 
											<th colspan="2">Present F.Y</th>
                                        </tr>
										<tr>
											<th>Indigenous</th> 	
                                            <th>Imported</th>
											<th>Indigenous</th> 	
                                            <th>Imported</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody">
									<?php if (!empty($records)) { ?>
                                        <?php
                                        foreach ($records as $record) :
                                        ?>
                                            <tr>
                                                <td></td>
                                                <td><?php echo $record['state_name']; ?>
												<td><?php echo $record['district_name']; ?></td>
												<td><?php echo $record['concession_code']; ?></td>
												<td><?php echo $record['fname']; ?></td>                                                                                                                                                                                                                                                                                                   
                                                <td><?php echo $record['address1']; ?></td>
												<td><?php echo $record['prod_name']; ?></td>
                                                <td><?php echo $record['prev_year_prod']; ?></td>
												<td><?php echo $record['pres_year_prod']; ?>
												<td><?php echo $record['mineral_name']; ?></td>
												<td><?php echo $record['prev_ind_year']; ?></td>
												<td><?php echo $record['prev_imp_year']; ?></td>                                                                                                                                                                                                                                                                                                   
                                                <td><?php echo $record['pres_ind_year']; ?></td>
												<td><?php echo $record['pres_inm_year']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
									<?php } ?>	
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

