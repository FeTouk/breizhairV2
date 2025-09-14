<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Test::all();
        return view('questions.index', ['questions' => $questions]);
    }

    public function create()
    {
        return view('questions.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'choix_1' => 'required|string|max:255',
            'choix_2' => 'required|string|max:255',
            'choix_3' => 'required|string|max:255',
            'reponse_correcte' => 'required|integer|in:1,2,3',
        ]);

        Test::create($validated);

        return redirect()->route('questions.index')->with('success', 'Question ajoutée avec succès.');
    }

    public function edit(Test $question)
    {
        return view('questions.form', ['question' => $question]);
    }

    public function update(Request $request, Test $question)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'choix_1' => 'required|string|max:255',
            'choix_2' => 'required|string|max:255',
            'choix_3' => 'required|string|max:255',
            'reponse_correcte' => 'required|integer|in:1,2,3',
        ]);

        $question->update($validated);

        return redirect()->route('questions.index')->with('success', 'Question mise à jour avec succès.');
    }

    public function destroy(Test $question)
    {
        $question->delete();
        return redirect()->route('questions.index')->with('success', 'Question supprimée avec succès.');
    }
}