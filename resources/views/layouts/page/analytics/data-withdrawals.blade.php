@extends('layouts.app')

@section('title', 'Analytics Withdrawal')

@section('content')
    <div class="main-content">

        <div class="card rounded rounded-4 shadow p-3">
            <div class="card-header text-dark fw-bold mt-2 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="h5 fw-bold">Riwayat Withdrawal<br>&nbsp;</div>
                </div>
                <div class="text-end">
                    <span class="h5 fw-bold">Total Withdraw</span><br>
                    <div>
                        <sup class="h6 text-primary fw-semibold" id="countTotalWithdraw">Rp.0</sup>
                    </div>
                </div>
            </div>
            <div class="card-body pt-2">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="form-label">Pilih aplikasi</label>
                            @foreach ($mBaseApplication as $application)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="base_application_id[]" value="{{ $application->app_pkg }}" id="app{{ $application->id }}">
                                <label class="form-check-label" for="app{{ $application->id }}">
                                    {{ $application->app_pkg }}
                                </label>
                            </div>
                            @endforeach
                        </div>
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
                <div id="canvasBar" style="width: 100%;"></div>
                <div class="table-responsive">
                    <table id="getDTWithdrawalRange" class="table table-bordered table-flush table-hover d-none"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="align-middle text-center">#</th>
                                <th class="align-middle">Player</th>
                                <th class="align-middle text-center">Ditarik</th>
                                <th class="align-middle text-center">Diterima</th>
                                <th class="align-middle text-center">status</th>
                                <th class="align-middle">Metode Pembayaran</th>
                                <th class="align-middle">Waktu Permintaan</th>
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

        function initializeAnalyticsTableAndChart(appPackage, startDate, endDate) {
            $(document).ready(function() {
                $('#getDTWithdrawalRange').removeClass('d-none');

                if ($.fn.DataTable.isDataTable('#getDTWithdrawalRange')) {
                    $('#getDTWithdrawalRange').DataTable().destroy();
                }

                var baseUrl = '/analytics-data/withdrawals/' + appPackage + '/' + startDate + '/' + endDate;

                var table = $('#getDTWithdrawalRange').DataTable({
                    processing: true,
                    serverSide: true,
                    paging: true,
                    ajax: baseUrl,
                    aLengthMenu: [
                        [50, 100, 1000, 10000, -1],
                        [50, 100, 1000, 10000, "Semua"]
                    ],
                    iDisplayLength: 50,
                    drawCallback: function(settings) {
                        updateChart(table);
                    },
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
                                    .image_url :
                                    '/img/default_avatar.png';
                                var playerName = fromPlayer ? fromPlayer.name : 'Unknown';
                                var playerEmail = fromPlayer ? fromPlayer.email : 'Unknown';
                                var playerPkg = fromPlayer ? fromPlayer.player_pkg : 'NOT FOUND APP PKG';
                                return '<div class="d-flex align-items-center align-middle">' +
                                    '<img src="' + imageUrl +
                                    '" alt="" class="avatar border border-secondary border-3" style="width:35px;height:35px; margin-right: 10px;">' +
                                    '<div>' +
                                    '<span class="fw-bold">' + playerName + '</span></br>' +
                                    '<span class="fw-semibold">' + playerEmail + '</span></br>' +
                                    '<span class="fw-bold text-primary">' + playerPkg + '</span>' +
                                    '</div>' +
                                    '</div>';
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
                            data: 'amount',
                            name: 'amount',
                            searchable: false,
                            className: 'align-middle text-center',
                            render: function(data, type, full, meta) {
                                var formatter = new Intl.NumberFormat('id-ID', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                });
                                var svgIconPath = '/img/money.svg';
                                var svgIcon =
                                    `<img src="${svgIconPath}" height="20px" width="20px" style="vertical-align: middle;margin-bottom:4px;margin-right:2px">`;
                                return '<span class="fw-semibold">' +
                                    `${svgIcon} ${formatter.format(full.amount)}` + ' ' + full
                                    .currency + '</span>';
                            }
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: false,
                            searchable: false,
                            className: 'align-middle text-center',
                            render: function(data, type, full, meta) {
                                var svgIconPath;
                                var status;
                                switch (full.status) {
                                    case 0:
                                        svgIconPath = '/img/pending.svg';
                                        break;
                                    case 1:
                                        svgIconPath = '/img/done.svg';
                                        break;
                                    case 2:
                                        svgIconPath = '/img/denied.svg';
                                        break;
                                    default:
                                        svgIconPath = '';
                                }
                                var svgIcon =
                                    `<img src="${svgIconPath}" height="20px" width="20px" style="vertical-align: middle;margin-bottom:4px;margin-right:3px">`;
                                return '<span class="fw-semibold">' + svgIcon + '</span>';
                            }
                        },
                        {
                            data: 'payment_method',
                            name: 'payment_method',
                            searchable: false,
                            className: 'align-middle text-center',
                            render: function(data, type, full, meta) {
                                var formatter = new Intl.NumberFormat('id-ID', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                });
                                var paymentMethod = full.payment_method;
                                var imageUrl = paymentMethod && paymentMethod.method_image ?
                                    paymentMethod
                                    .method_image : '/img/dana.png';
                                var methodName = paymentMethod ? paymentMethod.method : 'Unknown';

                                return '<div class="d-flex align-items-center align-middle">' +
                                    '<img src="' + imageUrl +
                                    '" alt="" class="img-fluid img-thumbnail border border-secondary border-2" style="width:50px;height:50px; margin-right: 10px;">' +
                                    '<div class="text-start mt-1">' +
                                    '<span class="fw-bold">' + methodName + '</span></br>' +
                                    '<small class="fw-normal">' + full.currency + ' ' + formatter
                                    .format(full
                                        .amount) + '</small></br>' +
                                    '<span class="fw-semibold">' + full.payment_account +
                                    '</span>' +
                                    '</div>' +
                                    '</div>';
                            }
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            searchable: false,
                            className: 'align-middle text-center',
                            render: function(data, type, full, meta) {
                                return '<span class="fw-bold text-muted">' + moment(full.created_at)
                                    .format('DD/MM/YYYY') +
                                    '</span>';
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
                        // console.log(json);
                        var totalAmount = 0;
                        table.rows().every(function(rowIdx, tableLoop, rowLoop) {
                            var data = this.data();
                            totalAmount += parseFloat(data.amount) || 0;
                        });
                        var formatter = new Intl.NumberFormat('id-ID', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        });
                        $('#countTotalWithdraw').text('Rp.' + formatter.format(totalAmount));
                        updateChart(table);
                    }
                });
            });
        }

        $('#initDataAnalyctics').on('click', function() {
            var appPackages = $('input[name="base_application_id[]"]:checked').map(function() {
                return this.value;
            }).get();
            var dateRangeText = $('#reportrange small').text();
            var dates = dateRangeText.split(' - ');
            var startDate = dates[0];
            var endDate = dates[1];

            if (appPackages.length > 0) {
                var appPackageString = appPackages.join(',');
                console.log(appPackageString);
                initializeAnalyticsTableAndChart(appPackageString, startDate, endDate);
            } else {
                iziToast.show({
                    title: 'Pilih dahulu aplikasi',
                    timeout: 1200,
                    position: 'topRight'
                });
            }
        });

        function updateChart(table) {
            var totalAmountPerDate = {};

            table.rows().every(function(rowIdx, tableLoop, rowLoop) {
                var data = this.data();
                var formattedDate = moment(data['created_at']).format('DD/MM/YYYY');
                var amount = parseFloat(data['amount']) || 0;

                if (!totalAmountPerDate[formattedDate]) {
                    totalAmountPerDate[formattedDate] = amount;
                } else {
                    totalAmountPerDate[formattedDate] += amount;
                }
            });

            var sortedDates = Object.keys(totalAmountPerDate).sort((a, b) => moment(a, 'DD/MM/YYYY').unix() - moment(b,
                'DD/MM/YYYY').unix());
            var sortedDataAmounts = sortedDates.map(date => totalAmountPerDate[date]);

            if (chart) {
                chart.destroy();
            }

            $('#canvasBar').empty();

            var canvas = document.createElement('canvas');
            canvas.id = 'barChart';
            document.getElementById('canvasBar').appendChild(canvas);

            var ctx = document.getElementById('barChart').getContext('2d');
            chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: sortedDates,
                    datasets: [{
                        label: 'Total Withdraw',
                        data: sortedDataAmounts,
                        fill: true,
                        backgroundColor: '#00c85360',
                        borderColor: '#00c853',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Total Amount'
                            }
                        }
                    }
                }
            });
        }

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
