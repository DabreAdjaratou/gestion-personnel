<?php
namespace User\Form;

use Zend\Form\Form;

class UserForm extends Form
{
   
    
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('user');
        
        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);

        // Add "email" field
        $this->add([            
            'type'  => 'text',
            'name' => 'email',
            'options' => [
                'label' => 'E-mail',
            ],
        ]);
        
        // Add "full_name" field
        $this->add([            
            'type'  => 'text',
            'name' => 'full_name',            
            'options' => [
                'label' => 'Full Name',
            ],
        ]);
        
        
        
            // Add "password" field
            $this->add([            
                'type'  => 'password',
                'name' => 'password',
                'options' => [
                    'label' => 'Password',
                ],
            ]);
            
            // Add "confirm_password" field
            $this->add([            
                'type'  => 'password',
                'name' => 'confirm_password',
                'options' => [
                    'label' => 'Confirm password',
                ],
            ]);
        
        
        // Add "status" field
        $this->add([            
            'type'  => 'select',
            'name' => 'status',
            'options' => [
                'label' => 'Status',
                'value_options' => [
                    1 => 'Active',
                    2 => 'Retired',                    
                ]
            ],
        ]);
        
        // Add the Submit button
        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [                
                'value' => 'Create'
            ],
        ]);
    }
    
    
}
