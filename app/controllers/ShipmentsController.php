<?php

/**
 * Created by PhpStorm.
 * User: Hieu
 * Date: 06/11/2014
 * Time: 10:44 SA
 */
class ShipmentsController extends BaseController
{
	protected $layout = "layouts.inventory";

	function __construct()
	{
		$this->beforeFilter('auth');
		$this->beforeFilter('acl');
	}

	public function getIndex()
	{
		$query = new Shipment();
		$order_id = Input::get('order_id');

		if (Input::has('seq_no'))
			$query = $query->where('seq_no', '=', Input::get("seq_no"));
		if (Input::has('purchased_on'))
			$query = $query->where('purchased_on', '=', Input::get("purchased_on"));
		if (Input::has('bill_customer'))
			$query = $query->where('email', '=', Input::get("email"));
		if (Input::has('ship_customer'))
			$query = $query->where('phone_no', '=', Input::get("phone_no"));
		if (Input::has('gtb'))
			$query = $query->where('gtb', '=', Input::get("gtb"));
		if (Input::has('status'))
			$query = $query->where('status', '=', Input::get("status"));

		$sort = Input::has('sort') ? Input::get('sort') : 'seq_no';
		$order = Input::get('order') === 'asc' ? 'asc' : 'desc';
		$query=$query->where('order_id','=',$order_id);
		$query=$query->where('client_id','=',Auth::user()->client_id)->orderBy($sort, $order);
		if($query->count() == 0){
			return Redirect::route('shipments.create.get',array('order_id'=>$order_id));
		}
		$rows = $query->paginate(20);

		$this->layout->content = View::make('shipments.index',array(
			'rows'=>$rows,
			'order_id'=>$order_id,
		));
	}

	public function getCreate()
	{
		$order_id = Input::get('order_id');
		$order = Order::find($order_id);
		if($this->checkQtyIsMax($order_id)){
			return Redirect::route('shipments.list', array('order_id' => $order_id))->with('warning', Lang::get('orders.warning_create_shipments'));
		}
		$this->layout->content = View::make('shipments.create')->with(array(
			'model' => $order,
		));

	}

	public function getView()
	{
		$id = Input::get('id');
		$ship = Shipment::find($id);
		if(empty($ship))
			return Redirect::route('orders.list');
		$this->layout->content = View::make('shipments.view')->with(array(
			'order' => $ship->order,
			'ship' => $ship,
		));
	}

	public function postCreate()
	{
		$order_id = Input::get('order_id');
		$product_order_item = Input::get('product_order_item');
		$qty_to_ship = Input::get('qty_to_ship');
		if($this->checkQtyIsMax($order_id)){
			return Redirect::route('shipments.list', array('order_id' => $order_id))->with('warning', Lang::get('orders.warning_create_shipments'));
		}
		if (empty($product_order_item)) {
			return Redirect::route('shipments.create.get', array('order_id' => $order_id))->with('error', Lang::get('orders.err_null_product'))->withInput();
		}
		
		$ship = new Shipment();
		$ship->order_id = $order_id;
		$ship->client_id = Auth::user()->client_id;
		$ship->status = Shipment::ACTIVE;
		$ship->created_at = date('Y-m-d H:i:s');
		$price_total = 0;
		$ship_total = 0;
		if ($ship->save()) {
			foreach ($product_order_item as $key => $product_id) {
				if ($qty_to_ship[$product_id] > 0) {
					$shipmentItem = new ShipmentItem();
					$shipmentItem->client_id = Auth::user()->client_id;
					$shipmentItem->shipment_id = $ship->id;
					$shipmentItem->product_id = $product_id;
					$shipmentItem->qty_add = $qty_to_ship[$product_id];
					$shipmentItem->created_at = date('Y-m-d H:i:s');
					$shipmentItem->save();

					//$shipmentItem = ShipmentItem::find($shipmentItem->id);
					$shipmentItem->sub_total = $shipmentItem->product->price * $shipmentItem->qty_add;
					$shipmentItem->save();
					$price_total += $shipmentItem->sub_total;
					$ship_total ++;

					//Update qty_to_ship in Order Item
					$product_item = OrderItem::where('order_id','=',$order_id)
						->where('product_id','=',$product_id)->first();
					$product_item->qty_to_ship = empty($product_item->qty_to_ship) ? $shipmentItem->qty_add : $shipmentItem->qty_add + $product_item->qty_to_ship ;
					$product_item->save();
				}
			}

			$ship = Shipment::find($ship->id);
			$ship->paid_total = $price_total;
			$ship->ship_total = $ship_total;
			$ship->save();
			return Redirect::route('shipments.list', array('order_id' => $order_id))->with('success', Lang::get('orders.succ_update_ship'));
		} else {
			return Redirect::route('shipments.create.get', array('order_id' => $order_id))->withErrors($ship->errors)->withInput();
		}
	}

	private function checkQtyIsMax($order_id){
		$order = Order::find($order_id);
		$sum_order_pro_qty = $order->orderItem->sum('qty_add');
		$sum_qty_to_ship = $order->orderItem->sum('qty_to_ship');
		if($sum_order_pro_qty == $sum_qty_to_ship){
			return true;
		}
		return false;
	}


}