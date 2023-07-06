<?php 
    namespace app\Model\Table;
    use Cake\ORM\Table;
    use App\Model\Model;
    use Cake\ORM\TableRegistry;
    use Cake\Datasource\ConnectionManager;
    use Cake\Core\Configure;
    
    class TblMinWorkedTable extends Table{

        var $name = "TblMinWorked";
        public $validate = array();
        
        // set default connection string
        public static function defaultConnectionName(): string {
          return Configure::read('conn');
        }

        public function checkDBForAnnualFinalSubmit($mineCode, $returnDate, $mineralName) {

          $q = $this->find()
              ->where(['mine_code'=>$mineCode])
              ->where(['return_date'=>$returnDate])
              ->where(['mineral_name'=>$mineralName])
              ->count();
      
          $result = $q;
          if ($result > 0)
            return 1;
          else
            return 0;

        }

        public function getFormData($mineCode, $returnDate, $minName) {

            $selected_ores = array();
            $constDetails = array();
            $qtyDetails = array();
            $gradeDetails = array();
            //get min worked details
            $q = $this->find()
                    ->select(['ore_lump', 'ore_fines', 'ore_granular', 'ore_friable', 'ore_platy', 'ore_fibrous', 'ore_other'])
                    ->where(['mine_code'=>$mineCode])
                    ->where(['mineral_name'=>$minName])
                    ->where(['return_date'=>$returnDate])
                    ->toArray();
        
            if (count($q) > 0) {
                $selected_ores['ore_lump'] = $q[0]['ore_lump'];
                $selected_ores['ore_fines'] = $q[0]['ore_fines'];
                $selected_ores['ore_granular'] = $q[0]['ore_granular'];
                $selected_ores['ore_friable'] = $q[0]['ore_friable'];
                $selected_ores['ore_platy'] = $q[0]['ore_platy'];
                $selected_ores['ore_fibrous'] = $q[0]['ore_fibrous'];
                $selected_ores['ore_other'] = $q[0]['ore_other'];
            }
        
            //get constituent table details
	          // $typicalRejectAnal = TableRegistry::getTableLocator()->get('TypicalRejectAnal');
            // $const = $typicalRejectAnal->find()
            //       ->select(['ore_type', 'grade_sn', 'size_range', 'size_range_grade', 
            //         'principal_const', 'principal_const_grade',
            //         'subsidiary_const', 'subsidiary_const_grade'])
            //       ->where(['mine_code'=>$mineCode])
            //       ->where(['mineral_name'=>$minName])
            //       ->where(['return_date'=>$returnDate])
            //       ->toArray();

            $connection = ConnectionManager::get(Configure::read('conn'));
            $const = $connection->execute("SELECT ore_type, grade_sn, size_range, size_range_grade, principal_const, principal_const_grade, subsidiary_const, subsidiary_const_grade FROM TYPICAL_REJECT_ANAL WHERE mine_code = '$mineCode' AND mineral_name = '$minName' AND return_date = '$returnDate'")->fetchAll('assoc');
        
            $grade_sns = array();
            $ores = array();
          
            /**
            * BELOW FIRST ARRAY IS CREATED FOR GETTING THE ORE TYPE AS THE OUTPUT OF VERY FIRST QUERY IN THIS FUNCTION 
            * IS USING NAME FOR CHECKING THE CHECK BOX SELECTED BY THE USER WHILE FILING THE FORM
            * NEXT ARRAY IS CREATED FOR GETING THE SERIAL NUMBER OF THESE ORE TYPES AS THIS WILL HELP WHILE CREATING THE 
            * ARRAY
            * @author Uday Shankar Singh
            * @version 26th June 2014
            **/
          
            $nameArray = array(
                '1' => 'ore_lump',
                '2' => 'ore_fines',
                '3' => 'ore_granular',
                '4' => 'ore_friable',
                '5' => 'ore_platy',
                '6' => 'ore_fibrous',
                '7' => 'ore_other'
            );
        
            $checkBoxNoArray = array(
                'ore_lump' => '1',
                'ore_fines' => '2',
                'ore_granular' => '3',
                'ore_friable' => '4',
                'ore_platy' => '5',
                'ore_fibrous' => '6',
                'ore_other' => '7'
            );
          
            /**
            * THE BELOW CODE IS ADDED FOR THE CASES IN WHICH THE FORM  1/2 IS FILLED BY THE USER USING LOWER VERSION OF
            * IE IN WHICH THE VALIDATION OF THE FORM ARE NOT WORKING.
            * THIS CONDITION WILL ONLY BE TRUE FOR THESE TYPES OF CASES ELSE THIS CONDITION WILL ALWAYS BE FALSE FOR FUTURE RETURNS
            * 
            * BELOW I AM JUST SETTING THE VALUES OF THE FIELDS THAT ARE REQUIRED IN THE JS TO RUN THE LOOP SO THAT PLEASE WAIT  CIRCLE WILL 
            * GO AWAY
            * @author Uday Shankar Singh
            * @version 26th June 2014
            *
            * THE WHOLE IF CONDITION IS NEW AND THE CODE IN THE ELSE WAS HERE IN PLACE OF THIS IF CONDITION
            **/
            if(empty($const)){
                foreach($nameArray as $checkSelected){
                    if(isset($selected_ores[$checkSelected]) && $selected_ores[$checkSelected] != ""){
                    
                        $ot = $checkBoxNoArray[$checkSelected];
                        $g = 1;
                  
                        if (isset($c['size_range']) && $c['size_range'] != "") {
                          $constDetails[$ot][$g]['size_range'] = "";
                          $constDetails[$ot][$g]['size_range_grade'] = "";
                          $constDetails[$ot][$g]['principal_const'] = "";
                          $constDetails[$ot][$g]['principal_const_grade'] = "";
                        } else {
                          $constDetails[$ot][$g]['subsidiary_const'][] = "";
                          $constDetails[$ot][$g]['subsidiary_const_grade'][] = "";
                        }
                  
                        $grade_sns[$ot] = (isset($grade_sns[$ot])) ? $grade_sns[$ot] : array();
                        if (!in_array($g, $grade_sns[$ot])) {
                          $grade_sns[$ot][] = $g;
                        }
                  
                        if (!in_array($ot, $ores)) {
                          $ores[] = $ot;
                        }
                  
                        // to find the count of contituent tables for each ore in js side
                        $constDetails[$ot]['total_const_tables'] = count($grade_sns[$ot]);
                    }
                }
            } else{
                foreach ($const as $c) {
                    $ot = $c['ore_type'];
                    $g = $c['grade_sn'];
              
                    if ($c['size_range'] != "") {
                      $constDetails[$ot][$g]['size_range'] = $c['size_range'];
                      $constDetails[$ot][$g]['size_range_grade'] = $c['size_range_grade'];
                      $constDetails[$ot][$g]['principal_const'] = $c['principal_const'];
                      $constDetails[$ot][$g]['principal_const_grade'] = $c['principal_const_grade'];
                    } else {
                      $constDetails[$ot][$g]['subsidiary_const'][] = $c['subsidiary_const'];
                      $constDetails[$ot][$g]['subsidiary_const_grade'][] = $c['subsidiary_const_grade'];
                    }
              
                    $grade_sns[$ot] = (isset($grade_sns[$ot])) ? $grade_sns[$ot] : array();
                    if (!in_array($g, $grade_sns[$ot])) {
                      $grade_sns[$ot][] = $g;
                    }
              
                    if (!in_array($ot, $ores)) {
                      $ores[] = $ot;
                    }
              
                    // to find the count of contituent tables for each ore in js side
                    $constDetails[$ot]['total_const_tables'] = count($grade_sns[$ot]);
                }
            }
            
            //get quantity table details
	          $tblGeologyQuantity = TableRegistry::getTableLocator()->get('TblGeologyQuantity');
            $qty = $tblGeologyQuantity->find()
                    ->select(['ore_type', 'rock', 'min_excavated', 'constituent_analysis'])
                    ->where(['mine_code'=>$mineCode])
                    ->where(['mineral_name'=>$minName])
                    ->where(['return_date'=>$returnDate])
                    ->toArray();
        
            foreach ($qty as $cq) {
              $ot = $cq['ore_type'];
              $qtyDetails['rock'] = $cq['rock'];
              $qtyDetails['min_excavated'] = $cq['min_excavated'];
              $qtyDetails['const_analysis'] = $cq['constituent_analysis'];
            }
        
            //get grade % table details
	          $tblGeologyGrade = TableRegistry::getTableLocator()->get('TblGeologyGrade');
            $grade = $tblGeologyGrade->find()
                    ->select(['ore_type', 'constituent_analysis', 'grade_percent'])
                    ->where(['mine_code'=>$mineCode])
                    ->where(['mineral_name'=>$minName])
                    ->where(['return_date'=>$returnDate])
                    ->toArray();
        
            foreach ($grade as $g) {
              $ot = $g['ore_type'];
              $gradeDetails['const_analysis'][] = $g['constituent_analysis'];
              $gradeDetails['grade_percent'][] = $g['grade_percent'];
            }
        
            $data['min_worked'] = $selected_ores;
            $data['const_details'] = $constDetails;
            $data['qty_details'] = $qtyDetails;
            $data['grade_details'] = $gradeDetails;
            $data['total_ores'] = $ores;
            
            return $data;
            
        }

	  }
?>