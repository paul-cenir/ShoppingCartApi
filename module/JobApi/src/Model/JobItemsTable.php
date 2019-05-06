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
            ->where(array("job_order_id" => $id));

        $rowData = $this->tableGateway->selectWith($select)->toArray();
        return $rowData;
    }

    public function copyCartItemsToJobItems($cartId, $jobOrderId)
    {
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

    public function getJobItemById($id)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->columns(array(
            "job_item_id" => "job_item_id",
            "job_order_id" => "job_order_id",
            "product_id" => "product_id",
            "weight" => "weight",
            "qty" => "qty",
            "unit_price" => "unit_price",
            "sub_total" => "price",
        ));
        $select->join(
            array("p" => "products"),
            "p.product_id = job_items.product_id",
            array("*")
        )
        ->where(array(
            "job_items.job_order_id" => $id,
        ));

        $resultSet = $this->tableGateway->selectWith($select)->getDataSource();
        $data = array();
        foreach ($resultSet as $row) {
            array_push($data,$row);
        }
        return $data; 
    }
}
