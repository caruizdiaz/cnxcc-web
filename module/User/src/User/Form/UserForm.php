<?php
namespace User\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceManagerAwareInterface;

use Directory\Model\DirectoryTable;

class UserForm extends Form
{
    public function __construct($forEdit = false) 
    {
    	parent::__construct();

        $this->setName('User');
        $this->setAttribute('method', 'post');
        
        $elements	= $forEdit ? $this->editElements() : $this->addNewElements();        
        
        //Fieldset One
        $this->add(array(
            'name'          => 'fsOne',
            'type'          => 'Zend\Form\Fieldset',
            'options'       => array(
                'legend'        => $forEdit ? 'Edit Existing User' : 'Add New User',
            ),
            'elements'      =>   $elements ));

        //Submit button
        $this->add(array(
                       'name'       => 'submit',
                       'type'       => 'Zend\Form\Element\Submit',
                       'attributes' => array(
                           'value'      => 'Create User',
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
    
    private function addNewElements()
    {
    	return array(
    			 
    			array(
    					'spec' => array(
    							'name'          => 'user_id',
    							'type'          => 'Zend\Form\Element\Text',
    							'attributes'       => array(
    									'type'        => 'hidden',
    							),
    					),
    			),
    			//Username
    			array(
    					'spec' => array(
    							'name'          => 'username',
    							'type'          => 'Zend\Form\Element\Text',
    							'options'       => array(
    									'label'              => 'Username',
    							),
    					),
    			),
    			//Real Name
    			array(
    					'spec' => array(
    							'name'          => 'display_name',
    							'type'          => 'Zend\Form\Element\Text',
    							'attributes'    => array(
    									'placeholder'       => "User's real name",
    							),
    							'options'       => array(
    									'label'              => 'Real Name',
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
    			// permission
    			array(
    					'spec'	=> array(
    							'name'          => 'permission_id',
    							'type'          => 'Zend\Form\Element\Select',
    							'options'       => array(
    									'label'             => 'Permissions',
    									'value_options'     => array(
    											'2'              	=> 'Basic',
    											'1'             	=> 'Admin',
    											'3'             	=> 'Basic + Can Drop Calls',
    									),
    							),
    					),
    			),
    	);
    }
    
    private function editElements()
    {
    	return array(
    	
    			array(
    					'spec' => array(
    							'name'          => 'user_id',
    							'type'          => 'Zend\Form\Element\Text',
    							'attributes'       => array(
    									'type'        => 'hidden',
    							),
    					),
    			),
    			//Username
    			array(
    					'spec' => array(
    							'name'          => 'username',
    							'type'          => 'Zend\Form\Element\Text',
    							'options'       => array(
    									'label'              => 'Username',
    							),
    					),
    			),
    			//Real Name
    			array(
    					'spec' => array(
    							'name'          => 'display_name',
    							'type'          => 'Zend\Form\Element\Text',
    							'attributes'    => array(
    									'placeholder'       => "User's real name",
    							),
    							'options'       => array(
    									'label'              => 'Real Name',
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
    			// permission
    			array(
    					'spec'	=> array(
    							'name'          => 'permission_id',
    							'type'          => 'Zend\Form\Element\Select',
    							'options'       => array(
    									'label'             => 'Permissions',
    									'value_options'     => array(
    											'2'              	=> 'Basic',
    											'1'             	=> 'Admin',
    											'3'             	=> 'Basic + Can Drop Calls',
    									),
    							),
    					),
    			),
    	);
    }       
   
}