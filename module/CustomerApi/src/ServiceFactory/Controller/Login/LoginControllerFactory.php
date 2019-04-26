<?php

namespace CustomerApi\ServiceFactory\Controller\Login;

use CustomerApi\Controller\Login\LoginController;
use CustomerApi\Service\AccessTokenService;
use CustomerApi\Service\Login\LoginService;
use Psr\Container\ContainerInterface;

class LoginControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator(); // remove if zf3

        $LoginService = $container->get(LoginService::class);
        $AccessTokenService = $container->get(AccessTokenService::class);

        return new LoginController($LoginService,$AccessTokenService);
    }
}
