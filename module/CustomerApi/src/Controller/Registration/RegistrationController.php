<?php

namespace CustomerApi\Controller\Registration;

use CustomerApi\Model\Customers;
use CustomerApi\Model\CustomersTable;
use CustomerApi\Service\TokenService;
use CustomerApi\Service\Registration\RegistrationService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class RegistrationController extends AbstractRestfulController
{
    protected $eventIdentifier = 'SecuredController';

    private $CustomersTable;
    private $Customers;
    private $RegistrationService;
    private $TokenService;
    public function __construct(
        Customers $Customers,
        CustomersTable $CustomersTable,
        RegistrationService $RegistrationService,
        TokenService $TokenService
    ) {

        $this->Customers = $Customers;
        $this->CustomersTable = $CustomersTable;
        $this->RegistrationService = $RegistrationService;
        $this->TokenService = $TokenService;
    }

    public function create($data)
    {
        //get input in Client
        //validate and sanitize
        //validate if email is existing in db
        //save data
        //create access token
        //return success
        $params = $this->params()->fromPost();
        $customerData = $this->RegistrationService->getCustomerDataIfValid($params);
        if (!$customerData['isValid']) {
            $this->getResponse()->setStatusCode(400);
            return new JsonModel(["validation_error_messages" => $customerData['data']]);

        } else {
            $this->Customers->exchangeArray($customerData['data']);
            $customerId = $this->CustomersTable->registerCustomer($this->Customers);
            $Token = $this->TokenService->generateToken([
                "customer_id" => $customerId,
                "first_name" => $customerData['data']['first_name'],
                "last_name" => $customerData['data']['last_name'],
            ]);

            return new JsonModel([
                "data" => $Token,
            ]);
        }
    }

    public function get($id)
    {

        return new JsonModel([]);
    }

    public function getList()
    {

        return new JsonModel([]);
    }

    public function update($id, $data)
    {
        return new JsonModel([]);
    }

    public function delete($id)
    {
        return new JsonModel([]);
    }

}
