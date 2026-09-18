<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Evaluation;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function index()
    {
        return view('evaluation.index');
    }

    public function start(Request $request)
    {
        $request->validate([
            'participant_name' => 'required|string|max:255'
        ]);

        // Start a new evaluation session
        session(['participant_name' => $request->participant_name]);

        return redirect()->route('evaluation.form');
    }

    public function form()
    {
        if (!session('participant_name')) {
            return redirect()->route('evaluation.index');
        }

        $questions = Question::with('options')->get();

        return view('evaluation.form', compact('questions'));
    }

    public function submit(Request $request)
    {
        if (!session('participant_name')) {
            return redirect()->route('evaluation.index');
        }

        $questions = Question::with('options')->get();
        $totalQuestions = $questions->count();
        $score = 0;

        $evaluation = Evaluation::create([
            'participant_name' => session('participant_name'),
            'total_questions' => $totalQuestions,
            'score' => 0 // will update later
        ]);

        foreach ($questions as $question) {
            $selectedOptionId = $request->input('question_' . $question->id);
            if ($selectedOptionId) {
                $option = Option::find($selectedOptionId);
                $isCorrect = $option ? $option->is_correct : false;
                
                if ($isCorrect) {
                    $score++;
                }

                Answer::create([
                    'evaluation_id' => $evaluation->id,
                    'question_id' => $question->id,
                    'option_id' => $selectedOptionId,
                    'is_correct' => $isCorrect
                ]);
            }
        }

        $evaluation->update(['score' => $score]);
        
        session()->forget('participant_name');

        return redirect()->route('evaluation.result', $evaluation->id);
    }

    public function result(Evaluation $evaluation)
    {
        $evaluation->load('answers.question', 'answers.option');
        
        return view('evaluation.result', compact('evaluation'));
    }
}
