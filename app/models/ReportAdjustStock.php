<?php
/**
 * Created by PhpStorm.
 * User: Hoangtv
 * Date: 12/19/2014
 * Time: 8:16 PM
 */
class ReportAdjustStock extends Eloquent{
	public $error;
	protected $fillable = ['client_id','user_id','warehouse_id','created_on','values','status','reasons'];
	protected $table = 'report_adjust_stock';

	public function user(){
		return $this->belongsTo('User','user_id','id');
	}

	public function warehouse(){
		return $this->belongsTo('Warehouse','warehouse_id','id');
	}

	public function client(){
		return $this->belongsTo('Client','client_id','id');
	}
}