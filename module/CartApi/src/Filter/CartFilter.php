<?php

namespace CartApi\Filter;

use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;
use Zend\Validator\Regex;

class CartFilter extends InputFilter
{
    private $InputFilter;
    public function __construct()
    {
        $this->InputFilter = new InputFilter();
    }

    public function addCartFilter()
    {
        $this->InputFilter->add(array(
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
            ),
        ));

        $this->InputFilter->add(array(
            'name' => 'qty',
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
                            NotEmpty::IS_EMPTY => 'qty field is required.',
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

        $this->InputFilter->add(array(
            'name' => 'cart_id',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));

        return $this->InputFilter;
    }

    public function getCartFilter()
    {
        $this->InputFilter->add(array(
            'name' => 'cart_id',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));

        return $this->InputFilter;
    }
}
