<?php
/**
 * Created by PhpStorm.
 * User: DONY
 * Date: 12/5/2014
 * Time: 10:40 PM
 */

class CustomersAdminController extends BaseAdminController {
	protected $layout = "layouts.inventory";

	/**
	 * List danh sach role cua 1 client
	 */
	public function getIndex(){
		$sort='id';
		$order='desc';

		if(Input::has('sort') && Input::has('order'))
		{
			$sort=Input::get('sort');
			$order=Input::get('order')==='asc'?'asc':'desc';
		}
		$rows = new Customer();
		if (Input::has('id')){
			$arrr=explode('>',Input::get('id'));
			if(count($arrr)<2)
				$rows = $rows->where('id', '=', Input::get("id"));
			else{
				$from=intval($arrr[0]);
				$to=intval($arrr[1]);
				if($to > $from)
					$rows = $rows->whereBetween('id',array($from,$to));
			}
		}
		if (Input::has('client_id'))
			$rows = $rows->where('client_id', '=', Input::get("client_id"));
		if (Input::has('first_name'))
			$rows = $rows->where('first_name', 'like', '%'.Input::get("first_name").'%');
		if (Input::has('last_name'))
			$rows = $rows->where('last_name', 'like', '%'.Input::get("last_name").'%');
		if (Input::has('email'))
			$rows = $rows->where('email', 'like', '%'.Input::get("email").'%');
		if (Input::has('phone_no'))
			$rows = $rows->where('phone_no', 'like', '%'.Input::get("phone_no").'%');
		if (Input::has('customer_group_id')){
			$cgroup=CustomerGroup::where('client_id' , '=',Auth::user()->client_id)->where('name','=',Input::get("customer_group_id"))->first();
			$group_id=0;
			if(!empty($cgroup)){
				$group_id=$cgroup->id;
			}
			$rows = $rows->where('customer_group_id', '=',$group_id);
		}

		if (Input::has('zipcode'))
			$rows = $rows->where('zipcode', 'like', '%'.Input::get("zipcode").'%');
		if (Input::has('city'))
			$rows = $rows->where('city', 'like', '%'.Input::get("city").'%');
		if (Input::has('province_id'))
			$rows = $rows->where('province_id', 'like', '%'.Input::get("province_id").'%');
		if (Input::has('country_id')){
			$rows = $rows->where('country_id', '=',Input::get('country_id'));
		}
		$data=$rows->orderBy($sort,$order)->paginate(10);
		$this->layout->content=View::make('customers.admin.index')->with(array('rows'=>$data));
	}

	public function getCreate(){
		$this->layout->content=View::make('customers.admin.create');
	}

	public function postCreate(){
		$input=Input::all();
		$input['client_id']=Auth::user()->client_id;
		//kiem tra ngay thang nap sinh
		if(!AppHelper::checkLeapYear($input['date'],$input['month'],$input['year'])){
			return Redirect::back()->withInput()->withErrors(array(Lang::get('customer.date_invalid')));
		}
		$input['dob']=$input['year'].'-'.$input['month'].'-'.$input['date'];
		if(isset($input['autopassword']))
			$input['password']=AppHelper::generateRandomString();
		$temp_pass=$input['password'];
		$input['password']=md5($input['password']);
		$input['province_id']=$input['province'];
		$input['country_id']=$input['country'];
		$cus=new Customer($input);
		$validate=Validator::make($input,Customer::$rules);
		if(!$validate->passes())
			return Redirect::back()->withInput()->withErrors($validate->errors()->all());
		if($cus->mysave()){
			if(isset($input['autopassword']))
				Event::fire('customer.create',array($input['email'],$input['first_name'].' '.$input['last_name'],$temp_pass));
			return Redirect::route('admin.customers.list')->with('success',Lang::get('customer.mes_add_success'));
		}
		return Redirect::back()->withInput()->withErrors(Lang::get('customer.database_error'));
	}

	public function getUpdate(){
		$id=Input::get('id');
		$model=Customer::find($id);
		$this->layout->content=View::make('customers.admin.update')->with('model',$model);
	}

	public function postUpdate(){
		$id=Input::get('id');
		$model=Customer::find($id);
		$input=Input::all();
		if(!AppHelper::checkLeapYear($input['date'],$input['month'],$input['year'])){
			return Redirect::back()->withInput()->withErrors(array(Lang::get('customer.date_invalid')));
		}
		$input['province_id']=$input['province'];
		$input['country_id']=$input['country'];
		$input['dob']=$input['year'].'-'.$input['month'].'-'.$input['date'];
		$datachange=array();
		if(Input::has('email') && Input::get('email')!=$model->email)
			$datachange['email']=Input::get('email');
		if(Input::has('phone_no') && Input::get('phone_no')!=$model->phone_no)
			$datachange['phone_no']=Input::get('phone_no');
		if(Input::has('fax') && Input::get('fax')!=$model->fax)
			$datachange['fax']=Input::get('fax');
		if(Input::has('vat_number') && Input::get('vat_number')!=$model->vat_number)
			$datachange['vat_number']=Input::get('vat_number');
		$newrule=array();
		$old_rule=Customer::$rules;
		foreach($datachange as $k=>$v)
			if(isset($old_rule[$k]))
				$newrule[$k]=$old_rule[$k];
		$validate=Validator::make($datachange,$newrule);
		if(!$validate->passes())
			return Redirect::back()->withInput()->withErrors($validate->errors()->all());
		if($model->update($input))
			return Redirect::route('admin.customers.list')->with('success',Lang::get('customer.mes_update_success'));
		return Redirect::back()->withInput()->withErrors($model->errors);
	}

	public function getDelete()
	{
		$id = Input::get('id');
		$model = Customer::find($id)->delete();
		if($model){
			return Redirect::route('admin.customers.list')->with('success', Lang::get('customer.mes_delete_success'));
		}
	}
} 