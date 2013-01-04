<?php
return array('controllers' => array(
					'invokables' => array(
						'User\Controller\User' => 'User\Controller\UserController'
					),
			),
			'controller_plugins' => array(
					'invokables' => array(
							'authenticatedUser' => 'User\Controller\Plugin\AuthenticatedUser',
					)
			),
			'router' => array(
					'routes' => array(
							'user' => array(
									'type' => 'segment',
									'options' => array(
											'route' => '/user[/:action][/:id]',
											'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id' => '[0-9]+',
											),
											'defaults' => array(
												'controller' => 'User\Controller\User',
												'action' => 'list',
											),
									),
							),
					),
			),
				
			'view_manager' => array(
					/*'template_map' => array(
							'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
					),*/
					'template_path_stack' => array(
							'user' => __DIR__ . '/../view',
					),
			),
			'service_manager' => array(
				'factories' => array(
						'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
//						'recording_navigation' => 'User\Navigation\Service\UserNavigationFactory',
//						'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
				),
		),
		 );
