<?php

namespace CustomerApi\Service;

use CustomerApi\Filter\RegistrationFilter;
use CustomerApi\Model\Customers;
use CustomerApi\Model\CustomersTable;
use CustomerApi\Service\TokenService;
use Zend\Mvc\Controller\AbstractRestfulController;

class RegistrationService extends AbstractRestfulController
{
    private $CustomersTable;
    private $RegistrationFilter;
    private $TokenService;
    private $Customers;
    public function __construct(
        CustomersTable $CustomersTable,
        RegistrationFilter $RegistrationFilter,
        TokenService $TokenService,
        Customers $Customers
    ) {
        $this->CustomersTable = $CustomersTable;
        $this->RegistrationFilter = $RegistrationFilter;
        $this->RegistrationFilter = $RegistrationFilter;
        $this->TokenService = $TokenService;
        $this->Customers = $Customers;
    }

    public function addCustomer($params)
    {
        $this->RegistrationFilter->setData($params);
        if (!$this->RegistrationFilter->isValid()) {
            return array("isValid" => false, "data" => $this->RegistrationFilter->getMessages());
        }
        $filteredParamData = $this->RegistrationFilter->getValues();
        $customerData = $this->CustomersTable->getCustomerByEmail($filteredParamData['email']);
        if ($customerData) {
            return array("isValid" => false, "data" => "Email already exist");
        }
        $this->Customers->exchangeArray($filteredParamData);
        $customerId = $this->CustomersTable->registerCustomer($this->Customers);
        $Token = $this->TokenService->generateToken([
            "customer_id" => $customerId,
            "first_name" => $filteredParamData['first_name'],
            "last_name" => $filteredParamData['last_name'],
        ]);
        return array("isValid" => true, "data" => $Token);
    }
}
