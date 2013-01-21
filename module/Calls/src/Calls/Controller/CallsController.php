<?php
namespace Calls\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;

class CallsController extends AbstractActionController
{
	protected $callsTable;
	protected $userTable;
	protected $sipServerTable;
	
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
			$sm					= $this->getServiceLocator();
			$this->callsTable	= $sm->get('Calls\Model\CallsTable');
		}
		
		return $this->callsTable;
	}
	
	public function getSipServerTable()
	{
		if (!$this->sipServerTable)
		{
			$sm						= $this->getServiceLocator();
			$this->sipServerTable	= $sm->get('SipServer\Model\SipServerTable');
		}
	
		return $this->sipServerTable;
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
	
	public function killAction()
	{
		if (!$this->zfcUserAuthentication()->hasIdentity())
			return $this->redirect()->toRoute('user', array('action' => 'login'));
		
		$this->checkPermissions();	
		
		$callID = $this->params()->fromRoute('id', 0);
		
		return array('id' => $callID);
	}
	
	public function dokillAction()
	{
		$callID = $this->params()->fromRoute('id', 0);
				
		$sipServer = $this->getSipServerTable()->getDefaultSipServer();
	
		if ($sipServer == null)
			throw new \Exception("No default SIP server found");
	
		$client = new \Zend\XmlRpc\Client("http://{$sipServer->host}:{$sipServer->port}/");
	
		$result = $client->call('cnxcc.kill_call', array($callID));
		
		return $this->redirect()->toRoute('calls', array('action' => 'showall'));
	}
	
	public function byClientAction()
	{
		if (!$this->zfcUserAuthentication()->hasIdentity())
			return $this->redirect()->toRoute('user', array('action' => 'login'));
		
		$this->checkPermissions();
		
		$id = $this->params()->fromRoute('id', 0);
		
		return array('client_id' => $id);
	}
	
	public function callInfoAction()
	{
		if (!$this->authenticatedUser()->isReady())
		{
			$this->authenticatedUser()->loadFromDatabase($this->getUserTable(),
												         $this->zfcUserAuthentication()->getIdentity()->getId());
			
		}
		
		$this->checkPermissions();
							
		$callID 	= $this->params()->fromQuery('cid');
		$callInfo	= $this->getCallsTable()->getCallInfo($callID);
				
		return $this->getResponse()->setContent(Json::encode($callInfo));
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
			{
				$links		= "<a href=\"$operations[0]\"><i class=\"icon-remove\"></i> <span class=\"label label-important\">Force Drop </span></a>";
				$links		.= "\n<br><a href=\"#\"><i class=\"icon-headphones\"></i> <span class=\"label label-warning\">Record Call</span></a>";
			}

			$call['confirmed']	= $call['confirmed'] == 'y' ? '<span class="label label-success">yes</span>' : 
															  '<span class="label label-important">no</span>';
					
			$call['call_id']	= '<a href="#" onclick="javascript: callInfo(\''.$call['call_id'].'\')">'.$call['call_id'].'</a>';
						
			$call['max_amount']		= number_format($call['max_amount'], 5);
			$call['consumed_amount']= number_format($call['consumed_amount'], 5);	
			
			array_push($data, array($call['call_id'], $call['confirmed'],
									$call['max_amount'], $call['consumed_amount'],
									$call['start_timestamp'], $call['time_elapsed'], $call['client_id'], $links));
		}
	
		$nor	= $this->getCallsTable()->getNumberOfRows();
	
		$output = array(
						"sEcho" => $this->params()->fromQuery('sEcho'),
						"iTotalRecords" => $nor,
						"iTotalDisplayRecords" => $nor,
						"aaData" => $data);	
	
		return $this->getResponse()->setContent(Json::encode($output));
	}
	
	protected function generateOperationLink($creditDataID)
	{
		$uri 	= $this->getRequest()->getUri();
		$scheme = $uri->getScheme();
		$host 	= $uri->getHost();
		 
		$actions	= array('kill');
		$urls		= array();
		 
		foreach ($actions as $action)
			array_push($urls, sprintf('%s://%s/calls/%s/%s', $scheme, $host, $action, $creditDataID));
		 
		return $urls;
	}
}
