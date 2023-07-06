<?php 
    $aadhar_auth_msg = 'I hereby state that I have no objection in authenticating myself with Aadhaar based authentication system and consent to providing my Aadhaar number, Biometric and/or One Time Pin (OTP) data for Aadhaar based authentication for the purposes of availing of eSign service/ e-KYC services / both in PAN application from IBM.';
    $esign_msg = "Please preview your application pdf, if all fine click 'Ok' to E-Sign the document, if you don't want to E-Sign now please click 'Cancel', Your Application will final submitted only after E-Signing.";
    
    $message = $aadhar_auth_msg.'<br><br>'.$esign_msg;
?>

<div id="declarationModal" class="modal" data-backdrop="static">
    <!-- Modal content -->
    <div class="modal-content esign_modal_content">
        <span class="close"><b class="float-right d-block">&times;</b></span>
        <!--added this pdf preview link on 27-10-2017 by Amol -->
        <div class="col-md-12">
            <div class="col-md-3 d-inline">Application PDF: </div>
            
            <?php 
                $login_user_type = $_SESSION['loginusertype'];
                $applicant_type = null;
                if (in_array($login_user_type, array('mmsuser', 'primaryuser'))) {
                    $applicant_type = $_SESSION['view_user_type'];
                } else {
                    $applicant_type = $login_user_type;
                }

                if ($applicant_type == 'authuser') {
                    $pdf_action = 'minerPrintPdf';
                } else {
                    $pdf_action = 'enduserPrintPdf';
                }
            ?>

            <?php if (!empty($applicant_type)) { ?>
                <input type="hidden" id = "controller_name" value='returnspdf'/>
                <input type="hidden" id = "forms_pdf" value='<?php echo $pdf_action; ?>'/>
                <div class="col-md-4 d-inline">
                    <?php echo $this->Html->link('Preview', ['controller'=>'returnspdf', 'action'=>$pdf_action], ['target'=>'_blank']); ?>
                </div><br>
            <?php } ?>
            

        </div>

        <div class="clearfix"></div>

        <div class="form-check mt-4">
            <input class="form-check-input modal-checkbox" type="checkbox" name="declaration_check_box" id="declaration_check_box">
            <label class="form-check-label" for="declaration_check_box"><?php echo $message; ?></label>
        </div>
        
       <!--  <form action="https://es-staging.cdac.in/esignlevel2/2.1/form/signdoc" method="POST"> -->
        <form action="https://esignservice.cdac.in/esign2.1/2.1/form/signdoc" method="POST">
            <input type="hidden" id = "eSignRequest" name="eSignRequest" value=''/>
            <input type="hidden" id = "aspTxnID" name="aspTxnID" value=""/>
            <input type="hidden" id = "Content-Type" name="Content-Type" value="application/xml"/>
            <input type="submit" value="Esign" class="btn btn-success mt-5 float-right mr-2" id="esign_submit_btn">
        </form>

        <p id="plz_wait" class="pleaseWait">Please Wait <i class="fa fa-circle-notch fa-spin"></i></p>
        
    </div>
</div>
<?php echo $this->Html->script('element/esign_declaration_msg'); ?>