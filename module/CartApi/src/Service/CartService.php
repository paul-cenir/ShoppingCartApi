<?php

namespace CartApi\Service;

use CartApi\Filter\CartFilter;
use CartApi\Model\Cart;
use CartApi\Model\CartItems;
use CartApi\Model\CartItemsTable;
use CartApi\Model\CartTable;
use CustomerApi\Model\CustomersTable;
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
    public function __construct(
        CartTable $CartTable,
        CartFilter $CartFilter,
        ProductsTable $ProductTable,
        CustomersTable $CustomersTable,
        Cart $Cart,
        CartItems $CartItems,
        CartItemsTable $CartItemsTable
    ) {
        $this->CartTable = $CartTable;
        $this->CartFilter = $CartFilter;
        $this->ProductTable = $ProductTable;
        $this->CustomersTable = $CustomersTable;
        $this->Cart = $Cart;
        $this->CartItems = $CartItems;
        $this->CartItemsTable = $CartItemsTable;
    }

    public function addToCart($params)
    {

        $this->CartFilter->setData($params);
        $filteredParamData = $this->CartFilter->getValues();

        if (!$this->CartFilter->isValid()) {
            return array("isValid" => false, "data" => $this->CartFilter->getMessages());

        } else {
            $existingCart = $this->CartTable->getCartByCustomerId(37);
            $productDetails = $this->ProductTable->getProductById($filteredParamData['product_id']);
            $customerDtetails = $this->CustomersTable->getCustomerById(1);
            $cartData = array_merge($customerDtetails, $filteredParamData);
            $cartData['customer_id'] = 37;
            $cartData['order_datetime'] = date("Y-m-d H:i:s");
            $sub_total = $productDetails['price'] * $filteredParamData['qty'];
            $cartData['sub_total'] = $sub_total;  //compute sub_total not yet done
            $filteredParamData['weight'] = $productDetails['weight'];
            $filteredParamData['price'] = $productDetails['price'];
            $filteredParamData['unit_price'] = $productDetails['price'];

            if (!$existingCart) {

                //insert in cart table and cart items
                //customer_id  save in  carts return cart_id
                //save  cart_id,product_id and quantity in cart_items
                $this->Cart->exchangeArray($cartData);
                $cartId = $this->CartTable->addCart($this->Cart);
                $filteredParamData['cart_id'] = $cartId;
                $this->CartItems->exchangeArray($filteredParamData);
                return $this->CartItemsTable->addCartItem($this->CartItems);

            } else {
              
                //get existing cart_id
                //save  cart_id,product_id and quantity in cart_items
                //else insert only in cart items
                $cartData['sub_total'] = $sub_total;
                $filteredParamData['cart_id'] = $existingCart['cart_id'];
                $this->CartItems->exchangeArray($filteredParamData);
                var_dump( $this->CartItemsTable->addCartItem($this->CartItems));
                exit;
                return;

            }
        }

    }

}
