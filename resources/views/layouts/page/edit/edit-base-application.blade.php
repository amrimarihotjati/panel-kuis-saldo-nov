@extends('layouts.app')

@section('title', 'Edit Base Application')

@push('style')

@endpush

@section('content')
<div class="main-content">
	<div class="card p-3 rounded rounded-4 shadow">
		<h5 class="text-center p-3 m-2">EDIT BASE APPLICATION</h5>
		<nav>
			<div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
				<button class="nav-link fw-semibold h5 active" id="nav-main-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-main-settings" type="button" role="tab" aria-controls="nav-main-settings" aria-selected="true">Main</button>

				<button class="nav-link fw-semibold h5" id="nav-secondary-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-secondary-settings" type="button" role="tab" aria-controls="nav-secondary-settings" aria-selected="false">Secondary</button>

				<button class="nav-link fw-semibold h5" id="nav-external-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-external-settings" type="button" role="tab" aria-controls="nav-external-settings" aria-selected="false">External</button>

				<button class="nav-link fw-semibold h5" id="nav-maintanance-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-maintanance-settings" type="button" role="tab" aria-controls="nav-maintanance-settings" aria-selected="false">Maintanance</button>

				<button class="nav-link fw-semibold h5" id="nav-component-daget-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-component-daget-settings" type="button" role="tab" aria-controls="nav-component-daget-settings" aria-selected="false">Dana Kaget</button>

				<button class="nav-link fw-semibold h5" id="nav-component-rewardsadpoint-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-component-rewardsadpoint-settings" type="button" role="tab" aria-controls="nav-component-rewardsadpoint-settings" aria-selected="false">Rewards Ad Point</button>

				<button class="nav-link fw-semibold h5" id="nav-component-catquiz-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-component-catquiz-settings" type="button" role="tab" aria-controls="nav-component-catquiz-settings" aria-selected="false">Kategori Kuis</button>

				<button class="nav-link fw-semibold h5" id="nav-component-banner-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-component-banner-settings" type="button" role="tab" aria-controls="nav-component-banner-settings" aria-selected="false">Banner</button>

				<button class="nav-link fw-semibold h5" id="nav-component-badge-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-component-badge-settings" type="button" role="tab" aria-controls="nav-component-badge-settings" aria-selected="false">Badge</button>

				<button class="nav-link fw-semibold h5" id="nav-menu-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-menu-settings" type="button" role="tab" aria-controls="nav-menu-settings" aria-selected="false">Menu Setting</button>
				
			</div>
		</nav>
		<div class="tab-content p-3 border" style="background-color:#FDFDFD;" id="nav-tabContent">
			<div class="tab-pane fade active show" id="nav-main-settings" role="tabpanel" aria-labelledby="nav-main-settings-tab">
				@include('layouts/page/edit/base-application/main')
			</div>

			<div class="tab-pane fade" id="nav-secondary-settings" role="tabpanel" aria-labelledby="nav-secondary-settings-tab">
				@include('layouts/page/edit/base-application/secondary')
			</div>

			<div class="tab-pane fade" id="nav-external-settings" role="tabpanel" aria-labelledby="nav-external-settings-tab">
				@include('layouts/page/edit/base-application/external')
			</div>

			<div class="tab-pane fade" id="nav-maintanance-settings" role="tabpanel" aria-labelledby="nav-maintanance-settings-tab">
				@include('layouts/page/edit/base-application/maintanance')
			</div>

			<div class="tab-pane fade" id="nav-component-daget-settings" role="tabpanel" aria-labelledby="nav-component-daget-settings-tab">
				@include('layouts/page/edit/base-application/component-daget')
			</div>

			<div class="tab-pane fade" id="nav-component-rewardsadpoint-settings" role="tabpanel" aria-labelledby="nav-component-rewardsadpoint-settings-tab">
				@include('layouts/page/edit/base-application/component-rewards-ad-point')
			</div>

			<div class="tab-pane fade" id="nav-component-catquiz-settings" role="tabpanel" aria-labelledby="nav-component-catquiz-settings-tab">
				@include('layouts/page/edit/base-application/component-category-quiz')
			</div>

			<div class="tab-pane fade" id="nav-component-banner-settings" role="tabpanel" aria-labelledby="nav-component-banner-settings-tab">
				@include('layouts/page/edit/base-application/component-banner')
			</div>

			<div class="tab-pane fade" id="nav-component-badge-settings" role="tabpanel" aria-labelledby="nav-component-badge-settings-tab">
				@include('layouts/page/edit/base-application/component-badge')
			</div>

			<div class="tab-pane fade" id="nav-menu-settings" role="tabpanel" aria-labelledby="nav-menu-settings-tab">
				@include('layouts/page/edit/base-application/menu-settings')
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script type="module">
	$('#saveMainSettings').on('submit', function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			url: "{{ route('saveMainSettings') }}",
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

	$('#saveSecondarySettings').on('submit', function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			url: "{{ route('saveSecondarySettings') }}",
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

	$('#saveExternalSettings').on('submit', function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			url: "{{ route('saveExternalSettings') }}",
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

	$('#saveMaintananceSettings').on('submit', function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			url: "{{ route('saveMaintananceSettings') }}",
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

	$('#saveAddDagetSettings').on('submit', function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			url: "{{ route('saveAddDagetSettings') }}",
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

	$('#saveAddRewardsAdPointsSettings').on('submit', function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			url: "{{ route('saveAddRewardsAdPointsSettings') }}",
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

	$('#saveAddCategoryQuizSettings').on('submit', function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			url: "{{ route('saveAddCategoryQuizSettings') }}",
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

	$('#saveAddBannerSettings').on('submit', function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			url: "{{ route('saveAddBannerSettings') }}",
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

	$('#saveAddBadgeSettings').on('submit', function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			url: "{{ route('saveAddBadgeSettings') }}",
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

	$('#saveMenuSettings').on('submit', function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			url: "{{ route('saveMenuSettings') }}",
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
