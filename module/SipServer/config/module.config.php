<?php
return array('controllers' => array(
					'invokables' => array(
						'SipServer\Controller\SipServer' => 'SipServer\Controller\SipServerController'
					),
			),
		
			'router' => array(
					'routes' => array(
							'sipsvr' => array(
									'type' => 'segment',
									'options' => array(
											'route' => '/sipsvr[/:action][/:id]',
											'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z]*',
												'id' => '.+',
											),
											'defaults' => array(
												'controller' => 'SipServer\Controller\SipServer',
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
							'sipsvr' => __DIR__ . '/../view',
					),
			),
		
			'service_manager' => array(
				'factories' => array(
						'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
//						'recording_navigation' => 'SipServer\Navigation\Service\SipServerNavigationFactory',
//						'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
				),
		),
		 );
