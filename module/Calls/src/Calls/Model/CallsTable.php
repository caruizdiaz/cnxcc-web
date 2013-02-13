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
		
		return $rowset;
	}	
	
	public function getCallInfo($callID)
	{
		$query	= "SELECT * FROM money_based_call WHERE call_id = '$callID'";
		$stmt	= $this->adapter->query($query);
		
		$results = $stmt->execute();
		
		return $results->current();
	}
	
	public function getForGrid($offsetFrom, $offsetTo, $search, $sortingCol, $sortingDir, $clientID, &$nor)
	{
		$columns	= array('call_id', 'confirmed', 'max_amount', 
							'consumed_amount', 'start_timestamp', 'client_id', 
							'TIMEDIFF(CURRENT_TIMESTAMP, start_timestamp) AS time_elapsed');
			
		$search			= "%$search%";
		$search			= $this->adapter->platform->quoteValue($search);
		$selectColums	= implode(',', $columns);
		
		$countQuery	= "SELECT COUNT(*) AS nor FROM `{$this->table}`";
		$query		= "SELECT $selectColums from `{$this->table}`";
		
		if ($clientID != null)
		{
			$filter		= " WHERE client_id = '$clientID'";
			$query	 	= "$query $filter";
			$countQuery	= "$countQuery $filter";
		}
		
		$filterByDir= "";
	
		if (isset($search) && $search != "'%%'") 
		{
				$filter	= "WHERE call_id LIKE $search";
				
				$query	=  "SELECT $selectColums from `{$this->table}` $filter ";
				$countQuery	= "SELECT COUNT(*) as nor from `{$this->table}` $filter";
				
				if ($clientID != null)
				{
					$filter	= " AND client_id = '$clientID'";
					$query .= " $filter";
					$countQuery .= " $filter";
				}
		}
	
		$query .= " ORDER BY {$columns[$sortingCol]} $sortingDir LIMIT $offsetFrom, $offsetTo";

		$stmt	= $this->adapter->query($query);
		$results = $stmt->execute();

		$stmt	= $this->adapter->query($countQuery);
		$count 	= $stmt->execute()->current();
			
		$nor	= $count['nor'];
		
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
