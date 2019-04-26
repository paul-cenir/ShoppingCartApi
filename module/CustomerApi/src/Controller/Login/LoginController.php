<?php

namespace CustomerApi\Controller\Login;

use CustomerApi\Service\AccessTokenService;
use CustomerApi\Service\Login\LoginService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class LoginController extends AbstractRestfulController
{
    private $LoginService;
    private $AccessTokenService;
    public function __construct
    (
        LoginService $LoginService,
        AccessTokenService $AccessTokenService
    ) {
        $this->LoginService = $LoginService;
        $this->AccessTokenService = $AccessTokenService;
    }

    public function create($data)
    {
        //get input in Client
        //validate and sanitize
        //validate if account is valid
        //create access token
        //return success

        $params = $this->params()->fromPost();
        $checkAccountData = $this->LoginService->checkAccountIfValid($params);
        if (!$checkAccountData['isValid']) {
            $this->getResponse()->setStatusCode(400);
            return new JsonModel(["validation_error_messages" => $checkAccountData['data']]);
        } else {
            $accessToken = $this->AccessTokenService->generateAccessToken([
                "customer_id" => $checkAccountData['data']['customer_id'],
                "first_name" => $checkAccountData['data']['first_name'],
                "last_name" => $checkAccountData['data']['last_name'],
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
