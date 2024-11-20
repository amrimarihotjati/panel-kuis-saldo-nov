@extends('layouts.app')

@section('title', 'Edit Player')

@push('style')
@endpush

@section('content')
    <div class="main-content">
        <form autocomplete="off" id="editPlayerForm">
            @csrf
            <div class="card rounded rounded-4 shadow">
                <div class="card-header text-dark fw-bold mt-2 d-flex justify-content-between align-items-center">
                    <div class="h5 fw-bold">Edit Player</div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('deletePlayer', $mPlayer->id) }}"
                            class="btn btn-danger btn-sm fw-bold shadow-none rounded rounded-1"><i
                                class="fas fa-trash"></i></a>
                        <div>
                            <a href="#" id="forceEditPlayerPassword"
                                class="btn btn-dark btn-sm fw-bold shadow-none rounded rounded-1 ms-2"><i
                                    class="fas fa-key fa-sm"></i> RESET PASSWORD</a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-5">
                    <input type="hidden" name="player_id" value="{{ $mPlayer->id }}">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    <span class="text-primary fw-bold">Nama Player</span>
                                </label>
                                <input name="name" type="text" class="form-control input-lg fw-bold" id="name"
                                    value="{{ $mPlayer->name }}" required />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <span class="text-primary fw-bold">Email</span>
                                </label>
                                <input name="email" type="text" class="form-control input-lg fw-bold" id="email"
                                    value="{{ $mPlayer->email }}" readonly required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="player_pkg" class="form-label">
                                    <span class="text-primary fw-bold">Player Package</span>
                                </label>
                                <input name="player_pkg" type="text" class="form-control input-lg fw-bold"
                                    id="player_pkg" value="{{ $mPlayer->player_pkg }}" readonly required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="score" class="form-label">
                                    <span class="text-primary fw-bold">Score</span>
                                </label>
                                <input name="score" type="number" class="form-control input-lg fw-bold" id="score"
                                    value="{{ $mPlayer->score }}" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="points" class="form-label">
                                    <span class="text-primary fw-bold">Points</span>
                                </label>
                                <input name="points" type="number" class="form-control input-lg fw-bold" id="points"
                                    value="{{ $mPlayer->points }}" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="points_collected" class="form-label">
                                    <span class="text-primary fw-bold">Points Collected</span>
                                </label>
                                <input name="points_collected" type="number" class="form-control input-lg fw-bold"
                                    id="points_collected" value="{{ $mPlayer->points_collected }}" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="referral_code" class="form-label">
                                    <span class="text-primary fw-bold">Refferal Code</span>
                                </label>
                                <input name="referral_code" type="text" class="form-control input-lg fw-bold"
                                    id="referral_code" value="{{ $mPlayer->referral_code }}" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="device_name" class="form-label">
                                    <span class="text-primary fw-bold">Device Name</span>
                                </label>
                                <input name="device_name" type="text" class="form-control input-lg fw-bold"
                                    id="device_name" value="{{ $mPlayer->device_name }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="device_id" class="form-label">
                                    <span class="text-primary fw-bold">Device ID</span>
                                </label>
                                <input name="device_id" type="text" class="form-control input-lg fw-bold"
                                    id="device_id" value="{{ $mPlayer->device_id }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="token" class="form-label">
                                    <span class="text-primary fw-bold">Player Token</span>
                                </label>
                                <input name="token" type="text" class="form-control input-lg fw-bold"
                                    id="token" value="{{ $mPlayer->token }}" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="real_player" class="form-label">
                                    <span class="text-primary fw-bold">Real Player</span>
                                </label>
                                <select class="form-control fw-bold" id="real_player" name="real_player" required>
                                    <option value="0" @if ($mPlayer->real_player == 0) selected @endif>BOT
                                    </option>
                                    <option value="1" @if ($mPlayer->real_player == 1) selected @endif>REAL
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">
                                    <span class="text-primary fw-bold">Status Player</span>
                                </label>
                                <select class="form-control fw-bold" id="status" name="status" required>
                                    <option value="0" @if ($mPlayer->status == 0) selected @endif>NORMAL
                                    </option>
                                    <option value="1" @if ($mPlayer->status == 1) selected @endif>WARNING
                                    </option>
                                    <option value="2" @if ($mPlayer->status == 2) selected @endif>BANNED
                                    </option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary fw-bold">SIMPAN</button>
                </div>
            </div>
        </form>

        <form autocomplete="off" id="giftPlayerPointForm">
            @csrf
            <div class="card rounded rounded-4 shadow p-3">
                <div class="card-header text-dark fw-bold mt-2 d-flex justify-content-between align-items-center">
                    <div class="h5 fw-bold">Gift Point</div>
                </div>
                <div class="card-body">
                    <input type="hidden" name="player_id" value="{{ $mPlayer->id }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    <span class="text-primary fw-bold">Nama Player</span>
                                </label>
                                <input name="name" type="text" class="form-control input-lg fw-bold"
                                    id="name" value="{{ $mPlayer->name }}" required readonly />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="gift_point" class="form-label">
                                    <span class="text-primary fw-bold">Jumlah Point</span>
                                </label>
                                <input name="gift_point" type="number" value="0"
                                    class="form-control input-lg fw-bold" id="gift_point" required />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary fw-bold">KIRIM</button>
                </div>
            </div>
        </form>

        <form autocomplete="off" id="giftPlayerBadgeForm">
            @csrf
            <div class="card rounded rounded-4 shadow p-3">
                <div class="card-header text-dark fw-bold mt-2 d-flex justify-content-between align-items-center">
                    <div class="h5 fw-bold">Gift Badge</div>
                </div>
                <div class="card-body">
                    <input type="hidden" name="player_id" value="{{ $mPlayer->id }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    <span class="text-primary fw-bold">Nama Player</span>
                                </label>
                                <input name="name" type="text" class="form-control input-lg fw-bold"
                                    id="name" value="{{ $mPlayer->name }}" required readonly />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="badge" class="form-label">
                                    <span class="text-primary fw-bold">Badge Dipilih</span>
                                </label>
                                <select name="badge_id" id="badge" class="form-control input-lg fw-bold" required>
                                    <option value="" disabled selected>Pilih Badge</option>
                                    @foreach ($badgeListPublic as $badge)
                                        <option value="{{ $badge->id }}">
                                            {{ $badge->badge_name }} - Level : {{ $badge->badge_level }} - Price :
                                            {{ $badge->badge_price }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary fw-bold">KIRIM</button>
                </div>
            </div>
        </form>

        <div class="card rounded rounded-4 shadow p-4">
            <div class="card-header text-dark fw-bold d-flex justify-content-between align-items-center mt-2">
                <div class="h5 fw-bold">Koleksi Badge<br>
                    <span class="h6 fw-semibold text-dark">Badge Utama :</span>
                    <span class="h6 fw-bolder text-primary">{{ $mBadgePrimary->badge_name }}</span>
                    <br>
                    <span class="h6 fw-semibold text-dark">Badge Level :</span>
                    <span class="h6 fw-bolder text-primary">{{ $mBadgePrimary->badge_level }}</span>
                    <br>
                    <span class="h6 fw-semibold text-dark">Harga Badge :</span>
                    <span class="h6 fw-bolder text-primary">{{ $mBadgePrimary->badge_price }} Points</span>
                    <br>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dtBadgeOnPlayer" class="table table-bordered table-flush" style="width:100%">
                        <thead>
                            <tr>
                                <th class="align-middle text-center">#</th>
                                <th class="align-middle"></th>
                                <th class="align-middle">Nama Koleksi Badge</th>
                                <th class="align-middle text-center">Level</th>
                                <th class="align-middle text-center">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mBadgeListWithCount as $index => $badge)
                                <tr>
                                    <td class="align-middle text-center">{{ $index + 1 }}</td>
                                    <td class="align-middle text-center">
                                        <img src="{{ $badge->badge_icon }}" class="img-fluid img-thumbnail"
                                            style="width:40px;height:40px;margin-right:6dp">
                                    </td>
                                    <td class="align-middle"><span class="h6 fw-semibold">{{ $badge->badge_name }}</span>
                                    </td>
                                    <td class="align-middle text-center"><span
                                            class="h6 fw-bolder">{{ $badge->badge_level }}</span></td>
                                    <td class="align-middle text-center"><span
                                            class="h6 fw-bolder">{{ $badge->count }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script type="module">
        $('#editPlayerForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('editPlayer') }}",
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

    <script>
        $(document).ready(function() {
            $('#forceEditPlayerPassword').on('click', function() {
                var newPassword;
                Swal.fire({
                    title: 'UBAH PASSWORD',
                    html: 'Masukan password baru untuk email <br> <b>{{ $mPlayer->email }}</b>',
                    input: "password",
                    inputAttributes: {
                        autocapitalize: "off"
                    },
                    inputValidator: (value) => {
                        if (!value) {
                            return "Password tidak boleh kosong";
                        } else {
                            newPassword = value;
                        }
                    },
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0276FC',
                    cancelButtonColor: '#BDBDBD',
                    confirmButtonText: 'SIMPAN',
                    cancelButtonText: 'BATALKAN'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form_data = new FormData();
                        form_data.append('player_id', "{{ $mPlayer->id }}");
                        form_data.append('player_password', newPassword);
                        console.log(newPassword);
                        var csrf_token = $('meta[name="csrf-token"]').attr('content');
                        Swal.fire({
                            title: 'Sedang Mengubah password...',
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
                            url: "{{ route('forceEditPasswordPlayer') }}",
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
            $('#dtBadgeOnPlayer').DataTable({
                "paging": true,
                "searching": true,
                "ordering": false,
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
                    "search": "",
                    "zeroRecords": "Tidak ditemukan",
                }
            });
        });

        $('#giftPlayerPointForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('giftPoint') }}",
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

        $('#giftPlayerBadgeForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('giftBadge') }}",
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
                    window.location.reload();
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

        document.addEventListener('DOMContentLoaded', function() {
            var form = document.querySelector('form');
            form.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                }
            });
        });
    </script>
@endpush
