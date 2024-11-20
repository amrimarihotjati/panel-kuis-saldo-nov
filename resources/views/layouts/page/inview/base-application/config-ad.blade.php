@extends('layouts.app')

@section('title', 'Config Ad')

@push('style')

@endpush

@section('content')
<div class="main-content">
	<div class="card p-3 rounded rounded-4 shadow">
		<h5 class="text-center p-3 m-2">EDIT CONFIG AD</h5>
		<nav>
			<div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
				<button class="nav-link fw-semibold h5 active" id="nav-ad-flowads-tab" data-bs-toggle="tab" data-bs-target="#nav-ad-flowads" type="button" role="tab" aria-controls="nav-ad-flowads" aria-selected="true">FLOW ADS</button>

				<button class="nav-link fw-semibold h5" id="nav-ad-vungle-tab" data-bs-toggle="tab" data-bs-target="#nav-ad-vungle" type="button" role="tab" aria-controls="nav-ad-vungle" aria-selected="true">VUNGLE</button>

				<button class="nav-link fw-semibold h5" id="nav-ad-applovinmax-tab" data-bs-toggle="tab" data-bs-target="#nav-ad-applovinmax" type="button" role="tab" aria-controls="nav-ad-applovinmax" aria-selected="false">APPLOVINMAX</button>

				<button class="nav-link fw-semibold h5" id="nav-ad-new-applovinmax-tab" data-bs-toggle="tab" data-bs-target="#nav-ad-new-applovinmax" type="button" role="tab" aria-controls="nav-ad-new-applovinmax" aria-selected="false">NEW APPLOVINMAX</button>

				<button class="nav-link fw-semibold h5" id="nav-ad-yandex-tab" data-bs-toggle="tab" data-bs-target="#nav-ad-yandex" type="button" role="tab" aria-controls="nav-ad-yandex" aria-selected="false">YANDEX</button>

			</div>
		</nav>
		<div class="tab-content p-4 border" style="background-color:#EFEFEF;" id="nav-tabContent">
			<div class="tab-pane fade active show" id="nav-ad-flowads" role="tabpanel" aria-labelledby="nav-ad-flowads-tab">
				@include('layouts/page/edit/base-application/ads/flowads-input')
			</div>

			<div class="tab-pane fade show" id="nav-ad-vungle" role="tabpanel" aria-labelledby="nav-ad-vungle-tab">
				@include('layouts/page/edit/base-application/ads/vungle-input')
			</div>

			<div class="tab-pane fade" id="nav-ad-applovinmax" role="tabpanel" aria-labelledby="nav-ad-applovinmax-tab">
				@include('layouts/page/edit/base-application/ads/applovinmax-input')
			</div>

			<div class="tab-pane fade" id="nav-ad-new-applovinmax" role="tabpanel" aria-labelledby="nav-ad-new-applovinmax-tab">
				@include('layouts/page/edit/base-application/ads/new-applovinmax-input')
			</div>

			<div class="tab-pane fade" id="nav-ad-yandex" role="tabpanel" aria-labelledby="nav-ad-yandex-tab">
				@include('layouts/page/edit/base-application/ads/yandex-input')
			</div>

		</div>
	</div>
</div>
@endsection

@push('scripts')
<script type="module">
	$('#saveConfigAdsFlow').on('submit', function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			url: "{{ route('saveConfigAdsFlow') }}",
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

	$('#saveConfigAdsVungle').on('submit', function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			url: "{{ route('saveConfigAdsVungle') }}",
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

	$('#saveConfigAdsApplovinmax').on('submit', function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			url: "{{ route('saveConfigAdsApplovinmax') }}",
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

	$('#saveConfigAdsNewApplovinmax').on('submit', function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			url: "{{ route('saveConfigAdsNewApplovinmax') }}",
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

	$('#saveConfigAdsYandex').on('submit', function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			url: "{{ route('saveConfigAdsYandex') }}",
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
