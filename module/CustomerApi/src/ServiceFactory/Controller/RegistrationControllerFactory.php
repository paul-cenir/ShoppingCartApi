<?php

namespace CustomerApi\ServiceFactory\Controller;

use CustomerApi\Controller\RegistrationController;
use CustomerApi\Service\RegistrationService;
use Psr\Container\ContainerInterface;

class RegistrationControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator(); // remove if zf3
        $RegistrationService = $container->get(RegistrationService::class);

        return new RegistrationController($RegistrationService);
    }
}
