<?php
/**
 * Created by PhpStorm.
 * User: Hieu
 * Date: 23/10/2014
 * Time: 9:52 SA
 */
return array(

	'title' => 'Packages',

	'single' => 'Packages',

	'model' => 'Package',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'name',
		'description',
		'unit_price',
		'limit_warehouses',
		'limit_products',
		'limit_users',
		'created_at',
		'updated_at',
		'deleted_at'
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'id',
		'name',
		'unit_price',
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'name' => array(
			'title' => 'Name',
			'type' => 'text'
		),
		'description' => array(
			'title' => 'Description',
			'type' => 'text',
		),
		'unit_price' => array(
			'title' => 'Unit Price',
			'type' => 'number',
//			'symbol' => '$',
			'decimals' => 2,
			'thousands_separator' => ',',
			'decimal_separator' => '.'
		),
		'limit_warehouses' => array(
			'title' => 'Limit Warehouses',
			'type' => 'number',
		),
		'limit_products' => array(
			'title' => 'Limit Products',
			'type' => 'number',
		),
		'limit_users' => array(
			'title' => 'Limit Users',
			'type' => 'number',
		),
	)
);