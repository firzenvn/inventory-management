<?php

/**
 * Actors model config
 */

return array(

	'title' => 'Quyền',

	'single' => 'quyền',

	'model' => 'Permission',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'client' => array(
			'title' => 'Client',
			'relationship' => "client",
			'select' => "company_name",
		),
		'role' => array(
			'title' => 'Vai trò',
			'relationship' => "role",
			'select' => "role_name",
		),
		'type' => array(
			'title' => 'Quyền',
			'select' => "type",
		),
		'action' => array(
			'title' => 'Hành động',
			'select' => "action",
		),
		'resource' => array(
			'title' => 'Hành động',
			'select' => "resource",
		),
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'role' => array(
			'title' => 'Vai trò',
			'type' => 'relationship',
			'name_field'=> "role_name"
		),
		'client' => array(
			'title' => 'Client',
			'type' => 'relationship',
			'name_field'=> "company_name"
		),
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'role' => array(
			'title' => 'Vai trò',
			'type' => 'relationship',
			'name_field'=> "role_name"
		),
		'type' => array(
			'title' => 'Quyền',
			'type' => 'enum',
			'options' => array('allow','deny'),
			'value'=>'allow',
		),
		'action' => array(
			'title' => 'Hành động',
			'type' => 'enum',
			'options' => array('list','view','create','update','delete'),
			'value'=>'list',
		),
		'resource' => array(
			'title' => 'Resource',
			'type' => 'text',
		),
	),
);