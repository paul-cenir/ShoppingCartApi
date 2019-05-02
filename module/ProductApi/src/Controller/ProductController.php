<?php

namespace ProductApi\Controller;

use ProductApi\Model\ProductsTable;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class ProductController extends AbstractRestfulController
{
    // protected $eventIdentifier = 'SecuredController';

    private $ProductsTable;

    public function __construct(ProductsTable $ProductsTable)
    {
        $this->ProductsTable = $ProductsTable;
    }

    public function get($id)
    {
        return new JsonModel($this->ProductsTable->getProductById($id));
    }

    public function getList()
    {
        return new JsonModel($this->ProductsTable->getProductList());
    }

}
