@extends('layouts.app')

@section('title', 'Completed Quiz')

@push('style')
@endpush

@section('content')
    <div class="main-content">
        <div class="card rounded rounded-4 shadow">
            <div class="card-header text-dark fw-bold d-flex justify-content-between align-items-center mt-2">
                <div class="h5 fw-bold">Completed Quiz Player<br>
                    <span class="h6 fw-semibold text-muted">package : {{ $mBaseApplication->app_pkg }}</span>
                </div>
                <div class="h5 fw-bold">
                    <button type="button" class="btn btn-danger btn-sm fw-bold no-shadow rounded rounded-1"
                        id="resetCompletedQuiz"><i class="fas fa-sync-alt fa-sm"></i> RESET SEMUA DATA</button>
                </div>
            </div>
            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                        <button class="nav-link fw-semibold h4 active" id="nav-all-completed-quiz-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-all-completed-quiz" type="button" role="tab"
                            aria-controls="nav-all-completed-quiz" aria-selected="true">Completed Quiz</button>
                        <button class="nav-link fw-semibold h4" id="nav-per-category-completed-quiz-tab"
                            data-bs-toggle="tab" data-bs-target="#nav-per-category-completed-quiz" type="button"
                            role="tab" aria-controls="nav-per-category-completed-quiz" aria-selected="true">Category
                            Quiz</button>
                    </div>
                </nav>
                <div class="tab-content p-2 border" id="nav-tabContent">
                    <div class="tab-pane fade active show" id="nav-all-completed-quiz" role="tabpanel"
                        aria-labelledby="nav-all-completed-quiz-tab">
                        <div class="table-responsive">
                            <table id="dtQuizCompletedPlayer" class="table table-bordered table-flush" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="align-middle text-center">#</th>
                                        <th class="align-middle">Player</th>
                                        <th class="align-middle">Kategori Kuis Selesai</th>
                                        <th class="align-middle">With 50%</th>
                                        <th class="align-middle">Waktu Diperoleh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-per-category-completed-quiz" role="tabpanel"
                        aria-labelledby="nav-per-category-completed-quiz-tab">
                        <div class="table-responsive">
                            <table id="dtCategoryQuiz" class="table table-bordered table-flush" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="align-middle text-center">#</th>
                                        <th class="align-middle">Kategori</th>
                                        <th class="align-middle"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script type="module">
            $('#dtQuizCompletedPlayer').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('list-quiz-completed-player', $mBaseApplication->app_pkg) }}",
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
                        data: 'player.name',
                        name: 'player.name',
                        orderable: false,
                        className: 'align-middle',
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
                        data: 'category_id',
                        name: 'category_id',
                        searchable: false,
                        className: 'align-middle',
                        render: function(data, type, full, meta) {
                            var catQuiz = full.category_quiz;
                            var imageUrl = catQuiz && catQuiz.category_image ? catQuiz.category_image :
                                '/img/image_holder.png';
                            var categoryName = catQuiz ? catQuiz.category_name : 'Unknown';

                            return '<div class="d-flex align-items-center align-middle">' +
                                '<img src="' + imageUrl +
                                '" alt="" class="img-fluid img-thumbnail border border-secondary border-3" style="width:40px;height:40px; margin-right: 10px;">' +
                                '<div>' +
                                '<span class="fw-bold">' + categoryName + '</span></br>' +
                                '<small class="fw-bold">Level Kuis : ' + full.category_level + '</small></br>' +
                                '</div>' +
                                '</div>';
                        }
                    },
                    {
                        data: 'is_use_completed',
                        name: 'is_use_completed',
                        searchable: false,
                        className: 'align-middle text-center',
                        render: function(data, type, full, meta) {
                            var dataCompletedOption = full.is_use_completed;
                            var result = 'unknown';
                            if (dataCompletedOption === 1) {
                                result = '<small class="badge rounded-pill bg-primary fw-bold">YA</small>';
                            } else {
                                result =
                                    '<small class="badge rounded-pill bg-light text-muted  fw-bold">TIDAK</small>';
                            }
                            return result;
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        searchable: false,
                        className: 'align-middle text-center',
                        render: function(data, type, full, meta) {
                            return '<span class="fw-bold text-muted">' + full.created_at + '</span>';
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
        </script>
        <script>
            $(document).ready(function() {
                $('#resetCompletedQuiz').on('click', function() {
                    Swal.fire({
                        title: 'Reset Completed Quiz?',
                        html: "Reset semua data completed kuis <br> package : {{ $mBaseApplication->app_pkg }}",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Batalkan'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var form_data = new FormData();
                            form_data.append('app_pkg', "{{ $mBaseApplication->app_pkg }}");
                            var csrf_token = $('meta[name="csrf-token"]').attr('content');
                            Swal.fire({
                                title: 'Sedang Mereset...',
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
                                url: "{{ route('resetAllCompletedFromPackage') }}",
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
                                    var dataTable = $('#dtQuizCompletedPlayer').DataTable();
                                    dataTable.ajax.reload();
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
            });
            $(document).ready(function() {
                const initDataCategoryQuiz = () => {
                    $('#dtCategoryQuiz').DataTable({
                        processing: true,
                        serverSide: true,
                        searching: false,
                        ajax: {
                            url: '{{ route('getDTCategoryQuiz', $mBaseApplication->app_pkg) }}',
                            type: 'GET',
                            dataSrc: function(json) {
                                return json.data;
                            }
                        },
                        aLengthMenu: [
                            [-1],
                            ["Semua"]
                        ],
                        iDisplayLength: -1,
                        columns: getColumns(),
                        language: getLanguageSettings(),
                        initComplete: function(settings, json) {

                        }
                    });
                };

                const getColumns = () => {
                    return [{
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + 1;
                            },
                            orderable: false,
                            searchable: false,
                            className: 'align-middle text-center text-muted'
                        },
                        {
                            data: 'category_name',
                            name: 'category_name',
                            className: 'align-middle',
                            render: renderCategory
                        },
                        {
                            data: null,
                            name: null,
                            orderable: false,
                            className: 'align-middle text-center',
                            render: function(data, type, full, meta) {
                                return '<div class="text-center align-middle">' +
                                    '<a class="btn btn-dark btn-sm ps-2 pe-2 fw-semibold shadow-none reset-quiz" ' +
                                    'data-player-pkg="' + full.player_pkg + '" data-id="' + full.id + '">' +
                                    '<i class="fas fa-sync-alt fa-sm"></i></a>' +
                                    '</div>';
                            }
                        }
                    ];
                };

                const renderCategory = function(data, type, full, meta) {
                    const icon =
                        `<img src="${full.category_image}" alt="" class="border border-secondary rounded border-2"
                    style="width:35px;height:35px; margin-right: 10px;">`;
                    const title = `<p class="h6 fw-bold mb-0">${full.category_name}</p>`;
                    return `
                <div class="d-flex align-items-center">
                    ${icon}
                    <div>${title}</div>
                </div>
                `;
                };

                const getLanguageSettings = () => {
                    return {
                        "paginate": {
                            "first": "Pertama",
                            "last": "Terakhir",
                            "next": "Lanjut",
                            "previous": "Kembali"
                        },
                        "emptyTable": "Tidak Ada data",
                        "info": "",
                        "infoEmpty": "",
                        "infoFiltered": "",
                        "lengthMenu": "",
                        "search": "",
                        "zeroRecords": "Tidak ditemukan"
                    };
                };

                initDataCategoryQuiz();
            });

            $(document).on('click', '.reset-quiz', function(e) {
                e.preventDefault();
                const playerPkg = $(this).data('player-pkg');
                const categoryId = $(this).data('id');

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah yakin ingin mereset completed kuis ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya, reset!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menghapus data...',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            onBeforeOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: '/reset-completed-quiz-selected/' + playerPkg + '/' + categoryId,
                            type: 'GET',
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message,
                                    showConfirmButton: true
                                });
                                $('#dtCategoryQuiz').DataTable().ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: xhr.responseJSON.message ||
                                        'Terjadi kesalahan saat mereset kuis.',
                                    showConfirmButton: true
                                });
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
