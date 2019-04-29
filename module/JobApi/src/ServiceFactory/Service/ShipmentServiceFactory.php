<?php

namespace JobApi\ServiceFactory\Service;

use JobApi\Model\ShipmentTable;
use JobApi\Service\ShipmentService;
use Psr\Container\ContainerInterface;


class ShipmentServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
       
        $ShipmentTable = $container->get(ShipmentTable::class);
     
        return new ShipmentService($ShipmentTable);
    }
}
