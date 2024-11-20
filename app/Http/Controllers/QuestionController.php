<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\CategoryQuiz;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;

class QuestionController extends Controller
{
    public function getDTQuestion($category_quiz_id)
    {
        $query = Question::query()->where('category_id', $category_quiz_id)->orderBy('created_at', 'desc');
        return Datatables::eloquent($query)->toJson();
    }

    public function getCountQuestion(Request $request)
    {
        $data = Question::select('*')
        ->orderBy('created_at', 'desc')
        ->get();
        return $data->count();
    }

    public function createQuestion(Request $request)
    {
        $category_id = $request->category_id;

        $mCategoryQuiz = CategoryQuiz::findOrFail($category_id);

        $quiz_question = $request->question;
        $quiz_true_answer = $request->true_answer;
        $quiz_false_answer1 = $request->false_answer1;
        $quiz_false_answer2 = $request->false_answer2;
        $quiz_false_answer3 = $request->false_answer3;
        $quiz_level = $request->level;
        $quiz_points = $request->points;

        $mQuestion = Question::create([
            'question' => $quiz_question,
            'true_answer' => $quiz_true_answer,
            'false_answer1' => $quiz_false_answer1,
            'false_answer2' => $quiz_false_answer2,
            'false_answer3' => $quiz_false_answer3,
            'level' => $quiz_level,
            'points' => $quiz_points,
            'category_id' => $category_id
        ]);

        if ($mQuestion) {
            return response()->json(['message' => 'Question berhasil dibuat'], 200);
        } else {
            return response()->json(['message' => 'Question gagal dibuat'], 500);
        }
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids;
        try {
            Question::whereIn('id', $ids)->delete();
            return response()->json(['message' => 'Pertanyaan berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus pertanyaan: ' . $e->getMessage()], 500);
        }
    }

}
