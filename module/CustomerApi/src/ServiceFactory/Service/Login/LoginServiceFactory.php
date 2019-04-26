<?php

namespace CustomerApi\ServiceFactory\Service\Login;

use CustomerApi\Filter\Login\LoginFilter;
use CustomerApi\Model\CustomersTable;
use CustomerApi\Service\Login\LoginService;
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
