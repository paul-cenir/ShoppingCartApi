<?php

namespace CustomerApi\Controller\Registration;

use CustomerApi\Model\Customers;
use CustomerApi\Model\CustomersTable;
use CustomerApi\Service\AccessTokenService;
use CustomerApi\Service\Registration\RegistrationService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class RegistrationController extends AbstractRestfulController
{
    protected $eventIdentifier = 'SecuredController';

    private $CustomersTable;
    private $Customers;
    private $RegistrationService;
    private $AccessTokenService;
    public function __construct(
        Customers $Customers,
        CustomersTable $CustomersTable,
        RegistrationService $RegistrationService,
        AccessTokenService $AccessTokenService
    ) {

        $this->Customers = $Customers;
        $this->CustomersTable = $CustomersTable;
        $this->RegistrationService = $RegistrationService;
        $this->AccessTokenService = $AccessTokenService;
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
        $checkCustomerData = $this->RegistrationService->checkCustomerDataIfValid($params);
        if (!$checkCustomerData['isValid']) {
            $this->getResponse()->setStatusCode(400);
            return new JsonModel(["validation_error_messages" => $checkCustomerData['data']]);

        } else {
            $this->Customers->exchangeArray($checkCustomerData['data']);
            $customerId = $this->CustomersTable->registerCustomer($this->Customers);
            $accessToken = $this->AccessTokenService->generateAccessToken([
                "customer_id" => $customerId,
                "first_name" => $checkCustomerData['data']['first_name'],
                "last_name" => $checkCustomerData['data']['last_name'],
            ]);

            return new JsonModel([
                "data" => $accessToken,
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
