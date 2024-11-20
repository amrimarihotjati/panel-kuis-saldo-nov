@php
$rewardsAdPointList = App\Models\RewardsAdPoints::orderBy('title', 'asc')->get();
$selectedRewardsAdPoints = $mBaseApplication->rewards_ad_points;
if ($selectedRewardsAdPoints == null) {
    $selectedRewardsAdPoints = [];
}
$selectedRewardsAdPointsJSON = json_encode($selectedRewardsAdPoints, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
$selectedRewardsAdPointsArray = json_decode($selectedRewardsAdPointsJSON);
$matchingRewardsAdPoints = App\Models\RewardsAdPoints::whereIn('id', $selectedRewardsAdPointsArray)->get();
@endphp

<div class="table-responsive mb-0" style="max-height: 350px; overflow-y: auto;">
    <form id="saveAddRewardsAdPointsSettings" autocomplete="off">
        @csrf
        <input type="hidden" class="form-control" name="app_id" id="app_id" value="{{ $mBaseApplication->id }}" required>
        @csrf
        <table
        class="table align-items-center table-flush table-light table-striped table-bordered table-sm mb-0 border border-4 rounded">
        <thead class="thead-dark">
            <tr>
                <th scope="col" class="text-center"></th>
                <th scope="col" class="text-center">#</th>
                <th scope="col">Nama RewardsAdPoints</th>
                <th scope="col" class="text-center">Tugas Nonton Ads</th>
                <th scope="col" class="text-center">Point Hadiah</th>
            </tr>
        </thead>
        <tbody>
            @if ($rewardsAdPointList->isEmpty())
            <tr>
                <td colspan="5" class="text-center p-8">
                    <div class="d-flex justify-content-center align-items-center">
                        <span class="m-4 text-dark">REWARDS AD POINTS TIDAK ADA</span>
                    </div>
                </td>
            </tr>
            @else
            @foreach ($rewardsAdPointList as $mRewardsAdPoints)
            <tr>
                <td class="text-center">
                    <input type="checkbox" class="form-check-input"
                    name="mRewardsAdPoints[]" value="{{ $mRewardsAdPoints->id }}"
                    @if (in_array($mRewardsAdPoints->id, $selectedRewardsAdPoints)) checked @endif>
                </td>
                <td class="text-center text-muted">{{ $loop->iteration }}</td>
                <td class="fw-semibold">{{ $mRewardsAdPoints->title }}</td>
                <td class="text-center">
                    <span class="text-dark fw-lighter">
                        {{ $mRewardsAdPoints->watch_ads_value }} ADS</span>
                    </td>
                    <td class="text-center fw-semibold text-dark">
                        {{ $mRewardsAdPoints->point_value }} points</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <div class="mb-3 mt-3">
                <button type="submit" class="fw-bold shadow-none btn btn-primary w-100">SIMPAN</button>
            </div>
        </form>
    </div>