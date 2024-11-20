@extends('layouts.app')

@section('title', 'History Refferal')

@push('style')
@endpush

@section('content')
<div class="main-content">
	<div class="card rounded rounded-4 shadow">
		<div class="card-header text-dark fw-bold d-flex justify-content-between align-items-center mt-2">
                <div class="h5 fw-bold">History Refferal Player<br>
                    <span class="h6 fw-semibold text-muted">package : {{ $mBaseApplication->app_pkg }}</span>
                </div>
            </div>
		<div class="card-body">
			<div class="table-responsive">
				<table id="dtRefferalPlayer" class="table table-bordered table-flush" style="width:100%">
					<thead>
						<tr>
							<th class="align-middle text-center">#</th>
							<th class="align-middle">Player Rekomendasi</th>
							<th class="align-middle">Player Didaftarkan</th>
							<th class="align-middle">Point Diperoleh</th>
							<th class="align-middle">Waktu Terdaftar</th>
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
	$('#dtRefferalPlayer').DataTable({
		processing: true,
		serverSide: true,
		ajax: "{{ route('list-refferal-player', $mBaseApplication->app_pkg) }}",
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
                data: 'refferaled_from_player',
                name: 'refferaled_from_player',
                className: 'align-middle',
                orderable: false,
                render: function(data, type, full, meta) {
                    var fromPlayer = full.from_player;
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
                data: 'refferaled_registered_player',
                name: 'refferaled_registered_player',
                className: 'align-middle',
                orderable: false,
                render: function(data, type, full, meta) {
                    var registeredPlayer = full.registered_player;
                    var imageUrl = registeredPlayer && registeredPlayer.image_url ? registeredPlayer.image_url : '/img/default_avatar.png';
                    var playerName = registeredPlayer ? registeredPlayer.name : 'Unknown';
                    var playerEmail = registeredPlayer ? registeredPlayer.email : 'Unknown';
                    
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
			data: 'refferaled_coins_added_to_player',
			name: 'refferaled_coins_added_to_player',
			searchable: false,
			className: 'align-middle text-center',
			render: function(data, type, full, meta) {
				var formatter = new Intl.NumberFormat('id-ID', {
					 minimumFractionDigits: 0,
					 maximumFractionDigits: 0
				});
				var svgIconPath = '/img/points.svg';
				var svgIcon = `<img src="${svgIconPath}" height="15px" width="15px" style="vertical-align: middle;margin-bottom:4px;margin-right:2px">`;
				return '<span class="fw-semibold">' + `${svgIcon} ${formatter.format(full.refferaled_coins_added_to_player)}` + '</span>';
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
