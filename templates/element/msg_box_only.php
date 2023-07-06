
        </div>
    </div>
</div>

<button type="button" class="btn mr-2 mb-2 btn-primary" data-toggle="modal" data-target="#msg_box_only" data-backdrop="static" data-keyboard="false" id="msg_box_only_btn" hidden>modal</button>

<div class="modal fade d_none msg_box_modal" id="msg_box_only" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content p-0 login-modal-danger>">
            <div class="modal-header m-0 d-inline-block text-center login-modal-header bg-success">
                <i class="fa fa-check-circle login-info-icon text-white"></i>
            </div>
            <div class="modal-body login-modal-body">
                <p class="mb-0 modal-body-text text-center font-weight-bold font_16"><?php echo $this->getRequest()->getSession()->read("process_msg"); $this->getRequest()->getSession()->delete("process_msg"); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="app-main">
    <div class="app-main__outer">
        <div class="app-main__inner">