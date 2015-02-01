<?php
/**
 * Created by PhpStorm.
 * User: DONY
 * Date: 12/22/2014
 * Time: 10:35 PM
 */

class WarehouseProductController extends BaseController {

	protected $layout = "layouts.inventory";

	function __construct(){
		$this->beforeFilter('auth');
		$this->beforeFilter('acl');
	}

	public function getIndex()
	{
		$query=new WarehouseProduct();
		if (Input::has('seq_no'))
			$query = $query->whereHas('product', function($q){
				$q->where('seq_no', '=', Input::get("seq_no"));
			});
		if (Input::has('name'))
			$query = $query->whereHas('product', function($q){
				$q->where('name', '=', Input::get("name"));
			});
		if (Input::has('sku'))
			$query = $query->whereHas('product', function($q){
				$q->where('sku', '=', Input::get("sku"));
			});
		if (Input::has('sku'))
			$query = $query->whereHas('product', function($q){
				$q->where('sku', '=', Input::get("sku"));
			});
		if (Input::has('price'))
			$query = $query->whereHas('price', function($q){
				$q->where('price', '=', Input::get("price"));
			});
		if (Input::has('status'))
			$query = $query->whereHas('status', function($q){
				$q->where('status', '=', Input::get("status"));
			});
		if (Input::has('warehouse_id'))
			$query = $query->where('warehouse_id', '=', Input::get("warehouse_id"));
		if (Input::has('total_qty'))
			$query = $query->where('total_qty', '=', Input::get("total_qty"));
		if (Input::has('available_qty'))
			$query = $query->where('available_qty', '=', Input::get("available_qty"));

		$query = $query->where('client_id', '=', Auth::user()->client_id);
		$rows = $query->paginate(10);
		$this->layout->content = View::make('warehouse_product.index',array(
			'rows'=>$rows,
		));
	}

	public function postUpdateQtyProduct()
	{
		$id=Input::get('id');
		$total_qty=Input::get('total_qty');
		$model = WarehouseProduct::find($id);
		$avail_qty = 0;
		if(!empty($model))
		{
			$sum_qty = OrderItem::where('product_id','=',$model->product_id)->where('qty_to_ship','=',0)->sum('qty_add');
			$avail_qty = $total_qty-$sum_qty;
		}
		$model->total_qty = $total_qty;
		$model->available_qty = $avail_qty;
		if($model->save())
			return Redirect::route('warehouse.update.get',array('id'=>$model->warehouse_id))->with('success', Lang::get('label.update_quantity_success'));
		else
			return Redirect::route('warehouseProduct.list')->withErrors($model->errors);
	}

	public function getAddProduct()
	{
		// TO DO something:
	}

	public function postAjaxSearchProduct()
	{
		if(Request::ajax()){
			$query=new WarehouseProduct();

			if (Input::has('seq_no_from') && Input::has('seq_no_to'))
				$query = $query->whereHas('product', function($q){
					$q->where('seq_no', '>=', Input::get("seq_no_from"));
					$q->where('seq_no', '<=', Input::get("seq_no_to"));
				});
			if (Input::has('p_name'))
				$query = $query->whereHas('product', function($q){
					$q->where('name', '=', Input::get("p_name"));
				});
			if (Input::has('p_sku'))
				$query = $query->whereHas('product', function($q){
					$q->where('sku', '=', Input::get("p_sku"));
				});
			if (Input::has('p_status'))
				$query = $query->whereHas('status', function($q){
					$q->where('status', '=', Input::get("p_status"));
				});
			if (Input::has('total_qty_from') && Input::has('total_qty_to')){
				$query = $query->where('total_qty', '>=', Input::get("total_qty_from"));
				$query = $query->where('total_qty', '<=', Input::get("total_qty_to"));
			}

			$query = $query->where('warehouse_id', '=', Input::get('warehouse_id'));
			$query = $query->where('client_id', '=', Auth::user()->client_id);
			$rows = $query->get();

			$data = '';
			foreach($rows as $row){
				$status = ($row->product->status==1)? 'Enable' : 'Disable';
				$data .= '<tr id="tr_c_'.$row->product->seq_no.'">
					<td><input name="product_arr['.$row->product_id.']" type="checkbox" value="'.$row->product->sku.'"></td>
					<td>'.$row->product->seq_no.'</td>
					<td>'.$row->product->name.'</td>
					<td>'.$status.'</td>
					<td>'.$row->product->sku.'</td>
					<td>'.$row->total_qty.'</td>
					<td><input name="qty_send['.$row->product_id.']" type="text" value=""/></td>
					</tr>';
			}
			return Response::make($data);
		}
	}

	public function postAjaxSearchWareHouseProduct()
	{
		if(Request::ajax()){
			$query=new WarehouseProduct();

			if (Input::has('seq_no_from') && Input::has('seq_no_to'))
				$query = $query->whereHas('product', function($q){
					$q->where('seq_no', '>=', Input::get("seq_no_from"));
					$q->where('seq_no', '<=', Input::get("seq_no_to"));
				});
			if (Input::has('p_name'))
				$query = $query->whereHas('product', function($q){
					$q->where('name', '=', Input::get("p_name"));
				});
			if (Input::has('p_sku'))
				$query = $query->whereHas('product', function($q){
					$q->where('sku', '=', Input::get("p_sku"));
				});
			if (Input::has('p_status'))
				$query = $query->whereHas('status', function($q){
					$q->where('status', '=', Input::get("p_status"));
				});
			if (Input::has('price_from') && Input::has('price_to'))
				$query = $query->whereHas('product', function($q){
					$q->where('price', '>=', Input::get("price_from"));
					$q->where('price', '<=', Input::get("price_to"));
				});
			if (Input::has('total_qty_from') && Input::has('total_qty_to')){
				$query = $query->where('total_qty', '>=', Input::get("total_qty_from"));
				$query = $query->where('total_qty', '<=', Input::get("total_qty_to"));
			}
			if (Input::has('available_qty_from') && Input::has('available_qty_to')){
				$query = $query->where('available_qty', '>=', Input::get("available_qty_from"));
				$query = $query->where('available_qty', '<=', Input::get("available_qty_to"));
			}
			if(Input::has('warehouse_id'))
				$query = $query->where('warehouse_id', '=', Input::get('warehouse_id'));

			$query = $query->where('client_id', '=', Auth::user()->client_id);
			$rows = $query->get();

			$data = '';
			foreach($rows as $row){
				$status = ($row->product->status==1)? 'Enable' : 'Disable';
				$data .= '<form method="POST" action="/warehouse-product/update-qty">
				<input name="id" type="hidden" value="'.$row->id.'">
				<tr id="tr_c_'.$row->product->seq_no.'">
					<td>'.$row->product->seq_no.'</td>
					<td>'.$row->product->name.'</td>
					<td>'.$row->product->sku.'</td>
					<td>'.$row->product->price.'</td>
					<td>'.$status.'</td>
					<td><input name="total_qty" type="text" value="'.$row->total_qty.'"></td>
					<td>'.$row->available_qty.'</td>
					<td><button class="btn btn-primary" type="submit"><i class="fa fa-check"></i></button></td>
				</tr>
				</form>';
			}
			return Response::make($data);
		}
	}
}