<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class DirWorkStoppageTable extends Table{

		var $name = "DirWorkStoppage";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		// get reasons array
		// @addedon: 26th FEB 2021 (by Aniket Ganvir)
		public function getReasonsArr(){

			$data = $this->find('all',array('order'=>array('stoppage_sn'=>'ASC')))->toArray();
			return $data;

		}

		//fetch all reasons for work stoppage
		public function fetchReasonsArr() {
			
			// Add language condition to get Reasons array value.
			// Done by pravin bhakare, 22-08-2020
			if($_SESSION['lang']=='hindi'){ $dText = 'चयन करे'; }else{ $dText = 'Select Reason'; }
			
		    $result = $this->find('all')
		            ->select(['id', 'stoppage_sn','stoppage_def','stoppage_def_h'])
		            ->toArray();
		    $returnType = $_SESSION['returnType'];

		    if ($returnType == 'MONTHLY') {
		        $reasonsArr = array('' => $dText);
		    }
		    if (count($result) > 0) {
		        foreach ($result as $tmpArr) {
		            if ($tmpArr['id'] != 1){
						// Add language condition to get Reasons array value. Done by pravin bhakare, 22-08-2020
						if($_SESSION['lang']=='hindi'){ $text = $tmpArr['stoppage_def_h']; }else{ $text = $tmpArr['stoppage_def']; }
		                $reasonsArr[$tmpArr['stoppage_sn']] = $text;
					}	
		        }
		    }
		    return $reasonsArr;
		}
		
		public function postDataValidationMasters($forms_data)
		{
			$returnValue = 1;

			$stoppageSn = $forms_data['stoppage_sn'];
			$stoppageDef = $forms_data['stoppage_def'];

			if ($forms_data['stoppage_sn'] == '') {
				$returnValue = null;
			}
			if ($forms_data['stoppage_def'] == '') {
				$returnValue = null;
			}

			if (strlen($forms_data['stoppage_sn']) > 6) {
				$returnValue = null;
			}
			if (strlen($forms_data['stoppage_def']) > 30) {
				$returnValue = null;
			}
			if (!is_numeric($forms_data['stoppage_sn'])) {
				$returnValue = null;
			}
			if (!preg_match('/^[0-9]+$/', $forms_data['stoppage_sn'])) {
				$returnValue = null;
			}

			if (!preg_match("/^[a-zA-Z0-9\s]+$/", $forms_data['stoppage_def'])) {
				$returnValue = null;
			}
			return $returnValue;
		}

	} 
?>