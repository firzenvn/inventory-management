<?php

/**
 * Created by PhpStorm.
 * User: Hieu
 * Date: 06/11/2014
 * Time: 10:44 SA
 */
class InvoicesController extends BaseController
{
	protected $layout = "layouts.inventory";

	function __construct()
	{
		$this->beforeFilter('auth');
		$this->beforeFilter('acl');
	}

	public function getIndex()
	{
		$query = new Invoice();
		$order_id = Input::get('order_id');
		if (Input::has('seq_no'))
			$query = $query->where('seq_no', '=', Input::get("seq_no"));

		if (Input::has('bill_customer'))
			$query = $query->where('email', '=', Input::get("email"));
		if (Input::has('ship_customer'))
			$query = $query->where('phone_no', '=', Input::get("phone_no"));
		if (Input::has('gtb'))
			$query = $query->where('gtb', '=', Input::get("gtb"));
		if (Input::has('amount'))
			$query = $query->where('paid_total', '=', Input::get("amount"));
		if (Input::has('invoice_date')){
			$invoice_date = Input::get("invoice_date");
			$form = date_format(date_create($invoice_date['from']), 'Y-m-d '.'00:00:00');
			$to = date_format(date_create($invoice_date['to']), 'Y-m-d '.'23:59:99');
			$query = $query->whereBetween('created_at', array($form, $to));
		}
		$sort = Input::has('sort') ? Input::get('sort') : 'seq_no';
		$order = Input::get('order') === 'asc' ? 'asc' : 'desc';
		$query=$query->where('order_id','=',$order_id);
		$query=$query->where('client_id','=',Auth::user()->client_id)->orderBy($sort, $order);
		if($query->count() == 0){
			return Redirect::route('invoices.create.get',array('order_id'=>$order_id));
		}
		$rows = $query->paginate(20);

		$this->layout->content = View::make('invoices.index',array(
			'rows'=>$rows,
			'order_id'=>$order_id,
		));
	}

	public function getCreate()
	{
		$order_id = Input::get('order_id');
		$order = Order::find($order_id);
		if($this->checkQtyIsMax($order_id)){
			return Redirect::route('invoices.list', array('order_id' => $order_id))->with('warning', Lang::get('orders.warning_create_invoice'));
		}

		$this->layout->content = View::make('invoices.create')->with(array(
			'model' => $order,
		));

	}

	public function postCreate()
	{
		$order_id = Input::get('order_id');
		$product_order_item = Input::get('product_order_item');
		$qty_add = Input::get('qty_add');
		if($this->checkQtyIsMax($order_id)){
			return Redirect::route('invoices.list', array('order_id' => $order_id))->with('warning', Lang::get('orders.warning_create_invoice'));
		}

		if (empty($product_order_item)) {
			return Redirect::route('invoices.create.get', array('order_id' => $order_id))->with('error', Lang::get('orders.err_null_product'))->withInput();
		}
		$invoice = new Invoice();
		$invoice->order_id = $order_id;
		$invoice->client_id = Auth::user()->client_id;
		$invoice->status = Invoice::ACTIVE;
		$invoice->created_at = date('Y-m-d H:i:s');
		$price_total = 0;
		if ($invoice->save()) {
			foreach ($product_order_item as $key => $product_id) {
				if ($qty_add[$product_id] > 0) {
					$invoiceItem = new InvoiceItem();
					$invoiceItem->client_id = Auth::user()->client_id;
					$invoiceItem->invoice_id = $invoice->id;
					$invoiceItem->product_id = $product_id;
					$invoiceItem->qty_add = $qty_add[$product_id];
					$invoiceItem->created_at = date('Y-m-d H:i:s');
					$invoiceItem->save();

					//$invoiceItem = InvoiceItem::find($invoiceItem->id);
					$invoiceItem->sub_total = $invoiceItem->product->price * $invoiceItem->qty_add;
					$invoiceItem->save();
					$price_total += $invoiceItem->sub_total;

					//Update qty_to_invoice in Order Item
					$product_item = OrderItem::where('order_id','=',$order_id)
									->where('product_id','=',$product_id)->first();
					$product_item->qty_to_invoice = empty($product_item->qty_to_invoice) ? $invoiceItem->qty_add : $invoiceItem->qty_add + $product_item->qty_to_invoice ;
					$product_item->save();
				}
			}
			$invoice = Invoice::find($invoice->id);
			$invoice->paid_total = $price_total;
			$invoice->save();

			return Redirect::route('invoices.list', array('order_id' => $order_id))->with('success', Lang::get('orders.succ_update_invoice'));
		} else {
			return Redirect::route('invoices.create.get', array('order_id' => $order_id))->withErrors($invoice->errors)->withInput();
		}
	}

	public function getView()
	{
		$id = Input::get('id');
		$invoice = Invoice::find($id);
		if(empty($invoice))
			return Redirect::route('orders.list');
		$this->layout->content = View::make('invoices.view')->with(array(
			'order' => $invoice->order,
			'invoice' => $invoice,
		));
	}

	private function checkQtyIsMax($order_id){
		$order = Order::find($order_id);
		$sum_order_pro_qty = $order->orderItem->sum('qty_add');
		$sum_qty_to_invoice = $order->orderItem->sum('qty_to_invoice');
		if($sum_order_pro_qty == $sum_qty_to_invoice){
			return true;
		}
		return false;
	}


}