<?php
/**
 * Created by PhpStorm.
 * User: DONY
 * Date: 12/5/2014
 * Time: 2:01 PM
 */

class CategoriesAdminController extends BaseAdminController {
	protected $layout = "layouts.inventory";

	public function getIndex()
	{
		$query=new Category();
		if (Input::has('id'))
			$query = $query->where('id', '=', Input::get("id"));
		if (Input::has('client_id'))
			$query = $query->where('client_id', '=', Input::get("client_id"));
		if (Input::has('status'))
			$query = $query->where('status', '=', Input::get("status"));
		if (Input::has('name'))
			$query = $query->where('name', 'like', '%'.Input::get("name").'%');
		if (Input::has('description'))
			$query = $query->where('description', 'like', '%'.Input::get("description").'%');

		$sort = Input::has('sort') ? Input::get('sort') : 'id';
		$order = Input::get('order') === 'asc' ? 'asc' : 'desc';
		$query = $query->orderBy($sort, $order);
		$rows = $query->paginate(20);
		$this->layout->content = View::make('categories.admin.index',array(
			'rows'=>$rows,
		));
	}

	public function getCreate()
	{
		$this->layout->content = View::make('categories.admin.create');
	}

	public function postCreate()
	{
		$model = new Category();
		$model->client_id = Input::get('client_id');
		$model->name = Input::get('name');
		$model->description = Input::get('description');
		$model->status = Input::get('status');
		$model->created_at = time();
		if($model->save())
			return Redirect::route('admin.categories.list')->with('success', Lang::get('label.create_category_success'));
		else
			return Redirect::route('admin.categories.create')->withErrors($model->errors)->withInput();
	}

	public function getUpdate()
	{
		$id=Input::get('id');
		$model = Category::find($id);
		$this->layout->content = View::make('categories.admin.update')->with(array(
			'model'=>$model,
		));
	}

	public function postUpdate(){
		$id=Input::get('id');
		$model = Category::find($id);
		$model->client_id = Input::get('client_id');
		$model->name = Input::get('name');
		$model->description = Input::get('description');
		$model->status = Input::get('status');
		if($model->save())
			return Redirect::route('admin.categories.list')->with('success', Lang::get('label.update_category_success'));
		else
			return Redirect::route('admin.categories.update',array('id'=>$id))->withErrors($model->errors)->withInput();
	}

	public function getDelete()
	{
		$id = Input::get('id');
		$row = Category::find($id)->delete();
		$sub_categories = SubCategory::where('category_id','=',$id)->delete();
		if($sub_categories && $row){
			return Redirect::route('admin.categories.list')->with('success', Lang::get('label.delete_category_success'));
		}
	}
} 