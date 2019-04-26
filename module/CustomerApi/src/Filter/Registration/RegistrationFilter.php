<?php

namespace CustomerApi\Filter\Registration;

use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;

class RegistrationFilter extends InputFilter
{
    public function __construct()
    {

   
        $this->add(array(
            'name' => 'email',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array(
                    'name' => 'StringTrim',
                ),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            NotEmpty::IS_EMPTY => 'Email is required.',
                        ),
                    ),
                ),
            ),
        ));
    
        $this->add(array(
            'name' => 'password',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array(
                    'name' => 'StringTrim',
                ),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            NotEmpty::IS_EMPTY => 'Password is required.',
                        ),
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name' => 'first_name',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array(
                    'name' => 'StringTrim',
                )
                // array(
                //     'name' => 'Ucwords',
                // ),

            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            NotEmpty::IS_EMPTY => 'First name is required.',
                        ),
                    ),
                ),
            ),
        ));
    
        $this->add(array(
            'name' => 'last_name',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array(
                    'name' => 'StringTrim',
                ),
                // array(
                //     'name' => 'Ucwords',
                // ),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            NotEmpty::IS_EMPTY => 'Last name is required.',
                        ),
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'phone',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array(
                    'name' => 'StringTrim',
                ),
            ),
            
        ));
  
     
        
    }
}
