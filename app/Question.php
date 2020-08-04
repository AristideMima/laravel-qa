<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Answer;

class Question extends Model
{
    //

    protected $fillable = ['title', 'body'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    //Title mutator
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = \Str::slug($value);
    }

    /* Defining our accessors */

    //ulr accessor
    public function getUrlAttribute()
    {
        return route('questions.show', $this->slug);
    }

    //createdDate accessor
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    //Display status
    public function getStatusAttribute()
    {
        if($this->answers_count > 0)
        {
            if($this->best_answer_id)
            {
                return "answered-accepted";
            }

            return "answered";
        }

        return "unanswered";
    }

    public function getBodyHtmlAttribute()
    {
        return \Parsedown::instance()->text($this->body);
    }

    //Answers relationship
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function acceptBestAnswer($answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites()->count();
    }

    public function votes()
    {
        return $this->morphToMany(User::class, 'votable');
    }

    public function upVotes()
    {
        return $this->votes()->wherePivot('vote', 1);
    }

    public function downVotes()
    {
        return $this->votes()->wherePivot('vote', -1);
    }
}
