<?php

namespace CartApi\Service;

use CartApi\Filter\ShipmentFilter;
use CartApi\Model\CartItemsTable;
use CartApi\Model\CartTable;
use CartApi\Model\ShipmentTable;

class ShipmentService
{
    private $ShipmentTable;
    private $ShipmentFilter;
    private $CartItemsTable;
    private $CartTable;
    public function __construct(
        ShipmentTable $ShipmentTable,
        ShipmentFilter $ShipmentFilter,
        CartItemsTable $CartItemsTable,
        CartTable $CartTable
    ) {
        $this->ShipmentTable = $ShipmentTable;
        $this->ShipmentFilter = $ShipmentFilter;
        $this->CartItemsTable = $CartItemsTable;
        $this->CartTable = $CartTable;
    }

    public function computeShippingTotal($shippingMethod, $totalWeight)
    {
        $shippingTotal = [];
        $heaviestWeight = $this->ShipmentTable->getHeaviestWeightByShippingMethod($shippingMethod);
        $shipmentList = $this->ShipmentTable->getShipmentList();
        if($shippingMethod == "Ground" || $shippingMethod == "Expedited") {
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
         
        } else {
            return 0;
        }
    }

    public function updateShippingInCart($params)
    {
        $this->ShipmentFilter->setData($params);
        if (!$this->ShipmentFilter->isValid()) {
            return array("isValid" => false, "data" => $this->ShipmentFilter->getMessages());
        }
        $filteredParamData = $this->ShipmentFilter->getValues();
        $filteredParamData['shipping_total'] = $this->computeShippingTotal($filteredParamData['shipping_mehod'],
            $this->CartItemsTable->computeCartTotalWeightByCartId($filteredParamData['cart_id'])
        );
        $filteredParamData['total_amount'] = ($filteredParamData['shipping_total'] +
            $this->CartItemsTable->computeCartTotalPriceByCartId($filteredParamData['cart_id'])
        );

     
        $this->CartTable->updateCartShippingById($filteredParamData);

        var_dump($filteredParamData['total_amount']);
        exit;

       
    }
}
