<?php
/**
 * Created by PhpStorm.
 * User: Bachviet
 * Date: 10/16/2014
 * Time: 9:09 AM
 */
class IdInventoryApi extends InventoryIDRestClient{
	const APP_ID = "2"; //change this to your app id
	const APP_SECRET = "cus123"; //change this to your app secret

	function registerUserOnId($user_info){

		$ticket=InventoryIDOauth2::encryptTicket($user_info);
		$post_array=array('register-ticket'=>$ticket,'_cid'=>self::APP_ID);
		$rs=$this->post('/users-api/create-by-ticket',$post_array);
		return $rs;
	}
}