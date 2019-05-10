<?php

namespace ProductApi\Controller;

use ProductApi\Model\ProductsTable;
use ProductApi\Service\ProductService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class ProductController extends AbstractRestfulController
{
    private $ProductsTable;
    private $ProductService;

    public function __construct(ProductsTable $ProductsTable, ProductService $ProductService)
    {
        $this->ProductsTable = $ProductsTable;
        $this->ProductService = $ProductService;
    }

    public function get($id)
    {
        $product = $this->ProductService->getProduct($id);
        if (!$product['isValid']) {
            $this->getResponse()->setStatusCode(400);
            return new JsonModel(["validation_error_messages" => $product['data']]);
        } else {
            return new JsonModel([
                "data" => $product['data'],
            ]);
        }
    }

    public function getList()
    {
        return new JsonModel($this->ProductsTable->getProductList());
    }

}
