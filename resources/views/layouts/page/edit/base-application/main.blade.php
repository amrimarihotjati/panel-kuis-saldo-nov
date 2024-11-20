<div class="container">
	<form autocomplete="off" id="saveMainSettings">
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
				<label for="app_pkg" class="form-label fw-semibold text-muted">APP PKG</label>
				<input type="text" class="form-control" name="app_pkg" id="app_pkg" value="{{ $mBaseApplication->app_pkg }}" required readonly>
			</div>
		</div>
		<div class="col-md-4">
			<div class="mb-3">
				<label for="app_code" class="form-label fw-semibold text-muted">APP CODE</label>
				<input type="number" step="1" min="1" name="app_code" class="form-control" id="app_code" value="{{ $mBaseApplication->app_code }}" required>
			</div>
		</div>
		<div class="col-md-4">
			<div class="mb-3">
				<label for="app_access_key" class="form-label fw-semibold text-muted">APP ACCESS KEY</label>
				<input type="text" class="form-control" name="app_access_key" id="app_access_key" value="{{ $mBaseApplication->app_access_key }}" required readonly>
			</div>
		</div>
		<div class="col-md-6">
			<div class="mb-3">
				<label for="app_url_redirect" class="form-label fw-semibold text-muted">APP REDIRECT URL</label>
				<input type="text" class="form-control" name="app_url_redirect" id="app_url_redirect" value="{{ $mBaseApplication->app_url_redirect }}" required>
			</div>
		</div>

		<div class="col-md-6">
			<div class="mb-3">
				<label for="app_is_redirect" class="form-label text-muted fw-semibold">APP REDIRECT TO SECONDARY</label>
				<select class="form-control fw-bold" id="app_is_redirect" name="app_is_redirect">
					<option value="0" @if ($mBaseApplication->app_is_redirect == 0) selected @endif>Tidak
					</option>
					<option value="1" @if ($mBaseApplication->app_is_redirect == 1) selected @endif>Aktif
					</option>
				</select>
			</div>
		</div>
		
		<div class="col-md-6">
			<div class="mb-3">
				<label for="settings_menu_wd_pending" class="form-label text-muted fw-semibold">SET PENDING WITHDRAW</label>
				<select class="form-control fw-bold" id="settings_menu_wd_pending" name="settings_menu_wd_pending">
					<option value="0" @if ($mBaseApplication->settings_menu_wd_pending == 0) selected @endif>Tidak
					</option>
					<option value="1" @if ($mBaseApplication->settings_menu_wd_pending == 1) selected @endif>Aktif
					</option>
				</select>
			</div>
		</div>

		<div class="col-md-6">
			<div class="mb-3">
				<label for="settings_menu_message_wd_pending" class="form-label fw-semibold text-muted">WITHDRAW PENDING MESSAGE</label>
				<input type="text" class="form-control" name="settings_menu_message_wd_pending" id="settings_menu_message_wd_pending" value="{{ $mBaseApplication->settings_menu_message_wd_pending }}">
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
