@extends('layouts.app')

@section('title', 'Edit Daget')

@push('style')
@endpush

@section('content')
    <div class="main-content">
        <form autocomplete="off" id="editDagetForm">
            @csrf
            <div class="card rounded rounded-4 shadow">
                <div class="card-header text-dark fw-bold d-flex justify-content-between align-items-center mt-2">
                    <div class="h5 fw-bold">Edit Daget</div>
                   <a href="{{ route('deleteDaget', $mDaget->id) }}" class="btn btn-danger btn-sm fw-bold shadow-none rounded rounded-1" ><i class="fas fa-trash"></i></a>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="daget_id" class="form-label">
                            <span class="text-primary font-weight-bold">DAGET ID</span>
                        </label>
                        <input name="daget_id" type="text" class="form-control input-lg fw-bold" id="daget_id"
                            value="{{ $mDaget->id }}" readonly>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="title" class="form-label">
                                    <span class="text-primary font-weight-bold">Nama Daget</span>
                                </label>
                                <input name="title" type="text" class="form-control input-lg fw-bold"
                                    id="title" value="{{ $mDaget->title }}" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="daget_number" class="form-label">
                                    <span class="text-primary font-weight-bold">Urutan Daget</span>
                                </label>
                                <input name="daget_number" type="number" class="form-control input-lg fw-bold"
                                    id="daget_number" value="{{ $mDaget->daget_number }}" step="1" min="1"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="url" class="form-label">
                                    <span class="text-primary font-weight-bold">Link Daget</span>
                                </label>
                                <input name="url" type="url" class="form-control input-lg fw-bold"
                                    id="url" value="{{ $mDaget->url }}" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="info_rupiah" class="form-label">
                                    <span class="text-primary font-weight-bold">Info Nominal (informasi)</span>
                                </label>
                                <input name="info_rupiah" type="number" class="form-control input-lg fw-bold"
                                    id="info_rupiah" value="{{ $mDaget->info_rupiah }}" required>
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
                                    id="watch_ads_value" value="{{ $mDaget->watch_ads_value }}" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="time_claimed" class="form-label">
                                    <span class="text-primary font-weight-bold">Waktu detik setelah klaim</span>
                                </label>
                                <input name="time_claimed" type="number" step="1" min="1"
                                    class="form-control input-lg fw-bold" id="time_claimed"
                                    value="{{ $mDaget->time_claimed }}" required>
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
        $('#editDagetForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ route('editDaget') }}",
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
