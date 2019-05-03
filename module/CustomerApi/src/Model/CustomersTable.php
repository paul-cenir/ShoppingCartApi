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
        $customerDetais = $this->tableGateway->select(['customer_id' => $id])->current();
       
        return $customerDetais? get_object_vars($customerDetais) : $customerDetais;
    }

    public function getCustomerByEmail($email)
    {
        $data = $this->tableGateway->select(['email' => $email])->current();
        return $data ? get_object_vars($data) : $data;
    }

    public function registerCustomer(Customers $customer)
    {
        $this->tableGateway->insert(get_object_vars($customer));

        return $this->tableGateway->getLastInsertValue();
    }
}
