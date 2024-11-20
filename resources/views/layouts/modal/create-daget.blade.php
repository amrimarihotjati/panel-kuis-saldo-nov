<div class="modal" id="createDaget" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content rounded rounded-4">
        <form autocomplete="off" id="createDagetForm">
            @csrf
            <div class="modal-header border shadow-none pb-4">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Daget</h5>
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fas fa-times-circle"></i></button>
                </div>
                <div class="modal-body pl-4 pr-4 pb-0">
                    <div class="mb-3">
                        <label for="title" class="form-label">
                            <span class="text-primary fw-semibold">Nama Daget</span>
                        </label>
                        <input name="title" type="text" class="form-control input-lg fw-bold" id="title"
                        required>
                    </div>
                    <div class="mb-3">
                        <label for="url" class="form-label">
                            <span class="text-primary fw-semibold">URL Daget</span>
                        </label>
                        <input name="url" type="url" class="form-control input-lg fw-bold" id="url"
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
                    <div class="mb-3">
                        <label for="info_rupiah" class="form-label">
                            <span class="text-primary fw-semibold">Info Rupiah</span>
                        </label>
                        <input name="info_rupiah" type="number" step="1" min="1" class="form-control input-lg fw-bold" id="info_rupiah"
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
    $('#createDagetForm').on('submit', function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "{{ route('createDaget') }}",
            type: "POST",
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: "success",
                    title: "BERHASIL!",
                    text: response.message
                });
                $('#createDaget').modal('hide');
                var dataTable = $('#dtDaget').DataTable();
                dataTable.ajax.reload();
            },
            error: function(xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: xhr.responseText
                });
                $('#createDaget').modal('hide');
            }
        });
    });
</script>