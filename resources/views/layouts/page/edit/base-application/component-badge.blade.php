@php
$badgeList = App\Models\Badge::orderBy('badge_level', 'asc')->get();
$selectedBadge = $mBaseApplication->badge;
if ($selectedBadge == null) {
    $selectedBadge = [];
}
$selectedBadgeJSON = json_encode($selectedBadge, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
$selectedBadgeArray = json_decode($selectedBadgeJSON);
$matchingBadge = App\Models\Badge::whereIn('id', $selectedBadgeArray)->get();
@endphp

<div class="table-responsive mb-0" style="max-height: 350px; overflow-y: auto;">
    <form id="saveAddBadgeSettings" autocomplete="off">
        @csrf
        <input type="hidden" class="form-control" name="app_id" id="app_id" value="{{ $mBaseApplication->id }}" required>
        @csrf
        <table
        class="table align-items-center table-flush table-light table-striped table-bordered table-sm mb-0 border border-4 rounded">
        <thead class="thead-dark">
            <tr>
                <th scope="col" class="text-center"></th>
                <th scope="col" class="text-center">#</th>
                <th scope="col">Nama Badge</th>
                <th scope="col" class="text-center">Level Badge</th>
                <th scope="col" class="text-center">Harga Badge</th>
            </tr>
        </thead>
        <tbody>
            @if ($badgeList->isEmpty())
            <tr>
                <td colspan="5" class="text-center p-8">
                    <div class="d-flex justify-content-center align-items-center">
                        <span class="m-4 text-dark">BADGE TIDAK ADA</span>
                    </div>
                </td>
            </tr>
            @else
            @foreach ($badgeList as $mBadge)
            <tr>
                <td class="text-center">
                    <input type="checkbox" class="form-check-input"
                    name="mBadge[]" value="{{ $mBadge->id }}"
                    @if (in_array($mBadge->id, $selectedBadge)) checked @endif>
                </td>
                <td class="text-center text-muted">{{ $loop->iteration }}</td>
                <td class="fw-semibold">{{ $mBadge->badge_name }}</td>
                <td class="fw-bold text-center">{{ $mBadge->badge_level }}</td>
                <td class="fw-semibold text-center">{{ $mBadge->badge_price }}</td>
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