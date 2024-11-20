<div class="modal" id="createApplication" tabindex="-1">
<div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content rounded rounded-4">
        <form autocomplete="off" id="createBaseApplicationForm">
            @csrf
            <div class="modal-header border shadow-none pb-4">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Aplikasi</h5>
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fas fa-times-circle"></i></button>
                </div>
                <div class="modal-body pl-4 pr-4 pb-0">
                    <div class="mb-3">
                        <label for="app_pkg" class="form-label">
                            <span class="text-primary fw-semibold">Nama Package</span>
                        </label>
                        <input name="app_pkg" type="text" class="form-control input-lg fw-bold" id="app_pkg"
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
    $('#createBaseApplicationForm').on('submit', function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "{{ route('createBaseApplication') }}",
            type: "POST",
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: "success",
                    title: "BERHASIL!",
                    text: response.message
                });
                $('#createApplication').modal('hide');
                var dataTable = $('#dtBaseApplication').DataTable();
                dataTable.ajax.reload();
            },
            error: function(xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: xhr.responseText
                });
                $('#createApplication').modal('hide');
            }
        });
    });
</script>