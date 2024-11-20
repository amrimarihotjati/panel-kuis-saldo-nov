<div class="container">
	 <form autocomplete="off" id="saveSecondarySettings">
     @csrf
	<div class="row">
		<div class="col-md-12">
			<div class="mb-3">
				<label for="app_id" class="form-label fw-semibold text-muted">APP ID</label>
				<input type="text" class="form-control" name="app_id" id="app_id" value="{{ $mBaseApplication->id }}" required readonly>
			</div>
		</div>
		<div class="col-md-4">
			<div class="mb-3">
				<label for="app_pkg_secondary" class="form-label fw-semibold text-muted">APP PKG</label>
				<input type="text" class="form-control" name="app_pkg_secondary" id="app_pkg_secondary" value="{{ $mBaseApplication->app_pkg_secondary }}" required>
			</div>
		</div>
		<div class="col-md-4">
			<div class="mb-3">
				<label for="app_secondary_code" class="form-label fw-semibold text-muted">APP CODE</label>
				<input type="number" step="1" min="1" class="form-control" name="app_secondary_code" id="app_secondary_code" value="{{ $mBaseApplication->app_secondary_code }}" required>
			</div>
		</div>
		<div class="col-md-4">
			<div class="mb-3">
				<label for="app_secondary_access_key" class="form-label fw-semibold text-muted">APP ACCESS KEY</label>
				<input type="text" class="form-control" name="app_secondary_access_key" id="app_secondary_access_key" value="{{ $mBaseApplication->app_secondary_access_key }}" required readonly>
			</div>
		</div>
		<div class="col-md-12">
			<div class="mb-3 mt-3">
				<button type="submit" class="fw-bold shadow-none btn btn-primary w-100">SIMPAN</button>
			</div>
		</div>
	</div>
</form>
</div>
