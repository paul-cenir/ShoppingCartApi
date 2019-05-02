<?php

namespace CustomerApi\Filter;

use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;

class LoginFilter extends InputFilter
{
    public function __construct()
    {

        $this->add(array(
            'name' => 'email',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
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
    }
}
