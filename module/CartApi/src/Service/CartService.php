<?php

namespace CartApi\Service;

use CartApi\Filter\CartFilter;
use CartApi\Model\Cart;
use CartApi\Model\CartItems;
use CartApi\Model\CartItemsTable;
use CartApi\Model\CartTable;
use CustomerApi\Model\CustomersTable;
use CustomerApi\Service\TokenService;
use ProductApi\Model\ProductsTable;

class CartService
{
    private $CartTable;
    private $CartFilter;
    private $ProductTable;
    private $CustomersTable;
    private $Cart;
    private $CartItems;
    private $CartItemsTable;
    private $TokenService;
    public function __construct(
        CartTable $CartTable,
        CartFilter $CartFilter,
        ProductsTable $ProductTable,
        CustomersTable $CustomersTable,
        Cart $Cart,
        CartItems $CartItems,
        CartItemsTable $CartItemsTable,
        TokenService $TokenService
    ) {
        $this->CartTable = $CartTable;
        $this->CartFilter = $CartFilter;
        $this->ProductTable = $ProductTable;
        $this->CustomersTable = $CustomersTable;
        $this->Cart = $Cart;
        $this->CartItems = $CartItems;
        $this->CartItemsTable = $CartItemsTable;
        $this->TokenService = $TokenService;
    }

    public function addToCart($params, $accessToken)
    {
        $accessToken = (array) $accessToken;
        var_dump($accessToken['value']);
        exit;
        if ($accessToken) {
            $customer_id = $this->TokenService->getCustomerId($accessToken);
            $params['customer_id'] = $customer_id;
        } else {
            $params['customer_id'] = 0;
        }
        var_dump($params['customer_id']);
        exit;
        $this->CartFilter->setData($params);
        if (!$this->CartFilter->isValid()) {
            return array("isValid" => false, "data" => $this->CartFilter->getMessages());
        } else {
            $filteredParamData = $this->CartFilter->getValues();
            $existingCart = $this->CartTable->getCartByCustomerId($filteredParamData['customer_id']);
            $productDetails = $this->ProductTable->getProductById($filteredParamData['product_id']);
            $customerDtetails = $this->CustomersTable->getCustomerById($filteredParamData['customer_id']);
            if ($productDetails['stock_qty'] >= $filteredParamData['qty']) {
                if ($customerDtetails && $filteredParamData) {
                    $cartData = array_merge($customerDtetails, $filteredParamData);
                }
                if ($productDetails && $filteredParamData) {
                    $cartItemData = array_merge($productDetails, $filteredParamData);
                }
                $price = $productDetails['price'] * $filteredParamData['qty'];
                $weight = $productDetails['weight'] * $filteredParamData['qty'];
                $cartItemData['price'] = $price;
                $cartItemData['weight'] = $weight;
                if (!$existingCart) {
                    $cartData['sub_total'] = $price;
                    $this->Cart->exchangeArray($cartData);
                    $cartId = $this->CartTable->addCart($this->Cart);
                    $cartItemData['cart_id'] = $cartId;
                    $this->CartItems->exchangeArray($cartItemData);
                    $this->CartItemsTable->addCartItem($this->CartItems);
                    return array("isValid" => true,
                        "data" => array(
                            "cartId" => $cartId,
                        ),
                    );
                } else {
                    $newCartData = [];
                    $cartItemData['cart_id'] = $existingCart['cart_id'];
                    $this->CartItems->exchangeArray($cartItemData);
                    $addedCartItem = $this->CartItemsTable->addCartItem($this->CartItems);
                    $subTotal = $this->CartItemsTable->computeCartTotalPriceByCartId($existingCart['cart_id']);
                    $totalWeight = $this->CartItemsTable->computeCartTotalWeightByCartId($existingCart['cart_id']);
                    $newCartData['sub_total'] = $subTotal;
                    $newCartData['cart_id'] = $existingCart['cart_id'];
                    $newCartData['total_weight'] = $totalWeight;
                    $this->CartTable->updateCartById($newCartData);
                    return array("isValid" => true, "data" => $addedCartItem);
                }
            } else {
                return array("isValid" => false, "data" => "insufficient stock");
            }
        }
    }
}
