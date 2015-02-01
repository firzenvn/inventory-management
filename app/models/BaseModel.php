<?php
/**
 * Created by PhpStorm.
 * User: Bachviet
 * Date: 10/13/2014
 * Time: 9:15 AM
 */
class BaseModel extends Eloquent{
	public $errors;

	public static function boot(){
		parent::boot();
	}

	function validate(){
		$validator=Validator::make($this->attributes,static::$rules);
		if($validator->passes())
			return true;
		throw new ModelValidationFailException($validator,'',400);
	}

	/**
	 * render ra link sap sep theo cot
	 *
	 * @param $sort
	 * @param $action
	 * @return string
	 */
	public static function renderHtmlSort($sort,$action){
		$params = array('sort' => $sort,
			'order' => 'asc');
		$params_desc = array('sort' => $sort,
			'order' => 'desc');
		$queryString = http_build_query($params);
		$queryString_desc = http_build_query($params_desc);
		$base_uri='';
		if(isset($_GET)){
			$data=array();
			foreach($_GET as $k=>$v){
				if(strtolower($k)=='sort' || strtolower($k)=='order')
					continue;
				$data[]=$k.'='.$v;
			}
			$base_uri=implode('&',$data);
		}

		$url_asc= URL::to(action($action) . '?'.$base_uri.'&' . $queryString);
		$url_desc= URL::to(action($action) . '?'.$base_uri.'&' . $queryString_desc);

		if(Input::get('sort') && Input::get('order')){
			if($sort===Input::get('sort'))
			{
				$str=Input::get('order')==='desc'?'<a href="'.$url_asc.'">
		        <i class="fa fa-caret-up" title="Asc"></i>
			    </a>'
					: '<a href="'.$url_desc.'">
		        <i class="fa fa-caret-down" title="Desc"></i>
		        </a>';
				echo $str;
				return true;
			}
		}
		$str='<a href="'.$url_asc.'">
		        <i class="fa fa-caret-up" title="Asc"></i>
			    </a>
	    <a href="'.$url_desc.'">
	        <i class="fa fa-caret-down" title="Desc"></i>
	    </a>';
		echo $str;
		return true;
	}
}