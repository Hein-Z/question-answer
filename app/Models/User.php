<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function favourites()
    {
        return $this->belongsToMany(Question::class, 'favourites', 'user_id', 'question_id');
    }

    public function questionVotes()
    {
        return $this->morphedByMany(Question::class, 'votable', 'votables', 'user_id', 'votable_id');
    }

    public function answerVotes()
    {
        return $this->morphedByMany(Answer::class, 'votable', 'votables', 'user_id', 'votable_id');
    }

    public function voteQuestion( $question, $vote)
    {
        $questionVotes = $this->questionVotes();
        $questionId = $question->id;
        if ($questionVotes->where('votable_id', $questionId)->exists()) {
            $questionVotes->updateExistingPivot($question, ['vote' => $vote]);
        } else {
            $questionVotes->attach($question, ['vote' => $vote]);
        }

        $question->load('votes');
        $upvotes = (int)$question->votes()->wherePivot('vote', 1)->sum('vote');
        $downvotes = (int)$question->votes()->wherePivot('vote', -1)->sum('vote');

        $question->votes_count = $upvotes + $downvotes;

        $question->save();
    }

    public function voteAnswer(Answer $answer, $vote)
    {
        $answerVotes = $this->answerVotes();
        $answerId = $answer->id;

        if ($answerVotes->where('votable_id', $answerId)->exists()) {
            $answerVotes->updateExistingPivot($answer, ['vote' => $vote]);
        } else {
            $answerVotes->attach($answer, ['vote' => $vote]);
        }

        $answer->load('votes');
        $upvotes = (int)$answer->votes()->wherePivot('vote', 1)->sum('vote');
        $downvotes = (int)$answer->votes()->wherePivot('vote', -1)->sum('vote');

        $answer->votes_count = $upvotes + $downvotes;

        $answer->save();
    }


}
