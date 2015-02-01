<?php
/**
 * Created by PhpStorm.
 * User: DONY
 * Date: 12/4/2014
 * Time: 10:55 PM
 */

class ProductsAdminController extends BaseController {
	protected $layout = "layouts.inventory";

	public function getIndex()
	{
		$query=new Product();
		if (Input::has('id'))
			$query = $query->where('id', '=', Input::get("id"));
		if (Input::has('client_id'))
			$query = $query->where('client_id', '=', Input::get("client_id"));
		if (Input::has('sku'))
			$query = $query->where('sku', '=', Input::get("sku"));
		if (Input::has('price'))
			$query = $query->where('price', '=', Input::get("price"));
		if (Input::has('quantity'))
			$query = $query->where('quantity', '=', Input::get("quantity"));
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
		$this->layout->content = View::make('products.admin.index',array(
			'rows'=>$rows,
		));
	}

	public function getCreate()
	{
		$categories = Category::get();
		$this->layout->content = View::make('products.admin.create',array(
			'categories'=>$categories,
		));
	}

	public function postCreate()
	{
		$model = new Product();
		$model->client_id = Input::get('client_id');
		$model->name = Input::get('name');
		$model->sku = Input::get('sku');
		$model->price = Input::get('price');
		$model->quantity = Input::get('quantity');
		$model->status = Input::get('status');
		$model->created_at = time();
		if($model->save()) {
			$sub_categories = Input::get('sub_cate');
			if(!empty($sub_categories)) {
				foreach ($sub_categories as $sub_cate_id) {
					$produc_cate = new ProductCategory();
					$produc_cate->client_id = Input::get('client_id');
					$produc_cate->product_id = $model->id;
					$produc_cate->sub_category_id = $sub_cate_id;
					$produc_cate->created_at = time();
					$produc_cate->save();
				}
			}
			return Redirect::route('admin.products.list')->with('success', Lang::get('label.create_product_success'));
		}else
			return Redirect::route('admin.products.create')->withErrors($model->errors)->withInput();
	}

	public function getUpdate()
	{
		$id=Input::get('id');
		$model = Product::find($id);
		$categories = Category::get();
		$sub_categories = ProductCategory::where('product_id','=',$id)->get();
		$sub_cates = array();
		foreach($sub_categories as $sc){
			$sub_cates[] = $sc->sub_category_id;
		}
		$this->layout->content = View::make('products.admin.update')->with(array(
			'model'=>$model,
			'categories'=>$categories,
			'sub_cates'=>$sub_cates,
		));
	}

	public function postUpdate(){
		$id=Input::get('id');
		$model = Product::find($id);
		$model->client_id = Input::get('client_id');
		$model->name = Input::get('name');
		$model->sku = Input::get('sku');
		$model->price = Input::get('price');
		$model->quantity = Input::get('quantity');
		$model->status = Input::get('status');
		if($model->save()){
			$sub_category = ProductCategory::where('product_id','=',$id)->delete();
			$sub_categories = Input::get('sub_cate');
			if(!empty($sub_categories)) {
				foreach($sub_categories as $sub_cate_id){
					$produc_cate = new ProductCategory();
					$produc_cate->client_id = Input::get('client_id');
					$produc_cate->product_id = $model->id;
					$produc_cate->sub_category_id = $sub_cate_id;
					$produc_cate->created_at = time();
					$produc_cate->save();
				}
			}
			return Redirect::route('admin.products.list')->with('success', Lang::get('label.update_product_success'));
		}else
			return Redirect::route('admin.products.update',array('id'=>$id))->withErrors($model->errors)->withInput();
	}

	public function getDelete()
	{
		$id = Input::get('id');
		$row = Product::find($id)->delete();
		$sub_category = ProductCategory::where('product_id','=',$id)->delete();
		if($sub_category && $row){
			return Redirect::route('admin.products.list')->with('success', Lang::get('label.delete_product_success'));
		}
	}
} 