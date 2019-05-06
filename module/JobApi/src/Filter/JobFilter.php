<?php

namespace JobApi\Filter;

use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;

class JobFilter extends InputFilter
{
    public function __construct()
    {
        $this->InputFilter = new InputFilter();
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

    public function getJobFilter()
    {
        $this->InputFilter->add(array(
            'name' => 'job_order_id',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));

        return $this->InputFilter;
    }


}
