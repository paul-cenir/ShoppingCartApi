<?php

namespace CartApi\ServiceFactory\Model;

use CartApi\Model\Shipment;
use CartApi\Model\ShipmentTable;
use Psr\Container\ContainerInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class ShipmentTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        // Creation for table gateway instance
        $dbAdapter = $container->get('shoppingcart');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Shipment());
       
        // create TableGateway instance
        $tableGateway = new TableGateway(
            'shipping',
            $dbAdapter,
            null,
            $resultSetPrototype
        );
        // Create ShipmentTable instance
        return new ShipmentTable($tableGateway);
    }
}
