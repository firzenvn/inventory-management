<?php
/**
 * Created by PhpStorm.
 * User: DONY
 * Date: 12/5/2014
 * Time: 2:18 PM
 */

class SubCategoriesAdminController extends BaseAdminController{
	protected $layout = "layouts.inventory";

	public function getIndex()
	{
		$query=new SubCategory();
		if (Input::has('id'))
			$query = $query->where('id', '=', Input::get("id"));
		if (Input::has('client_id'))
			$query = $query->where('client_id', '=', Input::get("client_id"));
		if (Input::has('category_id'))
			$query = $query->where('category_id', '=', Input::get("category_id"));
		if (Input::has('status'))
			$query = $query->where('status', '=', Input::get("status"));
		if (Input::has('name'))
			$query = $query->where('name', 'like', '%'.Input::get("name").'%');
		if (Input::has('description'))
			$query = $query->where('description', 'like', '%'.Input::get("description").'%');

		$category = Category::get();
		$categories = array(''=>'== Select once ==');
		foreach($category as $cate){
			$categories[$cate->id] = $cate->name;
		}

		$sort = Input::has('sort') ? Input::get('sort') : 'id';
		$order = Input::get('order') === 'asc' ? 'asc' : 'desc';
		$query = $query->orderBy($sort, $order);
		$rows = $query->paginate(20);
		$this->layout->content = View::make('sub_categories.admin.index',array(
			'rows'=>$rows,
			'categories'=>$categories,
		));
	}

	public function getCreate()
	{
		$category = Category::get();
		$categories = array(''=>'== Select once ==');
		foreach($category as $cate){
			$categories[$cate->id] = $cate->name;
		}
		$this->layout->content = View::make('sub_categories.admin.create',array(
			'categories'=>$categories,
		));
	}

	public function postCreate()
	{
		$model = new SubCategory();
		$model->client_id = Input::get('client_id');
		$model->category_id = Input::get('category_id');
		$model->name = Input::get('name');
		$model->description = Input::get('description');
		$model->status = Input::get('status');
		$model->created_at = time();
		if($model->save())
			return Redirect::route('admin.sub-categories.list')->with('success', Lang::get('label.create_sub_category_success'));
		else
			return Redirect::route('admin.sub-categories.create')->withErrors($model->errors)->withInput();
	}

	public function getUpdate()
	{
		$id=Input::get('id');
		$model = SubCategory::find($id);
		$category = Category::get();
		$categories = array(''=>'== Select once ==');
		foreach($category as $cate){
			$categories[$cate->id] = $cate->name;
		}
		$this->layout->content = View::make('sub_categories.admin.update')->with(array(
			'model'=>$model,
			'categories'=>$categories,
		));
	}

	public function postUpdate(){
		$id=Input::get('id');
		$model = SubCategory::find($id);
		$model->client_id = Input::get('client_id');;
		$model->category_id = Input::get('category_id');
		$model->name = Input::get('name');
		$model->description = Input::get('description');
		$model->status = Input::get('status');
		if($model->save())
			return Redirect::route('admin.sub-categories.list')->with('success', Lang::get('label.update_sub_category_success'));
		else
			return Redirect::route('admin.sub-categories.update',array('id'=>$id))->withErrors($model->errors)->withInput();
	}

	public function getDelete()
	{
		$id = Input::get('id');
		$row = SubCategory::find($id)->delete();
		if($row){
			return Redirect::route('admin.sub-categories.list')->with('success', Lang::get('label.delete_sub_category_success'));
		}
	}
} 