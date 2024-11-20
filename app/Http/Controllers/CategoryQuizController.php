<?php

namespace App\Http\Controllers;

use App\Models\CategoryQuiz;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;

class CategoryQuizController extends Controller
{
     public function getDTCategoryQuiz(Request $request)
    {
        $query = CategoryQuiz::query()->orderBy('created_at', 'desc');
        return Datatables::eloquent($query)->toJson();
    }

    public function getCountCategoryQuiz(Request $request)
    {
        $data = CategoryQuiz::select('*')
        ->orderBy('created_at', 'desc')
        ->get();
        return $data->count();
    }

    public function createCategoryQuiz(Request $request)
    {
        $category_name = $request->category_name;
        $category_caption = $request->category_caption;

        if ($request->file('category_image')) {
            $newImage = $request->file('category_image');
            $filerandom = Str::random(30, 'alpha_num_or_symbols');
            $filename = $filerandom . '.png';
            $newImage->move(public_path('uploads/category_image'), $filename);

            $mCategoryQuiz = CategoryQuiz::create([
                'category_name' => $category_name,
                'category_caption' => $category_caption,
                'category_image' => env('APP_URL') . '/uploads/category_image/' . $filename,
            ]);

            if ($mCategoryQuiz) {
                return response()->json(['message' => 'Kategori Kuis berhasil dibuat'], 200);
            } else {
                 return response()->json(['message' => 'Kategori Kuis gagal dibuat'], 500);
            }
        }
    }

    public function editCategoryQuiz(Request $request) {
        $findCategoryQuiz = CategoryQuiz::findOrFail($request->category_quiz_id);
        
        $category_name = $request->category_name;
        $category_caption = $request->category_caption;

        if ($request->file('category_image')) {
            $newImage = $request->file('category_image');
            $filerandom = Str::random(30, 'alpha_num_or_symbols');
            $filename = $filerandom . '.png';
            $newImage->move(public_path('uploads/category_image'), $filename);

            $findCategoryQuiz->category_name = $category_name;
            $findCategoryQuiz->category_caption = $category_caption;
            $findCategoryQuiz->category_image = env('APP_URL') . '/uploads/category_image/' . $filename;
            $findCategoryQuiz->save();

            if ($findCategoryQuiz) {
                return response()->json(['message' => 'Kategory kuis berhasil diubah'], 200);
            } else {
                 return response()->json(['message' => 'Kategory kuis gagal diubah'], 500);
            }
        } else {
            $findCategoryQuiz->category_name = $category_name;
            $findCategoryQuiz->category_caption = $category_caption;
            $findCategoryQuiz->save();
            if ($findCategoryQuiz) {
                return response()->json(['message' => 'Kategory kuis berhasil diubah'], 200);
            } else {
                 return response()->json(['message' => 'Kategory kuis gagal diubah'], 500);
            }
        }
    }

    public function detailCategoryQuiz($id) {
        $mCategoryQuiz = CategoryQuiz::findOrFail($id);
        return view('layouts/page/edit/edit-category-quiz', compact('mCategoryQuiz'));
    }

    public function deleteCategoryQuiz($id) {
        $mCategoryQuiz = CategoryQuiz::findOrFail($id);
        $mCategoryQuiz->delete();
        if ($mCategoryQuiz) {
           return redirect('/category-quiz');
        } else {
           return response()->json(['message' => 'Kategori kuis gagal dihapus'], 500);
       }
    }
}
