@extends('layouts.app')

@section('title', 'History Withdrawal')

@push('style')
@endpush

@section('content')
    <div class="main-content">
        <div class="card rounded rounded-4 shadow p-2">
            <div class="card-header text-dark fw-bold mt-2 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="h5 fw-bold">Riwayat Withdrawal<br>
                        <span class="h6 fw-semibold text-muted">package : {{ $mBaseApplication->app_pkg }}</span>
                    </div>
                </div>
                <div class="text-center">
                    <span class="h5 fw-bold">Total Pending Withdraw</span><br>
                    <div>
                        <sup class="h6 text-primary fw-semibold"
                            id="countTotalPendingWithdraw">Rp.{{ $mWithdrawalTotalAmountPending }}</sup>
                    </div>
                </div>
                <div class="text-end">
                    <span class="h5 fw-bold">Total Withdraw Player</span><br>
                    <div>
                        <sup class="h6 text-primary fw-semibold"
                            id="countTotalWithdraw">Rp.{{ $mWithdrawalTotalAmount }}</sup>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dtWithdrawalPlayer" class="table table-bordered table-flush" style="width:100%">
                        <thead>
                            <tr>
                                <th class="align-middle text-center">No</th>
                                <th class="align-middle">Player</th>
                                <th class="align-middle">Ditarik</th>
                                <th class="align-middle">Diterima</th>
                                <th class="align-middle">Status</th>
                                <th class="align-middle">Big Point Quiz</th>
                                <th class="align-middle">Withdraw By Akun</th>
                                <th class="align-middle">Withdraw By Nomor</th>
                                <th class="align-middle">Last Ad Inters</th>
                                <th class="align-middle">Last Ad Rewards</th>
                                <th class="align-middle">Metode Pembayaran Wallet</th>
                                <th class="align-middle">Waktu Permintaan</th>
                                <th class="align-middle">Aksi</th>
                                <th class="align-middle">#</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('layouts/modal/update-withdrawal')

    </div>
@endsection

@push('scripts')
    <script type="module">
        $('#dtWithdrawalPlayer').DataTable({
            processing: true,
            serverSide: true,
            order: [[10, 'desc'], [5, 'desc'], [6, 'desc'], [7, 'desc']],
            ajax: {
                url: "{{ route('list-withdrawal-player', $mBaseApplication->app_pkg) }}",
                data: function(d) {
                    d.payment_method = $('.paymentmethod-filter-dropdown').val();
                    d.withdraw_count_by_nomor = $('.wdcountbynomor-filter-dropdown').val();
                }
            },
            aLengthMenu: [
                [25, 50, 100, 1000, 10000, -1],
                [25, 50, 100, 1000, 10000, "Semua"]
            ],
            iDisplayLength: 25,
            layout: {
                topStart: {
                    buttons: [{
                            extend: 'colvis',
                            className: 'btn btn-primary btn-sm fw-bold shadow-none m-1 rounded'
                        },
                        {
                            extend: 'pageLength',
                            className: 'btn btn-primary btn-sm fw-bold shadow-none m-1 rounded'
                        },
                        {
                            extend: 'csv',
                            text: 'CSV',
                            className: 'btn btn-primary btn-sm fw-bold shadow-none m-1 rounded'
                        },
                        {
                            extend: 'excel',
                            text: 'EXCEL',
                            className: 'btn btn-primary btn-sm fw-bold shadow-none m-1 rounded'
                        }
                    ],
                }
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
                    orderable: false,
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
                            `<img src="${svgIconPath}" height="12px" width="12px" style="vertical-align: middle;margin-bottom:4px;margin-right:2px">`;
                        return '<small class="fw-semibold">' +
                            `${svgIcon} ${formatter.format(full.points)}` + '</small>';
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
                            `<img src="${svgIconPath}" height="15px" width="15px" style="vertical-align: middle;margin-bottom:4px;margin-right:2px">`;
                        return '<small class="fw-semibold">' +
                            `${svgIcon} ${formatter.format(full.amount)}` + ' ' + full.currency +
                            '</small>';
                    }
                },
                {
                    data: 'status',
                    name: 'status',
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
                    data: 'big_point_quiz',
                    name: 'big_point_quiz',
                    orderable: true,
                    searchable: false,
                    className: 'align-middle text-center',
                    render: function(data, type, full, meta) {
                        return '<small class="fw-bold">' + full.big_point_quiz + ' POINT</small>';
                    }
                },
                {
                    data: 'withdraw_count',
                    name: 'withdraw_count',
                    orderable: false,
                    searchable: false,
                    className: 'align-middle text-center',
                    render: function(data, type, full, meta) {
                        return '<small class="fw-bold">' + full.withdraw_count + '<br>KALI</small>';
                    }
                },
                {
                    data: 'withdraw_count_by_nomor',
                    name: 'withdraw_count_by_nomor',
                    orderable: false,
                    searchable: false,
                    className: 'align-middle text-center',
                    render: function(data, type, full, meta) {
                        return '<small class="fw-bold">' + full.withdraw_count_by_nomor + '<br>KALI</small>';
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'align-middle text-center',
                    render: function(data, type, full, meta) {
                        return '<small class="fw-normal"><span class="fw-bold text-primary">' + full
                            .ad_inters_count + '</span><br>ADS</small>';
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'align-middle text-center',
                    render: function(data, type, full, meta) {
                        return '<small class="fw-normal"><span class="fw-bold text-primary">' + full
                            .ad_rewards_count + '</span><br>ADS</small>';
                    }
                },
                {
                    data: 'payment_account',
                    name: 'payment_account',
                    searchable: false,
                    className: 'align-middle text-center',
                    render: function(data, type, full, meta) {
                        var formatter = new Intl.NumberFormat('id-ID', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        });
                        var paymentMethod = full.payment_method;
                        var imageUrl = paymentMethod && paymentMethod.method_image ? paymentMethod
                            .method_image : '/img/dana.png';
                        var methodName = paymentMethod ? paymentMethod.method : 'Unknown';

                        return '<div class="align-middle">' +
                            '<img src="' + imageUrl +
                            '" alt="" class="img-fluid img-thumbnail border border-light border-1" style="width:40px;height:40px;"><br>' +
                            '<span class="fw-bold">' + methodName + '</span></br>' +
                            '<div class="text-center">' +
                            '<small class="fw-bold text-primary">' + formatter.format(full
                                .amount) + '</small></br>' +
                            '<small class="fw-semibold">' + full.payment_account + '</small>' +
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
                        return '<small class="fw-bold text-muted">' + full.created_at + '</small>';
                    }
                },
                {
                    data: null,
                    name: null,
                    searchable: true,
                    orderable: false,
                    className: 'align-middle text-center',
                    render: function(data, type, full, meta) {
                        var playerId = full.player ? full.player.id : -1;
                        var playerPkg = full.player ? full.player.player_pkg : -1;
                        var playerName = full.player ? full.player.name : 'Unknown';
                        var playerMail = full.player ? full.player.email : 'Unknown';
                        var paymentMethodName = full.payment_method ? full.payment_method.method :
                            'Unknown';
                        var textCopy = '*PEMBAYARAN*\n\n' +
                            '*Nama Player :* ' + playerName + '\n' +
                            '*Email Player :* ' + playerMail + '\n\n' +
                            '*NOMINAL ' + full.currency.toUpperCase() + '*\n' + full.amount + '\n\n*' +
                            paymentMethodName.toUpperCase() + '*\n' + full.payment_account;

                        var copyButton =
                            '<button type="button" class="btn btn-sm btn-primary shadow-none fw-bold" ' +
                            'data-clipboard-text="' + textCopy + '" ' +
                            'data-bs-toggle="tooltip" data-placement="top" title="COPY">' +
                            '<i class="fa fa-copy" aria-hidden="true"></i>' +
                            '</button>';

                        var pantauButton = '<a href="/pantau-player-collected-points/' + playerId + '" ' +
                            'class="btn btn-sm btn-success shadow-none fw-bold ms-1" ' +
                            'data-placement="top">' +
                            '<i class="fa fa-eye" aria-hidden="true"></i>' +
                            '</a>';

                        return '<div class="d-flex justify-content-between">' + copyButton + pantauButton +
                            '</div>';
                    }
                },
                {
                    data: null,
                    name: 'actions',
                    searchable: false,
                    orderable: false,
                    className: 'align-middle text-center',
                    render: function(data, type, full, meta) {
                        var playerId = full.player ? full.player.id : -1;
                        var playerPkg = full.player ? full.player.player_pkg : -1;
                        var playerName = full.player ? full.player.name : 'Unknown';
                        var playerMail = full.player ? full.player.email : 'Unknown';
                        var paymentMethodName = full.payment_method ? full.payment_method.method :
                            'Unknown';

                        return ' <a href="#" class="btn btn-sm btn-dark shadow-none" data-bs-toggle="modal"' +
                            ' data-bs-target="#withdrawalDetailModal"' +
                            ' data-nama-player="' + playerName + '"' +
                            ' data-email-player="' + playerMail + '"' +
                            ' data-withdrawal-id="' + full.id + '"' +
                            ' data-withdrawal-amount="' + full.amount + '"' +
                            ' data-withdrawal-points="' + full.points + '"' +
                            ' data-withdrawal-payment-message="' + full.payment_message + '"' +
                            ' data-withdrawal-player-id="' + playerId + '"' +
                            ' data-withdrawal-app-id="' + playerPkg + '"' +
                            ' data-points="' + full.points + '"' +
                            ' data-amount="' + full.amount + '"' +
                            ' data-status="' + full.status + '"' +
                            ' data-payment-method="' + paymentMethodName + '"' +
                            ' data-payment-message="' + full.payment_message + '"' +
                            ' data-created-at="' + full.created_at + '"' +
                            ' data-updated-at="' + full.created_at + '">' +
                            ' <i class="fa fa-edit" aria-hidden="true"></i>' +
                            '</a>';
                    }
                }
            ],
            drawCallback: function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var lastPaymentAccount = null;
                var totalAmount = 0;

                api.column(10, {
                    page: 'current'
                }).data().each(function(paymentAccount, i) {
                    var currentPaymentAccount = api.cell(i, 10).data(); 
                    var currentAmount = api.cell(i, 3).data();

                    if (lastPaymentAccount !== currentPaymentAccount) {
                        if (lastPaymentAccount !== null) {
                            $(rows).eq(i - 1).after(
                                '<tr class="bg-success"><td colspan="14" class="text-center h6 text-white fw-bold">Total Amount: ' +
                                totalAmount.toLocaleString('id-ID') + '</td></tr>'
                            );
                        }

                        totalAmount = 0;
                        lastPaymentAccount = currentPaymentAccount;

                        $(rows).eq(i).before(
                            '<tr class="group bg-dark fw-bold text-white text-center h6"><td colspan="14">Nomor E-wallet : ' +
                            currentPaymentAccount + '</td></tr>'
                        );
                    }

                    totalAmount += parseFloat(currentAmount) || 0;
                });

                if (lastPaymentAccount !== null) {
                    $(rows).eq(-1).after(
                        '<tr class="bg-success"><td colspan="14" class="text-end text-white fw-bold">Total Amount: ' +
                        totalAmount.toLocaleString('id-ID') + '</td></tr>'
                    );
                }
            },

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
                "zeroRecords": "Tidak ditemukan",
            },
            initComplete: function(settings, json) {
                var paymentMethods = ['Dana', 'Gopay', 'Link Aja', 'Ovo', 'Shoopepay'];
                var StatusCountWd = [];
                json.data.forEach(function(item) {
                    // if (item.payment_method && paymentMethods.indexOf(item.payment_method.method) === -
                    //     1) {
                    //     paymentMethods.push(item.payment_method.method);
                    // }
                    if (item.withdraw_count_by_nomor && StatusCountWd.indexOf(item
                            .withdraw_count_by_nomor) === -
                        1) {
                        StatusCountWd.push(item.withdraw_count_by_nomor);
                    }
                });
                generateFilterDropdown(paymentMethods, StatusCountWd);
            }
        });

        function generateFilterDropdown(paymentMethods, StatusCountWd) {
            var buttonContainer = $('.dt-buttons');
            buttonContainer.find('.dynamic-filter-dropdown').remove();

            var selectDropdown = $('<select class="form-select form-select-sm paymentmethod-filter-dropdown m-1"></select>');
            selectDropdown.append('<option value="">Semua Payment</option>');

            paymentMethods.forEach(function(method) {
                selectDropdown.append('<option value="' + method + '">' + method + '</option>');
            });
            buttonContainer.append(selectDropdown);

            var selectStatusDropdown = $(
            '<select class="form-select form-select-sm wdcountbynomor-filter-dropdown m-1"></select>');
            selectStatusDropdown.append('<option value="">Semua Withdraw By Nomor</option>');
            StatusCountWd.forEach(function(statusCount) {
                selectStatusDropdown.append('<option value="' + statusCount + '"> Total Wd By Nomor ' + statusCount + ' Kali</option>');
            });
            buttonContainer.append(selectStatusDropdown);

            var table = $('#dtWithdrawalPlayer').DataTable();

            selectDropdown.on('change', function() {
                var paymentMethod = $(this).val();
                table.column(10).search(paymentMethod || '').draw();
            });

            selectStatusDropdown.on('change', function() {
                var withdrawCountByNomor = $(this).val();
                table.column(7).search(withdrawCountByNomor || '').draw();
            });
            
        }

        $('#withdrawalDetailModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var modal = $(this);

            var status = button.data('status');
            var statusMessage = button.data('payment-message');

            var statusInfo = "unknown";
            if (status === 0) {
                statusInfo = "PENDING";
            } else if (status === 1) {
                statusInfo = "DISETUJUI";
            } else {
                statusInfo = "DITOLAK";
            }

            var messageInfo = modal.find('#modal-input-response-message');
            messageInfo.val(statusMessage);

            modal.find('#modal-nama-player').val(button.data('nama-player'));
            modal.find('#modal-email-player').val(button.data('email-player'));
            modal.find('#modal-withdrawal-id').val(button.data('withdrawal-id'));
            modal.find('#modal-withdrawal-amount').val(button.data('withdrawal-amount'));
            modal.find('#modal-withdrawal-points').val(button.data('withdrawal-points'));
            modal.find('#modal-withdrawal-player-id').val(button.data('withdrawal-player-id'));
            modal.find('#modal-withdrawal-app-id').val(button.data('withdrawal-app-id'));
            modal.find('#modal-points').val(button.data('points'));
            modal.find('#modal-amount').val(button.data('amount'));
            modal.find('#modal-status').val(statusInfo);
            modal.find('#modal-payment-method').val(button.data('payment-method'));
            modal.find('#modal-created-at').val(button.data('created-at'));
            modal.find('#modal-updated-at').val(button.data('updated-at'));

        });

        $(document).ready(function() {
            function formatRupiah(angka, prefix) {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi),
                    separator;

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                return prefix === undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
            }

            var totalAmount = $('#countTotalWithdraw').text();
            var totalAmountPending = $('#countTotalPendingWithdraw').text();
            var formattedAmount = formatRupiah(totalAmount, 'Rp. ');
            var formattedAmountPending = formatRupiah(totalAmountPending, 'Rp. ');

            $('#countTotalWithdraw').text(formattedAmount);
            $('#countTotalPendingWithdraw').text(formattedAmountPending);

        });
    </script>
@endpush
