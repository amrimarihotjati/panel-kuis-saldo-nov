<?php

namespace App\Http\Controllers;

use App\Models\QuizCompleted;
use App\Models\CategoryQuiz;
use App\Models\BaseApplication;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;

class QuizCompletedController extends Controller
{
    public function getDTQuizCompleted(Request $request)
    {
        $app_pkg = $request->app_pkg;
        $query = QuizCompleted::query()->where('player_pkg', $app_pkg)->with('player')->with('categoryQuiz')->orderBy('created_at', 'desc');
        return Datatables::eloquent($query)
            ->filter(function ($query) use ($app_pkg) {
                if (request()->has('search')) {
                    $search = request()->get('search')['value'];
                    $query->whereHas('player', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('email', 'LIKE', "%{$search}%")
                            ->orWhere('id', 'LIKE', "%{$search}%");
                    });
                    $query->where('player_pkg', $app_pkg);
                }
            })
            ->toJson();
    }

    public function getDTCategoryQuiz($app_pkg)
    {
        $baseApplication = BaseApplication::where('app_pkg', $app_pkg)->first();
        if ($baseApplication) {
            $categoryQuizIds = is_string($baseApplication->category_quiz) ? json_decode($baseApplication->category_quiz, true) : $baseApplication->category_quiz;
            if (!is_array($categoryQuizIds)) {
                return response()->json(['error' => 'Invalid category data'], 400);
            }
            $query = CategoryQuiz::whereIn('id', $categoryQuizIds)->orderBy('category_name', 'asc')->orderBy('created_at', 'desc');
            return Datatables::eloquent($query)->toJson();
        } else {
            return response()->json(['message' => 'Aplikasi tidak ditemukan'], 404);
        }
    }

    public function getCountQuizCompleted(Request $request)
    {
        $data = QuizCompleted::select('*')->orderBy('created_at', 'desc')->get();
        return $data->count();
    }

    public function resetAllCompletedFromPackage(Request $request)
    {
        $app_pkg = $request->app_pkg;
        $dataQuizCompleted = QuizCompleted::where('player_pkg', $app_pkg)->get();
        if ($dataQuizCompleted->isEmpty()) {
            return response()->json(['message' => 'Completed Kuis kosong'], 500);
        }
        foreach ($dataQuizCompleted as $quizCompleted) {
            $quizCompleted->delete();
        }
        return response()->json(['message' => 'Completed Quiz Berhasil direset'], 200);
    }

    public function resetSelectedCategoryCompletedQuizFromPackage(Request $request)
    {
        $app_pkg = $request->app_pkg;
        $category_id = $request->category_id;
    
        if (!$category_id) {
            return response()->json(['message' => 'Kategori ID tidak ditemukan'], 400);
        }
    
        $dataQuizCompleted = QuizCompleted::where('player_pkg', $app_pkg)
            ->where('category_id', $category_id)
            ->get();
    
        if ($dataQuizCompleted->isEmpty()) {
            return response()->json(['message' => 'Completed Kuis Ini kosong'], 404);
        }
    
        foreach ($dataQuizCompleted as $quizCompleted) {
            $quizCompleted->delete();
        }
    
        $category = CategoryQuiz::find($category_id);
        $categoryName = $category ? $category->category_name : 'Kategori tidak diketahui';
    
        return response()->json(['message' => 'Completed Quiz dari kategori ' . $categoryName . ' berhasil direset'], 200);
    }    

}
