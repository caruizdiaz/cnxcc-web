<?php
namespace SipServer\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;

class SipServerTable extends AbstractTableGateway
{
	protected $table = 'sip_server';
	
	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
		$this->resultSetPrototype = new ResultSet();
		$this->resultSetPrototype->setArrayObjectPrototype(new SipServer());
		$this->initialize();
	}
	
	public function fetchAll()
	{
		$resultSet = $this->select();
		return $resultSet;
	}
	
	public function getSipServer($id)
	{
		$id		= (int) $id;
		$sql 	= new Sql($this->adapter);
		$select	= $sql->select();
		
		$rowset	= $select->from($this->table)
						 ->where(array('sip_server_id' => $id));
		
		$statement 	= $sql->prepareStatementForSqlObject($select);
		$results 	= $statement->execute();
		$resultSet 	= $this->resultSetPrototype->initialize($results);			
		
		return $resultSet->current();
	}
	
	public function saveSipServer(SipServer $sipServer)
	{
		$data	= array(
					'sip_server_id'	=> $sipServer->sip_server_id,
					'host'			=> $sipServer->host,
					'port'			=> $sipServer->port,
					'default_server'=> $sipServer->default_server,
					);
	
		$id		= (int) $sipServer->sip_server_id;

		if ($sipServer->default_server == 'Y')
			$this->markAllAsNonDefault();
		
		if (0 == $id)
			$this->insert($data);		
		elseif ($this->getSipServer($id))
			$this->update($data, array('sip_server_id' => $id));
		else
			throw new \Exception("Error saving SipServer");
	}
	
	public function getDefaultSipServer()
	{
		$sql 	= new Sql($this->adapter);
		$select	= $sql->select();
		
		$rowset	= $select->from($this->table)
						 ->where(array('default_server' => 'Y'));
		
		$statement 	= $sql->prepareStatementForSqlObject($select);
		$results 	= $statement->execute();
		$resultSet 	= $this->resultSetPrototype->initialize($results);
		
		$row		= $resultSet->current(); 
		
		if (!$row)
			return null;
		
		return $row;
	}
	
	private function markAllAsNonDefault()
	{
		$query		= "UPDATE sip_server SET default_server = 'N'";
		$stmt		= $this->adapter->query($query);
		$results 	= $stmt->execute();
	}
	
	public function deleteSipServer($id)
	{
		$id	= (int) $id;
	
		if ($this->getSipServer($id))
			$this->delete(array('sip_server_id' => $id));
	}
	
}
