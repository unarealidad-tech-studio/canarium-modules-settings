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
						'label' => 'Users',
						'route' => 'admin/settings-user',
						'resource' => 'admin',
						'controller' => 'Admin\Settings\User',
						'icon' => 'fa fa-cog',
					),
				),
             ),
         ),
     ),
);