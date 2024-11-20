@extends('layouts.app')

@section('title', 'Badge')

@push('style')
@endpush

@section('content')
<div class="main-content">
	<div class="card rounded rounded-4 shadow">
		<div class="card-header text-dark fw-bold d-flex justify-content-between align-items-center mt-2">
			<div class="h5 fw-bold">Manage Badge</div>
			<button type="button" class="btn btn-primary btn-sm fw-bold no-shadow rounded rounded-1"
			data-bs-toggle="modal" data-bs-target="#createBadge"><i class="fas fa-plus"></i></button>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table id="dtBadge" class="table table-bordered table-flush" style="width:100%">
					<thead>
						<tr>
							<th class="align-middle text-center">#</th>
							<th class="align-middle">Nama Badge</th>
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

	@include('layouts/modal/create-badge')
</div>
@endsection

@push('scripts')
<script type="module">
	$('#dtBadge').DataTable({
		processing: true,
		serverSide: true,
		ajax: "{{ route('list-badge') }}",
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
			data: 'badge_name',
			name: 'badge_name',
			className: 'align-middle',
			render: function(data, type, full, meta) {
				return '<div class="d-flex align-items-center align-middle">' +
				'<img src="' + full.badge_icon + '" alt="image" class="img-fluid img-thumbnail mt-1 mb-1" style="width:60px;height:60px; margin-right: 10px;">' +
				'<br><div class="align-middle">' +
				'<span class="fw-bold mt-2">' + full.badge_name + '</span><br>' +
				'<span class="fw-semibold mt-2">Level : ' + full.badge_level + '</span><br>' +
				'<span class="fw-normal mt-2">Harga : ' + full.badge_price + ' point</span>' +
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
				'<a class="btn btn-secondary btn-sm text-dark" href="detail-badge/' +
				full.id + '">' +
				'<i class="fa fa-cog" aria-hidden="true"></i></a>' +
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
