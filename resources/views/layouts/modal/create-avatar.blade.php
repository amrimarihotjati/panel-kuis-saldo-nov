<div class="modal" id="createAvatar" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded rounded-4">
            <form autocomplete="off" id="createAvatarForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Avatar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-0" style="max-height: calc(100vh - 210px); overflow-y: auto;">
                    <div class="mb-3">
                         <label for="avatar_icon" class="form-label">
                            <span class="text-primary fw-semibold">Icon Avatar</span>
                        </label>
                        <div class="input-group mb-3">
                          <label class="input-group-text border-0 ps-0" for="inputGroupFile01"><img alt="" src="" class="img-fluid img-thumbnail" style="width:45px;min-height:45px;max-height:45px;background-color:#f4f4f4;" id="method_image_preview"></label>
                          <input type="file" name="avatar_icon" class="form-control" id="inputGroupFile01" onchange="previewImage()" required>
                      </div>
                    </div>
                    <div class="mb-3">
                        <label for="avatar_name" class="form-label">
                            <span class="text-primary fw-semibold">Nama Avatar</span>
                        </label>
                        <input name="avatar_name" type="text" class="form-control input-lg fw-bold" id="avatar_name" required>
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
    $('#createAvatarForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ route('createAvatar') }}",
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
                $('#createAvatar').modal('hide');
                var dataTable = $('#dtAvatar').DataTable();
                dataTable.ajax.reload();
            },
            error: function(xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: xhr.responseText
                });
                $('#createAvatar').modal('hide');
            }
        });
    });
</script>
<script type="text/javascript">
    function previewImage() {
        method_image_preview.src = URL.createObjectURL(event.target.files[0]);
    }
</script>