<?php
namespace User\Model;

class User
{		
	public $user_id;
	public $username;
	public $display_name;
	public $password;
	public $permission_id;
	public $email;		
	/*
	 * fields from join
	 */
	public $permission;	
	
	protected $inputFilter;
	
	public function exchangeArrayFromForm($data)
	{
		$this->user_id			= (isset($data['fsOne']['user_id'])) ? $data['fsOne']['user_id'] : null;		
		$this->username			= (isset($data['fsOne']['username'])) ? $data['fsOne']['username'] : null;
		$this->display_name 	= (isset($data['fsOne']['display_name'])) ? $data['fsOne']['display_name'] : null;
		$this->password 		= (isset($data['fsOne']['password'])) ? $data['fsOne']['password'] : null;
		$this->permission_id 	= (isset($data['fsOne']['permission_id'])) ? $data['fsOne']['permission_id'] : null;
		$this->email 			= (isset($data['fsOne']['email'])) ? $data['fsOne']['email'] : null;
//		$this->directory_id 	= (isset($data['fsOne']['directory_id'])) ? $data['fsOne']['directory_id'] : null;
//		$this->directories 		= (isset($data['fsOne']['directories'])) ? $data['fsOne']['directories'] : null;		
	}
	
	public function exchangeArray($data)
	{			
		$this->user_id			= (isset($data['user_id'])) ? $data['user_id'] : null;
		$this->username			= (isset($data['username'])) ? $data['username'] : null;
		$this->display_name 	= (isset($data['display_name'])) ? $data['display_name'] : null;
		$this->password 		= (isset($data['password'])) ? $data['password'] : null;
		$this->permission_id 	= (isset($data['permission_id'])) ? $data['permission_id'] : null;
		$this->email 			= (isset($data['email'])) ? $data['email'] : null;
//		$this->directory_id 	= (isset($data['directory_id'])) ? $data['directory_id'] : null;
		
		$this->permission 		= (isset($data['permission'])) ? $data['permission'] : null;
		$this->name				= (isset($data['name'])) ? $data['name'] : null;
	}	
	
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
	
	public function getAsFieldsetArray()
	{
		return array('fsOne'	=> array(	'user_id'	=> $this->user_id,
											 	'username'	=> $this->username,
												'display_name'	=> $this->display_name,
												'password'	=> $this->password,
												'permission_id'	=> $this->permission_id,
												'email'			=> $this->email,												
//												'directory_id'	=> $this->directory_id
											)
					);
	}
}
