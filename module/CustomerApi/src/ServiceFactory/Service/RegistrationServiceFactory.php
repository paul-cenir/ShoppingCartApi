<?php

namespace CustomerApi\ServiceFactory\Service;

use CustomerApi\Filter\RegistrationFilter;
use CustomerApi\Model\CustomersTable;
use CustomerApi\Service\RegistrationService;
use Psr\Container\ContainerInterface;

class RegistrationServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $CustomersTable = $container->get(CustomersTable::class);
        $RegistrationFilter = $container->get(RegistrationFilter::class);

        return new RegistrationService($CustomersTable, $RegistrationFilter);

    }
}
