<?php
/**
 * Created by PhpStorm.
 * User: DONY
 * Date: 10/9/2014
 * Time: 2:53 PM
 */

class Menu extends Eloquent {
	protected $table = 'menus';

	public function menu_parent(){
		return $this->belongsTo('Menu','parent_id');
	}
} 