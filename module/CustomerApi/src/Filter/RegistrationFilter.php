<?php

namespace CustomerApi\Filter;

use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;
use Zend\Validator\Regex;

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
                array(
                    'name' => 'EmailAddress',
                    'options' => array(
                        'domain' => 'true',
                        'hostname' => 'true',
                        'mx' => 'true',
                        'deep' => 'true',
                        'message' => 'Invalid email address',
                    )
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
            'validators' => array(
                array(
                    'name' => 'Regex',
                    'options' => array(
                        'pattern' => '/^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$/',
                        'messages' => array(
                            \Zend\Validator\Regex::INVALID => 'Your error message.',
                        ),
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'company_name',
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
