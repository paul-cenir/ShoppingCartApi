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

    public function getCartListByCustomerId($id)
    {
        // return $this->tableGateway->select()->toArray();
     
        $select = $this->tableGateway->getSql()->select();
        $select->columns(array("*"));
        $select->join(
            array("ci" => "cart_items"),
            "ci.cart_id = carts.cart_id",
            array("*")
        )->where(array(
            "carts.customer_id" => 1
        ));

        $resultSet = $this->tableGateway->selectWith($select)->getDataSource();
        return $resultSet;
       
    }

    public function getCartByCartId($id)
    {
        return $this->tableGateway->select(['cart_id' => $id])->current();
    }

    public function getCartByCustomerId($id)
    {
        return get_object_vars($this->tableGateway->select(['customer_id' => $id])->current());
    }

    public function addCart(Cart $cart)
    {
        $this->tableGateway->insert(get_object_vars($cart));

        return $this->tableGateway->getLastInsertValue();
    }

}
