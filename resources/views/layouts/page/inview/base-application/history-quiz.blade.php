@extends('layouts.app')

@section('title', 'History Quiz')

@push('style')
@endpush

@section('content')
<div class="main-content">
	<div class="card rounded rounded-4 shadow">
		<div class="card-header text-dark fw-bold d-flex justify-content-between align-items-center mt-2">
                <div class="h5 fw-bold">History Quiz Player<br>
                    <span class="h6 fw-semibold text-muted">package : {{ $mBaseApplication->app_pkg }}</span>
                </div>
            </div>
		<div class="card-body">
			<div class="table-responsive">
				<table id="dtHistoryQuizPlayer" class="table table-bordered table-flush" style="width:100%">
					<thead>
						<tr>
							<th class="align-middle text-center">#</th>
							<th class="align-middle">Player</th>
							<th class="align-middle">Score Diraih</th>
							<th class="align-middle">Points Didapat</th>
							<th class="align-middle">Ad Inters</th>
							<th class="align-middle">Ad Rewards</th>
							<th class="align-middle">Kategori Kuis</th>
							<th class="align-middle">With 50%</th>
							<th class="align-middle">Double Point</th>
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
		$('#dtHistoryQuizPlayer').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('list-history-quiz-player', $mBaseApplication->app_pkg) }}",
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
				data: 'ads_watched_inters',
				name: 'ads_watched_inters',
				searchable: false,
				className: 'align-middle text-center',
				render: function(data, type, full, meta) {
					var formatter = new Intl.NumberFormat('id-ID', {
						minimumFractionDigits: 0,
						maximumFractionDigits: 0
					});
					return '<span class="fw-semibold">' + `${formatter.format(full.ads_watched_inters)}` + ' ADS</span>';
				}
			},
			{
				data: 'ads_watched_rewards',
				name: 'ads_watched_rewards',
				searchable: false,
				className: 'align-middle text-center',
				render: function(data, type, full, meta) {
					var formatter = new Intl.NumberFormat('id-ID', {
						minimumFractionDigits: 0,
						maximumFractionDigits: 0
					});
					return '<span class="fw-semibold">' + `${formatter.format(full.ads_watched_rewards)}` + ' ADS</span>';
				}
			},
			{
				data: 'category_id',
				name: 'category_id',
				searchable: false,
				className: 'align-middle',
				render: function(data, type, full, meta) {
					var catQuiz = full.category_quiz;
					var imageUrl = catQuiz && catQuiz.category_image ? catQuiz.category_image : '/img/img_null.svg';
					var categoryName = catQuiz ? catQuiz.category_name : 'Unknown';

					return '<div class="d-flex align-items-center align-middle">' +
					'<img src="' + imageUrl + '" alt="" class="img-fluid img-thumbnail border border-secondary border-3" style="width:50px;height:50px; margin-right: 10px;">' +
					'<div>' +
					'<span class="fw-bold">' + categoryName + '</span></br>' +
					'<small class="fw-bold">Level Kuis : ' + full.category_level + '</small></br>' +
					'<small class="fw-semibold text-muted">Total Point : ' + full.total_quiz_points + '</small>' +
					'</div>' +
					'</div>';
				}
			},
			{
				data: 'completed_option',
				name: 'completed_option',
				searchable: false,
				className: 'align-middle text-center',
				render: function(data, type, full, meta) {
					var dataCompletedOption = full.completed_option;
					var result = 'unknown';
					if (dataCompletedOption === 1) {
						result = '<small class="badge rounded-pill bg-primary fw-bold">YA</small>';
					} else {
						result = '<small class="badge rounded-pill bg-light text-muted  fw-bold">TIDAK</small>';
					}
					return result;
				}
			},
			{
				data: 'with_double_option',
				name: 'with_double_option',
				searchable: false,
				className: 'align-middle text-center',
				render: function(data, type, full, meta) {
					var dataDoubleOption = full.with_double_option;
					var result = 'unknown';
					if (dataDoubleOption === 1) {
						result = '<small class="badge rounded-pill bg-info fw-bold">YA</small>';
					} else {
						result = '<small class="badge rounded-pill bg-light text-muted fw-bold">TIDAK</small>';
					}
					return result;
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
