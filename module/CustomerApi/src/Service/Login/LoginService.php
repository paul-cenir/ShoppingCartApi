<?php

namespace CustomerApi\Service\Login;

use CustomerApi\Filter\Login\LoginFilter;
use CustomerApi\Model\CustomersTable;
use Zend\Mvc\Controller\AbstractRestfulController;

class LoginService extends AbstractRestfulController
{
    private $CustomersTable;
    private $LoginFilter;
    public function __construct(CustomersTable $CustomersTable, LoginFilter $LoginFilter)
    {
        $this->CustomersTable = $CustomersTable;
        $this->LoginFilter = $LoginFilter;

    }

    public function checkAccountIfValid($params)
    {

        $this->LoginFilter->setData($params);
        $filteredParamData = $this->LoginFilter->getValues();
        if (!$this->LoginFilter->isValid()) {

            return array("isValid" => false, "data" => $this->LoginFilter->getMessages());
        }
        $checkIfEmailExist = get_object_vars($this->CustomersTable->getCustomerByEmail($filteredParamData['email']));
        $filteredParamData['customer_id'] = $checkIfEmailExist['customer_id']; 
        if ($checkIfEmailExist['password'] === $filteredParamData['password']) {

            return array("isValid" => true, "data" => $filteredParamData);
        } else {
            return array("isValid" => false, "data" => "Invalid account");
        }

    }

}
