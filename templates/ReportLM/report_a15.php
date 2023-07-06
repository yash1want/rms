
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
                    <h4 class="tHeadFont" id="heading1">Yearly Mineral wise End Use Mineral Consumption Report</h4>
                    <div class="form-horizontal">
                        <div class="card-body" id="avb">
							<h6 class="tHeadDate" id='heading2'><?php echo $report; ?></h6>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" id="tableReport">
                                    <thead class="tableHead">
                                        <tr>
                                            <th>#</th>
                                            <th>Industry</th>
											<?php $i = 1; $j = 0;
											
													while($i <= $daterange+1){
														
														switch ($i) {
															case 1 :
																echo "<th>".($from_year + $j).'-'.substr(($from_year + $i),-2)."</th>";
															break;
															case 2 :
																echo "<th>".($from_year + $j).'-'.substr(($from_year + $i),-2)."</th>";
															break;
															case 3 :
																echo "<th>".($from_year + $j).'-'.substr(($from_year + $i),-2)."</th>";
															break;
															case 4 :
																echo "<th>".($from_year + $j).'-'.substr(($from_year + $i),-2)."</th>";
															break;
															case 5 :
																echo "<th>".($from_year + $j).'-'.substr(($from_year + $i),-2)."</th>";
															break;
															case 6 :
																echo "<th>".($from_year + $j).'-'.substr(($from_year + $i),-2)."</th>";
															break;
															case 7 :
																echo "<th>".($from_year + $j).'-'.substr(($from_year + $i),-2)."</th>";
															break;
															case 8 :
																echo "<th>".($from_year + $j).'-'.substr(($from_year + $i),-2)."</th>";
															break;
															case 9 :
																echo "<th>".($from_year + $j).'-'.substr(($from_year + $i),-2)."</th>";
															break;
															case 10 :
																echo "<th>".($from_year + $j).'-'.substr(($from_year + $i),-2)."</th>";
															break;
														}
														
														$i++;
														$j++;
													}

												?>					
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody">
									<?php if (!empty($records)) { ?>
                                        <?php
                                        foreach ($records as $record) :
                                        ?>
                                            <tr>
                                                <td></td>
                                                <td><?php echo $record['industry_name']; ?>
												
												<?php $i = 1; $j = 0;
											
													while($i <= $daterange+1){
														
														switch ($i) {
															case 1 :
																echo "<td>".$record['year1']."</td>";
															break;
															case 2 :
																echo "<td>".$record['year2']."</td>";
															break;
															case 3 :
																echo "<td>".$record['year3']."</td>";
															break;
															case 4 :
																echo "<td>".$record['year4']."</td>";
															break;
															case 5 :
																echo "<td>".$record['year5']."</td>";
															break;
															case 6 :
																echo "<td>".$record['year6']."</td>";
															break;
															case 7 :
																echo "<td>".$record['year7']."</td>";
															break;
															case 8 :
																echo "<td>".$record['year8']."</td>";
															break;
															case 9 :
																echo "<td>".$record['year9']."</td>";
															break;
															case 10 :
																echo "<td>".$record['year10']."</td>";
															break;
														}
														
														$i++;
														$j++;
													}
												?>							
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

