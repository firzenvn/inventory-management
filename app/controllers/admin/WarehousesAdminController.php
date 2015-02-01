<?php
/**
 * Created by PhpStorm.
 * User: DONY
 * Date: 04/12/2014
 * Time: 3:19 PM
 */

class WarehousesAdminController extends BaseAdminController {
	protected $layout = "layouts.inventory";

	public function getIndex()
	{
		$query=new Warehouse();
		if (Input::has('id'))
			$query = $query->where('id', '=', Input::get("id"));
		if (Input::has('client_id'))
			$query = $query->where('client_id', '=', Input::get("client_id"));
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

		$sort = Input::has('sort') ? Input::get('sort') : 'id';
		$order = Input::get('order') === 'asc' ? 'asc' : 'desc';
		$query=$query->orderBy($sort, $order);

		$countries = Country::select(array('id','name'))->get();
		$list_country = array(''=>'= Select one =');
		foreach($countries as $country){
			$list_country[$country->id] = $country->name;
		}

		$rows = $query->paginate(20);
		$this->layout->content = View::make('warehouses.admin.index',array(
			'rows'=>$rows,
			'countries'=>$list_country,
		));
	}

	public function getCreate()
	{
		$countries = Country::select(array('id','name'))->get();
		$list_country = array(''=>'= Select one =');
		foreach($countries as $country){
			$list_country[$country->id] = $country->name;
		}
		$this->layout->content = View::make('warehouses.admin.create')->with(array(
			'countries'=>$list_country,
		));
	}

	public function postCreate()
	{
		$model = new Warehouse();
		$model->client_id = Input::get('client_id');
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
			return Redirect::route('admin.warehouse.list')->with('success', Lang::get('label.create_warehouse_success'));
		else
			return Redirect::route('admin.warehouse.create')->withErrors($model->errors)->withInput();
	}

	public function getUpdate()
	{
		$countries = Country::select(array('id','name'))->get();
		$list_country = array();
		foreach($countries as $country){
			$list_country[$country->id] = $country->name;
		}
		$id=Input::get('id');
		$model = Warehouse::find($id);
		$this->layout->content = View::make('warehouses.admin.update')->with(array(
			'countries'=>$list_country,
			'model'=>$model,
		));
	}

	public function postUpdate()
	{
		$id=Input::get('id');
		$model = Warehouse::find($id);
		$model->client_id = Input::get('client_id');
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
			return Redirect::route('admin.warehouse.list')->with('success', Lang::get('label.update_warehouse_success'));
		else
			return Redirect::route('admin.warehouse.update',array('id'=>$id))->withErrors($model->errors);
	}

	public function getDelete()
	{
		$id = Input::get('id');
		$row = Warehouse::find($id)->delete();
		if($row){
			return Redirect::route('admin.warehouse.list')->with('success', Lang::get('label.delete_warehouse_success'));
		}
	}
} 