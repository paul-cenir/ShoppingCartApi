<?php

namespace CartApi\ServiceFactory\Model;

use CartApi\Model\CartItems;
use CartApi\Model\CartItemsTable;
use Psr\Container\ContainerInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class CartItemsTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
   
        // Creation for table gateway instance
        $dbAdapter = $container->get('shoppingcart');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new CartItems());
       
        // create TableGateway instance
        $tableGateway = new TableGateway(
            'cart_items',
            $dbAdapter,
            null,
            $resultSetPrototype
        );
      
        // Create CartItemsTable instance
        return new CartItemsTable($tableGateway);
    }
}
