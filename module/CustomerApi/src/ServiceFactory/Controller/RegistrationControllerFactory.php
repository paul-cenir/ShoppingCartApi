<?php

namespace CustomerApi\ServiceFactory\Controller;

use CustomerApi\Controller\RegistrationController;
use CustomerApi\Model\Customers;
use CustomerApi\Model\CustomersTable;
use CustomerApi\Service\TokenService;
use CustomerApi\Service\RegistrationService;
use Psr\Container\ContainerInterface;

class RegistrationControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator(); // remove if zf3
        $CustomersTable = $container->get(CustomersTable::class);
        $Customers = $container->get(Customers::class);
        $RegistrationService = $container->get(RegistrationService::class);
        $TokenService = $container->get(TokenService::class);

        return new RegistrationController($Customers, $CustomersTable, $RegistrationService, $TokenService);
    }
}
