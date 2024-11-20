@extends('layouts.app')

@section('title', 'Completed Point Kaget')

@push('style')
@endpush

@section('content')
<div class="main-content">
	<div class="card rounded rounded-4 shadow">
		<div class="card-header text-dark fw-bold d-flex justify-content-between align-items-center mt-2">
			<div class="h5 fw-bold">Completed Point Kaget<br>
				<span class="h6 fw-semibold text-muted">package : {{ $mBaseApplication->app_pkg }}</span>
			</div>
			<div class="h5 fw-bold">
				<button type="button" class="btn btn-danger btn-sm fw-bold no-shadow rounded rounded-1" id="resetCompletedPointKaget"><i class="fas fa-sync-alt fa-sm"></i> RESET DATA</button>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table id="dtQuizCompletedPointKagetPlayer" class="table table-bordered table-flush" style="width:100%">
					<thead>
						<tr>
							<th class="align-middle text-center">#</th>
							<th class="align-middle">Player</th>
							<th class="align-middle">Point Kaget</th>
							<th class="align-middle">Task Selesai</th>
							<th class="align-middle">Bonus Point</th>
							<th class="align-middle">Terklaim</th>
							<th class="align-middle">Ad Inter</th>
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
		$('#dtQuizCompletedPointKagetPlayer').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('getDTCompletedPointKaget', $mBaseApplication->app_pkg) }}",
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
				data: 'rewards_ad_points.name',
				name: 'rewards_ad_points.name',
				orderable: false,
				className: 'align-middle',
				render: function(data, type, full, meta) {
					var pointKaget = full.rewards_ad_points;
					var title = pointKaget ? pointKaget.title : 'Unknown';
					var taskValue = pointKaget ? pointKaget.watch_ads_value : 'Unknown';

					return '<div class="d-flex align-items-center align-middle">' +
					'<img src="/img/coins.svg" alt="" class="avatar border border-secondary border-3" style="width:35px;height:35px; margin-right: 10px;">' +
					'<div>' +
					'<small class="fw-bold">' + title + '</small></br>' +
					'<small class="fw-normal"> Jumlah Task : ' + taskValue + '</small>' +
					'</div>' +
					'</div>';
				}
			},
			{
				data: 'task_count',
				name: 'task_count',
				searchable: false,
				orderable: false,
				className: 'align-middle text-center',
				render: function(data, type, full, meta) {
					var value = full.task_count !== null ? full.task_count : '0';
					return '<small class="fw-bold">' + value + ' TASK</small>';
				}
			},
			{
				data: 'bonus_points',
				name: 'bonus_points',
				searchable: false,
				className: 'align-middle text-center',
				render: function(data, type, full, meta) {
					var formatter = new Intl.NumberFormat('id-ID', {
						minimumFractionDigits: 0,
						maximumFractionDigits: 0
					});
					var svgIconPath = '/img/points.svg';
					var svgIcon = `<img src="${svgIconPath}" height="15px" width="15px" style="vertical-align: middle;margin-bottom:4px;margin-right:2px">`;
					return '<span class="fw-semibold">' + `${svgIcon} ${formatter.format(full.bonus_points)}` + '</span>';
				}
			},
			{
				data: 'is_claimmed',
				name: 'is_claimmed',
				searchable: false,
				orderable: false,
				className: 'align-middle text-center',
				render: function(data, type, full, meta) {
					var svgIconPath;
					var is_claimmed;
					switch (full.is_claimmed) {
					case 0:
						svgIconPath = '/img/pending.svg';
						break;
					case 1:
						svgIconPath = '/img/done.svg';
						break;
					default:
						svgIconPath = '/img/pending.svg';
					}
					var svgIcon =
					`<img src="${svgIconPath}" height="20px" width="20px" style="vertical-align: middle;margin-bottom:4px;margin-right:3px">`;
					return '<span class="fw-semibold">' + svgIcon + '</span>';
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
				console.log(json);
			}
		});
	</script>
	<script>
		$(document).ready(function() {
			$('#resetCompletedPointKaget').on('click', function() {
				Swal.fire({
					title: 'Reset Completed Point Kaget?',
					html: "Reset semua data completed point kaget <br> package : {{ $mBaseApplication->app_pkg }}",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#d33',
					cancelButtonColor: '#3085d6',
					confirmButtonText: 'Ya',
					cancelButtonText: 'Batalkan'
				}).then((result) => {
					if (result.isConfirmed) {
						var form_data = new FormData();
						form_data.append('app_pkg', "{{ $mBaseApplication->app_pkg }}");
						var csrf_token = $('meta[name="csrf-token"]').attr('content');
						Swal.fire({
							title: 'Sedang Mereset...',
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
							url: "{{ route('resetAllCompletedPointKagetFromPackage') }}",
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
								var dataTable = $('#dtQuizCompletedPointKagetPlayer').DataTable();
								dataTable.ajax.reload();
							},
							error: function(xhr, status, error) {
								Swal.fire({
									icon: "error",
									title: "Oops...",
									text: xhr.responseText
								}).then(() => {
									Swal.enableButtons();
								});
							},
							complete: function() {
								Swal.enableButtons();
							}
						});
					}
				});
			});
		});
	</script>
	@endpush
