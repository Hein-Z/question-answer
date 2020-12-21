<?php

namespace App\Models\Traits;

use App\Models\Question;
use Illuminate\Support\Str;

trait Votable
{
    public function upVotes()
    {
        return $this->votes()->wherePivot('vote', 1);
    }

    public function downVotes()
    {
        return $this->votes()->wherePivot('vote', -1);
    }
}
