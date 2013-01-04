<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

use User\Model\UserTable;

class AuthenticatedUser extends AbstractHelper
{
	const ADMIN				= 1;
	const NORMAL_USER		= 2;
	const PRIVILEGED_USER	= 3;
	
	public $user_id			= 0;
	public $permission_id	= 0;	
	
	protected $table		= null;
	/*public function __invoke()
	{
		if ($this->info)
			return $this->info;
		else
			return false;
	}*/
	
	public function isAdmin()
	{
		if ($this->user_id	== 0)
			throw new \Exception("Not authenticated");
		
		return self::ADMIN == $this->permission_id;
	}
	
	public function isNormalUser()
	{
		if ($this->user_id	== 0)
			throw new \Exception("Not authenticated");
		
		return self::NORMAL_USER == $this->permission_id;
	}
	
	public function isPrivilegedUser()
	{
		if ($this->user_id	== 0)
			throw new \Exception("Not authenticated");
		
		return self::PRIVILEGED_USER == $this->permission_id;
	}
	
	public function setTable(UserTable $userTable)
	{
		$this->table	= $userTable;
	}
	
	public function loadFromDatabase($userID)
	{	
		if (null == $this->table)
			throw new \Exception("UserTable not asigned");	
		
		$userTable			= $this->table;
		
		$user				= $userTable->getUser($userID);
		
		$this->user_id		= $userID;
		$this->permission_id= $user->permission_id;
		
	}
	
	public function isReady()
	{
		return 0 != $this->user_id;
	}
	
}