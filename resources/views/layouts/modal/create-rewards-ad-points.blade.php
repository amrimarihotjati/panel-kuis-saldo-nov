<div class="modal" id="createRewardsAdPoints" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content rounded rounded-4">
        <form autocomplete="off" id="createRewardsAdPointsForm">
            @csrf
            <div class="modal-header border shadow-none pb-4">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Rewards Ad Points</h5>
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fas fa-times-circle"></i></button>
                </div>
                <div class="modal-body pl-4 pr-4 pb-0">
                    <div class="mb-3">
                        <label for="title" class="form-label">
                            <span class="text-primary fw-semibold">Nama RewardsAdPoints</span>
                        </label>
                        <input name="title" type="text" class="form-control input-lg fw-bold" id="title"
                        required>
                    </div>
                    <div class="mb-3">
                        <label for="point_value" class="form-label">
                            <span class="text-primary fw-semibold">Jumlah Point Didapat</span>
                        </label>
                        <input name="point_value" type="number" step="1" min="1" class="form-control input-lg fw-bold" id="point_value"
                        required>
                    </div>
                    <div class="mb-3">
                        <label for="time_claimed" class="form-label">
                            <span class="text-primary fw-semibold">Jarak waktu detik klaim</span>
                        </label>
                        <input name="time_claimed" type="number" step="1" min="1" class="form-control input-lg fw-bold" id="time_claimed"
                        required>
                    </div>
                    <div class="mb-3">
                        <label for="watch_ads_value" class="form-label">
                            <span class="text-primary fw-semibold">Jumlah Nonton Iklan</span>
                        </label>
                        <input name="watch_ads_value" type="number" step="1" min="1" class="form-control input-lg fw-bold" id="watch_ads_value"
                        required>
                    </div>
                </div>
                <div class="modal-footer border-0 shadow-none">
                    <button type="submit" id="create"
                    class="btn btn-primary fw-bold ps-4 pe-4 mr-3 mb-3">TAMBAHKAN</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="module">
    $('#createRewardsAdPointsForm').on('submit', function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "{{ route('createRewardsAdPoints') }}",
            type: "POST",
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: "success",
                    title: "BERHASIL!",
                    text: response.message
                });
                $('#createRewardsAdPoints').modal('hide');
                var dataTable = $('#dtRewardsAdPoints').DataTable();
                dataTable.ajax.reload();
            },
            error: function(xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: xhr.responseText
                });
                $('#createRewardsAdPoints').modal('hide');
            }
        });
    });
</script>