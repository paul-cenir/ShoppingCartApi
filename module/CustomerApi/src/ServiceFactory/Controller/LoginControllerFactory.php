<?php

namespace CustomerApi\ServiceFactory\Controller;

use CustomerApi\Controller\LoginController;
use CustomerApi\Service\LoginService;
use CustomerApi\Service\TokenService;
use Psr\Container\ContainerInterface;

class LoginControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator(); // remove if zf3
        $LoginService = $container->get(LoginService::class);
        $TokenService = $container->get(TokenService::class);

        return new LoginController($LoginService, $TokenService);
    }
}
