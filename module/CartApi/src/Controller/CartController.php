<?php

namespace CartApi\Controller;

use CartApi\Model\CartItemsTable;
use CartApi\Model\CartTable;
use CartApi\Service\CartService;
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
        $data['customer_id'] = 4;
        $addedCart = $this->CartService->addToCart($data);
        return new JsonModel($addedCart);
    }

    public function getList()
    {
        $cartTotal = $this->CartItemsTable->computeCartTotalPriceByCartId(101);
        var_dump($cartTotal);
        exit;

        return new JsonModel([]);
    }

}
