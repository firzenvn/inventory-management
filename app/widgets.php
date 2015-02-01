<?php
/**
 * Define widgets here
 */

Widget::register('menu', function()
{
	//TODO:load menu tu db hoac cache
	/*if(Cache::has('menus')){
		return View::make('widgets.menu')->with(array(
			'menus'=>Cache::get('menus')
		));
	}*/

	$menus = Menu::where('status','=',1)->orderBy('sort', 'asc')->get();
	Cache::put('menus',$menus,60);

	return View::make('widgets.menu')->with(array(
		'menus'=>$menus
	));
});

Widget::register('proccess_csv',function($path,$list_column){
	return View::make('widgets.proccess_csv');
});

Widget::register('products_added_daily', function($startDate=null,$endDate=null,$chartType='AreaChart')
{
	$query = new Product();
	$query = $query->where('client_id','=', App::make('client')->id);
	$startDate=$startDate?$startDate:DateHelper::getDateXDaysAgo(7);
	$endDate=$endDate?$endDate:DateHelper::getCurrentDate();
	$query=$query->whereBetween('created_at',array($startDate,$endDate));

	$chart=null;

	$query=$query->groupBy(DB::raw('date(`created_at`)'))
		->select(DB::raw('date(`created_at`) as row_date, sum(quantity) as row_count, sum(quantity*price) as row_value'))
		->orderBy('created_at', 'asc');

	return AppHelper::drawChart($query,'',$startDate,$endDate,$chartType,600,400);
});
