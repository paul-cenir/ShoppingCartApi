<?php

namespace CartApi\Controller;

use CartApi\Model\CartItemsTable;
use CartApi\Model\CartTable;
use CartApi\Service\CartService;
use Zend\Debug\Debug;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class CartController extends AbstractRestfulController
{
    //protected $eventIdentifier = 'SecuredController';

    private $CartTable;
    private $CartItemsTable;
    private $CartService;
    public function __construct(
        CartTable $CartTable,
        CartItemsTable $CartItemsTable,
        CartService $CartService
    ) {

        $this->CartTable = $CartTable;
        $this->CartItemsTable = $CartItemsTable;
        $this->CartService = $CartService;
    }

    public function create($data)
    {
        //get input in productId and quantity only
        //validate and sanitize
        //check if customer exist in Cart
        //insert in cart table and cart items
        //else insert only in cart items
        //return success
        $params = $this->params()->fromPost();
        $params['customer_id'] = 4;
        $addedCart = $this->CartService->addToCart($params);
        return new JsonModel($addedCart);
    }

    public function get($id)
    {
        return new JsonModel([]);
    }

    public function getList()
    {
        $cartTotal = $this->CartItemsTable->countCartTotalPriceByCartId(101);
        var_dump($cartTotal);
        exit;

        return new JsonModel([]);
    }

    public function update($id, $data)
    {

        \Zend\Debug\Debug::dump('update');
        exit;
    }

    public function delete($id)
    {
        \Zend\Debug\Debug::dump('delete');
        exit;
    }

}
