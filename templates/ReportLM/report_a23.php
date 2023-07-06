
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
                    <h4 class="tHeadFont" id="heading1">Industry-wise List of Plants</h4>
                    <div class="form-horizontal">
                        <div class="card-body" id="avb">
							<h6 class="tHeadDate" id='heading2'><?php echo $report; ?></h6>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" id="tableReport">
                                    <thead class="tableHead">
                                        <tr>
                                            <th>#</th>
                                            <th>Name Of Industry</th>
											<th>Name of State</th>
											<th>Name of the Company</th>
                                            <th>Name of Plant</th>
                                            <th>Registration Number</th>  		
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody">
									<?php if (!empty($records)) { ?>
                                        <?php
                                        foreach ($records as $record) :
                                        ?>
                                            <tr>
                                                <td></td>
												<td><?php echo $record['industry_name']; ?></td>
												<td><?php echo $record['state_name']; ?></td>
                                                <td><?php echo $record['fname']; ?>
												<td><?php echo $record['address1']; ?></td>                                                                                                                                                                                                                                                                                                   
                                                <td><?php echo $record['concession_code']; ?></td>     											
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


