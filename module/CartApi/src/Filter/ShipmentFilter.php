<?php

namespace CartApi\Filter;

use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;

class ShipmentFilter extends InputFilter
{
    public function __construct()
    {
        
        $this->add(array(
            'name' => 'shipping_name',
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
                            NotEmpty::IS_EMPTY => 'shipping_name field is required.',
                        ),
                    ),
                ),
                array(
                    'name' => 'string_length',
                    'options' => array(
                        'max' => 35
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name' => 'shipping_address1',
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
                            NotEmpty::IS_EMPTY => 'shipping_address1 field is required.',
                        ),
                    ),
                ),
                array(
                    'name' => 'string_length',
                    'options' => array(
                        'max' => 35
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name' => 'shipping_address2',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array( 'name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'string_length',
                    'options' => array(
                        'max' => 35
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name' => 'shipping_address3',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array( 'name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'string_length',
                    'options' => array(
                        'max' => 35
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name' => 'shipping_city',
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
                            NotEmpty::IS_EMPTY => 'shipping_city field is required.',
                        ),
                    ),
                ),
                array(
                    'name' => 'string_length',
                    'options' => array(
                        'max' => 35
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name' => 'shipping_state',
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
                            NotEmpty::IS_EMPTY => 'shipping_state field is required.',
                        ),
                    ),
                ),
                array(
                    'name' => 'string_length',
                    'options' => array(
                        'max' => 35
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name' => 'shipping_country',
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
                            NotEmpty::IS_EMPTY => 'shipping_country field is required.',
                        ),
                    ),
                ),
                array(
                    'name' => 'string_length',
                    'options' => array(
                        'max' => 35
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name' => 'shipping_mehod',
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
                            NotEmpty::IS_EMPTY => 'shipping_mehod field is required.',
                        ),
                    ),
                ),
              
            ),
        ));
        $this->add(array(
            'name' => 'cart_id',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
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
