<?php

namespace JobApi\Model;

use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class JobItemsTable
{
    private $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {

        $this->tableGateway = $tableGateway;

    }

    public function getJobItemList()
    {
        return $this->tableGateway->select()->toArray();
    }

    public function getJobItemByItemId($id)
    {
        return $this->tableGateway->select(['Job_item_id' => $id])->current();
    }

    public function addJobItem(JobItems $Job)
    {
        $this->tableGateway->insert(get_object_vars($Job));
        return $this->tableGateway->getLastInsertValue();
    }

    public function countJobTotalPriceByJobId($id)
    {
        $sql = $this->tableGateway->getSql();
        $select = $sql->select()
            ->columns(array('price' => new \Zend\Db\Sql\Expression('SUM(price)')))
            ->where(array("Job_id" => $id));

        $rowData = $this->tableGateway->selectWith($select)->toArray();
        return $rowData;
    }

    public function copyCartItemsToJobItems($cartId, $jobOrderId)
    {
        // INSERT INTO job_items (job_order_id, product_id, weight, qty,unit_price,price)
        // SELECT 2, cart_items.product_id,cart_items.weight,cart_items.qty,cart_items.unit_price,cart_items.price
        // FROM cart_items
        // WHERE cart_items.cart_id = 101
        $cartId = $cartId;
        $jobOrderId = strval($jobOrderId);
        $select = new Select('cart_items');
        $select->columns(array('job_order_id' => new \Zend\Db\Sql\Expression($jobOrderId), 'product_id', 'weight', 'qty', 'unit_price', 'price'))
            ->where(array("cart_id" => $cartId));
        $insert = new Insert();
        $insert->into('job_items');
        $insert->columns(array('job_order_id', 'product_id', 'weight', 'qty', 'unit_price', 'price'));
        $insert->values($select);
        $this->tableGateway->insertWith($insert);
        return $this->tableGateway->getLastInsertValue();
    }

}
