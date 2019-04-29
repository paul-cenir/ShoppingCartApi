<?php

namespace JobApi\Service;

use JobApi\Model\ShipmentTable;

class ShipmentService
{
    private $ShipmentTable;
    public function __construct(
        ShipmentTable $ShipmentTable
    ) {
        $this->ShipmentTable = $ShipmentTable;
    }

    public function countShippingTotal()
    {
      
        //get total weight in all cart items
        //get shipping method
        //find the range base on the range of min  and max
        //if
        $totalWeight = 41;
        $shippingMethod = 'Ground';
        $shipmentList = $this->ShipmentTable->getShipmentList();

        foreach ($shipmentList as $key => $row) {
            
            if($row['min_weight'] <= $totalWeight && $row['max_weight'] >= $totalWeight && $row['shipping_method'] == $shippingMethod ) {
                \Zend\Debug\Debug::dump($row['shipping_rate']);
            }

          
        }
        exit;

        $totalWeight = 80;
        while ($x <= 5) {

        }

    }

}
