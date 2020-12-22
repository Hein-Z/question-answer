<?php

namespace App\Models;

use App\Models\Traits\Slugify;
use App\Models\Traits\Votable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Facades\Auth;
use function Symfony\Component\Translation\t;

class Question extends Model
{
    use HasFactory;
    use Slugify;
    use Votable;

    protected $fillable = ['title', 'body', 'user_id'];
    protected $appends = ['created_date', 'is_favourited'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class)->orderByDesc('votes_count');
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

    public function getBodyHtmlAttribute()
    {
        return Markdown::parse(strip_tags($this->body));
    }

    public function getExcreptAttribute()
    {
        $dot = (strlen($this->body) > 400 ? '...' : '');
        return Markdown::parse(strip_tags(substr($this->body, 0, 400) . $dot));
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }


    public function favourites()
    {
        return $this->belongsToMany(User::class, 'favourites');
    }

    public function isFavourited()
    {
        if (!Auth::check()) {
            return false;
        }
        return $this->favourites()->where('user_id', Auth::user()->id)->exists();
    }

    public function getIsFavouritedAttribute()
    {
        return $this->isFavourited();
    }

    public function votes()
    {
        return $this->morphToMany(User::class, 'votable', 'votables', 'votable_id', 'user_id');
    }

    public function getDownVoteStatusAttribute()
    {
        if (!Auth::check()) {
            return 'disabled';
        }
        $questionVotes = $this->votes();
        $isDownVote = $questionVotes->where('user_id', Auth::user()->id)->wherePivot('vote', -1)->exists();
        return $isDownVote ? 'disabled' : '';
    }

    public function getUpVoteStatusAttribute()
    {
        if (!Auth::check()) {
            return 'disabled';
        }
        $questionVotes = $this->votes();
        $isUpVote = $questionVotes->where('user_id', Auth::user()->id)->wherePivot('vote', 1)->exists();
        return $isUpVote ? 'disabled' : '';
    }


}

