<?php

namespace CartApi\Model;

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

    public function getHeaviestWeightByShippingMethod($shippingMethod)
    {
        $sql = $this->tableGateway->getSql();
        $select = $sql->select()
            ->columns(
                array('max_weight' => new \Zend\Db\Sql\Expression('MAX(max_weight)'),
                    'shipping_rate' => new \Zend\Db\Sql\Expression('MAX(shipping_rate)'),
                )
            )
            ->where(array("shipping_method" => $shippingMethod));

        $rowData = $this->tableGateway->selectWith($select)->toArray();

        return $rowData[0];
    }
}
