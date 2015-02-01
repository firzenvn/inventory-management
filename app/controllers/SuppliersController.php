<?php
/**
 * Created by PhpStorm.
 * User: DONY
 * Date: 10/17/2014
 * Time: 5:39 PM
 */

class SuppliersController extends BaseController {
	protected $layout = "layouts.inventory";

	function __construct(){
		$this->beforeFilter('auth');
		$this->beforeFilter('acl');
	}

	public function getIndex()
	{
		$query=new Supplier();
		if (Input::has('seq_no'))
			$query = $query->where('seq_no', '=', Input::get("seq_no"));
		if (Input::has('email'))
			$query = $query->where('email', '=', Input::get("email"));
		if (Input::has('phone_no'))
			$query = $query->where('phone_no', '=', Input::get("phone_no"));
		if (Input::has('fax'))
			$query = $query->where('fax', '=', Input::get("fax"));
		if (Input::has('street'))
			$query = $query->where('street', '=', Input::get("street"));
		if (Input::has('city'))
			$query = $query->where('city', '=', Input::get("city"));
		if (Input::has('status'))
			$query = $query->where('status', '=', Input::get("status"));
		if (Input::has('name'))
			$query = $query->where('name', 'like', '%'.Input::get("name").'%');
		if (Input::has('person'))
			$query = $query->where('person', 'like', '%'.Input::get("person").'%');

		$sort = Input::has('sort') ? Input::get('sort') : 'seq_no';
		$order = Input::get('order') === 'asc' ? 'asc' : 'desc';
		$query = $query->where('client_id','=',Auth::user()->client_id)->orderBy($sort, $order);
		$rows = $query->paginate(20);
		$this->layout->content = View::make('suppliers.index',array(
			'rows'=>$rows,
		));
	}

	public function getCreate()
	{
		$countries = Country::select(array('id','name'))->get();
		$list_country = array();
		foreach($countries as $country){
			$list_country[$country->id] = $country->name;
		}
		$this->layout->content = View::make('suppliers.create')->with(array(
			'countries'=>$list_country,
		));
	}

	public function postCreate()
	{
		$model = new Supplier();
		$model->client_id = Auth::user()->client_id;
		$model->name = Input::get('supplier_name');
		$model->person = Input::get('supplier_person');
		$model->email = Input::get('supplier_email');
		$model->phone_no = Input::get('phone_no');
		$model->fax = Input::get('fax');
		$model->street = Input::get('street');
		$model->city = Input::get('city');
		$model->country_id = Input::get('country_id');
		$model->province = Input::get('province');
		$model->zipcode = Input::get('zipcode');
		$model->website = Input::get('website');
		$model->description = Input::get('description');
		$model->status = Input::get('status');
		$model->created_at = time();
		if($model->save())
			return Redirect::route('suppliers.list')->with('success', Lang::get('label.create_supplier_success'));
		else
			return Redirect::route('suppliers.create')->withErrors($model->errors)->withInput();
	}

	public function getUpdate()
	{
		$countries = Country::select(array('id','name'))->get();
		$list_country = array();
		foreach($countries as $country){
			$list_country[$country->id] = $country->name;
		}
		$id=Input::get('id');
		$model = Supplier::where('client_id','=',Auth::user()->client_id)->find($id);
		if(empty($model))
			return Redirect::route('suppliers.list');
		$this->layout->content = View::make('suppliers.update')->with(array(
			'countries'=>$list_country,
			'model'=>$model,
		));
	}

	public function postUpdate()
	{
		$id=Input::get('id');
		$model = Supplier::where('client_id','=',Auth::user()->client_id)->find($id);
		$model->client_id = Auth::user()->client_id;
		$model->name = Input::get('supplier_name');
		$model->person = Input::get('supplier_person');
		$model->email = Input::get('supplier_email');
		$model->phone_no = Input::get('phone_no');
		$model->fax = Input::get('fax');
		$model->street = Input::get('street');
		$model->city = Input::get('city');
		$model->country_id = Input::get('country_id');
		$model->province = Input::get('province');
		$model->zipcode = Input::get('zipcode');
		$model->website = Input::get('website');
		$model->description = Input::get('description');
		$model->status = Input::get('status');
		if($model->save())
			return Redirect::route('suppliers.list')->with('success', Lang::get('label.update_supplier_success'));
		else
			return Redirect::route('suppliers.update',array('id'=>$id))->withErrors($model->errors);
	}

	public function getDelete()
	{
		$id = Input::get('id');
		$row = Supplier::where('client_id','=',Auth::user()->client_id)->find($id);
		$row->productSupplierItem()->delete();
		if($row->delete()){
			return Redirect::route('suppliers.list')->with('success', Lang::get('label.delete_supplier_success'));
		}
	}

	public function getProductSupplier(){
		$id = Input::get('supplier_id');
		$model = Supplier::where('client_id','=',Auth::user()->client_id)->where('id','=',$id)->first();

		if(empty($model)){
			return Redirect::route('suppliers.list')->with('error',"Supplier does not exist");
		}
		$query = new ProductSupplierItem();
		$sort = Input::has('sort') ? Input::get('sort') : 'id';
		$order = Input::get('order') === 'asc' ? 'asc' : 'desc';
		$query = $query->where('supplier_id','=',$id)->where('client_id', '=', Auth::user()->client_id)->orderBy($sort, $order);
		$product_supplier_item_count = $query->count();
		$rows = $query->paginate(Config::get("constant.paginate"));
		$rows->setBaseUrl(URL::route('suppliers.search-product-supplier.get'));
		return View::make('suppliers.productSuppliers')->with(array(
			'model'=>$model,
			'product_supplier_items'=> $rows,
			'product_supplier_item_count'=> $product_supplier_item_count,
		));
	}

	public function getDeleteProductSupplier(){
		$id = Input::get('id');
		$supplier_id = Input::get('supplier_id');
		$row = ProductSupplierItem::where('client_id','=',Auth::user()->client_id)->where('supplier_id','=',$supplier_id)->find($id);
		if($row->delete()){
			return Redirect::route('suppliers.search-product-supplier.get',array('supplier_id'=>$supplier_id));
		}
	}

	public function getSearchProductSupplier(){
		$id = Input::get('supplier_id');
		$model = Supplier::where('client_id','=',Auth::user()->client_id)->where('id','=',$id)->first();
		if(empty($model)){
			return Redirect::route('suppliers.list')->with('error',"Supplier does not exist");
		}

		$query = new ProductSupplierItem();
		if (Input::has('sku')){
			$sku = Input::get("sku");
			$product = Product::where('sku','=',$sku)->where('client_id', '=', Auth::user()->client_id)->first();
			$query = $query->where('product_id', '=', $product->id);
		}
		Session::put('product_supplier_search', Input::all());

		$sort = Input::has('sort') ? Input::get('sort') : 'id';
		$order = Input::get('order') === 'asc' ? 'asc' : 'desc';
		$query = $query->where('supplier_id','=',$id)->where('client_id', '=', Auth::user()->client_id)->orderBy($sort, $order);
		$product_supplier_item_count = $query->count();
		$rows = $query->paginate(Config::get("constant.paginate"));
		$rows->setBaseUrl(URL::route('suppliers.search-product-supplier.get'));
		return View::make('suppliers._listProductSupplierItems')->with(array(
			'model'=>$model,
			'product_supplier_items'=> $rows,
			'product_supplier_item_count'=> $product_supplier_item_count,
		));
	}

	public function postProductSupplier(){
		Session::put('assign_product_supplier',true);
		$product_items = Input::get('product_item');
		$product_item_info = Input::get('product_item_info');
		$supplier_id = Input::get('supplier_id');

		$model = Supplier::where('client_id','=',Auth::user()->client_id)->where('id','=',$supplier_id)->first();
		if(empty($model)){
			return Redirect::route('suppliers.list')->with('error',"Supplier does not exist");
		}
		//IMPORT CSV
		if(Input::has('csv_content_file')){
			$csv_content_file = Input::get('csv_content_file');
			if(empty($csv_content_file))
				return Redirect::route('suppliers.product-supplier.get',array('supplier_id'=>$supplier_id))->with('error', 'File CSV Is Empty');

			//$result = $this->importCSV($supplier_id, $csv_content_file);
			$result = $this->importTermCSV($supplier_id, $csv_content_file);
			if(isset($result['data']) && !empty($result['data'])){
				Session::put('dataImport', json_encode($result['data']));
			}

			return Redirect::route('suppliers.update.get',array('id'=>$supplier_id))->with($result['status'], $result['message']);
		}

		$validator = Validator::make(Input::all(), array(
			'product_item' => 'required',
			'supplier_id' => 'required',
		));

		if (!$validator->passes()) {
			return Redirect::route('suppliers.product-supplier.get',array('id',$supplier_id))->with('error',$validator->messages()->all())->withInput();
		}

		foreach($product_items as $key => $product_id){
			$info_item = $product_item_info[$product_id];
			if(!empty($info_item)){
				$item = ProductSupplierItem::firstOrNew(array(
					'supplier_id' => $supplier_id,
					'product_id' => $product_id,
					'client_id' => Auth::user()->client_id
				));
				$item->client_id = Auth::user()->client_id;
				$item->supplier_id = $supplier_id;
				$item->product_id = $product_id;
				$item->cost = $info_item['cost'];
				$item->tax = $info_item['tax'];
				$item->discount = $info_item['discount'];
				$item->supplier_sku = $info_item['supplier_sku'];
				$item->created_at = date('Y-m-d H:i:s');
				$item->save();
			}
		}

		return Redirect::route('suppliers.update.get',array('id'=>$supplier_id))->with('success', "Assign Product Success");
	}

	public function getListProducts()
	{
		$query = new Product();
		if (!Input::has('supplier_id')){
			return "";
		}

		$id = Input::get('supplier_id');
		$model = Supplier::where('client_id','=',Auth::user()->client_id)->where('id','=',$id)->first();
		foreach($model->productSupplierItem as $row){
			$query = $query->where('id', '!=', $row->product->id);
		}

		if (Input::has('id'))
			$query = $query->where('id', '=', Input::get("id"));
		if (Input::has('sku'))
			$query = $query->where('sku', '=', Input::get("sku"));
		if (Input::has('price'))
			$query = $query->where('price', '=', Input::get("price"));
		if (Input::has('quantity'))
			$query = $query->where('quantity', '=', Input::get("quantity"));
		if (Input::has('status'))
			$query = $query->where('status', '=', Input::get("status"));
		if (Input::has('name'))
			$query = $query->where('name', 'like', '%' . Input::get("name") . '%');
		if (Input::has('description'))
			$query = $query->where('description', 'like', '%' . Input::get("description") . '%');
		Session::put('product_search', Input::all());

		$sort = Input::has('sort') ? Input::get('sort') : 'id';
		$order = Input::get('order') === 'asc' ? 'asc' : 'desc';
		$query = $query->where('client_id', '=', Auth::user()->client_id)->orderBy($sort, $order);
		$rows = $query->paginate(Config::get("constant.paginate"));

		return  View::make('suppliers.listProducts', array(
			'supplier_id' => $id,
			'rows' => $rows,
		));
	}

	private function importTermCSV($supplier_id, $csv_content_file)
	{
		$csv_paser = json_decode($csv_content_file);
		$col_number = 5; // Số cột import
		//define column
		$sku = 0;
		$cost = 1;
		$discount = 1;
		$tax = 3;
		$supplier_sku = 4;

		$insert_row = 0;
		$data = array();
		if(is_array($csv_paser) && count($csv_paser) > 1){ // Row đầu tiên là tên cột
			foreach($csv_paser as $key=>$items){
				if($key > 0 && count($items) == $col_number){
					$data[$items[$sku]] = array(
						'cost' => $items[$cost],
						'tax' => $items[$tax],
						'discount' => $items[$discount],
						'supplier_sku' => $items[$supplier_sku],
					);
				}
			}
			return array('status' => 'success','message'=>'Import success!. Row number apply: ' . $insert_row,'data'=>$data);
		}
		return array('status' => 'error','message'=>'Import fail! CSV File Invalid');
	}

	private function importCSV($supplier_id, $csv_content_file)
	{
		$csv_paser = json_decode($csv_content_file);
		$col_number = 5; // Số cột import
		//define column
		$sku = 0;
		$cost = 1;
		$discount = 1;
		$tax = 3;
		$supplier_sku = 4;

		$insert_row = 0;
		if(is_array($csv_paser) && count($csv_paser) > 1){ // Row đầu tiên là tên cột
			foreach($csv_paser as $key=>$items){
				if($key > 0 && count($items) == $col_number){
					$product = Product::where('sku','=',$items[$sku])->where('client_id', '=', Auth::user()->client_id)->first();
					if(!empty($product)){
						$item = ProductSupplierItem::firstOrNew(array(
							'supplier_id' => $supplier_id,
							'product_id' => $product->id,
							'client_id' => Auth::user()->client_id
						));
						$item->client_id = Auth::user()->client_id;
						$item->supplier_id = $supplier_id;
						$item->product_id = $product->id;
						$item->cost = $items[$cost];
						$item->tax = $items[$tax];
						$item->discount = $items[$discount];
						$item->supplier_sku = $items[$supplier_sku];
						$item->updated_at = date('Y-m-d H:i:s');
						$item->save();
						$insert_row++;
					}
				}
			}
			return array('status' => 'success','message'=>'Import success!. Row number apply: ' . $insert_row);
		}
		return array('status' => 'error','message'=>'Import fail! CSV File Invalid');
	}
} 