<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use User\Form\UserForm;
use User\Form\UserLoginForm;
use User\Form\UserFormInputFilter;
use User\Form\UserLoginFormInputFilter;
use User\Model\User;

class UserController extends AbstractActionController
{
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
	
	protected function checkPermissions()
	{
		if (!$this->authenticatedUser()->isReady())
		{
			$this->authenticatedUser()->loadFromDatabase($this->getUserTable(),
														$this->zfcUserAuthentication()->getIdentity()->getId());
		}
		
		$isAdmin	= $this->authenticatedUser()->isAdmin();
		
		if (!$isAdmin)		
			return $this->redirect()->toRoute('user', array('action' => 'login'));
		
	}

	public function indexAction()
	{
		if (!$this->zfcUserAuthentication()->hasIdentity())
			return $this->redirect()->toRoute('user', array('action' => 'login'));
		
		$this->checkPermissions();
		
		return $this->redirect()->toRoute('user', array('action' => 'display'));
	}
	
	public function displayAction()
	{
		if (!$this->zfcUserAuthentication()->hasIdentity())
			return $this->redirect()->toRoute('user', array('action' => 'login'));
		
		$this->checkPermissions();
		
		return new ViewModel(array('users'	=> $this->getUserTable()->fetchAll()));
	}
	
	public function loggedInAction()
	{
		if (!$this->zfcUserAuthentication()->hasIdentity())
			return $this->redirect()->toRoute('user', array('action' => 'login'));
		
//		$this->checkPermissions();
	}
	
	public function addAction()
	{
		if (!$this->zfcUserAuthentication()->hasIdentity())
			return $this->redirect()->toRoute('user', array('action' => 'login'));
		
		$this->checkPermissions();
		
		$form			= $this->getServiceLocator()->get('User\Form\UserFormAdd');				
		
		$form->get('submit')->setValue('Add');
			
		$request	= $this->getRequest();
		if ($request->isPost())
		{
			$postData		= $request->getPost();
			$form->setData($postData);			
			
			if ($postData['fsOne']['password'] != $postData['fsOne']['password_confirmation'])	
			{
				return array('error' => 'Passwords don\'t match', 
							 'form' => $form);
			}
			
			$user			= new User();			
			
			if ($form->isValid())
			{
				$user->exchangeArrayFromForm($form->getData());
				$this->getUserTable()->saveUser($user);
				
				return $this->redirect()->toRoute('user', array('action' => 'display'));
			}
		}
		
		return array('form' => $form);
	}
	
	public function changeAction()
	{
		if (!$this->zfcUserAuthentication()->hasIdentity())
			return $this->redirect()->toRoute('user', array('action' => 'login'));		
		
		$this->setCredentialReady();
		
		$id = (int) $this->params()->fromRoute('id', $this->zfcUserAuthentication()->getIdentity()->getId());		
	
		if ($id != $this->zfcUserAuthentication()->getIdentity()->getId() && !$this->authenticatedUser()->isAdmin())
			return $this->redirect()->toRoute('user', array('action' => 'login'));		
		
		$user 	= $this->getUserTable()->getUser($id);
		
		$form	= new UserLoginForm();		
		$form->setInputFilter(new UserLoginFormInputFilter());
		
		$form->setData($user->getAsFieldsetArray());		
		
		$request = $this->getRequest();
		
		if ($request->isPost()) 
		{
			$postData		= $request->getPost();
			
			if ($postData['fsOne']['password'] != $postData['fsOne']['password_confirmation'])	
			{
				return array('error' => 'Passwords don\'t match', 
							 'form' => $form);
			}		
			
			$form->setData($postData);
			
			if ($form->isValid())
			{
				//$user->password	= $postData['fsOne']['password'];
				$this->getUserTable()->changePassword($user->user_id, $postData['fsOne']['password']);
		
				return $this->redirect()->toRoute('user');
			}
		}
		
		return array(	'user_id' => $id,
						'form' => $form);
	}
	
	public function editAction()
	{
		if (!$this->zfcUserAuthentication()->hasIdentity())
			return $this->redirect()->toRoute('user', array('action' => 'login'));
		
		$this->checkPermissions();
		
		$id = (int) $this->params()->fromRoute('id', 0);
		
		if (!$id) 
			return $this->redirect()->toRoute('user', array('action' => 'add'));		
		
		$user 				= $this->getUserTable()->getUser($id);			
		
		$form				= $this->getServiceLocator()->get('User\Form\UserFormEdit');		
		
		$form->setData($user->getAsFieldsetArray());
		$form->get('submit')->setAttribute('value', 'Save');		
		
		$request = $this->getRequest();

		if ($request->isPost()) 
		{			
			$postData		= $request->getPost();		
							
			$form->setData($request->getPost());
			
//			die ($form->isValid());
			
			if ($form->isValid()) 
			{
				$user->exchangeArrayFromForm($request->getPost());
				$this->getUserTable()->saveUser($user);
				
				return $this->redirect()->toRoute('user', array('action' => 'display'));
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
		
		$this->getUserTable()->deleteUser($this->getEvent()->getRouteMatch()->getParam('id'));
		
		return $this->redirect()->toRoute('user', array('action' => 'display'));
	}
	
	protected function setCredentialReady()
	{
		if (!$this->zfcUserAuthentication()->hasIdentity())
			throw \Exception("User not authenticated");
	
		if (!$this->authenticatedUser()->isReady())
		{
			$this->authenticatedUser()->loadFromDatabase(
					$this->getServiceLocator()->get('User\Model\UserTable'),
					$this->zfcUserAuthentication()->getIdentity()->getId()
			);
		}
	}
	
}
