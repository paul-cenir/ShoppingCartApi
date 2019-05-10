<?php

namespace CustomerApi\ServiceFactory\Service;

use CustomerApi\Filter\RegistrationFilter;
use CustomerApi\Model\Customers;
use CustomerApi\Model\CustomersTable;
use CustomerApi\Service\RegistrationService;
use CustomerApi\Service\TokenService;
use Psr\Container\ContainerInterface;

class RegistrationServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $CustomersTable = $container->get(CustomersTable::class);
        $RegistrationFilter = $container->get(RegistrationFilter::class);
        $TokenService = $container->get(TokenService::class);
        $Customers = $container->get(Customers::class);

        return new RegistrationService($CustomersTable, $RegistrationFilter, $TokenService, $Customers);

    }
}
