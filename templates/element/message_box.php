
<button type="button" class="btn mr-2 mb-2 btn-primary" data-toggle="modal" data-target="#loginModal" id="login-modal-btn" hidden>modal</button>

<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content p-0 login-modal-content login-modal-danger">
            <div class="modal-header m-0 d-inline-block text-center login-modal-header">
                <i class="fa fa-info-circle login-info-icon"></i>
            </div>
            <div class="modal-body login-modal-body">
                <p class="mb-0 modal-body-text"><?php echo $message; ?></p>
            </div>
            <div class="modal-footer m-0 login-modal-footer">
                <button type="button" class="btn btn-primary login-modal-btn" onclick="location.href='<?php echo $redirect_to; ?>'">Continue</button>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){
        $('#login-modal-btn').click();
        $('#loginModal').on('click',function(){
            location.href='<?php echo $redirect_to; ?>';
        });
    });

</script>