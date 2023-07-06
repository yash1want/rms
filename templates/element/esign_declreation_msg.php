

<div id="declarationModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close"><b>&times;</b></span>
    <!--added this pdf preview link on 27-10-2017 by Amol -->
    <div class="col-md-3 d-inline">Application PDF: </div>
    <?php if($_SESSION['loginusertype'] == 'authuser'){ ?>
        <div class="col-md-4 d-inline"><a target="blank" href="../returnspdf/miner-print-pdf">Preview</a></div><br>
    <?php } ?>
    <?php if($_SESSION['loginusertype'] == 'enduser'){ ?>
        <div class="col-md-4 d-inline"><a target="blank" href="../returnspdf/enduser-print-pdf">Preview</a></div><br>
    <?php } ?>
    <div class="clearfix"></div>

    <form action="https://esignservice.cdac.in/esign2.1/2.1/form/signdoc" method="POST">

        <input type="hidden" id = "eSignRequest" name="eSignRequest" value=''/>
        <input type="hidden" id = "aspTxnID" name="aspTxnID" value=""/>
        <input type="hidden" id = "Content-Type" name="Content-Type" value="application/xml"/>
        <input type="submit" name="submit" value="Esign" class="btn btn-success mt-2 float-right mr-2" id="esign_submit_btn">
    </form>

    <input type="checkbox" name="declaration_check_box" id="declaration_check_box" class="modal-checkbox" >
    <label for="declaration_check_box"><?php echo $message; ?></label><br>

    <p id="plz_wait" class="pleaseWait">Please Wait...</p>


    </div>
</div>