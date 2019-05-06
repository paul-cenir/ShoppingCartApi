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

    public function getCartItemById($id)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->columns(array(
            "cart_item_id" => "cart_item_id",
            "cart_id" => "cart_id",
            "product_id" => "product_id",
            "weight" => "weight",
            "qty" => "qty",
            "unit_price" => "unit_price",
            "sub_total" => "price",
        ));
        $select->join(
            array("p" => "products"),
            "p.product_id = cart_items.product_id",
            array("*")
        )
        ->where(array(
            "cart_items.cart_id" => $id,
        ));

        $resultSet = $this->tableGateway->selectWith($select)->getDataSource();
        $data = array();
        foreach ($resultSet as $row) {
            array_push($data,$row);
        }
        return $data; 
    }

    public function addCartItem(CartItems $cart)
    {
        $this->tableGateway->insert(get_object_vars($cart));
        return $this->tableGateway->getLastInsertValue();
    }

    public function computeCartTotalPriceByCartId($id)
    {
        $sql = $this->tableGateway->getSql();
        $select = $sql->select()
            ->columns(array('price' => new \Zend\Db\Sql\Expression('SUM(price)')))
            ->where(array("cart_id" => $id));

        $subTotal = $this->tableGateway->selectWith($select)->toArray();

        return $subTotal[0]['price'];
    }

    public function computeCartTotalWeightByCartId($id)
    {
        $sql = $this->tableGateway->getSql();
        $select = $sql->select()
            ->columns(array('weight' => new \Zend\Db\Sql\Expression('SUM(weight)')))
            ->where(array("cart_id" => $id));

        $subTotal = $this->tableGateway->selectWith($select)->toArray();

        return $subTotal[0]['weight'];
    }
    

}
