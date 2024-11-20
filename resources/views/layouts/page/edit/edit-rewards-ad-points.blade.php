@extends('layouts.app')

@section('title', 'Edit RewardsAdPoints')

@push('style')
@endpush

@section('content')
    <div class="main-content">
        <form autocomplete="off" id="editRewardsAdPointsForm">
            @csrf
            <div class="card rounded rounded-4 shadow">
                <div class="card-header text-dark fw-bold d-flex justify-content-between align-items-center mt-2">
                    <div class="h5 fw-bold">Edit RewardsAdPoints</div>
                   <a href="{{ route('deleteRewardsAdPoints', $mRewardsAdPoints->id) }}" class="btn btn-danger btn-sm fw-bold shadow-none rounded rounded-1" ><i class="fas fa-trash"></i></a>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="rewards_ad_points_id" class="form-label">
                            <span class="text-primary font-weight-bold">REWARDS AD POINT ID</span>
                        </label>
                        <input name="rewards_ad_points_id" type="text" class="form-control input-lg fw-bold" id="rewards_ad_points_id"
                            value="{{ $mRewardsAdPoints->id }}" readonly>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="title" class="form-label">
                                    <span class="text-primary font-weight-bold">Nama RewardsAdPoints</span>
                                </label>
                                <input name="title" type="text" class="form-control input-lg fw-bold"
                                    id="title" value="{{ $mRewardsAdPoints->title }}" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="point_value" class="form-label">
                                    <span class="text-primary font-weight-bold">Point Didapat</span>
                                </label>
                                <input name="point_value" type="number" class="form-control input-lg fw-bold"
                                    id="point_value" value="{{ $mRewardsAdPoints->point_value }}" step="1" min="1"
                                    required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="point_number" class="form-label">
                                    <span class="text-primary font-weight-bold">Urutan RewardsAdPoints</span>
                                </label>
                                <input name="point_number" type="number" class="form-control input-lg fw-bold"
                                    id="point_number" value="{{ $mRewardsAdPoints->point_number }}" step="1" min="1"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="watch_ads_value" class="form-label">
                                    <span class="text-primary font-weight-bold">Jumlah Nonton Iklan</span>
                                </label>
                                <input name="watch_ads_value" type="number" class="form-control input-lg fw-bold"
                                    id="watch_ads_value" value="{{ $mRewardsAdPoints->watch_ads_value }}" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="time_claimed" class="form-label">
                                    <span class="text-primary font-weight-bold">Waktu detik setelah klaim</span>
                                </label>
                                <input name="time_claimed" type="number" step="1" min="1"
                                    class="form-control input-lg fw-bold" id="time_claimed"
                                    value="{{ $mRewardsAdPoints->time_claimed }}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary fw-bold">SIMPAN</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script type="module">
        $('#editRewardsAdPointsForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ route('editRewardsAdPoints') }}",
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                Swal.fire({
                    icon: "success",
                    title: "BERHASIL!",
                    text: response.message
                });
            },
            error: function(xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: xhr.responseText
                });
            }
        });
    });
    </script>
@endpush
