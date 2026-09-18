<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    // Delete a candidate evaluation and all their answers
    public function destroyEvaluation(Evaluation $evaluation)
    {
        $evaluation->answers()->delete();
        $evaluation->delete();

        return redirect()->route('admin.index')->with('success', 'Candidat et ses réponses supprimés avec succès.');
    }

    // List admin users
    public function admins()
    {
        $admins = User::orderBy('created_at', 'desc')->get();
        return view('admin.admins', compact('admins'));
    }

    // Store a new admin user
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.admins')->with('success', 'Administrateur ajouté avec succès.');
    }

    // Delete an admin user
    public function destroyAdmin(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.admins')->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('admin.admins')->with('success', 'Administrateur supprimé avec succès.');
    }
}
