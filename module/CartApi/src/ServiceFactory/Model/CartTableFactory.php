<?php

namespace CartApi\ServiceFactory\Model;

use CartApi\Model\Cart;
use CartApi\Model\CartTable;
use Psr\Container\ContainerInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class CartTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
   
        // Creation for table gateway instance
        $dbAdapter = $container->get('shoppingcart');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Cart());
       
        // create TableGateway instance
        $tableGateway = new TableGateway(
            'carts',
            $dbAdapter,
            null,
            $resultSetPrototype
        );
      
     
        // Create AlbumTable instance
        return new CartTable($tableGateway);
    }
}
