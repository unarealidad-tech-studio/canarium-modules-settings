<?php
return array(
	/*'doctrine' => array(
	  'driver' => array(
		'settings_entities' => array(
		  'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
		  'cache' => 'array',
		  'paths' => array(__DIR__ . '/../src/Settings/Entity')
		),

		'orm_default' => array(
		  'drivers' => array(
			'Settings\Entity' => 'settings_entities'
		  )
		)
	)
	),
*/
    'controllers' => array(
        'invokables' => array(
			'Admin\Settings' => 'Settings\Controller\AdminController',
			'Admin\Settings\User' => 'Settings\Controller\UserController',
        ),
    ),

	'bjyauthorize' => array(
		'guards' => array(
			'BjyAuthorize\Guard\Controller' => array(
                array('controller' => 'Admin\Settings', 'roles' => array('admin')),
				array('controller' => 'Admin\Settings\User', 'roles' => array('admin')),
            ),
		),
	),

	'router' => array(
        'routes' => array(
			'admin' => array(
                'child_routes' => array(
					'settings' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/settings[/:action[/:id]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id'     => '[0-9]*',
                            ),
                            'defaults' => array(
								'controller'    => 'Admin\Settings',
								'action'        => 'index',
                            ),
                        ),
                    ),
                    'settings-user' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/settings/user[/:action[/:id]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id'     => '[0-9]*',
                            ),
                            'defaults' => array(
								'controller'    => 'Admin\Settings\User',
								'action'        => 'index',
                            ),
                        ),
                    ),

				),
			),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'settings' => __DIR__ . '/../view',
        ),
		'template_map' => array(

        ),
    ),
);