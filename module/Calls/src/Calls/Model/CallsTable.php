<?php
namespace Calls\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;

class CallsTable extends AbstractTableGateway
{
	protected $table = 'call';
	
	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
		$this->resultSetPrototype = new ResultSet();
		$this->resultSetPrototype->setArrayObjectPrototype(new Calls());
		$this->initialize();
	}
	
	public function fetchAll()
	{
		$resultSet = $this->select();
		return $resultSet;
	}
	
	public function getCallsByClientID($id)
	{				
		
		$rowset	= $this->select(array('client_id' => $id));
		
		$row	= $rowset->current();
		
		if (!$row)
			throw new \Exception("Couldn't find row $id");
		
		return $row;
	}	
	
	public function getCallInfo($callID)
	{
		$query	= "SELECT * FROM money_based_call WHERE call_id = '$callID'";
		$stmt	= $this->adapter->query($query);
		
		$results = $stmt->execute();
		
		return $results->current();
	}
	
	public function getForGrid($offsetFrom, $offsetTo, $search, $sortingCol, $sortingDir)
	{
		$columns	= array('call_id', 'confirmed', 'max_amount', 'consumed_amount', 'start_timestamp', 'client_id');
			
		$search			= "%$search%";
		$search			= $this->adapter->platform->quoteValue($search);
		$selectColums	= implode(',', $columns);
	
		$query		= "SELECT $selectColums from `{$this->table}`";
		$filterByDir= "";
	
		if (isset($search) && $search != "'%%'")
				$query	=  "SELECT $selectColums from `{$this->table}` WHERE ".
				"call_id LIKE $search";
	
		$query .= " ORDER BY {$columns[$sortingCol]} $sortingDir LIMIT $offsetFrom, $offsetTo";

		$stmt	= $this->adapter->query($query);

		$results = $stmt->execute();

		return $results;
	
	}
	
	public function getNumberOfRows()
	{
		$query		= "SELECT count(*) AS nor FROM `{$this->table}`";
	
		$stmt	= $this->adapter->query($query);
	
		$row = $stmt->execute()->current();
	
		return $row['nor'];
	}
}
