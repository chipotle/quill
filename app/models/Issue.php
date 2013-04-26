<?php

class Issue extends Eloquent {

    /**
     * Database table used by model
     */
    protected $table = 'issues';

    /**
     * Issue hasMany Stories
     */
    function stories()
    {
        return $this->hasMany('Story');
    }

}
