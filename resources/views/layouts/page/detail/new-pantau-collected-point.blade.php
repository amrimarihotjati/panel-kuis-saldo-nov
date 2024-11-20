@extends('layouts.app')

@section('title', 'Pantau Collected Point Player')

@push('style')
@endpush

@section('content')
    <div class="main-content">
        <div class="card rounded rounded-4 shadow p-2">
            <div class="container text-center align-middle">
                <h4 class="text-center m-4 text-primary">Pantau Collected Player</h4>
                <div class="row ms-1 me-1">
                    <div class="col-md-3">
                        <div class="card shadow-none border rounded-2">
                            <div class="card-body">
                                <h6 class="card-title text-muted mb-0">Current Point</h6>
                                <p class="h5 card-text fw-bold mt-0" id="valueHeadPlayerPoint">{{ $mPlayer->points }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card shadow-none border rounded-2">
                            <div class="card-body">
                                <h6 class="card-title text-muted mb-0">Point Collected</h6>
                                <p class="h5 card-text fw-bold mt-0" id="valueHeadPlayerTotalPoint">
                                    {{ $mPlayer->points_collected }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card shadow-none border rounded-2">
                            <div class="card-body">
                                <h6 class="card-title text-muted mb-0">Total Ammount WD</h6>
                                <p class="h5 card-text fw-bold mt-0" id="valueHeadTotalAmmountWd">memuat</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card shadow-none border rounded-2">
                            <div class="card-body">
                                <h6 class="card-title text-muted mb-0">Total Point WD</h6>
                                <p class="h5 card-text fw-bold mt-0" id="valueHeadTotalPointWd">memuat</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card shadow-none border rounded-2">
                            <div class="card-body">
                                <h6 class="card-title text-muted mb-0">Withdraw</h6>
                                <p class="h5 card-text fw-bold mt-0" id="valueHeadTotalCountWd">memuat</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card shadow-none border rounded-2">
                            <div class="card-body">
                                <h6 class="card-title text-muted mb-0">Wd Pending</h6>
                                <p class="h5 card-text fw-bold mt-0" id="valueHeadPendingWd">memuat</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card shadow-none border rounded-2">
                            <div class="card-body">
                                <h6 class="card-title text-muted mb-0">Wd Disetujui</h6>
                                <p class="h5 card-text fw-bold mt-0" id="valueHeadAcceptedWd">memuat</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card shadow-none border rounded-2">
                            <div class="card-body">
                                <h6 class="card-title text-muted mb-0">Wd Ditolak</h6>
                                <p class="h5 card-text fw-bold mt-0" id="valueHeadDeniedWd">memuat</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <nav>
                    <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                        <button class="nav-link fw-semibold h4 active" id="nav-collected-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-collected" type="button" role="tab" aria-controls="nav-collected"
                            aria-selected="true">Collected</button>
                        <button class="nav-link fw-semibold h4" id="nav-tempads-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-tempads" type="button" role="tab" aria-controls="nav-tempads"
                            aria-selected="true">Ads Watched</button>
                        <button class="nav-link fw-semibold h4" id="nav-history-quiz-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-history-quiz" type="button" role="tab"
                            aria-controls="nav-question-quiz" aria-selected="true">History Quiz</button>
                        <button class="nav-link fw-semibold h4" id="nav-question-quiz-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-question-quiz" type="button" role="tab"
                            aria-controls="nav-question-quiz" aria-selected="true">Quiz Completed</button>
                        <button class="nav-link fw-semibold h4" id="nav-statistic-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-statistic" type="button" role="tab" aria-controls="nav-statistic"
                            aria-selected="true">Statistic</button>
                    </div>
                </nav>
                <div class="tab-content p-2 border" id="nav-tabContent">
                    <div class="tab-pane fade active show" id="nav-collected" role="tabpanel"
                        aria-labelledby="nav-collected-tab">
                        <div class="table-responsive">
                            <table id="dtHistoryCollectedPointPlayer" class="table table-bordered table-light"
                                style="width:100%">
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


                    <div class="tab-pane fade" id="nav-tempads" role="tabpanel" aria-labelledby="nav-tempads-tab">
                        <div class="text-dark fw-bold d-flex justify-content-between align-items-center mt-2 p-3">
                            <div class="h5 fw-bold text-muted ms-1">Statistik Ads</div>
                            <div class="h5 fw-bold">
                                <button type="button"
                                    class="btn btn-danger btn-sm fw-bold shadow-none rounded rounded-1 mb-1"
                                    id="resetStatistcsAds"><i class="fas fa-sync-alt fa-sm"></i> RESET DATA</button>
                            </div>
                        </div>

                        <div class="row ms-1 me-1">
                            <div class="col-md-4">
                                <div class="card shadow-none border rounded-2">
                                    <div class="card-body">
                                        <h6 class="card-title text-success mb-0">Total Iklan Dilihat</h6>
                                        <p class="h5 card-text fw-bold mt-0 text-muted" id="valueAdsCounterTotal">
                                            Memuat...</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card shadow-none border rounded-2">
                                    <div class="card-body">
                                        <h6 class="card-title text-warning mb-0">Interstital Dilihat</h6>
                                        <p class="h5 card-text fw-bold mt-0 text-muted" id="valueAdsCounterInters">
                                            Memuat...</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card shadow-none border rounded-2">
                                    <div class="card-body">
                                        <h6 class="card-title text-warning mb-0">Rewards Dilihat</h6>
                                        <p class="h5 card-text fw-bold mt-0 text-muted" id="valueAdsCounterRewards">
                                            Memuat...</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="dtAdsCounterTemporary" class="table table-bordered table-light"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="align-middle text-center">#</th>
                                        <th class="align-middle">Player</th>
                                        <th class="align-middle">Description</th>
                                        <th class="align-middle">Ad Inters</th>
                                        <th class="align-middle">Ad Rewards</th>
                                        <th class="align-middle">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-history-quiz" role="tabpanel"
                        aria-labelledby="nav-history-quiz-tab">
                        <div class="text-dark fw-bold d-flex justify-content-between align-items-center mt-2 p-3">
                            <div class="h5 fw-bold text-muted ms-1">History Quiz</div>
                        </div>

                        <div class="row ms-1 me-1">
                            <div class="col-md-6">
                                <div class="card shadow-none border rounded-2">
                                    <div class="card-body">
                                        <h6 class="card-title text-success mb-0">Valid</h6>
                                        <p class="h5 card-text fw-bold mt-0 text-muted" id="valueHistoryQuizValid">Memuat...
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card shadow-none border rounded-2">
                                    <div class="card-body">
                                        <h6 class="card-title text-danger mb-0">Invalid</h6>
                                        <p class="h5 card-text fw-bold mt-0 text-muted" id="valueHistoryQuizInvalid">
                                            Memuat...</p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="table-responsive">
                            <table id="dtStatHistoryQuiz" class="table table-bordered table-light" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="align-middle text-center">#</th>
                                        <th class="align-middle">Player</th>
                                        <th class="align-middle">Category</th>
                                        <th class="align-middle">Level</th>
                                        <th class="align-middle">Point Ganda</th>
                                        <th class="align-middle">Point Kuis</th>   
                                        <th class="align-middle">Hasil Ganda</th>
                                        <th class="align-middle">Point Diraih</th>
                                        <th class="align-middle">Status</th>
                                        <th class="align-middle">Keterangan</th>
                                        <th class="align-middle">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-question-quiz" role="tabpanel"
                        aria-labelledby="nav-question-quiz-tab">
                        <div class="text-dark fw-bold d-flex justify-content-between align-items-center mt-2 p-3">
                            <div class="h5 fw-bold text-muted ms-1">Quiz Completed</div>
                            <div class="h5 fw-bold">
                                <button type="button"
                                    class="btn btn-danger btn-sm fw-bold shadow-none rounded rounded-1 mb-1"
                                    id="resetStatisticsQuizCompleted"><i class="fas fa-sync-alt fa-sm"></i> RESET
                                    DATA</button>
                            </div>
                        </div>

                        <div class="row ms-1 me-1">
                            <div class="col-md-6">
                                <div class="card shadow-none border rounded-2">
                                    <div class="card-body">
                                        <h6 class="card-title text-primary mb-0">Total Kuis Selesai</h6>
                                        <p class="h5 card-text fw-bold mt-0 text-muted" id="valueQuizCompleted">Memuat...
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card shadow-none border rounded-2">
                                    <div class="card-body">
                                        <h6 class="card-title text-primary mb-0">Total Kuis Belum</h6>
                                        <p class="h5 card-text fw-bold mt-0 text-muted" id="valueQuizNotCompleted">
                                            Memuat...</p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="table-responsive">
                            <table id="dtStatQuizCompleted" class="table table-bordered table-light" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="align-middle text-center">#</th>
                                        <th class="align-middle">Player</th>
                                        <th class="align-middle">Category</th>
                                        <th class="align-middle">Level</th>
                                        <th class="align-middle">Status</th>
                                        <th class="align-middle">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="tab-pane fade" id="nav-statistic" role="tabpanel" aria-labelledby="nav-statistic-tab">
                        <div class="row mt-4 ms-1 me-1">
                            <div class="col-md-3 text-center p-2">
                                <div class="card shadow-none">
                                    <div class="card-body p-0 text-start">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <small class="text-primary fw-bold">Player App :</small><br>
                                                <span class="text-dark">{{ $mPlayer->player_pkg }}</span>
                                            </li>
                                            <li class="list-group-item">
                                                <small class="text-primary fw-bold">Email :</small><br>
                                                <span class="text-dark">{{ $mPlayer->email }}</span>
                                            </li>
                                            <li class="list-group-item">
                                                <small class="text-primary fw-bold">Current Point :</small><br>
                                                <span class="text-dark">{{ $mPlayer->points }}</span>
                                            </li>
                                            <li class="list-group-item">
                                                <small class="text-primary fw-bold">Total Point Collected :</small><br>
                                                <span class="text-dark">{{ $mPlayer->points_collected }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 text-center p-2">
                                <div class="card shadow-none">
                                    <div class="card-body p-0 text-start">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <small class="text-primary fw-bold">Total Ad Inters :</small><br>
                                                <span class="text-dark text-muted" id="valueAdInters">Sedang
                                                    menghitung...</span>
                                            </li>
                                            <li class="list-group-item">
                                                <small class="text-primary fw-bold">Total Ad Rewards :</small><br>
                                                <span class="text-dark text-dark text-muted" id="valueAdRewards">Sedang
                                                    menghitung...</span>
                                            </li>
                                            <li class="list-group-item">
                                                <small class="text-primary fw-bold">Completed Quiz :</small><br>
                                                <span class="text-dark text-dark text-muted"
                                                    id="valueCompletedQuiz">Sedang
                                                    menghitung...</span>
                                            </li>
                                            <li class="list-group-item">
                                                <small class="text-primary fw-bold">Completed Point Kaget :</small><br>
                                                <span class="text-dark text-dark text-muted"
                                                    id="valueCompletedPointKaget">Sedang menghitung...</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 text-center p-2">
                                <div class="card shadow-none">
                                    <div class="card-body p-0 text-start">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <small class="text-primary fw-bold">WD Pending :</small><br>
                                                <span class="text-dark text-dark text-muted" id="valueWdPending">Sedang
                                                    menghitung...</span>
                                            </li>
                                            <li class="list-group-item">
                                                <small class="text-primary fw-bold">WD Disetujui :</small><br>
                                                <span class="text-dark text-dark text-muted" id="valueWdAccepted">Sedang
                                                    menghitung...</span>
                                            </li>
                                            <li class="list-group-item">
                                                <small class="text-primary fw-bold">WD Ditolak :</small><br>
                                                <span class="text-dark text-dark text-muted" id="valueWdDenied">Sedang
                                                    menghitung...</span>
                                                <br>
                                                <small class="text-primary fw-bold">Catatan WD terakhir :</small><br>
                                                <span class="text-dark text-dark text-muted"
                                                    id="valueLastMessageDenied">Sedang memuat...</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 text-center p-2">
                                <div class="card shadow-none">
                                    <div class="card-body p-0 text-start">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <small class="text-primary fw-bold">Semua WD :</small><br>
                                                <span class="text-dark text-dark text-muted" id="valueTotalCountWd">Sedang
                                                    menghitung...</span>
                                            </li>
                                            <li class="list-group-item">
                                                <small class="text-primary fw-bold">Total Ammount WD :</small><br>
                                                <span class="text-dark text-dark text-muted"
                                                    id="valueTotalAmmountWd">Sedang menghitung...</span>
                                            </li>
                                            <li class="list-group-item">
                                                <small class="text-primary fw-bold">Total Point WD :</small><br>
                                                <span class="text-dark text-dark text-muted" id="valueTotalPointWd">Sedang
                                                    menghitung...</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script type="module">
            $('#dtHistoryCollectedPointPlayer').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: "{{ route('getDTPantauPrivateCollectedPointPlayer', $mPlayer->id) }}",
                aLengthMenu: [
                    [50, 100, 1000, 10000, -1],
                    [50, 100, 1000, 10000, "Semua"]
                ],
                iDisplayLength: 50,
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
                        data: 'player.name',
                        name: 'player.name',
                        className: 'align-middle',
                        render: function(data, type, full, meta) {
                            var fromPlayer = full.player;
                            var imageUrl = fromPlayer && fromPlayer.image_url ? fromPlayer.image_url :
                                '/img/default_avatar.png';
                            var playerName = fromPlayer ? fromPlayer.name : 'Unknown';
                            var playerEmail = fromPlayer ? fromPlayer.email : 'Unknown';

                            return '<div class="d-flex align-items-center align-middle">' +
                                '<img src="' + imageUrl +
                                '" alt="" class="avatar border border-secondary border-3" style="width:35px;height:35px; margin-right: 10px;">' +
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
                            var svgIcon =
                                `<img src="${svgIconPath}" height="15px" width="15px" style="vertical-align: middle;margin-bottom:4px;margin-right:2px">`;
                            return '<span class="fw-semibold">' +
                                `${svgIcon} ${formatter.format(full.point_collected_value)}` + '</span>';
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
                            var value = full.ads_watched_inters_is_exist !== null ? full
                                .ads_watched_inters_is_exist : '0';
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
                            var value = full.ads_watched_rewards_is_exist !== null ? full
                                .ads_watched_rewards_is_exist : '0';
                            return '<small class="fw-bold">' + value + ' ADS</small>';
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        searchable: false,
                        orderable: true,
                        className: 'align-middle text-center',
                        render: function(data, type, full, meta) {
                            return '<span class="fw-bold text-muted">' + full.created_at + '</span>';
                        }
                    }
                ],
                order: [
                    [7, 'desc']
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
                    "lengthMenu": "Tampilkan data : _MENU_<br/></br/>",
                    "search": "<b>Cari ID, Nama atau Email : </b>",
                    "zeroRecords": "Tidak ditemukan",
                },
                initComplete: function(settings, json) {}
            });
            
            $('#dtStatHistoryQuiz').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: "{{ route('getDtPantauHistoryQuiz', $mPlayer->id) }}",
                aLengthMenu: [
                    [50, 100, 1000, 10000, -1],
                    [50, 100, 1000, 10000, "Semua"]
                ],
                iDisplayLength: 50,
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
                        data: 'player.name',
                        name: 'player.name',
                        className: 'align-middle',
                        render: function(data, type, full, meta) {
                            var fromPlayer = full.player;
                            var imageUrl = fromPlayer && fromPlayer.image_url ? fromPlayer.image_url :
                                '/img/default_avatar.png';
                            var playerName = fromPlayer ? fromPlayer.name : 'Unknown';
                            var playerEmail = fromPlayer ? fromPlayer.email : 'Unknown';

                            return '<div class="d-flex align-items-center align-middle">' +
                                '<img src="' + imageUrl +
                                '" alt="" class="avatar border border-secondary border-3" style="width:35px;height:35px; margin-right: 10px;">' +
                                '<div>' +
                                '<span class="fw-bold">' + playerName + '</span></br>' +
                                '<span class="fw-semibold">' + playerEmail + '</span>' +
                                '</div>' +
                                '</div>';
                        }
                    },
                    {
                        data: 'category_quiz.category_name',
                        name: 'category_quiz.category_name',
                        searchable: false,
                        className: 'align-middle text-center',
                        render: function(data, type, full, meta) {
                            var categoryQuizzes = full.category_quiz;
                            var categoryNames = categoryQuizzes && categoryQuizzes.category_name ? categoryQuizzes.category_name : 'Unknown';
                            var categoryImage = categoryQuizzes && categoryQuizzes.category_image ? categoryQuizzes.category_image : 'https://placehold.co/400';

                            const icon = categoryImage !== 'Unknown'
                            ? `<img src="${categoryImage}" alt="" class="border border-secondary rounded border-2" style="width:30px;height:30px; margin-right: 10px;">`
                            : `<div class="placeholder-icon" style="width:40px;height:40px;margin-right:10px;background-color:#ccc;"></div>`;

                            const title = `<p class="fw-bold mb-0">${categoryNames}</p>`;
                            return `
                            <div class="d-flex align-items-center">
                            ${icon}
                            <div>${title}</div>
                            </div>
                            `;
                        }
                    },
                    {
                        data: 'category_level',
                        name: 'category_level',
                        searchable: false,
                        className: 'align-middle text-center',
                        render: function(data, type, full, meta) {
                            return '<small class="fw-bold">' + full.category_level + '</small>';
                        }
                    },
                    {
                        data: 'with_double_option',
                        name: 'with_double_option',
                        searchable: false,
                        className: 'align-middle text-center',
                        render: function(data, type, full, meta) {
                           return data === 1 ?
                           '<small class="fw-bold badge badge-sm bg-info">YA</small>' :
                           '<small class="fw-bold badge badge-sm bg-secondary">TIDAK</small>';
                        }
                    },
                    {
                        data: 'totalPointFromQuestionCategory',
                        name: 'totalPointFromQuestionCategory',
                        searchable: false,
                        className: 'align-middle text-center',
                        render: function(data, type, full, meta) {
                            var formatter = new Intl.NumberFormat('id-ID', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            });
                            var svgIconPath = '/img/points.svg';
                            var svgIcon =
                                `<img src="${svgIconPath}" height="15px" width="15px" style="vertical-align: middle;margin-bottom:4px;margin-right:2px">`;
                            return '<span class="fw-semibold">' +
                                `${svgIcon} ${formatter.format(full.totalPointFromQuestionCategory)}` + '</span>';
                        }
                    },
                    {
                        data: 'doublePoint',
                        name: 'doublePoint',
                        searchable: false,
                        className: 'align-middle text-center',
                        render: function(data, type, full, meta) {
                           var formatter = new Intl.NumberFormat('id-ID', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            });
                            var svgIconPath = '/img/points.svg';
                            var svgIcon =
                                `<img src="${svgIconPath}" height="15px" width="15px" style="vertical-align: middle;margin-bottom:4px;margin-right:2px">`;
                            return '<span class="fw-semibold">' +
                                `${svgIcon} ${formatter.format(full.doublePoint)}` + '</span>';
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
                            var svgIcon =
                                `<img src="${svgIconPath}" height="15px" width="15px" style="vertical-align: middle;margin-bottom:4px;margin-right:2px">`;
                            return '<span class="fw-semibold">' +
                                `${svgIcon} ${formatter.format(full.points)}` + '</span>';
                        }
                    },
                    {
                        data: null,
                        searchable: false,
                        className: 'align-middle text-center',
                        render: function(data, type, full, meta) {
                            var status;
                            var isWithDouble = full.with_double_option;
                            if (isWithDouble == 1) {
                                if (full.points > (full.totalPointFromQuestionCategory + 300)) {
                                    status = '<small class="fw-bold badge badge-sm bg-danger">INVALID</small>';
                                } else {
                                    status = '<small class="fw-bold badge badge-sm bg-success">VALID</small>';
                                }
                            } else {
                                if (full.points == full.totalPointFromQuestionCategory) {
                                    status = '<small class="fw-bold badge badge-sm bg-success">VALID</small>';
                                } else if (full.points > full.totalPointFromQuestionCategory) {
                                    status = '<small class="fw-bold badge badge-sm bg-danger">INVALID</small>';
                                } else {
                                    status = '<small class="fw-bold badge badge-sm bg-success">VALID</small>';
                                }
                            }
                            return status;
                        }
                    },
                    {
                        data: null,
                        searchable: false,
                        className: 'align-middle',
                        render: function(data, type, full, meta) {
                           var status;
                            var isWithDouble = full.with_double_option;
                            if (isWithDouble == 1) {
                                if (full.points > full.totalPointFromQuestionCategory) {
                                    status = '<small class="text-primary">Hasil valid menunjukkan <b>tidak ada kecurangan</b></small>. <small>Selain valid, butuh perhatian lebih lanjut.</small>';
                                } else if (full.points > (full.totalPointFromQuestionCategory + 500)) {
                                    status = '<small class="text-primary">Hasil invalid menunjukkan <b>ada indikasi kecurangan</b></small>';
                                } else {
                                    status = '<small class="text-primary">Hasil valid menunjukkan <b>tidak ada kecurangan</b></small>. <small>Selain valid, butuh perhatian lebih lanjut.</small>';
                                }
                            } else {
                                if (full.points == full.totalPointFromQuestionCategory) {
                                    status = '<small class="text-primary">Hasil valid menunjukkan <b>tidak ada kecurangan</b></small>. <small>Selain valid, butuh perhatian lebih lanjut.</small>';
                                } else if (full.points > full.totalPointFromQuestionCategory) {
                                    status = '<small class="text-primary">Hasil invalid menunjukkan <b>ada indikasi kecurangan</b></small>';
                                } else {
                                   status = '<small class="text-primary">Hasil valid menunjukkan <b>tidak ada kecurangan</b></small>. <small>Selain valid, butuh perhatian lebih lanjut.</small>';
                                }
                            }
                            return status;
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        searchable: false,
                        orderable: true,
                        className: 'align-middle text-center',
                        render: function(data, type, full, meta) {
                            return '<span class="fw-bold text-muted">' + full.created_at + '</span>';
                        }
                    }
                ],
                order: [
                    [10, 'desc']
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
                    "lengthMenu": "Tampilkan data : _MENU_<br/></br/>",
                    "search": "<b>Cari ID, Nama atau Email : </b>",
                    "zeroRecords": "Tidak ditemukan",
                },
                initComplete: function(settings, json) {
                    let validCount = 0;
                    let invalidCount = 0;
                    this.api().data().each(function(data) {
                        let withDoubleOption = data.with_double_option;
                        if (withDoubleOption == 1) {
                            if (data.points > (data.totalPointFromQuestionCategory + 300)) {
                                invalidCount++;
                            } else {
                                validCount++;
                            }
                        } else {
                            if (data.points <= data.totalPointFromQuestionCategory) {
                                validCount++;
                            } else if (data.points > data.totalPointFromQuestionCategory) {
                                invalidCount++;
                            } else {
                                validCount++;
                            }
                        }
                    });
                    $('#valueHistoryQuizValid').text(validCount);
                    $('#valueHistoryQuizInvalid').text(invalidCount);
                }
            });

            $('#dtAdsCounterTemporary').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: "{{ route('getDTAdsCounterTemporary', $mPlayer->id) }}",
                aLengthMenu: [
                    [50, 100, 1000, 10000, -1],
                    [50, 100, 1000, 10000, "Semua"]
                ],
                iDisplayLength: 50,
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
                        data: 'player.name',
                        name: 'player.name',
                        className: 'align-middle',
                        render: function(data, type, full, meta) {
                            var fromPlayer = full.player;
                            var imageUrl = fromPlayer && fromPlayer.image_url ? fromPlayer.image_url :
                                '/img/default_avatar.png';
                            var playerName = fromPlayer ? fromPlayer.name : 'Unknown';
                            var playerEmail = fromPlayer ? fromPlayer.email : 'Unknown';

                            return '<div class="d-flex align-items-center align-middle">' +
                                '<img src="' + imageUrl +
                                '" alt="" class="avatar border border-secondary border-3" style="width:35px;height:35px; margin-right: 10px;">' +
                                '<div>' +
                                '<span class="fw-bold">' + playerName + '</span></br>' +
                                '<span class="fw-semibold">' + playerEmail + '</span>' +
                                '</div>' +
                                '</div>';
                        }
                    },
                    {
                        data: 'description',
                        name: 'description',
                        searchable: false,
                        className: 'align-middle',
                        render: function(data, type, full, meta) {
                            return '<small class="fw-bold">' + full.description + '</small>';
                        }
                    },
                    {
                        data: 'ads_watched_inters',
                        name: 'ads_watched_inters',
                        searchable: false,
                        orderable: false,
                        className: 'align-middle text-center',
                        render: function(data, type, full, meta) {
                            var value = full.ads_watched_inters !== null ? full
                                .ads_watched_inters : '0';
                            return '<small class="fw-bold">' + value + ' ADS</small>';
                        }
                    },
                    {
                        data: 'ads_watched_rewards',
                        name: 'ads_watched_rewards',
                        searchable: false,
                        orderable: false,
                        className: 'align-middle text-center',
                        render: function(data, type, full, meta) {
                            var value = full.ads_watched_rewards !== null ? full
                                .ads_watched_rewards : '0';
                            return '<small class="fw-bold">' + value + ' ADS</small>';
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        searchable: false,
                        orderable: true,
                        className: 'align-middle text-center',
                        render: function(data, type, full, meta) {
                            return '<span class="fw-bold text-muted">' + full.created_at + '</span>';
                        }
                    }
                ],
                order: [
                    [5, 'desc']
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
                    "lengthMenu": "Tampilkan data : _MENU_<br/></br/>",
                    "search": "<b>Cari ID, Nama atau Email : </b>",
                    "zeroRecords": "Tidak ditemukan",
                },
                initComplete: function(settings, json) {}
            });

            reloadStatistikAds();

            function formatRupiah(amount) {
                return parseInt(amount).toLocaleString('id-ID', {
                    minimumFractionDigits: 0
                }).replace('IDR', '').trim();
            }

            function reloadStatistikAds() {
                $.ajax({
                    url: '/statistic-player/' + {{ $mPlayer->id }},
                    method: 'GET',
                    success: function(response) {
                        $('#valueAdInters').removeClass('text-muted').addClass('text-dark').text(response
                            .ad_inters_count || '0');
                        $('#valueAdRewards').removeClass('text-muted').addClass('text-dark').text(response
                            .ad_rewards_count || '0');

                        $('#valueCompletedQuiz').removeClass('text-muted').addClass('text-dark').text(response
                            .quiz_participation || '0');
                        $('#valueCompletedPointKaget').removeClass('text-muted').addClass('text-dark').text(response
                            .collected_rewards_ad_point || '0');

                        $('#valueWdPending').removeClass('text-muted').addClass('text-dark').text(response
                            .withdrawal
                            .pending || '0');
                        $('#valueHeadPendingWd').removeClass('text-muted').text(response.withdrawal
                            .pending || '0');

                        $('#valueWdAccepted').removeClass('text-muted').addClass('text-dark').text(response
                            .withdrawal
                            .accepted || '0');
                        $('#valueHeadAcceptedWd').removeClass('text-muted').text(response.withdrawal
                            .accepted || '0');

                        $('#valueWdDenied').removeClass('text-muted').addClass('text-dark').text(response.withdrawal
                            .denied || '0');
                        $('#valueHeadDeniedWd').removeClass('text-muted').text(response.withdrawal
                            .denied || '0');

                        let valueHeadPlayerPoint = formatRupiah($('#valueHeadPlayerPoint').text() || '0');
                        let valueHeadPlayerTotalPoint = formatRupiah($('#valueHeadPlayerTotalPoint').text() || '0');
                        $('#valueHeadPlayerPoint').text(valueHeadPlayerPoint);
                        $('#valueHeadPlayerTotalPoint').text(valueHeadPlayerTotalPoint);

                        $('#valueHeadTotalAmmountWd').text(formatRupiah(
                            response.withdrawal.total_amount || '0'));
                        $('#valueHeadTotalPointWd').text(formatRupiah(
                            response.withdrawal.total_points || '0'));


                        $('#valueTotalCountWd').removeClass('text-muted').addClass('text-dark').text(formatRupiah(
                            response.withdrawal.count || '0') + ' Kali');
                        $('#valueHeadTotalCountWd').text(formatRupiah(
                            response.withdrawal.count || '0'));

                        $('#valueTotalAmmountWd').removeClass('text-muted').addClass('text-dark').text(formatRupiah(
                            response.withdrawal.total_amount || '0'));
                        $('#valueTotalPointWd').removeClass('text-muted').addClass('text-dark').text(formatRupiah(
                            response.withdrawal.total_points || '0'));
                        $('#valueLastMessageDenied').removeClass('text-muted').addClass('text-dark').text(response
                            .withdrawal.last_denied_message || 'Tidak ada catatan');

                    },
                    error: function(xhr, status, error) {}
                });

                $.ajax({
                    url: '/ads-statistic-player/' + {{ $mPlayer->id }},
                    method: 'GET',
                    success: function(response) {
                        $('#valueAdsCounterTotal').removeClass('text-muted').text(formatRupiah(
                            response.ads_watched_totals || '0'));
                        $('#valueAdsCounterInters').removeClass('text-muted').text(formatRupiah(
                            response.ads_watched_inters || '0'));
                        $('#valueAdsCounterRewards').removeClass('text-muted').text(formatRupiah(
                            response.ads_watched_rewards || '0'));
                    },
                    error: function(xhr, status, error) {}
                });
            }

            $(document).ready(function() {
                $('#resetStatistcsAds').on('click', function() {
                    Swal.fire({
                        title: 'Reset statistic ads?',
                        html: "Reset semua data ads sementara player<br> <strong> {{ $mPlayer->name }} </strong>",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Batalkan'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var form_data = new FormData();
                            form_data.append('player_id', "{{ $mPlayer->id }}");
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
                                url: "{{ route('resetAllDataTemporaryAds') }}",
                                type: "POST",
                                dataType: 'json',
                                headers: {
                                    'X-CSRF-TOKEN': csrf_token
                                },
                                xhr: function() {
                                    var xhr = new window.XMLHttpRequest();
                                    xhr.upload.addEventListener("progress", function(evt) {
                                        if (evt.lengthComputable) {
                                            var percentComplete = (evt.loaded / evt
                                                .total) * 100;
                                            Swal.getHtmlContainer().querySelector(
                                                    '.swal2-progress-bar')
                                                .style.width = percentComplete +
                                                '%';
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
                                    var dataTable = $('#dtAdsCounterTemporary').DataTable();
                                    dataTable.ajax.reload();
                                    reloadStatistikAds();
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

            $(document).ready(function() {
                $('#resetStatisticsQuizCompleted').on('click', function() {
                    Swal.fire({
                        title: 'Reset Completed Quiz?',
                        html: "Reset semua data QuizCompleted player<br> <strong> {{ $mPlayer->name }} </strong>",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Batalkan'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var form_data = new FormData();
                            form_data.append('player_id', "{{ $mPlayer->id }}");
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
                                url: "{{ route('resetAllCompletedQuizFromPlayer') }}",
                                type: "POST",
                                dataType: 'json',
                                headers: {
                                    'X-CSRF-TOKEN': csrf_token
                                },
                                xhr: function() {
                                    var xhr = new window.XMLHttpRequest();
                                    xhr.upload.addEventListener("progress", function(evt) {
                                        if (evt.lengthComputable) {
                                            var percentComplete = (evt.loaded / evt
                                                .total) * 100;
                                            Swal.getHtmlContainer().querySelector(
                                                    '.swal2-progress-bar')
                                                .style.width = percentComplete +
                                                '%';
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
                                    initDataTableQuizCompleted();
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

            $(document).ready(function() {
                const initDataTableQuizCompleted = () => {
                    $('#dtStatQuizCompleted').DataTable({
                        processing: true,
                        serverSide: true,
                        searching: false,
                        ajax: {
                            url: '{{ route('getDataQuizCompletedStatistic', $mPlayer->id) }}',
                            type: 'GET',
                            dataSrc: function(json) {
                                window.total_completed = json.total_completed;
                                window.total_not_completed = json.total_not_completed;
                                return json.data;
                            }
                        },
                        aLengthMenu: [
                            [-1],
                            ["Semua"]
                        ],
                        iDisplayLength: -1,
                        columns: getColumns(),
                        language: getLanguageSettings(),
                        initComplete: function(settings, json) {
                            updateTotalCounts();
                        }
                    });
                };

                const getColumns = () => {
                    return [{
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
                            render: renderPlayer
                        },
                        {
                            data: 'category',
                            name: 'category',
                            orderable: false,
                            className: 'align-middle text-center',
                            render: renderCategory
                        },
                        {
                            data: 'level',
                            name: 'level',
                            orderable: false,
                            className: 'align-middle text-center',
                            render: renderLevel
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: false,
                            className: 'align-middle text-center',
                            render: renderStatus
                        },
                        {
                            data: 'waktu',
                            name: 'waktu',
                            orderable: false,
                            className: 'align-middle text-center',
                            render: renderWaktu
                        }
                    ];
                };

                const renderPlayer = function(data, type, full, meta) {
                    var fromPlayer = full.player;
                    var imageUrl = fromPlayer && fromPlayer.image_url ? fromPlayer.image_url :
                        '/img/default_avatar.png';
                    var playerName = fromPlayer ? fromPlayer.name : 'Unknown';
                    var playerEmail = fromPlayer ? fromPlayer.email : 'Unknown';

                    return `
        <div class="d-flex align-items-center align-middle">
        <img src="${imageUrl}" alt="" class="avatar border border-secondary border-3" style="width:35px;height:35px; margin-right: 10px;">
        <div>
        <p class="fw-bold mb-0">${playerName}</p>
        <span class="fw-semibold mt-0">${playerEmail}</span>
        </div>
        </div>
        `;
                };

                const renderCategory = function(data, type, full, meta) {
                    const icon =
                        `<img src="${data.category_image}" alt="" class="border border-secondary rounded border-2" style="width:40px;height:40px; margin-right: 10px;">`;
                    const title = `<p class="fw-bold mb-0">${data.category_name}</p>`;
                    return `
        <div class="d-flex align-items-center">
        ${icon}
        <div>${title}</div>
        </div>
        `;
                };

                const renderLevel = function(data, type, row) {
                    return `<span class="fw-semibold text-sm">${data}</span>`;
                };

                const renderStatus = function(data, type, row) {
                    return data === 'SELESAI' ?
                        '<span class="fw-bold badge badge-sm bg-success">SELESAI</span>' :
                        '<span class="fw-bold badge badge-sm bg-danger">BELUM</span>';
                };

                const renderWaktu = function(data, type, row) {
                    return `<span class="fw-semibold text-sm">${data ? data : '----'}</span>`;
                };

                const getLanguageSettings = () => {
                    return {
                        "paginate": {
                            "first": "Pertama",
                            "last": "Terakhir",
                            "next": "Lanjut",
                            "previous": "Kembali"
                        },
                        "emptyTable": "Tidak Ada data",
                        "info": "",
                        "infoEmpty": "",
                        "infoFiltered": "",
                        "lengthMenu": "",
                        "search": "",
                        "zeroRecords": "Tidak ditemukan"
                    };
                };

                const updateTotalCounts = () => {
                    $('#valueQuizCompleted').removeClass('text-muted').text(formatRupiah(window.total_completed ||
                        '0'));
                    $('#valueQuizNotCompleted').removeClass('text-muted').text(formatRupiah(window
                        .total_not_completed || '0'));
                };
                initDataTableQuizCompleted();
            })
        </script>
    @endpush
