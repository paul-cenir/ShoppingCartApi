<?php

namespace CustomerApi\ServiceFactory\Service\Registration;

use CustomerApi\Filter\Registration\RegistrationFilter;
use CustomerApi\Model\CustomersTable;
use CustomerApi\Service\Registration\RegistrationService;
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
