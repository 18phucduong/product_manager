<?php
return [
	'upload_dir' => dirname(dirname(dirname(__FILE__))).'/public/assets/images/',
	'base_path' => '/product_manager/public',
	'app_root_dir' => dirname(dirname(__FILE__)),
	'public_root_dir' => dirname(dirname(dirname(__FILE__))).'/public',
	'root_dir' =>  dirname(dirname(dirname(__FILE__))),
	'db_configs'      => [
		'host_name' => 'localhost',
		'username' => 'root',
		'password' => '',
		'db_name' => 'manager_product'
	],
	'layout' => 'admin-master',
	// Sidebar configs
];
