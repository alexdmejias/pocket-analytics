<?php

class PocketController extends BaseController {

	public function _config() {
		$config = array(
			'request_url' => 'https://getpocket.com/v3/oauth/request',
			'authorize_url' => 'https://getpocket.com/v3/oauth/authorize',
			'consumer_key' => Config::get('pocket.pocket.consumer_key'),
			'access_token' => Config::get('pocket.pocket.access_token'),
			'redirect_uri' => Config::get('pocket.pocket.redirect_uri')
		);

		return $config;
	}

	public function getConnect() {

		$config = $this->_config();

		$request_url = 'https://getpocket.com/v3/oauth/request';

		$data = array(
			'consumer_key' => $config['consumer_key'],
			'redirect_uri' => $config['redirect_uri']
		);
		$post_data = http_build_query($data);

		$opts = array(
		    'http' => array(
		        'method' => "POST",
		        'header' => "Connection: close\r\n".
		                    "Content-type: application/x-www-form-urlencoded\r\n".
		                    "Content-Length: ".strlen($post_data)."\r\n",
		        'content' => $post_data
		  )
		);

		$context  = stream_context_create($opts);
		$result = file_get_contents($request_url, false, $context);

		$code = explode('=', $result);
		$request_token = $code[1];

		header("Location: https://getpocket.com/auth/authorize?request_token=$request_token&redirect_uri=".$data['redirect_uri']."?request_token=$request_token");

	}

	public function getCallback() {
		$config = $this->_config();

		$consumer_key = $config['consumer_key'];
		$request_token = $_GET['request_token'];

		$config = array(
			'consumer_key' => $config['consumer_key'],
			'code' => $request_token
		);

		$post_data = http_build_query($config);

		$opts = array(
			'http' => array(
				'method' => 'POST',
				'header' => "Connection: close\r\n".
							"Content-type: application/x-www-form-urlencoded\r\n".
							"Content-Length: ".strlen($post_data)."\r\n",
				'content' => $post_data
			)
		);
		$context = stream_context_create($opts);
		$result = file_get_contents($config['url'], false, $context);

		echo $result;
	}

	public function getArticles($article_count = 10) {
		$config = $this->_config();
		$retrive_url = 'https://getpocket.com/v3/get?count='. $article_count;

        $data = array(
            'consumer_key' => $config['consumer_key'],
            'access_token' => $config['access_token']
        );
        $creds_data = http_build_query($data);

        $options = array(
	        'http' => array(
                'method'  => 'POST',
                'content' => http_build_query($data)
	        )
        );

		$request = array(
			'http' => array(
				'method' => 'POST',
				'header' => "Connection: close\r\n".
							"Content-type: application/x-www-form-urlencoded\r\n".
							"Content-Length: ".strlen($creds_data)."\r\n",
				'content' => $creds_data
			)
		);

		$context = stream_context_create($request);
		$result = file_get_contents($retrive_url, false, $context);

		$list = json_decode($result);

		return (array)$list->list;
	}

	public function getTotal() {
		$list = $this->getArticles(10000);

		return count($list);
	}

	public function getCounts($q = 10, $m = null) {
		return Pocket::orderBy('created_at','desc')->take($q)->get();
	}

	public function getInsert($key = '') {
		$total = $this->getTotal();

		$pocket = new Pocket;

		$pocket->fill(array('total' => $total));

		$last_save = Pocket::orderBy('id', 'desc')->first();

		if ($last_save->total != $total) {
			if (!$pocket->save()) {
				return 'error, could not save';
			} else {
				return 'saved';
			}
		} else {
			return "wrong time or key. key used was '$key' and time is " . date('i');
		}
	}

	public function getIndex() {
		$highest = Pocket::orderBy('total', 'desc')->first();
		$lowest = Pocket::orderBy('total')->first();
		$latest = Pocket::orderBy('id', 'desc')->first();

		return View::make('home')->with('highest', $highest)->with('lowest', $lowest)->with('latest', $latest);
	}

}