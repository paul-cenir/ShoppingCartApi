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
        $data = $this->tableGateway->select(['product_id' => $id])->current();
        return $data ? get_object_vars($data) : $data;
    }

}
