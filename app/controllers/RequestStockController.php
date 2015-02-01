<?php
/**
 * Created by PhpStorm.
 * User: DONY
 * Date: 12/26/2014
 * Time: 5:11 PM
 */

class RequestStockController extends BaseController {
	protected $layout = "layouts.inventory";
	function __construct(){
		$this->beforeFilter('auth');
		$this->beforeFilter('acl');
	}

	public function getIndex(){
		$query = new RequestStock();
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

		$this->layout->content=View::make('requestStock.index',array(
			'rows'=>$rows,
		));
	}

	public function getCreate()
	{
		$this->layout->content=View::make('requestStock.create');
	}

	public function postCreateRequest()
	{
		$source_id = Input::get('source_id');
		$destination_id = Input::get('destination_id');
		$requestStock = new RequestStock();
		$requestStock->client_id = Auth::user()->client_id;
		$requestStock->source_warehouse_id = $source_id;
		$requestStock->destination_warehouse_id = $destination_id;
		if($requestStock->save())
			return Redirect::route('requestStock.add_detail.get',array('request_id'=>$requestStock->id))->with('success',Lang::get('label.request_new_stock_success'));
		else
			return Redirect::back()->withInput()->with('error',$requestStock->error);
	}

	public function getAddDetailRequest()
	{
		$id=Input::get('request_id');
		$requestStock=RequestStock::where('client_id','=',Auth::user()->client_id)->find($id);
		if(empty($requestStock))
			return $this->layout->content=View::make('requestStock.index')->with('error',Lang::get('request_stock_not_exist'));

		$product_item=WarehouseProduct::where('warehouse_id','=',$requestStock->source_warehouse_id)->get();
		$this->layout->content=View::make('requestStock.add_detail')->with(array(
			'model'=>$requestStock,
			'products'=>$product_item
		));
	}

	public function postAddDetailRequest()
	{
		$id=Input::get('request_id');
		$requestStock=RequestStock::where('client_id','=',Auth::user()->client_id)->find($id);
		if(empty($requestStock))
			return $this->layout->content=View::make('requestStock.index')->with('error',Lang::get('request_stock_not_exist'));

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

			/*foreach($data_insert as $data){
				$sum_qty = OrderItem::where('product_id','=',$data['pid'])->where('qty_to_ship','=',0)->sum('qty_add');
				$avail_qty = $data['qty']-$sum_qty;

				$warehouse_product = new WarehouseProduct();
				$warehouse_product->client_id = Auth::user()->client_id;
				$warehouse_product->warehouse_id = $sendStock->destination_warehouse_id;
				$warehouse_product->product_id = $data['pid'];
				$warehouse_product->total_qty = $data['qty'];
				$warehouse_product->available_qty = $avail_qty;
				$warehouse_product->save();
			}*/

			$requestStock->reasons = $reasons;
			$requestStock->list_value = json_encode($data_json);
			$requestStock->data_insert = json_encode($data_insert);
			$requestStock->status = 1;
			$requestStock->save();

			return Redirect::route('requestStock.index')->with('success', Lang::get('label.request_product_success'));
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

			/*foreach($data_insert as $data){
				$sum_qty = OrderItem::where('product_id','=',$data['pid'])->where('qty_to_ship','=',0)->sum('qty_add');
				$avail_qty = $data['qty']-$sum_qty;

				$warehouse_product = new WarehouseProduct();
				$warehouse_product->client_id = Auth::user()->client_id;
				$warehouse_product->warehouse_id = $sendStock->destination_warehouse_id;
				$warehouse_product->product_id = $data['pid'];
				$warehouse_product->total_qty = $data['qty'];
				$warehouse_product->available_qty = $avail_qty;
				$warehouse_product->save();
			}*/
			$requestStock->reasons = $reasons;
			$requestStock->list_value = json_encode($product_list);
			$requestStock->data_insert = json_encode($data_insert);
			$requestStock->status = 1;
			$requestStock->save();

			return Redirect::route('requestStock.index')->with('success', Lang::get('label.request_product_success'));
		}

		$product_item=WarehouseProduct::where('warehouse_id','=',$requestStock->source_warehouse_id)->get();
		$this->layout->content=View::make('requestStock.add_detail')->with(array(
			'model'=>$requestStock,
			'products'=>$product_item
		));
	}
}