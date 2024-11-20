<form autocomplete="off" id="saveConfigAdsVungle">
@csrf
<input type="hidden" class="form-control" name="app_id" id="app_id" value="{{ $mBaseApplication->id }}" required>
<div class="row">
	<div class="col-md-12">
		<div class="mb-3">
			<label for="vungle_app_id_or_sdk_key" class="form-label fw-bold text-primary">APP ID OR SDK KEY</label>
			<input type="text" class="form-control" name="vungle_app_id_or_sdk_key" id="vungle_app_id_or_sdk_key" value="{{ $mBaseApplication->vungle_app_id_or_sdk_key }}">
		</div>
	</div>
	<div class="col-md-6">
		<div class="mb-3">
			<label for="vungle_placement_banner" class="form-label fw-bold text-primary">BANNER</label>
			<input type="text" class="form-control" name="vungle_placement_banner" id="vungle_placement_banner" value="{{ $mBaseApplication->vungle_placement_banner }}">
		</div>
	</div>
	<div class="col-md-6">
		<div class="mb-3">
			<label for="vungle_placement_native" class="form-label fw-bold text-primary">NATIVE</label>
			<input type="text" class="form-control" name="vungle_placement_native" id="vungle_placement_native" value="{{ $mBaseApplication->vungle_placement_native }}">
		</div>
	</div>
	<div class="col-md-6">
		<div class="mb-3">
			<label for="vungle_placement_interstitial" class="form-label fw-bold text-primary">INTERSTITIAL</label>
			<input type="text" class="form-control" name="vungle_placement_interstitial" id="vungle_placement_interstitial" value="{{ $mBaseApplication->vungle_placement_interstitial }}">
		</div>
	</div>
	<div class="col-md-6">
		<div class="mb-3">
			<label for="vungle_placement_rewards" class="form-label fw-bold text-primary">REWARDS</label>
			<input type="text" class="form-control" name="vungle_placement_rewards" id="vungle_placement_rewards" value="{{ $mBaseApplication->vungle_placement_rewards }}">
		</div>
	</div>
	<div class="col-md-12">
		<div class="mb-3 mt-3">
			<button type="submit" class="fw-bold shadow-none btn btn-primary w-100">SIMPAN</button>
		</div>
	</div>
</div>
</form>