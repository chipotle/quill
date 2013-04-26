<?php

class Page extends Eloquent {

    /**
     * Database table used by model
     */
    protected $table = 'pages';

    /**
     * Issue hasMany Stories
     */
    function stories()
    {
        return $this->hasMany('Story');
    }

}
