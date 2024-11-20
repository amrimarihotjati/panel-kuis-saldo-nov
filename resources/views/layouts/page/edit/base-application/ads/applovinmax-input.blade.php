<form autocomplete="off" id="saveConfigAdsApplovinmax">
@csrf
<input type="hidden" class="form-control" name="app_id" id="app_id" value="{{ $mBaseApplication->id }}" required>
<div class="row">
	<div class="col-md-12">
		<div class="mb-3">
			<label for="applovinmax_app_id_or_sdk_key" class="form-label fw-bold text-primary">APP ID OR SDK KEY</label>
			<input type="text" class="form-control" name="applovinmax_app_id_or_sdk_key" id="applovinmax_app_id_or_sdk_key" value="{{ $mBaseApplication->applovinmax_app_id_or_sdk_key }}">
		</div>
	</div>
	
	<div class="col-md-12">
	<h6 class="mb-4 mt-2 badge text-bg-secondary rounded rounded-1 opacity-50"># PLACEMENT WITH ECPM</h6>
	</div>
	
	<div class="col-md-6">
		<div class="mb-3">
			<label for="applovinmax_placement_banner" class="form-label fw-bold text-primary">BANNER</label>
			<input type="text" class="form-control" name="applovinmax_placement_banner" id="applovinmax_placement_banner" value="{{ $mBaseApplication->applovinmax_placement_banner }}">
		</div>
	</div>
	<div class="col-md-6">
		<div class="mb-3">
			<label for="applovinmax_placement_native" class="form-label fw-bold text-primary">NATIVE</label>
			<input type="text" class="form-control" name="applovinmax_placement_native" id="applovinmax_placement_native" value="{{ $mBaseApplication->applovinmax_placement_native }}">
		</div>
	</div>
	<div class="col-md-6">
		<div class="mb-3">
			<label for="applovinmax_placement_interstitial" class="form-label fw-bold text-primary">INTERSTITIAL</label>
			<input type="text" class="form-control" name="applovinmax_placement_interstitial" id="applovinmax_placement_interstitial" value="{{ $mBaseApplication->applovinmax_placement_interstitial }}">
		</div>
	</div>
	<div class="col-md-6">
		<div class="mb-3">
			<label for="applovinmax_placement_rewards" class="form-label fw-bold text-primary">REWARDS</label>
			<input type="text" class="form-control" name="applovinmax_placement_rewards" id="applovinmax_placement_rewards" value="{{ $mBaseApplication->applovinmax_placement_rewards }}">
		</div>
	</div>

	<div class="col-md-12">
	<h6 class="mb-4 mt-2 badge text-bg-secondary rounded rounded-1 opacity-50"># PLACEMENT WITHOUT ECPM</h6>
	</div>
	
	<div class="col-md-6">
		<div class="mb-3">
			<label for="applovinmax_placement_banner_no_ecpm" class="form-label fw-bold text-primary">BANNER</label>
			<input type="text" class="form-control" name="applovinmax_placement_banner_no_ecpm" id="applovinmax_placement_banner_no_ecpm" value="{{ $mBaseApplication->applovinmax_placement_banner_no_ecpm }}">
		</div>
	</div>
	<div class="col-md-6">
		<div class="mb-3">
			<label for="applovinmax_placement_native_no_ecpm" class="form-label fw-bold text-primary">NATIVE</label>
			<input type="text" class="form-control" name="applovinmax_placement_native_no_ecpm" id="applovinmax_placement_native_no_ecpm" value="{{ $mBaseApplication->applovinmax_placement_native_no_ecpm }}">
		</div>
	</div>
	<div class="col-md-6">
		<div class="mb-3">
			<label for="applovinmax_placement_interstitial_no_ecpm" class="form-label fw-bold text-primary">INTERSTITIAL</label>
			<input type="text" class="form-control" name="applovinmax_placement_interstitial_no_ecpm" id="applovinmax_placement_interstitial_no_ecpm" value="{{ $mBaseApplication->applovinmax_placement_interstitial_no_ecpm }}">
		</div>
	</div>
	<div class="col-md-6">
		<div class="mb-3">
			<label for="applovinmax_placement_rewards_no_ecpm" class="form-label fw-bold text-primary">REWARDS</label>
			<input type="text" class="form-control" name="applovinmax_placement_rewards_no_ecpm" id="applovinmax_placement_rewards_no_ecpm" value="{{ $mBaseApplication->applovinmax_placement_rewards_no_ecpm }}">
		</div>
	</div>

	<div class="col-md-12">
		<div class="mb-3 mt-3">
			<button type="submit" class="fw-bold shadow-none btn btn-primary w-100">SIMPAN</button>
		</div>
	</div>
</div>
</form>