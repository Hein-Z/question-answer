<?php

namespace App\Models;

use App\Models\Traits\Slugify;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use function Symfony\Component\Translation\t;

class Question extends Model
{
    use HasFactory;
    use Slugify;

    protected $fillable = ['title', 'body', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = $this->createSlug($value);
    }

    public function getUrlAttribute()
    {
        return route('question.show', $this->slug);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getGravatorAttribute()
    {
        $size = 35;
        $email = $this->user->email;
        $grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "s=" . $size;
        return $grav_url;
    }

    public function favourites()
    {
        return $this->belongsToMany(User::class, 'favourites');
    }

    public function isFavourite()
    {
        return $this->favourites()->where('user_id', Auth::user()->id)->exists();
    }

    public function getStatusAttribute()
    {
        return $this->isFavourite() ? 'favorited' : '';
    }

    public function votes()
    {
        return $this->morphToMany(User::class, 'votable', 'votables', 'votable_id', 'user_id');
    }

    public function downVoteStatus($user)
    {
        $questionVotes = $this->votes();
        $isDownVote = $questionVotes->where('user_id', $user->id)->wherePivot('vote', -1)->exists();
        return $isDownVote ? 'disabled' : '';
    }

    public function upVoteStatus($user)
    {
        $questionVotes = $this->votes();
        $isUpVote = $questionVotes->where('user_id', $user->id)->wherePivot('vote', 1)->exists();
        return $isUpVote ? 'disabled' : '';
    }
}

