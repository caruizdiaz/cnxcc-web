<?php
namespace SipServer\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceManagerAwareInterface;

use Directory\Model\DirectoryTable;

class SipServerForm extends Form
{
    public function __construct() 
    {
    	parent::__construct();

        $this->setName('SipServer');
        $this->setAttribute('method', 'post');
        
        //Fieldset One
        $this->add(array(
            'name'          => 'fsOne',
            'type'          => 'Zend\Form\Fieldset',
            'options'       => array(
                'legend'        => 'SIP Server Configuration',
            ),
            'elements'      =>   array(
					    			array(
					    					'spec' => array(
					    							'name'          => 'sip_server_id',
					    							'type'          => 'Zend\Form\Element\Text',
					    							'attributes'       => array(
					    									'type'        => 'hidden',
					    							),
					    					),
					    			),
					    			//SipServername
					    			array(
					    					'spec' => array(
					    							'name'          => 'host',
					    							'type'          => 'Zend\Form\Element\Text',
					    							'options'       => array(
					    									'label'              => 'Domain-Name/IP',
					    							),
					    					),
					    			),
					    			// Port
					    			array(
					    					'spec' => array(
					    							'name'          => 'port',
					    							'type'          => 'Zend\Form\Element\Text',					    							
					    							'options'       => array(
					    									'label'              => 'XMLRPC Port #',
					    							),
					    					),
    								),
    								// Default
    								array(
    										'spec'	=> array(
    												'name'          => 'default_server',
    												'type'          => 'Zend\Form\Element\Select',
    												'options'       => array(
    														'label'             => 'Default',
    														'value_options'     => array(
    																'N'              	=> 'No',
    																'Y'             	=> 'Yes',
    														),
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
                           'value'      => 'Add Server',
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