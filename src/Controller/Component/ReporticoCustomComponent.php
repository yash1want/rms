<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Datasource\ConnectionManager;

class ReporticoCustomComponent extends Component
{
    public static function getYearsCount($fromDate, $toDate)
    {
        $x = 0;
        $yearsCount = 0;
        while ($x == 0) {
            $start = date('Y', strtotime(date("Y-m-d", strtotime($fromDate)) . " +$yearsCount year"));
            $end = date("Y", strtotime($toDate));
            if ($start == $end)
                $x = 1;
            $yearsCount++;
        }
        echo $yearsCount;
        exit;
        return $yearsCount;
    }

    public static function getMonthsCount($fromDate, $toDate)
    {
        $x = 0;
        $monthsCount = 0;

        while ($x == 0) {
            $start = date('FY', strtotime(date("Y-m-d", strtotime($fromDate)) . " +$monthsCount month"));
            $end = date("FY", strtotime($toDate));
            if ($start == $end)
                $x = 1;
            $monthsCount++;
        }
        return $monthsCount;
    }

    public static function changeReportDateFormat($timestamp)
    {
        $date = explode(' ', $timestamp);
        $temp = explode('-', $date[0]);
        $formatted_date = $temp[2] . "-" . $temp[1] . "-01";

        return $formatted_date;
    }

    public static function getReportM02RegionWise($returnType, $status, $date, $business, $state, $district, $region)
    {
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_m02");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_m02` (
            `fname` varchar(255) NOT NULL,
            `mname` varchar(255) NOT NULL,
            `lname` varchar(255) NOT NULL,
            `address1` varchar(255) NOT NULL,
            `address2` varchar(255) NOT NULL,
            `address3` varchar(255) NOT NULL,
            `state` varchar(255) NOT NULL,
            `district` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `concession_code` varchar(255) NOT NULL,
            `applicant_id` varchar(255) NOT NULL,
            `state_name` varchar(255) NOT NULL,
            `district_name` varchar(255) NOT NULL,
            `region_code` varchar(255) NOT NULL,
            `region_name` varchar(255) NOT NULL,
            `nregion_code` varchar(255) NOT NULL,
            `ibm_unqiue_reg_no` varchar(255) NOT NULL,
            `return_type` varchar(255) NOT NULL,
            `status` varchar(255) NOT NULL,
            `return_date` varchar(255) NOT NULL,
            `activity` varchar(255) NOT NULL,
            `activity_name` varchar(255) NOT NULL,
            `status_name` varchar(255) NOT NULL,
            `district_total` varchar(255) DEFAULT NULL,
            `state_total` varchar(255) DEFAULT NULL,
            `region_total` varchar(255) DEFAULT NULL,
            `district_outof` varchar(255) DEFAULT NULL,
            `state_outof` varchar(255) DEFAULT NULL,
            `region_outof` varchar(255) DEFAULT NULL
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

		//print_r("CALL SP_Report_M02_regionWiseEnduser('$returnType',$status,'$date','$business','$state','$district','$region')"); exit;
        $query = $con->execute("CALL SP_Report_M02_regionWiseEnduser('$returnType',$status,'$date','$business','$state','$district','$region')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $fname = $record['mcappd_fname'];
            $mname = $record['mcappd_mname'];
            $lname = $record['mcappd_lastname'];
            $address1 = $record['mcappd_address1'];
            $address2 = $record['mcappd_address2'];
            $address3 = $record['mcappd_address3'];
            $state = $record['mcappd_state'];
            $district = $record['mcappd_district'];
            $email = $record['mcappd_email'];
            $concession_code = $record['mcappd_concession_code'];
            $applicant_id = $record['applicant_id'];
            $state_name = $record['state_name'];
            $district_name = $record['district_name'];
            $region_code = $record['region_code'];
            $region_name = $record['region_name'];
            $nregion_code = $record['mcappd_regioncode'];
            $ibm_unqiue_reg_no = $record['ibm_unique_reg_no'];
            $return_type = $record['return_type'];
            $return_date = $record['Date'];
            $status = $record['status'];
            $activity = $record['Activity'];
            $activity_name = $record['activity_name'];
            $status_name = $record['status'];

            $insert = $con->execute("INSERT INTO temp_reportico_report_m02 (fname, mname, lname, address1, address2, address3, state, district, email, concession_code, applicant_id, state_name, district_name, region_code, region_name, nregion_code, ibm_unqiue_reg_no, return_type, status, return_date, activity, activity_name, status_name) 
            VALUES (
                '$fname', '$mname', '$lname', '$address1', '$address2', '$address3', '$state', '$district', '$email', '$concession_code', '$applicant_id', '$state_name', '$district_name', '$region_code', '$region_name', '$nregion_code', '$ibm_unqiue_reg_no', '$return_type', '$status', '$return_date', '$activity', '$activity_name', '$status_name')");

            $update = $con->execute("UPDATE temp_reportico_report_m02 SET district_total = (SELECT COUNT(district) FROM temp_reportico_report_m02 WHERE district = $district) WHERE district = $district");
            $update = $con->execute("UPDATE temp_reportico_report_m02 SET state_total = (SELECT COUNT(state) FROM temp_reportico_report_m02 WHERE state = '$state') WHERE state = '$state'");
            $update = $con->execute("UPDATE temp_reportico_report_m02 SET region_total = (SELECT COUNT(region_code) FROM temp_reportico_report_m02 WHERE region_code = $region_code) WHERE region_code = $region_code");
            $update = $con->execute("UPDATE temp_reportico_report_m02 SET district_outof = (SELECT COUNT(mcappd_district) FROM mc_applicant_det WHERE mcappd_district = $district) WHERE district = $district");
            $update = $con->execute("UPDATE temp_reportico_report_m02 SET state_outof = (SELECT COUNT(mcappd_state) FROM mc_applicant_det WHERE mcappd_state = '$state') WHERE state = '$state'");
            $update = $con->execute("UPDATE temp_reportico_report_m02 SET region_outof = (SELECT COUNT(mcappd_regioncode) FROM mc_applicant_det WHERE mcappd_regioncode = $region_code) WHERE region_code = $region_code");
        }
    }

    public static function getReportA03RegionWise($returnType, $status, $from_date, $business, $state, $district, $region)
    {
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A03");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A03` (
            `fname` varchar(255) DEFAULT NULL,
            `mname` varchar(255) DEFAULT NULL,
            `lname` varchar(255) DEFAULT NULL,
            `address1` varchar(255) DEFAULT NULL,
            `address2` varchar(255) DEFAULT NULL,
            `address3` varchar(255) DEFAULT NULL,
            `state` varchar(255) DEFAULT NULL,
            `district` varchar(255) DEFAULT NULL,
            `email` varchar(255) DEFAULT NULL,
            `concession_code` varchar(255) DEFAULT NULL,
            `applicant_id` varchar(255) DEFAULT NULL,
            `state_name` varchar(255) DEFAULT NULL,
            `district_name` varchar(255) DEFAULT NULL,
            `region_code` varchar(255) DEFAULT NULL,
            `region_name` varchar(255) DEFAULT NULL,
            `nregion_code` varchar(255) DEFAULT NULL,
            `ibm_unqiue_reg_no` varchar(255) DEFAULT NULL,
            `return_type` varchar(255) DEFAULT NULL,
            `status` varchar(255) DEFAULT NULL,
            `return_date` varchar(255) DEFAULT NULL,
            `activity` varchar(255) DEFAULT NULL,
            `activity_name` varchar(255) DEFAULT NULL,
            `status_name` varchar(255) DEFAULT NULL,
            `district_total` varchar(255) DEFAULT NULL,
            `state_total` varchar(255) DEFAULT NULL,
            `region_total` varchar(255) DEFAULT NULL,
            `district_outof` varchar(255) DEFAULT NULL,
            `state_outof` varchar(255) DEFAULT NULL,
            `region_outof` varchar(255) DEFAULT NULL
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A03_regionWiseEnduser('$returnType',$status,'$from_date','$business','$state','$district','$region')");
        $records = $query->fetchAll('assoc');
        $query->closeCursor();
		

        foreach ($records as $record) {
			$fname = $record['mcappd_fname'];
            $mname = $record['mcappd_mname'];
            $lname = $record['mcappd_lastname'];
            $address1 = $record['mcappd_address1'];
            $address2 = $record['mcappd_address2'];
            $address3 = $record['mcappd_address3'];
            $state = $record['mcappd_state'];
            $district = $record['mcappd_district'];
            $email = $record['mcappd_email'];
            $concession_code = $record['mcappd_concession_code'];
            $applicant_id = $record['applicant_id'];
            $state_name = $record['state_name'];
            $district_name = $record['district_name'];
            $region_code = $record['region_code'];
            $region_name = $record['region_name'];
            $nregion_code = $record['mcappd_regioncode'];
            $ibm_unqiue_reg_no = $record['ibm_unique_reg_no'];
            $return_type = $record['return_type'];
            $return_date = $record['Date'];
            $status = $record['status'];
            $activity = $record['Activity'];
            $activity_name = $record['activity_name'];
            $status_name = $record['status'];

            $insert = $con->execute("INSERT INTO temp_reportico_report_A03 (fname, mname, lname, address1, address2, address3, state, district, email, concession_code, applicant_id, state_name, district_name, region_code, region_name, nregion_code, ibm_unqiue_reg_no, return_type, status, return_date, activity, activity_name, status_name) 
            VALUES (
                '$fname', '$mname', '$lname', '$address1', '$address2', '$address3', '$state', '$district', '$email', '$concession_code','$applicant_id', '$state_name', '$district_name', '$region_code', '$region_name', '$nregion_code', '$ibm_unqiue_reg_no', '$return_type', '$status', '$return_date', '$activity', '$activity_name', '$status_name')");

            $update = $con->execute("UPDATE temp_reportico_report_A03 SET district_total = (SELECT COUNT(district) FROM temp_reportico_report_A03 WHERE district = $district) WHERE district = $district");
            $update = $con->execute("UPDATE temp_reportico_report_A03 SET state_total = (SELECT COUNT(state) FROM temp_reportico_report_A03 WHERE state = '$state') WHERE state = '$state'");
            $update = $con->execute("UPDATE temp_reportico_report_A03 SET region_total = (SELECT COUNT(region_code) FROM temp_reportico_report_A03 WHERE region_code = $region_code) WHERE region_code = $region_code");
            $update = $con->execute("UPDATE temp_reportico_report_A03 SET district_outof = (SELECT COUNT(mcappd_district) FROM mc_applicant_det WHERE mcappd_district = $district) WHERE district = $district");
            $update = $con->execute("UPDATE temp_reportico_report_A03 SET state_outof = (SELECT COUNT(mcappd_state) FROM mc_applicant_det WHERE mcappd_state = '$state') WHERE state = '$state'");
            $update = $con->execute("UPDATE temp_reportico_report_A03 SET region_outof = (SELECT COUNT(mcappd_regioncode) FROM mc_applicant_det WHERE mcappd_regioncode = $region_code) WHERE region_code = $region_code");
        }
    }

    public static function getReportM04StateWise($returnType, $status, $date, $business, $state, $district)
    {
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_M04");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_M04` (
            `fname` varchar(255) NOT NULL,
            `mname` varchar(255) NOT NULL,
            `lname` varchar(255) NOT NULL,
            `address1` varchar(255) NOT NULL,
            `address2` varchar(255) NOT NULL,
            `address3` varchar(255) NOT NULL,
            `state` varchar(255) NOT NULL,
            `district` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `concession_code` varchar(255) NOT NULL,
            `applicant_id` varchar(255) NOT NULL,
            `state_name` varchar(255) NOT NULL,
            `district_name` varchar(255) NOT NULL,
            `region_code` varchar(255) NOT NULL,
            `region_name` varchar(255) NOT NULL,
            `nregion_code` varchar(255) NOT NULL,
            `ibm_unqiue_reg_no` varchar(255) NOT NULL,
            `return_type` varchar(255) NOT NULL,
            `status` varchar(255) NOT NULL,
            `return_date` varchar(255) NOT NULL,
            `activity` varchar(255) NOT NULL,
            `activity_name` varchar(255) NOT NULL,
            `status_name` varchar(255) NOT NULL,
            `district_total` varchar(255) DEFAULT NULL,
            `state_total` varchar(255) DEFAULT NULL,
            `region_total` varchar(255) DEFAULT NULL,
            `district_outof` varchar(255) DEFAULT NULL,
            `state_outof` varchar(255) DEFAULT NULL,
            `region_outof` varchar(255) DEFAULT NULL
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_M04_stateWiseEnduser('$returnType',$status,'$date','$business','$state','$district')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $fname = $record['mcappd_fname'];
            $mname = $record['mcappd_mname'];
            $lname = $record['mcappd_lastname'];
            $address1 = $record['mcappd_address1'];
            $address2 = $record['mcappd_address2'];
            $address3 = $record['mcappd_address3'];
            $state = $record['mcappd_state'];
            $district = $record['mcappd_district'];
            $email = $record['mcappd_email'];
            $concession_code = $record['mcappd_concession_code'];
            $applicant_id = $record['applicant_id'];
            $state_name = $record['state_name'];
            $district_name = $record['district_name'];
            $region_code = $record['region_code'];
            $region_name = $record['region_name'];
            $nregion_code = $record['mcappd_regioncode'];
            $ibm_unqiue_reg_no = $record['ibm_unique_reg_no'];
            $return_type = $record['return_type'];
            $return_date = $record['Date'];
            $status = $record['status'];
            $activity = $record['Activity'];
            $activity_name = $record['activity_name'];
            $status_name = $record['status'];

            $insert = $con->execute("INSERT INTO temp_reportico_report_M04 (fname, mname, lname, address1, address2, address3, state, district, email, concession_code, applicant_id, state_name, district_name, region_code, region_name, nregion_code, ibm_unqiue_reg_no, return_type, status, return_date, activity, activity_name, status_name) 
            VALUES (
                '$fname', '$mname', '$lname', '$address1', '$address2', '$address3', '$state', '$district', '$email', '$concession_code', '$applicant_id', '$state_name', '$district_name', '$region_code', '$region_name', '$nregion_code', '$ibm_unqiue_reg_no', '$return_type', '$status', '$return_date', '$activity', '$activity_name', '$status_name')");

            $update = $con->execute("UPDATE temp_reportico_report_M04 SET district_total = (SELECT COUNT(district) FROM temp_reportico_report_M04 WHERE district = $district) WHERE district = $district");
            $update = $con->execute("UPDATE temp_reportico_report_M04 SET state_total = (SELECT COUNT(state) FROM temp_reportico_report_M04 WHERE state = '$state') WHERE state = '$state'");
            $update = $con->execute("UPDATE temp_reportico_report_M04 SET region_total = (SELECT COUNT(region_code) FROM temp_reportico_report_M04 WHERE region_code = $region_code) WHERE region_code = $region_code");
            $update = $con->execute("UPDATE temp_reportico_report_M04 SET district_outof = (SELECT COUNT(mcappd_district) FROM mc_applicant_det WHERE mcappd_district = $district) WHERE district = $district");
            $update = $con->execute("UPDATE temp_reportico_report_M04 SET state_outof = (SELECT COUNT(mcappd_state) FROM mc_applicant_det WHERE mcappd_state = '$state') WHERE state = '$state'");
            $update = $con->execute("UPDATE temp_reportico_report_M04 SET region_outof = (SELECT COUNT(mcappd_regioncode) FROM mc_applicant_det WHERE mcappd_regioncode = $region_code) WHERE region_code = $region_code");
        }
    }

    public static function getReportA05StateWise($returnType, $status, $from_date, $business, $state, $district)
    {
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A05");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A05` (
            `fname` varchar(255) NOT NULL,
            `mname` varchar(255) NOT NULL,
            `lname` varchar(255) NOT NULL,
            `address1` varchar(255) NOT NULL,
            `address2` varchar(255) NOT NULL,
            `address3` varchar(255) NOT NULL,
            `state` varchar(255) NOT NULL,
            `district` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `concession_code` varchar(255) NOT NULL,
            `applicant_id` varchar(255) NOT NULL,
            `state_name` varchar(255) NOT NULL,
            `district_name` varchar(255) NOT NULL,
            `region_code` varchar(255) NOT NULL,
            `region_name` varchar(255) NOT NULL,
            `nregion_code` varchar(255) NOT NULL,
            `ibm_unqiue_reg_no` varchar(255) NOT NULL,
            `return_type` varchar(255) NOT NULL,
            `status` varchar(255) NOT NULL,
            `return_date` varchar(255) NOT NULL,
            `activity` varchar(255) NOT NULL,
            `activity_name` varchar(255) NOT NULL,
            `status_name` varchar(255) NOT NULL,
            `district_total` varchar(255) DEFAULT NULL,
            `state_total` varchar(255) DEFAULT NULL,
            `region_total` varchar(255) DEFAULT NULL,
            `district_outof` varchar(255) DEFAULT NULL,
            `state_outof` varchar(255) DEFAULT NULL,
            `region_outof` varchar(255) DEFAULT NULL
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A05_stateWiseEnduser('$returnType',$status,'$from_date','$business','$state','$district')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $fname = $record['mcappd_fname'];
            $mname = $record['mcappd_mname'];
            $lname = $record['mcappd_lastname'];
            $address1 = $record['mcappd_address1'];
            $address2 = $record['mcappd_address2'];
            $address3 = $record['mcappd_address3'];
            $state = $record['mcappd_state'];
            $district = $record['mcappd_district'];
            $email = $record['mcappd_email'];
            $concession_code = $record['mcappd_concession_code'];
            $applicant_id = $record['applicant_id'];
            $state_name = $record['state_name'];
            $district_name = $record['district_name'];
            $region_code = $record['region_code'];
            $region_name = $record['region_name'];
            $nregion_code = $record['mcappd_regioncode'];
            $ibm_unqiue_reg_no = $record['ibm_unique_reg_no'];
            $return_type = $record['return_type'];
            $return_date = $record['Date'];
            $status = $record['status'];
            $activity = $record['Activity'];
            $activity_name = $record['activity_name'];
            $status_name = $record['status'];

            $insert = $con->execute("INSERT INTO temp_reportico_report_A05 (fname, mname, lname, address1, address2, address3, state, district, email, concession_code, applicant_id, state_name, district_name, region_code, region_name, nregion_code, ibm_unqiue_reg_no, return_type, status, return_date, activity, activity_name, status_name) 
            VALUES (
                '$fname', '$mname', '$lname', '$address1', '$address2', '$address3', '$state', '$district', '$email', '$concession_code', '$applicant_id', '$state_name', '$district_name', '$region_code', '$region_name', '$nregion_code', '$ibm_unqiue_reg_no', '$return_type', '$status', '$return_date', '$activity', '$activity_name', '$status_name')");

            $update = $con->execute("UPDATE temp_reportico_report_A05 SET district_total = (SELECT COUNT(district) FROM temp_reportico_report_A05 WHERE district = $district) WHERE district = $district");
            $update = $con->execute("UPDATE temp_reportico_report_A05 SET state_total = (SELECT COUNT(state) FROM temp_reportico_report_A05 WHERE state = '$state') WHERE state = '$state'");
            $update = $con->execute("UPDATE temp_reportico_report_A05 SET region_total = (SELECT COUNT(region_code) FROM temp_reportico_report_A05 WHERE region_code = $region_code) WHERE region_code = $region_code");
            $update = $con->execute("UPDATE temp_reportico_report_A05 SET district_outof = (SELECT COUNT(mcappd_district) FROM mc_applicant_det WHERE mcappd_district = $district) WHERE district = $district");
            $update = $con->execute("UPDATE temp_reportico_report_A05 SET state_outof = (SELECT COUNT(mcappd_state) FROM mc_applicant_det WHERE mcappd_state = '$state') WHERE state = '$state'");
            $update = $con->execute("UPDATE temp_reportico_report_A05 SET region_outof = (SELECT COUNT(mcappd_regioncode) FROM mc_applicant_det WHERE mcappd_regioncode = $region_code) WHERE region_code = $region_code");
        }
    }

    public static function getReportA06PlantWiseIndustryRegionWise($returnType, $from_date, $region, $industry, $ibm)
    {
        $region = implode(',', $region);
        $ibm = implode(',', $ibm);
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A06");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A06` (
            `fname` varchar(255) NOT NULL,
            `mname` varchar(255) NOT NULL,
            `lname` varchar(255) NOT NULL,
            `address1` varchar(255) NOT NULL,
            `address2` varchar(255) NOT NULL,
            `address3` varchar(255) NOT NULL,
            `concession_code` varchar(255) NOT NULL,
            `applicant_id` varchar(255) NOT NULL,
            `region_code` varchar(255) NOT NULL,
            `region_name` varchar(255) NOT NULL,
            `nregion_code` varchar(255) NOT NULL,
            `ibm_unqiue_reg_no` varchar(255) NOT NULL,
            `return_type` varchar(255) NOT NULL,
            `return_date` varchar(255) NOT NULL,
            `mcappd_officer_add1` varchar(255) NOT NULL,
            `mcappd_officer_add2` varchar(255) NOT NULL,
            `mcappd_officer_add3` varchar(255) NOT NULL,
            `prod_name` varchar(255) NOT NULL,
            `prod_annual_capacity` varchar(255) NOT NULL,
            `plant_name1` varchar(255) NOT NULL,
            `plant_name2` varchar(255) NOT NULL,
            `industry_name` varchar(255) NOT NULL,
            `district_total` varchar(255) DEFAULT NULL,
            `state_total` varchar(255) DEFAULT NULL,
            `region_total` varchar(255) DEFAULT NULL,
            `district_outof` varchar(255) DEFAULT NULL,
            `state_outof` varchar(255) DEFAULT NULL,
            `region_outof` varchar(255) DEFAULT NULL
            
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A06_Plantwise_Capacity_RegionWise('$returnType','$from_date','$region','$industry','$ibm')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $fname = $record['mcappd_fname'];
            $mname = $record['mcappd_mname'];
            $lname = $record['mcappd_lastname'];
            $address1 = $record['mcappd_address1'];
            $address2 = $record['mcappd_address2'];
            $address3 = $record['mcappd_address3'];
            $concession_code = $record['mcappd_concession_code'];
            $applicant_id = $record['applicant_id'];
            $region_code = $record['region_code'];
            $region_name = $record['region_name'];
            $nregion_code = $record['mcappd_regioncode'];
            $ibm_unqiue_reg_no = $record['ibm_unique_reg_no'];
            $return_type = $record['return_type'];
            $return_date = $record['Date'];
            $officer_add1 = $record['mcappd_officer_add1'];
            $officer_add2 = $record['mcappd_officer_add2'];
            $officer_add3 = $record['mcappd_officer_add3'];
            $prod_name = $record['prod_name'];
            $prod_annual_capacity = $record['prod_anual_capacity'];
            $plant_name1 = $record['plant_name1'];
            $plant_name2 = $record['plant_name2'];
            $industry_name = $record['industry_name'];
            $other_industry_name = $record['other_industry_name'];
            $industry_name_combine = $industry_name . ' ' . $other_industry_name;

            $insert = $con->execute("INSERT INTO temp_reportico_report_A06 (fname, mname, lname, address1, address2, address3, concession_code, applicant_id, region_code, region_name, nregion_code, ibm_unqiue_reg_no, return_type, return_date, mcappd_officer_add1, mcappd_officer_add2, mcappd_officer_add3, prod_name, prod_annual_capacity, plant_name1, plant_name2, industry_name) 
            VALUES (
                '$fname', '$mname', '$lname', '$address1', '$address2', '$address3', '$concession_code', '$applicant_id', '$region_code', '$region_name', '$nregion_code', '$ibm_unqiue_reg_no', '$return_type', '$return_date', '$officer_add1', '$officer_add2', '$officer_add3', '$prod_name', '$prod_annual_capacity', '$plant_name1', '$plant_name2','$industry_name_combine')");

            $update = $con->execute("UPDATE temp_reportico_report_A06 SET region_total = (SELECT COUNT(DISTINCT region_code) FROM temp_reportico_report_A06 WHERE region_code = $region_code) WHERE region_code = $region_code");
            $update = $con->execute("UPDATE temp_reportico_report_A06 SET region_outof = (SELECT COUNT(mcappd_regioncode) FROM mc_applicant_det WHERE mcappd_regioncode = $region_code) WHERE region_code = $region_code");
        }
    }

    public static function getReportA07PlantWiseIndustryStateWise($returnType, $from_date, $state, $industry, $ibm)
    {
        $ibm = implode(',', $ibm);
        $state = implode(',', $state);
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A07");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A07` (
            `fname` varchar(255) NOT NULL,
            `mname` varchar(255) NOT NULL,
            `lname` varchar(255) NOT NULL,
            `address1` varchar(255) NOT NULL,
            `address2` varchar(255) NOT NULL,
            `address3` varchar(255) NOT NULL,
            `concession_code` varchar(255) NOT NULL,
            `applicant_id` varchar(255) NOT NULL,
            `state` varchar(255) NOT NULL,
            `state_code` varchar(255) NOT NULL,
            `ibm_unqiue_reg_no` varchar(255) NOT NULL,
            `return_type` varchar(255) NOT NULL,
            `return_date` varchar(255) NOT NULL,
            `mcappd_officer_add1` varchar(255) NOT NULL,
            `mcappd_officer_add2` varchar(255) NOT NULL,
            `mcappd_officer_add3` varchar(255) NOT NULL,
            `prod_name` varchar(255) NOT NULL,
            `prod_annual_capacity` varchar(255) NOT NULL,
            `plant_name1` varchar(255) NOT NULL,
            `plant_name2` varchar(255) NOT NULL,
            `industry_name` varchar(255) NOT NULL,
            `district_total` varchar(255) DEFAULT NULL,
            `state_total` varchar(255) DEFAULT NULL,
            `region_total` varchar(255) DEFAULT NULL,
            `district_outof` varchar(255) DEFAULT NULL,
            `state_outof` varchar(255) DEFAULT NULL,
            `region_outof` varchar(255) DEFAULT NULL
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A07_Plantwise_Capacity_StateWise('$returnType','$from_date','$state','$industry','$ibm')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $fname = $record['mcappd_fname'];
            $mname = $record['mcappd_mname'];
            $lname = $record['mcappd_lastname'];
            $address1 = $record['mcappd_address1'];
            $address2 = $record['mcappd_address2'];
            $address3 = $record['mcappd_address3'];
            $concession_code = $record['mcappd_concession_code'];
            $applicant_id = $record['applicant_id'];
            $state = $record['mcappd_state'];
            $ibm_unqiue_reg_no = $record['ibm_unique_reg_no'];
            $return_type = $record['return_type'];
            $return_date = $record['Date'];
            $officer_add1 = $record['mcappd_officer_add1'];
            $officer_add2 = $record['mcappd_officer_add2'];
            $officer_add3 = $record['mcappd_officer_add3'];
            $prod_name = $record['prod_name'];
            $prod_annual_capacity = $record['prod_anual_capacity'];
            $plant_name1 = $record['plant_name1'];
            $plant_name2 = $record['plant_name2'];
            $industry_name = $record['industry_name'];
            $other_industry_name = $record['other_industry_name'];
            $industry_name_combine = $industry_name . ' ' . $other_industry_name;

            $queryState = $con->execute("SELECT state_name FROM dir_state WHERE state_code = '$state'");
            $recStates = $queryState->fetchAll('assoc');
            foreach ($recStates as $recState) {
                $state_name = $recState['state_name'];
            }

            $insert = $con->execute("INSERT INTO temp_reportico_report_A07 (fname, mname, lname, address1, address2, address3, concession_code, applicant_id, state, state_code, ibm_unqiue_reg_no, return_type, return_date, mcappd_officer_add1, mcappd_officer_add2, mcappd_officer_add3, prod_name, prod_annual_capacity, plant_name1, plant_name2, industry_name) 
            VALUES (
                '$fname', '$mname', '$lname', '$address1', '$address2', '$address3', '$concession_code', '$applicant_id', '$state_name','$state', '$ibm_unqiue_reg_no', '$return_type', '$return_date', '$officer_add1', '$officer_add2', '$officer_add3', '$prod_name', '$prod_annual_capacity', '$plant_name1', '$plant_name2','$industry_name_combine')");

            $update = $con->execute("UPDATE temp_reportico_report_A07 SET state_total = (SELECT COUNT(DISTINCT state) FROM temp_reportico_report_A07 WHERE state_code = '$state') WHERE state_code = '$state'");
            $update = $con->execute("UPDATE temp_reportico_report_A07 SET state_outof = (SELECT COUNT(mcappd_state) FROM mc_applicant_det WHERE mcappd_state = '$state') WHERE state_code = '$state'");
        }
    }

    public static function getReportA08SubmissionForRegNo($returnType, $from_date, $status, $business, $ibm)
    {
        $status = implode(',', $status);
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A08");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A08` (
            `fname` varchar(255) NOT NULL,
            `mname` varchar(255) NOT NULL,
            `lname` varchar(255) NOT NULL,
            `address1` varchar(255) NOT NULL,
            `address2` varchar(255) NOT NULL,
            `address3` varchar(255) NOT NULL,
            `concession_code` varchar(255) NOT NULL,
            `applicant_id` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `ibm_unqiue_reg_no` varchar(255) NOT NULL,
            `return_type` varchar(255) NOT NULL,
            `return_date` varchar(255) NOT NULL,
            `activity` varchar(255) NOT NULL,
            `activity_name` varchar(255) NOT NULL,
            `status` varchar(255) NOT NULL,
            `status_name` varchar(255) NOT NULL,
            `plant_name` varchar(255) NOT NULL,
            `district_total` varchar(255) DEFAULT NULL,
            `state_total` varchar(255) DEFAULT NULL,
            `region_total` varchar(255) DEFAULT NULL,
            `district_outof` varchar(255) DEFAULT NULL,
            `state_outof` varchar(255) DEFAULT NULL,
            `region_outof` varchar(255) DEFAULT NULL
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A08_RegistrationNo('$returnType','$from_date','$status','$business','$ibm')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $fname = $record['mcappd_fname'];
            $mname = $record['mcappd_mname'];
            $lname = $record['mcappd_lastname'];
            $address1 = $record['mcappd_address1'];
            $address2 = $record['mcappd_address2'];
            $address3 = $record['mcappd_address3'];
            $email = $record['mcappd_email'];
            $concession_code = $record['mcappd_concession_code'];
            $applicant_id = $record['applicant_id'];
            $ibm_unqiue_reg_no = $record['ibm_unique_reg_no'];
            $return_type = $record['return_type'];
            $return_date = $record['Date'];
            $status = $record['status'];
            $status_name = $record['status_name'];
            $activity = $record['Activity'];
            $activity_name = $record['activity_name'];
            $plant1 = $record['plant_name1'];
            $plant2 = $record['plant_name2'];
            $plant_name = $plant1 . ' ' . $plant2;

            $insert = $con->execute("INSERT INTO temp_reportico_report_A08 (fname, mname, lname, address1, address2, address3, email, concession_code, applicant_id, ibm_unqiue_reg_no, return_type, status, status_name, return_date, activity, activity_name, plant_name) 
            VALUES (
                '$fname', '$mname', '$lname', '$address1', '$address2', '$address3',  '$email', '$concession_code', '$applicant_id',  '$ibm_unqiue_reg_no', '$return_type', '$status', '$status_name', '$return_date', '$activity', '$activity_name','$plant_name')");
        }
    }

    public static function getReportA09CompanywiseActivtyRegionwise($returnType, $from_date, $business, $region, $ibm)
    {
        $business = implode(',', $business);
        $region = implode(',', $region);
        $ibm = implode(',', $ibm);
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A09");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A09` (
            `fname` varchar(255) NOT NULL,
            `mname` varchar(255) NOT NULL,
            `lname` varchar(255) NOT NULL,
            `address1` varchar(255) NOT NULL,
            `address2` varchar(255) NOT NULL,
            `address3` varchar(255) NOT NULL,
            `concession_code` varchar(255) NOT NULL,
            `applicant_id` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `ibm_unqiue_reg_no` varchar(255) NOT NULL,
            `return_type` varchar(255) NOT NULL,
            `return_date` varchar(255) NOT NULL,
            `activity` varchar(255) NOT NULL,
            `activity_name` varchar(255) NOT NULL,
            `region` varchar(255) NOT NULL,
            `region_code` varchar(255) NOT NULL,
            `plant_name` varchar(255) NOT NULL,
            `district_total` varchar(255) DEFAULT NULL,
            `state_total` varchar(255) DEFAULT NULL,
            `region_total` varchar(255) DEFAULT NULL,
            `district_outof` varchar(255) DEFAULT NULL,
            `state_outof` varchar(255) DEFAULT NULL,
            `region_outof` varchar(255) DEFAULT NULL
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A09_Companywise_Business_RegionWise('$returnType','$from_date','$business','$region', '$ibm')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $fname = $record['mcappd_fname'];
            $mname = $record['mcappd_mname'];
            $lname = $record['mcappd_lastname'];
            $address1 = $record['mcappd_address1'];
            $address2 = $record['mcappd_address2'];
            $address3 = $record['mcappd_address3'];
            $email = $record['mcappd_email'];
            $concession_code = $record['mcappd_concession_code'];
            $applicant_id = $record['applicant_id'];
            $ibm_unqiue_reg_no = $record['ibm_unique_reg_no'];
            $return_type = $record['return_type'];
            $return_date = $record['Date'];
            $activity = $record['mcu_activity'];
            $activity_name = $record['activity_name'];
            $region = $record['region_name'];
            $region_code = $record['region_code'];
            $plant1 = $record['plant_name1'];
            $plant2 = $record['plant_name2'];
            $plant_name = $plant1 . ' ' . $plant2;

            $insert = $con->execute("INSERT INTO temp_reportico_report_A09 (fname, mname, lname, address1, address2, address3, email, concession_code, applicant_id, ibm_unqiue_reg_no, return_type,  return_date, activity, activity_name, region, region_code, plant_name) 
            VALUES (
                '$fname', '$mname', '$lname', '$address1', '$address2', '$address3',  '$email', '$concession_code', '$applicant_id',  '$ibm_unqiue_reg_no', '$return_type', '$return_date', '$activity', '$activity_name' , '$region' , '$region_code', '$plant_name')");

            $update = $con->execute("UPDATE temp_reportico_report_A09 SET region_total = (SELECT COUNT(DISTINCT region_code) FROM temp_reportico_report_A09 WHERE region_code = $region_code) WHERE region_code = $region_code");
            $update = $con->execute("UPDATE temp_reportico_report_A09 SET region_outof = (SELECT COUNT(mcappd_regioncode) FROM mc_applicant_det WHERE mcappd_regioncode = $region_code) WHERE region_code = $region_code");
        }
    }

    public static function getReportA10CompanywiseActivtyStatewise($returnType, $from_date, $business, $state, $ibm)
    {
        $business = implode(',', $business);
        $state = implode(',', $state);
        $ibm = implode(',', $ibm);
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A10");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A10` (
            `fname` varchar(255) NOT NULL,
            `mname` varchar(255) NOT NULL,
            `lname` varchar(255) NOT NULL,
            `address1` varchar(255) NOT NULL,
            `address2` varchar(255) NOT NULL,
            `address3` varchar(255) NOT NULL,
            `concession_code` varchar(255) NOT NULL,
            `applicant_id` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `ibm_unqiue_reg_no` varchar(255) NOT NULL,
            `activity` varchar(255) NOT NULL,
            `activity_name` varchar(255) NOT NULL,
            `state` varchar(255) NOT NULL,
            `state_name` varchar(255) NOT NULL,
            `plant_name` varchar(255) NOT NULL,
            `district_total` varchar(255) DEFAULT NULL,
            `state_total` varchar(255) DEFAULT NULL,
            `region_total` varchar(255) DEFAULT NULL,
            `district_outof` varchar(255) DEFAULT NULL,
            `state_outof` varchar(255) DEFAULT NULL,
            `region_outof` varchar(255) DEFAULT NULL
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A10_Companywise_Business_StateWise('$returnType','$from_date','$business','$state','$ibm')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $fname = $record['mcappd_fname'];
            $mname = $record['mcappd_mname'];
            $lname = $record['mcappd_lastname'];
            $address1 = $record['mcappd_address1'];
            $address2 = $record['mcappd_address2'];
            $address3 = $record['mcappd_address3'];
            $email = $record['mcappd_email'];
            $concession_code = $record['mcappd_concession_code'];
            $applicant_id = $record['applicant_id'];
            $ibm_unqiue_reg_no = $record['ibm_unique_reg_no'];
            $activity = $record['mcu_activity'];
            $activity_name = $record['activity_name'];
            $state = $record['mcappd_state'];
            $state_name = $record['state_name'];
            $plant1 = $record['plant_name1'];
            $plant2 = $record['plant_name2'];
            $plant_name = $plant1 . ' ' . $plant2;

            $insert = $con->execute("INSERT INTO temp_reportico_report_A10 (fname, mname, lname, address1, address2, address3, email, concession_code, applicant_id, ibm_unqiue_reg_no, activity, activity_name, state_name, state, plant_name) 
            VALUES (
                '$fname', '$mname', '$lname', '$address1', '$address2', '$address3',  '$email', '$concession_code', '$applicant_id',  '$ibm_unqiue_reg_no','$activity', '$activity_name' , '$state_name' , '$state', '$plant_name')");

            $update = $con->execute("UPDATE temp_reportico_report_A10 SET state_total = (SELECT COUNT(state) FROM temp_reportico_report_A10 WHERE state = '$state') WHERE state = '$state'");

            $update = $con->execute("UPDATE temp_reportico_report_A10 SET state_outof = (SELECT COUNT(mcappd_state) FROM mc_applicant_det WHERE mcappd_state = '$state') WHERE state = '$state'");
        }
    }

    public static function getReportA11RegionwisePercentageStatus($returnType, $from_date, $business, $region)
    {
        $region = implode(',', $region);
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A11");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A11` (
            `company` varchar(255) NOT NULL,
            `registered_activity` varchar(255) NOT NULL,
            `return_status` varchar(255) NOT NULL,
            `received` varchar(255) NOT NULL,
            `region` varchar(255) NOT NULL
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A11_Regionwise_Percentage_Status('$returnType','$from_date','$business','$region')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $company = $record['company'];
            $registered_activity = $record['rgact'];
            $return_status = $record['retregst'];
            if ($registered_activity == '') {
                $registered_activity = 0;
            }
            if ($return_status == '') {
                $return_status = 0;
            }
            if ($registered_activity == 0) {
                $received = 0;
            } else {
                $received = ($return_status / $registered_activity) * 100;
                $received = round($received, 2);
            }
            $region = $record['region_name'];

            $insert = $con->execute("INSERT INTO temp_reportico_report_A11 (company, registered_activity, return_status, received, region) 
            VALUES (
                '$company', '$registered_activity', '$return_status', '$received', '$region')");
        }
    }

    public static function getReportA12StatewisePercentageStatus($returnType, $from_date, $business, $state)
    {
        $state = implode(',', $state);
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A12");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A12` (
            `company` varchar(255) NOT NULL,
            `registered_activity` varchar(255) NOT NULL,
            `return_status` varchar(255) NOT NULL,
            `received` varchar(255) NOT NULL,
            `state` varchar(255) NOT NULL,
            `district_total` varchar(255) DEFAULT NULL,
            `state_total` varchar(255) DEFAULT NULL,
            `region_total` varchar(255) DEFAULT NULL,
            `district_outof` varchar(255) DEFAULT NULL,
            `state_outof` varchar(255) DEFAULT NULL,
            `region_outof` varchar(255) DEFAULT NULL
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A12_Statewise_Percentage_Status('$returnType','$from_date','$business','$state')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $company = $record['company'];
            $registered_activity = $record['rgact'];
            $return_status = $record['retregst'];
            if ($registered_activity == '') {
                $registered_activity = 0;
            }
            if ($return_status == '') {
                $return_status = 0;
            }
            if ($registered_activity == 0) {
                $received = 0;
            } else {
                $received = ($return_status / $registered_activity) * 100;
                $received = round($received, 2);
            }
            $state = $record['state_name'];

            $insert = $con->execute("INSERT INTO temp_reportico_report_A12 (company, registered_activity, return_status, received, state) 
            VALUES (
                '$company', '$registered_activity', '$return_status', '$received', '$state')");
        }
    }

    public static function getReportM13EnduseConsumption($returnType, $from_date, $to_date, $mineral, $ibm)
    {
        $ibm = implode(',', $ibm);
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_M13");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_M13` (
            `company` varchar(255) NOT NULL,
            `plant_name` varchar(255) NOT NULL,
            `ibm` varchar(255) NOT NULL,
            `date` varchar(255) NOT NULL,
            `mineral_name` varchar(255) NOT NULL,
            `mineral_quantity` varchar(255) NOT NULL
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_M13_Enduse_Consumption('$returnType','$from_date','$to_date', '$mineral','$ibm')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $fname = $record['mcappd_fname'];
            $mname = $record['mcappd_mname'];
            $lname = $record['mcappd_lastname'];
            $company = $fname . ' ' . $mname . ' ' . $lname;
            $plant1 = $record['plant_name1'];
            $plant2 = $record['plant_name2'];
            $plant = $plant1 . ' ' . $plant2;
            $ibm = $record['applicant_id'];
            $mineral_quantity = $record['quantity'];
            $mineral_name = $record['local_mineral_code'];
            $date = $record['return_date'];
            $date = date("F", strtotime($date));

            $insert = $con->execute("INSERT INTO temp_reportico_report_M13 (company, plant_name, ibm, date, mineral_quantity, mineral_name) 
            VALUES (
                '$company', '$plant', '$ibm', '$date', '$mineral_quantity', '$mineral_name')");
        }
    }

    public static function getReportA14StatewiseProductMineralConsumption($returnType, $from_date, $plant)
    {
        $plant = array_filter(array_map('trim', $plant), 'strlen');
        $plant = implode(',', $plant);
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A14");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A14` (
            `company` varchar(255) NOT NULL,
            `state` varchar(255) NOT NULL,
            `district` varchar(255) NOT NULL,
            `applicant_id` varchar(255) NOT NULL,
            `plant` varchar(255) NOT NULL,
            `prod_name` varchar(255) NOT NULL,
            `prev_year_prod` varchar(255) NOT NULL,
            `pres_year_prod` varchar(255) NOT NULL,
            `mineral` varchar(255) NOT NULL
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A14_Statewise_Production_Mineral_Consumption('$returnType','$from_date','$plant')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $fname = $record['mcappd_fname'];
            $mname = $record['mcappd_mname'];
            $lastname = $record['mcappd_lastname'];
            $company = $fname . ' ' . $mname . ' ' . $lastname;
            $state = $record['mcappd_state'];
            $district = $record['mcappd_district'];
            $applicant_id = $record['applicant_id'];
            $plant1 = $record['plant_name1'];
            $plant2 = $record['plant_name2'];
            $plant = $plant1 . ' ' . $plant2;
            $address1 = $record['mcappd_address1'];
            $address2 = $record['mcappd_address2'];
            $address3 = $record['mcappd_address3'];
            $address = $address1 . ' ' . $address2 . ' ' . $address3;
            $plant = $plant . ' - ' . $address;
            $prev_year_prod = $record['prev_year_prod'];
            $pres_year_prod = $record['pres_year_prod'];
            $mineral = $record['local_mineral_code'];
            $queryStateDistrict = $con->execute("SELECT s.state_name, d.district_name FROM dir_district d INNER JOIN dir_state s ON d.state_code = s.state_code WHERE d.district_code = '$district' AND d.state_code = '$state'");
            $recStateDists = $queryStateDistrict->fetchAll('assoc');
            foreach ($recStateDists as $recStateDist) {
                $state = $recStateDist['state_name'];
                $district = $recStateDist['district_name'];
            }

            $insert = $con->execute("INSERT INTO temp_reportico_report_A14 (company, state, district, applicant_id, plant, prev_year_prod, pres_year_prod, mineral) 
            VALUES (
                '$company', '$state', '$district', '$applicant_id','$plant','$prev_year_prod','$pres_year_prod','$mineral')");
        }
    }

    public static function getReportA15MineralwiseEnduse($returnType, $from_date, $mineral, $industry)
    {
        $industry = implode(',', $industry);
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A15");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A15` (
            `industry` varchar(255) NOT NULL,
            `sum_quantity` varchar(255) NOT NULL,
            `local_mineral_code` varchar(255) NOT NULL,
            `return_date` varchar(255) NOT NULL
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A15_Mineralwise_Enduse_Consumption('$returnType','$from_date','$mineral','$industry')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $industry_name = $record['industry_name'];
            $other_industry_name = $record['other_industry_name'];
            $industry = $industry_name . ' ' . $other_industry_name;
            $sum_quantity = $record['sum_quantity'];
            $local_mineral_code = $record['local_mineral_code'];
            $return_date = $record['return_date'];

            $insert = $con->execute("INSERT INTO temp_reportico_report_A15 (industry, sum_quantity, local_mineral_code, return_date) 
            VALUES (
                '$industry', '$sum_quantity', '$local_mineral_code', '$return_date')");
        }
    }

    public static function getReportA16MineralwiseEnduse($returnType, $from_date, $mineral, $industry)
    {
        $mineral = implode(',', $mineral);
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A16");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A16` (
             `industry` varchar(255) NOT NULL,
            `sum_quantity` varchar(255) NOT NULL,
            `local_mineral_code` varchar(255) NOT NULL,
            `return_date` varchar(255) NOT NULL
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A16_Industrywise_Enduse_Consumption('$returnType','$from_date','$mineral','$industry')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $industry_name = $record['industry_name'];
            $other_industry_name = $record['other_industry_name'];
            $industry = $industry_name . ' ' . $other_industry_name;
            $sum_quantity = $record['sum_quantity'];
            $local_mineral_code = $record['local_mineral_code'];
            $return_date = $record['return_date'];

            $insert = $con->execute("INSERT INTO temp_reportico_report_A16 (industry, sum_quantity, local_mineral_code, return_date) 
            VALUES (
                '$industry', '$sum_quantity', '$local_mineral_code', '$return_date')");
        }
    }

    public static function getReportA17MonthlyVsYearlyEnduse($returnType, $from_date, $to_date, $mineral, $ibm)
    {
        $mineral = implode(',', $mineral);
        $ibm = implode(',', $ibm);
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A17");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A17` (
            `company` varchar(255) NOT NULL,
            `plant_name` varchar(255) NOT NULL,
            `address` varchar(255) NOT NULL,
            `ibm` varchar(255) NOT NULL,
            `mineral_name` varchar(255) NOT NULL,
            `monthly_quantity` varchar(255) NOT NULL,
            `annual_quantity` varchar(255) NOT NULL
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A17_Monthly_Yearly_Enduse_Consumption('$returnType','$from_date','$to_date','$mineral','$ibm')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $fname = $record['mcappd_fname'];
            $mname = $record['mcappd_mname'];
            $lname = $record['mcappd_lastname'];
            $company = $fname . ' ' . $mname . ' ' . $lname;
            $plant1 = $record['plant_name1'];
            $plant2 = $record['plant_name2'];
            $plant = $plant1 . ' ' . $plant2;
            $add1 = $record['mcappd_address1'];
            $add2 = $record['mcappd_address2'];
            $add3 = $record['mcappd_address3'];
            $address = $add1 . ' ' . $add2 . ' ' . $add3;
            $ibm = $record['applicant_id'];
            $monthly_quantity = round($record['Count_Monthly'], 2);
            $annual_quantity = round($record['Count_Annual'], 2);
            $mineral_name = $record['local_mineral_code'];

            $insert = $con->execute("INSERT INTO temp_reportico_report_A17 (company, plant_name, ibm, address, mineral_name, monthly_quantity, annual_quantity) 
            VALUES (
                '$company', '$plant', '$ibm', '$address', '$mineral_name','$monthly_quantity','$annual_quantity')");
        }
    }

    public static function getReportA18CostMineralVsIndigenous($returnType, $from_date, $mineral)
    {
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A18");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A18` (
            `applicant_id` varchar(255) NOT NULL,
            `plant_name` varchar(255) NOT NULL,
            `ind_price` varchar(255) NOT NULL,
            `import_cost` varchar(255) NOT NULL,
            `mineral_name` varchar(255) NOT NULL,
            `difference_cost` varchar(255) NOT NULL
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A18_Cost_Mineral_Vs_Indigenous('$returnType','$from_date','$mineral')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $applicant_id = $record['applicant_id'];
            $plant1 = $record['plant_name1'];
            $plant2 = $record['plant_name2'];
            $plant = $plant1 . ' ' . $plant2;
            $ind_price = $record['ind_price'];
            $import_cost = $record['import_cost'];
            $mineral_name = $record['ferroalloy'];
            $difference_cost = (float)$ind_price - (float)$import_cost;

            if ($import_cost == '') {
                $import_cost = 0.00;
            }
            if ($ind_price == '') {
                $ind_price = 0.00;
            }

            $insert = $con->execute("INSERT INTO temp_reportico_report_A18 (applicant_id, plant_name, ind_price, import_cost, difference_cost,  mineral_name) 
            VALUES (
                '$applicant_id', '$plant', '$ind_price', '$import_cost', '$difference_cost', '$mineral_name')");
        }
    }

    public static function getReportA19MineralewiseTransportationCost($returnType, $from_date, $mineral)
    {
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A19");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A19` (
            `applicant_id` varchar(255) NOT NULL,
            `plant_name` varchar(255) NOT NULL,
            `ind_price` varchar(255) NOT NULL,
            `ind_trans_cost` varchar(255) NOT NULL,
            `ind_distance` varchar(255) NOT NULL,
            `mineral_name` varchar(255) NOT NULL,
            `landing_cost` varchar(255) DEFAULT NULL
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A19_Mineralwise_Transportation_Cost('$returnType','$from_date','$mineral')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $applicant_id = $record['applicant_id'];
            $plant1 = $record['plant_name1'];
            $plant2 = $record['plant_name2'];
            $plant = $plant1 . ' ' . $plant2;
            $ind_price = $record['ind_price'];
            $ind_trans_cost = $record['ind_trans_cost'];
            $ind_distance = $record['ind_distance'];
            $mineral_name = $record['ferroalloy'];
            $landing_cost = (float)$ind_price + (float)$ind_trans_cost;

            if ($ind_price == '') {
                $ind_price = 0.00;
            }
            if ($ind_trans_cost == '') {
                $ind_trans_cost = 0.00;
            }

            $insert = $con->execute("INSERT INTO temp_reportico_report_A19 (applicant_id, plant_name, ind_price, ind_trans_cost, ind_distance, mineral_name, landing_cost) 
            VALUES (
                '$applicant_id', '$plant', '$ind_price', '$ind_trans_cost','$ind_distance' ,'$mineral_name', '$landing_cost')");
        }
    }

    public static function getReportA20TransportationCostForRegNo($returnType, $from_date, $company)
    {
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A20");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A20` (
            `applicant_id` varchar(255) NOT NULL,
            `plant_name` varchar(255) NOT NULL,
            `ind_price` varchar(255) NOT NULL,
            `ind_trans_cost` varchar(255) NOT NULL,
            `ind_distance` varchar(255) NOT NULL,
            `company` varchar(255) NOT NULL,
            `landing_cost` varchar(255) DEFAULT NULL
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A20_Transportation_Cost_For_Regno('$returnType','$from_date','$company')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $applicant_id = $record['applicant_id'];
            $fname = $record['mcappd_fname'];
            $mname = $record['mcappd_mname'];
            $lname = $record['mcappd_lastname'];
            $company = $fname . ' ' . $mname . ' ' . $lname;
            $plant1 = $record['plant_name1'];
            $plant2 = $record['plant_name2'];
            $plant = $plant1 . ' ' . $plant2;
            $ind_price = $record['ind_price'];
            $ind_trans_cost = $record['ind_trans_cost'];
            $ind_distance = $record['ind_distance'];
            $landing_cost = (float)$ind_price + (float)$ind_trans_cost;

            if ($ind_price == '') {
                $ind_price = 0.00;
            }

            $insert = $con->execute("INSERT INTO temp_reportico_report_A20 (applicant_id, plant_name, ind_price, ind_trans_cost, ind_distance,landing_cost, company) 
            VALUES (
                '$applicant_id', '$plant', '$ind_price', '$ind_trans_cost', '$ind_distance', '$landing_cost', '$company')");
        }
    }

    public static function getReportA21SectorwiseMineralConsumptionStatewise($returnType, $from_date, $mineral)
    {
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A21");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A21` (
            `company` varchar(255) NOT NULL,
            `state` varchar(255) NOT NULL,
            `state_name` varchar(255) NOT NULL,
            `mineral_name` varchar(255) NOT NULL,
            `total_quantity` varchar(255) NOT NULL,
            `total_consumed` varchar(255) NOT NULL,
            `state_total` varchar(255) DEFAULT NULL,
            `state_outof` varchar(255) DEFAULT NULL
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A21_Sectorwise_Mineral_Consumption_Statewise('$returnType','$from_date','$mineral')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $fname = $record['mcappd_fname'];
            $mname = $record['mcappd_mname'];
            $lname = $record['mcappd_lastname'];
            $company = $fname . ' ' . $mname . ' ' . $lname;
            $company = str_replace("'", " ", $company);
            $state = $record['mcappd_state'];
            $mineral = $record['mineral_name'];
            $total_quantity = $record['total_quantity'];
            $total_consumed = $record['consumed'];
            if ($total_consumed == '') {
                $total_consumed = '0';
            }
            if ($total_quantity == '') {
                $total_quantity = '0';
            }

            $queryState = $con->execute("SELECT state_name FROM dir_state WHERE state_code = '$state'");
            $recStates = $queryState->fetchAll('assoc');
            foreach ($recStates as $recState) {
                $state_name = $recState['state_name'];
            }

            $insert = $con->execute("INSERT INTO temp_reportico_report_A21 (company, state_name, state, mineral_name, total_quantity, total_consumed) 
            VALUES ('$company','$state_name','$state','$mineral','$total_quantity','$total_consumed')");

            $update = $con->execute("UPDATE temp_reportico_report_A21 SET state_total = (SELECT COUNT(state) FROM temp_reportico_report_A21 WHERE state = '$state') WHERE state = '$state'");

            $update = $con->execute("UPDATE temp_reportico_report_A21 SET state_outof = (SELECT COUNT(mcappd_state) FROM mc_applicant_det WHERE mcappd_state = '$state') WHERE state = '$state'");
        }
    }

    public static function getReportA22SectorwiseMineralConsumptionRegionwise($returnType, $from_date, $mineral)
    {
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A22");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A22` (
            `company` varchar(255) NOT NULL,
            `region` varchar(255) NOT NULL,
            `region_name` varchar(255) NOT NULL,
            `mineral_name` varchar(255) NOT NULL,
            `total_quantity` varchar(255) NOT NULL,
            `total_consumed` varchar(255) NOT NULL,
            `region_total` varchar(255) DEFAULT NULL,
            `region_outof` varchar(255) DEFAULT NULL
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A22_Sectorwise_Mineral_Consumption_Regionwise('$returnType', '$from_date','$mineral')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $fname = $record['mcappd_fname'];
            $mname = $record['mcappd_mname'];
            $lname = $record['mcappd_lastname'];
            $company = $fname . ' ' . $mname . ' ' . $lname;
            $company = str_replace("'", " ", $company);
            $region = $record['mcappd_regioncode'];
            $total_quantity = $record['total_quantity'];
            $total_consumed = $record['consumed'];
            $mineral = $record['mineral_name'];
            if ($total_consumed == '') {
                $total_consumed = '0';
            }
            if ($total_quantity == '') {
                $total_quantity = '0';
            }

            $queryRegion = $con->execute("SELECT region_name FROM dir_district WHERE region_code = '$region'");
            $recRegions = $queryRegion->fetchAll('assoc');
            foreach ($recRegions as $recRegion) {
                $region_name = $recRegion['region_name'];
            }

            $insert = $con->execute("INSERT INTO temp_reportico_report_A22 (company, region, region_name, mineral_name, total_quantity, total_consumed) 
            VALUES (
                '$company', '$region', '$region_name','$mineral', '$total_quantity', '$total_consumed')");

            $update = $con->execute("UPDATE temp_reportico_report_A22 SET region_total = (SELECT COUNT(region) FROM temp_reportico_report_A22 WHERE region = '$region') WHERE region = '$region'");

            $update = $con->execute("UPDATE temp_reportico_report_A22 SET region_outof = (SELECT COUNT(mcappd_regioncode) FROM mc_applicant_det WHERE mcappd_regioncode = '$region') WHERE region = '$region'");
        }
    }

    public static function getReportA23IndustrywisePlant($returnType, $from_date, $industry)
    {
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A23");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A23` (
            `company` varchar(255) NOT NULL,
            `plant_name` varchar(255) NOT NULL,
            `ibm` varchar(255) NOT NULL,
            `state` varchar(255) NOT NULL,
            `industry` varchar(255) NOT NULL
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A23_Industrywise_Plant('$returnType', '$from_date','$industry')");
        $records = $query->fetchAll('assoc');
        // print_r($records);
        // exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $fname = $record['mcappd_fname'];
            $mname = $record['mcappd_mname'];
            $lname = $record['mcappd_lastname'];
            $company = $fname . ' ' . $mname . ' ' . $lname;
            $company = str_replace("'", " ", $company);
            $plant1 = $record['plant_name1'];
            $plant2 = $record['plant_name2'];
            $plant = $plant1 . ' ' . $plant2;
            $ibm = $record['applicant_id'];
            $state = $record['mcappd_state'];
            $industry1  = $record['industry_name'];
            $industry2 = $record['other_industry_name'];
            $industry = $industry1 . ' ' . $industry2;

            $queryState = $con->execute("SELECT state_name FROM dir_state WHERE state_code = '$state'");
            $recStates = $queryState->fetchAll('assoc');
            foreach ($recStates as $recState) {
                $state = $recState['state_name'];
            }

            $insert = $con->execute("INSERT INTO temp_reportico_report_A23 (company, plant_name, ibm, state, industry) 
            VALUES (
                '$company', '$plant', '$ibm', '$state', '$industry')");
        }
    }

    public static function getReportA24MaterTradingActivity($returnType, $from_date, $mineral, $grade, $state)
    {
        $state = implode(',', $state);
        $grade = implode(',', $grade);
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A24");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A24` (
            `applicant_id` varchar(255) NOT NULL,
            `mineral_name` varchar(255) NOT NULL,
            `mineral_grade` varchar(255) NOT NULL,
            `state` varchar(255) NOT NULL,
            `district` varchar(255) NOT NULL,
            `plant_name` varchar(255) NOT NULL,
            `opening_stock` varchar(255) NOT NULL,
            `closing_stock` varchar(255) NOT NULL,
            `ore_purchased_quantity` varchar(255) NOT NULL,
            `ore_purchased_value` varchar(255) DEFAULT NULL,
            `ore_import_quantity` varchar(255) DEFAULT NULL,
            `ore_import_value` varchar(255) DEFAULT NULL,
            `ore_dispatched_quantity` varchar(255) DEFAULT NULL,
            `ore_dispatched_value` varchar(255) DEFAULT NULL
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A24_MasterTradingActivity('$returnType','$from_date','$mineral','$grade','$state')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $applicant_id = $record['applicant_id'];
            $mineral_name = $record['local_mineral_code'];
            $mineral_grade = $record['local_grade_code'];
            $state = $record['mcappd_state'];
            $district = $record['mcappd_district'];
            $plant1 = $record['plant_name1'];
            $plant2 = $record['plant_name2'];
            $plant = $plant1 . ' ' . $plant2;
            $open_stock = $record['opening_stock'];
            $close_stock = $record['closing_stock'];
            $ore_purchased_quantity = $record['ore_purchased_quantity'];
            $ore_purchased_value = $record['ore_purchased_value'];
            $ore_import_quantity = $record['ore_import_quantity'];
            $ore_import_value = $record['ore_import_value'];
            $ore_dispatched_quantity = $record['ore_dispatched_quantity'];
            $ore_dispatched_value = $record['ore_dispatched_value'];

            $queryStateDistrict = $con->execute("SELECT s.state_name, d.district_name FROM dir_district d INNER JOIN dir_state s ON d.state_code = s.state_code WHERE d.district_code = '$district' AND d.state_code = '$state'");
            $recStateDists = $queryStateDistrict->fetchAll('assoc');
            foreach ($recStateDists as $recStateDist) {
                $state = $recStateDist['state_name'];
                $district = $recStateDist['district_name'];
            }

            $insert = $con->execute("INSERT INTO temp_reportico_report_A24 (applicant_id, mineral_name, mineral_grade, state, district, plant_name, opening_stock, closing_stock, ore_purchased_quantity, ore_purchased_value, ore_import_quantity, ore_import_value, ore_dispatched_quantity, ore_dispatched_value) 
            VALUES (
                '$applicant_id', '$mineral_name', '$mineral_grade', '$state', '$district', '$plant','$open_stock','$close_stock','$ore_purchased_quantity','$ore_purchased_value','$ore_import_quantity','$ore_import_value','$ore_dispatched_quantity','$ore_dispatched_value')");
        }
    }

    public static function getReportA25MaterExportActivity($returnType, $from_date, $mineral, $grade, $state)
    {
        $state = implode(',', $state);
        $grade = implode(',', $grade);
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A25");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A25` (
            `applicant_id` varchar(255) NOT NULL,
            `mineral_name` varchar(255) NOT NULL,
            `mineral_grade` varchar(255) NOT NULL,
            `state` varchar(255) NOT NULL,
            `district` varchar(255) NOT NULL,
            `plant_name` varchar(255) NOT NULL,
            `opening_stock` varchar(255) NOT NULL,
            `closing_stock` varchar(255) NOT NULL,
            `ore_purchased_quantity` varchar(255) NOT NULL,
            `ore_purchased_value` varchar(255) DEFAULT NULL,
            `ore_import_quantity` varchar(255) DEFAULT NULL,
            `ore_import_value` varchar(255) DEFAULT NULL,
            `ore_dispatched_quantity` varchar(255) DEFAULT NULL,
            `ore_dispatched_value` varchar(255) DEFAULT NULL           
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A25_MasterExportActivity('$returnType','$from_date','$mineral','$grade','$state')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $applicant_id = $record['applicant_id'];
            $mineral_name = $record['local_mineral_code'];
            $mineral_grade = $record['local_grade_code'];
            $state = $record['mcappd_state'];
            $district = $record['mcappd_district'];
            $plant1 = $record['plant_name1'];
            $plant2 = $record['plant_name2'];
            $plant = $plant1 . ' ' . $plant2;
            $open_stock = $record['opening_stock'];
            $close_stock = $record['closing_stock'];
            $ore_purchased_quantity = $record['ore_purchased_quantity'];
            $ore_purchased_value = $record['ore_purchased_value'];
            $ore_import_quantity = $record['ore_import_quantity'];
            $ore_import_value = $record['ore_import_value'];
            $ore_dispatched_quantity = $record['ore_dispatched_quantity'];
            $ore_dispatched_value = $record['ore_dispatched_value'];

            $queryStateDistrict = $con->execute("SELECT s.state_name, d.district_name FROM dir_district d INNER JOIN dir_state s ON d.state_code = s.state_code WHERE d.district_code = '$district' AND d.state_code = '$state'");
            $recStateDists = $queryStateDistrict->fetchAll('assoc');
            foreach ($recStateDists as $recStateDist) {
                $state = $recStateDist['state_name'];
                $district = $recStateDist['district_name'];
            }

            $insert = $con->execute("INSERT INTO temp_reportico_report_A25 (applicant_id, mineral_name, mineral_grade, state, district, plant_name, opening_stock, closing_stock, ore_purchased_quantity, ore_purchased_value, ore_import_quantity, ore_import_value, ore_dispatched_quantity, ore_dispatched_value) 
            VALUES (
                '$applicant_id', '$mineral_name', '$mineral_grade', '$state', '$district', '$plant','$open_stock','$close_stock','$ore_purchased_quantity','$ore_purchased_value','$ore_import_quantity','$ore_import_value','$ore_dispatched_quantity','$ore_dispatched_value')");
        }
    }

    public static function getReportA26MaterEndUserActivity($returnType, $from_date, $mineral, $grade, $state)
    {
        $state = implode(',', $state);
        $grade = implode(',', $grade);
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A26");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A26` (
            `applicant_id` varchar(255) NOT NULL,
            `mineral_name` varchar(255) NOT NULL,
            `mineral_grade` varchar(255) NOT NULL,
            `state` varchar(255) NOT NULL,
            `district` varchar(255) NOT NULL,
            `plant_name` varchar(255) NOT NULL,
            `opening_stock` varchar(255) NOT NULL,
            `closing_stock` varchar(255) NOT NULL,
            `ore_purchased_quantity` varchar(255) NOT NULL,
            `ore_purchased_value` varchar(255) DEFAULT NULL,
            `ore_import_quantity` varchar(255) DEFAULT NULL,
            `ore_import_value` varchar(255) DEFAULT NULL,
            `ore_dispatched_quantity` varchar(255) DEFAULT NULL,
            `ore_dispatched_value` varchar(255) DEFAULT NULL          
             ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A26_MasterEndUserActivity('$returnType','$from_date','$mineral','$grade','$state')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $applicant_id = $record['applicant_id'];
            $mineral_name = $record['local_mineral_code'];
            $mineral_grade = $record['local_grade_code'];
            $state = $record['mcappd_state'];
            $district = $record['mcappd_district'];
            $plant1 = $record['plant_name1'];
            $plant2 = $record['plant_name2'];
            $plant = $plant1 . ' ' . $plant2;
            $open_stock = $record['opening_stock'];
            $close_stock = $record['closing_stock'];
            $ore_purchased_quantity = $record['ore_purchased_quantity'];
            $ore_purchased_value = $record['ore_purchased_value'];
            $ore_import_quantity = $record['ore_import_quantity'];
            $ore_import_value = $record['ore_import_value'];
            $ore_dispatched_quantity = $record['ore_dispatched_quantity'];
            $ore_dispatched_value = $record['ore_dispatched_value'];

            $queryStateDistrict = $con->execute("SELECT s.state_name, d.district_name FROM dir_district d INNER JOIN dir_state s ON d.state_code = s.state_code WHERE d.district_code = '$district' AND d.state_code = '$state'");
            $recStateDists = $queryStateDistrict->fetchAll('assoc');
            foreach ($recStateDists as $recStateDist) {
                $state = $recStateDist['state_name'];
                $district = $recStateDist['district_name'];
            }

            $insert = $con->execute("INSERT INTO temp_reportico_report_A26 (applicant_id, mineral_name, mineral_grade, state, district, plant_name, opening_stock, closing_stock, ore_purchased_quantity, ore_purchased_value, ore_import_quantity, ore_import_value, ore_dispatched_quantity, ore_dispatched_value) 
            VALUES (
                '$applicant_id', '$mineral_name', '$mineral_grade', '$state', '$district', '$plant','$open_stock','$close_stock','$ore_purchased_quantity','$ore_purchased_value','$ore_import_quantity','$ore_import_value','$ore_dispatched_quantity','$ore_dispatched_value')");
        }
    }

    public static function getReportA27MaterStockistActivity($returnType, $from_date, $mineral, $grade, $state)
    {
        $state = implode(',', $state);
        $grade = implode(',', $grade);
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A27");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A27` (
            `applicant_id` varchar(255) NOT NULL,
            `mineral_name` varchar(255) NOT NULL,
            `mineral_grade` varchar(255) NOT NULL,
            `state` varchar(255) NOT NULL,
            `district` varchar(255) NOT NULL,
            `plant_name` varchar(255) NOT NULL,
            `opening_stock` varchar(255) NOT NULL,
            `closing_stock` varchar(255) NOT NULL,
            `ore_purchased_quantity` varchar(255) NOT NULL,
            `ore_purchased_value` varchar(255) DEFAULT NULL,
            `ore_import_quantity` varchar(255) DEFAULT NULL,
            `ore_import_value` varchar(255) DEFAULT NULL,
            `ore_dispatched_quantity` varchar(255) DEFAULT NULL,
            `ore_dispatched_value` varchar(255) DEFAULT NULL          
             ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A27_MasterStockistActivity('$returnType','$from_date','$mineral','$grade','$state')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $applicant_id = $record['applicant_id'];
            $mineral_name = $record['local_mineral_code'];
            $mineral_grade = $record['local_grade_code'];
            $state = $record['mcappd_state'];
            $district = $record['mcappd_district'];
            $plant1 = $record['plant_name1'];
            $plant2 = $record['plant_name2'];
            $plant = $plant1 . ' ' . $plant2;
            $open_stock = $record['opening_stock'];
            $close_stock = $record['closing_stock'];
            $ore_purchased_quantity = $record['ore_purchased_quantity'];
            $ore_purchased_value = $record['ore_purchased_value'];
            $ore_import_quantity = $record['ore_import_quantity'];
            $ore_import_value = $record['ore_import_value'];
            $ore_dispatched_quantity = $record['ore_dispatched_quantity'];
            $ore_dispatched_value = $record['ore_dispatched_value'];

            $queryStateDistrict = $con->execute("SELECT s.state_name, d.district_name FROM dir_district d INNER JOIN dir_state s ON d.state_code = s.state_code WHERE d.district_code = '$district' AND d.state_code = '$state'");
            $recStateDists = $queryStateDistrict->fetchAll('assoc');
            foreach ($recStateDists as $recStateDist) {
                $state = $recStateDist['state_name'];
                $district = $recStateDist['district_name'];
            }

            $insert = $con->execute("INSERT INTO temp_reportico_report_A27 (applicant_id, mineral_name, mineral_grade, state, district, plant_name, opening_stock, closing_stock, ore_purchased_quantity, ore_purchased_value, ore_import_quantity, ore_import_value, ore_dispatched_quantity, ore_dispatched_value) 
            VALUES (
                '$applicant_id', '$mineral_name', '$mineral_grade', '$state', '$district', '$plant','$open_stock','$close_stock','$ore_purchased_quantity','$ore_purchased_value','$ore_import_quantity','$ore_import_value','$ore_dispatched_quantity','$ore_dispatched_value')");
        }
    }

    public static function getReportA28MaterRawMaterialConsumed($returnType, $from_date, $mineral, $plant)
    {
        $plant = array_filter(array_map('trim', $plant), 'strlen');
        $plant = implode(',', $plant);
        $mineral = implode(',', $mineral);

        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A28");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A28` (
            `applicant_id` varchar(255) NOT NULL,
            `mineral_name` varchar(255) NOT NULL,
            `state` varchar(255) NOT NULL,
            `district` varchar(255) NOT NULL,
            `plant_name` varchar(255) NOT NULL,
            `industry` varchar(255) NOT NULL,
            `prev_ind_year` varchar(255) NOT NULL,
            `prev_imp_year` varchar(255) NOT NULL,
            `pres_ind_year` varchar(255) DEFAULT NULL,
            `pres_inm_year` varchar(255) DEFAULT NULL,
            `next_year_est` varchar(255) DEFAULT NULL,
            `future_est` varchar(255) DEFAULT NULL
             ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A28_MasterRawMaterialConsumed('$returnType','$from_date','$mineral','$plant')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $applicant_id = $record['applicant_id'];
            $mineral_name = $record['mineral_name'];
            $state = $record['mcappd_state'];
            $district = $record['mcappd_district'];
            $plant1 = $record['plant_name1'];
            $plant2 = $record['plant_name2'];
            $plant = $plant1 . ' ' . $plant2;
            $industry1 = $record['industry_name'];
            $industry2 = $record['other_industry_name'];
            $industry = $industry1 . ' ' . $industry2;
            $prev_ind_year = $record['prev_ind_year'];
            $prev_imp_year = $record['prev_imp_year'];
            $pres_ind_year = $record['pres_ind_year'];
            $pres_inm_year = $record['pres_inm_year'];
            $next_year_est = $record['next_year_est'];
            $future_est = $record['future_est'];

            $queryStateDistrict = $con->execute("SELECT s.state_name, d.district_name FROM dir_district d INNER JOIN dir_state s ON d.state_code = s.state_code WHERE d.district_code = '$district' AND d.state_code = '$state'");
            $recStateDists = $queryStateDistrict->fetchAll('assoc');
            foreach ($recStateDists as $recStateDist) {
                $state = $recStateDist['state_name'];
                $district = $recStateDist['district_name'];
            }

            $insert = $con->execute("INSERT INTO temp_reportico_report_A28 (applicant_id, mineral_name, state, district, plant_name, industry, prev_ind_year, prev_imp_year, pres_ind_year, pres_inm_year, next_year_est, future_est) 
            VALUES (
                '$applicant_id', '$mineral_name',  '$state', '$district', '$plant','$industry','$prev_ind_year','$prev_imp_year','$pres_ind_year','$pres_inm_year','$next_year_est','$future_est')");
        }
    }

    public static function getReportA29SourceSupplyIndigenous($returnType, $from_date, $mineral, $plant)
    {
        $plant = array_filter(array_map('trim', $plant), 'strlen');
        $plant = implode(',', $plant);
        $mineral = implode(',', $mineral);
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A29");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A29` (
            `applicant_id` varchar(255) NOT NULL,
            `mineral_name` varchar(255) NOT NULL,
            `state` varchar(255) NOT NULL,
            `plant_name` varchar(255) NOT NULL,
            `industry` varchar(255) NOT NULL,
            `ind_sup_name` varchar(255) NOT NULL,
            `ind_trans_mode` varchar(255) NOT NULL,
            `ind_trans_cost` varchar(255) DEFAULT NULL,
            `ind_quantity` varchar(255) DEFAULT NULL,
            `ind_price` varchar(255) DEFAULT NULL
             ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A29_SourceSupply_Indigenous('$returnType','$from_date','$mineral','$plant')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $applicant_id = $record['applicant_id'];
            $mineral_name = $record['ferroalloy'];
            $state = $record['state'];
            $plant1 = $record['plant_name1'];
            $plant2 = $record['plant_name2'];
            $plant = $plant1 . ' ' . $plant2;
            $industry1 = $record['industry_name'];
            $industry2 = $record['other_industry_name'];
            $industry = $industry1 . ' ' . $industry2;
            $address1 = $record['mcappd_address1'];
            $address2 = $record['mcappd_address2'];
            $address3 = $record['mcappd_address3'];
            $address = $address1 . ' ' . $address2 . ' ' . $address3;
            $ind_sup_name = $record['ind_sup_name'];
            $ind_trans_mode = $record['ind_trans_mode'];
            $ind_trans_cost = $record['ind_trans_cost'];
            $ind_quantity = $record['ind_quantity'];
            $ind_price = $record['ind_price'];

            $queryState = $con->execute("SELECT state_name FROM dir_state WHERE state_code = '$state'");
            $recStates = $queryState->fetchAll('assoc');
            foreach ($recStates as $recState) {
                $state = $recState['state_name'];
            }

            $insert = $con->execute("INSERT INTO temp_reportico_report_A29 (applicant_id, mineral_name, state, plant_name, industry, ind_sup_name, ind_trans_mode, ind_trans_cost, ind_quantity, ind_price) 
            VALUES (
                '$applicant_id', '$mineral_name',  '$state',  '$plant','$industry','$ind_sup_name','$ind_trans_mode','$ind_trans_cost','$ind_quantity','$ind_price')");
        }
    }

    public static function getReportA30SourceSupplyImported($returnType, $from_date, $mineral, $plant)
    {
        $plant = array_filter(array_map('trim', $plant), 'strlen');
        $plant = implode(',', $plant);
        $mineral = implode(',', $mineral);
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A30");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A30` (
            `applicant_id` varchar(255) NOT NULL,
            `mineral_name` varchar(255) NOT NULL,
            `state` varchar(255) NOT NULL,
            `ind_sup_name` varchar(255) NOT NULL,
            `plant_name` varchar(255) NOT NULL,
            `industry` varchar(255) NOT NULL,
            `import_addr` varchar(255) NOT NULL,
            `import_pur_quantity` varchar(255) NOT NULL,
            `import_cost` varchar(255) DEFAULT NULL
             ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A30_SourceSupply_Imported('$returnType','$from_date','$mineral','$plant')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $applicant_id = $record['applicant_id'];
            $mineral_name = $record['ferroalloy'];
            $state = $record['state'];
            $plant1 = $record['plant_name1'];
            $plant2 = $record['plant_name2'];
            $plant = $plant1 . ' ' . $plant2;
            $industry1 = $record['industry_name'];
            $industry2 = $record['other_industry_name'];
            $industry = $industry1 . ' ' . $industry2;
            $import_addr = $record['import_addr'];
            $import_pur_quantity = $record['import_pur_quantity'];
            $import_cost = $record['import_cost'];
            $ind_sup_name = $record['ind_sup_name'];

            $queryState = $con->execute("SELECT state_name FROM dir_state WHERE state_code = '$state'");
            $recStates = $queryState->fetchAll('assoc');
            foreach ($recStates as $recState) {
                $state = $recState['state_name'];
            }

            $insert = $con->execute("INSERT INTO temp_reportico_report_A30 (applicant_id, mineral_name, state, plant_name,ind_sup_name, industry, import_addr, import_pur_quantity, import_cost) 
            VALUES (
                '$applicant_id', '$mineral_name',  '$state',  '$plant',''$ind_sup_name,'$industry','$import_addr','$import_pur_quantity','$import_cost')");
        }
    }

    public static function getReportA31TransportationCost($returnType, $from_date, $mineral, $plant)
    {
        $plant = implode(',', $plant);
        $mineral = implode(',', $mineral);
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A31");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A31` (
            `applicant_id` varchar(255) NOT NULL,
            `mineral_name` varchar(255) NOT NULL,
            `plant_name` varchar(255) NOT NULL,
            `industry` varchar(255) NOT NULL,
            `company` varchar(255) NOT NULL,
            `ind_sup_name` varchar(255) NOT NULL,
            `ind_trans_cost` varchar(255) NOT NULL,
            `ind_price` varchar(255) NOT NULL
             ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A31_TransportationCost('$returnType','$from_date','$mineral','$plant')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $applicant_id = $record['applicant_id'];
            $mineral_name = $record['ferroalloy'];
            $plant1 = $record['plant_name1'];
            $plant2 = $record['plant_name2'];
            $plant = $plant1 . ' ' . $plant2;
            $industry1 = $record['industry_name'];
            $industry2 = $record['other_industry_name'];
            $industry = $industry1 . ' ' . $industry2;
            $fname = $record['mcappd_fname'];
            $mname = $record['mcappd_mname'];
            $lname = $record['mcappd_lastname'];
            $company = $fname . ' ' . $mname . ' ' . $lname;
            $ind_sup_name = $record['ind_sup_name'];
            $ind_trans_cost = $record['ind_trans_cost'];
            $ind_price = $record['ind_price'];

            $insert = $con->execute("INSERT INTO temp_reportico_report_A31 (applicant_id, mineral_name, plant_name, company, industry, ind_sup_name, ind_trans_cost, ind_price) 
            VALUES (
                '$applicant_id', '$mineral_name',  '$plant','$company', '$industry','$ind_sup_name','$ind_trans_cost','$ind_price')");
        }
    }

    public static function getReportA32SupplierIndigenous($returnType, $from_date, $mineral, $plant)
    {
        $plant = implode(',', $plant);
        $mineral = implode(',', $mineral);
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A32");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A32` (
            `applicant_id` varchar(255) NOT NULL,
            `mineral_name` varchar(255) NOT NULL,
            `plant_name` varchar(255) NOT NULL,
            `company` varchar(255) NOT NULL,
            `ind_sup_name` varchar(255) NOT NULL,
            `reg_id` varchar(255) NOT NULL
             ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A32_Supplier_Indigenous('$returnType','$from_date','$mineral','$plant')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $applicant_id = $record['applicant_id'];
            $mineral_name = $record['ferroalloy'];
            $plant1 = $record['plant_name1'];
            $plant2 = $record['plant_name2'];
            $plant = $plant1 . ' ' . $plant2;
            $fname = $record['mcappd_fname'];
            $mname = $record['mcappd_mname'];
            $lname = $record['mcappd_lastname'];
            $company = $fname . ' ' . $mname . ' ' . $lname;
            $ind_sup_name = $record['name'];
            $reg_id = $record['registration_no'];
            $address1 = $record['mcappd_address1'];
            $address2 = $record['mcappd_address2'];
            $address3 = $record['mcappd_address3'];
            $address = $address1 . ' ' . $address2 . ' ' . $address3;
            $plant = $plant . ' - ' . ucwords($address);
            if ($ind_sup_name == '1') {
                $ind_sup_name = '';
            }

            $insert = $con->execute("INSERT INTO temp_reportico_report_A32 (applicant_id, mineral_name, plant_name, company, ind_sup_name, reg_id) 
            VALUES (
                '$applicant_id', '$mineral_name',  '$plant','$company', '$ind_sup_name','$reg_id')");
        }
    }

    public static function getReportA33SupplierImported($returnType, $from_date, $mineral, $plant, $country)
    {
        $plant = implode(',', $plant);
        $mineral = implode(',', $mineral);
        $country = implode(',', $country);
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_A33");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_A33` (
            `applicant_id` varchar(255) NOT NULL,
            `mineral_name` varchar(255) NOT NULL,
            `plant_name` varchar(255) NOT NULL,
            `company` varchar(255) NOT NULL,
            `imp_sup_name` varchar(255) NOT NULL
             ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_A33_Supplier_Imported('$returnType','$from_date','$mineral','$plant','$country')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $applicant_id = $record['applicant_id'];
            $mineral_name = $record['ferroalloy'];
            $plant1 = $record['plant_name1'];
            $plant2 = $record['plant_name2'];
            $plant = $plant1 . ' ' . $plant2;
            $fname = $record['mcappd_fname'];
            $mname = $record['mcappd_mname'];
            $lname = $record['mcappd_lastname'];
            $company = $fname . ' ' . $mname . ' ' . $lname;
            $address1 = $record['mcappd_address1'];
            $address2 = $record['mcappd_address2'];
            $address3 = $record['mcappd_address3'];
            $address = $address1 . ' ' . $address2 . ' ' . $address3;
            $plant = $plant . ' - ' . ucwords($address);
            $import_address = $record['import_addr'];
            if ($import_address == '1') {
                $import_address = '';
            }
            $imp_sup_name = $import_address;

            $insert = $con->execute("INSERT INTO temp_reportico_report_A33 (applicant_id, mineral_name, plant_name, company, imp_sup_name) 
            VALUES (
                '$applicant_id','$mineral_name','$plant','$company','$imp_sup_name')");
        }
    }

    public static function getReportM36TradingActivity($returnType, $date, $mineral, $grade, $plant)
    {
        $new_arr = array_filter(array_map('trim', $plant), 'strlen');
        $plant = implode(',', $new_arr);
        $grade = implode(',', $grade);
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_M36");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_M36` (
            `applicant_id` varchar(255) NOT NULL,
            `mineral_name` varchar(255) NOT NULL,
            `mineral_grade` varchar(255) NOT NULL,
            `state` varchar(255) NOT NULL,
            `plant_name` varchar(255) NOT NULL,
            `opening_stock` varchar(255) NOT NULL,
            `closing_stock` varchar(255) NOT NULL,
            `ore_purchased_quantity` varchar(255) NOT NULL,
            `ore_purchased_value` varchar(255) DEFAULT NULL,
            `ore_import_quantity` varchar(255) DEFAULT NULL,
            `ore_import_value` varchar(255) DEFAULT NULL,
            `ore_dispatched_quantity` varchar(255) DEFAULT NULL,
            `ore_dispatched_value` varchar(255) DEFAULT NULL
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_M36_TradingActivity('$returnType','$date','$mineral','$grade','$plant')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $applicant_id = $record['applicant_id'];
            $mineral_name = $record['local_mineral_code'];
            $mineral_grade = $record['local_grade_code'];
            $state = $record['state'];
            $plant1 = $record['plant_name1'];
            $plant2 = $record['plant_name2'];
            $plant = $plant1 . ' ' . $plant2;
            $open_stock = $record['opening_stock'];
            $close_stock = $record['closing_stock'];
            $ore_purchased_quantity = $record['ore_purchased_quantity'];
            $ore_purchased_value = $record['ore_purchased_value'];
            $ore_import_quantity = $record['ore_import_quantity'];
            $ore_import_value = $record['ore_import_value'];
            $ore_dispatched_quantity = $record['ore_dispatched_quantity'];
            $ore_dispatched_value = $record['ore_dispatched_value'];

            $queryState = $con->execute("SELECT state_name FROM dir_state WHERE state_code = '$state'");
            $recStates = $queryState->fetchAll('assoc');
            foreach ($recStates as $recState) {
                $state = $recState['state_name'];
            }

            $queryGrade = $con->execute("SELECT grade_name FROM dir_mineral_grade WHERE id = '$grade'");
            $recGrades = $queryGrade->fetchAll('assoc');
            foreach ($recGrades as $recGrade) {
                $mineral_grade = $recGrade['grade_name'];
            }

            $insert = $con->execute("INSERT INTO temp_reportico_report_M36 (applicant_id, mineral_name, mineral_grade, state, plant_name, opening_stock, closing_stock, ore_purchased_quantity, ore_purchased_value, ore_import_quantity, ore_import_value, ore_dispatched_quantity, ore_dispatched_value) 
            VALUES (
                '$applicant_id', '$mineral_name', '$mineral_grade', '$state', '$plant','$open_stock','$close_stock','$ore_purchased_quantity','$ore_purchased_value','$ore_import_quantity','$ore_import_value','$ore_dispatched_quantity','$ore_dispatched_value')");
        }
    }

    public static function getReportM37ExportActivity($returnType, $date, $mineral, $grade, $plant)
    {
        $new_arr = array_filter(array_map('trim', $plant), 'strlen');
        $plant = implode(',', $new_arr);
        $grade = implode(',', $grade);
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_M37");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_M37` (
            `applicant_id` varchar(255) NOT NULL,
            `mineral_name` varchar(255) NOT NULL,
            `mineral_grade` varchar(255) NOT NULL,
            `state` varchar(255) NOT NULL,
            `plant_name` varchar(255) NOT NULL,
            `opening_stock` varchar(255) NOT NULL,
            `closing_stock` varchar(255) NOT NULL,
            `ore_purchased_quantity` varchar(255) NOT NULL,
            `ore_purchased_value` varchar(255) DEFAULT NULL,
            `ore_import_quantity` varchar(255) DEFAULT NULL,
            `ore_import_value` varchar(255) DEFAULT NULL,
            `ore_dispatched_quantity` varchar(255) DEFAULT NULL,
            `ore_dispatched_value` varchar(255) DEFAULT NULL
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_M37_ExportActivity('$returnType','$date','$mineral','$grade','$plant')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $applicant_id = $record['applicant_id'];
            $mineral_name = $record['local_mineral_code'];
            $mineral_grade = $record['local_grade_code'];
            $state = $record['state'];
            $plant1 = $record['plant_name1'];
            $plant2 = $record['plant_name2'];
            $plant = $plant1 . ' ' . $plant2;
            $open_stock = $record['opening_stock'];
            $close_stock = $record['closing_stock'];
            $ore_purchased_quantity = $record['ore_purchased_quantity'];
            $ore_purchased_value = $record['ore_purchased_value'];
            $ore_import_quantity = $record['ore_import_quantity'];
            $ore_import_value = $record['ore_import_value'];
            $ore_dispatched_quantity = $record['ore_dispatched_quantity'];
            $ore_dispatched_value = $record['ore_dispatched_value'];

            $queryState = $con->execute("SELECT state_name FROM dir_state WHERE state_code = '$state'");
            $recStates = $queryState->fetchAll('assoc');
            foreach ($recStates as $recState) {
                $state = $recState['state_name'];
            }

            $queryGrade = $con->execute("SELECT grade_name FROM dir_mineral_grade WHERE id = '$grade'");
            $recGrades = $queryGrade->fetchAll('assoc');
            foreach ($recGrades as $recGrade) {
                $mineral_grade = $recGrade['grade_name'];
            }

            $insert = $con->execute("INSERT INTO temp_reportico_report_M37 (applicant_id, mineral_name, mineral_grade, state, plant_name, opening_stock, closing_stock, ore_purchased_quantity, ore_purchased_value, ore_import_quantity, ore_import_value, ore_dispatched_quantity, ore_dispatched_value) 
            VALUES (
                '$applicant_id', '$mineral_name', '$mineral_grade', '$state', '$plant','$open_stock','$close_stock','$ore_purchased_quantity','$ore_purchased_value','$ore_import_quantity','$ore_import_value','$ore_dispatched_quantity','$ore_dispatched_value')");
        }
    }

    public static function getReportM38EndUseActivity($returnType, $date, $mineral, $grade, $plant)
    {
        $new_arr = array_filter(array_map('trim', $plant), 'strlen');
        $plant = implode(',', $new_arr);
        $grade = implode(',', $grade);
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_M38");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_M38` (
            `applicant_id` varchar(255) NOT NULL,
            `mineral_name` varchar(255) NOT NULL,
            `mineral_grade` varchar(255) NOT NULL,
            `state` varchar(255) NOT NULL,
            `plant_name` varchar(255) NOT NULL,
            `opening_stock` varchar(255) NOT NULL,
            `closing_stock` varchar(255) NOT NULL,
            `ore_purchased_quantity` varchar(255) NOT NULL,
            `ore_purchased_value` varchar(255) DEFAULT NULL,
            `ore_import_quantity` varchar(255) DEFAULT NULL,
            `ore_import_value` varchar(255) DEFAULT NULL,
            `ore_dispatched_quantity` varchar(255) DEFAULT NULL,
            `ore_dispatched_value` varchar(255) DEFAULT NULL
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_M38_EndUseActivity('$returnType','$date','$mineral','$grade','$plant')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $applicant_id = $record['applicant_id'];
            $mineral_name = $record['local_mineral_code'];
            $mineral_grade = $record['local_grade_code'];
            $state = $record['state'];
            $plant1 = $record['plant_name1'];
            $plant2 = $record['plant_name2'];
            $plant = $plant1 . ' ' . $plant2;
            $open_stock = $record['opening_stock'];
            $close_stock = $record['closing_stock'];
            $ore_purchased_quantity = $record['ore_purchased_quantity'];
            $ore_purchased_value = $record['ore_purchased_value'];
            $ore_import_quantity = $record['ore_import_quantity'];
            $ore_import_value = $record['ore_import_value'];
            $ore_dispatched_quantity = $record['ore_dispatched_quantity'];
            $ore_dispatched_value = $record['ore_dispatched_value'];

            $queryState = $con->execute("SELECT state_name FROM dir_state WHERE state_code = '$state'");
            $recStates = $queryState->fetchAll('assoc');
            foreach ($recStates as $recState) {
                $state = $recState['state_name'];
            }

            $queryGrade = $con->execute("SELECT grade_name FROM dir_mineral_grade WHERE id = '$grade'");
            $recGrades = $queryGrade->fetchAll('assoc');
            foreach ($recGrades as $recGrade) {
                $mineral_grade = $recGrade['grade_name'];
            }

            $insert = $con->execute("INSERT INTO temp_reportico_report_M38 (applicant_id, mineral_name, mineral_grade, state, plant_name, opening_stock, closing_stock, ore_purchased_quantity, ore_purchased_value, ore_import_quantity, ore_import_value, ore_dispatched_quantity, ore_dispatched_value) 
            VALUES (
                '$applicant_id', '$mineral_name', '$mineral_grade', '$state','$plant','$open_stock','$close_stock','$ore_purchased_quantity','$ore_purchased_value','$ore_import_quantity','$ore_import_value','$ore_dispatched_quantity','$ore_dispatched_value')");
        }
    }

    public static function getReportM39StorageActivity($returnType, $date, $mineral, $grade, $plant)
    {
        $new_arr = array_filter(array_map('trim', $plant), 'strlen');
        $plant = implode(',', $new_arr);
        $grade = implode(',', $grade);
        $con = ConnectionManager::get('default');

        $delete = $con->execute("DROP TABLE IF EXISTS temp_reportico_report_M39");

        $table = $con->execute("CREATE TABLE `temp_reportico_report_M39` (
            `applicant_id` varchar(255) NOT NULL,
            `mineral_name` varchar(255) NOT NULL,
            `mineral_grade` varchar(255) NOT NULL,
            `state` varchar(255) NOT NULL,
            `plant_name` varchar(255) NOT NULL,
            `opening_stock` varchar(255) NOT NULL,
            `closing_stock` varchar(255) NOT NULL,
            `ore_purchased_quantity` varchar(255) NOT NULL,
            `ore_purchased_value` varchar(255) DEFAULT NULL,
            `ore_import_quantity` varchar(255) DEFAULT NULL,
            `ore_import_value` varchar(255) DEFAULT NULL,
            `ore_dispatched_quantity` varchar(255) DEFAULT NULL,
            `ore_dispatched_value` varchar(255) DEFAULT NULL
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $query = $con->execute("CALL SP_Report_M39_StorageActivity('$returnType','$date','$mineral','$grade','$plant')");
        $records = $query->fetchAll('assoc');
        // print_r($records);exit;
        $query->closeCursor();

        foreach ($records as $record) {
            $applicant_id = $record['applicant_id'];
            $mineral_name = $record['local_mineral_code'];
            $mineral_grade = $record['local_grade_code'];
            $state = $record['state'];
            $plant1 = $record['plant_name1'];
            $plant2 = $record['plant_name2'];
            $plant = $plant1 . ' ' . $plant2;
            $open_stock = $record['opening_stock'];
            $close_stock = $record['closing_stock'];
            $ore_purchased_quantity = $record['ore_purchased_quantity'];
            $ore_purchased_value = $record['ore_purchased_value'];
            $ore_import_quantity = $record['ore_import_quantity'];
            $ore_import_value = $record['ore_import_value'];
            $ore_dispatched_quantity = $record['ore_dispatched_quantity'];
            $ore_dispatched_value = $record['ore_dispatched_value'];

            $queryState = $con->execute("SELECT state_name FROM dir_state WHERE state_code = '$state'");
            $recStates = $queryState->fetchAll('assoc');
            foreach ($recStates as $recState) {
                $state = $recState['state_name'];
            }

            $queryGrade = $con->execute("SELECT grade_name FROM dir_mineral_grade WHERE id = '$grade'");
            $recGrades = $queryGrade->fetchAll('assoc');
            foreach ($recGrades as $recGrade) {
                $mineral_grade = $recGrade['grade_name'];
            }

            $insert = $con->execute("INSERT INTO temp_reportico_report_M39 (applicant_id, mineral_name, mineral_grade, state, plant_name, opening_stock, closing_stock, ore_purchased_quantity, ore_purchased_value, ore_import_quantity, ore_import_value, ore_dispatched_quantity, ore_dispatched_value) 
            VALUES (
                '$applicant_id', '$mineral_name', '$mineral_grade', '$state','$plant','$open_stock','$close_stock','$ore_purchased_quantity','$ore_purchased_value','$ore_import_quantity','$ore_import_value','$ore_dispatched_quantity','$ore_dispatched_value')");
        }
    }
}
