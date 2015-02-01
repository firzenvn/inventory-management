<?php
/**
 * Created by PhpStorm.
 * User: Hoangtv
 * Date: 12/18/2014
 * Time: 10:13 AM
 */
class AdjustStockController extends BaseController{
	protected $layout = "layouts.inventory";
	function __construct(){
		$this->beforeFilter('auth');
		$this->beforeFilter('acl');
	}

	public function getIndex(){
		$this->layout->content=View::make('adjustStock.index');
	}

	public function getCreate(){
		$this->layout->content=View::make('adjustStock.create');
	}

	public function getListPhysical(){
		$client=App::make('client');
		$sort='id';
		$order='desc';
		$rows=$client->ReportPhysical();
		$data=$rows->orderBy($sort,$order)->paginate(10);
		$this->layout->content=View::make('adjustStock.physicalList')->with(array('rows'=>$data));
	}

	public function getListAdjust(){
		$client=App::make('client');
		$sort='id';
		$order='desc';
		$rows=$client->ReportAdjust();
		$data=$rows->orderBy($sort,$order)->paginate(10);
		$this->layout->content=View::make('adjustStock.adjustList')->with(array('rows'=>$data));
	}

	public function getCreateAdjust(){
		$this->layout->content=View::make('adjustStock.adjust');
	}

	public function postCreateAdjust(){
		$input=Input::all();
		$input['client_id']=Auth::user()->client_id;
		$input['user_id']=Auth::user()->id;
		$report=new ReportAdjustStock($input);
		if($report->save())
			return Redirect::route('adjustStock.add_product_adjust.get',array('report_id'=>$report->id))->with('success',Lang::get('adjuststock.add_new_report_phy_success'));
		return Redirect::back()->withInput()->with('error',$report->error);
	}

	public function postCreatePhysical(){
		$input=Input::all();
		$input['client_id']=Auth::user()->client_id;
		$input['user_id']=Auth::user()->id;
		$report=new ReportPhysicalStocktaking($input);
		if($report->save()){
			$report->csv_file_name=$report->id.'_'.Auth::user()->client_id.'_'.Auth::user()->id.'_'.md5($report->id);
			$report->update();
			return Redirect::route('adjustStock.add_product_phy.get',array('report_id'=>$report->id))->with('success',Lang::get('adjuststock.add_new_report_phy_success'));
		}
		return Redirect::back()->withInput()->with('error',$report->error);
	}

	public function getAddAdjust(){
		$id=Input::get('report_id');
		$report=ReportAdjustStock::find($id);
		if(empty($report)){
			$this->layout->content=View::make('adjustStock.addAdjust')->with('error','Report Physical not exits');
			return;
		}
		$data=array();
		$page=1;
		$limit=20;
		if(Input::has('page'))
			$page=Input::get('page');
		if(!empty($report->csv_file_name)){
			$filename=public_path().'/csv/adjuststock/adjust/data/'.$report->csv_file_name;
			if(is_file($filename)){
				$content=file_get_contents($filename);
				$data=json_decode($content);
			}
		}
		if($report->status!='Pending')
			return Redirect::route('adjuststock.list')->with('error','Report id='.$id.' not pedding');
		//check report has procu item
		$produc_item=AdjustStockItem::where('py_id','=',$id)->get();
		$this->layout->content=View::make('adjustStock.addAdjust')->with(array('model'=>$report,'product'=>$produc_item,'data'=>$data));

	}

	public function postAddAdjust(){
		$phy_qty=Input::get('phy_qty');
		$list_id=Input::get('reviews');
		$rp=Input::get('rp');
		//check product for wh and client_id
		$rs_rp=ReportAdjustStock::find($rp);
		$rs_rp->reasons=Input::get('reasons');
		if(empty($rs_rp))
			return Redirect::back()->withInput()->with('error',Lang::get('adjuststock.no_found_report'));
		if($rs_rp->user_id != Auth::user()->id)
			return Redirect::back()->withInput()->with('error',Lang::get('adjuststock.not_auth_report'));
		if(Input::has('id_re') && Input::hasFile('csv_file')){
			$link_file=$this->proccessFileCsv(Input::file('csv_file'),'adjust');
			if($link_file!==false)
				$rs_rp->csv_file_name=$link_file;
			else
				return Redirect::back()->withInput()->with('error',Lang::get('adjuststock.error_import_file_csv'));
		}
		if(Input::has('complate')){
			//todo update so luong san pham
			$rs_rp->status='Confirmed';
		}
		if($rs_rp->update())
			return Redirect::back()->with('success',Lang::get('adjuststock.create_report'));
		return Redirect::back()->withInput()->with('error',Lang::get('adjuststock.database_error'));
	}

	public function getAddPhysical(){
		$id=Input::get('report_id');
		$report=ReportPhysicalStocktaking::find($id);
		if(empty($report)){
			$this->layout->content=View::make('adjustStock.addPhysical')->with('error','Report Physical not exits');
			return;
		}
		$data=array();
		$page=1;
		$limit=20;
		if(Input::has('page'))
			$page=Input::get('page');
		if(!empty($report->csv_file_name)){
			$filename=public_path().'/csv/adjuststock/physical/data/'.$report->csv_file_name;
			if(is_file($filename)){
				$content=file_get_contents($filename);
				$data=json_decode($content);
			}
		}
		if($report->status!='Pending')
			return Redirect::route('physical.list')->with('error','Report id='.$id.' not pedding');
		//check report has procu item
		$produc_item=PhysicalStocktakinItem::where('py_id','=',$id)->get();
		$this->layout->content=View::make('adjustStock.addPhysical')->with(array('model'=>$report,'product'=>$produc_item,'data'=>$data));
	}

	public function postAddPhysical(){
		$phy_qty=Input::get('phy_qty');
		$list_id=Input::get('reviews');
		$rp=Input::get('rp');
		//check product for wh and client_id
		$rs_rp=ReportPhysicalStocktaking::find($rp);
		$rs_rp->reasons=Input::get('reasons');
		if(empty($rs_rp))
			return Redirect::back()->withInput()->with('error',Lang::get('adjuststock.no_found_report'));
		if($rs_rp->user_id != Auth::user()->id)
			return Redirect::back()->withInput()->with('error',Lang::get('adjuststock.not_auth_report'));
		if(Input::has('id_re') && Input::hasFile('csv_file')){
			$link_file=$this->proccessFileCsv(Input::file('csv_file'));
			if($link_file!==false)
				$rs_rp->csv_file_name=$link_file;
			else
				return Redirect::back()->withInput()->with('error',Lang::get('adjuststock.error_import_file_csv'));
		}
		if(Input::has('complate')){
			Event::fire('adjustFromPhysical.create', array($rs_rp->id));
			$rs_rp->status='Confirmed';
		}
		if(Input::has('complate_update'))
		{
			Event::fire('adjustFromPhysical.create_success', array($rs_rp->id,'Completed'));
			$rs_rp->status='Confirmed';
		}
		if($rs_rp->update())
			return Redirect::back()->with('success',Lang::get('adjuststock.create_report'));
		return Redirect::back()->withInput()->with('error',Lang::get('adjuststock.database_error'));
	}

	/**
	 * proccess file csv upload
	 * @param $file
	 * @return mixed
	 */
	public function proccessFileCsv($file,$swicht='physical'){
		if($swicht=='physical')
			$destinationPath = public_path().'/csv/adjuststock/physical';
		else
			$destinationPath = public_path().'/csv/adjuststock/adjust';
		$filename        = Input::get('id_re'). '_' .Auth::user()->client_id.'_'.Auth::user()->id.'_'.md5(Input::get('id_re'));
		$uploadSuccess   = $file->move($destinationPath, $filename);
		$file_path=$destinationPath.'/'.$filename;
		$file = fopen($file_path,"r");
		$data=array();
		$list_sku=array();
		$list_physicaltaking=array();
		$check_formmat_file=0;
		while(!feof($file)){
			$r=fgetcsv($file);
			if(strtolower($r[0])==='sku' && strtolower($r[1])==='qty')
				$check_formmat_file=1;
			if($check_formmat_file==1){
				if(!empty($r))
					$data[]=$r;
				if(!empty($r[0]) && strtolower($r[0])!='sku')
					$list_physicaltaking[trim($r[0])]=isset($r[1])?$r[1]:'';
				if(!empty($r[0]) && strtolower($r[0])!='sku')
				$list_sku[]=$r[0];
			}

		}
		fclose($file);
		if(empty($data) || $check_formmat_file==0)
			return false;
		//lay thong tin cu neu có và cập nhật lại
		$old_data_link=$destinationPath.'/data/'.$filename;
		$old_physicaltaking=array();
		$old_list_sku=array();
		if(is_file($old_data_link)){
			$rs=file_get_contents($old_data_link);
			$rs=json_decode($rs);
			foreach($rs as $k=>$v){
				if(!empty($v))
					$data[]=$v;
				if(!empty($v[3]) && $v[3]!='sku')
					$old_physicaltaking[trim($v[3])]=$v[6];
				if(!empty($v[3]) && $v[3]!='sku')
					$old_list_sku[]=$v[3];
			}
		}
		if(!empty($old_physicaltaking) && !empty($old_list_sku)){
			foreach($list_sku as $k=>$v){
				if(!in_array($v,$old_list_sku)){
					$old_list_sku[]=$v;
					$old_physicaltaking[$v]=$list_physicaltaking[$v];
				}else{
					$old_physicaltaking[$v]=$list_physicaltaking[$v];
				}
			}
		}else{
			$old_list_sku=$list_sku;
			$old_physicaltaking=$list_physicaltaking;
		}

		//lay thong tin san pham luu file csv
		$rs_product=Product::whereIn('sku',$old_list_sku)->get();
		$csvput=array();
		$csvput[]=['id','name','status','sku','img','price','physicaltaking'];
		foreach($rs_product as $r){
			$csvput[]=[$r->id,$r->name,$r->status,$r->sku,'',$r->price,$old_physicaltaking[$r->sku]];
		}
		$json=json_encode($csvput);
		$filename=$destinationPath.'/data/'.$filename;
		file_put_contents($filename,$json);
		//up date thong tin file csv vào bao cao
		return $uploadSuccess->getFilename();
	}

	##-----------------------------delete--------------------------
	public function getDeletePhysical(){
		$id = Input::get('id');
		$model = ReportPhysicalStocktaking::find($id);
		if($model->client_id!=Auth::user()->client_id)
			return Redirect::route('physical.list');
		if($model->delete()){
			return Redirect::route('physical.list')->with('success', Lang::get('adjuststock.mes_delete_success'));
		}
	}

	public function getDeleteAdjust(){
		$id = Input::get('id');
		$model = ReportAdjustStock::find($id);
		if($model->client_id!=Auth::user()->client_id)
			return Redirect::route('adjuststock.list');
		if($model->delete()){
			return Redirect::route('adjuststock.list')->with('success', Lang::get('adjuststock.mes_delete_success'));
		}
	}
	##-------------------------------------------ajax proccess-----------------------

	/**
	 * search product in warehouse
	 * @return string
	 */
	public function postAjaxSearch(){
		$switch=Input::get('switch');
		$rpid=Input::get('rid');
		$file_name=$rpid.'_'.Auth::user()->client_id.'_'.Auth::user()->id.'_'.md5($rpid);
		if(empty($rpid))
			return '<tr><td colspan="8" style="text-align: center">Request data invalid </td></tr>';
		if($switch=='physical') {
			$path = public_path() . '/csv/adjuststock/physical/data/' . $file_name;
			$re = ReportPhysicalStocktaking::where('id', '=', $rpid)->where('user_id', '=', Auth::user()->id)->get();
		}
		else{
			$path=public_path().'/csv/adjuststock/adjust/data/'.$file_name;
			$re=ReportAdjustStock::where('id','=',$rpid)->where('user_id','=',Auth::user()->id)->get();
		}
		if(empty($re[0]))
			return '<tr><td colspan="8" style="text-align: center">Report not found</td></tr>';
		///list product in wh
		//TODO kiểm tra lai quyen truy cập
		$list_id_pro=WarehouseProduct::where('warehouse_id','=',$re[0]->warehouse_id)->get();
		$data_list=array();
		if(!empty($list_id_pro))
			foreach($list_id_pro as $row)
				$data_list[]=$row->product_id;
		if(empty($data_list))
			return '<tr><td colspan="8" style="text-align: center">Warehouse empty</td></tr>';
		$produc=new Product();
		$produc=$produc->whereIn('id',$data_list);
		$allow_id=$this->getArrayIdFromFile($path);
		if(!empty($allow_id))
		{
			$produc=$produc->whereNotIn('id',$allow_id);
		}
		if(Input::has('id')){
			$arrr=explode('>',Input::get('id'));
			if(count($arrr)<2)
				$produc=$produc->where('seq_no','=',Input::get('id'));
			else{
				$from=intval($arrr[0]);
				$to=intval($arrr[1]);
				if($to > $from)
					$produc=$produc->whereBetween('seq_no',array($from,$to));
			}
		}
		if(Input::has('name'))
			$produc=$produc->where('name','like','%'.Input::get('name').'%');
		if(Input::has('status'))
			$produc=$produc->where('status','=',Input::get('status'));
		if(Input::has('sku'))
			$produc=$produc->where('sku','like','%'.Input::get('sku').'%');
		if(Input::has('price')){
			$arrr=explode('>',Input::get('price'));
			if(count($arrr)<2)
				$produc=$produc->where('price','=',Input::get('price'));
			else{
				$from=intval($arrr[0]);
				$to=intval($arrr[1]);
				if($to > $from)
					$produc=$produc->whereBetween('price',array($from,$to));
			}
		}
		$produc=$produc->orderBy('id', 'desc');
		$page=Input::get('page');
		if($page!=''){
			$ofset=$page*10-1;
			$rows=$produc->take(10)->skip($ofset)->get();
		}
		else
			$rows=$produc->take(10)->skip(0)->get();
		if(count($rows)==0)
			return '<tr><td colspan="8" style="text-align: center">Product not found</td></tr>';
		$html='';
		foreach($rows as $row){
			$seq_no=isset($row->seq_no)?$row->seq_no:'';
			$html.='<tr id="tr_c_'.$row->id.'">
	            <td>'.$seq_no.'</td>
	            <td>'.$row->name .'</td>
	            <td>'. $row->status .'</td>
	            <td>'. $row->sku.'</td>
	            <td></td>
	            <td>'. $row->price .'</td>
	            <td>'.Form::text('phy_qty['.$row->id.']','',array('class'=>'phy_qty_'.$row->id)) .'</td>
	            <td><i class="fa fa-plus" data="'.$row->id.'"></i>'.Form::hidden('choises['.$row->id.']',$row->id,array('class'=>'choise1')).'</td>
	        </tr>';
		}
		return $html.'<script>
	        $(document).ready(function(){
	            $(".fa-plus").click(function(){
	                var id=$(this).attr("data");
	                var qty=$(".phy_qty_"+id).val();
	                var reg = new RegExp("^[0-9]+$");
	                if(!reg.test(qty)){
	                    $(".phy_qty_"+id).focus();
	                    return false;
	                }
	                $.ajax({
		                type: "POST",
		                url: "'.URL::route("adjustStock.ajax_add.get").'",
		                dataType:"json",
		                data: {rid:'.$rpid.',id:id,qty:qty,switch:"'.$switch.'"}
		            }).done(function(data){
		                 if(data.status==1)
		                 {
		                    $("#tr_c_"+id).empty();
		                    alert(data.mes);
		                    return;
		                 }else
					{
						alert("'.Lang::get('adjuststock.remove_product_error').'");
						return;
					}
					});
	            });
	        });
	        </script>';
	}


	/**
	 * update line in file
	 * @return string
	 */
	public function postUpdatePhysical(){
		$switch=Input::get('switch');
		$rid=Input::has('rid')?Input::get('rid'):'';
		$id=Input::has('id')?Input::get('id'):'';
		$pty=Input::has('qty')?Input::get('qty'):'';
		$file_name=$rid.'_'.Auth::user()->client_id.'_'.Auth::user()->id.'_'.md5($rid);
		if($switch=='adjust')
			$path=public_path().'/csv/adjuststock/adjust/data/'.$file_name;
		else
			$path=public_path().'/csv/adjuststock/physical/data/'.$file_name;
		if(is_file($path)){
			//tim san pham trong list
			$r=Product::where('id','=',$id)->where('client_id','=',Auth::user()->client_id)->get();
			if(empty($r[0]))
				return json_encode(array('status'=>0));
			$data=array();
			$new=0;
			$old_raw=file_get_contents($path);
			$old_rs=json_decode($old_raw);
			foreach($old_rs as $k=>$v){
				if(isset($v[0]) && $v[0]==$id){
					$v[6]=$pty;
					$new=1;
				}
				$data[]=$v;
			}
			if($new==0)
				$data[]=[$r[0]->id,$r[0]->name,$r[0]->status,$r[0]->sku,'',$r[0]->price,$pty];
			if(!empty($data)){
				$put_data=json_encode($data);
				file_put_contents($path,$put_data);
			}
			return json_encode(array('status'=>1,'mes'=>Lang::get('adjuststock.update_product_succes')));
		}
	}

	/**
	 * remove line in file
	 * @return string
	 */
	public function postAjaxRemove(){
		$switch=Input::get('switch');
		$rid=Input::has('rid')?Input::get('rid'):'';
		$id=Input::has('id')?Input::get('id'):'';
		$file_name=$rid.'_'.Auth::user()->client_id.'_'.Auth::user()->id.'_'.md5($rid);
		if($switch=='adjust')
			$path=public_path().'/csv/adjuststock/adjust/data/'.$file_name;
		else
			$path=public_path().'/csv/adjuststock/physical/data/'.$file_name;
		if(is_file($path)){
			$data=array();
			$old_raw=file_get_contents($path);
			$old_rs=json_decode($old_raw);
			foreach($old_rs as $k=>$v){
				if(isset($v[0]) && $v[0]==$id)
					continue;
				$data[]=$v;
			}
			if(!empty($data)){
				$put_data=json_encode($data);
				file_put_contents($path,$put_data);
			}
			return json_encode(array('status'=>1,'mes'=>Lang::get('adjuststock.remove_product_succes')));
		}
	}

	/**
	 * them line in file
	 * @return string
	 */
	public function postAjaxAdd(){
		$switch=Input::get('switch');
		$rid=Input::has('rid')?Input::get('rid'):'';
		$id=Input::has('id')?Input::get('id'):'';
		$pty=Input::has('qty')?Input::get('qty'):'';
		$file_name=$rid.'_'.Auth::user()->client_id.'_'.Auth::user()->id.'_'.md5($rid);
		if($switch=='adjust')
			$path=public_path().'/csv/adjuststock/adjust/data/'.$file_name;
		else
			$path=public_path().'/csv/adjuststock/physical/data/'.$file_name;
		if(!is_file($path)){
			touch($path);
			if($switch=='physical')
				$re = ReportPhysicalStocktaking::find($rid);
			else
				$re=ReportAdjustStock::find($rid);
			if(isset($re->client_id) && $re->client_id==Auth::user()->client_id){
				$re->csv_file_name=$file_name;
				$re->update();
			}
		}
		if(is_file($path)){
			//tim san pham trong list
			$r=Product::where('id','=',$id)->where('client_id','=',Auth::user()->client_id)->get();
			if(empty($r[0]))
				return json_encode(array('status'=>0));
			$data=array();
			$old_raw=file_get_contents($path);
			if($old_raw!=''){
				$old_rs=json_decode($old_raw);
				foreach($old_rs as $k=>$v){
					if(empty($v))
						continue;
					$data[]=$v;
				}
			}
			if(empty($data))
				$data[]=['id','name','status','sku','img','price','physicaltaking'];
			$data[]=[$r[0]->id,$r[0]->name,$r[0]->status,$r[0]->sku,'',$r[0]->price,$pty];
			if(!empty($data)){
				$put_data=json_encode($data);
				file_put_contents($path,$put_data);
			}
			return json_encode(array('status'=>1,'mes'=>Lang::get('adjuststock.add_product_succes')));
		}
	}

	/**
	 * get list id product in file tamplate
	 * @param $file
	 * @return array
	 */
	public function getArrayIdFromFile($file){
		$data=array();
		if(!is_file($file))
			return $data;
		$raw=file_get_contents($file);
		$rs=json_decode($raw);
		if(!empty($rs));
			foreach($rs as $k=>$v)
				$data[]=$v[0];
		return $data;
	}
}