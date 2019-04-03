<?php 
/* version 1.0
 * $token - token of telegramm bot
 * $chat_id - id chat fof telegramm may be different
 * read telegramm api https://core.telegram.org/bots/api
 * 
 * $api_token - token freelancehunt
 * $api_secret - secret key freelancehunt
 * read https://freelancehunt.com/my/api
 *  */

require_once 'freelancehunt.php';
require_once 'telegramm.php';

$telegramm = new telegramm($token); 


$freelancehunt = new freelancehunt($api_token, $api_secret);
$private_message = $freelancehunt->get_new_message(); 
$new_projects = $freelancehunt->get_new_project();

if(!empty($private_message)){
	$string =  $private_message["from"]["fname"] . " " . $private_message["from"]["sname"] . "\n" . $private_message["message_html"] . "\n" .  $private_message["post_time"] . "\n\n";
	$telegramm->post_message($string, $chat_id);
}

if(!empty($new_projects)){
	foreach($new_projects as $v ){
		$string = $v["url"] . "\n" .$v["description"] . "\n" . $v["status_name"] . "\n\n";
		$telegramm->post_message($string, $chat_id);
	}
}

