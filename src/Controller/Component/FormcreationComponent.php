<?php	

	//To access the properties of main controller used initialize function.

	namespace app\Controller\Component;
	use Cake\Controller\Controller;
	use Cake\Controller\Component;
	
	use Cake\Controller\ComponentRegistry;
	use Cake\ORM\Table;
	use Cake\ORM\TableRegistry;
	use Cake\Datasource\EntityInterface;
	use Cake\Utility\Security;
	use SimpleXMLElement;
	
	class FormcreationComponent extends Component {
	
		public $components= array('Session','Customfunctions','Language');
		public $controller = null;
		public $session = null;

		public function initialize(array $config): void {
			parent::initialize($config);
			$this->Controller = $this->_registry->getController();
			$this->Session = $this->getController()->getRequest()->getSession();
		}
		

		/**
		 * GENERATING MULTIDIMENSIONAL ARRAYS FOR RENDER FORM COMPONENTS ALONG WITH VALUES
		 * @addedon: 03rd MAR 2021 (by Aniket Ganvir)
		 */
		/***
		 * To change label header of grade according to form type passing one extra var mc_form_type in 
		 * getFormInputlabel() Added by Shweta A. 27-01-2022
		*/
		public function formTableArr($formId, $lang, $rowArr = null, $subMin = null, $isMagnetite = null){
			$mc_form_type = $this->getController()->getRequest()->getSession()->read('mc_form_type'); 
			$label = $this->Language->getFormInputLabels($formId, $lang,$mc_form_type);
			$mc_form_main = $this->getController()->getRequest()->getSession()->read('mc_form_main');
			$return_type = $this->getController()->getRequest()->getSession()->read('returnType');
			
			
			$tableD = array();

			// Part II: Sales/Dispatches
			if(in_array($formId,['sale_despatch'])){

				$tableD['label'] = array(
					'0' => array(
						'0' => array(
							'col' 		=> $label[2],
							'colspan' 	=> '1',
							'rowspan' 	=> '2'
						),
						'1' => array(
							'col' 		=> $label[0],
							'colspan' 	=> '5',
							'rowspan' 	=> '1'
						),
						'2' => array(
							'col' 		=> $label[1],
							'colspan' 	=> '3',
							'rowspan' 	=> '1'
						),
						'3' => array(
							'col' 		=> $label[15],
							'colspan' 	=> '1',
							'rowspan' 	=> '2'
						),
						'4' => array(
							'col' 		=> $label[16],
							'colspan' 	=> '1',
							'rowspan' 	=> '2'
						),
						'5' => array(
							'col' 		=> $label[17],
							'colspan' 	=> '1',
							'rowspan' 	=> '2'
						),
						'6' => array(
							'col' 		=> $label[18],
							'colspan' 	=> '1',
							'rowspan' 	=> '2'
						),
						'7' => array(
							'col' 		=> $label[19],
							'colspan' 	=> '1',
							'rowspan' 	=> '2'
						),'8' => array(
							'col' 		=> $label[20],
							'colspan' 	=> '1',
							'rowspan' 	=> '2'
						),
						'9' => array(
							'col' 		=> $label[21],
							'colspan' 	=> '1',
							'rowspan' 	=> '2'
						),
						'10' => array(
							'col' 		=> $label[22],
							'colspan' 	=> '1',
							'rowspan' 	=> '2',
							
						),




					),
					'1' => array(
						'0' => array(
							'col' 		=> $label[3],
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						),
						'1' => array(
							'col' 		=> $label[4],
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						),
						'2' => array(
							'col' 		=> $label[5],
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						),
						'3' => array(
							'col' 		=> $label[6],
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						),
						'4' => array(
							'col' 		=> $label[7],
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						),
						'5' => array(
							'col' 		=> $label[8],
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						),
						'6' => array(
							'col' 		=> $label[9],
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						),
						'7' => array(
							'col' 		=> $label[10],
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						)
						
					)
				);
				
				$tableD['input'] = [];

				// grade code options
				$grade_code_option = array();
				$mCat = '';
				$mCatRow = array();
				$mCatRow[$mCat] = '';
				foreach($rowArr[1] as $key=>$val){

					// As per new amendment, grade codes (200, 208, 216) are only visible for magnetite
					// Added on 07-05-2022 by Aniket Ganvir
					// $showGrade = (in_array($key, array(200, 208, 216))) ? (($subMin == 'magnetite') ? true : false ) : true;
					$showGrade = (in_array($key, array(200, 208, 216))) ? (($isMagnetite == true) ? true : false ) : true;
					
					if($showGrade == true){
					
						// the below structure created for displaying "optgroup" in dropdown
						$mCatCount = substr_count($val, ",");
						if ($mCatCount > 0) {
							$mCatCurrent = substr($val, strpos($val, ",") + 1);
							if ($mCat != $mCatCurrent) {
								$mCat = $mCatCurrent;
								$mCatRow[$mCat] = 1;
							} else {
								$mCat = $mCatCurrent;
								$mCatRow[$mCat] = $mCatRow[$mCat] + 1;
							}
							$val = strtok($val, ",");
						}

					
						$grade_code_option[] = array(
							'vall' => $key,
							'label' => $val,
							'mcat' => $mCat,
							'mcatsrno' => $mCatRow[$mCat]
						);
					}
				}

				foreach($grade_code_option as $gKey=>$val){
					$mcat_grade = $val['mcat'];
					$grade_code_option[$gKey]['mcatrow'] = $mCatRow[$mcat_grade];
				}

				$g_code_option = $grade_code_option;
				$g_code_option[] = array(
					'vall' => 'NIL',
					'label' => 'NIL'
				);

				// client type options
				$client_type_option = array();
				
				foreach($rowArr[2] as $cType){

					$client_type_option[] = array(
						'vall' => $cType['client_type'],
						'label' => $cType['client_type']
					);
				}
				$c_type_option = $client_type_option;
				$c_type_option[] = array(
					'vall' => 'NIL',
					'label' => 'NIL'
				);

				// country list options
				$country_list_option = array();
				
				$country_list_option[] = array(
					'vall' => '',
					'label' => '--Select--'
				);

				foreach($rowArr[3] as $cList){

					$country_list_option[] = array(
						'vall' => $cList['id'],
						'label' => ucwords($cList['country_name'])
					);
				}

				$loopC = "0";
				$row_old_main = (isset($rowArr[4])) ? $rowArr[4] : array();
				foreach($rowArr[0] as $row){

					$grade_code = $row['grade_code'];
					$client_type = $row['client_type'];
					$client_reg_no = $row['client_reg_no'];
					$expo_country = $row['expo_country'];

					// Highlight fields which are differs from cumulative monthly data in annual
					// (Only for Form G1 in MMS side)
					// Effective from Phase-II
					// Added on 06th Nov 2021 by Aniket Ganvir
					if (isset($rowArr[4])) {

						$keys['grade_code'] = array_keys(array_column($rowArr[4], 'grade_code'), $grade_code);
						$keys['client_type'] = array_keys(array_column($rowArr[4], 'client_type'), $client_type);
						$keys['client_reg_no'] = array_keys(array_column($rowArr[4], 'client_reg_no'), $client_reg_no);
						$keys['expo_country'] = array_keys(array_column($rowArr[4], 'expo_country'), $expo_country);
						$keys_all[] = $keys['grade_code'];
						$keys_all[] = $keys['client_type'];
						$keys_all[] = $keys['client_reg_no'];
						$keys_all[] = $keys['expo_country'];
						$inter = array_intersect(...$keys_all);
						
						if (count($inter) == 1) {
							
							$row_old = $rowArr[4][$inter[array_key_first($inter)]];

							if ($row['client_name'] != $row_old['client_name']) {
								$diff[$loopC]['client_name']['title'] = $row_old['client_name'];
								$diff[$loopC]['client_name']['class'] = ' in_new';
							}
							
							if ($row['quantity'] != $row_old['quantity']) {
								$diff[$loopC]['quantity']['title'] = $row['quantity'] - $row_old['quantity'];
								$diff[$loopC]['quantity']['title'] = ($diff[$loopC]['quantity']['title'] > 0) ? "+".$diff[$loopC]['quantity']['title'] : $diff[$loopC]['quantity']['title'];
								$diff[$loopC]['quantity']['class'] = ' in_new';
							}
							
							if ($row['sale_value'] != $row_old['sale_value']) {
								$diff[$loopC]['sale_value']['title'] = $row['sale_value'] - $row_old['sale_value'];
								$diff[$loopC]['sale_value']['title'] = ($diff[$loopC]['sale_value']['title'] > 0) ? "+".$diff[$loopC]['sale_value']['title'] : $diff[$loopC]['sale_value']['title'];
								$diff[$loopC]['sale_value']['class'] = ' in_new';
							}
							
							if ($row['expo_quantity'] != $row_old['expo_quantity']) {
								$diff[$loopC]['expo_quantity']['title'] = $row['expo_quantity'] - $row_old['expo_quantity'];
								$diff[$loopC]['expo_quantity']['title'] = ($diff[$loopC]['expo_quantity']['title'] > 0) ? "+".$diff[$loopC]['expo_quantity']['title'] : $diff[$loopC]['expo_quantity']['title'];
								$diff[$loopC]['expo_quantity']['class'] = ' in_new';
							}
							
							if ($row['expo_fob'] != $row_old['expo_fob']) {
								$diff[$loopC]['expo_fob']['title'] = $row['expo_fob'] - $row_old['expo_fob'];
								$diff[$loopC]['expo_fob']['title'] = ($diff[$loopC]['expo_fob']['title'] > 0) ? "+".$diff[$loopC]['expo_fob']['title'] : $diff[$loopC]['expo_fob']['title'];
								$diff[$loopC]['expo_fob']['class'] = ' in_new';
							}

							$key = (int)$inter[array_key_first($inter)];
							unset($row_old_main[$key]);

						} else {
							$diff[$loopC]['grade_code']['class'] = ' in_new';
							$diff[$loopC]['grade_code']['title'] = 'New record';
							$diff[$loopC]['client_type']['class'] = ' in_new';
							$diff[$loopC]['client_type']['title'] = 'New record';
							$diff[$loopC]['client_name']['class'] = ' in_new';
							$diff[$loopC]['client_name']['title'] = 'New record';
							$diff[$loopC]['client_reg_no']['class'] = ' in_new';
							$diff[$loopC]['client_reg_no']['title'] = 'New record';
							$diff[$loopC]['quantity']['class'] = ' in_new';
							$diff[$loopC]['quantity']['title'] = 'New record';
							$diff[$loopC]['sale_value']['class'] = ' in_new';
							$diff[$loopC]['sale_value']['title'] = 'New record';
							$diff[$loopC]['expo_country']['class'] = ' in_new';
							$diff[$loopC]['expo_country']['title'] = 'New record';
							$diff[$loopC]['expo_quantity']['class'] = ' in_new';
							$diff[$loopC]['expo_quantity']['title'] = 'New record';
							$diff[$loopC]['expo_fob']['class'] = ' in_new';
							$diff[$loopC]['expo_fob']['title'] = 'New record';
							$diff[$loopC]['trans_cost']['class'] = ' in_new';
							$diff[$loopC]['trans_cost']['title'] = 'New record';
							$diff[$loopC]['loading_charges']['class'] = ' in_new';
							$diff[$loopC]['loading_charges']['title'] = 'New record';
							$diff[$loopC]['railway_freight']['class'] = ' in_new';
							$diff[$loopC]['railway_freight']['title'] = 'New record';
							$diff[$loopC]['port_handling']['class'] = ' in_new';
							$diff[$loopC]['port_handling']['title'] = 'New record';
							$diff[$loopC]['sampling_cost']['class'] = ' in_new';
							$diff[$loopC]['sampling_cost']['title'] = 'New record';
							$diff[$loopC]['plot_rent']['class'] = ' in_new';
							$diff[$loopC]['plot_rent']['title'] = 'New record';
							$diff[$loopC]['other_cost']['class'] = ' in_new';
							$diff[$loopC]['other_cost']['title'] = 'New record';
							$diff[$loopC]['total_prod']['class'] = ' in_new';
							$diff[$loopC]['total_prod']['title'] = 'New record';
						}

						unset($inter);
						unset($keys_all);

					}

					$tableD['input'][$loopC] = array(
						'0' => array(
							'name'		=> 'grade_code',
							'type'		=> 'select',
							'valid'		=> 'notEmpty',
							'length'	=> null,
							'option'	=> ($loopC==0) ? $g_code_option : $grade_code_option,
							'selected'	=> ($row['grade_code'] == 0) ? 'NIL' : $row['grade_code'],
							'class'		=> "cvOn cvReq sale_despatch_grade s_des_input input_sm text-fields g_code",
							'diff'		=> (isset($diff[$loopC]['grade_code']['class'])) ? $diff[$loopC]['grade_code']['class'] : '',
							'title'		=> (isset($diff[$loopC]['grade_code']['title'])) ? $diff[$loopC]['grade_code']['title'] : ''
						),
						'1' => array(
							'name'		=> 'client_type',
							'type'		=> 'select',
							'valid'		=> 'notEmpty',
							'length'	=> null,
							'option'	=> ($row['client_type'] == 'NIL') ? $c_type_option : $client_type_option,
							'selected'	=> ($row['client_type'] == 'NIL') ? 'NIL' : $row['client_type'],
							'class'		=> "cvOn cvReq s_des_input client_type input_sm text-fields c_type",
							'diff'		=> (isset($diff[$loopC]['client_type']['class'])) ? $diff[$loopC]['client_type']['class'] : '',
							'title'		=> (isset($diff[$loopC]['client_type']['title'])) ? $diff[$loopC]['client_type']['title'] : ''
						),
						'2' => array(
							'name'		=> 'client_reg_no',
							'type'		=> 'text',
							'valid'		=> 'text',
							'length'	=> '250',
							'value'		=> $row['client_reg_no'],
							'class'		=> "nameOne ui-autocomplete-input auto-comp s_des_input input_sm text-fields right reg_no ui-autocomplete-input",
							'diff'		=> (isset($diff[$loopC]['client_reg_no']['class'])) ? $diff[$loopC]['client_reg_no']['class'] : '',
							'title'		=> (isset($diff[$loopC]['client_reg_no']['title'])) ? $diff[$loopC]['client_reg_no']['title'] : ''
						),
						'3' => array(
							'name'		=> 'client_name',
							'type'		=> 'text',
							'valid'		=> 'text',
							'length'	=> '250',
							'value'		=> $row['client_name'],
							'class'		=> "nameTwo s_des_input input_sm text-fields reg_name ui-autocomplete-input",
							'diff'		=> (isset($diff[$loopC]['client_name']['class'])) ? $diff[$loopC]['client_name']['class'] : '',
							'title'		=> (isset($diff[$loopC]['client_name']['title'])) ? $diff[$loopC]['client_name']['title'] : '',
							'readonly'	=> ($row['client_name_status'] == 1) ? true : false
						),
						'4' => array(
							'name'		=> 'quantity',
							'type'		=> 'text',
							'valid'		=> 'text',
							'length'	=> '250',
							'value'		=> $row['quantity'],
							'class'		=> "cvOn cvNum cvReq s_des_input input_sm text-fields right f_quant",
							'diff'		=> (isset($diff[$loopC]['quantity']['class'])) ? $diff[$loopC]['quantity']['class'] : '',
							'title'		=> (isset($diff[$loopC]['quantity']['title'])) ? $diff[$loopC]['quantity']['title'] : ''
						),
						'5' => array(
							'name'		=> 'sale_value',
							'type'		=> 'text',
							'valid'		=> 'text',
							'length'	=> '250',
							'value'		=> $row['sale_value'],
							'class'		=> "cvOn cvNum cvReq s_des_input input_sm text-fields right s_value",
							'diff'		=> (isset($diff[$loopC]['sale_value']['class'])) ? $diff[$loopC]['sale_value']['class'] : '',
							'title'		=> (isset($diff[$loopC]['sale_value']['title'])) ? $diff[$loopC]['sale_value']['title'] : ''
						),
						'6' => array(
							'name'		=> 'expo_country',
							'type'		=> 'select',
							'valid'		=> 'notEmpty',
							'length'	=> null,
							'option'	=> $country_list_option,
							'selected'	=> $row['expo_country'],
							'class'		=> "cvOn cvReq s_des_input input_sm text-fields country",
							'diff'		=> (isset($diff[$loopC]['expo_country']['class'])) ? $diff[$loopC]['expo_country']['class'] : '',
							'title'		=> (isset($diff[$loopC]['expo_country']['title'])) ? $diff[$loopC]['expo_country']['title'] : ''
						),
						'7' => array(
							'name'		=> 'expo_quantity',
							'type'		=> 'text',
							'valid'		=> 'text',
							'length'	=> '250',
							'value'		=> $row['expo_quantity'],
							'class'		=> "cvOn cvNum cvReq s_des_input input_sm text-fields-with-numbers right e_quant",
							'diff'		=> (isset($diff[$loopC]['expo_quantity']['class'])) ? $diff[$loopC]['expo_quantity']['class'] : '',
							'title'		=> (isset($diff[$loopC]['expo_quantity']['title'])) ? $diff[$loopC]['expo_quantity']['title'] : ''
						),
						'8' => array(
							'name'		=> 'expo_fob',
							'type'		=> 'text',
							'valid'		=> 'text',
							'length'	=> '250',
							'value'		=> $row['expo_fob'],
							'class'		=> "cvOn cvNum cvReq s_des_input input_sm text-fields-with-numbers right fob",
							'diff'		=> (isset($diff[$loopC]['expo_fob']['class'])) ? $diff[$loopC]['expo_fob']['class'] : '',
							'title'		=> (isset($diff[$loopC]['expo_fob']['title'])) ? $diff[$loopC]['expo_fob']['title'] : ''
						),

						// added input field 07-07-2023
						'9' => array(
							'name'		=> 'trans_cost',
							'type'		=> 'text',
							'valid'		=> 'text',
							'length'	=> '250',
							'id'	    => 'trans_cost',
							'value'		=> $row['trans_cost'],
							'class'		=> "cvOn cvNum cvReq s_des_input input_sm text-fields-with-numbers right numeric-input",
							'diff'		=> (isset($diff[$loopC]['trans_cost']['class'])) ? $diff[$loopC]['trans_cost']['class'] : '',
							'title'		=> (isset($diff[$loopC]['trans_cost']['title'])) ? $diff[$loopC]['trans_cost']['title'] : ''
						),
						'10' => array(
							'name'		=> 'loading_charges',
							'type'		=> 'text',
							'valid'		=> 'text',
							'length'	=> '250',
							'value'		=> $row['loading_charges'],
							'id'	    => 'loading_charges',
							'class'		=> "cvOn cvNum cvReq s_des_input input_sm text-fields-with-numbers right numeric-input",
							'diff'		=> (isset($diff[$loopC]['loading_charges']['class'])) ? $diff[$loopC]['loading_charges']['class'] : '',
							'title'		=> (isset($diff[$loopC]['loading_charges']['title'])) ? $diff[$loopC]['loading_charges']['title'] : ''
						),
						'11' => array(
							'name'		=> 'railway_freight',
							'type'		=> 'text',
							'valid'		=> 'text',
							'length'	=> '250',
							'id'	    => 'railway_freight',
							'value'		=> $row['railway_freight'],
							'class'		=> "cvOn cvNum cvReq s_des_input input_sm text-fields-with-numbers right numeric-input",
							'diff'		=> (isset($diff[$loopC]['railway_freight']['class'])) ? $diff[$loopC]['railway_freight']['class'] : '',
							'title'		=> (isset($diff[$loopC]['railway_freight']['title'])) ? $diff[$loopC]['railway_freight']['title'] : ''
						),
						'12' => array(
							'name'		=> 'port_handling',
							'type'		=> 'text',
							'valid'		=> 'text',
							'length'	=> '250',
							'id'	    => 'sampling_cost',
							'value'		=> $row['port_handling'],
							'class'		=> "cvOn cvNum cvReq s_des_input input_sm text-fields-with-numbers right numeric-input",
							'diff'		=> (isset($diff[$loopC]['port_handling']['class'])) ? $diff[$loopC]['port_handling']['class'] : '',
							'title'		=> (isset($diff[$loopC]['port_handling']['title'])) ? $diff[$loopC]['port_handling']['title'] : ''
						),
						'13' => array(
							'name'		=> 'sampling_cost',
							'type'		=> 'text',
							'valid'		=> 'text',
							'length'	=> '250',
							'id'	    => 'sampling_cost',
							'value'		=> $row['sampling_cost'],
							'class'		=> "cvOn cvNum cvReq s_des_input input_sm text-fields-with-numbers right numeric-input",
							'diff'		=> (isset($diff[$loopC]['sampling_cost']['class'])) ? $diff[$loopC]['sampling_cost']['class'] : '',
							'title'		=> (isset($diff[$loopC]['sampling_cost']['title'])) ? $diff[$loopC]['sampling_cost']['title'] : ''
						),
						'14' => array(
							'name'		=> 'plot_rent',
							'type'		=> 'text',
							'valid'		=> 'text',
							'length'	=> '250',
							'id'	    => 'plot_rent',
							'value'		=> $row['plot_rent'],
							'class'		=> "cvOn cvNum cvReq s_des_input input_sm text-fields-with-numbers right numeric-input",
							'diff'		=> (isset($diff[$loopC]['plot_rent']['class'])) ? $diff[$loopC]['plot_rent']['class'] : '',
							'title'		=> (isset($diff[$loopC]['plot_rent']['title'])) ? $diff[$loopC]['plot_rent']['title'] : ''
						),
						'15' => array(
							'name'		=> 'other_cost',
							'type'		=> 'text',
							'valid'		=> 'text',
							'length'	=> '250',
							'id'	    => 'other_cost',
							'value'		=> $row['other_cost'],
							'class'		=> "cvOn cvNum cvReq s_des_input input_sm text-fields-with-numbers right numeric-input",
							'diff'		=> (isset($diff[$loopC]['other_cost']['class'])) ? $diff[$loopC]['other_cost']['class'] : '',
							'title'		=> (isset($diff[$loopC]['other_cost']['title'])) ? $diff[$loopC]['other_cost']['title'] : ''
						),
						'16' => array(
							'name'		=> 'total_prod',
							'type'		=> 'text',
							'valid'		=> 'text',
							'length'	=> '300',
							'id'	    => 'total_prod',
							'value'		=> $row['total_prod'],
							'class'		=> "cvOn cvNum cvReq s_des_input input_sm text-fields-with-numbers right ",
							'diff'		=> (isset($diff[$loopC]['total_prod']['class'])) ? $diff[$loopC]['total_prod']['class'] : '',
							'title'		=> (isset($diff[$loopC]['total_prod']['title'])) ? $diff[$loopC]['total_prod']['title'] : ''
						),
						
					);

					$loopC++;
				}

				// This extra loop is only for showing deleted records in the annual return
				// as compares to monthly return
				// Effective from Phase-II
				// Added on 08th Nov 2021 by Aniket Ganvir
				if ($return_type == 'ANNUAL') {
					if (count($row_old_main) > 0) {

						foreach($row_old_main as $row){

							$tableD['input'][$loopC] = array(
								'0' => array(
									'name'		=> 'grade_code',
									'type'		=> 'select',
									'valid'		=> 'notEmpty',
									'length'	=> null,
									'option'	=> ($loopC==0) ? $g_code_option : $grade_code_option,
									'selected'	=> ($row['grade_code'] == 0) ? 'NIL' : $row['grade_code'],
									'class'		=> "cvOn cvReq sale_despatch_grade s_des_input input_sm",
									'diff'		=> " in_old",
									'title'		=> 'Removed record'
								),
								'1' => array(
									'name'		=> 'client_type',
									'type'		=> 'select',
									'valid'		=> 'notEmpty',
									'length'	=> null,
									'option'	=> ($row['client_type'] == 'NIL') ? $c_type_option : $client_type_option,
									'selected'	=> ($row['client_type'] == 'NIL') ? 'NIL' : $row['client_type'],
									'class'		=> "cvOn cvReq s_des_input client_type input_sm",
									'diff'		=> " in_old",
									'title'		=> 'Removed record'
								),
								'2' => array(
									'name'		=> 'client_reg_no',
									'type'		=> 'text',
									'valid'		=> 'text',
									'length'	=> '250',
									'value'		=> $row['client_reg_no'],
									'class'		=> "nameOne ui-autocomplete-input auto-comp s_des_input input_sm",
									'diff'		=> " in_old",
									'title'		=> 'Removed record'
								),
								'3' => array(
									'name'		=> 'client_name',
									'type'		=> 'text',
									'valid'		=> 'text',
									'length'	=> '250',
									'value'		=> $row['client_name'],
									'class'		=> "nameTwo s_des_input input_sm",
									'diff'		=> " in_old",
									'title'		=> 'Removed record'
								),
								'4' => array(
									'name'		=> 'quantity',
									'type'		=> 'text',
									'valid'		=> 'text',
									'length'	=> '250',
									'value'		=> $row['quantity'],
									'class'		=> "cvOn cvNum cvReq s_des_input input_sm",
									'diff'		=> " in_old",
									'title'		=> 'Removed record'
								),
								'5' => array(
									'name'		=> 'sale_value',
									'type'		=> 'text',
									'valid'		=> 'text',
									'length'	=> '250',
									'value'		=> $row['sale_value'],
									'class'		=> "cvOn cvNum cvReq s_des_input input_sm",
									'diff'		=> " in_old",
									'title'		=> 'Removed record'
								),
								'6' => array(
									'name'		=> 'expo_country',
									'type'		=> 'select',
									'valid'		=> 'notEmpty',
									'length'	=> null,
									'option'	=> $country_list_option,
									'selected'	=> $row['expo_country'],
									'class'		=> "cvOn cvReq s_des_input input_sm",
									'diff'		=> " in_old",
									'title'		=> 'Removed record'
								),
								'7' => array(
									'name'		=> 'expo_quantity',
									'type'		=> 'text',
									'valid'		=> 'text',
									'length'	=> '250',
									'value'		=> $row['expo_quantity'],
									'class'		=> "cvOn cvNum cvReq s_des_input input_sm",
									'diff'		=> " in_old",
									'title'		=> 'Removed record'
								),
								'8' => array(
									'name'		=> 'expo_fob',
									'type'		=> 'text',
									'valid'		=> 'text',
									'length'	=> '250',
									'value'		=> $row['expo_fob'],
									'class'		=> "cvOn cvNum cvReq s_des_input input_sm",
									'diff'		=> " in_old",
									'title'		=> 'Removed record'
								)
							);
		
							$loopC++;
						}

					}
				}

			}

			// Part II: pulverisation
			if(in_array($formId,['pulverisation'])){

				$tableD['label'] = array(
					'0' => array(
						'0' => array(
							'col' 		=> $label[4],
							'colspan' 	=> '1',
							'rowspan' 	=> '2'
						),
						'1' => array(
							'col' 		=> $label[5],
							'colspan' 	=> '1',
							'rowspan' 	=> '2'
						),
						'2' => array(
							'col' 		=> $label[6],
							'colspan' 	=> '2',
							'rowspan' 	=> '1'
						),
						'3' => array(
							'col' 		=> $label[7],
							'colspan' 	=> '3',
							'rowspan' 	=> '1'
						)
					),
					'1' => array(
						'0' => array(
							'col' 		=> $label[8],
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						),
						'1' => array(
							'col' 		=> $label[9],
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						),
						'2' => array(
							'col' 		=> $label[10],
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						),
						'3' => array(
							'col' 		=> $label[11],
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						),
						'4' => array(
							'col' 		=> $label[12],
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						)
					)
				);

				$tableD['input'] = [];

				$f_grade_code_option = array();

				foreach($rowArr[1] as $key=>$val){

					$f_grade_code_option[] = array(
						'vall' => $key,
						'label' => $val
					);
				}

				$loopC = "0";
				$row_old_main = (isset($rowArr[2])) ? $rowArr[2] : array();
				foreach($rowArr[0] as $row){

					$grade_code = $row['grade_code'];
					$produced_mesh_size = $row['produced_mesh_size'];
					
					// Highlight fields which are differs from cumulative monthly data in annual
					// (Only for Form G1 in MMS side)
					// Effective from Phase-II
					// Added on 09th Nov 2021 by Aniket Ganvir
					if (isset($rowArr[2])) {

						$keys['grade_code'] = array_keys(array_column($rowArr[2], 'grade_code'), $grade_code);
						$keys['produced_mesh_size'] = array_keys(array_column($rowArr[2], 'produced_mesh_size'), $produced_mesh_size);
						$keys_all[] = $keys['grade_code'];
						$keys_all[] = $keys['produced_mesh_size'];
						$inter = array_intersect(...$keys_all);
						
						if (count($inter) == 1) {
							
							$row_old = $rowArr[2][$inter[array_key_first($inter)]];

							if ($row['mineral_tot_qty'] != $row_old['mineral_tot_qty']) {
								$diff[$loopC]['mineral_tot_qty']['title'] = $row['mineral_tot_qty'] - $row_old['mineral_tot_qty'];
								$diff[$loopC]['mineral_tot_qty']['title'] = ($diff[$loopC]['mineral_tot_qty']['title'] > 0) ? "+".$diff[$loopC]['mineral_tot_qty']['title'] : $diff[$loopC]['mineral_tot_qty']['title'];
								$diff[$loopC]['mineral_tot_qty']['class'] = ' in_new';
							}
							
							if ($row['produced_quantity'] != $row_old['produced_quantity']) {
								$diff[$loopC]['produced_quantity']['title'] = $row['produced_quantity'] - $row_old['produced_quantity'];
								$diff[$loopC]['produced_quantity']['title'] = ($diff[$loopC]['produced_quantity']['title'] > 0) ? "+".$diff[$loopC]['produced_quantity']['title'] : $diff[$loopC]['produced_quantity']['title'];
								$diff[$loopC]['produced_quantity']['class'] = ' in_new';
							}
							
							if ($row['sold_mesh_size'] != $row_old['sold_mesh_size']) {
								$diff[$loopC]['sold_mesh_size']['title'] = $row['sold_mesh_size'] - $row_old['sold_mesh_size'];
								$diff[$loopC]['sold_mesh_size']['title'] = ($diff[$loopC]['sold_mesh_size']['title'] > 0) ? "+".$diff[$loopC]['sold_mesh_size']['title'] : $diff[$loopC]['sold_mesh_size']['title'];
								$diff[$loopC]['sold_mesh_size']['class'] = ' in_new';
							}
							
							if ($row['sold_quantity'] != $row_old['sold_quantity']) {
								$diff[$loopC]['sold_quantity']['title'] = $row['sold_quantity'] - $row_old['sold_quantity'];
								$diff[$loopC]['sold_quantity']['title'] = ($diff[$loopC]['sold_quantity']['title'] > 0) ? "+".$diff[$loopC]['sold_quantity']['title'] : $diff[$loopC]['sold_quantity']['title'];
								$diff[$loopC]['sold_quantity']['class'] = ' in_new';
							}
							
							if ($row['sale_value'] != $row_old['sale_value']) {
								$diff[$loopC]['sale_value']['title'] = $row['sale_value'] - $row_old['sale_value'];
								$diff[$loopC]['sale_value']['title'] = ($diff[$loopC]['sale_value']['title'] > 0) ? "+".$diff[$loopC]['sale_value']['title'] : $diff[$loopC]['sale_value']['title'];
								$diff[$loopC]['sale_value']['class'] = ' in_new';
							}

							$key = (int)$inter[array_key_first($inter)];
							unset($row_old_main[$key]);

						} else {
							$diff[$loopC]['grade_code']['class'] = ' in_new';
							$diff[$loopC]['grade_code']['title'] = 'New record';
							$diff[$loopC]['mineral_tot_qty']['class'] = ' in_new';
							$diff[$loopC]['mineral_tot_qty']['title'] = 'New record';
							$diff[$loopC]['produced_mesh_size']['class'] = ' in_new';
							$diff[$loopC]['produced_mesh_size']['title'] = 'New record';
							$diff[$loopC]['produced_quantity']['class'] = ' in_new';
							$diff[$loopC]['produced_quantity']['title'] = 'New record';
							$diff[$loopC]['sold_mesh_size']['class'] = ' in_new';
							$diff[$loopC]['sold_mesh_size']['title'] = 'New record';
							$diff[$loopC]['sold_quantity']['class'] = ' in_new';
							$diff[$loopC]['sold_quantity']['title'] = 'New record';
							$diff[$loopC]['sale_value']['class'] = ' in_new';
							$diff[$loopC]['sale_value']['title'] = 'New record';
						}

						unset($inter);
						unset($keys_all);

					}

					$tableD['input'][$loopC] = array(
						'0' => array(
							'name'		=> 'f_grade_code',
							'type'		=> 'select',
							'valid'		=> 'notEmpty',
							'length'	=> null,
							'option'	=> $f_grade_code_option,
							'selected'	=> $row['grade_code'],
							'class'		=> 'cvOn cvReq g_code',
							'diff'		=> (isset($diff[$loopC]['grade_code']['class'])) ? $diff[$loopC]['grade_code']['class'] : '',
							'title'		=> (isset($diff[$loopC]['grade_code']['title'])) ? $diff[$loopC]['grade_code']['title'] : ''
						),
						'1' => array(
							'name'		=> 'f_mineral_tot_qty',
							'type'		=> 'text',
							'maxlength'	=> '13',
							'max'		=> '999999999.999',
							'value'		=> $row['mineral_tot_qty'],
							'class'		=> 'cvOn cvReq cvNum cvMaxLen cvMax tot_qty pulverised',
							'diff'		=> (isset($diff[$loopC]['mineral_tot_qty']['class'])) ? $diff[$loopC]['mineral_tot_qty']['class'] : '',
							'title'		=> (isset($diff[$loopC]['mineral_tot_qty']['title'])) ? $diff[$loopC]['mineral_tot_qty']['title'] : ''
						),
						'2' => array(
							'name'		=> 'f_produced_mesh_size',
							'type'		=> 'text',
							'maxlength'	=> '15',
							'value'		=> $row['produced_mesh_size'],
							'class'		=> 'cvOn cvReq cvMaxLen p_mesh_size',
							'diff'		=> (isset($diff[$loopC]['produced_mesh_size']['class'])) ? $diff[$loopC]['produced_mesh_size']['class'] : '',
							'title'		=> (isset($diff[$loopC]['produced_mesh_size']['title'])) ? $diff[$loopC]['produced_mesh_size']['title'] : ''
						),
						'3' => array(
							'name'		=> 'f_produced_quantity',
							'type'		=> 'text',
							'maxlength'	=> '13',
							'max'		=> '999999999.999',
							'value'		=> $row['produced_quantity'],
							'class'		=> 'cvOn cvReq cvNum cvMaxLen cvMax p_quant',
							'diff'		=> (isset($diff[$loopC]['produced_quantity']['class'])) ? $diff[$loopC]['produced_quantity']['class'] : '',
							'title'		=> (isset($diff[$loopC]['produced_quantity']['title'])) ? $diff[$loopC]['produced_quantity']['title'] : ''
						),
						'4' => array(
							'name'		=> 'f_sold_mesh_size',
							'type'		=> 'text',
							'maxlength'	=> '15',
							'value'		=> $row['sold_mesh_size'],
							'class'		=> 'cvOn cvReq cvMaxLen s_mesh_size',
							'diff'		=> (isset($diff[$loopC]['sold_mesh_size']['class'])) ? $diff[$loopC]['sold_mesh_size']['class'] : '',
							'title'		=> (isset($diff[$loopC]['sold_mesh_size']['title'])) ? $diff[$loopC]['sold_mesh_size']['title'] : ''
						),
						'5' => array(
							'name'		=> 'f_sold_quantity',
							'type'		=> 'text',
							'maxlength'	=> '13',
							'max'		=> '999999999.999',
							'value'		=> $row['sold_quantity'],
							'class'		=> 'cvOn cvReq cvNum cvMaxLen cvMax s_quant',
							'diff'		=> (isset($diff[$loopC]['sold_quantity']['class'])) ? $diff[$loopC]['sold_quantity']['class'] : '',
							'title'		=> (isset($diff[$loopC]['sold_quantity']['title'])) ? $diff[$loopC]['sold_quantity']['title'] : ''
						),
						'6' => array(
							'name'		=> 'f_sale_value',
							'type'		=> 'text',
							'maxlength'	=> '14',
							'max'		=> '99999999999.99',
							'value'		=> $row['sale_value'],
							'class'		=> 'cvOn cvReq cvMaxLen cvMax cvNum s_value',
							'diff'		=> (isset($diff[$loopC]['sale_value']['class'])) ? $diff[$loopC]['sale_value']['class'] : '',
							'title'		=> (isset($diff[$loopC]['sale_value']['title'])) ? $diff[$loopC]['sale_value']['title'] : ''
						)
					);
					$loopC++;

				}
				
				// This extra loop is only for showing deleted records in the annual return
				// as compares to monthly return
				// Effective from Phase-II
				// Added on 09th Nov 2021 by Aniket Ganvir
				if ($return_type == 'ANNUAL') {
					if (count($row_old_main) > 0) {

						foreach($row_old_main as $row){

							$tableD['input'][$loopC] = array(
								'0' => array(
									'name'		=> 'f_grade_code',
									'type'		=> 'select',
									'valid'		=> 'notEmpty',
									'length'	=> null,
									'option'	=> $f_grade_code_option,
									'selected'	=> $row['grade_code'],
									'class'		=> 'cvOn cvReq g_code',
									'diff'		=> " in_old",
									'title'		=> 'Removed record'
								),
								'1' => array(
									'name'		=> 'f_mineral_tot_qty',
									'type'		=> 'text',
									'maxlength'	=> '13',
									'max'		=> '999999999.999',
									'value'		=> $row['mineral_tot_qty'],
									'class'		=> 'cvOn cvReq cvNum cvMaxLen cvMax tot_qty pulverised',
									'diff'		=> " in_old",
									'title'		=> 'Removed record'
								),
								'2' => array(
									'name'		=> 'f_produced_mesh_size',
									'type'		=> 'text',
									'maxlength'	=> '15',
									'value'		=> $row['produced_mesh_size'],
									'class'		=> 'cvOn cvReq cvMaxLen p_mesh_size',
									'diff'		=> " in_old",
									'title'		=> 'Removed record'
								),
								'3' => array(
									'name'		=> 'f_produced_quantity',
									'type'		=> 'text',
									'maxlength'	=> '13',
									'max'		=> '999999999.999',
									'value'		=> $row['produced_quantity'],
									'class'		=> 'cvOn cvReq cvNum cvMaxLen cvMax p_quant',
									'diff'		=> " in_old",
									'title'		=> 'Removed record'
								),
								'4' => array(
									'name'		=> 'f_sold_mesh_size',
									'type'		=> 'text',
									'maxlength'	=> '15',
									'value'		=> $row['sold_mesh_size'],
									'class'		=> 'cvOn cvReq cvMaxLen s_mesh_size',
									'diff'		=> " in_old",
									'title'		=> 'Removed record'
								),
								'5' => array(
									'name'		=> 'f_sold_quantity',
									'type'		=> 'text',
									'maxlength'	=> '13',
									'max'		=> '999999999.999',
									'value'		=> $row['sold_quantity'],
									'class'		=> 'cvOn cvReq cvNum cvMaxLen cvMax s_quant',
									'diff'		=> " in_old",
									'title'		=> 'Removed record'
								),
								'6' => array(
									'name'		=> 'f_sale_value',
									'type'		=> 'text',
									'maxlength'	=> '14',
									'max'		=> '99999999999.99',
									'value'		=> $row['sale_value'],
									'class'		=> 'cvOn cvReq cvMaxLen cvMax cvNum s_value',
									'diff'		=> " in_old",
									'title'		=> 'Removed record'
								)
							);
		
							$loopC++;
						}

					}
				}
				
			}

			// G1: Part V: Sec 6: Type of Machinery
			if(in_array($formId,['geology_part_three'])){

				$tableD['label'] = array(
					'0' => array(
						'0' => array(
							'col' 		=> $label[1],
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						),
						'1' => array(
							'col' 		=> $label[2],
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						),
						'2' => array(
							'col' 		=> $label[3],
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						),
						'3' => array(
							'col' 		=> $label[4],
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						),
						'4' => array(
							'col' 		=> $label[5],
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						),
						'5' => array(
							'col' 		=> $label[6],
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						)
					)
				);
				
				$tableD['input'] = [];

				// machinery type options
				$machinery_type_option = array();
				foreach($rowArr[1] as $key=>$val){

					$machinery_type_option[] = array(
						'vall' => $key,
						'label' => $val
					);
				}
				$m_type_option = $machinery_type_option;
				$m_type_option[] = array(
					'vall' => 'NIL',
					'label' => 'NIL'
				);

				// electrical options
				$electric_option = array();
				foreach($label['electric_option'] as $key=>$val){

					$electric_option[] = array(
						'vall' => $key,
						'label' => $val
					);
				}

				// opencast options
				$opencast_option = array();
				foreach($label['opencast_option'] as $key=>$val){

					$opencast_option[] = array(
						'vall' => $key,
						'label' => $val
					);
				}

				$loopC = "0";
				$agg_count = $rowArr[0]['aggregation']['aggregation_count'];
				$row = $rowArr[0]['aggregation'];
				for ($i=1; $i <= $agg_count; $i++) {
					
					// GET CAPACITY UNIT
					$macSel = $row['machine_select_'.$i];
					$macSelArr = explode('-', $macSel);
					if (count($macSelArr) == 2) {
						$unit_box = $macSelArr[1];
					} else {
						$unit_box = '';
					}

					$tableD['input'][$loopC] = array(
						'0' => array(
							'name'		=> 'machine_select',
							'type'		=> 'select',
							'valid'		=> 'notEmpty',
							'length'	=> null,
							'option'	=> ($loopC==0) ? $m_type_option : $machinery_type_option,
							'selected'	=> ($row['machine_select_'.$i] == 0) ? 'NIL' : $row['machine_select_'.$i],
							'class'		=> "machine_select selectbox-small form-control-sm cvOn cvReq"
						),
						'1' => array(
							'name'		=> 'capacity_box',
							'type'		=> 'text',
							'valid'		=> 'text',
							'length'	=> null,
							'maxlength'	=> 10,
							'min'		=> 0,
							'value'		=> $row['capacity_box_'.$i],
							'class'		=> "capacity_box number-fields-small valid form-control-sm cvOn cvReq cvNum"
						),
						'2' => array(
							'name'		=> 'unit_boxx',
							'type'		=> 'text',
							'valid'		=> 'text',
							'length'	=> null,
							'maxlength'	=> 4,
							'value'		=> $unit_box,
							'class'		=> "unit_boxx form-control-sm cvOn cvNotReq",
							'disabled'	=> true
						),
						'3' => array(
							'name'		=> 'no_of_machinery',
							'type'		=> 'text',
							'valid'		=> 'text',
							'length'	=> null,
							'maxlength'	=> 4,
							'value'		=> $row['no_of_machinery_'.$i],
							'class'		=> "machinery_no number-fields-small valid form-control-sm cvOn cvReq cvNum cvMaxLen"
						),
						'4' => array(
							'name'		=> 'electrical_select',
							'type'		=> 'select',
							'valid'		=> 'notEmpty',
							'length'	=> null,
							'option'	=> $electric_option,
							'selected'	=> $row['electrical_select_'.$i],
							'class'		=> "electrical_select selectbox-small form-control-sm cvOn cvReq"
						),
						'5' => array(
							'name'		=> 'opencast_select',
							'type'		=> 'select',
							'valid'		=> 'notEmpty',
							'length'	=> null,
							'option'	=> $opencast_option,
							'selected'	=> $row['opencast_select_'.$i],
							'class'		=> "opencast_select selectbox-small form-control-sm cvOn cvReq"
						)
					);

					$loopC++;
				}

			}

			
			// FORM M: Part III: End-use Mineral Based Industries - II
			if(in_array($formId,['product_manufacture_details'])){

				$tableD['label'] = array(
					'0' => array(
						'0' => array(
							'col' 		=> null,
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						),
						'1' => array(
							'col' 		=> null,
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						),
						'2' => array(
							'col' 		=> null,
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						),
						'3' => array(
							'col' 		=> null,
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						)
					)
				);

				$tableD['input'] = [];
				
				// machinery type options
				$finishedProductList = array();
				foreach($rowArr[2] as $key=>$val){
					$finishedProductList[] = array(
						'vall' => $key,
						'label' => $val
					);
				}

				$prod = $rowArr[1];

				$loopC = "0";

				if ($rowArr[0] == 1) {
					$finProdCount = $prod['finishedProductCount'];
					for ($n = 1; $n <= $finProdCount; $n++) {

						$tableD['input'][$loopC] = array(
							'0' => array(
								'name'		=> 'finished_Product',
								'type'		=> 'select',
								'valid'		=> 'notEmpty',
								'length'	=> null,
								'option'	=> $finishedProductList,
								'selected'	=> $prod['finished_Product_'.$n],
								'class'		=> 'products right mw_170'
							),
							'1' => array(
								'name'		=> 'finished_Capacity',
								'type'		=> 'text',
								'maxlength'	=> '50',
								'max'		=> '999999999999.999',
								'cvfloat'	=> 999999999999.999,
								'value'		=> $prod['finished_Capacity_'.$n],
								'class'		=> 'products_1 right cvOn cvNum cvMax cvFloat'
							),
							'2' => array(
								'name'		=> 'finished_Previous',
								'type'		=> 'text',
								'maxlength'	=> '50',
								'max'		=> '999999999999.999',
								'cvfloat'	=> 999999999999.999,
								'value'		=> $prod['finished_Previous_'.$n],
								'class'		=> 'products_1 right cvOn cvNum cvMax cvFloat'
							),
							'3' => array(
								'name'		=> 'finished_Present',
								'type'		=> 'text',
								'maxlength'	=> '50',
								'max'		=> '999999999999.999',
								'cvfloat'	=> 999999999999.999,
								'value'		=> $prod['finished_Present_'.$n],
								'class'		=> 'products_1 right cvOn cvNum cvMax cvFloat'
							)
						);
						$loopC++;

					}
				}
				
				if ($rowArr[0] == 2) {
					$intProdCount = $prod['interProductCount'];
					for ($m = 1; $m <= $intProdCount; $m++) {

						$tableD['input'][$loopC] = array(
							'0' => array(
								'name'		=> 'intermediate_Product',
								'type'		=> 'text',
								'maxlength'	=> '50',
								'value'		=> $prod['intermediate_Product_'.$m],
								'class'		=> 'products right'
							),
							'1' => array(
								'name'		=> 'intermediate_Capacity',
								'type'		=> 'text',
								'maxlength'	=> '50',
								'max'		=> '999999999999.999',
								'cvfloat'	=> 999999999999.999,
								'value'		=> $prod['intermediate_Capacity_'.$m],
								'class'		=> 'products_1 right cvOn cvNum cvMax cvFloat'
							),
							'2' => array(
								'name'		=> 'intermediate_Previous',
								'type'		=> 'text',
								'maxlength'	=> '50',
								'max'		=> '999999999999.999',
								'cvfloat'	=> 999999999999.999,
								'value'		=> $prod['intermediate_Previous_'.$m],
								'class'		=> 'products_1 right cvOn cvNum cvMax cvFloat'
							),
							'3' => array(
								'name'		=> 'intermediate_Present',
								'type'		=> 'text',
								'maxlength'	=> '50',
								'max'		=> '999999999999.999',
								'cvfloat'	=> 999999999999.999,
								'value'		=> $prod['intermediate_Present_'.$m],
								'class'		=> 'products_1 right cvOn cvNum cvMax cvFloat'
							)
						);
						$loopC++;

					}
				}

				
				if ($rowArr[0] == 3) {
					$byProdCount = $prod['byProductCount'];
					for ($o = 1; $o <= $byProdCount; $o++) {

						$tableD['input'][$loopC] = array(
							'0' => array(
								'name'		=> 'byProducts_Product',
								'type'		=> 'text',
								'maxlength'	=> '50',
								'value'		=> $prod['byProducts_Product_'.$o],
								'class'		=> 'products right'
							),
							'1' => array(
								'name'		=> 'byProducts_Capacity',
								'type'		=> 'text',
								'maxlength'	=> '50',
								'max'		=> '999999999999.999',
								'cvfloat'	=> 999999999999.999,
								'value'		=> $prod['byProducts_Capacity_'.$o],
								'class'		=> 'products_1 right cvOn cvNum cvMax cvFloat'
							),
							'2' => array(
								'name'		=> 'byProducts_Previous',
								'type'		=> 'text',
								'maxlength'	=> '50',
								'max'		=> '999999999999.999',
								'cvfloat'	=> 999999999999.999,
								'value'		=> $prod['byProducts_Previous_'.$o],
								'class'		=> 'products_1 right cvOn cvNum cvMax cvFloat'
							),
							'3' => array(
								'name'		=> 'byProducts_Present',
								'type'		=> 'text',
								'maxlength'	=> '50',
								'max'		=> '999999999999.999',
								'cvfloat'	=> 999999999999.999,
								'value'		=> $prod['byProducts_Present_'.$o],
								'class'		=> 'products_1 right cvOn cvNum cvMax cvFloat'
							)
						);
						$loopC++;

					}
				}
				
			}

			
			// FORM M: Part III: Raw Materials Consumed In Production
			if(in_array($formId,['raw_material_consumed'])){

				$tableD['label'] = array(
					'0' => array(
						'0' => array(
							'col' 		=> $label[0],
							'colspan' 	=> '3',
							'rowspan' 	=> '2'
						),
						'1' => array(
							'col' 		=> $label[1],
							'colspan' 	=> '4',
							'rowspan' 	=> '1'
						),
						'2' => array(
							'col' 		=> $label[2],
							'colspan' 	=> '2',
							'rowspan' 	=> '1'
						)
					),
					'1' => array(
						'0' => array(
							'col' 		=> $label[6],
							'colspan' 	=> '2',
							'rowspan' 	=> '1'
						),
						'1' => array(
							'col' 		=> $label[7],
							'colspan' 	=> '2',
							'rowspan' 	=> '1'
						),
						'2' => array(
							'col' 		=> $label[8],
							'colspan' 	=> '1',
							'rowspan' 	=> '2'
						),
						'3' => array(
							'col' 		=> $label[9],
							'colspan' 	=> '1',
							'rowspan' 	=> '2'
						)
					),
					'2' => array(
						'0' => array(
							'col' 		=> $label[3],
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						),
						'1' => array(
							'col' 		=> $label[4],
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						),
						'2' => array(
							'col' 		=> $label[5],
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						),
						'3' => array(
							'col' 		=> $label[10],
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						),
						'4' => array(
							'col' 		=> $label[11],
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						),
						'5' => array(
							'col' 		=> $label[10],
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						),
						'6' => array(
							'col' 		=> $label[11],
							'colspan' 	=> '1',
							'rowspan' 	=> '1'
						)
					)
				);

				$tableD['input'] = [];

				// grade code options
				$mineral_option = array();
				$mineral_option[] = array('vall'=>'', 'label'=>'--Select--');

				foreach($rowArr[1] as $key=>$val){

					$mineral_option[] = array(
						'vall' => $key,
						'label' => $val
					);
				}
				$m_option = $mineral_option;
				$m_option[] = array(
					'vall' => 'NIL',
					'label' => 'NIL'
				);

				$loopC = "0";
				$row = $rowArr[0];
				$count = $row['totalCount'];
				for ($i = 1; $i <= $count; $i++) {

					$tableD['input'][$loopC] = array(
						'0' => array(
							'name'		=> 'raw_mineral',
							'type'		=> 'select',
							'option'	=> ($loopC==0) ? $m_option : $mineral_option,
							'selected'	=> $row['raw_mineral_'.$i],
							'class'		=> "MakeRequired putUnit fillNil"
						),
						'1' => array(
							'name'		=> 'rawmat_physpe',
							'type'		=> 'text',
							'value'		=> $row['rawmat_physpe_'.$i],
							'class'		=> "MakeRequired makeNilChar text-fields Specification"
						),
						'2' => array(
							'name'		=> 'rawmat_chespe',
							'type'		=> 'text',
							'value'		=> $row['rawmat_chespe_'.$i],
							'class'		=> "MakeRequired makeNilChar text-fields Specification"
						),
						'3' => array(
							'name'		=> 'rawmat_prv_ind',
							'type'		=> 'text',
							'value'		=> $row['rawmat_prv_ind_'.$i],
							'class'		=> "MakeRequired makeNil right text-fields year"
						),
						'4' => array(
							'name'		=> 'rawmat_prv_imp',
							'type'		=> 'text',
							'value'		=> $row['rawmat_prv_imp_'.$i],
							'class'		=> "MakeRequired makeNil right text-fields year"
						),
						'5' => array(
							'name'		=> 'rawmat_pre_ind',
							'type'		=> 'text',
							'value'		=> $row['rawmat_pre_ind_'.$i],
							'class'		=> "MakeRequired makeNil right text-fields year"
						),
						'6' => array(
							'name'		=> 'rawmat_pre_imp',
							'type'		=> 'text',
							'value'		=> $row['rawmat_pre_imp_'.$i],
							'class'		=> "MakeRequired makeNil right text-fields year"
						),
						'7' => array(
							'name'		=> 'rawmat_nex_fin_yr',
							'type'		=> 'text',
							'value'		=> $row['rawmat_nex_fin_yr_'.$i],
							'class'		=> "MakeRequired makeNil right text-fields year"
						),
						'8' => array(
							'name'		=> 'rawmat_nextonex_fin_yr',
							'type'		=> 'text',
							'value'		=> $row['rawmat_nextonex_fin_yr_'.$i],
							'class'		=> "MakeRequired makeNil right text-fields year"
						)
					);

					$loopC++;
				}
				
			}
			
			return $tableD;
			
		}

	}
	
?>