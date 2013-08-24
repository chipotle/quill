<?php

class Image extends BaseModel {

	protected $table = 'images';

	/**
	 * Image belongsTo (table) polymorphic
	 */
	public function imageable()
	{
		return $this->morphTo();
	}
}
