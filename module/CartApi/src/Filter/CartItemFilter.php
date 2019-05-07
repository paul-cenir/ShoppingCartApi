<?php

namespace CartApi\Filter;

use Zend\InputFilter\InputFilter;

class CartItemFilter extends InputFilter
{
    private $InputFilter;
    public function __construct()
    {
        $this->InputFilter = new InputFilter();
    }

    public function getCartItemFilter()
    {
        $this->InputFilter->add(array(
            'name' => 'cart_item_id',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));

        return $this->InputFilter;
    }
}
