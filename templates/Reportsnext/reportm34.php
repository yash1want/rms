<?php 

$mineral_name = '';
$state = "";
$district = "";

$tot_district = array();
$tot_state = array();
$tot_mineral = array();

$total_col = 5 + ($total_month * 3);
$total_col_plus = $total_col + 1;

$district_header_count = 0;

if (count($records) > 0) {

echo '<a href="../reportsnext/monthly-filter?title=reportm34" class="btn btn-primary backBtn mb-2">Back</a>';

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

            <td class="HEADER3" id="reportname">M15</td>
        </tr>        
    </tbody>';
echo '<tbody>';
foreach ($records as $key => $data) {

    if ($data['MineralName'] != $mineral_name) {

        echo '<tr><td colspan="'.$total_col_plus.'">&nbsp;</td></tr>';
        echo '<tr class="font-weight-bold"><td>MineralName</td><td colspan="'.$total_col.'">'.$data['MineralName'].'</td></tr>';
    }

    if ($data['MineralName'] != $mineral_name || ($data['MineralName'] == $mineral_name && $data['StateName'] != $state)) {

        $total_col = 5 + ($total_month * 3);
        echo '<tr class="font-weight-bold"><td>State Name</td><td colspan="'.$total_col.'">'.$data['StateName'].'</td></tr>';
    }

    if ($data['MineralName'] == $mineral_name && $data['StateName'] == $state) {
        //
    } else {

        echo '<tr class="font-weight-bold bg-light"><td>Mine Code</td><td>Mine Name</td><td>Owner Name</td><td>Reason</td>';
        
    }

    echo '<tr><td>'.$data['MineCode'].'</td>';
    echo '<td>'.$data['MineName'].'</td>';
    echo '<td>'.$data['OwnerName'].'</td>';
    echo '<td>'.$data['reason1'].'</td> </tr>';
    
    $mineral_name = $data['MineralName'];
    $state = $data['StateName'];

}

echo '</tbody>';
echo '</table>';
echo '</div>';
echo '</div>';

echo '<a href="../reportsnext/monthly-filter?title=reportm34" class="btn btn-primary backBtn mb-2">Back</a>';
echo '<a href="#" class="downloadExcel btn btn-success float-right mb-2">Export to Excel</a>';

} else {
    
echo '<a href="../reportsnext/monthly-filter?title=reportm34" class="btn btn-primary backBtn mb-2">Back</a>';

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