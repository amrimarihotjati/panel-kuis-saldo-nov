<div class="table-responsive p-0 m-0">
    <table id="DatatableWithdrawDanaPending" class="table table-bordered table-hover p-0 m-0 border" style="width:100%">
        <thead class="">
            <tr>
                <th class="align-middle">No</th>
                <th class="align-middle">Player</th>
                <th class="align-middle">Point</th>
                <th class="align-middle">Amount</th>
                <th class="align-middle">Payment Status</th>
                <th class="align-middle">Wallet</th>
                <th class="align-middle">Account Number</th>
                <th class="align-middle">Request Time</th>
                <th class="align-middle">Action</th>
                <th class="align-middle">Response</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script type="module">
    $(document).ready(function() {
        $('#DatatableWithdrawDanaPending').DataTable({
            processing: true,
            serverSide: true,
            order: [
                [6, 'desc'],
            ],
            ajax: {
                url: "{{ route('getDatatableWithdrawDanaPending') }}",
            },
            paging: false,
            searching: false,
            lengthMenu: [
                [-1],
                ["Semua"]
            ],
            pageLength: -1,
            buttons: [{
                    extend: 'colvis',
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
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    },
                    orderable: false,
                    searchable: false,
                    className: 'fw-bold text-center align-middle'
                },
                {
                    data: 'player.name',
                    orderable: false,
                    className: 'text-start align-middle',
                    render: function(data, type, full, meta) {
                        const {
                            player
                        } = full;
                        const playerName = player?.name || 'Player Tidak Ada';
                        const playerEmail = player?.email || 'Email Tidak Ada';
                        return `
                    <span class="text-dark">${playerName}</span><br/>
                    <span class="text-primary fw-bold">${playerEmail}</span>
                    `;
                    }
                },
                {
                    data: 'points',
                    orderable: false,
                    className: 'text-center align-middle',
                    render: function(data, type, full, meta) {
                        var formatter = new Intl.NumberFormat('id-ID', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        });
                        return '<span class="text-dark fw-semibold">' + formatter.format(full
                            .points) + '</span>';
                    }
                },
                {
                    data: 'amount',
                    orderable: false,
                    className: 'text-center align-middle',
                    render: function(data, type, full, meta) {
                        var formatter = new Intl.NumberFormat('id-ID', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        });
                        return '<span class="text-dark fw-semibold">Rp.' + formatter.format(full
                            .amount) + '</span>';
                    }
                },
                {
                    data: 'status',
                    orderable: false,
                    className: 'text-center align-middle',
                    render: function(data, type, full, meta) {
                        let statusLabel = '';
                        switch (data) {
                            case 0:
                                statusLabel =
                                    '<span class="badge rounded rounded-2 text-bg-secondary">PENDING</span>';
                                break;
                            case 1:
                                statusLabel =
                                    '<span class="badge rounded rounded-2 text-bg-success">ACCEPTED</span>';
                                break;
                            case 2:
                                statusLabel =
                                    '<span class="badge rounded rounded-2 text-bg-danger">REJECTED</span>';
                                break;
                            default:
                                statusLabel =
                                    '<span class="badge rounded rounded-2 text-bg-warning">UNKNOWN</span>';
                        }

                        return statusLabel;
                    }
                },
                {
                    data: 'payment_method.method',
                    orderable: false,
                    className: 'text-center align-middle',
                    render: function(data, type, full, meta) {
                        const {
                            payment_method
                        } = full;
                        const paymentMethodName = payment_method?.method ||
                            'Payment Method Tidak Ada';
                        return '<span class="text-primary fw-bold">' + paymentMethodName
                            .toUpperCase() + '</span>';
                    }
                },
                {
                    data: 'payment_account',
                    orderable: false,
                    className: 'text-center align-middle',
                    render: function(data, type, full, meta) {
                        return '<span class="text-dark fw-bold">' + full.payment_account +
                            '</span>';
                    }
                },
                {
                    data: 'created_at',
                    orderable: false,
                    className: 'text-center align-middle',
                    render: function(data, type, full, meta) {
                        return '<small class="text-dark">' + full.created_at + '</small>';
                    }
                },
                {
                    data: null,
                    orderable: false,
                    className: 'text-center align-middle',
                    render: function(data, type, full, meta) {
                        var playerId = full.player ? full.player.id : -1;
                        var playerPkg = full.player ? full.player.player_pkg : -1;
                        var playerName = full.player ? full.player.name : 'Unknown';
                        var playerMail = full.player ? full.player.email : 'Unknown';
                        var paymentMethodName = full.payment_method ? full.payment_method
                            .method :
                            'Unknown';
                        var textCopy = '*PEMBAYARAN*\n\n' +
                            '*Nama Player :* ' + playerName + '\n' +
                            '*Email Player :* ' + playerMail + '\n\n' +
                            '*NOMINAL ' + full.currency.toUpperCase() + '*\n' + full.amount +
                            '\n\n*' +
                            paymentMethodName.toUpperCase() + '*\n' + full.payment_account;

                        var copyButton =
                            '<button type="button" class="btn btn-sm btn-primary shadow-none fw-bold" ' +
                            'data-clipboard-text="' + textCopy + '" ' +
                            'data-bs-toggle="tooltip" data-placement="top" title="COPY">' +
                            '<i class="fa fa-copy" aria-hidden="true"></i>' +
                            '</button>';

                        var pantauButton = '<a href="/pantau-player-collected-points/' +
                            playerId + '" ' +
                            'class="btn btn-sm btn-success shadow-none fw-bold ms-1" ' +
                            'data-placement="top">' +
                            '<i class="fa fa-eye" aria-hidden="true"></i>' +
                            '</a>';

                        var pantauButton = '<a href="/pantau-player-collected-points/' +
                            playerId + '" ' +
                            'class="btn btn-sm btn-success shadow-none fw-bold ms-1" ' +
                            'data-placement="top">' +
                            '<i class="fa fa-eye" aria-hidden="true"></i>' +
                            '</a>';

                        return '<div class="d-flex justify-content-between">' + copyButton +
                            pantauButton +
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
                        var paymentMethodName = full.payment_method ? full.payment_method
                            .method :
                            'Unknown';
                        return ' <a href="#" class="btn btn-sm btn-dark shadow-none" data-bs-toggle="modal"' +
                            ' data-bs-target="#withdrawalDetailModalDashboard"' +
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
                },
            ],
            drawCallback: function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var lastPaymentAccount = null;
                var totalAmount = 0;

                api.column(6, {
                    page: 'current'
                }).data().each(function(paymentAccount, i) {
                    var currentPaymentAccount = api.cell(i, 6).data();
                    var currentAmount = api.cell(i, 3).data();

                    if (lastPaymentAccount !== currentPaymentAccount) {
                        if (lastPaymentAccount !== null) {
                            $(rows).eq(i - 1).after(
                                '<tr class="bg-success"><td colspan="10" class="text-center h6 text-white fw-bold">Total Amount: ' +
                                totalAmount.toLocaleString('id-ID') + '</td></tr>'
                            );
                        }

                        totalAmount = 0;
                        lastPaymentAccount = currentPaymentAccount;

                        $(rows).eq(i).before(
                            '<tr class="group bg-dark fw-bold text-white text-center h6"><td colspan="10">Nomor E-wallet : ' +
                            currentPaymentAccount + '</td></tr>'
                        );
                    }

                    totalAmount += parseFloat(currentAmount) || 0;
                });

                if (lastPaymentAccount !== null) {
                    $(rows).eq(-1).after(
                        '<tr class="bg-success"><td colspan="10" class="text-center h6 text-white fw-bold">Total Amount: ' +
                        totalAmount.toLocaleString('id-ID') + '</td></tr>'
                    );
                }
            },
            language: {
                emptyTable: "Tidak ada data",
                info: "_TOTAL_ data ditampilkan",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Tidak ditemukan"
            },
            initComplete: function(settings, json) {
                // console.log(json);
            },
        });
    });
</script>
