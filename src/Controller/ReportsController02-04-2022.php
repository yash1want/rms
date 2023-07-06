<?php

namespace App\Controller;

use Cake\Datasource\ConnectionManager;

class ReportsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadModel('DirMeMineral');
        $this->loadModel('DirState');
		
		$this->userSessionExits();
    }

    public function reportList()
    {
        $this->viewBuilder()->setLayout('report_layout');
    }

    public function monthlyFilter()
    {
        $title = $this->request->getQuery('title');
		$subtype = null;
		
		if($title == "report-M01a"){
			$title = "report-M01";
			$subtype= "1";
		}
		if($title == "report-M01b"){
			$title = "report-M01";
			$subtype= "2";
		}
		
		$this->set('subtype', $subtype);		
        $this->set('title', $title);

        $this->viewBuilder()->setLayout('report_layout');

        $queryMineral = $this->DirMeMineral->find('list', [
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
        $this->set('title', $title);

        $this->viewBuilder()->setLayout('report_layout');

        $queryMineral = $this->DirMeMineral->find('list', [
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

    public function reportM01()
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
			$subtype = $this->request->getData('subtype');
			 
			
				if($subtype == '2'){
					
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
									'' as grade_name	";									
									
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
									mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode ";					
										
					$conditions = " WHERE m1.return_type = '$returnType' AND (m1.return_date BETWEEN '$from_date' AND '$to_date')
									AND (m1.mineral_name != 'iron_ore' and m1.mineral_name != 'chromite')";
					
				}else{
					
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
											END) AS `quantity`  ";
											
											
						$joins = " FROM
									view_report_grade_rom_m01 m1						
										LEFT JOIN
									grade_sale gs ON m1.mine_code = gs.mine_code
										AND m1.mine_code = gs.mine_code
										AND (gs.return_date BETWEEN '$from_date' AND '$to_date')
										AND gs.return_type = '$returnType'
										AND gs.mineral_name = m1.mineral_name
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
								 mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode ";					
											
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
           //print_r($sql);exit;
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate',$showDate);
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
             //print_r($sql);exit;
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate',$showDate);
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

    public function reportM03()
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

            $sql = "SELECT DISTINCT p.open_oc_rom, p.open_ug_rom, p.open_dw_rom, p.clos_oc_rom, p.clos_ug_rom, p.clos_dw_rom, p.mine_code, p.prod_oc_rom, p.prod_ug_rom, p.prod_dw_rom,
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
                AND (gp.return_date BETWEEN '$from_date' AND '$to_date') AND tfs.is_latest = 1";

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
                $sql .= " AND ml.mcmdt_ML_Area = '$lesseearea'";
            }
             //print_r($sql);exit;
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
				$this->set('showDate',$showDate);
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

    public function reportM04()
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

            $sql = "SELECT DISTINCT r5.mineral_name, r5.mine_code, m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name,
            d.district_name, '$from' AS fromDate , '$to' As toDate, (ml.under_forest_area + ml.outside_forest_area) AS lease_area, EXTRACT(MONTH FROM rs.return_date)  AS showMonth, EXTRACT(YEAR FROM rs.return_date)  AS showYear,
            CASE
                WHEN r5.rom_5_step_sn = 10 THEN r5.tot_qty
            END AS open_stock_qty,
            CASE
                WHEN r5.rom_5_step_sn = 10 THEN r5.metal_content
            END AS open_stock_metal,
             CASE
                WHEN r5.rom_5_step_sn = 10 THEN r5.grade
            END AS open_stock_metal_grade,
            CASE
                WHEN r5.rom_5_step_sn = 11 THEN r5.tot_qty
            END AS ore_rec_qty,
            CASE
                WHEN r5.rom_5_step_sn = 11 THEN r5.metal_content
            END AS ore_rec_metal,
            CASE
                WHEN r5.rom_5_step_sn = 11 THEN  r5.grade
            END AS ore_rec_metal_grade,
            CASE
                WHEN r5.rom_5_step_sn = 12 THEN r5.tot_qty
            END AS ore_treat_qty,
            CASE
                WHEN r5.rom_5_step_sn = 12 THEN r5.metal_content
            END AS ore_treat_metal,
             CASE
                WHEN r5.rom_5_step_sn = 12 THEN r5.grade
            END AS ore_treat_metal_grade,
            CASE
                WHEN r5.rom_5_step_sn = 13 THEN r5.tot_qty
            END AS concentrate_obtain_qty,
            CASE
                WHEN r5.rom_5_step_sn = 13 THEN r5.metal_content
            END AS concentrate_obtain_metal,
             CASE
                WHEN r5.rom_5_step_sn = 13 THEN  r5.grade
            END AS concentrate_obtain_metal_grade,
            CASE
                WHEN r5.rom_5_step_sn = 14 THEN r5.tot_qty
            END AS tail_qty,
            CASE
                WHEN r5.rom_5_step_sn = 14 THEN r5.metal_content
            END AS tail_metal,
            CASE
                WHEN r5.rom_5_step_sn = 14 THEN r5.grade
            END AS tail_metal_grade,
            CASE
                WHEN r5.rom_5_step_sn = 15 THEN r5.tot_qty
            END AS clos_stock_qty,
            CASE
                WHEN r5.rom_5_step_sn = 15 THEN r5.metal_content
            END AS clos_stock_metal,
             CASE
                WHEN r5.rom_5_step_sn = 15 THEN r5.grade
            END AS clos_stock_metal_grade,
            CASE
                WHEN rs.smelter_step_sn = 1 THEN rs.qty
            END AS qyt_open_smelter,
            CASE
                WHEN rs.smelter_step_sn = 1 THEN rs.grade
            END AS metal_open_smelter,
			(CASE
				WHEN (`rs`.`smelter_step_sn` = 1) THEN `rs`.`type_concentrate`
			END) AS `qyt_open_smelter_metal`,
            CASE
                WHEN rs.smelter_step_sn = 2 THEN rs.qty
            END AS concentrate_rec_qty,
            CASE
                WHEN rs.smelter_step_sn = 2 THEN rs.grade
            END AS concentrate_rec_metal,
			(CASE
            WHEN (`rs`.`smelter_step_sn` = 3) THEN `rs`.`qty`
			END) AS `concentrate_other_src_qty`,
			(CASE
				WHEN (`rs`.`smelter_step_sn` = 3) THEN `rs`.`grade`
			END) AS `concentrate_other_src_grade`,
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
			(CASE
            WHEN (`rs`.`smelter_step_sn` = 7) THEN `rs`.`type_concentrate`
				END) AS `other_prod_grade_metal`,
            CASE
                WHEN rs.smelter_step_sn = 6 THEN rs.qty
            END AS metal_recover_qty,
            CASE
                WHEN rs.smelter_step_sn = 6 THEN rs.grade
            END AS metal_recover_grade,
			(CASE
				WHEN (`rs`.`smelter_step_sn` = 6) THEN `rs`.`type_concentrate`
			END) AS `metal_recover_qty_metal`,
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
                    AND (r5.return_date BETWEEN '$from_date' AND '$to_date')
                    AND r5.return_type = '$returnType'
                    INNER JOIN
                recov_smelter rs ON rs.mine_code = r5.mine_code
                    AND (rs.return_date BETWEEN '$from_date' AND '$to_date')
                    AND rs.return_type = '$returnType'
                    AND r5.return_type = rs.return_type
                    AND r5.return_date = rs.return_date
                    LEFT JOIN
                mcp_lease ml ON m.mine_code = ml.mine_code
                    AND r5.mine_code = ml.mine_code
                    AND rs.mine_code = ml.mine_code
            WHERE
                r5.return_type = '$returnType' AND (rs.return_date BETWEEN '$from_date' AND '$to_date')";
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
             //print_r($sql);exit;
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
				$this->set('showDate',$showDate);
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

    public function reportM05()
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

            $sql = "SELECT DISTINCT gs.client_type, gs.client_name, gs.client_reg_no, gs.quantity, gs.sale_value, dc.country_name AS expo_country, gs.expo_quantity,
            ml.mcmdt_ML_Area AS lease_area, gs.expo_fob, gs.mine_code, gs.mineral_name, m.MINE_NAME,
            m.lessee_owner_name, m.registration_no, dmg.grade_name, s.state_name, d.district_name, '$from' AS fromDate , '$to' As toDate, EXTRACT(MONTH FROM gs.return_date)  AS showMonth, EXTRACT(YEAR FROM gs.return_date)  AS showYear
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
                    AND (gs.return_date BETWEEN '$from_date' AND '$to_date')					
					LEFT JOIN 
				dir_country dc ON gs.expo_country = dc.id
                    LEFT JOIN
                 mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode 
                    AND gs.mine_code = ml.mcmdt_mineCode
                    INNER JOIN
                dir_mineral_grade dmg ON gs.grade_code = dmg.grade_code
                    AND gs.mineral_name = REPLACE(LOWER(dmg.mineral_name), ' ', '_')
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
            // pr($sql);exit;
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
				$this->set('showDate',$showDate);
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

    public function reportM06()
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
            // pr($sql);exit;
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
				$this->set('showDate',$showDate);
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

    public function reportM07()
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
                    AND mw.mine_code = ml.mcmdt_mineCode
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
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
				$this->set('showDate',$showDate);
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
            $sql = "SELECT DISTINCT rs.mine_code, rs.mineral_name, m.MINE_NAME, m.lessee_owner_name, m.registration_no, ml.mcmdt_ML_Area AS lease_area,
            s.state_name, d.district_name, rs.oc_type, rs.oc_qty, rs.ug_type, rs.ug_qty, '$from' AS fromDate , '$to' As toDate, EXTRACT(MONTH FROM rs.return_date)  AS showMonth, EXTRACT(YEAR FROM rs.return_date)  AS showYear
            FROM
                mine m
                    INNER JOIN
                dir_state s ON m.state_code = s.state_code
                    INNER JOIN
                dir_district d ON m.district_code = d.district_code
                    AND d.state_code = s.state_code
                    INNER JOIN
                rom_stone rs ON m.mine_code = rs.mine_code
                    AND rs.return_type = '$returnType'
                    AND (rs.return_date BETWEEN '$from_date' AND '$to_date')
					 LEFT JOIN
				tbl_final_submit tfs ON tfs.mine_code = rs.mine_code
					AND tfs.return_date = rs.return_date
                    AND tfs.return_type = rs.return_type
                    AND tfs.is_latest = 1
                    LEFT JOIN
                 mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode 
                    AND rs.mine_code = ml.mcmdt_mineCode
            WHERE
                rs.return_type = '$returnType' AND (rs.return_date BETWEEN '$from_date' AND '$to_date')";

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
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
                $this->set('showDate',$showDate);
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

    public function reportM09()
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
				$this->set('showDate',$showDate);
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

    public function reportM10()
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
				$this->set('showDate',$showDate);
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

    public function reportM11()
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
				$this->set('showDate',$showDate);
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

    public function reportA01()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $showDate = "From ".$from_year . ' To ' . $from_year + 1;
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

            $con = ConnectionManager::get('default');

            $sql = "SELECT DISTINCT p.open_oc_rom, p.open_ug_rom, p.open_dw_rom, gp.despatches, gs.sale_value, gp.mine_code,
            gp.mineral_name, m.MINE_NAME, m.lessee_owner_name, m.registration_no, dmg.grade_name, s.state_name, d.district_name,
            (p.trans_cost + p.loading_charges + p.railway_freight + p.port_handling + p.sampling_cost + p.plot_rent + p.other_cost) AS detail_deduction,
            gp.pmv, '$from_year' AS year1, $next_year AS year2, (ml.under_forest_area + ml.outside_forest_area) AS lease_area,'$showDate' AS showDate
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
                grade_sale gs ON p.mine_code = gs.mine_code
                    AND m.mine_code = gs.mine_code
                    AND gp.mine_code = gs.mine_code
                    AND gs.return_type = '$returnType'
                    AND gs.return_date = '$from_date'
                    AND p.mineral_name = gs.mineral_name
                    AND gp.mineral_name = gs.mineral_name
                    AND gp.return_date = gs.return_date
                    AND gp.return_type = gs.return_type
                    AND p.return_date = gs.return_date
                    AND p.return_type = gs.return_type
                    LEFT JOIN
                mcp_lease ml ON m.mine_code = ml.mine_code
                    AND gp.mine_code = ml.mine_code
                    AND p.mine_code = ml.mine_code
                    AND gs.mine_code = ml.mine_code
                    INNER JOIN
                dir_mineral_grade dmg ON gp.grade_code = dmg.grade_code
                    AND gp.mineral_name = REPLACE(LOWER(dmg.mineral_name),' ','_')
                    AND gs.mineral_name = REPLACE(LOWER(dmg.mineral_name),' ','_')
                    AND p.mineral_name = REPLACE(LOWER(dmg.mineral_name),' ','_')
                WHERE
                gp.return_type = '$returnType' AND gp.return_date = '$from_date' AND p.return_type = '$returnType' AND p.return_date = '$from_date'
                AND gs.return_type = '$returnType' AND gs.return_date = '$from_date'";

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND gp.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND gp.mine_code IN('$minecode')";
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
            //  pr($sql);exit;
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');
            if (!empty($records)) {
                $this->set('records', $records);
				$this-->set('showDate',$showDate);
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
            $showDate = "From ".$from_year . ' To ' . $from_year + 1;
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

            $sql = "SELECT DISTINCT gp.opening_stock, gp.production, gp.closing_stock, gp.despatches, gs.sale_value, gp.mine_code, gp.mineral_name,
            m.MINE_NAME, m.lessee_owner_name, m.registration_no, dmg.grade_name, s.state_name, d.district_name,
            (p.trans_cost + p.loading_charges + p.railway_freight + p.port_handling + p.sampling_cost + p.plot_rent + p.other_cost) AS detail_deduction,
            gp.pmv, '$from_year' AS year1, $next_year AS year2, (ml.under_forest_area + ml.outside_forest_area) AS lease_area, '$showDate' AS showDate
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
                grade_sale gs ON p.mine_code = gs.mine_code
                    AND m.mine_code = gs.mine_code
                    AND gp.mine_code = gs.mine_code
                    AND gs.return_type = '$returnType'
                    AND gs.return_date = '$from_date'
                    AND p.mineral_name = gs.mineral_name
                    AND gp.mineral_name = gs.mineral_name
                    AND gp.return_date = gs.return_date
                    AND gp.return_type = gs.return_type
                    AND p.return_date = gs.return_date
                    AND p.return_type = gs.return_type
                    INNER JOIN
                dir_mineral_grade dmg ON gp.grade_code = dmg.grade_code
                    AND gp.mineral_name = REPLACE(LOWER(dmg.mineral_name), ' ', '_')
                    AND gs.mineral_name = REPLACE(LOWER(dmg.mineral_name), ' ', '_')
                    AND p.mineral_name = REPLACE(LOWER(dmg.mineral_name), ' ', '_')
                    LEFT JOIN
                mcp_lease ml ON m.mine_code = ml.mine_code
                    AND gp.mine_code = ml.mine_code
                    AND gs.mine_code = ml.mine_code
                    AND p.mine_code = ml.mine_code
                WHERE
                gp.return_type = '$returnType' AND gp.return_date = '$from_date' AND gs.return_type = '$returnType' AND gs.return_date = '$from_date'
                AND p.return_type = '$returnType' AND p.return_date = '$from_date'";

            if ($state != '') {
                $sql .= " AND m.state_code = '$state'";
            }
            if ($district != '') {
                $sql .= " AND m.district_code = '$district'";
            }
            if ($mineral != '') {
                $sql .= " AND gp.mineral_name = '$mineral'";
            }
            if ($minecode != '') {
                $sql .= " AND gp.mine_code IN('$minecode')";
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
    }

    public function reportA03()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From ".$from_year . ' To ' . $from_year + 1;
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
    }

    public function reportA04()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From ".$from_year . ' To ' . $from_year + 1;
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
            d.district_name, '$from_year' AS year1, $next_year AS year2, (ml.under_forest_area + ml.outside_forest_area) AS lease_area, '$showDate' AS showDate,
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
    }

    public function reportA05()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From ".$from_year . ' To ' . $from_year + 1;
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
    }

    public function reportA06()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From ".$from_year . ' To ' . $from_year + 1;
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
    }

    public function reportA07()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From ".$from_year . ' To ' . $from_year + 1;
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

            $sql = "SELECT DISTINCT rr.past_surface_rent, rr.past_royalty, rr.past_dead_rent, rr.past_pay_dmf, rr.past_pay_nmet, rr.mine_code,
            mw.mineral_name, m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, '$from_year' AS year1, $next_year AS year2,
            (ml.under_forest_area + ml.outside_forest_area) AS lease_area, '$showDate' AS showDate
            FROM
                mine m
                    INNER JOIN
                dir_state s ON m.state_code = s.state_code
                    INNER JOIN
                dir_district d ON m.district_code = d.district_code
                    AND s.state_code = d.state_code
                    INNER JOIN
                rent_returns rr ON m.mine_code = rr.mine_code
                    AND rr.return_type = '$returnType'
                    AND rr.return_date = '$from_date'
                    INNER JOIN
                mineral_worked mw ON rr.mine_code = mw.mine_code
                    AND m.mine_code = mw.mine_code
                    LEFT JOIN
                mcp_lease ml ON m.mine_code = ml.mine_code
                    AND rr.mine_code = ml.mine_code
                    AND mw.mine_code = ml.mine_code
            WHERE
                rr.return_type = '$returnType' AND rr.return_date = '$from_date'";

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
    }

    public function reportA08()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From ".$from_year . ' To ' . $from_year + 1;
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

            $sql = "SELECT DISTINCT rs.mine_code, rs.mineral_name, m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name,
            d.district_name, rs.oc_type, rs.oc_qty, rs.ug_type, rs.ug_qty, '$from_year' AS year1, $next_year AS year2, (ml.under_forest_area + ml.outside_forest_area) AS lease_area, '$showDate' AS showDate
            FROM
                mine m
                    INNER JOIN
                dir_state s ON m.state_code = s.state_code
                    INNER JOIN
                dir_district d ON m.district_code = d.district_code
                    AND d.state_code = s.state_code
                    INNER JOIN
                rom_stone rs ON m.mine_code = rs.mine_code
                    AND rs.return_type = '$returnType'
                    AND rs.return_date = '$from_date'
                    LEFT JOIN
                mcp_lease ml ON m.mine_code = ml.mine_code
                    AND rs.mine_code = ml.mine_code
            WHERE
                rs.return_type = '$returnType' AND rs.return_date = '$from_date'";

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
    }

    public function reportA09()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From ".$from_year . ' To ' . $from_year + 1;
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
    }

    public function reportA10()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From ".$from_year . ' To ' . $from_year + 1;
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
    }

    public function reportA11()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From ".$from_year . ' To ' . $from_year + 1;
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
    }

    public function reportA12()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From ".$from_year . ' To ' . $from_year + 1;
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
            d.district_name, '$from_year' AS year1, $next_year AS year2, rr.proved_balance, rr.probable_first_balance, (ml.under_forest_area + ml.outside_forest_area) AS lease_area,
            SUM(rr.feasibility_balance + rr.prefeasibility_first_balance + rr.prefeasibility_sec_balance + rr.measured_sec_balance + rr.indicated_sec_balance + rr.inferred_sec_balance + rr.reconnaissance_sec_balance) AS resources, '$showDate' AS showDate
            FROM
                mine m
                    INNER JOIN
                dir_state s ON m.state_code = s.state_code
                    INNER JOIN
                dir_district d ON m.district_code = d.district_code
                    AND d.state_code = s.state_code
                    INNER JOIN
                reserves_resources rr ON m.mine_code = rr.mine_code
                    AND rr.return_type = '$returnType'
                    AND rr.return_date = '$from_date'
                    LEFT JOIN
                mcp_lease ml ON m.mine_code = ml.mine_code
                    AND rr.mine_code = ml.mine_code
            WHERE
                rr.return_type = '$returnType' AND rr.return_date = '$from_date'";

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
    }

    public function reportA13()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From ".$from_year . ' To ' . $from_year + 1;
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
            d.district_name, '$from_year' AS year1, $next_year AS year2, smr.unprocessed_begin, smr.unprocessed_generated, smr.unprocessed_disposed, smr.unprocessed_total,
            smr.unprocessed_average, smr.processed_begin, smr.processed_generated, smr.processed_disposed, smr.processed_total,
            smr.processed_average, (ml.under_forest_area + ml.outside_forest_area) AS lease_area, '$showDate' AS showDate
            FROM
                mine m
                    INNER JOIN
                dir_state s ON m.state_code = s.state_code
                    INNER JOIN
                dir_district d ON m.district_code = d.district_code
                    AND d.state_code = s.state_code
                    INNER JOIN
                subgrade_mineral_reject smr ON m.mine_code = smr.mine_code
                    AND smr.return_type = '$returnType'
                    AND smr.return_date = '$from_date'
                    LEFT JOIN
                mcp_lease ml ON m.mine_code = ml.mine_code
                    AND smr.mine_code = ml.mine_code
            WHERE
                smr.return_type = '$returnType' AND smr.return_date = '$from_date'";

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
    }

    public function reportA14()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $showDate = "From ".$from_year . ' To ' . $from_year + 1;
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

            $con = ConnectionManager::get('default');

            $sql = "SELECT DISTINCT tps.mine_code, mw.mineral_name, m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name,
            d.district_name, '$from_year' AS year1, '$next_year' AS year2, tps.trees_wi_lease, tps.surv_wi_lease, tps.ttl_eoy_wi_lease, tps.trees_os_lease,
            tps.surv_os_lease, tps.ttl_eoy_os_lease, (ml.under_forest_area + ml.outside_forest_area) AS lease_area, '$showDate' AS showDate
            FROM
                mine m
                    INNER JOIN
                dir_state s ON m.state_code = s.state_code
                    INNER JOIN
                dir_district d ON m.district_code = d.district_code
                    AND d.state_code = s.state_code
                    INNER JOIN
                trees_plant_survival tps ON m.mine_code = tps.mine_code
                    AND tps.return_type = '$returnType'
                    AND tps.return_date = '$from_date'
                    INNER JOIN
                mineral_worked mw ON tps.mine_code = mw.mine_code
                    AND m.mine_code = mw.mine_code
                    LEFT JOIN
                mcp_lease ml ON m.mine_code = ml.mine_code
                    AND tps.mine_code = ml.mine_code
                    AND mw.mine_code = ml.mine_code
            WHERE
                tps.return_type = '$returnType' AND tps.return_date = '$from_date'";

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
    }

    public function reportA15()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From ".$from_year . ' To ' . $from_year + 1;
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

            $sql = " SELECT DISTINCT cp.exploration_cost, cp.mining_cost, cp.beneficiation_cost, cp.overhead_cost, cp.depreciation_cost,
            cp.interest_cost, cp.royalty_cost, cp.past_pay_dmf, cp.past_pay_nmet, cp.taxes_cost, cp.dead_rent_cost, cp.others_cost, cp.mine_code,
            cp.total_cost, m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, '$from_year' AS year1, $next_year AS year2, mw.mineral_name,
            (ml.under_forest_area + ml.outside_forest_area) AS lease_area, '$showDate' AS showDate
            FROM
                cost_production cp
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
                mcp_lease ml ON m.mine_code = ml.mine_code
                    AND cp.mine_code = ml.mine_code
                    AND mw.mine_code = ml.mine_code
            WHERE
                cp.return_date = '$from_date' AND cp.return_type = '$returnType'";

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
    }

    public function reportA16()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From ".$from_year . ' To ' . $from_year + 1;
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

            $sql = "SELECT DISTINCT lr.forest_abandoned_area, lr.non_forest_abandoned_area, lr.total_abandoned_area, lr.forest_working_area, lr.non_forest_working_area,
            lr.total_working_area, lr.forest_reclaimed_area, lr.non_forest_reclaimed_area, lr.total_reclaimed_area, lr.forest_waste_area, lr.non_forest_waste_area,
            lr.total_waste_area, lr.forest_building_area, lr.non_forest_building_area, lr.total_building_area, lr.forest_other_area, lr.non_forest_other_area,
            lr.total_other_area, lr.forest_progressive_area, lr.non_forest_progressive_area, lr.total_progressive_area, lr.mine_code, m.MINE_NAME,
            m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, '$from_year' AS year1, $next_year AS year2, mw.mineral_name, (ml.under_forest_area + ml.outside_forest_area) AS lease_area, '$showDate' AS showDate
            FROM
                lease_return lr
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
                mcp_lease ml ON m.mine_code = ml.mine_code
                    AND lr.mine_code = ml.mine_code
                    AND mw.mine_code = ml.mine_code
            WHERE
                lr.return_date = '$from_date' AND lr.return_type = '$returnType'";

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
    }

    public function reportA17()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From ".$from_year . ' To ' . $from_year + 1;
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

            $sql = "SELECT DISTINCT rr.wholly_employed_geologist, rr.partly_employed_geologist, rr.no_work_days, rr.mine_code, mw.mineral_name,
            m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, '$from_year' AS year1, $next_year AS year2,
            (ml.under_forest_area + ml.outside_forest_area) AS lease_area, '$showDate' AS showDate
            FROM
                rent_returns rr
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
                mcp_lease ml ON m.mine_code = ml.mine_code
                    AND rr.mine_code = ml.mine_code
                    AND mw.mine_code = ml.mine_code
            WHERE
                rr.return_date = '$from_date' AND rr.return_type = '$returnType'";

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
    }

    public function reportA18()
    {
        $this->viewBuilder()->setLayout('report_layout');
        if ($this->request->is('post')) {
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $from_date = $from_year . '-' . '04-01';
            $next_year = $from_year + 1;
            $showDate = "From ".$from_year . ' To ' . $from_year + 1;
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

            $sql = "SELECT DISTINCT dr.machinery_name, mc.capacity, mc.unit_no, mc.no_of_machinery, mc.oc_machinery, mw.mineral_name, m.MINE_NAME,
            m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, '$from_year' AS year1, $next_year AS year2, mc.mine_code, (ml.under_forest_area + ml.outside_forest_area) AS lease_area, '$showDate' AS showDate,
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
                machinery mc
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
                mcp_lease ml ON m.mine_code = ml.mine_code
                    AND mc.mine_code = ml.mine_code
                    AND mw.mine_code = ml.mine_code
            WHERE
                mc.return_date = '$from_date' AND mc.return_type = '$returnType'";

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
    }
}
