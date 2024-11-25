<div class="modal" id="withdrawalDetailModalDashboard" tabindex="-1" role="dialog"
    aria-labelledby="withdrawalDetailModalDashboardLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="withdrawalDetailModalDashboardLabel">PROGRESS WITHDRAW</h5>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 bg-light">
                <div class="row me-1 mt-2">
                    <div class="col-md-8">
                        <div class="row me-1">
                            <div class="col-md-4">
                                <div class="card shadow-none border rounded-2">
                                    <div class="card-body">
                                        <small class="card-title text-primary mb-0 fw-bold">Big Point Quiz</small>
                                        <p class="h5 card-text fw-bold mt-0" id="valueBigPointQuiz">Memuat...</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card shadow-none border rounded-2">
                                    <div class="card-body">
                                        <small class="card-title text-primary mb-0 fw-bold">Quiz Valid</small>
                                        <p class="h5 card-text fw-bold mt-0" id="valueQuizValid">
                                            Memuat...</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card shadow-none border rounded-2">
                                    <div class="card-body">
                                        <small class="card-title text-primary mb-0 fw-bold">Quiz Invalid</small>
                                        <p class="h5 card-text fw-bold mt-0" id="valueQuizInValid">Memuat...</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card shadow-none border rounded-2">
                                    <div class="card-body">
                                        <small class="card-title text-primary mb-0 fw-bold">Last Ad Inters</small>
                                        <p class="h5 card-text fw-bold mt-0" id="valueLastAdInters">Memuat...</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card shadow-none border rounded-2">
                                    <div class="card-body">
                                        <small class="card-title text-primary mb-0 fw-bold">Last Ad Rewards</small>
                                        <p class="h5 card-text fw-bold mt-0" id="valueLastAdRewards">Memuat...</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card shadow-none border rounded-2">
                                    <div class="card-body">
                                        <small class="card-title text-primary mb-0 fw-bold">WD By Account</small>
                                        <p class="h5 card-text fw-bold mt-0" id="valueWithdrawByAccount">Memuat...</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card shadow-none border rounded-2">
                                    <div class="card-body">
                                        <small class="card-title text-primary mb-0 fw-bold">WD By Number</small>
                                        <p class="h5 card-text fw-bold mt-0" id="valueWithdrawByNumber">Memuat...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ps-3 pe-3 pb-3 pt-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="modal-nama-player" class="text-xs text-primary fw-bold">Nama
                                            Player</label>
                                        <input type="text" class="form-control form-control-sm"
                                            id="modal-nama-player" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="modal-email-player" class="text-xs text-primary fw-bold">Email
                                            Player</label>
                                        <input type="text" class="form-control form-control-sm"
                                            id="modal-email-player" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="modal-points" class="text-xs text-primary fw-bold">Points</label>
                                        <input type="text" class="form-control form-control-sm" id="modal-points"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="modal-amount" class="text-xs text-primary fw-bold">Diterima</label>
                                        <input type="text" class="form-control form-control-sm" id="modal-amount"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="modal-status" class="text-xs text-primary fw-bold">Status</label>
                                        <input type="text" class="form-control form-control-sm" id="modal-status"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="modal-payment-method"
                                            class="text-xs text-primary fw-bold">Wallet</label>
                                        <input type="text" class="form-control form-control-sm"
                                            id="modal-payment-method" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="modal-created-at"
                                            class="text-xs text-primary fw-bold">Permintaan</label>
                                        <input type="text" class="form-control form-control-sm"
                                            id="modal-created-at" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="modal-updated-at"
                                            class="text-xs text-primary fw-bold">Diprogress</label>
                                        <input type="text" class="form-control form-control-sm"
                                            id="modal-updated-at" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 bg-white p-4 rounded rounded-2 border">
                        <form id="updateDashboardWithdrawalForm" autocomplete="off" class="w-100 pt-0">
                            @csrf
                            <input type="hidden" name="withdrawal_id" id="modal-withdrawal-id">
                            <input type="hidden" name="withdrawal_amount" id="modal-withdrawal-amount">
                            <input type="hidden" name="withdrawal_points" id="modal-withdrawal-points">
                            <input type="hidden" name="player_id" id="modal-withdrawal-player-id">
                            <input type="hidden" name="app_id" id="modal-withdrawal-app-id">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <label for="status" class="form-label text-primary fw-bold">Respon
                                        Penarikan</label>
                                    <select class="form-select form-select-sm fw-bold" name="status"
                                        id="modal-input-response-status" required>
                                        <option value="0">PENDING</option>
                                        <option value="1" selected>SETUJUI</option>
                                        <option value="2">TOLAK</option>
                                    </select>
                                </div>
                                <div class="col-4 mb-2">
                                    <label for="with_reset_ads" class="form-label text-primary fw-bold small">Reset
                                        Ads</label>
                                    <select class="form-select form-select-sm fw-bold" name="with_reset_ads"
                                        id="modal-input-response-with_reset_ads" required>
                                        <option value="0">TIDAK</option>
                                        <option value="1">YA</option>
                                    </select>
                                </div>
                                <div class="col-4 mb-2">
                                    <label for="with_reset_completed_article"
                                        class="form-label text-primary fw-bold small">Reset Article</label>
                                    <select class="form-select form-select-sm fw-bold"
                                        name="with_reset_completed_article" id="modal-input-response-with_reset_ads"
                                        required>
                                        <option value="0">TIDAK</option>
                                        <option value="1">YA</option>
                                    </select>
                                </div>
                                <div class="col-4 mb-2">
                                    <label for="with_reset_completed_quiz"
                                        class="form-label text-primary fw-bold small">Reset Quiz</label>
                                    <select class="form-select form-select-sm fw-bold"
                                        name="with_reset_completed_quiz" id="modal-input-response-with_reset_ads"
                                        required>
                                        <option value="0">TIDAK</option>
                                        <option value="1">YA</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="payment_message" class="form-label text-primary fw-bold">Pesan
                                        Penarikan</label>
                                    <textarea name="payment_message" id="modal-input-response-message"
                                        class="form-control form-control-sm input-lg fw-semibold"></textarea>
                                </div>
                                <div class="col-12 mb-2 mt-2">
                                    <button type="submit"
                                        class="btn btn-success fw-bold w-100 shadow-none">SIMPAN</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
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

    $('#updateDashboardWithdrawalForm').on('submit', function(event) {
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
                $('#withdrawalDetailModalDashboard').modal('hide');
                var mDatatableWithdrawAllMethodPending = $('#DatatableWithdrawAllMethodPending').DataTable();
                var mDatatableWithdrawDanaMethodPending = $('#DatatableWithdrawDanaPending').DataTable();
                var mDatatableWithdrawOvoMethodPending = $('#DatatableWithdrawAllMethodPending').DataTable();
                var mDatatableWithdrawLinkAjaMethodPending = $('#DatatableWithdrawLinkAjaMethodPending').DataTable();
                var mDatatableWithdrawShoopepayMethodPending = $('#DatatableWithdrawShoopepayMethodPending').DataTable();
                var mDatatableWithdrawGopayMethodPending = $('#DatatableWithdrawGopayMethodPending').DataTable();

                mDatatableWithdrawAllMethodPending.ajax.reload();
                mDatatableWithdrawDanaMethodPending.ajax.reload();
                mDatatableWithdrawOvoMethodPending.ajax.reload();
                mDatatableWithdrawLinkAjaMethodPending.ajax.reload();
                mDatatableWithdrawShoopepayMethodPending.ajax.reload();
                mDatatableWithdrawGopayMethodPending.ajax.reload();

            },
            error: function(xhr) {
                hideSwalLoading();
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: xhr.responseText
                });
                $('#withdrawalDetailModalDashboard').modal('hide');
            }
        });
    });
</script>
