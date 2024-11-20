@extends('layouts.app')

@section('title', 'WatchList Player')

@push('style')
@endpush

@section('content')
<div class="main-content">
	<div class="card rounded rounded-4 shadow">
		<div class="card-header text-dark fw-bold d-flex justify-content-between align-items-center mt-2">
			<div class="h5 fw-bold">WatchList Player<br>
				<span class="h6 fw-semibold text-muted">package : {{ $mBaseApplication->app_pkg }}</span>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table id="dtWatchListPlayer" class="table table-bordered table-flush" style="width:100%">
					<thead>
						<tr>
							<th class="align-middle text-center">#</th>
							<th class="align-middle">Player</th>
							<th class="align-middle">Alasan Terindikasi</th>
							<th class="align-middle">Indikasi</th>
							<th class="text-center align-middle">AKSI</th>
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

	$(document).ready(function() {
		var table = $('#dtWatchListPlayer').DataTable({
			processing: true,
			serverSide: true,
			searching: true,
			ajax: "{{ route('watchlist-player', $mBaseApplication->app_pkg) }}",
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
					data: 'player.name',
					name: 'player.name',
					className: 'align-middle',
					orderable: false,
					render: function(data, type, full, meta) {
						var fromPlayer = full.player;
						var imageUrl = fromPlayer && fromPlayer.image_url ? fromPlayer.image_url :
						'/img/default_avatar.png';
						var playerName = fromPlayer ? fromPlayer.name : 'Unknown';
						var playerEmail = fromPlayer ? fromPlayer.email : 'Unknown';
						var playerPoints = fromPlayer ? fromPlayer.points : 'Unknown';
						var playerPointsCollected = fromPlayer ? fromPlayer.points_collected : 'Unknown';

						return '<div class="d-flex align-items-center align-middle">' +
						'<img src="' + imageUrl +
						'" alt="" class="avatar border border-secondary border-3" style="width:50px;height:50px; margin-right: 10px;">' +
						'<div>' +
						'<span class="fw-bold">' + playerName + '</span></br>' +
						'<span class="fw-semibold">' + playerEmail + '</span><br>' +
						'<small class="fw-semibold text-primary">Current Point : ' + playerPoints + '</small><br>' +
						'<small class="fw-semibold text-primary"> Point collected : ' + playerPointsCollected + '</small><br>' +
						'</div>' +
						'</div>';
					}
				},
				{
					data: 'reason',
					name: 'reason',
					searchable: false,
					orderable: false,
					className: 'align-middle',
					render: function(data, type, full, meta) {
						if (Array.isArray(full.reason)) {
							let reversedReasons = full.reason.slice().reverse();
							return '<ul class="text-danger" style="line-height: 1.1;">' + 
							reversedReasons.map(item => 
								'<li><small class="fw-bold text-danger">' + item + '</small></li>'
								).join('') + 
							'</ul>';
						} else {
							return '<small class="fw-semibold text-danger">' + full.reason + '</small>';
						}
					}
				},
				{
					data: null,
					name: null,
					orderable: false,
					searchable: false,
					className: 'align-middle text-center',
					render: function(data, type, full, meta) {
						if (Array.isArray(full.reason)) {
							return '<span class="fw-semibold text-dark">' + full.reason.length + ' KALI</span';
						} else {
							return '';
						}
					}
				},
				{
					data: null,
					name: 'actions',
					searchable: false,
					orderable: false,
					className: 'align-middle text-center',
					render: function(data, type, full, meta) {
						var player = full.player;
						var playerID = full.player.id ?? 'null';

						var pantauButton = '<a href="/pantau-player-collected-points/' + playerID + '" class="btn btn-sm btn-success shadow-none fw-bold" data-placement="top" title="Pantau">' +
						'<i class="fa fa-eye"></i></a>';

						var detailButton = '<a href="/detail-player/' + playerID + '" class="btn btn-sm btn-primary shadow-none fw-bold" title="Detail">' +
						'<i class="fa fa-info-circle"></i></a>';

						var hapusButton = '<a href="/remove-player-from-watch-list/' + playerID + '" class="btn btn-sm btn-danger shadow-none fw-bold" title="Hapus">' +
						'<i class="fa fa-trash"></i></button>';

						return '<div class="d-flex justify-content-center text-center align-middle gap-2">' + detailButton + pantauButton + hapusButton + '</div>';
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
				console.log(json);
			}
		});
	});
</script>
@endpush
