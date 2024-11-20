<div class="modal" id="createBanner" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded rounded-4">
            <form autocomplete="off" id="createBannerForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-0" style="max-height: calc(100vh - 210px); overflow-y: auto;">
                    <div class="mb-3">
                        <label for="banner_title" class="form-label">
                            <span class="text-primary fw-semibold">Judul Banner</span>
                        </label>
                        <input name="banner_title" type="text" class="form-control input-lg fw-bold" id="banner_title" required>
                    </div>
                    <div class="mb-3">
                        <label for="banner_url" class="form-label">
                            <span class="text-primary fw-semibold">URL Banner</span>
                        </label>
                        <input name="banner_url" type="text" class="form-control input-lg fw-semibold" id="banner_url" required>
                    </div>
                    <div class="mb-3">
                        <label for="banner_description" class="form-label">
                            <span class="text-primary fw-semibold">Deskripsi</span>
                        </label>
                        <input name="banner_description" type="text" class="form-control input-lg" id="banner_description" required>
                    </div>
                    <div class="mb-3">
                        <label for="banner_image" class="form-label">
                            <span class="text-primary fw-semibold">Gambar Banner</span>
                        </label>
                        <br>
                        <img alt="" src="/img/image_holder.png" class="img-fluid img-thumbnail" style="width:100%;min-height:400px;max-height:400px;background-color:#f4f4f4;" id="method_image_preview">
                        <br>
                        <input name="banner_image" type="file" class="form-control input-lg fw-bold mt-2" id="banner_image" onchange="previewImage()" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="submit" id="create" class="btn btn-primary fw-bold">TAMBAHKAN</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="module">
    $('#createBannerForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ route('createBanner') }}",
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                Swal.fire({
                    icon: "success",
                    title: "BERHASIL!",
                    text: response.message
                });
                $('#createBanner').modal('hide');
                var dataTable = $('#dtBanner').DataTable();
                dataTable.ajax.reload();
            },
            error: function(xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: xhr.responseText
                });
                $('#createBanner').modal('hide');
            }
        });
    });
</script>
<script type="text/javascript">
    function previewImage() {
        method_image_preview.src = URL.createObjectURL(event.target.files[0]);
    }
</script>