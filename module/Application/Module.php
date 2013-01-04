<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
    	$moduleConfig   = include __DIR__ . '/config/module.config.php';
    	$navConfig      = include __DIR__ . '/config/nav.config.php';
    	$config         = array_merge($moduleConfig, $navConfig);
    	return $config;
        //return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
        	'Zend\Loader\ClassMapAutoloader' => array(
							__DIR__ . '/autoload_classmap.php',
							),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function init(\Zend\ModuleManager\ModuleManager $moduleManager) 
    {
    	$sharedEvents   = $moduleManager->getEventManager()->getSharedManager();
    	$sharedEvents->attach(__NAMESPACE__, 'dispatch', array($this, 'onModuleDispatch'));
    }
    
    public function onModuleDispatch(\Zend\Mvc\MvcEvent $e) 
    {
		$controller         = $e->getTarget();	
    	$controller->layout('layout/layout.phtml');

    	//Set the main menu into the layout view model
    	$serviceManager     	= $e->getApplication()->getServiceManager();
    	$adminNavbarContainer   = $serviceManager->get('admin_navigation');
    	$othersNavbarContainer 	= $serviceManager->get('others_navigation');
//    	$authenticatedUser		= $serviceManager->get('authenticated_user');
    
    	$viewModel          = $e->getViewModel();
    	
    	$viewModel->setVariable('admin_navbar', $adminNavbarContainer);
    	$viewModel->setVariable('others_navbar', $othersNavbarContainer);
//    	$viewModel->setVariable('isAdmin', true);
    	
    }    
}
