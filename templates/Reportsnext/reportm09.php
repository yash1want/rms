<?php 

$mineral_name = '';
$state = "";
$district = "";

$tot_district = array();
$tot_state = array();
$tot_mineral = array();

$total_col = 10 + ($total_month * 3);
$total_col_plus = $total_col + 1;

$district_header_count = 0;

if (count($records) > 0) {

echo '<a href="../reportsnext/monthly-filter?title=reportm09" class="btn btn-primary backBtn mb-2">Back</a>';

echo '<a href="#" class="downloadExcel btn btn-success float-right mb-2">Export to Excel</a>';

echo '<div class="container-fluid mt-2">';
    
echo '<div id ="main_tb" class="container-fluid">';

echo '<table class="table data_tbl">';

echo '<tbody class="bg-secondary text-white"><tr>
            <td colspan="'.$total_col_plus.'" class="HEADER01" align="CENTER">
            <b>INDIAN BUREAU OF MINES</b>                  
            </td>
        </tr>
        <tr>
            <td colspan="'.$total_col_plus.'" class="HEADER02" align="CENTER">
            <b>'.$report_name.'</b>
            </td>

            <td class="HEADER3" id="reportname">M14-'. date("Y-m-d h:i:sa").'</td>
        </tr>        
    </tbody>';
echo '<tbody>';
foreach ($records as $key => $data) {

    
    if ($data['MineralName'] == $mineral_name && $data['StateName'] == $state && $data['DistrictName'] == $district) {
        //
    } else {
        if ($key != 0){
            $key_pr = (int)$key - (int)1;
            echo '<tr><td colspan="8">'.$records[$key_pr]['DistrictName'].'</td>';
            foreach ($month_arr as $month) {
                echo '<td>'.$tot_district[$records[$key_pr]['MineralName']][$records[$key_pr]['StateName']][$records[$key_pr]['DistrictName']][$month['month_name'].'Employee'].'</td>';
                echo '<td>'.$tot_district[$records[$key_pr]['MineralName']][$records[$key_pr]['StateName']][$records[$key_pr]['DistrictName']][$month['month_name'].'Wages'].'</td>';
                '</td>';
            }
            echo '<td>'.$tot_district[$records[$key_pr]['MineralName']][$records[$key_pr]['StateName']][$records[$key_pr]['DistrictName']]['EmployeeAverage'].'</td>';
            echo '<td>'.$tot_district[$records[$key_pr]['MineralName']][$records[$key_pr]['StateName']][$records[$key_pr]['DistrictName']]['WagesTotal'].'</td>';
           '</tr>';
        }
    }

    
    if ($data['MineralName'] != $mineral_name || ($data['MineralName'] == $mineral_name && $data['StateName'] != $state)) {

        if ($key != 0){
            $key_pr = (int)$key - (int)1;
            echo '<tr><td colspan="8">'.$records[$key_pr]['StateName'].'</td>';
            foreach ($month_arr as $month) {
                echo '<td>'.$tot_state[$records[$key_pr]['MineralName']][$records[$key_pr]['StateName']][$month['month_name'].'Employee'].'</td>';
                echo '<td>'.$tot_state[$records[$key_pr]['MineralName']][$records[$key_pr]['StateName']][$month['month_name'].'Wages'].'</td>';
            }
            echo '<td>'.$tot_state[$records[$key_pr]['MineralName']][$records[$key_pr]['StateName']]['EmployeeAverage'].'</td>';
            echo '<td>'.$tot_state[$records[$key_pr]['MineralName']][$records[$key_pr]['StateName']]['WagesTotal'].'</td>';
            '</tr>';
        }

    }
    
    if ($data['MineralName'] != $mineral_name) {

        if ($key != 0){
            $key_pr = (int)$key - (int)1;
            echo '<tr><td colspan="8">'.$records[$key_pr]['MineralName'].'</td>';
            foreach ($month_arr as $month) {
                echo '<td>'.$tot_mineral[$records[$key_pr]['MineralName']][$month['month_name'].'Employee'].'</td>';
                echo '<td>'.$tot_mineral[$records[$key_pr]['MineralName']][$month['month_name'].'Wages'].'</td>';
            }
            echo '<td>'.$tot_mineral[$records[$key_pr]['MineralName']]['EmployeeAverage'].'</td>';
            echo '<td>'.$tot_mineral[$records[$key_pr]['MineralName']]['WagesTotal'].'</td>';
            '</tr>';
        }

    }

    if ($data['MineralName'] != $mineral_name) {

        echo '<tr><td colspan="'.$total_col_plus.'">&nbsp;</td></tr>';
        echo '<tr class="font-weight-bold"><td>MineralName</td><td colspan="'.$total_col.'">'.$data['MineralName'].'</td></tr>';
    }

    if ($data['MineralName'] != $mineral_name || ($data['MineralName'] == $mineral_name && $data['StateName'] != $state)) {

        $total_col = 10 + ($total_month * 3);
        echo '<tr class="font-weight-bold"><td>State Name</td><td colspan="'.$total_col.'">'.$data['StateName'].'</td></tr>';
    }

    if ($data['DistrictName'] != $district) {

        $total_col = 10 + ($total_month * 3);
        echo '<tr class="font-weight-bold"><td>DistrictName</td><td colspan="'.$total_col.'">'.$data['DistrictName'].'</td></tr>';
    }

    if ($data['MineralName'] == $mineral_name && $data['StateName'] == $state && $data['DistrictName'] == $district) {
        //
    } else {

        echo '<tr class="font-weight-bold bg-light"><td rowspan="2">Mine Code</td><td rowspan="2">Mine Name</td><td rowspan="2">Owner Name</td><td rowspan="2">Work Place</td>
		<td rowspan="2">Mine Category</td><td rowspan="2">Type of Working</td><td rowspan="2">Mechanisation</td><td rowspan="2">Mine Ownership</td>';
        foreach ($month_arr as $month) {
            echo '<td colspan="2">'.$month['month_label'].'</td>';
        }
        echo '<td colspan="2">Total</td></tr>';
        echo '<tr class="font-weight-bold bg-light">';
        foreach ($month_arr as $month) {
            echo '<td>Avg Daily Emp</td><td>Wages</td>';
        }
        echo '<td>Avg Daily Emp</td><td>Wages</td></tr>';
    }

    echo '<tr><td>'.$data['MineCode'].'</td>';
    echo '<td>'.$data['MineName'].'</td>';
    echo '<td>'.$data['OwnerName'].'</td>';
    echo '<td>'.$data['employee_classif_def'].'</td>';
	// Added by Shweta Apale on 28-02-2023
    echo '<td>'.$data['MineCategory'].'</td>';
    echo '<td>'.$data['TypeWorking'].'</td>';
    echo '<td>'.$data['Mechanisation'].'</td>';
    echo '<td>'.$data['MineOwnership'].'</td>';	  
    
    foreach ($month_arr as $month) {
        echo '<td>'.$data[$month['month_name'].'Employee'].'</td>';
        echo '<td>'.$data[$month['month_name'].'Wages'].'</td>';

        // total district
        $last_district_direct = (isset($tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']][$month['month_name'].'Employee'])) ? $tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']][$month['month_name'].'Employee'] : 0;
        $tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']][$month['month_name'].'Employee'] = (float)$last_district_direct + (float)$data[$month['month_name'].'Employee'];
        
        $last_district_contract = (isset($tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']][$month['month_name'].'Wages'])) ? $tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']][$month['month_name'].'Wages'] : 0;
        $tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']][$month['month_name'].'Wages'] = (float)$last_district_contract + (float)$data[$month['month_name'].'Wages'];
     
        // total state
        $last_state_direct = (isset($tot_state[$data['MineralName']][$data['StateName']][$month['month_name'].'Employee'])) ? $tot_state[$data['MineralName']][$data['StateName']][$month['month_name'].'Employee'] : 0;
        $tot_state[$data['MineralName']][$data['StateName']][$month['month_name'].'Employee'] = (float)$last_state_direct + (float)$data[$month['month_name'].'Employee'];
        
        $last_state_contract = (isset($tot_state[$data['MineralName']][$data['StateName']][$month['month_name'].'Wages'])) ? $tot_state[$data['MineralName']][$data['StateName']][$month['month_name'].'Wages'] : 0;
        $tot_state[$data['MineralName']][$data['StateName']][$month['month_name'].'Wages'] = (float)$last_state_contract + (float)$data[$month['month_name'].'Wages'];
              
        // total mineral
        $last_mineral_direct = (isset($tot_mineral[$data['MineralName']][$month['month_name'].'Employee'])) ? $tot_mineral[$data['MineralName']][$month['month_name'].'Employee'] : 0;
        $tot_mineral[$data['MineralName']][$month['month_name'].'Employee'] = (float)$last_mineral_direct + (float)$data[$month['month_name'].'Employee'];
        
        $last_mineral_contract = (isset($tot_mineral[$data['MineralName']][$month['month_name'].'Wages'])) ? $tot_mineral[$data['MineralName']][$month['month_name'].'Wages'] : 0;
        $tot_mineral[$data['MineralName']][$month['month_name'].'Wages'] = (float)$last_mineral_contract + (float)$data[$month['month_name'].'Wages'];        
    }
    
    echo '<td>'.$data['EmployeeAverage'].'</td>';
    echo '<td>'.$data['WagesTotal'].'</td>';
    '</tr>';
    
    // // total district
    $last_district_direct = (isset($tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']]['EmployeeAverage'])) ? $tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']]['EmployeeAverage'] : 0;
    $tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']]['EmployeeAverage'] = (float)$last_district_direct + (float)$data['EmployeeAverage'];
    
    $last_district_contract = (isset($tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']]['WagesTotal'])) ? $tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']]['WagesTotal'] : 0;
    $tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']]['WagesTotal'] = (float)$last_district_contract + (float)$data['WagesTotal'];    
    
    // total state
    $last_state_direct = (isset($tot_state[$data['MineralName']][$data['StateName']]['EmployeeAverage'])) ? $tot_state[$data['MineralName']][$data['StateName']]['EmployeeAverage'] : 0;
    $tot_state[$data['MineralName']][$data['StateName']]['EmployeeAverage'] = (float)$last_state_direct + (float)$data['EmployeeAverage'];
    
    $last_state_contract = (isset($tot_state[$data['MineralName']][$data['StateName']]['WagesTotal'])) ? $tot_state[$data['MineralName']][$data['StateName']]['WagesTotal'] : 0;
    $tot_state[$data['MineralName']][$data['StateName']]['WagesTotal'] = (float)$last_state_contract + (float)$data['WagesTotal'];
    
    // total mineral
    $last_mineral_direct = (isset($tot_mineral[$data['MineralName']]['EmployeeAverage'])) ? $tot_mineral[$data['MineralName']]['EmployeeAverage'] : 0;
    $tot_mineral[$data['MineralName']]['EmployeeAverage'] = (float)$last_mineral_direct + (float)$data['EmployeeAverage'];
    
    $last_mineral_contract = (isset($tot_mineral[$data['MineralName']]['WagesTotal'])) ? $tot_mineral[$data['MineralName']]['WagesTotal'] : 0;
    $tot_mineral[$data['MineralName']]['WagesTotal'] = (float)$last_mineral_contract + (float)$data['WagesTotal'];

    $key_nx = (int)$key + (int)1;
    if (!isset($records[$key_nx]['MineralName'])){
        echo '<tr><td colspan="8">'.$records[$key]['DistrictName'].'</td>';
        foreach ($month_arr as $month) {
            echo '<td>'.$tot_district[$records[$key]['MineralName']][$records[$key]['StateName']][$records[$key]['DistrictName']][$month['month_name'].'Employee'].'</td>';
            echo '<td>'.$tot_district[$records[$key]['MineralName']][$records[$key]['StateName']][$records[$key]['DistrictName']][$month['month_name'].'Wages'].'</td>';
        }
        echo '<td>'.$tot_district[$records[$key]['MineralName']][$records[$key]['StateName']][$records[$key]['DistrictName']]['EmployeeAverage'].'</td>';
        echo '<td>'.$tot_district[$records[$key]['MineralName']][$records[$key]['StateName']][$records[$key]['DistrictName']]['WagesTotal'].'</td>';
        '</tr>';
    }
    
    $key_nx = (int)$key + (int)1;
    if (!isset($records[$key_nx]['StateName'])){
        echo '<tr><td colspan="8">'.$records[$key]['StateName'].'</td>';
        foreach ($month_arr as $month) {
            echo '<td>'.$tot_state[$records[$key]['MineralName']][$records[$key]['StateName']][$month['month_name'].'Employee'].'</td>';
            echo '<td>'.$tot_state[$records[$key]['MineralName']][$records[$key]['StateName']][$month['month_name'].'Wages'].'</td>';
        }
        echo '<td>'.$tot_state[$records[$key]['MineralName']][$records[$key]['StateName']]['EmployeeAverage'].'</td>';
        echo '<td>'.$tot_state[$records[$key]['MineralName']][$records[$key]['StateName']]['WagesTotal'].'</td>';
        '</tr>';
    }
    
    $key_nx = (int)$key + (int)1;
    if (!isset($records[$key_nx]['MineralName'])){
        echo '<tr><td colspan="8">'.$records[$key]['MineralName'].'</td>';
        foreach ($month_arr as $month) {
            echo '<td>'.$tot_mineral[$records[$key]['MineralName']][$month['month_name'].'Employee'].'</td>';
            echo '<td>'.$tot_mineral[$records[$key]['MineralName']][$month['month_name'].'Wages'].'</td>';
        }
        echo '<td>'.$tot_mineral[$records[$key]['MineralName']]['EmployeeAverage'].'</td>';
        echo '<td>'.$tot_mineral[$records[$key]['MineralName']]['WagesTotal'].'</td>';
        '</tr>';
    }

    $mineral_name = $data['MineralName'];
    $state = $data['StateName'];
    $district = $data['DistrictName'];

}

echo '</tbody>';
echo '</table>';
echo '</div>';
echo '</div>';

echo '<a href="../reportsnext/monthly-filter?title=reportm09" class="btn btn-primary backBtn mb-2">Back</a>';
echo '<a href="#" class="downloadExcel btn btn-success float-right mb-2">Export to Excel</a>';

} else {
    
echo '<a href="../reportsnext/monthly-filter?title=reportm09" class="btn btn-primary backBtn mb-2">Back</a>';

echo '<div class="container-fluid mt-2">';
echo '<table border="0" cellpadding="2" cellspacing="0" width="100%" height="100">
        <tbody class="bg-secondary text-white"><tr>
            <td class="HEADER01" align="CENTER">
            <b>INDIAN BUREAU OF MINES</b>                  
            </td>
        </tr>
        <tr>
            <td class="HEADER02" align="CENTER">
            <b>'.$report_name.'</b>
            </td>
        </tr>
    </tbody></table>';
echo '<table class="table text-center"><tr><td><h4 class="font-weight-bold">No data available.</h4></td></tr></table>';
echo '</div>';
}


?><?php ?>