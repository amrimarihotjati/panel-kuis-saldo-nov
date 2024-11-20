@extends('layouts.app')

@section('title', 'Edit Badge')

@push('style')
@endpush

@section('content')
<div class="main-content">
	<form autocomplete="off" id="editBadgeForm" enctype="multipart/form-data">
		@csrf
		<div class="card rounded rounded-4 shadow">
			<div class="card-header text-dark fw-bold d-flex justify-content-between align-items-center mt-2">
				<div class="h5 fw-bold">Edit Badge</div>
				<a href="{{ route('deleteBadge', $mBadge->id) }}" class="btn btn-danger btn-sm fw-bold shadow-none rounded rounded-1" ><i class="fas fa-trash"></i></a>
			</div>
			<div class="card-body">
				<input name="badge_id" type="hidden" value="{{ $mBadge->id }}" required>
				<div class="mb-3">
                         <label for="badge_icon" class="form-label">
                            <span class="text-primary fw-semibold">Icon Badge</span>
                        </label>
                        <div class="input-group mb-3">
                          <label class="input-group-text border-0 ps-0" for="inputGroupFile01"><img alt="" src="{{ $mBadge->badge_icon }}" class="img-fluid img-thumbnail" style="width:45px;min-height:45px;max-height:45px;background-color:#f4f4f4;" id="method_image_preview"></label>
                          <input type="file" name="badge_icon" class="form-control" id="inputGroupFile01" onchange="previewImage()">
                      </div>
                    </div>
                    <div class="mb-3">
                        <label for="badge_name" class="form-label">
                            <span class="text-primary fw-semibold">Nama Badge</span>
                        </label>
                        <input name="badge_name" type="text" class="form-control input-lg fw-bold" id="badge_name" value="{{ $mBadge->badge_name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="badge_price" class="form-label">
                            <span class="text-primary fw-semibold">Harga Point Badge</span>
                        </label>
                        <input name="badge_price" type="number" min="0" class="form-control input-lg fw-bold" id="badge_price" value="{{ $mBadge->badge_price }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="badge_level" class="form-label">
                            <span class="text-primary fw-semibold">Level Badge</span>
                        </label>
                        <input name="badge_level" type="number" min="1" max="100" step="1" class="form-control input-lg fw-bold" id="badge_level" value="{{ $mBadge->badge_level }}" required>
                    </div>
			</div>
			<div class="card-footer text-end">
				<button type="submit" class="btn btn-primary fw-bold">SIMPAN</button>
			</div>
		</div>
	</form>
</div>
@endsection

@push('scripts')
<script type="module">
    $('#editBadgeForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ route('editBadge') }}",
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
            },
            error: function(xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: xhr.responseText
                });
            }
        });
    });
</script>
<script type="text/javascript">
    function previewImage() {
        method_image_preview.src = URL.createObjectURL(event.target.files[0]);
    }
</script>
@endpush
