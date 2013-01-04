<?php
return array('controllers' => array(
					'invokables' => array(
						'CreditData\Controller\CreditData' => 'CreditData\Controller\CreditDataController'
					),
			),
		
			'router' => array(
					'routes' => array(
							'creditdata' => array(
									'type' => 'segment',
									'options' => array(
											'route' => '/creditdata[/:action][/:id]',
											'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id' => '[0-9]+',
											),
											'defaults' => array(
												'controller' => 'CreditData\Controller\CreditData',
												'action' => 'index',
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
							'creditdata' => __DIR__ . '/../view',
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
