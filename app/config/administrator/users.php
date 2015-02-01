<?php

/**
 * Actors model config
 */

return array(

	'title' => 'Users',

	'single' => 'user',

	'model' => 'User',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
        'username' => array(
            'title'=>'Username',
            'select'=>'username'
        ),
		'last_name' => array(
			'title' => 'Họ và tên đệm',
			'select' => "last_name",
		),
		'first_name' => array(
			'title' => 'Tên',
			'select' => "first_name",
		),
		'email' => array(
			'title' => 'Email',
			'select' => "email",
		),
		'roles' => array(
			'title' => 'Vai trò',
			'relationship' => 'roles',
			'select' => "group_concat(role_name)",
		),
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'id',
        'username'=>array(
            'title'=>'Username'
        ),
		'email' => array(
			'title' => 'Email',
		),
		'first_name' => array(
			'title' => 'Tên',
		),
		'created_at' => array(
			'title' => 'Thời gian đăng ký',
			'type' => 'date',
		),
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
        'username'=>array(
            'title'=>'Username',
            'type'=>'text'
        ),
		'first_name' => array(
			'title' => 'Tên',
			'type' => 'text',
		),
		'last_name' => array(
			'title' => 'Họ và tên đệm',
			'type' => 'text',
		),
		'email' => array(
			'title' => 'Email',
			'type' => 'text',
		),
		'roles' => array(
			'title' => 'Role',
			'type' => 'relationship',
			'relationship' => 'roles',
			'name_field' => 'role_name' // The column name which holds the name of the role
		),
	),

	/**
	 * This is where you can define the model's custom actions
	 */
	'actions' => array(
		//Ordering an item up
		'hash_password' => array(
			'title' => 'Mã hóa password',
			'messages' => array(
				'active' => 'Hashing password...',
				'success' => 'Mã hóa mật khẩu thành công',
				'error' => 'Mã hóa mật khẩu lỗi',
			),
			//the model is passed to the closure
			'action' => function(&$model)
			{
				$model->password=Hash::make($model->password);
				return $model->save();
			}
		),
	),
);