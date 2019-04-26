<?php

namespace CustomerApi\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\View\Model\JsonModel;

class CustomersTable
{

    private $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {

        $this->tableGateway = $tableGateway;

    }

    public function getAll()
    {
        return $this->tableGateway->select()->toArray();
    }

    public function getCustomerById($id)
    {
        return $this->tableGateway->select(['customer_id' => $id])->current();
    }

    public function getCustomerByEmail($email)
    {
        return $this->tableGateway->select(['email' => $email])->current();
    }

    public function registerCustomer(Customers $customer)
    {

        $insertData = get_object_vars($customer);
       

        $this->tableGateway->insert($insertData);
     
        return  $this->tableGateway->getLastInsertValue();
    }
}
