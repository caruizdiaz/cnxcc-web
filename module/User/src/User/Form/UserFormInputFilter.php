<?php
namespace User\Form;

use Zend\InputFilter\InputFilter;

class UserFormInputFilter extends InputFilter
{
	public function __construct($forEdit = false)
	{
		$inputFilter	= new InputFilter();
			
		$inputFilter->add(array(
				'name' => 'user_id',
				'required' => true,
				'filters' => array(
						array('name' => 'Int'),
				),		
		));
			
		$inputFilter->add(array(
				'name'		=> 'username',
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
										'min'		=> 3,
										'max'		=> 20,
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
				'name' => 'display_name',
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
										'min'		=> 3,
										'max'		=> 20,
								),
						),
				),
		)
		);
		
		if (!$forEdit)
			$inputFilter->add(array(
					'name' => 'password',
					'required'	=> true,
					'validators'=> array(
							array(
									'name' => 'StringLength',
									'options' => array(
											'encoding' 	=> 'UTF-8',
											'min'		=> 6,
											'max'		=> 128,
									),
							),
					),
				)
			);
			
		$inputFilter->add(array(
				'name' => 'email',
				'required'	=> false,
				'validators'=> array(
						array(
								'name' => 'EmailAddress',
								'options' => array(
										'encoding' 	=> 'UTF-8',
								),
						),
				),
		)
		);
		
		
		$this->add($inputFilter, 'fsOne');
	}
}