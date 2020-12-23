<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Null_;

class AnswerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);
    }

    public function index(Question $question)
    {
        return $question->answers()->with('user')->simplePaginate(3);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Question $question)
    {
        $answer = $question->answers()->create($request->validate(['body' => 'required']) + ['user_id' => Auth::user()->id]);
        $answer = Answer::with('user', 'question')->where('id', $answer->id)->first();
        return response()->json(['message' => 'Successfully Created', 'answer' => $answer]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Answer $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question, Answer $answer)
    {
        return view('editAnswer', compact('answer', 'question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Answer $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        $result = $answer->update($request->validate(['body' => 'required']));
        return response()->json(['message' => 'success', 'body' => $answer->body]);
//        return redirect()->route('question.show', $question->slug)->with('msg', 'Successfully Edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Answer $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Answer $answer)
    {
        $this->authorize('answer', $answer);
        $answer->delete();
        return response()->json(['message' => 'success']);
//        return back()->with('msg', 'Successfully Deleted');
    }

    public function acceptBestAnswer(Question $question, Request $request)
    {
        $this->authorize('acceptAnswer', $question);
        $question->best_answer_id = $question->best_answer_id == $request->id ? NULL : $request->id;
        $question->save();
        return back();
    }
}
