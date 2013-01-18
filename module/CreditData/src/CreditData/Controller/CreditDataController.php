<?php
namespace CreditData\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;

use User\Model\User;

class CreditDataController extends AbstractActionController
{
	protected $creditDataTable;
	protected $userTable;
	protected $callsTable;
	protected $sipServerTable;
	
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
	
	public function getSipServerTable()
	{
		if (!$this->sipServerTable)
		{
			$sm						= $this->getServiceLocator();
			$this->sipServerTable	= $sm->get('SipServer\Model\SipServerTable');
		}
	
		return $this->sipServerTable;
	}
	
	public function getUserTable()
	{
		if (!$this->userTable)
		{
			$sm					= $this->getServiceLocator();
			$this->userTable	= $sm->get('User\Model\UserTable');
		}
	
		return $this->userTable;
	}
	
	public function getCreditDataTable()
	{
		if (!$this->creditDataTable)
		{
			$sm					= $this->getServiceLocator();
			$this->creditDataTable	= $sm->get('CreditData\Model\CreditDataTable');
		}
		
		return $this->creditDataTable;
	}
	
	public function indexAction()
	{
		return $this->redirect()->toRoute('creditdata', array('action' => 'showall'));
	}
	
	public function showAllAction()
	{		
		if (!$this->zfcUserAuthentication()->hasIdentity())
			return $this->redirect()->toRoute('user', array('action' => 'login'));
		
		if (!$this->authenticatedUser()->isReady())
		{
			$this->authenticatedUser()->loadFromDatabase($this->getUserTable(),
														 $this->zfcUserAuthentication()->getIdentity()->getId());
		}				
		
		//die("show all");
		
		return array('credit_data' => $this->getCreditDataTable()->fetchAll());		
	}
	
	public function allAction()
	{
		if (!$this->zfcUserAuthentication()->hasIdentity())
			return $this->redirect()->toRoute('user', array('action' => 'login'));
	
		if (!$this->authenticatedUser()->isReady())
		{
			$this->authenticatedUser()->loadFromDatabase($this->getUserTable(),
					$this->zfcUserAuthentication()->getIdentity()->getId());
		}
	
//		return array('calls' => $this->getCallsTable()->fetchAll());
	}
	
	public function killallAction()
	{	
		if (!$this->zfcUserAuthentication()->hasIdentity())
			return $this->redirect()->toRoute('user', array('action' => 'login'));
		
		return array('id' => $this->getEvent()->getRouteMatch()->getParam('id'));
	}
	
	public function showCallsAction()
	{
		$client_id	= $this->getEvent()->getRouteMatch()->getParam('id');
		
		if (!$this->zfcUserAuthentication()->hasIdentity())
			return $this->redirect()->toRoute('user', array('action' => 'login'));
		
//		return $this->redirect()->toRoute('calls', array('action' => 'byclient'));			
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
		
		$creditDataList	= $this->getCreditDataTable()->getForGrid($from, 
																$to, 
																$search, 
																$sortingCol, 
																$sortingDir);	
		
		$data		= array();			
		
		foreach($creditDataList as $creditData)
		{
			$operations	= $this->generateOperationLink($creditData['client_id']);
			$links		= '';
			
			if ($this->authenticatedUser()->isAdmin() || $this->authenticatedUser()->isPrivilegedUser())
				$links	= "<a href=\"$operations[0]\"><i class=\"icon-remove\"></i> <span class=\"label label-important\">Force Drop</span></a>";
				
			$creditData['client_id']	= "<a href=\"$operations[1]\">{$creditData['client_id']}</a>";
			$creditData['credit_type']  = "<span class=\"label label-warning\">{$creditData['credit_type']}</span>";
						
			$creditData['max_amount']	= number_format($creditData['max_amount'], 3);
			$creditData['consumed_amount']	= number_format($creditData['consumed_amount'], 3);			
			
			array_push($data, array($creditData['client_id'], $creditData['credit_type'], 
									$creditData['number_of_calls'], $creditData['concurrent_calls'],
									$creditData['max_amount'], $creditData['consumed_amount'], $links));
		}	
		
		$nor	= $this->getCreditDataTable()->getNumberOfRows();
		
		$output = array(
				"sEcho" => $this->params()->fromQuery('sEcho'),
				"iTotalRecords" => $nor,
				"iTotalDisplayRecords" => $nor,
				"aaData" => $data
		);
				
		return $this->getResponse()->setContent(Json::encode($output));
	}
	
	protected function generateOperationLink($clientID)
	{
		$uri 	= $this->getRequest()->getUri();
    	$scheme = $uri->getScheme();
    	$host 	= $uri->getHost();
    	
    	$actions	= array('dokillall', 'byclient');
    	$urls		= array();
    	
    	foreach ($actions as $action)
    	{
    		$format	= $action == 'byclient' ? '%s://%s/calls/%s/%s' : '%s://%s/creditdata/%s/%s';
    		array_push($urls, sprintf($format, $scheme, $host, $action, urlencode($clientID)));
    	}
    	
    	return $urls;
	}
	
	public function doKillAllAction()
	{
		$client_id	= $this->getEvent()->getRouteMatch()->getParam('id');
		
		$sipServer = $this->getSipServerTable()->getDefaultSipServer();
		
		if ($sipServer == null)
			throw new \Exception("No default SIP server found");
		
		$calls	= $this->getCallsTable()->getCallsByClientID($client_id);
		
		foreach($calls as $call)
		{
			$client = new \Zend\XmlRpc\Client("http://{$sipServer->host}:{$sipServer->port}/");		
			$result = $client->call('cnxcc.kill_call', array($call->call_id));
		}
		return $this->redirect()->toRoute('creditdata', array('action' => 'showall'));
	}
	
	
}
