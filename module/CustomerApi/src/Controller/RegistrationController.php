<?php

namespace CustomerApi\Controller;

use CustomerApi\Service\RegistrationService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class RegistrationController extends AbstractRestfulController
{
    private $RegistrationService;

    public function __construct(RegistrationService $RegistrationService)
    {
        $this->RegistrationService = $RegistrationService;
    }

    public function create($data)
    {
        $customer = $this->RegistrationService->addCustomer($data);
        if (!$customer['isValid']) {
            $this->getResponse()->setStatusCode(400);
            return new JsonModel(["validation_error_messages" => $customer['data']]);
        } else {
            return new JsonModel([
                "data" => $customer['data'],
            ]);
        }
    }
}
