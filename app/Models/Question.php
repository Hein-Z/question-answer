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
        return $this->belongsToMany(User::class, 'favourites', 'question_id', 'user_id');
    }

    public function isFavourite()
    {
        return in_array(Auth::user()->id, $this->favourites->pluck('id')->toArray());
    }

    public function getStatusAttribute()
    {
        return $this->isFavourite() ? 'favorited' : '';
    }


}

