<?php
namespace Calls\Model;

class Calls
{		
	public $call_id;
	public $confirmed;
	public $max_amount;
	public $consumed_amount;
	public $start_timestamp;
	public $client_id;
	public $time_elapsed;
	
	public function exchangeArray($data)
	{			
		$this->call_id			= (isset($data['call_id'])) ? $data['call_id'] : null;
		$this->confirmed		= (isset($data['confirmed'])) ? $data['confirmed'] : null;
		$this->max_amount		= (isset($data['max_amount'])) ? $data['max_amount'] : null;
		$this->consumed_amount 	= (isset($data['consumed_amount'])) ? $data['consumed_amount'] : null;
		$this->start_timestamp 	= (isset($data['start_timestamp'])) ? $data['start_timestamp'] : null;
		$this->client_id		= (isset($data['client_id'])) ? $data['client_id'] : null;
		$this->time_elapsed		= (isset($data['time_elapsed'])) ? $data['time_elapsed'] : null;
	}	
	
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}

}
