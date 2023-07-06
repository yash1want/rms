<?php	

	//To access the properties of main controller used initialize function.

	namespace app\Controller\Component;
	use Cake\Controller\Controller;
	use Cake\Controller\Component;
	use Cake\Datasource\ConnectionManager;
	
	use Cake\Controller\ComponentRegistry;
	use Cake\ORM\Table;
	use Cake\ORM\TableRegistry;
	use Cake\Datasource\EntityInterface;
	use Cake\Utility\Security;
	use SimpleXMLElement;
	
	class CustomfunctionsComponent extends Component {
	
		public $components= array('Session');
		public $controller = null;
		public $session = null;

		public function initialize(array $config): void {
			parent::initialize($config);
			$this->Controller = $this->_registry->getController();
			$this->Session = $this->getController()->getRequest()->getSession();

			$this->BlacklistChar = $this->getController()->getTableLocator()->get('BlacklistChar');
			$this->CapitalStructure = $this->getController()->getTableLocator()->get('CapitalStructure');
			$this->CostProduction = $this->getController()->getTableLocator()->get('CostProduction');
			$this->DirCountry = $this->getController()->getTableLocator()->get('DirCountry');
			$this->DirDistrict = $this->getController()->getTableLocator()->get('DirDistrict');
			$this->DirMcpMineral = $this->getController()->getTableLocator()->get('DirMcpMineral');
			$this->DirMetal = $this->getController()->getTableLocator()->get('DirMetal');
			$this->DirMineralGrade = $this->getController()->getTableLocator()->get('DirMineralGrade');
			$this->DirProduct = $this->getController()->getTableLocator()->get('DirProduct');
			$this->DirRomGrade = $this->getController()->getTableLocator()->get('DirRomGrade');
			$this->DirWorkStoppage = $this->getController()->getTableLocator()->get('DirWorkStoppage');
			$this->Employment = $this->getController()->getTableLocator()->get('Employment');
			$this->ExplorationDetails = $this->getController()->getTableLocator()->get('ExplorationDetails');
			$this->ExplosiveConsumption = $this->getController()->getTableLocator()->get('ExplosiveConsumption');
			$this->ExplosiveReturn = $this->getController()->getTableLocator()->get('ExplosiveReturn');
			$this->GradeProd = $this->getController()->getTableLocator()->get('GradeProd');
			$this->GradeRom = $this->getController()->getTableLocator()->get('GradeRom');
			$this->GradeSale = $this->getController()->getTableLocator()->get('GradeSale');
			$this->IncrDecrReasons = $this->getController()->getTableLocator()->get('IncrDecrReasons');
			$this->KwClientType = $this->getController()->getTableLocator()->get('KwClientType');
			$this->LeaseReturn = $this->getController()->getTableLocator()->get('LeaseReturn');
			$this->Machinery = $this->getController()->getTableLocator()->get('Machinery');
			$this->MaterialConsumption = $this->getController()->getTableLocator()->get('MaterialConsumption');
			$this->McApplicantDet = $this->getController()->getTableLocator()->get('McApplicantDet');
			$this->McpLease = $this->getController()->getTableLocator()->get('McpLease');
			$this->McUser = $this->getController()->getTableLocator()->get('McUser');
			$this->Mine = $this->getController()->getTableLocator()->get('Mine');
			$this->MineralWorked = $this->getController()->getTableLocator()->get('MineralWorked');
			$this->MiningPlan = $this->getController()->getTableLocator()->get('MiningPlan');
			$this->NSeriesProdActivity = $this->getController()->getTableLocator()->get('NSeriesProdActivity');
			$this->OMineralIndustryInfo = $this->getController()->getTableLocator()->get('OMineralIndustryInfo');
			$this->OProdDetails = $this->getController()->getTableLocator()->get('OProdDetails');
			$this->ORawMatConsume = $this->getController()->getTableLocator()->get('ORawMatConsume');
			$this->OSourceSupply = $this->getController()->getTableLocator()->get('OSourceSupply');
			$this->Prod1 = $this->getController()->getTableLocator()->get('Prod1');
			$this->Prod5 = $this->getController()->getTableLocator()->get('Prod5');
			$this->ProdStone = $this->getController()->getTableLocator()->get('ProdStone');
			$this->Pulverisation = $this->getController()->getTableLocator()->get('Pulverisation');
			$this->RecovSmelter = $this->getController()->getTableLocator()->get('RecovSmelter');
			$this->Reserves = $this->getController()->getTableLocator()->get('Reserves');
			$this->ReservesResources = $this->getController()->getTableLocator()->get('ReservesResources');
			$this->Returns = $this->getController()->getTableLocator()->get('Returns');
			$this->RentReturns = $this->getController()->getTableLocator()->get('RentReturns');
			$this->Rom5 = $this->getController()->getTableLocator()->get('Rom5');
			$this->RomMetal5 = $this->getController()->getTableLocator()->get('RomMetal5');
			$this->RomStone = $this->getController()->getTableLocator()->get('RomStone');
			$this->Sale5 = $this->getController()->getTableLocator()->get('Sale5');
			$this->TblEndUserFinalSubmit = $this->getController()->getTableLocator()->get('TblEndUserFinalSubmit');
			$this->TblFinalSubmit = $this->getController()->getTableLocator()->get('TblFinalSubmit');
			$this->TreesPlantSurvival = $this->getController()->getTableLocator()->get('TreesPlantSurvival');
			$this->WorkStoppage = $this->getController()->getTableLocator()->get('WorkStoppage');
			$this->MmsUser = $this->getController()->getTableLocator()->get('MmsUser');
			$this->DirRegion = $this->getController()->getTableLocator()->get('DirRegion');
		}
		
		
	public function getFormType($returnType,$formNo){
		
		if($returnType=="MONTHLY"){
			
		}elseif($returnType=="ANNUAL"){
			
		}
	}	
		
	public function getYearArr(){
		
		 for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
               $yearsArr[$i] = $i;
         }		 
		 return $yearsArr;
	}
	
	public function getFormArr($form_type){
		
		switch($form_type){
			case 'f':
				$formArr = ['1|2|3|4|8'=>'F1','5'=>'F2','7'=>'F3'];
				break;
			case 'g': 
				$formArr = ['1|2|3|4|8'=>'G1','5'=>'G2','7'=>'G3'];	
				break;
			case 'm':
				$formArr = ['1'=>'M'];
				break;
			case 'l':
				$formArr = ['1'=>'L'];
				break;
			default:
				$formArr = [];
				break;
		}
		
		 return $formArr;
	}
	
	public function getReturnPeriodArr($form_type){
		
		switch($form_type){
			case 'f':
				$periodArr = ['limit20'=>'Latest 20 returns','currmonth'=>'Current Month','l1month'=>'Last 1 month',
							  'l2month'=>'Last 2 month','l3month'=>'Last 3 month','l6month'=>'Last 6 month'];
				break;
			case 'g': 
				$periodArr = ['limit20'=>'Latest 20 returns','curryear'=>'Current Year','l1year'=>'Last 1 Year'];	
				break;
			case 'm':
				$periodArr = ['limit20'=>'Latest 20 returns','currmonth'=>'Current Month','l1month'=>'Last 1 month',
							  'l2month'=>'Last 2 month','l3month'=>'Last 3 month','l6month'=>'Last 6 month'];
				break;
			case 'l':
				$periodArr = ['limit20'=>'Latest 20 returns','curryear'=>'Current Year','l1year'=>'Last 1 Year'];
				break;
			case 'auth':
				$periodArr = ['0'=>'Select','authcurryear'=>'Current Year','authl1year'=>'Last 1 Year'];
				break;	
			default:
				$periodArr = [];
				break;
		}
		
		return $periodArr;
	}
	/*==========Added By Yashwant 05-07-2023 start=============*/
	public function getTicketPeriodArr($status){
		
		switch($status){
			case 'all':
				$periodArr = ['limit20'=>'Latest 20 returns','currmonth'=>'Current Month','l1month'=>'Last 1 month',
							  'l2month'=>'Last 2 month','l3month'=>'Last 3 month','l6month'=>'Last 6 month','curryear'=>'Current Year'];
				break;
			case 'pending': 
				$periodArr = ['limit20'=>'Latest 20 returns','currmonth'=>'Current Month','l1month'=>'Last 1 month',
							  'l2month'=>'Last 2 month','l3month'=>'Last 3 month','l6month'=>'Last 6 month','curryear'=>'Current Year'];	
				break;
			case 'inprocess':
				$periodArr = ['limit20'=>'Latest 20 returns','currmonth'=>'Current Month','l1month'=>'Last 1 month',
							  'l2month'=>'Last 2 month','l3month'=>'Last 3 month','l6month'=>'Last 6 month','curryear'=>'Current Year'];
				break;
			case 'resolve':
				$periodArr = ['limit20'=>'Latest 20 returns','currmonth'=>'Current Month','l1month'=>'Last 1 month',
							  'l2month'=>'Last 2 month','l3month'=>'Last 3 month','l6month'=>'Last 6 month','curryear'=>'Current Year'];
				break;
			default:
				$periodArr = [];
				break;
		}
		
		return $periodArr;
	}
	/*==========Added By Yashwant 06-06-2023 END=============*/

	/*==========Added By Yashwant 06-06-2023 start=============*/

	public function getReturnTicketDateByTicketPeriod($ticketPeriod){
			switch($ticketPeriod){
				
			case 'limit20':						
					$rangeValue = 'limit20';
				break;
			case 'currmonth': 
					$rangeValue = date('m-Y');
				break;
			case 'l1month':
					$rangeValue = date("m-Y",strtotime("-1 month"));
				break;
			case 'l2month':
					$rangeValue = date("m-Y",strtotime("-2 month"));
				break;
			case 'l3month':
					$rangeValue = date("m-Y",strtotime("-3 month"));
				break;
			case 'l6month':
					$rangeValue = date("m-Y",strtotime("-6 month"));
				break;
			case 'curryear':
					$rangeValue = date("Y");
				break;	
			case 'l1year':
					$rangeValue = date("Y",strtotime("-1 year"));
				break;	
			default:
				$rangeValue = '';
				break;
		}
		
		$from_date = '';
		$to_date = '';
			
		$rangeValue = str_replace('/', '-', $rangeValue);	
		$count = count(explode('-',$rangeValue));
		
		//print_r($rangeValue);  print_r($count); exit; 
		
		/*Yashwant 27-06-2023 add start*/
		if($rangeValue != 'limit20' and $ticketPeriod=='currmonth' and $count == 2){
			
			$from_date = '31-'.date('m-Y');
			$to_date = '01-'.$rangeValue;
			//echo"<pre>";print_r($from_date);  echo"<pre>";print_r($to_date); exit; 
		}
		else if($rangeValue != 'limit20' and $count == 2){
			$from_date = '01-'.date('m-Y');
			$to_date = '01-'.$rangeValue;
		}
		/*Yashwant 27-06-2023 add end*/
		/*Yashwant 04-07-2023 add START*/
		elseif($rangeValue != 'limit20' and $count == 1){
			
			$from_date = '01-04-'.date("Y")+1;
			$to_date = '01-04-'.$rangeValue;
		}
		/*Yashwant 04-07-2023 add END*/
		$from_date = $this->ticketDateValidation($from_date);
		$to_date = $this->ticketDateValidation($to_date);

		return array($to_date,$from_date);
	}

	/*Yashwant 27-06-2023 Changes this function--*/
	public function getTicketDateByReturnRange($date){
		$date = str_replace('/', '-', $date);	
		//echo"<pre>";print_r($date);
		$count = count(explode('-',$date));
		//echo"<pre>";print_r($count);exit;
		$retrundate = '';
		if($count == 2){
			$retrundate = '31-'.$date;
		}
		/*elseif($count == 1){			
			$retrundate = '01-04-'.$date;
			//echo"<pre>";print_r($retrundate);exit;
		}*/
		
		$retrundate = $this->ticketDateValidation($retrundate);
		return $retrundate;
	}
	/*Yashwant 27-06-2023 Start--*/
	public function getTicketDateByReturnFromRange($date){
		$date = str_replace('/', '-', $date);	
		$count = count(explode('-',$date));
		//echo"<pre>";print_r($count);exit;
		$retrundate = '';
		if($count == 2)
		{
			$retrundate = '01-'.$date;
		}

		$retrundate = $this->ticketDateValidation($retrundate);
		return $retrundate;
	}
	/*Yashwant 27-06-2023 END--*/

	public function ticketDateValidation($date){
		
		$validDate = $date;
		
		if(!empty($date)){
			
			$explode = explode(' ',$date);
			
			$date = str_replace('/', '-', $explode[0]);
			
			//if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",'2022-02-28')) {
			if (preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$date)) {
				 
				 $validDate  = date('Y-m-d', strtotime($date));		  
			
			}/* elseif (preg_match("/^(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])-[0-9]{4}$/",$date)) {
				 
				 $validDate  = date('Y-m-d', strtotime($date));
			 
			 }*/ 
			 else {
				 
				  $validDate  = 'invalid';
			 }
			 
			 
			 if(count($explode) == 2 and $validDate != 'invalid')
			 {
				 
				 $validDate = $validDate.' '.$explode[1];
			
			}
			elseif($validDate == 'invalid')
			{
				
				$msg = "Date format is Tampared. So you are being logout from portal.";
				$this->Controller->invalidActivities($msg);
			 }
		
		}
		//print_r($validDate);die;
		
		return $validDate;
		 
	}
	/*==========Added By Yashwant 06-06-2023 END=============*/
	
	public function getReturnDateByReturnPeriod($returnPeriod){
					
			$form_type = $this->Session->read('sess_form_type');
						
			switch($returnPeriod){
				
			case 'limit20':						
					$rangeValue = 'limit20';
				break;
			case 'currmonth': 
					$rangeValue = date('m-Y');
				break;
			case 'l1month':
					$rangeValue = date("m-Y",strtotime("-1 month"));
				break;
			case 'l2month':
					$rangeValue = date("m-Y",strtotime("-2 month"));
				break;
			case 'l3month':
					$rangeValue = date("m-Y",strtotime("-3 month"));
				break;
			case 'l6month':
				    $rangeValue = date("m-Y",strtotime("-6 month"));
				break;
			case 'curryear':
					$rangeValue = date("Y");
				break;	
			case 'l1year':
					$rangeValue = date("Y",strtotime("-1 year"));
				break;	
			default:
				$rangeValue = '';
				break;
		}
		
		$from_date = '';
		$to_date = '';
			
		$rangeValue = str_replace('/', '-', $rangeValue);	
		$count = count(explode('-',$rangeValue));
		
		//print_r($rangeValue);  print_r($count); exit; 
		
		if($rangeValue != 'limit20' and $count == 2){
			
			$from_date = '01-'.date('m-Y');
			$to_date = '01-'.$rangeValue;
			
		}elseif($rangeValue != 'limit20' and $count == 1){
			
			$from_date = '01-04-'.date("Y");
			$to_date = '01-04-'.$rangeValue;
		}
		
		
		
		$from_date = $this->dateValidation($from_date);
		$to_date = $this->dateValidation($to_date);

		
		return array($to_date,$from_date);
	}
	
	public function getReturnsDateByReturnRange($date){
		
		$date = str_replace('/', '-', $date);	
		$count = count(explode('-',$date));
		$retrundate = '';
		if($count == 2){
			$retrundate = '01-'.$date;
		}elseif($count == 1){			
			$retrundate = '01-04-'.$date;
		}
		
		$retrundate = $this->dateValidation($retrundate);
		
		return $retrundate;
	}
	
	// validate the date format in dd-mm-YYYY
	
	public function dateValidation($date){
		
		$validDate = $date;
		
		if(!empty($date)){
			
			$explode = explode(' ',$date);
			
			$date = str_replace('/', '-', $explode[0]);
			
			//if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",'2022-02-28')) {
			if (preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$date)) {
				 
				 $validDate  = date('Y-m-d', strtotime($date));		  
			
			}/* elseif (preg_match("/^(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])-[0-9]{4}$/",$date)) {
				 
				 $validDate  = date('Y-m-d', strtotime($date));
			 
			 }*/ 
			 else {
				 
				  $validDate  = 'invalid';
			 }
			 
			 
			 if(count($explode) == 2 and $validDate != 'invalid'){
				 
				 $validDate = $validDate.' '.$explode[1];
			
			}elseif($validDate == 'invalid'){
				
				$msg = "Date format is Tampared. So you are being logout from portal.";
				$this->Controller->invalidActivities($msg);
			 }
		
		}
		//print_r($validDate);die;
		
		return $validDate;
		 
	}
	
	
		/**
		 * get the chemical representation formula for the mineral
		 * @added on: 02nd MAR 2021 (by Aniket Ganvir)
		 */
		public function getChemRep($mineral_name){

	        $mineral = strtolower(str_replace(' ', '_', $mineral_name));

	        $chem_rep = $mineral;
	        switch ($mineral) {
	            case ("iron_ore"):
	                $chem_rep = "Fe";
	                break;

	            case ("manganese_ore"):
	                $chem_rep = "Mn";
	                break;

	            case ("bauxite"):

	            case ("laterite"):
	                $chem_rep = "Al<sub>2</sub>O<sub>3</sub>";
	                break;

	            case ("chromite"):
	                $chem_rep = "Cr<sub>2</sub>O<sub>3</sub>";
	                break;
	        }

	        return $chem_rep;

		}

		/**
		 * get filtered returns count for statistics purpose
		 * @addedon: 04th MAR 2021 (by Aniket Ganvir)
		 */
		public function getFilteredReturnsCount($mine_code, $mms_user_id, $jurisdiction, $area, $state, $district, $year, $month, $form, $referred_total, $status, $role = 0){

			$this->validateServerSide($mine_code, $mms_user_id, $jurisdiction, $area, $state, $district, $year, $month, $form, $referred_total, $status, $role);

	        $mine_code = ($mine_code != "") ? "'$mine_code'" : "''";
	        $jurisdiction = ($jurisdiction != "") ? "'$jurisdiction'" : "''";
	        $area = ($area != "") ? "'$area'" : "''";
	        $state = ($area != "") ? "'$state'" : "''";
	        $district = ($district != "") ? "'$district'" : "''";
	        $year = ($year != "") ? "'$year'" : "''";
	        $month = ($year != "") ? "'$month'" : "''";
	        $form = ($form != "") ? "'$form'" : "''";
	        $referred_total = ($referred_total != "") ? "'$referred_total'" : "''";
	        $status = ($status != "") ? "'$status'" : "''";
	        $mms_user_id1 = ($mms_user_id != "") ? "'$mms_user_id'" : "'0'";

	        $connection = ConnectionManager::get("default");			
	        $returns = $connection->prepare("CALL SP_FileReturns($mine_code, $mms_user_id1, $jurisdiction, $area, $state, $district, $year, $month, $form, $referred_total, $status, 1, 0, 10,$role)");

	        $returns->execute();
	        $returns = $returns->fetch('assoc');

	        $total_records = $returns['_TotalRows']; 

	        return $total_records;

		}

		/**
		 * get annual returns count for statistics purpose
		 * @addedon: 04th MAR 2021 (by Aniket Ganvir)
		 */
	    public function getAnnualReturnsCount($mine_code, $mms_user_id, $jurisdiction, $area, $state, $district, $year, $form, $referred_total, $status, $role) {

	        $this->validateServerSide($mine_code, $mms_user_id, $jurisdiction, $area, $state, $district, $year, $form, $referred_total, $status, $role);

	        $mms_user_id1 = ($mms_user_id != "") ? "'$mms_user_id'" : "'0'";
	        $mine_code = ($mine_code != "") ? "'$mine_code'" : "''";
	        $jurisdiction = ($jurisdiction != "") ? "'$jurisdiction'" : "''";
	        $area = ($area != "") ? "'$area'" : "''";
	        $state = ($area != "") ? "'$state'" : "''";
	        $district = ($district != "") ? "'$district'" : "''";
	        $year = ($year != "") ? "'$year'" : "''";
	        //$month = ($year != "") ? "'$month'" : "''";
	        $form = ($form != "") ? "'$form'" : "''";
	        $referred_total = ($referred_total != "") ? "'$referred_total'" : "''";
	        $status = ($status != "") ? "'$status'" : "''";
	        $mms_user_id1 = ($mms_user_id != "") ? "'$mms_user_id'" : "'0'";
	        $role = ($role != "") ? "'$role'" : "'0'";

	        $connection = ConnectionManager::get("default");
	        $returns = $connection->prepare("CALL SP_AnnualFileReturns($mine_code, $mms_user_id1, $jurisdiction, 
	            $area, $state, $district, $year, $form, $referred_total, $status, 1, 0, 10,$role)");

	        $returns->execute();
	        $returns = $returns->fetch('assoc');

	        $total_records = $returns['_TotalRows'];

	        return $total_records=0;
	    }

	    /**
	     * get shorten statistics count (like 1452 = 1k)
	     * @addedon: 04th MAR 2021 (by Aniket Ganvir)
	     */
	    public function getShortStatsCount($count){

	    	if(strlen((string)$count) > 3) {

	    		$count = substr((string)$count, 0, -3) . "k";

	    	}

	    	return $count;

	    }


	    /**
	     * get shorten statistics count (like 1452451 = 1m)
	     * @addedon: 04th MAR 2021 (by Aniket Ganvir)
	     */
	    public function getShortStatsCountM($count){

	    	if(strlen((string)$count) > 6) {

	    		$count = substr((string)$count, 0, -6) . "m";

	    	}

	    	return $count;

	    }

	    /**
	     * GET NEXT RETURNS FORM REDIRECTION LINK
	     * ALONG WITH MINERAL NAME
	     * @addedon 11th MAR 2021 (by Aniket Ganvir)
	     */
	    public function getNextFormLink(){

	    	$part_no = $this->Session->read('partId');
			$form_id = $this->Session->read('formId');

			$f_link = $this->Session->read('fLink');
			$mineralName = $this->Session->read('mineralName');

			$currentLink = ($mineralName != '')  ? "/monthly/activeForm/".$part_no."/".$form_id."/".$mineralName : "/monthly/activeForm/".$part_no."/".$form_id;

			$currentFLink = array_search($currentLink, $f_link);
			$nextFLink = $f_link[$currentFLink+'1'];
			return $nextFLink;

	    }

	    /**
	     * GET ALL COLUMN NAMES OF TABLE
	     * @addedon 12th MAR 2021 (by Aniket Ganvir)
	     */
	    public function getTableColumns($tableName){

	        $conn = ConnectionManager::get("default");

	        // Create a schema collection.
	        $collection = $conn->getSchemaCollection();

	        // Get a single table (instance of Schema\TableSchema)
	        $tableSchema = $collection->describe($tableName);
	        
	        //Get columns list from table
	        $columns = $tableSchema->columns();
	        
	        //Empty array for fields
	        $fields = [];
	        
	        //iterate columns
	        foreach ( $columns as $key => $val ){
	            $fields[ $val ] = "";
	        }

	        return $fields;

	    }

	    // monthly select return form validations
	    // @addedon: 25th MAR 2021 (by Aniket Ganvir)
	    public function selectReturnValidation($post_data){

	    	$result = false;
	    	$month = $post_data['month'];
	    	$year = $post_data['year'];

	    	if($month == '' || $month == null){
	    		$result = "Invalid month selected";
	    	} else if($year == '' || $year == null) {
	    		$result = "Invalid year selected";
	    	}

	    	return $result;

	    }
		
		/**
		 * ANNUAL SELECT RETURN FORM VALIDATIONS
		 * @addedon: 25th MAR 2021 (by Aniket Ganvir)
		 */
	    public function selectAnnualReturnValidation($params){

	    	$result = false;
	    	$year = $params['year'];

	    	if($year == '' || $year == null) {
	    		$result = "Invalid year selected";
	    	}

	    	return $result;

	    }

	    /**
	     * CREATING COMMUNICATION REASON/REMARK LABELS AS PER CURRENT USER ROLE
	     * @addedon: 12th APR 2021 (by Aniket Ganvir)
	     */
	    public function getCommentLabel($mmsUserRole){

	    	$label = array();
	    	if(in_array($mmsUserRole, array('2','8'))){

	    		$label['title'] = "Communications with Mine/End User";
	    		$label['third_person'] = "Primary";
	    		$label['comment'] = "reason";
	    		$label['comment_date'] = "reason_date";
	    		$label['other_comment'] = "primary_rsn";
	    		$label['other_comment_date'] = "primary_date";

	    	} else if(in_array($mmsUserRole, array('3','9'))) {

	    		$label['title'] = "Communications with Supervisor";
	    		$label['third_person'] = "Supervisor";
	    		$label['comment'] = "primary_rsn";
	    		$label['comment_date'] = "primary_date";
	    		$label['other_comment'] = "reason";
	    		$label['other_comment_date'] = "reason_date";

	    	} else {

	    		$label['title'] = "Communications with Scrutinizer";
	    		$label['third_person'] = "Primary";
	    		$label['comment'] = "reply";
	    		$label['comment_date'] = "reply_date";
	    		$label['other_comment'] = "reason";
	    		$label['other_comment_date'] = "reason_date";

	    	}

	    	return $label;

	    }

	    public function formReturnTitle(){

	    	$return_date = $this->Session->read("returnDate");
			$month = strtoupper(date('F',strtotime($return_date)));
			$year = $this->Session->read("mc_sel_year");
			$year_next = $year + 1;
			$return_type = strtoupper($this->Session->read('returnType'));

    		if($this->Session->read('lang') == 'english'){

				$file_return_title = ($return_type == 'MONTHLY') ? $month . " - " . $year : $year . " - " . $year_next;
	    		$title_format = $return_type." RETURN [ ".$file_return_title." ]";

    		} else {

				$m = date('m', strtotime($return_date));
	    		$hindi_month = array('01'=>'जनवरी', '02'=>'फरवरी', '03'=>'मार्च', '04'=>'अप्रैल', '05'=>'मई', '06'=>'जून', '07'=>'जुलाई', '08'=>'अगस्त', '09'=>'सितम्बर', '10'=>'अक्टूबर', '11'=>'नवम्बर', '12'=>'दिसम्बर');
				$return_type_hindi = array('MONTHLY'=>'मासिक', 'ANNUAL'=>'वार्षिक');
	    		$h_month = $hindi_month[$m];
				$r_type = $return_type_hindi[$return_type];
				$file_return_title = ($return_type == 'MONTHLY') ? $h_month . " - " . $year : $year . " - " . $year_next;
	    		$title_format = $r_type." विवरणी [ ".$h_month." - ".$year." ]";

    		}

    		$this->Session->write('form_return_date',$title_format);

	    }
		
		
		public function validateServerSide($p1=null, $p2=null, $p3=null, $p4=null, $p5=null, $p6=null, $p9=null, 
												  $p10=null, $p11=null, $p12=null, $p13=null, $p14=null, $p15=null) {
		   $filterValue = 'not_tampared';
		   
		   if (!empty($p1))
				$check1 = self::validateParameter($p1);
			else
				$check1 = 'not_tampared';
			
			if (!empty($p2))
				$check2 = self::validateParameter($p2);
			else
				$check2 = 'not_tampared';
			
			if (!empty($p3))
				$check3 = self::validateParameter($p3);
			else
				$check3 = 'not_tampared';
			
			if (!empty($p4))
				$check4 = self::validateParameter($p4);
			else
				$check4 = 'not_tampared';
			
			if (!empty($p5))
				$check5 = self::validateParameter($p5);
			else
				$check5 = 'not_tampared';
			
			if (!empty($p6))
				$check6 = self::validateParameter($p6);
			else
				$check6 = 'not_tampared';
			
			if (!empty($p7))
				$check7 = self::validateParameter($p7);
			else
				$check7 = 'not_tampared';
			
			if (!empty($p8))
				$check8 = self::validateParameter($p8);
			else
				$check8 = 'not_tampared';
			
			if (!empty($p9))
				$check9 = self::validateParameter($p9);
			else
				$check9 = 'not_tampared';
			
			if (!empty($p10))
				$check10 = self::validateParameter($p10);
			else
				$check10 = 'not_tampared';
			
			if (!empty($p11))
				$check11 = self::validateParameter($p11);
			else
				$check11 = 'not_tampared';
			
			if (!empty($p12))
				$check12 = self::validateParameter($p12);
			else
				$check12 = 'not_tampared';
			
			if (!empty($p13))
				$check13 = self::validateParameter($p13);
			else
				$check13 = 'not_tampared';
			
			if (!empty($p14))
				$check14 = self::validateParameter($p14);
			else
				$check14 = 'not_tampared';
			
			if (!empty($p15))
				$check15 = self::validateParameter($p15);
			else
				$check15 = 'not_tampared';
			
			
			if($check1=='tampared' || $check2=='tampared' ||$check3=='tampared' ||$check4=='tampared' ||$check5=='tampared' ||
				$check6=='tampared' ||$check7=='tampared' ||$check8=='tampared' ||$check9=='tampared' ||$check10=='tampared' ||
				$check11=='tampared' ||$check12=='tampared' ||$check13=='tampared' ||$check14=='tampared' ||$check15=='tampared')
			{
				$filterValue = 'tampared';
			}	
			
			return $filterValue;
		}	

		public function validateParameter($param) {
			
			$returnValue = 'not_tampared';			
			
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
				
				$msg = "Filter Data are Tampared. So you are being logout from portal.";
				$this->Controller->invalidActivities($msg);
				//$returnValue = 'tampared';
			
			}else{
				return  $returnValue;
			}
			
			
		}
		
		public function returnStatus($userRole,$status){
			
			switch ($userRole) {
				case 1: 
						$submitted = '';
						$pending = '0|1|2';
						$approved = '3';
						$referredback = '4';						
				break;
				case 2: 
						$submitted = '';
						$pending = '0|1|2';
						$approved = '3';
						$referredback = '4';	
				break;
				case 3: 
						$submitted = '';
						$pending = '0';
						$approved = '1|3';
						$referredback = '2|4';
				break;
				case 4: 
						$submitted = '';
						$pending = '0|1|2';
						$approved = '3';
						$referredback = '4';	
				break;
				case 5: 
						$submitted = '';
						$pending = '0|1|2';
						$approved = '3';
						$referredback = '4';	
				break;
				case 6: 
						$submitted = '';
						$pending = '0|1|2';
						$approved = '3';
						$referredback = '4';	
				break;
				case 7: 
						$submitted = '';
						$pending = '0|1|2';
						$approved = '3';
						$referredback = '4';	
				break;
				case 8: 
						$submitted = '';
						$pending = '0|1|2';
						$approved = '3';
						$referredback = '4';	
				break;
				case 9: 
						$submitted = '';
						$pending = '0';
						$approved = '1|3';
						$referredback = '2|4';
				break;
				case 10: 
						$submitted = '';
						$pending = '0|1|2';
						$approved = '3';
						$referredback = '4';	
				break;
				case 11: 
						$submitted = '';
						$pending = '0|1|2';
						$approved = '3';
						$referredback = '4';	
				break;
				case 20: 
						$submitted = '';
						$pending = '0|1|2';
						$approved = '3';
						$referredback = '4';	
				break;
			}
		
			if($status=='s'){ return $submitted; }
			if($status=='p'){ return $pending; }
			if($status=='r'){ return $referredback; }
			if($status=='a'){ return $approved; }
		
		}
		
		
		public function counts($counts){
			
			$total = 0;
			$pending = 0;
			$referredback = 0;
			$approved = 0;
			
			foreach($counts as $each){
				
				if($each['status']== 'total'){
					$total = $each['counts'];
				}
				if($each['status']== 'pending'){
					$pending = $each['counts'];
				}
				if($each['status']== 'referredback'){
					$referredback = $each['counts'];
				}
				if($each['status']== 'approved'){
					$approved = $each['counts'];
				}
			}
			
			return array($total,$pending,$referredback,$approved);
			
		}


		public function executeUserleftnav($mine_code, $mineral_name = null){

			$returnType = $this->Session->read('returnType');

			//========CONTAINS THE LIST OF ALL THE MINERAL OF THE PARTICULAR MINE=======
			$minerals = $this->MineralWorked->fetchMineralInfo($mine_code);
			foreach($minerals as $mineral){
				$mineralArr[] = $mineral['mineral_name'];	
			}
	
			$this->Session->write('mineralArr',$mineralArr);
	
			$this->sectionFillStatus($mine_code);

			// set final submit button status
			if ($returnType == 'MONTHLY') {
				$finalSubmitButtonStatus = $this->finalSubmitButton();
			} else {
				$finalSubmitButtonStatus = $this->finalSubmitAnnualButton();
			}
			$this->getController()->set('final_submit_button', $finalSubmitButtonStatus);
	
			//=====================$mineralWorked CONTAINS THE WHOLE ARRAY AND HENCE WE 
			//=============================ARE STORIG WHOLE ARRAY TO SESSION============
			$mineralWorked = $minerals[0];
			$this->getController()->set('primary_min', $mineralWorked);
	
			//=========CODE RETURN TRUE IF DATA IS FOUND IN THE DB ELSE FALSE===========
			//code for HEMATITE, MAGNETITE:start
			$returnYear = $this->Session->read('mc_sel_year');
			

			if($returnType == "ANNUAL"){

				$returnDate = $returnYear . "-04-01";
			}else{
				$returnMonth = $this->Session->read('mc_sel_month');
				$returnDate = $returnYear . "-" . $returnMonth . "-01";
			}
			
			$minHematite = $this->Prod1->fetchIronTypeProduction($mine_code, $returnType, $returnDate, 'iron_ore', 'hematite');
			$minMagnetite = $this->Prod1->fetchIronTypeProduction($mine_code, $returnType, $returnDate, 'iron_ore', 'magnetite');
	
			$replyStatus = $this->TblFinalSubmit->checkReplyStatus($mine_code, $returnType, $returnDate);
			$this->getController()->set('replyStatus',$replyStatus);
	
			if($minHematite == true){
				$is_hematite = true;
			} else {
				$is_hematite = false;
			}
	
			if($minMagnetite == true){
				$is_magnetite = true;
			} else {
				$is_magnetite = false;
			}
			$this->getController()->set('is_hematite',$is_hematite);
			$this->getController()->set('is_magnetite',$is_magnetite);
			$this->Session->write('is_hematite',$is_hematite);
			$this->Session->write('is_magnetite',$is_magnetite);
	
			//======STORING THE VARIABLE IN BOTH UPPER CASE AND IN LOWER CASE IN $this->partIIM1
			//========OUTPUT OF THE BELOW CODE PRITING IS: Array ( [0] => MICA [1] => mica ) 
			$mineralWorked['mineral_name'] = trim($mineralWorked['mineral_name']);
			$partIIM1 = array($mineralWorked['mineral_name'], strtolower(str_replace(' ','_', $mineralWorked['mineral_name'])));
			
			$partIIM1['formNo'] = $this->DirMcpMineral->getFormNumber($partIIM1[1]);
	
			$this->getController()->set('partIIM1',$partIIM1);
	
			//=============GETS THE FORM TYPE FROM THE SESSION LIKE F5==================
			$formType = $this->Session->read('mc_form_type');
	
			//=====STORING THE OTHER MINERALS IF PRESENT IN THE $this->partIIMOther[] AS
			//=========( [0] => Array ( [0] => COPPER ORE [1] => copper_ore ))==========
			$partIIMOther = [];
			if(count($minerals) > 1){
				$otherMinerals = [];
				for($i=1; $i<count($minerals); $i++){
					$otherMinerals[] = $minerals[$i]['mineral_name'];
				}
	
				foreach($otherMinerals as $otrMineral){
					$otrMineral = trim($otrMineral);
					if($otrMineral != ''){
						$partIIMOther[] = array($otrMineral, strtolower(str_replace(' ','_', $otrMineral)));
					}
				}
				
			}
			foreach ($partIIMOther as $key=>$value){
				$partIIMOther[$key]['formNo'] = $this->DirMcpMineral->getFormNumber($partIIMOther[$key][0]);
			}
			
			$this->getController()->set('partIIMOther',$partIIMOther);

			//section view
			$section_mode = '';
			if(null !== $this->Session->read('form_status')){
				if($this->Session->read('form_status') == 'edit'){
					$section_mode = 'read';
				} else {
					$section_mode = $this->Session->read('form_status');
				}
			}
			$this->Session->write('section_mode', $section_mode);

			//show grades as per primary minerals
			$mineralArr = $this->Session->read('mineralArr');
			$rom_grade = false;
			$mineral_sp = strtoupper(str_replace('_', ' ', $mineral_name));

			if(in_array($mineralArr[0], array('IRON ORE', 'CHROMITE'))){

				if($mineral_sp == $mineralArr[0]){
					$rom_grade = true;
				}

			}
			$this->getController()->set('rom_grade', $rom_grade);

			if ($returnType == 'ANNUAL') {
				$allMin = $this->Session->read('mineralArr');
				$this->getController()->set('allMin',$allMin);
			}
			
		}
	
		public function sectionFillStatus($mine_code){

			//print_r("expression");die;
			
			$returnType = $this->Session->read('returnType');
			$returnDate = $this->Session->read('returnDate');
			$formStatus = (null !== $this->Session->read('form_status')) ? $this->Session->read('form_status') : null;
	
			$app_sec = (null !== $this->Session->read('approved_sections')) ? $this->Session->read('approved_sections') : array();
			
			if(null !== $this->Session->read('return_id')){
				$return_id = $this->Session->read('return_id');
			} else {
				$return_id = $this->TblFinalSubmit->getLatestReturnId($mine_code, $returnDate, $returnType);
			}

			$return_id = ($return_id == null) ? 0 : $return_id;
			$reason = array();
		
			if ($returnType == 'MONTHLY') {
				//PART I: Details of the Mine
				$reason['mine'] = $this->TblFinalSubmit->getReason($return_id, '', '', 1, 'applicant');
				$reason['status']['mine'] = (isset($reason['mine']['commented']) && $reason['mine']['commented'] == '1') ? 'success' : 'pending';
				$reason['status']['mine'] = ($formStatus == 'read') ? 'success' : $reason['status']['mine'];
				$secStatus['mine'] = (isset($app_sec['partI'][1]) && $app_sec['partI'][1] == 'Rejected') ? $reason['status']['mine'] : 'success';
		
				//PART I: Name and Address
				$reason['name_address'] = $this->TblFinalSubmit->getReason($return_id, '', '', 2, 'applicant');
				$reason['status']['name_address'] = (isset($reason['name_address']['commented']) && $reason['name_address']['commented'] == '1') ? 'success' : 'pending';
				$reason['status']['name_address'] = ($formStatus == 'read') ? 'success' : $reason['status']['name_address'];
				$secStatus['name_address'] = (isset($app_sec['partI'][2]) && $app_sec['partI'][2] == 'Rejected') ? $reason['status']['name_address'] : 'success';
		
				//PART I: Details of Rent/Royalty
				$reason['rent'] = $this->TblFinalSubmit->getReason($return_id, '', '', 3, 'applicant');
				$reason['status']['rent'] = (isset($reason['rent']['commented']) && $reason['rent']['commented'] == '1') ? 'success' : 'pending';
				$reason['status']['rent'] = ($formStatus == 'read') ? 'success' : $reason['status']['rent'];
				$rentDetail = $this->RentReturns->getRentReturnsDetails($mine_code, $returnType, $returnDate);
				$rentDetailStatus = (isset($app_sec['partI'][3]) && $app_sec['partI'][3] == 'Rejected') ? $reason['status']['rent'] : (($rentDetail['id'] != '') ? "success" : "error");
				$secStatus['rent'] = $rentDetailStatus;
		
				//PART I: Details on Working
				$reason['working_detail'] = $this->TblFinalSubmit->getReason($return_id, '', '', 4, 'applicant');
				$reason['status']['working_detail'] = (isset($reason['working_detail']['commented']) && $reason['working_detail']['commented'] == '1') ? 'success' : 'pending';
				$reason['status']['working_detail'] = ($formStatus == 'read') ? 'success' : $reason['status']['working_detail'];
				$workDetail = $this->WorkStoppage->fetchWorkingDetails($mine_code, $returnType, $returnDate);
				$workDetailStatus = (isset($app_sec['partI'][4]) && $app_sec['partI'][4] == 'Rejected') ? $reason['status']['working_detail'] : (($workDetail['id'] != '') ? "success" : "error");
				$secStatus['working_detail'] = $workDetailStatus;
		
				//PART I: Average Daily Employment
				$reason['daily_average'] = $this->TblFinalSubmit->getReason($return_id, '', '', 5, 'applicant');
				$reason['status']['daily_average'] = (isset($reason['daily_average']['commented']) && $reason['daily_average']['commented'] == '1') ? 'success' : 'pending';
				$reason['status']['daily_average'] = ($formStatus == 'read') ? 'success' : $reason['status']['daily_average'];
				$openCastId = '5';
				$belowId = '1';
				$aboveId = '9';
				$openArr = $this->Employment->fetchEmpWageDetails($mine_code, $returnType, $returnDate, $openCastId);
				$belowArr = $this->Employment->fetchEmpWageDetails($mine_code, $returnType, $returnDate, $belowId);
				$aboveArr = $this->Employment->fetchEmpWageDetails($mine_code, $returnType, $returnDate, $aboveId);
				$openArrStatus = ($openArr['id'] != '') ? "1" : "0";
				$belowArrStatus = ($belowArr['id'] != '') ? "1" : "0";
				$aboveArrStatus = ($aboveArr['id'] != '') ? "1" : "0";
				$secStatus['daily_average'] = (isset($app_sec['partI'][5]) && $app_sec['partI'][5] == 'Rejected') ? $reason['status']['daily_average'] : (($openArrStatus == '1' && $belowArrStatus == '1' && $aboveArrStatus == '1') ? "success" : "error");
		
				//PART II:
				$mcFormMain = $this->Session->read('mc_form_main');
				$mineralArr = $this->Session->read('mineralArr');
				$minHematite = $this->Prod1->fetchIronTypeProduction($mine_code, $returnType, $returnDate, 'iron_ore', 'hematite');
				$minMagnetite = $this->Prod1->fetchIronTypeProduction($mine_code, $returnType, $returnDate, 'iron_ore', 'magnetite');
		
				if($minHematite == true){
					$is_hematite = true;
				} else {
					$is_hematite = false;
				}
		
				if($minMagnetite == true){
					$is_magnetite = true;
				} else {
					$is_magnetite = false;
				}

				foreach($mineralArr as $mineral){
		
					$mineral_name = strtolower($mineral);
					$mineral_sp = str_replace('_',' ',$mineral_name);
					$mineral_ul = str_replace(' ','_',$mineral_name); // mineral underscore lowercase

					//set sub mineral
					if($mineral_name == 'iron ore'){
						if($is_hematite == true){
							$ironSubMin = 'hematite';
						} else if($is_magnetite == true){
							$ironSubMin = 'magnetite';
						} else {
							$ironSubMin = '';
						}
					} else {
						$ironSubMin = '';
					}
					
					$formNo = $this->DirMcpMineral->getFormNumber($mineral);
					$formNoNew = (in_array($formNo, array('1','2','3','4','8'))) ? 1 : (($formNo == 5) ? 2 : 3);
					$reason_no = array();
					if ($formNo == 6){
						$reason_no['deduct_detail'] = 2;
						$reason_no['sale_despatch'] = 3;
					}
					else if ($formNo == 5){
						$reason_no['deduct_detail'] = 6;
						$reason_no['sale_despatch'] = 7;
					}
					else {
						$reason_no['deduct_detail'] = 3;
						$reason_no['sale_despatch'] = 4;
					}
		
					// if($mcFormMain == 1){
					if($formNoNew == 1){
		
						//PART II: TYPE OF ORE
						$oreTypeStatus = ($is_hematite == true || $is_magnetite == true) ? "success" : "error";
						$secStatus['ore_type'][$mineral_name] = $oreTypeStatus;
		
						//PART II: Production / Stocks (ROM) (Form F1)
						// if($mineral_name == 'iron ore'){
						// 	if($is_hematite == true){
								$reason['rom_stocks'][$mineral_name.'/hematite'] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, 'hematite', 1, 'applicant');
								$reason['status']['rom_stocks'][$mineral_name.'/hematite'] = (isset($reason['rom_stocks'][$mineral_name.'/hematite']['commented']) && $reason['rom_stocks'][$mineral_name.'/hematite']['commented'] == '1') ? 'success' : 'pending';
								$reason['status']['rom_stocks'][$mineral_name.'/hematite'] = ($formStatus == 'read') ? 'success' : $reason['status']['rom_stocks'][$mineral_name.'/hematite'];
								$prodArr = $this->Prod1->fetchProduction($mine_code, $returnType, $returnDate, $mineral_name, 'hematite');
								$prodArrStatus = (isset($app_sec[$mineral_ul]['hematite'][1]) && $app_sec[$mineral_ul]['hematite'][1] == 'Rejected') ? $reason['status']['rom_stocks'][$mineral_name.'/hematite'] : (($prodArr['open_oc_rom'] != '' && $prodArr['prod_oc_rom'] != '' && $prodArr['clos_oc_rom'] != '' && $prodArr['open_ug_rom'] != '' && $prodArr['prod_ug_rom'] != '' && $prodArr['clos_ug_rom'] != '' && $prodArr['open_dw_rom'] != '' && $prodArr['prod_dw_rom'] != '' && $prodArr['clos_dw_rom'] != '') ? "success" : "error");
								$secStatus['rom_stocks'][$mineral_name.'/hematite'] = $prodArrStatus;
							// }
							// if($is_magnetite == true){
								$reason['rom_stocks'][$mineral_name.'/magnetite'] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, 'magnetite', 1, 'applicant');
								$reason['status']['rom_stocks'][$mineral_name.'/magnetite'] = (isset($reason['rom_stocks'][$mineral_name.'/magnetite']['commented']) && $reason['rom_stocks'][$mineral_name.'/magnetite']['commented'] == '1') ? 'success' : 'pending';
								$reason['status']['rom_stocks'][$mineral_name.'/magnetite'] = ($formStatus == 'read') ? 'success' : $reason['status']['rom_stocks'][$mineral_name.'/magnetite'];
								$prodArr = $this->Prod1->fetchProduction($mine_code, $returnType, $returnDate, $mineral_name, 'magnetite');
								$prodArrStatus = (isset($app_sec[$mineral_ul]['magnetite'][1]) && $app_sec[$mineral_ul]['magnetite'][1] == 'Rejected') ? $reason['status']['rom_stocks'][$mineral_name.'/magnetite'] : (($prodArr['open_oc_rom'] != '' && $prodArr['prod_oc_rom'] != '' && $prodArr['clos_oc_rom'] != '' && $prodArr['open_ug_rom'] != '' && $prodArr['prod_ug_rom'] != '' && $prodArr['clos_ug_rom'] != '' && $prodArr['open_dw_rom'] != '' && $prodArr['prod_dw_rom'] != '' && $prodArr['clos_dw_rom'] != '') ? "success" : "error");
								$secStatus['rom_stocks'][$mineral_name.'/magnetite'] = $prodArrStatus;
							// }
							// if($is_hematite != true && $is_magnetite != true){
								$reason['rom_stocks'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, '', 1, 'applicant');
								$reason['status']['rom_stocks'][$mineral_name] = (isset($reason['rom_stocks'][$mineral_name]['commented']) && $reason['rom_stocks'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
								$reason['status']['rom_stocks'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['rom_stocks'][$mineral_name];
								$prodArr = $this->Prod1->fetchProduction($mine_code, $returnType, $returnDate, $mineral_name, '');
								$prodArrStatus = (isset($app_sec[$mineral_ul][1]) && $app_sec[$mineral_ul][1] == 'Rejected') ? $reason['status']['rom_stocks'][$mineral_name] : (($prodArr['open_oc_rom'] != '' && $prodArr['prod_oc_rom'] != '' && $prodArr['clos_oc_rom'] != '' && $prodArr['open_ug_rom'] != '' && $prodArr['prod_ug_rom'] != '' && $prodArr['clos_ug_rom'] != '' && $prodArr['open_dw_rom'] != '' && $prodArr['prod_dw_rom'] != '' && $prodArr['clos_dw_rom'] != '') ? "success" : "error");
								$secStatus['rom_stocks'][$mineral_name] = $prodArrStatus;
							// }
						// } else {
						// 	$prodArr = $this->Prod1->fetchProduction($mine_code, $returnType, $returnDate, $mineral_name, '');
						// 	$prodArrStatus = (isset($app_sec[$mineral_ul][1]) && $app_sec[$mineral_ul][1] == 'Rejected') ? 'pending' : (($prodArr['open_oc_rom'] != '' && $prodArr['prod_oc_rom'] != '' && $prodArr['clos_oc_rom'] != '' && $prodArr['open_ug_rom'] != '' && $prodArr['prod_ug_rom'] != '' && $prodArr['clos_ug_rom'] != '' && $prodArr['open_dw_rom'] != '' && $prodArr['prod_dw_rom'] != '' && $prodArr['clos_dw_rom'] != '') ? "success" : "error");
						// 	$secStatus['rom_stocks'][$mineral_name] = $prodArrStatus;
						// }
						
						//PART II: Production / Stocks (ROM) (Form F7)
						$reason['rom_stocks_three'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, '', 1, 'applicant');
						$reason['status']['rom_stocks_three'][$mineral_name] = (isset($reason['rom_stocks_three'][$mineral_name]['commented']) && $reason['rom_stocks_three'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['rom_stocks_three'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['rom_stocks_three'][$mineral_name];
						$romData = $this->RomStone->getRomData($mine_code, $returnType, $returnDate, $mineral_name);
						$romDataStatus = (isset($app_sec[$mineral_ul][1]) && $app_sec[$mineral_ul][1] == 'Rejected') ? $reason['status']['rom_stocks_three'][$mineral_name] : (($romData['count'] != 0) ? "success" : "error");
						$secStatus['rom_stocks_three'][$mineral_name] = $romDataStatus;
		
						//PART II: Grade-Wise Production
						
						// if($mineral_name == 'iron ore'){
						// 	if($is_hematite == true){
								$reason['gradewise_prod'][$mineral_name.'/hematite'] = $this->TblFinalSubmit->getReason($return_id, $mineral_ul, 'hematite', 2, 'applicant');
								$reason['status']['gradewise_prod'][$mineral_name.'/hematite'] = (isset($reason['gradewise_prod'][$mineral_name.'/hematite']['commented']) && $reason['gradewise_prod'][$mineral_name.'/hematite']['commented'] == '1') ? 'success' : 'pending';
								$reason['status']['gradewise_prod'][$mineral_name.'/hematite'] = ($formStatus == 'read') ? 'success' : $reason['status']['gradewise_prod'][$mineral_name.'/hematite'];
								$gradeArr = $this->GradeProd->fetchGradeWiseProd($mine_code, $returnType, $returnDate, str_replace(' ','_',$mineral_name), '', 'hematite');
								$gradeArrStatus = (isset($app_sec[$mineral_ul]['hematite'][2]) && $app_sec[$mineral_ul]['hematite'][2] == 'Rejected') ? $reason['status']['gradewise_prod'][$mineral_name.'/hematite'] : (($gradeArr['id'] != '') ? "success" : "error");
								$secStatus['gradewise_prod'][$mineral_name.'/hematite'] = $gradeArrStatus;
							// }
							// if($is_magnetite == true){
								$reason['gradewise_prod'][$mineral_name.'/magnetite'] = $this->TblFinalSubmit->getReason($return_id, $mineral_ul, 'magnetite', 2, 'applicant');
								$reason['status']['gradewise_prod'][$mineral_name.'/magnetite'] = (isset($reason['gradewise_prod'][$mineral_name.'/magnetite']['commented']) && $reason['gradewise_prod'][$mineral_name.'/magnetite']['commented'] == '1') ? 'success' : 'pending';
								$reason['status']['gradewise_prod'][$mineral_name.'/magnetite'] = ($formStatus == 'read') ? 'success' : $reason['status']['gradewise_prod'][$mineral_name.'/magnetite'];
								$gradeArr = $this->GradeProd->fetchGradeWiseProd($mine_code, $returnType, $returnDate, str_replace(' ','_',$mineral_name), '', 'magnetite');
								$gradeArrStatus = (isset($app_sec[$mineral_ul]['magnetite'][2]) && $app_sec[$mineral_ul]['magnetite'][2] == 'Rejected') ? $reason['status']['gradewise_prod'][$mineral_name.'/magnetite'] : (($gradeArr['id'] != '') ? "success" : "error");
								$secStatus['gradewise_prod'][$mineral_name.'/magnetite'] = $gradeArrStatus;
							// }
							// if($is_hematite != true && $is_magnetite != true){
								$reason['gradewise_prod'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_ul, '', 2, 'applicant');
								$reason['status']['gradewise_prod'][$mineral_name] = (isset($reason['gradewise_prod'][$mineral_name]['commented']) && $reason['gradewise_prod'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
								$reason['status']['gradewise_prod'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['gradewise_prod'][$mineral_name];
								$gradeArr = $this->GradeProd->fetchGradeWiseProd($mine_code, $returnType, $returnDate, str_replace(' ','_',$mineral_name), '');
								$gradeArrStatus = (isset($app_sec[$mineral_ul][2]) && $app_sec[$mineral_ul][2] == 'Rejected') ? $reason['status']['gradewise_prod'][$mineral_name] : (($gradeArr['id'] != '') ? "success" : "error");
								$secStatus['gradewise_prod'][$mineral_name] = $gradeArrStatus;
						// 	}
						// } else {
						// 	$gradeArr = $this->GradeProd->fetchGradeWiseProd($mine_code, $returnType, $returnDate, $mineral_name, '');
						// 	$gradeArrStatus = (isset($app_sec[$mineral_ul][2]) && $app_sec[$mineral_ul][2] == 'Rejected') ? 'pending' : (($gradeArr['id'] != '') ? "success" : "error");
						// 	$secStatus['gradewise_prod'][$mineral_name] = $gradeArrStatus;
						// }

						//PART II: Production, Despatches and Stocks (Form F7)
						$reason['prod_stock_dis'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, '', 2, 'applicant');
						$reason['status']['prod_stock_dis'][$mineral_name] = (isset($reason['prod_stock_dis'][$mineral_name]['commented']) && $reason['prod_stock_dis'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['prod_stock_dis'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['prod_stock_dis'][$mineral_name];
						$roughStoneData = $this->ProdStone->getProdStoneData($mine_code, $returnDate, $mineral_name, 1, $returnType);
						$cutStoneData = $this->ProdStone->getProdStoneData($mine_code, $returnDate, $mineral_name, 2, $returnType);
						$indStoneData = $this->ProdStone->getProdStoneData($mine_code, $returnDate, $mineral_name, 3, $returnType);
						$othStoneData = $this->ProdStone->getProdStoneData($mine_code, $returnDate, $mineral_name, 99, $returnType);
						$prodStockDisStatus = (isset($app_sec[$mineral_ul][2]) && $app_sec[$mineral_ul][2] == 'Rejected') ? $reason['status']['prod_stock_dis'][$mineral_name] : (($roughStoneData['count'] != 0 && $cutStoneData['count'] != 0 && $indStoneData['count'] != 0 && $othStoneData['count'] != 0) ? "success" : "error");
						$secStatus['prod_stock_dis'][$mineral_name] = $prodStockDisStatus;
		
						//PART II: Pulverisation
						$reason['pulverisation'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $ironSubMin, 5, 'applicant');
						$reason['status']['pulverisation'][$mineral_name] = (isset($reason['pulverisation'][$mineral_name]['commented']) && $reason['pulverisation'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['pulverisation'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['pulverisation'][$mineral_name];
						$pulverArr = $this->Pulverisation->getPulverData($mine_code, $returnType, $returnDate, $mineral_name);
						$pulverArrStatus = (isset($app_sec[$mineral_ul][5]) && $app_sec[$mineral_ul][5] == 'Rejected') ? $reason['status']['pulverisation'][$mineral_name] : (($pulverArr[0]['id'] != '') ? "success" : "error");
						$secStatus['pulverisation'][$mineral_name] = $pulverArrStatus;
		
						//PART II: Details of Deductions
						
						// if($mineral_name == 'iron ore'){
							//hematite
							$reason['deduct_detail'][$mineral_name.'/hematite'] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $ironSubMin, $reason_no['deduct_detail'], 'applicant');
							$reason['status']['deduct_detail'][$mineral_name.'/hematite'] = (isset($reason['deduct_detail'][$mineral_name.'/hematite']['commented']) && $reason['deduct_detail'][$mineral_name.'/hematite']['commented'] == '1') ? 'success' : 'pending';
							$reason['status']['deduct_detail'][$mineral_name.'/hematite'] = ($formStatus == 'read') ? 'success' : $reason['status']['deduct_detail'][$mineral_name.'/hematite'];
							$prodDeductArr = $this->Prod1->fetchProduction($mine_code, $returnType, $returnDate, $mineral, $ironSubMin);
							$prodDeductArrStatus = (isset($app_sec[$mineral_ul]['hematite'][3]) && $app_sec[$mineral_ul]['hematite'][3] == 'Rejected') ? $reason['status']['deduct_detail'][$mineral_name.'/hematite'] : (($prodDeductArr['trans_cost'] != '' && $prodDeductArr['loading_charges'] != '' && $prodDeductArr['railway_freight'] != '' && $prodDeductArr['port_handling'] != '' && $prodDeductArr['sampling_cost'] != '' && $prodDeductArr['plot_rent'] != '' && $prodDeductArr['other_cost'] != '' && $prodDeductArr['total_prod'] != '') ? "success" : "error");
							$secStatus['deduct_detail'][$mineral_name.'/hematite'] = $prodDeductArrStatus;
							
							//magnetite
							$reason['deduct_detail'][$mineral_name.'/magnetite'] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $ironSubMin, $reason_no['deduct_detail'], 'applicant');
							$reason['status']['deduct_detail'][$mineral_name.'/magnetite'] = (isset($reason['deduct_detail'][$mineral_name.'/magnetite']['commented']) && $reason['deduct_detail'][$mineral_name.'/magnetite']['commented'] == '1') ? 'success' : 'pending';
							$reason['status']['deduct_detail'][$mineral_name.'/magnetite'] = ($formStatus == 'read') ? 'success' : $reason['status']['deduct_detail'][$mineral_name.'/magnetite'];
							$prodDeductArr = $this->Prod1->fetchProduction($mine_code, $returnType, $returnDate, $mineral, $ironSubMin);
							$prodDeductArrStatus = (isset($app_sec[$mineral_ul]['magnetite'][3]) && $app_sec[$mineral_ul]['magnetite'][3] == 'Rejected') ? $reason['status']['deduct_detail'][$mineral_name.'/magnetite'] : (($prodDeductArr['trans_cost'] != '' && $prodDeductArr['loading_charges'] != '' && $prodDeductArr['railway_freight'] != '' && $prodDeductArr['port_handling'] != '' && $prodDeductArr['sampling_cost'] != '' && $prodDeductArr['plot_rent'] != '' && $prodDeductArr['other_cost'] != '' && $prodDeductArr['total_prod'] != '') ? "success" : "error");
							$secStatus['deduct_detail'][$mineral_name.'/magnetite'] = $prodDeductArrStatus;

							//other
							$reason['deduct_detail'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $ironSubMin, $reason_no['deduct_detail'], 'applicant');
							$reason['status']['deduct_detail'][$mineral_name] = (isset($reason['deduct_detail'][$mineral_name]['commented']) && $reason['deduct_detail'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
							$reason['status']['deduct_detail'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['deduct_detail'][$mineral_name];
							$prodDeductArr = $this->Prod1->fetchProduction($mine_code, $returnType, $returnDate, $mineral, $ironSubMin);
							$prodDeductArrStatus = (isset($app_sec[$mineral_ul][3]) && $app_sec[$mineral_ul][3] == 'Rejected') ? $reason['status']['deduct_detail'][$mineral_name] : (($prodDeductArr['trans_cost'] != '' && $prodDeductArr['loading_charges'] != '' && $prodDeductArr['railway_freight'] != '' && $prodDeductArr['port_handling'] != '' && $prodDeductArr['sampling_cost'] != '' && $prodDeductArr['plot_rent'] != '' && $prodDeductArr['other_cost'] != '' && $prodDeductArr['total_prod'] != '') ? "success" : "error");
							$secStatus['deduct_detail'][$mineral_name] = $prodDeductArrStatus;
						// }
		
						//PART II: Sales/Dispatches
						// if($mineral_name == 'iron ore'){
							//hematite
							$reason['sale_despatch'][$mineral_name.'/hematite'] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $ironSubMin, $reason_no['sale_despatch'], 'applicant');
							$reason['status']['sale_despatch'][$mineral_name.'/hematite'] = (isset($reason['sale_despatch'][$mineral_name.'/hematite']['commented']) && $reason['sale_despatch'][$mineral_name.'/hematite']['commented'] == '1') ? 'success' : 'pending';
							$reason['status']['sale_despatch'][$mineral_name.'/hematite'] = ($formStatus == 'read') ? 'success' : $reason['status']['sale_despatch'][$mineral_name.'/hematite'];
							$gradeSaleArr = $this->GradeSale->fetchSalesData($mine_code, $returnType, $returnDate, $mineral_name);
							$gradeSaleArrStatus = (isset($app_sec[$mineral_ul]['hematite'][4]) && $app_sec[$mineral_ul]['hematite'][4] == 'Rejected') ? $reason['status']['sale_despatch'][$mineral_name.'/hematite'] : (($gradeSaleArr[0]['id'] != '') ? "success" : "error");
							$secStatus['sale_despatch'][$mineral_name.'/hematite'] = $gradeSaleArrStatus;
							
							//magnetite
							$reason['sale_despatch'][$mineral_name.'/magnetite'] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $ironSubMin, $reason_no['sale_despatch'], 'applicant');
							$reason['status']['sale_despatch'][$mineral_name.'/magnetite'] = (isset($reason['sale_despatch'][$mineral_name.'/magnetite']['commented']) && $reason['sale_despatch'][$mineral_name.'/magnetite']['commented'] == '1') ? 'success' : 'pending';
							$reason['status']['sale_despatch'][$mineral_name.'/magnetite'] = ($formStatus == 'read') ? 'success' : $reason['status']['sale_despatch'][$mineral_name.'/magnetite'];
							$gradeSaleArr = $this->GradeSale->fetchSalesData($mine_code, $returnType, $returnDate, $mineral_name);
							$gradeSaleArrStatus = (isset($app_sec[$mineral_ul]['magnetite'][4]) && $app_sec[$mineral_ul]['magnetite'][4] == 'Rejected') ? $reason['status']['sale_despatch'][$mineral_name.'/magnetite'] : (($gradeSaleArr[0]['id'] != '') ? "success" : "error");
							$secStatus['sale_despatch'][$mineral_name.'/magnetite'] = $gradeSaleArrStatus;

							//other
							$reason['sale_despatch'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $ironSubMin, $reason_no['sale_despatch'], 'applicant');
							$reason['status']['sale_despatch'][$mineral_name] = (isset($reason['sale_despatch'][$mineral_name]['commented']) && $reason['sale_despatch'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
							$reason['status']['sale_despatch'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['sale_despatch'][$mineral_name];
							$gradeSaleArr = $this->GradeSale->fetchSalesData($mine_code, $returnType, $returnDate, $mineral_name);
							$gradeSaleArrStatus = (isset($app_sec[$mineral_ul][4]) && $app_sec[$mineral_ul][4] == 'Rejected') ? $reason['status']['sale_despatch'][$mineral_name] : (($gradeSaleArr[0]['id'] != '') ? "success" : "error");
							$secStatus['sale_despatch'][$mineral_name] = $gradeSaleArrStatus;
						// }
		
					// } else if($mcFormMain == 2){
					} else if($formNoNew == 2){
		
						//PART II: Production / Stocks (ROM)
						$reason['rom_stocks_ore'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, '', 1, 'applicant');
						$reason['status']['rom_stocks_ore'][$mineral_name] = (isset($reason['rom_stocks_ore'][$mineral_name]['commented']) && $reason['rom_stocks_ore'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['rom_stocks_ore'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['rom_stocks_ore'][$mineral_name];
						$romData = $this->Rom5->getRomData($mine_code, $returnDate, $returnType, $mineral_name);
						$romDataStatus = (isset($app_sec[$mineral_ul][1]) && $app_sec[$mineral_ul][1] == 'Rejected') ? $reason['status']['rom_stocks_ore'][$mineral_name] : (($romData[1]['tot_qty'][0] != '' && $romData[1]['metal'][0] != '' && $romData[1]['grade'][0] != '' && $romData[2]['tot_qty'][0] != '' && $romData[2]['metal'][0] != '' && $romData[2]['grade'][0] != '' && $romData[3]['tot_qty'][0] != '' && $romData[3]['metal'][0] != '' && $romData[3]['grade'][0] != '' && $romData[4]['tot_qty'][0] != '' && $romData[4]['metal'][0] != '' && $romData[4]['grade'][0] != '' && $romData[5]['tot_qty'][0] != '' && $romData[5]['metal'][0] != '' && $romData[5]['grade'][0] != '' && $romData[6]['tot_qty'][0] != '' && $romData[6]['metal'][0] != '' && $romData[6]['grade'][0] != '' && $romData[7]['tot_qty'][0] != '' && $romData[7]['metal'][0] != '' && $romData[7]['grade'][0] != '' && $romData[8]['tot_qty'][0] != '' && $romData[8]['metal'][0] != '' && $romData[8]['grade'][0] != '' && $romData[9]['tot_qty'][0] != '' && $romData[9]['metal'][0] != '' && $romData[9]['grade'][0] != '') ? "success" : "error");
						$secStatus['rom_stocks_ore'][$mineral_name] = $romDataStatus;
		
						//PART II: Ex-Mine Price
						$reason['ex_mine'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, '', 2, 'applicant');
						$reason['status']['ex_mine'][$mineral_name] = (isset($reason['ex_mine'][$mineral_name]['commented']) && $reason['ex_mine'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['ex_mine'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['ex_mine'][$mineral_name];
						$prod5Arr = $this->Prod5->getExMineProd5($mine_code, $returnType, $returnDate, $mineral);
						$prod5ArrStatus = (isset($app_sec[$mineral_ul][2]) && $app_sec[$mineral_ul][2] == 'Rejected') ? $reason['status']['ex_mine'][$mineral_name] : (($prod5Arr['pmv'] != '') ? "success" : "error");
						$secStatus['ex_mine'][$mineral_name] = $prod5ArrStatus;
		
						//PART II: Recoveries at Concentrator
						$reason['con_reco'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, '', 3, 'applicant');
						$reason['status']['con_reco'][$mineral_name] = (isset($reason['con_reco'][$mineral_name]['commented']) && $reason['con_reco'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['con_reco'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['con_reco'][$mineral_name];
						$conRomDataArr = $this->RomMetal5->getConRomData($mine_code, $returnDate, $returnType, $mineral);
						$conRomDataArrStatus = (isset($app_sec[$mineral_ul][3]) && $app_sec[$mineral_ul][3] == 'Rejected') ? $reason['status']['con_reco'][$mineral_name] : (($conRomDataArr['rom'][10]['tot_qty'][0] != '' && $conRomDataArr['rom'][10]['metal'][0] != '' && $conRomDataArr['rom'][10]['grade'][0] != '' && $conRomDataArr['rom'][11]['tot_qty'][0] != '' && $conRomDataArr['rom'][11]['metal'][0] != '' && $conRomDataArr['rom'][11]['grade'][0] != '' && $conRomDataArr['rom'][12]['tot_qty'][0] != '' && $conRomDataArr['rom'][12]['metal'][0] != '' && $conRomDataArr['rom'][12]['grade'][0] != '' && $conRomDataArr['rom'][14]['tot_qty'][0] != '' && $conRomDataArr['rom'][14]['metal'][0] != '' && $conRomDataArr['rom'][14]['grade'][0] != '' && $conRomDataArr['con'][13]['tot_qty'][0] != '' && $conRomDataArr['con'][13]['metal'][0] != '' && $conRomDataArr['con'][13]['grade'][0] != '' && $conRomDataArr['con'][13]['con_value'][0] != '' && $conRomDataArr['con'][15]['tot_qty'][0] != '' && $conRomDataArr['con'][15]['metal'][0] != '' && $conRomDataArr['con'][15]['grade'][0] != '') ? "success" : "error");
						$secStatus['con_reco'][$mineral_name] = $conRomDataArrStatus;
		
						//PART II: Recovery at the Smelter
						$reason['smelt_reco'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, '', 4, 'applicant');
						$reason['status']['smelt_reco'][$mineral_name] = (isset($reason['smelt_reco'][$mineral_name]['commented']) && $reason['smelt_reco'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['smelt_reco'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['smelt_reco'][$mineral_name];
						$recovSmelterArr = $this->RecovSmelter->getRecoveryData($mine_code, $returnDate, $returnType, $mineral);
						$recovSmelterArrStatus = (isset($app_sec[$mineral_ul][4]) && $app_sec[$mineral_ul][4] == 'Rejected') ? $reason['status']['smelt_reco'][$mineral_name] : ((
							$recovSmelterArr['recovery'][0]['open_metal'] != ''
							&& $recovSmelterArr['recovery'][0]['open_qty'] != ''
							&& $recovSmelterArr['recovery'][0]['open_grade'] != ''
							&& $recovSmelterArr['recovery'][0]['con_rc_qty'] != ''
							&& $recovSmelterArr['recovery'][0]['con_rc_grade'] != ''
							&& $recovSmelterArr['recovery'][0]['con_rs_qty'] != ''
							&& $recovSmelterArr['recovery'][0]['con_rs_grade'] != ''
							&& $recovSmelterArr['recovery'][0]['con_so_qty'] != ''
							&& $recovSmelterArr['recovery'][0]['con_so_grade'] != ''
							&& $recovSmelterArr['recovery'][0]['con_tr_qty'] != ''
							&& $recovSmelterArr['recovery'][0]['con_tr_grade'] != ''
							&& $recovSmelterArr['recovery'][0]['close_qty'] != ''
							&& $recovSmelterArr['recovery'][0]['close_value'] != ''
							&& $recovSmelterArr['con_metal'][0]['rc_metal'] != ''
							&& $recovSmelterArr['con_metal'][0]['rc_qty'] != ''
							&& $recovSmelterArr['con_metal'][0]['rc_value'] != ''
							&& $recovSmelterArr['con_metal'][0]['rc_grade'] != ''
							&& $recovSmelterArr['by_product'][0]['bp_metal'] != ''
							&& $recovSmelterArr['by_product'][0]['bp_qty'] != ''
							&& $recovSmelterArr['by_product'][0]['bp_value'] != ''
							&& $recovSmelterArr['by_product'][0]['bp_grade'] != ''
						) ? "success" : "error");
						$secStatus['smelt_reco'][$mineral_name] = $recovSmelterArrStatus;
		
						//PART II: Sales(Metals/By Product)
						$reason['sales_metal_product'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, '', 5, 'applicant');
						$reason['status']['sales_metal_product'][$mineral_name] = (isset($reason['sales_metal_product'][$mineral_name]['commented']) && $reason['sales_metal_product'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['sales_metal_product'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['sales_metal_product'][$mineral_name];
						$salesData = $this->Sale5->getSalesData($mine_code, $returnDate, $returnType, $mineral);
						$salesDataStatus = (isset($app_sec[$mineral_ul][5]) && $app_sec[$mineral_ul][5] == 'Rejected') ? $reason['status']['sales_metal_product'][$mineral_name] : (($salesData[0]['open_tot_qty'] != '' && $salesData[0]['open_metal'] != '' && $salesData[0]['open_grade'] != '' && $salesData[1]['sale_place'] != '' && $salesData[2]['prod_tot_qty'] != '' && $salesData[2]['prod_grade'] != '' && $salesData[2]['prod_product_value'] != '' && $salesData[3]['close_tot_qty'] != '' && $salesData[3]['close_product_value'] != '') ? "success" : "error");
						$secStatus['sales_metal_product'][$mineral_name] = $salesDataStatus;
		
						//PART II: Details of Deductions
						$reason['deduct_detail'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $ironSubMin, $reason_no['deduct_detail'], 'applicant');
						$reason['status']['deduct_detail'][$mineral_name] = (isset($reason['deduct_detail'][$mineral_name]['commented']) && $reason['deduct_detail'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['deduct_detail'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['deduct_detail'][$mineral_name];
						$detDeductArr = $this->Prod1->fetchProduction($mine_code, $returnType, $returnDate, $mineral_name, '');
						$detDeductArrStatus = (isset($app_sec[$mineral_ul][6]) && $app_sec[$mineral_ul][6] == 'Rejected') ? $reason['status']['deduct_detail'][$mineral_name] : (($detDeductArr['trans_cost'] != '' && $detDeductArr['loading_charges'] != '' && $detDeductArr['railway_freight'] != '' && $detDeductArr['port_handling'] != '' && $detDeductArr['sampling_cost'] != '' && $detDeductArr['plot_rent'] != '' && $detDeductArr['other_cost'] != '' && $detDeductArr['total_prod'] != '') ? "success" : "error");
						$secStatus['deduct_detail'][$mineral_name] = $detDeductArrStatus;
		
						//PART II: Sales/Dispatches
						$reason['sale_despatch'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $ironSubMin, $reason_no['sale_despatch'], 'applicant');
						$reason['status']['sale_despatch'][$mineral_name] = (isset($reason['sale_despatch'][$mineral_name]['commented']) && $reason['sale_despatch'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['sale_despatch'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['sale_despatch'][$mineral_name];
						$gradeSaleArr = $this->GradeSale->fetchSalesData($mine_code, $returnType, $returnDate, $mineral_name);
						$gradeSaleArrStatus = (isset($app_sec[$mineral_ul][7]) && $app_sec[$mineral_ul][7] == 'Rejected') ? $reason['status']['sale_despatch'][$mineral_name] : (($gradeSaleArr[0]['id'] != '') ? "success" : "error");
						$secStatus['sale_despatch'][$mineral_name] = $gradeSaleArrStatus;
						
					// } else if($mcFormMain == 3){
					} else if($formNoNew == 3){
		
						//PART II: Production / Stocks (ROM) (Form F7)
						$reason['rom_stocks_three'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, '', 1, 'applicant');
						$reason['status']['rom_stocks_three'][$mineral_name] = (isset($reason['rom_stocks_three'][$mineral_name]['commented']) && $reason['rom_stocks_three'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['rom_stocks_three'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['rom_stocks_three'][$mineral_name];
						$romData = $this->RomStone->getRomData($mine_code, $returnType, $returnDate, $mineral_name);
						$romDataStatus = (isset($app_sec[$mineral_ul][1]) && $app_sec[$mineral_ul][1] == 'Rejected') ? $reason['status']['rom_stocks_three'][$mineral_name] : (($romData['count'] != 0) ? "success" : "error");
						$secStatus['rom_stocks_three'][$mineral_name] = $romDataStatus;
						
						//PART II: Production / Stocks (ROM) (Form F8)
						$reason['rom_stocks'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, '', 1, 'applicant');
						$reason['status']['rom_stocks'][$mineral_name] = (isset($reason['rom_stocks'][$mineral_name]['commented']) && $reason['rom_stocks'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['rom_stocks'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['rom_stocks'][$mineral_name];
						$prodArr = $this->Prod1->fetchProduction($mine_code, $returnType, $returnDate, $mineral_name, '');
						$prodArrStatus = (isset($app_sec[$mineral_ul][1]) && $app_sec[$mineral_ul][1] == 'Rejected') ? $reason['status']['rom_stocks'][$mineral_name] : (($prodArr['open_oc_rom'] != '' && $prodArr['prod_oc_rom'] != '' && $prodArr['clos_oc_rom'] != '' && $prodArr['open_ug_rom'] != '' && $prodArr['prod_ug_rom'] != '' && $prodArr['clos_ug_rom'] != '' && $prodArr['open_dw_rom'] != '' && $prodArr['prod_dw_rom'] != '' && $prodArr['clos_dw_rom'] != '') ? "success" : "error");
						$secStatus['rom_stocks'][$mineral_name] = $prodArrStatus;
						
						//PART II: Grade-Wise Production (Form F8)
						$reason['gradewise_prod'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, '', 2, 'applicant');
						$reason['status']['gradewise_prod'][$mineral_name] = (isset($reason['gradewise_prod'][$mineral_name]['commented']) && $reason['gradewise_prod'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['gradewise_prod'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['gradewise_prod'][$mineral_name];
						$gradeArr = $this->GradeProd->fetchGradeWiseProd($mine_code, $returnType, $returnDate, $mineral_name, '');
						$gradeArrStatus = (isset($app_sec[$mineral_ul][2]) && $app_sec[$mineral_ul][2] == 'Rejected') ? $reason['status']['gradewise_prod'][$mineral_name] : (($gradeArr['id'] != '') ? "success" : "error");
						$secStatus['gradewise_prod'][$mineral_name] = $gradeArrStatus;
						
						//PART II: Pulverisation
						$reason['pulverisation'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $ironSubMin, 5, 'applicant');
						$reason['status']['pulverisation'][$mineral_name] = (isset($reason['pulverisation'][$mineral_name]['commented']) && $reason['pulverisation'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['pulverisation'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['pulverisation'][$mineral_name];
						$pulverArr = $this->Pulverisation->getPulverData($mine_code, $returnType, $returnDate, $mineral_name);
						$pulverArrStatus = (isset($app_sec[$mineral_ul][5]) && $app_sec[$mineral_ul][5] == 'Rejected') ? $reason['status']['pulverisation'][$mineral_name] : (($pulverArr[0]['id'] != '') ? "success" : "error");
						$secStatus['pulverisation'][$mineral_name] = $pulverArrStatus;
						
						//PART II: Production, Despatches and Stocks
						$reason['prod_stock_dis'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, '', 2, 'applicant');
						$reason['status']['prod_stock_dis'][$mineral_name] = (isset($reason['prod_stock_dis'][$mineral_name]['commented']) && $reason['prod_stock_dis'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['prod_stock_dis'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['prod_stock_dis'][$mineral_name];
						$roughStoneData = $this->ProdStone->getProdStoneData($mine_code, $returnDate, $mineral_name, 1, $returnType);
						$cutStoneData = $this->ProdStone->getProdStoneData($mine_code, $returnDate, $mineral_name, 2, $returnType);
						$indStoneData = $this->ProdStone->getProdStoneData($mine_code, $returnDate, $mineral_name, 3, $returnType);
						$othStoneData = $this->ProdStone->getProdStoneData($mine_code, $returnDate, $mineral_name, 99, $returnType);
						$prodStockDisStatus = (isset($app_sec[$mineral_ul][2]) && $app_sec[$mineral_ul][2] == 'Rejected') ? $reason['status']['prod_stock_dis'][$mineral_name] : (($roughStoneData['count'] != 0 && $cutStoneData['count'] != 0 && $indStoneData['count'] != 0 && $othStoneData['count'] != 0) ? "success" : "error");
						$secStatus['prod_stock_dis'][$mineral_name] = $prodStockDisStatus;
						
						//PART II: Details of Deductions
						$reason['deduct_detail'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $ironSubMin, $reason_no['deduct_detail'], 'applicant');
						$reason['status']['deduct_detail'][$mineral_name] = (isset($reason['deduct_detail'][$mineral_name]['commented']) && $reason['deduct_detail'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['deduct_detail'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['deduct_detail'][$mineral_name];
						$detDeductArr = $this->Prod1->fetchProduction($mine_code, $returnType, $returnDate, $mineral_name, '');
						$detDeductArrStatus = (isset($app_sec[$mineral_ul][3]) && $app_sec[$mineral_ul][3] == 'Rejected') ? $reason['status']['deduct_detail'][$mineral_name] : (($detDeductArr['trans_cost'] != '' && $detDeductArr['loading_charges'] != '' && $detDeductArr['railway_freight'] != '' && $detDeductArr['port_handling'] != '' && $detDeductArr['sampling_cost'] != '' && $detDeductArr['plot_rent'] != '' && $detDeductArr['other_cost'] != '' && $detDeductArr['total_prod'] != '') ? "success" : "error");
						$secStatus['deduct_detail'][$mineral_name] = $detDeductArrStatus;
		
						//PART II: Sales/Dispatches
						$reason['sale_despatch'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $ironSubMin, $reason_no['sale_despatch'], 'applicant');
						$reason['status']['sale_despatch'][$mineral_name] = (isset($reason['sale_despatch'][$mineral_name]['commented']) && $reason['sale_despatch'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['sale_despatch'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['sale_despatch'][$mineral_name];
						$gradeSaleArr = $this->GradeSale->fetchSalesData($mine_code, $returnType, $returnDate, $mineral_name);
						$gradeSaleArrStatus = (isset($app_sec[$mineral_ul][4]) && $app_sec[$mineral_ul][4] == 'Rejected') ? $reason['status']['sale_despatch'][$mineral_name] : (($gradeSaleArr[0]['id'] != '') ? "success" : "error");
						$secStatus['sale_despatch'][$mineral_name] = $gradeSaleArrStatus;
		
					}
		
				}

			} else {
				
				//PART I: DETAILS OF THE MINE
				$reason['mine'] = $this->TblFinalSubmit->getReason($return_id, '', '', 1, 'applicant');
				$reason['status']['mine'] = (isset($reason['mine']['commented']) && $reason['mine']['commented'] == '1') ? 'success' : 'pending';
				$reason['status']['mine'] = ($formStatus == 'read') ? 'success' : $reason['status']['mine'];
				$secStatus['mine'] = (isset($app_sec['partI'][1]) && $app_sec['partI'][1] == 'Rejected') ? $reason['status']['mine'] : 'success';
		
				//PART I: NAME AND ADDRESS
				$reason['name_address'] = $this->TblFinalSubmit->getReason($return_id, '', '', 2, 'applicant');
				$reason['status']['name_address'] = (isset($reason['name_address']['commented']) && $reason['name_address']['commented'] == '1') ? 'success' : 'pending';
				$reason['status']['name_address'] = ($formStatus == 'read') ? 'success' : $reason['status']['name_address'];
				$nameAndAddressData = $this->Mine->nameAndAddressCheck($mine_code);
				$secStatus['name_address'] = (isset($app_sec['partI'][2]) && $app_sec['partI'][2] == 'Rejected') ? $reason['status']['name_address'] : (($nameAndAddressData == 1) ? 'error' : 'success');
		
				//PART I: PARTICULARS OF AREA OPERATED
				$reason['particulars'] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partI', 3);
				$reason['status']['particulars'] = (isset($reason['particulars']['commented']) && $reason['particulars']['commented'] == '1') ? 'success' : 'pending';
				$reason['status']['particulars'] = ($formStatus == 'read') ? 'success' : $reason['status']['particulars'];
				$partData = $this->McpLease->particularAnnualCheck($mine_code, $returnDate);
				$partDataStatus = (isset($app_sec['partI'][3]) && $app_sec['partI'][3] == 'Rejected') ? $reason['status']['particulars'] : (($partData == 0) ? "success" : "error");
				$secStatus['particulars'] = $partDataStatus;
				
				//PART I: LEASE AREA UTILISATION
				$reason['area_utilisation'] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partI', 4);
				$reason['status']['area_utilisation'] = (isset($reason['area_utilisation']['commented']) && $reason['area_utilisation']['commented'] == '1') ? 'success' : 'pending';
				$reason['status']['area_utilisation'] = ($formStatus == 'read') ? 'success' : $reason['status']['area_utilisation'];
				$leaseArea = $this->LeaseReturn->lesseeCheck($mine_code, $returnDate);
				$leaseAreaStatus = (isset($app_sec['partI'][4]) && $app_sec['partI'][4] == 'Rejected') ? $reason['status']['area_utilisation'] : (($leaseArea == 0) ? "success" : "error");
				$secStatus['area_utilisation'] = $leaseAreaStatus;

				// PART II: EMPLOYMENT & WAGES I
				$reason['employment_wages'] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partII', 1);
				$reason['status']['employment_wages'] = (isset($reason['employment_wages']['commented']) && $reason['employment_wages']['commented'] == '1') ? 'success' : 'pending';
				$reason['status']['employment_wages'] = ($formStatus == 'read') ? 'success' : $reason['status']['employment_wages'];
				$empWageRecord = $this->RentReturns->isFilledByFormType($mine_code, $returnType, $returnDate, 1);
				$empWageStatus = (isset($app_sec['partII'][1]) && $app_sec['partII'][1] == 'Rejected') ? $reason['status']['employment_wages'] : (($empWageRecord == 1) ? "success" : "error");
				$secStatus['employment_wages'] = $empWageStatus;
				
				// PART II: EMPLOYMENT & WAGES II
				$reason['employment_wages_part'] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partII', 3);
				$reason['status']['employment_wages_part'] = (isset($reason['employment_wages_part']['commented']) && $reason['employment_wages_part']['commented'] == '1') ? 'success' : 'pending';
				$reason['status']['employment_wages_part'] = ($formStatus == 'read') ? 'success' : $reason['status']['employment_wages_part'];
				$empWagePartRecord = $this->Employment->isFilledEmpWagePart($mine_code, $returnDate);
				$empWagePartStatus = (isset($app_sec['partII'][3]) && $app_sec['partII'][3] == 'Rejected') ? $reason['status']['employment_wages_part'] : (($empWagePartRecord == 1) ? "success" : "error");
				$secStatus['employment_wages_part'] = $empWagePartStatus;
				
				// PART II: CAPITAL STRUCTURE
				$reason['capital_structure'] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partII', 2);
				$reason['status']['capital_structure'] = (isset($reason['capital_structure']['commented']) && $reason['capital_structure']['commented'] == '1') ? 'success' : 'pending';
				$reason['status']['capital_structure'] = ($formStatus == 'read') ? 'success' : $reason['status']['capital_structure'];
				$capStrucRecord = $this->CapitalStructure->isFilled($mine_code, $returnDate);
				$capStrucStatus = (isset($app_sec['partII'][2]) && $app_sec['partII'][2] == 'Rejected') ? $reason['status']['capital_structure'] : (($capStrucRecord == 1) ? "success" : "error");
				$secStatus['capital_structure'] = $capStrucStatus;
				
    			// PART III: QUANTITY & COST OF MATERIAL
				$reason['material_consumption_quantity'] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partIII', 1);
				$reason['status']['material_consumption_quantity'] = (isset($reason['material_consumption_quantity']['commented']) && $reason['material_consumption_quantity']['commented'] == '1') ? 'success' : 'pending';
				$reason['status']['material_consumption_quantity'] = ($formStatus == 'read') ? 'success' : $reason['status']['material_consumption_quantity'];
				$matConsQtyRecord = $this->MaterialConsumption->isFilled($mine_code, $returnDate);
				$matConsQtyStatus = (isset($app_sec['partIII'][1]) && $app_sec['partIII'][1] == 'Rejected') ? $reason['status']['material_consumption_quantity'] : (($matConsQtyRecord == 1) ? "success" : "error");
				$secStatus['material_consumption_quantity'] = $matConsQtyStatus;
				
    			// PART III: ROYALTY / COMPENSATION / DEPRECIATION
				$reason['material_consumption_royalty'] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partIII', 2);
				$reason['status']['material_consumption_royalty'] = (isset($reason['material_consumption_royalty']['commented']) && $reason['material_consumption_royalty']['commented'] == '1') ? 'success' : 'pending';
				$reason['status']['material_consumption_royalty'] = ($formStatus == 'read') ? 'success' : $reason['status']['material_consumption_royalty'];
				$matConsRoyRecord = $this->RentReturns->isFilledByFormType($mine_code, $returnType, $returnDate, 2);
				$matConsRoyStatus = (isset($app_sec['partIII'][2]) && $app_sec['partIII'][2] == 'Rejected') ? $reason['status']['material_consumption_royalty'] : (($matConsRoyRecord == 1) ? "success" : "error");
				$secStatus['material_consumption_royalty'] = $matConsRoyStatus;
				
    			// PART III: TAXES / OTHER EXPENSES
				$reason['material_consumption_tax'] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partIII', 3);
				$reason['status']['material_consumption_tax'] = (isset($reason['material_consumption_tax']['commented']) && $reason['material_consumption_tax']['commented'] == '1') ? 'success' : 'pending';
				$reason['status']['material_consumption_tax'] = ($formStatus == 'read') ? 'success' : $reason['status']['material_consumption_tax'];
				$matConsTaxRecord = $this->RentReturns->isFilledByFormType($mine_code, $returnType, $returnDate, 3);
				$matConsTaxStatus = (isset($app_sec['partIII'][3]) && $app_sec['partIII'][3] == 'Rejected') ? $reason['status']['material_consumption_tax'] : (($matConsTaxRecord == 1) ? "success" : "error");
				$secStatus['material_consumption_tax'] = $matConsTaxStatus;
				
				// PART IV: CONSUMPTION OF EXPLOSIVES
				$reason['explosive_consumption'] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partIV', 1);
				$reason['status']['explosive_consumption'] = (isset($reason['explosive_consumption']['commented']) && $reason['explosive_consumption']['commented'] == '1') ? 'success' : 'pending';
				$reason['status']['explosive_consumption'] = ($formStatus == 'read') ? 'success' : $reason['status']['explosive_consumption'];
				$expConsumRecord = $this->ExplosiveConsumption->isFilled($mine_code, $returnDate, $returnType);
				$expConsumStatus = (isset($app_sec['partIV'][1]) && $app_sec['partIV'][1] == 'Rejected') ? $reason['status']['explosive_consumption'] : (($expConsumRecord == 1) ? "success" : "error");
				$secStatus['explosive_consumption'] = $expConsumStatus;
				
				// PART V:
				$mineralArr = $this->Session->read('mineralArr');
				$formType12 = $this->Session->read('mc_form_type');

    			// PART V: SEC 1 : EXPLORATION
				$reason['geology_exploration'] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partV', 1);
				$reason['status']['geology_exploration'] = (isset($reason['geology_exploration']['commented']) && $reason['geology_exploration']['commented'] == '1') ? 'success' : 'pending';
				$reason['status']['geology_exploration'] = ($formStatus == 'read') ? 'success' : $reason['status']['geology_exploration'];
				$geoExpRecord = $this->ExplorationDetails->isFilled($mine_code, $returnType, $returnDate);
				$geoExpStatus = (isset($app_sec['partV'][1]) && $app_sec['partV'][1] == 'Rejected') ? $reason['status']['geology_exploration'] : (($geoExpRecord == 1) ? "success" : "error");
				$secStatus['geology_exploration'] = $geoExpStatus;
				
    			// PART V: SEC 4/5 : OVERBURDEN AND WASTE / TREES PLANTED- SURVIVAL RATE
				$reason['geology_overburden_trees'] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partV', 3);

				$reason['status']['geology_overburden_trees'] = (isset($reason['geology_overburden_trees']['commented']) && $reason['geology_overburden_trees']['commented'] == '1') ? 'success' : 'pending';
				$reason['status']['geology_overburden_trees'] = ($formStatus == 'read') ? 'success' : $reason['status']['geology_overburden_trees'];
				$geoOverburdTreeRecord = $this->TreesPlantSurvival->isFilled($mine_code, $returnType, $returnDate);
				$geoOverburdTreeStatus = (isset($app_sec['partV'][3]) && $app_sec['partV'][3] == 'Rejected') ? $reason['status']['geology_overburden_trees'] : (($geoOverburdTreeRecord == 1) ? "success" : "error");
				$secStatus['geology_overburden_trees'] = $geoOverburdTreeStatus;
				
    			// PART V: SEC 6 :  TYPE OF MACHINERY
				$reason['geology_part_three'] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partV', 4);
				$reason['status']['geology_part_three'] = (isset($reason['geology_part_three']['commented']) && $reason['geology_part_three']['commented'] == '1') ? 'success' : 'pending';
				$reason['status']['geology_part_three'] = ($formStatus == 'read') ? 'success' : $reason['status']['geology_part_three'];
				$geoPartThreeRecord = $this->Machinery->isFilled($mine_code, $returnType, $returnDate, $formType12, 1);
				$geoPartThreeStatus = (isset($app_sec['partV'][4]) && $app_sec['partV'][4] == 'Rejected') ? $reason['status']['geology_part_three'] : (($geoPartThreeRecord == 1) ? "success" : "error");
				$secStatus['geology_part_three'] = $geoPartThreeStatus;
				
				foreach($mineralArr as $mineral){
					$mineral_name = strtolower($mineral);
					$mineral_sp = str_replace('_',' ',$mineral_name);
					$min_und_low = strtolower(str_replace(' ','_',$mineral)); // mineral underscore lowercase

					// PART V: SEC 2/3 : RESERVES AND RESOURCES ESTIMATED / SUBGRADE-MINERAL REJECT

					$reason['geology_reserves_subgrade'] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partV', 2, $mineral);
					
					$reason['status']['geology_reserves_subgrade'] = (isset($reason['geology_reserves_subgrade']['commented']) && $reason['geology_reserves_subgrade']['commented'] == '1') ? 'success' : 'pending';
					$reason['status']['geology_reserves_subgrade'] = ($formStatus == 'read') ? 'success' : $reason['status']['geology_reserves_subgrade'];
					$geoResSubgradeRecord = $this->ReservesResources->isFilled($mine_code, $returnType, $returnDate, $mineral_name);
					$geoResSubgradeStatus = (isset($app_sec['partV'][2][$min_und_low]) && $app_sec['partV'][2][$min_und_low] == 'Rejected') ? $reason['status']['geology_reserves_subgrade'] : (($geoResSubgradeRecord == 1) ? "success" : "error");
					$secStatus['geology_reserves_subgrade'][$mineral_name] = $geoResSubgradeStatus;
					
    				// PART V: SEC 7 : MINERAL TREATMENT PLANT
					$reason['geology_part_six'] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partV', 5, $mineral_name);
					//print_r($reason['geology_part_six']);
					$reason['status']['geology_part_six'] = (isset($reason['geology_part_six']['commented']) && $reason['geology_part_six']['commented'] == '1') ? 'success' : 'pending';
					$reason['status']['geology_part_six'] = ($formStatus == 'read') ? 'success' : $reason['status']['geology_part_six'];
					$geoPartSixRecord = $this->Machinery->isFilledPartSix($mine_code, $returnType, $returnDate, $mineral_name, 2, 2);
					
					$geoPartSixStatus = (isset($app_sec['partV'][5][$min_und_low]) && $app_sec['partV'][5][$min_und_low] == 'Rejected') ? $reason['status']['geology_part_six'] : (($geoPartSixRecord == 1) ? "success" : "error");
					$secStatus['geology_part_six'][$mineral_name] = $geoPartSixStatus;

				}

				//PART VI:
				$mcFormMain = $this->Session->read('mc_form_main');
				$mineralArr = $this->Session->read('mineralArr');
				
				$minHematite = $this->Prod1->fetchIronTypeProduction($mine_code, $returnType, $returnDate, 'iron_ore', 'hematite');
				$minMagnetite = $this->Prod1->fetchIronTypeProduction($mine_code, $returnType, $returnDate, 'iron_ore', 'magnetite');
		
				if($minHematite == true){
					$is_hematite = true;
				} else {
					$is_hematite = false;
				}
		
				if($minMagnetite == true){
					$is_magnetite = true;
				} else {
					$is_magnetite = false;
				}
				
				foreach($mineralArr as $mineral){
		
					$mineral_name = strtolower($mineral);
					$mineral_sp = str_replace('_',' ',$mineral_name);
					$mineral_ul = str_replace(' ','_',$mineral_name); //mineral underscore lowercase

					//set sub mineral
					if($mineral_name == 'iron ore'){
						if($is_hematite == true){
							$ironSubMin = 'hematite';
						} else if($is_magnetite == true){
							$ironSubMin = 'magnetite';
						} else {
							$ironSubMin = '';
						}
					} else {
						$ironSubMin = '';
					}
					
					$formNo = $this->DirMcpMineral->getFormNumber($mineral);
					$formNoNew = (in_array($formNo, array('1','2','3','4','8'))) ? 1 : (($formNo == 5) ? 2 : 3);
					$reason_no = array();
					if ($formNo == 6){
						$reason_no['deduct_detail'] = 2;
						$reason_no['sale_despatch'] = 3;
					}
					else if ($formNo == 5){
						$reason_no['deduct_detail'] = 6;
						$reason_no['sale_despatch'] = 7;
					}
					else {
						$reason_no['deduct_detail'] = 3;
						$reason_no['sale_despatch'] = 4;
					}
		
					// if($mcFormMain == 1){
					if($formNoNew == 1){
		
						//PART VI: TYPE OF ORE
						$oreTypeStatus = ($is_hematite == true || $is_magnetite == true) ? "success" : "error";
						$secStatus['ore_type'][$mineral_name] = $oreTypeStatus;
		
						//PART VI: Production / Stocks (ROM) (Form F1)
						// if($mineral_name == 'iron ore'){
						// 	if($is_hematite == true){
								$reason['rom_stocks'][$mineral_name.'/hematite'] = $this->TblFinalSubmit->getReason($return_id, $mineral_name, 'hematite', 1, 'applicant');
								$reason['status']['rom_stocks'][$mineral_name.'/hematite'] = (isset($reason['rom_stocks'][$mineral_name.'/hematite']['commented']) && $reason['rom_stocks'][$mineral_name.'/hematite']['commented'] == '1') ? 'success' : 'pending';
								$reason['status']['rom_stocks'][$mineral_name.'/hematite'] = ($formStatus == 'read') ? 'success' : $reason['status']['rom_stocks'][$mineral_name.'/hematite'];
								$prodArr = $this->Prod1->isFilledOreType($mine_code, $returnType, $returnDate, $mineral_name, 'hematite');
								$prodArrStatus = (isset($app_sec[$mineral_ul]['hematite'][1]) && $app_sec[$mineral_ul]['hematite'][1] == 'Rejected') ? $reason['status']['rom_stocks'][$mineral_name.'/hematite'] : (($prodArr == 1) ? "success" : "error");
								$secStatus['rom_stocks'][$mineral_name.'/hematite'] = $prodArrStatus;
							// }
							// if($is_magnetite == true){
								$reason['rom_stocks'][$mineral_name.'/magnetite'] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, 'magnetite', 1, 'applicant');
								$reason['status']['rom_stocks'][$mineral_name.'/magnetite'] = (isset($reason['rom_stocks'][$mineral_name.'/magnetite']['commented']) && $reason['rom_stocks'][$mineral_name.'/magnetite']['commented'] == '1') ? 'success' : 'pending';
								$reason['status']['rom_stocks'][$mineral_name.'/magnetite'] = ($formStatus == 'read') ? 'success' : $reason['status']['rom_stocks'][$mineral_name.'/magnetite'];
								$prodArr = $this->Prod1->isFilledOreType($mine_code, $returnType, $returnDate, $mineral_name, 'magnetite');
								$prodArrStatus = (isset($app_sec[$mineral_ul]['magnetite'][1]) && $app_sec[$mineral_ul]['magnetite'][1] == 'Rejected') ? $reason['status']['rom_stocks'][$mineral_name.'/magnetite'] : (($prodArr == 1) ? "success" : "error");
								$secStatus['rom_stocks'][$mineral_name.'/magnetite'] = $prodArrStatus;
							// }
							// if($is_hematite != true && $is_magnetite != true){
								$reason['rom_stocks'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, '', 1, 'applicant');
								$reason['status']['rom_stocks'][$mineral_name] = (isset($reason['rom_stocks'][$mineral_name]['commented']) && $reason['rom_stocks'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
								$reason['status']['rom_stocks'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['rom_stocks'][$mineral_name];
								$prodArr = $this->Prod1->isFilledOreType($mine_code, $returnType, $returnDate, $mineral_name, '');
								$prodArrStatus = (isset($app_sec[$mineral_ul][1]) && $app_sec[$mineral_ul][1] == 'Rejected') ? $reason['status']['rom_stocks'][$mineral_name] : (($prodArr == 1) ? "success" : "error");
								$secStatus['rom_stocks'][$mineral_name] = $prodArrStatus;
							// }
						// } else {
						// 	$prodArr = $this->Prod1->fetchProduction($mine_code, $returnType, $returnDate, $mineral_name, '');
						// 	$prodArrStatus = (isset($app_sec[$mineral_ul][1]) && $app_sec[$mineral_ul][1] == 'Rejected') ? 'pending' : (($prodArr['open_oc_rom'] != '' && $prodArr['prod_oc_rom'] != '' && $prodArr['clos_oc_rom'] != '' && $prodArr['open_ug_rom'] != '' && $prodArr['prod_ug_rom'] != '' && $prodArr['clos_ug_rom'] != '' && $prodArr['open_dw_rom'] != '' && $prodArr['prod_dw_rom'] != '' && $prodArr['clos_dw_rom'] != '') ? "success" : "error");
						// 	$secStatus['rom_stocks'][$mineral_name] = $prodArrStatus;
						// }
						
						//PART VI: Production / Stocks (ROM) (Form F7)
						$reason['rom_stocks_three'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, '', 1, 'applicant');
						$reason['status']['rom_stocks_three'][$mineral_name] = (isset($reason['rom_stocks_three'][$mineral_name]['commented']) && $reason['rom_stocks_three'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['rom_stocks_three'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['rom_stocks_three'][$mineral_name];
						$romData = $this->RomStone->getRomData($mine_code, $returnType, $returnDate, $mineral_name);
						$romDataStatus = (isset($app_sec[$mineral_ul][1]) && $app_sec[$mineral_ul][1] == 'Rejected') ? $reason['status']['rom_stocks_three'][$mineral_name] : (($romData['count'] != 0) ? "success" : "error");
						$secStatus['rom_stocks_three'][$mineral_name] = $romDataStatus;
		
						//PART VI: Grade-Wise Production
						
						// if($mineral_name == 'iron ore'){
						// 	if($is_hematite == true){
								$reason['gradewise_prod'][$mineral_name.'/hematite'] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, 'hematite', 2, 'applicant');
								$reason['status']['gradewise_prod'][$mineral_name.'/hematite'] = (isset($reason['gradewise_prod'][$mineral_name.'/hematite']['commented']) && $reason['gradewise_prod'][$mineral_name.'/hematite']['commented'] == '1') ? 'success' : 'pending';
								$reason['status']['gradewise_prod'][$mineral_name.'/hematite'] = ($formStatus == 'read') ? 'success' : $reason['status']['gradewise_prod'][$mineral_name.'/hematite'];
								$gradeArr = $this->GradeProd->isFilledGradeProd($mine_code, $returnType, $returnDate, str_replace(' ','_',$mineral_name), '', 'hematite');
								$gradeArrStatus = (isset($app_sec[$mineral_ul]['hematite'][2]) && $app_sec[$mineral_ul]['hematite'][2] == 'Rejected') ? $reason['status']['gradewise_prod'][$mineral_name.'/hematite'] : (($gradeArr == 1) ? "success" : "error");
								$secStatus['gradewise_prod'][$mineral_name.'/hematite'] = $gradeArrStatus;
							// }
							// if($is_magnetite == true){
								$reason['gradewise_prod'][$mineral_name.'/magnetite'] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, 'magnetite', 2, 'applicant');
								$reason['status']['gradewise_prod'][$mineral_name.'/magnetite'] = (isset($reason['gradewise_prod'][$mineral_name.'/magnetite']['commented']) && $reason['gradewise_prod'][$mineral_name.'/magnetite']['commented'] == '1') ? 'success' : 'pending';
								$reason['status']['gradewise_prod'][$mineral_name.'/magnetite'] = ($formStatus == 'read') ? 'success' : $reason['status']['gradewise_prod'][$mineral_name.'/magnetite'];
								$gradeArr = $this->GradeProd->isFilledGradeProd($mine_code, $returnType, $returnDate, str_replace(' ','_',$mineral_name), '', 'magnetite');
								$gradeArrStatus = (isset($app_sec[$mineral_ul]['magnetite'][2]) && $app_sec[$mineral_ul]['magnetite'][2] == 'Rejected') ? $reason['status']['gradewise_prod'][$mineral_name.'/magnetite'] : (($gradeArr == 1) ? "success" : "error");
								$secStatus['gradewise_prod'][$mineral_name.'/magnetite'] = $gradeArrStatus;
							// }
							// if($is_hematite != true && $is_magnetite != true){
								$reason['gradewise_prod'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, '', 2, 'applicant');
								$reason['status']['gradewise_prod'][$mineral_name] = (isset($reason['gradewise_prod'][$mineral_name]['commented']) && $reason['gradewise_prod'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
								$reason['status']['gradewise_prod'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['gradewise_prod'][$mineral_name];
								$gradeArr = $this->GradeProd->isFilledGradeProd($mine_code, $returnType, $returnDate, str_replace(' ','_',$mineral_name), '');
								$gradeArrStatus = (isset($app_sec[$mineral_ul][2]) && $app_sec[$mineral_ul][2] == 'Rejected') ? $reason['status']['gradewise_prod'][$mineral_name] : (($gradeArr == 1) ? "success" : "error");
								$secStatus['gradewise_prod'][$mineral_name] = $gradeArrStatus;
						// 	}
						// } else {
						// 	$gradeArr = $this->GradeProd->fetchGradeWiseProd($mine_code, $returnType, $returnDate, $mineral_name, '');
						// 	$gradeArrStatus = (isset($app_sec[$mineral_ul][2]) && $app_sec[$mineral_ul][2] == 'Rejected') ? 'pending' : (($gradeArr['id'] != '') ? "success" : "error");
						// 	$secStatus['gradewise_prod'][$mineral_name] = $gradeArrStatus;
						// }

						//PART VI: Production, Despatches and Stocks (Form F7)
						$reason['prod_stock_dis'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, '', 2, 'applicant');
						$reason['status']['prod_stock_dis'][$mineral_name] = (isset($reason['prod_stock_dis'][$mineral_name]['commented']) && $reason['prod_stock_dis'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['prod_stock_dis'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['prod_stock_dis'][$mineral_name];
						$roughStoneData = $this->ProdStone->getProdStoneData($mine_code, $returnDate, $mineral_name, 1, $returnType);
						$cutStoneData = $this->ProdStone->getProdStoneData($mine_code, $returnDate, $mineral_name, 2, $returnType);
						$indStoneData = $this->ProdStone->getProdStoneData($mine_code, $returnDate, $mineral_name, 3, $returnType);
						$othStoneData = $this->ProdStone->getProdStoneData($mine_code, $returnDate, $mineral_name, 99, $returnType);
						$prodStockDisStatus = (isset($app_sec[$mineral_ul][2]) && $app_sec[$mineral_ul][2] == 'Rejected') ? $reason['status']['prod_stock_dis'][$mineral_name] : (($roughStoneData['count'] != 0 && $cutStoneData['count'] != 0 && $indStoneData['count'] != 0 && $othStoneData['count'] != 0) ? "success" : "error");
						$secStatus['prod_stock_dis'][$mineral_name] = $prodStockDisStatus;
		
						//PART VI: Pulverisation
						$reason['pulverisation'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $ironSubMin, 5, 'applicant');
						$reason['status']['pulverisation'][$mineral_name] = (isset($reason['pulverisation'][$mineral_name]['commented']) && $reason['pulverisation'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['pulverisation'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['pulverisation'][$mineral_name];
						$pulverArr = $this->Pulverisation->isFilled($mine_code, $returnType, $returnDate, $mineral_name);
						$pulverArrStatus = (isset($app_sec[$mineral_ul][5]) && $app_sec[$mineral_ul][5] == 'Rejected') ? $reason['status']['pulverisation'][$mineral_name] : (($pulverArr == 1) ? "success" : "error");
						$secStatus['pulverisation'][$mineral_name] = $pulverArrStatus;
		
						//PART VI: Details of Deductions
						
						// if($mineral_name == 'iron ore'){
							//hematite
							$reason['deduct_detail'][$mineral_name.'/hematite'] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $ironSubMin, $reason_no['deduct_detail'], 'applicant');
							$reason['status']['deduct_detail'][$mineral_name.'/hematite'] = (isset($reason['deduct_detail'][$mineral_name.'/hematite']['commented']) && $reason['deduct_detail'][$mineral_name.'/hematite']['commented'] == '1') ? 'success' : 'pending';
							$reason['status']['deduct_detail'][$mineral_name.'/hematite'] = ($formStatus == 'read') ? 'success' : $reason['status']['deduct_detail'][$mineral_name.'/hematite'];
							$prodDeductArr = $this->Prod1->fetchProduction($mine_code, $returnType, $returnDate, $mineral, $ironSubMin);
							$prodDeductArrStatus = (isset($app_sec[$mineral_ul]['hematite'][3]) && $app_sec[$mineral_ul]['hematite'][3] == 'Rejected') ? $reason['status']['deduct_detail'][$mineral_name.'/hematite'] : (($prodDeductArr['trans_cost'] != '' && $prodDeductArr['loading_charges'] != '' && $prodDeductArr['railway_freight'] != '' && $prodDeductArr['port_handling'] != '' && $prodDeductArr['sampling_cost'] != '' && $prodDeductArr['plot_rent'] != '' && $prodDeductArr['other_cost'] != '' && $prodDeductArr['total_prod'] != '' && $prodDeductArr['return_type'] == 'ANNUAL') ? "success" : "error");
							$secStatus['deduct_detail'][$mineral_name.'/hematite'] = $prodDeductArrStatus;
							
							//magnetite
							$reason['deduct_detail'][$mineral_name.'/magnetite'] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $ironSubMin, $reason_no['deduct_detail'], 'applicant');
							$reason['status']['deduct_detail'][$mineral_name.'/magnetite'] = (isset($reason['deduct_detail'][$mineral_name.'/magnetite']['commented']) && $reason['deduct_detail'][$mineral_name.'/magnetite']['commented'] == '1') ? 'success' : 'pending';
							$reason['status']['deduct_detail'][$mineral_name.'/magnetite'] = ($formStatus == 'read') ? 'success' : $reason['status']['deduct_detail'][$mineral_name.'/magnetite'];
							$prodDeductArr = $this->Prod1->fetchProduction($mine_code, $returnType, $returnDate, $mineral, $ironSubMin);
							$prodDeductArrStatus = (isset($app_sec[$mineral_ul]['magnetite'][3]) && $app_sec[$mineral_ul]['magnetite'][3] == 'Rejected') ? $reason['status']['deduct_detail'][$mineral_name.'/magnetite'] : (($prodDeductArr['trans_cost'] != '' && $prodDeductArr['loading_charges'] != '' && $prodDeductArr['railway_freight'] != '' && $prodDeductArr['port_handling'] != '' && $prodDeductArr['sampling_cost'] != '' && $prodDeductArr['plot_rent'] != '' && $prodDeductArr['other_cost'] != '' && $prodDeductArr['total_prod'] != '' && $prodDeductArr['return_type'] == 'ANNUAL') ? "success" : "error");
							$secStatus['deduct_detail'][$mineral_name.'/magnetite'] = $prodDeductArrStatus;

							//other
							$reason['deduct_detail'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $ironSubMin, $reason_no['deduct_detail'], 'applicant');
							$reason['status']['deduct_detail'][$mineral_name] = (isset($reason['deduct_detail'][$mineral_name]['commented']) && $reason['deduct_detail'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
							$reason['status']['deduct_detail'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['deduct_detail'][$mineral_name];
							// $prodDeductArr = $this->Prod1->fetchProduction($mine_code, $returnType, $returnDate, $mineral, $ironSubMin);
							$prodDeductArr = $this->Prod1->isDeductionFilledByMineral($mine_code, $returnDate, $returnType, $mineral, $ironSubMin);
							$prodDeductArrStatus = (isset($app_sec[$mineral_ul][3]) && $app_sec[$mineral_ul][3] == 'Rejected') ? $reason['status']['deduct_detail'][$mineral_name] : (($prodDeductArr == 1) ? "success" : "error");
							$secStatus['deduct_detail'][$mineral_name] = $prodDeductArrStatus;
						// }
		
						//PART VI: Sales/Dispatches
						// if($mineral_name == 'iron ore'){
							//hematite
							$reason['sale_despatch'][$mineral_name.'/hematite'] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $ironSubMin, $reason_no['sale_despatch'], 'applicant');
							$reason['status']['sale_despatch'][$mineral_name.'/hematite'] = (isset($reason['sale_despatch'][$mineral_name.'/hematite']['commented']) && $reason['sale_despatch'][$mineral_name.'/hematite']['commented'] == '1') ? 'success' : 'pending';
							$reason['status']['sale_despatch'][$mineral_name.'/hematite'] = ($formStatus == 'read') ? 'success' : $reason['status']['sale_despatch'][$mineral_name.'/hematite'];
							$gradeSaleArr = $this->GradeSale->fetchSalesData($mine_code, $returnType, $returnDate, $mineral_name);
							$gradeSaleArrStatus = (isset($app_sec[$mineral_ul]['hematite'][4]) && $app_sec[$mineral_ul]['hematite'][4] == 'Rejected') ? $reason['status']['sale_despatch'][$mineral_name.'/hematite'] : (($gradeSaleArr[0]['id'] != '' && $gradeSaleArr[0]['return_type'] == 'ANNUAL') ? "success" : "error");
							$secStatus['sale_despatch'][$mineral_name.'/hematite'] = $gradeSaleArrStatus;
							
							//magnetite
							$reason['sale_despatch'][$mineral_name.'/magnetite'] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $ironSubMin, $reason_no['sale_despatch'], 'applicant');
							$reason['status']['sale_despatch'][$mineral_name.'/magnetite'] = (isset($reason['sale_despatch'][$mineral_name.'/magnetite']['commented']) && $reason['sale_despatch'][$mineral_name.'/magnetite']['commented'] == '1') ? 'success' : 'pending';
							$reason['status']['sale_despatch'][$mineral_name.'/magnetite'] = ($formStatus == 'read') ? 'success' : $reason['status']['sale_despatch'][$mineral_name.'/magnetite'];
							$gradeSaleArr = $this->GradeSale->fetchSalesData($mine_code, $returnType, $returnDate, $mineral_name);
							$gradeSaleArrStatus = (isset($app_sec[$mineral_ul]['magnetite'][4]) && $app_sec[$mineral_ul]['magnetite'][4] == 'Rejected') ? $reason['status']['sale_despatch'][$mineral_name.'/magnetite'] : (($gradeSaleArr[0]['id'] != '' && $gradeSaleArr[0]['return_type'] == 'ANNUAL') ? "success" : "error");
							$secStatus['sale_despatch'][$mineral_name.'/magnetite'] = $gradeSaleArrStatus;

							//other
							$reason['sale_despatch'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $ironSubMin, $reason_no['sale_despatch'], 'applicant');
							$reason['status']['sale_despatch'][$mineral_name] = (isset($reason['sale_despatch'][$mineral_name]['commented']) && $reason['sale_despatch'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
							$reason['status']['sale_despatch'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['sale_despatch'][$mineral_name];
							$gradeSaleArr = $this->GradeSale->fetchSalesData($mine_code, $returnType, $returnDate, $mineral_name);
							$gradeSaleArrStatus = (isset($app_sec[$mineral_ul][4]) && $app_sec[$mineral_ul][4] == 'Rejected') ? $reason['status']['sale_despatch'][$mineral_name] : (($gradeSaleArr[0]['id'] != '' && $gradeSaleArr[0]['return_type'] == 'ANNUAL') ? "success" : "error");
							$secStatus['sale_despatch'][$mineral_name] = $gradeSaleArrStatus;
						// }
		
					// } else if($mcFormMain == 2){
					} else if($formNoNew == 2){
		
						//PART II: Production / Stocks (ROM)
						$reason['rom_stocks_ore'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, '', 1, 'applicant');
						$reason['status']['rom_stocks_ore'][$mineral_name] = (isset($reason['rom_stocks_ore'][$mineral_name]['commented']) && $reason['rom_stocks_ore'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['rom_stocks_ore'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['rom_stocks_ore'][$mineral_name];
						$romData = $this->Rom5->isFilledRom($mine_code, $returnDate, $returnType, $mineral_name);
						$romDataStatus = (isset($app_sec[$mineral_ul][1]) && $app_sec[$mineral_ul][1] == 'Rejected') ? $reason['status']['rom_stocks_ore'][$mineral_name] : (($romData == 0) ? "success" : "error");
						$secStatus['rom_stocks_ore'][$mineral_name] = $romDataStatus;
		
						//PART II: Ex-Mine Price
						$reason['ex_mine'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, '', 2, 'applicant');
						$reason['status']['ex_mine'][$mineral_name] = (isset($reason['ex_mine'][$mineral_name]['commented']) && $reason['ex_mine'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['ex_mine'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['ex_mine'][$mineral_name];
						$prod5 = $this->Prod5->isFilled($mine_code, $returnDate, $returnType, $mineral);
						$prod5Status = (isset($app_sec[$mineral_ul][2]) && $app_sec[$mineral_ul][2] == 'Rejected') ? $reason['status']['ex_mine'][$mineral_name] : (($prod5 == 0) ? "success" : "error");
						$secStatus['ex_mine'][$mineral_name] = $prod5Status;
		
						//PART II: Recoveries at Concentrator
						$reason['con_reco'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, '', 3, 'applicant');
						$reason['status']['con_reco'][$mineral_name] = (isset($reason['con_reco'][$mineral_name]['commented']) && $reason['con_reco'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['con_reco'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['con_reco'][$mineral_name];
						$conRomData = $this->RomMetal5->isFilled($mine_code, $returnDate, $returnType, $mineral);
						$conRomDataStatus = (isset($app_sec[$mineral_ul][3]) && $app_sec[$mineral_ul][3] == 'Rejected') ? $reason['status']['con_reco'][$mineral_name] : (($conRomData == 0) ? "success" : "error");
						$secStatus['con_reco'][$mineral_name] = $conRomDataStatus;
		
						//PART II: Recovery at the Smelter
						$reason['smelt_reco'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, '', 4, 'applicant');
						$reason['status']['smelt_reco'][$mineral_name] = (isset($reason['smelt_reco'][$mineral_name]['commented']) && $reason['smelt_reco'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['smelt_reco'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['smelt_reco'][$mineral_name];
						$recovSmelter = $this->RecovSmelter->isFilled($mine_code, $returnDate, $returnType, $mineral);
						$recovSmelterStatus = (isset($app_sec[$mineral_ul][4]) && $app_sec[$mineral_ul][4] == 'Rejected') ? $reason['status']['smelt_reco'][$mineral_name] : (($recovSmelter == 0) ? "success" : "error");
						$secStatus['smelt_reco'][$mineral_name] = $recovSmelterStatus;
		
						//PART II: Sales(Metals/By Product)
						$reason['sales_metal_product'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, '', 5, 'applicant');
						$reason['status']['sales_metal_product'][$mineral_name] = (isset($reason['sales_metal_product'][$mineral_name]['commented']) && $reason['sales_metal_product'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['sales_metal_product'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['sales_metal_product'][$mineral_name];
						$salesData = $this->Sale5->isFilled($mine_code, $returnDate, $returnType, $mineral);
						$salesDataStatus = (isset($app_sec[$mineral_ul][5]) && $app_sec[$mineral_ul][5] == 'Rejected') ? $reason['status']['sales_metal_product'][$mineral_name] : (($salesData == 0) ? "success" : "error");
						$secStatus['sales_metal_product'][$mineral_name] = $salesDataStatus;
		
						//PART II: Details of Deductions
						$reason['deduct_detail'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $ironSubMin, $reason_no['deduct_detail'], 'applicant');
						$reason['status']['deduct_detail'][$mineral_name] = (isset($reason['deduct_detail'][$mineral_name]['commented']) && $reason['deduct_detail'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['deduct_detail'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['deduct_detail'][$mineral_name];
						$detDeduct = $this->Prod1->isDeductionFilledByMineral($mine_code, $returnDate, $returnType, $mineral_name, '');
						$prodDeductArrStatus = (isset($app_sec[$mineral_ul][6]) && $app_sec[$mineral_ul][6] == 'Rejected') ? $reason['status']['deduct_detail'][$mineral_name] : (($detDeduct == 1) ? "success" : "error");
						$secStatus['deduct_detail'][$mineral_name] = $prodDeductArrStatus;
		
						//PART II: Sales/Dispatches
						$reason['sale_despatch'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $ironSubMin, $reason_no['sale_despatch'], 'applicant');
						$reason['status']['sale_despatch'][$mineral_name] = (isset($reason['sale_despatch'][$mineral_name]['commented']) && $reason['sale_despatch'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['sale_despatch'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['sale_despatch'][$mineral_name];
						$gradeSaleArr = $this->GradeSale->fetchSalesData($mine_code, $returnType, $returnDate, $mineral_name);
						$gradeSaleArrStatus = (isset($app_sec[$mineral_ul][7]) && $app_sec[$mineral_ul][7] == 'Rejected') ? $reason['status']['sale_despatch'][$mineral_name] : (($gradeSaleArr[0]['id'] != '' && $gradeSaleArr[0]['return_type'] == 'ANNUAL') ? "success" : "error");
						$secStatus['sale_despatch'][$mineral_name] = $gradeSaleArrStatus;
						
					// } else if($mcFormMain == 3){
					} else if($formNoNew == 3){
		
						//PART II: Production / Stocks (ROM) (Form F7)
						$reason['rom_stocks_three'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, '', 1, 'applicant');
						$reason['status']['rom_stocks_three'][$mineral_name] = (isset($reason['rom_stocks_three'][$mineral_name]['commented']) && $reason['rom_stocks_three'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['rom_stocks_three'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['rom_stocks_three'][$mineral_name];
						$romData = $this->RomStone->isFilledRomData($mine_code, $returnDate, $returnType, $mineral_name);
						$romDataStatus = (isset($app_sec[$mineral_ul][1]) && $app_sec[$mineral_ul][1] == 'Rejected') ? $reason['status']['rom_stocks_three'][$mineral_name] : (($romData == 1) ? "success" : "error");
						$secStatus['rom_stocks_three'][$mineral_name] = $romDataStatus;
						
						//PART II: Production / Stocks (ROM) (Form F8)
						$reason['rom_stocks'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, '', 1, 'applicant');
						$reason['status']['rom_stocks'][$mineral_name] = (isset($reason['rom_stocks'][$mineral_name]['commented']) && $reason['rom_stocks'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['rom_stocks'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['rom_stocks'][$mineral_name];
						$prodArr = $this->Prod1->isFilledOreType($mine_code, $returnType, $returnDate, $mineral_name, '');
						$prodArrStatus = (isset($app_sec[$mineral_ul][1]) && $app_sec[$mineral_ul][1] == 'Rejected') ? $reason['status']['rom_stocks'][$mineral_name] : (($prodArr == 1) ? "success" : "error");
						$secStatus['rom_stocks'][$mineral_name] = $prodArrStatus;
						
						//PART II: Grade-Wise Production (Form F8)
						$reason['gradewise_prod'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, '', 2, 'applicant');
						$reason['status']['gradewise_prod'][$mineral_name] = (isset($reason['gradewise_prod'][$mineral_name]['commented']) && $reason['gradewise_prod'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['gradewise_prod'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['gradewise_prod'][$mineral_name];
						$gradeArr = $this->GradeProd->isFilledGradeProd($mine_code, $returnType, $returnDate, str_replace(' ','_',$mineral_name), '');
						$gradeArrStatus = (isset($app_sec[$mineral_ul][2]) && $app_sec[$mineral_ul][2] == 'Rejected') ? $reason['status']['gradewise_prod'][$mineral_name] : (($gradeArr == 1) ? "success" : "error");
						$secStatus['gradewise_prod'][$mineral_name] = $gradeArrStatus;
						
						//PART II: Pulverisation
						$reason['pulverisation'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $ironSubMin, 5, 'applicant');
						$reason['status']['pulverisation'][$mineral_name] = (isset($reason['pulverisation'][$mineral_name]['commented']) && $reason['pulverisation'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['pulverisation'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['pulverisation'][$mineral_name];
						$pulverArr = $this->Pulverisation->isFilled($mine_code, $returnType, $returnDate, $mineral_name);
						$pulverArrStatus = (isset($app_sec[$mineral_ul][5]) && $app_sec[$mineral_ul][5] == 'Rejected') ? $reason['status']['pulverisation'][$mineral_name] : (($pulverArr == 1) ? "success" : "error");
						$secStatus['pulverisation'][$mineral_name] = $pulverArrStatus;
						
						//PART II: Production, Despatches and Stocks
						$reason['prod_stock_dis'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, '', 2, 'applicant');
						$reason['status']['prod_stock_dis'][$mineral_name] = (isset($reason['prod_stock_dis'][$mineral_name]['commented']) && $reason['prod_stock_dis'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['prod_stock_dis'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['prod_stock_dis'][$mineral_name];
						$roughStoneData = $this->ProdStone->getProdStoneData($mine_code, $returnDate, $mineral_name, 1, $returnType, 1);
						$cutStoneData = $this->ProdStone->getProdStoneData($mine_code, $returnDate, $mineral_name, 2, $returnType, 1);
						$indStoneData = $this->ProdStone->getProdStoneData($mine_code, $returnDate, $mineral_name, 3, $returnType, 1);
						$othStoneData = $this->ProdStone->getProdStoneData($mine_code, $returnDate, $mineral_name, 99, $returnType, 1);
						$prodStockDisStatus = (isset($app_sec[$mineral_ul][2]) && $app_sec[$mineral_ul][2] == 'Rejected') ? $reason['status']['prod_stock_dis'][$mineral_name] : (($roughStoneData['count'] != 0 && $cutStoneData['count'] != 0 && $indStoneData['count'] != 0 && $othStoneData['count'] != 0) ? "success" : "error");
						$secStatus['prod_stock_dis'][$mineral_name] = $prodStockDisStatus;
						
						//PART II: Details of Deductions
						$reason['deduct_detail'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $ironSubMin, $reason_no['deduct_detail'], 'applicant');
						$reason['status']['deduct_detail'][$mineral_name] = (isset($reason['deduct_detail'][$mineral_name]['commented']) && $reason['deduct_detail'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['deduct_detail'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['deduct_detail'][$mineral_name];
						$detDeduct = $this->Prod1->isDeductionFilledByMineral($mine_code, $returnDate, $returnType, $mineral_name, '');
						$detDeductArrStatus = (isset($app_sec[$mineral_ul][3]) && $app_sec[$mineral_ul][3] == 'Rejected') ? $reason['status']['deduct_detail'][$mineral_name] : (($detDeduct == 1) ? "success" : "error");
						$secStatus['deduct_detail'][$mineral_name] = $detDeductArrStatus;
		
						//PART II: Sales/Dispatches
						$reason['sale_despatch'][$mineral_name] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $ironSubMin, $reason_no['sale_despatch'], 'applicant');
						$reason['status']['sale_despatch'][$mineral_name] = (isset($reason['sale_despatch'][$mineral_name]['commented']) && $reason['sale_despatch'][$mineral_name]['commented'] == '1') ? 'success' : 'pending';
						$reason['status']['sale_despatch'][$mineral_name] = ($formStatus == 'read') ? 'success' : $reason['status']['sale_despatch'][$mineral_name];
						$gradeSaleArr = $this->GradeSale->fetchSalesData($mine_code, $returnType, $returnDate, $mineral_name);
						$gradeSaleArrStatus = (isset($app_sec[$mineral_ul][4]) && $app_sec[$mineral_ul][4] == 'Rejected') ? $reason['status']['sale_despatch'][$mineral_name] : (($gradeSaleArr[0]['id'] != '' && $gradeSaleArr[0]['return_type'] == 'ANNUAL') ? "success" : "error");
						$secStatus['sale_despatch'][$mineral_name] = $gradeSaleArrStatus;
		
					}
		
				}
				
    			// PART VII: COST OF PRODUCTION
				$reason['production_cost'] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partVII', 1);
				$reason['status']['production_cost'] = (isset($reason['production_cost']['commented']) && $reason['production_cost']['commented'] == '1') ? 'success' : 'pending';
				$reason['status']['production_cost'] = ($formStatus == 'read') ? 'success' : $reason['status']['production_cost'];
				$prodCostRecord = $this->CostProduction->isFilled($mine_code, $returnType, $returnDate);
				$prodCostStatus = (isset($app_sec['partVII'][1]) && $app_sec['partVII'][1] == 'Rejected') ? $reason['status']['production_cost'] : (($prodCostRecord == 1) ? "success" : "error");
				$secStatus['production_cost'] = $prodCostStatus;
			}
	
			$this->Session->write('secStatus',$secStatus);
	
		}

		//set enduser return section fill status for sidebar menu purpose
		//@addedon 14th JUL 2021 (by Aniket Ganvir)
		public function enduserSectionFillStatus($formType, $returnType, $returnDate, $endUserId){
			
			// $returnType = $this->Session->read('returnType');
			// $returnDate = $this->Session->read('returnDate');
			$formStatus = (null !== $this->Session->read('form_status')) ? $this->Session->read('form_status') : null;

			if(null !== $this->Session->read('return_id')){
				$return_id = $this->Session->read('return_id');
			} else {
				$return_id = $this->TblEndUserFinalSubmit->getLatestReturnId($endUserId, $returnDate, $returnType);
			}

			$return_id = ($return_id == null) ? 0 : $return_id;
	
			$app_sec = (null !== $this->Session->read('approved_sections')) ? $this->Session->read('approved_sections') : array();
	
			//PART I: Instruction
			$secStatus['instruction'] = (isset($app_sec['partI'][1]) && $app_sec['partI'][1] == 'Rejected') ? 'pending' : 'success';
	
			//PART I: General Particular 
			$secStatus['gen_particular'] = (isset($app_sec['partI'][2]) && $app_sec['partI'][2] == 'Rejected') ? 'pending' : 'success';
	
			//PART II: Trading Activity
			$reason['trading_ac'] = $this->TblEndUserFinalSubmit->getReason($return_id, 'partII', 1, 'applicant');
			$reason['status']['trading_ac'] = (isset($reason['trading_ac']['commented']) && $reason['trading_ac']['commented'] == '1') ? 'success' : 'pending';
			$reason['status']['trading_ac'] = ($formStatus == 'read') ? 'success' : $reason['status']['trading_ac'];
			$tradingData = $this->NSeriesProdActivity->checkFillStatus($formType, $returnType, $returnDate, $endUserId, 'T');
			$tradingStatus = (isset($app_sec['partII'][1]) && $app_sec['partII'][1] == 'Rejected') ? $reason['status']['trading_ac'] : (($tradingData > 0) ? "success" : "error");
			$secStatus['trading_ac'] = $tradingStatus;
			
			//PART II: Export Activity
			$reason['export_ac'] = $this->TblEndUserFinalSubmit->getReason($return_id, 'partII', 2, 'applicant');
			$reason['status']['export_ac'] = (isset($reason['export_ac']['commented']) && $reason['export_ac']['commented'] == '1') ? 'success' : 'pending';
			$reason['status']['export_ac'] = ($formStatus == 'read') ? 'success' : $reason['status']['export_ac'];
			$exportData = $this->NSeriesProdActivity->checkFillStatus($formType, $returnType, $returnDate, $endUserId, 'E');
			$exportStatus = (isset($app_sec['partII'][2]) && $app_sec['partII'][2] == 'Rejected') ? $reason['status']['export_ac'] : (($exportData > 0) ? "success" : "error");
			$secStatus['export_ac'] = $exportStatus;
			
			//PART II: End-Use Mineral Based Activity
			$reason['min_bas_ac'] = $this->TblEndUserFinalSubmit->getReason($return_id, 'partII', 3, 'applicant');
			$reason['status']['min_bas_ac'] = (isset($reason['min_bas_ac']['commented']) && $reason['min_bas_ac']['commented'] == '1') ? 'success' : 'pending';
			$reason['status']['min_bas_ac'] = ($formStatus == 'read') ? 'success' : $reason['status']['min_bas_ac'];
			$mineralData = $this->NSeriesProdActivity->checkFillStatus($formType, $returnType, $returnDate, $endUserId, 'C');
			$mineralStatus = (isset($app_sec['partII'][3]) && $app_sec['partII'][3] == 'Rejected') ? $reason['status']['min_bas_ac'] : (($mineralData > 0) ? "success" : "error");
			$secStatus['min_bas_ac'] = $mineralStatus;
			
			//PART II: Storage Activity
			$reason['storage_ac'] = $this->TblEndUserFinalSubmit->getReason($return_id, 'partII', 4, 'applicant');
			$reason['status']['storage_ac'] = (isset($reason['storage_ac']['commented']) && $reason['storage_ac']['commented'] == '1') ? 'success' : 'pending';
			$reason['status']['storage_ac'] = ($formStatus == 'read') ? 'success' : $reason['status']['storage_ac'];
			$storageData = $this->NSeriesProdActivity->checkFillStatus($formType, $returnType, $returnDate, $endUserId, 'S');
			$storageStatus = (isset($app_sec['partII'][4]) && $app_sec['partII'][4] == 'Rejected') ? $reason['status']['storage_ac'] : (($storageData > 0) ? "success" : "error");
			$secStatus['storage_ac'] = $storageStatus;

			if ($returnType == 'ANNUAL') {

				//PART III: End-Use Mineral Based Ind-I
				$reason['min_bas_ind'] = $this->TblEndUserFinalSubmit->getReason($return_id, 'partIII', 1, 'applicant');
				$reason['status']['min_bas_ind'] = (isset($reason['min_bas_ind']['commented']) && $reason['min_bas_ind']['commented'] == '1') ? 'success' : 'pending';
				$reason['status']['min_bas_ind'] = ($formStatus == 'read') ? 'success' : $reason['status']['min_bas_ind'];
				$minBasInd = $this->OMineralIndustryInfo->isFilled($formType, $returnType, $returnDate, $endUserId, 'C');
				$minBasIndStatus = (isset($app_sec['partIII'][1]) && $app_sec['partIII'][1] == 'Rejected') ? $reason['status']['min_bas_ind'] : (($minBasInd == 1) ? "success" : "error");
				$secStatus['min_bas_ind'] = $minBasIndStatus;

				//PART III: End-Use Mineral Based Ind-II
				$reason['prod_man_det'] = $this->TblEndUserFinalSubmit->getReason($return_id, 'partIII', 2, 'applicant');
				$reason['status']['prod_man_det'] = (isset($reason['prod_man_det']['commented']) && $reason['prod_man_det']['commented'] == '1') ? 'success' : 'pending';
				$reason['status']['prod_man_det'] = ($formStatus == 'read') ? 'success' : $reason['status']['prod_man_det'];
				$prodManDet = $this->OProdDetails->isFilled($formType, $returnType, $returnDate, $endUserId, 1);
				$prodManDetStatus = (isset($app_sec['partIII'][2]) && $app_sec['partIII'][2] == 'Rejected') ? $reason['status']['prod_man_det'] : (($prodManDet == 1) ? "success" : "error");
				$secStatus['prod_man_det'] = $prodManDetStatus;
				
				//PART III: Iron And Steel Industry
				$reason['iron_steel'] = $this->TblEndUserFinalSubmit->getReason($return_id, 'partIII', 3, 'applicant');
				$reason['status']['iron_steel'] = (isset($reason['iron_steel']['commented']) && $reason['iron_steel']['commented'] == '1') ? 'success' : 'pending';
				$reason['status']['iron_steel'] = ($formStatus == 'read') ? 'success' : $reason['status']['iron_steel'];
				$ironSteel = $this->OProdDetails->isFilled($formType, $returnType, $returnDate, $endUserId, 2);
				$ironSteelStatus = (isset($app_sec['partIII'][3]) && $app_sec['partIII'][3] == 'Rejected') ? $reason['status']['iron_steel'] : (($ironSteel == 1) ? "success" : "error");
				$secStatus['iron_steel'] = $ironSteelStatus;

				//PART III: Raw Materials Consumed In Production
				$reason['raw_mat_cons'] = $this->TblEndUserFinalSubmit->getReason($return_id, 'partIII', 4, 'applicant');
				$reason['status']['raw_mat_cons'] = (isset($reason['raw_mat_cons']['commented']) && $reason['raw_mat_cons']['commented'] == '1') ? 'success' : 'pending';
				$reason['status']['raw_mat_cons'] = ($formStatus == 'read') ? 'success' : $reason['status']['raw_mat_cons'];
				$rawMatCons = $this->ORawMatConsume->isFilled($formType, $returnType, $returnDate, $endUserId, "C");
				$rawMatConsStatus = (isset($app_sec['partIII'][4]) && $app_sec['partIII'][4] == 'Rejected') ? $reason['status']['raw_mat_cons'] : (($rawMatCons == 1) ? "success" : "error");
				$secStatus['raw_mat_cons'] = $rawMatConsStatus;
				
				//PART III: Source Of Supply
				$reason['sour_supp'] = $this->TblEndUserFinalSubmit->getReason($return_id, 'partIII', 5, 'applicant');
				$reason['status']['sour_supp'] = (isset($reason['sour_supp']['commented']) && $reason['sour_supp']['commented'] == '1') ? 'success' : 'pending';
				$reason['status']['sour_supp'] = ($formStatus == 'read') ? 'success' : $reason['status']['sour_supp'];
				$sourceData = $this->OSourceSupply->isFilled($formType, $returnType, $returnDate, $endUserId, "C");
				$sourceDataStatus = (isset($app_sec['partIII'][5]) && $app_sec['partIII'][5] == 'Rejected') ? $reason['status']['sour_supp'] : (($sourceData == 1) ? "success" : "error");
				$secStatus['sour_supp'] = $sourceDataStatus;

			}
			
			$this->Session->write('secStatus',$secStatus);
			
		}

		/**
		 * FINAL SUBMIT BUTTON SHOW/HIDE STATUS
		 * @addedon 07th Sept 2021 (by Aniket Ganvir)
		 */
		public function finalSubmitButton(){

			$mineCode = $this->Session->read('mc_mine_code');
			$returnDate = $this->Session->read('returnDate');
			$returnType = $this->Session->read('returnType');
	
			/***** Added by saranya raj 18th April 2016 *******************/
			// $is_hematite = $this->getUser()->getAttribute('is_hematite');
			// $is_magnetite = $this->getUser()->getAttribute('is_magnetite');
			$is_hematite = '';
			$is_magnetite = '';
			$is_hematite = $this->Session->read('is_hematite');
			$is_magnetite = $this->Session->read('is_magnetite');
	
			/**
			 * GETTING THE USER ID AND THEN EXPLODING IT WITH '/' 
			 * TO CHECK THE MINE USER AS IF 2 '/' COMES THEN THE USER IS A 3rd LEVEL
			 * USER ELSE IF 1 '/' COMES IT'S A SECONDAY USER
			 * 
			 * eg:- the o/p of above user is : 57/40MSH14010/1
			 * then exploding with '/' and since only one '/' is there it's a 
			 * SECONDARY USER
			 */
			$mcu_user_id = $this->Session->read('username');
	
			$temp = explode('/', $mcu_user_id);
			if (count($temp) > 1) {
				$app_id = $temp[0] . "/" . $temp[1];
			} else {
				$app_id = $temp[0];
			}
	
			if (count($temp) == 3){
				$submitted_by = $temp[2];
			} else {
				$submitted_by = $app_id;
			}
	
			//======================GETTING MINERAL FROM THE SESSION====================
			$mineMinerals = $this->Session->read('mineralArr');
	
			$no_error = true;
	
			//primary form no
			$primaryMineral = $mineMinerals[0];
			$primaryFormNo = $this->DirMcpMineral->getFormNumber($primaryMineral);
			
			//check rent & royalty
			$is_submitted['rent'] = $this->RentReturns->isFilled($mineCode, $returnDate, $returnType);
			//check working details
			$is_submitted['working_details'] = $this->WorkStoppage->isFilled($mineCode, $returnDate, $returnType);
			//check daily average
			$is_submitted['daily_average'] = $this->Employment->isFilled($mineCode, $returnDate, $returnType);
			//check rom
			$is_submitted['rom'] = $this->Prod1->isFilled($mineCode, $returnDate, $returnType, $mineMinerals);
			//check gradewise production
			$is_submitted['grade_wise'] = $this->GradeProd->isFilled($mineCode, $returnDate, $returnType, $is_hematite, $is_magnetite);
			//check deduction details
			$is_submitted['deduction'] = $this->Prod1->isDeductionFilled($mineCode, $returnDate, $returnType, $is_hematite, $is_magnetite);
			//check sales and despatches - Dont need to check the sales and dispatch entry
			//$is_submitted['sales'] = $this->GradeSale->isFilled($mineCode, $returnDate, $returnType);
	
			if ($is_submitted['rent'] != 0){ return false; }
			if ($is_submitted['working_details'] != 0){ return false; }
			if ($is_submitted['daily_average'] != 0){ return false; }
	
			if ($is_submitted['rom'] != 0) {
				foreach ($is_submitted['rom'] as $r) {
					return false;
				}
			}
	
			if ($is_submitted['grade_wise'] != 0) {
				foreach ($is_submitted['grade_wise'] as $g) {
					if (strtolower($g) == "mica")
						$num = '';
					else
						/* In new form, for Iron and chromite, the OpenStock, production and Closing Stock value 
							is not required to fill grade-wise production details. 
							So validate the production details if form number is not a 1 and 4.  
							Done by Pravin Bhakare, 23-07-2020 */
						if($primaryFormNo !=1 && $primaryFormNo !=4)
						return false;
				}
			}
	
			if ($is_submitted['deduction'] != 0) {
				foreach ($is_submitted['deduction'] as $g) {
					return false;
				}
			}
	
			/* if ($is_submitted['sales'] != 0) {
			  foreach ($is_submitted['sales'] as $g) {
			  $error_msg[] = "Please enter sales/dispatches details for " . ucwords($g);
			  }
			  } */
			 
			//extra forms check
			foreach ($mineMinerals as $m) {
				$formNo = $this->DirMcpMineral->getFormNumber($m);
				
				if(in_array($formNo, array(1,2,3,4,8))) {
					//check gradewise production
					$mineral_ul = strtolower(str_replace(' ','_',$m));
					if($mineral_ul == 'iron_ore') {
						if ($is_hematite == true) {
							$is_grade_wise = $this->GradeProd->isFilledGradeProd($mineCode, $returnType, $returnDate, $mineral_ul, '', 'hematite');
							if ($is_grade_wise == false)
								return false;
						}
						if ($is_magnetite == true) {
							$is_grade_wise = $this->GradeProd->isFilledGradeProd($mineCode, $returnType, $returnDate, $mineral_ul, '', 'magnetite');
							if ($is_grade_wise == false)
								return false;
						}
					} else {
						$is_grade_wise = $this->GradeProd->isFilledGradeProd($mineCode, $returnType, $returnDate, $mineral_ul, '');
						if ($is_grade_wise == false)
							return false;
					}


				}

				if ($formNo == 8) {
					$is_pulverised = $this->Pulverisation->chkPulRecord($mineCode, $returnType, $returnDate, $m);
					if ($is_pulverised == false)
						return false;
				} else if ($formNo == 5) {
					//for ex mine price
					$is_exmine_filled = $this->Prod5->isFilled($mineCode, $returnDate, $returnType, $m);
					if ($is_exmine_filled != 0)
						return false;
	
					//for conReco
					$is_conreco_filled = $this->RomMetal5->isFilled($mineCode, $returnDate, $returnType, $m);
					if ($is_conreco_filled != 0)
						return false;
	
					//for smelter
					$is_smelter_filled = $this->RecovSmelter->isFilled($mineCode, $returnDate, $returnType, $m);
					if ($is_smelter_filled != 0)
						return false;
	
					//for sales
					$is_sales_filled = $this->Sale5->isFilled($mineCode, $returnDate, $returnType, $m);
					if ($is_sales_filled != 0)
						return false;
				} 
				// else if ($formNo == 7) {
				// 	//production / stocks (rom)
				// 	$prod_stock_rom_filled = $this->RomStone->isFilled($mineCode, $returnDate, $returnType);
				// 	if ($prod_stock_rom_filled != 0)
				// 		$error_msg[] = "Please enter <b>Production / Stocks (ROM)</b> for <b>" . ucwords(str_replace('_', ' ', $m))."</b>";
			
				// 	//production, despatches and stocks
				// 	$prod_stock_dis_filled = $this->ProdStone->isFilled($mineCode, $returnDate, $returnType);
				// 	if ($prod_stock_dis_filled != 0)
				// 		$error_msg[] = "Please enter <b>Production, Despatches and Stocks</b> for <b>" . ucwords(str_replace('_', ' ', $m))."</b>";
			
				// 	//details of deductions
				// 	$deduct_detail_filled = $this->Prod1->isFilled($mineCode, $returnDate, $returnType);
				// 	if ($deduct_detail_filled != 0)
				// 		$error_msg[] = "Please enter <b>Details of Deductions</b> for <b>" . ucwords(str_replace('_', ' ', $m))."</b>";
						
				// 	//sales/dispatches
				// 	$sale_despatch_filled = $this->GradeSale->isFilled($mineCode, $returnDate, $returnType);
				// 	if ($sale_despatch_filled != 0)
				// 		$error_msg[] = "Please enter <b>Sales/Dispatches</b> for <b>" . ucwords(str_replace('_', ' ', $m))."</b>";
				// }
			}

			return $no_error;
	
		}
		
		/**
		 * FINAL SUBMIT BUTTON SHOW/HIDE STATUS
		 * @addedon 07th Sept 2021 (by Aniket Ganvir)
		 */
		public function finalSubmitButtonEndUser(){

			$endUserId = $this->Session->read('registration_code');
			$returnType = $this->Session->read('returnType');
			$formType = $this->Session->read('formType');
			$returnDate = $this->Session->read('returnDate');
			
			/**
			 * VALIDATING SECTION AS PER USER'S ACTIVITY TYPE (PHASE-II)
			 * @version 07th Sept 2021
			 * @author Aniket Ganvir
			 */
			$userType = $this->Session->read('activityType');
			$userType = ($userType == 'W') ? 'T' : $userType; //set $userType T for "Trader without storage"
			$sectionActivity = $this->NSeriesProdActivity->checkForValue($formType, $returnType, $returnDate, $endUserId, $userType);
			
			$no_error = true;
			
			if ($sectionActivity == 0) { return false; }

			if ($returnType == 'ANNUAL') {
				if ($userType == 'C') {
					
					// optionalItemCheck
					//============END-USE MINERAL BASED INDUXTRIES-II===========
					//                $mineral_name = 'SILVER';
					$formFlag = 1;
					$exsistanceCheck2 = $this->OProdDetails->checkRecordForFinalSubmit($formType, $returnType, $returnDate, $endUserId, $formFlag);

					//====================IRON AND STEEL INDUSTRY===============
					$formFlagTwo = 2;
					$exsistanceCheck5 = $this->OProdDetails->checkRecordForFinalSubmit($formType, $returnType, $returnDate, $endUserId, $formFlagTwo);

					$item3Check = $exsistanceCheck2;
					$item4Check = $exsistanceCheck5;
					if ($item3Check == 0 && $item4Check == 0) {
						// "Either 'End-Use mineral based activity-II' or 'Iron and Steel industry' or both must be filled. Currently both of them are empty. Without filling either one of them or both you can't proceed"
						return false;
					}

					// checkRawVsSource
					$exsistanceCheck3 = $this->ORawMatConsume->getRecordIdNew($formType, $returnType, $returnDate, $endUserId, $userType);
					$exsistanceCheck4 = $this->OSourceSupply->getRecordId($formType, $returnType, $returnDate, $endUserId, $userType);
					/**
					 * CHANGED THE ARRAY PARAMETER FROM count to status 
					 */
					$checkRawMaterial = $exsistanceCheck3['status'];
					$checkSourceOfSuply = $exsistanceCheck4['status'];
		
					if ($checkRawMaterial != $checkSourceOfSuply) {
						// "Either one of form 'Raw Metarial Consumed in Production' OR 'Source of Supply' not filled. Kindly fill both of them or none of them then proceed."
						return false;
					}

					// form validation
					//============================END-USE MINERAL BASED INDUXTRIES-I============
					$exsistanceCheck1 = $this->OMineralIndustryInfo->getRecordIdNew('O', $returnType, $returnDate, $endUserId, $userType);
					if ($exsistanceCheck1 == 0) {
						// "Please enter end-user mineral based industries-I details"
						return false;
					}

					//============================END-USE MINERAL BASED INDUXTRIES-II===========
					// $mineral_name = 'SILVER';
					$formFlag = 1;
					$exsistanceCheck2 = $this->OProdDetails->checkRecordForFinalSubmit($formType, $returnType, $returnDate, $endUserId, $formFlag);

					//============================ RAW MATERIALS CONSUMED IN PRODUCTION=========
					$exsistanceCheck3 = $this->ORawMatConsume->getRecordIdNew($formType, $returnType, $returnDate, $endUserId, $userType);
					if ($exsistanceCheck3 == 0) {
						// "Please enter raw materials consumed in production details"
						return false;
					}

					//=================================== SOURCE OF SUPPLY======================
					$exsistanceCheck4 = $this->OSourceSupply->getRecordId($formType, $returnType, $returnDate, $endUserId, $userType);
					if ($exsistanceCheck4 == 0) {
						// "Please enter source of supply details"
						return false;
					}

					//============================IRON AND STEEL INDUSTRIES===========
					// $mineral_name = 'IRON ORE';
					$formFlagTwo = 2;
					$exsistanceCheck5 = $this->OProdDetails->checkRecordForFinalSubmit($formType, $returnType, $returnDate, $endUserId, $formFlagTwo);
					
					if ($exsistanceCheck2 == 0 && $exsistanceCheck5 == 0) {
						// "Either 'End-Use mineral based activity-II' or 'Iron and Steel industry' or both must be filled. Currently both of them are empty. Without filling either one of them or both you can't proceed."
						return false;
					}

				}
			}

			return $no_error;

		}

		/**
		 * Annual final submit button show/hide status
		 * @version 01st Nov 2021
		 * @author Aniket Ganvir
		 */
		public function finalSubmitAnnualButton(){
	
			$mineCode = $this->Session->read('mc_mine_code');
			$returnDate = $this->Session->read('returnDate');
			$returnType = $this->Session->read('returnType');
	
			/***** Added by saranya raj 18th April 2016 *******************/
			// $is_hematite = $this->getUser()->getAttribute('is_hematite');
			// $is_magnetite = $this->getUser()->getAttribute('is_magnetite');
			$is_hematite = '';
			$is_magnetite = '';
	
			/**
			 * GETTING THE USER ID AND THEN EXPLODING IT WITH '/' 
			 * TO CHECK THE MINE USER AS IF 2 '/' COMES THEN THE USER IS A 3rd LEVEL
			 * USER ELSE IF 1 '/' COMES IT'S A SECONDAY USER
			 * 
			 * eg:- the o/p of above user is : 57/40MSH14010/1
			 * then exploding with '/' and since only one '/' is there it's a 
			 * SECONDARY USER
			 */
			$mcu_user_id = $this->Session->read('username');
	
			$temp = explode('/', $mcu_user_id);
			$app_id = $temp[0] . "/" . $temp[1];
	
			if (count($temp) == 3) {
				$submitted_by = $temp[2];
			} else {
				$submitted_by = $app_id;
			}
	
			//======================GETTING MINERAL FROM THE SESSION====================
			$mineMinerals = $this->Session->read('mineralArr');
			
			//primary form no
			$primaryMineral = $mineMinerals[0];
			$primaryFormNo = $this->DirMcpMineral->getFormNumber($primaryMineral);
			
			//=======================CHECKING NAME AND ADDRESS PAGE=====================
			$nameAndAddress = $this->Mine->nameAndAddressCheck($mineCode);
			
			//=====================CHECKING PARTICULARS OF AREA OPERATED================
			/*
			 * Added one more parameter returnDate for validation with Lease_Year. Earlier it was being compared with 'CurrentYear' resulting in issue.
			 * Author : Naveen Jha naveenj@ubicsindia.com
			 * Date : 17th Jan 2015
			 */
			$particular = $this->McpLease->particularAnnualCheck($mineCode,$returnDate);
	
			//==========================CHECKING AREA UTILIZATION=======================
			$areaUtilisation = $this->LeaseReturn->lesseeCheck($mineCode, $returnDate);
			
			//====================CHECKING EMPLOYMENT & WAGES PART 1====================
			/**
			 * form type for employment fields = 1 in RENT_RETURNS TABLE 
			 */
			$wagesFormType = 1;
			$wagesFromReturn = $this->RentReturns->getReturnsId($mineCode, $returnType, $returnDate, $wagesFormType);
			if ($wagesFromReturn != "") {
				$wageErrorCount = 0;
			} else {
				$wageErrorCount = 1;
			}
	
			$wagesFromWorkStoppage = $this->WorkStoppage->isFilled($mineCode, $returnDate, $returnType);
			
			//=====================CHECKING EMPLOYMENT & WAGES PART 2===================
			$employment = $this->Employment->employmentAnnualCheck($mineCode, $returnDate, $returnType);
	
			//========================CHECKING CAPITAL STRUCTURE========================
			$capitalStruc = $this->CapitalStructure->getRecordId($mineCode, $returnDate);
			if ($capitalStruc == 1) {
				$capitalError = 0;
			} else {
				$capitalError = 1;
			}
	
				
			//======================QUANTITY AND COST OF MATERIAL=======================
			$quantity = $this->MaterialConsumption->materialQuantityAnnualCheck($mineCode, $returnDate, $returnType);
	
			//==========================ROYALITY/COMPENSATION===========================
			/**
			 * form type for royality fields = 2 in RENT_RETURNS TABLE 
			 */
			$royalityFormType = 2;
			$royality = $this->RentReturns->getReturnsId($mineCode, $returnType, $returnDate, $royalityFormType);
			if ($royality == "") {
				$royalityError = 1;
			} else {
				$royalityError = 0;
			}
	
				
			//==========================MATERIAL CONSUMPTION TAX========================
			/**
			 * form type for consumption tax fields = 3 in RENT_RETURNS TABLE 
			 */
			$taxFormType = 3;
			$tax = $this->RentReturns->getReturnsId($mineCode, $returnType, $returnDate, $taxFormType);
			if ($tax == "") {
				$taxError = 1;
			} else {
				$taxError = 0;
			}
				
			//===========================EXPLOSIVE CONSUMPTION==========================
			/**
			 * COMMENTED THE FUNCTION AS THE VALIDATION HAS BEEN CHANGED 
			 * NOW WE ONLY HAVE TO CHECK "QUANTITY CONSUMED DURING THE YEAR"
			 * AS PER THE GUIDANCE GIVEN BY IBM, SO NO NEED TO CHECK THIS FUNCTION
			 * ANY MORE
			 * 
			 * @author Uday Shankar Singh<using@ubicsindia.com, udayshankar1306@gmail.com>
			 * @version 26th Feb 2014 
			 */
			// $explosiveReturn = EXPLOSIVE_CONSUMPTIONTable::getExplosiveReturnsId($this->mineCode, $this->returnDate, $this->returnType);
			// $checkQuantityForExplosiveValue = 0 -> VALUE GREATER THAN 0 IS ENTERED IN QUANTITY FORM
			// ELSE 1 THEN VALUE ENTERED IS 0
			/**
			 * THE BELOW FUNCTION CALL IS ADDED TO CHECK THE QUANTITY FORM ALSO NOW
			 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
			 * @version 25th March 2014 
			 */
			$checkQuantityForExplosiveValue = $this->MaterialConsumption->explosiveCheckForPart4($mineCode, 'ANNUAL', $returnDate);
			// $explosiveConsumption = 1 THAN VALUE ENTERED IN EXPLOSIVE IS GREATER THAN 0
			// ELSE 0 THEN 0 IS ENTERED IN ALL THE FIELD OF EXPLOSIVE CONSUMPTION
			
			/**
			 * The below function is now being called with one more parameter 'calledfrom = finalSubmit'
			 * This was done to handle a special case where 'explosive value' in part III is zero but future consumption in Part IV is not zero.
			 * On Final submit error was being flashed. 
			 * @author Uday Shankar Singh<usingh@ubicsindia.com>
			 * @version 26th June 2015
			 */
			// $explosiveConsumption = EXPLOSIVE_CONSUMPTIONTable::getExplosiveConsumptionId($this->mineCode, $this->returnDate);
			$explosiveConsumption = $this->ExplosiveConsumption->getExplosiveConsumptionId($mineCode, $returnDate, 'finalSubmit');
	
		  
			if (($checkQuantityForExplosiveValue == 0 && $explosiveConsumption == 1) || ($checkQuantityForExplosiveValue == 1 && $explosiveConsumption == 0)) { //BOTH HAVE VALUE GREATER THAN 0 or 0
				$expConError = 0;
			} else {
				$expConError = 1;
			}
			/**
			 * BELOW 4 LINES ARE COMMENTED AS I MADE A LITTLE CHANGE IN THE VALIDATION
			 * AS NOW I AM CHECKING THE QUANTITY FORM ALSO FOR VALUE TO DOUBLE ENSURE THAT
			 * VALUE IS EITHER FILLED IN BOTH THE FORMS OR ENTERED 0 IN BOTH THE FORMS
			 * 
			 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
			 * @version 25th March 2014 
			 */
			// if ($explosiveConsumption == 1)
			// 	$expConError = 0;
			// else
			// 	$expConError = 1;
			//===========================GEOLOGY PART 1 FORM NEED TO BE COMPLETE====================================
			
			// $i = 1;
			// foreach ($mineMinerals as $name) {
			//     $mineralName = $name;
			//     $geoPart1[$i] = $this->TblMinWorked->checkDBForAnnualFinalSubmit($mineCode, $returnDate, $mineralName);
			//     if ($geoPart1[$i] == 1)
			//         $part1Error[$i] = 0;
			//     else
			//         $part1Error[$i] = 1;
			//     $i++;
			// }
			// foreach ($part1Error as $errorCheck) {
			//     //==================ERROR FOUND======================
			//     if ($errorCheck == 1) {
			//         $geoPart1Error = 1;
			//     }
			//     //=================NO ERROR FOUND====================
			//     else {
			//         $geoPart1Error = 0;
			//     }
			// }
			
			// PART V: Sec 1
			$geoExpRecord = $this->ExplorationDetails->isFilled($mineCode, $returnType, $returnDate);
	
			// PART V:
			$geoResSubgradeRecordError = 0;
			$geoPartSixRecordError = 0;
			foreach ($mineMinerals as $name) {
				$mineralName = $name;
				$mineral_name = strtolower($mineralName);
	
				// PART V: Sec 2/3
				$geoResSubgradeRecord = $this->ReservesResources->isFilled($mineCode, $returnType, $returnDate, $mineral_name);
				if ($geoResSubgradeRecord == 0) {
					$geoResSubgradeRecordError++;
				}
	
				// PART V: Sec 7
				$geoPartSixRecord = $this->Machinery->isFilledPartSix($mineCode, $returnType, $returnDate, $mineral_name, 2, 2);
				if ($geoPartSixRecord == 0) {
					$geoPartSixRecordError++;
				}
			   
			}
	
			// PART V: Sec 4/5
			$geoOverburdTreeRecord = $this->TreesPlantSurvival->isFilled($mineCode, $returnType, $returnDate);
	
			// PART V: Sec 6
			$formType12 = $this->Session->read('mc_form_type');
			$geoPartThreeRecord = $this->Machinery->isFilled($mineCode, $returnType, $returnDate, $formType12, 1);
			
			//=============================GEOLOGY PART 2===============================
			/**
			 * form type for geology part 2 = 4 in RENT_RETURNS table 
			 */
			// $geoFormType = 4;
			// $mineralName = '0';
			// $geoPart2 = $this->RentReturns->checkGeologyPart2Id($mineCode, $returnType, $returnDate, $geoFormType, $mineralName);
			// if ($geoPart2['db_check'] == 1)
			//     $geoPart2Error = 0;
			// else
			//     $geoPart2Error = 1;
	
			//=============================GEOLOGY PART 3===============================
			$i = 1;
			foreach ($mineMinerals as $name) {
				$mineralName = $name;
				$geoPartRejects1[$i] = $this->RentReturns->checkMineralDB($mineCode, $returnType, $returnDate, $mineralName);
				//RESERVESTable::checkDBForAnnual($this->mineCode, $this->returnType, $this->returnDate, $mineralName);
				if ($geoPartRejects1[$i] == 1)
					$partRejectsError[$i] = 0;
				else
					$partRejectsError[$i] = 1;
				$i++;
			}
			foreach ($partRejectsError as $errorRejectsCheck) {
				//==================ERROR FOUND======================
				if ($errorRejectsCheck == 1) {
					$mineralRejects = 1;
				}
				//=================NO ERROR FOUND====================
				else {
					$mineralRejects = 0;
				}
			}
	
			
			/*
			  $mineralRejects = RETURNSTable::checkMineralDB($this->mineCode, $this->returnType, $this->returnDate);
			  if ($mineralRejects == 1)
			  $mineralRejects = 0;
			  else
			  $mineralRejects = 1; */
			//=============================GEOLOGY PART 4===============================
			$i = 1;
			foreach ($mineMinerals as $name) {
				$mineralName = $name;
				$geoPart4[$i] = $this->Reserves->checkDBForAnnual($mineCode, $returnType, $returnDate, $mineralName);
				if ($geoPart4[$i] == 1)
					$part4Error[$i] = 0;
				else
					$part4Error[$i] = 1;
				$i++;
			}
			foreach ($part4Error as $errorCheck) {
				//==================ERROR FOUND======================
				if ($errorCheck == 1) {
					$geoPart4Error = 1;
				}
				//=================NO ERROR FOUND====================
				else {
					$geoPart4Error = 0;
				}
			}
			
			//================================SALE AND DISPATCH=========================
			/*
			  $i = 1;
			  foreach ($this->mineMinerals as $name) {
			  $mineralName = $name;
			  $mineralSaleGrade[$i] = GRADE_SALETable::checkdSaleMineralDB($this->mineCode, $this->returnType, $this->returnDate,$mineralName);
			  if ($mineralSaleGrade[$i] == 1)
			  $partSaleError[$i] = 0;
			  else
			  $partSaleError[$i] = 1;
			  $i++;
			  }
			  foreach ($partSaleError as $errorSaleCheck) {
			  //==================ERROR FOUND======================
			  if ($errorSaleCheck == 1) {
			  $geoPartSaleError = 1;
			  }
			  //=================NO ERROR FOUND====================
			  else {
			  $geoPartSaleError = 0;
			  }
			  } */
			//===========================COST OF PRODUCTION=============================
			// $cost = $this->CostProduction->getCostId($mineCode, $returnType, $returnDate);
			$prodCost = $this->CostProduction->isFilled($mineCode, $returnType, $returnDate);
			// if ($cost != "")
			// 	$costError = 0;
			// else
			// 	$costError = 1;
	
			//====================CHECKING GRADE WISE PRODUCTION AND ROM FOR PRODUCTION VALUE CHECK==========
			$romTotalForAllMineral = 0;
			foreach ($mineMinerals as $name) {
				$formNo = $this->DirMcpMineral->getFormNumber($name);
				if ($formNo == 6) {
					$gradeTotalCheck = $this->ProdMica->getProductionTotalfn($mineCode, $returnType, $returnDate, $name, $formNo);
					$romData = $this->ProdMica->getRomProductionTotalfn($mineCode, $returnType, $returnDate, $name);
					$tmp = $romData / 1000;
					$romTotalForAllMineral = $romTotalForAllMineral + $tmp;
				} else if ($formNo == 5) {
					$gradeTotalCheck = $this->Rom5->getTotalProduction($mineCode, $returnDate, $returnType, $name);
					$romData = $gradeTotalCheck;
					$romTotalForAllMineral = $romTotalForAllMineral + $romData;
				} else if ($formNo == 7) {
					$gradeTotalCheck = $this->RomStone->getRomProductionTotal($mineCode, $returnType, $returnDate, $name);
					/**
					 * CHANGED THE FUNCTION CALL FROM
					 * 
					 * PROD_STONETable::getProductionTotal TO  
					 * ROM_STONETable::getProductionTotal AS 
					 * PER THE CHANGES FOUND IN THE RELEASE VERSION 
					 * 
					 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
					 * @version 21st Jan 2014
					 * 
					 */
					$romData = $this->RomStone->getProductionTotal($mineCode, $returnType, $returnDate, $name);
					$romTotalForAllMineral = $romTotalForAllMineral + $romData;
				} else {
					$gradeTotalCheck = $this->GradeProd->getProductionTotal($mineCode, $returnType, $returnDate, $name);
					$romData = $this->Prod1->getRomProductionTotal($mineCode, $returnType, $returnDate, $name);
					$romTotalForAllMineral = $romTotalForAllMineral + $romData;
				}
			}
			
			$expConProdTot = $this->ExplosiveReturn->getProductionDuringTheYear($mineCode, $returnDate, $returnType);
			// print_r($romTotalForAllMineral);
			// print_r("-------");
			// print_r($expConProdTot);
			// die;
	
			// COMMENTED THESE LINES FOR NOW LATER WILL BE UNCOMMENTED
			// Uday Shankar Singh @30th May 2014
			// if (trim($romTotalForAllMineral) != trim($expConProdTot)) {
			// //        if($gradeTotalCheck != $romData){
			// //        return $this->renderText("bothVary");
			// //      }
			// return $this->renderText("singleVary");
			// }
			// print_r("--->");
			// print_r($romTotalForAllMineral);
			// die;
			//====================CHECKING FOR ERROR IN ALL ABOVE PAGES=================
			$annualError = Array();
			if ($nameAndAddress != 0) {
				return false;
			}
			if ($particular != 0) {
				return false;
			}
			if ($areaUtilisation != 0) {
				return false;
			}
			if ($wageErrorCount != 0 || $wagesFromWorkStoppage != 0) {
				return false;
			}
			if ($employment != 0) {
				return false;
			}
			if ($capitalError != 0) {
				return false;
			}
			if ($quantity != 0) {
				return false;
			}
			if ($royalityError != 0) {
				return false;
			}
			if ($taxError != 0) {
				return false;
			}
			
			/**
			 * COMMENTED THE BELOW LINE AND REMOVE THE  $explosiveReturn != 0 CONDITION
			 * AS THE VALIDATION HAS BEEN CHANGED 
			 * NOW WE ONLY HAVE TO CHECK "QUANTITY CONSUMED DURING THE YEAR"
			 * AS PER THE GUIDANCE GIVEN BY IBM, SO NO NEED TO CHECK THIS 
			 * ANY MORE
			 * 
			 * @author Uday Shankar Singh<using@ubicsindia.com, udayshankar1306@gmail.com>
			 * @version 26th Feb 2014 
			 */
			// if ($explosiveReturn != 0 && $expConError != 0) {
			if ($expConError != 0) {
				return false;
			}
			// if ($geoPart1Error == 0) {
				// $annualError[] = "Please enter Sec 1/2 details for all minerals in Part V";
			// }
	
			// if ($geoPart2Error != 0) {
			// 	$annualError[] = "Please enter Sec 4 details in Part V";
			// }
	
			// if ($mineralRejects != 0) {
			// 	$annualError[] = "Please enter Sec 4 - Mineral Rejects for all mineral in Part V";
			// }
	
			// if ($geoPart3Error != 0) {
			// 	$annualError[] = "Please enter Sec 5/6/8/9 details in Part V";
			// }
			// if ($geoPart4Error != 0) {
			// 	$annualError[] = "Please enter Sec 3 details for all minerals in Part V";
			// }
	
			
			if ($geoExpRecord == 0) {
				return false;
			}
	
			if ($geoResSubgradeRecordError != 0) {
				return false;
			}
	
			if ($geoOverburdTreeRecord == 0) {
				return false;
			}
	
			if ($geoPartThreeRecord == 0) {
				return false;
			}
	
			if ($geoPartSixRecordError != 0) {
				return false;
			}
	
			if ($prodCost == 0) {
				return false;
			}
			
			/* if ($geoPartSaleError != 0) {
			  $annualError[] = "Please enter sales/dispatches for all mineral";
			  } */
			//==============================COMMON PART=================================
			//check rom
			$is_submitted = Array();
			$is_submitted['rom'] = $this->Prod1->isFilled($mineCode, $returnDate, $returnType, $mineMinerals);
			
			//check gradewise production
			/**
			 * 
			 * @author Uday Shankar Singh
			 * @version 10th June 2014
			 * 
			 * ADDED THE BELOW CALL TO FUNCTION removeTableExtraRowsForIronOre() TO REMOVE THE RECORDS THAT ARE EXTRA IN GRADE_PROD TABLE
			 * THE EXTRA RECORDS COMES WHEN THE USER FIRST CHECKED HEMATITE AND THEN WENT TO GRADE WISE PRODUCTION FORM
			 * AT THAT TIME SOME ROWS ARE DEFAULT GETS INSERTED INTO THE GRADE_PROD TABLE.
			 * AND THEN IF USER GOES BACK AND DE-SELECT THE HEMATITE AND SELECTED THE MEGNATITE AT THAT TIME THE HEMATITTE REDCORDS ARE
			 * WASTE OR EXTRA IN THE GRADE_PROD TABBLE, SO THE BELOW LOGIC WILL REMOVE THOSE EXTRA ROWS OF HEMATITE
			 * 
			 * THIS IS THE ONLY WAY IS AM ABLE TO THINK RIGHT NOW, AS THE TIME IS A CONSTRAINT THESE DAYS
			 * LATER CAN BE IMPLEMENTED IN BETTER WAY IS POSSIBLE
			 * 
			 */
			$this->GradeProd->removeTableExtraRowsForIronOre($mineCode, $returnDate, $returnType);
			$is_submitted['grade_wise'] = $this->GradeProd->isFilled($mineCode, $returnDate, $returnType, $is_hematite, $is_magnetite);
			//check deduction details
			$is_submitted['deduction'] = $this->Prod1->isDeductionFilled($mineCode, $returnDate, $returnType, $is_hematite, $is_magnetite);
			//check sales and despatches - Dont need to check the sales and dispatch entry  
	
			$error_msg = Array();
			if ($is_submitted['rom'] != 0) {
				foreach ($is_submitted['rom'] as $r) {
					return false;
				}
			}
			if ($is_submitted['grade_wise'] != 0) {
				foreach ($is_submitted['grade_wise'] as $g) {
					if (strtolower($g) == "mica")
						return false;
					else
						return false;
				}
			}
			if ($is_submitted['deduction'] != 0) {
				foreach ($is_submitted['deduction'] as $g) {
					return false;
				}
			}
	
			//extra forms check
			foreach ($mineMinerals as $m) {
				$formNo = $this->DirMcpMineral->getFormNumber($m);
				if ($formNo == 8) {
					$is_pulverised = $this->Pulverisation->chkPulRecord($mineCode, $returnType, $returnDate, $m);
					if ($is_pulverised == false)
						return false;
				} else if ($formNo == 5) {
					//for ex mine price
					$is_exmine_filled = $this->Prod5->isFilled($mineCode, $returnDate, $returnType, $m);
					if ($is_exmine_filled != 0)
						return false;
	
					//for conReco
					$is_conreco_filled = $this->RomMetal5->isFilled($mineCode, $returnDate, $returnType, $m);
	
					if ($is_conreco_filled != 0)
						return false;
	
					//for smelter
					$is_smelter_filled = $this->RecovSmelter->isFilled($mineCode, $returnDate, $returnType, $m);
					if ($is_smelter_filled != 0)
						return false;
	
					//for sales
					$is_sales_filled = $this->Sale5->isFilled($mineCode, $returnDate, $returnType, $m);
					if ($is_sales_filled != 0)
						return false;
				}
			}
	
			if (count($annualError) == 0 && count($error_msg) == 0) {
				return true;
			} else {
				return false;
			}

		}

		/**
		 * SET SECTION COLOR CODES AS PER SECTION STATUS
		 * FOR MMS PANEL
		 * @version 10th Jan 2022
		 * @author Aniket Ganvir
		 */
		public function setMinerSectionColorCode($returnId){


			$returnData = $this->TblFinalSubmit->findReturnById($returnId);
			$tmpSec = $returnData['approved_sections'];
			$app_sec = unserialize($tmpSec);
			
	
			$returnType = $this->Session->read('returnType');
			
			if ($returnType == 'MONTHLY') {

				//PART I: Details of the Mine
				$sec['mine'] = (isset($app_sec['partI'][1])) ? $app_sec['partI'][1] : '';
				$secStatus['mine'] = ($sec['mine'] == 'Rejected') ? 'pending' : (($sec['mine'] == 'Approved') ? 'success' : 'error');
		
				//PART I: Name and Address
				$sec['name_address'] = (isset($app_sec['partI'][2])) ? $app_sec['partI'][2] : '';
				$secStatus['name_address'] = ($sec['name_address'] == 'Rejected') ? 'pending' : (($sec['name_address'] == 'Approved') ? 'success' : 'error');
		
				//PART I: Details of Rent/Royalty
				$sec['rent'] = (isset($app_sec['partI'][3])) ? $app_sec['partI'][3] : '';
				$secStatus['rent'] = ($sec['rent'] == 'Rejected') ? 'pending' : (($sec['rent'] == 'Approved') ? 'success' : 'error');
		
				//PART I: Details on Working
				$sec['working_detail'] = (isset($app_sec['partI'][4])) ? $app_sec['partI'][4] : '';
				$secStatus['working_detail'] = ($sec['working_detail'] == 'Rejected') ? 'pending' : (($sec['working_detail'] == 'Approved') ? 'success' : 'error');
		
				//PART I: Average Daily Employment
				$sec['daily_average'] = (isset($app_sec['partI'][5])) ? $app_sec['partI'][5] : '';
				$secStatus['daily_average'] = ($sec['daily_average'] == 'Rejected') ? 'pending' : (($sec['daily_average'] == 'Approved') ? 'success' : 'error');
		
				//PART II:
				$mcFormMain = $this->Session->read('mc_form_main');
				$mineralArr = $this->Session->read('mineralArr');
				$is_hematite = $this->Session->read('is_hematite');
				$is_magnetite = $this->Session->read('is_magnetite');
				foreach($mineralArr as $mineral){
		
					$mineral_name = strtolower($mineral);
					$mineral_sp = str_replace('_',' ',$mineral_name);
					$mineral_ul = str_replace(' ','_',$mineral_name); // mineral underscore lowercase
					
					$formNo = $this->DirMcpMineral->getFormNumber($mineral);
					$reason_no = array();
					if ($formNo == 6){
						$reason_no['deduct_detail'] = 2;
						$reason_no['sale_despatch'] = 3;
					}
					else if ($formNo == 5){
						$reason_no['deduct_detail'] = 6;
						$reason_no['sale_despatch'] = 7;
					}
					else {
						$reason_no['deduct_detail'] = 3;
						$reason_no['sale_despatch'] = 4;
					}
		
					if($mcFormMain == 1){
		
						//PART II: TYPE OF ORE
						$oreTypeStatus = ($is_hematite == true || $is_magnetite == true) ? "success" : "error";
						$secStatus['ore_type'][$mineral_name] = $oreTypeStatus;
		
						//PART II: Production / Stocks (ROM) (Form F1)
						// if($mineral_name == 'iron ore'){
						// 	if($is_hematite == true){
								$sec['rom_stocks'][$mineral_name.'/hematite'] = (isset($app_sec[$mineral_ul]['hematite'][1])) ? $app_sec[$mineral_ul]['hematite'][1] : '';
								$secStatus['rom_stocks'][$mineral_name.'/hematite'] = ($sec['rom_stocks'][$mineral_name.'/hematite'] == 'Rejected') ? 'pending' : (($sec['rom_stocks'][$mineral_name.'/hematite'] == 'Approved') ? 'success' : 'error');
							// }
							// if($is_magnetite == true){
								$sec['rom_stocks'][$mineral_name.'/magnetite'] = (isset($app_sec[$mineral_ul]['magnetite'][1])) ? $app_sec[$mineral_ul]['magnetite'][1] : '';
								$secStatus['rom_stocks'][$mineral_name.'/magnetite'] = ($sec['rom_stocks'][$mineral_name.'/magnetite'] == 'Rejected') ? 'pending' : (($sec['rom_stocks'][$mineral_name.'/magnetite'] == 'Approved') ? 'success' : 'error');
							// }
							// if($is_hematite != true && $is_magnetite != true){
								$sec['rom_stocks'][$mineral_name] = (isset($app_sec[$mineral_ul][1])) ? $app_sec[$mineral_ul][1] : '';
								$secStatus['rom_stocks'][$mineral_name] = ($sec['rom_stocks'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['rom_stocks'][$mineral_name] == 'Approved') ? 'success' : 'error');
							// }
						// }
						
						//PART II: Production / Stocks (ROM) (Form F7)
						$sec['rom_stocks_three'][$mineral_name] = (isset($app_sec[$mineral_ul][1])) ? $app_sec[$mineral_ul][1] : '';
						$secStatus['rom_stocks_three'][$mineral_name] = ($sec['rom_stocks_three'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['rom_stocks_three'][$mineral_name] == 'Approved') ? 'success' : 'error');
		
						//PART II: Grade-Wise Production
						
						// if($mineral_name == 'iron ore'){
						// 	if($is_hematite == true){
								$sec['gradewise_prod'][$mineral_name.'/hematite'] = (isset($app_sec[$mineral_ul]['hematite'][2])) ? $app_sec[$mineral_ul]['hematite'][2] : '';
								$secStatus['gradewise_prod'][$mineral_name.'/hematite'] = ($sec['gradewise_prod'][$mineral_name.'/hematite'] == 'Rejected') ? 'pending' : (($sec['gradewise_prod'][$mineral_name.'/hematite'] == 'Approved') ? 'success' : 'error');
							// }
							// if($is_magnetite == true){
								$sec['gradewise_prod'][$mineral_name.'/magnetite'] = (isset($app_sec[$mineral_ul]['magnetite'][2])) ? $app_sec[$mineral_ul]['magnetite'][2] : '';
								$secStatus['gradewise_prod'][$mineral_name.'/magnetite'] = ($sec['gradewise_prod'][$mineral_name.'/magnetite'] == 'Rejected') ? 'pending' : (($sec['gradewise_prod'][$mineral_name.'/magnetite'] == 'Approved') ? 'success' : 'error');
							// }
							// if($is_hematite != true && $is_magnetite != true){
								$sec['gradewise_prod'][$mineral_name] = (isset($app_sec[$mineral_ul][2])) ? $app_sec[$mineral_ul][2] : '';
								$secStatus['gradewise_prod'][$mineral_name] = ($sec['gradewise_prod'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['gradewise_prod'][$mineral_name] == 'Approved') ? 'success' : 'error');
						// 	}
						// }

						//PART II: Production, Despatches and Stocks (Form F7)
						$sec['prod_stock_dis'][$mineral_name] = (isset($app_sec[$mineral_ul][2])) ? $app_sec[$mineral_ul][2] : '';
						$secStatus['prod_stock_dis'][$mineral_name] = ($sec['prod_stock_dis'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['prod_stock_dis'][$mineral_name] == 'Approved') ? 'success' : 'error');
		
						//PART II: Pulverisation
						$sec['pulverisation'][$mineral_name] = (isset($app_sec[$mineral_ul][5])) ? $app_sec[$mineral_ul][5] : '';
						$secStatus['pulverisation'][$mineral_name] = ($sec['pulverisation'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['pulverisation'][$mineral_name] == 'Approved') ? 'success' : 'error');
		
						//PART II: Details of Deductions
						
						// if($mineral_name == 'iron ore'){
							//hematite
							$sec['deduct_detail'][$mineral_name.'/hematite'] = (isset($app_sec[$mineral_ul]['hematite'][3])) ? $app_sec[$mineral_ul]['hematite'][3] : '';
							$secStatus['deduct_detail'][$mineral_name.'/hematite'] = ($sec['deduct_detail'][$mineral_name.'/hematite'] == 'Rejected') ? 'pending' : (($sec['deduct_detail'][$mineral_name.'/hematite'] == 'Approved') ? 'success' : 'error');
							
							//magnetite
							$sec['deduct_detail'][$mineral_name.'/magnetite'] = (isset($app_sec[$mineral_ul]['magnetite'][3])) ? $app_sec[$mineral_ul]['magnetite'][3] : '';
							$secStatus['deduct_detail'][$mineral_name.'/magnetite'] = ($sec['deduct_detail'][$mineral_name.'/magnetite'] == 'Rejected') ? 'pending' : (($sec['deduct_detail'][$mineral_name.'/magnetite'] == 'Approved') ? 'success' : 'error');

							//other
							$sec['deduct_detail'][$mineral_name] = (isset($app_sec[$mineral_ul][3])) ? $app_sec[$mineral_ul][3] : '';
							$secStatus['deduct_detail'][$mineral_name] = ($sec['deduct_detail'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['deduct_detail'][$mineral_name] == 'Approved') ? 'success' : 'error');
						// }
		
						//PART II: Sales/Dispatches
						// if($mineral_name == 'iron ore'){
							//hematite
							$sec['sale_despatch'][$mineral_name.'/hematite'] = (isset($app_sec[$mineral_ul]['hematite'][4])) ? $app_sec[$mineral_ul]['hematite'][4] : '';
							$secStatus['sale_despatch'][$mineral_name.'/hematite'] = ($sec['sale_despatch'][$mineral_name.'/hematite'] == 'Rejected') ? 'pending' : (($sec['sale_despatch'][$mineral_name.'/hematite'] == 'Approved') ? 'success' : 'error');
							
							//magnetite
							$sec['sale_despatch'][$mineral_name.'/magnetite'] = (isset($app_sec[$mineral_ul]['magnetite'][4])) ? $app_sec[$mineral_ul]['magnetite'][4] : '';
							$secStatus['sale_despatch'][$mineral_name.'/magnetite'] = ($sec['sale_despatch'][$mineral_name.'/magnetite'] == 'Rejected') ? 'pending' : (($sec['sale_despatch'][$mineral_name.'/magnetite'] == 'Approved') ? 'success' : 'error');

							//other
							$sec['sale_despatch'][$mineral_name] = (isset($app_sec[$mineral_ul][4])) ? $app_sec[$mineral_ul][4] : '';
							$secStatus['sale_despatch'][$mineral_name] = ($sec['sale_despatch'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['sale_despatch'][$mineral_name] == 'Approved') ? 'success' : 'error');
						// }
		
					} else if($mcFormMain == 2){

						//PART II: Production / Stocks (ROM)
						$sec['rom_stocks_ore'][$mineral_name] = (isset($app_sec[$mineral_ul][1])) ? $app_sec[$mineral_ul][1] : '';
						$secStatus['rom_stocks_ore'][$mineral_name] = ($sec['rom_stocks_ore'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['rom_stocks_ore'][$mineral_name] == 'Approved') ? 'success' : 'error');
		
						//PART II: Ex-Mine Price
						$sec['ex_mine'][$mineral_name] = (isset($app_sec[$mineral_ul][2])) ? $app_sec[$mineral_ul][2] : '';
						$secStatus['ex_mine'][$mineral_name] = ($sec['ex_mine'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['ex_mine'][$mineral_name] == 'Approved') ? 'success' : 'error');
		
						//PART II: Recoveries at Concentrator
						$sec['con_reco'][$mineral_name] = (isset($app_sec[$mineral_ul][3])) ? $app_sec[$mineral_ul][3] : '';
						$secStatus['con_reco'][$mineral_name] = ($sec['con_reco'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['con_reco'][$mineral_name] == 'Approved') ? 'success' : 'error');
		
						//PART II: Recovery at the Smelter
						$sec['smelt_reco'][$mineral_name] = (isset($app_sec[$mineral_ul][4])) ? $app_sec[$mineral_ul][4] : '';
						$secStatus['smelt_reco'][$mineral_name] = ($sec['smelt_reco'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['smelt_reco'][$mineral_name] == 'Approved') ? 'success' : 'error');
						

						//PART II: Sales(Metals/By Product)
						$sec['sales_metal_product'][$mineral_name] = (isset($app_sec[$mineral_ul][5])) ? $app_sec[$mineral_ul][5] : '';
						$secStatus['sales_metal_product'][$mineral_name] = ($sec['sales_metal_product'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['sales_metal_product'][$mineral_name] == 'Approved') ? 'success' : 'error');
		
						//PART II: Details of Deductions
						$sec['deduct_detail'][$mineral_name] = (isset($app_sec[$mineral_ul][6])) ? $app_sec[$mineral_ul][6] : '';
						$secStatus['deduct_detail'][$mineral_name] = ($sec['deduct_detail'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['deduct_detail'][$mineral_name] == 'Approved') ? 'success' : 'error');
		
						//PART II: Sales/Dispatches
						$sec['sale_despatch'][$mineral_name] = (isset($app_sec[$mineral_ul][7])) ? $app_sec[$mineral_ul][7] : '';
						$secStatus['sale_despatch'][$mineral_name] = ($sec['sale_despatch'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['sale_despatch'][$mineral_name] == 'Approved') ? 'success' : 'error');
						
					} else if($mcFormMain == 3){
						
						//PART II: Production / Stocks (ROM) (Form F7)
						$sec['rom_stocks_three'][$mineral_name] = (isset($app_sec[$mineral_ul][1])) ? $app_sec[$mineral_ul][1] : '';
						$secStatus['rom_stocks_three'][$mineral_name] = ($sec['rom_stocks_three'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['rom_stocks_three'][$mineral_name] == 'Approved') ? 'success' : 'error');
						
						//PART II: Production / Stocks (ROM) (Form F8)
						$sec['rom_stocks'][$mineral_name] = (isset($app_sec[$mineral_ul][1])) ? $app_sec[$mineral_ul][1] : '';
						$secStatus['rom_stocks'][$mineral_name] = ($sec['rom_stocks'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['rom_stocks'][$mineral_name] == 'Approved') ? 'success' : 'error');
						
						//PART II: Grade-Wise Production (Form F8)
						$sec['gradewise_prod'][$mineral_name] = (isset($app_sec[$mineral_ul][2])) ? $app_sec[$mineral_ul][2] : '';
						$secStatus['gradewise_prod'][$mineral_name] = ($sec['gradewise_prod'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['gradewise_prod'][$mineral_name] == 'Approved') ? 'success' : 'error');
						
						//PART II: Pulverisation
						$sec['pulverisation'][$mineral_name] = (isset($app_sec[$mineral_ul][5])) ? $app_sec[$mineral_ul][5] : '';
						$secStatus['pulverisation'][$mineral_name] = ($sec['pulverisation'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['pulverisation'][$mineral_name] == 'Approved') ? 'success' : 'error');
						
						//PART II: Production, Despatches and Stocks
						$sec['prod_stock_dis'][$mineral_name] = (isset($app_sec[$mineral_ul][2])) ? $app_sec[$mineral_ul][2] : '';
						$secStatus['prod_stock_dis'][$mineral_name] = ($sec['prod_stock_dis'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['prod_stock_dis'][$mineral_name] == 'Approved') ? 'success' : 'error');
						
						//PART II: Details of Deductions
						$sec['deduct_detail'][$mineral_name] = (isset($app_sec[$mineral_ul][3])) ? $app_sec[$mineral_ul][3] : '';
						$secStatus['deduct_detail'][$mineral_name] = ($sec['deduct_detail'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['deduct_detail'][$mineral_name] == 'Approved') ? 'success' : 'error');
		
						//PART II: Sales/Dispatches
						$sec['sale_despatch'][$mineral_name] = (isset($app_sec[$mineral_ul][4])) ? $app_sec[$mineral_ul][4] : '';
						$secStatus['sale_despatch'][$mineral_name] = ($sec['sale_despatch'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['sale_despatch'][$mineral_name] == 'Approved') ? 'success' : 'error');
		
					}
		
				}

			} else {

				
				//PART I: DETAILS OF THE MINE
				$sec['mine'] = (isset($app_sec['partI'][1])) ? $app_sec['partI'][1] : '';
				$secStatus['mine'] = ($sec['mine'] == 'Rejected') ? 'pending' : (($sec['mine'] == 'Approved') ? 'success' : 'error');
		
				//PART I: NAME AND ADDRESS
				$sec['name_address'] = (isset($app_sec['partI'][2])) ? $app_sec['partI'][2] : '';
				$secStatus['name_address'] = ($sec['name_address'] == 'Rejected') ? 'pending' : (($sec['name_address'] == 'Approved') ? 'success' : 'error');
		
				//PART I: PARTICULARS OF AREA OPERATED
				$sec['particulars'] = (isset($app_sec['partI'][3])) ? $app_sec['partI'][3] : '';
				$secStatus['particulars'] = ($sec['particulars'] == 'Rejected') ? 'pending' : (($sec['particulars'] == 'Approved') ? 'success' : 'error');
				
				//PART I: LEASE AREA UTILISATION
				$sec['area_utilisation'] = (isset($app_sec['partI'][4])) ? $app_sec['partI'][4] : '';
				$secStatus['area_utilisation'] = ($sec['area_utilisation'] == 'Rejected') ? 'pending' : (($sec['area_utilisation'] == 'Approved') ? 'success' : 'error');

				// PART II: EMPLOYMENT & WAGES I
				$sec['employment_wages'] = (isset($app_sec['partII'][1])) ? $app_sec['partII'][1] : '';
				$secStatus['employment_wages'] = ($sec['employment_wages'] == 'Rejected') ? 'pending' : (($sec['employment_wages'] == 'Approved') ? 'success' : 'error');
				
				// PART II: EMPLOYMENT & WAGES II
				$sec['employment_wages_part'] = (isset($app_sec['partII'][3])) ? $app_sec['partII'][3] : '';
				$secStatus['employment_wages_part'] = ($sec['employment_wages_part'] == 'Rejected') ? 'pending' : (($sec['employment_wages_part'] == 'Approved') ? 'success' : 'error');
				
				// PART II: CAPITAL STRUCTURE
				$sec['capital_structure'] = (isset($app_sec['partII'][2])) ? $app_sec['partII'][2] : '';
				$secStatus['capital_structure'] = ($sec['capital_structure'] == 'Rejected') ? 'pending' : (($sec['capital_structure'] == 'Approved') ? 'success' : 'error');
				
    			// PART III: QUANTITY & COST OF MATERIAL
				$sec['material_consumption_quantity'] = (isset($app_sec['partIII'][1])) ? $app_sec['partIII'][1] : '';
				$secStatus['material_consumption_quantity'] = ($sec['material_consumption_quantity'] == 'Rejected') ? 'pending' : (($sec['material_consumption_quantity'] == 'Approved') ? 'success' : 'error');
				
    			// PART III: ROYALTY / COMPENSATION / DEPRECIATION
				$sec['material_consumption_royalty'] = (isset($app_sec['partIII'][2])) ? $app_sec['partIII'][2] : '';
				$secStatus['material_consumption_royalty'] = ($sec['material_consumption_royalty'] == 'Rejected') ? 'pending' : (($sec['material_consumption_royalty'] == 'Approved') ? 'success' : 'error');
				
    			// PART III: TAXES / OTHER EXPENSES
				$sec['material_consumption_tax'] = (isset($app_sec['partIII'][3])) ? $app_sec['partIII'][3] : '';
				$secStatus['material_consumption_tax'] = ($sec['material_consumption_tax'] == 'Rejected') ? 'pending' : (($sec['material_consumption_tax'] == 'Approved') ? 'success' : 'error');
				
				// PART IV: CONSUMPTION OF EXPLOSIVES
				$sec['explosive_consumption'] = (isset($app_sec['partIV'][1])) ? $app_sec['partIV'][1] : '';
				$secStatus['explosive_consumption'] = ($sec['explosive_consumption'] == 'Rejected') ? 'pending' : (($sec['explosive_consumption'] == 'Approved') ? 'success' : 'error');
				
				// PART V:
				$mineralArr = $this->Session->read('mineralArr');
				$formType12 = $this->Session->read('mc_form_type');

    			// PART V: SEC 1 : EXPLORATION
				$sec['geology_exploration'] = (isset($app_sec['partV'][1])) ? $app_sec['partV'][1] : '';
				$secStatus['geology_exploration'] = ($sec['geology_exploration'] == 'Rejected') ? 'pending' : (($sec['geology_exploration'] == 'Approved') ? 'success' : 'error');
				
    			// PART V: SEC 4/5 : OVERBURDEN AND WASTE / TREES PLANTED- SURVIVAL RATE
				$sec['geology_overburden_trees'] = (isset($app_sec['partV'][3])) ? $app_sec['partV'][3] : '';
				$secStatus['geology_overburden_trees'] = ($sec['geology_overburden_trees'] == 'Rejected') ? 'pending' : (($sec['geology_overburden_trees'] == 'Approved') ? 'success' : 'error');
				
    			// PART V: SEC 6 :  TYPE OF MACHINERY
				$sec['geology_part_three'] = (isset($app_sec['partV'][4])) ? $app_sec['partV'][4] : '';
				$secStatus['geology_part_three'] = ($sec['geology_part_three'] == 'Rejected') ? 'pending' : (($sec['geology_part_three'] == 'Approved') ? 'success' : 'error');
				
				foreach($mineralArr as $mineral){
					$mineral_name = strtolower($mineral);
					$mineral_sp = str_replace('_',' ',$mineral_name);
					$mineralName = strtolower(str_replace(' ','_',$mineral));

					// PART V: SEC 2/3 : RESERVES AND RESOURCES ESTIMATED / SUBGRADE-MINERAL REJECT
					$sec['geology_reserves_subgrade'][$mineral_name] = (isset($app_sec['partV'][2][$mineralName])) ? $app_sec['partV'][2] : '';
					
					if($sec['geology_reserves_subgrade'][$mineral_name] != ''){
					$secStatus['geology_reserves_subgrade'][$mineral_name] = ($sec['geology_reserves_subgrade'][$mineral_name][$mineralName] == 'Rejected') ? 'pending' : (($sec['geology_reserves_subgrade'][$mineral_name][$mineralName] == 'Approved') ? 'success' : 'error');
					}else{ $secStatus['geology_reserves_subgrade'][$mineral_name] = 'error'; }

    				// PART V: SEC 7 : MINERAL TREATMENT PLANT
					$sec['geology_part_six'][$mineral_name] = (isset($app_sec['partV'][5][$mineralName])) ? $app_sec['partV'][5] : '';
					if($sec['geology_part_six'][$mineral_name] != ''){
					$secStatus['geology_part_six'][$mineral_name] = ($sec['geology_part_six'][$mineral_name][$mineralName] == 'Rejected') ? 'pending' : (($sec['geology_part_six'][$mineral_name][$mineralName] == 'Approved') ? 'success' : 'error'); } else{
						$secStatus['geology_part_six'][$mineral_name] = 'error';
					}

				}

				//PART VI:
				$mcFormMain = $this->Session->read('mc_form_main');
				$mineralArr = $this->Session->read('mineralArr');
				$is_hematite = $this->Session->read('is_hematite');
				$is_magnetite = $this->Session->read('is_magnetite');
				foreach($mineralArr as $mineral){
		
					$mineral_name = strtolower($mineral);
					$mineral_sp = str_replace('_',' ',$mineral_name);
					$mineral_ul = str_replace(' ','_',$mineral_name); //mineral underscore lowercase

					//set sub mineral
					if($mineral_name == 'iron ore'){
						if($is_hematite == true){
							$ironSubMin = 'hematite';
						} else if($is_magnetite == true){
							$ironSubMin = 'magnetite';
						} else {
							$ironSubMin = '';
						}
					} else {
						$ironSubMin = '';
					}
					
					$formNo = $this->DirMcpMineral->getFormNumber($mineral);
					$reason_no = array();
					if ($formNo == 6){
						$reason_no['deduct_detail'] = 2;
						$reason_no['sale_despatch'] = 3;
					}
					else if ($formNo == 5){
						$reason_no['deduct_detail'] = 6;
						$reason_no['sale_despatch'] = 7;
					}
					else {
						$reason_no['deduct_detail'] = 3;
						$reason_no['sale_despatch'] = 4;
					}
		
					if($mcFormMain == 1){
		
						//PART VI: TYPE OF ORE
						$oreTypeStatus = ($is_hematite == true || $is_magnetite == true) ? "success" : "error";
						$secStatus['ore_type'][$mineral_name] = $oreTypeStatus;
		
						//PART VI: Production / Stocks (ROM) (Form F1)
						// if($mineral_name == 'iron ore'){
						// 	if($is_hematite == true){
								$sec['rom_stocks'][$mineral_name.'/hematite'] = (isset($app_sec[$mineral_ul]['hematite'][1])) ? $app_sec[$mineral_ul]['hematite'][1] : '';
								$secStatus['rom_stocks'][$mineral_name.'/hematite'] = ($sec['rom_stocks'][$mineral_name.'/hematite'] == 'Rejected') ? 'pending' : (($sec['rom_stocks'][$mineral_name.'/hematite'] == 'Approved') ? 'success' : 'error');
							// }
							// if($is_magnetite == true){
								$sec['rom_stocks'][$mineral_name.'/magnetite'] = (isset($app_sec[$mineral_ul]['magnetite'][1])) ? $app_sec[$mineral_ul]['magnetite'][1] : '';
								$secStatus['rom_stocks'][$mineral_name.'/magnetite'] = ($sec['rom_stocks'][$mineral_name.'/magnetite'] == 'Rejected') ? 'pending' : (($sec['rom_stocks'][$mineral_name.'/magnetite'] == 'Approved') ? 'success' : 'error');
							// }
							// if($is_hematite != true && $is_magnetite != true){
								$sec['rom_stocks'][$mineral_name] = (isset($app_sec[$mineral_ul][1])) ? $app_sec[$mineral_ul][1] : '';
								$secStatus['rom_stocks'][$mineral_name] = ($sec['rom_stocks'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['rom_stocks'][$mineral_name] == 'Approved') ? 'success' : 'error');
							// }
						// }

						
						//PART VI: Production / Stocks (ROM) (Form F7)
						$sec['rom_stocks_three'][$mineral_name] = (isset($app_sec[$mineral_ul][1])) ? $app_sec[$mineral_ul][1] : '';
						$secStatus['rom_stocks_three'][$mineral_name] = ($sec['rom_stocks_three'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['rom_stocks_three'][$mineral_name] == 'Approved') ? 'success' : 'error');
		
						//PART VI: Grade-Wise Production
						
						// if($mineral_name == 'iron ore'){
						// 	if($is_hematite == true){
								$sec['gradewise_prod'][$mineral_name.'/hematite'] = (isset($app_sec[$mineral_ul]['hematite'][2])) ? $app_sec[$mineral_ul]['hematite'][2] : '';
								$secStatus['gradewise_prod'][$mineral_name.'/hematite'] = ($sec['gradewise_prod'][$mineral_name.'/hematite'] == 'Rejected') ? 'pending' : (($sec['gradewise_prod'][$mineral_name.'/hematite'] == 'Approved') ? 'success' : 'error');
							// }
							// if($is_magnetite == true){
								$sec['gradewise_prod'][$mineral_name.'/magnetite'] = (isset($app_sec[$mineral_ul]['magnetite'][2])) ? $app_sec[$mineral_ul]['magnetite'][2] : '';
								$secStatus['gradewise_prod'][$mineral_name.'/magnetite'] = ($sec['gradewise_prod'][$mineral_name.'/magnetite'] == 'Rejected') ? 'pending' : (($sec['gradewise_prod'][$mineral_name.'/magnetite'] == 'Approved') ? 'success' : 'error');
							// }
							// if($is_hematite != true && $is_magnetite != true){
								$sec['gradewise_prod'][$mineral_name] = (isset($app_sec[$mineral_ul][2])) ? $app_sec[$mineral_ul][2] : '';
								$secStatus['gradewise_prod'][$mineral_name] = ($sec['gradewise_prod'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['gradewise_prod'][$mineral_name] == 'Approved') ? 'success' : 'error');
						// 	}
						// }

						//PART VI: Production, Despatches and Stocks (Form F7)
						$sec['prod_stock_dis'][$mineral_name] = (isset($app_sec[$mineral_ul][2])) ? $app_sec[$mineral_ul][2] : '';
						$secStatus['prod_stock_dis'][$mineral_name] = ($sec['prod_stock_dis'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['prod_stock_dis'][$mineral_name] == 'Approved') ? 'success' : 'error');
		
						//PART VI: Pulverisation
						$sec['pulverisation'][$mineral_name] = (isset($app_sec[$mineral_ul][5])) ? $app_sec[$mineral_ul][5] : '';
						$secStatus['pulverisation'][$mineral_name] = ($sec['pulverisation'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['pulverisation'][$mineral_name] == 'Approved') ? 'success' : 'error');
		
						//PART VI: Details of Deductions
						
						// if($mineral_name == 'iron ore'){
							//hematite
							$sec['deduct_detail'][$mineral_name.'/hematite'] = (isset($app_sec[$mineral_ul]['hematite'][3])) ? $app_sec[$mineral_ul]['hematite'][3] : '';
							$secStatus['deduct_detail'][$mineral_name.'/hematite'] = ($sec['deduct_detail'][$mineral_name.'/hematite'] == 'Rejected') ? 'pending' : (($sec['deduct_detail'][$mineral_name.'/hematite'] == 'Approved') ? 'success' : 'error');
							
							//magnetite
							$sec['deduct_detail'][$mineral_name.'/magnetite'] = (isset($app_sec[$mineral_ul]['magnetite'][3])) ? $app_sec[$mineral_ul]['magnetite'][3] : '';
							$secStatus['deduct_detail'][$mineral_name.'/magnetite'] = ($sec['deduct_detail'][$mineral_name.'/magnetite'] == 'Rejected') ? 'pending' : (($sec['deduct_detail'][$mineral_name.'/magnetite'] == 'Approved') ? 'success' : 'error');
							
							//other
							$sec['deduct_detail'][$mineral_name] = (isset($app_sec[$mineral_ul][3])) ? $app_sec[$mineral_ul][3] : '';
							$secStatus['deduct_detail'][$mineral_name] = ($sec['deduct_detail'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['deduct_detail'][$mineral_name] == 'Approved') ? 'success' : 'error');
						// }
		
						//PART VI: Sales/Dispatches
						// if($mineral_name == 'iron ore'){
							//hematite
							$sec['sale_despatch'][$mineral_name.'/hematite'] = (isset($app_sec[$mineral_ul]['hematite'][4])) ? $app_sec[$mineral_ul]['hematite'][4] : '';
							$secStatus['sale_despatch'][$mineral_name.'/hematite'] = ($sec['sale_despatch'][$mineral_name.'/hematite'] == 'Rejected') ? 'pending' : (($sec['sale_despatch'][$mineral_name.'/hematite'] == 'Approved') ? 'success' : 'error');
							
							//magnetite
							$sec['sale_despatch'][$mineral_name.'/magnetite'] = (isset($app_sec[$mineral_ul]['magnetite'][4])) ? $app_sec[$mineral_ul]['magnetite'][4] : '';
							$secStatus['sale_despatch'][$mineral_name.'/magnetite'] = ($sec['sale_despatch'][$mineral_name.'/magnetite'] == 'Rejected') ? 'pending' : (($sec['sale_despatch'][$mineral_name.'/magnetite'] == 'Approved') ? 'success' : 'error');

							//other
							$sec['sale_despatch'][$mineral_name] = (isset($app_sec[$mineral_ul][4])) ? $app_sec[$mineral_ul][4] : '';
							$secStatus['sale_despatch'][$mineral_name] = ($sec['sale_despatch'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['sale_despatch'][$mineral_name] == 'Approved') ? 'success' : 'error');
						// }
		
					} else if($mcFormMain == 2){

						//PART II: Production / Stocks (ROM)
						$sec['rom_stocks_ore'][$mineral_name] = (isset($app_sec[$mineral_ul][1])) ? $app_sec[$mineral_ul][1] : '';
						$secStatus['rom_stocks_ore'][$mineral_name] = ($sec['rom_stocks_ore'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['rom_stocks_ore'][$mineral_name] == 'Approved') ? 'success' : 'error');
		
						//PART II: Ex-Mine Price
						$sec['ex_mine'][$mineral_name] = (isset($app_sec[$mineral_ul][2])) ? $app_sec[$mineral_ul][2] : '';
						$secStatus['ex_mine'][$mineral_name] = ($sec['ex_mine'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['ex_mine'][$mineral_name] == 'Approved') ? 'success' : 'error');
		
						//PART II: Recoveries at Concentrator
						$sec['con_reco'][$mineral_name] = (isset($app_sec[$mineral_ul][3])) ? $app_sec[$mineral_ul][3] : '';
						$secStatus['con_reco'][$mineral_name] = ($sec['con_reco'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['con_reco'][$mineral_name] == 'Approved') ? 'success' : 'error');
		
						//PART II: Recovery at the Smelter
						$sec['smelt_reco'][$mineral_name] = (isset($app_sec[$mineral_ul][4])) ? $app_sec[$mineral_ul][4] : '';
						$secStatus['smelt_reco'][$mineral_name] = ($sec['smelt_reco'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['smelt_reco'][$mineral_name] == 'Approved') ? 'success' : 'error');
		

						//PART II: Sales(Metals/By Product)
						$sec['sales_metal_product'][$mineral_name] = (isset($app_sec[$mineral_ul][5])) ? $app_sec[$mineral_ul][5] : '';
						$secStatus['sales_metal_product'][$mineral_name] = ($sec['sales_metal_product'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['sales_metal_product'][$mineral_name] == 'Approved') ? 'success' : 'error');
		
						//PART II: Details of Deductions
						$sec['deduct_detail'][$mineral_name] = (isset($app_sec[$mineral_ul][6])) ? $app_sec[$mineral_ul][6] : '';

						$secStatus['deduct_detail'][$mineral_name] = ($sec['deduct_detail'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['deduct_detail'][$mineral_name] == 'Approved') ? 'success' : 'error');
			
						//PART II: Sales/Dispatches
						$sec['sale_despatch'][$mineral_name] = (isset($app_sec[$mineral_ul][7])) ? $app_sec[$mineral_ul][7] : '';
						$secStatus['sale_despatch'][$mineral_name] = ($sec['sale_despatch'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['sale_despatch'][$mineral_name] == 'Approved') ? 'success' : 'error');
						
					} else if($mcFormMain == 3){
		
						//PART II: Production / Stocks (ROM) (Form F7)
						$sec['rom_stocks_three'][$mineral_name] = (isset($app_sec[$mineral_ul][1])) ? $app_sec[$mineral_ul][1] : '';
						$secStatus['rom_stocks_three'][$mineral_name] = ($sec['rom_stocks_three'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['rom_stocks_three'][$mineral_name] == 'Approved') ? 'success' : 'error');
						
						//PART II: Production / Stocks (ROM) (Form F8)
						$sec['rom_stocks'][$mineral_name] = (isset($app_sec[$mineral_ul][1])) ? $app_sec[$mineral_ul][1] : '';
						$secStatus['rom_stocks'][$mineral_name] = ($sec['rom_stocks'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['rom_stocks'][$mineral_name] == 'Approved') ? 'success' : 'error');
						
						//PART II: Grade-Wise Production (Form F8)
						$sec['gradewise_prod'][$mineral_name] = (isset($app_sec[$mineral_ul][2])) ? $app_sec[$mineral_ul][2] : '';
						$secStatus['gradewise_prod'][$mineral_name] = ($sec['gradewise_prod'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['gradewise_prod'][$mineral_name] == 'Approved') ? 'success' : 'error');
						
						//PART II: Pulverisation
						$sec['pulverisation'][$mineral_name] = (isset($app_sec[$mineral_ul][5])) ? $app_sec[$mineral_ul][5] : '';
						$secStatus['pulverisation'][$mineral_name] = ($sec['pulverisation'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['pulverisation'][$mineral_name] == 'Approved') ? 'success' : 'error');
						
						//PART II: Production, Despatches and Stocks
						$sec['prod_stock_dis'][$mineral_name] = (isset($app_sec[$mineral_ul][2])) ? $app_sec[$mineral_ul][2] : '';
						$secStatus['prod_stock_dis'][$mineral_name] = ($sec['prod_stock_dis'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['prod_stock_dis'][$mineral_name] == 'Approved') ? 'success' : 'error');
						
						//PART II: Details of Deductions
						$sec['deduct_detail'][$mineral_name] = (isset($app_sec[$mineral_ul][3])) ? $app_sec[$mineral_ul][3] : '';
						$secStatus['deduct_detail'][$mineral_name] = ($sec['deduct_detail'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['deduct_detail'][$mineral_name] == 'Approved') ? 'success' : 'error');
		
						//PART II: Sales/Dispatches
						$sec['sale_despatch'][$mineral_name] = (isset($app_sec[$mineral_ul][4])) ? $app_sec[$mineral_ul][4] : '';
						$secStatus['sale_despatch'][$mineral_name] = ($sec['sale_despatch'][$mineral_name] == 'Rejected') ? 'pending' : (($sec['sale_despatch'][$mineral_name] == 'Approved') ? 'success' : 'error');
		
					}
		
				}
				
    			// PART VII: COST OF PRODUCTION
				$sec['production_cost'] = (isset($app_sec['partVII'][1])) ? $app_sec['partVII'][1] : '';
				$secStatus['production_cost'] = ($sec['production_cost'] == 'Rejected') ? 'pending' : (($sec['production_cost'] == 'Approved') ? 'success' : 'error');
			}
	
			$this->Session->write('secStatus',$secStatus);
	
		}

		
		/**
		 * SET SECTION COLOR CODES AS PER SECTION STATUS
		 * FOR MMS PANEL
		 * @version 11th Jan 2022
		 * @author Aniket Ganvir
		 */
		public function setEnduserSectionColorCode($formType, $returnType, $returnDate, $endUserId){
			
			$returnId = $this->TblEndUserFinalSubmit->getLatestReturnId($endUserId, $returnDate, $returnType);
			$returnData = $this->TblEndUserFinalSubmit->findReturnById($returnId);
			$tmpSec = $returnData['approved_sections'];
			$app_sec = unserialize($tmpSec);
	
			//PART I: Instruction
			$secStatus['instruction'] = 'success';
	
			//PART I: General Particular
			$secStatus['gen_particular'] = 'success';
	
			//PART II: Trading Activity
			$sec['trading_ac'] = (isset($app_sec['partII'][1])) ? $app_sec['partII'][1] : '';
			$secStatus['trading_ac'] = ($sec['trading_ac'] == 'Rejected') ? 'pending' : (($sec['trading_ac'] == 'Approved') ? 'success' : 'error');
			
			//PART II: Export Activity
			$sec['export_ac'] = (isset($app_sec['partII'][2])) ? $app_sec['partII'][2] : '';
			$secStatus['export_ac'] = ($sec['export_ac'] == 'Rejected') ? 'pending' : (($sec['export_ac'] == 'Approved') ? 'success' : 'error');
			
			//PART II: End-Use Mineral Based Activity
			$sec['min_bas_ac'] = (isset($app_sec['partII'][3])) ? $app_sec['partII'][3] : '';
			$secStatus['min_bas_ac'] = ($sec['min_bas_ac'] == 'Rejected') ? 'pending' : (($sec['min_bas_ac'] == 'Approved') ? 'success' : 'error');
			
			//PART II: Storage Activity
			$sec['storage_ac'] = (isset($app_sec['partII'][4])) ? $app_sec['partII'][4] : '';
			$secStatus['storage_ac'] = ($sec['storage_ac'] == 'Rejected') ? 'pending' : (($sec['storage_ac'] == 'Approved') ? 'success' : 'error');

			if ($returnType == 'ANNUAL') {

				//PART III: End-Use Mineral Based Ind-I
				$sec['min_bas_ind'] = (isset($app_sec['partIII'][1])) ? $app_sec['partIII'][1] : '';
				$secStatus['min_bas_ind'] = ($sec['min_bas_ind'] == 'Rejected') ? 'pending' : (($sec['min_bas_ind'] == 'Approved') ? 'success' : 'error');

				//PART III: End-Use Mineral Based Ind-II
				$sec['prod_man_det'] = (isset($app_sec['partIII'][2])) ? $app_sec['partIII'][2] : '';
				$secStatus['prod_man_det'] = ($sec['prod_man_det'] == 'Rejected') ? 'pending' : (($sec['prod_man_det'] == 'Approved') ? 'success' : 'error');
				
				//PART III: Iron And Steel Industry
				$sec['iron_steel'] = (isset($app_sec['partIII'][3])) ? $app_sec['partIII'][3] : '';
				$secStatus['iron_steel'] = ($sec['iron_steel'] == 'Rejected') ? 'pending' : (($sec['iron_steel'] == 'Approved') ? 'success' : 'error');

				//PART III: Raw Materials Consumed In Production
				$sec['raw_mat_cons'] = (isset($app_sec['partIII'][4])) ? $app_sec['partIII'][4] : '';
				$secStatus['raw_mat_cons'] = ($sec['raw_mat_cons'] == 'Rejected') ? 'pending' : (($sec['raw_mat_cons'] == 'Approved') ? 'success' : 'error');
				
				//PART III: Source Of Supply
				$sec['sour_supp'] = (isset($app_sec['partIII'][5])) ? $app_sec['partIII'][5] : '';
				$secStatus['sour_supp'] = ($sec['sour_supp'] == 'Rejected') ? 'pending' : (($sec['sour_supp'] == 'Approved') ? 'success' : 'error');

			}
			
			$this->Session->write('secStatus',$secStatus);
			
		}

		public function fileUploadLib($file_name,$file_size,$file_type,$file_local_path,$file_size_limit_mb = 2,$ticket_attachment = null){

			$valid_extension_file = array('jpeg','pdf','jpg','xls','xlsx','kml','kmz','docx');
			$valid_file_type = array(
				'application/pdf',
				'image/jpeg',
				'application/vnd.google-earth.kml+xml',
				'application/vnd.google-earth.kmz',
				'application/octet-stream',
				'application/xml',
				'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
				'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
				'application/vnd.ms-excel'
			);
			$get_extension_value = explode('.',$file_name);

			$uploadData = '';

			if (count($get_extension_value) != 2 ) {

			    $message = 'Invalid file type';

			} else {

			    $extension_name = strtolower($get_extension_value[1]);

			    if (in_array($extension_name,$valid_extension_file)) {} else {

			        $message = 'Invalid file type.';
			    }
			}
			
			switch ($file_size_limit_mb) {
				case 2:
					$file_size_limit = 2097152;
					break;
				case 10:
					$file_size_limit = 10534243;
					break;
				case 15:
					$file_size_limit = 15728640;
					break;
				default:
					$file_size_limit = 2097152;
			}

			if (($file_size > $file_size_limit)) {

			    $message = 'File too large. File must be less than '.$file_size_limit_mb.' megabytes.';			    

			} elseif (!in_array($file_type, $valid_file_type)) {

			    $message = 'Invalid file type. Only PDF, JPG, Excel, KMZ types are accepted.';

			} else {

			    // For PDF files
			    if ($file_type == "application/pdf" ) {

			        if ($f = fopen($file_local_path, 'rb')) {

			            $header = fread($f, 4);
			            fclose($f);

			            // Signature = PDF
			            if (strncmp($header, "\x25\x50\x44\x46", 4)==0 && strlen ($header)==4) {

			                // CHECK IF PDF CONTENT HAVING MALICIOUS CHARACTERS OR NOT
			                $pdf_content = file_get_contents($file_local_path);

			                $cleaned_pdf_content = $this->fileClean($pdf_content);

			                if ($cleaned_pdf_content=='invalid') {

			                	$message = 'File seems to be corrupted !';	
			                }

			            } else {

			                $message = 'Sorry....modified PDF file';
			            }

			        } else {

			           	$message = 'Not getting file path';
			        }

			    } elseif ($file_type == "image/jpeg" ) {

			        if ($f = fopen($file_local_path, 'rb')) {

			            $header = fread($f, 3);
			            fclose($f);

			            // Signature = JPEG
			            if (strncmp($header, "\xFF\xD8\xFF", 3)==0 && strlen ($header)==3) {

			                // CHECK FOR CORRUPTED (MODIFIED) FILE
			                $img_content = file_get_contents($file_local_path);
			                $im = imagecreatefromstring($img_content);
			                if ($im !== false) {
			                    // original file
			                } else {
			                	$message = 'File seems to be corrupted !';			                    
			                }

			                // CHECK IF IMAGE CONTENTS HAVING MALICIOUS CHARACTERS OR NOT
			                $img_content = file_get_contents($file_local_path);
			                $cleaned_img_content = $this->fileClean($img_content);

			                if ($cleaned_img_content=='invalid') {

			                   $message = 'File seems to be corrupted !';			                    
			                }

			            } else {

			                $message = 'Sorry....modified JPG file';
			            }

			        } else {

			            $message = 'Not getting file path';

			        }

			    } elseif ($file_type == "image/jpg") {

			        if ($f = fopen($file_local_path, 'rb')) {

			            $header = fread($f, 3);
			            fclose($f);

			            // Signature = JPEG
			            if (strncmp($header, "\xFF\xD8\xFF", 3)==0 && strlen ($header)==3) {

			                // CHECK FOR CORRUPTED (MODIFIED) FILE
			                $img_content = file_get_contents($file_local_path);
			                $im = imagecreatefromstring($img_content);
			                if ($im !== false) {
			                    // original file
			                } else {

			                    $message = 'File seems to be corrupted !';
			                }

			                // CHECK IF IMAGE CONTENTS HAVING MALICIOUS CHARACTERS OR NOT
			                $img_content = file_get_contents($file_local_path);
			                $cleaned_img_content = $this->fileClean($img_content);

			                if ($cleaned_img_content=='invalid') {

			                    $message =  'File seems to be corrupted !';
			                }

			            } else {

			                $message = 'Sorry....modified JPG file';
			            }

			        } else {

			            $message = 'Not getting file path';
			            return false;

			        }

			    } elseif ($file_type == "application/xml" || $file_type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" || $file_type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
					// Check if the file is either XML, Excel, or Word (docx) file

					if ($f = fopen($file_local_path, 'rb')) {
						$header = fread($f, 4);
						fclose($f);

						// Signature = Excel or Word or XML
						if ((strncmp($header, "\xD0\xCF\x11\xE0", 4) == 0 || strncmp($header, "\x50\x4B\x03\x04", 4) == 0 || strncmp($header, "\x50\x4B\x03\x04", 4) == 0) && strlen($header) == 4) {

							// CHECK IF EXCEL CONTENT HAVING MALICIOUS CHARACTERS OR NOT
							$excel_content = file_get_contents($file_local_path);

							$cleaned_excel_content = $this->fileClean($excel_content);

							if ($cleaned_excel_content == 'invalid') {
								$message = 'File seems to be corrupted!';
							} else {
				                // Process the XML, Excel, or Word file
				                // Add your code here to handle the specific file type (docx, XML, or Excel)
				            }

						} else {
							$message = 'Sorry....modified Excel file';
						}
					} else {
						$message = 'Not getting file path';
					}

				} 
				elseif ($file_type == "application/octet-stream" || $file_type == "application/vnd.google-earth.kmz" || $file_type == "application/vnd.google-earth.kml+xml") {
				//elseif ($file_type == "application/octet-stream" || $file_type == "application/vnd.google-earth.kml+xml" || $file_type == "application/xml") { // For KMZ files

			        if ($f = fopen($file_local_path, 'rb')) {

			            $header = fread($f, 4);
			            fclose($f);

			            // Signature = KMZ
						// 50 50 03 04
						// 50 4B 05 06 (empty archive)
						// 50 4B 07 08 (spanned archive)
			            if (((strncmp($header, "\x50\x50\x03\x04", 4)==0 || strncmp($header, "\x50\x4B\x05\x06", 4)==0 || strncmp($header, "\x50\x4B\x07\x08", 4)==0) && strlen ($header)==4) || $extension_name == 'kml') {

			                // CHECK IF KMZ CONTENT HAVING MALICIOUS CHARACTERS OR NOT
			                $kmz_content = file_get_contents($file_local_path);

			                $cleaned_kmz_content = $this->fileClean($kmz_content);

			                if ($cleaned_kmz_content=='invalid') {

			                	$message = 'File seems to be corrupted !';	
			                }

			            } else {

			                $message = 'Sorry....modified KMZ file';
			            }

			        } else {

			           	$message = 'Not getting file path';
			        }

				}

			    // File Uploading code start
				$fileNameFiltered = preg_replace('!\s+!', '_', $file_name); // replace spaces with "_" to handle "tcpdf file link not found" issue - Aniket [14-11-2022][c]
			    $filecodedName = time().uniqid().$fileNameFiltered;

			    if($ticket_attachment == true){
                
                         
                          $uploadPath = $_SERVER["DOCUMENT_ROOT"].'/webroot/writereaddata/IBM/files/ticket/';

				}else{
                 	      // print_r("santosh");die;
			              $uploadPath = $_SERVER["DOCUMENT_ROOT"].'/webroot/writereaddata/IBM/files/';
				}
			    $uploadFile = $uploadPath.$filecodedName;			    

			    if (move_uploaded_file($file_local_path,$uploadFile)) {
			    	
			    	if($ticket_attachment == true){
                       
                
                       
                      $uploadData = '/writereaddata/IBM/files/ticket/'.$filecodedName; 

			    	}else{
			        
			           
			          $uploadData = '/writereaddata/IBM/files/'.$filecodedName;

			         }

			    } else {

			         $message = 'File not uploaded please select proper file';
			    }

			}

			if (!empty($uploadData)) {

			    return array('success',$uploadData);

			}else{

				return array('error',$message);
			}

		}
		
		/*Yashwant 10-may-2023============*/
		public function supportFileUploadLib($file_name,$file_size,$file_type,$file_local_path,$ticket_attachment,$file_size_limit_mb = 2){

              
			$valid_extension_file = array('jpeg', 'pdf', 'jpg', 'xls', 'xlsx', 'kml', 'docx');
			$valid_file_type = array(
			    'application/pdf',
			    'image/jpeg',
			    'application/vnd.google-earth.kml+xml',
			    'application/octet-stream',
			    'application/xml',
			    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
			    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
			);
			$get_extension_value = explode('.',$file_name);

			$uploadData = '';

			if (count($get_extension_value) != 2 ) {

			    $message = 'Invalid file type';

			} else {

			    $extension_name = strtolower($get_extension_value[1]);
			// print_r($extension_name);die;

			    if (in_array($extension_name,$valid_extension_file)) {} else {

			        $message = 'Invalid file type.';
			    }
			}
			
			switch ($file_size_limit_mb) {
				case 2:
					$file_size_limit = 2097152;
					break;
				case 15:
					$file_size_limit = 15728640;
					break;
				default:
					$file_size_limit = 2097152;
			}


			if (($file_size > $file_size_limit)) {

			    $message = 'File too large. File must be less than '.$file_size_limit_mb.' megabytes.';			    

			} elseif (!in_array($file_type, $valid_file_type)) {

			    $message = 'Invalid file type. Only PDF, JPG, Excel, KMZ types are accepted.';

			} else {

			    // For PDF files
			    if ($file_type == "application/pdf" ) {

			        if ($f = fopen($file_local_path, 'rb')) {

			            $header = fread($f, 4);
			            fclose($f);

			            // Signature = PDF
			            if (strncmp($header, "\x25\x50\x44\x46", 4)==0 && strlen ($header)==4) {

			                // CHECK IF PDF CONTENT HAVING MALICIOUS CHARACTERS OR NOT
			                $pdf_content = file_get_contents($file_local_path);

			                $cleaned_pdf_content = $this->fileClean($pdf_content);

			                if ($cleaned_pdf_content=='invalid') {

			                	$message = 'File seems to be corrupted !';	
			                }

			            } else {

			                $message = 'Sorry....modified PDF file';
			            }

			        } else {

			           	$message = 'Not getting file path';
			        }

			    } elseif ($file_type == "image/jpeg" ) {

			        if ($f = fopen($file_local_path, 'rb')) {

			            $header = fread($f, 3);
			            fclose($f);

			            // Signature = JPEG
			            if (strncmp($header, "\xFF\xD8\xFF", 3)==0 && strlen ($header)==3) {

			                // CHECK FOR CORRUPTED (MODIFIED) FILE
			                $img_content = file_get_contents($file_local_path);
			                $im = imagecreatefromstring($img_content);
			                if ($im !== false) {
			                    // original file
			                } else {
			                	$message = 'File seems to be corrupted !';			                    
			                }

			                // CHECK IF IMAGE CONTENTS HAVING MALICIOUS CHARACTERS OR NOT
			                $img_content = file_get_contents($file_local_path);
			                $cleaned_img_content = $this->fileClean($img_content);

			                if ($cleaned_img_content=='invalid') {

			                   $message = 'File seems to be corrupted !';			                    
			                }

			            } else {

			                $message = 'Sorry....modified JPG file';
			            }

			        } else {

			            $message = 'Not getting file path';

			        }

			    } elseif ($file_type == "image/jpg") {

			        if ($f = fopen($file_local_path, 'rb')) {

			            $header = fread($f, 3);
			            fclose($f);

			            // Signature = JPEG
			            if (strncmp($header, "\xFF\xD8\xFF", 3)==0 && strlen ($header)==3) {

			                // CHECK FOR CORRUPTED (MODIFIED) FILE
			                $img_content = file_get_contents($file_local_path);
			                $im = imagecreatefromstring($img_content);
			                if ($im !== false) {
			                    // original file
			                } else {

			                    $message = 'File seems to be corrupted !';
			                }

			                // CHECK IF IMAGE CONTENTS HAVING MALICIOUS CHARACTERS OR NOT
			                $img_content = file_get_contents($file_local_path);
			                $cleaned_img_content = $this->fileClean($img_content);

			                if ($cleaned_img_content=='invalid') {

			                    $message =  'File seems to be corrupted !';
			                }

			            } else {

			                $message = 'Sorry....modified JPG file';
			            }

			        } else {

			            $message = 'Not getting file path';
			            return false;

			        }

			    } elseif($file_type == "application/xml" || $file_type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") { // excel file

			        if ($f = fopen($file_local_path, 'rb')) {

			            $header = fread($f, 4);
			            fclose($f);

			            // Signature = Excel
			            if ((strncmp($header, "\xD0\xCF\x11\xE0", 4)==0 || strncmp($header, "\x50\x4B\x03\x04", 4)==0) && strlen ($header)==4) {

			                // CHECK IF EXCEL CONTENT HAVING MALICIOUS CHARACTERS OR NOT
			                $excel_content = file_get_contents($file_local_path);

			                $cleaned_excel_content = $this->fileClean($excel_content);

			                if ($cleaned_excel_content=='invalid') {

			                	$message = 'File seems to be corrupted !';	
			                }

			            } else {

			                $message = 'Sorry....modified Excel file';
			            }

			        } else {

			           	$message = 'Not getting file path';
			        }

				} elseif ($file_type == "application/octet-stream" || $file_type == "application/vnd.google-earth.kml+xml" || $file_type == "application/xml") { // For KMZ files

			        if ($f = fopen($file_local_path, 'rb')) {

			            $header = fread($f, 4);
			            fclose($f);

			            // Signature = KMZ
						// 50 50 03 04
						// 50 4B 05 06 (empty archive)
						// 50 4B 07 08 (spanned archive)
			            if (((strncmp($header, "\x50\x50\x03\x04", 4)==0 || strncmp($header, "\x50\x4B\x05\x06", 4)==0 || strncmp($header, "\x50\x4B\x07\x08", 4)==0) && strlen ($header)==4) || $extension_name == 'kml') {

			                // CHECK IF KMZ CONTENT HAVING MALICIOUS CHARACTERS OR NOT
			                $kmz_content = file_get_contents($file_local_path);

			                $cleaned_kmz_content = $this->fileClean($kmz_content);

			                if ($cleaned_kmz_content=='invalid') {

			                	$message = 'File seems to be corrupted !';	
			                }

			            } else {

			                $message = 'Sorry....modified KMZ file';
			            }

			        } else {

			           	$message = 'Not getting file path';
			        }

				}

			   
			    // File Uploading code start
                    
				$fileNameFiltered = preg_replace('!\s+!', '_', $file_name); // replace spaces with "_" to handle "tcpdf file link not found" issue - Aniket [14-11-2022][c]
			    $filecodedName = time().uniqid().$fileNameFiltered;
                // print_r($_SERVER["DOCUMENT_ROOT"]);die;

			    if($ticket_attachment == true){
                         
                          $uploadPath = $_SERVER["DOCUMENT_ROOT"].'/webroot/writereaddata/IBM/files/supporting_documents/';

                 }else{
                 	      // print_r("santosh");die;
			              $uploadPath = $_SERVER["DOCUMENT_ROOT"].'/webroot/writereaddata/IBM/files/';
			      }
			    $uploadFile = $uploadPath.$filecodedName;			    
                
                // print_r($uploadFile);die;

			    if (move_uploaded_file($file_local_path,$uploadFile)) {
			    	
			    	if($ticket_attachment == true){
                       
                       
                      $uploadData = '/writereaddata/IBM/files/supporting_documents/'.$filecodedName; 

			    	}else{
			        
			           
			          $uploadData = '/writereaddata/IBM/files/'.$filecodedName;

			         }

			    } else {

			         $message = 'File not uploaded please select proper file';
			    }

			}

			if (!empty($uploadData)) {

			    return array('success',$uploadData);

			}else{

				return array('error',$message);
			}

		}


		//below function is for checking the uploadded files have malicious chracter or not! added on 29-04-2021 by Akash
		public function fileClean($str){

			$BlacklistCharacters = TableRegistry::getTableLocator()->get('BlacklistChar');
			// $blacklists = array of blacklist characters from database
			$blacklists = $BlacklistCharacters->find('all');

			$malicious_found = '0';
			foreach($blacklists as $b_list){
				// Change by Pravin Bhakare 13-10-2020
				$charac = $b_list['charac'];
				$posValue = strpos($str,$charac);
				if(!empty($posValue)){
					$malicious_found = 1;
					break;
				}

			}

			if($malicious_found > 0)
			{
				return 'invalid';
			}

			return $str;

		}

		//Function check the valid date format and valid date value
		public function dateFormatCheck($date)
		{
			if(!empty($date))
			{
				$input_date = explode('/',$date);
				$removeTime	= explode(' ',$input_date[2]);
				$year = $removeTime[0];

				if(count($input_date) == 3){

					$zero_int_value = array('01','02','03','04','05','06','07','08','09');

					if(in_array($input_date[0],$zero_int_value, true))
					{
						$day_value = str_replace('0','',$input_date[0]);

					}else{

						$day_value = $input_date[0];
					}
					$day_value = $this->integerInputCheck($day_value);

					if(in_array($input_date[1],$zero_int_value, true))
					{
						$month_value = str_replace('0','',$input_date[1]);

					}else{

						$month_value = $input_date[1];
					}
					$month_value = $this->integerInputCheck($month_value);

					if(in_array($year,$zero_int_value, true))
					{
						$year_value = str_replace('0','',$$year);

					}else{

						$year_value = $year;
					}
					$year_value = $this->integerInputCheck($year_value);

					$valid = checkdate(trim($month_value), trim($day_value), trim((int)$year_value));



					if($valid == 1){

						return $this->changeDateFormat($date);

					}else{

						echo"Sorry.. Something wrong happened. ";?><a href="<?php echo $this->getController()->getRequest()->getAttribute('webroot');?>"> Please Login again</a><?php
						exit;

						//$this->Session->destroy();

					}

				}else
				{
					echo"Sorry.. Something wrong happened. ";?><a href="<?php echo $this->getController()->getRequest()->getAttribute('webroot');?>"> Please Login again</a><?php
					exit;

					//$this->Session->destroy();
				}

			}else{

				return $this->changeDateFormat($date);
			}
		}

		//Only no. input server side validation
		public function integerInputCheck($post_input_request){

				$min = 1;

				if (!filter_var($post_input_request, FILTER_VALIDATE_INT, array("options" => array("min_range"=>$min))) === false) {

						return $post_input_request;

					} else {

						echo "<script>alert('One of the given input should be in no. only')</script>";
						return false;
					}


		}
		// GET DATE FORMAT AS IN "Y-m-d"
		// by Aniket Ganvir dated 29th JAN 2021
		public function changeDateFormat($date) {

			if (!empty($date)) {

				$result	= explode(' ',trim($date));

				if (count($result) == 2) {

					$date1 = $result[0];
					$time = $result[1];
					$date = date_create_from_format("d/m/Y" , trim($date1))->format("Y-m-d").' '.$time;//added ' ' on 01-10-2021 by Amol

				} else {

					$date1 = $result[0];
					$date = date_create_from_format("d/m/Y" , trim($date1))->format("Y-m-d");
				}

			} else {
				$date;
			}

			return $date;
		}
		//radio button server side validation
		public function radioButtonInputCheck($post_input_request){

			if ($post_input_request == 'yes' ||
				$post_input_request == 'no' ||
				$post_input_request == 'page' ||
				$post_input_request == 'external' ||
				$post_input_request == 'top' ||
				$post_input_request == 'side' ||
				$post_input_request == 'bottom' ||
				$post_input_request == 'DMI' ||
				$post_input_request == 'LMIS' ||
				$post_input_request == 'BOTH' ||
				$post_input_request == 'n/a' ||

				// LMIS user roles option (Done By pravin 22/11/2017)
				$post_input_request == 'RO' ||
				$post_input_request == 'SO' ||
				$post_input_request == 'RAL' ||
				$post_input_request == 'CAL' ||
				$post_input_request == 'HO' ||
				// add by pravin 28-07-2021
				$post_input_request == 'male' ||
				$post_input_request == 'female'
			) {
					return $post_input_request;

			} else {
				echo "<script>alert('one of YES/NO button input is not proper')</script>";
				return false;
			}
		}
		//dropdown select server side validation
		public function dropdownSelectInputCheck($table,$post_input_request){

			$table = TableRegistry::getTableLocator()->get($table);
			$db_table_id_list = $table->find('list',array('valueField'=>'id'))->toArray();
			$min_id_from_list = min($db_table_id_list);
			$max_id_from_list = max($db_table_id_list);

			if (filter_var($post_input_request, FILTER_VALIDATE_INT, array("options" => array("min_range"=>$min_id_from_list, "max_range"=>$max_id_from_list))) === false) {

				//commented below code and created the variable for passing message to the view , replcaing the script alerts
					//echo "<script>alert('One of selected drop down value is not proper')</script>";
					$this->Controller->set('returnFalseMessage',$this->returnFalseMessage);
					//$this->Session->destroy();
					//exit();
			} else {
					return $post_input_request;
			}
		}
		//get region name of mms user date: 07/02/2022 by Shalini D
		public function getUserRegion()
		{
			$mms_user_id = $this->Session->read('mms_user_id');
			$region_id = $this->MmsUser->find('list', array('valueField'=>'region_id','conditions'=>array('id'=>$mms_user_id)))->first();
			
			$region_name = $this->DirRegion->find('list', array('valueField'=>'region_name','conditions'=>array('id'=>$region_id)))->first();

			return $region_name;
		}
		//get all districts againt region date: 07/02/2022 by Shalini D
		public function getRegionDistrict($region_name)
		{
			$allDistricts = $this->DirDistrict->find('all', array('conditions'=>array('region_name LIKE '=>$region_name)))->order('district_name')->toArray();
			$district_list = array();
			if(!empty($allDistricts)){
				foreach($allDistricts as $dist) 
	            {   
	                $dis_id = $dist['state_code'].'-'.$dist['district_code'];
	                $district_list[$dis_id] = $dist['district_name'];  
	            }
			}
            return $district_list;

		}

		// Get PDF file path
		public function pdfFilePath(){

			$userType = $this->Session->read('loginusertype');
			$applicantid = $this->Session->read('applicantid');
			$returnDate = $this->Session->read('returnDate');
			$returnType = $this->Session->read('returnType');
			$pdfFileName = $this->Session->read('pdf_file_name');
			
			$dirname = date("d-m-Y", strtotime($returnDate));

			$filename = $_SERVER["DOCUMENT_ROOT"];
			$filename .= '/webroot/writereaddata/returns/';
			$filename .=  strtolower($returnType).'/';
			$filename .=  strtolower($userType).'/';		
			$filename .=  $dirname;

			if (!file_exists($filename)) {
				mkdir($filename, 0777);			
			}
			$file_path = $filename.'/'.$pdfFileName;

			return $file_path;
		}

	}
	
?>