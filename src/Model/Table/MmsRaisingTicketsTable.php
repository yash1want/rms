<?php 
namespace app\Model\Table;
use Cake\ORM\Table;
use App\Model\Model;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use App\Controller\AdminController;
use App\Controller\MmsController;


class MmsRaisingTicketsTable extends Table{

var $name = "MmsRaisingTickets";			
public $validate = array();

	// set default connection string
public static function defaultConnectionName(): string {
	return Configure::read('conn');
}

	// save Ticket data 

public function saveGenerateTicket($formsData, $editTicketId, $userId) {
	if (!empty($editTicketId)) {

		// print_r('update');die;
		$updateTicket = $this->get($editTicketId);
		if (isset($formsData['add_more_description']) && !empty($formsData['add_more_description'])) {
			$add_more_description_string = implode(',', $formsData['add_more_description']);
			$add_more_description = $add_more_description_string;
		}

		if (isset($_FILES['add_more_attachment']) && !empty($_FILES['add_more_attachment']['name'][0])) {

			// print_r('old file with new file');die;
			$files = $formsData['add_more_attachment'];
			$mmsCntrl = new MmsController;
			$upload_result = array();
			$file_name = '';
			foreach ($files as $file) {
				$file_name = $file->getClientFilename();
				$file_size = $file->getSize();
				$file_type = $file->getClientMediaType();
				$file_local_path = $file->getStream()->getMetadata('uri');
				$ticket_attachment = true;
				$upload_result[] = $mmsCntrl->Customfunctions->fileUploadLib($file_name, $file_size, $file_type, $file_local_path, $ticket_attachment);
			}

			$attachment = array();
			foreach ($upload_result as $result) {
				if (is_array($result) && count($result) == 2) {
					$status = $result[0];
					$file_path = $result[1];
					if ($status == 'success') {
						$attachment[] = $result[1];
					} elseif ($status == 'error') {
						return $result[1];
					}
				}
			}

			if(!empty($formsData['add_more_attachment_name'])){

				
            
             $result = array_merge( $formsData['add_more_attachment_name'],$attachment);
             $attachments_string = implode(',', $result);
		     
		     }else{

		     	

              $attachments_string = implode(',', $attachment);

		     }

		} else {
                 if(!empty($formsData['add_more_attachment_name'])){
              
                     // print_r('only old file');die;
                        
                 	$attachments_string = implode(',', $formsData['add_more_attachment_name']);
			
			       $attachments_string = $attachments_string;
                     
                 }else{

                 	$attachments_string = '';

                     // print_r('no any file');die;
                 }
        }

        // print_r('baher');die;

		$updateTicket->token = $formsData['token'];
		$updateTicket->user_id = $userId;
		$updateTicket->ticket_type = $formsData['ticket_type'];
		$updateTicket->issued_raise_at = $formsData['issued-raise-at'];
		$updateTicket->issued_type = $formsData['issued_type'];
		$updateTicket->form_submission = $formsData['form_submission'];
		$updateTicket->return_month = $formsData['return_month'];
		$updateTicket->return_year = $formsData['return_year'];
		$updateTicket->applicant_id = $formsData['applicant_id'];
		$updateTicket->description = $formsData['description'];
		$updateTicket->add_more_attachment = $attachments_string;
		$updateTicket->add_more_description = $add_more_description;
		$updateTicket->mine_code = $formsData['mine_code'];
		$updateTicket->other_issue_type = $formsData['other_issue_type'];
		$updateTicket->updated_at = date('Y-m-d H:i:s');
		$this->save($updateTicket);

		return 'success';
	} else {

		// print_r('save');die;
		if (isset($_FILES['add_more_attachment']) && !empty($_FILES['add_more_attachment']['name'][0])) {

			
			$files = $formsData['add_more_attachment'];
			$mmsCntrl = new MmsController;
			$upload_result = array();
			foreach ($files as $file) {
				$file_name = $file->getClientFilename();
				$file_size = $file->getSize();
				$file_type = $file->getClientMediaType();
				$file_local_path = $file->getStream()->getMetadata('uri');
				$ticket_attachment = true;
				$upload_result[] = $mmsCntrl->Customfunctions->fileUploadLib($file_name, $file_size, $file_type, $file_local_path, $ticket_attachment);
			}

			$attachment = array();
			foreach ($upload_result as $result) {
				if (is_array($result) && count($result) == 2) {
					$status = $result[0];
					$file_path = $result[1];
					if ($status == 'success') {
						$attachment[] = $result[1];
					} elseif ($status == 'error') {
						return $result[1];
					}
				}
			}

			$attachments_string = implode(',', $attachment);
			$add_more_filename = $attachments_string;
		} else {

			$add_more_filename = $formsData['add_more_attachment'];

			// print_r($add_more_filename);die;
		}

		if (isset($formsData['add_more_description']) && !empty($formsData['add_more_description'])) {
			$add_more_description_string = implode(',', $formsData['add_more_description']);
			$add_more_description = $add_more_description_string;
		}

		$newEntity = $this->newEntity(array(
			'token' => $formsData['token'],
			'user_id' => $userId,
			'reference_no' => $formsData['reference_no'],
			'ticket_type' => $formsData['ticket_type'],
			'issued_raise_at' => $formsData['issued-raise-at'],
			'issued_type' => $formsData['issued_type'],
			'form_submission' => $formsData['form_submission'],
			'return_month' => $formsData['return_month'],
			'return_year' => $formsData['return_year'],
			'applicant_id' => $formsData['applicant_id'],
			'description' => $formsData['description'],
			'mine_code' => $formsData['mine_code'],
			'attachment' => $filename,
			'add_more_attachment' => $add_more_filename,
			'add_more_description' => $add_more_description,
			'other_issue_type' => $formsData['other_issue_type'],
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		));

		$this->save($newEntity);
		return 'success';
	}
}


				     

} 
?>