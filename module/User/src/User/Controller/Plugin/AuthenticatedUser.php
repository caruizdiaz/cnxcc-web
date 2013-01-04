<?php 
namespace User\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;

use User\Model\UserTable;

class AuthenticatedUser extends AbstractPlugin
{
	const ADMIN				= 1;
	const NORMAL_USER		= 2;
	const PRIVILEGED_USER	= 3;
	
	public $user_id			= 0;
	public $permission_id	= 0;
	
	public function isAdmin()
	{
		if ($this->user_id	== 0)
			throw new \Exception("Not authenticated");
		
		return self::ADMIN == $this->permission_id;
	}
		
	public function loadFromDatabase(UserTable $userTable, $userID)
	{		
		$user	= $userTable->getUser($userID);
		
		$this->user_id		= $userID;		
		$this->permission_id= $user->permission_id;
		
//		die($this->permission_id);
	}
	
	public function reset()
	{
		$this->user_id		= 0;		
		$this->permission_id= 0;
	}
	
	public function isReady()
	{
		return 0 != $this->user_id;
	}
	
	public function isPrivilegedUser()
	{
		if ($this->user_id	== 0)
			throw new \Exception("Not authenticated");
	
		return self::PRIVILEGED_USER == $this->permission_id;
	}
}

?>