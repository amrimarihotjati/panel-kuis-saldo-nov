<form autocomplete="off" id="saveConfigAdsNewApplovinmax">
@csrf
<input type="hidden" class="form-control" name="app_id" id="app_id" value="{{ $mBaseApplication->id }}" required>
<div class="row">
	
	<div class="col-md-12">
	<h6 class="mb-4 mt-2 badge text-bg-secondary rounded rounded-1 opacity-50"># BANNER</h6>
	</div>

	<div class="col-md-6">
		<div class="mb-3">
			<label for="applovinmax_placement_new_banner_1" class="form-label fw-bold text-primary">BANNER 1</label>
			<input type="text" class="form-control" name="applovinmax_placement_new_banner_1" id="applovinmax_placement_new_banner_1" value="{{ $mBaseApplication->applovinmax_placement_new_banner_1 }}">
		</div>
	</div>

	<div class="col-md-6">
		<div class="mb-3">
			<label for="applovinmax_placement_new_banner_2" class="form-label fw-bold text-primary">BANNER 2</label>
			<input type="text" class="form-control" name="applovinmax_placement_new_banner_2" id="applovinmax_placement_new_banner_2" value="{{ $mBaseApplication->applovinmax_placement_new_banner_2 }}">
		</div>
	</div>

	<div class="col-md-4">
		<div class="mb-3">
			<label for="applovinmax_placement_new_banner_3" class="form-label fw-bold text-primary">BANNER 3</label>
			<input type="text" class="form-control" name="applovinmax_placement_new_banner_3" id="applovinmax_placement_new_banner_3" value="{{ $mBaseApplication->applovinmax_placement_new_banner_3 }}">
		</div>
	</div>

	<div class="col-md-4">
		<div class="mb-3">
			<label for="applovinmax_placement_new_banner_4" class="form-label fw-bold text-primary">BANNER 4</label>
			<input type="text" class="form-control" name="applovinmax_placement_new_banner_4" id="applovinmax_placement_new_banner_4" value="{{ $mBaseApplication->applovinmax_placement_new_banner_4 }}">
		</div>
	</div>

	<div class="col-md-4">
		<div class="mb-3">
			<label for="applovinmax_placement_new_banner_5" class="form-label fw-bold text-primary">BANNER 5</label>
			<input type="text" class="form-control" name="applovinmax_placement_new_banner_5" id="applovinmax_placement_new_banner_5" value="{{ $mBaseApplication->applovinmax_placement_new_banner_5 }}">
		</div>
	</div>

	<div class="col-md-12">
	<h6 class="mb-4 mt-2 badge text-bg-secondary rounded rounded-1 opacity-50"># NATIVE</h6>
	</div>

	<div class="col-md-6">
		<div class="mb-3">
			<label for="applovinmax_placement_new_native_1" class="form-label fw-bold text-primary">NATIVE 1</label>
			<input type="text" class="form-control" name="applovinmax_placement_new_native_1" id="applovinmax_placement_new_native_1" value="{{ $mBaseApplication->applovinmax_placement_new_native_1 }}">
		</div>
	</div>

	<div class="col-md-6">
		<div class="mb-3">
			<label for="applovinmax_placement_new_native_2" class="form-label fw-bold text-primary">NATIVE 2</label>
			<input type="text" class="form-control" name="applovinmax_placement_new_native_2" id="applovinmax_placement_new_native_2" value="{{ $mBaseApplication->applovinmax_placement_new_native_2 }}">
		</div>
	</div>

	<div class="col-md-4">
		<div class="mb-3">
			<label for="applovinmax_placement_new_native_3" class="form-label fw-bold text-primary">NATIVE 3</label>
			<input type="text" class="form-control" name="applovinmax_placement_new_native_3" id="applovinmax_placement_new_native_3" value="{{ $mBaseApplication->applovinmax_placement_new_native_3 }}">
		</div>
	</div>

	<div class="col-md-4">
		<div class="mb-3">
			<label for="applovinmax_placement_new_native_4" class="form-label fw-bold text-primary">NATIVE 4</label>
			<input type="text" class="form-control" name="applovinmax_placement_new_native_4" id="applovinmax_placement_new_native_4" value="{{ $mBaseApplication->applovinmax_placement_new_native_4 }}">
		</div>
	</div>

	<div class="col-md-4">
		<div class="mb-3">
			<label for="applovinmax_placement_new_native_5" class="form-label fw-bold text-primary">NATIVE 5</label>
			<input type="text" class="form-control" name="applovinmax_placement_new_native_5" id="applovinmax_placement_new_native_5" value="{{ $mBaseApplication->applovinmax_placement_new_native_5 }}">
		</div>
	</div>

	<div class="col-md-12">
	<h6 class="mb-4 mt-2 badge text-bg-secondary rounded rounded-1 opacity-50"># INTERSTITIAL</h6>
	</div>

	<div class="col-md-6">
		<div class="mb-3">
			<label for="applovinmax_placement_new_interstitial_1" class="form-label fw-bold text-primary">INTERSTITIAL 1</label>
			<input type="text" class="form-control" name="applovinmax_placement_new_interstitial_1" id="applovinmax_placement_new_interstitial_1" value="{{ $mBaseApplication->applovinmax_placement_new_interstitial_1 }}">
		</div>
	</div>

	<div class="col-md-6">
		<div class="mb-3">
			<label for="applovinmax_placement_new_interstitial_2" class="form-label fw-bold text-primary">INTERSTITIAL 2</label>
			<input type="text" class="form-control" name="applovinmax_placement_new_interstitial_2" id="applovinmax_placement_new_interstitial_2" value="{{ $mBaseApplication->applovinmax_placement_new_interstitial_2 }}">
		</div>
	</div>

	<div class="col-md-4">
		<div class="mb-3">
			<label for="applovinmax_placement_new_interstitial_3" class="form-label fw-bold text-primary">INTERSTITIAL 3</label>
			<input type="text" class="form-control" name="applovinmax_placement_new_interstitial_3" id="applovinmax_placement_new_interstitial_3" value="{{ $mBaseApplication->applovinmax_placement_new_interstitial_3 }}">
		</div>
	</div>

	<div class="col-md-4">
		<div class="mb-3">
			<label for="applovinmax_placement_new_interstitial_4" class="form-label fw-bold text-primary">INTERSTITIAL 4</label>
			<input type="text" class="form-control" name="applovinmax_placement_new_interstitial_4" id="applovinmax_placement_new_interstitial_4" value="{{ $mBaseApplication->applovinmax_placement_new_interstitial_4 }}">
		</div>
	</div>

	<div class="col-md-4">
		<div class="mb-3">
			<label for="applovinmax_placement_new_interstitial_5" class="form-label fw-bold text-primary">INTERSTITIAL 5</label>
			<input type="text" class="form-control" name="applovinmax_placement_new_interstitial_5" id="applovinmax_placement_new_interstitial_5" value="{{ $mBaseApplication->applovinmax_placement_new_interstitial_5 }}">
		</div>
	</div>

	<div class="col-md-12">
	<h6 class="mb-4 mt-2 badge text-bg-secondary rounded rounded-1 opacity-50"># REWARDS</h6>
	</div>

	<div class="col-md-6">
		<div class="mb-3">
			<label for="applovinmax_placement_new_rewards_1" class="form-label fw-bold text-primary">REWARDS 1</label>
			<input type="text" class="form-control" name="applovinmax_placement_new_rewards_1" id="applovinmax_placement_new_rewards_1" value="{{ $mBaseApplication->applovinmax_placement_new_rewards_1 }}">
		</div>
	</div>

	<div class="col-md-6">
		<div class="mb-3">
			<label for="applovinmax_placement_new_rewards_2" class="form-label fw-bold text-primary">REWARDS 2</label>
			<input type="text" class="form-control" name="applovinmax_placement_new_rewards_2" id="applovinmax_placement_new_rewards_2" value="{{ $mBaseApplication->applovinmax_placement_new_rewards_2 }}">
		</div>
	</div>

	<div class="col-md-4">
		<div class="mb-3">
			<label for="applovinmax_placement_new_rewards_3" class="form-label fw-bold text-primary">REWARDS 3</label>
			<input type="text" class="form-control" name="applovinmax_placement_new_rewards_3" id="applovinmax_placement_new_rewards_3" value="{{ $mBaseApplication->applovinmax_placement_new_rewards_3 }}">
		</div>
	</div>

	<div class="col-md-4">
		<div class="mb-3">
			<label for="applovinmax_placement_new_rewards_4" class="form-label fw-bold text-primary">REWARDS 4</label>
			<input type="text" class="form-control" name="applovinmax_placement_new_rewards_4" id="applovinmax_placement_new_rewards_4" value="{{ $mBaseApplication->applovinmax_placement_new_rewards_4 }}">
		</div>
	</div>

	<div class="col-md-4">
		<div class="mb-3">
			<label for="applovinmax_placement_new_rewards_5" class="form-label fw-bold text-primary">REWARDS 5</label>
			<input type="text" class="form-control" name="applovinmax_placement_new_rewards_5" id="applovinmax_placement_new_rewards_5" value="{{ $mBaseApplication->applovinmax_placement_new_rewards_5 }}">
		</div>
	</div>

	<div class="col-md-12">
		<div class="mb-3 mt-3">
			<button type="submit" class="fw-bold shadow-none btn btn-primary w-100">SIMPAN</button>
		</div>
	</div>
</div>
</form>