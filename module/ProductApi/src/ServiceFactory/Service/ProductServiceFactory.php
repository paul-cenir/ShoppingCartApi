<?php

namespace ProductApi\ServiceFactory\Service;

use ProductApi\Filter\ProductFilter;
use ProductApi\Model\ProductsTable;
use ProductApi\Service\ProductService;
use Psr\Container\ContainerInterface;

class ProductServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $ProductsTable = $container->get(ProductsTable::class);
        $ProductFilter = $container->get(ProductFilter::class);
      
        return new ProductService($ProductsTable, $ProductFilter);
    }
}
