<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-523/dist/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/skins/reverse.css') }}">
    <link rel="stylesheet" href="{{ asset('library/izitoast/dist/css/iziToast.min.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.datatables.net/2.1.2/css/dataTables.bootstrap5.css" rel="stylesheet">
    <link
        href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.1.6/b-3.1.2/b-colvis-3.1.2/b-html5-3.1.2/b-print-3.1.2/fc-5.0.1/fh-4.0.1/sl-2.1.0/datatables.min.css"
        rel="stylesheet">

    <link href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }}</title>
    @vite('resources/css/app.css')

</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            @include('components.header')
            @include('components.sidebar')
            @yield('content')
            @include('components.footer')
        </div>
    </div>
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('library/tooltip.js/dist/umd/tooltip.js') }}"></script>
    <script src="{{ asset('library/bootstrap-523/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>

    <script src="{{ asset('library/bootstrap-daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/izitoast/dist/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.min.js') }}"></script>

    @stack('scripts')
    <script type="module">
        var clipboard = new ClipboardJS('.btn');
        clipboard.on('success', function(e) {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: "Payment copied to clipboard"
            });
        });
        clipboard.on('error', function(e) {

        });
    </script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="https:////cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.2/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script
        src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.1.6/b-3.1.2/b-colvis-3.1.2/b-html5-3.1.2/b-print-3.1.2/fc-5.0.1/fh-4.0.1/sl-2.1.0/datatables.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.html5.min.js"></script>
    @vite('resources/js/app.js')
</body>

</html>
