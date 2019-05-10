<?php

namespace JobApi\ServiceFactory\Model;

use JobApi\Model\JobItems;
use JobApi\Model\JobItemsTable;
use Psr\Container\ContainerInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class JobItemsTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        // Creation for table gateway instance
        $dbAdapter = $container->get('shoppingcart');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new JobItems());
        // create TableGateway instance
        $tableGateway = new TableGateway(
            'job_items',
            $dbAdapter,
            null,
            $resultSetPrototype
        );
        // Create JobItemsTable instance
        return new JobItemsTable($tableGateway);
    }
}
