<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        if($this->answers > 0)
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
}
