<?php

namespace CartApi\Service;

use CartApi\Filter\CartItemFilter;
use CartApi\Model\CartItemsTable;
use CartApi\Model\CartTable;
use CartApi\Service\ShipmentService;

class CartItemService
{
    private $CartItemsTable;
    private $CartItemFilter;
    private $CartTable;
    private $ShipmentService;
    public function __construct(
        CartItemsTable $CartItemsTable,
        CartItemFilter $CartItemFilter,
        CartTable $CartTable,
        ShipmentService $ShipmentService
    ) {
        $this->CartItemsTable = $CartItemsTable;
        $this->CartItemFilter = $CartItemFilter;
        $this->CartTable = $CartTable;
        $this->ShipmentService = $ShipmentService;
    }

    public function deleteCartItem($params)
    {

        $cartData = array("cart_item_id" => $params);
        $validation = $this->CartItemFilter->getCartItemFilter()->setData($cartData);

        if (!$validation->isValid()) {
            return array("isValid" => false, "data" => $validation->getMessages());
        } else {
            $filteredParamData = $validation->getValues();
            $existingCartItem = $this->CartItemsTable->getCartItemId($filteredParamData['cart_item_id']);

            if (!$existingCartItem) {
                return array("isValid" => false, "data" => "Invalid cart item id");
            } else {

                $cart = $this->CartTable->getCartByCartId($existingCartItem->cart_id);
                $totalWeight = $this->CartItemsTable->computeCartTotalWeightByCartId($existingCartItem->cart_id);
                $subTotal = $this->CartItemsTable->computeCartTotalPriceByCartId($existingCartItem->cart_id);
                $data = [
                    'sub_total' => $subTotal,
                    'shipping_total' => $cart->shipping_total,
                    'total_amount' => $subTotal + $cart->shipping_total,
                    'total_weight' => $totalWeight,
                    'cart_id' => $existingCartItem->cart_id,
                ];
                $this->CartItemsTable->deleteCartItem($filteredParamData['cart_item_id']);
                $this->CartTable->updateCartById($data);
                return array("isValid" => true, "data" => ["success"]);
            }
        }
    }
}
