<?php
/**
 * Created by PhpStorm.
 * User: Hieu
 * Date: 23/10/2014
 * Time: 9:55 SA
 */
class Package extends Eloquent{

	protected $table = 'packages';

	const UNLIMITED = 0;
	const FREE_UNIT_PRICE = 0;
}