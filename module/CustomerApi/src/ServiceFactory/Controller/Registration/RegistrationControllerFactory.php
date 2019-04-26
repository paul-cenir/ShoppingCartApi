<?php

namespace CustomerApi\ServiceFactory\Controller\Registration;

use CustomerApi\Controller\Registration\RegistrationController;
use CustomerApi\Model\Customers;
use CustomerApi\Model\CustomersTable;
use CustomerApi\Service\AccessTokenService;
use CustomerApi\Service\Registration\RegistrationService;
use Psr\Container\ContainerInterface;

class RegistrationControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator(); // remove if zf3
        $CustomersTable = $container->get(CustomersTable::class);
        $Customers = $container->get(Customers::class);
        $RegistrationService = $container->get(RegistrationService::class);
        $AccessTokenService = $container->get(AccessTokenService::class);

        return new RegistrationController($Customers, $CustomersTable, $RegistrationService, $AccessTokenService);
    }
}
