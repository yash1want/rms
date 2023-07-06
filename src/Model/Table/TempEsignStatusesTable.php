<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class TempEsignStatusesTable extends Table{

		var $name = "TempEsignStatuses";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        //this function is created to save temp esign record, when redirected from CDAC domain to DMI domain
        //to just get that esigning is called, this record will be deleted if esiging done properly till final submit.
        public function saveTempEsignRecord($applicant_id,$return_type,$return_date,$user_type,$pdf_file_name,$username){
            
            $log_id = $_SESSION['log_last_insert_id'];
            $Entity = $this->newEntity(array(
                'applicant_id'=>$applicant_id,
                'return_type'=>$return_type,
                'return_date'=>$return_date,
                'user_type'=>$user_type,
                'pdf_file_name'=>$pdf_file_name,
                'esigning_user'=>$username,
                'log_id' => $log_id,
                'created'=>date('Y-m-d H:i:s')
            ));
            $this->save($Entity);
        }

        // Removing temporary entries from table after successfull esigning
        public function removeTempLog($log_id) {

            $query = $this->query();
            $query->delete()
                ->where(['log_id'=>$log_id])
                ->execute();

        }

	} 
?>