<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Question;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $evaluations = Evaluation::orderBy('created_at', 'desc')->get();
        return view('admin.index', compact('evaluations'));
    }

    public function show(Evaluation $evaluation)
    {
        $evaluation->load('answers.question', 'answers.option');
        return view('admin.show', compact('evaluation'));
    }

    public function questions()
    {
        $questions = Question::with('options')->get();
        return view('admin.questions', compact('questions'));
    }
}
