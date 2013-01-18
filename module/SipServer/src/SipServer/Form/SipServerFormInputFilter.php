<?php
namespace SipServer\Form;

use Zend\InputFilter\InputFilter;

class SipServerFormInputFilter extends InputFilter
{
	public function __construct()
	{
		$inputFilter	= new InputFilter();
			
			$inputFilter->add(array(
				'name' => 'sip_server_id',
				'required' => true,
				'filters' => array(
						array('name' => 'Int'),
				),		
		));
			
		$inputFilter->add(array(
				'name'		=> 'host',
				'required'	=> true,
				'filters' 	=> array(
						array('name' => 'StripTags'),
						array('name' => 'StringTrim'),
				),
				'validators'=> array(
						array(
								'name' => 'StringLength',
								'options' => array(
										'encoding' 	=> 'UTF-8',
										'min'		=> 1,
										'max'		=> 30,
								),
						),
						array(
								'name' => 'NotEmpty',
								'options' => array(
										'encoding' 	=> 'UTF-8',
								),
						),
				),
		));
		
		$inputFilter->add(array(
				'name'		=> 'port',
				'required'	=> true,
				'filters' => array(
						array('name' => 'Int'),
				),	
				'validators'=> array(
						array(
								'name' => 'NotEmpty',
								'options' => array(
										'encoding' 	=> 'UTF-8',
								),
						),
				),
		));		
		
		$this->add($inputFilter, 'fsOne');
	}
}