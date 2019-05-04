<?php

namespace CartApi\Controller;

use CartApi\Model\CartItemsTable;
use CartApi\Model\CartTable;
use CartApi\Service\CartService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Zend\Mvc\MvcEvent;


class CartController extends AbstractRestfulController
{
    // protected $eventIdentifier = 'SecuredController';

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
        $accessToken = $this->getRequest()->getHeader('Authorization');
        $addedCart = $this->CartService->addToCart($data,$accessToken);
        return new JsonModel($addedCart);
    }

    public function get($id)
    {
        //validation and sanitization
        $student_one = array(
            "cartItemData" => $this->CartItemsTable->getCartItemById($id),
            "cartData" => $this->CartTable->getCartByCartId($id),
        );
        return new JsonModel($student_one);
    }
}
