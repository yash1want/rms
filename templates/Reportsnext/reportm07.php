<?php 

$mineral_name = '';
$state = "";
$district = "";

$tot_district = array();
$tot_state = array();
$tot_mineral = array();

$total_col = 9 + ($total_month * 3);
$total_col_plus = $total_col + 1;

$district_header_count = 0;

if (count($records) > 0) {

echo '<a href="../reportsnext/monthly-filter?title=reportm07" class="btn btn-primary backBtn mb-2">Back</a>';

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

            <td class="HEADER3" id="reportname">M12-'. date("Y-m-d h:i:sa").'</td>
        </tr>
    </tbody>';
echo '<tbody>';
foreach ($records as $key => $data) {

    
    if ($data['MineralName'] == $mineral_name && $data['StateName'] == $state && $data['DistrictName'] == $district) {
        //
    } else {
        if ($key != 0){
            $key_pr = (int)$key - (int)1;
            echo '<tr><td colspan="7">'.$records[$key_pr]['DistrictName'].'</td>';
            foreach ($month_arr as $month) {
                echo '<td>'.$tot_district[$records[$key_pr]['MineralName']][$records[$key_pr]['StateName']][$records[$key_pr]['DistrictName']][$month['month_name'].'Male'].'</td>';
                echo '<td>'.$tot_district[$records[$key_pr]['MineralName']][$records[$key_pr]['StateName']][$records[$key_pr]['DistrictName']][$month['month_name'].'Female'].'</td>';
                echo '<td>'.$tot_district[$records[$key_pr]['MineralName']][$records[$key_pr]['StateName']][$records[$key_pr]['DistrictName']][$month['month_name'].'Total'].'</td>';
            }
            echo '<td>'.$tot_district[$records[$key_pr]['MineralName']][$records[$key_pr]['StateName']][$records[$key_pr]['DistrictName']]['MaleAverage'].'</td>';
            echo '<td>'.$tot_district[$records[$key_pr]['MineralName']][$records[$key_pr]['StateName']][$records[$key_pr]['DistrictName']]['FemaleAverage'].'</td>';
            echo '<td>'.$tot_district[$records[$key_pr]['MineralName']][$records[$key_pr]['StateName']][$records[$key_pr]['DistrictName']]['TotalAverage'].'</td>
            </tr>';
        }
    }

    
    if ($data['MineralName'] != $mineral_name || ($data['MineralName'] == $mineral_name && $data['StateName'] != $state)) {

        if ($key != 0){
            $key_pr = (int)$key - (int)1;
            echo '<tr><td colspan="7">'.$records[$key_pr]['StateName'].'</td>';
            foreach ($month_arr as $month) {
                echo '<td>'.$tot_state[$records[$key_pr]['MineralName']][$records[$key_pr]['StateName']][$month['month_name'].'Male'].'</td>';
                echo '<td>'.$tot_state[$records[$key_pr]['MineralName']][$records[$key_pr]['StateName']][$month['month_name'].'Female'].'</td>';
                echo '<td>'.$tot_state[$records[$key_pr]['MineralName']][$records[$key_pr]['StateName']][$month['month_name'].'Total'].'</td>';
            }
            echo '<td>'.$tot_state[$records[$key_pr]['MineralName']][$records[$key_pr]['StateName']]['MaleAverage'].'</td>';
            echo '<td>'.$tot_state[$records[$key_pr]['MineralName']][$records[$key_pr]['StateName']]['FemaleAverage'].'</td>';
            echo '<td>'.$tot_state[$records[$key_pr]['MineralName']][$records[$key_pr]['StateName']]['TotalAverage'].'</td>
            </tr>';
        }

    }
    
    if ($data['MineralName'] != $mineral_name) {

        if ($key != 0){
            $key_pr = (int)$key - (int)1;
            echo '<tr><td colspan="7">'.$records[$key_pr]['MineralName'].'</td>';
            foreach ($month_arr as $month) {
                echo '<td>'.$tot_mineral[$records[$key_pr]['MineralName']][$month['month_name'].'Male'].'</td>';
                echo '<td>'.$tot_mineral[$records[$key_pr]['MineralName']][$month['month_name'].'Female'].'</td>';
                echo '<td>'.$tot_mineral[$records[$key_pr]['MineralName']][$month['month_name'].'Total'].'</td>';
            }
            echo '<td>'.$tot_mineral[$records[$key_pr]['MineralName']]['MaleAverage'].'</td>';
            echo '<td>'.$tot_mineral[$records[$key_pr]['MineralName']]['FemaleAverage'].'</td>';
            echo '<td>'.$tot_mineral[$records[$key_pr]['MineralName']]['TotalAverage'].'</td>
            </tr>';
        }

    }

    if ($data['MineralName'] != $mineral_name) {

        echo '<tr><td colspan="'.$total_col_plus.'">&nbsp;</td></tr>';
        echo '<tr class="font-weight-bold"><td>MineralName</td><td colspan="'.$total_col.'">'.$data['MineralName'].'</td></tr>';
    }

    if ($data['MineralName'] != $mineral_name || ($data['MineralName'] == $mineral_name && $data['StateName'] != $state)) {

        $total_col = 9 + ($total_month * 3);
        echo '<tr class="font-weight-bold"><td>State Name</td><td colspan="'.$total_col.'">'.$data['StateName'].'</td></tr>';
    }

    if ($data['DistrictName'] != $district) {

        $total_col = 9 + ($total_month * 3);
        echo '<tr class="font-weight-bold"><td>DistrictName</td><td colspan="'.$total_col.'">'.$data['DistrictName'].'</td></tr>';
    }

    if ($data['MineralName'] == $mineral_name && $data['StateName'] == $state && $data['DistrictName'] == $district) {
        //
    } else {

        echo '<tr class="font-weight-bold bg-light"><td rowspan="2">Mine Code</td><td rowspan="2">Mine Name</td><td rowspan="2">Owner Name</td><td rowspan="2">Mine Category</td><td rowspan="2">Type of Working</td><td rowspan="2">Mechanisation</td><td rowspan="2">Mine Ownership</td>';
        foreach ($month_arr as $month) {
            echo '<td colspan="3">'.$month['month_label'].'</td>';
        }
        echo '<td colspan="3">Total</td></tr>';
        echo '<tr class="font-weight-bold bg-light">';
        foreach ($month_arr as $month) {
            echo '<td>Male</td><td>Female</td><td>Total</td>';
        }
        echo '<td>Male</td><td>Female</td><td>Total</td></tr>';
    }

    echo '<tr><td>'.$data['MineCode'].'</td>';
    echo '<td>'.$data['MineName'].'</td>';
    echo '<td>'.$data['OwnerName'].'</td>';
	
    echo '<td>'.$data['MineCategory'].'</td>';
    echo '<td>'.$data['TypeWorking'].'</td>';
    echo '<td>'.$data['Mechanisation'].'</td>';
    echo '<td>'.$data['MineOwnership'].'</td>';
	
    foreach ($month_arr as $month) {
        echo '<td>'.$data[$month['month_name'].'Male'].'</td>';
        echo '<td>'.$data[$month['month_name'].'Female'].'</td>';
        echo '<td>'.$data[$month['month_name'].'Total'].'</td>';

        // total district
        $last_district_direct = (isset($tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']][$month['month_name'].'Male'])) ? $tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']][$month['month_name'].'Male'] : 0;
        $tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']][$month['month_name'].'Male'] = (float)$last_district_direct + (float)$data[$month['month_name'].'Male'];
        
        $last_district_contract = (isset($tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']][$month['month_name'].'Female'])) ? $tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']][$month['month_name'].'Female'] : 0;
        $tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']][$month['month_name'].'Female'] = (float)$last_district_contract + (float)$data[$month['month_name'].'Female'];
        
        $last_district_tot = (isset($tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']][$month['month_name'].'Total'])) ? $tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']][$month['month_name'].'Total'] : 0;
        $tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']][$month['month_name'].'Total'] = (float)$last_district_tot + (float)$data[$month['month_name'].'Total'];

        // total state
        $last_state_direct = (isset($tot_state[$data['MineralName']][$data['StateName']][$month['month_name'].'Male'])) ? $tot_state[$data['MineralName']][$data['StateName']][$month['month_name'].'Male'] : 0;
        $tot_state[$data['MineralName']][$data['StateName']][$month['month_name'].'Male'] = (float)$last_state_direct + (float)$data[$month['month_name'].'Male'];
        
        $last_state_contract = (isset($tot_state[$data['MineralName']][$data['StateName']][$month['month_name'].'Female'])) ? $tot_state[$data['MineralName']][$data['StateName']][$month['month_name'].'Female'] : 0;
        $tot_state[$data['MineralName']][$data['StateName']][$month['month_name'].'Female'] = (float)$last_state_contract + (float)$data[$month['month_name'].'Female'];
        
        $last_state_tot = (isset($tot_state[$data['MineralName']][$data['StateName']][$month['month_name'].'Total'])) ? $tot_state[$data['MineralName']][$data['StateName']][$month['month_name'].'Total'] : 0;
        $tot_state[$data['MineralName']][$data['StateName']][$month['month_name'].'Total'] = (float)$last_state_tot + (float)$data[$month['month_name'].'Total'];

        // total mineral
        $last_mineral_direct = (isset($tot_mineral[$data['MineralName']][$month['month_name'].'Male'])) ? $tot_mineral[$data['MineralName']][$month['month_name'].'Male'] : 0;
        $tot_mineral[$data['MineralName']][$month['month_name'].'Male'] = (float)$last_mineral_direct + (float)$data[$month['month_name'].'Male'];
        
        $last_mineral_contract = (isset($tot_mineral[$data['MineralName']][$month['month_name'].'Female'])) ? $tot_mineral[$data['MineralName']][$month['month_name'].'Female'] : 0;
        $tot_mineral[$data['MineralName']][$month['month_name'].'Female'] = (float)$last_mineral_contract + (float)$data[$month['month_name'].'Female'];
        
        $last_mineral_tot = (isset($tot_mineral[$data['MineralName']][$month['month_name'].'Total'])) ? $tot_mineral[$data['MineralName']][$month['month_name'].'Total'] : 0;
        $tot_mineral[$data['MineralName']][$month['month_name'].'Total'] = (float)$last_mineral_tot + (float)$data[$month['month_name'].'Total'];

    }
    
    echo '<td>'.$data['MaleAverage'].'</td>';
    echo '<td>'.$data['FemaleAverage'].'</td>';
    echo '<td>'.$data['TotalAverage'].'</td>
    </tr>';
    
    // // total district
    $last_district_direct = (isset($tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']]['MaleAverage'])) ? $tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']]['MaleAverage'] : 0;
    $tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']]['MaleAverage'] = (float)$last_district_direct + (float)$data['MaleAverage'];
    
    $last_district_contract = (isset($tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']]['FemaleAverage'])) ? $tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']]['FemaleAverage'] : 0;
    $tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']]['FemaleAverage'] = (float)$last_district_contract + (float)$data['FemaleAverage'];
    
    $last_district_tot = (isset($tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']]['TotalAverage'])) ? $tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']]['TotalAverage'] : 0;
    $tot_district[$data['MineralName']][$data['StateName']][$data['DistrictName']]['TotalAverage'] = (float)$last_district_tot + (float)$data['TotalAverage'];
    
    // total state
    $last_state_direct = (isset($tot_state[$data['MineralName']][$data['StateName']]['MaleAverage'])) ? $tot_state[$data['MineralName']][$data['StateName']]['MaleAverage'] : 0;
    $tot_state[$data['MineralName']][$data['StateName']]['MaleAverage'] = (float)$last_state_direct + (float)$data['MaleAverage'];
    
    $last_state_contract = (isset($tot_state[$data['MineralName']][$data['StateName']]['FemaleAverage'])) ? $tot_state[$data['MineralName']][$data['StateName']]['FemaleAverage'] : 0;
    $tot_state[$data['MineralName']][$data['StateName']]['FemaleAverage'] = (float)$last_state_contract + (float)$data['FemaleAverage'];
    
    $last_state_tot = (isset($tot_state[$data['MineralName']][$data['StateName']]['TotalAverage'])) ? $tot_state[$data['MineralName']][$data['StateName']]['TotalAverage'] : 0;
    $tot_state[$data['MineralName']][$data['StateName']]['TotalAverage'] = (float)$last_state_tot + (float)$data['TotalAverage'];
    
    // total mineral
    $last_mineral_direct = (isset($tot_mineral[$data['MineralName']]['MaleAverage'])) ? $tot_mineral[$data['MineralName']]['MaleAverage'] : 0;
    $tot_mineral[$data['MineralName']]['MaleAverage'] = (float)$last_mineral_direct + (float)$data['MaleAverage'];
    
    $last_mineral_contract = (isset($tot_mineral[$data['MineralName']]['FemaleAverage'])) ? $tot_mineral[$data['MineralName']]['FemaleAverage'] : 0;
    $tot_mineral[$data['MineralName']]['FemaleAverage'] = (float)$last_mineral_contract + (float)$data['FemaleAverage'];
    
    $last_mineral_tot = (isset($tot_mineral[$data['MineralName']]['TotalAverage'])) ? $tot_mineral[$data['MineralName']]['TotalAverage'] : 0;
    $tot_mineral[$data['MineralName']]['TotalAverage'] = (float)$last_mineral_tot + (float)$data['TotalAverage'];

    $key_nx = (int)$key + (int)1;
    if (!isset($records[$key_nx]['MineralName'])){
        echo '<tr><td colspan="7">'.$records[$key]['DistrictName'].'</td>';
        foreach ($month_arr as $month) {
            echo '<td>'.$tot_district[$records[$key]['MineralName']][$records[$key]['StateName']][$records[$key]['DistrictName']][$month['month_name'].'Male'].'</td>';
            echo '<td>'.$tot_district[$records[$key]['MineralName']][$records[$key]['StateName']][$records[$key]['DistrictName']][$month['month_name'].'Female'].'</td>';
            echo '<td>'.$tot_district[$records[$key]['MineralName']][$records[$key]['StateName']][$records[$key]['DistrictName']][$month['month_name'].'Total'].'</td>';
        }
        echo '<td>'.$tot_district[$records[$key]['MineralName']][$records[$key]['StateName']][$records[$key]['DistrictName']]['MaleAverage'].'</td>';
        echo '<td>'.$tot_district[$records[$key]['MineralName']][$records[$key]['StateName']][$records[$key]['DistrictName']]['FemaleAverage'].'</td>';
        echo '<td>'.$tot_district[$records[$key]['MineralName']][$records[$key]['StateName']][$records[$key]['DistrictName']]['TotalAverage'].'</td>
        </tr>';
    }
    
    $key_nx = (int)$key + (int)1;
    if (!isset($records[$key_nx]['StateName'])){
        echo '<tr><td colspan="7">'.$records[$key]['StateName'].'</td>';
        foreach ($month_arr as $month) {
            echo '<td>'.$tot_state[$records[$key]['MineralName']][$records[$key]['StateName']][$month['month_name'].'Male'].'</td>';
            echo '<td>'.$tot_state[$records[$key]['MineralName']][$records[$key]['StateName']][$month['month_name'].'Female'].'</td>';
            echo '<td>'.$tot_state[$records[$key]['MineralName']][$records[$key]['StateName']][$month['month_name'].'Total'].'</td>';
        }
        echo '<td>'.$tot_state[$records[$key]['MineralName']][$records[$key]['StateName']]['MaleAverage'].'</td>';
        echo '<td>'.$tot_state[$records[$key]['MineralName']][$records[$key]['StateName']]['FemaleAverage'].'</td>';
        echo '<td>'.$tot_state[$records[$key]['MineralName']][$records[$key]['StateName']]['TotalAverage'].'</td>
        </tr>';
    }
    
    $key_nx = (int)$key + (int)1;
    if (!isset($records[$key_nx]['MineralName'])){
        echo '<tr><td colspan="7">'.$records[$key]['MineralName'].'</td>';
        foreach ($month_arr as $month) {
            echo '<td>'.$tot_mineral[$records[$key]['MineralName']][$month['month_name'].'Male'].'</td>';
            echo '<td>'.$tot_mineral[$records[$key]['MineralName']][$month['month_name'].'Female'].'</td>';
            echo '<td>'.$tot_mineral[$records[$key]['MineralName']][$month['month_name'].'Total'].'</td>';
        }
        echo '<td>'.$tot_mineral[$records[$key]['MineralName']]['MaleAverage'].'</td>';
        echo '<td>'.$tot_mineral[$records[$key]['MineralName']]['FemaleAverage'].'</td>';
        echo '<td>'.$tot_mineral[$records[$key]['MineralName']]['TotalAverage'].'</td>
        </tr>';
    }

    $mineral_name = $data['MineralName'];
    $state = $data['StateName'];
    $district = $data['DistrictName'];

}

echo '</tbody>';
echo '</table>';
echo '</div>';
echo '</div>';

echo '<a href="../reportsnext/monthly-filter?title=reportm07" class="btn btn-primary backBtn mb-2">Back</a>';
echo '<a href="#" class="downloadExcel btn btn-success float-right mb-2">Export to Excel</a>';

} else {
    
echo '<a href="../reportsnext/monthly-filter?title=reportm07" class="btn btn-primary backBtn mb-2">Back</a>';

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


?>