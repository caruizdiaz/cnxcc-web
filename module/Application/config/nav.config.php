<?php
return array(
		'navigation' => array(
				'admin' => array(
						array(
								'label'         => 'Calls',
								'type'          => 'uri',
								'pages'         => array(
									array(
											'label'         => 'Show by client',
											'route'         => 'creditdata',
											'action'        => 'showall',
									),
									array(
											'label'         => 'Show all',
											'route'         => 'calls',
											'action'        => 'showall',
									),
								),
						),
						array (
								'label'         => 'Reports',
								'type'          => 'uri',
								'pages'         => array(
										array(
												'label'         => 'Report #1',
												'route'         => 'creditdata',
												'action'        => '132',
										),
										array(
												'label'         => 'Report #2',
												'route'         => 'creditdata',
												'action'        => '132',
										),
								),
						),
						array(
								'label'         => 'User',
								'type'          => 'uri',
								'pages'         => array(
										array(
												'label'         => 'Show all',
												'route'         => 'user',
												'action'        => 'display',
										),
										array(
												'label'         => 'Add New',
												'route'         => 'user',
												'action'        => 'add',
										),
								),
						),
				),
				'others' => array(
						array(
								'label'         => 'Calls',
								'type'          => 'uri',
								'pages'         => array(
									array(
											'label'         => 'Show by client',
											'route'         => 'creditdata',
											'action'        => 'showall',
									),
									array(
											'label'         => 'Show all',
											'route'         => 'calls',
											'action'        => 'showall',
									),
								),
						),
						array (
								'label'         => 'Reports',
								'type'          => 'uri',
								'pages'         => array(
										array(
												'label'         => 'Report #1',
												'route'         => 'creditdata',
												'action'        => '132',
										),
										array(
												'label'         => 'Report #2',
												'route'         => 'creditdata',
												'action'        => '132',
										),
								),
						),
				),
		  )
	);