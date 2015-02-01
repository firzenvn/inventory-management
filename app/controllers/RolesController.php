<?php
/**
 * Created by PhpStorm.
 * User: DONY
 * Date: 10/2/2014
 * Time: 11:45 PM
 */

class RolesController extends BaseController {
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
		$rows=$client->roles();
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
		if (Input::has('role_name'))
			$rows = $rows->where('role_name', '=', Input::get("role_name"));
		if (Input::has('inherited_roleid')){
			$role_parent=Role::where('role_name' , '=', Input::get("inherited_roleid"))->where('client_id' , '=',Auth::user()->client_id)->first();
			$parent_id=0;
			if(!empty($role_parent))
				$parent_id=$role_parent->id;
			$rows = $rows->where('inherited_roleid', '=', $parent_id);
		}
		if (Input::has('created_at'))
		{
			$rows=$rows->where('created_at','>=',Input::get("created_at").' 00:00:00');
			$rows=$rows->where('created_at','<=',Input::get("created_at").' 23:59:59');

		}
		if (Input::has('updated_at'))
		{
			$rows=$rows->where('updated_at','>=',Input::get("updated_at").' 00:00:00');
			$rows=$rows->where('updated_at','<=',Input::get("updated_at").' 23:59:59');
		}
		$data=$rows->orderBy($sort,$order)->paginate(10);
		$this->layout->content=View::make('roles.index')->with(array('rows'=>$data));
	}

	public function getCreate(){
		$this->layout->content=View::make('roles.create');
	}

	public function postCreate(){
		$input=$this->InputFilter(Input::all());
		$input['client_id']=Auth::user()->client_id;
		$role=new Role($input);
		if($role->mysave())
			return Redirect::route('roles.list')->with('success',Lang::get('role.mes_add_success'));
		return Redirect::back()->withInput()->withErrors($role->errors);
	}

	public function getUpdate(){
		$id=Input::get('id');
		$model=Role::find($id);
		if($model->client_id!=Auth::user()->client_id)
			return Redirect::route('roles.list');
		$this->layout->content=View::make('roles.update')->with('model',$model);
	}

	public function postUpdate(){
		$id=Input::get('id');
		$model=Role::find($id);
		if($model->client_id!=Auth::user()->client_id)
			return Redirect::route('roles.list');
		$model->role_name=Input::get('role_name');
		if(Input::get('inherited_roleid') && Input::get('inherited_roleid')!='')
			$model->inherited_roleid=Input::get('inherited_roleid');
		if($model->myupdate())
			return Redirect::route('roles.list')->with('success',Lang::get('role.mes_update_success'));
		return Redirect::back()->withInput()->withErrors($model->errors);
	}

	public function getDelete()
	{
		$id = Input::get('id');
		$model = Role::find($id);
		if($model->client_id!=Auth::user()->client_id)
			return Redirect::route('roles.list');
		if($model->delete()){
			return Redirect::route('roles.list')->with('success', Lang::get('role.mes_delete_success'));
		}
	}
} 