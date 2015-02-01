<?php
/**
 * Created by PhpStorm.
 * User: Firzen
 * Date: 8/21/14
 * Time: 9:13 AM
 */

class InventoryIDRestClient extends RestClient {

	const APP_ID = "2"; //change this to your app id
	const APP_SECRET = "cus123"; //change this to your app secret

	public function get($path, $params=array(), $headers = array(), $timeout = 30) {
		$this->_signData($params);
		$payload=http_build_query($params);
		$path.='?'.$payload;
		$response = parent::get(Config::get('constant.inventory_id_base_url').$path, $headers, $timeout);
		return json_decode($response->getContent(),true);
	}

	public function post($path, $params=array(), $headers = array(), $timeout = 30) {
		$this->_signData($params);
		$payload=http_build_query($params);
		$response = parent::post(Config::get('constant.inventory_id_base_url').$path, $payload, $headers, $timeout);
		return json_decode($response->getContent(),true);
	}

	protected function _signData(&$params){
		$params['client_id']=self::APP_ID;
		ksort($params);
		$params['checksum'] = hash_hmac('SHA1',implode('|',$params),self::APP_SECRET);
	}
} 