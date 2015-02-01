<?php

/**
 * Created by PhpStorm.
 * User: BachViet
 * Date: 10/2/2014
 * Time: 11:45 PM
 */
class PermissionsController extends BaseController
{
	protected $layout = "layouts.inventory";
	function __construct(){
		$this->beforeFilter('auth');
		$this->beforeFilter('acl');
	}
	/**
	 * List danh sach role cua 1 client
	 */
	public function getIndex()
	{
		$client = App::make('client');
		$sort = 'id';
		$order = 'desc';
		if (Input::has('sort') && Input::has('order')) {
			$sort = Input::get('sort');
			$order = Input::get('order') === 'asc' ? 'asc' : 'desc';
		}
		$rows=$client->permissions();
		//if (Input::has('id'))
			//$rows = $rows->where('id', '=', Input::get("id"));
		if (Input::has('role_id')){
			$role=Role::where('role_name','=',Input::get('role_id'))->first();
			if(!empty($role))
				$rows = $rows->where('role_id', '=', $role->id);
		}
		if (Input::has('type')){
			$rows = $rows->where('type', '=', Input::get('type'));
		}
		if (Input::has('action')){
			$rows = $rows->where('action', '=', Input::get('action'));
		}
		if (Input::has('resource')){
			$rows = $rows->where('resource', 'like', '%'.Input::get('resource').'%');
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
		$rows = $rows->orderBy($sort, $order)->paginate(10);

		$this->layout->content = View::make('permissions.index')->with(array('rows' => $rows));
	}

	public function getCreate()
	{
		$role_id = Input::get('role_id');
		$this->layout->content = View::make('permissions.create',compact('role_id'));
	}

	public function postCreate()
	{
		$input=Input::all();
		$validator = Validator::make($input, array(
			'role_id' => 'required',
		));

		if (!$validator->passes()) {
			return Redirect::route('permissions.create')->with('error', 'Please complete the following errors')->withErrors($validator)->withInput();
		}

		$role_id = Input::get('role_id');
		$resources = Resource::getResource();
		$permissions = array();
		foreach ($resources as $rs) {
			foreach (Config::get('constant.permission_actions') as $key => $val) {
				$permission = Permission::firstOrNew(array(
					'role_id' => $role_id,
					'action' => $key,
					'resource' => $rs->id
				));
				$permission->resource = $rs->id;
				$permission->client_id = Auth::user()->client_id;
				if (isset($input[$rs->id . '_' . $key]) && $input[$rs->id . '_' . $key] == 'on') {
					$permission->type = Permission::ALLOW;
				} else {
					$permission->type = Permission::DENY;
				}
//				$permission->save();
				$permissions[] = $permission->attributesToArray();
			}
		}
		//delete old permissions
		DB::beginTransaction();
		try{
			Permission::where('role_id','=',$role_id)->delete();
			DB::table('permissions')->insert($permissions);
			DB::commit();
		}catch (Exception $e){
			DB::rollBack();
		}
		return Redirect::route('permissions.list')->with('success', Lang::get('messages.add_permission_success'));
	}

	public function getUpdate()
	{
		$role_id = Input::get('role_id');
		$model = Permission::where('role_id',$role_id)->where('client_id','=',Auth::user()->client_id)->get();

		if (is_null($model->first()))
			return Redirect::route('permissions.create')->with('role_id',$role_id);
		$this->layout->content = View::make('permissions.update', compact('model', 'role_id'));
	}

	public function postUpdate()
	{
		$id = Input::get('id');
		$model = Permission::find($id);
		if ($model->client_id != Auth::user()->client_id)
			return Redirect::route('permissions.list');
		$model->role_id = Input::get('role_id');
		$model->type = Input::get('type');
		$model->action = Input::get('action');
		if ($model->save())
			return Redirect::route('permissions.list')->with('success', Lang::get('permission.mes_update_success'));
		return Redirect::back()->withInput()->withErrors($model->errors);
	}
	public function getDelete()
	{
		$id = Input::get('id');
		$model = Permission::find($id);
		if($model->client_id!=Auth::user()->client_id)
			return Redirect::route('permissions.list');
		if($model->delete()){
			return Redirect::route('permissions.list')->with('success',Lang::get('permission.mes_delete_success'));;
		}
	}
	/*
	public function postChangeStatus(){
		$id_permission=Input::has('permission_id')?Input::get('permission_id'):'';
		$permission=Permission::find($id_permission);
		if(empty($permission))
		{
			echo json_encode(array('status'=>0,'data'=>'Not found'));
			die;
		}
		if($permission->client_id!=Auth::user()->client_id)
		{
			echo json_encode(array('status'=>0,'data'=>'Forbidden'));
			die;
		}
		$permission->type=$permission->type==Permission::ALLOW?Permission::DENY:Permission::ALLOW;
		if(!$permission->save()){
			echo json_encode(array('status'=>0,'data'=>'Database error'));
			die;
		}
		echo json_encode(array('status'=>1,'data'=>$permission->type));
		die;
	}
	*/
} 