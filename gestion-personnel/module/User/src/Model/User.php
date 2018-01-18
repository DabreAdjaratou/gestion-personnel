<?php

namespace User\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;

class User 
{

    public $id;
    public $email;
    public $full_name;
    public $password;
    public $status;
    public $date_created;
    public $pwd_reset_token;
    public $pwd_reset_token_creation_date;

    // Add this property:
    private $inputFilter;


//    
//    const STATUS_ACTIVE = 1; // Active user.
//    const STATUS_RETIRED = 2; // Retired user.

    public function exchangeArray(array $data) {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->email = !empty($data['email']) ? $data['email'] : null;
        $this->full_name = !empty($data['full_name']) ? $data['full_name'] : null;
        $this->password = !empty($data['password']) ? $data['password'] : null;
        $this->status = !empty($data['status']) ? $data['status'] : null;
        $this->date_created = !empty($data['date_created']) ? $data['date_created'] : null;
        $this->pwd_reset_token = !empty($data['pwd_reset_token']) ? $data['pwd_reset_token'] : null;
        $this->pwd_reset_token_creation_date = !empty($data['pwd_reset_token_creation_date']) ? $data['pwd_reset_token_creation_date'] : null;
    }
    
   

    /**
     * Returns possible statuses as array.
     * @return array
     */
//    public static function getStatusList() 
//    {
//        return [
//            self::STATUS_ACTIVE => 'Active',
//            self::STATUS_RETIRED => 'Retired'
//        ];
//    }    
    
    /**
     * Returns user status as string.
     * @return string
     */
//    public function getStatusAsString()
//    {
//        $list = self::getStatusList();
//        if (isset($list[$this->status])){
//            return $list[$this->status];
//        }
//        return 'Unknown';
//    }    

   /* Add the following methods: */

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

       // Add input for "email" field
        $inputFilter->add([
                'name'     => 'email',
                'required' => true,
                'filters'  => [
                    ['name' => 'StringTrim'],                    
                ],                
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 1,
                            'max' => 128
                        ],
                    ],
                    [
                        'name' => 'EmailAddress',
                        'options' => [
                            'allow' => \Zend\Validator\Hostname::ALLOW_DNS,
                            'useMxCheck'    => false,                            
                        ],
                    ],
//                    [
//                        'name' => UserExistsValidator::class,
//                        'options' => [
//                            'entityManager' => $this->entityManager,
//                            'user' => $this->user
//                        ],
//                    ],                    
                ],
            ]);     
        
        // Add input for "full_name" field
        $inputFilter->add([
                'name'     => 'full_name',
                'required' => true,
                'filters'  => [                    
                    ['name' => 'StringTrim'],
                ],                
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 1,
                            'max' => 512
                        ],
                    ],
                ],
            ]);
        
    
            
            // Add input for "password" field
            $inputFilter->add([
                    'name'     => 'password',
                    'required' => true,
                    'filters'  => [                        
                    ],                
                    'validators' => [
                        [
                            'name'    => 'StringLength',
                            'options' => [
                                'min' => 6,
                                'max' => 64
                            ],
                        ],
                    ],
                ]);
            
            // Add input for "confirm_password" field
            $inputFilter->add([
                    'name'     => 'confirm_password',
                    'required' => true,
                    'filters'  => [                        
                    ],                
                    'validators' => [
                        [
                            'name'    => 'Identical',
                            'options' => [
                                'token' => 'password',                            
                            ],
                        ],
                    ],
                ]);
        
        
        // Add input for "status" field
        $inputFilter->add([
                'name'     => 'status',
                'required' => true,
                'filters'  => [                    
                    ['name' => 'ToInt'],
                ],                
                'validators' => [
                    ['name'=>'InArray', 'options'=>['haystack'=>[1, 2]]]
                ],
            ]);        
            

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}
