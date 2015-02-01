<?php
/**
 * Created by PhpStorm.
 * User: Hoangtv
 * Date: 11/15/2014
 * Time: 1:44 AM
 */

class CustomerGroupController extends BaseController {
	protected $layout = "layouts.inventory";
	function __construct(){
		$this->beforeFilter('auth');
		$this->beforeFilter('acl');
	}
	/**
	 * List danh sach role cua 1 client
	 */
	public function getIndex(){
		$client=App::make('client');
		$sort='seq_no';
		$order='desc';

		if(Input::has('sort') && Input::has('order'))
		{
			$sort=Input::get('sort');
			$order=Input::get('order')==='asc'?'asc':'desc';
		}
		$rows=$client->customersGroups();
		if (Input::has('seq_no')){
			$arrr=explode('>',Input::get('seq_no'));
			if(count($arrr)<2)
				$rows = $rows->where('seq_no', '=', Input::get("seq_no"));
			else{
				$from=intval($arrr[0]);
				$to=intval($arrr[1]);
				if($to > $from)
					$rows = $rows->whereBetween('seq_no',array($from,$to));
			}
		}
		if (Input::has('name'))
			$rows = $rows->where('name', 'like', '%'.Input::get("name").'%');
		if (Input::has('status'))
			$rows = $rows->where('status', '=', Input::get("status"));
		$data=$rows->orderBy($sort,$order)->paginate(10);
		$this->layout->content=View::make('customerGroup.index')->with(array('rows'=>$data));
	}

	public function getCreate(){
		$this->layout->content=View::make('customerGroup.create');
	}

	public function postCreate(){
		$input=Input::all();
		$input['client_id']=Auth::user()->client_id;
		$cus=new CustomerGroup($input);
		if($cus->mysave())
			return Redirect::route('customer-groups.list')->with('success',Lang::get('customerGroup.mes_add_success'));
		return Redirect::back()->withInput()->withErrors(Lang::get('customerGroup.database_error'));
	}

	public function getUpdate(){
		$id=Input::get('id');
		$model=CustomerGroup::find($id);
		if($model->client_id!=Auth::user()->client_id)
			return Redirect::route('customer-groups.list');
		$this->layout->content=View::make('customerGroup.update')->with('model',$model);
	}

	public function postUpdate(){
		$id=Input::get('id');
		$model=CustomerGroup::find($id);
		if($model->client_id!=Auth::user()->client_id)
			return Redirect::route('customer-groups.list');
		$model->name=Input::get('name');
		if(Input::get('name') && Input::get('name')!='')
			$model->name=Input::get('name');
		if(Input::get('status') && Input::get('status')!='')
			$model->status=Input::get('status');
		if($model->update())
			return Redirect::route('customer-groups.list')->with('success',Lang::get('customerGroup.mes_update_success'));
		return Redirect::back()->withInput()->withErrors(Lang::get('customerGroup.database_error'));
	}

	public function getDelete()
	{
		$id = Input::get('id');
		$model = CustomerGroup::find($id);
		if($model->client_id!=Auth::user()->client_id)
			return Redirect::route('customer-groups.list');
		if($model->delete()){
			return Redirect::route('customer-groups.list')->with('success', Lang::get('customerGroup.mes_delete_success'));
		}
	}
}