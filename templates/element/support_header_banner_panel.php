
<div class="app-page-title u_bnr_new col-12 row m-0 p-0">
    <div class="col-2" id="u_header_left_img">
    </div>
    <div class="col-9" id="u_header_middle_img">
        <div id="u_header_text_next">Support Management System

            <?php if(isset($_SESSION['color_code']) && $_SESSION['color_code'] == 'show') { ?>

            
            <table class="banner-main-div">
                <?php if(isset($_SESSION['loginusertype']) && $_SESSION['loginusertype'] == 'supportuser') { ?>
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
