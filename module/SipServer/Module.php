<?php
namespace SipServer;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

use SipServer\Model\SipServerTable; 

class Module
{
    public function getConfig()
    {
    	/*$moduleConfig   = include __DIR__ . '/config/module.config.php';
    	$navConfig      = include __DIR__ . '/../Application/config/nav.config.php';
    	$config         = array_merge($moduleConfig, $navConfig);
    	return $config;*/
		return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
		return array(
						/*'Zend\Loader\ClassMapAutoloader' => array(
							__DIR__ . '/autoload_classmap.php',
							),*/
						'Zend\Loader\StandardAutoloader' => array(
							'namespaces' => array(
								__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
							),
						)
		     		);
    }
    
    public function init(\Zend\ModuleManager\ModuleManager $moduleManager)
    {
    	$sharedEvents   = $moduleManager->getEventManager()->getSharedManager();
    	$sharedEvents->attach(__NAMESPACE__, 'dispatch', array($this, 'onModuleDispatch'));
    }
    
    public function onModuleDispatch(\Zend\Mvc\MvcEvent $e) 
    {
		//		Set the layout template for every action in this module
    	$controller         = $e->getTarget();
    	$controller->layout('layout/layout.phtml');

    	//Set the main menu into the layout view model
    	$serviceManager     	= $e->getApplication()->getServiceManager();
    	$adminNavbarContainer   = $serviceManager->get('admin_navigation');
    	$othersNavbarContainer 	= $serviceManager->get('others_navigation');
    
    	$viewModel          = $e->getViewModel();
    	
    	$viewModel->setVariable('admin_navbar', $adminNavbarContainer);
    	$viewModel->setVariable('others_navbar', $othersNavbarContainer);
    }
    
   
	public function getServiceConfig()
    {    	    	
    	return array(
    			'factories' => array(
    					'SipServer\Model\SipServerTable' => function($sm) {
  //  						die("trying this shit");
    						$dbAdapter 	= $sm->get('Zend\Db\Adapter\Adapter');
    						$table 		= new SipServerTable($dbAdapter);
    						return $table;
    					},
    			),
    		);
    }
    
}
