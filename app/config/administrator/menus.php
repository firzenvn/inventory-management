<?php
/**
 * Created by PhpStorm.
 * User: dongnv
 * Date: 10/17/2014
 * Time: 5:09 PM
 */

return array(

	'title' => 'Menu',

	'single' => 'menu',

	'model' => 'Menu',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'menu_parent' => array(
			'title' => 'Menu cha',
			'relationship' => 'menu_parent',
			'select' => "(:table).name",
		),
		'name' => array(
			'title' => 'Tiêu đề',
			'select' => "name",
		),
		'url' => array(
			'title' => 'Đường dẫn',
			'select' => "url",
		),
		'icon' => array(
			'title' => 'Menu Icon',
			'select' => "icon",
		),
		'sort' => array(
			'title' => 'Thứ tự sắp xếp',
			'select' => "sort",
		),
		'status' => array(
			'title' => 'Trạng thái',
			'select' => "IF((:table).status, 'Hiển thị', 'Không hiển thị')",
		),
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'id',
		'parent_id' => array(
			'title'=>'Menu cha',
		),
		'name' => array(
			'title'=>'Tiêu đề',
		),
		'url' => array(
			'title'=>'Đường dẫn',
		),
		'sort' => array(
			'title'=>'Thứ tự sắp xếp',
		),
		'icon' => array(
			'title'=>'Menu Icon',
		),
		'status' => array(
			'type'=>'bool',
			'title'=>'Hiển thị',
		),
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'id',
		'menu_parent' => array(
			'title' => 'Menu cha',
			'type' => "relationship",
			'name_field'=> "name"
		),
		'name',
		'url',
		'sort',
		'icon',
		'status'=>array(
			'type'=>'bool',
			'title' => 'Hiển thị',
		),
	),

);