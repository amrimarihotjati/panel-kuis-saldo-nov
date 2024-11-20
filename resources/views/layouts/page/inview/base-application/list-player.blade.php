@extends('layouts.app')

@section('title', 'List Player')

@push('style')
@endpush

@section('content')
<div class="main-content">
	<div class="card rounded rounded-4 shadow">
		<div class="card-header text-dark fw-bold d-flex justify-content-between align-items-center mt-2">
			<div class="h5 fw-bold">Manage Player<br>
				<span class="h6 fw-semibold text-muted">package : {{ $mBaseApplication->app_pkg }}</span>
			</div>
			<div class="h5 fw-bold">
				<button type="button" class="btn btn-primary btn-sm fw-bold no-shadow rounded rounded-1"
			data-bs-toggle="modal" data-bs-target="#createPlayer"><i class="fas fa-plus"></i></button>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
{{-- 				<div class="ms-3 me-3">
					<input type="text" class="form-control" id="searchFilter" aria-describedby="searchFilter">
					<div id="searchFilterHelp" class="form-text">Cari player berdasarkan id, nama atau email</div>
				</div> --}}
				<table id="dtPlayer" class="table table-bordered table-flush" style="width:100%">
					<thead>
						<tr>
							<th class="align-middle text-center">#</th>
							<th class="align-middle">Player</th>
							<th class="align-middle text-center">Points</th>
							<th class="align-middle text-center">Points Collected</th>
							<th class="align-middle text-center">Score</th>
							<th class="align-middle text-center">Status Player</th>
							<th class="align-middle text-center">Terdaftar</th>
							<th class="text-center align-middle">AKSI</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
		@include('layouts/modal/create-player')
</div>
@endsection

@push('scripts')
<script type="module">
	$(document).ready(function() {
	var table = $('#dtPlayer').DataTable({
		processing: true,
		serverSide: true,
		searching: true,
		ajax: "{{ route('list-player', $mBaseApplication->app_pkg) }}",
		aLengthMenu: [
			[50, 100, 1000, 10000, -1],
			[50, 100, 1000, 10000, "Semua"]
			],
		iDisplayLength: 50,
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
			data: 'name',
			name: 'name',
			className: 'align-middle',
			render: function(data, type, full, meta) {
				if(type === 'display'){
					var imageUrl = full.image_url ? full.image_url : '/img/default_avatar.png';
					data = '<div class="d-flex align-items-center align-middle">' +
					'<img src="' + imageUrl + '" alt="" class="avatar border border-secondary border-3" style="width:35px;height:35px; margin-right: 10px;">' +
					'<div>' +
					'<span class="fw-bold">' + full.name + '</span></br>' +
					'<span class="fw-semibold">' + full.email + '</span>' +
					'</div>' +
					'</div>';
				}
				return data;
			},
		},
		{
			data: 'points',
			name: 'points',
			searchable: false,
			className: 'align-middle text-center',
			render: function(data, type, full, meta) {
				var formatter = new Intl.NumberFormat('id-ID', {
					 minimumFractionDigits: 0,
					 maximumFractionDigits: 0
				});
				var svgIconPath = '/img/points.svg';
				var svgIcon = `<img src="${svgIconPath}" height="15px" width="15px" style="vertical-align: middle;margin-bottom:4px;margin-right:2px">`;
				return '<span class="fw-semibold">' + `${svgIcon} ${formatter.format(full.points)}` + '</span>';
			}
		},
		{
			data: 'points_collected',
			name: 'points_collected',
			searchable: false,
			className: 'align-middle text-center',
			render: function(data, type, full, meta) {
				var formatter = new Intl.NumberFormat('id-ID', {
					 minimumFractionDigits: 0,
					 maximumFractionDigits: 0
				});
				var svgIconPath = '/img/points.svg';
				var svgIcon = `<img src="${svgIconPath}" height="15px" width="15px" style="vertical-align: middle;margin-bottom:4px;margin-right:2px">`;
				return '<span class="fw-semibold">' + `${svgIcon} ${formatter.format(full.points_collected)}` + '</span>';
			}
		},
		{
			data: 'score',
			name: 'score',
			searchable: false,
			className: 'align-middle text-center',
			render: function(data, type, full, meta) {
				var formatter = new Intl.NumberFormat('id-ID', {
					 minimumFractionDigits: 0,
					 maximumFractionDigits: 0
				});
				var svgIconPath = '/img/trophy.svg';
				var svgIcon = `<img src="${svgIconPath}" height="25px" width="25px" style="vertical-align: middle;margin-bottom:4px;margin-right:2px">`;
				return '<span class="fw-semibold">' + `${svgIcon} ${formatter.format(full.score)}` + '</span>';
			}
		},
		{
			data: 'status',
			name: 'status',
			searchable: false,
			className: 'align-middle text-center',
			render: function(data, type, full, meta) {
				var svgIconPath;
				var status;
				switch(full.status) {
				case 0:
					svgIconPath = '/img/safe.svg';
					status = '<span class="fw-bold text-primary">NORMAL</span>';
					break;
				case 1:
					svgIconPath = '/img/warning.svg';
					status = '<span class="fw-bold text-warning">WARNING</span>';
					break;
				case 2:
					svgIconPath = '/img/denied.svg';
					status = '<span class="fw-bold text-danger">BANNED</span>';
					break;
				default:
					svgIconPath = '';
					status = 'UNKNOWN';
				}
				var svgIcon = `<img src="${svgIconPath}" height="15px" width="15px" style="vertical-align: middle;margin-bottom:4px;margin-right:3px">`;
				return '<span class="fw-semibold">' + svgIcon + '<strong>' + status +  '</strong></span>';
			}
		},
		{
			data: 'created_at',
			name: 'created_at',
			searchable: false,
			className: 'align-middle text-center',
			render: function(data, type, full, meta) {
				return '<span class="fw-bold text-muted">' + full.created_at + '</span>';
			}
		},
		{
			data: null,
			name: 'actions',
			searchable: false,
			orderable: false,
			className: 'align-middle text-center',
			render: function(data, type, full, meta) {
				var pantauButton = '<a href="/pantau-player-collected-points/' + full.id + '" class="btn btn-sm btn-success shadow-none fw-bold ms-1" data-placement="top">PANTAU</a>';
				var actionButton = '<div class="text-center align-middle">' +
				'<a class="btn btn-sm btn-primary shadow-none fw-bold ms-1" href="/detail-player/' +
				full.id + '">' +
				'<i class="fa fa-edit" aria-hidden="true"></i></a>' + '</div>';
				return '<div class="d-flex justify-content-between">' + actionButton + pantauButton + '</div>';
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
			"search": "<b>Cari ID, Nama atau Email : </b>",
			"zeroRecords": "Tidak ditemukan",
		},
		initComplete: function(settings, json) {

		}
	});
});
</script>
@endpush
