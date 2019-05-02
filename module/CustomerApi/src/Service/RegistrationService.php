<?php

namespace CustomerApi\Service;

use CustomerApi\Filter\RegistrationFilter;
use CustomerApi\Model\CustomersTable;
use Zend\Mvc\Controller\AbstractRestfulController;

class RegistrationService extends AbstractRestfulController
{
    private $CustomersTable;
    private $RegistrationFilter;
    public function __construct(CustomersTable $CustomersTable, RegistrationFilter $RegistrationFilter)
    {
        $this->CustomersTable = $CustomersTable;
        $this->RegistrationFilter = $RegistrationFilter;

    }

    public function getCustomerDataIfValid($params)
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
        return array("isValid" => true, "data" => $filteredParamData);
    }
}