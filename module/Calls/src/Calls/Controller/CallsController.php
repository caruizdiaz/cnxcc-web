<?php
namespace Calls\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;

class CallsController extends AbstractActionController
{
	protected $callsTable;
	protected $userTable;
	
	public function getUserTable()
	{
		if (!$this->userTable)
		{
			$sm					= $this->getServiceLocator();
			$this->userTable	= $sm->get('User\Model\UserTable');
		}
	
		return $this->userTable;
	}
	
	public function getCallsTable()
	{
		if (!$this->callsTable)	
		{
			$sm						= $this->getServiceLocator();
//			print_r($sm);
			$this->callsTable	= $sm->get('Calls\Model\CallsTable');
			 
		}
		
		return $this->callsTable;
	}
	
	protected function checkPermissions()
	{
		if (!$this->authenticatedUser()->isReady())
		{
			$this->authenticatedUser()->loadFromDatabase($this->getUserTable(),
					$this->zfcUserAuthentication()->getIdentity()->getId());
		}
	
		if (!$this->authenticatedUser()->isAdmin())
			return $this->redirect()->toRoute('user', array('action' => 'login'));
	
	}
	
	public function indexAction()
	{
		return $this->redirect()->toRoute('calls', array('action' => 'showall'));
	}
	
	public function showAllAction()
	{
		if (!$this->zfcUserAuthentication()->hasIdentity())
			return $this->redirect()->toRoute('user', array('action' => 'login'));
		
		$this->checkPermissions();
		
		return array('calls' => $this->getCallsTable()->fetchAll());
	}
	
	public function byClientAction()
	{
		if (!$this->zfcUserAuthentication()->hasIdentity())
			return $this->redirect()->toRoute('user', array('action' => 'login'));
		
		$this->checkPermissions();
		
		$id = $this->params()->fromRoute('id', 0);
		
//		if (!$id)
//			return $this->redirect()->toRoute('calls', array('action' => 'showall'));
		
		return array('client_id' => $id);
		
	}
	
	public function gridAction()
	{
		if (!$this->authenticatedUser()->isReady())
		{
			$this->authenticatedUser()->loadFromDatabase($this->getUserTable(),
					$this->zfcUserAuthentication()->getIdentity()->getId());
		}
	
		$from		= $this->params()->fromQuery('iDisplayStart');
		$to			= $this->params()->fromQuery('iDisplayLength');
		$search		= $this->params()->fromQuery('sSearch');
		$sortingCol	= intval($this->params()->fromQuery('iSortCol_0'));
		$sortingDir	= $this->params()->fromQuery('sSortDir_0');
	
		$calls		= $this->getCallsTable()->getForGrid($from,
														$to,
														$search,
														$sortingCol,
														$sortingDir);
	
		$data		= array();
	
		foreach($calls as $call)
		{
			$operations	= $this->generateOperationLink($call['call_id']);
			$links		= '';
				
			if ($this->authenticatedUser()->isAdmin() || $this->authenticatedUser()->isPrivilegedUser())
				$links		= "<a href=\"$operations[0]\"><i class=\"icon-remove\"></i></a>";

			$call['confirmed']	= $call['confirmed'] == 'y' ? '<span class="label label-success">yes</span>' : 
															  '<span class="label label-important">no</span>';
			
			array_push($data, array($call['call_id'], $call['confirmed'],
									$call['max_amount'], $call['consumed_amount'],
									$call['start_timestamp'], $call['client_id'], $links));
		}
	
		$nor	= $this->getCallsTable()->getNumberOfRows();
	
		$output = array(
				"sEcho" => $this->params()->fromQuery('sEcho'),
				"iTotalRecords" => $nor,
				"iTotalDisplayRecords" => $nor,
				"aaData" => $data
		);
	
		return $this->getResponse()->setContent(Json::encode($output));
	}
	
	protected function generateOperationLink($creditDataID)
	{
		$uri 	= $this->getRequest()->getUri();
		$scheme = $uri->getScheme();
		$host 	= $uri->getHost();
		 
		$actions	= array('killall', 'showcalls');
		$urls		= array();
		 
		foreach ($actions as $action)
			array_push($urls, sprintf('%s://%s/creditdata/%s/%s', $scheme, $host, $action, $creditDataID));
		 
		return $urls;
	}
}
