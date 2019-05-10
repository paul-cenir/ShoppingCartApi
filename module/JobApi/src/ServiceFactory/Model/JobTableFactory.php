<?php

namespace JobApi\ServiceFactory\Model;

use JobApi\Model\Job;
use JobApi\Model\JobTable;
use Psr\Container\ContainerInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class JobTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        // Creation for table gateway instance
        $dbAdapter = $container->get('shoppingcart');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Job());
        // create TableGateway instance
        $tableGateway = new TableGateway(
            'job_orders',
            $dbAdapter,
            null,
            $resultSetPrototype
        );
        // Create AlbumTable instance
        return new JobTable($tableGateway);
    }
}
