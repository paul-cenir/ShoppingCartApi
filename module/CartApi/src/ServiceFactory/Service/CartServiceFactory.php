<?php


namespace CartApi\ServiceFactory\Service;


use CartApi\Service\CartService;
use Psr\Container\ContainerInterface;
use CartApi\Model\CartTable;
use CartApi\Filter\CartFilter;
use ProductApi\Model\ProductsTable;
use CustomerApi\Model\CustomersTable;
use CartApi\Model\Cart;
use CartApi\Model\CartItems;
use CartApi\Model\CartItemsTable;

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

        return new CartService($CartTable, $CartFilter,$ProductsTable, $CustomersTable, $Cart, $CartItems, $CartItemsTable);
    }
}
