<div class="modal fade" id="pdf_version_modal" tabindex="-1" role="dialog" aria-labelledby="pdf_version_modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pdf_version_modalLabel">Returns PDF version list</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div class="alert alert-info pb-4">
			<span class="float-left" id="pdf_version_appid"></span>
			<span class="float-right" id="pdf_version_rdate"></span></div>
		</div>
		<div class="mx-3">
			<div class="text-center" id="pdf_version_spinner"><i class="fa fa-circle-notch fa-spin h5"></i></div>
            <div class="card border shadow">
                <div class="p-2 pl-3 bg-secondary text-white text-center rounded-top font-weight-bold">Application Versions</div>
                <div class="card-body">
                    <table class="table table-bordered text-center" id="pdf_version_tbl">
                        <thead>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <br>
            <div class="card border shadow">
                <div class="p-2 pl-3 bg-secondary text-white text-center rounded-top font-weight-bold" id="pdf_mms_version_title">Approved Version</div>
                <div class="card-body">
                    <div id="pdf_approved_version_msg"></div>
                    <table class="table table-bordered text-center" id="pdf_version_tbl_two">
                        <thead>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
		</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>