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
    public function __construct(
        LoginService $LoginService,
        TokenService $TokenService
    ) {
        $this->LoginService = $LoginService;
        $this->TokenService = $TokenService;
    }

    public function create($data)
    {
        $user = $this->LoginService->login($data);
        if (!$user['isValid']) {
            $this->getResponse()->setStatusCode(400);
            return new JsonModel(["validation_error_messages" => $user['data']]);
        } else {
            return new JsonModel(["data" => $user['data']]);
        }
    }
}
