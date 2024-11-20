@extends('layouts.app')

@section('title', 'Rewards Ad Points')

@push('style')
@endpush

@section('content')
<div class="main-content">
<div class="card rounded rounded-4 shadow">
	<div class="card-header text-dark fw-bold d-flex justify-content-between align-items-center mt-2">
		<div class="h5 fw-bold">Manage Rewards Ad Point</div>
		<button type="button" class="btn btn-primary btn-sm fw-bold no-shadow rounded rounded-1"
		data-bs-toggle="modal" data-bs-target="#createRewardsAdPoints"><i class="fas fa-plus"></i></button>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table id="dtRewardsAdPoints" class="table table-bordered table-flush" style="width:100%">
				<thead>
					<tr>
						<th class="align-middle text-center">#</th>
						<th class="align-middle">Nama RewardsAdPoint</th>
						<th class="align-middle">Hadiah Points</th>
						<th class="align-middle">Nomor Urutan</th>
						<th class="align-middle">Jumlah Nonton Ads</th>
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

@include('layouts/modal/create-rewards-ad-points')
</div>
@endsection

@push('scripts')
<script type="module">
	$('#dtRewardsAdPoints').DataTable({
		processing: true,
		serverSide: true,
		ajax: "{{ route('list-rewardsadpoint') }}",
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
			data: 'title',
			name: 'title',
			className: 'align-middle',
			render: function(data, type, full, meta) {
				return '<div class="d-flex align-items-center">' +
				'<img src="/img/coins.svg" alt="image" class="" style="width:25px;height:25px; margin-right: 10px;">' +
				'<div>' +
				'<strong>' + full.title + '</strong>' +
				'</div>' +
				'</div>';
			}
		},
		{
			data: 'point_value',
			name: 'point_value',
			searchable: false,
			className: 'align-middle text-center',
			render: function(data, type, full, meta) {
				return '<span class="text-dark fw-bold">' + full.point_value + ' POINTS</span>';
			}
		},
		{
			data: 'point_number',
			name: 'point_number',
			searchable: false,
			className: 'align-middle text-center',
			render: function(data, type, full, meta) {
				return '<span class="text-dark fw-bold">NO ' + full.point_number + '</span>';
			}
		},
		{
			data: 'watch_ads_value',
			name: 'watch_ads_value',
			searchable: false,
			className: 'align-middle text-center',
			render: function(data, type, full, meta) {
				return '<span class="text-dark fw-semibold">' + full.watch_ads_value + ' IKLAN</span>';
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
				'<a class="btn btn-secondary btn-sm text-dark" href="detail-rewards-ad-points/' +
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