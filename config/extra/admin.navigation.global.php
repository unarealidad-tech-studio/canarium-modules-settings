<?php
return array(
	'navigation' => array(
         'admin' => array(
			 array(
				'label' => 'Settings',
				'route' => 'admin/settings',
				'resource' => 'admin',
				'controller' => 'Admin\Settings',
				'icon' => 'fa fa-cog',
				'pages' => array(
					array(
						'label' => 'Widgets',
						'resource' => 'admin',
						'route' => 'admin/settings',
						'action' => 'widgets',
						'icon' => 'fa fa-list',
					),
				),
             ),
             array(
				'label' => 'Users',
				'route' => 'admin/settings-user',
				'resource' => 'admin',
				'controller' => 'Admin\Settings\User',
				'icon' => 'fa fa-cog',
				'pages' => array(
					array(
						'label' => 'List',
						'resource' => 'admin',
						'route' => 'admin/settings-user',
						'action' => 'index',
						'icon' => 'fa fa-list',
					),
					array(
						'label' => 'Create',
						'resource' => 'admin',
						'route' => 'admin/settings-user',
						'action' => 'create',
						'icon' => 'fa fa-plus-circle',
					),
					array(
						'label' => 'Settings',
						'resource' => 'superuser',
						'route' => 'admin/settings-user',
						'action' => 'settings',
						'icon' => 'fa fa-cog',
					),
				)
			),
         ),
     ),
);