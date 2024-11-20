@extends('layouts.app')

@section('title', 'JOBSERVICES-COMPLETED-QUIZ')

@section('content')
<div class="main-content">
    <div class="card p-4">
        <div class="card-header h5 fw-bolder text-muted">
            Panel Settings
        </div>
        <div class="card-body pt-0">
            <form id="updateSettingList">
                @csrf
                <ul class="list-group">
                    @foreach($mPanelSettingList as $setting)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0 mt-2 fw-bolder">{{ $setting->name }}</h6>
                                    <p class="mb-1 text-muted fw-semibold">{{ $setting->description }}</p>
                                </div>
                                <div class="form-check form-switch form-control-lg">
                                    <input class="form-check-input" type="checkbox" id="setting-{{ $setting->id }}" name="settings[{{ $setting->id }}]" value="1" {{ $setting->status == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="setting-{{ $setting->id }}"></label>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary fw-bold btn-lg shadow-none btn-sm p-2">SIMPAN PERUBAHAN</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
 <script type="module">
        $('#updateSettingList').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ route('updateSettingList') }}",
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
