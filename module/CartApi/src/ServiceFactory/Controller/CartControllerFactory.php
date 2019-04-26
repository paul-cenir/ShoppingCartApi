<?php

namespace CartApi\ServiceFactory\Controller;

use CartApi\Controller\CartController;
use CartApi\Model\CartTable;
use Psr\Container\ContainerInterface;

class CartControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator(); // remove if zf3
        $CartTable = $container->get(CartTable::class);

        return new CartController($CartTable);
    }
}
