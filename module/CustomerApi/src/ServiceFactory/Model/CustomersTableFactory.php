<?php

namespace CustomerApi\ServiceFactory\Model;

use CustomerApi\Model\Customers;
use CustomerApi\Model\CustomersTable;
use Psr\Container\ContainerInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class CustomersTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        // Creation for table gateway instance
        $dbAdapter = $container->get('shoppingcart');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Customers());
        // create TableGateway instance
        $tableGateway = new TableGateway(
            'customers',
            $dbAdapter,
            null,
            $resultSetPrototype
        );
        // Create AlbumTable instance
        return new CustomersTable($tableGateway);
    }
}
