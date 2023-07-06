
<table id="final-submit-error"></table>

<?php 

$loginUserType = $this->getRequest()->getSession()->read('loginusertype');
$returnType = $this->getRequest()->getSession()->read('returnType');
$returnTypeSm = strtolower($returnType);
$controller = $this->request->getParam('controller');
$action_ctrl = $controller;
$action = $this->request->getParam('action');
$pass = $this->request->getParam('pass');
$passArr = json_encode($pass);
$newPass = str_replace('[','',$passArr);
$newPass = str_replace(']','',$newPass);
$newPass = str_replace(',','/',$newPass);
$newPass = str_replace('"','',$newPass);
$pass_arr = explode('/', $newPass);
$param_one = (isset($pass_arr[0])) ? $pass_arr[0] : '';
$param_two = (isset($pass_arr[1])) ? $pass_arr[1] : '';

switch($loginUserType){
    case "authuser":
        $controller = 'Monthly';
        $submit_ctrl = $returnTypeSm;
        $print_pdf_action = 'minerPrintPdf';
        $home_action = 'auth-home';
        break;
    case "enduser":
        $controller = 'Enduser';
        $submit_ctrl = 'enduser';
        $print_pdf_action = 'enduserPrintPdf';
        $home_action = 'enduser-home';
        break;
    default:
        $controller = 'Monthly';
        $submit_ctrl = 'monthly';
        // $print_pdf_action = 'minerPrintPdf';
        $print_pdf_action = ($_SESSION['view_user_type'] == 'enduser') ? 'enduserPrintPdf' : 'minerPrintPdf';
        $home_action = 'auth-home';
}

echo $this->Form->control('',['type'=>'hidden', 'id'=>'final_submit_url', 'value'=>$this->Url->build(array('controller'=>$submit_ctrl, 'action'=>'finalSubmit'))]);
echo $this->Form->control('',['type'=>'hidden', 'id'=>'pdf_generation_url', 'value'=>$this->Url->build(array('controller'=>'returnspdf', 'action'=>$print_pdf_action))]);
echo $this->Form->control('',['type'=>'hidden', 'id'=>'esign_xml_url', 'value'=>$this->Url->build(array('controller'=>'esign', 'action'=>'createEsignXmlAjax'))]);

$finalSubmitUrl = $this->Url->build(array('controller'=>$controller, 'action'=>'finalSubmit'));
$curAction = $this->getRequest()->getParam('action');
$is_mine_owner_except  = array( 'conReco', 'exMine', 'prodStockDis', 'romStocksOre', 'romStocksThree', 'salesDespatches', 'salesMetalProduct', 'smeltReco', 
                                'tradingActivity', 'exportOfOre', 'mineralBaseActivity', 'storageActivity');
$view_only_section = array('oreType');
$isMineOwner = (!isset($isMineOwner)) ? null : $isMineOwner;





/*
$curAction = $this->getRequest()->getParam('action');
$firstSec = array('mine', 'instruction');
if(!in_array($curAction, $firstSec)){
    echo $this->Html->link('<i class="fa fa-arrow-left"></i> Previous', array('controller'=>$controller,'action'=>'prevSection',$action,$action_ctrl,$param_one,$param_two), array('class'=>'mt-2 btn btn-info btn-lg ml-1 spinner_btn_nxt float-left form_btn_prev', 'escape'=>false));
}
*/






if ($isMineOwner == true && (!in_array($curAction, $is_mine_owner_except))) {
    
    //echo link_to($btnLabel['next'], 'monthly/F1?partI=name_address&MC=' . $mineCode . '&M=' . $returnMonth . '&Y=' . $returnYear, array('id' => 'next1', "class" => "btn", "style" => "text-align:center;display:inline; text-decoration:none; padding:2px 10px;"));
    // echo $this->Html->link('Next <i class="fa fa-arrow-right"></i>', '#', array('class'=>'mt-2 btn btn-primary btn-lg spinner_btn_nxt', 'id'=>'next1', 'escape'=>false));
    // echo $this->Html->link('Next 11<i class="fa fa-arrow-right"></i>', array('controller'=>$controller,'action'=>'nextSection',$action,$action_ctrl,$param_one,$param_two), array('id'=>'next1', 'class'=>'mt-2 btn btn-info btn-lg ml-1 spinner_btn_nxt', 'escapeTitle'=>false));

} else {
    
    if ($is_all_approved == false) {

        if (in_array($curAction, $view_only_section)) {
            
            if ($viewOnly == true) {
                
                //if rejected and By-default allow the user to save
                //echo tag('input', array('name' => 'submit', 'type' => 'submit', 'id' => 'submit', "value" => $btnLabel['savenext'], "class" => "btn", "style" => "width:auto; text-align:center"));
                echo $this->Form->button('Save & Next', array('type'=>'submit','id'=>'submit','class'=>'mt-2 ml-1 btn btn-success btn-lg spinner_btn'));
    
            } else {
                
                //if approved, only next link should be visible. No Save Button
    
                //ADDED THE CODE BELOW FOR CORRECT NAVIGATION IN CASE OF ANNUAL RETURNS
                //@author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
                //@version Oct 15th 2014
                if ($returnType == "ANNUAL") {
                    
                    //echo link_to($btnLabel['savenext'], 'h1/address', array('id' => 'next1', "class" => "btn", "style" => "text-align:center;display:inline; text-decoration:none; padding:2px 10px;"));
                    echo $this->Html->link('Save & Next', '#', array('class'=>'ml-1 mt-2 btn btn-primary btn-lg spinner_btn', 'id'=>'next1', 'escape'=>false));
                    
                } else {
                    
                    //echo link_to($btnLabel['savenext'], 'monthly/F1?partI=name_address&MC=' . $mineCode . '&M=' . $returnMonth . '&Y=' . $returnYear, array('id' => 'next1', "class" => "btn", "style" => "text-align:center;display:inline; text-decoration:none; padding:2px 10px;"));
                    echo $this->Html->link('Save & Next', '#', array('id'=>'next1', 'class'=>'ml-1 mt-2 btn btn-primary btn-lg spinner_btn', 'escape'=>false));
                    
                }
    
            }

        } else {

            if ($is_rejected_section != 2) {
                
                if(in_array($curAction, array('instruction', 'generalParticular'))) {
                    
                    // $curController = $this->getRequest()->getParam('controller');
                    // $mineralParam = $this->getRequest()->getParam('pass');
                    // if(null==$mineralParam){
                    //     $mineralParam = "";
                    // } else {
                    //     $mineralPar = $mineralParam[0];
                    //     $mineralPar .= (isset($mineralParam[1])) ? "/".$mineralParam[1] : "";
                    //     $mineralParam = "/".$mineralPar;
                    // }
                    // $secLink = "/".$curController."/".$curAction.$mineralParam;
                    // $secLinkArr = $this->getRequest()->getSession()->read('sec_link');
                    // $secLinkArrLast = end($secLinkArr);
                    // $secLinkLast = end($secLinkArrLast);
                    // $secLinkLast = strtolower(str_replace(' ','',$secLinkLast));
                    // $secLinkLast = str_replace('_','',$secLinkLast);
                    // $secLink = strtolower(str_replace(' ','',$secLink));

                    // if($secLink != $secLinkLast){
                    //     echo $this->Html->link('Next <i class="fa fa-arrow-right"></i>', array('controller'=>$controller,'action'=>'nextSection',$action,$action_ctrl,$param_one,$param_two), array('id'=>'next1', 'class'=>'mt btn btn-info btn-lg ml-1 spinner_btn_nxt', 'escapeTitle'=>false));
                    // }
                
                } else if(in_array($curAction, array('tradingActivity', 'exportOfOre', 'mineralBaseActivity', 'storageActivity', 'sourceOfSupply'))) {

                    if (null !== $this->getRequest()->getSession()->read('activityType') && $this->getRequest()->getSession()->read('activityType') == 'C' && $returnType == 'ANNUAL' && $curAction != 'sourceOfSupply') {
                        $saveBtnLabel = 'Save & Next';
                    } else {
                        $saveBtnLabel = 'Save';
                    }
                    
                    // echo '<input type="submit" value="Save & Next" class="btn" style="padding-top: 1px;padding-bottom: 1px;height: 21px">';
                    echo $this->Form->button($saveBtnLabel, array('type'=>'submit','id'=>'submit','class'=>'mt-2 ml-1 btn btn-success btn-lg spinner_btn'));

                } else {

                    //if rejected and By-default allow the user to save
                    //echo tag('input', array('name' => 'submit', 'type' => 'submit', 'id' => 'submit', "value" => $btnLabel['savenext'], "class" => "btn", "style" => "width:auto; text-align:center"));
                    echo $this->Form->button('Save & Next', array('type'=>'submit','id'=>'submit','class'=>'mt-2 ml-1 btn btn-success btn-lg spinner_btn'));
                
                }
    
            } else {
                
                //echo link_to($btnLabel['next'], 'monthly/F1?partI=working_details&MC=' . $mineCode . '&M=' . $returnMonth . '&Y=' . $returnYear, array('id' => 'next1', "class" => "btn", "style" => "text-align:center;display:inline; text-decoration:none; padding:2px 10px;")); 
                // echo $this->Html->link('Next <i class="fa fa-arrow-right"></i>', '#', array('class'=>'mt-2 btn btn-primary btn-lg spinner_btn_nxt', 'id'=>'next1', 'escape'=>false));
                // echo $this->Html->link('Next 2<i class="fa fa-arrow-right"></i>', array('controller'=>$controller,'action'=>'nextSection',$action,$action_ctrl,$param_one,$param_two), array('id'=>'next1', 'class'=>'mt-2 btn btn-info btn-lg ml-1 spinner_btn_nxt', 'escapeTitle'=>false));
    
            }
            
        }
        
        
        if ($returnType == "ANNUAL") {
            
            //echo '<input type="button" value="'.$btnLabel['finalsubmit'].'" onclick="annualFinalValidation.annualFinalSubmit('.url_for("h1/annualFinalSubmit").', '.url_for("default/index").')">';
            if($final_submit_button == true){
                echo $this->Form->button('Final Submit', array('type'=>'button','class'=>'mt-2 ml-1 btn btn-success btn-lg btn_final_submit float-right', 'id'=>'btn_final_submit'));
            }
            
        } else {
            
            //echo '<input type="button" value="'.$btnLabel['finalsubmit'].'" onclick="custom_validations.finalSubmit('.url_for("monthly/finalSubmit").', '.url_for("default/index").', '.$minaral.', '.$('#F_MAGNETITE').is(':checked'), $('#F_HEMATITE').is(':checked')).'">';
            if($final_submit_button == true){
                echo $this->Form->button('Final Submit', array('type'=>'button','class'=>'mt-2 ml-1 btn btn-success btn-lg btn_final_submit float-right', 'id'=>'btn_final_submit'));
            }
            
        }

    
    } else {
        
        if (in_array($curAction, $view_only_section)) {
            
            //if all parts are approved, only next link should be visible. No Save Button
            //echo link_to($btnLabel['savenext'], 'monthly/F1?partI=name_address&MC=' . $mineCode . '&M=' . $returnMonth . '&Y=' . $returnYear, array('id' => 'next1', "class" => "btn", "style" => "text-align:center;display:inline; text-decoration:none; padding:2px 10px;"));
            echo $this->Html->link('Save & Next', '#', array('id'=>'next1', 'class'=>'mt-2 ml-1 btn btn-primary btn-lg spinner_btn', 'escape'=>false));

        } else {
            
            //echo link_to($btnLabel['next'], 'monthly/F1?partI=working_details&MC=' . $mineCode . '&M=' . $returnMonth . '&Y=' . $returnYear, array('id' => 'next1', "class" => "btn", "style" => "text-align:center;display:inline; text-decoration:none; padding:2px 10px;")); 
            // echo $this->Html->link('Next <i class="fa fa-arrow-right"></i>', '#', array('class'=>'mt-2 btn btn-primary btn-lg spinner_btn_nxt', 'id'=>'next1', 'escape'=>false));
            // echo $this->Html->link('Next <i class="fa fa-arrow-right"></i>', array('controller'=>$controller,'action'=>'nextSection',$action,$action_ctrl,$param_one,$param_two), array('id'=>'next1', 'class'=>'mt-2 btn btn-info btn-lg ml-1 spinner_btn_nxt', 'escapeTitle'=>false));
        
        }
        
    }
    
}

//echo link_to($btnLabel['home'], 'default/index', array('id' => 'next1', "class" => "btn", "style" => "width:50px; text-align:center; display:inline; text-decoration:none; padding:2px 10px;"));
echo $this->Html->link('Home', array('controller'=>'auth','action'=>'home'), array('id'=>'next1', 'class'=>'mt-2 ml-1 btn btn-primary btn-lg spinner_btn_nxt', 'escape'=>false));

// below comment button by ganesh satav as per the discuss with ibm person 
// added by ganesh satav dated 2 Sep 2014                                         
//<td align="center" valign="middle"><input type='button' onclick="printForm('details_maines', 1);" id='print_mine_details' value='Print' class='btn' style='float:right; margin:0px 5px;'/></td>
//echo button_to($btnLabel['printall'], 'monthly/printAll?mc=' . $mineCode . "&date=" . $returnDate . "&return_type=" . $returnType, array('class' => 'print-all btn', 'target' => '_blank', 'style' => 'float:right; margin:0px 5px;'));

// echo $this->Form->button('Print All', array('type'=>'button','class'=>'mt-2 btn btn-success btn-lg'));
// echo $this->Html->link('Print All', '/returnspdftest/miner_print_pdf', array('class'=>'mt-2 ml-1 btn btn-success btn-lg', 'id'=>'next1', 'target'=>'_blank', 'escape'=>false));
echo $this->Html->link('Print All', array('controller'=>'returnspdf', 'action'=>$print_pdf_action), array('id'=>'next1', 'class'=>'print-all mt-2 ml-1 btn btn-success btn-lg spinner_btn','target'=>'_blank'));




if(null !== $this->getRequest()->getSession()->read("form_status")){
    if($this->getRequest()->getSession()->read("form_status") == 'edit'){
        if($section_mode == 'edit'){

            $curAction = $this->getRequest()->getParam('action');
            $notCommentSection = array('oreType', 'instruction', 'generalParticular');
            if(!in_array($curAction, $notCommentSection)){
                echo $this->element('communication_applicant');
            }

        } else if($section_mode == 'read'){

            // $curAction = $this->getRequest()->getParam('action');
            // $firstSec = array('mine', 'instruction');
            // if(!in_array($curAction, $firstSec)){
            //     echo $this->Html->link('<i class="fa fa-arrow-left"></i> Previous', array('controller'=>$controller,'action'=>'prevSection',$action,$action_ctrl,$param_one,$param_two), array('class'=>'mt-2 btn btn-info btn-lg ml-1 spinner_btn_nxt', 'escape'=>false));
            // }

            // if all section commented then show final submit button
            //$replyStatus =0;
            if($commented_status == false && $replyStatus == 1){

                echo $this->Html->script('mc/communication_applicant.js?version='.$version);
                
                $viewUserType = $this->getRequest()->getSession()->read("view_user_type");
                $ref_cntrl = ($viewUserType == 'enduser') ? 'Enduser' : 'Monthly';

                echo $this->Form->button('Final Submit', array('name'=>'submit','type'=>'button','id'=>'final_submit_ref','class'=>'mt-2 btn btn-success btn-lg ml-1 d_in_block_i btn_final_submit float-right','value'=>'final_submit_ref'));
                echo $this->Form->control('final_submit_ref_url', array('type'=>'hidden', 'id'=>'final_submit_ref_url', 'value'=>$this->Url->build(['controller' => $ref_cntrl, 'action' => 'final_submit_ref'])));
                echo $this->Form->control('mms_user_id', array('type'=>'hidden', 'id'=>'mms_user_id', 'value'=>(isset($mmsUserId) ? $mmsUserId : '')));
                echo $this->Form->control('home_link', array('type'=>'hidden', 'id'=>'home_link', 'value'=>$this->Url->build(array('controller'=>'auth', 'action'=>$home_action))));
                echo $this->Form->control('view_user_type', array('type'=>'hidden', 'id'=>'view_user_type', 'value'=>$viewUserType));
                echo $this->Form->control('mine_code', array('type'=>'hidden', 'id'=>'mine_code', 'value'=>$mineCode));
                echo $this->Form->control('return_date', array('type'=>'hidden', 'id'=>'return_date', 'value'=>$returnDate));
                echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType));

            }
            
            echo $this->Html->link('Home', array('controller'=>'Auth','action'=>'home'), array('class'=>'print-all mt-2 ml-1 btn btn-primary btn-lg ml-1 spinner_btn_nxt'));

            echo $this->Html->link('Print All', array('controller'=>'returnspdf', 'action'=>$print_pdf_action), array('class'=>'print-all mt-2 ml-1 btn btn-success btn-lg','target'=>'_blank'));
            
            $curController = $this->getRequest()->getParam('controller');
            $mineralParam = $this->getRequest()->getParam('pass');
            if(null==$mineralParam){
                $mineralParam = "";
            } else {
                $mineralPar = $mineralParam[0];
                $mineralPar .= (isset($mineralParam[1])) ? "/".$mineralParam[1] : "";
                $mineralParam = "/".$mineralPar;
            }
            $secLink = "/".$curController."/".$curAction.$mineralParam;
            $secLinkArr = $this->getRequest()->getSession()->read('sec_link');
            $secLinkArrLast = end($secLinkArr);
            $secLinkLast = end($secLinkArrLast);
            $secLinkLast = strtolower(str_replace(' ','',$secLinkLast));
            $secLinkLast = str_replace('_','',$secLinkLast);
            $secLink = strtolower(str_replace(' ','',$secLink));

            if($secLink != $secLinkLast){
                // echo $this->Html->link('Next <i class="fa fa-arrow-right"></i>', array('controller'=>$controller,'action'=>'nextSection',$action,$action_ctrl,$param_one,$param_two), array('class'=>'mt-2 btn btn-info btn-lg ml-1 spinner_btn_nxt', 'escapeTitle'=>false));
            }

        }
        
    } else {
        
        $curAction = $this->getRequest()->getParam('action');
        $notCommentSection = array('oreType', 'instruction', 'generalParticular');
        if(!in_array($curAction, $notCommentSection)){
            echo $this->element('communication_applicant_history');
        }
        
        // $curAction = $this->getRequest()->getParam('action');
        // $firstSec = array('mine', 'instruction');
        // if(!in_array($curAction, $firstSec)){
        //     echo $this->Html->link('<i class="fa fa-arrow-left"></i> Previous', array('controller'=>$controller,'action'=>'prevSection',$action,$action_ctrl,$param_one,$param_two), array('class'=>'mt-2 btn btn-info btn-lg ml-1 spinner_btn_nxt', 'escape'=>false));
        // }
        
        echo $this->Html->link('Home', array('controller'=>'Auth','action'=>'home'), array('class'=>'print-all mt-2 ml-1 btn btn-primary btn-lg ml-1 spinner_btn_nxt'));

        echo $this->Html->link('Print All', array('controller'=>'returnspdf', 'action'=>$print_pdf_action), array('class'=>'print-all mt-2 ml-1 btn btn-success btn-lg','target'=>'_blank'));
        
        $curController = $this->getRequest()->getParam('controller');
        $mineralParam = $this->getRequest()->getParam('pass');
        if(null==$mineralParam){
            $mineralParam = "";
        } else {
            $mineralPar = $mineralParam[0];
            $mineralPar .= (isset($mineralParam[1])) ? "/".$mineralParam[1] : "";
            $mineralParam = "/".$mineralPar;
        }
        $secLink = "/".$curController."/".$curAction.$mineralParam;
        $secLinkArr = $this->getRequest()->getSession()->read('sec_link');
        $secLinkArrLast = end($secLinkArr);
        $secLinkLast = end($secLinkArrLast);
        $secLinkLast = strtolower(str_replace(' ','',$secLinkLast));
        $secLinkLast = str_replace('_','',$secLinkLast);
        $secLink = strtolower(str_replace(' ','',$secLink));

        if($secLink != $secLinkLast){
            // echo $this->Html->link('Next <i class="fa fa-arrow-right"></i>', array('controller'=>$controller,'action'=>'nextSection',$action,$action_ctrl,$param_one,$param_two), array('class'=>'mt-2 btn btn-info btn-lg ml-1 spinner_btn_nxt', 'escapeTitle'=>false));
        }
    }
}


$curAction = $this->getRequest()->getParam('action');
$firstSec = array('mine', 'instruction');
if(!in_array($curAction, $firstSec)){
    echo $this->Html->link('<i class="fa fa-arrow-left"></i> Previous', array('controller'=>$controller,'action'=>'prevSection',$action,$action_ctrl,$param_one,$param_two), array('class'=>'mt-2 btn btn-info btn-lg ml-1 spinner_btn_nxt float-left form_btn_prev', 'escape'=>false));
}


// "Next" button hide on last section
$curController = $this->getRequest()->getParam('controller');
$mineralParam = $this->getRequest()->getParam('pass');
if(null==$mineralParam){
    $mineralParam = "";
} else {
    $mineralPar = $mineralParam[0];
    $mineralPar .= (isset($mineralParam[1])) ? "/".$mineralParam[1] : "";
    $mineralParam = "/".$mineralPar;
}
$secLink = "/".$curController."/".$curAction.$mineralParam;
$secLinkArr = $this->getRequest()->getSession()->read('sec_link');
$secLinkArrLast = end($secLinkArr);
$secLinkLast = end($secLinkArrLast);
$secLinkLast = strtolower(str_replace(' ','',$secLinkLast));
$secLinkLast = str_replace('_','',$secLinkLast);
$secLink = strtolower(str_replace(' ','',$secLink));

if($secLink != $secLinkLast){
    echo $this->Html->link('Next <i class="fa fa-arrow-right"></i>', array('controller'=>$controller,'action'=>'nextSection',$action,$action_ctrl,$param_one,$param_two), array('class'=>'mt-2 btn btn-info btn-lg ml-1 spinner_btn_nxt form_btn_next', 'escape'=>false));
}

?>