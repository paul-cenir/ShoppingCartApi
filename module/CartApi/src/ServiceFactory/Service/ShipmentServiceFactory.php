<?php

namespace CartApi\ServiceFactory\Service;

use CartApi\Filter\ShipmentFilter;
use CartApi\Model\CartItemsTable;
use CartApi\Model\CartTable;
use CartApi\Model\ShipmentTable;
use CartApi\Service\ShipmentService;
use Psr\Container\ContainerInterface;

class ShipmentServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $ShipmentTable = $container->get(ShipmentTable::class);
        $ShipmentFilter = $container->get(ShipmentFilter::class);
        $CartItemsTable = $container->get(CartItemsTable::class);
        $CartTable = $container->get(CartTable::class);

        return new ShipmentService($ShipmentTable, $ShipmentFilter, $CartItemsTable, $CartTable);
    }
}
