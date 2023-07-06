<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class ReturnDocTable extends Table{

		var $name = "ReturnDoc";			
		public $validate = array();
        
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}
		
        public function getReturnDoc($mineCode, $returnDate) {

            $data = $this->find()
                ->select(['return_pdf', 'return_kml'])
                ->where(['mine_code'=>$mineCode])
                ->where(['return_date IS'=>$returnDate])
                ->where(['return_type'=>'ANNUAL'])
                ->limit(1)
                ->toArray();

            if (count($data) > 0) {
                return $data[0];
            } else {
                $result = array();
                $result['return_pdf'] = '';
                $result['return_kml'] = '';
                return $result;
            }

        }

        public function getReturnId($mineCode, $returnDate) {

            $data = $this->find()
                ->select(['id', 'created_at'])
                ->where(['mine_code'=>$mineCode])
                ->where(['return_date IS'=>$returnDate])
                ->where(['return_type'=>'ANNUAL'])
                ->limit(1)
                ->toArray();

            if (count($data) > 0) {
                return $data[0];
            } else {
                $result = array();
                $result['id'] = '';
                $result['created_at'] = date('Y-m-d H:i:s');
                return $result;
            }

        }

	} 
?>