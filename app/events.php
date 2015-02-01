<?php
/**
 * Define events listener here
 */

Event::listen('users.register', function($user,$customer_code)
{
	$data = array(
		'customer_code' => $customer_code,
		'username' => $user->username,
		'customer_name' => $user->first_name . $user->last_name,
	);
	Mail::send('emails.user.register_success', $data, function($message) use ($user){
		$message->to($user->email, $user->first_name . $user->last_name)->subject('Inventory Registered Success');
	});
});

Event::listen('customer.create', function($email,$customername,$password)
{
	$data = array(
		'customer_name' => $customername,
		'password'=>$password
	);
	Mail::send('emails.customer.sent_password_customer', $data, function($message) use ($customername,$email){
		$message->to($email, $customername)->subject('Inventory Registered Success');
	});
});

Event::listen('adjustFromPhysical.create',function($physical_id,$status='Pending'){
	$physical=ReportPhysicalStocktaking::find($physical_id);
	$input=array(
		'client_id'=>$physical->client_id,
		'warehouse_id'=>$physical->warehouse_id,
		'user_id'=>$physical->user_id,
		'reasons'=>isset($physical->reasons)?$physical->reasons:'',
		'status'=>$status
	);
	$adjust=new ReportAdjustStock($input);
	$adjust->save();
	//get content physical
	$filename=public_path().'/csv/adjuststock/physical/data/'.$physical->csv_file_name;
	$raw_data=file_get_contents($filename);
	//make file adjust
	$link_file_csv=public_path().'/csv/adjuststock/adjust/data/';
	$adjust_name=$adjust->id.'_'.Auth::user()->client_id.'_'.Auth::user()->id.'_'.md5($adjust->id);
	$adjust->csv_file_name=$adjust_name;
	$adjust->update();
	touch($link_file_csv.$adjust_name);
	//put data to file adjust
	file_put_contents($link_file_csv.$adjust_name,$raw_data);

});

Event::listen('adjustFromPhysical.create_success',function($physical_id,$status='Pending'){
	$physical=ReportPhysicalStocktaking::find($physical_id);
	$input=array(
		'client_id'=>$physical->client_id,
		'warehouse_id'=>$physical->warehouse_id,
		'user_id'=>$physical->user_id,
		'reasons'=>isset($physical->reasons)?$physical->reasons:'',
		'status'=>$status
	);
	$adjust=new ReportAdjustStock($input);
	$adjust->save();
	//get content physical
	$filename=public_path().'/csv/adjuststock/physical/data/'.$physical->csv_file_name;
	$raw_data=file_get_contents($filename);
	//make file adjust
	$link_file_csv=public_path().'/csv/adjuststock/adjust/data/';
	$adjust_name=$adjust->id.'_'.Auth::user()->client_id.'_'.Auth::user()->id.'_'.md5($adjust->id);
	$adjust->csv_file_name=$adjust_name;
	$adjust->status='Completed';
	$adjust->update();
	touch($link_file_csv.$adjust_name);
	//put data to file adjust
	file_put_contents($link_file_csv.$adjust_name,$raw_data);
	//update from product
});