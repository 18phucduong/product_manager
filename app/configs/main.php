<?php
return [
	'base_path' => '/product_manager/public',
	'app_root_dir' => dirname(dirname(__FILE__)),
	'public_root_dir' => dirname(dirname(dirname(__FILE__))).'/public',
	'db_configs'      => [
		'host_name' => 'localhost',
		'username' => 'root',
		'password' => '',
		'db_name' => 'manager_product'
	],
	'layout' => 'admin-master',
	'main_sidebar_menu' => [
		[
			'icon' => null,
			'text' => 'Navigation',
			'link' => null
		],
		[
			'icon' => 'th-large',
			'text' => 'Dashboarth',
			'link' => '#'
		],
		[
			'icon' => 'university',
			'text' => 'Bank',
			'link' => '#'
		],
		[
			'icon' => 'bars',
			'text' => 'report',
			'link' =>  '#'
		],
		[
			'icon' => 'cogs',
			'text' => 'Setting',
			'link' => '#'
		]
	]
];
