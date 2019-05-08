<?php

namespace CartApi\Service;

use CartApi\Filter\CartFilter;
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
    private $CartFilter;
    public function __construct(
        ShipmentTable $ShipmentTable,
        ShipmentFilter $ShipmentFilter,
        CartItemsTable $CartItemsTable,
        CartTable $CartTable,
        CartFilter $CartFilter
    ) {
        $this->ShipmentTable = $ShipmentTable;
        $this->ShipmentFilter = $ShipmentFilter;
        $this->CartItemsTable = $CartItemsTable;
        $this->CartTable = $CartTable;
        $this->CartFilter = $CartFilter;
    }

    public function computeShippingTotal($shippingMethod, $totalWeight)
    {
        $roundedTotalWeight = round($totalWeight);
        $shippingTotal = [];
        $heaviestWeight = $this->ShipmentTable->getHeaviestWeightByShippingMethod($shippingMethod);
        $shipmentList = $this->ShipmentTable->getShipmentList();
        if ($shippingMethod == "Ground" || $shippingMethod == "Expedited") {
            while ($roundedTotalWeight > 0) {
                if ($heaviestWeight['max_weight'] <= $roundedTotalWeight) {
                    $roundedTotalWeight -= $heaviestWeight['max_weight'];
                    array_push($shippingTotal, $heaviestWeight['shipping_rate']);
                } else {
                    foreach ($shipmentList as $key => $row) {
                        if ($row['min_weight'] <= $roundedTotalWeight && $row['max_weight'] >= $roundedTotalWeight && $row['shipping_method'] == $shippingMethod) {
                            $roundedTotalWeight -= $row['max_weight'];
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
        return array("isValid" => true, "data" => "success");
    }

    public function getRatesPerShippingMethod($params)
    {
        $cartData = array("cart_id" => $params);
        $validation = $this->CartFilter->getCartFilter()->setData($cartData);
        if (!$validation->isValid()) {
            return array("isValid" => false, "data" => $validation->getMessages());
        } else {
            $existingCart = $this->CartTable->getCartByCartId($params);
            if (!$existingCart) {
                return array("isValid" => false, "data" => "Invalid cart id");
            }
            $filteredParamData = $validation->getValues();
            $shipmentMethods = $this->ShipmentTable->getShipmentMethod();
            foreach ($shipmentMethods as $shipmentMethod) {
                $data[$shipmentMethod] =  $this->computeShippingTotal($shipmentMethod,
                $this->CartItemsTable->computeCartTotalWeightByCartId($filteredParamData['cart_id']));
            }
            return array("isValid" => true, "data" => $data);
        }
    }
}
