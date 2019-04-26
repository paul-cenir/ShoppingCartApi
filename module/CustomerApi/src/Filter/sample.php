<?php

namespace ProductApi\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use ProductApi\Model\ProductsTable;

class ProductController extends AbstractRestfulController
{
    

    private $ProductsTable;

    public function __construct(ProductsTable $ProductsTable)
    {
      
        $this->ProductsTable = $ProductsTable;
    }

    public function get($id)
    {

        return new JsonModel([]);
    }

    public function getList()
    {
      
        \Zend\Debug\Debug::dump( $this->ProductsTable->getAll());
        exit;
    }

    public function update($id, $data)
    {

        \Zend\Debug\Debug::dump('update');
        exit;
    }

    public function delete($id)
    {
        \Zend\Debug\Debug::dump('delete');
        exit;
    }


}
