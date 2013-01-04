<?php
namespace User\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Crypt\Password\Bcrypt;

class UserTable extends AbstractTableGateway
{
	protected $table = 'user';
	
	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
		
		$this->resultSetPrototype = new ResultSet();
		$this->resultSetPrototype->setArrayObjectPrototype(new User());
		
		$this->initialize();
	}
	
	public function fetchAll()
	{
		$sql = new Sql($this->adapter);
		$select = $sql->select();

		$statement	= $this->adapter->query("SELECT `user`.*, `permission`.`description` AS `permission`
											 FROM `user` INNER JOIN `permission` ON `user`.`permission_id` = `permission`.`permission_id`
											GROUP BY user.user_id");
		
		$results = $statement->execute();
		
		$resultSet = $this->resultSetPrototype->initialize($results);
		
		return $resultSet;
		
		/*$resultSet = $this->select();
		return $resultSet;*/
	}
	
	public function getUser($id)
	{
		$id		= (int) $id;
		$sql 	= new Sql($this->adapter);
		$select	= $sql->select();
		
		$rowset	= $select->from($this->table)								
					     ->where(array('user.user_id' => $id));
		
		$statement 	= $sql->prepareStatementForSqlObject($select);
		$results 	= $statement->execute();
		$resultSet 	= $this->resultSetPrototype->initialize($results);
		
		$row		= $resultSet->current();
		
		if (!$row)
			throw new \Exception("Couldn't find row $id");
		
		return $row;
	}	
	
	protected function encryptPassword($password)
	{
		$bcrypt = new Bcrypt();
		$bcrypt->setCost(14);
			
		return  $bcrypt->create($password);
	}
	
	public function changePassword($userID, $password)
	{
		$data	= array('password'	=> $this->encryptPassword($password));
		
		$this->update($data, array('user_id' => $userID));
	}
	
	public function saveUser(User $user)
	{
		$data	= array(
						'username'	=> $user->username,						
						'email'		=> $user->email,
						'display_name'	=> $user->display_name,						
						'permission_id'	=> $user->permission_id,
						/*'directory_id'	=> $user->directory_id*/ );
		
		$id		= (int) $user->user_id;
			
		if (0 == $id)
		{		
			$data['password'] = $this->encryptPassword($user->password);
			$this->insert($data);									
		}
		elseif ($this->getUser($id))
		{
			$this->update($data, array('user_id' => $id));
		}
		else
			throw new \Exception("Error saving user");		
	}
	
	public function deleteUser($id)
	{
		$id	= (int) $id;
		
		if ($this->getUser($id))
			$this->delete(array('user_id' => $id));
	}
}
