<?php 
class telegramm{
	
	public $url = 'https://api.telegram.org/bot';
	protected $request_url;
	
	function __construct($token){
		$this->request_url = $this->url . $token;
	}
	
	public function post_message($text, $chat_id){
		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => $this->request_url . '/sendMessage',
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_POSTFIELDS => array(
                'chat_id' => $chat_id,
                'text' => $text,
            ),
		]);

		$return = curl_exec($curl);
		curl_close($curl);
		return json_decode($return, true);
	}
	
	public function get_updates(){
		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => $this->request_url . '/getUpdates',
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 10,       
		]);

		$return = curl_exec($curl);
		curl_close($curl);
		return json_decode($return, true);
	}
}
