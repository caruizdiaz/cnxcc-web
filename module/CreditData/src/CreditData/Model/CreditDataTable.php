<?php
namespace CreditData\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;

class CreditDataTable extends AbstractTableGateway
{
	protected $table = 'credit_data';
	
	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
		$this->resultSetPrototype = new ResultSet();
		$this->resultSetPrototype->setArrayObjectPrototype(new CreditData());
		$this->initialize();
	}
	
	public function fetchAll()
	{
		$resultSet = $this->select();
		return $resultSet;		
	}
	
	public function getForGrid($offsetFrom, $offsetTo, $search, $sortingCol, $sortingDir)
	{
		$columns	= array('credit_data_id', '`max_amount`', '`consumed_amount`', '`number_of_calls`', 'concurrent_calls', 'client_id', 'credit_type_id');
			
		$search			= "%$search%";
		$search			= $this->adapter->platform->quoteValue($search);
		$selectColums	= implode(',', $columns);
		$selectColums   .= ", CASE credit_type_id WHEN 1 THEN 'money based' ELSE 'time based' END  AS credit_type";
		
		$query		= "SELECT $selectColums from {$this->table}";		
		$filterByDir= "";
		
		if (isset($search) && $search != "'%%'")
			$query	=  "SELECT $selectColums from {$this->table} WHERE ".
						"client_id LIKE $search";

		$query .= " ORDER BY {$columns[$sortingCol]} $sortingDir LIMIT $offsetFrom, $offsetTo";		
		
		$stmt	= $this->adapter->query($query);
		
		$results = $stmt->execute();
		
		return $results;
		
	}
	
	public function getNumberOfRows()
	{
		$query		= "SELECT count(*) AS nor FROM {$this->table}";		
		
		$stmt	= $this->adapter->query($query);
		
		$row = $stmt->execute()->current();
		
		return $row['nor'];
	}
}
