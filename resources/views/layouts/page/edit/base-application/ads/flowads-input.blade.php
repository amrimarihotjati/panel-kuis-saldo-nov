<form autocomplete="off" id="saveConfigAdsFlow">
	@csrf
	<input type="hidden" class="form-control" name="app_id" id="app_id" value="{{ $mBaseApplication->id }}" required>
	<div class="row">
		<div class="col-md-4">
			<div class="mb-3">
				<label for="settings_module_ads_first" class="form-label text-muted fw-semibold">MAIN ADS</label>
				<select class="form-control fw-bold" id="settings_module_ads_first" name="settings_module_ads_first">
					<option value="VUNGLE" @if ($mBaseApplication->settings_module_ads_first == "VUNGLE") selected @endif>VUNGLE
					</option>
					<option value="APPLOVINMAX" @if ($mBaseApplication->settings_module_ads_first == "APPLOVINMAX") selected @endif>APPLOVINMAX
					</option>
					<option value="YANDEX" @if ($mBaseApplication->settings_module_ads_first == "YANDEX") selected @endif>YANDEX
					</option>
				</select>
			</div>
		</div>
		<div class="col-md-4">
			<div class="mb-3">
				<label for="settings_module_ads_secondary" class="form-label text-muted fw-semibold">BACKUP ADS</label>
				<select class="form-control fw-bold" id="settings_module_ads_secondary" name="settings_module_ads_secondary">
					<option value="VUNGLE" @if ($mBaseApplication->settings_module_ads_secondary == "VUNGLE") selected @endif>VUNGLE
					</option>
					<option value="APPLOVINMAX" @if ($mBaseApplication->settings_module_ads_secondary == "APPLOVINMAX") selected @endif>APPLOVINMAX
					</option>
					<option value="YANDEX" @if ($mBaseApplication->settings_module_ads_secondary == "YANDEX") selected @endif>YANDEX
					</option>
				</select>
			</div>
		</div>
		<div class="col-md-4">
			<div class="mb-3">
				<label for="settings_module_ads_third" class="form-label text-muted fw-semibold">THIRDS ADS</label>
				<select class="form-control fw-bold" id="settings_module_ads_third" name="settings_module_ads_third">
					<option value="VUNGLE" @if ($mBaseApplication->settings_module_ads_third == "VUNGLE") selected @endif>VUNGLE
					</option>
					<option value="APPLOVINMAX" @if ($mBaseApplication->settings_module_ads_third == "APPLOVINMAX") selected @endif>APPLOVINMAX
					</option>
					<option value="YANDEX" @if ($mBaseApplication->settings_module_ads_third == "YANDEX") selected @endif>YANDEX
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