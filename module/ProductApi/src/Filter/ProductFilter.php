<?php

namespace ProductApi\Filter;

use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;

class ProductFilter extends InputFilter
{
    public function __construct()
    {
        $this->InputFilter = new InputFilter();
        $this->add(array(
            'name' => 'product_id',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
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
                array(
                    'name' => 'Regex',
                    'options' => array(
                        'pattern' => '/^[0-9]+$/',
                        'messages' => array(
                            \Zend\Validator\Regex::INVALID => 'Number only',
                        ),
                    ),
                ),
            ),
        ));
    }
}
