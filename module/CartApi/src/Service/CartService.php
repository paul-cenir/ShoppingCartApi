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
            
            $existingCart = $this->CartTable->getCartByCustomerId($filteredParamData['customer_id']);
            $productDetails = $this->ProductTable->getProductById($filteredParamData['product_id']);
            $customerDtetails = $this->CustomersTable->getCustomerById($filteredParamData['customer_id']);
            $cartData = array_merge($customerDtetails, $filteredParamData);
            $cartItemData = array_merge($productDetails, $filteredParamData);
            $sub_total = $productDetails['price'] * $filteredParamData['qty'];

            if (!$existingCart) {
                //insert in cart table and cart items
                //customer_id  save in  carts return cart_id
                //save  cart_id,product_id and quantity in cart_items
                $cartData['sub_total'] = $sub_total;
                $cartData['total_amount'] = $sub_total;
                $this->Cart->exchangeArray($cartData);
                $cartId = $this->CartTable->addCart($this->Cart);
                $cartItemData['cart_id'] = $cartId;
                $this->CartItems->exchangeArray($cartItemData);
                return array("isValid" => true, "data" => $this->CartItemsTable->addCartItem($this->CartItems));
            } else {
                //get existing cart_id
                //save  cart_id,product_id and quantity in cart_items
                //else insert only in cart items
                //update the sub_total in cart
                $existingCart = get_object_vars($existingCart);
                $cartItemData['cart_id'] = $existingCart['cart_id'];
                $this->CartItems->exchangeArray($cartItemData);
                $addedCartItem = $this->CartItemsTable->addCartItem($this->CartItems);
                $totalAmount = $this->CartItemsTable->countCartTotalPriceByCartId($existingCart['cart_id']);
                $cartData['sub_total'] = $totalAmount;
                $cartData['total_amount'] = $totalAmount;
                $cartData['cart_id'] = $existingCart['cart_id'];
                $this->Cart->exchangeArray($cartData);
                $this->CartTable->updateCartById($this->Cart);
                return array("isValid" => true, "data" => $addedCartItem);
            }
        }
    }

}
