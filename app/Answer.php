<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    // User relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Question relationship
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function getBodyHtmlAttribute()
    {
        return \Parsedown::instance()->text($this->body);
    }

    //createdDate accessor
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
