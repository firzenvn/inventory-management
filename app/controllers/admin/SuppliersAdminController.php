<?php
/**
 * Created by PhpStorm.
 * User: DONY
 * Date: 12/5/2014
 * Time: 9:37 AM
 */

class SuppliersAdminController extends BaseAdminController {
	protected $layout = "layouts.inventory";

	public function getIndex()
	{
		$query=new Supplier();
		if (Input::has('id'))
			$query = $query->where('id', '=', Input::get("id"));
		if (Input::has('client_id'))
			$query = $query->where('client_id', '=', Input::get("client_id"));
		if (Input::has('email'))
			$query = $query->where('email', '=', Input::get("email"));
		if (Input::has('phone_no'))
			$query = $query->where('phone_no', '=', Input::get("phone_no"));
		if (Input::has('fax'))
			$query = $query->where('fax', '=', Input::get("fax"));
		if (Input::has('street'))
			$query = $query->where('street', '=', Input::get("street"));
		if (Input::has('city'))
			$query = $query->where('city', '=', Input::get("city"));
		if (Input::has('status'))
			$query = $query->where('status', '=', Input::get("status"));
		if (Input::has('name'))
			$query = $query->where('name', 'like', '%'.Input::get("name").'%');
		if (Input::has('person'))
			$query = $query->where('person', 'like', '%'.Input::get("person").'%');

		$sort = Input::has('sort') ? Input::get('sort') : 'id';
		$order = Input::get('order') === 'asc' ? 'asc' : 'desc';
		$query = $query->orderBy($sort, $order);
		$rows = $query->paginate(20);
		$this->layout->content = View::make('suppliers.admin.index',array(
			'rows'=>$rows,
		));
	}

	public function getCreate()
	{
		$countries = Country::select(array('id','name'))->get();
		$list_country = array();
		foreach($countries as $country){
			$list_country[$country->id] = $country->name;
		}
		$this->layout->content = View::make('suppliers.admin.create')->with(array(
			'countries'=>$list_country,
		));
	}

	public function postCreate()
	{
		$model = new Supplier();
		$model->client_id = Input::get('client_id');
		$model->name = Input::get('supplier_name');
		$model->person = Input::get('supplier_person');
		$model->email = Input::get('supplier_email');
		$model->phone_no = Input::get('phone_no');
		$model->fax = Input::get('fax');
		$model->street = Input::get('street');
		$model->city = Input::get('city');
		$model->country_id = Input::get('country_id');
		$model->province = Input::get('province');
		$model->zipcode = Input::get('zipcode');
		$model->website = Input::get('website');
		$model->description = Input::get('description');
		$model->status = Input::get('status');
		$model->created_at = time();
		if($model->save())
			return Redirect::route('admin.suppliers.list')->with('success', Lang::get('label.create_supplier_success'));
		else
			return Redirect::route('admin.suppliers.create')->withErrors($model->errors)->withInput();
	}

	public function getUpdate()
	{
		$countries = Country::select(array('id','name'))->get();
		$list_country = array();
		foreach($countries as $country){
			$list_country[$country->id] = $country->name;
		}
		$id=Input::get('id');
		$model = Supplier::find($id);
		$this->layout->content = View::make('suppliers.admin.update')->with(array(
			'countries'=>$list_country,
			'model'=>$model,
		));
	}

	public function postUpdate()
	{
		$id=Input::get('id');
		$model = Supplier::find($id);
		$model->client_id = Input::get('client_id');
		$model->name = Input::get('supplier_name');
		$model->person = Input::get('supplier_person');
		$model->email = Input::get('supplier_email');
		$model->phone_no = Input::get('phone_no');
		$model->fax = Input::get('fax');
		$model->street = Input::get('street');
		$model->city = Input::get('city');
		$model->country_id = Input::get('country_id');
		$model->province = Input::get('province');
		$model->zipcode = Input::get('zipcode');
		$model->website = Input::get('website');
		$model->description = Input::get('description');
		$model->status = Input::get('status');
		if($model->save())
			return Redirect::route('admin.suppliers.list')->with('success', Lang::get('label.update_supplier_success'));
		else
			return Redirect::route('admin.suppliers.update',array('id'=>$id))->withErrors($model->errors);
	}

	public function getDelete()
	{
		$id = Input::get('id');
		$row = Supplier::find($id)->delete();
		if($row){
			return Redirect::route('admin.suppliers.list')->with('success', Lang::get('label.delete_supplier_success'));
		}
	}
} 