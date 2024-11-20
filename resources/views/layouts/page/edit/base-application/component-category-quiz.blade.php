@php
$categoryList = App\Models\CategoryQuiz::all();
$selectedCategoryQuiz = $mBaseApplication->category_quiz;
if ($selectedCategoryQuiz == null) {
    $selectedCategoryQuiz = [];
}
$selectedCategoryQuizJSON = json_encode($selectedCategoryQuiz, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
$selectedCategoryQuizArray = json_decode($selectedCategoryQuizJSON);
$matchingCategoryQuiz = App\Models\CategoryQuiz::whereIn('id', $selectedCategoryQuizArray)->get();
@endphp

<div class="table-responsive mb-0" style="max-height: 350px; overflow-y: auto;">
    <form id="saveAddCategoryQuizSettings" autocomplete="off">
        @csrf
        <input type="hidden" class="form-control" name="app_id" id="app_id" value="{{ $mBaseApplication->id }}" required>
        @csrf
        <table
        class="table align-items-center table-flush table-light table-striped table-bordered table-sm mb-0 border border-4 rounded">
        <thead class="thead-dark">
            <tr>
                <th scope="col" class="text-center"></th>
                <th scope="col" class="text-center">#</th>
                <th scope="col">Nama Kategori</th>
            </tr>
        </thead>
        <tbody>
            @if ($categoryList->isEmpty())
            <tr>
                <td colspan="3" class="text-center p-8">
                    <div class="d-flex justify-content-center align-items-center">
                        <span class="m-4 text-dark">KATEGORI KUIS TIDAK ADA</span>
                    </div>
                </td>
            </tr>
            @else
            @foreach ($categoryList as $mCategoryQuiz)
            <tr>
                <td class="text-center">
                    <input type="checkbox" class="form-check-input"
                    name="mCategoryQuiz[]" value="{{ $mCategoryQuiz->id }}"
                    @if (in_array($mCategoryQuiz->id, $selectedCategoryQuiz)) checked @endif>
                </td>
                <td class="text-center text-muted">{{ $loop->iteration }}</td>
                <td class="fw-bold">{{ $mCategoryQuiz->category_name }}</td>
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