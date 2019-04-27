<?php

namespace CartApi\ServiceFactory\Controller;

use CartApi\Controller\CartController;
use CartApi\Model\CartTable;
use Psr\Container\ContainerInterface;
use CartApi\Model\CartItemsTable;
use CartApi\Service\CartService;

class CartControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator(); // remove if zf3
        $CartTable = $container->get(CartTable::class);
        $CartItemsTable = $container->get(CartItemsTable::class);
        $CartService = $container->get(CartService::class);
      
        return new CartController($CartTable, $CartItemsTable, $CartService);
    }
}
