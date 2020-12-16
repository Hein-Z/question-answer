<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::latest()->paginate(5);
        return view('question.index', compact('questions', $questions));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('question.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request)
    {
        $request->user()->questions()->create($request->all());

        return redirect()->route('question.index')->with('msg', 'successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Question $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        return view('question.show', ['question' => $question]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Question $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        $this->authorize('question', $question);
        return view('question.edit', ['question' => $question]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Question $question
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionRequest $request, Question $question)
    {
        $this->authorize('question', $question);
        $question->update($request->only('title', 'body'));
        return redirect()->route('question.index')->with('msg', 'successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Question $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $this->authorize('question', $question);
        $question->delete();
        return redirect()->route('question.index')->with('msg', 'successfully deleted');
    }
}

