<?php
/**
 * Created by PhpStorm.
 * User: DONY
 * Date: 10/2/2014
 * Time: 11:37 PM
 */

class DashboardController extends BaseController {
	protected $layout = "layouts.inventory";

	function __construct(){
		$this->beforeFilter('auth');
	}

	public function getIndex()
	{
		$client_info = Client::find(Auth::user()->client_id);
		$total_order = Order::where('client_id','=',Auth::user()->client_id)->count();
		$total_amount = Order::where('client_id','=',Auth::user()->client_id)->sum('base_grand_total');
		$this->layout->content = View::make("inventory.index",array(
			'client_info'=>$client_info,
			'total_order'=>$total_order,
			'total_amount'=>$total_amount,
		));
	}
}