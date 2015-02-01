<?php
/**
 * Created by PhpStorm.
 * User: DONY
 * Date: 12/2/2014
 * Time: 8:32 AM
 */

class DashboardAdminController extends BaseAdminController {
	protected $layout = "layouts.inventory";

	public function getIndex()
	{
		$client_info = Client::find(Auth::user()->client_id);
		$total_order = Order::count();
		$total_amount = Order::sum('base_grand_total');
		$this->layout->content = View::make("inventory.index",array(
			'client_info'=>$client_info,
			'total_order'=>$total_order,
			'total_amount'=>$total_amount,
		));
	}
} 