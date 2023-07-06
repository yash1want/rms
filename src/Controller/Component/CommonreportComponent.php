<?php	

	//To access the properties of main controller used initialize function.

	namespace app\Controller\Component;
	use Cake\Controller\Controller;
	use Cake\Controller\Component;
	use Cake\Datasource\ConnectionManager;
	
	use Cake\Controller\ComponentRegistry;
	use Cake\ORM\Table;
	use Cake\ORM\TableRegistry;
	use Cake\ORM\Locator\LocatorAwareTrait;
	use Cake\Datasource\EntityInterface;
	use Cake\Utility\Security;
	use Cake\Core\Configure;
	use SimpleXMLElement;
	
	class CommonreportComponent extends Component {
	
		public $components= array('Session','Sitemails');
		public $controller = null;
		public $session = null;

		public function initialize(array $config): void {
			parent::initialize($config);
			$this->Controller = $this->_registry->getController();
			$this->Session = $this->getController()->getRequest()->getSession();
		}
        
        public function validateServerSide($p1, $p2, $p3, $p4, $p5 = null, $p6 = null, $p7 = null, $p8 = null, $p9 = null, $p10 = null, $p11 = null, $p12 = null, $p13 = null, $p14 = null, $p15 = null) {
            if (!empty($p1))
                $check = $this->validateParameter($p1);
            if (!empty($p2))
                $check = $this->validateParameter($p2);
            if (!empty($p3))
                $check = $this->validateParameter($p3);
            if (!empty($p4))
                $check = $this->validateParameter($p4);
            if (!empty($p5))
                $check = $this->validateParameter($p5);
            if (!empty($p6))
                $check = $this->validateParameter($p6);
            if (!empty($p7))
                $check = $this->validateParameter($p7);
            if (!empty($p8))
                $check = $this->validateParameter($p8);
            if (!empty($p9))
                $check = $this->validateParameter($p9);
            if (!empty($p10))
                $check = $this->validateParameter($p10);
            if (!empty($p11))
                $check = $this->validateParameter($p11);
            if (!empty($p12))
                $check = $this->validateParameter($p12);
            if (!empty($p13))
                $check = $this->validateParameter($p13);
            if (!empty($p14))
                $check = $this->validateParameter($p14);
            if (!empty($p15))
                $check = $this->validateParameter($p15);
        }

        public function validateParameter($param) {
            $blackList = array('SELECT', 'UPDATE', 'INSERT', 'TRUNCATE', 'ALTER', 'CREATE',
                'DROP', 'DELETE', ';', "applet", "body", "bgsound", "basefont", "embed", "'",
                "frameset", "html", "iframe", "ilayer", "object",
                "script", "xml", "prompt", "aspx", ">", "<", "\"", "(", ")", "%", "alert"
            );

            $badWordCount = 0;
            foreach ($blackList as $badWord) {
                if (stristr($param, $badWord)) {
                    $badWordCount++;
                }
            }

            if ($badWordCount > 0) {
                $message = 'Data Tampared. So you are being redirect to homepage. Kindly pass proper arguments and try again.';
                $this->Controller->invalidActivities($message);
                exit;
            }
        }

        public function getReportM07($mineral_names, $state, $district, $from_date, $to_date, $return_type) {

            $this->validateServerSide($mineral_names, $state, $district, $from_date, $to_date, $return_type);

            $mineral_names = ($mineral_names != "") ? "'$mineral_names'" : "''";
            $state_code = ($state != "") ? "'$state'" : "''";
            $district = ($district != "") ? "'$district'" : "''";
            $from_date = ($from_date != "") ? "'$from_date'" : "''";
            $to_date = ($to_date != "") ? "'$to_date'" : "''";
            $return_type = ($return_type != "") ? "'$return_type'" : "''";
	        $connection = ConnectionManager::get("default");

            //CALL SP_ReportM07('', 'GOA', '', '2012-04-01', '2012-05-01', 'MONTHLY' 0, 10000)
			//print_r("CALL SP_ReportM07($mineral_names, $state_code, $district, $from_date, $to_date, $return_type, 0, 10000)"); exit;
	        $returns = $connection->prepare("CALL SP_ReportM07($mineral_names, $state_code, $district, $from_date, $to_date, $return_type, 0, 10000)");

	        $returns->execute();
	        $records = $returns->fetch('assoc');
            return $records['SqlQuery'];

        }
        
        public function getReportM08($mineral_names, $state, $district, $from_date, $to_date, $return_type) {

            $this->validateServerSide($mineral_names, $state, $district, $from_date, $to_date, $return_type);

            $mineral_names = ($mineral_names != "") ? "'$mineral_names'" : "''";
            $state_code = ($state != "") ? "'$state'" : "''";
            $district = ($district != "") ? "'$district'" : "''";
            $from_date = ($from_date != "") ? "'$from_date'" : "''";
            $to_date = ($to_date != "") ? "'$to_date'" : "''";
            $return_type = ($return_type != "") ? "'$return_type'" : "''";
	        $connection = ConnectionManager::get("default");

	        $returns = $connection->prepare("CALL SP_ReportM08($mineral_names, $state_code, $district, $from_date, $to_date, $return_type, 0, 10000)");

	        $returns->execute();
	        $records = $returns->fetch('assoc');
            return $records['SqlQuery'];

        }
        
        public function getReportM09($mineral_names, $state, $district, $from_date, $to_date, $return_type) {

            $this->validateServerSide($mineral_names, $state, $district, $from_date, $to_date, $return_type);

            $mineral_names = ($mineral_names != "") ? "'$mineral_names'" : "''";
            $state_code = ($state != "") ? "'$state'" : "''";
            $district = ($district != "") ? "'$district'" : "''";
            $from_date = ($from_date != "") ? "'$from_date'" : "''";
            $to_date = ($to_date != "") ? "'$to_date'" : "''";
            $return_type = ($return_type != "") ? "'$return_type'" : "''";
	        $connection = ConnectionManager::get("default");

	        $returns = $connection->prepare("CALL SP_ReportM09($mineral_names, $state_code, $district, $from_date, $to_date, $return_type, 0, 10000)");

	        $returns->execute();
	        $records = $returns->fetch('assoc');
            return $records['SqlQuery'];

        }
        
        public function getReportM34($report_no, $mineral, $returnType, $from_date) {

            $this->validateServerSide($report_no, $mineral, $returnType, $from_date);

            $report_no = ($report_no != "") ? "'$report_no'" : "''";
            $mineral = ($mineral != "") ? "'$mineral'" : "''";
            $returnType = ($returnType != "") ? "'$returnType'" : "''";
            $from_date = ($from_date != "") ? "'$from_date'" : "''";
	        $connection = ConnectionManager::get("default");

	        $returns = $connection->prepare("CALL SP_ReportM34($report_no, $mineral, $returnType, $from_date, 0, 10000)");

	        $returns->execute();
	        $records = $returns->fetch('assoc');
            return $records['SqlQuery'];

        }

    }

?>