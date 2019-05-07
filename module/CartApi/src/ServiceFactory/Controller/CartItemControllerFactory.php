<?php

namespace CartApi\ServiceFactory\Controller;

use CartApi\Controller\CartItemController;
use Psr\Container\ContainerInterface;
use CartApi\Service\CartItemService;

class CartItemControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator(); // remove if zf3
       
        $CartItemService = $container->get(CartItemService::class);
     
        return new CartItemController($CartItemService);
    }
}
