<?php
/**
 * Created by PhpStorm.
 * User: DONY
 * Date: 12/5/2014
 * Time: 10:18 PM
 */

class CustomerGroupAdminController extends BaseAdminController {
	protected $layout = "layouts.inventory";

	/**
	 * List danh sach role cua 1 client
	 */
	public function getIndex(){
		$client=App::make('client');
		$sort='id';
		$order='desc';

		if(Input::has('sort') && Input::has('order'))
		{
			$sort=Input::get('sort');
			$order=Input::get('order')==='asc'?'asc':'desc';
		}
		$rows=new CustomerGroup();
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
		if (Input::has('name'))
			$rows = $rows->where('name', 'like', '%'.Input::get("name").'%');
		if (Input::has('status'))
			$rows = $rows->where('status', '=', Input::get("status"));
		$data=$rows->orderBy($sort,$order)->paginate(10);
		$this->layout->content=View::make('customerGroup.admin.index')->with(array('rows'=>$data));
	}

	public function getCreate(){
		$this->layout->content=View::make('customerGroup.admin.create');
	}

	public function postCreate(){
		$input=Input::all();
		$input['client_id']=Auth::user()->client_id;
		$cus=new CustomerGroup($input);
		if($cus->mysave())
			return Redirect::route('admin.customer-groups.list')->with('success',Lang::get('customerGroup.mes_add_success'));
		return Redirect::back()->withInput()->withErrors(Lang::get('customerGroup.database_error'));
	}

	public function getUpdate(){
		$id=Input::get('id');
		$model=CustomerGroup::find($id);
		$this->layout->content=View::make('customerGroup.admin.update')->with('model',$model);
	}

	public function postUpdate(){
		$id=Input::get('id');
		$model=CustomerGroup::find($id);
		$model->client_id=Input::get('client_id');
		$model->name=Input::get('name');
		if(Input::get('name') && Input::get('name')!='')
			$model->name=Input::get('name');
		if(Input::get('status') && Input::get('status')!='')
			$model->status=Input::get('status');
		if($model->update())
			return Redirect::route('admin.customer-groups.list')->with('success',Lang::get('customerGroup.mes_update_success'));
		return Redirect::back()->withInput()->withErrors(Lang::get('customerGroup.database_error'));
	}

	public function getDelete()
	{
		$id = Input::get('id');
		$model = CustomerGroup::find($id)->delete();
		if($model){
			return Redirect::route('admin.customer-groups.list')->with('success', Lang::get('customerGroup.mes_delete_success'));
		}
	}
} 