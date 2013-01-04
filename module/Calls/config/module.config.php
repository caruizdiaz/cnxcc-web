<?php
return array('controllers' => array(
					'invokables' => array(
						'Calls\Controller\Calls' => 'Calls\Controller\CallsController'
					),
			),
		
			'router' => array(
					'routes' => array(
							'calls' => array(
									'type' => 'segment',
									'options' => array(
											'route' => '/calls[/:action][/:id]',
											'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z]*',
												'id' => '.+',
											),
											'defaults' => array(
												'controller' => 'Calls\Controller\Calls',
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
							'calls' => __DIR__ . '/../view',
					),
			),
			'service_manager' => array(
				'factories' => array(
						'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
//						'recording_navigation' => 'Calls\Navigation\Service\CallsNavigationFactory',
//						'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
				),
		),
		 );
