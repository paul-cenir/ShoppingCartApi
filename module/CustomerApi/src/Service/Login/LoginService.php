<?php

namespace CustomerApi\Service\Login;

use CustomerApi\Filter\Login\LoginFilter;
use CustomerApi\Model\CustomersTable;

class LoginService
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
        if (!$this->LoginFilter->isValid()) {

            return array("isValid" => false, "data" => $this->LoginFilter->getMessages());
        }
        $filteredParamData = $this->LoginFilter->getValues();
        $customerData = get_object_vars($this->CustomersTable->getCustomerByEmail($filteredParamData['email']));
        $filteredParamData['customer_id'] = $customerData['customer_id'];
        $filteredParamData['first_name'] = $customerData['first_name'];
        $filteredParamData['last_name'] = $customerData['last_name'];
        if ($customerData['password'] === $filteredParamData['password']) {
            return array("isValid" => true, "data" => $filteredParamData);
        } else {
            return array("isValid" => false, "data" => "Invalid account");
        }
    }
}
