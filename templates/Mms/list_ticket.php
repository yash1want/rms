<!-- List Ticket, added on 24-04-2023 by Ankush -->
<div class="main-card card fcard mb-1 mt-n3">
    <div class="card-body">
        <div class="rows"><h4 class="text-center font-weight-bold text-alternate">All Ticket List</h4>
         
        </div>
    </div>
</div>
<!-- <div class="main-card card fcard mb-1 mt-n3">
    <div class="card-body">
        <div class="rows"><h4 class="text-center font-weight-bold text-alternate">Search List Data</h4>
            <div class="dataTables_filter">
                
                    
                        <input type="text" id="search-input" placeholder="Search...">
                      
                
            </div>
        </div>
    </div>
</div> -->
<div class="main-card mb-3 card">
		<div class="card-body">			
			<div class="table-responsive">
                
                <?php if(!empty($this->getRequest()->getSession()->read('usr_msg_suc'))){ ?>
                     <div class="alert alert-success fade show" role="alert" id=msg-box><i class="fa fa-check-circle"></i> 
                        <?php echo $this->getRequest()->getSession()->read('usr_msg_suc'); ?>
                    </div>
                <?php $this->getRequest()->getSession()->delete('usr_msg_suc'); } ?>
                
                <?php if(!empty($this->getRequest()->getSession()->read('usr_msg_err'))){ ?>
                    <div class="alert alert-danger fade show" role="alert"><i class="fa fa-check-circle"></i> 
                        <?php echo $this->getRequest()->getSession()->read('usr_msg_err'); ?>
                    </div>
                <?php $this->getRequest()->getSession()->delete('usr_msg_err'); } ?>

                <?php echo $this->Form->create(null); ?>
				<table class="mb-0 table table-striped " id="list">
					<thead class="bg-dark text-white">
                        <tr>
                            <th class="p-1 border-right-1 border-white">#</th>
                            <th class="p-1 border-right-1 border-white">Token No.</th>				<th class="p-1 border-right-1 border-white">Module Name</th>
                            <th class="p-1 border-right-1 border-white">Issue Raise By</th>
                            <th class="p-1 border-right-1 border-white">Issue Type</th>
                            <th class="p-1 border-right-1 border-white">Status</th>
                            <th class="p-1 border-right-1 border-white">Action</th>
                        </tr>
					</thead>                   
                        <tbody>
                            <?php

                            

                                foreach ($listTicket as $each) {
                                    
                                    $reference []= $each['reference_no'];

                                 }
                            
                            $i = 1;
                            foreach ($listTicket as $each) {

                                // print_r($token);die;
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $i; ?></th>
                                    <td><?php echo $each['token']; ?></td>
                                    <td><?php echo $each['ticket_type']; ?></td>
                                    <td><?php echo $each['issued_raise_at']; ?></td>
                                    <td><?php echo $each['issued_type'] . '-' . $each['form_submission']; ?></td>
                                    <?php if ($each['status'] == 'Pending') { ?>
                                        <td><span class="badge badge-warning"><?php echo $each['status']; ?></span></td>
                                    <?php } elseif ($each['status'] == 'Inprocess') { ?>
                                        <td><span class="badge badge-info"><?php echo $each['status']; ?></span></td>
                                    <?php } elseif ($each['status'] == 'Closed') { ?>
                                        <td><span class="badge badge-success"><?php echo $each['status']; ?></span></td>
                                    <?php } ?>

                                    <td>
                                        <div class="btn-group" role="group">
                                            <?php
                                            echo $this->Html->link('', array('controller' => 'mms', 'action' => 'view-ticket', $each['id']), array('class' => 'fa fa-eye btn btn-dark btn-sm ml-1', 'title' => 'View Ticket','data-toggle' => 'tooltip'));
                                             
                                            if ($each['status'] == 'Pending') {
                                                echo $this->Html->link('', array('controller' => 'mms', 'action' => 'ticket-edit', $each['id']), array('class' => 'fa fa-edit btn btn-info btn-sm ml-1', 'title' => 'Edit Ticket Details','data-toggle' => 'tooltip'));
                                            } 
                                            elseif ($each['status'] === 'Closed' &&  in_array($each['token'],$reference)) {

                                                echo $this->Html->link('', array(), array('class' => 'fa fa-plus btn btn-link btn-sm ml-1','id'=>"myButton", 'title' => 'You have already created a ticket with this reference','data-toggle' => 'tooltip'));


                                            } else{

                                                echo $this->Html->link('', array('controller' => 'mms', 'action' => 'ticket-create-with-reference', $each['id']), array('class' => 'fa fa-plus btn btn-primary btn-sm ml-1', 'title' => 'Create New Ticket With This Reference','data-toggle' => 'tooltip'));
                                            }
                                            
                                            ?>
                                            
                                        </div>
                                    </td>
                                </tr>
                                <?php $i++;
                            } ?>

                        </tbody>
				</table>	
                <?php echo $this->Form->end(); ?>

                		
			</div>
		</div>
	</div>
    <script> $('#list').DataTable();</script>
    <?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'usr_id_hidden')); ?>
    <?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'usr_role_id_hidden')); ?>
    <!-- <?php echo $this->Html->script('mms/search_ticket_data.js?version='.$version); ?> -->
    <?php echo $this->Html->script('mms/generate_ticket.js?version='.$version); ?>
