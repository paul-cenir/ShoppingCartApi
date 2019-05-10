<?php

namespace ProductApi\Service;

use ProductApi\Filter\ProductFilter;
use ProductApi\Model\ProductsTable;

class ProductService
{
    private $ProductFilter;
    private $ProductsTable;
    public function __construct(
        ProductsTable $ProductsTable,
        ProductFilter $ProductFilter
    ) {
        $this->ProductsTable = $ProductsTable;
        $this->ProductFilter = $ProductFilter;
    }

    public function getProduct($params)
    {
        $productData = array("product_id" => $params);
        $this->ProductFilter->setData($productData);
        if (!$this->ProductFilter->isValid()) {
            return array("isValid" => false, "data" => $this->ProductFilter->getMessages());
        }
        $filteredParamData = $this->ProductFilter->getValues();
        $product = $this->ProductsTable->getProductById($filteredParamData['product_id']);
        if (!$product) {
            return array("isValid" => false, "data" => "Invalid product id");
        } else {
            return array("isValid" => true, "data" => $product);
        }
    }
}
