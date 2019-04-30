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

    public function computeShippingTotal()
    {
        $shippingMethod = 'Expedited';
        $totalWeight = 40;
        $shippingTotal = [];
        $heaviestWeight = $this->ShipmentTable->getHeaviestWeightByShippingMethod($shippingMethod);
        $shipmentList = $this->ShipmentTable->getShipmentList();

        while ($totalWeight > 0) {
            if ($heaviestWeight['max_weight'] <= $totalWeight) {
                $totalWeight -= $heaviestWeight['max_weight'];
                array_push($shippingTotal, $heaviestWeight['shipping_rate']);
            } else {
                foreach ($shipmentList as $key => $row) {
                    if ($row['min_weight'] <= $totalWeight && $row['max_weight'] >= $totalWeight && $row['shipping_method'] == $shippingMethod) {
                        $totalWeight -= $row['max_weight'];
                        array_push($shippingTotal, $row['shipping_rate']);
                    }
                }
            }
        }
        return array_sum($shippingTotal);
    }
}
