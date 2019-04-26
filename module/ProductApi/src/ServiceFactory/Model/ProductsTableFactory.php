<?php

namespace ProductApi\ServiceFactory\Model;

use ProductApi\Model\Products;
use ProductApi\Model\ProductsTable;
use Psr\Container\ContainerInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class ProductsTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        
        // Creation for table gateway instance
        $dbAdapter = $container->get('shoppingcart');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Products());

        // create TableGateway instance
        $tableGateway = new TableGateway(
            'products',
            $dbAdapter,
            null,
            $resultSetPrototype
        );
   
     
        // Create AlbumTable instance
        return new ProductsTable($tableGateway);
    }
}
