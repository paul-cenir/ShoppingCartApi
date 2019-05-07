<?php

namespace CartApi\ServiceFactory\Service;

use CartApi\Filter\CartItemFilter;
use CartApi\Model\CartItemsTable;
use CartApi\Model\CartTable;
use CartApi\Service\CartItemService;
use CartApi\Service\ShipmentService;
use Psr\Container\ContainerInterface;

class CartItemServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $CartItemsTable = $container->get(CartItemsTable::class);
        $CartItemFilter = $container->get(CartItemFilter::class);
        $CartTable = $container->get(CartTable::class);
        $ShipmentService = $container->get(ShipmentService::class);
        return new CartItemService($CartItemsTable, $CartItemFilter, $CartTable, $ShipmentService);
    }
}
