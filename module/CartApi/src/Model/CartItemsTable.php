<?php

namespace CartApi\Model;

use Zend\Db\TableGateway\TableGateway;

class CartItemsTable
{
    private $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
     
        $this->tableGateway = $tableGateway;
     
    }

    public function getCartItemList()
    {
        return $this->tableGateway->select()->toArray();
    }

    public function getCartItemByItemId($id)
    {
        return $this->tableGateway->select(['cart_item_id' => $id])->current();
    }

    public function addCartItem(CartItems $cart)
    {
        $this->tableGateway->insert(get_object_vars($cart));
        return $this->tableGateway->getLastInsertValue();
    }

}
