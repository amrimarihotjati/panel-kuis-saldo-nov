@extends('layouts.app')

@section('title', 'Base Application')

@push('style')
@endpush

@section('content')
<div class="main-content">
	<div class="card rounded rounded-4 shadow">
		<div class="card-header text-dark fw-bold d-flex justify-content-between align-items-center mt-2">
			<div class="h5 fw-bold">Manage Application</div>
			<button type="button" class="btn btn-primary btn-sm fw-bold no-shadow rounded rounded-1"
			data-bs-toggle="modal" data-bs-target="#createApplication"><i class="fas fa-plus"></i></button>
		</div>
		<div class="card-body">
			<div class="table-responsive vh-100">
				<table id="dtBaseApplication" class="table table-bordered table-flush" style="width:100%">
					<thead>
						<tr>
							<th class="align-middle text-center">#</th>
							<th class="align-middle">Nama Package</th>
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

	@include('layouts/modal/create-base-application')

	<div class="modal fade" id="actionModalMenuApp" tabindex="-1" aria-labelledby="actionModalMenuAppLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title text-lowercase" id="actionModalMenuAppLabel">Config App</h6>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="list-group">
						<a href="#" id="editDataAppLink" class="list-group-item list-group-item-action p-3"><i class="fa fa-edit me-2"></i> Edit Data App</a>
						<a href="#" id="configAdLink" class="list-group-item list-group-item-action p-3"><i class="fa fa-ad me-2"></i> Config Ad</a>
						<hr>
						<a href="#" id="completedQuizLink" class="list-group-item list-group-item-action p-3"><i class="fa fa-check-circle me-2"></i> Completed Quiz</a>
						<a href="#" id="completedArticlePointLink" class="list-group-item list-group-item-action p-3"><i class="fa fa-check-circle me-2"></i> Completed Article Point</a>
						<a href="#" id="completedPointKagetLink" class="list-group-item list-group-item-action p-3"><i class="fa fa-check-circle me-2"></i> Completed Point Kaget</a>
						<hr>
						<a href="#" id="collectedPointLink" class="list-group-item list-group-item-action p-3"><i class="fa fa-coins me-2"></i> Collected Point</a>
						<a href="#" id="collectedRewardsLink" class="list-group-item list-group-item-action p-3"><i class="fa fa-trophy me-2"></i> Collected Point Kaget</a>
						<hr>
						<a href="#" id="historyReferralLink" class="list-group-item list-group-item-action p-3"><i class="fa fa-users me-2"></i> History Refferal</a>
						<a href="#" id="historyQuizLink" class="list-group-item list-group-item-action p-3"><i class="fa fa-question-circle me-2"></i> History Quiz</a>
						<a href="#" id="historyWithdrawLink" class="list-group-item list-group-item-action p-3"><i class="fa fa-wallet me-2"></i> History Withdraw</a>
						<a href="#" id="historyExchangeBadgeLink" class="list-group-item list-group-item-action p-3"><i class="fa fa-exchange-alt me-2"></i> History Exchange Badge</a>
						<hr>
						<a href="#" id="pantauPlayerLink" class="list-group-item list-group-item-action p-3"><i class="fa fa-eye me-2"></i> Pantau Player</a>
						<a href="#" id="listPlayerLink" class="list-group-item list-group-item-action p-3"><i class="fa fa-list me-2"></i> List Player</a>
						<a href="#" id="watchListPlayerLink" class="list-group-item list-group-item-action p-3"><i class="fa fa-binoculars me-2"></i> WatchList Player</a>
					</div>
				</div>
				<div class="modal-footer">
				</div>
			</div>
		</div>
	</div>

</div>
@endsection

@push('scripts')
<script type="text/javascript">
    // Fungsi untuk mengatur link pada modal saat tombol diklik
    function setModalLinks(id, packageName) {
    	document.getElementById('actionModalMenuAppLabel').textContent = packageName;
        document.getElementById('editDataAppLink').href = '/base-application/goEditData/' + id;
        document.getElementById('configAdLink').href = '/base-application/goEditConfigAd/' + id;
        document.getElementById('completedQuizLink').href = '/base-application/goCompletedQuiz/' + id;
        document.getElementById('completedArticlePointLink').href = '/base-application/goCompletedArticlePoint/' + id;
        document.getElementById('completedPointKagetLink').href = '/base-application/goCompletedPointKaget/' + id;
        document.getElementById('collectedPointLink').href = '/base-application/goCollectedPoint/' + id;
        document.getElementById('collectedRewardsLink').href = '/base-application/goHistoryCollectedRewardsAdPoint/' + id;
        document.getElementById('historyReferralLink').href = '/base-application/goHistoryRefferal/' + id;
        document.getElementById('historyQuizLink').href = '/base-application/goHistoryQuiz/' + id;
        document.getElementById('historyWithdrawLink').href = '/base-application/goHistoryWithdraw/' + id;
        document.getElementById('historyExchangeBadgeLink').href = '/base-application/goHistoryExchangeBadgePlayer/' + id;
        document.getElementById('pantauPlayerLink').href = '/base-application/goPantauPlayer/' + id;
        document.getElementById('listPlayerLink').href = '/base-application/goListPlayer/' + id;
        document.getElementById('watchListPlayerLink').href = '/base-application/goWatchListPlayer/' + id;
    }

    // Tunggu sampai dokumen siap
    $(document).ready(function() {
        // Inisialisasi DataTable
        $('#dtBaseApplication').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('list-baseapplication') }}",
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
                    data: 'app_pkg',
                    name: 'app_pkg',
                    className: 'align-middle',
                    render: function(data, type, full, meta) {
                        return '<div class="d-flex align-items-center">' +
                               '<img src="/img/android.png" alt="image" class="" style="width:25px;height:25px; margin-right: 10px;">' +
                               '<div>' +
                               '<strong>' + full.app_pkg + '</strong>' +
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
                    className: 'align-middle text-center',
                    render: function(data, type, full, meta) {
                        return `
                            <div class="m-2">
                                <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#actionModalMenuApp" onclick="setModalLinks('${full.id}', '${full.app_pkg}')">
                                    <i class="fa fa-cog"></i>
                                </button>
                            </div>`;
                    }
                }
            ],
            language: {
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Lanjut",
                    previous: "Kembali"
                },
                emptyTable: "Tidak Ada data",
                info: "_START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Dari 0 sampai 0 of 0 data",
                infoFiltered: "(Disaring dari _MAX_ total data)",
                lengthMenu: "_MENU_<br/></br/>",
                search: "",
                zeroRecords: "Tidak ditemukan"
            },
            initComplete: function(settings, json) {
                // Aksi lain yang diperlukan saat inisialisasi DataTable selesai
            }
        });
    });
</script>

@endpush