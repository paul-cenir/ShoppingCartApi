<?php

namespace ProductApi\ServiceFactory\Controller;

use ProductApi\Controller\ProductController;
use ProductApi\Model\ProductsTable;
use ProductApi\Service\ProductService;
use Psr\Container\ContainerInterface;

class ProductControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator(); // remove if zf3
        $ProductsTable = $container->get(ProductsTable::class);
        $ProductService = $container->get(ProductService::class);

        return new ProductController($ProductsTable, $ProductService);
    }
}
