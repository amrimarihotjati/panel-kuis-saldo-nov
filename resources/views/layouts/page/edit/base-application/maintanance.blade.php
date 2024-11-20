<div class="container">
	<form autocomplete="off" id="saveMaintananceSettings">
		@csrf
		<input type="hidden" class="form-control" name="app_id" id="app_id" value="{{ $mBaseApplication->id }}" required>
		<div class="row">
			<div class="col-md-6">
				<div class="mb-3">
					<label for="app_msg_maintanance" class="form-label fw-semibold text-muted">App maintanance message</label>
					<input type="text" class="form-control" name="app_msg_maintanance" id="app_msg_maintanance" value="{{ $mBaseApplication->app_msg_maintanance }}">
				</div>
			</div>
			<div class="col-md-6">
				<div class="mb-3">
					<label for="app_is_maintanance" class="form-label text-muted fw-semibold">Allow external App</label>
					<select class="form-control fw-bold" id="app_is_maintanance" name="app_is_maintanance">
						<option value="0" @if ($mBaseApplication->app_is_maintanance == 0) selected @endif>Tidak
						</option>
						<option value="1" @if ($mBaseApplication->app_is_maintanance == 1) selected @endif>Aktif
						</option>
					</select>
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
