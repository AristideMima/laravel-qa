<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $appends = ['url', 'avatar'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function questions(){
        return $this->hasMany(Question::class);
    }

    /* Defining our accessors */

    //ulr accessor
    public function getUrlAttribute()
    {
        //return route('questions.show', $this->id);

        return '#';
    }

    //Avatar accessor
    public function getAvatarAttribute()
    {
        $email = $this->email;
        $size = 30;

        return $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . "&s=" . $size;
    }
    //Answers relationship
    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Question::class, 'favorites')->withTimestamps();
    }

    public function voteQuestions()
    {
        return $this->morphedByMany(Question::class, 'votable');

    }

    public function voteAnswers()
    {
        return $this->morphedByMany(Answer::class, 'votable');
    }

    public function voteQuestion(Question $question, $vote)
    {
        $voteQuestions = $this->voteQuestions();

        $this->_vote($voteQuestions, $question, $vote);
    }

    public function voteAnswer(Answer $answer, $vote)
    {
        $voteAnswers = $this->voteAnswers();
        $this->_vote($voteAnswers, $answer, $vote);

    }

    private function _vote($relationship, $model, $vote)
    {
        if($relationship->where('votable_id', $model->id)->exists())
        {
            $relationship->updateExistingPivot($model, ['vote' => $vote]);
        }else{
            $relationship->attach($model, ['vote' => $vote]);
        }

        $model->load('votes');
        $downvote = (int) $model->downVotes()->sum('vote');
        $upvote = (int) $model->upVotes()->sum('vote');

        $model->votes_count = $upvote + $downvote;
        $model->save();
    }
}
