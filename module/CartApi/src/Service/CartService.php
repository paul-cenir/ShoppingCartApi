<?php

namespace CartApi\Service;

use CartApi\Filter\CartFilter;
use CartApi\Model\Cart;
use CartApi\Model\CartItems;
use CartApi\Model\CartItemsTable;
use CartApi\Model\CartTable;
use CustomerApi\Model\Customers;
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
    private $Customers;
    public function __construct(
        CartTable $CartTable,
        CartFilter $CartFilter,
        ProductsTable $ProductTable,
        CustomersTable $CustomersTable,
        Cart $Cart,
        CartItems $CartItems,
        CartItemsTable $CartItemsTable,
        TokenService $TokenService,
        Customers $Customers
    ) {
        $this->CartTable = $CartTable;
        $this->CartFilter = $CartFilter;
        $this->ProductTable = $ProductTable;
        $this->CustomersTable = $CustomersTable;
        $this->Cart = $Cart;
        $this->CartItems = $CartItems;
        $this->CartItemsTable = $CartItemsTable;
        $this->TokenService = $TokenService;
        $this->Customers = $Customers;
    }

    public function addToCart($params, $accessToken)
    {
        $validation = $this->CartFilter->addCartFilter()->setData($params);
        if (!$validation->isValid()) {
            return array("isValid" => false, "data" => $validation->getMessages());
        } else {
            $filteredParamData = $validation->getValues();
            $filteredParamData['customer_id'] = $this->TokenService->getCutomerIdInAccessToken($accessToken);
            $existingCart = $this->CartTable->getCartByCartId($filteredParamData['cart_id']);
            $productDetails = $this->ProductTable->getProductById($filteredParamData['product_id']);
            $customer = $this->CustomersTable->getCustomerById($filteredParamData['customer_id']);
            if ($productDetails['stock_qty'] >= $filteredParamData['qty']) {
                if ($customer) {
                    $cartData = array_merge($customer, $filteredParamData);
                } else {
                    $cartData = $filteredParamData;
                    $this->Customers->exchangeArray([]);
                    $cartData = array_merge(get_object_vars($this->Customers), $filteredParamData);
                }
                if ($productDetails) {
                    $cartItemData = array_merge($productDetails, $filteredParamData);
                }
                $price = $productDetails['price'] * $filteredParamData['qty'];
                $weight = $productDetails['weight'] * $filteredParamData['qty'];
                $cartItemData['price'] = $price;
                $cartItemData['weight'] = $weight;
                if (!$existingCart) {
                    $cartData['sub_total'] = $price;
                    $cartData['total_amount'] = $price;
                    $this->Cart->exchangeArray($cartData);
                    $cartId = $this->CartTable->addCart($this->Cart);
                    $cartItemData['cart_id'] = $cartId;
                    $this->CartItems->exchangeArray($cartItemData);
                    $this->CartItemsTable->addCartItem($this->CartItems);
                    return array("isValid" => true, "data" => array("cartId" => $cartId));
                } else {
                    $existingCart = get_object_vars( $existingCart);
                    $newCartData = [];
                    $this->CartItems->exchangeArray($cartItemData);
                    $addedCartItem = $this->CartItemsTable->addCartItem($this->CartItems);
                    $subTotal = $this->CartItemsTable->computeCartTotalPriceByCartId($filteredParamData['cart_id']);
                    $totalWeight = $this->CartItemsTable->computeCartTotalWeightByCartId($filteredParamData['cart_id']);
                    $newCartData['sub_total'] = $subTotal;
                    $newCartData['total_amount'] = $subTotal + $existingCart['shipping_total'];
                    $newCartData['cart_id'] = $filteredParamData['cart_id'];
                    $newCartData['total_weight'] = $totalWeight;
                    $newCartData['customer_id'] = $filteredParamData['customer_id'];
                    $this->CartTable->updateCartById($newCartData);
                    return array("isValid" => true, "data" => array("cartItemId" => $addedCartItem));
                }
            } else {
                return array("isValid" => false, "data" => "insufficient stock");
            }
        }
    }

    public function getCart($params)
    {
        $cartData = array("cart_id" => $params);
        $validation = $this->CartFilter->getCartFilter()->setData($cartData);
      
        if (!$validation->isValid()) {
            return array("isValid" => false, "data" => $validation->getMessages());
        } else {
            $filteredParamData = $validation->getValues();
            $existingCart = $this->CartTable->getCartByCartId($filteredParamData['cart_id']);
            if (!$existingCart) {
                return array("isValid" => false, "data" => "Invalid cart id");
            }
            return array("isValid" => true, "data" => array(
                "cartItemData" => $this->CartItemsTable->getCartItemById($filteredParamData['cart_id']),
                "cartData" => $this->CartTable->getCartByCartId($filteredParamData['cart_id']),
            ));

        }
    }

    public function deleteCart($params)
    {
        $cartData = array("cart_id" => $params);
        $validation = $this->CartFilter->getCartFilter()->setData($cartData);
        if (!$validation->isValid()) {
            return array("isValid" => false, "data" => $validation->getMessages());
        } else {
            $filteredParamData = $validation->getValues();
            $existingCart = $this->CartTable->getCartByCartId($filteredParamData['cart_id']);

            if (!$existingCart) {
                return array("isValid" => false, "data" => "Invalid cart item id");
            } else {
                $this->CartTable->deleteCart($filteredParamData['cart_id']);
                $this->CartItemsTable->deleteCartItemByCartId($filteredParamData['cart_id']);
                return array("isValid" => true, "data" => ["success"]);
            }
        }
    }
}
