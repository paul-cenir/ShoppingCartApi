<?php

namespace CartApi\Model;

use Zend\Db\TableGateway\TableGateway;

class CartTable
{
    private $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
     
        $this->tableGateway = $tableGateway;
     
    }

    public function getCartList()
    {
        return $this->tableGateway->select()->toArray();
    }

    public function getCartById($id)
    {
        return $this->tableGateway->select(['Cart_id' => $id])->current();
    }

}
