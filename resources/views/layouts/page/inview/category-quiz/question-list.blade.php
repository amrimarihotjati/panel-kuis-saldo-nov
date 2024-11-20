<div class="card rounded rounded-4 shadow">
	<div class="card-header text-dark fw-bold mt-2 d-flex justify-content-between align-items-center">
    <div class="h5 fw-bold">{{ $mCategoryQuiz->category_name }} Question</div>
    <div class="d-flex align-items-center">
        <button type="button" class="btn btn-primary btn-sm fw-bold shadow-none rounded rounded-1 me-2" data-bs-toggle="modal" data-bs-target="#createQuestion">
            <i class="fas fa-plus"></i>
        </button>
        <label>
        	<input id="file_input_xlss" type="file" class="d-none" name="file_question">
        	<a  id="name_of_file" class="btn btn-warning btn-sm fw-bold shadow-none rounded rounded-1"><i class="fas fa-file mr-2"></i></a>
        </label>
        <div>
        	<button id="deleteSelectedRows" class="d-none btn btn-danger btn-sm fw-bold shadow-none rounded rounded-1 ms-2">HAPUS ITEM TERPILIH</button>
        	<button id="checkAllRows" class="btn btn-success btn-sm fw-bold shadow-none rounded rounded-1 ms-1">PILIH SEMUA</button>
        </div>

    </div>
</div>

	<div class="card-body">
		<div class="table-responsive">
			<table id="dtQuestion" class="table table-bordered table-flush" style="width:100%">
				<thead>
					<tr>
						<th class="align-middle text-center">#</th>
						<th class="align-middle">Pertanyaan Kuis</th>
						<th class="align-middle">Level</th>
						<th class="align-middle">Point</th>
						<th class="text-center align-middle">AKSI</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>

@include('layouts/modal/create-question')

@push('scripts')
<script type="module">
	$(document).ready(function() {
		var table = $('#dtQuestion').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('list-question-quiz', $mCategoryQuiz->id) }}",
			aLengthMenu: [
				[10, 50, 100, 1000, 10000, -1],
				[10, 50, 100, 1000, 10000, "Semua"]
				],
			iDisplayLength: 10,
			columns: [
			{
				data: null,
				render: function(data, type, row, meta) {
					return meta.row + 1;
				},
				orderable: false,
				searchable: false,
				className: 'align-middle text-center text-muted'
			},
			{
				data: 'question',
				name: 'question',
				className: 'align-middle',
				render: function(data, type, full, meta) {
					return '<div class="d-flex align-items-center">' +
					'<strong>' + full.question + '</strong>' +
					'</div>';
				}
			},
			{
				data: 'level',
				name: 'level',
				searchable: false,
				className: 'align-middle text-center',
				render: function(data, type, full, meta) {
					return '<span class="text-muted">' + full.level + '</span>';
				}
			},
			{
				data: 'points',
				name: 'points',
				searchable: false,
				className: 'align-middle text-center',
				render: function(data, type, full, meta) {
					return '<span class="text-muted">' + full.points + '</span>';
				}
			},
			{
				data: null,
				render: function(data, type, row, meta) {
					return '<input type="checkbox" class="row-checkbox" data-id="' + row.id + '">';
				},
				orderable: false,
				searchable: false,
				className: 'align-middle text-center text-muted'
			},
			],
			language: {
				"paginate": {
					"first": "Pertama",
					"last": "Terakhir",
					"next": "Lanjut",
					"previous": "Kembali"
				},
				"emptyTable": "Tidak Ada data",
				"info": "_START_ sampai _END_ dari _TOTAL_ data",
				"infoEmpty": "Dari 0 sampai 0 of 0 data",
				"infoFiltered": "(Disaring dari _MAX_ total data)",
				"lengthMenu": "_MENU_<br/></br/>",
				"search": "",
				"zeroRecords": "Tidak ditemukan",
			},
			initComplete: function(settings, json) {
			}
		});

		$('#checkAllRows').on('click', function() {
			var allCheckboxes = table.$('.row-checkbox');
			var allChecked = allCheckboxes.filter(':checked').length === allCheckboxes.length;
			allCheckboxes.prop('checked', !allChecked);
			var selectedCount = $('.row-checkbox:checked').length;
			if (selectedCount > 0) {
				$('#deleteSelectedRows').text(selectedCount + ' HAPUS ITEM TERPILIH').removeClass('d-none');
			} else {
				$('#deleteSelectedRows').addClass('d-none');
			}
		});
	});

	$(document).on('change', '.row-checkbox', function() {
		var selectedCount = $('.row-checkbox:checked').length;
		if (selectedCount > 0) {
			$('#deleteSelectedRows').text(selectedCount + ' HAPUS ITEM TERPILIH').removeClass('d-none');
		} else {
			$('#deleteSelectedRows').addClass('d-none');
		}
	});

	$(document).ready(function() {
		$('#deleteSelectedRows').click(function() {
			var selectedIds = [];

			$('.row-checkbox:checked').each(function() {
				selectedIds.push($(this).data('id'));
			});

			var csrf_token = $('meta[name="csrf-token"]').attr('content');

			$.ajax({
				url: "{{ route('delete-multiple-questions') }}",
				type: "POST",
				headers: {
					'X-CSRF-TOKEN': csrf_token
				},
				data: {
					ids: selectedIds
				},
				success: function(response) {
					var dataTable = $('#dtQuestion').DataTable();
					dataTable.ajax.reload();
					Swal.fire({
						icon: "success",
						title: "Berhasil!",
						text: response.message
					});
					$('#deleteSelectedRows').addClass('d-none');
				},
				error: function(xhr, status, error) {
					Swal.fire({
						icon: "error",
						title: "Oops...",
						text: xhr.responseText
					});
				}
			});
		});
	});


	$('#file_input_xlss').change(function() {
		var file_data = $('#file_input_xlss').prop('files')[0];
		var form_data = new FormData();
		form_data.append('category_id', "{{ $mCategoryQuiz->id }}");
		form_data.append('file_question', file_data);

		var csrf_token = $('meta[name="csrf-token"]').attr('content');

		Swal.fire({
			title: 'Mengunggah...',
			html: '<div class="swal2-progress"><div class="swal2-progress-bar"></div></div>',
			customClass: {
				popup: 'swal2-noanimation',
				content: 'swal2-noanimation'
			},
			allowOutsideClick: false, 
			allowEscapeKey: false, 
			showConfirmButton: false,
			didOpen: () => {
				Swal.showLoading();
			}
		});

		$.ajax({
			url: "{{ route('import-question') }}",
			type: "POST",
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': csrf_token
			},
			xhr: function() {
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener("progress", function(evt) {
					if (evt.lengthComputable) {
						var percentComplete = (evt.loaded / evt.total) * 100;
						Swal.getHtmlContainer().querySelector('.swal2-progress-bar')
						.style.width = percentComplete + '%';
					}
				}, false);

				return xhr;
			},
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			success: function(response) {
				Swal.fire({
					icon: "success",
					title: "BERHASIL!",
					text: response.message
				}).then(() => {
					Swal.close();
				});
				var dataTable = $('#dtQuestion').DataTable();
				dataTable.ajax.reload();
				$('#file_input_xlss').val('');
			},
			error: function(xhr, status, error) {
				Swal.fire({
					icon: "error",
					title: "Oops...",
					text: xhr.responseText
				}).then(() => {
					Swal.enableButtons();
				});
				$('#file_input_xlss').val('');
			},
			complete: function() {
				Swal.enableButtons();
				$('#file_input_xlss').val('');
			}
		});
	});

</script>
@endpush