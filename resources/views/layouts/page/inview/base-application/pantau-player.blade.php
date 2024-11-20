@extends('layouts.app')

@section('title', 'Pantau Player')

@push('style')

@endpush

@section('content')
    <div class="main-content">
        <div class="card rounded rounded-4 shadow">
            <div class="card-header text-dark fw-bold d-flex justify-content-between align-items-center mt-2">
                <div class="h5 fw-bold">Pantau Player<br>
                    <span class="h6 fw-semibold text-muted">package : {{ $mBaseApplication->app_pkg }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dtPlayer" class="table table-bordered table-flush" style="width:100%">
                        <thead>
                            <tr>
                                <th class="align-middle text-center">#</th>
                                <th class="align-middle">Player</th>
                                <th class="align-middle">Withdraw Accepted</th>
                                <th class="align-middle">Data Payment Withdraw</th>
                                <th class="align-middle">Detail Payment Withdraw</th>
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
            $('#dtPlayer').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('list-pantau-player', $mBaseApplication->app_pkg) }}",
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
                        data: 'name',
                        name: 'name',
                        render: function(data, type, full, meta) {
                            var wdPlayer = full.withdrawals;
                            var imageUrl = full.image_url ? full.image_url : '/img/default_avatar.png';
                            var formatter = new Intl.NumberFormat('id-ID', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            });
                            var svgIconPath = '/img/points.svg';
                            var svgIcon =
                                `<img src="${svgIconPath}" height="15px" width="15px" style="vertical-align: middle;margin-bottom:4px;margin-right:2px">`;
                            return '<div class="">' +
                                '<img src="' + imageUrl +
                                '" alt="" class="avatar border border-secondary border-3" style="width:50px;height:50px; margin-bottom:8px;margin-top:8px">' +
                                '<div>' +
                                '<span class="fw-bold h6">' + full.name + '</span></br>' +
                                '<small class="fw-bold">' + full.email + '</small></br>' +
                                '<small class="fw-semibold text-sm">Withdraw : ' + wdPlayer.length +
                                ' kali</small></br>' +
                                '<small class="fw-bold text-sm text-muted">Score : ' + full.score +
                                '</small></br>' +
                                '<small class="fw-bold text-sm text-muted">Terdaftar : ' + full.created_at +
                                '</small></br>' +
                                '</div>' +
                                '</div>';
                        }
                    },
                    {
                        data: null,
                        name: 'actions',
                        searchable: false,
                        orderable: false,
                        className: '',
                        render: function(data, type, full, meta) {
                            var wdPlayer = full.withdrawals;
                            var filteredWithdrawals = wdPlayer.filter(function(w) {
                                return w.status === 1;
                            });
                            var totalAmount = filteredWithdrawals.reduce(function(sum, withdrawal) {
                                return sum + withdrawal.amount;
                            }, 0);

                            var totalPoints = filteredWithdrawals.reduce(function(sum, withdrawal) {
                                return sum + withdrawal.points;
                            }, 0);
                            var formatter = new Intl.NumberFormat('id-ID', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            });
                            var svgIconMoneyPath = '/img/money.svg';
                            var svgIconPointPath = '/img/points.svg';
                            var svgIconMoney = `<img src="${svgIconMoneyPath}" height="15px" width="15px" style="vertical-align: middle;margin-bottom:4px;margin-right:2px">`;
                            var svgIconPoints = `<img src="${svgIconPointPath}" height="15px" width="15px" style="vertical-align: middle;margin-bottom:4px;margin-right:2px">`;

                            return '<span class="fw-semibold">' +
                            `${svgIconMoney} ${formatter.format(totalAmount)} Total Ammount WD` +
                            '</span></br>' +
                            '<span class="fw-semibold">' +
                            `${svgIconPoints} ${formatter.format(totalPoints)} Total Points WD ` +
                            '</span></br>' +
                            '<small class="fw-semibold">' +
                            `${svgIconPoints} ${formatter.format(full.points)}` +
                            ' <b class="text-muted">Current Points</b></small></br>' +
                            '<small class="fw-semibold">' +
                            `${svgIconPoints} ${formatter.format(full.points_collected)}` +
                            ' <b class="text-muted">Points Collected</b></small></br>' ;
                        }
                    },
                    {
                        data: null,
                        name: 'actions',
                        searchable: false,
                        orderable: false,
                        className: 'p-0',
                        render: function(data, type, full, meta) {
                            var wdPlayer = full.withdrawals;
                            var groupedData = {
                                0: {},
                                1: {}, 
                                2: {}
                            };

                            wdPlayer.forEach(function(withdrawal) {
                                var status = withdrawal.status;
                                var method = withdrawal.payment_method.method;
                                var account = withdrawal.payment_account;

                                if (!groupedData[status][method]) {
                                    groupedData[status][method] = [];
                                }

                                groupedData[status][method].push(account);
                            });

                            var result = '<div class="accordion p-0" id="accordion-' + meta.row + '">';
                            var statusLabels = {
                                0: { label: 'WD PENDING', colorClass: 'bg-primary text-white fw-bold bg-primary-active' },
                                1: { label: 'WD APPROVED', colorClass: 'bg-success text-white fw-bold bg-success-active' },
                                2: { label: 'WD DECLINED', colorClass: 'bg-danger text-white fw-bold bg-danger-active' }
                            };

                            for (var status in groupedData) {
                                if (groupedData.hasOwnProperty(status)) {
                                    var collapseId = 'collapse-' + status + '-' + meta.row;
                                    var headingId = 'heading-' + status + '-' + meta.row;
                                    var statusLabel = statusLabels[status].label;
                                    var statusColorClass = statusLabels[status].colorClass;
                                    var methods = groupedData[status];
                                    var count = wdPlayer.filter(w => w.status == status).length;

                                    result += `
                                    <div class="accordion-item p-0 m-0" style="border: none; border-radius: 0;">
                                    <h2 class="accordion-header p-0 m-0" id="${headingId}">
                                    <button class="accordion-button collapsed p-1 fw-semibold ${statusColorClass}" style="font-size: 0.80rem; border: none; border-radius: 0;" type="button" data-bs-toggle="collapse" data-bs-target="#${collapseId}" aria-expanded="false" aria-controls="${collapseId}">
                                    <span class="align-middle p-2">${statusLabel} (${count})</span>
                                    </button>
                                    </h2>
                                    <div id="${collapseId}" class="accordion-collapse collapse" aria-labelledby="${headingId}" data-parent="#accordion-${meta.row}">
                                    <div class="accordion-body p-0" style="font-size: 0.75rem;background-color:#FAFAFA">
                                    `;

                                    for (var method in methods) {
                                        if (methods.hasOwnProperty(method)) {
                                            var methodAccounts = methods[method];
                                            var methodCount = methodAccounts.length;
                                            var methodCollapseId = 'method-collapse-' + method.replace(/\s+/g, '-') + '-' + status + '-' + meta.row;
                                            var methodHeadingId = 'method-heading-' + method.replace(/\s+/g, '-') + '-' + status + '-' + meta.row;

                                            result += `
                                            <div class="accordion-item m-0" style="border-radius: 0;">
                                            <h2 class="accordion-header p-0 m-0" id="${methodHeadingId}">
                                            <button class="accordion-button collapsed p-1 fw-semibold" style="font-size: 0.75rem; border: none; border-radius: 0;" type="button" data-bs-toggle="collapse" data-bs-target="#${methodCollapseId}" aria-expanded="false" aria-controls="${methodCollapseId}">
                                            ${method} (${methodCount})
                                            </button>
                                            </h2>
                                            <div id="${methodCollapseId}" class="accordion-collapse collapse" aria-labelledby="${methodHeadingId}" data-parent="#${collapseId}">
                                            <div class="accordion-body" style="font-size: 0.75rem;">
                                            `;

                                            methodAccounts.forEach(function(account) {
                                                result += `
                                                <div class="fw-bold text-primary">
                                                ${account}
                                                </div>
                                                `;
                                            });

                                            result += `
                                            </div>
                                            </div>
                                            </div>
                                            `;
                                        }
                                    }

                                    result += `
                                    </div>
                                    </div>
                                    </div>
                                    `;
                                }
                            }

                            result += '</div>';

                            return result;
                        }
                    },
                    {
                        data: null,
                        name: 'actions',
                        searchable: false,
                        orderable: false,
                        className: 'p-0',
                        render: function(data, type, full, meta) {
                            var wdPlayer = full.withdrawals;
                            var groupedData = {};
                            wdPlayer.forEach(function(withdrawal) {
                                var method = withdrawal.payment_method.method;
                                var account = withdrawal.payment_account;
                                var createdAt = withdrawal.created_at;

                                if (!groupedData[method]) {
                                    groupedData[method] = {};
                                }

                                if (!groupedData[method][account]) {
                                    groupedData[method][account] = { count: 0, dates: [] };
                                }

                                groupedData[method][account].count++;
                                groupedData[method][account].dates.push(createdAt);
                            });
                            var result = '<div class="accordion p-0 m-0" id="accordion-' + meta.row + '">';
                            for (var method in groupedData) {
                                if (groupedData.hasOwnProperty(method)) {
                                    var collapseId = 'collapse-' + method.replace(/\s+/g, '-') + '-' + meta.row;
                                    var headingId = 'heading-' + method.replace(/\s+/g, '-') + '-' + meta.row;
                                    result += `
                                    <div class="accordion-item p-2 m-0" style="border: none; border-radius: 0;">
                                    <h2 class="accordion-header p-0 m-0" id="${headingId}">
                                    <span class="accordion-button collapsed p-1 fw-semibold" style="font-size: 0.90rem; border-radius: 0;" data-bs-toggle="collapse" data-bs-target="#${collapseId}" aria-expanded="false" aria-controls="${collapseId}">
                                    ${method}
                                    </span>
                                    </h2>
                                    <div id="${collapseId}" class="accordion-collapse collapse" aria-labelledby="${headingId}" data-parent="#accordion-${meta.row}">
                                    <div class="accordion-body p-1" style="font-size: 0.75rem;">
                                    `;
                                    for (var account in groupedData[method]) {
                                        if (groupedData[method].hasOwnProperty(account)) {
                                            var accountData = groupedData[method][account];
                                            var count = accountData.count;
                                            var dates = accountData.dates.join(', ');
                                            result += `
                                            <div class="fw-bold text-primary">
                                            ${account} (${count} kali)
                                            <br>
                                            <span class="text-muted">${dates}</span>
                                            </div>
                                            `;
                                        }
                                    }
                                    result += `
                                    </div>
                                    </div>
                                    </div>
                                    `;
                                }
                            }
                            result += '</div>';
                            return result;
                        }
                    },
                    {
                        data: null,
                        name: 'actions',
                        searchable: false,
                        orderable: false,
                        className: 'align-middle text-center',
                        render: function(data, type, full, meta) {
                            var pantauButton = '<a href="/pantau-player-collected-points/' + full.id + '" class="btn btn-sm btn-success shadow-none fw-bold ms-1" data-placement="top">PANTAU</a>';
                            var actionButton = '<div class="text-center align-middle">' +
                            '<a class="btn btn-sm btn-primary shadow-none fw-bold ms-1" href="/detail-player/' +
                            full.id + '">' +
                            '<i class="fa fa-edit" aria-hidden="true"></i></a>' + '</div>';
                            return '<div class="d-flex justify-content-between">' + actionButton + pantauButton + '</div>';
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
