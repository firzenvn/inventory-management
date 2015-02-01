<?php
/**
 * Created by PhpStorm.
 * User: Hieu
 * Date: 06/11/2014
 * Time: 10:44 SA
 */

class OrdersController extends BaseController{
	protected $layout = "layouts.inventory";

	function __construct(){
		$this->beforeFilter('auth');
		$this->beforeFilter('acl');
	}

	public function getIndex()
	{
		$query = new Order();
		if (Input::has('seq_no'))
			$query = $query->where('seq_no', '=', Input::get("seq_no"));

		if (Input::has('bill_customer')){
			$customer=Customer::where('client_id' , '=',Auth::user()->client_id)
							->where('first_name','=',Input::get("bill_customer"))->first();
			$customer_id=0;
			if(!empty($customer)){
				$customer_id=$customer->id;
			}
			$query = $query->where('bill_customer_id', '=',$customer_id);
		}
		if (Input::has('ship_customer')){
			$customer=Customer::where('client_id' , '=',Auth::user()->client_id)
				->where('first_name','=',Input::get("ship_customer"))->first();
			$customer_id=0;
			if(!empty($customer)){
				$customer_id=$customer->id;
			}
			$query = $query->where('ship_customer_id', '=',$customer_id);
		}
		if (Input::has('gtb'))
			$query = $query->where('gtb', '=', Input::get("gtb"));
		if (Input::has('gtp'))
			$query = $query->where('gtp', '=', Input::get("gtp"));
		if (Input::has('status'))
			$query = $query->where('status', '=', Input::get("status"));
		if (Input::has('purchased_on')){
			$purchased_on = Input::get("purchased_on");
			if(!empty($purchased_on['from']) && !empty($purchased_on['to'])){
				$form = date_format(date_create($purchased_on['from']), 'Y-m-d '.'00:00:00');
				$to = date_format(date_create($purchased_on['to']), 'Y-m-d '.'23:59:99');
				$query = $query->whereBetween('purchased_on', array($form, $to));
			}
		}
		$sort = Input::has('sort') ? Input::get('sort') : 'seq_no';
		$order = Input::get('order') === 'asc' ? 'asc' : 'desc';
		$query=$query->where('client_id','=',Auth::user()->client_id)->orderBy($sort, $order);
		$rows = $query->paginate(20);

		$this->layout->content = View::make('orders.index',array(
			'rows'=>$rows,
		));
	}

	public function getCreate()
	{
		$this->layout->content = View::make('orders.create');
	}

	public function postCreate()
	{

		$product_items = Input::get('product_item');
		$qty_to_add = Input::get('qty_to_add');
		$bill_customer_id = Input::get('bill_customer_id');
		$ship_customer_id = Input::get('ship_customer_id');
		$order_status = Input::get('status');

		$validator = Validator::make(Input::all(), array(
			'search_customer' => 'required',
			'product_item' => 'required',
			'status' => 'required',
		));

		Session::put('product_items', $product_items);
		Session::put('qty_to_add', $qty_to_add);
		if (!$validator->passes()) {
			return Redirect::route('orders.create')->with('error',$validator->messages()->all())->withInput();
		}
		if(empty($product_items)){
			return Redirect::route('orders.create')->with('error', Lang::get('orders.err_null_product'))->withInput();
		}

		$order = new Order();
		$order->client_id = Auth::user()->client_id;
		$order->status = $order_status;
		$order->bill_customer_id = $bill_customer_id;
		$order->ship_customer_id = $ship_customer_id;
		$order->base_grand_total = 0;
		$order->purchased_grand_total = 0;
		$order->purchased_on = date('Y-m-d H:i:s');
		$order->created_at = date('Y-m-d H:i:s');

		$price_total = 0;
		if($order->save()){
			foreach($product_items as $key => $product_id){
				if($qty_to_add[$product_id] == 0){
					return Redirect::route('orders.create')->with('error', Lang::get('orders.err_qty_product'))->withInput();
				}
				$orderItem = new OrderItem();
				$orderItem->client_id = Auth::user()->client_id;
				$orderItem->order_id = $order->id;
				$orderItem->product_id = $product_id;
				$orderItem->qty_add = $qty_to_add[$product_id];
				$order->created_at = date('Y-m-d H:i:s');
				$orderItem->save();
				$price_total += $orderItem->product->price*$orderItem->qty_add;
			}

			$order = Order::find($order->id);
			$order->base_grand_total = $price_total;
			$order->purchased_grand_total = $price_total;
			$order->save();

			return Redirect::route('orders.list')->with('success', Lang::get('orders.succ_create_order'));
		}else{
			return Redirect::route('orders.create')->withErrors($order->errors)->withInput();
		}

	}

	public function getUpdate()
	{
		$id = Input::get('id');
		$model = Order::find($id);

		$this->layout->content = View::make('orders.update')->with(array(
			'model'=>$model,
		));
	}

	public function postUpdate()
	{
		$id = Input::get('order_id');
		$product_items = Input::get('product_item');
		$qty_to_add = Input::get('qty_to_add');
		$product_order_items = Input::get('product_order_item');
		$product_qty = Input::get('product_qty');

		$order = Order::find($id);
		$order->status = Input::get('status');
		$price_total = 0;
		if(!empty($product_order_items)) {
			foreach ($product_order_items as $key => $product_id) {
				if ($product_qty[$product_id] == 0) {
					return Redirect::route('orders.update', array('id' => $id))->with('error', Lang::get('orders.err_qty_product'))->withInput();
				}
				$orderItem = OrderItem::where('order_id', '=', $id)->where('product_id', '=', $product_id)->first();
				$orderItem->qty_add = $product_qty[$product_id];
				$orderItem->updated_at = date('Y-m-d H:i:s');
				$orderItem->save();
				$price_total += $orderItem->product->price * $orderItem->qty_add;
			}
		}
		if(!empty($product_items)){
			foreach($product_items as $key => $product_id) {
				if($qty_to_add[$product_id] != 0){
					$orderItem = OrderItem::firstOrNew(array(
						'order_id' => $id,
						'product_id' => $product_id,
					));

					$orderItem->client_id = Auth::user()->client_id;
					$orderItem->order_id = $id;
					$orderItem->product_id = $product_id;
					$orderItem->qty_add = empty($orderItem->qty_add) ? $qty_to_add[$product_id] : $orderItem->qty_add + $qty_to_add[$product_id];
					$orderItem->save();
					$price_total += $orderItem->product->price * $orderItem->qty_add;
				}
			}
		}
	//	$order = Order::find($order->id);
		$order->base_grand_total = $price_total;
		$order->purchased_grand_total = $price_total;
		$order->save();

		return Redirect::route('orders.update',array('id'=>$id))->with('success',Lang::get('orders.succ_update_order'));
	}

	public function getDelete()
	{
		$id = Input::get('id');
		$row = Order::find($id);

		DB::beginTransaction();
		try{
			$row->orderItem()->delete();

			if($row->invoice->count() > 0)
				foreach($row->invoice as $item){
					$item->invoiceItem()->delete();
				}
			$row->invoice()->delete();

			if($row->shipment->count() > 0)
				foreach($row->shipment as $item){
					$item->shipmentItem()->delete();
				}
			$row->shipment()->delete();

			$row->delete();
			DB::commit();
			return Redirect::route('orders.list')->with('success', Lang::get('orders.delete_orders_success'));
		}catch (Exception $e){
			DB::rollBack();
			return Redirect::route('orders.list')->with('error', $e->getMessage());
		}
	}

	public function postSearchCustomer()
	{
		$html = '';
		$key = Input::get('key');
		$customers = null;
		if(empty($key)){
			return;
		}
		if(is_numeric($key)){
			$customers = Customer::where('phone_no', 'LIKE', '%'.$key.'%')->where('client_id','=',Auth::user()->client_id)->get();
		}else{
			$customers = Customer::where('email', 'LIKE', '%'.$key.'%')->where('client_id','=',Auth::user()->client_id)->get();
		}
		if(!empty($customers)){
			foreach($customers as $cus){
				$html .= "<li   onclick='addCustomerInfo(this);' class='customer_item' id='cus_" .  $cus->id . "' data-options='". json_encode($cus->attributesToArray()) ."' class=''><a href='javascript: void(0)' >" . $cus->first_name . "<br><span><strong>Email:</strong> " . $cus->email . "</span><br><span><strong>SĐT:</strong> " . $cus->phone_no . "</span></a></li>";
			}
		}
		return $html;
	}

	public function getListProducts()
	{
		$query = new Product();
		if (Input::has('id'))
			$query = $query->where('id', '=', Input::get("id"));
		if (Input::has('sku'))
			$query = $query->where('sku', '=', Input::get("sku"));
		if (Input::has('price'))
			$query = $query->where('price', '=', Input::get("price"));
		if (Input::has('quantity'))
			$query = $query->where('quantity', '=', Input::get("quantity"));
		if (Input::has('status'))
			$query = $query->where('status', '=', Input::get("status"));
		if (Input::has('name'))
			$query = $query->where('name', 'like', '%' . Input::get("name") . '%');
		if (Input::has('description'))
			$query = $query->where('description', 'like', '%' . Input::get("description") . '%');

		$sort = Input::has('sort') ? Input::get('sort') : 'id';
		$order = Input::get('order') === 'asc' ? 'asc' : 'desc';
		$query = $query->where('client_id', '=', Auth::user()->client_id)->orderBy($sort, $order);
		$rows = $query->paginate(20);

		return  View::make('orders.listProducts', array(
			'rows' => $rows,
		));
	}


}