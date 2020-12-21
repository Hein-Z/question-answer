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

    protected $appends=['gravator'];

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

    public function getGravatorAttribute()
    {
        $size = 35;
        $email = $this->email;
        $grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "s=" . $size;
        return $grav_url;
    }

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

    public function voteQuestion($question, $vote)
    {
        $questionVotes = $this->questionVotes();
        return $this->_vote($questionVotes, $question, $vote);
    }

    public function voteAnswer(Answer $answer, $vote)
    {
        $answerVotes = $this->answerVotes();
        return $this->_vote($answerVotes, $answer, $vote);
    }

    private function _vote($relationshipVotes, $model, $vote)
    {
        if ($relationshipVotes->where('votable_id', $model->id)->exists()) {
            $relationshipVotes->updateExistingPivot($model, ['vote' => $vote]);
        } else {
            $relationshipVotes->attach($model, ['vote' => $vote]);
        }

        $model->load('votes');
        $upvotes = (int)$model->upVotes()->sum('vote');
        $downvotes = (int)$model->downVotes()->sum('vote');

        $model->votes_count = $upvotes + $downvotes;

        $model->save();

        return $upvotes + $downvotes;
    }


}
