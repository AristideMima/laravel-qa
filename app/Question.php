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
        return route('questions.show', $this->id);
    }

    //createdDate accessor
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
