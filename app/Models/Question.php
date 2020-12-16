<?php

namespace App\Models;

use App\Models\Traits\Slugify;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    use Slugify;

    protected $fillable=['title','body','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function setTitleAttribute($value){
        $this->attributes['title']=$value;
        $this->attributes['slug']= $this->createSlug($value);
    }

    public function getUrlAttribute(){
        return route('question.show',$this->slug);
    }

    public function getCreatedDateAttribute(){
        return $this->created_at->diffForHumans();
    }

}

