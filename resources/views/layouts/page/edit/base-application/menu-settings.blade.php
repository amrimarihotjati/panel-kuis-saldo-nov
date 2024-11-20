<div class="container">
	<form autocomplete="off" id="saveMenuSettings">
		@csrf
		<input type="hidden" class="form-control" name="app_id" id="app_id" value="{{ $mBaseApplication->id }}" required>
		
		<div class="row">
			<div class="col-md-6">
				<div class="mb-3">
					<label for="settings_validation_device_api" class="form-label text-muted fw-semibold">Enabled validation device</label>
					<select class="form-control fw-bold" id="settings_validation_device_api" name="settings_validation_device_api">
						<option value="0" @if ($mBaseApplication->settings_validation_device_api == 0) selected @endif>Tidak
						</option>
						<option value="1" @if ($mBaseApplication->settings_validation_device_api == 1) selected @endif>Aktif
						</option>
					</select>
				</div>
			</div>

			<div class="col-md-6">
				<div class="mb-3">
					<label for="settings_checking_emulator" class="form-label text-muted fw-semibold">Enabled checking emulator</label>
					<select class="form-control fw-bold" id="settings_checking_emulator" name="settings_checking_emulator">
						<option value="0" @if ($mBaseApplication->settings_checking_emulator == 0) selected @endif>Tidak
						</option>
						<option value="1" @if ($mBaseApplication->settings_checking_emulator == 1) selected @endif>Aktif
						</option>
					</select>
				</div>
			</div>

			<div class="col-md-6">
				<div class="mb-3">
					<label for="settings_completed_option" class="form-label text-muted fw-semibold">Setting Completed options 50%</label>
					<select class="form-control fw-bold" id="settings_completed_option" name="settings_completed_option">
						<option value="0" @if ($mBaseApplication->settings_completed_option == 0) selected @endif>Tidak
						</option>
						<option value="1" @if ($mBaseApplication->settings_completed_option == 1) selected @endif>Aktif
						</option>
					</select>
				</div>
			</div>

			<div class="col-md-6">
				<div class="mb-3">
					<label for="settings_fifty_fifty" class="form-label text-muted fw-semibold">Allow fifty fifty in quiz</label>
					<select class="form-control fw-bold" id="settings_fifty_fifty" name="settings_fifty_fifty">
						<option value="0" @if ($mBaseApplication->settings_fifty_fifty == 0) selected @endif>Tidak
						</option>
						<option value="1" @if ($mBaseApplication->settings_fifty_fifty == 1) selected @endif>Aktif
						</option>
					</select>
				</div>
			</div>

			<div class="col-md-6">
				<div class="mb-3">
					<label for="settings_video_reward" class="form-label text-muted fw-semibold">Allow video rewards in quiz</label>
					<select class="form-control fw-bold" id="settings_video_reward" name="settings_video_reward">
						<option value="0" @if ($mBaseApplication->settings_video_reward == 0) selected @endif>Tidak
						</option>
						<option value="1" @if ($mBaseApplication->settings_video_reward == 1) selected @endif>Aktif
						</option>
					</select>
				</div>
			</div>

			<div class="col-md-6">
				<div class="mb-3">
					<label for="settings_menu_dana_kaget" class="form-label text-muted fw-semibold">Show daget menu</label>
					<select class="form-control fw-bold" id="settings_menu_dana_kaget" name="settings_menu_dana_kaget">
						<option value="0" @if ($mBaseApplication->settings_menu_dana_kaget == 0) selected @endif>Tidak
						</option>
						<option value="1" @if ($mBaseApplication->settings_menu_dana_kaget == 1) selected @endif>Aktif
						</option>
					</select>
				</div>
			</div>

			<div class="col-md-6">
				<div class="mb-3">
					<label for="settings_menu_badge_player" class="form-label text-muted fw-semibold">Show badge menu</label>
					<select class="form-control fw-bold" id="settings_menu_badge_player" name="settings_menu_badge_player">
						<option value="0" @if ($mBaseApplication->settings_menu_badge_player == 0) selected @endif>Tidak
						</option>
						<option value="1" @if ($mBaseApplication->settings_menu_badge_player == 1) selected @endif>Aktif
						</option>
					</select>
				</div>
			</div>

			<div class="col-md-6">
				<div class="mb-3">
					<label for="settings_menu_rewards_point" class="form-label text-muted fw-semibold">Show RewardAdPoint menu</label>
					<select class="form-control fw-bold" id="settings_menu_rewards_point" name="settings_menu_rewards_point">
						<option value="0" @if ($mBaseApplication->settings_menu_rewards_point == 0) selected @endif>Tidak
						</option>
						<option value="1" @if ($mBaseApplication->settings_menu_rewards_point == 1) selected @endif>Aktif
						</option>
					</select>
				</div>
			</div>

			<div class="col-md-4">
				<div class="mb-3">
					<label for="settings_currency" class="form-label fw-semibold text-muted">Currency</label>
					<input type="text" class="form-control" name="settings_currency" id="settings_currency" value="{{ $mBaseApplication->settings_currency }}" required>
				</div>
			</div>

			<div class="col-md-4">
				<div class="mb-3">
					<label for="settings_min_to_withdraw" class="form-label fw-semibold text-muted">Minimum Withdraw</label>
					<input type="number" step="1" min="1" class="form-control" name="settings_min_to_withdraw" id="settings_min_to_withdraw" value="{{ $mBaseApplication->settings_min_to_withdraw }}" required>
				</div>
			</div>

			<div class="col-md-4">
				<div class="mb-3">
					<label for="settings_conversion_rate" class="form-label fw-semibold text-muted">Conversion Rate</label>
					<input type="number" step="1" min="0" class="form-control" name="settings_conversion_rate" id="settings_conversion_rate" value="{{ $mBaseApplication->settings_conversion_rate }}" required>
				</div>
			</div>

			<div class="col-md-4">
				<div class="mb-3">
					<label for="settings_question_time" class="form-label fw-semibold text-muted">Question Time</label>
					<input type="number" step="1" min="0" class="form-control" name="settings_question_time" id="settings_question_time" value="{{ $mBaseApplication->settings_question_time }}" required>
				</div>
			</div>

			<div class="col-md-4">
				<div class="mb-3">
					<label for="settings_referral_register_points" class="form-label fw-semibold text-muted">Refferal Register Point</label>
					<input type="number" step="1" min="0" class="form-control" name="settings_referral_register_points" id="settings_referral_register_points" value="{{ $mBaseApplication->settings_referral_register_points }}" required>
				</div>
			</div>

			<div class="col-md-4">
				<div class="mb-3">
					<label for="settings_commission_withdraw_player_value" class="form-label fw-semibold text-muted">Refferal Commission WD</label>
					<input type="number" step="1" min="0" class="form-control" name="settings_commission_withdraw_player_value" id="settings_commission_withdraw_player_value" value="{{ $mBaseApplication->settings_commission_withdraw_player_value }}" required>
				</div>
			</div>

			<div class="col-md-4">
				<div class="mb-3">
					<label for="settings_with_double_option_value" class="form-label fw-semibold text-muted">Opsi double Ads (point x %)</label>
					<input type="number" step="1" min="0" class="form-control" name="settings_with_double_option_value" id="settings_with_double_option_value" value="{{ $mBaseApplication->settings_with_double_option_value }}" required>
				</div>
			</div>

			<div class="col-md-4">
				<div class="mb-3">
					<label for="settings_difference_ms_quiz" class="form-label fw-semibold text-muted">Handle Spam Quiz Time Seconds to ms</label>
					<input type="number" step="1" min="0" class="form-control" name="settings_difference_ms_quiz" id="settings_difference_ms_quiz" value="{{ $mBaseApplication->settings_difference_ms_quiz }}" required>
				</div>
			</div>

			<div class="col-md-4">
				<div class="mb-3">
					<label for="settings_minimum_ad_withdraw" class="form-label fw-semibold text-muted">Minimum Ad Withdraw Count</label>
					<input type="number" step="1" min="0" class="form-control" name="settings_minimum_ad_withdraw" id="settings_minimum_ad_withdraw" value="{{ $mBaseApplication->settings_minimum_ad_withdraw }}" required>
				</div>
			</div>

			<div class="col-md-12">
				<div class="mb-3">
					<label for="settings_date_all_completed" class="form-label fw-semibold text-muted">Automatic Completed Date</label>
					<select class="form-control fw-bold" id="settings_date_all_completed" name="settings_date_all_completed">
						<option value="0" @if ($mBaseApplication->settings_date_all_completed == 0) selected @endif>Tidak
						</option>
						<option value="1" @if ($mBaseApplication->settings_date_all_completed == 1) selected @endif>Aktif
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
