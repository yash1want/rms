
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
                    <h4 class="tHeadFont" id="heading1">Regionwise - Plantwise Installed Capacity Report</h4>
                    <div class="form-horizontal">
                        <div class="card-body" id="avb">
							<h6 class="tHeadDate" id='heading2'><?php echo $report; ?></h6>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" id="tableReport">
                                    <thead class="tableHead">
                                        <tr>
                                            <th>#</th>
                                            <th>Name Of Company</th>
											<th>Applicant ID</th>
                                            <th>IBM Registration Number</th>
                                            <th>Name of Plant/Storage Location</th>                                                                                         
                                            <th>Address of the Plant</th>
											<th>Product</th>
											<th>Installed Capacity</th>
											<th>Regional Office</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody">
									<?php if (!empty($records)) { ?>
                                        <?php
                                        foreach ($records as $record) :
                                        ?>
                                            <tr>
                                                <td></td>
                                                <td><?php echo $record['fname']; ?>
												<td><?php echo $record['applicant_id']; ?></td>
												<td><?php echo $record['concession_code']; ?></td>
												<td><?php echo $record['address1']; ?></td>                                                                                                                                                                                                                                                                                                   
                                                <td><?php echo $record['address2'].' '.$record['address3'].' '.$record['state_name']; ?></td>                      
												<td><?php echo $record['prod_name']; ?></td>
                                                <td><?php echo $record['prod_anual_capacity']; ?></td>
												<td><?php echo $record['region_name']; ?></td>
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

