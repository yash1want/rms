<?php

namespace App\Controller;

include("../vendor/autoload.php");

use Cake\Datasource\ConnectionManager;

use PhpOffice\PhpSpreadsheet\IOFactory;

use DateTime;


class ReportsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadModel('DirMcpMineral');
        $this->loadModel('DirState');

        $this->userSessionExits();
		
		ini_set('memory_limit', '-1');
		//ini_set('memory_limit', '1024M'); // or you could use 1G
		
		//ini_set('memory_limit', '4095M'); // 4 GBs minus 1 MB
		
		//ini_set('memory_limit','10240M'); //10 gb
		set_time_limit(0);

		

		// ini_set("max_execution_time", "-1");
		// ini_set("memory_limit", "-1");
		// ignore_user_abort(true);
		// set_time_limit(0);
    }

    public function reportList()
    {
        $this->viewBuilder()->setLayout('report_layout');
    }

    public function monthlyFilter()
    {
        $title = $this->request->getQuery('title');
        $subtype = null;

        if ($title == "report-M01a") {
            $title = "report-M01";
            $subtype = "1";
        }
        if ($title == "report-M01b") {
            $title = "report-M01";
            $subtype = "2";
        }		

        $this->set('subtype', $subtype);
        $this->set('title', $title);

        $this->viewBuilder()->setLayout('report_layout');

        $queryMineral = $this->DirMcpMineral->find('list', [
            'keyField' => 'mineral_name',
            'valueField' => 'mineral_name',
        ])
            ->select(['mineral_name'])->order(['mineral_name' => 'ASC']);
        $minerals = $queryMineral->toArray();
        $this->set('minerals', $minerals);

        $queryState = $this->DirState->find('list', [
            'keyField' => 'state_code',
            'valueField' => 'state_name',
        ])
            ->select(['state_name']);
        $states = $queryState->toArray();
        $this->set('states', $states);
    }

    public function annualFilter()
    {	
        $title = $this->request->getQuery('title');
		
		if ($title == "report-A01a") {
            $title = "report-A01";
            $subtype = "1";
        }
        if ($title == "report-A01b") {
            $title = "report-A01";
            $subtype = "2";
        }		
		
		$this->set('subtype', $subtype);
        $this->set('title', $title);

        $this->viewBuilder()->setLayout('report_layout');

        $queryMineral = $this->DirMcpMineral->find('list', [
            'keyField' => 'mineral_name',
            'valueField' => 'mineral_name',
        ])
            ->select(['mineral_name'])->order(['mineral_name' => 'ASC']);
        $minerals = $queryMineral->toArray();
        $this->set('minerals', $minerals);

        $queryState = $this->DirState->find('list', [
            'keyField' => 'state_code',
            'valueField' => 'state_name',
        ])
            ->select(['state_name'])->order(['state_name' => 'ASC']);
        $states = $queryState->toArray();
        $this->set('states', $states);
    }

    public function reportM01()
    {
        $this->viewBuilder()->setLayout('report_layout');

        if ($this->request->is('post')) {

            $returnType = $this->request->getData('returnType');
            $fromDate = $this->request->getData('from_date');
            $fromDate = explode(' ', $fromDate);
            $month1 = $fromDate[0];
			$month1 =$year1.$month1.'-01';
			$month01 = explode('-',$month1);
            $monthno = date('m', strtotime($month1));
            $year1 = $fromDate[1];
            $from_date = $year1 . '-' . $monthno . '-01';

            $toDate = $this->request->getData('to_date');
            $toDate = explode(' ', $toDate);
            $month2 = $toDate[0];
			$month2 = $year2.$month2.'-01';
			$month02 = explode('-',$month2);
            $monthno = date('m', strtotime($month2));
            $year2 = $toDate[1];
            $to_date = $year2 . '-' . $monthno . '-01';

            $from = $month1 . ' ' . $year1;
            $to =  $month2 . ' ' . $year2;
            $showDate = $month01[0] . ' ' . $year1 . ' To ' . $month02[0] . ' ' . $year2;

            $mineral = $this->request->getData('mineral');
            $mineral = strtolower(str_replace(' ', '_', $mineral));
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');
            $subtype = $this->request->getData('subtype');

            if ($subtype == '2') {

                $selectColumn = " SELECT 
									m.MINE_NAME,
									m.lessee_owner_name,
									m.registration_no,
									s.state_name,
									d.district_name,
									'$from' AS fromDate,
									'$to' AS toDate,
									EXTRACT(MONTH FROM m1.return_date) AS showMonth,
									EXTRACT(YEAR FROM m1.return_date) AS showYear,
									ml.mcmdt_ML_Area AS lease_area,
									m1.*,
									m.nature_use,
									'' as sale_value,
									'' as quantity,
									'' as client_type,
									'' as grade_name,
									m.type_working, m.mechanisation, m.mine_ownership,
									CASE
										WHEN `m`.`mine_category` = 1 THEN 'A'
										WHEN `m`.`mine_category` = 2 THEN 'B'
										ELSE `m`.`mine_category`
									END AS mine_category ";

                $joins = " FROM
									view_report_grade_rom_m01a m1        
										INNER JOIN
									mine m ON m.mine_code = m1.mine_code
										INNER JOIN
									dir_state s ON m.state_code = s.state_code
										INNER JOIN
									dir_district d ON m.district_code = d.district_code
										AND s.state_code = d.state_code       
										LEFT JOIN
									mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1";

                $conditions = " WHERE m1.return_type = '$returnType' AND (m1.return_date BETWEEN '$from_date' AND '$to_date')
									AND (m1.mineral_name != 'iron_ore' and m1.mineral_name != 'chromite')";
            } else {

                $selectColumn = "SELECT 
											m.MINE_NAME,
											m.lessee_owner_name,
											m.registration_no,
											s.state_name,
											d.district_name,
											dmg.grade_name,
											'$from' AS fromDate,
											'$to' AS toDate,
											EXTRACT(MONTH FROM m1.return_date) AS showMonth,
											EXTRACT(YEAR FROM m1.return_date) AS showYear,
											ml.mcmdt_ML_Area AS lease_area,
											m1.*,
											m.nature_use,
											(CASE
												WHEN (`gs`.`grade_code` = `m1`.`grade_code`) THEN `gs`.`client_type`
											END) AS `client_type`,
											(CASE
												WHEN
													(((`gs`.`client_type` = 'DOMESTIC SALE')
														OR (`gs`.`client_type` = 'DOMESTIC TRANSFER')
														OR (`gs`.`client_type` = 'CAPTIVE CONSUMPTION'))
														AND (`gs`.`grade_code` = `m1`.`grade_code`))
												THEN
													`gs`.`sale_value`
												WHEN
													((`gs`.`client_type` = 'EXPORT')
														AND (`gs`.`grade_code` = `m1`.`grade_code`))
												THEN
													`gs`.`expo_fob`
											END) AS `sale_value`,
											(CASE
												WHEN
													(((`gs`.`client_type` = 'DOMESTIC SALE')
														OR (`gs`.`client_type` = 'DOMESTIC TRANSFER')
														OR (`gs`.`client_type` = 'CAPTIVE CONSUMPTION'))
														AND (`gs`.`grade_code` = `m1`.`grade_code`))
												THEN
													`gs`.`quantity`
												WHEN
													((`gs`.`client_type` = 'EXPORT')
														AND (`gs`.`grade_code` = `m1`.`grade_code`))
												THEN
													`gs`.`expo_quantity`
											END) AS `quantity`,
											m.type_working, m.mechanisation, m.mine_ownership,
											CASE
												WHEN `m`.`mine_category` = 1 THEN 'A'
												WHEN `m`.`mine_category` = 2 THEN 'B'
												ELSE `m`.`mine_category`
											END AS `mine_category`";


				// Removing condition from Join => (AND gs.mineral_name = m1.mineral_name) to get Quantity, Sale value, Nature of despatch on 04-04-2022 By Shweta Apale
                //Added new condition in Join (AND m1.iron_type = gs.min_iron_type) on 04-04-2022
                $joins = " FROM
                            view_report_grade_rom_m01 m1						
                                LEFT JOIN
                            grade_sale gs ON m1.mine_code = gs.mine_code
                                AND m1.mine_code = gs.mine_code
                                AND (gs.return_date BETWEEN '$from_date' AND '$to_date')
                                AND gs.return_type = '$returnType'
                                AND m1.iron_type = gs.min_iron_type										
                                AND m1.return_date = gs.return_date
                                AND m1.return_type = gs.return_type
                                AND m1.grade_code = gs.grade_code
                                INNER JOIN
                            mine m ON m.mine_code = m1.mine_code
                                INNER JOIN
                            dir_state s ON m.state_code = s.state_code
                                INNER JOIN
                            dir_district d ON m.district_code = d.district_code
                                AND s.state_code = d.state_code
                                LEFT JOIN
                            dir_mineral_grade dmg ON m1.grade_code = dmg.grade_code
                                AND m1.mineral_name = REPLACE(LOWER(dmg.mineral_name),
                                ' ',
                                '_')       
                                LEFT JOIN
                            mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1 ";

                $conditions = " WHERE m1.return_type = '$returnType' AND (m1.return_date BETWEEN '$from_date' AND '$to_date') 
								AND (m1.mineral_name = 'iron_ore' OR m1.mineral_name = 'chromite')";
            }


            $sql = "$selectColumn $joins $conditions ";

            //print_r($sql); exit;

            /*$sql = "SELECT m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, dmg.grade_name, '$from' AS fromDate , '$to' As toDate,
					EXTRACT(MONTH FROM m1.return_date) AS showMonth, EXTRACT(YEAR FROM m1.return_date) AS showYear,ml.mcmdt_ML_Area AS lease_area, m1.*,
					m.nature_use					
					$selectColumn 
					FROM
					$viewtable m1						
						LEFT JOIN
					grade_sale gs ON m1.mine_code = gs.mine_code
						AND m1.mine_code = gs.mine_code
						AND (gs.return_date BETWEEN '$from_date' AND '$to_date')
						AND gs.return_type = '$returnType'
						AND gs.mineral_name = m1.mineral_name
						AND m1.return_date = gs.return_date
						AND m1.return_type = gs.return_type
						$joninCondition
						INNER JOIN
					mine m ON m.mine_code = m1.mine_code
						INNER JOIN
					dir_state s ON m.state_code = s.state_code
						INNER JOIN
					dir_district d ON m.district_code = d.district_code
						AND s.state_code = d.state_code
						LEFT JOIN
					dir_mineral_grade dmg ON m1.grade_code = dmg.grade_code
						AND m1.mineral_name = REPLACE(LOWER(dmg.mineral_name),
						' ',
						'_')       
					   LEFT JOIN
                 mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode 
					WHERE
						m1.return_type = '$returnType' AND (m1.return_date BETWEEN '$from_date' AND '$to_date') 
						AND (m1.mineral_name = 'iron_ore' OR m1.mineral_name = 'chromite') "
						 ;*/
            // last condition added by Naveen 29/3/22 to list only iron ore and chromite 
            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND m1.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND m1.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area  = '$lesseearea'";
            }
            $sql .= "order by m1.mineral_name,s.state_name,d.district_name,m1.return_date,grade_name";
            //print_r($sql);exit;
            $query = $con->execute($sql);
			// echo $sql; exit;	
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
				$this->set('subtype',$subtype);
                $this->set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportM02()
    {
          $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
					$returnType = $this->request->getData('returnType');
					$fromDate = $this->request->getData('from_date');
					$fromDate = explode(' ', $fromDate);
					$month1 = $fromDate[0];
					$month1 = $year1.$month1.'-01';
					$month01 = explode('-',$month1);
					$monthno = date('m', strtotime($month1));
					$year1 = $fromDate[1];
					$from_date = $year1 . '-' . $monthno . '-01';

					$toDate = $this->request->getData('to_date');
					$toDate = explode(' ', $toDate);
					$month2 = $toDate[0];
					$month2 = $year2.$month2.'-01';
					$month02 = explode('-',$month2);
					$monthno = date('m', strtotime($month2));
					$year2 = $toDate[1];
					$to_date = $year2 . '-' . $monthno . '-01';

					$from = $month1 . ' ' . $year1;
					$to =  $month2 . ' ' . $year2;

					$showDate = $month01[0] . ' ' . $year1 . ' To ' . $month02[0] . ' ' . $year2;

					$mineral = $this->request->getData('mineral');
					
					$mineral = strtolower(str_replace(' ', '_', $mineral));
					
					$state = $this->request->getData('state');
					$district = $this->request->getData('district');
					$minecode = $this->request->getData('minecode');
					if ($minecode != '') {
						$minecode = implode('\', \'', $minecode);
					}
					$minename = $this->request->getData('minename');
					$owner = $this->request->getData('owner');
					$lesseearea = $this->request->getData('lesseearea');
					$ibm = $this->request->getData('ibm');

					$con = ConnectionManager::get('default');

					if($mineral == 'iron_ore'){
					$sql = "SELECT m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, dmg.grade_name,'$from' AS fromDate , '$to' As toDate,
							EXTRACT(MONTH FROM m2.return_date) AS showMonth,
							EXTRACT(YEAR FROM m2.return_date) AS showYear,
							ml.mcmdt_ML_Area AS lease_area,
							m2.*,m.nature_use,
							m.type_working, m.mechanisation, m.mine_ownership,
							CASE
								WHEN `m`.`mine_category` = 1 THEN 'A'
								WHEN `m`.`mine_category` = 2 THEN 'B'
								ELSE `m`.`mine_category`
							END AS `mine_category`
						FROM
							view_report_grade_rom_m02_saleprod_union_iv m2												
								INNER JOIN
							mine m ON m.mine_code = m2.mine_code
								INNER JOIN
							dir_state s ON m.state_code = s.state_code
								INNER JOIN
							dir_district d ON m.district_code = d.district_code
								AND s.state_code = d.state_code
								INNER JOIN
							dir_mineral_grade dmg ON m2.grade_code = dmg.grade_code
							  
							  LEFT JOIN
							mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1

							WHERE
							m2.return_type = '$returnType' AND (m2.return_date BETWEEN '$from_date' AND '$to_date')";
					}
					if($mineral == 'chromite'){
						$sql = "SELECT m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, dmg.grade_name,'$from' AS fromDate , '$to' As toDate,
							EXTRACT(MONTH FROM m2.return_date) AS showMonth,
							EXTRACT(YEAR FROM m2.return_date) AS showYear,
							ml.mcmdt_ML_Area AS lease_area,
							m2.*,m.nature_use,
							m.type_working, m.mechanisation, m.mine_ownership,
							CASE
								WHEN `m`.`mine_category` = 1 THEN 'A'
								WHEN `m`.`mine_category` = 2 THEN 'B'
								ELSE `m`.`mine_category`
							END AS `mine_category`
						FROM
							view_report_grade_rom_m02_saleprod_union_chromite m2												
								INNER JOIN
							mine m ON m.mine_code = m2.mine_code
								INNER JOIN
							dir_state s ON m.state_code = s.state_code
								INNER JOIN
							dir_district d ON m.district_code = d.district_code
								AND s.state_code = d.state_code
								INNER JOIN
							dir_mineral_grade dmg ON m2.grade_code = dmg.grade_code
							  
							  LEFT JOIN
							mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode  AND ml.mcmdt_status = 1

							WHERE
							m2.return_type = '$returnType' AND (m2.return_date BETWEEN '$from_date' AND '$to_date')";
					}
					if($mineral == ''){
						$sql = "SELECT m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, dmg.grade_name,'$from' AS fromDate , '$to' As toDate,
							EXTRACT(MONTH FROM m2.return_date) AS showMonth,
							EXTRACT(YEAR FROM m2.return_date) AS showYear,
							ml.mcmdt_ML_Area AS lease_area,
							m2.*,m.nature_use,
							m.type_working, m.mechanisation, m.mine_ownership,
							CASE
								WHEN `m`.`mine_category` = 1 THEN 'A'
								WHEN `m`.`mine_category` = 2 THEN 'B'
								ELSE `m`.`mine_category`
							END AS `mine_category`
						FROM
							view_report_grade_rom_m02_saleprod_union_iron_chromite m2												
								INNER JOIN
							mine m ON m.mine_code = m2.mine_code
								INNER JOIN
							dir_state s ON m.state_code = s.state_code
								INNER JOIN
							dir_district d ON m.district_code = d.district_code
								AND s.state_code = d.state_code
								INNER JOIN
							dir_mineral_grade dmg ON m2.grade_code = dmg.grade_code
							  
							  LEFT JOIN
							mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1

							WHERE
							m2.return_type = '$returnType' AND (m2.return_date BETWEEN '$from_date' AND '$to_date')																			
							";
					}
							
							 if ($state != '') {
								$sql .= " AND m.state_code = '$state'";
							}
							if ($district != '') {
								$sql .= " AND m.district_code = '$district'";
							}
							if ($mineral != '') {
								$sql .= " AND m2.mineral_name = '$mineral'";
							}
							if ($minecode != '') {
								$sql .= " AND m2.mine_code IN('$minecode')";
							}
							if ($ibm != '') {
								$sql .= " AND m.registration_no  = '$ibm'";
							}
							if ($minename != '') {
								$sql .= " AND m.MINE_NAME = '$minename'";
							}
							if ($owner != '') {
								$sql .= "  AND m.lessee_owner_name = '$owner'";
							}
							if ($lesseearea != '') {
								$sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
							}
						$sql .= " ORDER BY m2.grade_code";
					
					//print_r($sql); die;
					$query = $con->execute($sql);
					
					// To count number of records
					$count = count($query);
					$rowCount = $query->rowCount();
					
					$records = $query->fetchAll('assoc');
				// 	$sr= 1;
				// 	foreach ($records as $record) {
				// 		//creating object of DateTime and fetching the month
				// 		$dbj   = DateTime::createFromFormat('!m', $record['showMonth']);
				// 		//Format it to month name
				// 		 $monthName = $dbj->format('F');

				// 		$showYear = $monthName.' '.$record['showYear'];
				// 		$mineral = ucwords(str_replace('_', ' ', $record['mineral_name']));
				// 		$state = $record['state_name'];
				// 		$district = $record['district_name'];
				// 		$mine = $record['MINE_NAME'];
				// 		$lesse = $record['lessee_owner_name'];
				// 		$area = $record['lease_area'];
				// 		$minecode = $record['mine_code'];
				// 		$nature = $record['nature_use'];
				// 		$reg = $record['registration_no'];
				// 		$gname = $record['grade_name'];
				// 		$prod = $record['production'];
				// 		$despatches = $record['despatches'];
				// 		$pmv = $record['pmv'];
				// 		$os = $record['opening_stock'];
				// 		$cs =  $record['closing_stock'];
				// 		$client = $record['client_type'];
				// 		$qty = $record['quantity'];
				// 		$sv = $record['sale_value'];
				// 		$dd = $record['detail_deduction'];

				// 		// $category = $record['mine_category'];
				// 		// $type =	 $record['type_working'] ;
				// 		// $mechanisation = $record['mechanisation'] ;
				// 		// $mineOwner = $record['mine_ownership'] ;

				// 		$insert = "INSERT INTO reporttwoa 
				// 	VALUES ('$sr','$showYear', '$mineral' , '$state', '$district', '$mine', '$lesse', '$area', '$minecode', '$nature', '$reg', '$category','$type','$mechanisation','$mineOwner', '$gname', '$prod', '$despatches', '$pmv', '$os', '$cs', '$client', '$qty', '$sv', '$dd') ";
					
				// 	// print_r($insert); die;
				// 	$queryins = $con->execute($insert);
					
				// $sr++;	
				// }
					
									
			}
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
    }


	public function reportM02b()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
					$returnType = $this->request->getData('returnType');
					$fromDate = $this->request->getData('from_date');
					$fromDate = explode(' ', $fromDate);
					$month1 = $fromDate[0];
					$month1 = $year1.$month1.'-01';
					$month01 = explode('-',$month1);
					$monthno = date('m', strtotime($month1));
					$year1 = $fromDate[1];
					$from_date = $year1 . '-' . $monthno . '-01';

					$toDate = $this->request->getData('to_date');
					$toDate = explode(' ', $toDate);
					$month2 = $toDate[0];
					$month2 = $year2.$month2.'-01';
					$month02 = explode('-',$month2);
					$monthno = date('m', strtotime($month2));
					$year2 = $toDate[1];
					$to_date = $year2 . '-' . $monthno . '-01';

					$from = $month1 . ' ' . $year1;
					$to =  $month2 . ' ' . $year2;

					$showDate = $month01[0] . ' ' . $year1 . ' To ' . $month02[0] . ' ' . $year2;

					$mineral = $this->request->getData('mineral');
					$mineral = strtolower(str_replace(' ', '_', $mineral));
					
					$state = $this->request->getData('state');
					$district = $this->request->getData('district');
					$minecode = $this->request->getData('minecode');
					if ($minecode != '') {
						$minecode = implode('\', \'', $minecode);
					}
					$minename = $this->request->getData('minename');
					$owner = $this->request->getData('owner');
					$lesseearea = $this->request->getData('lesseearea');
					$ibm = $this->request->getData('ibm');

					$con = ConnectionManager::get('default');

					$sql = "SELECT m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, dmg.grade_name,'$from' AS fromDate , '$to' As toDate,
							EXTRACT(MONTH FROM m2.return_date) AS showMonth,
							EXTRACT(YEAR FROM m2.return_date) AS showYear,
							ml.mcmdt_ML_Area AS lease_area,
							m2.*,m.nature_use,
							m.type_working, m.mechanisation, m.mine_ownership,
							CASE
								WHEN `m`.`mine_category` = 1 THEN 'A'
								WHEN `m`.`mine_category` = 2 THEN 'B'
								ELSE `m`.`mine_category`
							END AS `mine_category`
						FROM
							view_report_grade_rom_m02b_saleprod_union_iv m2												
								INNER JOIN
							mine m ON m.mine_code = m2.mine_code
								INNER JOIN
							dir_state s ON m.state_code = s.state_code
								INNER JOIN
							dir_district d ON m.district_code = d.district_code
								AND s.state_code = d.state_code
								INNER JOIN
							dir_mineral_grade dmg ON m2.grade_code = dmg.grade_code
							  
							  LEFT JOIN
							mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1

							WHERE
							m2.return_type = '$returnType' AND (m2.return_date BETWEEN '$from_date' AND '$to_date')";
							
							 if ($state != '') {
								$sql .= " AND m.state_code = '$state'";
							}
							if ($district != '') {
								$sql .= " AND m.district_code = '$district'";
							}
							if ($mineral != '') {
								$sql .= " AND m2.mineral_name = '$mineral'";
							}
							if ($minecode != '') {
								$sql .= " AND m2.mine_code IN('$minecode')";
							}
							if ($ibm != '') {
								$sql .= " AND m.registration_no  = '$ibm'";
							}
							if ($minename != '') {
								$sql .= " AND m.MINE_NAME = '$minename'";
							}
							if ($owner != '') {
								$sql .= "  AND m.lessee_owner_name = '$owner'";
							}
							if ($lesseearea != '') {
								$sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
							}
					$sql .= " ORDER BY m2.client_type,m2.grade_code";
					//print_r($sql);exit;
					$query = $con->execute($sql);
					
					// To count number of records
					$count = count($query);
					$rowCount = $query->rowCount();
					
					$records = $query->fetchAll('assoc');																
			}
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount', $rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
    }



    public function reportM02c()
    {
          $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $fromDate = $this->request->getData('from_date');
            $fromDate = explode(' ', $fromDate);
            $month1 = $fromDate[0];
			$month1 = $year1.$month1.'-01';
			$month01 = explode('-',$month1);
            $monthno = date('m', strtotime($month1));
            $year1 = $fromDate[1];
            $from_date = $year1 . '-' . $monthno . '-01';

            $toDate = $this->request->getData('to_date');
            $toDate = explode(' ', $toDate);
            $month2 = $toDate[0];
			$month2 = $year2.$month2.'-01';
			$month02 = explode('-',$month2);
            $monthno = date('m', strtotime($month2));
            $year2 = $toDate[1];
            $to_date = $year2 . '-' . $monthno . '-01';

            $from = $month1 . ' ' . $year1;
            $to =  $month2 . ' ' . $year2;

            $showDate = $month01[0] . ' ' . $year1 . ' To ' . $month02[0] . ' ' . $year2;

            $mineral = $this->request->getData('mineral');
            $mineral = strtolower(str_replace(' ', '_', $mineral));
			
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            $sql = "SELECT DISTINCT m.MINE_NAME, m.lessee_owner_name, m.registration_no, ml.mcmdt_ML_Area AS lease_area, s.state_name, d.district_name, 
						 dst.stone_def as grade_name,'$from' AS fromDate , '$to' As toDate, EXTRACT(MONTH FROM m2.return_date) AS showMonth, EXTRACT(YEAR FROM m2.return_date) AS showYear,
						m2.*,m.nature_use,dmm.input_unit,
						m.type_working, m.mechanisation, m.mine_ownership,
						CASE
							WHEN `m`.`mine_category` = 1 THEN 'A'
							WHEN `m`.`mine_category` = 2 THEN 'B'
							ELSE `m`.`mine_category`
						END AS `mine_category`
						FROM
						tbl_final_submit tfs
						inner join view_report_grade_rom_m02c_saleprod_union_iv m2 on tfs.mine_code = m2.mine_code							
							INNER JOIN
						dir_stone_type dst ON m2.grade_code = dst.stone_sn
						 INNER JOIN 
						 mine m on m.mine_code = tfs.mine_code
							 INNER JOIN
						dir_state s ON m.state_code = s.state_code
							INNER JOIN
						dir_district d ON m.district_code = d.district_code
							AND d.state_code = s.state_code
							INNER JOIN
						dir_mcp_mineral dmm on m2.mineral_name = dmm.mineral_name
							LEFT JOIN
						mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1
						
						WHERE m2.return_type = '$returnType' AND (m2.return_date BETWEEN '$from_date' AND '$to_date') and tfs.is_latest = 1";
					
					 if ($state != '') {
						$sql .= " AND m.state_code = '$state'";
					}
					if ($district != '') {
						$sql .= " AND m.district_code = '$district'";
					}
					if ($mineral != '') {
						$sql .= " AND m2.mineral_name = '$mineral'";
					}
					if ($minecode != '') {
						$sql .= " AND m2.mine_code IN('$minecode')";
					}
					if ($ibm != '') {
						$sql .= " AND m.registration_no  = '$ibm'";
					}
					if ($minename != '') {
						$sql .= " AND m.MINE_NAME = '$minename'";
					}
					if ($owner != '') {
						$sql .= "  AND m.lessee_owner_name = '$owner'";
					}
					if ($lesseearea != '') {
						$sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
					}
				$sql .= " ORDER BY m2.return_date,m2.mine_code,m2.client_type,m2.grade_code";
			
            //print_r($sql);exit;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
					
            $records = $query->fetchAll('assoc');						
			}
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
    }


 public function reportM02_BAK_13_APR()
    {
          $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $fromDate = $this->request->getData('from_date');
            $fromDate = explode(' ', $fromDate);
            $month1 = $fromDate[0];
			$month1 = $year1.$month1.'-01';
            $monthno = date('m', strtotime($month1));
            $year1 = $fromDate[1];
            $from_date = $year1 . '-' . $monthno . '-01';

            $toDate = $this->request->getData('to_date');
            $toDate = explode(' ', $toDate);
            $month2 = $toDate[0];
			$month2 = $year2.$month2.'-01';
            $monthno = date('m', strtotime($month2));
            $year2 = $toDate[1];
            $to_date = $year2 . '-' . $monthno . '-01';

            $from = $month1 . ' ' . $year1;
            $to =  $month2 . ' ' . $year2;

            $showDate = $month1 . ' ' . $year1 . ' To ' . $month2 . ' ' . $year2;

            $mineral = $this->request->getData('mineral');
            $mineral = strtolower(str_replace(' ', '_', $mineral));
			
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

			//if($subtype == '1'){
            $sql = "SELECT m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, dmg.grade_name,'$from' AS fromDate , '$to' As toDate,
					EXTRACT(MONTH FROM m2.return_date) AS showMonth,
					EXTRACT(YEAR FROM m2.return_date) AS showYear,
					ml.mcmdt_ML_Area AS lease_area,
					m2.*,m.nature_use
				FROM
					view_report_grade_wise_m02 m2												
						INNER JOIN
					mine m ON m.mine_code = m2.mine_code
						INNER JOIN
					dir_state s ON m.state_code = s.state_code
						INNER JOIN
					dir_district d ON m.district_code = d.district_code
						AND s.state_code = d.state_code
						INNER JOIN
					dir_mineral_grade dmg ON m2.grade_code = dmg.grade_code
						AND m2.mineral_name = REPLACE(LOWER(dmg.mineral_name),
						' ',
						'_')       
					  LEFT JOIN
					mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode 

					WHERE
					m2.return_type = '$returnType' AND (m2.return_date BETWEEN '$from_date' AND '$to_date')";
					
					 if ($state != '') {
						$sql .= " AND m.state_code = '$state'";
					}
					if ($district != '') {
						$sql .= " AND m.district_code = '$district'";
					}
					if ($mineral != '') {
						$sql .= " AND m2.mineral_name = '$mineral'";
					}
					if ($minecode != '') {
						$sql .= " AND m2.mine_code IN('$minecode')";
					}
					if ($ibm != '') {
						$sql .= " AND m.registration_no  = '$ibm'";
					}
					if ($minename != '') {
						$sql .= " AND m.MINE_NAME = '$minename'";
					}
					if ($owner != '') {
						$sql .= "  AND m.lessee_owner_name = '$owner'";
					}
					if ($lesseearea != '') {
						$sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
					}
			//} 
			/*else {
				$sql = "SELECT DISTINCT m.MINE_NAME, m.lessee_owner_name, m.registration_no, ml.mcmdt_ML_Area AS lease_area, s.state_name, d.district_name, ps.mine_code,
						ps.mineral_name, ps.stone_sn, ps.open_tot_qty AS opening_stock, ps.prod_tot_qty AS production, ps.desp_tot_qty AS despatches, ps.clos_tot_qty AS closing_stock, ps.pmv_oc AS pmv, gs.return_date, dst.stone_def, 
						'$from' AS fromDate , '$to' As toDate, EXTRACT(MONTH FROM ps.return_date) AS showMonth, EXTRACT(YEAR FROM ps.return_date) AS showYear,
						(CASE
							WHEN (`gs`.`grade_code` = `ps`.`stone_sn` AND gs.mineral_name = ps.mineral_name) THEN `gs`.`client_type`
						END) AS `client_type`,
						(CASE
							WHEN
								(((`gs`.`client_type` = 'DOMESTIC SALE')
									OR (`gs`.`client_type` = 'DOMESTIC TRANSFER')
									OR (`gs`.`client_type` = 'CAPTIVE CONSUMPTION'))
									AND (`gs`.`grade_code` = `ps`.`stone_sn`)
									 AND gs.mineral_name = ps.mineral_name)
							THEN
								`gs`.`sale_value`
							WHEN
								((`gs`.`client_type` = 'EXPORT')
									AND (`gs`.`grade_code` = `ps`.`stone_sn` AND gs.mineral_name = ps.mineral_name))
							THEN
								`gs`.`expo_fob`
						END) AS `sale_value`,
						(CASE
							WHEN
								(((`gs`.`client_type` = 'DOMESTIC SALE')
									OR (`gs`.`client_type` = 'DOMESTIC TRANSFER')
									OR (`gs`.`client_type` = 'CAPTIVE CONSUMPTION'))
									AND (`gs`.`grade_code` = `ps`.`stone_sn`) AND gs.mineral_name = ps.mineral_name)
							THEN
								`gs`.`quantity`
							WHEN
								((`gs`.`client_type` = 'EXPORT')
									AND (`gs`.`grade_code` = `ps`.`stone_sn` AND gs.mineral_name = ps.mineral_name))
							THEN
								`gs`.`expo_quantity`
						END) AS `quantity`
						FROM
						tbl_final_submit tfs
						inner join prod_stone ps on tfs.mine_code = ps.mine_code
							INNER JOIN
						grade_sale gs ON gs.mine_code = ps.mine_code
							AND gs.grade_code = ps.stone_sn
							AND gs.return_type = ps.return_type
							AND gs.return_date = ps.return_date
							INNER JOIN
						dir_stone_type dst ON ps.stone_sn = dst.stone_sn
						 INNER JOIN 
						 mine m on m.mine_code = tfs.mine_code
							 INNER JOIN
						dir_state s ON m.state_code = s.state_code
							INNER JOIN
						dir_district d ON m.district_code = d.district_code
							AND d.state_code = s.state_code
							LEFT JOIN
						mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode
						
						WHERE ps.return_type = '$returnType' AND (ps.return_date BETWEEN '$from_date' AND '$to_date') and tfs.is_latest = 1";
			
				if ($state != '') {
					$sql .= " AND m.state_code = '$state'";
				}
				if ($district != '') {
					$sql .= " AND m.district_code = '$district'";
				}
				if ($mineral != '') {
					$sql .= " AND ps.mineral_name = '$mineral'";
				}
				if ($minecode != '') {
					$sql .= " AND ps.mine_code IN('$minecode')";
				}
				if ($ibm != '') {
					$sql .= " AND m.registration_no  = '$ibm'";
				}
				if ($minename != '') {
					$sql .= " AND m.MINE_NAME = '$minename'";
				}
				if ($owner != '') {
					$sql .= "  AND m.lessee_owner_name = '$owner'";
				}
				if ($lesseearea != '') {
					$sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
				}
			}*/
			/*$sql .= " group by m2.opening_stock,m2.production,m2.closing_stock, m2.despatches, m2.mine_code, m2.pmv,m2.detail_deduction,
        m2.return_date,m2.mineral_name,m2.return_type, m2.grade_code";*/
            //print_r($sql);exit;
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');
			
			//if($subtype == '1'){
			if(!empty($records)){
			
			//$delete = $con->execute("DROP TABLE IF EXISTS report_m02_grade_wise_temp_table");
			
			$deleteTbl = $con->execute("TRUNCATE TABLE report_m02_grade_wise_temp_table");

			/*$table = $con->execute("CREATE TABLE `report_m02_grade_wise_temp_table` (
				`MINE_NAME` varchar(255) NOT NULL,
				`lessee_owner_name` varchar(255) NOT NULL,
				`registration_no` varchar(255) NOT NULL,
				`state_name` varchar(255) NOT NULL,
				`district_name` varchar(255) NOT NULL,
				`grade_name` varchar(255) NOT NULL,
				`fromDate` varchar(255) NOT NULL,
				`toDate` varchar(255) NOT NULL,
				`showMonth` varchar(255) NOT NULL,
				`showYear` varchar(255) NOT NULL,
				`lease_area` varchar(255) NOT NULL,
				`opening_stock` varchar(255) NOT NULL,
				`production` varchar(255) NOT NULL,
				`closing_stock` varchar(255) NOT NULL,
				`despatches` varchar(255) NOT NULL,
				`mine_code` varchar(255) NOT NULL,
				`pmv` varchar(255) NOT NULL,
				`detail_deduction` varchar(255) NOT NULL,
				`return_date` varchar(255) NOT NULL,
				`mineral_name` varchar(255) NOT NULL,
				`return_type` varchar(255) NOT NULL,
				`grade_code` varchar(255) NOT NULL,
				`client_type` varchar(255) DEFAULT NULL,
				`sale_value` varchar(255) DEFAULT NULL,
				`quantity` varchar(255) DEFAULT NULL,
				`nature_use` varchar(255) DEFAULT NULL				
			   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"); */
			 $ctr=0;  
			foreach($records as $record){
				$ctr++;
				$MINE_NAME = $record['MINE_NAME'];
				$lessee_owner_name = $record['lessee_owner_name'];
				$registration_no = $record['registration_no'];
				$state_name = $record['state_name'];
				$district_name = $record['district_name'];
				$grade_name = $record['grade_name'];
				$fromDate = $record['fromDate'];
				$toDate = $record['toDate'];
				$showMonth = $record['showMonth'];
				$showYear = $record['showYear'];
				$lease_area = $record['lease_area'];
				$opening_stock = $record['opening_stock'];
				$production = $record['production'];
				$closing_stock = $record['closing_stock'];
				$despatches = $record['despatches'];
				$mine_code = $record['mine_code'];
				$pmv = $record['pmv'];
				$detail_deduction = $record['detail_deduction'];
				$return_date = $record['return_date'];
				$mineral_name = $record['mineral_name'];
				$return_type = $record['return_type'];
				$grade_code = $record['grade_code'];
				$client_type = $record['client_type'];
				$sale_value = $record['sale_value'];
				$quantity = $record['quantity'];
				$nature_use = $record['nature_use'];
				$iron_type = $record['iron_type'];
											
				$insert = $con->execute("INSERT INTO report_m02_grade_wise_temp_table (MINE_NAME, lessee_owner_name, registration_no, state_name, district_name, grade_name, fromDate,
				toDate, showMonth, showYear, lease_area, opening_stock, production, closing_stock, despatches, mine_code, pmv, detail_deduction, return_date, mineral_name, return_type,
				grade_code, client_type, sale_value, quantity, nature_use,id,iron_type) 
				VALUES (
					'$MINE_NAME', '$lessee_owner_name', '$registration_no', '$state_name', '$district_name', '$grade_name',
					'$fromDate', '$toDate', '$showMonth', '$showYear', '$lease_area', '$opening_stock', '$production',
					'$closing_stock', '$despatches', '$mine_code', '$pmv', '$detail_deduction', '$return_date', '$mineral_name',
					'$return_type', '$grade_code', '$client_type', '$sale_value', '$quantity', '$nature_use',$ctr,'$iron_type')");
			} 
			
			$mainSelect =  $con->execute("SELECT * FROM report_m02_grade_wise_temp_table");
			$recordMainSelects = $mainSelect->fetchAll('assoc');
			
			foreach($recordMainSelects AS $rs){
				$id = $rs['id'];	
				$MINE_NAME = $rs['MINE_NAME'];
				$lessee_owner_name = $rs['lessee_owner_name'];
				$registration_no = $rs['registration_no'];
				$state_name = $rs['state_name'];
				$district_name = $rs['district_name'];
				$grade_name = $rs['grade_name'];
				$fromDate = $rs['fromDate'];
				$toDate = $rs['toDate'];
				$showMonth = $rs['showMonth'];
				$showYear = $rs['showYear'];
				$lease_area = $rs['lease_area'];
				$opening_stock = $rs['opening_stock'];
				$production = $rs['production'];
				$closing_stock = $rs['closing_stock'];
				$despatches = $rs['despatches'];
				$mine_code = $rs['mine_code'];
				$pmv = $rs['pmv'];
				$detail_deduction = $rs['detail_deduction'];
				$return_date = $rs['return_date'];
				$mineral_name = $rs['mineral_name'];
				$return_type = $rs['return_type'];
				$grade_code = $rs['grade_code'];
				$client_type = $rs['client_type'];
				$sale_value = $rs['sale_value'];
				$quantity = $rs['quantity'];
				$nature_use = $rs['nature_use'];	
				
				// TO get Count of grade_code, if grade_code > 1 then delete the null row from temp table	
				$select = $con->execute("SELECT COUNT(grade_code) as count_grade_code, id FROM report_m02_grade_wise_temp_table WHERE grade_code = '$grade_code'   
						AND sale_value = '$sale_value' AND client_type = '$client_type' AND quantity = '$quantity' AND 
						mine_code = '$mine_code'  AND detail_deduction = '$detail_deduction' AND return_date = '$return_date'   order by grade_code,id");
				//AND opening_stock = '$opening_stock' AND production = '$production' AND closing_stock = '$closing_stock' AND despatches = '$despatches' 
			//	pr($select); exit();
				
				$recordSelects = $select->fetch('assoc');
				
				
				$count_grade_code = $recordSelects['count_grade_code'];		
				//echo $count_grade_code;
				if($count_grade_code > 1){
					
					$id_code= $recordSelects['id'];
					//$delete = $con->execute("DELETE from report_m02_grade_wise_temp_table WHERE id = '$recordSelects['id']' ");
				$delete = $con->execute("DELETE from report_m02_grade_wise_temp_table WHERE id = '$id_code' ");
				
				
				
			//	$select = $con->execute("SELECT COUNT(grade_code) as count_grade_code, id FROM report_m02_grade_wise_temp_table WHERE isnull(client_type) AND isnull(sale_value) AND isnull(quantity) AND isnull(detail_deduction)    
						
				//		");
						
			//	$select = $con->execute("SELECT COUNT(grade_code) as count_grade_code, id FROM report_m02_grade_wise_temp_table WHERE client_type = '' AND sale_value= '' AND quantity ='' AND detail_deduction=''    
						
			///			");
						
			//	$recordSelects = $select->fetch('assoc');
		//		$del_rec_count = $recordSelects['id'];
				//$delete = $con->execute("DELETE from report_m02_grade_wise_temp_table WHERE client_type = '' AND sale_value= '' AND quantity ='' AND detail_deduction='' ");

//$delete = $con->execute("DELETE from report_m02_grade_wise_temp_table WHERE iron_type = 'magnetite' AND   client_type is not null");				
						

					
				/*	$delete = $con->execute("DELETE from report_m02_grade_wise_temp_table WHERE grade_code = '$grade_code' AND MINE_NAME = '$MINE_NAME' AND lessee_owner_name = '$lessee_owner_name' AND registration_no = '$registration_no'
					AND state_name = '$state_name' AND district_name = '$district_name' AND grade_name = '$grade_name' AND fromDate = '$fromDate' AND toDate = '$toDate' AND showMonth = '$showMonth'
					AND showYear = '$showYear' AND lease_area = '$lease_area' AND opening_stock = '$opening_stock' AND production = '$production' AND closing_stock = '$closing_stock' AND despatches = '$despatches' AND
					mine_code = '$mine_code' AND pmv = '$pmv' AND detail_deduction = '$detail_deduction' AND return_date = '$return_date' AND mineral_name = '$mineral_name' AND return_type = '$return_type' AND nature_use = '$nature_use' AND (client_type = ' ' or ISNULL(client_type)) AND (sale_value = ' ' OR ISNULL(sale_value)) AND (quantity = ' ' OR ISNULL(quantity))");		
					//print_r($delete);
					break;*/
				}								
			}
//print_r($delete);die	;		
			
        }
		
		
		
		$mainSelect =  $con->execute("SELECT * FROM report_m02_grade_wise_temp_table");
			$recordMainSelects = $mainSelect->fetchAll('assoc');
				
			}
            if (!empty($recordMainSelects)) {
                $this->set('records', $recordMainSelects);
                $this->set('showDate', $showDate);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
    }


    public function createfile($lhtml,$lfilenm) {
		$lext=".xlsx";
		$lwriter="Xlsx";
		
		//$filename = $_SERVER['DOCUMENT_ROOT']."/writereaddata/IBM/".$lfilenm.$lext;	//'.xlsx';
		//echo $_SERVER['DOCUMENT_ROOT'];die;
		
		//$filename = "writereaddata/".$lfilenm.$lext;	//'.xlsx';
		
		$filename = "reports/".$lfilenm.$lext;	//'.xlsx';
				
		
		//$filename = "/writereaddata1/IBM/".$lfilenm.$lext;	//'.xlsx';
		
		if (file_exists($filename)) {
			unlink($filename);
		}
		$tempfile='../tmp/tmp_repm03'.strftime("%d-%m-%Y").'.html';
		if (file_exists($tempfile)) {
			unlink($tempfile);
		}

		file_put_contents($tempfile,$lhtml);
		$reader=IOFactory::createReader('Html');
		$spreadsheet=$reader->load($tempfile);
		$writer=IOFactory::createWriter($spreadsheet,$lwriter);
		$writer->save($filename);
		unlink($tempfile);
		return $lfilenm.$lext;
	}
    public function reportM03()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $fromDate = $this->request->getData('from_date');
            $fromDate = explode(' ', $fromDate);
            $month1 = $fromDate[0];
			$month1 = $year1.$month1.'-01';
			$month01 = explode('-',$month1);
            $monthno = date('m', strtotime($month1));
            $year1 = $fromDate[1];
            $from_date = $year1 . '-' . $monthno . '-01';

            $toDate = $this->request->getData('to_date');
            $toDate = explode(' ', $toDate);
            $month2 = $toDate[0];
			$month2 = $year2.$month2.'-01';
			$month02 = explode('-',$month2);
            $monthno = date('m', strtotime($month2));
            $year2 = $toDate[1];
            $to_date = $year2 . '-' . $monthno . '-01';

            $from = $month1 . ' ' . $year1;
            $to =  $month2 . ' ' . $year2;

            $showDate = $month01[0] . ' ' . $year1 . ' To ' . $month02[0] . ' ' . $year2;

            $mineral = $this->request->getData('mineral');
            $mineral = strtolower(str_replace(' ', '_', $mineral));
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

           /* $sql = "SELECT DISTINCT p.open_oc_rom, p.open_ug_rom, p.open_dw_rom, p.clos_oc_rom, p.clos_ug_rom, p.clos_dw_rom, p.mine_code, p.prod_oc_rom, p.prod_ug_rom, p.prod_dw_rom,
            p.mineral_name, m.MINE_NAME, m.lessee_owner_name, m.registration_no, dmg.grade_name, s.state_name, d.district_name,
            '$from' AS fromDate , '$to' As toDate, ml.mcmdt_ML_Area AS lease_area, EXTRACT(MONTH FROM p.return_date)  AS showMonth, EXTRACT(YEAR FROM p.return_date)  AS showYear
            FROM
				tbl_final_submit tfs
					INNER JOIN
                mine m ON m.mine_code = tfs.mine_code
                    INNER JOIN
                dir_state s ON m.state_code = s.state_code
                    INNER JOIN
                dir_district d ON m.district_code = d.district_code
                    AND s.state_code = d.state_code					
                    INNER JOIN
                grade_prod gp ON m.mine_code = gp.mine_code
                    AND gp.return_type = '$returnType'
                    AND (gp.return_date BETWEEN '$from_date' AND '$to_date')
					 AND gp.type = 'ROM'
                    INNER JOIN
                prod_1 p ON gp.mine_code = p.mine_code
                    AND p.return_type = '$returnType'
                    AND (p.return_date BETWEEN '$from_date' AND '$to_date')
                    AND gp.return_type = p.return_type
                    AND gp.return_date = p.return_date
                    AND gp.mineral_name = p.mineral_name					 
                    INNER JOIN
                dir_mineral_grade dmg ON gp.grade_code = dmg.grade_code
                    AND gp.mineral_name = REPLACE(LOWER(dmg.mineral_name), ' ', '_')
                    AND p.mineral_name = REPLACE(LOWER(dmg.mineral_name), ' ', '_')
                    LEFT JOIN
                 mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode 
                WHERE
                p.return_type = '$returnType' AND (p.return_date BETWEEN '$from_date' AND '$to_date') AND gp.return_type = '$returnType'
                AND (gp.return_date BETWEEN '$from_date' AND '$to_date') AND tfs.is_latest = 1";*/
				
			/**
            * Change in query on 02-04-2022 added new tables rom5, rom_sale for metal_content & grade value
			* Using View named view_report_open_prod_clos_m03
			*/
             
			
					$sql = "SELECT DISTINCT
					m.MINE_NAME,
					m.lessee_owner_name,
					m.registration_no,				   
					s.state_name,
					d.district_name,
					'$from' AS fromDate , '$to' As toDate,
					ml.mcmdt_ML_Area AS lease_area,
					EXTRACT(MONTH FROM m03.return_date) AS showMonth,
					EXTRACT(YEAR FROM m03.return_date) AS showYear,
					m03.*
					FROM
					view_report_open_prod_clos_m03 m03
						INNER JOIN
					mine m ON m.mine_code = m03.mine_code
						INNER JOIN
					dir_state s ON m.state_code = s.state_code
						INNER JOIN
					dir_district d ON m.district_code = d.district_code
						AND s.state_code = d.state_code
																   
						LEFT JOIN
					mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1
					WHERE
					m03.return_type = '$returnType'
						AND (m03.return_date BETWEEN '$from_date' AND '$to_date')";
				

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND m03.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND m03.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
            $sql .= "order by m03.mineral_name,s.state_name,d.district_name,m03.return_date,m03.mine_code,m03.serial_sn";
            //print_r($sql);exit;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                $lprint=$this->generatem03($records,$showDate,$rowCount);
				$lfilenm="reportm03_".strftime("%d-%m-%Y"); //.$_SESSION['mms_user_email'];
				$lfile=$this->createfile($lprint,$lfilenm);
                $this->set('lprint',$lprint);
				$this->set('lfilenm',$lfile);
                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }
 	public function generatem03($records,$showDate,$rowCount) {
        $datarry=array();
        $lcnt=-1;
        $cnt=0;
        $lmineral_name = "";
        $lstate_name = "";
        $ldistrict_name = "";
        $lmonthnm = "";
        $lyearnm = "";
        $lmincode="";
		$lserialno="";
        $lflg="";
		$lcounter=0;
        $print="";
		$ugopary=array();		//under ground open stock
		$ocopary=array();		//open cast open stock
		$dwopary=array();		//dump working open stock
		$ugpdary=array();		//under ground production
		$ocpdary=array();		//open cast production
		$dwpdary=array();		//dump working production
		$ugclary=array();		//under ground closing stock
		$occlary=array();		//open cast closing stock
		$dwclary=array();		//dump working closing stock

        $lugopcnt=-1;			//under ground open stock   
        $locopcnt=-1;			//open cast open stock      
        $ldwopcnt=-1;			//dump working open stock   
		$lugpdcnt=-1;			//under ground production   
		$locpdcnt=-1;			//open cast production      
		$ldwpdcnt=-1;			//dump working production   
		$lugclcnt=-1;			//under ground closing stock
		$locclcnt=-1;			//open cast closing stock   
		$ldwclcnt=-1;			//dump working closing stock
		
		if($rowCount <= 15000) {
        $print='<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="tHeadFont" id="heading1">Report M03 - ROM Opening Stock, ROM Production & ROM Closing Stock</h4>
                    <div class="form-horizontal">
                        <div class="card-body" id="avb">
						    <h6 class="tHeadDate" id="heading2">Date : From '.$showDate.'</h6>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" id="tableReportm03">
                                    <thead class="tableHead">
                                        <tr>
                                            <th rowspan="2">#</th>
                                            <th rowspan="2">Month</th>
											<th rowspan="2">Mineral</th>
											<th rowspan="2">State</th>
											<th rowspan="2">District</th>                                            
                                            <th rowspan="2">Name of Mine</th>
                                            <th rowspan="2">Name of Lease Owner</th>
                                            <th rowspan="2">Lease Area</th>
											<th rowspan="2">Mine Code</th>
                                            <th rowspan="2">IBM Registration Number</th>
                                            <th colspan="9">Opening Stock</th>
											<th colspan="9">Production</th>
                                            <th colspan="9">Closing Stock</th>
                                        </tr>
                                        <tr>
											<!-- Opening Stock -->
                                            <th>Open Cast (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											
                                            <th>Underground (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											
                                            <th>Dump Working (tonnes)</th>
                                            <th>Metal Content</th>
											<th>Grade</th>
											<!-- End-->
											
											<!-- Production -->
                                            <th>Open Cast (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											
                                            <th>Underground (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											
                                            <th>Dump Working (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											<!-- End-->
											
											<!-- Closing Stock -->
											<th>Open Cast (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											
                                            <th>Underground (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											
                                            <th>Dump Working (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											<!-- End-->
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody">';
        foreach ($records as $record) {
            
            if ($lmineral_name != $record['mineral_name']) {
                $lmineral_name = $record['mineral_name'];
                $lflg="Y";
            }
            if ($lstate_name != $record['state_name']) {
                $lstate_name = $record['state_name'];
                $lflg="Y";
            }
            if ($ldistrict_name != $record['district_name']) {
                $ldistrict_name = $record['district_name'];
                $lflg="Y";
            }
            if ($lmonthnm != $record['showMonth']) {
                $lmonthnm  = $record['showMonth'];
                $lflg="Y";
            }
            if ($lyearnm != $record['showYear']) {
                $lyearnm  = $record['showYear'];
                $lflg="Y";
            }
            if ($lmincode!=$record['mine_code']) {
                $lmincode=$record['mine_code'];
                $lflg="Y";
            }
            if ((int)$record['serial_sn']<=0) {
                $lflg="Y";
				if ((int)$record['serial_sn']<=0)
					$lrowspan="";
                
            } 
			if ($lserialno!=(int)$record['serial_sn']) {
				if ($record['serial_sn']>=4 && $record['serial_sn']<=6) {
					if ($lserialno<=3 || $lserialno>=7) {
						$lflg="Y";
					}
				}
				$lserialno=$record['serial_sn'];
			}

            if ($lflg=="Y" || $lcnt <0) {
//
				if ($lcnt >=0) {
					$larcount=count($ugopary);
					if(count($ocopary) > $larcount) $larcount=count($ocopary);
					if(count($dwopary) > $larcount) $larcount=count($dwopary);
					if(count($ugpdary) > $larcount) $larcount=count($ugpdary);
					if(count($ocpdary) > $larcount) $larcount=count($ocpdary);
					if(count($dwpdary) > $larcount) $larcount=count($dwpdary);
					if(count($ugclary) > $larcount) $larcount=count($ugclary);
					if(count($occlary) > $larcount) $larcount=count($occlary);
					if(count($dwclary) > $larcount) $larcount=count($dwclary);
					$lrowspan="";
					if ($larcount>1) 
						$lrowspan=" rowspan=".$larcount."";
					$lcounter+=1;
					$print.='<tr>
						<td '.$lrowspan.'>'.$lcounter.'</td>
						<td '.$lrowspan.'>'.$monthname.'</td>	
						<td '.$lrowspan.'>'.$mineral_name.'</td>
						<td '.$lrowspan.'>'.$state_name.'</td>
						<td '.$lrowspan.'>'.$district_name.'</td>												
						<td '.$lrowspan.'>'.$MINE_NAME.'</td>
						<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
						<td '.$lrowspan.'>'.$lease_area.'</td>
						<td '.$lrowspan.'>'.$mine_code.'</td>
						<td '.$lrowspan.'>'.$registration_no.'</td>';
					for ($cnt=0;$cnt < $larcount; $cnt++) {
						if ($cnt > 0) $print.='</tr><tr>';
						//7 starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($ocopary[$cnt]['open_oc_rom']))
								$print.=$ocopary[$cnt]['open_oc_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($ocopary[$cnt]['open_oc_metal_content']))
							$print.=$ocopary[$cnt]['open_oc_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($ocopary[$cnt]['open_oc_grade']))
							$print.=$ocopary[$cnt]['open_oc_grade'];
						$print.="</td>";
						//7 ends
						//1 and 4 starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($ugopary[$cnt]['open_ug_rom']))
								$print.=$ugopary[$cnt]['open_ug_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($ugopary[$cnt]['open_ug_metal_content']))
							$print.=$ugopary[$cnt]['open_ug_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($ugopary[$cnt]['open_ug_grade']))
							$print.=$ugopary[$cnt]['open_ug_grade'];
						$print.="</td>";
						//1 and 4 ends
						//0 dw starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($dwopary[$cnt]['open_dw_rom']))
								$print.=$dwopary[$cnt]['open_dw_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($dwopary[$cnt]['open_dw_metal_content']))
							$print.=$dwopary[$cnt]['open_dw_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($dwopary[$cnt]['open_dw_grade']))
							$print.=$dwopary[$cnt]['open_dw_grade'];
						$print.="</td>";
						//0 dw ends
						//8 oc production starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($ocpdary[$cnt]['prod_oc_rom']))
								$print.=$ocpdary[$cnt]['prod_oc_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($ocpdary[$cnt]['prod_oc_metal_content']))
							$print.=$ocpdary[$cnt]['prod_oc_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($ocpdary[$cnt]['prod_oc_grade']))
							$print.=$ocpdary[$cnt]['prod_oc_grade'];
						$print.="</td>";
						//8 oc production ends
						//2 or 5 ug production starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($ugpdary[$cnt]['prod_ug_rom']))
								$print.=$ugpdary[$cnt]['prod_ug_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($ugpdary[$cnt]['prod_ug_metal_content']))
							$print.=$ugpdary[$cnt]['prod_ug_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($ugpdary[$cnt]['prod_ug_grade']))
							$print.=$ugpdary[$cnt]['prod_ug_grade'];
						$print.="</td>";
						//2 or 5 ug production ends
						// dw production starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($dwpdary[$cnt]['prod_dw_rom']))
								$print.=$dwpdary[$cnt]['prod_dw_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($dwpdary[$cnt]['prod_dw_metal_content']))
							$print.=$dwpdary[$cnt]['prod_dw_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($dwpdary[$cnt]['prod_dw_grade']))
							$print.=$dwpdary[$cnt]['prod_dw_grade'];
						$print.="</td>";
						// dw production ends
						//9 oc clossing starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($occlary[$cnt]['clos_oc_rom']))
								$print.=$occlary[$cnt]['clos_oc_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($occlary[$cnt]['clos_oc_metal_content']))
							$print.=$occlary[$cnt]['clos_oc_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($occlary[$cnt]['clos_oc_grade']))
							$print.=$occlary[$cnt]['clos_oc_grade'];
						$print.="</td>";
						//9 oc clossing ends
						//3 or 6 ug clossing starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($ugclary[$cnt]['clos_ug_rom']))
								$print.=$ugclary[$cnt]['clos_ug_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($ugclary[$cnt]['clos_ug_metal_content']))
							$print.=$ugclary[$cnt]['clos_ug_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($ugclary[$cnt]['clos_ug_grade']))
							$print.=$ugclary[$cnt]['clos_ug_grade'];
						$print.="</td>";
						//3 or 6 ug clossing ends
						// dw clossing starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($dwclary[$cnt]['clos_dw_rom']))
								$print.=$dwclary[$cnt]['clos_dw_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($dwclary[$cnt]['clos_dw_metal_content']))
							$print.=$dwclary[$cnt]['clos_dw_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($dwclary[$cnt]['clos_dw_grade']))
							$print.=$dwclary[$cnt]['clos_dw_grade'];
						$print.="</td>";
						// dw clossing ends
					}
					if ($cnt >0) $print.='</tr>';

				}

//
                $lcnt++;
                $lflg="";
                $cnt=0;
				$dbj   = \DateTime::createFromFormat('!m', $record['showMonth']);										  
				//Format it to month name
				$monthName = $dbj->format('F');
				//$monthName = $record['showMonth'];
                $monthname=$monthName.' '.$record['showYear'];	
                $mineral_name=ucwords(str_replace('_', ' ', $record['mineral_name']));
                $state_name=$record['state_name']; 
                $district_name=$record['district_name']; 
                $MINE_NAME=$record['MINE_NAME'] ;
                $lessee_owner_name=$record['lessee_owner_name'];
                $lease_area=$record['lease_area'];
                $mine_code=$record['mine_code'];
                $registration_no=$record['registration_no'];

				$ugopary=array();		//under ground open stock
				$ocopary=array();		//open cast open stock
				$dwopary=array();		//dump working open stock
				$ugpdary=array();		//under ground production
				$ocpdary=array();		//open cast production
				$dwpdary=array();		//dump working production
				$ugclary=array();		//under ground closing stock
				$occlary=array();		//open cast closing stock
				$dwclary=array();		//dump working closing stock

				$lugopcnt=-1;			//under ground open stock   
				$locopcnt=-1;			//open cast open stock      
				$ldwopcnt=-1;			//dump working open stock   
				$lugpdcnt=-1;			//under ground production   
				$locpdcnt=-1;			//open cast production      
				$ldwpdcnt=-1;			//dump working production   
				$lugclcnt=-1;			//under ground closing stock
				$locclcnt=-1;			//open cast closing stock   
				$ldwclcnt=-1;			//dump working closing stock

            }
            if ((int)$record['serial_sn']<=0) {
				$lugopcnt=0;			//under ground open stock   
				$locopcnt=0;			//open cast open stock      
				$ldwopcnt=0;			//dump working open stock   
				$lugpdcnt=0;			//under ground production   
				$locpdcnt=0;			//open cast production      
				$ldwpdcnt=0;			//dump working production   
				$lugclcnt=0;			//under ground closing stock
				$locclcnt=0;			//open cast closing stock   
				$ldwclcnt=0;			//dump working closing stock
				$ugopary[$lugopcnt]['open_ug_rom']=$record['open_ug_rom'];
				$ugopary[$lugopcnt]['open_ug_metal_content']=$record['open_ug_metal_content'];
				$ugopary[$lugopcnt]['open_ug_grade']=$record['open_ug_grade'];
				$ocopary[$locopcnt]['open_oc_rom']=$record['open_oc_rom'];
				$ocopary[$locopcnt]['open_oc_metal_content']=$record['open_oc_metal_content'];
				$ocopary[$locopcnt]['open_oc_grade']=$record['open_oc_grade'];
				$dwopary[$ldwopcnt]['open_dw_rom']=$record['open_dw_rom'];
				$dwopary[$ldwopcnt]['open_dw_metal_content']="";
				$dwopary[$ldwopcnt]['open_dw_grade']="";
				$ugpdary[$lugpdcnt]['prod_ug_rom']=$record['prod_ug_rom'];
				$ugpdary[$lugpdcnt]['prod_ug_metal_content']=$record['prod_ug_metal_content'];
				$ugpdary[$lugpdcnt]['prod_ug_grade']=$record['prod_ug_grade'];
				$ocpdary[$locpdcnt]['prod_oc_rom']=$record['prod_oc_rom'];
				$ocpdary[$locpdcnt]['prod_oc_metal_content']=$record['prod_oc_metal_content'];
				$ocpdary[$locpdcnt]['prod_oc_grade']=$record['prod_oc_grade'];
				$dwpdary[$ldwpdcnt]['prod_dw_rom']=$record['prod_dw_rom'];
				$dwpdary[$ldwpdcnt]['prod_dw_metal_content']="";
				$dwpdary[$ldwpdcnt]['prod_dw_grade']="";
				$ugclary[$lugclcnt]['clos_ug_rom']=$record['clos_ug_rom'];
				$ugclary[$lugclcnt]['clos_ug_metal_content']=$record['clos_ug_metal_content'];
				$ugclary[$lugclcnt]['clos_ug_grade']=$record['clos_ug_grade'];
				$occlary[$locclcnt]['clos_oc_rom']=$record['clos_oc_rom'];	
				$occlary[$locclcnt]['clos_oc_metal_content']=$record['clos_oc_metal_content'];	
				$occlary[$locclcnt]['clos_oc_grade']=$record['clos_oc_grade'];	
				$dwclary[$ldwclcnt]['clos_dw_rom']=$record['clos_dw_rom'];
				$dwclary[$ldwclcnt]['clos_dw_metal_content']="";
				$dwclary[$ldwclcnt]['clos_dw_grade']="";				
            } 
            if ((int)$record['serial_sn']==1 || (int)$record['serial_sn']==4) { 
				$lugopcnt+=1;
				$ugopary[$lugopcnt]['open_ug_rom']=$record['open_ug_rom'];
				$ugopary[$lugopcnt]['open_ug_metal_content']=$record['open_ug_metal_content'];
				$ugopary[$lugopcnt]['open_ug_grade']=$record['open_ug_grade'];

            }
            if ((int)$record['serial_sn']==2 || (int)$record['serial_sn']==5) {
				$lugpdcnt+=1;
				$ugpdary[$lugpdcnt]['prod_ug_rom']=$record['prod_ug_rom'];
				$ugpdary[$lugpdcnt]['prod_ug_metal_content']=$record['prod_ug_metal_content'];
				$ugpdary[$lugpdcnt]['prod_ug_grade']=$record['prod_ug_grade'];

            }
            if ((int)$record['serial_sn']==3 || (int)$record['serial_sn']==6) {
				$lugclcnt+=1;
				$ugclary[$lugclcnt]['clos_ug_rom']=$record['clos_ug_rom'];
				$ugclary[$lugclcnt]['clos_ug_metal_content']=$record['clos_ug_metal_content'];
				$ugclary[$lugclcnt]['clos_ug_grade']=$record['clos_ug_grade'];

            }

            if ((int)$record['serial_sn']==7) {   
				$locopcnt+=1;
				$ocopary[$locopcnt]['open_oc_rom']=$record['open_oc_rom'];
				$ocopary[$locopcnt]['open_oc_metal_content']=$record['open_oc_metal_content'];
				$ocopary[$locopcnt]['open_oc_grade']=$record['open_oc_grade'];
            }
            if ((int)$record['serial_sn']==8) { 
				$locpdcnt+=1;
				$ocpdary[$locpdcnt]['prod_oc_rom']=$record['prod_oc_rom'];
				$ocpdary[$locpdcnt]['prod_oc_metal_content']=$record['prod_oc_metal_content'];
				$ocpdary[$locpdcnt]['prod_oc_grade']=$record['prod_oc_grade'];


            }  
            if ((int)$record['serial_sn']==9) {  
				$locclcnt+=1;
				$occlary[$locclcnt]['clos_oc_rom']=$record['clos_oc_rom'];	
				$occlary[$locclcnt]['clos_oc_metal_content']=$record['clos_oc_metal_content'];	
				$occlary[$locclcnt]['clos_oc_grade']=$record['clos_oc_grade'];
            }            
			
        }
		if ($lcnt >=0) {
			$larcount=count($ugopary);
			if(count($ocopary) > $larcount) $larcount=count($ocopary);
			if(count($dwopary) > $larcount) $larcount=count($dwopary);
			if(count($ugpdary) > $larcount) $larcount=count($ugpdary);
			if(count($ocpdary) > $larcount) $larcount=count($ocpdary);
			if(count($dwpdary) > $larcount) $larcount=count($dwpdary);
			if(count($ugclary) > $larcount) $larcount=count($ugclary);
			if(count($occlary) > $larcount) $larcount=count($occlary);
			if(count($dwclary) > $larcount) $larcount=count($dwclary);
			$lrowspan="";
			if ($larcount>1) 
				$lrowspan=" rowspan=".$larcount."";
			$lcounter+=1;
			$print.='<tr>
				<td '.$lrowspan.'>'.$lcounter.'</td>
				<td '.$lrowspan.'>'.$monthname.'</td>	
				<td '.$lrowspan.'>'.$mineral_name.'</td>
				<td '.$lrowspan.'>'.$state_name.'</td>
				<td '.$lrowspan.'>'.$district_name.'</td>												
				<td '.$lrowspan.'>'.$MINE_NAME.'</td>
				<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
				<td '.$lrowspan.'>'.$lease_area.'</td>
				<td '.$lrowspan.'>'.$mine_code.'</td>
				<td '.$lrowspan.'>'.$registration_no.'</td>';
			for ($cnt=0;$cnt < $larcount; $cnt++) {
				if ($cnt > 0) $print.='</tr><tr>';
				//7 starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($ocopary[$cnt]['open_oc_rom']))
						$print.=$ocopary[$cnt]['open_oc_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($ocopary[$cnt]['open_oc_metal_content']))
					$print.=$ocopary[$cnt]['open_oc_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($ocopary[$cnt]['open_oc_grade']))
					$print.=$ocopary[$cnt]['open_oc_grade'];
				$print.="</td>";
				//7 ends
				//1 and 4 starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($ugopary[$cnt]['open_ug_rom']))
						$print.=$ugopary[$cnt]['open_ug_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($ugopary[$cnt]['open_ug_metal_content']))
					$print.=$ugopary[$cnt]['open_ug_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($ugopary[$cnt]['open_ug_grade']))
					$print.=$ugopary[$cnt]['open_ug_grade'];
				$print.="</td>";
				//1 and 4 ends
				//0 dw starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($dwopary[$cnt]['open_dw_rom']))
						$print.=$dwopary[$cnt]['open_dw_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($dwopary[$cnt]['open_dw_metal_content']))
					$print.=$dwopary[$cnt]['open_dw_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($dwopary[$cnt]['open_dw_grade']))
					$print.=$dwopary[$cnt]['open_dw_grade'];
				$print.="</td>";
				//0 dw ends
				//8 oc production starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($ocpdary[$cnt]['prod_oc_rom']))
						$print.=$ocpdary[$cnt]['prod_oc_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($ocpdary[$cnt]['prod_oc_metal_content']))
					$print.=$ocpdary[$cnt]['prod_oc_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($ocpdary[$cnt]['prod_oc_grade']))
					$print.=$ocpdary[$cnt]['prod_oc_grade'];
				$print.="</td>";
				//8 oc production ends
				//2 or 5 ug production starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($ugpdary[$cnt]['prod_ug_rom']))
						$print.=$ugpdary[$cnt]['prod_ug_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($ugpdary[$cnt]['prod_ug_metal_content']))
					$print.=$ugpdary[$cnt]['prod_ug_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($ugpdary[$cnt]['prod_ug_grade']))
					$print.=$ugpdary[$cnt]['prod_ug_grade'];
				$print.="</td>";
				//2 or 5 ug production ends
				// dw production starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($dwpdary[$cnt]['prod_dw_rom']))
						$print.=$dwpdary[$cnt]['prod_dw_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($dwpdary[$cnt]['prod_dw_metal_content']))
					$print.=$dwpdary[$cnt]['prod_dw_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($dwpdary[$cnt]['prod_dw_grade']))
					$print.=$dwpdary[$cnt]['prod_dw_grade'];
				$print.="</td>";
				// dw production ends
				//9 oc clossing starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($occlary[$cnt]['clos_oc_rom']))
						$print.=$occlary[$cnt]['clos_oc_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($occlary[$cnt]['clos_oc_metal_content']))
					$print.=$occlary[$cnt]['clos_oc_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($occlary[$cnt]['clos_oc_grade']))
					$print.=$occlary[$cnt]['clos_oc_grade'];
				$print.="</td>";
				//9 oc clossing ends
				//3 or 6 ug clossing starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($ugclary[$cnt]['clos_ug_rom']))
						$print.=$ugclary[$cnt]['clos_ug_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($ugclary[$cnt]['clos_ug_metal_content']))
					$print.=$ugclary[$cnt]['clos_ug_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($ugclary[$cnt]['clos_ug_grade']))
					$print.=$ugclary[$cnt]['clos_ug_grade'];
				$print.="</td>";
				//3 or 6 ug clossing ends
				// dw clossing starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($dwclary[$cnt]['clos_dw_rom']))
						$print.=$dwclary[$cnt]['clos_dw_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($dwclary[$cnt]['clos_dw_metal_content']))
					$print.=$dwclary[$cnt]['clos_dw_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($dwclary[$cnt]['clos_dw_grade']))
					$print.=$dwclary[$cnt]['clos_dw_grade'];
				$print.="</td>";
				// dw clossing ends
			}
			if ($cnt >0) $print.='</tr>';

		}
        $print.='</tbody>
        </table>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>';
		} else {
			$print='<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="tHeadFont" id="heading1">Report M03 - ROM Opening Stock, ROM Production & ROM Closing Stock</h4>
                    <div class="form-horizontal">
                        <div class="card-body" id="avb">
						    <h6 class="tHeadDate" id="heading2">Date : From '.$showDate.'</h6>
							
							<h6 class="tHeadDate" id="heading2"><strong>Since records are more hence no search & pagination service is available, you may use the option "Export to Excel"</strong></h6>
							<input type="button" id="downloadExcel" value="Export to Excel">
							<br /><br />
								
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" border="1" id="noDatatable">
                                    <thead class="tableHead">
										<tr>
											<th colspan="37" class="noDisplay" align="left">Report M03 - ROM Opening Stock, ROM Production & ROM Closing Stock  Date : From '.$showDate.'</th>
										</tr>
                                        <tr>
                                            <th rowspan="2">#</th>
                                            <th rowspan="2">Month</th>
											<th rowspan="2">Mineral</th>
											<th rowspan="2">State</th>
											<th rowspan="2">District</th>                                            
                                            <th rowspan="2">Name of Mine</th>
                                            <th rowspan="2">Name of Lease Owner</th>
                                            <th rowspan="2">Lease Area</th>
											<th rowspan="2">Mine Code</th>
                                            <th rowspan="2">IBM Registration Number</th>
                                            <th colspan="9">Opening Stock</th>
											<th colspan="9">Production</th>
                                            <th colspan="9">Closing Stock</th>
                                        </tr>
                                        <tr>
											<!-- Opening Stock -->
                                            <th>Open Cast (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											
                                            <th>Underground (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											
                                            <th>Dump Working (tonnes)</th>
                                            <th>Metal Content</th>
											<th>Grade</th>
											<!-- End-->
											
											<!-- Production -->
                                            <th>Open Cast (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											
                                            <th>Underground (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											
                                            <th>Dump Working (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											<!-- End-->
											
											<!-- Closing Stock -->
											<th>Open Cast (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											
                                            <th>Underground (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											
                                            <th>Dump Working (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											<!-- End-->
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody">';
        foreach ($records as $record) {
            
            if ($lmineral_name != $record['mineral_name']) {
                $lmineral_name = $record['mineral_name'];
                $lflg="Y";
            }
            if ($lstate_name != $record['state_name']) {
                $lstate_name = $record['state_name'];
                $lflg="Y";
            }
            if ($ldistrict_name != $record['district_name']) {
                $ldistrict_name = $record['district_name'];
                $lflg="Y";
            }
            if ($lmonthnm != $record['showMonth']) {
                $lmonthnm  = $record['showMonth'];
                $lflg="Y";
            }
            if ($lyearnm != $record['showYear']) {
                $lyearnm  = $record['showYear'];
                $lflg="Y";
            }
            if ($lmincode!=$record['mine_code']) {
                $lmincode=$record['mine_code'];
                $lflg="Y";
            }
            if ((int)$record['serial_sn']<=0) {
                $lflg="Y";
				if ((int)$record['serial_sn']<=0)
					$lrowspan="";
                
            } 
			if ($lserialno!=(int)$record['serial_sn']) {
				if ($record['serial_sn']>=4 && $record['serial_sn']<=6) {
					if ($lserialno<=3 || $lserialno>=7) {
						$lflg="Y";
					}
				}
				$lserialno=$record['serial_sn'];
			}

            if ($lflg=="Y" || $lcnt <0) {
//
				if ($lcnt >=0) {
					$larcount=count($ugopary);
					if(count($ocopary) > $larcount) $larcount=count($ocopary);
					if(count($dwopary) > $larcount) $larcount=count($dwopary);
					if(count($ugpdary) > $larcount) $larcount=count($ugpdary);
					if(count($ocpdary) > $larcount) $larcount=count($ocpdary);
					if(count($dwpdary) > $larcount) $larcount=count($dwpdary);
					if(count($ugclary) > $larcount) $larcount=count($ugclary);
					if(count($occlary) > $larcount) $larcount=count($occlary);
					if(count($dwclary) > $larcount) $larcount=count($dwclary);
					$lrowspan="";
					if ($larcount>1) 
						$lrowspan=" rowspan=".$larcount."";
					$lcounter+=1;
					$print.='<tr>
						<td '.$lrowspan.'>'.$lcounter.'</td>
						<td '.$lrowspan.'>'.$monthname.'</td>	
						<td '.$lrowspan.'>'.$mineral_name.'</td>
						<td '.$lrowspan.'>'.$state_name.'</td>
						<td '.$lrowspan.'>'.$district_name.'</td>												
						<td '.$lrowspan.'>'.$MINE_NAME.'</td>
						<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
						<td '.$lrowspan.'>'.$lease_area.'</td>
						<td '.$lrowspan.'>'.$mine_code.'</td>
						<td '.$lrowspan.'>'.$registration_no.'</td>';
					for ($cnt=0;$cnt < $larcount; $cnt++) {
						if ($cnt > 0) $print.='</tr><tr>';
						//7 starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($ocopary[$cnt]['open_oc_rom']))
								$print.=$ocopary[$cnt]['open_oc_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($ocopary[$cnt]['open_oc_metal_content']))
							$print.=$ocopary[$cnt]['open_oc_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($ocopary[$cnt]['open_oc_grade']))
							$print.=$ocopary[$cnt]['open_oc_grade'];
						$print.="</td>";
						//7 ends
						//1 and 4 starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($ugopary[$cnt]['open_ug_rom']))
								$print.=$ugopary[$cnt]['open_ug_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($ugopary[$cnt]['open_ug_metal_content']))
							$print.=$ugopary[$cnt]['open_ug_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($ugopary[$cnt]['open_ug_grade']))
							$print.=$ugopary[$cnt]['open_ug_grade'];
						$print.="</td>";
						//1 and 4 ends
						//0 dw starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($dwopary[$cnt]['open_dw_rom']))
								$print.=$dwopary[$cnt]['open_dw_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($dwopary[$cnt]['open_dw_metal_content']))
							$print.=$dwopary[$cnt]['open_dw_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($dwopary[$cnt]['open_dw_grade']))
							$print.=$dwopary[$cnt]['open_dw_grade'];
						$print.="</td>";
						//0 dw ends
						//8 oc production starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($ocpdary[$cnt]['prod_oc_rom']))
								$print.=$ocpdary[$cnt]['prod_oc_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($ocpdary[$cnt]['prod_oc_metal_content']))
							$print.=$ocpdary[$cnt]['prod_oc_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($ocpdary[$cnt]['prod_oc_grade']))
							$print.=$ocpdary[$cnt]['prod_oc_grade'];
						$print.="</td>";
						//8 oc production ends
						//2 or 5 ug production starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($ugpdary[$cnt]['prod_ug_rom']))
								$print.=$ugpdary[$cnt]['prod_ug_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($ugpdary[$cnt]['prod_ug_metal_content']))
							$print.=$ugpdary[$cnt]['prod_ug_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($ugpdary[$cnt]['prod_ug_grade']))
							$print.=$ugpdary[$cnt]['prod_ug_grade'];
						$print.="</td>";
						//2 or 5 ug production ends
						// dw production starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($dwpdary[$cnt]['prod_dw_rom']))
								$print.=$dwpdary[$cnt]['prod_dw_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($dwpdary[$cnt]['prod_dw_metal_content']))
							$print.=$dwpdary[$cnt]['prod_dw_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($dwpdary[$cnt]['prod_dw_grade']))
							$print.=$dwpdary[$cnt]['prod_dw_grade'];
						$print.="</td>";
						// dw production ends
						//9 oc clossing starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($occlary[$cnt]['clos_oc_rom']))
								$print.=$occlary[$cnt]['clos_oc_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($occlary[$cnt]['clos_oc_metal_content']))
							$print.=$occlary[$cnt]['clos_oc_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($occlary[$cnt]['clos_oc_grade']))
							$print.=$occlary[$cnt]['clos_oc_grade'];
						$print.="</td>";
						//9 oc clossing ends
						//3 or 6 ug clossing starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($ugclary[$cnt]['clos_ug_rom']))
								$print.=$ugclary[$cnt]['clos_ug_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($ugclary[$cnt]['clos_ug_metal_content']))
							$print.=$ugclary[$cnt]['clos_ug_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($ugclary[$cnt]['clos_ug_grade']))
							$print.=$ugclary[$cnt]['clos_ug_grade'];
						$print.="</td>";
						//3 or 6 ug clossing ends
						// dw clossing starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($dwclary[$cnt]['clos_dw_rom']))
								$print.=$dwclary[$cnt]['clos_dw_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($dwclary[$cnt]['clos_dw_metal_content']))
							$print.=$dwclary[$cnt]['clos_dw_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($dwclary[$cnt]['clos_dw_grade']))
							$print.=$dwclary[$cnt]['clos_dw_grade'];
						$print.="</td>";
						// dw clossing ends
					}
					if ($cnt >0) $print.='</tr>';

				}

//
                $lcnt++;
                $lflg="";
                $cnt=0;
				$dbj   = \DateTime::createFromFormat('!m', $record['showMonth']);										  
				//Format it to month name
				$monthName = $dbj->format('F');
				//$monthName = $record['showMonth'];
                $monthname=$monthName.' '.$record['showYear'];	
                $mineral_name=ucwords(str_replace('_', ' ', $record['mineral_name']));
                $state_name=$record['state_name']; 
                $district_name=$record['district_name']; 
                $MINE_NAME=$record['MINE_NAME'] ;
                $lessee_owner_name=$record['lessee_owner_name'];
                $lease_area=$record['lease_area'];
                $mine_code=$record['mine_code'];
                $registration_no=$record['registration_no'];

				$ugopary=array();		//under ground open stock
				$ocopary=array();		//open cast open stock
				$dwopary=array();		//dump working open stock
				$ugpdary=array();		//under ground production
				$ocpdary=array();		//open cast production
				$dwpdary=array();		//dump working production
				$ugclary=array();		//under ground closing stock
				$occlary=array();		//open cast closing stock
				$dwclary=array();		//dump working closing stock

				$lugopcnt=-1;			//under ground open stock   
				$locopcnt=-1;			//open cast open stock      
				$ldwopcnt=-1;			//dump working open stock   
				$lugpdcnt=-1;			//under ground production   
				$locpdcnt=-1;			//open cast production      
				$ldwpdcnt=-1;			//dump working production   
				$lugclcnt=-1;			//under ground closing stock
				$locclcnt=-1;			//open cast closing stock   
				$ldwclcnt=-1;			//dump working closing stock

            }
            if ((int)$record['serial_sn']<=0) {
				$lugopcnt=0;			//under ground open stock   
				$locopcnt=0;			//open cast open stock      
				$ldwopcnt=0;			//dump working open stock   
				$lugpdcnt=0;			//under ground production   
				$locpdcnt=0;			//open cast production      
				$ldwpdcnt=0;			//dump working production   
				$lugclcnt=0;			//under ground closing stock
				$locclcnt=0;			//open cast closing stock   
				$ldwclcnt=0;			//dump working closing stock
				$ugopary[$lugopcnt]['open_ug_rom']=$record['open_ug_rom'];
				$ugopary[$lugopcnt]['open_ug_metal_content']=$record['open_ug_metal_content'];
				$ugopary[$lugopcnt]['open_ug_grade']=$record['open_ug_grade'];
				$ocopary[$locopcnt]['open_oc_rom']=$record['open_oc_rom'];
				$ocopary[$locopcnt]['open_oc_metal_content']=$record['open_oc_metal_content'];
				$ocopary[$locopcnt]['open_oc_grade']=$record['open_oc_grade'];
				$dwopary[$ldwopcnt]['open_dw_rom']=$record['open_dw_rom'];
				$dwopary[$ldwopcnt]['open_dw_metal_content']="";
				$dwopary[$ldwopcnt]['open_dw_grade']="";
				$ugpdary[$lugpdcnt]['prod_ug_rom']=$record['prod_ug_rom'];
				$ugpdary[$lugpdcnt]['prod_ug_metal_content']=$record['prod_ug_metal_content'];
				$ugpdary[$lugpdcnt]['prod_ug_grade']=$record['prod_ug_grade'];
				$ocpdary[$locpdcnt]['prod_oc_rom']=$record['prod_oc_rom'];
				$ocpdary[$locpdcnt]['prod_oc_metal_content']=$record['prod_oc_metal_content'];
				$ocpdary[$locpdcnt]['prod_oc_grade']=$record['prod_oc_grade'];
				$dwpdary[$ldwpdcnt]['prod_dw_rom']=$record['prod_dw_rom'];
				$dwpdary[$ldwpdcnt]['prod_dw_metal_content']="";
				$dwpdary[$ldwpdcnt]['prod_dw_grade']="";
				$ugclary[$lugclcnt]['clos_ug_rom']=$record['clos_ug_rom'];
				$ugclary[$lugclcnt]['clos_ug_metal_content']=$record['clos_ug_metal_content'];
				$ugclary[$lugclcnt]['clos_ug_grade']=$record['clos_ug_grade'];
				$occlary[$locclcnt]['clos_oc_rom']=$record['clos_oc_rom'];	
				$occlary[$locclcnt]['clos_oc_metal_content']=$record['clos_oc_metal_content'];	
				$occlary[$locclcnt]['clos_oc_grade']=$record['clos_oc_grade'];	
				$dwclary[$ldwclcnt]['clos_dw_rom']=$record['clos_dw_rom'];
				$dwclary[$ldwclcnt]['clos_dw_metal_content']="";
				$dwclary[$ldwclcnt]['clos_dw_grade']="";				
            } 
            if ((int)$record['serial_sn']==1 || (int)$record['serial_sn']==4) { 
				$lugopcnt+=1;
				$ugopary[$lugopcnt]['open_ug_rom']=$record['open_ug_rom'];
				$ugopary[$lugopcnt]['open_ug_metal_content']=$record['open_ug_metal_content'];
				$ugopary[$lugopcnt]['open_ug_grade']=$record['open_ug_grade'];

            }
            if ((int)$record['serial_sn']==2 || (int)$record['serial_sn']==5) {
				$lugpdcnt+=1;
				$ugpdary[$lugpdcnt]['prod_ug_rom']=$record['prod_ug_rom'];
				$ugpdary[$lugpdcnt]['prod_ug_metal_content']=$record['prod_ug_metal_content'];
				$ugpdary[$lugpdcnt]['prod_ug_grade']=$record['prod_ug_grade'];

            }
            if ((int)$record['serial_sn']==3 || (int)$record['serial_sn']==6) {
				$lugclcnt+=1;
				$ugclary[$lugclcnt]['clos_ug_rom']=$record['clos_ug_rom'];
				$ugclary[$lugclcnt]['clos_ug_metal_content']=$record['clos_ug_metal_content'];
				$ugclary[$lugclcnt]['clos_ug_grade']=$record['clos_ug_grade'];

            }

            if ((int)$record['serial_sn']==7) {   
				$locopcnt+=1;
				$ocopary[$locopcnt]['open_oc_rom']=$record['open_oc_rom'];
				$ocopary[$locopcnt]['open_oc_metal_content']=$record['open_oc_metal_content'];
				$ocopary[$locopcnt]['open_oc_grade']=$record['open_oc_grade'];
            }
            if ((int)$record['serial_sn']==8) { 
				$locpdcnt+=1;
				$ocpdary[$locpdcnt]['prod_oc_rom']=$record['prod_oc_rom'];
				$ocpdary[$locpdcnt]['prod_oc_metal_content']=$record['prod_oc_metal_content'];
				$ocpdary[$locpdcnt]['prod_oc_grade']=$record['prod_oc_grade'];


            }  
            if ((int)$record['serial_sn']==9) {  
				$locclcnt+=1;
				$occlary[$locclcnt]['clos_oc_rom']=$record['clos_oc_rom'];	
				$occlary[$locclcnt]['clos_oc_metal_content']=$record['clos_oc_metal_content'];	
				$occlary[$locclcnt]['clos_oc_grade']=$record['clos_oc_grade'];
            }            
			
        }
		if ($lcnt >=0) {
			$larcount=count($ugopary);
			if(count($ocopary) > $larcount) $larcount=count($ocopary);
			if(count($dwopary) > $larcount) $larcount=count($dwopary);
			if(count($ugpdary) > $larcount) $larcount=count($ugpdary);
			if(count($ocpdary) > $larcount) $larcount=count($ocpdary);
			if(count($dwpdary) > $larcount) $larcount=count($dwpdary);
			if(count($ugclary) > $larcount) $larcount=count($ugclary);
			if(count($occlary) > $larcount) $larcount=count($occlary);
			if(count($dwclary) > $larcount) $larcount=count($dwclary);
			$lrowspan="";
			if ($larcount>1) 
				$lrowspan=" rowspan=".$larcount."";
			$lcounter+=1;
			$print.='<tr>
				<td '.$lrowspan.'>'.$lcounter.'</td>
				<td '.$lrowspan.'>'.$monthname.'</td>	
				<td '.$lrowspan.'>'.$mineral_name.'</td>
				<td '.$lrowspan.'>'.$state_name.'</td>
				<td '.$lrowspan.'>'.$district_name.'</td>												
				<td '.$lrowspan.'>'.$MINE_NAME.'</td>
				<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
				<td '.$lrowspan.'>'.$lease_area.'</td>
				<td '.$lrowspan.'>'.$mine_code.'</td>
				<td '.$lrowspan.'>'.$registration_no.'</td>';
			for ($cnt=0;$cnt < $larcount; $cnt++) {
				if ($cnt > 0) $print.='</tr><tr>';
				//7 starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($ocopary[$cnt]['open_oc_rom']))
						$print.=$ocopary[$cnt]['open_oc_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($ocopary[$cnt]['open_oc_metal_content']))
					$print.=$ocopary[$cnt]['open_oc_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($ocopary[$cnt]['open_oc_grade']))
					$print.=$ocopary[$cnt]['open_oc_grade'];
				$print.="</td>";
				//7 ends
				//1 and 4 starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($ugopary[$cnt]['open_ug_rom']))
						$print.=$ugopary[$cnt]['open_ug_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($ugopary[$cnt]['open_ug_metal_content']))
					$print.=$ugopary[$cnt]['open_ug_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($ugopary[$cnt]['open_ug_grade']))
					$print.=$ugopary[$cnt]['open_ug_grade'];
				$print.="</td>";
				//1 and 4 ends
				//0 dw starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($dwopary[$cnt]['open_dw_rom']))
						$print.=$dwopary[$cnt]['open_dw_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($dwopary[$cnt]['open_dw_metal_content']))
					$print.=$dwopary[$cnt]['open_dw_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($dwopary[$cnt]['open_dw_grade']))
					$print.=$dwopary[$cnt]['open_dw_grade'];
				$print.="</td>";
				//0 dw ends
				//8 oc production starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($ocpdary[$cnt]['prod_oc_rom']))
						$print.=$ocpdary[$cnt]['prod_oc_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($ocpdary[$cnt]['prod_oc_metal_content']))
					$print.=$ocpdary[$cnt]['prod_oc_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($ocpdary[$cnt]['prod_oc_grade']))
					$print.=$ocpdary[$cnt]['prod_oc_grade'];
				$print.="</td>";
				//8 oc production ends
				//2 or 5 ug production starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($ugpdary[$cnt]['prod_ug_rom']))
						$print.=$ugpdary[$cnt]['prod_ug_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($ugpdary[$cnt]['prod_ug_metal_content']))
					$print.=$ugpdary[$cnt]['prod_ug_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($ugpdary[$cnt]['prod_ug_grade']))
					$print.=$ugpdary[$cnt]['prod_ug_grade'];
				$print.="</td>";
				//2 or 5 ug production ends
				// dw production starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($dwpdary[$cnt]['prod_dw_rom']))
						$print.=$dwpdary[$cnt]['prod_dw_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($dwpdary[$cnt]['prod_dw_metal_content']))
					$print.=$dwpdary[$cnt]['prod_dw_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($dwpdary[$cnt]['prod_dw_grade']))
					$print.=$dwpdary[$cnt]['prod_dw_grade'];
				$print.="</td>";
				// dw production ends
				//9 oc clossing starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($occlary[$cnt]['clos_oc_rom']))
						$print.=$occlary[$cnt]['clos_oc_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($occlary[$cnt]['clos_oc_metal_content']))
					$print.=$occlary[$cnt]['clos_oc_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($occlary[$cnt]['clos_oc_grade']))
					$print.=$occlary[$cnt]['clos_oc_grade'];
				$print.="</td>";
				//9 oc clossing ends
				//3 or 6 ug clossing starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($ugclary[$cnt]['clos_ug_rom']))
						$print.=$ugclary[$cnt]['clos_ug_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($ugclary[$cnt]['clos_ug_metal_content']))
					$print.=$ugclary[$cnt]['clos_ug_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($ugclary[$cnt]['clos_ug_grade']))
					$print.=$ugclary[$cnt]['clos_ug_grade'];
				$print.="</td>";
				//3 or 6 ug clossing ends
				// dw clossing starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($dwclary[$cnt]['clos_dw_rom']))
						$print.=$dwclary[$cnt]['clos_dw_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($dwclary[$cnt]['clos_dw_metal_content']))
					$print.=$dwclary[$cnt]['clos_dw_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($dwclary[$cnt]['clos_dw_grade']))
					$print.=$dwclary[$cnt]['clos_dw_grade'];
				$print.="</td>";
				// dw clossing ends
			}
			if ($cnt >0) $print.='</tr>';

		}
        $print.='</tbody>
        </table>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>';
		}

		return $print;
	}
	
	
	public function createfileM04($lhtml,$lfilenm) {
		$lext=".xlsx";
		$lwriter="Xlsx";
		
		//$filename = $_SERVER['DOCUMENT_ROOT']."/writereaddata/IBM/".$lfilenm.$lext;	//'.xlsx';
		//echo $_SERVER['DOCUMENT_ROOT'];die;
		
		//$filename = "writereaddata/".$lfilenm.$lext;	//'.xlsx';
		
		$filename = "reports/".$lfilenm.$lext;	//'.xlsx';
				
		
		//$filename = "/writereaddata1/IBM/".$lfilenm.$lext;	//'.xlsx';
		
		if (file_exists($filename)) {
			unlink($filename);
		}
		$tempfile='../tmp/tmp_repm04'.strftime("%d-%m-%Y").'.html';
		if (file_exists($tempfile)) {
			unlink($tempfile);
		}

		file_put_contents($tempfile,$lhtml);
		$reader=IOFactory::createReader('Html');
		$spreadsheet=$reader->load($tempfile);
		$writer=IOFactory::createWriter($spreadsheet,$lwriter);
		$writer->save($filename);
		unlink($tempfile);
		return $lfilenm.$lext;
	}
	
    public function reportM04()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $fromDate = $this->request->getData('from_date');
            $fromDate = explode(' ', $fromDate);
            $month1 = $fromDate[0];
			$month1 = $year1.$month1.'-01';
			$month01 = explode('-',$month1);
            $monthno = date('m', strtotime($month1));
            $year1 = $fromDate[1];
            $from_date = $year1 . '-' . $monthno . '-01';

            $toDate = $this->request->getData('to_date');
            $toDate = explode(' ', $toDate);
            $month2 = $toDate[0];
			$month2 = $year2.$month2.'-01';
			$month02 = explode('-',$month2);
            $monthno = date('m', strtotime($month2));
            $year2 = $toDate[1];
            $to_date = $year2 . '-' . $monthno . '-01';

            $from = $month1 . ' ' . $year1;
            $to =  $month2 . ' ' . $year2;

            $showDate = $month01[0] . ' ' . $year1 . ' To ' . $month02[0] . ' ' . $year2;

            $mineral = $this->request->getData('mineral');
            $mineral = strtolower($mineral);
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            //  Changes query on 06-04-2022 by Shweta Apale
            $sql = "SELECT m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name,
            EXTRACT(MONTH FROM r5.return_date)  AS showMonth, EXTRACT(YEAR FROM r5.return_date)  AS showYear, ml.mcmdt_ML_Area AS lease_area, r5.mine_code, r5.mineral_name, r5.tot_qty,
            r5.grade, r5.metal_content, r5.rom_5_step_sn, '' AS value, r5.return_date
            FROM
            tbl_final_submit tfs
			   INNER JOIN rom_5 r5 on r5.mine_code = tfs.mine_code
			   AND tfs.return_type = 'MONTHLY'
                INNER JOIN
            mine m ON m.mine_code = r5.mine_code
                INNER JOIN
            dir_state s ON m.state_code = s.state_code
                INNER JOIN
            dir_district d ON m.district_code = d.district_code
                AND d.state_code = s.state_code
                  LEFT JOIN
            mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1 
            WHERE
            r5.return_type = '$returnType'
                AND (r5.return_date BETWEEN '$from_date' AND '$to_date')
                AND r5.rom_5_step_sn > 9 AND tfs.is_latest = 1 AND tfs.return_type = 'MONTHLY'";
			if($mineral != ''){
				$sql .= " AND r5.mineral_name = '$mineral'";
				}
				
           $sql .=" UNION SELECT m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, EXTRACT(MONTH FROM rm.return_date)  AS showMonth, EXTRACT(YEAR FROM rm.return_date)  AS showYear,
            ml.mcmdt_ML_Area AS lease_area, rm.mine_code, rm.mineral_name, rm.qty, rm.grade, rm.metal_name, rm.rom_5_step_sn, rm.value, rm.return_date
            FROM
            tbl_final_submit tfs
			   INNER JOIN rom_metal_5 rm on rm.mine_code = tfs.mine_code
			   AND tfs.return_type = 'MONTHLY'
                INNER JOIN
            mine m ON m.mine_code = rm.mine_code
                INNER JOIN
            dir_state s ON m.state_code = s.state_code
                INNER JOIN
            dir_district d ON m.district_code = d.district_code
                AND d.state_code = s.state_code
                  LEFT JOIN
            mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1 
            WHERE
             (rm.return_date BETWEEN '$from_date' AND '$to_date')
                AND rm.return_type = '$returnType' AND tfs.is_latest = 1 AND tfs.return_type = 'MONTHLY'";
				
				if($mineral != ''){
				$sql .= " AND rm.mineral_name = '$mineral'";
				}
				
            $sql .=" UNION SELECT m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, EXTRACT(MONTH FROM rs.return_date)  AS showMonth, EXTRACT(YEAR FROM rs.return_date)  AS showYear,
            ml.mcmdt_ML_Area AS lease_area, rs.mine_code, rs.mineral_name, rs.qty, rs.grade, rs.type_concentrate AS metal_content,
            rs.smelter_step_sn AS rom_step_sn_5, rs.value, rs.return_date
            FROM
            tbl_final_submit tfs
			   INNER JOIN recov_smelter rs on rs.mine_code = tfs.mine_code
			   AND tfs.return_type = 'MONTHLY'
                INNER JOIN
            mine m ON m.mine_code = rs.mine_code
                INNER JOIN
            dir_state s ON m.state_code = s.state_code
                INNER JOIN
            dir_district d ON m.district_code = d.district_code
                AND d.state_code = s.state_code
                LEFT JOIN
            mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1 
            WHERE
             (rs.return_date BETWEEN '$from_date' AND '$to_date')
                AND rs.return_type = '$returnType' AND  tfs.is_latest = 1 AND tfs.return_type = 'MONTHLY'";
				if($mineral != ''){
				$sql .= " AND rs.mineral_name = '$mineral'";
				}

            // $sql = "SELECT DISTINCT r5.mineral_name, r5.mine_code, m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name,
            // d.district_name, '$from' AS fromDate , '$to' As toDate, (ml.under_forest_area + ml.outside_forest_area) AS lease_area, EXTRACT(MONTH FROM rs.return_date)  AS showMonth, EXTRACT(YEAR FROM rs.return_date)  AS showYear,
            // CASE
            //     WHEN r5.rom_5_step_sn = 10 THEN r5.tot_qty
            // END AS open_stock_qty,
            // CASE
            //     WHEN r5.rom_5_step_sn = 10 THEN r5.metal_content
            // END AS open_stock_metal,
            //  CASE
            //     WHEN r5.rom_5_step_sn = 10 THEN r5.grade
            // END AS open_stock_metal_grade,
            // CASE
            //     WHEN r5.rom_5_step_sn = 11 THEN r5.tot_qty
            // END AS ore_rec_qty,
            // CASE
            //     WHEN r5.rom_5_step_sn = 11 THEN r5.metal_content
            // END AS ore_rec_metal,
            // CASE
            //     WHEN r5.rom_5_step_sn = 11 THEN  r5.grade
            // END AS ore_rec_metal_grade,
            // CASE
            //     WHEN r5.rom_5_step_sn = 12 THEN r5.tot_qty
            // END AS ore_treat_qty,
            // CASE
            //     WHEN r5.rom_5_step_sn = 12 THEN r5.metal_content
            // END AS ore_treat_metal,
            //  CASE
            //     WHEN r5.rom_5_step_sn = 12 THEN r5.grade
            // END AS ore_treat_metal_grade,
            // CASE
            //     WHEN r5.rom_5_step_sn = 13 THEN r5.tot_qty
            // END AS concentrate_obtain_qty,
            // CASE
            //     WHEN r5.rom_5_step_sn = 13 THEN r5.metal_content
            // END AS concentrate_obtain_metal,
            //  CASE
            //     WHEN r5.rom_5_step_sn = 13 THEN  r5.grade
            // END AS concentrate_obtain_metal_grade,
            // CASE
            //     WHEN r5.rom_5_step_sn = 14 THEN r5.tot_qty
            // END AS tail_qty,
            // CASE
            //     WHEN r5.rom_5_step_sn = 14 THEN r5.metal_content
            // END AS tail_metal,
            // CASE
            //     WHEN r5.rom_5_step_sn = 14 THEN r5.grade
            // END AS tail_metal_grade,
            // CASE
            //     WHEN r5.rom_5_step_sn = 15 THEN r5.tot_qty
            // END AS clos_stock_qty,
            // CASE
            //     WHEN r5.rom_5_step_sn = 15 THEN r5.metal_content
            // END AS clos_stock_metal,
            //  CASE
            //     WHEN r5.rom_5_step_sn = 15 THEN r5.grade
            // END AS clos_stock_metal_grade,
            // CASE
            //     WHEN rs.smelter_step_sn = 1 THEN rs.qty
            // END AS qyt_open_smelter,
            // CASE
            //     WHEN rs.smelter_step_sn = 1 THEN rs.grade
            // END AS metal_open_smelter,
			// (CASE
			// 	WHEN (`rs`.`smelter_step_sn` = 1) THEN `rs`.`type_concentrate`
			// END) AS `qyt_open_smelter_metal`,
            // CASE
            //     WHEN rs.smelter_step_sn = 2 THEN rs.qty
            // END AS concentrate_rec_qty,
            // CASE
            //     WHEN rs.smelter_step_sn = 2 THEN rs.grade
            // END AS concentrate_rec_metal,
			// (CASE
            // WHEN (`rs`.`smelter_step_sn` = 3) THEN `rs`.`qty`
			// END) AS `concentrate_other_src_qty`,
			// (CASE
			// 	WHEN (`rs`.`smelter_step_sn` = 3) THEN `rs`.`grade`
			// END) AS `concentrate_other_src_grade`,
            // CASE
            //     WHEN rs.smelter_step_sn = 4 THEN rs.qty
            // END AS concentrate_sold_qty,
            // CASE
            //     WHEN rs.smelter_step_sn = 4 THEN rs.grade
            // END AS concentrate_sold_metal,
            // CASE
            //     WHEN rs.smelter_step_sn = 5 THEN rs.qty
            // END AS concentrate_treat_qty,
            // CASE
            //     WHEN rs.smelter_step_sn = 5 THEN rs.grade
            // END AS concentrate_treat_metal,
            // CASE
            //     WHEN rs.smelter_step_sn = 6 THEN rs.qty
            // END AS qyt_close_smelter,
            // CASE
            //     WHEN rs.smelter_step_sn = 6 THEN rs.grade
            // END AS metal_close_smelter,
            // CASE
            //     WHEN rs.smelter_step_sn = 7 THEN rs.qty
            // END AS other_prod_qty,
            // CASE
            //     WHEN rs.smelter_step_sn = 7 THEN rs.grade
            // END AS other_prod_grade,
            // CASE
            //     WHEN rs.smelter_step_sn = 7 THEN rs.value
            // END AS other_prod_value,
			// (CASE
            // WHEN (`rs`.`smelter_step_sn` = 7) THEN `rs`.`type_concentrate`
			// 	END) AS `other_prod_grade_metal`,
            // CASE
            //     WHEN rs.smelter_step_sn = 6 THEN rs.qty
            // END AS metal_recover_qty,
            // CASE
            //     WHEN rs.smelter_step_sn = 6 THEN rs.grade
            // END AS metal_recover_grade,
			// (CASE
			// 	WHEN (`rs`.`smelter_step_sn` = 6) THEN `rs`.`type_concentrate`
			// END) AS `metal_recover_qty_metal`,
            // CASE
            //     WHEN rs.smelter_step_sn = 6 THEN rs.value
            // END AS metal_recover_value
            // FROM
            //     mine m
            //         INNER JOIN
            //     dir_state s ON m.state_code = s.state_code
            //         INNER JOIN
            //     dir_district d ON m.district_code = d.district_code
            //         AND d.state_code = s.state_code
            //         INNER JOIN
            //     rom_5 r5 ON m.mine_code = r5.mine_code
            //         AND (r5.return_date BETWEEN '$from_date' AND '$to_date')
            //         AND r5.return_type = '$returnType'
            //         INNER JOIN
            //     recov_smelter rs ON rs.mine_code = r5.mine_code
            //         AND (rs.return_date BETWEEN '$from_date' AND '$to_date')
            //         AND rs.return_type = '$returnType'
            //         AND r5.return_type = rs.return_type
            //         AND r5.return_date = rs.return_date
            //         LEFT JOIN
            //     mcp_lease ml ON m.mine_code = ml.mine_code
            //         AND r5.mine_code = ml.mine_code
            //         AND rs.mine_code = ml.mine_code
            // WHERE
            //     r5.return_type = '$returnType' AND (rs.return_date BETWEEN '$from_date' AND '$to_date')";
            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND rs.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND rs.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
            $sql .= "order by mineral_name,state_name,district_name,return_date,mine_code,rom_5_step_sn, metal_content";

			// print_r($sql);exit;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $lprint=$this->generatem04($records,$showDate,$rowCount);
				$lfilenm="reportm04_".strftime("%d-%m-%Y"); //.$_SESSION['mms_user_email'];
				$lfile=$this->createfileM04($lprint,$lfilenm);
                $this->set('lprint',$lprint);	
				$this->set('lfilenm',$lfilenm);				
                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }
		public function generatem04($records,$showDate,$rowCount) {
		$datarry=array();
        $lcnt=-1;
        $cnt=0;
		$lcounter=0;
        $lmineral_name = "";
        $lstate_name = "";
        $ldistrict_name = "";
        $lmonthnm = "";
        $lyearnm = "";
        $lmincode="";
		$lserialno="";
        $lflg="";
        $print="";
		
		$oreopstk=array();		//Opening Stock of the Ore at concentrator/plant
		$orerecmine=array();		//Ore received from the Mine
		$oretreatcp=array();		//Ore treated at concentrator plant
		$concobtain=array();		//Concentrates Obtained
		$trailing=array();		//Tailing
		$clstkcpnt=array();		//Closing Stock of Concentrate at Concentrator/Plant
		$opstkspnt=array();		//Opening Stock of Concentrates at Smelter/Plant
		$cntrecpnt=array();		//Concentrates Received from Concentrator/plant
		$cntrecoth=array();		//Concentrates Received from other sources(specify)
		$cntsold=array();		//Concentrates Sold (if any)
		$cnttreat=array();		//Concentrates Treated
		$clstkspnt=array();		//Closing Stock of Concentrate at the smelter/plant
		$metlrecvd=array();		//Metal Recoverd (specify)
		$othprodrec=array();		//Other by Products if any recovered
		$lrcnt1=-1;
		$lrcnt2=-1;
		$lrcnt3=-1;
		$lrcnt4=-1;
		$lrcnt5=-1;

		$lrcnt6=-1;
		$lrcnt7=-1;
		$lrcnt8=-1;
		$lrcnt10=-1;
		$lrcnt11=-1;
		$lrcnt12=-1;
		$lrcnt13=-1;
		$lrcnt14=-1;
		$lrcnt15=-1;
		
		if($rowCount <= 15000) {
		$print='<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<h4 class="tHeadFont" id="heading1">Report M04 - Mine to Smelter Details (Ore to Metal)</h4>
						<div class="form-horizontal">
							<div class="card-body" id="avb">
								<h6 class="tHeadDate"  id="heading2">Date : From '.$showDate.'</h6>
								<div class="table-responsive">
									<table class="table table-striped table-hover table-bordered compact" id="tableReport">
										<thead class="tableHead">
											<tr>
												<th rowspan="2">#</th>
												<th rowspan="2">Month</th>
												<th rowspan="2">Mineral</th>
												<th rowspan="2">State</th>
												<th rowspan="2">District</th>
												<th rowspan="2">Name of Mine</th>
												<th rowspan="2">Name of Lease Owner</th>
												<th rowspan="2">Lease Area</th>
												<th rowspan="2">Mine Code</th>
												<th rowspan="2">IBM Registration Number</th>
												<th colspan="3"> Opening Stock of the Ore at concentrator/plant</th>
												<th colspan="3">Ore received from the Mine</th>
												<th colspan="3">Ore treated at concentrator plant</th>
												<th colspan="4">Concentrates Obtained</th>
												<th colspan="3">Tailing</th>
												<th colspan="3">Closing Stock of Concentrate at Concentrator/Plant</th>
												<th colspan="3">Opening Stock of Concentrates at Smelter/Plant</th>
												<th colspan="2">Concentrates Received from Concentrator/plant</th>
												<th colspan="2">Concentrates Received from other sources(specify)</th>
												<th colspan="2">Concentrates Sold (if any)</th>
												<th colspan="2">Concentrates Treated</th>
												<th colspan="2">Closing Stock of Concentrate at the smelter/plant</th>
												<th colspan="4">Metal Recoverd (specify)</th>
												<th colspan="4">Other by Products if any recovered</th>
											</tr>
											<tr>
												<th>Quantity(tonnes)</th>
												<th colspan="2">Metal Content/Grade</th>
												<th>Quantity(tonnes)</th>
												<th colspan="2">Metal Content / Grade</th>
												<th>Quantity(tonnes)</th>
												<th colspan="2">Metal Content / Grade</th>
												<th>Quantity(tonnes)</th>
												<th colspan="2">Metal Content / Grade</th>
												<th>Value</th>
												<th>Quantity(tonnes)</th>
												<th colspan="2">Metal Content / Grade</th>
												<th>Quantity(tonnes)</th>
												<th colspan="2">Metal Content / Grade</th>
												<th>Metal</th>
												<th>Quantity(tonnes)</th>
												<th>Metal Content/Grade</th>
												<th>Quantity(tonnes)</th>
												<th>Metal Content/Grade</th>
												<th>Quantity(tonnes)</th>
												<th>Metal Content/Grade</th>
												<th>Quantity(tonnes)</th>
												<th>Metal Content/Grade</th>
												<th>Quantity(tonnes)</th>
												<th>Metal Content/Grade</th>
												<th>Quantity(tonnes)</th>
												<th>Metal Content/Grade</th>
												<th>Metal</th>
												<th>Quantity(tonnes)</th>
												<th>Grade</th>
												<th> Value(Rs)</th>
												<th>Metal</th>
												<th>Quantity(tonnes)</th>
												<th>Grade</th>
												<th> Value(Rs)</th>
											</tr>

										</thead>
										<tbody class="tableBody">';
        foreach ($records as $record) {
            
            if ($lmineral_name != $record['mineral_name']) {
                $lmineral_name = $record['mineral_name'];
                $lflg="Y";
            }
            if ($lstate_name != $record['state_name']) {
                $lstate_name = $record['state_name'];
                $lflg="Y";
            }
            if ($ldistrict_name != $record['district_name']) {
                $ldistrict_name = $record['district_name'];
                $lflg="Y";
            }
            if ($lmonthnm != $record['showMonth']) {
                $lmonthnm  = $record['showMonth'];
                $lflg="Y";
            }
            if ($lyearnm != $record['showYear']) {
                $lyearnm  = $record['showYear'];
                $lflg="Y";
            }
            if ($lmincode!=$record['mine_code']) {
                $lmincode=$record['mine_code'];
                $lflg="Y";
            }


            if ($lflg=="Y" || $lcnt <0) {
                if ($lcnt >=0) {
					$larcount=count($oreopstk);
					if (count($orerecmine) >$larcount) $larcount=count($orerecmine);
					if (count($oretreatcp) >$larcount) $larcount=count($oretreatcp);
					if (count($concobtain) >$larcount) $larcount=count($concobtain);
					if (count($trailing)   >$larcount) $larcount=count($trailing);
					if (count($clstkcpnt)  >$larcount) $larcount=count($clstkcpnt);
					if (count($opstkspnt)  >$larcount) $larcount=count($opstkspnt);
					if (count($cntrecpnt)  >$larcount) $larcount=count($cntrecpnt);
					if (count($cntrecoth)  >$larcount) $larcount=count($cntrecoth);
					if (count($cntsold)    >$larcount) $larcount=count($cntsold);
					if (count($cnttreat)   >$larcount) $larcount=count($cnttreat);
					if (count($clstkspnt)  >$larcount) $larcount=count($clstkspnt);
					if (count($metlrecvd)  >$larcount) $larcount=count($metlrecvd);
					if (count($othprodrec) >$larcount) $larcount=count($othprodrec);
					$lrowspan="";
					if ($larcount>1) 
						$lrowspan=" rowspan=".$larcount."";
				$lcounter+=1;					
				$print.='<tr>
					<td '.$lrowspan.'>'.$lcounter.'</td>
					<td '.$lrowspan.'>'.$monthname.'</td>	
					<td '.$lrowspan.'>'.$mineral_name.'</td>
					<td '.$lrowspan.'>'.$state_name.'</td>
					<td '.$lrowspan.'>'.$district_name.'</td>												
					<td '.$lrowspan.'>'.$MINE_NAME.'</td>
					<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
					<td '.$lrowspan.'>'.$lease_area.'</td>
					<td '.$lrowspan.'>'.$mine_code.'</td>
					<td '.$lrowspan.'>'.$registration_no.'</td>';
					for ($cnt=0;$cnt < $larcount; $cnt++) {
						if ($cnt > 0) $print.='</tr><tr>';
						//10 starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($oreopstk[$cnt]['open_stock_qty']))
								$print.=$oreopstk[$cnt]['open_stock_qty'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($oreopstk[$cnt]['open_stock_metal']))
							$print.=$oreopstk[$cnt]['open_stock_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($oreopstk[$cnt]['open_stock_metal_grade']))
							$print.=$oreopstk[$cnt]['open_stock_metal_grade'];
						$print.="</td>";
						//10 ends
						//11 starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($orerecmine[$cnt]['ore_rec_qty']))
								$print.=$orerecmine[$cnt]['ore_rec_qty'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($orerecmine[$cnt]['ore_rec_metal']))
							$print.=$orerecmine[$cnt]['ore_rec_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($orerecmine[$cnt]['ore_rec_metal_grade']))
							$print.=$orerecmine[$cnt]['ore_rec_metal_grade'];
						$print.="</td>";
						//11 ends
						//12 starts					
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($oretreatcp[$cnt]['ore_treat_qty']))
								$print.=$oretreatcp[$cnt]['ore_treat_qty'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($oretreatcp[$cnt]['ore_treat_metal']))
							$print.=$oretreatcp[$cnt]['ore_treat_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($oretreatcp[$cnt]['ore_treat_metal_grade']))
							$print.=$oretreatcp[$cnt]['ore_treat_metal_grade'];
						$print.="</td>";
						//12 end

						//13 start
						$print.="<td>";
						if (isset($concobtain[$cnt]['concentrate_obtain_metal']))
							$print.=$concobtain[$cnt]['concentrate_obtain_metal'];
						$print.="</td>";
				
						$print.="<td>";
						if (isset($concobtain[$cnt]['concentrate_obtain_qty']))
							$print.=$concobtain[$cnt]['concentrate_obtain_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($concobtain[$cnt]['concentrate_obtain_metal_grade']))
							$print.=$concobtain[$cnt]['concentrate_obtain_metal_grade'];
						$print.="</td>";
						$print.="<td>";
						if (isset($concobtain[$cnt]['concentrate_obtain_value']))
							$print.=$concobtain[$cnt]['concentrate_obtain_value'];
						$print.="</td>";
						//13 end
						//14 start
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";

							if (isset($trailing[$cnt]['tail_qty']))
								$print.=$trailing[$cnt]['tail_qty'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($trailing[$cnt]['tail_metal']))
							$print.=$trailing[$cnt]['tail_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($trailing[$cnt]['tail_metal_grade']))
							$print.=$trailing[$cnt]['tail_metal_grade'];
						$print.="</td>";
						//14 end
						//15 start
						$print.="<td>";
						if (isset($clstkcpnt[$cnt]['clos_stock_qty']))
							$print.=$clstkcpnt[$cnt]['clos_stock_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($clstkcpnt[$cnt]['clos_stock_metal']))
							$print.=$clstkcpnt[$cnt]['clos_stock_metal'];
						$print.="</td>";						
						$print.="<td>";
						if (isset($clstkcpnt[$cnt]['clos_stock_metal_grade']))
							$print.=$clstkcpnt[$cnt]['clos_stock_metal_grade'];
						$print.="</td>";
						//15 end
						//1 start
						$print.="<td>";
						if (isset($opstkspnt[$cnt]['qyt_open_smelter_metal']))
							$print.=$opstkspnt[$cnt]['qyt_open_smelter_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($opstkspnt[$cnt]['qyt_open_smelter']))
							$print.=$opstkspnt[$cnt]['qyt_open_smelter'];
						$print.="</td>";
						$print.="<td>";
						if (isset($opstkspnt[$cnt]['metal_open_smelter']))
							$print.=$opstkspnt[$cnt]['metal_open_smelter'];
						$print.="</td>";
						//1 end
						//2 start
						$print.="<td>";
						if (isset($cntrecpnt[$cnt]['concentrate_rec_qty']))
							$print.=$cntrecpnt[$cnt]['concentrate_rec_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($cntrecpnt[$cnt]['concentrate_rec_metal']))
							$print.=$cntrecpnt[$cnt]['concentrate_rec_metal'];
						$print.="</td>";
						//2 end
						//3 start
						$print.="<td>";
						if (isset($cntrecoth[$cnt]['concentrate_other_src_qty']))
							$print.=$cntrecoth[$cnt]['concentrate_other_src_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($cntrecoth[$cnt]['concentrate_other_src_grade']))
							$print.=$cntrecoth[$cnt]['concentrate_other_src_grade'];
						$print.="</td>";
						//3 end
						//4 start
						$print.="<td>";
						if (isset($cntsold[$cnt]['concentrate_sold_qty']))
							$print.=$cntsold[$cnt]['concentrate_sold_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($cntsold[$cnt]['concentrate_sold_metal']))
							$print.=$cntsold[$cnt]['concentrate_sold_metal'];
						$print.="</td>";
						//4 end
						//5 start
						$print.="<td>";
						if (isset($cnttreat[$cnt]['concentrate_treat_qty']))
							$print.=$cnttreat[$cnt]['concentrate_treat_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($cnttreat[$cnt]['concentrate_treat_metal']))
							$print.=$cnttreat[$cnt]['concentrate_treat_metal'];
						$print.="</td>";
						//5 end
						//8 start
						$print.="<td>";
						if (isset($clstkspnt[$cnt]['qyt_close_smelter']))
							$print.=$clstkspnt[$cnt]['qyt_close_smelter'];
						$print.="</td>";
						$print.="<td>";
						if (isset($clstkspnt[$cnt]['metal_close_smelter']))
							$print.=$clstkspnt[$cnt]['metal_close_smelter'];
						$print.="</td>";
						//8 end
						//6 start
						$print.="<td>";
						if (isset($metlrecvd[$cnt]['metal_recover_qty_metal']))
							$print.=$metlrecvd[$cnt]['metal_recover_qty_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($metlrecvd[$cnt]['metal_recover_qty']))
							$print.=$metlrecvd[$cnt]['metal_recover_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($metlrecvd[$cnt]['metal_recover_grade']))
							$print.=$metlrecvd[$cnt]['metal_recover_grade'];
						$print.="</td>";
						$print.="<td>";
						if (isset($metlrecvd[$cnt]['metal_recover_value']))
							$print.=$metlrecvd[$cnt]['metal_recover_value'];
						$print.="</td>";
						//6 end
						//7 start
						$print.="<td>";
						if (isset($othprodrec[$cnt]['other_prod_grade_metal']))
							$print.=$othprodrec[$cnt]['other_prod_grade_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($othprodrec[$cnt]['other_prod_qty']))
							$print.=$othprodrec[$cnt]['other_prod_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($othprodrec[$cnt]['other_prod_grade']))
							$print.=$othprodrec[$cnt]['other_prod_grade'];
						$print.="</td>";
						$print.="<td>";
						if (isset($othprodrec[$cnt]['other_prod_value']))
							$print.=$othprodrec[$cnt]['other_prod_value'];
						$print.="</td>";
						//7 end

					}
					if ($cnt >0) $print.='</tr>';
                }
                $lcnt++;
                $lflg="";
                $cnt=0;
				$dbj   = \DateTime::createFromFormat('!m', $record['showMonth']);										  
				//Format it to month name
				$monthName = $dbj->format('F');
				//$monthName = $record['showMonth'];
                $monthname=$monthName.' '.$record['showYear'];	
                $mineral_name=ucwords(str_replace('_', ' ', $record['mineral_name']));
                $state_name=$record['state_name']; 
                $district_name=$record['district_name']; 
                $MINE_NAME=$record['MINE_NAME'] ;
                $lessee_owner_name=$record['lessee_owner_name'];
                $lease_area=$record['lease_area'];
                $mine_code=$record['mine_code'];
                $registration_no=$record['registration_no']; 
				$oreopstk=array();		//Opening Stock of the Ore at concentrator/plant
				$orerecmine=array();		//Ore received from the Mine
				$oretreatcp=array();		//Ore treated at concentrator plant
				$concobtain=array();		//Concentrates Obtained
				$trailing=array();		//Tailing
				$clstkcpnt=array();		//Closing Stock of Concentrate at Concentrator/Plant
				$opstkspnt=array();		//Opening Stock of Concentrates at Smelter/Plant
				$cntrecpnt=array();		//Concentrates Received from Concentrator/plant
				$cntrecoth=array();		//Concentrates Received from other sources(specify)
				$cntsold=array();		//Concentrates Sold (if any)
				$cnttreat=array();		//Concentrates Treated
				$clstkspnt=array();		//Closing Stock of Concentrate at the smelter/plant
				$metlrecvd=array();		//Metal Recoverd (specify)
				$othprodrec=array();		//Other by Products if any recovered				
				$lrcnt1=-1;
				$lrcnt2=-1;
				$lrcnt3=-1;
				$lrcnt4=-1;
				$lrcnt5=-1;

				$lrcnt6=-1;
				$lrcnt7=-1;
				$lrcnt8=-1;
				$lrcnt10=-1;
				$lrcnt11=-1;
				$lrcnt12=-1;
				$lrcnt13=-1;
				$lrcnt14=-1;
				$lrcnt15=-1;

            }
            if ((int)$record['rom_5_step_sn']==1) { 
				$lrcnt1+=1;
				$opstkspnt[$lrcnt1]['qyt_open_smelter']=$record['tot_qty'];
				$opstkspnt[$lrcnt1]['metal_open_smelter']=$record['grade'];
				$opstkspnt[$lrcnt1]['qyt_open_smelter_metal']=$record['metal_content'];
            }
            if ((int)$record['rom_5_step_sn']==2) { 
				$lrcnt2+=1;
				$cntrecpnt[$lrcnt2]['concentrate_rec_qty']=$record['tot_qty'];
				$cntrecpnt[$lrcnt2]['concentrate_rec_metal']=$record['grade'];
            }          
            if ((int)$record['rom_5_step_sn']==3) { 
				$lrcnt3+=1;
				$cntrecoth[$lrcnt3]['concentrate_other_src_qty']=$record['tot_qty'];
				$cntrecoth[$lrcnt3]['concentrate_other_src_grade']=$record['grade'];
            }
            if ((int)$record['rom_5_step_sn']==4) { 
				$lrcnt4+=1;
				$cntsold[$lrcnt4]['concentrate_sold_qty']=$record['tot_qty'];
				$cntsold[$lrcnt4]['concentrate_sold_metal']=$record['grade'];

            }
            if ((int)$record['rom_5_step_sn']==5) { 
				$lrcnt5+=1;
				$cnttreat[$lrcnt5]['concentrate_treat_qty']=$record['tot_qty'];
				$cnttreat[$lrcnt5]['concentrate_treat_metal']=$record['grade'];
            }
            if ((int)$record['rom_5_step_sn']==6) { 
				$lrcnt6+=1;
				$metlrecvd[$lrcnt6]['metal_recover_qty_metal']=$record['metal_content'];
				$metlrecvd[$lrcnt6]['metal_recover_qty']=$record['tot_qty'];
				$metlrecvd[$lrcnt6]['metal_recover_grade']=$record['grade'];
				$metlrecvd[$lrcnt6]['metal_recover_value']=$record['value'];
            }	
            if ((int)$record['rom_5_step_sn']==7) { 
				$lrcnt7+=1;
				$othprodrec[$lrcnt7]['other_prod_grade_metal']=$record['metal_content'];
				$othprodrec[$lrcnt7]['other_prod_qty']=$record['tot_qty'];
				$othprodrec[$lrcnt7]['other_prod_grade']=$record['grade'];
				$othprodrec[$lrcnt7]['other_prod_value']=$record['value'];
            }
            if ((int)$record['rom_5_step_sn']==8) { 
				$lrcnt8+=1;
				$clstkspnt[$lrcnt8]['qyt_close_smelter']=$record['tot_qty'];
				//as discussed dated on 12-04-22 use value column instead of grade
				//$clstkspnt[$lrcnt8]['metal_close_smelter']=$record['grade'];
				$clstkspnt[$lrcnt8]['metal_close_smelter']=$record['value'];

            }
            if ((int)$record['rom_5_step_sn']==10) { 
				$lrcnt10+=1;
				$oreopstk[$lrcnt10]['open_stock_qty']=$record['tot_qty'];
				$oreopstk[$lrcnt10]['open_stock_metal']=$record['metal_content'];
				$oreopstk[$lrcnt10]['open_stock_metal_grade']=$record['grade'];
            }		
            if ((int)$record['rom_5_step_sn']==11) { 
				$lrcnt11+=1;
				$orerecmine[$lrcnt11]['ore_rec_qty']=$record['tot_qty'];
				$orerecmine[$lrcnt11]['ore_rec_metal']=$record['metal_content'];
				$orerecmine[$lrcnt11]['ore_rec_metal_grade']=$record['grade'];
            }	
            if ((int)$record['rom_5_step_sn']==12) { 
				$lrcnt12+=1;
				$oretreatcp[$lrcnt12]['ore_treat_qty']=$record['tot_qty'];
				$oretreatcp[$lrcnt12]['ore_treat_metal']=$record['metal_content'];
				$oretreatcp[$lrcnt12]['ore_treat_metal_grade']=$record['grade'];
            }
            if ((int)$record['rom_5_step_sn']==13) { 
				$lrcnt13+=1;
				$concobtain[$lrcnt13]['concentrate_obtain_metal']=$record['metal_content'];
				$concobtain[$lrcnt13]['concentrate_obtain_qty']=$record['tot_qty'];
				$concobtain[$lrcnt13]['concentrate_obtain_metal_grade']=$record['grade'];
				$concobtain[$lrcnt13]['concentrate_obtain_value']=$record['value'];
            }
            if ((int)$record['rom_5_step_sn']==14) { 
				$lrcnt14+=1;
				$trailing[$lrcnt14]['tail_qty']=$record['tot_qty'];
				$trailing[$lrcnt14]['tail_metal']=$record['metal_content'];
				$trailing[$lrcnt14]['tail_metal_grade']=$record['grade'];
            }
            if ((int)$record['rom_5_step_sn']==15) { 
				$lrcnt15+=1;
				$clstkcpnt[$lrcnt15]['clos_stock_metal']=$record['metal_content'];
				$clstkcpnt[$lrcnt15]['clos_stock_qty']=$record['tot_qty'];
				$clstkcpnt[$lrcnt15]['clos_stock_metal_grade']=$record['grade'];

            }
			
			
        }
		if ($lcnt >=0) {
			$larcount=count($oreopstk);
			if (count($orerecmine) >$larcount) $larcount=count($orerecmine);
			if (count($oretreatcp) >$larcount) $larcount=count($oretreatcp);
			if (count($concobtain) >$larcount) $larcount=count($concobtain);
			if (count($trailing)   >$larcount) $larcount=count($trailing);
			if (count($clstkcpnt)  >$larcount) $larcount=count($clstkcpnt);
			if (count($opstkspnt)  >$larcount) $larcount=count($opstkspnt);
			if (count($cntrecpnt)  >$larcount) $larcount=count($cntrecpnt);
			if (count($cntrecoth)  >$larcount) $larcount=count($cntrecoth);
			if (count($cntsold)    >$larcount) $larcount=count($cntsold);
			if (count($cnttreat)   >$larcount) $larcount=count($cnttreat);
			if (count($clstkspnt)  >$larcount) $larcount=count($clstkspnt);
			if (count($metlrecvd)  >$larcount) $larcount=count($metlrecvd);
			if (count($othprodrec) >$larcount) $larcount=count($othprodrec);
			$lrowspan="";
			if ($larcount>1) 
				$lrowspan=" rowspan=".$larcount."";
		$lcounter+=1;
		$print.='<tr>
			<td '.$lrowspan.'>'.$lcounter.'</td>
			<td '.$lrowspan.'>'.$monthname.'</td>	
			<td '.$lrowspan.'>'.$mineral_name.'</td>
			<td '.$lrowspan.'>'.$state_name.'</td>
			<td '.$lrowspan.'>'.$district_name.'</td>												
			<td '.$lrowspan.'>'.$MINE_NAME.'</td>
			<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
			<td '.$lrowspan.'>'.$lease_area.'</td>
			<td '.$lrowspan.'>'.$mine_code.'</td>
			<td '.$lrowspan.'>'.$registration_no.'</td>';
			for ($cnt=0;$cnt < $larcount; $cnt++) {
				if ($cnt > 0) $print.='</tr><tr>';
				//10 starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($oreopstk[$cnt]['open_stock_qty']))
						$print.=$oreopstk[$cnt]['open_stock_qty'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($oreopstk[$cnt]['open_stock_metal']))
					$print.=$oreopstk[$cnt]['open_stock_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($oreopstk[$cnt]['open_stock_metal_grade']))
					$print.=$oreopstk[$cnt]['open_stock_metal_grade'];
				$print.="</td>";
				//10 ends
				//11 starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($orerecmine[$cnt]['ore_rec_qty']))
						$print.=$orerecmine[$cnt]['ore_rec_qty'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($orerecmine[$cnt]['ore_rec_metal']))
					$print.=$orerecmine[$cnt]['ore_rec_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($orerecmine[$cnt]['ore_rec_metal_grade']))
					$print.=$orerecmine[$cnt]['ore_rec_metal_grade'];
				$print.="</td>";
				//11 ends
				//12 starts	 				
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($oretreatcp[$cnt]['ore_treat_qty']))
						$print.=$oretreatcp[$cnt]['ore_treat_qty'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($oretreatcp[$cnt]['ore_treat_metal']))
					$print.=$oretreatcp[$cnt]['ore_treat_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($oretreatcp[$cnt]['ore_treat_metal_grade']))
					$print.=$oretreatcp[$cnt]['ore_treat_metal_grade'];
				$print.="</td>";
				//12 end

				//13 start
				$print.="<td>";
				if (isset($concobtain[$cnt]['concentrate_obtain_metal']))
					$print.=$concobtain[$cnt]['concentrate_obtain_metal'];
				$print.="</td>";
		
				$print.="<td>";
				if (isset($concobtain[$cnt]['concentrate_obtain_qty']))
					$print.=$concobtain[$cnt]['concentrate_obtain_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($concobtain[$cnt]['concentrate_obtain_metal_grade']))
					$print.=$concobtain[$cnt]['concentrate_obtain_metal_grade'];
				$print.="</td>";
				$print.="<td>";
				if (isset($concobtain[$cnt]['concentrate_obtain_value']))
					$print.=$concobtain[$cnt]['concentrate_obtain_value'];
				$print.="</td>";
				//13 end
				//14 start
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";

					if (isset($trailing[$cnt]['tail_qty']))
						$print.=$trailing[$cnt]['tail_qty'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($trailing[$cnt]['tail_metal']))
					$print.=$trailing[$cnt]['tail_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($trailing[$cnt]['tail_metal_grade']))
					$print.=$trailing[$cnt]['tail_metal_grade'];
				$print.="</td>";
				//14 end
				//15 start
				$print.="<td>";
				if (isset($clstkcpnt[$cnt]['clos_stock_qty']))
					$print.=$clstkcpnt[$cnt]['clos_stock_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($clstkcpnt[$cnt]['clos_stock_metal']))
					$print.=$clstkcpnt[$cnt]['clos_stock_metal'];
				$print.="</td>";
			
				$print.="<td>";
				if (isset($clstkcpnt[$cnt]['clos_stock_metal_grade']))
					$print.=$clstkcpnt[$cnt]['clos_stock_metal_grade'];
				$print.="</td>";
				//15 end
				//1 start
				$print.="<td>";
				if (isset($opstkspnt[$cnt]['qyt_open_smelter_metal']))
					$print.=$opstkspnt[$cnt]['qyt_open_smelter_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($opstkspnt[$cnt]['qyt_open_smelter']))
					$print.=$opstkspnt[$cnt]['qyt_open_smelter'];
				$print.="</td>";
				$print.="<td>";
				if (isset($opstkspnt[$cnt]['metal_open_smelter']))
					$print.=$opstkspnt[$cnt]['metal_open_smelter'];
				$print.="</td>";
				//1 end
				//2 start
				$print.="<td>";
				if (isset($cntrecpnt[$cnt]['concentrate_rec_qty']))
					$print.=$cntrecpnt[$cnt]['concentrate_rec_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($cntrecpnt[$cnt]['concentrate_rec_metal']))
					$print.=$cntrecpnt[$cnt]['concentrate_rec_metal'];
				$print.="</td>";
				//2 end
				//3 start
				$print.="<td>";
				if (isset($cntrecoth[$cnt]['concentrate_other_src_qty']))
					$print.=$cntrecoth[$cnt]['concentrate_other_src_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($cntrecoth[$cnt]['concentrate_other_src_grade']))
					$print.=$cntrecoth[$cnt]['concentrate_other_src_grade'];
				$print.="</td>";
				//3 end
				//4 start
				$print.="<td>";
				if (isset($cntsold[$cnt]['concentrate_sold_qty']))
					$print.=$cntsold[$cnt]['concentrate_sold_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($cntsold[$cnt]['concentrate_sold_metal']))
					$print.=$cntsold[$cnt]['concentrate_sold_metal'];
				$print.="</td>";
				//4 end
				//5 start
				$print.="<td>";
				if (isset($cnttreat[$cnt]['concentrate_treat_qty']))
					$print.=$cnttreat[$cnt]['concentrate_treat_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($cnttreat[$cnt]['concentrate_treat_metal']))
					$print.=$cnttreat[$cnt]['concentrate_treat_metal'];
				$print.="</td>";
				//5 end
				//8 start
				$print.="<td>";
				if (isset($clstkspnt[$cnt]['qyt_close_smelter']))
					$print.=$clstkspnt[$cnt]['qyt_close_smelter'];
				$print.="</td>";
				$print.="<td>";
				if (isset($clstkspnt[$cnt]['metal_close_smelter']))
					$print.=$clstkspnt[$cnt]['metal_close_smelter'];
				$print.="</td>";
				//8 end
				//6 start
				$print.="<td>";
				if (isset($metlrecvd[$cnt]['metal_recover_qty_metal']))
					$print.=$metlrecvd[$cnt]['metal_recover_qty_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($metlrecvd[$cnt]['metal_recover_qty']))
					$print.=$metlrecvd[$cnt]['metal_recover_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($metlrecvd[$cnt]['metal_recover_grade']))
					$print.=$metlrecvd[$cnt]['metal_recover_grade'];
				$print.="</td>";
				$print.="<td>";
				if (isset($metlrecvd[$cnt]['metal_recover_value']))
					$print.=$metlrecvd[$cnt]['metal_recover_value'];
				$print.="</td>";
				//6 end
				//7 start
				$print.="<td>";
				if (isset($othprodrec[$cnt]['other_prod_grade_metal']))
					$print.=$othprodrec[$cnt]['other_prod_grade_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($othprodrec[$cnt]['other_prod_qty']))
					$print.=$othprodrec[$cnt]['other_prod_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($othprodrec[$cnt]['other_prod_grade']))
					$print.=$othprodrec[$cnt]['other_prod_grade'];
				$print.="</td>";
				$print.="<td>";
				if (isset($othprodrec[$cnt]['other_prod_value']))
					$print.=$othprodrec[$cnt]['other_prod_value'];
				$print.="</td>";
				//7 end

			}
			if ($cnt >0) $print.='</tr>';
		}

        $print.='</tbody>
        </table>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
		</div>';
		} else {
			$print='<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<h4 class="tHeadFont" id="heading1">Report M04 - Mine to Smelter Details (Ore to Metal)</h4>
						<div class="form-horizontal">
							<div class="card-body" id="avb">
								<h6 class="tHeadDate"  id="heading2">Date : From '.$showDate.'</h6>
								
								<h6 class="tHeadDate" id="heading2"><strong>Since records are more hence no search & pagination service is available, you may use the option "Export to Excel"</strong></h6>
                                <input type="button" id="downloadExcel" value="Export to Excel">
                                <br /><br />
								
								<div class="table-responsive">
									<table class="table table-striped table-hover table-bordered compact" border="1" id="noDatatable">
										<thead class="tableHead">
											<tr>
												<th colspan="50" class="noDisplay" align="left">Report M04 - Mine to Smelter Details (Ore to Metal)  Date : From '.$showDate.'</th>
											</tr>
											<tr>
												<th rowspan="2">#</th>
												<th rowspan="2">Month</th>
												<th rowspan="2">Mineral</th>
												<th rowspan="2">State</th>
												<th rowspan="2">District</th>
												<th rowspan="2">Name of Mine</th>
												<th rowspan="2">Name of Lease Owner</th>
												<th rowspan="2">Lease Area</th>
												<th rowspan="2">Mine Code</th>
												<th rowspan="2">IBM Registration Number</th>
												<th colspan="3"> Opening Stock of the Ore at concentrator/plant</th>
												<th colspan="3">Ore received from the Mine</th>
												<th colspan="3">Ore treated at concentrator plant</th>
												<th colspan="4">Concentrates Obtained</th>
												<th colspan="3">Tailing</th>
												<th colspan="3">Closing Stock of Concentrate at Concentrator/Plant</th>
												<th colspan="3">Opening Stock of Concentrates at Smelter/Plant</th>
												<th colspan="2">Concentrates Received from Concentrator/plant</th>
												<th colspan="2">Concentrates Received from other sources(specify)</th>
												<th colspan="2">Concentrates Sold (if any)</th>
												<th colspan="2">Concentrates Treated</th>
												<th colspan="2">Closing Stock of Concentrate at the smelter/plant</th>
												<th colspan="4">Metal Recoverd (specify)</th>
												<th colspan="4">Other by Products if any recovered</th>
											</tr>
											<tr>
												<th>Quantity(tonnes)</th>
												<th colspan="2">Metal Content/Grade</th>
												<th>Quantity(tonnes)</th>
												<th colspan="2">Metal Content / Grade</th>
												<th>Quantity(tonnes)</th>
												<th colspan="2">Metal Content / Grade</th>
												<th>Quantity(tonnes)</th>
												<th colspan="2">Metal Content / Grade</th>
												<th>Value</th>
												<th>Quantity(tonnes)</th>
												<th colspan="2">Metal Content / Grade</th>
												<th>Quantity(tonnes)</th>
												<th colspan="2">Metal Content / Grade</th>
												<th>Metal</th>
												<th>Quantity(tonnes)</th>
												<th>Metal Content/Grade</th>
												<th>Quantity(tonnes)</th>
												<th>Metal Content/Grade</th>
												<th>Quantity(tonnes)</th>
												<th>Metal Content/Grade</th>
												<th>Quantity(tonnes)</th>
												<th>Metal Content/Grade</th>
												<th>Quantity(tonnes)</th>
												<th>Metal Content/Grade</th>
												<th>Quantity(tonnes)</th>
												<th>Metal Content/Grade</th>
												<th>Metal</th>
												<th>Quantity(tonnes)</th>
												<th>Grade</th>
												<th> Value(Rs)</th>
												<th>Metal</th>
												<th>Quantity(tonnes)</th>
												<th>Grade</th>
												<th> Value(Rs)</th>
											</tr>

										</thead>
										<tbody class="tableBody">';
        foreach ($records as $record) {
            
            if ($lmineral_name != $record['mineral_name']) {
                $lmineral_name = $record['mineral_name'];
                $lflg="Y";
            }
            if ($lstate_name != $record['state_name']) {
                $lstate_name = $record['state_name'];
                $lflg="Y";
            }
            if ($ldistrict_name != $record['district_name']) {
                $ldistrict_name = $record['district_name'];
                $lflg="Y";
            }
            if ($lmonthnm != $record['showMonth']) {
                $lmonthnm  = $record['showMonth'];
                $lflg="Y";
            }
            if ($lyearnm != $record['showYear']) {
                $lyearnm  = $record['showYear'];
                $lflg="Y";
            }
            if ($lmincode!=$record['mine_code']) {
                $lmincode=$record['mine_code'];
                $lflg="Y";
            }


            if ($lflg=="Y" || $lcnt <0) {
                if ($lcnt >=0) {
					$larcount=count($oreopstk);
					if (count($orerecmine) >$larcount) $larcount=count($orerecmine);
					if (count($oretreatcp) >$larcount) $larcount=count($oretreatcp);
					if (count($concobtain) >$larcount) $larcount=count($concobtain);
					if (count($trailing)   >$larcount) $larcount=count($trailing);
					if (count($clstkcpnt)  >$larcount) $larcount=count($clstkcpnt);
					if (count($opstkspnt)  >$larcount) $larcount=count($opstkspnt);
					if (count($cntrecpnt)  >$larcount) $larcount=count($cntrecpnt);
					if (count($cntrecoth)  >$larcount) $larcount=count($cntrecoth);
					if (count($cntsold)    >$larcount) $larcount=count($cntsold);
					if (count($cnttreat)   >$larcount) $larcount=count($cnttreat);
					if (count($clstkspnt)  >$larcount) $larcount=count($clstkspnt);
					if (count($metlrecvd)  >$larcount) $larcount=count($metlrecvd);
					if (count($othprodrec) >$larcount) $larcount=count($othprodrec);
					$lrowspan="";
					if ($larcount>1) 
						$lrowspan=" rowspan=".$larcount."";
				$lcounter+=1;					
				$print.='<tr>
					<td '.$lrowspan.'>'.$lcounter.'</td>
					<td '.$lrowspan.'>'.$monthname.'</td>	
					<td '.$lrowspan.'>'.$mineral_name.'</td>
					<td '.$lrowspan.'>'.$state_name.'</td>
					<td '.$lrowspan.'>'.$district_name.'</td>												
					<td '.$lrowspan.'>'.$MINE_NAME.'</td>
					<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
					<td '.$lrowspan.'>'.$lease_area.'</td>
					<td '.$lrowspan.'>'.$mine_code.'</td>
					<td '.$lrowspan.'>'.$registration_no.'</td>';
					for ($cnt=0;$cnt < $larcount; $cnt++) {
						if ($cnt > 0) $print.='</tr><tr>';
						//10 starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($oreopstk[$cnt]['open_stock_qty']))
								$print.=$oreopstk[$cnt]['open_stock_qty'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($oreopstk[$cnt]['open_stock_metal']))
							$print.=$oreopstk[$cnt]['open_stock_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($oreopstk[$cnt]['open_stock_metal_grade']))
							$print.=$oreopstk[$cnt]['open_stock_metal_grade'];
						$print.="</td>";
						//10 ends
						//11 starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($orerecmine[$cnt]['ore_rec_qty']))
								$print.=$orerecmine[$cnt]['ore_rec_qty'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($orerecmine[$cnt]['ore_rec_metal']))
							$print.=$orerecmine[$cnt]['ore_rec_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($orerecmine[$cnt]['ore_rec_metal_grade']))
							$print.=$orerecmine[$cnt]['ore_rec_metal_grade'];
						$print.="</td>";
						//11 ends
						//12 starts					
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($oretreatcp[$cnt]['ore_treat_qty']))
								$print.=$oretreatcp[$cnt]['ore_treat_qty'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($oretreatcp[$cnt]['ore_treat_metal']))
							$print.=$oretreatcp[$cnt]['ore_treat_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($oretreatcp[$cnt]['ore_treat_metal_grade']))
							$print.=$oretreatcp[$cnt]['ore_treat_metal_grade'];
						$print.="</td>";
						//12 end

						//13 start
						$print.="<td>";
						if (isset($concobtain[$cnt]['concentrate_obtain_metal']))
							$print.=$concobtain[$cnt]['concentrate_obtain_metal'];
						$print.="</td>";
				
						$print.="<td>";
						if (isset($concobtain[$cnt]['concentrate_obtain_qty']))
							$print.=$concobtain[$cnt]['concentrate_obtain_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($concobtain[$cnt]['concentrate_obtain_metal_grade']))
							$print.=$concobtain[$cnt]['concentrate_obtain_metal_grade'];
						$print.="</td>";
						$print.="<td>";
						if (isset($concobtain[$cnt]['concentrate_obtain_value']))
							$print.=$concobtain[$cnt]['concentrate_obtain_value'];
						$print.="</td>";
						//13 end
						//14 start
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";

							if (isset($trailing[$cnt]['tail_qty']))
								$print.=$trailing[$cnt]['tail_qty'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($trailing[$cnt]['tail_metal']))
							$print.=$trailing[$cnt]['tail_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($trailing[$cnt]['tail_metal_grade']))
							$print.=$trailing[$cnt]['tail_metal_grade'];
						$print.="</td>";
						//14 end
						//15 start
						$print.="<td>";
						if (isset($clstkcpnt[$cnt]['clos_stock_qty']))
							$print.=$clstkcpnt[$cnt]['clos_stock_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($clstkcpnt[$cnt]['clos_stock_metal']))
							$print.=$clstkcpnt[$cnt]['clos_stock_metal'];
						$print.="</td>";						
						$print.="<td>";
						if (isset($clstkcpnt[$cnt]['clos_stock_metal_grade']))
							$print.=$clstkcpnt[$cnt]['clos_stock_metal_grade'];
						$print.="</td>";
						//15 end
						//1 start
						$print.="<td>";
						if (isset($opstkspnt[$cnt]['qyt_open_smelter_metal']))
							$print.=$opstkspnt[$cnt]['qyt_open_smelter_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($opstkspnt[$cnt]['qyt_open_smelter']))
							$print.=$opstkspnt[$cnt]['qyt_open_smelter'];
						$print.="</td>";
						$print.="<td>";
						if (isset($opstkspnt[$cnt]['metal_open_smelter']))
							$print.=$opstkspnt[$cnt]['metal_open_smelter'];
						$print.="</td>";
						//1 end
						//2 start
						$print.="<td>";
						if (isset($cntrecpnt[$cnt]['concentrate_rec_qty']))
							$print.=$cntrecpnt[$cnt]['concentrate_rec_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($cntrecpnt[$cnt]['concentrate_rec_metal']))
							$print.=$cntrecpnt[$cnt]['concentrate_rec_metal'];
						$print.="</td>";
						//2 end
						//3 start
						$print.="<td>";
						if (isset($cntrecoth[$cnt]['concentrate_other_src_qty']))
							$print.=$cntrecoth[$cnt]['concentrate_other_src_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($cntrecoth[$cnt]['concentrate_other_src_grade']))
							$print.=$cntrecoth[$cnt]['concentrate_other_src_grade'];
						$print.="</td>";
						//3 end
						//4 start
						$print.="<td>";
						if (isset($cntsold[$cnt]['concentrate_sold_qty']))
							$print.=$cntsold[$cnt]['concentrate_sold_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($cntsold[$cnt]['concentrate_sold_metal']))
							$print.=$cntsold[$cnt]['concentrate_sold_metal'];
						$print.="</td>";
						//4 end
						//5 start
						$print.="<td>";
						if (isset($cnttreat[$cnt]['concentrate_treat_qty']))
							$print.=$cnttreat[$cnt]['concentrate_treat_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($cnttreat[$cnt]['concentrate_treat_metal']))
							$print.=$cnttreat[$cnt]['concentrate_treat_metal'];
						$print.="</td>";
						//5 end
						//8 start
						$print.="<td>";
						if (isset($clstkspnt[$cnt]['qyt_close_smelter']))
							$print.=$clstkspnt[$cnt]['qyt_close_smelter'];
						$print.="</td>";
						$print.="<td>";
						if (isset($clstkspnt[$cnt]['metal_close_smelter']))
							$print.=$clstkspnt[$cnt]['metal_close_smelter'];
						$print.="</td>";
						//8 end
						//6 start
						$print.="<td>";
						if (isset($metlrecvd[$cnt]['metal_recover_qty_metal']))
							$print.=$metlrecvd[$cnt]['metal_recover_qty_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($metlrecvd[$cnt]['metal_recover_qty']))
							$print.=$metlrecvd[$cnt]['metal_recover_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($metlrecvd[$cnt]['metal_recover_grade']))
							$print.=$metlrecvd[$cnt]['metal_recover_grade'];
						$print.="</td>";
						$print.="<td>";
						if (isset($metlrecvd[$cnt]['metal_recover_value']))
							$print.=$metlrecvd[$cnt]['metal_recover_value'];
						$print.="</td>";
						//6 end
						//7 start
						$print.="<td>";
						if (isset($othprodrec[$cnt]['other_prod_grade_metal']))
							$print.=$othprodrec[$cnt]['other_prod_grade_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($othprodrec[$cnt]['other_prod_qty']))
							$print.=$othprodrec[$cnt]['other_prod_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($othprodrec[$cnt]['other_prod_grade']))
							$print.=$othprodrec[$cnt]['other_prod_grade'];
						$print.="</td>";
						$print.="<td>";
						if (isset($othprodrec[$cnt]['other_prod_value']))
							$print.=$othprodrec[$cnt]['other_prod_value'];
						$print.="</td>";
						//7 end

					}
					if ($cnt >0) $print.='</tr>';
                }
                $lcnt++;
                $lflg="";
                $cnt=0;
				$dbj   = \DateTime::createFromFormat('!m', $record['showMonth']);										  
				//Format it to month name
				$monthName = $dbj->format('F');
				//$monthName = $record['showMonth'];
                $monthname=$monthName.' '.$record['showYear'];	
                $mineral_name=ucwords(str_replace('_', ' ', $record['mineral_name']));
                $state_name=$record['state_name']; 
                $district_name=$record['district_name']; 
                $MINE_NAME=$record['MINE_NAME'] ;
                $lessee_owner_name=$record['lessee_owner_name'];
                $lease_area=$record['lease_area'];
                $mine_code=$record['mine_code'];
                $registration_no=$record['registration_no']; 
				$oreopstk=array();		//Opening Stock of the Ore at concentrator/plant
				$orerecmine=array();		//Ore received from the Mine
				$oretreatcp=array();		//Ore treated at concentrator plant
				$concobtain=array();		//Concentrates Obtained
				$trailing=array();		//Tailing
				$clstkcpnt=array();		//Closing Stock of Concentrate at Concentrator/Plant
				$opstkspnt=array();		//Opening Stock of Concentrates at Smelter/Plant
				$cntrecpnt=array();		//Concentrates Received from Concentrator/plant
				$cntrecoth=array();		//Concentrates Received from other sources(specify)
				$cntsold=array();		//Concentrates Sold (if any)
				$cnttreat=array();		//Concentrates Treated
				$clstkspnt=array();		//Closing Stock of Concentrate at the smelter/plant
				$metlrecvd=array();		//Metal Recoverd (specify)
				$othprodrec=array();		//Other by Products if any recovered				
				$lrcnt1=-1;
				$lrcnt2=-1;
				$lrcnt3=-1;
				$lrcnt4=-1;
				$lrcnt5=-1;

				$lrcnt6=-1;
				$lrcnt7=-1;
				$lrcnt8=-1;
				$lrcnt10=-1;
				$lrcnt11=-1;
				$lrcnt12=-1;
				$lrcnt13=-1;
				$lrcnt14=-1;
				$lrcnt15=-1;

            }
            if ((int)$record['rom_5_step_sn']==1) { 
				$lrcnt1+=1;
				$opstkspnt[$lrcnt1]['qyt_open_smelter']=$record['tot_qty'];
				$opstkspnt[$lrcnt1]['metal_open_smelter']=$record['grade'];
				$opstkspnt[$lrcnt1]['qyt_open_smelter_metal']=$record['metal_content'];
            }
            if ((int)$record['rom_5_step_sn']==2) { 
				$lrcnt2+=1;
				$cntrecpnt[$lrcnt2]['concentrate_rec_qty']=$record['tot_qty'];
				$cntrecpnt[$lrcnt2]['concentrate_rec_metal']=$record['grade'];
            }          
            if ((int)$record['rom_5_step_sn']==3) { 
				$lrcnt3+=1;
				$cntrecoth[$lrcnt3]['concentrate_other_src_qty']=$record['tot_qty'];
				$cntrecoth[$lrcnt3]['concentrate_other_src_grade']=$record['grade'];
            }
            if ((int)$record['rom_5_step_sn']==4) { 
				$lrcnt4+=1;
				$cntsold[$lrcnt4]['concentrate_sold_qty']=$record['tot_qty'];
				$cntsold[$lrcnt4]['concentrate_sold_metal']=$record['grade'];

            }
            if ((int)$record['rom_5_step_sn']==5) { 
				$lrcnt5+=1;
				$cnttreat[$lrcnt5]['concentrate_treat_qty']=$record['tot_qty'];
				$cnttreat[$lrcnt5]['concentrate_treat_metal']=$record['grade'];
            }
            if ((int)$record['rom_5_step_sn']==6) { 
				$lrcnt6+=1;
				$metlrecvd[$lrcnt6]['metal_recover_qty_metal']=$record['metal_content'];
				$metlrecvd[$lrcnt6]['metal_recover_qty']=$record['tot_qty'];
				$metlrecvd[$lrcnt6]['metal_recover_grade']=$record['grade'];
				$metlrecvd[$lrcnt6]['metal_recover_value']=$record['value'];
            }	
            if ((int)$record['rom_5_step_sn']==7) { 
				$lrcnt7+=1;
				$othprodrec[$lrcnt7]['other_prod_grade_metal']=$record['metal_content'];
				$othprodrec[$lrcnt7]['other_prod_qty']=$record['tot_qty'];
				$othprodrec[$lrcnt7]['other_prod_grade']=$record['grade'];
				$othprodrec[$lrcnt7]['other_prod_value']=$record['value'];
            }
            if ((int)$record['rom_5_step_sn']==8) { 
				$lrcnt8+=1;
				$clstkspnt[$lrcnt8]['qyt_close_smelter']=$record['tot_qty'];
				//as discussed dated on 12-04-22 use value column instead of grade
				//$clstkspnt[$lrcnt8]['metal_close_smelter']=$record['grade'];
				$clstkspnt[$lrcnt8]['metal_close_smelter']=$record['value'];

            }
            if ((int)$record['rom_5_step_sn']==10) { 
				$lrcnt10+=1;
				$oreopstk[$lrcnt10]['open_stock_qty']=$record['tot_qty'];
				$oreopstk[$lrcnt10]['open_stock_metal']=$record['metal_content'];
				$oreopstk[$lrcnt10]['open_stock_metal_grade']=$record['grade'];
            }		
            if ((int)$record['rom_5_step_sn']==11) { 
				$lrcnt11+=1;
				$orerecmine[$lrcnt11]['ore_rec_qty']=$record['tot_qty'];
				$orerecmine[$lrcnt11]['ore_rec_metal']=$record['metal_content'];
				$orerecmine[$lrcnt11]['ore_rec_metal_grade']=$record['grade'];
            }	
            if ((int)$record['rom_5_step_sn']==12) { 
				$lrcnt12+=1;
				$oretreatcp[$lrcnt12]['ore_treat_qty']=$record['tot_qty'];
				$oretreatcp[$lrcnt12]['ore_treat_metal']=$record['metal_content'];
				$oretreatcp[$lrcnt12]['ore_treat_metal_grade']=$record['grade'];
            }
            if ((int)$record['rom_5_step_sn']==13) { 
				$lrcnt13+=1;
				$concobtain[$lrcnt13]['concentrate_obtain_metal']=$record['metal_content'];
				$concobtain[$lrcnt13]['concentrate_obtain_qty']=$record['tot_qty'];
				$concobtain[$lrcnt13]['concentrate_obtain_metal_grade']=$record['grade'];
				$concobtain[$lrcnt13]['concentrate_obtain_value']=$record['value'];
            }
            if ((int)$record['rom_5_step_sn']==14) { 
				$lrcnt14+=1;
				$trailing[$lrcnt14]['tail_qty']=$record['tot_qty'];
				$trailing[$lrcnt14]['tail_metal']=$record['metal_content'];
				$trailing[$lrcnt14]['tail_metal_grade']=$record['grade'];
            }
            if ((int)$record['rom_5_step_sn']==15) { 
				$lrcnt15+=1;
				$clstkcpnt[$lrcnt15]['clos_stock_metal']=$record['metal_content'];
				$clstkcpnt[$lrcnt15]['clos_stock_qty']=$record['tot_qty'];
				$clstkcpnt[$lrcnt15]['clos_stock_metal_grade']=$record['grade'];

            }
			
			
        }
		if ($lcnt >=0) {
			$larcount=count($oreopstk);
			if (count($orerecmine) >$larcount) $larcount=count($orerecmine);
			if (count($oretreatcp) >$larcount) $larcount=count($oretreatcp);
			if (count($concobtain) >$larcount) $larcount=count($concobtain);
			if (count($trailing)   >$larcount) $larcount=count($trailing);
			if (count($clstkcpnt)  >$larcount) $larcount=count($clstkcpnt);
			if (count($opstkspnt)  >$larcount) $larcount=count($opstkspnt);
			if (count($cntrecpnt)  >$larcount) $larcount=count($cntrecpnt);
			if (count($cntrecoth)  >$larcount) $larcount=count($cntrecoth);
			if (count($cntsold)    >$larcount) $larcount=count($cntsold);
			if (count($cnttreat)   >$larcount) $larcount=count($cnttreat);
			if (count($clstkspnt)  >$larcount) $larcount=count($clstkspnt);
			if (count($metlrecvd)  >$larcount) $larcount=count($metlrecvd);
			if (count($othprodrec) >$larcount) $larcount=count($othprodrec);
			$lrowspan="";
			if ($larcount>1) 
				$lrowspan=" rowspan=".$larcount."";
		$lcounter+=1;
		$print.='<tr>
			<td '.$lrowspan.'>'.$lcounter.'</td>
			<td '.$lrowspan.'>'.$monthname.'</td>	
			<td '.$lrowspan.'>'.$mineral_name.'</td>
			<td '.$lrowspan.'>'.$state_name.'</td>
			<td '.$lrowspan.'>'.$district_name.'</td>												
			<td '.$lrowspan.'>'.$MINE_NAME.'</td>
			<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
			<td '.$lrowspan.'>'.$lease_area.'</td>
			<td '.$lrowspan.'>'.$mine_code.'</td>
			<td '.$lrowspan.'>'.$registration_no.'</td>';
			for ($cnt=0;$cnt < $larcount; $cnt++) {
				if ($cnt > 0) $print.='</tr><tr>';
				//10 starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($oreopstk[$cnt]['open_stock_qty']))
						$print.=$oreopstk[$cnt]['open_stock_qty'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($oreopstk[$cnt]['open_stock_metal']))
					$print.=$oreopstk[$cnt]['open_stock_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($oreopstk[$cnt]['open_stock_metal_grade']))
					$print.=$oreopstk[$cnt]['open_stock_metal_grade'];
				$print.="</td>";
				//10 ends
				//11 starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($orerecmine[$cnt]['ore_rec_qty']))
						$print.=$orerecmine[$cnt]['ore_rec_qty'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($orerecmine[$cnt]['ore_rec_metal']))
					$print.=$orerecmine[$cnt]['ore_rec_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($orerecmine[$cnt]['ore_rec_metal_grade']))
					$print.=$orerecmine[$cnt]['ore_rec_metal_grade'];
				$print.="</td>";
				//11 ends
				//12 starts	 				
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($oretreatcp[$cnt]['ore_treat_qty']))
						$print.=$oretreatcp[$cnt]['ore_treat_qty'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($oretreatcp[$cnt]['ore_treat_metal']))
					$print.=$oretreatcp[$cnt]['ore_treat_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($oretreatcp[$cnt]['ore_treat_metal_grade']))
					$print.=$oretreatcp[$cnt]['ore_treat_metal_grade'];
				$print.="</td>";
				//12 end

				//13 start
				$print.="<td>";
				if (isset($concobtain[$cnt]['concentrate_obtain_metal']))
					$print.=$concobtain[$cnt]['concentrate_obtain_metal'];
				$print.="</td>";
		
				$print.="<td>";
				if (isset($concobtain[$cnt]['concentrate_obtain_qty']))
					$print.=$concobtain[$cnt]['concentrate_obtain_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($concobtain[$cnt]['concentrate_obtain_metal_grade']))
					$print.=$concobtain[$cnt]['concentrate_obtain_metal_grade'];
				$print.="</td>";
				$print.="<td>";
				if (isset($concobtain[$cnt]['concentrate_obtain_value']))
					$print.=$concobtain[$cnt]['concentrate_obtain_value'];
				$print.="</td>";
				//13 end
				//14 start
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";

					if (isset($trailing[$cnt]['tail_qty']))
						$print.=$trailing[$cnt]['tail_qty'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($trailing[$cnt]['tail_metal']))
					$print.=$trailing[$cnt]['tail_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($trailing[$cnt]['tail_metal_grade']))
					$print.=$trailing[$cnt]['tail_metal_grade'];
				$print.="</td>";
				//14 end
				//15 start
				$print.="<td>";
				if (isset($clstkcpnt[$cnt]['clos_stock_qty']))
					$print.=$clstkcpnt[$cnt]['clos_stock_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($clstkcpnt[$cnt]['clos_stock_metal']))
					$print.=$clstkcpnt[$cnt]['clos_stock_metal'];
				$print.="</td>";
			
				$print.="<td>";
				if (isset($clstkcpnt[$cnt]['clos_stock_metal_grade']))
					$print.=$clstkcpnt[$cnt]['clos_stock_metal_grade'];
				$print.="</td>";
				//15 end
				//1 start
				$print.="<td>";
				if (isset($opstkspnt[$cnt]['qyt_open_smelter_metal']))
					$print.=$opstkspnt[$cnt]['qyt_open_smelter_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($opstkspnt[$cnt]['qyt_open_smelter']))
					$print.=$opstkspnt[$cnt]['qyt_open_smelter'];
				$print.="</td>";
				$print.="<td>";
				if (isset($opstkspnt[$cnt]['metal_open_smelter']))
					$print.=$opstkspnt[$cnt]['metal_open_smelter'];
				$print.="</td>";
				//1 end
				//2 start
				$print.="<td>";
				if (isset($cntrecpnt[$cnt]['concentrate_rec_qty']))
					$print.=$cntrecpnt[$cnt]['concentrate_rec_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($cntrecpnt[$cnt]['concentrate_rec_metal']))
					$print.=$cntrecpnt[$cnt]['concentrate_rec_metal'];
				$print.="</td>";
				//2 end
				//3 start
				$print.="<td>";
				if (isset($cntrecoth[$cnt]['concentrate_other_src_qty']))
					$print.=$cntrecoth[$cnt]['concentrate_other_src_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($cntrecoth[$cnt]['concentrate_other_src_grade']))
					$print.=$cntrecoth[$cnt]['concentrate_other_src_grade'];
				$print.="</td>";
				//3 end
				//4 start
				$print.="<td>";
				if (isset($cntsold[$cnt]['concentrate_sold_qty']))
					$print.=$cntsold[$cnt]['concentrate_sold_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($cntsold[$cnt]['concentrate_sold_metal']))
					$print.=$cntsold[$cnt]['concentrate_sold_metal'];
				$print.="</td>";
				//4 end
				//5 start
				$print.="<td>";
				if (isset($cnttreat[$cnt]['concentrate_treat_qty']))
					$print.=$cnttreat[$cnt]['concentrate_treat_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($cnttreat[$cnt]['concentrate_treat_metal']))
					$print.=$cnttreat[$cnt]['concentrate_treat_metal'];
				$print.="</td>";
				//5 end
				//8 start
				$print.="<td>";
				if (isset($clstkspnt[$cnt]['qyt_close_smelter']))
					$print.=$clstkspnt[$cnt]['qyt_close_smelter'];
				$print.="</td>";
				$print.="<td>";
				if (isset($clstkspnt[$cnt]['metal_close_smelter']))
					$print.=$clstkspnt[$cnt]['metal_close_smelter'];
				$print.="</td>";
				//8 end
				//6 start
				$print.="<td>";
				if (isset($metlrecvd[$cnt]['metal_recover_qty_metal']))
					$print.=$metlrecvd[$cnt]['metal_recover_qty_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($metlrecvd[$cnt]['metal_recover_qty']))
					$print.=$metlrecvd[$cnt]['metal_recover_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($metlrecvd[$cnt]['metal_recover_grade']))
					$print.=$metlrecvd[$cnt]['metal_recover_grade'];
				$print.="</td>";
				$print.="<td>";
				if (isset($metlrecvd[$cnt]['metal_recover_value']))
					$print.=$metlrecvd[$cnt]['metal_recover_value'];
				$print.="</td>";
				//6 end
				//7 start
				$print.="<td>";
				if (isset($othprodrec[$cnt]['other_prod_grade_metal']))
					$print.=$othprodrec[$cnt]['other_prod_grade_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($othprodrec[$cnt]['other_prod_qty']))
					$print.=$othprodrec[$cnt]['other_prod_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($othprodrec[$cnt]['other_prod_grade']))
					$print.=$othprodrec[$cnt]['other_prod_grade'];
				$print.="</td>";
				$print.="<td>";
				if (isset($othprodrec[$cnt]['other_prod_value']))
					$print.=$othprodrec[$cnt]['other_prod_value'];
				$print.="</td>";
				//7 end

			}
			if ($cnt >0) $print.='</tr>';
		}

        $print.='</tbody>
        </table>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
		</div>';
		}
		
        return $print;

	}
    public function reportM05()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $fromDate = $this->request->getData('from_date');
            $fromDate = explode(' ', $fromDate);
            $month1 = $fromDate[0];
            $year1 = $fromDate[1];
			//$month1 = $year1.$month1.'-01';
			$month1 = $month1.'-01';
			$month01 = explode('-',$month1);
            $monthno = date('m', strtotime($month1));
            $from_date = $year1 . '-' . $monthno . '-01';

            $toDate = $this->request->getData('to_date');
            $toDate = explode(' ', $toDate);
            $month2 = $toDate[0];
            $year2 = $toDate[1];
			//$month2 = $year2.$month2.'-01';
			$month2 = $month2.'-01';
			$month02 = explode('-',$month2);
            $monthno = date('m', strtotime($month2));
            $to_date = $year2 . '-' . $monthno . '-01';

            $from = $month1 . ' ' . $year1;
            $to =  $month2 . ' ' . $year2;

            $showDate = $month01[0] . ' ' . $year1 . ' To ' . $month02[0] . ' ' . $year2;

            $mineral = $this->request->getData('mineral');
            $mineral = strtolower($mineral);
			//echo $mineral;
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            // Change in query & in table grade_sale & dir_mineral_grade tale added new column (new_grade_code) , In join comparing mineral_name of both table & new_grade_code of both table
            $sql = "SELECT gs.client_type, gs.client_name, gs.client_reg_no, gs.quantity, gs.sale_value, dc.country_name AS expo_country, gs.expo_quantity,
            ml.mcmdt_ML_Area AS lease_area, gs.expo_fob, gs.mine_code, gs.mineral_name, m.MINE_NAME,
            m.lessee_owner_name, m.registration_no, dmg.grade_name, s.state_name, d.district_name, '$from' AS fromDate , '$to' As toDate, EXTRACT(MONTH FROM gs.return_date)  AS showMonth, EXTRACT(YEAR FROM gs.return_date)  AS showYear,
			m.type_working, m.mechanisation, m.mine_ownership,
			CASE
				WHEN `m`.`mine_category` = 1 THEN 'A'
				WHEN `m`.`mine_category` = 2 THEN 'B'
				ELSE `m`.`mine_category`
			END AS `mine_category`
            FROM
				tbl_final_submit tfs
					INNER JOIN
                mine m ON m.mine_code = tfs.mine_code
                    INNER JOIN
                dir_state s ON m.state_code = s.state_code
                    INNER JOIN
                dir_district d ON m.district_code = d.district_code
                    AND s.state_code = d.state_code
                    INNER JOIN
                grade_sale gs ON m.mine_code = gs.mine_code
					and gs.return_date = tfs.return_date and gs.return_type = tfs.return_type
                    AND gs.return_type = '$returnType'
                    AND (gs.return_date BETWEEN '$from_date' AND '$to_date')					
					LEFT JOIN 
				dir_country dc ON gs.expo_country = dc.id
                    LEFT JOIN
                 mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode
                    AND gs.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1
                     INNER JOIN
				dir_mineral_grade dmg ON gs.new_grade_code = dmg.new_grade_code
					AND gs.mineral_name = REPLACE(LOWER(dmg.mineral_name),
					'&',
					'and')
            WHERE
                gs.return_type = '$returnType' AND (gs.return_date BETWEEN '$from_date' AND '$to_date') AND tfs.is_latest = 1";


            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND gs.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND gs.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }

			// $sql .= " GROUP BY dmg.new_grade_code,gs.client_reg_no,gs.mine_code,gs.mineral_name,m.MINE_NAME,m.lessee_owner_name, m.registration_no,s.state_name,gs.return_date "; // added this to handle duplicate entries, on 06-07-2022 by Aniket

             //print_r($sql);exit;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

   /* public function reportM06()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $fromDate = $this->request->getData('from_date');
            $fromDate = explode(' ', $fromDate);
            $month1 = $fromDate[0];
            $monthno = date('m', strtotime($month1));
            $year1 = $fromDate[1];
            $from_date = $year1 . '-' . $monthno . '-01';

            $toDate = $this->request->getData('to_date');
            $toDate = explode(' ', $toDate);
            $month2 = $toDate[0];
            $monthno = date('m', strtotime($month2));
            $year2 = $toDate[1];
            $to_date = $year2 . '-' . $monthno . '-01';

            $from = $month1 . ' ' . $year1;
            $to =  $month2 . ' ' . $year2;

            $showDate = $month1 . ' ' . $year1 . ' To ' . $month2 . ' ' . $year2;

            $mineral = $this->request->getData('mineral');
            $mineral = strtolower(str_replace(' ', '_', $mineral));
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            $sql = "SELECT DISTINCT m06_01.mine_code, m06_01.mineral_name, m.MINE_NAME, m.lessee_owner_name, m.registration_no,   ml.mcmdt_ML_Area AS lease_area,
					s.state_name, d.district_name, m06_01.metal_content,  '$from' AS fromDate , '$to' As toDate, EXTRACT(MONTH FROM m06_01.return_date)  AS showMonth, EXTRACT(YEAR FROM m06_01.return_date)  AS showYear,
					m06_01.open_qty, m06_01.open_grade, m06_02.place_of_sale, m06_03.prod_qty, m06_03.prod_grade, m06_03.prod_value, m06_04.close_qty, m06_04.close_grade
					FROM
						mine m
							LEFT JOIN
						view_report_sale_metal_product_m06_01 m06_01 ON m.mine_code = m06_01.mine_code
							LEFT JOIN
						view_report_sale_metal_product_m06_02 m06_02 ON m.mine_code = m06_02.mine_code
							LEFT JOIN
						view_report_sale_metal_product_m06_03 m06_03 ON m.mine_code = m06_03.mine_code
							LEFT JOIN
						view_report_sale_metal_product_m06_04 m06_04 ON m.mine_code = m06_04.mine_code
							INNER JOIN
						dir_state s ON m.state_code = s.state_code
							INNER JOIN
						dir_district d ON m.district_code = d.district_code
							AND d.state_code = s.state_code										
							LEFT JOIN
						mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode
							WHERE
						m06_01.return_type = '$returnType' AND (m06_01.return_date BETWEEN '$from_date' AND '$to_date')
						AND m06_02.return_type = '$returnType' AND (m06_02.return_date BETWEEN '$from_date' AND '$to_date')
						AND m06_03.return_type = '$returnType' AND (m06_03.return_date BETWEEN '$from_date' AND '$to_date')
						AND m06_04.return_type = '$returnType' AND (m06_04.return_date BETWEEN '$from_date' AND '$to_date')";

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND ss.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND ss.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
            $sql .= " GROUP BY m.mine_code";
             //print_r($sql);exit;
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }*/
	
	public function reportM06()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $fromDate = $this->request->getData('from_date');
            $fromDate = explode(' ', $fromDate);
            $month1 = $fromDate[0];
			$month1 = $year1.$month1.'-01';
			$month01 = explode('-',$month1);
            $monthno = date('m', strtotime($month1));
            $year1 = $fromDate[1];
            $from_date = $year1 . '-' . $monthno . '-01';

            $toDate = $this->request->getData('to_date');
            $toDate = explode(' ', $toDate);
            $month2 = $toDate[0];
			$month2 = $year2.$month2.'-01';
			$month02 = explode('-',$month2);
            $monthno = date('m', strtotime($month2));
            $year2 = $toDate[1];
            $to_date = $year2 . '-' . $monthno . '-01';

            $from = $month1 . ' ' . $year1;
            $to =  $month2 . ' ' . $year2;

            $showDate = $month01[0] . ' ' . $year1 . ' To ' . $month02[0] . ' ' . $year2;

            $mineral = $this->request->getData('mineral');
            $mineral = strtolower($mineral);
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            /*$sql = "SELECT DISTINCT m06_01.mine_code, m06_01.mineral_name, m.MINE_NAME, m.lessee_owner_name, m.registration_no,   ml.mcmdt_ML_Area AS lease_area,
					s.state_name, d.district_name, m06_01.metal_content,  '$from' AS fromDate , '$to' As toDate, EXTRACT(MONTH FROM m06_01.return_date)  AS showMonth, EXTRACT(YEAR FROM m06_01.return_date)  AS showYear,
					m06_01.open_qty, m06_01.open_grade, m06_02.place_of_sale, m06_03.prod_qty, m06_03.prod_grade, m06_03.prod_value, m06_04.close_qty, m06_04.close_grade
					FROM
						mine m
							LEFT JOIN
						view_report_sale_metal_product_m06_01 m06_01 ON m.mine_code = m06_01.mine_code
							LEFT JOIN
						view_report_sale_metal_product_m06_02 m06_02 ON m.mine_code = m06_02.mine_code
							LEFT JOIN
						view_report_sale_metal_product_m06_03 m06_03 ON m.mine_code = m06_03.mine_code
							LEFT JOIN
						view_report_sale_metal_product_m06_04 m06_04 ON m.mine_code = m06_04.mine_code
							INNER JOIN
						dir_state s ON m.state_code = s.state_code
							INNER JOIN
						dir_district d ON m.district_code = d.district_code
							AND d.state_code = s.state_code										
							LEFT JOIN
						mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode
							WHERE
						m06_01.return_type = '$returnType' AND (m06_01.return_date BETWEEN '$from_date' AND '$to_date')
						AND m06_02.return_type = '$returnType' AND (m06_02.return_date BETWEEN '$from_date' AND '$to_date')
						AND m06_03.return_type = '$returnType' AND (m06_03.return_date BETWEEN '$from_date' AND '$to_date')
						AND m06_04.return_type = '$returnType' AND (m06_04.return_date BETWEEN '$from_date' AND '$to_date')"; */
                
                $sql = "SELECT m.MINE_NAME, m.lessee_owner_name, m.registration_no, ml.mcmdt_ML_Area AS lease_area, s.state_name,
                    d.district_name, s5.mine_code, s5.return_type, s5.return_date,  s5.mineral_name, '$from' AS fromDate , '$to' As toDate, EXTRACT(MONTH FROM s5.return_date)  AS showMonth, EXTRACT(YEAR FROM s5.return_date)  AS showYear,
                    s5.sale_5_step_sn, s5.metal_content,
                    s5.qty, s5.grade, s5.place_of_sale, s5.product_value                 
					FROM
					  tbl_final_submit tfs
						  INNER JOIN
					  sale_5 s5 ON s5.mine_code = tfs.mine_code
						  AND s5.return_type = tfs.return_type
						  AND s5.return_date = tfs.return_date
						  INNER JOIN 
					   mine m on m.mine_code = tfs.mine_code
						   INNER JOIN
					  dir_state s ON m.state_code = s.state_code
						  INNER JOIN
					  dir_district d ON m.district_code = d.district_code
						  AND d.state_code = s.state_code
						  LEFT JOIN
					  mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1
						  WHERE 
					  s5.return_type = '$returnType' AND s5.return_date BETWEEN '$from_date' AND '$to_date' AND tfs.is_latest = 1";

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND s5.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND s5.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
			$sql.=" order by  s5.mineral_name,s.state_name,d.district_name,s5.return_date,s5.mine_code,s5.metal_content";
             //print_r($sql);exit;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $lprint=$this->generatem06($records,$showDate,$rowCount);
                $this->set('lprint',$lprint);				

                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }
	public function generatem06($records,$showDate,$rowCount) {
        $lcnt=-1;
        $cnt=0;
        $lmineral_name = "";
        $lstate_name = "";
        $ldistrict_name = "";
        $lmonthnm = "";
        $lyearnm = "";
        $lmincode="";
		$lmetal_content="";
		$lserialno="";
        $lflg="";
		$lcounter=0;
		/*$loqty="";			//opening stock Qty
		$lograde="";		//opening stock grade
		$lpsale="";			//place of sale
		$lsqty="";			//sale qty
		$lsgrade="";		//Sale grade
		$lsvalue="";		//sale value
		$lclqty="";			//closing stock qty
		$lclgrade="";		//closing stock grade*/
		$marray=array();	//metal content
		$oarray=array();	//opening stock array
		$parray=array();	//Place of sale array
		$sarray=array();	//Sale array
		$carray=array();	//clossing stock array
		$lmcnt=-1;
		$locnt=-1;
		$lpcnt=-1;
		$lscnt=-1;
		$lccnt=-1;

		if($rowCount <= 15000) {
        $print="";
		$print='<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<h4 class="tHeadFont" id="heading1">Report M06 - Opening Stock, Sale of Metal/Product and Closing Stock </h4>
						<div class="form-horizontal">
							<div class="card-body" id="avb">
								<h6 class="tHeadDate"  id="heading2">Date : From '.$showDate.'</h6>
								<div class="table-responsive">
									<table class="table table-striped table-hover table-bordered compact" id="tableReport">
										<thead class="tableHead">
											<tr>
												<th rowspan="2">#</th>
												<th rowspan="2">Month</th>  
												<th rowspan="2">Mineral</th>
												<th rowspan="2">State</th>
												<th rowspan="2">District</th>  
												<th rowspan="2">Name of Mine</th>
												<th rowspan="2">Name of Lease Owner</th>
												<th rowspan="2">Lease Area</th>
												<th rowspan="2">Mine Code</th>
												<th rowspan="2">IBM Registration Number</th>
												<th rowspan="2">Metal/Product</th>
												<th colspan="2">Opening Stock</th>
												<th rowspan="2">Place of Sale</th>
												<th colspan="3">Metals/Products Sold</th>
												<th colspan="2">Closing Stock of Metals/Products</th>
											</tr>
											<tr>
												<th>Quantity(tonnes)</th>
												<th>Grade</th>
												<th>Quantity(tonnes) </th>
												<th>Grade</th>
												<th>Value</th>
												<th>Quantity(tonnes)</th>
												<th>Grade</th>
											</tr>
										</thead>
										<tbody class="tableBody">';
        foreach ($records as $record) {
            if ($lmineral_name != $record['mineral_name']) {
                $lmineral_name = $record['mineral_name'];
                $lflg="Y";
            }
            if ($lstate_name != $record['state_name']) {
                $lstate_name = $record['state_name'];
                $lflg="Y";
            }
            if ($ldistrict_name != $record['district_name']) {
                $ldistrict_name = $record['district_name'];
                $lflg="Y";
            }
            if ($lmonthnm != $record['showMonth']) {
                $lmonthnm  = $record['showMonth'];
                $lflg="Y";
            }
            if ($lyearnm != $record['showYear']) {
                $lyearnm  = $record['showYear'];
                $lflg="Y";
            }
            if ($lmincode!=$record['mine_code']) {
                $lmincode=$record['mine_code'];
                $lflg="Y";
            }
            //if ($lmetal_content!=$record['metal_content']) {
            //    $lflg="Y";
                
            //} 
            if ($lflg=="Y" || $lcnt <0) {
				if ($lcnt>=0) {
					$larcount=count($oarray);
					if (count($parray)>$larcount) $larcount=count($parray);
					if (count($sarray)>$larcount) $larcount=count($sarray);
					if (count($carray)>$larcount) $larcount=count($carray);
					$lrowspan="";
					//if ($larcount>1) 
					//	$lrowspan=" rowspan=".$larcount."";
					for ($cnt=0; $cnt < $larcount; $cnt++) {					
						$lcounter+=1;
						$print.='<tr>
							<td '.$lrowspan.'>'.$lcounter.'</td>
							<td '.$lrowspan.'>'.$monthname.'</td>	
							<td '.$lrowspan.'>'.$mineral_name.'</td>
							<td '.$lrowspan.'>'.$state_name.'</td>
							<td '.$lrowspan.'>'.$district_name.'</td>
							<td '.$lrowspan.'>'.$MINE_NAME.'</td>
							<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
							<td '.$lrowspan.'>'.$lease_area.'</td>
							<td '.$lrowspan.'>'.$mine_code.'</td>
							<td '.$lrowspan.'>'.$registration_no.'</td>';

						//if ($cnt >0) 
						//	$print.='<tr>';
						$print.="<td>";
						if (isset($marray[$cnt]['cont']))
							$print.=$marray[$cnt]['cont'];
						$print.="</td>";						
						//1 start
						$print.="<td>";
						if (isset($oarray[$cnt]['qty']))
							$print.=$oarray[$cnt]['qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($oarray[$cnt]['grade']))
							$print.=$oarray[$cnt]['grade'];
						$print.="</td>";
						//1 end
						//2 start
						$print.="<td>";
						if (isset($parray[$cnt]['psale']))
							$print.=$parray[$cnt]['psale'];
						$print.="</td>";
						//2 end
						//3 start
						$print.="<td>";
						if (isset($sarray[$cnt]['qty']))
							$print.=$sarray[$cnt]['qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($sarray[$cnt]['grade']))
							$print.=$sarray[$cnt]['grade'];
						$print.="</td>";
						$print.="<td>";
						if (isset($sarray[$cnt]['value']))
							$print.=$sarray[$cnt]['value'];
						$print.="</td>";

						//3 end
						//4 start
						$print.="<td>";
						if (isset($carray[$cnt]['qty']))
							$print.=$carray[$cnt]['qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($carray[$cnt]['grade']))
							$print.=$carray[$cnt]['grade'];
						$print.="</td>";
						//4 end
						$print.='</tr>';
					}
					//if ($cnt >0) $print.='</tr>';
						
				}
                $lcnt++;
                $lflg="";
                $cnt=0;
				$dbj   = \DateTime::createFromFormat('!m', $record['showMonth']);										  
				//Format it to month name
				$monthName = $dbj->format('F');
				//$monthName = $record['showMonth'];
                $monthname=$monthName.' '.$record['showYear'];	
                $mineral_name=ucwords(str_replace('_', ' ', $record['mineral_name']));
                $state_name=$record['state_name']; 
                $district_name=$record['district_name']; 
                $MINE_NAME=$record['MINE_NAME'] ;
                $lessee_owner_name=$record['lessee_owner_name'];
                $lease_area=$record['lease_area'];
                $mine_code=$record['mine_code'];
                $registration_no=$record['registration_no'];
				$lmetal_content=$record['metal_content'];
				/*$loqty="";			//opening stock Qty
				$lograde="";		//opening stock grade
				$lpsale="";			//place of sale
				$lsqty="";			//sale qty
				$lsgrade="";		//Sale grade
				$lsvalue="";		//sale value
				$lclqty="";			//closing stock qty
				$lclgrade="";		//closing stock grade*/
				$marray=array();	//metal content
				$oarray=array();	//opening stock array
				$parray=array();	//Place of sale array
				$sarray=array();	//Sale array
				$carray=array();	//clossing stock array
				$lmcnt=-1;
				$locnt=-1;
				$lpcnt=-1;
				$lscnt=-1;
				$lccnt=-1;

			}
            if ($lmetal_content!=$record['metal_content'] || $lmcnt <0) {
				$lmcnt+=1;
				$marray[$lmcnt]['cont']=$record['metal_content'];  
				$lmetal_content=$record['metal_content'];
            } 

			if ($record['sale_5_step_sn']==1) {
				$locnt+=1;
				$oarray[$locnt]['qty']=$record['qty'];
				$oarray[$locnt]['grade']=$record['grade'];
				//$loqty=$record['qty'];
				//$lograde=$record['grade'];
			}
			if ($record['sale_5_step_sn']==2) {
				$lpcnt+=1;
				$parray[$lpcnt]['psale']=$record['place_of_sale'];
				//$lpsale=$record['place_of_sale'];
			}
			if ($record['sale_5_step_sn']==3) {
				$lscnt+=1;
				$sarray[$lscnt]['qty']=$record['qty'];
				$sarray[$lscnt]['grade']=$record['grade'];
				$sarray[$lscnt]['value']=$record['product_value'];
				//$lsqty=$record['qty'];
				//$lsgrade=$record['grade'];
				//$lsvalue=$record['product_value'];
			}
			if ($record['sale_5_step_sn']==4) {
				$lccnt+=1;
				$carray[$lccnt]['qty']=$record['qty'];
				$carray[$lccnt]['grade']=$record['grade'];
				//$lclqty=$record['qty'];
				//$lclgrade=$record['grade'];
			}

		}
		if ($lcnt>=0) {
			$larcount=count($oarray);
			if (count($parray)>$larcount) $larcount=count($parray);
			if (count($sarray)>$larcount) $larcount=count($sarray);
			if (count($carray)>$larcount) $larcount=count($carray);
			$lrowspan="";
			//if ($larcount>1) 
			//	$lrowspan=" rowspan=".$larcount."";
			for ($cnt=0; $cnt < $larcount; $cnt++) {			
				$lcounter+=1;
				$print.='<tr>
					<td '.$lrowspan.'>'.$lcounter.'</td>
					<td '.$lrowspan.'>'.$monthname.'</td>	
					<td '.$lrowspan.'>'.$mineral_name.'</td>
					<td '.$lrowspan.'>'.$state_name.'</td>
					<td '.$lrowspan.'>'.$district_name.'</td>
					<td '.$lrowspan.'>'.$MINE_NAME.'</td>
					<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
					<td '.$lrowspan.'>'.$lease_area.'</td>
					<td '.$lrowspan.'>'.$mine_code.'</td>
					<td '.$lrowspan.'>'.$registration_no.'</td>';

				//if ($cnt >0) 
				//	$print.='<tr>';

				$print.="<td>";
				if (isset($marray[$cnt]['cont']))
					$print.=$marray[$cnt]['cont'];
				$print.="</td>";						
				//1 start
				$print.="<td>";
				if (isset($oarray[$cnt]['qty']))
					$print.=$oarray[$cnt]['qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($oarray[$cnt]['grade']))
					$print.=$oarray[$cnt]['grade'];
				$print.="</td>";
				//1 end
				//2 start
				$print.="<td>";
				if (isset($parray[$cnt]['psale']))
					$print.=$parray[$cnt]['psale'];
				$print.="</td>";
				//2 end
				//3 start
				$print.="<td>";
				if (isset($sarray[$cnt]['qty']))
					$print.=$sarray[$cnt]['qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($sarray[$cnt]['grade']))
					$print.=$sarray[$cnt]['grade'];
				$print.="</td>";
				$print.="<td>";
				if (isset($sarray[$cnt]['value']))
					$print.=$sarray[$cnt]['value'];
				$print.="</td>";

				//3 end
				//4 start
				$print.="<td>";
				if (isset($carray[$cnt]['qty']))
					$print.=$carray[$cnt]['qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($carray[$cnt]['grade']))
					$print.=$carray[$cnt]['grade'];
				$print.="</td>";
				//4 end
				$print.='</tr>';
			}
			//if ($cnt >0) $print.='</tr>';
				
		}
		$print.='</tbody>
		</table>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>';
		} else {
			$print="";
		$print='<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<h4 class="tHeadFont" id="heading1">Report M06 - Opening Stock, Sale of Metal/Product and Closing Stock </h4>
						<div class="form-horizontal">
							<div class="card-body" id="avb">
								<h6 class="tHeadDate"  id="heading2">Date : From '.$showDate.'</h6>
								
								<h6 class="tHeadDate" id="heading2"><strong>Since records are more hence no search & pagination service is available, you may use the option "Export to Excel"</strong></h6>
								<input type="button" id="downloadExcel" value="Export to Excel">
								<br /><br />
			
								<div class="table-responsive">
									<table class="table table-striped table-hover table-bordered compact" border="1" id="noDatatable">
										<thead class="tableHead">
											<tr>
												<th colspan="19" class="noDisplay" align="left">Report M06 - Opening Stock, Sale of Metal/Product and Closing Stock  Date : From '.$showDate.'</th>
											</tr>
											<tr>
												<th rowspan="2">#</th>
												<th rowspan="2">Month</th>  
												<th rowspan="2">Mineral</th>
												<th rowspan="2">State</th>
												<th rowspan="2">District</th>  
												<th rowspan="2">Name of Mine</th>
												<th rowspan="2">Name of Lease Owner</th>
												<th rowspan="2">Lease Area</th>
												<th rowspan="2">Mine Code</th>
												<th rowspan="2">IBM Registration Number</th>
												<th rowspan="2">Metal/Product</th>
												<th colspan="2">Opening Stock</th>
												<th rowspan="2">Place of Sale</th>
												<th colspan="3">Metals/Products Sold</th>
												<th colspan="2">Closing Stock of Metals/Products</th>
											</tr>
											<tr>
												<th>Quantity(tonnes)</th>
												<th>Grade</th>
												<th>Quantity(tonnes) </th>
												<th>Grade</th>
												<th>Value</th>
												<th>Quantity(tonnes)</th>
												<th>Grade</th>
											</tr>
										</thead>
										<tbody class="tableBody">';
        foreach ($records as $record) {
            if ($lmineral_name != $record['mineral_name']) {
                $lmineral_name = $record['mineral_name'];
                $lflg="Y";
            }
            if ($lstate_name != $record['state_name']) {
                $lstate_name = $record['state_name'];
                $lflg="Y";
            }
            if ($ldistrict_name != $record['district_name']) {
                $ldistrict_name = $record['district_name'];
                $lflg="Y";
            }
            if ($lmonthnm != $record['showMonth']) {
                $lmonthnm  = $record['showMonth'];
                $lflg="Y";
            }
            if ($lyearnm != $record['showYear']) {
                $lyearnm  = $record['showYear'];
                $lflg="Y";
            }
            if ($lmincode!=$record['mine_code']) {
                $lmincode=$record['mine_code'];
                $lflg="Y";
            }
            //if ($lmetal_content!=$record['metal_content']) {
            //    $lflg="Y";
                
            //} 
            if ($lflg=="Y" || $lcnt <0) {
				if ($lcnt>=0) {
					$larcount=count($oarray);
					if (count($parray)>$larcount) $larcount=count($parray);
					if (count($sarray)>$larcount) $larcount=count($sarray);
					if (count($carray)>$larcount) $larcount=count($carray);
					$lrowspan="";
					//if ($larcount>1) 
					//	$lrowspan=" rowspan=".$larcount."";
					for ($cnt=0; $cnt < $larcount; $cnt++) {					
						$lcounter+=1;
						$print.='<tr>
							<td '.$lrowspan.'>'.$lcounter.'</td>
							<td '.$lrowspan.'>'.$monthname.'</td>	
							<td '.$lrowspan.'>'.$mineral_name.'</td>
							<td '.$lrowspan.'>'.$state_name.'</td>
							<td '.$lrowspan.'>'.$district_name.'</td>
							<td '.$lrowspan.'>'.$MINE_NAME.'</td>
							<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
							<td '.$lrowspan.'>'.$lease_area.'</td>
							<td '.$lrowspan.'>'.$mine_code.'</td>
							<td '.$lrowspan.'>'.$registration_no.'</td>';

						//if ($cnt >0) 
						//	$print.='<tr>';
						$print.="<td>";
						if (isset($marray[$cnt]['cont']))
							$print.=$marray[$cnt]['cont'];
						$print.="</td>";						
						//1 start
						$print.="<td>";
						if (isset($oarray[$cnt]['qty']))
							$print.=$oarray[$cnt]['qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($oarray[$cnt]['grade']))
							$print.=$oarray[$cnt]['grade'];
						$print.="</td>";
						//1 end
						//2 start
						$print.="<td>";
						if (isset($parray[$cnt]['psale']))
							$print.=$parray[$cnt]['psale'];
						$print.="</td>";
						//2 end
						//3 start
						$print.="<td>";
						if (isset($sarray[$cnt]['qty']))
							$print.=$sarray[$cnt]['qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($sarray[$cnt]['grade']))
							$print.=$sarray[$cnt]['grade'];
						$print.="</td>";
						$print.="<td>";
						if (isset($sarray[$cnt]['value']))
							$print.=$sarray[$cnt]['value'];
						$print.="</td>";

						//3 end
						//4 start
						$print.="<td>";
						if (isset($carray[$cnt]['qty']))
							$print.=$carray[$cnt]['qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($carray[$cnt]['grade']))
							$print.=$carray[$cnt]['grade'];
						$print.="</td>";
						//4 end
						$print.='</tr>';
					}
					//if ($cnt >0) $print.='</tr>';
						
				}
                $lcnt++;
                $lflg="";
                $cnt=0;
				$dbj   = \DateTime::createFromFormat('!m', $record['showMonth']);										  
				//Format it to month name
				$monthName = $dbj->format('F');
				//$monthName = $record['showMonth'];
                $monthname=$monthName.' '.$record['showYear'];	
                $mineral_name=ucwords(str_replace('_', ' ', $record['mineral_name']));
                $state_name=$record['state_name']; 
                $district_name=$record['district_name']; 
                $MINE_NAME=$record['MINE_NAME'] ;
                $lessee_owner_name=$record['lessee_owner_name'];
                $lease_area=$record['lease_area'];
                $mine_code=$record['mine_code'];
                $registration_no=$record['registration_no'];
				$lmetal_content=$record['metal_content'];
				/*$loqty="";			//opening stock Qty
				$lograde="";		//opening stock grade
				$lpsale="";			//place of sale
				$lsqty="";			//sale qty
				$lsgrade="";		//Sale grade
				$lsvalue="";		//sale value
				$lclqty="";			//closing stock qty
				$lclgrade="";		//closing stock grade*/
				$marray=array();	//metal content
				$oarray=array();	//opening stock array
				$parray=array();	//Place of sale array
				$sarray=array();	//Sale array
				$carray=array();	//clossing stock array
				$lmcnt=-1;
				$locnt=-1;
				$lpcnt=-1;
				$lscnt=-1;
				$lccnt=-1;

			}
            if ($lmetal_content!=$record['metal_content'] || $lmcnt <0) {
				$lmcnt+=1;
				$marray[$lmcnt]['cont']=$record['metal_content'];  
				$lmetal_content=$record['metal_content'];
            } 

			if ($record['sale_5_step_sn']==1) {
				$locnt+=1;
				$oarray[$locnt]['qty']=$record['qty'];
				$oarray[$locnt]['grade']=$record['grade'];
				//$loqty=$record['qty'];
				//$lograde=$record['grade'];
			}
			if ($record['sale_5_step_sn']==2) {
				$lpcnt+=1;
				$parray[$lpcnt]['psale']=$record['place_of_sale'];
				//$lpsale=$record['place_of_sale'];
			}
			if ($record['sale_5_step_sn']==3) {
				$lscnt+=1;
				$sarray[$lscnt]['qty']=$record['qty'];
				$sarray[$lscnt]['grade']=$record['grade'];
				$sarray[$lscnt]['value']=$record['product_value'];
				//$lsqty=$record['qty'];
				//$lsgrade=$record['grade'];
				//$lsvalue=$record['product_value'];
			}
			if ($record['sale_5_step_sn']==4) {
				$lccnt+=1;
				$carray[$lccnt]['qty']=$record['qty'];
				$carray[$lccnt]['grade']=$record['grade'];
				//$lclqty=$record['qty'];
				//$lclgrade=$record['grade'];
			}

		}
		if ($lcnt>=0) {
			$larcount=count($oarray);
			if (count($parray)>$larcount) $larcount=count($parray);
			if (count($sarray)>$larcount) $larcount=count($sarray);
			if (count($carray)>$larcount) $larcount=count($carray);
			$lrowspan="";
			//if ($larcount>1) 
			//	$lrowspan=" rowspan=".$larcount."";
			for ($cnt=0; $cnt < $larcount; $cnt++) {			
				$lcounter+=1;
				$print.='<tr>
					<td '.$lrowspan.'>'.$lcounter.'</td>
					<td '.$lrowspan.'>'.$monthname.'</td>	
					<td '.$lrowspan.'>'.$mineral_name.'</td>
					<td '.$lrowspan.'>'.$state_name.'</td>
					<td '.$lrowspan.'>'.$district_name.'</td>
					<td '.$lrowspan.'>'.$MINE_NAME.'</td>
					<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
					<td '.$lrowspan.'>'.$lease_area.'</td>
					<td '.$lrowspan.'>'.$mine_code.'</td>
					<td '.$lrowspan.'>'.$registration_no.'</td>';

				//if ($cnt >0) 
				//	$print.='<tr>';

				$print.="<td>";
				if (isset($marray[$cnt]['cont']))
					$print.=$marray[$cnt]['cont'];
				$print.="</td>";						
				//1 start
				$print.="<td>";
				if (isset($oarray[$cnt]['qty']))
					$print.=$oarray[$cnt]['qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($oarray[$cnt]['grade']))
					$print.=$oarray[$cnt]['grade'];
				$print.="</td>";
				//1 end
				//2 start
				$print.="<td>";
				if (isset($parray[$cnt]['psale']))
					$print.=$parray[$cnt]['psale'];
				$print.="</td>";
				//2 end
				//3 start
				$print.="<td>";
				if (isset($sarray[$cnt]['qty']))
					$print.=$sarray[$cnt]['qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($sarray[$cnt]['grade']))
					$print.=$sarray[$cnt]['grade'];
				$print.="</td>";
				$print.="<td>";
				if (isset($sarray[$cnt]['value']))
					$print.=$sarray[$cnt]['value'];
				$print.="</td>";

				//3 end
				//4 start
				$print.="<td>";
				if (isset($carray[$cnt]['qty']))
					$print.=$carray[$cnt]['qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($carray[$cnt]['grade']))
					$print.=$carray[$cnt]['grade'];
				$print.="</td>";
				//4 end
				$print.='</tr>';
			}
			//if ($cnt >0) $print.='</tr>';
				
		}
		$print.='</tbody>
		</table>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>';
		}
		return $print;
	}
    public function reportM07()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $fromDate = $this->request->getData('from_date');
            $fromDate = explode(' ', $fromDate);
            $month1 = $fromDate[0];
			$month1 = $year1.$month1.'-01';
			$month01 = explode('-',$month1);
            $monthno = date('m', strtotime($month1));
            $year1 = $fromDate[1];
            $from_date = $year1 . '-' . $monthno . '-01';

            $toDate = $this->request->getData('to_date');
            $toDate = explode(' ', $toDate);
            $month2 = $toDate[0];
			$month2 = $year2.$month2.'-01';
			$month02 = explode('-',$month2);
            $monthno = date('m', strtotime($month2));
            $year2 = $toDate[1];
            $to_date = $year2 . '-' . $monthno . '-01';

            $from = $month1 . ' ' . $year1;
            $to =  $month2 . ' ' . $year2;

            $showDate = $month01[0] . ' ' . $year1 . ' To ' . $month02[0] . ' ' . $year2;

            $mineral = $this->request->getData('mineral');
            $mineral = strtolower($mineral);
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            $sql = "SELECT DISTINCT rr.past_surface_rent, rr.past_royalty, rr.past_dead_rent, rr.past_pay_dmf, rr.past_pay_nmet, rr.mine_code,
            ml.mcmdt_ML_Area AS lease_area, mw.mineral_name, m.MINE_NAME, m.lessee_owner_name, m.registration_no,
            s.state_name, d.district_name, '$from' AS fromDate , '$to' As toDate, EXTRACT(MONTH FROM rr.return_date)  AS showMonth, EXTRACT(YEAR FROM rr.return_date)  AS showYear
            FROM
			 tbl_final_submit tfs
					INNER JOIN 
				mine m ON m.mine_code = tfs.mine_code
                    INNER JOIN
                dir_state s ON m.state_code = s.state_code
                    INNER JOIN
                dir_district d ON m.district_code = d.district_code
                    AND s.state_code = d.state_code
                    INNER JOIN
                rent_returns rr ON m.mine_code = rr.mine_code
                    AND rr.return_type = '$returnType'
                    AND (rr.return_date BETWEEN '$from_date' AND '$to_date')
                    INNER JOIN
                mineral_worked mw ON rr.mine_code = mw.mine_code
                    AND m.mine_code = mw.mine_code
                    LEFT JOIN
                 mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode 
                    AND rr.mine_code = ml.mcmdt_mineCode
                    AND mw.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1
            WHERE
                rr.return_type = '$returnType' AND (rr.return_date BETWEEN '$from_date' AND '$to_date') AND tfs.is_latest = 1";

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND mw.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND rr.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_mineCode = '$lesseearea'";
            }
            // pr($sql);exit;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportM08()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $fromDate = $this->request->getData('from_date');
            $fromDate = explode(' ', $fromDate);
            $month1 = $fromDate[0];
			$month1 = $year1.$month1.'-01';
			$month01 = explode('-',$month1);
            $monthno = date('m', strtotime($month1));
            $year1 = $fromDate[1];
            $from_date = $year1 . '-' . $monthno . '-01';

            $toDate = $this->request->getData('to_date');
            $toDate = explode(' ', $toDate);
            $month2 = $toDate[0];
			$month2 = $year2.$month2.'-01';
			$month02 = explode('-',$month2);
            $monthno = date('m', strtotime($month2));
            $year2 = $toDate[1];
            $to_date = $year2 . '-' . $monthno . '-01';

            $from = $month1 . ' ' . $year1;
            $to =  $month2 . ' ' . $year2;

            $showDate = $month01[0] . ' ' . $year1 . ' To ' . $month02[0] . ' ' . $year2;

            $mineral = $this->request->getData('mineral');
            $mineral = strtolower($mineral);
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            // Changes Lease area table to get lease area Old table = mcp_lease Column name = under_forest_area, outside_forest_area
            // New table mc_minesleasearea_dt table used column name = mcmdt_ML_Area
            $sql = "SELECT DISTINCT rs.mine_code, rs.mineral_name, m.MINE_NAME, m.lessee_owner_name, m.registration_no, ml.mcmdt_ML_Area AS lease_area,
            s.state_name, d.district_name, rs.oc_type, rs.oc_qty, rs.ug_type, rs.ug_qty, '$from' AS fromDate , '$to' As toDate, EXTRACT(MONTH FROM rs.return_date)  AS showMonth, EXTRACT(YEAR FROM rs.return_date)  AS showYear
            FROM
				tbl_final_submit tfs
					INNER JOIN 
                mine m ON tfs.mine_code = m.mine_code
                    INNER JOIN
                dir_state s ON m.state_code = s.state_code
                    INNER JOIN
                dir_district d ON m.district_code = d.district_code
                    AND d.state_code = s.state_code
                    INNER JOIN
                rom_stone rs ON m.mine_code = rs.mine_code
                    AND rs.return_type = '$returnType'
                    AND (rs.return_date BETWEEN '$from_date' AND '$to_date')
					AND tfs.return_date = rs.return_date
                    AND tfs.return_type = rs.return_type
                    AND tfs.is_latest = 1					 
                    LEFT JOIN
                 mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode 
                    AND rs.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1
            WHERE
                rs.return_type = '$returnType' AND (rs.return_date BETWEEN '$from_date' AND '$to_date') AND tfs.is_latest = 1";

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND rs.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND rs.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
            // pr($sql);exit;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

   /* public function reportM09()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $fromDate = $this->request->getData('from_date');
            $fromDate = explode(' ', $fromDate);
            $month1 = $fromDate[0];
            $monthno = date('m', strtotime($month1));
            $year1 = $fromDate[1];
            $from_date = $year1 . '-' . $monthno . '-01';

            $toDate = $this->request->getData('to_date');
            $toDate = explode(' ', $toDate);
            $month2 = $toDate[0];
            $monthno = date('m', strtotime($month2));
            $year2 = $toDate[1];
            $to_date = $year2 . '-' . $monthno . '-01';

            $from = $month1 . ' ' . $year1;
            $to =  $month2 . ' ' . $year2;

            $showDate = $month1 . ' ' . $year1 . ' To ' . $month2 . ' ' . $year2;

            $mineral = $this->request->getData('mineral');
            $mineral = strtolower(str_replace(' ', '_', $mineral));
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            // Changes Lease area table to get lease area Old table = mcp_lease Column name = under_forest_area, outside_forest_area
            // New table mc_minesleasearea_dt table used column name = mcmdt_ML_Area          

            $sql = "SELECT DISTINCT m09_01.mine_code, m09_01.mineral_name, m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, ml.mcmdt_ML_Area AS lease_area,
					EXTRACT(MONTH FROM m09_01.return_date) AS showMonth, EXTRACT(YEAR FROM m09_01.return_date) AS showYear,  '$from' AS fromDate , '$to' As toDate,
					m09_01.rough_prod_no, m09_01.rough_prod_qty, m09_02.cut_prod_no, m09_02.cut_prod_qty, m09_03.industrial_prod_no, m09_03.industrial_prod_qty,
					m09_04.other_prod_no, m09_04.other_prod_qty
					FROM
					mine m
					 LEFT JOIN
					view_report_precious_semi_precious_production_detail_m09_01 m09_01 ON m.mine_code = m09_01.mine_code
						LEFT JOIN
					view_report_precious_semi_precious_production_detail_m09_02 m09_02 ON m.mine_code = m09_02.mine_code
						LEFT JOIN
					view_report_precious_semi_precious_production_detail_m09_03 m09_03 ON m.mine_code = m09_03.mine_code
						LEFT JOIN
					view_report_precious_semi_precious_production_detail_m09_04 m09_04 ON m.mine_code = m09_04.mine_code
						INNER JOIN
					dir_state s ON m.state_code = s.state_code
						INNER JOIN
					dir_district d ON m.district_code = d.district_code
						AND d.state_code = s.state_code		
						LEFT JOIN
					mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode
					  
					WHERE
						m09_01.return_type = '$returnType'
						AND (m09_01.return_date BETWEEN '$from_date' AND '$to_date')
						AND  m09_02.return_type = '$returnType'
						AND (m09_02.return_date BETWEEN '$from_date' AND '$to_date')
						AND  m09_03.return_type = '$returnType'
						AND (m09_03.return_date BETWEEN '$from_date' AND '$to_date')
						AND  m09_04.return_type = '$returnType'
						AND (m09_04.return_date BETWEEN '$from_date' AND '$to_date')";
            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND ps.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND ps.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
            $sql .= " GROUP BY m.mine_code";
            //print_r($sql);exit;
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }*/
	
	public function reportM09()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $fromDate = $this->request->getData('from_date');
            $fromDate = explode(' ', $fromDate);
            $month1 = $fromDate[0];
			$month1 = $year1.$month1.'-01';
			$month01 = explode('-',$month1);
            $monthno = date('m', strtotime($month1));
            $year1 = $fromDate[1];
            $from_date = $year1 . '-' . $monthno . '-01';

            $toDate = $this->request->getData('to_date');
            $toDate = explode(' ', $toDate);
            $month2 = $toDate[0];
			$month2 = $year2.$month2.'-01';
			$month02 = explode('-',$month2);
            $monthno = date('m', strtotime($month2));
            $year2 = $toDate[1];
            $to_date = $year2 . '-' . $monthno . '-01';

            $from = $month1 . ' ' . $year1;
            $to =  $month2 . ' ' . $year2;

            $showDate = $month01[0] . ' ' . $year1 . ' To ' . $month02[0] . ' ' . $year2;

            $mineral = $this->request->getData('mineral');
            $mineral = strtolower($mineral);
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            // Changes Lease area table to get lease area Old table = mcp_lease Column name = under_forest_area, outside_forest_area
            // New table mc_minesleasearea_dt table used column name = mcmdt_ML_Area          

           /* $sql = "SELECT DISTINCT m09_01.mine_code, m09_01.mineral_name, m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, ml.mcmdt_ML_Area AS lease_area,
					EXTRACT(MONTH FROM m09_01.return_date) AS showMonth, EXTRACT(YEAR FROM m09_01.return_date) AS showYear,  '$from' AS fromDate , '$to' As toDate,
					m09_01.rough_prod_no, m09_01.rough_prod_qty, m09_02.cut_prod_no, m09_02.cut_prod_qty, m09_03.industrial_prod_no, m09_03.industrial_prod_qty,
					m09_04.other_prod_no, m09_04.other_prod_qty
					FROM
					mine m
					 LEFT JOIN
					view_report_precious_semi_precious_production_detail_m09_01 m09_01 ON m.mine_code = m09_01.mine_code
						LEFT JOIN
					view_report_precious_semi_precious_production_detail_m09_02 m09_02 ON m.mine_code = m09_02.mine_code
						LEFT JOIN
					view_report_precious_semi_precious_production_detail_m09_03 m09_03 ON m.mine_code = m09_03.mine_code
						LEFT JOIN
					view_report_precious_semi_precious_production_detail_m09_04 m09_04 ON m.mine_code = m09_04.mine_code
						INNER JOIN
					dir_state s ON m.state_code = s.state_code
						INNER JOIN
					dir_district d ON m.district_code = d.district_code
						AND d.state_code = s.state_code		
						LEFT JOIN
					mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode
					  
					WHERE
						m09_01.return_type = '$returnType'
						AND (m09_01.return_date BETWEEN '$from_date' AND '$to_date')
						AND  m09_02.return_type = '$returnType'
						AND (m09_02.return_date BETWEEN '$from_date' AND '$to_date')
						AND  m09_03.return_type = '$returnType'
						AND (m09_03.return_date BETWEEN '$from_date' AND '$to_date')
						AND  m09_04.return_type = '$returnType'
						AND (m09_04.return_date BETWEEN '$from_date' AND '$to_date')"; */

            $sql = "SELECT m.MINE_NAME, m.lessee_owner_name, m.registration_no, ml.mcmdt_ML_Area AS lease_area, s.state_name,
                EXTRACT(MONTH FROM ps.return_date) AS showMonth, EXTRACT(YEAR FROM ps.return_date) AS showYear,  '$from' AS fromDate , '$to' As toDate,
               d.district_name, ps.prod_tot_no, ps.prod_tot_qty, ps.stone_sn, ps.mine_code, ps.mineral_name, ps.return_date,
               ps.return_type               
                FROM
              tbl_final_submit tfs
                   INNER JOIN
               prod_stone ps ON ps.mine_code = tfs.mine_code
                   AND ps.return_type = tfs.return_type
                   AND ps.return_date = tfs.return_date
                   INNER JOIN 
                mine m on m.mine_code = tfs.mine_code
                    INNER JOIN
               dir_state s ON m.state_code = s.state_code
                   INNER JOIN
               dir_district d ON m.district_code = d.district_code
                   AND d.state_code = s.state_code
                   LEFT JOIN
               mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1
                   WHERE 
               ps.return_type = '$returnType' AND (ps.return_date BETWEEN '$from_date' AND '$to_date') AND tfs.is_latest = 1";        

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND ps.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND ps.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
			$sql.=" order by ps.mineral_name,s.state_name,d.district_name,ps.return_date,ps.mine_code,ps.stone_sn ";
            //print_r($sql);exit;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $lprint=$this->generatem09($records,$showDate,$rowCount);
                $this->set('lprint',$lprint);				

                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount', $rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }
	public function generatem09($records,$showDate,$rowCount) {
       $lcnt=-1;
        $cnt=0;
        $lmineral_name = "";
        $lstate_name = "";
        $ldistrict_name = "";
        $lmonthnm = "";
        $lyearnm = "";
        $lmincode="";
		$lmetal_content="";
		$lserialno="";
        $lflg="";
		$lcounter=0;

		$marray=array();	//metal content
		$rarray=array();	//rough and uncut array
		$carray=array();	//Cut & Polished Stones array
		$iarray=array();	//Industrial array
		$oarray=array();	//Others array
		$lmcnt=-1;
		$locnt=-1;
		$lpcnt=-1;
		$lscnt=-1;
		$lccnt=-1;
		
		if ($rowCount <= 15000) { 
		
		$print = '<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="tHeadFont" id="heading1">Report M09 - Precious & Semi Precious Stone Grade wise Production Details (Form F3)</h4>
                    <div class="form-horizontal">
                        <div class="card-body" id="avb">
							<h6 class="tHeadDate"  id="heading2">Date : From '.$showDate .'</h6>';
		
		$print .='    
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" id="tableReport">
                                    <thead class="tableHead">
                                        <tr>
                                            <th rowspan="4">#</th>
                                            <th rowspan="4">Month</th> 
											<th rowspan="4">Mineral</th>
                                            <th rowspan="4">State</th>
                                            <th rowspan="4">District</th>   											
                                            <th rowspan="4">Name of Mine</th>
                                            <th rowspan="4">Name of Lease Owner</th>
                                            <th rowspan="4">Lease Area</th>
											<th rowspan="4">Mine Code</th>
                                            <th rowspan="4">IBM Registration Number</th>
                                            <th colspan="8"> Production</th>
                                        </tr>
                                        <tr>
                                            <th colspan="4">Gem Variety</th>
                                            <th colspan="2" rowspan="2">Industrial</th>
                                            <th colspan="2" rowspan="2">Others</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Rough & Uncut Stones</th>
                                            <th colspan="2">Cut & Polished Stones</th>
                                        </tr>
                                        <tr>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody">';
        foreach ($records as $record) {
            if ($lmineral_name != $record['mineral_name']) {
                $lmineral_name = $record['mineral_name'];
                $lflg="Y";
            }
            if ($lstate_name != $record['state_name']) {
                $lstate_name = $record['state_name'];
                $lflg="Y";
            }
            if ($ldistrict_name != $record['district_name']) {
                $ldistrict_name = $record['district_name'];
                $lflg="Y";
            }
            if ($lmonthnm != $record['showMonth']) {
                $lmonthnm  = $record['showMonth'];
                $lflg="Y";
            }
            if ($lyearnm != $record['showYear']) {
                $lyearnm  = $record['showYear'];
                $lflg="Y";
            }
            if ($lmincode!=$record['mine_code']) {
                $lmincode=$record['mine_code'];
                $lflg="Y";
            }
            //if ($lmetal_content!=$record['metal_content']) {
            //    $lflg="Y";
                
            //} 
            if ($lflg=="Y" || $lcnt <0) {
				if ($lcnt>=0) {
					$larcount=count($rarray);
					if (count($carray)>$larcount) $larcount=count($carray);
					if (count($iarray)>$larcount) $larcount=count($iarray);
					if (count($oarray)>$larcount) $larcount=count($oarray);
					$lrowspan="";
					if ($larcount>1) 
						$lrowspan=" rowspan=".$larcount."";
					
					$lcounter+=1;
					$print.='<tr>
						<td '.$lrowspan.'>'.$lcounter.'</td>
						<td '.$lrowspan.'>'.$monthname.'</td>	
						<td '.$lrowspan.'>'.$mineral_name.'</td>
						<td '.$lrowspan.'>'.$state_name.'</td>
						<td '.$lrowspan.'>'.$district_name.'</td>
						<td '.$lrowspan.'>'.$MINE_NAME.'</td>
						<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
						<td '.$lrowspan.'>'.$lease_area.'</td>
						<td '.$lrowspan.'>'.$mine_code.'</td>
						<td '.$lrowspan.'>'.$registration_no.'</td>';
					for ($cnt=0; $cnt < $larcount; $cnt++) {
						if ($cnt >0) 
							$print.='<tr>';
						//$print.="<td>";
						//if (isset($marray[$cnt]['cont']))
						//	$print.=$marray[$cnt]['cont'];
						//$print.="</td>";						
						//1 start
						$print.="<td>";
						if (isset($rarray[$cnt]['no']))
							$print.=$rarray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($rarray[$cnt]['qty']))
							$print.=$rarray[$cnt]['qty'];
						$print.="</td>";
						//1 end
						//2 start
						$print.="<td>";
						if (isset($carray[$cnt]['no']))
							$print.=$carray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($carray[$cnt]['qty']))
							$print.=$carray[$cnt]['qty'];
						$print.="</td>";
						//2 end
						//3 start
						$print.="<td>";
						if (isset($iarray[$cnt]['no']))
							$print.=$iarray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($iarray[$cnt]['qty']))
							$print.=$iarray[$cnt]['qty'];
						$print.="</td>";
						//3 end
						//99 start
						$print.="<td>";
						if (isset($oarray[$cnt]['no']))
							$print.=$oarray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($oarray[$cnt]['qty']))
							$print.=$oarray[$cnt]['qty'];
						$print.="</td>";
						//99 end
					}
					if ($cnt >0) $print.='</tr>';
						
				}
                $lcnt++;
                $lflg="";
                $cnt=0;
				$dbj   = \DateTime::createFromFormat('!m', $record['showMonth']);										  
				//Format it to month name
				$monthName = $dbj->format('F');
				//$monthName = $record['showMonth'];
                $monthname=$monthName.' '.$record['showYear'];	
                $mineral_name=ucwords(str_replace('_', ' ', $record['mineral_name']));
                $state_name=$record['state_name']; 
                $district_name=$record['district_name']; 
                $MINE_NAME=$record['MINE_NAME'] ;
                $lessee_owner_name=$record['lessee_owner_name'];
                $lease_area=$record['lease_area'];
                $mine_code=$record['mine_code'];
                $registration_no=$record['registration_no'];
				//$lmetal_content=$record['metal_content'];
				$marray=array();	//metal content
				$rarray=array();	//rough and uncut array
				$carray=array();	//Cut & Polished Stones array
				$iarray=array();	//Industrial array
				$oarray=array();	//Others array
				$lmcnt=-1;
				$locnt=-1;
				$lpcnt=-1;
				$lscnt=-1;
				$lccnt=-1;
			}

			if ($record['stone_sn']==1) {
				$locnt+=1;
				$rarray[$locnt]['no']=$record['prod_tot_no'];
				$rarray[$locnt]['qty']=$record['prod_tot_qty'];
			}
			if ($record['stone_sn']==2) {
				$lpcnt+=1;
				$carray[$lpcnt]['no']=$record['prod_tot_no'];
				$carray[$lpcnt]['qty']=$record['prod_tot_qty'];
			}
			if ($record['stone_sn']==3) {
				$lscnt+=1;
				$iarray[$lscnt]['no']=$record['prod_tot_no'];
				$iarray[$lscnt]['qty']=$record['prod_tot_qty'];

			}
			if ($record['stone_sn']==99) {
				$lccnt+=1;
				$oarray[$lccnt]['no']=$record['prod_tot_no'];
				$oarray[$lccnt]['qty']=$record['prod_tot_qty'];
			}

		}
		if ($lcnt>=0) {
			$larcount=count($rarray);
			if (count($carray)>$larcount) $larcount=count($carray);
			if (count($iarray)>$larcount) $larcount=count($iarray);
			if (count($oarray)>$larcount) $larcount=count($oarray);
			$lrowspan="";
			if ($larcount>1) 
				$lrowspan=" rowspan=".$larcount."";
			
			$lcounter+=1;
			$print.='<tr>
				<td '.$lrowspan.'>'.$lcounter.'</td>
				<td '.$lrowspan.'>'.$monthname.'</td>	
				<td '.$lrowspan.'>'.$mineral_name.'</td>
				<td '.$lrowspan.'>'.$state_name.'</td>
				<td '.$lrowspan.'>'.$district_name.'</td>
				<td '.$lrowspan.'>'.$MINE_NAME.'</td>
				<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
				<td '.$lrowspan.'>'.$lease_area.'</td>
				<td '.$lrowspan.'>'.$mine_code.'</td>
				<td '.$lrowspan.'>'.$registration_no.'</td>';
			for ($cnt=0; $cnt < $larcount; $cnt++) {
				if ($cnt >0) 
					$print.='<tr>';
				//$print.="<td>";
				//if (isset($marray[$cnt]['cont']))
				//	$print.=$marray[$cnt]['cont'];
				//$print.="</td>";						
				//1 start
				$print.="<td>";
				if (isset($rarray[$cnt]['no']))
					$print.=$rarray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($rarray[$cnt]['qty']))
					$print.=$rarray[$cnt]['qty'];
				$print.="</td>";
				//1 end
				//2 start
				$print.="<td>";
				if (isset($carray[$cnt]['no']))
					$print.=$carray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($carray[$cnt]['qty']))
					$print.=$carray[$cnt]['qty'];
				$print.="</td>";
				//2 end
				//3 start
				$print.="<td>";
				if (isset($iarray[$cnt]['no']))
					$print.=$iarray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($iarray[$cnt]['qty']))
					$print.=$iarray[$cnt]['qty'];
				$print.="</td>";
				//3 end
				//99 start
				$print.="<td>";
				if (isset($oarray[$cnt]['no']))
					$print.=$oarray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($oarray[$cnt]['qty']))
					$print.=$oarray[$cnt]['qty'];
				$print.="</td>";
				//99 end
			}
			if ($cnt >0) $print.='</tr>';
				
		}
		$print.= '</tbody>
		</table>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>';
		} else {
			$print = '<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="tHeadFont" id="heading1">Report M09 - Precious & Semi Precious Stone Grade wise Production Details (Form F3)</h4>
                    <div class="form-horizontal">
                        <div class="card-body" id="avb">
							<h6 class="tHeadDate"  id="heading2">Date : From '.$showDate .'</h6>';
			$print .='    
			<h6 class="tHeadDate" id="heading2"><strong>Since records are more hence no search & pagination service is available, you may use the option "Export to Excel"</strong></h6>
			<input type="button" id="downloadExcel" value="Export to Excel">
			<br /><br />
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" border="1" id="noDatatable">
                                    <thead class="tableHead">
										<tr>
											<th colspan="18" class="noDisplay" align="left">Report M09 - Precious & Semi Precious Stone Grade wise Production Details (Form F3) Date : From '.$showDate .'</th>
										</tr>
                                        <tr>
                                            <th rowspan="4">#</th>
                                            <th rowspan="4">Month</th> 
											<th rowspan="4">Mineral</th>
                                            <th rowspan="4">State</th>
                                            <th rowspan="4">District</th>   											
                                            <th rowspan="4">Name of Mine</th>
                                            <th rowspan="4">Name of Lease Owner</th>
                                            <th rowspan="4">Lease Area</th>
											<th rowspan="4">Mine Code</th>
                                            <th rowspan="4">IBM Registration Number</th>
                                            <th colspan="8"> Production</th>
                                        </tr>
                                        <tr>
                                            <th colspan="4">Gem Variety</th>
                                            <th colspan="2" rowspan="2">Industrial</th>
                                            <th colspan="2" rowspan="2">Others</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Rough & Uncut Stones</th>
                                            <th colspan="2">Cut & Polished Stones</th>
                                        </tr>
                                        <tr>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody">';
        foreach ($records as $record) {
            if ($lmineral_name != $record['mineral_name']) {
                $lmineral_name = $record['mineral_name'];
                $lflg="Y";
            }
            if ($lstate_name != $record['state_name']) {
                $lstate_name = $record['state_name'];
                $lflg="Y";
            }
            if ($ldistrict_name != $record['district_name']) {
                $ldistrict_name = $record['district_name'];
                $lflg="Y";
            }
            if ($lmonthnm != $record['showMonth']) {
                $lmonthnm  = $record['showMonth'];
                $lflg="Y";
            }
            if ($lyearnm != $record['showYear']) {
                $lyearnm  = $record['showYear'];
                $lflg="Y";
            }
            if ($lmincode!=$record['mine_code']) {
                $lmincode=$record['mine_code'];
                $lflg="Y";
            }
            //if ($lmetal_content!=$record['metal_content']) {
            //    $lflg="Y";
                
            //} 
            if ($lflg=="Y" || $lcnt <0) {
				if ($lcnt>=0) {
					$larcount=count($rarray);
					if (count($carray)>$larcount) $larcount=count($carray);
					if (count($iarray)>$larcount) $larcount=count($iarray);
					if (count($oarray)>$larcount) $larcount=count($oarray);
					$lrowspan="";
					if ($larcount>1) 
						$lrowspan=" rowspan=".$larcount."";
					
					$lcounter+=1;
					$print.='<tr>
						<td '.$lrowspan.'>'.$lcounter.'</td>
						<td '.$lrowspan.'>'.$monthname.'</td>	
						<td '.$lrowspan.'>'.$mineral_name.'</td>
						<td '.$lrowspan.'>'.$state_name.'</td>
						<td '.$lrowspan.'>'.$district_name.'</td>
						<td '.$lrowspan.'>'.$MINE_NAME.'</td>
						<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
						<td '.$lrowspan.'>'.$lease_area.'</td>
						<td '.$lrowspan.'>'.$mine_code.'</td>
						<td '.$lrowspan.'>'.$registration_no.'</td>';
					for ($cnt=0; $cnt < $larcount; $cnt++) {
						if ($cnt >0) 
							$print.='<tr>';
						//$print.="<td>";
						//if (isset($marray[$cnt]['cont']))
						//	$print.=$marray[$cnt]['cont'];
						//$print.="</td>";						
						//1 start
						$print.="<td>";
						if (isset($rarray[$cnt]['no']))
							$print.=$rarray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($rarray[$cnt]['qty']))
							$print.=$rarray[$cnt]['qty'];
						$print.="</td>";
						//1 end
						//2 start
						$print.="<td>";
						if (isset($carray[$cnt]['no']))
							$print.=$carray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($carray[$cnt]['qty']))
							$print.=$carray[$cnt]['qty'];
						$print.="</td>";
						//2 end
						//3 start
						$print.="<td>";
						if (isset($iarray[$cnt]['no']))
							$print.=$iarray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($iarray[$cnt]['qty']))
							$print.=$iarray[$cnt]['qty'];
						$print.="</td>";
						//3 end
						//99 start
						$print.="<td>";
						if (isset($oarray[$cnt]['no']))
							$print.=$oarray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($oarray[$cnt]['qty']))
							$print.=$oarray[$cnt]['qty'];
						$print.="</td>";
						//99 end
					}
					if ($cnt >0) $print.='</tr>';
						
				}
                $lcnt++;
                $lflg="";
                $cnt=0;
				$dbj   = \DateTime::createFromFormat('!m', $record['showMonth']);										  
				//Format it to month name
				$monthName = $dbj->format('F');
				//$monthName = $record['showMonth'];
                $monthname=$monthName.' '.$record['showYear'];	
                $mineral_name=ucwords(str_replace('_', ' ', $record['mineral_name']));
                $state_name=$record['state_name']; 
                $district_name=$record['district_name']; 
                $MINE_NAME=$record['MINE_NAME'] ;
                $lessee_owner_name=$record['lessee_owner_name'];
                $lease_area=$record['lease_area'];
                $mine_code=$record['mine_code'];
                $registration_no=$record['registration_no'];
				//$lmetal_content=$record['metal_content'];
				$marray=array();	//metal content
				$rarray=array();	//rough and uncut array
				$carray=array();	//Cut & Polished Stones array
				$iarray=array();	//Industrial array
				$oarray=array();	//Others array
				$lmcnt=-1;
				$locnt=-1;
				$lpcnt=-1;
				$lscnt=-1;
				$lccnt=-1;
			}

			if ($record['stone_sn']==1) {
				$locnt+=1;
				$rarray[$locnt]['no']=$record['prod_tot_no'];
				$rarray[$locnt]['qty']=$record['prod_tot_qty'];
			}
			if ($record['stone_sn']==2) {
				$lpcnt+=1;
				$carray[$lpcnt]['no']=$record['prod_tot_no'];
				$carray[$lpcnt]['qty']=$record['prod_tot_qty'];
			}
			if ($record['stone_sn']==3) {
				$lscnt+=1;
				$iarray[$lscnt]['no']=$record['prod_tot_no'];
				$iarray[$lscnt]['qty']=$record['prod_tot_qty'];

			}
			if ($record['stone_sn']==99) {
				$lccnt+=1;
				$oarray[$lccnt]['no']=$record['prod_tot_no'];
				$oarray[$lccnt]['qty']=$record['prod_tot_qty'];
			}

		}
		if ($lcnt>=0) {
			$larcount=count($rarray);
			if (count($carray)>$larcount) $larcount=count($carray);
			if (count($iarray)>$larcount) $larcount=count($iarray);
			if (count($oarray)>$larcount) $larcount=count($oarray);
			$lrowspan="";
			if ($larcount>1) 
				$lrowspan=" rowspan=".$larcount."";
			
			$lcounter+=1;
			$print.='<tr>
				<td '.$lrowspan.'>'.$lcounter.'</td>
				<td '.$lrowspan.'>'.$monthname.'</td>	
				<td '.$lrowspan.'>'.$mineral_name.'</td>
				<td '.$lrowspan.'>'.$state_name.'</td>
				<td '.$lrowspan.'>'.$district_name.'</td>
				<td '.$lrowspan.'>'.$MINE_NAME.'</td>
				<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
				<td '.$lrowspan.'>'.$lease_area.'</td>
				<td '.$lrowspan.'>'.$mine_code.'</td>
				<td '.$lrowspan.'>'.$registration_no.'</td>';
			for ($cnt=0; $cnt < $larcount; $cnt++) {
				if ($cnt >0) 
					$print.='<tr>';
				//$print.="<td>";
				//if (isset($marray[$cnt]['cont']))
				//	$print.=$marray[$cnt]['cont'];
				//$print.="</td>";						
				//1 start
				$print.="<td>";
				if (isset($rarray[$cnt]['no']))
					$print.=$rarray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($rarray[$cnt]['qty']))
					$print.=$rarray[$cnt]['qty'];
				$print.="</td>";
				//1 end
				//2 start
				$print.="<td>";
				if (isset($carray[$cnt]['no']))
					$print.=$carray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($carray[$cnt]['qty']))
					$print.=$carray[$cnt]['qty'];
				$print.="</td>";
				//2 end
				//3 start
				$print.="<td>";
				if (isset($iarray[$cnt]['no']))
					$print.=$iarray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($iarray[$cnt]['qty']))
					$print.=$iarray[$cnt]['qty'];
				$print.="</td>";
				//3 end
				//99 start
				$print.="<td>";
				if (isset($oarray[$cnt]['no']))
					$print.=$oarray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($oarray[$cnt]['qty']))
					$print.=$oarray[$cnt]['qty'];
				$print.="</td>";
				//99 end
			}
			if ($cnt >0) $print.='</tr>';
				
		}
		$print.= '</tbody>
		</table>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>';
		}
		
		return $print;

	}

   /* public function reportM10()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $fromDate = $this->request->getData('from_date');
            $fromDate = explode(' ', $fromDate);
            $month1 = $fromDate[0];
            $monthno = date('m', strtotime($month1));
            $year1 = $fromDate[1];
            $from_date = $year1 . '-' . $monthno . '-01';

            $toDate = $this->request->getData('to_date');
            $toDate = explode(' ', $toDate);
            $month2 = $toDate[0];
            $monthno = date('m', strtotime($month2));
            $year2 = $toDate[1];
            $to_date = $year2 . '-' . $monthno . '-01';

            $from = $month1 . ' ' . $year1;
            $to =  $month2 . ' ' . $year2;

            $showDate = $month1 . ' ' . $year1 . ' To ' . $month2 . ' ' . $year2;

            $mineral = $this->request->getData('mineral');
            $mineral = strtolower(str_replace(' ', '_', $mineral));
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            $sql = "SELECT DISTINCT m10_01.mine_code,m10_01.mineral_name, m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, ml.mcmdt_ML_Area AS lease_area,
					EXTRACT(MONTH FROM m10_01.return_date) AS showMonth, EXTRACT(YEAR FROM m10_01.return_date) AS showYear, '$from' AS fromDate , '$to' As toDate,
					m10_01.rough_open_prod_no, m10_01.rough_open_prod_qty, m10_01.rough_clos_prod_no, m10_01.rough_clos_prod_qty, m10_02.cut_open_prod_no, m10_02.cut_open_prod_qty,
					m10_02.cut_clos_prod_no, m10_02.cut_clos_prod_qty, m10_03.industrial_open_prod_no, m10_03.industrial_open_prod_qty, m10_03.industrial_clos_prod_no,
					m10_03.industrial_clos_prod_qty, m10_04.other_open_prod_no, m10_04.other_open_prod_qty, m10_04.other_clos_prod_no, m10_04.other_clos_prod_qty
					FROM
					mine m
						LEFT JOIN
					view_report_precious_semi_precious_open_close_stock_m10_01 m10_01 ON m.mine_code = m10_01.mine_code
						LEFT JOIN
					view_report_precious_semi_precious_open_close_stock_m10_02 m10_02 ON m.mine_code = m10_02.mine_code
						LEFT JOIN
					view_report_precious_semi_precious_open_close_stock_m10_03 m10_03 ON m.mine_code = m10_03.mine_code
						LEFT JOIN
					view_report_precious_semi_precious_open_close_stock_m10_04 m10_04 ON m.mine_code = m10_04.mine_code
						INNER JOIN
					dir_state s ON m.state_code = s.state_code
						INNER JOIN
					dir_district d ON m.district_code = d.district_code
						AND d.state_code = s.state_code        
						LEFT JOIN
					mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode						
					WHERE
					m10_01.return_type = '$returnType'
						AND (m10_01.return_date BETWEEN '$from_date' AND '$to_date')
						AND m10_02.return_type = '$returnType'
						AND (m10_02.return_date BETWEEN '$from_date' AND '$to_date')
						AND m10_03.return_type = '$returnType'
						AND (m10_03.return_date BETWEEN '$from_date' AND '$to_date')
						AND m10_04.return_type = '$returnType'
						AND (m10_04.return_date BETWEEN '$from_date' AND '$to_date')
						GROUP BY m.mine_code";
            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND ps.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND ps.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
            //print_r($sql);exit;
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }*/
	
	
	public function reportM10()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $fromDate = $this->request->getData('from_date');
            $fromDate = explode(' ', $fromDate);
            $month1 = $fromDate[0];
			$month1 = $year1.$month1.'-01';
			$month01 = explode('-',$month1);
            $monthno = date('m', strtotime($month1));
            $year1 = $fromDate[1];
            $from_date = $year1 . '-' . $monthno . '-01';

            $toDate = $this->request->getData('to_date');
            $toDate = explode(' ', $toDate);
            $month2 = $toDate[0];
			$month2 = $year2.$month2.'-01';
			$month02 = explode('-',$month2);
            $monthno = date('m', strtotime($month2));
            $year2 = $toDate[1];
            $to_date = $year2 . '-' . $monthno . '-01';

            $from = $month1 . ' ' . $year1;
            $to =  $month2 . ' ' . $year2;

            $showDate = $month01[0] . ' ' . $year1 . ' To ' . $month02[0] . ' ' . $year2;

            $mineral = $this->request->getData('mineral');
            $mineral = strtolower($mineral);
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

           /* $sql = "SELECT DISTINCT m10_01.mine_code,m10_01.mineral_name, m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, ml.mcmdt_ML_Area AS lease_area,
					EXTRACT(MONTH FROM m10_01.return_date) AS showMonth, EXTRACT(YEAR FROM m10_01.return_date) AS showYear, '$from' AS fromDate , '$to' As toDate,
					m10_01.rough_open_prod_no, m10_01.rough_open_prod_qty, m10_01.rough_clos_prod_no, m10_01.rough_clos_prod_qty, m10_02.cut_open_prod_no, m10_02.cut_open_prod_qty,
					m10_02.cut_clos_prod_no, m10_02.cut_clos_prod_qty, m10_03.industrial_open_prod_no, m10_03.industrial_open_prod_qty, m10_03.industrial_clos_prod_no,
					m10_03.industrial_clos_prod_qty, m10_04.other_open_prod_no, m10_04.other_open_prod_qty, m10_04.other_clos_prod_no, m10_04.other_clos_prod_qty
					FROM
					mine m
						LEFT JOIN
					view_report_precious_semi_precious_open_close_stock_m10_01 m10_01 ON m.mine_code = m10_01.mine_code
						LEFT JOIN
					view_report_precious_semi_precious_open_close_stock_m10_02 m10_02 ON m.mine_code = m10_02.mine_code
						LEFT JOIN
					view_report_precious_semi_precious_open_close_stock_m10_03 m10_03 ON m.mine_code = m10_03.mine_code
						LEFT JOIN
					view_report_precious_semi_precious_open_close_stock_m10_04 m10_04 ON m.mine_code = m10_04.mine_code
						INNER JOIN
					dir_state s ON m.state_code = s.state_code
						INNER JOIN
					dir_district d ON m.district_code = d.district_code
						AND d.state_code = s.state_code        
						LEFT JOIN
					mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode						
					WHERE
					m10_01.return_type = '$returnType'
						AND (m10_01.return_date BETWEEN '$from_date' AND '$to_date')
						AND m10_02.return_type = '$returnType'
						AND (m10_02.return_date BETWEEN '$from_date' AND '$to_date')
						AND m10_03.return_type = '$returnType'
						AND (m10_03.return_date BETWEEN '$from_date' AND '$to_date')
						AND m10_04.return_type = '$returnType'
						AND (m10_04.return_date BETWEEN '$from_date' AND '$to_date')
						GROUP BY m.mine_code";*/

            $sql = "SELECT m.MINE_NAME, m.lessee_owner_name, m.registration_no, ml.mcmdt_ML_Area AS lease_area, s.state_name,
                    d.district_name, EXTRACT(MONTH FROM ps.return_date) AS showMonth, EXTRACT(YEAR FROM ps.return_date) AS showYear, '$from' AS fromDate , '$to' As toDate,
                    ps.stone_sn, ps.open_tot_no, ps.open_tot_qty, ps.clos_tot_no, ps.clos_tot_qty,  ps.mine_code,
                    ps.mineral_name, ps.return_date, ps.return_type               
                    FROM
                    tbl_final_submit tfs
                        INNER JOIN
                    prod_stone ps ON ps.mine_code = tfs.mine_code
                        AND ps.return_type = tfs.return_type
                        AND ps.return_date = tfs.return_date
                        INNER JOIN 
                        mine m on m.mine_code = tfs.mine_code
                            INNER JOIN
                    dir_state s ON m.state_code = s.state_code
                        INNER JOIN
                    dir_district d ON m.district_code = d.district_code
                        AND d.state_code = s.state_code
                        LEFT JOIN
                    mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1
                        WHERE 
                    ps.return_type = '$returnType' AND (ps.return_date BETWEEN '$from_date' AND '$to_date') AND tfs.is_latest = 1";
            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND ps.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND ps.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
			$sql.=" order by ps.mineral_name,s.state_name,d.district_name,ps.return_date,ps.mine_code,ps.stone_sn ";
			
            //print_r($sql);exit;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $lprint=$this->generatem10($records,$showDate,$rowCount);
                $this->set('lprint',$lprint);				
				
                $this->set('records', $records);
                $this->set('showDate', $showDate);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }
	public function generatem10($records,$showDate,$rowCount) {
        $lcnt=-1;
        $cnt=0;
        $lmineral_name = "";
        $lstate_name = "";
        $ldistrict_name = "";
        $lmonthnm = "";
        $lyearnm = "";
        $lmincode="";
		$lmetal_content="";
		$lserialno="";
        $lflg="";
		$lcounter=0;

		$marray=array();	//metal content
		$rarray=array();	//rough and uncut array
		$carray=array();	//Cut & Polished Stones array
		$iarray=array();	//Industrial array
		$oarray=array();	//Others array
		$lmcnt=-1;
		$locnt=-1;
		$lpcnt=-1;
		$lscnt=-1;
		$lccnt=-1;
		
		if($rowCount <= 15000) {
		$print='  <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="tHeadFont" id="heading1">Report M10 - Precious & Semi Precious Stone Opening & Closing Stock Details (Form F3)</h4>
                    <div class="form-horizontal">
                        <div class="card-body" id="avb">
							<h6 class="tHeadDate"  id="heading2">Date : From '.$showDate.'</h6>';
							
        $print .= ' <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" id="tableReport">
                                    <thead class="tableHead">
                                        <tr>
                                            <th rowspan="4">#</th>
                                            <th rowspan="4">Month</th>    
											<th rowspan="4">Mineral</th>
                                            <th rowspan="4">State</th>
                                            <th rowspan="4">District</th>  
                                            <th rowspan="4">Name of Mine</th>
                                            <th rowspan="4">Name of Lease Owner</th>
                                            <th rowspan="4">Lease Area</th>
											 <th rowspan="4">Mine Code</th>
                                            <th rowspan="4">IBM Registration Number</th>
                                            <th colspan="8"> Opening Stock</th>
                                            <th colspan="8"> Closing Stock</th>
                                        </tr>
                                        <tr>
                                            <th colspan="4">Gem Variety</th>
                                            <th colspan="2" rowspan="2">Industrial</th>
                                            <th colspan="2" rowspan="2">Others</th>
                                            <th colspan="4">Gem Variety</th>
                                            <th colspan="2" rowspan="2">Industrial</th>
                                            <th colspan="2" rowspan="2">Others</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Rough & Uncut Stones</th>
                                            <th colspan="2">Cut & Polished Stones</th>
                                            <th colspan="2">Rough & Uncut Stones</th>
                                            <th colspan="2">Cut & Polished Stones</th>
                                        </tr>
                                        <tr>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody">';
        foreach ($records as $record) {
            if ($lmineral_name != $record['mineral_name']) {
                $lmineral_name = $record['mineral_name'];
                $lflg="Y";
            }
            if ($lstate_name != $record['state_name']) {
                $lstate_name = $record['state_name'];
                $lflg="Y";
            }
            if ($ldistrict_name != $record['district_name']) {
                $ldistrict_name = $record['district_name'];
                $lflg="Y";
            }
            if ($lmonthnm != $record['showMonth']) {
                $lmonthnm  = $record['showMonth'];
                $lflg="Y";
            }
            if ($lyearnm != $record['showYear']) {
                $lyearnm  = $record['showYear'];
                $lflg="Y";
            }
            if ($lmincode!=$record['mine_code']) {
                $lmincode=$record['mine_code'];
                $lflg="Y";
            }
            //if ($lmetal_content!=$record['metal_content']) {
            //    $lflg="Y";
                
            //} 
            if ($lflg=="Y" || $lcnt <0) {
				if ($lcnt>=0) {
					$larcount=count($rarray);
					if (count($carray)>$larcount) $larcount=count($carray);
					if (count($iarray)>$larcount) $larcount=count($iarray);
					if (count($oarray)>$larcount) $larcount=count($oarray);
					$lrowspan="";
					if ($larcount>1) 
						$lrowspan=" rowspan=".$larcount."";
					
					$lcounter+=1;
					$print.='<tr>
						<td '.$lrowspan.'>'.$lcounter.'</td>
						<td '.$lrowspan.'>'.$monthname.'</td>	
						<td '.$lrowspan.'>'.$mineral_name.'</td>
						<td '.$lrowspan.'>'.$state_name.'</td>
						<td '.$lrowspan.'>'.$district_name.'</td>
						<td '.$lrowspan.'>'.$MINE_NAME.'</td>
						<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
						<td '.$lrowspan.'>'.$lease_area.'</td>
						<td '.$lrowspan.'>'.$mine_code.'</td>
						<td '.$lrowspan.'>'.$registration_no.'</td>';
					for ($cnt=0; $cnt < $larcount; $cnt++) {
						if ($cnt >0) 
							$print.='<tr>';
						//$print.="<td>";
						//if (isset($marray[$cnt]['cont']))
						//	$print.=$marray[$cnt]['cont'];
						//$print.="</td>";
						//opening Stock starts here
						//1 start
						$print.="<td>";
						if (isset($rarray[$cnt]['no']))
							$print.=$rarray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($rarray[$cnt]['qty']))
							$print.=$rarray[$cnt]['qty'];
						$print.="</td>";
						//1 end
						//2 start
						$print.="<td>";
						if (isset($carray[$cnt]['no']))
							$print.=$carray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($carray[$cnt]['qty']))
							$print.=$carray[$cnt]['qty'];
						$print.="</td>";
						//2 end
						//3 start
						$print.="<td>";
						if (isset($iarray[$cnt]['no']))
							$print.=$iarray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($iarray[$cnt]['qty']))
							$print.=$iarray[$cnt]['qty'];
						$print.="</td>";
						//3 end
						//99 start
						$print.="<td>";
						if (isset($oarray[$cnt]['no']))
							$print.=$oarray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($oarray[$cnt]['qty']))
							$print.=$oarray[$cnt]['qty'];
						$print.="</td>";
						//99 end
						//open stock ends here
						//Closing STock starts here
						//1 start
						$print.="<td>";
						if (isset($rarray[$cnt]['cno']))
							$print.=$rarray[$cnt]['cno'];
						$print.="</td>";
						$print.="<td>";
						if (isset($rarray[$cnt]['cqty']))
							$print.=$rarray[$cnt]['cqty'];
						$print.="</td>";
						//1 end
						//2 start
						$print.="<td>";
						if (isset($carray[$cnt]['cno']))
							$print.=$carray[$cnt]['cno'];
						$print.="</td>";
						$print.="<td>";
						if (isset($carray[$cnt]['cqty']))
							$print.=$carray[$cnt]['cqty'];
						$print.="</td>";
						//2 end
						//3 start
						$print.="<td>";
						if (isset($iarray[$cnt]['cno']))
							$print.=$iarray[$cnt]['cno'];
						$print.="</td>";
						$print.="<td>";
						if (isset($iarray[$cnt]['cqty']))
							$print.=$iarray[$cnt]['cqty'];
						$print.="</td>";
						//3 end
						//99 start
						$print.="<td>";
						if (isset($oarray[$cnt]['cno']))
							$print.=$oarray[$cnt]['cno'];
						$print.="</td>";
						$print.="<td>";
						if (isset($oarray[$cnt]['cqty']))
							$print.=$oarray[$cnt]['cqty'];
						$print.="</td>";
						//99 end
						//closing stock ends here
					}
					if ($cnt >0) $print.='</tr>';
						
				}
                $lcnt++;
                $lflg="";
                $cnt=0;
				$dbj   = \DateTime::createFromFormat('!m', $record['showMonth']);										  
				//Format it to month name
				$monthName = $dbj->format('F');
				//$monthName = $record['showMonth'];
                $monthname=$monthName.' '.$record['showYear'];	
                $mineral_name=ucwords(str_replace('_', ' ', $record['mineral_name']));
                $state_name=$record['state_name']; 
                $district_name=$record['district_name']; 
                $MINE_NAME=$record['MINE_NAME'] ;
                $lessee_owner_name=$record['lessee_owner_name'];
                $lease_area=$record['lease_area'];
                $mine_code=$record['mine_code'];
                $registration_no=$record['registration_no'];
				//$lmetal_content=$record['metal_content'];
				$marray=array();	//metal content
				$rarray=array();	//rough and uncut array
				$carray=array();	//Cut & Polished Stones array
				$iarray=array();	//Industrial array
				$oarray=array();	//Others array
				$lmcnt=-1;
				$locnt=-1;
				$lpcnt=-1;
				$lscnt=-1;
				$lccnt=-1;
			}

			if ($record['stone_sn']==1) {
				$locnt+=1;
				$rarray[$locnt]['no']=$record['open_tot_no'];
				$rarray[$locnt]['qty']=$record['open_tot_qty'];
				$rarray[$locnt]['cno']=$record['clos_tot_no'];
				$rarray[$locnt]['cqty']=$record['clos_tot_qty'];
			}
			if ($record['stone_sn']==2) {
				$lpcnt+=1;
				$carray[$lpcnt]['no']=$record['open_tot_no'];
				$carray[$lpcnt]['qty']=$record['open_tot_qty'];
				$carray[$lpcnt]['cno']=$record['clos_tot_no'];
				$carray[$lpcnt]['cqty']=$record['clos_tot_qty'];
			}
			if ($record['stone_sn']==3) {
				$lscnt+=1;
				$iarray[$lscnt]['no']=$record['open_tot_no'];
				$iarray[$lscnt]['qty']=$record['open_tot_qty'];
				$iarray[$lscnt]['cno']=$record['clos_tot_no'];
				$iarray[$lscnt]['cqty']=$record['clos_tot_qty'];

			}
			if ($record['stone_sn']==99) {
				$lccnt+=1;
				$oarray[$lccnt]['no']=$record['open_tot_no'];
				$oarray[$lccnt]['qty']=$record['open_tot_qty'];
				$oarray[$lccnt]['cno']=$record['clos_tot_no'];
				$oarray[$lccnt]['cqty']=$record['clos_tot_qty'];
			}

		}
		if ($lcnt>=0) {
			$larcount=count($rarray);
			if (count($carray)>$larcount) $larcount=count($carray);
			if (count($iarray)>$larcount) $larcount=count($iarray);
			if (count($oarray)>$larcount) $larcount=count($oarray);
			$lrowspan="";
			if ($larcount>1) 
				$lrowspan=" rowspan=".$larcount."";
			
			$lcounter+=1;
			$print.='<tr>
				<td '.$lrowspan.'>'.$lcounter.'</td>
				<td '.$lrowspan.'>'.$monthname.'</td>	
				<td '.$lrowspan.'>'.$mineral_name.'</td>
				<td '.$lrowspan.'>'.$state_name.'</td>
				<td '.$lrowspan.'>'.$district_name.'</td>
				<td '.$lrowspan.'>'.$MINE_NAME.'</td>
				<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
				<td '.$lrowspan.'>'.$lease_area.'</td>
				<td '.$lrowspan.'>'.$mine_code.'</td>
				<td '.$lrowspan.'>'.$registration_no.'</td>';
			for ($cnt=0; $cnt < $larcount; $cnt++) {
				if ($cnt >0) 
					$print.='<tr>';
				//$print.="<td>";
				//if (isset($marray[$cnt]['cont']))
				//	$print.=$marray[$cnt]['cont'];
				//$print.="</td>";
				//opening Stock starts here
				//1 start
				$print.="<td>";
				if (isset($rarray[$cnt]['no']))
					$print.=$rarray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($rarray[$cnt]['qty']))
					$print.=$rarray[$cnt]['qty'];
				$print.="</td>";
				//1 end
				//2 start
				$print.="<td>";
				if (isset($carray[$cnt]['no']))
					$print.=$carray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($carray[$cnt]['qty']))
					$print.=$carray[$cnt]['qty'];
				$print.="</td>";
				//2 end
				//3 start
				$print.="<td>";
				if (isset($iarray[$cnt]['no']))
					$print.=$iarray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($iarray[$cnt]['qty']))
					$print.=$iarray[$cnt]['qty'];
				$print.="</td>";
				//3 end
				//99 start
				$print.="<td>";
				if (isset($oarray[$cnt]['no']))
					$print.=$oarray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($oarray[$cnt]['qty']))
					$print.=$oarray[$cnt]['qty'];
				$print.="</td>";
				//99 end
				//open stock ends here
				//Closing STock starts here
				//1 start
				$print.="<td>";
				if (isset($rarray[$cnt]['cno']))
					$print.=$rarray[$cnt]['cno'];
				$print.="</td>";
				$print.="<td>";
				if (isset($rarray[$cnt]['cqty']))
					$print.=$rarray[$cnt]['cqty'];
				$print.="</td>";
				//1 end
				//2 start
				$print.="<td>";
				if (isset($carray[$cnt]['cno']))
					$print.=$carray[$cnt]['cno'];
				$print.="</td>";
				$print.="<td>";
				if (isset($carray[$cnt]['cqty']))
					$print.=$carray[$cnt]['cqty'];
				$print.="</td>";
				//2 end
				//3 start
				$print.="<td>";
				if (isset($iarray[$cnt]['cno']))
					$print.=$iarray[$cnt]['cno'];
				$print.="</td>";
				$print.="<td>";
				if (isset($iarray[$cnt]['cqty']))
					$print.=$iarray[$cnt]['cqty'];
				$print.="</td>";
				//3 end
				//99 start
				$print.="<td>";
				if (isset($oarray[$cnt]['cno']))
					$print.=$oarray[$cnt]['cno'];
				$print.="</td>";
				$print.="<td>";
				if (isset($oarray[$cnt]['cqty']))
					$print.=$oarray[$cnt]['cqty'];
				$print.="</td>";
				//99 end
				//closing stock ends here
			}
			if ($cnt >0) $print.='</tr>';
				
		}
		
		$print.= '</tbody>
		</table>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>';
		} else {
			$print='  <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="tHeadFont" id="heading1">Report M10 - Precious & Semi Precious Stone Opening & Closing Stock Details (Form F3)</h4>
                    <div class="form-horizontal">
                        <div class="card-body" id="avb">
							<h6 class="tHeadDate"  id="heading2">Date : From '.$showDate.'</h6>';
							
        $print .= ' 
					<h6 class="tHeadDate" id="heading2"><strong>Since records are more hence no search & pagination service is available, you may use the option "Export to Excel"</strong></h6>
					<input type="button" id="downloadExcel" value="Export to Excel">
					<br /><br />
					<div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" border="1" id="noDatatable">
                                    <thead class="tableHead">
										<tr>
											<th colspan="26" class="noDisplay" align="left">Report M10 - Precious & Semi Precious Stone Opening & Closing Stock Details (Form F3) Date : From '.$showDate.'</th>
										</tr>
                                        <tr>
                                            <th rowspan="4">#</th>
                                            <th rowspan="4">Month</th>    
											<th rowspan="4">Mineral</th>
                                            <th rowspan="4">State</th>
                                            <th rowspan="4">District</th>  
                                            <th rowspan="4">Name of Mine</th>
                                            <th rowspan="4">Name of Lease Owner</th>
                                            <th rowspan="4">Lease Area</th>
											 <th rowspan="4">Mine Code</th>
                                            <th rowspan="4">IBM Registration Number</th>
                                            <th colspan="8"> Opening Stock</th>
                                            <th colspan="8"> Closing Stock</th>
                                        </tr>
                                        <tr>
                                            <th colspan="4">Gem Variety</th>
                                            <th colspan="2" rowspan="2">Industrial</th>
                                            <th colspan="2" rowspan="2">Others</th>
                                            <th colspan="4">Gem Variety</th>
                                            <th colspan="2" rowspan="2">Industrial</th>
                                            <th colspan="2" rowspan="2">Others</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Rough & Uncut Stones</th>
                                            <th colspan="2">Cut & Polished Stones</th>
                                            <th colspan="2">Rough & Uncut Stones</th>
                                            <th colspan="2">Cut & Polished Stones</th>
                                        </tr>
                                        <tr>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody">';
        foreach ($records as $record) {
            if ($lmineral_name != $record['mineral_name']) {
                $lmineral_name = $record['mineral_name'];
                $lflg="Y";
            }
            if ($lstate_name != $record['state_name']) {
                $lstate_name = $record['state_name'];
                $lflg="Y";
            }
            if ($ldistrict_name != $record['district_name']) {
                $ldistrict_name = $record['district_name'];
                $lflg="Y";
            }
            if ($lmonthnm != $record['showMonth']) {
                $lmonthnm  = $record['showMonth'];
                $lflg="Y";
            }
            if ($lyearnm != $record['showYear']) {
                $lyearnm  = $record['showYear'];
                $lflg="Y";
            }
            if ($lmincode!=$record['mine_code']) {
                $lmincode=$record['mine_code'];
                $lflg="Y";
            }
            //if ($lmetal_content!=$record['metal_content']) {
            //    $lflg="Y";
                
            //} 
            if ($lflg=="Y" || $lcnt <0) {
				if ($lcnt>=0) {
					$larcount=count($rarray);
					if (count($carray)>$larcount) $larcount=count($carray);
					if (count($iarray)>$larcount) $larcount=count($iarray);
					if (count($oarray)>$larcount) $larcount=count($oarray);
					$lrowspan="";
					if ($larcount>1) 
						$lrowspan=" rowspan=".$larcount."";
					
					$lcounter+=1;
					$print.='<tr>
						<td '.$lrowspan.'>'.$lcounter.'</td>
						<td '.$lrowspan.'>'.$monthname.'</td>	
						<td '.$lrowspan.'>'.$mineral_name.'</td>
						<td '.$lrowspan.'>'.$state_name.'</td>
						<td '.$lrowspan.'>'.$district_name.'</td>
						<td '.$lrowspan.'>'.$MINE_NAME.'</td>
						<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
						<td '.$lrowspan.'>'.$lease_area.'</td>
						<td '.$lrowspan.'>'.$mine_code.'</td>
						<td '.$lrowspan.'>'.$registration_no.'</td>';
					for ($cnt=0; $cnt < $larcount; $cnt++) {
						if ($cnt >0) 
							$print.='<tr>';
						//$print.="<td>";
						//if (isset($marray[$cnt]['cont']))
						//	$print.=$marray[$cnt]['cont'];
						//$print.="</td>";
						//opening Stock starts here
						//1 start
						$print.="<td>";
						if (isset($rarray[$cnt]['no']))
							$print.=$rarray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($rarray[$cnt]['qty']))
							$print.=$rarray[$cnt]['qty'];
						$print.="</td>";
						//1 end
						//2 start
						$print.="<td>";
						if (isset($carray[$cnt]['no']))
							$print.=$carray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($carray[$cnt]['qty']))
							$print.=$carray[$cnt]['qty'];
						$print.="</td>";
						//2 end
						//3 start
						$print.="<td>";
						if (isset($iarray[$cnt]['no']))
							$print.=$iarray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($iarray[$cnt]['qty']))
							$print.=$iarray[$cnt]['qty'];
						$print.="</td>";
						//3 end
						//99 start
						$print.="<td>";
						if (isset($oarray[$cnt]['no']))
							$print.=$oarray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($oarray[$cnt]['qty']))
							$print.=$oarray[$cnt]['qty'];
						$print.="</td>";
						//99 end
						//open stock ends here
						//Closing STock starts here
						//1 start
						$print.="<td>";
						if (isset($rarray[$cnt]['cno']))
							$print.=$rarray[$cnt]['cno'];
						$print.="</td>";
						$print.="<td>";
						if (isset($rarray[$cnt]['cqty']))
							$print.=$rarray[$cnt]['cqty'];
						$print.="</td>";
						//1 end
						//2 start
						$print.="<td>";
						if (isset($carray[$cnt]['cno']))
							$print.=$carray[$cnt]['cno'];
						$print.="</td>";
						$print.="<td>";
						if (isset($carray[$cnt]['cqty']))
							$print.=$carray[$cnt]['cqty'];
						$print.="</td>";
						//2 end
						//3 start
						$print.="<td>";
						if (isset($iarray[$cnt]['cno']))
							$print.=$iarray[$cnt]['cno'];
						$print.="</td>";
						$print.="<td>";
						if (isset($iarray[$cnt]['cqty']))
							$print.=$iarray[$cnt]['cqty'];
						$print.="</td>";
						//3 end
						//99 start
						$print.="<td>";
						if (isset($oarray[$cnt]['cno']))
							$print.=$oarray[$cnt]['cno'];
						$print.="</td>";
						$print.="<td>";
						if (isset($oarray[$cnt]['cqty']))
							$print.=$oarray[$cnt]['cqty'];
						$print.="</td>";
						//99 end
						//closing stock ends here
					}
					if ($cnt >0) $print.='</tr>';
						
				}
                $lcnt++;
                $lflg="";
                $cnt=0;
				$dbj   = \DateTime::createFromFormat('!m', $record['showMonth']);										  
				//Format it to month name
				$monthName = $dbj->format('F');
				//$monthName = $record['showMonth'];
                $monthname=$monthName.' '.$record['showYear'];	
                $mineral_name=ucwords(str_replace('_', ' ', $record['mineral_name']));
                $state_name=$record['state_name']; 
                $district_name=$record['district_name']; 
                $MINE_NAME=$record['MINE_NAME'] ;
                $lessee_owner_name=$record['lessee_owner_name'];
                $lease_area=$record['lease_area'];
                $mine_code=$record['mine_code'];
                $registration_no=$record['registration_no'];
				//$lmetal_content=$record['metal_content'];
				$marray=array();	//metal content
				$rarray=array();	//rough and uncut array
				$carray=array();	//Cut & Polished Stones array
				$iarray=array();	//Industrial array
				$oarray=array();	//Others array
				$lmcnt=-1;
				$locnt=-1;
				$lpcnt=-1;
				$lscnt=-1;
				$lccnt=-1;
			}

			if ($record['stone_sn']==1) {
				$locnt+=1;
				$rarray[$locnt]['no']=$record['open_tot_no'];
				$rarray[$locnt]['qty']=$record['open_tot_qty'];
				$rarray[$locnt]['cno']=$record['clos_tot_no'];
				$rarray[$locnt]['cqty']=$record['clos_tot_qty'];
			}
			if ($record['stone_sn']==2) {
				$lpcnt+=1;
				$carray[$lpcnt]['no']=$record['open_tot_no'];
				$carray[$lpcnt]['qty']=$record['open_tot_qty'];
				$carray[$lpcnt]['cno']=$record['clos_tot_no'];
				$carray[$lpcnt]['cqty']=$record['clos_tot_qty'];
			}
			if ($record['stone_sn']==3) {
				$lscnt+=1;
				$iarray[$lscnt]['no']=$record['open_tot_no'];
				$iarray[$lscnt]['qty']=$record['open_tot_qty'];
				$iarray[$lscnt]['cno']=$record['clos_tot_no'];
				$iarray[$lscnt]['cqty']=$record['clos_tot_qty'];

			}
			if ($record['stone_sn']==99) {
				$lccnt+=1;
				$oarray[$lccnt]['no']=$record['open_tot_no'];
				$oarray[$lccnt]['qty']=$record['open_tot_qty'];
				$oarray[$lccnt]['cno']=$record['clos_tot_no'];
				$oarray[$lccnt]['cqty']=$record['clos_tot_qty'];
			}

		}
		if ($lcnt>=0) {
			$larcount=count($rarray);
			if (count($carray)>$larcount) $larcount=count($carray);
			if (count($iarray)>$larcount) $larcount=count($iarray);
			if (count($oarray)>$larcount) $larcount=count($oarray);
			$lrowspan="";
			if ($larcount>1) 
				$lrowspan=" rowspan=".$larcount."";
			
			$lcounter+=1;
			$print.='<tr>
				<td '.$lrowspan.'>'.$lcounter.'</td>
				<td '.$lrowspan.'>'.$monthname.'</td>	
				<td '.$lrowspan.'>'.$mineral_name.'</td>
				<td '.$lrowspan.'>'.$state_name.'</td>
				<td '.$lrowspan.'>'.$district_name.'</td>
				<td '.$lrowspan.'>'.$MINE_NAME.'</td>
				<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
				<td '.$lrowspan.'>'.$lease_area.'</td>
				<td '.$lrowspan.'>'.$mine_code.'</td>
				<td '.$lrowspan.'>'.$registration_no.'</td>';
			for ($cnt=0; $cnt < $larcount; $cnt++) {
				if ($cnt >0) 
					$print.='<tr>';
				//$print.="<td>";
				//if (isset($marray[$cnt]['cont']))
				//	$print.=$marray[$cnt]['cont'];
				//$print.="</td>";
				//opening Stock starts here
				//1 start
				$print.="<td>";
				if (isset($rarray[$cnt]['no']))
					$print.=$rarray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($rarray[$cnt]['qty']))
					$print.=$rarray[$cnt]['qty'];
				$print.="</td>";
				//1 end
				//2 start
				$print.="<td>";
				if (isset($carray[$cnt]['no']))
					$print.=$carray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($carray[$cnt]['qty']))
					$print.=$carray[$cnt]['qty'];
				$print.="</td>";
				//2 end
				//3 start
				$print.="<td>";
				if (isset($iarray[$cnt]['no']))
					$print.=$iarray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($iarray[$cnt]['qty']))
					$print.=$iarray[$cnt]['qty'];
				$print.="</td>";
				//3 end
				//99 start
				$print.="<td>";
				if (isset($oarray[$cnt]['no']))
					$print.=$oarray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($oarray[$cnt]['qty']))
					$print.=$oarray[$cnt]['qty'];
				$print.="</td>";
				//99 end
				//open stock ends here
				//Closing STock starts here
				//1 start
				$print.="<td>";
				if (isset($rarray[$cnt]['cno']))
					$print.=$rarray[$cnt]['cno'];
				$print.="</td>";
				$print.="<td>";
				if (isset($rarray[$cnt]['cqty']))
					$print.=$rarray[$cnt]['cqty'];
				$print.="</td>";
				//1 end
				//2 start
				$print.="<td>";
				if (isset($carray[$cnt]['cno']))
					$print.=$carray[$cnt]['cno'];
				$print.="</td>";
				$print.="<td>";
				if (isset($carray[$cnt]['cqty']))
					$print.=$carray[$cnt]['cqty'];
				$print.="</td>";
				//2 end
				//3 start
				$print.="<td>";
				if (isset($iarray[$cnt]['cno']))
					$print.=$iarray[$cnt]['cno'];
				$print.="</td>";
				$print.="<td>";
				if (isset($iarray[$cnt]['cqty']))
					$print.=$iarray[$cnt]['cqty'];
				$print.="</td>";
				//3 end
				//99 start
				$print.="<td>";
				if (isset($oarray[$cnt]['cno']))
					$print.=$oarray[$cnt]['cno'];
				$print.="</td>";
				$print.="<td>";
				if (isset($oarray[$cnt]['cqty']))
					$print.=$oarray[$cnt]['cqty'];
				$print.="</td>";
				//99 end
				//closing stock ends here
			}
			if ($cnt >0) $print.='</tr>';
				
		}
		
		$print.= '</tbody>
		</table>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>';
		}
		return $print;
	}


    /*public function reportM11()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $fromDate = $this->request->getData('from_date');
            $fromDate = explode(' ', $fromDate);
            $month1 = $fromDate[0];
            $monthno = date('m', strtotime($month1));
            $year1 = $fromDate[1];
            $from_date = $year1 . '-' . $monthno . '-01';

            $toDate = $this->request->getData('to_date');
            $toDate = explode(' ', $toDate);
            $month2 = $toDate[0];
            $monthno = date('m', strtotime($month2));
            $year2 = $toDate[1];
            $to_date = $year2 . '-' . $monthno . '-01';

            $from = $month1 . ' ' . $year1;
            $to =  $month2 . ' ' . $year2;

            $showDate = $month1 . ' ' . $year1 . ' To ' . $month2 . ' ' . $year2;

            $mineral = $this->request->getData('mineral');
            $mineral = strtolower(str_replace(' ', '_', $mineral));
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            $sql = "SELECT DISTINCT m.mine_code, m11_01.mineral_name, m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, ml.mcmdt_ML_Area AS lease_area,
					EXTRACT(MONTH FROM m11_01.return_date) AS showMonth, EXTRACT(YEAR FROM m11_01.return_date) AS showYear,'$from' AS fromDate , '$to' As toDate, m11_01.*,
					m11_02.cut_pmv_prod_no, m11_03.industrial_pmv_prod_no, m11_04.other_pmv_prod_no
					FROM				   
					mine m 
						LEFT JOIN
					view_report_precious_semi_precious_exmine_price_m11_01 m11_01 ON m.mine_code = m11_01.mine_code					  
						LEFT JOIN
					view_report_precious_semi_precious_exmine_price_m11_02 m11_02 ON m.mine_code = m11_02.mine_code					   
						LEFT JOIN
					view_report_precious_semi_precious_exmine_price_m11_03 m11_03 ON m.mine_code = m11_03.mine_code					   
						LEFT JOIN
					view_report_precious_semi_precious_exmine_price_m11_04 m11_04 ON m.mine_code = m11_04.mine_code					   
						INNER JOIN
					dir_state s ON m.state_code = s.state_code
						INNER JOIN
					dir_district d ON m.district_code = d.district_code
						AND d.state_code = s.state_code
						LEFT JOIN
					mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode
					WHERE
					 m11_01.return_type = '$returnType'
						 AND (m11_01.return_date BETWEEN '$from_date' AND '$to_date')
						 AND  m11_02.return_type = '$returnType'
						 AND (m11_02.return_date BETWEEN '$from_date' AND '$to_date')
						 AND  m11_03.return_type = '$returnType'
						 AND (m11_03.return_date BETWEEN '$from_date' AND '$to_date')
						 AND  m11_04.return_type = '$returnType'
						 AND (m11_04.return_date BETWEEN '$from_date' AND '$to_date')					   
						group by m.mine_code";
            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND m11_01.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND m11_01.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
            //pr($sql);die;
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }*/
	
	
	public function reportM11()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $fromDate = $this->request->getData('from_date');
            $fromDate = explode(' ', $fromDate);
            $month1 = $fromDate[0];
			$month1 = $year1.$month1.'-01';
			$month01 = explode('-',$month1);
            $monthno = date('m', strtotime($month1));
            $year1 = $fromDate[1];
            $from_date = $year1 . '-' . $monthno . '-01';

            $toDate = $this->request->getData('to_date');
            $toDate = explode(' ', $toDate);
            $month2 = $toDate[0];
			$month2 = $year2.$month2.'-01';
			$month02 = explode('-',$month2);
            $monthno = date('m', strtotime($month2));
            $year2 = $toDate[1];
            $to_date = $year2 . '-' . $monthno . '-01';

            $from = $month1 . ' ' . $year1;
            $to =  $month2 . ' ' . $year2;

            $showDate = $month01[0] . ' ' . $year1 . ' To ' . $month02[0] . ' ' . $year2;

            $mineral = $this->request->getData('mineral');
            $mineral = strtolower($mineral);
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            /*$sql = "SELECT DISTINCT m.mine_code, m11_01.mineral_name, m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, ml.mcmdt_ML_Area AS lease_area,
					EXTRACT(MONTH FROM m11_01.return_date) AS showMonth, EXTRACT(YEAR FROM m11_01.return_date) AS showYear,'$from' AS fromDate , '$to' As toDate, m11_01.*,
					m11_02.cut_pmv_prod_no, m11_03.industrial_pmv_prod_no, m11_04.other_pmv_prod_no
					FROM				   
					mine m 
						LEFT JOIN
					view_report_precious_semi_precious_exmine_price_m11_01 m11_01 ON m.mine_code = m11_01.mine_code					  
						LEFT JOIN
					view_report_precious_semi_precious_exmine_price_m11_02 m11_02 ON m.mine_code = m11_02.mine_code					   
						LEFT JOIN
					view_report_precious_semi_precious_exmine_price_m11_03 m11_03 ON m.mine_code = m11_03.mine_code					   
						LEFT JOIN
					view_report_precious_semi_precious_exmine_price_m11_04 m11_04 ON m.mine_code = m11_04.mine_code					   
						INNER JOIN
					dir_state s ON m.state_code = s.state_code
						INNER JOIN
					dir_district d ON m.district_code = d.district_code
						AND d.state_code = s.state_code
						LEFT JOIN
					mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode
					WHERE
					 m11_01.return_type = '$returnType'
						 AND (m11_01.return_date BETWEEN '$from_date' AND '$to_date')
						 AND  m11_02.return_type = '$returnType'
						 AND (m11_02.return_date BETWEEN '$from_date' AND '$to_date')
						 AND  m11_03.return_type = '$returnType'
						 AND (m11_03.return_date BETWEEN '$from_date' AND '$to_date')
						 AND  m11_04.return_type = '$returnType'
						 AND (m11_04.return_date BETWEEN '$from_date' AND '$to_date')					   
						group by m.mine_code";*/

                $sql = "SELECT m.MINE_NAME,  m.lessee_owner_name, m.registration_no, ml.mcmdt_ML_Area AS lease_area, s.state_name,
                        d.district_name , EXTRACT(MONTH FROM ps.return_date) AS showMonth, EXTRACT(YEAR FROM ps.return_date) AS showYear,'$from' AS fromDate , '$to' As toDate, ps.stone_sn, ps.pmv_oc,  ps.mine_code, 
						ps.mineral_name, ps.return_date, ps.return_type                   
                        FROM
                        tbl_final_submit tfs
                            INNER JOIN
                        prod_stone ps ON ps.mine_code = tfs.mine_code
                            AND ps.return_type = tfs.return_type
                            AND ps.return_date = tfs.return_date
                            INNER JOIN 
                            mine m on m.mine_code = tfs.mine_code
                                INNER JOIN
                        dir_state s ON m.state_code = s.state_code
                            INNER JOIN
                        dir_district d ON m.district_code = d.district_code
                            AND d.state_code = s.state_code
                            LEFT JOIN
                        mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1
                            WHERE 
                        ps.return_type = '$returnType'  AND (ps.return_date BETWEEN '$from_date' AND '$to_date') AND tfs.is_latest = 1";
            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND ps.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND ps.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
			$sql.=" order by ps.mineral_name,s.state_name,d.district_name,ps.return_date,ps.mine_code,ps.stone_sn ";
			
            //print_r($sql);die;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $lprint=$this->generatem11($records,$showDate,$rowCount);
                $this->set('lprint',$lprint);					
                $this->set('records', $records);
                $this->set('showDate', $showDate);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }
	public function generatem11($records,$showDate,$rowCount) {
        $lcnt=-1;
        $cnt=0;
        $lmineral_name = "";
        $lstate_name = "";
        $ldistrict_name = "";
        $lmonthnm = "";
        $lyearnm = "";
        $lmincode="";
		$lmetal_content="";
		$lserialno="";
        $lflg="";
		$lcounter=0;

		$marray=array();	//metal content
		$rarray=array();	//rough and uncut array
		$carray=array();	//Cut & Polished Stones array
		$iarray=array();	//Industrial array
		$oarray=array();	//Others array
		$lmcnt=-1;
		$locnt=-1;
		$lpcnt=-1;
		$lscnt=-1;
		$lccnt=-1;
		
		if($rowCount <= 15000) {
		$print='<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="tHeadFont" id="heading1">Report M11 - Precious & Semi Precious Stone Ex-Mine Price Details (Form F3)</h4>
                    <div class="form-horizontal">
                        <div class="card-body" id="avb">
							<h6 class="tHeadDate"  id="heading2">Date : '.$showDate.'</h6>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" id="tableReport">
                                    <thead class="tableHead">
                                        <tr>
                                            <th rowspan="3">#</th>
                                            <th rowspan="3">Month</th>  
											<th rowspan="3">Mineral</th>
                                            <th rowspan="3">State</th>
                                            <th rowspan="3">District</th>  
                                            <th rowspan="3">Name of Mine</th>
                                            <th rowspan="3">Name of Lease Owner</th>
                                            <th rowspan="3">Lease Area</th>
											<th rowspan="3">Mine Code</th>
                                            <th rowspan="3">IBM Registration Number</th>
                                            <th colspan="4"> Ex Mine Price</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Gem Variety</th>
                                            <th rowspan="2">Industrial</th>
                                            <th  rowspan="2">Others</th>
                                        </tr>
                                        <tr>
                                             <th>Rough & Uncut Stones</th>
                                            <th >Cut & Polished Stones</th>
                                        </tr>                                        
                                    </thead>
                                    <tbody class="tableBody">';
        foreach ($records as $record) {
            if ($lmineral_name != $record['mineral_name']) {
                $lmineral_name = $record['mineral_name'];
                $lflg="Y";
            }
            if ($lstate_name != $record['state_name']) {
                $lstate_name = $record['state_name'];
                $lflg="Y";
            }
            if ($ldistrict_name != $record['district_name']) {
                $ldistrict_name = $record['district_name'];
                $lflg="Y";
            }
            if ($lmonthnm != $record['showMonth']) {
                $lmonthnm  = $record['showMonth'];
                $lflg="Y";
            }
            if ($lyearnm != $record['showYear']) {
                $lyearnm  = $record['showYear'];
                $lflg="Y";
            }
            if ($lmincode!=$record['mine_code']) {
                $lmincode=$record['mine_code'];
                $lflg="Y";
            }
            //if ($lmetal_content!=$record['metal_content']) {
            //    $lflg="Y";
                
            //} 
            if ($lflg=="Y" || $lcnt <0) {
				if ($lcnt>=0) {
					$larcount=count($rarray);
					if (count($carray)>$larcount) $larcount=count($carray);
					if (count($iarray)>$larcount) $larcount=count($iarray);
					if (count($oarray)>$larcount) $larcount=count($oarray);
					$lrowspan="";
					if ($larcount>1) 
						$lrowspan=" rowspan=".$larcount."";
					
					$lcounter+=1;
					$print.='<tr>
						<td '.$lrowspan.'>'.$lcounter.'</td>
						<td '.$lrowspan.'>'.$monthname.'</td>	
						<td '.$lrowspan.'>'.$mineral_name.'</td>
						<td '.$lrowspan.'>'.$state_name.'</td>
						<td '.$lrowspan.'>'.$district_name.'</td>
						<td '.$lrowspan.'>'.$MINE_NAME.'</td>
						<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
						<td '.$lrowspan.'>'.$lease_area.'</td>
						<td '.$lrowspan.'>'.$mine_code.'</td>
						<td '.$lrowspan.'>'.$registration_no.'</td>';
					for ($cnt=0; $cnt < $larcount; $cnt++) {
						if ($cnt >0) 
							$print.='<tr>';
						//1 start
						$print.="<td>";
						if (isset($rarray[$cnt]['no']))
							$print.=$rarray[$cnt]['no'];
						$print.="</td>";
						//1 end
						//2 start
						$print.="<td>";
						if (isset($carray[$cnt]['no']))
							$print.=$carray[$cnt]['no'];
						$print.="</td>";
						//2 end
						//3 start
						$print.="<td>";
						if (isset($iarray[$cnt]['no']))
							$print.=$iarray[$cnt]['no'];
						$print.="</td>";
						//3 end
						//99 start
						$print.="<td>";
						if (isset($oarray[$cnt]['no']))
							$print.=$oarray[$cnt]['no'];
						$print.="</td>";
						//99 end
					}
					if ($cnt >0) $print.='</tr>';
						
				}
                $lcnt++;
                $lflg="";
                $cnt=0;
				$dbj   = \DateTime::createFromFormat('!m', $record['showMonth']);										  
				//Format it to month name
				$monthName = $dbj->format('F');
				//$monthName = $record['showMonth'];
                $monthname=$monthName.' '.$record['showYear'];	
                $mineral_name=ucwords(str_replace('_', ' ', $record['mineral_name']));
                $state_name=$record['state_name']; 
                $district_name=$record['district_name']; 
                $MINE_NAME=$record['MINE_NAME'] ;
                $lessee_owner_name=$record['lessee_owner_name'];
                $lease_area=$record['lease_area'];
                $mine_code=$record['mine_code'];
                $registration_no=$record['registration_no'];
				//$lmetal_content=$record['metal_content'];
				$marray=array();	//metal content
				$rarray=array();	//rough and uncut array
				$carray=array();	//Cut & Polished Stones array
				$iarray=array();	//Industrial array
				$oarray=array();	//Others array
				$lmcnt=-1;
				$locnt=-1;
				$lpcnt=-1;
				$lscnt=-1;
				$lccnt=-1;
			}

			if ($record['stone_sn']==1) {
				$locnt+=1;
				$rarray[$locnt]['no']=$record['pmv_oc'];
			}
			if ($record['stone_sn']==2) {
				$lpcnt+=1;
				$carray[$lpcnt]['no']=$record['pmv_oc'];
			}
			if ($record['stone_sn']==3) {
				$lscnt+=1;
				$iarray[$lscnt]['no']=$record['pmv_oc'];

			}
			if ($record['stone_sn']==99) {
				$lccnt+=1;
				$oarray[$lccnt]['no']=$record['pmv_oc'];
			}

		}
		if ($lcnt>=0) {
			$larcount=count($rarray);
			if (count($carray)>$larcount) $larcount=count($carray);
			if (count($iarray)>$larcount) $larcount=count($iarray);
			if (count($oarray)>$larcount) $larcount=count($oarray);
			$lrowspan="";
			if ($larcount>1) 
				$lrowspan=" rowspan=".$larcount."";
			
			$lcounter+=1;
			$print.='<tr>
				<td '.$lrowspan.'>'.$lcounter.'</td>
				<td '.$lrowspan.'>'.$monthname.'</td>	
				<td '.$lrowspan.'>'.$mineral_name.'</td>
				<td '.$lrowspan.'>'.$state_name.'</td>
				<td '.$lrowspan.'>'.$district_name.'</td>
				<td '.$lrowspan.'>'.$MINE_NAME.'</td>
				<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
				<td '.$lrowspan.'>'.$lease_area.'</td>
				<td '.$lrowspan.'>'.$mine_code.'</td>
				<td '.$lrowspan.'>'.$registration_no.'</td>';
			for ($cnt=0; $cnt < $larcount; $cnt++) {
				if ($cnt >0) 
					$print.='<tr>';
				//$print.="<td>";
				//if (isset($marray[$cnt]['cont']))
				//	$print.=$marray[$cnt]['cont'];
				//$print.="</td>";						
				//1 start
				$print.="<td>";
				if (isset($rarray[$cnt]['no']))
					$print.=$rarray[$cnt]['no'];
				$print.="</td>";
				//1 end
				//2 start
				$print.="<td>";
				if (isset($carray[$cnt]['no']))
					$print.=$carray[$cnt]['no'];
				$print.="</td>";
				//2 end
				//3 start
				$print.="<td>";
				if (isset($iarray[$cnt]['no']))
					$print.=$iarray[$cnt]['no'];
				$print.="</td>";
				//3 end
				//99 start
				$print.="<td>";
				if (isset($oarray[$cnt]['no']))
					$print.=$oarray[$cnt]['no'];
				$print.="</td>";
				//99 end
			}
			if ($cnt >0) $print.='</tr>';
				
		}
		$print.= '</tbody>
		</table>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>';
		} else {
			$print='<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="tHeadFont" id="heading1">Report M11 - Precious & Semi Precious Stone Ex-Mine Price Details (Form F3)</h4>
                    <div class="form-horizontal">
                        <div class="card-body" id="avb">
							<h6 class="tHeadDate"  id="heading2">Date : '.$showDate.'</h6>

							<h6 class="tHeadDate" id="heading2"><strong>Since records are more hence no search & pagination service is available, you may use the option "Export to Excel"</strong></h6>
							<input type="button" id="downloadExcel" value="Export to Excel">
							<br /><br />

                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" border="1" id="noDatatable">
                                    <thead class="tableHead">
										<tr>
											<th colspan="14" class="noDisplay" align="left">Report M11 - Precious & Semi Precious Stone Ex-Mine Price Details (Form F3)  Date : '.$showDate.'</th>
										</tr>
                                        <tr>
                                            <th rowspan="3">#</th>
                                            <th rowspan="3">Month</th>  
											<th rowspan="3">Mineral</th>
                                            <th rowspan="3">State</th>
                                            <th rowspan="3">District</th>  
                                            <th rowspan="3">Name of Mine</th>
                                            <th rowspan="3">Name of Lease Owner</th>
                                            <th rowspan="3">Lease Area</th>
											<th rowspan="3">Mine Code</th>
                                            <th rowspan="3">IBM Registration Number</th>
                                            <th colspan="4"> Ex Mine Price</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Gem Variety</th>
                                            <th rowspan="2">Industrial</th>
                                            <th  rowspan="2">Others</th>
                                        </tr>
                                        <tr>
                                             <th>Rough & Uncut Stones</th>
                                            <th >Cut & Polished Stones</th>
                                        </tr>                                        
                                    </thead>
                                    <tbody class="tableBody">';
        foreach ($records as $record) {
            if ($lmineral_name != $record['mineral_name']) {
                $lmineral_name = $record['mineral_name'];
                $lflg="Y";
            }
            if ($lstate_name != $record['state_name']) {
                $lstate_name = $record['state_name'];
                $lflg="Y";
            }
            if ($ldistrict_name != $record['district_name']) {
                $ldistrict_name = $record['district_name'];
                $lflg="Y";
            }
            if ($lmonthnm != $record['showMonth']) {
                $lmonthnm  = $record['showMonth'];
                $lflg="Y";
            }
            if ($lyearnm != $record['showYear']) {
                $lyearnm  = $record['showYear'];
                $lflg="Y";
            }
            if ($lmincode!=$record['mine_code']) {
                $lmincode=$record['mine_code'];
                $lflg="Y";
            }
            //if ($lmetal_content!=$record['metal_content']) {
            //    $lflg="Y";
                
            //} 
            if ($lflg=="Y" || $lcnt <0) {
				if ($lcnt>=0) {
					$larcount=count($rarray);
					if (count($carray)>$larcount) $larcount=count($carray);
					if (count($iarray)>$larcount) $larcount=count($iarray);
					if (count($oarray)>$larcount) $larcount=count($oarray);
					$lrowspan="";
					if ($larcount>1) 
						$lrowspan=" rowspan=".$larcount."";
					
					$lcounter+=1;
					$print.='<tr>
						<td '.$lrowspan.'>'.$lcounter.'</td>
						<td '.$lrowspan.'>'.$monthname.'</td>	
						<td '.$lrowspan.'>'.$mineral_name.'</td>
						<td '.$lrowspan.'>'.$state_name.'</td>
						<td '.$lrowspan.'>'.$district_name.'</td>
						<td '.$lrowspan.'>'.$MINE_NAME.'</td>
						<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
						<td '.$lrowspan.'>'.$lease_area.'</td>
						<td '.$lrowspan.'>'.$mine_code.'</td>
						<td '.$lrowspan.'>'.$registration_no.'</td>';
					for ($cnt=0; $cnt < $larcount; $cnt++) {
						if ($cnt >0) 
							$print.='<tr>';
						//1 start
						$print.="<td>";
						if (isset($rarray[$cnt]['no']))
							$print.=$rarray[$cnt]['no'];
						$print.="</td>";
						//1 end
						//2 start
						$print.="<td>";
						if (isset($carray[$cnt]['no']))
							$print.=$carray[$cnt]['no'];
						$print.="</td>";
						//2 end
						//3 start
						$print.="<td>";
						if (isset($iarray[$cnt]['no']))
							$print.=$iarray[$cnt]['no'];
						$print.="</td>";
						//3 end
						//99 start
						$print.="<td>";
						if (isset($oarray[$cnt]['no']))
							$print.=$oarray[$cnt]['no'];
						$print.="</td>";
						//99 end
					}
					if ($cnt >0) $print.='</tr>';
						
				}
                $lcnt++;
                $lflg="";
                $cnt=0;
				$dbj   = \DateTime::createFromFormat('!m', $record['showMonth']);										  
				//Format it to month name
				$monthName = $dbj->format('F');
				//$monthName = $record['showMonth'];
                $monthname=$monthName.' '.$record['showYear'];	
                $mineral_name=ucwords(str_replace('_', ' ', $record['mineral_name']));
                $state_name=$record['state_name']; 
                $district_name=$record['district_name']; 
                $MINE_NAME=$record['MINE_NAME'] ;
                $lessee_owner_name=$record['lessee_owner_name'];
                $lease_area=$record['lease_area'];
                $mine_code=$record['mine_code'];
                $registration_no=$record['registration_no'];
				//$lmetal_content=$record['metal_content'];
				$marray=array();	//metal content
				$rarray=array();	//rough and uncut array
				$carray=array();	//Cut & Polished Stones array
				$iarray=array();	//Industrial array
				$oarray=array();	//Others array
				$lmcnt=-1;
				$locnt=-1;
				$lpcnt=-1;
				$lscnt=-1;
				$lccnt=-1;
			}

			if ($record['stone_sn']==1) {
				$locnt+=1;
				$rarray[$locnt]['no']=$record['pmv_oc'];
			}
			if ($record['stone_sn']==2) {
				$lpcnt+=1;
				$carray[$lpcnt]['no']=$record['pmv_oc'];
			}
			if ($record['stone_sn']==3) {
				$lscnt+=1;
				$iarray[$lscnt]['no']=$record['pmv_oc'];

			}
			if ($record['stone_sn']==99) {
				$lccnt+=1;
				$oarray[$lccnt]['no']=$record['pmv_oc'];
			}

		}
		if ($lcnt>=0) {
			$larcount=count($rarray);
			if (count($carray)>$larcount) $larcount=count($carray);
			if (count($iarray)>$larcount) $larcount=count($iarray);
			if (count($oarray)>$larcount) $larcount=count($oarray);
			$lrowspan="";
			if ($larcount>1) 
				$lrowspan=" rowspan=".$larcount."";
			
			$lcounter+=1;
			$print.='<tr>
				<td '.$lrowspan.'>'.$lcounter.'</td>
				<td '.$lrowspan.'>'.$monthname.'</td>	
				<td '.$lrowspan.'>'.$mineral_name.'</td>
				<td '.$lrowspan.'>'.$state_name.'</td>
				<td '.$lrowspan.'>'.$district_name.'</td>
				<td '.$lrowspan.'>'.$MINE_NAME.'</td>
				<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
				<td '.$lrowspan.'>'.$lease_area.'</td>
				<td '.$lrowspan.'>'.$mine_code.'</td>
				<td '.$lrowspan.'>'.$registration_no.'</td>';
			for ($cnt=0; $cnt < $larcount; $cnt++) {
				if ($cnt >0) 
					$print.='<tr>';
				//$print.="<td>";
				//if (isset($marray[$cnt]['cont']))
				//	$print.=$marray[$cnt]['cont'];
				//$print.="</td>";						
				//1 start
				$print.="<td>";
				if (isset($rarray[$cnt]['no']))
					$print.=$rarray[$cnt]['no'];
				$print.="</td>";
				//1 end
				//2 start
				$print.="<td>";
				if (isset($carray[$cnt]['no']))
					$print.=$carray[$cnt]['no'];
				$print.="</td>";
				//2 end
				//3 start
				$print.="<td>";
				if (isset($iarray[$cnt]['no']))
					$print.=$iarray[$cnt]['no'];
				$print.="</td>";
				//3 end
				//99 start
				$print.="<td>";
				if (isset($oarray[$cnt]['no']))
					$print.=$oarray[$cnt]['no'];
				$print.="</td>";
				//99 end
			}
			if ($cnt >0) $print.='</tr>';
				
		}
		$print.= '</tbody>
		</table>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>';
		}
	
		return $print;
	}

    public function reportA01()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $next_year = $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower(str_replace(' ', '_', $mineral));
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');
			
			$subtype = $this->request->getData('subtype');

            $con = ConnectionManager::get('default');
			
			// Creating Views for A01 view_report_grade_rom_A01, view_report_grade_rom_A01a
			
			 if ($subtype == '2') {

                $selectColumn = " SELECT 
									m.MINE_NAME,
									m.lessee_owner_name,
									m.registration_no,
									s.state_name,
									d.district_name,
									'$from_year' AS year1, '$next_year' AS year2,
									'$showDate' AS showDate,
									ml.mcmdt_ML_Area AS lease_area,
									a1.*,
									m.nature_use,
									'' as sale_value,
									'' as quantity,
									'' as client_type,
									'' as grade_name,
									m.type_working, m.mechanisation, m.mine_ownership,
									CASE
										WHEN `m`.`mine_category` = 1 THEN 'A'
										WHEN `m`.`mine_category` = 2 THEN 'B'
										ELSE `m`.`mine_category`
									END AS `mine_category` ";

                $joins = " FROM
									view_report_grade_rom_A01a a1        
										INNER JOIN
									mine m ON m.mine_code = a1.mine_code
										INNER JOIN
									dir_state s ON m.state_code = s.state_code
										INNER JOIN
									dir_district d ON m.district_code = d.district_code
										AND s.state_code = d.state_code       
										LEFT JOIN
									mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1 ";

                $conditions = " WHERE a1.return_type = '$returnType' AND a1.return_date = '$from_date' 
									AND (a1.mineral_name != 'iron_ore' and a1.mineral_name != 'chromite')";
            } else {

                $selectColumn = "SELECT 
											m.MINE_NAME,
											m.lessee_owner_name,
											m.registration_no,
											s.state_name,
											d.district_name,
											dmg.grade_name,
											'$from_year' AS year1, '$next_year' AS year2,
											'$showDate' AS showDate,
											ml.mcmdt_ML_Area AS lease_area,
											a1.*,
											m.nature_use,
											(CASE
												WHEN (`gs`.`grade_code` = `a1`.`grade_code`) THEN `gs`.`client_type`
											END) AS `client_type`,
											(CASE
												WHEN
													(((`gs`.`client_type` = 'DOMESTIC SALE')
														OR (`gs`.`client_type` = 'DOMESTIC TRANSFER')
														OR (`gs`.`client_type` = 'CAPTIVE CONSUMPTION'))
														AND (`gs`.`grade_code` = `a1`.`grade_code`))
												THEN
													`gs`.`sale_value`
												WHEN
													((`gs`.`client_type` = 'EXPORT')
														AND (`gs`.`grade_code` = `a1`.`grade_code`))
												THEN
													`gs`.`expo_fob`
											END) AS `sale_value`,
											(CASE
												WHEN
													(((`gs`.`client_type` = 'DOMESTIC SALE')
														OR (`gs`.`client_type` = 'DOMESTIC TRANSFER')
														OR (`gs`.`client_type` = 'CAPTIVE CONSUMPTION'))
														AND (`gs`.`grade_code` = `a1`.`grade_code`))
												THEN
													`gs`.`quantity`
												WHEN
													((`gs`.`client_type` = 'EXPORT')
														AND (`gs`.`grade_code` = `a1`.`grade_code`))
												THEN
													`gs`.`expo_quantity`
											END) AS `quantity`,
											m.type_working, m.mechanisation, m.mine_ownership,
											CASE
												WHEN `m`.`mine_category` = 1 THEN 'A'
												WHEN `m`.`mine_category` = 2 THEN 'B'
												ELSE `m`.`mine_category`
											END AS `mine_category` ";


				
                $joins = " FROM
                            view_report_grade_rom_A01 a1						
                                LEFT JOIN
                            grade_sale gs ON a1.mine_code = gs.mine_code
                                AND a1.mine_code = gs.mine_code
                                AND gs.return_date = '$from_date'
                                AND gs.return_type = '$returnType'
                                AND a1.iron_type = gs.min_iron_type										
                                AND a1.return_date = gs.return_date
                                AND a1.return_type = gs.return_type
                                AND a1.grade_code = gs.grade_code
                                INNER JOIN
                            mine m ON m.mine_code = a1.mine_code
                                INNER JOIN
                            dir_state s ON m.state_code = s.state_code
                                INNER JOIN
                            dir_district d ON m.district_code = d.district_code
                                AND s.state_code = d.state_code
                                LEFT JOIN
                            dir_mineral_grade dmg ON a1.grade_code = dmg.grade_code
                                AND a1.mineral_name = REPLACE(LOWER(dmg.mineral_name),
                                ' ',
                                '_')       
                                LEFT JOIN
                            mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1 ";

                $conditions = " WHERE a1.return_type = '$returnType' AND a1.return_date = '$from_date'
								AND (a1.mineral_name = 'iron_ore' OR a1.mineral_name = 'chromite')";
            }


            $sql = "$selectColumn $joins $conditions ";
			
			//print_r($sql);die;
			 if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND a1.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND a1.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area  = '$lesseearea'";
            }
            $sql .= "order by a1.mineral_name,s.state_name,d.district_name,a1.return_date,grade_code";
			
			//print_r($sql);die;
						
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this ->set('records', $records);
				$this->set('subtype',$subtype);
                $this -> set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA02()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower(str_replace(' ', '_', $mineral));
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');          
			
			// Created views view_report_grade_rom_A02_saleprod_union_iv, view_report_grade_rom_a02_saleprod_union_chromite, 
			//view_report_grade_rom_a02_saleprod_union_iron_chromite
			if($mineral == 'iron_ore'){
					$sql = "SELECT m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, dmg.grade_name,
							'$from_year' AS year1, '$next_year' AS year2, '$showDate' AS showDate,
							ml.mcmdt_ML_Area AS lease_area,
							a2.*,m.nature_use,
							m.type_working, m.mechanisation, m.mine_ownership,
							CASE
								WHEN `m`.`mine_category` = 1 THEN 'A'
								WHEN `m`.`mine_category` = 2 THEN 'B'
								ELSE `m`.`mine_category`
							END AS `mine_category`
						FROM
							view_report_grade_rom_A02_saleprod_union_iv A2												
								INNER JOIN
							mine m ON m.mine_code = a2.mine_code
								INNER JOIN
							dir_state s ON m.state_code = s.state_code
								INNER JOIN
							dir_district d ON m.district_code = d.district_code
								AND s.state_code = d.state_code
								INNER JOIN
							dir_mineral_grade dmg ON a2.grade_code = dmg.grade_code
							  
							  LEFT JOIN
							mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1 

							WHERE
							a2.return_type = '$returnType' AND a2.return_date = '$from_date'";
					}
					if($mineral == 'chromite'){
						$sql = "SELECT m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, dmg.grade_name,'$from' AS fromDate , '$to' As toDate,
							'$from_year' AS year1, '$next_year' AS year2, '$showDate' AS showDate,
							ml.mcmdt_ML_Area AS lease_area,
							a2.*,m.nature_use,
							m.type_working, m.mechanisation, m.mine_ownership,
							CASE
								WHEN `m`.`mine_category` = 1 THEN 'A'
								WHEN `m`.`mine_category` = 2 THEN 'B'
								ELSE `m`.`mine_category`
							END AS `mine_category`
						FROM
							view_report_grade_rom_a02_saleprod_union_chromite a2												
								INNER JOIN
							mine m ON m.mine_code = a2.mine_code
								INNER JOIN
							dir_state s ON m.state_code = s.state_code
								INNER JOIN
							dir_district d ON m.district_code = d.district_code
								AND s.state_code = d.state_code
								INNER JOIN
							dir_mineral_grade dmg ON a2.grade_code = dmg.grade_code
							  
							  LEFT JOIN
							mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1 

							WHERE
							a2.return_type = '$returnType' AND a2.return_date = '$from_date'";
					}
					if($mineral == ''){
						$sql = "SELECT m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, dmg.grade_name,'$from' AS fromDate , '$to' As toDate,
							'$from_year' AS year1, '$next_year' AS year2, '$showDate' AS showDate,
							ml.mcmdt_ML_Area AS lease_area,
							a2.*,m.nature_use,
							m.type_working, m.mechanisation, m.mine_ownership,
							CASE
								WHEN `m`.`mine_category` = 1 THEN 'A'
								WHEN `m`.`mine_category` = 2 THEN 'B'
								ELSE `m`.`mine_category`
							END AS `mine_category`
						FROM
							view_report_grade_rom_a02_saleprod_union_iron_chromite a2												
								INNER JOIN
							mine m ON m.mine_code = a2.mine_code
								INNER JOIN
							dir_state s ON m.state_code = s.state_code
								INNER JOIN
							dir_district d ON m.district_code = d.district_code
								AND s.state_code = d.state_code
								INNER JOIN
							dir_mineral_grade dmg ON a2.grade_code = dmg.grade_code
							  
							  LEFT JOIN
							mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1 

							WHERE
							a2.return_type = '$returnType' AND a2.return_date = '$from_date' 																			
							";
					}
							
					if ($state != '') {
						$sql .= " AND m.state_code = '$state'";
					}
					if ($district != '') {
						$sql .= " AND m.district_code = '$district'";
					}
					if ($mineral != '') {
						$sql .= " AND a2.mineral_name = '$mineral'";
					}
					if ($minecode != '') {
						$sql .= " AND a2.mine_code IN('$minecode')";
					}
					if ($ibm != '') {
						$sql .= " AND m.registration_no  = '$ibm'";
					}
					if ($minename != '') {
						$sql .= " AND m.MINE_NAME = '$minename'";
					}
					if ($owner != '') {
						$sql .= "  AND m.lessee_owner_name = '$owner'";
					}
					if ($lesseearea != '') {
						$sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
					}
				$sql .= " ORDER BY a2.grade_code";
			//print_r($sql);die;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }
	
	public function reportA02b()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
			$returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower(str_replace(' ', '_', $mineral));
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');
			$con = ConnectionManager::get('default');

			// Created  view view_report_grade_rom_a02b_saleprod_union_iv, 
			$sql = "SELECT m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, dmg.grade_name,
					'$from_year' AS year1, '$next_year' AS year2, '$showDate' AS showDate,
					ml.mcmdt_ML_Area AS lease_area,
					a2.*,m.nature_use,
					m.type_working, m.mechanisation, m.mine_ownership,
					CASE
						WHEN `m`.`mine_category` = 1 THEN 'A'
						WHEN `m`.`mine_category` = 2 THEN 'B'
						ELSE `m`.`mine_category`
					END AS `mine_category`
				FROM
					view_report_grade_rom_a02b_saleprod_union_iv a2												
						INNER JOIN
					mine m ON m.mine_code = a2.mine_code
						INNER JOIN
					dir_state s ON m.state_code = s.state_code
						INNER JOIN
					dir_district d ON m.district_code = d.district_code
						AND s.state_code = d.state_code
						INNER JOIN
					dir_mineral_grade dmg ON a2.grade_code = dmg.grade_code					  
					  LEFT JOIN
					mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1 

					WHERE
					a2.return_type = '$returnType' AND a2.return_date = '$from_date' ";
					
					 if ($state != '') {
						$sql .= " AND m.state_code = '$state'";
					}
					if ($district != '') {
						$sql .= " AND m.district_code = '$district'";
					}
					if ($mineral != '') {
						$sql .= " AND a2.mineral_name = '$mineral'";
					}
					if ($minecode != '') {
						$sql .= " AND a2.mine_code IN('$minecode')";
					}
					if ($ibm != '') {
						$sql .= " AND m.registration_no  = '$ibm'";
					}
					if ($minename != '') {
						$sql .= " AND m.MINE_NAME = '$minename'";
					}
					if ($owner != '') {
						$sql .= "  AND m.lessee_owner_name = '$owner'";
					}
					if ($lesseearea != '') {
						$sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
					}
			$sql .= " ORDER BY a2.client_type,a2.grade_code";
			//print_r($sql);exit;
			$query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
			$records = $query->fetchAll('assoc');																
			}
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
    }
	
	
	public function reportA02c()
    {
          $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
           $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower(str_replace(' ', '_', $mineral));
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');
            $con = ConnectionManager::get('default');

			// Created view view_report_grade_rom_a02c_saleprod_union_iv
            $sql = "SELECT DISTINCT m.MINE_NAME, m.lessee_owner_name, m.registration_no, ml.mcmdt_ML_Area AS lease_area, s.state_name, d.district_name, 
						 dst.stone_def as grade_name,'$from_year' AS year1, '$next_year' AS year2, '$showDate' AS showDate,
						a2.*,m.nature_use,dmm.input_unit,
						m.type_working, m.mechanisation, m.mine_ownership,
						CASE
							WHEN `m`.`mine_category` = 1 THEN 'A'
							WHEN `m`.`mine_category` = 2 THEN 'B'
							ELSE `m`.`mine_category`
						END AS `mine_category`
						FROM
						tbl_final_submit tfs
						inner join view_report_grade_rom_a02c_saleprod_union_iv a2 on tfs.mine_code = a2.mine_code							
							INNER JOIN
						dir_stone_type dst ON a2.grade_code = dst.stone_sn
						 INNER JOIN 
						 mine m on m.mine_code = tfs.mine_code
							 INNER JOIN
						dir_state s ON m.state_code = s.state_code
							INNER JOIN
						dir_district d ON m.district_code = d.district_code
							AND d.state_code = s.state_code
							INNER JOIN
						dir_mcp_mineral dmm on a2.mineral_name = dmm.mineral_name
							LEFT JOIN
						mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1
						
						WHERE a2.return_type = '$returnType' AND a2.return_date = '$from_date' AND tfs.is_latest = 1";
					
					 if ($state != '') {
						$sql .= " AND m.state_code = '$state'";
					}
					if ($district != '') {
						$sql .= " AND m.district_code = '$district'";
					}
					if ($mineral != '') {
						$sql .= " AND a2.mineral_name = '$mineral'";
					}
					if ($minecode != '') {
						$sql .= " AND a2.mine_code IN('$minecode')";
					}
					if ($ibm != '') {
						$sql .= " AND m.registration_no  = '$ibm'";
					}
					if ($minename != '') {
						$sql .= " AND m.MINE_NAME = '$minename'";
					}
					if ($owner != '') {
						$sql .= "  AND m.lessee_owner_name = '$owner'";
					}
					if ($lesseearea != '') {
						$sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
					}
				$sql .= " ORDER BY a2.return_date,a2.mine_code,a2.client_type,a2.grade_code";
			
            //print_r($sql);exit;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');						
			}
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
    }


   /* public function reportA03()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower(str_replace(' ', '_', $mineral));
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            $sql = "SELECT DISTINCT p.open_oc_rom, p.open_ug_rom, p.open_dw_rom, p.clos_oc_rom, p.clos_ug_rom, p.clos_dw_rom, p.mine_code,
            p.mineral_name, m.MINE_NAME, m.lessee_owner_name, m.registration_no, dmg.grade_name, s.state_name, d.district_name,
            '$from_year' AS year1, $next_year AS year2, (ml.under_forest_area + ml.outside_forest_area) AS lease_area, '$showDate' AS showDate
            FROM
                mine m
                    INNER JOIN
                dir_state s ON m.state_code = s.state_code
                    INNER JOIN
                dir_district d ON m.district_code = d.district_code
                    AND s.state_code = d.state_code
                    INNER JOIN
                grade_prod gp ON m.mine_code = gp.mine_code
                    AND gp.return_type = '$returnType'
                    AND gp.return_date = '$from_date'
                    INNER JOIN
                prod_1 p ON gp.mine_code = p.mine_code
                    AND m.mine_code = p.mine_code
                    AND p.return_type = '$returnType'
                    AND p.return_date = '$from_date'
                    AND gp.mineral_name = p.mineral_name
                    AND gp.return_date = p.return_date
                    AND gp.return_type = p.return_type
                    INNER JOIN
                dir_mineral_grade dmg ON gp.grade_code = dmg.grade_code
                    AND gp.mineral_name = REPLACE(LOWER(dmg.mineral_name), ' ', '_')
                    AND p.mineral_name = REPLACE(LOWER(dmg.mineral_name), ' ', '_')
                    LEFT JOIN
                mcp_lease ml ON m.mine_code = ml.mine_code
                    AND gp.mine_code = ml.mine_code
                    AND p.mine_code = ml.mine_code
                WHERE
                p.return_type = '$returnType' AND p.return_date = '$from_date' AND gp.return_type = '$returnType' AND gp.return_date = '$from_date'";

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND p.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND p.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND (ml.under_forest_area + ml.outside_forest_area) = '$lesseearea'";
            }
            // pr($sql);exit;
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }*/
	
	
	public function createfileA03($lhtml,$lfilenm) {
		$lext=".xlsx";
		$lwriter="Xlsx";
		
		$filename = "reports/".$lfilenm.$lext;	//'.xlsx';
						
		if (file_exists($filename)) {
			unlink($filename);
		}
		$tempfile='../tmp/tmp_repa03'.strftime("%d-%m-%Y").'.html';
		if (file_exists($tempfile)) {
			unlink($tempfile);
		}

		file_put_contents($tempfile,$lhtml);
		$reader=IOFactory::createReader('Html');
		$spreadsheet=$reader->load($tempfile);
		$writer=IOFactory::createWriter($spreadsheet,$lwriter);
		$writer->save($filename);
		unlink($tempfile);
		return $lfilenm.$lext;
	}
	
    public function reportA03()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower(str_replace(' ', '_', $mineral));
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');
	
			/**
            * Created view view_report_open_prod_clos_a03
			*/
             
			$sql = "SELECT DISTINCT m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name,'$showDate' AS showDate,
			ml.mcmdt_ML_Area AS lease_area, '$from_year' AS year1, '$next_year' AS year2, a03.*
			FROM
			view_report_open_prod_clos_a03 a03
				INNER JOIN
			mine m ON m.mine_code = a03.mine_code
				INNER JOIN
			dir_state s ON m.state_code = s.state_code
				INNER JOIN
			dir_district d ON m.district_code = d.district_code
				AND s.state_code = d.state_code
														   
				LEFT JOIN
			mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1
			WHERE
			a03.return_type = '$returnType'
				AND a03.return_date = '$from_date' ";
				

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND a03.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND a03.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
            $sql .= "order by a03.mineral_name,s.state_name,d.district_name,a03.return_date,a03.mine_code,a03.serial_sn";
           // print_r($sql);exit;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                $lprint=$this->generatea03($records,$showDate,$rowCount);
				$lfilenm="reporta03_".strftime("%d-%m-%Y"); //.$_SESSION['mms_user_email'];
				$lfile=$this->createfileA03($lprint,$lfilenm);
                $this->set('lprint',$lprint);
				$this->set('lfilenm',$lfile);
                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }
 	public function generatea03($records,$showDate,$rowCount) {
        $datarry=array();
        $lcnt=-1;
        $cnt=0;
        $lmineral_name = "";
        $lstate_name = "";
        $ldistrict_name = "";
        $lmonthnm = "";
        $lyearnm = "";
        $lmincode="";
		$lserialno="";
        $lflg="";
		$lcounter=0;
        $print="";
		$ugopary=array();		//under ground open stock
		$ocopary=array();		//open cast open stock
		$dwopary=array();		//dump working open stock
		$ugpdary=array();		//under ground production
		$ocpdary=array();		//open cast production
		$dwpdary=array();		//dump working production
		$ugclary=array();		//under ground closing stock
		$occlary=array();		//open cast closing stock
		$dwclary=array();		//dump working closing stock

        $lugopcnt=-1;			//under ground open stock   
        $locopcnt=-1;			//open cast open stock      
        $ldwopcnt=-1;			//dump working open stock   
		$lugpdcnt=-1;			//under ground production   
		$locpdcnt=-1;			//open cast production      
		$ldwpdcnt=-1;			//dump working production   
		$lugclcnt=-1;			//under ground closing stock
		$locclcnt=-1;			//open cast closing stock   
		$ldwclcnt=-1;			//dump working closing stock
        
		if($rowCount <= 15000) {
		$print='<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="tHeadFont" id="heading1">Report A03 - ROM Opening Stock, ROM Production & ROM Closing Stock</h4>
                    <div class="form-horizontal">
                        <div class="card-body" id="avb">
						    <h6 class="tHeadDate" id="heading2">Year : '.$showDate.'</h6>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" id="tableReportm03">
                                    <thead class="tableHead">
                                        <tr>
                                            <th rowspan="2">#</th>
                                            <th rowspan="2">Year</th>
											<th rowspan="2">Mineral</th>
											<th rowspan="2">State</th>
											<th rowspan="2">District</th>                                            
                                            <th rowspan="2">Name of Mine</th>
                                            <th rowspan="2">Name of Lease Owner</th>
                                            <th rowspan="2">Lease Area</th>
											<th rowspan="2">Mine Code</th>
                                            <th rowspan="2">IBM Registration Number</th>
                                            <th colspan="9">Opening Stock</th>
											<th colspan="9">Production</th>
                                            <th colspan="9">Closing Stock</th>
                                        </tr>
                                        <tr>
											<!-- Opening Stock -->
                                            <th>Open Cast (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											
                                            <th>Underground (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											
                                            <th>Dump Working (tonnes)</th>
                                            <th>Metal Content</th>
											<th>Grade</th>
											<!-- End-->
											
											<!-- Production -->
                                            <th>Open Cast (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											
                                            <th>Underground (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											
                                            <th>Dump Working (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											<!-- End-->
											
											<!-- Closing Stock -->
											<th>Open Cast (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											
                                            <th>Underground (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											
                                            <th>Dump Working (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											<!-- End-->
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody">';
        foreach ($records as $record) {
            
            if ($lmineral_name != $record['mineral_name']) {
                $lmineral_name = $record['mineral_name'];
                $lflg="Y";
            }
            if ($lstate_name != $record['state_name']) {
                $lstate_name = $record['state_name'];
                $lflg="Y";
            }
            if ($ldistrict_name != $record['district_name']) {
                $ldistrict_name = $record['district_name'];
                $lflg="Y";
            }
            if ($lmonthnm != $record['showMonth']) {
                $lmonthnm  = $record['showMonth'];
                $lflg="Y";
            }
            if ($lyearnm != $record['showYear']) {
                $lyearnm  = $record['showYear'];
                $lflg="Y";
            }
            if ($lmincode!=$record['mine_code']) {
                $lmincode=$record['mine_code'];
                $lflg="Y";
            }
            if ((int)$record['serial_sn']<=0) {
                $lflg="Y";
				if ((int)$record['serial_sn']<=0)
					$lrowspan="";
                
            } 
			if ($lserialno!=(int)$record['serial_sn']) {
				if ($record['serial_sn']>=4 && $record['serial_sn']<=6) {
					if ($lserialno<=3 || $lserialno>=7) {
						$lflg="Y";
					}
				}
				$lserialno=$record['serial_sn'];
			}

            if ($lflg=="Y" || $lcnt <0) {
//
				if ($lcnt >=0) {
					$larcount=count($ugopary);
					if(count($ocopary) > $larcount) $larcount=count($ocopary);
					if(count($dwopary) > $larcount) $larcount=count($dwopary);
					if(count($ugpdary) > $larcount) $larcount=count($ugpdary);
					if(count($ocpdary) > $larcount) $larcount=count($ocpdary);
					if(count($dwpdary) > $larcount) $larcount=count($dwpdary);
					if(count($ugclary) > $larcount) $larcount=count($ugclary);
					if(count($occlary) > $larcount) $larcount=count($occlary);
					if(count($dwclary) > $larcount) $larcount=count($dwclary);
					$lrowspan="";
					if ($larcount>1) 
						$lrowspan=" rowspan=".$larcount."";
					$lcounter+=1;
					$print.='<tr>
						<td '.$lrowspan.'>'.$lcounter.'</td>
						<td '.$lrowspan.'>'.$record['year1'].'</td>	
						<td '.$lrowspan.'>'.$mineral_name.'</td>
						<td '.$lrowspan.'>'.$state_name.'</td>
						<td '.$lrowspan.'>'.$district_name.'</td>												
						<td '.$lrowspan.'>'.$MINE_NAME.'</td>
						<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
						<td '.$lrowspan.'>'.$lease_area.'</td>
						<td '.$lrowspan.'>'.$mine_code.'</td>
						<td '.$lrowspan.'>'.$registration_no.'</td>';
					for ($cnt=0;$cnt < $larcount; $cnt++) {
						if ($cnt > 0) $print.='</tr><tr>';
						//7 starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($ocopary[$cnt]['open_oc_rom']))
								$print.=$ocopary[$cnt]['open_oc_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($ocopary[$cnt]['open_oc_metal_content']))
							$print.=$ocopary[$cnt]['open_oc_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($ocopary[$cnt]['open_oc_grade']))
							$print.=$ocopary[$cnt]['open_oc_grade'];
						$print.="</td>";
						//7 ends
						//1 and 4 starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($ugopary[$cnt]['open_ug_rom']))
								$print.=$ugopary[$cnt]['open_ug_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($ugopary[$cnt]['open_ug_metal_content']))
							$print.=$ugopary[$cnt]['open_ug_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($ugopary[$cnt]['open_ug_grade']))
							$print.=$ugopary[$cnt]['open_ug_grade'];
						$print.="</td>";
						//1 and 4 ends
						//0 dw starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($dwopary[$cnt]['open_dw_rom']))
								$print.=$dwopary[$cnt]['open_dw_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($dwopary[$cnt]['open_dw_metal_content']))
							$print.=$dwopary[$cnt]['open_dw_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($dwopary[$cnt]['open_dw_grade']))
							$print.=$dwopary[$cnt]['open_dw_grade'];
						$print.="</td>";
						//0 dw ends
						//8 oc production starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($ocpdary[$cnt]['prod_oc_rom']))
								$print.=$ocpdary[$cnt]['prod_oc_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($ocpdary[$cnt]['prod_oc_metal_content']))
							$print.=$ocpdary[$cnt]['prod_oc_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($ocpdary[$cnt]['prod_oc_grade']))
							$print.=$ocpdary[$cnt]['prod_oc_grade'];
						$print.="</td>";
						//8 oc production ends
						//2 or 5 ug production starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($ugpdary[$cnt]['prod_ug_rom']))
								$print.=$ugpdary[$cnt]['prod_ug_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($ugpdary[$cnt]['prod_ug_metal_content']))
							$print.=$ugpdary[$cnt]['prod_ug_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($ugpdary[$cnt]['prod_ug_grade']))
							$print.=$ugpdary[$cnt]['prod_ug_grade'];
						$print.="</td>";
						//2 or 5 ug production ends
						// dw production starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($dwpdary[$cnt]['prod_dw_rom']))
								$print.=$dwpdary[$cnt]['prod_dw_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($dwpdary[$cnt]['prod_dw_metal_content']))
							$print.=$dwpdary[$cnt]['prod_dw_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($dwpdary[$cnt]['prod_dw_grade']))
							$print.=$dwpdary[$cnt]['prod_dw_grade'];
						$print.="</td>";
						// dw production ends
						//9 oc clossing starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($occlary[$cnt]['clos_oc_rom']))
								$print.=$occlary[$cnt]['clos_oc_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($occlary[$cnt]['clos_oc_metal_content']))
							$print.=$occlary[$cnt]['clos_oc_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($occlary[$cnt]['clos_oc_grade']))
							$print.=$occlary[$cnt]['clos_oc_grade'];
						$print.="</td>";
						//9 oc clossing ends
						//3 or 6 ug clossing starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($ugclary[$cnt]['clos_ug_rom']))
								$print.=$ugclary[$cnt]['clos_ug_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($ugclary[$cnt]['clos_ug_metal_content']))
							$print.=$ugclary[$cnt]['clos_ug_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($ugclary[$cnt]['clos_ug_grade']))
							$print.=$ugclary[$cnt]['clos_ug_grade'];
						$print.="</td>";
						//3 or 6 ug clossing ends
						// dw clossing starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($dwclary[$cnt]['clos_dw_rom']))
								$print.=$dwclary[$cnt]['clos_dw_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($dwclary[$cnt]['clos_dw_metal_content']))
							$print.=$dwclary[$cnt]['clos_dw_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($dwclary[$cnt]['clos_dw_grade']))
							$print.=$dwclary[$cnt]['clos_dw_grade'];
						$print.="</td>";
						// dw clossing ends
					}
					if ($cnt >0) $print.='</tr>';

				}

//
                $lcnt++;
                $lflg="";
                $cnt=0;
					
                $mineral_name=ucwords(str_replace('_', ' ', $record['mineral_name']));
                $state_name=$record['state_name']; 
                $district_name=$record['district_name']; 
                $MINE_NAME=$record['MINE_NAME'] ;
                $lessee_owner_name=$record['lessee_owner_name'];
                $lease_area=$record['lease_area'];
                $mine_code=$record['mine_code'];
                $registration_no=$record['registration_no'];

				$ugopary=array();		//under ground open stock
				$ocopary=array();		//open cast open stock
				$dwopary=array();		//dump working open stock
				$ugpdary=array();		//under ground production
				$ocpdary=array();		//open cast production
				$dwpdary=array();		//dump working production
				$ugclary=array();		//under ground closing stock
				$occlary=array();		//open cast closing stock
				$dwclary=array();		//dump working closing stock

				$lugopcnt=-1;			//under ground open stock   
				$locopcnt=-1;			//open cast open stock      
				$ldwopcnt=-1;			//dump working open stock   
				$lugpdcnt=-1;			//under ground production   
				$locpdcnt=-1;			//open cast production      
				$ldwpdcnt=-1;			//dump working production   
				$lugclcnt=-1;			//under ground closing stock
				$locclcnt=-1;			//open cast closing stock   
				$ldwclcnt=-1;			//dump working closing stock

            }
            if ((int)$record['serial_sn']<=0) {
				$lugopcnt=0;			//under ground open stock   
				$locopcnt=0;			//open cast open stock      
				$ldwopcnt=0;			//dump working open stock   
				$lugpdcnt=0;			//under ground production   
				$locpdcnt=0;			//open cast production      
				$ldwpdcnt=0;			//dump working production   
				$lugclcnt=0;			//under ground closing stock
				$locclcnt=0;			//open cast closing stock   
				$ldwclcnt=0;			//dump working closing stock
				$ugopary[$lugopcnt]['open_ug_rom']=$record['open_ug_rom'];
				$ugopary[$lugopcnt]['open_ug_metal_content']=$record['open_ug_metal_content'];
				$ugopary[$lugopcnt]['open_ug_grade']=$record['open_ug_grade'];
				$ocopary[$locopcnt]['open_oc_rom']=$record['open_oc_rom'];
				$ocopary[$locopcnt]['open_oc_metal_content']=$record['open_oc_metal_content'];
				$ocopary[$locopcnt]['open_oc_grade']=$record['open_oc_grade'];
				$dwopary[$ldwopcnt]['open_dw_rom']=$record['open_dw_rom'];
				$dwopary[$ldwopcnt]['open_dw_metal_content']="";
				$dwopary[$ldwopcnt]['open_dw_grade']="";
				$ugpdary[$lugpdcnt]['prod_ug_rom']=$record['prod_ug_rom'];
				$ugpdary[$lugpdcnt]['prod_ug_metal_content']=$record['prod_ug_metal_content'];
				$ugpdary[$lugpdcnt]['prod_ug_grade']=$record['prod_ug_grade'];
				$ocpdary[$locpdcnt]['prod_oc_rom']=$record['prod_oc_rom'];
				$ocpdary[$locpdcnt]['prod_oc_metal_content']=$record['prod_oc_metal_content'];
				$ocpdary[$locpdcnt]['prod_oc_grade']=$record['prod_oc_grade'];
				$dwpdary[$ldwpdcnt]['prod_dw_rom']=$record['prod_dw_rom'];
				$dwpdary[$ldwpdcnt]['prod_dw_metal_content']="";
				$dwpdary[$ldwpdcnt]['prod_dw_grade']="";
				$ugclary[$lugclcnt]['clos_ug_rom']=$record['clos_ug_rom'];
				$ugclary[$lugclcnt]['clos_ug_metal_content']=$record['clos_ug_metal_content'];
				$ugclary[$lugclcnt]['clos_ug_grade']=$record['clos_ug_grade'];
				$occlary[$locclcnt]['clos_oc_rom']=$record['clos_oc_rom'];	
				$occlary[$locclcnt]['clos_oc_metal_content']=$record['clos_oc_metal_content'];	
				$occlary[$locclcnt]['clos_oc_grade']=$record['clos_oc_grade'];	
				$dwclary[$ldwclcnt]['clos_dw_rom']=$record['clos_dw_rom'];
				$dwclary[$ldwclcnt]['clos_dw_metal_content']="";
				$dwclary[$ldwclcnt]['clos_dw_grade']="";				
            } 
            if ((int)$record['serial_sn']==1 || (int)$record['serial_sn']==4) { 
				$lugopcnt+=1;
				$ugopary[$lugopcnt]['open_ug_rom']=$record['open_ug_rom'];
				$ugopary[$lugopcnt]['open_ug_metal_content']=$record['open_ug_metal_content'];
				$ugopary[$lugopcnt]['open_ug_grade']=$record['open_ug_grade'];

            }
            if ((int)$record['serial_sn']==2 || (int)$record['serial_sn']==5) {
				$lugpdcnt+=1;
				$ugpdary[$lugpdcnt]['prod_ug_rom']=$record['prod_ug_rom'];
				$ugpdary[$lugpdcnt]['prod_ug_metal_content']=$record['prod_ug_metal_content'];
				$ugpdary[$lugpdcnt]['prod_ug_grade']=$record['prod_ug_grade'];

            }
            if ((int)$record['serial_sn']==3 || (int)$record['serial_sn']==6) {
				$lugclcnt+=1;
				$ugclary[$lugclcnt]['clos_ug_rom']=$record['clos_ug_rom'];
				$ugclary[$lugclcnt]['clos_ug_metal_content']=$record['clos_ug_metal_content'];
				$ugclary[$lugclcnt]['clos_ug_grade']=$record['clos_ug_grade'];

            }

            if ((int)$record['serial_sn']==7) {   
				$locopcnt+=1;
				$ocopary[$locopcnt]['open_oc_rom']=$record['open_oc_rom'];
				$ocopary[$locopcnt]['open_oc_metal_content']=$record['open_oc_metal_content'];
				$ocopary[$locopcnt]['open_oc_grade']=$record['open_oc_grade'];
            }
            if ((int)$record['serial_sn']==8) { 
				$locpdcnt+=1;
				$ocpdary[$locpdcnt]['prod_oc_rom']=$record['prod_oc_rom'];
				$ocpdary[$locpdcnt]['prod_oc_metal_content']=$record['prod_oc_metal_content'];
				$ocpdary[$locpdcnt]['prod_oc_grade']=$record['prod_oc_grade'];


            }  
            if ((int)$record['serial_sn']==9) {  
				$locclcnt+=1;
				$occlary[$locclcnt]['clos_oc_rom']=$record['clos_oc_rom'];	
				$occlary[$locclcnt]['clos_oc_metal_content']=$record['clos_oc_metal_content'];	
				$occlary[$locclcnt]['clos_oc_grade']=$record['clos_oc_grade'];
            }            
			
        }
		if ($lcnt >=0) {
			$larcount=count($ugopary);
			if(count($ocopary) > $larcount) $larcount=count($ocopary);
			if(count($dwopary) > $larcount) $larcount=count($dwopary);
			if(count($ugpdary) > $larcount) $larcount=count($ugpdary);
			if(count($ocpdary) > $larcount) $larcount=count($ocpdary);
			if(count($dwpdary) > $larcount) $larcount=count($dwpdary);
			if(count($ugclary) > $larcount) $larcount=count($ugclary);
			if(count($occlary) > $larcount) $larcount=count($occlary);
			if(count($dwclary) > $larcount) $larcount=count($dwclary);
			$lrowspan="";
			if ($larcount>1) 
				$lrowspan=" rowspan=".$larcount."";
			$lcounter+=1;
			$print.='<tr>
				<td '.$lrowspan.'>'.$lcounter.'</td>
				<td '.$lrowspan.'>'.$record['year1'].'</td>	
				<td '.$lrowspan.'>'.$mineral_name.'</td>
				<td '.$lrowspan.'>'.$state_name.'</td>
				<td '.$lrowspan.'>'.$district_name.'</td>												
				<td '.$lrowspan.'>'.$MINE_NAME.'</td>
				<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
				<td '.$lrowspan.'>'.$lease_area.'</td>
				<td '.$lrowspan.'>'.$mine_code.'</td>
				<td '.$lrowspan.'>'.$registration_no.'</td>';
			for ($cnt=0;$cnt < $larcount; $cnt++) {
				if ($cnt > 0) $print.='</tr><tr>';
				//7 starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($ocopary[$cnt]['open_oc_rom']))
						$print.=$ocopary[$cnt]['open_oc_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($ocopary[$cnt]['open_oc_metal_content']))
					$print.=$ocopary[$cnt]['open_oc_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($ocopary[$cnt]['open_oc_grade']))
					$print.=$ocopary[$cnt]['open_oc_grade'];
				$print.="</td>";
				//7 ends
				//1 and 4 starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($ugopary[$cnt]['open_ug_rom']))
						$print.=$ugopary[$cnt]['open_ug_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($ugopary[$cnt]['open_ug_metal_content']))
					$print.=$ugopary[$cnt]['open_ug_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($ugopary[$cnt]['open_ug_grade']))
					$print.=$ugopary[$cnt]['open_ug_grade'];
				$print.="</td>";
				//1 and 4 ends
				//0 dw starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($dwopary[$cnt]['open_dw_rom']))
						$print.=$dwopary[$cnt]['open_dw_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($dwopary[$cnt]['open_dw_metal_content']))
					$print.=$dwopary[$cnt]['open_dw_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($dwopary[$cnt]['open_dw_grade']))
					$print.=$dwopary[$cnt]['open_dw_grade'];
				$print.="</td>";
				//0 dw ends
				//8 oc production starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($ocpdary[$cnt]['prod_oc_rom']))
						$print.=$ocpdary[$cnt]['prod_oc_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($ocpdary[$cnt]['prod_oc_metal_content']))
					$print.=$ocpdary[$cnt]['prod_oc_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($ocpdary[$cnt]['prod_oc_grade']))
					$print.=$ocpdary[$cnt]['prod_oc_grade'];
				$print.="</td>";
				//8 oc production ends
				//2 or 5 ug production starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($ugpdary[$cnt]['prod_ug_rom']))
						$print.=$ugpdary[$cnt]['prod_ug_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($ugpdary[$cnt]['prod_ug_metal_content']))
					$print.=$ugpdary[$cnt]['prod_ug_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($ugpdary[$cnt]['prod_ug_grade']))
					$print.=$ugpdary[$cnt]['prod_ug_grade'];
				$print.="</td>";
				//2 or 5 ug production ends
				// dw production starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($dwpdary[$cnt]['prod_dw_rom']))
						$print.=$dwpdary[$cnt]['prod_dw_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($dwpdary[$cnt]['prod_dw_metal_content']))
					$print.=$dwpdary[$cnt]['prod_dw_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($dwpdary[$cnt]['prod_dw_grade']))
					$print.=$dwpdary[$cnt]['prod_dw_grade'];
				$print.="</td>";
				// dw production ends
				//9 oc clossing starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($occlary[$cnt]['clos_oc_rom']))
						$print.=$occlary[$cnt]['clos_oc_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($occlary[$cnt]['clos_oc_metal_content']))
					$print.=$occlary[$cnt]['clos_oc_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($occlary[$cnt]['clos_oc_grade']))
					$print.=$occlary[$cnt]['clos_oc_grade'];
				$print.="</td>";
				//9 oc clossing ends
				//3 or 6 ug clossing starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($ugclary[$cnt]['clos_ug_rom']))
						$print.=$ugclary[$cnt]['clos_ug_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($ugclary[$cnt]['clos_ug_metal_content']))
					$print.=$ugclary[$cnt]['clos_ug_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($ugclary[$cnt]['clos_ug_grade']))
					$print.=$ugclary[$cnt]['clos_ug_grade'];
				$print.="</td>";
				//3 or 6 ug clossing ends
				// dw clossing starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($dwclary[$cnt]['clos_dw_rom']))
						$print.=$dwclary[$cnt]['clos_dw_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($dwclary[$cnt]['clos_dw_metal_content']))
					$print.=$dwclary[$cnt]['clos_dw_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($dwclary[$cnt]['clos_dw_grade']))
					$print.=$dwclary[$cnt]['clos_dw_grade'];
				$print.="</td>";
				// dw clossing ends
			}
			if ($cnt >0) $print.='</tr>';

		}
        $print.='</tbody>
        </table>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>';
		} else { 
		$print='<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="tHeadFont" id="heading1">Report A03 - ROM Opening Stock, ROM Production & ROM Closing Stock</h4>
                    <div class="form-horizontal">
                        <div class="card-body" id="avb">
						    <h6 class="tHeadDate" id="heading2">Year : '.$showDate.'</h6>
							
							<h6 class="tHeadDate" id="heading2"><strong>Since records are more hence no search & pagination service is available, you may use the option "Export to Excel"</strong></h6>
							<input type="button" id="downloadExcel" value="Export to Excel">
							<br /><br />
							
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" border="1" id="noDatatable">
                                    <thead class="tableHead">
										<tr>
											<th colspan="37" class="noDisplay" align="left">Report A03 - ROM Opening Stock, ROM Production & ROM Closing Stock  Year : '.$showDate.'</th>
										</tr>
                                        <tr>
                                            <th rowspan="2">#</th>
                                            <th rowspan="2">Year</th>
											<th rowspan="2">Mineral</th>
											<th rowspan="2">State</th>
											<th rowspan="2">District</th>                                            
                                            <th rowspan="2">Name of Mine</th>
                                            <th rowspan="2">Name of Lease Owner</th>
                                            <th rowspan="2">Lease Area</th>
											<th rowspan="2">Mine Code</th>
                                            <th rowspan="2">IBM Registration Number</th>
                                            <th colspan="9">Opening Stock</th>
											<th colspan="9">Production</th>
                                            <th colspan="9">Closing Stock</th>
                                        </tr>
                                        <tr>
											<!-- Opening Stock -->
                                            <th>Open Cast (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											
                                            <th>Underground (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											
                                            <th>Dump Working (tonnes)</th>
                                            <th>Metal Content</th>
											<th>Grade</th>
											<!-- End-->
											
											<!-- Production -->
                                            <th>Open Cast (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											
                                            <th>Underground (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											
                                            <th>Dump Working (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											<!-- End-->
											
											<!-- Closing Stock -->
											<th>Open Cast (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											
                                            <th>Underground (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											
                                            <th>Dump Working (tonnes)</th>
											<th>Metal Content</th>
											<th>Grade</th>
											<!-- End-->
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody">';
        foreach ($records as $record) {
            
            if ($lmineral_name != $record['mineral_name']) {
                $lmineral_name = $record['mineral_name'];
                $lflg="Y";
            }
            if ($lstate_name != $record['state_name']) {
                $lstate_name = $record['state_name'];
                $lflg="Y";
            }
            if ($ldistrict_name != $record['district_name']) {
                $ldistrict_name = $record['district_name'];
                $lflg="Y";
            }
            if ($lmonthnm != $record['showMonth']) {
                $lmonthnm  = $record['showMonth'];
                $lflg="Y";
            }
            if ($lyearnm != $record['showYear']) {
                $lyearnm  = $record['showYear'];
                $lflg="Y";
            }
            if ($lmincode!=$record['mine_code']) {
                $lmincode=$record['mine_code'];
                $lflg="Y";
            }
            if ((int)$record['serial_sn']<=0) {
                $lflg="Y";
				if ((int)$record['serial_sn']<=0)
					$lrowspan="";
                
            } 
			if ($lserialno!=(int)$record['serial_sn']) {
				if ($record['serial_sn']>=4 && $record['serial_sn']<=6) {
					if ($lserialno<=3 || $lserialno>=7) {
						$lflg="Y";
					}
				}
				$lserialno=$record['serial_sn'];
			}

            if ($lflg=="Y" || $lcnt <0) {
//
				if ($lcnt >=0) {
					$larcount=count($ugopary);
					if(count($ocopary) > $larcount) $larcount=count($ocopary);
					if(count($dwopary) > $larcount) $larcount=count($dwopary);
					if(count($ugpdary) > $larcount) $larcount=count($ugpdary);
					if(count($ocpdary) > $larcount) $larcount=count($ocpdary);
					if(count($dwpdary) > $larcount) $larcount=count($dwpdary);
					if(count($ugclary) > $larcount) $larcount=count($ugclary);
					if(count($occlary) > $larcount) $larcount=count($occlary);
					if(count($dwclary) > $larcount) $larcount=count($dwclary);
					$lrowspan="";
					if ($larcount>1) 
						$lrowspan=" rowspan=".$larcount."";
					$lcounter+=1;
					$print.='<tr>
						<td '.$lrowspan.'>'.$lcounter.'</td>
						<td '.$lrowspan.'>'.$record['year1'].'</td>	
						<td '.$lrowspan.'>'.$mineral_name.'</td>
						<td '.$lrowspan.'>'.$state_name.'</td>
						<td '.$lrowspan.'>'.$district_name.'</td>												
						<td '.$lrowspan.'>'.$MINE_NAME.'</td>
						<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
						<td '.$lrowspan.'>'.$lease_area.'</td>
						<td '.$lrowspan.'>'.$mine_code.'</td>
						<td '.$lrowspan.'>'.$registration_no.'</td>';
					for ($cnt=0;$cnt < $larcount; $cnt++) {
						if ($cnt > 0) $print.='</tr><tr>';
						//7 starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($ocopary[$cnt]['open_oc_rom']))
								$print.=$ocopary[$cnt]['open_oc_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($ocopary[$cnt]['open_oc_metal_content']))
							$print.=$ocopary[$cnt]['open_oc_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($ocopary[$cnt]['open_oc_grade']))
							$print.=$ocopary[$cnt]['open_oc_grade'];
						$print.="</td>";
						//7 ends
						//1 and 4 starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($ugopary[$cnt]['open_ug_rom']))
								$print.=$ugopary[$cnt]['open_ug_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($ugopary[$cnt]['open_ug_metal_content']))
							$print.=$ugopary[$cnt]['open_ug_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($ugopary[$cnt]['open_ug_grade']))
							$print.=$ugopary[$cnt]['open_ug_grade'];
						$print.="</td>";
						//1 and 4 ends
						//0 dw starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($dwopary[$cnt]['open_dw_rom']))
								$print.=$dwopary[$cnt]['open_dw_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($dwopary[$cnt]['open_dw_metal_content']))
							$print.=$dwopary[$cnt]['open_dw_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($dwopary[$cnt]['open_dw_grade']))
							$print.=$dwopary[$cnt]['open_dw_grade'];
						$print.="</td>";
						//0 dw ends
						//8 oc production starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($ocpdary[$cnt]['prod_oc_rom']))
								$print.=$ocpdary[$cnt]['prod_oc_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($ocpdary[$cnt]['prod_oc_metal_content']))
							$print.=$ocpdary[$cnt]['prod_oc_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($ocpdary[$cnt]['prod_oc_grade']))
							$print.=$ocpdary[$cnt]['prod_oc_grade'];
						$print.="</td>";
						//8 oc production ends
						//2 or 5 ug production starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($ugpdary[$cnt]['prod_ug_rom']))
								$print.=$ugpdary[$cnt]['prod_ug_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($ugpdary[$cnt]['prod_ug_metal_content']))
							$print.=$ugpdary[$cnt]['prod_ug_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($ugpdary[$cnt]['prod_ug_grade']))
							$print.=$ugpdary[$cnt]['prod_ug_grade'];
						$print.="</td>";
						//2 or 5 ug production ends
						// dw production starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($dwpdary[$cnt]['prod_dw_rom']))
								$print.=$dwpdary[$cnt]['prod_dw_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($dwpdary[$cnt]['prod_dw_metal_content']))
							$print.=$dwpdary[$cnt]['prod_dw_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($dwpdary[$cnt]['prod_dw_grade']))
							$print.=$dwpdary[$cnt]['prod_dw_grade'];
						$print.="</td>";
						// dw production ends
						//9 oc clossing starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($occlary[$cnt]['clos_oc_rom']))
								$print.=$occlary[$cnt]['clos_oc_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($occlary[$cnt]['clos_oc_metal_content']))
							$print.=$occlary[$cnt]['clos_oc_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($occlary[$cnt]['clos_oc_grade']))
							$print.=$occlary[$cnt]['clos_oc_grade'];
						$print.="</td>";
						//9 oc clossing ends
						//3 or 6 ug clossing starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($ugclary[$cnt]['clos_ug_rom']))
								$print.=$ugclary[$cnt]['clos_ug_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($ugclary[$cnt]['clos_ug_metal_content']))
							$print.=$ugclary[$cnt]['clos_ug_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($ugclary[$cnt]['clos_ug_grade']))
							$print.=$ugclary[$cnt]['clos_ug_grade'];
						$print.="</td>";
						//3 or 6 ug clossing ends
						// dw clossing starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($dwclary[$cnt]['clos_dw_rom']))
								$print.=$dwclary[$cnt]['clos_dw_rom'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($dwclary[$cnt]['clos_dw_metal_content']))
							$print.=$dwclary[$cnt]['clos_dw_metal_content'];
						$print.="</td>";
						$print.="<td>";
						if (isset($dwclary[$cnt]['clos_dw_grade']))
							$print.=$dwclary[$cnt]['clos_dw_grade'];
						$print.="</td>";
						// dw clossing ends
					}
					if ($cnt >0) $print.='</tr>';

				}

//
                $lcnt++;
                $lflg="";
                $cnt=0;
					
                $mineral_name=ucwords(str_replace('_', ' ', $record['mineral_name']));
                $state_name=$record['state_name']; 
                $district_name=$record['district_name']; 
                $MINE_NAME=$record['MINE_NAME'] ;
                $lessee_owner_name=$record['lessee_owner_name'];
                $lease_area=$record['lease_area'];
                $mine_code=$record['mine_code'];
                $registration_no=$record['registration_no'];

				$ugopary=array();		//under ground open stock
				$ocopary=array();		//open cast open stock
				$dwopary=array();		//dump working open stock
				$ugpdary=array();		//under ground production
				$ocpdary=array();		//open cast production
				$dwpdary=array();		//dump working production
				$ugclary=array();		//under ground closing stock
				$occlary=array();		//open cast closing stock
				$dwclary=array();		//dump working closing stock

				$lugopcnt=-1;			//under ground open stock   
				$locopcnt=-1;			//open cast open stock      
				$ldwopcnt=-1;			//dump working open stock   
				$lugpdcnt=-1;			//under ground production   
				$locpdcnt=-1;			//open cast production      
				$ldwpdcnt=-1;			//dump working production   
				$lugclcnt=-1;			//under ground closing stock
				$locclcnt=-1;			//open cast closing stock   
				$ldwclcnt=-1;			//dump working closing stock

            }
            if ((int)$record['serial_sn']<=0) {
				$lugopcnt=0;			//under ground open stock   
				$locopcnt=0;			//open cast open stock      
				$ldwopcnt=0;			//dump working open stock   
				$lugpdcnt=0;			//under ground production   
				$locpdcnt=0;			//open cast production      
				$ldwpdcnt=0;			//dump working production   
				$lugclcnt=0;			//under ground closing stock
				$locclcnt=0;			//open cast closing stock   
				$ldwclcnt=0;			//dump working closing stock
				$ugopary[$lugopcnt]['open_ug_rom']=$record['open_ug_rom'];
				$ugopary[$lugopcnt]['open_ug_metal_content']=$record['open_ug_metal_content'];
				$ugopary[$lugopcnt]['open_ug_grade']=$record['open_ug_grade'];
				$ocopary[$locopcnt]['open_oc_rom']=$record['open_oc_rom'];
				$ocopary[$locopcnt]['open_oc_metal_content']=$record['open_oc_metal_content'];
				$ocopary[$locopcnt]['open_oc_grade']=$record['open_oc_grade'];
				$dwopary[$ldwopcnt]['open_dw_rom']=$record['open_dw_rom'];
				$dwopary[$ldwopcnt]['open_dw_metal_content']="";
				$dwopary[$ldwopcnt]['open_dw_grade']="";
				$ugpdary[$lugpdcnt]['prod_ug_rom']=$record['prod_ug_rom'];
				$ugpdary[$lugpdcnt]['prod_ug_metal_content']=$record['prod_ug_metal_content'];
				$ugpdary[$lugpdcnt]['prod_ug_grade']=$record['prod_ug_grade'];
				$ocpdary[$locpdcnt]['prod_oc_rom']=$record['prod_oc_rom'];
				$ocpdary[$locpdcnt]['prod_oc_metal_content']=$record['prod_oc_metal_content'];
				$ocpdary[$locpdcnt]['prod_oc_grade']=$record['prod_oc_grade'];
				$dwpdary[$ldwpdcnt]['prod_dw_rom']=$record['prod_dw_rom'];
				$dwpdary[$ldwpdcnt]['prod_dw_metal_content']="";
				$dwpdary[$ldwpdcnt]['prod_dw_grade']="";
				$ugclary[$lugclcnt]['clos_ug_rom']=$record['clos_ug_rom'];
				$ugclary[$lugclcnt]['clos_ug_metal_content']=$record['clos_ug_metal_content'];
				$ugclary[$lugclcnt]['clos_ug_grade']=$record['clos_ug_grade'];
				$occlary[$locclcnt]['clos_oc_rom']=$record['clos_oc_rom'];	
				$occlary[$locclcnt]['clos_oc_metal_content']=$record['clos_oc_metal_content'];	
				$occlary[$locclcnt]['clos_oc_grade']=$record['clos_oc_grade'];	
				$dwclary[$ldwclcnt]['clos_dw_rom']=$record['clos_dw_rom'];
				$dwclary[$ldwclcnt]['clos_dw_metal_content']="";
				$dwclary[$ldwclcnt]['clos_dw_grade']="";				
            } 
            if ((int)$record['serial_sn']==1 || (int)$record['serial_sn']==4) { 
				$lugopcnt+=1;
				$ugopary[$lugopcnt]['open_ug_rom']=$record['open_ug_rom'];
				$ugopary[$lugopcnt]['open_ug_metal_content']=$record['open_ug_metal_content'];
				$ugopary[$lugopcnt]['open_ug_grade']=$record['open_ug_grade'];

            }
            if ((int)$record['serial_sn']==2 || (int)$record['serial_sn']==5) {
				$lugpdcnt+=1;
				$ugpdary[$lugpdcnt]['prod_ug_rom']=$record['prod_ug_rom'];
				$ugpdary[$lugpdcnt]['prod_ug_metal_content']=$record['prod_ug_metal_content'];
				$ugpdary[$lugpdcnt]['prod_ug_grade']=$record['prod_ug_grade'];

            }
            if ((int)$record['serial_sn']==3 || (int)$record['serial_sn']==6) {
				$lugclcnt+=1;
				$ugclary[$lugclcnt]['clos_ug_rom']=$record['clos_ug_rom'];
				$ugclary[$lugclcnt]['clos_ug_metal_content']=$record['clos_ug_metal_content'];
				$ugclary[$lugclcnt]['clos_ug_grade']=$record['clos_ug_grade'];

            }

            if ((int)$record['serial_sn']==7) {   
				$locopcnt+=1;
				$ocopary[$locopcnt]['open_oc_rom']=$record['open_oc_rom'];
				$ocopary[$locopcnt]['open_oc_metal_content']=$record['open_oc_metal_content'];
				$ocopary[$locopcnt]['open_oc_grade']=$record['open_oc_grade'];
            }
            if ((int)$record['serial_sn']==8) { 
				$locpdcnt+=1;
				$ocpdary[$locpdcnt]['prod_oc_rom']=$record['prod_oc_rom'];
				$ocpdary[$locpdcnt]['prod_oc_metal_content']=$record['prod_oc_metal_content'];
				$ocpdary[$locpdcnt]['prod_oc_grade']=$record['prod_oc_grade'];


            }  
            if ((int)$record['serial_sn']==9) {  
				$locclcnt+=1;
				$occlary[$locclcnt]['clos_oc_rom']=$record['clos_oc_rom'];	
				$occlary[$locclcnt]['clos_oc_metal_content']=$record['clos_oc_metal_content'];	
				$occlary[$locclcnt]['clos_oc_grade']=$record['clos_oc_grade'];
            }            
			
        }
		if ($lcnt >=0) {
			$larcount=count($ugopary);
			if(count($ocopary) > $larcount) $larcount=count($ocopary);
			if(count($dwopary) > $larcount) $larcount=count($dwopary);
			if(count($ugpdary) > $larcount) $larcount=count($ugpdary);
			if(count($ocpdary) > $larcount) $larcount=count($ocpdary);
			if(count($dwpdary) > $larcount) $larcount=count($dwpdary);
			if(count($ugclary) > $larcount) $larcount=count($ugclary);
			if(count($occlary) > $larcount) $larcount=count($occlary);
			if(count($dwclary) > $larcount) $larcount=count($dwclary);
			$lrowspan="";
			if ($larcount>1) 
				$lrowspan=" rowspan=".$larcount."";
			$lcounter+=1;
			$print.='<tr>
				<td '.$lrowspan.'>'.$lcounter.'</td>
				<td '.$lrowspan.'>'.$record['year1'].'</td>	
				<td '.$lrowspan.'>'.$mineral_name.'</td>
				<td '.$lrowspan.'>'.$state_name.'</td>
				<td '.$lrowspan.'>'.$district_name.'</td>												
				<td '.$lrowspan.'>'.$MINE_NAME.'</td>
				<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
				<td '.$lrowspan.'>'.$lease_area.'</td>
				<td '.$lrowspan.'>'.$mine_code.'</td>
				<td '.$lrowspan.'>'.$registration_no.'</td>';
			for ($cnt=0;$cnt < $larcount; $cnt++) {
				if ($cnt > 0) $print.='</tr><tr>';
				//7 starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($ocopary[$cnt]['open_oc_rom']))
						$print.=$ocopary[$cnt]['open_oc_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($ocopary[$cnt]['open_oc_metal_content']))
					$print.=$ocopary[$cnt]['open_oc_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($ocopary[$cnt]['open_oc_grade']))
					$print.=$ocopary[$cnt]['open_oc_grade'];
				$print.="</td>";
				//7 ends
				//1 and 4 starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($ugopary[$cnt]['open_ug_rom']))
						$print.=$ugopary[$cnt]['open_ug_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($ugopary[$cnt]['open_ug_metal_content']))
					$print.=$ugopary[$cnt]['open_ug_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($ugopary[$cnt]['open_ug_grade']))
					$print.=$ugopary[$cnt]['open_ug_grade'];
				$print.="</td>";
				//1 and 4 ends
				//0 dw starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($dwopary[$cnt]['open_dw_rom']))
						$print.=$dwopary[$cnt]['open_dw_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($dwopary[$cnt]['open_dw_metal_content']))
					$print.=$dwopary[$cnt]['open_dw_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($dwopary[$cnt]['open_dw_grade']))
					$print.=$dwopary[$cnt]['open_dw_grade'];
				$print.="</td>";
				//0 dw ends
				//8 oc production starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($ocpdary[$cnt]['prod_oc_rom']))
						$print.=$ocpdary[$cnt]['prod_oc_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($ocpdary[$cnt]['prod_oc_metal_content']))
					$print.=$ocpdary[$cnt]['prod_oc_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($ocpdary[$cnt]['prod_oc_grade']))
					$print.=$ocpdary[$cnt]['prod_oc_grade'];
				$print.="</td>";
				//8 oc production ends
				//2 or 5 ug production starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($ugpdary[$cnt]['prod_ug_rom']))
						$print.=$ugpdary[$cnt]['prod_ug_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($ugpdary[$cnt]['prod_ug_metal_content']))
					$print.=$ugpdary[$cnt]['prod_ug_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($ugpdary[$cnt]['prod_ug_grade']))
					$print.=$ugpdary[$cnt]['prod_ug_grade'];
				$print.="</td>";
				//2 or 5 ug production ends
				// dw production starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($dwpdary[$cnt]['prod_dw_rom']))
						$print.=$dwpdary[$cnt]['prod_dw_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($dwpdary[$cnt]['prod_dw_metal_content']))
					$print.=$dwpdary[$cnt]['prod_dw_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($dwpdary[$cnt]['prod_dw_grade']))
					$print.=$dwpdary[$cnt]['prod_dw_grade'];
				$print.="</td>";
				// dw production ends
				//9 oc clossing starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($occlary[$cnt]['clos_oc_rom']))
						$print.=$occlary[$cnt]['clos_oc_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($occlary[$cnt]['clos_oc_metal_content']))
					$print.=$occlary[$cnt]['clos_oc_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($occlary[$cnt]['clos_oc_grade']))
					$print.=$occlary[$cnt]['clos_oc_grade'];
				$print.="</td>";
				//9 oc clossing ends
				//3 or 6 ug clossing starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($ugclary[$cnt]['clos_ug_rom']))
						$print.=$ugclary[$cnt]['clos_ug_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($ugclary[$cnt]['clos_ug_metal_content']))
					$print.=$ugclary[$cnt]['clos_ug_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($ugclary[$cnt]['clos_ug_grade']))
					$print.=$ugclary[$cnt]['clos_ug_grade'];
				$print.="</td>";
				//3 or 6 ug clossing ends
				// dw clossing starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($dwclary[$cnt]['clos_dw_rom']))
						$print.=$dwclary[$cnt]['clos_dw_rom'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($dwclary[$cnt]['clos_dw_metal_content']))
					$print.=$dwclary[$cnt]['clos_dw_metal_content'];
				$print.="</td>";
				$print.="<td>";
				if (isset($dwclary[$cnt]['clos_dw_grade']))
					$print.=$dwclary[$cnt]['clos_dw_grade'];
				$print.="</td>";
				// dw clossing ends
			}
			if ($cnt >0) $print.='</tr>';

		}
        $print.='</tbody>
        </table>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>';
		}

		return $print;
	}

    /*public function reportA04()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower(str_replace(' ', '_', $mineral));
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            $sql = "SELECT DISTINCT r5.mineral_name, r5.mine_code, m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name,
            d.district_name, (ml.under_forest_area + ml.outside_forest_area) AS lease_area, 
            CASE
                WHEN r5.rom_5_step_sn = 10 THEN r5.tot_qty
            END AS open_stock_qty,
            CASE
                WHEN r5.rom_5_step_sn = 10 THEN CONCAT(r5.metal_content, ' ', r5.grade)
            END AS open_stock_metal,
            CASE
                WHEN r5.rom_5_step_sn = 11 THEN r5.tot_qty
            END AS ore_rec_qty,
            CASE
                WHEN r5.rom_5_step_sn = 11 THEN CONCAT(r5.metal_content, ' ', r5.grade)
            END AS ore_rec_metal,
            CASE
                WHEN r5.rom_5_step_sn = 12 THEN r5.tot_qty
            END AS ore_treat_qty,
            CASE
                WHEN r5.rom_5_step_sn = 12 THEN CONCAT(r5.metal_content, ' ', r5.grade)
            END AS ore_treat_metal,
            CASE
                WHEN r5.rom_5_step_sn = 13 THEN r5.tot_qty
            END AS concentrate_obtain_qty,
            CASE
                WHEN r5.rom_5_step_sn = 13 THEN CONCAT(r5.metal_content, ' ', r5.grade)
            END AS concentrate_obtain_metal,
            CASE
                WHEN r5.rom_5_step_sn = 14 THEN r5.tot_qty
            END AS tail_qty,
            CASE
                WHEN r5.rom_5_step_sn = 14 THEN CONCAT(r5.metal_content, ' ', r5.grade)
            END AS tail_metal,
            CASE
                WHEN r5.rom_5_step_sn = 15 THEN r5.tot_qty
            END AS clos_stock_qty,
            CASE
                WHEN r5.rom_5_step_sn = 15 THEN CONCAT(r5.metal_content, ' ', r5.grade)
            END AS clos_stock_metal,
            CASE
                WHEN rs.smelter_step_sn = 1 THEN rs.qty
            END AS qyt_open_smelter,
            CASE
                WHEN rs.smelter_step_sn = 1 THEN rs.grade
            END AS metal_open_smelter,
            CASE
                WHEN rs.smelter_step_sn = 2 THEN rs.qty
            END AS concentrate_rec_qty,
            CASE
                WHEN rs.smelter_step_sn = 2 THEN rs.grade
            END AS concentrate_rec_metal,
            CASE
                WHEN rs.smelter_step_sn = 4 THEN rs.qty
            END AS concentrate_sold_qty,
            CASE
                WHEN rs.smelter_step_sn = 4 THEN rs.grade
            END AS concentrate_sold_metal,
            CASE
                WHEN rs.smelter_step_sn = 5 THEN rs.qty
            END AS concentrate_treat_qty,
            CASE
                WHEN rs.smelter_step_sn = 5 THEN rs.grade
            END AS concentrate_treat_metal,
            CASE
                WHEN rs.smelter_step_sn = 6 THEN rs.qty
            END AS qyt_close_smelter,
            CASE
                WHEN rs.smelter_step_sn = 6 THEN rs.grade
            END AS metal_close_smelter,
            CASE
                WHEN rs.smelter_step_sn = 7 THEN rs.qty
            END AS other_prod_qty,
            CASE
                WHEN rs.smelter_step_sn = 7 THEN rs.grade
            END AS other_prod_grade,
            CASE
                WHEN rs.smelter_step_sn = 7 THEN rs.value
            END AS other_prod_value,
            CASE
                WHEN rs.smelter_step_sn = 6 THEN rs.qty
            END AS metal_recover_qty,
            CASE
                WHEN rs.smelter_step_sn = 6 THEN rs.grade
            END AS metal_recover_grade,
            CASE
                WHEN rs.smelter_step_sn = 6 THEN rs.value
            END AS metal_recover_value
        FROM
            mine m
                INNER JOIN
            dir_state s ON m.state_code = s.state_code
                INNER JOIN
            dir_district d ON m.district_code = d.district_code
                AND d.state_code = s.state_code
                INNER JOIN
            rom_5 r5 ON m.mine_code = r5.mine_code
                AND r5.return_date = '$from_date'
                AND r5.return_type = '$returnType'
                INNER JOIN
            recov_smelter rs ON rs.mine_code = r5.mine_code
                AND m.mine_code = rs.mine_code
                AND rs.return_date = '$from_date'
                AND rs.return_type = '$returnType'
                AND r5.return_date = rs.return_date
                AND r5.return_type = rs.return_type
                LEFT JOIN
            mcp_lease ml ON m.mine_code = ml.mine_code
                AND rs.mine_code = ml.mine_code
                AND r5.mine_code = ml.mine_code
        WHERE
            r5.return_type = '$returnType' AND r5.return_date = '$from_date' AND rs.return_date = '$from_date' AND rs.return_type = '$returnType'";

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND rs.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND rs.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND (ml.under_forest_area + ml.outside_forest_area) = '$lesseearea'";
            }
            // pr($sql);exit;
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }*/
	
	public function createfileA04($lhtml,$lfilenm) {
		$lext=".xlsx";
		$lwriter="Xlsx";				
		
		$filename = "reports/".$lfilenm.$lext;	//'.xlsx';
	
		if (file_exists($filename)) {
			unlink($filename);
		}
		$tempfile='../tmp/tmp_repa04'.strftime("%d-%m-%Y").'.html';
		if (file_exists($tempfile)) {
			unlink($tempfile);
		}

		file_put_contents($tempfile,$lhtml);
		$reader=IOFactory::createReader('Html');
		$spreadsheet=$reader->load($tempfile);
		$writer=IOFactory::createWriter($spreadsheet,$lwriter);
		$writer->save($filename);
		unlink($tempfile);
		return $lfilenm.$lext;
	}
	
    public function reportA04()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower($mineral);
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            $sql = "SELECT m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name,
             '$from_year' AS year1, '$next_year' AS year2,'$showDate' AS showDate, ml.mcmdt_ML_Area AS lease_area, r5.mine_code, r5.mineral_name, r5.tot_qty,
            r5.grade, r5.metal_content, r5.rom_5_step_sn, '' AS value, r5.return_date
            FROM
            tbl_final_submit tfs
			   INNER JOIN rom_5 r5 on r5.mine_code = tfs.mine_code
			   AND tfs.return_type = '$returnType'
                INNER JOIN
            mine m ON m.mine_code = r5.mine_code
                INNER JOIN
            dir_state s ON m.state_code = s.state_code
                INNER JOIN
            dir_district d ON m.district_code = d.district_code
                AND d.state_code = s.state_code
                  LEFT JOIN
            mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1 
            WHERE
            r5.return_type = '$returnType'
                AND r5.return_date = '$from_date'
                AND r5.rom_5_step_sn > 9 AND tfs.is_latest = 1 AND tfs.return_type = '$returnType'";
			if($mineral != ''){
				$sql .= " AND r5.mineral_name = '$mineral'";
				}
				
           $sql .=" UNION SELECT m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name,  '$from_year' AS year1, '$next_year' AS year2,'$showDate' AS showDate,
            ml.mcmdt_ML_Area AS lease_area, rm.mine_code, rm.mineral_name, rm.qty, rm.grade, rm.metal_name, rm.rom_5_step_sn, rm.value, rm.return_date
            FROM
            tbl_final_submit tfs
			   INNER JOIN rom_metal_5 rm on rm.mine_code = tfs.mine_code
			   AND tfs.return_type = '$returnType'
                INNER JOIN
            mine m ON m.mine_code = rm.mine_code
                INNER JOIN
            dir_state s ON m.state_code = s.state_code
                INNER JOIN
            dir_district d ON m.district_code = d.district_code
                AND d.state_code = s.state_code
                  LEFT JOIN
            mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1 
            WHERE
				rm.return_date = '$from_date'
                AND rm.return_type = '$returnType' AND tfs.is_latest = 1 AND tfs.return_type = '$returnType'";
				
				if($mineral != ''){
				$sql .= " AND rm.mineral_name = '$mineral'";
				}
				
            $sql .=" UNION SELECT m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, '$from_year' AS year1, '$next_year' AS year2,'$showDate' AS showDate,
            ml.mcmdt_ML_Area AS lease_area, rs.mine_code, rs.mineral_name, rs.qty, rs.grade, rs.type_concentrate AS metal_content,
            rs.smelter_step_sn AS rom_step_sn_5, rs.value, rs.return_date
            FROM
            tbl_final_submit tfs
			   INNER JOIN recov_smelter rs on rs.mine_code = tfs.mine_code
			   AND tfs.return_type = '$returnType'
                INNER JOIN
            mine m ON m.mine_code = rs.mine_code
                INNER JOIN
            dir_state s ON m.state_code = s.state_code
                INNER JOIN
            dir_district d ON m.district_code = d.district_code
                AND d.state_code = s.state_code
                LEFT JOIN
            mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1 
            WHERE
				rs.return_date = '$from_date'
                AND rs.return_type = '$returnType' AND  tfs.is_latest = 1 AND tfs.return_type = '$returnType'";
				if($mineral != ''){
				$sql .= " AND rs.mineral_name = '$mineral'";
				}

          
            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND rs.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND rs.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
            $sql .= "order by mineral_name,state_name,district_name,return_date,mine_code,rom_5_step_sn, metal_content";

           // print_r($sql);exit;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $lprint=$this->generatea04($records,$showDate,$rowCount);
				$lfilenm="reporta04_".strftime("%d-%m-%Y"); //.$_SESSION['mms_user_email'];
				$lfile=$this->createfileA04($lprint,$lfilenm);
                $this->set('lprint',$lprint);	
				$this->set('lfilenm',$lfilenm);				
                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }
	
	public function generatea04($records,$showDate,$rowCount) {
		$datarry=array();
        $lcnt=-1;
        $cnt=0;
		$lcounter=0;
        $lmineral_name = "";
        $lstate_name = "";
        $ldistrict_name = "";
        $lmonthnm = "";
        $lyearnm = "";
        $lmincode="";
		$lserialno="";
        $lflg="";
        $print="";
		
		$oreopstk=array();		//Opening Stock of the Ore at concentrator/plant
		$orerecmine=array();		//Ore received from the Mine
		$oretreatcp=array();		//Ore treated at concentrator plant
		$concobtain=array();		//Concentrates Obtained
		$trailing=array();		//Tailing
		$clstkcpnt=array();		//Closing Stock of Concentrate at Concentrator/Plant
		$opstkspnt=array();		//Opening Stock of Concentrates at Smelter/Plant
		$cntrecpnt=array();		//Concentrates Received from Concentrator/plant
		$cntrecoth=array();		//Concentrates Received from other sources(specify)
		$cntsold=array();		//Concentrates Sold (if any)
		$cnttreat=array();		//Concentrates Treated
		$clstkspnt=array();		//Closing Stock of Concentrate at the smelter/plant
		$metlrecvd=array();		//Metal Recoverd (specify)
		$othprodrec=array();		//Other by Products if any recovered
		$lrcnt1=-1;
		$lrcnt2=-1;
		$lrcnt3=-1;
		$lrcnt4=-1;
		$lrcnt5=-1;

		$lrcnt6=-1;
		$lrcnt7=-1;
		$lrcnt8=-1;
		$lrcnt10=-1;
		$lrcnt11=-1;
		$lrcnt12=-1;
		$lrcnt13=-1;
		$lrcnt14=-1;
		$lrcnt15=-1;
		
		if($rowCount <= 15000) {
		$print='<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<h4 class="tHeadFont" id="heading1">Report A04 - Mine to Smelter Details (Ore to Metal)</h4>
						<div class="form-horizontal">
							<div class="card-body" id="avb">
								<h6 class="tHeadDate"  id="heading2">Year : '.$showDate.'</h6>
								<div class="table-responsive">
									<table class="table table-striped table-hover table-bordered compact" id="tableReport">
										<thead class="tableHead">
											<tr>
												<th rowspan="2">#</th>
												<th rowspan="2">Year</th>
												<th rowspan="2">Mineral</th>
												<th rowspan="2">State</th>
												<th rowspan="2">District</th>
												<th rowspan="2">Name of Mine</th>
												<th rowspan="2">Name of Lease Owner</th>
												<th rowspan="2">Lease Area</th>
												<th rowspan="2">Mine Code</th>
												<th rowspan="2">IBM Registration Number</th>
												<th colspan="3"> Opening Stock of the Ore at concentrator/plant</th>
												<th colspan="3">Ore received from the Mine</th>
												<th colspan="3">Ore treated at concentrator plant</th>
												<th colspan="4">Concentrates Obtained</th>
												<th colspan="3">Tailing</th>
												<th colspan="3">Closing Stock of Concentrate at Concentrator/Plant</th>
												<th colspan="3">Opening Stock of Concentrates at Smelter/Plant</th>
												<th colspan="2">Concentrates Received from Concentrator/plant</th>
												<th colspan="2">Concentrates Received from other sources(specify)</th>
												<th colspan="2">Concentrates Sold (if any)</th>
												<th colspan="2">Concentrates Treated</th>
												<th colspan="2">Closing Stock of Concentrate at the smelter/plant</th>
												<th colspan="4">Metal Recoverd (specify)</th>
												<th colspan="4">Other by Products if any recovered</th>
											</tr>
											<tr>
												<th>Quantity(tonnes)</th>
												<th colspan="2">Metal Content/Grade</th>
												<th>Quantity(tonnes)</th>
												<th colspan="2">Metal Content / Grade</th>
												<th>Quantity(tonnes)</th>
												<th colspan="2">Metal Content / Grade</th>
												<th>Quantity(tonnes)</th>
												<th colspan="2">Metal Content / Grade</th>
												<th>Value</th>
												<th>Quantity(tonnes)</th>
												<th colspan="2">Metal Content / Grade</th>
												<th>Quantity(tonnes)</th>
												<th colspan="2">Metal Content / Grade</th>
												<th>Metal</th>
												<th>Quantity(tonnes)</th>
												<th>Metal Content/Grade</th>
												<th>Quantity(tonnes)</th>
												<th>Metal Content/Grade</th>
												<th>Quantity(tonnes)</th>
												<th>Metal Content/Grade</th>
												<th>Quantity(tonnes)</th>
												<th>Metal Content/Grade</th>
												<th>Quantity(tonnes)</th>
												<th>Metal Content/Grade</th>
												<th>Quantity(tonnes)</th>
												<th>Metal Content/Grade</th>
												<th>Metal</th>
												<th>Quantity(tonnes)</th>
												<th>Grade</th>
												<th> Value(Rs)</th>
												<th>Metal</th>
												<th>Quantity(tonnes)</th>
												<th>Grade</th>
												<th> Value(Rs)</th>
											</tr>

										</thead>
										<tbody class="tableBody">';
        foreach ($records as $record) {
            
            if ($lmineral_name != $record['mineral_name']) {
                $lmineral_name = $record['mineral_name'];
                $lflg="Y";
            }
            if ($lstate_name != $record['state_name']) {
                $lstate_name = $record['state_name'];
                $lflg="Y";
            }
            if ($ldistrict_name != $record['district_name']) {
                $ldistrict_name = $record['district_name'];
                $lflg="Y";
            }
            if ($lmonthnm != $record['showMonth']) {
                $lmonthnm  = $record['showMonth'];
                $lflg="Y";
            }
            if ($lyearnm != $record['showYear']) {
                $lyearnm  = $record['showYear'];
                $lflg="Y";
            }
            if ($lmincode!=$record['mine_code']) {
                $lmincode=$record['mine_code'];
                $lflg="Y";
            }


            if ($lflg=="Y" || $lcnt <0) {
                if ($lcnt >=0) {
					$larcount=count($oreopstk);
					if (count($orerecmine) >$larcount) $larcount=count($orerecmine);
					if (count($oretreatcp) >$larcount) $larcount=count($oretreatcp);
					if (count($concobtain) >$larcount) $larcount=count($concobtain);
					if (count($trailing)   >$larcount) $larcount=count($trailing);
					if (count($clstkcpnt)  >$larcount) $larcount=count($clstkcpnt);
					if (count($opstkspnt)  >$larcount) $larcount=count($opstkspnt);
					if (count($cntrecpnt)  >$larcount) $larcount=count($cntrecpnt);
					if (count($cntrecoth)  >$larcount) $larcount=count($cntrecoth);
					if (count($cntsold)    >$larcount) $larcount=count($cntsold);
					if (count($cnttreat)   >$larcount) $larcount=count($cnttreat);
					if (count($clstkspnt)  >$larcount) $larcount=count($clstkspnt);
					if (count($metlrecvd)  >$larcount) $larcount=count($metlrecvd);
					if (count($othprodrec) >$larcount) $larcount=count($othprodrec);
					$lrowspan="";
					if ($larcount>1) 
						$lrowspan=" rowspan=".$larcount."";
				$lcounter+=1;					
				$print.='<tr>
					<td '.$lrowspan.'>'.$lcounter.'</td>
					<td '.$lrowspan.'>'.$record['year1'].'</td>	
					<td '.$lrowspan.'>'.$mineral_name.'</td>
					<td '.$lrowspan.'>'.$state_name.'</td>
					<td '.$lrowspan.'>'.$district_name.'</td>												
					<td '.$lrowspan.'>'.$MINE_NAME.'</td>
					<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
					<td '.$lrowspan.'>'.$lease_area.'</td>
					<td '.$lrowspan.'>'.$mine_code.'</td>
					<td '.$lrowspan.'>'.$registration_no.'</td>';
					for ($cnt=0;$cnt < $larcount; $cnt++) {
						if ($cnt > 0) $print.='</tr><tr>';
						//10 starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($oreopstk[$cnt]['open_stock_qty']))
								$print.=$oreopstk[$cnt]['open_stock_qty'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($oreopstk[$cnt]['open_stock_metal']))
							$print.=$oreopstk[$cnt]['open_stock_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($oreopstk[$cnt]['open_stock_metal_grade']))
							$print.=$oreopstk[$cnt]['open_stock_metal_grade'];
						$print.="</td>";
						//10 ends
						//11 starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($orerecmine[$cnt]['ore_rec_qty']))
								$print.=$orerecmine[$cnt]['ore_rec_qty'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($orerecmine[$cnt]['ore_rec_metal']))
							$print.=$orerecmine[$cnt]['ore_rec_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($orerecmine[$cnt]['ore_rec_metal_grade']))
							$print.=$orerecmine[$cnt]['ore_rec_metal_grade'];
						$print.="</td>";
						//11 ends
						//12 starts					
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($oretreatcp[$cnt]['ore_treat_qty']))
								$print.=$oretreatcp[$cnt]['ore_treat_qty'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($oretreatcp[$cnt]['ore_treat_metal']))
							$print.=$oretreatcp[$cnt]['ore_treat_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($oretreatcp[$cnt]['ore_treat_metal_grade']))
							$print.=$oretreatcp[$cnt]['ore_treat_metal_grade'];
						$print.="</td>";
						//12 end

						//13 start
						$print.="<td>";
						if (isset($concobtain[$cnt]['concentrate_obtain_metal']))
							$print.=$concobtain[$cnt]['concentrate_obtain_metal'];
						$print.="</td>";
				
						$print.="<td>";
						if (isset($concobtain[$cnt]['concentrate_obtain_qty']))
							$print.=$concobtain[$cnt]['concentrate_obtain_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($concobtain[$cnt]['concentrate_obtain_metal_grade']))
							$print.=$concobtain[$cnt]['concentrate_obtain_metal_grade'];
						$print.="</td>";
						$print.="<td>";
						if (isset($concobtain[$cnt]['concentrate_obtain_value']))
							$print.=$concobtain[$cnt]['concentrate_obtain_value'];
						$print.="</td>";
						//13 end
						//14 start
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";

							if (isset($trailing[$cnt]['tail_qty']))
								$print.=$trailing[$cnt]['tail_qty'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($trailing[$cnt]['tail_metal']))
							$print.=$trailing[$cnt]['tail_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($trailing[$cnt]['tail_metal_grade']))
							$print.=$trailing[$cnt]['tail_metal_grade'];
						$print.="</td>";
						//14 end
						//15 start
						$print.="<td>";
						if (isset($clstkcpnt[$cnt]['clos_stock_qty']))
							$print.=$clstkcpnt[$cnt]['clos_stock_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($clstkcpnt[$cnt]['clos_stock_metal']))
							$print.=$clstkcpnt[$cnt]['clos_stock_metal'];
						$print.="</td>";						
						$print.="<td>";
						if (isset($clstkcpnt[$cnt]['clos_stock_metal_grade']))
							$print.=$clstkcpnt[$cnt]['clos_stock_metal_grade'];
						$print.="</td>";
						//15 end
						//1 start
						$print.="<td>";
						if (isset($opstkspnt[$cnt]['qyt_open_smelter_metal']))
							$print.=$opstkspnt[$cnt]['qyt_open_smelter_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($opstkspnt[$cnt]['qyt_open_smelter']))
							$print.=$opstkspnt[$cnt]['qyt_open_smelter'];
						$print.="</td>";
						$print.="<td>";
						if (isset($opstkspnt[$cnt]['metal_open_smelter']))
							$print.=$opstkspnt[$cnt]['metal_open_smelter'];
						$print.="</td>";
						//1 end
						//2 start
						$print.="<td>";
						if (isset($cntrecpnt[$cnt]['concentrate_rec_qty']))
							$print.=$cntrecpnt[$cnt]['concentrate_rec_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($cntrecpnt[$cnt]['concentrate_rec_metal']))
							$print.=$cntrecpnt[$cnt]['concentrate_rec_metal'];
						$print.="</td>";
						//2 end
						//3 start
						$print.="<td>";
						if (isset($cntrecoth[$cnt]['concentrate_other_src_qty']))
							$print.=$cntrecoth[$cnt]['concentrate_other_src_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($cntrecoth[$cnt]['concentrate_other_src_grade']))
							$print.=$cntrecoth[$cnt]['concentrate_other_src_grade'];
						$print.="</td>";
						//3 end
						//4 start
						$print.="<td>";
						if (isset($cntsold[$cnt]['concentrate_sold_qty']))
							$print.=$cntsold[$cnt]['concentrate_sold_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($cntsold[$cnt]['concentrate_sold_metal']))
							$print.=$cntsold[$cnt]['concentrate_sold_metal'];
						$print.="</td>";
						//4 end
						//5 start
						$print.="<td>";
						if (isset($cnttreat[$cnt]['concentrate_treat_qty']))
							$print.=$cnttreat[$cnt]['concentrate_treat_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($cnttreat[$cnt]['concentrate_treat_metal']))
							$print.=$cnttreat[$cnt]['concentrate_treat_metal'];
						$print.="</td>";
						//5 end
						//8 start
						$print.="<td>";
						if (isset($clstkspnt[$cnt]['qyt_close_smelter']))
							$print.=$clstkspnt[$cnt]['qyt_close_smelter'];
						$print.="</td>";
						$print.="<td>";
						if (isset($clstkspnt[$cnt]['metal_close_smelter']))
							$print.=$clstkspnt[$cnt]['metal_close_smelter'];
						$print.="</td>";
						//8 end
						//6 start
						$print.="<td>";
						if (isset($metlrecvd[$cnt]['metal_recover_qty_metal']))
							$print.=$metlrecvd[$cnt]['metal_recover_qty_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($metlrecvd[$cnt]['metal_recover_qty']))
							$print.=$metlrecvd[$cnt]['metal_recover_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($metlrecvd[$cnt]['metal_recover_grade']))
							$print.=$metlrecvd[$cnt]['metal_recover_grade'];
						$print.="</td>";
						$print.="<td>";
						if (isset($metlrecvd[$cnt]['metal_recover_value']))
							$print.=$metlrecvd[$cnt]['metal_recover_value'];
						$print.="</td>";
						//6 end
						//7 start
						$print.="<td>";
						if (isset($othprodrec[$cnt]['other_prod_grade_metal']))
							$print.=$othprodrec[$cnt]['other_prod_grade_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($othprodrec[$cnt]['other_prod_qty']))
							$print.=$othprodrec[$cnt]['other_prod_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($othprodrec[$cnt]['other_prod_grade']))
							$print.=$othprodrec[$cnt]['other_prod_grade'];
						$print.="</td>";
						$print.="<td>";
						if (isset($othprodrec[$cnt]['other_prod_value']))
							$print.=$othprodrec[$cnt]['other_prod_value'];
						$print.="</td>";
						//7 end

					}
					if ($cnt >0) $print.='</tr>';
                }
                $lcnt++;
                $lflg="";
                $cnt=0;
				
                $mineral_name=ucwords(str_replace('_', ' ', $record['mineral_name']));
                $state_name=$record['state_name']; 
                $district_name=$record['district_name']; 
                $MINE_NAME=$record['MINE_NAME'] ;
                $lessee_owner_name=$record['lessee_owner_name'];
                $lease_area=$record['lease_area'];
                $mine_code=$record['mine_code'];
                $registration_no=$record['registration_no']; 
				$oreopstk=array();		//Opening Stock of the Ore at concentrator/plant
				$orerecmine=array();		//Ore received from the Mine
				$oretreatcp=array();		//Ore treated at concentrator plant
				$concobtain=array();		//Concentrates Obtained
				$trailing=array();		//Tailing
				$clstkcpnt=array();		//Closing Stock of Concentrate at Concentrator/Plant
				$opstkspnt=array();		//Opening Stock of Concentrates at Smelter/Plant
				$cntrecpnt=array();		//Concentrates Received from Concentrator/plant
				$cntrecoth=array();		//Concentrates Received from other sources(specify)
				$cntsold=array();		//Concentrates Sold (if any)
				$cnttreat=array();		//Concentrates Treated
				$clstkspnt=array();		//Closing Stock of Concentrate at the smelter/plant
				$metlrecvd=array();		//Metal Recoverd (specify)
				$othprodrec=array();		//Other by Products if any recovered				
				$lrcnt1=-1;
				$lrcnt2=-1;
				$lrcnt3=-1;
				$lrcnt4=-1;
				$lrcnt5=-1;

				$lrcnt6=-1;
				$lrcnt7=-1;
				$lrcnt8=-1;
				$lrcnt10=-1;
				$lrcnt11=-1;
				$lrcnt12=-1;
				$lrcnt13=-1;
				$lrcnt14=-1;
				$lrcnt15=-1;

            }
            if ((int)$record['rom_5_step_sn']==1) { 
				$lrcnt1+=1;
				$opstkspnt[$lrcnt1]['qyt_open_smelter']=$record['tot_qty'];
				$opstkspnt[$lrcnt1]['metal_open_smelter']=$record['grade'];
				$opstkspnt[$lrcnt1]['qyt_open_smelter_metal']=$record['metal_content'];
            }
            if ((int)$record['rom_5_step_sn']==2) { 
				$lrcnt2+=1;
				$cntrecpnt[$lrcnt2]['concentrate_rec_qty']=$record['tot_qty'];
				$cntrecpnt[$lrcnt2]['concentrate_rec_metal']=$record['grade'];
            }          
            if ((int)$record['rom_5_step_sn']==3) { 
				$lrcnt3+=1;
				$cntrecoth[$lrcnt3]['concentrate_other_src_qty']=$record['tot_qty'];
				$cntrecoth[$lrcnt3]['concentrate_other_src_grade']=$record['grade'];
            }
            if ((int)$record['rom_5_step_sn']==4) { 
				$lrcnt4+=1;
				$cntsold[$lrcnt4]['concentrate_sold_qty']=$record['tot_qty'];
				$cntsold[$lrcnt4]['concentrate_sold_metal']=$record['grade'];

            }
            if ((int)$record['rom_5_step_sn']==5) { 
				$lrcnt5+=1;
				$cnttreat[$lrcnt5]['concentrate_treat_qty']=$record['tot_qty'];
				$cnttreat[$lrcnt5]['concentrate_treat_metal']=$record['grade'];
            }
            if ((int)$record['rom_5_step_sn']==6) { 
				$lrcnt6+=1;
				$metlrecvd[$lrcnt6]['metal_recover_qty_metal']=$record['metal_content'];
				$metlrecvd[$lrcnt6]['metal_recover_qty']=$record['tot_qty'];
				$metlrecvd[$lrcnt6]['metal_recover_grade']=$record['grade'];
				$metlrecvd[$lrcnt6]['metal_recover_value']=$record['value'];
            }	
            if ((int)$record['rom_5_step_sn']==7) { 
				$lrcnt7+=1;
				$othprodrec[$lrcnt7]['other_prod_grade_metal']=$record['metal_content'];
				$othprodrec[$lrcnt7]['other_prod_qty']=$record['tot_qty'];
				$othprodrec[$lrcnt7]['other_prod_grade']=$record['grade'];
				$othprodrec[$lrcnt7]['other_prod_value']=$record['value'];
            }
            if ((int)$record['rom_5_step_sn']==8) { 
				$lrcnt8+=1;
				$clstkspnt[$lrcnt8]['qyt_close_smelter']=$record['tot_qty'];
				//as discussed dated on 12-04-22 use value column instead of grade
				//$clstkspnt[$lrcnt8]['metal_close_smelter']=$record['grade'];
				$clstkspnt[$lrcnt8]['metal_close_smelter']=$record['value'];

            }
            if ((int)$record['rom_5_step_sn']==10) { 
				$lrcnt10+=1;
				$oreopstk[$lrcnt10]['open_stock_qty']=$record['tot_qty'];
				$oreopstk[$lrcnt10]['open_stock_metal']=$record['metal_content'];
				$oreopstk[$lrcnt10]['open_stock_metal_grade']=$record['grade'];
            }		
            if ((int)$record['rom_5_step_sn']==11) { 
				$lrcnt11+=1;
				$orerecmine[$lrcnt11]['ore_rec_qty']=$record['tot_qty'];
				$orerecmine[$lrcnt11]['ore_rec_metal']=$record['metal_content'];
				$orerecmine[$lrcnt11]['ore_rec_metal_grade']=$record['grade'];
            }	
            if ((int)$record['rom_5_step_sn']==12) { 
				$lrcnt12+=1;
				$oretreatcp[$lrcnt12]['ore_treat_qty']=$record['tot_qty'];
				$oretreatcp[$lrcnt12]['ore_treat_metal']=$record['metal_content'];
				$oretreatcp[$lrcnt12]['ore_treat_metal_grade']=$record['grade'];
            }
            if ((int)$record['rom_5_step_sn']==13) { 
				$lrcnt13+=1;
				$concobtain[$lrcnt13]['concentrate_obtain_metal']=$record['metal_content'];
				$concobtain[$lrcnt13]['concentrate_obtain_qty']=$record['tot_qty'];
				$concobtain[$lrcnt13]['concentrate_obtain_metal_grade']=$record['grade'];
				$concobtain[$lrcnt13]['concentrate_obtain_value']=$record['value'];
            }
            if ((int)$record['rom_5_step_sn']==14) { 
				$lrcnt14+=1;
				$trailing[$lrcnt14]['tail_qty']=$record['tot_qty'];
				$trailing[$lrcnt14]['tail_metal']=$record['metal_content'];
				$trailing[$lrcnt14]['tail_metal_grade']=$record['grade'];
            }
            if ((int)$record['rom_5_step_sn']==15) { 
				$lrcnt15+=1;
				$clstkcpnt[$lrcnt15]['clos_stock_metal']=$record['metal_content'];
				$clstkcpnt[$lrcnt15]['clos_stock_qty']=$record['tot_qty'];
				$clstkcpnt[$lrcnt15]['clos_stock_metal_grade']=$record['grade'];

            }
			
			
        }
		if ($lcnt >=0) {
			$larcount=count($oreopstk);
			if (count($orerecmine) >$larcount) $larcount=count($orerecmine);
			if (count($oretreatcp) >$larcount) $larcount=count($oretreatcp);
			if (count($concobtain) >$larcount) $larcount=count($concobtain);
			if (count($trailing)   >$larcount) $larcount=count($trailing);
			if (count($clstkcpnt)  >$larcount) $larcount=count($clstkcpnt);
			if (count($opstkspnt)  >$larcount) $larcount=count($opstkspnt);
			if (count($cntrecpnt)  >$larcount) $larcount=count($cntrecpnt);
			if (count($cntrecoth)  >$larcount) $larcount=count($cntrecoth);
			if (count($cntsold)    >$larcount) $larcount=count($cntsold);
			if (count($cnttreat)   >$larcount) $larcount=count($cnttreat);
			if (count($clstkspnt)  >$larcount) $larcount=count($clstkspnt);
			if (count($metlrecvd)  >$larcount) $larcount=count($metlrecvd);
			if (count($othprodrec) >$larcount) $larcount=count($othprodrec);
			$lrowspan="";
			if ($larcount>1) 
				$lrowspan=" rowspan=".$larcount."";
		$lcounter+=1;
		$print.='<tr>
			<td '.$lrowspan.'>'.$lcounter.'</td>
			<td '.$lrowspan.'>'.$record['year1'].'</td>	
			<td '.$lrowspan.'>'.$mineral_name.'</td>
			<td '.$lrowspan.'>'.$state_name.'</td>
			<td '.$lrowspan.'>'.$district_name.'</td>												
			<td '.$lrowspan.'>'.$MINE_NAME.'</td>
			<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
			<td '.$lrowspan.'>'.$lease_area.'</td>
			<td '.$lrowspan.'>'.$mine_code.'</td>
			<td '.$lrowspan.'>'.$registration_no.'</td>';
			for ($cnt=0;$cnt < $larcount; $cnt++) {
				if ($cnt > 0) $print.='</tr><tr>';
				//10 starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($oreopstk[$cnt]['open_stock_qty']))
						$print.=$oreopstk[$cnt]['open_stock_qty'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($oreopstk[$cnt]['open_stock_metal']))
					$print.=$oreopstk[$cnt]['open_stock_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($oreopstk[$cnt]['open_stock_metal_grade']))
					$print.=$oreopstk[$cnt]['open_stock_metal_grade'];
				$print.="</td>";
				//10 ends
				//11 starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($orerecmine[$cnt]['ore_rec_qty']))
						$print.=$orerecmine[$cnt]['ore_rec_qty'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($orerecmine[$cnt]['ore_rec_metal']))
					$print.=$orerecmine[$cnt]['ore_rec_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($orerecmine[$cnt]['ore_rec_metal_grade']))
					$print.=$orerecmine[$cnt]['ore_rec_metal_grade'];
				$print.="</td>";
				//11 ends
				//12 starts	 				
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($oretreatcp[$cnt]['ore_treat_qty']))
						$print.=$oretreatcp[$cnt]['ore_treat_qty'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($oretreatcp[$cnt]['ore_treat_metal']))
					$print.=$oretreatcp[$cnt]['ore_treat_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($oretreatcp[$cnt]['ore_treat_metal_grade']))
					$print.=$oretreatcp[$cnt]['ore_treat_metal_grade'];
				$print.="</td>";
				//12 end

				//13 start
				$print.="<td>";
				if (isset($concobtain[$cnt]['concentrate_obtain_metal']))
					$print.=$concobtain[$cnt]['concentrate_obtain_metal'];
				$print.="</td>";
		
				$print.="<td>";
				if (isset($concobtain[$cnt]['concentrate_obtain_qty']))
					$print.=$concobtain[$cnt]['concentrate_obtain_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($concobtain[$cnt]['concentrate_obtain_metal_grade']))
					$print.=$concobtain[$cnt]['concentrate_obtain_metal_grade'];
				$print.="</td>";
				$print.="<td>";
				if (isset($concobtain[$cnt]['concentrate_obtain_value']))
					$print.=$concobtain[$cnt]['concentrate_obtain_value'];
				$print.="</td>";
				//13 end
				//14 start
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";

					if (isset($trailing[$cnt]['tail_qty']))
						$print.=$trailing[$cnt]['tail_qty'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($trailing[$cnt]['tail_metal']))
					$print.=$trailing[$cnt]['tail_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($trailing[$cnt]['tail_metal_grade']))
					$print.=$trailing[$cnt]['tail_metal_grade'];
				$print.="</td>";
				//14 end
				//15 start
				$print.="<td>";
				if (isset($clstkcpnt[$cnt]['clos_stock_qty']))
					$print.=$clstkcpnt[$cnt]['clos_stock_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($clstkcpnt[$cnt]['clos_stock_metal']))
					$print.=$clstkcpnt[$cnt]['clos_stock_metal'];
				$print.="</td>";
			
				$print.="<td>";
				if (isset($clstkcpnt[$cnt]['clos_stock_metal_grade']))
					$print.=$clstkcpnt[$cnt]['clos_stock_metal_grade'];
				$print.="</td>";
				//15 end
				//1 start
				$print.="<td>";
				if (isset($opstkspnt[$cnt]['qyt_open_smelter_metal']))
					$print.=$opstkspnt[$cnt]['qyt_open_smelter_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($opstkspnt[$cnt]['qyt_open_smelter']))
					$print.=$opstkspnt[$cnt]['qyt_open_smelter'];
				$print.="</td>";
				$print.="<td>";
				if (isset($opstkspnt[$cnt]['metal_open_smelter']))
					$print.=$opstkspnt[$cnt]['metal_open_smelter'];
				$print.="</td>";
				//1 end
				//2 start
				$print.="<td>";
				if (isset($cntrecpnt[$cnt]['concentrate_rec_qty']))
					$print.=$cntrecpnt[$cnt]['concentrate_rec_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($cntrecpnt[$cnt]['concentrate_rec_metal']))
					$print.=$cntrecpnt[$cnt]['concentrate_rec_metal'];
				$print.="</td>";
				//2 end
				//3 start
				$print.="<td>";
				if (isset($cntrecoth[$cnt]['concentrate_other_src_qty']))
					$print.=$cntrecoth[$cnt]['concentrate_other_src_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($cntrecoth[$cnt]['concentrate_other_src_grade']))
					$print.=$cntrecoth[$cnt]['concentrate_other_src_grade'];
				$print.="</td>";
				//3 end
				//4 start
				$print.="<td>";
				if (isset($cntsold[$cnt]['concentrate_sold_qty']))
					$print.=$cntsold[$cnt]['concentrate_sold_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($cntsold[$cnt]['concentrate_sold_metal']))
					$print.=$cntsold[$cnt]['concentrate_sold_metal'];
				$print.="</td>";
				//4 end
				//5 start
				$print.="<td>";
				if (isset($cnttreat[$cnt]['concentrate_treat_qty']))
					$print.=$cnttreat[$cnt]['concentrate_treat_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($cnttreat[$cnt]['concentrate_treat_metal']))
					$print.=$cnttreat[$cnt]['concentrate_treat_metal'];
				$print.="</td>";
				//5 end
				//8 start
				$print.="<td>";
				if (isset($clstkspnt[$cnt]['qyt_close_smelter']))
					$print.=$clstkspnt[$cnt]['qyt_close_smelter'];
				$print.="</td>";
				$print.="<td>";
				if (isset($clstkspnt[$cnt]['metal_close_smelter']))
					$print.=$clstkspnt[$cnt]['metal_close_smelter'];
				$print.="</td>";
				//8 end
				//6 start
				$print.="<td>";
				if (isset($metlrecvd[$cnt]['metal_recover_qty_metal']))
					$print.=$metlrecvd[$cnt]['metal_recover_qty_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($metlrecvd[$cnt]['metal_recover_qty']))
					$print.=$metlrecvd[$cnt]['metal_recover_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($metlrecvd[$cnt]['metal_recover_grade']))
					$print.=$metlrecvd[$cnt]['metal_recover_grade'];
				$print.="</td>";
				$print.="<td>";
				if (isset($metlrecvd[$cnt]['metal_recover_value']))
					$print.=$metlrecvd[$cnt]['metal_recover_value'];
				$print.="</td>";
				//6 end
				//7 start
				$print.="<td>";
				if (isset($othprodrec[$cnt]['other_prod_grade_metal']))
					$print.=$othprodrec[$cnt]['other_prod_grade_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($othprodrec[$cnt]['other_prod_qty']))
					$print.=$othprodrec[$cnt]['other_prod_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($othprodrec[$cnt]['other_prod_grade']))
					$print.=$othprodrec[$cnt]['other_prod_grade'];
				$print.="</td>";
				$print.="<td>";
				if (isset($othprodrec[$cnt]['other_prod_value']))
					$print.=$othprodrec[$cnt]['other_prod_value'];
				$print.="</td>";
				//7 end

			}
			if ($cnt >0) $print.='</tr>';
		}

        $print.='</tbody>
        </table>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
		</div>';
		} else {
			$print='<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<h4 class="tHeadFont" id="heading1">Report A04 - Mine to Smelter Details (Ore to Metal)</h4>
						<div class="form-horizontal">
							<div class="card-body" id="avb">
								<h6 class="tHeadDate"  id="heading2">Year : '.$showDate.'</h6>
								<div class="table-responsive">
								
									<h6 class="tHeadDate" id="heading2"><strong>Since records are more hence no search & pagination service is available, you may use the option "Export to Excel"</strong></h6>
									<input type="button" id="downloadExcel" value="Export to Excel">
									<br /><br />
									
									<table class="table table-striped table-hover table-bordered compact" border="1" id="noDatatable">
										<thead class="tableHead">
											<tr>
												<th colspan="50" class="noDisplay" align="left">Report A04 - Mine to Smelter Details (Ore to Metal)  Year : '.$showDate.'</th>
											</tr>
											<tr>
												<th rowspan="2">#</th>
												<th rowspan="2">Year</th>
												<th rowspan="2">Mineral</th>
												<th rowspan="2">State</th>
												<th rowspan="2">District</th>
												<th rowspan="2">Name of Mine</th>
												<th rowspan="2">Name of Lease Owner</th>
												<th rowspan="2">Lease Area</th>
												<th rowspan="2">Mine Code</th>
												<th rowspan="2">IBM Registration Number</th>
												<th colspan="3"> Opening Stock of the Ore at concentrator/plant</th>
												<th colspan="3">Ore received from the Mine</th>
												<th colspan="3">Ore treated at concentrator plant</th>
												<th colspan="4">Concentrates Obtained</th>
												<th colspan="3">Tailing</th>
												<th colspan="3">Closing Stock of Concentrate at Concentrator/Plant</th>
												<th colspan="3">Opening Stock of Concentrates at Smelter/Plant</th>
												<th colspan="2">Concentrates Received from Concentrator/plant</th>
												<th colspan="2">Concentrates Received from other sources(specify)</th>
												<th colspan="2">Concentrates Sold (if any)</th>
												<th colspan="2">Concentrates Treated</th>
												<th colspan="2">Closing Stock of Concentrate at the smelter/plant</th>
												<th colspan="4">Metal Recoverd (specify)</th>
												<th colspan="4">Other by Products if any recovered</th>
											</tr>
											<tr>
												<th>Quantity(tonnes)</th>
												<th colspan="2">Metal Content/Grade</th>
												<th>Quantity(tonnes)</th>
												<th colspan="2">Metal Content / Grade</th>
												<th>Quantity(tonnes)</th>
												<th colspan="2">Metal Content / Grade</th>
												<th>Quantity(tonnes)</th>
												<th colspan="2">Metal Content / Grade</th>
												<th>Value</th>
												<th>Quantity(tonnes)</th>
												<th colspan="2">Metal Content / Grade</th>
												<th>Quantity(tonnes)</th>
												<th colspan="2">Metal Content / Grade</th>
												<th>Metal</th>
												<th>Quantity(tonnes)</th>
												<th>Metal Content/Grade</th>
												<th>Quantity(tonnes)</th>
												<th>Metal Content/Grade</th>
												<th>Quantity(tonnes)</th>
												<th>Metal Content/Grade</th>
												<th>Quantity(tonnes)</th>
												<th>Metal Content/Grade</th>
												<th>Quantity(tonnes)</th>
												<th>Metal Content/Grade</th>
												<th>Quantity(tonnes)</th>
												<th>Metal Content/Grade</th>
												<th>Metal</th>
												<th>Quantity(tonnes)</th>
												<th>Grade</th>
												<th> Value(Rs)</th>
												<th>Metal</th>
												<th>Quantity(tonnes)</th>
												<th>Grade</th>
												<th> Value(Rs)</th>
											</tr>

										</thead>
										<tbody class="tableBody">';
        foreach ($records as $record) {
            
            if ($lmineral_name != $record['mineral_name']) {
                $lmineral_name = $record['mineral_name'];
                $lflg="Y";
            }
            if ($lstate_name != $record['state_name']) {
                $lstate_name = $record['state_name'];
                $lflg="Y";
            }
            if ($ldistrict_name != $record['district_name']) {
                $ldistrict_name = $record['district_name'];
                $lflg="Y";
            }
            if ($lmonthnm != $record['showMonth']) {
                $lmonthnm  = $record['showMonth'];
                $lflg="Y";
            }
            if ($lyearnm != $record['showYear']) {
                $lyearnm  = $record['showYear'];
                $lflg="Y";
            }
            if ($lmincode!=$record['mine_code']) {
                $lmincode=$record['mine_code'];
                $lflg="Y";
            }


            if ($lflg=="Y" || $lcnt <0) {
                if ($lcnt >=0) {
					$larcount=count($oreopstk);
					if (count($orerecmine) >$larcount) $larcount=count($orerecmine);
					if (count($oretreatcp) >$larcount) $larcount=count($oretreatcp);
					if (count($concobtain) >$larcount) $larcount=count($concobtain);
					if (count($trailing)   >$larcount) $larcount=count($trailing);
					if (count($clstkcpnt)  >$larcount) $larcount=count($clstkcpnt);
					if (count($opstkspnt)  >$larcount) $larcount=count($opstkspnt);
					if (count($cntrecpnt)  >$larcount) $larcount=count($cntrecpnt);
					if (count($cntrecoth)  >$larcount) $larcount=count($cntrecoth);
					if (count($cntsold)    >$larcount) $larcount=count($cntsold);
					if (count($cnttreat)   >$larcount) $larcount=count($cnttreat);
					if (count($clstkspnt)  >$larcount) $larcount=count($clstkspnt);
					if (count($metlrecvd)  >$larcount) $larcount=count($metlrecvd);
					if (count($othprodrec) >$larcount) $larcount=count($othprodrec);
					$lrowspan="";
					if ($larcount>1) 
						$lrowspan=" rowspan=".$larcount."";
				$lcounter+=1;					
				$print.='<tr>
					<td '.$lrowspan.'>'.$lcounter.'</td>
					<td '.$lrowspan.'>'.$record['year1'].'</td>	
					<td '.$lrowspan.'>'.$mineral_name.'</td>
					<td '.$lrowspan.'>'.$state_name.'</td>
					<td '.$lrowspan.'>'.$district_name.'</td>												
					<td '.$lrowspan.'>'.$MINE_NAME.'</td>
					<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
					<td '.$lrowspan.'>'.$lease_area.'</td>
					<td '.$lrowspan.'>'.$mine_code.'</td>
					<td '.$lrowspan.'>'.$registration_no.'</td>';
					for ($cnt=0;$cnt < $larcount; $cnt++) {
						if ($cnt > 0) $print.='</tr><tr>';
						//10 starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($oreopstk[$cnt]['open_stock_qty']))
								$print.=$oreopstk[$cnt]['open_stock_qty'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($oreopstk[$cnt]['open_stock_metal']))
							$print.=$oreopstk[$cnt]['open_stock_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($oreopstk[$cnt]['open_stock_metal_grade']))
							$print.=$oreopstk[$cnt]['open_stock_metal_grade'];
						$print.="</td>";
						//10 ends
						//11 starts
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($orerecmine[$cnt]['ore_rec_qty']))
								$print.=$orerecmine[$cnt]['ore_rec_qty'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($orerecmine[$cnt]['ore_rec_metal']))
							$print.=$orerecmine[$cnt]['ore_rec_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($orerecmine[$cnt]['ore_rec_metal_grade']))
							$print.=$orerecmine[$cnt]['ore_rec_metal_grade'];
						$print.="</td>";
						//11 ends
						//12 starts					
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";
							if (isset($oretreatcp[$cnt]['ore_treat_qty']))
								$print.=$oretreatcp[$cnt]['ore_treat_qty'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($oretreatcp[$cnt]['ore_treat_metal']))
							$print.=$oretreatcp[$cnt]['ore_treat_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($oretreatcp[$cnt]['ore_treat_metal_grade']))
							$print.=$oretreatcp[$cnt]['ore_treat_metal_grade'];
						$print.="</td>";
						//12 end

						//13 start
						$print.="<td>";
						if (isset($concobtain[$cnt]['concentrate_obtain_metal']))
							$print.=$concobtain[$cnt]['concentrate_obtain_metal'];
						$print.="</td>";
				
						$print.="<td>";
						if (isset($concobtain[$cnt]['concentrate_obtain_qty']))
							$print.=$concobtain[$cnt]['concentrate_obtain_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($concobtain[$cnt]['concentrate_obtain_metal_grade']))
							$print.=$concobtain[$cnt]['concentrate_obtain_metal_grade'];
						$print.="</td>";
						$print.="<td>";
						if (isset($concobtain[$cnt]['concentrate_obtain_value']))
							$print.=$concobtain[$cnt]['concentrate_obtain_value'];
						$print.="</td>";
						//13 end
						//14 start
						if ($cnt <=0) {
							$print.="<td ".$lrowspan.">";

							if (isset($trailing[$cnt]['tail_qty']))
								$print.=$trailing[$cnt]['tail_qty'];
							$print.="</td>";
						}
						$print.="<td>";
						if (isset($trailing[$cnt]['tail_metal']))
							$print.=$trailing[$cnt]['tail_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($trailing[$cnt]['tail_metal_grade']))
							$print.=$trailing[$cnt]['tail_metal_grade'];
						$print.="</td>";
						//14 end
						//15 start
						$print.="<td>";
						if (isset($clstkcpnt[$cnt]['clos_stock_qty']))
							$print.=$clstkcpnt[$cnt]['clos_stock_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($clstkcpnt[$cnt]['clos_stock_metal']))
							$print.=$clstkcpnt[$cnt]['clos_stock_metal'];
						$print.="</td>";						
						$print.="<td>";
						if (isset($clstkcpnt[$cnt]['clos_stock_metal_grade']))
							$print.=$clstkcpnt[$cnt]['clos_stock_metal_grade'];
						$print.="</td>";
						//15 end
						//1 start
						$print.="<td>";
						if (isset($opstkspnt[$cnt]['qyt_open_smelter_metal']))
							$print.=$opstkspnt[$cnt]['qyt_open_smelter_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($opstkspnt[$cnt]['qyt_open_smelter']))
							$print.=$opstkspnt[$cnt]['qyt_open_smelter'];
						$print.="</td>";
						$print.="<td>";
						if (isset($opstkspnt[$cnt]['metal_open_smelter']))
							$print.=$opstkspnt[$cnt]['metal_open_smelter'];
						$print.="</td>";
						//1 end
						//2 start
						$print.="<td>";
						if (isset($cntrecpnt[$cnt]['concentrate_rec_qty']))
							$print.=$cntrecpnt[$cnt]['concentrate_rec_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($cntrecpnt[$cnt]['concentrate_rec_metal']))
							$print.=$cntrecpnt[$cnt]['concentrate_rec_metal'];
						$print.="</td>";
						//2 end
						//3 start
						$print.="<td>";
						if (isset($cntrecoth[$cnt]['concentrate_other_src_qty']))
							$print.=$cntrecoth[$cnt]['concentrate_other_src_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($cntrecoth[$cnt]['concentrate_other_src_grade']))
							$print.=$cntrecoth[$cnt]['concentrate_other_src_grade'];
						$print.="</td>";
						//3 end
						//4 start
						$print.="<td>";
						if (isset($cntsold[$cnt]['concentrate_sold_qty']))
							$print.=$cntsold[$cnt]['concentrate_sold_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($cntsold[$cnt]['concentrate_sold_metal']))
							$print.=$cntsold[$cnt]['concentrate_sold_metal'];
						$print.="</td>";
						//4 end
						//5 start
						$print.="<td>";
						if (isset($cnttreat[$cnt]['concentrate_treat_qty']))
							$print.=$cnttreat[$cnt]['concentrate_treat_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($cnttreat[$cnt]['concentrate_treat_metal']))
							$print.=$cnttreat[$cnt]['concentrate_treat_metal'];
						$print.="</td>";
						//5 end
						//8 start
						$print.="<td>";
						if (isset($clstkspnt[$cnt]['qyt_close_smelter']))
							$print.=$clstkspnt[$cnt]['qyt_close_smelter'];
						$print.="</td>";
						$print.="<td>";
						if (isset($clstkspnt[$cnt]['metal_close_smelter']))
							$print.=$clstkspnt[$cnt]['metal_close_smelter'];
						$print.="</td>";
						//8 end
						//6 start
						$print.="<td>";
						if (isset($metlrecvd[$cnt]['metal_recover_qty_metal']))
							$print.=$metlrecvd[$cnt]['metal_recover_qty_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($metlrecvd[$cnt]['metal_recover_qty']))
							$print.=$metlrecvd[$cnt]['metal_recover_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($metlrecvd[$cnt]['metal_recover_grade']))
							$print.=$metlrecvd[$cnt]['metal_recover_grade'];
						$print.="</td>";
						$print.="<td>";
						if (isset($metlrecvd[$cnt]['metal_recover_value']))
							$print.=$metlrecvd[$cnt]['metal_recover_value'];
						$print.="</td>";
						//6 end
						//7 start
						$print.="<td>";
						if (isset($othprodrec[$cnt]['other_prod_grade_metal']))
							$print.=$othprodrec[$cnt]['other_prod_grade_metal'];
						$print.="</td>";
						$print.="<td>";
						if (isset($othprodrec[$cnt]['other_prod_qty']))
							$print.=$othprodrec[$cnt]['other_prod_qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($othprodrec[$cnt]['other_prod_grade']))
							$print.=$othprodrec[$cnt]['other_prod_grade'];
						$print.="</td>";
						$print.="<td>";
						if (isset($othprodrec[$cnt]['other_prod_value']))
							$print.=$othprodrec[$cnt]['other_prod_value'];
						$print.="</td>";
						//7 end

					}
					if ($cnt >0) $print.='</tr>';
                }
                $lcnt++;
                $lflg="";
                $cnt=0;
				
                $mineral_name=ucwords(str_replace('_', ' ', $record['mineral_name']));
                $state_name=$record['state_name']; 
                $district_name=$record['district_name']; 
                $MINE_NAME=$record['MINE_NAME'] ;
                $lessee_owner_name=$record['lessee_owner_name'];
                $lease_area=$record['lease_area'];
                $mine_code=$record['mine_code'];
                $registration_no=$record['registration_no']; 
				$oreopstk=array();		//Opening Stock of the Ore at concentrator/plant
				$orerecmine=array();		//Ore received from the Mine
				$oretreatcp=array();		//Ore treated at concentrator plant
				$concobtain=array();		//Concentrates Obtained
				$trailing=array();		//Tailing
				$clstkcpnt=array();		//Closing Stock of Concentrate at Concentrator/Plant
				$opstkspnt=array();		//Opening Stock of Concentrates at Smelter/Plant
				$cntrecpnt=array();		//Concentrates Received from Concentrator/plant
				$cntrecoth=array();		//Concentrates Received from other sources(specify)
				$cntsold=array();		//Concentrates Sold (if any)
				$cnttreat=array();		//Concentrates Treated
				$clstkspnt=array();		//Closing Stock of Concentrate at the smelter/plant
				$metlrecvd=array();		//Metal Recoverd (specify)
				$othprodrec=array();		//Other by Products if any recovered				
				$lrcnt1=-1;
				$lrcnt2=-1;
				$lrcnt3=-1;
				$lrcnt4=-1;
				$lrcnt5=-1;

				$lrcnt6=-1;
				$lrcnt7=-1;
				$lrcnt8=-1;
				$lrcnt10=-1;
				$lrcnt11=-1;
				$lrcnt12=-1;
				$lrcnt13=-1;
				$lrcnt14=-1;
				$lrcnt15=-1;

            }
            if ((int)$record['rom_5_step_sn']==1) { 
				$lrcnt1+=1;
				$opstkspnt[$lrcnt1]['qyt_open_smelter']=$record['tot_qty'];
				$opstkspnt[$lrcnt1]['metal_open_smelter']=$record['grade'];
				$opstkspnt[$lrcnt1]['qyt_open_smelter_metal']=$record['metal_content'];
            }
            if ((int)$record['rom_5_step_sn']==2) { 
				$lrcnt2+=1;
				$cntrecpnt[$lrcnt2]['concentrate_rec_qty']=$record['tot_qty'];
				$cntrecpnt[$lrcnt2]['concentrate_rec_metal']=$record['grade'];
            }          
            if ((int)$record['rom_5_step_sn']==3) { 
				$lrcnt3+=1;
				$cntrecoth[$lrcnt3]['concentrate_other_src_qty']=$record['tot_qty'];
				$cntrecoth[$lrcnt3]['concentrate_other_src_grade']=$record['grade'];
            }
            if ((int)$record['rom_5_step_sn']==4) { 
				$lrcnt4+=1;
				$cntsold[$lrcnt4]['concentrate_sold_qty']=$record['tot_qty'];
				$cntsold[$lrcnt4]['concentrate_sold_metal']=$record['grade'];

            }
            if ((int)$record['rom_5_step_sn']==5) { 
				$lrcnt5+=1;
				$cnttreat[$lrcnt5]['concentrate_treat_qty']=$record['tot_qty'];
				$cnttreat[$lrcnt5]['concentrate_treat_metal']=$record['grade'];
            }
            if ((int)$record['rom_5_step_sn']==6) { 
				$lrcnt6+=1;
				$metlrecvd[$lrcnt6]['metal_recover_qty_metal']=$record['metal_content'];
				$metlrecvd[$lrcnt6]['metal_recover_qty']=$record['tot_qty'];
				$metlrecvd[$lrcnt6]['metal_recover_grade']=$record['grade'];
				$metlrecvd[$lrcnt6]['metal_recover_value']=$record['value'];
            }	
            if ((int)$record['rom_5_step_sn']==7) { 
				$lrcnt7+=1;
				$othprodrec[$lrcnt7]['other_prod_grade_metal']=$record['metal_content'];
				$othprodrec[$lrcnt7]['other_prod_qty']=$record['tot_qty'];
				$othprodrec[$lrcnt7]['other_prod_grade']=$record['grade'];
				$othprodrec[$lrcnt7]['other_prod_value']=$record['value'];
            }
            if ((int)$record['rom_5_step_sn']==8) { 
				$lrcnt8+=1;
				$clstkspnt[$lrcnt8]['qyt_close_smelter']=$record['tot_qty'];
				//as discussed dated on 12-04-22 use value column instead of grade
				//$clstkspnt[$lrcnt8]['metal_close_smelter']=$record['grade'];
				$clstkspnt[$lrcnt8]['metal_close_smelter']=$record['value'];

            }
            if ((int)$record['rom_5_step_sn']==10) { 
				$lrcnt10+=1;
				$oreopstk[$lrcnt10]['open_stock_qty']=$record['tot_qty'];
				$oreopstk[$lrcnt10]['open_stock_metal']=$record['metal_content'];
				$oreopstk[$lrcnt10]['open_stock_metal_grade']=$record['grade'];
            }		
            if ((int)$record['rom_5_step_sn']==11) { 
				$lrcnt11+=1;
				$orerecmine[$lrcnt11]['ore_rec_qty']=$record['tot_qty'];
				$orerecmine[$lrcnt11]['ore_rec_metal']=$record['metal_content'];
				$orerecmine[$lrcnt11]['ore_rec_metal_grade']=$record['grade'];
            }	
            if ((int)$record['rom_5_step_sn']==12) { 
				$lrcnt12+=1;
				$oretreatcp[$lrcnt12]['ore_treat_qty']=$record['tot_qty'];
				$oretreatcp[$lrcnt12]['ore_treat_metal']=$record['metal_content'];
				$oretreatcp[$lrcnt12]['ore_treat_metal_grade']=$record['grade'];
            }
            if ((int)$record['rom_5_step_sn']==13) { 
				$lrcnt13+=1;
				$concobtain[$lrcnt13]['concentrate_obtain_metal']=$record['metal_content'];
				$concobtain[$lrcnt13]['concentrate_obtain_qty']=$record['tot_qty'];
				$concobtain[$lrcnt13]['concentrate_obtain_metal_grade']=$record['grade'];
				$concobtain[$lrcnt13]['concentrate_obtain_value']=$record['value'];
            }
            if ((int)$record['rom_5_step_sn']==14) { 
				$lrcnt14+=1;
				$trailing[$lrcnt14]['tail_qty']=$record['tot_qty'];
				$trailing[$lrcnt14]['tail_metal']=$record['metal_content'];
				$trailing[$lrcnt14]['tail_metal_grade']=$record['grade'];
            }
            if ((int)$record['rom_5_step_sn']==15) { 
				$lrcnt15+=1;
				$clstkcpnt[$lrcnt15]['clos_stock_metal']=$record['metal_content'];
				$clstkcpnt[$lrcnt15]['clos_stock_qty']=$record['tot_qty'];
				$clstkcpnt[$lrcnt15]['clos_stock_metal_grade']=$record['grade'];

            }
			
			
        }
		if ($lcnt >=0) {
			$larcount=count($oreopstk);
			if (count($orerecmine) >$larcount) $larcount=count($orerecmine);
			if (count($oretreatcp) >$larcount) $larcount=count($oretreatcp);
			if (count($concobtain) >$larcount) $larcount=count($concobtain);
			if (count($trailing)   >$larcount) $larcount=count($trailing);
			if (count($clstkcpnt)  >$larcount) $larcount=count($clstkcpnt);
			if (count($opstkspnt)  >$larcount) $larcount=count($opstkspnt);
			if (count($cntrecpnt)  >$larcount) $larcount=count($cntrecpnt);
			if (count($cntrecoth)  >$larcount) $larcount=count($cntrecoth);
			if (count($cntsold)    >$larcount) $larcount=count($cntsold);
			if (count($cnttreat)   >$larcount) $larcount=count($cnttreat);
			if (count($clstkspnt)  >$larcount) $larcount=count($clstkspnt);
			if (count($metlrecvd)  >$larcount) $larcount=count($metlrecvd);
			if (count($othprodrec) >$larcount) $larcount=count($othprodrec);
			$lrowspan="";
			if ($larcount>1) 
				$lrowspan=" rowspan=".$larcount."";
		$lcounter+=1;
		$print.='<tr>
			<td '.$lrowspan.'>'.$lcounter.'</td>
			<td '.$lrowspan.'>'.$record['year1'].'</td>	
			<td '.$lrowspan.'>'.$mineral_name.'</td>
			<td '.$lrowspan.'>'.$state_name.'</td>
			<td '.$lrowspan.'>'.$district_name.'</td>												
			<td '.$lrowspan.'>'.$MINE_NAME.'</td>
			<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
			<td '.$lrowspan.'>'.$lease_area.'</td>
			<td '.$lrowspan.'>'.$mine_code.'</td>
			<td '.$lrowspan.'>'.$registration_no.'</td>';
			for ($cnt=0;$cnt < $larcount; $cnt++) {
				if ($cnt > 0) $print.='</tr><tr>';
				//10 starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($oreopstk[$cnt]['open_stock_qty']))
						$print.=$oreopstk[$cnt]['open_stock_qty'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($oreopstk[$cnt]['open_stock_metal']))
					$print.=$oreopstk[$cnt]['open_stock_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($oreopstk[$cnt]['open_stock_metal_grade']))
					$print.=$oreopstk[$cnt]['open_stock_metal_grade'];
				$print.="</td>";
				//10 ends
				//11 starts
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($orerecmine[$cnt]['ore_rec_qty']))
						$print.=$orerecmine[$cnt]['ore_rec_qty'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($orerecmine[$cnt]['ore_rec_metal']))
					$print.=$orerecmine[$cnt]['ore_rec_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($orerecmine[$cnt]['ore_rec_metal_grade']))
					$print.=$orerecmine[$cnt]['ore_rec_metal_grade'];
				$print.="</td>";
				//11 ends
				//12 starts	 				
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";
					if (isset($oretreatcp[$cnt]['ore_treat_qty']))
						$print.=$oretreatcp[$cnt]['ore_treat_qty'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($oretreatcp[$cnt]['ore_treat_metal']))
					$print.=$oretreatcp[$cnt]['ore_treat_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($oretreatcp[$cnt]['ore_treat_metal_grade']))
					$print.=$oretreatcp[$cnt]['ore_treat_metal_grade'];
				$print.="</td>";
				//12 end

				//13 start
				$print.="<td>";
				if (isset($concobtain[$cnt]['concentrate_obtain_metal']))
					$print.=$concobtain[$cnt]['concentrate_obtain_metal'];
				$print.="</td>";
		
				$print.="<td>";
				if (isset($concobtain[$cnt]['concentrate_obtain_qty']))
					$print.=$concobtain[$cnt]['concentrate_obtain_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($concobtain[$cnt]['concentrate_obtain_metal_grade']))
					$print.=$concobtain[$cnt]['concentrate_obtain_metal_grade'];
				$print.="</td>";
				$print.="<td>";
				if (isset($concobtain[$cnt]['concentrate_obtain_value']))
					$print.=$concobtain[$cnt]['concentrate_obtain_value'];
				$print.="</td>";
				//13 end
				//14 start
				if ($cnt <=0) {
					$print.="<td ".$lrowspan.">";

					if (isset($trailing[$cnt]['tail_qty']))
						$print.=$trailing[$cnt]['tail_qty'];
					$print.="</td>";
				}
				$print.="<td>";
				if (isset($trailing[$cnt]['tail_metal']))
					$print.=$trailing[$cnt]['tail_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($trailing[$cnt]['tail_metal_grade']))
					$print.=$trailing[$cnt]['tail_metal_grade'];
				$print.="</td>";
				//14 end
				//15 start
				$print.="<td>";
				if (isset($clstkcpnt[$cnt]['clos_stock_qty']))
					$print.=$clstkcpnt[$cnt]['clos_stock_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($clstkcpnt[$cnt]['clos_stock_metal']))
					$print.=$clstkcpnt[$cnt]['clos_stock_metal'];
				$print.="</td>";
			
				$print.="<td>";
				if (isset($clstkcpnt[$cnt]['clos_stock_metal_grade']))
					$print.=$clstkcpnt[$cnt]['clos_stock_metal_grade'];
				$print.="</td>";
				//15 end
				//1 start
				$print.="<td>";
				if (isset($opstkspnt[$cnt]['qyt_open_smelter_metal']))
					$print.=$opstkspnt[$cnt]['qyt_open_smelter_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($opstkspnt[$cnt]['qyt_open_smelter']))
					$print.=$opstkspnt[$cnt]['qyt_open_smelter'];
				$print.="</td>";
				$print.="<td>";
				if (isset($opstkspnt[$cnt]['metal_open_smelter']))
					$print.=$opstkspnt[$cnt]['metal_open_smelter'];
				$print.="</td>";
				//1 end
				//2 start
				$print.="<td>";
				if (isset($cntrecpnt[$cnt]['concentrate_rec_qty']))
					$print.=$cntrecpnt[$cnt]['concentrate_rec_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($cntrecpnt[$cnt]['concentrate_rec_metal']))
					$print.=$cntrecpnt[$cnt]['concentrate_rec_metal'];
				$print.="</td>";
				//2 end
				//3 start
				$print.="<td>";
				if (isset($cntrecoth[$cnt]['concentrate_other_src_qty']))
					$print.=$cntrecoth[$cnt]['concentrate_other_src_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($cntrecoth[$cnt]['concentrate_other_src_grade']))
					$print.=$cntrecoth[$cnt]['concentrate_other_src_grade'];
				$print.="</td>";
				//3 end
				//4 start
				$print.="<td>";
				if (isset($cntsold[$cnt]['concentrate_sold_qty']))
					$print.=$cntsold[$cnt]['concentrate_sold_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($cntsold[$cnt]['concentrate_sold_metal']))
					$print.=$cntsold[$cnt]['concentrate_sold_metal'];
				$print.="</td>";
				//4 end
				//5 start
				$print.="<td>";
				if (isset($cnttreat[$cnt]['concentrate_treat_qty']))
					$print.=$cnttreat[$cnt]['concentrate_treat_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($cnttreat[$cnt]['concentrate_treat_metal']))
					$print.=$cnttreat[$cnt]['concentrate_treat_metal'];
				$print.="</td>";
				//5 end
				//8 start
				$print.="<td>";
				if (isset($clstkspnt[$cnt]['qyt_close_smelter']))
					$print.=$clstkspnt[$cnt]['qyt_close_smelter'];
				$print.="</td>";
				$print.="<td>";
				if (isset($clstkspnt[$cnt]['metal_close_smelter']))
					$print.=$clstkspnt[$cnt]['metal_close_smelter'];
				$print.="</td>";
				//8 end
				//6 start
				$print.="<td>";
				if (isset($metlrecvd[$cnt]['metal_recover_qty_metal']))
					$print.=$metlrecvd[$cnt]['metal_recover_qty_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($metlrecvd[$cnt]['metal_recover_qty']))
					$print.=$metlrecvd[$cnt]['metal_recover_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($metlrecvd[$cnt]['metal_recover_grade']))
					$print.=$metlrecvd[$cnt]['metal_recover_grade'];
				$print.="</td>";
				$print.="<td>";
				if (isset($metlrecvd[$cnt]['metal_recover_value']))
					$print.=$metlrecvd[$cnt]['metal_recover_value'];
				$print.="</td>";
				//6 end
				//7 start
				$print.="<td>";
				if (isset($othprodrec[$cnt]['other_prod_grade_metal']))
					$print.=$othprodrec[$cnt]['other_prod_grade_metal'];
				$print.="</td>";
				$print.="<td>";
				if (isset($othprodrec[$cnt]['other_prod_qty']))
					$print.=$othprodrec[$cnt]['other_prod_qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($othprodrec[$cnt]['other_prod_grade']))
					$print.=$othprodrec[$cnt]['other_prod_grade'];
				$print.="</td>";
				$print.="<td>";
				if (isset($othprodrec[$cnt]['other_prod_value']))
					$print.=$othprodrec[$cnt]['other_prod_value'];
				$print.="</td>";
				//7 end

			}
			if ($cnt >0) $print.='</tr>';
		}

        $print.='</tbody>
        </table>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
		</div>';
		}
		
        return $print;

	}

    /*public function reportA05()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower(str_replace(' ', '_', $mineral));
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            $sql = "SELECT DISTINCT gs.client_type, gs.client_name, gs.client_reg_no, gs.quantity, gs.sale_value, gs.expo_country, gs.expo_quantity,
            (ml.under_forest_area + ml.outside_forest_area) AS lease_area, gs.expo_fob, gs.mine_code, gs.mineral_name, m.MINE_NAME, m.lessee_owner_name,
            m.registration_no, dmg.grade_name, s.state_name, d.district_name, '$from_year' AS year1, $next_year AS year2, '$showDate' AS showDate
            FROM
                mine m
                    INNER JOIN
                dir_state s ON m.state_code = s.state_code
                    INNER JOIN
                dir_district d ON m.district_code = d.district_code
                    AND s.state_code = d.state_code
                    INNER JOIN
                grade_sale gs ON m.mine_code = gs.mine_code
                    AND gs.return_type = '$returnType'
                    AND gs.return_date = '$from_date'
                    LEFT JOIN
                mcp_lease ml ON m.mine_code = ml.mine_code
                    AND gs.mine_code = ml.mine_code
                    INNER JOIN
                dir_mineral_grade dmg ON gs.grade_code = dmg.grade_code
                    AND gs.mineral_name = REPLACE(LOWER(dmg.mineral_name), ' ', '_')
            WHERE
                gs.return_type = '$returnType' AND gs.return_date = '$from_date'";

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND gs.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND gs.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND (ml.under_forest_area + ml.outside_forest_area) = '$lesseearea'";
            }
            // pr($sql);exit;
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }*/
	
	public function reportA05()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower($mineral);
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            // Change in query & in table grade_sale & dir_mineral_grade tale added new column (new_grade_code) , In join comparing mineral_name of both table & new_grade_code of both table
            $sql = "SELECT DISTINCT gs.client_type, gs.client_name, gs.client_reg_no, gs.quantity, gs.sale_value, dc.country_name AS expo_country, gs.expo_quantity,
            ml.mcmdt_ML_Area AS lease_area, gs.expo_fob, gs.mine_code, gs.mineral_name, m.MINE_NAME,
            m.lessee_owner_name, m.registration_no, dmg.grade_name, s.state_name, d.district_name, '$from_year' AS year1, '$next_year' AS year2, '$showDate' AS showDate,
			m.type_working, m.mechanisation, m.mine_ownership,
			CASE
				WHEN `m`.`mine_category` = 1 THEN 'A'
				WHEN `m`.`mine_category` = 2 THEN 'B'
				ELSE `m`.`mine_category`
			END AS `mine_category`
            FROM
				tbl_final_submit tfs
					INNER JOIN
                mine m ON m.mine_code = tfs.mine_code
                    INNER JOIN
                dir_state s ON m.state_code = s.state_code
                    INNER JOIN
                dir_district d ON m.district_code = d.district_code
                    AND s.state_code = d.state_code
                    INNER JOIN
                grade_sale gs ON m.mine_code = gs.mine_code
                    AND gs.return_type = '$returnType'
                    AND gs.return_date = '$from_date' 				
					LEFT JOIN 
				dir_country dc ON gs.expo_country = dc.id
                    LEFT JOIN
                 mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1 
                    AND gs.mine_code = ml.mcmdt_mineCode
                     INNER JOIN
				dir_mineral_grade dmg ON gs.new_grade_code = dmg.new_grade_code
					AND gs.mineral_name = REPLACE(LOWER(dmg.mineral_name),
					'&',
					'and')
            WHERE
                gs.return_type = '$returnType' AND gs.return_date = '$from_date' AND tfs.is_latest = 1";

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND gs.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND gs.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
            // print_r($sql);exit;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    /*public function reportA06()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower(str_replace(' ', '_', $mineral));
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            $sql = "SELECT DISTINCT ss.mine_code, ss.mineral_name, m.MINE_NAME, m.lessee_owner_name, m.registration_no, (ml.under_forest_area + ml.outside_forest_area) AS lease_area,
            s.state_name, d.district_name, ss.metal_content, ss.qty, ss.grade, ss.place_of_sale, ss.product_value, '$from_year' AS year1, $next_year AS year2, '$showDate' AS showDate
            FROM
                mine m
                    INNER JOIN
                dir_state s ON m.state_code = s.state_code
                    INNER JOIN
                dir_district d ON m.district_code = d.district_code
                    AND d.state_code = s.state_code
                    INNER JOIN
                sale_5 ss ON m.mine_code = ss.mine_code
                    AND ss.return_type = '$returnType'
                    AND ss.return_date = '$from_date'
                    LEFT JOIN
                mcp_lease ml ON m.mine_code = ml.mine_code
                    AND ss.mine_code = ml.mine_code
            WHERE
                ss.return_type = '$returnType' AND ss.return_date = '$from_date'";

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND ss.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND ss.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND (ml.under_forest_area + ml.outside_forest_area) = '$lesseearea'";
            }
            // pr($sql);exit;
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }*/
	
	public function reportA06()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
           $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower($mineral);
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');           
                
                $sql = "SELECT m.MINE_NAME, m.lessee_owner_name, m.registration_no, ml.mcmdt_ML_Area AS lease_area, s.state_name,
                    d.district_name, s5.mine_code, s5.return_type, s5.return_date,  s5.mineral_name, '$from_year' AS year1, '$next_year' AS year2, '$showDate' AS showDate,
                    s5.sale_5_step_sn, s5.metal_content,
                    s5.qty, s5.grade, s5.place_of_sale, s5.product_value                 
                FROM
                  tbl_final_submit tfs
                      INNER JOIN
                  sale_5 s5 ON s5.mine_code = tfs.mine_code
                      AND s5.return_type = tfs.return_type
                      AND s5.return_date = tfs.return_date
                      INNER JOIN 
                   mine m on m.mine_code = tfs.mine_code
                       INNER JOIN
                  dir_state s ON m.state_code = s.state_code
                      INNER JOIN
                  dir_district d ON m.district_code = d.district_code
                      AND d.state_code = s.state_code
                      LEFT JOIN
                  mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1
                      WHERE 
                  s5.return_type = '$returnType' AND s5.return_date = '$from_date' AND tfs.is_latest = 1";

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND s5.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND s5.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
			$sql.=" order by  s5.mineral_name,s.state_name,d.district_name,s5.return_date,s5.mine_code,s5.metal_content";
             //print_r($sql);exit;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $lprint=$this->generatea06($records,$showDate,$rowCount);
                $this->set('lprint',$lprint);				

                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }
	public function generatea06($records,$showDate,$rowCount) {
        $lcnt=-1;
        $cnt=0;
        $lmineral_name = "";
        $lstate_name = "";
        $ldistrict_name = "";
        $lmonthnm = "";
        $lyearnm = "";
        $lmincode="";
		$lmetal_content="";
		$lserialno="";
        $lflg="";
		$lcounter=0;
		$marray=array();	//metal content
		$oarray=array();	//opening stock array
		$parray=array();	//Place of sale array
		$sarray=array();	//Sale array
		$carray=array();	//clossing stock array
		$lmcnt=-1;
		$locnt=-1;
		$lpcnt=-1;
		$lscnt=-1;
		$lccnt=-1;

		if($rowCount <= 15000) {
        $print="";
		$print='<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<h4 class="tHeadFont" id="heading1">Report A06 - Opening Stock, Sale of Metal/Product and Closing Stock </h4>
						<div class="form-horizontal">
							<div class="card-body" id="avb">
								<h6 class="tHeadDate"  id="heading2">Year : '.$showDate.'</h6>
								<div class="table-responsive">
									<table class="table table-striped table-hover table-bordered compact" id="tableReport">
										<thead class="tableHead">
											<tr>
												<th rowspan="2">#</th>
												<th rowspan="2">Year</th>  
												<th rowspan="2">Mineral</th>
												<th rowspan="2">State</th>
												<th rowspan="2">District</th>  
												<th rowspan="2">Name of Mine</th>
												<th rowspan="2">Name of Lease Owner</th>
												<th rowspan="2">Lease Area</th>
												<th rowspan="2">Mine Code</th>
												<th rowspan="2">IBM Registration Number</th>
												<th rowspan="2">Metal/Product</th>
												<th colspan="2">Opening Stock</th>
												<th rowspan="2">Place of Sale</th>
												<th colspan="3">Metals/Products Sold</th>
												<th colspan="2">Closing Stock of Metals/Products</th>
											</tr>
											<tr>
												<th>Quantity(tonnes)</th>
												<th>Grade</th>
												<th>Quantity(tonnes) </th>
												<th>Grade</th>
												<th>Value</th>
												<th>Quantity(tonnes)</th>
												<th>Grade</th>
											</tr>
										</thead>
										<tbody class="tableBody">';
        foreach ($records as $record) {
            if ($lmineral_name != $record['mineral_name']) {
                $lmineral_name = $record['mineral_name'];
                $lflg="Y";
            }
            if ($lstate_name != $record['state_name']) {
                $lstate_name = $record['state_name'];
                $lflg="Y";
            }
            if ($ldistrict_name != $record['district_name']) {
                $ldistrict_name = $record['district_name'];
                $lflg="Y";
            }
            if ($lmonthnm != $record['showMonth']) {
                $lmonthnm  = $record['showMonth'];
                $lflg="Y";
            }
            if ($lyearnm != $record['showYear']) {
                $lyearnm  = $record['showYear'];
                $lflg="Y";
            }
            if ($lmincode!=$record['mine_code']) {
                $lmincode=$record['mine_code'];
                $lflg="Y";
            }

            if ($lflg=="Y" || $lcnt <0) {
				if ($lcnt>=0) {
					$larcount=count($oarray);
					if (count($parray)>$larcount) $larcount=count($parray);
					if (count($sarray)>$larcount) $larcount=count($sarray);
					if (count($carray)>$larcount) $larcount=count($carray);
					$lrowspan="";

					for ($cnt=0; $cnt < $larcount; $cnt++) {					
						$lcounter+=1;
						$print.='<tr>
							<td '.$lrowspan.'>'.$lcounter.'</td>
							<td '.$lrowspan.'>'.$record['year1'].'</td>	
							<td '.$lrowspan.'>'.$mineral_name.'</td>
							<td '.$lrowspan.'>'.$state_name.'</td>
							<td '.$lrowspan.'>'.$district_name.'</td>
							<td '.$lrowspan.'>'.$MINE_NAME.'</td>
							<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
							<td '.$lrowspan.'>'.$lease_area.'</td>
							<td '.$lrowspan.'>'.$mine_code.'</td>
							<td '.$lrowspan.'>'.$registration_no.'</td>';

						//if ($cnt >0) 
						//	$print.='<tr>';
						$print.="<td>";
						if (isset($marray[$cnt]['cont']))
							$print.=$marray[$cnt]['cont'];
						$print.="</td>";						
						//1 start
						$print.="<td>";
						if (isset($oarray[$cnt]['qty']))
							$print.=$oarray[$cnt]['qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($oarray[$cnt]['grade']))
							$print.=$oarray[$cnt]['grade'];
						$print.="</td>";
						//1 end
						//2 start
						$print.="<td>";
						if (isset($parray[$cnt]['psale']))
							$print.=$parray[$cnt]['psale'];
						$print.="</td>";
						//2 end
						//3 start
						$print.="<td>";
						if (isset($sarray[$cnt]['qty']))
							$print.=$sarray[$cnt]['qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($sarray[$cnt]['grade']))
							$print.=$sarray[$cnt]['grade'];
						$print.="</td>";
						$print.="<td>";
						if (isset($sarray[$cnt]['value']))
							$print.=$sarray[$cnt]['value'];
						$print.="</td>";

						//3 end
						//4 start
						$print.="<td>";
						if (isset($carray[$cnt]['qty']))
							$print.=$carray[$cnt]['qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($carray[$cnt]['grade']))
							$print.=$carray[$cnt]['grade'];
						$print.="</td>";
						//4 end
						$print.='</tr>';
					}						
				}
                $lcnt++;
                $lflg="";
                $cnt=0;
				
                $mineral_name=ucwords(str_replace('_', ' ', $record['mineral_name']));
                $state_name=$record['state_name']; 
                $district_name=$record['district_name']; 
                $MINE_NAME=$record['MINE_NAME'] ;
                $lessee_owner_name=$record['lessee_owner_name'];
                $lease_area=$record['lease_area'];
                $mine_code=$record['mine_code'];
                $registration_no=$record['registration_no'];
				$lmetal_content=$record['metal_content'];
				$marray=array();	//metal content
				$oarray=array();	//opening stock array
				$parray=array();	//Place of sale array
				$sarray=array();	//Sale array
				$carray=array();	//clossing stock array
				$lmcnt=-1;
				$locnt=-1;
				$lpcnt=-1;
				$lscnt=-1;
				$lccnt=-1;

			}
            if ($lmetal_content!=$record['metal_content'] || $lmcnt <0) {
				$lmcnt+=1;
				$marray[$lmcnt]['cont']=$record['metal_content'];  
				$lmetal_content=$record['metal_content'];
            } 

			if ($record['sale_5_step_sn']==1) {
				$locnt+=1;
				$oarray[$locnt]['qty']=$record['qty'];
				$oarray[$locnt]['grade']=$record['grade'];
			}
			if ($record['sale_5_step_sn']==2) {
				$lpcnt+=1;
				$parray[$lpcnt]['psale']=$record['place_of_sale'];
			}
			if ($record['sale_5_step_sn']==3) {
				$lscnt+=1;
				$sarray[$lscnt]['qty']=$record['qty'];
				$sarray[$lscnt]['grade']=$record['grade'];
				$sarray[$lscnt]['value']=$record['product_value'];
			}
			if ($record['sale_5_step_sn']==4) {
				$lccnt+=1;
				$carray[$lccnt]['qty']=$record['qty'];
				$carray[$lccnt]['grade']=$record['grade'];
			}

		}
		if ($lcnt>=0) {
			$larcount=count($oarray);
			if (count($parray)>$larcount) $larcount=count($parray);
			if (count($sarray)>$larcount) $larcount=count($sarray);
			if (count($carray)>$larcount) $larcount=count($carray);
			$lrowspan="";

			for ($cnt=0; $cnt < $larcount; $cnt++) {			
				$lcounter+=1;
				$print.='<tr>
					<td '.$lrowspan.'>'.$lcounter.'</td>
					<td '.$lrowspan.'>'.$record['year1'].'</td>	
					<td '.$lrowspan.'>'.$mineral_name.'</td>
					<td '.$lrowspan.'>'.$state_name.'</td>
					<td '.$lrowspan.'>'.$district_name.'</td>
					<td '.$lrowspan.'>'.$MINE_NAME.'</td>
					<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
					<td '.$lrowspan.'>'.$lease_area.'</td>
					<td '.$lrowspan.'>'.$mine_code.'</td>
					<td '.$lrowspan.'>'.$registration_no.'</td>';

				$print.="<td>";
				if (isset($marray[$cnt]['cont']))
					$print.=$marray[$cnt]['cont'];
				$print.="</td>";						
				//1 start
				$print.="<td>";
				if (isset($oarray[$cnt]['qty']))
					$print.=$oarray[$cnt]['qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($oarray[$cnt]['grade']))
					$print.=$oarray[$cnt]['grade'];
				$print.="</td>";
				//1 end
				//2 start
				$print.="<td>";
				if (isset($parray[$cnt]['psale']))
					$print.=$parray[$cnt]['psale'];
				$print.="</td>";
				//2 end
				//3 start
				$print.="<td>";
				if (isset($sarray[$cnt]['qty']))
					$print.=$sarray[$cnt]['qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($sarray[$cnt]['grade']))
					$print.=$sarray[$cnt]['grade'];
				$print.="</td>";
				$print.="<td>";
				if (isset($sarray[$cnt]['value']))
					$print.=$sarray[$cnt]['value'];
				$print.="</td>";

				//3 end
				//4 start
				$print.="<td>";
				if (isset($carray[$cnt]['qty']))
					$print.=$carray[$cnt]['qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($carray[$cnt]['grade']))
					$print.=$carray[$cnt]['grade'];
				$print.="</td>";
				//4 end
				$print.='</tr>';
			}
			//if ($cnt >0) $print.='</tr>';
				
		}
		$print.='</tbody>
		</table>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>';
		} else { 
		$print="";
		$print='<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<h4 class="tHeadFont" id="heading1">Report A06 - Opening Stock, Sale of Metal/Product and Closing Stock </h4>
						<div class="form-horizontal">
							<div class="card-body" id="avb">
								<h6 class="tHeadDate"  id="heading2">Year : '.$showDate.'</h6>
								
							<h6 class="tHeadDate" id="heading2"><strong>Since records are more hence no search & pagination service is available, you may use the option "Export to Excel"</strong></h6>
							<input type="button" id="downloadExcel" value="Export to Excel">
							<br /><br />
							
								<div class="table-responsive">
									<table class="table table-striped table-hover table-bordered compact" border="1" id="noDatatable">
										<thead class="tableHead">
											<tr>
												<th colspan="19" class="noDisplay" align="left">Report A06 - Opening Stock, Sale of Metal/Product and Closing Stock  Year : '.$showDate.'</th>
											</tr>
											<tr>
												<th rowspan="2">#</th>
												<th rowspan="2">Year</th>  
												<th rowspan="2">Mineral</th>
												<th rowspan="2">State</th>
												<th rowspan="2">District</th>  
												<th rowspan="2">Name of Mine</th>
												<th rowspan="2">Name of Lease Owner</th>
												<th rowspan="2">Lease Area</th>
												<th rowspan="2">Mine Code</th>
												<th rowspan="2">IBM Registration Number</th>
												<th rowspan="2">Metal/Product</th>
												<th colspan="2">Opening Stock</th>
												<th rowspan="2">Place of Sale</th>
												<th colspan="3">Metals/Products Sold</th>
												<th colspan="2">Closing Stock of Metals/Products</th>
											</tr>
											<tr>
												<th>Quantity(tonnes)</th>
												<th>Grade</th>
												<th>Quantity(tonnes) </th>
												<th>Grade</th>
												<th>Value</th>
												<th>Quantity(tonnes)</th>
												<th>Grade</th>
											</tr>
										</thead>
										<tbody class="tableBody">';
        foreach ($records as $record) {
            if ($lmineral_name != $record['mineral_name']) {
                $lmineral_name = $record['mineral_name'];
                $lflg="Y";
            }
            if ($lstate_name != $record['state_name']) {
                $lstate_name = $record['state_name'];
                $lflg="Y";
            }
            if ($ldistrict_name != $record['district_name']) {
                $ldistrict_name = $record['district_name'];
                $lflg="Y";
            }
            if ($lmonthnm != $record['showMonth']) {
                $lmonthnm  = $record['showMonth'];
                $lflg="Y";
            }
            if ($lyearnm != $record['showYear']) {
                $lyearnm  = $record['showYear'];
                $lflg="Y";
            }
            if ($lmincode!=$record['mine_code']) {
                $lmincode=$record['mine_code'];
                $lflg="Y";
            }

            if ($lflg=="Y" || $lcnt <0) {
				if ($lcnt>=0) {
					$larcount=count($oarray);
					if (count($parray)>$larcount) $larcount=count($parray);
					if (count($sarray)>$larcount) $larcount=count($sarray);
					if (count($carray)>$larcount) $larcount=count($carray);
					$lrowspan="";

					for ($cnt=0; $cnt < $larcount; $cnt++) {					
						$lcounter+=1;
						$print.='<tr>
							<td '.$lrowspan.'>'.$lcounter.'</td>
							<td '.$lrowspan.'>'.$record['year1'].'</td>	
							<td '.$lrowspan.'>'.$mineral_name.'</td>
							<td '.$lrowspan.'>'.$state_name.'</td>
							<td '.$lrowspan.'>'.$district_name.'</td>
							<td '.$lrowspan.'>'.$MINE_NAME.'</td>
							<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
							<td '.$lrowspan.'>'.$lease_area.'</td>
							<td '.$lrowspan.'>'.$mine_code.'</td>
							<td '.$lrowspan.'>'.$registration_no.'</td>';

						//if ($cnt >0) 
						//	$print.='<tr>';
						$print.="<td>";
						if (isset($marray[$cnt]['cont']))
							$print.=$marray[$cnt]['cont'];
						$print.="</td>";						
						//1 start
						$print.="<td>";
						if (isset($oarray[$cnt]['qty']))
							$print.=$oarray[$cnt]['qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($oarray[$cnt]['grade']))
							$print.=$oarray[$cnt]['grade'];
						$print.="</td>";
						//1 end
						//2 start
						$print.="<td>";
						if (isset($parray[$cnt]['psale']))
							$print.=$parray[$cnt]['psale'];
						$print.="</td>";
						//2 end
						//3 start
						$print.="<td>";
						if (isset($sarray[$cnt]['qty']))
							$print.=$sarray[$cnt]['qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($sarray[$cnt]['grade']))
							$print.=$sarray[$cnt]['grade'];
						$print.="</td>";
						$print.="<td>";
						if (isset($sarray[$cnt]['value']))
							$print.=$sarray[$cnt]['value'];
						$print.="</td>";

						//3 end
						//4 start
						$print.="<td>";
						if (isset($carray[$cnt]['qty']))
							$print.=$carray[$cnt]['qty'];
						$print.="</td>";
						$print.="<td>";
						if (isset($carray[$cnt]['grade']))
							$print.=$carray[$cnt]['grade'];
						$print.="</td>";
						//4 end
						$print.='</tr>';
					}						
				}
                $lcnt++;
                $lflg="";
                $cnt=0;
				
                $mineral_name=ucwords(str_replace('_', ' ', $record['mineral_name']));
                $state_name=$record['state_name']; 
                $district_name=$record['district_name']; 
                $MINE_NAME=$record['MINE_NAME'] ;
                $lessee_owner_name=$record['lessee_owner_name'];
                $lease_area=$record['lease_area'];
                $mine_code=$record['mine_code'];
                $registration_no=$record['registration_no'];
				$lmetal_content=$record['metal_content'];
				$marray=array();	//metal content
				$oarray=array();	//opening stock array
				$parray=array();	//Place of sale array
				$sarray=array();	//Sale array
				$carray=array();	//clossing stock array
				$lmcnt=-1;
				$locnt=-1;
				$lpcnt=-1;
				$lscnt=-1;
				$lccnt=-1;

			}
            if ($lmetal_content!=$record['metal_content'] || $lmcnt <0) {
				$lmcnt+=1;
				$marray[$lmcnt]['cont']=$record['metal_content'];  
				$lmetal_content=$record['metal_content'];
            } 

			if ($record['sale_5_step_sn']==1) {
				$locnt+=1;
				$oarray[$locnt]['qty']=$record['qty'];
				$oarray[$locnt]['grade']=$record['grade'];
			}
			if ($record['sale_5_step_sn']==2) {
				$lpcnt+=1;
				$parray[$lpcnt]['psale']=$record['place_of_sale'];
			}
			if ($record['sale_5_step_sn']==3) {
				$lscnt+=1;
				$sarray[$lscnt]['qty']=$record['qty'];
				$sarray[$lscnt]['grade']=$record['grade'];
				$sarray[$lscnt]['value']=$record['product_value'];
			}
			if ($record['sale_5_step_sn']==4) {
				$lccnt+=1;
				$carray[$lccnt]['qty']=$record['qty'];
				$carray[$lccnt]['grade']=$record['grade'];
			}

		}
		if ($lcnt>=0) {
			$larcount=count($oarray);
			if (count($parray)>$larcount) $larcount=count($parray);
			if (count($sarray)>$larcount) $larcount=count($sarray);
			if (count($carray)>$larcount) $larcount=count($carray);
			$lrowspan="";

			for ($cnt=0; $cnt < $larcount; $cnt++) {			
				$lcounter+=1;
				$print.='<tr>
					<td '.$lrowspan.'>'.$lcounter.'</td>
					<td '.$lrowspan.'>'.$record['year1'].'</td>	
					<td '.$lrowspan.'>'.$mineral_name.'</td>
					<td '.$lrowspan.'>'.$state_name.'</td>
					<td '.$lrowspan.'>'.$district_name.'</td>
					<td '.$lrowspan.'>'.$MINE_NAME.'</td>
					<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
					<td '.$lrowspan.'>'.$lease_area.'</td>
					<td '.$lrowspan.'>'.$mine_code.'</td>
					<td '.$lrowspan.'>'.$registration_no.'</td>';

				$print.="<td>";
				if (isset($marray[$cnt]['cont']))
					$print.=$marray[$cnt]['cont'];
				$print.="</td>";						
				//1 start
				$print.="<td>";
				if (isset($oarray[$cnt]['qty']))
					$print.=$oarray[$cnt]['qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($oarray[$cnt]['grade']))
					$print.=$oarray[$cnt]['grade'];
				$print.="</td>";
				//1 end
				//2 start
				$print.="<td>";
				if (isset($parray[$cnt]['psale']))
					$print.=$parray[$cnt]['psale'];
				$print.="</td>";
				//2 end
				//3 start
				$print.="<td>";
				if (isset($sarray[$cnt]['qty']))
					$print.=$sarray[$cnt]['qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($sarray[$cnt]['grade']))
					$print.=$sarray[$cnt]['grade'];
				$print.="</td>";
				$print.="<td>";
				if (isset($sarray[$cnt]['value']))
					$print.=$sarray[$cnt]['value'];
				$print.="</td>";

				//3 end
				//4 start
				$print.="<td>";
				if (isset($carray[$cnt]['qty']))
					$print.=$carray[$cnt]['qty'];
				$print.="</td>";
				$print.="<td>";
				if (isset($carray[$cnt]['grade']))
					$print.=$carray[$cnt]['grade'];
				$print.="</td>";
				//4 end
				$print.='</tr>';
			}
			//if ($cnt >0) $print.='</tr>';
				
		}
		$print.='</tbody>
		</table>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>';
		}
		return $print;
	}

    public function reportA07()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower($mineral);
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            $sql = "SELECT DISTINCT rr.current_royalty, rr.current_dead_rent, rr.current_surface_rent,current_pay_dmf,rr.current_pay_nmet, rr.mine_code,
            mw.mineral_name, m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, '$from_year' AS year1, '$next_year' AS year2,
            ml.mcmdt_ML_Area AS lease_area, '$showDate' AS showDate
             FROM
			 tbl_final_submit tfs
					INNER JOIN 
				mine m ON m.mine_code = tfs.mine_code
                    INNER JOIN
                dir_state s ON m.state_code = s.state_code
                    INNER JOIN
                dir_district d ON m.district_code = d.district_code
                    AND s.state_code = d.state_code
                    INNER JOIN
                rent_returns rr ON m.mine_code = rr.mine_code
					AND tfs.mine_code = rr.mine_code
					AND tfs.return_date = rr.return_date
					AND tfs.return_type = rr.return_type
                    AND rr.return_type = '$returnType'
                    AND rr.return_date = '$from_date'
                    INNER JOIN
                mineral_worked mw ON rr.mine_code = mw.mine_code
                    AND m.mine_code = mw.mine_code
					AND tfs.mine_code = mw.mine_code
                   LEFT JOIN
                 mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode 
                    AND rr.mine_code = ml.mcmdt_mineCode
                    AND mw.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1
            WHERE
                rr.return_type = '$returnType' AND rr.return_date = '$from_date' AND tfs.is_latest = 1
				AND rr.current_royalty is not null AND rr.current_dead_rent  is not null and rr.current_surface_rent  is not null and current_pay_dmf is not null and rr.current_pay_nmet  is not null
				";

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND mw.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND rr.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
             //print_r($sql);exit;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA08()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower($mineral);
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            $sql = "SELECT DISTINCT rs.mine_code, rs.mineral_name, m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name,
            d.district_name, rs.oc_type, rs.oc_qty, rs.ug_type, rs.ug_qty, '$from_year' AS year1, '$next_year' AS year2, ml.mcmdt_ML_Area AS lease_area, '$showDate' AS showDate
            FROM
			 tbl_final_submit tfs
					INNER JOIN
                mine m ON tfs.mine_code = m.mine_code
                    INNER JOIN
                dir_state s ON m.state_code = s.state_code
                    INNER JOIN
                dir_district d ON m.district_code = d.district_code
                    AND d.state_code = s.state_code
                    INNER JOIN
                rom_stone rs ON m.mine_code = rs.mine_code
					AND tfs.mine_code = rs.mine_code
					AND tfs.return_date = rs.return_date
					AND tfs.return_type = rs.return_type
                    AND rs.return_type = '$returnType'
                    AND rs.return_date = '$from_date'
                    LEFT JOIN
                 mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode 
                    AND rs.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1
            WHERE
                rs.return_type = '$returnType' AND rs.return_date = '$from_date' AND tfs.is_latest = 1";

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND rs.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND rs.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
            // pr($sql);exit;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

   /* public function reportA09()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower(str_replace(' ', '_', $mineral));
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            $sql = "SELECT DISTINCT ps.mine_code, ps.mineral_name, m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name,
            (ml.under_forest_area + ml.outside_forest_area) AS lease_area, '$showDate' AS showDate,
            CASE
                WHEN ps.stone_sn = 1 THEN ps.prod_oc_no
            END AS rough_prod_no,
            CASE
                WHEN ps.stone_sn = 1 THEN ps.prod_oc_qty
            END AS rough_prod_qty,
            CASE
                WHEN ps.stone_sn = 2 THEN ps.prod_oc_no
            END AS cut_prod_no,
            CASE
                WHEN ps.stone_sn = 2 THEN ps.prod_oc_qty
            END AS cut_prod_qty,
            CASE
                WHEN ps.stone_sn = 3 THEN ps.prod_oc_no
            END AS industrial_prod_no,
            CASE
                WHEN ps.stone_sn = 3 THEN ps.prod_oc_qty
            END AS industrial_prod_qty,
            CASE
                WHEN ps.stone_sn = 99 THEN ps.prod_oc_no
            END AS other_prod_no,
            CASE
                WHEN ps.stone_sn = 99 THEN ps.prod_oc_qty
            END AS other_prod_qty,
            '$from_year' AS year1, $next_year AS year2
            FROM
                mine m
                    INNER JOIN
                dir_state s ON m.state_code = s.state_code
                    INNER JOIN
                dir_district d ON m.district_code = d.district_code
                    AND d.state_code = s.state_code
                    INNER JOIN
                prod_stone ps ON m.mine_code = ps.mine_code
                    AND ps.return_type = '$returnType'
                    AND ps.return_date = '$from_date'
                    INNER JOIN
                mcp_lease ml ON m.mine_code = ml.mine_code
                    AND ps.mine_code = ml.mine_code
            WHERE
                ps.return_type = '$returnType' AND ps.return_date = '$from_date'";

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND ps.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND ps.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND (ml.under_forest_area + ml.outside_forest_area) = '$lesseearea'";
            }
            // pr($sql);exit;
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }*/
	
	
	public function reportA09()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower($mineral);
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            // Changes Lease area table to get lease area Old table = mcp_lease Column name = under_forest_area, outside_forest_area
            // New table mc_minesleasearea_dt table used column name = mcmdt_ML_Area          

            $sql = "SELECT m.MINE_NAME, m.lessee_owner_name, m.registration_no, ml.mcmdt_ML_Area AS lease_area, s.state_name,
                '$showDate' AS showDate,'$from_year' AS year1, '$next_year' AS year2,
               d.district_name, ps.prod_tot_no, ps.prod_tot_qty, ps.stone_sn, ps.mine_code, ps.mineral_name, ps.return_date,
               ps.return_type               
                FROM
              tbl_final_submit tfs
                   INNER JOIN
               prod_stone ps ON ps.mine_code = tfs.mine_code
                   AND ps.return_type = tfs.return_type
                   AND ps.return_date = tfs.return_date
                   INNER JOIN 
                mine m on m.mine_code = tfs.mine_code
                    INNER JOIN
               dir_state s ON m.state_code = s.state_code
                   INNER JOIN
               dir_district d ON m.district_code = d.district_code
                   AND d.state_code = s.state_code
                   LEFT JOIN
               mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1
                   WHERE 
               ps.return_type = '$returnType' AND ps.return_date = '$from_date' AND tfs.is_latest = 1";        

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND ps.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND ps.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
			$sql.=" order by ps.mineral_name,s.state_name,d.district_name,ps.return_date,ps.mine_code,ps.stone_sn ";
            //print_r($sql);exit;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $lprint=$this->generatea09($records,$showDate,$rowCount);
                $this->set('lprint',$lprint);				

                $this->set('records', $records);
                $this->set('showDate', $showDate);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }
	public function generatea09($records,$showDate,$rowCount) {
       $lcnt=-1;
        $cnt=0;
        $lmineral_name = "";
        $lstate_name = "";
        $ldistrict_name = "";
        $lmonthnm = "";
        $lyearnm = "";
        $lmincode="";
		$lmetal_content="";
		$lserialno="";
        $lflg="";
		$lcounter=0;

		$marray=array();	//metal content
		$rarray=array();	//rough and uncut array
		$carray=array();	//Cut & Polished Stones array
		$iarray=array();	//Industrial array
		$oarray=array();	//Others array
		$lmcnt=-1;
		$locnt=-1;
		$lpcnt=-1;
		$lscnt=-1;
		$lccnt=-1;
		
		if($rowCount <= 15000) {
		$print='    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="tHeadFont" id="heading1">Report A09 - Precious & Semi Precious Stone Grade wise Production Details (Form F3)</h4>
                    <div class="form-horizontal">
                        <div class="card-body" id="avb">
							<h6 class="tHeadDate"  id="heading2">Year : '.$showDate .'</h6>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" id="tableReport">
                                    <thead class="tableHead">
                                        <tr>
                                            <th rowspan="4">#</th>
                                            <th rowspan="4">Year</th> 
											<th rowspan="4">Mineral</th>
                                            <th rowspan="4">State</th>
                                            <th rowspan="4">District</th>   											
                                            <th rowspan="4">Name of Mine</th>
                                            <th rowspan="4">Name of Lease Owner</th>
                                            <th rowspan="4">Lease Area</th>
											<th rowspan="4">Mine Code</th>
                                            <th rowspan="4">IBM Registration Number</th>
                                            <th colspan="8"> Production</th>
                                        </tr>
                                        <tr>
                                            <th colspan="4">Gem Variety</th>
                                            <th colspan="2" rowspan="2">Industrial</th>
                                            <th colspan="2" rowspan="2">Others</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Rough & Uncut Stones</th>
                                            <th colspan="2">Cut & Polished Stones</th>
                                        </tr>
                                        <tr>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody">';
        foreach ($records as $record) {
            if ($lmineral_name != $record['mineral_name']) {
                $lmineral_name = $record['mineral_name'];
                $lflg="Y";
            }
            if ($lstate_name != $record['state_name']) {
                $lstate_name = $record['state_name'];
                $lflg="Y";
            }
            if ($ldistrict_name != $record['district_name']) {
                $ldistrict_name = $record['district_name'];
                $lflg="Y";
            }
            if ($lmonthnm != $record['showMonth']) {
                $lmonthnm  = $record['showMonth'];
                $lflg="Y";
            }
            if ($lyearnm != $record['showYear']) {
                $lyearnm  = $record['showYear'];
                $lflg="Y";
            }
            if ($lmincode!=$record['mine_code']) {
                $lmincode=$record['mine_code'];
                $lflg="Y";
            }
            //if ($lmetal_content!=$record['metal_content']) {
            //    $lflg="Y";
                
            //} 
            if ($lflg=="Y" || $lcnt <0) {
				if ($lcnt>=0) {
					$larcount=count($rarray);
					if (count($carray)>$larcount) $larcount=count($carray);
					if (count($iarray)>$larcount) $larcount=count($iarray);
					if (count($oarray)>$larcount) $larcount=count($oarray);
					$lrowspan="";
					if ($larcount>1) 
						$lrowspan=" rowspan=".$larcount."";
					
					$lcounter+=1;
					$print.='<tr>
						<td '.$lrowspan.'>'.$lcounter.'</td>
						<td '.$lrowspan.'>'.$record['year1'].'</td>	
						<td '.$lrowspan.'>'.$mineral_name.'</td>
						<td '.$lrowspan.'>'.$state_name.'</td>
						<td '.$lrowspan.'>'.$district_name.'</td>
						<td '.$lrowspan.'>'.$MINE_NAME.'</td>
						<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
						<td '.$lrowspan.'>'.$lease_area.'</td>
						<td '.$lrowspan.'>'.$mine_code.'</td>
						<td '.$lrowspan.'>'.$registration_no.'</td>';
					for ($cnt=0; $cnt < $larcount; $cnt++) {
						if ($cnt >0) 
							$print.='<tr>';
						//$print.="<td>";
						//if (isset($marray[$cnt]['cont']))
						//	$print.=$marray[$cnt]['cont'];
						//$print.="</td>";						
						//1 start
						$print.="<td>";
						if (isset($rarray[$cnt]['no']))
							$print.=$rarray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($rarray[$cnt]['qty']))
							$print.=$rarray[$cnt]['qty'];
						$print.="</td>";
						//1 end
						//2 start
						$print.="<td>";
						if (isset($carray[$cnt]['no']))
							$print.=$carray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($carray[$cnt]['qty']))
							$print.=$carray[$cnt]['qty'];
						$print.="</td>";
						//2 end
						//3 start
						$print.="<td>";
						if (isset($iarray[$cnt]['no']))
							$print.=$iarray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($iarray[$cnt]['qty']))
							$print.=$iarray[$cnt]['qty'];
						$print.="</td>";
						//3 end
						//99 start
						$print.="<td>";
						if (isset($oarray[$cnt]['no']))
							$print.=$oarray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($oarray[$cnt]['qty']))
							$print.=$oarray[$cnt]['qty'];
						$print.="</td>";
						//99 end
					}
					if ($cnt >0) $print.='</tr>';
						
				}
                $lcnt++;
                $lflg="";
                $cnt=0;
				
                $mineral_name=ucwords(str_replace('_', ' ', $record['mineral_name']));
                $state_name=$record['state_name']; 
                $district_name=$record['district_name']; 
                $MINE_NAME=$record['MINE_NAME'] ;
                $lessee_owner_name=$record['lessee_owner_name'];
                $lease_area=$record['lease_area'];
                $mine_code=$record['mine_code'];
                $registration_no=$record['registration_no'];
				//$lmetal_content=$record['metal_content'];
				$marray=array();	//metal content
				$rarray=array();	//rough and uncut array
				$carray=array();	//Cut & Polished Stones array
				$iarray=array();	//Industrial array
				$oarray=array();	//Others array
				$lmcnt=-1;
				$locnt=-1;
				$lpcnt=-1;
				$lscnt=-1;
				$lccnt=-1;
			}

			if ($record['stone_sn']==1) {
				$locnt+=1;
				$rarray[$locnt]['no']=$record['prod_tot_no'];
				$rarray[$locnt]['qty']=$record['prod_tot_qty'];
			}
			if ($record['stone_sn']==2) {
				$lpcnt+=1;
				$carray[$lpcnt]['no']=$record['prod_tot_no'];
				$carray[$lpcnt]['qty']=$record['prod_tot_qty'];
			}
			if ($record['stone_sn']==3) {
				$lscnt+=1;
				$iarray[$lscnt]['no']=$record['prod_tot_no'];
				$iarray[$lscnt]['qty']=$record['prod_tot_qty'];

			}
			if ($record['stone_sn']==99) {
				$lccnt+=1;
				$oarray[$lccnt]['no']=$record['prod_tot_no'];
				$oarray[$lccnt]['qty']=$record['prod_tot_qty'];
			}

		}
		if ($lcnt>=0) {
			$larcount=count($rarray);
			if (count($carray)>$larcount) $larcount=count($carray);
			if (count($iarray)>$larcount) $larcount=count($iarray);
			if (count($oarray)>$larcount) $larcount=count($oarray);
			$lrowspan="";
			if ($larcount>1) 
				$lrowspan=" rowspan=".$larcount."";
			
			$lcounter+=1;
			$print.='<tr>
				<td '.$lrowspan.'>'.$lcounter.'</td>
				<td '.$lrowspan.'>'.$record['year1'].'</td>	
				<td '.$lrowspan.'>'.$mineral_name.'</td>
				<td '.$lrowspan.'>'.$state_name.'</td>
				<td '.$lrowspan.'>'.$district_name.'</td>
				<td '.$lrowspan.'>'.$MINE_NAME.'</td>
				<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
				<td '.$lrowspan.'>'.$lease_area.'</td>
				<td '.$lrowspan.'>'.$mine_code.'</td>
				<td '.$lrowspan.'>'.$registration_no.'</td>';
			for ($cnt=0; $cnt < $larcount; $cnt++) {
				if ($cnt >0) 
					$print.='<tr>';
				//$print.="<td>";
				//if (isset($marray[$cnt]['cont']))
				//	$print.=$marray[$cnt]['cont'];
				//$print.="</td>";						
				//1 start
				$print.="<td>";
				if (isset($rarray[$cnt]['no']))
					$print.=$rarray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($rarray[$cnt]['qty']))
					$print.=$rarray[$cnt]['qty'];
				$print.="</td>";
				//1 end
				//2 start
				$print.="<td>";
				if (isset($carray[$cnt]['no']))
					$print.=$carray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($carray[$cnt]['qty']))
					$print.=$carray[$cnt]['qty'];
				$print.="</td>";
				//2 end
				//3 start
				$print.="<td>";
				if (isset($iarray[$cnt]['no']))
					$print.=$iarray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($iarray[$cnt]['qty']))
					$print.=$iarray[$cnt]['qty'];
				$print.="</td>";
				//3 end
				//99 start
				$print.="<td>";
				if (isset($oarray[$cnt]['no']))
					$print.=$oarray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($oarray[$cnt]['qty']))
					$print.=$oarray[$cnt]['qty'];
				$print.="</td>";
				//99 end
			}
			if ($cnt >0) $print.='</tr>';
				
		}
		$print.= '</tbody>
		</table>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>';
		} else {
			$print='    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="tHeadFont" id="heading1">Report A09 - Precious & Semi Precious Stone Grade wise Production Details (Form F3)</h4>
                    <div class="form-horizontal">
                        <div class="card-body" id="avb">
							<h6 class="tHeadDate"  id="heading2">Year : '.$showDate .'</h6>
							
							<h6 class="tHeadDate" id="heading2"><strong>Since records are more hence no search & pagination service is available, you may use the option "Export to Excel"</strong></h6>
							<input type="button" id="downloadExcel" value="Export to Excel">
							<br /><br />
								
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" border="1" id="noDatatable">
                                    <thead class="tableHead">
										<tr>
											<th colspan="18" class="noDisplay" align="left">Report A09 - Precious & Semi Precious Stone Grade wise Production Details (Form F3)  Year : '.$showDate .'</th>
										</tr>
                                        <tr>
                                            <th rowspan="4">#</th>
                                            <th rowspan="4">Year</th> 
											<th rowspan="4">Mineral</th>
                                            <th rowspan="4">State</th>
                                            <th rowspan="4">District</th>   											
                                            <th rowspan="4">Name of Mine</th>
                                            <th rowspan="4">Name of Lease Owner</th>
                                            <th rowspan="4">Lease Area</th>
											<th rowspan="4">Mine Code</th>
                                            <th rowspan="4">IBM Registration Number</th>
                                            <th colspan="8"> Production</th>
                                        </tr>
                                        <tr>
                                            <th colspan="4">Gem Variety</th>
                                            <th colspan="2" rowspan="2">Industrial</th>
                                            <th colspan="2" rowspan="2">Others</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Rough & Uncut Stones</th>
                                            <th colspan="2">Cut & Polished Stones</th>
                                        </tr>
                                        <tr>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody">';
        foreach ($records as $record) {
            if ($lmineral_name != $record['mineral_name']) {
                $lmineral_name = $record['mineral_name'];
                $lflg="Y";
            }
            if ($lstate_name != $record['state_name']) {
                $lstate_name = $record['state_name'];
                $lflg="Y";
            }
            if ($ldistrict_name != $record['district_name']) {
                $ldistrict_name = $record['district_name'];
                $lflg="Y";
            }
            if ($lmonthnm != $record['showMonth']) {
                $lmonthnm  = $record['showMonth'];
                $lflg="Y";
            }
            if ($lyearnm != $record['showYear']) {
                $lyearnm  = $record['showYear'];
                $lflg="Y";
            }
            if ($lmincode!=$record['mine_code']) {
                $lmincode=$record['mine_code'];
                $lflg="Y";
            }
            //if ($lmetal_content!=$record['metal_content']) {
            //    $lflg="Y";
                
            //} 
            if ($lflg=="Y" || $lcnt <0) {
				if ($lcnt>=0) {
					$larcount=count($rarray);
					if (count($carray)>$larcount) $larcount=count($carray);
					if (count($iarray)>$larcount) $larcount=count($iarray);
					if (count($oarray)>$larcount) $larcount=count($oarray);
					$lrowspan="";
					if ($larcount>1) 
						$lrowspan=" rowspan=".$larcount."";
					
					$lcounter+=1;
					$print.='<tr>
						<td '.$lrowspan.'>'.$lcounter.'</td>
						<td '.$lrowspan.'>'.$record['year1'].'</td>	
						<td '.$lrowspan.'>'.$mineral_name.'</td>
						<td '.$lrowspan.'>'.$state_name.'</td>
						<td '.$lrowspan.'>'.$district_name.'</td>
						<td '.$lrowspan.'>'.$MINE_NAME.'</td>
						<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
						<td '.$lrowspan.'>'.$lease_area.'</td>
						<td '.$lrowspan.'>'.$mine_code.'</td>
						<td '.$lrowspan.'>'.$registration_no.'</td>';
					for ($cnt=0; $cnt < $larcount; $cnt++) {
						if ($cnt >0) 
							$print.='<tr>';
						//$print.="<td>";
						//if (isset($marray[$cnt]['cont']))
						//	$print.=$marray[$cnt]['cont'];
						//$print.="</td>";						
						//1 start
						$print.="<td>";
						if (isset($rarray[$cnt]['no']))
							$print.=$rarray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($rarray[$cnt]['qty']))
							$print.=$rarray[$cnt]['qty'];
						$print.="</td>";
						//1 end
						//2 start
						$print.="<td>";
						if (isset($carray[$cnt]['no']))
							$print.=$carray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($carray[$cnt]['qty']))
							$print.=$carray[$cnt]['qty'];
						$print.="</td>";
						//2 end
						//3 start
						$print.="<td>";
						if (isset($iarray[$cnt]['no']))
							$print.=$iarray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($iarray[$cnt]['qty']))
							$print.=$iarray[$cnt]['qty'];
						$print.="</td>";
						//3 end
						//99 start
						$print.="<td>";
						if (isset($oarray[$cnt]['no']))
							$print.=$oarray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($oarray[$cnt]['qty']))
							$print.=$oarray[$cnt]['qty'];
						$print.="</td>";
						//99 end
					}
					if ($cnt >0) $print.='</tr>';
						
				}
                $lcnt++;
                $lflg="";
                $cnt=0;
				
                $mineral_name=ucwords(str_replace('_', ' ', $record['mineral_name']));
                $state_name=$record['state_name']; 
                $district_name=$record['district_name']; 
                $MINE_NAME=$record['MINE_NAME'] ;
                $lessee_owner_name=$record['lessee_owner_name'];
                $lease_area=$record['lease_area'];
                $mine_code=$record['mine_code'];
                $registration_no=$record['registration_no'];
				//$lmetal_content=$record['metal_content'];
				$marray=array();	//metal content
				$rarray=array();	//rough and uncut array
				$carray=array();	//Cut & Polished Stones array
				$iarray=array();	//Industrial array
				$oarray=array();	//Others array
				$lmcnt=-1;
				$locnt=-1;
				$lpcnt=-1;
				$lscnt=-1;
				$lccnt=-1;
			}

			if ($record['stone_sn']==1) {
				$locnt+=1;
				$rarray[$locnt]['no']=$record['prod_tot_no'];
				$rarray[$locnt]['qty']=$record['prod_tot_qty'];
			}
			if ($record['stone_sn']==2) {
				$lpcnt+=1;
				$carray[$lpcnt]['no']=$record['prod_tot_no'];
				$carray[$lpcnt]['qty']=$record['prod_tot_qty'];
			}
			if ($record['stone_sn']==3) {
				$lscnt+=1;
				$iarray[$lscnt]['no']=$record['prod_tot_no'];
				$iarray[$lscnt]['qty']=$record['prod_tot_qty'];

			}
			if ($record['stone_sn']==99) {
				$lccnt+=1;
				$oarray[$lccnt]['no']=$record['prod_tot_no'];
				$oarray[$lccnt]['qty']=$record['prod_tot_qty'];
			}

		}
		if ($lcnt>=0) {
			$larcount=count($rarray);
			if (count($carray)>$larcount) $larcount=count($carray);
			if (count($iarray)>$larcount) $larcount=count($iarray);
			if (count($oarray)>$larcount) $larcount=count($oarray);
			$lrowspan="";
			if ($larcount>1) 
				$lrowspan=" rowspan=".$larcount."";
			
			$lcounter+=1;
			$print.='<tr>
				<td '.$lrowspan.'>'.$lcounter.'</td>
				<td '.$lrowspan.'>'.$record['year1'].'</td>	
				<td '.$lrowspan.'>'.$mineral_name.'</td>
				<td '.$lrowspan.'>'.$state_name.'</td>
				<td '.$lrowspan.'>'.$district_name.'</td>
				<td '.$lrowspan.'>'.$MINE_NAME.'</td>
				<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
				<td '.$lrowspan.'>'.$lease_area.'</td>
				<td '.$lrowspan.'>'.$mine_code.'</td>
				<td '.$lrowspan.'>'.$registration_no.'</td>';
			for ($cnt=0; $cnt < $larcount; $cnt++) {
				if ($cnt >0) 
					$print.='<tr>';
				//$print.="<td>";
				//if (isset($marray[$cnt]['cont']))
				//	$print.=$marray[$cnt]['cont'];
				//$print.="</td>";						
				//1 start
				$print.="<td>";
				if (isset($rarray[$cnt]['no']))
					$print.=$rarray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($rarray[$cnt]['qty']))
					$print.=$rarray[$cnt]['qty'];
				$print.="</td>";
				//1 end
				//2 start
				$print.="<td>";
				if (isset($carray[$cnt]['no']))
					$print.=$carray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($carray[$cnt]['qty']))
					$print.=$carray[$cnt]['qty'];
				$print.="</td>";
				//2 end
				//3 start
				$print.="<td>";
				if (isset($iarray[$cnt]['no']))
					$print.=$iarray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($iarray[$cnt]['qty']))
					$print.=$iarray[$cnt]['qty'];
				$print.="</td>";
				//3 end
				//99 start
				$print.="<td>";
				if (isset($oarray[$cnt]['no']))
					$print.=$oarray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($oarray[$cnt]['qty']))
					$print.=$oarray[$cnt]['qty'];
				$print.="</td>";
				//99 end
			}
			if ($cnt >0) $print.='</tr>';
				
		}
		$print.= '</tbody>
		</table>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>';
		}
		return $print;

	}


    /*public function reportA10()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower(str_replace(' ', '_', $mineral));
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            $sql = "SELECT DISTINCT ps.mine_code, ps.mineral_name, m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, (ml.under_forest_area + ml.outside_forest_area) AS lease_area, '$showDate' AS showDate,
            CASE
                WHEN ps.stone_sn = 1 THEN ps.open_tot_no
            END AS rough_open_prod_no,
            CASE
                WHEN ps.stone_sn = 1 THEN ps.open_tot_qty
            END AS rough_open_prod_qty,
            CASE
                WHEN ps.stone_sn = 2 THEN ps.open_tot_no
            END AS cut_open_prod_no,
            CASE
                WHEN ps.stone_sn = 2 THEN ps.open_tot_qty
            END AS cut_open_prod_qty,
            CASE
                WHEN ps.stone_sn = 3 THEN ps.open_tot_no
            END AS industrial_open_prod_no,
            CASE
                WHEN ps.stone_sn = 3 THEN ps.open_tot_qty
            END AS industrial_open_prod_qty,
            CASE
                WHEN ps.stone_sn = 99 THEN ps.open_tot_no
            END AS other_open_prod_no,
            CASE
                WHEN ps.stone_sn = 99 THEN ps.open_tot_qty
            END AS other_open_prod_qty,
            CASE
                WHEN ps.stone_sn = 1 THEN ps.clos_tot_no
            END AS rough_clos_prod_no,
            CASE
                WHEN ps.stone_sn = 1 THEN ps.clos_tot_qty
            END AS rough_clos_prod_qty,
            CASE
                WHEN ps.stone_sn = 2 THEN ps.clos_tot_no
            END AS cut_clos_prod_no,
            CASE
                WHEN ps.stone_sn = 2 THEN ps.clos_tot_qty
            END AS cut_clos_prod_qty,
            CASE
                WHEN ps.stone_sn = 3 THEN ps.clos_tot_no
            END AS industrial_clos_prod_no,
            CASE
                WHEN ps.stone_sn = 3 THEN ps.clos_tot_qty
            END AS industrial_clos_prod_qty,
            CASE
                WHEN ps.stone_sn = 99 THEN ps.clos_tot_no
            END AS other_clos_prod_no,
            CASE
                WHEN ps.stone_sn = 99 THEN ps.clos_tot_qty
            END AS other_clos_prod_qty,
            '$from_year' AS year1, $next_year AS year2
            FROM
                mine m
                    INNER JOIN
                dir_state s ON m.state_code = s.state_code
                    INNER JOIN
                dir_district d ON m.district_code = d.district_code
                    AND d.state_code = s.state_code
                    INNER JOIN
                prod_stone ps ON m.mine_code = ps.mine_code
                    AND ps.return_type = '$returnType'
                    AND ps.return_date = '$from_date'
                    LEFT JOIN
                mcp_lease ml ON m.mine_code = ml.mine_code
                    AND ps.mine_code = ml.mine_code
            WHERE
                ps.return_type = '$returnType' AND ps.return_date = '$from_date'";

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND ps.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND ps.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND (ml.under_forest_area + ml.outside_forest_area) = '$lesseearea'";
            }
            // pr($sql);exit;
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }*/
	
	public function reportA10()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower($mineral);
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');
           
            $sql = "SELECT m.MINE_NAME, m.lessee_owner_name, m.registration_no, ml.mcmdt_ML_Area AS lease_area, s.state_name,
                    d.district_name, '$from_year' AS year1, '$next_year' AS year2,  '$showDate' AS showDate,
                    ps.stone_sn, ps.open_tot_no, ps.open_tot_qty, ps.clos_tot_no, ps.clos_tot_qty,  ps.mine_code,
                    ps.mineral_name, ps.return_date, ps.return_type               
                    FROM
                    tbl_final_submit tfs
                        INNER JOIN
                    prod_stone ps ON ps.mine_code = tfs.mine_code
                        AND ps.return_type = tfs.return_type
                        AND ps.return_date = tfs.return_date
                        INNER JOIN 
                        mine m on m.mine_code = tfs.mine_code
                            INNER JOIN
                    dir_state s ON m.state_code = s.state_code
                        INNER JOIN
                    dir_district d ON m.district_code = d.district_code
                        AND d.state_code = s.state_code
                        LEFT JOIN
                    mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1
                        WHERE 
                    ps.return_type = '$returnType' AND ps.return_date = '$from_date' AND tfs.is_latest = 1";
            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND ps.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND ps.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
			$sql.=" order by ps.mineral_name,s.state_name,d.district_name,ps.return_date,ps.mine_code,ps.stone_sn ";
			
            //print_r($sql);exit;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $lprint=$this->generatea10($records,$showDate,$rowCount);
                $this->set('lprint',$lprint);				
				
                $this->set('records', $records);
                $this->set('showDate', $showDate);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }
	public function generatea10($records,$showDate,$rowCount) {
        $lcnt=-1;
        $cnt=0;
        $lmineral_name = "";
        $lstate_name = "";
        $ldistrict_name = "";
        $lmonthnm = "";
        $lyearnm = "";
        $lmincode="";
		$lmetal_content="";
		$lserialno="";
        $lflg="";
		$lcounter=0;

		$marray=array();	//metal content
		$rarray=array();	//rough and uncut array
		$carray=array();	//Cut & Polished Stones array
		$iarray=array();	//Industrial array
		$oarray=array();	//Others array
		$lmcnt=-1;
		$locnt=-1;
		$lpcnt=-1;
		$lscnt=-1;
		$lccnt=-1;
		
		if($rowCount <= 15000) {
		$print='  <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="tHeadFont" id="heading1">Report A10 - Precious & Semi Precious Stone Opening & Closing Stock Details (Form F3)</h4>
                    <div class="form-horizontal">
                        <div class="card-body" id="avb">
							<h6 class="tHeadDate"  id="heading2">Year : '.$showDate.'</h6>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" id="tableReport">
                                    <thead class="tableHead">
                                        <tr>
                                            <th rowspan="4">#</th>
                                            <th rowspan="4">Year</th>    
											<th rowspan="4">Mineral</th>
                                            <th rowspan="4">State</th>
                                            <th rowspan="4">District</th>  
                                            <th rowspan="4">Name of Mine</th>
                                            <th rowspan="4">Name of Lease Owner</th>
                                            <th rowspan="4">Lease Area</th>
											 <th rowspan="4">Mine Code</th>
                                            <th rowspan="4">IBM Registration Number</th>
                                            <th colspan="8"> Opening Stock</th>
                                            <th colspan="8"> Closing Stock</th>
                                        </tr>
                                        <tr>
                                            <th colspan="4">Gem Variety</th>
                                            <th colspan="2" rowspan="2">Industrial</th>
                                            <th colspan="2" rowspan="2">Others</th>
                                            <th colspan="4">Gem Variety</th>
                                            <th colspan="2" rowspan="2">Industrial</th>
                                            <th colspan="2" rowspan="2">Others</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Rough & Uncut Stones</th>
                                            <th colspan="2">Cut & Polished Stones</th>
                                            <th colspan="2">Rough & Uncut Stones</th>
                                            <th colspan="2">Cut & Polished Stones</th>
                                        </tr>
                                        <tr>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody">';
        foreach ($records as $record) {
            if ($lmineral_name != $record['mineral_name']) {
                $lmineral_name = $record['mineral_name'];
                $lflg="Y";
            }
            if ($lstate_name != $record['state_name']) {
                $lstate_name = $record['state_name'];
                $lflg="Y";
            }
            if ($ldistrict_name != $record['district_name']) {
                $ldistrict_name = $record['district_name'];
                $lflg="Y";
            }
            if ($lmonthnm != $record['showMonth']) {
                $lmonthnm  = $record['showMonth'];
                $lflg="Y";
            }
            if ($lyearnm != $record['showYear']) {
                $lyearnm  = $record['showYear'];
                $lflg="Y";
            }
            if ($lmincode!=$record['mine_code']) {
                $lmincode=$record['mine_code'];
                $lflg="Y";
            }
            //if ($lmetal_content!=$record['metal_content']) {
            //    $lflg="Y";
                
            //} 
            if ($lflg=="Y" || $lcnt <0) {
				if ($lcnt>=0) {
					$larcount=count($rarray);
					if (count($carray)>$larcount) $larcount=count($carray);
					if (count($iarray)>$larcount) $larcount=count($iarray);
					if (count($oarray)>$larcount) $larcount=count($oarray);
					$lrowspan="";
					if ($larcount>1) 
						$lrowspan=" rowspan=".$larcount."";
					
					$lcounter+=1;
					$print.='<tr>
						<td '.$lrowspan.'>'.$lcounter.'</td>
						<td '.$lrowspan.'>'.$record['year1'].'</td>	
						<td '.$lrowspan.'>'.$mineral_name.'</td>
						<td '.$lrowspan.'>'.$state_name.'</td>
						<td '.$lrowspan.'>'.$district_name.'</td>
						<td '.$lrowspan.'>'.$MINE_NAME.'</td>
						<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
						<td '.$lrowspan.'>'.$lease_area.'</td>
						<td '.$lrowspan.'>'.$mine_code.'</td>
						<td '.$lrowspan.'>'.$registration_no.'</td>';
					for ($cnt=0; $cnt < $larcount; $cnt++) {
						if ($cnt >0) 
							$print.='<tr>';
						//$print.="<td>";
						//if (isset($marray[$cnt]['cont']))
						//	$print.=$marray[$cnt]['cont'];
						//$print.="</td>";
						//opening Stock starts here
						//1 start
						$print.="<td>";
						if (isset($rarray[$cnt]['no']))
							$print.=$rarray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($rarray[$cnt]['qty']))
							$print.=$rarray[$cnt]['qty'];
						$print.="</td>";
						//1 end
						//2 start
						$print.="<td>";
						if (isset($carray[$cnt]['no']))
							$print.=$carray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($carray[$cnt]['qty']))
							$print.=$carray[$cnt]['qty'];
						$print.="</td>";
						//2 end
						//3 start
						$print.="<td>";
						if (isset($iarray[$cnt]['no']))
							$print.=$iarray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($iarray[$cnt]['qty']))
							$print.=$iarray[$cnt]['qty'];
						$print.="</td>";
						//3 end
						//99 start
						$print.="<td>";
						if (isset($oarray[$cnt]['no']))
							$print.=$oarray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($oarray[$cnt]['qty']))
							$print.=$oarray[$cnt]['qty'];
						$print.="</td>";
						//99 end
						//open stock ends here
						//Closing STock starts here
						//1 start
						$print.="<td>";
						if (isset($rarray[$cnt]['cno']))
							$print.=$rarray[$cnt]['cno'];
						$print.="</td>";
						$print.="<td>";
						if (isset($rarray[$cnt]['cqty']))
							$print.=$rarray[$cnt]['cqty'];
						$print.="</td>";
						//1 end
						//2 start
						$print.="<td>";
						if (isset($carray[$cnt]['cno']))
							$print.=$carray[$cnt]['cno'];
						$print.="</td>";
						$print.="<td>";
						if (isset($carray[$cnt]['cqty']))
							$print.=$carray[$cnt]['cqty'];
						$print.="</td>";
						//2 end
						//3 start
						$print.="<td>";
						if (isset($iarray[$cnt]['cno']))
							$print.=$iarray[$cnt]['cno'];
						$print.="</td>";
						$print.="<td>";
						if (isset($iarray[$cnt]['cqty']))
							$print.=$iarray[$cnt]['cqty'];
						$print.="</td>";
						//3 end
						//99 start
						$print.="<td>";
						if (isset($oarray[$cnt]['cno']))
							$print.=$oarray[$cnt]['cno'];
						$print.="</td>";
						$print.="<td>";
						if (isset($oarray[$cnt]['cqty']))
							$print.=$oarray[$cnt]['cqty'];
						$print.="</td>";
						//99 end
						//closing stock ends here
					}
					if ($cnt >0) $print.='</tr>';
						
				}
                $lcnt++;
                $lflg="";
                $cnt=0;
				
                $mineral_name=ucwords(str_replace('_', ' ', $record['mineral_name']));
                $state_name=$record['state_name']; 
                $district_name=$record['district_name']; 
                $MINE_NAME=$record['MINE_NAME'] ;
                $lessee_owner_name=$record['lessee_owner_name'];
                $lease_area=$record['lease_area'];
                $mine_code=$record['mine_code'];
                $registration_no=$record['registration_no'];
				//$lmetal_content=$record['metal_content'];
				$marray=array();	//metal content
				$rarray=array();	//rough and uncut array
				$carray=array();	//Cut & Polished Stones array
				$iarray=array();	//Industrial array
				$oarray=array();	//Others array
				$lmcnt=-1;
				$locnt=-1;
				$lpcnt=-1;
				$lscnt=-1;
				$lccnt=-1;
			}

			if ($record['stone_sn']==1) {
				$locnt+=1;
				$rarray[$locnt]['no']=$record['open_tot_no'];
				$rarray[$locnt]['qty']=$record['open_tot_qty'];
				$rarray[$locnt]['cno']=$record['clos_tot_no'];
				$rarray[$locnt]['cqty']=$record['clos_tot_qty'];
			}
			if ($record['stone_sn']==2) {
				$lpcnt+=1;
				$carray[$lpcnt]['no']=$record['open_tot_no'];
				$carray[$lpcnt]['qty']=$record['open_tot_qty'];
				$carray[$lpcnt]['cno']=$record['clos_tot_no'];
				$carray[$lpcnt]['cqty']=$record['clos_tot_qty'];
			}
			if ($record['stone_sn']==3) {
				$lscnt+=1;
				$iarray[$lscnt]['no']=$record['open_tot_no'];
				$iarray[$lscnt]['qty']=$record['open_tot_qty'];
				$iarray[$lscnt]['cno']=$record['clos_tot_no'];
				$iarray[$lscnt]['cqty']=$record['clos_tot_qty'];

			}
			if ($record['stone_sn']==99) {
				$lccnt+=1;
				$oarray[$lccnt]['no']=$record['open_tot_no'];
				$oarray[$lccnt]['qty']=$record['open_tot_qty'];
				$oarray[$lccnt]['cno']=$record['clos_tot_no'];
				$oarray[$lccnt]['cqty']=$record['clos_tot_qty'];
			}

		}
		if ($lcnt>=0) {
			$larcount=count($rarray);
			if (count($carray)>$larcount) $larcount=count($carray);
			if (count($iarray)>$larcount) $larcount=count($iarray);
			if (count($oarray)>$larcount) $larcount=count($oarray);
			$lrowspan="";
			if ($larcount>1) 
				$lrowspan=" rowspan=".$larcount."";
			
			$lcounter+=1;
			$print.='<tr>
				<td '.$lrowspan.'>'.$lcounter.'</td>
				<td '.$lrowspan.'>'.$record['year1'].'</td>	
				<td '.$lrowspan.'>'.$mineral_name.'</td>
				<td '.$lrowspan.'>'.$state_name.'</td>
				<td '.$lrowspan.'>'.$district_name.'</td>
				<td '.$lrowspan.'>'.$MINE_NAME.'</td>
				<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
				<td '.$lrowspan.'>'.$lease_area.'</td>
				<td '.$lrowspan.'>'.$mine_code.'</td>
				<td '.$lrowspan.'>'.$registration_no.'</td>';
			for ($cnt=0; $cnt < $larcount; $cnt++) {
				if ($cnt >0) 
					$print.='<tr>';
				//$print.="<td>";
				//if (isset($marray[$cnt]['cont']))
				//	$print.=$marray[$cnt]['cont'];
				//$print.="</td>";
				//opening Stock starts here
				//1 start
				$print.="<td>";
				if (isset($rarray[$cnt]['no']))
					$print.=$rarray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($rarray[$cnt]['qty']))
					$print.=$rarray[$cnt]['qty'];
				$print.="</td>";
				//1 end
				//2 start
				$print.="<td>";
				if (isset($carray[$cnt]['no']))
					$print.=$carray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($carray[$cnt]['qty']))
					$print.=$carray[$cnt]['qty'];
				$print.="</td>";
				//2 end
				//3 start
				$print.="<td>";
				if (isset($iarray[$cnt]['no']))
					$print.=$iarray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($iarray[$cnt]['qty']))
					$print.=$iarray[$cnt]['qty'];
				$print.="</td>";
				//3 end
				//99 start
				$print.="<td>";
				if (isset($oarray[$cnt]['no']))
					$print.=$oarray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($oarray[$cnt]['qty']))
					$print.=$oarray[$cnt]['qty'];
				$print.="</td>";
				//99 end
				//open stock ends here
				//Closing STock starts here
				//1 start
				$print.="<td>";
				if (isset($rarray[$cnt]['cno']))
					$print.=$rarray[$cnt]['cno'];
				$print.="</td>";
				$print.="<td>";
				if (isset($rarray[$cnt]['cqty']))
					$print.=$rarray[$cnt]['cqty'];
				$print.="</td>";
				//1 end
				//2 start
				$print.="<td>";
				if (isset($carray[$cnt]['cno']))
					$print.=$carray[$cnt]['cno'];
				$print.="</td>";
				$print.="<td>";
				if (isset($carray[$cnt]['cqty']))
					$print.=$carray[$cnt]['cqty'];
				$print.="</td>";
				//2 end
				//3 start
				$print.="<td>";
				if (isset($iarray[$cnt]['cno']))
					$print.=$iarray[$cnt]['cno'];
				$print.="</td>";
				$print.="<td>";
				if (isset($iarray[$cnt]['cqty']))
					$print.=$iarray[$cnt]['cqty'];
				$print.="</td>";
				//3 end
				//99 start
				$print.="<td>";
				if (isset($oarray[$cnt]['cno']))
					$print.=$oarray[$cnt]['cno'];
				$print.="</td>";
				$print.="<td>";
				if (isset($oarray[$cnt]['cqty']))
					$print.=$oarray[$cnt]['cqty'];
				$print.="</td>";
				//99 end
				//closing stock ends here
			}
			if ($cnt >0) $print.='</tr>';
				
		}
		
		$print.= '</tbody>
		</table>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>';
		} else { 
		$print='  <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="tHeadFont" id="heading1">Report A10 - Precious & Semi Precious Stone Opening & Closing Stock Details (Form F3)</h4>
                    <div class="form-horizontal">
                        <div class="card-body" id="avb">
							<h6 class="tHeadDate"  id="heading2">Year : '.$showDate.'</h6>
							
							<h6 class="tHeadDate" id="heading2"><strong>Since records are more hence no search & pagination service is available, you may use the option "Export to Excel"</strong></h6>
							<input type="button" id="downloadExcel" value="Export to Excel">
							<br /><br />
								
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" border="1" id="noDatatable">
                                    <thead class="tableHead">
										<tr>
											<th colspan="26" class="noDisplay" align="left">Report A10 - Precious & Semi Precious Stone Opening & Closing Stock Details (Form F3)  Year : '.$showDate.'</th>
										</tr>
                                        <tr>
                                            <th rowspan="4">#</th>
                                            <th rowspan="4">Year</th>    
											<th rowspan="4">Mineral</th>
                                            <th rowspan="4">State</th>
                                            <th rowspan="4">District</th>  
                                            <th rowspan="4">Name of Mine</th>
                                            <th rowspan="4">Name of Lease Owner</th>
                                            <th rowspan="4">Lease Area</th>
											 <th rowspan="4">Mine Code</th>
                                            <th rowspan="4">IBM Registration Number</th>
                                            <th colspan="8"> Opening Stock</th>
                                            <th colspan="8"> Closing Stock</th>
                                        </tr>
                                        <tr>
                                            <th colspan="4">Gem Variety</th>
                                            <th colspan="2" rowspan="2">Industrial</th>
                                            <th colspan="2" rowspan="2">Others</th>
                                            <th colspan="4">Gem Variety</th>
                                            <th colspan="2" rowspan="2">Industrial</th>
                                            <th colspan="2" rowspan="2">Others</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Rough & Uncut Stones</th>
                                            <th colspan="2">Cut & Polished Stones</th>
                                            <th colspan="2">Rough & Uncut Stones</th>
                                            <th colspan="2">Cut & Polished Stones</th>
                                        </tr>
                                        <tr>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                            <th>No. of Stones</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody">';
        foreach ($records as $record) {
            if ($lmineral_name != $record['mineral_name']) {
                $lmineral_name = $record['mineral_name'];
                $lflg="Y";
            }
            if ($lstate_name != $record['state_name']) {
                $lstate_name = $record['state_name'];
                $lflg="Y";
            }
            if ($ldistrict_name != $record['district_name']) {
                $ldistrict_name = $record['district_name'];
                $lflg="Y";
            }
            if ($lmonthnm != $record['showMonth']) {
                $lmonthnm  = $record['showMonth'];
                $lflg="Y";
            }
            if ($lyearnm != $record['showYear']) {
                $lyearnm  = $record['showYear'];
                $lflg="Y";
            }
            if ($lmincode!=$record['mine_code']) {
                $lmincode=$record['mine_code'];
                $lflg="Y";
            }
            //if ($lmetal_content!=$record['metal_content']) {
            //    $lflg="Y";
                
            //} 
            if ($lflg=="Y" || $lcnt <0) {
				if ($lcnt>=0) {
					$larcount=count($rarray);
					if (count($carray)>$larcount) $larcount=count($carray);
					if (count($iarray)>$larcount) $larcount=count($iarray);
					if (count($oarray)>$larcount) $larcount=count($oarray);
					$lrowspan="";
					if ($larcount>1) 
						$lrowspan=" rowspan=".$larcount."";
					
					$lcounter+=1;
					$print.='<tr>
						<td '.$lrowspan.'>'.$lcounter.'</td>
						<td '.$lrowspan.'>'.$record['year1'].'</td>	
						<td '.$lrowspan.'>'.$mineral_name.'</td>
						<td '.$lrowspan.'>'.$state_name.'</td>
						<td '.$lrowspan.'>'.$district_name.'</td>
						<td '.$lrowspan.'>'.$MINE_NAME.'</td>
						<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
						<td '.$lrowspan.'>'.$lease_area.'</td>
						<td '.$lrowspan.'>'.$mine_code.'</td>
						<td '.$lrowspan.'>'.$registration_no.'</td>';
					for ($cnt=0; $cnt < $larcount; $cnt++) {
						if ($cnt >0) 
							$print.='<tr>';
						//$print.="<td>";
						//if (isset($marray[$cnt]['cont']))
						//	$print.=$marray[$cnt]['cont'];
						//$print.="</td>";
						//opening Stock starts here
						//1 start
						$print.="<td>";
						if (isset($rarray[$cnt]['no']))
							$print.=$rarray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($rarray[$cnt]['qty']))
							$print.=$rarray[$cnt]['qty'];
						$print.="</td>";
						//1 end
						//2 start
						$print.="<td>";
						if (isset($carray[$cnt]['no']))
							$print.=$carray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($carray[$cnt]['qty']))
							$print.=$carray[$cnt]['qty'];
						$print.="</td>";
						//2 end
						//3 start
						$print.="<td>";
						if (isset($iarray[$cnt]['no']))
							$print.=$iarray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($iarray[$cnt]['qty']))
							$print.=$iarray[$cnt]['qty'];
						$print.="</td>";
						//3 end
						//99 start
						$print.="<td>";
						if (isset($oarray[$cnt]['no']))
							$print.=$oarray[$cnt]['no'];
						$print.="</td>";
						$print.="<td>";
						if (isset($oarray[$cnt]['qty']))
							$print.=$oarray[$cnt]['qty'];
						$print.="</td>";
						//99 end
						//open stock ends here
						//Closing STock starts here
						//1 start
						$print.="<td>";
						if (isset($rarray[$cnt]['cno']))
							$print.=$rarray[$cnt]['cno'];
						$print.="</td>";
						$print.="<td>";
						if (isset($rarray[$cnt]['cqty']))
							$print.=$rarray[$cnt]['cqty'];
						$print.="</td>";
						//1 end
						//2 start
						$print.="<td>";
						if (isset($carray[$cnt]['cno']))
							$print.=$carray[$cnt]['cno'];
						$print.="</td>";
						$print.="<td>";
						if (isset($carray[$cnt]['cqty']))
							$print.=$carray[$cnt]['cqty'];
						$print.="</td>";
						//2 end
						//3 start
						$print.="<td>";
						if (isset($iarray[$cnt]['cno']))
							$print.=$iarray[$cnt]['cno'];
						$print.="</td>";
						$print.="<td>";
						if (isset($iarray[$cnt]['cqty']))
							$print.=$iarray[$cnt]['cqty'];
						$print.="</td>";
						//3 end
						//99 start
						$print.="<td>";
						if (isset($oarray[$cnt]['cno']))
							$print.=$oarray[$cnt]['cno'];
						$print.="</td>";
						$print.="<td>";
						if (isset($oarray[$cnt]['cqty']))
							$print.=$oarray[$cnt]['cqty'];
						$print.="</td>";
						//99 end
						//closing stock ends here
					}
					if ($cnt >0) $print.='</tr>';
						
				}
                $lcnt++;
                $lflg="";
                $cnt=0;
				
                $mineral_name=ucwords(str_replace('_', ' ', $record['mineral_name']));
                $state_name=$record['state_name']; 
                $district_name=$record['district_name']; 
                $MINE_NAME=$record['MINE_NAME'] ;
                $lessee_owner_name=$record['lessee_owner_name'];
                $lease_area=$record['lease_area'];
                $mine_code=$record['mine_code'];
                $registration_no=$record['registration_no'];
				//$lmetal_content=$record['metal_content'];
				$marray=array();	//metal content
				$rarray=array();	//rough and uncut array
				$carray=array();	//Cut & Polished Stones array
				$iarray=array();	//Industrial array
				$oarray=array();	//Others array
				$lmcnt=-1;
				$locnt=-1;
				$lpcnt=-1;
				$lscnt=-1;
				$lccnt=-1;
			}

			if ($record['stone_sn']==1) {
				$locnt+=1;
				$rarray[$locnt]['no']=$record['open_tot_no'];
				$rarray[$locnt]['qty']=$record['open_tot_qty'];
				$rarray[$locnt]['cno']=$record['clos_tot_no'];
				$rarray[$locnt]['cqty']=$record['clos_tot_qty'];
			}
			if ($record['stone_sn']==2) {
				$lpcnt+=1;
				$carray[$lpcnt]['no']=$record['open_tot_no'];
				$carray[$lpcnt]['qty']=$record['open_tot_qty'];
				$carray[$lpcnt]['cno']=$record['clos_tot_no'];
				$carray[$lpcnt]['cqty']=$record['clos_tot_qty'];
			}
			if ($record['stone_sn']==3) {
				$lscnt+=1;
				$iarray[$lscnt]['no']=$record['open_tot_no'];
				$iarray[$lscnt]['qty']=$record['open_tot_qty'];
				$iarray[$lscnt]['cno']=$record['clos_tot_no'];
				$iarray[$lscnt]['cqty']=$record['clos_tot_qty'];

			}
			if ($record['stone_sn']==99) {
				$lccnt+=1;
				$oarray[$lccnt]['no']=$record['open_tot_no'];
				$oarray[$lccnt]['qty']=$record['open_tot_qty'];
				$oarray[$lccnt]['cno']=$record['clos_tot_no'];
				$oarray[$lccnt]['cqty']=$record['clos_tot_qty'];
			}

		}
		if ($lcnt>=0) {
			$larcount=count($rarray);
			if (count($carray)>$larcount) $larcount=count($carray);
			if (count($iarray)>$larcount) $larcount=count($iarray);
			if (count($oarray)>$larcount) $larcount=count($oarray);
			$lrowspan="";
			if ($larcount>1) 
				$lrowspan=" rowspan=".$larcount."";
			
			$lcounter+=1;
			$print.='<tr>
				<td '.$lrowspan.'>'.$lcounter.'</td>
				<td '.$lrowspan.'>'.$record['year1'].'</td>	
				<td '.$lrowspan.'>'.$mineral_name.'</td>
				<td '.$lrowspan.'>'.$state_name.'</td>
				<td '.$lrowspan.'>'.$district_name.'</td>
				<td '.$lrowspan.'>'.$MINE_NAME.'</td>
				<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
				<td '.$lrowspan.'>'.$lease_area.'</td>
				<td '.$lrowspan.'>'.$mine_code.'</td>
				<td '.$lrowspan.'>'.$registration_no.'</td>';
			for ($cnt=0; $cnt < $larcount; $cnt++) {
				if ($cnt >0) 
					$print.='<tr>';
				//$print.="<td>";
				//if (isset($marray[$cnt]['cont']))
				//	$print.=$marray[$cnt]['cont'];
				//$print.="</td>";
				//opening Stock starts here
				//1 start
				$print.="<td>";
				if (isset($rarray[$cnt]['no']))
					$print.=$rarray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($rarray[$cnt]['qty']))
					$print.=$rarray[$cnt]['qty'];
				$print.="</td>";
				//1 end
				//2 start
				$print.="<td>";
				if (isset($carray[$cnt]['no']))
					$print.=$carray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($carray[$cnt]['qty']))
					$print.=$carray[$cnt]['qty'];
				$print.="</td>";
				//2 end
				//3 start
				$print.="<td>";
				if (isset($iarray[$cnt]['no']))
					$print.=$iarray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($iarray[$cnt]['qty']))
					$print.=$iarray[$cnt]['qty'];
				$print.="</td>";
				//3 end
				//99 start
				$print.="<td>";
				if (isset($oarray[$cnt]['no']))
					$print.=$oarray[$cnt]['no'];
				$print.="</td>";
				$print.="<td>";
				if (isset($oarray[$cnt]['qty']))
					$print.=$oarray[$cnt]['qty'];
				$print.="</td>";
				//99 end
				//open stock ends here
				//Closing STock starts here
				//1 start
				$print.="<td>";
				if (isset($rarray[$cnt]['cno']))
					$print.=$rarray[$cnt]['cno'];
				$print.="</td>";
				$print.="<td>";
				if (isset($rarray[$cnt]['cqty']))
					$print.=$rarray[$cnt]['cqty'];
				$print.="</td>";
				//1 end
				//2 start
				$print.="<td>";
				if (isset($carray[$cnt]['cno']))
					$print.=$carray[$cnt]['cno'];
				$print.="</td>";
				$print.="<td>";
				if (isset($carray[$cnt]['cqty']))
					$print.=$carray[$cnt]['cqty'];
				$print.="</td>";
				//2 end
				//3 start
				$print.="<td>";
				if (isset($iarray[$cnt]['cno']))
					$print.=$iarray[$cnt]['cno'];
				$print.="</td>";
				$print.="<td>";
				if (isset($iarray[$cnt]['cqty']))
					$print.=$iarray[$cnt]['cqty'];
				$print.="</td>";
				//3 end
				//99 start
				$print.="<td>";
				if (isset($oarray[$cnt]['cno']))
					$print.=$oarray[$cnt]['cno'];
				$print.="</td>";
				$print.="<td>";
				if (isset($oarray[$cnt]['cqty']))
					$print.=$oarray[$cnt]['cqty'];
				$print.="</td>";
				//99 end
				//closing stock ends here
			}
			if ($cnt >0) $print.='</tr>';
				
		}
		
		$print.= '</tbody>
		</table>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>';
		}
		return $print;
	}


    /*public function reportA11()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower(str_replace(' ', '_', $mineral));
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            $sql = "SELECT DISTINCT ps.mine_code, ps.mineral_name, m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, (ml.under_forest_area + ml.outside_forest_area) AS lease_area, '$showDate' AS showDate,
            CASE
                WHEN ps.stone_sn = 1 THEN ps.pmv_oc
            END AS rough_pmv_prod_no,
            CASE
                WHEN ps.stone_sn = 1 THEN ps.pmv_oc
            END AS rough_pmv_prod_qty,
            CASE
                WHEN ps.stone_sn = 2 THEN ps.pmv_oc
            END AS cut_pmv_prod_no,
            CASE
                WHEN ps.stone_sn = 2 THEN ps.pmv_oc
            END AS cut_pmv_prod_qty,
            CASE
                WHEN ps.stone_sn = 3 THEN ps.pmv_oc
            END AS industrial_pmv_prod_no,
            CASE
                WHEN ps.stone_sn = 3 THEN ps.pmv_oc
            END AS industrial_pmv_prod_qty,
            CASE
                WHEN ps.stone_sn = 99 THEN ps.pmv_oc
            END AS other_pmv_prod_no,
            CASE
                WHEN ps.stone_sn = 99 THEN ps.pmv_oc
            END AS other_pmv_prod_qty,
            '$from_year' AS year1, $next_year AS year2
            FROM
                mine m
                    INNER JOIN
                dir_state s ON m.state_code = s.state_code
                    INNER JOIN
                dir_district d ON m.district_code = d.district_code
                    AND d.state_code = s.state_code
                    INNER JOIN
                prod_stone ps ON m.mine_code = ps.mine_code
                    AND ps.return_type = '$returnType'
                    AND ps.return_date = '$from_date'
                    LEFT JOIN
                mcp_lease ml ON m.mine_code = ml.mine_code
                    AND ps.mine_code = ml.mine_code
            WHERE
                ps.return_type = '$returnType'
                    AND ps.return_date = '$from_date'";
            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND ps.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND ps.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND (ml.under_forest_area + ml.outside_forest_area) = '$lesseearea'";
            }
            // pr($sql);exit;
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }*/
	
	public function reportA11()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower($mineral);
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            
                $sql = "SELECT m.MINE_NAME,  m.lessee_owner_name, m.registration_no, ml.mcmdt_ML_Area AS lease_area, s.state_name,
                        d.district_name ,   '$from_year' AS year1, '$next_year' AS year2, ps.stone_sn, ps.pmv_oc,  ps.mine_code, '$showDate' AS showDate,
						ps.mineral_name, ps.return_date, ps.return_type                   
                        FROM
                        tbl_final_submit tfs
                            INNER JOIN
                        prod_stone ps ON ps.mine_code = tfs.mine_code
                            AND ps.return_type = tfs.return_type
                            AND ps.return_date = tfs.return_date
                            INNER JOIN 
                            mine m on m.mine_code = tfs.mine_code
                                INNER JOIN
                        dir_state s ON m.state_code = s.state_code
                            INNER JOIN
                        dir_district d ON m.district_code = d.district_code
                            AND d.state_code = s.state_code
                            LEFT JOIN
                        mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1
                            WHERE 
                        ps.return_type = '$returnType'  AND ps.return_date = '$from_date' AND tfs.is_latest = 1";
            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND ps.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND ps.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
			$sql.=" order by ps.mineral_name,s.state_name,d.district_name,ps.return_date,ps.mine_code,ps.stone_sn ";
			
            //print_r($sql);die;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $lprint=$this->generatea11($records,$showDate,$rowCount);
                $this->set('lprint',$lprint);					
                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }
	public function generatea11($records,$showDate,$rowCount) {
        $lcnt=-1;
        $cnt=0;
        $lmineral_name = "";
        $lstate_name = "";
        $ldistrict_name = "";
        $lmonthnm = "";
        $lyearnm = "";
        $lmincode="";
		$lmetal_content="";
		$lserialno="";
        $lflg="";
		$lcounter=0;

		$marray=array();	//metal content
		$rarray=array();	//rough and uncut array
		$carray=array();	//Cut & Polished Stones array
		$iarray=array();	//Industrial array
		$oarray=array();	//Others array
		$lmcnt=-1;
		$locnt=-1;
		$lpcnt=-1;
		$lscnt=-1;
		$lccnt=-1;
		
		if($rowCount <= 15000) {
		$print='<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="tHeadFont" id="heading1">Report A11 - Precious & Semi Precious Stone Ex-Mine Price Details (Form F3)</h4>
                    <div class="form-horizontal">
                        <div class="card-body" id="avb">
							<h6 class="tHeadDate"  id="heading2">Year : '.$showDate.'</h6>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" id="tableReport">
                                    <thead class="tableHead">
                                        <tr>
                                            <th rowspan="3">#</th>
                                            <th rowspan="3">Year</th>  
											<th rowspan="3">Mineral</th>
                                            <th rowspan="3">State</th>
                                            <th rowspan="3">District</th>  
                                            <th rowspan="3">Name of Mine</th>
                                            <th rowspan="3">Name of Lease Owner</th>
                                            <th rowspan="3">Lease Area</th>
											<th rowspan="3">Mine Code</th>
                                            <th rowspan="3">IBM Registration Number</th>
                                            <th colspan="4"> Ex Mine Price</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Gem Variety</th>
                                            <th rowspan="2">Industrial</th>
                                            <th  rowspan="2">Others</th>
                                        </tr>
                                        <tr>
                                             <th>Rough & Uncut Stones</th>
                                            <th >Cut & Polished Stones</th>
                                        </tr>                                        
                                    </thead>
                                    <tbody class="tableBody">';
        foreach ($records as $record) {
            if ($lmineral_name != $record['mineral_name']) {
                $lmineral_name = $record['mineral_name'];
                $lflg="Y";
            }
            if ($lstate_name != $record['state_name']) {
                $lstate_name = $record['state_name'];
                $lflg="Y";
            }
            if ($ldistrict_name != $record['district_name']) {
                $ldistrict_name = $record['district_name'];
                $lflg="Y";
            }
            if ($lmonthnm != $record['showMonth']) {
                $lmonthnm  = $record['showMonth'];
                $lflg="Y";
            }
            if ($lyearnm != $record['showYear']) {
                $lyearnm  = $record['showYear'];
                $lflg="Y";
            }
            if ($lmincode!=$record['mine_code']) {
                $lmincode=$record['mine_code'];
                $lflg="Y";
            }
            //if ($lmetal_content!=$record['metal_content']) {
            //    $lflg="Y";
                
            //} 
            if ($lflg=="Y" || $lcnt <0) {
				if ($lcnt>=0) {
					$larcount=count($rarray);
					if (count($carray)>$larcount) $larcount=count($carray);
					if (count($iarray)>$larcount) $larcount=count($iarray);
					if (count($oarray)>$larcount) $larcount=count($oarray);
					$lrowspan="";
					if ($larcount>1) 
						$lrowspan=" rowspan=".$larcount."";
					
					$lcounter+=1;
					$print.='<tr>
						<td '.$lrowspan.'>'.$lcounter.'</td>
						<td '.$lrowspan.'>'.$record['year1'].'</td>	
						<td '.$lrowspan.'>'.$mineral_name.'</td>
						<td '.$lrowspan.'>'.$state_name.'</td>
						<td '.$lrowspan.'>'.$district_name.'</td>
						<td '.$lrowspan.'>'.$MINE_NAME.'</td>
						<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
						<td '.$lrowspan.'>'.$lease_area.'</td>
						<td '.$lrowspan.'>'.$mine_code.'</td>
						<td '.$lrowspan.'>'.$registration_no.'</td>';
					for ($cnt=0; $cnt < $larcount; $cnt++) {
						if ($cnt >0) 
							$print.='<tr>';
						//1 start
						$print.="<td>";
						if (isset($rarray[$cnt]['no']))
							$print.=$rarray[$cnt]['no'];
						$print.="</td>";
						//1 end
						//2 start
						$print.="<td>";
						if (isset($carray[$cnt]['no']))
							$print.=$carray[$cnt]['no'];
						$print.="</td>";
						//2 end
						//3 start
						$print.="<td>";
						if (isset($iarray[$cnt]['no']))
							$print.=$iarray[$cnt]['no'];
						$print.="</td>";
						//3 end
						//99 start
						$print.="<td>";
						if (isset($oarray[$cnt]['no']))
							$print.=$oarray[$cnt]['no'];
						$print.="</td>";
						//99 end
					}
					if ($cnt >0) $print.='</tr>';
						
				}
                $lcnt++;
                $lflg="";
                $cnt=0;
				
                $mineral_name=ucwords(str_replace('_', ' ', $record['mineral_name']));
                $state_name=$record['state_name']; 
                $district_name=$record['district_name']; 
                $MINE_NAME=$record['MINE_NAME'] ;
                $lessee_owner_name=$record['lessee_owner_name'];
                $lease_area=$record['lease_area'];
                $mine_code=$record['mine_code'];
                $registration_no=$record['registration_no'];
				//$lmetal_content=$record['metal_content'];
				$marray=array();	//metal content
				$rarray=array();	//rough and uncut array
				$carray=array();	//Cut & Polished Stones array
				$iarray=array();	//Industrial array
				$oarray=array();	//Others array
				$lmcnt=-1;
				$locnt=-1;
				$lpcnt=-1;
				$lscnt=-1;
				$lccnt=-1;
			}

			if ($record['stone_sn']==1) {
				$locnt+=1;
				$rarray[$locnt]['no']=$record['pmv_oc'];
			}
			if ($record['stone_sn']==2) {
				$lpcnt+=1;
				$carray[$lpcnt]['no']=$record['pmv_oc'];
			}
			if ($record['stone_sn']==3) {
				$lscnt+=1;
				$iarray[$lscnt]['no']=$record['pmv_oc'];

			}
			if ($record['stone_sn']==99) {
				$lccnt+=1;
				$oarray[$lccnt]['no']=$record['pmv_oc'];
			}

		}
		if ($lcnt>=0) {
			$larcount=count($rarray);
			if (count($carray)>$larcount) $larcount=count($carray);
			if (count($iarray)>$larcount) $larcount=count($iarray);
			if (count($oarray)>$larcount) $larcount=count($oarray);
			$lrowspan="";
			if ($larcount>1) 
				$lrowspan=" rowspan=".$larcount."";
			
			$lcounter+=1;
			$print.='<tr>
				<td '.$lrowspan.'>'.$lcounter.'</td>
				<td '.$lrowspan.'>'.$record['year1'].'</td>	
				<td '.$lrowspan.'>'.$mineral_name.'</td>
				<td '.$lrowspan.'>'.$state_name.'</td>
				<td '.$lrowspan.'>'.$district_name.'</td>
				<td '.$lrowspan.'>'.$MINE_NAME.'</td>
				<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
				<td '.$lrowspan.'>'.$lease_area.'</td>
				<td '.$lrowspan.'>'.$mine_code.'</td>
				<td '.$lrowspan.'>'.$registration_no.'</td>';
			for ($cnt=0; $cnt < $larcount; $cnt++) {
				if ($cnt >0) 
					$print.='<tr>';
				//$print.="<td>";
				//if (isset($marray[$cnt]['cont']))
				//	$print.=$marray[$cnt]['cont'];
				//$print.="</td>";						
				//1 start
				$print.="<td>";
				if (isset($rarray[$cnt]['no']))
					$print.=$rarray[$cnt]['no'];
				$print.="</td>";
				//1 end
				//2 start
				$print.="<td>";
				if (isset($carray[$cnt]['no']))
					$print.=$carray[$cnt]['no'];
				$print.="</td>";
				//2 end
				//3 start
				$print.="<td>";
				if (isset($iarray[$cnt]['no']))
					$print.=$iarray[$cnt]['no'];
				$print.="</td>";
				//3 end
				//99 start
				$print.="<td>";
				if (isset($oarray[$cnt]['no']))
					$print.=$oarray[$cnt]['no'];
				$print.="</td>";
				//99 end
			}
			if ($cnt >0) $print.='</tr>';
				
		}
		$print.= '</tbody>
		</table>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>';
		} else {
			$print='<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="tHeadFont" id="heading1">Report A11 - Precious & Semi Precious Stone Ex-Mine Price Details (Form F3)</h4>
                    <div class="form-horizontal">
                        <div class="card-body" id="avb">
							<h6 class="tHeadDate"  id="heading2">Year : '.$showDate.'</h6>
							
							<h6 class="tHeadDate" id="heading2"><strong>Since records are more hence no search & pagination service is available, you may use the option "Export to Excel"</strong></h6>
							<input type="button" id="downloadExcel" value="Export to Excel">
							<br /><br />
								
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered compact" border="1" id="noDatatable">
                                    <thead class="tableHead">
										<tr>
											<th colspan="14" class="noDisplay" align="left">Report A11 - Precious & Semi Precious Stone Ex-Mine Price Details (Form F3)  Year : '.$showDate.'</th>
										</tr>
                                        <tr>
                                            <th rowspan="3">#</th>
                                            <th rowspan="3">Year</th>  
											<th rowspan="3">Mineral</th>
                                            <th rowspan="3">State</th>
                                            <th rowspan="3">District</th>  
                                            <th rowspan="3">Name of Mine</th>
                                            <th rowspan="3">Name of Lease Owner</th>
                                            <th rowspan="3">Lease Area</th>
											<th rowspan="3">Mine Code</th>
                                            <th rowspan="3">IBM Registration Number</th>
                                            <th colspan="4"> Ex Mine Price</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Gem Variety</th>
                                            <th rowspan="2">Industrial</th>
                                            <th  rowspan="2">Others</th>
                                        </tr>
                                        <tr>
                                             <th>Rough & Uncut Stones</th>
                                            <th >Cut & Polished Stones</th>
                                        </tr>                                        
                                    </thead>
                                    <tbody class="tableBody">';
        foreach ($records as $record) {
            if ($lmineral_name != $record['mineral_name']) {
                $lmineral_name = $record['mineral_name'];
                $lflg="Y";
            }
            if ($lstate_name != $record['state_name']) {
                $lstate_name = $record['state_name'];
                $lflg="Y";
            }
            if ($ldistrict_name != $record['district_name']) {
                $ldistrict_name = $record['district_name'];
                $lflg="Y";
            }
            if ($lmonthnm != $record['showMonth']) {
                $lmonthnm  = $record['showMonth'];
                $lflg="Y";
            }
            if ($lyearnm != $record['showYear']) {
                $lyearnm  = $record['showYear'];
                $lflg="Y";
            }
            if ($lmincode!=$record['mine_code']) {
                $lmincode=$record['mine_code'];
                $lflg="Y";
            }
            //if ($lmetal_content!=$record['metal_content']) {
            //    $lflg="Y";
                
            //} 
            if ($lflg=="Y" || $lcnt <0) {
				if ($lcnt>=0) {
					$larcount=count($rarray);
					if (count($carray)>$larcount) $larcount=count($carray);
					if (count($iarray)>$larcount) $larcount=count($iarray);
					if (count($oarray)>$larcount) $larcount=count($oarray);
					$lrowspan="";
					if ($larcount>1) 
						$lrowspan=" rowspan=".$larcount."";
					
					$lcounter+=1;
					$print.='<tr>
						<td '.$lrowspan.'>'.$lcounter.'</td>
						<td '.$lrowspan.'>'.$record['year1'].'</td>	
						<td '.$lrowspan.'>'.$mineral_name.'</td>
						<td '.$lrowspan.'>'.$state_name.'</td>
						<td '.$lrowspan.'>'.$district_name.'</td>
						<td '.$lrowspan.'>'.$MINE_NAME.'</td>
						<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
						<td '.$lrowspan.'>'.$lease_area.'</td>
						<td '.$lrowspan.'>'.$mine_code.'</td>
						<td '.$lrowspan.'>'.$registration_no.'</td>';
					for ($cnt=0; $cnt < $larcount; $cnt++) {
						if ($cnt >0) 
							$print.='<tr>';
						//1 start
						$print.="<td>";
						if (isset($rarray[$cnt]['no']))
							$print.=$rarray[$cnt]['no'];
						$print.="</td>";
						//1 end
						//2 start
						$print.="<td>";
						if (isset($carray[$cnt]['no']))
							$print.=$carray[$cnt]['no'];
						$print.="</td>";
						//2 end
						//3 start
						$print.="<td>";
						if (isset($iarray[$cnt]['no']))
							$print.=$iarray[$cnt]['no'];
						$print.="</td>";
						//3 end
						//99 start
						$print.="<td>";
						if (isset($oarray[$cnt]['no']))
							$print.=$oarray[$cnt]['no'];
						$print.="</td>";
						//99 end
					}
					if ($cnt >0) $print.='</tr>';
						
				}
                $lcnt++;
                $lflg="";
                $cnt=0;
				
                $mineral_name=ucwords(str_replace('_', ' ', $record['mineral_name']));
                $state_name=$record['state_name']; 
                $district_name=$record['district_name']; 
                $MINE_NAME=$record['MINE_NAME'] ;
                $lessee_owner_name=$record['lessee_owner_name'];
                $lease_area=$record['lease_area'];
                $mine_code=$record['mine_code'];
                $registration_no=$record['registration_no'];
				//$lmetal_content=$record['metal_content'];
				$marray=array();	//metal content
				$rarray=array();	//rough and uncut array
				$carray=array();	//Cut & Polished Stones array
				$iarray=array();	//Industrial array
				$oarray=array();	//Others array
				$lmcnt=-1;
				$locnt=-1;
				$lpcnt=-1;
				$lscnt=-1;
				$lccnt=-1;
			}

			if ($record['stone_sn']==1) {
				$locnt+=1;
				$rarray[$locnt]['no']=$record['pmv_oc'];
			}
			if ($record['stone_sn']==2) {
				$lpcnt+=1;
				$carray[$lpcnt]['no']=$record['pmv_oc'];
			}
			if ($record['stone_sn']==3) {
				$lscnt+=1;
				$iarray[$lscnt]['no']=$record['pmv_oc'];

			}
			if ($record['stone_sn']==99) {
				$lccnt+=1;
				$oarray[$lccnt]['no']=$record['pmv_oc'];
			}

		}
		if ($lcnt>=0) {
			$larcount=count($rarray);
			if (count($carray)>$larcount) $larcount=count($carray);
			if (count($iarray)>$larcount) $larcount=count($iarray);
			if (count($oarray)>$larcount) $larcount=count($oarray);
			$lrowspan="";
			if ($larcount>1) 
				$lrowspan=" rowspan=".$larcount."";
			
			$lcounter+=1;
			$print.='<tr>
				<td '.$lrowspan.'>'.$lcounter.'</td>
				<td '.$lrowspan.'>'.$record['year1'].'</td>	
				<td '.$lrowspan.'>'.$mineral_name.'</td>
				<td '.$lrowspan.'>'.$state_name.'</td>
				<td '.$lrowspan.'>'.$district_name.'</td>
				<td '.$lrowspan.'>'.$MINE_NAME.'</td>
				<td '.$lrowspan.'>'.$lessee_owner_name.'</td>
				<td '.$lrowspan.'>'.$lease_area.'</td>
				<td '.$lrowspan.'>'.$mine_code.'</td>
				<td '.$lrowspan.'>'.$registration_no.'</td>';
			for ($cnt=0; $cnt < $larcount; $cnt++) {
				if ($cnt >0) 
					$print.='<tr>';
				//$print.="<td>";
				//if (isset($marray[$cnt]['cont']))
				//	$print.=$marray[$cnt]['cont'];
				//$print.="</td>";						
				//1 start
				$print.="<td>";
				if (isset($rarray[$cnt]['no']))
					$print.=$rarray[$cnt]['no'];
				$print.="</td>";
				//1 end
				//2 start
				$print.="<td>";
				if (isset($carray[$cnt]['no']))
					$print.=$carray[$cnt]['no'];
				$print.="</td>";
				//2 end
				//3 start
				$print.="<td>";
				if (isset($iarray[$cnt]['no']))
					$print.=$iarray[$cnt]['no'];
				$print.="</td>";
				//3 end
				//99 start
				$print.="<td>";
				if (isset($oarray[$cnt]['no']))
					$print.=$oarray[$cnt]['no'];
				$print.="</td>";
				//99 end
			}
			if ($cnt >0) $print.='</tr>';
				
		}
		$print.= '</tbody>
		</table>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>';
		}
	
		return $print;
	}

    public function reportA12()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower(str_replace(' ', '_', $mineral));
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            $sql = "SELECT DISTINCT rr.mine_code, rr.mineral_name, m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name,
            d.district_name, '$from_year' AS year1, '$next_year' AS year2, rr.proved_balance, rr.probable_first_balance, ml.mcmdt_ML_Area AS lease_area,
            rr.feasibility_balance , rr.prefeasibility_first_balance , rr.prefeasibility_sec_balance , rr.measured_sec_balance , rr.indicated_sec_balance , rr.inferred_sec_balance , rr.reconnaissance_sec_balance, '$showDate' AS showDate
            FROM
				tbl_final_submit tfs
					INNER JOIN
                mine m ON tfs.mine_code = m.mine_code
                    INNER JOIN
                dir_state s ON m.state_code = s.state_code
                    INNER JOIN
                dir_district d ON m.district_code = d.district_code
                    AND d.state_code = s.state_code
                    INNER JOIN
                reserves_resources rr ON m.mine_code = rr.mine_code
					AND tfs.mine_code = rr.mine_code
					AND tfs.return_date = rr.return_date
					AND tfs.return_type = rr.return_type
                    AND rr.return_type = '$returnType'
                    AND rr.return_date = '$from_date'
                    LEFT JOIN
				mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode
					AND rr.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1
            WHERE
                rr.return_type = '$returnType' AND rr.return_date = '$from_date' AND tfs.is_latest = 1 ";

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND rr.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND rr.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
           //print_r($sql);exit;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA13()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower(str_replace(' ', '_', $mineral));
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            $sql = "SELECT DISTINCT smr.mine_code, smr.mineral_name, m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name,
            d.district_name, '$from_year' AS year1, '$next_year' AS year2, smr.unprocessed_begin, smr.unprocessed_generated, smr.unprocessed_disposed, smr.unprocessed_total,
            smr.unprocessed_average, smr.processed_begin, smr.processed_generated, smr.processed_disposed, smr.processed_total,
            smr.processed_average, ml.mcmdt_ML_Area AS lease_area, '$showDate' AS showDate
            FROM
				tbl_final_submit tfs
					INNER JOIN
                mine m ON tfs.mine_code = m.mine_code
                    INNER JOIN
                dir_state s ON m.state_code = s.state_code
                    INNER JOIN
                dir_district d ON m.district_code = d.district_code
                    AND d.state_code = s.state_code
                    INNER JOIN
                subgrade_mineral_reject smr ON m.mine_code = smr.mine_code
					AND tfs.mine_code = smr.mine_code
					AND tfs.return_date = smr.return_date
					AND tfs.return_type = smr.return_type
                    AND smr.return_type = '$returnType'
                    AND smr.return_date = '$from_date'
                    LEFT JOIN
                        mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode
                    AND smr.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1
            WHERE
                smr.return_type = '$returnType' AND smr.return_date = '$from_date' AND tfs.is_latest = 1";

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND smr.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND smr.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
            //print_r($sql);exit;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA14()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $next_year = $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower($mineral);
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            $sql = "SELECT DISTINCT tps.mine_code, mw.mineral_name, m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name,
            d.district_name, '$from_year' AS year1, '$next_year' AS year2, tps.trees_wi_lease, tps.surv_wi_lease, tps.ttl_eoy_wi_lease, tps.trees_os_lease,
            tps.surv_os_lease, tps.ttl_eoy_os_lease, ml.mcmdt_ML_Area AS lease_area, '$showDate' AS showDate
            FROM
				tbl_final_submit tfs
					INNER JOIN
                mine m ON tfs.mine_code = m.mine_code
                    INNER JOIN
                dir_state s ON m.state_code = s.state_code
                    INNER JOIN
                dir_district d ON m.district_code = d.district_code
                    AND d.state_code = s.state_code
                    INNER JOIN
                trees_plant_survival tps ON m.mine_code = tps.mine_code
					AND tfs.return_type = tps.return_type
					AND tfs.return_date = tps.return_date
                    AND tps.return_type = '$returnType'
                    AND tps.return_date = '$from_date'
                    INNER JOIN
                mineral_worked mw ON tps.mine_code = mw.mine_code
                    AND m.mine_code = mw.mine_code
                    LEFT JOIN
                mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode
                    AND tps.mine_code = ml.mcmdt_mineCode
                    AND mw.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1
            WHERE
                tps.return_type = '$returnType' AND tps.return_date = '$from_date' AND tfs.is_latest = 1";

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND mw.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND tps.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
            // print_r($sql);exit;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA15()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower($mineral);
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            $sql = " SELECT DISTINCT cp.exploration_cost, cp.mining_cost, cp.beneficiation_cost, cp.overhead_cost, cp.depreciation_cost,
            cp.interest_cost, cp.royalty_cost, cp.past_pay_dmf, cp.past_pay_nmet, cp.taxes_cost, cp.dead_rent_cost, cp.others_cost, cp.mine_code,
            cp.total_cost, m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, '$from_year' AS year1, '$next_year' AS year2, mw.mineral_name,
             ml.mcmdt_ML_Area AS lease_area, '$showDate' AS showDate
            FROM
			tbl_final_submit tfs
					INNER JOIN
				cost_production cp ON tfs.mine_code = cp.mine_code
					AND tfs.return_type = cp.return_type
					AND tfs.return_date = cp.return_date
					AND tfs.return_date = '$from_date'
					AND tfs.return_type = '$returnType'
                    INNER JOIN
                mine m ON cp.mine_code = m.mine_code
                    INNER JOIN
                dir_state s ON m.state_code = s.state_code
                    INNER JOIN
                dir_district d ON m.district_code = d.district_code
                    AND s.state_code = d.state_code
                    INNER JOIN
                mineral_worked mw ON cp.mine_code = mw.mine_code
                    AND m.mine_code = mw.mine_code
                     LEFT JOIN
				mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode
                    AND cp.mine_code = ml.mcmdt_mineCode
                    AND mw.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1
            WHERE
                cp.return_date = '$from_date' AND cp.return_type = '$returnType' AND tfs.is_latest = 1";

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND mw.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND cp.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
             //prINT_R($sql);exit;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA16()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower($mineral);
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            $sql = "SELECT DISTINCT lr.forest_abandoned_area, lr.non_forest_abandoned_area, lr.total_abandoned_area, lr.forest_working_area, lr.non_forest_working_area,
            lr.total_working_area, lr.forest_reclaimed_area, lr.non_forest_reclaimed_area, lr.total_reclaimed_area, lr.forest_waste_area, lr.non_forest_waste_area,
            lr.total_waste_area, lr.forest_building_area, lr.non_forest_building_area, lr.total_building_area, lr.forest_other_area, lr.non_forest_other_area,
            lr.total_other_area, lr.forest_progressive_area, lr.non_forest_progressive_area, lr.total_progressive_area, lr.mine_code, m.MINE_NAME,
            m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, '$from_year' AS year1, '$next_year' AS year2, mw.mineral_name, ml.mcmdt_ML_Area AS lease_area, '$showDate' AS showDate
            FROM
                tbl_final_submit tfs
					INNER JOIN 
				lease_return lr ON lr.mine_code = tfs.mine_code
					AND tfs.return_date = lr.return_date
					AND tfs.return_type = lr.return_type
					AND tfs.return_date = '$from_date'
					AND tfs.return_type = '$returnType'
                    INNER JOIN
                mine m ON lr.mine_code = m.mine_code
                    INNER JOIN
                dir_state s ON m.state_code = s.state_code
                    INNER JOIN
                dir_district d ON m.district_code = d.district_code
                    AND s.state_code = d.state_code
                    INNER JOIN
                mineral_worked mw ON lr.mine_code = mw.mine_code
                    AND m.mine_code = mw.mine_code
                     LEFT JOIN
				mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode
					AND lr.mine_code = ml.mcmdt_mineCode
					AND mw.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1
            WHERE
                lr.return_date = '$from_date' AND lr.return_type = '$returnType' AND tfs.is_latest = 1";

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND mw.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND lr.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
            //print_r($sql);exit;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA17()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower($mineral);
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');
						
            $sql = "SELECT DISTINCT m.mining_engineer_name, m.geologist_name,  rr.no_work_days, rr.mine_code, mw.mineral_name,
            m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, '$from_year' AS year1, '$next_year' AS year2,
            ml.mcmdt_ML_Area AS lease_area, '$showDate' AS showDate
            FROM
               tbl_final_submit tfs
					INNER JOIN
				rent_returns rr ON tfs.mine_code = rr.mine_code
					AND tfs.return_date = rr.return_date
					AND tfs.return_type = rr.return_type
					AND tfs.return_date = '$from_date'
					AND tfs.return_type = '$returnType'
                    INNER JOIN
                mine m ON rr.mine_code = m.mine_code
                    INNER JOIN
                mineral_worked mw ON rr.mine_code = mw.mine_code
                    AND m.mine_code = mw.mine_code
                    INNER JOIN
                dir_state s ON m.state_code = s.state_code
                    INNER JOIN
                dir_district d ON m.district_code = d.district_code
                    AND s.state_code = d.state_code
                    LEFT JOIN
				mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode
					AND rr.mine_code = ml.mcmdt_mineCode
					AND mw.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1
            WHERE
                rr.return_date = '$from_date' AND rr.return_type = '$returnType' AND tfs.is_latest = 1 AND rr.no_work_days is not null";

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND mw.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND rr.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
             //print_r($sql);exit;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA18()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From " . $from_year . ' To ' . $from_year + 1;
            $mineral = $this->request->getData('mineral');
            $mineral = strtolower($mineral);
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $minecode = $this->request->getData('minecode');
            if ($minecode != '') {
                $minecode = implode('\', \'', $minecode);
            }
            $minename = $this->request->getData('minename');
            $owner = $this->request->getData('owner');
            $lesseearea = $this->request->getData('lesseearea');
            $ibm = $this->request->getData('ibm');

            $con = ConnectionManager::get('default');

            $sql = "SELECT DISTINCT dr.machinery_name, mc.capacity, mc.unit_no, mc.no_of_machinery, mc.oc_machinery, mw.mineral_name, m.MINE_NAME,
            m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, '$from_year' AS year1, '$next_year' AS year2, mc.mine_code,  ml.mcmdt_ML_Area AS lease_area, '$showDate' AS showDate,
            CASE
                WHEN mc.electrical_machinery = 1 THEN 'Electrical'
                WHEN mc.electrical_machinery = 2 THEN 'Non Electrical'
            END AS electrical_machinery,
            CASE
                WHEN mc.oc_machinery = 1 THEN 'Open Cast'
                WHEN mc.oc_machinery = 2 THEN 'Underground'
                WHEN mc.oc_machinery = 3 THEN 'Both'
            END AS oc_machinery
            FROM
                tbl_final_submit tfs
					INNER JOIN
				machinery mc ON tfs.mine_code = mc.mine_code
					AND tfs.return_date = mc.return_date
					AND tfs.return_type = mc.return_type
					AND tfs.return_date = '$from_date'
					AND tfs.return_type = '$returnType'
                    INNER JOIN
                mine m ON mc.mine_code = m.mine_code
                    AND mc.return_type = '$returnType'
                    AND mc.return_date = '$from_date'
                    LEFT JOIN
                dir_machinery dr ON dr.machinery_code = SUBSTRING_INDEX(mc.machinery_code, '-', 1)
                    INNER JOIN
                dir_state s ON m.state_code = s.state_code
                    INNER JOIN
                dir_district d ON m.district_code = d.district_code
                    AND s.state_code = d.state_code
                    INNER JOIN
                mineral_worked mw ON mw.mine_code = mc.mine_code
                    AND m.mine_code = mw.mine_code
                    LEFT JOIN
				mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode
					AND mc.mine_code = ml.mcmdt_mineCode
					AND mw.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1
            WHERE
                mc.return_date = '$from_date' AND mc.return_type = '$returnType' AND tfs.is_latest = 1 AND dr.machinery_name IS NOT NULL";

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND mw.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND mc.mine_code IN('$minecode')";
            }
            if ($ibm != '') {
                $sql .= " AND m.registration_no  = '$ibm'";
            }
            if ($minename != '') {
                $sql .= " AND m.MINE_NAME = '$minename'";
            }
            if ($owner != '') {
                $sql .= "  AND m.lessee_owner_name = '$owner'";
            }
            if ($lesseearea != '') {
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
             //prINT_R($sql);exit;
            $query = $con->execute($sql);
			
			// To count number of records
			$count = count($query);
			$rowCount = $query->rowCount();
			
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate', $showDate);
				$this->set('rowCount',$rowCount);
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "report-list";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }
	
	
	public function userLoginStatus(){
		
		$this->loadModel('PasswordHistory');
		$this->loadModel('McUserLog');
		$this->loadModel('McUser');
			
		$this->viewBuilder()->setLayout('report_layout');
		$update_date = '';
		$userid = '';
		$status = '';
		$email = '';
		$logid = '';
		
		if ($this->request->is('post')) {
			
			if($this->request->getData('submit') == 'Unblock'){
				
				$getid = $this->request->getData('logid');
				
				$result = $this->McUserLog->newEntity(array(
					'id'=>$getid,
					'status'=>'SUCCESS'					
				));
				
				$this->McUserLog->save($result);
				
				$userid = $this->request->getData('uname');
			
			}else{
				
				$userid = $this->request->getData('userid');	
			}
			
			$userDetails = $this->McUser->find('all',array('fields'=>array('mcu_sha_password','mcu_email'),'conditions'=>array('mcu_child_user_name IS'=>$userid)))->first();
			if(empty($userDetails)){
				$status = 'User Not Exist';
			}else{
				
				$email = $userDetails['mcu_email'];
				
				$resetpassword = explode('-',$userDetails['mcu_sha_password']);
				if(count($resetpassword) > 1){					
					$status = 'Forgot Password';
					$update_date = strtotime($resetpassword[0]);
				
				}else{
					
					$userLog = $this->McUserLog->find('all',array('fields'=>array('status','login_time','id'),'conditions'=>array('uname IS'=>$userid),'order'=>'id desc'))->first();
					
					if($userLog['status'] == 'LOCKED'){
						
						$status = 'User Blocked';
						//$update_date = date("d/m/Y h:i:s:A",strtotime('+330 minutes',strtotime($userLog['login_time'])));
						$update_date = $userLog['login_time'];
						$logid = $userLog['id'];
						
					}else{
						$changepassword = $this->PasswordHistory->find('all',array('fields'=>array('password','created'),'conditions'=>array('username IS'=>$userid,'user_type IS'=>'auth'),'order'=>'id desc'))->first();
						
						if(empty($changepassword)){
							$status = 'Old Password Set';
						}else{
							if($changepassword['password'] == $userDetails['mcu_sha_password']){
								$status = 'New Password Set';
								$update_date = $changepassword['created'];
							}else{
								$status = 'Old Password Set';
							}
						}
					}
				
				}
			}
		}
		
		$this->set('status',$status);
		$this->set('update_date',$update_date);
		$this->set('userid',$userid);
		$this->set('email',$email);
		$this->set('logid',$logid);
	}
}
