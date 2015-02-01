<?php
/**
 * Created by PhpStorm.
 * User: Hoangtv
 * Date: 12/17/2014
 * Time: 1:54 PM
 */
class StocksController extends BaseController{
	protected $layout = "layouts.inventory";
	function __construct(){
		$this->beforeFilter('auth');
		$this->beforeFilter('acl');
	}

	public function getIndex(){
		$this->layout->content=View::make('stocks.index');
	}

	public function getSend(){

	}

	public function postSend(){

	}

	public function getRequest(){

	}

	public function postRequest(){

	}
}