<?php

namespace CustomerApi\Model;

use Zend\Db\TableGateway\TableGateway;

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
        return get_object_vars($this->tableGateway->select(['customer_id' => $id])->current());
    }

    public function getCustomerByEmail($email)
    {
        return$this->tableGateway->select(['email' => $email])->current();
    }

    public function registerCustomer(Customers $customer)
    {
        $this->tableGateway->insert(get_object_vars($customer));

        return $this->tableGateway->getLastInsertValue();
    }
}
