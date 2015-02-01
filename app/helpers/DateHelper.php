<?php
/**
 * Created by PhpStorm.
 * User: Firzen
 * Date: 11/27/2014
 * Time: 10:01 AM
 */

class DateHelper {
	public static function getCurrentDate(){
		return date('Y-m-d', time());
	}

	public static function getCurrentDateTime(){
		return date('Y-m-d H:i:s', time());
	}

	public static function getDateXDaysAgo($x){
		return date("Y-m-d", strtotime("-$x days", time()));
	}
} 