<?php

class Issue extends BaseModel {

    /**
     * Database table used by model
     */
    protected $table = 'issues';

    public static $rules = [
		'number' => 'required|numeric|min:1',
		'volume' => 'required|numeric|min:1',
		'pub_date' => 'required|date_format:Y-m-d',
	];

    /**
     * Issue hasMany Stories
     */
    function stories()
    {
        return $this->hasMany('Story');
    }

}
