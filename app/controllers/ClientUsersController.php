<?php
/**
 * Created by PhpStorm.
 * User: BachViet
 * Date: 10/2/2014
 * Time: 11:45 PM
 */

class ClientUsersController extends BaseController {
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
		$rows=$client->users();
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

		if (Input::has('username'))
			$rows = $rows->where('username', 'like', '%'.Input::get("username").'%');
		if (Input::has('email')){
			$rows = $rows->where('email','like', '%'.Input::get("email").'%');
		}
		if (Input::has('first_name')){
			$rows = $rows->where('first_name','like', '%'.Input::get("first_name").'%');
		}
		if (Input::has('last_name')){
			$rows = $rows->where('last_name','like', '%'.Input::get("last_name").'%');
		}
		if (Input::has('phone')){
			$rows = $rows->where('phone','like', '%'.Input::get("phone").'%');
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
		$rows=$rows->where('id','<>',$client->owner_user_id);
		$rows=$rows->orderBy($sort,$order)->paginate(10);

		$this->layout->content=View::make('client_users.index')->with(array('rows'=>$rows));
	}

	public function getCreate(){
		$client = App::make('client');
		if($client->user_count >= $client->package->limit_users)
			return Redirect::route('client-users.list')->with('error',Lang::get('label.limited_user'));

		$this->layout->content=View::make('client_users.create');
	}

	public function postCreate(){
		$client = App::make('client');
		if($client->user_count >= $client->package->limit_users)
			return Redirect::route('client-users.list')->with('error',Lang::get('label.limited_users'));

		$input=Input::all();
		$input['client_id']=Auth::user()->client_id;
		$input['password']=Input::get('password');
		$validator=Validator::make($input,User::$rules_client_user);
		if(!$validator->passes())
		{
			return Redirect::back()->withInput()->withErrors($validator->messages());
		}
		$input['password']=Hash::make(Input::get('password'));
		$user=new User($input);
		if(!$user->mysave()){
			return Redirect::back()->withInput()->with('error',$user->errors);
		}
		return Redirect::route('client-users.list')->with('success',Lang::get('client-user.mes_add_success'));
		//return Redirect::back()->withInput()->with('error','error occured while creating user');
	}

	public function getUpdate(){
		$id=Input::get('id');
		if(!$this->checkOwner($id))
			return Redirect::route('client-users.list');
		$model=User::find($id);
		if($model->client_id!=Auth::user()->client_id)
			return Redirect::route('client-users.list');
		$this->layout->content=View::make('client_users.update')->with('model',$model);
	}

	public function postUpdate(){
		$id=Input::get('id');
		if(!$this->checkOwner($id))
			return Redirect::route('client-users.list');
		$model=User::find($id);
		$data=array();
		if($model->client_id!=Auth::user()->client_id)
			return Redirect::route('client-users.list');
		if(Input::has('username') && $model->username!=Input::get('username'))
		{
			$data['username']=Input::get('username');
			$model->username=Input::get('username');
		}
		if(Input::has('last_name') && $model->last_name!=Input::get('last_name'))
		{
			$data['last_name']=Input::get('last_name');
			$model->last_name=Input::get('last_name');
		}
		if(Input::has('first_name') && $model->first_name!=Input::get('first_name'))
		{
			$data['first_name']=Input::get('first_name');
			$model->first_name=Input::get('first_name');
		}
		if(Input::has('phone') && $model->phone!=Input::get('phone'))
		{
			$data['phone']=Input::get('phone');
			$model->phone=Input::get('phone');
		}
		if(Input::has('email') && $model->email!=Input::get('email'))
		{
			$data['email']=Input::get('email');
			$model->email=Input::get('email');
		}
		if(Input::has('role_id'))
			if(!isset($model->roleUser->role_id))
			{
				$role=new RoleUser();
				$role->role_id=Input::get('role_id');
				$role->user_id=$model->id;
				$role->save();
			}else{
				$model->roleUser->role_id=Input::get('role_id');
				$model->roleUser->save();
			}
		if(Input::has('password'))
			$model->password=Hash::make(Input::get('password'));
		$validate=Validator::make($data,User::$rules_update_user);
		if(!$validate->passes())
			return Redirect::back()->withInput()->withErrors($validate->messages()->all());
		if(!$model->myupdate($data))
			return Redirect::back()->withInput()->withErrors($model->errors);
		return Redirect::route('client-users.list')->with('success',Lang::get('client-user.mes_update_success'));
	}

	public function getDelete()
	{
		$id = Input::get('id');
		if(!$this->checkOwner($id))
			return Redirect::route('client-users.list');
		$model = User::find($id);
		if ($model->client_id != Auth::user()->client_id)
			return Redirect::route('client-users.list');
		if ($model->delete()) {
			return Redirect::route('client-users.list')->with('success', Lang::get('client-user.mes_delete_success'));;
		}
	}

	public function checkOwner($id){
		$client = App::make('client');
		if($id==$client->owner_user_id)
			return false;
		return true;
	}
}