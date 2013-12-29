<?php

class Pocket extends Eloquent {

	protected $table = 'pockets';

	public static function update_total($new_total) {
		$last_total = Pocket::first();
		if (empty($last_total)) {
			$last_total = new Pocket;
		}

		$last_total->total = $new_total;

		$last_total->save();

	}
}