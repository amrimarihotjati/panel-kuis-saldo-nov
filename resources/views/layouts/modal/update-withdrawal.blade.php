<div class="modal" id="withdrawalDetailModal" tabindex="-1" role="dialog" aria-labelledby="withdrawalDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="withdrawalDetailModalLabel">Withdrawal Details</h5>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="modal-nama-player" class="text-xs text-primary fw-bold">Nama Player</label>
                            <input type="text" class="form-control form-control-sm" id="modal-nama-player" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="modal-email-player" class="text-xs text-primary fw-bold">Email Player</label>
                            <input type="text" class="form-control form-control-sm" id="modal-email-player" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="modal-points" class="text-xs text-primary fw-bold">Points</label>
                            <input type="text" class="form-control form-control-sm" id="modal-points" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="modal-amount" class="text-xs text-primary fw-bold">Diterima</label>
                            <input type="text" class="form-control form-control-sm" id="modal-amount" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="modal-status" class="text-xs text-primary fw-bold">Status</label>
                            <input type="text" class="form-control form-control-sm" id="modal-status" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="modal-payment-method" class="text-xs text-primary fw-bold">Wallet</label>
                            <input type="text" class="form-control form-control-sm" id="modal-payment-method" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="modal-created-at" class="text-xs text-primary fw-bold">Permintaan</label>
                            <input type="text" class="form-control form-control-sm" id="modal-created-at" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="modal-updated-at" class="text-xs text-primary fw-bold">Diprogress</label>
                            <input type="text" class="form-control form-control-sm" id="modal-updated-at" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form id="updateWithdrawalForm" autocomplete="off" class="w-100 pt-0">
                    @csrf
                    <input type="hidden" name="withdrawal_id" id="modal-withdrawal-id">
                    <input type="hidden" name="withdrawal_amount" id="modal-withdrawal-amount">
                    <input type="hidden" name="withdrawal_points" id="modal-withdrawal-points">
                    <input type="hidden" name="player_id" id="modal-withdrawal-player-id">
                    <input type="hidden" name="app_id" id="modal-withdrawal-app-id">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="status" class="form-label text-muted fw-bold">Respon Penarikan</label>
                            <select class="form-select form-select-sm fw-bold" name="status" id="modal-input-response-status" required>
                                <option value="0">PENDING</option>
                                <option value="1" selected>SETUJUI</option>
                                <option value="2">TOLAK</option>
                            </select>
                        </div>
                        <div class="col-4 mb-3">
                            <label for="with_reset_ads" class="form-label text-muted fw-bold">Reset Temporary Ads</label>
                            <select class="form-select form-select-sm fw-bold" name="with_reset_ads" id="modal-input-response-with_reset_ads" required>
                                <option value="0">TIDAK</option>
                                <option value="1">YA</option>
                            </select>
                        </div>
                        <div class="col-4 mb-3">
                            <label for="with_reset_completed_article" class="form-label text-muted fw-bold">Reset Completed Article</label>
                            <select class="form-select form-select-sm fw-bold" name="with_reset_completed_article" id="modal-input-response-with_reset_ads" required>
                                <option value="0">TIDAK</option>
                                <option value="1">YA</option>
                            </select>
                        </div>
                        <div class="col-4 mb-3">
                            <label for="with_reset_completed_quiz" class="form-label text-muted fw-bold">Reset Completed Quiz</label>
                            <select class="form-select form-select-sm fw-bold" name="with_reset_completed_quiz" id="modal-input-response-with_reset_ads" required>
                                <option value="0">TIDAK</option>
                                <option value="1">YA</option>
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="payment_message" class="form-label text-muted fw-bold">Pesan Penarikan</label>
                            <input name="payment_message" type="text" id="modal-input-response-message" class="form-control form-control-sm input-lg fw-semibold" />
                        </div>
                        <div class="col-12 mb-2">
                            <button type="submit" class="btn btn-sm btn-success fw-bold w-100">SIMPAN</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="module">
    function showSwalLoading() {
        Swal.fire({
            title: 'Mohon Tunggu...',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }

    function hideSwalLoading() {
        Swal.close();
    }

    $('#updateWithdrawalForm').on('submit', function(event) {
        event.preventDefault();
        var formData = $(this).serialize();

        showSwalLoading();

        $.ajax({
            url: "{{ route('updateStatusWithdrawalRequest') }}",
            type: "POST",
            data: formData,
            success: function(response) {
                hideSwalLoading();
                Swal.fire({
                    icon: "success",
                    title: "BERHASIL!",
                    text: response.message
                });
                $('#withdrawalDetailModal').modal('hide');
                var dataTable = $('#dtWithdrawalPlayer').DataTable();
                dataTable.ajax.reload();
            },
            error: function(xhr) {
                hideSwalLoading();
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: xhr.responseText
                });
                $('#withdrawalDetailModal').modal('hide');
            }
        });
    });
</script>
