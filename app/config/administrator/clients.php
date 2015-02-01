<?php
/**
 * Created by PhpStorm.
 * User: Hieu
 * Date: 24/10/2014
 * Time: 10:16 SA
 */
return array(
	'title' => 'Clients',

	'single' => 'Clients',

	'model' => 'Client',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'owner_user_id',
		'package_id',
		'company_name',
		'website_url',
		'warehouse_count',
		'product_count',
		'created_at',
		'updated_at',
		'deleted_at',
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'id',
		'owner_user_id',
		'package' => array(
			'type' => 'relationship',
			'name_field' => 'description',
		),
		'company_name',
		'website_url'
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'name' => array(
			'title' => 'Owner User Id',
			'type' => 'number'
		),
		'package' => array(
			'title' => 'Package',
			'type' => 'relationship',
			'name_field' => 'description',
		),

		'company_name' => array(
			'title' => 'Company Name',
			'type' => 'text',
		),

		'website_url' => array(
			'title' => 'Website Url',
			'type' => 'text',
		),
		'warehouse_count' => array(
			'title' => 'Warehouse Count',
			'type' => 'number',
			'value' => 0
		),
		'user_count' => array(
			'title' => 'User Count',
			'type' => 'number',
			'value' => 0
		),
		'product_count' => array(
			'title' => 'Product Count',
			'type' => 'number',
			'value' => 0
		),
	)

);