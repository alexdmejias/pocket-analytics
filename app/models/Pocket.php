<?php

class Pocket extends Eloquent {

	protected $table = 'pockets';
	protected $fillable = array('total');

	public function get_highest() {
		return static::orderBy('total', 'desc')->first();
	}
}