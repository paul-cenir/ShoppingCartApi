<?php

namespace CartApi\ServiceFactory\Controller;

use CartApi\Controller\CartController;
use Psr\Container\ContainerInterface;
use CartApi\Service\CartService;

class CartControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator(); // remove if zf3
        $CartService = $container->get(CartService::class);
      
        return new CartController($CartService);
    }
}
