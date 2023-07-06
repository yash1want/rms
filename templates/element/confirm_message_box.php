
<button type="button" class="btn mr-2 mb-2 btn-primary" data-toggle="modal" data-target="#confirmModal" id="confirm-modal-btn" hidden>modal</button>

<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content p-0 login-modal-content login-modal-info" id="confirm_modal_box">
            <div class="modal-header m-0 d-inline-block text-center login-modal-header">
                <i class="fa fa-info-circle login-info-icon"></i>
            </div>
            <div class="modal-body login-modal-body text-center font-weight-bold">
                <p class="mb-0 modal-body-text" id="modal-confirm-txt"></p>
                <input type="hidden" name="btn_type" id="btn_type" value="">
            </div>
            <div class="modal-footer m-0 login-modal-footer">
                <button type="button" class="btn btn-primary confirm-modal-btn" id="modal_ok">Ok</button>
                <button type="button" class="btn btn-default" id="modal_cancel">Cancel</button>
            </div>
        </div>
    </div>
</div>
