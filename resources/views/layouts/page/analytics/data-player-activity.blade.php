@extends('layouts.app')

@section('title', 'Analytics Player Kuis')

@section('content')
    <div class="main-content">

        <div class="card rounded rounded-4 shadow">
            <div class="card-header text-center opacity-50">
                <div class="h5 fw-bold card-title text-dark mt-3 ms-1 mb-0 text-center" id="title">AKTIVITAS KUIS</div>
            </div>
            <div class="card-body pt-2">
                <div class="row">
                    <div class="col-md-5">
                        <select class="form-control form-select" id="baseApplicationSelect" name="base_application_id">
                            <option selected disabled class="fw-bold">Pilih aplikasi</option>
                            @foreach ($mBaseApplication as $application)
                                <option value="{{ $application->id }}">{{ $application->app_pkg }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <div id="reportrange"
                                class="form-control d-flex justify-content-between align-items-center text-center"
                                style="cursor: pointer; padding: 5px 10px;">
                                <i class="fa fa-calendar fa-xs"></i>&nbsp;
                                <small>Pilih tanggal</small>
                                <i class="fa fa-caret-down fa-xs"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div
                            class="form-control bg-transparent border-none d-flex justify-content-between align-items-center">
                            <button class="btn shadow-none w-100 text-primary fw-bolder"
                                id="initDataAnalyctics">LOAD</button>
                        </div>
                    </div>

                </div>
                <div class="table-responsive">
                    <table id="dtAnalyticsHistoryQuizActivity" class="table table-bordered table-flush table-hover d-none"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="align-middle text-center">#</th>
                                <th class="align-middle">Player</th>
                                <th class="align-middle">Total Bermain</th>
                                <th class="align-middle text-center">Point Didapat</th>
                                <th class="align-middle text-center">Ad Interstitial</th>
                                <th class="align-middle text-center">Ad Rewards</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script type="module">
        var labels = [];
        var dataPoints = [];
        var chart = null;

        function initializeAnalyticsTableWithoutChart(appPackage, startDate, endDate) {
            $(document).ready(function() {
                $('#dtAnalyticsHistoryQuizActivity').removeClass('d-none');

                if ($.fn.DataTable.isDataTable('#dtAnalyticsHistoryQuizActivity')) {
                    $('#dtAnalyticsHistoryQuizActivity').DataTable().destroy();
                }

                var baseUrl = '/analytics-data/player-activity/' + appPackage + '/' + startDate + '/' + endDate;

                var table = $('#dtAnalyticsHistoryQuizActivity').DataTable({
                    processing: true,
                    serverSide: true,
                    paging: true,
                    ajax: baseUrl,
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
                            orderable: false,
                            className: 'align-middle',
                            render: function(data, type, full, meta) {
                                var fromPlayer = full.player;
                                var imageUrl = fromPlayer && fromPlayer.image_url ? fromPlayer
                                    .image_url : '/img/default_avatar.png';
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
                            data: 'total_bermain_kuis',
                            name: 'total_bermain_kuis',
                            searchable: false,
                            className: 'align-middle text-center',
                            render: function(data, type, full, meta) {
                                return '<span class="fw-bold text-success">' + full
                                    .total_bermain_kuis +
                                    ' kali</span>';
                            }
                        },
                        {
                            data: 'total_point_collected',
                            name: 'total_point_collected',
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
                                    `${svgIcon} ${formatter.format(full.total_point_collected)}` +
                                    '</span>';
                            }
                        },
                        {
                            data: 'total_ads_inters',
                            name: 'total_ads_inters',
                            searchable: false,
                            className: 'align-middle text-center',
                            render: function(data, type, full, meta) {
                                var formatter = new Intl.NumberFormat('id-ID', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                });
                                return '<span class="fw-semibold">' +
                                    `${formatter.format(full.total_ads_inters)}` +
                                    ' Dilihat</span>';
                            }
                        },
                        {
                            data: 'total_ads_rewards',
                            name: 'total_ads_rewards',
                            searchable: false,
                            className: 'align-middle text-center',
                            render: function(data, type, full, meta) {
                                var formatter = new Intl.NumberFormat('id-ID', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                });
                                return '<span class="fw-semibold">' +
                                    `${formatter.format(full.total_ads_rewards)}` +
                                    ' Dilihat</span>';
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
                    initComplete: function(settings, json) {}
                });
            });
        }

        $('#initDataAnalyctics').on('click', function() {
            var appPackage = $('#baseApplicationSelect').find(':selected').text();
            var appId = $('#baseApplicationSelect').val();

            var dateRangeText = $('#reportrange small').text();
            var dates = dateRangeText.split(' - ');
            var startDate = dates[0];
            var endDate = dates[1];

            if (appId && startDate && endDate) {
                initializeAnalyticsTableWithoutChart(appPackage, startDate, endDate);
            } else {
                iziToast.show({
                    title: 'Pilih dahulu aplikasi',
                    timeout: 1200,
                    position: 'topRight'
                });
            }
        });

        $(function() {
            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#reportrange small').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                alwaysShowCalendars: true,
                showDropdowns: true,
                maxYear: parseInt(moment().format('YYYY'), 10),
                ranges: {
                    'Hari Ini': [moment(), moment()],
                    'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                    '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                    'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                    'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')],
                    'Tahun Ini': [moment().startOf('year'), moment()]
                },
                opens: 'center'
            }, cb);

            cb(start, end);
        });
    </script>
@endpush
