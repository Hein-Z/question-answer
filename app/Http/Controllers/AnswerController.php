<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Null_;

class AnswerController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Question $question)
    {
        $question->answers()->create($request->validate(['body' => 'required']) + ['user_id' => Auth::user()->id]);
        return back()->with('msg', 'Successfully Created');
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
        $answer->update($request->validate(['body' => 'required']));
        return redirect()->route('question.show', $question->slug)->with('msg', 'Successfully Edited');
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
        return back()->with('msg', 'Successfully Deleted');
    }

    public function acceptBestAnswer(Question $question, Request $request)
    {
        $this->authorize('acceptAnswer', $question);
        $question->best_answer_id = $question->best_answer_id == $request->id ? NULL : $request->id;
        $question->save();
        return back();
    }
}
