<?php

namespace Accolade\Cashew;

class Cache {

	public $cache_folder = '_cache/'; // cache store folder
	public $cache_time = 1 * 60 * 60; // in hour


	public function get_the_json($label, $url) {		
		if($data = $this->get_cache($label)){
			$data = json_decode($data);
		} else {
			$data = $this->fetch_data($url);
			$this->set_cache($label, $data);
			$data = json_decode($data);
		}

		return $data;
	}


	public function set_cache($label, $data){
		file_put_contents($this->cache_folder . $this->regex($label), $data);
	}


	public function get_cache($label){
		if($this->is_cached($label)){
			$filename = $this->cache_folder . $this->regex($label);
			return file_get_contents($filename);
		}

		return false;
	}

	public function is_cached($label){
		$filename = $this->cache_folder . $this->regex($label);

		if(file_exists($filename) && (filemtime($filename) + $this->cache_time >= time())) return true;

		return false;
	}
	
	//regex function to standardize a filename
	private function regex($filename){
		if (!file_exists($this->cache_folder)) {
			mkdir($this->cache_folder, 0755, true);
		}
		return preg_replace('/[^0-9a-z\.\_\-]/i','', strtolower($filename));
	}

	// Fetch API data using CURL
	public function fetch_data($url){
		if(function_exists("curl_init")){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			$content = curl_exec($ch);
			curl_close($ch);
			return $content;
		} else {
			return file_get_contents($url);
		}
	}

}
