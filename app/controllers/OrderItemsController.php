<?php
/**
 * Created by PhpStorm.
 * User: Hieu
 * Date: 06/11/2014
 * Time: 10:44 SA
 */

class OrderItemsController extends BaseController{
	protected $layout = "layouts.inventory";

	function __construct(){
		$this->beforeFilter('auth');
		$this->beforeFilter('acl');
	}

	public function getDelete()
	{
		$id = Input::get('id');
		$orderItem = OrderItem::find($id);
		$order = Order::find($orderItem->order_id);

		$count_invoice = $order->invoice->count();
		$count_ship = $order->shipment->count();

		if($count_invoice ==0 && $count_ship == 0){
			$price_total = $order->base_grand_total - ($orderItem->product->price * $orderItem->qty_add);
			$order->base_grand_total = $price_total;
			$order->purchased_grand_total = $price_total;
			$order->save();
			if($orderItem->delete()){
				return Redirect::route('orders.update',array('id'=>$orderItem->order_id))->with('success', Lang::get('orders.delete_order_item_success'));
			}
		} else{
			return Redirect::route('orders.update',array('id'=>$orderItem->order_id))->with('warning', Lang::get('orders.delete_order_item_warning_inv_ship'));
		}


	}
}