<div class="modal" id="createPlayer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content rounded rounded-4">
			<form autocomplete="off" id="createPlayerForm">
				@csrf
				<div class="modal-header border-bottom-0">
					<h5 class="modal-title" id="staticBackdropLabel">Tambah Player</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body pb-0" style="max-height: calc(100vh - 210px); overflow-y: auto;">
					<input type="hidden" name="app_pkg" value="{{ $mBaseApplication->app_pkg }}">
					<div class="row">
						<div class="col-md-6">
							<div class="mb-3">
								<label for="name" class="form-label">
									<span class="text-primary fw-bold">Nama Player</span>
								</label>
								<input name="name" type="text" class="form-control input-lg fw-semibold" id="name" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="email" class="form-label">
									<span class="text-primary fw-bold">Email Player</span>
								</label>
								<input name="email" type="email" class="form-control input-lg fw-semibold" id="email" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="points" class="form-label">
									<span class="text-primary fw-bold">Point</span>
								</label>
								<input name="points" type="number" step="1" min="0" class="form-control input-lg fw-semibold" id="points" value="0" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="score" class="form-label">
									<span class="text-primary fw-bold">Score</span>
								</label>
								<input name="score" type="number" step="1" min="0" class="form-control input-lg fw-semibold" id="score" value="0" required>
							</div>
						</div>
						<div class="col-md-12">
							<div class="mb-3">
								<label for="password" class="form-label">
									<span class="text-primary fw-bold">Password</span>
								</label>
								<input name="password" type="text" class="form-control input-lg fw-semibold" id="password" required>
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
	$('#createPlayerForm').on('submit', function(event) {
		event.preventDefault();
		var formData = $(this).serialize();
		$.ajax({
			url: "{{ route('createPlayer') }}",
			type: "POST",
			data: formData,
			success: function(response) {
				Swal.fire({
					icon: "success",
					title: "BERHASIL!",
					text: response.message
				});
				$('#createPlayer').modal('hide');
				var dataTable = $('#dtPlayer').DataTable();
				dataTable.ajax.reload();
			},
			error: function(xhr) {
				Swal.fire({
					icon: "error",
					title: "Oops...",
					text: xhr.responseText
				});
				$('#createPlayer').modal('hide');
			}
		});
	});
</script>