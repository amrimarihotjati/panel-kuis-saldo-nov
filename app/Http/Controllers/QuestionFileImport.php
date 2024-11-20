<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;

class QuestionFileImport extends Controller
{
 public function import(Request $request)
 {
    $validator = Validator::make($request->all(), [
        'file_question' => 'required|file|mimes:xlsx,csv'
    ]);

    if ($validator->fails()) {
        return response()->json(['message' => 'File need content type xlsx or csv'], 500);
    }

    $file = $request->file('file_question');

    try {
        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        $categoryQuizId = $request->category_id;

        foreach (array_slice($rows, 1) as $row) {
            if (!empty($row[0])) {
                Question::create([
                    'question' => $row[0],
                    'true_answer' => $row[1] ?? null,
                    'false_answer1' => $row[2] ?? null,
                    'false_answer2' => $row[3] ?? null,
                    'false_answer3' => $row[4] ?? null,
                    'level' => $row[5] ?? null,
                    'points' => $row[6] ?? null,
                    'category_id' => $categoryQuizId
                ]);
            }
        }


        return response()->json(['message' => 'Question berhasil diimport'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Question gagal diimport : ' . $e->getMessage()], 500);
    }
}

}
