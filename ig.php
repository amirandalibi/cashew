<?php

namespace EI\Cashew;
require_once('cache.php');

class APICall extends Cache {

	
	function InstagramOAuth($label, $userid, $accessToken, $count = 20){
			return $this->get_the_json($label, 'https://api.instagram.com/v1/users/'.$userid.'/media/recent/?access_token='.$accessToken.'&count='.$count.'');
	}

}