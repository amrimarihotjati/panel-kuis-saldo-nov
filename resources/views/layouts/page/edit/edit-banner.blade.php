@extends('layouts.app')

@section('title', 'Edit Banner')

@push('style')
@endpush

@section('content')
<div class="main-content">
	<form autocomplete="off" id="editBannerForm" enctype="multipart/form-data">
		@csrf
		<div class="card rounded rounded-4 shadow">
			<div class="card-header text-dark fw-bold d-flex justify-content-between align-items-center mt-2">
				<div class="h5 fw-bold">Edit Banner</div>
				<a href="{{ route('deleteBanner', $mBanner->id) }}" class="btn btn-danger btn-sm fw-bold shadow-none rounded rounded-1" ><i class="fas fa-trash"></i></a>

			</div>
			<div class="card-body">
				<input name="banner_id" type="hidden" value="{{ $mBanner->id }}" required>
				<div class="mb-3">
					<label for="banner_title" class="form-label">
						<span class="text-primary fw-semibold">Judul Banner</span>
					</label>
					<input name="banner_title" type="text" class="form-control input-lg fw-bold" id="banner_title" value="{{ $mBanner->banner_title }}" required>
				</div>
				<div class="mb-3">
					<label for="banner_url" class="form-label">
						<span class="text-primary fw-semibold">URL Banner</span>
					</label>
					<input name="banner_url" type="text" class="form-control input-lg fw-semibold" id="banner_url" value="{{ $mBanner->banner_url }}" required>
				</div>
				<div class="mb-3">
					<label for="banner_description" class="form-label">
						<span class="text-primary fw-semibold">Deskripsi</span>
					</label>
					<input name="banner_description" type="text" class="form-control input-lg" id="banner_description" value="{{ $mBanner->banner_description }}" required>
				</div>
				<div class="mb-3">
					<label for="banner_image" class="form-label">
						<span class="text-primary fw-semibold">Gambar Banner</span>
					</label>
					<br>
					<img alt="" src="{{ $mBanner->banner_image }}" class="img-fluid img-thumbnail" style="width:100%;min-height:400px;max-height:400px;background-color:#f4f4f4;" id="method_image_preview">
					<br>
					<input name="banner_image" type="file" class="form-control input-lg fw-bold mt-2" id="banner_image" onchange="previewImage()">
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
    $('#editBannerForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ route('editBanner') }}",
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