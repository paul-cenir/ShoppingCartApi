<?php

namespace CartApi\Controller;

use CartApi\Model\CartTable;
use CartApi\Model\CartItemsTable;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Zend\Debug\Debug;
use CartApi\Service\CartService;

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
        $params = $this->params()->fromPost();

        
        $addedCart = $this->CartService->addToCart($params);
     

        return new JsonModel($addedCart);
        //get input in productId and quantity only 
        //validate and sanitize
        //check if customer exist in Cart
        //insert in cart table and cart items
        //else insert only in cart items
        //return success

    }

    public function get($id)
    {
        return new JsonModel([]);
    }

    public function getList()
    {
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
