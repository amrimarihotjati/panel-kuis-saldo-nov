@extends('layouts.app')

@section('title', 'Avatar')

@push('style')
@endpush

@section('content')
<div class="main-content">
	<div class="card rounded rounded-4 shadow">
		<div class="card-header text-dark fw-bold d-flex justify-content-between align-items-center mt-2">
			<div class="h5 fw-bold">Manage Avatar</div>
			<button type="button" class="btn btn-primary btn-sm fw-bold no-shadow rounded rounded-1"
			data-bs-toggle="modal" data-bs-target="#createAvatar"><i class="fas fa-plus"></i></button>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table id="dtAvatar" class="table table-bordered table-flush" style="width:100%">
					<thead>
						<tr>
							<th class="align-middle text-center">#</th>
							<th class="align-middle">Avatar</th>
							<th class="align-middle">Tanggal Dibuat</th>
							<th class="text-center align-middle">AKSI</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	@include('layouts/modal/create-avatar')
</div>
@endsection

@push('scripts')
<script type="module">
	$('#dtAvatar').DataTable({
		processing: true,
		serverSide: true,
		ajax: "{{ route('list-avatar') }}",
		aLengthMenu: [
			[10, 50, 100, 1000, 10000, -1],
			[10, 50, 100, 1000, 10000, "Semua"]
			],
		iDisplayLength: 10,
		columns: [{
			data: null,
			render: function(data, type, row, meta) {
				return meta.row + 1;
			},
			orderable: false,
			searchable: false,
			className: 'align-middle text-center text-muted'
		},
		{
			data: 'avatar_name',
			name: 'avatar_name',
			className: 'align-middle',
			render: function(data, type, full, meta) {
				return '<div class="d-flex align-items-center align-middle">' +
				'<img src="' + full.avatar_icon + '" alt="image" class="img-fluid img-thumbnail mt-1 mb-1" style="width:45px;height:45px; margin-right: 10px;">' +
				'<br><div class="align-middle">' +
				'<h6 class="fw-semibold mt-2">' + full.avatar_name + '</h6>' +
				'</div>' +
				'</div>';
			}
		},
		{
			data: 'created_at',
			name: 'created_at',
			searchable: false,
			className: 'align-middle',
			render: function(data, type, full, meta) {
				return '<span class="text-muted">' + full.created_at + '</span>';
			}
		},
		{
			data: null,
			name: 'actions',
			searchable: false,
			orderable: false,
			className: 'align-middle',
			render: function(data, type, full, meta) {
				return '<div class="text-center align-middle">' +
				'<a class="btn btn-secondary btn-sm text-dark" href="detail-avatar/' + full.id +
				'">' +
				'<i class="fa fa-edit" aria-hidden="true"></i></a>' +
				'</div>';
			}

		}
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
</script>
@endpush
