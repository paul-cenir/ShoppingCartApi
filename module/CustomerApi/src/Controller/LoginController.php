<?php

namespace CustomerApi\Controller;

use CustomerApi\Service\LoginService;
use CustomerApi\Service\TokenService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class LoginController extends AbstractRestfulController
{
    private $LoginService;
    private $TokenService;
    public function __construct
    (
        LoginService $LoginService,
        TokenService $TokenService
    ) {
        $this->LoginService = $LoginService;
        $this->TokenService = $TokenService;
    }

    public function create($data)
    {
        $accountData = $this->LoginService->checkAccountIfValid($data);
        if (!$accountData['isValid']) {
            $this->getResponse()->setStatusCode(400);
            return new JsonModel(["validation_error_messages" => $accountData['data']]);
        } else {
            $Token = $this->TokenService->generateToken([
                "customer_id" => $accountData['data']['customer_id'],
                "first_name" => $accountData['data']['first_name'],
                "last_name" => $accountData['data']['last_name'],
            ]);

            return new JsonModel([
                "data" => $Token,
            ]);
        }
    }
}
