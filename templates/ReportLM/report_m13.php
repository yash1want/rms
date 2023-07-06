
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
                    <h4 class="tHeadFont" id="heading1">End Use Mineral Consumption Monthly Report</h4>
                    <div class="form-horizontal">
                        <div class="card-body" id="avb">
							<h6 class="tHeadDate" id='heading2'><?php echo $report; ?></h6>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" id="tableReport">
                                    <thead class="tableHead">
                                        <tr>
                                            <th>#</th>
                                            <th>IBM Registration No</th>
											<th>Name of the Company</th>
											<th>Applicant Id</th>
                                            <th>Name of the Plant/Storage Location</th>
                                            <th>Name Of Month</th>  
											<th>Mineral</th> 	
                                            <th>Mineral/Ore Consumed(In tonnes) Monthly</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody">
									<?php if (!empty($records)) { ?>
                                        <?php
                                        foreach ($records as $record) :
                                        ?>
                                            <tr>
                                                <td></td>
                                                <td><?php echo $record['concession_code']; ?>
												<td><?php echo $record['fname']; ?></td>
												<td><?php echo $record['applicant_id']; ?></td>
												<td><?php echo $record['address1']; ?></td>                                                                                                                                                                                                                                                                                                   
                                                <td><?php echo $record['return_date']; ?></td>
												<td><?php echo $record['local_mineral_code']; ?></td>
                                                <td><?php echo $record['quantity']; ?></td>
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

