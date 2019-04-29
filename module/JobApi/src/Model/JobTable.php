<?php

namespace JobApi\Model;

use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class JobTable
{
    private $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {

        $this->tableGateway = $tableGateway;

    }

    public function getJobListByCustomerId($id)
    {
        // return $this->tableGateway->select()->toArray();

        $select = $this->tableGateway->getSql()->select();
        $select->columns(array("*"));
        $select->join(
            array("ci" => "job_items"),
            "ci.job_id = jobs.job_id",
            array("*")
        )->where(array(
            "jobs.customer_id" => 1,
        ));

        $resultSet = $this->tableGateway->selectWith($select)->getDataSource();
        return $resultSet;

    }

    public function getJobByJobId($id)
    {
        return $this->tableGateway->select(['job_id' => $id])->current();
    }

    public function getJobByCustomerId($id)
    {
        return get_object_vars($this->tableGateway->select(['customer_id' => $id])->current());
    }

    public function addJob(Job $job)
    {
        $this->tableGateway->insert(get_object_vars($job));

        return $this->tableGateway->getLastInsertValue();
    }

    public function copyCartToJob($cartId)
    {
        //or this
        // INSERT INTO job ()
        // SELECT 2
        // FROM carts
        // WHERE carts.cart_id = 101
        $select = new Select('carts');
        $select->columns(array('customer_id', 'order_datetime', 'sub_total', 'taxable_amount', 'discount', 'tax',
            'shipping_total', 'total_amount', 'total_weight', 'company_name', 'email', 'first_name', 'last_name', 'phone',
            'shipping_mehod', 'shipping_name', 'shipping_address1', 'shipping_address2', 'shipping_address3', 'shipping_city',
            'shipping_state', 'shipping_country'))
            ->where(array("cart_id" => $cartId));

        $insert = new Insert();
        $insert->into('job_orders');
        $insert->columns(array('customer_id', 'order_datetime', 'sub_total', 'taxable_amount', 'discount', 'tax',
            'shipping_total', 'total_amount', 'total_weight', 'company_name', 'email', 'first_name', 'last_name', 'phone',
            'shipping_mehod', 'shipping_name', 'shipping_address1', 'shipping_address2', 'shipping_address3', 'shipping_city',
            'shipping_state', 'shipping_country'));
        $insert->values($select);
        $this->tableGateway->insertWith($insert);

        return $this->tableGateway->getLastInsertValue();
    }
}
