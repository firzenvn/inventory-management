<?php
/**
 * Created by PhpStorm.
 * User: DONY
 * Date: 11/13/2014
 * Time: 3:36 PM
 */

class CategoriesController extends BaseController {
	protected $layout = "layouts.inventory";

	function __construct(){
		$this->beforeFilter('auth');
		$this->beforeFilter('acl');
	}

	public function getIndex()
	{
		$query=new Category();
		if (Input::has('seq_no'))
			$query = $query->where('seq_no', '=', Input::get("seq_no"));
		if (Input::has('status'))
			$query = $query->where('status', '=', Input::get("status"));
		if (Input::has('name'))
			$query = $query->where('name', 'like', '%'.Input::get("name").'%');
		if (Input::has('description'))
			$query = $query->where('description', 'like', '%'.Input::get("description").'%');

		$sort = Input::has('sort') ? Input::get('sort') : 'seq_no';
		$order = Input::get('order') === 'asc' ? 'asc' : 'desc';
		$query = $query->where('client_id','=',Auth::user()->client_id)->orderBy($sort, $order);
		$rows = $query->paginate(20);
		$this->layout->content = View::make('categories.index',array(
			'rows'=>$rows,
		));
	}

	public function getCreate()
	{
		$this->layout->content = View::make('categories.create');
	}

	public function postCreate()
	{
		$model = new Category();
		$model->client_id = Auth::user()->client_id;
		$model->name = Input::get('name');
		$model->description = Input::get('description');
		$model->status = Input::get('status');
		$model->created_at = time();
		if($model->save())
			return Redirect::route('categories.list')->with('success', Lang::get('label.create_category_success'));
		else
			return Redirect::route('categories.create')->withErrors($model->errors)->withInput();
	}

	public function getUpdate()
	{
		$id=Input::get('id');
		$model = Category::where('client_id','=',Auth::user()->client_id)->find($id);
		if(empty($model))
			return Redirect::route('categories.list');
		$this->layout->content = View::make('categories.update')->with(array(
			'model'=>$model,
		));
	}

	public function postUpdate(){
		$id=Input::get('id');
		$model = Category::where('client_id','=',Auth::user()->client_id)->find($id);
		$model->client_id = Auth::user()->client_id;
		$model->name = Input::get('name');
		$model->description = Input::get('description');
		$model->status = Input::get('status');
		if($model->save())
			return Redirect::route('categories.list')->with('success', Lang::get('label.update_category_success'));
		else
			return Redirect::route('categories.update',array('id'=>$id))->withErrors($model->errors)->withInput();
	}

	public function getDelete()
	{
		$id = Input::get('id');
		$row = Category::where('client_id','=',Auth::user()->client_id)->find($id);
		$sub_categories = SubCategory::where('client_id','=',Auth::user()->client_id)->where('category_id','=',$id)->delete();
		if($sub_categories && $row->delete()){
			return Redirect::route('categories.list')->with('success', Lang::get('label.delete_category_success'));
		}
	}
} 