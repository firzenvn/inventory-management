<?php

return array(
	'inventory_id_base_url' => 'http://id.inventory.dev',
	'paginate' => 4,
	'permission_actions'=>array(
		'list'=>'List',
		'view'=>'View',
		'create'=>'Create',
		'update'=>'Update',
		'delete'=>'Delete',
	),
	'order_status'=>array(
		'' => '--Select one--',
		1 => 'Canceled',
		2 => 'Pending',
		3 => 'Processing',
		4 => 'Complete'
	),

	'permission_types'=>array(
		'allow'=>'Allow',
		'deny'=>'Deny',
	)


);