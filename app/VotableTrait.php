<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 05/08/2020
 * Time: 03:14
 */

namespace App;


trait VotableTrait
{
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