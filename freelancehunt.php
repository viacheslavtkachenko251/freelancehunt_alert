<?php
class freelancehunt{
	private $api_token; // ваш идентификатор
	private $api_secret; // ваш секретный ключ
	public  $method = "GET";
	public  $url_project = "https://api.freelancehunt.com/my/feed";
	public  $url_new_message = "https://api.freelancehunt.com/threads?filter=new";
	
	function __construct($api_token, $api_secret){
		$this->api_token  = $api_token;
		$this->api_secret = $api_secret;
		
	}
	private function sign($api_secret, $url, $method, $post_params = '') {
		return base64_encode(hash_hmac("sha256", $url.$method.$post_params, $api_secret, true));
	}
	
	public function get_request($url){
		$signature = $this->sign($this->api_secret, $url, $this->method); // реализацию функции смотрите выше
		$curl = curl_init();
		curl_setopt_array($curl, [    
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_USERPWD        => $this->api_token . ":" . $signature,
			CURLOPT_URL            => $url
		]);

		$return = curl_exec($curl);
		curl_close($curl);		
		return json_decode($return, true);
	}
	
	public function get_new_project(){
		$list = $this->get_request($this->url_project); 
		if(!empty($list)){
			$projects = array();
			foreach($list as $v){
				if($v['is_new'] == 1){
					$url = 'https://api.freelancehunt.com/projects/' . $v['related']['project_id'];
					$projects[] = $this->get_request($url);
				}
			}
		return $projects;
		}
	
	}
	
	public function get_new_message(){
		$list = $this->get_request($this->url_new_message); 
		if(!empty($list)){
			$v = array_pop($list);
			$url = "https://api.freelancehunt.com/threads/" .$v["thread_id"];	
			$test_message = $this->get_request($url); 
			return array_pop($test_message);
		}
	
	}
}
