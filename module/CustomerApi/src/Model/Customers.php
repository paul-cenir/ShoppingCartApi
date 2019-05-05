<?php

namespace CustomerApi\Model;

class Customers
{
    public $customer_id;
    public $email;
    public $password;
    public $company_name;
    public $first_name;
    public $last_name;
    public $phone;

    public function exchangeArray(array $data)
    {
        $this->customer_id = !empty($data['customer_id']) ? $data['customer_id'] : 0;
        $this->email = !empty($data['email']) ? $data['email'] : 'ND';
        $this->password = !empty($data['password']) ? $data['password'] : 'ND';
        $this->company_name = !empty($data['company_name']) ? $data['company_name'] : 'ND';
        $this->first_name = !empty($data['first_name']) ? $data['first_name'] : 'ND';
        $this->last_name = !empty($data['last_name']) ? $data['last_name'] : 'ND';
        $this->phone = !empty($data['phone']) ? $data['phone'] : 'ND';
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
