@extends('layouts.app')

@section('content')
@include('sweetalert::alert')

<div class="main-content">
    <div class="header">
        <div class="row">
            <div class="col-xl-4">
                <div class="card card rounded rounded-3 shadow bg-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body text-left">
                                    <h5 class="text-primary" id="withdrawPendingSum">Rp.{{ $withdrawPendingSum }}</h5>
                                    <span class="fw-bold text-muted">Withdraw Pending {{ $withdrawPending }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card card rounded rounded-3 shadow bg-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body text-left">
                                    <h5 class="text-primary" id="withdrawAcceptedSum">Rp.{{ $withdrawAcceptedSum }}</h5>
                                    <span class="fw-bold text-muted">Withdraw Accepted {{ $withdrawAccepted }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card card rounded rounded-3 shadow bg-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body text-left">
                                    <h5 class="text-primary" id="withdrawRejectedSum">Rp.{{ $withdrawRejectedSum }}</h5>
                                    <span class="fw-bold text-muted">Withdraw Rejected {{ $withdrawRejected }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="card rounded rounded-3 shadow">
            <div class="card-header text-primary fw-bold d-flex justify-content-between align-items-center mt-2">
                <div class="h5 fw-bold">Permintaan Withdrawal<br>
                    <span class="h6 fw-semibold text-muted">Semua Aplikasi</span>
                </div>
            </div>
            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                        <button class="nav-link fw-semibold h5 active" id="nav-pm-dana" data-bs-toggle="tab" data-bs-target="#tab-pm-dana" type="button" role="tab" aria-controls="tab-pm-dana" aria-selected="true">Dana</button>
                        <button class="nav-link fw-semibold h5" id="nav-pm-ovo" data-bs-toggle="tab" data-bs-target="#tab-pm-ovo" type="button" role="tab" aria-controls="tab-pm-ovo" aria-selected="false">Ovo</button>
                        <button class="nav-link fw-semibold h5" id="nav-pm-gopay" data-bs-toggle="tab" data-bs-target="#tab-pm-gopay" type="button" role="tab" aria-controls="tab-pm-gopay" aria-selected="false">Gopay</button>
                        <button class="nav-link fw-semibold h5" id="nav-pm-shopeepay" data-bs-toggle="tab" data-bs-target="#tab-pm-shopeepay" type="button" role="tab" aria-controls="tab-pm-shopeepay" aria-selected="false">ShopeePay</button>
                        <button class="nav-link fw-semibold h5" id="nav-pm-linkaja" data-bs-toggle="tab" data-bs-target="#tab-pm-linkaja" type="button" role="tab" aria-controls="tab-pm-linkaja" aria-selected="false">LinkAja</button>
                        <button class="nav-link fw-semibold h5" id="nav-pm-all" data-bs-toggle="tab" data-bs-target="#tab-pm-all" type="button" role="tab" aria-controls="tab-pm-all" aria-selected="false">Semua</button>
                    </div>
                </nav>
                <div class="tab-content p-0" style="" id="nav-tabContent">
                    <div class="tab-pane p-0 fade active show" id="tab-pm-dana" role="tabpanel" aria-labelledby="nav-pm-dana">
                        @include('layouts/dashboard/withdraw/wd-dana')
                    </div>
                    <div class="tab-pane p-0 fade" id="tab-pm-ovo" role="tabpanel" aria-labelledby="nav-pm-ovo">
                        @include('layouts/dashboard/withdraw/wd-ovo')
                    </div>
                    <div class="tab-pane p-0 fade" id="tab-pm-gopay" role="tabpanel" aria-labelledby="nav-pm-gopay">
                        @include('layouts/dashboard/withdraw/wd-gopay')
                    </div>
                    <div class="tab-pane p-0 fade" id="tab-pm-shopeepay" role="tabpanel" aria-labelledby="nav-pm-shopeepay">
                        @include('layouts/dashboard/withdraw/wd-shoopepay')
                    </div>
                    <div class="tab-pane p-0 fade" id="tab-pm-linkaja" role="tabpanel" aria-labelledby="nav-pm-linkaja">
                        @include('layouts/dashboard/withdraw/wd-linkaja')
                    </div>
                     <div class="tab-pane p-0 fade" id="tab-pm-all" role="tabpanel" aria-labelledby="nav-pm-all">
                        @include('layouts/dashboard/withdraw/wd-all')
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@include('layouts/modal/update-public-dashboard-withdrawal')
@push('scripts')
<script type="module">
    var requestStatistic;

    $('#withdrawalDetailModalDashboard').on('show.bs.modal', function(event) {
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

        var points = button.data('points');
        var amount = button.data('amount');
        var formattedPoints = new Intl.NumberFormat('id-ID').format(points);
        var formattedAmount = new Intl.NumberFormat('id-ID').format(amount);

        modal.find('#modal-points').val(formattedPoints);
        modal.find('#modal-amount').val(formattedAmount);

        modal.find('#modal-status').val(statusInfo);
        modal.find('#modal-payment-method').val(button.data('payment-method'));
        modal.find('#modal-created-at').val(button.data('created-at'));
        modal.find('#modal-updated-at').val(button.data('updated-at'));

        requestStatistic = $.ajax({
            url: 'getDataPlayerStatisticForWithdraw/' + button.data('withdrawal-id'),
            type: 'GET',
            success: function(response) {
                // console.log(response);
                var bigPointQuiz = response.bigPointQuiz
                var validCountQuiz = response.validCountQuiz;
                var invalidCountQuiz = response.invalidCountQuiz;
                var totalIntersWatched3days = response.totalIntersWatched3days;
                var totalRewardsWatched3days = response.totalRewardsWatched3days;
                var countWdByNumber = response.countWdByNumber;
                var countWdByAccount = response.countWdByAccount;

                modal.find('#valueBigPointQuiz').text(bigPointQuiz);
                modal.find('#valueQuizValid').text(validCountQuiz);
                modal.find('#valueQuizInValid').text(invalidCountQuiz);
                modal.find('#valueLastAdInters').text(totalIntersWatched3days);
                modal.find('#valueLastAdRewards').text(totalRewardsWatched3days);
                modal.find('#valueWithdrawByAccount').text(countWdByNumber);
                modal.find('#valueWithdrawByNumber').text(countWdByAccount);
            },
            error: function(xhr, status, error) {
                // console.log('Error:', error);
            }
        });

        $('#withdrawalDetailModalDashboard').on('hidden.bs.modal', function() {
            if (requestStatistic) {
                requestStatistic.abort();
            }
            var modal = $(this);
            modal.find('#valueBigPointQuiz').text('Memuat...');
            modal.find('#valueQuizValid').text('Memuat...');
            modal.find('#valueQuizInValid').text('Memuat...');
            modal.find('#valueLastAdInters').text('Memuat...');
            modal.find('#valueLastAdRewards').text('Memuat...');
            modal.find('#valueWithdrawByAccount').text('Memuat...');
            modal.find('#valueWithdrawByNumber').text('Memuat...');
        });

    });
</script>
@endpush
