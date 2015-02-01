<?php
/**
 * Created by PhpStorm.
 * User: DONY
 * Date: 11/14/2014
 * Time: 4:16 PM
 */

class SubCategoriesController extends BaseController {
	protected $layout = "layouts.inventory";

	function __construct(){
		$this->beforeFilter('auth');
		//$this->beforeFilter('acl');
	}

	public function getIndex()
	{
		$query=new SubCategory();
		if (Input::has('seq_no'))
			$query = $query->where('seq_no', '=', Input::get("seq_no"));
		if (Input::has('category_id'))
			$query = $query->where('category_id', '=', Input::get("category_id"));
		if (Input::has('status'))
			$query = $query->where('status', '=', Input::get("status"));
		if (Input::has('name'))
			$query = $query->where('name', 'like', '%'.Input::get("name").'%');
		if (Input::has('description'))
			$query = $query->where('description', 'like', '%'.Input::get("description").'%');

		$category = Category::where('client_id','=',Auth::user()->client_id)->get();
		$categories = array(''=>'== Select once ==');
		foreach($category as $cate){
			$categories[$cate->id] = $cate->name;
		}

		$sort = Input::has('sort') ? Input::get('sort') : 'seq_no';
		$order = Input::get('order') === 'asc' ? 'asc' : 'desc';
		$query = $query->where('client_id','=',Auth::user()->client_id)->orderBy($sort, $order);
		$rows = $query->paginate(20);
		$this->layout->content = View::make('sub_categories.index',array(
			'rows'=>$rows,
			'categories'=>$categories,
		));
	}

	public function getCreate()
	{
		$category = Category::where('client_id','=',Auth::user()->client_id)->get();
		$categories = array(''=>'== Select once ==');
		foreach($category as $cate){
			$categories[$cate->id] = $cate->name;
		}
		$this->layout->content = View::make('sub_categories.create',array(
			'categories'=>$categories,
		));
	}

	public function postCreate()
	{
		$model = new SubCategory();
		$model->client_id = Auth::user()->client_id;
		$model->category_id = Input::get('category_id');
		$model->name = Input::get('name');
		$model->description = Input::get('description');
		$model->status = Input::get('status');
		$model->created_at = time();
		if($model->save())
			return Redirect::route('sub-categories.list')->with('success', Lang::get('label.create_sub_category_success'));
		else
			return Redirect::route('sub-categories.create')->withErrors($model->errors)->withInput();
	}

	public function getUpdate()
	{
		$id=Input::get('id');
		$model = SubCategory::where('client_id','=',Auth::user()->client_id)->find($id);
		if(empty($model))
			return Redirect::route('sub-categories.list');
		$category = Category::where('client_id','=',Auth::user()->client_id)->get();
		$categories = array(''=>'== Select once ==');
		foreach($category as $cate){
			$categories[$cate->id] = $cate->name;
		}
		$this->layout->content = View::make('sub_categories.update')->with(array(
			'model'=>$model,
			'categories'=>$categories,
		));
	}

	public function postUpdate(){
		$id=Input::get('id');
		$model = SubCategory::where('client_id','=',Auth::user()->client_id)->find($id);
		$model->client_id = Auth::user()->client_id;
		$model->category_id = Input::get('category_id');
		$model->name = Input::get('name');
		$model->description = Input::get('description');
		$model->status = Input::get('status');
		if($model->save())
			return Redirect::route('sub-categories.list')->with('success', Lang::get('label.update_sub_category_success'));
		else
			return Redirect::route('sub-categories.update',array('id'=>$id))->withErrors($model->errors)->withInput();
	}

	public function getDelete()
	{
		$id = Input::get('id');
		$row = SubCategory::where('client_id','=',Auth::user()->client_id)->find($id);
		if($row->delete()){
			return Redirect::route('sub-categories.list')->with('success', Lang::get('label.delete_sub_category_success'));
		}
	}
} 