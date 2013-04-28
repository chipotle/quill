<?php

class Page extends Eloquent {

    /**
     * Database table used by model
     */
    protected $table = 'pages';

    protected $fillable = ['title', 'slug', 'body', 'head'];
}
