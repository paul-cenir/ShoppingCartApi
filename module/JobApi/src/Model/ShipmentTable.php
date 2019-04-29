<?php

namespace JobApi\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class ShipmentTable
{
    private $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {

        $this->tableGateway = $tableGateway;

    }

    public function getShipmentList()
    {
        return $this->tableGateway->select()->toArray();
    }

}
