<?php

namespace CustomerApi\Service\Registration;

use CustomerApi\Filter\Registration\RegistrationFilter;
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

    public function checkCustomerDataIfValid($params)
    {
        $this->RegistrationFilter->setData($params);
        $filteredParamData = $this->RegistrationFilter->getValues();
        if (!$this->RegistrationFilter->isValid()) {

            return array("isValid" => false, "data" => $this->RegistrationFilter->getMessages());
        }
        $checkIfEmailExist = $this->CustomersTable->getCustomerByEmail($filteredParamData['email']);
        if ($checkIfEmailExist) {

            return array("isValid" => false, "data" => "Email already exist");
        }

        return array("isValid" => true, "data" => $filteredParamData);
    }

}
