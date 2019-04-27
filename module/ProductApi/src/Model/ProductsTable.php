<?php

namespace ProductApi\Model;

use Zend\Db\TableGateway\TableGateway;

class ProductsTable
{
    private $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {

        $this->tableGateway = $tableGateway;

    }

    public function getProductList()
    {
        return $this->tableGateway->select()->toArray();
    }

    public function getProductById($id)
    {
        return get_object_vars($this->tableGateway->select(['product_id' => $id])->current());
    }

}
