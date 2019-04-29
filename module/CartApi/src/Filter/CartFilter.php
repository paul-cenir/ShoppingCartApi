<?php

namespace CartApi\Filter;

use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;

class CartFilter extends InputFilter
{
    public function __construct()
    {
        
        $this->add(array(
            'name' => 'product_id',
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
                            NotEmpty::IS_EMPTY => 'product_id field is required.',
                        ),
                    ),
                ),
            ),
        ));
    
        $this->add(array(
            'name' => 'qty',
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
                            NotEmpty::IS_EMPTY => 'qty field is required.',
                        ),
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'customer_id',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array( 'name' => 'StringTrim'),
            ),
        ));
    }
}
