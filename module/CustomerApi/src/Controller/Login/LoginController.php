<?php

namespace CustomerApi\Controller\Login;

use CustomerApi\Service\TokenService;
use CustomerApi\Service\Login\LoginService;
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
        //get input in Client
        //validate and sanitize
        //validate if account is valid
        //create access token
        //return success

        $params = $this->params()->fromPost();
        $accountData = $this->LoginService->checkAccountIfValid($params);
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
