<?php

class PocketController extends BaseController {

	public function _config() {
		$config = array(
			'request_url' => 'https://getpocket.com/v3/oauth/request',
			'authorize_url' => 'https://getpocket.com/v3/oauth/authorize',
			'consumer_key' => '21250-15764f0901f9abc158cfafe6',
			'access_token' => '56f54cc1-bb79-7d46-de6e-fb4af0',
			'redirect_uri' => 'http://pocket.dev/index.php/pocket/callback'
		);

		return $config;
	}

	public function getConnect() {

		$config = $this->_config();

		$config['request_url'] = 'https://getpocket.com/v3/oauth/request';

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

	public function _retrieve_articles($article_count = 10) {
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

		return $list->list;

	}

	public function _get_total_count() {
		$list = $this->_retrieve_articles(10000);

		return count((array)$list);
	}

	public function getArticles($article_count = 10) {
		$list = $this->_retrieve_articles($article_count);
		$list_count = count((array)$list);
		$data['list'] = $list;
		$data['count'] = $list_count;
		$this->load->view('list', $data);
	}

	public function getFull() {
		$list = $this->_retrieve_articles(10000);

		$data['list'] = $list;
		$data['count'] = count((array)$list);
		// $this->load->view('list', $data);
		return View::make('pocket', ['data'=> $data]);
	}

	// public function getIndex() {
	public function index() {
	  	return View::make('hello');

	}

	/*public function getProfile() {
		return $this->_config();
	}*/

}