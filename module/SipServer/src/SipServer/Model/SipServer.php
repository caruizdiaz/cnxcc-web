<?php
namespace SipServer\Model;

class SipServer
{		
	public $sip_server_id;
	public $host;
	public $port;
	public $default_server;
	
	public function exchangeArray($data)
	{			
		$this->sip_server_id	= (isset($data['sip_server_id'])) ? $data['sip_server_id'] : null;
		$this->host				= (isset($data['host'])) ? $data['host'] : null;
		$this->port				= (isset($data['port'])) ? $data['port'] : null;
		$this->default_server 	= (isset($data['default_server'])) ? $data['default_server'] : null;		
	}	
	
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
	
	public function getAsFieldsetArray()
	{
		return array('fsOne'	=> array(	'sip_server_id'	=> $this->sip_server_id,
											'host'	=> $this->host,				
											'port'	=> $this->port,
											'default_server'	=> $this->default_server,
										)
		);
	}
	
	public function exchangeArrayFromForm($data)
	{
		$this->sip_server_id		= (isset($data['fsOne']['sip_server_id'])) ? $data['fsOne']['sip_server_id'] : null;
		$this->host					= (isset($data['fsOne']['host'])) ? $data['fsOne']['host'] : null;
		$this->port					= (isset($data['fsOne']['port'])) ? $data['fsOne']['port'] : null;
		$this->default_server		= (isset($data['fsOne']['default_server'])) ? $data['fsOne']['default_server'] : null;
	
	}
	

}
