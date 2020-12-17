<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{


    public function question(Question $question)
    {
        $vote = (int)\request()->vote;

        Auth::user()->voteQuestion($question, $vote);
        return back();
    }

    public function answer(Answer $answer)
    {
        $vote = (int)\request()->vote;

        Auth::user()->voteAnswer($answer, $vote);
        return back();
    }
}
