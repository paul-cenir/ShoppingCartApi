<?php

namespace CartApi\ServiceFactory\Service;

use CartApi\Filter\CartFilter;
use CartApi\Model\Cart;
use CartApi\Model\CartItems;
use CartApi\Model\CartItemsTable;
use CartApi\Model\CartTable;
use CartApi\Service\CartService;
use CustomerApi\Model\Customers;
use CustomerApi\Model\CustomersTable;
use CustomerApi\Service\TokenService;
use ProductApi\Model\ProductsTable;
use Psr\Container\ContainerInterface;

class CartServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $CartTable = $container->get(CartTable::class);
        $CartFilter = $container->get(CartFilter::class);
        $ProductsTable = $container->get(ProductsTable::class);
        $CustomersTable = $container->get(CustomersTable::class);
        $Cart = $container->get(Cart::class);
        $CartItems = $container->get(CartItems::class);
        $CartItemsTable = $container->get(CartItemsTable::class);
        $TokenService = $container->get(TokenService::class);
        $Customers = $container->get(Customers::class);

        return new CartService(
            $CartTable,
            $CartFilter,
            $ProductsTable,
            $CustomersTable,
            $Cart,
            $CartItems,
            $CartItemsTable,
            $TokenService,
            $Customers
        );
    }
}
