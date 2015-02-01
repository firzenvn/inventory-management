<?php

class HomeController extends BaseController {
	protected $layout = "layouts.home";

	function __construct(){
		$this->beforeFilter('guest');
	}

	public function getIndex()
	{
		$this->layout->content = View::make("home.index");
	}
}
