<?php
namespace CreditData\Model;

class CreditData
{		
	public $credit_data_id;
	public $max_amount;
	public $consumed_amount;
	public $number_of_calls;
	public $concurrent_calls;
	public $credit_type;
	public $client_id;
	
	public function exchangeArray($data)
	{			
		$this->credit_data_id	= (isset($data['credit_data_id'])) ? $data['credit_data_id'] : null;
		$this->max_amount		= (isset($data['max_amount'])) ? $data['max_amount'] : null;
		$this->consumed_amount 	= (isset($data['consumed_amount'])) ? $data['consumed_amount'] : null;
		$this->number_of_calls	= (isset($data['number_of_calls'])) ? $data['number_of_calls'] : null;
		$this->concurrent_calls	= (isset($data['concurrent_calls'])) ? $data['concurrent_calls'] : null;
		$this->credit_type	 	= (isset($data['credit_type'])) ? $data['credit_type'] : null;
		$this->client_id 		= (isset($data['client_id'])) ? $data['client_id'] : null;		
	}
}
