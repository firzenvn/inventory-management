<?php
/**
 * Created by PhpStorm.
 * User: DONY
 * Date: 10/9/2014
 * Time: 3:19 PM
 */

class WarehousesController extends BaseController {
	protected $layout = "layouts.inventory";

	function __construct(){
		$this->beforeFilter('auth');
		$this->beforeFilter('acl');
	}

	public function getIndex()
	{
		$query=new Warehouse();
		if (Input::has('seq_no'))
			$query = $query->where('seq_no', '=', Input::get("seq_no"));
		if (Input::has('country_id'))
			$query = $query->where('country_id', '=', Input::get("country_id"));
		if (Input::has('email'))
			$query = $query->where('email', '=', Input::get("email"));
		if (Input::has('phone_no'))
			$query = $query->where('phone_no', '=', Input::get("phone_no"));
		if (Input::has('manager_email'))
			$query = $query->where('manager_email', '=', Input::get("manager_email"));
		if (Input::has('street'))
			$query = $query->where('street', "=", Input::get("street"));
		if (Input::has('city'))
			$query = $query->where('city', "=", Input::get("city"));
		if (Input::has('status'))
			$query = $query->where('status', "=", Input::get("status"));
		if (Input::has('name'))
			$query = $query->where('name', 'like', '%'.Input::get("name").'%');
		if (Input::has('manager_name'))
			$query = $query->where('manager_name', 'like', '%'.Input::get("manager_name").'%');
		/*if (Input::has('country_id'))
			$query = $query->where('country_id', function($q){
				$q->where('name','=',Input::get('country'));
			});*/

		$sort = Input::has('sort') ? Input::get('sort') : 'seq_no';
		$order = Input::get('order') === 'asc' ? 'asc' : 'desc';
		$query=$query->where('client_id','=',Auth::user()->client_id)->orderBy($sort, $order);

		$countries = Country::select(array('id','name'))->get();
		$list_country = array(''=>'= Select one =');
		foreach($countries as $country){
			$list_country[$country->id] = $country->name;
		}

		$rows = $query->paginate(20);
		$this->layout->content = View::make('warehouses.index',array(
			'rows'=>$rows,
			'countries'=>$list_country,
		));
	}

	public function getCreate()
	{
		$client = App::make('client');
		if($client->warehouse_count >= $client->package->limit_warehouses)
			return Redirect::route('warehouse.list')->with('error',Lang::get('label.limited_warehouse'));

		$countries = Country::select(array('id','name'))->get();
		$list_country = array(''=>'= Select one =');
		foreach($countries as $country){
			$list_country[$country->id] = $country->name;
		}
		$this->layout->content = View::make('warehouses.create')->with(array(
			'countries'=>$list_country,
		));
	}

	public function postCreate()
	{
		$client = App::make('client');
		if($client->warehouse_count >= $client->package->limit_warehouses)
			return Redirect::route('warehouse.list')->with('error',Lang::get('label.limited_warehouse'));

		$model = new Warehouse();
		$model->client_id = Auth::user()->client_id;
		$model->name = Input::get('name');
		$model->manager_name = Input::get('manager_name');
		$model->manager_email = Input::get('manager_email');
		$model->phone_no = Input::get('phone_no');
		$model->street = Input::get('street');
		$model->city = Input::get('city');
		$model->country_id = Input::get('country_id');
		$model->province = Input::get('province');
		$model->zipcode = Input::get('zipcode');
		$model->status = Input::get('status');
		$model->created_at = time();
		if($model->save())
			return Redirect::route('warehouse.list')->with('success', Lang::get('label.create_warehouse_success'));
		else
			return Redirect::route('warehouse.create')->withErrors($model->errors)->withInput();
	}

	public function getUpdate()
	{
		$countries = Country::select(array('id','name'))->get();
		$list_country = array();
		foreach($countries as $country){
			$list_country[$country->id] = $country->name;
		}
		$id=Input::get('id');
		$model = Warehouse::where('client_id','=',Auth::user()->client_id)->find($id);
		if(empty($model))
			return Redirect::route('warehouse.list');


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
		if (Input::has('id'))
			$query = $query->where('warehouse_id', '=', Input::get("id"));
		if (Input::has('total_qty'))
			$query = $query->where('total_qty', '=', Input::get("total_qty"));
		if (Input::has('available_qty'))
			$query = $query->where('available_qty', '=', Input::get("available_qty"));

		$query = $query->where('client_id', '=', Auth::user()->client_id);
		$rows = $query->paginate(10);

		$this->layout->content = View::make('warehouses.update')->with(array(
			'countries'=>$list_country,
			'model'=>$model,
			'rows'=>$rows,
		));
	}

	public function postUpdate()
	{
		$id=Input::get('id');
		$model = Warehouse::find($id);
		$model->client_id = Auth::user()->client_id;
		$model->name = Input::get('name');
		$model->manager_name = Input::get('manager_name');
		$model->manager_email = Input::get('manager_email');
		$model->phone_no = Input::get('phone_no');
		$model->street = Input::get('street');
		$model->city = Input::get('city');
		$model->country_id = Input::get('country_id');
		$model->province = Input::get('province');
		$model->zipcode = Input::get('zipcode');
		$model->status = Input::get('status');
		if($model->save())
			return Redirect::route('warehouse.list')->with('success', Lang::get('label.update_warehouse_success'));
		else
			return Redirect::route('warehouse.update',array('id'=>$id))->withErrors($model->errors);
	}

	public function getDelete()
	{
		$id = Input::get('id');
		$row = Warehouse::where('client_id','=',Auth::user()->client_id)->find($id);
		if($row->delete()){
			return Redirect::route('warehouse.list')->with('success', Lang::get('label.delete_warehouse_success'));
		}
	}
} 