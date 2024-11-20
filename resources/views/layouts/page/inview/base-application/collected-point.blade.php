@extends('layouts.app')

@section('title', 'History Collected Point')

@push('style')
@endpush

@section('content')
<div class="main-content">
	<div class="card rounded rounded-4 shadow">
		<div class="card-header text-dark fw-bold d-flex justify-content-between align-items-center mt-2">
                <div class="h5 fw-bold">History collected point<br>
                    <span class="h6 fw-semibold text-muted">package : {{ $mBaseApplication->app_pkg }}</span>
                </div>
            </div>
		<div class="card-body">
			<div class="table-responsive">
				<table id="dtHistoryCollectedPointPlayer" class="table table-bordered table-flush" style="width:100%">
					<thead>
						<tr>
							<th class="align-middle text-center">#</th>
							<th class="align-middle">Player</th>
							<th class="align-middle">Point Didapat</th>
							<th class="align-middle">Jumlah Point</th>
							<th class="align-middle">Deskripsi</th>
							<th class="align-middle">Ad Inters</th>
							<th class="align-middle">Ad Rewards</th>
							<th class="align-middle">Waktu Diperoleh</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	@endsection

	@push('scripts')
	<script type="module">
		$('#dtHistoryCollectedPointPlayer').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('list-history-collected-point-player', $mBaseApplication->app_pkg) }}",
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
				data: 'player.name',
				name: 'player.name',
				orderable: false,
				className: 'align-middle',
				render: function(data, type, full, meta) {
					var fromPlayer = full.player;
					var imageUrl = fromPlayer && fromPlayer.image_url ? fromPlayer.image_url : '/img/default_avatar.png';
					var playerName = fromPlayer ? fromPlayer.name : 'Unknown';
					var playerEmail = fromPlayer ? fromPlayer.email : 'Unknown';

					return '<div class="d-flex align-items-center align-middle">' +
					'<img src="' + imageUrl + '" alt="" class="avatar border border-secondary border-3" style="width:35px;height:35px; margin-right: 10px;">' +
					'<div>' +
					'<span class="fw-bold">' + playerName + '</span></br>' +
					'<span class="fw-semibold">' + playerEmail + '</span>' +
					'</div>' +
					'</div>';
				}
			},
			{
				data: 'point_collected_from',
				name: 'point_collected_from',
				searchable: false,
				className: 'align-middle',
				render: function(data, type, full, meta) {
					return '<small class="fw-bold">' + full.point_collected_from + '</small>';
				}
			},
			{
				data: 'point_collected_value',
				name: 'point_collected_value',
				searchable: false,
				className: 'align-middle text-center',
				render: function(data, type, full, meta) {
					var formatter = new Intl.NumberFormat('id-ID', {
						minimumFractionDigits: 0,
						maximumFractionDigits: 0
					});
					var svgIconPath = '/img/points.svg';
					var svgIcon = `<img src="${svgIconPath}" height="15px" width="15px" style="vertical-align: middle;margin-bottom:4px;margin-right:2px">`;
					return '<span class="fw-semibold">' + `${svgIcon} ${formatter.format(full.point_collected_value)}` + '</span>';
				}
			},
			{
				data: 'description',
				name: 'description',
				searchable: false,
				className: '',
				render: function(data, type, full, meta) {
					return '<small class="fw-semibold">' + full.description + '</small>';
				}
			},
			{
				data: 'ads_watched_inters_is_exist',
				name: 'ads_watched_inters_is_exist',
				searchable: false,
				orderable: false,
				className: 'align-middle text-center',
				render: function(data, type, full, meta) {
					var value = full.ads_watched_inters_is_exist !== null ? full.ads_watched_inters_is_exist : '0';
					return '<small class="fw-bold">' + value + ' ADS</small>';
				}
			},
			{
				data: 'ads_watched_rewards_is_exist',
				name: 'ads_watched_rewards_is_exist',
				searchable: false,
				orderable: false,
				className: 'align-middle text-center',
				render: function(data, type, full, meta) {
					var value = full.ads_watched_rewards_is_exist !== null ? full.ads_watched_rewards_is_exist : '0';
					return '<small class="fw-bold">' + value + ' ADS</small>';
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
	</script>
	@endpush
