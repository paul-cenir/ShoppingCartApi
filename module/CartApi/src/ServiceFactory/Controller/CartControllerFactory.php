<?php

namespace CartApi\ServiceFactory\Controller;

use CartApi\Controller\CartController;
use CartApi\Service\CartService;
use Psr\Container\ContainerInterface;

class CartControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator(); // remove if zf3
        $CartService = $container->get(CartService::class);

        return new CartController($CartService);
    }
}
