<?php

namespace Accolade\Cashew;
require_once('cache.php');

class InstagramOAuth extends Cache {

	public function get_feed($label, $userid, $accessToken){
			return parent::get_the_json($label, 'https://api.instagram.com/v1/users/'.$userid.'/media/recent/?access_token='.$accessToken.'&count=20');
	}

}