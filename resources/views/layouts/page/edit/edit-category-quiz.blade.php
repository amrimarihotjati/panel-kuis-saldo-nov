@extends('layouts.app')

@section('title', 'Edit CategoryQuiz')

@push('style')
@endpush

@section('content')
<div class="main-content">
	<form autocomplete="off" id="editCategoryQuizForm" enctype="multipart/form-data">
		@csrf
		<div class="card rounded rounded-4 shadow">
			<div class="card-header text-dark fw-bold d-flex justify-content-between align-items-center mt-2">
				<div class="h5 fw-bold">Edit CategoryQuiz</div>
                <a href="{{ route('deleteCategoryQuiz', $mCategoryQuiz->id) }}" class="btn btn-danger btn-sm fw-bold shadow-none rounded rounded-1" ><i class="fas fa-trash"></i></a>
			</div>
			<div class="card-body">
				<input name="category_quiz_id" type="hidden" value="{{ $mCategoryQuiz->id }}" required>
				<div class="mb-3">
					<label for="category_image" class="form-label">
						<span class="text-primary fw-semibold">Icon Kategori</span>
					</label>
					<div class="input-group mb-3">
						<label class="input-group-text border-0 ps-0" for="inputGroupFile01"><img alt="" src="{{ $mCategoryQuiz->category_image }}" class="img-fluid img-thumbnail" style="width:45px;min-height:45px;max-height:45px;background-color:#f4f4f4;" id="method_image_preview"></label>
						<input type="file" name="category_image" class="form-control" id="inputGroupFile01" onchange="previewImage()">
					</div>
				</div>
				<div class="mb-3">
                        <label for="category_name" class="form-label">
                            <span class="text-primary fw-semibold">Nama Kategori</span>
                        </label>
                        <input name="category_name" type="text" class="form-control input-lg fw-bold" id="category_name" value="{{ $mCategoryQuiz->category_name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_caption" class="form-label">
                            <span class="text-primary fw-semibold">Keterangan Kategori</span>
                        </label>
                        <input name="category_caption" type="text" class="form-control input-lg fw-semibold" id="category_caption" value="{{ $mCategoryQuiz->category_caption }}" required>
                    </div>
			</div>
			<div class="card-footer text-end">
				<button type="submit" class="btn btn-primary fw-bold">SIMPAN</button>
			</div>
		</div>
	</form>
    @include('layouts/page/inview/category-quiz/question-list')

</div>
@endsection

@push('scripts')
<script type="module">
    $('#editCategoryQuizForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ route('editCategoryQuiz') }}",
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
