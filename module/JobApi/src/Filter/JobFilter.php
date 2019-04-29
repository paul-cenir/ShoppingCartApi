<?php

namespace JobApi\Filter;

use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;

class JobFilter extends InputFilter
{
    public function __construct()
    {
        
        $this->add(array(
            'name' => 'cart_id',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array( 'name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            NotEmpty::IS_EMPTY => 'cart_id field is required.',
                        ),
                    ),
                ),
            ),
        ));
    }
}
