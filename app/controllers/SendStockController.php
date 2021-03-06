<?php
/**
 * Created by PhpStorm.
 * User: DONY
 * Date: 12/24/2014
 * Time: 11:50 PM
 */

class SendStockController extends BaseController {
	protected $layout = "layouts.inventory";
	function __construct(){
		$this->beforeFilter('auth');
		$this->beforeFilter('acl');
	}

	public function getIndex(){
		$query = new SendStock();
		if (Input::has('source_warehouse'))
			$query = $query->whereHas('source', function($q){
				$q->where('name', '=', Input::get("source_warehouse"));
			});
		if (Input::has('destination_warehouse'))
			$query = $query->whereHas('destination', function($q){
				$q->where('name', '=', Input::get("destination_warehouse"));
			});
		if (Input::has('seq_no'))
			$query = $query->where('seq_no', '=', Input::get("seq_no"));
		if (Input::has('created_at_from') && Input::has('created_at_to')){
			$query = $query->where('created_at','>=',Input::has('created_at_from'));
			$query = $query->where('created_at','<=',Input::has('created_at_to'));
		}
		if (Input::has('created_by'))
			$query = $query->where('created_by', '=', Input::get("created_by"));

		$query = $query->where('client_id', '=', Auth::user()->client_id);
		$rows = $query->paginate(10);

		$this->layout->content=View::make('sendStock.index',array(
			'rows'=>$rows,
		));
	}

	public function getCreate()
	{
		$this->layout->content=View::make('sendStock.create');
	}

	public function postCreateSending()
	{
		$source_id = Input::get('source_id');
		$destination_id = Input::get('destination_id');
		$sendStock = new SendStock();
		$sendStock->client_id = Auth::user()->client_id;
		$sendStock->source_warehouse_id = $source_id;
		$sendStock->destination_warehouse_id = $destination_id;
		if($sendStock->save())
			return Redirect::route('sendStock.add_detail.get',array('sending_id'=>$sendStock->id))->with('success',Lang::get('label.send_new_stock_success'));
		else
			return Redirect::back()->withInput()->with('error',$sendStock->error);
	}

	public function getUpdate()
	{
		//
	}

	public function getAddDetailSending()
	{
		$id=Input::get('sending_id');
		$sendStock=SendStock::where('client_id','=',Auth::user()->client_id)->find($id);
		if(empty($sendStock))
			return $this->layout->content=View::make('sendStock.index')->with('error',Lang::get('send_stock_not_exist'));

		$product_item=WarehouseProduct::where('warehouse_id','=',$sendStock->source_warehouse_id)->get();
		$this->layout->content=View::make('sendStock.add_detail')->with(array(
			'model'=>$sendStock,
			'products'=>$product_item
		));
	}

	public function postAddDetailSending()
	{
		$id=Input::get('sending_id');
		$sendStock=SendStock::where('client_id','=',Auth::user()->client_id)->find($id);
		if(empty($sendStock))
			return $this->layout->content=View::make('sendStock.index')->with('error',Lang::get('send_stock_not_exist'));

		$reasons = Input::get('reasons');
		if(Input::has('content')){
			$product_list=(array)json_decode(Input::get('content'));
			$count=0;
			$data=array();
			$qty=array();
			foreach($product_list as $k=>$v){
				if($k==0)
					continue;
				$data[]=$v[0];
				$qty[$v[0]]=$v[1];
				$count++;
			}
			$rs=Product::whereIn('sku',$data)->get();
			if(empty($rs[0]))
				return Redirect::back()->with('error',Lang::get('warehouse_empty'));
			$data_insert=array();
			$data_json=array();
			foreach($rs as $r){
				if(isset($r->id)) {
					$data_insert[] = array(
						'pid' => $r->id,
						'qty' => $qty[$r->sku],
						'sku' => $r->sku
					);
					$data_json[$r->id] = $r->sku;
				}
			}

			foreach($data_insert as $data){
				$sum_qty = OrderItem::where('product_id','=',$data['pid'])->where('qty_to_ship','=',0)->sum('qty_add');
				$avail_qty = $data['qty']-$sum_qty;

				$warehouse_product = new WarehouseProduct();
				$warehouse_product->client_id = Auth::user()->client_id;
				$warehouse_product->warehouse_id = $sendStock->destination_warehouse_id;
				$warehouse_product->product_id = $data['pid'];
				$warehouse_product->total_qty = $data['qty'];
				$warehouse_product->available_qty = $avail_qty;
				$warehouse_product->save();
			}

			$sendStock->reasons = $reasons;
			$sendStock->list_value = json_encode($data_json);
			$sendStock->status = 1;
			$sendStock->save();

			return Redirect::route('sendStock.index')->with('success', Lang::get('label.send_product_success'));
		}elseif(Input::has('product_arr')){
			$product_list = Input::get('product_arr');
			$product_qty = Input::get('qty_send');
			$data_insert=array();
			foreach($product_list as $k=>$v){
				if(!empty($product_qty[$k]))
					$data_insert[]=array(
						'pid'=>$k,
						'qty'=>$product_qty[$k],
						'sku'=>$v,
					);
			}

			foreach($data_insert as $data){
				$sum_qty = OrderItem::where('product_id','=',$data['pid'])->where('qty_to_ship','=',0)->sum('qty_add');
				$avail_qty = $data['qty']-$sum_qty;

				$warehouse_product = new WarehouseProduct();
				$warehouse_product->client_id = Auth::user()->client_id;
				$warehouse_product->warehouse_id = $sendStock->destination_warehouse_id;
				$warehouse_product->product_id = $data['pid'];
				$warehouse_product->total_qty = $data['qty'];
				$warehouse_product->available_qty = $avail_qty;
				$warehouse_product->save();
			}

			$sendStock->reasons = $reasons;
			$sendStock->list_value = json_encode($product_list);
			$sendStock->status = 1;
			$sendStock->save();

			return Redirect::route('sendStock.index')->with('success', Lang::get('label.send_product_success'));
		}

		$product_item=WarehouseProduct::where('warehouse_id','=',$sendStock->source_warehouse_id)->get();
		$this->layout->content=View::make('sendStock.add_detail')->with(array(
			'model'=>$sendStock,
			'products'=>$product_item
		));
	}
}