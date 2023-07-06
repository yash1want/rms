
        </div>
    </div>
</div>

<button type="button" class="btn mr-2 mb-2 btn-primary" data-toggle="modal" data-target="#loginModal" data-backdrop="static" data-keyboard="false" id="login-modal-btn-msg-box" hidden>modal</button>
<?php $alrt_status = $alert_theme=='success'?'success':'danger'; ?>
<?php $alrt_bg = $alert_theme=='success'?'bg-success':'bg-danger'; ?>
<?php $alrt_icon = $alert_theme=='success'?'fa-check-circle text-light':'fa-info-circle'; ?>
<div class="modal fade d_none msg_box_modal" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content p-0 login-modal-content login-modal-<?= $alrt_status; ?>">
            <div class="modal-header m-0 d-inline-block text-center login-modal-header <?= $alrt_bg; ?>">
                <i class="fa <?= $alrt_icon; ?> login-info-icon"></i>
            </div>
            <div class="modal-body login-modal-body">
                <p class="mb-0 modal-body-text"><?php echo $alert_message; ?></p>
            </div>
            <div class="modal-footer m-0 login-modal-footer">
                <button type="button" class="btn btn-primary login-modal-btn">Continue</button>
            </div>
        </div>
    </div>

    <?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'alrt_redirect_url', 'value'=>$alert_redirect_url]); ?>

</div>

<div class="app-main">
    <div class="app-main__outer">
        <div class="app-main__inner">