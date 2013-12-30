<?php

	class CountController extends BaseController {

		public function getInsert() {
			$last_total = Pocket::all()->first();
			var_dump($last_total);

		}

		function getIndex() {
			return 'hi';
		}
	}