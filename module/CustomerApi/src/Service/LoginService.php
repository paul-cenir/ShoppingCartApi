<?php

namespace CustomerApi\Service;

use CustomerApi\Filter\LoginFilter;
use CustomerApi\Model\CustomersTable;
use CustomerApi\Service\TokenService;

class LoginService
{
    private $CustomersTable;
    private $LoginFilter;
    private $TokenService;
    public function __construct(
        CustomersTable $CustomersTable,
        LoginFilter $LoginFilter,
        TokenService $TokenService
    ) {
        $this->CustomersTable = $CustomersTable;
        $this->LoginFilter = $LoginFilter;
        $this->TokenService = $TokenService;

    }

    public function login($params)
    {
        $this->LoginFilter->setData($params);
        if (!$this->LoginFilter->isValid()) {

            return array("isValid" => false, "data" => $this->LoginFilter->getMessages());
        }
        $filteredParamData = $this->LoginFilter->getValues();
        $customerData = $this->CustomersTable->getCustomerByEmail($filteredParamData['email']);
        if ($customerData['password'] === $filteredParamData['password']) {
            $accessToken = $this->TokenService->generateToken([
                "customer_id" => $customerData['customer_id'],
                "first_name" => $customerData['first_name'],
                "last_name" => $customerData['last_name'],
            ]);
            return array("isValid" => true, "data" => $accessToken);
        } else {
            return array("isValid" => false, "data" => "Account does not exist");
        }
    }
}
