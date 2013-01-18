<?php
namespace SipServer\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;

use SipServer\Form\SipServerForm;
use SipServer\Form\SipServerFormInputFilter;
use SipServer\Model\SipServer;

class SipServerController extends AbstractActionController
{
	protected $sipServerTable;
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
		return $this->redirect()->toRoute('sipsvr', array('action' => 'showall'));
	}
	
	public function showAllAction()
	{
		if (!$this->zfcUserAuthentication()->hasIdentity())
			return $this->redirect()->toRoute('user', array('action' => 'login'));
		
		$this->checkPermissions();
		
		return array('servers' => $this->getSipServerTable()->fetchAll());
	}
	
	public function addAction()
	{
		if (!$this->zfcUserAuthentication()->hasIdentity())
			return $this->redirect()->toRoute('user', array('action' => 'login'));
	
		$this->checkPermissions();
	
		$form			= new SipServerForm();
		$form->setInputFilter(new SipServerFormInputFilter());
		
		$form->get('submit')->setValue('Add');
			
		$request	= $this->getRequest();
		
		if ($request->isPost())
		{
			$postData		= $request->getPost();
			$form->setData($postData);
			
			$sipServer			= new SipServer();
	
			if ($form->isValid())
			{
				$sipServer->exchangeArrayFromForm($request->getPost());
				$this->getSipServerTable()->saveSipServer($sipServer);
	
				return $this->redirect()->toRoute('sipsvr', array('action' => 'showall'));
			}
		}
	
		return array('form' => $form);
	}
	
	public function editAction()
	{
		if (!$this->zfcUserAuthentication()->hasIdentity())
			return $this->redirect()->toRoute('user', array('action' => 'login'));
	
		$this->checkPermissions();
	
		$id = (int) $this->params()->fromRoute('id', 0);
	
		if (!$id)
			return $this->redirect()->toRoute('sipsvr', array('action' => 'add'));
	
		$sipServer			= $this->getSipServerTable()->getSipServer($id);
	
		$form				= new SipServerForm();
	
		$form->setData($sipServer->getAsFieldsetArray());
		
		$form->get('submit')->setAttribute('value', 'Save');
	
		$request = $this->getRequest();
	
		if ($request->isPost())
		{
			$postData		= $request->getPost();
				
			$form->setData($request->getPost());				
				
			if ($form->isValid())
			{
				$sipServer->exchangeArrayFromForm($request->getPost());
				$this->getSipServerTable()->saveSipServer($sipServer);
	
				return $this->redirect()->toRoute('sipsvr', array('action' => 'showall'));
			}
		}
	
		return array('form' => $form);
	}
	
	public function deleteAction()
	{
		if (!$this->zfcUserAuthentication()->hasIdentity())
			return $this->redirect()->toRoute('user', array('action' => 'login'));
	
		$this->checkPermissions();
	
		return array('id' => $this->getEvent()->getRouteMatch()->getParam('id'));
	}
	
	public function dodeleteAction()
	{
		if (!$this->zfcUserAuthentication()->hasIdentity())
			return $this->redirect()->toRoute('user', array('action' => 'login'));
	
		$this->getSipServerTable()->deleteSipServer($this->getEvent()->getRouteMatch()->getParam('id'));
	
		return $this->redirect()->toRoute('sipsvr', array('action' => 'showall'));
	}
}
