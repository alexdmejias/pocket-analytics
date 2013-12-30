<?php

class Pocket extends Eloquent {

	protected $table = 'pockets';

	public static function create_total($new_total) {

		$last_total = new Pocket;
		$last_total->total = $new_total;
		$last_total->created_at = new DateTime;
		$last_total->updated_at = new DateTime;

		$last_total->save();

	}
}