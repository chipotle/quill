<?php

class Story extends Eloquent {

    /**
     * Database table used by model
     */
    protected $table = 'stories';

    /**
     * Story belongsTo Issue
     */
    function issue()
    {
        return $this->belongsTo('Issue');
    }

    /**
     * Story belongsTo Author
     */
    function author()
    {
        return $this->belongsTo('Author');
    }

}