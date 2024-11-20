<div class="container">
	<form autocomplete="off" id="saveExternalSettings">
		@csrf
		<input type="hidden" class="form-control" name="app_id" id="app_id" value="{{ $mBaseApplication->id }}" required>
		<div class="row">
			<div class="col-md-4">
				<div class="mb-3">
					<label for="app_ext_pkg_name" class="form-label fw-semibold text-muted">App ext pkg</label>
					<input type="text" class="form-control" name="app_ext_pkg_name" id="app_ext_pkg_name" value="{{ $mBaseApplication->app_ext_pkg_name }}">
				</div>
			</div>
			<div class="col-md-4">
				<div class="mb-3">
					<label for="app_ext_pkg_access_key" class="form-label fw-semibold text-muted">App ext access key</label>
					<input type="text" class="form-control" name="app_ext_pkg_access_key" id="app_ext_pkg_access_key" value="{{ $mBaseApplication->app_ext_pkg_access_key }}" required readonly>
				</div>
			</div>
			<div class="col-md-4">
				<div class="mb-3">
					<label for="app_ext_pkg_allow_access" class="form-label text-muted fw-semibold">Allow external App</label>
					<select class="form-control fw-bold" id="app_ext_pkg_allow_access" name="app_ext_pkg_allow_access">
						<option value="0" @if ($mBaseApplication->app_ext_pkg_allow_access == 0) selected @endif>Tidak
						</option>
						<option value="1" @if ($mBaseApplication->app_ext_pkg_allow_access == 1) selected @endif>Aktif
						</option>
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<div class="mb-3">
					<label for="settings_menu_limit_time_claim_external" class="form-label text-muted fw-semibold">Difference External Claim Article Time</label>
					<input type="number" class="form-control" name="settings_menu_limit_time_claim_external" id="settings_menu_limit_time_claim_external" value="{{ $mBaseApplication->settings_menu_limit_time_claim_external }}" min="1" required>
				</div>
			</div>
			<div class="col-md-6">
				<div class="mb-3">
					<label for="settings_menu_limit_count_claim_external" class="form-label text-muted fw-semibold">Limit External Claim Article</label>
					<input type="number" class="form-control" name="settings_menu_limit_count_claim_external" id="settings_menu_limit_count_claim_external" value="{{ $mBaseApplication->settings_menu_limit_count_claim_external }}" min="1" required>
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
