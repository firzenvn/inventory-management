<?php
/**
 * Created by PhpStorm.
 * User: DONY
 * Date: 12/20/2014
 * Time: 9:01 AM
 */

class WarehouseProduct extends Eloquent {
	protected $table = 'warehouse_product';
	public function product(){
		return $this->belongsTo('Product','product_id','id');
	}
	public function warehouse(){
		return $this->belongsTo('Warehouse','warehouse_id','id');
	}
}