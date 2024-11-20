<div class="modal" id="createQuestion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content rounded rounded-4">
			<form autocomplete="off" id="createQuestionForm" enctype="multipart/form-data">
				@csrf
				<div class="modal-header border-bottom-0">
					<h5 class="modal-title" id="staticBackdropLabel">Tambah Question</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body pb-0" style="max-height: calc(100vh - 210px); overflow-y: auto;">
					<input type="hidden" name="category_id" value="{{ $mCategoryQuiz->id }}">
					<div class="mb-3">
						<label for="question" class="form-label">
							<span class="text-primary fw-bold">Pertanyaan Kuis</span>
						</label>
						<textarea name="question" class="form-control input-lg fw-semibold" style="height:150px;resize:none;" id="question" rows="4" cols="50" required></textarea>
					</div>
					<div class="row">
						<div class="col">
							<div class="mb-3">
								<label for="true_answer" class="form-label">
									<span class="text-primary fw-bold">Jawaban Benar</span>
								</label>
								<input name="true_answer" type="text" class="form-control input-lg fw-semibold" id="true_answer" required>
							</div>
						</div>
						<div class="col">
							<div class="mb-3">
								<label for="false_answer1" class="form-label">
									<span class="text-primary fw-bold">Jawaban Salah 1</span>
								</label>
								<input name="false_answer1" type="text" class="form-control input-lg fw-semibold" id="false_answer1" equired>
							</div>
						</div>
						<div class="col">
							<div class="mb-3">
								<label for="false_answer2" class="form-label">
									<span class="text-primary fw-bold">Jawaban Salah 2</span>
								</label>
								<input name="false_answer2" type="text" class="form-control input-lg fw-semibold" id="false_answer2"  required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="mb-3">
								<label for="false_answer3" class="form-label">
									<span class="text-primary fw-bold">Jawaban Salah 3</span>
								</label>
								<input name="false_answer3" type="text" class="form-control input-lg fw-semibold" id="false_answer3" required>
							</div>
						</div>
						<div class="col">
							<div class="mb-3">
								<label for="level" class="form-label">
									<span class="text-primary fw-bold">Level Kuis</span>
								</label>
								<input name="level" type="number" min="0" step="1" class="form-control input-lg fw-semibold" id="level" value="0" required>
							</div>
						</div>
						<div class="col">
							<div class="mb-3">
								<label for="points" class="form-label">
									<span class="text-primary fw-bold">Point Didapatkan</span>
								</label>
								<input name="points" type="number" min="1" step="1" class="form-control input-lg fw-semibold" id="points" value="2" required>
							</div>
						</div>
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
	$('#createQuestionForm').on('submit', function(event) {
		event.preventDefault();
		var formData = $(this).serialize();
		$.ajax({
			url: "{{ route('createQuestion') }}",
			type: "POST",
			data: formData,
			success: function(response) {
				Swal.fire({
					icon: "success",
					title: "BERHASIL!",
					text: response.message
				});
				$('#createQuestion').modal('hide');
				var dataTable = $('#dtQuestion').DataTable();
				dataTable.ajax.reload();
			},
			error: function(xhr) {
				Swal.fire({
					icon: "error",
					title: "Oops...",
					text: xhr.responseText
				});
				$('#createQuestion').modal('hide');
			}
		});
	});
</script>