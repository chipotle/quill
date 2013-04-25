<?php

class Author extends Eloquent {

    /**
     * Database table used by model
     */
    protected $table = 'authors';

    /**
     * Class Constants
     */

    const SHOW_NAME = 10;
    const SHOW_NICK = 20;
    const SHOW_BOTH = 30;

    public function user()
    {
        return $this->belongsTo('User');
    }
}
