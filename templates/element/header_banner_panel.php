
<div class="app-page-title u_bnr_new col-12 row m-0 p-0">
    <div class="col-2" id="u_header_left_img">
    </div>
    <div class="col-9" id="u_header_middle_img">
        <div id="u_header_text_next">Returns Management System

            <?php if(isset($_SESSION['color_code']) && $_SESSION['color_code'] == 'show') { ?>

            <!-- <div class="banner-main-div">
                <span class="bg-success banner-color-code"></span>
                <span class="banner-color-code-text">Filled</span>
                <span class="bg-warning banner-color-code"></span>
                <span class="banner-color-code-text">Referred</span>
                <span class="bg-danger banner-color-code"></span>
                <span class="banner-color-code-text">Yet to be filled</span>
                <span class="bg-dark banner-color-code"></span>
                <span class="banner-color-code-text">Deleted</span>
                <span class="bg_modified banner-color-code"></span>
                <span class="banner-color-code-text">Modified</span>
                <span class="bg_new banner-color-code"></span>
                <span class="banner-color-code-text">New Records</span>
            </div> -->

            <table class="banner-main-div">
                <?php if(isset($_SESSION['loginusertype']) && $_SESSION['loginusertype'] == 'mmsuser') { ?>
                    <tr>
                        <td><span class="banner-color-code bg-success d-block"></span></td>
                        <td class="float-left">Approved</td>
                        <td><span class="banner-color-code bg-warning d-block"></span></td>
                        <td class="float-left">Referred</td>
                        <td><span class="banner-color-code bg-danger d-block"></span></td>
                        <td class="float-left">Yet to be review</td>
                    </tr>
                    <?php if(isset($diff_color_code)) { ?>
                        <tr>
                            <td><span class="banner-color-code bg_deleted d-block"></span></td>
                            <td class="float-left">Deleted</td>
                            <td><span class="banner-color-code bg_modified d-block"></span></td>
                            <td class="float-left">Modified</td>
                            <td><span class="banner-color-code bg_new d-block"></span></td>
                            <td class="float-left">New Records</td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td><span class="banner-color-code bg-success d-block"></span></td>
                        <td class="float-left">Filled</td>
                        <td><span class="banner-color-code bg-warning d-block"></span></td>
                        <td class="float-left">Referred</td>
                        <td><span class="banner-color-code bg-danger d-block"></span></td>
                        <td class="float-left">Yet to be filled</td>
                    </tr>
                <?php } ?>
            </table>

             <?php } ?>

        </div>
    </div>
    <div class="col-1" id="u_header_right_img">
    </div>
</div>
<?php if($_SESSION['mining_close_status'] =='C'){ ?>
    <div><h5 class="text-danger text-right font-weight-bold pr-2">Mine has been closed</h5></div>
<?php } ?>