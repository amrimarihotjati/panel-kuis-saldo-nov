@php
$dagetList = App\Models\Daget::orderBy('title', 'asc')->get();
$selectedDaget = $mBaseApplication->dana_kaget;
if ($selectedDaget == null) {
    $selectedDaget = [];
}
$selectedDagetJSON = json_encode($selectedDaget, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
$selectedDagetArray = json_decode($selectedDagetJSON);
$matchingDaget = App\Models\Daget::whereIn('id', $selectedDagetArray)->get();
@endphp

<div class="table-responsive mb-0" style="max-height: 350px; overflow-y: auto;">
    <form id="saveAddDagetSettings" autocomplete="off">
        @csrf
        <input type="hidden" class="form-control" name="app_id" id="app_id" value="{{ $mBaseApplication->id }}" required>
        @csrf
        <table
        class="table align-items-center table-flush table-light table-striped table-bordered table-sm mb-0 border border-4 rounded">
        <thead class="thead-dark">
            <tr>
                <th scope="col" class="text-center"></th>
                <th scope="col" class="text-center">#</th>
                <th scope="col">Nama Daget</th>
                <th scope="col" class="text-center">Tugas Nonton Ads</th>
                <th scope="col" class="text-center">Nominal</th>
                <th scope="col" class="text-center">Link</th>
            </tr>
        </thead>
        <tbody>
            @if ($dagetList->isEmpty())
            <tr>
                <td colspan="6" class="text-center p-8">
                    <div class="d-flex justify-content-center align-items-center">
                        <span class="m-4 text-dark">DAGET TIDAK ADA</span>
                    </div>
                </td>
            </tr>
            @else
            @foreach ($dagetList as $mDaget)
            <tr>
                <td class="text-center">
                    <input type="checkbox" class="form-check-input"
                    name="mDaget[]" value="{{ $mDaget->id }}"
                    @if (in_array($mDaget->id, $selectedDaget)) checked @endif>
                </td>
                <td class="text-center text-muted">{{ $loop->iteration }}</td>
                <td class="fw-bold">{{ $mDaget->title }}</td>
                <td class="text-center">
                    <span class="text-dark fw-lighter">
                        {{ $mDaget->watch_ads_value }} ADS</span>
                    </td>
                    <td class="text-center fw-bolder text-warning">
                        {{ $mDaget->info_rupiah }}</td>
                        <td class="text-center font-weight-bold">
                            <a class="nav-link link-primary fw-bold"
                            href="{{ $mDaget->url }}">LINK</a>
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