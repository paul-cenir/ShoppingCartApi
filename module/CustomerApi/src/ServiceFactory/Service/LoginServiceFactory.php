<?php

namespace CustomerApi\ServiceFactory\Service;

use CustomerApi\Filter\LoginFilter;
use CustomerApi\Model\CustomersTable;
use CustomerApi\Service\LoginService;
use Psr\Container\ContainerInterface;

class LoginServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $CustomersTable = $container->get(CustomersTable::class);
        $LoginFilter = $container->get(LoginFilter::class);

        return new LoginService($CustomersTable, $LoginFilter);

    }
}
