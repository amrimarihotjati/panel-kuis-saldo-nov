@php
$bannerList = App\Models\Banner::orderBy('banner_title', 'asc')->get();
$selectedBanner = $mBaseApplication->banner;
if ($selectedBanner == null) {
    $selectedBanner = [];
}
$selectedBannerJSON = json_encode($selectedBanner, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
$selectedBannerArray = json_decode($selectedBannerJSON);
$matchingBanner = App\Models\Banner::whereIn('id', $selectedBannerArray)->get();
@endphp

<div class="table-responsive mb-0" style="max-height: 350px; overflow-y: auto;">
    <form id="saveAddBannerSettings" autocomplete="off">
        @csrf
        <input type="hidden" class="form-control" name="app_id" id="app_id" value="{{ $mBaseApplication->id }}" required>
        @csrf
        <table
        class="table align-items-center table-flush table-light table-striped table-bordered table-sm mb-0 border border-4 rounded">
        <thead class="thead-dark">
            <tr>
                <th scope="col" class="text-center"></th>
                <th scope="col" class="text-center">#</th>
                <th scope="col">Judul Banner</th>
                <th scope="col" class="text-center">Link</th>
            </tr>
        </thead>
        <tbody>
            @if ($bannerList->isEmpty())
            <tr>
                <td colspan="4" class="text-center p-8">
                    <div class="d-flex justify-content-center align-items-center">
                        <span class="m-4 text-dark">BANNER TIDAK ADA</span>
                    </div>
                </td>
            </tr>
            @else
            @foreach ($bannerList as $mBanner)
            <tr>
                <td class="text-center">
                    <input type="checkbox" class="form-check-input"
                    name="mBanner[]" value="{{ $mBanner->id }}"
                    @if (in_array($mBanner->id, $selectedBanner)) checked @endif>
                </td>
                <td class="text-center text-muted">{{ $loop->iteration }}</td>
                <td class="fw-bold">{{ $mBanner->banner_title }}</td>
                <td class="text-center font-weight-bold">
                    <a class="nav-link link-primary fw-bold"
                    href="{{ $mBanner->banner_url }}">LINK</a>
                </td>
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