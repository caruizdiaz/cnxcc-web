<?php
namespace User\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceManagerAwareInterface;

use Directory\Model\DirectoryTable;

class UserLoginForm extends Form
{
    public function __construct($forEdit = false) 
    {
    	parent::__construct();

        $this->setName('User Login Data');
        $this->setAttribute('method', 'post');
        
        //Fieldset One
        $this->add(array(
            'name'          => 'fsOne',
            'type'          => 'Zend\Form\Fieldset',
            'options'       => array(
				'legend'        =>  'Change My Login Info'
            ),
            'elements'      => array(
            		
				array(
					'spec' => array(
	            		'name'          => 'user_id',
	            		'type'          => 'Zend\Form\Element\Text',
	            		'attributes'    => array(
	            			'type'			=> 'hidden',	            	
	            				),
					 	),
					),			
                //Password
                array(
                    'spec'  => array(
                        'name'          => 'password',
                        'type'          => 'Zend\Form\Element\Password',
                        'options'       => array(
                            'label'             => 'Password',                            
                            //'prependText'   => 'Prepend text',
                            //'appendText'    => 'Append text',
                        ),
                    ),
                ),
                //Confirm Password
                array(
                		'spec'  => array(
                				'name'          => 'password_confirmation',
                				'type'          => 'Zend\Form\Element\Password',
                				'options'       => array(
                						'label'             => 'Confirmation',
                						//'prependText'   => 'Prepend text',
                						//'appendText'    => 'Append text',
                				),
                		),
                ),
                // email
                array(
                		'spec'  => array(
                				'name'          => 'email',
                				'type'          => 'Zend\Form\Element\Email',
                				'options'       => array(
                						'label'             => 'Email Address',                						//
                				),
                		),
                ),
             )                          
        ));

        //Submit button
        $this->add(array(
                       'name'       => 'submit',
                       'type'       => 'Zend\Form\Element\Submit',
                       'attributes' => array(
                           'value'      => 'Update',
                       ),
                       'options'    => array(
                           'primary'    => true,
                       ),
                   ));

        //Reset button
        $this->add(array(
                       'name'       => 'reset',
//        				'type'       => 'reset',
                       'attributes' => array(
                           'type'       => 'reset',
                           'value'      => 'Reset',
                       ),
                   ));              
    }
}